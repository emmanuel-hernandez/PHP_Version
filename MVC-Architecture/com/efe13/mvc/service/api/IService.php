<?php
namespace com\efe13\mvc\service\api;

require_once( dirname( dirname(__DIR__) ) . '/commons/api/interfaces/CrudOperations.php' );
require_once( dirname( dirname(__DIR__) ) . '/commons/api/interfaces/Mappeable.php' );
require_once( dirname( dirname(__DIR__) ) . '/model/api/dto/IDTO.php' );

use com\efe13\mvc\commons\api\interfaces\CrudOperations;
use com\efe13\mvc\commons\api\interfaces\Mappeable;
use com\efe13\mvc\model\api\dto\IDTO;

interface IService extends CrudOperations {

	public function map( Mappeable $source, Mappeable $destination );
}
?>