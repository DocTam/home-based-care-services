-- phpMyAdmin SQL Dump
-- version 4.0.10.20
-- https://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2019-03-30 17:57:11
-- 服务器版本: 5.1.65-community
-- PHP 版本: 5.5.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `admin_szrrjl9073`
--

-- --------------------------------------------------------

--
-- 表的结构 `hh_admin`
--

CREATE TABLE IF NOT EXISTS `hh_admin` (
  `admin_id` int(11) NOT NULL AUTO_INCREMENT,
  `admin_name` varchar(50) DEFAULT '',
  `passwd` char(32) DEFAULT '',
  `realname` varchar(50) DEFAULT '',
  `mobile` varchar(50) DEFAULT '',
  `telephone` varchar(50) DEFAULT '',
  `gender` tinyint(4) DEFAULT '1' COMMENT '1男 2女',
  `type` tinyint(4) DEFAULT '1' COMMENT '类别: 1管理员',
  `last_login` int(11) DEFAULT '0' COMMENT '最后登录时间',
  `loginip` varchar(50) DEFAULT '0' COMMENT '登录ip',
  `status` tinyint(4) DEFAULT '1' COMMENT '状态 1正常 2无效',
  `dateline` int(11) DEFAULT '0' COMMENT '创建日期',
  PRIMARY KEY (`admin_id`),
  KEY `admin_name` (`admin_name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='管理员' AUTO_INCREMENT=1 ;

--
-- passwd: `admin` <-- md5 --> 'f5b08083d7b76e4293fed13aaa38207f'
--
INSERT INTO `hh_admin` (`admin_id`, `admin_name`, `passwd`, `realname`, `mobile`, `telephone`, `gender`, `type`, `last_login`, `loginip`, `status`, `dateline`) VALUES
(1, 'admin', 'f5b08083d7b76e4293fed13aaa38207f', '超级管理员', '18617051708', '0755-4550311', 1, 1, 1554084843, '61.141.252.105', 1, 0),
(2, 'test', '786fffa07955dc6394f8e0b60b6d5838', '体验账号', '18888888888', '0755-4550311', 1, 1, 1554084843, '61.141.252.105', 1, 0);

-- --------------------------------------------------------

--
-- 表的结构 `hh_apidata`
--

CREATE TABLE IF NOT EXISTS `hh_apidata` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `imei` int(11) NOT NULL DEFAULT '0',
  `datatype` varchar(20) NOT NULL DEFAULT '' COMMENT '数据类型',
  `content` text,
  `ip` varchar(50) DEFAULT '',
  `dateline` int(11) DEFAULT '0' COMMENT '时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='接口数据' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `hh_careadvice`
--

CREATE TABLE IF NOT EXISTS `hh_careadvice` (
  `advice_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL COMMENT '客户姓名:',
  `mobile` varchar(50) DEFAULT NULL COMMENT '手机号:',
  `ask_type` varchar(50) DEFAULT NULL COMMENT '护理类别:',
  `ask_cause` varchar(200) DEFAULT NULL COMMENT '护理事由:',
  `ask_time` int(11) DEFAULT NULL COMMENT '护理时间:',
  `worker_id` int(11) DEFAULT NULL COMMENT '护理师:',
  `ask_result` varchar(200) DEFAULT NULL COMMENT '护理结果:',
  `ask_num` int(11) DEFAULT NULL COMMENT '护理次数:',
  `satisfy` varchar(50) DEFAULT NULL COMMENT '是否满意:',
  `admin_id` varchar(50) DEFAULT NULL,
  `dateline` int(11) DEFAULT NULL,
  PRIMARY KEY (`advice_id`),
  KEY `admin_id` (`admin_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='护理记录' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `hh_cleaneradvice`
--

CREATE TABLE IF NOT EXISTS `hh_cleaneradvice` (
  `advice_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL COMMENT '客户姓名:',
  `mobile` varchar(50) DEFAULT NULL COMMENT '手机号:',
  `ask_type` varchar(50) DEFAULT NULL COMMENT '服务类别:',
  `ask_cause` varchar(200) DEFAULT NULL COMMENT '服务事由:',
  `ask_time` int(11) DEFAULT NULL COMMENT '服务时间:',
  `worker_id` int(11) DEFAULT NULL COMMENT '保洁员:',
  `ask_result` varchar(200) DEFAULT NULL COMMENT '服务结果:',
  `ask_num` int(11) DEFAULT NULL COMMENT '服务次数:',
  `satisfy` varchar(50) DEFAULT NULL COMMENT '是否满意:',
  `admin_id` varchar(50) DEFAULT NULL,
  `dateline` int(11) DEFAULT NULL,
  PRIMARY KEY (`advice_id`),
  KEY `admin_id` (`admin_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='服务记录' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `hh_cookfood`
--

CREATE TABLE IF NOT EXISTS `hh_cookfood` (
  `food_id` int(11) NOT NULL AUTO_INCREMENT,
  `dining_time` int(11) DEFAULT NULL,
  `menu_id` int(11) DEFAULT NULL,
  `price` float DEFAULT NULL,
  `worker_id` int(11) DEFAULT NULL,
  `people_num` int(11) DEFAULT NULL,
  `memo` varchar(200) DEFAULT NULL,
  `admin_id` int(11) DEFAULT NULL,
  `dateline` int(11) DEFAULT NULL,
  PRIMARY KEY (`food_id`),
  KEY `admin_id` (`admin_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='今日食谱' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `hh_cookmenu`
--

CREATE TABLE IF NOT EXISTS `hh_cookmenu` (
  `menu_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `price` float DEFAULT NULL,
  `admin_id` int(11) DEFAULT NULL,
  `dateline` int(11) DEFAULT NULL,
  PRIMARY KEY (`menu_id`),
  KEY `admin_id` (`admin_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='菜单' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `hh_course`
--

CREATE TABLE IF NOT EXISTS `hh_course` (
  `course_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL COMMENT '名称:',
  `lesson` varchar(50) DEFAULT NULL COMMENT '课时:',
  `worker_id` int(11) DEFAULT NULL COMMENT '任课老师:',
  `content` text COMMENT '说明:',
  `begintime` int(11) DEFAULT NULL COMMENT '开学时间:',
  `endtime` int(11) DEFAULT NULL COMMENT '结束时间:',
  `status` int(11) DEFAULT NULL,
  `admin_id` int(11) DEFAULT NULL,
  `dateline` int(11) DEFAULT NULL,
  PRIMARY KEY (`course_id`),
  KEY `admin_id` (`admin_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='课程表' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `hh_cultureart`
--

CREATE TABLE IF NOT EXISTS `hh_cultureart` (
  `art_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL COMMENT '艺术团名:',
  `people_num` int(11) DEFAULT NULL COMMENT '团队人数:',
  `type_id` varchar(50) DEFAULT NULL COMMENT '所属类别:',
  `company` varchar(50) DEFAULT NULL COMMENT '所属单位:',
  `leader` varchar(50) DEFAULT NULL COMMENT '团长姓名:',
  `charge` varchar(50) DEFAULT NULL COMMENT '负责人:',
  `chargemobile` varchar(50) DEFAULT NULL COMMENT '负责人电话',
  `status` int(11) DEFAULT NULL,
  `admin_id` int(11) DEFAULT NULL,
  `dateline` int(11) DEFAULT NULL,
  PRIMARY KEY (`art_id`),
  KEY `admin_id` (`admin_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='艺术团表' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `hh_culturemember`
--

CREATE TABLE IF NOT EXISTS `hh_culturemember` (
  `member_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL COMMENT '团员姓名:',
  `mobile` varchar(50) DEFAULT NULL COMMENT '团员电话:',
  `art_id` int(11) DEFAULT NULL COMMENT '所属艺术团:',
  `type_id` int(11) DEFAULT NULL COMMENT '特长:',
  `status` int(11) DEFAULT NULL,
  `admin_id` int(11) DEFAULT NULL,
  `dateline` int(11) DEFAULT NULL,
  PRIMARY KEY (`member_id`),
  KEY `admin_id` (`admin_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='文化娱乐 团员管理' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `hh_cultureshow`
--

CREATE TABLE IF NOT EXISTS `hh_cultureshow` (
  `show_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL COMMENT '演出名称:',
  `showtime` varchar(50) DEFAULT NULL COMMENT '参演时间:',
  `address` varchar(50) DEFAULT NULL COMMENT '演出地点:',
  `charge` varchar(50) DEFAULT NULL COMMENT '负责人:',
  `team_num` int(11) DEFAULT NULL COMMENT '参演队数:',
  `people_num` int(11) DEFAULT NULL COMMENT '参演人数:',
  `viewer_num` int(11) DEFAULT NULL COMMENT '观众人数:',
  `content` varchar(200) DEFAULT NULL COMMENT '说明:',
  `status` int(11) DEFAULT '1',
  `admin_id` int(11) DEFAULT '1',
  `dateline` int(11) DEFAULT NULL,
  PRIMARY KEY (`show_id`),
  KEY `admin_id` (`admin_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='文化娱乐 演出管理' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `hh_cultureteam`
--

CREATE TABLE IF NOT EXISTS `hh_cultureteam` (
  `team_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL COMMENT '队伍名称',
  `subject` varchar(50) DEFAULT NULL COMMENT '参演项目:',
  `showtime` varchar(50) DEFAULT NULL COMMENT '演出时间:',
  `show_num` int(11) DEFAULT NULL COMMENT '参演人数:',
  `item` varchar(50) DEFAULT NULL COMMENT '参演节目:',
  `item_type` varchar(50) DEFAULT NULL COMMENT '节目类型:',
  `show_order` int(11) DEFAULT NULL,
  `content` int(11) DEFAULT NULL COMMENT '说明:',
  `status` int(11) DEFAULT '1',
  `admin_id` int(11) DEFAULT '1',
  `dateline` int(11) DEFAULT NULL,
  PRIMARY KEY (`team_id`),
  KEY `admin_id` (`admin_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='演出队伍管理' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `hh_culturetype`
--

CREATE TABLE IF NOT EXISTS `hh_culturetype` (
  `type_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL COMMENT '特长',
  `type_no` varchar(50) DEFAULT NULL COMMENT '特长编号',
  `admin_id` varchar(50) DEFAULT NULL,
  `dateline` int(11) DEFAULT NULL,
  PRIMARY KEY (`type_id`),
  KEY `admin_id` (`admin_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='文化娱乐 类别管理' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `hh_daibiao`
--

CREATE TABLE IF NOT EXISTS `hh_daibiao` (
  `daibiao_id` int(11) NOT NULL AUTO_INCREMENT,
  `member_id` int(11) DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL COMMENT '姓名:',
  `mobile` varchar(50) DEFAULT NULL COMMENT '手机号:',
  `address` varchar(200) DEFAULT NULL COMMENT '地址:',
  `nation` varchar(50) DEFAULT NULL COMMENT '民族:',
  `birthY` int(11) DEFAULT NULL COMMENT '出生年月:',
  `birthM` int(11) DEFAULT NULL COMMENT '出生年月:',
  `select_sex` tinyint(4) DEFAULT NULL,
  `zhiwu` varchar(100) DEFAULT NULL COMMENT '代表职务',
  `renzhi` varchar(100) DEFAULT NULL COMMENT '任职时间',
  `workeraddress` varchar(100) DEFAULT NULL COMMENT '工作地址',
  `shiji` varchar(100) DEFAULT NULL COMMENT '主要事迹',
  `admin_id` int(11) DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL,
  `dateline` int(11) DEFAULT NULL,
  PRIMARY KEY (`daibiao_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='人大代表' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `hh_dibao`
--

CREATE TABLE IF NOT EXISTS `hh_dibao` (
  `dibao_id` int(11) NOT NULL AUTO_INCREMENT,
  `member_id` int(11) DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL COMMENT '姓名:',
  `mobile` varchar(50) DEFAULT NULL COMMENT '手机号:',
  `address` varchar(200) DEFAULT NULL COMMENT '地址:',
  `nation` varchar(50) DEFAULT NULL COMMENT '民族:',
  `birthY` int(11) DEFAULT NULL COMMENT '出生年月:',
  `birthM` int(11) DEFAULT NULL COMMENT '出生年月:',
  `select_sex` tinyint(4) DEFAULT NULL,
  `zhufang` varchar(100) DEFAULT NULL COMMENT '住房面积',
  `weifang` varchar(100) DEFAULT NULL COMMENT '是否危房',
  `jiegou` varchar(100) DEFAULT NULL COMMENT '房屋结构',
  `yinshui` varchar(100) DEFAULT NULL COMMENT '饮水情况',
  `yinshuianquan` varchar(100) DEFAULT NULL COMMENT '饮水安全',
  `tongdian` varchar(100) DEFAULT NULL COMMENT '是否通电',
  `zhipin` varchar(100) DEFAULT NULL COMMENT '主要致贫原因',
  `zhikun` varchar(100) DEFAULT NULL COMMENT '主要致困原因',
  `admin_id` int(11) DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL,
  `dateline` int(11) DEFAULT NULL,
  PRIMARY KEY (`dibao_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='低保特困' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `hh_difficulty`
--

CREATE TABLE IF NOT EXISTS `hh_difficulty` (
  `difficulty_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `mobile` varchar(50) DEFAULT NULL,
  `address` varchar(200) DEFAULT NULL,
  `type_id` int(11) DEFAULT NULL,
  `service_id` int(11) DEFAULT NULL,
  `content` text COMMENT '服务说明:',
  `money` float DEFAULT NULL COMMENT '金额:',
  `memo` text COMMENT '备注:',
  `begin_time` int(11) DEFAULT NULL COMMENT '开始时间:',
  `end_time` int(11) DEFAULT NULL COMMENT '结束时间:',
  `admin_id` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `dateline` int(11) DEFAULT NULL,
  PRIMARY KEY (`difficulty_id`),
  KEY `admin_id` (`admin_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='特困服务' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `hh_disabled`
--

CREATE TABLE IF NOT EXISTS `hh_disabled` (
  `disabled_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL COMMENT '姓名:',
  `mobile` varchar(50) DEFAULT NULL COMMENT '手机号:',
  `nation` varchar(50) DEFAULT NULL COMMENT '民族:',
  `hukou` varchar(50) DEFAULT NULL COMMENT '户口性质:',
  `select_marriage` tinyint(4) DEFAULT NULL COMMENT '婚姻:',
  `select_bloodType` varchar(10) DEFAULT NULL COMMENT '血型:',
  `select_sex` tinyint(4) DEFAULT NULL,
  `birthY` smallint(6) DEFAULT NULL,
  `birthM` tinyint(4) DEFAULT NULL,
  `grade` tinyint(4) DEFAULT NULL COMMENT '伤残级别:',
  `cause` varchar(50) DEFAULT NULL COMMENT '伤残事由:',
  `disabledno` varchar(50) DEFAULT NULL COMMENT '残疾人证件号:',
  `other_name` varchar(50) DEFAULT NULL COMMENT '监护人姓名:',
  `other_mobile` varchar(50) DEFAULT NULL COMMENT '手机号:',
  `other_address` varchar(50) DEFAULT NULL COMMENT '地址:',
  `other_sex` tinyint(4) DEFAULT NULL COMMENT '性别:',
  `other_idcard` varchar(50) DEFAULT NULL COMMENT '身份证号:',
  `admin_id` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `dateline` int(11) DEFAULT NULL,
  PRIMARY KEY (`disabled_id`),
  KEY `admin_id` (`admin_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='残疾人信息' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `hh_gongxian`
--

CREATE TABLE IF NOT EXISTS `hh_gongxian` (
  `gongxian_id` int(11) NOT NULL AUTO_INCREMENT,
  `member_id` int(11) DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL COMMENT '姓名:',
  `mobile` varchar(50) DEFAULT NULL COMMENT '手机号:',
  `address` varchar(200) DEFAULT NULL COMMENT '地址:',
  `nation` varchar(50) DEFAULT NULL COMMENT '民族:',
  `birthY` int(11) DEFAULT NULL COMMENT '出生年月:',
  `birthM` int(11) DEFAULT NULL COMMENT '出生年月:',
  `select_sex` tinyint(4) DEFAULT NULL,
  `otherdata` text,
  `admin_id` int(11) DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL,
  `dateline` int(11) DEFAULT NULL,
  PRIMARY KEY (`gongxian_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='突出贡献' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `hh_gulao`
--

CREATE TABLE IF NOT EXISTS `hh_gulao` (
  `gulao_id` int(11) NOT NULL AUTO_INCREMENT,
  `member_id` int(11) DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL COMMENT '姓名:',
  `mobile` varchar(50) DEFAULT NULL COMMENT '手机号:',
  `address` varchar(200) DEFAULT NULL COMMENT '地址:',
  `nation` varchar(50) DEFAULT NULL COMMENT '民族:',
  `birthY` int(11) DEFAULT NULL COMMENT '出生年月:',
  `birthM` int(11) DEFAULT NULL COMMENT '出生年月:',
  `select_sex` tinyint(4) DEFAULT NULL,
  `otherdata` text,
  `admin_id` int(11) DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL,
  `dateline` int(11) DEFAULT NULL,
  PRIMARY KEY (`gulao_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='孤老孤疾' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `hh_healthadvice`
--

CREATE TABLE IF NOT EXISTS `hh_healthadvice` (
  `advice_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL COMMENT '客户姓名:',
  `mobile` varchar(50) DEFAULT NULL COMMENT '手机号:',
  `ask_type` varchar(50) DEFAULT NULL COMMENT '咨询类别:',
  `ask_cause` varchar(200) DEFAULT NULL COMMENT '咨询事由:',
  `ask_time` int(11) DEFAULT NULL COMMENT '咨询时间:',
  `worker_id` int(11) DEFAULT NULL COMMENT '律师:',
  `ask_result` varchar(200) DEFAULT NULL COMMENT '咨询结果:',
  `ask_num` int(11) DEFAULT NULL COMMENT '咨询次数:',
  `satisfy` varchar(50) DEFAULT NULL COMMENT '是否满意:',
  `admin_id` varchar(50) DEFAULT NULL,
  `dateline` int(11) DEFAULT NULL,
  PRIMARY KEY (`advice_id`),
  KEY `admin_id` (`admin_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='健康咨询记录' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `hh_healthdata`
--

CREATE TABLE IF NOT EXISTS `hh_healthdata` (
  `data_id` int(11) NOT NULL AUTO_INCREMENT,
  `member_id` int(11) DEFAULT '0',
  `admin_id` int(11) DEFAULT '0',
  `name` varchar(50) DEFAULT NULL,
  `mobile` varchar(50) DEFAULT NULL,
  `datatype` varchar(20) DEFAULT '' COMMENT '数据类型',
  `imei` varchar(50) DEFAULT '',
  `time_begin` varchar(50) DEFAULT NULL COMMENT '发生时间',
  `time_end` varchar(50) DEFAULT NULL COMMENT '结束时间',
  `interval` smallint(6) DEFAULT NULL COMMENT '固定30分钟',
  `total` smallint(6) DEFAULT NULL COMMENT '检测次数',
  `data` text COMMENT '睡眠数据',
  `value` smallint(6) DEFAULT NULL COMMENT '步数',
  `heartrate` smallint(6) DEFAULT NULL COMMENT '心率',
  `theshold_heartrate_h` smallint(6) DEFAULT NULL COMMENT '心率阈值上限',
  `theshold_heartrate_l` smallint(6) DEFAULT NULL COMMENT '心率阈值下限',
  `is_reply` tinyint(4) DEFAULT NULL COMMENT '是否为响应',
  `is_track` tinyint(4) DEFAULT NULL COMMENT '是否轨迹',
  `city` varchar(50) DEFAULT NULL,
  `address` varchar(200) DEFAULT NULL COMMENT '地址',
  `lon` varchar(50) DEFAULT NULL COMMENT '经度',
  `lat` varchar(50) DEFAULT NULL COMMENT '纬度',
  `type` tinyint(4) DEFAULT NULL COMMENT '定位类型',
  `remaining_power` tinyint(4) DEFAULT NULL COMMENT '剩余电量',
  `dbp` smallint(6) DEFAULT NULL COMMENT '舒张压',
  `dbp_l` smallint(6) DEFAULT NULL COMMENT '舒张压报警下限',
  `sbp` smallint(6) DEFAULT NULL COMMENT '收缩压',
  `sbp_h` smallint(6) DEFAULT NULL COMMENT '收缩压报警上限',
  `receptionist` varchar(50) DEFAULT NULL COMMENT '接待人',
  `result` text COMMENT '处理结果',
  `updatetime` int(11) DEFAULT NULL,
  `opter` int(11) DEFAULT NULL COMMENT '操作管理员',
  `status` tinyint(4) DEFAULT '0' COMMENT '是否处理 0未处理',
  `dateline` int(11) DEFAULT NULL,
  PRIMARY KEY (`data_id`),
  KEY `member_id` (`member_id`),
  KEY `datatype` (`datatype`),
  KEY `admin_id` (`admin_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='健康数据' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `hh_kongchao`
--

CREATE TABLE IF NOT EXISTS `hh_kongchao` (
  `kongchao_id` int(11) NOT NULL AUTO_INCREMENT,
  `member_id` int(11) DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL COMMENT '姓名:',
  `mobile` varchar(50) DEFAULT NULL COMMENT '手机号:',
  `address` varchar(200) DEFAULT NULL COMMENT '地址:',
  `nation` varchar(50) DEFAULT NULL COMMENT '民族:',
  `birthY` int(11) DEFAULT NULL COMMENT '出生年月:',
  `birthM` int(11) DEFAULT NULL COMMENT '出生年月:',
  `select_sex` tinyint(4) DEFAULT NULL,
  `jingshen` varchar(100) DEFAULT NULL COMMENT '精神心理',
  `child` varchar(100) DEFAULT NULL COMMENT '子女赡养',
  `techang` varchar(100) DEFAULT NULL COMMENT '特长爱好',
  `jingji` varchar(100) DEFAULT NULL COMMENT '经济来源',
  `juzhu` varchar(100) DEFAULT NULL COMMENT '居住状况',
  `leixing` varchar(100) DEFAULT NULL COMMENT '家庭类型',
  `admin_id` int(11) DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL,
  `dateline` int(11) DEFAULT NULL,
  PRIMARY KEY (`kongchao_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='空巢老人' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `hh_lawadvice`
--

CREATE TABLE IF NOT EXISTS `hh_lawadvice` (
  `advice_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL COMMENT '客户姓名:',
  `mobile` varchar(50) DEFAULT NULL COMMENT '手机号:',
  `ask_type` varchar(50) DEFAULT NULL COMMENT '咨询类别:',
  `ask_cause` varchar(200) DEFAULT NULL COMMENT '咨询事由:',
  `ask_time` int(11) DEFAULT NULL COMMENT '咨询时间:',
  `worker_id` int(11) DEFAULT NULL COMMENT '律师:',
  `ask_result` varchar(200) DEFAULT NULL COMMENT '咨询结果:',
  `ask_num` int(11) DEFAULT NULL COMMENT '咨询次数:',
  `satisfy` varchar(50) DEFAULT NULL COMMENT '是否满意:',
  `admin_id` varchar(50) DEFAULT NULL,
  `dateline` int(11) DEFAULT NULL,
  PRIMARY KEY (`advice_id`),
  KEY `admin_id` (`admin_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='法律咨询记录' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `hh_medicaladvice`
--

CREATE TABLE IF NOT EXISTS `hh_medicaladvice` (
  `advice_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL COMMENT '客户姓名:',
  `mobile` varchar(50) DEFAULT NULL COMMENT '手机号:',
  `ask_type` varchar(50) DEFAULT NULL COMMENT '咨询类别:',
  `ask_cause` varchar(200) DEFAULT NULL COMMENT '咨询事由:',
  `ask_time` int(11) DEFAULT NULL COMMENT '咨询时间:',
  `worker_id` int(11) DEFAULT NULL COMMENT '律师:',
  `ask_result` varchar(200) DEFAULT NULL COMMENT '咨询结果:',
  `ask_num` int(11) DEFAULT NULL COMMENT '咨询次数:',
  `satisfy` varchar(50) DEFAULT NULL COMMENT '是否满意:',
  `admin_id` varchar(50) DEFAULT NULL,
  `dateline` int(11) DEFAULT NULL,
  PRIMARY KEY (`advice_id`),
  KEY `admin_id` (`admin_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='保健咨询记录' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `hh_member`
--

CREATE TABLE IF NOT EXISTS `hh_member` (
  `member_id` int(11) NOT NULL AUTO_INCREMENT,
  `member_no` varchar(50) DEFAULT NULL COMMENT '会员编号',
  `num` int(11) DEFAULT NULL,
  `name` text COMMENT '真实姓名',
  `select_sex` tinyint(4) DEFAULT NULL COMMENT '性别',
  `age` smallint(6) DEFAULT NULL COMMENT '年龄',
  `birthY` int(11) DEFAULT NULL COMMENT '出生年',
  `birthM` int(11) DEFAULT NULL COMMENT '出生月',
  `select_bloodType` varchar(10) DEFAULT NULL COMMENT '血型',
  `birthplace` varchar(50) DEFAULT NULL COMMENT '籍贯',
  `educational` varchar(50) DEFAULT NULL COMMENT '学历',
  `idcard` varchar(50) DEFAULT NULL COMMENT '身份证号',
  `technicaltitle` varchar(50) DEFAULT NULL COMMENT '岗位职称',
  `nation` varchar(50) DEFAULT NULL COMMENT '民族',
  `height` varchar(50) DEFAULT NULL COMMENT '身高',
  `health` varchar(50) DEFAULT NULL COMMENT '健康状况',
  `political` varchar(50) DEFAULT NULL COMMENT '政治面貌',
  `industry` varchar(50) DEFAULT NULL COMMENT '所在行业',
  `introducer` varchar(50) DEFAULT NULL COMMENT '介绍人',
  `select_marriage` tinyint(4) DEFAULT NULL COMMENT '婚姻 1已婚 2未婚',
  `contactphone` varchar(50) DEFAULT NULL COMMENT '联系电话',
  `mobile` varchar(50) DEFAULT NULL COMMENT '移动电话',
  `address` varchar(200) DEFAULT NULL COMMENT '家庭地址',
  `workaddress` varchar(200) DEFAULT NULL COMMENT '工作地址',
  `select_vip` tinyint(4) DEFAULT NULL COMMENT '是否会员 1 是',
  `vip_time` int(11) DEFAULT NULL COMMENT '入会时间',
  `vip_end` int(11) DEFAULT NULL COMMENT '会员到期时间',
  `vip_level` int(11) DEFAULT NULL COMMENT '会员等级',
  `vip_amount` float DEFAULT NULL COMMENT '会员金额',
  `vip_status` tinyint(4) DEFAULT NULL COMMENT '状态 1有效',
  `vip_addtime` int(11) DEFAULT NULL COMMENT '录入时间',
  `familynum` int(11) DEFAULT NULL COMMENT '家庭人数',
  `familyname` varchar(50) DEFAULT NULL COMMENT '家庭称谓',
  `familyarea` varchar(50) DEFAULT NULL COMMENT '家庭面积',
  `busroad` varchar(200) DEFAULT NULL COMMENT '公交路线',
  `otherdata` text COMMENT '其它监护人 json个数',
  `status` tinyint(4) DEFAULT NULL COMMENT '有效无效',
  `admin_id` tinyint(4) DEFAULT NULL,
  `dateline` int(11) DEFAULT NULL,
  PRIMARY KEY (`member_id`),
  KEY `user_no` (`member_no`),
  KEY `admin_id` (`admin_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='会员信息' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `hh_memberdevice`
--

CREATE TABLE IF NOT EXISTS `hh_memberdevice` (
  `device_id` int(11) NOT NULL AUTO_INCREMENT,
  `member_id` int(11) DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL,
  `imei` varchar(50) DEFAULT NULL,
  `admin_id` int(11) DEFAULT NULL,
  `dateline` int(11) DEFAULT NULL,
  PRIMARY KEY (`device_id`),
  KEY `member_id` (`member_id`),
  KEY `imei` (`imei`),
  KEY `admin_id` (`admin_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='用户的设备信息' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `hh_modelworker`
--

CREATE TABLE IF NOT EXISTS `hh_modelworker` (
  `worker_id` int(11) NOT NULL AUTO_INCREMENT,
  `member_id` int(11) DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL COMMENT '姓名:',
  `mobile` varchar(50) DEFAULT NULL COMMENT '手机号:',
  `address` varchar(200) DEFAULT NULL COMMENT '地址:',
  `nation` varchar(50) DEFAULT NULL COMMENT '民族:',
  `birthY` int(11) DEFAULT NULL COMMENT '出生年月:',
  `birthM` int(11) DEFAULT NULL COMMENT '出生年月:',
  `select_sex` tinyint(4) DEFAULT NULL,
  `otherdata` text COMMENT '获奖荣誉',
  `admin_id` int(11) DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL,
  `dateline` int(11) DEFAULT NULL,
  PRIMARY KEY (`worker_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='劳动模范' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `hh_older`
--

CREATE TABLE IF NOT EXISTS `hh_older` (
  `older_id` int(11) NOT NULL AUTO_INCREMENT,
  `member_id` int(11) DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL COMMENT '姓名:',
  `mobile` varchar(50) DEFAULT NULL COMMENT '手机号:',
  `address` varchar(200) DEFAULT NULL COMMENT '地址:',
  `nation` varchar(50) DEFAULT NULL COMMENT '民族:',
  `birthY` int(11) DEFAULT NULL COMMENT '出生年月:',
  `birthM` int(11) DEFAULT NULL COMMENT '出生年月:',
  `select_sex` tinyint(4) DEFAULT NULL,
  `isolder` varchar(50) DEFAULT NULL COMMENT '是否高龄',
  `admin_id` int(11) DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL,
  `dateline` int(11) DEFAULT NULL,
  PRIMARY KEY (`older_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='高龄老人' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `hh_optlog`
--

CREATE TABLE IF NOT EXISTS `hh_optlog` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tableid` int(11) NOT NULL DEFAULT '0',
  `tablename` varchar(50) DEFAULT '',
  `optid` int(11) DEFAULT '0' COMMENT '操作员',
  `opttype` tinyint(4) DEFAULT '1' COMMENT '1增加 2删除 3改',
  `after` text,
  `ip` varchar(50) DEFAULT '',
  `dateline` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='操作日志' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `hh_order`
--

CREATE TABLE IF NOT EXISTS `hh_order` (
  `order_id` int(11) NOT NULL AUTO_INCREMENT,
  `order_no` varchar(50) DEFAULT NULL COMMENT '工单编号:',
  `num` int(11) DEFAULT NULL,
  `item_id` int(11) DEFAULT NULL COMMENT '服务内容',
  `worker_id` int(11) DEFAULT NULL COMMENT '服务人员:',
  `customer_name` varchar(50) DEFAULT NULL COMMENT '客户姓名:',
  `customer_mobile` varchar(50) DEFAULT NULL COMMENT '联系方式',
  `price` float DEFAULT NULL COMMENT '下单金额:',
  `pay_type` varchar(50) DEFAULT NULL COMMENT '支付方式:',
  `agreement_begin` int(11) DEFAULT NULL COMMENT '合同开始日:',
  `agreement_end` int(11) DEFAULT NULL COMMENT '合同结束日:',
  `status` int(11) DEFAULT NULL COMMENT '订单状态:',
  `memo` varchar(200) DEFAULT NULL COMMENT '备注:',
  `comment` varchar(200) DEFAULT NULL COMMENT '评价:',
  `admin_id` int(11) DEFAULT NULL,
  `dateline` int(11) DEFAULT NULL,
  PRIMARY KEY (`order_id`),
  KEY `order_no` (`order_no`),
  KEY `admin_id` (`admin_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='订单' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `hh_psychologyadvice`
--

CREATE TABLE IF NOT EXISTS `hh_psychologyadvice` (
  `advice_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL COMMENT '客户姓名:',
  `mobile` varchar(50) DEFAULT NULL COMMENT '手机号:',
  `ask_type` varchar(50) DEFAULT NULL COMMENT '咨询类别:',
  `ask_cause` varchar(50) DEFAULT NULL COMMENT '咨询事由:',
  `ask_time` int(11) DEFAULT NULL COMMENT '咨询时间:',
  `worker_id` int(11) DEFAULT NULL COMMENT '心理咨询师:',
  `ask_result` varchar(200) DEFAULT NULL COMMENT '咨询结果:',
  `ask_num` int(11) DEFAULT NULL COMMENT '咨询次数:',
  `satisfy` varchar(50) DEFAULT NULL COMMENT '是否满意:',
  `admin_id` int(11) DEFAULT NULL,
  `dateline` int(11) DEFAULT NULL,
  PRIMARY KEY (`advice_id`),
  KEY `admin_id` (`admin_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='心理咨询记录' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `hh_sanwu`
--

CREATE TABLE IF NOT EXISTS `hh_sanwu` (
  `sanwu_id` int(11) NOT NULL AUTO_INCREMENT,
  `member_id` int(11) DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL COMMENT '姓名:',
  `mobile` varchar(50) DEFAULT NULL COMMENT '手机号:',
  `address` varchar(200) DEFAULT NULL COMMENT '地址:',
  `nation` varchar(50) DEFAULT NULL COMMENT '民族:',
  `birthY` int(11) DEFAULT NULL COMMENT '出生年月:',
  `birthM` int(11) DEFAULT NULL COMMENT '出生年月:',
  `select_sex` tinyint(4) DEFAULT NULL,
  `health` varchar(50) DEFAULT NULL COMMENT '身体状况',
  `low_premium` varchar(50) DEFAULT NULL COMMENT '城市低保金',
  `basic_money` varchar(50) DEFAULT NULL COMMENT '基本生活费	',
  `relief` varchar(50) DEFAULT NULL COMMENT '政府救济',
  `other` varchar(50) DEFAULT NULL COMMENT '其它经济收入',
  `provide_way` varchar(50) DEFAULT NULL COMMENT '供养方式',
  `service` varchar(50) DEFAULT NULL COMMENT '是否享受了政府购买养老服务制度',
  `flag` varchar(50) DEFAULT NULL COMMENT '类别',
  `admin_id` int(11) DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL,
  `dateline` int(11) DEFAULT NULL,
  PRIMARY KEY (`sanwu_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='三无老人' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `hh_service`
--

CREATE TABLE IF NOT EXISTS `hh_service` (
  `service_id` int(11) NOT NULL AUTO_INCREMENT,
  `service_no` varchar(50) DEFAULT NULL COMMENT '服务商编号:',
  `num` int(11) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL COMMENT '服务商名称:',
  `type_id` int(11) DEFAULT NULL COMMENT '服务类型:',
  `institution` varchar(100) DEFAULT NULL COMMENT '所属机构:',
  `license` varchar(50) DEFAULT NULL COMMENT '营业执照号码:',
  `legalperson` varchar(50) DEFAULT NULL COMMENT '法人姓名:',
  `contact` varchar(50) DEFAULT NULL COMMENT '联系人:',
  `mobile` varchar(50) DEFAULT NULL COMMENT '手机号码:',
  `address` varchar(200) DEFAULT NULL COMMENT '注册地址:',
  `contactaddress` varchar(50) DEFAULT NULL COMMENT '联系地址:',
  `agreement_begin` int(11) DEFAULT NULL COMMENT '合同开始日:',
  `agreement_end` int(11) DEFAULT NULL COMMENT '合同结束日:',
  `memo` varchar(200) DEFAULT NULL COMMENT '备注:',
  `status` int(11) DEFAULT NULL COMMENT '状态:',
  `admin_id` int(11) DEFAULT NULL,
  `dateline` int(11) DEFAULT NULL,
  PRIMARY KEY (`service_id`),
  KEY `service_no` (`service_no`),
  KEY `admin_id` (`admin_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='服务商' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `hh_serviceitem`
--

CREATE TABLE IF NOT EXISTS `hh_serviceitem` (
  `item_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL COMMENT '项目名称:',
  `type_id` int(11) DEFAULT NULL COMMENT '项目类型:',
  `content` varchar(200) DEFAULT NULL COMMENT '项目内容:',
  `price` float DEFAULT NULL COMMENT '价格:',
  `contact` varchar(50) DEFAULT NULL COMMENT '联系人:',
  `mobile` varchar(50) DEFAULT NULL COMMENT '手机号:',
  `service_id` int(11) DEFAULT NULL COMMENT '所属服务商:',
  `service_no` varchar(50) DEFAULT NULL COMMENT '服务商编号:',
  `address` varchar(100) DEFAULT NULL COMMENT '地址:',
  `organization` varchar(50) DEFAULT NULL COMMENT '组织机构:',
  `institution` varchar(50) DEFAULT NULL COMMENT '服务机构:',
  `memo` varchar(200) DEFAULT NULL COMMENT '备注:',
  `unit` varchar(50) DEFAULT NULL COMMENT '单位:',
  `status` int(11) DEFAULT NULL,
  `admin_id` int(11) DEFAULT NULL,
  `dateline` int(11) DEFAULT NULL,
  PRIMARY KEY (`item_id`),
  KEY `admin_id` (`admin_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='项目名称' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `hh_servicetype`
--

CREATE TABLE IF NOT EXISTS `hh_servicetype` (
  `type_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL,
  `admin_id` int(11) DEFAULT NULL,
  `dateline` int(11) DEFAULT NULL,
  PRIMARY KEY (`type_id`),
  KEY `admin_id` (`admin_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='服务类型' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `hh_student`
--

CREATE TABLE IF NOT EXISTS `hh_student` (
  `student_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL COMMENT '学员姓名',
  `mobile` varchar(50) DEFAULT NULL COMMENT '学员电话',
  `isjiaofei` tinyint(4) DEFAULT NULL COMMENT '是否缴费 1缴费',
  `course_id` int(11) DEFAULT NULL COMMENT '所在班级:',
  `addtime` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `admin_id` int(11) DEFAULT NULL,
  `dateline` int(11) DEFAULT NULL,
  PRIMARY KEY (`student_id`),
  KEY `admin_id` (`admin_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='学员管理' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `hh_system_config`
--

CREATE TABLE IF NOT EXISTS `hh_system_config` (
  `k` varchar(30) NOT NULL,
  `v` mediumtext,
  `title` varchar(30) DEFAULT '',
  `dateline` int(10) DEFAULT NULL,
  PRIMARY KEY (`k`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `hh_travel`
--

CREATE TABLE IF NOT EXISTS `hh_travel` (
  `travel_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL COMMENT '线路名称:',
  `destination` varchar(50) DEFAULT NULL COMMENT '目的地:',
  `pricememo` varchar(50) DEFAULT NULL COMMENT '费用说明:',
  `traffic` varchar(50) DEFAULT NULL COMMENT '交通工具:',
  `day` int(11) DEFAULT NULL COMMENT '出行天数:',
  `outtime` int(11) DEFAULT NULL COMMENT '出发时间:',
  `introduce` int(11) DEFAULT NULL COMMENT '景点介绍:',
  `line_provider` varchar(50) DEFAULT NULL COMMENT '线路提供方:',
  `line_do` varchar(50) DEFAULT NULL COMMENT '线路实施方:',
  `go_time` int(11) DEFAULT NULL COMMENT '发团次数:',
  `go_num` int(11) DEFAULT NULL COMMENT '出行人数:',
  `status` int(11) DEFAULT NULL COMMENT '是否有效:',
  `admin_id` int(11) DEFAULT NULL,
  `dateline` int(11) DEFAULT NULL,
  PRIMARY KEY (`travel_id`),
  KEY `admin_id` (`admin_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='旅游管理' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `hh_travelcorp`
--

CREATE TABLE IF NOT EXISTS `hh_travelcorp` (
  `corp_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL COMMENT '线路名称:',
  `destination` varchar(50) DEFAULT NULL COMMENT '目的地:',
  `pricememo` varchar(50) DEFAULT NULL COMMENT '费用说明:',
  `traffic` varchar(50) DEFAULT NULL COMMENT '交通工具:',
  `day` int(11) DEFAULT NULL COMMENT '出行天数:',
  `outtime` int(11) DEFAULT NULL COMMENT '出发时间:',
  `introduce` int(11) DEFAULT NULL COMMENT '景点介绍:',
  `line_provider` varchar(50) DEFAULT NULL COMMENT '线路提供方:',
  `line_do` varchar(50) DEFAULT NULL COMMENT '线路实施方:',
  `go_time` int(11) DEFAULT NULL COMMENT '发团次数:',
  `go_num` int(11) DEFAULT NULL COMMENT '出行人数:',
  `status` int(11) DEFAULT NULL COMMENT '是否有效:',
  `admin_id` int(11) DEFAULT NULL,
  `dateline` int(11) DEFAULT NULL,
  PRIMARY KEY (`corp_id`),
  KEY `admin_id` (`admin_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='旅游合作' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `hh_travelline`
--

CREATE TABLE IF NOT EXISTS `hh_travelline` (
  `line_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL COMMENT '线路名称:',
  `destination` varchar(50) DEFAULT NULL COMMENT '目的地:',
  `pricememo` varchar(50) DEFAULT NULL COMMENT '费用说明:',
  `traffic` varchar(50) DEFAULT NULL COMMENT '交通工具:',
  `day` int(11) DEFAULT NULL COMMENT '出行天数:',
  `outtime` int(11) DEFAULT NULL COMMENT '出发时间:',
  `introduce` int(11) DEFAULT NULL COMMENT '景点介绍:',
  `line_provider` varchar(50) DEFAULT NULL COMMENT '线路提供方:',
  `line_do` varchar(50) DEFAULT NULL COMMENT '线路实施方:',
  `go_time` int(11) DEFAULT NULL COMMENT '发团次数:',
  `go_num` int(11) DEFAULT NULL COMMENT '出行人数:',
  `status` int(11) DEFAULT NULL COMMENT '是否有效:',
  `admin_id` int(11) DEFAULT NULL,
  `dateline` int(11) DEFAULT NULL,
  PRIMARY KEY (`line_id`),
  KEY `admin_id` (`admin_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='旅游线路' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `hh_veteran`
--

CREATE TABLE IF NOT EXISTS `hh_veteran` (
  `veteran_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL COMMENT '姓名:',
  `mobile` varchar(50) DEFAULT NULL COMMENT '手机号:',
  `address` varchar(200) DEFAULT NULL COMMENT '地址:',
  `nation` varchar(50) DEFAULT NULL COMMENT '民族:',
  `birthY` int(11) DEFAULT NULL COMMENT '出生年月:',
  `birthM` int(11) DEFAULT NULL COMMENT '出生年月:',
  `select_sex` tinyint(4) DEFAULT NULL,
  `educational` varchar(50) DEFAULT NULL COMMENT '学历:',
  `school` varchar(50) DEFAULT NULL COMMENT '毕业院校:',
  `profession` varchar(50) DEFAULT NULL COMMENT '所学专业:',
  `graduate` varchar(50) DEFAULT NULL COMMENT '毕业时间:',
  `birthplace` varchar(50) DEFAULT NULL COMMENT '户籍所在地:',
  `select_marriage` tinyint(4) DEFAULT NULL COMMENT '婚姻状况:',
  `jointime` varchar(50) DEFAULT NULL COMMENT '入伍时间:',
  `veterantime` varchar(50) DEFAULT NULL COMMENT '退伍时间:',
  `reward` varchar(50) DEFAULT NULL COMMENT '受过奖励:',
  `army` varchar(50) DEFAULT NULL COMMENT '服役部队:',
  `health` varchar(50) DEFAULT NULL COMMENT '身体状况:',
  `rewardmoney` varchar(50) DEFAULT NULL COMMENT '退伍优待金:',
  `helpmoney` varchar(50) DEFAULT NULL COMMENT '医疗补助金:',
  `work_status` varchar(50) DEFAULT NULL COMMENT '工作状况:',
  `political` varchar(50) DEFAULT NULL COMMENT '政治面貌:',
  `admin_id` int(11) DEFAULT NULL,
  `status` tinyint(4) DEFAULT '1',
  `dateline` int(11) DEFAULT NULL,
  PRIMARY KEY (`veteran_id`),
  KEY `admin_id` (`admin_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='退伍军人数据' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `hh_volunteeradvice`
--

CREATE TABLE IF NOT EXISTS `hh_volunteeradvice` (
  `advice_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL COMMENT '客户姓名:',
  `mobile` varchar(50) DEFAULT NULL COMMENT '手机号:',
  `ask_type` varchar(50) DEFAULT NULL COMMENT '服务类别:',
  `ask_cause` varchar(200) DEFAULT NULL COMMENT '服务事由:',
  `ask_time` int(11) DEFAULT NULL COMMENT '服务时间:',
  `worker_id` int(11) DEFAULT NULL COMMENT '志愿者:',
  `ask_result` varchar(200) DEFAULT NULL COMMENT '服务结果:',
  `ask_num` int(11) DEFAULT NULL COMMENT '服务次数:',
  `satisfy` varchar(50) DEFAULT NULL COMMENT '是否满意:',
  `admin_id` varchar(50) DEFAULT NULL,
  `dateline` int(11) DEFAULT NULL,
  PRIMARY KEY (`advice_id`),
  KEY `admin_id` (`admin_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='服务记录' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `hh_worker`
--

CREATE TABLE IF NOT EXISTS `hh_worker` (
  `worker_id` int(11) NOT NULL AUTO_INCREMENT,
  `service_id` int(11) DEFAULT NULL COMMENT '所属服务商:',
  `type_id` int(11) DEFAULT NULL COMMENT '服务类型',
  `role_id` int(11) DEFAULT NULL COMMENT '服务角色',
  `code` varchar(10) DEFAULT '',
  `worker_no` varchar(50) DEFAULT NULL COMMENT '编号:',
  `num` int(11) DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL COMMENT '姓名:',
  `birthY` int(11) DEFAULT NULL COMMENT '出生年',
  `birthM` int(11) DEFAULT NULL COMMENT '出生月',
  `select_sex` tinyint(4) DEFAULT NULL COMMENT '性别:',
  `nation` varchar(50) DEFAULT NULL COMMENT '民族:',
  `select_bloodType` varchar(50) DEFAULT NULL COMMENT '血型:',
  `idcard` varchar(50) DEFAULT NULL COMMENT '身份证号:',
  `birthplace` varchar(50) DEFAULT NULL COMMENT '籍贯:',
  `select_marriage` int(11) DEFAULT NULL COMMENT '婚姻:',
  `nowaddress` varchar(100) DEFAULT NULL COMMENT '现居住地址:',
  `political` varchar(50) DEFAULT NULL COMMENT '政治面貌:',
  `educational` varchar(50) DEFAULT NULL COMMENT '学历:',
  `health` varchar(50) DEFAULT NULL COMMENT '健康状况:',
  `height` varchar(50) DEFAULT NULL COMMENT '身高:',
  `mobile` varchar(50) DEFAULT NULL COMMENT '手机号:',
  `contactphone` varchar(50) DEFAULT NULL COMMENT '座机电话:',
  `agreement_begin` int(11) DEFAULT NULL COMMENT '合同开始日:',
  `agreement_end` int(11) DEFAULT NULL COMMENT '合同结束日:',
  `certificate` varchar(100) DEFAULT NULL COMMENT '资质证书',
  `department` varchar(50) DEFAULT NULL COMMENT '部门:',
  `technicaltitle` varchar(50) DEFAULT NULL COMMENT '岗位:',
  `select_grade` int(11) DEFAULT NULL COMMENT '级别:',
  `work_status` int(11) DEFAULT NULL COMMENT '工作状态:',
  `secure_type` varchar(50) DEFAULT NULL COMMENT '保险类型:',
  `secure_company` varchar(50) DEFAULT NULL COMMENT '参保公司:',
  `secure_date` int(11) DEFAULT NULL COMMENT '保险日期:',
  `status` tinyint(4) DEFAULT NULL COMMENT '状态:',
  `comment` varchar(200) DEFAULT NULL COMMENT '评价:',
  `memo` varchar(200) DEFAULT NULL COMMENT '备注:',
  `admin_id` int(11) DEFAULT NULL,
  `dateline` int(11) DEFAULT NULL,
  PRIMARY KEY (`worker_id`),
  KEY `code` (`code`),
  KEY `admin_id` (`admin_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='员工信息' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `hh_workerrole`
--

CREATE TABLE IF NOT EXISTS `hh_workerrole` (
  `role_id` int(11) NOT NULL AUTO_INCREMENT,
  `type_id` int(11) NOT NULL DEFAULT '0',
  `name` varchar(50) DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL,
  `admin_id` int(11) DEFAULT NULL,
  `dateline` int(11) DEFAULT NULL,
  PRIMARY KEY (`role_id`),
  KEY `admin_id` (`admin_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='员工服务角色' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `hh_workertype`
--

CREATE TABLE IF NOT EXISTS `hh_workertype` (
  `type_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `code` varchar(50) DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL,
  `admin_id` int(11) DEFAULT NULL,
  `dateline` int(11) DEFAULT NULL,
  PRIMARY KEY (`type_id`),
  KEY `admin_id` (`admin_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='员工服务类型' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `hh_zhengxie`
--

CREATE TABLE IF NOT EXISTS `hh_zhengxie` (
  `zhengxie_id` int(11) NOT NULL AUTO_INCREMENT,
  `member_id` int(11) DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL COMMENT '姓名:',
  `mobile` varchar(50) DEFAULT NULL COMMENT '手机号:',
  `address` varchar(200) DEFAULT NULL COMMENT '地址:',
  `nation` varchar(50) DEFAULT NULL COMMENT '民族:',
  `birthY` int(11) DEFAULT NULL COMMENT '出生年月:',
  `birthM` int(11) DEFAULT NULL COMMENT '出生年月:',
  `select_sex` tinyint(4) DEFAULT NULL,
  `zhiwu` varchar(100) DEFAULT NULL COMMENT '主要社会职务',
  `biaoxian` varchar(100) DEFAULT NULL COMMENT '主要表现',
  `chengjiu` varchar(100) DEFAULT NULL COMMENT '主要成就',
  `admin_id` int(11) DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL,
  `dateline` int(11) DEFAULT NULL,
  PRIMARY KEY (`zhengxie_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='退休政协委员' AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
