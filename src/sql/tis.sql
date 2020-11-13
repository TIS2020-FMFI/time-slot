-- phpMyAdmin SQL Dump
-- version 4.0.4.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Nov 12, 2020 at 12:11 AM
-- Server version: 5.6.13
-- PHP Version: 5.4.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `tis`
--
CREATE DATABASE IF NOT EXISTS `tis` DEFAULT CHARACTER SET utf8 COLLATE utf8_slovak_ci;
USE `tis`;

-- --------------------------------------------------------

--
-- Table structure for table `employee`
--

CREATE TABLE IF NOT EXISTS `employee` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `meno` varchar(20) COLLATE utf8_slovak_ci NOT NULL,
  `priezvisko` varchar(20) COLLATE utf8_slovak_ci NOT NULL,
  `email` varchar(100) COLLATE utf8_slovak_ci NOT NULL,
  `heslo` varchar(300) COLLATE utf8_slovak_ci NOT NULL,
  `role` varchar(50) COLLATE utf8_slovak_ci NOT NULL,
  `is_working` tinyint(1) NOT NULL,
  `login_count` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_slovak_ci AUTO_INCREMENT=14 ;

--
-- Dumping data for table `employee`
--

INSERT INTO `employee` (`id`, `meno`, `priezvisko`, `email`, `heslo`, `role`, `is_working`, `login_count`) VALUES
(1, 'admin', 'admin', 'admin.admin@gmial.com', '21232f297a57a5a743894a0e4a801fc3', 'EXD', 1, 2),
(3, 'EXD', 'EXD', 'EXD.EXD@gmial.com', '08e72627bd8dce9e03cf847a7569a5de', 'EXD', 1, 2),
(4, 'IND', 'IND', 'IND.IND@gmial.com', '82828756da24342a94c9b1355ae83653', 'IND', 1, 0),
(5, 'GM', 'GM', 'GM.GM@gmial.com', '64f3bd1741ab8d6ba545a1ae09bb8728', 'GM', 1, 0),
(6, 'asdfsdfsg', 'dfsghg', 'root@gmial.com', '6db23eee40d34e8290441bd8ff5bd924', 'EXD', 0, 0),
(7, 'sdsd', 'dsds', 'root@gmial.com', '21232f297a57a5a743894a0e4a801fc3', 'EXD', 0, 0),
(8, 'sdsd', 'dsds', 'root@gmial.com', '0cc175b9c0f1b6a831c399e269772661', 'EXD', 0, 0),
(9, 'dfsg', 'dsds', 'root@gmial.com', 'f970e2767d0cfe75876ea857f92e319b', 'EXD', 0, 0),
(10, 'sdsd', 'dsds', 'root@gmial.com', '03c7c0ace395d80182db07ae2c30f034', 'EXD', 0, 0),
(11, 'sdsd', 'dsds', 'root', '03c7c0ace395d80182db07ae2c30f034', 'EXD', 0, 0),
(13, 'xvb', 'sadfgh', 'admin.admin@gmial.com', 'f561aaf6ef0bf14d4208bb46a4ccb3ad', 'EXD', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `event_log`
--

CREATE TABLE IF NOT EXISTS `event_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(100) COLLATE utf8_slovak_ci NOT NULL,
  `task_event` text COLLATE utf8_slovak_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_slovak_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `gate_calendar`
--

CREATE TABLE IF NOT EXISTS `gate_calendar` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `gate_number` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_slovak_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `time_slot`
--

CREATE TABLE IF NOT EXISTS `time_slot` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_calendar` int(11) NOT NULL,
  `id_external_dispatcher` int(11) NOT NULL,
  `truck_driver_ids` text COLLATE utf8_slovak_ci NOT NULL,
  `id_truck` int(11) NOT NULL,
  `start_date_time` datetime NOT NULL,
  `end_date_time` datetime NOT NULL,
  `state` varchar(20) COLLATE utf8_slovak_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_slovak_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `truck`
--

CREATE TABLE IF NOT EXISTS `truck` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `EVC` varchar(20) COLLATE utf8_slovak_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_slovak_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `truck_driver`
--

CREATE TABLE IF NOT EXISTS `truck_driver` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `full_name` varchar(50) COLLATE utf8_slovak_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_slovak_ci AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
