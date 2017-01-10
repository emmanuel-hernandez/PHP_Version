<?php
namespace com\efe13\tdt\model\entity;

require_once( getMVCPath( IENTITY_PATH ) );

use com\efe13\mvc\model\api\impl\entity\EntityAPI;

//@Entity
//@Table( name="concessionType" )
class ConcessionType extends EntityAPI {

	//@Id
	//@Column( name="concessionTypeId" )
	//@GeneratedValue( strategy=GenerationType\AUTO )
	private $id;
	
	//@Column( name="type" )
	private $type;
	
	//@Column( name="description" )
	private $description;
	
	//@Column( name="active" )
	private $active;
	
	/*
	@OneToMany( fetch=FetchType\EAGER, mappedBy="concessionType" )
	private Set<Channel> channels = new HashSet<>();
	*/
	
	//@Override
	public function getId() {
		return $this->id;
	}
	
	//@Override
	public function setId($id) {
		$this->id = $id;
	}
	
	public function getType() {
		return $this->type;
	}
	
	public function setType($type) {
		$this->type = $type;
	}
	
	public function getDescription() {
		return $this->description;
	}

	public function setDescription($description) {
		$this->description = $description;
	}

	//@Override
	public function isActive() {
		return $this->active;
	}
	
	//@Override
	public function setActive($active) {
		$this->active = $active;
	}

	/*
	public Set<Channel> getChannels() {
		return channels;
	}

	public void setChannels(Set<Channel> channels) {
		$this->channels = channels;
	}
	*/
	
}
?>