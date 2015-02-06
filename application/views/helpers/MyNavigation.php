<?php

class My_View_Helper_MyNavigation extends Zend_View_Helper_Navigation
{
	private $nav_path;

	private $cacheLife = 86400; // 1 day

	private $cache_prefix = __CLASS__;

	private $containers = array();

	const DEFAULT_CONTAINER = 'default';


	// ************************************************************
	public function __construct()
	// ************************************************************
	{
		HeadScript('added_js', 'menu.js');
		HeadScript('added_css', 'menu.css');

		$module = Zend_Controller_Front::getInstance()->getRequest()->getModuleName();
		$this->nav_path = APPLICATION_PATH.'/configs/navigation/'.$module.'.xml';

		//set master file for navigation
		try {	
			mongoc()->setMasterFile($this->nav_path);
		} catch(Gp_MongoCache_DisabledException $e) {}
	}

	/**
	 *
	 * @param type $name - container name
	 * @return Zend_Navigation
	 */
	public function getContainerByName($name)
	// ************************************************************
	{
		if (!isset($this->containers[$name]))
		{
			$conf = new Zend_Config_Xml($this->nav_path,'nav');

			$this->containers[$name] = new Zend_Navigation($conf->toArray());
		}

        return $this->containers[$name];
	}

    /**
	 * Helpers for site's navigation
	 *
	 * @param Zend_Navigation_Container $containter
	 * @return My_View_Helper_MyNavigation
	 */
	public function myNavigation($name = self::DEFAULT_CONTAINER)
	{
		$this->setContainer($this->getContainerByName($name));
		return $this;
	}

	/**
	 * render site's top menu
	 *
	 * @return string
	 */
	public function topMenu()
	{
		$id = $this->cache_prefix.'_topMenu'.$this->getCacheId();
		$data = mongoc()->get($id);

//		if (is_null($data))
		{
			$scripts = $this->view->getScriptPaths();
			$scripts[] = dirname(__FILE__).'/'.basename(__FILE__, '.php');
			$this->view->setScriptPath($scripts);

			$this->myMenu()->setPartial('top_menu.phtml');
			$container =  $this->getContainer();
			$data = $this->myMenu()->render($container, array(
				'onlyActiveBranch' => false,
				'renderParents' => false,
//				'minDepth' => 0,
//				'maxDepth' => null,
			));

			mongoc()->set($id, $data, false, $this->cacheLife);
		}

		return $data;
	}

	protected function getCacheId()
	{
		static $id;

		return $id = $id ? $id : serialize(
			array_intersect_key(
				Zend_Controller_Front::getInstance()->getRequest()->getParams(),
				array('controller' => 1, 'action' => 1, 'subPage' => 1)
			)
		);
	}

		/**
	 * Slightly modified Breadcrumbs
	 *
	 * @return string
	 */
	public function myBreadcrumbs()
	{
		$id = $this->cache_prefix.'_breadcrumbs'.$this->getCacheId();
		$breadcrumbs = mongoc()->get($id);

		if (is_null($breadcrumbs))
		{
			$scripts = $this->view->getScriptPaths();
			$scripts[] = dirname(__FILE__).'/'.basename(__FILE__, '.php');
			$this->view->setScriptPath($scripts);

			$breadcrumbs = $this->breadcrumbs()->setPartial('breadcrumbs.phtml');

			mongoc()->set($id, $breadcrumbs, false, $this->cacheLife);
		}

		return $breadcrumbs;
	}

	public function addPage($controller, $action, $route, $label, $container_name = self::DEFAULT_CONTAINER, $parent = null, $linkActive = true)
	{
		$name = Gp_String::word2link($controller.'_'.$action.'_'.$label);

		$p = new Zend_Navigation_Page_Mvc(array(
			'label' => $label,
			'action' => $action,
			'route' => $route,
			'controller' => $controller,
			'myNavigation_name' => $name,
			'linkActive' => $linkActive,
//			'subaction'=> $subaction
		));

		if ($parent && $parent instanceof Zend_Navigation_Page_Mvc)
			$container = $parent;
		else
			$container = $this->getContainerByName($container_name);

		$active = $this->findActive($container);
		if ($active)
			$container = $active['page'];

		$container->addPage($p);

		return $container->findBy('myNavigation_name', $name);
	}
}