-- MySQL dump 10.13  Distrib 5.1.51, for apple-darwin10.4.0 (i386)
--
-- Host: localhost    Database: casting
-- ------------------------------------------------------
-- Server version	5.1.51

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `backoffice_users`
--

DROP TABLE IF EXISTS `backoffice_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `backoffice_users`
--

LOCK TABLES `backoffice_users` WRITE;
/*!40000 ALTER TABLE `backoffice_users` DISABLE KEYS */;
INSERT INTO `backoffice_users` VALUES (1,'John','Doe','john.doe','6c64e8dcebc17e3d08546a355b52817f63eb6fe2',0,'john@doe.es','987654321','2010-10-19 16:04:04','2010-10-14 15:53:44'),(4,'Member','Test','member.test','6c64e8dcebc17e3d08546a355b52817f63eb6fe2',0,'member@test.com','1234567890','2010-10-19 10:06:36','2010-10-16 20:26:54');
/*!40000 ALTER TABLE `backoffice_users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `backoffice_users_groups`
--

DROP TABLE IF EXISTS `backoffice_users_groups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `backoffice_users_groups` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `group_id` int(11) unsigned NOT NULL,
  `user_id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_user_id` (`user_id`),
  KEY `idx_group_id` (`group_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `backoffice_users_groups`
--

