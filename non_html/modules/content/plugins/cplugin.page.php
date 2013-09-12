<?php
/**
 * n30-cms content plugin: page
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
define('TAB_CNT_PPAGE', T_PREFIX . 'cnt_ppage');

class cPlugin_page
{
	private $cms;
	private $itemid;
	private $page;
	public function __construct (&$cms, $itemid)
	{
		$this->cms = &$cms;
		$this->itemid = $itemid;
		$QE = $this->cms->connection->query("SELECT * FROM " . TAB_CNT_PPAGE . " WHERE itemid = " . intval($itemid) . " LIMIT 0,1 ");
		$res = $this->cms->connection->fetch_assoc($QE);
		if (isset($res['page']))
		{
			$this->page = $res['page'];
		} else
		{
			throw new Exception("Module content, plugin link: no related page found.");
		}
	}
	public function getOutput ($viewmode = '')
	{
		switch ($viewmode)
		{
			default:
				return (stripslashes($this->page));
			break;
		}
	}
}

class cAPlugin_page
{
	private $cms;
	private $id;
	public function __construct (&$cms, $id)
	{
		$this->cms = &$cms;
		$this->id = intval($id);
		if ($id != 'new')
		{
		}
	}
	/**
	 * required function for every plugin to check data
	 *
	 * @param array $data
	 */
	public function check ($data)
	{
		if (isset($data['page']))
		{
			return (true);
		}
		else
		{
			return (false);
		}
	}
	/**
	 * required function for every plugin to edit the data
	 *
	 * @param array $data
	 * @return boolean
	 */
	public function edit ($data)
	{
		if ($this->id == 'new')
		{
			if (isset($data['page']) AND isset($data['iid']))
			{
				$this->cms->connection->query("INSERT INTO " .TAB_CNT_PPAGE . " (id, itemid, page) VALUES (null, " . intval($data['iid']) . ", '" . $this->cms->connection->escape_string($data['page']) . "')" );
				return (true);
			}
			else 
			{
				// fields missing, end of story
				return (false);
			}
		}
		else
		{
			if (isset($data['page']))
			{
				$this->cms->connection->query("UPDATE " .TAB_CNT_PPAGE . " SET page = '" . $this->cms->connection->escape_string(trim($data['page'])) . "' WHERE itemid = " . intval($this->id) );
				return (true);
			}
			else 
			{
				// fields missing, end of story
				return (false);
			}
		}
	}
	/**
	 * deletes an instance of page
	 *
	 */
	public function delete ()
	{
		$this->cms->connection->query("DELETE FROM " . TAB_CNT_PPAGE . " WHERE itemid = " . intval($this->id));
	}
	public function getExtension ()
	{
		return ('.cnt');
	}
	/**
	 * shows form for editing or creating a page
	 *
	 * @return string
	 */
	public function getForm ()
	{
		if ($this->id == 'new')
		{
			$form = $this->cms->getWYSIWYGcode('pdata[page]', '', admin::generateLink('m', array('module' => 'content', 'action' => 'fckconfig')), '', '100%', '350px');
			return ($form);
		}
		else
		{
			$QE = $this->cms->connection->query("SELECT * FROM " . TAB_CNT_PPAGE . " WHERE itemid = " . intval($this->id));
			$res = $this->cms->connection->fetch_assoc($QE);
			$form = $this->cms->getWYSIWYGcode('pdata[page]', $res['page'], admin::generateLink('m', array('module' => 'content', 'action' => 'fckconfig')), '', '100%', '350px');
			return ($form);
		}
	}
}
?>