
CREATE TABLE IF NOT EXISTS `#__akeeba_multicategories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_ids` varchar(255) DEFAULT NULL,
  `item_id` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
);