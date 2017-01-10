<?php
namespace com\efe13\tdt\service\impl;

require_once( getMVCPath( UPDATE_ENUM_PATH ) );
require_once( getMVCPath( UTILS_PATH ) );
require_once( getMVCPath( MAPPEABLE_PATH ) );
require_once( getMVCPath( DAO_EXCEPTION_PATH ) );
require_once( getMVCPath( VALIDATION_EXCEPTION_PATH ) );
require_once( getMVCPath( DTO_API_PATH ) );
require_once( getMVCPath( QUERY_HELPER_PATH ) );
require_once( getAppPath( STATUS_RESULT_SERVICE_PATH ) );
require_once( getAppPath( SERVICE_RESULT_PATH ) );
require_once( getAppPath( STATE_DTO_PATH ) );
require_once( getAppPath( STATE_SERVICE_PATH ) );

use com\efe13\mvc\commons\api\enums\UpdateEnum;
use com\efe13\mvc\commons\api\util\Utils;
use com\efe13\mvc\commons\api\interfaces\Mappeable;
use com\efe13\mvc\commons\api\exception\ValidationException;
use com\efe13\mvc\model\api\impl\dto\DTOAPI;
use com\efe13\mvc\model\api\impl\helper\QueryHelper;
use com\efe13\tdt\enums\StatusResultService;
use com\efe13\tdt\helper\ServiceResult;
use com\efe13\tdt\model\dto\StateDTO;
use com\efe13\tdt\service\StateService;

class StateServiceImpl extends StateService {
	
	private $serviceResult = null;
	private $resultMessage;
	private $statusResultService;

	private static $FIELD_MIN_LENGTH = 3;
	private static $NAME_FIELD_MAX_LENGTH = 25;
	private static $SHORT_NAME_FIELD_MAX_LENGTH = 5;
	
	public function getById(Mappeable $stateDTO) {
		try {
			$this->serviceResult = new ServiceResult();
			
			$stateDTO = parent::getById( $stateDTO );
			if( !Utils::isNull( $stateDTO ) ) {
				$this->resultMessage = null;
				$this->serviceResult->setObject( $stateDTO );
				$this->statusResultService = StatusResultService::STATUS_SUCCESS;
			}
			else {
				$this->resultMessage = "El estado especificado no existe";
				$this->statusResultService = StatusResultService::STATUS_FAILED;
			}
		}
		catch( \Exception $ex ) {
			$this->resultMessage = $ex->getMessage();
			$this->statusResultService = StatusResultService::STATUS_FAILED;
		}
		
		$this->serviceResult->setMessage( $this->resultMessage );
		$this->serviceResult->setStatusResult( $this->statusResultService );
		return $this->serviceResult;
	}

	public function listAll(QueryHelper $queryHelper = null) {
		try {
			$this->serviceResult = new ServiceResult();
			
			$dtos = array();
			foreach( parent::getAll( $queryHelper ) as $dto ) {
				$dtos[] = $dto;
			}
			
			$defaultState = new StateDTO();
			$defaultState->setId( -1 );
			$defaultState->setName( "Seleccionar..." );
			array_unshift( $dtos, $defaultState );
			
			$this->serviceResult->setCollection( $dtos );
			$this->statusResultService = StatusResultService::STATUS_SUCCESS;
		}
		catch( \Exception $ex ) {
			$this->resultMessage = $ex->getMessage();
			$this->statusResultService = StatusResultService::STATUS_FAILED;
		}
		
		$this->serviceResult->setMessage( $this->resultMessage );
		$this->serviceResult->setStatusResult( $this->statusResultService );
		return $this->serviceResult;
	}

	public function saveState(Mappeable $stateDTO) {
		try {
			$this->serviceResult = new ServiceResult();
			
			$this->validateDTO( $stateDTO, UpdateEnum::IS_NOT_UPDATE );
			if( parent::save( $stateDTO ) > 0 ) {
				$this->resultMessage = "El estado se ha guardado correctamente";
				$this->statusResultService = StatusResultService::STATUS_SUCCESS;
			}
			else {
				$this->resultMessage = "No se pudo guardar el estado";
				$this->statusResultService = StatusResultService::STATUS_FAILED;
			}
		}
		catch( \Exception $ex ) {
			$this->resultMessage = $ex->getMessage();
			$this->statusResultService = StatusResultService::STATUS_FAILED;
		}
		
		$this->serviceResult->setMessage( $this->resultMessage );
		$this->serviceResult->setStatusResult( $this->statusResultService );
		return $this->serviceResult;
	}

