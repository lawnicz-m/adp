<?php

class AdminScaffoldController extends Scaffold {
	
	public function authorize() {
		if(isset($_SESSION['user'])) {
			$user = $_SESSION['user'];
	
			$refreshedUser = R::load('user', $user->id);
	
			if($refreshedUser->id == 0) {
				unset($_SESSION['user']);
			} else {
				if(!$refreshedUser->active) {
					unset($_SESSION['user']);
				} else {
					$_SESSION['user'] = $refreshedUser;
				}
			}			
		}
		
		$allowed = isset($_SESSION['user']) && (count($_SESSION['user']->ownRoot) > 0);
			
		$authorization = array(
				'allowed' => $allowed,
				'redirect' => array(
						'module' => 'admin',
						'controller' => 'index',
						'action' => 'noauth',
						'params' => array(),
				),
		);
	
		return $authorization;
	}

}