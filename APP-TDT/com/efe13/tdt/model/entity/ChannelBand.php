<?php
namespace com\efe13\tdt\model\entity;
/*
import javax\persistence\Column;
import javax\persistence\Entity;
import javax\persistence\FetchType;
import javax\persistence\GeneratedValue;
import javax\persistence\GenerationType;
import javax\persistence\Id;
import javax\persistence\OneToMany;
import javax\persistence\Table;
*/

require_once( getMVCPath( ENTITY_API_PATH ) );

use com\efe13\mvc\model\api\impl\entity\EntityAPI;

//@Entity
//@Table( name="channelBand" )
class ChannelBand extends EntityAPI {

	//@Id
	//@Column( name="channelBandId" )
	//@GeneratedValue( strategy=GenerationType\AUTO )
	private $id;
	
	//@Column( name="name" )
	private $name;
	
	//@Column( name="description" )
	private $description;
	
	//@Column( name="active" )
	private $active;
	
	/*
	@OneToMany( fetch=FetchType\EAGER, mappedBy="channelBand" )
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
	
	public  function getName() {
		return $this->name;
	}
	
	public function setName($name) {
		$this->name = $name;
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
		this\channels = channels;
	}
	*/
}
?>