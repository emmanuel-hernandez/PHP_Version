<?php
namespace com\efe13\tdt\dao;

require_once( getMVCPath( ACTIVE_ENUM_PATH ) );
require_once( getMVCPath( UTILS_PATH ) );
require_once( getMVCPath( CRITERIA_PATH ) );
require_once( getMVCPath( HIBERNATE_EXCEPTION_PATH ) );
require_once( getMVCPath( PROJECTIONS_PATH ) );
require_once( getMVCPath( CRITERIA_PATH ) );
require_once( getMVCPath( RESTRICTIONS_PATH ) );
require_once( getMVCPath( DAO_API_PATH ) );
require_once( getAppPath( CONCESSIONAIRE_PATH ) );
require_once( getAppPath( APP_CONSTANT_PATH ) );

use com\efe13\mvc\dao\api\impl\util\Criteria;
use com\efe13\mvc\dao\api\impl\util\Projections;
use com\efe13\mvc\dao\api\impl\util\Restrictions;

use com\efe13\mvc\commons\api\enums\ActiveEnum;
use com\efe13\mvc\commons\api\util\Utils;
use com\efe13\mvc\dao\api\impl\DAOAPI;
use com\efe13\tdt\model\entity\Concessionaire;
use com\efe13\tdt\utils\AppConstant;

class ConcessionaireDAO extends DAOAPI {
	
	public function __construct() {
		parent::__construct( new Concessionaire(), AppConstant::ACTIVE_COLUMN_NAME, ActiveEnum::ACTIVE );
	}
	
	public function findByName( Concessionaire $concessionaire ) {
		try {
			$criteria = $this->getCriteria()
				->setProjection( Projections::id( $concessionaire ) )
				->add( Restrictions::eq( "name", $concessionaire->getName() ) )
				->add( Restrictions::eq( "active", ActiveEnum::ACTIVE ) );

			$object = $criteria->uniqueResult();

			if( !Utils::isNull( $object ) ) {
				return $object;
			}
			
			return 0;
		}
		finally {
			$this->closeSession();
		}
	}
}
?>