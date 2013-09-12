<?php
/**
 * n30-cms admin: rights
 * 
 * ------------------------------------------------------------------------------------
 * LICENSE
 * ------------------------------------------------------------------------------------
 * This source code is release under the BSD License.
 * This file is part of N30-CMS
 * n30-cms version 0.6
 * ------------------------------------------------------------------------------------
 * DESCRIPTION:
 * ------------------------------------------------------------------------------------
 * Access management
 * 
 * ------------------------------------------------------------------------------------
 * Author: Simon de la Court
 * 
 */

class adminRights
{
	private $cms;
	private $groups;
	private $userid;
	private $rights;
	public function __construct (&$cms)
	{
		$this->cms = &$cms;
		$this->groups = $cms->user->groups;
		$this->userid = $this->cms->user->uid;
		$this->getRights();
	}
	/**
	 * fetches rights based on group membership and userid
	 *
	 */
	private function getRights ()
	{
		$or = "";
		if (count($this->groups) > 0)
		{
			if (count($this->groups) == 1)
			{
				$or = "OR (ownertype = 'group' AND ownerid = '" . implode('', $this->groups) . "')";
			} else
			{
				$or = "OR (ownertype = 'group' AND (ownerid = " . implode(" OR ownerid =  ", $this->groups) . "))";
			}
		}
		$QE = $this->cms->connection->query("SELECT * FROM " . TAB_ADMIN_XS . " WHERE (ownertype = 'user' AND ownerid = " . intval($this->userid) . ") " . $or);
		while ($res = $this->cms->connection->fetch_assoc($QE))
		{
			$this->rights[$res['accessto']] = true;
		}
	}
	/**
	 * check if user has access to the admin panel
	 *
	 * @return boolean
	 */
	public function xstoAdmin ()
	{
		if (isset($this->rights['admin']))
		{
			return (true);
		} else
		{
			return (false);
		}
	}
	/**
	 * checks if user has access to a certain admin module
	 *
	 * @param string $mod
	 * @return boolean
	 */
	public function xstoAdm ($mod)
	{
		$mod = "adm_" . $mod;
		if (isset($this->rights[$mod]) or isset($this->rights['mod_all']))
		{
			return (true);
		} else
		{
			return (false);
		}
	}
	/**
	 * check if user has access to a certain mod
	 *
	 * @param string $mod
	 * @return boolean
	 */
	public function xstoMod ($mod)
	{
		$mod = "mod_" . $mod;
		if (isset($this->rights[$mod]) or isset($this->rights['mod_all']))
		{
			return (true);
		} else
		{
			return (false);
		}
	}
	/**
	 * add right to database
	 *
	 * @param string $type
	 * @param string $mod
	 */
	public function addRight ($ownertype, $ownerid, $accessto)
	{
		if ($ownertype == "group" OR $ownertype == "user")
		{
			$this->cms->connection->query("INSERT INTO " . TAB_ADMIN_XS . " (id, ownertype, ownerid, accessto) VALUES (null, '" . $ownertype . "', '" . intval($ownerid) . "', '" . $this->cms->connection->escape_string($accessto) . "')");
		}
		else 
		{
			throw new Exception ("Illegal ownertype for addRight");
		}
	}
	/**
	 * delete right from database
	 *
	 * @param int $id
	 */
	public function deleteRight ($id)
	{
		$this->cms->connection->query("DELETE FROM " . TAB_ADMIN_XS . " WHERE id = " . intval($id));
	}
	/**
	 * list all rights
	 *
	 * @param usertype string $type
	 * @param userid int $id
	 */
	public function listRights ($type, $id)
	{
		if ($type == 'group' OR $type == 'user')
		{
			return ($this->cms->connection->fetch_multiarray("SELECT * FROM " . TAB_ADMIN_XS . " WHERE ownertype = '" . $type ."' AND ownerid = " . intval($id)));
		}
		else 
		{
			throw new Exception ("Illegal type call for listRights");
		}
	}
	
	
}
?>