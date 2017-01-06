<?php
namespace com\efe13\tdt\service\impl;

require_once( getMVCPath( UPDATE_ENUM_PATH ) );
require_once( getMVCPath( UTILS_PATH ) );
require_once( getMVCPath( DTO_API_PATH ) );
require_once( getMVCPath( QUERY_HELPER_PATH ) );
require_once( getAppPath( STATUS_RESULT_SERVICE_PATH ) );
require_once( getAppPath( SERVICE_RESULT_PATH ) );
require_once( getAppPath( CHANNEL_BAND_DTO_PATH ) );
require_once( getAppPath( CHANNEL_BAND_SERVICE_PATH ) );

use com\efe13\mvc\commons\api\enums\UpdateEnum;
use com\efe13\mvc\commons\api\util\Utils;
use com\efe13\mvc\model\api\impl\dto\DTOAPI;
use com\efe13\mvc\model\api\impl\helper\QueryHelper;
use com\efe13\tdt\enums\StatusResultService;
use com\efe13\tdt\helper\ServiceResult;
use com\efe13\tdt\model\dto\ChannelBandDTO;
use com\efe13\tdt\service\ChannelBandService;

class ChannelBandServiceImpl extends ChannelBandService {

	private $serviceResult = null;
	private $resultMessage;
	private $statusResultService;
	
	private static $FIELD_MIN_LENGTH = 2;
	private static $NAME_FIELD_MAX_LENGTH = 3;
	private static $DESCRIPTION_FIELD_MAX_LENGTH = 10;
	
	public function getById( ChannelBandDTO $channelBandDTO ) {
		try {
			$serviceResult = new ServiceResult();
			
			$channelBandDTO = parent::getById( $channelBandDTO );
			if( $channelBandDTO != null ) {
				$resultMessage = null;
				$serviceResult->setObject( $channelBandDTO );
				$statusResultService = StatusResultService::STATUS_SUCCESS;
			}
			else {
				$resultMessage = "El canal especificado no existe";
				$statusResultService = StatusResultService::STATUS_FAILED;
			}
		}
		catch( Exception $ex ) {
			$resultMessage = $ex->getMessage();
			$statusResultService = StatusResultService::STATUS_FAILED;
		}
		
		$serviceResult->setMessage( $resultMessage );
		$serviceResult->setStatusResult( $statusResultService );
		return $serviceResult;
	}

	public function listAll( QueryHelper $serviceRequest ) {
		try {
			$serviceResult = new ServiceResult();
			
			$dtos = array();
			foreach( parent::getAll( $serviceRequest ) as $dto ) {
				$dtos[] = $dto;
			}
			
			$serviceResult->setCollection( $dtos );
			$statusResultService = StatusResultService::STATUS_SUCCESS;
		}
		catch( Exception $ex ) {
			$resultMessage = $ex->getMessage();
			$statusResultService = StatusResultService::STATUS_FAILED;
		}
		
		$serviceResult->setMessage( $resultMessage );
		$serviceResult->setStatusResult( $statusResultService );
		return $serviceResult;
	}

	public function saveChannelBand(ChannelBandDTO $channelBandDTO) {
		try {
			$serviceResult = new ServiceResult();
			
			$this->validateDTO( $channelBandDTO, UpdateEnum::IS_NOT_UPDATE );
			if( parent::save( $channelBandDTO ) > 0 ) {
				$resultMessage = "El canal se ha guardado correctamente";
				$statusResultService = StatusResultService::STATUS_SUCCESS;
			}
			else {
				$resultMessage = "No se pudo guardar el canal";
				$statusResultService = StatusResultService::STATUS_FAILED;
			}
		}
		catch( Exception $ex ) {
			$resultMessage = $ex->getMessage();
			$statusResultService = StatusResultService::STATUS_FAILED;
		}
		
		$serviceResult->setMessage( $resultMessage );
		$serviceResult->setStatusResult( $statusResultService );
		return $serviceResult;
	}

	public function update(ChannelBandDTO $channelBandDTO) {
		try {
			$serviceResult = new ServiceResult();
			
			$this->validateDTO( $channelBandDTO, UpdateEnum::IS_UPDATE );
			if( parent::update( $channelBandDTO ) ) {
				$resultMessage = "El canal se ha actualizado correctamente";
				$statusResultService = StatusResultService::STATUS_SUCCESS;
			}
			else {
				$resultMessage = "No se pudo actualizar el canal";;
				$statusResultService = StatusResultService::STATUS_FAILED;
			}
		}
		catch( Exception $ex ) {
			$resultMessage = $ex->getMessage();
			$statusResultService = StatusResultService::STATUS_FAILED;
		}
		
		$serviceResult->setMessage( $resultMessage );
		$serviceResult->setStatusResult( $statusResultService );
		return $serviceResult;
	}

	public function delete(ChannelBandDTO $channelBandDTO) {
		try {
			$serviceResult = new ServiceResult();
			
			if( parent::delete( $channelBandDTO ) ) {
				$resultMessage = "El canal se ha eliminado correctamente";
				$statusResultService = StatusResultService::STATUS_SUCCESS;
			}
			else {
				$resultMessage = "No se pudo eliminar el canal";
				$statusResultService = StatusResultService::STATUS_FAILED;
			}
		}
		catch( Exception $ex ) {
			$resultMessage = $ex->getMessage();
			$statusResultService = StatusResultService::STATUS_FAILED;
		}
		
		$serviceResult->setMessage( $resultMessage );
		$serviceResult->setStatusResult( $statusResultService );
		return $serviceResult;
	}
	
	//@Override
	public function validateDTO( DTOAPI $dto, $update ) {
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
	public function sanitizeDTO(DTOAPI $dto) {
		$channelBandDTO = $dto;

		$channelBandDTO->setName( Utils::toUpperCase( $channelBandDTO->getName() ) );
		$channelBandDTO->setDescription( Utils::toUpperCase( $channelBandDTO->getDescription() ) );
		
		return $channelBandDTO;
	}
}
?>