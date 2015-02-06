<?php

/**
 * User
 *
 * @author Michal Trmac <michal.trmac@gmail.com>
 */
class Model_User
{

	/** @var int $default_id */
	private static $default_id = 1;

	/**
	 *
	 * @return int
	 */
	public static function getId()
	{
		$session = new Zend_Session_Namespace('user');
		return (int)(isset($session->id) ? $session->id : self::$default_id);
	}

	/**
	 *
	 * @param int $id
	 */
	public static function setId($id)
	{
		$session = new Zend_Session_Namespace('user');
		$session->id = (int)$id;
	}

	public static function getName($id)
	{
		return 'User_'.(int)$id;
	}

}