<?php
namespace com\efe13\mvc\commons\api\util;

require_once( dirname(__DIR__). '/enums/UpdateEnum.php' );
require_once( dirname(__DIR__) . '/exception/ValidationException.php' );

use com\efe13\mvc\commons\api\enums\UpdateEnum;
use com\efe13\mvc\commons\api\exception\ValidationException;

abstract class Utilities {

	public abstract function validateDTO($dto, UpdateEnum $isUpdate);

	public abstract function sanitizeDTO($dto);
	
}
?>