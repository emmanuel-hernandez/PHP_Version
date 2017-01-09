<?php
namespace com\efe13\mvc\dao\api\impl\util;

require_once( dirname( dirname( dirname( dirname(__DIR__) ) ) ) . '/commons/api/util/Utils.php' );
require_once( dirname( dirname( dirname( dirname(__DIR__) ) ) ) . '/commons/api/exception/HibernateException.php' );
require_once( 'HibernateUtil.php' );

use com\efe13\mvc\commons\api\util\Utils;
use com\efe13\mvc\commons\api\exception\HibernateException;
use com\efe13\mvc\dao\api\impl\util\HibernateUtil;

final class Criteria {
	
	private $sessionFactory;
	private $clazz;
	private $sql;
	private $restrictions;

	private static $IS_INSERT = true;

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
		$this->restrictions = sprintf( '%s %s', $this->getRestrictions(), $restriction );

		return $this;
	}

	public function listAll() {
		$objects = null;
		$this->sql = sprintf( 'SELECT %s FROM %s', 
							  implode( HibernateUtil::getPropertiesClass( $this->clazz ), ', ' ),
							  strtolower( HibernateUtil::getClassName( $this->clazz ) ) );

		$result = $this->execute();
		while( $row = $result->fetch_array( MYSQLI_ASSOC ) ) {
			$objects[] = HibernateUtil::buildObject( $this->clazz, $row );
		}

		return $objects;
	}

	public function uniqueResult() {
		$this->sql = sprintf( 'SELECT %s FROM %s',
							  implode( HibernateUtil::getPropertiesClass( $this->clazz ), ', ' ),
							  strtolower( HibernateUtil::getClassName( $this->clazz ) ) );

		if( !Utils::isNull( $this->restrictions != null ) ) {
			$this->sql = sprintf( '%s %s', $this->sql, $this->getRestrictions() );
		}

		$result = $this->execute();
		if( $result->num_rows == 0 ) {
			return null;
		}
		else if( $result->num_rows > 1 ) {
			throw new HibernateException( 'Result set is not a unique result' );
		}

		return HibernateUtil::buildObject( $this->clazz, $result->fetch_array( MYSQLI_ASSOC ) );
	}

	public function save($object) {
		$propertiesValues = HibernateUtil::getPropertiesClassValuesWithOutIdProperty( $this->clazz, $object );
		for( $i=0; $i<count( $propertiesValues ); $i++ ) {
			if( is_string( $propertiesValues[ $i ] ) ) {
				$propertiesValues[ $i ] = sprintf( "'%s'", $propertiesValues[ $i ] );
			}
		}

		$this->sql = sprintf( 'INSERT INTO %s(%s) VALUES(%s)',
							  strtolower( HibernateUtil::getClassName( $this->clazz ) ),
							  implode( HibernateUtil::getPropertiesClassWithOutIdProperty( $this->clazz ), ', ' ),
							  implode( $propertiesValues, ', ' ) );

		return ( $this->execute( self::$IS_INSERT ) );
	}

	public function update($object) {
		$propertiesValues = HibernateUtil::getPropertiesClassValuesWithOutIdProperty( $this->clazz, $object );
		$properties = HibernateUtil::getPropertiesClassWithOutIdProperty( $this->clazz );

		for( $i=0; $i<count( $properties ); $i++ ) {
			$propertiesValues[ $i ] = is_string( $propertiesValues[ $i ] ) ?
									  sprintf( "%s = '%s'", $properties[ $i ], $propertiesValues[ $i ] ) :
									  sprintf( "%s = %s", $properties[ $i ], $propertiesValues[ $i ] );
		}

		$columnIdName = HibernateUtil::getColumnIdName( $this->clazz );
		$getColumnIdName = 'getId';
		$this->sql = sprintf( 'UPDATE %s SET %s WHERE %s = %d',
							  strtolower( HibernateUtil::getClassName( $this->clazz ) ),
							  implode( $propertiesValues, ', ' ),
							  $columnIdName,
							  $object->$getColumnIdName() );

		return ( $this->execute() );
	}

	private function getRestrictions() {
		if( !isset( $this->restrictions ) ) {
			$this->restrictions = 'WHERE ';
		}

		return $this->restrictions;
	}

	private function execute( $is_insert = false ) {
		$result = $this->sessionFactory->query( $this->sql );

		if( $result === false ) {
			throw new HibernateException( $this->sessionFactory->error );
		}

		if( $is_insert ) {
			$result = $this->sessionFactory->insert_id;
		}

		return $result;
	}
}
?>