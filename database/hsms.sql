-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 07, 2026 at 03:37 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hsms`
--

-- --------------------------------------------------------

--
-- Table structure for table `appointments`
--

CREATE TABLE `appointments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` bigint(20) UNSIGNED NOT NULL,
  `employee_id` bigint(20) UNSIGNED DEFAULT NULL,
  `discount_id` bigint(20) UNSIGNED DEFAULT NULL,
  `appointment_date` date NOT NULL,
  `appointment_time` time NOT NULL,
  `status` enum('pending','confirmed','completed','cancelled') NOT NULL DEFAULT 'pending',
  `cancellation_reason` text DEFAULT NULL,
  `payment_method` enum('cash','gcash') NOT NULL,
  `payment_status` enum('pending','for_validation','paid') NOT NULL DEFAULT 'pending',
  `total_amount` decimal(8,2) DEFAULT NULL,
  `loyalty_discount_applied` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `appointments`
--

INSERT INTO `appointments` (`id`, `customer_id`, `employee_id`, `discount_id`, `appointment_date`, `appointment_time`, `status`, `cancellation_reason`, `payment_method`, `payment_status`, `total_amount`, `loyalty_discount_applied`, `created_at`, `updated_at`, `deleted_at`) VALUES
(2, 1, 2, NULL, '2026-03-17', '10:00:00', 'confirmed', NULL, 'cash', 'paid', 250.00, 0, '2026-03-14 03:13:08', '2026-04-13 19:11:27', NULL),
(3, 2, 1, NULL, '2026-03-18', '00:18:00', 'completed', NULL, 'gcash', 'paid', 1299.00, 0, '2026-03-15 05:15:43', '2026-04-13 19:23:55', NULL),
(4, 3, 2, NULL, '2026-03-31', '13:00:00', 'cancelled', NULL, 'cash', 'pending', 399.00, 0, '2026-03-20 17:12:25', '2026-05-10 03:14:12', NULL),
(5, 3, 1, NULL, '2026-04-09', '10:00:00', 'completed', NULL, 'cash', 'paid', 99.00, 0, '2026-03-20 22:39:40', '2026-04-13 18:46:41', NULL),
(6, 4, 1, NULL, '2026-04-07', '09:00:00', 'completed', NULL, 'gcash', 'paid', 1200.00, 0, '2026-03-20 22:56:44', '2026-04-13 18:59:24', NULL),
(7, 4, 1, 1, '2026-04-11', '09:00:00', 'completed', NULL, 'gcash', 'paid', 899.10, 0, '2026-03-28 22:47:50', '2026-05-14 05:53:30', NULL),
(8, 3, 1, 1, '2026-04-24', '13:00:00', 'completed', NULL, 'cash', 'paid', 225.00, 0, '2026-03-30 18:39:42', '2026-05-14 05:53:11', NULL),
(9, 2, 2, NULL, '2026-04-14', '12:30:00', 'completed', NULL, 'cash', 'paid', 499.00, 0, '2026-04-13 19:20:43', '2026-04-13 19:22:31', NULL),
(10, 4, 2, NULL, '2026-04-14', '11:00:00', 'completed', NULL, 'cash', 'paid', 750.00, 0, '2026-04-13 19:31:06', '2026-04-13 19:37:17', NULL),
(11, 6, 5, NULL, '2026-04-23', '11:00:00', 'completed', NULL, 'cash', 'paid', 1888.00, 0, '2026-04-20 17:19:40', '2026-05-10 03:12:18', NULL),
(12, 6, 5, NULL, '2026-04-27', '15:30:00', 'completed', NULL, 'cash', 'paid', 1200.00, 0, '2026-04-26 23:55:08', '2026-04-26 23:55:50', NULL),
(13, 9, 7, NULL, '2026-05-12', '11:00:00', 'completed', NULL, 'gcash', 'paid', 1888.00, 0, '2026-05-11 03:58:31', '2026-05-14 21:21:41', NULL),
(14, 2, NULL, NULL, '2026-04-30', '11:35:00', 'cancelled', NULL, 'cash', 'pending', 999.00, 0, '2026-05-13 18:36:56', '2026-05-13 18:51:58', NULL),
(15, 12, 5, 1, '2026-05-14', '11:37:00', 'completed', NULL, 'cash', 'paid', 1699.20, 0, '2026-05-13 18:44:51', '2026-05-13 18:51:31', NULL),
(16, 2, 1, NULL, '2026-05-16', '10:45:00', 'confirmed', NULL, 'gcash', 'paid', 1200.00, 0, '2026-05-13 18:47:05', '2026-05-13 19:18:48', NULL),
(17, 7, 7, NULL, '2026-05-16', '14:16:00', 'completed', NULL, 'cash', 'paid', 1200.00, 0, '2026-05-13 19:16:31', '2026-05-14 23:37:27', NULL),
(18, 10, NULL, NULL, '2026-05-16', '14:33:00', 'pending', NULL, 'gcash', 'paid', 99.00, 0, '2026-05-13 19:34:15', '2026-05-14 20:35:12', NULL),
(19, 3, 7, NULL, '2026-05-23', '13:27:00', 'confirmed', NULL, 'cash', 'paid', 1888.00, 0, '2026-05-13 21:27:58', '2026-05-14 04:05:13', NULL),
(20, 3, 5, NULL, '2026-05-14', '16:32:00', 'completed', NULL, 'gcash', 'paid', 1888.00, 0, '2026-05-13 21:32:35', '2026-05-14 05:52:35', NULL),
(21, 3, 6, NULL, '2026-05-23', '09:30:00', 'cancelled', NULL, 'cash', 'pending', 199.00, 0, '2026-05-14 03:14:47', '2026-05-15 01:33:01', NULL),
(22, 3, NULL, NULL, '2026-05-24', '10:00:00', 'pending', NULL, 'cash', 'pending', 1200.00, 0, '2026-05-14 06:00:37', '2026-05-14 20:47:52', NULL),
(23, 6, 6, NULL, '2026-06-04', '15:00:00', 'completed', NULL, 'gcash', 'paid', 399.00, 0, '2026-05-14 21:45:55', '2026-05-14 21:47:30', NULL),
(24, 5, 1, NULL, '2026-05-30', '16:30:00', 'completed', NULL, 'gcash', 'paid', 99.00, 0, '2026-05-14 22:28:23', '2026-05-14 23:27:42', NULL),
(25, 5, 5, NULL, '2026-05-16', '15:30:00', 'completed', NULL, 'cash', 'paid', 999.00, 0, '2026-05-14 23:25:01', '2026-05-14 23:30:31', NULL),
(26, 5, 1, NULL, '2026-05-17', '10:30:00', 'completed', NULL, 'cash', 'paid', 750.00, 0, '2026-05-14 23:25:26', '2026-05-14 23:30:42', NULL),
(27, 5, 2, NULL, '2026-05-19', '16:30:00', 'cancelled', NULL, 'cash', 'pending', 499.00, 0, '2026-05-15 00:27:02', '2026-05-15 01:36:41', NULL),
(28, 12, 7, 2, '2026-05-28', '09:00:00', 'cancelled', NULL, 'cash', 'pending', 350.00, 0, '2026-05-15 02:52:33', '2026-05-22 05:36:13', NULL),
(29, 3, NULL, NULL, '2026-05-20', '09:00:00', 'pending', NULL, 'cash', 'pending', 499.00, 0, '2026-05-19 12:47:11', '2026-05-19 12:47:11', NULL),
(30, 4, NULL, NULL, '2026-05-22', '09:30:00', 'pending', NULL, 'cash', 'pending', 899.10, 0, '2026-05-22 00:31:18', '2026-05-22 00:31:18', NULL),
(31, 11, NULL, NULL, '2026-05-23', '17:30:00', 'pending', NULL, 'gcash', 'for_validation', 999.00, 0, '2026-05-22 00:34:20', '2026-05-22 00:34:20', NULL),
(32, 12, NULL, NULL, '2026-05-23', '18:00:00', 'pending', NULL, 'gcash', 'for_validation', 750.00, 0, '2026-05-22 00:35:31', '2026-05-22 00:35:31', NULL),
(33, 3, 6, NULL, '2026-05-25', '18:30:00', 'completed', NULL, 'gcash', 'paid', 499.00, 0, '2026-05-22 00:36:42', '2026-05-22 05:35:09', NULL),
(34, 3, NULL, NULL, '2026-05-25', '18:30:00', 'pending', NULL, 'gcash', 'for_validation', 1200.00, 0, '2026-05-22 01:37:21', '2026-05-22 01:37:21', NULL),
(35, 3, NULL, NULL, '2026-05-25', '17:00:00', 'pending', NULL, 'gcash', 'for_validation', 1200.00, 0, '2026-05-22 01:40:01', '2026-05-22 01:40:01', NULL),
(36, 3, NULL, NULL, '2026-05-26', '11:30:00', 'cancelled', NULL, 'gcash', 'for_validation', 300.00, 0, '2026-05-22 05:24:53', '2026-05-22 05:26:48', NULL),
(37, 14, NULL, NULL, '2026-05-25', '14:30:00', 'pending', NULL, 'cash', 'pending', 1500.00, 0, '2026-05-22 05:32:15', '2026-05-22 05:32:15', NULL),
(38, 3, 1, NULL, '2026-05-29', '12:00:00', 'completed', NULL, 'cash', 'paid', 300.00, 0, '2026-05-22 05:52:22', '2026-05-22 05:55:59', NULL),
(39, 3, 2, NULL, '2026-05-28', '14:00:00', 'completed', NULL, 'cash', 'paid', 199.00, 0, '2026-05-22 05:52:58', '2026-05-22 05:56:49', NULL),
(40, 3, NULL, NULL, '2026-05-30', '10:00:00', 'pending', NULL, 'cash', 'pending', 630.00, 0, '2026-05-22 06:00:15', '2026-05-22 06:00:15', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `appointment_service`
--

CREATE TABLE `appointment_service` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `appointment_id` bigint(20) UNSIGNED NOT NULL,
  `service_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `appointment_service`
