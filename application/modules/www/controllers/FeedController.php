<?php

/**
 * FeedController
 *
 * @author Michal Trmac <michal.trmac@gmail.com>
 */
class FeedController extends Zend_Controller_Action
{

	public function init()
	{
		Model_Settings::init();
		$this->user_id = Model_User::getId();
		$this->view->items = iterator_to_array(Model_Item::getInstance()->getAll());
	}

	public function flatAction()
	{
		$feed = Model_Pin_Manager::getInstance()->getFeedByType($this->user_id, 'flat');
		$this->view->activities = $feed->get(25);
	}

	public function aggregatedAction()
	{
		$feed = Model_Pin_Manager::getInstance()->getFeedByType($this->user_id, 'aggregated');
		$this->view->aggregated = $feed->get(25);
	}

	public function notificationAction()
	{
		$feed = Model_Pin_Manager::getInstance()->getFeedByType($this->user_id, 'notification');
		$feed->markAll(true);
		$this->view->activities = $feed->get(100);
	}

	public function markAsReadAction()
	{
		$params = $this->getRequest()->getParams();
		$feed = Model_Pin_Manager::getInstance()->getFeedByType($this->user_id, 'notification');
		$activity = $feed->filter(array('activity_id__=' => $params['id']))->get();

		if (!empty($activity))
		{
			$activity = reset($activity);
			$feed->markAsRead($activity);
		}

		$this->_redirect($this->view->url(array('controller' => 'feed', 'action' => 'notification'), 'default', true));
	}

}