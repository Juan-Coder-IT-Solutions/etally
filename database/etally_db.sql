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
  `event_start` date NOT NULL,
  `event_end` date NOT NULL,
  `participant_needed` int(11) NOT NULL DEFAULT '0',
  `encoded_by` int(11) NOT NULL DEFAULT '0',
  `date_added` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_modified` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`event_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- Dumping data for table etally_db.tbl_events: ~2 rows (approximately)
INSERT INTO `tbl_events` (`event_id`, `event_name`, `event_start`, `event_end`, `participant_needed`, `encoded_by`, `date_added`, `date_modified`) VALUES
	(1, 'Badminton', '2023-10-26', '0000-00-00', 5, 0, '2023-10-05 16:08:20', '2023-10-05 16:18:37'),
	(2, 'asdasd', '2023-10-05', '0000-00-00', 5, 0, '2023-10-05 16:18:29', '2023-10-05 16:18:29');

-- Dumping structure for table etally_db.tbl_event_criterias
CREATE TABLE IF NOT EXISTS `tbl_event_criterias` (
  `criteria_id` int(11) NOT NULL AUTO_INCREMENT,
  `event_id` int(11) NOT NULL DEFAULT '0',
  `criteria` text NOT NULL,
  `points` decimal(12,2) NOT NULL DEFAULT '0.00',
  `date_added` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_modified` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`criteria_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

-- Dumping data for table etally_db.tbl_event_criterias: ~3 rows (approximately)
INSERT INTO `tbl_event_criterias` (`criteria_id`, `event_id`, `criteria`, `points`, `date_added`, `date_modified`) VALUES
	(1, 1, 'Artistic Quality\r\n Expression 15\r\n Interpretation 15', 20.00, '2023-10-07 15:39:59', '2023-10-10 16:20:53'),
	(2, 1, 'Criteria 2', 15.00, '2023-10-07 15:48:32', '2023-10-07 15:48:32'),
	(5, 1, 's', 15.00, '2023-10-10 11:15:09', '2023-10-10 11:15:17');

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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- Dumping data for table etally_db.tbl_event_judges: ~0 rows (approximately)
INSERT INTO `tbl_event_judges` (`event_judge_id`, `event_id`, `judge_id`, `judge_no`, `status`, `date_added`, `date_modified`) VALUES
	(1, 1, 1, 1, 1, '2023-10-12 14:38:19', '2023-10-12 14:38:19'),
	(2, 1, 3, 2, 1, '2023-10-12 14:38:19', '2023-10-12 14:38:19');

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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- Dumping data for table etally_db.tbl_event_participants: ~2 rows (approximately)
INSERT INTO `tbl_event_participants` (`event_participant_id`, `event_id`, `participant_id`, `status`, `date_added`, `date_modified`) VALUES
	(1, 1, 1, 1, '2023-10-12 11:21:12', '2023-10-12 11:21:12'),
	(2, 1, 4, 1, '2023-10-12 11:21:12', '2023-10-12 11:21:12');

-- Dumping structure for table etally_db.tbl_judges
CREATE TABLE IF NOT EXISTS `tbl_judges` (
  `judge_id` int(11) NOT NULL AUTO_INCREMENT,
  `judge_name` varchar(150) NOT NULL,
  `judge_affiliation` varchar(150) NOT NULL,
  `judge_img` varchar(15) NOT NULL DEFAULT 'user.png',
  `encoded_by` int(11) NOT NULL DEFAULT '0',
  `date_added` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_modified` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`judge_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- Dumping data for table etally_db.tbl_judges: ~0 rows (approximately)
INSERT INTO `tbl_judges` (`judge_id`, `judge_name`, `judge_affiliation`, `judge_img`, `encoded_by`, `date_added`, `date_modified`) VALUES
	(1, 'Judge 1', 'Organization', 'user.png', 0, '2023-10-12 14:37:37', '2023-10-12 14:37:37'),
	(2, 'Judge 2', 'Organization', 'user.png', 0, '2023-10-12 14:37:54', '2023-10-12 14:37:54'),
	(3, 'Judge 3', 'Organization', 'user.png', 0, '2023-10-12 14:38:08', '2023-10-12 14:38:08');

-- Dumping structure for table etally_db.tbl_participants
CREATE TABLE IF NOT EXISTS `tbl_participants` (
  `participant_id` int(11) NOT NULL AUTO_INCREMENT,
  `participant_name` varchar(255) DEFAULT NULL,
  `participant_affiliation` varchar(255) DEFAULT NULL,
  `date_added` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_modified` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`participant_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

-- Dumping data for table etally_db.tbl_participants: ~2 rows (approximately)
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
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

-- Dumping data for table etally_db.tbl_users: ~1 rows (approximately)
INSERT INTO `tbl_users` (`user_id`, `account_id`, `account_name`, `username`, `password`, `user_category`, `date_added`, `date_modified`) VALUES
	(1, 0, 'Event Organizer', 'admin', '0cc175b9c0f1b6a831c399e269772661', 'O', '2023-10-12 09:22:59', '2023-10-12 09:23:29'),
	(7, 1, 'Judge 1', 'judge1', '0cc175b9c0f1b6a831c399e269772661', 'J', '2023-10-12 14:37:37', '2023-10-12 14:37:37'),
	(8, 2, 'Judge 2', 'judge2', '0cc175b9c0f1b6a831c399e269772661', 'J', '2023-10-12 14:37:54', '2023-10-12 14:37:54'),
	(9, 3, 'Judge 3', 'judge3', '0cc175b9c0f1b6a831c399e269772661', 'J', '2023-10-12 14:38:08', '2023-10-12 14:38:08');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
