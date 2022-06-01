-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 01, 2022 at 05:05 AM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 8.0.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `e-diary`
--

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `department_id` tinyint(3) UNSIGNED NOT NULL,
  `department` varchar(100) NOT NULL,
  `faculty_id` tinyint(3) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`department_id`, `department`, `faculty_id`) VALUES
(1, 'КОМУНИКАЦИОННА ТЕХНИКА И ТЕХНОЛОГИИ (КТТ)', 4),
(2, 'ЕЛЕКТРОННА ТЕХНИКА И МИКРОЕЛЕКТРОНИКА (ЕТМ)', 4),
(3, 'АВТОМАТИЗАЦИЯ НА ПРОИЗВОДСТВОТО (АП)', 4),
(4, 'КОМПЮТЪРНИ НАУКИ И ТЕХНОЛОГИИ (КНТ)', 4),
(5, 'СОФТУЕРНИ И ИНТЕРНЕТ ТЕХНОЛОГИИ (СИТ)', 4);

-- --------------------------------------------------------

--
-- Table structure for table `disciplines`
--

CREATE TABLE `disciplines` (
  `discipline_id` int(11) NOT NULL,
  `discipline` varchar(100) NOT NULL,
  `speciality_id` tinyint(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `disciplines`
--

INSERT INTO `disciplines` (`discipline_id`, `discipline`, `speciality_id`) VALUES
(1, 'Основи но компютърните комуникации', 1),
(2, 'Компютърни мрежи', 1),
(3, 'Администриране на локални и интернет мрежи', 1),
(4, 'Електронна търговия', 1);

-- --------------------------------------------------------

--
-- Table structure for table `e_degrees`
--

CREATE TABLE `e_degrees` (
  `degree_id` tinyint(3) UNSIGNED NOT NULL,
  `degree` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `e_degrees`
--

INSERT INTO `e_degrees` (`degree_id`, `degree`) VALUES
(1, 'Бакалавър'),
(2, 'Магистър');

-- --------------------------------------------------------

--
-- Table structure for table `faculties`
--

CREATE TABLE `faculties` (
  `faculty_id` tinyint(3) UNSIGNED NOT NULL,
  `faculty` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `faculties`
--

INSERT INTO `faculties` (`faculty_id`, `faculty`) VALUES
(1, 'МТФ (МАШИННО-ТЕХНОЛОГИЧЕН ФАКУЛТЕТ)'),
(2, 'КФ (КОРАБОСТРОИТЕЛЕН ФАКУЛТЕТ)'),
(3, 'ЕФ (ЕЛЕКТРОТЕХНИЧЕСКИ ФАКУЛТЕТ)'),
(4, 'ФИТА (ФАКУЛТЕТ ПО ИЗЧИСЛИТЕЛНА ТЕХНИКА И АВТОМАТИЗАЦИЯ)'),
(5, 'ДТК (ДОБРУДЖАНСКИ ТЕХНОЛОГИЧЕН КОЛЕЖ)'),
(6, 'КТУ (КОЛЕЖ В СТРУКТУРАТА НА ТУ - ВАРНА)'),
(7, 'ДЕПОС (ДЕПАРТАМЕНТ ПО ЕЗИКОВО И ПРОДЪЛЖАВАЩО ОБУЧЕНИЕ И СПОРТ)');

-- --------------------------------------------------------

--
-- Table structure for table `form_of_education`
--

CREATE TABLE `form_of_education` (
  `form_id` tinyint(3) UNSIGNED NOT NULL,
  `form_ed` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `form_of_education`
--

INSERT INTO `form_of_education` (`form_id`, `form_ed`) VALUES
(1, 'Редовна'),
(2, 'Задочна'),
(3, 'Дистанционна');

-- --------------------------------------------------------

--
-- Table structure for table `grades`
--

CREATE TABLE `grades` (
  `grade_id` int(11) NOT NULL,
  `discipline_id` int(11) NOT NULL,
  `student_id` varchar(10) NOT NULL,
  `teacher_id` varchar(10) NOT NULL,
  `exam_date` datetime NOT NULL,
  `grade` tinyint(4) NOT NULL,
  `semester` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `grades`
--

INSERT INTO `grades` (`grade_id`, `discipline_id`, `student_id`, `teacher_id`, `exam_date`, `grade`, `semester`) VALUES
(5, 2, '18621414', '7502156393', '2022-05-11 11:34:03', 6, 3),
(6, 1, '18621414', '7502156393', '2022-05-30 09:07:50', 4, 1),
(7, 2, '18621414', '7502156393', '2022-05-30 09:08:20', -1, 1),
(8, 4, '18621414', '7502156393', '2022-05-30 09:08:54', 5, 4),
(9, 4, '18621414', '7502156393', '2022-05-30 09:10:05', 5, 2),
(10, 4, '18621414', '7502156393', '2022-05-30 09:10:37', 2, 2),
(11, 4, '18621414', '7502156393', '2022-05-30 09:11:32', 3, 4),
(12, 3, '18621414', '7502156393', '2022-05-30 09:17:35', 1, 4);

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `msg_id` int(11) NOT NULL,
  `from` varchar(10) NOT NULL,
  `to` varchar(10) NOT NULL,
  `msg` varchar(255) NOT NULL,
  `time` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`msg_id`, `from`, `to`, `msg`, `time`) VALUES
(117, '7502156393', '18621414', ':)', '2022-05-29 11:30:01'),
(118, '18621414', '6850631256', 'ЗДравейте :)', '2022-05-29 11:30:15'),
(119, '18621414', '6850631256', ':)', '2022-05-30 09:45:54');

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `notification_id` int(11) NOT NULL,
  `text_id` int(11) NOT NULL,
  `from_user` varchar(10) NOT NULL,
  `to_user` varchar(10) NOT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT 0,
  `time` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `notification_text`
--

CREATE TABLE `notification_text` (
  `id` int(11) NOT NULL,
  `text` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `notification_text`
--

INSERT INTO `notification_text` (`id`, `text`) VALUES
(1, 'Нова оценка'),
(2, 'Ново съобщение');

-- --------------------------------------------------------

--
-- Table structure for table `specialties`
--

CREATE TABLE `specialties` (
  `specialty_id` tinyint(3) UNSIGNED NOT NULL,
  `specialty` varchar(100) NOT NULL,
  `department_id` tinyint(3) UNSIGNED NOT NULL,
  `degree_id` tinyint(3) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `specialties`
--

INSERT INTO `specialties` (`specialty_id`, `specialty`, `department_id`, `degree_id`) VALUES
(1, 'Компютърни системи и технологии (КСТ)', 4, 1),
(2, 'Софтуерни и интернет технологии (СИТ)', 5, 1);

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `facultyNumber` varchar(10) NOT NULL,
  `firstname` varchar(15) NOT NULL,
  `middlename` varchar(25) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `specialty` tinyint(3) UNSIGNED NOT NULL,
  `form_of_education` tinyint(3) UNSIGNED NOT NULL,
  `st_group` tinyint(4) NOT NULL,
  `course` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`facultyNumber`, `firstname`, `middlename`, `lastname`, `specialty`, `form_of_education`, `st_group`, `course`) VALUES
('18621395', 'Наско', 'Спасинов', 'Николов', 1, 1, 1, 4),
('18621396', 'Даяна', 'Димитрова', 'Димитрова', 1, 2, 1, 4),
('18621414', 'Беркант', 'Сезгин', 'Исмет', 1, 1, 1, 4);

-- --------------------------------------------------------

--
-- Table structure for table `st_login`
--

CREATE TABLE `st_login` (
  `facultyNumber` varchar(10) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(50) DEFAULT NULL,
  `code` varchar(15) DEFAULT NULL,
  `code_expire_in` datetime DEFAULT NULL,
  `email_verified_at` datetime DEFAULT NULL,
  `img` varchar(50) NOT NULL DEFAULT 'default.jpg',
  `status` varchar(10) NOT NULL DEFAULT 'Offline',
  `last_activity` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `st_login`
--

INSERT INTO `st_login` (`facultyNumber`, `password`, `email`, `code`, `code_expire_in`, `email_verified_at`, `img`, `status`, `last_activity`) VALUES
('18621414', '$2y$10$CqN0xXgfTHcgXCMPH1aYFuQxlwpNgZjDf5./X.6FlfW7sIJuAedda', 'berkant_99@abv.bg', NULL, NULL, '2022-05-30 09:42:37', 'default.jpg', 'Offline', '2022-05-30 20:26:56'),
('18621395', '$2y$10$.7BGiAS.LruCFMi13o8UqOKfX7N4DyhwYSgkhzGBN.6yFAGng.Vpi', 'ber_99@abv.bg', NULL, NULL, '2022-04-08 07:32:55', 'default.jpg', 'Offline', '2022-05-30 12:45:54'),
('18621396', '$2y$10$s8IQSXZYeL2GWZ4s1S4xdedXo7yZQea784jp1BQPc94pyJrbDV6Hi', 'selena99selena@abv.bg', NULL, NULL, '2022-03-29 13:23:05', '18621396.jpg', 'Offline', '2022-05-28 15:00:54');

-- --------------------------------------------------------

--
-- Table structure for table `teachers`
--

CREATE TABLE `teachers` (
  `teacher_id` varchar(10) NOT NULL,
  `email` varchar(50) NOT NULL,
  `name` varchar(15) NOT NULL,
  `middlename` varchar(15) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `department_id` tinyint(3) UNSIGNED NOT NULL,
  `title_id` tinyint(2) NOT NULL,
  `cabinet` varchar(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `teachers`
--

INSERT INTO `teachers` (`teacher_id`, `email`, `name`, `middlename`, `lastname`, `department_id`, `title_id`, `cabinet`) VALUES
('6850631256', 'tganchev@tu-varna.bg', 'Тодор', 'Димитров', 'Ганчев', 4, 6, '201'),
('7502156393', 'v.aleksieva@tu-varna.bg', 'Венета', 'Панайотова', 'Алексиева', 5, 5, '303-ТВ');

-- --------------------------------------------------------

--
-- Table structure for table `titles`
--

CREATE TABLE `titles` (
  `title_id` tinyint(2) NOT NULL,
  `title` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `titles`
--

INSERT INTO `titles` (`title_id`, `title`) VALUES
(7, 'акад.'),
(2, 'ас.'),
(3, 'гл. ас.'),
(4, 'д-р'),
(5, 'доц.'),
(1, 'инж.'),
(9, 'пр.'),
(6, 'проф.'),
(8, 'хон.');

-- --------------------------------------------------------

--
-- Table structure for table `t_profile`
--

CREATE TABLE `t_profile` (
  `teacher_id` varchar(10) NOT NULL,
  `password` varchar(255) NOT NULL,
  `code` varchar(15) DEFAULT NULL,
  `code_expire_in` datetime DEFAULT NULL,
  `img` varchar(50) NOT NULL DEFAULT 'default.jpg',
  `status` varchar(10) NOT NULL DEFAULT 'Offline',
  `last_activity` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `t_profile`
--

INSERT INTO `t_profile` (`teacher_id`, `password`, `code`, `code_expire_in`, `img`, `status`, `last_activity`) VALUES
('6850631256', '6850631256', NULL, NULL, 'default.jpg', 'Offline', NULL),
('7502156393', '7502156393', NULL, NULL, 'default.jpg', 'Offline', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`department_id`),
  ADD KEY `FK_FACULTY_ID` (`faculty_id`);

--
-- Indexes for table `disciplines`
--
ALTER TABLE `disciplines`
  ADD PRIMARY KEY (`discipline_id`);

--
-- Indexes for table `e_degrees`
--
ALTER TABLE `e_degrees`
  ADD PRIMARY KEY (`degree_id`);

--
-- Indexes for table `faculties`
--
ALTER TABLE `faculties`
  ADD PRIMARY KEY (`faculty_id`);

--
-- Indexes for table `form_of_education`
--
ALTER TABLE `form_of_education`
  ADD PRIMARY KEY (`form_id`);

--
-- Indexes for table `grades`
--
ALTER TABLE `grades`
  ADD PRIMARY KEY (`grade_id`),
  ADD KEY `FK_ST_ID` (`student_id`),
  ADD KEY `FK_DIS_ID` (`discipline_id`),
  ADD KEY `FK_TEACH_ID` (`teacher_id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`msg_id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`notification_id`),
  ADD KEY `FK_FROM_ST` (`from_user`),
  ADD KEY `FK_TO_ST` (`to_user`),
  ADD KEY `FK_TEXT_ID` (`text_id`);

--
-- Indexes for table `notification_text`
--
ALTER TABLE `notification_text`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `specialties`
--
ALTER TABLE `specialties`
  ADD PRIMARY KEY (`specialty_id`),
  ADD KEY `FK_DEPARTMENT_ID` (`department_id`),
  ADD KEY `FK_DEGREE_ID` (`degree_id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`facultyNumber`),
  ADD KEY `FK_SPECIALTY_ID` (`specialty`),
  ADD KEY `FK_FORM_EDUCATION` (`form_of_education`);

--
-- Indexes for table `st_login`
--
ALTER TABLE `st_login`
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `FacultyNumber_FK` (`facultyNumber`);

--
-- Indexes for table `teachers`
--
ALTER TABLE `teachers`
  ADD PRIMARY KEY (`teacher_id`),
  ADD UNIQUE KEY `unique_email` (`email`),
  ADD KEY `FK_DEP_ID` (`department_id`),
  ADD KEY `FK_TITLE_ID` (`title_id`);

--
-- Indexes for table `titles`
--
ALTER TABLE `titles`
  ADD PRIMARY KEY (`title_id`),
  ADD UNIQUE KEY `unique_title` (`title`);

--
-- Indexes for table `t_profile`
--
ALTER TABLE `t_profile`
  ADD UNIQUE KEY `teacher_id` (`teacher_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `department_id` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `disciplines`
--
ALTER TABLE `disciplines`
  MODIFY `discipline_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `e_degrees`
--
ALTER TABLE `e_degrees`
  MODIFY `degree_id` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `faculties`
--
ALTER TABLE `faculties`
  MODIFY `faculty_id` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `form_of_education`
--
ALTER TABLE `form_of_education`
  MODIFY `form_id` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `grades`
--
ALTER TABLE `grades`
  MODIFY `grade_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `msg_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=120;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `notification_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `notification_text`
--
ALTER TABLE `notification_text`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `specialties`
--
ALTER TABLE `specialties`
  MODIFY `specialty_id` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `titles`
--
ALTER TABLE `titles`
  MODIFY `title_id` tinyint(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `departments`
--
ALTER TABLE `departments`
  ADD CONSTRAINT `FK_FACULTY_ID` FOREIGN KEY (`faculty_id`) REFERENCES `faculties` (`faculty_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `grades`
--
ALTER TABLE `grades`
  ADD CONSTRAINT `FK_DIS_ID` FOREIGN KEY (`discipline_id`) REFERENCES `disciplines` (`discipline_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_ST_ID` FOREIGN KEY (`student_id`) REFERENCES `students` (`facultyNumber`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_TEACH_ID` FOREIGN KEY (`teacher_id`) REFERENCES `teachers` (`teacher_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `FK_FROM_ST` FOREIGN KEY (`from_user`) REFERENCES `students` (`facultyNumber`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_TEXT_ID` FOREIGN KEY (`text_id`) REFERENCES `notification_text` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_TO_ST` FOREIGN KEY (`to_user`) REFERENCES `students` (`facultyNumber`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `specialties`
--
ALTER TABLE `specialties`
  ADD CONSTRAINT `FK_DEGREE_ID` FOREIGN KEY (`degree_id`) REFERENCES `e_degrees` (`degree_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_DEPARTMENT_ID` FOREIGN KEY (`department_id`) REFERENCES `departments` (`department_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `students`
--
ALTER TABLE `students`
  ADD CONSTRAINT `FK_FORM_EDUCATION` FOREIGN KEY (`form_of_education`) REFERENCES `form_of_education` (`form_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_SPECIALTY_ID` FOREIGN KEY (`specialty`) REFERENCES `specialties` (`specialty_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `st_login`
--
ALTER TABLE `st_login`
  ADD CONSTRAINT `FacultyNumber_FK` FOREIGN KEY (`facultyNumber`) REFERENCES `students` (`facultyNumber`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `teachers`
--
ALTER TABLE `teachers`
  ADD CONSTRAINT `FK_DEP_ID` FOREIGN KEY (`department_id`) REFERENCES `departments` (`department_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_TITLE_ID` FOREIGN KEY (`title_id`) REFERENCES `titles` (`title_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `t_profile`
--
ALTER TABLE `t_profile`
  ADD CONSTRAINT `FK_TEACHR_ID` FOREIGN KEY (`teacher_id`) REFERENCES `teachers` (`teacher_id`) ON DELETE CASCADE ON UPDATE CASCADE;

DELIMITER $$
--
-- Events
--
CREATE DEFINER=`root`@`localhost` EVENT `delete_code` ON SCHEDULE EVERY 1 SECOND STARTS '2022-03-10 15:35:37' ON COMPLETION NOT PRESERVE ENABLE COMMENT 'Clears out expired verification codes each second.' DO UPDATE `st_login` SET `code` = NULL, `code_expire_in` = NULL WHERE `code_expire_in` <= NOW()$$

CREATE DEFINER=`root`@`localhost` EVENT `update_status` ON SCHEDULE EVERY 1 SECOND STARTS '2022-04-05 12:27:51' ON COMPLETION NOT PRESERVE ENABLE COMMENT 'Set status to ''Offline'' if there is no activity more than 15 sec' DO UPDATE `st_login`
SET `status` = 
CASE
WHEN `last_activity` IS NULL THEN 'Offline'
WHEN (TIMESTAMPDIFF(SECOND, `last_activity`, NOW()) >= 15) THEN 'Offline'
WHEN (TIMESTAMPDIFF(SECOND, `last_activity`, NOW()) < 15) THEN 'Active'
END$$

CREATE DEFINER=`root`@`localhost` EVENT `delete_read_notifications` ON SCHEDULE EVERY 1 HOUR STARTS '2022-04-08 11:56:09' ON COMPLETION NOT PRESERVE ENABLE COMMENT 'Check for read notification every hour and delete them' DO DELETE FROM notifications WHERE is_read = 1$$

DELIMITER ;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
