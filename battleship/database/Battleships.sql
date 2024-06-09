CREATE DATABASE  IF NOT EXISTS `battleship` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */;
USE `battleship`;
-- MariaDB dump 10.19  Distrib 10.4.32-MariaDB, for Win64 (AMD64)
--
-- Host: 127.0.0.1    Database: battleship
-- ------------------------------------------------------
-- Server version	10.4.32-MariaDB

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
-- Table structure for table `entity_games`
--

DROP TABLE IF EXISTS `entity_games`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `entity_games` (
  `id_game` mediumint(7) NOT NULL,
  `p1` varchar(3000) DEFAULT NULL,
  `p2` varchar(3000) DEFAULT NULL,
  PRIMARY KEY (`id_game`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `entity_games`
--

LOCK TABLES `entity_games` WRITE;
/*!40000 ALTER TABLE `entity_games` DISABLE KEYS */;
INSERT INTO `entity_games` VALUES (8,'{\"ships\":[[\"P\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"C\"],[\"P\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"C\"],[\"D\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"C\"],[\"D\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"C\"],[\"D\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"C\"],[\"B\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"S\"],[\"B\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"S\"],[\"B\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"S\"],[\"B\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\"],[\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\"]],\"shots\":[[\"-\",\"-\",\"-\",\"-\",\"-\",\"-\",\"-\",\"-\",\"-\",\"-\"],[\"-\",\"-\",\"-\",\"-\",\"-\",\"-\",\"-\",\"-\",\"-\",\"-\"],[\"-\",\"-\",\"-\",\"-\",\"-\",\"-\",\"-\",\"-\",\"-\",\"-\"],[\"-\",\"-\",\"-\",\"-\",\"-\",\"-\",\"M\",\"-\",\"-\",\"-\"],[\"-\",\"-\",\"-\",\"-\",\"-\",\"-\",\"-\",\"-\",\"-\",\"-\"],[\"-\",\"-\",\"-\",\"-\",\"-\",\"-\",\"-\",\"-\",\"-\",\"-\"],[\"-\",\"-\",\"-\",\"-\",\"-\",\"-\",\"-\",\"-\",\"-\",\"-\"],[\"-\",\"-\",\"-\",\"-\",\"-\",\"-\",\"-\",\"-\",\"-\",\"-\"],[\"-\",\"-\",\"-\",\"-\",\"-\",\"-\",\"-\",\"-\",\"-\",\"-\"],[\"-\",\"-\",\"-\",\"-\",\"-\",\"-\",\"-\",\"-\",\"-\",\"-\"]],\"placedShips\":[{\"ship\":\"Carrier [5 Squares]\",\"row\":0,\"col\":9,\"length\":5,\"orientation\":\"Vertical\"},{\"ship\":\"Destroyer [3 Squares]\",\"row\":2,\"col\":0,\"length\":3,\"orientation\":\"Vertical\"},{\"ship\":\"Battleship [4 Squares]\",\"row\":5,\"col\":0,\"length\":4,\"orientation\":\"Vertical\"},{\"ship\":\"Submarine [3 Squares]\",\"row\":5,\"col\":9,\"length\":3,\"orientation\":\"Vertical\"},{\"ship\":\"Patrol Boat [2 Squares]\",\"row\":0,\"col\":0,\"length\":2,\"orientation\":\"Vertical\"}],\"shipHealth\":{\"Carrier [5 Squares]\":5,\"Battleship [4 Squares]\":4,\"Destroyer [3 Squares]\":3,\"Submarine [3 Squares]\":2,\"Patrol Boat [2 Squares]\":2}}','{\"ships\":[[\"\",\"B\",\"P\",\"P\",\"C\",\"C\",\"C\",\"C\",\"C\",\"\"],[\"\",\"B\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\"],[\"\",\"B\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\"],[\"\",\"B\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\"],[\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\"],[\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\"],[\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\"],[\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\"],[\"\",\"\",\"\",\"D\",\"D\",\"D\",\"\",\"\",\"\",\"\"],[\"\",\"\",\"\",\"\",\"S\",\"S\",\"S\",\"\",\"\",\"\"]],\"shots\":[[\"-\",\"-\",\"-\",\"-\",\"-\",\"-\",\"-\",\"-\",\"-\",\"-\"],[\"-\",\"-\",\"-\",\"-\",\"-\",\"-\",\"-\",\"-\",\"-\",\"-\"],[\"-\",\"-\",\"-\",\"-\",\"-\",\"-\",\"-\",\"-\",\"-\",\"-\"],[\"-\",\"-\",\"-\",\"-\",\"-\",\"-\",\"-\",\"-\",\"-\",\"-\"],[\"-\",\"-\",\"-\",\"-\",\"-\",\"-\",\"-\",\"-\",\"-\",\"-\"],[\"-\",\"-\",\"-\",\"-\",\"-\",\"-\",\"-\",\"-\",\"-\",\"H\"],[\"-\",\"-\",\"-\",\"-\",\"-\",\"-\",\"-\",\"-\",\"-\",\"-\"],[\"-\",\"-\",\"-\",\"-\",\"-\",\"-\",\"-\",\"-\",\"-\",\"-\"],[\"-\",\"-\",\"-\",\"-\",\"-\",\"-\",\"-\",\"-\",\"-\",\"-\"],[\"-\",\"-\",\"-\",\"-\",\"-\",\"-\",\"-\",\"-\",\"-\",\"-\"]],\"placedShips\":[],\"shipHealth\":{\"Carrier [5 Squares]\":5,\"Battleship [4 Squares]\":4,\"Destroyer [3 Squares]\":3,\"Submarine [3 Squares]\":3,\"Patrol Boat [2 Squares]\":2}}');
/*!40000 ALTER TABLE `entity_games` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `entity_users`
--

DROP TABLE IF EXISTS `entity_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `entity_users` (
  `id_user` mediumint(7) NOT NULL AUTO_INCREMENT,
  `email` varchar(50) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `isAdmin` tinyint(1) DEFAULT NULL,
  `wins` mediumint(7) DEFAULT NULL,
  `losses` mediumint(7) DEFAULT NULL,
  PRIMARY KEY (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `entity_users`
--

LOCK TABLES `entity_users` WRITE;
/*!40000 ALTER TABLE `entity_users` DISABLE KEYS */;
INSERT INTO `entity_users` VALUES (8,'hansintheair@email.com','$2y$10$1r24aSZp3NgXMbMKAdtEfOYFPbYw.A0wkKHqV6Ac4L/DJYMvUZT3K',NULL,NULL,NULL);
/*!40000 ALTER TABLE `entity_users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-06-08 17:06:10
