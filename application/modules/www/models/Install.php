<?php

/**
 * Install
 *
 * @author Michal Trmac <michal.trmac@gmail.com>
 */
class Model_Install 
{

	final public function install()
	{
		$mongo = new Model_Install_Mongo();
		$mongo->install();

		$cassandra = Model_Install_Cassandra::getInstance();
		$cassandra->install();
	}

}