-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 12, 2023 at 09:14 AM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

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
CREATE DATABASE IF NOT EXISTS session_library;

Use session_library;
-- --------------------------------------------------------

--
-- Table structure for table `activitylog`
--

CREATE TABLE `activity_log` (
  `id` int(10) NOT NULL,
  `activity_type` varchar(255) NOT NULL,
  `activity` varchar(255) NOT NULL,
  `outcome` varchar(255) NOT NULL,
  `user_id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `organisation`
--

CREATE TABLE `organisation` (
  `id` int(10) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `organisation`
--

INSERT INTO `organisation` (`id`, `name`) VALUES
(5, 'TechUp Tasmania'),
(6, 'UTAS'),
(7, 'CUHK');

-- --------------------------------------------------------

--
-- Table structure for table `organisation_has_user`
--

CREATE TABLE `organisation_has_user` (
  `id` int(10) NOT NULL,
  `organisation_id` int(10) NOT NULL,
  `user_id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `organisationhasuser`
--

INSERT INTO `organisation_has_user` (`id`, `organisation_id`, `user_id`) VALUES
(1, 5, 11),
(2, 7, 14),
(3, 7, 13);

-- --------------------------------------------------------

--
-- Table structure for table `permission`
--

CREATE TABLE `permission` (
  `id` int(10) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` longtext NOT NULL,
  `permission_group_id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `permission`
--

INSERT INTO `permission` (`id`, `name`, `description`, `permission_group_id`) VALUES
(10, 'edit volunteer', 'edit volunteer details or engagement', 1),
(11, 'add volunteer', 'register volunteer account', 2),
(12, 'delete volunteer', 'delete volunteer details or engagement', 3),
(13, 'add organization', 'register organization', 2),
(14, 'delete organization', 'delete organization', 3),
(15, 'edit organization', 'edit organization', 1),
(16, 'edit permission', 'edit permission for users', 1),
(17, 'add permission', 'add permission for users', 2),
(18, 'delete permission', 'delete permission for users', 3);

-- --------------------------------------------------------

--
-- Table structure for table `permission_group`
--

CREATE TABLE `permission_group` (
  `id` int(10) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `permissiongroup`
--

INSERT INTO `permission_group` (`id`, `name`) VALUES
(1, 'edit'),
(2, 'add'),
(3, 'delete');

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

CREATE TABLE `role` (
  `id` int(10) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `role_has_permission`
--

INSERT INTO `role_has_permission` (`id`, `role_id`, `permission_id`) VALUES
(1, 1, 13),
(2, 1, 17),
(3, 1, 11),
(4, 1, 14),
(5, 1, 18),
(6, 1, 12),
(7, 1, 15),
(8, 1, 16),
(9, 1, 10),
(10, 2, 11),
(11, 2, 17),
(12, 2, 18),
(13, 2, 12),
(14, 2, 15),
(15, 2, 16),
(16, 2, 10),
(21, 3, 10);

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
  `photo_path` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `first_name`, `last_name`, `preferred_name`, `email`, `phone`, `username`, `password`, `photo_path`) VALUES
(11, 'David', 'Hui', 'Dave', 'davidhui2047@gmail.com', '0425665169', 'davidhui', '$2y$10$ANIwta0NYQYfdC4/v5fi1OrqTgsk6.W.q4.zpEW9zsZn/CI8JSfJ6', NULL),
(13, 'Woody', 'Leung', 'Wood', 'woodyl@gmail.com', '59983585', 'woodyl', '$2y$10$caiJG/7ULcNt5LQVMxAmcOf89KJkTM7bb7Qpg4qMU8itEm10pcYwS', NULL),
(14, 'Samuel', 'Tong', 'Sam', 'samtong@gmail.com', '88651523', 'samt', '$2y$10$SnUxF0YMVWK02KwZVR1aGOoQi6VRZ1b9GGp6TyEiBh09mVuoBoFFW', NULL),
(15, NULL, NULL, NULL, 'davidhui2043@gmail.com', NULL, NULL, '$2y$10$rUzErWvekOuaUnSYDwLc5.FmsxpUrdAXLp/P2PUpHIWcLAnhVaoMO', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_has_role`
--

CREATE TABLE `user_has_role` (
  `id` int(10) NOT NULL,
  `role_id` int(10) NOT NULL,
  `organisation_has_user_id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_has_role`
--

INSERT INTO `user_has_role` (`id`, `role_id`, `organisation_has_user_id`) VALUES
(1, 1, 1),
(2, 2, 2),
(3, 4, 3);

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
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `organisation_has_user`
--
ALTER TABLE `organisation_has_user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `organisation_id` (`organisation_id`),
  ADD KEY `user_id` (`user_id`);

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
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

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
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `permission`
--
ALTER TABLE `permission`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `permission_group`
--
ALTER TABLE `permission_group`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `role`
--
ALTER TABLE `role`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `role_has_permission`
--
ALTER TABLE `role_has_permission`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `userhasrole`
--
ALTER TABLE `user_has_role`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `activity_log`
--
ALTER TABLE `activity_log`
  ADD CONSTRAINT `activity_log_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Constraints for table `organisation_has_user`
--
ALTER TABLE `organisation_has_user`
  ADD CONSTRAINT `organisation_has_user_ibfk_1` FOREIGN KEY (`organisation_id`) REFERENCES `organisation` (`id`),
  ADD CONSTRAINT `organisation_has_user_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

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
-- Constraints for table `user_has_role`
--
ALTER TABLE `user_has_role`
  ADD CONSTRAINT `user_has_role_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `role` (`id`),
  ADD CONSTRAINT `user_has_role_ibfk_2` FOREIGN KEY (`organisation_has_user_id`) REFERENCES `organisation_has_user` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