--

INSERT INTO `appointment_service` (`id`, `appointment_id`, `service_id`, `quantity`, `created_at`, `updated_at`) VALUES
(2, 2, 1, 1, '2026-03-14 03:13:08', '2026-03-14 03:13:08'),
(4, 4, 14, 1, '2026-03-20 17:12:25', '2026-03-20 17:12:25'),
(5, 5, 6, 1, '2026-03-20 22:39:40', '2026-03-20 22:39:40'),
(6, 6, 2, 1, '2026-03-20 22:56:44', '2026-03-20 22:56:44'),
(7, 7, 10, 1, '2026-03-28 22:47:50', '2026-03-28 22:47:50'),
(8, 8, 1, 1, '2026-03-30 18:39:42', '2026-03-30 18:39:42'),
(9, 3, 8, 1, '2026-04-13 18:40:08', '2026-04-13 18:40:08'),
(10, 9, 13, 1, '2026-04-13 19:20:43', '2026-04-13 19:20:43'),
(11, 10, 15, 1, '2026-04-13 19:31:06', '2026-04-13 19:31:06'),
(12, 11, 12, 1, '2026-04-20 17:19:40', '2026-04-20 17:19:40'),
(13, 12, 2, 1, '2026-04-26 23:55:08', '2026-04-26 23:55:08'),
(14, 13, 12, 1, '2026-05-11 03:58:31', '2026-05-11 03:58:31'),
(15, 14, 10, 1, '2026-05-13 18:36:56', '2026-05-13 18:36:56'),
(16, 15, 12, 1, '2026-05-13 18:44:51', '2026-05-13 18:44:51'),
(17, 16, 2, 1, '2026-05-13 18:47:05', '2026-05-13 18:47:05'),
(18, 17, 2, 1, '2026-05-13 19:16:31', '2026-05-13 19:16:31'),
(19, 18, 6, 1, '2026-05-13 19:34:15', '2026-05-13 19:34:15'),
(20, 19, 12, 1, '2026-05-13 21:27:58', '2026-05-13 21:27:58'),
(21, 20, 12, 1, '2026-05-13 21:32:35', '2026-05-13 21:32:35'),
(22, 21, 3, 1, '2026-05-14 03:14:47', '2026-05-14 03:14:47'),
(23, 22, 2, 1, '2026-05-14 06:00:37', '2026-05-14 06:00:37'),
(24, 23, 14, 1, '2026-05-14 21:45:55', '2026-05-14 21:45:55'),
(25, 24, 5, 1, '2026-05-14 22:28:23', '2026-05-14 22:28:23'),
(26, 25, 9, 1, '2026-05-14 23:25:01', '2026-05-14 23:25:01'),
(27, 26, 15, 1, '2026-05-14 23:25:26', '2026-05-14 23:25:26'),
(28, 27, 13, 1, '2026-05-15 00:27:02', '2026-05-15 00:27:02'),
(29, 28, 16, 1, '2026-05-15 02:52:33', '2026-05-15 02:52:33'),
(30, 29, 13, 1, '2026-05-19 12:47:11', '2026-05-19 12:47:11'),
(31, 30, 10, 1, '2026-05-22 00:31:18', '2026-05-22 00:31:18'),
(32, 31, 10, 1, '2026-05-22 00:34:20', '2026-05-22 00:34:20'),
(33, 32, 15, 1, '2026-05-22 00:35:31', '2026-05-22 00:35:31'),
(34, 33, 13, 1, '2026-05-22 00:36:42', '2026-05-22 00:36:42'),
(35, 34, 2, 1, '2026-05-22 01:37:21', '2026-05-22 01:37:21'),
(36, 35, 2, 1, '2026-05-22 01:40:01', '2026-05-22 01:40:01'),
(37, 36, 1, 1, '2026-05-22 05:24:53', '2026-05-22 05:24:53'),
(38, 37, 7, 1, '2026-05-22 05:32:15', '2026-05-22 05:32:15'),
(39, 38, 1, 1, '2026-05-22 05:52:22', '2026-05-22 05:52:22'),
(40, 39, 3, 1, '2026-05-22 05:52:58', '2026-05-22 05:52:58'),
(41, 40, 16, 1, '2026-05-22 06:00:15', '2026-05-22 06:00:15');

