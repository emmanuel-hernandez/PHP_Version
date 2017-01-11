<?php
namespace com\efe13\tdt\model\dto;


require_once( getMVCPath( DTO_API_PATH ) );
require_once( getAppPath( STATE_DTO_PATH ) );

use com\efe13\tdt\model\dto\StateDTO;
use com\efe13\mvc\model\api\impl\dto\DTOAPI;

class PopulationDTO extends DTOAPI {

	private $id;
	private $name;
	private $active;
	
	//@JsonIgnoreProperties("populations")
	private $state;
	
	//@Override
	public function getId() {
		return $this->id;
	}
	
	//@Override
	public function setId($id) {
		$this->id = $id;
	}
	
	public function getName() {
		return $this->name;
	}
	
	public function setName($name) {
		$this->name = $name;
	}
	
	//@Override
	public function isActive() {
		return $this->active;
	}

	//@Override
	public function setActive($active) {
		$this->active = $active;
	}

	public function getState() {
		if( $this->state == null ) {
			$this->state = new StateDTO();
		}

		return $this->state;
	}

	public function setState(StateDTO $state) {
		$this->state = $state;
	}
}
?>