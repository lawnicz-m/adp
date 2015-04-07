<?php

class Model_Privcat extends Model {
	
	protected $columns = array(
		'name' => MODEL::TYPE_NORMAL,
		'address' => MODEL::TYPE_NORMAL,
		'ftpaddress' => MODEL::TYPE_NORMAL,
		'ftpuser' => MODEL::TYPE_NORMAL,
		'ftppass' => MODEL::TYPE_NORMAL,
		'ftphash' => MODEL::TYPE_NORMAL,
		'ownPrivcatentry' => Model::TYPE_RELATION_OWN_MULTIPLE,
		'ownPrivcathistory' => Model::TYPE_RELATION_OWN_MULTIPLE,	
	);
	
	public function getNumberOfEntries() {
		return $this->bean->withCondition('deleted = ? ', array(false))->countOwn('privcatentry');
	}

	public function getNumberOfPublishedEntries() {
		return $this->bean->withCondition('uploaded = ? AND deleted = ?', array(true, false))->countOwn('privcatentry');
	}
	
	public static function getAvailablePrivcats($client) {
		
		$availablePrivcats = array();
		$allPrivcats = R::findAll('privcat');
		
		foreach($allPrivcats as $privcat) {
			
			$entries = $privcat->withCondition(' deleted = ? ', array(false))->ownPrivcatentry;
			
			$ok = true;
			foreach($entries as $entry) {
				if($entry->client == $client->getID()) {
					$ok = false;
				}
			}
			
			if($ok) {
				$availablePrivcats[$privcat->id] = $privcat;
			}
		}
		
		return $availablePrivcats;
	}
	
	public static function compareEntryCount($a, $b) {
		return $a->getNumberOfPublishedEntries() - $b->getNumberOfPublishedEntries();
	}
	
}