-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 27, 2024 at 02:19 PM
-- Server version: 10.6.15-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `goerms_admin`
--

-- --------------------------------------------------------

--
-- Table structure for table `forms`
--

CREATE TABLE `forms` (
  `form_id` int(11) NOT NULL,
  `form_name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `forms`
--

INSERT INTO `forms` (`form_id`, `form_name`, `description`, `created_by`, `created_at`) VALUES
(1, 'STUDENT FORM', 'FOR STUDENTS.', 1, '2024-11-24 10:50:19'),
(2, 'BH FORM', 'FOR PURA BHOUSE', 1, '2024-11-25 04:53:54');

-- --------------------------------------------------------

--
-- Table structure for table `form_fields`
--

CREATE TABLE `form_fields` (
  `field_id` int(11) NOT NULL,
  `form_id` int(11) NOT NULL,
  `field_label` varchar(255) NOT NULL,
  `field_type` enum('text','textarea','number','radio','checkbox','dropdown','date') NOT NULL,
  `is_required` tinyint(1) DEFAULT 0,
  `options` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `form_fields`
--

INSERT INTO `form_fields` (`field_id`, `form_id`, `field_label`, `field_type`, `is_required`, `options`) VALUES
(1, 1, 'Name', 'text', 1, ''),
(2, 1, 'Gender', 'radio', 1, 'Male,Female'),
(3, 2, 'Name', 'text', 1, ''),
(4, 2, 'GENDER', 'radio', 1, 'Male,Female'),
(5, 2, 'Ratings', 'radio', 1, '1,2,3,4,5');

-- --------------------------------------------------------

--
-- Table structure for table `form_responses`
--

CREATE TABLE `form_responses` (
  `response_id` int(11) NOT NULL,
  `form_id` int(11) DEFAULT NULL,
  `field_id` int(11) DEFAULT NULL,
  `response` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `form_responses`
--

INSERT INTO `form_responses` (`response_id`, `form_id`, `field_id`, `response`, `created_at`) VALUES
(1, 1, 1, 'Walton ', '2024-11-24 11:24:43'),
(2, 1, 2, 'Male', '2024-11-24 11:24:43'),
(3, 1, 1, 'Cristine', '2024-11-24 11:33:52'),
(4, 1, 2, 'Female', '2024-11-24 11:33:52');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `forms`
--
ALTER TABLE `forms`
  ADD PRIMARY KEY (`form_id`);

--
-- Indexes for table `form_fields`
--
ALTER TABLE `form_fields`
  ADD PRIMARY KEY (`field_id`),
  ADD KEY `form_id` (`form_id`);

--
-- Indexes for table `form_responses`
--
ALTER TABLE `form_responses`
  ADD PRIMARY KEY (`response_id`),
  ADD KEY `form_id` (`form_id`),
  ADD KEY `field_id` (`field_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `forms`
--
ALTER TABLE `forms`
  MODIFY `form_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `form_fields`
--
ALTER TABLE `form_fields`
  MODIFY `field_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `form_responses`
--
ALTER TABLE `form_responses`
  MODIFY `response_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `form_fields`
--
ALTER TABLE `form_fields`
  ADD CONSTRAINT `form_fields_ibfk_1` FOREIGN KEY (`form_id`) REFERENCES `forms` (`form_id`) ON DELETE CASCADE;

--
-- Constraints for table `form_responses`
--
ALTER TABLE `form_responses`
  ADD CONSTRAINT `form_responses_ibfk_1` FOREIGN KEY (`form_id`) REFERENCES `forms` (`form_id`),
  ADD CONSTRAINT `form_responses_ibfk_2` FOREIGN KEY (`field_id`) REFERENCES `form_fields` (`field_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
