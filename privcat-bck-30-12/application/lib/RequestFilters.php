<?php

class RequestFilters {

	protected $departments;
	protected $firms;
	
	protected $status;
	protected $department;
	protected $firm;
	protected $requester;
	protected $servicer;
	
	protected $title;
	protected $id;
	
	protected $requesterModel;
	
	public function __construct() {
		$this->setupFilters();
		
		$this->status		= $_SESSION['request_filters']['status'];
		$this->department	= $_SESSION['request_filters']['department'];
		$this->firm			= $_SESSION['request_filters']['firm'];
		$this->requester	= $_SESSION['request_filters']['requester'];
		$this->servicer		= $_SESSION['request_filters']['servicer'];
		$this->title		= $_SESSION['request_filters']['title'];
		$this->id			= $_SESSION['request_filters']['id'];
		
		$user = $_SESSION['user'];
				
		$requester = $user->getRequester();
		$servicer = $user->getServicer();
		
		$this->departments = array_merge(
				$servicer->sharedDepartment,
				$requester->sharedDepartment
		);
		
		$firms = array();
		foreach($this->departments as $department) {
			$firms[] = $department->firm;
		}
		
		$this->firms = array_unique($firms);
	}
	
	public function resetFilters() {
		$this->setStatus(0);
		$this->setDepartment(0);
		$this->setFirm(0);
		$this->setRequester(0);
		$this->setServicer(0);
		$this->setTitle('');
		$this->setId(0);
	}
	
	public function setupFilters() {
		if(!isset($_SESSION['request_filters']['status'])) {
			$_SESSION['request_filters']['status'] = 0;
		}
		
		if(!isset($_SESSION['request_filters']['department'])) {
			$_SESSION['request_filters']['department'] = 0;
		}
		
		if(!isset($_SESSION['request_filters']['firm'])) {
			$_SESSION['request_filters']['firm'] = 0;
		}
		
		if(!isset($_SESSION['request_filters']['requester'])) {
			$_SESSION['request_filters']['requester'] = 0;
		}
		
		if(!isset($_SESSION['request_filters']['servicer'])) {
			$_SESSION['request_filters']['servicer'] = 0;
		}
		
		if(!isset($_SESSION['request_filters']['title'])) {
			$_SESSION['request_filters']['title'] = '';
		}
		
		if(!isset($_SESSION['request_filters']['id'])) {
			$_SESSION['request_filters']['id'] = 0;
		}
	}
	
	protected function updateSession() {
		$_SESSION['request_filters']['status']		= $this->status;
		$_SESSION['request_filters']['department']	= $this->department;
		$_SESSION['request_filters']['firm']		= $this->firm;
		$_SESSION['request_filters']['requester']	= $this->requester;
		$_SESSION['request_filters']['servicer']	= $this->servicer;
		$_SESSION['request_filters']['title']		= $this->title;
		$_SESSION['request_filters']['id']			= $this->id;
	}
	
	public function setStatus($statusId) {
		$this->status = $statusId;
		$this->updateSession();
	}
	
	public function setDepartment($departmentId) {
		$this->department = $departmentId;
		$this->updateSession();
	}
	
	public function setFirm($firmId) {
		$this->firm = $firmId;
		$this->updateSession();
	}
	
	public function setRequester($requesterId) {
		$this->requester = $requesterId;
		$this->updateSession();
	}
	
	public function setServicer($servicerId) {
		$this->servicer = $servicerId;
		$this->updateSession();
	}
	
	public function setTitle($title) {
		$this->title = $title;
		$this->updateSession();
	}
	
	public function setId($id) {
		$this->id = $id;
		$this->updateSession();
	}
	
	public function setFilters($filtersData) {
		$this->setStatus($filtersData['status']);
		$this->setDepartment($filtersData['department']);
		$this->setFirm($filtersData['firm']);
		$this->setRequester($filtersData['requester']);
		$this->setServicer($filtersData['servicer']);
		$this->setTitle($filtersData['title']);
		$this->setId($filtersData['id']);
	}
	
	public function getWhereClause() {
		$where = 'WHERE ';
		
		$depCount = count($this->departments);
		
		for($i=0; $i<$depCount; $i++) {
			if($i==0) {
				$where .= ' department_id IN (';
			}
			
			$where .= '? ';
			
			if($i<$depCount-1) {
				$where .= ', ';
			}
				
			if($i==$depCount-1) {
				$where .= ') AND ';
			}				
		}
		
		if($this->status != 0) {
			if($this->status == -1) {
				$nonEndpointStatuses = array_values(R::findAll('requeststatus', 'WHERE is_endpoint = 0'));
				$nonEndpointStatusesCount = count($nonEndpointStatuses);

				$nonEndpointStatusesIds = ' (';
				
				for($i=0; $i<$nonEndpointStatusesCount; $i++) {
					$nonEndpointStatusesIds .= '?';
					
					if($i<$nonEndpointStatusesCount-1) {
						$nonEndpointStatusesIds .= ', ';
					}
					
				}
				
				$nonEndpointStatusesIds .= ') ';
				
				$where .= ' requeststatus_id IN ' . $nonEndpointStatusesIds . ' AND ';
			} else {
				$where .= ' requeststatus_id = ? AND ';
			}
		}
		
		if($this->firm != 0) {
			$where .= ' firm_id = ? AND ';
		}	

		if($this->department != 0) {
			$where .= ' department_id = ? AND ';
		}		

		if($this->requester != 0) {
			$where .= ' requester_id = ? AND ';
		}		

		if($this->servicer != 0) {
			if($this->servicer == -1) {
				$where .= ' servicer_id IS null AND ';
			} else {
				$where .= ' servicer_id = ? AND ';
			}
		}

		if(strlen($this->title) > 0) {
			$where .= ' ( title LIKE ? ) AND ';
		}

		if($this->id != 0) {
			$where .= ' ( id = ? ) AND ';
		}
		
		$where .= ' 1';	
		
// 		pre($where);
		return $where;
	}
	
	public function getWhereParams() {
		$params = array();
		
		foreach ($this->departments as $department) {
			$params[] = $department->id;
		}
		
		if($this->status != 0){
			if($this->status == -1) {
				$nonEndpointStatuses = array_values(R::findAll('requeststatus', 'WHERE is_endpoint = 0'));
				foreach($nonEndpointStatuses as $status) {
					$params[] = $status->id;
				}
			} else {
				$params[] = $this->status;
			}
		}
		
		if($this->firm != 0) {
			$params[] = $this->firm;
		}
		
		if($this->department != 0) {
			$params[] = $this->department;
		}
		
		if($this->requester != 0) {
			$params[] = $this->requester;
		}
		
		if($this->servicer != 0) {
			if($this->servicer == -1) {
				// no action
			} else {
				$params[] = $this->servicer;
			}
		}

		if(strlen($this->title) > 0) {
			$sqlString = str_replace('*', '%', $this->title);
			
			$params[] = '%'.$sqlString.'%';
		}
		
		if($this->id != 0) {
			$params[] = $this->id;
		}
		
// 		pre($params);
		return $params;
	}
	
}

