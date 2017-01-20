<?php
namespace com\efe13\mvc\dao\api\impl\util;

require_once( dirname( dirname( dirname( dirname(__DIR__) ) ) ) . '/commons/api/util/Utils.php' );
require_once( 'SessionFactory.php' );
require_once( 'Mapping.php' );
require_once( 'ForeignKey.php' );

use com\efe13\mvc\commons\api\util\Utils;
use com\efe13\mvc\dao\api\impl\util\SessionFactory;
use com\efe13\mvc\dao\api\impl\util\Mapping;
use com\efe13\mvc\dao\api\impl\util\ForeignKey;

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
		$fullClassName = is_string($entity) ? $entity : get_class( $entity );
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

	public static function buildObject($entity, array $data, $aliases) {
		$classInstance = new $entity;
		$propertiesByAlias = Utils::groupDataByArrayIndex( array_keys( $data ) );

		echo '$data: <br><br>';
		print_r( $data );
		foreach ( $data as $method => $value ) {
			foreach( $propertiesByAlias as $alias => $properties ) {
				;
			}

			$aliasProperty = explode( '.', $method );
			$alias = $aliasProperty[ 0 ];
			$property = $aliasProperty[ 1 ];

			$id = substr( $property, strlen( $property ) - 2, 2 );
			$method = 'set' . (( strcasecmp( $id, 'id' ) == 0 ) ? $id : $property);

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
		$classFile = new \ReflectionClass($entity);
		$comments = $classFile->getDocComment();
		$lines = explode( '*', $comments );

		if( Utils::size( $lines ) <= 0 ) {
			return null;
		}

		$annotations = self::getAnnotations( $lines );
		if( Utils::size( $lines ) <= 0 ) {
			return null;
		}

		$mappedClass = new Mapping();
		foreach($annotations as $annotation) {
			$mappingClass = self::parseAnnotation( trim( $annotation ) );

			if( array_key_exists( 'table', $mappingClass ) ) {
				$mappedClass->setTable( $mappingClass['table']->name );
			}
			else if( array_key_exists( 'foreignkey', $mappingClass ) ) {
				foreach( $mappingClass['foreignkey'] as $foreignkey ) {
					$mappedClass->addForeignKey( new ForeignKey( $foreignkey->name, str_replace( '/', '\\', $foreignkey->entity ) ) );
				}
			}
		}

		return $mappedClass;
	}

	public static function getAnnotations(array $lines) {
		$annotations = array();
		$continueAnnotation = false;
		$partialAnnotation = '';

		foreach( $lines as $line ) {
			$line = trim( $line );
			if( strlen( $line ) <= 3 ) {
				continue;
			}

			if( preg_match( '/@[a-zA-Z]*/i', $line ) ) {
				$last2Chars = trim( substr( $line, strlen($line) - 2 ) );
				if( strcasecmp( $last2Chars, '})' ) == 0 ||
					strcasecmp( $last2Chars, '])' ) == 0 ) {
						$partialAnnotation = $line;
				}
				else if( strcasecmp( $last2Chars, '},' ) == 0 ) {
					$partialAnnotation = $line;
					$continueAnnotation = true;
					continue;
				}
			}
			else {
				$beginningChars = substr( $line, 0, 1 );
				if( $continueAnnotation && strcasecmp( $line, '{' ) ) {
					$partialAnnotation = $partialAnnotation . $line;
					$continueAnnotation = false;
				}
			}

			$annotations[] = $partialAnnotation;
		}

		return $annotations;
	}

	public static function parseAnnotation( $annotation ) {
		$annotationFound = stripos( $annotation, '@Table' );
		$annotationFound = $annotationFound === false ? stripos( $annotation, '@ForeignKey' ) : $annotationFound;
		if( $annotationFound === false ) {
			return null;
		}

		$annotationName = strtolower( trim( substr( $annotation, 1, strripos( $annotation, '(' ) - 1 ) ) );
		switch($annotationName) {
			case 'table':
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
		$json = str_replace( '\\', '/', $json );
		$json = json_decode( $json );

		return $json;
	}
}
?>