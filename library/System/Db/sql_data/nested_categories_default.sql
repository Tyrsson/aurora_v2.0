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
(1, 0, 'Electronics', 0, 1, 16),
(2, 0, 'Televisions', 1, 2, 7),
(3, 0, 'LCD', 2, 3, 4),
(4, 0, 'Plasma', 2, 5, 6),
(5, 0, 'Audio Equipment', 1, 8, 15),
(6, 0, 'MP3 Players', 5, 9, 10),
(7, 0, 'Radios', 5, 11, 12),
(8, 0, 'CD Players', 5, 13, 14);