<?php
namespace com\efe13\tdt\controller;

require_once( getMVCPath( ACTIVE_ENUM_PATH ) );
require_once( getMVCPath( QUERY_HELPER_PATH ) );
require_once( getAppPath( STATUS_RESULT_SERVICE_PATH ) );
require_once( getAppPath( SERVICE_RESULT_PATH ) );
require_once( getAppPath( CONCESSIONAIRE_DTO_PATH ) );
require_once( getAppPath( CONCESSIONAIRE_SERVICE_IMPL_PATH ) );
require_once( getAppPath( APP_UTILS_PATH ) );

use com\efe13\mvc\commons\api\enums\ActiveEnum;
use com\efe13\mvc\model\api\impl\helper\QueryHelper;
use com\efe13\tdt\enums\StatusResultService;
use com\efe13\tdt\helper\ServiceResult;
use com\efe13\tdt\model\dto\ConcessionaireDTO;
use com\efe13\tdt\service\impl\ConcessionaireServiceImpl;
use com\efe13\tdt\utils\AppUtils;

//@RequestMapping( "/concessionaire" )
class ConcessionaireController {
	
	private static $CONCESSIONAIRE_SERVICE;

	public function __construct() {
		self::$CONCESSIONAIRE_SERVICE = new ConcessionaireServiceImpl();
	}
	
	//@RequestMapping( value="/", method=RequestMethod\GET )
	public function getConcessionaires(QueryHelper $queryHelper = null) {
		try {
			return self::$CONCESSIONAIRE_SERVICE->listAll( $queryHelper );
		}
		catch( \Exception $ex ) {
			return AppUtils::createResultServiceByMessageAndStatus( $ex->getMessage(), StatusResultService::STATUS_FAILED );
		}
	}
	
	//@RequestMapping( value="/{id}", method=RequestMethod\GET )
	public function getConcessionaire($concessionaireId) {
		try {
			$concessionaireDTO = new ConcessionaireDTO();
			$concessionaireDTO->setId( $concessionaireId );
			return self::$CONCESSIONAIRE_SERVICE->getById( $concessionaireDTO );
		}
		catch( \Exception $ex ) {
			return AppUtils::createResultServiceByMessageAndStatus( $ex->getMessage(), StatusResultService::STATUS_FAILED );
		}
	}
	
	//@RequestMapping( value="/", method=RequestMethod\POST )
	public function saveConcessionaire(ConcessionaireDTO $concessionaireDTO) {
		try {
			$concessionaireDTO->setActive( ActiveEnum::ACTIVE );
			return self::$CONCESSIONAIRE_SERVICE->saveConcessionaire( $concessionaireDTO );
		}
		catch( \Exception $ex ) {
			return AppUtils::createResultServiceByMessageAndStatus( $ex->getMessage(), StatusResultService::STATUS_FAILED );
		}
	}
	
	//@RequestMapping( value="/{id}", method=RequestMethod\PUT )
	public function updateConcessionaire($concessionaireId, ConcessionaireDTO $concessionaireDTO ) {
		try {
			$serviceResult = $this->getConcessionaire( $concessionaireId );
			if( $serviceResult->getStatusResult() == StatusResultService::STATUS_SUCCESS ) {
				$concessionaireDTO->setId( $concessionaireId );
				return self::$CONCESSIONAIRE_SERVICE->update( $concessionaireDTO );
			}
			
			return $serviceResult;
		}
		catch( \Exception $ex ) {
			return AppUtils::createResultServiceByMessageAndStatus( $ex->getMessage(), StatusResultService::STATUS_FAILED );
		}

	}
	
	//@RequestMapping( value="/{id}", method=RequestMethod\DELETE )
	public function deleteConcessionaire($concessionaireId) {
		try {
			$serviceResult = $this->getConcessionaire( $concessionaireId );
			if( $serviceResult->getStatusResult() == StatusResultService::STATUS_SUCCESS ) {
				return self::$CONCESSIONAIRE_SERVICE->delete( $serviceResult->getObject() );
			}
			
			return $serviceResult;
		}
		catch( \Exception $ex ) {
			return AppUtils::createResultServiceByMessageAndStatus( $ex->getMessage(), StatusResultService::STATUS_FAILED );
		}
	}
}
?>