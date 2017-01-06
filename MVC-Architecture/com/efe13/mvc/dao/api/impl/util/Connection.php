<?php
namespace com\efe13\mvc\dao\api\impl\util;

require_once( dirname( dirname( dirname( dirname(__DIR__) ) ) ) . '/commons/api/exception/HibernateException.php' );

use com\efe13\mvc\commons\api\exception\HibernateException;

class Connection extends \mysqli {
	
	public function __construct($user, $password, $host, $db) {
		parent::__construct( $host, $user, $password, $db );
		
		if( mysqli_connect_error() ) {
			throw new HibernateException( mysqli_connect_error() );
		}
	}
}
?>