-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jul 02, 2025 at 01:19 AM
-- Server version: 8.0.41
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `user_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `category_rubric`
--

CREATE TABLE `category_rubric` (
  `cat_id` varchar(10) NOT NULL,
  `cat_rubric` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `category_rubric`
--

INSERT INTO `category_rubric` (`cat_id`, `cat_rubric`) VALUES
('C01', 'Demo 3'),
('C02', 'Reruai'),
('C03', 'Innovation');

--
-- Triggers `category_rubric`
--
DELIMITER $$
CREATE TRIGGER `before_insert_category` BEFORE INSERT ON `category_rubric` FOR EACH ROW BEGIN
    DECLARE new_id VARCHAR(10);
    DECLARE last_id INT;

    -- Get the last numeric part of cat_id
    SELECT COALESCE(MAX(CAST(SUBSTRING(cat_id, 2) AS UNSIGNED)), 0) + 1 INTO last_id FROM category_rubric;

    -- Format as C01, C02, etc.
    SET new_id = CONCAT('C', LPAD(last_id, 2, '0'));

    -- Assign to new row
    SET NEW.cat_id = new_id;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `criteria_demo3`
--

CREATE TABLE `criteria_demo3` (
  `criteria_demo3_id` int NOT NULL,
  `cat_id` varchar(10) NOT NULL,
  `aspect` varchar(100) NOT NULL,
  `demo_score1` varchar(250) DEFAULT NULL,
  `demo_score2` varchar(250) DEFAULT NULL,
  `demo_score3` varchar(250) DEFAULT NULL,
  `demo_score4` varchar(250) DEFAULT NULL,
  `weightage` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `criteria_demo3`
--

INSERT INTO `criteria_demo3` (`criteria_demo3_id`, `cat_id`, `aspect`, `demo_score1`, `demo_score2`, `demo_score3`, `demo_score4`, `weightage`) VALUES
(1, 'C01', 'PROJECT ACHIEVEMENT AND OBJECTIVE', 'Project is 100% complete and achieve all objectives', 'Project is more than 80% complete and achieve all objectives', 'Project is more than 50% complete and achieve a few objectives', 'Project is less than 50% complete and achieve only one objective', 12.5),
(2, 'C01', 'USER REQUIREMENTS', 'All requirements were met.', 'Several requirements were met', 'Only one requirement were met', 'No requirement were met', 12.5),
(3, 'C01', 'CONSTRUCTION AND FUNCTIONALITY', 'Excellently describes how the system was constructed and how it functions', 'Clearly describes how the system was constructed and how it functions', 'Moderately describes how the system was constructed and how it functions', 'Generally not clear describes how the system was constructed and how it functions', 12.5),
(4, 'C01', 'FEASIBILITY', 'Excellently communicated feasibility of construction and implementation most of the time', 'Clearly communicated feasibility of construction and implementation most of the time with minor error', 'Moderately communicated feasibility of construction and implementation most of the time with minor error', 'Generally not clear communicated feasibility of construction and implementation most of the time with minor error', 12.5),
(5, 'C01', 'ORIGINALITY', 'Product shows an excellent genuine idea', 'Product shows a good genuine idea', 'Product shows moderate amount of genuine idea', 'Copied product', 12.5),
(6, 'C01', 'MARKETABILITY', 'Provide strong evidence through market surveys AND have a client (with proof) OR recognition from outside parties (lab tested, MyIPO, testemonial)', 'Provide strong evidence such as market surveys OR have a client (with proof) OR recognition from outside parties', 'Provide a few evidence from both sources of newspapers, blogs, social media or etc', 'Least attempt is made for a market potential', 12.5),
(7, 'C01', 'CREATIVITY', 'Excellent ideas, creative and inventive.', 'Good ideas, creative and inventive.', 'Moderate ideas, creative and inventive.', 'Least creative ideas and inventive.', 12.5),
(8, 'C01', 'SYSTEM SECURITY, FEATURES AND TESTING', 'Excellent implementation of user controls and validation controls', 'Good implementation of user controls and validation controls', 'Moderate implementation of user controls and validation controls', 'Least implementation of user controls and validation controls', 12.5);

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `id` int NOT NULL,
  `event_name` varchar(255) NOT NULL,
  `semester_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`id`, `event_name`, `semester_id`) VALUES
