<?php
/**
 * n30-cms content plugin: file
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
define('TAB_CNT_PFILES', T_PREFIX . 'cnt_pfiles');

class cPlugin_file
{
	private $cms;
	private $itemid;
	private $uploadpath;
	
	public function __construct (&$cms, $itemid)
	{
		$this->cms = &$cms;
		$this->itemid = $itemid;
		$this->cms->blockOutput();
		$this->uploadpath = $this->cms->bPath . "/non_html/modules/content/files/";
		
		$QE = $this->cms->connection->query("SELECT * FROM " . TAB_CNT_PFILES . " WHERE itemid = " . intval($this->itemid));
		$res = $this->cms->connection->fetch_assoc($QE);
		$fp = fopen($this->uploadpath . $res['file_intname'], 'rb');
		
		$name = $res['file_name'];
		
		if (strstr($_SERVER['HTTP_USER_AGENT'], "MSIE"))
		{
        	$name = preg_replace('/\./', '%2e', $name, substr_count($name, '.') - 1);
		}

	    //required, or it might try to send the serving     //document instead of the file
	
	    header("Cache-Control: ");
	    header("Pragma: ");
	    header("Content-Type: application/octet-stream");
	    header("Content-Length: " . (string) (filesize($this->uploadpath . $res['file_intname'])) );
	    header('Content-Disposition: attachment; filename="'.$name.'"');
	    header("Content-Transfer-Encoding: binary\n");
		
		
		fpassthru($fp);
		fclose($fp);
	}
	public function getOutput ($viewmode = '')
	{
		return (null);
	}
}
class cAPlugin_file
{
	private $cms;
	private $id;
	private $ok = false;
	private $uploadpath;
	
	
	public $rExtra = true;
	public function __construct (&$cms, $id, $admin)
	{
		$this->cms = &$cms;
		$this->id = intval($id);
		if ($id != 'new')
		{
			// lalalalal
		
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
		return (true);
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
				
				$this->cms->connection->query("INSERT INTO " . TAB_CNT_PFILES . " (id, itemid, file_name, file_extension, file_size, file_intname)
				VALUES
				(null,
				'" . intval ($data['iid']) . "',
				'" . $this->cms->connection->escape_string ($data['filename']) . "',
				'" . $this->cms->connection->escape_string ($fext) . "',
				'" . intval ($fsize) . "',
				'" . $this->cms->connection->escape_string ($nfilename) . "'
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
			return (true);
		}
	}
	/**
	 * delete an instance of file
	 *
	 */
	public function delete ()
	{
		$QE = $this->cms->connection->query("SELECT * FROM " . TAB_CNT_PFILES . " WHERE itemid = " . intval($this->id));
		$res = $this->cms->connection->fetch_assoc($QE);
		if (is_file($this->uploadpath . $res['file_intname']) AND !empty($res['file_intname']))
		{
			unlink($this->uploadpath . $res['file_intname']);
		}
		$this->cms->connection->query("DELETE FROM " . TAB_CNT_PFILES . " WHERE itemid = " . intval($this->id));
	}
	public function getExtension ()
	{
		return ('.cfl');
	}
	/**
	 * shows form for editing or creating a page
	 *
	 * @return strnig
	 */
	public function getForm ()
	{
		if ($this->id == 'new')
		{
			return($this->cms->filemanagement->showUploadFrontEnd('pdata[filename]'));
		}
		else
		{
			return ("<input type='hidden' name='pdata[none]' value='none'/>");
		}
	}
	public function getExtra ()
	{
		return($this->cms->filemanagement->showUploadTop());
	}
}
?>