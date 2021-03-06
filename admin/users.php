<?php
/**
 * n30-cms admin: frontend: users
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
 * Manage users
 * 
 * ------------------------------------------------------------------------------------
 * Author: Simon de la Court
 * 
 */
require_once './includes.php';
$admin = new admin("users");
$admin->loadAdminModule("users");
if (isset($_SERVER['PATH_INFO']))
{
	$url = explode('/', substr($_SERVER['PATH_INFO'], 1));
	
	if (count($url) == 1)
	{
		$admin->showModule($url[0]);
	}
	elseif (count($url) > 1)
	{
		$args['id'] = $url[1];
		if (isset($url[2]))
		{
			$args['page'] = $url[2];
		}
		$admin->showModule($url[0], $args);
	}
	else
	{
		$admin->showModule("default");
	}
}
?>