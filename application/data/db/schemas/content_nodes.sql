--
-- Table structure for table `content_nodes`
--

DROP TABLE IF EXISTS `content_nodes`;
CREATE TABLE IF NOT EXISTS `content_nodes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `page_id` int(11) DEFAULT NULL,
  `node` varchar(50) DEFAULT NULL,
  `content` text,
  `node_type` set('metaTitle','metaDescription','text','textarea','image','heading','subheading','footer') DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `content_nodes`
--

INSERT INTO `content_nodes` (`id`, `page_id`, `node`, `content`, `node_type`) VALUES
(1, 1, 'headline', 'test one headline', 'text'),
(2, 1, 'image', 'Document.png', 'image'),
(3, 1, 'description', 'test one description', 'text'),
(4, 1, 'content', 'test one content', 'textarea'),
(5, 1, 'title', 'Meta Title example', 'metaTitle'),
(6, 1, 'seoDescription', 'This is the description that will show in the meta data for the page.', 'metaDescription'),
(7, 1, 'pageFooter', 'This is an example footer for the page.', 'footer');