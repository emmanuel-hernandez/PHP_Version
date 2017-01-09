<?php
namespace com\efe13\tdt\service\impl;

require_once( getMVCPath( UPDATE_ENUM_PATH ) );

use com\efe13\mvc\commons\api\enums\UpdateEnum;
use com\efe13\mvc\commons\api\util\Utils;
use com\efe13\mvc\model\api\impl\dto\DTOAPI;
use com\efe13\mvc\model\api\impl\helper\QueryHelper;
use com\efe13\tdt\enums\StatusResultService;
use com\efe13\tdt\helper\ServiceResult;
use com\efe13\tdt\model\dto\ConcessionTypeDTO;
use com\efe13\tdt\service\ConcessionTypeService;

class ConcessionTypeServiceImpl extends ConcessionTypeService {
	
	private $serviceResult = null;
	private $resultMessage;
	private $statusResultService;
	
	private static $FIELD_MIN_LENGTH = 3;
	private static $TYPE_FIELD_MAX_LENGTH = 25;
	private static $DESCRIPTION_FIELD_MAX_LENGTH = 40;
	
	public function getById(ConcessionTypeDTO $concessionTypeDTO) {
		try {
			$this->serviceResult = new ServiceResult();
			
			$concessionTypeDTO = super\getById( $concessionTypeDTO );
			if( $concessionTypeDTO != null ) {
				$this->resultMessage = null;
				$this->serviceResult->setObject( $concessionTypeDTO );
				$this->statusResultService = StatusResultService::STATUS_SUCCESS;
			}
			else {
				$this->resultMessage = "La concesión especificada no existe";
				$this->statusResultService = StatusResultService::STATUS_FAILED;
			}
		}
		catch( DAOException $ex ) {
			$this->resultMessage = ex\getMessage();
			$this->statusResultService = StatusResultService::STATUS_FAILED;
		}
		
		$this->serviceResult->setMessage( $this->resultMessage );
		$this->serviceResult->setStatusResult( $this->statusResultService );
		return $this->serviceResult;
	}

	public function listAll(QueryHelper $queryHelper) {
		try {
			$this->serviceResult = new ServiceResult();
			$this->resultMessage = null;
			
			$dtos = array();
			foreach( parent::getAll( $queryHelper ) as $dto ) {
				$dtos[] = $dto;
			}
			
			$defaultConcessionType = new ConcessionTypeDTO();
			$defaultConcessionType->setId( -1 );
			$defaultConcessionType->setType( "Seleccionar..." );
			array_unshift( $dtos, $defaultConcessionType );
			
			$this->serviceResult->setCollection( $dtos );
			if( !Utils::isNull( $queryHelper ) ) {
				$this->serviceResult->setQueryHelper( getQueryHelper( getTableCount(), $queryHelper ) );
			}
			$this->statusResultService = StatusResultService::STATUS_SUCCESS;
		}
		catch( DAOException $ex ) {
			$this->resultMessage = $ex->getMessage();
			$this->statusResultService = StatusResultService::STATUS_FAILED;
		}
		
		$this->serviceResult->setMessage( $this->resultMessage );
		$this->serviceResult->setStatusResult( $this->statusResultService );
		return $this->serviceResult;
	}

	public function saveConcessionType(ConcessionTypeDTO $concessionTypeDTO) {
		try {
			$this->serviceResult = new ServiceResult();
			
			$this->validateDTO( $concessionTypeDTO, UpdateEnum::IS_NOT_UPDATE );
			if( parent::save( $concessionTypeDTO ) > 0 ) {
				$this->resultMessage = "La concesión se ha guardado correctamente";
				$this->statusResultService = StatusResultService::STATUS_SUCCESS;
			}
			else {
				$this->resultMessage = "No se pudo guardar la concesión";
				$this->statusResultService = StatusResultService::STATUS_FAILED;
			}
		}
		catch( DAOException $ex ) {
			$this->resultMessage = $ex->getMessage();
			$this->statusResultService = StatusResultService::STATUS_FAILED;
		}
		
		$this->serviceResult->setMessage( $this->resultMessage );
		$this->serviceResult->setStatusResult( $this->statusResultService );
		return $this->serviceResult;
	}

