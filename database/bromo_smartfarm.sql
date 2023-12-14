-- MySQL dump 10.13  Distrib 8.0.33, for Win64 (x86_64)
--
-- Host: localhost    Database: bromo_smartfarm
-- ------------------------------------------------------
-- Server version	8.0.33

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
-- Table structure for table `amoniak_sensors`
--

DROP TABLE IF EXISTS `amoniak_sensors`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `amoniak_sensors` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_kandang` int NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `amoniak` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_amoniak_sensors_kandang` (`id_kandang`),
  CONSTRAINT `fk_amoniak_sensors_kandang` FOREIGN KEY (`id_kandang`) REFERENCES `kandang` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `amoniak_sensors`
--

LOCK TABLES `amoniak_sensors` WRITE;
/*!40000 ALTER TABLE `amoniak_sensors` DISABLE KEYS */;
/*!40000 ALTER TABLE `amoniak_sensors` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `data_kandang`
--

DROP TABLE IF EXISTS `data_kandang`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `data_kandang` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_kandang` int NOT NULL,
  `hari_ke` int NOT NULL,
  `pakan` int NOT NULL,
  `bobot` int NOT NULL,
  `minum` int NOT NULL,
  `riwayat_populasi` int DEFAULT NULL,
  `date` date NOT NULL,
  `classification` enum('normal','abnormal') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'normal',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `updated_by` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_data_kandang_kandang` (`id_kandang`),
  CONSTRAINT `fk_data_kandang_kandang` FOREIGN KEY (`id_kandang`) REFERENCES `kandang` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `data_kandang`
--

LOCK TABLES `data_kandang` WRITE;
/*!40000 ALTER TABLE `data_kandang` DISABLE KEYS */;
INSERT INTO `data_kandang` VALUES (1,1,1,50,20,30,20,'2023-12-12','normal','2023-12-12 12:47:16',NULL,NULL,NULL),(2,2,1,55,25,35,20,'2023-12-12','normal','2023-12-12 12:47:16',NULL,NULL,NULL),(3,1,2,20,40,30,20,'2023-12-12','normal','2023-12-12 05:47:46',3,'2023-12-12 06:00:57',3);
/*!40000 ALTER TABLE `data_kandang` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `data_kematian`
--

DROP TABLE IF EXISTS `data_kematian`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `data_kematian` (
  `id` int NOT NULL AUTO_INCREMENT,
  `kematian_terbaru` int DEFAULT NULL,
  `jumlah_kematian` int NOT NULL,
  `jam` time NOT NULL,
  `hari` date DEFAULT NULL,
  `id_data_kandang` int NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_by` int DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `updated_by` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_data_kematian_data_kandang` (`id_data_kandang`),
  CONSTRAINT `fk_data_kematian_data_kandang` FOREIGN KEY (`id_data_kandang`) REFERENCES `data_kandang` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `data_kematian`
--

LOCK TABLES `data_kematian` WRITE;
/*!40000 ALTER TABLE `data_kematian` DISABLE KEYS */;
/*!40000 ALTER TABLE `data_kematian` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `data_kematian_populations`
--

DROP TABLE IF EXISTS `data_kematian_populations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `data_kematian_populations` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_population` int NOT NULL,
  `total_kematian` int NOT NULL,
  `jam` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_data_kematian_population` (`id_population`),
  CONSTRAINT `fk_data_kematian_population` FOREIGN KEY (`id_population`) REFERENCES `populations` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `data_kematian_populations`
--

LOCK TABLES `data_kematian_populations` WRITE;
/*!40000 ALTER TABLE `data_kematian_populations` DISABLE KEYS */;
/*!40000 ALTER TABLE `data_kematian_populations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
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
-- Table structure for table `kandang`
--

DROP TABLE IF EXISTS `kandang`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `kandang` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_user` bigint unsigned DEFAULT NULL,
  `id_peternak` bigint unsigned DEFAULT NULL,
  `nama_kandang` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `populasi_awal` int NOT NULL,
  `populasi_saat_ini` int NOT NULL,
  `alamat_kandang` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `luas_kandang` double(8,2) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `updated_by` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nama_kandang` (`nama_kandang`),
  KEY `id_user` (`id_user`),
  KEY `id_peternak` (`id_peternak`),
  CONSTRAINT `id_peternak` FOREIGN KEY (`id_peternak`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `id_user` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kandang`
--

LOCK TABLES `kandang` WRITE;
/*!40000 ALTER TABLE `kandang` DISABLE KEYS */;
INSERT INTO `kandang` VALUES (1,2,3,'Kandang 1',20,20,'Jln Kandang 1',255.00,'2023-12-12 12:47:16',NULL,NULL,NULL),(2,2,3,'Kandang 2',23,23,'Jln Kandang 2',155.00,'2023-12-12 12:47:16',NULL,NULL,NULL);
/*!40000 ALTER TABLE `kandang` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'2014_10_12_000000_create_users_table',1),(2,'2014_10_12_100000_create_password_resets_table',1),(3,'2014_10_12_200000_add_two_factor_columns_to_users_table',1),(4,'2019_08_19_000000_create_failed_jobs_table',1),(5,'2019_12_14_000001_create_personal_access_tokens_table',1),(6,'2021_01_24_083237_create_sessions_table',1),(7,'2023_10_01_063813_create_amoniak_sensors_table',1),(8,'2023_10_01_063813_create_data_kandang_table',1),(9,'2023_10_01_063813_create_data_kematian_populations_table',1),(10,'2023_10_01_063813_create_data_kematian_table',1),(11,'2023_10_01_063813_create_kandang_table',1),(12,'2023_10_01_063813_create_notification',1),(13,'2023_10_01_063813_create_panen_table',1),(14,'2023_10_01_063813_create_populations_table',1),(15,'2023_10_01_063813_create_rekap_data_harian_table',1),(16,'2023_10_01_063813_create_rekap_data_table',1),(17,'2023_10_01_063813_create_roles_table',1),(18,'2023_10_01_063813_create_suhu_kelembapan_sensors_table',1),(19,'2023_10_01_063816_add_foreign_keys_to_amoniak_sensors_table',1),(20,'2023_10_01_063816_add_foreign_keys_to_data_kandang_table',1),(21,'2023_10_01_063816_add_foreign_keys_to_data_kematian_populations_table',1),(22,'2023_10_01_063816_add_foreign_keys_to_data_kematian_table',1),(23,'2023_10_01_063816_add_foreign_keys_to_kandang_table',1),(24,'2023_10_01_063816_add_foreign_keys_to_notification_table',1),(25,'2023_10_01_063816_add_foreign_keys_to_panen_table',1),(26,'2023_10_01_063816_add_foreign_keys_to_populations',1),(27,'2023_10_01_063816_add_foreign_keys_to_rekap_data_harian_table',1),(28,'2023_10_01_063816_add_foreign_keys_to_rekap_data_table',1),(29,'2023_10_01_063816_add_foreign_keys_to_suhu_kelembapan_sensors_table copy',1),(30,'2023_10_01_063816_add_foreign_keys_to_users_table copy',1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `notification`
--

DROP TABLE IF EXISTS `notification`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `notification` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_kandang` int NOT NULL,
  `pesan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL,
  `waktu` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `fk_notification_kandang` (`id_kandang`),
  CONSTRAINT `fk_notification_kandang` FOREIGN KEY (`id_kandang`) REFERENCES `kandang` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `notification`
--

LOCK TABLES `notification` WRITE;
/*!40000 ALTER TABLE `notification` DISABLE KEYS */;
INSERT INTO `notification` VALUES (1,1,'Halo Smartfarm ini pesan pertama',1,'2023-12-12 05:47:16');
/*!40000 ALTER TABLE `notification` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `panen`
--

DROP TABLE IF EXISTS `panen`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `panen` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_kandang` int NOT NULL,
  `tanggal_mulai` date NOT NULL,
  `tanggal_panen` date NOT NULL,
  `jumlah_panen` int NOT NULL,
  `bobot_total` int NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `updated_by` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_panen_kandang` (`id_kandang`),
  CONSTRAINT `fk_panen_kandang` FOREIGN KEY (`id_kandang`) REFERENCES `kandang` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `panen`
--

LOCK TABLES `panen` WRITE;
/*!40000 ALTER TABLE `panen` DISABLE KEYS */;
INSERT INTO `panen` VALUES (1,1,'2023-12-12','2023-12-18',50,20,'2023-12-12 06:02:33',2,'2023-12-12 06:02:33',NULL);
/*!40000 ALTER TABLE `panen` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_resets`
--

LOCK TABLES `password_resets` WRITE;
/*!40000 ALTER TABLE `password_resets` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_resets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `personal_access_tokens`
--

DROP TABLE IF EXISTS `personal_access_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `personal_access_tokens` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
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
-- Table structure for table `populations`
--

DROP TABLE IF EXISTS `populations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `populations` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_kandang` int NOT NULL,
  `population` int NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `updated_by` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_kandang` (`id_kandang`),
  CONSTRAINT `fK_populations_kandang` FOREIGN KEY (`id_kandang`) REFERENCES `kandang` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `populations`
--

LOCK TABLES `populations` WRITE;
/*!40000 ALTER TABLE `populations` DISABLE KEYS */;
INSERT INTO `populations` VALUES (1,1,30,'2023-12-12 12:47:16',NULL,NULL,NULL);
/*!40000 ALTER TABLE `populations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rekap_data`
--

DROP TABLE IF EXISTS `rekap_data`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `rekap_data` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_kandang` int NOT NULL,
  `hari_ke` int NOT NULL,
  `date` date NOT NULL,
  `rata_rata_amoniak` int NOT NULL,
  `rata_rata_suhu` int NOT NULL,
  `kelembapan` int NOT NULL,
  `pakan` int NOT NULL,
  `minum` int NOT NULL,
  `bobot` int NOT NULL,
  `jumlah_kematian` int DEFAULT NULL,
  `jumlah_kematian_harian` int NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_by` int DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `updated_by` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_rekap_data_kandang` (`id_kandang`),
  CONSTRAINT `fk_rekap_data_kandang` FOREIGN KEY (`id_kandang`) REFERENCES `kandang` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rekap_data`
--

LOCK TABLES `rekap_data` WRITE;
/*!40000 ALTER TABLE `rekap_data` DISABLE KEYS */;
/*!40000 ALTER TABLE `rekap_data` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rekap_data_harian`
--

DROP TABLE IF EXISTS `rekap_data_harian`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `rekap_data_harian` (
  `id` int NOT NULL,
  `id_kandang` int NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `amoniak` int NOT NULL,
  `suhu` int NOT NULL,
  `kelembapan` int NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_by` int DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `updated_by` int DEFAULT NULL,
  KEY `fk_rekap_data_harian_kandang` (`id_kandang`),
  CONSTRAINT `fk_rekap_data_harian_kandang` FOREIGN KEY (`id_kandang`) REFERENCES `kandang` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rekap_data_harian`
--

LOCK TABLES `rekap_data_harian` WRITE;
/*!40000 ALTER TABLE `rekap_data_harian` DISABLE KEYS */;
/*!40000 ALTER TABLE `rekap_data_harian` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `roles` (
  `id_role` int NOT NULL AUTO_INCREMENT,
  `nama_role` varchar(11) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id_role`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` VALUES (1,'Admin'),(2,'Pemilik'),(3,'Peternak');
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sessions`
--

LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
INSERT INTO `sessions` VALUES ('0RXCHowf6sBqWgWSuXXqz6NxkSPKQm8rQR0mzr8v',3,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36','YTo2OntzOjY6Il90b2tlbiI7czo0MDoiYTh1SGh5WlcwZXB5c3VqWDYzWURQT1JDSkFQbjd6dkNrYUQ1R1pQUiI7czozOiJ1cmwiO2E6MDp7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjQzOiJodHRwOi8vMTI3LjAuMC4xOjgwMDAva2xhc2lmaWthc2lNb25pdG9yaW5nIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MztzOjIxOiJwYXNzd29yZF9oYXNoX3NhbmN0dW0iO3M6NjA6IiQyeSQxMCQ5MklYVU5wa2pPMHJPUTVieU1pLlllNG9Lb0VhM1JvOWxsQy8ub2cvYXQyLnVoZVdHL2lnaSI7fQ==',1702395053),('MSWJXMraWtr2HGPQgZBNYFyU1PVDEfcdatXWEmsS',2,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36','YTo2OntzOjY6Il90b2tlbiI7czo0MDoiYWtIMkVRNmpLb3JSRnJWSFNnYTlJMGJTZXFnV1lGM0g1V1ZXWUtwMyI7czozOiJ1cmwiO2E6MDp7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjMzOiJodHRwOi8vMTI3LjAuMC4xOjgwMDAvZGF0YUthbmRhbmciO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToyO3M6MjE6InBhc3N3b3JkX2hhc2hfc2FuY3R1bSI7czo2MDoiJDJ5JDEwJDkySVhVTnBrak8wck9RNWJ5TWkuWWU0b0tvRWEzUm85bGxDLy5vZy9hdDIudWhlV0cvaWdpIjt9',1702395052);
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `suhu_kelembapan_sensors`
--

DROP TABLE IF EXISTS `suhu_kelembapan_sensors`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `suhu_kelembapan_sensors` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_kandang` int NOT NULL,
  `suhu` int NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `kelembapan` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_suhu_kelembapan_sensors_kandang` (`id_kandang`),
  CONSTRAINT `fk_suhu_kelembapan_sensors_kandang` FOREIGN KEY (`id_kandang`) REFERENCES `kandang` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `suhu_kelembapan_sensors`
--

LOCK TABLES `suhu_kelembapan_sensors` WRITE;
/*!40000 ALTER TABLE `suhu_kelembapan_sensors` DISABLE KEYS */;
/*!40000 ALTER TABLE `suhu_kelembapan_sensors` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `id_role` int NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `two_factor_secret` text COLLATE utf8mb4_unicode_ci,
  `two_factor_recovery_codes` text COLLATE utf8mb4_unicode_ci,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `current_team_id` bigint unsigned DEFAULT NULL,
  `profile_photo_path` text COLLATE utf8mb4_unicode_ci,
  `created_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `updated_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  KEY `id_role_user` (`id_role`),
  CONSTRAINT `id_role_user` FOREIGN KEY (`id_role`) REFERENCES `roles` (`id_role`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,1,'Admin',NULL,'admin@gmail.com','2023-12-12 05:47:16','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',NULL,NULL,'zyT8nKBydo',NULL,NULL,NULL,NULL,'2023-12-12 05:47:16','2023-12-12 05:47:16'),(2,2,'Pemilik',NULL,'pemilik@gmail.com','2023-12-12 05:47:16','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',NULL,NULL,'7itwhcvvrk',NULL,NULL,NULL,NULL,'2023-12-12 05:47:16','2023-12-12 05:47:16'),(3,3,'Peternak',NULL,'peternak@gmail.com','2023-12-12 05:47:16','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',NULL,NULL,'2yQCfgj9kT',NULL,NULL,NULL,NULL,'2023-12-12 05:47:16','2023-12-12 05:47:16');
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

-- Dump completed on 2023-12-13  0:12:41
