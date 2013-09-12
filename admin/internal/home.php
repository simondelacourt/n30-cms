<?php
/**
 * n30-cms admin: home
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
 * Home page for admin
 * 
 * ------------------------------------------------------------------------------------
 * Author: Simon de la Court
 * 
 */
class adminhome
{
	private $cms;
	public function __construct (&$cms)
	{
		$this->cms = &$cms;
	}
	public function show ($mode, $args)
	{
		// page title
		$this->cms->pageTitle = $this->cms->languages->lang['adminlang']['hometitle'];
		
		$home = new Smarty();
		$home->template_dir = $this->cms->bPath . "./template";
		$home->compile_dir = $this->cms->bPath . "./template/compiled";
		$home->assign('lang', $this->cms->languages->lang);
		$home->assign('baseurl', BASE_URL);
		return ($home->fetch('home.tpl'));
	}
}
?>