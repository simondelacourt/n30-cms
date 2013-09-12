<?php
/**
 * n30-cms content plugin: pictureslideshow
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
define('TAB_CNT_PPICTURESSLIDESHOW', T_PREFIX . 'cnt_ppicturesslideshow');

class cPlugin_pictureslideshow
{	
	// public:
	public $intoutput = true;
	
	// private:
	private $itemid;
	public function __construct (&$cms, $itemid)
	{
		$this->cms = &$cms;
		$this->itemid = $itemid;
	}
	public function showPage ($id)
	{
		$QE = $this->cms->connection->query("SELECT * FROM " . TAB_CNT_STRUCTURE . " WHERE id = " . intval($this->itemid));
		$sshowinfo = $this->cms->connection->fetch_assoc($QE);
		$QE = $this->cms->connection->query("SELECT
											p.*,s.description, s.full_title, sl.show_imgstrip, sl.duration, sl.picture_maxwidth AS slmaxwidth, sl.picture_maxheight AS slmaxheight, sl.thumbnail_maxwidth, sl.thumbnail_maxheight, s.full_location
											FROM " . TAB_CNT_PPICTURESSLIDESHOW . " sl
											LEFT JOIN " . TAB_CNT_STRUCTURE . " s ON sl.directory_id = s.id_parent
											LEFT JOIN " . TAB_CNT_PPICTURES. " p ON p.itemid = s.id									
											WHERE sl.itemid = " . intval($this->itemid) . " AND s.str_plugin = 'picture' ORDER BY s.sortorder ASC");
		$nres = array();
		$sinfo = array();
		$i = 0;
		while ($res = $this->cms->connection->fetch_assoc($QE))
		{
			if ($i == 0)
			{
				$sinfo['duration'] = $res['duration'];
				$sinfo['showimagestrip'] = $res['show_imgstrip'];
				$sinfo['picture_maxwidth'] = $res['slmaxwidth'];
				$sinfo['picture_maxheight'] = $res['slmaxheight'];	
			}
			if ($i == $id)
			{
				$res['active'] = true;
			}
			else
			{
				$res['active'] = false;
			}
			$res['viewurl'] = n30::generateLink($this->cms->modules['content']->file, array('mode' => 'int', 'options' => 'itemid:' . intval($res['itemid']) . ';hsize:' . intval($res['slmaxheight']) . ';vsize:' . intval($res['slmaxwidth'])));				$res['viewurl_full'] = n30::generateLink($this->cms->modules['content']->file, array('mode' => 'int', 'options' => 'itemid:' . intval($res['itemid']) ));
			$res['thumbnail'] = n30::generateLink($this->cms->modules['content']->file, array('mode' => 'int', 'options' => 'itemid:' . intval($res['itemid']) . ';hsize:' . intval($res['thumbnail_maxheight']) . ';vsize:' . intval($res['thumbnail_maxwidth'])));				$res['viewurl_full'] = n30::generateLink($this->cms->modules['content']->file, array('mode' => 'int', 'options' => 'itemid:' . intval($res['itemid']) ));
			$res['link'] = $this->cms->generateLink($this->cms->modules['content']->file, array('path' => $res['full_location']));
			$res['slink'] = n30::generateLink($this->cms->modules['content']->file, array('mode' => 'int', 'options' => 'itemid:' . intval($this->itemid) . ';id:' . $i));
			$nres[] = $res;
			$i++;
		}
		$nav = array();
		
		if (count($nres) > ($id + 1))
		{
			$nav['next'] = n30::generateLink($this->cms->modules['content']->file, array('mode' => 'int', 'options' => 'itemid:' . intval($this->itemid) . ';id:' . ($id + 1)));
		}
		if ($id > 0)
		{
			$nav['prev'] = n30::generateLink($this->cms->modules['content']->file, array('mode' => 'int', 'options' => 'itemid:' . intval($this->itemid) . ';id:' . ($id - 1)));
		}
		
		
		
		$slideshow = new Smarty();
		$slideshow->template_dir = $this->cms->bPath . "/non_html/modules/content/templates/plugins/";
		$slideshow->compile_dir = $this->cms->templates->compileddir;
		$slideshow->assign('lang', $this->cms->languages->lang);
		$slideshow->assign('baseurl', BASE_URL);
		$slideshow->assign('pictures', $nres);
		$slideshow->assign('sinfo', $sinfo);
		$slideshow->assign('info', $sshowinfo);
		$slideshow->assign('picture_count', count($nres));
		$slideshow->assign('picture_current', ($id + 1));
		$slideshow->assign('images', $nres);
		$slideshow->assign('nav', $nav);
		if (isset($nres[$id]))
		{
			$slideshow->assign('currentpicture', $nres[$id]);
		}
		return ($slideshow->fetch($this->cms->modules['content']->getTemplateFile('plugin','pctsl.show.tpl')));
	}
	public function internal ($data)
	{
		if (isset($data['id']))
		{
			return($this->showPage($data['id']));
		}
	}
	public function getOutput ($viewmode = '')
	{
		return($this->showPage(0));
	}
}
class cAPlugin_pictureslideshow
{
	private $cms;
	private $id;
	public function __construct (&$cms, $id, $admin)
	{
		$this->cms = &$cms;
		$this->id = intval($id);
	}
	public function getForm ()
	{
		if ($this->id == 'new')
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
			return ($pictureform->fetch('adm.pctsls.new.tpl'));
		}
		else
		{
			// fetch the data first
			$QE = $this->cms->connection->query("SELECT * FROM " . TAB_CNT_PPICTURESSLIDESHOW . " WHERE itemid = " . intval($this->id));
			$res = $this->cms->connection->fetch_assoc($QE);
			// only one way to show this
			$pictureform = new Smarty();
			$pictureform->template_dir = $this->cms->bPath . "../non_html/modules/content/templates/plugins";
			$pictureform->compile_dir = $this->cms->templates->compileddir;
			$pictureform->assign('lang', $this->cms->languages->lang);
			$pictureform->assign('mlang', $this->cms->module->lang);
			$pictureform->assign('baseurl', BASE_URL);
			$item = $this->cms->module->getItem($this->id);
			$pictureform->assign('dirs', $this->cms->module->getAllItems('/', 'dir'));
			$pictureform->assign('item', $item);
			$pictureform->assign('slideshow', $res);
			return ($pictureform->fetch('adm.pctsls.edit.tpl'));
		}
	}
	/**
	 * required function for every plugin to check data
	 *
	 * @param array $data
	 */
	public function check ($data)
	{
		if (isset($data['directory_id']) AND isset($data['picture_duration']) AND isset($data['picture_maxwidth']) AND isset($data['picture_maxheight']) AND isset($data['picturestrip']) AND isset($data['thumbnail_maxwidth']) AND isset($data['thumbnail_maxheight']) )
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
		if (isset($data['directory_id']) AND isset($data['picture_duration']) AND isset($data['picture_maxwidth']) AND isset($data['picturestrip']) AND isset($data['picture_maxheight']) AND isset($data['thumbnail_maxwidth']) AND isset($data['thumbnail_maxheight']) )
		{
			if ($this->id == 'new')
			{
				$this->cms->connection->query("INSERT INTO  " . TAB_CNT_PPICTURESSLIDESHOW . " (
												`id` ,
												`itemid`,
												`directory_id` ,
												`duration` ,
												`picture_maxwidth` ,
												`picture_maxheight`,
												`show_imgstrip`,
												`thumbnail_maxwidth` ,
												`thumbnail_maxheight`
												)
												VALUES (
												NULL , " . intval($data['iid']) . ", " . intval($data['directory_id']) . ",  " . intval($data['picture_duration']) . ",  " . intval($data['picture_maxwidth']) . ",  " . intval($data['picture_maxheight']) . ", '" . intval($data['picturestrip']) . "', " . intval($data['thumbnail_maxwidth']) . ",  " . intval($data['thumbnail_maxheight']) . "
												);");
				return (true);
			}
			else 
			{
				$query = "UPDATE " . TAB_CNT_PPICTURESSLIDESHOW . " SET 
				directory_id = " . intval($data['directory_id']) . ",
				duration = " . intval($data['picture_duration']) . ",
				picture_maxwidth = " . intval($data['picture_maxwidth']) . ",
				picture_maxheight = " . intval($data['picture_maxheight']) . ",
				show_imgstrip = '" . intval($data['picturestrip']) . "',
				thumbnail_maxwidth = " . intval($data['thumbnail_maxwidth']) . ",
				thumbnail_maxheight = " . intval($data['thumbnail_maxheight']) . "
				WHERE itemid = " . intval($this->id);
				$this->cms->connection->query($query);
				return (true);
			}
		
		}
		else
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
		$this->cms->connection->query("DELETE FROM " . TAB_CNT_PPICTURESSLIDESHOW . " WHERE itemid = " . intval($this->id));
	}
	/**
	 * get extension
	 *
	 * @return string
	 */
	public function getExtension ()
	{
		
		return ('.pcsls');
	}
}
?>