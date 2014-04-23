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
('user', '', 'adminUserCountPerPage', '5', 'Text', 'dxadmin'),
('user', '', 'enableRegistration', '1', 'CheckBox', 'admin'),
('user', '', 'enableMainMenuLogin', '1', 'CheckBox', 'admin'),
('user', '', 'enableUserLogin', '1', 'CheckBox', 'dxadmin'),
('user', '', 'showEmail', '1', 'CheckBox', 'admin'),
('pages', '', 'lockCategories', '1', 'CheckBox', 'dxadmin'),
('pages', '', 'showPageHeading', '1', 'CheckBox', 'dxadmin'),
('contact', '', 'addressLine1', '', 'TextBox', 'admin'),
('contact', '', 'addressLine2', '', 'TextBox', 'admin'),
('contact', '', 'contactFaxNumber', '', 'TextBox', 'admin'),
('contact', '', 'contactPhoneNumber', '', 'TextBox', 'admin'),
('contact', '', 'emailAddress', '', 'TextBox', 'admin'),
('contact', '', 'enableContactInfo', '1', 'CheckBox', 'admin'),
('contact', '', 'facebookUrl', 'http://www.facebook.com', 'TextBox', 'dxadmin'),
('contact', '', 'twitterUrl', 'http://www.twitter.com', 'TextBox', 'admin'),
('general', '', 'allowTags', '<h1>,<h2>,<h3>,<h4>,<h5>,<h6>,<hr>', 'Textarea', 'admin'),
('general', '', 'enableCaptcha', '1', 'CheckBox', 'dxadmin'),
('general', '', 'enableDebugMode', '1', 'CheckBox', 'dxadmin'),
('general', '', 'enableFbOpenGraph', '0', 'CheckBox', 'dxadmin'),
('general', '', 'enableFbPageLink', '1', 'CheckBox', 'dxadmin'),
('general', '', 'enableHomeTab', '1', 'CheckBox', 'admin'),
('general', '', 'enableLinkLogo', '1', 'CheckBox', 'admin'),
('general', '', 'enableLogging', '1', 'CheckBox', 'dxadmin'),
('general', '', 'enableMobileSupport', '1', 'CheckBox', 'dxadmin'),
('general', '', 'enableSearch', '1', 'CheckBox', 'dxadmin'),
('general', '', 'facebookAppId', '431812843521907', 'TextBox', 'dxadmin'),
('general', '', 'facebookAppSecret', 'd86702c59bd48f3a76bc57d923cd237e', 'TextBox', 'dxadmin'),
('general', '', 'isInstalled', '0', 'CheckBox', 'dxadmin'),
('general', '', 'mobileSkinName', 'jquery.mobile', 'TextBox', 'dxadmin'),
('general', '', 'remoteLicenseKey', 'SingleDomain18446aad51de8a3a596b594c3fcca5d137cf8c34', 'Textarea', 'dxadmin'),
('general', '', 'seoDescription', 'Custom CMS', 'Textarea', 'admin'),
('general', '', 'sessionLength', '86400', 'TextBox', 'admin'),
('general', '', 'showOnlineList', '1', 'CheckBox', 'dxadmin'),
('general', '', 'siteEmail', 'testing@test.com', 'TextBox', 'admin'),
('general', '', 'siteName', 'Find Your Perfect Getaway', 'TextBox', 'admin'),
('general', '', 'webMasterEmail', 'noreply@dirextion.com', 'TextBox', 'admin');