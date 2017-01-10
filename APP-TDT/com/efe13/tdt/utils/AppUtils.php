<?php
namespace com\efe13\tdt\utils;

require_once( getAppPath( SERVICE_RESULT_PATH ) );

use com\efe13\tdt\helper\ServiceResult;

final class AppUtils {
	private function __construct() {
	}

	public static function createResultServiceByMessageAndStatus($message, $status) {
		$serviceResult = new ServiceResult();
		$serviceResult->setMessage( $message );
		$serviceResult->setStatusResult( $status );

		return $serviceResult;
	}
}
?>