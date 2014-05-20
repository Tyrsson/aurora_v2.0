--
-- Table structure for table `skins`
--

DROP TABLE IF EXISTS `skins`;
CREATE TABLE `skins` (
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
CREATE TABLE `skin_settings` (
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