-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               10.1.21-MariaDB - mariadb.org binary distribution
-- Server OS:                    Win32
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
CREATE DATABASE IF NOT EXISTS `etally_db` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `etally_db`;

-- Dumping structure for table etally_db.tbl_events
CREATE TABLE IF NOT EXISTS `tbl_events` (
  `event_id` int(11) NOT NULL AUTO_INCREMENT,
  `event_name` varchar(150) NOT NULL,
  `event_description` varchar(255) DEFAULT NULL,
  `event_mechanics` varchar(15) NOT NULL DEFAULT 'no_image.png',
  `event_start` date NOT NULL,
  `event_end` date NOT NULL,
  `event_status` varchar(1) NOT NULL DEFAULT 'S' COMMENT 'S=Open For Registration;P=Ongoing;F=Finish',
  `participant_needed` int(11) NOT NULL DEFAULT '0',
  `judge_needed` int(11) NOT NULL DEFAULT '0',
  `encoded_by` int(11) NOT NULL DEFAULT '0',
  `date_added` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_modified` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`event_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- Dumping data for table etally_db.tbl_events: ~3 rows (approximately)
INSERT INTO `tbl_events` (`event_id`, `event_name`, `event_description`, `event_mechanics`, `event_start`, `event_end`, `event_status`, `participant_needed`, `judge_needed`, `encoded_by`, `date_added`, `date_modified`) VALUES
	(1, 'Radio Drama', 'Male Category', 'qLmPKMKjj.pdf', '2023-10-13', '0000-00-00', 'F', 30, 5, 0, '2023-10-13 13:57:51', '2023-10-19 15:14:14'),
	(2, 'Instrumental Solo', ' (2017 â€“ PIANO)', 'P0NSmfyMT.pdf', '2023-10-13', '0000-00-00', 'S', 10, 3, 0, '2023-10-13 14:25:10', '2023-10-13 14:25:10'),
	(3, 'Radio Drama', 'Male Category', 'qLmPKMKjj.pdf', '2023-10-13', '0000-00-00', 'P', 30, 5, 0, '2023-10-13 13:57:51', '2023-10-18 11:05:10');

-- Dumping structure for table etally_db.tbl_event_criterias
CREATE TABLE IF NOT EXISTS `tbl_event_criterias` (
  `criteria_id` int(11) NOT NULL AUTO_INCREMENT,
  `ch_id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL DEFAULT '0',
  `criteria` text NOT NULL,
  `points` decimal(12,2) NOT NULL DEFAULT '0.00',
  `date_added` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_modified` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`criteria_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

-- Dumping data for table etally_db.tbl_event_criterias: ~8 rows (approximately)
INSERT INTO `tbl_event_criterias` (`criteria_id`, `ch_id`, `event_id`, `criteria`, `points`, `date_added`, `date_modified`) VALUES
	(1, 0, 1, 'Radio Drama\r\nTheme Appropriateness - 10 \r\nVariety of characters - 10\r\nScript Flow and Continuity - 10 ', 30.00, '2023-10-13 14:11:19', '2023-10-13 14:11:19'),
	(2, 0, 1, 'B. TECHNICAL QUALITY\r\nAppropriateness of sounds -10\r\nSmoothness of production - 10 \r\nPrecision (Timing, Pacing and Transition) -10', 30.00, '2023-10-13 14:11:38', '2023-10-13 14:11:38'),
	(3, 0, 1, 'C. VOCAL QUALITY \r\nVoice flexibility - 15\r\nVoice creativity - 15 ', 30.00, '2023-10-13 14:11:54', '2023-10-13 14:11:54'),
	(4, 0, 1, 'D. OVER-ALL APPEAL\r\nDramatic effect - 5\r\nRendering/delevery - 5', 10.00, '2023-10-13 14:12:20', '2023-10-13 14:12:20'),
	(5, 0, 2, 'Technique\r\n Intonation 15\r\n Dexterity 15', 30.00, '2023-10-13 14:36:54', '2023-10-13 14:36:54'),
	(6, 0, 2, 'Mastery (Fidelity of the score', 30.00, '2023-10-13 14:37:12', '2023-10-13 14:37:12'),
	(7, 0, 2, 'Artistic Quality\r\n Expression 15\r\n Interpretation 15', 30.00, '2023-10-13 14:37:25', '2023-10-13 14:37:25'),
	(8, 0, 2, 'Stage Deportment 10', 10.00, '2023-10-13 14:37:35', '2023-10-13 14:37:35');

-- Dumping structure for table etally_db.tbl_event_criteria_header
CREATE TABLE IF NOT EXISTS `tbl_event_criteria_header` (
  `ch_id` int(11) NOT NULL AUTO_INCREMENT,
  `event_id` int(11) NOT NULL DEFAULT '0',
  `criteria` varchar(255) NOT NULL DEFAULT '0',
  `points` decimal(12,2) NOT NULL DEFAULT '0.00',
  `date_added` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_modified` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`ch_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table etally_db.tbl_event_criteria_header: ~0 rows (approximately)

-- Dumping structure for table etally_db.tbl_event_judges
CREATE TABLE IF NOT EXISTS `tbl_event_judges` (
  `event_judge_id` int(11) NOT NULL AUTO_INCREMENT,
  `event_id` int(11) NOT NULL DEFAULT '0',
  `judge_id` int(11) NOT NULL DEFAULT '0',
  `judge_no` int(11) NOT NULL DEFAULT '0',
  `status` int(11) NOT NULL DEFAULT '0',
  `date_added` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_modified` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`event_judge_id`),
  KEY `event_id` (`event_id`),
  KEY `judge_id` (`judge_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

-- Dumping data for table etally_db.tbl_event_judges: ~6 rows (approximately)
INSERT INTO `tbl_event_judges` (`event_judge_id`, `event_id`, `judge_id`, `judge_no`, `status`, `date_added`, `date_modified`) VALUES
	(1, 1, 1, 1, 1, '2023-10-13 13:58:44', '2023-10-18 11:37:08'),
	(2, 2, 1, 1, 1, '2023-10-13 14:25:23', '2023-10-13 14:25:23'),
	(3, 2, 3, 2, 1, '2023-10-13 14:25:23', '2023-10-13 14:25:23'),
	(4, 1, 3, 2, 1, '2023-10-18 11:37:08', '2023-10-18 11:37:08'),
	(5, 3, 1, 1, 1, '2023-10-18 15:55:07', '2023-10-18 15:55:07'),
	(6, 3, 3, 2, 1, '2023-10-18 15:55:07', '2023-10-18 15:55:07');

-- Dumping structure for table etally_db.tbl_event_participants
CREATE TABLE IF NOT EXISTS `tbl_event_participants` (
  `event_participant_id` int(11) NOT NULL AUTO_INCREMENT,
  `event_id` int(11) NOT NULL DEFAULT '0',
  `participant_id` int(11) NOT NULL DEFAULT '0',
  `status` int(11) NOT NULL DEFAULT '0',
  `total_ranks` decimal(12,2) NOT NULL,
  `rank` decimal(12,2) NOT NULL DEFAULT '0.00',
  `date_added` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_modified` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`event_participant_id`) USING BTREE,
  KEY `event_id` (`event_id`) USING BTREE,
  KEY `participant_id` (`participant_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

-- Dumping data for table etally_db.tbl_event_participants: ~13 rows (approximately)
INSERT INTO `tbl_event_participants` (`event_participant_id`, `event_id`, `participant_id`, `status`, `total_ranks`, `rank`, `date_added`, `date_modified`) VALUES
	(1, 1, 1, 1, 7.50, 5.00, '2023-10-13 13:58:51', '2023-10-19 15:00:05'),
	(2, 1, 2, 1, 6.50, 4.00, '2023-10-13 13:58:51', '2023-10-19 14:47:55'),
	(4, 2, 1, 1, 0.00, 0.00, '2023-10-13 14:25:34', '2023-10-13 14:25:34'),
	(5, 2, 2, 1, 0.00, 0.00, '2023-10-13 14:25:34', '2023-10-13 14:25:34'),
	(6, 2, 4, 1, 0.00, 0.00, '2023-10-13 14:25:34', '2023-10-13 14:25:34'),
	(7, 1, 4, 1, 5.00, 3.00, '2023-10-18 11:17:42', '2023-10-19 14:47:55'),
	(8, 1, 5, 1, 4.00, 1.50, '2023-10-18 11:36:55', '2023-10-19 15:14:14'),
	(9, 1, 6, 1, 4.00, 1.50, '2023-10-18 11:36:55', '2023-10-19 15:14:14'),
	(10, 3, 1, 1, 0.00, 0.00, '2023-10-18 15:55:00', '2023-10-18 15:55:00'),
	(11, 3, 2, 1, 0.00, 0.00, '2023-10-18 15:55:00', '2023-10-18 15:55:00'),
	(12, 3, 4, 1, 0.00, 0.00, '2023-10-18 15:55:00', '2023-10-18 15:55:00'),
	(13, 3, 5, 1, 0.00, 0.00, '2023-10-18 15:55:00', '2023-10-18 15:55:00'),
	(14, 3, 6, 1, 0.00, 0.00, '2023-10-18 15:55:00', '2023-10-18 15:55:00');

-- Dumping structure for table etally_db.tbl_event_ranks
CREATE TABLE IF NOT EXISTS `tbl_event_ranks` (
  `rank_id` int(11) NOT NULL AUTO_INCREMENT,
  `event_id` int(11) NOT NULL DEFAULT '0',
  `judge_id` int(11) NOT NULL DEFAULT '0',
  `participant_id` int(11) NOT NULL DEFAULT '0',
  `rank` decimal(12,2) NOT NULL DEFAULT '0.00',
  `scores` decimal(12,2) NOT NULL DEFAULT '0.00',
  `date_added` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_modified` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`rank_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=51 DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- Dumping data for table etally_db.tbl_event_ranks: ~14 rows (approximately)
INSERT INTO `tbl_event_ranks` (`rank_id`, `event_id`, `judge_id`, `participant_id`, `rank`, `scores`, `date_added`, `date_modified`) VALUES
	(35, 1, 1, 1, 5.00, 86.00, '2023-10-19 14:46:35', '2023-10-19 14:46:35'),
	(36, 1, 1, 2, 1.50, 94.00, '2023-10-19 14:46:35', '2023-10-19 14:46:35'),
	(37, 1, 1, 4, 4.00, 92.00, '2023-10-19 14:46:35', '2023-10-19 14:46:35'),
	(38, 1, 1, 5, 1.50, 94.00, '2023-10-19 14:46:35', '2023-10-19 14:46:35'),
	(39, 1, 1, 6, 1.50, 94.00, '2023-10-19 14:46:35', '2023-10-19 14:46:35'),
	(40, 2, 1, 1, 2.00, 78.00, '2023-10-19 14:46:55', '2023-10-19 14:46:55'),
	(41, 2, 1, 2, 3.00, 64.00, '2023-10-19 14:46:55', '2023-10-19 14:46:55'),
	(42, 2, 1, 4, 1.00, 93.00, '2023-10-19 14:46:55', '2023-10-19 14:46:55'),
	(43, 1, 3, 1, 2.50, 91.00, '2023-10-19 14:58:29', '2023-10-19 14:58:29'),
	(44, 1, 3, 2, 5.00, 83.00, '2023-10-19 14:58:29', '2023-10-19 14:58:29'),
	(45, 1, 3, 4, 1.00, 93.00, '2023-10-19 14:58:29', '2023-10-19 14:58:29'),
	(46, 1, 3, 5, 2.50, 91.00, '2023-10-19 14:58:29', '2023-10-19 14:58:29'),
	(47, 1, 3, 6, 2.50, 91.00, '2023-10-19 14:58:29', '2023-10-19 14:58:29'),
	(48, 2, 3, 1, 3.00, 78.00, '2023-10-19 14:59:09', '2023-10-19 14:59:09'),
	(49, 2, 3, 2, 2.00, 81.00, '2023-10-19 14:59:09', '2023-10-19 14:59:09'),
	(50, 2, 3, 4, 1.00, 90.00, '2023-10-19 14:59:09', '2023-10-19 14:59:09');

-- Dumping structure for table etally_db.tbl_event_scores
CREATE TABLE IF NOT EXISTS `tbl_event_scores` (
  `score_id` int(11) NOT NULL AUTO_INCREMENT,
  `event_id` int(11) NOT NULL DEFAULT '0',
  `criteria_id` int(11) NOT NULL DEFAULT '0',
  `judge_id` int(11) NOT NULL DEFAULT '0',
  `participant_id` int(11) NOT NULL DEFAULT '0',
  `points` decimal(12,2) NOT NULL DEFAULT '0.00',
  `date_added` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_modified` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`score_id`)
) ENGINE=InnoDB AUTO_INCREMENT=245 DEFAULT CHARSET=latin1;

