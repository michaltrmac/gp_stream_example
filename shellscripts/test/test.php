<?php

require_once realpath(dirname(__FILE__).'/../shellbootstrap.php');

$data = Model_ApiFetcher_Local::getInstance()->Test();
print_r($data);