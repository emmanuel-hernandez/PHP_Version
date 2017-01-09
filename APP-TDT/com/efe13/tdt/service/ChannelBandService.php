<?php
namespace com\efe13\tdt\service;

require_once( getMVCPath( ACTIVE_ENUM_PATH ) );
require_once( getMVCPath( UPDATE_ENUM_PATH ) );
require_once( getMVCPath( VALIDATION_EXCEPTION_PATH ) );
require_once( getMVCPath( DAO_EXCEPTION_PATH ) );
require_once( getMVCPath( MAPPEABLE_PATH ) );
require_once( getMVCPath( UTILS_PATH ) );
require_once( getMVCPath( ENTITY_API_PATH ) );
require_once( getMVCPath( QUERY_HELPER_PATH ) );
require_once( getMVCPath( SERVICE_API_PATH ) );
require_once( getAppPath( CHANNEL_BAND_DAO_PATH ) );
require_once( getAppPath( CHANNEL_BAND_DTO_PATH ) );
require_once( getAppPath( CHANNEL_BAND_PATH ) );

use com\efe13\mvc\commons\api\enums\ActiveEnum;
use com\efe13\mvc\commons\api\enums\UpdateEnum;
use com\efe13\mvc\commons\api\exception\ValidationException;
use com\efe13\mvc\commons\api\exception\DAOException;
use com\efe13\mvc\commons\api\interfaces\Mappeable;
use com\efe13\mvc\commons\api\util\Utils;
use com\efe13\mvc\model\api\impl\entity\EntityAPI;
use com\efe13\mvc\model\api\impl\QueryHelper;
use com\efe13\mvc\service\api\impl\ServiceAPI;
use com\efe13\tdt\dao\ChannelBandDAO;
use com\efe13\tdt\model\dto\ChannelBandDTO;
use com\efe13\tdt\model\entity\ChannelBand;

class ChannelBandService extends ServiceAPI {
	
	private static $CHANNEL_BAND_DAO;
	
	public function __construct() {
		self::$CHANNEL_BAND_DAO = new ChannelBandDAO();
	}
	
	//@Override
	public function getById( Mappeable $dto ) {
		$entity = new ChannelBand();
		
		try {
			$entity = $entity = $this->map( $dto, $entity );
			$entity = self::$CHANNEL_BAND_DAO->getById( $entity );
		}
		catch( DAOException $ex ) {
			throw $ex;
		}
		
		if( Utils::isNull( $entity ) ) {
			return null;
		}
		
		return ( $this->map( $entity, $dto ) );
	}

	//@Override
	public function getAll(QueryHelper $queryHelper = null) {
		$dtos = array();

		try {
			$entities = self::$CHANNEL_BAND_DAO->getAll( $queryHelper );

			if( !empty( $entities ) ) {
				$dtos = array();
				
				foreach( $entities as $entity ) {
					$dtos[] = $entity;//parent::map( $entity, new ChannelBandDTO() );
				}
			}
		}
		catch( DAOException $ex ) {
			throw $ex;
		}
		
		return $dtos;
	}

	//@Override
	public function save(Mappeable $channelBandDTO) {
		try {
			$channelBand = $this->map( $channelBandDTO, new ChannelBand() );
			return (self::$CHANNEL_BAND_DAO->save( $channelBand ) );
		}
		catch( DAOException $ex ) {
			throw $ex;
		}
	}

	//@Override
	public function update(Mappeable $channelBandDTO) {
		try {
			$channelBand = $this->map( $channelBandDTO, new ChannelBand() );
			return ( self::$CHANNEL_BAND_DAO->update( $channelBand ) );
		}
		catch( DAOException $ex ) {
			throw $ex;
		}
	}

	//@Override
	public function delete(Mappeable $channelBandDTO) {
		try {
			$channelBandDTO->setActive( ActiveEnum::INACTIVE );
			return ( $this->update( $channelBandDTO ) );
		}
		catch( DAOException $ex ) {
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