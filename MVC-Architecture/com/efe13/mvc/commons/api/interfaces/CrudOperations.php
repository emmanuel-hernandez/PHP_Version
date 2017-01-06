<?php
namespace com\efe13\mvc\commons\api\interfaces;

require_once( dirname( dirname( dirname(__DIR__) ) ) . '/commons/api/interfaces/Mappeable.php' );
require_once( dirname( dirname( dirname(__DIR__) ) ) . '/model/api/impl/QueryHelper.php' );

use com\efe13\mvc\commons\api\interfaces\Mappeable;
use com\efe13\mvc\model\api\impl\QueryHelper;

interface CrudOperations {
	
	public function getById(Mappeable $object);
	
	public function getAll(QueryHelper $object);
	
	public function save(Mappeable $object);
	
	public function update(Mappeable $object);
	
	public function delete(Mappeable $object);
}
?>