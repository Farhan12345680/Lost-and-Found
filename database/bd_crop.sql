-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 26, 2026 at 08:49 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bd crop`
--

-- --------------------------------------------------------

--
-- Table structure for table `crops`
--

CREATE TABLE `crops` (
  `crop name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `district`
--

CREATE TABLE `district` (
  `District_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `district wise production of crop`
--

CREATE TABLE `district wise production of crop` (
  `District name` varchar(20) NOT NULL,
  `Area` decimal(10,5) DEFAULT 0.00000,
  `production` decimal(10,5) DEFAULT 0.00000,
  `Financial Year` varchar(20) NOT NULL,
  `Year midpoint` decimal(5,2) NOT NULL,
  `Crop name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `year wise crop production`
--

CREATE TABLE `year wise crop production` (
  `Financial Year` varchar(20) NOT NULL,
  `year_midpoint` decimal(5,1) NOT NULL,
  `crop_name` varchar(100) NOT NULL,
  `crop_type` varchar(100) NOT NULL,
  `area` decimal(10,5) DEFAULT 0.00000,
  `Total production` decimal(10,10) DEFAULT 0.0000000000,
  `Yield Rate` decimal(10,10) DEFAULT 0.0000000000
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `crops`
--
ALTER TABLE `crops`
  ADD PRIMARY KEY (`crop name`);

--
-- Indexes for table `district`
--
ALTER TABLE `district`
  ADD PRIMARY KEY (`District_name`);

--
-- Indexes for table `district wise production of crop`
--
ALTER TABLE `district wise production of crop`
  ADD KEY `Crop name` (`Crop name`);

--
-- Indexes for table `year wise crop production`
--
ALTER TABLE `year wise crop production`
  ADD KEY `crop_name` (`crop_name`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `district wise production of crop`
--
ALTER TABLE `district wise production of crop`
  ADD CONSTRAINT `district wise production of crop_ibfk_1` FOREIGN KEY (`Crop name`) REFERENCES `crops` (`crop name`);

--
-- Constraints for table `year wise crop production`
--
ALTER TABLE `year wise crop production`
  ADD CONSTRAINT `year wise crop production_ibfk_1` FOREIGN KEY (`crop_name`) REFERENCES `crops` (`crop name`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
