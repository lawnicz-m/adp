<?php

class View extends Smarty {
	protected $file;

	private $subViews = array();
	private $blocks = array();

	public function __construct($file) {
		parent::__construct();

		$this->file = $file . '.tpl';
		$this->setTemplateDir(SMRTY_TMPLT_DIR);
		$this->setCacheDir(SMRTY_CACHE_DIR);
		$this->setCompileDir(SMRTY_TMPLT_C_DIR);
		$this->setConfigDir(SMRTY_CNFG_DIR);
		$this->APP_BASE_URL = rtrim (APP_BASE_URL, "/");
	}

	public function render() {
		
		foreach ($this->subViews as $viewName => $view) {
			ob_start();
			$view->render();
			$viewRender = ob_get_clean();
			$this->blocks[$viewName] = $viewRender;
			gflog("Rendered view $viewName");
		}
		
		$this->assign($this->blocks);
		$this->display($this->file);
	}

	public function __set($name, $value) {
		
		if($value instanceof View) {
			$this->subViews[$name] = $value;
			$this->blocks[$name] = "#RENDER OF $name#";
			gflog("Registered subview $name");
		} else {
			$this->blocks[$name] = $value;
		}
		
	}

	public function __get($name) {
		if ( isset($this->subViews[$name]) ) {
			return $this->subViews[$name];
		}
		
		if ( isset($this->blocks[$name]) ) {
			return $this->blocks[$name];
		}
	}

	public function __isset($name) {
		if ( isset($this->subViews[$name]) ) {
			return true;
		}
		
		return isset($this->blocks[$name]);
	}

}

