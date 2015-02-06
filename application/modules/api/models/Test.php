<?php

class Api_Model_Test extends Api_Model_Abstract
{

	public function get($time)
	{
		$this->validateSecret();

		return array('status' => true, 't' => $time);
	}

}