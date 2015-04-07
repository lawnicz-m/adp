<?php

class Controller {
	
	/**
	 * @var FrontController
	 */
	protected $frontController = null;
	
	/**
	 * @var bool
	 */
	protected $layoutEnabled = true;
	
	/**
	 * @var string
	 */
	protected $layoutName = 'layout';
	
	/**
	 * @var View
	 */
	protected $layout = null;
	
	/**
	 * @param FrntController $frontController
	 */
	public function __construct($frontController) {
		$this->frontController = $frontController;
		$this->layout = new View($this->layoutName);
		$this->layout->pageTitle = APPLICATION_NAME;
	}
	
	public function authorize() {
		//return true;
	    if (    isset ( $_SESSION ['id'] )
	         && isset ( $_SESSION ['login'] ) 
	         && isset ( $_SESSION ['typ'] ) 
	         && isset ( $_SESSION ['haslo'] ) 
	         && $_SESSION ['typ'] == 'admin'
           ) {
	            return true;
	        } else {
	            $this->frontController->redirectToLogin();
	        }
	
	}
	
	public function preDispatch($params) {
// 		gflog("Controller->preDispatch()");
		$this->autoloadCSS();
	}
	
	protected function autoloadCSS() {
		$module = $this->frontController->getModuleName();
		$controller = $this->frontController->getControllerName();
		
		$cssFiles = array();
		
		if($module !== null) {
			$filePath = "css/$module/layout.css";
			if(file_exists($filePath)) {
				$cssFiles[] = $filePath;
			}
			
			$paths = glob("css/$module/$controller/*.css");
			foreach ($paths as $filePath) {
				if(file_exists($filePath)) {
					$cssFiles[] = $filePath;
				}
			}
			
		} else {
			$filePath = "css/layout.css";
			if(file_exists($filePath)) {
				$cssFiles[] = $filePath;
			}
			
			$paths = glob("css/$controller/*.css");
			foreach ($paths as $filePath) {
				if(file_exists($filePath)) {
					$cssFiles[] = $filePath;
				}
			}
		}
		
		$this->layout->autoloadedCSS = $cssFiles;
	}
	
	public function postDispatch($params) {
		
	}
	
	public function isLayoutEnabled() {
		return $this->layoutEnabled;
	}
	
	public function setLayoutEnabled($bool) {
		$this->layoutEnabled = $bool;
	}
	
	
}