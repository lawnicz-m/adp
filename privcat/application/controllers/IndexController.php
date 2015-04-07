<?php

class IndexController extends Controller {
	
	public function preDispatch($params) {
		parent::preDispatch($params);
		
		$menu = new View('menu');
		$this->layout->menu = $menu;
		
		$_SESSION['privcat']['hideclient'] = false;
	}
	
	public function IndexAction($params) {
		$clientId = $params[0];
		
		$client = new Model_Client();
		$client->load($clientId);
		
		$_SESSION['privcat']['client'] = $client;

		$this->frontController->redirect('entries', 'client', array($clientId), 'privcat');
	}
	
}














