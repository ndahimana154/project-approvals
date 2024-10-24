-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 24, 2024 at 10:12 PM
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
-- Database: `project_approval`
--

-- --------------------------------------------------------

--
-- Table structure for table `project_members`
--

CREATE TABLE `project_members` (
  `id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `role` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `project_progress`
--

CREATE TABLE `project_progress` (
  `id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `progress_text` text NOT NULL,
  `screenshot` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `supervisor_comment` text DEFAULT NULL,
  `comment_file` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `project_progress`
--

INSERT INTO `project_progress` (`id`, `project_id`, `student_id`, `progress_text`, `screenshot`, `created_at`, `supervisor_comment`, `comment_file`) VALUES
(13, 20, 12, 'Hello this is the progress one.', '1729787251_0624cdf7f4.png', '2024-10-24 16:27:31', 'wefedfeddds', ''),
(14, 20, 12, 'ewferfgrfregre', '', '2024-10-24 18:38:34', NULL, ''),
(15, 20, 12, 'regregreregreg', '', '2024-10-24 18:38:36', NULL, ''),
(16, 20, 12, 'rgfverfgvrfgvrefgvregv fdvb dv', '', '2024-10-24 18:38:39', 'refvf', '../assets/project_files/1729799381_27603 KWIZERA Parfait Assignement_DBMS.pdf'),
(17, 20, 12, 'rgrfgfregreger', '1729800658_0cd989c822.png', '2024-10-24 20:10:58', NULL, '');

-- --------------------------------------------------------

--
-- Table structure for table `session`
--

CREATE TABLE `session` (
  `id` int(11) NOT NULL,
  `userID` int(11) DEFAULT NULL,
  `otp` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `session`
--

INSERT INTO `session` (`id`, `userID`, `otp`, `created_at`) VALUES
(7, 12, 151569, '2024-10-24 19:24:53');

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `id` int(11) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `regno` varchar(255) DEFAULT NULL,
  `class` varchar(255) DEFAULT NULL,
  `profilepicture` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `firstname`, `lastname`, `email`, `phone`, `password`, `regno`, `class`, `profilepicture`) VALUES
(12, 'Bonheur', 'NDAHIMANA', 'ndahimana154@gmail.com', '0788923011', '$2y$10$nCIsG7qbv024FTgcMIlSMuEd9RVQHIflr5EXS9iDcImhAZPkM6BaS', '244FD', 'Software dev', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `studentsprojects`
--

CREATE TABLE `studentsprojects` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `file_name` text NOT NULL,
  `student_id` int(11) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `created_at` varchar(255) NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `studentsprojects`
--

INSERT INTO `studentsprojects` (`id`, `title`, `description`, `file_name`, `student_id`, `status`, `created_at`) VALUES
(20, 'Starting project', 'This is the project description', '671a755d23e8f7.00238639_Udacity ceritifacete.pdf', 12, 'Accepted', '2024-10-24 18:27:09');

-- --------------------------------------------------------

--
-- Table structure for table `supervisor_project_assignment`
--

CREATE TABLE `supervisor_project_assignment` (
  `id` int(11) NOT NULL,
  `supervisor_id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `assigned_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `supervisor_project_assignment`
--

INSERT INTO `supervisor_project_assignment` (`id`, `supervisor_id`, `project_id`, `assigned_date`) VALUES
(7, 10, 20, '2024-10-24 18:34:11');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `names` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `names`, `email`, `password`, `role`) VALUES
(7, 'admin', 'ndahimana154@gmail.com', '$2y$10$.khre2erG2iX7ThX.tIhiOaL8383gCIfdn/0jJBRAiqdVoybikHeC', 'admin'),
(10, 'SUper', 'supervisor1@gmail.com', '1234', 'supervisor');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `project_members`
--
ALTER TABLE `project_members`
  ADD PRIMARY KEY (`id`),
  ADD KEY `project_id` (`project_id`),
  ADD KEY `student_id` (`student_id`);

--
-- Indexes for table `project_progress`
--
ALTER TABLE `project_progress`
  ADD PRIMARY KEY (`id`),
  ADD KEY `project_id` (`project_id`),
  ADD KEY `student_id` (`student_id`);

--
-- Indexes for table `session`
--
ALTER TABLE `session`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `studentsprojects`
--
ALTER TABLE `studentsprojects`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sdifugnrefini` (`student_id`);

--
-- Indexes for table `supervisor_project_assignment`
--
ALTER TABLE `supervisor_project_assignment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `dcewwed` (`project_id`),
  ADD KEY `dcwoijiocew` (`supervisor_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `project_members`
--
ALTER TABLE `project_members`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `project_progress`
--
ALTER TABLE `project_progress`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `session`
--
ALTER TABLE `session`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `studentsprojects`
--
ALTER TABLE `studentsprojects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `supervisor_project_assignment`
--
ALTER TABLE `supervisor_project_assignment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `project_members`
--
ALTER TABLE `project_members`
  ADD CONSTRAINT `project_members_ibfk_1` FOREIGN KEY (`project_id`) REFERENCES `studentsprojects` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `project_members_ibfk_2` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `project_progress`
--
ALTER TABLE `project_progress`
  ADD CONSTRAINT `project_progress_ibfk_1` FOREIGN KEY (`project_id`) REFERENCES `studentsprojects` (`id`),
  ADD CONSTRAINT `project_progress_ibfk_2` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`);

--
-- Constraints for table `studentsprojects`
--
ALTER TABLE `studentsprojects`
  ADD CONSTRAINT `sdifugnrefini` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `supervisor_project_assignment`
--
ALTER TABLE `supervisor_project_assignment`
  ADD CONSTRAINT `dcewwed` FOREIGN KEY (`project_id`) REFERENCES `studentsprojects` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `dcwoijiocew` FOREIGN KEY (`supervisor_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
