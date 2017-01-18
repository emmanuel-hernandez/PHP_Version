<?php
namespace com\efe13\mvc\dao\api\impl\util;

require_once( dirname( dirname( dirname( dirname(__DIR__) ) ) ) . '/commons/api/util/Utils.php' );
require_once( dirname( dirname( dirname( dirname(__DIR__) ) ) ) . '/commons/api/exception/HibernateException.php' );
require_once( 'HibernateUtil.php' );
require_once( 'Alias.php' );

use com\efe13\mvc\commons\api\util\Utils;
use com\efe13\mvc\commons\api\exception\HibernateException;
use com\efe13\mvc\dao\api\impl\util\HibernateUtil;
use com\efe13\mvc\dao\api\impl\util\Alias;

final class Criteria {
	
	private $sessionFactory;
	private $entity;
	private $sql;
	private $restrictions;
	private $projection;
	private $aliases;

	private static $IS_INSERT = true;
	private static $IS_NOT_INSERT = false;
	private static $IS_UPDATE = true;

	public function __construct($sessionFactory) {
		$this->sessionFactory = $sessionFactory;

		$this->entity = null;
		$this->sql = null;
		$this->restrictions = null;
		$this->projections = null;
		$this->aliases = null;
		$this->entityAlias = null;
	}

	public function createCriteria($entity, $tableAlias = null) {
		$this->entity = $entity;
		$this->entityAlias = $tableAlias;

		return $this;
	}

	public function add($restriction) {
		if( Utils::isEmpty( $this->restrictions ) ) {
			$this->restrictions = array();
		}

		$this->restrictions[] = $restriction;
		return $this;
	}

	public function setProjection($projection) {
		$this->projection = $projection;

		return $this;
	}

	public function createAlias($entity, $alias, $joinType) {
		if( Utils::isNull( $this->aliases ) ) {
			$this->aliases = array();
		}

		$this->aliases[ $alias ] = new Alias( $entity, $alias, $joinType );
		return $this;
	}

	public function listAll() {
		$objects = null;
		$this->sql = sprintf( 'SELECT %s FROM %s', 
							  $this->getProjection(),
							  $this->getAliases() );

		$result = $this->execute();
		while( $row = $result->fetch_array( MYSQLI_ASSOC ) ) {
			$objects[] = HibernateUtil::buildObject( $this->entity, $row );
		}

		return $objects;
	}

	public function uniqueResult() {
		$result = $this->execute();

		if( $result->num_rows == 0 ) {
			return null;
		}
		else if( $result->num_rows > 1 ) {
			throw new HibernateException( 'Result set is not a unique result' );
		}

		$projections = array();
		$projections = explode( ',', $this->getProjection() );
		if( count( $projections ) > 1 ) {
			return HibernateUtil::buildObject( $this->entity, $result->fetch_array( MYSQLI_ASSOC ) );
		}
		else {
			$reg = $result->fetch_array( MYSQLI_ASSOC );
			foreach( $reg as $key => $value ) {
				return $value;
			}
		}
	}

	public function save($object) {
		$propertiesValues = HibernateUtil::getPropertiesClassValuesWithOutIdProperty( $this->entity, $object );

		for( $i=0; $i<count( $propertiesValues ); $i++ ) {
			if( is_string( $propertiesValues[ $i ] ) ) {
				$propertiesValues[ $i ] = sprintf( "'%s'", $propertiesValues[ $i ] );
			}
		}

		$this->sql = sprintf( 'INSERT INTO %s(%s) VALUES(%s)',
							  strtolower( HibernateUtil::getClassName( $this->entity ) ),
							  implode( HibernateUtil::getPropertiesClassWithOutIdProperty( $this->entity ), ', ' ),
							  implode( $propertiesValues, ', ' ) );

		return ( $this->execute( self::$IS_INSERT ) );
	}

