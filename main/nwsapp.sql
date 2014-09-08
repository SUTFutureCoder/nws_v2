-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2014-08-14 15:53:21
-- 服务器版本: 5.5.38-0ubuntu0.14.04.1
-- PHP 版本: 5.5.9-1ubuntu4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `nwsapp`
--

-- --------------------------------------------------------

--
-- 表的结构 `activity`
--

CREATE TABLE IF NOT EXISTS `activity` (
  `act_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '活动编号',
  `act_name` varchar(200) NOT NULL,
  `act_class` varchar(50) NOT NULL,
  `activity_user_number` char(20) NOT NULL COMMENT '建立者',
  `act_section_only` int(2) NOT NULL COMMENT '针对部门(0为不针对)',
  `act_content` varchar(1000) NOT NULL COMMENT '活动内容',
  `act_warn` varchar(1000) NOT NULL COMMENT '活动注意事项',
  `act_start` datetime NOT NULL COMMENT '活动开始时间',
  `act_end` datetime NOT NULL COMMENT '活动结束时间',
  `act_money` int(10) NOT NULL COMMENT '活动需要费用',
  `act_position` varchar(100) NOT NULL COMMENT '活动地点',
  `act_regtime` datetime NOT NULL COMMENT '活动注册时间',
  `act_member_sum` int(10) NOT NULL COMMENT '活动总人数限制(0为不限制)',
  `act_join_num` int(10) NOT NULL COMMENT '活动参加人数',
  `act_good` int(10) NOT NULL COMMENT '活动赞数',
  `act_defunct` int(1) NOT NULL COMMENT '和谐/封禁',
  `act_defunct_time` datetime NOT NULL COMMENT '采用污点式记录方案',
  `act_defunct_result` text,
  PRIMARY KEY (`act_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- 转存表中的数据 `activity`
--

INSERT INTO `activity` (`act_id`, `act_name`, `act_class`, `activity_user_number`, `act_section_only`, `act_content`, `act_warn`, `act_start`, `act_end`, `act_money`, `act_position`, `act_regtime`, `act_member_sum`, `act_join_num`, `act_good`, `act_defunct`, `act_defunct_time`, `act_defunct_result`) VALUES
(1, '', '宣传', '0', 0, '请准时参加', '', '2014-05-20 00:00:00', '2014-10-27 00:00:00', 0, '新、老校区及网络宣传', '2014-05-03 21:04:29', 0, 0, 0, 0, '0000-00-00 00:00:00', NULL),
(2, '', '聚餐', '0', 2, '为答谢部员们努力为网管拼搏，\n现特邀请工程部各位参加网管的部员聚餐活动', '注意交通安全', '2014-05-29 19:00:00', '2014-10-29 20:30:00', 100, '万达广场', '2014-05-03 21:10:07', 0, 0, 0, 1, '2014-05-03 23:18:29', '演示活动注销'),
(3, '', '培训', '0', 0, '第二讲：充满创意的网页排版', '', '2014-04-23 18:00:00', '2014-10-23 20:00:00', 0, '老校区综合楼719', '2014-05-03 21:11:23', 0, 0, 0, 0, '0000-00-00 00:00:00', NULL),
(4, '', '投票', '0', 0, '各位亲：又到了一年一度的网管盛会——网络文化节，本次绿能量网页设计大赛即将在2014年5月24日进行全校范围内投票，请您登陆数字工大选出最喜欢的作品！', '', '2014-05-24 00:00:00', '2014-10-30 00:00:00', 0, '数字工大', '2014-05-03 21:12:42', 0, 0, 0, 0, '0000-00-00 00:00:00', NULL),
(5, '', '开会', '0', 0, '下个月我们即将为网管注入新鲜的血液', '', '2014-06-01 18:00:00', '2014-10-01 20:00:00', 0, '大活214', '2014-05-03 21:13:30', 0, 0, 0, 0, '0000-00-00 00:00:00', NULL),
(6, '', '培训', '0', 0, '未参加的活动会用白色底色表示，已参加的活动会用绿色表示，已参加但退出的活动会用浅红表示', '无', '2014-05-03 00:00:00', '2014-10-30 00:00:00', 0, '沈阳工业大学', '2014-05-03 22:59:44', 0, 0, 0, 0, '0000-00-00 00:00:00', NULL),
(7, '', '培训', '0', 0, '未参加的活动会用白色底色表示，已参加的活动会用绿色表示，已参加但退出的活动会用浅红表示', '无', '2014-05-03 01:01:00', '2014-05-29 00:00:00', 0, '沈阳工业大学', '2014-05-03 23:01:51', 0, 0, 0, 0, '0000-00-00 00:00:00', NULL),
(8, '', '开会', '0', 0, '例行会议', '请按时参加', '2014-07-03 17:00:00', '2014-07-03 18:00:00', 0, '大活214', '2014-05-03 23:11:41', 0, 0, 0, 0, '0000-00-00 00:00:00', NULL);

-- --------------------------------------------------------

--
-- 表的结构 `activity_arrange`
--

CREATE TABLE IF NOT EXISTS `activity_arrange` (
  `arrange_id` int(8) NOT NULL AUTO_INCREMENT COMMENT '分配号',
  `arrange_act_id` int(8) NOT NULL COMMENT '对应活动号',
  `arrange_user_number` char(20) NOT NULL COMMENT '被分配学号',
  `arrange_user_joined` tinyint(1) NOT NULL COMMENT '实际是否参加',
  `arrange_time` char(3) NOT NULL COMMENT '1-2:周一第二节大课',
  `arrange_datetime` datetime NOT NULL COMMENT '标准时间格式',
  PRIMARY KEY (`arrange_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `activity_ask`
--

CREATE TABLE IF NOT EXISTS `activity_ask` (
  `act_ask_id` int(10) NOT NULL AUTO_INCREMENT COMMENT '总参与编号',
  `act_id` int(10) NOT NULL COMMENT '活动编号',
  `user_number` char(20) NOT NULL COMMENT '会号',
  `act_ask_time` datetime NOT NULL COMMENT '加入时间',
  `act_join_ask_theme` varchar(100) DEFAULT NULL,
  `act_join_ask` varchar(1000) NOT NULL COMMENT '活动咨询',
  `act_join_ask_id_defunct` int(1) NOT NULL COMMENT '咨询人匿名',
  `act_join_ask_defunct` int(1) NOT NULL COMMENT '咨询和谐',
  PRIMARY KEY (`act_ask_id`),
  UNIQUE KEY `act_join_id` (`act_ask_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `activity_join`
--

CREATE TABLE IF NOT EXISTS `activity_join` (
  `act_join_id` int(10) NOT NULL AUTO_INCREMENT COMMENT '总参与编号',
  `act_id` int(10) NOT NULL COMMENT '活动编号',
  `user_number` char(20) NOT NULL COMMENT '会号',
  `act_join_time` datetime NOT NULL COMMENT '加入时间',
  `act_join_star_s` float NOT NULL COMMENT '期待值评分',
  `act_join_star_e` float NOT NULL COMMENT '完成活动后评分',
  `act_join_defunct` int(1) NOT NULL COMMENT '活动退出/和谐参与者',
  `act_join_ask` varchar(1000) NOT NULL COMMENT '活动咨询',
  `act_join_ask_id_defunct` int(1) NOT NULL COMMENT '咨询人匿名',
  `act_join_ask_defunct` int(1) NOT NULL COMMENT '咨询和谐',
  PRIMARY KEY (`act_join_id`),
  UNIQUE KEY `act_join_id` (`act_join_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- 转存表中的数据 `activity_join`
--

INSERT INTO `activity_join` (`act_join_id`, `act_id`, `user_number`, `act_join_time`, `act_join_star_s`, `act_join_star_e`, `act_join_defunct`, `act_join_ask`, `act_join_ask_id_defunct`, `act_join_ask_defunct`) VALUES
(1, 1, '1', '2014-05-03 21:04:29', 0, 0, 0, '', 0, 0),
(2, 2, '1', '2014-05-03 21:10:07', 0, 0, 0, '', 0, 0),
(3, 3, '1', '2014-05-03 21:11:23', 0, 0, 0, '', 0, 0),
(4, 4, '1', '2014-05-03 21:12:42', 0, 0, 1, '', 0, 0),
(5, 5, '1', '2014-05-03 21:13:30', 0, 0, 0, '', 0, 0),
(6, 6, '29', '2014-05-03 22:59:44', 0, 0, 0, '', 0, 0),
(7, 7, '29', '2014-05-03 23:01:51', 0, 0, 0, '', 0, 0),
(8, 8, '1', '2014-05-03 23:11:41', 0, 0, 0, '', 0, 0);

-- --------------------------------------------------------

--
-- 表的结构 `activity_reply`
--

CREATE TABLE IF NOT EXISTS `activity_reply` (
  `act_re_id` int(10) NOT NULL AUTO_INCREMENT COMMENT '回复编号',
  `act_ask_id` int(10) NOT NULL,
  `act_id` int(10) NOT NULL COMMENT '活动编号',
  `user_number` char(20) NOT NULL COMMENT '会号',
  `user_name_defunct` int(1) NOT NULL COMMENT '匿名',
  `act_re_defunct` int(1) NOT NULL COMMENT '和谐',
  `act_re_time` datetime NOT NULL COMMENT '回复时间',
  `act_re_good` int(10) NOT NULL COMMENT '赞数',
  PRIMARY KEY (`act_re_id`),
  UNIQUE KEY `act_re_id` (`act_re_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `authorizee`
--

CREATE TABLE IF NOT EXISTS `authorizee` (
  `authorizee_id` int(10) NOT NULL AUTO_INCREMENT,
  `authorizee_name` varchar(100) NOT NULL,
  `authorizee_describe` varchar(100) NOT NULL,
  PRIMARY KEY (`authorizee_id`),
  UNIQUE KEY `authorizee_id` (`authorizee_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='权限表' AUTO_INCREMENT=2 ;

--
-- 转存表中的数据 `authorizee`
--

INSERT INTO `authorizee` (`authorizee_id`, `authorizee_name`, `authorizee_describe`) VALUES
(1, '管理员', '');

-- --------------------------------------------------------

--
-- 表的结构 `bug`
--

CREATE TABLE IF NOT EXISTS `bug` (
  `bug_id` int(10) NOT NULL AUTO_INCREMENT,
  `bug_version` varchar(100) NOT NULL COMMENT '出现bug的版本',
  `bug_release_time` datetime NOT NULL,
  `bug_detail` varchar(2000) NOT NULL COMMENT 'bug描述',
  `bug_report_user_number` char(20) NOT NULL COMMENT 'bug上报学号',
  `bug_report_time` datetime NOT NULL COMMENT 'bug上报时间',
  `bug_reply` varchar(2000) NOT NULL COMMENT '开发者回复',
  `bug_reply_user_number` int(9) NOT NULL COMMENT 'bug回复的学号',
  `bug_reply_time` datetime NOT NULL COMMENT 'bug回复的时间',
  `bug_repair_progress` int(4) NOT NULL COMMENT 'bug修复进度',
  `bug_repaired` int(11) NOT NULL COMMENT '是否已经修复完毕',
  PRIMARY KEY (`bug_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- 转存表中的数据 `bug`
--

INSERT INTO `bug` (`bug_id`, `bug_version`, `bug_release_time`, `bug_detail`, `bug_report_user_number`, `bug_report_time`, `bug_reply`, `bug_reply_user_number`, `bug_reply_time`, `bug_repair_progress`, `bug_repaired`) VALUES
(1, 'Alpha1 build1071', '2014-04-29 23:59:49', '功能有些不完善', '120406305', '2014-05-03 23:32:10', '敬请期待后续版本更新', 120406305, '2014-05-03 23:38:18', 80, 0),
(2, 'Alpha1 build1071', '2014-04-29 23:59:49', '功能还不完善', '120406305', '2014-05-03 23:32:49', '', 0, '0000-00-00 00:00:00', 0, 0),
(3, 'Alpha1 build1071', '2014-04-29 23:59:49', '功能还不完善', '120406305', '2014-05-03 23:34:06', '', 0, '0000-00-00 00:00:00', 0, 0),
(4, 'Alpha1 build1077', '2014-05-15 21:25:26', '多宣传平台一键直达', '120406305', '2014-05-24 23:18:50', '', 0, '0000-00-00 00:00:00', 0, 0);

-- --------------------------------------------------------

--
-- 表的结构 `contest`
--

CREATE TABLE IF NOT EXISTS `contest` (
  `contest_id` int(10) NOT NULL AUTO_INCREMENT,
  `contest_name` varchar(100) NOT NULL COMMENT '比赛名称',
  `contest_launcher` varchar(20) NOT NULL COMMENT '发起方',
  `contest_telephone` bigint(15) NOT NULL COMMENT '发起人电话',
  `contest_content` varchar(2000) NOT NULL COMMENT '比赛内容',
  `contest_limitation` varchar(1000) NOT NULL COMMENT '比赛限制',
  `contest_join_method` varchar(1000) NOT NULL COMMENT '参与方式',
  `contest_start_time` datetime NOT NULL COMMENT '比赛开始时间',
  `contest_end_time` datetime NOT NULL COMMENT '比赛结束时间',
  `contest_regtime` datetime NOT NULL COMMENT '比赛注册时间',
  `contest_res_ext` varchar(20) NOT NULL COMMENT '比赛材料后缀名',
  `contest_join_num` int(10) NOT NULL COMMENT '比赛加入人数',
  PRIMARY KEY (`contest_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- 转存表中的数据 `contest`
--

INSERT INTO `contest` (`contest_id`, `contest_name`, `contest_launcher`, `contest_telephone`, `contest_content`, `contest_limitation`, `contest_join_method`, `contest_start_time`, `contest_end_time`, `contest_regtime`, `contest_res_ext`, `contest_join_num`) VALUES
(1, '第六届ACM程序设计大赛', '沈阳工业大学ACM实验室', 13900000000, '比赛描述样例', '全校本科生', '请到acm.sut.edu.cn参与报名', '2014-06-03 10:00:00', '2014-10-03 15:00:00', '2014-05-03 23:52:17', '.zip', 0);

-- --------------------------------------------------------

--
-- 表的结构 `contest_join`
--

CREATE TABLE IF NOT EXISTS `contest_join` (
  `contest_join_id` int(10) NOT NULL AUTO_INCREMENT COMMENT '比赛加入流水号',
  `contest_id` int(10) NOT NULL COMMENT '比赛流水号',
  `user_number` char(20) NOT NULL COMMENT '会号',
  `contest_join_time` datetime NOT NULL COMMENT '比赛加入时间',
  `contest_join_defunct` tinyint(1) NOT NULL COMMENT '注销加入',
  PRIMARY KEY (`contest_join_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- 转存表中的数据 `contest_join`
--

INSERT INTO `contest_join` (`contest_join_id`, `contest_id`, `user_number`, `contest_join_time`, `contest_join_defunct`) VALUES
(1, 1, '1', '2014-05-29 00:04:34', 0);

-- --------------------------------------------------------

--
-- 表的结构 `elfinder_file`
--

CREATE TABLE IF NOT EXISTS `elfinder_file` (
  `id` int(7) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` int(7) unsigned NOT NULL,
  `name` varchar(256) NOT NULL,
  `content` longblob NOT NULL,
  `size` int(10) unsigned NOT NULL DEFAULT '0',
  `mtime` int(10) unsigned NOT NULL,
  `mime` varchar(256) NOT NULL DEFAULT 'unknown',
  `read` enum('1','0') NOT NULL DEFAULT '1',
  `write` enum('1','0') NOT NULL DEFAULT '1',
  `locked` enum('1','0') NOT NULL DEFAULT '0',
  `hidden` enum('1','0') NOT NULL DEFAULT '0',
  `width` int(5) NOT NULL,
  `height` int(5) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `parent_name` (`parent_id`,`name`),
  KEY `parent_id` (`parent_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- 转存表中的数据 `elfinder_file`
--

INSERT INTO `elfinder_file` (`id`, `parent_id`, `name`, `content`, `size`, `mtime`, `mime`, `read`, `write`, `locked`, `hidden`, `width`, `height`) VALUES
(1, 0, 'DATABASE', '', 0, 0, 'directory', '1', '1', '0', '0', 0, 0);

-- --------------------------------------------------------

--
-- 表的结构 `friend`
--

CREATE TABLE IF NOT EXISTS `friend` (
  `friend_id` int(10) NOT NULL AUTO_INCREMENT,
  `friend_s` char(20) NOT NULL COMMENT '申请者/接受者',
  `friend_d` char(20) NOT NULL COMMENT '接受者/申请者',
  `friend_confirm` tinyint(1) NOT NULL COMMENT '好友确认',
  `friend_defunct` tinyint(1) NOT NULL COMMENT '删除好友',
  `friend_defunct_time` datetime NOT NULL COMMENT '删除时间',
  `friend_intimate` int(10) NOT NULL COMMENT '亲密度',
  PRIMARY KEY (`friend_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `loginlog`
--

CREATE TABLE IF NOT EXISTS `loginlog` (
  `login_id` int(10) NOT NULL AUTO_INCREMENT,
  `user_number` char(20) NOT NULL,
  `login_time` datetime NOT NULL,
  `login_ip` varchar(100) NOT NULL,
  `pass` tinyint(1) NOT NULL,
  PRIMARY KEY (`login_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=169 ;

--
-- 转存表中的数据 `loginlog`
--

INSERT INTO `loginlog` (`login_id`, `user_number`, `login_time`, `login_ip`, `pass`) VALUES
(1, '120406305', '2014-05-03 20:54:42', '10.16.3.186', 1),
(2, '120406305', '2014-05-03 20:58:19', '10.16.3.186', 1),
(3, '120406305', '2014-05-03 21:20:54', '10.16.3.186', 1),
(4, '120406305', '2014-05-03 21:25:11', '10.16.3.186', 1),
(5, '120406305', '2014-05-03 21:28:19', '10.16.3.186', 1),
(6, '120406305', '2014-05-03 22:47:19', '113.225.30.211', 1),
(7, '120406306', '2014-05-03 22:54:02', '113.225.30.211', 0),
(8, '120406305', '2014-05-03 22:54:10', '113.225.30.211', 1),
(9, '120406305', '2014-05-03 22:54:37', '113.225.30.211', 1),
(10, '120406306', '2014-05-03 22:55:14', '113.225.30.211', 1),
(11, '120406305', '2014-05-03 22:59:56', '113.225.30.211', 1),
(12, '120406306', '2014-05-03 23:00:24', '113.225.30.211', 1),
(13, '120406305', '2014-05-03 23:07:00', '113.225.30.211', 1),
(14, '120406305', '2014-05-03 23:21:40', '113.225.30.211', 1),
(15, '120406305', '2014-05-03 23:29:46', '120.201.105.13', 1),
(16, '120406305', '2014-05-03 23:55:00', '120.201.105.13', 1),
(17, '120406305', '2014-05-04 00:15:55', '120.201.105.13', 1),
(18, '120406305', '2014-05-04 07:43:27', '10.16.3.186', 1),
(19, '120406305', '2014-05-04 08:13:40', '10.16.3.186', 1),
(20, '120406305', '2014-05-04 08:14:18', '10.16.3.186', 1),
(21, '130406301', '2014-05-04 08:14:37', '10.16.3.186', 1),
(22, '120406305', '2014-05-04 08:16:34', '10.16.3.186', 1),
(23, '120406305', '2014-05-04 14:35:06', '10.16.3.186', 1),
(24, '120406305', '2014-05-04 14:40:20', '10.16.3.186', 1),
(25, '120406305', '2014-05-04 15:59:46', '10.16.3.186', 1),
(26, '120406305', '2014-05-04 16:05:02', '10.16.3.186', 1),
(27, '120406305', '2014-05-04 16:12:03', '10.16.3.186', 1),
(28, '120406305', '2014-05-05 14:32:55', '113.225.206.122', 1),
(29, '120406305', '2014-05-05 20:07:43', '10.16.3.186', 1),
(30, '120406305', '2014-05-05 20:11:36', '10.16.3.186', 1),
(31, '120406305', '2014-05-05 20:31:14', '10.16.3.186', 1),
(32, '120406305', '2014-05-05 20:52:59', '10.16.3.186', 1),
(33, '120406305', '2014-05-05 21:29:36', '10.16.3.186', 1),
(34, '120406305', '2014-05-05 21:31:22', '10.16.3.186', 1),
(35, '120406305', '2014-05-06 11:59:34', '113.225.30.164', 1),
(36, '120406305', '2014-05-06 12:02:54', '113.232.100.112', 1),
(37, '120406305', '2014-05-06 15:38:14', '10.16.3.186', 1),
(38, '120406305', '2014-05-06 15:55:09', '10.16.3.186', 1),
(39, '120406305', '2014-05-06 16:30:23', '10.16.3.186', 1),
(40, '120406305', '2014-05-06 18:54:17', '10.16.3.186', 1),
(41, '120406305', '2014-05-06 20:21:37', '10.16.3.186', 1),
(42, '120406305', '2014-05-06 20:23:04', '10.16.3.186', 1),
(43, '120406305', '2014-05-06 20:46:23', '10.16.3.186', 1),
(44, '120406305', '2014-05-06 20:46:45', '10.16.3.186', 1),
(45, '120406305', '2014-05-06 20:47:15', '10.16.3.186', 1),
(46, '120406305', '2014-05-06 21:01:41', '10.16.3.186', 1),
(47, '120406305', '2014-05-07 19:23:24', '10.16.3.186', 1),
(48, '120406305', '2014-05-07 19:27:58', '10.16.3.186', 1),
(49, '120406305', '2014-05-07 19:29:32', '10.16.3.186', 1),
(50, '120406305', '2014-05-07 19:41:41', '10.16.3.186', 1),
(51, '120406305', '2014-05-07 19:41:58', '10.16.3.186', 1),
(52, '120406305', '2014-05-07 19:45:19', '10.16.3.186', 1),
(53, '120406305', '2014-05-08 09:23:16', '113.225.23.185', 1),
(54, '120406305', '2014-05-09 00:46:07', '120.201.105.13', 1),
(55, '120406305', '2014-05-09 18:19:15', '10.16.3.186', 1),
(56, '120406305', '2014-05-12 12:04:44', '113.232.106.217', 1),
(57, '120406305', '2014-05-12 15:06:47', '10.16.3.186', 1),
(58, '120406305', '2014-05-12 19:50:13', '10.16.3.186', 1),
(59, '120406305', '2014-05-12 19:54:44', '10.16.3.186', 1),
(60, '120406305', '2014-05-13 16:46:42', '10.16.3.186', 1),
(61, '120406305', '2014-05-13 16:47:56', '10.16.3.186', 1),
(62, '120406305', '2014-05-14 18:34:15', '10.16.3.186', 1),
(63, '120406305', '2014-05-14 19:00:08', '10.16.3.186', 1),
(64, '120406305', '2014-05-15 11:09:53', '10.16.1.187', 1),
(65, '120406305', '2014-05-15 19:51:47', '10.16.1.187', 1),
(66, '120406305', '2014-05-15 20:43:48', '10.16.1.187', 1),
(67, '120406305', '2014-05-15 20:50:16', '10.16.1.187', 1),
(68, '120406305', '2014-05-15 21:01:34', '10.16.1.187', 1),
(69, '120406305', '2014-05-15 21:24:58', '10.16.1.187', 1),
(70, '120406305', '2014-05-16 18:37:34', '113.225.195.132', 1),
(71, '120406305', '2014-05-18 21:13:49', '113.225.17.66', 1),
(72, '120406305', '2014-05-18 21:22:41', '113.225.17.66', 1),
(73, '120406305', '2014-05-18 23:25:18', '120.201.105.105', 1),
(74, '120406305', '2014-05-19 11:43:29', '113.225.196.96', 1),
(75, '120406305', '2014-05-19 13:27:45', '113.225.196.96', 1),
(76, '120406305', '2014-05-19 15:10:26', '113.225.196.96', 1),
(77, '120406305', '2014-05-19 18:56:51', '10.16.1.187', 1),
(78, '120406305', '2014-05-20 21:22:45', '113.225.20.23', 1),
(79, '120406305', '2014-05-21 14:27:39', '10.16.2.157', 1),
(80, '120406305', '2014-05-21 14:28:51', '10.16.2.157', 1),
(81, '120406305', '2014-05-21 14:29:08', '10.16.2.157', 1),
(82, '120000000', '2014-05-21 14:29:24', '10.16.2.157', 0),
(83, '120406305', '2014-05-21 20:00:58', '10.16.3.186', 1),
(84, '120406305', '2014-05-22 23:27:38', '120.201.105.116', 1),
(85, '120406305', '2014-05-22 23:38:38', '120.201.105.116', 1),
(86, '120406305', '2014-05-22 23:40:18', '120.201.105.116', 1),
(87, '120406305', '2014-05-22 23:43:17', '120.201.105.116', 1),
(88, '120406305', '2014-05-22 23:44:23', '120.201.105.116', 1),
(89, '120406305', '2014-05-24 16:52:55', '221.8.221.131', 1),
(90, '120406305', '2014-05-24 20:39:18', '222.161.221.3', 1),
(91, '120406305', '2014-05-24 23:18:02', '60.10.69.71', 1),
(92, '120406305', '2014-05-25 18:17:27', '10.16.3.186', 1),
(93, '120406305', '2014-05-25 18:25:07', '10.16.3.186', 0),
(94, '120406305', '2014-05-25 18:25:12', '10.16.3.186', 0),
(95, '120406305', '2014-05-25 18:25:18', '10.16.3.186', 0),
(96, '120406305', '2014-05-25 18:26:12', '10.16.3.186', 0),
(97, '120406305', '2014-05-25 18:26:18', '10.16.3.186', 0),
(98, '120406305', '2014-05-25 18:26:23', '10.16.3.186', 0),
(99, '120406305', '2014-05-25 18:26:26', '10.16.3.186', 0),
(100, '120406305', '2014-05-25 18:27:09', '10.16.3.186', 0),
(101, '120406305', '2014-05-25 18:27:16', '10.16.3.186', 0),
(102, '120406305', '2014-05-25 18:27:54', '10.16.3.186', 0),
(103, '120406305', '2014-05-25 18:28:00', '10.16.3.186', 0),
(104, '120406305', '2014-05-25 18:28:00', '10.16.3.186', 0),
(105, '120406305', '2014-05-25 18:29:32', '10.16.3.186', 0),
(106, '120406305', '2014-05-25 18:30:33', '10.16.3.186', 0),
(107, '120406305', '2014-05-25 18:30:43', '10.16.3.186', 0),
(108, '120406305', '2014-05-25 18:30:52', '10.16.3.186', 0),
(109, '120406305', '2014-05-25 18:33:03', '10.16.3.186', 0),
(110, '120406305', '2014-05-25 18:33:09', '10.16.3.186', 0),
(111, '120406305', '2014-05-25 18:34:30', '10.16.3.186', 0),
(112, '120406305', '2014-05-25 18:34:35', '10.16.3.186', 0),
(113, '120406305', '2014-05-25 18:35:50', '10.16.3.186', 1),
(114, '120406305', '2014-05-25 18:48:42', '10.16.3.186', 1),
(115, '120406305', '2014-05-25 19:13:37', '10.16.3.186', 1),
(116, '120406305', '2014-05-26 14:46:16', '113.225.27.234', 1),
(117, '120406305', '2014-05-28 19:54:06', '120.201.105.65', 1),
(118, '120406305', '2014-05-28 23:50:39', '120.201.105.116', 1),
(119, '120406305', '2014-05-28 23:52:22', '120.201.105.116', 1),
(120, '120406305', '2014-05-28 23:57:41', '175.169.230.52', 1),
(121, '120406305', '2014-05-28 23:59:51', '116.2.83.239', 1),
(122, '120405122', '2014-05-29 09:28:11', '116.2.95.152', 0),
(123, '120405122', '2014-05-29 09:28:28', '116.2.95.152', 0),
(124, '120405122', '2014-05-29 09:28:47', '116.2.95.152', 0),
(125, '100405214', '2014-05-29 10:26:18', '114.247.50.45', 0),
(126, '100405214', '2014-05-29 10:26:27', '114.247.50.45', 0),
(127, '120406305', '2014-05-29 10:26:41', '114.247.50.45', 1),
(128, '110405203', '2014-05-29 10:48:36', '113.225.201.42', 0),
(129, '120406305', '2014-05-29 11:04:27', '113.225.29.55', 1),
(130, '120406305', '2014-05-29 20:02:35', '113.225.27.25', 1),
(131, '120406305', '2014-05-29 20:03:49', '113.225.27.25', 1),
(132, '120406305', '2014-05-29 21:53:47', '113.225.27.25', 1),
(133, '120406305', '2014-05-29 21:58:22', '113.225.27.25', 1),
(134, '120406305', '2014-05-30 21:17:01', '60.10.69.69', 1),
(135, '120406305', '2014-05-30 21:18:52', '60.10.69.69', 1),
(136, '120406305', '2014-05-30 23:53:22', '60.10.69.69', 1),
(137, '120406305', '2014-05-30 23:55:06', '60.10.69.69', 1),
(138, '120406305', '2014-05-31 00:01:02', '60.10.69.69', 1),
(139, '120406305', '2014-05-31 00:19:54', '60.10.69.69', 1),
(140, '120406305', '2014-05-31 00:21:34', '60.10.69.69', 1),
(141, '120406305', '2014-05-31 00:22:42', '60.10.69.69', 1),
(142, '120406305', '2014-05-31 00:27:25', '60.10.69.69', 1),
(143, '120406305', '2014-05-31 00:33:36', '60.10.69.69', 1),
(144, '120406305', '2014-05-31 00:34:22', '60.10.69.69', 1),
(145, '120406305', '2014-05-31 00:34:50', '60.10.69.69', 1),
(146, '120406305', '2014-05-31 00:37:40', '60.10.69.69', 1),
(147, '120406305', '2014-05-31 01:30:53', '222.161.199.186', 1),
(148, '120406305', '2014-05-31 01:31:55', '222.161.199.186', 1),
(149, '120406305', '2014-05-31 09:40:19', '222.161.199.186', 1),
(150, '120406305', '2014-05-31 09:43:52', '222.161.199.186', 1),
(151, '120406305', '2014-05-31 23:34:04', '222.161.199.186', 1),
(152, '120406305', '2014-06-03 16:56:55', '10.16.3.50', 1),
(153, '120406305', '2014-06-09 22:04:55', '113.225.25.110', 1),
(154, '120406305', '2014-06-10 17:58:13', '10.16.1.220', 1),
(155, '120406305', '2014-06-12 15:19:29', '106.120.112.210', 1),
(156, '120406305', '2014-06-23 09:51:06', '10.16.4.39', 1),
(157, '120406305', '2014-06-23 19:01:21', '10.16.1.187', 1),
(158, '120406305', '2014-06-24 19:32:20', '10.16.1.187', 1),
(159, '120406305', '2014-06-24 19:34:50', '10.16.1.187', 1),
(160, '120406305', '2014-06-25 08:42:30', '10.16.20.217', 1),
(161, '120406305', '2014-06-25 08:53:02', '10.16.20.217', 1),
(162, '120406305', '2014-06-25 09:11:10', '10.16.20.217', 1),
(163, '120406305', '2014-06-27 09:12:09', '10.16.20.217', 1),
(164, '120406305', '2014-07-02 10:58:53', '10.16.20.217', 1),
(165, '120406305', '2014-07-07 23:51:35', '110.96.208.130', 1),
(166, '120406305', '2014-07-20 20:23:09', '222.161.198.245', 1),
(167, '120406305', '2014-07-20 20:24:26', '222.161.198.245', 1),
(168, '120406305', '2014-07-20 20:25:22', '222.161.198.245', 1);

-- --------------------------------------------------------

--
-- 表的结构 `medal`
--

CREATE TABLE IF NOT EXISTS `medal` (
  `medal_sum_id` int(10) NOT NULL AUTO_INCREMENT COMMENT '勋章流水号',
  `medal_id` int(10) NOT NULL COMMENT '勋章编号',
  `user_number_from` char(20) NOT NULL COMMENT '勋章发放人',
  `user_number_to` char(20) NOT NULL COMMENT '勋章领取人',
  `medal_name` varchar(64) NOT NULL COMMENT '勋章名称',
  `medal_defunct` int(1) NOT NULL COMMENT '隐藏勋章',
  `medal_addin` varchar(400) NOT NULL COMMENT '附加文本',
  PRIMARY KEY (`medal_sum_id`),
  UNIQUE KEY `medal_sum_id` (`medal_sum_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `medal_property`
--

CREATE TABLE IF NOT EXISTS `medal_property` (
  `medal_id` int(10) NOT NULL AUTO_INCREMENT COMMENT '勋章编号',
  `medal_detail` varchar(400) NOT NULL COMMENT '勋章描述',
  `medal_img` varchar(64) NOT NULL COMMENT '勋章图片地址',
  PRIMARY KEY (`medal_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `message`
--

CREATE TABLE IF NOT EXISTS `message` (
  `mess_id` int(10) NOT NULL AUTO_INCREMENT,
  `mess_from_number` char(20) NOT NULL,
  `mess_to_number` char(20) NOT NULL,
  `mess_title` varchar(400) NOT NULL,
  `mess_content` varchar(4000) NOT NULL,
  `mess_sign` varchar(400) NOT NULL,
  `mess_time` datetime NOT NULL,
  `mess_read` tinyint(1) NOT NULL,
  `mess_anonymity` tinyint(1) NOT NULL COMMENT '发送者匿名',
  `mess_accusation` tinyint(1) NOT NULL COMMENT '举报',
  `mess_accusation_reason` varchar(1000) NOT NULL COMMENT '举报原因',
  `mess_accusation_time` datetime NOT NULL COMMENT '举报时间',
  `mess_dele` tinyint(1) NOT NULL COMMENT '收件人删除',
  `mess_dele_time` datetime NOT NULL COMMENT '收件人删除时间',
  `mess_dele_from` tinyint(1) NOT NULL COMMENT '发件人删除',
  `mess_dele_from_time` datetime NOT NULL COMMENT '发件人删除时间',
  `mess_smash` tinyint(1) NOT NULL COMMENT '收件人销毁',
  `mess_smash_from` tinyint(1) NOT NULL COMMENT '发件人销毁',
  PRIMARY KEY (`mess_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=39 ;

--
-- 转存表中的数据 `message`
--

INSERT INTO `message` (`mess_id`, `mess_from_number`, `mess_to_number`, `mess_title`, `mess_content`, `mess_sign`, `mess_time`, `mess_read`, `mess_anonymity`, `mess_accusation`, `mess_accusation_reason`, `mess_accusation_time`, `mess_dele`, `mess_dele_time`, `mess_dele_from`, `mess_dele_from_time`, `mess_smash`, `mess_smash_from`) VALUES
(1, '120406305', '120406305', '3Tyt1OYncoRB6OJsKllV4XNBVMlBcUaK745Yvp10hZxR4Tvai+/qFvIh1wlg3KXU8P5Yxsl/DU1mgaQ9p+cq9w==', 'ojFyPmu2oZemBuU0IX/Qhfn5OEs6D8n270gGbtvwMvWOM8mFQfPBceRwJD+8hUTA54rd9NEF/tcRBGY9UhXnnDo9LSBGGU1dIwkp1FFPFTM4H/maeoozBsg65ZowJXw9Fob/J8NH2j8VVwR8DA5khLBndiHpW/kbvFmDoxBkYR0wfJkYXf5znas+6RN3k+5BajkU/+Q3O14woIRXVUsczp0wJtCaYAKHqYUcbzRnWvVfkceemXjp4rJC1aeIlo5jPz1DSG5Q711h5aITTHW/KuLy/oAZvwjEuP5jlqaMSwhT8qxA2tQBgL7MqE5u7tXOfN249u1pE8dSH4IiaF1DqprFrQ57r2l6Qt/lG0KhTTIH/P8phN5/J7M+zvBJc6lszjw4xUnHl4NZ2dRESDaj6rBqPKwV+P63rD1cWDoK0Vg=', 'zh2mYkjLvQIcxpspvhN/3yBhum9Ps1WyoRXQSFtDg/6dNgMtQnd7OhlodkNlxnb+vlEHRVP0jgfNmg2XGRPcO8fH2mrNkNFSF3mcwjPhzQNQoDumXxHBsg2xMRRLEYpD', '2014-05-03 21:04:29', 0, 0, 0, '', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, 0),
(2, '120406305', '10000', '3Tyt1OYncoRB6OJsKllV4XNBVMlBcUaK745Yvp10hZxR4Tvai+/qFvIh1wlg3KXU8P5Yxsl/DU1mgaQ9p+cq9w==', 'ojFyPmu2oZemBuU0IX/Qhfn5OEs6D8n270gGbtvwMvWOM8mFQfPBceRwJD+8hUTA54rd9NEF/tcRBGY9UhXnnDo9LSBGGU1dIwkp1FFPFTM4H/maeoozBsg65ZowJXw9Fob/J8NH2j8VVwR8DA5khLBndiHpW/kbvFmDoxBkYR0wfJkYXf5znas+6RN3k+5BajkU/+Q3O14woIRXVUsczp0wJtCaYAKHqYUcbzRnWvVfkceemXjp4rJC1aeIlo5jPz1DSG5Q711h5aITTHW/KuLy/oAZvwjEuP5jlqaMSwhT8qxA2tQBgL7MqE5u7tXOfN249u1pE8dSH4IiaF1DqprFrQ57r2l6Qt/lG0KhTTIH/P8phN5/J7M+zvBJc6lszjw4xUnHl4NZ2dRESDaj6rBqPKwV+P63rD1cWDoK0Vg=', 'zh2mYkjLvQIcxpspvhN/3yBhum9Ps1WyoRXQSFtDg/6dNgMtQnd7OhlodkNlxnb+vlEHRVP0jgfNmg2XGRPcO8fH2mrNkNFSF3mcwjPhzQNQoDumXxHBsg2xMRRLEYpD', '2014-05-03 21:04:29', 0, 0, 0, '', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, 0),
(3, '120406305', '120406305', '7YUgfnBHgjxuUqcFR97ixIiQ3NP37GGb+NYt39UnAwHsn7PdkrIU2jhugC6ierBHYEAtIPLn44jn5NwatldAQA==', 'wqnswSLfg4COkHOF3dGaLD2ljhrim7F/xJj2mErEzJMH1iC06mT5cZuCfp22UeVO/PSJ8NXlyEZhZec4j56bh0q+YHfTQyxzQ5Fcym1qvrp5BRUHxWT9eIoT8u/NlkUTMHYlrcybcIOen0r3RSnGcouzLIuPgEfj3vH2rjfX/ZX89mX2ZSW/C0Uvt22wpgdkR/GTKTETQmVaGEXB/kdo6gTKJlbxf8P6KBOtLf7ss8dlRIlPJQhVuXl5zomjeLSMJe1iUK/sSXX19EjptrcMOOKWZLlvTsHo/tb1n5muaA6V0ml6G/h2xT4Hca8X60hQRWYJAWwVrBmnteE6BGe5OQkDhWJ2Tmt7QA8PjSvLpy7fohY6vvgFaP6jFWRNMudk', 'j29HMIkiGJnrASI+yzHPUyMsoo8ETOxdgzNhGG6KgPC4DANMH9EkdaiLJ6iSz9ENXD0z798+URNK8vQEV78N9ZMDpchl1n2GeWXY/M71WwQLtA52fl8sCGJdKG7oPW2E', '2014-05-03 21:10:07', 0, 0, 0, '', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, 0),
(4, '120406305', '10000', '7YUgfnBHgjxuUqcFR97ixIiQ3NP37GGb+NYt39UnAwHsn7PdkrIU2jhugC6ierBHYEAtIPLn44jn5NwatldAQA==', 'wqnswSLfg4COkHOF3dGaLD2ljhrim7F/xJj2mErEzJMH1iC06mT5cZuCfp22UeVO/PSJ8NXlyEZhZec4j56bh0q+YHfTQyxzQ5Fcym1qvrp5BRUHxWT9eIoT8u/NlkUTMHYlrcybcIOen0r3RSnGcouzLIuPgEfj3vH2rjfX/ZX89mX2ZSW/C0Uvt22wpgdkR/GTKTETQmVaGEXB/kdo6gTKJlbxf8P6KBOtLf7ss8dlRIlPJQhVuXl5zomjeLSMJe1iUK/sSXX19EjptrcMOOKWZLlvTsHo/tb1n5muaA6V0ml6G/h2xT4Hca8X60hQRWYJAWwVrBmnteE6BGe5OQkDhWJ2Tmt7QA8PjSvLpy7fohY6vvgFaP6jFWRNMudk', 'j29HMIkiGJnrASI+yzHPUyMsoo8ETOxdgzNhGG6KgPC4DANMH9EkdaiLJ6iSz9ENXD0z798+URNK8vQEV78N9ZMDpchl1n2GeWXY/M71WwQLtA52fl8sCGJdKG7oPW2E', '2014-05-03 21:10:07', 0, 0, 0, '', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, 0),
(5, '120406305', '120406305', 'nu5X7OBU2BmrkxuQ8jWQNnvA8gl8RuhLDwTeSuoiQUPvx1i62tnoNGbcWcNAqBFOI5dWCYNeTj9YcTUtmuzfbw==', 'qF0bHTHUuV/5CVnVCsok6YesUT4RulxIMvpxi+dIyxytmp1SDTLjKXr1vPQJ3SVI+P4EnPVwZJQteymWXujNNQEDnVTQ92YvBYePaIChRHVCcTbBlYE7XdWxx6iMgG+PMg1mLaSpfk993q+JATR1YB8sU8ZNz2YfOHtaYAyVwtqEqnN83xkftfo8BqVuf32G3WkIw4OJwG7RFGpugNU8NC5/Bt8ynTetj/fE4zK5cf8GhcceMIPEEyUcRw0j8q6qsoUcYSat+sASPjnku27s194A4j2U4Oowl9PmCHCHNbKL9YQmCAuwv+H+JlKy1qIDb3Je824bvR7jkJZsZydvttg27zvQngjGg+3gnGC3g8qoN7QAtZ3pdsgzXV2cjVmY', 'M6htYBLfErU47uiufLXKefvQGvW2lDzYRyhTLE1Q42SDjas6KON+zNdTS8jgVNpzIRLLO9PF11q+jhPHjm1084F4knNgH0/o+gvzIDwKVjIZqV61Qu2KEhNwb/uWMxq2', '2014-05-03 21:11:23', 1, 0, 0, '', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, 0),
(6, '120406305', '10000', 'nu5X7OBU2BmrkxuQ8jWQNnvA8gl8RuhLDwTeSuoiQUPvx1i62tnoNGbcWcNAqBFOI5dWCYNeTj9YcTUtmuzfbw==', 'qF0bHTHUuV/5CVnVCsok6YesUT4RulxIMvpxi+dIyxytmp1SDTLjKXr1vPQJ3SVI+P4EnPVwZJQteymWXujNNQEDnVTQ92YvBYePaIChRHVCcTbBlYE7XdWxx6iMgG+PMg1mLaSpfk993q+JATR1YB8sU8ZNz2YfOHtaYAyVwtqEqnN83xkftfo8BqVuf32G3WkIw4OJwG7RFGpugNU8NC5/Bt8ynTetj/fE4zK5cf8GhcceMIPEEyUcRw0j8q6qsoUcYSat+sASPjnku27s194A4j2U4Oowl9PmCHCHNbKL9YQmCAuwv+H+JlKy1qIDb3Je824bvR7jkJZsZydvttg27zvQngjGg+3gnGC3g8qoN7QAtZ3pdsgzXV2cjVmY', 'M6htYBLfErU47uiufLXKefvQGvW2lDzYRyhTLE1Q42SDjas6KON+zNdTS8jgVNpzIRLLO9PF11q+jhPHjm1084F4knNgH0/o+gvzIDwKVjIZqV61Qu2KEhNwb/uWMxq2', '2014-05-03 21:11:23', 0, 0, 0, '', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, 0),
(7, '120406305', '120406305', 'see3EcXnL5thbGOKAAcBaxbzKve88+hvqrFQsd/5HTHnxgb84x1m6k5sXdX0nePFhKuDQ0LqYqec0W9BOBa0vA==', 'GlllBQBN5zy0d6T3nRgFIo0kePYwoTpEdi+AGbUZpaelvbC9o5qDbN135Os5ouT9pdm9ja/aOvNjb8Y6vxuCaAqj4Na4JY2ULtWAh1AOfQahDJt4/GdA/V0rPBQ6TiwtyAMt/YtLqoYprmSjBUsYihZJqcM00rZ+l9s9HgTQqTdnVbimpLrtpMxDs2hZfVFvQ28N1/Mu43Z+xTBdofUDU7nDO8ORAdVoa0wUA9Qk7yj2AJcpwSFfWhC4XrK9t4HvuAyGWS4hIwcsHGJm+gLXu+MBTBdLaLB9xFIH6j+lhhDOA4LUm2yB0iSlmsVYq3N3Ko3zk/OrBkSbCpbtb7BPVON7hltGSuSe6ed3Q3zRukUmYT+QPjIYGOCO3TWYRmnl', 'YnomUtCgo0wS7CgHwxzbx1QP9hlaPCiOrmcJcfBYtKKdqmoAmp2aiYKJ6wJl4qjeaGbJKXljCAH155eEt+FvqB7E0M5yK8787Un38JJpnkmW5PbWRBnb9Spz9n6b7CWl', '2014-05-03 21:12:42', 0, 0, 0, '', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, 0),
(8, '120406305', '10000', 'see3EcXnL5thbGOKAAcBaxbzKve88+hvqrFQsd/5HTHnxgb84x1m6k5sXdX0nePFhKuDQ0LqYqec0W9BOBa0vA==', 'GlllBQBN5zy0d6T3nRgFIo0kePYwoTpEdi+AGbUZpaelvbC9o5qDbN135Os5ouT9pdm9ja/aOvNjb8Y6vxuCaAqj4Na4JY2ULtWAh1AOfQahDJt4/GdA/V0rPBQ6TiwtyAMt/YtLqoYprmSjBUsYihZJqcM00rZ+l9s9HgTQqTdnVbimpLrtpMxDs2hZfVFvQ28N1/Mu43Z+xTBdofUDU7nDO8ORAdVoa0wUA9Qk7yj2AJcpwSFfWhC4XrK9t4HvuAyGWS4hIwcsHGJm+gLXu+MBTBdLaLB9xFIH6j+lhhDOA4LUm2yB0iSlmsVYq3N3Ko3zk/OrBkSbCpbtb7BPVON7hltGSuSe6ed3Q3zRukUmYT+QPjIYGOCO3TWYRmnl', 'YnomUtCgo0wS7CgHwxzbx1QP9hlaPCiOrmcJcfBYtKKdqmoAmp2aiYKJ6wJl4qjeaGbJKXljCAH155eEt+FvqB7E0M5yK8787Un38JJpnkmW5PbWRBnb9Spz9n6b7CWl', '2014-05-03 21:12:42', 0, 0, 0, '', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, 0),
(9, '120406305', '120406305', 'MKfKnc21WKO/4DmlMm+zSH6cpgQc3fKQvaHWIjPNWiXJuVY7b0CHzEZ3+T2cCSciEc3buHiS8RhFn0OeWL5Muw==', '8AH9/AnykffolCNENCqVPJFr6gZf0gY3zWK1pK56a4cSko88s66B3axSlJWF3L+pRZ+1y9IDSFcVwVDtYb6qyE3/OJCrc9PEBNXgIGtk4NuF50JR6Gx6er7G0t07EcIM+uhWYyccfwDgT/6cM7V1/6ZIyzZ6lJefp5Hd5qW9YeA9WGpTdjSsb/Triu3EeiNDCwLG+RXfrfBoSfL7T7zjGbb6DUxajWLJ3Xfvsx8vSzy7Ui7qHBVsBpOKk68ENczY/UxNBHv9f1/3aYNZSJY6D8gczN1qsWEd6JGfe+8Gc3MydyiHHvi0lU+3IYLt0WI1wEYI6/6JY6rGyGMpXbch230jSWorOVWJL7bRDViAvAVmCgT40X4025JRTt9e0SX8', '/2xzoUMt3jOYWeaG0meEu2xROlQy1uZb6DvNibIrR/F9Gt9BHPAQ8IqSS+6jVQW5J6jYTcdm6rsBUsWrgYb1mOB41X35tbcS52Gxz1GZ0gpkO7VnSKQtHCucY1J1tM/r', '2014-05-03 21:13:30', 0, 0, 0, '', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, 0),
(10, '120406305', '10000', 'MKfKnc21WKO/4DmlMm+zSH6cpgQc3fKQvaHWIjPNWiXJuVY7b0CHzEZ3+T2cCSciEc3buHiS8RhFn0OeWL5Muw==', '8AH9/AnykffolCNENCqVPJFr6gZf0gY3zWK1pK56a4cSko88s66B3axSlJWF3L+pRZ+1y9IDSFcVwVDtYb6qyE3/OJCrc9PEBNXgIGtk4NuF50JR6Gx6er7G0t07EcIM+uhWYyccfwDgT/6cM7V1/6ZIyzZ6lJefp5Hd5qW9YeA9WGpTdjSsb/Triu3EeiNDCwLG+RXfrfBoSfL7T7zjGbb6DUxajWLJ3Xfvsx8vSzy7Ui7qHBVsBpOKk68ENczY/UxNBHv9f1/3aYNZSJY6D8gczN1qsWEd6JGfe+8Gc3MydyiHHvi0lU+3IYLt0WI1wEYI6/6JY6rGyGMpXbch230jSWorOVWJL7bRDViAvAVmCgT40X4025JRTt9e0SX8', '/2xzoUMt3jOYWeaG0meEu2xROlQy1uZb6DvNibIrR/F9Gt9BHPAQ8IqSS+6jVQW5J6jYTcdm6rsBUsWrgYb1mOB41X35tbcS52Gxz1GZ0gpkO7VnSKQtHCucY1J1tM/r', '2014-05-03 21:13:30', 0, 0, 0, '', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, 0),
(11, '120406305', '120406306', '/t2fi5smMXTz7EvXP/llAjXd5sxXSgZQnmcBBKFJEAagNQpSyuXbmQAD6v9dwmJYfz55pEv+PFkl3d0zF+hxCQ==', '/st6FdT+f9eciLG4zCSkgx3nT0wRq59xg4jPZR1o+HzbEXrE70hpjCnlrlhTvCg4ys+04KoLuJwERly8xtztSRkUMmpdUvwNxNlD+ASxeT99BowbIzVxfQtSGvLU3NaBLgd3SztQJ8TXjitsLMnHAX1Y/H5cxJCIaCGVmTIEizw2lOtaxbNcA69lZcRkQO+9rDYRSaOLUaYkR9C+URI4e5cUVlL4ShPrmE20Ggc0g8NZYpo34LJFNPWr/WmvqlPU', 'AR80VCjJ4qItFC7msAZshXOEESDGZAqngJFsQELkBT+ghoqcvk10DAhLn3bit1TnqXUAtfEFvrjVQZDx5iGv+NmK+vI2X2ezeTmtco7+MkoinR/D9M5lnXTMCfvFW42oMrkneVOS8fxw7NgZJngZKNM9sRR+EmawnGXdHUnYWAc=', '2014-05-03 22:53:47', 0, 0, 0, '', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, 0),
(12, '120406305', '120406306', 'T7zyhOnNPmU7eOga495S+pG770PdxX1DmBgDr45oSV3uCLijzP0TZRSHs7HZg5lK9JyDQcERbNKvbn8WVxkVrw==', 'Wf5T4rj398JGW5ByWHnAy80eqQPtJk3WeLq+Zlal9wk9v2I7aniWjpYnLL7ywdaeLl+5PVIE5gmQNNoD5k+taLerafS6niuvrYE7J8Em0NpMtqFnXtZFVOgGW7jzyDvApQuXUJl0YP4VYHBdW0ScCyEH2btPtSkZDEoo9FGKLfvAMiq9fGOx8TbwbeViOG2yVby7N+AM65Pm3G6Fe0VG2RncLVP7EfX5lUQfKFlze9nxw52nL8qYIFj/lBAMlBED', 'AAZBfLajMWIja3byXnyaelxd6sHwBVIZR10woRl2dxZtYhsHbQ/4ufMDI1sdwS14WvE08WqMxSGjwGpCozDfGtWn5jN+vwC3O9CLOieWso+LSBCIKISaJe3f5DxamYJWGAgS9EReUYRlnjFKTPYZVDNn4AlPV27Cw4Fg3cWdNGM=', '2014-05-03 22:55:03', 0, 0, 0, '', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, 0),
(13, '120406306', '120406305', 'W8IUIY5xK1SlASlndH3U4jhBRKAhFWy+No7b97S3rctKSDcXDz63rLjj41uwafssz6hTxyvhB/HwA7Lc0xR0fQ==', 'WTYXa/DQCiyyM/F/ukwUWu1QkmDrEX4EYJxfI7E7U4HH63DLUggnR2J0186xYy0D6acPRIZNx4wxRN1cq21oKNqbICKzQClhhw2DarjggRynmirO5kfD7oR7NdplVcmd8ap88Zzr257hYZwLqrX30HJ6afeikVdE+sYo9ZMLnYhktVfXinbPh+gDFh5YZUvMpv4A6+lFDQP0pNWjmTenoLUfNW/fnoOCQP1lliG3zmRKYLQxrSClcNKli7rZzLG8AexYNknR6H6ZE+HoIEz1mfwGNsTBtwjz/k8ss2kneQPawx4kfrZn4guae4lsAhLq/Yx9M2V5IBVudW1OvB3TwKY1NZVrL9me8xCRly3eBnpTBR0wS9tA626CAvvt21Nx', 'T6loUlcHRsOxBKLsmAD6vsW5GxPgEwhtHyVlkyPXS492HTygWBHOqWc24YLLUjxAnzxRgx92zZrU6FusGMVtPOWtB+eC9s64kjqpJh5HDSsi96o3ZYVVjNvClhjE5Dvp', '2014-05-03 22:59:44', 0, 0, 0, '', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, 0),
(14, '120406306', '10000', 'W8IUIY5xK1SlASlndH3U4jhBRKAhFWy+No7b97S3rctKSDcXDz63rLjj41uwafssz6hTxyvhB/HwA7Lc0xR0fQ==', 'WTYXa/DQCiyyM/F/ukwUWu1QkmDrEX4EYJxfI7E7U4HH63DLUggnR2J0186xYy0D6acPRIZNx4wxRN1cq21oKNqbICKzQClhhw2DarjggRynmirO5kfD7oR7NdplVcmd8ap88Zzr257hYZwLqrX30HJ6afeikVdE+sYo9ZMLnYhktVfXinbPh+gDFh5YZUvMpv4A6+lFDQP0pNWjmTenoLUfNW/fnoOCQP1lliG3zmRKYLQxrSClcNKli7rZzLG8AexYNknR6H6ZE+HoIEz1mfwGNsTBtwjz/k8ss2kneQPawx4kfrZn4guae4lsAhLq/Yx9M2V5IBVudW1OvB3TwKY1NZVrL9me8xCRly3eBnpTBR0wS9tA626CAvvt21Nx', 'T6loUlcHRsOxBKLsmAD6vsW5GxPgEwhtHyVlkyPXS492HTygWBHOqWc24YLLUjxAnzxRgx92zZrU6FusGMVtPOWtB+eC9s64kjqpJh5HDSsi96o3ZYVVjNvClhjE5Dvp', '2014-05-03 22:59:44', 0, 0, 0, '', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, 0),
(15, '120406306', '120406306', 'W8IUIY5xK1SlASlndH3U4jhBRKAhFWy+No7b97S3rctKSDcXDz63rLjj41uwafssz6hTxyvhB/HwA7Lc0xR0fQ==', 'WTYXa/DQCiyyM/F/ukwUWu1QkmDrEX4EYJxfI7E7U4HH63DLUggnR2J0186xYy0D6acPRIZNx4wxRN1cq21oKNqbICKzQClhhw2DarjggRynmirO5kfD7oR7NdplVcmd8ap88Zzr257hYZwLqrX30HJ6afeikVdE+sYo9ZMLnYhktVfXinbPh+gDFh5YZUvMpv4A6+lFDQP0pNWjmTenoLUfNW/fnoOCQP1lliG3zmRKYLQxrSClcNKli7rZzLG8AexYNknR6H6ZE+HoIEz1mfwGNsTBtwjz/k8ss2kneQPawx4kfrZn4guae4lsAhLq/Yx9M2V5IBVudW1OvB3TwKY1NZVrL9me8xCRly3eBnpTBR0wS9tA626CAvvt21Nx', 'T6loUlcHRsOxBKLsmAD6vsW5GxPgEwhtHyVlkyPXS492HTygWBHOqWc24YLLUjxAnzxRgx92zZrU6FusGMVtPOWtB+eC9s64kjqpJh5HDSsi96o3ZYVVjNvClhjE5Dvp', '2014-05-03 22:59:44', 0, 0, 0, '', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, 0),
(16, '120406306', '120406305', 'U0bEbL2jQIrOsWg7sIvSwWaz7F+lDBe2dcv/Q0NNOXqi8GdB4W/jESclMzpxod7wJnfM5x6t5+N7DDFOLwRrFw==', 'WDgnvqtZzt6r7Eozl36YkR9SX2inhFpZo77195sIYSv01m0OxtkNEfVwZu1Xqf5E2kuCTCE1pvS56NrA+xfLLC/pCcRm5RBiYx3zY8U/u8jSv0Epf2Pry5ZvHV8HK9aKCl12AUOg/fOiAyfsoyl8ekg4XvesdqMREdRwCXB0ytuFTeZ5qwoULphLzohmHDLaXkAJx8b4XB2w4It3mwidtWOJveLZ52N/QcTlsiv/lNojgFCs+z4bZBrwIR9OahxUul6va5FEm7KR2RwiIo3VFdIFcM5YRMo5otv+RGchDR+0+PjAvUMqe0wdgbZL38UmVhSJIA4Qhr5yL6ipvfkHeybaX5XBke4l/4h4vsBX8Q24L6/EzBad81fLBrdj1E6C', 'lTD3W+URnwiNK9OUloNj6AoUR3oPzcfdV+wp0qxeZ8tcyRmbNfijN+KRWUafGbMXtvlb4ngXUCUlX8B9AHgtqjdSBDBoqFC0pIE6kCSf36mOMXnKbX5XEzX20vd1yyzM', '2014-05-03 23:01:51', 0, 0, 0, '', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, 0),
(17, '120406306', '10000', 'U0bEbL2jQIrOsWg7sIvSwWaz7F+lDBe2dcv/Q0NNOXqi8GdB4W/jESclMzpxod7wJnfM5x6t5+N7DDFOLwRrFw==', 'WDgnvqtZzt6r7Eozl36YkR9SX2inhFpZo77195sIYSv01m0OxtkNEfVwZu1Xqf5E2kuCTCE1pvS56NrA+xfLLC/pCcRm5RBiYx3zY8U/u8jSv0Epf2Pry5ZvHV8HK9aKCl12AUOg/fOiAyfsoyl8ekg4XvesdqMREdRwCXB0ytuFTeZ5qwoULphLzohmHDLaXkAJx8b4XB2w4It3mwidtWOJveLZ52N/QcTlsiv/lNojgFCs+z4bZBrwIR9OahxUul6va5FEm7KR2RwiIo3VFdIFcM5YRMo5otv+RGchDR+0+PjAvUMqe0wdgbZL38UmVhSJIA4Qhr5yL6ipvfkHeybaX5XBke4l/4h4vsBX8Q24L6/EzBad81fLBrdj1E6C', 'lTD3W+URnwiNK9OUloNj6AoUR3oPzcfdV+wp0qxeZ8tcyRmbNfijN+KRWUafGbMXtvlb4ngXUCUlX8B9AHgtqjdSBDBoqFC0pIE6kCSf36mOMXnKbX5XEzX20vd1yyzM', '2014-05-03 23:01:51', 0, 0, 0, '', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, 0),
(18, '120406306', '120406306', 'U0bEbL2jQIrOsWg7sIvSwWaz7F+lDBe2dcv/Q0NNOXqi8GdB4W/jESclMzpxod7wJnfM5x6t5+N7DDFOLwRrFw==', 'WDgnvqtZzt6r7Eozl36YkR9SX2inhFpZo77195sIYSv01m0OxtkNEfVwZu1Xqf5E2kuCTCE1pvS56NrA+xfLLC/pCcRm5RBiYx3zY8U/u8jSv0Epf2Pry5ZvHV8HK9aKCl12AUOg/fOiAyfsoyl8ekg4XvesdqMREdRwCXB0ytuFTeZ5qwoULphLzohmHDLaXkAJx8b4XB2w4It3mwidtWOJveLZ52N/QcTlsiv/lNojgFCs+z4bZBrwIR9OahxUul6va5FEm7KR2RwiIo3VFdIFcM5YRMo5otv+RGchDR+0+PjAvUMqe0wdgbZL38UmVhSJIA4Qhr5yL6ipvfkHeybaX5XBke4l/4h4vsBX8Q24L6/EzBad81fLBrdj1E6C', 'lTD3W+URnwiNK9OUloNj6AoUR3oPzcfdV+wp0qxeZ8tcyRmbNfijN+KRWUafGbMXtvlb4ngXUCUlX8B9AHgtqjdSBDBoqFC0pIE6kCSf36mOMXnKbX5XEzX20vd1yyzM', '2014-05-03 23:01:51', 0, 0, 0, '', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, 0),
(19, '120406306', '120406305', 'GKcaLXsq5BKm+nUngaAl0vr3nfYotGPqEQNDyPGFGn7AaRzOiaFmggF5QhYjRAPxvq18vIt8mKZ8kZsBjCLR8A==', 'gJnqYAcTgmwkEl8t7aK2nyvcMkdwMmBywTEOHf3J3bL1nhuBWwFa5U16wXAwykIi9cPn72PAsHFpQA1xtHJRROCS8hgW1s0ronOq7WbNGh+FFsSb+E75MGUE4dURocBP8mkHe+rGCHnYTSPadsHPlGqwYbtsC0o92vNC8G8tM0EgzV5MLD02tJUEoa2iepMn98B2/a8hc5dIADbF+9ZK8kAJfnZgmoWBmglkxU9X24sfwxKm2JlfO/nq7UV1zYMDKRz0hGGXd6YQA7wMYtNpXfxJSBmqT4HLNLvO2xgu1CYUhLzWWiMO78xm8bYqARnGJZTe7LkjHn8lE0BfPHWiFIYeua2udg/DHF1xc/9Q7QBIuR5yWRcibqjDi1JYfPtU', 'mjfmKiagF4hdHK/brxWeFM06ICqfYsfUZ0bVrmjS/gKe7QjFvqSZ7YCFop9sabtaquUInY5/ph8jXQsNRy8+0GsFc6i4t/AjK/GSFqeOPE99u1kmBNSYRounE3prBZns', '2014-05-03 23:02:04', 0, 0, 0, '', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, 0),
(20, '120406306', '10000', 'GKcaLXsq5BKm+nUngaAl0vr3nfYotGPqEQNDyPGFGn7AaRzOiaFmggF5QhYjRAPxvq18vIt8mKZ8kZsBjCLR8A==', 'gJnqYAcTgmwkEl8t7aK2nyvcMkdwMmBywTEOHf3J3bL1nhuBWwFa5U16wXAwykIi9cPn72PAsHFpQA1xtHJRROCS8hgW1s0ronOq7WbNGh+FFsSb+E75MGUE4dURocBP8mkHe+rGCHnYTSPadsHPlGqwYbtsC0o92vNC8G8tM0EgzV5MLD02tJUEoa2iepMn98B2/a8hc5dIADbF+9ZK8kAJfnZgmoWBmglkxU9X24sfwxKm2JlfO/nq7UV1zYMDKRz0hGGXd6YQA7wMYtNpXfxJSBmqT4HLNLvO2xgu1CYUhLzWWiMO78xm8bYqARnGJZTe7LkjHn8lE0BfPHWiFIYeua2udg/DHF1xc/9Q7QBIuR5yWRcibqjDi1JYfPtU', 'mjfmKiagF4hdHK/brxWeFM06ICqfYsfUZ0bVrmjS/gKe7QjFvqSZ7YCFop9sabtaquUInY5/ph8jXQsNRy8+0GsFc6i4t/AjK/GSFqeOPE99u1kmBNSYRounE3prBZns', '2014-05-03 23:02:04', 0, 0, 0, '', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, 0),
(21, '120406306', '120406306', 'GKcaLXsq5BKm+nUngaAl0vr3nfYotGPqEQNDyPGFGn7AaRzOiaFmggF5QhYjRAPxvq18vIt8mKZ8kZsBjCLR8A==', 'gJnqYAcTgmwkEl8t7aK2nyvcMkdwMmBywTEOHf3J3bL1nhuBWwFa5U16wXAwykIi9cPn72PAsHFpQA1xtHJRROCS8hgW1s0ronOq7WbNGh+FFsSb+E75MGUE4dURocBP8mkHe+rGCHnYTSPadsHPlGqwYbtsC0o92vNC8G8tM0EgzV5MLD02tJUEoa2iepMn98B2/a8hc5dIADbF+9ZK8kAJfnZgmoWBmglkxU9X24sfwxKm2JlfO/nq7UV1zYMDKRz0hGGXd6YQA7wMYtNpXfxJSBmqT4HLNLvO2xgu1CYUhLzWWiMO78xm8bYqARnGJZTe7LkjHn8lE0BfPHWiFIYeua2udg/DHF1xc/9Q7QBIuR5yWRcibqjDi1JYfPtU', 'mjfmKiagF4hdHK/brxWeFM06ICqfYsfUZ0bVrmjS/gKe7QjFvqSZ7YCFop9sabtaquUInY5/ph8jXQsNRy8+0GsFc6i4t/AjK/GSFqeOPE99u1kmBNSYRounE3prBZns', '2014-05-03 23:02:04', 0, 0, 0, '', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, 0),
(22, '120406305', '120406305', 'n/iMhehWUH7YrJb52VE7LE4lUp2xzkGntSk/6RN9jq0D5UcDK+LAHDq370QmlexkQJlNYwHlBbvv3QqEusiN2A==', 'ZQYjWCEj1xiSFBBPCYP4QW3yfbuy1Bw6EGMSwC4ir54+j87rHBbvtGnxgBnppEjUNZDICgHbuc6THyo0WDHXEsHRR4tU88ooZUqPYWFIqQkDoi3NWemRzHD57Gp1p+qbq4c9bYgRqQmFvB0W3s8MfdTkDTz6NpPROIX2DI5D9IaPaPJQuWfQii7n7jTfy3e3US5ggYD/p1M/36OtekW/wcfsGtdAbZlDiIcIBSb3IbuPE75eTMUE6nlyx7GyKkFbAmVrx1p4dib8wG9A06juRUxweetegWU4STuoWqw9oUmcZZ1oBISyv9u5V9xskElBxHUf758WGN7SqSsNfBD7+e8avBS8e4GMDWyyKJuQOPseCN+9nm0q5YUbGUoX3uPo', '7GCKmMnyE9ND7Y5VTkL24qHh2KTy64uCae+l8m97R+fv8czh6i2/DnCmJ/8KqzglvA3Q9XyyQnAhXSeaBhTh88Tt/4o67wB03u+wU8xMzOIYYtnKKI1O/ppLQq8FGwL8', '2014-05-03 23:11:41', 0, 0, 0, '', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, 0),
(23, '120406305', '10000', 'n/iMhehWUH7YrJb52VE7LE4lUp2xzkGntSk/6RN9jq0D5UcDK+LAHDq370QmlexkQJlNYwHlBbvv3QqEusiN2A==', 'ZQYjWCEj1xiSFBBPCYP4QW3yfbuy1Bw6EGMSwC4ir54+j87rHBbvtGnxgBnppEjUNZDICgHbuc6THyo0WDHXEsHRR4tU88ooZUqPYWFIqQkDoi3NWemRzHD57Gp1p+qbq4c9bYgRqQmFvB0W3s8MfdTkDTz6NpPROIX2DI5D9IaPaPJQuWfQii7n7jTfy3e3US5ggYD/p1M/36OtekW/wcfsGtdAbZlDiIcIBSb3IbuPE75eTMUE6nlyx7GyKkFbAmVrx1p4dib8wG9A06juRUxweetegWU4STuoWqw9oUmcZZ1oBISyv9u5V9xskElBxHUf758WGN7SqSsNfBD7+e8avBS8e4GMDWyyKJuQOPseCN+9nm0q5YUbGUoX3uPo', '7GCKmMnyE9ND7Y5VTkL24qHh2KTy64uCae+l8m97R+fv8czh6i2/DnCmJ/8KqzglvA3Q9XyyQnAhXSeaBhTh88Tt/4o67wB03u+wU8xMzOIYYtnKKI1O/ppLQq8FGwL8', '2014-05-03 23:11:41', 0, 0, 0, '', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, 0),
(24, '120406305', '120406306', 'n/iMhehWUH7YrJb52VE7LE4lUp2xzkGntSk/6RN9jq0D5UcDK+LAHDq370QmlexkQJlNYwHlBbvv3QqEusiN2A==', 'ZQYjWCEj1xiSFBBPCYP4QW3yfbuy1Bw6EGMSwC4ir54+j87rHBbvtGnxgBnppEjUNZDICgHbuc6THyo0WDHXEsHRR4tU88ooZUqPYWFIqQkDoi3NWemRzHD57Gp1p+qbq4c9bYgRqQmFvB0W3s8MfdTkDTz6NpPROIX2DI5D9IaPaPJQuWfQii7n7jTfy3e3US5ggYD/p1M/36OtekW/wcfsGtdAbZlDiIcIBSb3IbuPE75eTMUE6nlyx7GyKkFbAmVrx1p4dib8wG9A06juRUxweetegWU4STuoWqw9oUmcZZ1oBISyv9u5V9xskElBxHUf758WGN7SqSsNfBD7+e8avBS8e4GMDWyyKJuQOPseCN+9nm0q5YUbGUoX3uPo', '7GCKmMnyE9ND7Y5VTkL24qHh2KTy64uCae+l8m97R+fv8czh6i2/DnCmJ/8KqzglvA3Q9XyyQnAhXSeaBhTh88Tt/4o67wB03u+wU8xMzOIYYtnKKI1O/ppLQq8FGwL8', '2014-05-03 23:11:41', 0, 0, 0, '', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, 0),
(25, '120406305', '120406305', '6vdny01xZdvZkl0TFRv3QTjMyqqJLpBKW1gJlKqxXrKpn4xMsrkNDiqM5rAJu4XSXb8+oixksfvtCRRDj+5x5Q==', 'jm6QqfLegfzlGOOCzF4fH1TzPMjKQAp+D9n7YgUQQnjDTpQI7LEa36Kb2X+kfDQCXqh/7Mt++1Ia7g7X9afv02wO52kxEluI0CfUmFOe7E/i9QJwQYBbRS45jP16wh19yXxxu4e3RZVEwXMBU+BNtLx3CCtdYluwmI1bZQFZ9Xjymgy3HmpARajr0qfd965hYxiXhdfUz6ofYupjyLzjiw==', 'hBMvhDCZJPOE5Jo5Q2gUvYo19nheZOffCOuz8MRce5M7bG5ytNT7SMxHOQH19fN/BMPJimNP7138RrD9GQfDCqUJsGC7VRksF0p2th4Iwo0YLdN2XG2r3Dj+kmuI/+CR', '2014-05-03 23:18:29', 1, 0, 0, '', '0000-00-00 00:00:00', 1, '2014-05-29 00:08:40', 0, '0000-00-00 00:00:00', 0, 0),
(26, '120406305', '10000', '6vdny01xZdvZkl0TFRv3QTjMyqqJLpBKW1gJlKqxXrKpn4xMsrkNDiqM5rAJu4XSXb8+oixksfvtCRRDj+5x5Q==', 'jm6QqfLegfzlGOOCzF4fH1TzPMjKQAp+D9n7YgUQQnjDTpQI7LEa36Kb2X+kfDQCXqh/7Mt++1Ia7g7X9afv02wO52kxEluI0CfUmFOe7E/i9QJwQYBbRS45jP16wh19yXxxu4e3RZVEwXMBU+BNtLx3CCtdYluwmI1bZQFZ9Xjymgy3HmpARajr0qfd965hYxiXhdfUz6ofYupjyLzjiw==', 'hBMvhDCZJPOE5Jo5Q2gUvYo19nheZOffCOuz8MRce5M7bG5ytNT7SMxHOQH19fN/BMPJimNP7138RrD9GQfDCqUJsGC7VRksF0p2th4Iwo0YLdN2XG2r3Dj+kmuI/+CR', '2014-05-03 23:18:29', 0, 0, 0, '', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, 0),
(27, '120406305', '120406305', 'JjT4jwjanOACbFENVvKBp3Qob0Rtt3ndZweOQG6pjSlUpW0AiMHmV19OkgrD/+aks6Us9VOE/7ectZ/xzr3Drnk7Dg+ep0k4I9aPvB5skNVRCVjtxvHySe0sMhAAkmv7', 'e29oulCVyU7EHr51VLNa1JWkhR2Qleh5VmRkqTBdsFJCrNX6sVaweggY1RruPSn4jmNreA3zV1Nwv21GJfB04/EpuO0DgcqzAmxoDM+5kY20PIBM/HBWSEDXcOCSZOGY4726RBigKh69rclUmwhTyTddDrLLu1S7w9KVGVH4lGM=', 'Ntdi42VVhDg9Hnt+k7z3rKCBgvtMF7BbtU7XbixznuUKNRjafPJ0OR4oTsLBEfN+CV90AY7HL56OlF5VMvQT9UCgm2ToJ7sFdlqfUPpatW6tON7YfIluVU9+3BkpIURo', '2014-05-03 23:38:18', 0, 0, 0, '', '0000-00-00 00:00:00', 1, '2014-05-29 00:03:58', 0, '0000-00-00 00:00:00', 1, 0),
(28, '120406305', '130406301', 'yD+r6lRD1rXUzsTiiXpZBJyTNFJySd3iJhqPWadUr3F/jTn8rlL38IH4MY+OtUuRhjAoXpTnfqyzP4SoqI+9vw==', 'EpsWfts5238cyLT3LEVq1/UrryHwVSXLEQ9RYB04ZicPrfxMAt9OqLXJiku/dmXRkbdDOj89X1kaK0IEv/tP1+PmNjwAzrvZEqRGG3JL91ToFuQ3LbS2BM0t/6uQKnNaStaV7oHSXU9W5l8qhlB3KjZNbXWHzfjCDHb5u3vg7pxrF9J+3cRWMrEl5TlOI0oeestLKan7h75m55V76HeyKHLiLQ1Mnl6cs/ImNfDi5dt655425RG547uSDIcu0w2I', 'B4ylUIFsQpHJOsHaVVhc6mVTsr2+v0jJ/CQHY0j4pkn99tSQsrqLSFKv8a/vCMgFjX0wtauYdfyAPTk1dAA0GjLPBpv5mDpg3ELH2zRuyE3UPF+tc15bNIEmncgrMKQ2V3Y0JN2y1eisQaDXb/wBNhew9Jx2QTPGlR+WtsOOEls=', '2014-05-04 08:14:26', 0, 0, 0, '', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, 0),
(29, '130406301', '130406302', 'eCPdI/NL0eHvBjBYYzg9kPtLevp8fm1kSzTTe3sHfedbSK1ZKFM6ToOeU9qXtYn2dJ3Vd7m5N/gcrA4lD0dN1w==', '498jTW9iedqnXhNWpm5c2kJhzuPFvaL2b1fuPUC6/Sck9qjiGIkwjVREHHbbXk/Rda/Tw+5a3jL5bOEOvr1P2Tju1jSYGjkZP/xr5lA05XqPZD6wk+b26ZDr0QW3DIZsM6uV3zvPgxFTrnLCU45DYzfi6cPsk18lEg7NougPNhYIwm3EYtUO7FGkAdIjCTStejW6RVoQrXr3VsmkHnbjaGPkWAwMfEmB5pLQVn8XV91/um7CnBflvORdT9F0o1Hb', 'V0Ek+man36dxrTomPztJds4YSiM3Io5/iwNBxcjrbO4hQEw3eeecymvpYdpvjxCyNVq6tP+vWqbRldtBYowGZonrI42NQyIiob/8D9CklzyknUjaOax+7HQ0Ig6tq7RIoh7amsBkIVwYjeMKQs57MVH6azXHJlOzwBLJUi20mOw=', '2014-05-04 08:15:38', 0, 0, 0, '', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, 0),
(30, '130406301', '130406302', 'MvoES7Xu7Pi/Q5lCcCjzWhQffmhclxoSmpbzrw7AfHm1BfonPk38Rs2WxF5TLV/3/2GiHX4KjuoXOMMer1Lgmg==', 'WLcQnI14n8/64e6SWgwwpdRE4qqQ/GVUzgCe7ZsIjk0ZyXlpvOOXGdObUwqFbAvbmUTOrJ+zxkBzO0/qriw4v3DCoOAnLaBf7/OPGZaeb4GiKHyoBvjJxuxuH3+8y9IgTPPxfwsF4BCPrjR5y+mxk2bt2qIffPR2znDxWvCW18BGCQ1tF4oq3MNrMJkcqLdH6BTMAY+zK8Zn8ayJRiCH5w==', 'Gg0eQb3JOa918Ro1Lpp+KnmuKwQ6IFu8v5G7nPa7kmwpoPQ75/hwO8ir/4aaIetXtiObX7KFli84MZNdo7VSKlA/B0EHGZ2XuPfL2YiOdlLQ6jW/gY8F8pru5SF19yR95DykrhBliyiE8yLWHio/X07Z/oUjPDw2UOwXox/c6dE=', '2014-05-04 08:15:46', 0, 0, 0, '', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, 0),
(31, '130406301', '120406309', '0Yq1RzmhN8Lsk8AGkPGjkxOIz02KWFbZ5lUaIUqvFRsW1ZyY4qxTe3Ils5cF8ZuD+uaX5F6x++rF73ZfR47Q8Q==', 'qGCXo5du9d1thLI70ICyVyj85sVKly8pPAk3k1fiDJip9bmVDZ7VEpQqHK3ZzFLriXl0B+/aWNJ+lCJK4XjxNh8v6jODAninslgRARxt9EvH66ZjMeGfzmbmTP/32olFjxZ/fuVU1La416yTBfK4S2NSVy1LJ2dsG6mpOTPlld0=', 'njxpwZxqMYgK9J2+v3lCEeH+kLo3zQ2dsajRuaHHFXCUvAMX20cq7z6VsCi+JX1pONTJRo4eYQQ2hnwxc7XtD9V0T3yymfWSq47oAwuBtJZRLSBNNQQQ/X1mFpypPtWY', '2014-05-04 08:16:29', 0, 0, 0, '', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, 0),
(32, '130406301', '120406310', '0Yq1RzmhN8Lsk8AGkPGjkxOIz02KWFbZ5lUaIUqvFRsW1ZyY4qxTe3Ils5cF8ZuD+uaX5F6x++rF73ZfR47Q8Q==', 'qGCXo5du9d1thLI70ICyVyj85sVKly8pPAk3k1fiDJip9bmVDZ7VEpQqHK3ZzFLriXl0B+/aWNJ+lCJK4XjxNh8v6jODAninslgRARxt9EvH66ZjMeGfzmbmTP/32olFjxZ/fuVU1La416yTBfK4S2NSVy1LJ2dsG6mpOTPlld0=', 'njxpwZxqMYgK9J2+v3lCEeH+kLo3zQ2dsajRuaHHFXCUvAMX20cq7z6VsCi+JX1pONTJRo4eYQQ2hnwxc7XtD9V0T3yymfWSq47oAwuBtJZRLSBNNQQQ/X1mFpypPtWY', '2014-05-04 08:16:29', 0, 0, 0, '', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, 0),
(33, '130406301', '130406303', '0Yq1RzmhN8Lsk8AGkPGjkxOIz02KWFbZ5lUaIUqvFRsW1ZyY4qxTe3Ils5cF8ZuD+uaX5F6x++rF73ZfR47Q8Q==', 'qGCXo5du9d1thLI70ICyVyj85sVKly8pPAk3k1fiDJip9bmVDZ7VEpQqHK3ZzFLriXl0B+/aWNJ+lCJK4XjxNh8v6jODAninslgRARxt9EvH66ZjMeGfzmbmTP/32olFjxZ/fuVU1La416yTBfK4S2NSVy1LJ2dsG6mpOTPlld0=', 'njxpwZxqMYgK9J2+v3lCEeH+kLo3zQ2dsajRuaHHFXCUvAMX20cq7z6VsCi+JX1pONTJRo4eYQQ2hnwxc7XtD9V0T3yymfWSq47oAwuBtJZRLSBNNQQQ/X1mFpypPtWY', '2014-05-04 08:16:29', 0, 0, 0, '', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, 0),
(34, '130406301', '130406304', '0Yq1RzmhN8Lsk8AGkPGjkxOIz02KWFbZ5lUaIUqvFRsW1ZyY4qxTe3Ils5cF8ZuD+uaX5F6x++rF73ZfR47Q8Q==', 'qGCXo5du9d1thLI70ICyVyj85sVKly8pPAk3k1fiDJip9bmVDZ7VEpQqHK3ZzFLriXl0B+/aWNJ+lCJK4XjxNh8v6jODAninslgRARxt9EvH66ZjMeGfzmbmTP/32olFjxZ/fuVU1La416yTBfK4S2NSVy1LJ2dsG6mpOTPlld0=', 'njxpwZxqMYgK9J2+v3lCEeH+kLo3zQ2dsajRuaHHFXCUvAMX20cq7z6VsCi+JX1pONTJRo4eYQQ2hnwxc7XtD9V0T3yymfWSq47oAwuBtJZRLSBNNQQQ/X1mFpypPtWY', '2014-05-04 08:16:29', 0, 0, 0, '', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, 0),
(35, '120406305', '120406305', 'PK79xleX0zG6ztzH4c8lv/JHyNuJbh41P6a2tfV7dQg8G3ZmmUIxy/Oz9rCaTUHoJE5GZZG3fcUwHvKKuR2Qlg==', 'Q0DflgyTodV0Og3Tt6AufvebiWgJe9laIJ2fHZL5+z/aANeVtwY9ha0G2SNMdLFlCDEkl+nv4pHtWRokeA8+AA==', 'S2m1NS3VXyUA+5C7wLblezeBfenqG5muQVA5GGOdDajm+A9M1FrOleISanzVZl9lzjFVYm3QyIcBrdKX3by3J8JaKWQqLS3tpQaAlRF1xLmExptPrQGvBXqpnl3ShtiW', '2014-05-18 21:14:51', 1, 0, 0, '', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, 0),
(36, '120406305', '120406305', 'MASD12X9LpAJbIKEn/PAdHzHAparc21eAtwy601dH+z/H1Rmv8EqBViC5ftcTOTX/Hez2r6OGnntFcCHVD+Ujg==', 'hxuAqvPdLquxYYiyj3xnmRWwCtGUfAgp/sch0vlFM3B/+95hyn5j7chWNjdL/yu8gxlMCb5RN9X2dK0wIrQIsw==', 'qOewZCvyGBYF7vu4rzSiFnzJY3qfwpBIxNVhw+1mb9f7T0bS0JZ/giZn6uD7hhF/AKTjvRgov2RE5O7LvXxKkUR/nlN1pyUgtUVwY6dL6Vb/V2rE5IhJPCozElcBPvr/', '2014-05-18 21:24:52', 0, 0, 0, '', '0000-00-00 00:00:00', 1, '2014-05-29 00:04:01', 0, '0000-00-00 00:00:00', 1, 0),
(37, '120406305', '120406305', '8MmKg71rvRkpSLkYvQUyTLNKB5Nkuqdf3Bskp0nMjgD1OQ33HNP0jBm7YOxvWDgAK+sw8qY8qTT0xiTErQkg3g==', '+j/aqFhzJmLu67Fl+crib0UZbSjHXVpgJtIc+CkBaeUsdwOui8RgOlYhZizmGu35mZka0iiM2frBGlFJwVyWQrZF0POPv8V/myywLalk5DwpRTrx12E/Io6B3wCVj+JWR3WbfU0xY0+gFIXibHJjA8/vbZIHbhuLAS9kNHLM9eLtSok44COauPFlNAkFJchB1kAp2davcUbtJANS3Illow==', 'FqpvmbeQxp5xhIOezvcj9jaWRfexZcS0zJm+nabsFA+AWrqgIq8Zg1VLpxUrb14/TwyIov++Xzg0TWXl0qzgCBkzBSnNEsByhHAXJeoHn5skOwpoc3wAyRPyHOU0X4ka', '2014-05-24 23:18:50', 1, 0, 0, '', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, 0),
(38, '120406305', '10000', '8MmKg71rvRkpSLkYvQUyTLNKB5Nkuqdf3Bskp0nMjgD1OQ33HNP0jBm7YOxvWDgAK+sw8qY8qTT0xiTErQkg3g==', '+j/aqFhzJmLu67Fl+crib0UZbSjHXVpgJtIc+CkBaeUsdwOui8RgOlYhZizmGu35mZka0iiM2frBGlFJwVyWQrZF0POPv8V/myywLalk5DwpRTrx12E/Io6B3wCVj+JWR3WbfU0xY0+gFIXibHJjA8/vbZIHbhuLAS9kNHLM9eLtSok44COauPFlNAkFJchB1kAp2davcUbtJANS3Illow==', 'FqpvmbeQxp5xhIOezvcj9jaWRfexZcS0zJm+nabsFA+AWrqgIq8Zg1VLpxUrb14/TwyIov++Xzg0TWXl0qzgCBkzBSnNEsByhHAXJeoHn5skOwpoc3wAyRPyHOU0X4ka', '2014-05-24 23:18:50', 0, 0, 0, '', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, 0);

-- --------------------------------------------------------

--
-- 表的结构 `re_role_authorizee`
--

CREATE TABLE IF NOT EXISTS `re_role_authorizee` (
  `role_id` int(10) NOT NULL,
  `authorizee_id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `re_user_authorizee`
--

CREATE TABLE IF NOT EXISTS `re_user_authorizee` (
  `user_number` char(20) NOT NULL,
  `authorizee_id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户权限关联表';

-- --------------------------------------------------------

--
-- 表的结构 `re_user_role`
--

CREATE TABLE IF NOT EXISTS `re_user_role` (
  `user_number` char(20) NOT NULL,
  `role_id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `re_user_role`
--

INSERT INTO `re_user_role` (`user_number`, `role_id`) VALUES
('12040633333', 1),
('1204063056666', 1);

-- --------------------------------------------------------

--
-- 表的结构 `re_user_section`
--

CREATE TABLE IF NOT EXISTS `re_user_section` (
  `user_number` char(20) NOT NULL,
  `section_id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户部门关联表';

-- --------------------------------------------------------

--
-- 表的结构 `resources`
--

CREATE TABLE IF NOT EXISTS `resources` (
  `res_id` int(10) NOT NULL AUTO_INCREMENT,
  `res_name` varchar(100) NOT NULL,
  PRIMARY KEY (`res_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `role`
--

CREATE TABLE IF NOT EXISTS `role` (
  `role_id` int(10) NOT NULL AUTO_INCREMENT,
  `role_name` varchar(20) NOT NULL,
  `role_describe` varchar(100) NOT NULL,
  PRIMARY KEY (`role_id`),
  UNIQUE KEY `role_id` (`role_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf32 COMMENT='角色表' AUTO_INCREMENT=2 ;

--
-- 转存表中的数据 `role`
--

INSERT INTO `role` (`role_id`, `role_name`, `role_describe`) VALUES
(1, '管理员', '');

-- --------------------------------------------------------

--
-- 表的结构 `school_information`
--

CREATE TABLE IF NOT EXISTS `school_information` (
  `id` int(11) NOT NULL,
  `student_school` varchar(10) CHARACTER SET utf8 NOT NULL,
  `student_major` varchar(10) CHARACTER SET utf8 NOT NULL,
  `student_grade` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- 转存表中的数据 `school_information`
--

INSERT INTO `school_information` (`id`, `student_school`, `student_major`, `student_grade`) VALUES
(8010101, '机械工程学院', '机自', 8),
(8010102, '机械工程学院', '机自', 8),
(8010103, '机械工程学院', '机自', 8),
(8010104, '机械工程学院', '机自', 8),
(8010105, '机械工程学院', '机自', 8),
(8010106, '机械工程学院', '机自', 8),
(8010201, '机械工程学院', '工业工程', 8),
(8010202, '机械工程学院', '工业工程', 8),
(8010301, '机械工程学院', '工业设计', 8),
(8010302, '机械工程学院', '工业设计', 8),
(8010401, '机械工程学院', '车辆工程', 8),
(8010501, '机械工程学院', '物流工程', 8),
(8010601, '机械工程学院', '体育装备', 8),
(8020101, '材料科学与工程学院', '成型控制', 8),
(8020102, '材料科学与工程学院', '成型控制', 8),
(8020103, '材料科学与工程学院', '成型控制', 8),
(8020104, '材料科学与工程学院', '成型控制', 8),
(8020105, '材料科学与工程学院', '成型控制', 8),
(8020106, '材料科学与工程学院', '成型控制', 8),
(8020107, '材料科学与工程学院', '成型控制', 8),
(8020108, '材料科学与工程学院', '成型控制', 8),
(8020201, '材料科学与工程学院', '金属材料', 8),
(8020202, '材料科学与工程学院', '金属材料', 8),
(8020301, '材料科学与工程学院', '无机', 8),
(8020302, '材料科学与工程学院', '无机', 8),
(8030101, '电气工程学院', '电气工程', 8),
(8030102, '电气工程学院', '电气工程', 8),
(8030103, '电气工程学院', '电气工程', 8),
(8030104, '电气工程学院', '电气工程', 8),
(8030105, '电气工程学院', '电气工程', 8),
(8030106, '电气工程学院', '电气工程', 8),
(8030201, '电气工程学院', '自动化', 8),
(8030202, '电气工程学院', '自动化', 8),
(8030203, '电气工程学院', '自动化', 8),
(8030204, '电气工程学院', '自动化', 8),
(8030205, '电气工程学院', '自动化', 8),
(8030301, '电气工程学院', '生物医学', 8),
(8040101, '信息科学与工程学院', '测控技术', 8),
(8040102, '信息科学与工程学院', '测控技术', 8),
(8040103, '信息科学与工程学院', '测控技术', 8),
(8040104, '信息科学与工程学院', '测控技术', 8),
(8040201, '信息科学与工程学院', '电子信息', 8),
(8040202, '信息科学与工程学院', '电子信息', 8),
(8040203, '信息科学与工程学院', '电子信息', 8),
(8040204, '信息科学与工程学院', '电子信息', 8),
(8040301, '信息科学与工程学院', '电子科学', 8),
(8040302, '信息科学与工程学院', '电子科学', 8),
(8040401, '信息科学与工程学院', '通信工程', 8),
(8040402, '信息科学与工程学院', '通信工程', 8),
(8040403, '信息科学与工程学院', '通信工程', 8),
(8040501, '信息科学与工程学院', '计算机', 8),
(8040502, '信息科学与工程学院', '计算机', 8),
(8040503, '信息科学与工程学院', '计算机', 8),
(8040504, '信息科学与工程学院', '计算机', 8),
(8050101, '管理学院', '工程管理', 8),
(8050102, '管理学院', '工程管理', 8),
(8050201, '管理学院', '工商管理', 8),
(8050202, '管理学院', '工商管理', 8),
(8050301, '管理学院', '市场营销', 8),
(8050401, '管理学院', '会计学', 8),
(8050402, '管理学院', '会计学', 8),
(8050501, '管理学院', '物流管理', 8),
(8050502, '管理学院', '物流管理', 8),
(8050601, '管理学院', '电子商务', 8),
(8050602, '管理学院', '电子商务', 8),
(8060101, '文法学院', '法学', 8),
(8060102, '文法学院', '法学', 8),
(8060103, '文法学院', '法学', 8),
(8060104, '文法学院', '法学', 8),
(8060401, '文法学院', '广告学', 8),
(8060402, '文法学院', '广告学', 8),
(8060501, '文法学院', '艺术设计', 8),
(8060502, '文法学院', '艺术设计', 8),
(8070101, '理学院', '计算科学', 8),
(8070201, '理学院', '应用物理', 8),
(8070301, '理学院', '应用化学', 8),
(8070302, '理学院', '应用化学', 8),
(8070303, '理学院', '应用化学', 8),
(8070401, '理学院', '环境工程', 8),
(8070402, '理学院', '环境工程', 8),
(8070501, '理学院', '应用数学', 8),
(8080101, '建筑工程学院', '土木工程', 8),
(8080102, '建筑工程学院', '土木工程', 8),
(8080103, '建筑工程学院', '土木工程', 8),
(8080104, '建筑工程学院', '土木工程', 8),
(8080105, '建筑工程学院', '土木工程', 8),
(8080201, '建筑工程学院', '建筑学', 8),
(8080202, '建筑工程学院', '建筑学', 8),
(8080301, '建筑工程学院', '建筑设备', 8),
(8090101, '外语学院', '英语', 8),
(8090102, '外语学院', '英语', 8),
(8090103, '外语学院', '英语', 8),
(8090104, '外语学院', '英语', 8),
(8100101, '经济学院', '国际贸易', 8),
(8100102, '经济学院', '国际贸易', 8),
(8100103, '经济学院', '国际贸易', 8),
(8100201, '经济学院', '金融学', 8),
(8100202, '经济学院', '金融学', 8),
(8100203, '经济学院', '金融学', 8),
(8100301, '经济学院', '经济学', 8),
(8110101, '国际教育学院', '计算机', 8),
(8110201, '国际教育学院', '会计', 8),
(8110202, '国际教育学院', '会计', 8),
(8110203, '国际教育学院', '会计', 8),
(8110204, '国际教育学院', '会计', 8),
(8110301, '国际教育学院', '国贸', 8),
(8120101, '软件学院', '软件', 8),
(8120102, '软件学院', '软件', 8),
(8120103, '软件学院', '软件', 8),
(8120104, '软件学院', '软件', 8),
(8120105, '软件学院', '软件', 8),
(8120106, '软件学院', '软件', 8),
(8120301, '软件学院', '软件工程', 8),
(8120302, '软件学院', '软件工程', 8),
(9010101, '机械工程学院', '机自', 9),
(9010102, '机械工程学院', '机自', 9),
(9010103, '机械工程学院', '机自', 9),
(9010104, '机械工程学院', '机自', 9),
(9010105, '机械工程学院', '机自', 9),
(9010106, '机械工程学院', '机自', 9),
(9010201, '机械工程学院', '工业工程', 9),
(9010202, '机械工程学院', '工业工程', 9),
(9010301, '机械工程学院', '工业设计', 9),
(9010302, '机械工程学院', '工业设计', 9),
(9010401, '机械工程学院', '车辆工程', 9),
(9010501, '机械工程学院', '物流工程', 9),
(9010601, '机械工程学院', '体育装备', 9),
(9020101, '材料科学与工程学院', '成型控制', 9),
(9020102, '材料科学与工程学院', '成型控制', 9),
(9020103, '材料科学与工程学院', '成型控制', 9),
(9020104, '材料科学与工程学院', '成型控制', 9),
(9020105, '材料科学与工程学院', '成型控制', 9),
(9020106, '材料科学与工程学院', '成型控制', 9),
(9020107, '材料科学与工程学院', '成型控制', 9),
(9020108, '材料科学与工程学院', '成型控制', 9),
(9020201, '材料科学与工程学院', '金属材料', 9),
(9020202, '材料科学与工程学院', '金属材料', 9),
(9020301, '材料科学与工程学院', '无机', 9),
(9020302, '材料科学与工程学院', '无机', 9),
(9030101, '电气工程学院', '电气工程', 9),
(9030102, '电气工程学院', '电气工程', 9),
(9030103, '电气工程学院', '电气工程', 9),
(9030104, '电气工程学院', '电气工程', 9),
(9030105, '电气工程学院', '电气工程', 9),
(9030106, '电气工程学院', '电气工程', 9),
(9030201, '电气工程学院', '自动化', 9),
(9030202, '电气工程学院', '自动化', 9),
(9030203, '电气工程学院', '自动化', 9),
(9030204, '电气工程学院', '自动化', 9),
(9030205, '电气工程学院', '自动化', 9),
(9030301, '电气工程学院', '生物医学', 9),
(9040101, '信息科学与工程学院', '测控技术', 9),
(9040102, '信息科学与工程学院', '测控技术', 9),
(9040103, '信息科学与工程学院', '测控技术', 9),
(9040201, '信息科学与工程学院', '电子信息', 9),
(9040202, '信息科学与工程学院', '电子信息', 9),
(9040203, '信息科学与工程学院', '电子信息', 9),
(9040204, '信息科学与工程学院', '电子信息', 9),
(9040301, '信息科学与工程学院', '电子科学', 9),
(9040302, '信息科学与工程学院', '电子科学', 9),
(9040401, '信息科学与工程学院', '通信工程', 9),
(9040402, '信息科学与工程学院', '通信工程', 9),
(9040403, '信息科学与工程学院', '通信工程', 9),
(9040501, '信息科学与工程学院', '计算机', 9),
(9040502, '信息科学与工程学院', '计算机', 9),
(9040503, '信息科学与工程学院', '计算机', 9),
(9040504, '信息科学与工程学院', '计算机', 9),
(9050101, '管理学院', '工程管理', 9),
(9050102, '管理学院', '工程管理', 9),
(9050201, '管理学院', '工商管理', 9),
(9050202, '管理学院', '工商管理', 9),
(9050301, '管理学院', '市场营销', 9),
(9050302, '管理学院', '市场营销', 9),
(9050401, '管理学院', '会计学', 9),
(9050402, '管理学院', '会计学', 9),
(9050501, '管理学院', '物流管理', 9),
(9050502, '管理学院', '物流管理', 9),
(9050601, '管理学院', '电子商务', 9),
(9050602, '管理学院', '电子商务', 9),
(9060101, '文法学院', '法学', 9),
(9060102, '文法学院', '法学', 9),
(9060103, '文法学院', '法学', 9),
(9060104, '文法学院', '法学', 9),
(9060401, '文法学院', '广告学', 9),
(9060402, '文法学院', '广告学', 9),
(9060501, '文法学院', '艺术设计', 9),
(9060502, '文法学院', '艺术设计', 9),
(9070101, '理学院', '计算科学', 9),
(9070102, '理学院', '计算科学', 9),
(9070201, '理学院', '应用物理', 9),
(9070301, '理学院', '应用化学', 9),
(9070302, '理学院', '应用化学', 9),
(9070401, '理学院', '环境工程', 9),
(9070402, '理学院', '环境工程', 9),
(9070501, '理学院', '应用数学', 9),
(9080101, '建筑工程学院', '土木工程', 9),
(9080102, '建筑工程学院', '土木工程', 9),
(9080103, '建筑工程学院', '土木工程', 9),
(9080104, '建筑工程学院', '土木工程', 9),
(9080105, '建筑工程学院', '土木工程', 9),
(9080201, '建筑工程学院', '建筑学', 9),
(9080202, '建筑工程学院', '建筑学', 9),
(9080301, '建筑工程学院', '建筑设备', 9),
(9090101, '外语学院', '英语', 9),
(9090102, '外语学院', '英语', 9),
(9090103, '外语学院', '英语', 9),
(9090104, '外语学院', '英语', 9),
(9100101, '经济学院', '国际贸易', 9),
(9100102, '经济学院', '国际贸易', 9),
(9100103, '经济学院', '国际贸易', 9),
(9100201, '经济学院', '金融学', 9),
(9100202, '经济学院', '金融学', 9),
(9100203, '经济学院', '金融学', 9),
(9100301, '经济学院', '经济学', 9),
(9110201, '国际教育学院', '会计', 9),
(9110202, '国际教育学院', '会计', 9),
(9110203, '国际教育学院', '会计', 9),
(9110301, '国际教育学院', '国贸', 9),
(9120101, '软件学院', '软件', 9),
(9120102, '软件学院', '软件', 9),
(9120103, '软件学院', '软件', 9),
(9120104, '软件学院', '软件', 9),
(9120105, '软件学院', '软件', 9),
(9120106, '软件学院', '软件', 9),
(9120301, '软件学院', '软件工程', 9),
(9120302, '软件学院', '软件工程', 9),
(1001011, '机械工程学院', '机自', 10),
(1001012, '机械工程学院', '机自', 10),
(1001013, '机械工程学院', '机自', 10),
(1001014, '机械工程学院', '机自', 10),
(1001015, '机械工程学院', '机自', 10),
(1001016, '机械工程学院', '机自', 10),
(1001021, '机械工程学院', '工业工程', 10),
(1001022, '机械工程学院', '工业工程', 10),
(1001031, '机械工程学院', '工业设计', 10),
(1001032, '机械工程学院', '工业设计', 10),
(1001041, '机械工程学院', '车辆工程', 10),
(1001042, '机械工程学院', '车辆工程', 10),
(1001051, '机械工程学院', '物流工程', 10),
(1001061, '机械工程学院', '体育装备', 10),
(1002011, '材料科学与工程学院', '成型控制', 10),
(1002012, '材料科学与工程学院', '成型控制', 10),
(1002013, '材料科学与工程学院', '成型控制', 10),
(1002014, '材料科学与工程学院', '成型控制', 10),
(1002015, '材料科学与工程学院', '成型控制', 10),
(1002016, '材料科学与工程学院', '成型控制', 10),
(1002021, '材料科学与工程学院', '金属材料', 10),
(1002022, '材料科学与工程学院', '金属材料', 10),
(1002031, '材料科学与工程学院', '无机', 10),
(1002032, '材料科学与工程学院', '无机', 10),
(1003011, '电气工程学院', '电气工程', 10),
(1003012, '电气工程学院', '电气工程', 10),
(1003013, '电气工程学院', '电气工程', 10),
(1003014, '电气工程学院', '电气工程', 10),
(1003015, '电气工程学院', '电气工程', 10),
(1003016, '电气工程学院', '电气工程', 10),
(1003021, '电气工程学院', '自动化', 10),
(1003022, '电气工程学院', '自动化', 10),
(1003023, '电气工程学院', '自动化', 10),
(1003024, '电气工程学院', '自动化', 10),
(1003025, '电气工程学院', '自动化', 10),
(1003026, '电气工程学院', '自动化', 10),
(1003031, '电气工程学院', '生物医学', 10),
(1004011, '信息科学与工程学院', '测控技术', 10),
(1004012, '信息科学与工程学院', '测控技术', 10),
(1004013, '信息科学与工程学院', '测控技术', 10),
(1004014, '信息科学与工程学院', '测控技术', 10),
(1004021, '信息科学与工程学院', '电子信息', 10),
(1004022, '信息科学与工程学院', '电子信息', 10),
(1004023, '信息科学与工程学院', '电子信息', 10),
(1004031, '信息科学与工程学院', '电子科学', 10),
(1004032, '信息科学与工程学院', '电子科学', 10),
(1004041, '信息科学与工程学院', '通信工程', 10),
(1004042, '信息科学与工程学院', '通信工程', 10),
(1004043, '信息科学与工程学院', '通信工程', 10),
(1004051, '信息科学与工程学院', '计算机', 10),
(1004052, '信息科学与工程学院', '计算机', 10),
(1004053, '信息科学与工程学院', '计算机', 10),
(1004054, '信息科学与工程学院', '计算机', 10),
(1005011, '管理学院', '工程管理', 10),
(1005012, '管理学院', '工程管理', 10),
(1005021, '管理学院', '工商管理', 10),
(1005022, '管理学院', '工商管理', 10),
(1005031, '管理学院', '市场营销', 10),
(1005032, '管理学院', '市场营销', 10),
(1005041, '管理学院', '会计学', 10),
(1005042, '管理学院', '会计学', 10),
(1005051, '管理学院', '物流管理', 10),
(1005052, '管理学院', '物流管理', 10),
(1005061, '管理学院', '电子商务', 10),
(1006011, '文法学院', '法学', 10),
(1006012, '文法学院', '法学', 10),
(1006013, '文法学院', '法学', 10),
(1006041, '文法学院', '广告学', 10),
(1006042, '文法学院', '广告学', 10),
(1006051, '文法学院', '艺术设计', 10),
(1006052, '文法学院', '艺术设计', 10),
(1007011, '理学院', '计算科学', 10),
(1007012, '理学院', '计算科学', 10),
(1007021, '理学院', '应用物理', 10),
(1007031, '理学院', '应用化学', 10),
(1007032, '理学院', '应用化学', 10),
(1007033, '理学院', '应用化学', 10),
(1007041, '理学院', '环境工程', 10),
(1007042, '理学院', '环境工程', 10),
(1007051, '理学院', '应用数学', 10),
(1008011, '建筑工程学院', '土木工程', 10),
(1008012, '建筑工程学院', '土木工程', 10),
(1008013, '建筑工程学院', '土木工程', 10),
(1008014, '建筑工程学院', '土木工程', 10),
(1008015, '建筑工程学院', '土木工程', 10),
(1008016, '建筑工程学院', '土木工程', 10),
(1008021, '建筑工程学院', '建筑学', 10),
(1008022, '建筑工程学院', '建筑学', 10),
(1008031, '建筑工程学院', '建筑设备', 10),
(1008032, '建筑工程学院', '建筑设备', 10),
(1009011, '外语学院', '英语', 10),
(1009012, '外语学院', '英语', 10),
(1009013, '外语学院', '英语', 10),
(1009014, '外语学院', '英语', 10),
(1009021, '外语学院', '日语', 10),
(1010011, '经济学院', '国际贸易', 10),
(1010012, '经济学院', '国际贸易', 10),
(1010013, '经济学院', '国际贸易', 10),
(1010021, '经济学院', '金融学', 10),
(1010022, '经济学院', '金融学', 10),
(1010023, '经济学院', '金融学', 10),
(1010031, '经济学院', '经济学', 10),
(1011021, '国际教育学院', '会计', 10),
(1011022, '国际教育学院', '会计', 10),
(1011031, '国际教育学院', '国贸', 10),
(1012011, '软件学院', '软件', 10),
(1012012, '软件学院', '软件', 10),
(1012013, '软件学院', '软件', 10),
(1012014, '软件学院', '软件', 10),
(1012015, '软件学院', '软件', 10),
(1012016, '软件学院', '软件', 10),
(1012031, '软件学院', '软件工程', 10),
(1012032, '软件学院', '软件工程', 10),
(1012033, '软件学院', '软件工程', 10),
(1015011, '新能源工程学院', '风能', 10),
(1015012, '新能源工程学院', '风能', 10),
(1101011, '机械工程学院', '机自', 11),
(1101012, '机械工程学院', '机自', 11),
(1101013, '机械工程学院', '机自', 11),
(1101014, '机械工程学院', '机自', 11),
(1101015, '机械工程学院', '机自', 11),
(1101016, '机械工程学院', '机自', 11),
(1101021, '机械工程学院', '工业工程', 11),
(1101022, '机械工程学院', '工业工程', 11),
(1101031, '机械工程学院', '工业设计', 11),
(1101041, '机械工程学院', '车辆工程', 11),
(1101042, '机械工程学院', '车辆工程', 11),
(1101043, '机械工程学院', '车辆工程', 11),
(1101051, '机械工程学院', '物流工程', 11),
(1101077, '机械工程学院', '机自', 11),
(1101078, '机械工程学院', '机自', 11),
(1102011, '材料科学与工程学院', '成型控制', 11),
(1102012, '材料科学与工程学院', '成型控制', 11),
(1102013, '材料科学与工程学院', '成型控制', 11),
(1102014, '材料科学与工程学院', '成型控制', 11),
(1102015, '材料科学与工程学院', '成型控制', 11),
(1102016, '材料科学与工程学院', '成型控制', 11),
(1102021, '材料科学与工程学院', '金属材料', 11),
(1102022, '材料科学与工程学院', '金属材料', 11),
(1102031, '材料科学与工程学院', '无机', 11),
(1102032, '材料科学与工程学院', '无机', 11),
(1102041, '材料科学与工程学院', '焊接', 11),
(1103011, '电气工程学院', '电气工程', 11),
(1103012, '电气工程学院', '电气工程', 11),
(1103013, '电气工程学院', '电气工程', 11),
(1103014, '电气工程学院', '电气工程', 11),
(1103015, '电气工程学院', '电气工程', 11),
(1103016, '电气工程学院', '电气工程', 11),
(1103017, '电气工程学院', '电气工程', 11),
(1103018, '电气工程学院', '电气工程', 11),
(1103021, '电气工程学院', '自动化', 11),
(1103022, '电气工程学院', '自动化', 11),
(1103023, '电气工程学院', '自动化', 11),
(1103024, '电气工程学院', '自动化', 11),
(1103025, '电气工程学院', '自动化', 11),
(1103026, '电气工程学院', '自动化', 11),
(1103031, '电气工程学院', '生物医学', 11),
(1104011, '信息科学与工程学院', '测控技术', 11),
(1104012, '信息科学与工程学院', '测控技术', 11),
(1104013, '信息科学与工程学院', '测控技术', 11),
(1104014, '信息科学与工程学院', '测控技术', 11),
(1104021, '信息科学与工程学院', '电子信息', 11),
(1104022, '信息科学与工程学院', '电子信息', 11),
(1104023, '信息科学与工程学院', '电子信息', 11),
(1104031, '信息科学与工程学院', '电子科学', 11),
(1104032, '信息科学与工程学院', '电子科学', 11),
(1104041, '信息科学与工程学院', '通信工程', 11),
(1104042, '信息科学与工程学院', '通信工程', 11),
(1104043, '信息科学与工程学院', '通信工程', 11),
(1104051, '信息科学与工程学院', '计算机', 11),
(1104052, '信息科学与工程学院', '计算机', 11),
(1104053, '信息科学与工程学院', '计算机', 11),
(1104071, '信息科学与工程学院', '智能科学', 11),
(1105011, '管理学院', '工程管理', 11),
(1105012, '管理学院', '工程管理', 11),
(1105021, '管理学院', '工商管理', 11),
(1105022, '管理学院', '工商管理', 11),
(1105031, '管理学院', '市场营销', 11),
(1105032, '管理学院', '市场营销', 11),
(1105041, '管理学院', '会计学', 11),
(1105042, '管理学院', '会计学', 11),
(1105043, '管理学院', '会计学', 11),
(1105051, '管理学院', '物流管理', 11),
(1105052, '管理学院', '物流管理', 11),
(1105061, '管理学院', '电子商务', 11),
(1106011, '文法学院', '法学', 11),
(1106012, '文法学院', '法学', 11),
(1106041, '文法学院', '广告学', 11),
(1106042, '文法学院', '广告学', 11),
(1106051, '文法学院', '艺术设计', 11),
(1106052, '文法学院', '艺术设计', 11),
(1106053, '文法学院', '艺术设计', 11),
(1107011, '理学院', '计算科学', 11),
(1107012, '理学院', '计算科学', 11),
(1107021, '理学院', '应用物理', 11),
(1107031, '理学院', '应用化学', 11),
(1107032, '理学院', '应用化学', 11),
(1107041, '理学院', '环境工程', 11),
(1107042, '理学院', '环境工程', 11),
(1107051, '理学院', '应用数学', 11),
(1107061, '理学院', '功能材料', 11),
(1108011, '建筑工程学院', '土木工程', 11),
(1108012, '建筑工程学院', '土木工程', 11),
(1108013, '建筑工程学院', '土木工程', 11),
(1108014, '建筑工程学院', '土木工程', 11),
(1108015, '建筑工程学院', '土木工程', 11),
(1108016, '建筑工程学院', '土木工程', 11),
(1108021, '建筑工程学院', '建筑学', 11),
(1108022, '建筑工程学院', '建筑学', 11),
(1108031, '建筑工程学院', '建筑设备', 11),
(1108032, '建筑工程学院', '建筑设备', 11),
(1109011, '外语学院', '英语', 11),
(1109012, '外语学院', '英语', 11),
(1109021, '外语学院', '日语', 11),
(1110011, '经济学院', '国际贸易', 11),
(1110012, '经济学院', '国际贸易', 11),
(1110021, '经济学院', '金融学', 11),
(1110022, '经济学院', '金融学', 11),
(1110031, '经济学院', '经济学', 11),
(1110032, '经济学院', '经济学', 11),
(1111021, '国际教育学院', '会计（', 11),
(1111022, '国际教育学院', '会计（', 11),
(1112011, '软件学院', '软件', 11),
(1112012, '软件学院', '软件', 11),
(1112013, '软件学院', '软件', 11),
(1112014, '软件学院', '软件', 11),
(1112015, '软件学院', '软件', 11),
(1112031, '软件学院', '软件工程', 11),
(1112032, '软件学院', '软件工程', 11),
(1112033, '软件学院', '软件工程', 11),
(1115011, '新能源工程学院', '风能', 11),
(1115012, '新能源工程学院', '风能', 11),
(1201011, '机械工程学院', '机自', 12),
(1201012, '机械工程学院', '机自', 12),
(1201013, '机械工程学院', '机自', 12),
(1201014, '机械工程学院', '机自', 12),
(1201015, '机械工程学院', '机自', 12),
(1201016, '机械工程学院', '机自', 12),
(1201017, '机械工程学院', '机自', 12),
(1201021, '机械工程学院', '工业工程', 12),
(1201022, '机械工程学院', '工业工程', 12),
(1201031, '机械工程学院', '工业设计', 12),
(1201041, '机械工程学院', '车辆工程', 12),
(1201042, '机械工程学院', '车辆工程', 12),
(1201043, '机械工程学院', '车辆工程', 12),
(1201051, '机械工程学院', '物流工程', 12),
(1201077, '机械工程学院', '机自', 12),
(1201079, '机械工程学院', '机自', 12),
(1202011, '材料科学与工程学院', '成型控制', 12),
(1202012, '材料科学与工程学院', '成型控制', 12),
(1202013, '材料科学与工程学院', '成型控制', 12),
(1202014, '材料科学与工程学院', '成型控制', 12),
(1202021, '材料科学与工程学院', '金属材料', 12),
(1202022, '材料科学与工程学院', '金属材料', 12),
(1202031, '材料科学与工程学院', '无机', 12),
(1202032, '材料科学与工程学院', '无机', 12),
(1202041, '材料科学与工程学院', '焊接', 12),
(1202042, '材料科学与工程学院', '焊接', 12),
(1203011, '电气工程学院', '电气工程', 12),
(1203012, '电气工程学院', '电气工程', 12),
(1203013, '电气工程学院', '电气工程', 12),
(1203014, '电气工程学院', '电气工程', 12),
(1203015, '电气工程学院', '电气工程', 12),
(1203016, '电气工程学院', '电气工程', 12),
(1203017, '电气工程学院', '电气工程', 12),
(1203018, '电气工程学院', '电气工程', 12),
(1203021, '电气工程学院', '自动化', 12),
(1203022, '电气工程学院', '自动化', 12),
(1203023, '电气工程学院', '自动化', 12),
(1203024, '电气工程学院', '自动化', 12),
(1203025, '电气工程学院', '自动化', 12),
(1203026, '电气工程学院', '自动化', 12),
(1203031, '电气工程学院', '生物医学', 12),
(1203032, '电气工程学院', '生物医学', 12),
(1204011, '信息科学与工程学院', '测控技术', 12),
(1204012, '信息科学与工程学院', '测控技术', 12),
(1204013, '信息科学与工程学院', '测控技术', 12),
(1204014, '信息科学与工程学院', '测控技术', 12),
(1204021, '信息科学与工程学院', '电子信息', 12),
(1204022, '信息科学与工程学院', '电子信息', 12),
(1204023, '信息科学与工程学院', '电子信息', 12),
(1204031, '信息科学与工程学院', '电子科学', 12),
(1204032, '信息科学与工程学院', '电子科学', 12),
(1204041, '信息科学与工程学院', '通信工程', 12),
(1204042, '信息科学与工程学院', '通信工程', 12),
(1204043, '信息科学与工程学院', '通信工程', 12),
(1204051, '信息科学与工程学院', '计算机', 12),
(1204052, '信息科学与工程学院', '计算机', 12),
(1204063, '信息科学与工程学院', '计算机', 12),
(1204071, '信息科学与工程学院', '智能科学', 12),
(1205011, '管理学院', '工程管理', 12),
(1205012, '管理学院', '工程管理', 12),
(1205021, '管理学院', '工商管理', 12),
(1205022, '管理学院', '工商管理', 12),
(1205031, '管理学院', '市场营销', 12),
(1205032, '管理学院', '市场营销', 12),
(1205041, '管理学院', '会计学', 12),
(1205042, '管理学院', '会计学', 12),
(1205051, '管理学院', '物流管理', 12),
(1205052, '管理学院', '物流管理', 12),
(1205061, '管理学院', '电子商务', 12),
(1205062, '管理学院', '电子商务', 12),
(1206011, '文法学院', '法学', 12),
(1206012, '文法学院', '法学', 12),
(1206041, '文法学院', '广告学', 12),
(1206042, '文法学院', '广告学', 12),
(1206051, '文法学院', '艺术设计', 12),
(1206052, '文法学院', '艺术设计', 12),
(1206053, '文法学院', '艺术设计', 12),
(1207011, '理学院', '计算科学', 12),
(1207012, '理学院', '计算科学', 12),
(1207021, '理学院', '应用物理', 12),
(1207031, '理学院', '应用化学', 12),
(1207032, '理学院', '应用化学', 12),
(1207041, '理学院', '环境工程', 12),
(1207042, '理学院', '环境工程', 12),
(1207051, '理学院', '应用数学', 12),
(1207061, '理学院', '功能材料', 12),
(1208011, '建筑工程学院', '土木工程', 12),
(1208012, '建筑工程学院', '土木工程', 12),
(1208013, '建筑工程学院', '土木工程', 12),
(1208014, '建筑工程学院', '土木工程', 12),
(1208015, '建筑工程学院', '土木工程', 12),
(1208016, '建筑工程学院', '土木工程', 12),
(1208021, '建筑工程学院', '建筑学', 12),
(1208022, '建筑工程学院', '建筑学', 12),
(1208031, '建筑工程学院', '建筑设备', 12),
(1208032, '建筑工程学院', '建筑设备', 12),
(1209011, '外语学院', '英语', 12),
(1209012, '外语学院', '英语', 12),
(1209021, '外语学院', '日语', 12),
(1209022, '外语学院', '日语', 12),
(1210011, '经济学院', '国际贸易', 12),
(1210012, '经济学院', '国际贸易', 12),
(1210021, '经济学院', '金融学', 12),
(1210022, '经济学院', '金融学', 12),
(1210023, '经济学院', '金融学', 12),
(1210031, '经济学院', '经济学', 12),
(1210032, '经济学院', '经济学', 12),
(1211021, '国际教育学院', '会计', 12),
(1211022, '国际教育学院', '会计', 12),
(1211031, '国际教育学院', '国贸', 12),
(1211032, '国际教育学院', '国贸', 12),
(1212011, '软件学院', '软件', 12),
(1212012, '软件学院', '软件', 12),
(1212013, '软件学院', '软件', 12),
(1212014, '软件学院', '软件', 12),
(1212031, '软件学院', '软件工程', 12),
(1212032, '软件学院', '软件工程', 12),
(1212033, '软件学院', '软件工程', 12),
(1212034, '软件学院', '软件工程', 12),
(1215011, '新能源工程学院', '风能', 12),
(1215012, '新能源工程学院', '风能', 12),
(1301011, '机械工程学院', '机自', 13),
(1301012, '机械工程学院', '机自', 13),
(1301013, '机械工程学院', '机自', 13),
(1301014, '机械工程学院', '机自', 13),
(1301015, '机械工程学院', '机自', 13),
(1301016, '机械工程学院', '机自', 13),
(1301017, '机械工程学院', '机自', 13),
(1301018, '机械工程学院', '机自', 13),
(1301019, '机械工程学院', '机自', 13),
(1301021, '机械工程学院', '工业工程', 13),
(1301022, '机械工程学院', '工业工程', 13),
(1301031, '机械工程学院', '工业设计', 13),
(1301041, '机械工程学院', '车辆工程', 13),
(1301042, '机械工程学院', '车辆工程', 13),
(1301043, '机械工程学院', '车辆工程', 13),
(1301051, '机械工程学院', '物流工程', 13),
(1302001, '材料科学与工程学院', '材料', 13),
(1302002, '材料科学与工程学院', '材料', 13),
(1302003, '材料科学与工程学院', '材料', 13),
(1302004, '材料科学与工程学院', '材料', 13),
(1302005, '材料科学与工程学院', '材料', 13),
(1302006, '材料科学与工程学院', '材料', 13),
(1302007, '材料科学与工程学院', '材料', 13),
(1302008, '材料科学与工程学院', '材料', 13),
(1302009, '材料科学与工程学院', '材料', 13),
(1302010, '材料科学与工程学院', '材料', 13),
(1303011, '电气工程学院', '电气工程', 13),
(1303012, '电气工程学院', '电气工程', 13),
(1303013, '电气工程学院', '电气工程', 13),
(1303014, '电气工程学院', '电气工程', 13),
(1303015, '电气工程学院', '电气工程', 13),
(1303016, '电气工程学院', '电气工程', 13),
(1303017, '电气工程学院', '电气工程', 13),
(1303018, '电气工程学院', '电气工程', 13),
(1303021, '电气工程学院', '自动化', 13),
(1303022, '电气工程学院', '自动化', 13),
(1303023, '电气工程学院', '自动化', 13),
(1303024, '电气工程学院', '自动化', 13),
(1303025, '电气工程学院', '自动化', 13),
(1303026, '电气工程学院', '自动化', 13),
(1303031, '电气工程学院', '生物医学', 13),
(1303032, '电气工程学院', '生物医学', 13),
(1304011, '信息科学与工程学院', '测控技术', 13),
(1304012, '信息科学与工程学院', '测控技术', 13),
(1304013, '信息科学与工程学院', '测控技术', 13),
(1304014, '信息科学与工程学院', '测控技术', 13),
(1304021, '信息科学与工程学院', '电子信息', 13),
(1304022, '信息科学与工程学院', '电子信息', 13),
(1304023, '信息科学与工程学院', '电子信息', 13),
(1304031, '信息科学与工程学院', '电子科学', 13),
(1304032, '信息科学与工程学院', '电子科学', 13),
(1304041, '信息科学与工程学院', '通信工程', 13),
(1304042, '信息科学与工程学院', '通信工程', 13),
(1304043, '信息科学与工程学院', '通信工程', 13),
(1304051, '信息科学与工程学院', '计算机', 13),
(1304052, '信息科学与工程学院', '计算机', 13),
(1304053, '信息科学与工程学院', '计算机', 13),
(1304071, '信息科学与工程学院', '智能科学', 13),
(1305011, '管理学院', '工程管理', 13),
(1305012, '管理学院', '工程管理', 13),
(1305021, '管理学院', '工商管理', 13),
(1305022, '管理学院', '工商管理', 13),
(1305031, '管理学院', '市场营销', 13),
(1305032, '管理学院', '市场营销', 13),
(1305041, '管理学院', '会计学', 13),
(1305042, '管理学院', '会计学', 13),
(1305051, '管理学院', '物流管理', 13),
(1305052, '管理学院', '物流管理', 13),
(1305061, '管理学院', '电子商务', 13),
(1305062, '管理学院', '电子商务', 13),
(1306011, '文法学院', '法学', 13),
(1306012, '文法学院', '法学', 13),
(1306041, '文法学院', '广告学', 13),
(1306042, '文法学院', '广告学', 13),
(1306061, '文法学院', '视觉传达', 13),
(1306062, '文法学院', '视觉传达', 13),
(1306071, '文法学院', '环境设计', 13),
(1306072, '文法学院', '环境设计', 13),
(1307011, '理学院', '计算科学', 13),
(1307012, '理学院', '计算科学', 13),
(1307021, '理学院', '应用物理', 13),
(1307031, '理学院', '应用化学', 13),
(1307032, '理学院', '应用化学', 13),
(1307041, '理学院', '环境工程', 13),
(1307042, '理学院', '环境工程', 13),
(1307051, '理学院', '应用数学', 13),
(1307061, '理学院', '功能材料', 13),
(1308011, '建筑工程学院', '土木工程', 13),
(1308012, '建筑工程学院', '土木工程', 13),
(1308013, '建筑工程学院', '土木工程', 13),
(1308014, '建筑工程学院', '土木工程', 13),
(1308015, '建筑工程学院', '土木工程', 13),
(1308016, '建筑工程学院', '土木工程', 13),
(1308021, '建筑工程学院', '建筑学', 13),
(1308022, '建筑工程学院', '建筑学', 13),
(1308041, '建筑工程学院', '建筑能源', 13),
(1308042, '建筑工程学院', '建筑能源', 13),
(1309011, '外语学院', '英语', 13),
(1309012, '外语学院', '英语', 13),
(1309021, '外语学院', '日语', 13),
(1309022, '外语学院', '日语', 13),
(1310011, '经济学院', '国际贸易', 13),
(1310012, '经济学院', '国际贸易', 13),
(1310021, '经济学院', '金融学', 13),
(1310022, '经济学院', '金融学', 13),
(1310023, '经济学院', '金融学', 13),
(1310031, '经济学院', '经济学', 13),
(1310032, '经济学院', '经济学', 13),
(1310041, '经济学院', '金融工程', 13),
(1311021, '国际教育学院', '会计', 13),
(1311022, '国际教育学院', '会计', 13),
(1311031, '国际教育学院', '国贸', 13),
(1311032, '国际教育学院', '国贸', 13),
(1312011, '软件学院', '软件', 13),
(1312012, '软件学院', '软件', 13),
(1312013, '软件学院', '软件', 13),
(1312014, '软件学院', '软件', 13),
(1312031, '软件学院', '软件工程', 13),
(1312032, '软件学院', '软件工程', 13),
(1312033, '软件学院', '软件工程', 13),
(1312034, '软件学院', '软件工程', 13),
(1315021, '新能源工程学院', '能源科学', 13),
(1315022, '新能源工程学院', '能源科学', 13);

-- --------------------------------------------------------

--
-- 表的结构 `section`
--

CREATE TABLE IF NOT EXISTS `section` (
  `section_id` int(10) NOT NULL AUTO_INCREMENT COMMENT '部门id',
  `section_name` varchar(30) NOT NULL,
  `section_describe` varchar(100) NOT NULL,
  PRIMARY KEY (`section_id`),
  UNIQUE KEY `section_id` (`section_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='部门表' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `sessions`
--

CREATE TABLE IF NOT EXISTS `sessions` (
  `session_id` varchar(32) NOT NULL,
  `session_last_access` int(10) unsigned DEFAULT NULL,
  `session_data` text,
  PRIMARY KEY (`session_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `sessions`
--

INSERT INTO `sessions` (`session_id`, `session_last_access`, `session_data`) VALUES
('0g55pfsgcm25gpj44cko9ijnq1', 1400653661, 'sess_last_access|i:1400653661;sess_ip_address|s:11:"10.16.2.157";sess_useragent|s:50:"Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.1;";sess_last_regenerated|i:1400653613;retry|i:3;user_id|s:1:"1";user_number|s:9:"120406305";user_name|s:9:"æž—æ˜Ÿè¾°";user_section|s:9:"å·¥ç¨‹éƒ¨";user_telephone|s:11:"13940022196";user_qq|s:9:"506200331";authorizee|s:1:"0";joined_act_sum|s:1:"0";'),
('0v3tjm3cc4rgmhprd7f48ebev5', 1404269935, 'sess_last_access|i:1404269935;sess_ip_address|s:12:"10.16.20.217";sess_useragent|s:50:"Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36";sess_last_regenerated|i:1404269920;retry|i:5;user_id|s:1:"1";user_number|s:9:"120406305";user_name|s:15:"æ¼”ç¤ºç”¨æˆ·å";user_section|s:9:"å·¥ç¨‹éƒ¨";user_telephone|s:11:"13940022196";user_qq|s:9:"506200331";authorizee|s:1:"0";joined_act_sum|s:1:"0";'),
('10693a7cm6tq375torvv15lqt7', 1401291550, 'sess_last_access|i:1401291550;sess_ip_address|s:14:"101.226.66.176";sess_useragent|s:50:"Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/53";sess_last_regenerated|i:1401291550;retry|i:1;'),
('10eh6j03hed3mllqbv2r9htoi4', 1401471129, 'sess_last_access|i:1401471129;sess_ip_address|s:15:"222.161.199.186";sess_useragent|s:50:"Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36";sess_last_regenerated|i:1401471033;retry|i:8;user_id|s:1:"1";user_number|s:9:"120406305";user_name|s:15:"æ¼”ç¤ºç”¨æˆ·å";user_section|s:9:"å·¥ç¨‹éƒ¨";user_telephone|s:11:"13940022196";user_qq|s:9:"506200331";authorizee|s:1:"0";joined_act_sum|s:1:"0";'),
('13l1pih4ht5266u5q7i8qiuhn0', 1400236702, 'sess_last_access|i:1400236702;sess_ip_address|s:15:"113.225.195.132";sess_useragent|s:50:"Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36";sess_last_regenerated|i:1400236644;retry|i:3;user_id|s:1:"1";user_number|s:9:"120406305";user_name|s:9:"æž—æ˜Ÿè¾°";user_section|s:9:"å·¥ç¨‹éƒ¨";user_telephone|s:11:"13940022196";user_qq|s:9:"506200331";authorizee|s:1:"0";joined_act_sum|s:1:"0";'),
('17764spnte6184pbkes2rqrju3', 1404156397, 'sess_last_access|i:1404156397;sess_ip_address|s:13:"66.249.69.116";sess_useragent|s:50:"Mozilla/5.0 (compatible; Googlebot/2.1; +http://ww";sess_last_regenerated|i:1404156397;retry|i:1;'),
('1f3j4t3bi70crlcgbl96bdsmp3', 1400418850, 'sess_last_access|i:1400418850;sess_ip_address|s:15:"119.147.146.193";sess_useragent|s:50:"Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1;";sess_last_regenerated|i:1400418850;'),
('1tiqran5aqhgfs7odi7v15trn0', 1404185587, 'sess_last_access|i:1404185587;sess_ip_address|s:13:"66.249.69.132";sess_useragent|s:50:"Mozilla/5.0 (compatible; Googlebot/2.1; +http://ww";sess_last_regenerated|i:1404185587;retry|i:1;'),
('2avv6vta4n9tghmdkf75kr67g2', 1403934262, 'sess_last_access|i:1403934262;sess_ip_address|s:14:"101.226.33.239";sess_useragent|s:11:"Mozilla/4.0";sess_last_regenerated|i:1403934262;retry|i:1;'),
('2itv5g24emlva41mnc571d01f4', 1405749653, 'sess_last_access|i:1405749653;sess_ip_address|s:13:"66.249.66.103";sess_useragent|s:50:"Mozilla/5.0 (compatible; Googlebot/2.1; +http://ww";sess_last_regenerated|i:1405749653;retry|i:1;'),
('2u6n8qb67a78ofdvggae32hu57', 1405858954, 'sess_last_access|i:1405858954;sess_ip_address|s:15:"119.147.146.189";sess_useragent|s:50:"Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1;";sess_last_regenerated|i:1405858954;retry|i:1;'),
('312h069g63nkihsf9jbohh5pi7', 1399217480, 'sess_last_access|i:1399217480;sess_ip_address|s:14:"120.201.105.13";sess_useragent|s:50:"Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36";sess_last_regenerated|i:1399217479;retry|i:2;'),
('3gdk910e082buusguu0gm1dsg4', 1401467645, 'sess_last_access|i:1401467645;sess_ip_address|s:11:"60.10.69.69";sess_useragent|s:50:"Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36";sess_last_regenerated|i:1401467613;retry|i:41;user_id|s:1:"1";user_number|s:9:"120406305";user_name|s:15:"æ¼”ç¤ºç”¨æˆ·å";user_section|s:9:"å·¥ç¨‹éƒ¨";user_telephone|s:11:"13940022196";user_qq|s:9:"506200331";authorizee|s:1:"0";joined_act_sum|s:1:"0";'),
('4assrir8jqjhdehbatufv24d50', 1400158894, 'sess_last_access|i:1400158894;sess_ip_address|s:11:"10.16.1.187";sess_useragent|s:50:"Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/53";sess_last_regenerated|i:1400158880;retry|i:11;user_id|s:1:"1";user_number|s:9:"120406305";user_name|s:9:"æž—æ˜Ÿè¾°";user_section|s:9:"å·¥ç¨‹éƒ¨";user_telephone|s:11:"13940022196";user_qq|s:9:"506200331";authorizee|s:1:"0";joined_act_sum|s:1:"0";'),
('4mppo9no5k96kd573o6kje6ks6', 1401530522, 'sess_last_access|i:1401530522;sess_ip_address|s:12:"112.90.78.22";sess_useragent|s:11:"Mozilla/4.0";sess_last_regenerated|i:1401530522;retry|i:1;'),
('4qij6haeiqrgrs7bvgm785ggt6', 1400592171, 'sess_last_access|i:1400592171;sess_ip_address|s:15:"119.147.146.189";sess_useragent|s:50:"Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1;";sess_last_regenerated|i:1400592171;retry|i:1;'),
('4t0o328pcuqvii798hs44obm42', 1401292429, 'sess_last_access|i:1401292429;sess_ip_address|s:15:"120.201.105.116";sess_useragent|s:50:"Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36";sess_last_regenerated|i:1401292334;retry|i:3;user_id|s:1:"1";user_number|s:9:"120406305";user_name|s:15:"æ¼”ç¤ºç”¨æˆ·å";user_section|s:9:"å·¥ç¨‹éƒ¨";user_telephone|s:11:"13940022196";user_qq|s:9:"506200331";authorizee|s:1:"0";joined_act_sum|s:1:"0";'),
('51ok3n8cno28fmdf1ulavj2lm0', 1403591863, 'sess_last_access|i:1403591863;sess_ip_address|s:15:"113.225.202.149";sess_useragent|s:50:"Mozilla/5.0 (Windows NT 6.1; WOW64; rv:30.0) Gecko";sess_last_regenerated|i:1403591863;retry|i:1;'),
('58uned69e4apb3mqc80djufij7', 1399162723, 'sess_last_access|i:1399162723;sess_ip_address|s:11:"10.16.3.186";sess_useragent|s:50:"Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36";sess_last_regenerated|i:1399162723;retry|i:15;user_id|s:1:"1";user_number|s:9:"120406305";user_name|s:9:"æž—æ˜Ÿè¾°";user_section|s:9:"å·¥ç¨‹éƒ¨";user_telephone|s:11:"13940022196";user_qq|s:9:"506200331";authorizee|s:1:"0";joined_act_sum|s:1:"0";'),
('590uuvieg1ofbfvvmqq0gr44i5', 1399271575, 'sess_last_access|i:1399271575;sess_ip_address|s:15:"113.225.206.122";sess_useragent|s:50:"Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36";sess_last_regenerated|i:1399271556;retry|i:3;user_id|s:1:"1";user_number|s:9:"120406305";user_name|s:9:"æž—æ˜Ÿè¾°";user_section|s:9:"å·¥ç¨‹éƒ¨";user_telephone|s:11:"13940022196";user_qq|s:9:"506200331";authorizee|s:1:"0";joined_act_sum|s:1:"0";'),
('5ftpr9pu6la3echehq8jj6lse6', 1400653616, 'sess_last_access|i:1400653616;sess_ip_address|s:15:"115.239.212.135";sess_useragent|s:11:"Mozilla/4.0";sess_last_regenerated|i:1400653616;retry|i:1;'),
('5ggt499du4jp37ss357ongml26', 1400673658, 'sess_last_access|i:1400673658;sess_ip_address|s:11:"10.16.3.186";sess_useragent|s:50:"Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36";sess_last_regenerated|i:1400673658;retry|i:1;user_id|s:1:"1";user_number|s:9:"120406305";user_name|s:9:"æž—æ˜Ÿè¾°";user_section|s:9:"å·¥ç¨‹éƒ¨";user_telephone|s:11:"13940022196";user_qq|s:9:"506200331";authorizee|s:1:"0";joined_act_sum|s:1:"0";'),
('5mdqjd39j1vg0uu268aur35p92', 1400921571, 'sess_last_access|i:1400921571;sess_ip_address|s:15:"119.147.146.189";sess_useragent|s:50:"Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1;";sess_last_regenerated|i:1400921571;retry|i:1;'),
('6bs34nmanr3gjn81kj24q4mnc1', 1404300936, 'sess_last_access|i:1404300936;sess_ip_address|s:13:"123.125.71.80";sess_useragent|s:50:"Mozilla/5.0 (compatible; Baiduspider/2.0; +http://";sess_last_regenerated|i:1404300936;retry|i:1;'),
('6du212r2ck6c7u4cj0acmn0nn6', 1404158847, 'sess_last_access|i:1404158847;sess_ip_address|s:13:"66.249.69.116";sess_useragent|s:50:"Mozilla/5.0 (compatible; Googlebot/2.1; +http://ww";sess_last_regenerated|i:1404158847;retry|i:1;'),
('6iujcemhs5t7gieskh8m924lo2', 1401465367, 'sess_last_access|i:1401465367;sess_ip_address|s:11:"60.10.69.69";sess_useragent|s:50:"Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36";sess_last_regenerated|i:1401465189;retry|i:14;user_id|s:1:"1";user_number|s:9:"120406305";user_name|s:15:"æ¼”ç¤ºç”¨æˆ·å";user_section|s:9:"å·¥ç¨‹éƒ¨";user_telephone|s:11:"13940022196";user_qq|s:9:"506200331";authorizee|s:1:"0";joined_act_sum|s:1:"0";'),
('75dockbc350pn70q8cmgvu31l1', 1405698569, 'sess_last_access|i:1405698569;sess_ip_address|s:12:"66.249.64.34";sess_useragent|s:50:"Mozilla/5.0 (compatible; Googlebot/2.1; +http://ww";sess_last_regenerated|i:1405698569;retry|i:1;'),
('78o2af6tping39hmv74s341lr3', 1400772481, 'sess_last_access|i:1400772481;sess_ip_address|s:15:"120.201.105.116";sess_useragent|s:50:"Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36";sess_last_regenerated|i:1400772455;retry|i:3;user_id|s:1:"1";user_number|s:9:"120406305";user_name|s:9:"æž—æ˜Ÿè¾°";user_section|s:9:"å·¥ç¨‹éƒ¨";user_telephone|s:11:"13940022196";user_qq|s:9:"506200331";authorizee|s:1:"0";joined_act_sum|s:1:"0";'),
('7d4bkrfqu9m6ri32tvbono7kj6', 1402394298, 'sess_last_access|i:1402394298;sess_ip_address|s:11:"10.16.1.220";sess_useragent|s:50:"Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:18.0) G";sess_last_regenerated|i:1402394286;retry|i:3;user_id|s:1:"1";user_number|s:9:"120406305";user_name|s:15:"æ¼”ç¤ºç”¨æˆ·å";user_section|s:9:"å·¥ç¨‹éƒ¨";user_telephone|s:11:"13940022196";user_qq|s:9:"506200331";authorizee|s:1:"0";joined_act_sum|s:1:"0";'),
('7dea3t0ffotr1796o6j9r72d91', 1399216993, 'sess_last_access|i:1399216993;sess_ip_address|s:13:"113.225.21.75";sess_useragent|s:50:"Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36";sess_last_regenerated|i:1399216979;retry|i:2;'),
('7h4j8lea6enu2s47s9qq1k0tg5', 1403521453, 'sess_last_access|i:1403521453;sess_ip_address|s:11:"10.16.1.187";sess_useragent|s:50:"Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36";sess_last_regenerated|i:1403521279;retry|i:2;user_id|s:1:"1";user_number|s:9:"120406305";user_name|s:15:"æ¼”ç¤ºç”¨æˆ·å";user_section|s:9:"å·¥ç¨‹éƒ¨";user_telephone|s:11:"13940022196";user_qq|s:9:"506200331";authorizee|s:1:"0";joined_act_sum|s:1:"0";'),
('7h9g62p3r42a8256nel23t9vr1', 1401016421, 'sess_last_access|i:1401016421;sess_ip_address|s:11:"10.16.3.186";sess_useragent|s:50:"Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36";sess_last_regenerated|i:1401016415;retry|i:19;user_id|s:1:"1";user_number|s:9:"120406305";user_name|s:15:"æ¼”ç¤ºç”¨æˆ·å";user_section|s:9:"å·¥ç¨‹éƒ¨";user_telephone|s:11:"13940022196";user_qq|s:9:"506200331";authorizee|s:1:"0";joined_act_sum|s:1:"0";'),
('7nf1c14qisjl6dv571ne81cgp1', 1400773466, 'sess_last_access|i:1400773466;sess_ip_address|s:15:"120.201.105.116";sess_useragent|s:50:"Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36";sess_last_regenerated|i:1400773460;retry|i:3;user_id|s:1:"1";user_number|s:9:"120406305";user_name|s:9:"æž—æ˜Ÿè¾°";user_section|s:9:"å·¥ç¨‹éƒ¨";user_telephone|s:11:"13940022196";user_qq|s:9:"506200331";authorizee|s:1:"0";joined_act_sum|s:1:"0";'),
('82j35bj1113lahrkug69aqjqa7', 1401015455, 'sess_last_access|i:1401015455;sess_ip_address|s:11:"10.16.3.186";sess_useragent|s:50:"Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:29.0) G";sess_last_regenerated|i:1401015454;retry|i:2;'),
('8eis4orvdg1ld0ar5113l6l1e3', 1400418633, 'sess_last_access|i:1400418633;sess_ip_address|s:15:"119.147.146.189";sess_useragent|s:50:"Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1;";sess_last_regenerated|i:1400418633;retry|i:1;'),
('8fi0hmq6p6ujkce1kir6974373', 1403609789, 'sess_last_access|i:1403609789;sess_ip_address|s:11:"10.16.1.187";sess_useragent|s:50:"Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36";sess_last_regenerated|i:1403609536;retry|i:6;user_id|s:1:"1";user_number|s:9:"120406305";user_name|s:15:"æ¼”ç¤ºç”¨æˆ·å";user_section|s:9:"å·¥ç¨‹éƒ¨";user_telephone|s:11:"13940022196";user_qq|s:9:"506200331";authorizee|s:1:"0";joined_act_sum|s:1:"0";'),
('8g012doap14b0ol3ogvbognm51', 1401326927, 'sess_last_access|i:1401326927;sess_ip_address|s:12:"116.2.95.152";sess_useragent|s:50:"Mozilla/5.0 (iPad; CPU OS 7_0_6 like Mac OS X) App";sess_last_regenerated|i:1401326837;retry|i:5;'),
('8hds5j8c54gpcloulnsdgr7o31', 1401500421, 'sess_last_access|i:1401500421;sess_ip_address|s:15:"222.161.199.186";sess_useragent|s:50:"Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36";sess_last_regenerated|i:1401500282;retry|i:5;user_id|s:1:"1";user_number|s:9:"120406305";user_name|s:15:"æ¼”ç¤ºç”¨æˆ·å";user_section|s:9:"å·¥ç¨‹éƒ¨";user_telephone|s:11:"13940022196";user_qq|s:9:"506200331";authorizee|s:1:"0";joined_act_sum|s:1:"0";'),
('8hf7onn2ukb4q3if70245vh7t6', 1404300937, 'sess_last_access|i:1404300937;sess_ip_address|s:13:"123.125.71.87";sess_useragent|s:50:"Mozilla/5.0 (compatible; Baiduspider/2.0; +http://";sess_last_regenerated|i:1404300937;retry|i:1;'),
('8j8r67llo490e353dmemiir7s6', 1401332807, 'sess_last_access|i:1401332807;sess_ip_address|s:13:"113.225.29.55";sess_useragent|s:50:"Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36";sess_last_regenerated|i:1401332664;retry|i:3;user_id|s:1:"1";user_number|s:9:"120406305";user_name|s:15:"æ¼”ç¤ºç”¨æˆ·å";user_section|s:9:"å·¥ç¨‹éƒ¨";user_telephone|s:11:"13940022196";user_qq|s:9:"506200331";authorizee|s:1:"0";joined_act_sum|s:1:"0";'),
('8k1vrfaakqiohjbdeedvrr51o0', 1400497502, 'sess_last_access|i:1400497502;sess_ip_address|s:11:"10.16.1.187";sess_useragent|s:50:"Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/53";sess_last_regenerated|i:1400497430;retry|i:3;user_id|s:1:"1";user_number|s:9:"120406305";user_name|s:9:"æž—æ˜Ÿè¾°";user_section|s:9:"å·¥ç¨‹éƒ¨";user_telephone|s:11:"13940022196";user_qq|s:9:"506200331";authorizee|s:1:"0";joined_act_sum|s:1:"0";'),
('8loq4htlhi9sf749gcbpig8mb0', 1399296765, 'sess_last_access|i:1399296765;sess_ip_address|s:11:"10.16.3.186";sess_useragent|s:50:"Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36";sess_last_regenerated|i:1399296573;retry|i:22;user_id|s:1:"1";user_number|s:9:"120406305";user_name|s:9:"æž—æ˜Ÿè¾°";user_section|s:9:"å·¥ç¨‹éƒ¨";user_telephone|s:11:"13940022196";user_qq|s:9:"506200331";authorizee|s:1:"0";joined_act_sum|s:1:"0";'),
('94njnpub3eg5qm8l6f93c1ck64', 1399162740, 'sess_last_access|i:1399162740;sess_ip_address|s:11:"10.16.3.186";sess_useragent|s:50:"Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36";sess_last_regenerated|i:1399162739;retry|i:2;'),
('98qajsppq5on9d6v6ll1v8nk52', 1401292248, 'sess_last_access|i:1401292248;sess_ip_address|s:15:"120.201.105.116";sess_useragent|s:50:"Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36";sess_last_regenerated|i:1401292232;retry|i:5;user_id|s:1:"1";user_number|s:9:"120406305";user_name|s:15:"æ¼”ç¤ºç”¨æˆ·å";user_section|s:9:"å·¥ç¨‹éƒ¨";user_telephone|s:11:"13940022196";user_qq|s:9:"506200331";authorizee|s:1:"0";joined_act_sum|s:1:"0";'),
('9c6em68koqili0d5ud9l9bgc82', 1401291553, 'sess_last_access|i:1401291553;sess_ip_address|s:11:"14.17.29.92";sess_useragent|s:11:"Mozilla/4.0";sess_last_regenerated|i:1401291553;retry|i:1;'),
('9en1590c5vqd17qca9hokmc8t3', 1401090198, 'sess_last_access|i:1401090198;sess_ip_address|s:15:"180.153.163.189";sess_useragent|s:11:"Mozilla/4.0";sess_last_regenerated|i:1401090198;retry|i:1;'),
('9lfd1dgtsv72964i8tbejpmpa5', 1405734707, 'sess_last_access|i:1405734707;sess_ip_address|s:13:"66.249.66.102";sess_useragent|s:50:"Mozilla/5.0 (compatible; Googlebot/2.1; +http://ww";sess_last_regenerated|i:1405734707;retry|i:1;'),
('9lq5kv1nh5bs3hdk39m7pphrt4', 1401086776, 'sess_last_access|i:1401086776;sess_ip_address|s:14:"113.225.27.234";sess_useragent|s:50:"Mozilla/5.0 (compatible; MSIE 10.0; Windows NT 6.1";sess_last_regenerated|i:1401086758;retry|i:3;user_id|s:1:"1";user_number|s:9:"120406305";user_name|s:15:"æ¼”ç¤ºç”¨æˆ·å";user_section|s:9:"å·¥ç¨‹éƒ¨";user_telephone|s:11:"13940022196";user_qq|s:9:"506200331";authorizee|s:1:"0";joined_act_sum|s:1:"0";'),
('9p8u8f2i3ak9s1saq28cu98t64', 1399970877, 'sess_last_access|i:1399970877;sess_ip_address|s:11:"10.16.3.186";sess_useragent|s:50:"Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36";sess_last_regenerated|i:1399970798;retry|i:6;user_id|s:1:"1";user_number|s:9:"120406305";user_name|s:9:"æž—æ˜Ÿè¾°";user_section|s:9:"å·¥ç¨‹éƒ¨";user_telephone|s:11:"13940022196";user_qq|s:9:"506200331";authorizee|s:1:"0";joined_act_sum|s:1:"0";'),
('au3kj9eau786cu2ilahee89eb2', 1401501399, 'sess_last_access|i:1401501399;sess_ip_address|s:15:"222.161.199.186";sess_useragent|s:50:"Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36";sess_last_regenerated|i:1401501123;retry|i:5;user_id|s:1:"1";user_number|s:9:"120406305";user_name|s:15:"æ¼”ç¤ºç”¨æˆ·å";user_section|s:9:"å·¥ç¨‹éƒ¨";user_telephone|s:11:"13940022196";user_qq|s:9:"506200331";authorizee|s:1:"0";joined_act_sum|s:1:"0";'),
('avj0fq5einc1iqd2hv61k0ur52', 1399897503, 'sess_last_access|i:1399897503;sess_ip_address|s:11:"10.16.3.186";sess_useragent|s:50:"Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36";sess_last_regenerated|i:1399897503;retry|i:8;user_id|s:1:"1";user_number|s:9:"120406305";user_name|s:9:"æž—æ˜Ÿè¾°";user_section|s:9:"å·¥ç¨‹éƒ¨";user_telephone|s:11:"13940022196";user_qq|s:9:"506200331";authorizee|s:1:"0";joined_act_sum|s:1:"0";'),
('b4fsol9chgjlivb7av8ddn90t3', 1400773220, 'sess_last_access|i:1400773220;sess_ip_address|s:15:"120.201.105.116";sess_useragent|s:50:"Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36";sess_last_regenerated|i:1400773214;retry|i:3;user_id|s:1:"1";user_number|s:9:"120406305";user_name|s:9:"æž—æ˜Ÿè¾°";user_section|s:9:"å·¥ç¨‹éƒ¨";user_telephone|s:11:"13940022196";user_qq|s:9:"506200331";authorizee|s:1:"0";joined_act_sum|s:1:"0";'),
('b9tn6pq0he9lg4fr15q1gn3nb5', 1401293328, 'sess_last_access|i:1401293328;sess_ip_address|s:12:"116.2.83.239";sess_useragent|s:50:"Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/53";sess_last_regenerated|i:1401293067;retry|i:3;user_id|s:1:"1";user_number|s:9:"120406305";user_name|s:15:"æ¼”ç¤ºç”¨æˆ·å";user_section|s:9:"å·¥ç¨‹éƒ¨";user_telephone|s:11:"13940022196";user_qq|s:9:"506200331";authorizee|s:1:"0";joined_act_sum|s:1:"0";'),
('c0gh4nq1h30d7s0gs4dh77vnu1', 1401895220, 'sess_last_access|i:1401895220;sess_ip_address|s:15:"123.150.182.115";sess_useragent|s:50:"Mozilla/5.0 (Linux; U; Android 4.2.2; zh-CN; Coolp";sess_last_regenerated|i:1401895189;retry|i:2;'),
('c3v336gk9oc13irs4c0qakklm5', 1405859066, 'sess_last_access|i:1405859066;sess_ip_address|s:15:"222.161.198.245";sess_useragent|s:50:"Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.1;";sess_last_regenerated|i:1405859006;retry|i:3;user_id|s:1:"1";user_number|s:9:"120406305";user_name|s:15:"æ¼”ç¤ºç”¨æˆ·å";user_section|s:9:"å·¥ç¨‹éƒ¨";user_telephone|s:11:"13940022196";user_qq|s:9:"506200331";authorizee|s:1:"0";joined_act_sum|s:1:"0";'),
('cck5h3jdi9b4aqo6n8dh5sg5j2', 1405820877, 'sess_last_access|i:1405820877;sess_ip_address|s:13:"66.249.66.103";sess_useragent|s:50:"Mozilla/5.0 (compatible; Googlebot/2.1; +http://ww";sess_last_regenerated|i:1405820877;retry|i:1;'),
('cjsfld4c2e782kndfhgav4pgu5', 1399348795, 'sess_last_access|i:1399348795;sess_ip_address|s:14:"113.225.30.164";sess_useragent|s:50:"Mozilla/5.0 (Linux; U; Android 4.2.2; zh-CN; Coolp";sess_last_regenerated|i:1399348729;retry|i:5;user_id|s:1:"1";user_number|s:9:"120406305";user_name|s:9:"æž—æ˜Ÿè¾°";user_section|s:9:"å·¥ç¨‹éƒ¨";user_telephone|s:11:"13940022196";user_qq|s:9:"506200331";authorizee|s:1:"0";joined_act_sum|s:1:"0";'),
('ct367tnqchiomrt27e95dmq462', 1401371627, 'sess_last_access|i:1401371627;sess_ip_address|s:13:"113.225.27.25";sess_useragent|s:50:"Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36";sess_last_regenerated|i:1401371598;retry|i:3;user_id|s:1:"1";user_number|s:9:"120406305";user_name|s:15:"æ¼”ç¤ºç”¨æˆ·å";user_section|s:9:"å·¥ç¨‹éƒ¨";user_telephone|s:11:"13940022196";user_qq|s:9:"506200331";authorizee|s:1:"0";joined_act_sum|s:1:"0";'),
('cvd38u8556pq40d8plivrgnq57', 1401785817, 'sess_last_access|i:1401785817;sess_ip_address|s:10:"10.16.3.50";sess_useragent|s:50:"Mozilla/5.0 (Windows NT 5.1) AppleWebKit/537.36 (K";sess_last_regenerated|i:1401785809;retry|i:3;user_id|s:1:"1";user_number|s:9:"120406305";user_name|s:15:"æ¼”ç¤ºç”¨æˆ·å";user_section|s:9:"å·¥ç¨‹éƒ¨";user_telephone|s:11:"13940022196";user_qq|s:9:"506200331";authorizee|s:1:"0";joined_act_sum|s:1:"0";'),
('d2cjqmve7j92p10q9cv1m62ri4', 1399567693, 'sess_last_access|i:1399567693;sess_ip_address|s:14:"120.201.105.13";sess_useragent|s:50:"Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36";sess_last_regenerated|i:1399567562;retry|i:3;user_id|s:1:"1";user_number|s:9:"120406305";user_name|s:9:"æž—æ˜Ÿè¾°";user_section|s:9:"å·¥ç¨‹éƒ¨";user_telephone|s:11:"13940022196";user_qq|s:9:"506200331";authorizee|s:1:"0";joined_act_sum|s:1:"0";'),
('d34t0jlcnubq3saua4dftfvm75', 1399194138, 'sess_last_access|i:1399194138;sess_ip_address|s:11:"10.16.3.186";sess_useragent|s:50:"Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36";sess_last_regenerated|i:1399194113;retry|i:15;user_id|s:1:"1";user_number|s:9:"120406305";user_name|s:9:"æž—æ˜Ÿè¾°";user_section|s:9:"å·¥ç¨‹éƒ¨";user_telephone|s:11:"13940022196";user_qq|s:9:"506200331";authorizee|s:1:"0";joined_act_sum|s:1:"0";'),
('d445rt13j8c01cdujqjt2ltkq4', 1401014952, 'sess_last_access|i:1401014952;sess_ip_address|s:11:"10.16.3.186";sess_useragent|s:50:"Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:29.0) G";sess_last_regenerated|i:1401014919;retry|i:11;user_id|s:1:"1";user_number|s:9:"120406305";user_name|s:15:"æ¼”ç¤ºç”¨æˆ·å";user_section|s:9:"å·¥ç¨‹éƒ¨";user_telephone|s:11:"13940022196";user_qq|s:9:"506200331";authorizee|s:1:"0";joined_act_sum|s:1:"0";'),
('djde24lvqm00f7k2k4noc28463', 1402557589, 'sess_last_access|i:1402557589;sess_ip_address|s:15:"106.120.112.210";sess_useragent|s:50:"Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/53";sess_last_regenerated|i:1402557535;retry|i:3;user_id|s:1:"1";user_number|s:9:"120406305";user_name|s:15:"æ¼”ç¤ºç”¨æˆ·å";user_section|s:9:"å·¥ç¨‹éƒ¨";user_telephone|s:11:"13940022196";user_qq|s:9:"506200331";authorizee|s:1:"0";joined_act_sum|s:1:"0";'),
('e2ci1ge3f213bil05li0h08jg6', 1401722202, 'sess_last_access|i:1401722202;sess_ip_address|s:15:"120.201.105.193";sess_useragent|s:50:"Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36";sess_last_regenerated|i:1401722202;retry|i:1;'),
('ejnu4g0th5b4rb9s7f3rqia077', 1400935179, 'sess_last_access|i:1400935179;sess_ip_address|s:13:"222.161.221.3";sess_useragent|s:50:"Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/53";sess_last_regenerated|i:1400935155;retry|i:2;user_id|s:1:"1";user_number|s:9:"120406305";user_name|s:9:"æž—æ˜Ÿè¾°";user_section|s:9:"å·¥ç¨‹éƒ¨";user_telephone|s:11:"13940022196";user_qq|s:9:"506200331";authorizee|s:1:"0";joined_act_sum|s:1:"0";'),
('erf12btjasvcrugj8i1f4bvle2', 1402142882, 'sess_last_access|i:1402142882;sess_ip_address|s:13:"123.125.71.15";sess_useragent|s:50:"Mozilla/5.0 (compatible; Baiduspider/2.0; +http://";sess_last_regenerated|i:1402142882;retry|i:1;'),
('esgadfvbpak1ufmmsbh04ehfd5', 1399133584, 'sess_last_access|i:1399133584;sess_ip_address|s:14:"120.201.105.13";sess_useragent|s:50:"Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36";sess_last_regenerated|i:1399133565;retry|i:8;user_id|s:1:"1";user_number|i:120406305;user_name|s:9:"æž—æ˜Ÿè¾°";user_section|s:9:"å·¥ç¨‹éƒ¨";user_telephone|s:11:"13940022196";user_qq|s:9:"506200331";authorizee|s:1:"0";joined_act_sum|s:1:"0";'),
('etkd7pdgckag0mi5c7019f6l81', 1405766388, 'sess_last_access|i:1405766388;sess_ip_address|s:13:"66.249.66.102";sess_useragent|s:50:"Mozilla/5.0 (compatible; Googlebot/2.1; +http://ww";sess_last_regenerated|i:1405766388;retry|i:1;'),
('f0mn6nhbj6frsas5hicmjcvto7', 1401013680, 'sess_last_access|i:1401013680;sess_ip_address|s:11:"10.16.3.186";sess_useragent|s:50:"Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36";sess_last_regenerated|i:1401013387;retry|i:22;user_id|s:1:"1";user_number|s:9:"120406305";user_name|s:15:"æ¼”ç¤ºç”¨æˆ·å";user_section|s:9:"å·¥ç¨‹éƒ¨";user_telephone|s:11:"13940022196";user_qq|s:9:"506200331";authorizee|s:1:"0";joined_act_sum|s:1:"0";'),
('f6dnnsju52av4m39r3narbp3s6', 1399983674, 'sess_last_access|i:1399983674;sess_ip_address|s:11:"10.38.83.86";sess_useragent|s:50:"Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36";sess_last_regenerated|i:1399983673;retry|i:2;'),
('fdns3pc97586va43e76l9hij77', 1401552008, 'sess_last_access|i:1401552008;sess_ip_address|s:15:"222.161.199.186";sess_useragent|s:50:"Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/53";sess_last_regenerated|i:1401552008;retry|i:7;user_id|s:1:"1";user_number|s:9:"120406305";user_name|s:15:"æ¼”ç¤ºç”¨æˆ·å";user_section|s:9:"å·¥ç¨‹éƒ¨";user_telephone|s:11:"13940022196";user_qq|s:9:"506200331";authorizee|s:1:"0";joined_act_sum|s:1:"0";'),
('fo4bd2sqkgsqamut1br46hakv6', 1403486603, 'sess_last_access|i:1403486603;sess_ip_address|s:12:"10.16.20.156";sess_useragent|s:50:"Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36";sess_last_regenerated|i:1403486603;retry|i:1;'),
('g5fh84c2cv93oigrl5iatuudk3', 1399348978, 'sess_last_access|i:1399348978;sess_ip_address|s:15:"113.232.100.112";sess_useragent|s:50:"Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36";sess_last_regenerated|i:1399348965;retry|i:3;user_id|s:1:"1";user_number|s:9:"120406305";user_name|s:9:"æž—æ˜Ÿè¾°";user_section|s:9:"å·¥ç¨‹éƒ¨";user_telephone|s:11:"13940022196";user_qq|s:9:"506200331";authorizee|s:1:"0";joined_act_sum|s:1:"0";'),
('h6fujiqurs0ngmegrv1r5loim5', 1401442365, 'sess_last_access|i:1401442365;sess_ip_address|s:12:"14.17.18.143";sess_useragent|s:11:"Mozilla/4.0";sess_last_regenerated|i:1401442365;retry|i:1;'),
('h80h8vejb3fq6u5gqoloum40r1', 1399463158, 'sess_last_access|i:1399463158;sess_ip_address|s:11:"10.16.3.186";sess_useragent|s:50:"Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36";sess_last_regenerated|i:1399463114;retry|i:18;user_id|s:1:"1";user_number|s:9:"120406305";user_name|s:9:"æž—æ˜Ÿè¾°";user_section|s:9:"å·¥ç¨‹éƒ¨";user_telephone|s:11:"13940022196";user_qq|s:9:"506200331";authorizee|s:1:"0";joined_act_sum|s:1:"0";'),
('hm100rdl3mqnq7c9p7l4mtiqo0', 1401783857, 'sess_last_access|i:1401783857;sess_ip_address|s:9:"10.16.3.9";sess_useragent|s:50:"Mozilla/5.0 (Macintosh; Intel Mac OS X 10_9_3) App";sess_last_regenerated|i:1401783857;retry|i:1;'),
('hqa5mviu15vah80hiee0tj9eg4', 1401322052, 'sess_last_access|i:1401322052;sess_ip_address|s:14:"123.184.77.154";sess_useragent|s:50:"Mozilla/5.0 (Linux; U; Android 4.4.2; zh-cn; GT-I9";sess_last_regenerated|i:1401322052;retry|i:1;'),
('hst52pj1oe0drrqmk90c3k9841', 1400592185, 'sess_last_access|i:1400592185;sess_ip_address|s:15:"119.147.146.189";sess_useragent|s:50:"Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1;";sess_last_regenerated|i:1400592185;'),
('ht6rrk6bdb7t4u03cntrisvs20', 1402976727, 'sess_last_access|i:1402976727;sess_ip_address|s:12:"116.2.82.161";sess_useragent|s:50:"Mozilla/5.0 (compatible; MSIE 10.0; Windows NT 6.1";sess_last_regenerated|i:1402976723;retry|i:2;'),
('hukl3kitcfdrbnqr5kpc4ufbr0', 1401706385, 'sess_last_access|i:1401706385;sess_ip_address|s:12:"183.60.35.80";sess_useragent|s:11:"Mozilla/4.0";sess_last_regenerated|i:1401706385;retry|i:1;'),
('i633pik59pc7t20i1clltrvq26', 1399878409, 'sess_last_access|i:1399878409;sess_ip_address|s:11:"10.16.3.186";sess_useragent|s:50:"Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36";sess_last_regenerated|i:1399878404;retry|i:3;user_id|s:1:"1";user_number|s:9:"120406305";user_name|s:9:"æž—æ˜Ÿè¾°";user_section|s:9:"å·¥ç¨‹éƒ¨";user_telephone|s:11:"13940022196";user_qq|s:9:"506200331";authorizee|s:1:"0";joined_act_sum|s:1:"0";'),
('i97rkqi4h77cd0qcnug7km66j2', 1405671039, 'sess_last_access|i:1405671039;sess_ip_address|s:12:"66.249.74.47";sess_useragent|s:50:"Mozilla/5.0 (compatible; Googlebot/2.1; +http://ww";sess_last_regenerated|i:1405671039;retry|i:1;'),
('inncus0v8cillk9c8q75thsb46', 1405859124, 'sess_last_access|i:1405859124;sess_ip_address|s:15:"222.161.198.245";sess_useragent|s:50:"Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36";sess_last_regenerated|i:1405858845;retry|i:8;user_id|s:1:"1";user_number|s:9:"120406305";user_name|s:15:"æ¼”ç¤ºç”¨æˆ·å";user_section|s:9:"å·¥ç¨‹éƒ¨";user_telephone|s:11:"13940022196";user_qq|s:9:"506200331";authorizee|s:1:"0";joined_act_sum|s:1:"0";'),
('j8v3n8h00rpkdrdpv2v3f6q4f1', 1401435161, 'sess_last_access|i:1401435161;sess_ip_address|s:12:"14.17.18.144";sess_useragent|s:11:"Mozilla/4.0";sess_last_regenerated|i:1401435161;retry|i:1;'),
('je2dmvkrbvqcl9od1g8gl9a7n5', 1399123815, 'sess_last_access|i:1399123815;sess_ip_address|s:11:"10.16.3.186";sess_useragent|s:50:"Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36";sess_last_regenerated|i:1399123813;retry|i:17;user_id|s:1:"1";user_number|i:120406305;user_name|s:9:"æž—æ˜Ÿè¾°";user_section|s:9:"å·¥ç¨‹éƒ¨";user_telephone|s:11:"13940022196";user_qq|s:9:"506200331";authorizee|s:1:"0";joined_act_sum|s:1:"0";'),
('jet50p13lk12sp7ng6f5bt8m54', 1400653764, 'sess_last_access|i:1400653764;sess_ip_address|s:11:"10.16.2.157";sess_useragent|s:50:"Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/53";sess_last_regenerated|i:1400653716;retry|i:9;user_id|s:1:"1";user_number|s:9:"120406305";user_name|s:9:"æž—æ˜Ÿè¾°";user_section|s:9:"å·¥ç¨‹éƒ¨";user_telephone|s:11:"13940022196";user_qq|s:9:"506200331";authorizee|s:1:"0";joined_act_sum|s:1:"0";'),
('jjdmmsuu4t4m6k3kl6jhmgq9q5', 1401278072, 'sess_last_access|i:1401278072;sess_ip_address|s:14:"120.201.105.65";sess_useragent|s:50:"Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36";sess_last_regenerated|i:1401277951;retry|i:3;user_id|s:1:"1";user_number|s:9:"120406305";user_name|s:15:"æ¼”ç¤ºç”¨æˆ·å";user_section|s:9:"å·¥ç¨‹éƒ¨";user_telephone|s:11:"13940022196";user_qq|s:9:"506200331";authorizee|s:1:"0";joined_act_sum|s:1:"0";'),
('jk1gr24m44re66av8ij1g2o2d1', 1404103827, 'sess_last_access|i:1404103827;sess_ip_address|s:13:"123.125.71.90";sess_useragent|s:50:"Mozilla/5.0 (compatible; Baiduspider/2.0; +http://";sess_last_regenerated|i:1404103827;retry|i:1;'),
('jp0mh26blu10l7khvkoa5hncf3', 1400123834, 'sess_last_access|i:1400123834;sess_ip_address|s:11:"10.16.1.187";sess_useragent|s:50:"Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36";sess_last_regenerated|i:1400123698;retry|i:3;user_id|s:1:"1";user_number|s:9:"120406305";user_name|s:9:"æž—æ˜Ÿè¾°";user_section|s:9:"å·¥ç¨‹éƒ¨";user_telephone|s:11:"13940022196";user_qq|s:9:"506200331";authorizee|s:1:"0";joined_act_sum|s:1:"0";'),
('jpig0892hhcn3eotl70ind5o62', 1405816333, 'sess_last_access|i:1405816333;sess_ip_address|s:13:"66.249.66.106";sess_useragent|s:50:"Mozilla/5.0 (compatible; Googlebot/2.1; +http://ww";sess_last_regenerated|i:1405816333;retry|i:1;'),
('jttkcfnvlvnv9h4l0np98cof97', 1400471273, 'sess_last_access|i:1400471273;sess_ip_address|s:14:"113.225.196.96";sess_useragent|s:50:"Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/53";sess_last_regenerated|i:1400471007;retry|i:3;user_id|s:1:"1";user_number|s:9:"120406305";user_name|s:9:"æž—æ˜Ÿè¾°";user_section|s:9:"å·¥ç¨‹éƒ¨";user_telephone|s:11:"13940022196";user_qq|s:9:"506200331";authorizee|s:1:"0";joined_act_sum|s:1:"0";'),
('jv2diq7b39norp53agichpedg1', 1401371948, 'sess_last_access|i:1401371948;sess_ip_address|s:13:"113.225.27.25";sess_useragent|s:50:"Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36";sess_last_regenerated|i:1401371827;retry|i:3;user_id|s:1:"1";user_number|s:9:"120406305";user_name|s:15:"æ¼”ç¤ºç”¨æˆ·å";user_section|s:9:"å·¥ç¨‹éƒ¨";user_telephone|s:11:"13940022196";user_qq|s:9:"506200331";authorizee|s:1:"0";joined_act_sum|s:1:"0";'),
('k6sq90cd4rnhdod0jhpl2ien16', 1400160327, 'sess_last_access|i:1400160327;sess_ip_address|s:11:"10.16.1.187";sess_useragent|s:50:"Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36";sess_last_regenerated|i:1400160295;retry|i:6;user_id|s:1:"1";user_number|s:9:"120406305";user_name|s:9:"æž—æ˜Ÿè¾°";user_section|s:9:"å·¥ç¨‹éƒ¨";user_telephone|s:11:"13940022196";user_qq|s:9:"506200331";authorizee|s:1:"0";joined_act_sum|s:1:"0";'),
('khsdt7p4u167bs82o4li0uuj10', 1399867536, 'sess_last_access|i:1399867536;sess_ip_address|s:15:"113.232.106.217";sess_useragent|s:50:"Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36";sess_last_regenerated|i:1399867479;retry|i:3;user_id|s:1:"1";user_number|s:9:"120406305";user_name|s:9:"æž—æ˜Ÿè¾°";user_section|s:9:"å·¥ç¨‹éƒ¨";user_telephone|s:11:"13940022196";user_qq|s:9:"506200331";authorizee|s:1:"0";joined_act_sum|s:1:"0";'),
('kpj33g6e9fjqtrgnohumip0v91', 1400921575, 'sess_last_access|i:1400921575;sess_ip_address|s:13:"221.8.221.131";sess_useragent|s:50:"Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/53";sess_last_regenerated|i:1400921571;retry|i:3;user_id|s:1:"1";user_number|s:9:"120406305";user_name|s:9:"æž—æ˜Ÿè¾°";user_section|s:9:"å·¥ç¨‹éƒ¨";user_telephone|s:11:"13940022196";user_qq|s:9:"506200331";authorizee|s:1:"0";joined_act_sum|s:1:"0";'),
('kqm1jq90f65rkvu70hq1eenng4', 1401674552, 'sess_last_access|i:1401674552;sess_ip_address|s:14:"203.208.60.165";sess_useragent|s:50:"Mozilla/5.0 (compatible; Googlebot/2.1; +http://ww";sess_last_regenerated|i:1401674552;retry|i:1;'),
('ku363eah97erm0lhpv5m1l5n20', 1403658672, 'sess_last_access|i:1403658672;sess_ip_address|s:12:"10.16.20.217";sess_useragent|s:50:"Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36";sess_last_regenerated|i:1403658621;retry|i:9;user_id|s:1:"1";user_number|s:9:"120406305";user_name|s:15:"æ¼”ç¤ºç”¨æˆ·å";user_section|s:9:"å·¥ç¨‹éƒ¨";user_telephone|s:11:"13940022196";user_qq|s:9:"506200331";authorizee|s:1:"0";joined_act_sum|s:1:"0";'),
('lg7e8rhe3gclvsmj9se94bnmv3', 1401895264, 'sess_last_access|i:1401895264;sess_ip_address|s:15:"123.150.182.115";sess_useragent|s:50:"Mozilla/5.0 (Linux; U; Android 4.2.2; zh-CN; Coolp";sess_last_regenerated|i:1401895264;retry|i:1;'),
('li27tndn2pd7ib7d0ls9acp790', 1399630755, 'sess_last_access|i:1399630755;sess_ip_address|s:11:"10.16.3.186";sess_useragent|s:50:"Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36";sess_last_regenerated|i:1399630596;retry|i:3;user_id|s:1:"1";user_number|s:9:"120406305";user_name|s:9:"æž—æ˜Ÿè¾°";user_section|s:9:"å·¥ç¨‹éƒ¨";user_telephone|s:11:"13940022196";user_qq|s:9:"506200331";authorizee|s:1:"0";joined_act_sum|s:1:"0";'),
('lq6l40fk7316bmd2m4k8cjnee2', 1400673658, 'sess_last_access|i:1400673658;sess_ip_address|s:11:"10.16.3.186";sess_useragent|s:50:"Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36";sess_last_regenerated|i:1400673658;retry|i:1;'),
('m4f24fometevtk7ii5s3persl6', 1400488410, 'sess_last_access|i:1400488410;sess_ip_address|s:14:"113.225.196.96";sess_useragent|s:50:"Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/53";sess_last_regenerated|i:1400488410;retry|i:3;user_id|s:1:"1";user_number|s:9:"120406305";user_name|s:9:"æž—æ˜Ÿè¾°";user_section|s:9:"å·¥ç¨‹éƒ¨";user_telephone|s:11:"13940022196";user_qq|s:9:"506200331";authorizee|s:1:"0";joined_act_sum|s:1:"0";'),
('mhi9mtmdpabpqqr53jllrvjv95', 1403687179, 'sess_last_access|i:1403687179;sess_ip_address|s:11:"10.16.1.187";sess_useragent|s:50:"Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36";sess_last_regenerated|i:1403687179;retry|i:1;'),
('n7km03v8km774qbe1j11qg35a6', 1400429256, 'sess_last_access|i:1400429256;sess_ip_address|s:15:"120.201.105.105";sess_useragent|s:50:"Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/53";sess_last_regenerated|i:1400429256;retry|i:3;user_id|s:1:"1";user_number|s:9:"120406305";user_name|s:9:"æž—æ˜Ÿè¾°";user_section|s:9:"å·¥ç¨‹éƒ¨";user_telephone|s:11:"13940022196";user_qq|s:9:"506200331";authorizee|s:1:"0";joined_act_sum|s:1:"0";'),
('nuo7qhb07p3gou6304khed3ov0', 1403934299, 'sess_last_access|i:1403934299;sess_ip_address|s:14:"113.225.27.182";sess_useragent|s:50:"Mozilla/5.0 (Windows NT 6.1; WOW64; rv:30.0) Gecko";sess_last_regenerated|i:1403934262;retry|i:2;'),
('o2ri2crqe7vm0rh8iooigrlvq0', 1402322697, 'sess_last_access|i:1402322697;sess_ip_address|s:14:"113.225.25.110";sess_useragent|s:50:"Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36";sess_last_regenerated|i:1402322689;retry|i:3;user_id|s:1:"1";user_number|s:9:"120406305";user_name|s:15:"æ¼”ç¤ºç”¨æˆ·å";user_section|s:9:"å·¥ç¨‹éƒ¨";user_telephone|s:11:"13940022196";user_qq|s:9:"506200331";authorizee|s:1:"0";joined_act_sum|s:1:"0";'),
('o535l377ae3u1i7c9in13oeka0', 1401201452, 'sess_last_access|i:1401201452;sess_ip_address|s:15:"120.201.105.173";sess_useragent|s:50:"Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36";sess_last_regenerated|i:1401201432;retry|i:2;'),
('ogn46f63fqkl79mtagvgjdhog2', 1401331716, 'sess_last_access|i:1401331716;sess_ip_address|s:14:"113.225.201.42";sess_useragent|s:50:"Mozilla/5.0 (Windows NT 6.1; WOW64; rv:29.0) Gecko";sess_last_regenerated|i:1401331652;retry|i:3;'),
('oub4882a7gb523nfjjaqb5k2q7', 1404748359, 'sess_last_access|i:1404748359;sess_ip_address|s:14:"110.96.208.130";sess_useragent|s:50:"Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/53";sess_last_regenerated|i:1404748253;retry|i:3;user_id|s:1:"1";user_number|s:9:"120406305";user_name|s:15:"æ¼”ç¤ºç”¨æˆ·å";user_section|s:9:"å·¥ç¨‹éƒ¨";user_telephone|s:11:"13940022196";user_qq|s:9:"506200331";authorizee|s:1:"0";joined_act_sum|s:1:"0";'),
('q2slu2bssmq7eoccesso19lqa3', 1400945344, 'sess_last_access|i:1400945344;sess_ip_address|s:11:"60.10.69.71";sess_useragent|s:50:"Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/53";sess_last_regenerated|i:1400945344;retry|i:3;user_id|s:1:"1";user_number|s:9:"120406305";user_name|s:9:"æž—æ˜Ÿè¾°";user_section|s:9:"å·¥ç¨‹éƒ¨";user_telephone|s:11:"13940022196";user_qq|s:9:"506200331";authorizee|s:1:"0";joined_act_sum|s:1:"0";'),
('q77if97cm2bsdgsiuaqf0ar7m7', 1401365181, 'sess_last_access|i:1401365181;sess_ip_address|s:13:"113.225.27.25";sess_useragent|s:50:"Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36";sess_last_regenerated|i:1401364951;retry|i:7;user_id|s:1:"1";user_number|s:9:"120406305";user_name|s:15:"æ¼”ç¤ºç”¨æˆ·å";user_section|s:9:"å·¥ç¨‹éƒ¨";user_telephone|s:11:"13940022196";user_qq|s:9:"506200331";authorizee|s:1:"0";joined_act_sum|s:1:"0";'),
('qobpqdlqsggjmcffs28g87b1i4', 1400065506, 'sess_last_access|i:1400065506;sess_ip_address|s:11:"10.16.3.186";sess_useragent|s:50:"Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36";sess_last_regenerated|i:1400065506;retry|i:12;user_id|s:1:"1";user_number|s:9:"120406305";user_name|s:9:"æž—æ˜Ÿè¾°";user_section|s:9:"å·¥ç¨‹éƒ¨";user_telephone|s:11:"13940022196";user_qq|s:9:"506200331";authorizee|s:1:"0";joined_act_sum|s:1:"0";'),
('rbbppd9qpa044haj5qcgccu4r7', 1400773119, 'sess_last_access|i:1400773119;sess_ip_address|s:15:"120.201.105.116";sess_useragent|s:50:"Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36";sess_last_regenerated|i:1400773114;retry|i:3;user_id|s:1:"1";user_number|s:9:"120406305";user_name|s:9:"æž—æ˜Ÿè¾°";user_section|s:9:"å·¥ç¨‹éƒ¨";user_telephone|s:11:"13940022196";user_qq|s:9:"506200331";authorizee|s:1:"0";joined_act_sum|s:1:"0";'),
('re2tta4hg71kt9qemmd3h1fbg5', 1401449057, 'sess_last_access|i:1401449057;sess_ip_address|s:14:"113.105.95.122";sess_useragent|s:11:"Mozilla/4.0";sess_last_regenerated|i:1401449057;retry|i:1;'),
('rirdu2f05rjja88kdpbteg2b21', 1402142881, 'sess_last_access|i:1402142881;sess_ip_address|s:13:"123.125.71.34";sess_useragent|s:50:"Mozilla/5.0 (compatible; Baiduspider/2.0; +http://";sess_last_regenerated|i:1402142881;retry|i:1;'),
('rkk9jh3m910ebcr5te4vrh6qc3', 1399512224, 'sess_last_access|i:1399512224;sess_ip_address|s:14:"113.225.23.185";sess_useragent|s:50:"Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36";sess_last_regenerated|i:1399512193;retry|i:3;user_id|s:1:"1";user_number|s:9:"120406305";user_name|s:9:"æž—æ˜Ÿè¾°";user_section|s:9:"å·¥ç¨‹éƒ¨";user_telephone|s:11:"13940022196";user_qq|s:9:"506200331";authorizee|s:1:"0";joined_act_sum|s:1:"0";'),
('ro4pv5597vr7sofmogrv13lnb4', 1399381304, 'sess_last_access|i:1399381304;sess_ip_address|s:11:"10.16.3.186";sess_useragent|s:50:"Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36";sess_last_regenerated|i:1399381295;retry|i:22;user_id|s:1:"1";user_number|s:9:"120406305";user_name|s:9:"æž—æ˜Ÿè¾°";user_section|s:9:"å·¥ç¨‹éƒ¨";user_telephone|s:11:"13940022196";user_qq|s:9:"506200331";authorizee|s:1:"0";joined_act_sum|s:1:"0";'),
('sbistl86tv5dki24hvsuo10nq2', 1400592233, 'sess_last_access|i:1400592233;sess_ip_address|s:13:"113.225.20.23";sess_useragent|s:50:"Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/53";sess_last_regenerated|i:1400592161;retry|i:3;user_id|s:1:"1";user_number|s:9:"120406305";user_name|s:9:"æž—æ˜Ÿè¾°";user_section|s:9:"å·¥ç¨‹éƒ¨";user_telephone|s:11:"13940022196";user_qq|s:9:"506200331";authorizee|s:1:"0";joined_act_sum|s:1:"0";'),
('sk6ai0lecmi2vr2gtqsmbohtm1', 1401292715, 'sess_last_access|i:1401292715;sess_ip_address|s:14:"175.169.230.52";sess_useragent|s:50:"Mozilla/5.0 (Windows NT 6.2; WOW64) AppleWebKit/53";sess_last_regenerated|i:1401292661;retry|i:3;user_id|s:1:"1";user_number|s:9:"120406305";user_name|s:15:"æ¼”ç¤ºç”¨æˆ·å";user_section|s:9:"å·¥ç¨‹éƒ¨";user_telephone|s:11:"13940022196";user_qq|s:9:"506200331";authorizee|s:1:"0";joined_act_sum|s:1:"0";'),
('tbg7sumato8u0pvmmc8m9mmf62', 1401798225, 'sess_last_access|i:1401798225;sess_ip_address|s:12:"183.60.70.29";sess_useragent|s:11:"Mozilla/4.0";sess_last_regenerated|i:1401798225;retry|i:1;'),
('u1pij0clp2vh5pamav7av26aq1', 1405492734, 'sess_last_access|i:1405492734;sess_ip_address|s:15:"180.153.163.189";sess_useragent|s:11:"Mozilla/4.0";sess_last_regenerated|i:1405492734;retry|i:1;'),
('ub0vlv8ponkvmigj7m7mai0916', 1399701067, 'sess_last_access|i:1399701067;sess_ip_address|s:12:"10.38.81.132";sess_useragent|s:50:"Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36";sess_last_regenerated|i:1399701056;retry|i:2;'),
('ubcvm4d864oi2fasid8v3eig52', 1400477265, 'sess_last_access|i:1400477265;sess_ip_address|s:14:"113.225.196.96";sess_useragent|s:50:"Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36";sess_last_regenerated|i:1400477262;retry|i:3;user_id|s:1:"1";user_number|s:9:"120406305";user_name|s:9:"æž—æ˜Ÿè¾°";user_section|s:9:"å·¥ç¨‹éƒ¨";user_telephone|s:11:"13940022196";user_qq|s:9:"506200331";authorizee|s:1:"0";joined_act_sum|s:1:"0";'),
('uh8qm17c380plaf4kjjvhskqd6', 1399864291, 'sess_last_access|i:1399864291;sess_ip_address|s:14:"120.201.105.13";sess_useragent|s:50:"Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36";sess_last_regenerated|i:1399864291;retry|i:1;'),
('uitb3j4t6t1pk89ogs4lc6h0f5', 1399864353, 'sess_last_access|i:1399864353;sess_ip_address|s:14:"120.201.105.13";sess_useragent|s:50:"Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:29.0) G";sess_last_regenerated|i:1399864348;retry|i:2;'),
('uprs03ottuaurivo1poum09fl6', 1400773399, 'sess_last_access|i:1400773399;sess_ip_address|s:15:"120.201.105.116";sess_useragent|s:50:"Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36";sess_last_regenerated|i:1400773392;retry|i:3;user_id|s:1:"1";user_number|s:9:"120406305";user_name|s:9:"æž—æ˜Ÿè¾°";user_section|s:9:"å·¥ç¨‹éƒ¨";user_telephone|s:11:"13940022196";user_qq|s:9:"506200331";authorizee|s:1:"0";joined_act_sum|s:1:"0";'),
('v2t3pd16hvf6ha3nf20sec8tb0', 1404103827, 'sess_last_access|i:1404103827;sess_ip_address|s:13:"123.125.71.84";sess_useragent|s:50:"Mozilla/5.0 (compatible; Baiduspider/2.0; +http://";sess_last_regenerated|i:1404103827;retry|i:1;'),
('vk7rvsd0b18vqe1bet83vrgqk3', 1399133755, 'sess_last_access|i:1399133755;sess_ip_address|s:14:"120.201.105.13";sess_useragent|s:50:"Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36";sess_last_regenerated|i:1399133749;retry|i:3;user_id|s:1:"1";user_number|i:120406305;user_name|s:9:"æž—æ˜Ÿè¾°";user_section|s:9:"å·¥ç¨‹éƒ¨";user_telephone|s:11:"13940022196";user_qq|s:9:"506200331";authorizee|s:1:"0";joined_act_sum|s:1:"0";');

-- --------------------------------------------------------

--
-- 表的结构 `timetable_class`
--

CREATE TABLE IF NOT EXISTS `timetable_class` (
  `time_class_id` int(8) NOT NULL AUTO_INCREMENT,
  `time_class_user_number` char(20) NOT NULL COMMENT '学号',
  `time_class_table` varchar(35) NOT NULL COMMENT '35位，1/0取出时注意按位取反',
  `time_class_campus` tinyint(1) NOT NULL COMMENT '0老校区1新校区',
  `time_class_addtime` datetime NOT NULL COMMENT '课程表录入时间',
  `time_class_lock` tinyint(1) NOT NULL COMMENT '课程表锁定',
  `time_class_effective` tinyint(1) NOT NULL DEFAULT '1' COMMENT '课程表是否有效',
  PRIMARY KEY (`time_class_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- 转存表中的数据 `timetable_class`
--

INSERT INTO `timetable_class` (`time_class_id`, `time_class_user_number`, `time_class_table`, `time_class_campus`, `time_class_addtime`, `time_class_lock`, `time_class_effective`) VALUES
(1, '120406305', '00100001101100100000000010000000100', 1, '2014-05-29 20:06:07', 0, 1),
(2, '120406301', '00000000000000000000000000000000000', 0, '2014-04-03 10:35:11', 0, 1),
(3, '130406301', '00100001101100100000000010000000100', 0, '2014-05-04 08:15:06', 0, 1),
(4, '130406302', '01010001111100101110001001000000000', 0, '2014-05-04 08:16:16', 0, 1),
(5, '130406303', '10100000110100100100001011001010000', 0, '2014-05-29 20:04:51', 0, 1),
(6, '130406304', '10101011001011011101001001000000000', 0, '2014-05-29 20:05:16', 0, 1),
(7, '120406309', '01100001010100100000001010000000000', 0, '2014-05-29 20:05:32', 0, 1);

-- --------------------------------------------------------

--
-- 表的结构 `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `user_id` int(10) NOT NULL AUTO_INCREMENT,
  `user_number` char(20) NOT NULL COMMENT '学号',
  `user_name` varchar(10) NOT NULL COMMENT '姓名',
  `user_section` varchar(10) NOT NULL COMMENT '部门',
  `user_telephone` bigint(16) NOT NULL COMMENT '电话号码',
  `user_qq` int(15) DEFAULT NULL,
  `user_major` varchar(50) NOT NULL COMMENT '学院专业',
  `user_sex` varchar(4) NOT NULL,
  `user_talent` text,
  `user_senior_number` int(9) NOT NULL COMMENT '负责的前辈学号',
  `user_friendsearch_enable` tinyint(1) NOT NULL DEFAULT '1' COMMENT '允许好友搜索被找到',
  `user_reg_time` date NOT NULL COMMENT '注册时间',
  `user_password` varchar(1000) NOT NULL COMMENT '密码',
  `user_authorizee` int(2) NOT NULL COMMENT '权限/职务-3【老部员】-2【老部长】-1【老前辈】0【首席开发者】1【主任】2【副主任】3【部长】4【副部长】||5【部员】6【预备部员】7【客人】',
  `defunct` int(1) NOT NULL COMMENT '和谐/封禁',
  `defunct_time` datetime NOT NULL COMMENT '采用污点式记录方案',
  `defunct_result` text,
  `joined_act_sum` int(10) NOT NULL COMMENT '加入活动总数',
  `last_failure` int(11) NOT NULL,
  `continuity_fail` int(3) NOT NULL,
  `locked` tinyint(1) NOT NULL COMMENT '锁定',
  `locked_reason` varchar(1000) NOT NULL COMMENT '锁定原因',
  `user_recruit` tinyint(1) NOT NULL COMMENT '是否完成负责部员设置',
  `user_mess_ban` date NOT NULL COMMENT '禁言截止日期',
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=42 ;

--
-- 转存表中的数据 `user`
--

INSERT INTO `user` (`user_id`, `user_number`, `user_name`, `user_section`, `user_telephone`, `user_qq`, `user_major`, `user_sex`, `user_talent`, `user_senior_number`, `user_friendsearch_enable`, `user_reg_time`, `user_password`, `user_authorizee`, `defunct`, `defunct_time`, `defunct_result`, `joined_act_sum`, `last_failure`, `continuity_fail`, `locked`, `locked_reason`, `user_recruit`, `user_mess_ban`) VALUES
(1, '120406305', '演示用户名', '工程部', 13940022196, 506200331, '计算机', '男', '计算机', 0, 0, '2014-03-09', 'gUg51Gkm1al6i+1CHDCJmie47mqj84F1/PdJ8wkNsD46UB7him6UEvWDE4Xq47iP3RRZB+hTOFFvdPjOMHeVcQ==', 0, 0, '0000-00-00 00:00:00', '123456', 0, 1398305452, 0, 0, '', 1, '0000-00-00'),
(2, '10000', '消息中心', '工程部', 13940022196, 506200331, '计算机', '男', '156', 120406305, 0, '0000-00-00', 'BGMEYFNkBmFRZA5j', 0, 0, '2014-03-22 17:43:06', NULL, 0, 1395322710, 1, 0, '', 0, '0000-00-00'),
(29, '120406306', '部员A', '传媒部', 13940022196, 506200331, '信息科学与工程学院-计算机-1203', '女', '排球', 0, 1, '2014-05-03', 'AI/BdKa6JbkoeP1BtsCNmCBs4Svv/lKJ3iKILIfzVB4BoSWrI8vMzSWk0cCNstFGxe/9GQkqCG+jy7Uy7/a/dg==', 1, 0, '0000-00-00 00:00:00', NULL, 0, 1399128842, 0, 0, '', 0, '0000-00-00'),
(30, '120406307', '老部长A', '企划部', 13940022196, 506200331, '信息科学与工程学院-计算机-1203', '男', '无', 0, 1, '2014-05-03', 'kHzyZix+TubWn/D83LyMEga4XlLPP0jjitv/FhZzlL32vKYOH30K9OKIkeLVvVoZjDJYiANnYeEQZaRlo9wV3A==', -2, 0, '0000-00-00 00:00:00', NULL, 0, 0, 0, 0, '', 0, '0000-00-00'),
(31, '120406308', '老主席', '统筹部', 13940022196, 506200331, '信息科学与工程学院-计算机-1203', '男', '无', 0, 1, '2014-05-03', 'Lf/BMZP1zUNUwfoBHESzJxgWLle+J0HE20FLF1Gq54+6CxTkbPq+HVwZo+UUDZV0kmgeadiNGwYvbEnhqsDcRA==', -1, 0, '0000-00-00 00:00:00', NULL, 0, 0, 0, 0, '', 0, '0000-00-00'),
(32, '120406309', '工程部部员', '工程部', 13940022196, 506200331, '信息科学与工程学院-计算机-1203', '男', '无', 0, 1, '2014-05-03', 'UC7HVboUE37QnkeF+8PTIrNZAJ8N4LRK+iTlL60ZYoy3r+8PrVALFDguyQzwaBgitAuw1StDRJgxUY3k7yiEWA==', 5, 0, '0000-00-00 00:00:00', NULL, 0, 0, 0, 0, '', 0, '0000-00-00'),
(33, '120406310', '未激活演示', '新闻部', 13940022196, 506200331, '信息科学与工程学院-计算机-1203', '男', '无', 0, 1, '2014-05-03', '', 6, 0, '0000-00-00 00:00:00', NULL, 0, 0, 0, 0, '', 0, '0000-00-00'),
(34, '130406301', '部员A', '工程部', 13940022196, 506200331, '', '男', '无', 0, 1, '2014-05-04', 'lZJYs5WKTBUCCGLm0g1MW0D8bsN3w7l5Q79m9Gv4SXSRL/r+XTm05eNtj0KqiTI9cuYXsmXneCYDNVIA0WFnwg==', 2, 0, '0000-00-00 00:00:00', NULL, 0, 0, 0, 0, '', 0, '0000-00-00'),
(35, '130406302', '部员B', '工程部', 13940022196, 506200331, '', '女', '无', 0, 1, '2014-05-04', 'a9T5ihpH24vImX7EUjIhz1niOAJ0nyGFEfp/EtXETHOUh0hyYDRul8HLU3rONmHiai9BSF9Ti6OJ5JJJH4v4Yw==', 5, 0, '0000-00-00 00:00:00', NULL, 0, 0, 0, 0, '', 0, '0000-00-00'),
(36, '130406303', '部员C', '工程部', 13940022196, 506200331, '', '男', '无', 0, 1, '2014-05-04', '', 6, 0, '0000-00-00 00:00:00', NULL, 0, 0, 0, 0, '', 0, '0000-00-00'),
(37, '130406304', '部员D', '工程部', 13940022196, 506200331, '', '男', '无', 0, 1, '2014-05-04', '', 6, 0, '0000-00-00 00:00:00', NULL, 0, 0, 0, 0, '', 0, '0000-00-00'),
(38, '130405331', '李华', '工程部', 13940000000, 500000000, '信息科学与工程学院-计算机-1303', '女', '计算机', 0, 1, '2014-05-31', 'g7LoPySex/0gyH8Uao/6Vm/tI7vmUFrxInvTcXrSKdaNUCIRPXOd/7JRFv/fisIy6vHVkPepU+sGfaxEbSWf2Q==', 6, 0, '0000-00-00 00:00:00', NULL, 0, 0, 0, 0, '', 0, '0000-00-00'),
(39, '130405210', '小明', '工程部', 13800000000, 600000000, '信息科学与工程学院-计算机-1302', '男', '计算机', 0, 1, '2014-05-31', '2ntXL+wrHjBUhtGF4TMZ/1caCfpxbnC61pMl0HFLIz0Ih4XAfu3Ta7/JdHgCPwOIQFXT96kVZDHGNwHCpgQoWA==', 6, 0, '0000-00-00 00:00:00', NULL, 0, 0, 0, 0, '', 0, '0000-00-00'),
(40, '12040633333', '', '', 0, NULL, '', '', NULL, 0, 1, '2014-08-14', 'CTIAMFQ1UWFRYgc1', 0, 0, '0000-00-00 00:00:00', NULL, 0, 0, 0, 0, '', 0, '0000-00-00'),
(41, '1204063056666', '', '', 0, NULL, '', '', NULL, 0, 1, '2014-08-14', 'CjFTY18+VmZebQQ2', 0, 0, '0000-00-00 00:00:00', NULL, 0, 0, 0, 0, '', 0, '0000-00-00');

-- --------------------------------------------------------

--
-- 表的结构 `user_property`
--

CREATE TABLE IF NOT EXISTS `user_property` (
  `user_id` int(10) NOT NULL AUTO_INCREMENT COMMENT '会号',
  `users_pro_user_number` char(20) NOT NULL,
  `users_pro_birthday` date NOT NULL COMMENT '出生日期',
  `users_pro_old` int(3) NOT NULL COMMENT '年龄',
  `users_pro_hometown` varchar(100) NOT NULL COMMENT '故乡',
  `users_pro_nick` varchar(100) NOT NULL COMMENT '昵称',
  `users_pro_homepage` varchar(1000) NOT NULL COMMENT '主页',
  `users_pro_language` varchar(100) NOT NULL COMMENT '语言',
  `users_pro_ename` varchar(100) NOT NULL COMMENT '外文名',
  `users_pro_bloodtype` varchar(3) NOT NULL COMMENT '血型',
  `users_pro_selfintro` varchar(400) NOT NULL COMMENT '自我介绍',
  `users_pro_photo_ext` varchar(10) NOT NULL COMMENT '照片后缀名',
  `users_pro_lock` int(1) NOT NULL COMMENT '隐私锁',
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=13 ;

--
-- 转存表中的数据 `user_property`
--

INSERT INTO `user_property` (`user_id`, `users_pro_user_number`, `users_pro_birthday`, `users_pro_old`, `users_pro_hometown`, `users_pro_nick`, `users_pro_homepage`, `users_pro_language`, `users_pro_ename`, `users_pro_bloodtype`, `users_pro_selfintro`, `users_pro_photo_ext`, `users_pro_lock`) VALUES
(1, '120406305', '1994-05-29', 20, '沈阳', '*Chen', 'acm.sut.edu.cn', '中日英', '*chen', 'B', '无', '.jpeg', 0),
(2, '120406306', '0000-00-00', 0, '', '', '', '', '', '', '', '', 0),
(3, '120406307', '0000-00-00', 0, '', '', '', '', '', '', '', '', 0),
(4, '120406308', '0000-00-00', 0, '', '', '', '', '', '', '', '', 0),
(5, '120406309', '0000-00-00', 0, '', '', '', '', '', '', '', '', 0),
(6, '120406310', '0000-00-00', 0, '', '', '', '', '', '', '', '', 0),
(7, '130406301', '0000-00-00', 0, '', '', '', '', '', '', '', '', 0),
(8, '130406302', '0000-00-00', 0, '', '', '', '', '', '', '', '', 0),
(9, '130406303', '0000-00-00', 0, '', '', '', '', '', '', '', '', 0),
(10, '130406304', '0000-00-00', 0, '', '', '', '', '', '', '', '', 0),
(11, '130405331', '0000-00-00', 0, '', '', '', '', '', '', '', '', 0),
(12, '130405210', '0000-00-00', 0, '', '', '', '', '', '', '', '', 0);

-- --------------------------------------------------------

--
-- 表的结构 `user_section_conflict`
--

CREATE TABLE IF NOT EXISTS `user_section_conflict` (
  `u_s_c_id` int(8) NOT NULL AUTO_INCREMENT,
  `u_s_c_user_number` char(20) NOT NULL,
  `u_s_c_user_section` varchar(10) NOT NULL,
  PRIMARY KEY (`u_s_c_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='招新部门冲突录入表' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `version`
--

CREATE TABLE IF NOT EXISTS `version` (
  `ver_id` int(5) NOT NULL AUTO_INCREMENT,
  `ver_code` text NOT NULL,
  `ver_describe` varchar(1000) NOT NULL,
  `release_time` datetime NOT NULL,
  PRIMARY KEY (`ver_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- 转存表中的数据 `version`
--

INSERT INTO `version` (`ver_id`, `ver_code`, `ver_describe`, `release_time`) VALUES
(1, 'Alpha1 build1064', '', '2014-04-23 14:39:38'),
(2, 'Alpha1 build1070', '', '2014-04-29 20:13:25'),
(3, 'Alpha1 build1071', '第一条开发日志', '2014-04-29 23:59:49'),
(4, 'Alpha1 build1072', '1.修复了多个因为过度安全加固而造成的BUG\n2.易用性改进\n3.紧急修改所有使用 (int) 的代码', '2014-05-04 14:36:43'),
(5, 'Alpha1 build1074', '1.研究成功WebSocket，建立简单社团聊天室\n2.易用性更新', '2014-05-06 20:22:52'),
(6, 'Alpha1 build1075', '细节更新', '2014-05-07 19:45:55'),
(7, 'Alpha1 build1076', '社团聊天室已经完成以下开发（封闭测试版）\n1.对WebSocket底层代码解析\n2.发送表情、图片、文件\n3.群聊、私聊任意切换\n4.@用户\n\n其他功能即将上线', '2014-05-09 00:48:09'),
(8, 'Alpha1 build1077', '1.易用性更新\n2.寻找灵感超级文件管理器部署完毕', '2014-05-15 21:25:26');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
