<?php
/**
 * n30-cms content plugin: picture
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
define('TAB_CNT_PPICTURES', T_PREFIX . 'cnt_ppictures');

class cPlugin_picture
{
	// private:
	private $cms;
	private $itemid;
	private $uploadpath;
	private $picture;
	private $method = 'imagemagick'; /* method can be either gd or imagemagick, either of one is required for this module to run */
	private $imagemagickpath = ' /usr/local/bin/convert';

	// public:
	public $intoutput = true;
	
	public function __construct (&$cms, $itemid)
	{
		$this->cms = &$cms;
		$this->itemid = $itemid;
		$this->uploadpath = $this->cms->bPath . "/non_html/modules/content/files/";
		if ($itemid != 'new')
		{
			$QE = $this->cms->connection->query("SELECT * FROM " . TAB_CNT_PPICTURES . " WHERE itemid = " . intval($this->itemid));
			$this->picture = $this->cms->connection->fetch_assoc($QE);
			$this->picture['viewurl'] = n30::generateLink($this->cms->modules['content']->file, array('mode' => 'int', 'options' => 'itemid:' . intval($itemid) . ';hsize:' . intval($this->picture['picture_showheight']) . ';vsize:' . intval($this->picture['picture_showwidth'])));
			$this->picture['viewurl_full'] = n30::generateLink($this->cms->modules['content']->file, array('mode' => 'int', 'options' => 'itemid:' . intval($itemid) ));
		}
 	}
	private function resize ($filename, $writeto, $max_width, $max_height)
	{
		list($orig_width, $orig_height) = getimagesize($filename);
		$width = $orig_width;
		$height = $orig_height;
		if ($height > $max_height)
		{
			$width = ($max_height / $height) * $width;
			$height = $max_height;
		}
		if ($width > $max_width)
		{
			$height = ($max_width / $width) * $height;
			$width = $max_width;
		}
		if ($this->method == 'gd' OR !isset($this->method))
		{
			
			$image_p = imagecreatetruecolor($width, $height);
			$image = imagecreatefromjpeg($filename);
			imagecopyresampled($image_p, $image, 0, 0, 0, 0, $width, $height, $orig_width, $orig_height);
			$image_p = imagejpeg($image_p, $writeto, 100);
		}
		elseif ($this->method == 'imagemagick')
		{
			$npath = explode(DIRECTORY_SEPARATOR, $writeto);
			$fname = $npath[count($npath) - 1];
			$npath[count($npath) - 1] = null;
			$tpath = realpath(implode($npath, DIRECTORY_SEPARATOR));
			$tpath = $tpath . DIRECTORY_SEPARATOR . $fname;
			$command = $this->imagemagickpath . " '" . realpath($filename) . "' -geometry " . $width . "x" . $height." -quality 90  '" . $tpath . "'";
			system ($command);
		}	
	}
	public function getOutput ($viewmode = '')
	{
		$this->internal(array());
	}
	public function internal ($data)
	{
		$this->cms->blockOutput();
		$res = $this->picture;
		$file = $this->uploadpath . $res['file_intname'];
		if (isset($data['hsize']) AND isset($data['vsize']))
		{
			$filen = $file . ".h" . intval($data['hsize']) . "w" .  intval($data['vsize']);
			if (!file_exists($filen))
			{
				$this->resize($file, $filen, $data['vsize'], $data['hsize']);
			}
			$file = $filen;
		}
	    //required, or it might try to send the serving     
	    //document instead of the file
	
		if (isset($_SERVER['HTTP_IF_MODIFIED_SINCE']))
		{
	  		// Client's cache IS current, so we just respond '304 Not Modified'.
	 		header('Cache-Control: private', true);
	  		header('Last-Modified: ' . gmdate('D, d M Y H:i:s', filemtime($file)) . ' GMT', true, 304);
			header( "HTTP/1.1 304 Not Modified", true);
		}
		else
		{
			// Image not cached or cache outdated, we respond '200 OK' and output the image.
			// Check if the file already exists on disk
			if (file_exists($file))
			{
				header('Cache-Control: private, max-age=' . (3600 * 24 * 365), true);
				header('Content-Disposition: inline; filename="' . $res['file_name'] . '"');
				header('Last-Modified: ' . gmdate('D, d M Y H:i:s', filemtime($file)) . ' GMT', true, 200);
				header("Content-Type: image/jpeg");
   
				if($fop = fopen($file, 'rb'))
				{
					while( (!feof($fop)) && (connection_status()==0) )
					{
						print(fread($fop, 1024*8));
				        flush();
				    }
					fclose($fop);
				}
  			}
  			else 
  			{
  				throw new Exception ("File not uploaded or resized!");
  			}
		}
	}
}
class cAPlugin_picture
{
	private $cms;
	private $id;
	private $ok = false;
	private $uploadpath;
	private $picture;
	private $admin;
	