	public function update($object) {
		$propertiesValues = HibernateUtil::getPropertiesClassValuesWithOutIdProperty( $this->entity, $object );
		$properties = HibernateUtil::getPropertiesClassWithOutIdProperty( $this->entity );

		for( $i=0; $i<count( $properties ); $i++ ) {
			if( Utils::isNull( $propertiesValues[ $i ] ) ) {
				array_splice( $propertiesValues, $i, 1);
				continue;
			}

			$propertiesValues[ $i ] = is_string( $propertiesValues[ $i ] ) ?
									  sprintf( "%s = '%s'", $properties[ $i ], $propertiesValues[ $i ] ) :
									  sprintf( "%s = %s", $properties[ $i ], $propertiesValues[ $i ] );
		}

		$columnIdName = HibernateUtil::getColumnIdName( $this->entity );
		$getColumnIdName = 'getId';
		$this->sql = sprintf( 'UPDATE %s SET %s WHERE %s = %d',
							  strtolower( HibernateUtil::getClassName( $this->entity ) ),
							  implode( $propertiesValues, ', ' ),
							  $columnIdName,
							  $object->$getColumnIdName() );

		return ( $this->execute( self::$IS_NOT_INSERT, self::$IS_UPDATE ) );
	}

	private function getProjection() {
		HibernateUtil::getMapping( get_class($this->entity) );
		$projection = '';

		if( !Utils::isNull( $this->projection ) ) {
			$projection = $this->projection;
		}
		else {
			$projection = implode( HibernateUtil::getPropertiesClass( $this->entity ), ', ' );
		}

		$fields = explode( ', ', $projection );
		if( !Utils::isEmpty( $fields ) ) {
			$projections = array();
			foreach( $fields as $field ) {
				if( !Utils::contains( $field, '.' ) ) {
					echo '<br><br>$field: ' . $field;
					$definition = $this->entityAlias . '.' . $field;
					$projections[] = sprintf( '%s AS "%s"', $definition, $definition );
				}
			}

			$projection = implode( ', ', $projections );
		}

		return $projection;
	}

	private function getAliases() {
		$aliases = sprintf( '%s %s', strtolower( HibernateUtil::getClassName( $this->entity ) ), $this->entityAlias );
		if( !Utils::isEmpty( $this->aliases ) ) {
			foreach( $this->aliases as $alias ) {
				$aliases .= sprintf( ' %s %s %s ON %s = %s', $alias->getJoinType(),
														 $alias->getEntity(),
														 $alias->getAlias(),
														 $this->entityAlias . '.' . HibernateUtil::getRelationshipColumnId( $this->entity, $alias->getEntity() ),
														 $alias->getAlias() .'.' . HibernateUtil::getRelationshipColumnId( $this->entity, $alias->getEntity() ) );
			}
		}

		return $aliases;
	}

	private function getRestrictions() {
		if( Utils::isEmpty( $this->restrictions ) ) {
			return '';
		}

		if( !Utils::isEmpty( $this->aliases ) ) {
			for( $i=0; $i<Utils::size( $this->restrictions ); $i++ ) {

				$restriction = $this->restrictions[ $i ];
				if( Utils::contains( $restriction->getField(), '.' ) ) {

					$aliasProperty = explode( '.', $restriction->getField() );
					if( array_key_exists( $aliasProperty[0], $this->aliases ) ) {

						$aliasProperty[1] = HibernateUtil::getRelationshipColumnId( $this->entity, $this->aliases[ $aliasProperty[0] ]->getEntity() );
						if( !Utils::isNull( $aliasProperty[1] ) ) {
							$this->restrictions[ $i ]->setField( implode( '.', $aliasProperty ) );
						}
					}
				}
			}
		}

		$restrictions = array();
		foreach( $this->restrictions as $restriction ) {
			$restrictions[] = sprintf( '%s %s %s', $restriction->getField(),
			 									 $restriction->getEqOperator(),
			 									 $restriction->getValue() );
		}
		
		$restrictions = 'WHERE ' . implode( ' AND ', $restrictions );	
		return $restrictions;
	}

	private function getSQL() {
		$sql = sprintf( 'SELECT %s
						 FROM %s
						 %s',
						$this->getProjection(),
					  	$this->getAliases(),
					  	$this->getRestrictions() );

		return $sql;
	}

	private function execute( $is_insert = false, $is_update = false ) {
		$this->sql = $is_insert || $is_update ? $this->sql : $this->getSQL();
		echo( $this->sql . '<br><br>');
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