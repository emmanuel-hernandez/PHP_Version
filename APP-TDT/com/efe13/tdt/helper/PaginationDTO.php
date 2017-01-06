<?php
namespace com\efe13\tdt\helper;

class PaginationDTO {

	private $page;
	private $pageSize;
	private $total;

	public function getPage() {
		return $this->page;
	}

	public function setPage($page) {
		$this->page = $page;
	}
	
	public function getPageSize() {
		return $this->pageSize;
	}
	
	public function setPageSize($pageSize) {
		$this->pageSize = $pageSize;
	}

	public function getTotal() {
		return $this->total;
	}

	public function setTotal($total) {
		$this->total = $total;
	}	
}
?>