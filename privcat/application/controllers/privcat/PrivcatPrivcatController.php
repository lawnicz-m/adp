<?php

class PrivcatPrivcatController extends Controller {
	
	public function preDispatch($params) {
		parent::preDispatch($params);
	
		$menu = new View('menu');
		$this->layout->menu = $menu;
		
		$_SESSION['privcat']['hideclient'] = true;
	}

	public function IndexAction($params) {
		$this->frontController->redirect('privcat', 'list');
	}
	
	public function ListAction($params) {
		
		$privcats = R::findAll('privcat');
		
		$view = new View('privcat/list');
		$view->privcats = $privcats;
		
		$this->layout->content = $view;
		$this->layout->render();
	}
	
	public function EditAction($params) {
		$id = 0;
		
		if(isset($params[0])) {
			$id = (int)$params[0];
		}
		
		$privcat = null;
		
		if($id != 0) {
			$privcat = R::load('privcat', $id);
		} else {
			$privcat = R::dispense('privcat');
		}
		
		$view = new View('privcat/edit');
		$view->privcat = $privcat;
		
		$this->layout->content = $view;
		$this->layout->render();
	}
	
	public function SaveAction($params) {
		
		if(!isset($_POST['privcat'])) {
			$this->frontController->redirect('index', 'index', array(), 'privcat');
		}
		
		$data = $_POST['privcat'];
		$id = $data['id'];
		
		if($id != 0) {
			$privcat = R::load('privcat', $id);
		} else {
			$privcat = R::dispense('privcat');
		}
		
		$privcat->name = $data['name'];
		$privcat->address = $data['address'];
		$privcat->ftpaddress = $data['ftpaddress'];
		$privcat->ftpuser = $data['ftpuser'];
		$privcat->ftppass = $data['ftppass'];
		$privcat->ftphash = $data['ftphash'];
		
		R::store($privcat);
		$this->frontController->redirect('privcat', 'list', array(), 'privcat');
	}
	
	public function HistoryAction($params) {		
// 		if(isset($params[0])) {
// 			$this->frontController->redirect('index', 'index', array(), 'privcat');
// 		}
		
		$id = (int)$params[0];
		
		$privcat = R::load('privcat', $id);
		$histories = $privcat->with(' ORDER BY datefrom ')->ownPrivcathistory;
		
		foreach ($histories as $key => $history) {
			$client = new Model_Client();
			$client->load($history->privcatentry->client);
			
			$phrase = new Model_Phrase();
			$phrase->load($history->privcatentry->phrase);
			
			$histories[$key]->client = $client;
			$histories[$key]->phrase = $phrase; 
		}
				
		$view = new View('privcat/history');
		$view->privcat = $privcat;
		$view->histories = $histories;
		
		$this->layout->content = $view;
		$this->layout->render();
	}
	
	public function TestFTPAction($params) {
		$id = (int)$params[0];
		
		$privcat = R::load('privcat', $id);
		
		$connection = @ftp_connect($privcat->ftpaddress);
		
		if($connection == false) {
			echo '<span class="error_message">Nie można odnaleść serwera</span>';
			return;
		}
		
		@ftp_login($connection,  $privcat->ftpuser,  $privcat->ftppass);
		$nlist = @ftp_nlist($connection, '.');
		
		if(is_array($nlist)) {
			echo '<span class="ok_message">Połączenie ok</span>';
		} else {
			echo '<span class="error_message">Nieprawidłowy user/pass</span>';
		}
	}
	
}