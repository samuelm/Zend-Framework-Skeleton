# Sequel Pro dump
# Version 2492
# http://code.google.com/p/sequel-pro
#
# Host: 127.0.0.1 (MySQL 5.1.53)
# Database: app
# Generation Time: 2011-01-07 14:06:17 +0100
# ************************************************************

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table backoffice_users
# ------------------------------------------------------------

DROP TABLE IF EXISTS `backoffice_users`;

CREATE TABLE `backoffice_users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `firstname` varchar(20) NOT NULL,
  `lastname` varchar(40) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(40) NOT NULL,
  `password_valid` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `email` varchar(340) NOT NULL,
  `phone_number` varchar(20) NOT NULL,
  `last_login` timestamp NULL DEFAULT NULL,
  `last_password_update` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_username` (`username`),
  KEY `idx_email` (`email`(255))
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `backoffice_users` WRITE;
/*!40000 ALTER TABLE `backoffice_users` DISABLE KEYS */;
INSERT INTO `backoffice_users` (`id`,`firstname`,`lastname`,`username`,`password`,`password_valid`,`email`,`phone_number`,`last_login`,`last_password_update`)
VALUES
	(NULL,'John','Doe','john.doe','6c64e8dcebc17e3d08546a355b52817f63eb6fe2',0,'john@doe.es','987654321','2011-01-07 13:04:19','2010-10-14 17:53:44');

/*!40000 ALTER TABLE `backoffice_users` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table backoffice_users_groups
# ------------------------------------------------------------

DROP TABLE IF EXISTS `backoffice_users_groups`;

CREATE TABLE `backoffice_users_groups` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `group_id` int(11) unsigned NOT NULL,
  `user_id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_user_id` (`user_id`),
  KEY `idx_group_id` (`group_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `backoffice_users_groups` WRITE;
/*!40000 ALTER TABLE `backoffice_users_groups` DISABLE KEYS */;
INSERT INTO `backoffice_users_groups` (`id`,`group_id`,`user_id`)
VALUES
	(NULL,1,1);

/*!40000 ALTER TABLE `backoffice_users_groups` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table flags
# ------------------------------------------------------------

DROP TABLE IF EXISTS `flags`;

CREATE TABLE `flags` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `description` varchar(255) NOT NULL,
  `active_on_dev` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `active_on_prod` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

LOCK TABLES `flags` WRITE;
/*!40000 ALTER TABLE `flags` DISABLE KEYS */;
INSERT INTO `flags` (`id`,`name`,`description`,`active_on_dev`,`active_on_prod`)
VALUES
	(1,'backoffice-groups','Allows user to manage the user groups',1,0),
	(2,'backoffice-index','Default entry point in the application',1,0),
	(3,'backoffice-privileges','Allows the users to perform CRUD operations on privileges',1,0),
	(4,'backoffice-profile','Allows user to manage their profile data',1,0),
	(5,'backoffice-system','Allow the admins to manage critical info, users, groups, permissions, etc.',1,0),
	(6,'backoffice-users','Allows the users to perform CRUD operations on other users',1,0),
	(7,'frontend-index','Default entry point in the application',1,0),
	(8,'backoffice-flags','Allows user to manage the flags',1,0),
	(9,'backoffice-testing','Activate some testing functionalities',1,0),
	(10,'frontend-testing','Activate some testing functionalities',1,0);

/*!40000 ALTER TABLE `flags` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table flippers
# ------------------------------------------------------------

DROP TABLE IF EXISTS `flippers`;

CREATE TABLE `flippers` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `group_id` int(11) unsigned NOT NULL,
  `flag_id` int(11) unsigned NOT NULL,
  `privilege_id` int(11) unsigned NOT NULL,
  `allow` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `flippers` WRITE;
/*!40000 ALTER TABLE `flippers` DISABLE KEYS */;
INSERT INTO `flippers` (`id`,`group_id`,`flag_id`,`privilege_id`,`allow`)
VALUES
	(NULL,2,4,14,1),
	(NULL,2,4,14,1),
	(NULL,2,7,23,1),
	(NULL,2,4,14,1),
	(NULL,2,7,23,1),
	(NULL,2,4,14,1),
	(NULL,2,7,23,1),
	(NULL,2,7,24,1);

