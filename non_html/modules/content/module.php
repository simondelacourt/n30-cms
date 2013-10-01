<?php

/**
 * n30-cms content module
 * (C) 2008 CT.Studios
 * version 0.2
 * 
 * This source code is release under the BSD License.
 */

//include DIR_MODUL . DIRECTORY_SEPARATOR . "content/test.php";
// SQL defines, should be moved to other file
define('TAB_CNT_STRUCTURE', T_PREFIX . 'cnt_structure');
// include all plugins
$plugindir = realpath("./non_html/modules/content/plugins/") . "/";
if (is_dir($plugindir))
{
    if ($dh = opendir($plugindir)) 
    {
        while (($file = readdir($dh)) !== false) 
        {
        	if (substr($file, 0, 8) == "cplugin." AND substr($file, -4) == ".php")
        	{
        		require_once ($plugindir . $file);
        	}
        }
    }
}
class content
{
	private $cms;
	private $page;
	private $moduledir = "content";
	private $lang;
	private $itemcache;
	private $itemcaching = true;
	// public:
	public $file = "index";
	public $activelocation;
	
	public function __construct (&$cms)
	{
		$this->cms = &$cms;
		$this->includeLang();
	}
	/**
	 * includes the lanugage files
	 *
	 */
	private function includeLang ()
	{
		$file = $this->cms->bPath . "/non_html/modules/" . $this->moduledir . "/locale/" . $this->cms->languages->selectedlanguage['dir'] . ".php";
		if (file_exists($file))
		{
			require $file;
			if (isset($lang))
			{
				$this->lang = $lang;
			} else
			{
				throw new Exception("Module Content: erroneous language file loaded.");
			}
		} else
		{
			$file = $this->cms->bPath . "/non_html/modules/" . $this->moduledir . "/locale/" . $this->cms->languages->default['dir'] . ".php";
			if (! file_exists($file))
			{
				throw new Exception("Module Content: no language file found.");
			} else
			{
				require $file;
				$this->lang = $lang;
				if (isset($lang))
				{
					$this->lang = $lang;
				} else
				{
					throw new Exception("Module Content: erroneous language file loaded.");
				}
			}
		}
	}
	/**
	 * check if user can view certain parts
	 *
	 * @param string $guestview
	 * @param string $groups
	 * @param string $visibledate
	 * @param string $visiblefrom
	 * @param string $visibleto
	 * @return boolean
	 */
	private function canIViewThis($guestview, $groups, $visibledate = 'false', $visiblefrom='', $visibleto='')
	{
		$d = date("Ymd");
		$visiblefromn = substr($visiblefrom, 0, 4) . substr($visiblefrom, 5, 2) . substr($visiblefrom, 8, 2);
		$visibleton = substr($visibleto, 0, 4) . substr($visibleto, 5, 2) . substr($visibleto, 8, 2);
			
		if ($this->cms->user->login == false AND $guestview == 'yes')
		{ 
			/**
			 * user is guest, first check if dates are ok
			 */
			if ($visibledate == 'true' AND !empty($visiblefrom) AND !empty($visibleto))
			{		
				if ($visiblefromn < $d AND $visibleton > $d)
				{
					 return (true);
				}
				else
				{
					return (false);
				}
			}
			else
			{
				return (true);
			}
		}
		else
		{
			/**
			 * user is logged in
			 */
			$g = explode (",", $groups);
			$access = false;
			
			foreach ($this->cms->user->groups AS $group)
			{
				if (in_array($group, $g))
				{
					/**
					 * match found, now check dates
					 */
					if ($visibledate == 'true' AND !empty($visiblefrom) AND !empty($visibleto) AND ($visiblefromn < $d AND $visibleton > $d))
					{
						// 2008-05-31 00:00:00
						return (true);
					}
					elseif ($visibledate == 'false')
					{
						return (true);
					}
				}
			}
			if ($guestview == 'yes' AND (($visibledate == 'true' AND !empty($visiblefrom) AND !empty($visibleto) AND ($visiblefromn < $d AND $visibleton > $d)) XOR $visibledate = 'false'))
			{
				return (true);
			}
		}
		return (false);
	}
	/**
	 * locate template file or alternate template
	 *
	 * @param unknown_type $type
	 * @param unknown_type $file
	 * @return unknown
	 */
	public function getTemplateFile ($type, $file)
	{
		$tdir = $this->cms->templates->templates['set']['dir'];
		if ($type == 'plugin')
		{
			if (is_file($this->cms->bPath . "/" . $tdir . "/modules/content/plugins/" . $file))
			{
				return ($this->cms->bPath . "/" . $tdir . "/modules/content/plugins/" . $file);
			}
			else
			{
				return ($this->cms->bPath . "non_html/modules/content/templates/plugins/" . $file);
			}
		}
		else 
		{
			if (is_file($this->cms->bPath . "/" . $tdir . "/modules/content/" . $file))
			{
				return ($this->cms->bPath . "/" . $tdir . "/modules/content/" . $file);
			}
			else
			{
				return ($this->cms->bPath . "non_html/modules/content/templates/" . $file);
			}
		}
		
	}
	/**
	 * returns language
	 *
	 * @return array
	 */
	public function getLang ()
	{
		return ($this->lang);
	}
	/**
	 * Fetches the appropriate file
	 * 
	 *  @param unknown_type $file
	 */
	private function templateDir ($file)
	{
		echo $file;
	}
	private function showError ($error, $to = 'mod')
	{
		/**
		 * Codes:
		 * 1: File Not Found
		 * 2: Access Denied
		 */
		switch ($error)
		{
			case 1:
				// File not found
				$errorTpl = new Smarty();
				$errorTpl->template_dir = $this->cms->bPath . "/non_html/modules/" . $this->moduledir . "/templates/";
				$errorTpl->compile_dir = $this->cms->templates->compileddir;
				$errorTpl->assign('elang', $this->lang);
				$errorTpl->assign('error', 1);
				$this->cms->pageTitle = $this->lang['ERROR_1'];
				$this->cms->addDataToOutput($errorTpl->fetch('error.tpl'), $to);
			break;
			case 2:
				// no access
				$errorTpl = new Smarty();
				$errorTpl->template_dir = $this->cms->bPath . "/non_html/modules/" . $this->moduledir . "/templates/";
				$errorTpl->compile_dir = $this->cms->templates->compileddir;
				$errorTpl->assign('elang', $this->lang);
				$errorTpl->assign('error', 2);
				$this->cms->pageTitle = $this->lang['ERROR_2'];
				$this->cms->addDataToOutput($errorTpl->fetch('error.tpl'), $to);
			break;
			default:
				throw new Exception("Unhandled error in module content.");
				break;
		}
	}
	/**
	 * load a plugin
	 *
	 * @param string $plugin
	 * @param int $id
	 * @return unknown
	 */
	private function getPlugin ($plugin, $id)
	{
		if (!empty($plugin))
		{
			// return loaded plugin object
			$class = "cPlugin_" . $plugin;
			if (class_exists($class))
			{
				$plugin = new $class($this->cms, $id);
				return $plugin;
			} else
			{
				throw new Exception("Content module: unknown plugin loaded (" . $plugin . ")");
			}
		}
	}
	/**
	 * retrieve the item data
	 *
	 * @param string $path
	 * @return array
	 */
	public function getItem ($path)
	{
		if (isset($this->itemcache[$path]) and $this->itemcaching == true)
		{
			return ($this->itemcache[$path]);
		} else
		{
			if ($path == "/")
			{
				$QE = $this->cms->connection->query("SELECT * FROM " . TAB_CNT_STRUCTURE . " WHERE full_location = '/'");
				if ($this->cms->connection->num_rows($QE) == 0)
				{
					$this->cms->connection->query("
					INSERT INTO  " . TAB_CNT_STRUCTURE . " (
					`id` ,
					`id_parent` ,
					`full_location` ,
					`full_title` ,
					`int_title` ,
					`user_author` ,
					`str_type` ,
					`str_plugin` ,
					`visible_from` ,
					`visible_to` ,
					`visible_date` ,
					`excludefromnav` ,
					`visible_guest` ,
					`visible_group` ,
					`dir_indexes` ,
					`dir_indexfile` ,
					`tags` ,
					`sortorder`
					)
					VALUES (
					NULL ,  '-1',  '/',  '/',  '/',  '0',  'dir',  '',  now(),  now(),  'false',  'true',  'yes',  '',  'true',  '',  '',  ''
					);");	
					
					$item['id'] = 0;
					$item['full_title'] = '/';
					$item['full_location'] = '/';
					$item['str_type'] = 'dir';
					$item['visible_group'] = '';
					$item['visible_guest'] = 'yes';
				}
				else 
				{
					$item = $this->cms->connection->fetch_assoc($QE);
					$item['id'] = 0;
				}
				$this->itemcache['/'] = $item;
			}
			else
			{
				$item = array();
				if (substr($path, 0, 1) != "/")
				{
					$path = "/" . $path;
				}
				$QE = $this->cms->connection->query("SELECT * FROM " . TAB_CNT_STRUCTURE . " WHERE full_location = '" . $this->cms->connection->escape_string($path) . "'");
				$item = $this->cms->connection->fetch_assoc($QE);
				if ($this->itemcaching)
				{
					$this->itemcache[$path] = $item;
				}
			}
			return ($item);
		}
	}
	/**
	 * retrieve item not by path, but id
	 *
	 * @param int $id
	 * @return array
	 */
	public function getItemById ($id)
	{
		$item['id'] = $id;
		if ($id == 0)
		{
			$item['full_title'] = '/';
			$item['full_location'] = '/';
			$item['str_type'] = 'dir';
		}
		else
		{
			$QE = $this->cms->connection->query("SELECT * FROM " . TAB_CNT_STRUCTURE . " WHERE id = " . intval($id));
			$item = $this->cms->connection->fetch_assoc($QE);
		}
		return ($item);
	}
	/**
	 * checks wether a path is a dir or a plugin
	 *
	 * @param string $path
	 * @return boolean
	 */
	public function isDir ($path)
	{
		$item = $this->getItem($path);
		if ($item['str_type'] == 'dir')
		{
			return (true);
		} else
		{
			return (false);
		}
	}
	/**
	 * gets a list
	 *
	 * @param string $path
	 */
	public function getList ($parentid)
	{
		/**
		 * now fetch the items
		 */
		$items = array();
		$QLIST = $this->cms->connection->query("SELECT * FROM " . TAB_CNT_STRUCTURE . " WHERE id_parent = " . intval($parentid) . "  AND (visible_date = 'false' OR (visible_date = 'true' AND (visible_from < now() AND visible_to > now()))) ORDER BY sortorder ASC");
		while ($res = $this->cms->connection->fetch_assoc($QLIST))
		{
			$res['link'] = $this->cms->generateLink($this->file, array('path' => $res['full_location']));
			$items[] = $res;
		}
		return ($items);
	}
	/**
	 * gets a menu
	 *
	 * @param string $path
	 */
	public function getMenu ($path, $active = "")
	{
		try
		{
			if (!empty($this->activelocation))
			{
				$active = $this->activelocation;
			}
			$list = array();
			/**
			 * let's check the path
			 */
			if ($path != "/")
			{
				$item = $this->getItem($path);
				if ($item['id_parent'] == "0" and $item['str_type'] != "dir")
				{
					$path = "/";
				}
			}
			$pexp = explode('/', $path);
			$pnew = array();
			foreach ($pexp as $pitem)
			{
				if (! empty($pitem))
				{
					$pnew[] = $pitem;
				}
			}
			if (empty($path) or $path == "/")
			{
				/**
				 * path is root, is easier to fetch directly
				 */
				$QLIST = $this->cms->connection->query("SELECT * FROM " . TAB_CNT_STRUCTURE . " WHERE id_parent = 0 AND excludefromnav = 'false' AND (visible_date = 'false' OR (visible_date = 'true' AND (visible_from < now() AND visible_to > now() ))) ORDER BY sortorder ASC");
				while ($res = $this->cms->connection->fetch_assoc($QLIST))
				{
					if ($this->canIViewThis($res['visible_guest'], $res['visible_group']))
					{
						if (!empty($active) AND $res['full_location'] == $active)
						{
							$res['active'] = "true";
						} else
						{
							$res['active'] = "false";
						}
						$res['link'] = $this->cms->generateLink($this->file, array('path' => $res['full_location']));
						$list[] = $res;
					}
				}
			} else
			{
				/**
				 * not root, something else, first fetching the item, then fetching it's members
				 */
				$item = $this->getItem($path);
				if ($item['str_type'] == 'dir')
				{
					$QLIST = $this->cms->connection->query("SELECT * FROM " . TAB_CNT_STRUCTURE . " WHERE id_parent = " . $item['id'] . " AND excludefromnav = 'false' AND excludefromnav = 'false' AND (visible_date = 'false' OR (visible_date = 'true' AND (visible_from < now() AND visible_to > now() ))) ORDER BY sortorder ASC");
					while ($res = $this->cms->connection->fetch_assoc($QLIST))
					{
						if ($this->canIViewThis($res['visible_guest'], $res['visible_group']))
						{
							if (!empty($active) AND $res['full_location'] == $active)
							{
								$res['active'] = "true";
							} else
							{
								$res['active'] = "false";
							}
							$res['link'] = $this->cms->generateLink($this->file, array('path' => $res['full_location']));
							$list[] = $res;
						}
					}
				} else
				{
					$QLIST = $this->cms->connection->query("SELECT * FROM " . TAB_CNT_STRUCTURE . " WHERE id_parent = " . $item['id_parent'] . " AND excludefromnav = 'false' AND (visible_date = 'false' OR (visible_date = 'true' AND (visible_from < now() AND visible_to > now() ))) ORDER BY sortorder ASC");
					while ($res = $this->cms->connection->fetch_assoc($QLIST))
					{
						if ($this->canIViewThis($res['visible_guest'], $res['visible_group']))
						{
							if ($active != "" and $res['full_location'] == $active)
							{
								$res['active'] = "true";
							} else
							{
								$res['active'] = "false";
							}
							$res['link'] = $this->cms->generateLink($this->file, array('path' => $res['full_location']));
							$list[] = $res;
						}
					}
				}
			}
			return ($list);
		} catch (Exception $e)
		{
			$this->cms->exceptions->addError($e);
		}
	}
	/**
	 * shows a list of items in a directory or a directory related to a pag
	 *
	 * @param string $path
	 * @param string $to
	 * @param string $viewmode
	 */
	public function showList ($path, $to, $viewmode = 'default')
	{
		/**
		 * first analyse the item
		 */
		$item = $this->getItem($path);
		$items = $this->getList($item['id']);
		switch ($viewmode)
		{
			default:
				$listview = new Smarty();
				$listview->template_dir = $this->cms->bPath . "/non_html/modules/" . $this->moduledir . "/templates/";
				$listview->compile_dir = $this->cms->templates->compileddir;
				$listview->assign('clang', $this->lang);
				$listview->assign('list', $items);
				$listview->assign('item', $item);
				$this->cms->pageTitle = $item['full_title'];
				$this->cms->pageDesc = $item['description'];
				$this->cms->addDataToOutput($listview->fetch($this->getTemplateFile('normal', 'l.default.tpl')), $to);
			break;
		}
	}
	/**
	 * shows a location, no matter what it is.
	 *
	 * @param string $path
	 * @param string $to
	 * @param string $viewmode
	 */
	public function showlocation ($path, $to, $viewmode = 'default')
	{
		try
		{
			// locate and load item
			$item = $this->getItem($path);
			$this->cms->pageTitle = $item['full_title'];
			$this->cms->pageDesc = $item['description'];
			$view = $this->canIViewThis($item['visible_guest'], $item['visible_group'], $item['visible_date'], $item['visible_from'], $item['visible_to']);
			if (! isset($item['id']) and $path != "" and $path != "/")
			{
				// if item is empty show error
				$this->showError(1, $to);
			} 
			elseif ($item['str_type'] == 'dir' OR ($path == "/" OR $path == ""))
			{
				if ($view AND (!empty($item['dir_indexfile']) AND $item['dir_indexfile'] != '0'))
				{
					$linkfile = $this->getItemById($item['dir_indexfile']);
					
					if ($linkfile['str_type'] == 'plugin')
					{
						// load plugin
						$plugin = $this->getPlugin($linkfile['str_plugin'], $linkfile['id']);
						// show item
						$this->cms->addDataToOutput($plugin->getOutput($viewmode), $to);
						// set active location
						$this->activelocation = $item['full_location'];
						$this->cms->pageDesc = $linkfile['description'];
						$this->cms->pageTitle = $linkfile['full_title'];
					}
					else
					{
						throw new Exception ('Erroneous Dir Index.');
					}
				}
				elseif ($view AND ($item['dir_indexes'] == 'true' OR $item['id'] == 0))
				{
					// wrong type of item, can not display dirs
					$this->showList($path, $to, $viewmode);
				}
				else 
				{
					// no access here
					$this->showError(2, $to);	
				}
			} 
			elseif ($view)
			{	
				// load plugin
				$plugin = $this->getPlugin($item['str_plugin'], $item['id']);
				// show item
				$this->cms->addDataToOutput($plugin->getOutput($viewmode), $to);
			}
			else
			{
				// no access here
				$this->showError(2, $to);	
			}
		} catch (Exception $e)
		{
			$this->cms->exceptions->addError($e);
		}
	}
	public function showRandomItem ($path, $to)
	{
		$parent = $this->getItem($path);
		$QE = $this->cms->connection->query("SELECT full_location FROM `" . TAB_CNT_STRUCTURE . "` WHERE id_parent = '" . $parent['id'] . "' ORDER BY rand() DESC LIMIT 0,1 ");
		$res = $this->cms->connection->fetch_assoc($QE);
		$this->showlocation($res['full_location'], $to);
	}
	/**
	 * show an internal info stream
	 *
	 * @param unknown_type $data
	 */
	public function showInternal ($data, $to='mod')
	{
		try
		{
			if (isset($data['itemid']))
			{
				// item data came through, getting item
				$item = $this->getItemById($data['itemid']);
				$view = $this->canIViewThis($item['visible_guest'], $item['visible_group'], $item['visible_date'], $item['visible_from'], $item['visible_to']);
				if (!isset($item['id']))
				{
					// no item found
					throw new Exception('Non existing Item loaded');
				}
				elseif ($item['str_type'] == 'dir')
				{
					// item is directory, so does not have a plugin, so no internal communication to plugin required
					throw new Exception('Can not load directory.');
				}
				elseif (!$view)
				{
					// can not view the plugin, so not letting the user even communicate with it
					$this->showError(2);
				}
				else 
				{
					// all ok, now we can view it.
					$plugin = $this->getPlugin($item['str_plugin'], $item['id']);
					if (isset($plugin->intoutput))
					{
						// set active location
						$this->activelocation = $item['full_location'];
						$this->cms->pageTitle = $item['full_title'];
						$this->cms->pageDesc = $item['description'];
						$this->cms->addDataToOutput($plugin->internal($data), $to);
					}
					else
					{
						throw new Exception ('Plugin does not support internal output feature');
					}
				}
			}
			else
			{
				throw new Exception ('No ID known.');
			}
		} catch (Exception $e)
		{
			$this->cms->exceptions->addError($e);
		}
	}
	/**
	 * bogus function, required but not used
	 *
	 * @param unknown_type $function
	 * @return unknown
	 */
	public function show ($function)
	{
		return (null);
	}
}
?>