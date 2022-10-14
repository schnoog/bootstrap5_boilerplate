<?php 


$database_migrations[] =
'CREATE TABLE IF NOT EXISTS `app_settings` (
  `app_settings_id` int(11) NOT NULL AUTO_INCREMENT,
  `app_settings_key` varchar(64) NOT NULL,
  `app_settings_value` text DEFAULT NULL,
  `app_settings_dect` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`app_settings_id`),
  UNIQUE KEY `app_Settings_uniq_key_id` (`app_settings_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
';

$database_migrations[]='
CREATE TABLE IF NOT EXISTS `sec_authtoken` (
  `sec_authtoken_id` int(11) NOT NULL AUTO_INCREMENT,
  `sec_authtoken_user_id` int(11) DEFAULT NULL,
  `sec_authtoken_token` varchar(256) DEFAULT NULL,
  `sec_authtoken_meaning` varchar(45) DEFAULT NULL,
  `sec_authtoken_used` int(11) DEFAULT 0,
  `sec_authtoken_issued` int(11) DEFAULT NULL,
  PRIMARY KEY (`sec_authtoken_id`),
  KEY `sec_authtoken_user_id` (`sec_authtoken_user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4;';

$database_migrations[]='
CREATE TABLE IF NOT EXISTS `sec_usergroups` (
  `sec_usergroups_id` int(11) NOT NULL AUTO_INCREMENT,
  `sec_usergroups_group` varchar(45) DEFAULT NULL,
  `sec_usergroups_level` int(11) DEFAULT NULL,
  PRIMARY KEY (`sec_usergroups_id`),
  UNIQUE KEY `sec_usergroups_group` (`sec_usergroups_group`),
  UNIQUE KEY `sec_usergroups_level` (`sec_usergroups_level`)
) ENGINE=InnoDB AUTO_INCREMENT=100 DEFAULT CHARSET=utf8mb4;
';


$database_migrations[]='
INSERT INTO `sec_usergroups` (`sec_usergroups_id`, `sec_usergroups_group`, `sec_usergroups_level`) VALUES
(1, 'Admin', 10),
(90, 'Registered User', 1),
(99, 'Guest', 0);
';

$database_migrations[]='
CREATE TABLE IF NOT EXISTS `sec_users` (
  `sec_users_id` int(11) NOT NULL AUTO_INCREMENT,
  `sec_users_name` varchar(45) DEFAULT NULL,
  `sec_users_password` varchar(256) DEFAULT NULL,
  `sec_users_email` varchar(256) DEFAULT NULL,
  `sec_users_lastlog` int(11) DEFAULT 0,
  `sec_users_active` int(1) DEFAULT 0,
  `sec_users_failcount` int(1) DEFAULT 0,
  `sec_users_lastfail` int(11) DEFAULT 0,
  PRIMARY KEY (`sec_users_id`),
     UNIQUE KEY `sec_users_name` (`sec_users_name`),
  UNIQUE KEY `sec_users_email` (`sec_users_email`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4;
';

$database_migrations[]='
CREATE TABLE IF NOT EXISTS `sec_users_usergroups` (
  `sec_users_usergroups_id` int(11) NOT NULL AUTO_INCREMENT,
  `sec_users_usergroups_user_id` int(11) DEFAULT NULL,
  `sec_users_usergroups_usergroup_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`sec_users_usergroups_id`),
  UNIQUE KEY `sec_users_usergroups_uniq` (`sec_users_usergroups_user_id`,`sec_users_usergroups_usergroup_id`),
  KEY `sec_users_usergroups_user_id` (`sec_users_usergroups_user_id`),
  KEY `sec_users_usergroups_usergroup_id` (`sec_users_usergroups_usergroup_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4;
';

$database_migrations[]='
ALTER TABLE `sec_authtoken`
  ADD CONSTRAINT `sec_authtoken_user_fk` FOREIGN KEY (`sec_authtoken_user_id`) REFERENCES `sec_users` (`sec_users_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;
';

$database_migrations[]='
INSERT INTO `sec_users` (`sec_users_id`, `sec_users_name`, `sec_users_password`, `sec_users_email`, `sec_users_lastlog`, `sec_users_active`, `sec_users_failcount`, `sec_users_lastfail`) VALUES
(1, "admin", "$2y$10$YRRqbJSw8eC3kizdnd4Dmelny3jAtKtvsOiHAGl1Qhmb1msZc8dP6", "admin@example.com", 0, 1, 0, 0);
';
// admin:admin

$database_migrations[]='
INSERT INTO `sec_users_usergroups` (`sec_users_usergroups_id`, `sec_users_usergroups_user_id`, `sec_users_usergroups_usergroup_id`) VALUES
(1, 1, 1)';