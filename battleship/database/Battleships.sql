CREATE DATABASE  IF NOT EXISTS `battleship` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */;
USE `battleship`;
-- MySQL dump 10.13  Distrib 8.0.36, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: battleship
-- ------------------------------------------------------
-- Server version	5.5.5-10.4.32-MariaDB

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
-- Table structure for table `entity_games`
--

DROP TABLE IF EXISTS `entity_games`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `entity_games` (
  `id_game` mediumint(7) NOT NULL,
  PRIMARY KEY (`id_game`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `entity_games`
--

LOCK TABLES `entity_games` WRITE;
/*!40000 ALTER TABLE `entity_games` DISABLE KEYS */;
INSERT INTO `entity_games` VALUES (1),(2);
/*!40000 ALTER TABLE `entity_games` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `entity_players`
--

DROP TABLE IF EXISTS `entity_players`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `entity_players` (
  `id_player` mediumint(7) NOT NULL,
  `board_ships` varchar(2000) DEFAULT NULL,
  `board_shots` varchar(2000) DEFAULT NULL,
  `type` varchar(1) DEFAULT NULL,
  `ai_last_shot` varchar(50) DEFAULT NULL,
  `ai_held_shot` varchar(50) DEFAULT NULL,
  `ai_state` int(1) DEFAULT NULL,
  `ai_cons_misses` int(7) DEFAULT NULL,
  `player_number` mediumint(1) DEFAULT NULL,
  `ships_health` varchar(500) DEFAULT NULL,
  PRIMARY KEY (`id_player`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `entity_players`
--

LOCK TABLES `entity_players` WRITE;
/*!40000 ALTER TABLE `entity_players` DISABLE KEYS */;
INSERT INTO `entity_players` VALUES (1,'{JSON}','{JSON}','1',NULL,NULL,NULL,NULL,1,'{JSON}'),(2,'{JSON}','{JSON}','2','d4','d2',1,3,2,'{JSON}'),(3,'{JSON}','{JSON}','2','a3',NULL,0,6,1,'{JSON}'),(4,'{JSON}','{JSON}','3','f1','f3',1,0,2,'{JSON}');
/*!40000 ALTER TABLE `entity_players` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `entity_users`
--

DROP TABLE IF EXISTS `entity_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `entity_users` (
  `id_user` mediumint(7) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) DEFAULT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `middle_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `password` varchar(60) DEFAULT NULL,
  PRIMARY KEY (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `entity_users`
--

LOCK TABLES `entity_users` WRITE;
/*!40000 ALTER TABLE `entity_users` DISABLE KEYS */;
INSERT INTO `entity_users` VALUES (1,'hansintheair','Hannes','M.','Ziegler','hansintheair@email.com','hanssafepwd#1'),(2,'mathewnex12','Mathew',NULL,NULL,'mathew@email.com','mathsafepws#1'),(3,NULL,NULL,NULL,NULL,'anthonyb@whatever.com','$2y$10$gfu55oHnA'),(4,NULL,NULL,NULL,NULL,'anthonyb@gmail.com','$2y$10$m2JxRNV.v'),(5,NULL,NULL,NULL,NULL,'anthony123@whatever.com','$2y$10$TsT4AdnO8'),(6,NULL,NULL,NULL,NULL,'anthony1234@whatever.com','$2y$10$IroyvDBwZ');
/*!40000 ALTER TABLE `entity_users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `xref_games_players`
--

DROP TABLE IF EXISTS `xref_games_players`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `xref_games_players` (
  `id_game_players` mediumint(7) NOT NULL,
  `id_game` mediumint(7) DEFAULT NULL,
  `id_player` mediumint(7) DEFAULT NULL,
  PRIMARY KEY (`id_game_players`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `xref_games_players`
--

LOCK TABLES `xref_games_players` WRITE;
/*!40000 ALTER TABLE `xref_games_players` DISABLE KEYS */;
INSERT INTO `xref_games_players` VALUES (1,1,1),(2,1,2),(3,2,3),(4,2,4);
/*!40000 ALTER TABLE `xref_games_players` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `xref_users_games`
--

DROP TABLE IF EXISTS `xref_users_games`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `xref_users_games` (
  `id_user_games` mediumint(7) NOT NULL AUTO_INCREMENT,
  `id_user` mediumint(7) DEFAULT NULL,
  `id_game` mediumint(7) DEFAULT NULL,
  PRIMARY KEY (`id_user_games`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `xref_users_games`
--

LOCK TABLES `xref_users_games` WRITE;
/*!40000 ALTER TABLE `xref_users_games` DISABLE KEYS */;
INSERT INTO `xref_users_games` VALUES (1,1,1),(2,2,2);
/*!40000 ALTER TABLE `xref_users_games` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-05-22  1:23:23
