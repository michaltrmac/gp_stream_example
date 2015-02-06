<?php

/**
 * The Bootstrap class.
 * - place any setup type tasks here
 * 
 * @return 
 * @access public
 */
class Www_Bootstrap extends Zend_Application_Module_Bootstrap
{

	public function activeInitMain()
	{
//		echo __FUNCTION__.'<br />';
	}

	protected function _initAutoload()
	{
		$loader = new Zend_Application_Module_Autoloader(array(
			'namespace' => '',
			'basePath'  => dirname(__FILE__),
		));
//		$loader->addResourceType('My_View_Helper', '/../../views/helpers', 'My_View_Helper');
	}

}