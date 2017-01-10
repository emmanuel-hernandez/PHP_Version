<?php
namespace com\efe13\mvc\dao\api\impl\util;

require_once( dirname( dirname( dirname( dirname(__DIR__) ) ) ) . '/commons/api/util/Utils.php' );
require_once( 'HibernateUtil.php' );

use com\efe13\mvc\commons\api\util\Utils;
use com\efe13\mvc\dao\api\impl\util\HibernateUtil;

final class Projections {
	
	private $criteriaClass = null;

	public static function id($criteriaClass) {
		return HibernateUtil::getColumnIdName($criteriaClass);
	}
}
?>