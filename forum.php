<?php
require_once 'includes.php';
$cms = new n30();
$cms->forceDebugMode();
$cms->loadModule('forum');
$cms->showModule('forum');
?>