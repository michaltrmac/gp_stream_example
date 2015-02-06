<?php

/**
 * Model_Pin_Manager
 *
 * @author Michal Trmac <michal.trmac@gmail.com>
 */
class Model_Pin_Manager extends Gp_Stream_Feed_Manager
{

	/** @var Model_Pin_Manager  */
	private static $instance;

	protected $feed_classes = array(
		'flat' => 'Model_Pin_Feed',
		'aggregated' => 'Model_Pin_Feed_Aggregated',
	);

	protected $user_feed_class = 'Model_Pin_Feed_User';

	/**
	 *
	 * @return Model_Pin_Manager
	 */
	public static function getInstance()
	{
		if (!self::$instance instanceof self)
			self::$instance = new self();

		return self::$instance;
	}

	final public function addPin($actor_id, $verb, $object_id, $target_id = null, $time = null, array $extra_context = array())
	{
		$activity = new Gp_Stream_Activity_Base($actor_id, $verb, $object_id, $target_id, $time, $extra_context);

		$this->addUserActivity($actor_id, $activity);
	}

	final public function removePin()
	{
		throw new Gp_Stream_Exception_NotImplemented();
	}

	final protected function getUserFollowerIds($user_id)
	{
		return array(Gp_Stream_Fanout_Priority::HIGH => array($user_id));
	}

}