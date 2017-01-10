<?php
namespace com\efe13\tdt\controller;

require_once( getMVCPath( ACTIVE_ENUM_PATH ) );
require_once( getMVCPath( QUERY_HELPER_PATH ) );
require_once( getAppPath( STATUS_RESULT_SERVICE_PATH ) );
require_once( getAppPath( SERVICE_RESULT_PATH ) );
require_once( getAppPath( POPULATION_DTO_PATH ) );
require_once( getAppPath( POPULATION_SERVICE_IMPL_PATH ) );
require_once( getAppPath( APP_UTILS_PATH ) );

use com\efe13\mvc\commons\api\enums\ActiveEnum;
use com\efe13\mvc\model\api\impl\helper\QueryHelper;
use com\efe13\tdt\enums\StatusResultService;
use com\efe13\tdt\helper\ServiceResult;
use com\efe13\tdt\model\dto\PopulationDTO;
use com\efe13\tdt\service\impl\PopulationServiceImpl;
use com\efe13\tdt\utils\AppUtils;

//@RequestMapping( "/population" )
class PopulationController {
	
	private static $POPULATION_SERVICE;

	public function __construct() {
		self::$POPULATION_SERVICE = new PopulationServiceImpl();
	}
	
	//@RequestMapping( value="/", method=RequestMethod\GET )
	public function getPopulations(QueryHelper $queryHelper) {
		try {
			return self::$POPULATION_SERVICE->listAll( $queryHelper );
		}
		catch( Exception $ex ) {
			return AppUtils::createResultServiceByMessageAndStatus( $ex->getMessage(), StatusResultService::STATUS_FAILED );
		}
	}
	
	//@RequestMapping( value="/state/{stateId}", method=RequestMethod\GET )
	public function getPopulationsByState($stateId) {
		try {
			$stateDTO = new StateDTO();
			$stateDTO->setId( $stateId );
			return self::$POPULATION_SERVICE->getByState( $stateDTO );
		}
		catch( Exception $ex ) {
			return AppUtils::createResultServiceByMessageAndStatus( $ex->getMessage(), StatusResultService::STATUS_FAILED );
		}
	}
	
	//@RequestMapping( value="/{id}", method=RequestMethod\GET )
	public function getPopulation($populationId) {
		try {
			$populationDTO = new PopulationDTO();
			$populationDTO->setId( $populationId );
			return self::$POPULATION_SERVICE->getById( $populationDTO );
		}
		catch( Exception $ex ) {
			return AppUtils::createResultServiceByMessageAndStatus( $ex->getMessage(), StatusResultService::STATUS_FAILED );
		}
	}

	//@RequestMapping( value="/", method=RequestMethod\POST )
	public function savePopulation(PopulationDTO $populationDTO) {
		try {
			$serviceResult = new StateServiceImpl()->getById( $populationDTO->getState() );
			if( $serviceResult->getStatusResult() == StatusResultService::STATUS_SUCCESS ) {
				$populationDTO->setActive( ActiveEnum::ACTIVE );
				return self::$POPULATION_SERVICE->savePopulation( $populationDTO );
			}
			
			return AppUtils::createResultServiceByMessageAndStatus( $serviceResult->getMessage(), $serviceResult->getStatusResult() );
		}
		catch( Exception $ex ) {
			return AppUtils::createResultServiceByMessageAndStatus( $ex->getMessage(), StatusResultService::STATUS_FAILED );
		}
	}
	
	//@RequestMapping( value="/{id}", method=RequestMethod\PUT )
	public function updatePopulation($populationId, PopulationDTO $populationDTO) {
		try {
			$serviceResult = $this->getPopulation( $populationId );
			if( $serviceResult->getStatusResult() == StatusResultService::STATUS_SUCCESS ) {
				$populationDTO->setId( $populationId );
				return self::$POPULATION_SERVICE->update( $populationDTO );
			}
			
			return $serviceResult;
		}
		catch( Exception $ex ) {
			return AppUtils::createResultServiceByMessageAndStatus( $ex->getMessage(), StatusResultService::STATUS_FAILED );
		}
	}
	
	//@RequestMapping( value="/{id}", method=RequestMethod\DELETE )
	public function deletePopulation($populationId) {
		try {
			$serviceResult = getPopulation( $populationId );
			if( $serviceResult->getStatusResult() == StatusResultService::STATUS_SUCCESS ) {
				return self::$POPULATION_SERVICE->delete( $serviceResult->getObject() );
			}
			
			return $serviceResult;
		}
		catch( Exception $ex ) {
			return AppUtils::createResultServiceByMessageAndStatus( $ex->getMessage(), StatusResultService::STATUS_FAILED );
		}

	}
}
?>