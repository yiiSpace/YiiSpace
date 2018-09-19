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
) ENGINE=InnoDB AUTO_INCREMENT=67 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `user` */

insert  into `user`(`id`,`username`,`auth_key`,`password_hash`,`password_reset_token`,`email`,`status`,`created_at`,`updated_at`) values (30,'sdfsadf','sdfsdf的','sdgasdg','到底到底','',10,1427251792,1427495301),(40,'sdfsadf','啥地方撒的','斯蒂芬森','到底dweweweew','yiqing_95@qq.com',10,1427260644,1428579274),(41,'水电费','撒旦法','sdfgds ','到底到底','hjkhjkljhk',10,1427261922,1428579329),(55,'dfasdf','点对点','sdgasdg','ertrtyrty','',10,1427495206,1428569169),(58,'jjjjj','啥地方撒的','啥地方撒的','ertrtyrty','yiqing_95@qq.com',10,1427523319,1428532909),(61,'dfasdf','sdfsdfooooo','啥地方撒的','','',10,1428506316,1428532870),(65,'dfasdf','','啥地方撒的','到底dweweweew','',10,1428539790,1428539800),(66,'sdfsadf','sdfsdfooooo','地方','到底','水电费',10,1428569153,1428569153);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