(1, 'ICE', 2),
(2, 'Innovation', 2);

-- --------------------------------------------------------

--
-- Table structure for table `panels`
--

CREATE TABLE `panels` (
  `id` int NOT NULL,
  `event_id` int DEFAULT NULL,
  `user_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `panel_demo3_marks`
--

CREATE TABLE `panel_demo3_marks` (
  `id` int NOT NULL,
  `group_id` int NOT NULL,
  `criteria_id` int NOT NULL,
  `score` int NOT NULL,
  `total` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `panel_demo3_marks`
--

INSERT INTO `panel_demo3_marks` (`id`, `group_id`, `criteria_id`, `score`, `total`) VALUES
(1, 1, 1, 2, 6.25),
(2, 1, 2, 2, 6.25),
(3, 1, 3, 4, 12.5),
(4, 1, 4, 2, 6.25),
(5, 1, 5, 4, 12.5),
(6, 1, 6, 2, 6.25),
(7, 1, 7, 3, 9.375),
(8, 1, 8, 2, 6.25);

-- --------------------------------------------------------

--
-- Table structure for table `panel_demo3_total`
--

CREATE TABLE `panel_demo3_total` (
  `id` int NOT NULL,
  `group_id` int NOT NULL,
  `grand_total` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `panel_demo3_total`
--

INSERT INTO `panel_demo3_total` (`id`, `group_id`, `grand_total`) VALUES
(1, 1, 65.625);

-- --------------------------------------------------------

--
-- Table structure for table `semesters`
--

CREATE TABLE `semesters` (
  `id` int NOT NULL,
  `semester` varchar(50) NOT NULL,
  `year` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `semesters`
--

INSERT INTO `semesters` (`id`, `semester`, `year`) VALUES
(2, '2', '2024'),
(3, '1', '2025');

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `id` int NOT NULL,
  `matric_num` varchar(15) NOT NULL,
  `name` varchar(100) NOT NULL,
  `project_title` varchar(255) NOT NULL,
  `project_description` text NOT NULL,
  `supervisor_id` int DEFAULT NULL,
  `track` enum('SAD','NS','IS') NOT NULL,
  `semester_id` int DEFAULT NULL,
  `group_id` int DEFAULT NULL,
  `user_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `matric_num`, `name`, `project_title`, `project_description`, `supervisor_id`, `track`, `semester_id`, `group_id`, `user_id`) VALUES
(1, ' 01DDT22F2039', 'UMMU SYAHIDAH BINTI ABDURAHMAN', 'Kamsis', 'Kamsis PUO Politeknik Ungku Omar', 1, 'SAD', 2, 1, 4);

-- --------------------------------------------------------

--
-- Table structure for table `supervisors`
--

