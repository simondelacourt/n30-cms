<?php
/**
 * n30-cms admin: frontend: modules
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
 * Show admin modules
 * 
 * ------------------------------------------------------------------------------------
 * Author: Simon de la Court
 * 
 */
require_once './includes.php';
if (isset($_SERVER['PATH_INFO']))
{
	$url = explode('/', substr($_SERVER['PATH_INFO'], 1));
	if (isset($url[0]) and !empty($url[0]))
	{
		$admin = new admin($url[0]);
		// load module
		$admin->loadModule(strip_tags($url[0]));
		$args = array();
		if (isset($url[1]))
		{
			$function = strip_tags($url[1]);
		}
		else 
		{
			$function = '';
		}
		
		if (isset($url[2]))
		{
			$args['id'] = $url[2];
		}
		if (isset($url[3]))
		{
			$args['page'] = $url[3];
		}
		
		$admin->showModule($function, $args);

		} else
	{
		$admin = new admin();
	}
} else
{
	$admin = new admin();
}
?>