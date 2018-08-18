-- phpMyAdmin SQL Dump
-- version 4.8.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 18, 2018 at 09:15 PM
-- Server version: 10.1.34-MariaDB
-- PHP Version: 7.2.8

-- *****************************************************************************
-- TO SETUP DB FROM SCRATCH FOR Prog03:
-- 1) create 'blspence' database as root
-- 2) import this file into the 'blspence' database
-- 3) MODIFY config.inc.php:
--      $cfg['Servers'][$i]['user'] = 'blspence';
--      $cfg['Servers'][$i]['password'] = '483995';
-- *****************************************************************************

-- execute as root to create 'blspence' user with all privileges
GRANT USAGE ON *.* TO 'blspence'@'localhost';
DROP USER 'blspence'@'localhost';
FLUSH PRIVILEGES;
CREATE USER 'blspence'@'localhost' IDENTIFIED BY '483995';
GRANT ALL PRIVILEGES ON *.* TO 'blspence'@'localhost';


SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `blspence`
--

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `mobile` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `name`, `email`, `mobile`) VALUES
(14, 'Dwight Schrute', 'AARM@Dunder.Mifflin.com', '570-555-0123'),
(16, 'Jim Halpert', 'Pro.Prankster@Dunder.Mifflin.com', '570-555-1234'),
(17, 'Pam Halpert', 'Pro.Artist@Dunder.Mifflin.com', '570-555-2345'),
(18, 'Pete \"Plop\" Miller', 'Mr.Steal.Your.Girl@Dunder.Mifflin.com', '570-555-0124'),
(19, 'Toby Flenderson', 'Scranton.Strangler@Dunder.Mifflin.com', '570-555-2346');

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `id` int(11) NOT NULL,
  `event_date` date NOT NULL,
  `event_time` time NOT NULL,
  `event_location` varchar(50) NOT NULL,
  `event_description` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`id`, `event_date`, `event_time`, `event_location`, `event_description`) VALUES
(1, '2018-08-05', '14:05:00', 'Saginaw, MI, USA', 'Coding'),
(2, '2018-08-05', '19:40:00', 'Midland, MI, USA', 'Still Coding');

-- --------------------------------------------------------

--
-- Table structure for table `upload02`
--

CREATE TABLE `upload02` (
  `id` int(11) NOT NULL,
  `filename` varchar(255) NOT NULL,
  `filetype` varchar(255) NOT NULL,
  `filesize` int(11) NOT NULL,
  `description` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `upload03`
--

CREATE TABLE `upload03` (
  `id` int(11) NOT NULL,
  `filename` varchar(255) NOT NULL,
  `filesize` int(11) NOT NULL,
  `filetype` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `content` blob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `fname` varchar(100) NOT NULL,
  `lname` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `mobile` varchar(100) NOT NULL,
  `password` varchar(250) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `fname`, `lname`, `email`, `mobile`, `password`) VALUES
(2, 'admin', 'admin', 'admin@admin.com', '555-555-5555', '21232F297A57A5A743894A0E4A801FC3'),
(12, 'Beep', 'Bop', 'boop@boop.com', '555-555-5555', '8e564ec6715d8c17b5b4919f905e6875');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `upload02`
--
ALTER TABLE `upload02`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `upload03`
--
ALTER TABLE `upload03`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `upload02`
--
ALTER TABLE `upload02`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `upload03`
--
ALTER TABLE `upload03`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
