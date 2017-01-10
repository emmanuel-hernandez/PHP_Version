<?php
namespace com\efe13\tdt\service;

require_once( getMVCPath( ACTIVE_ENUM_PATH ) );
require_once( getMVCPath( UPDATE_ENUM_PATH ) );
require_once( getMVCPath( VALIDATION_EXCEPTION_PATH ) );
require_once( getMVCPath( DAO_EXCEPTION_PATH ) );
require_once( getMVCPath( DTO_API_PATH ) );
require_once( getMVCPath( ENTITY_API_PATH ) );
require_once( getMVCPath( QUERY_HELPER_PATH ) );
require_once( getMVCPath( SERVICE_API_PATH ) );
require_once( getMVCPath( UTILS_PATH ) );
require_once( getMVCPath( MAPPEABLE_PATH ) );
require_once( getAppPath( STATE_DAO_PATH ) );
require_once( getAppPath( STATE_PATH ) );

use com\efe13\mvc\commons\api\enums\ActiveEnum;
use com\efe13\mvc\commons\api\enums\UpdateEnum;
use com\efe13\mvc\commons\api\exception\ValidationException;
use com\efe13\mvc\commons\api\interfaces\Mappeable;
use com\efe13\mvc\model\api\impl\entity\EntityAPI;
use com\efe13\mvc\model\api\impl\QueryHelper;
use com\efe13\mvc\service\api\impl\ServiceAPI;
use com\efe13\mvc\commons\api\util\Utils;
use com\efe13\tdt\dao\StateDAO;
use com\efe13\tdt\model\dto\StateDTO;
use com\efe13\tdt\model\entity\State;

class StateService extends ServiceAPI {
	
	private static $STATE_DAO;

	public function __construct() {
		self::$STATE_DAO = new StateDAO();
	}
	
	//@Override
	public function getById(Mappeable $stateDTO) {
		$entity = new State();
		
		try {
			$entity = $this->map( $stateDTO, $entity );
			$entity = self::$STATE_DAO->getById( $entity );
		}
		catch( \Exception $ex ) {
			throw $ex;
		}
		
		if( Utils::isNull( $entity ) ) {
			return null;
		}
		
		return $this->map( $entity, $stateDTO );	
	}

	//@Override
	public function getAll(QueryHelper $queryHelper = null) {
		$dtos = array();
		
		try {
			$entities = self::$STATE_DAO->getAll( $queryHelper );
			if( count( $entities ) > 0 ) {
				foreach( $entities as $state ) {
					$dtos[] = $this->map( $state, new StateDTO() );
				}
			}

			return $dtos;
		}
		catch( \Exception $ex ) {
			throw $ex;
		}
	}

	public function findByName(Mappeable $stateDTO) {
		$entity = new State();
		$id = 0;
		
		try {
			$entity = $this->map( $stateDTO, $entity );
			$id = self::$STATE_DAO->findByName( $entity );
		}
		catch( \Exception $ex ) {
			throw $ex;
		}
		
		return $id;
	}
	
	public function findByShortName(Mappeable $stateDTO) {
		$entity = new State();
		$exists = 0;
		
		try {
			$entity = $this->map( $stateDTO, $entity );
			$exists = self::$STATE_DAO->findByShortName( $entity );
		}
		catch( \Exception $ex ) {
			throw $ex;
		}
		
		return $exists;
	}
	
	//@Override
	public function save(Mappeable $stateDTO) {
		try {
			$state = $this->map( $stateDTO, new State() );
			return self::$STATE_DAO->save( $state );
		}
		catch( \Exception $ex ) {;
			throw $ex;
		}
	}

	//@Override
	public function update(Mappeable $stateDTO) {
		try {
			$state = $this->map( $stateDTO, new State() );
			return self::$STATE_DAO->update( $state );
		}
		catch( \Exception $ex ) {
			throw $ex;
		}
	}

	//@Override
	public function delete(Mappeable $stateDTO) {
		try {
			$stateDTO->setActive( ActiveEnum::INACTIVE );
			return $this->update( $stateDTO );
		}
		catch( \Exception $ex ) {
			throw $ex;
		}
	}

	//@Override
	public function validateDTO(Mappeable $dto, $update) {
		throw new ValidationException( "This method has not implementation. It needs to be implemented by the concrete class" );
	}

	//@Override
	public function sanitizeDTO(Mappeable $dto) {
		throw new ValidationException( "This method has not implementation. It needs to be implemented by the concrete class" );	
	}
}
?>