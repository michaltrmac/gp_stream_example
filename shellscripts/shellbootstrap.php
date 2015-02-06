<?php

define('APPLICATION_ENV', 'console');
error_reporting(E_ALL ^ E_NOTICE);

require_once (realpath(dirname(__FILE__).'/../public_html/configs/setup.php'));
require_once (realpath(APPLICATION_PATH.'/functions.php'));
require_once realpath(LIBS_PATH.'/Zend/Application.php');

$applicationConfig = cache()->config(APPLICATION_PATH . '/configs/app.ini', APPLICATION_ENV);
$application = new Zend_Application(APPLICATION_ENV, $applicationConfig);
$application->getBootstrap()->bootstrap('Shell');


// -----------------------------------------------------------------------------------------------------------------
function check_run()
// -----------------------------------------------------------------------------------------------------------------
{
	$pid = posix_getpid();
	if (sprintf("%d", `/sbin/pidof -s -x -o {$pid} {$_SERVER['PHP_SELF']}`))
		die("Another instance of this script is running under PID: $pid\n");
}

// -----------------------------------------------------------------------------------------------------------------
function check_user($u)
// -----------------------------------------------------------------------------------------------------------------
{
	if (!$u) {
		trigger_error("Must specify user!");
		exit;
	}
	$user = posix_getpwuid(posix_getuid());
	if ($user['name'] != $u)
		die("Please run this script under the '$u' user!\nCurrently running as '{$user['name']}' ({$user['uid']})\n");
}