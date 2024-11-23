-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Nov 23, 2024 at 01:42 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `amapos_logs`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_logs`
--

CREATE TABLE `admin_logs` (
  `id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `activity_type` varchar(50) NOT NULL,
  `user_type` varchar(30) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_logs`
--

INSERT INTO `admin_logs` (`id`, `email`, `activity_type`, `user_type`, `timestamp`) VALUES
(2, 'admin@gmail.com', 'Login', 'admin', '2024-11-19 10:31:58'),
(3, 'admin@gmail.com', 'Logout', 'admin', '2024-11-19 10:32:08'),
(4, 'admin@gmail.com', 'Logout', 'admin', '2024-11-19 10:32:52'),
(5, 'admin@gmail.com', 'Logout', 'admin', '2024-11-22 21:02:09'),
(6, 'admin@gmail.com', 'Logout', 'admin', '2024-11-22 21:18:26'),
(7, 'admin@gmail.com', 'Logout', 'admin', '2024-11-22 21:35:04'),
(8, 'admin@gmail.com', 'Login', 'admin', '2024-11-22 22:24:40'),
(9, 'admin@gmail.com', 'Logout', 'admin', '2024-11-22 23:15:34'),
(10, 'admin@gmail.com', 'Logout', 'admin', '2024-11-23 00:09:52'),
(11, 'admin@gmail.com', 'Logout', 'admin', '2024-11-23 00:20:12'),
(12, 'admin@gmail.com', 'Logout', 'admin', '2024-11-23 00:22:07'),
(13, 'admin@gmail.com', 'Login', 'admin', '2024-11-23 00:22:17'),
(14, 'admin@gmail.com', 'Logout', 'admin', '2024-11-23 00:24:09'),
(15, 'admin@gmail.com', 'Login', 'admin', '2024-11-23 00:27:28');

-- --------------------------------------------------------

--
-- Table structure for table `user_logs`
--

CREATE TABLE `user_logs` (
  `id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `activity_type` varchar(50) NOT NULL,
  `user_type` varchar(50) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_logs`
--

INSERT INTO `user_logs` (`id`, `email`, `activity_type`, `user_type`, `timestamp`) VALUES
(5, 'parent@gmail.com', 'Login', 'parent', '2024-11-22 21:34:58'),
(6, 'student@gmail.com', 'Login', 'student', '2024-11-22 21:46:07'),
(7, 'parent@gmail.com', 'Login', 'parent', '2024-11-22 23:15:46'),
(8, 'parent@gmail.com', 'Login', 'parent', '2024-11-23 00:10:04'),
(9, 'student@gmail.com', 'Login', 'student', '2024-11-23 00:20:26');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_logs`
--
ALTER TABLE `admin_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_logs`
--
ALTER TABLE `user_logs`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_logs`
--
ALTER TABLE `admin_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `user_logs`
--
ALTER TABLE `user_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
