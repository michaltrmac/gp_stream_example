<?php

class Model_ApiFetcher_Local
{
	public $throwErrors = true;
	
	private static $_instance = null;
	private $apiKey = '5cebcfce3f637ee233e11301';
	private $secret = 'de949739';
	private $apiUrl = '';
	private $port = '';
	
	/**
	 *
	 * @return Model_ApiFetcher_Local
	 */
	public static function getInstance() // Singleton Access Only
	// --------------------------------------------------------------------------------------------
    {
        if (self::$_instance  === null)
        	self::$_instance = new self();

        return self::$_instance;
    }

	public function __construct()
	{
		$this->apiUrl = 'http://api.'.config('domain').$this->port.'/';
	}
	
	
	// -------------------------------------------------
	public function fetch($controller, $method, $params)
	// -------------------------------------------------
	{
		$params['method'] = $method;

		$params['client_api_key'] = $this->apiKey;
		$params['secret']		  = $this->secret;

		$req = new Gp_Rest_Request($this->apiUrl.'/'.$controller, 'POST', $params);
		$req->execute();

		return $this->decode($req->getResponseBody());
	}

	// ------------------------------
	private function decode($data)
	// ------------------------------
	{
		$resp = json_decode($data);

		if (!is_object($resp))
			return false;
		else if (isset($resp->status) && $resp->status !== true)
		{
			if ($this->throwErrors) 
				throw new Zend_Exception($data);

			return false;
		}
		else
			return $resp;
	}	
	
	// *****************************************************************************************
	public function Test()
	// *****************************************************************************************
	{
		$data = array(
			"time" => time(),
		);
		
		return $this->fetch('Test', 'get', $data);
	}

}
?>