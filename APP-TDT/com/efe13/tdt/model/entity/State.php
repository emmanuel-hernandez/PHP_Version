<?php
namespace com\efe13\tdt\model\entity;

require_once( getMVCPath( IENTITY_PATH ) );

use com\efe13\mvc\model\api\impl\entity\EntityAPI;

//@Entity
//@Table( name="state" )
class State extends EntityAPI {

	//@Id
	//@Column( name="stateId" )
	//@GeneratedValue( strategy=GenerationType\AUTO )
	private $id;
	
	//@Column( name="name" )
	private $name;
	
	//@Column( name="shortName" )
	private $shortName;
	
	//@Column( name="active" )
	private $active;
	
	/*
	@OneToMany( fetch=FetchType\EAGER, mappedBy="state" )
	private Set<Population> populations = new HashSet<>();
	*/
	
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
	public Set<Population> getPopulations() {
		return populations;
	}

	public void setPopulations(Set<Population> populations) {
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