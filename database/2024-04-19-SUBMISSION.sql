-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               10.4.32-MariaDB - mariadb.org binary distribution
-- Server OS:                    Win64
-- HeidiSQL Version:             12.6.0.6765
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for boardhaven
CREATE DATABASE IF NOT EXISTS `boardhaven` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */;
USE `boardhaven`;

-- Dumping structure for table boardhaven.administratorship
CREATE TABLE IF NOT EXISTS `administratorship` (
  `Id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `User` int(10) unsigned NOT NULL,
  `StartTime` datetime NOT NULL,
  `EndTime` datetime DEFAULT NULL,
  PRIMARY KEY (`Id`),
  KEY `administratorship_user_FK` (`User`),
  CONSTRAINT `administratorship_user_FK` FOREIGN KEY (`User`) REFERENCES `user` (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table boardhaven.administratorship: ~3 rows (approximately)
REPLACE INTO `administratorship` (`Id`, `User`, `StartTime`, `EndTime`) VALUES
	(1, 1, '2024-02-29 19:55:55', NULL),
	(2, 2, '2024-02-29 19:55:55', '2024-03-01 20:01:01'),
	(3, 3, '2024-04-27 16:35:12', NULL);

-- Dumping structure for table boardhaven.board
CREATE TABLE IF NOT EXISTS `board` (
  `Id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `Name` varchar(45) NOT NULL,
  `Founder` int(10) unsigned NOT NULL,
  `TimeCreated` datetime NOT NULL DEFAULT current_timestamp(),
  `Rules` text DEFAULT NULL,
  PRIMARY KEY (`Id`),
  UNIQUE KEY `unique_name` (`Name`),
  KEY `board_user_FK` (`Founder`),
  CONSTRAINT `board_user_FK` FOREIGN KEY (`Founder`) REFERENCES `user` (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table boardhaven.board: ~2 rows (approximately)
REPLACE INTO `board` (`Id`, `Name`, `Founder`, `TimeCreated`, `Rules`) VALUES
	(1, 'main', 1, '2024-02-29 19:55:55', 'just be yourself'),
	(2, 'gaming', 1, '2024-02-29 19:55:55', 'gaming related posts only.'),
	(3, 'gardening', 6, '2024-04-19 16:31:55', 'default');

-- Dumping structure for table boardhaven.comment
CREATE TABLE IF NOT EXISTS `comment` (
  `Id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ParentPost` int(10) unsigned DEFAULT NULL,
  `ParentComment` int(10) unsigned DEFAULT NULL,
  `Text` text NOT NULL,
  `TimeCreated` datetime NOT NULL DEFAULT current_timestamp(),
  `Author` int(10) unsigned NOT NULL,
  `Pinned` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`Id`),
  KEY `fk_comment_parent_idx` (`ParentPost`),
  KEY `fk_comment_parentcomment_idx` (`ParentComment`),
  KEY `fk_comment_user` (`Author`),
  CONSTRAINT `fk_comment_parentcomment` FOREIGN KEY (`ParentComment`) REFERENCES `comment` (`Id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `fk_comment_parentpost` FOREIGN KEY (`ParentPost`) REFERENCES `post` (`Id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_comment_user` FOREIGN KEY (`Author`) REFERENCES `user` (`Id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `ck_comment__parentpost_xor_parentcomment` CHECK (`ParentPost` is not null and `ParentComment` is null or `ParentPost` is null and `ParentComment` is not null)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table boardhaven.comment: ~7 rows (approximately)
REPLACE INTO `comment` (`Id`, `ParentPost`, `ParentComment`, `Text`, `TimeCreated`, `Author`, `Pinned`) VALUES
	(1, 1, NULL, 'This comment is a response to a post!', '2024-02-29 19:55:55', 1, 0),
	(2, NULL, 1, 'This comment is a response to a comment!', '2024-02-29 19:55:55', 1, 0),
	(3, NULL, 1, 'A', '2024-02-29 19:55:55', 1, 0),
	(4, NULL, 3, 'B', '2024-02-29 19:55:55', 1, 0),
	(5, NULL, 4, 'C', '2024-02-29 19:55:55', 3, 0),
	(6, NULL, 3, 'B2', '2024-02-29 19:55:55', 2, 0),
	(7, 2, NULL, 'Hello', '2024-02-29 19:55:55', 2, 0),
	(8, 4, NULL, 'Me neither!', '2024-04-19 16:32:39', 6, 0);

-- Dumping structure for table boardhaven.moderatorship
CREATE TABLE IF NOT EXISTS `moderatorship` (
  `Id` int(10) unsigned NOT NULL,
  `Board` int(10) unsigned NOT NULL,
  `User` int(10) unsigned NOT NULL,
  `StartTime` datetime NOT NULL,
  `EndTime` datetime DEFAULT NULL,
  PRIMARY KEY (`Id`),
  KEY `moderatorship_board_FK` (`Board`),
  KEY `moderatorship_user_FK` (`User`),
  CONSTRAINT `moderatorship_board_FK` FOREIGN KEY (`Board`) REFERENCES `board` (`Id`),
  CONSTRAINT `moderatorship_user_FK` FOREIGN KEY (`User`) REFERENCES `user` (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table boardhaven.moderatorship: ~0 rows (approximately)

-- Dumping structure for table boardhaven.post
CREATE TABLE IF NOT EXISTS `post` (
  `Id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Board` int(10) unsigned NOT NULL,
  `Author` int(10) unsigned NOT NULL,
  `TimeCreated` datetime NOT NULL DEFAULT current_timestamp(),
  `Title` varchar(100) NOT NULL,
  `Content` text NOT NULL,
  `Pinned` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`Id`),
  KEY `fk_post_board_idx` (`Board`),
  KEY `fk_post_author_idx` (`Author`),
  CONSTRAINT `fk_post_author` FOREIGN KEY (`Author`) REFERENCES `user` (`Id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_post_board` FOREIGN KEY (`Board`) REFERENCES `board` (`Id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table boardhaven.post: ~4 rows (approximately)
REPLACE INTO `post` (`Id`, `Board`, `Author`, `TimeCreated`, `Title`, `Content`, `Pinned`) VALUES
	(1, 1, 1, '2024-02-29 19:55:55', 'Welcome to BoardHaven!', 'Please feel free to create new boards, posts and participate in discussion. We hope you enjoy your stay!', 0),
	(2, 2, 1, '2024-02-29 19:55:55', 'Why you should play Dota 2', 'It\'s fun', 0),
	(3, 1, 1, '2024-02-29 19:55:55', 'Second Post', 'Needed this for testing', 0),
	(4, 2, 2, '2024-02-29 19:55:55', 'Path of Exile 2', 'Can\'t WAIT!', 0),
	(5, 3, 6, '2024-04-19 16:32:11', 'How to grow sunflowers in cold climates.', '123', 0);

-- Dumping structure for table boardhaven.removed_submission
CREATE TABLE IF NOT EXISTS `removed_submission` (
  `Id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Post` int(10) unsigned DEFAULT NULL,
  `Comment` int(10) unsigned DEFAULT NULL,
  `Administrator` int(10) unsigned DEFAULT NULL,
  `Moderator` int(10) unsigned DEFAULT NULL,
  `TimeRemoved` datetime NOT NULL,
  `TimeReinstated` datetime DEFAULT NULL,
  `ReasonRemoved` text DEFAULT NULL,
  `ReasonReinstated` text DEFAULT NULL,
  PRIMARY KEY (`Id`),
  KEY `removed_submissions_comment_FK` (`Comment`),
  KEY `removed_submissions_moderatorship_FK` (`Administrator`),
  KEY `removed_submissions_post_FK` (`Post`),
  KEY `FK_-_removed_submissions_-_moderatorship` (`Moderator`),
  CONSTRAINT `FK_-_removed_submissions_-_moderatorship` FOREIGN KEY (`Moderator`) REFERENCES `moderatorship` (`Id`),
  CONSTRAINT `removed_submissions_administratorship_FK` FOREIGN KEY (`Administrator`) REFERENCES `administratorship` (`Id`),
  CONSTRAINT `removed_submissions_comment_FK` FOREIGN KEY (`Comment`) REFERENCES `comment` (`Id`),
  CONSTRAINT `removed_submissions_post_FK` FOREIGN KEY (`Post`) REFERENCES `post` (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table boardhaven.removed_submission: ~2 rows (approximately)
REPLACE INTO `removed_submission` (`Id`, `Post`, `Comment`, `Administrator`, `Moderator`, `TimeRemoved`, `TimeReinstated`, `ReasonRemoved`, `ReasonReinstated`) VALUES
	(1, NULL, 3, 1, NULL, '2024-03-01 20:01:01', NULL, 'Testing', NULL),
	(2, NULL, 6, 1, NULL, '2024-03-01 20:01:01', '2024-03-05 20:01:01', 'Testing Reinstation', 'Testing Reinstation');

-- Dumping structure for table boardhaven.report
CREATE TABLE IF NOT EXISTS `report` (
  `Id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Post` int(10) unsigned DEFAULT NULL,
  `Comment` int(10) unsigned DEFAULT NULL,
  `Reporter` int(10) unsigned NOT NULL,
  `TimeCreated` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`Id`) USING BTREE,
  UNIQUE KEY `Unique_Post_Reporter` (`Post`,`Reporter`),
  UNIQUE KEY `Unique_Comment_Reporter` (`Comment`,`Reporter`),
  KEY `FK-report-user` (`Reporter`),
  CONSTRAINT `FK-report-comment` FOREIGN KEY (`Comment`) REFERENCES `comment` (`Id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK-report-post` FOREIGN KEY (`Post`) REFERENCES `post` (`Id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK-report-user` FOREIGN KEY (`Reporter`) REFERENCES `user` (`Id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `check_post_comment_null` CHECK (`Post` is null and `Comment` is not null or `Post` is not null and `Comment` is null)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table boardhaven.report: ~2 rows (approximately)
REPLACE INTO `report` (`Id`, `Post`, `Comment`, `Reporter`, `TimeCreated`) VALUES
	(1, NULL, 4, 2, '2024-04-19 16:30:06'),
	(2, 3, NULL, 3, '2024-04-19 16:30:06');

-- Dumping structure for view boardhaven.submission
-- Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `submission` (
	`Type` VARCHAR(1) NOT NULL COLLATE 'utf8mb4_general_ci',
	`Id` INT(10) UNSIGNED NULL,
	`Author` DECIMAL(10,0) NULL,
	`TimeCreated` DATETIME NULL,
	`Title` VARCHAR(100) NULL COLLATE 'utf8mb4_general_ci',
	`Content` LONGTEXT NULL COLLATE 'utf8mb4_general_ci',
	`Post` INT(10) UNSIGNED NULL,
	`Board` INT(10) UNSIGNED NULL
) ENGINE=MyISAM;

-- Dumping structure for table boardhaven.suspension_from_board
CREATE TABLE IF NOT EXISTS `suspension_from_board` (
  `Id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `User` int(10) unsigned NOT NULL,
  `Moderator` int(10) unsigned NOT NULL,
  `StartTime` datetime NOT NULL,
  `EndTime` datetime DEFAULT NULL,
  `ReasonSuspended` text DEFAULT NULL,
  `ReasonReinstated` text DEFAULT NULL,
  PRIMARY KEY (`Id`),
  KEY `suspensions_from_board_user_FK` (`User`),
  KEY `suspensions_from_board_moderatorship_FK` (`Moderator`),
  CONSTRAINT `suspensions_from_board_moderatorship_FK` FOREIGN KEY (`Moderator`) REFERENCES `moderatorship` (`Id`),
  CONSTRAINT `suspensions_from_board_user_FK` FOREIGN KEY (`User`) REFERENCES `user` (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table boardhaven.suspension_from_board: ~0 rows (approximately)

-- Dumping structure for table boardhaven.suspension_from_site
CREATE TABLE IF NOT EXISTS `suspension_from_site` (
  `Id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `User` int(10) unsigned NOT NULL,
  `Administrator` int(10) unsigned NOT NULL,
  `StartTime` datetime NOT NULL,
  `EndTime` datetime DEFAULT NULL,
  `ReasonSuspended` text DEFAULT NULL,
  `ReasonReinstated` text DEFAULT NULL,
  PRIMARY KEY (`Id`),
  KEY `suspensions_sitewide_user_FK` (`User`),
  KEY `suspensions_sitewide_administratorship_FK` (`Administrator`),
  CONSTRAINT `suspensions_sitewide_administratorship_FK` FOREIGN KEY (`Administrator`) REFERENCES `administratorship` (`Id`),
  CONSTRAINT `suspensions_sitewide_user_FK` FOREIGN KEY (`User`) REFERENCES `user` (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table boardhaven.suspension_from_site: ~0 rows (approximately)

-- Dumping structure for table boardhaven.user
CREATE TABLE IF NOT EXISTS `user` (
  `Id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Username` varchar(45) NOT NULL,
  `Email` varchar(45) NOT NULL,
  `Password` varchar(45) NOT NULL,
  `TimeCreated` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`Id`),
  UNIQUE KEY `Username_UNIQUE` (`Username`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table boardhaven.user: ~5 rows (approximately)
REPLACE INTO `user` (`Id`, `Username`, `Email`, `Password`, `TimeCreated`) VALUES
	(1, 'Haven', 'haven@example.com', 'password', '2024-02-29 19:55:55'),
	(2, 'echo2', 'echointhevoid@example.com', 'password', '2024-03-04 20:01:01'),
	(3, 'TNT', 'johnsmith@example.com', 'password', '2024-03-04 20:01:01'),
	(4, 'Simba1997', 'ericaklein@example.com', 'password', '2024-03-04 20:01:01'),
	(5, 'DannyBoy', 'dannyj@example.com', 'password', '2024-03-04 20:01:01'),
	(6, 'happy', 'happy@email.com', 'Password1', '2024-04-19 16:31:27');

-- Dumping structure for view boardhaven.visible_comment
-- Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `visible_comment` (
	`Id` INT(10) UNSIGNED NOT NULL,
	`ParentPost` INT(10) UNSIGNED NULL,
	`ParentComment` INT(10) UNSIGNED NULL,
	`Text` MEDIUMTEXT NOT NULL COLLATE 'utf8mb4_general_ci',
	`TimeCreated` DATETIME NOT NULL,
	`Author` DECIMAL(10,0) NOT NULL,
	`Pinned` TINYINT(4) NOT NULL
) ENGINE=MyISAM;

-- Dumping structure for view boardhaven.visible_post
-- Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `visible_post` (
	`Id` INT(10) UNSIGNED NOT NULL,
	`Board` INT(10) UNSIGNED NOT NULL,
	`Author` DECIMAL(10,0) NOT NULL,
	`TimeCreated` DATETIME NOT NULL,
	`Title` VARCHAR(100) NOT NULL COLLATE 'utf8mb4_general_ci',
	`Content` MEDIUMTEXT NOT NULL COLLATE 'utf8mb4_general_ci',
	`Pinned` TINYINT(4) NOT NULL
) ENGINE=MyISAM;

-- Dumping structure for table boardhaven.vote_on_comment
CREATE TABLE IF NOT EXISTS `vote_on_comment` (
  `User` int(10) unsigned NOT NULL,
  `Comment` int(10) unsigned NOT NULL,
  `Verdict` tinyint(1) NOT NULL,
  PRIMARY KEY (`User`,`Comment`),
  KEY `vote_on_comment_comment_FK` (`Comment`),
  CONSTRAINT `vote_on_comment_comment_FK` FOREIGN KEY (`Comment`) REFERENCES `comment` (`Id`),
  CONSTRAINT `vote_on_comment_user_FK` FOREIGN KEY (`User`) REFERENCES `user` (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table boardhaven.vote_on_comment: ~0 rows (approximately)

-- Dumping structure for table boardhaven.vote_on_post
CREATE TABLE IF NOT EXISTS `vote_on_post` (
  `User` int(10) unsigned NOT NULL,
  `Post` int(10) unsigned NOT NULL,
  `Verdict` tinyint(1) NOT NULL,
  PRIMARY KEY (`User`,`Post`),
  KEY `vote_on_post_post_FK` (`Post`),
  CONSTRAINT `vote_on_post_post_FK` FOREIGN KEY (`Post`) REFERENCES `post` (`Id`),
  CONSTRAINT `vote_on_post_user_FK` FOREIGN KEY (`User`) REFERENCES `user` (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table boardhaven.vote_on_post: ~0 rows (approximately)

-- Dumping structure for trigger boardhaven.TRG-removed-comment-overlap
SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION';
DELIMITER //
CREATE TRIGGER `TRG-removed-comment-overlap` BEFORE INSERT ON `removed_submission` FOR EACH ROW BEGIN
	IF EXISTS (
		SELECT NULL
		FROM removed_submission
		WHERE
			`Comment` IS NOT NULL
			AND
			`Comment` = NEW.`Comment`
			AND
			((NEW.TimeRemoved > TimeRemoved AND NEW.TimeRemoved < TimeReinstated)
			OR (NEW.TimeRemoved > TimeRemoved AND TimeReinstated IS NULL))
	)
	THEN
	SIGNAL SQLSTATE '45000'
	SET MESSAGE_TEXT = 'Comment removal overlaps with existing removal';
	END IF;
END//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;

-- Dumping structure for trigger boardhaven.TRG-removed-post-overlap
SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION';
DELIMITER //
CREATE TRIGGER `TRG-removed-post-overlap`
BEFORE INSERT ON removed_submission
FOR EACH ROW
BEGIN
	IF EXISTS (
		SELECT NULL
		FROM removed_submission
		WHERE
			`Post` IS NOT NULL
			AND
			`Post` = NEW.`Post`
			AND
			((NEW.TimeRemoved > TimeRemoved AND NEW.TimeRemoved < TimeReinstated)
			OR (NEW.TimeRemoved > TimeRemoved AND TimeReinstated IS NULL))
	)
	THEN
	SIGNAL SQLSTATE '45000'
	SET MESSAGE_TEXT = 'Post removal overlaps with existing removal';
	END IF;
END//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;

-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `submission`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `submission` AS SELECT * FROM (
	WITH RECURSIVE CommentHierarchy AS (
		-- Anchor member: Select the root comments for the specified post
		SELECT co.Id, ParentPost, ParentComment, Text, co.TimeCreated, co.Author, co.Pinned, po.Id AS Post, po.Board, po.Title
		FROM visible_comment co INNER JOIN visible_post po ON co.ParentPost = po.Id
		WHERE ParentPost IS NOT NULL
		UNION ALL
		-- Recursive member: Select comments that are children of the previous level
		SELECT c.Id, c.ParentPost, c.ParentComment, c.Text, c.TimeCreated, c.Author, ch.Pinned, ch.Post, ch.Board, ch.Title
		FROM visible_comment c
		INNER JOIN CommentHierarchy ch ON c.ParentComment = ch.Id
	)
	SELECT '1' AS Type, ch.Id, ch.Author, ch.TimeCreated, ch.Title, ch.Text AS Content, ch.Post, ch.Board
	FROM CommentHierarchy ch
	UNION ALL
	SELECT '2' AS Type, Id, Author, TimeCreated, Title, Content, Id AS Post, Board
	FROM visible_post
) AS submission ;

-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `visible_comment`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `visible_comment` AS WITH rs AS (
	SELECT * FROM removed_submission r
	WHERE (CURRENT_TIME() BETWEEN r.TimeRemoved AND r.TimeReinstated) OR (CURRENT_TIME() >= r.TimeRemoved AND r.TimeReinstated IS NULL)
)
	SELECT
		c.Id,
		c.ParentPost,
		c.ParentComment,
		'<deleted>' AS Text,
		c.TimeCreated,
		0 as Author,
		c.Pinned
	FROM comment c LEFT JOIN rs ON c.Id = rs.Comment
	WHERE rs.Id IS NOT NULL
UNION ALL
	SELECT
		c.Id,
		c.ParentPost,
		c.ParentComment,
		c.Text,
		c.TimeCreated,
		c.Author,
		c.Pinned
	FROM comment c LEFT JOIN rs ON c.Id = rs.Comment
	WHERE rs.Id IS NULL
ORDER BY Id ;

-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `visible_post`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `visible_post` AS WITH rs AS (
	SELECT * FROM removed_submission r
	WHERE (CURRENT_TIME() BETWEEN r.TimeRemoved AND r.TimeReinstated) OR (CURRENT_TIME() >= r.TimeRemoved AND r.TimeReinstated IS NULL)
)
	SELECT
		p.Id,
		p.Board,
		0 as Author,
		p.TimeCreated,
		'<deleted>' AS Title,
		'<deleted>' AS Content,
		p.Pinned
	FROM post p LEFT JOIN rs ON p.Id = rs.Post
	WHERE rs.Id IS NOT NULL
UNION ALL
	SELECT
		p.Id,
		p.Board,
		p.Author,
		p.TimeCreated,
		p.Title,
		p.Content,
		p.Pinned
	FROM post p LEFT JOIN rs ON p.Id = rs.Post
	WHERE rs.Id IS NULL
ORDER BY Id ;

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
