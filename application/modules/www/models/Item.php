<?php

/**
 * Model_Item
 *
 * @author Michal Trmac <michal.trmac@gmail.com>
 */
class Model_Item extends Gp_Mongo_Abstract
{

	/** @var Model_Item $instance */
	private static $instance = null;

	/** @var Gp_Mongo_Collection $collection */
	private $collection = null;

	/** @var string $collection_name */
	private $collection_name = 'Items';

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
	}

	public function getAll()
	{
		return $this->collection->find();
	}

}