-- --------------------------------------------------------

--
-- Table structure for table `audit_logs`
--

CREATE TABLE `audit_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `action` varchar(255) NOT NULL,
  `model_type` varchar(255) DEFAULT NULL,
  `model_id` bigint(20) UNSIGNED DEFAULT NULL,
  `old_values` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`old_values`)),
  `new_values` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`new_values`)),
  `ip` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('hair-salon-ms-cache-5c785c036466adea360111aa28563bfd556b5fba', 'i:1;', 1780793643),
('hair-salon-ms-cache-5c785c036466adea360111aa28563bfd556b5fba:timer', 'i:1780793643;', 1780793643);

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `birthdate` date DEFAULT NULL,
  `mobile_num` varchar(255) DEFAULT NULL,
  `gender` varchar(255) DEFAULT NULL,
  `loyalty_discount_available` tinyint(1) NOT NULL DEFAULT 0,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `user_id`, `first_name`, `last_name`, `birthdate`, `mobile_num`, `gender`, `loyalty_discount_available`, `image`, `created_at`, `updated_at`) VALUES
(1, 1, 'Christian', 'Cahilig', NULL, NULL, NULL, 0, NULL, '2026-03-14 02:28:17', '2026-03-14 02:28:17'),
(2, 4, 'Sabrina Rina', 'Carpenter', '2026-03-04', '09736153155', 'female', 0, 'customers/0MBvEAr7U3KO3dyqnm6jZbDN387dg6tv9UMGweJE.jpg', '2026-03-14 18:04:06', '2026-03-30 15:18:07'),
(3, 6, 'John Llorie', 'Sarmiento', '2005-01-13', '09781378131', 'male', 0, 'customers/sSk2mTYeU7VmS8oy1ViVTPiVMpomVHSVGkS0Ykxf.png', '2026-03-20 17:12:25', '2026-05-22 06:00:15'),
(4, 7, 'Hazeljoy', 'Hingpit', NULL, '09176347815', NULL, 0, NULL, '2026-03-20 22:56:44', '2026-05-22 00:31:18'),
(5, 8, 'Christian', 'Cahilig', NULL, '09495655839', NULL, 0, NULL, '2026-04-03 15:33:20', '2026-05-15 00:27:02'),
(6, 9, 'Annika', 'Dumalogdog', '2005-07-06', '09872642412', 'female', 1, 'customers/Ju1qrVu7Yn2C9sdyM7W97n3Q2ge4zdEPvLhgkmEJ.jpg', '2026-04-20 01:17:03', '2026-05-14 21:47:30'),
(7, 17, 'Glinda', 'Guding', '2001-06-13', '09361289491', 'female', 0, 'customers/z0ed0AniFLAvJs6dM6UFRfOUPkCEMWqtdyDR2ljm.jpg', '2026-05-09 18:52:17', '2026-05-09 18:52:17'),
(9, 19, 'Spencer', 'Agnew', NULL, '09782141241', NULL, 0, 'customers/A8IzscYUoNd6AlxVlKDhhz4yJBgJMvqzhAyFlV7G.jpg', '2026-05-11 03:58:31', '2026-05-12 21:49:07'),
(10, 20, 'Elphaba', 'Bading', '1985-04-13', '09827146892', 'female', 0, 'customers/bwjqFBjixoaS3Kd7LFUv8LRmJ0ttj7H1ZScO9zfZ.jpg', '2026-05-12 21:57:52', '2026-05-12 21:57:52'),
(11, 21, 'Dakota', 'Fanning', '1999-06-09', '09892498729', 'female', 0, 'customers/ac3oGAsWjCBbPrMAVKznIeoIEoSQdOdBPkv2TqMz.png', '2026-05-13 18:07:17', '2026-05-13 18:07:17'),
(12, 22, 'Jane', 'Doe', NULL, '09718246126', NULL, 0, NULL, '2026-05-13 18:44:51', '2026-05-13 18:44:51'),
(13, 23, 'Elle', 'Fanning', '1994-02-17', '09458162143', 'female', 0, 'customers/QO25LQhXVmBaIvl1H1OkUpWJ4P3Hos3BpRkhErOd.png', '2026-05-13 18:56:19', '2026-05-13 18:56:19'),
(14, 25, 'Jonathan', 'Byers', NULL, '09761847612', NULL, 0, NULL, '2026-05-22 05:32:15', '2026-05-22 05:32:15'),
(15, 26, 'Max', 'Mayfield', '2003-06-20', '09178563487', 'female', 0, NULL, '2026-05-22 05:47:51', '2026-05-22 05:50:17'),
(16, 27, 'Mike', 'Wheeler', '2001-03-12', '09815742148', 'male', 0, NULL, '2026-05-22 06:06:55', '2026-05-22 06:06:55');

-- --------------------------------------------------------

--
-- Table structure for table `customer_discount`
--

CREATE TABLE `customer_discount` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` bigint(20) UNSIGNED NOT NULL,
  `discount_id` bigint(20) UNSIGNED NOT NULL,
  `used_count` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `customer_discount`
--

INSERT INTO `customer_discount` (`id`, `customer_id`, `discount_id`, `used_count`, `created_at`, `updated_at`) VALUES
(2, 3, 1, 1, '2026-03-30 19:39:05', '2026-03-30 19:39:05'),
(3, 12, 1, 1, '2026-05-13 18:44:51', '2026-05-13 18:44:51');

-- --------------------------------------------------------

--
-- Table structure for table `discounts`
--

