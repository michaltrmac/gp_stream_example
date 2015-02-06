<?php

/**
 * ProfileController
 *
 * @author Michal Trmac <michal.trmac@gmail.com>
 */
class ProfileController extends Zend_Controller_Action
{

	public function init()
	{
		Model_Settings::init();
		$this->user_id = Model_User::getId();
		$this->view->items = iterator_to_array(Model_Item::getInstance()->getAll());
	}

	public function listAction()
	{
		$users = array();

		for ($i = 1; $i <= 10; $i++)
			$users[$i] = Model_User::getName($i);

		$this->view->users = $users;
	}

}
