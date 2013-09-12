<?php
/**
 * (C) 2008 CT.Studios
 * 
 * This source code is release under the BSD License.
 *
 */

/**
 * We first include all plugins, so we don't have to do that in a dirty way
 */
$plugindir = realpath("../non_html/modules/content/plugins/") . "/";
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

/**
 * admin for content
 *
 */
class contentAdmin
{
	// private:
	private $cms;
	private $inttitle;
	private $itemcaching = true; // true or false
	private $itemcacheid;
	private $itemcachepath;

	
	// public:
	public $version = 0.2;
	public $moduledir = "content";
	public $file = "index";
	public $currentparentid;
	
	public function __construct ($cms)
	{
		$this->cms = $cms;

		$this->cms->forceDebugMode();
		try
		{
			$this->includeLang();
		} catch (Exception $e)
		{
			$this->cms->exceptions->addError($e);
		}
		if ($_SERVER['REQUEST_METHOD'] == 'POST' AND isset($_POST['action']))
		{
			try {
				$this->processPost($_POST);
			}
			catch (Exception $e)
			{
				$this->cms->exceptions->addError($e);
			}
		}
	}
	/**
	 * processes all post data
	 *
	 * @param array $post
	 */
	private function processPost ($post)
	{
		switch ($post['action'])
		{
			case 'move':
				$item = $this->getItem($post['id']);
				if (!isset($item['id']) OR $item['str_type'] != 'plugin')
				{
					throw new Exception('Erroneous input');
				}
				else
				{
					$this->moveItem($post['id'], $post['moveto']);
				}
				header ("Location: " . admin::generateLink("m", array("module" => "content", "action" => "dir", "id" => intval($item['id_parent']))));
				exit();	
			break;
			case 'editdir':
				$item = $this->getItem($post['id']);
				if (!isset($item['id']))
				{
					throw new Exception('Item not found');
				}
				// checking vars first!
				if (isset($post['excludefromnav']))
				{
					$excludefromnav = 'true';
				}
				else
				{
					$excludefromnav = 'false';
				}
				if (isset($post['visibledate']))
				{
					$visibledate = 'true';
				}
				else
				{
					$visibledate = 'false';
				}
				if (isset($post['visibleguest']))
				{
					$visibleguest = 'yes';
				}
				else
				{
					$visibleguest = 'no';
				}
				if (isset($post['visgroup']) AND is_array($post['visgroup']))
				{
					$visgroups = $post['visgroup'];
				}
				else
				{
					$visgroups = array();
				}
				if (isset($post['showindexes']))
				{
					$showindexes = 'true';
				}
				else 
				{
					$showindexes = 'false';
				}
				$sitem = $this->getItem($post['indexfile']);
				if (!isset($sitem['id']))
				{
					throw new Exception("Erroneous input");
				}
				$error = false;
				if (!empty($post['title']))
				{
					$this->editDir($item['id'], $post['title'],  $excludefromnav, $visibledate, $post['visiblefrom'], $post['visibleto'], $visibleguest, $visgroups, $showindexes, $sitem['id']);
				}
				elseif ($item['id'] == 0) 
				{
					$this->editDir($item['id'], "/",  $excludefromnav, $visibledate, $post['visiblefrom'], $post['visibleto'], $visibleguest, $visgroups, $showindexes, $sitem['id']);
				}
				header ("Location: " . admin::generateLink("m", array("module" => "content", "action" => "dir", "id" => intval($item['id']))));
				exit();	
			break;
			case 'delete':
				if (isset($post['id']))
				{
					$item = $this->getItem($post['id']);
					$this->deleteItem($post['id']);
					header ("Location: " . admin::generateLink("m", array("module" => "content", "action" => "dir", "id" => intval($item['id_parent']))));
					exit();	
				}
				else
				{
					throw new Exception("Erroneous input");
				}
			break;
			case 'newitem':
				if (isset($post['id']) AND (!empty($post['id']) XOR $post['id'] == "0") AND isset($post['plugin']) AND !empty($post['plugin']))
				{
					if ($post['plugin'] == 'directory')
					{
						header ("Location: " . admin::generateLink("m", array("module" => "content", "action" => "adddir", "id" => intval($post['id']))));
					}
					else
					{
						header ("Location: " . admin::generateLink("m", array("module" => "content", "action" => "additem", "id" => intval($post['id']), "plugin" => $post['plugin'])));
					}
					exit();
				}
				else 
				{
					throw new Exception("Erroneous post information.");
				}
			break;
			case 'additem':
				if (isset($post['plugin']) AND !empty($_POST['title']))
				{
					
					$pltitle = "cAPlugin_" . $post['plugin'];
					if (class_exists($pltitle))
					{
						// checking vars first!
						if (isset($post['excludefromnav']))
						{
							$excludefromnav = 'true';
						}
						else
						{
							$excludefromnav = 'false';
						}
						if (isset($post['visibledate']))
						{
							$visibledate = 'true';
						}
						else
						{
							$visibledate = 'false';
						}
						if (isset($post['visibleguest']))
						{
							$visibleguest = 'yes';
						}
						else
						{
							$visibleguest = 'no';
						}
						if (isset($post['visgroup']) AND is_array($post['visgroup']))
						{
							$visgroups = $post['visgroup'];
						}
						else
						{
							$visgroups = array();
						}
						$error = false;
						
						// load plugin, all well
						$plugin = new $pltitle($this->cms, 'new', $this);
						if (isset($post['pdata']) AND $plugin->check($post['pdata']) AND !empty($post['title']))
						{
							if (!isset($plugin->blocknew))
							{
								// first create the new item, so we can bind this new plugin instance to an item
								$id = $this->newItem($post['title'], $post['id'], $post['desc'], $post['thumbnail'], $excludefromnav, $visibledate, $post['visiblefrom'], $post['visibleto'], $visibleguest, $visgroups, $post['tags'], $post['plugin']);
								$post['pdata']['iid'] = $id;			
								$plugin->edit($post['pdata']);
							}
							else
							{
								$plugin->newSpecial($post['pdata'], $post['id'], $post['desc'], $post['thumbnail'], $excludefromnav, $visibledate, $post['visiblefrom'], $post['visibleto'], $visibleguest, $visgroups, $post['tags'], $post['plugin']);
							}
						}
						else
						{
							$error = true;
						}
						// TODO: create error handling
						if ($error)
						{
							throw new Exception ('something wwwwong!');
						}
						// no errors, let's get the hell outta here
						if (!$error)
						{
							header ("Location: " . admin::generateLink("m", array("module" => "content", "action" => "dir", "id" => intval($post['id']))));
							exit();		
						}
					}
					else
					{
						throw new Exception("Illegal plugin loaded for content admin module. Plugin does not contain admin handler.");
					}
					
				}
			break;
			case 'adddir':
				$item = $this->getItem($post['id']);
				if (!isset($item['id']))
				{
					throw new Exception('Item not found');
				}
				if (isset($post['excludefromnav']))
				{
					$excludefromnav = 'true';
				}
				else
				{
					$excludefromnav = 'false';
				}
				if (isset($post['visibledate']))
				{
					$visibledate = 'true';
				}
				else
				{
					$visibledate = 'false';
				}
				if (isset($post['showindexes']))
				{
					$showindexes = 'true';
				}
				else
				{
					$showindexes = 'false';
				}
				if (isset($post['visibleguest']))
				{
					$visibleguest = 'yes';
				}
				else
				{
					$visibleguest = 'no';
				}
				if (isset($post['visgroup']) AND is_array($post['visgroup']))
				{
					$visgroups = $post['visgroup'];
				}
				else
				{
					$visgroups = array();
				}
				
				if (!empty($post['title']))
				{
					$id = $this->newDirectory($post['title'], $post['id'], $excludefromnav, $showindexes, $visibledate, $post['visiblefrom'], $post['visibleto'], $visibleguest, $visgroups);
					if ($id != 0)
					{
						header ("Location: " . admin::generateLink("m", array("module" => "content", "action" => "dir", "id" => intval($post['id']))));
						exit();
					}
					else
					{
						throw new Exception ('Something went wrong, could not add directory');	
					}
				}
			break;
			case 'edititem':
				
				$item = $this->getItem($post['id']);
				if (!isset($item['id']))
				{
					throw new Exception('Item not found');
				}
				
				
				$pltitle = "cAPlugin_" . $item['str_plugin'];
				if (class_exists($pltitle))
				{
					// checking vars first!
					if (isset($post['excludefromnav']))
					{
						$excludefromnav = 'true';
					}
					else
					{
						$excludefromnav = 'false';
					}
					if (isset($post['visibledate']))
					{
						$visibledate = 'true';
					}
					else
					{
						$visibledate = 'false';
					}
					if (isset($post['visibleguest']))
					{
						$visibleguest = 'yes';
					}
					else
					{
						$visibleguest = 'no';
					}
					if (isset($post['visgroup']) AND is_array($post['visgroup']))
					{
						$visgroups = $post['visgroup'];
					}
					else
					{
						$visgroups = array();
					}
					$error = false;
					// load plugin, all well
					$plugin = new $pltitle($this->cms, $post['id'], $this);
					if ($plugin->check($post['pdata']) AND !empty($post['title']))
					{				
						$id = $this->editItem($item['id'], $post['title'],  $post['desc'], $post['thumbnail'], $excludefromnav, $visibledate, $post['visiblefrom'], $post['visibleto'], $visibleguest, $visgroups, $post['tags']);
						$post['pdata']['iid'] = $id;			
						$plugin->edit($post['pdata']);
					}
					else
					{
						$error = true;
					}
					// TODO: create error handling
					if ($error)
					{
						throw new Exception ('something wwwwong!');
					}
					// no errors, let's get the hell outta here
					if (!$error)
					{
						header ("Location: " . admin::generateLink("m", array("module" => "content", "action" => "item", "id" => intval($item['id']))));
						exit();		
					}
				}
				else
				{
					throw new Exception("Illegal plugin loaded for content admin module. Plugin does not contain admin handler.");
				}
			break;
			default:
				throw new Exception("Illegal post action");
			break;
		}
	}
	/**
	 * includes the lanugage files
	 *
	 */
	private function includeLang ()
	{
		$file = $this->cms->bPath . "../non_html/modules/" . $this->moduledir . "/locale/" . $this->cms->languages->selectedlanguage['dir'] . ".php";
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
			$file = $this->cms->bPath . "../non_html/modules/" . $this->moduledir . "/locale/" . $this->cms->languages->defaultlanguage['dir'] . ".php";
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
	 * checks if title exists in db
	 *
	 * @param string $inttitle
	 * @param int $parentid
	 * @return boolean
	 */
	private function titleExists ($inttitle, $parentid, $mode='plugin', $ext='.cnt')
	{
		if (isset($this->inttitle[$parentid][$inttitle]))
		{
			$checktitle = $inttitle . "_" . $this->inttitle[$parentid][$inttitle];
		}
		else
		{
			$checktitle = $inttitle;
		}
		if ($mode == 'dir')
		{
			$QE = $this->cms->connection->query("SELECT id FROM " . TAB_CNT_STRUCTURE . " WHERE id_parent = " . intval($parentid) . " AND int_title = '" . $this->cms->connection->escape_string($checktitle) . "'");
		}
		else
		{
			$QE = $this->cms->connection->query("SELECT id FROM " . TAB_CNT_STRUCTURE . " WHERE id_parent = " . intval($parentid) . " AND int_title = '" . $this->cms->connection->escape_string($checktitle) . $ext . "'");
		}
		if ($this->cms->connection->num_rows($QE) == "0")
		{
			return (false);
		}
		else
		{
			if (isset($this->inttitle[$parentid][$inttitle]))
			{
				$this->inttitle[$parentid][$inttitle]++;
			}
			else
			{
				$this->inttitle[$parentid][$inttitle] = 1;
			}
			return (true);
		}
	}
	/**
	 * creates a new title if necessary 
	 *
	 * @param string $inttitle
	 * @param int $parentid
	 * @return string
	 */
	private function checkTitle ($inttitle, $parentid)
	{
		$title = $inttitle;
		if ($title == 'int')
		{
			$title = "_" . $title;
		}
		while ($this->titleExists($inttitle, $parentid))
		{
			$title = $inttitle . "_" . $this->inttitle[$parentid][$inttitle];
		}
		
		return ($title);
	}
	/**
	 * remove crap from title
	 *
	 * @param string $title
	 * @return string
	 */
	private function processTitle ($title)
	{
		$title = trim($title);
		$title = strip_tags($title);
		$title = stripslashes($title);
		$title = str_replace(" ", "_", $title);
		$title = str_replace(":", "", $title);
		$title = str_replace("'", "", $title);
		$title = str_replace('"', "", $title);
		$title = str_replace("?", "", $title);
		$title = str_replace("!", "", $title);
		$title = str_replace("\\", "", $title);
		$title = str_replace("<", "", $title);
		$title = str_replace(">", "", $title);
		$title = str_replace(",", "", $title);
		$title = str_replace("}", "", $title);
		$title = str_replace("{", "", $title);
		$title = str_replace("@", "", $title);
		$title = str_replace("#", "", $title);
		$title = str_replace("%", "", $title);
		$title = str_replace("^", "", $title);
		$title = str_replace("&", "", $title);
		$title = str_replace("*", "", $title);
		$title = str_replace("(", "", $title);
		$title = str_replace(")", "", $title);
		$title = str_replace("±", "", $title);
		$title = str_replace("¤", "", $title);
		$title = str_replace("`", "", $title);
		$title = str_replace("«", "", $title);
		$title = str_replace("#", "", $title);
		$title = str_replace("=", "", $title);
		$title = str_replace("+", "", $title);
		$title = str_replace(";", "", $title);
		$title = str_replace("£", "", $title);
		$title = str_replace("Û", "", $title);
		$title = str_replace("$", "", $title);
		return ($title);
	}
	/**
	 * retrieve item from DB
	 *
	 * @param int $id
	 * @return array
	 */
	public function getItem ($id)
	{
		if (isset($this->itemcacheid[$id]) and $this->itemcaching == true)
		{
			return ($this->itemcacheid[$id]);
		}
		else 
		{
			// item not cached, retrieving item from db
			if ($id == 0)
			{
		 		// root path, if no entry is present, entry will be created
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
				}
				else 
				{
					$item = $this->cms->connection->fetch_assoc($QE);
					$item['id'] = 0;
				}
				$this->itemcacheid[0] = $item;
			}
			else
			{
				// normal item
				$QE = $this->cms->connection->query("SELECT * FROM " . TAB_CNT_STRUCTURE . " WHERE id = " . intval($id));
				$item = $this->cms->connection->fetch_assoc($QE);
				$this->itemcacheid[$id] = $item;
			}
		}
		return ($item);
	}
	/**
	 * retrieve the item data by path
	 *
	 * @param string $path
	 * @return array
	 */
	public function getItemByPath ($path)
	{
		if (isset($this->itemcachepath[$path]) and $this->itemcaching == true)
		{
			return ($this->itemcachepath[$path]);
		} else
		{
			if ($path == "/")
			{
				$item['id'] = 0;
				$item['full_title'] = '/';
				$item['full_location'] = '/';
				$item['str_type'] = 'dir';	
				$item['dir_indexes'] = 'true';	
				$item['str_plugin'] = "";
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
					$this->itemcachepath[$path] = $item;
				}
			}
			return ($item);
		}
	}
	/**
	 * get all children of an item by path
	 *
	 * @param string $path
	 * @param string $type
	 * @return array
	 */
	public function getItemsByPath ($path='/', $type='all', $plugin='')
	{
		$item = $this->getItemByPath ($path);
		// non existant item
		if (!isset($item['id']))
		{
			return (array());
		}
		// item exists
		// first check if a plugin is demanded
		if (empty($plugin))
		{
			$plugin = '';
		}
		else
		{
			$plugin = " AND str_plugin = '" . $this->cms->connection->escape_string($plugin) . "'";
		}
		switch ($type)
		{
			case 'plugin':
				$res = $this->cms->connection->fetch_multiarray("SELECT * FROM " . TAB_CNT_STRUCTURE . " WHERE id_parent = '" . $item['id'] . "' AND str_type = 'plugin' " . $plugin . " ORDER BY sortorder ASC");
				return ($res);
			break;
			case 'dir':
				$res = $this->cms->connection->fetch_multiarray("SELECT * FROM " . TAB_CNT_STRUCTURE . " WHERE id_parent = '" . $item['id'] . "' AND str_type = 'dir' " . $plugin . " ORDER BY sortorder ASC");
				return ($res);
			break;
			default:
				$res = $this->cms->connection->fetch_multiarray("SELECT * FROM " . TAB_CNT_STRUCTURE . " WHERE id_parent = '" . $item['id'] . "' " . $plugin . " ORDER BY sortorder ASC");
				return ($res);
			break;
		}
	}
	/**
	 * retrieves all items that start with a path
	 *
	 * @param string $path
	 * @param string $type
	 * @return array
	 */
	public function getAllItems ($path='/', $type='all')
	{
		switch ($type)
		{
			case 'plugin':
				$res = $this->cms->connection->fetch_multiarray("SELECT * FROM " . TAB_CNT_STRUCTURE . " WHERE full_location LIKE '" . $this->cms->connection->escape_string($path) . "%' AND str_type = 'plugin' ORDER BY sortorder ASC");
				return ($res);
			break;
			case 'dir':
				$res = $this->cms->connection->fetch_multiarray("SELECT * FROM " . TAB_CNT_STRUCTURE . " WHERE full_location LIKE '" . $this->cms->connection->escape_string($path) . "%'  AND str_type = 'dir' ORDER BY sortorder ASC");
				return ($res);
			break;
			default:
				$res = $this->cms->connection->fetch_multiarray("SELECT * FROM " . TAB_CNT_STRUCTURE . " WHERE full_location LIKE '" . $this->cms->connection->escape_string($path) . "%'  ORDER BY sortorder ASC");
				return ($res);
			break;
		}
	}
	/**
	 * get item list by parent id
	 *
	 * @param int $parentid
	 * @return array
	 */
	public function getItems ($parentid, $type='all')
	{
		switch ($type)
		{
			case 'plugin':
				$res = $this->cms->connection->fetch_multiarray("SELECT * FROM " . TAB_CNT_STRUCTURE . " WHERE id_parent = " . intval($parentid) . " AND str_type = 'plugin' ORDER BY sortorder ASC");
				return ($res);
			break;
			case 'dir':
				$res = $this->cms->connection->fetch_multiarray("SELECT * FROM " . TAB_CNT_STRUCTURE . " WHERE id_parent = " . intval($parentid) . " AND str_type = 'dir' ORDER BY sortorder ASC");
				return ($res);
			break;
			default:
				$res = $this->cms->connection->fetch_multiarray("SELECT * FROM " . TAB_CNT_STRUCTURE . " WHERE id_parent = " . intval($parentid) . " ORDER BY sortorder ASC");
				return ($res);
			break;
		}

	}
	/**
	 * create new dir
	 *
	 * @param string $title
	 * @param int $parentid
	 * @param array $visfrom
	 * @param array $visto
	 * @param unknown_type $visuse
	 * @param unknown_type $excludefromnav
	 */
	private function newDirectory ($title, $parentid, $excludefromnav, $showindexes, $visibledate, $visiblefrom, $visibleto, $visibleguest, $visiblegroups)
	{
		$item = $this->getItem($parentid);
		if (empty($title) OR !isset($item['id']))
		{
			throw new Exception('Erroneous input for new directory');
		}
		
		$visfrom = $visiblefrom['Date_Year'] . "-" . $visiblefrom['Date_Month'] . "-" . $visiblefrom['Date_Day'] . " 00:00:00";
		$visto = $visibleto['Date_Year'] . "-" . $visibleto['Date_Month'] . "-" . $visibleto['Date_Day'] . " 00:00:00";
		
		// process title
		$inttitle = $this->checkTitle($this->processTitle($title), $parentid);
		if ($item['full_location'] == '/')
		{
			$fullpath = "/" . $inttitle;
		}
		else
		{
			$fullpath = $item['full_location'] . "/" . $inttitle;
		}
		
		// check sortorder
		$QE = $this->cms->connection->query("SELECT sortorder FROM `" . TAB_CNT_STRUCTURE . "` WHERE id_parent = '" . intval($item['id']) .  "' ORDER BY sortorder DESC LIMIT 0,1");
		$res = $this->cms->connection->fetch_assoc($QE);
		if (isset($res['sortorder']))
		{
			$sortorder = intval($res['sortorder']) + 1;
		}
		else
		{
			$sortorder = 1;
		}
	
		// check visgroups
		if (isset($visiblegroups[0]))
		{
			$visgroups = implode(',', $visiblegroups);
		}
		else
		{
			$visgroups = '';
		}
		
		$this->cms->connection->query("
		INSERT INTO " . TAB_CNT_STRUCTURE . "
		(id, id_parent, full_location, full_title, int_title, user_author, str_type, str_plugin, visible_from, visible_to, visible_date, excludefromnav, visible_guest, visible_group, dir_indexes, tags, sortorder)
		VALUES
		(
		null,
		" . intval($parentid) . ",
		'" . $this->cms->connection->escape_string($fullpath) . "',
		'" . $this->cms->connection->escape_string($title) . "',
		'" . $this->cms->connection->escape_string($inttitle) . "',
		" . intval($this->cms->user->uid) . ",
		'dir', 
		'',
		'" . $this->cms->connection->escape_string($visfrom) . "',
		'" . $this->cms->connection->escape_string($visto) . "',
		'" . $this->cms->connection->escape_string($visibledate) . "',
		'" . $this->cms->connection->escape_string($excludefromnav) . "',
		'" . $this->cms->connection->escape_string($visibleguest) . "',
		'" . $this->cms->connection->escape_string($visgroups) . "',
		'" . $this->cms->connection->escape_string($showindexes) . "',
	    '',
	    " . intval($sortorder) . ")
		");
		// return new id for plugin
		return ($this->cms->connection->insert_id());
	}
	/**
	 * Adds an item to the database
	 *
	 * @param string $title
	 * @param int $parentid
	 * @param string $excludefromnav
	 * @param array $visibledate
	 * @param array $visiblefrom
	 * @param string $visibleto
	 * @param string $visibleguest
	 * @param array $visiblegroups
	 * @param string $tags
	 * @param string $plugin
	 * @return int
	 */
	public function newItem ($title, $parentid, $desc, $thumbnail, $excludefromnav, $visibledate, $visiblefrom, $visibleto, $visibleguest, $visiblegroups, $tags, $plugin)
	{
		// get parent item
		$item = $this->getItem($parentid);
		// no parent, no show
		if (!isset($item['id']))
		{
			throw new Exception ("Erroneous data for new item");
		}
		
		// file extension
		$pl = $this->loadPlugin($plugin, 'new');
		$ext = $pl->getExtension();
		
		// process title
		$inttitle = $this->checkTitle($this->processTitle(trim($title)), $parentid, 'plugin', $ext) . $ext;
		if ($item['full_location'] == '/')
		{
			$fullpath = "/" . $inttitle;
		}
		else
		{
			$fullpath = $item['full_location'] . "/" . $inttitle;
		}
		$visfrom = $visiblefrom['Date_Year'] . "-" . $visiblefrom['Date_Month'] . "-" . $visiblefrom['Date_Day'] . " 00:00:00";
		$visto = $visibleto['Date_Year'] . "-" . $visibleto['Date_Month'] . "-" . $visibleto['Date_Day'] . " 00:00:00";
		
		// check visgroups
		if (isset($visiblegroups[0]))
		{
			$visgroups = implode(',', $visiblegroups);
		}
		else
		{
			$visgroups = '';
		}
		
		// check sortorder
		$QE = $this->cms->connection->query("SELECT sortorder FROM `" . TAB_CNT_STRUCTURE . "` WHERE id_parent = '" . intval($item['id']) .  "' ORDER BY sortorder DESC LIMIT 0,1");
		$res = $this->cms->connection->fetch_assoc($QE);
		if (isset($res['sortorder']))
		{
			$sortorder = intval($res['sortorder']) + 1;
		}
		else
		{
			$sortorder = 1;
		}
		
		// all ok, start SQL now
		$this->cms->connection->query("
		INSERT INTO " . TAB_CNT_STRUCTURE . "
		(id, id_parent, full_location, full_title, int_title, description, thumbnail, user_author, str_type, str_plugin, visible_from, visible_to, visible_date, excludefromnav, visible_guest, visible_group, tags, sortorder)
		VALUES
		(
		null,
		" . intval($parentid) . ",
		'" . $this->cms->connection->escape_string($fullpath) . "',
		'" . trim($this->cms->connection->escape_string($title)) . "',
		'" . $this->cms->connection->escape_string($inttitle) . "',
		'" . $this->cms->connection->escape_string($desc) . "',
		'" . $this->cms->connection->escape_string($thumbnail) . "',
		" . intval($this->cms->user->uid) . ",
		'plugin', 
		'" . $this->cms->connection->escape_string($plugin) . "',
		'" . $this->cms->connection->escape_string($visfrom) . "',
		'" . $this->cms->connection->escape_string($visto) . "',
		'" . $this->cms->connection->escape_string($visibledate) . "',
		'" . $this->cms->connection->escape_string($excludefromnav) . "',
		'" . $this->cms->connection->escape_string($visibleguest) . "',
		'" . $this->cms->connection->escape_string($visgroups) . "',
	    '" . $this->cms->connection->escape_string($tags) . "',
	    " . intval($sortorder) . ")
		");
		// return new id for plugin
		return ($this->cms->connection->insert_id());
	}
	private function editItem ($id, $title, $desc, $thumbnail, $excludefromnav, $visibledate, $visiblefrom, $visibleto, $visibleguest, $visiblegroups, $tags)
	{
		$visfrom = $visiblefrom['Date_Year'] . "-" . $visiblefrom['Date_Month'] . "-" . $visiblefrom['Date_Day'] . " 00:00:00";
		$visto = $visibleto['Date_Year'] . "-" . $visibleto['Date_Month'] . "-" . $visibleto['Date_Day'] . " 00:00:00";
		
		// check visgroups
		if (isset($visiblegroups[0]))
		{
			$visgroups = implode(',', $visiblegroups);
		}
		else
		{
			$visgroups = '';
		}
		
		$this->cms->connection->query("UPDATE " . TAB_CNT_STRUCTURE . " SET 
		full_title = '" . trim($this->cms->connection->escape_string($title)) . "',
		description = '" . trim($this->cms->connection->escape_string($desc)) . "',
		thumbnail = '" . trim($this->cms->connection->escape_string($thumbnail)) . "',
		visible_from = '" . $this->cms->connection->escape_string($visfrom) . "',
		visible_to = '" . $this->cms->connection->escape_string($visto) . "',
		visible_date = '" . $this->cms->connection->escape_string($visibledate) . "',
		excludefromnav = '" . $this->cms->connection->escape_string($excludefromnav) . "',
		visible_guest = '" . $this->cms->connection->escape_string($visibleguest) . "',
		visible_group = '" . $this->cms->connection->escape_string($visgroups) . "',
		tags = '" . trim($this->cms->connection->escape_string(trim($tags))) . "'		
		WHERE id = " . intval($id));
		
	}
	private function editDir ($id, $title, $excludefromnav, $visibledate, $visiblefrom, $visibleto, $visibleguest, $visiblegroups, $indexes, $indexfile)
	{
		$visfrom = $visiblefrom['Date_Year'] . "-" . $visiblefrom['Date_Month'] . "-" . $visiblefrom['Date_Day'] . " 00:00:00";
		$visto = $visibleto['Date_Year'] . "-" . $visibleto['Date_Month'] . "-" . $visibleto['Date_Day'] . " 00:00:00";
		
		// check visgroups
		if (isset($visiblegroups[0]))
		{
			$visgroups = implode(',', $visiblegroups);
		}
		else
		{
			$visgroups = '';
		}
		
		if ($id == 0)
		{
			$where = " WHERE full_location = '/'";
		}
		else 
		{
			$where = "WHERE id = " . intval($id);
		}
		$this->cms->connection->query("UPDATE " . TAB_CNT_STRUCTURE . " SET 
		full_title = '" . trim($this->cms->connection->escape_string($title)) . "',
		visible_from = '" . $this->cms->connection->escape_string($visfrom) . "',
		visible_to = '" . $this->cms->connection->escape_string($visto) . "',
		visible_date = '" . $this->cms->connection->escape_string($visibledate) . "',
		excludefromnav = '" . $this->cms->connection->escape_string($excludefromnav) . "',
		visible_guest = '" . $this->cms->connection->escape_string($visibleguest) . "',
		visible_group = '" . $this->cms->connection->escape_string($visgroups) . "',
		dir_indexes = '" . $this->cms->connection->escape_string($indexes) . "',
		dir_indexfile = '" . intval($indexfile) . "' " . $where);	
	}
	/**
	 * delete an item
	 *
	 * @param int $id
	 */
	private function deleteItem ($id)
	{
		$item = $this->getItem($id);
		if (!isset($item['id']))
		{
			throw new Exception ('Erroneous input data');
		}
		if ($item['str_type'] == 'plugin')
		{
			$this->deleteItemPlugin($item['str_plugin'], $id);
		}
		else
		{
			if ($item['full_location'] != '/' OR $item['full_location'] != '')
			{
				// fetch all plugins, delete them.
				$QE = $this->cms->connection->query("SELECT str_plugin, id FROM " . TAB_CNT_STRUCTURE . " WHERE full_location LIKE '" . $item['full_location'] . "/%'" );
				while ($res = $this->cms->connection->fetch_assoc($QE))
				{
					$this->deleteItemPlugin($res['str_plugin'], $res['id']);
				}
				// delete remaining parts
				$this->cms->connection->query("DELETE FROM " . TAB_CNT_STRUCTURE . " WHERE full_location LIKE '" . $item['full_location'] . "/%'" );
			}
		}
		// delete the item
		$this->cms->connection->query("DELETE FROM " . TAB_CNT_STRUCTURE . " WHERE id = " . intval($id));
		// update sortorder
		$this->cms->connection->query("UPDATE " . TAB_CNT_STRUCTURE . " SET sortorder = sortorder - 1 WHERE id_parent = " . intval($item['id_parent']) . " AND sortorder > " . intval($item['sortorder']));
	}
	/**
	 * move item to a new directory
	 *
	 * @param int $id
	 * @param int $to
	 */
	private function moveItem ($id, $to)
	{
		$item = $this->getItem($id);
		$new = $this->getItem($to);
		if (isset($new['id']) AND $new['str_type'] == 'dir')
		{
			if ($item['id_parent'] != $to)
			{
				// check sortorder
				$QE = $this->cms->connection->query("SELECT sortorder FROM `" . TAB_CNT_STRUCTURE . "` WHERE id_parent = '" . intval($new['id']) .  "' ORDER BY sortorder DESC LIMIT 0,1");
				$res = $this->cms->connection->fetch_assoc($QE);
				if (isset($res['sortorder']))
				{
					$sortorder = intval($res['sortorder']) + 1;
				}
				else
				{
					$sortorder = 1;
				}
				// set new location
				$newlocation = $new['full_location'] . "/" . $item['int_title'];
				// move it
				$this->cms->connection->query("UPDATE " . TAB_CNT_STRUCTURE . " SET id_parent = " . intval($to) . ", sortorder = " . intval($sortorder) . ", full_location = '" . $this->cms->connection->escape_string($newlocation) . "' WHERE id = " . intval($id));
				// fix sort order of old dir
				$this->cms->connection->query("UPDATE " . TAB_CNT_STRUCTURE . " SET sortorder = sortorder - 1 WHERE id_parent = " . intval($item['id_parent']) . " AND sortorder > " . intval($item['sortorder']));
			
			}
		}
		else
		{
			throw new Exception('Erroneous ID for moving item to.');
		}
	}
	/**
	 * move item sort order up by 1
	 *
	 * @param int $itemid
	 */
	private function moveItemUp ($itemid)
	{
		$item = $this->getItem($itemid);
		if ($item['sortorder'] > 1)
		{
			$QE = $this->cms->connection->query("SELECT id FROM " . TAB_CNT_STRUCTURE . " WHERE sortorder = " . ($item['sortorder'] - 1) . " AND id_parent = " . intval($item['id_parent']));
			$res = $this->cms->connection->fetch_assoc($QE);
					
			$this->cms->connection->query("UPDATE " . TAB_CNT_STRUCTURE . " SET sortorder = sortorder - 1 WHERE id = "  . intval($itemid));
			$this->cms->connection->query("UPDATE " . TAB_CNT_STRUCTURE . " SET sortorder = sortorder + 1 WHERE id = "  . intval($res['id']));
		}
	}
	/**
	 * move item sort order down by 1
	 *
	 * @param int $itemid
	 */
	private function moveItemDown ($itemid)
	{
		$item = $this->getItem($itemid);
		$QE = $this->cms->connection->query("SELECT count(*) AS amdec FROM " . TAB_CNT_STRUCTURE . " WHERE id_parent = " . intval($item['id_parent']));
		$res = $this->cms->connection->fetch_assoc($QE);

		if ($res['amdec'] != $item['sortorder'])
		{
			$QE = $this->cms->connection->query("SELECT id FROM " . TAB_CNT_STRUCTURE . " WHERE sortorder = " . ($item['sortorder'] + 1) . " AND id_parent = " . intval($item['id_parent']));
			$res = $this->cms->connection->fetch_assoc($QE);
			$this->cms->connection->query("UPDATE " . TAB_CNT_STRUCTURE . " SET sortorder = sortorder + 1 WHERE id = "  . intval($itemid));
			$this->cms->connection->query("UPDATE " . TAB_CNT_STRUCTURE . " SET sortorder = sortorder - 1 WHERE id = "  . intval($res['id']));
		}
	}
	/**
	 * create bread crumb bar
	 *
	 * @param string $path
	 * @return array
	 */
	private function createBreadCrumbs ($path)
	{
		$br[] = array('title' => $this->lang['root'], 'link' => admin::generateLink('m', array('module' => 'content')));
		
		$b = explode ('/', $path);
		$prev = "";
		foreach ($b AS $p)
		{
			if (!empty($p))
			{
				$prev .= "+" . $p;
				$br[] = array('title' => str_replace("_", " ", $p), 'link' => admin::generateLink('m', array('module' => 'content', 'action' => 'showlocation', 'location' => substr($prev, 1))));
			}
		}
		if (count($br) > 5)
		{
			$brn[] = $br[0];
			$brn[] = $br[1];
			$brn[] = array('title' => '...', 'link' => '');
			$brn[] = $br[(count($br) -2)];
			$brn[] = $br[(count($br) -1)];
			$br = $brn;
		}
		
		return ($br);
	}
	/**
	 * ----------
	 * PLUGIN PART
	 * ----------
	 */
	/**
	 * delete an instance of a plugin related to an item
	 *
	 * @param unknown_type $plugin
	 * @param unknown_type $id
	 */
	private function deleteItemPlugin($plugin, $id)
	{
		if (!empty($plugin))
		{
			$pltitle = "cAPlugin_" . $plugin;
			if (class_exists($pltitle))
			{
				$plugin = new $pltitle($this->cms, $id, $this);
				$plugin->delete();
			}
			else
			{
				throw new Exception ("Can not delete Item->Plugin, Plugin admin not found.");
			}
		}
	}	
	/**
	 * get plugins and adds language stuff
	 *
	 * @return array
	 */
	private function getPlugins ()
	{
		$plugins = array();
		// check plugins in the directory
		$plugindir = realpath($this->cms->bPath . "../non_html/modules/" . $this->moduledir . "/plugins/") . "/";
		
		if (is_dir($plugindir) AND $dh = opendir($plugindir))
	 	{
			while (($file = readdir($dh)) !== false) 
        	{
        		if (substr($file, 0, 8) == "cplugin.")
        		{
        			$p['type'] = substr($file, 8, -4);
        			if (isset($this->lang['pluginmenu'][$p['type']]))
        			{
        				$p['title'] = $this->lang['pluginmenu'][$p['type']]['title'];
        				$p['group'] = $this->lang['pluginmenu'][$p['type']]['group'];
        				$p['new'] = $this->lang['pluginmenu'][$p['type']]['new'];
        				$p['save'] = $this->lang['pluginmenu'][$p['type']]['save'];
        			}
        			else
        			{
        				$p['title'] = $p['type'];
        				$p['group'] = 'none';
        				$p['new'] = "New " . $p['type'];
        				$p['save'] = "New " . $p['save'];
        			}
        			// get the groups right
        			$plugins[$p['group']]['items'][] = $p;
        			$plugins[$p['group']]['name'] = $p['group'];
        			$plugins[$p['group']]['title'] = $p['group'];
        			if (isset($this->lang['plugingroups'][$p['group']]))
        			{
        				$plugins[$p['group']]['title'] = $this->lang['plugingroups'][$p['group']];
        			}
        			
        		}
        	}
        	closedir($dh);
	 	}
		return ($plugins);
	}
	/**
	 * returns plugin path
	 *
	 * @param string $plugin
	 * @return string
	 */
	private function pluginPath ($plugin)
	{
		$plugin = str_replace(".", "", $plugin);
		$plugin = str_replace("\\", "", $plugin);
		$plugin = str_replace(":", "", $plugin);
		$plugin = str_replace("?", "", $plugin);
		$plugin = str_replace(",", "", $plugin);
		return ($this->cms->bPath . "../non_html/modules/" . $this->moduledir . "/plugins/cplugin." . strip_tags($plugin) . ".php");
	}
	/**
	 * shows the form for a new plugin on an item
	 *
	 * @param unknown_type $plugin
	 */
	private function getPluginForm ($plugin, $id='new')
	{
		$pl = $this->loadPlugin($plugin, $id);	
		$form = $pl->getForm();
		return ($form);
		
	}
	/**
	 * load a plugin
	 *
	 * @param string $plugin
	 * @param int $id
	 * @return plugin
	 */
	private function loadPlugin ($plugin, $id)
	{
		$pltitle = "cAPlugin_" . $plugin;
		if (class_exists($pltitle))
		{
			$pl = new $pltitle($this->cms, $id, $this);
			return ($pl);
		}
		else 
		{
			throw new Exception("Illegal plugin loaded for content admin module. Plugin does not contain admin handler.");
		}
	}
	/**
	 * ----------
	 * VISUAL PART
	 * ----------
	 */
	/**
	 * show delete form
	 *
	 * @param int $id
	 * @return string
	 */
	private function showDeleteItem ($id)
	{
		// fetching some info
		$item = $this->getItem($id);
		if (!isset($item['id']) OR $id == 0)
		{
			throw new Exception ('Content delete: Erroneous ID supplied');
		}
		
		// page title
		$this->cms->pageTitle = $item['full_title'];
		
		// template
		$delete = new Smarty();
		$delete->template_dir = $this->cms->bPath . "../non_html/modules/" . $this->moduledir . "/templates/admin";
		$delete->compile_dir = $this->cms->templates->compileddir;
		$delete->assign('lang', $this->cms->languages->lang);
		$delete->assign('mlang', $this->lang);
		$delete->assign('item', $item);
		$delete->assign('breadcrumbs', $this->createBreadCrumbs($item['full_location']));
		$delete->assign('baseurl', BASE_URL);
		return ($delete->fetch('delete.tpl'));
	}
	/**
	 * show the form to add a directory
	 *
	 * @param int $id
	 * @return string
	 */
	private function showAddDir ($id)
	{
		// fetching some info
		$item = $this->getItem($id);
		$groups = $this->cms->users->getGroups();
		if (!isset($item['id']))
		{
			throw new Exception ('Illegal ID');
		}
		
		// page title
		$this->cms->pageTitle = $item['full_title'];
		
		
		// template
		$directory = new Smarty();
		$directory->template_dir = $this->cms->bPath . "../non_html/modules/" . $this->moduledir . "/templates/admin";
		$directory->compile_dir = $this->cms->templates->compileddir;
		$directory->assign('lang', $this->cms->languages->lang);
		$directory->assign('mlang', $this->lang);
		$directory->assign('baseurl', BASE_URL);
		$directory->assign('item', $item);
		$directory->assign('groups', $groups);
		$directory->assign('items', $this->getItems($id, 'plugin'));
		$directory->assign('breadcrumbs', $this->createBreadCrumbs($item['full_location']));
		return ($directory->fetch('newdir.tpl'));
		
	}
	/**
	 * show a new item form based on a plugin
	 *
	 * @param int $id
	 * @param string $plugin
	 * @return string
	 */
	private function showNewItem ($id, $plugin)
	{
		$item = $this->getItem($id);
		$this->currentparentid = $id;
		// initial checks
		if (!isset($item['full_title']))
		{
			throw new Exception ('Illegal ID');
		}
		if (!is_file($this->pluginPath($plugin)))
		{
			throw new Exception ('Plugin not found');
		}
		//template
		$newitem = new Smarty();
		$newitem->template_dir = $this->cms->bPath . "../non_html/modules/" . $this->moduledir . "/templates/admin";
		$newitem->compile_dir = $this->cms->templates->compileddir;
		
		//languagestuff
		$newitem->assign('lang', $this->cms->languages->lang);
		$newitem->assign('mlang', $this->lang);
		if (isset($this->lang['pluginmenu'][$plugin]))
		{
			// page title
			$this->cms->pageTitle = $this->lang['pluginmenu'][$plugin]['new'];
			$newitem->assign('title', $this->lang['pluginmenu'][$plugin]['new']);
			$newitem->assign('save', $this->lang['pluginmenu'][$plugin]['save']);
		}
		else 
		{
			// page title
			$this->cms->pageTitle = $this->lang['newitem'];
			$newitem->assign('title', $this->lang['newitem']);
			$newitem->assign('save', $this->lang['newitem']);
		}
		// get needed data
		$nplugin = $this->loadPlugin($plugin, 'new');
		$pluginform = $nplugin->getForm();
		if (isset($nplugin->rExtra) AND $nplugin->rExtra)
		{
			$pluginextra = $nplugin->getExtra();
		}
		else 
		{
			$pluginextra = '';
		}
		$ogroups = $this->cms->users->getGroups();
		$groups = array();
		// reprocess groups, to check if they are already checked
		$gchecked = explode(',', $item['visible_group']);
		foreach ($ogroups AS $group)
		{
			if (in_array($group['id'], $gchecked))
			{
				$group['checked'] = 'true';
			}
			else 
			{
				$group['checked'] = 'false';
			}
			$groups[] = $group;
		}
		// data assigns
		$newitem->assign('pluginform', $pluginform);
		$newitem->assign('pluginextra', $pluginextra);
		$newitem->assign('item', $item);
		$newitem->assign('groups', $groups);
		$newitem->assign('plugin', $plugin);
		$newitem->assign('id', $id);
		$newitem->assign('baseurl', BASE_URL);
		$newitem->assign('breadcrumbs', $this->createBreadCrumbs($item['full_location']));
		return ($newitem->fetch('newitem.tpl'));
	}
	/**
	 * shows the contents of a directory
	 *
	 * @param int $id
	 * @return string
	 */
	private function showDirectory ($id)
	{
		$item = $this->getItem($id);
		if (!isset($item['id']))
		{
			throw new Exception("Directory not found");
		}
		
		// page title
		$this->cms->pageTitle = $item['full_title'];
		
		// template
		$directory = new Smarty();
		$directory->template_dir = $this->cms->bPath . "../non_html/modules/" . $this->moduledir . "/templates/admin";
		$directory->compile_dir = $this->cms->templates->compileddir;
		$directory->assign('lang', $this->cms->languages->lang);
		$directory->assign('mlang', $this->lang);
		$directory->assign('baseurl', BASE_URL);
		
		// breadcrumbs, show the nice bar
		$directory->assign('breadcrumbs', $this->createBreadCrumbs($item['full_location']));
		
		// assign a url for editing the directory
		$directory->assign('direditlink', admin::generateLink('m', array('module' => 'content', 'action' => 'editdir', 'id' => $item['id'])));
		
		
		// fetch some data
		
		$directory->assign('directory', $item);
		$items = $this->getItems($id);
		$nitems = array();
		// process items, add links to the array
		foreach ($items AS $fitem)
		{
			if ($fitem['str_type'] == 'dir')
			{
				$fitem['link'] = admin::generateLink('m', array('module' => 'content', 'action' => 'dir', 'id' => $fitem['id']));
				$fitem['link_editdir'] = admin::generateLink('m', array('module' => 'content', 'action' => 'editdir', 'id' => $fitem['id']));
			}
			else
			{
				$fitem['link'] = admin::generateLink('m', array('module' => 'content', 'action' => 'item', 'id' => $fitem['id']));
			}
			$fitem['link_move'] = admin::generateLink('m', array('module' => 'content', 'action' => 'move', 'id' => $fitem['id']));
			$fitem['link_moveup'] = admin::generateLink('m', array('module' => 'content', 'action' => 'moveup', 'id' => $fitem['id']));
			$fitem['link_movedown'] = admin::generateLink('m', array('module' => 'content', 'action' => 'movedown', 'id' => $fitem['id']));
			$fitem['link_delete'] = admin::generateLink('m', array('module' => 'content', 'action' => 'delete', 'id' => $fitem['id']));
			
			$nitems[] = $fitem;
		}
		$directory->assign('items', $nitems);
		$directory->assign('plugins', $this->getPlugins());
		return ($directory->fetch('directory.tpl'));
	}
	private function showItem ($id)
	{
		// fetch some data
		$item = $this->getItem($id);
		
		if (!isset($item['id']))
		{
			throw new Exception('Erroneous input. Item does not exist.');	
		}
		
		// page title
		$this->cms->pageTitle = $item['full_title'];
		
		// template
		$edititem = new Smarty();
		$edititem->template_dir = $this->cms->bPath . "../non_html/modules/" . $this->moduledir . "/templates/admin";
		$edititem->compile_dir = $this->cms->templates->compileddir;
		
		// language stuff
		$edititem->assign('lang', $this->cms->languages->lang);
		$edititem->assign('mlang', $this->lang);
		$edititem->assign('baseurl', BASE_URL);
		
		// get needed data
		$pluginform = $this->getPluginForm($item['str_plugin'], intval($id));
		$ogroups = $this->cms->users->getGroups();
		$groups = array();
		
		// reprocess groups, to check if they are already checked
		$gchecked = explode(',', $item['visible_group']);
		foreach ($ogroups AS $group)
		{
			if (in_array($group['id'], $gchecked))
			{
				$group['checked'] = 'true';
			}
			else 
			{
				$group['checked'] = 'false';
			}
			$groups[] = $group;
		}
		
		// assign stuff
		$edititem->assign('item', $item);
		$edititem->assign('groups', $groups);
		$edititem->assign('pluginform', $pluginform);
		$edititem->assign('breadcrumbs', $this->createBreadCrumbs($item['full_location']));
		return ($edititem->fetch('edititem.tpl'));	
	}
	/**
	 * edit directory settings
	 *
	 * @param int $id
	 * @return string
	 */
	public function showEditDirectory ($id)
	{
		// fetch some data
		$item = $this->getItem($id);
		if (!isset($item['id']))
		{
			throw new Exception('Erroneous input. Item does not exist.');	
		}
				
		// template
		$edititem = new Smarty();
		$edititem->template_dir = $this->cms->bPath . "../non_html/modules/" . $this->moduledir . "/templates/admin";
		$edititem->compile_dir = $this->cms->templates->compileddir;
		
		// language stuff
		$edititem->assign('lang', $this->cms->languages->lang);
		$edititem->assign('mlang', $this->lang);
		$edititem->assign('baseurl', BASE_URL);

		// fetching items for index
		$indexes = $this->getItems($id, 'plugin');
		$nindexes = array();
		foreach ($indexes AS $index)
		{
			if ($index['id'] == $item['dir_indexfile'])
			{
				$index['checked'] = 'true';
			}
			$nindexes[] = $index;
		}
		$edititem->assign('indexfiles', $nindexes);
		
		// get needed data
		$ogroups = $this->cms->users->getGroups();
		$groups = array();
		
		// reprocess groups, to check if they are already checked
		$gchecked = explode(',', $item['visible_group']);
		foreach ($ogroups AS $group)
		{
			if (in_array($group['id'], $gchecked))
			{
				$group['checked'] = 'true';
			}
			else 
			{
				$group['checked'] = 'false';
			}
			$groups[] = $group;
		}
		// assign stuff
		$edititem->assign('item', $item);
		$edititem->assign('groups', $groups);
		$edititem->assign('breadcrumbs', $this->createBreadCrumbs($item['full_location']));
		return ($edititem->fetch('editdirectory.tpl'));	
	}
	/**
	 * move item
	 *
	 * @param int $id
	 * @return string
	 */
	public function showMoveItem ($id)
	{
		// fetch some data
		$item = $this->getItem($id);
		if (!isset($item['id']))
		{
			throw new Exception('Erroneous input. Item does not exist.');	
		}
		
		// page title
		$this->cms->pageTitle = $item['full_title'];
		
		// template
		$moveitem = new Smarty();
		$moveitem->template_dir = $this->cms->bPath . "../non_html/modules/" . $this->moduledir . "/templates/admin";
		$moveitem->compile_dir = $this->cms->templates->compileddir;
		
		// language stuff
		$moveitem->assign('lang', $this->cms->languages->lang);
		$moveitem->assign('mlang', $this->lang);
		$moveitem->assign('baseurl', BASE_URL);
		
		// get and assign target
		$moveto = $this->getAllItems('/', 'dir');
		$mvnew = array();
		foreach ($moveto AS $mv)
		{
			if ($mv['full_location'] == '/')
			{
				$mv['id'] = 0;
			}
			$mvnew[] = $mv;
		}
		$moveitem->assign('moveto', $mvnew);
		
		// assign stuff
		$moveitem->assign('item', $item);
		$moveitem->assign('breadcrumbs', $this->createBreadCrumbs($item['full_location']));
		return ($moveitem->fetch('moveitem.tpl'));	
	}
	/**
	 * fckeditor stuff
	 */
	private function fckEConfig ()
	{
		$fckconfig = new Smarty();
		$fckconfig->template_dir = $this->cms->bPath . "../non_html/modules/" . $this->moduledir . "/templates/fckeditor";
		$fckconfig->compile_dir = $this->cms->templates->compileddir;
		$fckconfig->assign('connectorurl', admin::generateLink('m', array('module' => 'content', 'action' => 'fckconnector')));
		$fckconfig->display('fckconfig.js');
	}
	private function fckConnector ()
	{
		// Prevent the browser from caching the result.
		// Date in the past
		header('Expires: Mon, 26 Jul 1997 05:00:00 GMT') ;
		// always modified
		header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT') ;
		// HTTP/1.1
		header('Cache-Control: no-store, no-cache, must-revalidate') ;
		header('Cache-Control: post-check=0, pre-check=0', false) ;
		// HTTP/1.0
		header('Pragma: no-cache') ;
	
		// Set the response format.
		header( 'Content-Type:text/xml; charset=utf-8' ) ;
		
		/**
		 * process input data
		 */
		if (isset($_GET['Command']))
		{
			$command = $_GET['Command'];
		}
		else
		{
			$command = '';
		}
		if (isset($_GET['Type']))
		{
			$resourceType = $_GET['Type'];
		}
		else
		{
			$resourceType = '';
		}
		if (isset($_GET['CurrentFolder']))
		{
			if (substr($_GET['CurrentFolder'], -1) == "/")
			{
				$currentFolder = substr($_GET['CurrentFolder'], 0, -1);
			}
			else
			{
				$currentFolder = $_GET['CurrentFolder'];
			}
			
		}
		else 
		{
			$currentFolder = '/';
		}
		
		if (empty($currentFolder))
		{
			$currentFolder = "/";
		}
		
		
		/**
		 * all input done, let's create some output
		 */
		
		// Create the XML document header.
		echo '<?xml version="1.0" encoding="utf-8" ?>' ;
	
		// Create the main "Connector" node.
		echo '<Connector command="' . $command . '" resourceType="' . $resourceType . '">' ;
	
		// Add the current folder node.
		echo '<CurrentFolder path="' . utf8_encode(htmlspecialchars($currentFolder)) . '" url="' . utf8_encode(n30::generateLink($this->file, array('location' => $currentFolder . "/"))) . '" />' ;
		
		echo '<Folders>';
		$items = $this->getItemsByPath($currentFolder, 'dir');
		foreach ($items AS $item)
		{
			echo '<Folder name="' . $item['int_title'] . '"/>';
		}
		echo '</Folders>';
		echo '<Files>';
		switch ($resourceType)
		{
			case 'Image':
				$items = $this->getItemsByPath($currentFolder, 'plugin', 'picture');
			break;
			default:
				$items = $this->getItemsByPath($currentFolder, 'plugin');
			break;
		}
		foreach ($items AS $item)
		{
			echo '<File name="' . $item['int_title'] . '" size="4"/>';
		}
		echo '</Files>';
		echo '</Connector>';
	}
	/**
	 * show the bunch
	 *
	 * @param string $function
	 * @param array $opt
	 * @return int
	 */
	public function show ($function, $opt)
	{
		$this->cms->loadJavascript(BASE_URL . "admin/thirdparty/jquery/jquery-1.2.6.pack.js");
		$this->cms->loadJavascript(BASE_URL . "non_html/modules/content/javascript/view.js");
		switch ($function)
		{
			case '':
				return ($this->showDirectory(0));
			break;
			case 'dir':
				if (isset($opt['id']))
				{
					return ($this->showDirectory($opt['id']));
				}
			break;
			case 'moveup':
				if (isset($opt['id']))
				{
					$item = $this->getItem($opt['id']);
					if (!isset($item['id']))
					{
						throw new Exception('Requested item does not exist.');
					}
					$this->moveItemUp(intval($opt['id']));
					header ("Location: " . admin::generateLink("m", array("module" => "content", "action" => "dir", "id" => intval($item['id_parent']))));
				}
				else
				{
					throw new Exception('No ID');
				}
			break;
			case 'movedown':
				if (isset($opt['id']))
				{
					$item = $this->getItem($opt['id']);
					if (!isset($item['id']))
					{
						throw new Exception('Requested item does not exist.');
					}
					$this->moveItemDown(intval($opt['id']));
					header ("Location: " . admin::generateLink("m", array("module" => "content", "action" => "dir", "id" => intval($item['id_parent']))));
				}
				else
				{
					throw new Exception('No ID');
				}
			break;
			case 'item':
				if (isset($opt['id']))
				{
					return($this->showItem($opt['id']));
				}
			break;
			case 'showlocation':
				if (isset($opt['id']))
				{
					$path = str_replace("+", "/", $opt['id']);
					$item = $this->getItemByPath($path);
					if (isset($item['str_type']) AND $item['str_type'] == "dir")
					{
						header ("Location: " . admin::generateLink("m", array("module" => "content", "action" => "dir", "id" => intval($item['id']))));
					}
					elseif (isset($item['str_type']) AND $item['str_type'] == "plugin")
					{
						header ("Location: " . admin::generateLink("m", array("module" => "content", "action" => "item", "id" => intval($item['id']))));
					}
					else 
					{
						throw new Exception ("Erroneous input data");
					}
				}
				else
				{
					throw new Exception ('No ID');
				}
			break;
			case 'move':
				if (isset($opt['id']))
				{
					return($this->showMoveItem($opt['id']));
				}
				else 
				{
					throw new Exception ('No ID');
				}
			break;
			case 'additem':
				if (isset($opt['id']) AND isset($opt['page']))
				{
					return($this->showNewItem($opt['id'], $opt['page']));
				}
				else
				{
					throw new Exception ('No ID');
				}
			break;
			case 'adddir':
				if (isset($opt['id']))
				{
					return($this->showAddDir($opt['id']));
				}
				else
				{
					throw new Exception ('No ID');
				}
			break;
			case 'editdir':
				if (isset($opt['id']))
				{
					return ($this->showEditDirectory($opt['id']));
				}
				else
				{
					throw new Exception ('No ID');
				}	
			break;
			case 'delete':
				if (isset($opt['id']))
				{
					return ($this->showDeleteItem($opt['id']));
				}
				else
				{
					throw new Exception ('No ID');
				}
			break;
			case 'fckconnector':
				$this->cms->blockOutput();
				$this->fckConnector();
			break;
			case 'fckconfig':
				$this->cms->blockOutput();
				$this->fckEConfig();
			break;
			default:
				throw new Exception('Illegal action');
			break;
		}
	}
}
?>