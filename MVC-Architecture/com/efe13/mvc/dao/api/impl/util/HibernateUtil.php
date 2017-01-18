<?php
namespace com\efe13\mvc\dao\api\impl\util;

require_once( 'SessionFactory.php' );
require_once( dirname( dirname( dirname( dirname(__DIR__) ) ) ) . '/commons/api/util/Utils.php' );

use com\efe13\mvc\commons\api\util\Utils;
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

	public static function getClassName($entity) {
		$fullClassName = get_class( $entity );
		$lastBackSlashPos = strripos( $fullClassName, '\\' ) + 1;
		$className = substr( $fullClassName, $lastBackSlashPos, strlen( $fullClassName ) );

		return $className;
	}

	public static function getPropertiesClass($entity) {
		$methods = self::getClassMethods( $entity );
		$properties = array();

		if( empty( $methods ) ) {
			return array();
		}

		foreach( $methods as $method ) {
			$prefix = substr( $method, 0, 3 );

			if( strcasecmp( $prefix, 'set' ) == 0  ) {
				$property = strtolower( substr( $method, 3, strlen( $method ) ) );

				if( strcasecmp( $property, 'id' ) == 0 ) {
					$property = self::getClassName( $entity ) . ucfirst( $property );
				}
				else {
					$get = 'get' . $property;
					if( method_exists( $entity, $get ) ) {
						$data = $entity->$get();
						$property = is_object( $data ) ? self::getColumnIdName( $data ) : $property;
					}
				}

				$properties[] = $property;
			}
		}

		return $properties;
	}

	public static function getPropertiesClassWithOutIdProperty($entity) {
		$properties = self::getPropertiesClass( $entity );
		$columnIdName = self::getColumnIdName( $entity );

		$newProperties = array();
		foreach( $properties as $property ) {
			if( strcasecmp( $property, $columnIdName ) != 0 ) {
				$property = is_object( $property ) ? self::getColumnIdName( $property ) : $property;
				$newProperties[] = $property;
			}
		}

		return $newProperties;
	}

	public static function getPropertiesClassValuesWithOutIdProperty($entity, $object) {
		$properties = self::getPropertiesClass( $entity );
		$columnIdName = self::getColumnIdName( $entity );

		$values = array();
		$hasInnerValue = false;
		foreach( $properties as $property ) {
			$hasInnerValue = false;

			if( strcasecmp( $property, $columnIdName ) != 0 ) {
				$getMethod = 'get' . $property;

				if( !method_exists( $object, $getMethod ) ) {
					$getMethod = substr( $getMethod, 0, strlen($getMethod) - 2 );
					if( method_exists( $object, $getMethod ) ) {
						$value = self::getIdPropertieValue( $object->$getMethod() );
						$hasInnerValue = true;
					}
					else {
						$getMethod = 'is' . $property;
						if( !method_exists( $object, $getMethod ) ) {
							continue;
						}
					}
				}

				if( !$hasInnerValue ) {
					$value = $object->$getMethod();
					if( is_bool( $value ) ) {
						$value = $value ? 1 : 0;	
					}
				}

				$values[] =  $value;
			}
		}

		return $values;
	}

	public static function getIdPropertieValue($entity) {
		$getMethod = 'getId';
		if( method_exists( $entity, $getMethod ) ) {
			return $entity->$getMethod();
		}
		
		return null;
	}

	public static function buildObject($entity, array $data) {
		$classInstance = new $entity;

		foreach ( $data as $method => $value ) {
			$aliasProperty = explode( '.', $method );
			$id = substr( $aliasProperty[1], strlen( $aliasProperty[1] ) - 2, 2 );
			$method = 'set' . (( strcasecmp( $id, 'id' ) == 0 ) ? $id : $aliasProperty[1]);

			$classInstance->$method( $value );
		}

		return $classInstance;
	}

	public static function getColumnIdName($entity) {
		$methods = self::getClassMethods( $entity );

		if( empty( $methods ) ) {
			return null;
		}

		foreach( $methods as $method ) {
			$prefix = substr( $method, 0, 3 );

			if( strcasecmp( $prefix, 'set' ) == 0  ) {
				$property = strtolower( substr( $method, 3, strlen( $method ) ) );

				if( strcasecmp( $property, 'id' ) == 0 ) {
					return self::getClassName( $entity ) . ucfirst( $property );
				}
			}
		}
	}

	public static function getRelationshipColumnId($entity, $entityRelationShip) {
		$method = 'get' . $entityRelationShip;

		if( !method_exists( $entity, $method ) ) {
			return false;
		}

		$relationship = $entity->$method();
		return self::getColumnIdName( $relationship );
	}

	private static function getClassMethods($entity) {
		return get_class_methods( $entity );
	}

	//Reflection API functions
	public static function getMapping($entity) {
		$reflection = new \ReflectionClass($entity);
		$definitions = $reflection->getDocComment();
		$pattern = '#(@[a-zA-Z]+\s*[a-zA-Z0-9, ()_].*)#';
		preg_match_all( $pattern, $definitions, $matches, PREG_PATTERN_ORDER );

		echo '<br><br>';
		if( Utils::size( $matches ) <= 0 ) {
			return null;
		}

		if( Utils::size( $matches[0] ) <= 0 ) {
			return null;
		}

		$annotations = array();
		foreach($matches[0] as $match) {
			$annotations[] = self::parseAnnotation( trim( $match ) );
		}

		print_r( $annotations );
		die('<br><br>jejej');
	}

	public static function parseAnnotation( $annotation ) {
		$annotationName = substr( $annotation, 1, strripos( $annotation, '(' ) - 1 );
		$annotationName = strtolower( trim( $annotationName ) );

		switch($annotationName) {
			case 'table': //attrs for this annotations name
				return array( 'table' => self::getJsonFromAnnotation( $annotation ) );
			break;
			case 'foreignkey':
				return array( 'foreignkey' => self::getJsonFromAnnotation( $annotation ) );
			break;
		}
	}

	private function getJsonFromAnnotation($annotation) {
		$json = substr( $annotation, strripos( $annotation, '(' ) );
		$json = substr( $json, 1, strlen( $json ) - 2 );

		echo 'json: ' . $json . '<br><br>';
		$json = json_decode( $json );

		return $json;
	}
}
?>