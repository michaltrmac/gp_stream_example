<?php

class TestController extends Zend_Controller_Action
{

	public function init()
	{
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
		//php-cassandra-binary
//		require_once(realpath(LIBS_PATH.'/Gp/Cassandra/lib/autoload.php'));
//		require_once(realpath(LIBS_PATH.'/Gp/Cassandra/lib/src/Database.php'));
//		require_once(realpath(LIBS_PATH.'/Gp/Cassandra/lib/src/Cluster.php'));
//		require_once(realpath(LIBS_PATH.'/Gp/Cassandra/lib/src/Cluster/Node.php'));
//		require_once(realpath(LIBS_PATH.'/Gp/Cassandra/lib/src/Connection.php'));
//		require_once(realpath(LIBS_PATH.'/Gp/Cassandra/lib/src/Protocol/RequestFactory.php'));
//		require_once(realpath(LIBS_PATH.'/Gp/Cassandra/lib/src/Protocol/Request.php'));
//		require_once(realpath(LIBS_PATH.'/Gp/Cassandra/lib/src/Protocol/Response.php'));
//		require_once(realpath(LIBS_PATH.'/Gp/Cassandra/lib/src/Protocol/Response/DataStream.php'));
//		require_once(realpath(LIBS_PATH.'/Gp/Cassandra/lib/src/Protocol/Response/Rows.php'));
//		require_once(realpath(LIBS_PATH.'/Gp/Cassandra/lib/src/Protocol/Response/DataStream/TypeReader.php'));
//		require_once(realpath(LIBS_PATH.'/Gp/Cassandra/lib/src/Protocol/Frame.php'));
//		require_once(realpath(LIBS_PATH.'/Gp/Cassandra/lib/src/Protocol/BinaryData.php'));
//		require_once(realpath(LIBS_PATH.'/Gp/Cassandra/lib/src/Enum/OpcodeEnum.php'));
//		require_once(realpath(LIBS_PATH.'/Gp/Cassandra/lib/src/Enum/VersionEnum.php'));
//		require_once(realpath(LIBS_PATH.'/Gp/Cassandra/lib/src/Enum/ConsistencyEnum.php'));
//		require_once(realpath(LIBS_PATH.'/Gp/Cassandra/lib/src/Enum/ErrorCodesEnum.php'));
//		require_once(realpath(LIBS_PATH.'/Gp/Cassandra/lib/src/Enum/ResultTypeEnum.php'));
//		require_once(realpath(LIBS_PATH.'/Gp/Cassandra/lib/src/Enum/DataTypeEnum.php'));
//		require_once(realpath(LIBS_PATH.'/Gp/Cassandra/lib/src/Exception/CassandraException.php'));

		$keyspace = 'sfre';
		// Create a new keyspace and column family
//$sys = new \phpcassa\SystemManager('192.168.1.13');
//$sys->create_keyspace($keyspace, array(
//	"strategy_class" => \phpcassa\Schema\StrategyClass::SIMPLE_STRATEGY,
//	"strategy_options" => array('replication_factor' => '1')));
//$sys->create_column_family($keyspace, 'example');
//$sys->create_column_family($keyspace, 'aggregated');
//$sys->drop_keyspace($keyspace);
// Start a connection pool, create our ColumnFamily instance
//$pool = new \phpcassa\Connection\ConnectionPool($keyspace, array('192.168.1.13'));
//dump($pool->describe_keyspace());
//die;
//$example = new phpcassa\ColumnFamily($pool, 'example');
//var_dump($example);
//// Create new ConnectionPool like you normally would
//$pool = new ConnectionPool("KeyspaceName", array("127.0.0.1"));
//
//// Retrieve a raw connection from the ConnectionPool
//$raw = $pool->get();
//
//try {
//	$rows = $raw->client->execute_cql3_query("select * from example", cassandra\Compression::NONE, \cassandra\ConsistencyLevel::ONE);
//} catch (Exception $e) {
//	dump($e);
//}
//foreach ($rows->rows as $row)
//{
//	foreach ($row->columns as $col)
//		dump($col->value);
//}

/**
 * evseevnn
 */

//$connection = new evseevnn\Cassandra\Database(['192.168.1.13:9042'], 'testkeyspace');
//$connection->connect();
//$connection->query("DROP KEYSPACE IF EXISTS testkeyspace;");
//$connection->query(
//		"CREATE KEYSPACE testkeyspace WITH replication = {   'class': 'SimpleStrategy',   'replication_factor': '1' };"
//);
//$connection->query("USE testkeyspace;");

//$connection->query('CREATE TABLE VarIntTest (foo varint PRIMARY KEY, bar varint)');
//$connection->query(
//		'INSERT INTO VarIntTest (foo, bar) VALUES (:foo, :bar)',
//		['foo' => '2', 'bar' => '52']
//);

//$connection->query(
//		'INSERT INTO VarIntTest (foo, bar) VALUES (:foo, :bar)',
//		['foo' => '22', 'bar' => '14156250080000000000003002']
//);

//$result = $connection->query('SELECT * FROM VarIntTest WHERE foo = :foo', ['foo' => '2']);
//dump($result);

//$result = $connection->query('SELECT * FROM VarIntTest WHERE foo = :foo', ['foo' => '22']);
//dump($result);



//dump('List Test');
////$connection->query('CREATE TABLE VarIntListTest (foo varint PRIMARY KEY, bar list<varint>)');
////$connection->query(
////		'INSERT INTO VarIntListTest (foo, bar) VALUES (:foo, :bar)',
////		['foo' => '2', 'bar' => ['52', '25', '14156250080000000000003002']]
////);
//$result = $connection->query('SELECT * FROM VarIntListTest WHERE foo = :foo', ['foo' => '2']);
//dump($result);
//
////according to Spec, this should be returned in index order
////$connection->query(
////		'INSERT INTO VarIntListTest (foo, bar) VALUES (:foo, :bar)',
////		['foo' => '22', 'bar' => ['25', '52', '14156250080000000000003002']]
////);
//$result = $connection->query('SELECT * FROM VarIntListTest WHERE foo = :foo', ['foo' => '22']);
//
//dump($result);
//
//dump('Map Test');
////$connection->query('CREATE TABLE VarIntMapTest (foo varint PRIMARY KEY, bar map<varint,varint>)');
////$connection->query(
////		'INSERT INTO VarIntMapTest (foo, bar) VALUES (:foo, :bar)',
////		['foo' => '2', 'bar' => ['52' => '25']]
////);
//$result = $connection->query('SELECT * FROM VarIntMapTest WHERE foo = :foo', ['foo' => '2']);
//dump($result);
//
////$connection->query(
////		'INSERT INTO VarIntMapTest (foo, bar) VALUES (:foo, :bar)',
////		['foo' => '22', 'bar' => ['522' => '14156250080000000000003002']]
////);
//$result = $connection->query('SELECT * FROM VarIntMapTest WHERE foo = :foo', ['foo' => '22']);
//dump($result);
//
//
//dump('Set Test');
//
////$connection->query('CREATE TABLE VarIntSetTest (foo varint PRIMARY KEY, bar set<varint>)');
////$connection->query(
////		'INSERT INTO VarIntSetTest (foo, bar) VALUES (:foo, :bar)',
////		['foo' => '2', 'bar' => ['25', '14156250080000000000003002', '52']]
////);
//$result = $connection->query('SELECT * FROM VarIntSetTest WHERE foo = :foo', ['foo' => '2']);
//dump($result);
////according to Spec, this should always be returned alphabetically.
////$connection->query(
////		'INSERT INTO VarIntSetTest (foo, bar) VALUES (:foo, :bar)',
////		['foo' => '22', 'bar' => ['52', '14156250080000000000003002', '25']]
////);
//$result = $connection->query('SELECT * FROM VarIntSetTest WHERE foo = :foo', ['foo' => '22']);
//dump($result);
//die;

//$nodes = [
//    '192.168.1.13',
//];
//
//// Connect to database.
//$database = new \evseevnn\Cassandra\Database($nodes, $keyspace);
//$database->connect();
//
////$rows = $database->query('select * from example', array(), evseevnn\Cassandra\Enum\ConsistencyEnum::CONSISTENCY_ONE);
////$describe = $database->query('describe tables', array(), evseevnn\Cassandra\Enum\ConsistencyEnum::CONSISTENCY_ONE);
//
////dump($rows);
//
$verb = new stdClass();
$verb->id = 10;
$activity = new Gp_Stream_Activity_Base(1, $verb, 3, 4, null);

$id = $activity->getSerializationId();
//
////$response = "\x00\x00\x00\x04\x00\x10\xb5\xcf]\xfa\x06,T\xb0\xb95V\x93\xce\t\xc8\xbe\x00\x00\x00\x01\x00\x00\x00\x01\x00\x0ctestkeyspace\x00\nvarinttest\x00\x03foo\x00\x0e";
////dump($response);
////
////$pos = 0;
//////$kind = substr($response, $pos, 4);
//////$pos += 4;
//////dump($kind);
////
////$flags = substr($response, $pos, 4);
////$pos += 4;
////dump($flags);
////
////$number_of_columns = substr($response, $pos, 4);
////$pos += 4;
////dump($number_of_columns);
////
////$first_string_length = substr($response, $pos, 2);
////$pos += 2;
////dump($first_string_length);
////$first_string = substr($response, $pos, 4);
////$pos += 4;
////dump($first_string);
////
////$second_string_length = substr($response, $pos, 2);
////$pos += 2;
////dump($second_string_length);
////$second_string = substr($response, $pos, 4);
////$pos += 4;
////dump($second_string);
////
////$first_column_length = substr($response, $pos, 2);
////$pos += 2;
////dump($first_column_length);
////
////$firs_column_name = substr($response, $pos, 11);
////$pos += 11;
////dump($firs_column_name);
////
////$first_column_type = substr($response, $pos, 2);
////$pos += 2;
////dump($first_column_type);
////
////$second_column_length = substr($response, $pos, 2);
////$pos += 2;
////dump(unpack('n', $second_column_length));
////
////$second_column_name = substr($response, $pos, 14);
////$pos += 14;
////dump($second_column_name);
////die;
//try {
////	$database->query(
////				'INSERT INTO "example" ("feed_id", "activity_id", "actor", "object", "target", "time", "verb") VALUES (:feed_id, :activity_id, :actor, :object, :target, :time, :verb);',
////				array(
////					"feed_id" => 'feed:user:1',
////					"activity_id" => "$id",
////					"actor" => 1,
////					"object" => 666,
////					"target" => 1,
////					"time" => time(),
////					"verb" => $verb->id,
////				),
////				\evseevnn\Cassandra\Enum\ConsistencyEnum::CONSISTENCY_ONE
////			);
//
////	$database->query(
////				'INSERT INTO "test" ("activity_id", "updated_at") VALUES (:activity_id, :updated_at);',
////				[
////					'activity_id' => "$id",
////					'updated_at' => time() * 1000,
////				],
////				\evseevnn\Cassandra\Enum\ConsistencyEnum::CONSISTENCY_ONE
////			);
//
////	$rows = $database->query('select * from test', array(), evseevnn\Cassandra\Enum\ConsistencyEnum::CONSISTENCY_ONE);
////	dump($rows);
//////	dump(date('Y-m-d H:i:s', (int)$rows[0]['updated_at']));
////
//		$database->query(
//				'INSERT INTO "test" ("activity_id", "updated_at") VALUES (:activity_id, :updated_at);',
//				[
//					'activity_id' => $id,
//					'updated_at' => (mktime() * 1000),
//				],
//				\evseevnn\Cassandra\Enum\ConsistencyEnum::CONSISTENCY_ONE
//			);
//
////	$database->query(
////				'INSERT INTO "test" ("activity_id", "updated_at") VALUES ('.$id.', '.(time() * 1000).');',
////				array(),
////				\evseevnn\Cassandra\Enum\ConsistencyEnum::CONSISTENCY_ONE
////			);
//}
//catch (Exception $e)
//{
//	dump($e);
//}

try {
//	require_once(realpath(LIBS_PATH.'/Gp/Cassandra/lib.duoshuo/vendor/autoload.php'));
//
//	$connection = new Cassandra\Connection($nodes, $keyspace);
//
//	$connection->querySync('INSERT INTO "test2" ("id", "time") VALUES (:id, :time)', array(
//		'id' => new \Cassandra\Type\Varint(7),
//		'time' => new Cassandra\Type\Timestamp(time() * 1000),
//	), Cassandra\Request\Request::CONSISTENCY_ONE);
//
//	// Run query synchronously.
//	$response = $connection->querySync('SELECT * FROM "test2"', array(), Cassandra\Request\Request::CONSISTENCY_ONE);
//
//	// Return a SplFixedArray containing all of the result set.
//	$rows = $response->fetchAll();      // SplFixedArray
//	dump($rows);
//
//	// Return a SplFixedArray containing a specified index column from the result set.
//	$col = $response->fetchCol();       // SplFixedArray
//	dump($col);
//
//	// Return a assoc array with key-value pairs, the key is the first column, the value is the second column.
//	$col = $response->fetchPairs();     // assoc array
//	dump($col);
//
//	// Return the first row of the result set.
//	$row = $response->fetchRow();       // ArrayObject
//	dump($row);
//
//	// Return the first column of the first row of the result set.
//	$value = $response->fetchOne();     // mixed
//	dump($value);

	// Suppose you have the Cassandra cluster at 127.0.0.1,
// listening at default port (9042).
$builder  = new CqlBuilder();
$builder->addContactPoint('192.168.1.13');

// Now build a model of cluster and connect it to DB.
$cluster  = $builder->build();
$session  = $cluster->connect();

// Write a query, switch keyspaces.

$cql = "INSERT INTO test.test_types (id, type_ascii, type_bigint, type_blob, type_boolean, type_decimal, type_double, type_float, type_int,	type_text, type_timestamp, type_uuid, type_varchar,	type_varint, type_inet)
		VALUES (2, 'abcd', ".PHP_INT_MAX.", 0x286470300a53276974656d5f6964270a70310a49320a732e, true, 123.123, 456.456456, 789.789789, 123456789, 'zxcvbnm', ".(time() * 1000).", 62c36092-82a1-3a00-93d1-46196ee77204, 'type varchar',	14141614580000000000196005, '192.168.2.5');";

$cql = "INSERT INTO test.test_types (id, type_ascii, type_bigint, type_blob, type_boolean, type_decimal, type_double, type_float, type_int,	type_text, type_timestamp, type_uuid, type_varchar,	type_varint, type_inet)
		VALUES (3, null, null, null, null, null, null, null, null, null, null, null, null,	null, null);";

$cql = 'SELECT * FROM test.test_types';

$query    = new CqlQuery($cql);
$query->setConsistency(Cql::CQL_CONSISTENCY_ONE);
// Send the query.
$future   = $session->query($query);

// Wait for the query to execute; retrieve the result.
$future->wait();
$result   = $future->getResult();
//dump($future->getError());

//die;
//dump(get_class_methods(CqlQuery));
//dump(get_class_methods($result));
//die;
function bchexdec($hex) {
	if (strlen($hex) == 1)
		return hexdec($hex);

	$remain = substr($hex, 0, -1);
	$last = substr($hex, -1);
	return bcadd(bcmul(16, bchexdec($remain)), hexdec($last));
}

if (null === $future->getError()) {

    echo "rowCount: {$result->getRowCount()}\n";

    while ($result->next()) {
////		dump($result->exists('activity_id'));
//		dump($result->get('feed_id', Cql::CQL_COLUMN_TYPE_VARCHAR));
//		$activity_id = unpack('H*', $result->get('activity_id', Cql::CQL_COLUMN_TYPE_TEXT));
//		dump(bchexdec($activity_id[1]));
//		dump($result->get('actor'));
//		dump($result->get('extra_context', Cql::CQL_COLUMN_TYPE_VARCHAR));
//		dump($result->get('object'));
//		dump($result->get('target'));
//		dump($result->get('time', Cql::CQL_COLUMN_TYPE_BIGINT));
//		dump($result->get('verb'));

		$row = $result->get();
		dump($row);
		dump(json_decode($row['type_blob']));
//		dump($result->getRow());

//		dump($result->get('id'));
//		dump($result->get('type_ascii'));
//		dump($result->get('type_bigint'));
//		dump($result->get('type_blob'));
//		dump($result->get('type_boolean'));
//		dump($result->get('type_decimal'));
//		dump($result->get('type_double'));
//		dump($result->get('type_float'));
//		dump($result->get('type_int'));
//		dump($result->get('type_text'));
//		dump($result->get('type_timestamp'));
//		dump($result->get('type_uuid'));
//		dump($result->get('type_varchar'));
//		dump(bchexdec(unpack('H*', $result->get('type_varint', Cql::CQL_COLUMN_TYPE_TEXT))[1]));
//		dump($result->get('type_varint'));
//		dump(inet_ntop($result->get('type_inet', Cql::CQL_COLUMN_TYPE_TEXT)));
//		dump($result->get('type_inet'));
//		break;


//		die;
//        echo "ID: " . $result->get("id") . "\n";
    }

}

// Boilerplate: close the connection session and perform the cleanup.
$session->close();
$cluster->shutdown();

} catch (Exception $e) {
	dump($e);
}

/*
 * McFrazier
// register the namespaces
$classLoader = new SplClassLoader('McFrazier\PhpBinaryCql', LIBS_PATH.'/Gp/Cassandra/lib'.DIRECTORY_SEPARATOR);
$classLoader->register();

// host and port for cassandra
$pbc = new \McFrazier\PhpBinaryCql\CqlClient('192.168.1.13', 9042);
$pbc->addStartupOption('CQL_VERSION', '3.2.0');

$queryText = 'select * from sfre.example';
$response = $pbc->query($queryText, \McFrazier\PhpBinaryCql\CqlConstants::QUERY_CONSISTENCY_ONE);

dump($response->getData());
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

	}

	public function test2Action()
	{
		// Suppose you have the Cassandra cluster at 127.0.0.1,
		// listening at default port (9042).
		$builder  = new CqlBuilder();
		$builder->addContactPoint("192.168.1.13");

		// Now build a model of cluster and connect it to DB.
		$cluster  = $builder->build();
		$session  = $cluster->connect();

		// Write a query, switch keyspaces.
		$query    = new CqlQuery('SELECT * FROM system.schema_keyspaces');

		// Send the query.
		$future   = $session->query($query);

		// Wait for the query to execute; retrieve the result.
		$future->wait();
		$result   = $future->getResult();

		if (null === $future->getError()) {

			echo "rowCount: {$result->getRowCount()}\n";

			while ($result->next()) {
				echo "strategy_options: " . $result->get("strategy_options") . "<br />";
			}

		}

		// Boilerplate: close the connection session and perform the cleanup.
//		$session->close();
//		$cluster->shutdown();
		die('x');
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