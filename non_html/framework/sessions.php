<?php
/**
 * n30-cms sessions
 * version 0.3
 * ------------------------------------------------------------------------------------
 * LICENSE
 * ------------------------------------------------------------------------------------
 * This source code is release under the BSD License.
 * This file is part of N30-CMS
 * n30-cms version 0.6
 * ------------------------------------------------------------------------------------
 * DESCRIPTION:
 * ------------------------------------------------------------------------------------
 * Session management
 * 
 * ------------------------------------------------------------------------------------
 * Author: Simon de la Court
 * 
 */
/**
 * n30-cms sessions
 * (C) 2008 CT.Studios
 * version 0.3
 * 
 * This source code is release under the BSD License.
 */
class sessions
{
	private $cms;
	public $identified = false;
	public $sessionid;
	public $userid;
	/**
	 * constructor 
	 *
	 * @param base $cms
	 */
	public function __construct (&$cms)
	{
		try
		{
			$this->cms = &$cms;
			$this->identify();
		} catch (Exception $e)
		{
			$this->cms->exceptions->addError($e);
		}
	}
	/**
	 * starts a new session
	 *
	 * @param int $userid
	 */
	public function startSession ($userid)
	{
		$this->setSessid();
		if (! empty($this->sessionid))
		{
			$this->cms->connection->query("INSERT INTO `" . TAB_SESSIONS . "` (id, sessionstring, ip, strtdate, userid) VALUES (NULL, '" . $this->cms->connection->escape_string($this->sessionid) . "', '" . $_SERVER['REMOTE_ADDR'] . "', now() , '" . intval($userid) . "')");
			setcookie(SESS_COOKIE_TITLE, $this->sessionid, SESS_COOKIE_STAY, '/');
		}
		$this->identified = true;
	}
	/**
	 * stops a running session
	 *
	 * @param string $sessid
	 */
	public function stopSession ($sessid)
	{
		$this->cms->connection->query("DELETE FROM " . TAB_SESSIONS . " WHERE sessionstring = '" . $this->cms->connection->escape_string($sessid) . "'");
	}
	/**
	 * stops only the active session
	 *
	 */
	public function stopThisSession ()
	{
		$this->cms->connection->query("DELETE FROM " . TAB_SESSIONS . " WHERE sessionstring = '" . $this->cms->connection->escape_string($this->sessionid) . "'");		
		setcookie (SESS_COOKIE_TITLE, "", time() - 3600);
	}
	/**
	 * stops all the sessions a user has
	 *
	 * @param int $userid
	 */
	public function stopAllSessions ($userid)
	{
		$this->cms->connection->query("DELETE FROM " . TAB_SESSIONS . " WHERE userid = '" . intval($userid) . "'");
	}
	/**
	 * checks wether a session really exists and the userid connected to this session
	 *
	 * @param string $sessid
	 */
	private function checkLogin ($sessid)
	{
		
		$QE = $this->cms->connection->query("SELECT * FROM `" . TAB_SESSIONS . "` WHERE sessionstring = '" . $this->cms->connection->escape_string($sessid) . "'");
		$res = $this->cms->connection->fetch_assoc($QE);
		if (isset($res['userid']))
		{
			$this->userid = intval($res['userid']);
		}
		else
		{	
			$this->stopThisSession();
			$this->identified = false;
			$this->sessionid = "";
		}
	}
	/**
	 * identification process
	 *
	 */
	private function identify ()
	{
		if (isset($_COOKIE[SESS_COOKIE_TITLE]))
		{
			$this->identified = true;
			$this->sessionid = addslashes($_COOKIE[SESS_COOKIE_TITLE]);
			$this->checkLogin($_COOKIE[SESS_COOKIE_TITLE]);
		} else
		{
			; // you are a guest
		}
	}
	private function checkSessions($unid)
	{
		return (true);
	}
	/**
	 * creates a unique random session id
	 *
	 */
	private function setSessid ()
	{
		if (is_bool($this->identified) and $this->identified == false and empty($this->sessionid))
		{
			$unid = md5(uniqid("Wallalalalalalalalla teh wlalalalalalalala") . time()) . md5(uniqid(microtime()));
			while (!$this->checkSessions($unid))
			{
				$unid = md5(uniqid("Wallalalalalalalalla teh wlalalalalalalala") . time()) . md5(uniqid(microtime()));
			}
			$this->sessionid = $unid;
		}
	}
}
?>