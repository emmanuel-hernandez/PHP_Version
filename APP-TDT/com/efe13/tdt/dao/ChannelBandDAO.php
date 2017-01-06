<?php
namespace com\efe13\tdt\dao;

require_once( getMVCPath( ACTIVE_ENUM_PATH ) );
require_once( getMVCPath( DAO_API_PATH ) );
require_once( getAppPath( CHANNEL_BAND_PATH ) );
require_once( getAppPath( APP_CONSTANT_PATH ) );

use com\efe13\mvc\commons\api\enums\ActiveEnum;
use com\efe13\mvc\dao\api\impl\DAOAPI;
use com\efe13\tdt\model\entity\ChannelBand;
use com\efe13\tdt\utils\AppConstant;

class ChannelBandDAO extends DAOAPI {

	public function __construct() {
		parent::__construct( new ChannelBand(), AppConstant::ACTIVE_COLUMN_NAME, ActiveEnum::ACTIVE );
	}
}
?>