SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `aurora_2_0_0`
--

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
CREATE TABLE `roles` (
  `roleId` int(11) NOT NULL AUTO_INCREMENT,
  `role` varchar(255) NOT NULL,
  `inheritsFrom` varchar(255) NOT NULL,
  `publicName` varchar(100) NOT NULL,
  PRIMARY KEY (`roleId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`roleId`, `role`, `inheritsFrom`, `publicName`) VALUES
(1, 'admin', 'jradmin', ''),
(2, 'jradmin', 'moderator', ''),
(3, 'moderator', 'user', ''),
(4, 'user', 'guest', ''),
(5, 'guest', 'none', '');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `userId` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(128) NOT NULL,
  `userName` varchar(128) NOT NULL,
  `firstName` varchar(128) NOT NULL,
  `lastName` varchar(128) NOT NULL,
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`userId`, `title`, `userName`, `firstName`, `lastName`, `email`, `passWord`, `salt`, `role`, `uStatus`, `registeredDate`, `hash`) VALUES
(1, '', 'admin', '', '', '', 'e1da551374f0a6f136916647ab0f157cc192ea22', '', 'admin', 'enabled', '', 0);