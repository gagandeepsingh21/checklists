-- MariaDB dump 10.19  Distrib 10.6.12-MariaDB, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: checklists
-- ------------------------------------------------------
-- Server version	10.6.12-MariaDB-1:10.6.12+maria~deb11

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
-- Table structure for table `buildings`
--

DROP TABLE IF EXISTS `buildings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `buildings` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL DEFAULT 0,
  `building_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `buildings_user_id_foreign` (`user_id`),
  CONSTRAINT `buildings_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `buildings`
--

LOCK TABLES `buildings` WRITE;
/*!40000 ALTER TABLE `buildings` DISABLE KEYS */;
INSERT INTO `buildings` VALUES (1,6,'MSB','2023-04-24 23:31:42','2023-04-24 23:31:42',NULL),(2,7,'Sample Building','2023-04-25 08:44:35','2023-04-25 08:44:35',NULL),(3,9,'STMB','2023-05-15 00:38:40','2023-05-15 00:38:40',NULL),(4,9,'CENTRAL BUILDING','2023-05-15 00:38:51','2023-05-15 00:38:51',NULL),(5,4,'Oval Building','2023-05-17 07:47:08','2023-05-17 07:47:08',NULL),(6,4,'SBS','2023-05-17 07:56:25','2023-05-17 07:56:25',NULL),(7,6,'Main Auditorium','2023-07-04 10:33:29','2023-07-04 10:33:29',NULL);
/*!40000 ALTER TABLE `buildings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `checklist_class`
--

DROP TABLE IF EXISTS `checklist_class`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `checklist_class` (
  `checklist_id` bigint(20) unsigned NOT NULL,
  `class_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`checklist_id`,`class_id`),
  KEY `checklist_class_class_id_foreign` (`class_id`),
  CONSTRAINT `checklist_class_checklist_id_foreign` FOREIGN KEY (`checklist_id`) REFERENCES `checklists` (`id`) ON DELETE CASCADE,
  CONSTRAINT `checklist_class_class_id_foreign` FOREIGN KEY (`class_id`) REFERENCES `classes` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `checklist_class`
--

LOCK TABLES `checklist_class` WRITE;
/*!40000 ALTER TABLE `checklist_class` DISABLE KEYS */;
INSERT INTO `checklist_class` VALUES (1,7),(1,9),(1,10),(1,11),(1,12);
/*!40000 ALTER TABLE `checklist_class` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `checklist_fault`
--

DROP TABLE IF EXISTS `checklist_fault`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `checklist_fault` (
  `checklist_id` bigint(20) unsigned NOT NULL,
  `fault_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`checklist_id`,`fault_id`),
  KEY `checklist_fault_fault_id_foreign` (`fault_id`),
  CONSTRAINT `checklist_fault_checklist_id_foreign` FOREIGN KEY (`checklist_id`) REFERENCES `checklists` (`id`) ON DELETE CASCADE,
  CONSTRAINT `checklist_fault_fault_id_foreign` FOREIGN KEY (`fault_id`) REFERENCES `faults` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `checklist_fault`
--

