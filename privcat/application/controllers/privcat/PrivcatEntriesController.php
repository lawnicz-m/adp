<?php

class PrivcatEntriesController extends Controller {

	public function preDispatch($params) {
		parent::preDispatch($params);

		$menu = new View('menu');
		$this->layout->menu = $menu;
		
		$_SESSION['privcat']['hideclient'] = false;
	}

	public function IndexAction($params) {
		$this->frontController->redirect('entries', 'list', array(), 'privcat');
	}
	
	public function ClientAction($params) {
		$clientId = (int)$params[0];
		
		$client = new Model_Client();
		$client->load($clientId);
		
		$entries = $client->getEntries();
		
		$view = new View('entries/client');
		$view->client = $client;
		$view->entries = $entries;
		
		$this->layout->content = $view;
		$this->layout->render();
	}
	
	public function AjaxgethistoryAction($params) {
		$phraseId = $params[0];
		$date = $params[1];
		$nextDate = date('Y-m-d', strtotime($date.' +1 day'));
		
		$histories = R::findAll(
				'privcathistory',
				' phrase = ? AND ((datefrom >= ? AND datefrom < ?) OR (dateto >= ? AND dateto < ?))',
				array(
						$phraseId,
						$date,
						$nextDate,
						$date,
						$nextDate,
				)
		);	
		
		foreach ($histories as $history) {
			$client = new Model_Client();
			$client->load($history->privcatentry->client);
			
			$phrase = new Model_Phrase();
			$phrase->load($history->phrase);
			
			$history->client = $client;
			$history->phrase = $phrase;
		}		
		
		$view = new View('entries/ajaxhistory');
		$view->histories = $histories;
		
		$view->render();
	}
	
	public function NewAction($params) {
		$clientId = (int)$params[0];
		
		$notEnoughTexts = isset($params[1]);
		
		$client = new Model_Client();
		$client->load($clientId);

		$phrases = new Model_Phrase();
		$phrases = $phrases->findAll(' id_klienta = '.$clientId);
		
		$preselectionData = array();
// 		pre($_SESSION['newentriesformdatacat']);
		
		$categories = R::findAll('privcatcategory');
		
		$preselectedCtegoryId = 0;
		if(isset($_SESSION['newentriesformdatacat'])) {
			$preselectedCtegoryId = $_SESSION['newentriesformdatacat']['privcatcategory'];
		} else {
			reset($categories);
			$preselectedCtegoryId = key($categories);
		}
		
		if(isset($_SESSION['newentriesformdata'])) {
			$data = $_SESSION['newentriesformdata'];
			
			foreach ($phrases as $phrase) {
				if(isset($data[$phrase->getID()])) {
					$preselectionData[$phrase->getID()] = $data[$phrase->getID()];
					
					$preselectionData[$phrase->getID()]['selected'] = isset($preselectionData[$phrase->getID()]['selected']);
					
				} else {
					$preselectionData[$phrase->getID()]['count'] = 1;
					$preselectionData[$phrase->getID()]['selected'] = false;
				}
			}
		} else {
			foreach ($phrases as $phrase) {
				$preselectionData[$phrase->getID()]['count'] = 1;
				$preselectionData[$phrase->getID()]['selected'] = false;
			}
		}
		
// 		pre($preselectionData);
		
		$view = new View('entries/new');
		$view->client = $client;
		$view->categories = $categories;
		$view->phrases = $phrases;
		$view->numTexts = $client->getNumOfAvailableTexts();
		$view->notEnoughTexts = $notEnoughTexts;
		$view->preselectionData = $preselectionData;
		$view->preselectedCtegoryId = $preselectedCtegoryId;
		
		$this->layout->content = $view;
		$this->layout->render();
	}
	
	public function SaveAction($params) {
		$clientId = (int)$params[0];
		
		$client = new Model_Client();
		$client->load($clientId);
		
		$data = $_POST['entry'];
		$phrasesData = $_POST['phrases'];
		
		$availableTexts = $client->getAvailableTexts();
		
		$totalCount = 0;
		
		foreach($phrasesData as $phraseId => $phraseData) {
			
			$count = (int)$phraseData['count'];
			$selected = isset($phraseData['selected']);
			
			if($selected) {
				$totalCount += $count;
			}
		}
		
		if($totalCount > count($availableTexts)) {			
			$_SESSION['newentriesformdata'] = $phrasesData;
			$_SESSION['newentriesformdatacat'] = $data;
			
			$this->frontController->redirect('entries', 'new', array($clientId, 'notentoughtexts'), 'privcat');
		} else {			
			unset($_SESSION['newentriesformdata']);
			unset($_SESSION['newentriesformdatacat']);
			
			foreach($phrasesData as $phraseId => $phraseData) {
				
				$count = (int)$phraseData['count'];
				$selected = isset($phraseData['selected']);
				
				if($selected) {
					for($i=0; $i<$count; $i++) {
						$entry = R::dispense('privcatentry');
						
						$text = array_shift($availableTexts);
		
						$privcat = $this->selectPrivcat(count($phrasesData), $client);
		
						$entry->privcat = $privcat;
						$entry->text = $text;
						$entry->client = $clientId;
						$entry->phrase = $phraseId;
						$entry->privcatcategory = R::load('privcatcategory', $data['privcatcategory']);
						$entry->uploaded = false;
						$entry->uploadedon = null;
						$entry->deleted = false;
		
						R::store($entry);
					}
				}
				
			}
			
			$this->frontController->redirect('entries', 'client', array($clientId), 'privcat');
		}
		
		
	}
	
