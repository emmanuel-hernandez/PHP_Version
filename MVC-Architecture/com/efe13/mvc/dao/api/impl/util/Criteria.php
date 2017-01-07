<?php
namespace com\efe13\mvc\dao\api\impl\util;

require_once( dirname( dirname( dirname( dirname(__DIR__) ) ) ) . '/commons/api/util/Utils.php' );

use com\efe13\mvc\commons\api\util\Utils;

final class Criteria {
	
	private $sessionFactory;
	private $clazz;
	private $sql;
	private $restrictions;

	public function __construct($sessionFactory) {
		$this->sessionFactory = $sessionFactory;

		$this->clazz = null;
		$this->sql = null;
		$this->restrictions = null;
	}

	public function createCriteria($clazz) {
		$this->clazz = $clazz;

		return $this;
	}

	public function add($restriction) {
		if( Utils::isEmpty( $this->restrictions ) ) {
			$this->restrictions = 'WHERE ' . $restriction;
		}
		else {
			$this->restrictions .= $restriction;
		}

		return $this;
	}

	public function lisst() {
		$objects = null;
		$this->sql = sprintf( 'SELECT %s FROM %s', 
							  implode( $this->getPropertiesClass(), ', ' ),
							  strtolower( $this->getClassName() ) );

		$result = $this->sessionFactory->query( $this->sql );
		if( $result === false ) {
			echo $this->sessionFactory->error;
		}
		else {
			while( $row = $result->fetch_array( MYSQLI_ASSOC ) ) {
				$objects[] = $this->buildObject( $row );
			}
		}

		return $objects;
	}

	private function getQuery() {
		$query = sprintf( '%s', 'hola' );

		return $query;
	}

	private function getClassName() {
		$fullClassName = get_class( $this->clazz );
		$lastBackSlashPos = strripos( $fullClassName, '\\' ) + 1;
		$className = substr( $fullClassName, $lastBackSlashPos, strlen( $fullClassName ) );
		
		return $className;
	}

	private function getPropertiesClass() {
		$publicMethods = get_class_methods( $this->clazz );
		$properties = array();

		if( empty( $publicMethods ) ) {
			return array();
		}

		foreach( $publicMethods as $method ) {
			$prefix = substr( $method, 0, 3 );

			if( strcasecmp( $prefix, 'set' ) == 0  ) {
				$property = strtolower( substr( $method, 3, strlen( $method ) ) );

				if( strcasecmp( $property, 'id' ) == 0 ) {
					$property = $this->getClassName() . $property;
				}

				$properties[] = $property;
			}
		}

		return $properties;
	}

	private function buildObject(array $data) {
		$classInstance = new $this->clazz;

		foreach ( $data as $method => $value ) {
			$id = substr( $method, strlen( $method ) - 2, 2 );
			$method = 'set' . (( strcasecmp( $id, 'id' ) == 0 ) ? $id : $method);

			$classInstance->$method( $value );
		}

		return $classInstance;
	}
}
?>