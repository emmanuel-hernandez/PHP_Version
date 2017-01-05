<?php
namespace com\efe13\mvc\model\api\impl\helper;

class FilterAPI {

	private $filter;

	public function getFilter() {
		return $this->filter;
	}

	public function setFilter(array $filter) {
		$this->filter = $filter;
	}
}
?>