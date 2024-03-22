
ALTER TABLE `ads` CHANGE `urls` `whitelist_urls` TEXT CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL;
ALTER TABLE `ads` ADD `blacklist_urls` TEXT NULL AFTER `whitelist_urls`;
