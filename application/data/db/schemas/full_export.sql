-- phpMyAdmin SQL Dump
-- version 4.1.9
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: May 21, 2014 at 02:05 AM
-- Server version: 5.6.16
-- PHP Version: 5.4.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `aurora_2_0_0`
--

-- --------------------------------------------------------

--
-- Table structure for table `content_nodes`
--

DROP TABLE IF EXISTS `content_nodes`;
CREATE TABLE IF NOT EXISTS `content_nodes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `page_id` int(11) DEFAULT NULL,
  `node` varchar(50) DEFAULT NULL,
  `content` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `content_nodes`
--

INSERT INTO `content_nodes` (`id`, `page_id`, `node`, `content`) VALUES
(3, 1, 'headline', 'test one headline'),
(4, 1, 'image', 'Document.png'),
(5, 1, 'description', 'test one description'),
(6, 1, 'content', 'test one content');

-- --------------------------------------------------------

--
-- Table structure for table `log`
--

DROP TABLE IF EXISTS `log`;
CREATE TABLE IF NOT EXISTS `log` (
  `logId` int(11) NOT NULL AUTO_INCREMENT,
  `userId` int(11) NOT NULL DEFAULT '0',
  `fileId` int(11) NOT NULL DEFAULT '0',
  `userName` varchar(255) DEFAULT NULL,
  `timeStamp` varchar(255) NOT NULL,
  `priorityName` varchar(20) NOT NULL,
  `priority` int(1) NOT NULL,
  `message` mediumtext NOT NULL,
  PRIMARY KEY (`logId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

