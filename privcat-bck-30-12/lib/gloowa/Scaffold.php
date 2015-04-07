<?php

class Scaffold extends Controller {

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
		$records = R::findAll($this->modelName);
		
		$content = $this->getView('scaffold/list');
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
			
			if($id == 0) {
				$record = R::dispense($this->modelName);
			} else {
				$record = R::load($this->modelName, $id);
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

		$record = null;
		if($id !== 0) {
			$record = R::load($this->modelName, $id);
		} else {
			$record = R::dispense($this->modelName);
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
					
				$related = R::load($relatedModelName, $value);
					
				$record->$column = $related;
			
			} elseif ($type == Model::TYPE_RELATION_OWN_SINGLE) {
				$relatedModelName = strtolower(substr($column, 3));
				$value = $_POST['record'][$column];
					
				$related = R::load($relatedModelName, $value);
				
				$record->$column = $related;
			
			} elseif ($type == Model::TYPE_RELATION_OWN_MULTIPLE) {
				$relatedModelName = strtolower(substr($column, 3));
				$values = $_POST['record'][$column];
					
				$relatedArray = array();
				foreach($values as $id) {
					$related = R::load($relatedModelName, $id);
					$relatedArray[] = $related;
				}
				
				$record->$column = $relatedArray;
			
			} elseif ($type == Model::TYPE_RELATION_SHARED) {
				$relatedModelName = strtolower(substr($column, 6));
				
				$values = $_POST['record'][$column];
					
				$relatedArray = array();
				foreach($values as $id) {
					$related = R::load($relatedModelName, $id);
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
			R::store($record);
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
		
		$record = R::load($this->modelName, $id);
		R::trash($record);

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











