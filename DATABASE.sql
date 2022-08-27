-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 18, 2022 at 07:00 AM
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
-- Database: `fastwork-2`
--

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
(1, 2, 1, '<p>Untuk file data-structure.pdf yang saya upload saya pastikan bahwa sudah mendapat persetujuan dari Pak Jono</p>', '2022-08-18 11:59:49'),
(2, 1, 1, '<p>Baik mas FM, terima kasih</p>', '2022-08-18 12:00:11');

-- --------------------------------------------------------

--
-- Table structure for table `files`
--

CREATE TABLE `files` (
  `id` int(11) NOT NULL,
  `document_name` varchar(255) NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `project_id` int(10) NOT NULL,
  `user_id` int(10) NOT NULL,
  `uploaded_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `files`
--

INSERT INTO `files` (`id`, `document_name`, `file_name`, `project_id`, `user_id`, `uploaded_at`) VALUES
(1, 'base concept.pdf', '1660798632_f6296b54cdfec5f9aad7.pdf', 1, 1, '2022-08-18 11:57:12'),
(2, 'data-structure.pdf', '1660798669_40325d01015562cd0e7b.pdf', 1, 2, '2022-08-18 11:57:49');

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

CREATE TABLE `projects` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` mediumtext NOT NULL,
  `progress` varchar(255) NOT NULL DEFAULT '-'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `projects`
--

INSERT INTO `projects` (`id`, `name`, `description`, `progress`) VALUES
(1, 'Pengembangan Aplikasi Sistem Management Project Terpusat Berbasis Web', '<h2>Deskripsi Project</h2>\r\n<p>Project ini merupakan project <em>web based app development&nbsp;</em>yang bertujuan untuk membangun sebuah sistem management project terpusat yang mudah digunakan oleh semua user.</p>\r\n<p>Tujuan utama dari sistem ini adalah untuk secara terpusat menjadi tempat yang mewadahi semua user dalam melampirkan dokumen atas suatu project sehingga tidak diperlukan sistem&nbsp;<em>submission&nbsp;</em>yang terpencar seperti halnya menggunakan platform&nbsp;<em>email&nbsp;</em>maupun&nbsp;<em>Whatsapp.</em></p>\r\n<h2>Fitur Aplikasi</h2>\r\n<p>Sebagai platform manajemen internal sistem mengharuskan <span style=\"background-color: rgb(251, 238, 184);\">user untuk memiliki akun</span> agar dapat mengakses fitur utama dari aplikasi ini.</p>\r\n<p>Pengguna dari sistem ini akan dibagi menjadi <span style=\"background-color: rgb(251, 238, 184);\">2 kategori pengguna</span> yaitu :</p>\r\n<ol>\r\n<li>Administrator</li>\r\n<li>User / Employee</li>\r\n</ol>\r\n<p>Masing-masing pengguna memiliki kapabilitas yang berbeda terhadap sistem seperti dijelaskan berikut ini.</p>\r\n<h3>Administrator</h3>\r\n<ul>\r\n<li>Akses ke panel administrator\r\n<ul>\r\n<li>Projects\r\n<ul>\r\n<li>Menambahkan project baru</li>\r\n<li>Mengubah informasi project yang ada</li>\r\n<li>menghapus project (soon)</li>\r\n</ul>\r\n</li>\r\n<li>User Accounts\r\n<ul>\r\n<li>Membuat akun pengguna baru, baik untuk admin maupun user</li>\r\n<li>Mengubah informasi akun pengguna</li>\r\n<li>Mereset <em>password </em>akun pengguna</li>\r\n</ul>\r\n</li>\r\n<li>Project Files\r\n<ul>\r\n<li>Mengunggah file baru pada setiap project</li>\r\n<li>Mengunduh file pada setiap project</li>\r\n<li>Menghapus file pada setiap project</li>\r\n</ul>\r\n</li>\r\n<li>Comments\r\n<ul>\r\n<li>Menulis (membalas) komentar pada setiap project</li>\r\n</ul>\r\n</li>\r\n</ul>\r\n</li>\r\n</ul>\r\n<h3>User / Employee</h3>\r\n<ul>\r\n<li>Akses ke halaman user\r\n<ul>\r\n<li>Projects\r\n<ul>\r\n<li>Membaca informasi setiap project&nbsp;</li>\r\n</ul>\r\n</li>\r\n<li>Project Files\r\n<ul>\r\n<li>Mengunggah file pada setiap project</li>\r\n<li>Mengunduh file pada setiap project</li>\r\n</ul>\r\n</li>\r\n<li>Comments\r\n<ul>\r\n<li>Menulis (membalas) komentar pada setiap project</li>\r\n</ul>\r\n</li>\r\n</ul>\r\n</li>\r\n</ul>\r\n<h2>Contributors</h2>\r\n<ol>\r\n<li>FM. (akuonline.my.id)&nbsp; - Developer</li>\r\n</ol>', 'Dalam tahap pengembangan fitur-fitur utama sistem');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('Admin','User') NOT NULL DEFAULT 'User',
  `status` enum('Active','Suspended') NOT NULL DEFAULT 'Active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`, `status`) VALUES
(1, 'Administrator', 'admin@akuonline.my.id', '$2y$10$QQSLdGTJFv00ae9ppu5EjOiY0z0agJjlgtkCNAiO/w7IFjxcpoStm', 'Admin', 'Active'),
(2, 'FM', 'fm@akuonline.my.id', '$2y$10$gtBViS6ERu0If8nTPFcOPOf5XMzA2w4okzrLQvM70LwPaROkg8msy', 'User', 'Active');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `files`
--
ALTER TABLE `files`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `projects`
--
ALTER TABLE `projects`
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
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `files`
--
ALTER TABLE `files`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE `projects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
