-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- 主机： localhost
-- 生成日期： 2023-09-19 19:29:23
-- 服务器版本： 5.7.41-log
-- PHP 版本： 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 数据库： `pwd_b2cc_top`
--

-- --------------------------------------------------------

--
-- 表的结构 `lxy_admins`
--

CREATE TABLE `lxy_admins` (
  `id` int(11) UNSIGNED NOT NULL COMMENT '管理员ID',
  `account` char(50) NOT NULL COMMENT '管理员账号',
  `password` char(100) NOT NULL COMMENT '管理员密码',
  `status` tinyint(1) UNSIGNED NOT NULL DEFAULT '1' COMMENT '状态 0 禁用',
  `sid` char(32) DEFAULT NULL COMMENT '登录SID',
  `create_time` int(11) UNSIGNED NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(11) UNSIGNED NOT NULL DEFAULT '0' COMMENT '更新时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='管理员列表' ROW_FORMAT=COMPACT;

--
-- 转存表中的数据 `lxy_admins`
--

INSERT INTO `lxy_admins` (`id`, `account`, `password`, `status`, `sid`, `create_time`, `update_time`) VALUES
(1, 'admin', 'fcea920f7412b5da7be0cf42b8c93759', 0, '4aa6dcd8c21cba829a09fba355bf2bf3', 0, 1695120770);

-- --------------------------------------------------------

--
-- 表的结构 `lxy_admin_logs`
--

CREATE TABLE `lxy_admin_logs` (
  `id` int(11) UNSIGNED NOT NULL COMMENT '日志ID',
  `admin_id` int(11) UNSIGNED NOT NULL DEFAULT '0' COMMENT '管理员ID',
  `action` char(10) NOT NULL DEFAULT '无' COMMENT '行为',
  `url` varchar(200) DEFAULT NULL COMMENT '提交地址',
  `data` text COMMENT '提交数据',
  `remark` varchar(255) NOT NULL DEFAULT '无' COMMENT '行为描述',
  `ip` char(15) NOT NULL DEFAULT '0.0.0.0' COMMENT '操作IP',
  `create_time` int(11) UNSIGNED NOT NULL DEFAULT '0' COMMENT '创建时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='管理员日志表' ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- 表的结构 `lxy_configs`
--

CREATE TABLE `lxy_configs` (
  `key` varchar(128) NOT NULL COMMENT '配置键名称',
  `value` text CHARACTER SET utf8mb4 NOT NULL COMMENT '配置内容'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

--
-- 转存表中的数据 `lxy_configs`
--

INSERT INTO `lxy_configs` (`key`, `value`) VALUES
('web_name', 'Lxy密码本'),
('title', '您的贴身密码管家！'),
('description', 'Lxy密码本是您的贴身密码管家！'),
('keywords', 'Lxy，密码本'),
('notice', '<p><b><font color=\"#f9963b\">本程序为开源程序，使用者造成的一切法律后果与作者无关。</font></b></p>');

-- --------------------------------------------------------

--
-- 表的结构 `lxy_notice`
--

CREATE TABLE `lxy_notice` (
  `id` int(11) UNSIGNED NOT NULL COMMENT 'ID',
  `title` text NOT NULL COMMENT '标题',
  `content` varchar(255) NOT NULL COMMENT '内容',
  `create_time` int(11) UNSIGNED NOT NULL DEFAULT '0' COMMENT '添加时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='公告表' ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- 表的结构 `lxy_pwd`
--

CREATE TABLE `lxy_pwd` (
  `id` int(11) UNSIGNED NOT NULL COMMENT 'ID',
  `uid` int(11) UNSIGNED NOT NULL COMMENT '用户ID',
  `title` text NOT NULL COMMENT '标题',
  `desc` varchar(255) NOT NULL COMMENT '描述',
  `username` varchar(60) NOT NULL COMMENT '用户名',
  `password` text NOT NULL COMMENT '密码',
  `weburl` varchar(60) NOT NULL COMMENT '网址',
  `create_time` int(11) UNSIGNED NOT NULL DEFAULT '0' COMMENT '添加时间',
  `update_time` int(11) UNSIGNED NOT NULL DEFAULT '0' COMMENT '更新数据时间',
  `status` tinyint(1) UNSIGNED NOT NULL DEFAULT '0' COMMENT '状态'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='密码本表' ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- 表的结构 `lxy_users`
--

CREATE TABLE `lxy_users` (
  `id` int(11) UNSIGNED NOT NULL COMMENT '用户ID',
  `account` varchar(80) NOT NULL COMMENT '用户名',
  `password` varchar(100) NOT NULL COMMENT '用户密码',
  `qq` char(12) DEFAULT NULL COMMENT '绑定qq',
  `reg_ip` char(15) NOT NULL DEFAULT '0.0.0.0' COMMENT '注册IP',
  `status` tinyint(1) UNSIGNED NOT NULL DEFAULT '0' COMMENT '状态',
  `sid` char(32) DEFAULT NULL COMMENT '登录SID',
  `create_time` int(11) UNSIGNED NOT NULL DEFAULT '0' COMMENT '注册时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户账号表' ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- 表的结构 `lxy_user_logs`
--

CREATE TABLE `lxy_user_logs` (
  `id` int(11) UNSIGNED NOT NULL COMMENT '日志ID',
  `user_id` int(11) UNSIGNED NOT NULL DEFAULT '0' COMMENT '用户ID',
  `action` char(10) NOT NULL DEFAULT '无' COMMENT '行为',
  `remark` varchar(255) NOT NULL DEFAULT '无' COMMENT '行为描述',
  `ip` char(15) NOT NULL DEFAULT '0.0.0.0' COMMENT '操作IP',
  `create_time` int(11) UNSIGNED NOT NULL DEFAULT '0' COMMENT '创建时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户行为日志表' ROW_FORMAT=COMPACT;

--
-- 转储表的索引
--

--
-- 表的索引 `lxy_admins`
--
ALTER TABLE `lxy_admins`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD UNIQUE KEY `id` (`id`) USING BTREE,
  ADD KEY `login` (`account`,`password`) USING BTREE;

--
-- 表的索引 `lxy_admin_logs`
--
ALTER TABLE `lxy_admin_logs`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD KEY `admin_id` (`admin_id`) USING BTREE;

--
-- 表的索引 `lxy_configs`
--
ALTER TABLE `lxy_configs`
  ADD UNIQUE KEY `key` (`key`) USING BTREE;

--
-- 表的索引 `lxy_notice`
--
ALTER TABLE `lxy_notice`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD UNIQUE KEY `id` (`id`) USING BTREE,
  ADD KEY `content` (`content`) USING BTREE,
  ADD KEY `create_time` (`create_time`) USING BTREE;

--
-- 表的索引 `lxy_pwd`
--
ALTER TABLE `lxy_pwd`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD UNIQUE KEY `id` (`id`) USING BTREE,
  ADD KEY `uid` (`uid`) USING BTREE,
  ADD KEY `username` (`username`) USING BTREE,
  ADD KEY `desc` (`desc`) USING BTREE,
  ADD KEY `weburl` (`weburl`) USING BTREE,
  ADD KEY `create_time` (`create_time`) USING BTREE;

--
-- 表的索引 `lxy_users`
--
ALTER TABLE `lxy_users`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD UNIQUE KEY `id` (`id`) USING BTREE,
  ADD UNIQUE KEY `phone` (`qq`) USING BTREE,
  ADD KEY `account` (`account`) USING BTREE,
  ADD KEY `reg_ip` (`reg_ip`) USING BTREE,
  ADD KEY `create_time` (`create_time`) USING BTREE;

--
-- 表的索引 `lxy_user_logs`
--
ALTER TABLE `lxy_user_logs`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD KEY `user_id` (`user_id`) USING BTREE;

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `lxy_admins`
--
ALTER TABLE `lxy_admins`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '管理员ID', AUTO_INCREMENT=2;

--
-- 使用表AUTO_INCREMENT `lxy_admin_logs`
--
ALTER TABLE `lxy_admin_logs`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '日志ID';

--
-- 使用表AUTO_INCREMENT `lxy_notice`
--
ALTER TABLE `lxy_notice`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'ID';

--
-- 使用表AUTO_INCREMENT `lxy_pwd`
--
ALTER TABLE `lxy_pwd`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'ID';

--
-- 使用表AUTO_INCREMENT `lxy_users`
--
ALTER TABLE `lxy_users`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '用户ID';

--
-- 使用表AUTO_INCREMENT `lxy_user_logs`
--
ALTER TABLE `lxy_user_logs`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '日志ID';
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
