<?php
namespace com\efe13\tdt\service\impl;

require_once( getMVCPath( UPDATE_ENUM_PATH ) );
require_once( getMVCPath( UTILS_PATH ) );
require_once( getMVCPath( MAPPEABLE_PATH ) );
require_once( getMVCPath( DTO_API_PATH ) );
require_once( getMVCPath( QUERY_HELPER_PATH ) );
require_once( getMVCPath( VALIDATION_EXCEPTION_PATH ) );
require_once( getAppPath( STATUS_RESULT_SERVICE_PATH ) );
require_once( getAppPath( SERVICE_RESULT_PATH ) );
require_once( getAppPath( POPULATION_DTO_PATH ) );
require_once( getAppPath( POPULATION_SERVICE_PATH ) );

use com\efe13\mvc\commons\api\enums\UpdateEnum;
use com\efe13\mvc\commons\api\util\Utils;
use com\efe13\mvc\commons\api\interfaces\Mappeable;
use com\efe13\mvc\model\api\impl\dto\DTOAPI;
use com\efe13\mvc\model\api\impl\helper\QueryHelper;
use com\efe13\mvc\commons\api\exception\ValidationException;
use com\efe13\tdt\enums\StatusResultService;
use com\efe13\tdt\helper\ServiceResult;
use com\efe13\tdt\model\dto\PopulationDTO;
use com\efe13\tdt\service\PopulationService;

class PopulationServiceImpl extends PopulationService {
	
	private $serviceResult = null;
	private $resultMessage;
	private $statusResultService;
	
	private static $FIELD_MIN_LENGTH = 3;
	private static $NAME_FIELD_MAX_LENGTH = 50;
	
	public function getById(Mappeable $populationDTO) {
		try {
			$this->serviceResult = new ServiceResult();
			
			$populationDTO = parent::getById( $populationDTO );
			if( !Utils::isNull( $populationDTO ) ) {
				$this->resultMessage = null;
				$this->serviceResult->setObject( $populationDTO );
				$this->statusResultService = StatusResultService::STATUS_SUCCESS;
			}
			else {
				$this->resultMessage = "La población especificada no existe";
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
			
			$defaultPopulation = new PopulationDTO();
			$defaultPopulation->setId( -1 );
			$defaultPopulation->setName( "Seleccionar..." );
			array_unshift( $dtos, $defaultPopulation );
			
			$this->serviceResult->setCollection( $dtos );
			if( !Utils::isNull( $queryHelper ) ) {
				$this->serviceResult->setQueryHelper( $this->getQueryHelper( getTableCount(), $queryHelper ) );
			}
			
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
	
	public function getByState(Mappeable $stateDTO) {
		try {
			$this->serviceResult = new ServiceResult();

			$dtos = array();
			foreach( parent::getByState( $stateDTO ) as $dto ) {
				$dtos[] = $dto;
			}
			
			$defaultPopulation = new PopulationDTO();
			$defaultPopulation->setId( -1 );
			$defaultPopulation->setName( "Seleccionar..." );
			array_unshift( $dtos, $defaultPopulation );
			
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

	public function savePopulation(Mappeable $populationDTO) {
		try {
			$this->serviceResult = new ServiceResult();
			
			$this->validateDTO( $populationDTO, UpdateEnum::IS_NOT_UPDATE );

			if( parent::save( $populationDTO ) > 0 ) {
				$this->resultMessage = "La población se ha guardado correctamente";
				$this->statusResultService = StatusResultService::STATUS_SUCCESS;
			}
			else {
				$this->resultMessage = "No se pudo guardar la población";
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

	public function update(Mappeable $populationDTO) {
		try {
			$this->serviceResult = new ServiceResult();
			
			$this->validateDTO( $populationDTO, UpdateEnum::IS_UPDATE );
			if( parent::update( $populationDTO ) ) {
				$this->resultMessage = "La población se ha actualizado correctamente";
				$this->statusResultService = StatusResultService::STATUS_SUCCESS;
			}
			else {
				$this->resultMessage = "No se pudo actualizar la población";;
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

	public function delete(Mappeable $populationDTO) {
		try {
			$this->serviceResult = new ServiceResult();
			
			if( parent::delete( $populationDTO ) ) {
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
		$populationDto = $this->sanitizeDTO( $dto );
		
		//Validate empty fields
		if( Utils::isEmpty( $populationDto->getName() ) ) {
			throw new ValidationException( "El campo nombre es requerido" );
		}
		if( Utils::isNull( $populationDto->getState() ) || Utils::isNegative( $populationDto->getState()->getId() ) ) {
			throw new ValidationException( "El campo estado es requerido" );
		}
		
		//Validate fields length
		$lengthCheck = Utils::lengthCheck( $populationDto->getName(), self::$FIELD_MIN_LENGTH, self::$NAME_FIELD_MAX_LENGTH ); 
		$exceptionMessage = "El campo nombre es demasiado" + (( $lengthCheck < 0 ) ? " corto" : " largo");
		if( $lengthCheck != 0 ) {
			throw new ValidationException( $exceptionMessage );
		}
		
		//Validate repeated
		$idFound = parent::findByNameAndState( $populationDto );
		if( $idFound > 0 ) {
			$exceptionMessage = "Ya existe una población con el mismo nombre en el mismo estado";
			if( $update == UpdateEnum::IS_NOT_UPDATE ) {
				throw new ValidationException( $exceptionMessage );
			}
			if( $update == UpdateEnum::IS_UPDATE && ( $idFound != $populationDto->getId() ) ) {
				throw new ValidationException( $exceptionMessage );
			}
		}
	}
	
	//@Override
	public function sanitizeDTO(Mappeable $populationDTO) {
		$populationDTO->setName( Utils::toUpperCase( $populationDTO->getName() ) );
		
		return $populationDTO;
	}
}
?>