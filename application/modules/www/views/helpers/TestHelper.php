<?php

class Www_View_Helper_TestHelper extends Zend_View_Helper_Abstract
{

	/**
	 *
	 * @return \Www_View_Helper_TestHelper
	 */
	public function TestHelper()
	{
		return $this;
	}

	public function __toString()
	{
		return __CLASS__;
	}
	
}