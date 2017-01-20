<?php
namespace com\efe13\mvc\dao\api\impl\util;

class ForeignKey {
	private $property;
	private $entity;

	public function __construct($property, $entity) {
		$this->property = $property;
		$this->entity = $entity;
	}

	public function setProperty($property) {
		$this->property = $property;
	}

	public function getProperty() {
		return $this->property;
	}

	public function setEntity($entity) {
		$this->entity = $entity;
	}

	public function getEntity() {
		return $this->entity;
	}
}
?>