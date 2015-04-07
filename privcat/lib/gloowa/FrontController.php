<?php

class FrontController {

	/**
	 * @var Controller
	 */
	protected $controller = null;

	/**
	 * @var string
	 */
	protected $layout = 'layout';
	
	/**
	 * @var string
	 */
	protected $moduleName = null;

	/**
	 * @var string
	 */
	protected $controllerName = null;

	/**
	 * @var string
	 */
	protected $actionName = null;

	/**
	 * @var string
	 */
	protected $params = null;

	public function __construct() {
	}

	/**
	 * Invokes parsing the url and executes appropriate Controller
	 */
	public function dispatch() {
		session_start();
		
		$path = parse_url( $_SERVER['REQUEST_URI']);
		$path = $path['path'];

		$urlParser = new URLParser($path);
		
		$this->moduleName = $urlParser->getModule();
		$this->controllerName = $urlParser->getController();
		$this->actionName = $urlParser->getAction();
		$this->params = $urlParser->getParams();
		
		$this->invokeController();
	}

	protected function invokeController() {
// 		gflog("FrontController: $this->moduleName, $this->controllerName, $this->actionName");
		
		$controllerClassName = '';
		if($this->moduleName !== null) {
			$controllerClassName .= ucfirst($this->moduleName);
		}
		
		$controllerClassName .= ucfirst($this->controllerName) . 'Controller';
		
		if(!class_exists($controllerClassName)) {
			gflog('Controller '.$controllerClassName.' not found.');
			
			$this->moduleName = null;
			$this->controllerName = 'error';
			$this->actionName = 'NotFound';
			$this->params = array('message' => 'Controller '.$controllerClassName.' not found.');
			
			$this->invokeController();
			return;
		}
		
		$controllerInstance = new $controllerClassName($this);
		
		$actionFunctionName = ucfirst($this->actionName) . 'Action';
		
		if(!method_exists($controllerInstance, $actionFunctionName)) {
			gflog('Action '.$this->actionName.' ('.$actionFunctionName.') in '.$controllerClassName.' not found');
			
			$this->moduleName = null;
			$this->controllerName = 'error';
			$this->actionName = 'NotFound';
			$this->params = array('message' => 'Action '.$actionFunctionName.' not found in '.$controllerClassName);
			
			$this->invokeController();
			return;
		}
		
		$authorization = $controllerInstance->authorize();
		
		if( is_bool($authorization) ) {
			if( $authorization ) {
				$this->execController($controllerInstance, $actionFunctionName, $this->params);
			} else {
				$this->moduleName = null;
				$this->controllerName = 'error';
				$this->actionName = 'restricted';
				$this->params = array('message' => 'You can not access '.$actionFunctionName.' in '.$controllerClassName);
	
				$this->invokeController();
				return;
			}
		} elseif (is_array($authorization)) {
			if( $authorization['allowed'] ) {
				$this->execController($controllerInstance, $actionFunctionName, $this->params);
			} else {
				$redirectModule = $authorization['redirect']['module'];
				$redirectController = $authorization['redirect']['controller'];
				$redirectAction = $authorization['redirect']['action'];
				$redirectParams = $authorization['redirect']['params'];
				
				$backURL = array(
						'module' => $this->moduleName,
						'controller' => $this->controllerName,
						'action' => $this->actionName,
						'params' => $this->params,
				);
				
				$_SESSION['backURL'] = $backURL;
				
				$this->redirect($redirectController, $redirectAction, $redirectParams, $redirectModule);
				return;
			}
		}
		
		return true;
	}
	
	/**
	 * Executes controller in proper order:
	 * preDispatch()
	 * Action()
	 * postDispatch()
	 *
	 * Action params are passed to pre/post Dispatch methods.
	 *
	 * @param Controller $controllerInstance
	 * @param string $actionFunctionName
	 * @param array $params
	 */
	private function execController($controllerInstance, $actionFunctionName, $params) {
		try {
			$controllerInstance->preDispatch($params);
			$controllerInstance->$actionFunctionName($params);
			$controllerInstance->postDispatch($params);
		} catch(Exception $e) {
			if($this->controllerName == 'error') {
				// complete failure -> error controller failed
				return;
			} else {
				$this->moduleName = null;
				$this->controllerName = 'error';
				$this->actionName = 'internalError';
				
				$errorControllerInstance = new ErrorController($this);
				
				$this->execController($errorControllerInstance, 'internalErrorAction', array('exception' => $e));
			}
		}
	}

	/**
	 * Redirects to supplied module/controller/action
	 *
	 * @param string $controller
	 * @param string $action
	 * @param array $params
	 */
	public function redirect($controller = 'index', $action = 'index', $params = array(), $module = null) {
		$paramString = implode("/", $params);
		
		if($module !== null) {
			header('Location: /'.$module.'/'.$controller.'/'.$action.'/'.$paramString);
		} else {
			header('Location: /'.$controller.'/'.$action.'/'.$paramString);
		}
		
	}
	public function redirectToLogin()
	{
	    header('Location: ' . APP_BASE_URL);
	}
	
	public function getModuleName() {
		return $this->moduleName;
	}
	
	public function getControllerName() {
		return $this->controllerName;
	}
	
	public function getActionName() {
		return $this->actionName;
	}
	
	public function getParams() {
		return $this->params;
	}

}













