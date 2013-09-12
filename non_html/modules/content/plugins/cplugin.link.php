<?php
/**
 * n30-cms content plugin: link
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
 * Plugin for content module.
 * 
 * 
 * ------------------------------------------------------------------------------------
 * Author: Simon de la Court
 * 
 */
define('TAB_CNT_PLINK', T_PREFIX . 'cnt_plink');

class cPlugin_link
{
	private $cms;
	private $itemid;
	private $link;
	private $mode;
	public function __construct (&$cms, $itemid)
	{
		$this->cms = &$cms;
		$this->itemid = $itemid;
		$QE = $this->cms->connection->query("SELECT * FROM " . TAB_CNT_PLINK . " WHERE itemid = " . intval($itemid) . " LIMIT 0,1 ");
		$res = $this->cms->connection->fetch_assoc($QE);
		//print_r($res);
		if (! isset($res['id']))
		{
			throw new Exception("Module content, plugin link: no related link found.");
		} else
		{
			$this->cms->connection->query("UPDATE " . TAB_CNT_PLINK . " SET hits = hits + 1 WHERE itemid = " . $itemid);
			switch ($res['mode'])
			{
				default:
					$this->cms->blockOutput();
					header("Location: " . $res['link']);
					exit();
				break;
			}
		}
	}
	/**
	 * normally returns output, but this module does not (yet) generate HTML output
	 *
	 * @param unknown_type $viewmode
	 * @return unknown
	 */
	public function getOutput ($viewmode = '')
	{
		return (null);
	}
}

class cAPlugin_link
{
	private $cms;
	private $id;
	public function __construct (&$cms, $id, $admin)
	{
		$this->cms = &$cms;
		$this->id = $id;
		if ($id != 'new')
		{
		}
	}
	/**
	 * gets an edit or create form
	 *
	 * @return string
	 */
	public function getForm ()
	{
		if ($this->id == 'new')
		{
			$linkform = new Smarty();
			$linkform->template_dir = $this->cms->bPath . "../non_html/modules/" . $this->cms->module->moduledir . "/templates/plugins";
			$linkform->compile_dir = $this->cms->templates->compileddir;
			$linkform->assign('lang', $this->cms->languages->lang);
			$linkform->assign('mlang', $this->cms->module->lang);
			$linkform->assign('baseurl', BASE_URL);
			return ($linkform->fetch('adm.link.new.tpl'));
		}
		else
		{
			$QE = $this->cms->connection->query("SELECT * FROM " . TAB_CNT_PLINK . " WHERE itemid = " . intval($this->id));
			$ldata = $this->cms->connection->fetch_assoc($QE);
			$linkform = new Smarty();
			$linkform->template_dir = $this->cms->bPath . "../non_html/modules/" . $this->cms->module->moduledir . "/templates/plugins";
			$linkform->compile_dir = $this->cms->templates->compileddir;
			$linkform->assign('lang', $this->cms->languages->lang);
			$linkform->assign('mlang', $this->cms->module->lang);
			$linkform->assign('baseurl', BASE_URL);
			$linkform->assign('link', $ldata['link']);
			return ($linkform->fetch('adm.link.edit.tpl'));
		}
	}
	/**
	 * return extension
	 *
	 * @return string
	 */
	public function getExtension ()
	{
		return ('.lnk');
	}
	/**
	 * check if data is ok
	 *
	 * @param array $data
	 * @return boolean
	 */
	public function check ($data)
	{
		if (isset($data['link']) AND strtolower(substr($data['link'], 0, 7)) == "http://")
		{
			return (true);
		}
		else
		{
			return (false);
		}
	}
	/**
	 * edit or create a link
	 *
	 * @param unknown_type $data
	 * @return unknown
	 */
	public function edit ($data)
	{
		if ($this->id == 'new')
		{
			if (isset($data['link']) AND isset($data['iid']))
			{
				$this->cms->connection->query("INSERT INTO " . TAB_CNT_PLINK . " (id, itemid, link) VALUES (null, " . intval($data['iid']) . ", '" . $this->cms->connection->escape_string($data['link']) .  "')");
				return (true);
			}
			else 
			{
				return (false);
			}
		}
		else
		{
			if (isset($data['link']))
			{
				$this->cms->connection->query("UPDATE " . TAB_CNT_PLINK . " SET link = '" . $this->cms->connection->escape_string($data['link']) .  "' WHERE itemid = " . intval($this->id));
				return (true);
			}
			else 
			{
				return (false);
			}
		}
	}
	/**
	 * delete an instance of link
	 *
	 */
	public function delete ()
	{
		$this->cms->connection->query("DELETE FROM " . TAB_CNT_PLINK . " WHERE itemid = " . intval($this->id));
	}
	
}
?>