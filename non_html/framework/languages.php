<?php
/**
 * n30-cms language
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
 * Language loading and management.
 * 
 * ------------------------------------------------------------------------------------
 * Author: Simon de la Court
 * 
 */
/**
 * n30-cms languages
 * (C) 2008 CT.Studios
 * 
 * This source code is release under the BSD License.
 */

/**
 * SQL UPDATES:
 * ALTER TABLE  `n30_lang` CHANGE  `default`  `def` ENUM(  'true',  'false' ) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT  'false'
 * 
 */
class languages
{
	public $langid;
	private $cms;
	public $lang;
	public $defaultlanguage;
	public $selectedlanguage;
	public function __construct (&$cms)
	{
		$this->cms = &$cms;
	}
	/**
	 * gets default language for CMS
	 */
	public function getDefaultLanguage ()
	{
		$q = $this->cms->connection->query("SELECT * FROM " . TAB_LANG . " WHERE `def` = 'true' LIMIT 0,1");
		$lang = $this->cms->connection->fetch_assoc($q);
		if ($this->cms->connection->num_rows($q) != 1)
		{
			throw new Exception('No default language set');
		} else
		{
			$this->defaultlanguage = $lang;
		}
	}
	/**
	 * get a language
	 *
	 * @param int $id
	 * @return array
	 */
	public function getLanguage ($id)
	{
		$QE = $this->cms->connection->query("SELECT * FROM " . TAB_LANG . " WHERE id = " . intval($id));
		$res = $this->cms->connection->fetch_assoc($QE);
		return ($res);
	}
	/**
	 * retrieve languages
	 *
	 * @return array
	 */
	public function getLanguages ()
	{
		return($this->cms->connection->fetch_array("SELECT * FROM " . TAB_LANG));
	}
	/**
	 * return languages that are in the template directory
	 *
	 * @return array
	 */
	public function getLanguagesFromDir ()
	{
		$languages = array();
		if ($this->cms->mode != "admin")
		{
			$dir = realpath($this->cms->bPath . "/non_html/lang") . "/";
		}
		else 
		{
			$dir = realpath($this->cms->bPath . "../non_html/lang") . "/";
		}
		
	    if ($dh = opendir($dir)) 
	    {
	        while (($file = readdir($dh)) !== false)
	        {
	        	if (is_dir($dir . $file) AND substr($file, 0, 1) != ".")
	        	{
	        		$languages[] = $file;
	        	}
	        }
	        closedir($dh);
	    }

		return ($languages);
	}
	/**
	 * sets language CMS-wide
	 *
	 * @param string $language
	 */
	public function setLanguage ($language)
	{
		if ($this->cms->mode == 'admin')
		{
			$extra = "../";
		} else
		{
			$extra = '';
		}
		if (is_dir($this->cms->bPath . $extra . DIR_LANG . DIRECTORY_SEPARATOR . $language))
		{
			if ($dir = @opendir($this->cms->bPath . $extra . DIR_LANG . DIRECTORY_SEPARATOR . $language))
			{
				while (($file = readdir($dir)) !== false)
				{
					if (substr($file, - 9) == '.lang.php')
					{
						require_once ($this->cms->bPath . $extra . DIR_LANG . DIRECTORY_SEPARATOR . $language . "/" . $file);
					}
				}
				closedir($dir);
			}
		} else
		{
			throw new Exception('Language directory missing.');
		}
	}
	/**
	 * install a language into the CMS
	 *
	 * @param directory $dir
	 * @param title $title
	 */
	public function installLanguage ($dir, $title)
	{
		$this->cms->connection->query("INSERT INTO " . TAB_LANG  . "(id, title, dir, def) VALUES (null, '" . $this->cms->connection->escape_string($title) . "', '" . $this->cms->connection->escape_string($dir) . "', 'false')");
	}
	/**
	 * uninstall a language from the CMS
	 *
	 * @param integer $id
	 */
	public function unInstallLanguage ($id)
	{
		$q = $this->cms->connection->query("SELECT id FROM " . TAB_LANG . " WHERE `def` = 'true' LIMIT 0,1");
		$template = $this->cms->connection->fetch_assoc($q);
		
		if ($id != $template['id'])
		{
			$this->cms->connection->query("DELETE FROM " . TAB_LANG . " WHERE id = '" . intval($id) . "'");
			$this->cms->connection->query("UPDATE " . TAB_USERS . " SET lang = " . intval($template['id']) . " WHERE lang = " . intval($id));
		}
	}
	/**
	 * set the default language
	 *
	 * @param integer $id
	 */
	public function setDefault ($id)
	{
		$this->cms->connection->query("UPDATE " . TAB_LANG . " SET def = 'false'");
		$this->cms->connection->query("UPDATE " . TAB_LANG . " SET def = 'true' WHERE id = " . intval($id));		
	}
	/**
	 * check if directory contains templates
	 *
	 * @param directory $dir
	 * @return boolean
	 */
	public function isLanguageDir ($dir)
	{
		$dir = realpath($this->cms->bPath . "../non_html/lang") . "/" . $dir;
		if (is_dir($dir))
		{
			return (true);
		}
		else
		{
			return (false);
		}
	}
}
?>