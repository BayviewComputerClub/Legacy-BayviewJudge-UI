-- phpMyAdmin SQL Dump
-- version 4.6.6deb5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Apr 26, 2019 at 11:20 AM
-- Server version: 10.1.38-MariaDB-0ubuntu0.18.04.1
-- PHP Version: 7.2.17-0ubuntu0.18.04.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bayviewjudge`
--

-- --------------------------------------------------------

--
-- Table structure for table `problems`
--

CREATE TABLE `problems` (
  `id` int(11) NOT NULL,
  `name` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `details` text COLLATE utf8_unicode_ci NOT NULL,
  `points` int(11) NOT NULL,
  `timelimit` int(11) NOT NULL,
  `memlimit` int(11) NOT NULL,
  `sample_in` text COLLATE utf8_unicode_ci NOT NULL,
  `sample_out` text COLLATE utf8_unicode_ci NOT NULL,
  `in_cases` text COLLATE utf8_unicode_ci NOT NULL,
  `out_cases` text COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `problems`
--

INSERT INTO `problems` (`id`, `name`, `details`, `points`, `timelimit`, `memlimit`, `sample_in`, `sample_out`, `in_cases`, `out_cases`) VALUES
(1, 'A Plus B', 'Add two numbers and then output the result.', 2, 2, 16, '1 2', '3', '[\"0 2\", \"1 3\"]', '[\"2\", \"4\"]');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `points` int(11) NOT NULL,
  `full_name` text COLLATE utf8_unicode_ci NOT NULL,
  `school` text COLLATE utf8_unicode_ci NOT NULL,
  `profile_desc` text COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`, `points`, `full_name`, `school`, `profile_desc`) VALUES
(1, 'seshpenguin1', '123', 'seshan10@me.com', 100, 'Hey', 'Place', 'Woop de dang do'),
(2, 'John', 'Doe', 'john@example.com', 0, 'hi', 'hi2', 'hi'),
(3, '', '$2y$10$WAmiHWp/P/95Qxvp7ixjLebdIBqHf315U7P4lc/zKLv1b1kcXFIye', 'john@example.com', 0, 'hi', 'hi2', 'hi'),
(4, 'test', '$2y$10$bi5s7nGckpL1kDbZGxkKqe0vnOmhOm2Uv2iQlTPozllCB87MwSD96', 'seshan10@me.com', 0, 'Test User', 'Bayview Secondary School', 'Default User');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `problems`
--
ALTER TABLE `problems`
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
-- AUTO_INCREMENT for table `problems`
--
ALTER TABLE `problems`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
