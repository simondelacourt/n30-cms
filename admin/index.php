<?php
/**
 * n30-cms admin: frontend: home
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
 * Show admin home
 * 
 * ------------------------------------------------------------------------------------
 * Author: Simon de la Court
 * 
 */
require_once './includes.php';
$admin = new admin();
$admin->loadAdminModule("home");
$admin->showModule("home");
?>