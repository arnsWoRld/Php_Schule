-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server Version:               10.1.36-MariaDB - mariadb.org binary distribution
-- Server Betriebssystem:        Win32
-- HeidiSQL Version:             9.3.0.4984
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Exportiere Datenbank Struktur für cms
CREATE DATABASE IF NOT EXISTS `cms` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `cms`;


-- Exportiere Struktur von Tabelle cms.content
CREATE TABLE IF NOT EXISTS `content` (
  `CID` int(11) NOT NULL AUTO_INCREMENT,
  `CLongText` varchar(1024) NOT NULL,
  `LastModified` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `Delete` tinyint(1) DEFAULT NULL,
  `CName` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`CID`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- Exportiere Daten aus Tabelle cms.content: ~3 rows (ungefähr)
/*!40000 ALTER TABLE `content` DISABLE KEYS */;
INSERT INTO `content` (`CID`, `CLongText`, `LastModified`, `Delete`, `CName`) VALUES
	(1, 'Hier könnte voll interessante Sachen stehen', '0000-00-00 00:00:00', 0, 'Tagesnews'),
	(2, 'Wo ist der Bus mit den Leuten die es interessiert', '0000-00-00 00:00:00', 0, 'Wayne'),
	(3, 'Fisch Fisch Fisch', '0000-00-00 00:00:00', 0, 'Fisch');
/*!40000 ALTER TABLE `content` ENABLE KEYS */;


-- Exportiere Struktur von Tabelle cms.mainmenu
CREATE TABLE IF NOT EXISTS `mainmenu` (
  `MmID` int(11) NOT NULL AUTO_INCREMENT,
  `MmName` varchar(50) DEFAULT '0',
  `LastModified` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `Delete` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`MmID`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- Exportiere Daten aus Tabelle cms.mainmenu: ~2 rows (ungefähr)
/*!40000 ALTER TABLE `mainmenu` DISABLE KEYS */;
INSERT INTO `mainmenu` (`MmID`, `MmName`, `LastModified`, `Delete`) VALUES
	(1, 'Hauptmenue', '2018-11-07 16:04:10', NULL),
	(2, 'News', '2018-11-07 16:04:10', NULL);
/*!40000 ALTER TABLE `mainmenu` ENABLE KEYS */;


-- Exportiere Struktur von Tabelle cms.settingtemplatevalue
CREATE TABLE IF NOT EXISTS `settingtemplatevalue` (
  `TemplateID` int(11) DEFAULT NULL,
  `SettingID` int(11) DEFAULT NULL,
  `Value` varchar(50) DEFAULT NULL,
  `LastModified` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `Delete` tinyint(1) DEFAULT NULL,
  KEY `settingtemplatevalue_templatesetting` (`SettingID`),
  KEY `settingtemplatevalue_template` (`TemplateID`),
  CONSTRAINT `settingtemplatevalue_template` FOREIGN KEY (`TemplateID`) REFERENCES `template` (`TemplateID`),
  CONSTRAINT `settingtemplatevalue_templatesetting` FOREIGN KEY (`SettingID`) REFERENCES `templatesetting` (`SettingID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Exportiere Daten aus Tabelle cms.settingtemplatevalue: ~5 rows (ungefähr)
/*!40000 ALTER TABLE `settingtemplatevalue` DISABLE KEYS */;
INSERT INTO `settingtemplatevalue` (`TemplateID`, `SettingID`, `Value`, `LastModified`, `Delete`) VALUES
	(1, 3, '500', '2018-11-07 16:03:42', NULL),
	(1, 2, '500', '2018-11-07 16:03:42', NULL),
	(1, 4, '30', '2018-11-07 16:03:42', NULL),
	(1, 1, '1050', '2018-11-07 16:03:42', NULL),
	(1, 5, '1', '2018-11-07 16:03:42', NULL);
/*!40000 ALTER TABLE `settingtemplatevalue` ENABLE KEYS */;


-- Exportiere Struktur von Tabelle cms.subcont
CREATE TABLE IF NOT EXISTS `subcont` (
  `SCID` int(11) NOT NULL AUTO_INCREMENT,
  `CID` int(11) DEFAULT NULL,
  `SmID` int(11) DEFAULT NULL,
  `Rank` int(11) DEFAULT NULL,
  PRIMARY KEY (`SCID`),
  KEY `FK__content` (`CID`),
  KEY `FK__submenu` (`SmID`),
  CONSTRAINT `FK__content` FOREIGN KEY (`CID`) REFERENCES `content` (`CID`),
  CONSTRAINT `FK__submenu` FOREIGN KEY (`SmID`) REFERENCES `submenu` (`SmID`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- Exportiere Daten aus Tabelle cms.subcont: ~3 rows (ungefähr)
/*!40000 ALTER TABLE `subcont` DISABLE KEYS */;
INSERT INTO `subcont` (`SCID`, `CID`, `SmID`, `Rank`) VALUES
	(1, 3, 2, NULL),
	(2, 2, 3, NULL),
	(3, 1, 4, NULL);
/*!40000 ALTER TABLE `subcont` ENABLE KEYS */;


-- Exportiere Struktur von Tabelle cms.submenu
CREATE TABLE IF NOT EXISTS `submenu` (
  `SmID` int(11) NOT NULL AUTO_INCREMENT,
  `MmID` int(11) DEFAULT NULL,
  `SmName` varchar(50) DEFAULT '0',
  `LastModified` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `Delete` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`SmID`),
  KEY `FK_submenu_mainmenu` (`MmID`),
  CONSTRAINT `FK_submenu_mainmenu` FOREIGN KEY (`MmID`) REFERENCES `mainmenu` (`MmID`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

-- Exportiere Daten aus Tabelle cms.submenu: ~4 rows (ungefähr)
/*!40000 ALTER TABLE `submenu` DISABLE KEYS */;
INSERT INTO `submenu` (`SmID`, `MmID`, `SmName`, `LastModified`, `Delete`) VALUES
	(1, 1, 'Admin', '2018-11-07 16:02:28', NULL),
	(2, 1, 'User', '2018-11-07 16:02:28', NULL),
	(3, 2, 'News 1', '2018-11-07 16:02:28', NULL),
	(4, 2, 'News 2', '2018-11-07 16:02:28', NULL);
/*!40000 ALTER TABLE `submenu` ENABLE KEYS */;


-- Exportiere Struktur von Tabelle cms.template
CREATE TABLE IF NOT EXISTS `template` (
  `TemplateID` int(11) NOT NULL AUTO_INCREMENT,
  `TemplateBezeichnung` varchar(50) NOT NULL,
  `LastModified` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `Delete` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`TemplateID`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- Exportiere Daten aus Tabelle cms.template: ~1 rows (ungefähr)
/*!40000 ALTER TABLE `template` DISABLE KEYS */;
INSERT INTO `template` (`TemplateID`, `TemplateBezeichnung`, `LastModified`, `Delete`) VALUES
	(1, 'default', '0000-00-00 00:00:00', 0);
/*!40000 ALTER TABLE `template` ENABLE KEYS */;


-- Exportiere Struktur von Tabelle cms.templatesetting
CREATE TABLE IF NOT EXISTS `templatesetting` (
  `SettingID` int(11) NOT NULL AUTO_INCREMENT,
  `SettingLabel` varchar(50) DEFAULT NULL,
  `SettingEinheit` varchar(15) DEFAULT NULL,
  `LastModified` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `Delete` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`SettingID`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

-- Exportiere Daten aus Tabelle cms.templatesetting: ~4 rows (ungefähr)
/*!40000 ALTER TABLE `templatesetting` DISABLE KEYS */;
INSERT INTO `templatesetting` (`SettingID`, `SettingLabel`, `SettingEinheit`, `LastModified`, `Delete`) VALUES
	(1, 'tableWidth', 'px', '2018-09-13 17:54:33', NULL),
	(2, 'headerHight', 'px', '2018-09-13 17:54:54', NULL),
	(3, 'footerHeight', 'px', '2018-09-13 17:55:53', NULL),
	(4, 'menuWidth', 'percent', '2018-09-13 17:56:21', NULL),
	(5, 'tableBorder', 'px', '2018-09-20 17:32:24', NULL);
/*!40000 ALTER TABLE `templatesetting` ENABLE KEYS */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
