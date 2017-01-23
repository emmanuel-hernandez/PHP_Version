<?php
namespace com\efe13\mvc\dao\api\impl\util;

require_once( dirname( dirname( dirname( dirname(__DIR__) ) ) ) . '/commons/api/util/Utils.php' );
require_once( 'ForeignKey.php' );

use com\efe13\mvc\commons\api\util\Utils;
use com\efe13\mvc\dao\api\impl\util\ForeignKey;

class Mapping {
	private $table;
	private $idColumn;
	private $foreignKeys;

	public function __construct() {
		$this->table = null;
		$this->foreignKeys = null;
		$this->idColumn = null;
	}

	public function setTable($table) {
		$this->table = $table;
	}

	public function getTable() {
		return $this->table;
	}

	public function setIdColumn($idColumn) {
		$this->idColumn = $idColumn;
	}

	public function getIdColumn() {
		return $this->idColumn;
	}

	public function setForeignKeys($foreignKeys) {
		$this->foreignKeys = $foreignKeys;
	}	

	public function getForeignKeys() {
		return $this->foreignKeys;
	}

	public function addForeignKey(ForeignKey $foreignKey) {
		if( $this->getForeignKeys() == null ) {
			$this->foreignKeys = array();
		}

		$this->foreignKeys[] = $foreignKey;
	}

	public function getForeignKeyByRelationshipId($relationshipId) {
		foreach( $this->foreignKeys as $foreignKey ) {
			if( Utils::areEquals( $foreignKey->getRelationshipId(), $relationshipId ) ) {
				return $foreignKey;
			}
		}

		return null;
	}
}
?>