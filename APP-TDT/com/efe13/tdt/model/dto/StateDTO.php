<?php
namespace com\efe13\tdt\model\dto;

require_once( getMVCPath( DTO_API_PATH ) );

use com\efe13\mvc\model\api\impl\dto\DTOAPI;

class StateDTO extends DTOAPI {
	
	private $id;
	private $name;
	private $shortName;
	private $active;
	//private Set<PopulationDTO> populations = new HashSet<>();

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

	public function getShortName() {
		return $this->shortName;
	}

	public function setShortName($shortName) {
		$this->shortName = $shortName;
	}
/*
	public Set<PopulationDTO> getPopulations() {
		return populations;
	}

	public void setPopulations(Set<PopulationDTO> populations) {
		$this->populations = populations;
	}
*/
	//@Override
	public function isActive() {
		return $this->active;
	}

	//@Override
	public function setActive($active) {
		$this->active = $active;
	}
}
?>