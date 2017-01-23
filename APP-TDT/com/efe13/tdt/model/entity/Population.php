<?php
namespace com\efe13\tdt\model\entity;

require_once( getMVCPath( IENTITY_PATH ) );
require_once( getAppPath( STATE_PATH ) );

use com\efe13\mvc\model\api\impl\entity\EntityAPI;
use com\efe13\tdt\model\entity\State;

/**
 * @Table({ "name": "population", "idColumn": "id" })
 * @ForeignKey([ {"property": "state", "relationshipId": "stateId", "entity": "com\efe13\tdt\model\entity\State"} ])
 */
class Population extends EntityAPI {

	/**
	 *@Id
	 *@Column( name="populationId" )
	 *@GeneratedValue( strategy=GenerationType\AUTO )
	 */
	private $id;
	
	//@Column( name="name" )
	private $name;
	
	//@Column( name="active" )
	private $active;
	
	//@ManyToOne( fetch=FetchType\EAGER )
	//@JoinColumn( name="stateId" )
	private $state;
	
	/*@OneToMany( fetch=FetchType\EAGER, mappedBy="population" )
	private Set<Channel> channels = new HashSet<>();*/
	
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
			$this->state = new State();
		}
		
		return $this->state;
	}

	public function setState(State $state) {
		$this->state = $state;
	}
/*
	public Set<Channel> getChannels() {
		return channels;
	}

	public void setChannels(Set<Channel> channels) {
		$this->channels = channels;
	}*/
}
?>