<?php
/*************************************************/
/** n30-cms config                              **/
/** Config title: news.mod                      **/
/** (C) 2005 Jackabuzah                         **/
/*************************************************/
/* --- tables --- */
define('TAB_MNWS_ART', T_PREFIX . 'mnws_art');
define('TAB_MNWS_CATSUBS', T_PREFIX . 'mnws_catsubs');
define('TAB_MNWS_CATS', T_PREFIX . 'mnws_cats');
define('TAB_MNWS_REPLIES', T_PREFIX . 'mnws_replies');
define('MOD_MNWS_ANSPM_TIME', time() + 60);
define('MOD_MNWS_ANSPM_TITLE', 'n30_antispam');
define('MNWS_URL_STYLE', 'slashes'); /* either slashes or get */
define('MNWS_URL_EXT', ''); /* either slashes or get */
define('MNWS_NEWS_FILE', 'index'); /* either slashes or get */
define('MNWS_ARCHIVE_AMOUNT', 200);
?>