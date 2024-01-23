-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               10.4.24-MariaDB - mariadb.org binary distribution
-- Server OS:                    Win64
-- HeidiSQL Version:             12.4.0.6659
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for etally_db
CREATE DATABASE IF NOT EXISTS `etally_db` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;
USE `etally_db`;

-- Dumping structure for table etally_db.tbl_events
CREATE TABLE IF NOT EXISTS `tbl_events` (
  `event_id` int(11) NOT NULL AUTO_INCREMENT,
  `event_category_id` int(11) NOT NULL DEFAULT 0,
  `event_name` varchar(150) NOT NULL,
  `event_description` varchar(255) DEFAULT NULL,
  `event_mechanics` varchar(15) NOT NULL DEFAULT 'no_image.png',
  `event_venue` varchar(255) NOT NULL,
  `event_start` datetime NOT NULL,
  `event_end` datetime NOT NULL,
  `event_status` varchar(1) NOT NULL DEFAULT 'S' COMMENT 'S=Open For Registration;P=Ongoing;F=Finish',
  `participant_needed` int(11) NOT NULL DEFAULT 0,
  `judge_needed` int(11) NOT NULL DEFAULT 0,
  `protest_hrs` decimal(12,2) NOT NULL DEFAULT 0.00,
  `encoded_by` int(11) NOT NULL DEFAULT 0,
  `date_added` datetime NOT NULL DEFAULT current_timestamp(),
  `date_modified` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`event_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- Dumping data for table etally_db.tbl_events: ~3 rows (approximately)
INSERT INTO `tbl_events` (`event_id`, `event_category_id`, `event_name`, `event_description`, `event_mechanics`, `event_venue`, `event_start`, `event_end`, `event_status`, `participant_needed`, `judge_needed`, `protest_hrs`, `encoded_by`, `date_added`, `date_modified`) VALUES
	(1, 1, 'Swimminh', 'Singing Contest ', '7a56tbNW7.pdf', ' ', '2024-01-23 16:59:00', '2024-01-19 10:00:00', 'P', 5, 4, 3.00, 0, '2023-10-28 14:18:34', '2024-01-23 21:26:30'),
	(2, 2, 'Badminton', 'Male Category', 'jlW0rT7Cp.pdf', 'University Gym', '2024-01-23 16:59:00', '0000-00-00 00:00:00', 'P', 10, 3, 3.00, 0, '2023-10-28 15:52:37', '2024-01-23 21:26:33'),
	(3, 1, 'hhhh', '  ', '8roZkVRk0.pdf', ' ', '2024-01-23 16:00:00', '0000-00-00 00:00:00', 'S', 4, 3, 3.00, 0, '2024-01-19 15:01:42', '2024-01-23 21:26:35');

-- Dumping structure for table etally_db.tbl_event_categories
CREATE TABLE IF NOT EXISTS `tbl_event_categories` (
  `event_category_id` int(11) NOT NULL AUTO_INCREMENT,
  `event_category` varchar(255) NOT NULL DEFAULT '0',
  `date_added` datetime NOT NULL DEFAULT current_timestamp(),
  `date_modified` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`event_category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

-- Dumping data for table etally_db.tbl_event_categories: ~6 rows (approximately)
INSERT INTO `tbl_event_categories` (`event_category_id`, `event_category`, `date_added`, `date_modified`) VALUES
	(1, 'Literary Arts', '2023-10-27 15:45:06', '2023-10-27 15:46:14'),
	(2, 'Visual Arts', '2023-10-28 14:07:49', '2023-10-28 14:07:49'),
	(3, 'Music', '2023-10-28 14:08:05', '2023-10-28 14:08:05'),
	(4, 'Dance', '2023-10-28 14:08:09', '2023-10-28 14:08:09'),
	(5, 'Performing Arts', '2023-10-28 14:08:24', '2023-10-28 14:08:24'),
	(6, 'Special Category', '2023-10-28 14:08:35', '2023-10-28 14:08:35');

-- Dumping structure for table etally_db.tbl_event_criterias
CREATE TABLE IF NOT EXISTS `tbl_event_criterias` (
  `criteria_id` int(11) NOT NULL AUTO_INCREMENT,
  `ch_id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL DEFAULT 0,
  `criteria` text NOT NULL,
  `points` decimal(12,2) NOT NULL DEFAULT 0.00,
  `date_added` datetime NOT NULL DEFAULT current_timestamp(),
  `date_modified` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`criteria_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

-- Dumping data for table etally_db.tbl_event_criterias: ~4 rows (approximately)
INSERT INTO `tbl_event_criterias` (`criteria_id`, `ch_id`, `event_id`, `criteria`, `points`, `date_added`, `date_modified`) VALUES
	(1, 1, 1, 'Performance\n  - Mastery\n  - Presence', 50.00, '2023-11-06 16:22:39', '2023-11-06 16:22:39'),
	(2, 2, 1, 'Mastery of Skills', 25.00, '2023-11-06 16:38:45', '2023-11-06 16:38:45'),
	(3, 2, 1, 'Presence', 25.00, '2023-11-06 16:38:45', '2023-11-06 16:38:45'),
	(4, 3, 2, 'a', 20.00, '2023-11-21 14:20:51', '2023-11-21 14:20:51'),
	(5, 4, 2, 'criteria 2', 50.00, '2024-01-23 22:39:17', '2024-01-23 22:39:17');

-- Dumping structure for table etally_db.tbl_event_criteria_header
CREATE TABLE IF NOT EXISTS `tbl_event_criteria_header` (
  `ch_id` int(11) NOT NULL AUTO_INCREMENT,
  `event_id` int(11) NOT NULL DEFAULT 0,
  `is_normal` int(1) NOT NULL DEFAULT 1 COMMENT '1=Normal;0=With Sub',
  `criteria` varchar(255) NOT NULL DEFAULT '0',
  `points` decimal(12,2) NOT NULL DEFAULT 0.00,
  `date_added` datetime NOT NULL DEFAULT current_timestamp(),
  `date_modified` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`ch_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

-- Dumping data for table etally_db.tbl_event_criteria_header: ~3 rows (approximately)
INSERT INTO `tbl_event_criteria_header` (`ch_id`, `event_id`, `is_normal`, `criteria`, `points`, `date_added`, `date_modified`) VALUES
	(1, 1, 1, 'Performance\n  - Mastery\n  - Presence', 50.00, '2023-11-06 16:22:39', '2023-11-06 16:22:39'),
	(2, 1, 0, 'Performance', 50.00, '2023-11-06 16:38:45', '2023-11-06 16:38:45'),
	(3, 2, 1, 'a', 20.00, '2023-11-21 14:20:51', '2023-11-21 14:20:51'),
	(4, 2, 1, 'criteria 2', 50.00, '2024-01-23 22:39:17', '2024-01-23 22:39:17');

-- Dumping structure for table etally_db.tbl_event_judges
CREATE TABLE IF NOT EXISTS `tbl_event_judges` (
  `event_judge_id` int(11) NOT NULL AUTO_INCREMENT,
  `event_id` int(11) NOT NULL DEFAULT 0,
  `judge_id` int(11) NOT NULL DEFAULT 0,
  `judge_no` int(11) NOT NULL DEFAULT 0,
  `status` int(11) NOT NULL DEFAULT 0,
  `date_added` datetime NOT NULL DEFAULT current_timestamp(),
  `date_modified` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`event_judge_id`),
  KEY `event_id` (`event_id`),
  KEY `judge_id` (`judge_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

-- Dumping data for table etally_db.tbl_event_judges: ~6 rows (approximately)
INSERT INTO `tbl_event_judges` (`event_judge_id`, `event_id`, `judge_id`, `judge_no`, `status`, `date_added`, `date_modified`) VALUES
	(1, 1, 1, 1, 1, '2023-11-06 15:15:06', '2023-11-06 15:15:06'),
	(2, 1, 3, 2, 1, '2023-11-06 15:15:06', '2023-11-06 15:15:06'),
	(3, 3, 1, 1, 1, '2024-01-19 15:03:31', '2024-01-19 15:03:31'),
	(4, 3, 3, 2, 1, '2024-01-19 15:03:31', '2024-01-19 15:03:31'),
	(5, 2, 1, 1, 1, '2024-01-23 21:13:22', '2024-01-23 21:13:22'),
	(6, 2, 3, 2, 1, '2024-01-23 21:13:22', '2024-01-23 21:13:22');

-- Dumping structure for table etally_db.tbl_event_participants
CREATE TABLE IF NOT EXISTS `tbl_event_participants` (
  `event_participant_id` int(11) NOT NULL AUTO_INCREMENT,
  `event_id` int(11) NOT NULL DEFAULT 0,
  `participant_id` int(11) NOT NULL DEFAULT 0,
  `status` int(11) NOT NULL DEFAULT 0,
  `total_ranks` decimal(12,2) NOT NULL,
  `rank` decimal(12,2) NOT NULL DEFAULT 0.00,
  `date_added` datetime NOT NULL DEFAULT current_timestamp(),
  `date_modified` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`event_participant_id`) USING BTREE,
  KEY `event_id` (`event_id`) USING BTREE,
  KEY `participant_id` (`participant_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

-- Dumping data for table etally_db.tbl_event_participants: ~8 rows (approximately)
INSERT INTO `tbl_event_participants` (`event_participant_id`, `event_id`, `participant_id`, `status`, `total_ranks`, `rank`, `date_added`, `date_modified`) VALUES
	(2, 1, 2, 1, 7.00, 3.00, '2023-10-28 15:42:15', '2024-01-23 21:16:09'),
	(5, 2, 4, 1, 0.00, 0.00, '2023-10-28 15:52:52', '2024-01-23 21:16:30'),
	(7, 3, 1, 1, 0.00, 0.00, '2024-01-19 15:03:19', '2024-01-19 15:03:19'),
	(8, 3, 2, 1, 0.00, 0.00, '2024-01-19 15:03:19', '2024-01-19 15:03:19'),
	(9, 3, 4, 1, 0.00, 0.00, '2024-01-19 15:03:19', '2024-01-19 15:03:19'),
	(10, 1, 9, 1, 0.00, 0.00, '2024-01-23 21:16:09', '2024-01-23 21:16:09'),
	(11, 2, 2, 1, 0.00, 0.00, '2024-01-23 21:16:30', '2024-01-23 21:16:30'),
	(12, 2, 9, 1, 0.00, 0.00, '2024-01-23 21:16:30', '2024-01-23 21:16:30');

-- Dumping structure for table etally_db.tbl_event_ranks
CREATE TABLE IF NOT EXISTS `tbl_event_ranks` (
  `rank_id` int(11) NOT NULL AUTO_INCREMENT,
  `event_id` int(11) NOT NULL DEFAULT 0,
  `judge_id` int(11) NOT NULL DEFAULT 0,
  `participant_id` int(11) NOT NULL DEFAULT 0,
  `rank` decimal(12,2) NOT NULL DEFAULT 0.00,
  `scores` decimal(12,2) NOT NULL DEFAULT 0.00,
  `date_added` datetime NOT NULL DEFAULT current_timestamp(),
  `date_modified` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`rank_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- Dumping data for table etally_db.tbl_event_ranks: ~8 rows (approximately)
INSERT INTO `tbl_event_ranks` (`rank_id`, `event_id`, `judge_id`, `participant_id`, `rank`, `scores`, `date_added`, `date_modified`) VALUES
	(9, 1, 3, 1, 4.00, 72.00, '2023-11-15 10:08:00', '2023-11-15 10:08:00'),
	(10, 1, 3, 2, 3.00, 76.00, '2023-11-15 10:08:00', '2023-11-15 10:08:00'),
	(11, 1, 3, 6, 2.00, 84.00, '2023-11-15 10:08:00', '2023-11-15 10:08:00'),
	(12, 1, 3, 8, 1.00, 91.00, '2023-11-15 10:08:00', '2023-11-15 10:08:00'),
	(13, 1, 1, 1, 3.00, 90.00, '2023-11-21 11:36:19', '2023-11-21 11:36:19'),
	(14, 1, 1, 2, 4.00, 77.00, '2023-11-21 11:36:19', '2023-11-21 11:36:20'),
	(15, 1, 1, 6, 1.00, 100.00, '2023-11-21 11:36:19', '2023-11-21 11:36:19'),
	(16, 1, 1, 8, 2.00, 99.00, '2023-11-21 11:36:19', '2023-11-21 11:36:19'),
	(17, 2, 3, 4, 2.00, 34.00, '2024-01-23 22:56:46', '2024-01-23 22:56:46'),
	(18, 2, 3, 2, 3.00, 0.00, '2024-01-23 22:56:46', '2024-01-23 22:56:46'),
	(19, 2, 3, 9, 1.00, 63.00, '2024-01-23 22:56:46', '2024-01-23 22:56:46');

-- Dumping structure for table etally_db.tbl_event_scores
CREATE TABLE IF NOT EXISTS `tbl_event_scores` (
  `score_id` int(11) NOT NULL AUTO_INCREMENT,
  `event_id` int(11) NOT NULL DEFAULT 0,
  `criteria_id` int(11) NOT NULL DEFAULT 0,
  `judge_id` int(11) NOT NULL DEFAULT 0,
  `participant_id` int(11) NOT NULL DEFAULT 0,
  `points` decimal(12,2) NOT NULL DEFAULT 0.00,
  `date_added` datetime NOT NULL DEFAULT current_timestamp(),
  `date_modified` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`score_id`)
) ENGINE=InnoDB AUTO_INCREMENT=53 DEFAULT CHARSET=latin1;

-- Dumping data for table etally_db.tbl_event_scores: ~24 rows (approximately)
INSERT INTO `tbl_event_scores` (`score_id`, `event_id`, `criteria_id`, `judge_id`, `participant_id`, `points`, `date_added`, `date_modified`) VALUES
	(25, 1, 1, 3, 1, 40.00, '2023-11-15 10:08:00', '2023-11-15 10:08:00'),
	(26, 1, 2, 3, 1, 15.00, '2023-11-15 10:08:00', '2023-11-15 10:08:00'),
	(27, 1, 3, 3, 1, 17.00, '2023-11-15 10:08:00', '2023-11-15 10:08:00'),
	(28, 1, 1, 3, 2, 50.00, '2023-11-15 10:08:00', '2023-11-15 10:08:00'),
	(29, 1, 2, 3, 2, 11.00, '2023-11-15 10:08:00', '2023-11-15 10:08:00'),
	(30, 1, 3, 3, 2, 15.00, '2023-11-15 10:08:00', '2023-11-15 10:08:00'),
	(31, 1, 1, 3, 6, 50.00, '2023-11-15 10:08:00', '2023-11-15 10:08:00'),
	(32, 1, 2, 3, 6, 20.00, '2023-11-15 10:08:00', '2023-11-15 10:08:00'),
	(33, 1, 3, 3, 6, 14.00, '2023-11-15 10:08:00', '2023-11-15 10:08:00'),
	(34, 1, 1, 3, 8, 48.00, '2023-11-15 10:08:00', '2023-11-15 10:08:00'),
	(35, 1, 2, 3, 8, 18.00, '2023-11-15 10:08:00', '2023-11-15 10:08:00'),
	(36, 1, 3, 3, 8, 25.00, '2023-11-15 10:08:00', '2023-11-15 10:08:00'),
	(37, 1, 1, 1, 1, 43.00, '2023-11-21 11:36:19', '2023-11-21 11:36:19'),
	(38, 1, 2, 1, 1, 24.00, '2023-11-21 11:36:19', '2023-11-21 11:36:19'),
	(39, 1, 3, 1, 1, 23.00, '2023-11-21 11:36:19', '2023-11-21 11:36:19'),
	(40, 1, 1, 1, 2, 38.00, '2023-11-21 11:36:19', '2023-11-21 11:36:19'),
	(41, 1, 2, 1, 2, 21.00, '2023-11-21 11:36:19', '2023-11-21 11:36:19'),
	(42, 1, 3, 1, 2, 18.00, '2023-11-21 11:36:19', '2023-11-21 11:36:19'),
	(43, 1, 1, 1, 6, 50.00, '2023-11-21 11:36:19', '2023-11-21 11:36:19'),
	(44, 1, 2, 1, 6, 25.00, '2023-11-21 11:36:19', '2023-11-21 11:36:19'),
	(45, 1, 3, 1, 6, 25.00, '2023-11-21 11:36:19', '2023-11-21 11:36:19'),
	(46, 1, 1, 1, 8, 50.00, '2023-11-21 11:36:19', '2023-11-21 11:36:19'),
	(47, 1, 2, 1, 8, 25.00, '2023-11-21 11:36:19', '2023-11-21 11:36:19'),
	(48, 1, 3, 1, 8, 24.00, '2023-11-21 11:36:19', '2023-11-21 11:36:19'),
	(49, 2, 4, 3, 4, 20.00, '2024-01-23 22:41:21', '2024-01-23 22:41:21'),
	(50, 2, 5, 3, 4, 14.00, '2024-01-23 22:48:34', '2024-01-23 22:48:34'),
	(51, 2, 4, 3, 9, 15.00, '2024-01-23 22:49:27', '2024-01-23 22:49:27'),
	(52, 2, 5, 3, 9, 48.00, '2024-01-23 22:49:41', '2024-01-23 22:49:41');

-- Dumping structure for table etally_db.tbl_judges
CREATE TABLE IF NOT EXISTS `tbl_judges` (
  `judge_id` int(11) NOT NULL AUTO_INCREMENT,
  `judge_name` varchar(150) NOT NULL,
  `judge_affiliation` varchar(150) NOT NULL,
  `judge_qualification` varchar(15) NOT NULL DEFAULT 'no_image.png',
  `judge_img` varchar(15) NOT NULL DEFAULT 'user.png',
  `encoded_by` int(11) NOT NULL DEFAULT 0,
  `date_added` datetime NOT NULL DEFAULT current_timestamp(),
  `date_modified` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`judge_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- Dumping data for table etally_db.tbl_judges: ~2 rows (approximately)
INSERT INTO `tbl_judges` (`judge_id`, `judge_name`, `judge_affiliation`, `judge_qualification`, `judge_img`, `encoded_by`, `date_added`, `date_modified`) VALUES
	(1, 'Eduard Rino Carton', 'Juancoders', 'vV6h9LXVY.pdf', 'user.png', 0, '2023-10-13 13:47:59', '2023-10-13 13:53:11'),
	(3, 'Judge 1', 'aasdas', 'no_image.png', 'user.png', 0, '2023-10-13 14:24:25', '2023-10-13 14:24:25');

-- Dumping structure for table etally_db.tbl_participants
CREATE TABLE IF NOT EXISTS `tbl_participants` (
  `participant_id` int(11) NOT NULL AUTO_INCREMENT,
  `participant_name` varchar(255) DEFAULT NULL,
  `participant_affiliation` varchar(255) DEFAULT NULL,
  `program_id` int(11) NOT NULL,
  `participant_year` varchar(15) DEFAULT NULL,
  `participant_img` varchar(15) DEFAULT 'user_img.png',
  `date_added` datetime NOT NULL DEFAULT current_timestamp(),
  `date_modified` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`participant_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

-- Dumping data for table etally_db.tbl_participants: ~7 rows (approximately)
INSERT INTO `tbl_participants` (`participant_id`, `participant_name`, `participant_affiliation`, `program_id`, `participant_year`, `participant_img`, `date_added`, `date_modified`) VALUES
	(2, 'Participant 2', 'BSIS', 1, 'Third Year', 'user_img.png', '2023-10-11 16:09:16', '2023-10-28 15:46:04'),
	(4, 'Participant 3', 'a', 4, 'Second Year', 'user_img.png', '2023-10-11 16:23:41', '2023-10-28 15:46:05'),
	(5, 'Participant 4', 'as', 3, 'Fourth Year', 'user_img.png', '2023-10-18 11:36:37', '2023-10-28 15:46:06'),
	(6, 'Participant 5', 'sasasd', 3, 'Second Year', 'user_img.png', '2023-10-18 11:36:43', '2023-10-28 15:46:07'),
	(7, 'Participant 6', NULL, 2, 'Second Year', 'user_img.png', '2023-11-06 15:10:19', '2023-11-06 15:10:19'),
	(8, 'Participant 7', NULL, 2, 'First Year', 'm3RY4xBpF.jpg', '2023-11-06 15:13:23', '2023-11-09 15:05:23'),
	(9, 'Participant 1', NULL, 2, 'Second Year', 'HA5dsHONO.png', '2024-01-23 21:15:43', '2024-01-23 21:15:43');

-- Dumping structure for table etally_db.tbl_programs
CREATE TABLE IF NOT EXISTS `tbl_programs` (
  `program_id` int(11) NOT NULL AUTO_INCREMENT,
  `program_name` varchar(255) NOT NULL DEFAULT '0',
  `date_added` datetime NOT NULL DEFAULT current_timestamp(),
  `date_modified` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`program_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

-- Dumping data for table etally_db.tbl_programs: ~4 rows (approximately)
INSERT INTO `tbl_programs` (`program_id`, `program_name`, `date_added`, `date_modified`) VALUES
	(1, 'BSINFO', '2023-10-28 15:00:46', '2023-10-28 15:01:01'),
	(2, 'BSIS', '2023-10-28 15:00:56', '2023-10-28 15:00:56'),
	(3, 'BTVTED', '2023-10-28 15:01:07', '2023-10-28 15:01:07'),
	(4, 'BSIT', '2023-10-28 15:01:16', '2023-10-28 15:01:16');

-- Dumping structure for table etally_db.tbl_protests
CREATE TABLE IF NOT EXISTS `tbl_protests` (
  `protest_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_token` varchar(50) NOT NULL DEFAULT '0',
  `event_id` int(11) NOT NULL DEFAULT 0,
  `protest` text NOT NULL,
  `date_added` datetime NOT NULL DEFAULT current_timestamp(),
  `date_modified` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `user_id` int(11) NOT NULL DEFAULT 0,
  `status` varchar(1) NOT NULL DEFAULT 'P',
  PRIMARY KEY (`protest_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

-- Dumping data for table etally_db.tbl_protests: ~6 rows (approximately)
INSERT INTO `tbl_protests` (`protest_id`, `user_token`, `event_id`, `protest`, `date_added`, `date_modified`, `user_id`, `status`) VALUES
	(1, 'cmD2m', 4, 'gfhfg', '2023-10-26 15:48:20', '2024-01-19 03:16:56', 0, 'P'),
	(2, 'zLMra', 4, 'fgdgd', '2023-10-26 15:48:44', '2024-01-19 03:16:47', 0, 'P'),
	(3, 'sHIlF', 4, 'dfdgdg', '2023-10-26 15:48:51', '2024-01-19 03:16:52', 0, 'P'),
	(4, 'xgu0q', 1, 'vhgv', '2024-01-19 11:14:24', '2024-01-19 11:14:24', 0, 'P'),
	(5, 'cYBO4', 1, 'sample protest', '2024-01-23 21:26:44', '2024-01-23 21:26:44', 0, 'P'),
	(6, 'DHyUY', 1, 'sample protest', '2024-01-23 21:27:22', '2024-01-23 21:27:22', 9, 'P');

-- Dumping structure for table etally_db.tbl_users
CREATE TABLE IF NOT EXISTS `tbl_users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `account_id` int(11) NOT NULL DEFAULT 0,
  `account_name` varchar(50) NOT NULL DEFAULT '0',
  `username` varchar(50) NOT NULL DEFAULT '0',
  `password` varchar(32) NOT NULL DEFAULT '0',
  `user_category` varchar(1) NOT NULL DEFAULT '0',
  `user_img` varchar(15) NOT NULL DEFAULT 'user_img.png',
  `date_added` datetime NOT NULL DEFAULT current_timestamp(),
  `date_modified` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;

-- Dumping data for table etally_db.tbl_users: ~5 rows (approximately)
INSERT INTO `tbl_users` (`user_id`, `account_id`, `account_name`, `username`, `password`, `user_category`, `user_img`, `date_added`, `date_modified`) VALUES
	(1, 0, 'Event Organizer', 'admin', '0cc175b9c0f1b6a831c399e269772661', 'A', 'iaXlMxv4s.png', '2023-10-12 09:22:59', '2023-11-29 13:54:42'),
	(11, 1, 'Eduard RIno Cartons', 'eduard1', '0cc175b9c0f1b6a831c399e269772661', 'J', 'user_img.png', '2023-10-13 13:47:59', '2023-10-13 13:47:59'),
	(13, 3, 'Judge 1', 'judge1', '0cc175b9c0f1b6a831c399e269772661', 'J', 'user_img.png', '2023-10-13 14:24:25', '2023-10-13 14:24:25'),
	(15, 0, 'Organizer', 'org1', '0cc175b9c0f1b6a831c399e269772661', 'O', 'user_img.png', '2024-01-19 07:17:20', '2024-01-19 07:17:20'),
	(17, 9, '', 'p1', '0cc175b9c0f1b6a831c399e269772661', 'P', 'user_img.png', '2024-01-23 21:15:43', '2024-01-23 21:15:43');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