DROP TABLE IF EXISTS `pages`;
CREATE TABLE IF NOT EXISTS `pages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) DEFAULT NULL,
  `namespace` varchar(50) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `date_created` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `pages`
--

INSERT INTO `pages` (`id`, `parent_id`, `namespace`, `name`, `date_created`) VALUES
(1, NULL, 'page', 'Test One', 1399415163);

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
CREATE TABLE IF NOT EXISTS `roles` (
  `roleId` int(11) NOT NULL AUTO_INCREMENT,
  `role` varchar(255) NOT NULL,
  `parentRole` varchar(255) DEFAULT NULL,
  `isDefaultRole` tinyint(1) NOT NULL DEFAULT '0',
  `publicName` varchar(100) NOT NULL,
  PRIMARY KEY (`roleId`),
  KEY `isDefaultRole` (`isDefaultRole`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`roleId`, `role`, `parentRole`, `isDefaultRole`, `publicName`) VALUES
(1, 'admin', 'jradmin', 0, ''),
(2, 'jradmin', 'moderator', 0, ''),
(3, 'moderator', 'user', 0, ''),
(4, 'user', 'guest', 1, ''),
(5, 'guest', NULL, 0, '');

-- --------------------------------------------------------

--
-- Table structure for table `session`
--

DROP TABLE IF EXISTS `session`;
CREATE TABLE IF NOT EXISTS `session` (
  `id` varchar(255) NOT NULL DEFAULT '',
  `modified` int(11) DEFAULT NULL,
  `lifetime` int(11) DEFAULT NULL,
  `data` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `session`
--

INSERT INTO `session` (`id`, `modified`, `lifetime`, `data`) VALUES
('emjcubovbej5piiisfec7njd2kkthccm21ue7mn89j9udtktnndlb97mi1fvml46c3bnmktumt7elhoq0fkfbip0cp6ekj70uju8gd2', 1400655463, 86400, '.Mozilla/5.0 (Macintosh; Intel Mac OS X 10_9_2) AppleWebKit/537.75.14 (KHTML, like Gecko) Version/7.0.3 Safari/537.75.14|a:1:{s:7:"storage";s:3149:"a:6:{s:12:"browser_type";s:7:"desktop";s:6:"config";a:3:{s:23:"identification_sequence";s:14:"mobile,desktop";s:7:"storage";a:1:{s:7:"adapter";s:7:"Session";}s:6:"mobile";a:1:{s:8:"features";a:1:{s:9:"classname";s:45:"Zend_Http_UserAgent_Features_Adapter_Browscap";}}}s:12:"device_class";s:27:"Zend_Http_UserAgent_Desktop";s:6:"device";s:2566:"a:6:{s:10:"_aFeatures";a:28:{s:21:"browser_compatibility";s:6:"Safari";s:14:"browser_engine";s:11:"AppleWebKit";s:12:"browser_name";s:6:"Safari";s:13:"browser_token";s:21:"Intel Mac OS X 10_9_2";s:15:"browser_version";s:5:"7.0.3";s:7:"comment";a:2:{s:4:"full";s:32:"Macintosh; Intel Mac OS X 10_9_2";s:6:"detail";a:2:{i:0;s:9:"Macintosh";i:1;s:22:" Intel Mac OS X 10_9_2";}}s:18:"compatibility_flag";s:9:"Macintosh";s:15:"device_os_token";s:9:"Macintosh";s:6:"others";a:2:{s:4:"full";s:72:"AppleWebKit/537.75.14 (KHTML, like Gecko) Version/7.0.3 Safari/537.75.14";s:6:"detail";a:3:{i:0;a:3:{i:0;s:41:"AppleWebKit/537.75.14 (KHTML, like Gecko)";i:1;s:11:"AppleWebKit";i:2;s:9:"537.75.14";}i:1;a:3:{i:0;s:13:"Version/7.0.3";i:1;s:7:"Version";i:2;s:5:"7.0.3";}i:2;a:3:{i:0;s:16:"Safari/537.75.14";i:1;s:6:"Safari";i:2;s:9:"537.75.14";}}}s:12:"product_name";s:7:"Mozilla";s:15:"product_version";s:3:"5.0";s:10:"user_agent";s:11:"Mozilla/5.0";s:18:"is_wireless_device";b:0;s:9:"is_mobile";b:0;s:10:"is_desktop";b:1;s:9:"is_tablet";b:0;s:6:"is_bot";b:0;s:8:"is_email";b:0;s:7:"is_text";b:0;s:25:"device_claims_web_support";b:0;s:9:"client_ip";s:12:"96.37.159.19";s:11:"php_version";s:6:"5.4.24";s:9:"server_os";s:6:"apache";s:17:"server_os_version";s:6:"2.2.26";s:18:"server_http_accept";s:63:"text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8";s:27:"server_http_accept_language";s:5:"en-us";s:9:"server_ip";s:8:"10.0.1.2";s:11:"server_name";s:18:"cms.webinertia.net";}s:7:"_aGroup";a:2:{s:12:"product_info";a:21:{i:0;s:21:"browser_compatibility";i:1;s:14:"browser_engine";i:2;s:12:"browser_name";i:3;s:13:"browser_token";i:4;s:15:"browser_version";i:5;s:7:"comment";i:6;s:18:"compatibility_flag";i:7;s:15:"device_os_token";i:8;s:6:"others";i:9;s:12:"product_name";i:10;s:15:"product_version";i:11;s:10:"user_agent";i:12;s:18:"is_wireless_device";i:13;s:9:"is_mobile";i:14;s:10:"is_desktop";i:15;s:9:"is_tablet";i:16;s:6:"is_bot";i:17;s:8:"is_email";i:18;s:7:"is_text";i:19;s:25:"device_claims_web_support";i:20;s:9:"client_ip";}s:11:"server_info";a:7:{i:0;s:11:"php_version";i:1;s:9:"server_os";i:2;s:17:"server_os_version";i:3;s:18:"server_http_accept";i:4;s:27:"server_http_accept_language";i:5;s:9:"server_ip";i:6;s:11:"server_name";}}s:8:"_browser";s:6:"Safari";s:15:"_browserVersion";s:5:"7.0.3";s:10:"_userAgent";s:119:"Mozilla/5.0 (Macintosh; Intel Mac OS X 10_9_2) AppleWebKit/537.75.14 (KHTML, like Gecko) Version/7.0.3 Safari/537.75.14";s:7:"_images";a:6:{i:0;s:4:"jpeg";i:1;s:3:"gif";i:2;s:3:"png";i:3;s:5:"pjpeg";i:4;s:5:"x-png";i:5;s:3:"bmp";}}";s:10:"user_agent";s:119:"Mozilla/5.0 (Macintosh; Intel Mac OS X 10_9_2) AppleWebKit/537.75.14 (KHTML, like Gecko) Version/7.0.3 Safari/537.75.14";s:11:"http_accept";s:63:"text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8";}";}Zend_Auth|a:1:{s:7:"storage";O:8:"stdClass":3:{s:6:"userId";s:1:"1";s:8:"userName";s:5:"admin";s:4:"role";s:5:"admin";}}__ZF|a:1:{s:14:"FlashMessenger";a:1:{s:4:"ENNH";i:1;}}FlashMessenger|a:1:{s:7:"default";a:1:{i:0;s:44:"You were sucessfully logged in as&nbsp;admin";}}'),
('uges7qd8pkqq1ltf7ee4a39ffka5236phscavlk9hg8hsb38t4orcs5n36ql8iulhsrdbvip6p6v92fo1s359rra8vuatu07vvu1o52', 1400630815, 86400, '.Mozilla/5.0 (Macintosh; Intel Mac OS X 10_9_3) AppleWebKit/537.75.14 (KHTML, like Gecko) Version/7.0.3 Safari/537.75.14|a:1:{s:7:"storage";s:3150:"a:6:{s:12:"browser_type";s:7:"desktop";s:6:"config";a:3:{s:23:"identification_sequence";s:14:"mobile,desktop";s:7:"storage";a:1:{s:7:"adapter";s:7:"Session";}s:6:"mobile";a:1:{s:8:"features";a:1:{s:9:"classname";s:45:"Zend_Http_UserAgent_Features_Adapter_Browscap";}}}s:12:"device_class";s:27:"Zend_Http_UserAgent_Desktop";s:6:"device";s:2567:"a:6:{s:10:"_aFeatures";a:28:{s:21:"browser_compatibility";s:6:"Safari";s:14:"browser_engine";s:11:"AppleWebKit";s:12:"browser_name";s:6:"Safari";s:13:"browser_token";s:21:"Intel Mac OS X 10_9_3";s:15:"browser_version";s:5:"7.0.3";s:7:"comment";a:2:{s:4:"full";s:32:"Macintosh; Intel Mac OS X 10_9_3";s:6:"detail";a:2:{i:0;s:9:"Macintosh";i:1;s:22:" Intel Mac OS X 10_9_3";}}s:18:"compatibility_flag";s:9:"Macintosh";s:15:"device_os_token";s:9:"Macintosh";s:6:"others";a:2:{s:4:"full";s:72:"AppleWebKit/537.75.14 (KHTML, like Gecko) Version/7.0.3 Safari/537.75.14";s:6:"detail";a:3:{i:0;a:3:{i:0;s:41:"AppleWebKit/537.75.14 (KHTML, like Gecko)";i:1;s:11:"AppleWebKit";i:2;s:9:"537.75.14";}i:1;a:3:{i:0;s:13:"Version/7.0.3";i:1;s:7:"Version";i:2;s:5:"7.0.3";}i:2;a:3:{i:0;s:16:"Safari/537.75.14";i:1;s:6:"Safari";i:2;s:9:"537.75.14";}}}s:12:"product_name";s:7:"Mozilla";s:15:"product_version";s:3:"5.0";s:10:"user_agent";s:11:"Mozilla/5.0";s:18:"is_wireless_device";b:0;s:9:"is_mobile";b:0;s:10:"is_desktop";b:1;s:9:"is_tablet";b:0;s:6:"is_bot";b:0;s:8:"is_email";b:0;s:7:"is_text";b:0;s:25:"device_claims_web_support";b:0;s:9:"client_ip";s:13:"64.53.243.105";s:11:"php_version";s:6:"5.4.24";s:9:"server_os";s:6:"apache";s:17:"server_os_version";s:6:"2.2.26";s:18:"server_http_accept";s:63:"text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8";s:27:"server_http_accept_language";s:5:"en-us";s:9:"server_ip";s:8:"10.0.1.2";s:11:"server_name";s:18:"cms.webinertia.net";}s:7:"_aGroup";a:2:{s:12:"product_info";a:21:{i:0;s:21:"browser_compatibility";i:1;s:14:"browser_engine";i:2;s:12:"browser_name";i:3;s:13:"browser_token";i:4;s:15:"browser_version";i:5;s:7:"comment";i:6;s:18:"compatibility_flag";i:7;s:15:"device_os_token";i:8;s:6:"others";i:9;s:12:"product_name";i:10;s:15:"product_version";i:11;s:10:"user_agent";i:12;s:18:"is_wireless_device";i:13;s:9:"is_mobile";i:14;s:10:"is_desktop";i:15;s:9:"is_tablet";i:16;s:6:"is_bot";i:17;s:8:"is_email";i:18;s:7:"is_text";i:19;s:25:"device_claims_web_support";i:20;s:9:"client_ip";}s:11:"server_info";a:7:{i:0;s:11:"php_version";i:1;s:9:"server_os";i:2;s:17:"server_os_version";i:3;s:18:"server_http_accept";i:4;s:27:"server_http_accept_language";i:5;s:9:"server_ip";i:6;s:11:"server_name";}}s:8:"_browser";s:6:"Safari";s:15:"_browserVersion";s:5:"7.0.3";s:10:"_userAgent";s:119:"Mozilla/5.0 (Macintosh; Intel Mac OS X 10_9_3) AppleWebKit/537.75.14 (KHTML, like Gecko) Version/7.0.3 Safari/537.75.14";s:7:"_images";a:6:{i:0;s:4:"jpeg";i:1;s:3:"gif";i:2;s:3:"png";i:3;s:5:"pjpeg";i:4;s:5:"x-png";i:5;s:3:"bmp";}}";s:10:"user_agent";s:119:"Mozilla/5.0 (Macintosh; Intel Mac OS X 10_9_3) AppleWebKit/537.75.14 (KHTML, like Gecko) Version/7.0.3 Safari/537.75.14";s:11:"http_accept";s:63:"text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8";}";}');

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

DROP TABLE IF EXISTS `settings`;
CREATE TABLE IF NOT EXISTS `settings` (
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

-- --------------------------------------------------------

--
-- Table structure for table `skins`
--

DROP TABLE IF EXISTS `skins`;
CREATE TABLE IF NOT EXISTS `skins` (
  `skinId` int(11) NOT NULL AUTO_INCREMENT,
  `skinName` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`skinId`),
  UNIQUE KEY `skinName` (`skinName`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `skins`
--

INSERT INTO `skins` (`skinId`, `skinName`) VALUES
(1, 'desktop');

-- --------------------------------------------------------

--
-- Table structure for table `skin_settings`
--

DROP TABLE IF EXISTS `skin_settings`;
CREATE TABLE IF NOT EXISTS `skin_settings` (
  `recordId` int(11) NOT NULL AUTO_INCREMENT,
  `skinId` int(11) NOT NULL,
  `spec` varchar(255) NOT NULL,
  `value` text NOT NULL,
  PRIMARY KEY (`recordId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `skin_settings`
