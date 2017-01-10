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
require_once( getAppPath( STATE_PATH ) );
require_once( getAppPath( APP_CONSTANT_PATH ) );

use com\efe13\mvc\commons\api\enums\ActiveEnum;
use com\efe13\mvc\commons\api\exception\HibernateException;
use com\efe13\mvc\commons\api\util\Utils;
use com\efe13\mvc\dao\api\impl\util\Criteria;
use com\efe13\mvc\dao\api\impl\util\Projections;
use com\efe13\mvc\dao\api\impl\util\Restrictions;

use com\efe13\mvc\dao\api\impl\DAOAPI;
use com\efe13\tdt\model\entity\Population;
use com\efe13\tdt\utils\AppConstant;

public class PopulationDAO extends DAOAPI {

	public function __construct() {
		parent::__construct( new Population(), AppConstant::ACTIVE_COLUMN_NAME, ActiveEnum::ACTIVE );
	}

	public function findByNameAndState(Population $population) {
		try {
			$criteria = $this->getCriteria( "p" )
				->setProjection( Projections::id( $population ) )
				->createAlias( "state", "s", JoinType::INNER_JOIN )
				->add( Restrictions::eq( "p.name", $population->getName() ) )
				->add( Restrictions::eq( "s.id", $population->getState()->getId() ) )
				->add( Restrictions::eq( "p.active", ActiveEnum::ACTIVE ) );

			$object = $criteria->uniqueResult();
			
			if( !Utils::isNull( $object  ) ) {
				return $object;
			}
			
			return 0;
		}
		finally {
			$this->closeSession();
		}
	}
	
	public function getByState(State $state) {
		try {
			$criteria = $this->getCriteria( "p" )
				->createAlias( "state", "s", JoinType::INNER_JOIN )
				->add( Restrictions::eq( "s.id", $state->getId() ) )
				->add( Restrictions::eq( "p.active", ActiveEnum::ACTIVE ) );

			return $criteria->list();
		}
		finally {
			$this->closeSession();
		}
	}
}
?>