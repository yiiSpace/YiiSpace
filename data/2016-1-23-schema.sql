/*
SQLyog v10.2 
MySQL - 5.6.21-log : Database - yii_space
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`yii_space` /*!40100 DEFAULT CHARACTER SET utf8 */;

USE `yii_space`;

/*Table structure for table `access_trace` */

DROP TABLE IF EXISTS `access_trace`;

CREATE TABLE `access_trace` (
  `ip` varchar(40) NOT NULL COMMENT '访问者ip',
  `space_id` int(11) DEFAULT NULL COMMENT '被访问者的空间id',
  `first_acc_time` int(11) NOT NULL COMMENT '首次访问时间',
  `last_acc_time` int(11) DEFAULT NULL COMMENT '最好一次访问时间',
  `acc_count` int(11) NOT NULL DEFAULT '0' COMMENT '访问次数',
  `acc_type` tinyint(4) NOT NULL DEFAULT '0' COMMENT '访问类型 默认是空间访问  另有后台访问，系统空间访问 公共前端访问等'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='访问追踪 以日为单位 一日内多次访问只记录第一次的';

/*Table structure for table `action_feed` */

DROP TABLE IF EXISTS `action_feed`;

CREATE TABLE `action_feed` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL COMMENT 'actor 行为者的id',
  `action_type` tinyint(3) NOT NULL DEFAULT '1' COMMENT '动作类型1表示ar_insert 2表示ar_update（跟object_type一起等价于verb语义） 3是控制器动作',
  `action_time` int(11) DEFAULT NULL COMMENT '动作的时间 注意不是ctime 是动作的时间',
  `data` text NOT NULL COMMENT '标题 和内容的数据 数组序列化后存储 含title和body的数据 原来设计为两个字段 感觉有浪费',
  `object_type` varchar(25) NOT NULL COMMENT '动作的主体 ar_class或者是当前路由(如果是当前路由时object_id可以取一个无意义的值)',
  `object_id` int(11) NOT NULL DEFAULT '0' COMMENT '动作的实体id配合object_type一起可以定位一个ar',
  `target_type` varchar(25) NOT NULL DEFAULT '' COMMENT '动作的目标 to 如添加照片to某相册',
  `target_id` int(11) NOT NULL DEFAULT '0' COMMENT '跟target_type一起可标识一个ar实体',
  `target_owner` int(11) NOT NULL DEFAULT '0' COMMENT '目标的主人一般都是自己根据verb决定',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=79 DEFAULT CHARSET=utf8 COMMENT='动态反馈表 是对某人干了什么的图文描述';

/*Table structure for table `admin_menu` */

DROP TABLE IF EXISTS `admin_menu`;

CREATE TABLE `admin_menu` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `root` int(10) unsigned DEFAULT NULL,
  `lft` int(10) unsigned NOT NULL,
  `rgt` int(10) unsigned NOT NULL,
  `level` smallint(5) unsigned NOT NULL,
  `label` varchar(255) NOT NULL,
  `url` varchar(255) DEFAULT NULL COMMENT 'url 如 array(user/create); 或者user/create  //user/create 服务端处理时要判断是否转为array 要考虑如果采用前者分号的问题 eval函数',
  `params` tinytext COMMENT 'url 后的请求参数',
  `ajaxoptions` text,
  `htmloptions` text,
  `is_visible` tinyint(1) NOT NULL DEFAULT '1',
  `uid` int(11) NOT NULL DEFAULT '0' COMMENT '谁的树 系统默认的是后台树0 ',
  `group_code` varchar(25) NOT NULL DEFAULT 'sys_admin_menu' COMMENT '归类码表示用途的 一般只需要标记根的用途即可 也可以考虑用eav 但考虑到查询问题 所以引入了此字段',
  PRIMARY KEY (`id`),
  KEY `root` (`root`),
  KEY `lft` (`lft`),
  KEY `rgt` (`rgt`),
  KEY `level` (`level`)
) ENGINE=InnoDB AUTO_INCREMENT=68 DEFAULT CHARSET=utf8 COMMENT='用nestedset保存树关系';

/*Table structure for table `admin_role` */

DROP TABLE IF EXISTS `admin_role`;

CREATE TABLE `admin_role` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL COMMENT '角色名',
  `description` text COMMENT '说明',
  `disabled` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '启用',
  `create_time` int(10) unsigned NOT NULL COMMENT '添加时间',
  `update_time` int(10) unsigned NOT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`),
  KEY `disabled` (`disabled`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;

/*Table structure for table `admin_role_priv` */

DROP TABLE IF EXISTS `admin_role_priv`;

CREATE TABLE `admin_role_priv` (
  `role_id` int(10) unsigned NOT NULL COMMENT '角色ID',
  `menu_id` int(10) unsigned NOT NULL COMMENT '菜单ID',
  PRIMARY KEY (`role_id`,`menu_id`),
  KEY `roleid` (`role_id`),
  KEY `menu_id` (`menu_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `admin_user` */

DROP TABLE IF EXISTS `admin_user`;

CREATE TABLE `admin_user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '用户ID',
  `username` varchar(50) NOT NULL COMMENT '用户名',
  `password` varchar(40) NOT NULL COMMENT '密码',
  `name` varchar(50) NOT NULL COMMENT '用户真名',
  `encrypt` char(6) NOT NULL COMMENT '加密',
  `role_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '角色',
  `disabled` tinyint(1) DEFAULT '0' COMMENT '禁用',
  `setting` text COMMENT '设置',
  `create_time` int(10) unsigned NOT NULL COMMENT '添加时间',
  `update_time` int(10) unsigned NOT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `id` (`id`),
  KEY `role_id` (`role_id`)
) ENGINE=InnoDB AUTO_INCREMENT=44 DEFAULT CHARSET=utf8;

/*Table structure for table `api_client` */

DROP TABLE IF EXISTS `api_client`;

CREATE TABLE `api_client` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `app_id` varchar(120) NOT NULL COMMENT 'appid 先定为字符串型 app_{id}',
  `app_key` varchar(64) NOT NULL COMMENT '应用的秘钥 用来加密请求 服务端用来解密请求',
  `app_name` varbinary(120) NOT NULL COMMENT '应用程序名字',
  `app_domain` varchar(255) DEFAULT NULL COMMENT '域名 如果是手机端 可以为空',
  `app_description` varchar(255) NOT NULL COMMENT '应用程序描述',
  `status` tinyint(3) NOT NULL DEFAULT '0' COMMENT '状态 0 表示未审核 1表示通过 其他值未定',
  `create_time` int(11) NOT NULL DEFAULT '0' COMMENT '创建时间 指申请提交的时间',
  `update_time` int(11) NOT NULL DEFAULT '0' COMMENT '一般是状态修改时间',
  `modifier_id` int(11) NOT NULL DEFAULT '0' COMMENT '审核者id 后台谁登陆修改其状态的',
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Table structure for table `auth_assignment` */

DROP TABLE IF EXISTS `auth_assignment`;

