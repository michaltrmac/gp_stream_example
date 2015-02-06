<?php

// *********************************************************************************************************************
class Api_IndexController extends Zend_Controller_Action
// *********************************************************************************************************************
{

	// -------------------------------------------------
	public function __construct(Zend_Controller_Request_Abstract $request, Zend_Controller_Response_Abstract $response, array $invokeArgs = array())
	// -------------------------------------------------
	{
		if (!isset($_POST['method']))
			exit('Invalid Request Type');

		parent::__construct($request, $response, $invokeArgs);
	}

	// -----------------------------------------------------------------------------------------------------------------
	public function indexAction()
	// -----------------------------------------------------------------------------------------------------------------
	{
		try
		{
			$reqParams = $this->getRequest()->getParams();

			// Get Secret & api Key
			Zend_Registry::set('ApiValidation', true);
			Zend_Registry::set('ClientSecret', $reqParams['secret']);
			Zend_Registry::set('ClientApiKey', $reqParams['client_api_key']);

			$server = new Gp_Rest_Json_Server();
			$server->setClass('Api_Model_'.ucfirst($reqParams['controller']));

			$server->returnResponse(false);
			$server->handle();
		}
		catch(Exception $e)
		{
			header('HTTP/1.0 400 Bad Request');
			echo json_encode(array('message' => $e->getMessage(), 'status' => false));
		}

		exit;
	}
}