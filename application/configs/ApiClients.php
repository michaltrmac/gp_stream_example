<?php

$apiClients = array();

$apiClients['6cebcfce3f637ee233e11302'] = array(
	'secret' => 'fe949739',
	'domain' => 'internal',
	'title' => 'internal',
	'short_name' => 'intr'
);

$apiClients['5cebcfce3f637ee233e11300'] = array(
	'secret' => 'ce949739',
	'domain' => 'cliphunter.com',
	'title' => 'Cliphunter',
	'short_name' => 'clip'
);

$apiClients['5cebcfce3f637ee233e11301'] = array(
	'secret' => 'de949739',
	'domain' => 'pichunter.com',
	'title' => 'Pichunter',
	'short_name' => 'pich'
);

$reversedClients = array();
$reversedClients['intr'] = '6cebcfce3f637ee233e11302';
$reversedClients['clip'] = '5cebcfce3f637ee233e11300';
$reversedClients['pich'] = '5cebcfce3f637ee233e11301';

$GLOBALS['apiClients'] = $apiClients;
$GLOBALS['reversedClients'] = $reversedClients;