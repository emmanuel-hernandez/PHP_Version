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
require_once( getAppPath( CONCESSIONAIRE_DTO_PATH ) );
require_once( getAppPath( CONCESSIONAIRE_SERVICE_PATH ) );

use com\efe13\mvc\commons\api\enums\UpdateEnum;
use com\efe13\mvc\commons\api\util\Utils;
use com\efe13\mvc\commons\api\interfaces\Mappeable;
use com\efe13\mvc\commons\api\exception\ValidationException;
use com\efe13\mvc\model\api\impl\dto\DTOAPI;
use com\efe13\mvc\model\api\impl\helper\QueryHelper;
use com\efe13\tdt\enums\StatusResultService;
use com\efe13\tdt\helper\ServiceResult;
use com\efe13\tdt\model\dto\ConcessionaireDTO;
use com\efe13\tdt\service\ConcessionaireService;

class ConcessionaireServiceImpl extends ConcessionaireService {
	
	private $serviceResult = null;
	private $resultMessage;
	private $statusResultService;
	
	private static $FIELD_MIN_LENGTH = 3;
	private static $NAME_FIELD_MAX_LENGTH = 100;
	
	public function getById(Mappeable $concessionaireDTO) {
		try {
			$this->serviceResult = new ServiceResult();
			
			$concessionaireDTO = parent::getById( $concessionaireDTO );
			if( $concessionaireDTO != null ) {
				$this->resultMessage = null;
				$this->serviceResult->setObject( $concessionaireDTO );
				$this->statusResultService = StatusResultService::STATUS_SUCCESS;
			}
			else {
				$this->resultMessage = "La concesionaria especificada no existe";
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

	public function listAll(QueryHelper $queryHelper = null) {
		try {
			$this->serviceResult = new ServiceResult();
			
			$dtos = array();
			foreach( parent::getAll( $queryHelper ) as $dto ) {
				$dtos[] = $dto;
			}
			
			$defaultConcessionaire = new ConcessionaireDTO();
			$defaultConcessionaire->setId( -1 );
			$defaultConcessionaire->setName( "Seleccionar..." );
			array_unshift( $dtos, $defaultConcessionaire );
			
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

	public function saveConcessionaire(Mappeable $concessionaireDTO) {
		try {
			$this->serviceResult = new ServiceResult();
			
			$this->validateDTO( $concessionaireDTO, UpdateEnum::IS_NOT_UPDATE );
			if( parent::save( $concessionaireDTO ) > 0 ) {
				$this->resultMessage = "La concesionaria se ha guardado correctamente";
				$this->statusResultService = StatusResultService::STATUS_SUCCESS;
			}
			else {
				$this->resultMessage = "No se pudo guardar la concesionaria";
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

	public function update(Mappeable $concessionaireDTO) {
		try {
			$this->serviceResult = new ServiceResult();
			
			$this->validateDTO( $concessionaireDTO, UpdateEnum::IS_UPDATE );
			if( parent::update( $concessionaireDTO ) ) {
				$this->resultMessage = "La concesionaria se ha actualizado correctamente";
				$this->statusResultService = StatusResultService::STATUS_SUCCESS;
			}
			else {
				$this->resultMessage = "No se pudo actualizar la concesionaria";;
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

	public function delete(Mappeable $concessionaireDTO) {
		try {
			$this->serviceResult = new ServiceResult();
			
			if( parent::delete( $concessionaireDTO ) ) {
				$this->resultMessage = "La concesionaria se ha eliminado correctamente";
				$this->statusResultService = StatusResultService::STATUS_SUCCESS;
			}
			else {
				$this->resultMessage = "No se pudo eliminar la concesionaria";;
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
	public function validateDTO(Mappeable $dto, $update ) {
		$concessionaireDto = $this->sanitizeDTO( $dto );

		//Validate empty fields
		if( Utils::isEmpty( $concessionaireDto->getName() ) ) {
			throw new ValidationException( "El campo nombre es requerido" );
		}
		
		//Validate fields length
		$lengthCheck = Utils::lengthCheck( $concessionaireDto->getName(), self::$FIELD_MIN_LENGTH, self::$NAME_FIELD_MAX_LENGTH ); 
		$exceptionMessage = "El campo nombre es demasiado" + (( $lengthCheck < 0 ) ? " corto" : " largo");
		if( $lengthCheck != 0 ) {
			throw new ValidationException( $exceptionMessage );
		}
		
		//Validate repeated
		$idFound = parent::findByName( $concessionaireDto );
		if( $idFound > 0 ) {
			$exceptionMessage = "Ya existe una concesionaria con el mismo nombre";
			if( $update == UpdateEnum::IS_NOT_UPDATE ) {
				throw new ValidationException( $exceptionMessage );
			}
			if( $update == UpdateEnum::IS_UPDATE && ( $idFound != $concessionaireDto->getId() ) ) {
				throw new ValidationException( $exceptionMessage );
			}
		}
	}

	//@Override
	public function sanitizeDTO(Mappeable $dto) {
		$concessionaireDTO = $dto;

		$concessionaireDTO->setName( Utils::toUpperCase( $concessionaireDTO->getName() ) );
		
		return $concessionaireDTO;
	}
}
?>