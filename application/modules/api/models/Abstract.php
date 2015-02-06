<?php
/**
 * OpenApi Abstract Class
 *
 * Every Api class needs to extend this one
 */
class Api_Model_Abstract
// *********************************************************************************************************************
{
	// -----------------------------------------------------------------------------------------------------------------
	protected function validateSecret()
	// -----------------------------------------------------------------------------------------------------------------
	{
		if (Zend_Registry::get('ApiValidation') !== true) return true;
		
		$clientData = $this->checkClientApiKey();

		$secret_to_validate	= Zend_Registry::get('ClientSecret');

		if ($clientData['secret'] == $secret_to_validate) return true;
		else throw new Exception("Invalid ApiKey Secret");
	}

	// -----------------------------------------------------------------------------------------------------------------
	protected function checkClientApiKey($client_api_key=null)
	// -----------------------------------------------------------------------------------------------------------------
	{
		if (Zend_Registry::get('ApiValidation') !== true) return true;
		
		if ($client_api_key === null)
		{
			$client_api_key = Zend_Registry::get('ClientApiKey');
		}

		require(APPLICATION_PATH . '/configs/ApiClients.php');

		if (!isset($apiClients[$client_api_key]))
		{
			throw new Exception("Invalid ApiKey");
		}

		return $apiClients[$client_api_key];
	}

	// -----------------------------------------------------------------------------------------------------------------
	protected function error($message)
	// -----------------------------------------------------------------------------------------------------------------
	{
		header('HTTP/1.0 400 Bad Request');

		$ret_array = array();
		$ret_array['status'] = false;
		$ret_array['message'] = $message;

		return $ret_array;
	}
}