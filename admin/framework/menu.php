<?php

/**
 * n30-cms admin: menu
 * version: 0.1
 * ------------------------------------------------------------------------------------
 * LICENSE
 * ------------------------------------------------------------------------------------
 * This source code is release under the BSD License.
 * This file is part of N30-CMS
 * n30-cms version 0.6
 * ------------------------------------------------------------------------------------
 * DESCRIPTION:
 * ------------------------------------------------------------------------------------
 * Language loading and management.
 * 
 * ------------------------------------------------------------------------------------
 * Author: Simon de la Court
 * 
 */
class menu
{
	private $cms;
	private $lang;
	public $menu;
	public $contexttitle;
	public function __construct ($cms, $active = "")
	{
		$this->cms = $cms;
		$this->lang = $this->cms->user->udata['lang'];
		if ($active == "")
		{
			$this->addItem('top', $this->cms->languages->lang['adminmenu']['home'], BASE_URL . "admin", 'true');
		} else
		{
			$this->addItem('top', $this->cms->languages->lang['adminmenu']['home'], BASE_URL . "admin");
		}
		$this->addBaseModules($active);
		$this->checkModules($active);
		if ($active == 'logout')
		{
			$this->addItem('top', $this->cms->languages->lang['adminmenu']['logout'], $this->cms->generateLink("user", array("logout")), 'true');
		} else
		{
			$this->addItem('top', $this->cms->languages->lang['adminmenu']['logout'], $this->cms->generateLink("user", array("logout")));
		}
	}
	/**
	 * load module into menu
	 *
	 * @param string $active
	 */
	private function addBaseModules ($active)
	{
		// first add users if possible
		if ($this->cms->rights->xstoAdm('users'))
		{
			if ($active == 'users')
			{
				$this->addItem('top', $this->cms->languages->lang['adminmenu']['users'], $this->cms->generateLink("users"), 'true');
			} else
			{
				$this->addItem('top', $this->cms->languages->lang['adminmenu']['users'], $this->cms->generateLink("users"));
			}
		}
		// first add users if possible
		if ($this->cms->rights->xstoAdm('cms'))
		{
			if ($active == 'cms')
			{
				$this->addItem('top', $this->cms->languages->lang['adminmenu']['cms'], $this->cms->generateLink("cms"), 'true');
			} else
			{
				$this->addItem('top', $this->cms->languages->lang['adminmenu']['cms'], $this->cms->generateLink("cms"));
			}
		}
	}
	/**
	 * check if module is real
	 *
	 * @param unknown_type $active
	 */
	private function checkModules ($active)
	{
		$dir = realpath($this->cms->bPath . "../non_html/modules/") . DIRECTORY_SEPARATOR;
		$menu = array();
		if (is_dir($dir))
		{
			if ($dh = opendir($dir))
			{
				while (($file = readdir($dh)) !== false)
				{
					if ($file != ".." and $file != "." and $file != "legacy" and $file != "ucontrol" and filetype($dir . $file) == 'dir' and $this->cms->rights->xstoMod($file))
					{
						if (is_file($dir . $file . DIRECTORY_SEPARATOR . "adminmenu.php"))
						{
							include $dir . $file . DIRECTORY_SEPARATOR . "adminmenu.php";
						}
					}
				}
				closedir($dh);
			}
		}
		foreach ($menu as $m)
		{
			if ($m['module'] == $active)
			{
				$this->addItem('top', $m[$this->lang], $this->cms->generateLink("m", array($m['module'])), 'true');
			} else
			{
				$this->addItem('top', $m[$this->lang], $this->cms->generateLink("m", array($m['module'])));
			}
		}
	}
	/**
	 * adds an item to the menu
	 *
	 * @param string $level
	 * @param string $title
	 * @param string $link
	 * @param string $active
	 */
	public function addItem ($level, $title, $link, $active = "false")
	{
		if (($level == 'top' or $level == 'sub' or $level == 'context') and ($active == 'false' or $active == 'true'))
		{
			$this->menu[$level][] = array('full_title' => $title , 'link' => $link , 'active' => $active);
		}
	}
	/**
	 * retrieve menu
	 *
	 * @param string $level
	 * @return array
	 */
	public function getMenu ($level)
	{
		if ($level == 'top' or $level == 'sub' or $level == 'context')
		{
			if (isset($this->menu[$level]))
			{
				return ($this->menu[$level]);
			} else
			{
				return (array());
			}
		} else
		{
			$this->cms->exceptions->addError(new Exception ("Errornous menu request"));
		}
		
	}
}
?>