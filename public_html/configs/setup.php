<?php

// Define path to application directory
defined('APPLICATION_PATH')
		|| define('APPLICATION_PATH', realpath(dirname(__FILE__) . '/../../application/'));

// Define application environment
defined('APPLICATION_ENV')
		|| define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'production'));

defined('LIBS_PATH') || define('LIBS_PATH', realpath('/www/sites/libs'));

// Ensure library/ is on include_path
set_include_path(implode(PATH_SEPARATOR, array(
			LIBS_PATH,
			get_include_path(),
		)));

define('CACHING', false); //enable or disable cache
define('CACHE_ID_PREFIX','phDev');

define('CUR_LNG', 'en');

define('LOCAL_DIR', '/www/local/template.com/');

$GLOBALS['MEMCACHE_SERVERS'] = array(
	'default' => array('host' => 'localhost', 'port' => 11211, 'persistent' => true),
);