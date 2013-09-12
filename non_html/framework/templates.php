<?php
/**
 * n30-cms templates
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
 * Template loading and management.
 * 
 * ------------------------------------------------------------------------------------
 * Author: Simon de la Court
 * 
 */

/**
 * SQL UPDATE for default table:
 * ALTER TABLE  `n30_templates` CHANGE  `default`  `def` ENUM(  'true',  'false' ) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT  'false'
 * 
 */
class templates
{
	public $langid;
	private $cms;
	public $templates;
	public $compileddir;
	public function __construct (&$cms)
	{
		$this->cms = &$cms;
		if ($cms->mode == 'admin')
		{
			$this->compileddir = realpath($this->cms->bPath . "../admin/template/compiled") . "/";
		}
	}
	/**
	 * get a template
	 *
	 * @param int $id
	 * @return array
	 */
	public function getTemplate ($id)
	{
		$QE = $this->cms->connection->query("SELECT * FROM " . TAB_TEMPLATES . " WHERE id = " . intval($id));
		$res = $this->cms->connection->fetch_assoc($QE);
		return ($res);
	}
	/**
	 * retrieve templates
	 *
	 * @return array
	 */
	public function getTemplates ()
	{
		return ($this->cms->connection->fetch_array("SELECT * FROM " . TAB_TEMPLATES));
	}
	/**
	 * return templates that are in the template directory
	 *
	 * @return array
	 */
	public function getTemplatesFromDir ()
	{
		$templates = array();
		if ($this->cms->mode != "admin")
		{
			$dir = realpath($this->cms->bPath . "/templates") . "/";
		}
		else 
		{
			$dir = realpath($this->cms->bPath . "../templates") . "/";
		}
		
	    if ($dh = opendir($dir)) 
	    {
	        while (($file = readdir($dh)) !== false)
	        {
	        	if (is_dir($dir . $file) AND substr($file, 0, 1) != ".")
	        	{
	        		$templates[] = $file;
	        	}
	        }
	        closedir($dh);
	    }

		return ($templates);
	}
	/**
	 * install a template into the CMS
	 *
	 * @param directory $dir
	 * @param title $title
	 */
	public function installTemplate ($dir, $title)
	{
		$this->cms->connection->query("INSERT INTO " . TAB_TEMPLATES  . "(id, title, dir, def) VALUES (null, '" . $this->cms->connection->escape_string($title) . "', '" . $this->cms->connection->escape_string($dir) . "', 'false')");
	}
	/**
	 * uninstall a template from the CMS
	 *
	 * @param integer $id
	 */
	public function unInstallTemplate ($id)
	{
		$q = $this->cms->connection->query("SELECT id FROM " . TAB_TEMPLATES . " WHERE `def` = 'true' LIMIT 0,1");
		$template = $this->cms->connection->fetch_assoc($q);
		
		if ($id != $template['id'])
		{
			$this->cms->connection->query("DELETE FROM " . TAB_TEMPLATES . " WHERE id = '" . intval($id) . "'");
			$this->cms->connection->query("UPDATE " . TAB_USERS . " SET template = " . intval($template['id']) . " WHERE template = " . intval($id));
		}
	}
	/**
	 * set the default template
	 *
	 * @param integer $id
	 */
	public function setDefault ($id)
	{
		$this->cms->connection->query("UPDATE " . TAB_TEMPLATES . " SET def = 'false'");
		$this->cms->connection->query("UPDATE " . TAB_TEMPLATES . " SET def = 'true' WHERE id = " . intval($id));		
	}
	/**
	 * check if directory contains templates
	 *
	 * @param directory $dir
	 * @return boolean
	 */
	public function isTemplateDir ($dir)
	{
		$dir = realpath($this->cms->bPath . "../templates") . "/" . $dir;
		if (is_dir($dir))
		{
			if (is_file($dir . "/index.tpl"))
			{
				return (true);
			}
		}
		return (false);
	}
	/**
	 * get and set default template
	 *
	 */
	public function getDefaultTemplate ()
	{
		$q = $this->cms->connection->query("SELECT * FROM " . TAB_TEMPLATES . " WHERE `def` = 'true' LIMIT 0,1");
		$template = $this->cms->connection->fetch_assoc($q);
		if ($this->cms->connection->num_rows($q) != 1)
		{
			throw new Exception('No default template set');
		} else
		{
			$this->templates['default'] = $template;
		}
	}
	/**
	 * load a templateset into the cache
	 *
	 * @param array $template
	 */
	public function loadTemplateSet ($template)
	{
		if (isset($template['title']) and isset($template['id']) and isset($template['dir']))
		{
			$this->templates[$template['title']] = $template;
		} else
		{
			throw new Exception('Faulty template loaded');
		}
	}
	/**
	 * set a template as loaded
	 *
	 * @param string $title
	 */
	public function setTemplate ($title)
	{
		if (isset($this->templates[$title]))
		{
			$this->templates['set'] = $this->templates[$title];
			$this->templates['set']['dir'] = DIR_TPLS . DIRECTORY_SEPARATOR . $this->templates['set']['dir'] . DIRECTORY_SEPARATOR;
		} elseif ($title == 'default')
		{
			$this->getDefaultTemplate();
			$this->templates['set'] = $this->templates[$title];
			$this->templates['set']['dir'] = DIR_TPLS . DIRECTORY_SEPARATOR . $this->templates['set']['dir'] . DIRECTORY_SEPARATOR;
		} else
		{
			throw new Exception('Nonexisting template set');
		}
		$this->compileddir = realpath($this->cms->bPath . $this->templates['set']['dir'] . "/compiled") . "/";
	}
}
?>