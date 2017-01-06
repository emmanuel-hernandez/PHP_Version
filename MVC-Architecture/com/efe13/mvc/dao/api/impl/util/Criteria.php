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

	public function list() {
		$r = array();
		$r[] = array( 'id' => 1,
				 'name' => 'TDT',
				 'description' => 'Televisón Digital',
				 'active' => true );

		return $r;
	}

	private function getQuery() {
		$query = sprintf( '%s', 'hola' );

		return $query;
	}
}
?>