<?php
namespace com\efe13\tdt\model\dto;

require_once( getMVCPath( DTO_API_PATH ) );

use com\efe13\mvc\model\api\impl\dto\DTOAPI;

class ConcessionaireDTO extends DTOAPI {

	private $id;
	private $name;
	private $active;
	//private Set<ChannelDTO> channels = new HashSet<>();
	
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
	public Set<ChannelDTO> getChannels() {
		return channels;
	}

	public void setChannels(Set<ChannelDTO> channels) {
		$this->channels = channels;
	}
	*/
}
?>