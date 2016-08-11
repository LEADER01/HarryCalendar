-- Adminer 4.2.4 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `daterating`;
CREATE TABLE `daterating` (
  `idDateRating` int(11) NOT NULL AUTO_INCREMENT,
  `value` int(11) NOT NULL,
  `description` text NOT NULL,
  `color` varchar(6) NOT NULL,
  PRIMARY KEY (`idDateRating`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `day`;
CREATE TABLE `day` (
  `idDay` int(11) NOT NULL AUTO_INCREMENT,
  `day` int(11) NOT NULL,
  `month` int(11) NOT NULL,
  `year` int(11) NOT NULL,
  `dayOfTheYear` int(11) NOT NULL,
  PRIMARY KEY (`idDay`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `day` (`idDay`, `day`, `month`, `year`, `dayOfTheYear`) VALUES
(1,	31,	7,	2016,	212);

DROP TABLE IF EXISTS `log`;
CREATE TABLE `log` (
  `idLog` int(11) NOT NULL AUTO_INCREMENT,
  `event` varchar(125) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `additional_params` text,
  PRIMARY KEY (`idLog`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `log` (`idLog`, `event`, `timestamp`, `additional_params`) VALUES
(1,	'generate_new_day',	'2016-07-31 04:39:27',	'day=212&year=2016');

DROP TABLE IF EXISTS `mailtemplate`;
CREATE TABLE `mailtemplate` (
  `idMailTemplate` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `text` text NOT NULL,
  `lang` int(11) DEFAULT NULL,
  PRIMARY KEY (`idMailTemplate`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `sentmaillog`;
CREATE TABLE `sentmaillog` (
  `idSentMailLog` int(11) NOT NULL AUTO_INCREMENT,
  `idUser` int(11) NOT NULL,
  `idMailTemplate` int(11) NOT NULL,
  `idDay` int(11) DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`idSentMailLog`),
  KEY `idUser` (`idUser`),
  KEY `idMailTemplate` (`idMailTemplate`),
  KEY `idDay` (`idDay`),
  CONSTRAINT `sentmaillog_ibfk_1` FOREIGN KEY (`idUser`) REFERENCES `user` (`idUser`) ON DELETE NO ACTION,
  CONSTRAINT `sentmaillog_ibfk_2` FOREIGN KEY (`idMailTemplate`) REFERENCES `mailtemplate` (`idMailTemplate`) ON DELETE NO ACTION,
  CONSTRAINT `sentmaillog_ibfk_3` FOREIGN KEY (`idDay`) REFERENCES `day` (`idDay`) ON DELETE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `idUser` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(125) NOT NULL,
  `name` varchar(125) NOT NULL,
  `surname` varchar(125) NOT NULL,
  `pass` varchar(512) NOT NULL,
  `role` int(11) DEFAULT NULL,
  PRIMARY KEY (`idUser`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `usersdaterating`;
CREATE TABLE `usersdaterating` (
  `idUsersDateRating` int(11) NOT NULL AUTO_INCREMENT,
  `idUser` int(11) NOT NULL,
  `idDay` int(11) NOT NULL,
  `idDateRating` int(11) DEFAULT NULL,
  `hash` varchar(125) DEFAULT NULL,
  PRIMARY KEY (`idUsersDateRating`),
  KEY `idUser` (`idUser`),
  KEY `idDateRating` (`idDateRating`),
  KEY `idDay` (`idDay`),
  CONSTRAINT `usersdaterating_ibfk_1` FOREIGN KEY (`idUser`) REFERENCES `user` (`idUser`) ON DELETE NO ACTION,
  CONSTRAINT `usersdaterating_ibfk_2` FOREIGN KEY (`idDateRating`) REFERENCES `daterating` (`idDateRating`) ON DELETE NO ACTION,
  CONSTRAINT `usersdaterating_ibfk_3` FOREIGN KEY (`idDay`) REFERENCES `day` (`idDay`) ON DELETE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `usersetting`;
CREATE TABLE `usersetting` (
  `idUserSetting` int(11) NOT NULL AUTO_INCREMENT,
  `idUser` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `value` text,
  PRIMARY KEY (`idUserSetting`),
  KEY `idUser` (`idUser`),
  CONSTRAINT `usersetting_ibfk_1` FOREIGN KEY (`idUser`) REFERENCES `user` (`idUser`) ON DELETE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- 2016-08-11 23:49:52
