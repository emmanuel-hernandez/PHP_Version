<?php
namespace com\efe13\mvc\commons\api\exception;

class DAOException extends \Exception {

	public function __construct($message) {
		parent::__construct( $message );
	}
}
?>