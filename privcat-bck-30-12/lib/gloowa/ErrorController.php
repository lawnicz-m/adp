<?php

class ErrorController extends Controller {
	
	public function NotFoundAction($params) {
		$view = new View('error/not_found');
		
		$view->errorMessages = array();
		if(isset($params['message'])) {
			$view->errorMessages = array($params['message']);
		}
		
		
		$view->render();
	}
	
	public function RestrictedAction($params) {
		$view = new View('error/access_restricted');
		
		$view->errorMessages = array($params['message']);
		$view->render();
	}
	
	public function InternalErrorAction($params) {
		$view = new View('error/internal_error');
		
		$view->exception = false;
		if(isset($params['exception']) && (TESTING || DEBUG)) {
			$exception = $params['exception'];
			$view->exception = $exception;
// 			pre($exception->getTrace());
		}

		$view->errorMessages = array();
		if(isset($params['message'])) {
			$view->errorMessages = array($params['message']);
		}
		
		$view->render();
	}
	
}
