-- phpMyAdmin SQL Dump
-- version 4.0.10
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2014-11-02 01:33:40
-- 服务器版本: 5.1.73
-- PHP 版本: 5.2.17

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
  `act_private` tinyint(1) NOT NULL COMMENT '社团内部活动，用于移动端游客信息控制',
  `act_global` tinyint(4) NOT NULL COMMENT '无部门限制',
  `act_user_id` int(10) NOT NULL COMMENT '建立者',
  `act_content` varchar(1000) NOT NULL COMMENT '活动内容',
  `act_warn` varchar(1000) NOT NULL COMMENT '活动注意事项',
  `act_start` datetime NOT NULL COMMENT '活动开始时间',
  `act_end` datetime NOT NULL COMMENT '活动结束时间',
  `act_money` int(10) NOT NULL COMMENT '活动需要费用',
  `act_position` varchar(200) NOT NULL COMMENT '活动地点',
  `act_regtime` datetime NOT NULL COMMENT '活动注册时间',
  `act_member_sum` int(10) NOT NULL COMMENT '活动总人数限制(0为不限制)',
  `act_join_num` int(10) NOT NULL COMMENT '活动参加人数',
  `act_good` int(10) NOT NULL COMMENT '活动赞数',
  `act_defunct` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`act_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `activity_arrange`
--

CREATE TABLE IF NOT EXISTS `activity_arrange` (
  `arrange_id` int(10) NOT NULL AUTO_INCREMENT COMMENT '分配号',
  `arrange_act_id` int(10) NOT NULL COMMENT '对应活动号',
  `arrange_user_id` int(10) NOT NULL COMMENT '被分配学号',
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
  `user_id` int(10) NOT NULL COMMENT '会号',
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
-- 表的结构 `activity_defunct`
--

CREATE TABLE IF NOT EXISTS `activity_defunct` (
  `act_id` int(11) NOT NULL,
  `act_defunct_time` datetime NOT NULL,
  `act_defunct_result` varchar(100) NOT NULL,
  PRIMARY KEY (`act_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='活动和谐';

-- --------------------------------------------------------

--
-- 表的结构 `activity_join`
--

