<?php
namespace com\efe13\tdt\service\impl;

require_once( getMVCPath( UPDATE_ENUM_PATH ) );
require_once( getMVCPath( UTILS_PATH ) );
require_once( getMVCPath( DTO_API_PATH ) );
require_once( getMVCPath( QUERY_HELPER_PATH ) );
require_once( getMVCPath( MAPPEABLE_PATH ) );
require_once( getAppPath( STATUS_RESULT_SERVICE_PATH ) );
require_once( getAppPath( SERVICE_RESULT_PATH ) );
require_once( getAppPath( CHANNEL_BAND_SERVICE_PATH ) );

use com\efe13\mvc\commons\api\enums\UpdateEnum;
use com\efe13\mvc\commons\api\util\Utils;
use com\efe13\mvc\commons\api\interfaces\Mappeable;
use com\efe13\mvc\model\api\impl\helper\QueryHelper;
use com\efe13\tdt\enums\StatusResultService;
use com\efe13\tdt\helper\ServiceResult;
use com\efe13\tdt\service\ChannelBandService;

class ChannelBandServiceImpl extends ChannelBandService {

	private $serviceResult = null;
	private $resultMessage;
	private $statusResultService;
	
	private static $FIELD_MIN_LENGTH = 2;
	private static $NAME_FIELD_MAX_LENGTH = 3;
	private static $DESCRIPTION_FIELD_MAX_LENGTH = 10;
	
	public function getById( Mappeable $channelBandDTO ) {
		try {
			$this->serviceResult = new ServiceResult();
			
			$channelBandDTO = parent::getById( $channelBandDTO );
			if( $channelBandDTO != null ) {
				$this->resultMessage = null;
				$this->serviceResult->setObject( $channelBandDTO );
				$this->statusResultService = StatusResultService::STATUS_SUCCESS;
			}
			else {
				$this->resultMessage = "El canal especificado no existe";
				$this->statusResultService = StatusResultService::STATUS_FAILED;
			}
		}
		catch( Exception $ex ) {
			$this->resultMessage = $ex->getMessage();
			$this->statusResultService = StatusResultService::STATUS_FAILED;
		}
		
		$this->serviceResult->setMessage( $this->resultMessage );
		$this->serviceResult->setStatusResult( $this->statusResultService );
		return $this->serviceResult;
	}

	public function listAll( QueryHelper $serviceRequest = null ) {
		try {
			$this->serviceResult = new ServiceResult();
			
			$dtos = array();
			foreach( parent::getAll( $serviceRequest ) as $dto ) {
				$dtos[] = $dto;
			}
			
			$this->serviceResult->setCollection( $dtos );
			$this->statusResultService = StatusResultService::STATUS_SUCCESS;
		}
		catch( Exception $ex ) {
			$this->resultMessage = $ex->getMessage();
			$this->statusResultService = StatusResultService::STATUS_FAILED;
		}
		
		$this->serviceResult->setMessage( $this->resultMessage );
		$this->serviceResult->setStatusResult( $this->statusResultService );
		return $this->serviceResult;
	}

	public function saveChannelBand(Mappeable $channelBandDTO) {
		try {
			$this->serviceResult = new ServiceResult();
			
			$this->validateDTO( $channelBandDTO, UpdateEnum::IS_NOT_UPDATE );
			if( parent::save( $channelBandDTO ) > 0 ) {
				$this->resultMessage = "El canal se ha guardado correctamente";
				$this->statusResultService = StatusResultService::STATUS_SUCCESS;
			}
			else {
				$this->resultMessage = "No se pudo guardar el canal";
				$this->statusResultService = StatusResultService::STATUS_FAILED;
			}
		}
		catch( Exception $ex ) {
			$this->resultMessage = $ex->getMessage();
			$this->statusResultService = StatusResultService::STATUS_FAILED;
		}
		
		$this->serviceResult->setMessage( $this->resultMessage );
		$this->serviceResult->setStatusResult( $this->statusResultService );
		return $this->serviceResult;
	}

