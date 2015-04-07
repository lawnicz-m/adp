<?php

class PrivcatClientsController extends Controller {

	public function preDispatch($params) {
		parent::preDispatch($params);

		$menu = new View('menu');
		$this->layout->menu = $menu;
		
		$_SESSION['privcat']['hideclient'] = true;
	}

	public function IndexAction($params) {
		$this->frontController->redirect('clients', 'list', array(), 'privcat');
	}
	
	public function ListAction($params) {

		$sort = 'entries';
		
		if(isset($_SESSION['clientslist']['sort'])) {
			$sort = $_SESSION['clientslist']['sort'];
		}
		
		if(isset($_POST['listsort'])) {
			$sort = $_POST['listsort'];
		}
		
		$clients = new Model_Client();
		$clients = $clients->getAllSortedBy($sort);
		
		$_SESSION['clientslist']['sort'] = $sort;
		
		$view = new View('clients/list');
		$view->clients = $clients;
		$view->sort = $sort;
		
		$this->layout->content = $view;
		$this->layout->render();
		
	}
	
}