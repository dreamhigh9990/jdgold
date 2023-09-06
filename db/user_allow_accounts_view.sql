-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jun 27, 2023 at 10:10 AM
-- Server version: 10.1.19-MariaDB
-- PHP Version: 5.6.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `jdgold`
--

-- --------------------------------------------------------

--
-- Table structure for table `user_allow_accounts_view`
--

CREATE TABLE `user_allow_accounts_view` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `allowed_account_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_allow_accounts_view`
--

INSERT INTO `user_allow_accounts_view` (`id`, `user_id`, `allowed_account_id`) VALUES
(1, 107, 533),
(2, 107, 539),
(200, 110, 533),
(201, 110, 1001);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `user_allow_accounts_view`
--
ALTER TABLE `user_allow_accounts_view`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `user_allow_accounts_view`
--
ALTER TABLE `user_allow_accounts_view`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=202;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
