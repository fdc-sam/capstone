-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 11, 2021 at 03:07 AM
-- Server version: 10.4.13-MariaDB
-- PHP Version: 7.2.32

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `capstone`
--

-- --------------------------------------------------------

--
-- Table structure for table `batch`
--

CREATE TABLE `batch` (
  `id` int(11) NOT NULL,
  `batch_from` date NOT NULL,
  `batch_to` date NOT NULL,
  `code` varchar(20) NOT NULL,
  `description` text NOT NULL,
  `status` tinyint(2) NOT NULL COMMENT '0: deactivated\r\n1 : active',
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `batch`
--

INSERT INTO `batch` (`id`, `batch_from`, `batch_to`, `code`, `description`, `status`, `created`, `modified`) VALUES
(8, '2021-03-19', '2021-03-19', 'z6j0n', '<p>Test ting&nbsp;</p>\n', 0, '2021-03-19 13:30:14', '2021-03-19 13:30:14'),
(10, '2021-03-19', '2021-03-19', 'wgwtq', '<p>asdasd</p>\n', 0, '2021-03-19 13:31:30', '2021-03-19 13:31:30'),
(13, '2021-03-19', '2021-03-19', 'j4yua', '<p>asdasd</p>\n', 0, '2021-03-19 13:40:19', '2021-03-19 13:40:19'),
(27, '2021-03-27', '2021-03-27', 'jna4z', '<ul><li>asdasd</li></ul>', 1, '2021-03-27 05:28:31', '2021-03-27 05:28:31');

-- --------------------------------------------------------

--
-- Table structure for table `batch_connect`
--

CREATE TABLE `batch_connect` (
  `id` int(11) NOT NULL,
  `batch_id` int(11) NOT NULL,
  `email` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `batch_connect`
--

INSERT INTO `batch_connect` (`id`, `batch_id`, `email`) VALUES
(2, 10, 'samvillarta05@gmail.com'),
(4, 10, 'samvillarta051@gmail.com'),
(5, 10, 'aloha05@gmail.com'),
(6, 10, 'MJ@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `class`
--

CREATE TABLE `class` (
  `id` int(11) NOT NULL,
  `class_room_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `date_created` datetime NOT NULL,
  `date_modified` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE `groups` (
  `id` mediumint(8) UNSIGNED NOT NULL,
  `name` varchar(20) NOT NULL,
  `description` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `groups`
--

INSERT INTO `groups` (`id`, `name`, `description`) VALUES
(1, 'admin', 'Administrator'),
(3, 'IT head', 'IT Head'),
(4, 'student', 'student'),
(5, 'instructor', 'Instructor');

-- --------------------------------------------------------

--
-- Table structure for table `login_attempts`
--

CREATE TABLE `login_attempts` (
  `id` int(11) UNSIGNED NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `login` varchar(100) NOT NULL,
  `time` int(11) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `thises`
--

CREATE TABLE `thises` (
  `id` int(11) NOT NULL,
  `thesis_group_id` varchar(20) NOT NULL,
  `title` text NOT NULL,
  `discreption` text NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `status` tinyint(2) DEFAULT 0 COMMENT '0 Pending\r\n1 Approved\r\n2 Rejected'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `thises`
--

INSERT INTO `thises` (`id`, `thesis_group_id`, `title`, `discreption`, `created`, `modified`, `status`) VALUES
(46, '7', 'Title 1', 'Description 1', '2021-04-09 05:56:53', '2021-04-09 05:56:53', 0),
(47, '7', 'Title 2', 'Description 2', '2021-04-09 06:09:40', '2021-04-09 06:09:40', 0),
(48, '8', 'Title 3', 'Description 3', '2021-04-09 06:09:40', '2021-04-09 06:09:40', 0);

-- --------------------------------------------------------

--
-- Table structure for table `thises_connect`
--

CREATE TABLE `thises_connect` (
  `id` int(11) NOT NULL,
  `thesis_group_id` varchar(11) NOT NULL,
  `thises_id` int(11) NOT NULL,
  `batch_id` varchar(20) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `thises_connect`
--

INSERT INTO `thises_connect` (`id`, `thesis_group_id`, `thises_id`, `batch_id`, `user_id`, `created`, `modified`) VALUES
(131, '7', 0, '10', 23, '2021-04-09 05:56:47', '2021-04-09 05:56:47'),
(133, '8', 0, '10', 31, '2021-04-09 05:57:34', '2021-04-09 05:57:34'),
(134, '8', 0, '10', 28, '2021-04-09 05:57:53', '2021-04-09 05:57:53'),
(135, '9', 0, '10', 35, '2021-04-10 04:27:01', '2021-04-10 04:27:01'),
(136, '7', 0, '10', 30, '2021-04-10 12:34:18', '2021-04-10 12:34:18');

-- --------------------------------------------------------

--
-- Table structure for table `thises_group`
--

CREATE TABLE `thises_group` (
  `id` int(11) NOT NULL,
  `thesis_group_name` text NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `thises_group`
--

INSERT INTO `thises_group` (`id`, `thesis_group_name`, `created`, `modified`) VALUES
(7, 'wemnrk-0nc', '2021-04-09 05:56:47', '2021-04-09 05:56:47'),
(8, '1', '2021-04-09 12:21:34', '2021-03-12 10:48:45'),
(9, 'sw9usxnbsw', '2021-04-10 04:27:01', '2021-04-10 04:27:01'),
(10, '3ydkbx3o-s', '2021-04-10 06:43:05', '2021-04-10 06:43:05'),
(11, 'c35ihimgmy', '2021-04-10 06:43:05', '2021-04-10 06:43:05');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) UNSIGNED NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `username` varchar(100) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(254) NOT NULL,
  `activation_selector` varchar(255) DEFAULT NULL,
  `activation_code` varchar(255) DEFAULT NULL,
  `forgotten_password_selector` varchar(255) DEFAULT NULL,
  `forgotten_password_code` varchar(255) DEFAULT NULL,
  `forgotten_password_time` int(11) UNSIGNED DEFAULT NULL,
  `remember_selector` varchar(255) DEFAULT NULL,
  `remember_code` varchar(255) DEFAULT NULL,
  `created_on` int(11) UNSIGNED NOT NULL,
  `last_login` int(11) UNSIGNED DEFAULT NULL,
  `active` tinyint(1) UNSIGNED DEFAULT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `middle_name` varchar(100) DEFAULT NULL,
  `gender` tinyint(2) DEFAULT NULL COMMENT '1 : Male\r\n2 : Female',
  `phone` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `ip_address`, `username`, `password`, `email`, `activation_selector`, `activation_code`, `forgotten_password_selector`, `forgotten_password_code`, `forgotten_password_time`, `remember_selector`, `remember_code`, `created_on`, `last_login`, `active`, `first_name`, `last_name`, `middle_name`, `gender`, `phone`) VALUES
(1, '127.0.0.1', 'administrator', '$2y$12$Xvj2qkM/SxReG2/uRdFv4uX8gzgmdFZ/x8FfyHnyJd33SlWbHrW/y', 'admin@admin.com', NULL, '', NULL, NULL, NULL, NULL, NULL, 1268889823, 1617923788, 1, 'Admin', 'istrator', 'ADMIN', NULL, '0'),
(21, '::1', 'samvillarta01@gmail.com', '$2y$10$ntwlC.FUf3j6u5b4ZZNtKeFqv0RZgoFrcu8AdnaIWOwU6lP9kl6rS', 'samvillarta01@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1615634101, 1618093652, 1, 'Samuel', 'Villarta', 'C.', 1, NULL),
(23, '::1', 'samvillarta05@gmail.com', '$2y$10$XKgzKrJDgz1A.yq.tmFThui/DrlzyWsFcy05A8TzM.MiITrtTv/My', 'samvillarta05@gmail.com', NULL, '93ior', NULL, NULL, NULL, NULL, NULL, 1615681394, 1618050821, 1, 'Samuel', 'Villarta', '', 2, NULL),
(30, '::1', 'aloha05@gmail.com', '$2y$10$gDPUr5uggIQpF9Jes8NWVe3hIduPx73uwPwo0PXJCl0hZwVLn/PYe', 'aloha05@gmail.com', NULL, 'xv-p0', NULL, NULL, NULL, NULL, NULL, 1617239599, 1617239651, 1, 'Aloha', 'Aloha', 'Aloha', 2, NULL),
(31, '::1', 'mj@gmail.com', '$2y$10$RNNdywlPbiLEHcDsvk/ASO81dUlFN.NMFG4OHfyG4uYOuei5lF6me', 'mj@gmail.com', NULL, '7eynx', NULL, NULL, NULL, NULL, NULL, 1617240129, 1617276493, 1, 'MJ', 'MJ', 'sai', 2, NULL),
(34, '::1', 'fdc.samvillarta@gmail.com', '$2y$10$vVl.eET1vbOfdnr8kmVmyOHrh9POinGSm2LyLs.QFS0jySVVCMRRa', 'fdc.samvillarta@gmail.com', 'Deactivated', 'cwunc', NULL, NULL, NULL, NULL, NULL, 1618021366, 1618021415, 1, 'Jocelyn', 'Jocelyn', 'Jocelyn', 1, NULL),
(36, '::1', 'qwerty@gmail.com', '$2y$10$KF511n2qtC4F.OxM7tSzX.B4oMWmyhPIrjaeFRwXnU3wxmNFObnc6', 'qwerty@gmail.com', 'Deactivated', '53uy-', NULL, NULL, NULL, NULL, NULL, 1618021875, 1618042099, 1, 'qwerty', 'qwerty', 'qwerty', 2, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users_groups`
--

CREATE TABLE `users_groups` (
  `id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `group_id` mediumint(8) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users_groups`
--

INSERT INTO `users_groups` (`id`, `user_id`, `group_id`) VALUES
(1, 1, 1),
(21, 21, 3),
(23, 23, 4),
(30, 30, 4),
(31, 31, 4),
(34, 34, 5),
(36, 36, 5);

-- --------------------------------------------------------

--
-- Table structure for table `user_profile_pics`
--

CREATE TABLE `user_profile_pics` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `picture` longblob NOT NULL,
  `created_date` datetime NOT NULL,
  `modified_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `batch`
--
ALTER TABLE `batch`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code_2` (`code`),
  ADD KEY `code` (`code`);

--
-- Indexes for table `batch_connect`
--
ALTER TABLE `batch_connect`
  ADD PRIMARY KEY (`id`),
  ADD KEY `batch_id` (`batch_id`),
  ADD KEY `email` (`email`);

--
-- Indexes for table `class`
--
ALTER TABLE `class`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `login_attempts`
--
ALTER TABLE `login_attempts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `thises`
--
ALTER TABLE `thises`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `thises_connect`
--
ALTER TABLE `thises_connect`
  ADD PRIMARY KEY (`id`),
  ADD KEY `batch_id` (`batch_id`),
  ADD KEY `user_id` (`user_id`) USING BTREE,
  ADD KEY `thises_id` (`thises_id`),
  ADD KEY `thesis_group_id` (`thesis_group_id`);

--
-- Indexes for table `thises_group`
--
ALTER TABLE `thises_group`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uc_email` (`email`),
  ADD UNIQUE KEY `uc_forgotten_password_selector` (`forgotten_password_selector`),
  ADD UNIQUE KEY `uc_remember_selector` (`remember_selector`);

--
-- Indexes for table `users_groups`
--
ALTER TABLE `users_groups`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uc_users_groups` (`user_id`,`group_id`),
  ADD KEY `fk_users_groups_users1_idx` (`user_id`),
  ADD KEY `fk_users_groups_groups1_idx` (`group_id`);

--
-- Indexes for table `user_profile_pics`
--
ALTER TABLE `user_profile_pics`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `batch`
--
ALTER TABLE `batch`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `batch_connect`
--
ALTER TABLE `batch_connect`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `class`
--
ALTER TABLE `class`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `groups`
--
ALTER TABLE `groups`
  MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `login_attempts`
--
ALTER TABLE `login_attempts`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=98;

--
-- AUTO_INCREMENT for table `thises`
--
ALTER TABLE `thises`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `thises_connect`
--
ALTER TABLE `thises_connect`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=137;

--
-- AUTO_INCREMENT for table `thises_group`
--
ALTER TABLE `thises_group`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `users_groups`
--
ALTER TABLE `users_groups`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `user_profile_pics`
--
ALTER TABLE `user_profile_pics`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `users_groups`
--
ALTER TABLE `users_groups`
  ADD CONSTRAINT `fk_users_groups_groups1` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_users_groups_users1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
