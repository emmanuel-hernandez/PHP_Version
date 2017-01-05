<?php
namespace com\efe13\mvc\model\api\impl\helper;

class OrderAPI {

	private $field;
	private $ascending;

	public function getField() {
		return $this->field;
	}

	public function setField(string $field) {
		$this->field = $field;
	}

	public function isAscending() {
		return $this->ascending;
	}

	public function setAscending(boolean $ascending) {
		$this->ascending = $ascending;
	}
}
?>