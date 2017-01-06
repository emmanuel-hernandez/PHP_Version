<?php
namespace com\efe13\mvc\dao\api\impl\util;

final class Restrictions {
	
	public static function eq($column, $value) {
		return sprintf( '%s = %s', $column, $value );
	}
}
?>