<?php
namespace com\efe13\mvc\commons\api\exception;

class ValidationException extends \Exception {

	public function __construct($message) {
		parent::__construct( $message );
	}
}
?>