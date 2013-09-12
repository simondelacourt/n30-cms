<?php
require_once 'includes.php';
$cms = new n30();
$cms->forceDebugMode();
$cms->loadModule("ucontrol");
if (isset($_SERVER['PATH_INFO']) and $_SERVER['REQUEST_METHOD'] == 'GET')
{
	$url = explode('/', substr($_SERVER['PATH_INFO'], 1));
	if (isset($url[0]))
	{
		switch ($url[0])
		{
			case 'profile':
				$cms->modules['ucontrol']->showProfile("mod");
				break;
			case 'login':
				$cms->modules['ucontrol']->showLogin("mod");
				break;
			case 'logout':
				$cms->modules['ucontrol']->showLogout("mod");
				break;
		}
	}
} elseif ($_SERVER['REQUEST_METHOD'] == 'POST')
{
	$cms->modules['ucontrol']->processPost();
}
?>