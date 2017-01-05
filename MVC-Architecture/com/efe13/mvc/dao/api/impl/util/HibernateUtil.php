<?php
namespace com\efe13\mvc\dao\api\impl\util;

class HibernateUtil {

	private static $instance = null;
	private static $sessionFactory;

	private function __construct() {
		$registry = new StandardServiceRegistryBuilder().configure().build();
		try {
	        $this->sessionFactory = new MetadataSources( $registry ).buildMetadata().buildSessionFactory();
		}
		catch( Exception ex ) {
			StandardServiceRegistryBuilder.destroy( $registry );
			System.out.println( "HibernateUtil: " + ex.getMessage() );
			ex.printStackTrace();
		}
	}

	public function static HibernateUtil getInstance(){
        if( instance == null ) {
            instance  = new HibernateUtil();
        }
        return instance;
	}

	public function static getSessionFactory() {
        getInstance();
		return HibernateUtil.sessionFactory;
	}
}
?>