LOCK TABLES `backoffice_users_groups` WRITE;
/*!40000 ALTER TABLE `backoffice_users_groups` DISABLE KEYS */;
INSERT INTO `backoffice_users_groups` VALUES (2,1,1),(3,2,4);
/*!40000 ALTER TABLE `backoffice_users_groups` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `flags`
--

DROP TABLE IF EXISTS `flags`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `flags` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `description` varchar(255) NOT NULL,
  `active_on_dev` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `active_on_prod` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `flags`
--

LOCK TABLES `flags` WRITE;
/*!40000 ALTER TABLE `flags` DISABLE KEYS */;
INSERT INTO `flags` VALUES (1,'backoffice-groups','Allows user to manage the user groups',1,0),(2,'backoffice-index','Default entry point in the application',1,0),(3,'backoffice-privileges','Allows the users to perform CRUD operations on privileges',1,0),(4,'backoffice-profile','Allows user to manage their profile data',1,0),(5,'backoffice-system','Allow the admins to manage critical info, users, groups, permissions, etc.',1,0),(6,'backoffice-users','Allows the users to perform CRUD operations on other users',1,0),(7,'frontend-index','Default entry point in the application',1,0),(8,'backoffice-flags','Allows user to manage the flags',1,0);
/*!40000 ALTER TABLE `flags` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `flippers`
--

DROP TABLE IF EXISTS `flippers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `flippers` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `group_id` int(11) unsigned NOT NULL,
  `flag_id` int(11) unsigned NOT NULL,
  `privilege_id` int(11) unsigned NOT NULL,
  `allow` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `flippers`
--

LOCK TABLES `flippers` WRITE;
/*!40000 ALTER TABLE `flippers` DISABLE KEYS */;
INSERT INTO `flippers` VALUES (1,1,1,1,1),(2,1,1,2,1),(3,1,1,3,1),(4,1,1,4,1),(5,1,1,5,1),(6,1,2,6,1),(7,1,3,7,1),(8,1,3,8,1),(9,1,3,9,1),(10,1,3,10,1),(11,1,4,11,1),(12,1,4,12,1),(13,1,4,13,1),(14,1,4,14,1),(15,1,4,15,1),(16,1,5,16,1),(17,1,5,17,1),(18,1,6,18,1),(19,1,6,19,1),(20,1,6,20,1),(21,1,6,21,1),(22,1,6,22,1),(23,1,7,23,1),(24,1,7,24,1),(25,2,4,11,1),(26,2,4,12,1),(27,2,4,13,1),(28,2,4,14,1),(29,2,4,15,1),(30,2,7,23,1),(31,2,7,24,1),(32,3,4,14,1),(33,3,4,14,1),(34,3,7,23,1),(35,3,4,14,1),(36,3,7,23,1),(37,3,4,14,1),(38,3,7,23,1),(39,3,7,24,1);
/*!40000 ALTER TABLE `flippers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `groups`
--

DROP TABLE IF EXISTS `groups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `groups` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(25) DEFAULT NULL,
  `parent_id` int(11) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`),
  KEY `idx_name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `groups`
--

LOCK TABLES `groups` WRITE;
/*!40000 ALTER TABLE `groups` DISABLE KEYS */;
INSERT INTO `groups` VALUES (1,'administrators',0),(2,'members',0),(3,'guests',0);
/*!40000 ALTER TABLE `groups` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_log`
--

DROP TABLE IF EXISTS `password_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `password_log` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `password` varchar(40) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_log`
--

LOCK TABLES `password_log` WRITE;
/*!40000 ALTER TABLE `password_log` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `privileges`
--

DROP TABLE IF EXISTS `privileges`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `privileges` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `flag_id` varchar(20) NOT NULL,
  `description` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`,`flag_id`),
  KEY `idx_resource_id` (`flag_id`)
) ENGINE=InnoDB AUTO_INCREMENT=98 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `privileges`
--

LOCK TABLES `privileges` WRITE;
/*!40000 ALTER TABLE `privileges` DISABLE KEYS */;
INSERT INTO `privileges` VALUES (1,'index','1','Allows the user to view all the user groups registered\nin the application'),(2,'add','1','Allows the user to add another user group in the\napplication'),(3,'edit','1','Edits an existing user group'),(4,'delete','1','Allows the user to delete an existing user group. All the users attached to\nthis group *WILL NOT* be deleted, they will just lose all'),(5,'flippers','1','Allows the user to manage individual permissions for each\nuser group'),(6,'index','2','Controller\'s entry point'),(7,'index','3','Allows the user to view all the permissions registered\nin the application'),(8,'add','3','Allows the user to add another privilege in the application'),(9,'edit','3','Edits an existing privilege'),(10,'delete','3','Allows the user to delete an existing privilege. All the acl\'s related to\nthis privilege will be removed'),(11,'index','4','Allows users to see their dashboards'),(12,'edit','4','Allows the users to update their profiles'),(13,'change-password','4','Allows users to change their passwords'),(14,'login','4','Allows users to log into the application'),(15,'logout','4','Allows users to log out of the application'),(16,'index','5','Controller\'s entry point'),(17,'example','5','Theme example page'),(18,'index','6','Allows users to see all other users that are registered in\nthe application'),(19,'add','6','Allows users to add new users in the application\n(should be reserved for administrators)'),(20,'edit','6','Allows users to edit another users\' data\n(should be reserved for administrators)'),(21,'view','6','Allows users to see other users\' profiles'),(22,'delete','6','Allows users to logically delete other users\n(should be reserved for administrators)'),(23,'index','7','Controller\'s entry point'),(24,'static','7','Static Pages'),(25,'index','8','Allows the user to view all the flags registered in the application'),(48,'toogle-prod','8','Change the active status of a flag on production'),(49,'toogle-dev','8','Change the active status of a flag on development');
/*!40000 ALTER TABLE `privileges` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `subscriptions`
--

DROP TABLE IF EXISTS `subscriptions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `subscriptions` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `amount` float DEFAULT '0',
  `rebill_period` int(2) NOT NULL DEFAULT '1',
  `currency_iso` varchar(3) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `updated_by` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `subscriptions`
--

LOCK TABLES `subscriptions` WRITE;
/*!40000 ALTER TABLE `subscriptions` DISABLE KEYS */;
/*!40000 ALTER TABLE `subscriptions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(40) DEFAULT NULL,
  `birth` date DEFAULT NULL,
  `gender` varchar(1) DEFAULT NULL,
  `type` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `city_woeid` int(11) unsigned DEFAULT NULL,
  `country_woeid` int(11) unsigned DEFAULT NULL,
  `country_iso` varchar(2) DEFAULT NULL,
  `subscription_id` int(11) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_email` (`email`),
  KEY `idx_email` (`email`),
  KEY `idx_city_woeid` (`city_woeid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2010-10-19 19:06:14
