-- MySQL dump 10.13  Distrib 5.5.2-m2, for apple-darwin10.4.0 (i386)
--
-- Host: localhost    Database: app
-- ------------------------------------------------------
-- Server version	5.5.2-m2

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

CREATE DATABASE app CHARACTER SET utf8 COLLATE utf8_general_ci;

USE app;

--
-- Table structure for table `backoffice_acls`
--

DROP TABLE IF EXISTS `backoffice_acls`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `backoffice_acls` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `group_id` int(11) unsigned NOT NULL,
  `resource_id` int(11) unsigned NOT NULL,
  `privilege_id` int(11) unsigned NOT NULL,
  `allow` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=50 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `backoffice_acls`
--

LOCK TABLES `backoffice_acls` WRITE;
/*!40000 ALTER TABLE `backoffice_acls` DISABLE KEYS */;
INSERT INTO `backoffice_acls` VALUES (1,1,1,1,1),(2,1,1,2,1),(3,1,1,3,1),(4,1,1,4,1),(5,1,1,5,1),(6,1,4,12,1),(7,1,4,13,1),(8,1,4,14,1),(9,1,4,15,1),(10,1,4,16,1),(11,8,1,2,1),(12,8,1,3,1),(13,8,1,4,1),(14,8,4,16,1),(15,1,1,1,1),(16,1,1,2,1),(17,1,1,3,1),(18,1,1,4,1),(19,1,1,5,1),(20,1,3,7,1),(21,1,3,8,1),(22,1,3,9,1),(23,1,3,10,1),(24,1,3,11,1),(25,1,4,12,1),(26,1,4,13,1),(27,1,4,14,1),(28,1,4,15,1),(29,1,4,16,1),(30,2,3,7,1),(31,2,3,8,1),(32,2,3,9,1),(33,2,4,12,1),(34,2,4,13,1),(35,2,4,14,1),(36,2,4,15,1),(37,2,4,16,1),(38,3,3,10,1),(39,2,3,7,1),(40,2,3,8,1),(41,2,3,9,1),(42,2,3,10,1),(43,2,3,11,1),(44,2,4,12,1),(45,2,4,13,1),(46,2,4,14,1),(47,2,4,15,1),(48,2,4,16,1),(49,3,3,10,1);
/*!40000 ALTER TABLE `backoffice_acls` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `backoffice_groups`
--

DROP TABLE IF EXISTS `backoffice_groups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `backoffice_groups` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(25) DEFAULT NULL,
  `parent_id` int(11) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`),
  KEY `idx_name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `backoffice_groups`
--

LOCK TABLES `backoffice_groups` WRITE;
/*!40000 ALTER TABLE `backoffice_groups` DISABLE KEYS */;
INSERT INTO `backoffice_groups` VALUES (1,'administrators',0),(2,'members',0),(3,'guests',0);
/*!40000 ALTER TABLE `backoffice_groups` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `backoffice_password_log`
--

DROP TABLE IF EXISTS `backoffice_password_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `backoffice_password_log` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `password` varchar(40) NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `backoffice_password_log`
--

LOCK TABLES `backoffice_password_log` WRITE;
/*!40000 ALTER TABLE `backoffice_password_log` DISABLE KEYS */;
/*!40000 ALTER TABLE `backoffice_password_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `backoffice_privileges`
--

DROP TABLE IF EXISTS `backoffice_privileges`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `backoffice_privileges` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `resource_id` varchar(20) NOT NULL,
  `description` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`,`resource_id`),
  KEY `idx_resource_id` (`resource_id`)
) ENGINE=InnoDB AUTO_INCREMENT=49 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `backoffice_privileges`
--

LOCK TABLES `backoffice_privileges` WRITE;
/*!40000 ALTER TABLE `backoffice_privileges` DISABLE KEYS */;
INSERT INTO `backoffice_privileges` VALUES (1,'index','1','Allows the user to view all the user groups registered\nin the application'),(2,'add','1','Allows the user to add another user group in the\napplication'),(3,'edit','1','Edits an existing user group'),(4,'delete','1','Allows the user to delete an existing user group. All the users attached to\nthis group *WILL NOT* be deleted, they will just lose all'),(5,'permissions','1','Allows the user to manage individual permissions for each\nuser group'),(6,'index','2','Controller\'s entry point'),(7,'index','3','Allows users to see their dashboards'),(8,'edit','3','Allows the users to update their profiles'),(9,'change-password','3','Allows users to change their passwords'),(10,'login','3','Allows users to log into the application'),(11,'logout','3','Allows users to log out of the application'),(12,'index','4','Allows users to see all other users that are registered in\nthe application'),(13,'add','4','Allows users to add new users in the application\n(should be reserved for administrators)'),(14,'edit','4','Allows users to edit another users\' data\n(should be reserved for administrators)'),(15,'view','4','Allows users to see other users\' profiles'),(16,'delete','4','Allows users to logically delete other users\n(should be reserved for administrators)');
/*!40000 ALTER TABLE `backoffice_privileges` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `backoffice_resources`
--

DROP TABLE IF EXISTS `backoffice_resources`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `backoffice_resources` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `description` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `backoffice_resources`
--

LOCK TABLES `backoffice_resources` WRITE;
/*!40000 ALTER TABLE `backoffice_resources` DISABLE KEYS */;
INSERT INTO `backoffice_resources` VALUES (1,'groups','Allows user to manage the user groups'),(2,'index','Default entry point in the application'),(3,'profile','Allows user to manage their profile data'),(4,'users','Allows the users to perform CRUD operations on other users');
/*!40000 ALTER TABLE `backoffice_resources` ENABLE KEYS */;
UNLOCK TABLES;

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
INSERT INTO `backoffice_users` VALUES (1,'John','Doe :)','john.doe','6c64e8dcebc17e3d08546a355b52817f63eb6fe2',0,'john@doe.es','987654321','2010-10-17 21:11:35','2010-10-14 15:53:44'),(4,'Member','Test','member.test','6c64e8dcebc17e3d08546a355b52817f63eb6fe2',0,'member@test.com','1234567890','2010-10-17 08:53:22','2010-10-16 20:26:54');
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
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2010-10-17 23:12:04
