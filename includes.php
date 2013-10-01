<?php
/**
 * n30-cms includes
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
 * All frontend includes
 * 
 * ------------------------------------------------------------------------------------
 * Author: Simon de la Court
 * 
 */
require_once './settings/base.cfg.php';
require_once './settings/sql.cfg.php';
require_once './settings/sessions.cfg.php';
require_once './settings/dirs.cfg.php';
require_once './non_html/framework/base.php';
require_once './non_html/framework/exceptions.php';
require_once './non_html/framework/sessions.php';
require_once './non_html/framework/templates.php';
require_once './non_html/framework/languages.php';
require_once './non_html/framework/legacy.php';
require_once './non_html/framework/settings.php';
require_once './non_html/framework/user.php';
require_once './non_html/framework/users.php';
require_once './non_html/framework/akismet.php';
require_once './non_html/Smarty/Smarty.class.php';
require_once './non_html/sqlconnectors/mysqli.con.php';
error_reporting(E_ALL);
?>