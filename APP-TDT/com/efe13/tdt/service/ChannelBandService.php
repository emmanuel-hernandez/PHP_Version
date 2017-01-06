<?php
namespace com\efe13\tdt\service;

require_once( getMVCPath( ACTIVE_ENUM_PATH ) );
require_once( getMVCPath( UPDATE_ENUM_PATH ) );
require_once( getMVCPath( VALIDATION_EXCEPTION_PATH ) );
require_once( getMVCPath( DTO_API_PATH ) );
require_once( getMVCPath( ENTITY_API_PATH ) );
require_once( getMVCPath( SERVICE_API_PATH ) );
require_once( getAppPath( CHANNEL_BAND_DAO_PATH ) );
require_once( getAppPath( CHANNEL_BAND_DTO_PATH ) );
require_once( getAppPath( CHANNEL_BAND_PATH ) );

use com\efe13\mvc\commons\api\enums\ActiveEnum;
use com\efe13\mvc\commons\api\enums\UpdateEnum;
use com\efe13\mvc\commons\api\exception\ValidationException;
use com\efe13\mvc\model\api\impl\dto\DTOAPI;
use com\efe13\mvc\model\api\impl\entity\EntityAPI;
use com\efe13\mvc\service\api\impl\ServiceAPI;
use com\efe13\tdt\dao\ChannelBandDAO;
use com\efe13\tdt\model\dto\ChannelBandDTO;
use com\efe13\tdt\model\entity\ChannelBand;

class ChannelBandService extends ServiceAPI {
	
	private static $CHANNEL_BAND_DAO;
	
	public function __construct() {
		$CHANNEL_BAND_DAO = new ChannelBandDAO();
	}
	
	//@Override
	public function getById( DTOAPI $dto ) {
		$entity = new ChannelBand();
		
		try {
			$entity = $this->map( $dto, $entity );
			$entity = self::$CHANNEL_BAND_DAO->getById( entity );
		}
		catch( Exception $ex ) {
		}
		
		if( $entity == null )
			return null;
		
		return $this->map( $entity, $dto );	
	}

	//@Override
	public function getAll($queryHelper) {
		$dtos = array();
		
		try {
			$entities = self::$CHANNEL_BAND_DAO->getAll( $queryHelper );
			if( empty( $entities ) ) {
				$dtos = array();
				
				foreach( $entities as $entity ) {
					$dtos->add( $this->map( $entity, new ChannelBandDTO() ) );
				}
			}
		}
		catch( Exception $ex ) {
		}
		
		return $dtos;
	}

	//@Override
	public function save(DTOAPI $channelBandDTO) {
		try {
			$channelBand = $this->map( $channelBandDTO, new ChannelBand() );
			return self::$CHANNEL_BAND_DAO->save( $channelBand );
		}
		catch( Exception $ex ) {
			throw new Exception( $ex->getMessage() );
		}
	}

	//@Override
	public function update(DTOAPI $channelBandDTO) {
		try {
			$channelBand = $this->map( $channelBandDTO, new ChannelBand() );
			return self::$CHANNEL_BAND_DAO->update( $channelBand );
		}
		catch( Exception $ex ) {
			throw new Exception( $ex->getMessage() );
		}
	}

	//@Override
	public function delete(DTOAPI $channelBandDTO) {
		try {
			$channelBandDTO->setActive( ActiveEnum::INACTIVE );
			return $this->update( $channelBandDTO );
		}
		catch( Exception $ex ) {
			throw new Exception( $ex->getMessage() );
		}
	}

	//@Override
	public function validateDTO(DTOAPI $dto, $update) {
		throw new ValidationException( "This method has not implementation\ It needs to be implemented by the concrete class" );
	}

	//@Override
	public function sanitizeDTO(DTOAPI $dto) {
		throw new ValidationException( "This method has not implementation\ It needs to be implemented by the concrete class" );	
	}
}
?>