<?php

/**
 * The Bootstrap class.
 * - place any setup type tasks here
 *
 * @return
 * @access public
 */

require_once(realpath(dirname(__FILE__).'/BootstrapBase.php'));

class Bootstrap extends BootstrapBase
{

	// --------------------------------------------------------
	public function wwwInitMain()
	// --------------------------------------------------------
	{
		$this->bootstrap('Debug');

		// Front Controller
		$this->bootstrap('FrontController');

		// MVC
		$this->bootstrap('MVC');
	}

	// --------------------------------------------------------
	public function adminInitMain()
	// --------------------------------------------------------
	{
		$this->wwwInitMain();
	}

	public function apiInitMain()
	{
		$this->bootstrap('shell');
		$this->bootstrap('FrontController');
	}

}