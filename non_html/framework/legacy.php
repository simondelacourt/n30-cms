<?php
/**
 * n30-cms legacy
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
 * This is the legacy environment for old modules, so they can run without major
 * adjustment.
 * 
 * ------------------------------------------------------------------------------------
 * Author: Simon de la Court
 * 
 */
class legacy
{
	private $cms;
	private $asQeue;
	public $modules;
	public $classes;
	public $connection;
	public function __construct (&$cms)
	{
		$this->cms = &$cms;
		$this->classes['user'] = &$this->cms->user;
		$this->classes['base'] = new legacyBase();
		$this->classes['base']->lang = $this->cms->languages->lang;
		$this->connection = &$this->cms->connection;
		$this->classes['base']->templates = $this->cms->templates->templates['set'];
	}
	public function loadModule ($module)
	{
		try
		{
			if (file_exists(DIR_LEGACY . "/" . $module . ".mod.php"))
			{
				require DIR_LEGACY . "/" . $module . ".mod.php";
				$this->modules[$module] = new $module($this);
			} else
			{
				throw new Exception('Module: ' . $module . '(legacy) file not found.');
			}
		} catch (Exception $e)
		{
			$this->cms->exceptions->addError($e);
		}
	}
	public function showModule ($module, $to, $function = 'default')
	{
		if (isset($this->modules[$module]))
		{
			$this->cms->addDataToOutput($this->modules[$module]->show($function), $to);
		} else
		{
			throw new Exception('Module: ' . $module . '(legacy) file not loaded.');
		}
	}
	public function __destruct ()
	{
	}
}

/**
 * n30-cms legacyBase
 * (C) 2008 CT.Studios
 * This is the legacy environment for old modules, so they can run without any major adjustment
 */
class legacyBase
{
	public $templates;
	public $lang;
	public $url;
	public $pagetitle;
	public function __construct ()
	{
		$this->url = $this->setUrl();
	}
	private function setUrl ()
	{
		$_SERVER['FULL_URL'] = 'http';
		if (isset($_SERVER['HTTPS']) and $_SERVER['HTTPS'] == 'on')
		{
			$_SERVER['FULL_URL'] .= 's';
		}
		$_SERVER['FULL_URL'] .= '://';
		if ($_SERVER['SERVER_PORT'] != '80')
		{
			$_SERVER['FULL_URL'] .= $_SERVER['HTTP_HOST'] . ':' . $_SERVER['SERVER_PORT'] . $_SERVER['REQUEST_URI'];
		} else
		{
			$_SERVER['FULL_URL'] .= $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
		}
		if ($_SERVER['QUERY_STRING'] > ' ')
		{
			$_SERVER['FULL_URL'] .= '?' . $_SERVER['QUERY_STRING'];
		}
		return ($_SERVER['FULL_URL']);
	}
	public function createURL ($file, $function = null, $id = null, $page = null)
	{
		switch (LINK_STYLE)
		{
			case 'multiviews':
				$url = BASE_URL . $file;
				if (! empty($function) and empty($id) and empty($page))
				{
					$url .= "/" . $function;
				} elseif (empty($function) and ! empty($id) and empty($page))
				{
					$url .= "/" . intval($id);
				} elseif (! empty($function) and ! empty($id) and empty($page))
				{
					$url .= "/" . $function . "/" . intval($id);
				} elseif (! empty($function) and ! empty($id) and ! empty($page))
				{
					$url .= "/" . $function . "/" . intval($id) . "/" . intval($page);
				}
				break;
			default:
				$url = BASE_URL . $file;
				if (! empty($function) and empty($id) and empty($page))
				{
					$url .= "?function=" . $function;
				} elseif (empty($function) and ! empty($id) and empty($page))
				{
					$url .= "?id=" . intval($id);
				} elseif (! empty($function) and ! empty($id) and empty($page))
				{
					$url .= "?function=" . $function . "&id=" . intval($id);
				} elseif (! empty($function) and ! empty($id) and ! empty($page))
				{
					$url .= "?function=" . $function . "&id=" . intval($id) . "&page=" . intval($page);
				}
				break;
		}
		return ($url);
	}
}
?>