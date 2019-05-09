-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: May 08, 2019 at 01:16 AM
-- Server version: 10.1.38-MariaDB
-- PHP Version: 7.1.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
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
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
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
(1, 'A Plus B', '<p>Add two <em>numbers <strong>and boom <span style=\"text-decoration: underline;\"><span style=\"font-family: impact, sans-serif;\">you win</span></span></strong></em></p>\r\n<p><em><strong><span style=\"text-decoration: underline;\"><span style=\"font-family: impact, sans-serif;\">And we can </span></span></strong><span style=\"text-decoration: underline;\"><span style=\"font-family: impact, sans-serif;\">edit</span></span></em><span style=\"text-decoration: underline;\"><span style=\"font-family: impact, sans-serif;\">&nbsp; <span style=\"text-decoration: line-through;\">i think?</span><br /></span></span></p>', 2, 24, 64, '1 2', '3', '[ {\"cases\": [\"1 2\", \"4 5\"], \"points\": 5 }, {\"cases\": [\"7 5\"], \"points\": 5} ]', '[ { \"cases\": [\"3\", \"9\"], \"points\": 5 }, {\"cases\": [\"12\"], \"points\": 5 } ]');

-- --------------------------------------------------------

--
-- Table structure for table `submissions`
--

CREATE TABLE `submissions` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `problem_id` int(11) NOT NULL,
  `batch` int(11) NOT NULL,
  `result` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `points` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `submissions`
--

INSERT INTO `submissions` (`id`, `user_id`, `problem_id`, `batch`, `result`, `points`) VALUES
(1, 3, 1, 0, 'AC', 2),
(41, 1, 1, 0, 'AC', 5),
(42, 1, 1, 1, 'AC', 5);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `points` int(11) NOT NULL,
  `full_name` text COLLATE utf8_unicode_ci NOT NULL,
  `school` text COLLATE utf8_unicode_ci NOT NULL,
  `profile_desc` text COLLATE utf8_unicode_ci NOT NULL,
  `role` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`, `points`, `full_name`, `school`, `profile_desc`, `role`) VALUES
(1, 'seshpenguin', '$2y$10$ZxtfqtoIJ8RK0jf08.w4S.n1ht/iL9PW.0YJkJeHD1l72MvJC/Sbq', 'seshan10@me.com', 10, 'Seshan Ravikumar', 'Bayview SS', '', 1),
(3, 'test', '$2y$10$bdvR6bHHfetnMaTGjSws..1p4CrrTNnkPb.a1QBwAn559pH0QmeqC', 'test@test.net', 2, 'Test McTestFace', 'Pixl North Secondary', '', 0),
(6, 'test2', '$2y$10$yeTwSPcRROkHbY/fsxFt..aWoIIcwDK2kYh.0cJ5zY8llbzc/oGai', 'test@test.nett', 0, 's', 's', '', 0),
(7, 'Raymo111', '$2y$10$fgw2tPpjvFv48dp6hb5Wr.KsnHXXQ3WJnOoYrhT/ng6QX1.FByOLy', 'hi@raymond.tk', 0, 'Raymond Li', 'Bayview SS', '', 1),
(10, 'test2', '$2y$10$idcypdc2Snq.S5.6CJ00COEoxJ0R7ZazZTAMaMfma18QseSTkBKju', 'seshan10@me.com', 2, 'This Name', 'Bayview Secondary School', 'Default User', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `problems`
--
ALTER TABLE `problems`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `submissions`
--
ALTER TABLE `submissions`
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
-- AUTO_INCREMENT for table `submissions`
--
ALTER TABLE `submissions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
