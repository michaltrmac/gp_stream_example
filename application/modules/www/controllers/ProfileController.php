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

		$user_consumers = iterator_to_array(Model_Follow::getInstance()->getConsumers(Model_User::getId()));
		$consumers = array();
		foreach ($user_consumers as $consumer)
			$consumers[] = $consumer['fid'];

		$this->view->users = $users;
		$this->view->consumers = $consumers;
	}

	public function followAction()
	{
		$follower_id = (int)$this->getRequest()->getParam('id');

		if ($follower_id > 0)
		{
			$user_id = Model_User::getId();
			Model_Follow::getInstance()->save($user_id, $follower_id);
			Model_Pin_Manager::getInstance()->followUser($user_id, $follower_id);
		}

		$this->_redirect($this->view->url(array('controller' => 'profile', 'action' => 'list'), 'default', true));
	}

	public function unfollowAction()
	{
		$follower_id = (int)$this->getRequest()->getParam('id');

		if ($follower_id > 0)
		{
			$user_id = Model_User::getId();
			Model_Follow::getInstance()->remove($user_id, $follower_id);
			Model_Pin_Manager::getInstance()->unfollowUser($user_id, $follower_id, false);
		}

		$this->_redirect($this->view->url(array('controller' => 'profile', 'action' => 'list'), 'default', true));
	}

	public function switchAction()
	{
		$user_id = (int)$this->getRequest()->getParam('id');
		$current_user_id = Model_User::getId();

		if ($user_id !== $current_user_id)
			Model_User::setId($user_id);

		$this->_redirect($this->view->url(array('controller' => 'profile', 'action' => 'list'), 'default', true));
	}

}
