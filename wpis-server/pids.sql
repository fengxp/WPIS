-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 2017-03-14 02:41:05
-- 服务器版本： 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `pids`
--

-- --------------------------------------------------------

--
-- 表的结构 `ps_auth_group`
--

CREATE TABLE IF NOT EXISTS `ps_auth_group` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `title` char(100) NOT NULL DEFAULT '',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `rules` varchar(255) NOT NULL DEFAULT '',
  `device` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=22 ;

--
-- 转存表中的数据 `ps_auth_group`
--

INSERT INTO `ps_auth_group` (`id`, `title`, `status`, `rules`, `device`) VALUES
(1, '超级管理员', 1, '1,2,58,65,59,60,61,62,3,56,4,6,5,7,8,9,10,51,52,53,57,11,54,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,29,30,31,32,33,34,36,37,38,39,40,41,42,43,44,45,46,47,63,48,49,50,55', '1,17,16,14'),
(2, '管理员', 0, '13,14,23,22,21,20,19,18,17,16,15,24,36,34,33,32,31,30,29,27,26,25,1', NULL),
(3, '普通用户', 1, '1,2,4,58,3,5,7,64,8,9,11,12,48,49,50,55,48', '1,17,16,14'),
(18, '6号线设备管理-发布管理-日志管理权限组', 1, '1,74,75,80,89,90,81,82,83', '1,15,19'),
(19, '4号线设备管理-发布管理-日志管理权限组(A出口)', 1, '1,74,75,80,89,90,81,82,83', '1,16,14,20'),
(20, '4号线设备管理-发布管理-日志管理权限组(B出口)', 1, '1,74,75,80,89,90,81,82,83', '1,16,14,20'),
(21, '测试组', 0, '0', '');

-- --------------------------------------------------------

--
-- 表的结构 `ps_auth_group_access`
--

