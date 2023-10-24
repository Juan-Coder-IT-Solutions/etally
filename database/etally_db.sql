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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

-- Dumping data for table etally_db.tbl_events: ~3 rows (approximately)
INSERT INTO `tbl_events` (`event_id`, `event_name`, `event_description`, `event_mechanics`, `event_start`, `event_end`, `event_status`, `participant_needed`, `judge_needed`, `encoded_by`, `date_added`, `date_modified`) VALUES
	(1, 'Radio Drama', 'Male Category', 'qLmPKMKjj.pdf', '2023-10-13', '0000-00-00', 'S', 30, 5, 0, '2023-10-13 13:57:51', '2023-10-20 15:40:38'),
	(2, 'Instrumental Solo', ' (2017 â€“ PIANO)', 'P0NSmfyMT.pdf', '2023-10-13', '0000-00-00', 'S', 10, 3, 0, '2023-10-13 14:25:10', '2023-10-13 14:25:10'),
	(3, 'Radio Drama', 'Male Category', 'qLmPKMKjj.pdf', '2023-10-13', '0000-00-00', 'S', 30, 5, 0, '2023-10-13 13:57:51', '2023-10-20 15:40:39'),
	(4, 'Choral Singing ', '1. Each choral group will sing the One (1) official contest piece and one (1) Original Pilipino  Music composed and arranged by a Filipino. Both pieces are with equal bearing.  2. The voice composition shall be SOPRANO, ALTO, TENOR, and BASS (SATB).  3. C', 'Y6WNjGOp7.pdf', '2023-10-20', '0000-00-00', 'F', 10, 3, 0, '2023-10-20 14:06:36', '2023-10-23 15:36:10');

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
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=latin1;

-- Dumping data for table etally_db.tbl_event_criterias: ~9 rows (approximately)
INSERT INTO `tbl_event_criterias` (`criteria_id`, `ch_id`, `event_id`, `criteria`, `points`, `date_added`, `date_modified`) VALUES
	(9, 1, 4, 'Intonation', 10.00, '2023-10-20 14:31:57', '2023-10-20 14:31:57'),
	(10, 1, 4, 'Resonance', 20.00, '2023-10-20 14:31:57', '2023-10-20 14:31:57'),
	(13, 3, 4, 'phrasing', 5.00, '2023-10-20 14:57:47', '2023-10-20 14:57:47'),
	(14, 3, 4, 'tempo', 5.00, '2023-10-20 14:57:47', '2023-10-20 14:57:47'),
	(15, 3, 4, 'dynamics', 5.00, '2023-10-20 14:57:47', '2023-10-20 14:57:47'),
	(16, 3, 4, 'Syllabication	', 5.00, '2023-10-20 14:57:47', '2023-10-20 14:57:47'),
	(18, 5, 4, 'Harmony', 15.00, '2023-10-20 15:23:54', '2023-10-20 15:23:54'),
	(19, 5, 4, 'Balance', 15.00, '2023-10-20 15:23:54', '2023-10-20 15:23:54'),
	(20, 3, 4, 'enunciations', 10.00, '2023-10-20 15:39:11', '2023-10-20 15:39:11'),
	(21, 6, 4, 'Deportment', 10.00, '2023-10-23 14:46:38', '2023-10-23 14:46:38');

