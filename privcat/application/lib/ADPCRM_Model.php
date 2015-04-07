<?php
abstract class ADPCRM_Model {

	protected $tableName=null;

	protected $idColumn=null;

	protected $columns=array ();

	protected $values=array ();

	public function __get($name) {
		return $this->values [$name];
	}

	public function __set($name, $value) {
		$this->values [$name]=$value;
	}

	public function createFromRow($row) {		
		foreach ( $this->columns as $columnName => $columnType ) {
			$this->values [$columnName]=$row [$columnName];
		}
	}

	public function getID() {
		return ( int ) $this->values [$this->idColumn];
	}
	
	public function getName() {
		if(isset($this->values['name'])) {
			return  $this->values['name'];
		} else {
			return $this->getID();
		}
	}

	public function store() {
		$id=$this->getID();
		
		$sql='';
		
		if ($id == 0) {
			$sql='INSERT INTO ' . $this->tableName . '(';
			
			$columns=$this->getColumns();
			
			$columnsSQL=implode(', ', $columns);
			
			$sql.=$columnsSQL . ') VALUES (';
			
			foreach ( $this->columns as $columnName => $columnType ) {

				if($columnName == $this->idColumn) {
					continue;
				}
				
				$value=$this->values [$columnName];
				if ($columnType == Model::TYPE_STRING) {
					$sql.='\'' . $value . '\'';
				} else {
					$sql.=$value;
				}
				
				$sql.=', ';
			}
			
			$sql=substr($sql, 0, strlen($sql) - 2);
			$sql.=')';
		} else {
			$sql='UPDATE ' . $this->tableName . ' SET ';
			
			$columns=$this->getColumns();
			
			foreach ( $this->columns as $columnName => $columnType ) {
				
				if($columnName == $this->idColumn) {
					continue;
				}
				
				$value=$this->values [$columnName];
				
				$colSql='';
				if ($columnType == Model::TYPE_STRING) {
					$colSql.='\'' . $value . '\'';
				} else {
					$colSql.=$value;
				}
				
				$colSet=$columnName . '=' . $colSql;
				
				$sql.=$colSet . ', ';
			}
			
			$sql=substr($sql, 0, strlen($sql) - 2);
			$sql.=' WHERE ' . $this->idColumn . '=' . $this->getID();
		}
		
		$dbh=new PDO('mysql:host=' . DB_HOST . ';port=' . DB_PORT . ';dbname=' . DB_NAME, DB_USER, DB_PASS);
		$rows_affected = $dbh->exec($sql);
		$insertId = $dbh->lastInsertId();
		
		return $insertId;
	}

	public function load($id) {
		$sql='SELECT * FROM ' . $this->tableName . ' WHERE ' . $this->idColumn . ' = ' . $id;
		
		$result=array ();
		$dbh=new PDO('mysql:host=' . DB_HOST . ';port=' . DB_PORT . ';dbname=' . DB_NAME, DB_USER, DB_PASS);
		$rows=$dbh->query($sql);
		
		foreach ( $rows as $row ) {
			foreach ( $this->columns as $columnName => $columnType ) {
				$this->values [$columnName]=$row [$columnName];
			}
			break;
		}
	}

	public function trash() {
		$sql='DELETE FROM '.$this->tableName.' WHERE '.$this->idColumn.' = '.$this->getID();
		$dbh=new PDO('mysql:host=' . DB_HOST . ';port=' . DB_PORT . ';dbname=' . DB_NAME, DB_USER, DB_PASS);
		$rows_affected = $dbh->exec($sql);
	}

	public function validate() {
		return true;
	}

	public function getTableName() {
		return $this->tableName;
	}

	public function getColumns() {
		$result=array ();
		
		foreach ( $this->columns as $columnName => $columnType ) {
			$result [$columnName]=$columnType;
		}
		
		return $result;
	}

	public function getVisibleColumns() {
		$result=array ();
		
		foreach ( $this->columns as $columnName => $columnType ) {
			$result [$columnName]=$columnType;
		}
		
		return $result;
	}
	
	public abstract function findAll($where = null, $limit = null);

}
