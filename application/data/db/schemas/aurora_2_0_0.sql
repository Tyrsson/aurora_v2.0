-- phpMyAdmin SQL Dump
-- version 3.5.7
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 23, 2014 at 05:22 PM
-- Server version: 5.5.29
-- PHP Version: 5.3.20

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `aurora_2_0_0`
--

-- --------------------------------------------------------

--
-- Table structure for table `nodes`
--

DROP TABLE IF EXISTS `nodes`;
CREATE TABLE `nodes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL COMMENT 'image, TextBox, Editor etc',
  `role` varchar(255) NOT NULL COMMENT 'Access role for display or administration of node',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Holds the node definitions' AUTO_INCREMENT=6 ;

--
-- Dumping data for table `nodes`
--

INSERT INTO `nodes` (`id`, `name`, `type`, `role`) VALUES
(1, 'Description', 'TextBox', 'admin'),
(2, 'Image', 'TextBox', 'admin'),
(3, 'Content', 'editor', 'admin'),
(4, 'Footer', 'TextBox', 'dxadmin'),
(5, 'Copy Right', 'TextBox', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

DROP TABLE IF EXISTS `pages`;
CREATE TABLE `pages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `uri` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Hold page primary info' AUTO_INCREMENT=2 ;

--
-- Dumping data for table `pages`
--

INSERT INTO `pages` (`id`, `title`, `uri`) VALUES
(1, 'Home', 'Home');

-- --------------------------------------------------------

--
-- Table structure for table `page_nodes`
--

DROP TABLE IF EXISTS `page_nodes`;
CREATE TABLE `page_nodes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pageId` int(11) NOT NULL,
  `nodeId` int(11) NOT NULL,
  `order` int(11) NOT NULL DEFAULT '0',
  `nodeName` varchar(255) NOT NULL,
  `nodeValue` longtext NOT NULL,
  PRIMARY KEY (`id`),
  KEY `order` (`order`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='lookup table to bind nodes to pages' AUTO_INCREMENT=6 ;

--
-- Dumping data for table `page_nodes`
--

INSERT INTO `page_nodes` (`id`, `pageId`, `nodeId`, `order`, `nodeName`, `nodeValue`) VALUES
(1, 1, 1, 0, 'Description', 'This is the page description'),
(2, 1, 2, 0, 'Image', 'someimage.png'),
(3, 1, 3, 0, 'Content', 'This is some page content'),
(4, 1, 4, 0, 'Footer', 'This is the page footer text. Just plain text for the moment.'),
(5, 1, 5, 0, 'Copy Right', 'CopyRight Some Company');

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

DROP TABLE IF EXISTS `settings`;
CREATE TABLE `settings` (
  `moduleName` varchar(255) NOT NULL,
  `label` varchar(255) NOT NULL,
  `variable` varchar(255) NOT NULL,
  `value` varchar(255) NOT NULL,
  `settingType` tinytext NOT NULL,
  `role` varchar(255) NOT NULL DEFAULT 'admin',
  PRIMARY KEY (`variable`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`moduleName`, `label`, `variable`, `value`, `settingType`, `role`) VALUES
('contact', '', 'addressLine1', '', 'TextBox', 'admin'),
('contact', '', 'addressLine2', '', 'TextBox', 'admin'),
('user', '', 'adminUserCountPerPage', '5', 'Text', 'dxadmin'),
('general', '', 'allowTags', '<h1>,<h2>,<h3>,<h4>,<h5>,<h6>,<hr>', 'Textarea', 'admin'),
('contact', '', 'contactFaxNumber', '', 'TextBox', 'admin'),
('contact', '', 'contactPhoneNumber', '', 'TextBox', 'admin'),
('contact', '', 'emailAddress', '', 'TextBox', 'admin'),
('general', '', 'enableCaptcha', '1', 'CheckBox', 'dxadmin'),
('contact', '', 'enableContactInfo', '1', 'CheckBox', 'admin'),
('general', '', 'enableDebugMode', '1', 'CheckBox', 'dxadmin'),
('general', '', 'enableFbOpenGraph', '0', 'CheckBox', 'dxadmin'),
('general', '', 'enableFbPageLink', '1', 'CheckBox', 'dxadmin'),
('general', '', 'enableHomeTab', '1', 'CheckBox', 'admin'),
('general', '', 'enableLinkLogo', '1', 'CheckBox', 'admin'),
('general', '', 'enableLogging', '1', 'CheckBox', 'dxadmin'),
('user', '', 'enableMainMenuLogin', '1', 'CheckBox', 'admin'),
('general', '', 'enableMobileSupport', '1', 'CheckBox', 'dxadmin'),
('user', '', 'enableRegistration', '1', 'CheckBox', 'admin'),
('general', '', 'enableSearch', '1', 'CheckBox', 'dxadmin'),
('user', '', 'enableUserLogin', '1', 'CheckBox', 'dxadmin'),
('general', '', 'facebookAppId', '431812843521907', 'TextBox', 'dxadmin'),
('general', '', 'facebookAppSecret', 'd86702c59bd48f3a76bc57d923cd237e', 'TextBox', 'dxadmin'),
('contact', '', 'facebookUrl', 'http://www.facebook.com', 'TextBox', 'dxadmin'),
('general', '', 'isInstalled', '0', 'CheckBox', 'dxadmin'),
('pages', '', 'lockCategories', '1', 'CheckBox', 'dxadmin'),
('general', '', 'mobileSkinName', 'jquery.mobile', 'TextBox', 'dxadmin'),
('general', '', 'remoteLicenseKey', 'SingleDomain18446aad51de8a3a596b594c3fcca5d137cf8c34', 'Textarea', 'dxadmin'),
('general', '', 'seoDescription', 'Custom CMS', 'Textarea', 'admin'),
('general', '', 'sessionLength', '86400', 'TextBox', 'admin'),
('user', '', 'showEmail', '1', 'CheckBox', 'admin'),
('general', '', 'showOnlineList', '1', 'CheckBox', 'dxadmin'),
('pages', '', 'showPageHeading', '1', 'CheckBox', 'dxadmin'),
('general', '', 'siteEmail', 'testing@test.com', 'TextBox', 'admin'),
('general', '', 'siteName', 'Aurora CMS', 'TextBox', 'admin'),
('contact', '', 'twitterUrl', 'http://www.twitter.com', 'TextBox', 'admin'),
('general', '', 'webMasterEmail', 'noreply@dirextion.com', 'TextBox', 'admin');