-- Dumping structure for table etally_db.tbl_event_criteria_header
CREATE TABLE IF NOT EXISTS `tbl_event_criteria_header` (
  `ch_id` int(11) NOT NULL AUTO_INCREMENT,
  `event_id` int(11) NOT NULL DEFAULT '0',
  `criteria` varchar(255) NOT NULL DEFAULT '0',
  `points` decimal(12,2) NOT NULL DEFAULT '0.00',
  `date_added` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_modified` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`ch_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

-- Dumping data for table etally_db.tbl_event_criteria_header: ~2 rows (approximately)
INSERT INTO `tbl_event_criteria_header` (`ch_id`, `event_id`, `criteria`, `points`, `date_added`, `date_modified`) VALUES
	(1, 4, 'Tone Quality', 30.00, '2023-10-20 14:31:57', '2023-10-20 14:31:57'),
	(3, 4, 'Technique Interpretation', 30.00, '2023-10-20 14:57:47', '2023-10-20 14:57:47'),
	(5, 4, 'Harmony and Balance', 30.00, '2023-10-20 15:23:54', '2023-10-20 15:23:54'),
	(6, 4, 'Deportment', 10.00, '2023-10-23 14:46:38', '2023-10-23 14:46:38');

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
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

-- Dumping data for table etally_db.tbl_event_judges: ~8 rows (approximately)
INSERT INTO `tbl_event_judges` (`event_judge_id`, `event_id`, `judge_id`, `judge_no`, `status`, `date_added`, `date_modified`) VALUES
	(1, 1, 1, 1, 1, '2023-10-13 13:58:44', '2023-10-18 11:37:08'),
	(2, 2, 1, 1, 1, '2023-10-13 14:25:23', '2023-10-13 14:25:23'),
	(3, 2, 3, 2, 1, '2023-10-13 14:25:23', '2023-10-13 14:25:23'),
	(4, 1, 3, 2, 1, '2023-10-18 11:37:08', '2023-10-18 11:37:08'),
	(5, 3, 1, 1, 1, '2023-10-18 15:55:07', '2023-10-18 15:55:07'),
	(6, 3, 3, 2, 1, '2023-10-18 15:55:07', '2023-10-18 15:55:07'),
	(7, 4, 1, 1, 1, '2023-10-20 14:44:34', '2023-10-20 14:44:34'),
	(8, 4, 3, 2, 1, '2023-10-20 14:44:34', '2023-10-20 14:44:34');

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
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=latin1;

-- Dumping data for table etally_db.tbl_event_participants: ~5 rows (approximately)
INSERT INTO `tbl_event_participants` (`event_participant_id`, `event_id`, `participant_id`, `status`, `total_ranks`, `rank`, `date_added`, `date_modified`) VALUES
	(15, 4, 1, 1, 6.50, 2.00, '2023-10-20 14:44:28', '2023-10-23 16:39:55'),
	(16, 4, 2, 1, 6.50, 3.00, '2023-10-20 14:44:28', '2023-10-23 16:39:55'),
	(17, 4, 4, 1, 7.00, 4.00, '2023-10-20 14:44:28', '2023-10-23 16:39:55'),
	(18, 4, 5, 1, 2.50, 1.00, '2023-10-20 14:44:28', '2023-10-23 15:36:10'),
	(19, 4, 6, 1, 7.50, 5.00, '2023-10-20 14:44:28', '2023-10-23 16:39:39');

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
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- Dumping data for table etally_db.tbl_event_ranks: ~10 rows (approximately)
INSERT INTO `tbl_event_ranks` (`rank_id`, `event_id`, `judge_id`, `participant_id`, `rank`, `scores`, `date_added`, `date_modified`) VALUES
	(6, 4, 3, 1, 3.00, 92.00, '2023-10-23 15:28:31', '2023-10-23 15:28:32'),
	(7, 4, 3, 2, 1.50, 97.00, '2023-10-23 15:28:31', '2023-10-23 15:28:32'),
	(8, 4, 3, 4, 5.00, 88.00, '2023-10-23 15:28:31', '2023-10-23 15:28:32'),
	(9, 4, 3, 5, 1.50, 97.00, '2023-10-23 15:28:32', '2023-10-23 15:28:32'),
	(10, 4, 3, 6, 4.00, 90.00, '2023-10-23 15:28:32', '2023-10-23 15:28:32'),
	(11, 4, 1, 1, 3.50, 90.00, '2023-10-23 15:35:35', '2023-10-23 15:35:36'),
	(12, 4, 1, 2, 5.00, 84.00, '2023-10-23 15:35:35', '2023-10-23 15:35:36'),
	(13, 4, 1, 4, 2.00, 93.00, '2023-10-23 15:35:35', '2023-10-23 15:35:36'),
	(14, 4, 1, 5, 1.00, 94.00, '2023-10-23 15:35:35', '2023-10-23 15:35:36'),
	(15, 4, 1, 6, 3.50, 90.00, '2023-10-23 15:35:36', '2023-10-23 15:35:36');

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
) ENGINE=InnoDB AUTO_INCREMENT=151 DEFAULT CHARSET=latin1;

