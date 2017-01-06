<?php
namespace com\efe13\mvc\commons\api\util;

require_once( getMVCPath( UPDATE_ENUM_PATH ) );
require_once( getMVCPath( VALIDATION_EXCEPTION_PATH ) );
require_once( getMVCPath( MAPPEABLE_PATH ) );

use com\efe13\mvc\commons\api\enums\UpdateEnum;
use com\efe13\mvc\commons\api\exception\ValidationException;
use com\efe13\mvc\commons\api\interfaces\Mappeable;

abstract class Utilities {

	public abstract function validateDTO(Mappeable $dto, $isUpdate);

	public abstract function sanitizeDTO(Mappeable $dto);
	
}
?>