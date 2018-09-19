/*
SQLyog Ultimate v11.11 (64 bit)
MySQL - 5.6.21-log : Database - yiispace
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`yiispace` /*!40100 DEFAULT CHARACTER SET utf8 */;

USE `yiispace`;

/*Table structure for table `migration` */

DROP TABLE IF EXISTS `migration`;

CREATE TABLE `migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `migration` */

insert  into `migration`(`version`,`apply_time`) values ('m000000_000000_base',1425565103),('m130524_201442_init',1425565107);

/*Table structure for table `tbl_admin_menu` */

DROP TABLE IF EXISTS `tbl_admin_menu`;

CREATE TABLE `tbl_admin_menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `root` int(11) DEFAULT NULL,
  `lft` int(11) NOT NULL,
  `rgt` int(11) NOT NULL,
  `lvl` smallint(5) NOT NULL,
  `name` varchar(60) NOT NULL,
  `url` varchar(255) DEFAULT NULL,
  `icon` varchar(255) DEFAULT NULL,
  `icon_type` tinyint(1) NOT NULL DEFAULT '1',
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `selected` tinyint(1) NOT NULL DEFAULT '0',
  `disabled` tinyint(1) NOT NULL DEFAULT '0',
  `readonly` tinyint(1) NOT NULL DEFAULT '0',
  `visible` tinyint(1) NOT NULL DEFAULT '1',
  `collapsed` tinyint(1) NOT NULL DEFAULT '0',
  `movable_u` tinyint(1) NOT NULL DEFAULT '1',
  `movable_d` tinyint(1) NOT NULL DEFAULT '1',
  `movable_l` tinyint(1) NOT NULL DEFAULT '1',
  `movable_r` tinyint(1) NOT NULL DEFAULT '1',
  `removable` tinyint(1) NOT NULL DEFAULT '1',
  `removable_all` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `tbl_admin_menu_NK1` (`root`),
  KEY `tbl_admin_menu_NK2` (`lft`),
  KEY `tbl_admin_menu_NK3` (`rgt`),
  KEY `tbl_admin_menu_NK4` (`lvl`),
  KEY `tbl_admin_menu_NK5` (`active`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

/*Data for the table `tbl_admin_menu` */

insert  into `tbl_admin_menu`(`id`,`root`,`lft`,`rgt`,`lvl`,`name`,`url`,`icon`,`icon_type`,`active`,`selected`,`disabled`,`readonly`,`visible`,`collapsed`,`movable_u`,`movable_d`,`movable_l`,`movable_r`,`removable`,`removable_all`) values (1,1,1,2,0,'sdfsdf',NULL,'',1,1,1,0,1,1,1,1,1,1,1,1,1),(2,2,1,6,0,'kkk','keybu','',1,1,1,0,0,1,0,0,0,0,0,0,0),(3,2,3,4,2,'你好','sdfsdf','',1,1,1,0,0,1,1,0,0,0,0,0,0),(4,4,1,6,0,'sdfsdf','','',1,1,1,0,0,1,1,0,0,0,0,0,0),(5,4,2,3,1,'shenm','danting','',1,1,1,0,0,1,1,0,0,0,0,0,0),(6,2,2,5,1,'用户管理','/user/admin/helo','',1,1,1,0,0,1,1,0,0,0,0,0,0),(7,4,4,5,1,'可以不','水电费水电费','',1,0,0,0,0,0,0,0,0,0,0,0,0);

/*Table structure for table `user` */

DROP TABLE IF EXISTS `user`;

CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `auth_key` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `password_hash` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password_reset_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` smallint(6) NOT NULL DEFAULT '10',
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=47 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `user` */

insert  into `user`(`id`,`username`,`auth_key`,`password_hash`,`password_reset_token`,`email`,`status`,`created_at`,`updated_at`) values (9,'nihaomefff','sdfsdfooooo','到底','','',10,1427119185,1427256770),(25,'dfasdf','sdfsdf','','','',10,1427249919,1427253809),(29,'dddf','','刚回家很健康','','方法',10,1427251271,1427253858),(30,'sdfsadf','sdfsdf的','sdgasdg','到底到底','',10,1427251792,1427270032),(31,'sdfsadf','sdfsdfooooo','','','',10,1427251792,1427251812),(36,'sdfasd','','','','hjkhjkljhk',10,1427253436,1427253476),(37,'sdgdfgdfg','似懂非懂','啥地方撒的','水电费','水电费',10,1427253437,1427254219),(38,'额发的 ','地方','地方','','',10,1427256752,1427258407),(39,'的说法是地方','到底','','','',10,1427258364,1427258394),(40,'sdfsadf','啥地方撒的','斯蒂芬森','','',10,1427260644,1427260655),(41,'水电费','撒旦法','sdfgds ','','',10,1427261922,1427386184),(42,'sdfsadf','','','','',10,1427269950,1427269962),(43,'是否','','','手动','',10,1427270006,1427270006),(45,'dfasdf','','','','',10,1427386154,1427386154),(46,'sdfs ','','','','',10,1427386311,1427386311);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
