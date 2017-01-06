<?php
/*
require_once( 'com/efe13/mvc/model/api/dto/IDTO.php' );
require_once( 'com/efe13/mvc/model/api/entity/IEntity.php' );
require_once( 'com/efe13/mvc/model/api/impl/DTOAPI.php' );
require_once( 'com/efe13/mvc/model/api/impl/EntityAPI.php' );
require_once( 'com/efe13/mvc/dao/api/IDAO.php' );
require_once( 'com/efe13/mvc/service/api/IService.php' );
require_once( 'com/efe13/mvc/service/api/impl/ServiceAPI.php' );

require_once( 'com/efe13/mvc/commons/api/exception/MappeableException.php' );
require_once( 'com/efe13/mvc/commons/api/exception/ServiceException.php' );
require_once( 'com/efe13/mvc/commons/api/exception/ValidationException.php' );
require_once( 'com/efe13/mvc/commons/api/exception/DAOException.php' );
require_once( 'com/efe13/mvc/commons/api/exception/HibernateException.php' );
require_once( 'com/efe13/mvc/commons/api/util/Utilities.php' );
require_once( 'com/efe13/mvc/commons/api/util/Utils.php' );
require_once( 'com/efe13/mvc/commons/api/enums/ActiveEnum.php' );
require_once( 'com/efe13/mvc/commons/api/enums/UpdateEnum.php' );
require_once( 'com/efe13/mvc/model/api/impl/FilterAPI.php' );
require_once( 'com/efe13/mvc/model/api/impl/OrderAPI.php' );
require_once( 'com/efe13/mvc/model/api/impl/PaginationAPI.php' );
require_once( 'com/efe13/mvc/model/api/impl/QueryHelper.php' );

require_once( 'com/efe13/mvc/dao/api/impl/util/HibernateUtil.php' );
require_once( 'com/efe13/mvc/dao/api/impl/DAOAPI.php' );

use com\efe13\mvc\model\api\dto\IDTO;
use com\efe13\mvc\model\api\entity\IEntity;
use com\efe13\mvc\model\api\impl\dto\DTOAPI;
use com\efe13\mvc\model\api\impl\dto\EntityAPI;

use com\efe13\mvc\dao\api\IDAO;
use com\efe13\mvc\service\api\IService;
use com\efe13\mvc\service\api\impl\ServiceAPI;

use com\efe13\mvc\commons\api\exception\DAOException;
use com\efe13\mvc\commons\api\exception\MappeableException;
use com\efe13\mvc\commons\api\exception\ServiceException;
use com\efe13\mvc\commons\api\exception\ValidationException;
use com\efe13\mvc\commons\api\exception\HibernateException;
use com\efe13\mvc\commons\api\util\Utilities;
use com\efe13\mvc\commons\api\util\Utils;

use com\efe13\mvc\commons\api\enums\ActiveEnum;
use com\efe13\mvc\commons\api\enums\UpdateEnum;

use com\efe13\mvc\model\api\impl\helper\FilterAPI;
use com\efe13\mvc\model\api\impl\helper\OrderAPI;
use com\efe13\mvc\model\api\impl\helper\PaginationAPI;
use com\efe13\mvc\model\api\impl\helper\QueryHelper;

use com\efe13\mvc\dao\api\impl\util\HibernateUtil;
use com\efe13\mvc\dao\api\impl\DAOAPI;
*/

require_once( 'com/efe13/tdt/utils/AppPaths.php' );
require_once( getAppPath( CHANNEL_BAND_CONTROLLER_PATH ) );
use com\efe13\tdt\controller\ChannelBandController;


$controller = new ChannelBandController();
$channels = $controller->getChannelBands();

//var_dump( $channels );
die( json_encode( (array) $channels, JSON_PRETTY_PRINT ) );

?>