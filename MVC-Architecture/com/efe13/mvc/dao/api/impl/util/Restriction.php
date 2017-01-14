<?php
namespace com\efe13\mvc\dao\api\impl\util;

class Restriction {
	private $field;
	private $eqOperator;
	private $value;

	public function __construct($field, $eqOperator, $value) {
		$this->field = $field;
		$this->eqOperator = $eqOperator;
		$this->value = $value;
	}

	public function setField($field) {
		$this->field = $field;
	}

	public function getField() {
		return $this->field;
	}

	public function setEqOperator($eqOperator) {
		$this->eqOperator = $eqOperator;
	}

	public function getEqOperator() {
		return $this->eqOperator;
	}

	public function setValue($value) {
		$this->value = $value;
	}

	public function getValue() {
		return $this->value;
	}
}
?>