	public function update(Mappeable $channelBandDTO) {
		try {
			$this->serviceResult = new ServiceResult();
			
			$this->validateDTO( $channelBandDTO, UpdateEnum::IS_UPDATE );
			if( parent::update( $channelBandDTO ) ) {
				$this->resultMessage = "El canal se ha actualizado correctamente";
				$this->statusResultService = StatusResultService::STATUS_SUCCESS;
			}
			else {
				$this->resultMessage = "No se pudo actualizar el canal";;
				$this->statusResultService = StatusResultService::STATUS_FAILED;
			}
		}
		catch( Exception $ex ) {
			$this->resultMessage = $ex->getMessage();
			$this->statusResultService = StatusResultService::STATUS_FAILED;
		}
		
		$this->serviceResult->setMessage( $this->resultMessage );
		$this->serviceResult->setStatusResult( $this->statusResultService );
		return $this->serviceResult;
	}

	public function delete(Mappeable $channelBandDTO) {
		try {
			$this->serviceResult = new ServiceResult();
			
			if( parent::delete( $channelBandDTO ) ) {
				$this->resultMessage = "El canal se ha eliminado correctamente";
				$this->statusResultService = StatusResultService::STATUS_SUCCESS;
			}
			else {
				$this->resultMessage = "No se pudo eliminar el canal";
				$this->statusResultService = StatusResultService::STATUS_FAILED;
			}
		}
		catch( Exception $ex ) {
			$this->resultMessage = $ex->getMessage();
			$this->statusResultService = StatusResultService::STATUS_FAILED;
		}
		
		$this->serviceResult->setMessage( $this->resultMessage );
		$this->serviceResult->setStatusResult( $this->statusResultService );
		return $this->serviceResult;
	}
	
	//@Override
	public function validateDTO( Mappeable $dto, $update ) {
		$channelBandDto = $this->sanitizeDTO( $dto );

		//Validate empty fields
		if( Utils::isEmpty( $channelBandDto->getName() ) ) {
			throw new ValidationException( "El campo nombre es requerido" );
		}
		if( Utils::isEmpty( $channelBandDto->getDescription() ) ) {
			throw new ValidationException( "El campo descripción es requerido" );
		}
		
		//Validate fields length
		$lengthCheck = Utils::lengthCheck( $channelBandDto->getName(), self::$FIELD_MIN_LENGTH,  self::$NAME_FIELD_MAX_LENGTH );
		$exceptionMessage = "El campo nombre es demasiado" + (( $lengthCheck < 0 ) ? " corto" : " largo");
		if( $lengthCheck != 0 ) {
			throw new ValidationException( $exceptionMessage );
		}
		
		$lengthCheck = Utils::lengthCheck( $channelBandDto->getDescription(), self::$FIELD_MIN_LENGTH, self::$DESCRIPTION_FIELD_MAX_LENGTH );
		$exceptionMessage = "El campo descripción es demasiado" + (( $lengthCheck < 0 ) ? " corto" : " largo");
		if( $lengthCheck != 0 ) {
			throw new ValidationException( $exceptionMessage );
		}
		
		//Validate repeated
		$channelBandDTOs = $this->listAll( null )->getCollection();
		foreach( $channelBandDTOs as $channelBand ) {
			if( $channelBand->isActive() ) {
				if( $update && $channelBand->getId() == $channelBandDto->getId() ) {
					continue;
				}
				if( strcasecmp( $channelBand->getName(), $channelBandDto->getName() ) == 0 ) {
					throw new ValidationException( "Ya existe una banda con el mismo nombre" );
				}
			}
		}
	}

	//@Override
	public function sanitizeDTO(Mappeable $dto) {
		$channelBandDTO = $dto;

		$channelBandDTO->setName( Utils::toUpperCase( $channelBandDTO->getName() ) );
		$channelBandDTO->setDescription( Utils::toUpperCase( $channelBandDTO->getDescription() ) );
		
		return $channelBandDTO;
	}
}
?>