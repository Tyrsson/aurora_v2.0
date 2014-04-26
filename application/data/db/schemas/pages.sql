CREATE TABLE `pages` (
  `id` int(11) NOT NULL auto_increment,
  `parent_id` int(11) default NULL,
  `namespace` varchar(50) default NULL,
  `name` varchar(100) default NULL,
  `date_created` int(11) default NULL,
  PRIMARY KEY  (`id`)
) DEFAULT CHARSET=utf8;


