<?php
namespace com\efe13\mvc\dao\api;

require_once( dirname( dirname( dirname(__FILE__) ) ) . '/commons/api/interfaces/CrudOperations.php' );

use com\efe13\mvc\commons\api\interfaces\CrudOperations;

interface IDAO extends CrudOperations {

	public function getTotalRecords();
}
?>