--

INSERT INTO `skin_settings` (`recordId`, `skinId`, `spec`, `value`) VALUES
(1, 1, 'skinVersion', '2.0.0'),
(2, 1, 'appVersion', '2.0.0'),
(3, 1, 'isCurrentSkin', '1');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `userId` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(128) NOT NULL,
  `userName` varchar(128) NOT NULL,
  `firstName` varchar(128) NOT NULL,
  `lastName` varchar(128) NOT NULL,
  `companyName` varchar(255) NOT NULL,
  `email` varchar(128) NOT NULL,
  `passWord` char(40) NOT NULL,
  `salt` char(32) NOT NULL,
  `role` varchar(100) NOT NULL DEFAULT 'user',
  `uStatus` varchar(8) NOT NULL DEFAULT 'disabled',
  `registeredDate` varchar(11) NOT NULL,
  `hash` int(10) NOT NULL,
  PRIMARY KEY (`userId`),
  KEY `email_pass` (`email`,`passWord`),
  KEY `email` (`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`userId`, `title`, `userName`, `firstName`, `lastName`, `companyName`, `email`, `passWord`, `salt`, `role`, `uStatus`, `registeredDate`, `hash`) VALUES
(1, '', 'admin', '', '', '', '', 'e1da551374f0a6f136916647ab0f157cc192ea22', '', 'admin', 'enabled', '', 0),
(3, '', 'test', 'testing', 'register', '', 'test@test.com', '0f53849ad746717133aad19be54518a6d67fa2fd', '', 'user', 'disabled', '1399567348', 1399567348);