	public function update(Mappeable $stateDTO) {
		try {
			$this->serviceResult = new ServiceResult();
			
			$this->validateDTO( $stateDTO, UpdateEnum::IS_UPDATE );
			if( parent::update( $stateDTO ) ) {
				$this->resultMessage = "El estado se ha actualizado correctamente";
				$this->statusResultService = StatusResultService::STATUS_SUCCESS;
			}
			else {
				$this->resultMessage = "No se pudo actualizar el estado";;
				$this->statusResultService = StatusResultService::STATUS_FAILED;
			}
		}
		catch( \Exception $ex ) {
			$this->resultMessage = $ex->getMessage();
			$this->statusResultService = StatusResultService::STATUS_FAILED;
		}
		
		$this->serviceResult->setMessage( $this->resultMessage );
		$this->serviceResult->setStatusResult( $this->statusResultService );
		return $this->serviceResult;
	}

	public function delete(Mappeable $stateDTO) {
		try {
			$this->serviceResult = new ServiceResult();
			
			if( parent::delete( $stateDTO ) ) {
				$this->resultMessage = "El estado se ha eliminado correctamente";
				$this->statusResultService = StatusResultService::STATUS_SUCCESS;
			}
			else {
				$this->resultMessage = "No se pudo eliminar el estado";;
				$this->statusResultService = StatusResultService::STATUS_FAILED;
			}
		}
		catch( \Exception $ex ) {
			$this->resultMessage = $ex->getMessage();
			$this->statusResultService = StatusResultService::STATUS_FAILED;
		}
		
		$this->serviceResult->setMessage( $this->resultMessage );
		$this->serviceResult->setStatusResult( $this->statusResultService );
		return $this->serviceResult;
	}
	
	//@Override
	public function validateDTO(Mappeable $dto, $update ) {
		$stateDto = $this->sanitizeDTO( $dto );
		
		//Validate empty fields
		if( Utils::isEmpty( $stateDto->getName() ) ) {
			throw new ValidationException( "El campo nombre es requerido" );
		}
		if( Utils::isNull( $stateDto->getShortName() ) || Utils::isEmpty( $stateDto->getShortName() ) ) {
			throw new ValidationException( "El campo abreviatura es requerido" );
		}

		//Validate fields length
		$lengthCheck = Utils::lengthCheck( $stateDto->getName(), self::$FIELD_MIN_LENGTH, self::$NAME_FIELD_MAX_LENGTH ); 
		$exceptionMessage = "El campo nombre es demasiado" + (( $lengthCheck < 0 ) ? " corto" : " largo");
		if( $lengthCheck != 0 ) {
			throw new ValidationException( $exceptionMessage );
		}
		
		$lengthCheck = Utils::lengthCheck( $stateDto->getShortName(), self::$FIELD_MIN_LENGTH, self::$SHORT_NAME_FIELD_MAX_LENGTH );
		$exceptionMessage = "El campo abreviatura es demasiado" + (( $lengthCheck < 0 ) ? " corto" : " largo");
		if( $lengthCheck != 0 ) {
			throw new ValidationException( $exceptionMessage );
		}
		
		//Validate repeated
		$idFound = parent::findByName( $stateDto );
		if( $idFound > 0 ) {
			$exceptionMessage = "Ya existe un estado con el mismo nombre";
			if( $update == UpdateEnum::IS_NOT_UPDATE ) {
				throw new ValidationException( $exceptionMessage );
			}
			if( $update == UpdateEnum::IS_UPDATE && ( $idFound != $stateDto->getId() ) ) {
				throw new ValidationException( $exceptionMessage );
			}
		}
		
		$idFound = parent::findByShortName( $stateDto );
		if( $idFound > 0 ) {
			$exceptionMessage = "Ya existe un estado con la misma abreviatura";
			if( $update == UpdateEnum::IS_NOT_UPDATE ) {
				throw new ValidationException( $exceptionMessage );
			}
			if( $update == UpdateEnum::IS_UPDATE && ( $idFound != $stateDto->getId() ) ) {
				throw new ValidationException( $exceptionMessage );
			}
		}
	}
	
	//@Override
	public function sanitizeDTO(Mappeable $stateDto) {
		$stateDto->setName( Utils::toUpperCase( $stateDto->getName() ) );
		$stateDto->setShortName( Utils::toUpperCase( $stateDto->getShortName() ) );
		
		return $stateDto;
	}
}
?>