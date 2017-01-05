<?php
namespace com\efe13\mvc\commons\api\util;

final class Utils {
	
	const ID_COLUMN_NAME = "id";
	
	private function __construct() {
	}
	
	public static function isNegative($number) {
		if( !is_numeric( $number ) ) {
			return true;
		}
		
		return $number < 0;
	}
	
	public static function isNull($object) {
		return $object == null;
	}
	
	public static function isEmpty(string $str) {
		return self::isNull( $str ) || strlen( trim( $str ) ) == 0;
	}
	
	public static function lengthCheck(string $str, int $minLength, int $maxLength) {
		if( self::isEmpty( $str ) || strlen( $str ) < $minLength ) {
			return -1;
		}
		else if( strlen( $str ) > $maxLength ) {
			return 1;
		}
		
		return 0;
	}

	public static function toUpperCase(string $str) {
		if( self::isEmpty( $str ) ) {
			return $str;
		}
		
		return strtoupper( $str );
	}
}
?>