<?php

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
        echo "strategy_options: " . $result->get("strategy_options") . "\n";
    }

}
sleep(5);
// Boilerplate: close the connection session and perform the cleanup.
//$session->close();
//$cluster->shutdown();