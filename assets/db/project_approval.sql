-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 07, 2024 at 03:06 AM
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

--
-- Dumping data for table `project_members`
--

INSERT INTO `project_members` (`id`, `project_id`, `student_id`, `role`) VALUES
(1, 2, 5, 'COntent creator'),
(2, 2, 5, 'COntent creator'),
(3, 2, 7, 'COntent creator');

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
  `supervisor_comment` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `project_progress`
--

INSERT INTO `project_progress` (`id`, `project_id`, `student_id`, `progress_text`, `screenshot`, `created_at`, `supervisor_comment`) VALUES
(1, 16, 3, 'refrefre', '', '2024-10-07 00:21:29', NULL),
(2, 16, 3, 'edcwecew', '', '2024-10-07 00:22:01', NULL),
(3, 16, 3, 'dcdsdd', '1728260682_aaa.jpg', '2024-10-07 00:24:42', NULL),
(4, 16, 3, 'dcdsdd', '1728260808_e87de422a5.jpg', '2024-10-07 00:26:48', NULL),
(5, 16, 3, 'dcdsdd', '1728260901_021467ec39.jpg', '2024-10-07 00:28:21', NULL),
(6, 16, 3, 'dcdsdd', '1728261058_59fdc602c5.jpg', '2024-10-07 00:30:58', NULL),
(7, 7, 3, 'dfefrfer', '1728261625_1c5bfa2b0d.jpg', '2024-10-07 00:40:25', 'New comment can be add?'),
(9, 17, 3, 'fefcre', '1728262515_67b52134ed.jpg', '2024-10-07 00:55:15', 'rerefd fdvf');

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
(3, 'dd', 'aaff', 'ndahimana154@gmail.com', '0788923011', '$2y$10$FJQrqe0ubUfiLNy5ZjPu1e9P.mXZTSbu8VLIolF6AjCU4MLQEGWRC', 'PWO220', '1234', '3_1728209043.png'),
(4, 'Bonheur', 'NDAHIMANA', 'ndahimana1534@gmail.com', '0788923011', '$2y$10$sIx65i0azJyBAlV7ZqIjheuGlHOOr1MOuYMndpFVz4yn3p3xqvlQG', '', '', ''),
(5, 'woij', 'oijoij', 'ojiojoi@efefe.efef', 'opkjij', '$2y$10$5XCB/r0d5BttidFVLPX/xuXhi4n1gk3jQAYO0E041L5WphGv1SFz6', NULL, NULL, NULL),
(6, 'ioj', 'oijiojiojio', 'ijoi@rvr.rvrf', '2939', '$2y$10$ZykZZ9vOovRXvBdzCP4kB.BSMM7nYQj1TH0vF.sOvs.UuoUAneU5y', NULL, NULL, NULL),
(7, 'qoij', 'ioj', 'iojiojioj@ee.e', 'opj', '$2y$10$tG3xhej4Svwz.rKO9jKW4ehU.BK/Uvq3C1dLbL0UiZNo4eo1.yDoq', NULL, NULL, NULL);

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
(1, 'dfW', 'JNIUN', 'BOOKS.YOSSR.COM-Finish-What-You-Start.pdf', 3, 'Rejected', '2024-10-06 02:56:08'),
(2, 'oeij', 'iojioj oij', 'BOOKS.YOSSR.COM-Finish-What-You-Start.pdf', 3, 'Accepted', '2024-10-06 02:56:08'),
(3, 'oeij', 'iojioj oij', 'BOOKS.YOSSR.COM-Finish-What-You-Start.pdf', 3, 'Accepted', '2024-10-06 02:56:08'),
(4, 'oeij', 'iojioj oij', 'BOOKS.YOSSR.COM-Finish-What-You-Start.pdf', 3, 'Rejected', '2024-10-06 02:56:08'),
(5, 'oeij', 'iojioj oij', 'BOOKS.YOSSR.COM-Finish-What-You-Start.pdf', 3, 'Rejected', '2024-10-06 02:56:08'),
(6, 'efoij', 'iojiofjvio', 'user.png', 3, 'pending', '2024-10-06 02:56:08'),
(7, 'sdowij', 'iojiojio', 'user.png', 3, 'pending', '2024-10-06 02:56:08'),
(8, 'kljm', 'ojmoijoio', 'Screenshot 2024-10-06 at 01.47.18.png', 3, 'pending', '2024-10-06 02:56:08'),
(9, 'dwjn', 'inijio', 'Screenshot 2024-09-05 at 11.52.17.png', 3, 'Rejected', '2024-10-06 02:56:08'),
(10, 'doij', 'oijiojoi', 'Screenshot 2024-09-05 at 11.52.17.png', 3, 'pending', '2024-10-06 02:56:08'),
(11, 'dcd', 'erfefe', 'Parfait ERD.pdf', 3, 'pending', '2024-10-06 02:56:26'),
(12, 'dcd', 'erfefe', 'Parfait ERD.pdf', 3, 'pending', '2024-10-06 02:57:05'),
(13, 'dcd', 'erfefe', 'Parfait ERD.pdf', 3, 'Accepted', '2024-10-06 02:57:09'),
(14, 'ewfe', 'eew', '6701e0f253fee8.60724094_27603 KWIZERA Parfait Assignement_DBMS.pdf', 3, 'rejected', '2024-10-06 02:59:30'),
(15, 'ewfre', 'erfer', '6701e15a225be5.28444404_27603 KWIZERA Parfait Assignement_DBMS.pdf', 3, 'Rejected', '2024-10-06 03:01:14'),
(16, 'fijh', 'iuhuihui', '670263c36bdb03.17017813_BAG_Presentation..pptx', 3, 'pending', '2024-10-06 12:17:39'),
(17, 'ddfcd', 'dsdsc', '67026d5654af17.10780632_LaravelTaskv12.txt', 3, 'Accepted', '2024-10-06 12:58:30');

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
(1, 3, 10, '2024-10-06 17:28:18'),
(2, 3, 14, '2024-10-06 17:28:34'),
(3, 6, 6, '2024-10-07 00:03:54'),
(4, 6, 7, '2024-10-07 00:03:59');

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
(1, 'NN', 'bonheurndahimana125@gmail.com', '1234', 'admin'),
(2, '1fvdd', 'bonheurndahimana125@gmail.com', '$2y$10$DrPx6vU9AWHgSwymbjqugePjE6obxDyCt.F52G.nqJ7RxuaW6DWjC', 'supervisor'),
(3, 'dfcdcfd', 'bonheurndahima334na125@gmail.com', '$2y$10$GG7MRVCgSyNND1BzvkCz.uPz6MUyv7oViOySKC65d5fymj0hdgWB.', 'supervisor'),
(4, 'efeww', 'bonheureewewndahimana125@gmail.com', '$2y$10$92EEwXsCgIiMHcrr.HqNmO/WR86xjqeuOlkUjZANl4tEUdgAKak92', 'supervisor'),
(5, 'super', 'super@gmail.com', '$2y$10$wXVX2wZoApEeGhS25yASLOO.ayDmBbov9e7K0E7si8ISMDlUG3W62', 'supervisor'),
(6, 'switch', 'superswitch@gmail.com', '1234', 'supervisor');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `project_progress`
--
ALTER TABLE `project_progress`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `studentsprojects`
--
ALTER TABLE `studentsprojects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `supervisor_project_assignment`
--
ALTER TABLE `supervisor_project_assignment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

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
