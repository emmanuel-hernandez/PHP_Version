<?php
namespace com\efe13\tdt\controller;

require_once( getMVCPath( ACTIVE_ENUM_PATH ) );
require_once( getMVCPath( QUERY_HELPER_PATH ) );
require_once( getAppPath( STATUS_RESULT_SERVICE_PATH ) );
require_once( getAppPath( SERVICE_RESULT_PATH ) );
require_once( getAppPath( CONCESSION_TYPE_DTO_PATH ) );
require_once( getAppPath( self::$CONCESSION_TYPE_SERVICE_IMPL_PATH ) );

use com\efe13\mvc\commons\api\enums\ActiveEnum;
use com\efe13\mvc\model\api\impl\helper\QueryHelper;
use com\efe13\tdt\enums\StatusResultService;
use com\efe13\tdt\helper\ServiceResult;
use com\efe13\tdt\model\dto\ConcessionTypeDTO;
use com\efe13\tdt\service\impl\ConcessionTypeServiceImpl;

//@RequestMapping( "/concessionType" )
public class ConcessionTypeController {
	
	private $CONCESSION_TYPE_SERVICE = new ConcessionTypeServiceImpl();
	
	//@RequestMapping( value="/", method=RequestMethod\GET )
	public function getConcessionTypes( QueryHelper $queryHelper ) {
		try {
			return self::$CONCESSION_TYPE_SERVICE->listAll( $queryHelper );
		}
		catch( Exception $ex ) {
			return new ServiceResult( $ex->getMessage(), StatusResultService::STATUS_FAILED );
		}
	}
	
	//@RequestMapping( value="/{id}", method=RequestMethod\GET )
	public function getConcessionType( $concessionTypeId ) {
		try {
			$concessionTypeDTO = new ConcessionTypeDTO();
			$concessionTypeDTO->setId( $concessionTypeId );
			return self::$CONCESSION_TYPE_SERVIC->getById( $concessionTypeDTO );
		}
		catch( Exception $ex ) {
			return new ServiceResult( $ex->getMessage(), StatusResultService::STATUS_FAILED );
		}
	}
	
	//@RequestMapping( value="/", method=RequestMethod\POST )
	public function saveConcessionType( ConcessionTypeDTO $concessionTypeDTO ) {
		try {
			$concessionTypeDTO->setActive( ActiveEnum::ACTIVE );
			return self::$CONCESSION_TYPE_SERVICE->saveConcessionType( $concessionTypeDTO );
		}
		catch( Exception $ex ) {
			return new ServiceResult( $ex->getMessage(), StatusResultService::STATUS_FAILED );
		}
	}
	
	//@RequestMapping( value="/{id}", method=RequestMethod\PUT )
	public function updateConcessionType( $concessionTypeId, ConcessionTypeDTO $concessionTypeDTO ) {
		try {
			$serviceResult = getConcessionType( $concessionTypeId );
			if( $serviceResult->getStatusResult() == StatusResultService::STATUS_SUCCESS ) {
				$concessionTypeDTO->setId( $concessionTypeId );
				return self::$CONCESSION_TYPE_SERVICE->update( $concessionTypeDTO );
			}
			
			return $serviceResult;
		}
		catch( Exception $ex ) {
			return new ServiceResult( $ex->getMessage(), StatusResultService::STATUS_FAILED );
		}
	}
	
	//@RequestMapping( value="/{id}", method=RequestMethod\DELETE )
	public function deleteConcessionType( $concessionTypeId ) {
		try {
			$serviceResult = getConcessionType( $concessionTypeId );
			if( $serviceResult->getStatusResult() == StatusResultService::STATUS_SUCCESS ) {
				return self::$CONCESSION_TYPE_SERVICE->delete( $serviceResult->getObject() );	
			}
			
			return $serviceResult;
		}
		catch( Exception $ex ) {
			return new ServiceResult( $ex->getMessage(), StatusResultService::STATUS_FAILED );
		}
	}
}
?>