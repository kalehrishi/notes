-- MySQL dump 10.13  Distrib 5.7.5-m15, for Linux (x86_64)
--
-- Host: localhost    Database: Notes_database
-- ------------------------------------------------------
-- Server version	5.7.5-m15

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `NoteTags`
--

DROP TABLE IF EXISTS `NoteTags`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `NoteTags` (
  `noteTagId` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `noteId` bigint(20) unsigned NOT NULL,
  `userTagId` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`noteTagId`),
  KEY `fk_notes_noteId_idx` (`noteId`),
  KEY `fk_userTags_userTagId_idx` (`userTagId`),
  CONSTRAINT `fk_notes_noteId` FOREIGN KEY (`noteId`) REFERENCES `Notes` (`noteId`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_userTags_userTagId` FOREIGN KEY (`userTagId`) REFERENCES `UserTags` (`userTagId`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `Notes`
--

DROP TABLE IF EXISTS `Notes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Notes` (
  `noteId` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `userId` bigint(20) unsigned NOT NULL,
  `title` varchar(1024) NOT NULL,
  `body` varchar(1024) DEFAULT NULL,
  `createdOn` datetime NOT NULL,
  `lastUpdateOn` datetime NOT NULL,
  `isDeleted` bit(1) NOT NULL DEFAULT b'0',
  PRIMARY KEY (`noteId`),
  KEY `fk_users_userId_idx` (`userId`),
  CONSTRAINT `fk_users_userId` FOREIGN KEY (`userId`) REFERENCES `Users` (`userId`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `Sessions`
--

DROP TABLE IF EXISTS `Sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Sessions` (
  `sessionId` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `userId` bigint(20) unsigned NOT NULL,
  `createdOn` datetime NOT NULL,
  `expiredOn` datetime NOT NULL,
  `isExpired` bit(1) NOT NULL DEFAULT b'0',
  PRIMARY KEY (`sessionId`),
  KEY `fk2_users_userId_idx` (`userId`),
  CONSTRAINT `fk2_users_userId` FOREIGN KEY (`userId`) REFERENCES `Users` (`userId`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `UserTags`
--

DROP TABLE IF EXISTS `UserTags`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `UserTags` (
  `userTagId` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `userId` bigint(20) unsigned NOT NULL,
  `tag` varchar(1024) DEFAULT NULL,
  PRIMARY KEY (`userTagId`),
  KEY `fk_users_userId_idx` (`userId`),
  CONSTRAINT `fk1_users_userId` FOREIGN KEY (`userId`) REFERENCES `Users` (`userId`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `Users`
--

DROP TABLE IF EXISTS `Users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Users` (
  `userId` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `firstName` varchar(1024) NOT NULL,
  `lastName` varchar(1024) NOT NULL,
  `emailId` varchar(1024) NOT NULL,
  `password` varchar(32) NOT NULL,
  `createdOn` datetime NOT NULL,
  PRIMARY KEY (`userId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2015-01-22  3:22:02
