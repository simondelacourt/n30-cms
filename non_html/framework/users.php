<?php
/**
 * n30-cms users
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
 * This class manages all users in the CMS.
 * 
 * ------------------------------------------------------------------------------------
 * Author: Simon de la Court
 * 
 */
class users
{
	private $cms;
	public $username;
	public $uid;
	public $login = false;
	public $groups = array();
	public $udata;
	public $defaults;
	public $regerror;
	
	private $usercount;
	public function __construct (&$cms)
	{
		$this->cms = &$cms;
	}
	public function retrievePassword ($userid)
	{
		return ($userid);
	}
	/**
	 * edit only the password
	 *
	 * @param unknown_type $userid
	 * @param unknown_type $newpassword
	 */
	public function editPassword ($userid, $newpassword)
	{
		if (strlen($newpassword) > 4)
		{
			$this->cms->connection->query("UPDATE `" . TAB_USERS . "` SET pass = sha1('" . USER_SALT . $this->cms->connection->escape_string($password) . "') WHERE id = '" . intval($userid) . "'");
		}
	}
	/**
	 * checks wether edits to user are ok
	 *
	 * @param int $id
	 * @param string $username
	 * @param string $email
	 * @param int $template
	 * @param int $lang
	 * @return unknown
	 */
	public function checkEditUser ($id, $username, $email, $template, $lang, $avatar)
	{
		$errors = array();
		$language = $this->cms->languages->getLanguage($lang);
		$template = $this->cms->templates->getTemplate($template);
		$QE = $this->cms->connection->query("SELECT id FROM `" . TAB_USERS . "` WHERE id = '" . intval($id) . "'");
		if (strlen($username) < 3)
		{
			$errors[] = 'username';
		}
		if (! $this->cms->connection->num_rows($QE) == 1)
		{
			$errors[] = 'nosuchuser';
		}
		if (! eregi('^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]{2,})+$', $email))
		{
			$errors[] = 'email';
		}
		if (!isset($language['id']))
		{
			$errors[] = 'language';
		}
		if (!isset($template['id']))
		{
			$errors[] = 'template';
		}
		if (substr($avatar, 0, 7) != "http://")
		{
			$errors[] = 'avatar';
		}
		return ($errors);
	}
	/**
	 * edits a user
	 *
	 * @param int $id
	 * @param string $username
	 * @param string $email
	 * @param int $template
	 * @param int $lang
	 * @param string $pass
	 * @return boolean
	 */
	public function editUser ($id, $username, $email, $template, $lang, $avatar, $signature)
	{
		/**
		 * checking wether user exists
		 */
		$QE = $this->cms->connection->query("SELECT id FROM `" . TAB_USERS . "` WHERE id = '" . intval($id) . "'");
		if ($this->cms->connection->num_rows($QE) == 1 AND eregi('^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]{2,})+$', $email) AND strlen($username) > 2 AND substr($avatar, 0, 7) == 'http://')
		{
			/**
			 * check wether email is ok
			 */
			$language = $this->cms->languages->getLanguage($lang);
			$template = $this->cms->templates->getTemplate($template);
			if (isset($language['id']) and isset($template['id']))
			{
				$this->cms->connection->query("UPDATE `" . TAB_USERS . "` SET
							username = '" . $this->cms->connection->escape_string($username) . "',
							email = '" . $email . "',
							template = '" . intval($template['id']) . "',
							lang = '" . intval($lang) . "',
							avatar = '" . $this->cms->connection->escape_string($avatar) . "',
							signature = '" . $this->cms->connection->escape_string($signature) . "'
							WHERE id = '" . intval($id) . "'");
				return (true);
			}
		}
		return (false);
	}
	/**
	 * returns groups for a user
	 *
	 * @param int $userid
	 * @return array
	 */
	public function getUserGroups ($userid)
	{
		// should be cached
		return ($this->cms->connection->fetch_multiarray("SELECT g.id, g.title, gm.default  FROM " . TAB_USERS_GMEMBER . " gm LEFT JOIN " . TAB_USERS_GROUPS . " g ON gm.groupid = g.id  WHERE gm.userid = " . intval($userid)));
	}
	/**
	 * gather not yet used groups for a user
	 *
	 * @param int $userid
	 * @return array
	 */
	public function getUnusedGroups ($userid)
	{
		$nlist = array();
		$groups = $this->cms->connection->fetch_multiarray("SELECT groupid FROM " . TAB_USERS_GMEMBER . " WHERE userid = " . intval($userid));
		foreach ($groups as $group)
		{
			$nlist[] = $group['groupid'];
		}
		$where = implode(" AND id != ", $nlist);
		if (! empty($where))
		{
			$where = " WHERE id != " . $where;
		} else
		{
			$where = "";
		}
		return ($this->cms->connection->fetch_multiarray("SELECT id, title FROM " . TAB_USERS_GROUPS . $where));
	}
	/**
	 * add a group
	 *
	 * @param string $title
	 * @param string $default
	 */
	public function addGroup($title, $default)
	{
		if (!empty($title) AND ($default == "true" OR $default == "false"))
		{
			$this->cms->connection->query("INSERT INTO " . TAB_USERS_GROUPS . " (id, title, `default`)  VALUES (null, '" . $this->cms->connection->escape_string($title) . "', '" . $default . "')");
		}
		else
		{
			throw new Execption("Erroneous input for addGroup");
		}
	}
	/**
	 * get all groups
	 *
	 * @return array
	 */
	public function getGroups ()
	{
		return ($this->cms->connection->fetch_multiarray("SELECT *  FROM " . TAB_USERS_GROUPS . ""));
	}
	/**
	 * get group
	 *
	 * @return array
	 */
	public function getGroup ($id)
	{
		$QE = $this->cms->connection->query("SELECT *  FROM " . TAB_USERS_GROUPS . " WHERE id = " . intval($id));
		return ($this->cms->connection->fetch_assoc($QE));
	}
	/**
	 * edit a group
	 *
	 * @param int $id
	 * @param string $title
	 * @param string $default
	 */
	public function editGroup ($id, $title, $default)
	{
		if (!empty($title) AND ($default == "true" OR $default == "false"))
		{
			$this->cms->connection->query("UPDATE " . TAB_USERS_GROUPS . " SET title = '" . $this->cms->connection->escape_string($title) . "', `default` = '" . $default . "' WHERE id = " . intval($id));
		}
		else
		{
			throw new Execption("Erroneous input for editGroup");
		}
	}
	/**
	 * delete a group
	 *
	 * @param int $id
	 */
	public function deleteGroup ($id)
	{
		$this->cms->connection->query("DELETE FROM " . TAB_USERS_GMEMBER . " WHERE groupid = " . intval($id));
		$this->cms->connection->query("DELETE FROM " . TAB_USERS_GROUPS . " WHERE id = " . intval($id));
	}
	/**
	 * edit the default group for a user
	 *
	 * @param int $groupid
	 * @param int $userid
	 */
	public function editUserDefaultGroup ($userid, $groupid)
	{
		$this->cms->connection->query("UPDATE " . TAB_USERS_GMEMBER . " SET `default`  = 'true' WHERE userid = " . intval($userid) . " AND groupid = " . intval($groupid)); 
		$this->cms->connection->query("UPDATE " . TAB_USERS_GMEMBER . " SET `default`  = 'false' WHERE userid = " . intval($userid) . " AND groupid != " . intval($groupid)); 
	}
	/**
	 * add user to group
	 *
	 * @param unknown_type $userid
	 * @param unknown_type $groupid
	 */
	public function addUserToGroup ($userid, $groupid)
	{
		if (!empty($groupid) AND intval($groupid) != 0 AND !empty($userid) AND intval($userid) != 0)
		{
			$this->cms->connection->query("INSERT INTO " . TAB_USERS_GMEMBER . " (id, userid, groupid, `default`) VALUES (null, " . intval($userid) . ", " . intval($groupid) . ", 'false')");
		}
	}
	public function removeUserFromGroup ($userid, $groupid)
	{
		$this->cms->connection->query("DELETE FROM " . TAB_USERS_GMEMBER  . " WHERE userid = " . intval($userid) . " AND groupid = " . intval($groupid)); 
	}
	/**
	 * dependancy thing..
	 *
	 * @param unknown_type $id
	 * @return unknown
	 */
	public function viewUser ($id)
	{
		return ($this->getUser($id));
	}
	/**
	 * get a user
	 *
	 * @param int $id
	 * @return user or null
	 */
	public function getUser ($id)
	{
		$QE = $this->cms->connection->query("SELECT * FROM `" . TAB_USERS . "` WHERE id = '" . intval($id) . "' LIMIT 0,1");
		if ($this->cms->connection->num_rows($QE) == 1)
		{
			return ($this->cms->connection->fetch_assoc($QE));
		} else
		{
			return (null);
		}
	}
	/**
	 * delete a user
	 *
	 * @param int $id
	 * @return boolean
	 */
	public function deleteUser ($id)
	{
		if ($id == $this->cms->user->uid)
		{
			throw new Exception("You can not delete yourself!");
		}
		$QE = $this->cms->connection->query("SELECT id FROM `" . TAB_USERS . "` WHERE id = '" . intval($id) . "'");
		if ($this->cms->connection->num_rows($QE) == 1)
		{
			$this->cms->connection->query("DELETE FROM `" . TAB_USERS . "` WHERE id = '" . intval($id) . "'");
			$this->cms->connection->query("DELETE FROM `" . TAB_USERS_GMEMBER . "` WHERE userid = '" . intval($id) . "'");
			return (true);
		} else
		{
			return (false);
		}
	}
	/**
	 * add a user
	 *
	 * @param string $username
	 * @param string $email
	 * @param string $pass
	 * @param string $unid
	 * @param int $template
	 * @param int $lang
	 * @param string $groups
	 * @param string $activated
	 * @return boolean
	 */
	public function addUser ($username, $email, $pass, $unid, $template, $lang, $groups, $activated = 'true')
	{
		$this->cms->connection->query("INSERT INTO `" . TAB_USERS . "` (id, username, pass, unid, email, template, lang, activated) VALUES
						(NULL, '" . $this->cms->connection->escape_string($username) . "', sha1('" . USER_SALT . $this->cms->connection->escape_string($pass) . "'), '" . $unid . "','" . $email . "', '" . intval($template) . "','" . intval($lang) . "', '" . $activated . "')");
		$uid = $this->cms->connection->insert_id();
		// add user to groups
		if (isset($groups[0]))
		{
			foreach ($groups AS $group)
			{
				$this->addUserToGroup($uid, $group);
			}
		}
		return ($uid);
	}
	/**
	 * checks wether user is ok for adding
	 *
	 * @param string $username
	 * @param string $email
	 * @param int $template
	 * @param int $lang
	 * @return array
	 */
	public function checkAddUser ($username, $email, $template, $lang, $password)
	{
		$errors = array();
		$language = $this->cms->languages->getLanguage($lang);
		$template = $this->cms->templates->getTemplate($template);
				
		$QE = $this->cms->connection->query("SELECT id FROM `" . TAB_USERS . "` WHERE username = '" . $this->cms->connection->escape_string($username) . "'");
		if ($this->cms->connection->num_rows($QE) != 0)
		{
			$errors[] = 'exists';
		}
		if (strlen($username) < 3)
		{
			$errors[] = 'username';
		}
		if (! eregi('^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]{2,})+$', $email))
		{
			$errors[] = 'email';
		}
		if (!isset($language['id']))
		{
			$errors[] = 'language';
		}
		if (!isset($template['id']))
		{
			$errors[] = 'template';
		}
		if (strlen($password) < 2)
		{
			$errors[] = 'password';
		}
		return ($errors);
	}
	/**
	 * activate a user
	 *
	 * @param string $unid
	 */
	public function activate ($unid)
	{
		$this->cms->connection->query("UPDATE " . TAB_USERS . " SET activated = 'true' WHERE unid = '" . $this->cms->connection->escape_string($unid) . "'");
	}
	/**
	 * finds users
	 *
	 * @param ascending or descending (default) $order
	 * @param string $on
	 * @param int $start
	 * @param int $end
	 * @return userarray
	 */
	public function findUsers ($filter = "", $order = 'asc', $on = 'id', $start = 0, $end = 100)
	{
		switch ($order)
		{
			case 'asc':
				$order = 'asc';
				break;
			default:
				$order = 'desc';
				break;
		}
		switch ($on)
		{
			case 'id':
			case 'id':
				break;
			default:
				$on = 'username';
				break;
		}
		$ret = array();
		$QE = $this->cms->connection->query("SELECT * FROM `" . TAB_USERS . "` WHERE username LIKE '" . $this->cms->connection->escape_string($filter) . "' ORDER BY " . $on . " " . $order . " LIMIT " . intval($start) . " , " . intval($end));
		while ($res = $this->cms->connection->fetch_assoc($QE))
		{
			$ret[] = $res;
		}
		return ($ret);
	}
	/**
	 * list all users
	 *
	 * @param ascending or descending (default) $order
	 * @param string $on
	 * @param int $start
	 * @param int $end
	 * @return userarray
	 */
	public function listUsers ($order = 'asc', $on = 'id', $start = 0, $end = 100)
	{
		switch ($order)
		{
			case 'asc':
				$order = 'asc';
				break;
			default:
				$order = 'desc';
				break;
		}
		switch ($on)
		{
			case 'id':
				break;
			default:
				$on = 'username';
				break;
		}
		$ret = array();
		$QE = $this->cms->connection->query("SELECT * FROM `" . TAB_USERS . "` ORDER BY " . $on . " " . $order . " LIMIT " . intval($start) . " , " . intval($end));
		while ($res = $this->cms->connection->fetch_assoc($QE))
		{
			$ret[] = $res;
		}
		return ($ret);
	}
	/**
	 * count the amount of users
	 *
	 * @return int
	 */
	public function countUsers ()
	{
		if (empty($this->usercount['normal']))
		{
			$QE = $this->cms->connection->query("SELECT count(*) AS users FROM " . TAB_USERS);
			$u = $this->cms->connection->fetch_assoc($QE);
			$this->usercount['normal'] = intval($u['users']);
		}
		return ($this->usercount['normal']);
	}
	/**
	 * count filtered users
	 *
	 * @param string $filter
	 * @return int
	 */
	public function countFilteredUsers ($filter)
	{
		$filter = str_replace('*', '%', $filter);
		$filter = strip_tags($filter);
		if (empty($this->usercount['filtered'][$filter]))
		{
			$QE = $this->cms->connection->query("SELECT count(*) AS users FROM " . TAB_USERS ." WHERE username LIKE '" . $filter . "'");
			$u = $this->cms->connection->fetch_assoc($QE);
			$this->usercount['filtered'][$filter] = intval($u['users']);
		}
		return ($this->usercount['filtered'][$filter]);
	}
	/**
	 * gets the notes for a user
	 *
	 * @param int $userid
	 * @return array
	 */
	public function getUserNotes ($userid)
	{
		$notes = $this->cms->connection->fetch_multiarray("SELECT n.*, u.username AS usernamecreator FROM " . TAB_USERS_NOTES . " n LEFT JOIN " . TAB_USERS . " u ON u.id = n.note_creator WHERE n.userid = " . intval($userid) . " ORDER BY crdate DESC");
		return ($notes);
	}
	/**
	 * add a note to a user
	 *
	 * @param int $userid
	 * @param string $note
	 */
	public function addUserNote ($userid, $note)
	{
		$user = $this->getUser($userid);
		if (!empty($note) AND isset($user['id']))
		{
			$this->cms->connection->query("INSERT INTO " . TAB_USERS_NOTES . " (id, userid, note, note_creator, crdate) VALUES (null, " . intval($userid) . ", '" . $this->cms->connection->escape_string($note) . "', " . $this->cms->user->uid . ", now() )");
		}
	}
	/**
	 * get usernote
	 *
	 * @param int $id
	 * @return usernote
	 */
	public function getUserNote ($id)
	{
		$QE = $this->cms->connection->query("SELECT * FROM " . TAB_USERS_NOTES . " WHERE id = " . intval($id));
		return ($this->cms->connection->fetch_assoc($QE));
	}
	/**
	 * delete a user note
	 *
	 * @param int $id
	 */
	public function deleteUserNote ($id)
	{
		$this->cms->connection->query("DELETE FROM " . TAB_USERS_NOTES . " WHERE id = " . intval($id));
	}
}
?>