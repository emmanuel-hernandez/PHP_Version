<?php
namespace com\efe13\mvc\dao\api\impl\util;

class ForeignKey {
	private $property;
	private $entity;
	private $relationshipId;

	public function __construct($property, $entity, $relationshipId) {
		$this->property = $property;
		$this->entity = $entity;
		$this->relationshipId = $relationshipId;
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

	public function setRelationshipId($relationshipId) {
		$this->relationshipId = $relationshipId;
	}

	public function getRelationshipId() {
		return $this->relationshipId;
	}
}
?>