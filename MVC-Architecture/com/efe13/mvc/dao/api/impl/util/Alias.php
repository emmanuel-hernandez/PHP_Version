<?php
namespace com\efe13\mvc\dao\api\impl\util;

class Alias {
	private $entity;
	private $alias;
	private $joinType;

	public function __construct($entity, $alias, $joinType) {
		$this->entity = $entity;
		$this->alias = $alias;
		$this->joinType = $joinType;
	}

	public function setEntity($entity) {
		$this->entity = $entity;
	}

	public function getEntity() {
		return $this->entity;
	}

	public function setAlias($alias) {
		$this->alias = $alias;
	}

	public function getAlias() {
		return $this->alias;
	}

	public function setJoinType($joinType) {
		$this->joinType = $joinType;
	}

	public function getJoinType() {
		return $this->joinType;
	}
}
?>