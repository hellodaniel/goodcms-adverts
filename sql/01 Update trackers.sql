

UPDATE ads SET created = modified WHERE created = '0000-00-00 00:00:00'; 
ALTER TABLE `ads` CHANGE `impressions` `historic_impressions` INT(11) NULL DEFAULT '0'; 
ALTER TABLE `ads` ADD `impressions` INT NOT NULL DEFAULT '0' AFTER `historic_impressions`; 
ALTER TABLE `ads` ADD `hits` INT NOT NULL DEFAULT '0' AFTER `impressions`; 

