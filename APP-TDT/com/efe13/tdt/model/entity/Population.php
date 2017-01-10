<?php
namespace com\efe13\tdt\model\entity;

use com\efe13\mvc\model\api\impl\entity\EntityAPI;

//@Entity
//@Table( name="population" )
class Population extends EntityAPI {

	//@Id
	//@Column( name="populationId" )
	//@GeneratedValue( strategy=GenerationType\AUTO )
	private $id;
	
	//@Column( name="name" )
	private $name;
	
	//@Column( name="active" )
	private $active;
	
	//@ManyToOne( fetch=FetchType\EAGER )
	//@JoinColumn( name="stateId" )
	private State $state;
	
	/*@OneToMany( fetch=FetchType\EAGER, mappedBy="population" )
	private Set<Channel> channels = new HashSet<>();*/
	
	//@Override
	public Short getId() {
		return id;
	}
	
	@Override
	public void setId(Number id) {
		this\id = (short) id;
	}
	
	public String getName() {
		return name;
	}
	
	public void setName(String name) {
		this\name = name;
	}
	
	@Override
	public Boolean isActive() {
		return active;
	}
	
	@Override
	public void setActive(Boolean active) {
		this\active = active;
	}

	public State getState() {
		return state;
	}

	public void setState(State state) {
		this\state = state;
	}
/*
	public Set<Channel> getChannels() {
		return channels;
	}

	public void setChannels(Set<Channel> channels) {
		this\channels = channels;
	}*/
}
?>