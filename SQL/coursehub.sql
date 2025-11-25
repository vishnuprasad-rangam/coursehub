-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 24, 2025 at 09:57 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `coursehub`
--
CREATE DATABASE IF NOT EXISTS `coursehub` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `coursehub`;

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `course_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `duration_weeks` int(11) NOT NULL,
  `original_price` decimal(10,2) NOT NULL,
  `sale_price` decimal(10,2) DEFAULT NULL,
  `image_url` varchar(500) DEFAULT NULL,
  `instructor_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`course_id`, `title`, `description`, `duration_weeks`, `original_price`, `sale_price`, `image_url`, `instructor_id`, `created_at`, `updated_at`) VALUES
(1, 'Python', 'Comprehensive introduction to core Python programming, covering syntax, data structures, and Object-Oriented Programming fundamentals for data science.', 4, 2999.00, NULL, 'https://placehold.co/640x360/C4C4C4/000000?text=Python', 2, '2025-11-25 05:00:00', '2025-11-25 05:00:00'),
(2, 'Numpy', 'Master the N-dimensional array and vectorized operations. Essential for high-performance numerical and mathematical computing in Python.', 2, 1499.00, NULL, 'https://placehold.co/640x360/C4C4C4/000000?text=Numpy', 2, '2025-11-25 05:00:00', '2025-11-25 05:00:00'),
(3, 'Pandas', 'The essential course for data analysis, focusing on DataFrames, data cleaning, manipulation, joining, and time series analysis.', 4, 3999.00, NULL, 'https://placehold.co/640x360/C4C4C4/000000?text=Pandas', 2, '2025-11-25 05:00:00', '2025-11-25 05:00:00'),
(4, 'Plotly', 'Interactive data visualization using Plotly. Learn to create dynamic and professional-grade charts, dashboards, and geospatial visualizations.', 2, 1999.00, NULL, 'https://placehold.co/640x360/C4C4C4/000000?text=Plotly', 3, '2025-11-25 05:00:00', '2025-11-25 05:00:00'),
(5, 'Matplotlib', 'Deep dive into Matplotlib, the foundational 2D plotting library for Python. Learn to customize static, animated, and interactive visualizations.', 3, 2499.00, NULL, 'https://placehold.co/640x360/C4C4C4/000000?text=Matplotlib', 4, '2025-11-25 05:00:00', '2025-11-25 05:00:00'),
(6, 'Seaborn', 'Advanced statistical data visualization built on Matplotlib. Focus on drawing informative and attractive statistical graphics with ease.', 1, 1299.00, NULL, 'https://placehold.co/640x360/C4C4C4/000000?text=Seaborn', 1, '2025-11-25 05:00:00', '2025-11-25 05:00:00'),
(7, 'Bootstrap', 'Learn to build responsive, mobile-first websites quickly using the world’s most popular front-end toolkit, Bootstrap.', 3, 1500.00, NULL, 'https://placehold.co/640x360/C4C4C4/000000?text=Bootstrap', 3, '2025-11-25 05:00:00', '2025-11-25 05:00:00'),
(8, 'React', 'Master the foundational concepts of React, including components, state, hooks, and the component lifecycle for building modern web applications.', 5, 4500.00, NULL, 'https://placehold.co/640x360/C4C4C4/000000?text=React', 1, '2025-11-25 05:00:00', '2025-11-25 05:00:00'),
(9, 'Next.js', 'Go beyond React fundamentals to master Next.js for server-side rendering, static site generation, and optimized performance.', 4, 3900.00, NULL, 'https://placehold.co/640x360/C4C4C4/000000?text=Next.js', 1, '2025-11-25 05:00:00', '2025-11-25 05:00:00'),
(10, 'PHP', 'Backend development fundamentals using PHP. Learn database interaction (MySQL), form processing, and building robust server-side applications.', 5, 3000.00, NULL, 'https://placehold.co/640x360/C4C4C4/000000?text=PHP', 4, '2025-11-25 05:00:00', '2025-11-25 05:00:00'),
(11, 'Node', 'Master asynchronous JavaScript and Node.js to build fast, scalable network applications and APIs. Includes Express.js.', 4, 4200.00, NULL, 'https://placehold.co/640x360/C4C4C4/000000?text=Node', 4, '2025-11-25 05:00:00', '2025-11-25 05:00:00'),
(12, 'Material UI', 'Learn to implement Google’s Material Design specification in React using the popular Material UI component library.', 2, 1800.00, NULL, 'https://placehold.co/640x360/C4C4C4/000000?text=Material+UI', 3, '2025-11-25 05:00:00', '2025-11-25 05:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `course_sections`
--

CREATE TABLE `course_sections` (
  `section_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `section_title` varchar(255) NOT NULL,
  `section_order` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `course_sections`
--

INSERT INTO `course_sections` (`section_id`, `course_id`, `section_title`, `section_order`, `created_at`) VALUES
(1, 1, 'Getting Started with Python', 1, '2025-11-25 05:00:00'),
(2, 1, 'Python Data Structures', 2, '2025-11-25 05:00:00'),
(3, 1, 'Functions and Modules', 3, '2025-11-25 05:00:00'),
(4, 2, 'Introduction to NumPy Arrays', 1, '2025-11-25 05:00:00'),
(5, 2, 'Array Indexing and Slicing', 2, '2025-11-25 05:00:00'),
(6, 3, 'Pandas Series and DataFrames', 1, '2025-11-25 05:00:00'),
(7, 3, 'Data Cleaning and Preprocessing', 2, '2025-11-25 05:00:00'),
(8, 4, 'Basic Plotly Charts', 1, '2025-11-25 05:00:00'),
(9, 4, 'Interactive Dashboards', 2, '2025-11-25 05:00:00'),
(10, 5, 'Matplotlib Architecture', 1, '2025-11-25 05:00:00'),
(11, 5, 'Customizing Visuals', 2, '2025-11-25 05:00:00'),
(12, 6, 'Statistical Relationship Plots', 1, '2025-11-25 05:00:00'),
(13, 6, 'Distribution and Categorical Plots', 2, '2025-11-25 05:00:00'),
(14, 7, 'Grid System and Layouts', 1, '2025-11-25 05:00:00'),
(15, 7, 'Components and Utilities', 2, '2025-11-25 05:00:00'),
(16, 8, 'React Components and JSX', 1, '2025-11-25 05:00:00'),
(17, 8, 'State Management and Hooks', 2, '2025-11-25 05:00:00'),
(18, 9, 'Routing and Data Fetching', 1, '2025-11-25 05:00:00'),
(19, 9, 'SSR and Static Generation', 2, '2025-11-25 05:00:00'),
(20, 10, 'PHP Basics and Syntax', 1, '2025-11-25 05:00:00'),
(21, 10, 'Database Connectivity (MySQL)', 2, '2025-11-25 05:00:00'),
(22, 11, 'Node.js and npm', 1, '2025-11-25 05:00:00'),
(23, 11, 'Building REST APIs with Express', 2, '2025-11-25 05:00:00'),
(24, 12, 'Material UI Components', 1, '2025-11-25 05:00:00'),
(25, 12, 'Theming and Customization', 2, '2025-11-25 05:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `enrollments`
--

CREATE TABLE `enrollments` (
  `enrollment_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `status` enum('Not Started','In Progress','Completed') DEFAULT 'Not Started',
  `enrollment_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `completion_date` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `enrollments`
--

INSERT INTO `enrollments` (`enrollment_id`, `student_id`, `course_id`, `status`, `enrollment_date`, `completion_date`) VALUES
(1, 2, 1, 'In Progress', '2025-11-25 05:01:00', NULL),
(2, 2, 2, 'Not Started', '2025-11-25 05:01:00', NULL),
(3, 2, 3, 'In Progress', '2025-11-25 05:01:00', NULL),
(4, 2, 4, 'Completed', '2025-11-25 05:01:00', '2025-11-25 10:00:00'),
(5, 2, 5, 'Not Started', '2025-11-25 05:01:00', NULL),
(6, 2, 6, 'In Progress', '2025-11-25 05:01:00', NULL),
(7, 1, 1, 'In Progress', '2025-11-25 05:02:00', NULL),
(8, 2, 7, 'In Progress', '2025-11-25 05:03:00', NULL),
(9, 2, 8, 'Not Started', '2025-11-25 05:03:00', NULL),
(10, 2, 9, 'In Progress', '2025-11-25 05:03:00', NULL),
(11, 2, 10, 'Completed', '2025-11-25 05:03:00', '2025-11-25 12:00:00'),
(12, 2, 11, 'Not Started', '2025-11-25 05:03:00', NULL),
(13, 2, 12, 'In Progress', '2025-11-25 05:03:00', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `instructors`
--

CREATE TABLE `instructors` (
  `instructor_id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `bio_summary` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `instructors`
--

INSERT INTO `instructors` (`instructor_id`, `name`, `bio_summary`, `created_at`) VALUES
(1, 'Dr. Sarah', 'Full-stack development expert specializing in modern JavaScript frameworks (React, Next.js) and producing clean, production-ready code. Also teaches advanced statistical visualization (Seaborn).', '2025-11-24 05:00:03'),
(2, 'Prof. James', 'Lead Data Science expert and AI researcher, focusing on foundational Python, NumPy for high-performance numerical computing, and Pandas for advanced data manipulation.', '2025-11-24 05:00:03'),
(3, 'Maria', 'UX/UI Design specialist and front-end architect. Focuses on design systems, interactive visualization (Plotly), Bootstrap, and Material UI for creating polished user interfaces.', '2025-11-24 05:00:03'),
(4, 'David', 'Senior data engineer and backend architect, specializing in the deep customization of plotting libraries (Matplotlib) and scalable server-side technologies (PHP, Node).', '2025-11-24 05:00:03');

-- --------------------------------------------------------

--
-- Table structure for table `section_topics`
--

CREATE TABLE `section_topics` (
  `topic_id` int(11) NOT NULL,
  `section_id` int(11) NOT NULL,
  `topic_name` varchar(255) NOT NULL,
  `topic_order` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `section_topics`
--

INSERT INTO `section_topics` (`topic_id`, `section_id`, `topic_name`, `topic_order`) VALUES
(1, 1, 'Python Installation and Setup', 1),
(2, 1, 'Variables and Basic Operators', 2),
(3, 2, 'Lists, Tuples, Sets, and Dictionaries', 1),
(4, 2, 'Conditional Logic and Loops', 2),
(5, 4, 'Creating ndarrays', 1),
(6, 4, 'Basic Array Math', 2),
(7, 6, 'Loading Data from CSV/Excel', 1),
(8, 6, 'Selecting Data (loc and iloc)', 2),
(9, 7, 'Handling Missing Data (NaN)', 1),
(10, 8, 'Scatter and Line Plots', 1),
(11, 8, 'Bar Charts and Histograms', 2),
(12, 9, 'Using Dash with Plotly', 1),
(13, 10, 'Figure, Axes, and Backends', 1),
(14, 10, 'Subplots and Grids', 2),
(15, 11, 'Color Maps and Palettes', 1),
(16, 12, 'Relational Plots (relplot)', 1),
(17, 12, 'Linear Model Plots (lmplot)', 2),
(18, 13, 'Histograms and KDEs (displot)', 1),
(19, 13, 'Box, Violin, and Bar Plots', 2),
(20, 14, 'Responsive Breakpoints and Containers', 1),
(21, 14, 'Flexbox and Grid Layouts', 2),
(22, 15, 'Navigation Bars and Carousels', 1),
(23, 15, 'Utility Classes and Spacing', 2),
(24, 16, 'Functional Components vs. Class Components', 1),
(25, 16, 'Handling Events in JSX', 2),
(26, 17, 'useState and useEffect', 1),
(27, 17, 'Context API for Global State', 2),
(28, 18, 'File-based Routing and Dynamic Routes', 1),
(29, 18, 'getServerSideProps and getStaticProps', 2),
(30, 19, 'API Routes and Backend Integration', 1),
(31, 19, 'Image Optimization and Static Assets', 2),
(32, 20, 'Variables, Data Types, and Operators', 1),
(33, 20, 'Control Structures (if/else, loops)', 2),
(34, 21, 'PDO for Database Connection', 1),
(35, 21, 'Securing Forms and Input', 2),
(36, 22, 'Asynchronous Programming (Callbacks, Promises)', 1),
(37, 22, 'Introduction to Event Loop', 2),
(38, 23, 'Setting up Express Server', 1),
(39, 23, 'Handling POST and GET Requests', 2),
(40, 24, 'Layout Components (Grid, Container)', 1),
(41, 24, 'Input and Feedback Components (Buttons, Forms)', 2),
(42, 25, 'Creating a Custom Theme with `createTheme`', 1),
(43, 25, 'Styling Components with `sx` Prop', 2);

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `student_id` int(11) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `password_hash` char(60) NOT NULL,
  `gender` enum('Male','Female','Other') NOT NULL,
  `date_of_birth` date NOT NULL,
  `state` varchar(100) NOT NULL,
  `pincode` char(6) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`student_id`, `first_name`, `last_name`, `email`, `password_hash`, `gender`, `date_of_birth`, `state`, `pincode`, `created_at`, `updated_at`) VALUES
(1, 'John', 'Doe', 'john.doe@example.com', '$2y$10$clztfH/ygl81VCJvMbodsuuyRDVgh/FQHUNtwIUmcCAArHALPVuna', 'Male', '1995-06-15', 'Maharashtra', '400001', '2025-11-24 05:00:03', '2025-11-24 05:00:39'),
(2, 'Jane', 'Smith', 'jane.smith@example.com', '$2y$10$clztfH/ygl81VCJvMbodsuuyRDVgh/FQHUNtwIUmcCAArHALPVuna', 'Female', '1998-03-22', 'Karnataka', '560001', '2025-11-24 05:00:03', '2025-11-24 05:00:44'),
(3, 'Cathy', 'Lee', 'cathy.lee@test.com', '$2y$10$clztfH/ygl81VCJvMbodsuuyRDVgh/FQHUNtwIUmcCAArHALPVuna', 'Female', '2000-11-08', 'Delhi', '110001', '2025-11-24 05:00:03', '2025-11-24 05:00:48'),
(4, 'Emily', 'Brown', 'emily.brown@example.com', '$2y$10$clztfH/ygl81VCJvMbodsuuyRDVgh/FQHUNtwIUmcCAArHALPVuna', 'Female', '1997-09-14', 'Tamil Nadu', '600001', '2025-11-24 05:00:03', '2025-11-24 05:00:52'),
(5, 'Nancy', '', 'nancy@test.com', '$2y$10$DPRegVS4/BEt5ugdT0mzT.HLi0L5VsODYLZ87Zkp1bTbZ.0ctn5FS', 'Female', '2005-01-01', 'Gujarat', '380001', '2025-11-24 06:23:52', '2025-11-24 06:23:52');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`course_id`),
  ADD KEY `instructor_id` (`instructor_id`);

--
-- Indexes for table `course_sections`
--
ALTER TABLE `course_sections`
  ADD PRIMARY KEY (`section_id`),
  ADD KEY `course_id` (`course_id`);

--
-- Indexes for table `enrollments`
--
ALTER TABLE `enrollments`
  ADD PRIMARY KEY (`enrollment_id`),
  ADD UNIQUE KEY `unique_enrollment` (`student_id`,`course_id`),
  ADD KEY `course_id` (`course_id`);

--
-- Indexes for table `instructors`
--
ALTER TABLE `instructors`
  ADD PRIMARY KEY (`instructor_id`);

--
-- Indexes for table `section_topics`
--
ALTER TABLE `section_topics`
  ADD PRIMARY KEY (`topic_id`),
  ADD KEY `section_id` (`section_id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`student_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `course_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `course_sections`
--
ALTER TABLE `course_sections`
  MODIFY `section_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `enrollments`
--
ALTER TABLE `enrollments`
  MODIFY `enrollment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `instructors`
--
ALTER TABLE `instructors`
  MODIFY `instructor_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `section_topics`
--
ALTER TABLE `section_topics`
  MODIFY `topic_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `student_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `courses`
--
ALTER TABLE `courses`
  ADD CONSTRAINT `courses_ibfk_1` FOREIGN KEY (`instructor_id`) REFERENCES `instructors` (`instructor_id`) ON DELETE CASCADE;

--
-- Constraints for table `course_sections`
--
ALTER TABLE `course_sections`
  ADD CONSTRAINT `course_sections_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `courses` (`course_id`) ON DELETE CASCADE;

--
-- Constraints for table `enrollments`
--
ALTER TABLE `enrollments`
  ADD CONSTRAINT `enrollments_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`student_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `enrollments_ibfk_2` FOREIGN KEY (`course_id`) REFERENCES `courses` (`course_id`) ON DELETE CASCADE;

--
-- Constraints for table `section_topics`
--
ALTER TABLE `section_topics`
  ADD CONSTRAINT `section_topics_ibfk_1` FOREIGN KEY (`section_id`) REFERENCES `course_sections` (`section_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
