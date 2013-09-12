<?php

/**
 * n30-cms admin: filemanagement
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
 * Management of files for web-end
 * 
 * ------------------------------------------------------------------------------------
 * Author: Simon de la Court
 * 
 */
class filemanagement
{

	private $cms;

	private $uploaddir;

	public function __construct (&$cms)
	{
		$this->cms = $cms;
		$this->uploaddir = $this->cms->bPath . "ftemp/";
	}
	/**
	 * check if file exists in temp
	 *
	 * @param unknown_type $file
	 * @return unknown
	 */
	public function fileExists ($file)
	{
		if (is_file($this->uploaddir . $file))
		{
			return (true);
		} 
		else
		{
			return (false);
		}
	}
	/**
	 * clean up old temp files
	 *
	 */
	public function cleanGarbage ()
	{
   		if ($dh = opendir($this->uploaddir))
   		{
			while (($file = readdir($dh)) !== false) 
			{
				if ($file != "." AND $file != ".." AND $file != ".svn")
				{
            		$last_modified = filemtime($this->uploaddir . $file); 
					if ($last_modified < date("YmdH") - 1)
					{
						echo 'gotta delete';
						unlink($this->uploaddir . $file);
					}
				}
            	
			}
        }
        closedir($dh);
	}
	/**
	 * move file into place from temp
	 *
	 * @param unknown_type $filename
	 * @param unknown_type $to
	 */
	public function moveintoplace ($filename, $to)
	{
		// TODO: requires some checks and shit
		rename($this->uploaddir . $filename, $to);
	}
	/**
	 * show upload backend
	 *
	 */
	public function showUploadBackend ()
	{
		$this->cleanGarbage();
		if (isset($_POST['fileframe']))
		{
			$this->cms->blockOutput();
			$result = 'ERROR';
			$result_msg = 'No FILE field found';
			if (isset($_FILES['file'])) // file was send from browser
			{
				if ($_FILES['file']['error'] == UPLOAD_ERR_OK) // no error
				{
					$filename = $_FILES['file']['name']; // file name 
					move_uploaded_file($_FILES['file']['tmp_name'], $this->uploaddir . '/' . $filename);
					$result = 'OK';
				} elseif ($_FILES['file']['error'] == UPLOAD_ERR_INI_SIZE)
				{
					$result_msg = 'The uploaded file exceeds the upload_max_filesize directive in php.ini';
				} else
				{
					$result_msg = 'Unknown error';
				}
			}
			echo '<html><head><title>-</title></head><body>';
			echo '<script language="JavaScript" type="text/javascript">' . "\n";
			echo 'var parDoc = window.parent.document;';
			if ($result == 'OK')
			{
				echo 'parDoc.getElementById("upload_status").value = "file successfully uploaded";';
				echo 'parDoc.getElementById("filename").value = "' . htmlspecialchars($filename) . '";';
				echo 'parDoc.getElementById("filenamei").value = "' . htmlspecialchars($filename) . '";';
				echo 'parDoc.getElementById("itemtitle").value = "' . htmlspecialchars($filename) . '";';
				echo 'parDoc.getElementById("upload_button").disabled = false;';
			} 
			else
			{
				echo 'parDoc.getElementById("upload_status").value = "ERROR: ' . $result_msg . '";';
			}
			echo "\n" . '</script></body></html>';
			exit();
		}
	}
	/**
	 * show upload top
	 *
	 * @return unknown
	 */
	public function showUploadTop ()
	{
		$form = new Smarty();
		$form->template_dir = $this->cms->bPath . "./template/upload";
		$form->compile_dir = $this->cms->bPath . "./template/compiled";
		$form->assign('baseurl', BASE_URL);
		$form->assign('lang', $this->cms->languages->lang);
		return ($form->fetch('uploadtop.tpl'));
	}
	/**
	 * show upload front end
	 *
	 * @param unknown_type $filenamefield
	 * @return unknown
	 */
	public function showUploadFrontEnd ($filenamefield = 'filename')
	{
		$form = new Smarty();
		$form->template_dir = $this->cms->bPath . "./template/upload";
		$form->compile_dir = $this->cms->bPath . "./template/compiled";
		$form->assign('baseurl', BASE_URL);
		$form->assign('filenamefield', $filenamefield);
		$form->assign('lang', $this->cms->languages->lang);
		return ($form->fetch('uploadform.tpl'));
	}
}
?>