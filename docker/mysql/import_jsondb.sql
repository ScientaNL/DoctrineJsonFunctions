-- Dump created by MySQL pump utility, version: 8.0.13, Linux (x86_64)
-- Server version: 8.0.13

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE;
SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET @@SESSION.SQL_LOG_BIN= 0;
SET @OLD_TIME_ZONE=@@TIME_ZONE;
SET TIME_ZONE='+00:00';
SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT;
SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS;
SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION;
SET NAMES utf8mb4;
CREATE DATABASE /*!32312 IF NOT EXISTS*/ `jsondb` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */;
CREATE TABLE `jsondb`.`events` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`event_name` varchar(255) DEFAULT NULL,
`visitor` varchar(255) DEFAULT NULL,
`properties` json DEFAULT NULL,
`browser` json DEFAULT NULL,
PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci
;
INSERT INTO `jsondb`.`events` VALUES (1,"pageview","1","{\"page\": \"/\"}","{\"os\": \"Mac\", \"name\": \"Safari\", \"resolution\": {\"x\": 1920, \"y\": 1080}}"),(2,"pageview","2","{\"page\": \"/contact\"}","{\"os\": \"Windows\", \"name\": \"Firefox\", \"resolution\": {\"x\": 2560, \"y\": 1600}}"),(3,"pageview","1","{\"page\": \"/products\"}","{\"os\": \"Mac\", \"name\": \"Safari\", \"resolution\": {\"x\": 1920, \"y\": 1080}}"),(4,"purchase","3","{\"amount\": 200, \"paymentCompleted\": true}","{\"os\": \"Windows\", \"name\": \"Firefox\", \"resolution\": {\"x\": 1600, \"y\": 900}}"),(5,"purchase","4","{\"amount\": 150, \"paymentCompleted\": false}","{\"os\": \"Windows\", \"name\": \"Firefox\", \"resolution\": {\"x\": 1280, \"y\": 800}}"),(6,"purchase","4","{\"amount\": 500, \"paymentCompleted\": true}","{\"os\": \"Windows\", \"name\": \"Chrome\", \"resolution\": {\"x\": 1680, \"y\": 1050}}");
SET TIME_ZONE=@OLD_TIME_ZONE;
SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT;
SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS;
SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
SET SQL_MODE=@OLD_SQL_MODE;