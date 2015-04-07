<?php
class Model_Phrase extends ADPCRM_Model {

	protected $tableName='frazy';

	protected $idColumn='id_frazy';

	protected $columns=array (
			'id_frazy' => Model::TYPE_NORMAL,
			'id_klienta' => Model::TYPE_NORMAL,
			'nazwa' => Model::TYPE_NORMAL,
			'fraza_link' => Model::TYPE_NORMAL,
			'typ' => Model::TYPE_NORMAL,
			'kwota_za_fraze' => Model::TYPE_NORMAL,
	);

	public function findAll($where = null, $limit = null) {
		$sql='SELECT * FROM ' . $this->tableName  . ' WHERE 1 ';
		if($where != null) {
			$sql .= ' AND '.$where;
		}
		
		if($limit != null) {
			$sql .= ' LIMIT '.$limit;
		}
		
		$result=array ();
		$dbh=new PDO('mysql:host=' . DB_HOST . ';port=' . DB_PORT . ';dbname=' . DB_NAME, DB_USER, DB_PASS);
		$rows=$dbh->query($sql);
		
		foreach ( $rows as $row ) {
			$model=new Model_Phrase();
			$model->createFromRow($row);
			$result[$model->getId()]=$model;
		}
		
		return $result;
	}

	public function getHistory($dateFrom, $dateTo) {
		$history = Model_Phrasehistory::findFor($this, $dateFrom, $dateTo);
		return $history;
	}

	public function getResult($date) {		
		$sql='SELECT * FROM frazy_wyniki WHERE id_frazy = '.$this->getID() . ' AND data = \''.$date.'\'';		
		
		$result=null;
		$dbh=new PDO('mysql:host=' . DB_HOST . ';port=' . DB_PORT . ';dbname=' . DB_NAME, DB_USER, DB_PASS);
		$rows=$dbh->query($sql);
		
		foreach ( $rows as $row ) {
			$model=new Model_Phrasehistory();
			$model->createFromRow($row);
			$result=$model;
		}
		
		return $result;
	}

	public function getCurrentPrivcatCount() {
		
		$entriesCount = R::count('privcatentry', 'phrase = ? AND uploaded = ?', array($this->getId(), true));
		
		return $entriesCount;
	}
	
	public function getPrice() {

		if ($this->typ == 1) {
			return $this->kwota_za_fraze . 'zł';
		}
		
		if ($this->typ == 2) {
			return 'ryczalt';
		}
		
		return '??';
		
	}
	
}