	protected function selectPrivcat($totalEntries, $client) {
		$availablePrivcats = Model_Privcat::getAvailablePrivcats($client);
		
		usort($availablePrivcats, array('Model_Privcat','compareEntryCount'));
		
		$numToSelect = 2*$totalEntries;
		
		$selectable = array_slice($availablePrivcats, 0, $numToSelect, false);
		
		$random = rand(0, count($selectable)-1);
				
		return $selectable[$random];
	}
	
	public function ListAction($params) {
		
		$privcatId = (int)$params[0];		
		$privcats = R::findAll('privcat');
		
		if($privcatId == 0) {
			$view = new View('entries/selectprivcat');
			
			$view->privcats = $privcats;
			
			$this->layout->content=$view;
			$this->layout->render();
			return;
		}
		
		$privcat = R::load('privcat', $privcatId);
		$entries = $privcat->ownPrivcatentry;
		
		$view = new View('entries/list');
		$view->privcats = $privcats;
		$view->privcat = $privcat;
		$view->entries = $entries;
		
		$this->layout->content = $view;
		$this->layout->render();
		
	}
	
	public function PublishAction($params) {
		$entryId = $params[0];
		
		$entry = R::load('privcatentry', $entryId);
		
		$entry->publish(Model_Privcatentry::FTP);
		
		$entry->uploaded = true;
		$entry->uploadedon = date('Y-m-d H:i:s');
		R::store($entry); 
				
		$this->frontController->redirect('entries', 'client', array($entry->client), 'privcat');
		
	}
	
	public function UnpublishAction($params) {
		$entryId = $params[0];
		
		$entry = R::load('privcatentry', $entryId);
		
		$entry->unpublish(Model_Privcatentry::FTP);
		
		$entry->uploaded = false;
		$entry->uploadedon = null;
		R::store($entry); 
				
		$this->frontController->redirect('entries', 'client', array($entry->client), 'privcat');
		
	}
	
	public function RemoveAction($params) {
		$entryId = $params[0];
		
		$entry = R::load('privcatentry', $entryId);
		if($entry->uploaded) {		
			$entry->unpublish(Model_Privcatentry::FTP);
			$entry->uploaded = false;
			$entry->uploadedon = null;
		}
				
		$entry->deleted = true;
		R::store($entry); 
				
		$this->frontController->redirect('entries', 'client', array($entry->client), 'privcat');
		
	}
	
	public function HistoryAction($params) {
		$clientId = (int)$params[0];

		$timeFrom = strtotime('midnight -30 days');
		$timeTo = strtotime('tomorrow midnight');

		$dateFrom = date('Y-m-d H:i:s', $timeFrom);
		$dateTo = date('Y-m-d H:i:s', $timeTo);

		$dates = array();
		
		for($i=-30; $i<1; $i++) {
			$dates[] = date('Y-m-d', strtotime('midnight '.$i.' days') );
		}
		
		$client = new Model_Client();
		$client->load($clientId);
		
		$phrases = $client->getPhrases();
		$entries = $client->getEntries();
		
		$histories = array();
		
		foreach ($phrases as $phrase) {
			$histories[$phrase->getID()] = array();

			foreach ($dates as $date) {
				$nextDate = date('Y-m-d', strtotime($date.' +1 day'));
				
				$histories[$phrase->getID()][$date] = array();
				
				$phraseResult = $phrase->getResult($date);
				
				if($phraseResult == null) {
					$phraseResult = new Model_Phrasehistory();
					$phraseResult->wynik = 500;
				}
				
				$histories[$phrase->getID()][$date]['results'] = $phraseResult;
				
				$privcatFromHistory = R::findAll('privcathistory', 'phrase = ? AND datefrom >= ? AND datefrom < ?', array($phrase->getID(), $date, $nextDate));
				$privcatToHistory = R::findAll('privcathistory', 'phrase = ? AND datefrom >= ? AND datefrom < ?', array($phrase->getID(), $date, $nextDate));

				$histories[$phrase->getID()][$date]['privcatsfrom'] = $privcatFromHistory;
				$histories[$phrase->getID()][$date]['privcatsto'] = $privcatToHistory;
			}
		}
		
		
		$view = new View('entries/history');
		$view->dates = $dates;
		$view->phrases = $phrases;
		$view->histories = $histories;
		$view->client = $client;
		
		$this->layout->content = $view;
		$this->layout->render();
	}
	

	public function HistorysubmitAction($params) {
		$clientId = (int)$params[0];
		
		$phrasesData = $_POST['phrases'];
		
// 		pre($phrasesData);
// 		die;
	
		$_SESSION['newentriesformdata'] = $phrasesData;
				
		$this->frontController->redirect('entries', 'new', array($clientId), 'privcat');	
	}

}