CREATE TABLE `auth_assignment` (
  `item_name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`item_name`,`user_id`),
  CONSTRAINT `auth_assignment_ibfk_1` FOREIGN KEY (`item_name`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Table structure for table `auth_codes` */

DROP TABLE IF EXISTS `auth_codes`;

CREATE TABLE `auth_codes` (
  `code` varchar(40) NOT NULL,
  `client_id` varchar(20) NOT NULL,
  `redirect_uri` varchar(200) NOT NULL,
  `expires` int(11) NOT NULL,
  `scope` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`code`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Table structure for table `auth_item` */

DROP TABLE IF EXISTS `auth_item`;

CREATE TABLE `auth_item` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `type` int(11) NOT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `rule_name` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `data` text COLLATE utf8_unicode_ci,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`name`),
  KEY `rule_name` (`rule_name`),
  KEY `idx-auth_item-type` (`type`),
  CONSTRAINT `auth_item_ibfk_1` FOREIGN KEY (`rule_name`) REFERENCES `auth_rule` (`name`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Table structure for table `auth_item_child` */

DROP TABLE IF EXISTS `auth_item_child`;

CREATE TABLE `auth_item_child` (
  `parent` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `child` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`parent`,`child`),
  KEY `child` (`child`),
  CONSTRAINT `auth_item_child_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `auth_item_child_ibfk_2` FOREIGN KEY (`child`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Table structure for table `auth_rule` */

DROP TABLE IF EXISTS `auth_rule`;

CREATE TABLE `auth_rule` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `data` text COLLATE utf8_unicode_ci,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Table structure for table `authassignment` */

DROP TABLE IF EXISTS `authassignment`;

CREATE TABLE `authassignment` (
  `item_name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`item_name`,`user_id`),
  CONSTRAINT `authassignment_ibfk_1` FOREIGN KEY (`item_name`) REFERENCES `authitem` (`name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Table structure for table `authitem` */

DROP TABLE IF EXISTS `authitem`;

CREATE TABLE `authitem` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `type` int(11) NOT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `rule_name` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `data` text COLLATE utf8_unicode_ci,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`name`),
  KEY `rule_name` (`rule_name`),
  KEY `idx-auth_item-type` (`type`),
  CONSTRAINT `authitem_ibfk_1` FOREIGN KEY (`rule_name`) REFERENCES `authrule` (`name`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Table structure for table `authitemchild` */

DROP TABLE IF EXISTS `authitemchild`;

CREATE TABLE `authitemchild` (
  `parent` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `child` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`parent`,`child`),
  KEY `child` (`child`),
  CONSTRAINT `authitemchild_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `authitem` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `authitemchild_ibfk_2` FOREIGN KEY (`child`) REFERENCES `authitem` (`name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Table structure for table `authrule` */

DROP TABLE IF EXISTS `authrule`;

CREATE TABLE `authrule` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `data` text COLLATE utf8_unicode_ci,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Table structure for table `badge` */

DROP TABLE IF EXISTS `badge`;

CREATE TABLE `badge` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(64) NOT NULL,
  `slug` varchar(32) NOT NULL,
  `desc` text,
  `exp` int(11) DEFAULT '0',
  `active` tinyint(1) DEFAULT '1',
  `user_count` int(11) DEFAULT '0',
  `t_insert` datetime DEFAULT NULL,
  `t_update` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `badge_slug_ukey` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

/*Table structure for table `blog_attachment` */

DROP TABLE IF EXISTS `blog_attachment`;

CREATE TABLE `blog_attachment` (
  `id` bigint(32) unsigned NOT NULL AUTO_INCREMENT COMMENT '序号',
  `post_id` int(11) unsigned NOT NULL COMMENT '博客序号',
  `filename` varchar(255) NOT NULL COMMENT '附件名称',
  `filesize` int(11) unsigned NOT NULL DEFAULT '0',
  `filepath` varchar(255) NOT NULL COMMENT '附件路径',
  `created` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `updated` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`),
  KEY `post_id` (`post_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='附件表';

/*Table structure for table `blog_category` */

DROP TABLE IF EXISTS `blog_category`;

CREATE TABLE `blog_category` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '序号',
  `uid` int(11) NOT NULL DEFAULT '0',
  `pid` int(11) unsigned NOT NULL DEFAULT '0',
  `name` varchar(255) NOT NULL,
  `alias` varchar(255) DEFAULT NULL COMMENT '别名',
  `position` int(11) unsigned DEFAULT '0' COMMENT '排序序号',
  `mbr_count` int(6) unsigned DEFAULT '0' COMMENT '成员数量',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=34 DEFAULT CHARSET=utf8 COMMENT='分类表';

/*Table structure for table `blog_comment` */

DROP TABLE IF EXISTS `blog_comment`;

CREATE TABLE `blog_comment` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `content` text NOT NULL,
  `status` int(11) unsigned NOT NULL,
  `created` int(11) unsigned DEFAULT NULL,
  `author` varchar(128) NOT NULL,
  `email` varchar(128) NOT NULL,
  `url` varchar(128) DEFAULT NULL,
  `ip` varchar(128) DEFAULT NULL,
  `post_id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_comment_post` (`post_id`)
) ENGINE=MyISAM AUTO_INCREMENT=74 DEFAULT CHARSET=utf8;

/*Table structure for table `blog_link` */

DROP TABLE IF EXISTS `blog_link`;

CREATE TABLE `blog_link` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '序号',
  `sitename` varchar(128) NOT NULL COMMENT '网站名称',
  `logo` varchar(128) DEFAULT NULL COMMENT '站标地址',
  `siteurl` varchar(255) NOT NULL COMMENT '网站地址',
  `description` varchar(255) DEFAULT NULL COMMENT '描述',
  `target` enum('_blank','_top','_self','_parent') DEFAULT '_blank' COMMENT '打开方式',
  `status` int(11) unsigned NOT NULL,
  `position` int(11) unsigned DEFAULT '0' COMMENT '排序序号',
  `created` int(11) unsigned DEFAULT NULL COMMENT '创建时间',
  `updated` int(11) unsigned DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Table structure for table `blog_lookup` */

DROP TABLE IF EXISTS `blog_lookup`;

CREATE TABLE `blog_lookup` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(128) NOT NULL,
  `code` int(11) unsigned NOT NULL,
  `type` varchar(128) NOT NULL,
  `position` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

/*Table structure for table `blog_options` */

DROP TABLE IF EXISTS `blog_options`;

CREATE TABLE `blog_options` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `object_id` int(11) unsigned NOT NULL DEFAULT '0',
  `option_name` varchar(255) NOT NULL COMMENT '选项名称',
  `option_value` text NOT NULL COMMENT '值',
  PRIMARY KEY (`id`),
  KEY `option_name` (`option_name`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='选项设置表';

/*Table structure for table `blog_post` */

DROP TABLE IF EXISTS `blog_post`;

CREATE TABLE `blog_post` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `author_id` int(11) unsigned NOT NULL,
  `content` text NOT NULL,
  `summary` varchar(255) NOT NULL COMMENT '摘要',
  `tags` text,
  `status` int(11) unsigned NOT NULL,
  `created` int(11) unsigned DEFAULT '0',
  `updated` int(11) unsigned DEFAULT '0',
  `rep_image` varchar(255) DEFAULT NULL COMMENT '代表图 如果有的话tipical_image',
  `featured` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT ' 是否作为作者的特征日志',
  `views` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '浏览数',
  `rate` float unsigned NOT NULL DEFAULT '0' COMMENT '投票得分',
  `rate_count` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '投票总次数',
  `cmt_count` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '评论数',
  `allow_rate` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否允许投票',
  `allow_cmt` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否允许评论',
  `last_cmt_time` int(11) NOT NULL DEFAULT '0' COMMENT '最后评论时间',
  `category_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '分类ID',
  `title` varchar(128) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_post_author` (`author_id`)
) ENGINE=MyISAM AUTO_INCREMENT=79 DEFAULT CHARSET=utf8;

/*Table structure for table `blog_recommend` */

DROP TABLE IF EXISTS `blog_recommend`;

CREATE TABLE `blog_recommend` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL COMMENT '推荐者',
  `object_id` int(11) NOT NULL COMMENT '推荐的目标对象',
  `grade` tinyint(3) NOT NULL DEFAULT '0' COMMENT '推荐的等级 可用来排序',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8;

/*Table structure for table `blog_sys_category` */

DROP TABLE IF EXISTS `blog_sys_category`;

CREATE TABLE `blog_sys_category` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(60) NOT NULL,
  `position` tinyint(3) NOT NULL DEFAULT '0',
  `enable` tinyint(3) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

/*Table structure for table `blog_sys_category2post` */

DROP TABLE IF EXISTS `blog_sys_category2post`;

CREATE TABLE `blog_sys_category2post` (
  `post_id` int(10) unsigned NOT NULL,
  `sys_cate_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`post_id`,`sys_cate_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `blog_tag` */

DROP TABLE IF EXISTS `blog_tag`;

CREATE TABLE `blog_tag` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(128) NOT NULL,
  `frequency` int(11) unsigned DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;

/*Table structure for table `cmt_thread` */

DROP TABLE IF EXISTS `cmt_thread`;

CREATE TABLE `cmt_thread` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `root` int(10) unsigned DEFAULT NULL,
  `lft` int(10) unsigned NOT NULL,
  `rgt` int(10) unsigned NOT NULL,
  `level` smallint(5) unsigned NOT NULL,
  `cmt_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `root` (`root`),
  KEY `lft` (`lft`),
  KEY `rgt` (`rgt`),
  KEY `level` (`level`),
  KEY `cmt_id` (`cmt_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `comment` */

DROP TABLE IF EXISTS `comment`;

CREATE TABLE `comment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `model` varchar(100) NOT NULL,
  `model_id` int(11) NOT NULL,
  `model_owner_id` int(11) NOT NULL DEFAULT '0' COMMENT 'whom the model belong to',
  `name` varchar(150) NOT NULL,
  `url` varchar(150) DEFAULT NULL,
  `email` varchar(150) NOT NULL,
  `text` text NOT NULL,
  `model_profile_data` varchar(400) DEFAULT NULL COMMENT 'model detail summery data : url ,id etc',
  `status` int(11) NOT NULL DEFAULT '0',
  `create_time` int(11) NOT NULL,
  `ip` varchar(20) DEFAULT NULL,
  `level` int(11) DEFAULT '0',
  `root` int(11) DEFAULT '0',
  `lft` int(11) DEFAULT '0',
  `rgt` int(11) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `ix_comment_status` (`status`),
  KEY `ix_comment_model_model_id` (`model`,`model_id`),
  KEY `ix_comment_model` (`model`),
  KEY `ix_comment_model_id` (`model_id`),
  KEY `ix_comment_user_id` (`user_id`),
  KEY `ix_comment_parent_id` (`parent_id`),
  KEY `ix_comment_level` (`level`),
  KEY `ix_comment_root` (`root`),
  KEY `ix_comment_lft` (`lft`),
  KEY `ix_comment_rgt` (`rgt`)
) ENGINE=InnoDB AUTO_INCREMENT=52 DEFAULT CHARSET=utf8;

/*Table structure for table `dashboard` */

DROP TABLE IF EXISTS `dashboard`;

CREATE TABLE `dashboard` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `position` varchar(50) CHARACTER SET armscii8 COLLATE armscii8_bin NOT NULL DEFAULT '146,383',
  `render` text NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `size` varchar(50) NOT NULL DEFAULT '334,140',
  `allowdelete` tinyint(4) NOT NULL,
  `ajaxrequest` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8;

/*Table structure for table `group` */

DROP TABLE IF EXISTS `group`;

CREATE TABLE `group` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` longtext NOT NULL,
  `creator_id` int(11) NOT NULL,
  `created` int(11) NOT NULL,
  `type` enum('public','private','private-member-invite','private-self-invite') NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `recommend_grade` tinyint(4) NOT NULL COMMENT '推荐等级',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

/*Table structure for table `group_category` */

DROP TABLE IF EXISTS `group_category`;

CREATE TABLE `group_category` (
  `id` mediumint(5) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `type` tinyint(1) NOT NULL DEFAULT '1',
  `pid` mediumint(5) NOT NULL DEFAULT '0',
  `module` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=71 DEFAULT CHARSET=utf8;

/*Table structure for table `group_invite` */

DROP TABLE IF EXISTS `group_invite`;

CREATE TABLE `group_invite` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `group_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `inviter_id` int(11) NOT NULL,
  `timeStamp` int(11) NOT NULL,
  `viewed` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `inviteUniq` (`group_id`,`user_id`,`inviter_id`),
  KEY `timeStamp` (`timeStamp`),
  KEY `userId` (`user_id`),
  KEY `groupId` (`group_id`),
  KEY `viewed` (`viewed`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='暂时没有用';

/*Table structure for table `group_member` */

DROP TABLE IF EXISTS `group_member`;

CREATE TABLE `group_member` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `group_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `approved` tinyint(1) NOT NULL DEFAULT '0',
  `requested` tinyint(1) NOT NULL DEFAULT '0',
  `invited` tinyint(1) NOT NULL DEFAULT '0',
  `requested_time` int(11) NOT NULL DEFAULT '0',
  `join_time` int(11) NOT NULL DEFAULT '0',
  `inviter_id` int(11) NOT NULL DEFAULT '0',
  `invited_time` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

/*Table structure for table `group_topic` */

DROP TABLE IF EXISTS `group_topic`;

CREATE TABLE `group_topic` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `creator_id` int(11) NOT NULL,
  `created` int(11) NOT NULL DEFAULT '0',
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `group_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

/*Table structure for table `group_topic_category` */

DROP TABLE IF EXISTS `group_topic_category`;

CREATE TABLE `group_topic_category` (
  `id` mediumint(6) unsigned NOT NULL AUTO_INCREMENT,
  `gid` int(11) unsigned NOT NULL,
  `title` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `group_topic_post` */

DROP TABLE IF EXISTS `group_topic_post`;

CREATE TABLE `group_topic_post` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `group_id` int(11) unsigned NOT NULL,
  `topic_id` int(11) unsigned NOT NULL,
  `user_id` int(11) unsigned NOT NULL,
  `content` text NOT NULL,
  `ip` char(16) NOT NULL,
  `create_time` int(11) NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `is_del` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `gid` (`group_id`,`topic_id`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8;

/*Table structure for table `migration` */

DROP TABLE IF EXISTS `migration`;

CREATE TABLE `migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `msg` */

DROP TABLE IF EXISTS `msg`;

CREATE TABLE `msg` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键id',
  `type` varchar(50) NOT NULL DEFAULT 'sys_broadcast' COMMENT '消息类型 多表继承关系的设计一般都用type做区分 站内还是email方式 还是站内回复  取(site email reply ) 回复消息应该还有对那个消息做回复 一旦出现回复那么请参看msg_thread表',
  `uid` int(11) NOT NULL COMMENT '用户id 发送者 snd_uid  ',
  `data` text NOT NULL COMMENT 'title,body',
  `snd_type` tinyint(4) NOT NULL DEFAULT '0' COMMENT '发送类型 即时消息0 延迟不确定什么时候或者定时消息 如果定时消息可能需要配合队列机制cron',
  `snd_status` tinyint(4) NOT NULL DEFAULT '-1' COMMENT '未发送 在队列中 已发送 发送成功 发送失败 -2表示取消发送如果还没有发送时 比如在队列或者是定时消息',
  `priority` tinyint(4) NOT NULL DEFAULT '0' COMMENT '优先级 默认是0 优先级在消息队列中有用 高的先发送',
  `to_id` int(11) NOT NULL DEFAULT '-1' COMMENT '发送给哪个目标 目标可以是组或者个人 或者是全部广播 默认-1表示广播 发送给所有人 广播只有管理员才可以做',
  `msg_pid` bigint(20) DEFAULT '0' COMMENT '默认无父亲 只记录消息是回复时的pid 真正消息树的构造是通过nestedset msg_thread 完成的 在inbox中只能看到此消息是对XX父消息的回复 然后另有一条链接可以看到全部的消息树结构',
  `create_time` int(11) NOT NULL COMMENT '消息创建时间',
  `sent_time` int(11) DEFAULT '0' COMMENT '真正发送的时间 由于队列的存在 创建时间跟发送时间不一样的  还由于有定时消息 所以还应该有一个字段 time_to_send 表示什么时候应该发送消息',
  `delete_time` int(11) NOT NULL DEFAULT '0' COMMENT '删除时间 msg表实际是发件箱表 自己的消息可以删除 原本用删除代替 取消发送的语义 最后考虑可以用snd_status 表示',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=70 DEFAULT CHARSET=utf8 COMMENT='一个人同时可以发送给某些群组要支持这种特性仍需添加字段';

/*Table structure for table `msg0` */

DROP TABLE IF EXISTS `msg0`;

CREATE TABLE `msg0` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sender` int(11) NOT NULL,
  `recipient` int(11) NOT NULL,
  `sent` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `read` tinyint(1) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `message` longtext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;

/*Table structure for table `msg_inbox` */

DROP TABLE IF EXISTS `msg_inbox`;

CREATE TABLE `msg_inbox` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT '收件id号 唯一主键',
  `uid` int(11) NOT NULL COMMENT '邮箱所有者 用户id',
  `msg_id` bigint(20) NOT NULL COMMENT '消息id 参考消息表',
  `read_time` int(11) NOT NULL DEFAULT '0' COMMENT '读取时间 默认是0表示未读 本来是想引入is_read 但后来考虑这个可以携带更多信息',
  `delete_time` int(11) NOT NULL DEFAULT '0' COMMENT '删除时间 同read_time一样的思路 原先准备用is_delete 0表示未删除',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=22 DEFAULT CHARSET=utf8 COMMENT='个人收件箱';

/*Table structure for table `msg_thread` */

DROP TABLE IF EXISTS `msg_thread`;

CREATE TABLE `msg_thread` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键 自增字段 嵌套集要求的 因为要跟msg_id字段形成一对一关系 所以类型也跟它一样 免得溢出 当消息形成树形结构后 用这个表 这个表配合yii官方nestedset扩展 在用rar关系中的has_one one-to-one 做左联接 很容易形成树形结构 且无递归 别名可以是msg_tree ',
  `root` bigint(20) unsigned NOT NULL COMMENT '根节点 嵌套集扩展的多根要求',
  `lft` bigint(20) unsigned NOT NULL COMMENT '一个节点的左值',
  `rgt` bigint(20) unsigned NOT NULL COMMENT '节点的右值',
  `level` int(10) unsigned NOT NULL COMMENT '树高',
  `msg_id` bigint(20) unsigned NOT NULL COMMENT '此字段用来做外键  跟msg表中的id进行左联接就可以完成树的构造了',
  PRIMARY KEY (`id`),
  KEY `root` (`root`),
  KEY `lft` (`lft`),
  KEY `rgt` (`rgt`),
  KEY `level` (`level`)
) ENGINE=MyISAM AUTO_INCREMENT=29 DEFAULT CHARSET=utf8;

/*Table structure for table `news_category` */

DROP TABLE IF EXISTS `news_category`;

CREATE TABLE `news_category` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `root` int(10) unsigned DEFAULT NULL,
  `lft` int(10) unsigned NOT NULL,
  `rgt` int(10) unsigned NOT NULL,
  `level` smallint(5) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `enable` tinyint(1) NOT NULL DEFAULT '1',
  `group_code` varchar(100) NOT NULL DEFAULT 'page' COMMENT '归类码表示用途的 也可以用来表示位置 一般只需要标记根的用途即可 也可以考虑用eav 但考虑到查询问题 所以引入了此字段',
  `mbr_count` int(10) DEFAULT '0' COMMENT '下面新闻的数量 节点数量',
  `link_to` varchar(60) DEFAULT 'route' COMMENT '如果是树的叶子那么链接到（page,pageList,route）',
  PRIMARY KEY (`id`),
  KEY `root` (`root`),
  KEY `lft` (`lft`),
  KEY `rgt` (`rgt`),
  KEY `level` (`level`)
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=utf8 COMMENT='用nestedset保存树关系';

/*Table structure for table `news_entry` */

DROP TABLE IF EXISTS `news_entry`;

CREATE TABLE `news_entry` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `creator` int(11) NOT NULL DEFAULT '0' COMMENT '新闻创建者',
  `cate_id` int(11) NOT NULL DEFAULT '0' COMMENT '新闻分类id',
  `title` varchar(255) NOT NULL COMMENT '新闻标题',
  `order` tinyint(3) NOT NULL DEFAULT '0' COMMENT '显示顺序 除了按时间还可按此字段',
  `deleted` tinyint(1) NOT NULL DEFAULT '0' COMMENT '当新闻类别删除时 置此字段为1',
  `create_time` int(11) NOT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

/*Table structure for table `news_post` */

DROP TABLE IF EXISTS `news_post`;

CREATE TABLE `news_post` (
  `nid` int(10) unsigned NOT NULL COMMENT '关联的新闻条目id',
  `content` text NOT NULL COMMENT '新闻内容这里',
  `keywords` varchar(100) DEFAULT NULL COMMENT '关键字 手动还是自动提取',
  `meta_title` varchar(255) DEFAULT NULL,
  `meta_description` varchar(255) DEFAULT NULL,
  `meta_keywords` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`nid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `notice_category` */

DROP TABLE IF EXISTS `notice_category`;

CREATE TABLE `notice_category` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(120) NOT NULL,
  `order` tinyint(3) NOT NULL DEFAULT '0',
  `enable` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

/*Table structure for table `notice_post` */

DROP TABLE IF EXISTS `notice_post`;

CREATE TABLE `notice_post` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `cate_id` int(11) NOT NULL,
  `title` varchar(120) NOT NULL,
  `content` text NOT NULL,
  `create_time` int(11) NOT NULL,
  `creator_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

/*Table structure for table `oauth_consumer_registry` */

DROP TABLE IF EXISTS `oauth_consumer_registry`;

CREATE TABLE `oauth_consumer_registry` (
  `ocr_id` int(11) NOT NULL AUTO_INCREMENT,
  `ocr_usa_id_ref` int(11) DEFAULT NULL,
  `ocr_consumer_key` varchar(128) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `ocr_consumer_secret` varchar(128) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `ocr_signature_methods` varchar(255) NOT NULL DEFAULT 'HMAC-SHA1,PLAINTEXT',
  `ocr_server_uri` varchar(255) NOT NULL,
  `ocr_server_uri_host` varchar(128) NOT NULL,
  `ocr_server_uri_path` varchar(128) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `ocr_request_token_uri` varchar(255) NOT NULL,
  `ocr_authorize_uri` varchar(255) NOT NULL,
  `ocr_access_token_uri` varchar(255) NOT NULL,
  `ocr_timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`ocr_id`),
  KEY `ocr_server_uri` (`ocr_server_uri`),
  KEY `ocr_server_uri_host` (`ocr_server_uri_host`,`ocr_server_uri_path`),
  KEY `ocr_usa_id_ref` (`ocr_usa_id_ref`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Table structure for table `oauth_consumer_token` */

DROP TABLE IF EXISTS `oauth_consumer_token`;

CREATE TABLE `oauth_consumer_token` (
  `oct_id` int(11) NOT NULL AUTO_INCREMENT,
  `oct_ocr_id_ref` int(11) NOT NULL,
  `oct_usa_id_ref` int(11) NOT NULL,
  `oct_name` varchar(64) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '',
  `oct_token` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `oct_token_secret` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `oct_token_type` enum('request','authorized','access') DEFAULT NULL,
  `oct_token_ttl` datetime NOT NULL DEFAULT '9999-12-31 00:00:00',
  `oct_timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`oct_id`),
  UNIQUE KEY `oct_ocr_id_ref` (`oct_ocr_id_ref`,`oct_token`),
  KEY `oct_token_ttl` (`oct_token_ttl`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Table structure for table `oauth_server_nonce` */

DROP TABLE IF EXISTS `oauth_server_nonce`;

CREATE TABLE `oauth_server_nonce` (
  `osn_id` int(11) NOT NULL AUTO_INCREMENT,
  `osn_consumer_key` varchar(64) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `osn_token` varchar(64) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `osn_timestamp` bigint(20) NOT NULL,
  `osn_nonce` varchar(80) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`osn_id`),
  UNIQUE KEY `osn_consumer_key` (`osn_consumer_key`,`osn_token`,`osn_timestamp`,`osn_nonce`)
) ENGINE=MyISAM AUTO_INCREMENT=229 DEFAULT CHARSET=utf8;

/*Table structure for table `oauth_server_registry` */

DROP TABLE IF EXISTS `oauth_server_registry`;

CREATE TABLE `oauth_server_registry` (
  `osr_id` int(11) NOT NULL AUTO_INCREMENT,
  `osr_usa_id_ref` int(11) DEFAULT NULL,
  `osr_consumer_key` varchar(64) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `osr_consumer_secret` varchar(64) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `osr_enabled` tinyint(1) NOT NULL DEFAULT '1',
  `osr_status` varchar(16) NOT NULL,
  `osr_requester_name` varchar(64) NOT NULL,
  `osr_requester_email` varchar(64) NOT NULL,
  `osr_callback_uri` varchar(255) NOT NULL,
  `osr_application_uri` varchar(255) NOT NULL,
  `osr_application_title` varchar(80) NOT NULL,
  `osr_application_descr` text NOT NULL,
  `osr_application_notes` text NOT NULL,
  `osr_application_type` varchar(20) NOT NULL,
  `osr_application_commercial` tinyint(1) NOT NULL DEFAULT '0',
  `osr_issue_date` datetime NOT NULL,
  `osr_timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`osr_id`),
  UNIQUE KEY `osr_consumer_key` (`osr_consumer_key`),
  KEY `osr_usa_id_ref` (`osr_usa_id_ref`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

/*Table structure for table `oauth_server_token` */

DROP TABLE IF EXISTS `oauth_server_token`;

CREATE TABLE `oauth_server_token` (
  `ost_id` int(11) NOT NULL AUTO_INCREMENT,
  `ost_osr_id_ref` int(11) NOT NULL,
  `ost_usa_id_ref` int(11) NOT NULL,
  `ost_token` varchar(64) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `ost_token_secret` varchar(64) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `ost_token_type` enum('request','access') DEFAULT NULL,
  `ost_authorized` tinyint(1) NOT NULL DEFAULT '0',
  `ost_referrer_host` varchar(128) NOT NULL DEFAULT '',
  `ost_token_ttl` datetime NOT NULL DEFAULT '9999-12-31 00:00:00',
  `ost_timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ost_verifier` char(10) DEFAULT NULL,
  `ost_callback_url` varchar(512) DEFAULT NULL,
  PRIMARY KEY (`ost_id`),
  UNIQUE KEY `ost_token` (`ost_token`),
  KEY `ost_osr_id_ref` (`ost_osr_id_ref`),
  KEY `ost_token_ttl` (`ost_token_ttl`)
) ENGINE=MyISAM AUTO_INCREMENT=161 DEFAULT CHARSET=utf8;

/*Table structure for table `photo` */

DROP TABLE IF EXISTS `photo`;

CREATE TABLE `photo` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uid` int(10) unsigned DEFAULT NULL,
  `album_id` int(10) NOT NULL DEFAULT '0',
  `title` varchar(255) DEFAULT '',
  `desc` text NOT NULL,
  `path` varchar(255) NOT NULL DEFAULT '' COMMENT 'resized max deminsion for display',
  `orig_path` varchar(255) NOT NULL DEFAULT '' COMMENT 'original uploaded image',
  `ext` varchar(4) NOT NULL DEFAULT '',
  `size` varchar(10) DEFAULT '',
  `tags` varchar(255) NOT NULL DEFAULT '',
  `create_time` int(11) NOT NULL DEFAULT '0',
  `views` int(11) DEFAULT '0',
  `rate` float NOT NULL DEFAULT '0',
  `rate_count` int(11) NOT NULL DEFAULT '0',
  `cmt_count` int(11) NOT NULL DEFAULT '0',
  `is_featured` tinyint(4) NOT NULL DEFAULT '0',
  `status` enum('approved','disapproved','pending') NOT NULL DEFAULT 'pending',
  `hash` varchar(32) NOT NULL DEFAULT '',
  `categories` text NOT NULL,
  `up_votes` int(11) NOT NULL DEFAULT '0',
  `down_votes` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `Hash` (`hash`),
  KEY `Owner` (`uid`),
  KEY `Date` (`create_time`),
  FULLTEXT KEY `ftMain` (`title`,`tags`,`desc`,`categories`),
  FULLTEXT KEY `ftTags` (`tags`),
  FULLTEXT KEY `ftCategories` (`categories`)
) ENGINE=MyISAM AUTO_INCREMENT=29 DEFAULT CHARSET=utf8;

/*Table structure for table `photo_album` */

DROP TABLE IF EXISTS `photo_album`;

CREATE TABLE `photo_album` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) DEFAULT NULL,
  `name` varchar(60) NOT NULL,
  `desc` varchar(255) DEFAULT '',
  `create_time` int(11) unsigned DEFAULT NULL,
  `update_time` int(11) unsigned DEFAULT NULL,
  `cover_uri` varchar(255) DEFAULT NULL,
  `mbr_count` int(11) DEFAULT '0',
  `views` int(11) NOT NULL DEFAULT '0',
  `status` tinyint(2) unsigned NOT NULL DEFAULT '1',
  `is_hot` varchar(1) NOT NULL DEFAULT '0',
  `privacy` tinyint(1) DEFAULT NULL,
  `privacy_data` text,
  PRIMARY KEY (`id`),
  KEY `uid` (`uid`),
  KEY `cTime` (`create_time`),
  KEY `mTime` (`update_time`)
) ENGINE=MyISAM AUTO_INCREMENT=23 DEFAULT CHARSET=utf8;

/*Table structure for table `photo_album_cmt` */

DROP TABLE IF EXISTS `photo_album_cmt`;

CREATE TABLE `photo_album_cmt` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id 主键',
  `pid` int(11) NOT NULL DEFAULT '0' COMMENT '对评论的评论',
  `object_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '评论的目标id 即ar的主键',
  `uid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'author_id 评论者 0 表示游客身份',
  `content` text NOT NULL COMMENT '评论内容',
  `mood` tinyint(4) NOT NULL DEFAULT '0' COMMENT '心情',
  `rate` int(11) NOT NULL DEFAULT '0' COMMENT '投票总分 5星制',
  `rate_count` int(11) NOT NULL DEFAULT '0' COMMENT '投票次数',
  `create_time` int(11) NOT NULL DEFAULT '0' COMMENT '评论的时间',
  `replies` int(11) NOT NULL DEFAULT '0' COMMENT '回复数',
  PRIMARY KEY (`id`),
  KEY `cmt_object_id` (`object_id`,`pid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Table structure for table `photo_cmt` */

DROP TABLE IF EXISTS `photo_cmt`;

CREATE TABLE `photo_cmt` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id 主键',
  `pid` int(11) NOT NULL DEFAULT '0' COMMENT '对评论的评论',
  `object_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '评论的目标id 即ar的主键',
  `uid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'author_id 评论者 0 表示游客身份',
  `content` text NOT NULL COMMENT '评论内容',
  `mood` tinyint(4) NOT NULL DEFAULT '0' COMMENT '心情',
  `rate` int(11) NOT NULL DEFAULT '0' COMMENT '投票总分 5星制',
  `rate_count` int(11) NOT NULL DEFAULT '0' COMMENT '投票次数',
  `create_time` int(11) NOT NULL DEFAULT '0' COMMENT '评论的时间',
  `replies` int(11) NOT NULL DEFAULT '0' COMMENT '回复数',
  PRIMARY KEY (`id`),
  KEY `cmt_object_id` (`object_id`,`pid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Table structure for table `photo_favorite` */

DROP TABLE IF EXISTS `photo_favorite`;

CREATE TABLE `photo_favorite` (
  `object_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '目标对象ar的id',
  `uid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '动作执行者',
  `create_time` int(11) NOT NULL DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`object_id`,`uid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Table structure for table `photo_rating` */

DROP TABLE IF EXISTS `photo_rating`;

CREATE TABLE `photo_rating` (
  `pt_id` int(10) unsigned NOT NULL DEFAULT '0',
  `pt_rating_count` int(11) NOT NULL DEFAULT '0',
  `pt_rating_sum` int(11) NOT NULL DEFAULT '0',
  UNIQUE KEY `med_id` (`pt_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Table structure for table `photo_thumb_vote` */

DROP TABLE IF EXISTS `photo_thumb_vote`;

CREATE TABLE `photo_thumb_vote` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `object_id` int(11) unsigned NOT NULL,
  `value` tinyint(1) unsigned NOT NULL,
  `uid` int(11) unsigned DEFAULT NULL,
  `ip` varchar(255) DEFAULT NULL,
  `create_time` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `only_once` (`object_id`,`ip`,`uid`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8;

/*Table structure for table `photo_view_track` */

DROP TABLE IF EXISTS `photo_view_track`;

CREATE TABLE `photo_view_track` (
  `id` int(10) unsigned NOT NULL,
  `viewer` int(10) unsigned NOT NULL,
  `ip` int(10) unsigned NOT NULL,
  `ts` int(10) unsigned NOT NULL,
  KEY `id` (`id`,`viewer`,`ip`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Table structure for table `photo_vote_track` */

DROP TABLE IF EXISTS `photo_vote_track`;

CREATE TABLE `photo_vote_track` (
  `pt_id` int(10) unsigned NOT NULL DEFAULT '0',
  `pt_ip` varchar(20) DEFAULT NULL,
  `pt_date` datetime DEFAULT NULL,
  KEY `med_ip` (`pt_ip`,`pt_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Table structure for table `profile` */

DROP TABLE IF EXISTS `profile`;

CREATE TABLE `profile` (
  `user_id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `public_email` varchar(255) DEFAULT NULL,
  `gravatar_email` varchar(255) DEFAULT NULL,
  `gravatar_id` varchar(32) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `website` varchar(255) DEFAULT NULL,
  `bio` text,
  PRIMARY KEY (`user_id`),
  CONSTRAINT `fk_user_profile` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `relationship` */

DROP TABLE IF EXISTS `relationship`;

CREATE TABLE `relationship` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'A unique ID for the relationship between the two users',
  `type` int(11) NOT NULL COMMENT 'The type of relationship (a reference to the relationship_types table)',
  `user_a` int(11) NOT NULL COMMENT 'The user who initiated the relationship, a relation to the users table',
  `user_b` int(11) NOT NULL COMMENT 'The user who usera initiated a relationship with, a relation to the users table',
  `accepted` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'Indicates if this is a mutual relationship (which is only used if the relationship type is a mutual relationship)',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'the time when form this relation',
  `category_id` int(11) NOT NULL DEFAULT '0' COMMENT 'the custom friend category',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8;

/*Table structure for table `relationship_category` */

DROP TABLE IF EXISTS `relationship_category`;

CREATE TABLE `relationship_category` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL COMMENT '所属的用户',
  `name` varchar(64) NOT NULL COMMENT '自定义用户分组名称',
  `display_order` tinyint(3) NOT NULL DEFAULT '0' COMMENT '显示顺序',
  `mbr_count` smallint(5) NOT NULL DEFAULT '0' COMMENT '成员数量',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

/*Table structure for table `relationship_type` */

DROP TABLE IF EXISTS `relationship_type`;

CREATE TABLE `relationship_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'A unique ID for the relationship type',
  `name` varchar(25) NOT NULL COMMENT 'The name of the relationship type, for example, friend',
  `plural_name` varchar(25) DEFAULT NULL COMMENT 'Plural version of the relationship type,for example, friends',
  `active` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'If this relationship type is active, and should users be able to form such relationships?',
  `mutual` tinyint(1) DEFAULT '1' COMMENT 'Does this relationship require it to be a mutual connection, or can users connect without the permission of the other?',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

/*Table structure for table `seo` */

DROP TABLE IF EXISTS `seo`;

CREATE TABLE `seo` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `keywords` varchar(255) NOT NULL,
  `seoble_id` int(11) unsigned NOT NULL,
  `seoble_type` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COMMENT='Polymorphic relationships seo实现';

/*Table structure for table `settings` */

DROP TABLE IF EXISTS `settings`;

CREATE TABLE `settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category` varchar(64) NOT NULL DEFAULT 'system',
  `key` varchar(255) NOT NULL,
  `value` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `category_key` (`category`,`key`)
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=utf8;

/*Table structure for table `social_account` */

DROP TABLE IF EXISTS `social_account`;

CREATE TABLE `social_account` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `provider` varchar(255) NOT NULL,
  `client_id` varchar(255) NOT NULL,
  `data` text,
  `code` varchar(32) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `account_unique` (`provider`,`client_id`),
  UNIQUE KEY `account_unique_code` (`code`),
  KEY `fk_user_account` (`user_id`),
  CONSTRAINT `fk_user_account` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `status` */

DROP TABLE IF EXISTS `status`;

CREATE TABLE `status` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID of the status',
  `update` longtext NOT NULL COMMENT 'The content of the update',
  `type` varchar(120) NOT NULL COMMENT 'Reference to the status types table',
  `creator` int(11) NOT NULL COMMENT 'The ID of the poster',
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Time status was posted',
  `profile` int(11) NOT NULL COMMENT 'Profile the status was posted on',
  `approved` tinyint(1) DEFAULT '1' COMMENT 'If the status is approved or notIf the status is approved or not',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=202 DEFAULT CHARSET=utf8;

/*Table structure for table `status_image` */

DROP TABLE IF EXISTS `status_image`;

CREATE TABLE `status_image` (
  `id` int(11) NOT NULL,
  `image` varchar(255) CHARACTER SET latin1 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Table structure for table `status_link` */

DROP TABLE IF EXISTS `status_link`;

CREATE TABLE `status_link` (
  `id` int(11) NOT NULL,
  `url` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Table structure for table `status_plugin` */

DROP TABLE IF EXISTS `status_plugin`;

CREATE TABLE `status_plugin` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID of the status plugin',
  `name` varchar(25) NOT NULL COMMENT 'The name of the type of status',
  `type_reference` varchar(120) NOT NULL COMMENT 'A machine readable name for the type, used as the file name of template bits (that is, no spaces or punctuation)',
  `description` varchar(255) NOT NULL,
  `plugin_class` varchar(255) NOT NULL COMMENT 'the class for this type',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `status_type` */

DROP TABLE IF EXISTS `status_type`;

CREATE TABLE `status_type` (
  `id` varchar(120) NOT NULL COMMENT 'A machine readable name for the type, used as the file name of template bits (that is, no spaces or punctuation)',
  `type_name` varchar(25) NOT NULL COMMENT 'The name of the type of status',
  `active` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'Indicates whether the status type is active or not',
  `handler` varchar(255) DEFAULT NULL COMMENT 'the handler in charge of render status for this type',
  `is_core` tinyint(2) NOT NULL DEFAULT '0' COMMENT 'is core status type ,only non-core type has handler',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='status_type_name 可以做国际化！';

/*Table structure for table `status_video` */

DROP TABLE IF EXISTS `status_video`;

CREATE TABLE `status_video` (
  `id` int(11) NOT NULL,
  `video_id` varchar(50) CHARACTER SET latin1 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Table structure for table `sys_album` */

DROP TABLE IF EXISTS `sys_album`;

CREATE TABLE `sys_album` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `caption` varchar(128) NOT NULL,
  `cover_uri` varchar(255) DEFAULT '' COMMENT '暂时不用此字段 唯一url生成比较耗时',
  `location` varchar(128) NOT NULL DEFAULT '',
  `description` varchar(255) NOT NULL DEFAULT '',
  `type` varchar(20) NOT NULL DEFAULT '',
  `uid` int(10) NOT NULL DEFAULT '0',
  `status` enum('active','passive') NOT NULL DEFAULT 'active',
  `create_time` int(10) NOT NULL DEFAULT '0',
  `obj_count` int(10) NOT NULL DEFAULT '0',
  `last_obj_id` int(10) NOT NULL DEFAULT '0',
  `allow_view` int(10) NOT NULL DEFAULT '3',
  PRIMARY KEY (`id`),
  KEY `Owner` (`uid`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

/*Table structure for table `sys_album_object` */

DROP TABLE IF EXISTS `sys_album_object`;

CREATE TABLE `sys_album_object` (
  `id_album` int(10) NOT NULL,
  `id_object` int(10) NOT NULL,
  `obj_order` int(10) NOT NULL DEFAULT '0',
  UNIQUE KEY `id_album` (`id_album`,`id_object`),
  KEY `id_object` (`id_object`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='索引关联表 只不过比传统的桥表多一个排序字段 暂时不准备用这个表';

/*Table structure for table `sys_article` */

DROP TABLE IF EXISTS `sys_article`;

CREATE TABLE `sys_article` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '索引id',
  `cate_id` int(11) DEFAULT NULL COMMENT '分类id',
  `url` varchar(255) DEFAULT NULL COMMENT '跳转链接 如果有那么内容被忽略',
  `enable` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '是否显示，0为否，1为是，默认为1',
  `order` tinyint(3) unsigned NOT NULL DEFAULT '255' COMMENT '排序',
  `title` varchar(125) DEFAULT NULL COMMENT '标题',
  `article_content` text COMMENT '内容',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '发布时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=46 DEFAULT CHARSET=utf8 COMMENT='文章表';

/*Table structure for table `sys_article_category` */

DROP TABLE IF EXISTS `sys_article_category`;

CREATE TABLE `sys_article_category` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '索引ID',
  `ref_code` varchar(255) DEFAULT NULL COMMENT '分类标识码',
  `name` varchar(100) NOT NULL COMMENT '分类名称',
  `parent_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '父ID',
  `order` tinyint(1) unsigned NOT NULL DEFAULT '255' COMMENT '排序',
  PRIMARY KEY (`id`),
  KEY `ac_parent_id` (`parent_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COMMENT='文章分类表';

/*Table structure for table `sys_audio` */

DROP TABLE IF EXISTS `sys_audio`;

CREATE TABLE `sys_audio` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL COMMENT '创建者id',
  `name` varchar(120) NOT NULL COMMENT '音频名称',
  `singer` varchar(60) NOT NULL DEFAULT '''unknown''' COMMENT '歌手',
  `summary` varchar(500) DEFAULT NULL COMMENT '音频简介 可抓取名网站的歌曲信息 正则匹配后存储',
  `uri` varchar(255) NOT NULL COMMENT '存储的uri位置 或者网络地址',
  `source_type` enum('local','remote') NOT NULL COMMENT '音频来源',
  `play_order` tinyint(4) NOT NULL DEFAULT '0' COMMENT '播放顺序 也可以使用sys_album_object 中的顺序',
  `listens` int(10) NOT NULL DEFAULT '0' COMMENT '播放次数 点击量！',
  `create_time` int(11) NOT NULL COMMENT '上传时间',
  `cmt_count` bigint(20) NOT NULL DEFAULT '0' COMMENT '评论数',
  `glean_count` int(11) NOT NULL DEFAULT '0' COMMENT '收藏次数',
  `file_size` int(11) NOT NULL DEFAULT '0' COMMENT '文件大小 当时网络歌曲地址时为0',
  `status` tinyint(2) NOT NULL DEFAULT '-1' COMMENT '状态 -1未被关联到相册 1已关联到相册',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8 COMMENT='ÒôÆµ±í ´æ´¢ÓÃ»§µÄmp3µÈÒôÀÖ';

/*Table structure for table `sys_email_queue` */

DROP TABLE IF EXISTS `sys_email_queue`;

CREATE TABLE `sys_email_queue` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `from_name` varchar(64) DEFAULT NULL,
  `from_email` varchar(128) NOT NULL,
  `to_email` varchar(128) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `max_attempts` int(11) NOT NULL DEFAULT '3',
  `attempts` int(11) NOT NULL DEFAULT '0',
  `success` tinyint(1) NOT NULL DEFAULT '0',
  `date_published` datetime DEFAULT NULL,
  `last_attempt` datetime DEFAULT NULL,
  `date_sent` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `to_email` (`to_email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `sys_event` */

DROP TABLE IF EXISTS `sys_event`;

CREATE TABLE `sys_event` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `from_module` varchar(128) NOT NULL DEFAULT '''app''' COMMENT 'from unit name , equal to the module id',
  `action` varchar(125) NOT NULL DEFAULT 'none' COMMENT 'action name : n+v or v+n (deleteUser or userDelete)',
  PRIMARY KEY (`id`),
  UNIQUE KEY `alert_handler` (`from_module`,`action`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Table structure for table `sys_event2listener` */

DROP TABLE IF EXISTS `sys_event2listener`;

CREATE TABLE `sys_event2listener` (
  `event_id` int(11) NOT NULL,
  `listener_id` int(11) NOT NULL,
  PRIMARY KEY (`event_id`,`listener_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `sys_event_listener` */

DROP TABLE IF EXISTS `sys_event_listener`;

CREATE TABLE `sys_event_listener` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(128) NOT NULL DEFAULT '',
  `class` varchar(128) NOT NULL DEFAULT '',
  `file` varchar(255) NOT NULL DEFAULT '',
  `eval` text,
  `from_module` varchar(50) NOT NULL DEFAULT '''app''' COMMENT 'from wich module default is app means from sys',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

/*Table structure for table `sys_friend_link` */

DROP TABLE IF EXISTS `sys_friend_link`;

CREATE TABLE `sys_friend_link` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL COMMENT '友链名称',
  `logo` varchar(255) DEFAULT NULL COMMENT '友链logo 可以是本地或者远程地址',
  `url` varchar(255) NOT NULL,
  `order` tinyint(3) NOT NULL DEFAULT '0' COMMENT '显示顺序',
  `enable` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否启用',
  PRIMARY KEY (`id`),
  KEY `xx_friend_link_order_list` (`order`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

/*Table structure for table `sys_hook` */

DROP TABLE IF EXISTS `sys_hook`;

CREATE TABLE `sys_hook` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `host_module` varchar(80) NOT NULL DEFAULT '''app''' COMMENT '宿主模块id',
  `hook_name` varchar(255) NOT NULL COMMENT '钩子名称executionPoint执行点 键值而已 如blogCreate',
  `client_module` varchar(80) NOT NULL DEFAULT '''app''' COMMENT '挂接方模块id',
  `client_hook_name` varchar(255) NOT NULL COMMENT '挂接方hook名字 用来删除的如blogOnUserDelete',
  `hook_content` text NOT NULL COMMENT '序列化或其他格式存储的hook内容自己定义解析格式',
  `priority` tinyint(5) NOT NULL DEFAULT '0' COMMENT '优先级',
  `type` varchar(25) NOT NULL DEFAULT '''custom''' COMMENT 'custome,action,filter',
  `create_time` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQUE` (`client_hook_name`)
) ENGINE=InnoDB AUTO_INCREMENT=232 DEFAULT CHARSET=utf8;

/*Table structure for table `sys_image_deleted` */

DROP TABLE IF EXISTS `sys_image_deleted`;

CREATE TABLE `sys_image_deleted` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `file_uri` varchar(255) NOT NULL COMMENT 'the deleted file uri',
  `create_time` int(11) DEFAULT NULL COMMENT 'deleted time',
  `storage_type` varchar(60) NOT NULL COMMENT 'the file storage type',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8 COMMENT='用来记录被删除的图片 以后可以用任务来跑删除缩略图的 此表也可以用其他db代替:mongodb,arangodb';

/*Table structure for table `sys_menu` */

DROP TABLE IF EXISTS `sys_menu`;

CREATE TABLE `sys_menu` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `root` int(10) unsigned DEFAULT NULL,
  `lft` int(10) unsigned NOT NULL,
  `rgt` int(10) unsigned NOT NULL,
  `level` smallint(5) unsigned NOT NULL,
  `label` varchar(255) NOT NULL,
  `url` varchar(255) DEFAULT NULL COMMENT 'url 如 array(user/create); 或者user/create  //user/create 服务端处理时要判断是否转为array 要考虑如果采用前者分号的问题 eval函数',
  `params` tinytext COMMENT 'url 后的请求参数',
  `ajaxoptions` text,
  `htmloptions` text,
  `is_visible` tinyint(1) NOT NULL DEFAULT '1',
  `group_code` varchar(25) NOT NULL DEFAULT 'sys_menu' COMMENT '归类码表示用途的 也可以用来表示位置 一般只需要标记根的用途即可 也可以考虑用eav 但考虑到查询问题 所以引入了此字段',
  `label_en` varchar(125) DEFAULT '' COMMENT '英文菜单名',
  `link_to` varchar(60) DEFAULT 'route' COMMENT '如果是树的叶子那么链接到（page,pageList,route）',
  PRIMARY KEY (`id`),
  KEY `root` (`root`),
  KEY `lft` (`lft`),
  KEY `rgt` (`rgt`),
  KEY `level` (`level`)
) ENGINE=InnoDB AUTO_INCREMENT=55 DEFAULT CHARSET=utf8 COMMENT='用nestedset保存树关系';

/*Table structure for table `sys_menu_types` */

DROP TABLE IF EXISTS `sys_menu_types`;

CREATE TABLE `sys_menu_types` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `menutype` varchar(24) NOT NULL,
  `title` varchar(48) NOT NULL,
  `description` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_menutype` (`menutype`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

/*Table structure for table `sys_module` */

DROP TABLE IF EXISTS `sys_module`;

CREATE TABLE `sys_module` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `module_id` varchar(32) NOT NULL DEFAULT '',
  `title` varchar(255) NOT NULL DEFAULT '',
  `vendor` varchar(64) NOT NULL DEFAULT '',
  `version` varchar(32) NOT NULL DEFAULT '',
  `dependencies` varchar(255) NOT NULL DEFAULT '',
  `ctime` int(11) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=71 DEFAULT CHARSET=utf8;

/*Table structure for table `sys_mp3files` */

DROP TABLE IF EXISTS `sys_mp3files`;

CREATE TABLE `sys_mp3files` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Categories` text NOT NULL,
  `Title` varchar(255) NOT NULL DEFAULT '',
  `Uri` varchar(255) NOT NULL DEFAULT '',
  `Tags` text NOT NULL,
  `Description` text NOT NULL,
  `Time` int(11) NOT NULL DEFAULT '0',
  `Date` int(20) NOT NULL DEFAULT '0',
  `Reports` int(11) NOT NULL DEFAULT '0',
  `Owner` varchar(64) NOT NULL DEFAULT '',
  `Listens` int(12) DEFAULT '0',
  `Rate` float NOT NULL,
  `RateCount` int(11) NOT NULL,
  `CommentsCount` int(11) NOT NULL,
  `Featured` tinyint(4) NOT NULL,
  `Status` enum('approved','disapproved','pending','processing','failed') NOT NULL DEFAULT 'pending',
  PRIMARY KEY (`ID`),
  KEY `Owner` (`Owner`),
  FULLTEXT KEY `ftMain` (`Title`,`Tags`,`Description`,`Categories`),
  FULLTEXT KEY `ftTags` (`Tags`),
  FULLTEXT KEY `ftCategories` (`Categories`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

/*Table structure for table `sys_object_cmt` */

DROP TABLE IF EXISTS `sys_object_cmt`;

CREATE TABLE `sys_object_cmt` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `object_name` varchar(50) NOT NULL,
  `table_cmt` varchar(50) NOT NULL,
  `table_track` varchar(50) DEFAULT NULL,
  `per_view` smallint(6) NOT NULL,
  `is_ratable` smallint(1) NOT NULL,
  `is_on` smallint(1) NOT NULL,
  `is_mood` smallint(1) NOT NULL,
  `trigger_table` varchar(32) NOT NULL,
  `trigger_field_id` varchar(32) NOT NULL,
  `trigger_field_cmts` varchar(32) NOT NULL,
  `class` varchar(32) NOT NULL DEFAULT '',
  `extra_config` tinytext COMMENT '额外配置 这里主要存针对commentsModule扩展的配置',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=36 DEFAULT CHARSET=utf8;

/*Table structure for table `sys_object_thumb_vote` */

DROP TABLE IF EXISTS `sys_object_thumb_vote`;

CREATE TABLE `sys_object_thumb_vote` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `object_name` varchar(50) NOT NULL COMMENT 'ar 的类名',
  `table_track` varchar(50) NOT NULL COMMENT '投票跟踪表 防止重复投票',
  `row_prefix` varchar(20) NOT NULL DEFAULT '' COMMENT '行前缀 join表时防止冲突',
  `duplicate_sec` int(10) NOT NULL DEFAULT '0' COMMENT '判断是重复的秒数阈值',
  `trigger_table` varchar(60) NOT NULL,
  `trigger_field_up_vote` varchar(60) NOT NULL DEFAULT '''up_votes''',
  `trigger_field_down_vote` varchar(60) NOT NULL DEFAULT '''down_votes''',
  `trigger_field_id` varchar(60) NOT NULL DEFAULT '''id''',
  `is_on` smallint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

/*Table structure for table `sys_object_view` */

DROP TABLE IF EXISTS `sys_object_view`;

CREATE TABLE `sys_object_view` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(32) NOT NULL COMMENT '唯一 一般是ar类名称',
  `table_track` varchar(32) NOT NULL COMMENT '跟踪每次点击的表名',
  `period` int(11) NOT NULL DEFAULT '86400' COMMENT '多长时间内不重复累积',
  `trigger_table` varchar(32) NOT NULL COMMENT '触发的主表 即ar所对应的表名',
  `trigger_field_id` varchar(32) NOT NULL DEFAULT '''id''' COMMENT '主键名称',
  `trigger_field_views` varchar(32) NOT NULL DEFAULT '''views''' COMMENT '记录点击量的字段名称',
  `enable` tinyint(2) NOT NULL DEFAULT '1' COMMENT '是否启用',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=43 DEFAULT CHARSET=utf8;

/*Table structure for table `sys_object_vote` */

DROP TABLE IF EXISTS `sys_object_vote`;

CREATE TABLE `sys_object_vote` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `object_name` varchar(50) NOT NULL COMMENT 'ar 的类名',
  `table_rating` varchar(50) NOT NULL COMMENT 'rating表名字',
  `table_track` varchar(50) NOT NULL COMMENT '投票跟踪表 防止重复投票',
  `row_prefix` varchar(20) NOT NULL COMMENT '行前缀 join表时防止冲突',
  `max_votes` smallint(2) NOT NULL COMMENT '最大投票数 一般是5',
  `duplicate_sec` int(10) NOT NULL COMMENT '判断是重复的秒数阈值',
  `trigger_table` varchar(60) NOT NULL,
  `trigger_field_rate` varchar(60) NOT NULL,
  `trigger_field_rate_count` varchar(60) NOT NULL,
  `trigger_field_id` varchar(60) NOT NULL,
  `override_class` varchar(256) NOT NULL DEFAULT '' COMMENT '重载类别名 最好用相对于applicaiton的',
  `post_name` varchar(50) NOT NULL DEFAULT 'rate' COMMENT '投票时用的postParam名称',
  `is_on` smallint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=41 DEFAULT CHARSET=utf8;

/*Table structure for table `sys_photo` */

DROP TABLE IF EXISTS `sys_photo`;

CREATE TABLE `sys_photo` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id 主键',
  `categories` text COMMENT '暂时不用',
  `uid` int(10) unsigned DEFAULT NULL,
  `mime_type` varchar(16) NOT NULL DEFAULT '',
  `ext` varchar(6) DEFAULT '',
  `size` int(10) DEFAULT '0',
  `title` varchar(255) DEFAULT '',
  `uri` varchar(255) DEFAULT '' COMMENT '暂时不支持',
  `desc` text NOT NULL,
  `tags` varchar(255) NOT NULL DEFAULT '',
  `create_time` int(11) NOT NULL DEFAULT '0',
  `views` int(11) DEFAULT '0',
  `rate` float NOT NULL DEFAULT '0',
  `rate_count` int(11) NOT NULL DEFAULT '0',
  `cmt_count` int(11) NOT NULL DEFAULT '0',
  `featured` tinyint(4) NOT NULL DEFAULT '0',
  `status` enum('approved','disapproved','pending') NOT NULL DEFAULT 'pending',
  `hash` varchar(32) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  UNIQUE KEY `Hash` (`hash`),
  KEY `Owner` (`uid`),
  KEY `Date` (`create_time`),
  FULLTEXT KEY `ftMain` (`title`,`tags`,`desc`,`categories`),
  FULLTEXT KEY `ftTags` (`tags`),
  FULLTEXT KEY `ftCategories` (`categories`)
) ENGINE=InnoDB AUTO_INCREMENT=61 DEFAULT CHARSET=utf8 COMMENT='这个表是系统用的 可以用来在前台形成系统空间 比如新闻 相册 日志 banner 等引用到的图片都可引用 ';

/*Table structure for table `sys_slider` */

DROP TABLE IF EXISTS `sys_slider`;

CREATE TABLE `sys_slider` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pos_id` varchar(120) NOT NULL COMMENT '所属的位置 如index_bottom.',
  `link_url` varchar(255) NOT NULL DEFAULT '#' COMMENT '点击后跳转路径 也可以不跳',
  `img_src` varchar(255) NOT NULL COMMENT '图片路径',
  `img_title` varchar(120) DEFAULT NULL COMMENT '图片标题',
  `text` varchar(1000) DEFAULT '0' COMMENT '也可以是文字 如果有这个那么图片的设置忽略',
  `order` tinyint(3) NOT NULL DEFAULT '0' COMMENT '同一位置上出现的顺序',
  `active` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否启用',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `sys_slider_position` */

DROP TABLE IF EXISTS `sys_slider_position`;

CREATE TABLE `sys_slider_position` (
  `id` varchar(120) NOT NULL COMMENT '系统页面中出现的slider位置键如index_top',
  `width` varchar(15) NOT NULL DEFAULT '100%' COMMENT '宽度 可以用百分比或像素整数',
  `height` varchar(15) NOT NULL DEFAULT '100%' COMMENT '高度设置 同宽度',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `tbl_comments` */

DROP TABLE IF EXISTS `tbl_comments`;

CREATE TABLE `tbl_comments` (
  `object_name` varchar(50) NOT NULL,
  `object_id` int(12) NOT NULL,
  `cmt_id` int(12) NOT NULL AUTO_INCREMENT,
  `cmt_parent_id` int(12) DEFAULT NULL,
  `author_id` int(12) DEFAULT NULL,
  `user_name` varchar(128) DEFAULT NULL,
  `user_email` varchar(128) DEFAULT NULL,
  `cmt_text` text,
  `create_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  `status` int(1) NOT NULL DEFAULT '0',
  `replies` int(6) NOT NULL DEFAULT '0',
  `mood` tinyint(4) NOT NULL DEFAULT '0' COMMENT '心情 0 表示natural',
  PRIMARY KEY (`cmt_id`),
  KEY `owner_name` (`object_name`,`object_id`)
) ENGINE=InnoDB AUTO_INCREMENT=303 DEFAULT CHARSET=utf8;

/*Table structure for table `tbl_migration` */

DROP TABLE IF EXISTS `tbl_migration`;

CREATE TABLE `tbl_migration` (
  `version` varchar(255) NOT NULL,
  `apply_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `thumbsup_items` */

DROP TABLE IF EXISTS `thumbsup_items`;

CREATE TABLE `thumbsup_items` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `closed` tinyint(1) unsigned NOT NULL,
  `date` int(11) unsigned NOT NULL,
  `votes_up` int(11) NOT NULL DEFAULT '0',
  `votes_down` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQUE_NAME` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `thumbsup_votes` */

DROP TABLE IF EXISTS `thumbsup_votes`;

CREATE TABLE `thumbsup_votes` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `item_id` int(11) unsigned NOT NULL,
  `value` tinyint(1) unsigned NOT NULL,
  `ip` varchar(255) DEFAULT NULL,
  `date` int(11) unsigned NOT NULL,
  `user_id` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `token` */

DROP TABLE IF EXISTS `token`;

CREATE TABLE `token` (
  `user_id` int(11) NOT NULL,
  `code` varchar(32) NOT NULL,
  `created_at` int(11) NOT NULL,
  `type` smallint(6) NOT NULL,
  UNIQUE KEY `token_unique` (`user_id`,`code`,`type`),
  CONSTRAINT `fk_user_token` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `user` */

DROP TABLE IF EXISTS `user`;

CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password_hash` varchar(60) NOT NULL,
  `auth_key` varchar(32) NOT NULL,
  `confirmed_at` int(11) DEFAULT NULL,
  `unconfirmed_email` varchar(255) DEFAULT NULL,
  `blocked_at` int(11) DEFAULT NULL,
  `registration_ip` varchar(45) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  `flags` int(11) NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_unique_email` (`email`),
  UNIQUE KEY `user_unique_username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;

/*Table structure for table `user_data` */

DROP TABLE IF EXISTS `user_data`;

CREATE TABLE `user_data` (
  `user_id` int(11) unsigned NOT NULL COMMENT '用户主键id',
  `attr` varchar(250) NOT NULL COMMENT '属性 用户键',
  `val` text NOT NULL COMMENT '对应的值 格式自己决定 推荐用json',
  UNIQUE KEY `user-key` (`user_id`,`attr`),
  KEY `ikEntity` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户 EAV表 放用户特定信息';

/*Table structure for table `user_glean` */

DROP TABLE IF EXISTS `user_glean`;

CREATE TABLE `user_glean` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL COMMENT '收藏者',
  `object_type` varchar(50) NOT NULL COMMENT '收藏类型 表名即可',
  `object_id` int(11) NOT NULL COMMENT '对应的主键',
  `object_glean_profile` varchar(255) NOT NULL COMMENT '收集对象的概要描述 跨模块问题 决定序列化被收集对象了',
  `ctime` int(11) NOT NULL COMMENT '收藏时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5959 DEFAULT CHARSET=utf8 COMMENT='¸öÈËÊÕ²Ø';

/*Table structure for table `user_profile` */

DROP TABLE IF EXISTS `user_profile`;

CREATE TABLE `user_profile` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `photo` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`user_id`),
  CONSTRAINT `user_profile_id` FOREIGN KEY (`user_id`) REFERENCES `user_v0` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

/*Table structure for table `user_profile_field` */

DROP TABLE IF EXISTS `user_profile_field`;

CREATE TABLE `user_profile_field` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `varname` varchar(50) NOT NULL DEFAULT '',
  `title` varchar(255) NOT NULL DEFAULT '',
  `field_type` varchar(50) NOT NULL DEFAULT '',
  `field_size` int(3) NOT NULL DEFAULT '0',
  `field_size_min` int(3) NOT NULL DEFAULT '0',
  `required` int(1) NOT NULL DEFAULT '0',
  `match` varchar(255) NOT NULL DEFAULT '',
  `range` varchar(255) NOT NULL DEFAULT '',
  `error_message` varchar(255) NOT NULL DEFAULT '',
  `other_validator` text,
  `default` varchar(255) NOT NULL DEFAULT '',
  `widget` varchar(255) NOT NULL DEFAULT '',
  `widgetparams` text,
  `position` int(3) NOT NULL DEFAULT '0',
  `visible` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

/*Table structure for table `user_space_visit_stat` */

DROP TABLE IF EXISTS `user_space_visit_stat`;

CREATE TABLE `user_space_visit_stat` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `target` int(11) DEFAULT NULL,
  `day` date NOT NULL,
  `times` int(5) unsigned NOT NULL DEFAULT '0' COMMENT 'quantity',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8361 DEFAULT CHARSET=utf8 COMMENT='空间访问量日统计';

/*Table structure for table `user_space_visitor` */

DROP TABLE IF EXISTS `user_space_visitor`;

CREATE TABLE `user_space_visitor` (
  `space_id` int(11) NOT NULL COMMENT '被访问者的uid',
  `visitor_id` int(11) NOT NULL COMMENT '当前访客的uid 参考user.uid',
  `vtime` int(11) NOT NULL COMMENT '高效的查询仍旧需要 在三个字段上建立索引',
  PRIMARY KEY (`space_id`,`visitor_id`),
  KEY `space_id` (`space_id`,`visitor_id`,`vtime`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户空间访客记录';

/*Table structure for table `user_v0` */

DROP TABLE IF EXISTS `user_v0`;

CREATE TABLE `user_v0` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(20) NOT NULL DEFAULT '',
  `password` varchar(128) NOT NULL DEFAULT '',
  `icon_uri` varchar(255) DEFAULT NULL COMMENT 'the user icon url path',
  `email` varchar(128) NOT NULL DEFAULT '',
  `activkey` varchar(128) NOT NULL DEFAULT '',
  `superuser` int(1) NOT NULL DEFAULT '0',
  `status` int(1) NOT NULL DEFAULT '0',
  `create_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `lastvisit_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_username` (`username`),
  UNIQUE KEY `user_email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

/*Table structure for table `yiisession` */

DROP TABLE IF EXISTS `yiisession`;

CREATE TABLE `yiisession` (
  `id` char(32) NOT NULL,
  `expire` int(11) DEFAULT NULL,
  `data` longblob,
  `user_id` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `ys_admin` */

DROP TABLE IF EXISTS `ys_admin`;

CREATE TABLE `ys_admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(60) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(64) DEFAULT NULL,
  `salt` varchar(255) DEFAULT NULL,
  `last_ip` varchar(64) DEFAULT NULL,
  `last_time` int(11) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
