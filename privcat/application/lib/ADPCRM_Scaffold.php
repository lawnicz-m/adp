<?php

class ADPCRM_Scaffold extends Controller {

	/**
	 * @var string
	 */
	protected $layoutName = 'scaffold/layout';

	/**
	 * @var string
	 */
	protected $modelName;

	/**
	 * @param FrntController $frontController
	 * @param string $modelName
	 */
	public function __construct($frontController) {
		parent::__construct($frontController);
	}

	public function preDispatch($params) {
		parent::preDispatch($params);

		$menu = new View('admin/menu');
		$menu->models = Model::getAllModelNames();

		$this->layout->menu = $menu;
	}

	public function IndexAction($params) {
		$this->ListAction($params);
	}

	public function ListAction($params) {
		
		$model = $this->getModel();
		$records = $model->findAll(null, 10);
		
		$content = $this->getView('scaffold/adpcrm/list');
		$content->columns = $model->getVisibleColumns();
		$content->model = $model;
		$content->records = $records;

		$this->layout->content = $content;
		$this->layout->render();
	}

	public function ShowAction($params) {
		if(isset($params[0])) {
			$id = (int)$params[0];
		} else {
			$id = 0;
		}

		$model = $this->getModel();
		
		if(isset($_SESSION['validation'])) {
			$validation = $_SESSION['validation'];
			unset($_SESSION['validation']);
			
			$record = $_SESSION['record'];
			unset($_SESSION['record']);
			
			
		} else {
			$validation = array();

			$record = $this->getModel();
			
			if($id != 0) {
				$record->load($id);
			}
		}
		
		
		$content = $this->getView('scaffold/edit');
		$content->columns = $model->getColumns();
		$content->model = $model;
		$content->record = $record;
		$content->validation = $validation;
		
		$this->layout->content = $content;
		$this->layout->render();
	}

	public function SaveAction($params) {
		if(isset($_POST['cancelSave'])) {
			$this->frontController->redirect('admin', $this->modelName);
			return;
		}
		
		if(isset($_POST['record']['id'])) {
			$id = (int)$_POST['record']['id'];
		} else {
			$id = 0;
		}

		$record = $this->getModel();
			
		if($id != 0) {
			$record->load($id);
		}

		$model = $this->getModel();
		$columns = $model->getColumns();

		foreach($columns as $column => $type) {

			if ($type == Model::TYPE_NORMAL) {
				$value = $_POST['record'][$column];
				$record->$column = $value;

			} elseif ($type == Model::TYPE_BOOLEAN) {
				$value = $_POST['record'][$column];
				$type = gettype($value);
					
				if($type === 'boolean') {
					$record->$column = $value;
				} elseif($type === 'integer') {
					$record->$column = ($value !== 0);
				} elseif($type === 'string') {
					if($value === 'true' || $value === 'yes') {
						$record->$column = true;
					} else {
						$record->$column = false;
					}
				} else {
					$record->$column = false;
				}
			} elseif ($type == Model::TYPE_PASSWORD_MD5) {
				if(strlen($_POST['record'][$column]) > 0) {
					$value = md5($_POST['record'][$column]);
					$record->$column = $value;
				}
			} elseif ($type == Model::TYPE_RELATION_SIMPLE) {
				$relatedModelName = strtolower($column);
				$value = $_POST['record'][$column];
					
				$related = 'TODO: relations'; //R::load($relatedModelName, $value);
					
				$record->$column = $related;
			
			} elseif ($type == Model::TYPE_RELATION_OWN_SINGLE) {
				$relatedModelName = strtolower(substr($column, 3));
				$value = $_POST['record'][$column];

				$related = 'TODO: relations'; //R::load($relatedModelName, $value);
				
				$record->$column = $related;
			
			} elseif ($type == Model::TYPE_RELATION_OWN_MULTIPLE) {
				$relatedModelName = strtolower(substr($column, 3));
				$values = $_POST['record'][$column];
					
				$relatedArray = array();
				foreach($values as $id) {
				$related = 'TODO: relations'; //R::load($relatedModelName, $value);
					$relatedArray[] = $related;
				}
				
				$record->$column = $relatedArray;
			
			} elseif ($type == Model::TYPE_RELATION_SHARED) {
				$relatedModelName = strtolower(substr($column, 6));
				
				$values = $_POST['record'][$column];
					
				$relatedArray = array();
				foreach($values as $id) {
					$related = 'TODO: relations'; //R::load($relatedModelName, $value);
					$relatedArray[] = $related;
				}
				
				$record->$column = $relatedArray;
				
				
			} else {
				$value = $_POST['record'][$column];
				$record->$column = $value;
			}
		}
		
		$validation = $record->validate();
		
		if( is_bool($validation) && $validation) {
			$record->store();
		} elseif(is_array($validation)) {
			$_SESSION['validation'] = $validation;
			$_SESSION['record'] = $record;
			$this->frontController->redirect($this->modelName, 'show', array($id), 'admin');
			return;
		}

		$this->frontController->redirect('admin', $this->modelName);
	}

	public function DeleteAction($params) {
		$id = (int)$params[0];
		
		$record = $this->getModel();
		$record->load($id);
		$record->trash();

		$this->frontController->redirect('admin', $this->modelName);
	}

	protected function getModel($id = 0) {
		$className = 'Model_'.ucfirst($this->modelName);
		return new $className();
	}

	protected function getView($name) {
		$view = new View($name);
		$view->modelName = $this->modelName;

		return $view;
	}


}











