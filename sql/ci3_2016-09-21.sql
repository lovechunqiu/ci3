# ************************************************************
# Sequel Pro SQL dump
# Version 4096
#
# http://www.sequelpro.com/
# http://code.google.com/p/sequel-pro/
#
# Host: 127.0.0.1 (MySQL 5.7.11)
# Database: ci3
# Generation Time: 2016-09-21 07:54:40 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table admin
# ------------------------------------------------------------

DROP TABLE IF EXISTS `admin`;

CREATE TABLE `admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pid` int(10) DEFAULT '0' COMMENT '管理员pid',
  `user_name` varchar(50) NOT NULL COMMENT '用户名',
  `mobile` bigint(15) DEFAULT '0' COMMENT '手机号',
  `user_pass` varchar(50) NOT NULL COMMENT '密码',
  `user_group_id` smallint(6) NOT NULL COMMENT '用户组',
  `real_name` varchar(20) NOT NULL DEFAULT '匿名',
  `user_word` varchar(100) NOT NULL COMMENT '密码口令',
  `created_time` int(11) NOT NULL COMMENT '创建时间',
  `updated_time` int(11) NOT NULL COMMENT '修改时间',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '0 表示删除, 1表示生效',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `admin` WRITE;
/*!40000 ALTER TABLE `admin` DISABLE KEYS */;

INSERT INTO `admin` (`id`, `pid`, `user_name`, `mobile`, `user_pass`, `user_group_id`, `real_name`, `user_word`, `created_time`, `updated_time`, `status`)
VALUES
	(1,0,'admin',0,'21232f297a57a5a743894a0e4a801fc3',1,'超级管理员','admin',1442481135,1468030193,1);

/*!40000 ALTER TABLE `admin` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table admin_auth
# ------------------------------------------------------------

DROP TABLE IF EXISTS `admin_auth`;

CREATE TABLE `admin_auth` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `controller` text,
  `groupname` varchar(100) NOT NULL COMMENT '权限组名',
  `created_time` int(11) DEFAULT NULL COMMENT '创建时间',
  `updated_time` int(11) DEFAULT NULL COMMENT '修改时间',
  `status` tinyint(1) DEFAULT '1' COMMENT '0 表示删除, 1表示生效',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='后台权限表';

LOCK TABLES `admin_auth` WRITE;
/*!40000 ALTER TABLE `admin_auth` DISABLE KEYS */;

INSERT INTO `admin_auth` (`id`, `controller`, `groupname`, `created_time`, `updated_time`, `status`)
VALUES
	(1,'a:5:{s:7:\"setting\";a:5:{i:0;s:3:\"at1\";i:1;s:3:\"at2\";i:2;s:3:\"at3\";i:3;s:3:\"at4\";i:4;s:4:\"at22\";}s:9:\"adminlogs\";a:4:{i:0;s:10:\"adminlogs1\";i:1;s:10:\"adminlogs2\";i:2;s:10:\"adminlogs3\";i:3;s:10:\"adminlogs4\";}s:7:\"welcome\";a:1:{i:0;s:4:\"wel1\";}s:4:\"auth\";a:4:{i:0;s:4:\"at73\";i:1;s:4:\"at74\";i:2;s:4:\"at75\";i:3;s:4:\"at76\";}s:9:\"adminuser\";a:5:{i:0;s:4:\"at77\";i:1;s:4:\"at78\";i:2;s:4:\"at79\";i:3;s:4:\"at99\";i:4;s:4:\"at80\";}}','超级管理员权限',1443410228,1474444348,1);

