<?php

//MVC-Architecture Framework paths!!!
define( 'IDTO_PATH', 'com/efe13/mvc/model/api/dto/IDTO.php' );
define( 'IDAO_PATH', 'com/efe13/mvc/dao/api/IDAO.php' );
define( 'ISERVICE_PATH', 'com/efe13/mvc/service/api/IService.php' );
define( 'IENTITY_PATH', 'com/efe13/mvc/model/api/entity/IEntity.php' );
define( 'DTO_API_PATH', 'com/efe13/mvc/model/api/impl/DTOAPI.php' );
define( 'ENTITY_API_PATH', 'com/efe13/mvc/model/api/impl/EntityAPI.php' );
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
define( 'CRITERIA_PATH', 'com/efe13/mvc/dao/api/impl/util/Criteria.php' );
define( 'RESTRICTIONS_PATH', 'com/efe13/mvc/dao/api/impl/util/Restrictions.php' );
define( 'SESSION_FACTORY_PATH', 'com/efe13/mvc/dao/api/impl/util/SessionFactory.php' );
define( 'PROJECTIONS_PATH', 'com/efe13/mvc/dao/api/impl/util/Projections.php' );
define( 'JOIN_TYPE_PATH', 'com/efe13/mvc/dao/api/impl/util/JoinType.php' );
define( 'DAO_API_PATH', 'com/efe13/mvc/dao/api/impl/DAOAPI.php' );

//APP-TDT paths!!!
define( 'APP_CONSTANT_PATH', 'com/efe13/tdt/utils/AppConstant.php' );
define( 'APP_UTILS_PATH', 'com/efe13/tdt/utils/AppUtils.php' );
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

define( 'CONCESSION_TYPE_CONTROLLER_PATH', 'com/efe13/tdt/controller/ConcessionTypeController.php' );
define( 'CONCESSION_TYPE_DTO_PATH', 'com/efe13/tdt/model/dto/ConcessionTypeDTO.php' );
define( 'CONCESSION_TYPE_SERVICE_IMPL_PATH', 'com/efe13/tdt/service/impl/ConcessionTypeServiceImpl.php' );
define( 'CONCESSION_TYPE_SERVICE_PATH', 'com/efe13/tdt/service/ConcessionTypeService.php' );
define( 'CONCESSION_TYPE_DAO_PATH', 'com/efe13/tdt/dao/ConcessionTypeDAO.php' );
define( 'CONCESSION_TYPE_PATH', 'com/efe13/tdt/model/entity/ConcessionType.php' );

define( 'CONCESSIONAIRE_CONTROLLER_PATH', 'com/efe13/tdt/controller/ConcessionaireController.php' );
define( 'CONCESSIONAIRE_DTO_PATH', 'com/efe13/tdt/model/dto/ConcessionaireDTO.php' );
define( 'CONCESSIONAIRE_SERVICE_IMPL_PATH', 'com/efe13/tdt/service/impl/ConcessionaireServiceImpl.php' );
define( 'CONCESSIONAIRE_SERVICE_PATH', 'com/efe13/tdt/service/ConcessionaireService.php' );
define( 'CONCESSIONAIRE_DAO_PATH', 'com/efe13/tdt/dao/ConcessionaireDAO.php' );
define( 'CONCESSIONAIRE_PATH', 'com/efe13/tdt/model/entity/Concessionaire.php' );

define( 'STATE_CONTROLLER_PATH', 'com/efe13/tdt/controller/StateController.php' );
define( 'STATE_DTO_PATH', 'com/efe13/tdt/model/dto/StateDTO.php' );
define( 'STATE_SERVICE_IMPL_PATH', 'com/efe13/tdt/service/impl/StateServiceImpl.php' );
define( 'STATE_SERVICE_PATH', 'com/efe13/tdt/service/StateService.php' );
define( 'STATE_DAO_PATH', 'com/efe13/tdt/dao/StateDAO.php' );
define( 'STATE_PATH', 'com/efe13/tdt/model/entity/State.php' );

define( 'POPULATION_CONTROLLER_PATH', 'com/efe13/tdt/controller/PopulationController.php' );
define( 'POPULATION_DTO_PATH', 'com/efe13/tdt/model/dto/PopulationDTO.php' );
define( 'POPULATION_SERVICE_IMPL_PATH', 'com/efe13/tdt/service/impl/PopulationServiceImpl.php' );
define( 'POPULATION_SERVICE_PATH', 'com/efe13/tdt/service/PopulationService.php' );
define( 'POPULATION_DAO_PATH', 'com/efe13/tdt/dao/PopulationDAO.php' );
define( 'POPULATION_PATH', 'com/efe13/tdt/model/entity/Population.php' );


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