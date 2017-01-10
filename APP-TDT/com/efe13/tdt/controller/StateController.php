<?php
namespace com\efe13\tdt\controller;

require_once( getMVCPath( ACTIVE_ENUM_PATH ) );
require_once( getMVCPath( QUERY_HELPER_PATH ) );
require_once( getAppPath( STATUS_RESULT_SERVICE_PATH ) );
require_once( getAppPath( SERVICE_RESULT_PATH ) );
require_once( getAppPath( STATE_DTO_PATH ) );
require_once( getAppPath( STATE_SERVICE_IMPL_PATH ) );
require_once( getAppPath( APP_UTILS_PATH ) );

use com\efe13\mvc\commons\api\enums\ActiveEnum;
use com\efe13\mvc\model\api\impl\helper\QueryHelper;
use com\efe13\tdt\enums\StatusResultService;
use com\efe13\tdt\helper\ServiceResult;
use com\efe13\tdt\model\dto\StateDTO;
use com\efe13\tdt\service\impl\StateServiceImpl;
use com\efe13\tdt\utils\AppUtils;

//@RequestMapping( "/state" )
class StateController {
	
	private static $STATE_SERVICE;

	public function __construct() {
		self::$STATE_SERVICE = new StateServiceImpl();
	}
	
	//@RequestMapping( value="/", method=RequestMethod\GET )
	public function getStates(QueryHelper $queryHelper = null) {
		try {
			return self::$STATE_SERVICE->listAll( $queryHelper );
		}
		catch( \Exception $ex ) {
			return AppUtils::createResultServiceByMessageAndStatus( $ex->getMessage(), StatusResultService::STATUS_FAILED );
		}
	}
	
	//@RequestMapping( value="/{id}", method=RequestMethod\GET )
	public function getState($stateId ) {
		try {
			$stateDTO = new StateDTO();
			$stateDTO->setId( $stateId );
			return self::$STATE_SERVICE->getById( $stateDTO );
		}
		catch( \Exception $ex ) {
			return AppUtils::createResultServiceByMessageAndStatus( $ex->getMessage(), StatusResultService::STATUS_FAILED );
		}
	}
	
	//@RequestMapping( value="/", method=RequestMethod\POST )
	public function saveState(StateDTO $stateDTO) {
		try {
			$stateDTO->setActive( ActiveEnum::ACTIVE );
			return self::$STATE_SERVICE->saveState( $stateDTO );
		}
		catch( \Exception $ex ) {
			return AppUtils::createResultServiceByMessageAndStatus( $ex->getMessage(), StatusResultService::STATUS_FAILED );
		}
	}
	
	//@RequestMapping( value="/{id}", method=RequestMethod\PUT )
	public function updateState($stateId, StateDTO $stateDTO) {
		try {
			$serviceResult = $this->getState( $stateId );
			if( $serviceResult->getStatusResult() == StatusResultService::STATUS_SUCCESS ) {
				$stateDTO->setId( $stateId );
				return self::$STATE_SERVICE->update( $stateDTO );
			}
			
			return $serviceResult;
		}
		catch( \Exception $ex ) {
			return AppUtils::createResultServiceByMessageAndStatus( $ex->getMessage(), StatusResultService::STATUS_FAILED );
		}
	}
	
	//@RequestMapping( value="/{id}", method=RequestMethod\DELETE )
	public function deleteState($stateId) {
		try {
			$serviceResult = $this->getState( $stateId );
			if( $serviceResult->getStatusResult() == StatusResultService::STATUS_SUCCESS ) {
				return self::$STATE_SERVICE->delete( $serviceResult->getObject() );
			}
			
			return $serviceResult;
		}
		catch( \Exception $ex ) {
			return AppUtils::createResultServiceByMessageAndStatus( $ex->getMessage(), StatusResultService::STATUS_FAILED );
		}
	}
}
?>