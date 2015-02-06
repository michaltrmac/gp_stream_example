<?php

class My_View_Helper_Utils extends Zend_View_Helper_Abstract
{

	/**
	 *
	 * @return \My_View_Helper_Utils
	 */
	public function utils()
	{
		return $this;
	}

	/**
	 *
	 * @param timestamp $ptime
	 * @return string
	 */
	public function ago($ptime) 
	// *************************************************************************
	{
	    $etime = time() - $ptime;

	    if ($etime < 1) {
	        return 'just now';
	    }

	    $a = array( 12 * 30 * 24 * 60 * 60  =>  'year',
	                30 * 24 * 60 * 60       =>  'month',
	                7  * 24 * 60 * 60		=>  'week',
	                24 * 60 * 60            =>  'day',
	                60 * 60                 =>  'hour',
	                60                      =>  'minute',
	                1                       =>  'second'
	                );

	    foreach ($a as $secs => $str) {
	        $d = $etime / $secs;
	        if ($d >= 1) {
	            $r = round($d);

	            if ($r == 1 && $str == 'hour') return 'last hour';
	            if ($r == 1 && $str == 'day') return 'yesterday';
	            if ($r == 1 && $str == 'week') return 'last week';
	            if ($r == 1 && $str == 'month') return 'last month';
	            if ($str == 'second' || ($r==1 && $str=='minute')) return 'just now';
	            return $r . ' ' . $str . ($r > 1 ? 's' : '').' ago';
	        }
	    }
	}
	
	/**
	 * 
	 * @param timestamp $ptime
	 * @return string
	 */
	public function agoDays($ptime)
	// *************************************************************************
	{
	    $etime = time() - $ptime;

	    if ($etime < 1) {
	        return 'just now';
	    }

	    $a = array( 12 * 30 * 24 * 60 * 60  =>  'year',
	                30 * 24 * 60 * 60       =>  'month',
	                7  * 24 * 60 * 60		=>  'week',
	                24 * 60 * 60            =>  'day',
	    );

	    foreach ($a as $secs => $str) {
	        $d = $etime / $secs;
	        if ($d >= 1) {
	            $r = round($d);

	            if ($r == 1 && $str == 'day') return 'yesterday';
	            if ($r == 1 && $str == 'week') return 'last week';
	            if ($r == 1 && $str == 'month') return 'last month';
	            return $r . ' ' . $str . ($r > 1 ? 's' : '').' ago';
	        }
	    }
		
		return 'today';
	}

	/**
	 * http://www.the-art-of-web.com/php/truncate/
	 * Return truncated string
	 *
	 * @param string $string
	 * @param int $limit
	 * @param string $break
	 * @param string $pad
	 * @return string
	 */
	function truncate($string, $limit, $break = ' ', $pad = '...')
	// *************************************************************************
	{
		return Gp_String::truncate($string, $limit, $break, $pad);
	}
	
}