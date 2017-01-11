<?php
namespace com\efe13\mvc\service\api\impl;

require_once( dirname( dirname( dirname(__DIR__) ) ) . '/commons/api/exception/ServiceException.php' );
require_once( dirname( dirname( dirname(__DIR__) ) ) . '/commons/api/interfaces/Mappeable.php' );
require_once( dirname( dirname( dirname(__DIR__) ) ) . '/commons/api/util/Utilities.php' );
require_once( dirname( dirname( dirname(__DIR__) ) ) . '/model/api/impl/QueryHelper.php' );
require_once( dirname( dirname( dirname(__DIR__) ) ) . '/model/api/impl/DTOAPI.php' );
require_once( dirname( dirname( dirname(__DIR__) ) ) . '/service/api/IService.php' );

//use org\modelmapper\ModelMapper;

use com\efe13\mvc\commons\api\exception\ServiceException;
use com\efe13\mvc\commons\api\interfaces\Mappeable;
use com\efe13\mvc\commons\api\util\Utilities;
use com\efe13\mvc\model\api\impl\dto\DTOAPI;
use com\efe13\mvc\model\api\impl\QueryHelper;
use com\efe13\mvc\service\api\IService;

abstract class ServiceAPI extends Utilities implements IService {

	public function getById(Mappeable $object) {
		throw new ServiceException( "This method has not implementation. It needs to be implemented by the concrete class" );
	}
	
	public function getAll(QueryHelper $queryHelper) {
		throw new ServiceException( "This method has not implementation. It needs to be implemented by the concrete class" );
	}
	
	public function save(Mappeable $object) {
		throw new ServiceException( "This method has not implementation. It needs to be implemented by the concrete class" );
	}
	
	public function update(Mappeable $object) {
		throw new ServiceException( "This method has not implementation. It needs to be implemented by the concrete class" );
	}
	
	public function delete(Mappeable $object) {
		throw new ServiceException( "This method has not implementation. It needs to be implemented by the concrete class" );
	}
	
	public function map(Mappeable $source, Mappeable $destination) {
		$destinationClass = get_class( $destination );
		$destination = new $destinationClass;

		$methods = get_class_methods( $destinationClass );
		if( empty( $methods ) ) {
			throw new ServiceException( "Class has not methods defined" );
		}

		foreach( $methods as $method ) {
			$prefix = substr( $method, 0, 3 );

			if( strcasecmp( $prefix, 'set' ) == 0  ) {
				$getMethod = 'get' . substr( $method, 3, strlen( $method ) );

				if( method_exists( get_class( $destination ), $getMethod ) ) {
					$data = $source->$getMethod();
					if( is_object( $data ) ) {
						$data = $this->map( $data, $destination->$getMethod() );
					}

					$destination->$method( $data );
				}
				else {
					$getMethod = 'is' . substr( $method, 3, strlen( $method ) );

					if( method_exists( get_class( $destination ), $getMethod ) ) {
						$destination->$method( $source->$getMethod() );
					}
					else {
						throw new ServiceException( "Some methods in the destination class doesn't match with the source class" );
					}
				}
			}
		}

		return $destination;
	}

	private function isDTOClass($clazz) {
		$postfix = substr( $clazz, strlen( $clazz )-3, 3 );
		return strcasecmp( $postfix, 'DTO' ) == 0;
	}
}
?>