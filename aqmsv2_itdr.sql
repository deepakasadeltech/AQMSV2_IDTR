-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 06, 2019 at 10:56 AM
-- Server version: 10.1.21-MariaDB
-- PHP Version: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `aqmsv2_itdr`
--

-- --------------------------------------------------------

--
-- Table structure for table `calls`
--

CREATE TABLE `calls` (
  `id` int(10) UNSIGNED NOT NULL,
  `queue_id` int(10) UNSIGNED NOT NULL,
  `department_id` int(10) UNSIGNED NOT NULL,
  `counter_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `number` varchar(11) COLLATE utf8_unicode_ci DEFAULT NULL,
  `nt_number` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `barcode` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `timeslot` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'A=10:20, B=11:20, C=12:20, D=13:20:',
  `checkingCounter` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Court Work=R, Pay fine=P',
  `newbarcode` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `token` varchar(2) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'new=N, old=O',
  `priority` int(6) DEFAULT '4' COMMENT '1=platinum,2=Gold,3=Silver,4=Normal',
  `view_status` tinyint(1) NOT NULL DEFAULT '0',
  `called_date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `pid` int(11) NOT NULL,
  `doctor_work_start` int(11) DEFAULT '0',
  `doctor_work_start_date` datetime DEFAULT NULL,
  `doctor_work_end` int(11) DEFAULT '0',
  `doctor_work_end_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `calls`
--

INSERT INTO `calls` (`id`, `queue_id`, `department_id`, `counter_id`, `user_id`, `number`, `nt_number`, `barcode`, `timeslot`, `checkingCounter`, `newbarcode`, `token`, `priority`, `view_status`, `called_date`, `created_at`, `updated_at`, `pid`, `doctor_work_start`, `doctor_work_start_date`, `doctor_work_end`, `doctor_work_end_date`) VALUES
(1, 1, 1, 1, 60, '2000', NULL, '2000_06-2019', NULL, NULL, NULL, 'O', 1, 3, '2019-06-01', '2019-06-01 14:08:53', '2019-06-01 14:09:03', 1, 1, '2019-06-01 19:39:00', 1, '2019-06-01 19:39:03'),
(2, 1, 1, 2, 66, NULL, '2000N2000', NULL, '10:20 AM', 'P', 'N2000_06-2019', 'N', 1, 0, '2019-06-01', '2019-06-01 14:15:00', '2019-06-01 14:15:00', 1, 0, NULL, 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `counters`
--

CREATE TABLE `counters` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `display_sequence` int(10) DEFAULT NULL,
  `pid` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `department_id` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `counters`
--

INSERT INTO `counters` (`id`, `name`, `display_sequence`, `pid`, `department_id`, `created_at`, `updated_at`) VALUES
(1, 'IDTR Counter', 1, '1', '1', '2019-05-24 06:29:40', '2019-05-28 10:12:39'),
(2, 'Token Scanner', 2, '1', '1', '2019-05-25 11:40:58', '2019-05-28 07:20:43'),
(3, 'Court Work', 3, '1', '1', '2019-05-27 05:40:25', '2019-05-27 07:15:11'),
(4, 'Pay Fine', 4, '1', '1', '2019-05-27 07:15:43', '2019-05-27 07:15:43');

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `letter` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `start` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `pid` int(11) NOT NULL,
  `is_uhid_required` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`id`, `name`, `letter`, `start`, `created_at`, `updated_at`, `pid`, `is_uhid_required`) VALUES
(1, 'IDTR Token', '', 2000, '2019-05-24 06:29:01', '2019-05-30 09:29:16', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `doctor_reports`
--

CREATE TABLE `doctor_reports` (
  `id` int(10) UNSIGNED NOT NULL,
  `call_id` int(11) NOT NULL,
  `department_id` int(11) NOT NULL,
  `pid` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `token_number` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `new_token_number` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `barcode` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `newbarcode` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `checkingCounter` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Court Work=R, Pay fine=P',
  `token` varchar(2) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'new=N, old=O',
  `start_time` datetime DEFAULT NULL,
  `end_time` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `doctor_reports`
--

INSERT INTO `doctor_reports` (`id`, `call_id`, `department_id`, `pid`, `user_id`, `token_number`, `new_token_number`, `barcode`, `newbarcode`, `checkingCounter`, `token`, `start_time`, `end_time`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, 60, '2000', NULL, NULL, NULL, NULL, 'O', '2019-06-01 19:39:00', '2019-06-01 19:39:03', '2019-06-01 14:09:03', '2019-06-01 14:09:03');

-- --------------------------------------------------------

--
-- Table structure for table `languages`
--

CREATE TABLE `languages` (
  `id` int(10) UNSIGNED NOT NULL,
  `code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `display` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `languages`
--

INSERT INTO `languages` (`id`, `code`, `name`, `display`, `image`, `created_at`, `updated_at`) VALUES
(1, 'gb', 'English', 'Google UK English Female', 'United-Kingdom.png', '2019-01-22 03:43:45', '2019-01-22 03:43:45'),
(2, 'tr', 'Turkish', 'Turkish Female', 'Turkey.png', '2019-01-22 03:43:45', '2019-01-22 03:43:45'),
(3, 'de', 'German', 'Deutsch Female', 'Germany.png', '2019-01-22 03:43:45', '2019-01-22 03:43:45'),
(4, 'es', 'Spanish', 'Spanish Female', 'Spain.png', '2019-01-22 03:43:45', '2019-01-22 03:43:45'),
(5, 'fr', 'French', 'French Female', 'France.png', '2019-01-22 03:43:45', '2019-01-22 03:43:45'),
(6, 'in', 'Hindi', 'Google हिन्दी', 'India.png', '2019-01-22 03:43:45', '2019-01-22 03:43:45'),
(7, 'it', 'Italian', 'Italian Female', 'Italy.png', '2019-01-22 03:43:45', '2019-01-22 03:43:45'),
(8, 'pt', 'Portuguese', 'Portuguese Female', 'Portugal.png', '2019-01-22 03:43:45', '2019-01-22 03:43:45'),
(9, 'ru', 'Russian', 'Russian Female', 'Russia.png', '2019-01-22 03:43:46', '2019-01-22 03:43:46'),
(10, 'sa', 'Arabic', 'Arabic Male', 'Saudi-Arabia.png', '2019-01-22 03:43:46', '2019-01-22 03:43:46'),
(11, 'sk', 'Slovak', 'Slovak Female', 'Slovakia.png', '2019-01-22 03:43:46', '2019-01-22 03:43:46'),
(12, 'th', 'Thai', 'Thai Female', 'Thailand.png', '2019-01-22 03:43:46', '2019-01-22 03:43:46'),
(13, 'id', 'Indonesian', 'Indonesian Female', 'Indonesia.png', '2019-01-22 03:43:46', '2019-01-22 03:43:46');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2016_07_16_161740_create_departments_table', 1),
(4, '2016_07_16_180929_create_counters_table', 1),
(5, '2016_07_16_190715_create_queues_table', 1),
(6, '2016_07_19_170334_create_calls_table', 1),
(7, '2016_08_24_231859_create_languages_table', 1),
(8, '2016_09_28_123908_create_settings_table', 1),
(10, '2019_01_25_111036_create_parent_departments_table', 2),
(12, '2019_01_25_164519_add_pid_to_departments', 3),
(13, '2019_01_25_210736_add_pid_to_calls', 4),
(14, '2019_01_25_222612_add_pid_to_queues', 5),
(15, '2019_01_25_224152_add_uhid_to_queues', 6),
(16, '2019_01_25_224359_add_priority_to_queues', 6),
(17, '2019_01_26_052008_add_is_uhid_required_to_departments', 7),
(18, '2019_01_26_055620_create_uhid_masters_table', 8),
(19, '2019_01_27_144115_create_doctor_reports_table', 9),
(20, '2019_01_29_152923_add_counter_id_to_users_table', 10);

-- --------------------------------------------------------

--
-- Table structure for table `parent_departments`
--

CREATE TABLE `parent_departments` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `parent_departments`
--

INSERT INTO `parent_departments` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'IDTR Token', '2019-05-24 06:28:03', '2019-05-28 07:55:21');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `password_resets`
--

