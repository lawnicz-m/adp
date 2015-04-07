<?php
class Model_Phrasehistory extends ADPCRM_Model {

	protected $tableName='frazy_wyniki';

	protected $idColumn='id_frazy';

	protected $columns=array (
			'data' => Model::TYPE_NORMAL,
			'id_frazy' => Model::TYPE_NORMAL,
			'pierwsza_strona' => Model::TYPE_NORMAL,
			'wynik' => Model::TYPE_NORMAL,
	);

	public static function findFor($phrase, $fromDate, $toDate) {
		$sql='SELECT * FROM frazy_wyniki WHERE id_frazy = ' . $phrase->getID() . ' AND data >= \'' . $fromDate . '\' AND data <= \'' . $toDate . '\'';
				
		$result=array ();
		$dbh=new PDO('mysql:host=' . DB_HOST . ';port=' . DB_PORT . ';dbname=' . DB_NAME, DB_USER, DB_PASS);
		$rows=$dbh->query($sql);
		
		foreach ( $rows as $row ) {
			$model=new Model_Phrasehistory();
			$model->createFromRow($row);
			$result[$model->data]=$model;
		}
		
		return $result;
	}
	
	public function findAll($where = null, $limit = null) {
		return array();
	}


}












