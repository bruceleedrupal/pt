-- MySQL dump 10.13  Distrib 5.7.30, for Linux (x86_64)
--
-- Host: localhost    Database: pt
-- ------------------------------------------------------
-- Server version	5.7.30-0ubuntu0.18.04.1

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
-- Table structure for table `package_address`
--

DROP TABLE IF EXISTS `package_address`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `package_address` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `school_id` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_82150A0DC32A47EE` (`school_id`),
  CONSTRAINT `FK_82150A0DC32A47EE` FOREIGN KEY (`school_id`) REFERENCES `school` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `package_address`
--

LOCK TABLES `package_address` WRITE;
/*!40000 ALTER TABLE `package_address` DISABLE KEYS */;
INSERT INTO `package_address` VALUES (1,1,'东一区'),(2,1,'东二区'),(3,2,'西二区'),(4,3,'韵达快递'),(5,4,'圆通快递');
/*!40000 ALTER TABLE `package_address` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `package_size`
--

DROP TABLE IF EXISTS `package_size`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `package_size` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` decimal(3,1) NOT NULL,
  `school_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_4C8D41A2C32A47EE` (`school_id`),
  CONSTRAINT `FK_4C8D41A2C32A47EE` FOREIGN KEY (`school_id`) REFERENCES `school` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `package_size`
--

LOCK TABLES `package_size` WRITE;
/*!40000 ALTER TABLE `package_size` DISABLE KEYS */;
INSERT INTO `package_size` VALUES (1,'小包',2.0,1),(2,'中包',3.0,1),(3,'大包',4.0,1),(4,'大件',2.0,4),(5,'爱民区',5.0,3);
/*!40000 ALTER TABLE `package_size` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `receive_address`
--

DROP TABLE IF EXISTS `receive_address`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `receive_address` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `school_id` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_A8A1EC0AC32A47EE` (`school_id`),
  CONSTRAINT `FK_A8A1EC0AC32A47EE` FOREIGN KEY (`school_id`) REFERENCES `school` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `receive_address`
--

LOCK TABLES `receive_address` WRITE;
/*!40000 ALTER TABLE `receive_address` DISABLE KEYS */;
INSERT INTO `receive_address` VALUES (1,1,'青溪'),(2,1,'紫云'),(3,2,'11栋'),(4,3,'男宿舍15栋'),(5,4,'无'),(6,4,'啦啦'),(7,4,'空');
/*!40000 ALTER TABLE `receive_address` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `school`
--

DROP TABLE IF EXISTS `school`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `school` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `agent_id` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `commission` decimal(3,2) NOT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `assistant_commission` decimal(3,2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_F99EDABB3414710B` (`agent_id`),
  CONSTRAINT `FK_F99EDABB3414710B` FOREIGN KEY (`agent_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `school`
--

LOCK TABLES `school` WRITE;
/*!40000 ALTER TABLE `school` DISABLE KEYS */;
INSERT INTO `school` VALUES (1,11,'浙江大学玉泉校区',0.10,0,0.15),(2,11,'同济大学嘉定校区',0.20,NULL,0.33),(3,13,'重庆大学',0.25,1,0.30),(4,13,'四川大学1',0.20,NULL,0.10),(5,14,'浙江师范大学',0.20,NULL,0.30);
/*!40000 ALTER TABLE `school` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `roles` json NOT NULL,
  `password` varchar(255) NOT NULL,
  `mobile` varchar(255) NOT NULL,
  `created` datetime NOT NULL,
  `last_login` datetime DEFAULT NULL,
  `note` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_8D93D6493C7323E0` (`mobile`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (1,'[\"ROLE_ADMIN\"]','$argon2id$v=19$m=65536,t=4,p=1$XOUN+LWxlebgZVcHiUcjLA$JwSJpc0eEpz/17Ij5zH6ZYAfj/04WfLuua8zHXC3mJw','18116381898','2020-04-01 00:00:00','2020-05-07 14:21:40',NULL),(2,'[\"ROLE_ADMIN\"]','$argon2id$v=19$m=65536,t=4,p=1$voLaABQ0AW13as+S9AWcYA$Wj4dO7bShYxlLU2J2K1k+k38rBP1jvkl2IAefUJrj+g','15523536265','2020-04-15 00:00:00','2020-05-05 22:11:19',NULL),(3,'[\"ROLE_AGENT\"]','$argon2id$v=19$m=65536,t=4,p=1$4CUsQnlC+EAtrqxxP9l8kg$IDvIaLAVUCsCAAwMTLR4kUisySwWv8L/r8xW+QR54Lw','18575515171','2020-04-15 00:00:00','2020-04-23 02:40:24','赵'),(11,'[\"ROLE_AGENT\"]','$argon2id$v=19$m=65536,t=4,p=1$eRkbssgo87cdB6eo5TZluQ$QMHqGl/Ml8SqUKevh/oMLHiDRWodNK5tMO++ej4cuPs','13586974554','2020-04-21 14:58:46','2020-04-29 18:40:15','小李'),(12,'[\"ROLE_AGENT\"]','$argon2id$v=19$m=65536,t=4,p=1$1nL1hFglf5ZLuKTsUpHQTQ$fnWnN7x9ug4EwiON0ALuMKI6m3Q/XIbxHiIDiAuRsO4','17725854422','2020-04-21 19:44:19',NULL,NULL),(13,'[\"ROLE_AGENT\"]','$argon2id$v=19$m=65536,t=4,p=1$3BRZgx4sCoJqJvN/vFz54A$BhAXwGjsDamY1HP2JhhUkHnUjfucZ+xfbeaFdDBQM74','18575515172','2020-04-21 23:56:23','2020-05-07 12:17:07','陈晓'),(14,'[\"ROLE_AGENT\"]','$argon2id$v=19$m=65536,t=4,p=1$I9fxYKiuxJ2wbgdVZbfJBQ$w2qYEunqWydArYhb7kQb+wCn2cbcYj3Kr4qDrHWRNMU','13586982831','2020-04-26 16:13:05','2020-04-26 17:26:52','张');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2020-05-07 16:58:35
