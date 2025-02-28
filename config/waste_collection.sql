-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Feb 28, 2025 at 01:22 PM
-- Server version: 8.0.40
-- PHP Version: 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `waste_collection`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

DROP TABLE IF EXISTS `admin`;
CREATE TABLE IF NOT EXISTS `admin` (
  `id` int NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `email`, `password`) VALUES
(2, 'admin', 'admin@example.com', 'aaa');

-- --------------------------------------------------------

--
-- Table structure for table `area`
--

DROP TABLE IF EXISTS `area`;
CREATE TABLE IF NOT EXISTS `area` (
  `id` int NOT NULL AUTO_INCREMENT,
  `lane_no` varchar(50) NOT NULL,
  `unit_no` int NOT NULL,
  `description` text NOT NULL,
  `no_of_houses` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `area`
--

INSERT INTO `area` (`id`, `lane_no`, `unit_no`, `description`, `no_of_houses`) VALUES
(11, '1', 1, 'Asiri Mawatha', 34),
(13, '2', 2, 'Samagi Mawatha', 60),
(15, '3', 3, 'Wasana Mawatha', 43),
(16, '4', 4, 'Perera Mawatha', 40),
(17, '5', 5, 'Dalugama Mawatha', 30);

-- --------------------------------------------------------

--
-- Table structure for table `assign_staff`
--

DROP TABLE IF EXISTS `assign_staff`;
CREATE TABLE IF NOT EXISTS `assign_staff` (
  `id` int NOT NULL AUTO_INCREMENT,
  `employee_no` varchar(50) NOT NULL,
  `vehicle_no` varchar(50) NOT NULL,
  `date` date NOT NULL,
  `lane_no` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `employee_no` (`employee_no`),
  KEY `vehicle_no` (`vehicle_no`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `assign_staff`
--

INSERT INTO `assign_staff` (`id`, `employee_no`, `vehicle_no`, `date`, `lane_no`) VALUES
(5, 'E120', 'V001', '2025-02-10', '1'),
(7, 'E121', 'V002', '2025-02-15', '2'),
(8, 'E103', 'V006', '2025-02-15', '1'),
(9, 'E99', 'V002', '2025-02-15', '2'),
(11, 'E100', 'V001', '2025-02-15', '1');

-- --------------------------------------------------------

--
-- Table structure for table `cleaning_staff`
--

DROP TABLE IF EXISTS `cleaning_staff`;
CREATE TABLE IF NOT EXISTS `cleaning_staff` (
  `id` int NOT NULL AUTO_INCREMENT,
  `employee_no` varchar(50) NOT NULL,
  `name` varchar(100) NOT NULL,
  `mobile` varchar(15) NOT NULL,
  `type` enum('Collector','Driver') NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `employee_no` (`employee_no`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cleaning_staff`
--

INSERT INTO `cleaning_staff` (`id`, `employee_no`, `name`, `mobile`, `type`) VALUES
(1, 'E121', 'Saman Kumara Rajakaruna', '+94719796759', 'Driver'),
(17, 'E120', 'Dilshan Kumara', '0718987654', 'Collector'),
(26, 'E100', 'Dumindu Silva', '0719876541', 'Driver'),
(27, 'E99', 'Nimal Kumara', '0719876543', 'Collector'),
(28, 'E101', 'Thusitha Perera', '+94714992904', 'Driver'),
(29, 'E102', 'Nuwan Silva', '+94718987654', 'Driver'),
(30, 'E103', 'Nuwan Perera', '+94718987655', 'Collector');

-- --------------------------------------------------------

--
-- Table structure for table `garbage_collection_status`
--

DROP TABLE IF EXISTS `garbage_collection_status`;
CREATE TABLE IF NOT EXISTS `garbage_collection_status` (
  `date` date NOT NULL,
  `time` time NOT NULL,
  `bin_no` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `remaining_weight` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `household_registration`
--

DROP TABLE IF EXISTS `household_registration`;
CREATE TABLE IF NOT EXISTS `household_registration` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `lane_no` varchar(50) NOT NULL,
  `house_no` varchar(50) NOT NULL,
  `bin_no` varchar(50) NOT NULL,
  `address` text NOT NULL,
  `description` varchar(200) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `mobile_number` varchar(15) NOT NULL,
  `email` varchar(150) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `household_registration`
--

INSERT INTO `household_registration` (`id`, `name`, `lane_no`, `house_no`, `bin_no`, `address`, `description`, `mobile_number`, `email`, `password`) VALUES
(1, 'Lahiru', '1', '1', '35-129-119-15', 'No.25,Asiri Mawatha,Maththegoda', 'Asiri mawatha', '94774436904', 'lahirumadsnka@gmail.com', '123'),
(2, 'Ayesha', '1', '2', '201-159-185-15', 'No.24,Asiri Mawatha,Maththegoda', 'Asiri mawatha', '94710447446', 'ayeshanpathirana@gmail.com', '123');

-- --------------------------------------------------------

--
-- Table structure for table `location`
--

DROP TABLE IF EXISTS `location`;
CREATE TABLE IF NOT EXISTS `location` (
  `lane_no` varchar(50) NOT NULL,
  `link` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `location`
--

INSERT INTO `location` (`lane_no`, `link`) VALUES
('1', 'https://mon-backend.azurewebsites.net/worldmap?unit_id=1'),
('2', 'https://mon-backend.azurewebsites.net/worldmap?unit_id=1'),
('3', 'https://mon-backend.azurewebsites.net/worldmap?unit_id=1'),
('4', 'https://mon-backend.azurewebsites.net/worldmap?unit_id=1'),
('5', 'https://mon-backend.azurewebsites.net/worldmap?unit_id=1');

-- --------------------------------------------------------

--
-- Table structure for table `managers`
--

DROP TABLE IF EXISTS `managers`;
CREATE TABLE IF NOT EXISTS `managers` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `managers`
--

INSERT INTO `managers` (`id`, `username`, `password`) VALUES
(1, 'Amal', 'qqq'),
(2, 'Silva', 'aaa'),
(3, 'Ameesha', 'Amali');

-- --------------------------------------------------------

--
-- Table structure for table `schedule`
--

DROP TABLE IF EXISTS `schedule`;
CREATE TABLE IF NOT EXISTS `schedule` (
  `id` int NOT NULL AUTO_INCREMENT,
  `lane_no` varchar(50) NOT NULL,
  `garbage_type` enum('Plastic','Biodegradable','E-waste') NOT NULL,
  `day` varchar(50) NOT NULL,
  `week` enum('Every week','First week','Second week','Third week','Fourth week') NOT NULL,
  `vehicle_no` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `schedule`
--

INSERT INTO `schedule` (`id`, `lane_no`, `garbage_type`, `day`, `week`, `vehicle_no`) VALUES
(3, '1', 'Biodegradable', '2025-03-01', 'Third week', 'V001'),
(4, '1', 'E-waste', '2025-03-15', 'Every week', 'V006'),
(5, '2', 'Biodegradable', '2025-03-12', 'Every week', 'V001'),
(7, '2', 'Plastic', '2025-03-14', 'Every week', 'V001'),
(9, '2', 'E-waste', '2025-03-25', 'First week', 'V004'),
(10, '1', 'Plastic', '2025-03-04', 'Every week', 'V002');

-- --------------------------------------------------------

--
-- Table structure for table `vehicle`
--

DROP TABLE IF EXISTS `vehicle`;
CREATE TABLE IF NOT EXISTS `vehicle` (
  `id` int NOT NULL AUTO_INCREMENT,
  `vehicle_no` varchar(50) NOT NULL,
  `capacity` int NOT NULL,
  `date` date NOT NULL,
  `status` enum('Available','Out of service','In service') NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `vehicle_no` (`vehicle_no`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `vehicle`
--

INSERT INTO `vehicle` (`id`, `vehicle_no`, `capacity`, `date`, `status`) VALUES
(1, 'V001', 5000, '2024-12-13', 'Available'),
(2, 'V002', 1200, '2022-05-10', 'Available'),
(3, 'V003', 1500, '2024-03-02', 'In service'),
(4, 'V005', 1100, '2023-07-25', 'Out of service'),
(7, 'V006', 1200, '2024-04-10', 'Available'),
(8, 'V004', 4000, '2023-07-11', 'Available');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `assign_staff`
--
ALTER TABLE `assign_staff`
  ADD CONSTRAINT `assign_staff_ibfk_1` FOREIGN KEY (`employee_no`) REFERENCES `cleaning_staff` (`employee_no`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `assign_staff_ibfk_2` FOREIGN KEY (`vehicle_no`) REFERENCES `vehicle` (`vehicle_no`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
