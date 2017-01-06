<?php
namespace com\efe13\mvc\dao\api\impl\util;

require_once( dirname( dirname( dirname( dirname(__DIR__) ) ) ) . '/commons/api/exception/HibernateException.php' );
require_once( 'Criteria.php' );

use com\efe13\mvc\dao\api\impl\util\Criteria;
use com\efe13\mvc\commons\api\exception\HibernateException;

class SessionFactory extends \mysqli {

	private $user;
	private $password;
	private $host;
	private $db;
	
	public function __construct($user, $password, $host, $db) {
		$this->user = $user;
		$this->password = $password;
		$this->host = $host;
		$this->db = $db;

		$this->openSession();
	}

	public function openSession() {
		parent::__construct( $this->host, $this->user, $this->password, $this->db );
		
		if( mysqli_connect_error() ) {
			throw new HibernateException( mysqli_connect_error() );
		}

		return new Criteria( $this );
	}
}
?>