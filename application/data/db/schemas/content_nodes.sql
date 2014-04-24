CREATE TABLE `content_nodes` (
`id` int(11) NOT NULL auto_increment, 
`page_id` int(11) default NULL, 
`node` varchar(50) default NULL, 
`content` text,
PRIMARY KEY (`id`)
) DEFAULT CHARSET=utf8;