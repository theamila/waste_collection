-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 24, 2025 at 02:09 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.1.25

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

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `email`, `password`) VALUES
(2, 'admin', 'admin@example.com', 'aaa');

-- --------------------------------------------------------

--
-- Table structure for table `area`
--

CREATE TABLE `area` (
  `id` int(11) NOT NULL,
  `lane_no` varchar(50) NOT NULL,
  `description` text NOT NULL,
  `no_of_houses` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `area`
--

INSERT INTO `area` (`id`, `lane_no`, `description`, `no_of_houses`) VALUES
(1, '26/B', 'Kaduwela', 17),
(2, '26/A', 'Kaduwela', 10),
(3, '26/C', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 20);

-- --------------------------------------------------------

--
-- Table structure for table `assign_staff`
--

CREATE TABLE `assign_staff` (
  `id` int(11) NOT NULL,
  `employee_no` varchar(50) NOT NULL,
  `vehicle_no` varchar(50) NOT NULL,
  `date` date NOT NULL,
  `lane_no` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

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

CREATE TABLE `cleaning_staff` (
  `id` int(11) NOT NULL,
  `employee_no` varchar(50) NOT NULL,
  `name` varchar(100) NOT NULL,
  `mobile` varchar(15) NOT NULL,
  `type` enum('Collector','Driver') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

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

CREATE TABLE `garbage_collection_status` (
  `date` date NOT NULL,
  `time` time NOT NULL,
  `lane_no` varchar(50) NOT NULL,
  `bin_no` varchar(50) NOT NULL,
  `unit_no` int(11) NOT NULL,
  `phone_number` text NOT NULL,
  `remaining_weight` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `garbage_collection_status`
--

INSERT INTO `garbage_collection_status` (`date`, `time`, `lane_no`, `bin_no`, `unit_no`, `phone_number`, `remaining_weight`) VALUES
('2024-07-29', '08:00:00', '1', '115-197-142-244', 1, '0714992904', 350),
('2024-07-29', '09:30:00', '2', '35-129-119-15', 2, '0768040960', 600),
('2024-07-29', '11:00:00', '1', '115-197-142-200', 1, '0719796759', 200),
('2024-07-29', '13:00:00', '3', '35-129-119-150', 3, '0714992904', 750),
('2024-07-29', '15:30:00', '2', '115-197-142-288', 2, '0714992904', 400);

-- --------------------------------------------------------

--
-- Table structure for table `household_registration`
--

CREATE TABLE `household_registration` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `lane_no` varchar(50) NOT NULL,
  `house_no` varchar(50) NOT NULL,
  `bin_no` varchar(50) NOT NULL,
  `address` text NOT NULL,
  `mobile_number` varchar(15) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `household_registration`
--

INSERT INTO `household_registration` (`id`, `name`, `lane_no`, `house_no`, `bin_no`, `address`, `mobile_number`, `password`) VALUES
(7, 'Esitha Jayawardana', '26/ciawion', '196/1', '0', 'Samagi mw, Malagoda', '0123445664', 'aaa'),
(11, 'vsdvsd', '26/A', 'vsdvsdv', '0', 'dvdvsdvs', 'sdvsdv', 'dsvsdv'),
(12, 'Sujani', '26/A', '13', '0', 'No.13, Nagala, Bibile', '0719796759', 'suja'),
(13, 'su', '26/B', '13', '0', 'No.13, Pattiyawaththa, Nagala, Bibile', '0719796759', 'suja');

-- --------------------------------------------------------

--
-- Table structure for table `managers`
--

CREATE TABLE `managers` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

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

CREATE TABLE `schedule` (
  `id` int(11) NOT NULL,
  `lane_no` varchar(50) NOT NULL,
  `garbage_type` enum('Plastic','Biodegradable','E-waste') NOT NULL,
  `day` varchar(50) NOT NULL,
  `week` enum('Every week','First week','Second week','Third week','Fourth week') NOT NULL,
  `vehicle_no` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

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

CREATE TABLE `vehicle` (
  `id` int(11) NOT NULL,
  `vehicle_no` varchar(50) NOT NULL,
  `capacity` int(11) NOT NULL,
  `date` date NOT NULL,
  `status` enum('Available','Out of service','In service') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

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
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `area`
--
ALTER TABLE `area`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `assign_staff`
--
ALTER TABLE `assign_staff`
  ADD PRIMARY KEY (`id`),
  ADD KEY `employee_no` (`employee_no`),
  ADD KEY `vehicle_no` (`vehicle_no`);

--
-- Indexes for table `cleaning_staff`
--
ALTER TABLE `cleaning_staff`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `employee_no` (`employee_no`);

--
-- Indexes for table `household_registration`
--
ALTER TABLE `household_registration`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `managers`
--
ALTER TABLE `managers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `schedule`
--
ALTER TABLE `schedule`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vehicle`
--
ALTER TABLE `vehicle`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `vehicle_no` (`vehicle_no`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `area`
--
ALTER TABLE `area`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `assign_staff`
--
ALTER TABLE `assign_staff`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `cleaning_staff`
--
ALTER TABLE `cleaning_staff`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `household_registration`
--
ALTER TABLE `household_registration`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `managers`
--
ALTER TABLE `managers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `schedule`
--
ALTER TABLE `schedule`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `vehicle`
--
ALTER TABLE `vehicle`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

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
