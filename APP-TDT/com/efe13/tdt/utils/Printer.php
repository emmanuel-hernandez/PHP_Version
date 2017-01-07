<?php
namespace com\efe13\tdt\utils;

require_once( getAppPath( SERVICE_RESULT_PATH ) );

use com\efe13\tdt\helper\ServiceResult;

class Printer {
	public static $PRINT_FORMAT = 'json';

	public function __construct($format = 'json') {
	}

	public function output($data) {
		$output = '';

		if( is_object( $data ) ) {
			if( $data instanceof ServiceResult ) {
				$output = $this->printServiceResult( $data );
			}
		}

		die( json_encode( $output, JSON_PRETTY_PRINT ) );
	}

	private function printServiceResult( ServiceResult $serviceResult ) {
		return $this->convertObjectToArray( $serviceResult );
	}

	private function convertObjectToArray( $object ) {
		$methods = get_class_methods( $object );

		if( count( $methods ) < 0 ) {
			return array();
		}

		$array = array();
		foreach( $methods as $method ) {
			$prefix = substr( $method, 0, 3 );

			if( strcasecmp( $prefix, 'get' ) == 0 ) {
				$property = lcfirst( substr( $method, 3, strlen( $method ) ) );
				$value = $object->$method();

				if( is_object( $value ) ) {
					$array[ $property ] = $this->convertObjectToArray( $value );
				}
				else if( is_array( $value ) ) {
					$subarray = array();
					foreach( $value as $o ) {
						$subarray[] = $this->convertObjectToArray( $o );
					}

					$array[ $property ] = $subarray;
				}
				else {
					$array[ $property ] = $value;
				}
			}
		}

		return $array;
	}
}
?>