	private $mime = array('image/gif', 'image/jpeg','image/pjpeg',  'image/png', 'image/bmp', 'image/tiff', 'image/jp2' => 'jp2','image/vnd.wap.wbmp');  
	public $rExtra = true;
	public function __construct ($cms, $id, $admin)
	{
		$this->cms = $cms;
		$this->admin = $admin;
		$this->id = intval($id);
		
		if ($id != 'new')
		{
			$QE = $this->cms->connection->query("SELECT * FROM " . TAB_CNT_PPICTURES . " WHERE itemid = " . intval($this->id));
			$this->picture = $this->cms->connection->fetch_assoc($QE);
			if (isset($this->cms->module->file))
			{
				$this->picture['viewurl'] = admin::generateLink($this->cms->module->file, array('mode' => 'int', 'options' => 'itemid:' . intval($id) . ';hsize:400;vsize:400'), '');	
			}
		}
		
		if (is_writable($this->cms->bPath . "../non_html/modules/content/files"))
		{
			$this->uploadpath = $this->cms->bPath . "../non_html/modules/content/files/";
			$this->ok = true;
		}
	}
	/**
	 * required function for every plugin to check data
	 *
	 * @param array $data
	 */
	public function check ($data)
	{
		if ($data['uploadmethod'] == 'multiupload')
		{
			$this->blocknew = true;
		}
		return (true);
	}

