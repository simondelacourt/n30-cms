<?php
/*************************************************/
/** n30-cms config                              **/
/** Config title: base                          **/
/** (C) 2005-2013 Simon de la Court             **/
/*************************************************/
error_reporting(E_ALL);
date_default_timezone_set('Europe/Amsterdam');
define('LINK_STYLE', 'multiviews'); /* --- this can be either multiviews or sglobals --- */
define('LINK_EXT', ''); /* --- this is the file extension in links refered to --- */
define('BASE_URL', 'http://localhost/php-projects/n30-cms/');
define('TEM_URL_MODE', 'regexp'); /* --- mode: regexp; regular expressions or normal; is an easy checking system --- */
define('ADMIN_EMAIL', 'simon@delacourt.co.uk');
/* --- template config --- */
define('TPL_MFILE', 'index.tpl'); /* --- this file is the main template file --- */
define('CONNECTOR', 'mysqli'); /* --- which connector does n30-cms use --- */
define('SQL_HOST', '127.0.0.1'); /* --- the SQL connectors hostname      --- */
define('SQL_USER', 'root'); /* --- the SQL connectors username      --- */
define('SQL_PASS', ''); /* --- the SQL connectors password      --- */
define('SQL_DATB', 'n30_06'); /* --- the SQL connectors database      --- */

define('USER_SALT', 'longsentencemakingithardtounderstandstuff');
?>