-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               5.6.17 - MySQL Community Server (GPL)
-- Server OS:                    Win32
-- HeidiSQL Version:             9.1.0.4903
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Dumping database structure for summers
CREATE DATABASE IF NOT EXISTS `summers` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `summers`;


-- Dumping structure for table summers.blog
CREATE TABLE IF NOT EXISTS `blog` (
  `blogid` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `body` text NOT NULL,
  `blogupdate` datetime DEFAULT NULL,
  `blogstatus` varchar(1) DEFAULT NULL,
  `mask` varchar(500) DEFAULT NULL,
  `userid` int(11) DEFAULT NULL,
  PRIMARY KEY (`blogid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.


-- Dumping structure for table summers.carousel
CREATE TABLE IF NOT EXISTS `carousel` (
  `carousel_id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `productid` int(11) DEFAULT NULL,
  `description` text,
  `picture` varchar(255) NOT NULL,
  `url` varchar(500) DEFAULT NULL,
  `sort_order` int(3) DEFAULT NULL,
  PRIMARY KEY (`carousel_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.


-- Dumping structure for table summers.gallery
CREATE TABLE IF NOT EXISTS `gallery` (
  `galleryid` int(11) NOT NULL AUTO_INCREMENT,
  `galleryname` varchar(255) NOT NULL,
  `description` text,
  `picture` varchar(255) DEFAULT NULL,
  `meta` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`galleryid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.


-- Dumping structure for table summers.product
CREATE TABLE IF NOT EXISTS `product` (
  `productid` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text,
  `pictures` text,
  `url` text COMMENT 'шлях до статі, публікації чи опису продукту',
  `meta` varchar(255) DEFAULT NULL,
  `gallerys` text,
  PRIMARY KEY (`productid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.


-- Dumping structure for table summers.sub_product_gallery
CREATE TABLE IF NOT EXISTS `sub_product_gallery` (
  `productid` int(11) NOT NULL,
  `galleryid` int(11) NOT NULL,
  PRIMARY KEY (`productid`,`galleryid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.


-- Dumping structure for table summers.user
CREATE TABLE IF NOT EXISTS `user` (
  `RecordID` int(4) NOT NULL AUTO_INCREMENT,
  `Username` varchar(10) NOT NULL,
  `Password` text NOT NULL,
  PRIMARY KEY (`RecordID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