	private function getMultiFiles ($uploaddir)
	{
		$mupload = array();
		if ($dh = opendir($uploaddir))
		{
			while (($file = readdir($dh)) !== false)
			{
				if (substr($file, 0, 01) != '.')
				{
					$file_info = getimagesize($uploaddir . $file);
					if (in_array($file_info['mime'], $this->mime))
					{
						$mupload[] = $file;
					}
				}
			}
			closedir($dh);
		}
		return ($mupload);
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
			if ($this->cms->filemanagement->fileExists($data['filename']) AND $this->ok)
			{
				$nfilename = $data['iid'] . "_" . $data['filename'];
				$npath = $this->uploadpath . $nfilename;
				$this->cms->filemanagement->moveintoplace($data['filename'], $npath);
				
				
				$fexp = explode ('.', $data['filename']);
				$fext = $fexp[count($fexp) - 1];
				$fsize = filesize($npath);
				
				$this->cms->connection->query("INSERT INTO " . TAB_CNT_PPICTURES . " 
				(id, itemid, file_name, file_extension, file_size, file_intname, picture_ref, picture_artist, picture_copyright, picture_date, picture_country, picture_location, picture_showheight, picture_showwidth)
				VALUES
				(null,
				'" . intval ($data['iid']) . "',
				'" . $this->cms->connection->escape_string ($data['filename']) . "',
				'" . $this->cms->connection->escape_string ($fext) . "',
				'" . intval ($fsize) . "',
				'" . $this->cms->connection->escape_string ($nfilename) . "',
				'" . $this->cms->connection->escape_string ($data['ref']) . "',
				'" . $this->cms->connection->escape_string ($data['artist']) . "',
				'" . $this->cms->connection->escape_string ($data['copyright']) . "',
				'" . $this->cms->connection->escape_string ($data['date']) . "',
				'" . $this->cms->connection->escape_string ($data['country']) . "',
				'" . $this->cms->connection->escape_string ($data['location']) . "',
				'" . intval ($data['showheight']) . "',
				'" . intval ($data['showwidth']) . "'
				)");
				
				return (true);
			}
			else
			{
				return (false);
			}
		}
		else
		{
			$this->cms->connection->query("UPDATE " . TAB_CNT_PPICTURES . " SET  
			picture_ref = '" . $this->cms->connection->escape_string ($data['ref']) . "',
			picture_artist = '" . $this->cms->connection->escape_string ($data['artist']) . "',
			picture_copyright = '" . $this->cms->connection->escape_string ($data['copyright']) . "',
			picture_date = '" . $this->cms->connection->escape_string ($data['date']) . "',
			picture_country = '" . $this->cms->connection->escape_string ($data['country']) . "', 
			picture_location = '" . $this->cms->connection->escape_string ($data['location']) . "',
			picture_showheight = '" . intval($data['showheight']) . "',
			picture_showwidth = '" . intval($data['showwidth']) . "'
			WHERE itemid = " . intval($this->id));
			
			return (true);
		}
	}
	public function newSpecial ($post, $parentid, $desc, $thumbnail, $excludefromnav, $visibledate, $visiblefrom, $visibleto, $visibleguest, $visiblegroups, $tags, $plugin)
	{
		$uploaddir = realpath($this->cms->bPath . "../non_html/modules/content/multiupload") . "/";
		if (is_dir($uploaddir))
		{
			$mupload = $this->getMultiFiles($uploaddir);
		}
		sort($post['multi']);
		foreach ($post['multi'] AS $image)
		{
			if (in_array($image, $mupload))
			{
				$id = $this->admin->newItem($image, $parentid, $desc, $thumbnail, $excludefromnav, $visibledate, $visiblefrom, $visibleto, $visibleguest, $visiblegroups, $tags, $plugin);
				$nfilename = $id. "_" . $image;
				$npath = $this->uploadpath . $nfilename;
				rename($uploaddir . $image, $npath);
				
				$fexp = explode ('.', $image);
				$fext = $fexp[count($fexp) - 1];
				$fsize = filesize($npath);
				
				$this->cms->connection->query("INSERT INTO " . TAB_CNT_PPICTURES . " 
				(id, itemid, file_name, file_extension, file_size, file_intname, picture_ref, picture_artist, picture_copyright, picture_date, picture_country, picture_location, picture_showheight, picture_showwidth)
				VALUES
				(null,
				'" . intval ($id) . "',
				'" . $this->cms->connection->escape_string ($post['filename']) . "',
				'" . $this->cms->connection->escape_string ($fext) . "',
				'" . intval ($fsize) . "',
				'" . $this->cms->connection->escape_string ($nfilename) . "',
				'" . $this->cms->connection->escape_string ($post['ref']) . "',
				'" . $this->cms->connection->escape_string ($post['artist']) . "',
				'" . $this->cms->connection->escape_string ($post['copyright']) . "',
				'" . $this->cms->connection->escape_string ($post['date']) . "',
				'" . $this->cms->connection->escape_string ($post['country']) . "',
				'" . $this->cms->connection->escape_string ($post['location']) . "',
				'" . intval ($post['showheight']) . "',
				'" . intval ($post['showwidth']) . "'
				)");
			}
		}
		return true;
	}
	/**
	 * delete an instance of picture
	 *
	 */
	public function delete ()
	{
		$QE = $this->cms->connection->query("SELECT * FROM " . TAB_CNT_PPICTURES . " WHERE itemid = " . intval($this->id));
		$res = $this->cms->connection->fetch_assoc($QE);
		if ($dh = opendir($this->uploadpath))
   		{
			while (($file = readdir($dh)) !== false) 
			{
				if (substr($file, 0, strlen($this->id)) == $this->id AND !empty($res['file_intname']) AND is_file($this->uploadpath . $file))
				{
					$matches = array();
					preg_match('/([0-9]*)_.*/', $file, $matches);
					if ($matches[1] == $this->id)
					{
						unlink($this->uploadpath . $file);
					}	
				}
			}
        }
		$this->cms->connection->query("DELETE FROM " . TAB_CNT_PPICTURES . " WHERE itemid = " . intval($this->id));
	}
	/**
	 * return the extension for this module
	 *
	 * @return string
	 */
	public function getExtension ()
	{
		return ('.pct');
	}
	/**
	 * shows form for editing or creating a picture
	 *
	 * @return string
	 */
	public function getForm ()
	{
		if ($this->id == 'new')
		{
			/*
			 * multiupload check
			 */
			$multiupload = true;
			$uploaddir = realpath($this->cms->bPath . "../non_html/modules/" . $this->cms->module->moduledir . "/multiupload") . "/";
			$multiupload = false;
			if (is_dir($uploaddir))
			{
				$mupload = $this->getMultiFiles($uploaddir);
				if (count($mupload) > 0)
				{
					$multiupload = true;
				}
			}
			
			$picform = new Smarty();
			$picform->template_dir = $this->cms->bPath . "../non_html/modules/" . $this->cms->module->moduledir . "/templates/plugins";
			$picform->compile_dir = $this->cms->templates->compileddir;
			$picform->assign('lang', $this->cms->languages->lang);
			$picform->assign('mlang', $this->cms->module->lang);
			$picform->assign('baseurl', BASE_URL);
			$picform->assign('upload', $this->cms->filemanagement->showUploadFrontEnd('pdata[filename]'));
			$picform->assign('multiupload', $multiupload);
			$picform->assign('mupload', $mupload);
			return ($picform->fetch('adm.pct.new.tpl'));
		}
		else
		{
			$picform = new Smarty();
			$picform->template_dir = $this->cms->bPath . "../non_html/modules/" . $this->cms->module->moduledir . "/templates/plugins";
			$picform->compile_dir = $this->cms->templates->compileddir;
			$picform->assign('lang', $this->cms->languages->lang);
			$picform->assign('mlang', $this->cms->module->lang);
			$picform->assign('baseurl', BASE_URL);
			$picform->assign('picture', $this->picture);
			return ($picform->fetch('adm.pct.edit.tpl'));
		}
	}
	/**
	 * get extra stuff
	 *
	 * @return string
	 */
	public function getExtra ()
	{
		return($this->cms->filemanagement->showUploadTop());
	}
}


?>