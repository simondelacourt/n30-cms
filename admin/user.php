<?php
/**
 * n30-cms admin: frontend: user
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
 * Manage your own user stuff
 * 
 * ------------------------------------------------------------------------------------
 * Author: Simon de la Court
 * 
 */
require_once './includes.php';
if (isset($_SERVER['PATH_INFO']))
{
	$url = explode('/', substr($_SERVER['PATH_INFO'], 1));
	if (isset($url[0]) and ! empty($url[0]))
	{
		$admin = new admin($url[0]);
	} else
	{
		$admin = new admin();
	}
} else
{
	$admin = new admin();
}
$admin->loadAdminModule("user");
if (isset($url[0]) AND $url[0] == "logout")
{
	$admin->showModule("logout");
}
?>