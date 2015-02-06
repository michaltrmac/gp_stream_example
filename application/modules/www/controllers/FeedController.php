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

}