CREATE TABLE IF NOT EXISTS `ps_auth_group_access` (
  `uid` mediumint(8) unsigned NOT NULL,
  `group_id` mediumint(8) unsigned NOT NULL,
  UNIQUE KEY `uid_group_id` (`uid`,`group_id`),
  KEY `uid` (`uid`),
  KEY `group_id` (`group_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `ps_auth_group_access`
--

INSERT INTO `ps_auth_group_access` (`uid`, `group_id`) VALUES
(1, 1),
(3, 7),
(26, 18),
(27, 20),
(28, 20),
(29, 3);

-- --------------------------------------------------------

--
-- 表的结构 `ps_auth_rule`
--

CREATE TABLE IF NOT EXISTS `ps_auth_rule` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pid` int(11) NOT NULL,
  `name` char(80) NOT NULL DEFAULT '',
  `title` char(20) NOT NULL DEFAULT '',
  `icon` varchar(255) NOT NULL,
  `type` tinyint(1) NOT NULL DEFAULT '1',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `condition` char(100) NOT NULL DEFAULT '',
  `islink` tinyint(1) NOT NULL DEFAULT '1',
  `o` int(11) NOT NULL COMMENT '排序',
  `tips` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=133 ;

--
-- 转存表中的数据 `ps_auth_rule`
--

INSERT INTO `ps_auth_rule` (`id`, `pid`, `name`, `title`, `icon`, `type`, `status`, `condition`, `islink`, `o`, `tips`) VALUES
(39, 37, 'Link/add', '增加链接', '', 1, 1, '', 1, 39, ''),
(40, 37, 'Link/edit', '编辑链接', '', 1, 1, '', 0, 40, ''),
(41, 37, 'Link/update', '保存链接', '', 1, 1, '', 0, 41, ''),
(37, 0, '', '链接管理', 'menu-icon fa fa-legal', 1, 1, '', 0, 37, ''),
(73, 71, 'Templet/lists', '模板列表', 'menu-icon fa fa-caret-right', 1, 1, '', 1, 42, ''),
(67, 65, 'Media/add', '增加素材', 'menu-icon fa fa-caret-right', 1, 1, '', 1, 2, ''),
(69, 65, 'Media/edit', '修改素材', '', 1, 1, '', 0, 60, ''),
(70, 65, 'Media/del', '删除素材', '', 1, 1, '', 0, 0, ''),
(68, 65, 'Media/see', '查看素材', '', 1, 1, '', 0, 0, ''),
(23, 13, 'Group/del', '删除用户组', '', 1, 1, '', 0, 23, ''),
(22, 13, 'Group/update', '保存用户组', 'menu-icon fa fa-caret-right', 1, 1, '', 0, 22, ''),
(21, 13, 'Group/edit', '编辑用户组', 'menu-icon fa fa-caret-right', 1, 1, '', 0, 21, ''),
(20, 13, 'Group/add', '新增用户组', 'menu-icon fa fa-caret-right', 1, 1, '', 1, 20, ''),
(19, 13, 'Group/index', '用户组管理', 'menu-icon fa fa-caret-right', 1, 1, '', 1, 19, ''),
(18, 13, 'Member/del', '删除用户', '', 1, 1, '', 0, 18, ''),
(17, 13, 'Member/update', '保存用户', 'menu-icon fa fa-caret-right', 1, 1, '', 0, 17, ''),
(16, 13, 'Member/edit', '编辑用户', 'menu-icon fa fa-caret-right', 1, 1, '', 0, 16, ''),
(14, 13, 'Member/index', '用户管理', 'menu-icon fa fa-caret-right', 1, 1, '', 1, 14, ''),
(15, 13, 'Member/add', '新增用户', 'menu-icon fa fa-caret-right', 1, 1, '', 1, 15, ''),
(13, 0, '', '用户及组', 'menu-icon fa fa-users', 1, 1, '', 1, 30, ''),
(12, 2, 'Update/devlog', '开发日志', 'menu-icon fa fa-caret-right', 1, 1, '', 1, 12, ''),
(11, 2, 'Update/update', '在线升级', 'menu-icon fa fa-caret-right', 1, 1, '', 1, 11, ''),
(10, 9, 'Database/recovery', '数据库还原', '', 1, 1, '', 0, 10, ''),
(9, 2, 'Database/backup', '数据库备份', 'menu-icon fa fa-caret-right', 1, 1, '', 1, 9, ''),
(8, 2, 'Menu/del', '删除菜单', 'menu-icon fa fa-caret-right', 1, 1, '', 0, 8, ''),
(7, 2, 'Menu/update', '保存菜单', 'menu-icon fa fa-caret-right', 1, 1, '', 0, 7, ''),
(71, 0, 'Templet/index', '模板管理', 'menu-icon fa fa-newspaper-o', 1, 1, '', 1, 60, ''),
(66, 65, 'Media/lists', '素材列表', 'menu-icon fa fa-caret-right', 1, 1, '', 1, 1, ''),
(42, 37, 'Link/del', '删除链接', '', 1, 1, '', 0, 42, ''),
(38, 37, 'Link/index', '友情链接', 'menu-icon fa fa-caret-right', 1, 1, '', 1, 38, ''),
(6, 4, 'Menu/edit', '编辑菜单', '', 1, 1, '', 0, 6, ''),
(5, 2, 'Menu/add', '新增菜单', 'menu-icon fa fa-caret-right', 1, 1, '', 0, 5, ''),
(64, 2, 'Menu/edit', '修改菜单', '', 1, 1, '', 0, 8, ''),
(65, 0, 'Media/index', '素材管理', 'menu-icon fa fa-file-video-o', 1, 1, '', 1, 50, '管理素材'),
(3, 2, 'Setting/setting', '站点设置', 'menu-icon fa fa-caret-right', 1, 1, '', 0, 3, '这是网站设置的提示。'),
(4, 2, 'Menu/index', '菜单设置', 'menu-icon fa fa-caret-right', 1, 1, '', 1, 0, ''),
(2, 0, '', '系统设置', 'menu-icon fa fa-cog', 1, 1, '', 1, 20, ''),
(72, 71, 'Templet/add', '增加模板', 'menu-icon fa fa-caret-right', 1, 1, '', 1, 43, ''),
(1, 0, 'Index/index', '控制台', 'menu-icon fa fa-tachometer', 1, 1, '', 1, 10, '友情提示：经常查看操作日志，发现异常以便及时追查原因。'),
(48, 0, 'Personal/index', '个人中心', 'menu-icon fa fa-user', 1, 1, '', 0, 1000, ''),
(49, 48, 'Personal/profile', '个人资料', 'menu-icon fa fa-user', 1, 1, '', 1, 49, ''),
(50, 48, 'Logout/index', '退出', '', 1, 1, '', 1, 50, ''),
(51, 9, 'Database/export', '备份', '', 1, 1, '', 0, 51, ''),
(52, 9, 'Database/optimize', '数据优化', '', 1, 1, '', 0, 52, ''),
(53, 9, 'Database/repair', '修复表', '', 1, 1, '', 0, 53, ''),
(54, 11, 'Update/updating', '升级安装', '', 1, 1, '', 0, 54, ''),
(55, 48, 'Personal/update', '资料保存', '', 1, 1, '', 0, 55, ''),
(56, 3, 'Setting/update', '设置保存', '', 1, 1, '', 0, 56, ''),
(57, 9, 'Database/del', '备份删除', '', 1, 1, '', 0, 57, ''),
(58, 2, 'variable/index', '自定义变量', '', 1, 1, '', 1, 1, ''),
(59, 58, 'variable/add', '新增变量', '', 1, 1, '', 0, 0, ''),
(60, 58, 'variable/edit', '编辑变量', '', 1, 1, '', 0, 0, ''),
(61, 58, 'variable/update', '保存变量', '', 1, 1, '', 0, 0, ''),
(62, 58, 'variable/del', '删除变量', '', 1, 1, '', 0, 0, ''),
(74, 0, 'Device/index', '设备管理', 'menu-icon fa fa-tree', 1, 1, '', 1, 40, ''),
(75, 74, 'Device/lists', '设备列表', 'menu-icon fa fa-caret-right', 1, 1, '', 1, 1, ''),
(76, 0, '', '节目单管理', 'menu-icon fa fa-film', 1, 1, '', 1, 70, '节目单管理'),
(77, 76, 'Program/videoLists', '视频节目单', 'menu-icon fa fa-caret-right', 1, 1, '', 1, 1, ''),
(78, 76, 'Program/imgLists', '图片节目单', 'menu-icon fa fa-caret-right', 1, 1, '', 1, 2, ''),
(79, 76, 'Program/add', '新增节目单', '', 1, 1, '', 0, 3, ''),
(80, 0, 'Publish', '发布管理', 'menu-icon fa fa-anchor', 1, 1, '', 1, 80, ''),
(81, 80, 'Publish/index', '发布模版', '', 1, 1, '', 1, 3, ''),
(82, 80, 'Info/index', '发布信息', '', 1, 1, '', 1, 6, ''),
(83, 80, 'Order/index', '发布指令', '', 1, 1, '', 1, 7, ''),
(84, 0, 'Log', '日志管理', 'menu-icon fa fa-building-o', 1, 1, '', 1, 90, ''),
(85, 84, 'Log/program', '模版日志', '', 1, 1, '', 1, 3, ''),
(86, 84, 'Log/info', '信息日志', '', 1, 1, '', 1, 6, ''),
(87, 84, 'Log/order', '指令日志', '', 1, 1, '', 1, 7, ''),
(98, 1, 'Index/monitor', '监控管理', 'menu-icon fa fa-caret-right', 1, 1, '', 1, 1, '监控管理'),
(89, 80, 'Publish/videoindex', '发布视频', '', 1, 1, '', 1, 1, ''),
(90, 80, 'Publish/imgindex', '发布图片', '', 1, 1, '', 1, 2, ''),
(91, 84, 'Log/videoprogram', '视频日志', '', 1, 1, '', 1, 1, ''),
(92, 84, 'Log/imgprogram', '图片日志', '', 1, 1, '', 1, 2, ''),
(93, 81, 'Publish/program', '发布模板', '', 1, 1, '', 1, 0, ''),
(94, 90, 'Publish/imgprogram', '发布图片', '', 1, 1, '', 0, 0, ''),
(95, 89, 'Publish/videoprogram', '发布视频', '', 1, 1, '', 0, 0, ''),
(96, 82, 'Info/add', '发布信息', '', 1, 1, '', 0, 0, ''),
(97, 83, 'Order/add', '发布指令', '', 1, 1, '', 0, 0, ''),
(99, 76, 'Program/see', '查看节目单', '', 1, 1, '', 0, 0, ''),
(105, 65, 'Media/auditlists', '素材审核', '', 1, 1, '', 1, 3, ''),
(106, 65, 'Media/auditsee', '审核素材', '', 1, 1, '', 0, 0, ''),
(107, 74, 'Device/repairlists', '维修管理', '', 1, 1, '', 1, 2, ''),
(108, 74, 'Device/repairadd', '新增维修管理', '', 1, 1, '', 0, 0, ''),
(109, 74, 'Device/repairedit', '修改维修管理', '', 1, 1, '', 0, 0, ''),
(110, 74, 'Device/repairsee', '查看维修管理', '', 1, 1, '', 0, 0, ''),
(111, 76, 'Program/preinfolists', '预定义信息', '', 1, 1, '', 1, 3, ''),
(112, 76, 'Program/preinfoadd', '新增预定义信息', '', 1, 1, '', 0, 0, ''),
(113, 0, 'Monitor', '监控管理', 'menu-icon fa fa-desktop', 1, 1, '', 1, 100, ''),
(114, 0, 'Advert', '广告管理', 'menu-icon fa fa-bank', 1, 1, '', 1, 110, ''),
(115, 76, 'Program/preinfosee', '查看预定义信息', '', 1, 1, '', 0, 0, ''),
(116, 76, 'Program/preinfoedit', '修改预定义信息', '', 1, 1, '', 0, 0, ''),
(117, 80, 'Publish/preinfoindex', '发布预定义信息', '', 1, 1, '', 1, 4, ''),
(118, 80, 'Publish/streamindex', '发布流媒体', '', 1, 1, '', 1, 5, ''),
(119, 80, 'Publish/preinfoprogram', '发布预定义信息', '', 1, 1, '', 0, 0, ''),
(120, 84, 'Log/preinfoprogram', '预定义信息日志', '', 1, 1, '', 1, 4, ''),
(122, 84, 'Log/streamprogram', '流媒体日志', '', 1, 1, '', 1, 5, ''),
(123, 80, 'Publish/streamprogram', '发布流媒体', '', 1, 1, '', 0, 0, ''),
(124, 80, 'Publish/streamsee', '查看流媒体', '', 1, 1, '', 0, 0, ''),
(125, 114, 'Advert/advertlists', '广告统计', '', 1, 1, '', 1, 0, ''),
(126, 114, 'Advert/contractlists', '合同管理', '', 1, 1, '', 1, 0, ''),
(127, 114, 'Advert/contractadd', '新增合同管理', '', 1, 1, '', 0, 0, ''),
(128, 113, 'Monitor/net', '网管/监控', '', 1, 1, '', 1, 0, ''),
(129, 113, 'Monitor/monitor', '监视', '', 1, 1, '', 1, 0, ''),
(130, 113, 'Monitor/file', '文件下载', '', 1, 1, '', 1, 0, ''),
(131, 114, 'Advert/contractsee', '查看合同管理', '', 1, 1, '', 0, 0, ''),
(132, 114, 'Advert/contractedit', '修改合同管理', '', 1, 1, '', 0, 0, '');

-- --------------------------------------------------------

--
-- 表的结构 `ps_calendar`
--

CREATE TABLE IF NOT EXISTS `ps_calendar` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL,
  `starttime` datetime(6) NOT NULL,
  `endtime` datetime(6) DEFAULT NULL,
  `allday` tinyint(1) NOT NULL DEFAULT '0',
  `color` varchar(20) DEFAULT NULL,
  `rules` varchar(600) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=27 ;

-- --------------------------------------------------------

--
-- 表的结构 `ps_contract`
--

CREATE TABLE IF NOT EXISTS `ps_contract` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `contractnum` varchar(30) DEFAULT NULL,
  `advertiser` varchar(160) DEFAULT NULL,
  `sub_time` int(11) DEFAULT NULL,
  `contracts` varchar(60) DEFAULT NULL,
  `begindate` int(11) DEFAULT NULL,
  `enddate` int(11) DEFAULT NULL,
  `name` varchar(160) DEFAULT NULL,
  `cost` decimal(10,2) DEFAULT NULL,
  `type` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=17 ;

--
-- 转存表中的数据 `ps_contract`
--

INSERT INTO `ps_contract` (`id`, `contractnum`, `advertiser`, `sub_time`, `contracts`, `begindate`, `enddate`, `name`, `cost`, `type`) VALUES
(9, '20170227-133541', '星辉公司', 1488173780, '小何同学', 1485878400, 1527782400, '我的第一份合同', NULL, '1'),
(10, '20170227-133623', '华谊兄弟', 1488184119, '小何同学', 1485964800, 1488470400, '我的第二份合同', NULL, '2'),
(11, '20170302-143909', '中国星', 1488436785, '小何', 1488988800, 1490284800, '我的第三份合同', NULL, '1'),
(12, '20170302-145151', '星辉公司', 1488437544, '何同学', 1488902400, 1490284800, '第4份', NULL, '1'),
(13, '20170302-145226', '星辉公司', 1488437571, '小何同学', 1489593600, 1490457600, '第5份合同', NULL, '2'),
(14, '20170302-151825', '中国星', 1488439131, '小何同学', 1488297600, 1491667200, '我的第6份合同', NULL, '1'),
(15, '20170306-091738', 'test', 1488763093, 'test', 1488729600, 1530374400, 'test111', NULL, '1'),
(16, '20170313-140048', 'test', 1489384875, '11111', 1489507200, 1491667200, 'test', NULL, '1');

-- --------------------------------------------------------

--
-- 表的结构 `ps_device`
--

CREATE TABLE IF NOT EXISTS `ps_device` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `p_id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `type` tinyint(4) NOT NULL,
  `sub_time` int(11) DEFAULT NULL,
  `status` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='设备表' AUTO_INCREMENT=21 ;

--
-- 转存表中的数据 `ps_device`
--

INSERT INTO `ps_device` (`id`, `p_id`, `name`, `type`, `sub_time`, `status`) VALUES
(1, -1, '设备列表', 1, 1466489407, NULL),
(17, 16, 'A出入口', 0, 1466489790, 'abnormal'),
(16, 14, '国家图书馆', 1, 1466489770, NULL),
(14, 1, '4号线', 1, 1466489736, NULL),
(15, 1, '6号线', 1, 1466489751, NULL),
(20, 16, 'B出入口', 0, 1480053045, 'normal'),
(19, 15, '物资学院路', 1, 1479101678, NULL);

-- --------------------------------------------------------

--
-- 表的结构 `ps_device_info`
--

CREATE TABLE IF NOT EXISTS `ps_device_info` (
  `id` int(11) NOT NULL,
  `addr1` varchar(200) NOT NULL,
  `addr2` varchar(200) DEFAULT NULL,
  `mac` varchar(200) NOT NULL,
  `cpu` int(11) DEFAULT NULL,
  `memory` int(11) DEFAULT NULL,
  `diskpercent` int(11) DEFAULT NULL,
  `status` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `ps_device_info`
--

INSERT INTO `ps_device_info` (`id`, `addr1`, `addr2`, `mac`, `cpu`, `memory`, `diskpercent`, `status`) VALUES
(17, '192.168.2.141', '192.168.8.101', '00:0b:ab:77:1c:f0', 60, 51, 71, 'abnormal'),
(20, '192.168.1.1', '192.168.1.202', 'MAC1.0.0.0.0.0.1', 20, 8, 66, 'normal');

-- --------------------------------------------------------

--
-- 表的结构 `ps_device_repair`
--

CREATE TABLE IF NOT EXISTS `ps_device_repair` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `device` text,
  `sub_time` int(11) DEFAULT NULL,
  `count` int(11) DEFAULT NULL,
  `repairer` varchar(30) DEFAULT NULL,
  `begindate` int(11) DEFAULT NULL,
  `enddate` int(11) DEFAULT NULL,
  `repairnum` varchar(200) DEFAULT NULL,
  `name` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- 转存表中的数据 `ps_device_repair`
--

INSERT INTO `ps_device_repair` (`id`, `device`, `sub_time`, `count`, `repairer`, `begindate`, `enddate`, `repairnum`, `name`) VALUES
(1, '1,17,16,14', 1487656179, 1, '小何', 1485878400, 1486742400, '20170221-133741', '维修单测试'),
(2, '1,15,19', 1487655762, 1, '小小', 1485878400, 1487347200, '20170221-134222', 'test维修单');

-- --------------------------------------------------------

--
-- 表的结构 `ps_devlog`
--

CREATE TABLE IF NOT EXISTS `ps_devlog` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `v` varchar(225) NOT NULL COMMENT '版本号',
  `y` int(4) NOT NULL COMMENT '年分',
  `t` int(10) NOT NULL COMMENT '发布日期',
  `log` text NOT NULL COMMENT '更新日志',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- 转存表中的数据 `ps_devlog`
--

INSERT INTO `ps_devlog` (`id`, `v`, `y`, `t`, `log`) VALUES
(1, '1.0.0', 2016, 1440259200, 'PIDS第一个版本发布。'),
(2, '1.0.1', 2016, 1440259200, '修改cookie过于简单的安全风险。');

-- --------------------------------------------------------

--
-- 表的结构 `ps_info`
--

CREATE TABLE IF NOT EXISTS `ps_info` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(200) NOT NULL,
  `type` tinyint(1) NOT NULL,
  `length` int(11) NOT NULL,
  `device` text NOT NULL,
  `status` tinyint(1) NOT NULL,
  `sub_time` int(11) NOT NULL,
  `update` int(11) DEFAULT NULL,
  `del` int(11) DEFAULT NULL,
  `content` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=60 ;

--
-- 转存表中的数据 `ps_info`
--

INSERT INTO `ps_info` (`id`, `title`, `type`, `length`, `device`, `status`, `sub_time`, `update`, `del`, `content`) VALUES
(2, '222', 3, 30, '1,17,16,14', 1, 1466758692, NULL, NULL, '22222'),
(3, 'tttt', 1, 30, '1,17,16,14', 1, 1467794053, NULL, NULL, 'ddddd'),
(4, '111', 1, 30, '1,17,16,14,18', 1, 1467794301, NULL, NULL, '111111'),
(5, 'hhhh', 1, 30, '1,17,16,14,18', 1, 1467794394, 1467881272, NULL, 'hhhh'),
(6, 'ggg', 1, 30, '1,17,16,14,18', 1, 1467794467, NULL, NULL, 'gggg'),
(7, 'dd', 1, 30, '1,17,16,14,18', 1, 1467795080, NULL, NULL, '得到'),
(8, 'hh', 1, 30, '1,17,16,14,18', 1, 1467795212, NULL, NULL, 'hh'),
(9, 'ddddd', 1, 30, '1,17,16,14,18', 1, 1467795284, NULL, NULL, '点点点点点点'),
(10, 'ss', 1, 30, '1,17,16,14,18', 1, 1467795549, NULL, NULL, 'sss'),
(11, 'rr', 1, 30, '1,17,16,14,18', 1, 1467795716, NULL, NULL, 'rr'),
(12, 'rr', 1, 30, '1,17,16,14,18', 1, 1467795738, NULL, NULL, 'rr'),
(13, 'rr', 1, 30, '1,17,16,14,18', 1, 1467795943, NULL, NULL, 'rr'),
(14, 'rr', 1, 30, '1,17,16,14,18', 1, 1467795957, NULL, NULL, 'rr'),
(15, 'rr', 1, 30, '1,17,16,14,18', 3, 1467796287, NULL, 1479777812, 'rr'),
(16, 'rr', 1, 30, '1,17,16,14,18', 1, 1467796374, NULL, NULL, 'rr'),
(17, '111', 1, 30, '1,17,16,14', 1, 1467859518, NULL, NULL, '111111'),
(18, '2222', 1, 30, '1,17,16,14', 1, 1467859690, NULL, NULL, '2222'),
(19, 'rrr', 1, 30, '1,17,16,14', 1, 1467859810, NULL, NULL, 'rrrr'),
(21, '111', 1, 30, '1,17,16,14', 1, 1467861844, NULL, NULL, '111'),
(22, '111', 1, 1, '1,17,16,14', 1, 1467862961, NULL, NULL, '1111'),
(27, 'ggg', 1, 30, '1,17,16,14,18', 1, 1467880832, 1467881353, NULL, 'ggg'),
(31, '测试信息发布功能', 1, 10, '1,15,19', 1, 1479781086, NULL, NULL, 'go fly'),
(32, '测试信息发布功能', 1, 10, '1,15,19', 1, 1479781514, 1479781787, NULL, 'go fly'),
(33, '测试', 1, 30, '1,15,19', 1, 1479781548, 1479781779, NULL, '测试'),
(34, 'asdf', 1, 30, '1,17,16,14', 1, 1482906469, NULL, NULL, 'sdf'),
(39, '111', 1, 30, '1,17,16,14,20', 3, 1483078580, 1483078734, 1486438141, '111'),
(43, 'ddd', 2, 30, '1,17,16,14,20', 1, 1483085199, NULL, NULL, '点点滴滴'),
(44, 'ffff', 3, 30, '1,17,16,14,20', 1, 1483085220, NULL, NULL, 'fffff'),
(45, 'dhh', 1, 30, '1,17,16,14', 1, 1483085332, NULL, NULL, 'hhhh'),
(46, 'ddd', 2, 30, '1,17,16,14', 3, 1483085366, NULL, 1486705944, '点点滴滴'),
(47, 'test', 1, 30, '1,17,16,14', 3, 1483421443, NULL, 1486618598, 'test'),
(55, 'dd', 1, 30, '1,17,16,14', 1, 1489141486, NULL, NULL, 'dddd'),
(56, '111', 1, 30, '1,17,16,14', 1, 1489373237, NULL, NULL, '111111'),
(57, '12', 1, 30, '1,17,16,14,20', 1, 1489374052, NULL, NULL, '1212'),
(58, 'ddd', 1, 30, '1,17,16,14,20', 1, 1489374248, NULL, NULL, 'ddd'),
(59, 'aa', 1, 30, '1,17,16,14', 1, 1489384225, NULL, NULL, 'aaaaaaaa');

-- --------------------------------------------------------

--
-- 表的结构 `ps_layout`
--

CREATE TABLE IF NOT EXISTS `ps_layout` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `temp_name` varchar(200) NOT NULL,
  `temp_width` smallint(6) NOT NULL,
  `temp_height` smallint(6) NOT NULL,
  `temp_bg` int(11) DEFAULT NULL,
  `video_info` varchar(200) DEFAULT NULL,
  `img_info` varchar(200) NOT NULL,
  `ats_info` varchar(200) DEFAULT NULL,
  `weather_info` varchar(200) DEFAULT NULL,
  `info1_info` varchar(200) DEFAULT NULL,
  `info2_info` varchar(200) DEFAULT NULL,
  `info3_info` varchar(200) DEFAULT NULL,
  `info1_txt` text,
  `info2_txt` text,
  `info3_txt` text,
  `sub_time` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=23 ;

--
-- 转存表中的数据 `ps_layout`
--

INSERT INTO `ps_layout` (`id`, `temp_name`, `temp_width`, `temp_height`, `temp_bg`, `video_info`, `img_info`, `ats_info`, `weather_info`, `info1_info`, `info2_info`, `info3_info`, `info1_txt`, `info2_txt`, `info3_txt`, `sub_time`, `status`) VALUES
(18, '测试模板', 1024, 768, 171, '0', '0', '0', '0', '0', '0', '0', '', '', '', 1486535482, 0),
(19, '20170208-143127', 1024, 768, 171, '0', '0', '0', '0', '0', '0', '0', '', '', '', 1486535493, 0),
(20, '20170209-134759', 1024, 768, 171, '0', '0', '0', '0', '0', '0', '0', '', '', '', 1486619301, 0),
(17, '20170208-142202', 1024, 768, 165, '0', '0', '0', '0', '0', '0', '0', '', '', '', 1486534930, 0),
(14, '20170207-113002', 1024, 768, 165, '0', '0', '0', '0', '0', '0', '0', '', '', '', 1486438211, 0),
(15, '20170208-133037', 1024, 768, 171, '0', '0', '0', '0', '0', '0', '0', '', '', '', 1486531845, 0),
(16, '20170208-133051', 1024, 768, 171, '0', '0', '0', '0', '0', '0', '0', '', '', '', 1486531858, 0),
(21, '20170307-163358', 1920, 1080, 174, '413.9583740234375:251.97915649414062:999.9791870117188:624.9791870117188', '0', '0', '0', '12:913.0000305175781:1895:150', '0', '0', '#43FDFF:left:80px:6:祝各位同事节日快乐', '', '', 1488875748, 0),
(22, '20170313-134455', 1024, 768, 175, '358:81:657:671', '13:78:321:327', '17:-170:0:0', '17:-170:0:0', '244:1:564:56', '17:-170:0:0', '17:-170:0:0', '#CBFF52:left:50px:8:欢迎使用PIDS系统', '', '', 1489383983, 0);

-- --------------------------------------------------------

--
-- 表的结构 `ps_log`
--

CREATE TABLE IF NOT EXISTS `ps_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `t` int(10) NOT NULL,
  `ip` varchar(16) NOT NULL,
  `log` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=442 ;

--
-- 转存表中的数据 `ps_log`
--

INSERT INTO `ps_log` (`id`, `name`, `t`, `ip`, `log`) VALUES
(376, 'admin', 1487571185, '::1', '新增菜单，名称：预定义信息'),
(415, 'admin', 1488174463, '::1', '新增菜单，名称：查看合同管理'),
(418, 'admin', 1488272768, '::1', '登录成功。'),
(419, 'admin', 1488273594, '::1', '登录成功。'),
(414, 'admin', 1488162631, '::1', '新增菜单，名称：文件下载'),
(413, 'admin', 1488162057, '::1', '新增菜单，名称：监视'),
(412, 'admin', 1488162025, '::1', '新增菜单，名称：网管/监控'),
(411, 'admin', 1488159293, '::1', '新增菜单，名称：新增合同管理'),
(434, 'admin', 1489116463, '127.0.0.1', '登录成功。'),
(334, 'admin', 1484291599, '127.0.0.1', '登录成功。'),
(333, 'admin', 1484210560, '127.0.0.1', '登录成功。'),
(435, 'admin', 1489139333, '127.0.0.1', '登录成功。'),
(433, 'admin', 1489025295, '127.0.0.1', '登录成功。'),
(432, 'admin', 1488944933, '127.0.0.1', '登录成功。'),
(431, 'admin', 1488870324, '127.0.0.1', '登录成功。'),
(441, 'admin', 1489392185, '127.0.0.1', '编辑菜单，ID：71'),
(440, 'admin', 1489392163, '127.0.0.1', '编辑菜单，ID：65'),
(439, 'admin', 1489392083, '127.0.0.1', '编辑菜单，ID：74'),
(438, 'admin', 1489391903, '127.0.0.1', '登录成功。'),
(437, 'admin', 1489383174, '127.0.0.1', '登录成功。'),
(332, 'admin', 1484208182, '127.0.0.1', '登录成功。'),
(335, 'admin', 1484553616, '127.0.0.1', '登录成功。'),
(340, 'admin', 1484893179, '127.0.0.1', '登录成功。'),
(339, 'admin', 1484819566, '127.0.0.1', '编辑菜单，ID：98'),
(336, 'admin', 1484794819, '127.0.0.1', '登录成功。'),
(338, 'admin', 1484819551, '127.0.0.1', '新增菜单，名称：监控管理'),
(337, 'admin', 1484819377, '127.0.0.1', '删除菜单ID：88'),
(342, 'admin', 1485071567, '127.0.0.1', '登录成功。'),
(341, 'admin', 1484900395, '127.0.0.1', '登录成功。'),
(343, 'admin', 1486363434, '127.0.0.1', '登录成功。'),
(345, 'admin', 1486433704, '127.0.0.1', '登录成功。'),
(344, 'admin', 1486363471, '127.0.0.1', '登录成功。'),
(368, 'admin', 1487313729, '::1', '新增用户组，ID：0，组名：测试组'),
(346, 'admin', 1486534986, '::1', '新增会员，会员UID：29'),
(347, 'admin', 1486608333, '::1', '登录成功。'),
(348, 'admin', 1486618247, '::1', '新增会员，会员UID：30'),
(349, 'admin', 1486623233, '::1', '新增菜单，名称：查看视频节目单'),
(350, 'admin', 1486623903, '::1', '新增菜单，名称：查看发布视频'),
(351, 'admin', 1486623923, '::1', '新增菜单，名称：查看发布图片'),
(352, 'admin', 1486623947, '::1', '新增菜单，名称：查看发布模版'),
(353, 'admin', 1486623966, '::1', '新增菜单，名称：查看发布信息'),
(354, 'admin', 1486623985, '::1', '新增菜单，名称：查看发布指令'),
(355, 'admin', 1486688970, '::1', '登录成功。'),
(356, 'admin', 1486692227, '::1', '登录成功。'),
(357, 'admin', 1486706196, '::1', '删除会员UID：Array'),
(358, 'admin', 1487036159, '::1', '登录成功。'),
(359, 'admin', 1487122299, '::1', '登录成功。'),
(360, 'admin', 1487124378, '::1', '新增菜单，名称：素材审核'),
(361, 'admin', 1487127913, '::1', '新增菜单，名称：审核素材'),
(362, 'admin', 1487144880, '::1', '登录成功。'),
(363, 'admin', 1487145570, '127.0.0.1', '登录成功。'),
(364, 'admin', 1487294466, '::1', '登录成功。'),
(365, 'admin', 1487308295, '::1', '新增菜单，名称：维修管理'),
(366, 'admin', 1487310094, '::1', '新增菜单，名称：新增维修管理'),
(367, 'admin', 1487311375, '::1', '登录成功。'),
(369, 'admin', 1487317594, '::1', '新增菜单，名称：修改维修管理'),
(370, 'admin', 1487317626, '::1', '新增菜单，名称：查看维修管理'),
(371, 'admin', 1487319448, '::1', '编辑用户组，ID：19，组名：4号线设备管理-发布管理-日志管理权限组(A出口)'),
(372, 'admin', 1487320919, '::1', '编辑用户组，ID：3，组名：普通用户'),
(373, 'admin', 1487320927, '::1', '编辑用户组，ID：3，组名：普通用户'),
(374, 'admin', 1487320982, '::1', '编辑用户组，ID：3，组名：普通用户'),
(375, 'admin', 1487553041, '::1', '登录成功。'),
(377, 'admin', 1487572951, '::1', '新增菜单，名称：新增预定义信息'),
(378, 'admin', 1487583830, '::1', '新增菜单，名称：监控管理'),
(379, 'admin', 1487583897, '::1', '新增菜单，名称：广告管理'),
(380, 'admin', 1487638938, '::1', '登录成功。'),
(381, 'admin', 1487640802, '::1', '登录成功。'),
(382, 'admin', 1487646351, '::1', '登录成功。'),
(383, 'admin', 1487647555, '::1', '登录成功。'),
(384, 'admin', 1487653132, '::1', '登录成功。'),
(385, 'admin', 1487654154, '::1', '登录成功。'),
(386, 'admin', 1487655456, '::1', '登录成功。'),
(387, 'admin', 1487656952, '::1', '新增菜单，名称：查看预定义信息'),
(388, 'admin', 1487658660, '::1', '新增菜单，名称：修改预定义信息'),
(389, 'admin', 1487725314, '::1', '登录成功。'),
(390, 'admin', 1487725740, '::1', '新增菜单，名称：发布预定义信息'),
(391, 'admin', 1487725803, '::1', '新增菜单，名称：发布流'),
(392, 'admin', 1487727884, '::1', '新增菜单，名称：发布预定义信息'),
(393, 'admin', 1487730581, '::1', '新增菜单，名称：预定义信息日志'),
(394, 'admin', 1487731580, '::1', '新增菜单，名称：发布流'),
(395, 'admin', 1487731613, '::1', '新增菜单，名称：流日志'),
(396, 'admin', 1487745993, '::1', '登录成功。'),
(397, 'admin', 1487747385, '::1', '登录成功。'),
(398, 'admin', 1487747841, '::1', '登录成功。'),
(399, 'admin', 1487748383, '::1', '登录成功。'),
(400, 'admin', 1487748470, '::1', '登录成功。'),
(401, 'admin', 1487748531, '::1', '登录成功。'),
(402, 'admin', 1487748859, '::1', '登录成功。'),
(403, 'admin', 1487811793, '::1', '登录成功。'),
(404, 'admin', 1487814388, '::1', '新增菜单，名称：发布流媒体'),
(405, 'admin', 1487814428, '::1', '新增菜单，名称：查看流媒体'),
(406, 'admin', 1487898329, '::1', '登录成功。'),
(407, 'admin', 1487899154, '::1', '新增菜单，名称：广告统计'),
(408, 'admin', 1487907503, '::1', '新增菜单，名称：合同管理'),
(409, 'admin', 1487926076, '::1', '登录成功。'),
(410, 'admin', 1488157950, '::1', '登录成功。'),
(416, 'admin', 1488174490, '::1', '新增菜单，名称：修改合同管理'),
(417, 'admin', 1488244866, '::1', '登录成功。'),
(420, 'admin', 1488336436, '::1', '登录成功。'),
(421, 'admin', 1488340583, '::1', '登录成功。'),
(422, 'admin', 1488362388, '::1', '登录成功。'),
(423, 'admin', 1488416472, '::1', '登录成功。'),
(424, 'admin', 1488421143, '::1', '登录成功。'),
(425, 'admin', 1488422639, '::1', '登录成功。'),
(426, 'admin', 1488425684, '::1', '登录成功。'),
(427, 'admin', 1488438644, '::1', '登录成功。'),
(428, 'admin', 1488503046, '::1', '登录成功。'),
(429, 'admin', 1488518821, '::1', '登录成功。'),
(430, 'admin', 1488762996, '127.0.0.1', '登录成功。'),
(436, 'admin', 1489369694, '127.0.0.1', '登录成功。');

-- --------------------------------------------------------

--
-- 表的结构 `ps_media`
--

CREATE TABLE IF NOT EXISTS `ps_media` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `file_name` varchar(200) NOT NULL,
  `temp_name` varchar(200) NOT NULL,
  `type` varchar(50) NOT NULL,
  `attr` tinyint(1) NOT NULL DEFAULT '1',
  `size` varchar(50) NOT NULL,
  `sub_time` int(10) NOT NULL,
  `audit` tinyint(1) DEFAULT NULL,
  `auditstatus` varchar(30) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=176 ;

--
-- 转存表中的数据 `ps_media`
--

INSERT INTO `ps_media` (`id`, `file_name`, `temp_name`, `type`, `attr`, `size`, `sub_time`, `audit`, `auditstatus`) VALUES
(170, '9_ps_ggz.png', '147788099421730.png', 'png', 1, '173185', 1477880994, NULL, '审核通过'),
(171, '成都地铁背景.jpg', '14784857883304.jpg', 'jpg', 4, '36434', 1478485788, NULL, '审核通过'),
(141, 'D03-地铁之心-路网公司周博玮.jpg', '14773652936862.jpg', 'jpg', 1, '321192', 1477365293, NULL, ''),
(142, 'D04-地下彩虹 李宁摄.jpg', '147736529324047.jpg', 'jpg', 1, '213136', 1477365293, NULL, ''),
(143, 'D05-盾构贯通——程功摄.jpg', '1477365294252.jpg', 'jpg', 1, '234916', 1477365294, NULL, ''),
(144, 'D06-法拉第式光圈-路网公司高建通.jpg', '147736529425477.jpg', 'jpg', 1, '300548', 1477365294, NULL, ''),
(145, 'D07-弧光.jpg', '14773652945594.jpg', 'jpg', 1, '205629', 1477365294, NULL, ''),
(146, 'D08-中枢-轨道交通指挥中心.jpg', '147736529427147.jpg', 'jpg', 1, '302794', 1477365294, NULL, ''),
(147, 'B01-1-陆岗-北京南站_8736.jpg', '147736530312520.jpg', 'jpg', 1, '478961', 1477365303, NULL, ''),
(148, 'B02-1-陆岗-北京西客站_6385.jpg', '14773653031956.jpg', 'jpg', 1, '377337', 1477365303, NULL, ''),
(149, 'B03-2-Theofanis frangis-西单.jpg', '147736530326893.jpg', 'jpg', 1, '436998', 1477365303, NULL, ''),
(150, 'B04-507-3-1 方圆 梁衡义.jpg', '147736530313057.jpg', 'jpg', 1, '439473', 1477365303, NULL, ''),
(151, 'B05-521-4-1 升腾-9号线六里桥站 资产管理部 杨义钊.jpg', '147736530313734.jpg', 'jpg', 1, '356484', 1477365303, NULL, ''),
(152, 'B06-地铁4号线动物园站+袁守义.jpg', '14773653037143.jpg', 'jpg', 1, '379013', 1477365303, NULL, ''),
(153, 'B07-快乐的疏导员（摄影 段续玲）.jpg', '147736530429588.jpg', 'jpg', 1, '413803', 1477365304, NULL, ''),
(154, 'B08-颐和园.jpg', '147736530432317.jpg', 'jpg', 1, '306273', 1477365304, NULL, ''),
(155, 'B09-圆明园.jpg', '14773653041586.jpg', 'jpg', 1, '192769', 1477365304, NULL, ''),
(156, 'E01-北京冬奥_1.jpg', '14773653113971.jpg', 'jpg', 1, '57950', 1477365311, NULL, ''),
(157, 'E02-北京精神-1.jpg', '147736531113568.jpg', 'jpg', 1, '165053', 1477365311, NULL, ''),
(158, 'E03-北京精神-2.jpg', '147736531116697.jpg', 'jpg', 1, '90911', 1477365311, NULL, ''),
(162, 'E07-社会主义核心价值观.jpg', '14773653118415.jpg', 'jpg', 1, '129404', 1477365311, NULL, ''),
(163, '北京轨道交通发展纪实节选.mp4', '147745217812783.mp4', 'mp4', 1, '13542016', 1477452178, NULL, ''),
(165, 'bg.png', '147755329022885.png', 'png', 4, '247274', 1477553290, NULL, ''),
(168, '4_wg_hc.png', '14778809945828.png', 'png', 1, '158678', 1477880994, NULL, '审核不通过'),
(169, '4_zg_hc.png', '14778809946573.png', 'png', 1, '158133', 1477880994, NULL, '审核通过'),
(172, '11718674_103447288129_2.jpg', '14810091213170.jpg', 'jpg', 1, '170924', 1481009121, NULL, '审核通过'),
(174, '浪漫.jpg', '1488875589377.jpg', 'jpg', 4, '258761', 1488875589, NULL, '审核通过'),
(175, 'hp.jpg', '148938386124002.jpg', 'jpg', 4, '36434', 1489383861, NULL, '审核通过');

-- --------------------------------------------------------

--
-- 表的结构 `ps_member`
--

CREATE TABLE IF NOT EXISTS `ps_member` (
  `uid` int(11) NOT NULL AUTO_INCREMENT,
  `user` varchar(225) NOT NULL,
  `head` varchar(255) NOT NULL COMMENT '头像',
  `sex` tinyint(1) NOT NULL COMMENT '0保密1男，2女',
  `birthday` int(10) NOT NULL COMMENT '生日',
  `phone` varchar(20) NOT NULL COMMENT '电话',
  `qq` varchar(20) NOT NULL COMMENT 'QQ',
  `email` varchar(255) NOT NULL COMMENT '邮箱',
  `password` varchar(32) NOT NULL,
  `t` int(10) unsigned NOT NULL COMMENT '注册时间',
  PRIMARY KEY (`uid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=31 ;

--
-- 转存表中的数据 `ps_member`
--

INSERT INTO `ps_member` (`uid`, `user`, `head`, `sex`, `birthday`, `phone`, `qq`, `email`, `password`, `t`) VALUES
(1, 'admin', '', 1, 1420128000, '13800138000', '331349451', 'xieyanwei@qq.com', '66d6a1c8748025462128dc75bf5ae8d1', 1442505600),
(27, 'xiao2', '', 2, 0, '', '', '', '0cec39247b943b3f0fdc091143391567', 1480988382),
(3, 'xiaohui', '', 1, -28800, '', '', '', '0cec39247b943b3f0fdc091143391567', 1479718038),
(28, 'xiao3', '', 1, 0, '', '', '', '0cec39247b943b3f0fdc091143391567', 1480988485),
(26, 'xiao1', '', 1, 0, '', '', '', '0cec39247b943b3f0fdc091143391567', 1480988261),
(29, 'xiao10', '', 1, 0, '', '', '', '0cec39247b943b3f0fdc091143391567', 1486534986);

-- --------------------------------------------------------

--
-- 表的结构 `ps_monitor_file`
--

CREATE TABLE IF NOT EXISTS `ps_monitor_file` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `filename` varchar(100) DEFAULT NULL,
  `progress` int(11) DEFAULT NULL,
  `device` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- 转存表中的数据 `ps_monitor_file`
--

INSERT INTO `ps_monitor_file` (`id`, `filename`, `progress`, `device`) VALUES
(1, '15号线广告视频', 80, '20'),
(2, '10号线广告视频', 90, '20');

-- --------------------------------------------------------

--
-- 表的结构 `ps_order`
--

CREATE TABLE IF NOT EXISTS `ps_order` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` tinyint(1) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `sub_time` int(11) NOT NULL,
  `del` int(11) DEFAULT NULL,
  `device` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=44 ;

--
-- 转存表中的数据 `ps_order`
--

INSERT INTO `ps_order` (`id`, `type`, `status`, `sub_time`, `del`, `device`) VALUES
(2, 1, 3, 1467344269, 1479864058, '1,17,16,14'),
(3, 1, 3, 1467344447, 1479864450, '1,17,16,14'),
(4, 1, 3, 1467344689, 1479864560, '1,17,16,14'),
(5, 1, 1, 1467344734, NULL, '1,17,16,14'),
(6, 1, 1, 1467344762, NULL, '1,17,16,14'),
(25, 1, 3, 1486617722, 1486619831, '1,17,16,14'),
(14, 1, 1, 1479868389, NULL, '1,16,14,18'),
(15, 1, 1, 1479868475, NULL, '1,16,14,18'),
(29, 2, 3, 1486617962, 1486618040, '1,17,16,14'),
(28, 1, 3, 1486617946, 1486618040, '1,17,16,14'),
(19, 2, 1, 1479868524, NULL, '1,17,16,14'),
(20, 1, 3, 1479868542, 1486545527, '1,15,19'),
(26, 3, 3, 1486617877, 1486618040, '1,17,16,14'),
(27, 2, 3, 1486617922, 1486618040, '1,16,14,20'),
(30, 1, 3, 1486618000, 1486618040, '1,17,16,14'),
(31, 1, 3, 1486618055, 1486619831, '1,17,16,14'),
(32, 1, 3, 1486618450, 1486619831, '1,17,16,14'),
(33, 2, 3, 1486618663, 1486619831, '1,17,16,14'),
(34, 1, 3, 1486618733, 1486619831, '1,17,16,14'),
(35, 1, 3, 1486619792, 1486619831, '1,17,16,14'),
(36, 1, 3, 1486620569, 1486620612, '1,17,16,14'),
(37, 2, 3, 1486620588, 1486620612, '1,17,16,14'),
(38, 2, 3, 1486620804, 1486705957, '1,17,16,14'),
(40, 3, 1, 1488958858, NULL, '1,17,16,14'),
(41, 3, 1, 1489116477, NULL, '1,17,16,14'),
(42, 4, 1, 1489116495, NULL, '1,17,16,14'),
(43, 1, 1, 1489397980, NULL, '1,17,16,14');

-- --------------------------------------------------------

--
-- 表的结构 `ps_prog_img`
--

CREATE TABLE IF NOT EXISTS `ps_prog_img` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL,
  `lists` text NOT NULL,
  `sub_time` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

--
-- 转存表中的数据 `ps_prog_img`
--

INSERT INTO `ps_prog_img` (`id`, `name`, `lists`, `sub_time`) VALUES
(4, '20161129-144405', '170,169,168', 1480401853),
(5, '20161227-105713', '172,170,169,172,168,162,161,160,159,158,157', 1482807438),
(6, '20170208-134024', '172', 1486532428),
(9, '20170313-134807', '172,170,169', 1489384122);

-- --------------------------------------------------------

--
-- 表的结构 `ps_prog_predefineinfo`
--

CREATE TABLE IF NOT EXISTS `ps_prog_predefineinfo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(60) DEFAULT NULL,
  `type` varchar(30) DEFAULT NULL,
  `sub_time` int(11) DEFAULT NULL,
  `content` varchar(300) DEFAULT NULL,
  `preinfonum` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=13 ;

--
-- 转存表中的数据 `ps_prog_predefineinfo`
--

INSERT INTO `ps_prog_predefineinfo` (`id`, `name`, `type`, `sub_time`, `content`, `preinfonum`) VALUES
(7, '预定义信息测试', '2', 1487659486, '15号线日常类预定义信息维护内容模版设定										', '20170221-104437'),
(11, '测试', '1', 1487666421, '其他类信息维护										', '20170221-163946'),
(12, 'test', '1', 1489384192, 'test11111', '20170313-134852');

-- --------------------------------------------------------

--
-- 表的结构 `ps_prog_video`
--

CREATE TABLE IF NOT EXISTS `ps_prog_video` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL,
  `lists` text NOT NULL,
  `sub_time` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=28 ;

--
-- 转存表中的数据 `ps_prog_video`
--

INSERT INTO `ps_prog_video` (`id`, `name`, `lists`, `sub_time`) VALUES
(26, '20170208-143201', '163', 1486535525),
(23, '20170208-141353', '163', 1486534436),
(22, '20170208-141345', '163', 1486534429),
(25, '20170208-143154', '163', 1486535517),
(24, '20170208-143146', '163', 1486535511);

-- --------------------------------------------------------

--
-- 表的结构 `ps_publish_img`
--

CREATE TABLE IF NOT EXISTS `ps_publish_img` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `device` text NOT NULL,
  `program_id` int(11) NOT NULL,
  `sub_time` int(11) NOT NULL,
  `del` int(11) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `type` varchar(30) DEFAULT NULL,
  `begindate` date DEFAULT NULL,
  `enddate` date DEFAULT NULL,
  `rules` varchar(500) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=31 ;

--
-- 转存表中的数据 `ps_publish_img`
--

INSERT INTO `ps_publish_img` (`id`, `device`, `program_id`, `sub_time`, `del`, `status`, `type`, `begindate`, `enddate`, `rules`) VALUES
(26, '1,16,14,20', 6, 1486608365, NULL, 1, NULL, '2017-02-09', '2017-02-10', '1,3:00-5:00'),
(27, '1,16,14,20', 6, 1486608380, NULL, 1, NULL, '2017-02-09', '2017-02-11', '2,3:00-5:00'),
(28, '1,17,16,14', 5, 1486608445, NULL, 1, NULL, '2017-02-09', '2017-02-11', '4,3:00-5:00'),
(30, '1,15,19', 6, 1486691065, 1486705925, 3, NULL, '2017-02-10', '2017-02-15', '1,3:00-5:00;2,5:00-6:00;3,6:00-6:30;4,6:30-7:00');

-- --------------------------------------------------------

--
-- 表的结构 `ps_publish_predefineinfo`
--

CREATE TABLE IF NOT EXISTS `ps_publish_predefineinfo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `device` text,
  `program_id` int(11) DEFAULT NULL,
  `sub_time` int(11) DEFAULT NULL,
  `status` varchar(30) DEFAULT NULL,
  `begindate` date DEFAULT NULL,
  `enddate` date DEFAULT NULL,
  `rules` varchar(500) DEFAULT NULL,
  `del` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=18 ;

--
-- 转存表中的数据 `ps_publish_predefineinfo`
--

INSERT INTO `ps_publish_predefineinfo` (`id`, `device`, `program_id`, `sub_time`, `status`, `begindate`, `enddate`, `rules`, `del`) VALUES
(4, '1,17,16,14', 7, 1487730332, '3', '2017-02-15', '2017-02-24', '1,3:00-5:00', 1487731442),
(5, '1,15,19', 11, 1487730383, '1', '2017-02-01', '2017-02-22', '1,3:00-5:00;2,3:00-5:00', NULL),
(6, '1,17,16,14', 11, 1489372175, '1', '2017-03-13', '2017-03-13', '', NULL),
(7, '1,17,16,14,20', 11, 1489372195, '1', '2017-03-13', '2017-03-13', '', NULL),
(8, '1,17,16,14', 11, 1489372916, '1', '2017-03-13', '2017-03-13', '', NULL),
(9, '1,17,16,14', 11, 1489373049, '1', '2017-03-13', '2017-03-13', '', NULL),
(10, '1,17,16,14', 11, 1489373085, '1', '2017-03-13', '2017-03-13', '', NULL),
(11, '1,17,16,14,20', 11, 1489374074, '1', '2017-03-13', '2017-03-13', '', NULL),
(12, '1,17,16,14,20', 11, 1489374117, '1', '2017-03-13', '2017-03-13', '', NULL),
(13, '1,17,16,14', 11, 1489374231, '1', '2017-03-13', '2017-03-13', '', NULL),
(14, '1,17,16,14,20', 7, 1489374265, '1', '2017-03-13', '2017-03-13', '', NULL),
(15, '1,17,16,14,20', 11, 1489375658, '1', '2017-03-13', '2017-03-13', '', NULL),
(16, '1,17,16,14,20', 11, 1489375726, '1', '2017-03-13', '2017-03-13', '', NULL),
(17, '1,17,16,14,20', 12, 1489384258, '1', '2017-03-13', '2017-03-13', '', NULL);

-- --------------------------------------------------------

--
-- 表的结构 `ps_publish_stream`
--

CREATE TABLE IF NOT EXISTS `ps_publish_stream` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `device` text,
  `program_id` int(11) DEFAULT NULL,
  `sub_time` int(11) DEFAULT NULL,
  `status` varchar(30) DEFAULT NULL,
  `begindate` date DEFAULT NULL,
  `enddate` date DEFAULT NULL,
  `rules` varchar(500) DEFAULT NULL,
  `content` varchar(300) DEFAULT NULL,
  `del` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=32 ;

--
-- 转存表中的数据 `ps_publish_stream`
--

INSERT INTO `ps_publish_stream` (`id`, `device`, `program_id`, `sub_time`, `status`, `begindate`, `enddate`, `rules`, `content`, `del`) VALUES
(3, '1,15,19', 0, 1487818717, '1', '2017-02-15', '2017-02-23', '1,3:00-5:00', '开始发布流媒体', NULL),
(5, '1,17,16,14', 0, 1487832520, '1', '2017-02-01', '2017-02-15', '1,3:00-5:00;2,5:00-6:00;3,6:00-6:30;4,6:30-7:00;5,7:00-7:30;6,7:30-8:00;7,8:00-8:30', '测试流媒体信息发布功能', NULL),
(6, '1,17,16,14', 0, 1487841704, '1', '2017-02-03', '2017-02-04', '1,3:00-5:00', '4号线-国家图书馆-A出入口-流媒体', NULL),
(7, '1,15,19', 0, 1489133349, '1', '2017-03-10', '2017-03-10', '', 'rtmp://live.hkstv.hk.lxdns.com/live/hks', NULL),
(8, '1,17,16,14', 0, 1489133375, '3', '2017-03-10', '2017-03-10', '', '111111111', 1489133421),
(9, '1,17,16,14', 0, 1489133388, '3', '2017-03-10', '2017-03-10', '5,6:00-6:30;5,6:30-7:00', '222222222222', 1489133430),
(10, '1,17,16,14', 0, 1489133401, '3', '2017-03-10', '2017-03-10', '', '搜索搜索搜索搜索', 1489133430),
(11, '1,17,16,14', 0, 1489139351, '1', '2017-03-10', '2017-03-10', '', '1111111', NULL),
(12, '1,17,16,14,20', 0, 1489139455, '1', '2017-03-10', '2017-03-10', '', 'ddddddddddd', NULL),
(13, '1,17,16,14', 0, 1489139492, '1', '2017-03-10', '2017-03-10', '', 'ddddd', NULL),
(14, '1,17,16,14', 0, 1489139696, '1', '2017-03-10', '2017-03-10', '', '111111111111', NULL),
(15, '1,17,16,14', 0, 1489139735, '1', '2017-03-10', '2017-03-10', '', 'rtmp://115.156.165.45:1935/iptv/cctv1hd', NULL),
(16, '1,17,16,14', 0, 1489140065, '1', '2017-03-10', '2017-03-10', '', 'rtmp://115.156.165.45:1935/iptv/cctv1hd', NULL),
(17, '1,17,16,14', 0, 1489140235, '1', '2017-03-10', '2017-03-10', '', '中文测试', NULL),
(18, '1,17,16,14', 0, 1489140254, '1', '2017-03-10', '2017-03-10', '', '中文测试', NULL),
(19, '1,17,16,14,20', 0, 1489140280, '1', '2017-03-10', '2017-03-10', '', 'ddd', NULL),
(20, '1,17,16,14', 0, 1489140303, '1', '2017-03-10', '2017-03-10', '', '中文测试', NULL),
(21, '1,17,16,14', 0, 1489140817, '1', '2017-03-10', '2017-03-10', '', 'dddddddd', NULL),
(22, '1,17,16,14', 0, 1489140936, '1', '2017-03-10', '2017-03-10', '', 'dd', NULL),
(23, '1,17,16,14,20', 0, 1489140958, '1', '2017-03-10', '2017-03-10', '', '中文测试', NULL),
(24, '1,17,16,14', 0, 1489140981, '1', '2017-03-10', '2017-03-10', '', 'rtmp://115.156.165.45:1935/iptv/cctv1hd', NULL),
(25, '1,17,16,14', 0, 1489141132, '1', '2017-03-10', '2017-03-10', '', 'rtmp://115.156.165.45:1935/iptv/cctv1hd', NULL),
(26, '1,17,16,14', 0, 1489141500, '1', '2017-03-10', '2017-03-10', '', 'rtmp://115.156.165.45:1935/iptv/cctv1hd', NULL),
(27, '1,17,16,14', 0, 1489141559, '1', '2017-03-10', '2017-03-10', '', 'rtmp://live.hkstv.hk.lxdns.com/live/hks', NULL),
(28, '1,17,16,14', 0, 1489142325, '1', '2017-03-10', '2017-03-10', '', 'http://125.88.92.166:30001/PLTV/88888956/224/3221227703/1.m3u8', NULL),
(29, '1,17,16,14', 0, 1489142425, '1', '2017-03-10', '2017-03-10', '', 'rtmp://live.hkstv.hk.lxdns.com/live/hks', NULL),
(30, '1,17,16,14', 0, 1489142465, '1', '2017-03-10', '2017-03-10', '', 'http://125.88.92.166:30001/PLTV/88888956/224/3221227703/1.m3u8', NULL),
(31, '1,17,16,14', 0, 1489384317, '1', '2017-03-13', '2017-03-13', '', 'http://125.88.92.166:30001/PLTV/88888956/224/3221227703/1.m3u8', NULL);

-- --------------------------------------------------------

--
-- 表的结构 `ps_publish_tpl`
--

CREATE TABLE IF NOT EXISTS `ps_publish_tpl` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `device` text NOT NULL,
  `program_id` int(11) NOT NULL,
  `sub_time` int(11) NOT NULL,
  `del` int(11) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `type` varchar(30) DEFAULT NULL,
  `begindate` date DEFAULT NULL,
  `enddate` date DEFAULT NULL,
  `rules` varchar(500) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=55 ;

--
-- 转存表中的数据 `ps_publish_tpl`
--

INSERT INTO `ps_publish_tpl` (`id`, `device`, `program_id`, `sub_time`, `del`, `status`, `type`, `begindate`, `enddate`, `rules`) VALUES
(42, '1,17,16,14', 19, 1486608405, NULL, 1, NULL, '2017-02-09', '2017-02-10', '1,3:00-5:00'),
(43, '1,16,14,20', 19, 1486608466, NULL, 1, NULL, '2017-02-09', '2017-02-12', '1,3:00-5:00'),
(44, '1,17,16,14', 14, 1486608693, 1486705934, 3, NULL, '2017-02-09', '2017-02-15', '1,5:00-6:00'),
(47, '1,17,16,14', 20, 1487567901, NULL, 1, NULL, '2017-02-20', '2017-02-23', '1,3:00-5:00'),
(46, '1,16,14,20', 14, 1486621844, 1486621889, 3, NULL, '2017-02-09', '2017-02-11', '1,3:00-5:00;2,3:00-5:00;3,3:00-5:00;4,3:00-5:00;5,3:00-5:00;6,3:00-5:00;7,3:00-5:00'),
(48, '1,17,16,14', 21, 1488949923, NULL, 1, NULL, '2017-03-08', '2017-03-08', ''),
(49, '1,17,16,14', 21, 1488967374, NULL, 1, NULL, '2017-03-08', '2017-03-08', ''),
(50, '1,17,16,14', 21, 1488968493, NULL, 1, NULL, '2017-03-08', '2017-03-08', ''),
(51, '1,17,16,14', 21, 1488968522, NULL, 1, NULL, '2017-03-08', '2017-03-08', ''),
(52, '1,17,16,14', 21, 1488968528, NULL, 1, NULL, '2017-03-08', '2017-03-08', ''),
(53, '1,17,16,14', 21, 1488968550, NULL, 1, NULL, '2017-03-08', '2017-03-08', ''),
(54, '1,17,16,14', 21, 1488968565, NULL, 1, NULL, '2017-03-08', '2017-03-08', '');

-- --------------------------------------------------------

--
-- 表的结构 `ps_publish_video`
--

CREATE TABLE IF NOT EXISTS `ps_publish_video` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `device` text NOT NULL,
  `program_id` int(11) NOT NULL,
  `sub_time` int(11) NOT NULL,
  `del` int(11) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `type` varchar(30) DEFAULT NULL,
  `begindate` date DEFAULT NULL,
  `enddate` date DEFAULT NULL,
  `rules` varchar(500) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=28 ;

--
-- 转存表中的数据 `ps_publish_video`
--

INSERT INTO `ps_publish_video` (`id`, `device`, `program_id`, `sub_time`, `del`, `status`, `type`, `begindate`, `enddate`, `rules`) VALUES
(25, '1,17,16,14', 22, 1486691022, NULL, 1, NULL, '2017-02-10', '2017-02-24', '1,3:00-5:00;2,5:00-6:00;3,6:00-6:30;4,6:30-7:00;5,7:00-7:30;6,7:30-8:00;7,8:00-8:30'),
(24, '1,17,16,14', 24, 1486628463, NULL, 1, NULL, '2017-02-09', '2017-02-16', '1,3:00-5:00'),
(15, '1,16,14,20', 22, 1486534728, NULL, 1, NULL, '2017-02-08', '2017-02-10', ''),
(26, '1,16,14,20', 26, 1486691041, 1486705916, 3, NULL, '2017-02-10', '2017-02-14', '1,3:00-5:00'),
(17, '1,16,14,20', 22, 1486535247, NULL, 1, NULL, '2017-02-08', '2017-02-09', '1,6:30-7:00'),
(22, '1,17,16,14', 23, 1486535324, NULL, 1, NULL, '2017-02-08', '2017-02-11', ''),
(27, '1,17,16,14', 26, 1488969794, NULL, 1, NULL, '2017-03-08', '2017-03-08', '');

-- --------------------------------------------------------

--
-- 表的结构 `ps_schedule`
--

CREATE TABLE IF NOT EXISTS `ps_schedule` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `bgtime` varchar(255) DEFAULT NULL,
  `endtime` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=54 ;

--
-- 转存表中的数据 `ps_schedule`
--

INSERT INTO `ps_schedule` (`id`, `bgtime`, `endtime`) VALUES
(1, '3:00', '5:00'),
(2, '5:00', '6:00'),
(3, '6:00', '6:30'),
(4, '6:30', '7:00'),
(5, '7:00', '7:30'),
(6, '7:30', '8:00'),
(7, '8:00', '8:30'),
(8, '8:30', '9:00'),
(9, '9:00', '9:30'),
(10, '9:30', '10:00'),
(11, '10:00', '10:30'),
(12, '10:30', '11:00'),
(13, '11:00', '11:30'),
(14, '11:30', '12:00'),
(15, '12:00', '12:30'),
(16, '12:30', '13:00'),
(17, '13:00', '13:30'),
(18, '13:30', '14:00'),
(19, '14:00', '14:30'),
(20, '14:30', '15:00'),
(21, '15:00', '15:30'),
(22, '15:30', '16:00'),
(23, '16:00', '16:30'),
(24, '16:30', '17:00'),
(25, '17:00', '17:30'),
(26, '17:30', '18:00'),
(27, '18:00', '18:30'),
(28, '18:30', '19:00'),
(29, '19:00', '19:30'),
(30, '19:30', '20:00'),
(31, '20:00', '21:00'),
(32, '21:00', '22:00'),
(33, '22:00', '00:00');

-- --------------------------------------------------------

--
-- 表的结构 `ps_setting`
--

CREATE TABLE IF NOT EXISTS `ps_setting` (
  `k` varchar(100) NOT NULL COMMENT '变量',
  `v` varchar(255) NOT NULL COMMENT '值',
  `type` tinyint(1) NOT NULL COMMENT '0系统，1自定义',
  `name` varchar(255) NOT NULL COMMENT '说明',
  PRIMARY KEY (`k`),
  KEY `k` (`k`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `ps_setting`
--

INSERT INTO `ps_setting` (`k`, `v`, `type`, `name`) VALUES
('sitename', 'PIDS', 0, ''),
('title', 'PIDS', 0, ''),
('keywords', '关键词', 0, ''),
('description', '网站描述', 0, ''),
('footer', '2016©pids ', 0, ''),
('test', '测试', 1, '测试变量');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