CREATE TABLE `discounts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `code` varchar(255) NOT NULL,
  `type` enum('percentage','fixed') NOT NULL,
  `value` decimal(8,2) NOT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `usage_limit` int(11) DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `discounts`
--

INSERT INTO `discounts` (`id`, `name`, `code`, `type`, `value`, `start_date`, `end_date`, `usage_limit`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Birthday Discount', 'MYBDAY2026', 'percentage', 10.00, '2026-01-01', '2026-12-31', 1, 'active', '2026-03-14 17:13:57', '2026-03-30 19:22:24', NULL),
(2, 'Valentines Discount', 'L0VEW1NS2026', 'percentage', 50.00, '2026-01-01', '2026-12-31', 1, 'active', '2026-03-21 03:22:02', '2026-05-15 01:47:24', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `job_role_id` bigint(20) UNSIGNED NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `personal_email` varchar(255) DEFAULT NULL,
  `birthdate` date DEFAULT NULL,
  `mobile_num` varchar(255) DEFAULT NULL,
  `gender` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `hire_date` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`id`, `user_id`, `job_role_id`, `first_name`, `last_name`, `personal_email`, `birthdate`, `mobile_num`, `gender`, `image`, `hire_date`, `created_at`, `updated_at`) VALUES
(1, 2, 1, 'Karylle Mish', 'Gellica', NULL, '2005-06-14', '09718412647', 'female', 'employees/IHf0LdKrtNwI4JBLZFui0hzR0VdfP5OirBK9YYed.jpg', '2025-07-14', '2026-03-14 05:26:47', '2026-04-22 22:33:51'),
(2, 3, 2, 'Bai Fatimaa', 'Andong', NULL, '2005-08-24', '09495659735', 'female', 'employees/lHe24hFTFYeJ4kpBqXX1f5BYmsuxWHxu5C64Bkhi.jpg', '2025-05-20', '2026-03-14 06:22:08', '2026-05-14 20:36:43'),
(3, 5, 3, 'Loren', 'Odiong', NULL, '2005-03-18', '09196347812', 'female', 'employees/sxu6zxuw564gRyAXSMTWvCtTMlMBDloVCdCHjuua.jpg', '2025-04-17', '2026-03-14 18:08:08', '2026-05-14 06:37:52'),
(4, 1, 4, 'Branch', 'Manager', NULL, NULL, NULL, NULL, NULL, '2026-03-22', '2026-03-22 08:30:50', '2026-03-22 08:30:50'),
(5, 12, 1, 'James', 'Cahilig', 'christianc.xviii@gmail.com', '2002-02-18', '09495655839', 'male', 'employees/H1WTKoFewJ1KrcHeSgCjRiVQoST87ovcDDDUyo1b.png', '2025-11-14', '2026-04-20 03:59:57', '2026-04-20 03:59:57'),
(6, 13, 2, 'Hanna', 'Bishi', 'hanna.ix02@gmail.com', '2007-02-09', '09716471241', 'female', NULL, '2026-01-15', '2026-04-20 16:40:51', '2026-05-09 17:22:38'),
(7, 14, 1, 'Nazlah', 'Nanding', 'hazeljoyhingpit@gmail.com', '2004-08-07', '09472934972', 'female', NULL, '2026-04-23', '2026-04-22 23:20:59', '2026-04-22 23:20:59'),
(9, 16, 3, 'Rena', 'Cahilig', 'r.cahilig.544799@umindanao.edu.ph', '2003-11-27', '09662469129', 'female', NULL, '2026-04-07', '2026-05-09 18:08:45', '2026-05-09 18:08:45'),
(10, 24, 2, 'Rene', 'Cahilig', 'rene.b.cahilig@gmail.com', '2005-07-28', '09495655839', 'male', NULL, '2026-05-14', '2026-05-13 19:04:29', '2026-05-13 19:04:29');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_roles`
--

