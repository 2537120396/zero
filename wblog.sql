-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: 2017-10-03 14:51:25
-- 服务器版本： 5.7.12-log
-- PHP Version: 7.0.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `wblog`
--

-- --------------------------------------------------------

--
-- 表的结构 `admin`
--

CREATE TABLE `admin` (
  `adminid` int(11) NOT NULL,
  `adminname` char(10) NOT NULL DEFAULT '',
  `adminpassword` char(35) NOT NULL DEFAULT '',
  `adminsalt` varchar(10) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `admin`
--

INSERT INTO `admin` (`adminid`, `adminname`, `adminpassword`, `adminsalt`) VALUES
(1, 'admin', 'bdd8cf979362bba46cfe326e853467e6', 'l,%*?vx^');

-- --------------------------------------------------------

--
-- 表的结构 `arts`
--

CREATE TABLE `arts` (
  `art_id` int(11) NOT NULL COMMENT '文章序号，自增',
  `title` varchar(20) NOT NULL DEFAULT '' COMMENT '文章标题',
  `pic` varchar(100) NOT NULL DEFAULT '' COMMENT '文章图片',
  `thumb` varchar(100) NOT NULL DEFAULT '' COMMENT '缩略图',
  `info` varchar(50) NOT NULL DEFAULT '' COMMENT '文章简介',
  `comnum` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '评论数',
  `clicknum` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '点击数',
  `update_time` int(11) NOT NULL DEFAULT '0' COMMENT '最后修改的时间戳',
  `cat_id` int(11) NOT NULL DEFAULT '0' COMMENT '分类序号'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='文章表';

-- --------------------------------------------------------

--
-- 表的结构 `cats`
--

CREATE TABLE `cats` (
  `cat_id` int(10) UNSIGNED NOT NULL COMMENT '分类序号，自增',
  `cat_name` char(10) NOT NULL DEFAULT '' COMMENT '分类名称',
  `num` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '分类下的直接文章数',
  `pid` int(11) UNSIGNED NOT NULL DEFAULT '0' COMMENT '该分类下上级分类序号'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='文章分类';

--
-- 转存表中的数据 `cats`
--

INSERT INTO `cats` (`cat_id`, `cat_name`, `num`, `pid`) VALUES
(1, '成长之路', 0, 0),
(2, '日常杂谈', 0, 0),
(3, '其他', 0, 0),
(4, 'php', 0, 1),
(5, 'html,css', 0, 1),
(6, 'js', 0, 1),
(7, 'linux', 0, 1),
(8, '我的兴趣', 0, 2),
(9, '杂谈', 0, 2),
(10, '转载', 0, 3),
(11, '其他方面', 0, 1);

-- --------------------------------------------------------

--
-- 表的结构 `comment`
--

CREATE TABLE `comment` (
  `com_id` int(11) NOT NULL COMMENT '评论序号，主键，自增',
  `comment` varchar(100) NOT NULL DEFAULT '' COMMENT '评论',
  `art_id` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '文章序号',
  `user_id` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '用户id',
  `num` int(11) NOT NULL DEFAULT '0',
  `create_time` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '最后修改的时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `compic`
--

CREATE TABLE `compic` (
  `pid` int(10) UNSIGNED NOT NULL,
  `pic` varchar(50) NOT NULL DEFAULT '',
  `com_id` int(10) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `contents`
--

CREATE TABLE `contents` (
  `con_id` int(10) UNSIGNED NOT NULL COMMENT '主键，自增',
  `content` text NOT NULL COMMENT '文章内容',
  `art_id` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '文章序号'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='文章内容';

-- --------------------------------------------------------

--
-- 表的结构 `cv`
--

CREATE TABLE `cv` (
  `cid` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `comment` varchar(100) NOT NULL DEFAULT '',
  `create_time` int(10) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `history`
--

CREATE TABLE `history` (
  `hid` int(10) UNSIGNED NOT NULL,
  `art_id` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `user_id` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `update_time` int(10) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `keywords`
--

CREATE TABLE `keywords` (
  `key_id` int(11) NOT NULL COMMENT '关键词序号，自增',
  `keyword` varchar(10) NOT NULL DEFAULT '' COMMENT '关键词',
  `art_id` int(11) NOT NULL DEFAULT '0' COMMENT '所属文章序号'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='关键词';

-- --------------------------------------------------------

--
-- 表的结构 `msg`
--

CREATE TABLE `msg` (
  `mid` int(11) NOT NULL,
  `msg` varchar(100) NOT NULL DEFAULT '',
  `user_id` int(11) NOT NULL DEFAULT '0',
  `art_id` int(11) NOT NULL DEFAULT '0',
  `uid` int(11) NOT NULL DEFAULT '0',
  `update_time` int(11) NOT NULL DEFAULT '0',
  `tag` enum('0','1') NOT NULL DEFAULT '1',
  `com_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `record`
--

CREATE TABLE `record` (
  `rid` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `art_id` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `update_time` int(10) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `record`
--

INSERT INTO `record` (`rid`, `user_id`, `art_id`, `update_time`) VALUES
(1, 0, 1, 1507041886),
(2, 0, 1, 1507041957);

-- --------------------------------------------------------

--
-- 表的结构 `user`
--

CREATE TABLE `user` (
  `user_id` int(10) UNSIGNED NOT NULL,
  `user_name` varchar(10) NOT NULL DEFAULT '',
  `password` char(35) NOT NULL DEFAULT '',
  `head_portrait` varchar(50) NOT NULL DEFAULT 'i.jpg',
  `tel` char(11) NOT NULL DEFAULT '',
  `email` varchar(30) DEFAULT '',
  `last_login_time` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `getpasstime` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `ip` char(20) NOT NULL DEFAULT '',
  `salt` char(8) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`adminid`);

--
-- Indexes for table `arts`
--
ALTER TABLE `arts`
  ADD PRIMARY KEY (`art_id`);

--
-- Indexes for table `cats`
--
ALTER TABLE `cats`
  ADD PRIMARY KEY (`cat_id`);

--
-- Indexes for table `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`com_id`);

--
-- Indexes for table `compic`
--
ALTER TABLE `compic`
  ADD PRIMARY KEY (`pid`);

--
-- Indexes for table `contents`
--
ALTER TABLE `contents`
  ADD PRIMARY KEY (`con_id`),
  ADD KEY `con` (`art_id`);

--
-- Indexes for table `cv`
--
ALTER TABLE `cv`
  ADD PRIMARY KEY (`cid`);

--
-- Indexes for table `history`
--
ALTER TABLE `history`
  ADD PRIMARY KEY (`hid`),
  ADD KEY `id` (`art_id`,`user_id`);

--
-- Indexes for table `keywords`
--
ALTER TABLE `keywords`
  ADD PRIMARY KEY (`key_id`),
  ADD KEY `art_id` (`art_id`);

--
-- Indexes for table `msg`
--
ALTER TABLE `msg`
  ADD PRIMARY KEY (`mid`),
  ADD KEY `id` (`user_id`,`uid`),
  ADD KEY `com_id` (`com_id`);

--
-- Indexes for table `record`
--
ALTER TABLE `record`
  ADD PRIMARY KEY (`rid`),
  ADD KEY `id` (`user_id`,`art_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`);

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `admin`
--
ALTER TABLE `admin`
  MODIFY `adminid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- 使用表AUTO_INCREMENT `arts`
--
ALTER TABLE `arts`
  MODIFY `art_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '文章序号，自增';

--
-- 使用表AUTO_INCREMENT `cats`
--
ALTER TABLE `cats`
  MODIFY `cat_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '分类序号，自增', AUTO_INCREMENT=12;

--
-- 使用表AUTO_INCREMENT `comment`
--
ALTER TABLE `comment`
  MODIFY `com_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '评论序号，主键，自增';

--
-- 使用表AUTO_INCREMENT `compic`
--
ALTER TABLE `compic`
  MODIFY `pid` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `contents`
--
ALTER TABLE `contents`
  MODIFY `con_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '主键，自增';

--
-- 使用表AUTO_INCREMENT `cv`
--
ALTER TABLE `cv`
  MODIFY `cid` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `history`
--
ALTER TABLE `history`
  MODIFY `hid` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `keywords`
--
ALTER TABLE `keywords`
  MODIFY `key_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '关键词序号，自增';

--
-- 使用表AUTO_INCREMENT `msg`
--
ALTER TABLE `msg`
  MODIFY `mid` int(11) NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `record`
--
ALTER TABLE `record`
  MODIFY `rid` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- 使用表AUTO_INCREMENT `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