	public function update(ConcessionTypeDTO $concessionTypeDTO) {
		try {
			$this->serviceResult = new ServiceResult();
			
			$this->validateDTO( $concessionTypeDTO, UpdateEnum::IS_UPDATE );
			if( parent::update( $concessionTypeDTO ) ) {
				$this->resultMessage = "La concesión se ha actualizado correctamente";
				$this->statusResultService = StatusResultService::STATUS_SUCCESS;
			}
			else {
				$this->resultMessage = "No se pudo actualizar la concesión";;
				$this->statusResultService = StatusResultService::STATUS_FAILED;
			}
		}
		catch( DAOException $ex ) {
			$this->resultMessage = $ex->getMessage();
			$this->statusResultService = StatusResultService::STATUS_FAILED;
		}
		
		$this->serviceResult->setMessage( $this->resultMessage );
		$this->serviceResult->setStatusResult( $this->statusResultService );
		return $this->serviceResult;
	}

	public function delete(ConcessionTypeDTO $concessionTypeDTO) {
		try {
			$this->serviceResult = new ServiceResult();
			
			if( parent::delete( $concessionTypeDTO ) ) {
				$this->resultMessage = "El estado se ha eliminado correctamente";
				$this->statusResultService = StatusResultService::STATUS_SUCCESS;
			}
			else {
				$this->resultMessage = "No se pudo eliminar el estado";;
				$this->statusResultService = StatusResultService::STATUS_FAILED;
			}
		}
		catch( DAOException $ex ) {
			$this->resultMessage = $ex->getMessage();
			$this->statusResultService = StatusResultService::STATUS_FAILED;
		}
		
		$this->serviceResult->setMessage( $this->resultMessage );
		$this->serviceResult->setStatusResult( $this->statusResultService );
		return $this->serviceResult;
	}

	//@Override
	public function validateDTO(DTOAPI $dto, $update) {
		$concessionTypeDto =  $this->sanitizeDTO( $dto );

		//Validate empty fields
		if( Utils::isEmpty( $concessionTypeDto->getType() ) ) {
			throw new ValidationException( "El campo tipo es requerido" );
		}
		if( Utils::isEmpty( $concessionTypeDto->getDescription() ) ) {
			throw new ValidationException( "El campo descripción es requerido" );
		}
		
		//Validate fields length
		$lengthCheck = Utils::lengthCheck( $concessionTypeDto->getType(), self::$FIELD_MIN_LENGTH,  self::$TYPE_FIELD_MAX_LENGTH ); 
		$exceptionMessage = "El campo nombre es demasiado" + (( $lengthCheck < 0 ) ? " corto" : " largo");
		if( $lengthCheck != 0 ) {
			throw new ValidationException( $exceptionMessage );
		}
		
		$lengthCheck = Utils::lengthCheck( $concessionTypeDto->getDescription(), self::$FIELD_MIN_LENGTH, self::$DESCRIPTION_FIELD_MAX_LENGTH );
		$exceptionMessage = "El campo descripción es demasiado" + (( lengthCheck < 0 ) ? " corto" : " largo");
		if( $lengthCheck != 0 ) {
			throw new ValidationException( $exceptionMessage );
		}
		
		$idFound = parent::findByName( $concessionTypeDto );
		if( $idFound > 0 ) {
			$exceptionMessage = "Ya existe un tipo de concesión con el mismo nombre";
			if( $update == UpdateEnum::IS_NOT_UPDATE ) {
				throw new ValidationException( $exceptionMessage );
			}
			if( $update == UpdateEnum::IS_UPDATE && ( $idFound != $concessionTypeDto->getId() ) ) {
				throw new ValidationException( $exceptionMessage );
			}
		}
	}

	//@Override
	public function sanitizeDTO(DTOAPI $dto) {
		$concessionTypeDTO = $dto;

		$concessionTypeDTO->setType( Utils::toUpperCase( $concessionTypeDTO->getType() ) );
		$concessionTypeDTO->setDescription( Utils::toUpperCase( $concessionTypeDTO->getDescription() ) );
		
		return $concessionTypeDTO;
	}
}
?>