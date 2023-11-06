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
  `event_category_id` int(11) NOT NULL DEFAULT '0',
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
INSERT INTO `tbl_events` (`event_id`, `event_category_id`, `event_name`, `event_description`, `event_mechanics`, `event_start`, `event_end`, `event_status`, `participant_needed`, `judge_needed`, `encoded_by`, `date_added`, `date_modified`) VALUES
	(1, 0, 'Choral Singing', 'Singing Contest', 'eEsfcpXSs.pdf', '2023-10-28', '0000-00-00', 'S', 10, 5, 0, '2023-10-28 14:18:34', '2023-10-28 14:18:34'),
	(2, 0, 'Badminton', 'Male Category', 'jlW0rT7Cp.pdf', '2023-10-28', '0000-00-00', 'S', 10, 3, 0, '2023-10-28 15:52:37', '2023-10-28 15:52:37');

-- Dumping structure for table etally_db.tbl_event_categories
CREATE TABLE IF NOT EXISTS `tbl_event_categories` (
  `event_category_id` int(11) NOT NULL AUTO_INCREMENT,
  `event_category` varchar(255) NOT NULL DEFAULT '0',
  `date_added` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_modified` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`event_category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

-- Dumping data for table etally_db.tbl_event_categories: ~5 rows (approximately)
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
  `event_id` int(11) NOT NULL DEFAULT '0',
  `criteria` text NOT NULL,
  `points` decimal(12,2) NOT NULL DEFAULT '0.00',
  `date_added` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_modified` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`criteria_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- Dumping data for table etally_db.tbl_event_criterias: ~0 rows (approximately)
INSERT INTO `tbl_event_criterias` (`criteria_id`, `ch_id`, `event_id`, `criteria`, `points`, `date_added`, `date_modified`) VALUES
	(1, 1, 1, 'Performance\n  - Mastery\n  - Presence', 50.00, '2023-11-06 16:22:39', '2023-11-06 16:22:39'),
	(2, 2, 1, 'Mastery of Skills', 25.00, '2023-11-06 16:38:45', '2023-11-06 16:38:45'),
	(3, 2, 1, 'Presence', 25.00, '2023-11-06 16:38:45', '2023-11-06 16:38:45');

-- Dumping structure for table etally_db.tbl_event_criteria_header
CREATE TABLE IF NOT EXISTS `tbl_event_criteria_header` (
  `ch_id` int(11) NOT NULL AUTO_INCREMENT,
  `event_id` int(11) NOT NULL DEFAULT '0',
  `is_normal` int(1) NOT NULL DEFAULT '1' COMMENT '1=Normal;0=With Sub',
  `criteria` varchar(255) NOT NULL DEFAULT '0',
  `points` decimal(12,2) NOT NULL DEFAULT '0.00',
  `date_added` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_modified` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`ch_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- Dumping data for table etally_db.tbl_event_criteria_header: ~0 rows (approximately)
INSERT INTO `tbl_event_criteria_header` (`ch_id`, `event_id`, `is_normal`, `criteria`, `points`, `date_added`, `date_modified`) VALUES
	(1, 1, 1, 'Performance\n  - Mastery\n  - Presence', 50.00, '2023-11-06 16:22:39', '2023-11-06 16:22:39'),
	(2, 1, 0, 'Performance', 50.00, '2023-11-06 16:38:45', '2023-11-06 16:38:45');

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

-- Dumping data for table etally_db.tbl_event_judges: ~2 rows (approximately)
INSERT INTO `tbl_event_judges` (`event_judge_id`, `event_id`, `judge_id`, `judge_no`, `status`, `date_added`, `date_modified`) VALUES
	(1, 1, 1, 1, 1, '2023-11-06 15:15:06', '2023-11-06 15:15:06'),
	(2, 1, 3, 2, 1, '2023-11-06 15:15:06', '2023-11-06 15:15:06');

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
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

-- Dumping data for table etally_db.tbl_event_participants: ~6 rows (approximately)
INSERT INTO `tbl_event_participants` (`event_participant_id`, `event_id`, `participant_id`, `status`, `total_ranks`, `rank`, `date_added`, `date_modified`) VALUES
	(1, 1, 1, 1, 0.00, 0.00, '2023-10-28 15:26:41', '2023-11-06 15:14:46'),
	(2, 1, 2, 1, 0.00, 0.00, '2023-10-28 15:42:15', '2023-11-06 15:14:46'),
	(3, 1, 6, 1, 0.00, 0.00, '2023-10-28 15:42:32', '2023-11-06 15:14:46'),
	(4, 2, 1, 1, 0.00, 0.00, '2023-10-28 15:52:52', '2023-10-28 15:52:52'),
	(5, 2, 4, 1, 0.00, 0.00, '2023-10-28 15:52:52', '2023-10-28 15:52:52'),
	(6, 1, 8, 1, 0.00, 0.00, '2023-11-06 15:14:46', '2023-11-06 15:14:46');

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table etally_db.tbl_event_scores: ~0 rows (approximately)

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
  `program_id` int(11) NOT NULL,
  `participant_year` varchar(15) DEFAULT NULL,
  `participant_img` varchar(15) DEFAULT 'user_img.png',
  `date_added` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_modified` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`participant_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

-- Dumping data for table etally_db.tbl_participants: ~7 rows (approximately)
INSERT INTO `tbl_participants` (`participant_id`, `participant_name`, `participant_affiliation`, `program_id`, `participant_year`, `participant_img`, `date_added`, `date_modified`) VALUES
	(1, 'Participant 1', '', 2, 'Third Year', 'user_img.png', '2023-10-11 16:06:36', '2023-10-28 15:46:03'),
	(2, 'Participant 2', 'BSIS', 1, 'Third Year', 'user_img.png', '2023-10-11 16:09:16', '2023-10-28 15:46:04'),
	(4, 'Participant 3', 'a', 4, 'Second Year', 'user_img.png', '2023-10-11 16:23:41', '2023-10-28 15:46:05'),
	(5, 'Participant 4', 'as', 3, 'Fourth Year', 'user_img.png', '2023-10-18 11:36:37', '2023-10-28 15:46:06'),
	(6, 'Participant 5', 'sasasd', 3, 'Second Year', 'user_img.png', '2023-10-18 11:36:43', '2023-10-28 15:46:07'),
	(7, 'Participant 6', NULL, 2, 'Second Year', 'user_img.png', '2023-11-06 15:10:19', '2023-11-06 15:10:19'),
	(8, 'Participant 7', NULL, 2, 'First Year', 'dd8UWwGRP.jpg', '2023-11-06 15:13:23', '2023-11-06 15:13:23');

-- Dumping structure for table etally_db.tbl_programs
CREATE TABLE IF NOT EXISTS `tbl_programs` (
  `program_id` int(11) NOT NULL AUTO_INCREMENT,
  `program_name` varchar(255) NOT NULL DEFAULT '0',
  `date_added` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_modified` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`program_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

-- Dumping data for table etally_db.tbl_programs: ~3 rows (approximately)
INSERT INTO `tbl_programs` (`program_id`, `program_name`, `date_added`, `date_modified`) VALUES
	(1, 'BSINFO', '2023-10-28 15:00:46', '2023-10-28 15:01:01'),
	(2, 'BSIS', '2023-10-28 15:00:56', '2023-10-28 15:00:56'),
	(3, 'BTVTED', '2023-10-28 15:01:07', '2023-10-28 15:01:07'),
	(4, 'BSIT', '2023-10-28 15:01:16', '2023-10-28 15:01:16');

-- Dumping structure for table etally_db.tbl_protests
CREATE TABLE IF NOT EXISTS `tbl_protests` (
  `protest_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_token` varchar(50) NOT NULL DEFAULT '0',
  `event_id` int(11) NOT NULL DEFAULT '0',
  `protest` text NOT NULL,
  `date_added` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_modified` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`protest_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- Dumping data for table etally_db.tbl_protests: ~2 rows (approximately)
INSERT INTO `tbl_protests` (`protest_id`, `user_token`, `event_id`, `protest`, `date_added`, `date_modified`) VALUES
	(1, 'cmD2m', 4, '        $("#protest").html("");\r\n        $.post("ajax/get_protests.php",{\r\n            params:"WHERE protest_id > 0 ORDER BY date_added DESC"\r\n        },function(data){\r\n            var res = JSON.parse(data);\r\n\r\n            $("#protest-title").html(`Protest (${res.data.length})`);\r\n\r\n            for (let protestIndex = 0; protestIndex < res.data.length; protestIndex++) {\r\n                const protest_row = res.data[protestIndex];\r\n                $("#protest").append(`<div class="timeline-item">\r\n                        <div class="timeline-item-marker">\r\n                            <div class="timeline-item-marker-text">${protest_row.time_past}</div>\r\n                        </div>\r\n                        <div class="timeline-item-content">\r\n                            <a class="fw-bold text-dark" href="index.php?page=event-details&event_id=${protest_row.event_id}">${protest_row.event_name}</a><br>\r\n                            ${protest_row.protest}\r\n                        </div>\r\n                </div>`);\r\n            }\r\n        });', '2023-10-26 15:48:20', '2023-10-26 15:48:20'),
	(2, 'zLMra', 4, '        $("#protest").html("");\r\n        $.post("ajax/get_protests.php",{\r\n            params:"WHERE protest_id > 0 ORDER BY date_added DESC"\r\n        },function(data){\r\n            var res = JSON.parse(data);\r\n\r\n            $("#protest-title").html(`Protest (${res.data.length})`);\r\n\r\n            for (let protestIndex = 0; protestIndex < res.data.length; protestIndex++) {\r\n                const protest_row = res.data[protestIndex];\r\n                $("#protest").append(`<div class="timeline-item">\r\n                        <div class="timeline-item-marker">\r\n                            <div class="timeline-item-marker-text">${protest_row.time_past}</div>\r\n                        </div>\r\n                        <div class="timeline-item-content">\r\n                            <a class="fw-bold text-dark" href="index.php?page=event-details&event_id=${protest_row.event_id}">${protest_row.event_name}</a><br>\r\n                            ${protest_row.protest}\r\n                        </div>\r\n                </div>`);\r\n            }\r\n        });', '2023-10-26 15:48:44', '2023-10-26 15:48:44'),
	(3, 'sHIlF', 4, '        $("#protest").html("");\r\n        $.post("ajax/get_protests.php",{\r\n            params:"WHERE protest_id > 0 ORDER BY date_added DESC"\r\n        },function(data){\r\n            var res = JSON.parse(data);\r\n\r\n            $("#protest-title").html(`Protest (${res.data.length})`);\r\n\r\n            for (let protestIndex = 0; protestIndex < res.data.length; protestIndex++) {\r\n                const protest_row = res.data[protestIndex];\r\n                $("#protest").append(`<div class="timeline-item">\r\n                        <div class="timeline-item-marker">\r\n                            <div class="timeline-item-marker-text">${protest_row.time_past}</div>\r\n                        </div>\r\n                        <div class="timeline-item-content">\r\n                            <a class="fw-bold text-dark" href="index.php?page=event-details&event_id=${protest_row.event_id}">${protest_row.event_name}</a><br>\r\n                            ${protest_row.protest}\r\n                        </div>\r\n                </div>`);\r\n            }\r\n        });', '2023-10-26 15:48:51', '2023-10-26 15:48:51');

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
