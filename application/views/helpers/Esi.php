<?php
// http://blog.raspberry.nl/2010/07/05/controlling-varnish-esi-inside-your-application/

/**
 * Copyright (c) 2010, Bas de Nooijer
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions are met:
 *
 *   * Redistributions of source code must retain the above copyright notice,
 *     this list of conditions and the following disclaimer.
 *
 *   * Redistributions in binary form must reproduce the above copyright
 *     notice, this list of conditions and the following disclaimer in the
 *     documentation and/or other materials provided with the distribution.
 *
 *   * Neither the name of Raspberry nor the names of its contributors may be
 *     used to endorse or promote products derived from this software without
 *     specific prior written permission.

 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS"
 * AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE
 * IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE
 * ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT OWNER OR CONTRIBUTORS BE
 * LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR
 * CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF
 * SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS
 * INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN
 * CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE)
 * ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE
 * POSSIBILITY OF SUCH DAMAGE.
 *
 * @author&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Bas de Nooijer
 * @copyright&nbsp;&nbsp; 2010, raspberry.nl
 * @license&nbsp;&nbsp;&nbsp;&nbsp; http://www.opensource.org/licenses/bsd-license.php
 */

/**
 * Helper for Varnish Edge Side Includes
 */
class My_View_Helper_Esi extends Zend_View_Helper_Abstract
{
	protected $simulation = false;
	
	protected $_httpContext = null;
	

	/**
     * Default ESI header name
     *
     * @var string
     */
    protected static $_varnishHeaderName = 'esi-enabled';

    /**
     * Default ESI header value
     *
     * @var string
     */
    protected static $_varnishHeaderValue = '1';

    /**
     * Has the Varnish header been sent?
     *
     * @var boolean
     */
    protected static $_varnishHeaderSent = false;

    /**
     * Sets the ESI header settings (to match your Varnish VCL)
     *
     * @param string $name
     * @param string $value
     */
    public static function setHeader($name, $value)
    {
        self::$_varnishHeaderName = $name;
        self::$_varnishHeaderValue = $value;
    }

    /**
     * Create an ESI tag for a given SRC.
     *
     * @param  string $src
     * @return string
     */
    public function esi($src)
    {
    	if ($this->simulation)
    	{
    		$uri = 'http://'.$_SERVER['HTTP_HOST'] . $src;
    		return $this->simulateEsi($uri);
    	}
    	
    	// If the ESI headers have not been sent yet do it now
    	if(!self::$_varnishHeaderSent)
    	{
            $response = Zend_Controller_Front::getInstance()->getResponse();
            $response->setHeader(self::$_varnishHeaderName, self::$_varnishHeaderValue);
     	    self::$_varnishHeaderSent = true;
    	}

        return '<esi:include src="' . $src . '"/>';
    }
    
    
    // ****************************************************************
    // SIMULATE ESI
    // ****************************************************************
    // -----------------------------------------------------
     protected function _getHttpContext()
     // -----------------------------------------------------
    {
    	if (null === $this->_httpContext)
    	{
	    	$this->_httpContext = stream_context_create(
	    	    array('http' =>
	    	        array(
	    	            'ignore_errors' => true, // only available since php 5.2.10
	    	        )
	    	    )
	        );
    	}
    	return $this->_httpContext;
    }

    // -----------------------------------------------------
    private function simulateEsi($uri)
    // -----------------------------------------------------
    {
    	// Append Cookies for simulation of Varnish
    	$uri.='&cooker='.base64_encode(serialize($_COOKIE));
    	$fp = fopen($uri, 'r', false, $this->_getHttpContext());
    	if (false !== $fp)
    	{
	        $data = stream_get_contents($fp);
	        fclose($fp);
	        return $data;
    	}
    	return '';
    }
}