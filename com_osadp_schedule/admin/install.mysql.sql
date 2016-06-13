-- create our main table for each project
CREATE TABLE IF NOT EXISTS `#__osadp_release_schedule` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `dma` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
);