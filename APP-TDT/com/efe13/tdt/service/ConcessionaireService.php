<?php
namespace com\efe13\tdt\service;

require_once( getMVCPath( ACTIVE_ENUM_PATH ) );
require_once( getMVCPath( UPDATE_ENUM_PATH ) );
require_once( getMVCPath( VALIDATION_EXCEPTION_PATH ) );
require_once( getMVCPath( DAO_EXCEPTION_PATH ) );
require_once( getMVCPath( DTO_API_PATH ) );
require_once( getMVCPath( MAPPEABLE_PATH ) );
require_once( getMVCPath( ENTITY_API_PATH ) );
require_once( getMVCPath( QUERY_HELPER_PATH ) );
require_once( getMVCPath( SERVICE_API_PATH ) );
require_once( getMVCPath( UTILS_PATH ) );
require_once( getAppPath( CONCESSIONAIRE_DAO_PATH ) );
require_once( getAppPath( CONCESSIONAIRE_DTO_PATH ) );
require_once( getAppPath( CONCESSIONAIRE_PATH ) );

use com\efe13\mvc\commons\api\enums\ActiveEnum;
use com\efe13\mvc\commons\api\enums\UpdateEnum;
use com\efe13\mvc\commons\api\exception\ValidationException;
use com\efe13\mvc\commons\api\exception\DAOException;
use com\efe13\mvc\model\api\impl\dto\DTOAPI;
use com\efe13\mvc\commons\api\interfaces\Mappeable;
use com\efe13\mvc\model\api\impl\entity\EntityAPI;
use com\efe13\mvc\model\api\impl\QueryHelper;
use com\efe13\mvc\service\api\impl\ServiceAPI;
use com\efe13\mvc\commons\api\util\Utils;
use com\efe13\tdt\dao\ConcessionaireDAO;
use com\efe13\tdt\model\dto\ConcessionaireDTO;
use com\efe13\tdt\model\entity\Concessionaire;

class ConcessionaireService extends ServiceAPI {
	
	private static $CONCESSIONAIRE_DAO;

	public function __construct() {
		self::$CONCESSIONAIRE_DAO = new ConcessionaireDAO();
	}
	
	//@Override
	public function getById(Mappeable $dto) {
		$entity = new Concessionaire();
		
		try {
			$entity = $this->map( $dto, $entity );
			$entity = self::$CONCESSIONAIRE_DAO->getById( $entity );
		}
		catch( \Exception $ex ) {
			throw $ex;
		}
		
		if( Utils::isNull( $entity ) ) {
			return null;
		}
		
		return $this->map( $entity, $dto );	
	}

	//@Override
	public function getAll( QueryHelper $queryHelper = null ) {
		$dtos = array();
		
		try {
			$entities = self::$CONCESSIONAIRE_DAO->getAll( $queryHelper );
			if( count( $entities ) > 0 ) {				
				foreach( $entities as $entity ) {
					$dtos[] = $this->map( $entity, new ConcessionaireDTO() );
				}			
			}
		}
		catch( \Exception $ex ) {
			throw $ex;
		}
		
		return $dtos;
	}

	public function findByName(Mappeable $concessionaireDTO) {
		$entity = new Concessionaire();
		$id = 0;
		
		try {
			$entity = $this->map( $concessionaireDTO, $entity );
			$id = self::$CONCESSIONAIRE_DAO->findByName( $entity );
		}
		catch( \Exception $ex ) {
			throw $ex;
		}
		
		return $id;
	}
	
	//@Override
	public function save(Mappeable $concessionaireDTO) {
		try {
			$concessionaire = $this->map( $concessionaireDTO, new Concessionaire() );
			return self::$CONCESSIONAIRE_DAO->save( $concessionaire );
		}
		catch( \Exception $ex ) {
			throw $ex;
		}
	}

	//@Override
	public function update(Mappeable $concessionaireDTO) {
		try {
			$concessionaire = $this->map( $concessionaireDTO, new Concessionaire() );
			return self::$CONCESSIONAIRE_DAO->update( $concessionaire );
		}
		catch( \Exception $ex ) {
			throw $ex;
		}
	}

	//@Override
	public function delete(Mappeable $concessionaireDTO) {
		try {
			$concessionaireDTO->setActive( ActiveEnum::INACTIVE );
			return $this->update( $concessionaireDTO );
		}
		catch( \Exception $ex ) {
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