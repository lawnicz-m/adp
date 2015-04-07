<?php

class Model extends RedBean_SimpleModel {

	const TYPE_NORMAL = 'normal';
	const TYPE_INT = 'int';
	const TYPE_STRING = 'string';
	const TYPE_FLOAT = 'float';
	const TYPE_PASSWORD_MD5 = 'password_md5';
	const TYPE_BOOLEAN = 'boolean';
	const TYPE_RELATION_SIMPLE = 'relation_simple';
	const TYPE_RELATION_SHARED = 'relation_shared';
	const TYPE_RELATION_OWN_SINGLE = 'relation_own_single';
	const TYPE_RELATION_OWN_MULTIPLE = 'relation_own_multiple';
	const TYPE_COMPUTED = 'computed';
	
	protected $columns = array();
	protected $hiddenColumns = array();
	
	public function getName() {
		if(isset($this->bean->name)) {
			return $this->bean->name;
		} else {
			return $this->bean->id;
		}
	}
	
	public function getColumns() {
		return $this->columns;
	}
	
	public function getHiddenColumns() {
		return $this->hiddenColumns;
	}
	
	public function getVisibleColumns() {
		$result = array();
		
		foreach($this->columns as $columnName => $columnType) {
			if(!in_array($columnName, $this->hiddenColumns)) {
				$result[$columnName] = $columnType;
			}
		}
		
		return $result;
	}

	public static function getAllModelNames() {
		$result = array();

		$files = glob('application/models/*.php');
		foreach($files as $filePath) {
			$fileName = basename($filePath);
			$modelName = strtolower(substr($fileName, 6, strlen($fileName)-10));
			$result[] = $modelName;
		}
		
		return $result;
	}
	
	public function relationOptions($columnName) {
		$relatedModelName = '';
		
		if($this->columns[$columnName] == self::TYPE_RELATION_SIMPLE) {
			$relatedModelName = $columnName;
		} elseif ($this->columns[$columnName] == self::TYPE_RELATION_OWN_SINGLE) {
			$relatedModelName = strtolower(substr($columnName, 3));
		} elseif ($this->columns[$columnName] == self::TYPE_RELATION_OWN_MULTIPLE) {
			$relatedModelName = strtolower(substr($columnName, 3));
		} elseif ($this->columns[$columnName] == self::TYPE_RELATION_SHARED) {
			$relatedModelName = strtolower(substr($columnName, 6));
		} else {
			throw new Exception("Column is not a relation!");
		}
		
		$relatedModelClassName = 'Model_'.ucfirst($relatedModelName);
		$relatedModel = new $relatedModelClassName();
		
		$all = R::findAll($relatedModelName);
		
		$result = array();
		foreach($all as $bean) {
// 			if(isset($bean->name)) {
// 				$result[$bean->id] = $bean->name;
// 			} else {
				$result[$bean->id] = $bean->getName();
// 			}
		}
		
		return $result;
	}
	
	public function relationSelected($columnName) {
		$result = null;
		
		if(isset($this->bean)) {
			if($this->bean->id == 0) {
				return null;
			}
		} else {
			return null;
		}
		
		if($this->columns[$columnName] == self::TYPE_RELATION_SIMPLE) {
			$result = $this->bean->$columnName->id;
			
		} elseif ($this->columns[$columnName] == self::TYPE_RELATION_OWN_SINGLE) {
			$result = $this->bean->$columnName->id;
			
		} elseif ($this->columns[$columnName] == self::TYPE_RELATION_OWN_MULTIPLE) {
			$relatedModelName = strtolower(substr($columnName, 3));
			foreach ($this->bean->$columnName as $bean) {
				$result[] = $bean->id;
			}
			
		} elseif ($this->columns[$columnName] == self::TYPE_RELATION_SHARED) {
			$relatedModelName = strtolower(substr($columnName, 6));
			foreach ($this->bean->$columnName as $bean) {
				$result[] = $bean->id;
			}
			
		} else {
			throw new Exception("Column is not a relation!");
		}
		
		return $result;
	}
	
	public function validate() {
		return true;
	}
	
	/*
	R::store	$model->update()
	R::store	$model->after_update()
	R::load		$model->open()
	R::trash	$model->delete()
	R::trash	$model->after_delete()
	R::dispense	$model->dispense()
	*/
	
}




