<?php
namespace com\efe13\mvc\dao\api\impl\util;

require_once( dirname( dirname( dirname( dirname(__DIR__) ) ) ) . '/commons/api/util/Utils.php' );
require_once( 'HibernateUtil.php' );

use com\efe13\mvc\commons\api\util\Utils;
use com\efe13\mvc\dao\api\impl\util\HibernateUtil;

final class Restrictions {

	public static function eq($column, $value) {
		$value = Utils::isNull( $value ) ? 'null' : $value;
		$value = is_string( $value ) ? sprintf( "'%s'", $value ) : $value;
		return sprintf( '%s = %s', $column, $value );
	}

	public static function idEq($criteriaClass, $value) {
		$value = Utils::isNull( $value ) ? 'null' : $value;

		return sprintf( '%s = %s', HibernateUtil::getColumnIdName($criteriaClass), $value );
	}
}
?>