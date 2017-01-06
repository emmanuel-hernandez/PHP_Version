<?php
namespace com\efe13\tdt\helper;

require_once( getMVCPath( QUERY_HELPER_PATH ) );
require_once( getAppPath( STATUS_RESULT_SERVICE_PATH ) );

use com\efe13\mvc\model\api\impl\helper\QueryHelper;
use com\efe13\tdt\enums\StatusResultService;

class ServiceResult {

	private $object;
	private $collection;
	private $statusResult;
	private $message;
	private $queryHelper;
	
	public function __construct($object = null, array $collection = null, $success = StatusResultService::FAILED, $message = '') {
		$this->statusResult = $success;
		$this->message = $message;
		$this->object = $object;
		$this->collection = $collection;
	}

	public function getStatusResult() {
		return $this->statusResult;
	}
	
	public function setStatusResult( StatusResultService $success) {
		$this->statusResult = $success;
	}
	
	public function getMessage() {
		return $this->message;
	}
	
	public function setMessage($message) {
		$this->message = message;
	}
	
	public function getObject() {
		return $this->object;
	}

	public function setObject($object) {
		$this->object = object;
	}

	public function getCollection() {
		return $this->collection;
	}
	
	public function setCollection($collection) {
		$this->collection = $collection;
	}

	public function getQueryHelper() {
		return $this->queryHelper;
	}

	public function setQueryHelper(QueryHelper $queryHelper) {
		$this->queryHelper = $queryHelper;
	}
}
?>