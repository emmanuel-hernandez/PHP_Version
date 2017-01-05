<?php
namespace com\efe13\mvc\model\api\impl\helper;

class QueryHelper {

	private $paginationAPI;
	private $filterAPI;
	private $orderAPI;
	
	public function getPaginationAPI() {
		return $this->paginationAPI;
	}
	
	public function setPaginationAPI(PaginationAPI $paginationAPI) {
		$this->paginationAPI = $paginationAPI;
	}
	
	public function getFilterAPI() {
		return $this->filterAPI;
	}
	
	public function setFilterAPI(FilterAPI $filterAPI) {
		$this->filterAPI = $filterAPI;
	}

	public function getOrderAPI() {
		return $this->orderAPI;
	}

	public function setOrderAPI(OrderAPI $orderAPI) {
		$this->orderAPI = $orderAPI;
	}
}
?>