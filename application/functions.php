<?php

// ******************************************************************************************************
// Global Functions for VARNISH
// ******************************************************************************************************


// -----------------------------------------------------------------------------------------------------
// call anywhere in your view scripts or controllers to setup Varnish time to lives
// Varnish(false) will disable varnish cashing for a given page view
// Varnish(10) // sets 10 second cache
// Varnish(false); Varnish(100); will not overwrite disabled varnish. Once disabled, there is no overwriting
// Varnish(100,true); is used in rare special cases when a page is not rendered via GpCombiner
function Varnish($ttl=100, $direct=false)
// -----------------------------------------------------------------------------------------------------
{
	if (config('Varnish', 'disable'))
		return;

	if ($ttl !== false)
		$ttl = $ttl+rand(0,20);

	//dump("Setting varnish to $ttl");
	if ($direct === false)
		getCombiner()->setVarnishTTL($ttl);
	else
	{
		$front = Zend_Controller_Front::getInstance();
		if ($ttl !== false) $front->getResponse()->setHeader('Cache-Control', "max-age=".$ttl."; must-revalidate",true);
		else $front->getResponse()->setHeader('Cache-Control', "no-cache",true);
	}
}

// -----------------------------------------------------------------------------------------------------
// Call this function anywhere in your view scripts or controllers to copmletely disable page caching
// FireFox loves to cache pages and will not reload when a user hits a Back button or the page is loaded in a frame
// This funciton will tell Firefox not to cache anything
function forceNocacheHeaders()
// -----------------------------------------------------------------------------------------------------
{
	Varnish(false);
	getCombiner()->setVarnishTTL(null);

	$front = Zend_Controller_Front::getInstance();
	$front->getResponse()->setHeader('Cache-Control', "no-cache, s-maxage=0,no-store,must-revalidate",true);
	$front->getResponse()->setHeader('Pragma', "no-cache",true);
	$front->getResponse()->setHeader('Expires', "Mon, 26 Jul 1997 05:00:00 GMT",true);
}


// ******************************************************************************************************
// Global Functions for retrieving variables quickly and easily
// ******************************************************************************************************

// -----------------------------------------------------------------------------------------------------
// Returns a pointer to View object
function getView()
// -----------------------------------------------------------------------------------------------------
{
	$bootstrap = Zend_Registry::getInstance()->bootstrap;
	return $bootstrap->getResource('View');
}

/*******************************************************************************************************
 * Returns a pointer to Gp_Combiner2
 *
 * @return Gp_Combiner2
 */
function getCombiner() // * @return Gp_Combiner2
// -----------------------------------------------------------------------------------------------------
{
	$bootstrap = Zend_Registry::getInstance()->bootstrap;
	$bootstrap->bootstrap('Combiner2');
	return $bootstrap->getResource('Combiner2');
}

// -----------------------------------------------------------------------------------------------------
// Quickly retrieve config values
// ie: (sensitive.ini) dbs.default.params.port	= 3308
// config('dbs','default','params','port') will return 3308
function config()
// -----------------------------------------------------------------------------------------------------
{
	$arr_keys = func_get_args();
	$ret_value = Zend_Registry::getInstance()->config;
	foreach ($arr_keys as $key)
	{
		if(isset($ret_value[$key]))
		{
			$ret_value = $ret_value[$key];
		}
		else
		{
			$ret_value = null;
			break;
		}
	}
	return $ret_value;
}



// ******************************************************************************************************
// Global Functions for settings and modifying things
// ******************************************************************************************************

// -----------------------------------------------------------------------------------------------------
// Adds a CSS/JS script to Gp_Combiner
// Call in your VIEW scripts
// HeadScript('default_js') will add default_js as defined in app.ini
// HeadScript('default_js','petr.js') will add "petr.js" to "default_js" group
// HeadScript('superCss','petr.css') will add "petr.css" to "superCss" group
function HeadScript($config_group,$file=null,$scriptPriority=0,$groupVersion=0,$groupPriority=0)
// -----------------------------------------------------------------------------------------------------
{
	getCombiner()->add($config_group,$file,$scriptPriority,$groupVersion,$groupPriority);
}


// -----------------------------------------------------------------------------------------------------
function var2Arr($var) // Make sure $var is an array. if $var is a single value, return Array($var)
// -----------------------------------------------------------------------------------------------------
{
	if (!is_array($var)) return Array($var);
	else return $var;
}

// -----------------------------------------------------------------------------------------------------
function arr2Ints($var) // Make sure $arr integers are integers
// -----------------------------------------------------------------------------------------------------
{
	foreach ($var as $k => $v) {
		if (is_numeric($v))
			$v = intval($v);
		$var[$k] = $v;
	}
	return $var;
}

// -----------------------------------------------------------------------------------------------------
function var2Bool($var) // Make sure $var is boolean
// -----------------------------------------------------------------------------------------------------
{
	if ($var) return true;

	return false;
}

/**
 *
 * @staticvar Gp_MongoCache $instance
 * @return \Gp_MongoCache
 */
function mongoc()
// -----------------------------------------------------------------------------------------------------
{
	static $instance;

	if(!$instance)
		$instance = new Gp_MongoCache(config('mongoAdapter', 'default'));

	return $instance;
}

// *********************************************************************************************************************
/* COMMON FUNCTIONS */
// *********************************************************************************************************************

/**
 * @return Gp_Cache
 */
function cache()
// -----------------------------------------------------------------------------------------------------
{
	require_once 'Gp/Cache.php';
	return Gp_Cache::getInstance($GLOBALS['MEMCACHE_SERVERS'], CACHING);
}

// -----------------------------------------------------------------------------------------------------
function get_file_extention($filename)
// -----------------------------------------------------------------------------------------------------
{
	list($file,$ext) = split('\.'.$row['ext'],$filename);
	return $ext;
}

// -----------------------------------------------------------------------------------------------------
function getip()
// -----------------------------------------------------------------------------------------------------
{
	if (isSet($_SERVER)) {
		if (isSet($_SERVER["HTTP_X_FORWARDED_FOR"])) {
			$realip = $_SERVER["HTTP_X_FORWARDED_FOR"];
		} elseif (isSet($_SERVER["HTTP_CLIENT_IP"])) {
			$realip = $_SERVER["HTTP_CLIENT_IP"];
		} else {
			$realip = $_SERVER["REMOTE_ADDR"];
		}
	} else {
		if ( getenv( 'HTTP_X_FORWARDED_FOR' ) ) {
			$realip = getenv( 'HTTP_X_FORWARDED_FOR' );
		} elseif ( getenv( 'HTTP_CLIENT_IP' ) ) {
			$realip = getenv( 'HTTP_CLIENT_IP' );
		} else {
			$realip = getenv( 'REMOTE_ADDR' );
		}
	}
	return $realip;
}

/**
 *
 * @param string $msg
 * @param mixed $values
 * @return string
 */
function lng_msg($msg, $values)
// -----------------------------------------------------------------------------------------------------
{

	if (!is_array($values)) 
		$values = array($values);

	foreach ($values as $val)
		$msg = preg_replace('/%value%/',$val,$msg,1);

	return (string)$msg;
}