<?php
namespace com\efe13\mvc\dao\api\impl;
/*
import org.hibernate.criterion.Order;
import org.hibernate.criterion.Projections;
import org.hibernate.criterion.Restrictions;
*/

require_once( dirname( dirname( dirname(__DIR__) ) ) . '/commons/api/enums/ActiveEnum.php' );
require_once( dirname( dirname( dirname(__DIR__) ) ) . '/commons/api/exception/DAOException.php' );
require_once( dirname( dirname( dirname(__DIR__) ) ) . '/commons/api/util/Utils.php' );
require_once( dirname( dirname( dirname(__DIR__) ) ) . '/dao/api/IDAO.php' );
require_once( dirname( dirname( dirname(__DIR__) ) ) . '/dao/api/impl/util/HibernateUtil.php' );
require_once( dirname( dirname( dirname(__DIR__) ) ) . '/commons/api/interfaces/Mappeable.php' );
require_once( dirname( dirname( dirname(__DIR__) ) ) . '/model/api/impl/QueryHelper.php' );

use com\efe13\mvc\commons\api\enums\ActiveEnum;
use com\efe13\mvc\commons\api\exception\DAOException;
use com\efe13\mvc\commons\api\util\Utils;
use com\efe13\mvc\dao\api\IDAO;
use com\efe13\mvc\dao\api\impl\util\HibernateUtil;
use com\efe13\mvc\commons\api\interfaces\Mappeable;
use com\efe13\mvc\model\api\impl\QueryHelper;

abstract class DAOAPI implements IDAO {

	private $sessionFactory;
	//private final Class<T> criteriaClass;
	//private final static Logger log = Logger.getLogger( DAOAPI.class );
	
	private $columnNameForActiveElement;
	private $activeEnum;
	
	public function __construct() {
		$this->sessionFactory = HibernateUtil::getSessionFactory();
	
		$this->columnNameForActiveElement = $columnNameForActiveElement;
		$this->activeEnum = $activeEnum;
		
		//createSessionFactory();
		//criteriaClass = (Class<T>) ((ParameterizedType) getClass().getGenericSuperclass() ).getActualTypeArguments()[0];
	}
	
	//@Override
	public function getTotalRecords() {
		try {
			$object = $this->getCriteria()
				->setProjection( Projections::rowCount() )
				->add( Restrictions::eq( $columnNameForActiveElement, ActiveEnum::ACTIVE ) )
				->uniqueResult();
			
			if( !Utils::isNull( $object ) ) {
				return $object;
			}
			
			return 0;
		}
		catch( DAOException $ex ) {
			throw new DAOException( $ex );
		}
		finally {
			$this->$this->closeSession();
		}
	}

	//@Override
	public function getById(Mappeable $object) {
		try {
			$criteria = $this->getCriteria()
				->add( Restrictions::idEq( $object->getId() ) )
				->add( Restrictions::eq( $columnNameForActiveElement, $this->activeEnum ) );
			
			return $criteria->uniqueResult();
		}
		finally {
			$this->closeSession();
		}
	}
	
	//@Override
	public function getAll(QueryHelper $helper) {
		try {
			if( !Utils::isNull( $helper ) && !($helper instanceof QueryHelper) ) {
				throw new RuntimeException( "Query Helper expected!" );
			}
			
			$criteria = $this->getCriteria()
				->add( Restrictions::eq( $columnNameForActiveElement, $this->activeEnum ) );
			
			if( !Utils::isNull( $helper ) ) {
				if( !Utils::isNull( $queryHelper->getPaginationAPI() ) ) {
					$criteria->setFirstResult( $queryHelper->getPaginationAPI()->getPage() );
					$criteria->setMaxResults( $queryHelper->getPaginationAPI()->getPageSize() );
				}
				
				if( !Utils::isNull( $queryHelper->getOrderAPI() ) ) {
					$criteria->addOrder( ($queryHelper->getOrderAPI()->isAscending()) ?
										Order::asc( $queryHelper->getOrderAPI()->getField() ) :
										Order::desc( $queryHelper->getOrderAPI()->getField() ) );
				}
			}
			
			return $criteria->list();
		}
		finally {
			$this->closeSession();
		}
	}
	
	//@Override
	public function save(Mappeable $object) {
		$session = $this->getSession();
		$generatedId = 0;
		
		try {
			$generatedId = $session->save( $object );
		}
		catch( DAOException $ex ) {
			throw new DAOException( $ex->getMessage() );
		}
		finally {
			$this->closeSession();
		}
		
		return $generatedId;
	}
	
	//@Override
	public function update(Mappeable $object) {
		$session = $this->getSession();
		
		try {
			$session->update( $object );
			return true;
		}
		catch( DAOException $ex ) {
			throw new DAOException( $ex->getMessage() );
		}
		finally {
			$this->closeSession();
		}
	}
	
	//@Override
	public function delete(Mappeable $object) {
		$session = $this->getSession();
		
		try {
			$session->delete( $object );
			return true;
		}
		catch( DAOException $ex ) {
			throw new DAOException( $ex->getMessage() );
		}
		finally {
			$this->closeSession();
		}
	}
		
	protected final function closeSession() {
		/*if( $sessionFactory != null && !$sessionFactory.isClosed() ) {
			$sessionFactory.close();
		}*/
	}

	protected function getCriteria($alias = '_this') {
		if( Utils::isEmpty( $alias ) )
			return $this->getSession()->createCriteria( $this->criteriaClass );
		
		return $this->getSession()->createCriteria( $this->criteriaClass, $alias );
	}
	
	private final function getSession() {
		return $sessionFactory->openSession();
	}
	
	/*
	private final void createSessionFactory() {
		if( $sessionFactory == null ) {
			final StandardServiceRegistry registry = new StandardServiceRegistryBuilder().configure().build();
			
			try {
				$sessionFactory = new MetadataSources( registry ).buildMetadata().buildSessionFactory();
			}
			catch( Exception ex ) {
				StandardServiceRegistryBuilder.destroy( registry );
				log.error( ex.getMessage(), ex );
				throw ex;
			}
		}
	}
	*/
}
?>