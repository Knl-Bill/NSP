-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Mar 30, 2025 at 11:55 AM
-- Server version: 8.0.31
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `nsp`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_logins`
--

DROP TABLE IF EXISTS `admin_logins`;
CREATE TABLE IF NOT EXISTS `admin_logins` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `phoneno` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `gender` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `department` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `admin_logins_phoneno_unique` (`phoneno`),
  UNIQUE KEY `admin_logins_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admin_logins`
--

INSERT INTO `admin_logins` (`id`, `name`, `phoneno`, `email`, `gender`, `department`, `password`) VALUES
(2, 'Dr. Hemachander', '1234567891', 'conatact.outrager@gmail.com', 'Male', 'EEE', '$2y$10$CqslvH9nktzizJzkBh5Yr.ZBJpwjsyy6GIimKExIRqe1iOyZxW.fq'),
(4, 'Dr Sanjay Bankapur', '1234567890', 'hprasad13579@gmail.com', 'Male', 'CSE', '$2y$12$X8MaJSHC0NQJEwkgcf.mgO3vbS167FHp95Wy78limDGYb5B9QrWFi');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
CREATE TABLE IF NOT EXISTS `cache` (
  `key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
CREATE TABLE IF NOT EXISTS `cache_locks` (
  `key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `forgot_passes`
--

DROP TABLE IF EXISTS `forgot_passes`;
CREATE TABLE IF NOT EXISTS `forgot_passes` (
  `email` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `forgot_passes_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `guestentry`
--

DROP TABLE IF EXISTS `guestentry`;
CREATE TABLE IF NOT EXISTS `guestentry` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phoneno` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `checkin_date` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `checkin_time` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `checkin_gate` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `checkout_date` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `checkout_time` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `checkout_gate` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_Id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `student_rollno` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `stay_at` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `guestentry`
--

INSERT INTO `guestentry` (`id`, `name`, `phoneno`, `checkin_date`, `checkin_time`, `checkin_gate`, `checkout_date`, `checkout_time`, `checkout_gate`, `email_Id`, `student_rollno`, `stay_at`) VALUES
(1, 'Kunal Billade', '9270466156', '2025-02-22', '01:06:58', 'main', '2025-02-22', '01:19:39', 'main', 'captainbarns1@gmail.com', 'CS21B1009', 'Bharani Hostel'),
(2, 'Harsh Prasad', '9345301929', '2025-02-22', '01:07:44', 'poovam', NULL, NULL, NULL, 'conatact.outrager@gmail.com', 'CS21B1014', 'Guest House'),
(3, 'Manvitha Pagadala', '93936 25115', '2025-02-22', '01:09:08', 'main', '2025-02-22', '01:25:21', 'poovam', 'pagadalamanvi@gmail.com', 'CS21B1032', 'Moyar Hostel'),
(4, 'Koustuv Saha', '1234567890', '2025-02-22', '01:24:58', 'main', NULL, NULL, NULL, 'koustuv026saha@gmail.com', 'CS21B1023', 'Faculty Quarters');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
CREATE TABLE IF NOT EXISTS `jobs` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `queue` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `leaveext`
--

DROP TABLE IF EXISTS `leaveext`;
CREATE TABLE IF NOT EXISTS `leaveext` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `rollno` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `phoneno` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `placeofvisit` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `outdate` date NOT NULL,
  `outime` time NOT NULL,
  `indate` date NOT NULL,
  `intime` time NOT NULL,
  `image` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `faculty_email` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `warden_email` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `faculty_adv` int NOT NULL DEFAULT '0',
  `warden` int NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `stud_photo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `leaveid` bigint NOT NULL,
  `ext_reason` varchar(1000) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `new_indate` date NOT NULL,
  `new_intime` time(6) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `leavereqs_rollno_unique` (`rollno`),
  UNIQUE KEY `leavereqs_phoneno_unique` (`phoneno`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `leaveext`
--

INSERT INTO `leaveext` (`id`, `rollno`, `name`, `phoneno`, `placeofvisit`, `outdate`, `outime`, `indate`, `intime`, `image`, `faculty_email`, `warden_email`, `faculty_adv`, `warden`, `created_at`, `updated_at`, `stud_photo`, `leaveid`, `ext_reason`, `new_indate`, `new_intime`) VALUES
(5, 'CS21B1009', 'Kunal Billade', '1234567891', 'Kalyan', '2024-09-30', '21:12:00', '2024-10-05', '12:12:00', 'leavereq_emails/CS21B1009_ext_2024-10-13', 'hprasad13579@gmail.com', 'conatact.outrager@gmail.com', 0, 0, '2024-10-01 06:16:15', '2024-10-01 06:16:15', 'CS21B1009.png', 1, 'I\'m sick', '2024-10-13', '12:12:00.000000');

-- --------------------------------------------------------

--
-- Table structure for table `leavehistory`
--

DROP TABLE IF EXISTS `leavehistory`;
CREATE TABLE IF NOT EXISTS `leavehistory` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `rollno` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `phoneno` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `placeofvisit` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `purpose` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `outtime` datetime NOT NULL,
  `intime` datetime DEFAULT NULL,
  `outregistration` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `outgate` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `inregistration` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ingate` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `gender` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `year` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `course` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `late` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `leavehistory`
--

INSERT INTO `leavehistory` (`id`, `rollno`, `name`, `phoneno`, `placeofvisit`, `purpose`, `outtime`, `intime`, `outregistration`, `outgate`, `inregistration`, `ingate`, `created_at`, `updated_at`, `gender`, `year`, `course`, `late`) VALUES
(1, 'CS21B1009', 'Kunal Billade', '9270466156', 'Kalyan', 'I\'m Sick', '2024-10-02 23:15:09', '2024-10-02 23:16:02', 'Jeel Patel', 'Poovam', 'Jeel Patel', 'Main', NULL, NULL, 'Male', '2021', 'B.Tech.', 0);

-- --------------------------------------------------------

--
-- Table structure for table `leavereqs`
--

DROP TABLE IF EXISTS `leavereqs`;
CREATE TABLE IF NOT EXISTS `leavereqs` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `rollno` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `phoneno` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `placeofvisit` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `purpose` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `outdate` date NOT NULL,
  `outime` time NOT NULL,
  `indate` date NOT NULL,
  `intime` time NOT NULL,
  `noofdays` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `faculty_email` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `warden_email` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `faculty_adv` int NOT NULL DEFAULT '0',
  `warden` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `gender` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `year` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `course` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `stud_photo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `leavereqs_rollno_unique` (`rollno`),
  UNIQUE KEY `leavereqs_phoneno_unique` (`phoneno`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `leavereq_histories`
--

DROP TABLE IF EXISTS `leavereq_histories`;
CREATE TABLE IF NOT EXISTS `leavereq_histories` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `rollno` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `phoneno` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `placeofvisit` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `purpose` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `outdate` date NOT NULL,
  `outime` time NOT NULL,
  `indate` date NOT NULL,
  `intime` time NOT NULL,
  `noofdays` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `faculty_adv` int NOT NULL DEFAULT '0',
  `warden` int NOT NULL DEFAULT '0',
  `image` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `barcode` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `faculty_email` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `warden_email` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `gender` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `year` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `course` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `stud_photo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `remark` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `leavereq_histories`
--

INSERT INTO `leavereq_histories` (`id`, `rollno`, `name`, `phoneno`, `placeofvisit`, `purpose`, `outdate`, `outime`, `indate`, `intime`, `noofdays`, `faculty_adv`, `warden`, `image`, `barcode`, `status`, `faculty_email`, `warden_email`, `created_at`, `updated_at`, `gender`, `year`, `course`, `stud_photo`, `remark`) VALUES
(2, 'CS21M1009', 'Kunal Billade', '1234567890', 'Kalyan', 'Home', '2024-10-02', '23:45:00', '2024-10-04', '12:12:00', '2', 1, 2, 'leavereq_emails/CS21M1009_2024-10-02', NULL, 'Declined', 'hprasad13579@gmail.com', 'conatact.outrager@gmail.com', '2024-09-30 08:55:14', '2024-09-30 08:55:14', 'Male', '2022', 'B.Tech.', 'CS21M1009.png', 'Excuses');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=91 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(73, '2014_10_12_000000_create_users_table', 1),
(74, '2014_10_12_100000_create_password_resets_table', 1),
(75, '2019_08_19_000000_create_failed_jobs_table', 1),
(76, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(77, '2024_05_09_062050_create_students_table', 1),
(78, '2024_05_13_061057_create_leavereqs_table', 1),
(79, '2024_05_13_111139_create_det_warfacs_table', 1),
(80, '2024_05_15_211651_create_security_logins_table', 1),
(81, '2024_05_17_093653_create_forgot_passes_table', 1),
(82, '2024_05_18_202734_outing__table', 1),
(83, '2024_05_21_053514_admin_login', 1),
(84, '2024_05_21_064508_create_password_reset_securities_table', 1),
(85, '2024_05_21_105926_password_reset_admin', 1),
(86, '2024_05_22_105903_create_leavereq_histories_table', 1),
(87, '2024_05_28_083010_leavehistory', 1),
(88, '2024_07_17_155726_create_glh_outings_table', 2),
(89, '2024_07_23_165440_create_jobs_table', 3),
(90, '2025_02_21_171529_guestentry', 3);

-- --------------------------------------------------------

--
-- Table structure for table `nitpy`
--

DROP TABLE IF EXISTS `nitpy`;
CREATE TABLE IF NOT EXISTS `nitpy` (
  `name` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `rollno` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  PRIMARY KEY (`rollno`),
  KEY `rollno` (`rollno`),
  KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `nitpy`
--

INSERT INTO `nitpy` (`name`, `rollno`, `email`) VALUES
('Harsh Prasad', 'CS21B1014', 'hprasad13579@gmail.com'),
('Kunal Billade', 'CS21M1009', 'kunal003billade@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `nitpy_signup`
--

DROP TABLE IF EXISTS `nitpy_signup`;
CREATE TABLE IF NOT EXISTS `nitpy_signup` (
  `email` varchar(191) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `token` varchar(191) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `nitpy_signup`
--

INSERT INTO `nitpy_signup` (`email`, `token`, `created_at`) VALUES
('hprasad13579@gmail.com', 'w71V27RPvrGGQKgFaVejGbmbZktwgHvKG3ADLMSvXoJOaGuAv0Y99sOapoYfvTps', '2024-09-30 07:28:39');

-- --------------------------------------------------------

--
-- Table structure for table `outing__table`
--

DROP TABLE IF EXISTS `outing__table`;
CREATE TABLE IF NOT EXISTS `outing__table` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `rollno` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `phoneno` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `year` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `gender` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `hostel` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `roomno` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `outtime` datetime NOT NULL,
  `intime` datetime DEFAULT NULL,
  `security_out` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `out_gate` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `security_in` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `in_gate` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `course` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `vehicle` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `late` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `outing__table`
--

INSERT INTO `outing__table` (`id`, `rollno`, `name`, `phoneno`, `email`, `year`, `gender`, `hostel`, `roomno`, `outtime`, `intime`, `security_out`, `out_gate`, `security_in`, `in_gate`, `course`, `vehicle`, `late`) VALUES
(1, 'CS21B1009', 'Kunal Billade', '1234567891', 'captainbarns1@gmail.com', '2021', 'Male', 'Moyar Hostel', 'A-4', '2024-10-02 22:59:47', '2024-10-02 23:00:07', 'Jeel Patel', 'Poovam', 'Jeel Patel', 'Main', 'B.Tech.', 'TN50L3837', 1);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE IF NOT EXISTS `password_resets` (
  `email` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_admins`
--

DROP TABLE IF EXISTS `password_reset_admins`;
CREATE TABLE IF NOT EXISTS `password_reset_admins` (
  `email` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_securities`
--

DROP TABLE IF EXISTS `password_reset_securities`;
CREATE TABLE IF NOT EXISTS `password_reset_securities` (
  `email` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

DROP TABLE IF EXISTS `personal_access_tokens`;
CREATE TABLE IF NOT EXISTS `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `security_logins`
--

DROP TABLE IF EXISTS `security_logins`;
CREATE TABLE IF NOT EXISTS `security_logins` (
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `phoneno` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `gender` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  UNIQUE KEY `security_logins_phoneno_unique` (`phoneno`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `security_logins`
--

INSERT INTO `security_logins` (`name`, `phoneno`, `email`, `email_verified_at`, `password`, `gender`) VALUES
('Koustuv Saha', '9345301928', 'captainbarns1@gmail.com', '0000-00-00 00:00:00', '$2y$12$2J2wGUILv6eH0c4vD8sNteEtCowtz68DMFNy2GW277Vlo.PNlr8GG', 'Male'),
('Jeel Patel', '9345301929', 'captainbarns1@gmail.com', '0000-00-00 00:00:00', '$2y$10$GXkBibz62APj/N4YFy9qYOLNexdQVoIgGZvQNApn5df8l3ZKUQVre', 'Male');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
CREATE TABLE IF NOT EXISTS `sessions` (
  `id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

DROP TABLE IF EXISTS `students`;
CREATE TABLE IF NOT EXISTS `students` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `rollno` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `phoneno` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `course` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `dept` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `gender` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `hostelname` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `roomno` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `faculty_advisor` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `warden` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `barcode` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `profile_picture` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `students_rollno_unique` (`rollno`),
  UNIQUE KEY `students_phoneno_unique` (`phoneno`),
  UNIQUE KEY `students_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `rollno`, `name`, `phoneno`, `email`, `course`, `batch`, `dept`, `gender`, `hostelname`, `roomno`, `faculty_advisor`, `warden`, `password`, `created_at`, `updated_at`, `barcode`, `profile_picture`) VALUES
(1, 'CS21B1009', 'Kunal Billade', '1234567891', 'captainbarns1@gmail.com', 'B.Tech.', '2021', 'Computer Science and Engineering', 'Male', 'Moyar Hostel', 'A-4', 'hprasad13579@gmail.com', 'conatact.outrager@gmail.com', '$2y$10$Q2bjjQIyton5qUOaxXpSO.DW1DDkqbg78thMZ0.loLj8kn7/0C4qy', NULL, NULL, 'student_roll_barcodes/CS21B1009.png', 'CS21B1009.png'),
(2, 'CS21M1009', 'Kunal Billade', '1234567890', 'kunal003billade@gmail.com', 'B.Tech.', '2022', 'Computer Science and Engineering', 'Male', 'Bharani Hostel', 'T-6', 'hprasad13579@gmail.com', 'conatact.outrager@gmail.com', '$2y$10$yYD4D9Jo9xQtptD.mdDFs.L.pBDwOM25ZdLrIMkMiio7kgUp3ZLbm', NULL, NULL, 'student_roll_barcodes/CS21M1009.png', 'CS21M1009.png');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
