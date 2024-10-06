-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Oct 06, 2024 at 02:39 AM
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
-- Database: `project_approval`
--

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
(3, 'Bonheur', 'NDAHIMANA', 'ndahimana154@gmail.com', '0788923011', '$2y$10$yIb5/UrfqDpE3ca8L2HkJeZsPCuOHeEKbyXlUSm01h0deX74LiSl6', '', '', ''),
(4, 'Bonheur', 'NDAHIMANA', 'ndahimana1534@gmail.com', '0788923011', '$2y$10$sIx65i0azJyBAlV7ZqIjheuGlHOOr1MOuYMndpFVz4yn3p3xqvlQG', '', '', ''),
(5, 'woij', 'oijoij', 'ojiojoi@efefe.efef', 'opkjij', '$2y$10$5XCB/r0d5BttidFVLPX/xuXhi4n1gk3jQAYO0E041L5WphGv1SFz6', NULL, NULL, NULL),
(6, 'ioj', 'oijiojiojio', 'ijoi@rvr.rvrf', '2939', '$2y$10$ZykZZ9vOovRXvBdzCP4kB.BSMM7nYQj1TH0vF.sOvs.UuoUAneU5y', NULL, NULL, NULL),
(7, 'qoij', 'ioj', 'iojiojioj@ee.e', 'opj', '$2y$10$tG3xhej4Svwz.rKO9jKW4ehU.BK/Uvq3C1dLbL0UiZNo4eo1.yDoq', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `studentsProjects`
--

CREATE TABLE `studentsProjects` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `file_name` text NOT NULL,
  `student_id` int(11) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `studentsProjects`
--

INSERT INTO `studentsProjects` (`id`, `title`, `description`, `file_name`, `student_id`, `status`) VALUES
(1, 'dfW', 'JNIUN', 'BOOKS.YOSSR.COM-Finish-What-You-Start.pdf', 3, 'pending'),
(2, 'oeij', 'iojioj oij', 'BOOKS.YOSSR.COM-Finish-What-You-Start.pdf', 3, 'pending'),
(3, 'oeij', 'iojioj oij', 'BOOKS.YOSSR.COM-Finish-What-You-Start.pdf', 3, 'pending'),
(4, 'oeij', 'iojioj oij', 'BOOKS.YOSSR.COM-Finish-What-You-Start.pdf', 3, 'pending'),
(5, 'oeij', 'iojioj oij', 'BOOKS.YOSSR.COM-Finish-What-You-Start.pdf', 3, 'pending'),
(6, 'efoij', 'iojiofjvio', 'user.png', 3, 'pending'),
(7, 'sdowij', 'iojiojio', 'user.png', 3, 'pending'),
(8, 'kljm', 'ojmoijoio', 'Screenshot 2024-10-06 at 01.47.18.png', 3, 'pending'),
(9, 'dwjn', 'inijio', 'Screenshot 2024-09-05 at 11.52.17.png', 3, 'pending'),
(10, 'doij', 'oijiojoi', 'Screenshot 2024-09-05 at 11.52.17.png', 3, 'pending');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `studentsProjects`
--
ALTER TABLE `studentsProjects`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sdifugnrefini` (`student_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `studentsProjects`
--
ALTER TABLE `studentsProjects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `studentsProjects`
--
ALTER TABLE `studentsProjects`
  ADD CONSTRAINT `sdifugnrefini` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
