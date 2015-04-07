<?php

class Model_Text extends Model {
	
	protected $columns = array(
		'content' => MODEL::TYPE_NORMAL,
		'client' => MODEL::TYPE_NORMAL,
		'deleted' => Model::TYPE_BOOLEAN,
		'ownPrivcatentry' => Model::TYPE_RELATION_OWN_MULTIPLE,
	);
	
	public function canBeDeleted() {		
		return $this->getCurrentEntry() == null;
	}
	
	public function getCurrentEntry() {
		$entries = $this->ownPrivcatentry;
		
		foreach($entries as $entry) {
			if($entry->uploaded) {
				return $entry;
			}
		}
		
		return null;
	}
	
}