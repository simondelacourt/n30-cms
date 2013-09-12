<?php
require_once 'includes.php';
$cms = new n30();
$cms->forceDebugMode();
$cms->settings->updatePersonalSetting(1, "tracker", "enabled", "false");

?>