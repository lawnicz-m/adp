<?php

class Paginator {
	
	protected $controller;
	protected $action;
	protected $params;
	protected $elementCount;
	protected $elementsPerPage;
	protected $currentPage;
	protected $margin = 3;
	
	public function __construct($controller, $action, $elementCount, $elementsPerPage, $currentPage, $params = array()) {
		$this->controller = $controller;
		$this->action = $action;
		$this->elementCount = $elementCount;
		$this->elementsPerPage = $elementsPerPage;
		$this->currentPage = $currentPage;
		$this->params = $params;
	}
	
	public function getHtml() {
		$pages = 0;
	
		$eC = $this->elementCount;
		$lL = $this->elementsPerPage;
	
		while($eC > 0) {
			$pages++;
			$eC -= $lL;
		}
	
		$HTML = '';
	
		if($this->currentPage > 1) {
			$HTML .= $this->div($this->a($this->href(1), '&#8810;'));
			$HTML .= $this->div($this->a($this->href($this->currentPage-1), '&#60;'));
		} else {
			$HTML .= $this->div('&nbsp;');
			$HTML .= $this->div('&nbsp;');
		}
	
		$paginBegin = 1;
		$paginLeftOffset = 0;
		if($this->currentPage - $this->margin > 1) {
			$paginBegin = $this->currentPage - $this->margin;
		} else {
			$paginLeftOffset = (-($this->currentPage - $this->margin))+1;
		}
	
	
		$paginEnd = $pages;
		$paginRightOffset = 0;
		if($this->currentPage + $this->margin < $pages) {
			$paginEnd = $this->currentPage + $this->margin;
		} else {
			$paginRightOffset = ($this->currentPage + $this->margin) - $pages;
		}
	
		for($i = 0; $i<$paginLeftOffset; $i++) {
			$HTML .= $this->div('&nbsp;');
		}
	
		for($page = $paginBegin; $page <= $paginEnd; $page++) {
			if($page != $this->currentPage) {
				$HTML .= $this->div($this->a($this->href($page), $page));
			} else {
				$HTML .= '<div class="paginLinkCurrent">'.$page.'</div>';
			}
		}
	
		for($i=0; $i<$paginRightOffset; $i++) {
			$HTML .= $this->div('&nbsp;');
		}
	
		if($this->currentPage < $pages) {
			$HTML .= $this->div($this->a($this->href($this->currentPage+1), '&#62;'));
			$HTML .= $this->div($this->a($this->href($pages), '&#8811;'));
		} else {
			$HTML .= $this->div('&nbsp;');
			$HTML .= $this->div('&nbsp;');
		}
	
		$HTML .= '<div style="height: 1px; width: 100px; clear:both;"></div>';
	
		return $HTML;
	}

	protected function div($content) {
		return '<div class="paginLink">'.$content.'</div>';
	}
	
	protected function a($href, $label) {
		return '<a href="'.$href.'" class="ajaxUpgradeable" ajax-target="requests_list_wrapper">'.$label.'</a>';
	}
	
	protected function href($page) {
		$cAndA = "$this->controller";
		if($this->action !== '') {
			$cAndA.= "/$this->action";
		}
		
		$href = "/$cAndA/$page";
		
		foreach($this->params as $var => $val) {
			$href.="/$val";
		}
		
		return $href;
	}
	
	public function getElementsPerPage() {
		return $this->elementsPerPage;
	}
	
	public function getCurrentPage() {
		return $this->currentPage;
	}
}

