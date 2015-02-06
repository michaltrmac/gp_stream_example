<?php

/** constants && functions */
require_once(realpath('./configs/setup.php'));
require_once(realpath(APPLICATION_PATH.'/functions.php'));
require_once(realpath(APPLICATION_PATH.'/lang/'.CUR_LNG.'.php'));

/** Zend_Application */
require_once 'Zend/Application.php';

date_default_timezone_set("Europe/Prague");

// Create application, bootstrap, and run
$applicationConfig	= cache()->config(APPLICATION_PATH . '/configs/app.ini', APPLICATION_ENV);
$application		= new Zend_Application(APPLICATION_ENV, $applicationConfig);

$application->bootstrap('main')->run();