-- Dumping data for table etally_db.tbl_event_scores: ~100 rows (approximately)
INSERT INTO `tbl_event_scores` (`score_id`, `event_id`, `criteria_id`, `judge_id`, `participant_id`, `points`, `date_added`, `date_modified`) VALUES
	(51, 4, 9, 3, 1, 9.00, '2023-10-23 15:28:31', '2023-10-23 15:28:31'),
	(52, 4, 10, 3, 1, 20.00, '2023-10-23 15:28:31', '2023-10-23 15:28:31'),
	(53, 4, 13, 3, 1, 4.00, '2023-10-23 15:28:31', '2023-10-23 15:28:31'),
	(54, 4, 14, 3, 1, 4.00, '2023-10-23 15:28:31', '2023-10-23 15:28:31'),
	(55, 4, 15, 3, 1, 5.00, '2023-10-23 15:28:31', '2023-10-23 15:28:31'),
	(56, 4, 16, 3, 1, 4.00, '2023-10-23 15:28:31', '2023-10-23 15:28:31'),
	(57, 4, 20, 3, 1, 8.00, '2023-10-23 15:28:31', '2023-10-23 15:28:31'),
	(58, 4, 18, 3, 1, 13.00, '2023-10-23 15:28:31', '2023-10-23 15:28:31'),
	(59, 4, 19, 3, 1, 15.00, '2023-10-23 15:28:31', '2023-10-23 15:28:31'),
	(60, 4, 21, 3, 1, 10.00, '2023-10-23 15:28:31', '2023-10-23 15:28:31'),
	(61, 4, 9, 3, 2, 10.00, '2023-10-23 15:28:31', '2023-10-23 15:28:31'),
	(62, 4, 10, 3, 2, 20.00, '2023-10-23 15:28:31', '2023-10-23 15:28:31'),
	(63, 4, 13, 3, 2, 5.00, '2023-10-23 15:28:31', '2023-10-23 15:28:31'),
	(64, 4, 14, 3, 2, 5.00, '2023-10-23 15:28:31', '2023-10-23 15:28:31'),
	(65, 4, 15, 3, 2, 9.00, '2023-10-23 15:28:31', '2023-10-23 15:28:31'),
	(66, 4, 16, 3, 2, 4.00, '2023-10-23 15:28:31', '2023-10-23 15:28:31'),
	(67, 4, 20, 3, 2, 8.00, '2023-10-23 15:28:31', '2023-10-23 15:28:31'),
	(68, 4, 18, 3, 2, 14.00, '2023-10-23 15:28:31', '2023-10-23 15:28:31'),
	(69, 4, 19, 3, 2, 12.00, '2023-10-23 15:28:31', '2023-10-23 15:28:31'),
	(70, 4, 21, 3, 2, 10.00, '2023-10-23 15:28:31', '2023-10-23 15:28:31'),
	(71, 4, 9, 3, 4, 9.00, '2023-10-23 15:28:31', '2023-10-23 15:28:31'),
	(72, 4, 10, 3, 4, 18.00, '2023-10-23 15:28:31', '2023-10-23 15:28:31'),
	(73, 4, 13, 3, 4, 5.00, '2023-10-23 15:28:31', '2023-10-23 15:28:31'),
	(74, 4, 14, 3, 4, 4.00, '2023-10-23 15:28:31', '2023-10-23 15:28:31'),
	(75, 4, 15, 3, 4, 5.00, '2023-10-23 15:28:31', '2023-10-23 15:28:31'),
	(76, 4, 16, 3, 4, 5.00, '2023-10-23 15:28:31', '2023-10-23 15:28:31'),
	(77, 4, 20, 3, 4, 9.00, '2023-10-23 15:28:31', '2023-10-23 15:28:31'),
	(78, 4, 18, 3, 4, 13.00, '2023-10-23 15:28:31', '2023-10-23 15:28:31'),
	(79, 4, 19, 3, 4, 13.00, '2023-10-23 15:28:31', '2023-10-23 15:28:31'),
	(80, 4, 21, 3, 4, 7.00, '2023-10-23 15:28:31', '2023-10-23 15:28:31'),
	(81, 4, 9, 3, 5, 8.00, '2023-10-23 15:28:31', '2023-10-23 15:28:31'),
	(82, 4, 10, 3, 5, 20.00, '2023-10-23 15:28:31', '2023-10-23 15:28:31'),
	(83, 4, 13, 3, 5, 5.00, '2023-10-23 15:28:31', '2023-10-23 15:28:31'),
	(84, 4, 14, 3, 5, 5.00, '2023-10-23 15:28:31', '2023-10-23 15:28:31'),
	(85, 4, 15, 3, 5, 5.00, '2023-10-23 15:28:31', '2023-10-23 15:28:31'),
	(86, 4, 16, 3, 5, 4.00, '2023-10-23 15:28:32', '2023-10-23 15:28:32'),
	(87, 4, 20, 3, 5, 10.00, '2023-10-23 15:28:32', '2023-10-23 15:28:32'),
	(88, 4, 18, 3, 5, 15.00, '2023-10-23 15:28:32', '2023-10-23 15:28:32'),
	(89, 4, 19, 3, 5, 15.00, '2023-10-23 15:28:32', '2023-10-23 15:28:32'),
	(90, 4, 21, 3, 5, 10.00, '2023-10-23 15:28:32', '2023-10-23 15:28:32'),
	(91, 4, 9, 3, 6, 10.00, '2023-10-23 15:28:32', '2023-10-23 15:28:32'),
	(92, 4, 10, 3, 6, 20.00, '2023-10-23 15:28:32', '2023-10-23 15:28:32'),
	(93, 4, 13, 3, 6, 5.00, '2023-10-23 15:28:32', '2023-10-23 15:28:32'),
	(94, 4, 14, 3, 6, 5.00, '2023-10-23 15:28:32', '2023-10-23 15:28:32'),
	(95, 4, 15, 3, 6, 4.00, '2023-10-23 15:28:32', '2023-10-23 15:28:32'),
	(96, 4, 16, 3, 6, 5.00, '2023-10-23 15:28:32', '2023-10-23 15:28:32'),
	(97, 4, 20, 3, 6, 8.00, '2023-10-23 15:28:32', '2023-10-23 15:28:32'),
	(98, 4, 18, 3, 6, 12.00, '2023-10-23 15:28:32', '2023-10-23 15:28:32'),
	(99, 4, 19, 3, 6, 13.00, '2023-10-23 15:28:32', '2023-10-23 15:28:32'),
	(100, 4, 21, 3, 6, 8.00, '2023-10-23 15:28:32', '2023-10-23 15:28:32'),
	(101, 4, 9, 1, 1, 10.00, '2023-10-23 15:35:35', '2023-10-23 15:35:35'),
	(102, 4, 10, 1, 1, 17.00, '2023-10-23 15:35:35', '2023-10-23 15:35:35'),
	(103, 4, 13, 1, 1, 4.00, '2023-10-23 15:35:35', '2023-10-23 15:35:35'),
	(104, 4, 14, 1, 1, 5.00, '2023-10-23 15:35:35', '2023-10-23 15:35:35'),
	(105, 4, 15, 1, 1, 5.00, '2023-10-23 15:35:35', '2023-10-23 15:35:35'),
	(106, 4, 16, 1, 1, 5.00, '2023-10-23 15:35:35', '2023-10-23 15:35:35'),
	(107, 4, 20, 1, 1, 7.00, '2023-10-23 15:35:35', '2023-10-23 15:35:35'),
	(108, 4, 18, 1, 1, 14.00, '2023-10-23 15:35:35', '2023-10-23 15:35:35'),
	(109, 4, 19, 1, 1, 14.00, '2023-10-23 15:35:35', '2023-10-23 15:35:35'),
	(110, 4, 21, 1, 1, 9.00, '2023-10-23 15:35:35', '2023-10-23 15:35:35'),
	(111, 4, 9, 1, 2, 8.00, '2023-10-23 15:35:35', '2023-10-23 15:35:35'),
	(112, 4, 10, 1, 2, 20.00, '2023-10-23 15:35:35', '2023-10-23 15:35:35'),
	(113, 4, 13, 1, 2, 4.00, '2023-10-23 15:35:35', '2023-10-23 15:35:35'),
	(114, 4, 14, 1, 2, 4.00, '2023-10-23 15:35:35', '2023-10-23 15:35:35'),
	(115, 4, 15, 1, 2, 3.00, '2023-10-23 15:35:35', '2023-10-23 15:35:35'),
	(116, 4, 16, 1, 2, 4.00, '2023-10-23 15:35:35', '2023-10-23 15:35:35'),
	(117, 4, 20, 1, 2, 8.00, '2023-10-23 15:35:35', '2023-10-23 15:35:35'),
	(118, 4, 18, 1, 2, 11.00, '2023-10-23 15:35:35', '2023-10-23 15:35:35'),
	(119, 4, 19, 1, 2, 14.00, '2023-10-23 15:35:35', '2023-10-23 15:35:35'),
	(120, 4, 21, 1, 2, 8.00, '2023-10-23 15:35:35', '2023-10-23 15:35:35'),
	(121, 4, 9, 1, 4, 10.00, '2023-10-23 15:35:35', '2023-10-23 15:35:35'),
	(122, 4, 10, 1, 4, 16.00, '2023-10-23 15:35:35', '2023-10-23 15:35:35'),
	(123, 4, 13, 1, 4, 5.00, '2023-10-23 15:35:35', '2023-10-23 15:35:35'),
	(124, 4, 14, 1, 4, 5.00, '2023-10-23 15:35:35', '2023-10-23 15:35:35'),
	(125, 4, 15, 1, 4, 5.00, '2023-10-23 15:35:35', '2023-10-23 15:35:35'),
	(126, 4, 16, 1, 4, 5.00, '2023-10-23 15:35:35', '2023-10-23 15:35:35'),
	(127, 4, 20, 1, 4, 9.00, '2023-10-23 15:35:35', '2023-10-23 15:35:35'),
	(128, 4, 18, 1, 4, 14.00, '2023-10-23 15:35:35', '2023-10-23 15:35:35'),
	(129, 4, 19, 1, 4, 14.00, '2023-10-23 15:35:35', '2023-10-23 15:35:35'),
	(130, 4, 21, 1, 4, 10.00, '2023-10-23 15:35:35', '2023-10-23 15:35:35'),
	(131, 4, 9, 1, 5, 9.00, '2023-10-23 15:35:35', '2023-10-23 15:35:35'),
	(132, 4, 10, 1, 5, 18.00, '2023-10-23 15:35:35', '2023-10-23 15:35:35'),
	(133, 4, 13, 1, 5, 4.00, '2023-10-23 15:35:35', '2023-10-23 15:35:35'),
	(134, 4, 14, 1, 5, 5.00, '2023-10-23 15:35:35', '2023-10-23 15:35:35'),
	(135, 4, 15, 1, 5, 5.00, '2023-10-23 15:35:35', '2023-10-23 15:35:35'),
	(136, 4, 16, 1, 5, 4.00, '2023-10-23 15:35:35', '2023-10-23 15:35:35'),
	(137, 4, 20, 1, 5, 10.00, '2023-10-23 15:35:35', '2023-10-23 15:35:35'),
	(138, 4, 18, 1, 5, 15.00, '2023-10-23 15:35:35', '2023-10-23 15:35:35'),
	(139, 4, 19, 1, 5, 14.00, '2023-10-23 15:35:35', '2023-10-23 15:35:35'),
	(140, 4, 21, 1, 5, 10.00, '2023-10-23 15:35:35', '2023-10-23 15:35:35'),
	(141, 4, 9, 1, 6, 9.00, '2023-10-23 15:35:35', '2023-10-23 15:35:35'),
	(142, 4, 10, 1, 6, 16.00, '2023-10-23 15:35:35', '2023-10-23 15:35:35'),
	(143, 4, 13, 1, 6, 5.00, '2023-10-23 15:35:36', '2023-10-23 15:35:36'),
	(144, 4, 14, 1, 6, 5.00, '2023-10-23 15:35:36', '2023-10-23 15:35:36'),
	(145, 4, 15, 1, 6, 5.00, '2023-10-23 15:35:36', '2023-10-23 15:35:36'),
	(146, 4, 16, 1, 6, 5.00, '2023-10-23 15:35:36', '2023-10-23 15:35:36'),
	(147, 4, 20, 1, 6, 10.00, '2023-10-23 15:35:36', '2023-10-23 15:35:36'),
	(148, 4, 18, 1, 6, 11.00, '2023-10-23 15:35:36', '2023-10-23 15:35:36'),
	(149, 4, 19, 1, 6, 14.00, '2023-10-23 15:35:36', '2023-10-23 15:35:36'),
	(150, 4, 21, 1, 6, 10.00, '2023-10-23 15:35:36', '2023-10-23 15:35:36');

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
  `user_img` varchar(15) NOT NULL DEFAULT 'user_img.png',
  `date_added` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_modified` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;

-- Dumping data for table etally_db.tbl_users: ~3 rows (approximately)
INSERT INTO `tbl_users` (`user_id`, `account_id`, `account_name`, `username`, `password`, `user_category`, `user_img`, `date_added`, `date_modified`) VALUES
	(1, 0, 'Event Organizer', 'admin', '0cc175b9c0f1b6a831c399e269772661', 'O', 'iaXlMxv4s.png', '2023-10-12 09:22:59', '2023-10-24 16:36:12'),
	(11, 1, 'Eduard RIno Cartons', 'eduard1', '0cc175b9c0f1b6a831c399e269772661', 'J', 'user_img.png', '2023-10-13 13:47:59', '2023-10-13 13:47:59'),
	(13, 3, 'Judge 1', 'judge1', '0cc175b9c0f1b6a831c399e269772661', 'J', 'user_img.png', '2023-10-13 14:24:25', '2023-10-13 14:24:25');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
