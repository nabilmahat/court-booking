CREATE DATABASE  IF NOT EXISTS `court_booking` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_bin */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `court_booking`;
-- MySQL dump 10.13  Distrib 8.0.38, for Win64 (x86_64)
--
-- Host: localhost    Database: court_booking
-- ------------------------------------------------------
-- Server version	8.0.38

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `booking_teams`
--

DROP TABLE IF EXISTS `booking_teams`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `booking_teams` (
  `id` int NOT NULL AUTO_INCREMENT,
  `booking_id` varchar(45) COLLATE utf8mb4_bin DEFAULT NULL,
  `team_id` varchar(45) COLLATE utf8mb4_bin DEFAULT NULL,
  `team_order` int DEFAULT NULL,
  `bill_id` varchar(45) COLLATE utf8mb4_bin DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `booking_teams`
--

LOCK TABLES `booking_teams` WRITE;
/*!40000 ALTER TABLE `booking_teams` DISABLE KEYS */;
INSERT INTO `booking_teams` VALUES (1,'1','1',1,NULL),(2,'1','2',2,NULL),(3,'2','3',1,NULL),(4,'2','4',2,NULL),(5,'3','5',1,NULL),(6,'3','6',2,NULL),(7,'4','7',1,NULL),(8,'4','8',2,NULL),(9,'5','9',1,'0'),(10,'5','10',2,'0'),(11,'6','11',1,'REF-20240911-XTMHS7');
/*!40000 ALTER TABLE `booking_teams` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `bookings`
--

DROP TABLE IF EXISTS `bookings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `bookings` (
  `id` int NOT NULL AUTO_INCREMENT,
  `booking_date` varchar(45) COLLATE utf8mb4_bin DEFAULT NULL,
  `booking_slot` varchar(45) COLLATE utf8mb4_bin DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bookings`
--

LOCK TABLES `bookings` WRITE;
/*!40000 ALTER TABLE `bookings` DISABLE KEYS */;
INSERT INTO `bookings` VALUES (1,'2024-09-11','0'),(2,'2024-09-11','1'),(3,'2024-09-11','2'),(4,'2024-09-30','3'),(5,'2024-09-11','10'),(6,'2024-09-11','3');
/*!40000 ALTER TABLE `bookings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `teams`
--

DROP TABLE IF EXISTS `teams`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `teams` (
  `id` int NOT NULL AUTO_INCREMENT,
  `team_name` varchar(45) COLLATE utf8mb4_bin DEFAULT NULL,
  `booking_name` varchar(45) COLLATE utf8mb4_bin DEFAULT NULL,
  `booking_contact_number` varchar(45) COLLATE utf8mb4_bin DEFAULT NULL,
  `jersey_color` varchar(45) COLLATE utf8mb4_bin DEFAULT NULL,
  `team_age` varchar(45) COLLATE utf8mb4_bin DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `teams`
--

LOCK TABLES `teams` WRITE;
/*!40000 ALTER TABLE `teams` DISABLE KEYS */;
INSERT INTO `teams` VALUES (1,'Fut1','Fooot One','0125346844','#FFFF00','semi_vet'),(2,'Fut2','Fooot Two','0183536577','#000000','semi_vet'),(3,'Fut2','Damak','0135436544','#000000','vet'),(4,'WD Transparent','Damak','','#C0C0C0','vet'),(5,'Mambang Huong','Damak 2','0135436542','#000000','vet'),(6,'Fut2','Fooot Two','0183536577','#808080','vet'),(7,'Mambang Huong','Damak 2','0135436542','#000000','vet'),(8,'WD Transparent','Damak 2','0125346844','#FFFFFF','vet'),(9,'Mambang Huong','Damak 2','0135436542','#FF0000','semi_vet'),(10,'Mambang Huong 2','Damak','0135436544','#FFFFFF','vet'),(11,'Mambang Huong 2sf','Damak 2','0135436542','#FFFFFF','vet');
/*!40000 ALTER TABLE `teams` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(45) COLLATE utf8mb4_bin DEFAULT NULL,
  `password` varchar(45) COLLATE utf8mb4_bin DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'admin','admin');
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

-- Dump completed on 2024-09-11 15:48:42
