<?php
/**
 * n30-cms user
 * version: 0.2
 * ------------------------------------------------------------------------------------
 * LICENSE
 * ------------------------------------------------------------------------------------
 * This source code is release under the BSD License.
 * This file is part of N30-CMS
 * n30-cms version 0.6
 * ------------------------------------------------------------------------------------
 * DESCRIPTION:
 * ------------------------------------------------------------------------------------
 * This is you, your data, you as a user.
 * Users (not user) contains the user editing
 * 
 * ------------------------------------------------------------------------------------
 * Author: Simon de la Court
 * 
 */
class user
{
	private $cms;
	public $username;
	public $uid;
	public $login = false;
	public $groups = array();
	public $udata;
	public $defaults;
	public $regError;
	public function __construct (&$cms)
	{
		$this->cms = &$cms;
		if ($this->cms->sessions->identified == 1) /* user is no guest... */
			{
			if ($this->cms->sessions->userid != 0)
			{
				/* user is logged in */
				$this->uid = $this->cms->sessions->userid;
				$user = $this->getUinfo($this->uid);
				if (!isset($user['udata']))
				{
					$this->login = false;
					$this->cms->sessions->stopThisSession();
				}
				else
				{
					$this->udata = $user['udata'];
					$this->groups = $user['groups'];
					$this->username = $this->udata['username'];
					$this->login = true;
				}
			} else
			{
				/* --- guest mode --- */
				$this->guest();
			}
		} else
		{
			/* --- guest mode --- */
			$this->guest();
		}
	}
	/**
	 * gets the user based on username and password
	 *
	 * @param string $username
	 * @param string (raw) $password
	 * @return  user
	 */
	public function getUser ($username, $pass)
	{
		$QE = $this->cms->connection->query("SELECT id FROM `" . TAB_USERS . "` WHERE username = '" . $this->cms->connection->escape_string($username) . "' AND pass = sha1('" . USER_SALT . $this->cms->connection->escape_string($pass) . "')");
		if ($this->cms->connection->num_rows($QE) == 1)
		{
			return ($this->cms->connection->fetch_assoc($QE));
		} else
		{
			return (null);
		}
	}
	/**
	 * logs user in
	 *
	 * @param string $username
	 * @param string $password
	 * @return boolean
	 */
	public function loginUser ($username, $password)
	{
		$user = $this->getUser($username, $password);
		if (isset($user['id']))
		{
			$this->login($user['id']);
			return (true);
		} else
		{
			return (false);
		}
	}
	/**
	 * logs user in
	 *
	 * @param int $id
	 */
	public function login ($id)
	{
		$this->cms->sessions->startSession($id);
	}
	/**
	 * logs out user
	 *
	 */
	public function logout ()
	{
		$this->cms->sessions->stopThisSession();
		
	}
	/**
	 * executes guest changes, not needed for now
	 *
	 */
	private function guest ()
	{
		;
	}
	private function getUinfo ($uid)
	{
		if (isset($this->uid) and $this->uid > 0)
		{
			$udata = array();
			$groups = array();
			$QE = $this->cms->connection->query("
						SELECT u.*, l.dir as lang, t.dir as templatedir, t.id AS templateid, t.title as templatetitle
						FROM `" . TAB_USERS . "` u 
						LEFT JOIN `" . TAB_LANG . "` l ON l.id = u.lang
						LEFT JOIN `" . TAB_TEMPLATES . "` t ON t.id = u.template
						WHERE
						u.id = '" . $uid . "'");
			if ($this->cms->connection->num_rows($QE) == 1)
			{
				$udata = $this->cms->connection->fetch_assoc($QE);
				$QE = $this->cms->connection->query("SELECT
															 g.*, gps.title
														 FROM
														 	`" . TAB_USERS_GMEMBER . "` g
														 LEFT JOIN `" . TAB_USERS_GROUPS . "` gps ON gps.id = g.groupid
														 WHERE g.userid = " . intval($uid));
				while ($res = $this->cms->connection->fetch_assoc($QE))
				{
					$groups[$res['groupid']] = $res['groupid'];
				}
				return (array('udata' => $udata , 'groups' => $groups));
			} else
			{return (array());
			}
		}
		return (array());
	}
}
?>