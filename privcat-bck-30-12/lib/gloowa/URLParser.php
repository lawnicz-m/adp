<?php


class URLParser {
	
	/**
	 * @var string
	 */
	protected $rawURL = '';
	
	/**
	 * @var integer
	 */
	protected $partsCount = 0;
	
	/**
	 * @var string
	 */
	protected $module = null;
	
	/**
	 * @var string
	 */
	protected $controller = null;

	/**
	 * @var string
	 */
	protected $action = null;

	/**
	 * @var array
	 */
	protected $params = null;
	
	/**
	 * Constructs the parser. Supplied is automagically parsed and data can be accesed immediatly.
	 * @param string $rawURL URL address to be parsed
	 */
	public function __construct($rawURL) {
		$this->rawURL = $rawURL;
		$this->parse();
	}
	
	/**
	 * Main parse routine
	 */
	private function parse() {
		$urlParts = array_slice(explode('/', strtolower($this->rawURL)), 1);
		
		for ($i=0; $i<count($urlParts); $i++) {
			if(empty($urlParts[$i])) {
				unset($urlParts[$i]);
			}
		}
		
		$urlParts = array_values($urlParts);
		$this->partsCount = count($urlParts);
				
		switch($this->partsCount) {
			
			case 0 : // empty path, should default to index/index
				$this->controller = 'index';
				$this->action = 'index';
				break;
			
			case 1 :
				if($this->moduleExists($urlParts[0])) {
					$this->module = $urlParts[0];
					$this->controller = 'index';
					$this->action = 'index';
				} else {
					$this->controller = $urlParts[0];
					$this->action = 'index';
				}
				break;
			
			case 2 :
				if($this->moduleExists($urlParts[0])) {
					$this->module = $urlParts[0];
					$this->controller = $urlParts[1];
					$this->action = 'index';
				} else {
					$this->controller = $urlParts[0];
					$this->action = $urlParts[1];
				}
				break;
			
			default :
				if($this->moduleExists($urlParts[0])) {
					$this->module = $urlParts[0];
					$this->controller = $urlParts[1];
					$this->action = $urlParts[2];
					
					$this->params = array_slice($urlParts, 3);
				} else {
					$this->controller = $urlParts[0];
					$this->action = $urlParts[1];
					
					$this->params = array_slice($urlParts, 2);
				}
				
				break;
		} // switch
		
	}
	
	/**
	 * Checks for existence of module by searching for
	 * subdirectory in controllers directory (application/controllers/moduleName)
	 *
	 * @param string $moduleName
	 */
	private function moduleExists($moduleName) {
		$modulePath = 'application/controllers/'.strtolower($moduleName);
		
		if (file_exists($modulePath) and is_dir($modulePath)) {
			return true;
		} else {
			return false;
		}
	}
	
	public function hasModule() {
		return $this->module !== null;
	}
	
	public function getModule() {
		return $this->module;
	}
	
	public function getController() {
		return $this->controller;
	}
	
	public function getAction() {
		return $this->action;
	}
	
	public function getParams() {
		return $this->params;
	}
	
	
}



















