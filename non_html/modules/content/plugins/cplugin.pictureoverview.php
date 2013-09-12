<?php
/**
 * n30-cms content plugin: pictureoverview
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
define('TAB_CNT_PPICTURESOVERVIEW', T_PREFIX . 'cnt_ppicturesoverview');

class cPlugin_pictureoverview
{

	// private:
	private $cms;

	private $itemid;

	// public:
	//public $intoutput = true;
	public function __construct (&$cms, $itemid)
	{
		$this->cms = &$cms;
		$this->itemid = $itemid;
	}

	public function getOutput ($viewmode = '')
	{
		$QE = $this->cms->connection->query("SELECT
											p.*, s.full_title, ov.picture_perline, ov.picture_maxwidth AS ovmaxwidth, ov.picture_maxheight AS ovmaxheight, s.full_location
											FROM " . TAB_CNT_PPICTURESOVERVIEW . " ov
											LEFT JOIN " . TAB_CNT_STRUCTURE . " s ON ov.directory_id = s.id_parent
											LEFT JOIN " . TAB_CNT_PPICTURES . " p ON p.itemid = s.id									
											WHERE ov.itemid = " . intval($this->itemid) . " AND s.str_plugin = 'picture' ORDER BY s.sortorder ASC");
		$i = 0;
		$i2 = 0;
		$nres = array();
		while ($res = $this->cms->connection->fetch_assoc($QE))
		{
			$res['viewurl'] = n30::generateLink($this->cms->modules['content']->file, array('mode' => 'int' , 'options' => 'itemid:' . intval($res['itemid']) . ';hsize:' . intval($res['ovmaxheight']) . ';vsize:' . intval($res['ovmaxwidth'])));
			$res['viewurl_full'] = n30::generateLink($this->cms->modules['content']->file, array('mode' => 'int' , 'options' => 'itemid:' . intval($res['itemid'])));
			$res['link'] = $this->cms->generateLink($this->cms->modules['content']->file, array('path' => $res['full_location']));
			$nres[$i2][$i] = $res;
			$i ++;
			if ($i == $res['picture_perline'])
			{
				$i = 0;
				$i2 ++;
			}
		}
		$overview = new Smarty();
		$overview->template_dir = $this->cms->bPath . "/non_html/modules/content/templates/plugins/";
		$overview->compile_dir = $this->cms->templates->compileddir;
		$overview->assign('lang', $this->cms->languages->lang);
		$overview->assign('baseurl', BASE_URL);
		$overview->assign('pictures', $nres);
		$overview->assign('item', $this->cms->modules['content']->getItemById($this->itemid));
		return ($overview->fetch($this->cms->modules['content']->getTemplateFile('plugin', 'pctov.show.tpl')));
	}
}

class cAPlugin_pictureoverview
{

	private $cms;

	private $itemid;

	public function __construct (&$cms, $itemid, $admin)
	{
		$this->cms = &$cms;
		$this->itemid = intval($itemid);
	}

	/**
	 * required function for every plugin to check data
	 *
	 * @param array $data
	 */
	public function check ($data)
	{
		if (isset($data['directory_id']) and isset($data['picture_perline']) and isset($data['picture_maxwidth']) and isset($data['picture_maxheight']))
		{
			return (true);
		} else
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
		if (isset($data['directory_id']) and isset($data['picture_perline']) and isset($data['picture_maxwidth']) and isset($data['picture_maxheight']))
		{
			if ($this->itemid == 'new')
			{
				$this->cms->connection->query("INSERT INTO  " . TAB_CNT_PPICTURESOVERVIEW . " (
												`id` ,
												`itemid`,
												`directory_id` ,
												`picture_perline` ,
												`picture_maxwidth` ,
												`picture_maxheight`
												)
												VALUES (
												NULL , " . intval($data['iid']) . ", " . intval($data['directory_id']) . ",  " . intval($data['picture_perline']) . ",  " . intval($data['picture_maxwidth']) . ",  " . intval($data['picture_maxheight']) . "
												);");
				return (true);
			} else
			{
				$query = "UPDATE " . TAB_CNT_PPICTURESOVERVIEW . " SET 
				directory_id = " . intval($data['directory_id']) . ",
				picture_perline = " . intval($data['picture_perline']) . ",
				picture_maxwidth = " . intval($data['picture_maxwidth']) . ",
				picture_maxheight = " . intval($data['picture_maxheight']) . "
				WHERE itemid = " . intval($this->itemid);
				$this->cms->connection->query($query);
				return (true);
			}
		} else
		{
			return (false);
		}
	}

	/**
	 * delete an instance of file
	 *
	 */
	public function delete ()
	{
		$this->cms->connection->query("DELETE FROM " . TAB_CNT_PPICTURESOVERVIEW . " WHERE itemid = " . intval($this->itemid));
	}

	/**
	 * return the extension for this module
	 *
	 * @return string
	 */
	public function getExtension ()
	{
		return ('.pco');
	}

	/**
	 * shows form for editing or creating a page
	 *
	 * @return string
	 */
	public function getForm ()
	{
		if ($this->itemid == 'new')
		{
			// only one way to show this
			$pictureform = new Smarty();
			$pictureform->template_dir = $this->cms->bPath . "../non_html/modules/content/templates/plugins";
			$pictureform->compile_dir = $this->cms->templates->compileddir;
			$pictureform->assign('lang', $this->cms->languages->lang);
			$pictureform->assign('mlang', $this->cms->module->lang);
			$pictureform->assign('baseurl', BASE_URL);
			$item = $this->cms->module->getItem($this->cms->module->currentparentid);
			$pictureform->assign('dirs', $this->cms->module->getAllItems('/', 'dir'));
			$pictureform->assign('item', $item);
			return ($pictureform->fetch('adm.pctov.new.tpl'));
		} else
		{
			// fetch the data first
			$QE = $this->cms->connection->query("SELECT * FROM " . TAB_CNT_PPICTURESOVERVIEW . " WHERE itemid = " . intval($this->itemid));
			$res = $this->cms->connection->fetch_assoc($QE);
			// only one way to show this
			$pictureform = new Smarty();
			$pictureform->template_dir = $this->cms->bPath . "../non_html/modules/content/templates/plugins";
			$pictureform->compile_dir = $this->cms->templates->compileddir;
			$pictureform->assign('lang', $this->cms->languages->lang);
			$pictureform->assign('mlang', $this->cms->module->lang);
			$pictureform->assign('baseurl', BASE_URL);
			$item = $this->cms->module->getItem($this->itemid);
			$pictureform->assign('dirs', $this->cms->module->getAllItems('/', 'dir'));
			$pictureform->assign('item', $item);
			$pictureform->assign('overview', $res);
			return ($pictureform->fetch('adm.pctov.edit.tpl'));
		}
	}

	/**
	 * get extra stuff
	 *
	 * @return string
	 */
	public function getExtra ()
	{
		return (null);
	}
}
?>