LOCK TABLES `checklist_fault` WRITE;
/*!40000 ALTER TABLE `checklist_fault` DISABLE KEYS */;
/*!40000 ALTER TABLE `checklist_fault` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `checklists`
--

DROP TABLE IF EXISTS `checklists`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `checklists` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `message` longtext DEFAULT NULL,
  `date_resolved` date DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `resolved_by` varchar(255) DEFAULT NULL,
  `date_created` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `checklists_user_id_foreign` (`user_id`),
  CONSTRAINT `checklists_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `checklists`
--

LOCK TABLES `checklists` WRITE;
/*!40000 ALTER TABLE `checklists` DISABLE KEYS */;
INSERT INTO `checklists` VALUES (1,6,'The amplifier issues in MSB 5 was resolved this morning.','2023-09-06','Solved',NULL,'2023-09-06','2023-09-06 06:22:34','2023-09-06 06:22:34',NULL);
/*!40000 ALTER TABLE `checklists` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `classes`
--

DROP TABLE IF EXISTS `classes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `classes` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `building_id` bigint(20) unsigned NOT NULL DEFAULT 0,
  `class_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `classes_building_id_foreign` (`building_id`),
  CONSTRAINT `classes_building_id_foreign` FOREIGN KEY (`building_id`) REFERENCES `buildings` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=54 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `classes`
--

LOCK TABLES `classes` WRITE;
/*!40000 ALTER TABLE `classes` DISABLE KEYS */;
INSERT INTO `classes` VALUES (1,1,'MSB1','2023-04-24 23:32:07','2023-04-24 23:32:07',NULL),(2,2,'Sample Class','2023-04-25 08:45:18','2023-04-25 08:45:18',NULL),(3,1,'MSB 1','2023-05-15 05:50:56','2023-05-15 05:51:28','2023-05-15 05:51:28'),(4,1,'MSB 2','2023-05-15 05:51:05','2023-05-15 05:51:05',NULL),(5,1,'MSB 3','2023-05-17 07:43:58','2023-05-17 07:43:58',NULL),(6,1,'MSB 4','2023-05-17 07:44:10','2023-05-17 07:44:10',NULL),(7,1,'MSB 5','2023-05-17 07:44:18','2023-05-17 07:44:18',NULL),(8,1,'MSB 6','2023-05-17 07:44:36','2023-05-17 07:44:36',NULL),(9,1,'MSB 7','2023-05-17 07:44:49','2023-05-17 07:44:49',NULL),(10,1,'MSB 8','2023-05-17 07:44:57','2023-05-17 07:44:57',NULL),(11,1,'MSB 9','2023-05-17 07:45:06','2023-05-17 07:45:06',NULL),(12,1,'MSB 10','2023-05-17 07:45:22','2023-05-17 07:45:22',NULL),(13,1,'MSB 11','2023-05-17 07:45:29','2023-05-17 07:45:44',NULL),(14,1,'MSB 12','2023-05-17 07:46:06','2023-05-17 07:46:06',NULL),(15,1,'MSB 13','2023-05-17 07:46:12','2023-05-17 07:46:12',NULL),(16,1,'MSB 14','2023-05-17 07:46:19','2023-05-17 07:46:19',NULL),(17,5,'SHABA','2023-05-17 07:47:48','2023-05-17 07:47:48',NULL),(18,5,'Zumaridi','2023-05-17 07:47:56','2023-05-17 07:47:56',NULL),(19,4,'LT 1','2023-05-17 07:48:17','2023-05-17 07:49:12',NULL),(20,4,'LT 2','2023-05-17 07:48:28','2023-05-17 07:49:25',NULL),(21,4,'LT 3','2023-05-17 07:48:36','2023-05-17 07:49:34',NULL),(22,4,'LT 4','2023-05-17 07:48:42','2023-05-17 07:49:45',NULL),(23,4,'LT 5','2023-05-17 07:48:49','2023-05-17 07:49:53',NULL),(24,4,'LT 6','2023-05-17 07:49:00','2023-05-17 07:50:01',NULL),(25,4,'ROOM B','2023-05-17 07:50:26','2023-05-17 07:50:26',NULL),(26,4,'ROOM 2','2023-05-17 07:50:34','2023-05-17 07:50:34',NULL),(27,4,'ROOM 3','2023-05-17 07:50:53','2023-05-17 07:50:53',NULL),(28,4,'ROOM 4','2023-05-17 07:52:08','2023-05-17 07:52:08',NULL),(29,4,'ROOM 10','2023-05-17 07:52:18','2023-05-17 07:52:18',NULL),(30,4,'ROOM 11','2023-05-17 07:52:25','2023-05-17 07:52:25',NULL),(31,4,'ROOM 12','2023-05-17 07:52:37','2023-05-17 07:52:37',NULL),(32,4,'ROOM 23','2023-05-17 07:52:48','2023-05-17 07:52:48',NULL),(33,4,'ROOM 25','2023-05-17 07:52:58','2023-05-17 07:52:58',NULL),(34,4,'ROOM 26','2023-05-17 07:53:06','2023-05-17 07:53:06',NULL),(35,3,'B-01','2023-05-17 07:53:49','2023-05-17 07:53:49',NULL),(36,3,'B-02','2023-05-17 07:53:56','2023-05-17 07:53:56',NULL),(37,3,'B-03','2023-05-17 07:54:07','2023-05-17 07:54:07',NULL),(38,3,'B-04','2023-05-17 07:54:15','2023-05-17 07:54:15',NULL),(39,3,'GF-01','2023-05-17 07:54:22','2023-05-17 07:54:22',NULL),(40,3,'GF-02','2023-05-17 07:54:27','2023-05-17 07:54:27',NULL),(41,3,'F1-02','2023-05-17 07:54:36','2023-05-17 07:54:36',NULL),(42,3,'F1-03','2023-05-17 07:54:43','2023-05-17 07:54:43',NULL),(43,3,'F1-04','2023-05-17 07:54:49','2023-05-17 07:54:49',NULL),(44,3,'F1-05','2023-05-17 07:54:59','2023-05-17 07:54:59',NULL),(45,3,'F2-01','2023-05-17 07:55:12','2023-05-17 07:55:12',NULL),(46,3,'F2-02','2023-05-17 07:55:22','2023-05-17 07:55:22',NULL),(47,3,'F2-03','2023-05-17 07:55:33','2023-05-17 07:55:33',NULL),(48,3,'F2-04','2023-05-17 07:55:49','2023-05-17 07:55:49',NULL),(49,3,'F2-05','2023-05-17 07:56:03','2023-05-17 07:56:03',NULL),(50,6,'SBS 1','2023-05-17 07:56:49','2023-05-17 07:56:49',NULL),(51,6,'SBS 2','2023-05-17 07:56:54','2023-05-17 07:56:54',NULL),(52,4,'ROOM 21','2023-07-03 04:10:21','2023-07-03 04:10:21',NULL),(53,4,'ROOM 24','2023-07-03 04:11:01','2023-07-03 04:11:01',NULL);
/*!40000 ALTER TABLE `classes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `faults`
--

DROP TABLE IF EXISTS `faults`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `faults` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL DEFAULT 0,
  `faults_identified` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `faults_user_id_foreign` (`user_id`),
  CONSTRAINT `faults_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `faults`
--

LOCK TABLES `faults` WRITE;
/*!40000 ALTER TABLE `faults` DISABLE KEYS */;
INSERT INTO `faults` VALUES (1,6,'Missing Battery','2023-04-25 02:33:13','2023-04-25 02:33:13',NULL),(2,6,'Power cable','2023-04-25 02:33:25','2023-04-25 02:33:25',NULL),(3,7,'Faulty Mouse','2023-04-25 11:45:47','2023-04-25 11:45:47',NULL),(4,7,'Faulty Ports','2023-04-25 11:46:38','2023-04-25 11:46:38',NULL),(5,7,'Faulty Cables','2023-04-28 05:49:42','2023-04-28 05:49:42',NULL),(6,4,'Sound(Amp & Speakers)','2023-05-17 10:57:17','2023-05-17 10:57:17',NULL),(7,4,'Alignment & Clarity','2023-05-17 10:57:20','2023-05-17 10:57:20',NULL),(8,4,'Screen','2023-05-17 10:57:24','2023-05-17 10:57:24',NULL),(9,4,'Screen Controller','2023-05-17 10:57:28','2023-05-17 10:57:28',NULL),(10,4,'Browser Ops/ Remote','2023-05-17 10:57:35','2023-05-17 10:57:35',NULL),(11,4,'Network','2023-05-17 10:57:42','2023-05-17 10:57:42',NULL),(12,4,'Internet','2023-05-17 10:58:05','2023-05-17 10:58:05',NULL),(13,4,'Anti-virus','2023-05-17 10:58:14','2023-05-17 10:58:14',NULL),(14,4,'PC & Projector Cabinet Security','2023-05-17 10:58:22','2023-05-17 10:58:22',NULL),(15,4,'AV Guideline Sheet','2023-05-17 10:58:31','2023-05-17 10:58:31',NULL),(16,4,'Clock','2023-05-17 10:58:36','2023-05-17 10:58:36',NULL),(17,4,'Potrait','2023-05-17 10:58:41','2023-05-17 10:58:41',NULL),(18,4,'Light','2023-05-17 10:58:46','2023-05-17 10:58:46',NULL),(19,4,'Door','2023-05-17 10:58:52','2023-05-17 10:58:52',NULL),(20,4,'Wireless & APs','2023-05-17 11:02:16','2023-05-17 11:02:16',NULL),(21,6,'Faulty splitter','2023-05-18 02:46:00','2023-05-18 02:46:00',NULL),(22,9,'faulty keyboard','2023-05-30 02:16:52','2023-05-30 02:16:52',NULL),(23,6,'Windows Activation','2023-07-18 05:37:41','2023-07-18 05:37:41',NULL);
/*!40000 ALTER TABLE `faults` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `login_logs`
--

DROP TABLE IF EXISTS `login_logs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `login_logs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `login_time` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `login_logs_user_id_foreign` (`user_id`),
  CONSTRAINT `login_logs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=144 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `login_logs`
--

LOCK TABLES `login_logs` WRITE;
/*!40000 ALTER TABLE `login_logs` DISABLE KEYS */;
INSERT INTO `login_logs` VALUES (1,4,'2023-04-24 12:36:05','2023-04-24 09:36:05','2023-04-24 09:36:05'),(2,5,'2023-04-24 12:51:24','2023-04-24 09:51:24','2023-04-24 09:51:24'),(3,4,'2023-04-24 12:51:54','2023-04-24 09:51:54','2023-04-24 09:51:54'),(4,4,'2023-04-24 12:53:19','2023-04-24 09:53:19','2023-04-24 09:53:19'),(5,5,'2023-04-24 12:56:08','2023-04-24 09:56:08','2023-04-24 09:56:08'),(6,4,'2023-04-24 13:16:13','2023-04-24 10:16:13','2023-04-24 10:16:13'),(7,4,'2023-04-24 14:59:00','2023-04-24 11:59:00','2023-04-24 11:59:00'),(8,6,'2023-04-25 05:28:37','2023-04-25 02:28:37','2023-04-25 02:28:37'),(9,4,'2023-04-25 05:30:10','2023-04-25 02:30:10','2023-04-25 02:30:10'),(10,6,'2023-04-25 05:31:05','2023-04-25 02:31:05','2023-04-25 02:31:05'),(11,6,'2023-04-25 05:41:17','2023-04-25 02:41:17','2023-04-25 02:41:17'),(12,4,'2023-04-25 05:57:45','2023-04-25 02:57:45','2023-04-25 02:57:45'),(13,7,'2023-04-25 11:46:53','2023-04-25 08:46:53','2023-04-25 08:46:53'),(14,4,'2023-04-25 14:01:13','2023-04-25 11:01:13','2023-04-25 11:01:13'),(15,7,'2023-04-25 14:44:15','2023-04-25 11:44:15','2023-04-25 11:44:15'),(16,4,'2023-04-26 09:09:32','2023-04-26 06:09:32','2023-04-26 06:09:32'),(17,4,'2023-04-27 11:33:19','2023-04-27 08:33:19','2023-04-27 08:33:19'),(18,4,'2023-04-27 14:27:33','2023-04-27 11:27:33','2023-04-27 11:27:33'),(19,4,'2023-04-28 07:20:22','2023-04-28 04:20:22','2023-04-28 04:20:22'),(20,7,'2023-04-28 08:48:43','2023-04-28 05:48:43','2023-04-28 05:48:43'),(21,4,'2023-05-08 08:23:34','2023-05-08 05:23:34','2023-05-08 05:23:34'),(22,4,'2023-05-11 12:58:52','2023-05-11 09:58:52','2023-05-11 09:58:52'),(23,8,'2023-05-12 12:27:48','2023-05-12 09:27:48','2023-05-12 09:27:48'),(24,5,'2023-05-12 13:30:02','2023-05-12 10:30:02','2023-05-12 10:30:02'),(25,9,'2023-05-12 13:33:57','2023-05-12 10:33:57','2023-05-12 10:33:57'),(26,4,'2023-05-12 13:42:27','2023-05-12 10:42:27','2023-05-12 10:42:27'),(27,9,'2023-05-15 06:37:08','2023-05-15 03:37:08','2023-05-15 03:37:08'),(28,9,'2023-05-15 11:44:21','2023-05-15 08:44:21','2023-05-15 08:44:21'),(29,4,'2023-05-17 11:25:26','2023-05-17 08:25:26','2023-05-17 08:25:26'),(30,4,'2023-05-17 11:29:39','2023-05-17 08:29:39','2023-05-17 08:29:39'),(31,4,'2023-05-17 11:30:33','2023-05-17 08:30:33','2023-05-17 08:30:33'),(32,4,'2023-05-17 12:09:33','2023-05-17 09:09:33','2023-05-17 09:09:33'),(33,4,'2023-05-17 14:01:24','2023-05-17 11:01:24','2023-05-17 11:01:24'),(34,4,'2023-05-17 14:09:24','2023-05-17 11:09:24','2023-05-17 11:09:24'),(35,6,'2023-05-18 05:42:38','2023-05-18 02:42:38','2023-05-18 02:42:38'),(36,4,'2023-05-18 07:07:04','2023-05-18 04:07:04','2023-05-18 04:07:04'),(37,10,'2023-05-19 07:38:48','2023-05-19 04:38:48','2023-05-19 04:38:48'),(38,4,'2023-05-19 07:39:17','2023-05-19 04:39:17','2023-05-19 04:39:17'),(39,10,'2023-05-23 13:12:56','2023-05-23 10:12:56','2023-05-23 10:12:56'),(40,4,'2023-05-24 07:29:51','2023-05-24 04:29:51','2023-05-24 04:29:51'),(41,9,'2023-05-24 09:55:15','2023-05-24 06:55:15','2023-05-24 06:55:15'),(42,4,'2023-05-24 12:56:53','2023-05-24 09:56:53','2023-05-24 09:56:53'),(43,6,'2023-05-25 06:19:52','2023-05-25 03:19:52','2023-05-25 03:19:52'),(44,9,'2023-05-25 06:25:41','2023-05-25 03:25:41','2023-05-25 03:25:41'),(45,6,'2023-05-25 13:55:00','2023-05-25 10:55:00','2023-05-25 10:55:00'),(46,9,'2023-05-26 05:45:48','2023-05-26 02:45:48','2023-05-26 02:45:48'),(47,6,'2023-05-26 09:04:41','2023-05-26 06:04:41','2023-05-26 06:04:41'),(48,6,'2023-05-26 09:05:39','2023-05-26 06:05:39','2023-05-26 06:05:39'),(49,4,'2023-05-26 09:19:02','2023-05-26 06:19:02','2023-05-26 06:19:02'),(50,4,'2023-05-26 09:41:23','2023-05-26 06:41:23','2023-05-26 06:41:23'),(51,11,'2023-05-26 09:43:55','2023-05-26 06:43:55','2023-05-26 06:43:55'),(52,9,'2023-05-26 11:16:47','2023-05-26 08:16:47','2023-05-26 08:16:47'),(53,11,'2023-05-26 12:55:41','2023-05-26 09:55:41','2023-05-26 09:55:41'),(54,12,'2023-05-29 04:57:25','2023-05-29 01:57:25','2023-05-29 01:57:25'),(55,4,'2023-05-29 05:22:06','2023-05-29 02:22:06','2023-05-29 02:22:06'),(56,4,'2023-05-29 10:06:36','2023-05-29 07:06:36','2023-05-29 07:06:36'),(57,6,'2023-05-30 04:50:00','2023-05-30 01:50:00','2023-05-30 01:50:00'),(58,9,'2023-05-30 04:51:17','2023-05-30 01:51:17','2023-05-30 01:51:17'),(59,12,'2023-05-30 05:00:17','2023-05-30 02:00:17','2023-05-30 02:00:17'),(60,8,'2023-05-30 05:15:17','2023-05-30 02:15:17','2023-05-30 02:15:17'),(61,4,'2023-05-30 06:45:27','2023-05-30 03:45:27','2023-05-30 03:45:27'),(62,12,'2023-05-30 10:39:38','2023-05-30 07:39:38','2023-05-30 07:39:38'),(63,12,'2023-05-30 14:19:07','2023-05-30 14:19:07','2023-05-30 14:19:07'),(64,9,'2023-05-31 04:26:32','2023-05-31 04:26:32','2023-05-31 04:26:32'),(65,9,'2023-05-31 06:54:56','2023-05-31 06:54:56','2023-05-31 06:54:56'),(66,12,'2023-05-31 07:24:10','2023-05-31 07:24:10','2023-05-31 07:24:10'),(67,9,'2023-06-02 06:44:38','2023-06-02 06:44:38','2023-06-02 06:44:38'),(68,12,'2023-06-02 08:35:28','2023-06-02 08:35:28','2023-06-02 08:35:28'),(69,12,'2023-06-05 08:24:05','2023-06-05 08:24:05','2023-06-05 08:24:05'),(70,12,'2023-06-06 05:12:58','2023-06-06 05:12:58','2023-06-06 05:12:58'),(71,6,'2023-06-06 05:24:26','2023-06-06 05:24:26','2023-06-06 05:24:26'),(72,9,'2023-06-07 04:47:47','2023-06-07 04:47:47','2023-06-07 04:47:47'),(73,7,'2023-06-12 13:48:20','2023-06-12 13:48:20','2023-06-12 13:48:20'),(74,9,'2023-06-14 04:22:42','2023-06-14 04:22:42','2023-06-14 04:22:42'),(75,9,'2023-06-14 04:24:00','2023-06-14 04:24:00','2023-06-14 04:24:00'),(76,12,'2023-06-14 10:04:06','2023-06-14 10:04:06','2023-06-14 10:04:06'),(77,4,'2023-06-14 10:24:00','2023-06-14 10:24:00','2023-06-14 10:24:00'),(78,12,'2023-06-19 07:21:38','2023-06-19 07:21:38','2023-06-19 07:21:38'),(79,12,'2023-06-20 05:58:04','2023-06-20 05:58:04','2023-06-20 05:58:04'),(80,9,'2023-06-20 06:03:05','2023-06-20 06:03:05','2023-06-20 06:03:05'),(81,12,'2023-06-20 11:56:37','2023-06-20 11:56:37','2023-06-20 11:56:37'),(82,6,'2023-06-21 07:28:00','2023-06-21 07:28:00','2023-06-21 07:28:00'),(83,6,'2023-06-22 06:31:20','2023-06-22 06:31:20','2023-06-22 06:31:20'),(84,11,'2023-06-22 11:36:25','2023-06-22 11:36:25','2023-06-22 11:36:25'),(85,6,'2023-07-03 07:09:22','2023-07-03 07:09:22','2023-07-03 07:09:22'),(86,9,'2023-07-04 04:41:45','2023-07-04 04:41:45','2023-07-04 04:41:45'),(87,6,'2023-07-04 06:30:17','2023-07-04 06:30:17','2023-07-04 06:30:17'),(88,6,'2023-07-04 13:33:11','2023-07-04 13:33:11','2023-07-04 13:33:11'),(89,6,'2023-07-06 07:47:49','2023-07-06 07:47:49','2023-07-06 07:47:49'),(90,4,'2023-07-11 06:54:57','2023-07-11 06:54:57','2023-07-11 06:54:57'),(91,11,'2023-07-11 09:40:46','2023-07-11 09:40:46','2023-07-11 09:40:46'),(92,12,'2023-07-13 04:08:56','2023-07-13 04:08:56','2023-07-13 04:08:56'),(93,12,'2023-07-14 07:22:08','2023-07-14 07:22:08','2023-07-14 07:22:08'),(94,12,'2023-07-17 05:46:16','2023-07-17 05:46:16','2023-07-17 05:46:16'),(95,6,'2023-07-17 06:03:22','2023-07-17 06:03:22','2023-07-17 06:03:22'),(96,6,'2023-07-18 05:16:14','2023-07-18 05:16:14','2023-07-18 05:16:14'),(97,6,'2023-07-24 05:35:10','2023-07-24 05:35:10','2023-07-24 05:35:10'),(98,11,'2023-07-25 06:24:48','2023-07-25 06:24:48','2023-07-25 06:24:48'),(99,12,'2023-07-25 06:26:53','2023-07-25 06:26:53','2023-07-25 06:26:53'),(100,8,'2023-07-25 06:46:44','2023-07-25 06:46:44','2023-07-25 06:46:44'),(101,11,'2023-07-26 06:35:43','2023-07-26 06:35:43','2023-07-26 06:35:43'),(102,4,'2023-07-26 13:20:57','2023-07-26 13:20:57','2023-07-26 13:20:57'),(103,4,'2023-07-26 13:43:12','2023-07-26 13:43:12','2023-07-26 13:43:12'),(104,7,'2023-07-26 13:44:24','2023-07-26 13:44:24','2023-07-26 13:44:24'),(105,4,'2023-08-07 06:08:53','2023-08-07 06:08:53','2023-08-07 06:08:53'),(106,13,'2023-08-07 10:50:48','2023-08-07 10:50:48','2023-08-07 10:50:48'),(107,4,'2023-08-07 11:01:36','2023-08-07 11:01:36','2023-08-07 11:01:36'),(108,4,'2023-08-24 08:14:58','2023-08-24 08:14:58','2023-08-24 08:14:58'),(109,4,'2023-08-24 08:22:59','2023-08-24 08:22:59','2023-08-24 08:22:59'),(110,4,'2023-08-24 08:39:20','2023-08-24 08:39:20','2023-08-24 08:39:20'),(111,4,'2023-08-24 08:41:47','2023-08-24 08:41:47','2023-08-24 08:41:47'),(112,4,'2023-08-24 08:43:35','2023-08-24 08:43:35','2023-08-24 08:43:35'),(113,4,'2023-08-24 08:44:05','2023-08-24 08:44:05','2023-08-24 08:44:05'),(114,4,'2023-08-24 08:46:44','2023-08-24 08:46:44','2023-08-24 08:46:44'),(115,4,'2023-08-24 09:01:14','2023-08-24 09:01:14','2023-08-24 09:01:14'),(116,4,'2023-08-24 09:02:29','2023-08-24 09:02:29','2023-08-24 09:02:29'),(117,4,'2023-08-24 09:03:50','2023-08-24 09:03:50','2023-08-24 09:03:50'),(118,4,'2023-08-24 09:21:33','2023-08-24 09:21:33','2023-08-24 09:21:33'),(119,14,'2023-08-24 09:27:03','2023-08-24 09:27:03','2023-08-24 09:27:03'),(120,14,'2023-08-24 09:31:00','2023-08-24 09:31:00','2023-08-24 09:31:00'),(121,14,'2023-08-24 09:31:41','2023-08-24 09:31:41','2023-08-24 09:31:41'),(122,4,'2023-08-24 12:26:52','2023-08-24 12:26:52','2023-08-24 12:26:52'),(123,4,'2023-08-24 13:00:15','2023-08-24 13:00:15','2023-08-24 13:00:15'),(124,4,'2023-08-24 13:07:47','2023-08-24 13:07:47','2023-08-24 13:07:47'),(125,4,'2023-08-24 13:21:04','2023-08-24 13:21:04','2023-08-24 13:21:04'),(126,4,'2023-08-24 13:37:23','2023-08-24 13:37:23','2023-08-24 13:37:23'),(127,4,'2023-08-24 13:45:57','2023-08-24 13:45:57','2023-08-24 13:45:57'),(128,4,'2023-08-24 13:46:27','2023-08-24 13:46:27','2023-08-24 13:46:27'),(129,4,'2023-08-24 14:03:36','2023-08-24 14:03:36','2023-08-24 14:03:36'),(130,4,'2023-08-25 07:20:32','2023-08-25 07:20:32','2023-08-25 07:20:32'),(131,4,'2023-08-25 07:38:02','2023-08-25 07:38:02','2023-08-25 07:38:02'),(132,4,'2023-08-28 05:45:03','2023-08-28 05:45:03','2023-08-28 05:45:03'),(133,4,'2023-08-30 08:11:35','2023-08-30 08:11:35','2023-08-30 08:11:35'),(134,15,'2023-08-31 10:10:47','2023-08-31 10:10:47','2023-08-31 10:10:47'),(135,4,'2023-09-01 06:42:13','2023-09-01 06:42:13','2023-09-01 06:42:13'),(136,4,'2023-09-01 07:48:51','2023-09-01 07:48:51','2023-09-01 07:48:51'),(137,4,'2023-09-01 10:03:56','2023-09-01 10:03:56','2023-09-01 10:03:56'),(138,6,'2023-09-04 06:18:07','2023-09-04 06:18:07','2023-09-04 06:18:07'),(139,4,'2023-09-04 06:19:22','2023-09-04 06:19:22','2023-09-04 06:19:22'),(140,4,'2023-09-04 10:04:35','2023-09-04 10:04:35','2023-09-04 10:04:35'),(141,4,'2023-09-04 10:31:49','2023-09-04 10:31:49','2023-09-04 10:31:49'),(142,4,'2023-09-05 09:16:13','2023-09-05 09:16:13','2023-09-05 09:16:13'),(143,6,'2023-09-06 06:20:14','2023-09-06 06:20:14','2023-09-06 06:20:14');
/*!40000 ALTER TABLE `login_logs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'2014_10_12_000000_create_users_table',1),(2,'2014_10_12_100000_create_password_reset_tokens_table',1),(3,'2019_08_19_000000_create_failed_jobs_table',1),(4,'2019_12_14_000001_create_personal_access_tokens_table',1),(5,'2023_03_20_065447_add_role_id_to_users_table',1),(6,'2023_03_21_095052_add_soft_deletes_to_users_table',1),(8,'2023_03_24_084715_add_status_to_checklists_table',1),(9,'2023_03_24_084918_add_phone_no_to_users_table',1),(12,'2023_04_03_081411_create_faults_table',1),(13,'2023_04_04_065512_remove_role_id_from_posts_table',1),(14,'2023_04_05_123813_add_soft_deletes_to_buildings_table',1),(15,'2023_04_05_123840_add_soft_deletes_to_faults_table',1),(16,'2023_04_06_075544_add_two_factor_columns_to_table',1),(17,'2023_04_12_145738_add_columns_to_users_table',1),(20,'2023_04_13_113346_add_soft_deletes_to_classes_table',1),(21,'2023_04_13_140423_create_login_logs_table',1),(24,'2023_04_20_124550_drop_phone_no_from_users_table',3),(26,'2023_03_24_083233_create_checklists_table',5),(27,'2023_03_29_060258_add_soft_deletes_to_checklists_table',6),(29,'2023_08_15_223359_create_checklist_fault_table',8),(33,'2023_04_13_110407_create_permission_tables',10),(34,'2023_08_16_120238_create_checklist_class_table',11),(35,'2023_04_13_113059_create_classes_table',12),(36,'2023_03_31_085905_create_buildings_table',13),(37,'2023_08_15_223240_create_checklists_table',14);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `model_has_permissions`
--

DROP TABLE IF EXISTS `model_has_permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) unsigned NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `model_has_permissions`
--

LOCK TABLES `model_has_permissions` WRITE;
/*!40000 ALTER TABLE `model_has_permissions` DISABLE KEYS */;
/*!40000 ALTER TABLE `model_has_permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `model_has_roles`
--

DROP TABLE IF EXISTS `model_has_roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) unsigned NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `model_has_roles`
--

LOCK TABLES `model_has_roles` WRITE;
/*!40000 ALTER TABLE `model_has_roles` DISABLE KEYS */;
INSERT INTO `model_has_roles` VALUES (1,'App\\Models\\User',4),(2,'App\\Models\\User',4),(2,'App\\Models\\User',6),(3,'App\\Models\\User',14),(3,'App\\Models\\User',15);
/*!40000 ALTER TABLE `model_has_roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_reset_tokens`
--

LOCK TABLES `password_reset_tokens` WRITE;
/*!40000 ALTER TABLE `password_reset_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_reset_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `permissions`
--

DROP TABLE IF EXISTS `permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `permissions` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB AUTO_INCREMENT=84 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `permissions`
--

LOCK TABLES `permissions` WRITE;
/*!40000 ALTER TABLE `permissions` DISABLE KEYS */;
INSERT INTO `permissions` VALUES (1,'view_buildings','web','2023-08-24 08:01:14','2023-08-24 08:01:14'),(2,'view_any_buildings','web','2023-08-24 08:01:14','2023-08-24 08:01:14'),(3,'create_buildings','web','2023-08-24 08:01:14','2023-08-24 08:01:14'),(4,'update_buildings','web','2023-08-24 08:01:14','2023-08-24 08:01:14'),(5,'restore_buildings','web','2023-08-24 08:01:14','2023-08-24 08:01:14'),(6,'restore_any_buildings','web','2023-08-24 08:01:14','2023-08-24 08:01:14'),(7,'replicate_buildings','web','2023-08-24 08:01:15','2023-08-24 08:01:15'),(8,'reorder_buildings','web','2023-08-24 08:01:15','2023-08-24 08:01:15'),(9,'delete_buildings','web','2023-08-24 08:01:15','2023-08-24 08:01:15'),(10,'delete_any_buildings','web','2023-08-24 08:01:15','2023-08-24 08:01:15'),(11,'force_delete_buildings','web','2023-08-24 08:01:15','2023-08-24 08:01:15'),(12,'force_delete_any_buildings','web','2023-08-24 08:01:15','2023-08-24 08:01:15'),(13,'view_checklist','web','2023-08-24 08:01:15','2023-08-24 08:01:15'),(14,'view_any_checklist','web','2023-08-24 08:01:15','2023-08-24 08:01:15'),(15,'create_checklist','web','2023-08-24 08:01:15','2023-08-24 08:01:15'),(16,'update_checklist','web','2023-08-24 08:01:15','2023-08-24 08:01:15'),(17,'restore_checklist','web','2023-08-24 08:01:15','2023-08-24 08:01:15'),(18,'restore_any_checklist','web','2023-08-24 08:01:15','2023-08-24 08:01:15'),(19,'replicate_checklist','web','2023-08-24 08:01:15','2023-08-24 08:01:15'),(20,'reorder_checklist','web','2023-08-24 08:01:15','2023-08-24 08:01:15'),(21,'delete_checklist','web','2023-08-24 08:01:15','2023-08-24 08:01:15'),(22,'delete_any_checklist','web','2023-08-24 08:01:15','2023-08-24 08:01:15'),(23,'force_delete_checklist','web','2023-08-24 08:01:15','2023-08-24 08:01:15'),(24,'force_delete_any_checklist','web','2023-08-24 08:01:15','2023-08-24 08:01:15'),(25,'view_classes','web','2023-08-24 08:01:16','2023-08-24 08:01:16'),(26,'view_any_classes','web','2023-08-24 08:01:16','2023-08-24 08:01:16'),(27,'create_classes','web','2023-08-24 08:01:16','2023-08-24 08:01:16'),(28,'update_classes','web','2023-08-24 08:01:16','2023-08-24 08:01:16'),(29,'restore_classes','web','2023-08-24 08:01:16','2023-08-24 08:01:16'),(30,'restore_any_classes','web','2023-08-24 08:01:16','2023-08-24 08:01:16'),(31,'replicate_classes','web','2023-08-24 08:01:16','2023-08-24 08:01:16'),(32,'reorder_classes','web','2023-08-24 08:01:16','2023-08-24 08:01:16'),(33,'delete_classes','web','2023-08-24 08:01:16','2023-08-24 08:01:16'),(34,'delete_any_classes','web','2023-08-24 08:01:16','2023-08-24 08:01:16'),(35,'force_delete_classes','web','2023-08-24 08:01:16','2023-08-24 08:01:16'),(36,'force_delete_any_classes','web','2023-08-24 08:01:16','2023-08-24 08:01:16'),(37,'view_faults','web','2023-08-24 08:01:16','2023-08-24 08:01:16'),(38,'view_any_faults','web','2023-08-24 08:01:16','2023-08-24 08:01:16'),(39,'create_faults','web','2023-08-24 08:01:16','2023-08-24 08:01:16'),(40,'update_faults','web','2023-08-24 08:01:16','2023-08-24 08:01:16'),(41,'restore_faults','web','2023-08-24 08:01:16','2023-08-24 08:01:16'),(42,'restore_any_faults','web','2023-08-24 08:01:16','2023-08-24 08:01:16'),(43,'replicate_faults','web','2023-08-24 08:01:16','2023-08-24 08:01:16'),(44,'reorder_faults','web','2023-08-24 08:01:16','2023-08-24 08:01:16'),(45,'delete_faults','web','2023-08-24 08:01:16','2023-08-24 08:01:16'),(46,'delete_any_faults','web','2023-08-24 08:01:16','2023-08-24 08:01:16'),(47,'force_delete_faults','web','2023-08-24 08:01:16','2023-08-24 08:01:16'),(48,'force_delete_any_faults','web','2023-08-24 08:01:16','2023-08-24 08:01:16'),(49,'view_role','web','2023-08-24 08:01:17','2023-08-24 08:01:17'),(50,'view_any_role','web','2023-08-24 08:01:17','2023-08-24 08:01:17'),(51,'create_role','web','2023-08-24 08:01:17','2023-08-24 08:01:17'),(52,'update_role','web','2023-08-24 08:01:17','2023-08-24 08:01:17'),(53,'delete_role','web','2023-08-24 08:01:17','2023-08-24 08:01:17'),(54,'delete_any_role','web','2023-08-24 08:01:17','2023-08-24 08:01:17'),(55,'view_user','web','2023-08-24 08:01:17','2023-08-24 08:01:17'),(56,'view_any_user','web','2023-08-24 08:01:17','2023-08-24 08:01:17'),(57,'create_user','web','2023-08-24 08:01:17','2023-08-24 08:01:17'),(58,'update_user','web','2023-08-24 08:01:17','2023-08-24 08:01:17'),(59,'restore_user','web','2023-08-24 08:01:17','2023-08-24 08:01:17'),(60,'restore_any_user','web','2023-08-24 08:01:17','2023-08-24 08:01:17'),(61,'replicate_user','web','2023-08-24 08:01:17','2023-08-24 08:01:17'),(62,'reorder_user','web','2023-08-24 08:01:17','2023-08-24 08:01:17'),(63,'delete_user','web','2023-08-24 08:01:17','2023-08-24 08:01:17'),(64,'delete_any_user','web','2023-08-24 08:01:17','2023-08-24 08:01:17'),(65,'force_delete_user','web','2023-08-24 08:01:17','2023-08-24 08:01:17'),(66,'force_delete_any_user','web','2023-08-24 08:01:17','2023-08-24 08:01:17'),(67,'page_MyProfile','web','2023-08-24 08:01:18','2023-08-24 08:01:18'),(68,'page_Reports','web','2023-08-24 08:01:18','2023-08-24 08:01:18'),(69,'widget_StatsOverview','web','2023-08-24 08:01:18','2023-08-24 08:01:18'),(70,'widget_CheckListChart','web','2023-08-24 08:01:18','2023-08-24 08:01:18'),(71,'widget_MyChecklist','web','2023-08-24 08:01:18','2023-08-24 08:01:18'),(72,'view_checklist::no::faults','web','2023-09-04 06:19:46','2023-09-04 06:19:46'),(73,'view_any_checklist::no::faults','web','2023-09-04 06:19:46','2023-09-04 06:19:46'),(74,'create_checklist::no::faults','web','2023-09-04 06:19:46','2023-09-04 06:19:46'),(75,'update_checklist::no::faults','web','2023-09-04 06:19:46','2023-09-04 06:19:46'),(76,'restore_checklist::no::faults','web','2023-09-04 06:19:46','2023-09-04 06:19:46'),(77,'restore_any_checklist::no::faults','web','2023-09-04 06:19:46','2023-09-04 06:19:46'),(78,'replicate_checklist::no::faults','web','2023-09-04 06:19:46','2023-09-04 06:19:46'),(79,'reorder_checklist::no::faults','web','2023-09-04 06:19:46','2023-09-04 06:19:46'),(80,'delete_checklist::no::faults','web','2023-09-04 06:19:46','2023-09-04 06:19:46'),(81,'delete_any_checklist::no::faults','web','2023-09-04 06:19:46','2023-09-04 06:19:46'),(82,'force_delete_checklist::no::faults','web','2023-09-04 06:19:46','2023-09-04 06:19:46'),(83,'force_delete_any_checklist::no::faults','web','2023-09-04 06:19:46','2023-09-04 06:19:46');
/*!40000 ALTER TABLE `permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `personal_access_tokens`
--

DROP TABLE IF EXISTS `personal_access_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `personal_access_tokens`
--

LOCK TABLES `personal_access_tokens` WRITE;
/*!40000 ALTER TABLE `personal_access_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `personal_access_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `role_has_permissions`
--

DROP TABLE IF EXISTS `role_has_permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) unsigned NOT NULL,
  `role_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`role_id`),
  KEY `role_has_permissions_role_id_foreign` (`role_id`),
  CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `role_has_permissions`
--

LOCK TABLES `role_has_permissions` WRITE;
/*!40000 ALTER TABLE `role_has_permissions` DISABLE KEYS */;
INSERT INTO `role_has_permissions` VALUES (1,1),(1,2),(1,3),(2,1),(2,2),(2,3),(3,1),(3,2),(4,1),(4,2),(5,1),(5,2),(6,1),(6,2),(7,1),(7,2),(8,1),(8,2),(9,1),(9,2),(10,1),(10,2),(11,1),(11,2),(12,1),(12,2),(13,1),(13,2),(13,3),(14,1),(14,2),(14,3),(15,1),(15,2),(16,1),(16,2),(17,1),(17,2),(18,1),(18,2),(19,1),(19,2),(20,1),(20,2),(21,1),(21,2),(22,1),(22,2),(23,1),(23,2),(24,1),(24,2),(25,1),(25,2),(25,3),(26,1),(26,2),(26,3),(27,1),(27,2),(28,1),(28,2),(29,1),(29,2),(30,1),(30,2),(31,1),(31,2),(32,1),(32,2),(33,1),(33,2),(34,1),(34,2),(35,1),(35,2),(36,1),(36,2),(37,1),(37,2),(37,3),(38,1),(38,2),(38,3),(39,1),(39,2),(40,1),(40,2),(41,1),(41,2),(42,1),(42,2),(43,1),(43,2),(44,1),(44,2),(45,1),(45,2),(46,1),(46,2),(47,1),(47,2),(48,1),(48,2),(49,1),(49,2),(50,1),(50,2),(51,1),(51,2),(52,1),(52,2),(53,1),(53,2),(54,1),(54,2),(55,1),(55,2),(55,3),(56,1),(56,2),(56,3),(57,1),(57,2),(58,1),(58,2),(59,1),(59,2),(60,1),(60,2),(61,1),(61,2),(62,1),(62,2),(63,1),(63,2),(64,1),(64,2),(65,1),(65,2),(66,1),(66,2),(67,1),(67,2),(67,3),(68,1),(68,2),(69,1),(69,2),(69,3),(70,1),(70,2),(70,3),(71,1),(71,2),(72,1),(72,2),(72,3),(73,1),(73,2),(73,3),(74,1),(74,2),(74,3),(75,1),(75,2),(75,3),(76,1),(76,2),(77,1),(77,2),(78,1),(78,2),(79,1),(79,2),(80,1),(80,2),(81,1),(81,2),(82,1),(82,2),(83,1),(83,2);
/*!40000 ALTER TABLE `role_has_permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `roles` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` VALUES (1,'super_admin','web','2023-08-24 08:01:15','2023-08-24 08:01:15'),(2,'Admin','web','2023-08-24 08:01:18','2023-08-24 09:28:56'),(3,'Manager','web','2023-08-24 09:30:09','2023-08-24 09:30:09');
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `objectguid` varchar(255) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `username` varchar(255) DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `two_factor_secret` text DEFAULT NULL,
  `two_factor_recovery_codes` text DEFAULT NULL,
  `two_factor_confirmed_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  UNIQUE KEY `users_username_unique` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (4,'112f32a3-ee2f-4a41-a4a2-d25c442a96b3','Gagandeep S Gahir','Gagandeep.Gahir@strathmore.edu','114736',NULL,'$2y$10$GZP9CnLJi.sWdaDNXhzY3udhS.CODdq53JYtuUD.P.ywDVKnsKdJS',NULL,NULL,NULL,'553lZsQH2Ky5h4FEMSDJEuQENw1lBfmtrOXiSvca17rL3lsqUr8aSZGLP5eM','2023-04-24 09:36:05','2023-04-24 09:36:05',NULL),(5,'6fb83d79-173b-4331-b5bd-8aec0f5cc2fe','Timothy G Muriuki','timothy.muriuki@strathmore.edu','134024',NULL,'$2y$10$SWXkg2OC2ySaUy.1uFPhP.yDkpdqlh5sZoH0IsWAxlY2WAtICOBuG',NULL,NULL,NULL,'6E0qaM49hHkO7Jng18UbFer1euyD5T82oAU9jZjeM9CRg6SsB5I2ZDO1I7lp','2023-04-24 09:51:24','2023-04-24 09:51:24',NULL),(6,'cf6486da-4e0b-4a30-a762-071ce4ec794b','Ntumwa S Bulonza','Bulonza.Ntumwa@strathmore.edu','113692',NULL,'$2y$10$fLXfR/VkZxG14iWOuj0LseipRAYVdNydBZjjq9wkNPFCy5YAfv6ge',NULL,NULL,NULL,NULL,'2023-04-25 02:28:37','2023-04-25 02:28:37',NULL),(7,'03519689-d180-4d88-a59c-fc62ba92b2df','Lawrence Kasera','LKasera@strathmore.edu','LKasera',NULL,'$2y$10$EwIR08airZ8fQ8StT6DVouqyZkyC4bRklI5Mm2KLGkMzIH1k5R8QW',NULL,NULL,NULL,NULL,'2023-04-25 08:46:53','2023-04-25 08:46:53',NULL),(8,'fc8aae54-6762-4426-958b-3ee802aa344f','Maria Awuor Kihara','Mkihara@strathmore.edu','mkihara',NULL,'$2y$10$KiI/.PIlN8pCWbbZg36eZerLMqOBd8tmkjP817WyKQZrbwcs9WLXS',NULL,NULL,NULL,NULL,'2023-05-12 09:27:48','2023-05-12 09:27:48',NULL),(9,'86594de5-8c8e-4eb3-b845-fe53240959c8','Latifa Sally','lsally@strathmore.edu','LSally',NULL,'$2y$10$UACx/9/agrs.l7U86ZVep.LQg1qzK1pB9qFFj8cR37STa0D0fgoJW',NULL,NULL,NULL,NULL,'2023-05-12 10:33:57','2023-05-12 10:33:57',NULL),(10,'b6512f0e-4b1c-4e6b-9b02-8df957045a5b','Caren Achieng','caren.achieng@strathmore.edu','acaren',NULL,'$2y$10$UiijtciSWQvdXeN2h4puf.EqwgFBSyVmLigZT4dJTx9xt//YI4b1a',NULL,NULL,NULL,NULL,'2023-05-19 04:38:48','2023-05-19 04:38:48',NULL),(11,'c05be6c4-fba4-46ac-b2b5-4e0ef03d1206','Benson Ogutu','BOgutu@strathmore.edu','bogutu',NULL,'$2y$10$R3Qbsxm1QYAlW18hptipguIMyMCeDacdggZJGsk1ZA4mDhHfxawi2',NULL,NULL,NULL,NULL,'2023-05-26 06:43:55','2023-05-26 06:43:55',NULL),(12,'5413c782-f31f-4627-bfd5-43bfe1735916','Sylvester Kioko','skioko@strathmore.edu','skioko',NULL,'$2y$10$Hu04nXCH.GAWmm.T37S0PehXBiSHIuPqfNSifOAGfPkSNFK.sPmwK',NULL,NULL,NULL,NULL,'2023-05-29 01:57:24','2023-05-29 01:57:24',NULL),(13,'6e95868c-da3e-4c80-89e3-b7fd46530fb6','Martin Ndeto','mndeto@strathmore.edu','mndeto',NULL,'$2y$10$RNJGgrq6kIe93Vz7oSZfoeOBN72wAOJv2o2N5z2Rgs/5E0AY88uyS',NULL,NULL,NULL,NULL,'2023-08-07 10:50:47','2023-08-07 10:50:47',NULL),(14,'3639abd4-f183-402b-9c4e-b743fa85dbc7','Michael Kiarie','MKiarie@strathmore.edu','MKiarie',NULL,'$2y$10$UHDJ8pqxknRGSajKJ8mYYeIfo44xWDNsQEcrisU5Sl3MdVgqic/um',NULL,NULL,NULL,NULL,'2023-08-24 09:27:03','2023-08-24 09:27:03',NULL),(15,'9fa50251-5001-4a8a-b23d-57b160ecea14','Samson Maosa','SMaosa@strathmore.edu','SMaosa',NULL,'$2y$10$yDUxZk2Z5EyR6tpCYl1NdekB.dTMsz3s2elWZH/xoF/mItBk3KM9K',NULL,NULL,NULL,NULL,'2023-08-31 10:10:47','2023-08-31 10:10:47',NULL);
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

-- Dump completed on 2023-09-06  9:35:23
