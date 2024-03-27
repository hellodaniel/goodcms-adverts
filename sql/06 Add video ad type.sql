
ALTER TABLE `ads` CHANGE `title` `title` TINYTEXT CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL, CHANGE `image` `image` TINYTEXT CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL, CHANGE `imagemobile` `imagemobile` TINYTEXT CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL, CHANGE `biller` `biller` TINYTEXT CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL, CHANGE `destination_url` `destination_url` TINYTEXT CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL;

ALTER TABLE `ads` ADD `video` TINYTEXT NULL DEFAULT NULL AFTER `imagemobile`, ADD `videomobile` TINYTEXT NULL DEFAULT NULL AFTER `video`;