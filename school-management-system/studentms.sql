-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Mar 22, 2024 at 10:08 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `studentms`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `admin_id` int(11) NOT NULL,
  `email` varchar(320) NOT NULL,
  `password` varchar(20) NOT NULL,
  `salt` varchar(220) NOT NULL,
  `fname` varchar(220) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`admin_id`, `email`, `password`, `salt`, `fname`) VALUES
(1, 'admin1@gmail.com', '6b', '89e0dace77f85766ed4f923d801fc73f', 'Sam Newson');

-- --------------------------------------------------------

--
-- Table structure for table `classes`
--

CREATE TABLE `classes` (
  `class_id` int(11) NOT NULL,
  `class` varchar(50) NOT NULL,
  `year` int(7) NOT NULL,
  `current_assignment` varchar(40) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `classes`
--

INSERT INTO `classes` (`class_id`, `class`, `year`, `current_assignment`) VALUES
(1, '7A-eng', 7, 'fihu32ig'),
(2, '7B-phy', 7, 'sdg'),
(8, '8A-mat', 8, NULL),
(9, '8B-phy', 8, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `notices`
--

CREATE TABLE `notices` (
  `event_id` int(11) NOT NULL,
  `event` varchar(200) NOT NULL,
  `description` varchar(300) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notices`
--

INSERT INTO `notices` (`event_id`, `event`, `description`, `date`) VALUES
(1, 'international day', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed ex tellus, ullamcorper vel elementum vel, rhoncus quis tortor. Mauris viverra metus ligula. Proin ut augue felis. Vivamus ultricies velit ut lacus tincidunt, nec ultricies arcu pretium. ', '2024-03-20'),
(4, 'Year 13 prom', 'prom', '2024-05-03');

-- --------------------------------------------------------

--
-- Table structure for table `setting`
--

CREATE TABLE `setting` (
  `id` int(11) NOT NULL,
  `current_year` int(11) NOT NULL,
  `current_term` int(1) NOT NULL,
  `school_name` varchar(40) NOT NULL,
  `slogan` varchar(300) NOT NULL,
  `about` varchar(600) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `setting`
--

INSERT INTO `setting` (`id`, `current_year`, `current_term`, `school_name`, `slogan`, `about`) VALUES
(1, 2024, 2, 'Test School ', 'Test slogan', 'Test about');

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `student_id` int(11) NOT NULL,
  `email` varchar(320) NOT NULL,
  `password` varchar(20) NOT NULL,
  `salt` varchar(220) NOT NULL,
  `fname` varchar(320) NOT NULL,
  `lname` varchar(200) NOT NULL,
  `classes` varchar(200) NOT NULL,
  `year` int(11) NOT NULL,
  `date_of_birth` date NOT NULL,
  `joining_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`student_id`, `email`, `password`, `salt`, `fname`, `lname`, `classes`, `year`, `date_of_birth`, `joining_date`) VALUES
(5, 'student1@gmail.com', '6b', '89e0dace77f85766ed4f923d801fc73f', 'studefjf', 'fhh', '7A-eng,7B-phy', 7, '2012-02-15', '2024-03-18 18:27:02'),
(7, 'sumeetmishra@outlook.com', '31', '8b6ac426ff10ee5e0a0c8310a6b15273', 'Sumeet', 'Mishra', '7A-eng,7B-phy', 7, '2024-03-09', '2024-03-19 06:14:36'),
(8, 'adams@gmail.com', '39', '0e2dc173a31dabcccb3e1ba802f69d83', 'Adam ', 'Sakr', '8A-mat', 8, '2005-09-06', '2024-03-21 04:38:43');

-- --------------------------------------------------------

--
-- Table structure for table `student_score`
--

CREATE TABLE `student_score` (
  `term` varchar(100) NOT NULL,
  `year` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `teacher_id` int(11) NOT NULL,
  `subject_id` int(11) NOT NULL,
  `results` varchar(512) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student_score`
--

INSERT INTO `student_score` (`term`, `year`, `student_id`, `teacher_id`, `subject_id`, `results`) VALUES
('2', 2024, 5, 6, 1, '56 80,60 80,40 80,30 50,');

-- --------------------------------------------------------

--
-- Table structure for table `subjects`
--

CREATE TABLE `subjects` (
  `subject_id` int(11) NOT NULL,
  `subject` varchar(50) NOT NULL,
  `subject_code` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `subjects`
--

INSERT INTO `subjects` (`subject_id`, `subject`, `subject_code`) VALUES
(1, 'English', 'eng'),
(2, 'Physics', 'phy'),
(3, 'Maths', 'mat'),
(5, 'Biology', 'bio');

-- --------------------------------------------------------

--
-- Table structure for table `teachers`
--

CREATE TABLE `teachers` (
  `teacher_id` int(11) NOT NULL,
  `email` varchar(320) NOT NULL,
  `password` varchar(20) NOT NULL,
  `salt` varchar(220) NOT NULL,
  `fname` text NOT NULL,
  `lname` varchar(220) NOT NULL,
  `subjects` varchar(50) NOT NULL,
  `classes` varchar(50) NOT NULL,
  `date_of_birth` date NOT NULL,
  `phone_number` int(31) NOT NULL,
  `qualification` varchar(127) NOT NULL,
  `joining_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `teachers`
--

INSERT INTO `teachers` (`teacher_id`, `email`, `password`, `salt`, `fname`, `lname`, `subjects`, `classes`, `date_of_birth`, `phone_number`, `qualification`, `joining_date`) VALUES
(6, 'teacher1@gmail.com', '3d', '3b0a3712c867b6deb79f94f071c88426', 'Teacher', '1', '1,2', '7A-eng,7B-phy', '1997-02-05', 508579849, 'Bsc physics', '2024-03-19 18:04:20'),
(7, 'teacher2@gmail.com', '35', '1b5f7d91565605bc413d3718087b0c28', 'Teacher', '2', '1', '7A-eng', '2024-03-22', 508579283, 'Bsc Media Studies', '2024-03-19 18:11:24'),
(9, 'teacher3@gmail.com', '3a', '75e32fe98e58d9800cb64334357fd14c', 'Teacher', '3', '3', '8A-mat', '2024-03-15', 569876543, 'Bsc Media Studies', '2024-03-21 08:30:31');

-- --------------------------------------------------------

--
-- Table structure for table `year`
--

CREATE TABLE `year` (
  `year` varchar(7) NOT NULL,
  `num_students` int(111) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `year`
--

INSERT INTO `year` (`year`, `num_students`) VALUES
('10', 110),
('7', 100),
('8', 150),
('9', 100);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `classes`
--
ALTER TABLE `classes`
  ADD PRIMARY KEY (`class_id`);

--
-- Indexes for table `notices`
--
ALTER TABLE `notices`
  ADD PRIMARY KEY (`event_id`);

--
-- Indexes for table `setting`
--
ALTER TABLE `setting`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`student_id`);

--
-- Indexes for table `student_score`
--
ALTER TABLE `student_score`
  ADD PRIMARY KEY (`term`,`year`,`student_id`,`teacher_id`,`subject_id`),
  ADD KEY `student_id` (`student_id`);

--
-- Indexes for table `subjects`
--
ALTER TABLE `subjects`
  ADD PRIMARY KEY (`subject_id`);

--
-- Indexes for table `teachers`
--
ALTER TABLE `teachers`
  ADD PRIMARY KEY (`teacher_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `year`
--
ALTER TABLE `year`
  ADD PRIMARY KEY (`year`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `classes`
--
ALTER TABLE `classes`
  MODIFY `class_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `notices`
--
ALTER TABLE `notices`
  MODIFY `event_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `setting`
--
ALTER TABLE `setting`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `student_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `subjects`
--
ALTER TABLE `subjects`
  MODIFY `subject_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `teachers`
--
ALTER TABLE `teachers`
  MODIFY `teacher_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `student_score`
--
ALTER TABLE `student_score`
  ADD CONSTRAINT `student_score_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`student_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
