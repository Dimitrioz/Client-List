-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 14, 2023 at 08:18 PM
-- Server version: 10.4.25-MariaDB
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `test`
--

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `id` int(100) NOT NULL,
  `name` varchar(100) CHARACTER SET utf8mb4 NOT NULL,
  `lastname` varchar(100) CHARACTER SET utf8mb4 NOT NULL,
  `address` varchar(255) CHARACTER SET utf8mb4 DEFAULT NULL,
  `phone` varchar(10) CHARACTER SET utf8mb4 DEFAULT NULL,
  `email` varchar(100) CHARACTER SET utf8mb4 DEFAULT NULL,
  `comments` varchar(100) CHARACTER SET utf8mb4 NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `active` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`id`, `name`, `lastname`, `address`, `phone`, `email`, `comments`, `created_at`, `active`) VALUES
(11, 'ΔΗΜΗΤΡΙΟΣ', 'ΓΚΟΡΟ', 'Θησέα 7', '6987777551', 'dimitrisgpao@hotmail.com', 'Ο καλυτερος πελατης', '2022-12-20 22:32:53', 1),
(12, 'Φελιπε', 'Μπεντερες', 'Aidoniwn 34', '6987413654', 'Phelipebed@gmail.com', 'Ο χειροτερος πελατης', '2022-12-20 22:33:45', 1),
(21, 'Μεγαλος', 'Μπισκοτος', 'Gala 12', '6945236523', 'Mpiskotosbig@gmail.com', 'Αγοραζει μονο μπισκοτα', '2022-12-28 22:20:26', 1),
(25, 'Πετρος', 'Πετρακης', 'Πετρα', '6945803311', 'peter@gmail.com', 'Ο πετρος αγοραζει πετρες', '2022-12-29 03:36:57', 1),
(26, 'Μαρια', 'Μαρακι', 'Συνταγμα', '6903451189', 'maraki@gmail.com', 'Το Μαρακι ψωνιζει πατατες μονο', '2022-12-29 03:38:21', 1),
(27, 'Μακης', 'Κοτσαμπασης', 'Χαλανδρι ', '6946023486', 'panthiras@gmail.com', 'Παιρνει μπυρες μονο', '2022-12-29 03:40:33', 1),
(31, 'Κωννουλα', 'Μπεμπα', 'Μπεμποσπιτο', '6966548848', 'μπεμποσπιτο@gmail.com', 'Ειναι η καλυτερη μπεμπα που υπαρχει στον πλανητη', '2023-02-13 23:44:46', 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) CHARACTER SET utf8mb4 NOT NULL,
  `email` varchar(250) CHARACTER SET utf8mb4 NOT NULL,
  `password` varchar(200) CHARACTER SET utf8mb4 NOT NULL,
  `date_created` int(11) NOT NULL,
  `last_login` int(11) NOT NULL,
  `status` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `date_created`, `last_login`, `status`) VALUES
(1, 'gorosdimitris', 'dimitrisgpao@hotmail.com', '$2y$10$yJAdiE4tDaLx2GkXaNM3M.GpZk0OX3ky4jtmbFDsFicdC.9EEap4e', 0, 0, 0),
(2, 'Pipinos', 'rosswalkerr1@yahoo.com', '$2y$10$1w.saHg6VjHE1lPXTnyFtOL7XrYamYpojrswd5ePR1f2IIc1ByrJO', 0, 0, 0),
(3, 'gorosdimitris1', 'dimitrisgpao@hotmail.comr', '$2y$10$uZ2xMrC3lRMQmD7JG1tVx.8g4E3qW2x/jC/CJpZ1CTuLdUUPMauje', 0, 0, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
