<?php
namespace com\efe13\mvc\commons\api\interfaces;

require_once( dirname( dirname( dirname(__DIR__) ) ) . '/model/api/impl/DTOAPI.php' );
require_once( dirname( dirname( dirname(__DIR__) ) ) . '/model/api/impl/QueryHelper.php' );

use com\efe13\mvc\model\api\impl\dto\DTOAPI;
use com\efe13\mvc\model\api\impl\QueryHelper;

interface CrudOperations {
	
	public function getById(DTOAPI $object);
	
	public function getAll(QueryHelper $object);
	
	public function save(DTOAPI $object);
	
	public function update(DTOAPI $object);
	
	public function delete(DTOAPI $object);
}
?>