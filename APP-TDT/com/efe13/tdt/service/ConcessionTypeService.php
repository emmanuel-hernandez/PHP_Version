<?php
namespace com\efe13\tdt\service;

require_once( getMVCPath( ACTIVE_ENUM_PATH ) );
require_once( getMVCPath( UPDATE_ENUM_PATH ) );
require_once( getMVCPath( VALIDATION_EXCEPTION_PATH ) );
require_once( getMVCPath( DAO_EXCEPTION_PATH ) );
require_once( getMVCPath( DTO_API_PATH ) );
require_once( getMVCPath( ENTITY_API_PATH ) );
require_once( getMVCPath( QUERY_HELPER_PATH ) );
require_once( getMVCPath( SERVICE_API_PATH ) );
require_once( getMVCPath( UTILS_PATH ) );
require_once( getAppPath( CONCESSION_TYPE_DAO_PATH ) );
require_once( getAppPath( MAPPEABLE_PATH ) );
require_once( getAppPath( CONCESSION_TYPE_PATH ) );

use com\efe13\mvc\commons\api\enums\ActiveEnum;
use com\efe13\mvc\commons\api\enums\UpdateEnum;
use com\efe13\mvc\commons\api\exception\ValidationException;
use com\efe13\mvc\commons\api\exception\DAOException;
use com\efe13\mvc\commons\api\util\Utils;
use com\efe13\mvc\commons\api\interfaces\Mappeable;
use com\efe13\mvc\model\api\impl\entity\EntityAPI;
use com\efe13\mvc\model\api\impl\QueryHelper;
use com\efe13\mvc\service\api\impl\ServiceAPI;
use com\efe13\tdt\dao\ConcessionTypeDAO;
use com\efe13\tdt\model\dto\ConcessionTypeDTO;
use com\efe13\tdt\model\entity\ConcessionType;

class ConcessionTypeService extends ServiceAPI {
	
	private static $CONCESSION_TYPE_DAO;
	
	public function __construct() {
		self::$CONCESSION_TYPE_DAO = new ConcessionTypeDAO();
	}

	//@Override
	public function getTableCount() {
		try {
			return self::$CONCESSION_TYPE_DAO->getTableCount();
		}
		catch( \Exception $ex ) {
			throw $ex;
		}
	}
	
	//@Override
	public function getById(Mappeable $dto) {
		$entity = new ConcessionType();
		
		try {
			$entity = $this->map( $dto, $entity );
			$entity = self::$CONCESSION_TYPE_DAO->getById( $entity );
		}
		catch( \Exception $ex ) {
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
			$entities = self::$CONCESSION_TYPE_DAO->getAll( $queryHelper );
			if( count( $entities ) > 0 ) {
				$dtos = array();
				foreach( $entities as $entity ) {
					$dtos[] = $this->map( $entity, new ConcessionTypeDTO() );
				}
			}
		}
		catch( DAOException $ex ) {
			throw $ex;
		}
		
		return $dtos;
	}

	public function findByName(Mappeable $concessionTypeDTO) {
		$entity = new ConcessionType();
		$id = 0;
		
		try {
			$entity = $this->map( $concessionTypeDTO, $entity );
			$id = self::$CONCESSION_TYPE_DAO->findByName( $entity );
		}
		catch( DAOException $ex ) {
			throw $ex;
		}
		
		return $id;
	}
	
	//@Override
	public function save(Mappeable $concessionTypeDTO) {
		try {
			$concessionType = $this->map( $concessionTypeDTO, new ConcessionType() );
			return ( self::$CONCESSION_TYPE_DAO->save( $concessionType ) );
		}
		catch( DAOException $ex ) {
			throw $ex;
		}
	}

	//@Override
	public function update(Mappeable $concessionTypeDTO) {
		try {
			$concessionType = ($this->map( $concessionTypeDTO, new ConcessionType() ) );
			return ( self::$CONCESSION_TYPE_DAO->update( $concessionType ) );
		}
		catch( DAOException $ex ) {
			throw $ex;
		}
	}

	//@Override
	public function delete(Mappeable $concessionTypeDTO) {
		try {
			$concessionTypeDTO->setActive( ActiveEnum::INACTIVE );
			return ( $this->update( $concessionTypeDTO ) );
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