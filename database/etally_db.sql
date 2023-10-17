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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- Dumping data for table etally_db.tbl_events: ~2 rows (approximately)
INSERT INTO `tbl_events` (`event_id`, `event_name`, `event_description`, `event_mechanics`, `event_start`, `event_end`, `event_status`, `participant_needed`, `judge_needed`, `encoded_by`, `date_added`, `date_modified`) VALUES
	(1, 'Radio Drama', 'Male Category', 'qLmPKMKjj.pdf', '2023-10-13', '0000-00-00', 'S', 30, 5, 0, '2023-10-13 13:57:51', '2023-10-13 14:10:32'),
	(2, 'Instrumental Solo', ' (2017 â€“ PIANO)', 'P0NSmfyMT.pdf', '2023-10-13', '0000-00-00', 'S', 10, 3, 0, '2023-10-13 14:25:10', '2023-10-13 14:25:10');

-- Dumping structure for table etally_db.tbl_event_criterias
CREATE TABLE IF NOT EXISTS `tbl_event_criterias` (
  `criteria_id` int(11) NOT NULL AUTO_INCREMENT,
  `event_id` int(11) NOT NULL DEFAULT '0',
  `criteria` text NOT NULL,
  `points` decimal(12,2) NOT NULL DEFAULT '0.00',
  `date_added` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_modified` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`criteria_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

-- Dumping data for table etally_db.tbl_event_criterias: ~8 rows (approximately)
INSERT INTO `tbl_event_criterias` (`criteria_id`, `event_id`, `criteria`, `points`, `date_added`, `date_modified`) VALUES
	(1, 1, 'Radio Drama\r\nTheme Appropriateness - 10 \r\nVariety of characters - 10\r\nScript Flow and Continuity - 10 ', 30.00, '2023-10-13 14:11:19', '2023-10-13 14:11:19'),
	(2, 1, 'B. TECHNICAL QUALITY\r\nAppropriateness of sounds -10\r\nSmoothness of production - 10 \r\nPrecision (Timing, Pacing and Transition) -10', 30.00, '2023-10-13 14:11:38', '2023-10-13 14:11:38'),
	(3, 1, 'C. VOCAL QUALITY \r\nVoice flexibility - 15\r\nVoice creativity - 15 ', 30.00, '2023-10-13 14:11:54', '2023-10-13 14:11:54'),
	(4, 1, 'D. OVER-ALL APPEAL\r\nDramatic effect - 5\r\nRendering/delevery - 5', 10.00, '2023-10-13 14:12:20', '2023-10-13 14:12:20'),
	(5, 2, 'Technique\r\n Intonation 15\r\n Dexterity 15', 30.00, '2023-10-13 14:36:54', '2023-10-13 14:36:54'),
	(6, 2, 'Mastery (Fidelity of the score', 30.00, '2023-10-13 14:37:12', '2023-10-13 14:37:12'),
	(7, 2, 'Artistic Quality\r\n Expression 15\r\n Interpretation 15', 30.00, '2023-10-13 14:37:25', '2023-10-13 14:37:25'),
	(8, 2, 'Stage Deportment 10', 10.00, '2023-10-13 14:37:35', '2023-10-13 14:37:35');

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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- Dumping data for table etally_db.tbl_event_judges: ~2 rows (approximately)
INSERT INTO `tbl_event_judges` (`event_judge_id`, `event_id`, `judge_id`, `judge_no`, `status`, `date_added`, `date_modified`) VALUES
	(1, 1, 1, 1, 1, '2023-10-13 13:58:44', '2023-10-13 13:58:44'),
	(2, 2, 1, 1, 1, '2023-10-13 14:25:23', '2023-10-13 14:25:23'),
	(3, 2, 3, 2, 1, '2023-10-13 14:25:23', '2023-10-13 14:25:23');

-- Dumping structure for table etally_db.tbl_event_participants
CREATE TABLE IF NOT EXISTS `tbl_event_participants` (
  `event_participant_id` int(11) NOT NULL AUTO_INCREMENT,
  `event_id` int(11) NOT NULL DEFAULT '0',
  `participant_id` int(11) NOT NULL DEFAULT '0',
  `status` int(11) NOT NULL DEFAULT '0',
  `date_added` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_modified` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`event_participant_id`) USING BTREE,
  KEY `event_id` (`event_id`) USING BTREE,
  KEY `participant_id` (`participant_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

-- Dumping data for table etally_db.tbl_event_participants: ~4 rows (approximately)
INSERT INTO `tbl_event_participants` (`event_participant_id`, `event_id`, `participant_id`, `status`, `date_added`, `date_modified`) VALUES
	(1, 1, 1, 1, '2023-10-13 13:58:51', '2023-10-13 14:05:03'),
	(2, 1, 2, 1, '2023-10-13 13:58:51', '2023-10-13 14:05:03'),
	(4, 2, 1, 1, '2023-10-13 14:25:34', '2023-10-13 14:25:34'),
	(5, 2, 2, 1, '2023-10-13 14:25:34', '2023-10-13 14:25:34'),
	(6, 2, 4, 1, '2023-10-13 14:25:34', '2023-10-13 14:25:34');

-- Dumping structure for table etally_db.tbl_event_ranks
CREATE TABLE IF NOT EXISTS `tbl_event_ranks` (
  `rank_id` int(11) NOT NULL AUTO_INCREMENT,
  `event_id` int(11) NOT NULL DEFAULT '0',
  `judge_id` int(11) NOT NULL DEFAULT '0',
  `participant_id` int(11) NOT NULL DEFAULT '0',
  `rank` decimal(12,2) NOT NULL DEFAULT '0.00',
  `date_added` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_modified` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`rank_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- Dumping data for table etally_db.tbl_event_ranks: ~0 rows (approximately)

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
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

-- Dumping data for table etally_db.tbl_event_scores: ~12 rows (approximately)
INSERT INTO `tbl_event_scores` (`score_id`, `event_id`, `criteria_id`, `judge_id`, `participant_id`, `points`, `date_added`, `date_modified`) VALUES
	(1, 2, 5, 3, 1, 27.00, '2023-10-17 16:45:46', '2023-10-17 16:45:46'),
	(2, 2, 6, 3, 1, 17.00, '2023-10-17 16:45:46', '2023-10-17 16:45:46'),
	(3, 2, 7, 3, 1, 30.00, '2023-10-17 16:45:46', '2023-10-17 16:45:46'),
	(4, 2, 8, 3, 1, 10.00, '2023-10-17 16:45:46', '2023-10-17 16:45:46'),
	(5, 2, 5, 3, 2, 30.00, '2023-10-17 16:45:46', '2023-10-17 16:45:46'),
	(6, 2, 6, 3, 2, 27.00, '2023-10-17 16:45:46', '2023-10-17 16:45:46'),
	(7, 2, 7, 3, 2, 24.00, '2023-10-17 16:45:46', '2023-10-17 16:45:46'),
	(8, 2, 8, 3, 2, 10.00, '2023-10-17 16:45:46', '2023-10-17 16:45:46'),
	(9, 2, 5, 3, 4, 17.00, '2023-10-17 16:45:46', '2023-10-17 16:45:46'),
	(10, 2, 6, 3, 4, 27.00, '2023-10-17 16:45:46', '2023-10-17 16:45:46'),
	(11, 2, 7, 3, 4, 30.00, '2023-10-17 16:45:46', '2023-10-17 16:45:46'),
	(12, 2, 8, 3, 4, 10.00, '2023-10-17 16:45:46', '2023-10-17 16:45:46');

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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

-- Dumping data for table etally_db.tbl_participants: ~3 rows (approximately)
INSERT INTO `tbl_participants` (`participant_id`, `participant_name`, `participant_affiliation`, `date_added`, `date_modified`) VALUES
	(1, 'Participant 1', '', '2023-10-11 16:06:36', '2023-10-11 16:11:19'),
	(2, 'Participant 2', 'BSIS', '2023-10-11 16:09:16', '2023-10-11 16:11:25'),
	(4, 'Participant 3', 'a', '2023-10-11 16:23:41', '2023-10-11 16:23:41');

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
