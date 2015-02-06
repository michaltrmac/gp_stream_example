<?php
/**
* the error controller
* 
*/
class ErrorController extends Zend_Controller_Action
{

	// ----------------------------------------------------
	public function  init()
	// ----------------------------------------------------
	{
		$errors = $this->_getParam('error_handler');

		if (Gp_Debug::$productionMode === false)
			throw $errors->exception;

		Varnish(config('Varnish', 'errors'));

		$this->view->exception = $errors->exception;
        $this->view->request   = $errors->request;
	}


    /**
    * the error action
    * 
    * @return 
    * @access public
    */
    public function errorAction()
    {
		$errors = $this->_getParam('error_handler');

		switch ($errors->type)
		{
            case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_CONTROLLER:
            case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_ACTION:
                // 404 error -- controller or action not found
                $this->getResponse()->setHttpResponseCode(404);
				$this->_helper->viewRenderer->setRender('404');
			break;

			default:
				$this->getResponse()->setHttpResponseCode(500);
				$this->_helper->layout()->disableLayout();

				if (config('Debugger', 'logEnabled') && Gp_Debug::isEnabled())
					Gp_Debug::log($errors->exception, Gp_Debug::ERROR);
			break;
		}
    }

}

