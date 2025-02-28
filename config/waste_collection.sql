-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Feb 27, 2025 at 06:01 PM
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
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `area`
--

INSERT INTO `area` (`id`, `lane_no`, `unit_no`, `description`, `no_of_houses`) VALUES
(11, '20/C', 3, 'Kaduwela', 37),
(13, '21/A', 4, 'Kiribathgoda', 60),
(15, '20/A', 5, 'Kiribathgoda', 43),
(16, '26/B', 1, 'Kiribathgoda', 43);

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
(5, 'E120', 'V001', '2025-02-10', '26/B'),
(7, 'E121', 'V002', '2025-02-15', '26/C'),
(8, 'E121', 'V002', '2025-02-15', '26/C'),
(9, 'E121', 'V002', '2025-02-15', '26/C'),
(11, 'E121', 'V002', '2025-02-15', '26/C');

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
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cleaning_staff`
--

INSERT INTO `cleaning_staff` (`id`, `employee_no`, `name`, `mobile`, `type`) VALUES
(1, 'E121', 'Saman Kumara Rajakaruna', '+94719796759', 'Driver'),
(17, 'E120', 'Dilshan Kumara', '0718987654', 'Collector'),
(26, 'E100', 'Dumindu Silva', '0719876541', 'Driver'),
(27, 'E99', 'Nimal Kumara', '0719876543', 'Collector');

-- --------------------------------------------------------

--
-- Table structure for table `garbage_collection_status`
--

DROP TABLE IF EXISTS `garbage_collection_status`;
CREATE TABLE IF NOT EXISTS `garbage_collection_status` (
  `date` date NOT NULL,
  `time` time NOT NULL,
  `bin_no` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `remaining_weight` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `garbage_collection_status`
--

INSERT INTO `garbage_collection_status` (`date`, `time`, `bin_no`, `remaining_weight`) VALUES
('2024-07-29', '08:00:00', '115-197-142-244', 350),
('2024-07-29', '09:30:00', '35-129-119-15', 600),
('2024-07-29', '11:00:00', '115-197-142-200', 200),
('2024-07-29', '13:00:00', '35-129-119-150', 750),
('2024-07-29', '15:30:00', '115-197-142-288', 400);

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
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `household_registration`
--

INSERT INTO `household_registration` (`id`, `name`, `lane_no`, `house_no`, `bin_no`, `address`, `description`, `mobile_number`, `email`, `password`) VALUES
(7, 'Esitha Jayawardana', '26/ciawion', '196/1', '0', 'Samagi mw, Malagoda', '', '0123445664', 'esi@gmail.com', 'aaa'),
(11, 'vsdvsd', '26/A', 'vsdvsdv', '0', 'dvdvsdvs', '', 'sdvsdv', '', 'dsvsdv'),
(12, 'Sujani', '26/A', '13', '0', 'No.13, Nagala, Bibile', '', '0719796759', '', 'suja'),
(13, 'sujani', '26/B', '13', '115-197-142-244', 'Kaduwela', '', '94719796759', 'su@gmail.com', 'suja'),
(14, 'Ria', '20/B', '7', '115-197-142-280', 'asd', '', '94712339087', 'ria@gmail.com', '123'),
(15, 'Diana', '20/B', '8', '115-197-142-000', 'sss', '', '94718987654', 'diana@gmail.com', ''),
(16, 'Ima', '20/B', '9', '115-197-142-001', 'kkk', '', '94987654321', 'ima@gmail.com', ''),
(17, 'Parami Perera', '20/B', '11', '115-197-142-003', 'asw', '', '94987654321', 'para@gmail.com', '123'),
(18, 'Anusha Perera', '26/B', '8', '115-197-142-244', 'Kaduwela', 'Kaduwela', '94714992904', 'anu@gmail.com', '123'),
(19, 'Diana', '26/B', '12', '115-197-142-288', 'sss', NULL, '94718987654', 'd@gmail.com', '123');

-- --------------------------------------------------------

--
-- Table structure for table `location`
--

DROP TABLE IF EXISTS `location`;
CREATE TABLE IF NOT EXISTS `location` (
  `lane_no` varchar(50) NOT NULL,
  `link` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `location`
--

INSERT INTO `location` (`lane_no`, `link`) VALUES
('26/A', 'https://mon-backend.azurewebsites.net/worldmap?unit_id=1'),
('26/B', 'https://mon-backend.azurewebsites.net/worldmap?unit_id=2'),
('25/C', 'https://mon-backend.azurewebsites.net/worldmap?unit_id=3'),
('20/A', 'https://mon-backend.azurewebsites.net/worldmap?unit_id=4'),
('20/B', 'https://mon-backend.azurewebsites.net/worldmap?unit_id=5');

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
(1, 'manager1@m.com', 'aaa'),
(2, 'manager2@m.com', 'aaa'),
(3, 'ama@yahoo.com', 'ama');

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
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `schedule`
--

INSERT INTO `schedule` (`id`, `lane_no`, `garbage_type`, `day`, `week`, `vehicle_no`) VALUES
(3, '26/C', 'E-waste', '2024-12-20', 'Third week', 'V001'),
(4, '26/A', 'Plastic', '2024-12-19', 'Every week', 'V001'),
(5, '26/A', 'Biodegradable', '2024-12-19', 'Every week', 'V001'),
(7, '26/A', 'Plastic', '2024-12-19', 'Every week', 'V001'),
(9, '26/B', 'Plastic', '2025-02-18', 'First week', 'V001');

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
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `vehicle`
--

INSERT INTO `vehicle` (`id`, `vehicle_no`, `capacity`, `date`, `status`) VALUES
(1, 'V001', 5000, '2024-12-13', 'Available'),
(2, 'V002', 1200, '2022-05-10', 'Available'),
(3, 'V003', 1500, '2024-03-02', 'In service'),
(4, 'V005', 1100, '2023-07-25', 'Out of service'),
(7, 'V010', 1200, '2024-04-10', 'In service');

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
