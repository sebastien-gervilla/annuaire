/* -- DATABASE CREATION -- */

/* You can modify 'annuaire_nws' by your desired database name. */
/* If you do, keep in mind you'll have to update your '.env' and 'settings.json' files accordingly. */

DROP DATABASE IF EXISTS `annuaire_nws`;
CREATE DATABASE `annuaire_nws` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci;

USE `annuaire_nws`;

/* -- TABLES CREATION - Don't modify anything below ! -- */

CREATE TABLE `student` (
  `_id` INT NOT NULL AUTO_INCREMENT,
  `fname` VARCHAR(32) NOT NULL,
  `lname` VARCHAR(32) NOT NULL,
  `age` INT NOT NULL,
  `gender` enum('Homme','Femme') NOT NULL,
  `email` VARCHAR(64) NOT NULL,
  `phone` VARCHAR(16) DEFAULT NULL,
  `degree` text,
  PRIMARY KEY (`_id`)
) ENGINE=InnoDB AUTO_INCREMENT=44 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


CREATE TABLE `user` (
  `_id` int NOT NULL AUTO_INCREMENT,
  `email` varchar(128) NOT NULL,
  `password` varchar(256) NOT NULL,
  PRIMARY KEY (`_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


CREATE TABLE `event` (
  `_id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(64) NOT NULL,
  `type` enum('JPO','Entretien','Visite','Autre') NOT NULL,
  `description` text,
  `date` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  PRIMARY KEY (`_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


CREATE TABLE `school_year` (
  `_id` tinyint(1) NOT NULL AUTO_INCREMENT,
  `title` varchar(64) NOT NULL,
  PRIMARY KEY (`_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


CREATE TABLE `entry_year` (
  `student_id` int NOT NULL,
  `school_year_id` tinyint(1) NOT NULL,
  KEY `student_id` (`student_id`),
  KEY `school_year_id` (`school_year_id`),
  CONSTRAINT `entry_year_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `student` (`_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `entry_year_ibfk_2` FOREIGN KEY (`school_year_id`) REFERENCES `school_year` (`_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


CREATE TABLE `participation` (
  `student_id` int NOT NULL,
  `event_id` int NOT NULL,
  `amount` tinyint(1) NOT NULL DEFAULT '1',
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  KEY `student_id` (`student_id`),
  KEY `event_id` (`event_id`),
  CONSTRAINT `participation_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `student` (`_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `participation_ibfk_2` FOREIGN KEY (`event_id`) REFERENCES `event` (`_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


CREATE TABLE `specialization` (
  `_id` tinyint(1) NOT NULL AUTO_INCREMENT,
  `title` varchar(64) NOT NULL,
  PRIMARY KEY (`_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


CREATE TABLE `pathway` (
  `student_id` int NOT NULL,
  `specialization_id` tinyint(1) NOT NULL,
  KEY `student_id` (`student_id`),
  KEY `specialization_id` (`specialization_id`),
  CONSTRAINT `pathway_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `student` (`_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `pathway_ibfk_2` FOREIGN KEY (`specialization_id`) REFERENCES `specialization` (`_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


INSERT INTO `user` (`email`, `password`) 
VALUES ('admin@ex.com', '$2y$10$CsNYBd8KlXPkpcSPotP49OGXQ4UBGamPBdC19e8r2ZNVjBPaw2xDu');