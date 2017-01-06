<?php
namespace com\efe13\tdt\helper;

class FilterDTO {

	private $fields;

	public function getFields() {
		return $this->fields;
	}

	public function setFields(array $fields) {
		$this->fields = $fields;
	}
}
?>