# ************************************************************
# Sequel Pro SQL dump
# Version 4096
#
# http://www.sequelpro.com/
# http://code.google.com/p/sequel-pro/
#
# Host: 127.0.0.1 (MySQL 5.5.17)
# Database: n30_06
# Generation Time: 2013-10-01 15:27:34 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table n30_admin_xs
# ------------------------------------------------------------

CREATE TABLE `n30_admin_xs` (
  `id` mediumint(255) NOT NULL AUTO_INCREMENT,
  `ownertype` enum('user','group') NOT NULL DEFAULT 'user',
  `ownerid` mediumint(255) NOT NULL DEFAULT '0',
  `accessto` varchar(255) NOT NULL DEFAULT '',
  KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;



# Dump of table n30_cnt_pfiles
# ------------------------------------------------------------

CREATE TABLE `n30_cnt_pfiles` (
  `id` mediumint(255) NOT NULL AUTO_INCREMENT,
  `itemid` mediumint(255) NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `file_extension` varchar(255) NOT NULL,
  `file_size` mediumint(255) NOT NULL,
  `file_intname` varchar(255) NOT NULL,
  KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;



# Dump of table n30_cnt_plink
# ------------------------------------------------------------

CREATE TABLE `n30_cnt_plink` (
  `id` mediumint(255) NOT NULL AUTO_INCREMENT,
  `itemid` mediumint(255) NOT NULL,
  `link` text NOT NULL,
  `mode` enum('forward','newwindow','iframe','intlink') NOT NULL DEFAULT 'forward',
  `hits` mediumint(255) NOT NULL DEFAULT '0',
  KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;



# Dump of table n30_cnt_pnews
# ------------------------------------------------------------

CREATE TABLE `n30_cnt_pnews` (
  `id` mediumint(255) NOT NULL AUTO_INCREMENT,
  `itemid` mediumint(255) NOT NULL,
  `news_short` text NOT NULL,
  `news_full` text NOT NULL,
  `news_tags` text NOT NULL,
  `replies_on` enum('true','false') NOT NULL DEFAULT 'false',
  `replies_guests` enum('true','false') NOT NULL DEFAULT 'false',
  `replies_groups` text NOT NULL,
  `replies_count` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;



# Dump of table n30_cnt_pnews_replies
# ------------------------------------------------------------

CREATE TABLE `n30_cnt_pnews_replies` (
  `id` mediumint(255) NOT NULL AUTO_INCREMENT,
  `itemid` mediumint(255) NOT NULL,
  `news_id` mediumint(255) NOT NULL,
  `poster_id` mediumint(255) NOT NULL,
  `poster_ip` varchar(255) NOT NULL,
  `poster_name` varchar(255) NOT NULL,
  `message_raw` text NOT NULL,
  `message_processed` text NOT NULL,
  `message_crdate` datetime NOT NULL,
  `message_update` datetime NOT NULL,
  `message_spam` enum('true','false') NOT NULL DEFAULT 'false',
  `poster_email` varchar(255) DEFAULT NULL,
  `poster_url` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;



# Dump of table n30_cnt_ppage
# ------------------------------------------------------------

CREATE TABLE `n30_cnt_ppage` (
  `id` mediumint(255) NOT NULL AUTO_INCREMENT,
  `itemid` mediumint(255) NOT NULL,
  `page` longtext NOT NULL,
  KEY `id` (`id`),
  FULLTEXT KEY `page` (`page`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;



# Dump of table n30_cnt_ppictures
# ------------------------------------------------------------

CREATE TABLE `n30_cnt_ppictures` (
  `id` mediumint(255) NOT NULL AUTO_INCREMENT,
  `itemid` mediumint(255) NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `file_extension` varchar(255) NOT NULL,
  `file_size` mediumint(255) NOT NULL,
  `file_intname` varchar(255) NOT NULL,
  `picture_ref` varchar(255) NOT NULL,
  `picture_artist` text NOT NULL,
  `picture_copyright` text NOT NULL,
  `picture_date` varchar(255) NOT NULL,
  `picture_country` varchar(255) NOT NULL,
  `picture_location` varchar(255) NOT NULL,
  `picture_showheight` mediumint(255) NOT NULL,
  `picture_showwidth` mediumint(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;



# Dump of table n30_cnt_ppicturesoverview
# ------------------------------------------------------------

CREATE TABLE `n30_cnt_ppicturesoverview` (
  `id` mediumint(255) NOT NULL AUTO_INCREMENT,
  `itemid` mediumint(255) NOT NULL,
  `directory_id` mediumint(255) NOT NULL,
  `picture_perline` mediumint(10) NOT NULL,
  `picture_maxwidth` mediumint(9) NOT NULL,
  `picture_maxheight` mediumint(9) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;



# Dump of table n30_cnt_ppicturesslideshow
# ------------------------------------------------------------

CREATE TABLE `n30_cnt_ppicturesslideshow` (
  `id` mediumint(255) NOT NULL AUTO_INCREMENT,
  `itemid` mediumint(255) NOT NULL,
  `directory_id` mediumint(255) NOT NULL,
  `duration` mediumint(255) NOT NULL,
  `picture_maxwidth` mediumint(255) NOT NULL,
  `picture_maxheight` mediumint(255) NOT NULL,
  `thumbnail_maxwidth` mediumint(255) NOT NULL,
  `thumbnail_maxheight` mediumint(255) NOT NULL,
  `show_imgstrip` enum('0','1') NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;



# Dump of table n30_cnt_structure
# ------------------------------------------------------------

CREATE TABLE `n30_cnt_structure` (
  `id` mediumint(255) NOT NULL AUTO_INCREMENT,
  `id_parent` mediumint(255) NOT NULL,
  `full_location` text NOT NULL,
  `full_title` text NOT NULL,
  `int_title` text NOT NULL,
  `user_author` mediumint(255) NOT NULL,
  `cr_date` datetime NOT NULL,
  `str_type` enum('dir','plugin') NOT NULL DEFAULT 'dir',
  `str_plugin` varchar(255) NOT NULL,
  `visible_from` datetime NOT NULL,
  `visible_to` datetime NOT NULL,
  `visible_date` enum('true','false') NOT NULL DEFAULT 'false',
  `excludefromnav` enum('true','false') NOT NULL DEFAULT 'false',
  `visible_guest` enum('yes','no') NOT NULL DEFAULT 'yes',
  `visible_group` text NOT NULL,
  `dir_indexes` enum('true','false') NOT NULL DEFAULT 'true',
  `dir_indexfile` mediumint(255) NOT NULL,
  `tags` text NOT NULL,
  `sortorder` mediumint(255) NOT NULL,
  `description` text NOT NULL,
  `thumbnail` text NOT NULL,
  KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;



# Dump of table n30_lang
# ------------------------------------------------------------

CREATE TABLE `n30_lang` (
  `id` mediumint(255) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL DEFAULT '',
  `dir` varchar(255) NOT NULL DEFAULT '',
  `def` enum('true','false') NOT NULL DEFAULT 'false',
  KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;



# Dump of table n30_perssettings
# ------------------------------------------------------------

CREATE TABLE `n30_perssettings` (
  `id` mediumint(255) NOT NULL AUTO_INCREMENT,
  `user_id` mediumint(255) NOT NULL,
  `setting_id` mediumint(255) NOT NULL,
  `value` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;



# Dump of table n30_sessions
# ------------------------------------------------------------

CREATE TABLE `n30_sessions` (
  `id` mediumint(255) NOT NULL AUTO_INCREMENT,
  `sessionstring` varchar(64) NOT NULL DEFAULT '',
  `ip` varchar(255) NOT NULL DEFAULT '',
  `strtdate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `userid` mediumint(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;



# Dump of table n30_settings
# ------------------------------------------------------------

CREATE TABLE `n30_settings` (
  `id` mediumint(255) NOT NULL AUTO_INCREMENT,
  `type` enum('bool','string','int') NOT NULL DEFAULT 'bool',
  `name` varchar(255) NOT NULL DEFAULT '',
  `category_name` varchar(255) NOT NULL DEFAULT '',
  `reg_value` text NOT NULL,
  `deleteable` enum('true','false') NOT NULL DEFAULT 'true',
  KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;



# Dump of table n30_templates
# ------------------------------------------------------------

CREATE TABLE `n30_templates` (
  `id` mediumint(255) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL DEFAULT '',
  `dir` varchar(255) NOT NULL DEFAULT '',
  `def` enum('true','false') NOT NULL DEFAULT 'false',
  KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;



# Dump of table n30_tracks
# ------------------------------------------------------------

CREATE TABLE `n30_tracks` (
  `id` mediumint(255) NOT NULL AUTO_INCREMENT,
  `userid` mediumint(255) NOT NULL DEFAULT '0',
  `tsession` varchar(255) NOT NULL DEFAULT '',
  `user_ip` varchar(16) NOT NULL DEFAULT '',
  `user_referer` text NOT NULL,
  `user_url` text NOT NULL,
  `user_os` varchar(255) NOT NULL DEFAULT '',
  `user_platform` varchar(255) NOT NULL DEFAULT '',
  `user_browser` varchar(255) NOT NULL DEFAULT '',
  `user_agent` text NOT NULL,
  `track_module` varchar(255) NOT NULL DEFAULT '',
  `track_type` varchar(255) NOT NULL DEFAULT '',
  `track_id` mediumint(255) NOT NULL DEFAULT '0',
  `track_code` varchar(255) NOT NULL DEFAULT '',
  `track_year` smallint(6) NOT NULL DEFAULT '0',
  `track_month` tinyint(4) NOT NULL DEFAULT '0',
  `track_yearmonth` mediumint(6) NOT NULL DEFAULT '0',
  `track_day` tinyint(4) NOT NULL DEFAULT '0',
  `track_hour` tinyint(2) NOT NULL DEFAULT '0',
  `track_minute` tinyint(2) NOT NULL DEFAULT '0',
  `track_seconds` tinyint(2) NOT NULL DEFAULT '0',
  KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;



# Dump of table n30_users
# ------------------------------------------------------------

CREATE TABLE `n30_users` (
  `id` mediumint(9) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL DEFAULT '',
  `pass` varchar(32) NOT NULL DEFAULT '',
  `unid` varchar(64) NOT NULL DEFAULT '',
  `email` varchar(255) NOT NULL DEFAULT '',
  `template` mediumint(255) NOT NULL DEFAULT '0',
  `lang` mediumint(255) NOT NULL DEFAULT '0',
  `activated` enum('true','false') NOT NULL DEFAULT 'false',
  `posts` mediumint(255) DEFAULT NULL,
  `avatar` text NOT NULL,
  `signature` varchar(255) NOT NULL,
  `nickdisplay` varchar(255) NOT NULL DEFAULT '[nick]',
  `name_first` varchar(255) NOT NULL,
  `name_last` varchar(255) NOT NULL,
  `login_first` datetime NOT NULL,
  `login_recent` datetime NOT NULL,
  KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='User table';



# Dump of table n30_users_gmember
# ------------------------------------------------------------

CREATE TABLE `n30_users_gmember` (
  `id` mediumint(255) NOT NULL AUTO_INCREMENT,
  `userid` mediumint(255) NOT NULL DEFAULT '0',
  `groupid` mediumint(255) NOT NULL DEFAULT '0',
  `default` enum('true','false') NOT NULL DEFAULT 'false',
  KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;



# Dump of table n30_users_groups
# ------------------------------------------------------------

CREATE TABLE `n30_users_groups` (
  `id` mediumint(255) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL DEFAULT '',
  `default` enum('true','false') NOT NULL DEFAULT 'false',
  `udefault` enum('true','false') NOT NULL DEFAULT 'false',
  KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;



# Dump of table n30_users_notes
# ------------------------------------------------------------

CREATE TABLE `n30_users_notes` (
  `id` mediumint(255) NOT NULL AUTO_INCREMENT,
  `userid` mediumint(255) NOT NULL,
  `note_creator` mediumint(255) NOT NULL,
  `note` text NOT NULL,
  `crdate` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;




/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
