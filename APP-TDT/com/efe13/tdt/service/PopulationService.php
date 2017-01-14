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
require_once( getAppPath( POPULATION_DAO_PATH ) );
require_once( getAppPath( POPULATION_PATH ) );

use com\efe13\mvc\commons\api\enums\ActiveEnum;
use com\efe13\mvc\commons\api\enums\UpdateEnum;
use com\efe13\mvc\commons\api\exception\ValidationException;
use com\efe13\mvc\commons\api\exception\DAOException;
use com\efe13\mvc\commons\api\util\Utils;
use com\efe13\mvc\commons\api\interfaces\Mappeable;
use com\efe13\mvc\model\api\impl\entity\EntityAPI;
use com\efe13\mvc\model\api\impl\QueryHelper;
use com\efe13\mvc\service\api\impl\ServiceAPI;
use com\efe13\tdt\dao\PopulationDAO;
use com\efe13\tdt\model\dto\PopulationDTO;
use com\efe13\tdt\model\entity\Population;

class PopulationService extends ServiceAPI {
	
	private static $POPULATION_DAO;

	public function __construct() {
		self::$POPULATION_DAO = new PopulationDAO();
	}
	
	//@Override
	public function getTableCount() {
		try {
			return self::$POPULATION_DAO->getTableCount();
		}
		catch( \Exception $ex ) {
			throw $ex;
		}
	}
	
	//@Override
	public function getById(Mappeable $populationDTO) {
		$entity = new Population();
		
		try {
			$entity = $this->map( $populationDTO, $entity );
			$entity = self::$POPULATION_DAO->getById( $entity );
		}
		catch( \Exception $ex ) {
			throw $ex;
		}
		
		if( Utils::isNull( $entity ) ) {
			return null;
		}
		
		return $this->map( $entity, $populationDTO );	
	}

	//@Override
	public function getAll(QueryHelper $queryHelper = null) {
		$dtos = array();
		
		try {
			$entities = self::$POPULATION_DAO->getAll( $queryHelper );
			if( !Utils::isEmpty( $entities ) ) {
				foreach( $entities as $population ) {
					$dtos[] = $this->map( $population, new PopulationDTO() );
				}
			}
		}
		catch( \Exception $ex ) {
			throw $ex;
			
		}
		
		return $dtos;
	}
	
	public function getByState(Mappeable $stateDTO) {
		$dtos = array();
		
		try {
			$entity = new State();
			$entity = $this->map( $stateDTO, new State() );
			$entities = self::$POPULATION_DAO->getByState( $entity );
			if( !Utils::isEmpty( $entities ) ) {
				foreach( $entities as $population ) {
					$dtos[] = $this->map( $population, new PopulationDTO() );
				}
			}
		}
		catch( \Exception $ex ) {
			throw $ex;
		}
		
		return $dtos;
	}

	public function findByNameAndState(Mappeable $populationDTO) {
		$entity = new Population();
		$id = 0;
		
		try {
			$entity = $this->map( $populationDTO, $entity );
			$id = self::$POPULATION_DAO->findByNameAndState( $entity );
		}
		catch( \Exception $ex ) {
			throw $ex;
		}
		
		return $id;
	}
	
	//@Override
	public function save(Mappeable $populationDTO) {
		try {
			$population = $this->map( $populationDTO, new Population() );

			return self::$POPULATION_DAO->save( $population );
		}
		catch( \Exception $ex ) {
			throw $ex;
		}
	}

	//@Override
	public function update(Mappeable $populationDTO) {
		try {
			$population = $this->map( $populationDTO, new Population() );
			return self::$POPULATION_DAO->update( $population );
		}
		catch( \Exception $ex ) {
			throw $ex;
		}
	}

	//@Override
	public function delete(Mappeable $populationDTO) {
		try {
			$populationDTO->setActive( ActiveEnum::INACTIVE );
			return $this->update( $populationDTO );
		}
		catch( \Exception $ex ) {
			throw $ex;
		}
	}
	
	//@Override
	public function validateDTO(Mappeable $dto, $update) {
		throw new ValidationException( "This method has not implementation\ It needs to be implemented by the concrete class" );
	}

	//@Override
	public function sanitizeDTO(Mappeable $dto) {
		throw new ValidationException( "This method has not implementation\ It needs to be implemented by the concrete class" );	
	}
}
?>