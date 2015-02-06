<?php

$builder  = new CqlBuilder();
$builder->addContactPoint('192.168.1.13');

// Now build a model of cluster and connect it to DB.
$cluster  = $builder->build();
$session  = $cluster->connect();

// Write a query, switch keyspaces.
$time = (time() * 1000);
$max = PHP_INT_MAX;
$cql      = <<<CQL
BEGIN BATCH
INSERT INTO test.test_types (id, type_ascii, type_bigint, type_blob, type_boolean, type_decimal, type_double, type_float, type_int,	type_text, type_timestamp, type_uuid, type_varchar,	type_varint, type_inet)
VALUES (1, 'abcd', $max, 0x286470300a53276974656d5f6964270a70310a49320a732e, true, 123.123, 456.456456, 789.789789, 123456789, 'zxcvbnm', $time, 62c36092-82a1-3a00-93d1-46196ee77204, 'type varchar',	123456, '192.168.2.5');

INSERT INTO test.test_types (id, type_ascii, type_bigint, type_blob, type_boolean, type_decimal, type_double, type_float, type_int,	type_text, type_timestamp, type_uuid, type_varchar,	type_varint, type_inet)
VALUES (2, 'abcd', $max, 0x286470300a53276974656d5f6964270a70310a49320a732e, true, 123.123, 456.456456, 789.789789, 123456789, 'zxcvbnm', $time, 62c36092-82a1-3a00-93d1-46196ee77204, 'type varchar',	14141614580000000000196005, '192.168.2.5');
APPLY BATCH;
CQL;

$query    = new CqlQuery($cql);
$query->setConsistency(Cql::CQL_CONSISTENCY_ONE);

$session->query($query)->wait();

$query->setQueryString('SELECT * FROM test.test_types');
// Send the query.
$future   = $session->query($query);

// Wait for the query to execute; retrieve the result.
$future->wait();
$result   = $future->getResult();

function bchexdec($hex) {
	if (strlen($hex) == 1)
		return hexdec($hex);

	$remain = substr($hex, 0, -1);
	$last = substr($hex, -1);
	return bcadd(bcmul(16, bchexdec($remain)), hexdec($last));
}

if (null === $future->getError()) {

    echo "rowCount: {$result->getRowCount()}\n";

	$i = 0;
    while ($result->next()) {
		$i++;

		echo "===== Row $i ===== \n";
		echo "Id: "; var_export($result->get('id')); echo "\n";
//		echo "type_ascii: "; var_export($result->get('type_ascii', Cql::CQL_COLUMN_TYPE_TEXT)); echo "\n";
		echo "type_ascii: "; var_export($result->get('type_ascii')); echo "\n";
		echo "type_bigint: "; var_export($result->get('type_bigint')); echo "\n";
//		echo "type_blob: "; var_export($result->get('type_blob', Cql::CQL_COLUMN_TYPE_TEXT)); echo "\n";
		echo "type_blob: "; var_export($result->get('type_blob')); echo "\n";
		echo "type_boolean: "; var_export($result->get('type_boolean')); echo "\n";
		echo "type_decimal: "; var_export($result->get('type_decimal')); echo "\n";
		echo "type_double: "; var_export($result->get('type_double')); echo "\n";
		echo "type_float: "; var_export($result->get('type_float')); echo "\n";
		echo "type_int: "; var_export($result->get('type_int')); echo "\n";
		echo "type_text: "; var_export($result->get('type_text')); echo "\n";
		echo "type_timestamp: "; var_export($result->get('type_timestamp')); echo "\n";
		echo "type_uuid: "; var_export($result->get('type_uuid')); echo "\n";
		echo "type_varchar: "; var_export($result->get('type_varchar')); echo "\n";
//		echo "Id: "; var_export(bchexdec(unpack('H*', $result->get('type_varint', Cql::CQL_COLUMN_TYPE_TEXT))[1])); echo "\n";
		echo "type_varint: "; var_export($result->get('type_varint')); echo "\n";
//		echo "type_inet: "; var_export(inet_ntop($result->get('type_inet', Cql::CQL_COLUMN_TYPE_TEXT))); echo "\n";
		echo "type_inet: "; var_export($result->get('type_inet')); echo "\n";
		echo "======================================================== \n";
    }

}

// Boilerplate: close the connection session and perform the cleanup.
$session->close();
$cluster->shutdown();