-- phpMyAdmin SQL Dump
-- version 4.3.11.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: 2016-03-09 10:37:53
-- 服务器版本： 5.5.41-0ubuntu0.14.04.1
-- PHP Version: 5.5.9-1ubuntu4.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `webstore`
--

-- --------------------------------------------------------

--
-- 表的结构 `cms_cms`
--

CREATE TABLE IF NOT EXISTS `cms_cms` (
  `id` int(11) NOT NULL,
  `catid` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '栏目id',
  `typeid` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '类别id',
  `title` varchar(80) DEFAULT NULL COMMENT '标题',
  `style` varchar(256) DEFAULT NULL COMMENT '样式',
  `thumb` varchar(100) DEFAULT NULL COMMENT '缩略图',
  `keywords` varchar(80) DEFAULT NULL COMMENT '关键字',
  `template` text NOT NULL,
  `layout` varchar(50) NOT NULL,
  `view` varchar(50) NOT NULL,
  `desc` varchar(500) NOT NULL,
  `url` varchar(100) DEFAULT NULL COMMENT '链接地址',
  `is_cache` tinyint(1) NOT NULL,
  `is_release` tinyint(1) NOT NULL,
  `activity` varchar(50) NOT NULL,
  `search_url` varchar(200) NOT NULL,
  `is_static` tinyint(1) NOT NULL,
  `time` int(11) NOT NULL,
  `username` varchar(20) DEFAULT NULL COMMENT '用户名',
  `userid` int(11) DEFAULT NULL COMMENT '用户id',
  `created` int(10) DEFAULT NULL COMMENT '创建时间',
  `updated` int(10) DEFAULT NULL COMMENT '更新时间',
  `status` tinyint(3) NOT NULL,
  `platform` tinyint(3) NOT NULL DEFAULT '1' COMMENT '平台（1PC,2移动）',
  `seo_title` varchar(200) DEFAULT NULL,
  `seo_keywords` varchar(1000) DEFAULT NULL,
  `seo_description` text
) ENGINE=InnoDB AUTO_INCREMENT=324 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `cms_cms`
--

INSERT INTO `cms_cms` (`id`, `catid`, `typeid`, `title`, `style`, `thumb`, `keywords`, `template`, `layout`, `view`, `desc`, `url`, `is_cache`, `is_release`, `activity`, `search_url`, `is_static`, `time`, `username`, `userid`, `created`, `updated`, `status`, `platform`, `seo_title`, `seo_keywords`, `seo_description`) VALUES
(321, 0, 0, 'test', NULL, NULL, NULL, 'gggaaaaaaaaa', 'main', 'test', 'test', NULL, 0, 0, 'a1', '', 0, 1457488739, NULL, NULL, NULL, NULL, 0, 1, '', '', ''),
(322, 0, 0, NULL, NULL, NULL, NULL, '1111ttttxxxxxxxxxxxxxx', 'main', 'testttxxx', 'testxxxxx', NULL, 0, 0, 'a1', '', 0, 1457489149, NULL, NULL, NULL, NULL, 0, 1, '', '', ''),
(323, 0, 0, NULL, NULL, NULL, NULL, 'aaaa', 'main', 'aaa', 'aaa', NULL, 0, 0, 'a1', '', 0, 1457489157, NULL, NULL, NULL, NULL, 0, 1, '', '', '');

-- --------------------------------------------------------

--
-- 表的结构 `cms_history`
--

CREATE TABLE IF NOT EXISTS `cms_history` (
  `id` int(11) NOT NULL,
  `cms_id` int(11) NOT NULL,
  `template` text NOT NULL,
  `layout` varchar(50) NOT NULL,
  `view` varchar(50) NOT NULL,
  `activity` varchar(50) NOT NULL,
  `search_url` varchar(200) NOT NULL,
  `desc` varchar(500) NOT NULL,
  `time` int(11) NOT NULL,
  `platform` tinyint(3) NOT NULL DEFAULT '1' COMMENT '平台（1PC,2移动）',
  `seo_title` varchar(200) DEFAULT NULL,
  `seo_keywords` varchar(200) DEFAULT NULL,
  `seo_description` text
) ENGINE=InnoDB AUTO_INCREMENT=1724 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `cms_release`
--

CREATE TABLE IF NOT EXISTS `cms_release` (
  `id` int(11) NOT NULL,
  `catid` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '栏目id',
  `typeid` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '类别id',
  `title` varchar(80) DEFAULT NULL COMMENT '标题',
  `style` varchar(256) DEFAULT NULL COMMENT '样式',
  `thumb` varchar(100) DEFAULT NULL COMMENT '缩略图',
  `keywords` varchar(80) DEFAULT NULL COMMENT '关键字',
  `template` text NOT NULL,
  `layout` varchar(50) NOT NULL,
  `view` varchar(50) NOT NULL,
  `desc` varchar(500) NOT NULL,
  `url` varchar(100) DEFAULT NULL COMMENT '链接地址',
  `is_cache` tinyint(1) NOT NULL,
  `is_release` tinyint(1) NOT NULL,
  `activity` varchar(50) NOT NULL,
  `search_url` varchar(200) NOT NULL,
  `is_static` tinyint(1) NOT NULL,
  `time` int(11) NOT NULL,
  `username` varchar(20) DEFAULT NULL COMMENT '用户名',
  `userid` int(11) DEFAULT NULL COMMENT '用户id',
  `created` int(10) DEFAULT NULL COMMENT '创建时间',
  `updated` int(10) DEFAULT NULL COMMENT '更新时间',
  `status` tinyint(3) NOT NULL,
  `platform` tinyint(3) NOT NULL DEFAULT '1' COMMENT '平台（1PC,2移动）',
  `seo_title` varchar(200) DEFAULT NULL,
  `seo_keywords` varchar(200) DEFAULT NULL,
  `seo_description` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `cms_user`
--

CREATE TABLE IF NOT EXISTS `cms_user` (
  `id` int(11) unsigned NOT NULL,
  `username` varchar(64) NOT NULL,
  `password_hash` varchar(64) NOT NULL,
  `password_reset_token` varchar(64) NOT NULL,
  `email` varchar(100) NOT NULL,
  `auth_key` varchar(100) NOT NULL,
  `status` int(11) NOT NULL,
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `cms_user`
--

INSERT INTO `cms_user` (`id`, `username`, `password_hash`, `password_reset_token`, `email`, `auth_key`, `status`, `created_at`, `updated_at`) VALUES
(2, 'admin', '$2y$13$PUe5YCZwHTp0yTFZtK8bF.DeauDEblAqU8ChB2HGyxr2XRVOX3nOS', '111', '111', '11', 10, 11, 11);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cms_cms`
--
ALTER TABLE `cms_cms`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cms_history`
--
ALTER TABLE `cms_history`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cms_release`
--
ALTER TABLE `cms_release`
  ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `view` (`view`);

--
-- Indexes for table `cms_user`
--
ALTER TABLE `cms_user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cms_cms`
--
ALTER TABLE `cms_cms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=324;
--
-- AUTO_INCREMENT for table `cms_history`
--
ALTER TABLE `cms_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1724;
--
-- AUTO_INCREMENT for table `cms_user`
--
ALTER TABLE `cms_user`
  MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
