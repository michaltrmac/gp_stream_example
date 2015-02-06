<?php

class My_View_Helper_Paginator extends Zend_View_Helper_Abstract
{

	private $currentPage;
	private $totalCount;
	private $itemsPerPage;
	private $template;
	private $paginatorObj = null;
	private $cssClass = 'pagination pagination-centered';
	
	// -------------------------------------------------------------------
	public function paginator($currentPage, $totalCount, $itemsPerPage = 8, $template = 'simple.phtml')
	// -------------------------------------------------------------------
	{
		$this->currentPage	= intval($currentPage);
		$this->totalCount	= intval($totalCount);
		$this->itemsPerPage	= intval($itemsPerPage);
		$this->template		= $template;
		
		return $this; 
	}

	// -------------------------------------------------------------------
	public function setCssClass($cssClass = null)
	// -------------------------------------------------------------------
	{
		if ($cssClass !== null) 
			$this->cssClass = $cssClass;

		$view = Zend_Layout::getMvcInstance()->getView();
		$view->paginatorClass = $this->cssClass;
	}
	
	// -------------------------------------------------------------------
	public function getPaginator()
	// -------------------------------------------------------------------
	{
		if ($this->paginatorObj == null)
		{
			$this->setViewDir();

			$paginator = Zend_Paginator::factory($this->totalCount);
			Zend_View_Helper_PaginationControl::setDefaultViewPartial($this->template);
			$paginator->setDefaultScrollingStyle('Sliding');
	
			$paginator->setCurrentPageNumber($this->currentPage);
			$paginator->setItemCountPerPage($this->itemsPerPage);
			$paginator->setPageRange(16);

			$this->paginator = $paginator;
			unset($paginator);
			
			$this->setCssClass();
		}
		
		return $this->paginator;
	}

	// -------------------------------------------------------------------
	protected function setViewDir()
	// -------------------------------------------------------------------
	{
		$scripts = $this->view->getScriptPaths();
		$scripts[] = dirname(__FILE__).'/'.basename(__FILE__, '.php');
		$this->view->setScriptPath($scripts);
	}
	
	// -------------------------------------------------------------------
	public function __toString()
	// -------------------------------------------------------------------
	{
		$paginator = $this->getPaginator()->__toString();
		return $paginator;
	}
}