<?php
namespace com\efe13\mvc\model\api\entity;

require_once( dirname( dirname( dirname( dirname(__FILE__) ) ) ) . '/commons/api/interfaces/BasicMethods.php' );
require_once( dirname( dirname( dirname( dirname(__FILE__) ) ) ) . '/commons/api/interfaces/Mappeable.php' );

use com\efe13\mvc\commons\api\interfaces\BasicMethods;
use com\efe13\mvc\commons\api\interfaces\Mappeable;

interface IEntity extends BasicMethods, Mappeable {

}
?>