CREATE TABLE `job_roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `job_roles`
--

INSERT INTO `job_roles` (`id`, `title`, `description`, `created_at`, `updated_at`) VALUES
(1, 'Hair Stylist', 'Specializes in haircuts and styling.', '2026-03-14 03:18:16', '2026-03-14 03:18:16'),
(2, 'Nail Technician', 'Provides manicure and pedicure services.', '2026-03-14 03:18:16', '2026-03-14 03:18:16'),
(3, 'Front Desk', 'Handles appointments and customer inquiries.', '2026-03-14 03:18:16', '2026-03-14 03:18:16'),
(4, 'Manager', 'Oversees salon operations.', '2026-03-14 03:18:16', '2026-03-14 03:18:16');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_03_14_073432_add_role_and_status_to_users_table', 2),
(5, '2026_03_14_073523_create_customers_table', 3),
(6, '2026_03_14_073617_create_job_roles_table', 3),
(7, '2026_03_14_073638_create_employees_table', 3),
(8, '2026_03_14_073656_create_services_table', 3),
(9, '2026_03_14_073730_create_discounts_table', 3),
(10, '2026_03_14_073801_create_appointments_table', 3),
(11, '2026_03_14_073817_create_appointment_service_table', 3),
(12, '2026_03_14_073836_create_payments_table', 3),
(13, '2026_03_14_073851_create_products_table', 3),
(14, '2026_03_15_020257_add_mobile_num_to_customers_table', 4),
(15, '2026_03_15_130242_add_soft_deletes_to_appointments_table', 4),
(16, '2026_03_15_132644_add_soft_deletes_to_services_table', 5),
(17, '2026_03_15_132645_add_soft_deletes_to_discounts_table', 5),
(18, '2026_03_15_132645_add_soft_deletes_to_products_table', 5),
(19, '2026_03_15_132930_remove_status_from_services_table', 5),
(20, '2026_03_15_132931_remove_status_from_discounts_table', 5),
(21, '2026_03_15_132931_remove_status_from_products_table', 5),
(22, '2026_03_16_045630_add_size_to_products_table', 6),
(23, '2026_03_16_062740_add_image_to_services_table', 7),
(24, '2026_03_16_073643_add_image_to_customers_table', 8),
(25, '2026_03_16_073643_add_image_to_employees_table', 8),
(26, '2026_03_21_111557_add_status_to_discounts_table', 9),
(27, '2026_03_30_145444_create_audit_logs_table', 10),
(28, '2026_03_31_001738_add_usage_tracking_to_discounts_table', 11),
(29, '2026_03_31_014025_create_customer_discount_table', 12),
(30, '2026_03_31_014217_add_per_customer_limit_to_discounts_table', 13),
(31, '2026_03_31_033718_remove_unused_columns_from_discounts_table', 14),
(32, '2026_03_31_041813_add_loyalty_discount_available_to_customers_table', 15),
(33, '2026_03_31_042352_add_loyalty_discount_applied_to_appointments_table', 16),
(34, '2026_04_20_083725_add_unique_to_mobile_num_in_customers', 17),
(35, '2026_04_20_103451_add_invitation_fields_to_users_table', 17),
(36, '2026_04_20_110923_add_personal_email_to_employees_table', 18),
(37, '2026_04_27_040655_create_product_service_table', 19),
(38, '2026_05_15_081403_add_cancellation_reason_to_appointments_table', 20);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `appointment_id` bigint(20) UNSIGNED NOT NULL,
  `amount` decimal(8,2) NOT NULL,
  `payment_method` enum('cash','gcash') NOT NULL,
  `reference_number` varchar(255) DEFAULT NULL,
  `validated_at` timestamp NULL DEFAULT NULL,
  `status` enum('pending','validated') NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`id`, `appointment_id`, `amount`, `payment_method`, `reference_number`, `validated_at`, `status`, `created_at`, `updated_at`) VALUES
(1, 6, 1200.00, 'gcash', 'DANNDAUD90AY31', '2026-04-13 18:47:41', 'validated', '2026-03-20 22:56:44', '2026-04-13 18:47:41'),
(2, 7, 899.10, 'gcash', '8ASF9YASFS', '2026-03-29 00:37:40', 'validated', '2026-03-28 22:47:50', '2026-03-30 19:32:47'),
(3, 3, 1299.00, 'gcash', 'NANFFASU9F32', '2026-04-13 19:11:43', 'validated', '2026-04-13 18:40:08', '2026-04-13 19:11:43'),
(4, 13, 1888.00, 'gcash', 'NDADFFA0F77', '2026-05-14 21:21:31', 'validated', '2026-05-11 03:58:31', '2026-05-14 21:21:31'),
(5, 16, 1200.00, 'gcash', 'aflansf920', '2026-05-13 19:18:48', 'validated', '2026-05-13 18:47:05', '2026-05-13 19:18:48'),
(6, 18, 99.00, 'gcash', '2848104818419', NULL, 'pending', '2026-05-13 19:34:15', '2026-05-13 22:17:15'),
(7, 20, 1888.00, 'gcash', '6193871274871', '2026-05-14 05:52:29', 'validated', '2026-05-13 21:32:35', '2026-05-14 05:52:29'),
(8, 23, 399.00, 'gcash', '1204802794871', NULL, 'pending', '2026-05-14 21:45:55', '2026-05-14 21:45:55'),
(9, 24, 99.00, 'gcash', '8249890573985', '2026-05-14 22:52:28', 'validated', '2026-05-14 22:28:23', '2026-05-14 22:52:28'),
(10, 31, 999.00, 'gcash', '2094021074907', NULL, 'pending', '2026-05-22 00:34:20', '2026-05-22 00:34:20'),
(11, 32, 750.00, 'gcash', '2534643673477', NULL, 'pending', '2026-05-22 00:35:31', '2026-05-22 00:35:31'),
(12, 33, 499.00, 'gcash', '3523523355325', '2026-05-22 05:34:30', 'validated', '2026-05-22 00:36:42', '2026-05-22 05:34:30'),
(13, 34, 1200.00, 'gcash', '3535253235352', NULL, 'pending', '2026-05-22 01:37:21', '2026-05-22 01:37:21'),
(14, 35, 1200.00, 'gcash', '3535636535235', NULL, 'pending', '2026-05-22 01:40:01', '2026-05-22 01:40:01'),
(15, 36, 300.00, 'gcash', '1289477219749', NULL, 'pending', '2026-05-22 05:24:53', '2026-05-22 05:24:53');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `category` varchar(255) NOT NULL,
  `size` varchar(255) DEFAULT NULL,
  `quantity` int(11) NOT NULL DEFAULT 0,
  `price` decimal(8,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `category`, `size`, `quantity`, `price`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Plastic Gloves', 'Others', '50pcs', 9, 25.00, '2026-03-14 17:12:47', '2026-05-22 05:55:59', NULL),
(2, 'Sunsilk Shampoo', 'Shampoo', '250ml', 15, 120.00, '2026-03-15 21:12:57', '2026-03-24 23:48:31', '2026-03-24 23:48:31'),
(3, 'Shampoo', 'Shampoo', '500ml', 19, 220.00, '2026-03-15 21:12:57', '2026-05-09 16:21:27', NULL),
(4, 'Conditioner', 'Conditioner', '250ml', 12, 130.00, '2026-03-15 21:12:57', '2026-03-15 21:12:57', NULL),
(5, 'Conditioner', 'Conditioner', '500ml', 15, 240.00, '2026-03-15 21:12:57', '2026-04-27 01:26:55', NULL),
(6, 'Hair Mask', 'Treatment Products', '200ml', 17, 350.00, '2026-03-15 21:12:57', '2026-04-27 01:27:08', NULL),
(7, 'Hair Oil', 'Treatment Products', '100ml', 10, 180.00, '2026-03-15 21:12:57', '2026-03-15 21:12:57', NULL),
(8, 'Permanent Hair Color', 'Hair Color', '60ml', 20, 250.00, '2026-03-15 21:12:57', '2026-03-15 21:12:57', NULL),
(9, 'Semi-Permanent Color', 'Hair Color', '60ml', 16, 220.00, '2026-03-15 21:12:57', '2026-05-14 23:37:27', NULL),
(10, 'Hair Dryer', 'Styling Tools', '1800W', 13, 1500.00, '2026-03-15 21:12:57', '2026-04-13 19:48:12', NULL),
(11, 'Flat Iron', 'Styling Tools', '1 inch', 14, 1200.00, '2026-03-15 21:12:57', '2026-04-27 01:27:24', NULL),
(12, 'Curling Wand', 'Styling Tools', '25mm', 12, 1300.00, '2026-03-15 21:12:57', '2026-04-27 01:27:34', NULL),
(13, 'Nail Polish - Red', 'Nail Products', '15ml', 25, 80.00, '2026-03-15 21:12:57', '2026-03-15 21:12:57', NULL),
(14, 'Nail Polish - Pink', 'Nail Products', '15ml', 22, 80.00, '2026-03-15 21:12:57', '2026-03-15 21:12:57', NULL),
(15, 'Base Coat', 'Nail Products', '15ml', 10, 90.00, '2026-03-15 21:12:57', '2026-03-15 21:12:57', NULL),
(16, 'Top Coat', 'Nail Products', '15ml', 19, 90.00, '2026-03-15 21:12:57', '2026-04-27 01:27:44', NULL),
(17, 'Nail Polish Remover', 'Nail Products', '250ml', 6, 120.00, '2026-03-15 21:12:57', '2026-03-15 21:12:57', NULL),
(18, 'Plastic Comb', 'Others', 'Set of 4', 20, 150.00, '2026-03-15 21:12:57', '2026-03-15 21:12:57', NULL),
(19, 'Hair Clips', 'Others', 'Set of 6', 30, 60.00, '2026-03-15 21:12:57', '2026-03-15 21:12:57', NULL),
(20, 'Apron', 'Others', 'One size', 5, 250.00, '2026-03-15 21:12:57', '2026-03-15 21:12:57', NULL),
(21, 'Holographic Top Coat', 'Nail Products', '20ml', 15, 185.00, '2026-03-15 22:09:13', '2026-04-13 19:48:28', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `product_service`
--

CREATE TABLE `product_service` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `service_id` bigint(20) UNSIGNED NOT NULL,
  `quantity_used` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_service`
--