/*!40000 ALTER TABLE `flippers` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table groups
# ------------------------------------------------------------

DROP TABLE IF EXISTS `groups`;

CREATE TABLE `groups` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(25) DEFAULT NULL,
  `parent_id` int(11) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`),
  KEY `idx_name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

LOCK TABLES `groups` WRITE;
/*!40000 ALTER TABLE `groups` DISABLE KEYS */;
INSERT INTO `groups` (`id`,`name`,`parent_id`)
VALUES
	(1,'administrators',0),
	(2,'guests',0);

/*!40000 ALTER TABLE `groups` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table privileges
# ------------------------------------------------------------

DROP TABLE IF EXISTS `privileges`;

CREATE TABLE `privileges` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `flag_id` varchar(20) NOT NULL,
  `description` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`,`flag_id`),
  KEY `idx_resource_id` (`flag_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `privileges` WRITE;
/*!40000 ALTER TABLE `privileges` DISABLE KEYS */;
INSERT INTO `privileges` (`id`,`name`,`flag_id`,`description`)
VALUES
	(NULL,'index','1','Allows the user to view all the user groups registered\nin the application'),
	(NULL,'add','1','Allows the user to add another user group in the\napplication'),
	(NULL,'edit','1','Edits an existing user group'),
	(NULL,'delete','1','Allows the user to delete an existing user group. All the users attached to\nthis group *WILL NOT* be deleted, they will just lose all'),
	(NULL,'flippers','1','Allows the user to manage individual permissions for each\nuser group'),
	(NULL,'index','2','Controller\'s entry point'),
	(NULL,'index','3','Allows the user to view all the permissions registered\nin the application'),
	(NULL,'add','3','Allows the user to add another privilege in the application'),
	(NULL,'edit','3','Edits an existing privilege'),
	(NULL,'delete','3','Allows the user to delete an existing privilege. All the acl\'s related to\nthis privilege will be removed'),
	(NULL,'index','4','Allows users to see their dashboards'),
	(NULL,'edit','4','Allows the users to update their profiles'),
	(NULL,'change-password','4','Allows users to change their passwords'),
	(NULL,'login','4','Allows users to log into the application'),
	(NULL,'logout','4','Allows users to log out of the application'),
	(NULL,'index','5','Controller\'s entry point'),
	(NULL,'example','5','Theme example page'),
	(NULL,'index','6','Allows users to see all other users that are registered in\nthe application'),
	(NULL,'add','6','Allows users to add new users in the application\n(should be reserved for administrators)'),
	(NULL,'edit','6','Allows users to edit another users\' data\n(should be reserved for administrators)'),
	(NULL,'view','6','Allows users to see other users\' profiles'),
	(NULL,'delete','6','Allows users to logically delete other users\n(should be reserved for administrators)'),
	(NULL,'index','7','Controller\'s entry point'),
	(NULL,'static','7','Static Pages'),
	(NULL,'index','8','Allows the user to view all the flags registered in the application'),
	(NULL,'toogle-prod','8','Change the active status of a flag on production'),
	(NULL,'toogle-dev','8','Change the active status of a flag on development'),
	(NULL,'toogleprod','8','Change the active status of a flag on production'),
	(NULL,'toogledev','8','Change the active status of a flag on development'),
	(NULL,'zfdebug','9','Enable ZF Debug Toolbar'),
	(NULL,'zfdebug','10','Enable ZF Debug Toolbar');

/*!40000 ALTER TABLE `privileges` ENABLE KEYS */;
UNLOCK TABLES;

/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
