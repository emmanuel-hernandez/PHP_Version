<?php

//MVC-Architecture Framework paths!!!
define( 'IDTO_PATH', 'com/efe13/mvc/model/api/dto/IDTO.php' );
define( 'IENTITY_PATH', 'com/efe13/mvc/model/api/entity/IEntity.php' );
define( 'DTO_API_PATH', 'com/efe13/mvc/model/api/impl/DTOAPI.php' );
define( 'ENTITY_API_PATH', 'com/efe13/mvc/model/api/impl/EntityAPI.php' );
define( 'IDAO_PATH', 'com/efe13/mvc/dao/api/IDAO.php' );
define( 'ISERVICE_PATH', 'com/efe13/mvc/service/api/IService.php' );
define( 'SERVICE_API_PATH', 'com/efe13/mvc/service/api/impl/ServiceAPI.php' );
define( 'MAPPEABLE_EXCEPTION_PATH', 'com/efe13/mvc/commons/api/exception/MappeableException.php' );
define( 'SERVICE_EXCEPTION_PATH', 'com/efe13/mvc/commons/api/exception/ServiceException.php' );
define( 'VALIDATION_EXCEPTION_PATH', 'com/efe13/mvc/commons/api/exception/ValidationException.php' );
define( 'DAO_EXCEPTION_PATH', 'com/efe13/mvc/commons/api/exception/DAOException.php' );
define( 'HIBERNATE_EXCEPTION_PATH', 'com/efe13/mvc/commons/api/exception/HibernateException.php' );
define( 'UTILITIES_PATH', 'com/efe13/mvc/commons/api/util/Utilities.php' );
define( 'UTILS_PATH', 'com/efe13/mvc/commons/api/util/Utils.php' );
define( 'ACTIVE_ENUM_PATH', 'com/efe13/mvc/commons/api/enums/ActiveEnum.php' );
define( 'UPDATE_ENUM_PATH', 'com/efe13/mvc/commons/api/enums/UpdateEnum.php' );
define( 'MAPPEABLE_PATH', 'com/efe13/mvc/commons/api/interfaces/Mappeable.php' );
define( 'FILTER_API_PATH', 'com/efe13/mvc/model/api/impl/FilterAPI.php' );
define( 'ORDER_API_PATH', 'com/efe13/mvc/model/api/impl/OrderAPI.php' );
define( 'PAGINATION_API_PATH', 'com/efe13/mvc/model/api/impl/PaginationAPI.php' );
define( 'QUERY_HELPER_PATH', 'com/efe13/mvc/model/api/impl/QueryHelper.php' );
define( 'HIBERNATE_UTIL_PATH', 'com/efe13/mvc/dao/api/impl/util/HibernateUtil.php' );
define( 'DAO_API_PATH', 'com/efe13/mvc/dao/api/impl/DAOAPI.php' );

//APP-TDT paths!!!
define( 'APP_CONSTANT_PATH', 'com/efe13/tdt/utils/AppConstant.php' );
define( 'PRINTER_PATH', 'com/efe13/tdt/utils/Printer.php' );
define( 'STATUS_RESULT_SERVICE_PATH', 'com/efe13/tdt/enums/StatusResultService.php' );
define( 'FILTER_DTO_PATH', 'com/efe13/tdt/helper/FilterDTO.php' );
define( 'PAGINATION_DTO_PATH' ,'com/efe13/tdt/helper/PaginationDTO.php' );
define( 'SERVICE_REQUEST_PATH', 'com/efe13/tdt/helper/ServiceRequest.php' );
define( 'SERVICE_RESULT_PATH', 'com/efe13/tdt/helper/ServiceResult.php' );

define( 'CHANNEL_BAND_CONTROLLER_PATH', 'com/efe13/tdt/controller/ChannelBandController.php' );
define( 'CHANNEL_BAND_DTO_PATH', 'com/efe13/tdt/model/dto/ChannelBandDTO.php' );
define( 'CHANNEL_BAND_SERVICE_IMPL_PATH', 'com/efe13/tdt/service/impl/ChannelBandServiceImpl.php' );
define( 'CHANNEL_BAND_SERVICE_PATH', 'com/efe13/tdt/service/ChannelBandService.php' );
define( 'CHANNEL_BAND_DAO_PATH', 'com/efe13/tdt/dao/ChannelBandDAO.php' );
define( 'CHANNEL_BAND_PATH', 'com/efe13/tdt/model/entity/ChannelBand.php' );

function getMVCPath($constant) {
	return getPath( 'MVC-Architecture/' . $constant );
}

function getAppPath($constant) {
	return getPath( 'APP-TDT/' . $constant );
}

function getPath($path) {
	$root = dirname( dirname( dirname( dirname( dirname(__DIR__) ) ) ) );
	return $root . '/'. $path;
}
?>