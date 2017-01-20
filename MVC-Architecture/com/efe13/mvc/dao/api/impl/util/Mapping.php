<?php
namespace com\efe13\mvc\dao\api\impl\util;

require_once( 'ForeignKey.php' );

use com\efe13\mvc\dao\api\impl\util\ForeignKey;

class Mapping {
	private $table;
	private $foreignKeys;

	public function __construct() {
		$this->table = null;
		$this->foreignKeys = null;
	}

	public function setTable($table) {
		$this->table = $table;
	}

	public function getTable() {
		return $this->table;
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

	public function getForeignKeyByProperty($property) {
		foreach( $this->foreignKeys as $foreignKey ) {
			if( strcasecmp( $foreignKey->getProperty(), $property ) == 0 ) {
				return $foreignKey;
			}
		}

		return null;
	}
}
?>