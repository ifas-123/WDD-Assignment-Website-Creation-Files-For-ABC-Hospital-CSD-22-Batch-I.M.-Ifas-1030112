-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 15, 2024 at 06:22 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `abc_hospital`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `admin_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`admin_id`, `name`, `email`, `password`) VALUES
(1, 'ifasadmin', 'ifasadmin@gmail.com', '$2y$10$0caZ.Zslu59Hf3islZx1Bu0lY7HAVmVW5FkY9oUGPs45mHzH.acuC');

-- --------------------------------------------------------

--
-- Table structure for table `appointment`
--

CREATE TABLE `appointment` (
  `appointment_id` int(11) NOT NULL,
  `reference_number` varchar(20) NOT NULL,
  `patient_name` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `contact_no` varchar(15) NOT NULL,
  `specialization` enum('Cardiologist','Neurologist','Pediatrician','Dermatologist','Orthopedic Surgeon','Gastroenterologist','Oncologist','Psychiatrist','Obstetrician/Gynecologist(OB/GYN)','Endocrinologist') NOT NULL,
  `doctor_name` varchar(100) NOT NULL,
  `avilability_time` varchar(150) NOT NULL,
  `reason` varchar(1000) NOT NULL,
  `status` enum('confirmed','rejected','pending') NOT NULL DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `appointment`
--

INSERT INTO `appointment` (`appointment_id`, `reference_number`, `patient_name`, `email`, `contact_no`, `specialization`, `doctor_name`, `avilability_time`, `reason`, `status`) VALUES
(17, 'REF-675ef74c5b6f2', 'patient 01', 'patient01@gmail.com', '0776636447', 'Cardiologist', 'doctor 01', '2024-12-12T21:05', 'fever', 'rejected'),
(18, 'REF-675f08b2e8ba4', 'patient 02', 'patient02@gmail.com', '0778855444', 'Neurologist', 'doctor 02', '2024-12-10T22:18', 'test', 'confirmed'),
(19, 'REF-675f0e3f6f382', 'patient 03', 'patient03@gmail.com', '0778855112', 'Cardiologist', 'doctor 01', '2024-12-09T22:43', 'test 02', 'pending');

-- --------------------------------------------------------

--
-- Table structure for table `doctor`
--

CREATE TABLE `doctor` (
  `doctor_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password` varchar(150) NOT NULL,
  `contact_no` varchar(15) NOT NULL,
  `gender` enum('male','female','other') NOT NULL,
  `specialization` enum('Cardiologist','Neurologist','Pediatrician','Dermatologist','Orthopedic Surgeon','Gastroenterologist','Oncologist','Psychiatrist','Obstetrician/Gynecologist(OB/GYN)','Endocrinologist') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `doctor`
--

INSERT INTO `doctor` (`doctor_id`, `name`, `email`, `password`, `contact_no`, `gender`, `specialization`) VALUES
(13, 'doctor 01', 'doctor01@gmail.com', '$2y$10$rJaXvrYq84ttjssWK6af4e4oiGJGQaiFtm.2Q35SRoNOgC0F6U2Xq', '0774545662', 'male', 'Cardiologist'),
(14, 'doctor 02', 'doctor02@gmail.com', '$2y$10$jkKclrJsOP14/d7VMsgf1e99pTnZwA7Mbme.jNTgtAkvCDciV2VMq', '0775566777', 'male', 'Neurologist');

-- --------------------------------------------------------

--
-- Table structure for table `receptionist`
--

CREATE TABLE `receptionist` (
  `receptionist_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password` varchar(150) NOT NULL,
  `contact_no` varchar(15) NOT NULL,
  `gender` enum('male','female','other') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `receptionist`
--

INSERT INTO `receptionist` (`receptionist_id`, `name`, `email`, `password`, `contact_no`, `gender`) VALUES
(13, 'receptionist 01', 'receptionist01@gmail.com', '$2y$10$C5NTFi8Wsg2fqTs7Cnxtu.p9xuAlpz8U.iTC8sEwsIvVMjwix.PWC', '0775525787', 'female'),
(14, 'receptionist 02', 'receptionist02@gmail.com', '$2y$10$BtQ9qH0DzzQkh47bU75ihuaz81ZSgXV5Hmx22u0wT.qC697tqaH9e', '0774455666', 'male');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `appointment`
--
ALTER TABLE `appointment`
  ADD PRIMARY KEY (`appointment_id`),
  ADD UNIQUE KEY `reference_number` (`reference_number`);

--
-- Indexes for table `doctor`
--
ALTER TABLE `doctor`
  ADD PRIMARY KEY (`doctor_id`);

--
-- Indexes for table `receptionist`
--
ALTER TABLE `receptionist`
  ADD PRIMARY KEY (`receptionist_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `appointment`
--
ALTER TABLE `appointment`
  MODIFY `appointment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `doctor`
--
ALTER TABLE `doctor`
  MODIFY `doctor_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `receptionist`
--
ALTER TABLE `receptionist`
  MODIFY `receptionist_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
