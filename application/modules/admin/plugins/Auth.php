<?php

class Admin_Plugin_Auth extends Zend_Controller_Plugin_Abstract
{

	private $filename = 'passwd.txt';

	// -------------------------------------------------
	public function preDispatch(Zend_Controller_Request_Abstract $request)
	// -------------------------------------------------
	{
		forceNocacheHeaders();

		if (!$request->getParam('error_handler'))
		{
			//echo md5('gotys:admin:123123');exit;

			$path = APPLICATION_PATH . '/../'.$this->filename;
			$this->checkPasswdFile($path);

			$resolver = new Zend_Auth_Adapter_Http_Resolver_File();
			$resolver->setFile(realpath($path));

			$config = array(
				'accept_schemes' => 'digest',
				'realm' => 'admin',
				'digest_domains' => 'http://admin.' . config('domain'),
				'nonce_timeout' => 3600,
			);

			$adapter = new Zend_Auth_Adapter_Http($config);
			$adapter->setDigestResolver($resolver);

			$adapter->setRequest($request);
			$adapter->setResponse($this->getResponse());

			$result = Zend_Auth::getInstance()->authenticate($adapter);

			if (!$result->isValid()) {
				$this->getResponse()->sendResponse();
				die('Invalid Identity');
			}
			else {
				// Check extra user privileges here if needed
			}
		}
	}

	// -------------------------------------------------
	private function checkPasswdFile($path)
	// -------------------------------------------------
	{
		$orig = $path;
		$path = realpath($path);

		if (!file_exists($path))
		{
			$instructions = "Please create a new file " . realpath(str_replace(basename($orig), '', $orig)). DIRECTORY_SEPARATOR . $this->filename . "\n and append the following text to it: \n";
			$instructions.= " 'admin:admin:" . md5('admin:admin:123123') . "'\n";
			$instructions.= "\nThis will create a new user 'admin' with password '123123'.\n";
			$instructions.= "\n\nNew users can be appended and changed. The formula to setup user/pass :\n";
			$instructions.= "-------------------------------------------------------\n";
			$instructions.= '$line = "$username:admin:".md5($username.\':admin:\'.$password);\n';
			$instructions.= "\n-------------------------------------------------------\n";

			$msg = 'Cannot find ' . $orig;

			NDebugger::$blueScreen->addPanel(function($e) use($instructions) {
				if ($e instanceof Zend_Exception)
					return array(
						'tab' => 'Instructions',
						'panel' => nl2br($instructions),
					);
			});

			throw new Zend_Exception($msg);
		}
	}

}