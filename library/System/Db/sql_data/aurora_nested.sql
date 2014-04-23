CREATE TABLE IF NOT EXISTS `categories` (
  `categoryId` int NOT NULL AUTO_INCREMENT,
  `rootId` int NOT NULL,
  `categoryName` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `parentId` int NOT NULL,
  `lft` int NOT NULL,
  `rgt` int NOT NULL,
  PRIMARY KEY (`categoryId`)
) ;

INSERT INTO `categories` (`categoryId`, `rootId`, `categoryName`, `parentId`, `lft`, `rgt`) VALUES
(1, 0, 'Site', 0, 1, 16),
(2, 0, 'Pages', 1, 2, 7),
(3, 0, 'About Us', 2, 3, 4),
(4, 0, 'Services', 2, 5, 6),
(5, 0, 'Contact Us', 2, 7, 8);





CREATE TABLE `category_pages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `categoryId` NOT NULL DEFAULT '1',
  `userId` int(11) NOT NULL DEFAULT '0',
  `role` varchar(100) NOT NULL DEFAULT 'guest',
  `name` varchar(50) NOT NULL,
  `url` varchar(255) NOT NULL COMMENT 'page is queried by this value',
  `visibility` enum('public','private') NOT NULL DEFAULT 'public',
  `createdDate` int(11) DEFAULT NULL,
  `publishDate` int(11) DEFAULT NULL,
  `modifiedDate` int(11) DEFAULT NULL,
  `archivedDate` int(11) DEFAULT NULL,
  `pageOrder` int(11) DEFAULT NULL,
  `content` longtext NOT NULL,
  `keyWords` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `reindex` int(11) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `linkText` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `userId` (`visibility`,`createdDate`,`modifiedDate`,`archivedDate`,`pageOrder`),
  KEY `role` (`role`),
  KEY `url` (`url`),
  KEY `pageName` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;