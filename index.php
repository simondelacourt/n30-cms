<?php
error_reporting(E_ALL);
require_once 'includes.php';
$cms = new n30();
$cms->forceDebugMode();
$cms->loadModule('content');
$url2 = "/";
if (isset($_SERVER['PATH_INFO']))
{
	$url = explode('/', substr($_SERVER['PATH_INFO'], 1));
	$urlr = $_SERVER['PATH_INFO'];
	if (isset($url[0]))
	{
		
		$url2 = "/" . $url[0];
		if (! $cms->modules['content']->isDir($url2))
		{
			$url2 = '/';
		}
		$urla = "/" . $url[0];
	}
	if (isset($url[0]) and isset($url[1]))
	{
		$urla2 = "/" . $url[0] . "/" . $url[1];
		if ($url[0] == 'int')
		{
			$intdata = explode(';', $url[1]);
			$narr = array();
			foreach ($intdata AS $int)
			{
				$p = explode (':', $int);
				if (isset($p[0]) AND isset($p[1]))
				$narr[$p[0]] = $p[1];
			}
		}
	} else
	{
		$urla2 = "/";
	}
	if (count($url) > 2)
	{
		$url3 = $urlr;
	} else
	{
		$url3 = "/";
	}
} else
{
	$url = array();
	$urlr = "/";
	$urla = "/";
}
if (isset($cms->modules['content']))
{
	if (!isset($narr))
	{
		$cms->modules['content']->showLocation($urlr, 'mod');
	}
	else
	{
		$cms->modules['content']->showInternal($narr);
	}
	$mainmenu = $cms->modules['content']->getMenu("/", $urla);
	$cms->fulltemplate->assign('mainmenu', $mainmenu);
	if (isset($url2) and $url2 != "/")
	{
		$submenu = $cms->modules['content']->getMenu($url2, $urla2);
		$cms->fulltemplate->assign('submenu', $submenu);
	}
	if (isset($url3) and $url3 != "/")
	{
		$contextmenu = $cms->modules['content']->getMenu($url3, $urla2);
		$cms->fulltemplate->assign('contextmenu', $contextmenu);
	}
}
?>