-- Dumping data for table etally_db.tbl_event_scores: ~64 rows (approximately)
INSERT INTO `tbl_event_scores` (`score_id`, `event_id`, `criteria_id`, `judge_id`, `participant_id`, `points`, `date_added`, `date_modified`) VALUES
	(181, 1, 1, 1, 1, 18.00, '2023-10-19 14:46:35', '2023-10-19 14:46:35'),
	(182, 1, 2, 1, 1, 29.00, '2023-10-19 14:46:35', '2023-10-19 14:46:35'),
	(183, 1, 3, 1, 1, 30.00, '2023-10-19 14:46:35', '2023-10-19 14:46:35'),
	(184, 1, 4, 1, 1, 9.00, '2023-10-19 14:46:35', '2023-10-19 14:46:35'),
	(185, 1, 1, 1, 2, 25.00, '2023-10-19 14:46:35', '2023-10-19 14:46:35'),
	(186, 1, 2, 1, 2, 30.00, '2023-10-19 14:46:35', '2023-10-19 14:46:35'),
	(187, 1, 3, 1, 2, 30.00, '2023-10-19 14:46:35', '2023-10-19 14:46:35'),
	(188, 1, 4, 1, 2, 9.00, '2023-10-19 14:46:35', '2023-10-19 14:46:35'),
	(189, 1, 1, 1, 4, 30.00, '2023-10-19 14:46:35', '2023-10-19 14:46:35'),
	(190, 1, 2, 1, 4, 28.00, '2023-10-19 14:46:35', '2023-10-19 14:46:35'),
	(191, 1, 3, 1, 4, 26.00, '2023-10-19 14:46:35', '2023-10-19 14:46:35'),
	(192, 1, 4, 1, 4, 8.00, '2023-10-19 14:46:35', '2023-10-19 14:46:35'),
	(193, 1, 1, 1, 5, 29.00, '2023-10-19 14:46:35', '2023-10-19 14:46:35'),
	(194, 1, 2, 1, 5, 30.00, '2023-10-19 14:46:35', '2023-10-19 14:46:35'),
	(195, 1, 3, 1, 5, 27.00, '2023-10-19 14:46:35', '2023-10-19 14:46:35'),
	(196, 1, 4, 1, 5, 8.00, '2023-10-19 14:46:35', '2023-10-19 14:46:35'),
	(197, 1, 1, 1, 6, 28.00, '2023-10-19 14:46:35', '2023-10-19 14:46:35'),
	(198, 1, 2, 1, 6, 26.00, '2023-10-19 14:46:35', '2023-10-19 14:46:35'),
	(199, 1, 3, 1, 6, 30.00, '2023-10-19 14:46:35', '2023-10-19 14:46:35'),
	(200, 1, 4, 1, 6, 10.00, '2023-10-19 14:46:35', '2023-10-19 14:46:35'),
	(201, 2, 5, 1, 1, 24.00, '2023-10-19 14:46:55', '2023-10-19 14:46:55'),
	(202, 2, 6, 1, 1, 20.00, '2023-10-19 14:46:55', '2023-10-19 14:46:55'),
	(203, 2, 7, 1, 1, 26.00, '2023-10-19 14:46:55', '2023-10-19 14:46:55'),
	(204, 2, 8, 1, 1, 8.00, '2023-10-19 14:46:55', '2023-10-19 14:46:55'),
	(205, 2, 5, 1, 2, 16.00, '2023-10-19 14:46:55', '2023-10-19 14:46:55'),
	(206, 2, 6, 1, 2, 21.00, '2023-10-19 14:46:55', '2023-10-19 14:46:55'),
	(207, 2, 7, 1, 2, 20.00, '2023-10-19 14:46:55', '2023-10-19 14:46:55'),
	(208, 2, 8, 1, 2, 7.00, '2023-10-19 14:46:55', '2023-10-19 14:46:55'),
	(209, 2, 5, 1, 4, 30.00, '2023-10-19 14:46:55', '2023-10-19 14:46:55'),
	(210, 2, 6, 1, 4, 26.00, '2023-10-19 14:46:55', '2023-10-19 14:46:55'),
	(211, 2, 7, 1, 4, 28.00, '2023-10-19 14:46:55', '2023-10-19 14:46:55'),
	(212, 2, 8, 1, 4, 9.00, '2023-10-19 14:46:55', '2023-10-19 14:46:55'),
	(213, 1, 1, 3, 1, 30.00, '2023-10-19 14:58:29', '2023-10-19 14:58:29'),
	(214, 1, 2, 3, 1, 29.00, '2023-10-19 14:58:29', '2023-10-19 14:58:29'),
	(215, 1, 3, 3, 1, 25.00, '2023-10-19 14:58:29', '2023-10-19 14:58:29'),
	(216, 1, 4, 3, 1, 7.00, '2023-10-19 14:58:29', '2023-10-19 14:58:29'),
	(217, 1, 1, 3, 2, 25.00, '2023-10-19 14:58:29', '2023-10-19 14:58:29'),
	(218, 1, 2, 3, 2, 24.00, '2023-10-19 14:58:29', '2023-10-19 14:58:29'),
	(219, 1, 3, 3, 2, 25.00, '2023-10-19 14:58:29', '2023-10-19 14:58:29'),
	(220, 1, 4, 3, 2, 9.00, '2023-10-19 14:58:29', '2023-10-19 14:58:29'),
	(221, 1, 1, 3, 4, 29.00, '2023-10-19 14:58:29', '2023-10-19 14:58:29'),
	(222, 1, 2, 3, 4, 28.00, '2023-10-19 14:58:29', '2023-10-19 14:58:29'),
	(223, 1, 3, 3, 4, 28.00, '2023-10-19 14:58:29', '2023-10-19 14:58:29'),
	(224, 1, 4, 3, 4, 8.00, '2023-10-19 14:58:29', '2023-10-19 14:58:29'),
	(225, 1, 1, 3, 5, 23.00, '2023-10-19 14:58:29', '2023-10-19 14:58:29'),
	(226, 1, 2, 3, 5, 28.00, '2023-10-19 14:58:29', '2023-10-19 14:58:29'),
	(227, 1, 3, 3, 5, 30.00, '2023-10-19 14:58:29', '2023-10-19 14:58:29'),
	(228, 1, 4, 3, 5, 10.00, '2023-10-19 14:58:29', '2023-10-19 14:58:29'),
	(229, 1, 1, 3, 6, 30.00, '2023-10-19 14:58:29', '2023-10-19 14:58:29'),
	(230, 1, 2, 3, 6, 27.00, '2023-10-19 14:58:29', '2023-10-19 14:58:29'),
	(231, 1, 3, 3, 6, 27.00, '2023-10-19 14:58:29', '2023-10-19 14:58:29'),
	(232, 1, 4, 3, 6, 7.00, '2023-10-19 14:58:29', '2023-10-19 14:58:29'),
	(233, 2, 5, 3, 1, 24.00, '2023-10-19 14:59:09', '2023-10-19 14:59:09'),
	(234, 2, 6, 3, 1, 26.00, '2023-10-19 14:59:09', '2023-10-19 14:59:09'),
	(235, 2, 7, 3, 1, 21.00, '2023-10-19 14:59:09', '2023-10-19 14:59:09'),
	(236, 2, 8, 3, 1, 7.00, '2023-10-19 14:59:09', '2023-10-19 14:59:09'),
	(237, 2, 5, 3, 2, 23.00, '2023-10-19 14:59:09', '2023-10-19 14:59:09'),
	(238, 2, 6, 3, 2, 26.00, '2023-10-19 14:59:09', '2023-10-19 14:59:09'),
	(239, 2, 7, 3, 2, 25.00, '2023-10-19 14:59:09', '2023-10-19 14:59:09'),
	(240, 2, 8, 3, 2, 7.00, '2023-10-19 14:59:09', '2023-10-19 14:59:09'),
	(241, 2, 5, 3, 4, 27.00, '2023-10-19 14:59:09', '2023-10-19 14:59:09'),
	(242, 2, 6, 3, 4, 30.00, '2023-10-19 14:59:09', '2023-10-19 14:59:09'),
	(243, 2, 7, 3, 4, 25.00, '2023-10-19 14:59:09', '2023-10-19 14:59:09'),
	(244, 2, 8, 3, 4, 8.00, '2023-10-19 14:59:09', '2023-10-19 14:59:09');

