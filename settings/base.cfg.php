<?php
/*************************************************/
/** n30-cms config                              **/
/** Config title: base                          **/
/** (C) 2005 Jackabuzah                         **/
/*************************************************/
error_reporting(E_ALL);
define('LINK_STYLE', 'multiviews'); /* --- this can be either multiviews or sglobals --- */
define('LINK_EXT', ''); /* --- this is the file extension in links refered to --- */
define('BASE_URL', 'http://192.168.178.20:4545/n30_06/');
define('TEM_URL_MODE', 'regexp'); /* --- mode: regexp; regular expressions or normal; is an easy checking system --- */
define('ADMIN_EMAIL', 'simon@delacourt.co.uk');
/* --- template config --- */
define('TPL_MFILE', 'index.tpl'); /* --- this file is the main template file --- */
define('CONNECTOR', 'mysqli'); /* --- which connector does n30-cms use --- */
define('SQL_HOST', 'localhost'); /* --- the SQL connectors hostname      --- */
define('SQL_USER', 'root'); /* --- the SQL connectors username      --- */
define('SQL_PASS', ''); /* --- the SQL connectors password      --- */
define('SQL_DATB', 'n30_06'); /* --- the SQL connectors database      --- */
?>