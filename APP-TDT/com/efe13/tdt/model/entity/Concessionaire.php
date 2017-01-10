<?php
namespace com\efe13\tdt\model\entity;

require_once( getMVCPath( ENTITY_API_PATH ) );

use com\efe13\mvc\model\api\impl\entity\EntityAPI;

//@Entity
//@Table( name="concessionaire" )
class Concessionaire extends EntityAPI {

	//@Id
	//@Column( name="concessionaireId" )
	//@GeneratedValue( strategy=GenerationType\AUTO )
	private $id;
	
	//@Column( name="name" )
	private $name;
	
	//@Column( name="active" )
	private $active;
	
	/*
	@OneToMany( fetch=FetchType\EAGER, mappedBy="concessionaire" )
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