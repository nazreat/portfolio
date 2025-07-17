-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 27, 2023 at 05:53 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `session_library`
--
CREATE DATABASE IF NOT EXISTS `session_library` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `session_library`;

-- --------------------------------------------------------

--
-- Table structure for table `activity_log`
--

CREATE TABLE `activity_log` (
  `id` int(10) NOT NULL,
  `activity_type` varchar(255) NOT NULL,
  `activity` varchar(255) NOT NULL,
  `outcome` varchar(255) NOT NULL,
  `user_id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `organisation`
--

CREATE TABLE `organisation` (
  `id` int(10) NOT NULL,
  `name` varchar(255) NOT NULL,
  `status_id` int(10) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `uuid` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `organisation`
--

INSERT INTO `organisation` (`id`, `name`, `status_id`, `created_at`, `uuid`) VALUES
(5, 'TechUp Tasmania', 1, '2023-05-08 23:37:07', 'de65593b-edf9-11ed-afa7-c84bd657767b'),
(6, 'UTAS', 1, '2023-05-08 23:37:07', '21aeadb6-edfa-11ed-afa7-c84bd657767b'),
(7, 'TAFE', 1, '2023-05-08 23:37:07', 'de6560c0-edf9-11ed-afa7-c84bd657767b');

-- --------------------------------------------------------

--
-- Table structure for table `organisation_has_user`
--

CREATE TABLE `organisation_has_user` (
  `id` int(10) NOT NULL,
  `organisation_id` int(10) NOT NULL,
  `user_id` int(10) NOT NULL,
  `status_id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `organisation_has_user`
--

INSERT INTO `organisation_has_user` (`id`, `organisation_id`, `user_id`, `status_id`) VALUES
(1, 5, 11, 1),
(2, 6, 13, 1),
(3, 7, 14, 1),
(4, 6, 14, 1);

-- --------------------------------------------------------

--
-- Table structure for table `permission`
--

CREATE TABLE `permission` (
  `id` int(10) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` longtext NOT NULL,
  `permission_group_id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `permission`
--

INSERT INTO `permission` (`id`, `name`, `description`, `permission_group_id`) VALUES
(10, 'edit staff', 'edit staff (including volunteers)', 1),
(11, 'add staff', 'register/create staff (including volunteers)', 2),
(12, 'delete staff', 'delete staff (including volunteers) ', 3),
(13, 'view staff', 'view staff page (including volunteers)', 5),
(16, 'edit permissions', 'edit permissions for users (to be decided)', 1),
(17, 'add permissions', 'create new permission  (to be decided)', 2),
(18, 'delete permissions', 'delete permissions for users  (to be decided)', 3),
(19, 'view permissions', 'view permissions page (to be decided)', 5),
(23, 'view timesheets', 'view timesheets page', 5),
(24, 'edit timesheets', 'edit timesheets', 1),
(27, 'add timesheets', 'create timesheets', 2),
(28, 'delete timesheets', 'delete timesheets', 3),
(29, 'add events', 'create events', 2),
(30, 'delete events', 'delete events', 3),
(31, 'edit events', 'edit events', 1),
(32, 'view events', 'view events page', 5),
(33, 'join events', 'join events', 6),
(35, 'view requests', 'view requests page', 5),
(36, 'approve requests', 'approve requests', 1),
(37, 'decline requests', 'decline requests', 1),
(39, 'view admin dashboard', 'view admin dashboard page', 5),
(40, 'view volunteer dashboard', 'view volunteer dashboard page', 5);

-- --------------------------------------------------------

--
-- Table structure for table `permission_group`
--

CREATE TABLE `permission_group` (
  `id` int(10) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `permission_group`
--

INSERT INTO `permission_group` (`id`, `name`) VALUES
(1, 'edit'),
(2, 'add'),
(3, 'delete'),
(5, 'view'),
(6, 'join');

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

CREATE TABLE `role` (
  `id` int(10) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `role`
--

INSERT INTO `role` (`id`, `name`, `description`) VALUES
(1, 'super admin', 'Manage the whole system'),
(2, 'admin', 'Manage the organization'),
(3, 'supervisor ', 'manage volunteer engagement '),
(4, 'volunteer', 'volunteer');

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permission`
--

CREATE TABLE `role_has_permission` (
  `id` int(10) NOT NULL,
  `role_id` int(10) NOT NULL,
  `permission_id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `role_has_permission`
--

INSERT INTO `role_has_permission` (`id`, `role_id`, `permission_id`) VALUES
(26, 1, 10),
(27, 1, 11),
(28, 1, 12),
(29, 1, 13),
(30, 1, 16),
(31, 1, 17),
(32, 1, 18),
(33, 1, 19),
(34, 1, 23),
(35, 1, 24),
(36, 1, 27),
(37, 1, 28),
(38, 1, 29),
(39, 1, 30),
(40, 1, 31),
(41, 1, 32),
(42, 1, 33),
(43, 1, 35),
(44, 1, 36),
(45, 1, 37),
(46, 1, 39),
(47, 1, 40),
(48, 4, 23),
(49, 4, 24),
(50, 4, 27),
(51, 4, 28),
(52, 4, 32),
(53, 4, 33),
(54, 4, 40),
(55, 3, 13),
(56, 3, 32),
(57, 3, 35),
(58, 3, 36),
(59, 3, 37),
(60, 3, 39);

-- --------------------------------------------------------

--
-- Table structure for table `status`
--

CREATE TABLE `status` (
  `id` int(10) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `status`
--

INSERT INTO `status` (`id`, `name`) VALUES
(1, 'ACTIVE'),
(2, 'DELETED'),
(3, 'INACTIVE');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(10) NOT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `preferred_name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `photo_path` varchar(255) DEFAULT NULL,
  `status_id` int(10) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `uuid` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `first_name`, `last_name`, `preferred_name`, `email`, `phone`, `username`, `password`, `photo_path`, `status_id`, `created_at`, `uuid`) VALUES
(11, 'David', 'Hui', 'Dave', 'superadmin@gmail.com', '0425665169', 'davidhui', '$2y$10$ANIwta0NYQYfdC4/v5fi1OrqTgsk6.W.q4.zpEW9zsZn/CI8JSfJ6', NULL, 1, '2023-05-08 23:36:57', 'de63d3e2-edf9-11ed-afa7-c84bd657767b'),
(13, 'Woody', 'Leung', 'Wood', 'supervisor@gmail.com', '59983585', 'woodyl', '$2y$10$ANIwta0NYQYfdC4/v5fi1OrqTgsk6.W.q4.zpEW9zsZn/CI8JSfJ6', NULL, 1, '2023-05-08 23:36:57', 'de641cd2-edf9-11ed-afa7-c84bd657767b'),
(14, 'Samuel', 'Tong', 'Sam', 'volunteer@gmail.com', '88651523', 'samt', '$2y$10$ANIwta0NYQYfdC4/v5fi1OrqTgsk6.W.q4.zpEW9zsZn/CI8JSfJ6', NULL, 1, '2023-05-08 23:36:57', 'de641da5-edf9-11ed-afa7-c84bd657767b');

-- --------------------------------------------------------

--
-- Table structure for table `user_has_role`
--

CREATE TABLE `user_has_role` (
  `id` int(10) NOT NULL,
  `role_id` int(10) NOT NULL,
  `organisation_has_user_id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_has_role`
--

INSERT INTO `user_has_role` (`id`, `role_id`, `organisation_has_user_id`) VALUES
(1, 1, 1),
(2, 3, 2),
(3, 4, 3),
(4, 3, 4);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activity_log`
--
ALTER TABLE `activity_log`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `organisation`
--
ALTER TABLE `organisation`
  ADD PRIMARY KEY (`id`),
  ADD KEY `status_id` (`status_id`);

--
-- Indexes for table `organisation_has_user`
--
ALTER TABLE `organisation_has_user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `organisation_id` (`organisation_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `status_id` (`status_id`);

--
-- Indexes for table `permission`
--
ALTER TABLE `permission`
  ADD PRIMARY KEY (`id`),
  ADD KEY `permission_group_id` (`permission_group_id`);

--
-- Indexes for table `permission_group`
--
ALTER TABLE `permission_group`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `role_has_permission`
--
ALTER TABLE `role_has_permission`
  ADD PRIMARY KEY (`id`),
  ADD KEY `role_id` (`role_id`),
  ADD KEY `permission_id` (`permission_id`);

--
-- Indexes for table `status`
--
ALTER TABLE `status`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `status_id` (`status_id`);

--
-- Indexes for table `user_has_role`
--
ALTER TABLE `user_has_role`
  ADD PRIMARY KEY (`id`),
  ADD KEY `role_id` (`role_id`),
  ADD KEY `organisation_has_user_id` (`organisation_has_user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activity_log`
--
ALTER TABLE `activity_log`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `organisation`
--
ALTER TABLE `organisation`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `organisation_has_user`
--
ALTER TABLE `organisation_has_user`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `permission`
--
ALTER TABLE `permission`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `permission_group`
--
ALTER TABLE `permission_group`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `role`
--
ALTER TABLE `role`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `role_has_permission`
--
ALTER TABLE `role_has_permission`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT for table `status`
--
ALTER TABLE `status`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `user_has_role`
--
ALTER TABLE `user_has_role`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `activity_log`
--
ALTER TABLE `activity_log`
  ADD CONSTRAINT `activity_log_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Constraints for table `organisation`
--
ALTER TABLE `organisation`
  ADD CONSTRAINT `organisation_ibfk_1` FOREIGN KEY (`status_id`) REFERENCES `status` (`id`);

--
-- Constraints for table `organisation_has_user`
--
ALTER TABLE `organisation_has_user`
  ADD CONSTRAINT `organisation_has_user_ibfk_1` FOREIGN KEY (`organisation_id`) REFERENCES `organisation` (`id`),
  ADD CONSTRAINT `organisation_has_user_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `organisation_has_user_ibfk_3` FOREIGN KEY (`status_id`) REFERENCES `status` (`id`);

--
-- Constraints for table `permission`
--
ALTER TABLE `permission`
  ADD CONSTRAINT `permission_ibfk_1` FOREIGN KEY (`permission_group_id`) REFERENCES `permission_group` (`id`);

--
-- Constraints for table `role_has_permission`
--
ALTER TABLE `role_has_permission`
  ADD CONSTRAINT `role_has_permission_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `role` (`id`),
  ADD CONSTRAINT `role_has_permission_ibfk_2` FOREIGN KEY (`permission_id`) REFERENCES `permission` (`id`);

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`status_id`) REFERENCES `status` (`id`);

--
-- Constraints for table `user_has_role`
--
ALTER TABLE `user_has_role`
  ADD CONSTRAINT `user_has_role_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `role` (`id`),
  ADD CONSTRAINT `user_has_role_ibfk_2` FOREIGN KEY (`organisation_has_user_id`) REFERENCES `organisation_has_user` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
