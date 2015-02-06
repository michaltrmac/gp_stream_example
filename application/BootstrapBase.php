<?php

/**
 * The Bootstrap class.
 * - place any setup type tasks here
 * 
 * @return 
 * @access public
 */
class BootstrapBase extends Zend_Application_Bootstrap_Bootstrap
{

	private $config = null;

	private $view = null;

	// --------------------------------------------------------
	protected function _initMain()
	// --------------------------------------------------------
	{
		$this->registerPluginResource('ModuleConfigs');
		$this->_executeResource('ModuleConfigs');

		$this->bootstrap('ConfigsMVC');

		// Custom Routing
		$this->bootstrap('Routes');

		// bootstrap sheell
		$this->bootstrap('Shell');
	}

	/**
	 * load configuration for MVC app (routes, combiner, etc.)
	 *
	 * @return
	 * @access public
	 */
	protected function _initConfigsMVC()
	// --------------------------------------------------------
	{
		$this->bootstrap('Configs');

		$files = array(
			APPLICATION_PATH.'/configs/combiner.ini',
		);

		$this->addToConfig($files);
	}

	/**
	 * load our configuration items and store then in Zend_Registry for later use by the application
	 *
	 * @return
	 * @access public
	 */
	protected function _initConfigs()
	// --------------------------------------------------------
	{
		$files = array(
			APPLICATION_PATH.'/configs/app.ini',
			realpath(APPLICATION_PATH . '/..').'/sensitive.ini',
			APPLICATION_PATH.'/configs/settings.ini',
		);

		$this->addToConfig($files);
	}

	/**
	 *
	 * @param array $files
	 */
	private function addToConfig(array $files)
	// --------------------------------------------------------
	{
		$configuration = cache()->config($files, $this->getEnvironment());

		$_config = $configuration;
		if (!is_null($this->config))
		{
			$this->config->merge($configuration);
			$_config = $this->config;
		}

		$registry = Zend_Registry::getInstance();
		$registry->config = $_config->toArray();
		$this->config = $_config;
	}

	// --------------------------------------------------------
	protected function _initDebug()
	// --------------------------------------------------------
	{
		$debugger = config('Debugger');

		if ($debugger['enabled'])
		{
			$mode = (isset($debugger['mode']) ? (boolean)$debugger['mode'] : (APPLICATION_ENV === 'production'));
			$logDir = ($debugger['logEnabled'] ? ($debugger['logDir'] ? realpath($debugger['logDir']) : false) : false);
			$logEmail = ($debugger['logEmail'] ? $debugger['logEmail'] : null);
			Gp_Debug::enable($mode, $logDir, $logEmail);
		}
	}

	// --------------------------------------------------------
	protected function _initRoutes()
	// --------------------------------------------------------
	{
		$frontController = Zend_Controller_Front::getInstance();
		$router = $frontController->getRouter();
		$def_module = $frontController->getDefaultModule();
		$router->removeDefaultRoutes();

		$files = array(
			APPLICATION_PATH.'/configs/routes.ini',
		);
		$this->addToConfig($files);

		$hostnameRoute = new Zend_Controller_Router_Route_Hostname(
			':module.'.$this->config->domain,
			array('module' => $def_module)
		);
		$router->addRoute('default', new Zend_Controller_Router_Route(':controller/:action/*', array(
			'controller' => $frontController->getDefaultControllerName(),
			'action' => $frontController->getDefaultAction())
		));

		if ($this->config->routes)
			$router->addConfig($this->config, 'routes');

		foreach($router->getRoutes() as $key => $route)
		{
			$router->addRoute($key, $hostnameRoute->chain($route));
		}
	}

	/**
	 * setup the View Helpers
	 *
	 * @return
	 * @access public
	 */
	protected function _initViewHelpers()
	// --------------------------------------------------------
	{
		$view = $this->getResource('view');

		$view->doctype('XHTML1_STRICT');

		if (isset($this->config->headMeta->HttpEquiv))
			foreach ($this->config->headMeta->HttpEquiv as $key => $val)
				$view->headMeta()->appendHttpEquiv((string)$key, (string)$val);

		if (isset($this->config->headMeta->name))
			foreach ($this->config->headMeta->name as $key => $val)
				$view->headMeta()->setName((string)$key, (string)$val);
	}

	// --------------------------------------------------------
	protected function _initView()
	// --------------------------------------------------------
	{
		$view = new Zend_View();
		$view->addHelperPath(APPLICATION_PATH.'/views/helpers', 'My_View_Helper');

		$viewRenderer = Zend_Controller_Action_HelperBroker::getStaticHelper('ViewRenderer');
		$viewRenderer->setView($view);

		$this->view = $view;

		return $view;
	}

	// --------------------------------------------------------
	protected function _initMVC()
	// --------------------------------------------------------
	{
		// Bootstrap View
		$this->bootstrap('View');

		// Initialize Combiner
		$this->bootstrap('Combiner2');
		if (config('Combiner', 'useShrinker') == true)
		{
			$this->getResource('Combiner2')->useShrinker(config('Combiner', 'shrinkerUrl'), config('Combiner', 'shrinkerDomainId'), config('Combiner', 'shrinkerRemoveSecret'));
		}
		else if (APPLICATION_ENV == 'development')
		{
			foreach ($this->config->Combiner->groups as $group)
				$group->version = rand(0,100000);
		}

		$this->getResource('Combiner2')->setConfig($this->config->Combiner);

		// Setup default title & title separator
		$def_title = $this->config->domain;
		if (defined('LNG_SEO_TITLE'))
			$def_title = LNG_SEO_TITLE;

		$this->view->headTitle($def_title)
			->setSeparator((defined('LNG_SEO_TITLE_SEPARATOR') ? LNG_SEO_TITLE_SEPARATOR : ''))
			->setDefaultAttachOrder('PREPEND');

		if (defined('LNG_SEO_KEYWORDS'))
			$this->view->headMeta()->setName('keywords', LNG_SEO_KEYWORDS);

		if (defined('LNG_SEO_DESCRIPTION'))
			$this->view->headMeta()->setName('description', LNG_SEO_DESCRIPTION);

		$this->bootstrap('Layout');
		$this->bootstrap('ViewHelpers');

		Varnish(config('Varnish', 'default'));
	}

	// --------------------------------------------------------
	protected function _initSession() // whenever we work with sessions
	// --------------------------------------------------------
	{
		Zend_Session::setOptions(array('cookie_domain' => $this->config->domain, 'use_only_cookies' => 'on'));
		Zend_Session::start();
	}

	// --------------------------------------------------------
	protected function _initShell() // to be ran from crons
	// --------------------------------------------------------
	{
		// Config needs to run first - loads app.ini
		$this->bootstrap('Configs');

		// Configure Autoloader - paths..etc
		$this->bootstrap('Modules');

		// Register this Bootstrap into general registry so that we can access it from anywhere within our application (Gp_Combiner etc.)
		Zend_Registry::set('bootstrap', self::getApplication()->getBootstrap());
	}

}