CREATE TABLE `supervisors` (
  `id` int NOT NULL,
  `name` varchar(100) NOT NULL,
  `track` enum('SAD','NS','IS') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `supervisors`
--

INSERT INTO `supervisors` (`id`, `name`, `track`) VALUES
(1, 'MAGESWARY A/P MUNIANDY', 'SAD');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `level_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `full_name`, `username`, `password`, `level_id`) VALUES
(1, 'MUNIRAH BINTI ABDULLAH', 'mun', '$2y$10$md1lCOJXNDx7bgWQt9qA1OH0./t3gzAvrQuEaC15ONvigsnddes7.', 1),
(2, 'NOR HANANI BINTI MOHD YUSOFF', 'nani', '$2y$10$st1y0ZarHZDAsCokK6UOae7sA/0G4WN60fCnUzd/V5jzG3QzAjfru', 2),
(4, 'HARISFAZILLAH BIN JAMEL ', 'haris', '$2y$10$6BPCw6sedS4krzFiGoTj/uJJGFPSAr4S/ehQcaJrlj.B6g8dVeKHG', 3);

-- --------------------------------------------------------

--
-- Table structure for table `user_levels`
--

CREATE TABLE `user_levels` (
  `id` int NOT NULL,
  `level_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `user_levels`
--

INSERT INTO `user_levels` (`id`, `level_name`) VALUES
(1, 'Admin'),
(4, 'Panel Booth'),
(3, 'Panel Demo 3'),
(5, 'Panel Innovation'),
(2, 'Unit Project');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `category_rubric`
--
ALTER TABLE `category_rubric`
  ADD PRIMARY KEY (`cat_id`);

--
-- Indexes for table `criteria_demo3`
--
ALTER TABLE `criteria_demo3`
  ADD PRIMARY KEY (`criteria_demo3_id`),
  ADD KEY `cat_id` (`cat_id`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`),
  ADD KEY `semester_id` (`semester_id`);

--
-- Indexes for table `panels`
--
ALTER TABLE `panels`
  ADD PRIMARY KEY (`id`),
  ADD KEY `event_id` (`event_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `panel_demo3_marks`
--
ALTER TABLE `panel_demo3_marks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `group_id` (`group_id`),
  ADD KEY `criteria_id` (`criteria_id`);

--
-- Indexes for table `panel_demo3_total`
--
ALTER TABLE `panel_demo3_total`
  ADD PRIMARY KEY (`id`),
  ADD KEY `group_id` (`group_id`);

--
-- Indexes for table `semesters`
--
ALTER TABLE `semesters`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `matric_num` (`matric_num`),
  ADD KEY `supervisor_id` (`supervisor_id`),
  ADD KEY `semester_id` (`semester_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `supervisors`
--
ALTER TABLE `supervisors`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD KEY `level_id` (`level_id`);

--
-- Indexes for table `user_levels`
--
ALTER TABLE `user_levels`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `level_name` (`level_name`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `criteria_demo3`
--
ALTER TABLE `criteria_demo3`
  MODIFY `criteria_demo3_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `panels`
--
ALTER TABLE `panels`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `panel_demo3_marks`
--
ALTER TABLE `panel_demo3_marks`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `panel_demo3_total`
--
ALTER TABLE `panel_demo3_total`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `semesters`
--
ALTER TABLE `semesters`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `supervisors`
--
ALTER TABLE `supervisors`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `user_levels`
--
ALTER TABLE `user_levels`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `criteria_demo3`
--
ALTER TABLE `criteria_demo3`
  ADD CONSTRAINT `criteria_demo3_ibfk_1` FOREIGN KEY (`cat_id`) REFERENCES `category_rubric` (`cat_id`) ON DELETE CASCADE;

--
-- Constraints for table `events`
--
ALTER TABLE `events`
  ADD CONSTRAINT `events_ibfk_1` FOREIGN KEY (`semester_id`) REFERENCES `semesters` (`id`);

--
-- Constraints for table `panels`
--
ALTER TABLE `panels`
  ADD CONSTRAINT `panels_ibfk_1` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`),
  ADD CONSTRAINT `panels_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `panel_demo3_marks`
--
ALTER TABLE `panel_demo3_marks`
  ADD CONSTRAINT `panel_demo3_marks_ibfk_1` FOREIGN KEY (`group_id`) REFERENCES `students` (`id`),
  ADD CONSTRAINT `panel_demo3_marks_ibfk_2` FOREIGN KEY (`criteria_id`) REFERENCES `criteria_demo3` (`criteria_demo3_id`);

--
-- Constraints for table `panel_demo3_total`
--
ALTER TABLE `panel_demo3_total`
  ADD CONSTRAINT `panel_demo3_total_ibfk_1` FOREIGN KEY (`group_id`) REFERENCES `students` (`id`);

--
-- Constraints for table `students`
--
ALTER TABLE `students`
  ADD CONSTRAINT `students_ibfk_1` FOREIGN KEY (`supervisor_id`) REFERENCES `supervisors` (`id`),
  ADD CONSTRAINT `students_ibfk_2` FOREIGN KEY (`semester_id`) REFERENCES `semesters` (`id`),
  ADD CONSTRAINT `students_ibfk_3` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`level_id`) REFERENCES `user_levels` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