INSERT INTO `password_resets` (`email`, `token`, `created_at`) VALUES
('anujmishra.it@gmail.com', 'fe6c1fc8e98981f46a24c5e4125042697a0434b66ea00b797fc6b874d5929dc8', '2019-01-24 14:22:22'),
('anujmishra.it@gmail.com', 'fe6c1fc8e98981f46a24c5e4125042697a0434b66ea00b797fc6b874d5929dc8', '2019-01-24 14:22:22'),
('deepak@asadeltech.com', '318ccdd174e798bf252f0c67aeafc7af8ce14f109549a47f128d5f48556c0b83', '2019-05-21 07:15:23');

-- --------------------------------------------------------

--
-- Table structure for table `patientcalls`
--

CREATE TABLE `patientcalls` (
  `id` int(10) NOT NULL,
  `user_id` int(10) NOT NULL,
  `token_number` varchar(20) NOT NULL,
  `room_number` varchar(20) NOT NULL,
  `patient_status` int(5) DEFAULT '0',
  `created_at` datetime(6) NOT NULL,
  `updated_at` datetime(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `queues`
--

CREATE TABLE `queues` (
  `id` int(10) UNSIGNED NOT NULL,
  `department_id` int(10) UNSIGNED NOT NULL,
  `number` varchar(11) COLLATE utf8_unicode_ci NOT NULL,
  `nt_number` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `barcode` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `timeslot` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'A=10:20, B=11:20, C=12:20, D=13:20:',
  `checkingCounter` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Court Work=R, Pay fine=P',
  `newbarcode` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `new_waiting` int(10) DEFAULT NULL,
  `called` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `pid` int(11) NOT NULL,
  `uhid` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `priority` int(11) NOT NULL DEFAULT '4' COMMENT '1=platinum,2=Gold,3=Silver,4=Normal',
  `customer_waiting` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `queue_status` int(5) NOT NULL DEFAULT '1',
  `token` varchar(2) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'new=N, old=O'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `queues`
--

INSERT INTO `queues` (`id`, `department_id`, `number`, `nt_number`, `barcode`, `timeslot`, `checkingCounter`, `newbarcode`, `new_waiting`, `called`, `created_at`, `updated_at`, `pid`, `uhid`, `priority`, `customer_waiting`, `queue_status`, `token`) VALUES
(1, 1, '2000', '2000N2000', '2000_06-2019', '10:20 AM', 'P', 'N2000_06-2019', 0, 1, '2019-06-01 14:07:06', '2019-06-01 14:15:00', 1, '123', 1, '0', 1, 'N');

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(10) UNSIGNED NOT NULL,
  `language_id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `bus_no` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `address` text COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `location` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `notification` text COLLATE utf8_unicode_ci NOT NULL,
  `size` int(11) NOT NULL,
  `color` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `logo` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `over_time` int(11) NOT NULL,
  `missed_time` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `language_id`, `name`, `bus_no`, `address`, `email`, `phone`, `location`, `notification`, `size`, `color`, `logo`, `over_time`, `missed_time`, `created_at`, `updated_at`) VALUES
(1, 6, 'IDTR, DELHI', '', '', 'info@idtr.com', '', '', 'Welcome To INSTITUTE OF DRIVING & TRAFFIC RESEARCH:: ड्राइविंग और यातायात अनुसंधान के संस्थान में आपका स्वागत है।', 30, '#f7184e', '', 30, 30, '2019-01-22 03:43:46', '2019-05-28 07:36:09');

-- --------------------------------------------------------

--
-- Table structure for table `uhid_masters`
--

CREATE TABLE `uhid_masters` (
  `id` int(10) UNSIGNED NOT NULL,
  `uhid` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `uid` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `priority_type` int(6) NOT NULL DEFAULT '5' COMMENT '1=platinum,2=Gold,3=Silver,4=Normal',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `uhid_masters`
--

INSERT INTO `uhid_masters` (`id`, `uhid`, `uid`, `priority_type`, `created_at`, `updated_at`) VALUES
(1, '123', '48789541254785', 1, '2019-01-26 13:59:18', '2019-01-26 13:59:24'),
(2, '456', '9876789', 2, '2019-01-26 14:00:04', '2019-01-26 14:00:04'),
(3, '789', '48789541254785', 3, NULL, NULL),
(4, '500', '48789541254785', 4, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `role` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `pid` int(11) DEFAULT NULL,
  `department_id` int(11) DEFAULT NULL,
  `counter_id` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `user_status` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `email`, `role`, `pid`, `department_id`, `counter_id`, `password`, `user_status`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'admin', 'your_email@rxample.com', 'A', NULL, NULL, NULL, '$2y$10$ChrwtsItXpqh1MXNGnBiu.5Nm7XZEYXWLgWrt3eRVZ.i5pY8R2lJq', '1', 'a78bHgWqVQDK25h01W0gucOOdlvFX4c2uqPuKgjT4xXf8rBbIKXdugeIlS2t', '2019-01-22 03:43:45', '2019-05-31 07:02:35'),
(60, 'Deepak', 'deepak', 'deepak@asadeltech.com', 'D', 1, 1, '1', '$2y$10$nGllNBoiJJmiL4gkLDLC.e0umz.76dUqD/XIAPnXyOzFxzw/w8c2m', '1', 'sXuX94yo80gO5GR5FB4ubLj7VsSe5LbjVpY0xiAYz90DtBrDcIbGXu2awEQE', '2019-05-24 06:30:53', '2019-06-01 14:09:08'),
(61, 'Token Generator', 'generator', 'generator@gmail.com', 'U', NULL, NULL, NULL, '$2y$10$d.pxNzHcx3bLQHQAdB0mS.6KQs1REVjzRg.Biauqick.bFZow53Fe', '1', 'tMPmh3BLeGRjOXiiWU7kv3RtqGf3CdjY1d5AEjD0QkPO1ZpuggNHQDY9PIIs', '2019-05-24 08:03:39', '2019-06-01 14:14:34'),
(66, 'Token Scanner', 'scanner', 'scanner@gmail.com', 'T', 1, 1, '2', '$2y$10$jB9iuxSAEgZZTjtMLTaB4eLHeZkvZVKaNKG083oiOb4dwpSXJ5mEu', '1', 'JNKlGG4KgRWmVJ8qJ4YufJv0tBs4aJa30dhQNssF1AcQB6IYnJWffvc7FvqJ', '2019-05-25 16:24:36', '2019-06-01 13:28:36'),
(67, 'Display', 'displayurl', 'display@gmail.com', 'I', NULL, NULL, NULL, '$2y$10$qkqr5Y1Y8uM.2fXRFMxc9elEqYo4b4/ks61jA03Vo9X1cZu032Tka', '1', 'ft6SOiChDmJsE7uc9gF2wiVjNPNywqzS7IZJ7hqwa0LYEkVBbXNYRjuBBAaB', '2019-05-27 04:48:21', '2019-05-30 06:11:50'),
(68, 'Court Work', 'courtwork', 'courtwork@gmail.com', 'R', 1, 1, '3', '$2y$10$.iAsusVvD1MAYJfArzAJQ.a6AklKugJ/gdI9idvPnwfsenzvNM4hi', '1', '84StA9hcWdP1rX7igLxFvDVsUYr3Tc4xvflTLOb7SwDLuJVPvsNiJIi88xSr', '2019-05-27 05:41:22', '2019-06-01 13:22:53'),
(71, 'Pay Fine', 'payfine', 'payfine@gmail.com', 'P', 1, 1, '4', '$2y$10$3F42QbqI747zF8spt8DVGOuiINJ3wTFhIF1B6Z2.l3tjPK4bY2Uji', '1', 'kNZ5PXuP0sUhdG5N1jINs2xiNpU859tc1Zz13iVbMwH5jjDXNsxPgbh3k8Xi', '2019-05-27 07:21:06', '2019-06-01 14:07:30'),
(72, 'Rahul raj', 'rahulraj', 'rahul@gmail.com', 'S', NULL, NULL, NULL, '$2y$10$gE0w6G499s.36Rsxis.A9O6vh5oGO3OZ4CmkMx4zB9GXUKmTW7t9u', '1', NULL, '2019-05-28 08:24:16', '2019-05-28 08:24:16');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `calls`
--
ALTER TABLE `calls`
  ADD PRIMARY KEY (`id`),
  ADD KEY `calls_queue_id_foreign` (`queue_id`),
  ADD KEY `calls_department_id_foreign` (`department_id`),
  ADD KEY `calls_counter_id_foreign` (`counter_id`),
  ADD KEY `calls_user_id_foreign` (`user_id`);

--
-- Indexes for table `counters`
--
ALTER TABLE `counters`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `doctor_reports`
--
ALTER TABLE `doctor_reports`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `languages`
--
ALTER TABLE `languages`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `languages_code_unique` (`code`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `parent_departments`
--
ALTER TABLE `parent_departments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`),
  ADD KEY `password_resets_token_index` (`token`);

--
-- Indexes for table `patientcalls`
--
ALTER TABLE `patientcalls`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `queues`
--
ALTER TABLE `queues`
  ADD PRIMARY KEY (`id`),
  ADD KEY `queues_department_id_foreign` (`department_id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `settings_language_id_foreign` (`language_id`);

--
-- Indexes for table `uhid_masters`
--
ALTER TABLE `uhid_masters`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_username_unique` (`username`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `calls`
--
ALTER TABLE `calls`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `counters`
--
ALTER TABLE `counters`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `doctor_reports`
--
ALTER TABLE `doctor_reports`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `languages`
--
ALTER TABLE `languages`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
--
-- AUTO_INCREMENT for table `parent_departments`
--
ALTER TABLE `parent_departments`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `patientcalls`
--
ALTER TABLE `patientcalls`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `queues`
--
ALTER TABLE `queues`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `uhid_masters`
--
ALTER TABLE `uhid_masters`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `calls`
--
ALTER TABLE `calls`
  ADD CONSTRAINT `calls_counter_id_foreign` FOREIGN KEY (`counter_id`) REFERENCES `counters` (`id`),
  ADD CONSTRAINT `calls_department_id_foreign` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`),
  ADD CONSTRAINT `calls_queue_id_foreign` FOREIGN KEY (`queue_id`) REFERENCES `queues` (`id`),
  ADD CONSTRAINT `calls_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `queues`
--
ALTER TABLE `queues`
  ADD CONSTRAINT `queues_department_id_foreign` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`);

--
-- Constraints for table `settings`
--
ALTER TABLE `settings`
  ADD CONSTRAINT `settings_language_id_foreign` FOREIGN KEY (`language_id`) REFERENCES `languages` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
