<?php
/*************************************************/
/** n30-cms config                              **/
/** Config title: gallery.mod                   **/
/** (C) 2005 Jackabuzah                         **/
/*************************************************/
define('TAB_MGAL_CATEGORIES', T_PREFIX . 'mgal_categories');
define('TAB_MGAL_GALLERIES', T_PREFIX . 'mgal_galleries');
define('TAB_MGAL_PHOTOS', T_PREFIX . 'mgal_photos');
define('GALLERY_P_LINE', '2');
define('GALLERY_P_DIR', './img/');
define('GALLERY_URL', BASE_URL . 'img/');
define('GALLERY_FILE_VGALL', 'image/');
define('P_STRIP_SIZE', 3); // the photostrip will be TWICE this size, plus one (the actual picture)
define('GALLERY_DIR_CACHE', './cache/gallery/')?>