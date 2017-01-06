<?php
namespace com\efe13\tdt\controller;

require_once( getMVCPath( ACTIVE_ENUM_PATH ) );
require_once( getMVCPath( QUERY_HELPER_PATH ) );
require_once( getAppPath( STATUS_RESULT_SERVICE_PATH ) );
require_once( getAppPath( SERVICE_RESULT_PATH ) );
require_once( getAppPath( CHANNEL_BAND_DTO_PATH ) );
require_once( getAppPath( CHANNEL_BAND_SERVICE_IMPL_PATH ) );

use com\efe13\mvc\commons\api\enums\ActiveEnum;
use com\efe13\mvc\model\api\impl\helper\QueryHelper;
use com\efe13\tdt\enums\StatusResultService;
use com\efe13\tdt\helper\ServiceResult;
use com\efe13\tdt\model\dto\ChannelBandDTO;
use com\efe13\tdt\service\impl\ChannelBandServiceImpl;

//@RequestMapping( "/channelBand" )
class ChannelBandController {

	private static $CHANNEL_BAND_SERVICE;
	
	public function __construct() {
		self::$CHANNEL_BAND_SERVICE = new ChannelBandServiceImpl();
	}
	
	//@RequestMapping( value="/", method=RequestMethod.GET )
	public function getChannelBands( QueryHelper $queryHelper = null ) {
		try {
			return self::$CHANNEL_BAND_SERVICE->listAll( $queryHelper );
		}
		catch( Exception $ex ) {
			return new ServiceResult( $ex->getMessage(), StatusResultService::STATUS_FAILED );
		}
	}
	
	//@RequestMapping( value="/{id}", method=RequestMethod.GET )
	public function getChannelBand( $channelBandId ) {
		try {
			$channelBandDTO = new ChannelBandDTO();
			$channelBandDTO->setId( $channelBandId );
			
			return $CHANNEL_BAND_SERVICE->getById( $channelBandDTO );
		}
		catch( Exception $ex ) {
			return new ServiceResult( $ex->getMessage(), StatusResultService::STATUS_FAILED );
		}
	}
	
	//@RequestMapping( value="/", method=RequestMethod.POST )
	public function saveChannelBand( ChannelBandDTO $channelBandDTO ) {
		try {
			$channelBandDTO->setActive( ActiveEnum::ACTIVE );
			return $CHANNEL_BAND_SERVICE->saveChannelBand( $channelBandDTO );
		}
		catch( Exception $ex ) {
			return new ServiceResult( $ex->getMessage(), StatusResultService::STATUS_FAILED );
		}
	}
	
	//@RequestMapping( value="/{id}", method=RequestMethod.PUT )
	public function updateChannelBand( $channelBandId, ChannelBandDTO $channelBandDTO ) {
		try {
			$serviceResult = getChannelBand( $channelBandId );
			if( $serviceResult->getStatusResult() == StatusResultService::STATUS_SUCCESS ) {
				$serviceResult->getObject()->setId( $channelBandId );
				return $CHANNEL_BAND_SERVICE->update( $channelBandDTO );
			}
			
			return $serviceResult;
		}
		catch( Exception $ex ) {
			return new ServiceResult( $ex->getMessage(), StatusResultService::STATUS_FAILED );
		}

	}
	
	//@RequestMapping( value="/{id}", method=RequestMethod.DELETE )
	public function deleteChannelBand( $channelBandId ) {
		try {
			$serviceResult = getChannelBand( $channelBandId );
			if( $serviceResult->getStatusResult() == StatusResultService::STATUS_SUCCESS ) {
				return $CHANNEL_BAND_SERVICE->delete( $serviceResult->getObject() );
			}
			
			return $serviceResult;
		}
		catch( Exception $ex ) {
			return new ServiceResult( $ex->getMessage(), StatusResultService::STATUS_FAILED );
		}

	}
}
?>