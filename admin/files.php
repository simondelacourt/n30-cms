<?php
/**
 * n30-cms admin: frontend: files
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
 * Show admin modules on files
 * 
 * ------------------------------------------------------------------------------------
 * Author: Simon de la Court
 * 
 */
require_once './includes.php';
$adm = new admin("");

if (isset($_POST['fileframe']))
{
	$adm->filemanagement->showUploadBackend();
}
elseif (isset($_GET['form']))
{
	$adm->adminTemplate->assign('mod', $adm->filemanagement->showUploadFrontEnd());
}
else
{
	$adm->blockOutput();
}
?>