-- Dumping structure for table etally_db.tbl_judges
CREATE TABLE IF NOT EXISTS `tbl_judges` (
  `judge_id` int(11) NOT NULL AUTO_INCREMENT,
  `judge_name` varchar(150) NOT NULL,
  `judge_affiliation` varchar(150) NOT NULL,
  `judge_qualification` varchar(15) NOT NULL DEFAULT 'no_image.png',
  `judge_img` varchar(15) NOT NULL DEFAULT 'user.png',
  `encoded_by` int(11) NOT NULL DEFAULT '0',
  `date_added` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_modified` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
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
  `date_added` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_modified` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`participant_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

-- Dumping data for table etally_db.tbl_participants: ~5 rows (approximately)
INSERT INTO `tbl_participants` (`participant_id`, `participant_name`, `participant_affiliation`, `date_added`, `date_modified`) VALUES
	(1, 'Participant 1', '', '2023-10-11 16:06:36', '2023-10-11 16:11:19'),
	(2, 'Participant 2', 'BSIS', '2023-10-11 16:09:16', '2023-10-11 16:11:25'),
	(4, 'Participant 3', 'a', '2023-10-11 16:23:41', '2023-10-11 16:23:41'),
	(5, 'Participant 4', 'as', '2023-10-18 11:36:37', '2023-10-18 11:36:37'),
	(6, 'Participant 5', 'asda', '2023-10-18 11:36:43', '2023-10-18 11:36:43');

-- Dumping structure for table etally_db.tbl_users
CREATE TABLE IF NOT EXISTS `tbl_users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `account_id` int(11) NOT NULL DEFAULT '0',
  `account_name` varchar(50) NOT NULL DEFAULT '0',
  `username` varchar(50) NOT NULL DEFAULT '0',
  `password` varchar(32) NOT NULL DEFAULT '0',
  `user_category` varchar(1) NOT NULL DEFAULT '0',
  `date_added` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_modified` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;

-- Dumping data for table etally_db.tbl_users: ~3 rows (approximately)
INSERT INTO `tbl_users` (`user_id`, `account_id`, `account_name`, `username`, `password`, `user_category`, `date_added`, `date_modified`) VALUES
	(1, 0, 'Event Organizer', 'admin', '0cc175b9c0f1b6a831c399e269772661', 'O', '2023-10-12 09:22:59', '2023-10-12 09:23:29'),
	(11, 1, 'Eduard RIno Cartons', 'eduard1', '0cc175b9c0f1b6a831c399e269772661', 'J', '2023-10-13 13:47:59', '2023-10-13 13:47:59'),
	(13, 3, 'Judge 1', 'judge1', '0cc175b9c0f1b6a831c399e269772661', 'J', '2023-10-13 14:24:25', '2023-10-13 14:24:25');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
