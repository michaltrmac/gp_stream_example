<?php

class IndexController extends Zend_Controller_Action
{

	public function init()
	{
		Model_Settings::init();
		$this->view->request = $this->getRequest();
	}

	/**
	 * the default action
	 *
	 * @return
	 * @access public
	 */
	public function indexAction()
	{
		$this->view->items = Model_Item::getInstance()->getAll();
	}

	public function saveAction()
	{
		$id = (int)$this->getRequest()->getParam('id');

		if (!isset($id) || $id <= 0)
			throw new Exception('Parametr id must be set');

		$user_id = Model_User::getId();
		$verb = new Model_Verb_Pin();
		$object_id = 1; // id of pin entry from database
		$target_id = null; // optional id of some bord (teen bord, lesbian bord, etc.)

		Model_Pin_Manager::getInstance()->addPin($user_id, $verb, $object_id, $target_id, null, array('item_id' => $id));
		
		$this->_redirect($this->view->url(array('controller' => 'index', 'action' => 'index'), 'default', true));
	}

}

/*
class A
{

    static protected $inner_var = null;

    static public function echoInnerVar()
    {
		$cls = get_called_class();
        echo $cls::$inner_var."\n";
    }

    static public function setInnerVar($v)
    {
		$cls = get_called_class();
		dump($cls);
//		var_dump(self);
        $cls::$inner_var = $v;
    }

}

class B extends A
{
//	static protected $inner_var = null;
}

A::setInnerVar(10);
B::setInnerVar(20);

A::echoInnerVar();
B::echoInnerVar();
 * 
 */

/**
 *
 *

CREATE KEYSPACE sfre WITH replication = {'class': 'SimpleStrategy', 'replication_factor': '3'}  AND durable_writes = true;


CREATE TABLE sfre.aggregated (
    feed_id ascii,
    activity_id varint,
    activities blob,
    created_at timestamp,
    group ascii,
    updated_at timestamp,
    PRIMARY KEY (feed_id, activity_id)
) WITH CLUSTERING ORDER BY (activity_id DESC)
    AND bloom_filter_fp_chance = 0.01
    AND caching = '{"keys":"ALL", "rows_per_partition":"NONE"}'
    AND comment = ''
    AND compaction = {'min_threshold': '4', 'class': 'org.apache.cassandra.db.compaction.SizeTieredCompactionStrategy', 'max_threshold': '32'}
    AND compression = {'sstable_compression': 'org.apache.cassandra.io.compress.LZ4Compressor'}
    AND dclocal_read_repair_chance = 0.1
    AND default_time_to_live = 0
    AND gc_grace_seconds = 864000
    AND max_index_interval = 2048
    AND memtable_flush_period_in_ms = 0
    AND min_index_interval = 128
    AND read_repair_chance = 0.0
    AND speculative_retry = '99.0PERCENTILE';

CREATE TABLE sfre.example (
    feed_id ascii,
    activity_id varint,
    actor int,
    extra_context blob,
    object int,
    target int,
    time timestamp,
    verb int,
    PRIMARY KEY (feed_id, activity_id)
) WITH CLUSTERING ORDER BY (activity_id DESC)
    AND bloom_filter_fp_chance = 0.01
    AND caching = '{"keys":"ALL", "rows_per_partition":"NONE"}'
    AND comment = ''
    AND compaction = {'min_threshold': '4', 'class': 'org.apache.cassandra.db.compaction.SizeTieredCompactionStrategy', 'max_threshold': '32'}
    AND compression = {'sstable_compression': 'org.apache.cassandra.io.compress.LZ4Compressor'}
    AND dclocal_read_repair_chance = 0.1
    AND default_time_to_live = 0
    AND gc_grace_seconds = 864000
    AND max_index_interval = 2048
    AND memtable_flush_period_in_ms = 0
    AND min_index_interval = 128
    AND read_repair_chance = 0.0
    AND speculative_retry = '99.0PERCENTILE';

CREATE TABLE test.test_types (
	id int,
	type_ascii ascii,
	type_bigint bigint,
	type_blob blob,
	type_boolean boolean,
	type_decimal decimal,
	type_double double,
	type_float float,
	type_int int,
	type_text text,
	type_timestamp timestamp,
	type_uuid uuid,
	type_varchar varchar,
	type_varint varint,
	type_timeuuid timeuuid,
	type_inet inet,
	PRIMARY KEY (id)
);

 *
 */