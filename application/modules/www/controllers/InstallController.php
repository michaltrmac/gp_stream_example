<?php

/**
 * Install
 *
 * @author Michal Trmac <michal.trmac@gmail.com>
 */
class InstallController extends Zend_Controller_Action
{

	public function init()
	{
		Model_Settings::init();
	}

	public function indexAction()
	{
		$model = new Model_Install();
		$model->install();

		die;
	}

}