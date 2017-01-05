<?php
namespace com\efe13\mvc\model\api\impl\helper;

class PaginationAPI {

	private $page;
	private $pageSize;
	private $total;
	private $totalPage;
	
	public function getPage() {
		return $this->page;
	}
	
	public function setPage(int $page) {
		$this->page = $page;
	}
	
	public function getPageSize() {
		return $this->pageSize;
	}
	
	public function setPageSize(int $pageSize) {
		$this->pageSize = $pageSize;
	}
	
	public function getTotal() {
		return $this->total;
	}
	
	public function setTotal(int $total) {
		$this->total = $total;
	}

	public function getTotalPage() {
		return $this->totalPage;
	}

	public function setTotalPage(int $totalPage) {
		$this->totalPage = $totalPage;
	}
}
?>