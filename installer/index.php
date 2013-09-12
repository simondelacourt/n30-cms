<?php
echo 'hi';

include "./backend.php";
include "../non_html/Smarty-2.6.19/Smarty.class.php";
$i = new installer();
$i->checkWritable('settings/base.cfg.php');
$i->checkWritable('non_html/modules/content/files');
$i->checkWritable('admin/template/compiled');

$i->showStepTest();
?>