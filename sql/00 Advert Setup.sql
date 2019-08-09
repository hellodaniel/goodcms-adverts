CREATE TABLE IF NOT EXISTS `ads` (
  `id` char(36) NOT NULL,
  `weight` int(11) NOT NULL DEFAULT '1000',
  `enabled` tinyint(1) DEFAULT '1',
  `ad_type_id` int(11) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `type` varchar(12) NOT NULL DEFAULT 'image',
  `image` varchar(255) DEFAULT NULL,
  `imagemobile` varchar(255) NOT NULL,
  `html` text NOT NULL,
  `background` varchar(6) DEFAULT NULL,
  `biller` varchar(255) DEFAULT NULL,
  `impressions` int(11) DEFAULT '0',
  `clicks` int(11) DEFAULT '0',
  `max_impressions` int(11) NOT NULL DEFAULT '0',
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `destination_url` varchar(255) DEFAULT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `ad_type_id_idxfk` (`ad_type_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
COMMIT;



CREATE TABLE IF NOT EXISTS `ad_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(127) DEFAULT NULL,
  `width` int(11) NOT NULL,
  `height` int(11) NOT NULL,
  `notes` text,
  `weight` int(11) NOT NULL DEFAULT '1000',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
COMMIT;

ALTER TABLE `ads` ADD `admin_only` TINYINT(1) NOT NULL DEFAULT '0' AFTER `enabled`; 
