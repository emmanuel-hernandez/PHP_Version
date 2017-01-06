<?php
namespace com\efe13\mvc\dao\api\impl\util;

require_once( dirname( dirname( dirname( dirname(__DIR__) ) ) ) . '/dao/api/impl/util/Connection.php' );

use com\efe13\mvc\dao\api\impl\util\Connection;

class HibernateUtil {

	private static $instance = null;
	private static $sessionFactory;

	private function __construct() {
		$this->openSession();
	}
	
	public function openSession() {
		try {
	        $this->sessionFactory = new Connection( 'root', 'admin', 'localhost', 'tdt' );
		}
		catch( DAOException $ex ) {
			throw new DAOException( $ex->getMessage() );
		}
	}

	public static function getInstance() {
        if( self::$instance == null ) {
            self::$instance = new HibernateUtil();
        }
		
        return self::$instance;
	}

	public static function getSessionFactory() {
        $this->getInstance();
		return HibernateUtil::$sessionFactory;
	}
}
?>