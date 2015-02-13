<?php

/**
 * Model_Follow
 *
 * @author Michal Trmac <michal.trmac@gmail.com>
 */
class Model_Follow extends Gp_Mongo_Abstract
{

	/** @var Model_Follow $instance */
	private static $instance = null;

	/** @var Gp_Mongo_Collection $collection */
	private $collection = null;

	/** @var string $collection_name */
	private $collection_name = 'Followers';

	protected function getConnParams()
	{
		return config('mongoAdapter', 'default');
	}

	public static function getInstance()
	{
		if (!self::$instance instanceof Model_Item)
			self::$instance = new self();

		return self::$instance;
	}
	
	protected function __construct()
	{
		$this->collection = $this->collection($this->collection_name);
		$this->collection('Followers')->ensureIndex(array(Gp_Attr::USER => 1, 'fid' => 1), array('unique' => true));
	}

	public function save($user_id, $follower_id)
	{
		try {
			$this->collection->save(array(Gp_Attr::USER => (int)$user_id, 'fid' => (int)$follower_id));
		}
		catch (MongoDuplicateKeyException $e) {}
	}

	public function remove($user_id, $follower_id)
	{
		$this->collection->remove(array(Gp_Attr::USER => (int)$user_id, 'fid' => (int)$follower_id));
	}

	public function getFollowers($user_id, array $fields = array(Gp_Attr::USER => 1))
	{
		return $this->collection->find(array('fid' => (int)$user_id), $fields);
	}

	public function getConsumers($user_id, array $fields = array('fid' => 1))
	{
		return $this->collection->find(array(Gp_Attr::USER => (int)$user_id), $fields);
	}

}