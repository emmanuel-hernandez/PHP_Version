<?php
namespace com\efe13\mvc\dao\api\impl\util;

require_once( 'SessionFactory.php' );

use com\efe13\mvc\dao\api\impl\util\SessionFactory;

class HibernateUtil {

	private static $instance = null;
	private static $sessionFactory;

	private function __construct() {
		try {
			self::$sessionFactory = new SessionFactory( 'root', 'admin', 'localhost', 'tdt' );
		}
		catch( DAOException $ex ) {
			throw new DAOException( $ex->getMessage() );
		}
	}

	public static function getInstance() {
        if( self::$instance == null ) {
            self::$instance = new HibernateUtil();
        }
		
        return self::$instance;
	}

	public static function getSessionFactory() {
        self::getInstance();

		return HibernateUtil::$sessionFactory;
	}

	public static function getClassName($clazz) {
		$fullClassName = get_class( $clazz );
		$lastBackSlashPos = strripos( $fullClassName, '\\' ) + 1;
		$className = substr( $fullClassName, $lastBackSlashPos, strlen( $fullClassName ) );

		return $className;
	}

	public static function getPropertiesClass($clazz) {
		$publicMethods = self::getClassMethods( $clazz );
		$properties = array();

		if( empty( $publicMethods ) ) {
			return array();
		}

		foreach( $publicMethods as $method ) {
			$prefix = substr( $method, 0, 3 );

			if( strcasecmp( $prefix, 'set' ) == 0  ) {
				$property = strtolower( substr( $method, 3, strlen( $method ) ) );

				if( strcasecmp( $property, 'id' ) == 0 ) {
					$prop = self::getClassName( $clazz ) . ucfirst( $property );
					$property = is_object( $prop ) ? self::getColumnIdName( $prop ) : $prop;
				}

				$properties[] = $property;
			}
		}

		return $properties;
	}

	public static function getPropertiesClassWithOutIdProperty($clazz) {
		$properties = self::getPropertiesClass( $clazz );
		$columnIdName = self::getColumnIdName( $clazz );

		$newProperties = array();
		foreach( $properties as $property ) {
			if( strcasecmp( $property, $columnIdName ) != 0 ) {
				$newProperties[] = $property;
			}
		}

		return $newProperties;
	}

	public static function getPropertiesClassValuesWithOutIdProperty($clazz, $object) {
		$properties = self::getPropertiesClass( $clazz );
		$columnIdName = self::getColumnIdName( $clazz );

		$values = array();
		foreach( $properties as $property ) {
			if( strcasecmp( $property, $columnIdName ) != 0 ) {
				$getMethod = 'get' . $property;

				if( !method_exists( $clazz, $getMethod ) ) {
					$getMethod = 'is' . $property;
					if( !method_exists( $clazz, $getMethod ) ) {
						continue;
					}
				}

				$value = $object->$getMethod();
				if( is_bool( $value ) ) {
					$value = $value ? 1 : 0;	
				}

				$values[] =  $value;
			}
		}

		return $values;
	}

	public static function buildObject($clazz, array $data) {
		$classInstance = new $clazz;

		foreach ( $data as $method => $value ) {
			$id = substr( $method, strlen( $method ) - 2, 2 );
			$method = 'set' . (( strcasecmp( $id, 'id' ) == 0 ) ? $id : $method);

			$classInstance->$method( $value );
		}

		return $classInstance;
	}

	public static function getColumnIdName($clazz) {
		$methods = self::getClassMethods( $clazz );

		if( empty( $methods ) ) {
			return null;
		}

		foreach( $methods as $method ) {
			$prefix = substr( $method, 0, 3 );

			if( strcasecmp( $prefix, 'set' ) == 0  ) {
				$property = strtolower( substr( $method, 3, strlen( $method ) ) );

				if( strcasecmp( $property, 'id' ) == 0 ) {
					return self::getClassName( $clazz ) . ucfirst( $property );
				}
			}
		}
	}

	private static function getClassMethods($clazz) {
		return get_class_methods( $clazz );
	}
}
?>