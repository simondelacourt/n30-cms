<?php
/**
 * n30-cms settings
 * version 0.2
 * ------------------------------------------------------------------------------------
 * LICENSE
 * ------------------------------------------------------------------------------------
 * This source code is release under the BSD License.
 * This file is part of N30-CMS
 * n30-cms version 0.6
 * ------------------------------------------------------------------------------------
 * DESCRIPTION:
 * ------------------------------------------------------------------------------------
 * Loading of settings and stuff.
 * 
 * ------------------------------------------------------------------------------------
 * Author: Simon de la Court
 * 
 */
/**
/**
 * (C) 2008 CT.Studios registry
 *
 * TODO: addvar, deleteVar
 * 
 * This source code is release under the BSD License.
 */
/**
 * SQL UPDATES:
 * RENAME TABLE  `n30_06`.`n30_registry` TO  `n30_06`.`n30_settings` ;
 */ 

define ('TAB_SETTINGS', T_PREFIX . 'settings');
define ('TAB_PERSSETTINGS', T_PREFIX . 'perssettings');

class settings
{
	private $cms;
	private $settings;
	private $settingtypes = array('bool', 'string', 'int');
	public function __construct (&$cms)
	{
		$this->cms = &$cms;
		$this->loadSettings();
		if ($this->cms->user->login)
		{
			$this->loadPersonalSettings($this->cms->user->uid);
		}
	}
	/**
	 * loads settings
	 *
	 */
	private function loadSettings ()
	{
		$QE = $this->cms->connection->query("SELECT * FROM " . TAB_SETTINGS . " ORDER BY id ASC");
		while ($res = $this->cms->connection->fetch_assoc($QE))
		{
			switch ($res['type'])
			{
				case 'bool':
					if ($res['reg_value'] == 'true')
					{
						$this->settings[$res['category_name']][$res['name']] = true;
					} else
					{
						$this->settings[$res['category_name']][$res['name']] = false;
					}
				break;
				case 'int':
					$this->settings[$res['category_name']][$res['name']] = intval($res['reg_value']);
				break;
				default:
					$this->settings[$res['category_name']][$res['name']] = $res['reg_value'];
				break;
			}
		}
	}
	/**
	 * load the personal settings of a user
	 *
	 * @param int $userid
	 */
	private function loadPersonalSettings ($userid)
	{
		$QE = $this->cms->connection->query("SELECT p.*, s.category_name, s.type, s.name FROM " . TAB_PERSSETTINGS . " p LEFT JOIN " . TAB_SETTINGS . " s ON p.setting_id = s.id WHERE user_id = " . intval($userid));
		while ($res = $this->cms->connection->fetch_assoc($QE))
		{
			switch ($res['type'])
			{
				case 'bool':
					if ($res['value'] == 'true')
					{
						$this->settings[$res['category_name']][$res['name']] = true;
					} else
					{
						$this->settings[$res['category_name']][$res['name']] = false;
					}
				break;
				case 'int':
					$this->settings[$res['category_name']][$res['name']] = intval($res['value']);
				break;
				default:
					$this->settings[$res['category_name']][$res['name']] = $res['value'];
				break;
			}
		}
	}
	/**
	 * add a setting to settings manager
	 *
	 * @param string $category
	 * @param string $name
	 * @param string $type
	 * @param string $value
	 * @param string $deleteable
	 */
	public function addSetting ($category, $name, $type, $value, $deleteable='false')
	{
		if (in_array($type, $this->oktypes) AND !empty($category) AND !empty($name) AND !empty($value))
		{
			$this->cms->connection->query("INSERT INTO  `" . TAB_SETTINGS . " ` (`id`, `type`, `name`, `category_name`, `reg_value`, `deleteable`) VALUES (
											NULL ,  '" . $this->cms->connection->escape_string($type) . "',  '" . $this->cms->connection->escape_string($name) . "',  '" . $this->cms->connection->escape_string($category) . "',  '" . $this->cms->connection->escape_string($value) . "',  '" . $this->cms->connection->escape_string($deleteable) . "');");
			// add the value also to the current array of settings
			switch ($type)
			{
				case 'bool':
					if ($value == 'true')
					{
						$this->settings[$category][$name] = true;
					} else
					{
						$this->settings[$category][$name] = false;
					}
				break;
				case 'int':
					$this->settings[$category][$name] = intval($value);
				break;
				default:
					$this->settings[$category][$name] = $value;
				break;
			}
		}
	}
	/**
	 * delete a settings from the settings library
	 *
	 * @param int $id
	 */
	public function deleteSetting ($category, $name)
	{
		$this->cms->connection->query("DELETE FROM " . TAB_SETTINGS . " WHERE category_name = '" . $this->cms->connection->escape_string($category) . "' AND name = '" . $this->cms->connection->escape_string($name) . "'");
	}
	public function deletePersonalSetting ($userid, $category, $name)
	{
		$setting = $this->getIntSetting($category, $name);
		if (isset($setting['id']))
		{
			$this->cms->connection->query("DELETE FROM " . TAB_PERSSETTINGS . " WHERE setting_id = " . intval($setting['id']) . " AND user_id = " . intval($userid));
		}
	}
	/**
	 * list all registry vars
	 *
	 * @param string $category
	 * @return array
	 */
	public function getSettings ($category = "")
	{
		if (empty($category))
		{
			$where = '';
		}
		else
		{
			$where = " WHERE category_name = '" . $this->cms->connection->escape_string($category) . "'";
		}
		$ret = array();
		$QE = $this->cms->connection->query("SELECT * FROM " . TAB_SETTINGS . " " . $where);
		while ($res = $this->cms->connection->fetch_assoc($QE))
		{
			$ret[] = $res;
		}
		return ($ret);
	}
	/**
	 * return all categories
	 *
	 * @return array
	 */
	public function getCategories ()
	{
		$ret = array();
		$QE = $this->cms->connection->query("SELECT category_name FROM " . TAB_SETTINGS . " GROUP BY category_name ORDER by category_name ASC");
		while ($res = $this->cms->connection->fetch_assoc($QE))
		{
			$ret[] = $res;
		}
		return ($ret);
	}
	/**
	 * get settings
	 *
	 * @param string $category
	 * @param string $name
	 * @return array
	 */
	public function getSetting ($category, $name)
	{
		if (isset($this->settings[$category][$name]))
		{
			return ($this->settings[$category][$name]);
		}
		else
		{
			return (null);
		}
	}
	/**
	 * get internal setting from DB
	 *
	 * @param string $category
	 * @param string $name
	 * @return array
	 */
	private function getIntSetting ($category, $name)
	{
		$QE = $this->cms->connection->query("SELECT * FROM " . TAB_SETTINGS . " WHERE category_name = '" . $this->cms->connection->escape_string($category) . "' AND name = '" . $this->cms->connection->escape_string($name) . "'");
		return ($this->cms->connection->fetch_assoc($QE));
	}
	/**
	 * edit a setting
	 *
	 * @param string $category
	 * @param string $name
	 * @param string $value
	 */
	public function updateSetting ($category, $name, $value)
	{
		$this->cms->connection->query("UPDATE " . TAB_SETTINGS . " SET value = '" . $this->cms->connection->escape_string($value) . "' WHERE category_name = '" . $this->cms->connection->escape_string($category) . "' AND name = '" . $this->cms->connection->escape_string($name) . "'");
	}
	/**
	 * Update or add a personal value for a user
	 *
	 * @param int $userid
	 * @param string $category
	 * @param string $name
	 * @param string $value
	 */
	public function updatePersonalSetting ($userid, $category, $name, $value)
	{
		try
		{
			$QE = $this->cms->connection->query("SELECT id, type, category_name, name FROM " . TAB_SETTINGS . " WHERE category_name = '" . $this->cms->connection->escape_string($category) . "' AND name = '" . $this->cms->connection->escape_string($name) . "'" );
			if ($this->cms->connection->num_rows($QE) == 1)
			{
				$setting = $this->cms->connection->fetch_assoc($QE);
				if ($this->cms->connection->num_rows($this->cms->connection->query("SELECT id FROM " . TAB_PERSSETTINGS . " WHERE setting_id = " . intval($setting['id']))) < 1)
				{
					$this->cms->connection->query("INSERT INTO " . TAB_PERSSETTINGS . " (id, user_id, setting_id, value) VALUES (null, '" . intval($userid) . "', '" . intval($setting['id']) . "', '" . $this->cms->connection->escape_string($value) . "')");
					if ($this->cms->user->uid == $userid)
					{
						// add the value also to the current array of settings
						switch ($setting['type'])
						{
							case 'bool':
								if ($value == 'true')
								{
									$this->settings[$setting['category_name']][$setting['name']] = true;
								} else
								{
									$this->settings[$setting['category_name']][$setting['name']] = false;
								}
							break;
							case 'int':
								$this->settings[$setting['category_name']][$setting['name']] = intval($value);
							break;
							default:
								$this->settings[$setting['category_name']][$setting['name']] = $value;
							break;
						}
					}
				}
				else
				{
					// update this setting instead of create it
					$this->cms->connection->query("UPDATE " . TAB_PERSSETTINGS . " SET value = '" . $this->cms->connection->escape_string($value) . "' WHERE user_id = " . intval($userid) . " AND setting_id = " . intval($setting['id']));
					if ($this->cms->user->uid == $userid)
					{
						// add the value also to the current array of settings
						switch ($setting['type'])
						{
							case 'bool':
								if ($value == 'true')
								{
									$this->settings[$setting['category_name']][$setting['name']] = true;
								} else
								{
									$this->settings[$setting['category_name']][$setting['name']] = false;
								}
							break;
							case 'int':
								$this->settings[$setting['category_name']][$setting['name']] = intval($value);
							break;
							default:
								$this->settings[$setting['category_name']][$setting['name']] = $value;
							break;
						}
					}
				}
			}
			else
			{
				throw new Exception ("Could not create personal setting, setting context was non existant.");
			}
		}
		catch (Exception $e)
		{
			$this->cms->exceptions->addError($e);
		}
	}
}
?>