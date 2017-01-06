<?php
namespace com\efe13\tdt\helper;

use com\efe13\mvc\model\api\impl\helper\FilterAPI;
use com\efe13\mvc\model\api\impl\helper\PaginationAPI;

class ServiceRequest {
	
	private $paginationDTO;
	private $filterDTO;
	
	public function getPaginationDTO() {
		return paginationDTO;
	}
	
	public function setPaginationDTO(PaginationAPI $paginationDTO) {
		$this->paginationDTO = $paginationDTO;
	}
	
	public function getFilterDTO() {
		return $this->filterDTO;
	}
	
	public function setFilterDTO(FilterAPI $filterDTO) {
		$this->filterDTO = $filterDTO;
	}
}
?>