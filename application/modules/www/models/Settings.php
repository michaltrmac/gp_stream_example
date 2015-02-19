<?php

/**
 * Model_Settings
 *
 * @author Michal Trmac <michal.trmac@gmail.com>
 */
class Model_Settings extends Gp_Stream_Settings
{

	/** @var array - cassandra db hosts */
//	protected static $cassandra_hosts = array(
//		'192.168.1.12',
//		'192.168.1.11',
//		'192.168.1.13',
//		array(
//			'host' => '192.168.1.14',
//			'port' => 123456
//		)
//	);
	protected static $cassandra_hosts = null;

	protected static $default_keyspace = null;

	/** @var array - fanout task cron mongo settings */
	protected static $fanout_task_cron_mongo = array(
		'name' => 'FanoutTasks',
		'address' => null,
		'dbname' => null,
		'collection' => 'FanoutTasks',
		'params' => array(),
	);

	/** @var bool - process the fanout task immediatly after its added to the task job */
	protected static $fanout_task_process_immediatly = true;

	/** @var string */
	protected static $stream_verb_storage = 'Model_Verb_Storage_Memory';

	public static function init()
	{
		$config = config('cassandra', 'default');

		self::$cassandra_hosts = $config['address'];
		self::$default_keyspace = $config['dbname'];

		self::$fanout_task_cron_mongo['address'] = config('mongoAdapter', 'default', 'address');
		self::$fanout_task_cron_mongo['dbname'] = config('mongoAdapter', 'default', 'dbname');

		if (!self::$is_inited)
		{
			parent::init();
		}
	}

}