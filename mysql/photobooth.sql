-- MySQL dump 10.17  Distrib 10.3.18-MariaDB, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: photobooth
-- ------------------------------------------------------
-- Server version	10.3.18-MariaDB-0+deb10u1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `event`
--

DROP TABLE IF EXISTS `event`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `event` (
  `eventID` int(11) NOT NULL AUTO_INCREMENT,
  `eventDate` date NOT NULL,
  `eventName` varchar(60) NOT NULL,
  `eventLat` float DEFAULT NULL,
  `eventLon` float DEFAULT NULL,
  `eventUrl` varchar(60) DEFAULT NULL,
  PRIMARY KEY (`eventID`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `event`
--

LOCK TABLES `event` WRITE;
/*!40000 ALTER TABLE `event` DISABLE KEYS */;
INSERT INTO `event` VALUES (1,'2019-12-18','test1',NULL,NULL,NULL);
/*!40000 ALTER TABLE `event` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `photo`
--

DROP TABLE IF EXISTS `photo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `photo` (
  `photoID` int(11) NOT NULL AUTO_INCREMENT,
  `eventID` int(11) DEFAULT NULL,
  `photoName` varchar(60) DEFAULT NULL,
  `photoTime` time DEFAULT current_timestamp(),
  `photoDate` date DEFAULT current_timestamp(),
  PRIMARY KEY (`photoID`),
  KEY `photo_ibfk_1` (`eventID`),
  CONSTRAINT `photo_ibfk_1` FOREIGN KEY (`eventID`) REFERENCES `event` (`eventID`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `photo`
--

LOCK TABLES `photo` WRITE;
/*!40000 ALTER TABLE `photo` DISABLE KEYS */;
INSERT INTO `photo` VALUES (1,1,'20200107_115435.jpg','12:54:35','2020-01-07'),(2,1,'20200107_131830.jpg','14:18:30','2020-01-07'),(3,1,'','09:14:32','2020-01-09'),(4,1,'','09:14:49','2020-01-09'),(5,1,'','09:15:10','2020-01-09'),(6,1,'20200109_081552.jpg','09:15:52','2020-01-09'),(7,1,'20200109_131551.jpg','14:15:51','2020-01-09'),(8,1,'20200109_131605.jpg','14:16:17','2020-01-09'),(9,1,'20200110_121851.jpg','12:18:51','2020-01-10'),(10,1,'20200110_134511.jpg','13:45:25','2020-01-10'),(11,1,'271430ce233bb50efe559249bb7eeec4.jpg','14:26:02','2020-01-22'),(12,1,'20200122_142642.jpg','14:26:57','2020-01-22'),(13,1,'20200123_162913.jpg','16:29:13','2020-01-23'),(14,1,'20200123_165144.jpg','16:52:00','2020-01-23'),(15,1,'20200124_171334.jpg','17:13:50','2020-01-24'),(16,1,'20200124_171448.jpg','17:15:04','2020-01-24'),(17,1,'20200124_171514.jpg','17:15:30','2020-01-24'),(18,1,'20200210_082525.jpg','08:25:25','2020-02-10'),(19,1,'20200210_082544.jpg','08:25:59','2020-02-10'),(20,1,'20200211_085251.jpg','08:52:51','2020-02-11'),(21,1,'20200211_085400.jpg','08:54:01','2020-02-11'),(22,1,'20200226_205255.jpg','20:52:55','2020-02-26'),(23,1,'20200226_205351.jpg','20:53:51','2020-02-26'),(24,1,'20200227_140458.jpg','14:04:58','2020-02-27');
/*!40000 ALTER TABLE `photo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `print`
--

DROP TABLE IF EXISTS `print`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `print` (
  `printID` int(11) NOT NULL AUTO_INCREMENT,
  `eventID` int(11) DEFAULT NULL,
  `printName` varchar(60) DEFAULT NULL,
  `printTime` time DEFAULT current_timestamp(),
  `printDate` date DEFAULT current_timestamp(),
  PRIMARY KEY (`printID`),
  KEY `print_ibfk_1` (`eventID`),
  CONSTRAINT `print_ibfk_1` FOREIGN KEY (`eventID`) REFERENCES `event` (`eventID`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `print`
--

LOCK TABLES `print` WRITE;
/*!40000 ALTER TABLE `print` DISABLE KEYS */;
INSERT INTO `print` VALUES (1,1,'20200110_134511.jpg','13:45:34','2020-01-10');
/*!40000 ALTER TABLE `print` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `temp`
--

DROP TABLE IF EXISTS `temp`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `temp` (
  `tempID` int(11) NOT NULL AUTO_INCREMENT,
  `eventID` int(11) DEFAULT NULL,
  `tempTemp` double DEFAULT NULL,
  `tempHumidity` float DEFAULT NULL,
  `tempPressure` float DEFAULT NULL,
  `tempTime` time DEFAULT current_timestamp(),
  `tempDate` date DEFAULT current_timestamp(),
  PRIMARY KEY (`tempID`),
  KEY `temp_ibfk_1` (`eventID`),
  CONSTRAINT `temp_ibfk_1` FOREIGN KEY (`eventID`) REFERENCES `event` (`eventID`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `temp`
--

LOCK TABLES `temp` WRITE;
/*!40000 ALTER TABLE `temp` DISABLE KEYS */;
INSERT INTO `temp` VALUES (1,1,23.19,NULL,NULL,'15:55:36','2020-01-12'),(2,1,23.25,NULL,NULL,'15:55:40','2020-01-12'),(3,1,23.25,NULL,NULL,'15:55:44','2020-01-12'),(4,1,23.19,NULL,NULL,'15:55:47','2020-01-12'),(5,1,23.19,NULL,NULL,'15:56:00','2020-01-12'),(6,1,23.19,NULL,NULL,'15:56:03','2020-01-12'),(7,1,23.25,NULL,NULL,'15:56:07','2020-01-12'),(8,1,23.25,NULL,NULL,'15:56:11','2020-01-12'),(9,1,23.25,NULL,NULL,'15:56:14','2020-01-12'),(10,1,23.25,NULL,NULL,'15:56:18','2020-01-12'),(11,1,23.25,NULL,NULL,'15:56:22','2020-01-12'),(12,1,23.19,NULL,NULL,'15:56:25','2020-01-12'),(13,1,23.25,NULL,NULL,'15:56:29','2020-01-12'),(14,1,23.25,NULL,NULL,'15:56:33','2020-01-12'),(15,1,23.25,NULL,NULL,'15:56:36','2020-01-12'),(16,1,23.25,NULL,NULL,'15:56:40','2020-01-12'),(17,1,23.25,NULL,NULL,'15:56:44','2020-01-12'),(18,1,23.19,NULL,NULL,'15:56:47','2020-01-12'),(19,1,23.25,NULL,NULL,'15:56:51','2020-01-12'),(20,1,23.19,NULL,NULL,'15:56:55','2020-01-12'),(21,1,23.19,NULL,NULL,'15:56:58','2020-01-12'),(22,1,23.25,NULL,NULL,'15:57:02','2020-01-12'),(23,1,23.25,NULL,NULL,'15:57:06','2020-01-12'),(24,1,23.31,NULL,NULL,'15:57:09','2020-01-12'),(25,1,23.25,NULL,NULL,'15:57:13','2020-01-12'),(26,1,23.25,NULL,NULL,'15:57:17','2020-01-12'),(27,1,23.25,NULL,NULL,'15:57:20','2020-01-12'),(28,1,23.25,NULL,NULL,'15:57:33','2020-01-12');
/*!40000 ALTER TABLE `temp` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2020-03-21 23:13:20
