-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 02, 2022 at 11:25 AM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ptrksn`
--

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

CREATE TABLE `attendance` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `meeting_id` int(11) NOT NULL,
  `signature` mediumtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `attendance`
--

INSERT INTO `attendance` (`id`, `user_id`, `meeting_id`, `signature`) VALUES
(1, 2, 1, 'data:image/png;base64,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'),
(2, 3, 1, 'data:image/png;base64,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'),
(6, 3, 2, 'data:image/png;base64,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'),
(8, 2, 2, 'data:image/png;base64,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');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `user_id` int(10) NOT NULL,
  `project_id` int(10) NOT NULL,
  `comment` mediumtext NOT NULL,
  `commented_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `user_id`, `project_id`, `comment`, `commented_at`) VALUES
(1, 1, 1, '<p>asdad</p>', '2022-09-24 10:08:50');

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `name` mediumtext NOT NULL,
  `description` mediumtext NOT NULL,
  `commit_time` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `event_files`
--

CREATE TABLE `event_files` (
  `id` int(11) NOT NULL,
  `document_name` mediumtext NOT NULL,
  `file_name` mediumtext NOT NULL,
  `event_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `upload_time` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `meetings`
--

CREATE TABLE `meetings` (
  `id` int(11) NOT NULL,
  `name` mediumtext NOT NULL,
  `datetime` datetime NOT NULL,
  `status` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `meetings`
--

INSERT INTO `meetings` (`id`, `name`, `datetime`, `status`) VALUES
(1, 'Agenda Pertemuan', '2022-09-07 20:18:00', 'open'),
(2, 'Rapat Perumusan PPS No.23 Thn 2022', '2022-09-11 20:00:00', 'open');

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

CREATE TABLE `projects` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` mediumtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `projects`
--

INSERT INTO `projects` (`id`, `name`, `description`) VALUES
(1, 's', '<p>asd</p>');

-- --------------------------------------------------------

--
-- Table structure for table `project_files`
--

CREATE TABLE `project_files` (
  `id` int(11) NOT NULL,
  `document_name` mediumtext NOT NULL,
  `file_name` mediumtext NOT NULL,
  `project_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `upload_time` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tutorials`
--

CREATE TABLE `tutorials` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `content` mediumtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tutorials`
--

INSERT INTO `tutorials` (`id`, `name`, `content`) VALUES
(1, 'user guide', '-');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `nip` varchar(20) DEFAULT NULL,
  `nik` varchar(20) DEFAULT NULL,
  `position` varchar(100) DEFAULT NULL,
  `instance` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `phone` varchar(20) NOT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role` enum('Admin','User','Deleted_user') NOT NULL DEFAULT 'User',
  `status` enum('Active','Suspended','Deleted') NOT NULL DEFAULT 'Active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `nip`, `nik`, `position`, `instance`, `email`, `phone`, `password`, `role`, `status`) VALUES
(1, 'Administrator', '123456', '3671000000000000', 'Administrator', 'Subdit PTRKSN III', 'admin@akuonline.my.id', '081200000000', '$2y$10$QQSLdGTJFv00ae9ppu5EjOiY0z0agJjlgtkCNAiO/w7IFjxcpoStm', 'Admin', 'Active'),
(2, 'Abdul', '234324', '234324325435', 'Pimpinan Partai', 'Partai Demokrat', 'abdul@akuonline.my.id', '45346546', '$2y$10$QQSLdGTJFv00ae9ppu5EjOiY0z0agJjlgtkCNAiO/w7IFjxcpoStm', 'User', 'Active'),
(3, 'Rudi', '5657658758', '435345', 'Wakil Pimpinan Partai', 'Partai Demokrat', 'rudi@gmail.com', '34566', '$2y$10$QQSLdGTJFv00ae9ppu5EjOiY0z0agJjlgtkCNAiO/w7IFjxcpoStm', 'User', 'Active');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `attendance`
--
ALTER TABLE `attendance`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`,`project_id`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `event_files`
--
ALTER TABLE `event_files`
  ADD PRIMARY KEY (`id`),
  ADD KEY `event_id` (`event_id`,`user_id`);

--
-- Indexes for table `meetings`
--
ALTER TABLE `meetings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `project_files`
--
ALTER TABLE `project_files`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tutorials`
--
ALTER TABLE `tutorials`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `attendance`
--
ALTER TABLE `attendance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `event_files`
--
ALTER TABLE `event_files`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `meetings`
--
ALTER TABLE `meetings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE `projects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `project_files`
--
ALTER TABLE `project_files`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tutorials`
--
ALTER TABLE `tutorials`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