CREATE TABLE IF NOT EXISTS `activity_join` (
  `act_join_id` int(10) NOT NULL AUTO_INCREMENT COMMENT '总参与编号',
  `act_id` int(10) NOT NULL COMMENT '活动编号',
  `user_id` int(10) NOT NULL COMMENT '会号',
  `act_join_time` datetime NOT NULL COMMENT '加入时间',
  `act_join_star_s` float NOT NULL COMMENT '期待值评分',
  `act_join_star_e` float NOT NULL COMMENT '完成活动后评分',
  `act_join_defunct` int(1) NOT NULL COMMENT '活动退出/和谐参与者',
  `act_join_ask` varchar(1000) NOT NULL COMMENT '活动咨询',
  `act_join_ask_id_defunct` int(1) NOT NULL COMMENT '咨询人匿名',
  `act_join_ask_defunct` int(1) NOT NULL COMMENT '咨询和谐',
  PRIMARY KEY (`act_join_id`),
  UNIQUE KEY `act_join_id` (`act_join_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `activity_reply`
--

CREATE TABLE IF NOT EXISTS `activity_reply` (
  `act_re_id` int(10) NOT NULL AUTO_INCREMENT COMMENT '回复编号',
  `act_ask_id` int(10) NOT NULL,
  `act_id` int(10) NOT NULL COMMENT '活动编号',
  `user_id` int(10) NOT NULL COMMENT '会号',
  `user_name_defunct` int(1) NOT NULL COMMENT '匿名',
  `act_re_defunct` int(1) NOT NULL COMMENT '和谐',
  `act_re_time` datetime NOT NULL COMMENT '回复时间',
  `act_re_good` int(10) NOT NULL COMMENT '赞数',
  PRIMARY KEY (`act_re_id`),
  UNIQUE KEY `act_re_id` (`act_re_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `activity_type`
--

CREATE TABLE IF NOT EXISTS `activity_type` (
  `activity_type_id` int(11) NOT NULL AUTO_INCREMENT,
  `activity_type_name` varchar(50) NOT NULL,
  PRIMARY KEY (`activity_type_id`),
  UNIQUE KEY `activity_type_id` (`activity_type_id`),
  KEY `activity_type_id_2` (`activity_type_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- 转存表中的数据 `activity_type`
--

INSERT INTO `activity_type` (`activity_type_id`, `activity_type_name`) VALUES
(1, '培训'),
(2, '开会'),
(3, '招新'),
(4, '宣传'),
(5, '比赛'),
(6, '聚餐'),
(7, '投票'),
(8, '其他');

-- --------------------------------------------------------

--
-- 表的结构 `activity_update`
--

CREATE TABLE IF NOT EXISTS `activity_update` (
  `act_id` int(10) NOT NULL COMMENT '活动id',
  `act_update_sum` int(10) NOT NULL COMMENT '修改次数，省流量',
  PRIMARY KEY (`act_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='活动更改';

-- --------------------------------------------------------

--
-- 表的结构 `authorizee`
--

CREATE TABLE IF NOT EXISTS `authorizee` (
  `authorizee_id` int(10) NOT NULL AUTO_INCREMENT,
  `authorizee_name` varchar(100) NOT NULL,
  `authorizee_describe` varchar(100) NOT NULL,
  `authorizee_column_id` int(11) NOT NULL,
  PRIMARY KEY (`authorizee_id`),
  UNIQUE KEY `authorizee_id` (`authorizee_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='权限表【Allow,Deny,Not Set】' AUTO_INCREMENT=25 ;

--
-- 转存表中的数据 `authorizee`
--

INSERT INTO `authorizee` (`authorizee_id`, `authorizee_name`, `authorizee_describe`, `authorizee_column_id`) VALUES
(1, 'act_add', '添加活动', 1),
(2, 'act_update', '活动修改', 1),
(3, 'act_dele', '活动删除', 1),
(4, 'act_global_list', '活动全局列表', 1),
(5, 'act_global_add', '活动全局添加(部门)', 1),
(6, 'act_propagator', '活动宣传安排', 1),
(7, 'person_add', '部员添加', 2),
(8, 'person_info_update', '部员信息更改', 2),
(9, 'person_dele', '删除部员', 2),
(10, 'person_update_class_table', '更改部员课程表', 2),
(11, 'person_add_class_table', '添加用户课程表', 2),
(12, 'act_dele_recovery', '活动删除恢复', 1),
(13, 'person_dele_recovery', '部员删除恢复', 2),
(14, 'person_add_by_excel', '部员招新', 2),
(15, 'person_conflict_judge', '部员冲突判定', 2),
(16, 'authorizee_update_password', '修改其他部员密码', 3),
(17, 'authorizee_update_role', '部员角色更改', 3),
(18, 'authorizee_add_role', '添加角色', 3),
(19, 'authorizee_update_authorizee', '修改角色权限', 3),
(20, 'authorizee_add_user_authorizee', '添加用户特权', 3),
(21, 'authorizee_update_user_authorizee', '修改用户特权', 3),
(22, 'person_add_section', '为添加用户选择部门', 2),
(23, 'authorizee_get_role_authorizee', '获取角色权限', 3),
(24, 'act_read_dele', '已删除活动读取', 1);

-- --------------------------------------------------------

--
-- 表的结构 `authorizee_column`
--

CREATE TABLE IF NOT EXISTS `authorizee_column` (
  `authorizee_column_id` int(11) NOT NULL AUTO_INCREMENT,
  `authorizee_column_name` varchar(200) NOT NULL,
  PRIMARY KEY (`authorizee_column_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- 转存表中的数据 `authorizee_column`
--

INSERT INTO `authorizee_column` (`authorizee_column_id`, `authorizee_column_name`) VALUES
(1, '活动'),
(2, '部员'),
(3, '权限'),
(4, '日常');

-- --------------------------------------------------------

--
-- 表的结构 `bug`
--

CREATE TABLE IF NOT EXISTS `bug` (
  `bug_id` int(10) NOT NULL AUTO_INCREMENT,
  `bug_version` varchar(100) NOT NULL COMMENT '出现bug的版本',
  `bug_release_time` datetime NOT NULL,
  `bug_detail` varchar(2000) NOT NULL COMMENT 'bug描述',
  `bug_report_user_id` int(10) NOT NULL COMMENT 'bug上报学号',
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

INSERT INTO `bug` (`bug_id`, `bug_version`, `bug_release_time`, `bug_detail`, `bug_report_user_id`, `bug_report_time`, `bug_reply`, `bug_reply_user_number`, `bug_reply_time`, `bug_repair_progress`, `bug_repaired`) VALUES
(1, 'Alpha1 build1071', '2014-04-29 23:59:49', '功能有些不完善', 120406305, '2014-05-03 23:32:10', '敬请期待后续版本更新', 120406305, '2014-05-03 23:38:18', 80, 0),
(2, 'Alpha1 build1071', '2014-04-29 23:59:49', '功能还不完善', 120406305, '2014-05-03 23:32:49', '', 0, '0000-00-00 00:00:00', 0, 0),
(3, 'Alpha1 build1071', '2014-04-29 23:59:49', '功能还不完善', 120406305, '2014-05-03 23:34:06', '', 0, '0000-00-00 00:00:00', 0, 0),
(4, 'Alpha1 build1077', '2014-05-15 21:25:26', '多宣传平台一键直达', 120406305, '2014-05-24 23:18:50', '', 0, '0000-00-00 00:00:00', 0, 0);

-- --------------------------------------------------------

--
-- 表的结构 `checkin`
--

CREATE TABLE IF NOT EXISTS `checkin` (
  `checkin_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '签到id',
  `checkin_activity_id` int(11) NOT NULL COMMENT '活动id',
  `checkin_user_id` int(11) NOT NULL COMMENT '用户id',
  `checkin_time` datetime NOT NULL COMMENT '签到时间',
  `checkin_ip` int(11) NOT NULL COMMENT '签到ip',
  `checkin_longitude` float NOT NULL COMMENT '签到人经度',
  `checkin_dimension` float NOT NULL COMMENT '签到人纬度',
  `checkin_accuracy` int(11) NOT NULL COMMENT '签到人经纬度准确度',
  PRIMARY KEY (`checkin_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

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
  `user_id` int(10) NOT NULL COMMENT '会号',
  `contest_join_time` datetime NOT NULL COMMENT '比赛加入时间',
  `contest_join_defunct` tinyint(1) NOT NULL COMMENT '注销加入',
  PRIMARY KEY (`contest_join_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- 转存表中的数据 `contest_join`
--

INSERT INTO `contest_join` (`contest_join_id`, `contest_id`, `user_id`, `contest_join_time`, `contest_join_defunct`) VALUES
(1, 1, 1, '2014-05-29 00:04:34', 0);

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
  `friend_s` int(10) NOT NULL COMMENT '申请者/接受者',
  `friend_d` int(10) NOT NULL COMMENT '接受者/申请者',
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
  `user_mixed` varchar(20) NOT NULL,
  `login_time` datetime NOT NULL,
  `login_ip` int(8) NOT NULL,
  `login_pass` tinyint(1) NOT NULL,
  PRIMARY KEY (`login_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `medal`
--

CREATE TABLE IF NOT EXISTS `medal` (
  `medal_sum_id` int(10) NOT NULL AUTO_INCREMENT COMMENT '勋章流水号',
  `medal_id` int(10) NOT NULL COMMENT '勋章编号',
  `user_id_from` int(10) NOT NULL COMMENT '勋章发放人',
  `user_id_to` int(10) NOT NULL COMMENT '勋章领取人',
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
  `mess_from_id` int(10) NOT NULL,
  `mess_to_id` int(10) NOT NULL,
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `message_push`
--

CREATE TABLE IF NOT EXISTS `message_push` (
  `mess_push_id` int(10) NOT NULL AUTO_INCREMENT COMMENT '推送id',
  `mess_push_user_id` int(10) NOT NULL COMMENT '推送者',
  `mess_push_section_limit` int(3) NOT NULL COMMENT '推送部门限制',
  `mess_push_title` varchar(100) NOT NULL COMMENT '推送标题',
  `mess_push_content` varchar(4000) NOT NULL,
  `mess_push_style` varchar(30) NOT NULL COMMENT '推送显示样式',
  `mess_push_time` datetime NOT NULL,
  `mess_push_end_time` datetime NOT NULL,
  `mess_push_dele` tinyint(1) NOT NULL COMMENT '推送人删除',
  `mess_push_dele_time` datetime NOT NULL COMMENT '推送人删除时间',
  PRIMARY KEY (`mess_push_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='消息推送表' AUTO_INCREMENT=5 ;

--
-- 转存表中的数据 `message_push`
--

INSERT INTO `message_push` (`mess_push_id`, `mess_push_user_id`, `mess_push_section_limit`, `mess_push_title`, `mess_push_content`, `mess_push_style`, `mess_push_time`, `mess_push_end_time`, `mess_push_dele`, `mess_push_dele_time`) VALUES
(1, 120406305, 0, '推送标题A', '推送样式A', 'alert-success', '2014-08-18 00:00:00', '2014-08-25 00:00:00', 0, '0000-00-00 00:00:00'),
(2, 120406305, 0, '推送标题B', '推送样式B', 'alert-info', '2014-08-11 00:00:00', '2014-08-31 00:00:00', 0, '0000-00-00 00:00:00'),
(3, 120406305, 0, '推送标题C', '推送样式C', 'alert-warning', '2014-08-11 00:00:00', '2014-08-31 00:00:00', 0, '0000-00-00 00:00:00'),
(4, 120406305, 0, '推送标题D', '推送样式D', 'alert-danger', '2014-08-11 00:00:00', '2014-08-24 00:00:00', 0, '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- 表的结构 `mobile_version`
--

CREATE TABLE IF NOT EXISTS `mobile_version` (
  `mobile_version_release` datetime NOT NULL COMMENT '发布日期',
  `mobile_version_build` decimal(6,5) NOT NULL COMMENT '版本号',
  `mobile_version_notice` varchar(1000) NOT NULL COMMENT '更新内容',
  PRIMARY KEY (`mobile_version_build`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='移动端版本表';

--
-- 转存表中的数据 `mobile_version`
--

INSERT INTO `mobile_version` (`mobile_version_release`, `mobile_version_build`, `mobile_version_notice`) VALUES
('2014-10-27 00:00:00', '2.00001', '允许进行自动更新\r\n测试换行');

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
-- 表的结构 `re_activity_section`
--

CREATE TABLE IF NOT EXISTS `re_activity_section` (
  `act_id` int(11) NOT NULL,
  `section_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='活动、部门关联表';

-- --------------------------------------------------------

--
-- 表的结构 `re_activity_type`
--

CREATE TABLE IF NOT EXISTS `re_activity_type` (
  `act_id` int(11) NOT NULL,
  `type_id` int(11) NOT NULL,
  PRIMARY KEY (`act_id`),
  UNIQUE KEY `activity_id` (`act_id`),
  KEY `activity_id_2` (`act_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `re_role_authorizee`
--

CREATE TABLE IF NOT EXISTS `re_role_authorizee` (
  `authorizee_id` int(10) NOT NULL,
  `1` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `re_role_authorizee`
--

INSERT INTO `re_role_authorizee` (`authorizee_id`, `1`) VALUES
(1, 1),
(2, 1),
(3, 1),
(4, 1),
(5, 1),
(6, 1),
(7, 1),
(8, 1),
(9, 1),
(10, 1),
(11, 1),
(12, 1),
(13, 1),
(14, 1),
(15, 1),
(16, 1),
(17, 1),
(18, 1),
(19, 1),
(20, 1),
(21, 1),
(22, 1),
(23, 1),
(24, 1),
(25, 0),
(26, 0),
(27, 0),
(28, 0),
(29, 0),
(30, 0);

-- --------------------------------------------------------

--
-- 表的结构 `re_user_authorizee`
--

CREATE TABLE IF NOT EXISTS `re_user_authorizee` (
  `user_id` int(10) NOT NULL,
  `authorizee_id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户权限关联表【特权表】';

-- --------------------------------------------------------

--
-- 表的结构 `re_user_role`
--

CREATE TABLE IF NOT EXISTS `re_user_role` (
  `user_id` int(10) NOT NULL,
  `role_id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `re_user_section`
--

CREATE TABLE IF NOT EXISTS `re_user_section` (
  `user_id` int(10) NOT NULL,
  `section_id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户部门关联表';

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='角色表' AUTO_INCREMENT=8 ;

--
-- 转存表中的数据 `role`
--

INSERT INTO `role` (`role_id`, `role_name`, `role_describe`) VALUES
(1, '管理员', '');

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
-- 表的结构 `session`
--

CREATE TABLE IF NOT EXISTS `session` (
  `session_id` varchar(32) NOT NULL,
  `ip_address` char(16) NOT NULL,
  `user_agent` int(10) NOT NULL,
  `last_activity` int(10) NOT NULL,
  `user_data` text NOT NULL,
  `session_last_access` int(10) unsigned DEFAULT NULL,
  `session_data` text,
  PRIMARY KEY (`session_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `session`
--

INSERT INTO `session` (`session_id`, `ip_address`, `user_agent`, `last_activity`, `user_data`, `session_last_access`, `session_data`) VALUES
('2916cfedc7602c7ce946fc9f7207ca1c', '127.0.0.1', 0, 1414656955, 'a:5:{s:9:"user_data";s:0:"";s:7:"user_id";s:1:"1";s:8:"user_key";s:11:"14146524871";s:9:"user_name";s:9:"林星辰";s:9:"user_role";s:9:"管理员";}', NULL, NULL),
('48f8963bdf4034758e62ab2d9d64100e', '127.0.0.1', 0, 1414753804, 'a:5:{s:9:"user_data";s:0:"";s:7:"user_id";s:1:"1";s:8:"user_key";s:11:"14147538141";s:9:"user_name";s:9:"林星辰";s:9:"user_role";s:9:"管理员";}', NULL, NULL),
('790dd3e853d090b1edb140d96876b851', '127.0.0.1', 0, 1414641284, 'a:5:{s:9:"user_data";s:0:"";s:7:"user_id";s:1:"1";s:8:"user_key";s:11:"14146371391";s:9:"user_name";s:9:"林星辰";s:9:"user_role";s:9:"管理员";}', NULL, NULL),
('aff37d9780ccc5ddc5813cc0d22f2d1d', '127.0.0.1', 0, 1414688436, 'a:5:{s:9:"user_data";s:0:"";s:7:"user_id";s:1:"1";s:8:"user_key";s:11:"14146851541";s:9:"user_name";s:9:"林星辰";s:9:"user_role";s:9:"管理员";}', NULL, NULL),
('b5644596ce698648ea03a8991e341087', '127.0.0.1', 0, 1414739207, 'a:5:{s:9:"user_data";s:0:"";s:7:"user_id";s:1:"1";s:8:"user_key";s:11:"14147381721";s:9:"user_name";s:9:"林星辰";s:9:"user_role";s:9:"管理员";}', NULL, NULL);

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

-- --------------------------------------------------------

--
-- 表的结构 `timetable_class`
--

CREATE TABLE IF NOT EXISTS `timetable_class` (
  `time_class_id` int(8) NOT NULL AUTO_INCREMENT,
  `time_class_user_id` int(10) NOT NULL COMMENT 'id',
  `time_class_table` varchar(35) NOT NULL COMMENT '35位，1/0取出时注意按位取反',
  `time_class_campus` tinyint(1) NOT NULL COMMENT '0老校区1新校区',
  `time_class_addtime` datetime NOT NULL COMMENT '课程表录入时间',
  `time_class_lock` tinyint(1) NOT NULL COMMENT '课程表锁定',
  `time_class_effective` tinyint(1) NOT NULL DEFAULT '1' COMMENT '课程表是否有效',
  PRIMARY KEY (`time_class_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `user_id` int(10) NOT NULL AUTO_INCREMENT,
  `user_number` char(20) NOT NULL COMMENT '学号',
  `user_name` varchar(10) NOT NULL COMMENT '姓名',
  `user_telephone` bigint(16) NOT NULL COMMENT '电话号码',
  `user_qq` bigint(16) DEFAULT '0',
  `user_major` varchar(50) NOT NULL COMMENT '学院专业',
  `user_sex` varchar(4) NOT NULL,
  `user_talent` varchar(400) DEFAULT '',
  `user_senior_number` int(9) NOT NULL COMMENT '负责的前辈学号',
  `user_friendsearch_enable` tinyint(1) NOT NULL DEFAULT '1' COMMENT '允许好友搜索被找到',
  `user_reg_time` date NOT NULL COMMENT '注册时间',
  `user_password` varchar(1000) NOT NULL COMMENT '密码',
  `user_defunct` int(1) NOT NULL COMMENT '和谐/封禁',
  `user_defunct_time` datetime NOT NULL COMMENT '采用污点式记录方案',
  `user_defunct_result` varchar(400) DEFAULT '',
  `user_joined_act_sum` int(10) NOT NULL COMMENT '加入活动总数',
  `user_last_failure` int(11) NOT NULL,
  `user_continuity_fail` int(3) NOT NULL,
  `user_locked` tinyint(1) NOT NULL COMMENT '锁定',
  `user_locked_reason` varchar(1000) NOT NULL COMMENT '锁定原因',
  `user_recruit` tinyint(1) NOT NULL COMMENT '是否完成负责部员设置',
  `user_mess_ban` date NOT NULL COMMENT '禁言截止日期',
  PRIMARY KEY (`user_number`),
  UNIQUE KEY `user_id` (`user_id`),
  UNIQUE KEY `user_number` (`user_number`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `user_property`
--

CREATE TABLE IF NOT EXISTS `user_property` (
  `user_id` int(10) NOT NULL AUTO_INCREMENT COMMENT '会号',
  `user_pro_birthday` date NOT NULL COMMENT '出生日期',
  `user_pro_old` int(3) NOT NULL COMMENT '年龄',
  `user_pro_hometown` varchar(100) NOT NULL COMMENT '故乡',
  `user_pro_nick` varchar(100) NOT NULL COMMENT '昵称',
  `user_pro_homepage` varchar(1000) NOT NULL COMMENT '主页',
  `user_pro_language` varchar(100) NOT NULL COMMENT '语言',
  `user_pro_ename` varchar(100) NOT NULL COMMENT '外文名',
  `user_pro_bloodtype` varchar(3) NOT NULL COMMENT '血型',
  `user_pro_selfintro` varchar(400) NOT NULL COMMENT '自我介绍',
  `user_pro_photo_ext` varchar(10) NOT NULL COMMENT '照片后缀名',
  `user_pro_lock` int(1) NOT NULL COMMENT '隐私锁',
  UNIQUE KEY `user_id_2` (`user_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

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