/*!40000 ALTER TABLE `admin_auth` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table admin_logs
# ------------------------------------------------------------

DROP TABLE IF EXISTS `admin_logs`;

CREATE TABLE `admin_logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `aid` int(10) DEFAULT NULL COMMENT '操作者id',
  `name` varchar(50) DEFAULT NULL COMMENT '操作者用户名',
  `mobile` bigint(15) DEFAULT '0' COMMENT '手机号',
  `ip` varchar(16) DEFAULT NULL COMMENT '操作者IP',
  `desc` varchar(200) DEFAULT NULL COMMENT '描述',
  `type` int(10) DEFAULT '0' COMMENT '类型，0表示登陆和退出，-100表示其他。默认为0',
  `tid` int(10) DEFAULT '0' COMMENT '不同的类型下面所对应的操作id',
  `created_time` int(11) NOT NULL COMMENT '创建时间',
  `updated_time` int(11) NOT NULL COMMENT '修改时间',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '0 表示删除, 1表示生效',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='管理员日志表';



# Dump of table user
# ------------------------------------------------------------

DROP TABLE IF EXISTS `user`;

CREATE TABLE `user` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `username` varchar(255) NOT NULL COMMENT '用户名称',
  `password` varchar(255) NOT NULL COMMENT '密码',
  `weight` int(11) DEFAULT '0' COMMENT '权重，默认0',
  `remarks` text COMMENT '备注',
  `created_time` int(11) NOT NULL COMMENT '创建时间',
  `updated_time` int(11) NOT NULL COMMENT '修改时间',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '0 表示删除, 1表示生效',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户表';

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;

INSERT INTO `user` (`id`, `username`, `password`, `weight`, `remarks`, `created_time`, `updated_time`, `status`)
VALUES
	(1,'111','222',0,NULL,1471318820,1471318820,1),
	(2,'3231','21313',0,NULL,1471400107,1471400107,1),
	(3,'12313dsaa','dasdasdas',0,NULL,1471484520,1471484520,1),
	(4,'ddd','ddd',0,NULL,1474179412,1474179412,1),
	(5,'lideqiang','lideqiang',0,NULL,1474429478,1474429478,1);

/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table web_global
# ------------------------------------------------------------

DROP TABLE IF EXISTS `web_global`;

CREATE TABLE `web_global` (
  `id` smallint(6) NOT NULL AUTO_INCREMENT,
  `type` varchar(10) NOT NULL COMMENT '参数类型',
  `text` text COMMENT '参数内容',
  `name` varchar(50) NOT NULL DEFAULT '' COMMENT '参数名称',
  `tip` varchar(200) NOT NULL DEFAULT '' COMMENT '参数说明',
  `order_sn` int(11) NOT NULL DEFAULT '0' COMMENT '参数排序',
  `code` varchar(20) NOT NULL DEFAULT '' COMMENT '参数代码',
  `is_sys` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '是否是系统参数',
  `params` text COMMENT '参数，json格式',
  `dis_abled` tinyint(1) DEFAULT '0' COMMENT '是否允许编辑，1不允许，默认为0',
  `created_time` int(11) unsigned DEFAULT NULL COMMENT '创建时间戳',
  `updated_time` int(11) unsigned DEFAULT NULL COMMENT '修改时间戳',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '0 表示删除, 1表示生效',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='网站设置';

LOCK TABLES `web_global` WRITE;
/*!40000 ALTER TABLE `web_global` DISABLE KEYS */;

INSERT INTO `web_global` (`id`, `type`, `text`, `name`, `tip`, `order_sn`, `code`, `is_sys`, `params`, `dis_abled`, `created_time`, `updated_time`, `status`)
VALUES
	(1,'input','测试中','网站名称','出现在每个页面的title后面',0,'web_name',1,NULL,0,1445859161,1474441864,1),
	(2,'input','测试首页','首页title','首页标题',0,'index_title',1,NULL,0,1445859205,1474441864,1),
	(3,'textarea','后台','网站关键词','在首页的keywords中显示',0,'web_keywords',1,NULL,0,1445859235,1474441864,1),
	(4,'textarea','测试','网站描述','在网站首页的描述中显示',0,'web_descript',1,NULL,0,1445859266,1474441864,1),
	(5,'input','网页底部','网站底部','网站底部的版权和联系信息',0,'bottom',1,NULL,0,1445859309,1474441864,1),
	(6,'input','ICP','ICP号','备案号',0,'icp',1,NULL,0,1445859736,1474441864,1);

/*!40000 ALTER TABLE `web_global` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
