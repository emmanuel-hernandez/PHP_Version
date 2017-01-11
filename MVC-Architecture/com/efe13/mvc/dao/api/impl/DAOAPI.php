<?php
namespace com\efe13\mvc\dao\api\impl;
/*
import org.hibernate.criterion.Order;
import org.hibernate.criterion.Projections;
import org.hibernate.criterion.Restrictions;
*/

require_once( dirname( dirname( dirname(__DIR__) ) ) . '/commons/api/enums/ActiveEnum.php' );
require_once( dirname( dirname( dirname(__DIR__) ) ) . '/commons/api/exception/DAOException.php' );
require_once( dirname( dirname( dirname(__DIR__) ) ) . '/commons/api/exception/HibernateException.php' );
require_once( dirname( dirname( dirname(__DIR__) ) ) . '/commons/api/util/Utils.php' );
require_once( dirname(__DIR__) . '/IDAO.php' );
require_once( 'util/HibernateUtil.php' );
require_once( 'util/Restrictions.php' );
require_once( dirname( dirname( dirname(__DIR__) ) ) . '/commons/api/interfaces/Mappeable.php' );
require_once( dirname( dirname( dirname(__DIR__) ) ) . '/model/api/impl/QueryHelper.php' );

use com\efe13\mvc\commons\api\enums\ActiveEnum;
use com\efe13\mvc\commons\api\exception\DAOException;
use com\efe13\mvc\commons\api\exception\HibernateException;
use com\efe13\mvc\commons\api\util\Utils;
use com\efe13\mvc\dao\api\IDAO;
use com\efe13\mvc\dao\api\impl\util\HibernateUtil;
use com\efe13\mvc\dao\api\impl\util\Restrictions;
use com\efe13\mvc\commons\api\interfaces\Mappeable;
use com\efe13\mvc\model\api\impl\QueryHelper;

abstract class DAOAPI implements IDAO {

	private $sessionFactory;
	private $criteriaClass;
	//private final static Logger log = Logger.getLogger( DAOAPI.class );
	
	private $columnNameForActiveElement;
	private $activeEnum;
	
	public function __construct($criteriaClass, $columnNameForActiveElement, $activeEnum) {
		$this->sessionFactory = HibernateUtil::getSessionFactory();
	
		$this->criteriaClass = $criteriaClass;
		$this->columnNameForActiveElement = $columnNameForActiveElement;
		$this->activeEnum = $activeEnum;
		
		//createSessionFactory();
		//criteriaClass = (Class<T>) ((ParameterizedType) getClass().getGenericSuperclass() ).getActualTypeArguments()[0];
	}
	
	//@Override
	public function getTotalRecords() {
		//echo 'gettingTotalRecords...<br>';
		try {
			$object = $this->getCriteria()
				->setProjection( Projections::rowCount() )
				->add( Restrictions::eq( $this->columnNameForActiveElement, ActiveEnum::ACTIVE ) )
				->uniqueResult();
			
			if( !Utils::isNull( $object ) ) {
				return $object;
			}
			
			return 0;
		}
		catch( DAOException $ex ) {
			throw new DAOException( $ex->getMessage() );
		}
		finally {
			$this->$this->closeSession();
		}
	}

	//@Override
	public function getById(Mappeable $object) {
		//echo 'gettingById...<br>';
		try {
			$criteria = $this->getCriteria()
				->add( Restrictions::idEq( $this->criteriaClass, $object->getId() ) )
				->add( Restrictions::eq( $this->columnNameForActiveElement, $this->activeEnum ) );

			$object = $criteria->uniqueResult();
			return $object;
		}
		catch( HibernateException $ex ) {
			throw new DAOException( $ex->getMessage() );
		}
		finally {
			$this->closeSession();
		}
	}
	
	//@Override
	public function getAll(QueryHelper $helper = null) {
		//echo 'gettingAll...<br>';
		try {
			if( !Utils::isNull( $helper ) && !($helper instanceof QueryHelper) ) {
				throw new HibernateException( "Query Helper expected!" );
			}
			
			$criteria = $this->getCriteria()
				->add( Restrictions::eq( $this->columnNameForActiveElement, $this->activeEnum ) );
			
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
			
			return $criteria->listAll();
		}
		catch( \Exception $ex ) {
			throw new DAOException( $ex->getMessage() );
		}
		finally {
			$this->closeSession();
		}
	}
	
	//@Override
	public function save(Mappeable $object) {
		//echo 'Guardando...<br>';
		$session = $this->getCriteria();
		$generatedId = 0;
		
		try {
			$generatedId = $session->save( $object );
		}
		catch( HibernateException $ex ) {
			throw new DAOException( $ex->getMessage() );
		}
		finally {
			$this->closeSession();
		}
		
		return $generatedId;
	}
	
	//@Override
	public function update(Mappeable $object) {
		//echo 'Actualizando...<br>';
		$session = $this->getCriteria();
		
		try {
			$session->update( $object );
			return true;
		}
		catch( HibernateException $ex ) {
			throw new DAOException( $ex->getMessage() );
		}
		finally {
			$this->closeSession();
		}
	}
	
	//@Override
	public function delete(Mappeable $object) {
		//$session = $this->getSession();
		
		try {
			$session->delete( $object );
			return true;
		}
		catch( HibernateException $ex ) {
			throw new DAOException( $ex->getMessage() );
		}
		finally {
			$this->closeSession();
		}
	}
		
	protected final function closeSession() {
		//echo 'sessionCerrada<br>';
		$this->sessionFactory->close();
	}

	protected function getCriteria($alias = 'this_') {
		$this->sessionFactory->openSession();
		return $this->getSession()->createCriteria( $this->criteriaClass, $alias );
	}
	
	private final function getSession() {
		//echo 'sessionAbierta<br>';
		return $this->sessionFactory->openSession();
	}
}
?>