INSERT INTO `product_service` (`id`, `product_id`, `service_id`, `quantity_used`, `created_at`, `updated_at`) VALUES
(9, 9, 2, 1, '2026-04-26 23:36:10', '2026-04-26 23:36:10'),
(10, 1, 2, 1, '2026-04-26 23:36:16', '2026-04-26 23:36:16'),
(15, 18, 5, 1, '2026-05-10 02:24:06', '2026-05-10 02:24:06'),
(16, 1, 1, 1, '2026-05-13 17:56:25', '2026-05-13 19:14:47');

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(8,2) NOT NULL,
  `duration` int(11) NOT NULL,
  `category` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`id`, `name`, `description`, `price`, `duration`, `category`, `image`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Haircut', 'Classic haircut tailored to your style.', 300.00, 30, 'Haircut', 'services/F8NPskS13zF9TFNdwv9ld8PFdtnK0JkYMcfY8d3P.jpg', '2026-03-14 02:57:47', '2026-05-13 19:13:25', NULL),
(2, 'Full Hair Color', 'Full hair color with premium dyes.', 1200.00, 90, 'Hair Color', 'services/iaimqPSJFaCl4u7laxbElS4ey7dFPC8RPRpSNsbz.jpg', '2026-03-14 02:57:47', '2026-03-21 06:04:21', NULL),
(3, 'Manicure', 'Basic nail shaping and polish.', 199.00, 45, 'Manicure', 'services/39KOLKU5skKqILLZh6TnZW7gEu0d7mI8UgpbD0tT.jpg', '2026-03-14 02:57:47', '2026-03-21 06:04:33', NULL),
(4, 'Balayage', 'Hand-painted highlights for a natural, sun-kissed look. Includes toner and gloss.', 550.00, 120, 'Hair Color', 'services/mOAEGKPHyiaaGSmJBBtg2f8JHjX7tSn75RmGIzp0.jpg', '2026-03-14 05:24:37', '2026-03-25 00:06:30', '2026-03-25 00:06:30'),
(5, 'Mid Fade', 'A clean, versatile haircut where the fade starts midway between the temples and ears, blending smoothly for a sharp yet balanced look.', 99.00, 30, 'Haircut', 'services/wzb2AFt4B12dsGtxtBsm6yKw5OI1yukQYMYW0Pvy.jpg', '2026-03-15 22:32:02', '2026-05-10 02:24:27', NULL),
(6, 'Birkin Bangs', 'Trendy curtain bangs that frame the face beautifully. Perfect for a fresh new look.', 99.00, 45, 'Haircut', 'services/xdoPnP9DKGbylblzL3OXfXQ4jTEqXLQnxowamep8.png', '2026-03-15 22:32:02', '2026-03-21 18:07:31', NULL),
(7, 'Balayage', 'Hand-painted highlights for a natural, sun-kissed look. Includes toner and gloss.', 1500.00, 120, 'Hair Color', 'services/YX8yLkIPAvQgXDlV3V8QFdCsYdVprrP89aXEFPh2.jpg', '2026-03-15 22:32:02', '2026-03-21 18:07:39', NULL),
(8, 'Ghost Roots', 'Root touch-up with a subtle shadow root effect. Perfect for low-maintenance color.', 1299.00, 90, 'Hair Color', 'services/FgcUK5DmGLE6a9E6h36U1GJi2H1TIyXU8olp42nc.jpg', '2026-03-15 22:32:02', '2026-03-21 18:07:50', NULL),
(9, 'Protein Treatment', 'Deep conditioning treatment to strengthen and repair damaged hair.', 999.00, 60, 'Treatment', 'services/LXhDWiWNrGUIzlxHcfbvaP5F4WiuvePzdETq71C6.jpg', '2026-03-15 22:32:02', '2026-03-21 18:07:59', NULL),
(10, 'Scalp Treatment', 'Soothing treatment for dry or itchy scalp. Promotes healthy hair growth.', 999.00, 60, 'Treatment', 'services/ATHiOM4qgRJmHuDN21HWMWKpEXTS7TVeU3Msmqlf.jpg', '2026-03-15 22:32:02', '2026-03-21 18:08:09', NULL),
(11, 'Long Rebonding', 'Chemical straightening for long hair. Leaves hair sleek and manageable.', 1999.00, 180, 'Rebonding', 'services/HRyuJV6qcupGOS0CybvE81PVwQOkxCYZz2hbAizj.jpg', '2026-03-15 22:32:02', '2026-03-21 18:08:17', NULL),
(12, 'Short Rebonding', 'Chemical straightening for short hair. Smooth and straight results.', 1888.00, 150, 'Rebonding', 'services/WAy6JPWOZ1Dz4sYThXg9rcXBCOhtPNc9pwixHDFf.jpg', '2026-03-15 22:32:02', '2026-05-10 02:23:40', NULL),
(13, '3D Gel Polish', 'Long-lasting gel polish with a 3D effect. Includes nail art options.', 499.00, 60, 'Gel Polish', 'services/LVRiS7ddSwrydXGwcDoPzhw0bZm17eOeB616pQLQ.jpg', '2026-03-15 22:32:02', '2026-03-21 18:10:47', NULL),
(14, 'Metallic Gel Polish', 'Shiny metallic gel polish that lasts for weeks. Available in various shades.', 399.00, 60, 'Gel Polish', 'services/OXDC7aV0jdmprIsLFKvqP6VRPmFb1nz5koY3Wd0U.jpg', '2026-03-15 22:32:02', '2026-03-21 18:10:59', NULL),
(15, 'Acrylic Nail', NULL, 750.00, 65, 'Manicure', 'services/LpjYofD2gVdNWbaRycoQ4Dgf9f2H46PdFufI6nbN.jpg', '2026-03-15 22:37:31', '2026-03-21 18:11:13', NULL),
(16, 'Hair Color', 'jasuduayuh', 700.00, 60, 'Treatment', NULL, '2026-05-13 19:12:17', '2026-05-13 19:12:17', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('GdAo4sIjQHx5ujOExGCNWKbTAuIWQUVubh4S1AnU', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiZ0g0NDF6N0UwcTlRQVF6aVdxZmV2OFVacHlxajBOa1ppVXVyb1dqUiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mzc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi9jdXN0b21lcnMiO3M6NToicm91dGUiO3M6MjE6ImFkbWluLmN1c3RvbWVycy5pbmRleCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7fQ==', 1780793754),
('VLvdBq77ttytNKkEF9zZSn5OfPW91QgUpSCcor3E', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiNENldzRucUY2bExXS3BxYWt2RVQzVG53d1NFeko2Uk0yMHhrWEUxNyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NDA6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi9jdXN0b21lcnMvMTMiO3M6NToicm91dGUiO3M6MjA6ImFkbWluLmN1c3RvbWVycy5zaG93Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTt9', 1780712613);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL DEFAULT 'customer',
  `status` varchar(255) NOT NULL DEFAULT 'active',
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `invitation_token` varchar(255) DEFAULT NULL,
  `invitation_sent_at` timestamp NULL DEFAULT NULL,
  `invitation_accepted_at` timestamp NULL DEFAULT NULL,
  `invitation_expires_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `role`, `status`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `invitation_token`, `invitation_sent_at`, `invitation_accepted_at`, `invitation_expires_at`) VALUES
(1, 'Admin', 'bmanager@gmail.com', 'manager', 'active', NULL, '$2y$12$qI1/vGNWN3vDm80LQ6QxMePjo5rUYJTcuBlP1nUybOlAya.dU795W', NULL, '2026-03-14 02:28:17', '2026-03-30 15:19:16', NULL, NULL, '2026-03-20 04:01:15', NULL),
(2, 'Karylle Mish Gellica', 'kmgellica@gmail.com', 'tech', 'active', NULL, '$2y$12$G6A7zQBAbcr0ak2CNjJw7.k1TxtgNSdp9koqncaOra3DRWdit5QKa', NULL, '2026-03-14 05:26:47', '2026-04-22 22:33:51', NULL, NULL, '2026-03-20 04:01:15', NULL),
(3, 'Bai Fatima Andong', 'bfandong@gmail.com', 'tech', 'active', NULL, '$2y$12$zeAvfua..LaTnvt.BCarIufnNdWIOdhnqHmeutGAiYtTXrb5A.VmK', 'zqhtCoh4AKDeYjWsFUDBp7PUxMa1qgLZ6LpARlgIt3JTJjaGkT9REtNHm8Hu', '2026-03-14 06:22:08', '2026-03-14 06:22:08', NULL, NULL, '2026-03-20 04:01:15', NULL),
(4, 'Sabrina Rina Carpenter', 'scarpenter@gmail.com', 'customer', 'active', NULL, '$2y$12$HcMPN7V3a5/grgHUQ2xANejbsVAGbzXlL8cUXu5juhmbCIULoDVMS', NULL, '2026-03-14 18:04:06', '2026-03-30 15:18:07', NULL, NULL, '2026-03-20 04:01:15', NULL),
(5, 'Loren Odiong', 'jlodiong@gmail.com', 'frontdesk', 'active', NULL, '$2y$12$Oej1yjfBUpmiAi3mIJRSuuWdxFjsdlKolEza4JYVp34NGEHQlYBve', NULL, '2026-03-14 18:08:08', '2026-04-20 02:49:54', NULL, NULL, '2026-03-20 04:01:15', NULL),
(6, 'John Llorie Sarmiento', 'jlsarmiento@gmail.com', 'customer', 'active', NULL, '$2y$12$4gokYu4SHx5XGIr73gFEyeBsucaDrIfVn3E0LAirWcgu8FnGAFzR6', NULL, '2026-03-20 17:12:25', '2026-05-14 21:28:21', NULL, NULL, '2026-03-20 04:01:15', NULL),
(7, 'Hazeljoy Hingpit', 'hjhingpit@gmail.com', 'customer', 'active', NULL, '$2y$12$tgvHEcOmn6iHHcifsA0QNOVNZE2YoiRLAE603/r8JBUW/DEMy0PqO', NULL, '2026-03-20 22:56:44', '2026-03-30 05:22:23', NULL, NULL, '2026-03-20 04:01:15', NULL),
(8, 'Christian Cahilig', 'christianc@gmail.com', 'customer', 'active', NULL, '$2y$12$cxk1eQLczkk1NtEHfTav2eTVfqp7WOtqfVajdDYlo4X/orEQxY6PC', 'KClwwv2deSTptzkp7yOgPVuePM170ndAizwefGrvAYk7CkvtW0s7DrGWWUa6', '2026-04-03 15:33:20', '2026-05-14 22:47:45', NULL, NULL, '2026-03-20 04:01:15', NULL),
(9, 'Annika Dumalogdog', 'adumalogdog@gmail.com', 'customer', 'active', NULL, '$2y$12$bGSzjJfhd/3aEEZSGCuPZ.AQ4D7GAjTgxt6udF2m4tN3W6CW4a6YC', NULL, '2026-04-20 01:17:03', '2026-05-09 18:27:52', NULL, NULL, '2026-03-20 04:01:15', NULL),
(12, 'James Cahilig', 'cjcahilig@gmail.com', 'tech', 'active', NULL, '$2y$12$feJUKbXr.u0iy.iE2cnolO9jLidc8LdqPoaFbraYVCIjMck9LnC8u', NULL, '2026-04-20 03:59:57', '2026-04-20 04:01:15', NULL, '2026-04-20 03:59:57', '2026-04-20 04:01:15', '2026-04-27 03:59:57'),
(13, 'Hanna Bishi', 'rbishi@gmail.com', 'tech', 'active', NULL, '$2y$12$3hzbXOSxyHZ/Sv5Xv0Y6m.F4TNtYLwIRRzAYI0k9ChmDbTj3pksRq', NULL, '2026-04-20 16:40:51', '2026-05-09 18:27:20', NULL, '2026-04-20 16:40:51', '2026-04-20 16:42:55', '2026-04-27 16:40:51'),
(14, 'Nazlah Nanding', 'nnanding@gmail.com', 'tech', 'invited', NULL, '$2y$12$KY33zEUcW/RYLXYK386VFOFrIHb1I8Fi391LNVO0G8p5QiiDQpahi', NULL, '2026-04-22 23:20:59', '2026-05-09 18:24:06', 'KQ55lGUHv3UmvjGKxP1nyF9a8w0HrQl9AS3dwavhOoHjT7dasX6K6uIFvwzKRmSP', '2026-05-09 18:24:06', NULL, '2026-05-16 18:24:06'),
(16, 'Rena Cahilig', 'rcahilig@gmail.com', 'frontdesk', 'inactive', NULL, '$2y$12$Ws00OqDQJaIi1BAFndXUWuakpgoROi4ob1ZrnL68Tfemqu4Kf7LnS', NULL, '2026-05-09 18:08:45', '2026-05-13 19:07:34', NULL, '2026-05-13 19:06:33', NULL, '2026-05-20 19:06:33'),
(17, 'Glinda Guding', 'gguding@gmail.com', 'customer', 'active', NULL, '$2y$12$7E6fdMHIU9RfgivOo6yV2.Zm74s.Tiv6YpbT4tzC/AcdpmZGBnZE.', NULL, '2026-05-09 18:52:17', '2026-05-09 18:52:17', NULL, NULL, NULL, NULL),
(19, 'Spencer Agnew', 'sagnew@gmail.com', 'customer', 'active', NULL, '$2y$12$AaKZ.xvn7bIUPl9Ziu/2meMC6h6YnUVfpoa2cVfXHchTIR72cZ4ae', NULL, '2026-05-11 03:58:31', '2026-05-11 03:58:31', NULL, NULL, NULL, NULL),
(20, 'Elphaba Bading', 'ebading@gmail.com', 'customer', 'active', NULL, '$2y$12$QYIc38BBc69GvWQ2/L.cdOQLf7.Elyx8PYtOK4MVFr4L090phcVMe', NULL, '2026-05-12 21:57:52', '2026-05-12 21:57:52', NULL, NULL, NULL, NULL),
(21, 'Dakota Fanning', 'dfanning@gmail.com', 'customer', 'active', NULL, '$2y$12$NRPpsJQSFJ6rSB2wd1jg5u9SovmNB0rPv9Rc5nLXKeebqvrmyhKLy', NULL, '2026-05-13 18:07:16', '2026-05-14 20:27:52', NULL, NULL, NULL, NULL),
(22, 'Jane Doe', 'jane@gmail.com', 'customer', 'active', NULL, '$2y$12$MjaQnj7wdbifY6lFiXdqJe9GylYx9QxgkzOJtBjmS.GtXBVUib49e', NULL, '2026-05-13 18:44:51', '2026-05-13 18:44:51', NULL, NULL, NULL, NULL),
(23, 'Elle Fanning', 'ellefanning@gmail.com', 'customer', 'active', NULL, '$2y$12$Izzk78nN11FjGROR.AVKY.JOA/dHa5o3TQ7Qc.PJhI9ae3w1ncUyO', NULL, '2026-05-13 18:56:19', '2026-05-14 20:31:25', NULL, NULL, NULL, NULL),
(24, 'Rene Cahilig', 'renecahilig@gmail.com', 'tech', 'inactive', NULL, '$2y$12$tDOIDKBI6jILqA9aiUKu.eFdzF.WjHhDoCAvS1P.ekNNcyUKe/SiC', NULL, '2026-05-13 19:04:29', '2026-05-13 19:09:49', NULL, '2026-05-13 19:04:29', '2026-05-13 19:05:31', '2026-05-20 19:04:29'),
(25, 'Jonathan Byers', 'jbyers@gmail.com', 'customer', 'active', NULL, '$2y$12$6AwSNMM4wFuGT1IDwCRi4OXN8Jd1zV1LV6UwWQFnz/S5Mwe1Jvnmy', NULL, '2026-05-22 05:32:15', '2026-05-22 05:32:15', NULL, NULL, NULL, NULL),
(26, 'Max Mayfield', 'mmayfield@gmail.com', 'customer', 'active', NULL, '$2y$12$RiA0YzpXcfQ8mc/z9JSpU.koqazZMzx4kvBhNIpxjQruz3WQZW/cS', NULL, '2026-05-22 05:47:51', '2026-05-22 06:10:02', NULL, NULL, NULL, NULL),
(27, 'Mike Wheeler', 'mwheeler@gmail.com', 'customer', 'active', NULL, '$2y$12$WOJCKnmq.VyhvMCwiwdhCOou1O4F92wEr8kIAoo3f.fMAYIdqLXeO', NULL, '2026-05-22 06:06:55', '2026-05-22 06:09:38', NULL, NULL, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `appointments`
--
ALTER TABLE `appointments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `appointments_customer_id_foreign` (`customer_id`),
  ADD KEY `appointments_employee_id_foreign` (`employee_id`),
  ADD KEY `appointments_discount_id_foreign` (`discount_id`);

--
-- Indexes for table `appointment_service`
--
ALTER TABLE `appointment_service`
  ADD PRIMARY KEY (`id`),
  ADD KEY `appointment_service_appointment_id_foreign` (`appointment_id`),
  ADD KEY `appointment_service_service_id_foreign` (`service_id`);

--
-- Indexes for table `audit_logs`
--
ALTER TABLE `audit_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `audit_logs_user_id_index` (`user_id`),
  ADD KEY `audit_logs_action_index` (`action`),
  ADD KEY `audit_logs_model_type_model_id_index` (`model_type`,`model_id`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `customers_mobile_num_unique` (`mobile_num`),
  ADD KEY `customers_user_id_foreign` (`user_id`);

--
-- Indexes for table `customer_discount`
--
ALTER TABLE `customer_discount`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `customer_discount_customer_id_discount_id_unique` (`customer_id`,`discount_id`),
  ADD KEY `customer_discount_discount_id_foreign` (`discount_id`);

--
-- Indexes for table `discounts`
--
ALTER TABLE `discounts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `discounts_code_unique` (`code`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`id`),
  ADD KEY `employees_user_id_foreign` (`user_id`),
  ADD KEY `employees_job_role_id_foreign` (`job_role_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_reserved_at_available_at_index` (`queue`,`reserved_at`,`available_at`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `job_roles`
--
ALTER TABLE `job_roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `payments_appointment_id_foreign` (`appointment_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_service`
--
ALTER TABLE `product_service`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `product_service_product_id_service_id_unique` (`product_id`,`service_id`),
  ADD KEY `product_service_service_id_foreign` (`service_id`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `users_invitation_token_unique` (`invitation_token`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `appointments`
--
ALTER TABLE `appointments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `appointment_service`
--
ALTER TABLE `appointment_service`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `audit_logs`
--
ALTER TABLE `audit_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=513;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `customer_discount`
--
ALTER TABLE `customer_discount`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `discounts`
--
ALTER TABLE `discounts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `job_roles`
--
ALTER TABLE `job_roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `product_service`
--
ALTER TABLE `product_service`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `appointments`
--
ALTER TABLE `appointments`
  ADD CONSTRAINT `appointments_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`),
  ADD CONSTRAINT `appointments_discount_id_foreign` FOREIGN KEY (`discount_id`) REFERENCES `discounts` (`id`),
  ADD CONSTRAINT `appointments_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`);

--
-- Constraints for table `appointment_service`
--
ALTER TABLE `appointment_service`
  ADD CONSTRAINT `appointment_service_appointment_id_foreign` FOREIGN KEY (`appointment_id`) REFERENCES `appointments` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `appointment_service_service_id_foreign` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `customers`
--
ALTER TABLE `customers`
  ADD CONSTRAINT `customers_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `customer_discount`
--
ALTER TABLE `customer_discount`
  ADD CONSTRAINT `customer_discount_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `customer_discount_discount_id_foreign` FOREIGN KEY (`discount_id`) REFERENCES `discounts` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `employees`
--
ALTER TABLE `employees`
  ADD CONSTRAINT `employees_job_role_id_foreign` FOREIGN KEY (`job_role_id`) REFERENCES `job_roles` (`id`),
  ADD CONSTRAINT `employees_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_appointment_id_foreign` FOREIGN KEY (`appointment_id`) REFERENCES `appointments` (`id`);

--
-- Constraints for table `product_service`
--
ALTER TABLE `product_service`
  ADD CONSTRAINT `product_service_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `product_service_service_id_foreign` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
