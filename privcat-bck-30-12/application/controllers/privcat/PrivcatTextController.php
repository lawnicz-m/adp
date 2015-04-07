<?php
class PrivcatTextController extends Controller {

	public function preDispatch($params) {
		parent::preDispatch ( $params );
		
		$menu = new View ( 'menu' );
		$this->layout->menu = $menu;
		
		$_SESSION['privcat']['hideclient'] = false;
	}

	public function IndexAction($params) {
		$this->frontController->redirect ( 'text', 'list' );
	}

	public function ListAction($params) {
		$clientId = ( int ) $params [0];
		
		if ($clientId == 0) {
			$texts = R::findAll ( 'text', ' client = ? AND deleted = ?', array (
					null,
					false 
			) );
			$view = new View ( 'text/list-noowner' );
			$view->texts = $texts;
			
			$this->layout->content = $view;
			$this->layout->render ();
			return;
		}
		
		$client = new Model_Client ();
		$client->load ( $clientId );
		
		$texts = R::findAll ( 'text', ' client = ? AND deleted = ?', array (
				$clientId,
				false 
		) );
		
		$view = new View ( 'text/list' );
		$view->client = $client;
		$view->texts = $texts;
		
		$this->layout->content = $view;
		$this->layout->render ();
	}

	public function EditAction($params) {
		$clientId = ( int ) $params [0];
		$textId = 0;
		
		if (isset ( $params [1] )) {
			$textId = ( int ) $params [1];
		}
		
		$text = null;
		
		if ($clientId == 0) {
			$this->frontController->redirect ( 'text', 'list', array (
					$clientId 
			), 'privcat' );
		}
		
		if ($textId != 0) {
			$text = R::load ( 'text', $textId );
		} else {
			$text = R::dispense ( 'text' );
		}
		
		$view = new View ( 'text/edit' );
		$view->text = $text;
		
		$this->layout->content = $view;
		$this->layout->render ();
	}

	public function SaveAction($params) {
		if (! isset ( $_POST ['text'] )) {
			$this->frontController->redirect ( 'text', 'list', array (
					$clientId 
			), 'privcat' );
			return;
		}
		
		$data = $_POST ['text'];
		$textId = $data ['id'];
		;
		$clientId = $data ['client'];
		
		if ($clientId == 0) {
			$this->frontController->redirect ( 'text', 'index', array (), 'privcat' );
			return;
		}
		
		if ($textId != 0) {
			$text = R::load ( 'text', $textId );
		} else {
			$text = R::dispense ( 'text' );
		}
		
		$text->deleted = false;
		$text->client = $clientId;
		$text->content = $data ['content'];
		
		R::store ( $text );
		$this->frontController->redirect ( 'text', 'list', array (
				$clientId 
		), 'privcat' );
	}

	public function RemoveAction($params) {
		$clientId = ( int ) $params [0];
		$textId = ( int ) $params [1];
		
		if ($clientId == 0) {
			$this->frontController->redirect ( 'text', 'list', array (
					$clientId 
			), 'privcat' );
		}
		
		if ($textId != 0) {
			$text = R::load ( 'text', $textId );
			
			$entry = $text->getCurrentEntry ();
			
			if ($entry != null) {
				$entry->unpublish ( Model_Privcatentry::FTP );
				
				$entry->uploaded = false;
				$entry->uploadedon = null;
				$entry->deleted = true;
				
				R::store ( $entry );
			}
			
			$text->deleted = true;
			
			R::store ( $text );
		}
		
		$this->frontController->redirect ( 'text', 'list', array (
				$clientId 
		), 'privcat' );
	}

	public function TestFTPAction($params) {
		$id = ( int ) $params [0];
		
		$privcat = R::load ( 'privcat', $id );
		
		$connection = @ftp_connect ( $privcat->ftpaddress );
		
		if ($connection == false) {
			echo '<span class="error_message">Nie można odnaleść serwera</span>';
			return;
		}
		
		@ftp_login ( $connection, $privcat->ftpuser, $privcat->ftppass );
		$nlist = @ftp_nlist ( $connection, '.' );
		
		if (is_array ( $nlist )) {
			echo '<span class="ok_message">Połączenie ok</span>';
		} else {
			echo '<span class="error_message">Nieprawidłowy user/pass</span>';
		}
	}

}