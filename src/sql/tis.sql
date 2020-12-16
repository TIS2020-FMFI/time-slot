-- phpMyAdmin SQL Dump
-- version 4.0.4.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Dec 07, 2020 at 02:38 PM
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

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `generate_data`()
BEGIN
  DECLARE i INT DEFAULT 0;
  WHILE i < 1000 DO
    (SELECT RAND()*10);
    SET i = i + 1;
END WHILE;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `config_start_end_working`
--

CREATE TABLE IF NOT EXISTS `config_start_end_working` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `starting_hour` decimal(11,1) NOT NULL,
  `ending_hour` decimal(11,1) NOT NULL,
  `exception_status` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_slovak_ci AUTO_INCREMENT=10 ;

--
-- Dumping data for table `config_start_end_working`
--

INSERT INTO `config_start_end_working` (`id`, `starting_hour`, `ending_hour`, `exception_status`) VALUES
(1, '7.0', '22.0', 1),
(2, '6.0', '22.0', 1),
(3, '6.0', '22.0', 0),
(4, '7.0', '22.0', 0),
(5, '7.0', '22.0', 0),
(6, '0.0', '0.0', 0),
(7, '0.0', '0.0', 0);

-- --------------------------------------------------------

--
-- Table structure for table `destination_order`
--

CREATE TABLE IF NOT EXISTS `destination_order` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `destination` varchar(50) COLLATE utf8_slovak_ci NOT NULL,
  `commodity` varchar(100) COLLATE utf8_slovak_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_slovak_ci AUTO_INCREMENT=3 ;

--
-- Dumping data for table `destination_order`
--

INSERT INTO `destination_order` (`id`, `destination`, `commodity`) VALUES
(1, 'Bratislava', '9x auto typu: BMW'),
(2, 'Vrakuna', '9x auto typu: AUDI');

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
  `is_working` tinyint(5) NOT NULL DEFAULT '1',
  `login_count` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_slovak_ci AUTO_INCREMENT=19 ;

--
-- Dumping data for table `employee`
--

INSERT INTO `employee` (`id`, `meno`, `priezvisko`, `email`, `heslo`, `role`, `is_working`, `login_count`) VALUES
(1, 'admin', 'admin', 'admin.admin@gmial.com', '21232f297a57a5a743894a0e4a801fc3', 'AD', 1, 2),
(3, 'EXD', 'EXD', 'EXD.EXD@gmial.com', '08e72627bd8dce9e03cf847a7569a5de', 'EXD', 1, 2),
(4, 'IND', 'IND', 'IND.IND@gmial.com', '82828756da24342a94c9b1355ae83653', 'IND', 1, 0),
(5, 'GM', 'GM', 'GM.GM@gmial.com', '64f3bd1741ab8d6ba545a1ae09bb8728', 'GM', 1, 0),
(6, 'asdfsdfsg', 'dfsghg', 'root@gmial.com', '6db23eee40d34e8290441bd8ff5bd924', 'EXD', 0, 0),
(7, 'sdsd', 'dsds', 'root@gmial.com', '21232f297a57a5a743894a0e4a801fc3', 'EXD', 0, 0),
(8, 'sdsd', 'dsds', 'root@gmial.com', '0cc175b9c0f1b6a831c399e269772661', 'EXD', 0, 0),
(9, 'dfsg', 'dsds', 'root@gmial.com', 'f970e2767d0cfe75876ea857f92e319b', 'EXD', 0, 0),
(10, 'sdsd', 'dsds', 'root@gmial.com', '03c7c0ace395d80182db07ae2c30f034', 'EXD', 0, 0),
(11, 'sdsd', 'dsds', 'root@gmial.com', '03c7c0ace395d80182db07ae2c30f034', 'IND', 0, 0),
(13, 'xvb', 'sadfgh', 'admin.admin@gmial.com', 'f561aaf6ef0bf14d4208bb46a4ccb3ad', 'EXD', 1, 0),
(14, 'xvb', 'sadfgh', 'rootssss@gmial.com', '03c7c0ace395d80182db07ae2c30f034', 'EXD', 1, 0),
(15, 'ssssss', 'ssssss', 'ssss.ssss@gmail.com', '03c7c0ace395d80182db07ae2c30f034', 'EXD', 1, 0),
(16, 'ssssss', 'ssssss', 'ssss.ssss@gmail.com', '03c7c0ace395d80182db07ae2c30f034', 'IND', 1, 0),
(17, 'dddd', 'dddd', 'rootd.d@gmail.com', '8277e0910d750195b448797616e091ad', 'EXD', 1, 0),
(18, 'dddd2', 'dddd2', 'rootd.d2@gmail.com', '8277e0910d750195b448797616e091ad', 'EXD', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `event_log`
--

CREATE TABLE IF NOT EXISTS `event_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `employee_id` int(11) NOT NULL,
  `task_event` text COLLATE utf8_slovak_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_slovak_ci AUTO_INCREMENT=211 ;

--
-- Dumping data for table `event_log`
--

INSERT INTO `event_log` (`id`, `employee_id`, `task_event`) VALUES
(1, 3, 'Close time slot 1'),
(2, 3, 'Close time slot 1'),
(3, 3, 'Close time slot 1'),
(4, 3, 'Close time slot 1'),
(5, 3, 'Close time slot 1'),
(6, 3, 'Close time slot 1'),
(7, 3, 'Close time slot 1'),
(8, 3, 'Close time slot 1'),
(9, 3, 'Close time slot 6'),
(10, 3, 'Close time slot 1'),
(11, 3, 'Close time slot 1'),
(12, 3, 'Close time slot 1'),
(13, 3, 'Close time slot 1'),
(14, 3, 'Close time slot 1'),
(15, 3, 'Close time slot 1'),
(16, 3, 'Close time slot 1'),
(17, 3, 'Close time slot 1'),
(18, 3, 'Close time slot 1'),
(19, 3, 'Close time slot 1'),
(20, 3, 'Close time slot 1'),
(21, 3, 'Close time slot 1'),
(22, 3, 'Close time slot 1'),
(23, 3, 'Close time slot 1'),
(24, 3, 'Close time slot 1'),
(25, 3, 'Close time slot 1'),
(26, 3, 'Close time slot 1'),
(27, 3, 'Close time slot 1'),
(28, 3, 'Close time slot 1'),
(29, 3, 'Close time slot 1'),
(30, 3, 'Close time slot 1'),
(31, 3, 'Close time slot 1'),
(32, 3, 'Close time slot 1'),
(33, 3, 'Close time slot 1'),
(34, 3, 'Close time slot 1'),
(35, 3, 'Close time slot 1'),
(36, 3, 'Close time slot 1'),
(37, 3, 'Close time slot 1'),
(38, 3, 'Close time slot 1'),
(39, 3, 'Close time slot 1'),
(40, 3, 'Close time slot 1'),
(41, 3, 'Close time slot 1'),
(42, 3, 'Close time slot 1'),
(43, 3, 'Close time slot 1'),
(44, 3, 'Close time slot 1'),
(45, 3, 'Close time slot 1'),
(46, 3, 'Close time slot 1'),
(47, 3, 'Close time slot 1'),
(48, 3, 'Close time slot 1'),
(49, 3, 'Close time slot 1'),
(50, 3, 'Close time slot 1'),
(51, 3, 'Close time slot 1'),
(52, 3, 'Close time slot 1'),
(53, 3, 'Close time slot 1'),
(54, 3, 'Close time slot 1'),
(55, 3, 'Close time slot 1'),
(56, 3, 'Close time slot 1'),
(57, 3, 'Close time slot 1'),
(58, 3, 'Close time slot 1'),
(59, 3, 'Close time slot 1'),
(60, 3, 'Close time slot 1'),
(61, 3, 'Close time slot 1'),
(62, 3, 'Close time slot 1'),
(63, 3, 'Close time slot 1'),
(64, 3, 'Close time slot 1'),
(65, 3, 'Close time slot 1'),
(66, 3, 'Close time slot 1'),
(67, 3, 'Close time slot 1'),
(68, 3, 'Close time slot 1'),
(69, 3, 'Close time slot 1'),
(70, 3, 'Close time slot 1'),
(71, 3, 'Close time slot 1'),
(72, 3, 'Close time slot 1'),
(73, 3, 'Close time slot 1'),
(74, 3, 'Close time slot 1'),
(75, 3, 'Close time slot 1'),
(76, 3, 'Close time slot 1'),
(77, 3, 'Close time slot 1'),
(78, 1, 'Close time slot 1'),
(79, 1, 'Close time slot 1'),
(80, 1, 'Close time slot 1'),
(81, 1, 'Close time slot 1'),
(82, 1, 'Close time slot 1'),
(83, 1, 'Close time slot 1'),
(84, 1, 'Close time slot 1'),
(85, 1, 'Close time slot 1'),
(86, 1, 'Close time slot 1'),
(87, 1, 'Close time slot 1'),
(88, 1, 'Close time slot 1'),
(89, 3, 'Close time slot 1'),
(90, 3, 'Close time slot 1'),
(91, 3, 'Close time slot 1'),
(92, 3, 'Close time slot 1'),
(93, 3, 'Close time slot 1'),
(94, 3, 'Close time slot 1'),
(95, 3, 'Close time slot 1'),
(96, 3, 'Close time slot 1'),
(97, 3, 'Close time slot 1'),
(98, 3, 'Close time slot 1'),
(99, 3, 'Close time slot 1'),
(100, 3, 'Close time slot 1'),
(101, 3, 'Close time slot 1'),
(102, 3, 'Close time slot 1'),
(103, 3, 'Close time slot 1'),
(104, 3, 'Close time slot 1'),
(105, 3, 'Close time slot 1'),
(106, 3, 'Close time slot 1'),
(107, 3, 'Close time slot 1'),
(108, 3, 'Close time slot 1'),
(109, 3, 'Close time slot 1'),
(110, 3, 'Close time slot 1'),
(111, 3, 'Close time slot 1'),
(112, 3, 'Close time slot 1'),
(113, 3, 'Close time slot 1'),
(114, 3, 'Close time slot 1'),
(115, 3, 'Close without active time slot'),
(116, 3, 'Close time slot 1'),
(117, 3, 'Close time slot 6'),
(118, 3, 'Close time slot 1'),
(119, 3, 'Close time slot 1'),
(120, 3, 'Close time slot 1'),
(121, 3, 'Close time slot 6'),
(122, 3, 'Close time slot 6'),
(123, 3, 'Close time slot 1'),
(124, 3, 'Close time slot 1'),
(125, 3, 'Close time slot 1'),
(126, 3, 'Close time slot 6'),
(127, 3, 'Close time slot 1'),
(128, 3, 'Close time slot 1'),
(129, 3, 'Close time slot 1'),
(130, 3, 'Close time slot 1'),
(131, 3, 'Close time slot 1'),
(132, 3, 'Close time slot 1'),
(133, 3, 'Close time slot 1'),
(134, 3, 'Close time slot 1'),
(135, 3, 'Close time slot 6'),
(136, 3, 'Close time slot 1'),
(137, 3, 'Close time slot 6'),
(138, 3, 'Close time slot 1'),
(139, 3, 'Close time slot 6'),
(140, 3, 'Close time slot 6'),
(141, 3, 'Close without active time slot'),
(142, 3, 'Close time slot 1'),
(143, 3, 'Close time slot 6'),
(144, 3, 'Close time slot 1'),
(145, 3, 'Close time slot 6'),
(146, 3, 'Close time slot 1'),
(147, 3, 'Close time slot 1'),
(148, 3, 'Close time slot 1'),
(149, 3, 'Close time slot 1'),
(150, 3, 'Close without active time slot'),
(151, 3, 'Close time slot 1'),
(152, 3, 'Close time slot 1'),
(153, 3, 'Close time slot 1'),
(154, 3, 'Close time slot 1'),
(155, 3, 'Close time slot 1'),
(156, 3, 'Close time slot 1'),
(157, 3, 'Close time slot 1'),
(158, 3, 'Close time slot 1'),
(159, 3, 'Close time slot 2'),
(160, 3, 'Close time slot 4'),
(161, 3, 'Close time slot 5'),
(162, 3, 'Close time slot 6'),
(163, 3, 'Close time slot 1'),
(164, 3, 'Close without active time slot'),
(165, 3, 'Close time slot 1'),
(166, 3, 'Close time slot 3'),
(167, 3, 'Close time slot 1'),
(168, 3, 'Close time slot 4'),
(169, 3, 'Close time slot 1'),
(170, 3, 'Close time slot 1'),
(171, 3, 'Close time slot 1'),
(172, 3, 'Close time slot 1'),
(173, 3, 'Close time slot 3'),
(174, 3, 'Close without active time slot'),
(175, 3, 'Close time slot 2'),
(176, 3, 'Close time slot 3'),
(177, 3, 'Close time slot 2'),
(178, 3, 'Close time slot 3'),
(179, 3, 'Close time slot 1'),
(180, 3, 'Close time slot 1'),
(181, 3, 'Close time slot 1'),
(182, 3, 'Close time slot 1'),
(183, 3, 'Close time slot 2'),
(184, 3, 'Close time slot 2'),
(185, 3, 'Close time slot 2'),
(186, 3, 'Close without active time slot'),
(187, 3, 'Close time slot 1'),
(188, 3, 'Close time slot 1'),
(189, 3, 'Close time slot 1'),
(190, 3, 'Close time slot 1'),
(191, 3, 'Close time slot 1'),
(192, 3, 'Close time slot 1'),
(193, 3, 'Close time slot 1'),
(194, 3, 'Close time slot 1'),
(195, 3, 'Close time slot 1'),
(196, 3, 'Close without active time slot'),
(197, 3, 'Close time slot 7842'),
(198, 3, 'Close time slot 7842'),
(199, 3, 'Close time slot 7842'),
(200, 3, 'Close time slot 7843'),
(201, 3, 'Close time slot 7845'),
(202, 3, 'Close time slot 7846'),
(203, 3, 'Close time slot 7845'),
(204, 3, 'Close without active time slot'),
(205, 3, 'Close without active time slot'),
(206, 3, 'Close without active time slot'),
(207, 3, 'Close without active time slot'),
(208, 3, 'Close time slot 14090'),
(209, 3, 'Close without active time slot'),
(210, 1, 'Close without active time slot');

-- --------------------------------------------------------

--
-- Table structure for table `holidays`
--

CREATE TABLE IF NOT EXISTS `holidays` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `holidays` text COLLATE utf8_slovak_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_slovak_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `holidays`
--

INSERT INTO `holidays` (`id`, `holidays`) VALUES
(1, '5-13,12-24,12-25,12-26,12-27,12-28,12-07,12-14,12-15');

-- --------------------------------------------------------

--
-- Table structure for table `time_slot`
--

CREATE TABLE IF NOT EXISTS `time_slot` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_gate` int(11) NOT NULL,
  `id_external_dispatcher` int(11) NOT NULL,
  `id_truck_driver_1` int(11) NOT NULL,
  `id_truck_driver_2` int(11) NOT NULL,
  `evc_truck` varchar(20) COLLATE utf8_slovak_ci DEFAULT NULL,
  `id_destination_order` int(11) DEFAULT NULL,
  `start_date_time` datetime NOT NULL,
  `end_date_time` datetime NOT NULL,
  `state` varchar(20) COLLATE utf8_slovak_ci NOT NULL,
  `ocupide_start_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `ocupide_end_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_slovak_ci AUTO_INCREMENT=26136 ;

--
-- Dumping data for table `time_slot`
--

INSERT INTO `time_slot` (`id`, `id_gate`, `id_external_dispatcher`, `id_truck_driver_1`, `id_truck_driver_2`, `evc_truck`, `id_destination_order`, `start_date_time`, `end_date_time`, `state`, `ocupide_start_time`, `ocupide_end_time`) VALUES
(26106, 1, 0, 0, 0, NULL, NULL, '2020-12-14 07:00:00', '2020-12-14 09:30:00', 'prepared', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(26107, 1, 0, 0, 0, NULL, NULL, '2020-12-14 09:30:00', '2020-12-14 12:00:00', 'prepared', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(26108, 1, 0, 0, 0, NULL, NULL, '2020-12-14 12:00:00', '2020-12-14 14:30:00', 'prepared', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(26109, 1, 0, 0, 0, NULL, NULL, '2020-12-14 14:30:00', '2020-12-14 17:00:00', 'prepared', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(26110, 1, 0, 0, 0, NULL, NULL, '2020-12-14 17:00:00', '2020-12-14 19:30:00', 'prepared', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(26111, 1, 0, 0, 0, NULL, NULL, '2020-12-14 19:30:00', '2020-12-14 22:00:00', 'prepared', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(26112, 1, 0, 0, 0, NULL, NULL, '2020-12-15 06:00:00', '2020-12-15 08:30:00', 'prepared', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(26113, 1, 0, 0, 0, NULL, NULL, '2020-12-15 08:30:00', '2020-12-15 11:00:00', 'prepared', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(26114, 1, 0, 0, 0, NULL, NULL, '2020-12-15 11:00:00', '2020-12-15 13:30:00', 'prepared', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(26115, 1, 0, 0, 0, NULL, NULL, '2020-12-15 13:30:00', '2020-12-15 16:00:00', 'prepared', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(26116, 1, 0, 0, 0, NULL, NULL, '2020-12-15 16:00:00', '2020-12-15 18:30:00', 'prepared', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(26117, 1, 0, 0, 0, NULL, NULL, '2020-12-15 18:30:00', '2020-12-15 21:00:00', 'prepared', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(26118, 1, 0, 0, 0, NULL, NULL, '2020-12-16 06:00:00', '2020-12-16 08:30:00', 'prepared', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(26119, 1, 0, 0, 0, NULL, NULL, '2020-12-16 08:30:00', '2020-12-16 11:00:00', 'prepared', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(26120, 1, 0, 0, 0, NULL, NULL, '2020-12-16 11:00:00', '2020-12-16 13:30:00', 'prepared', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(26121, 1, 0, 0, 0, NULL, NULL, '2020-12-16 13:30:00', '2020-12-16 16:00:00', 'prepared', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(26122, 1, 0, 0, 0, NULL, NULL, '2020-12-16 16:00:00', '2020-12-16 18:30:00', 'prepared', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(26123, 1, 0, 0, 0, NULL, NULL, '2020-12-16 18:30:00', '2020-12-16 21:00:00', 'prepared', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(26124, 1, 0, 0, 0, NULL, NULL, '2020-12-17 07:00:00', '2020-12-17 09:30:00', 'prepared', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(26125, 1, 0, 0, 0, NULL, NULL, '2020-12-17 09:30:00', '2020-12-17 12:00:00', 'prepared', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(26126, 1, 0, 0, 0, NULL, NULL, '2020-12-17 12:00:00', '2020-12-17 14:30:00', 'prepared', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(26127, 1, 0, 0, 0, NULL, NULL, '2020-12-17 14:30:00', '2020-12-17 17:00:00', 'prepared', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(26128, 1, 0, 0, 0, NULL, NULL, '2020-12-17 17:00:00', '2020-12-17 19:30:00', 'prepared', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(26129, 1, 0, 0, 0, NULL, NULL, '2020-12-17 19:30:00', '2020-12-17 22:00:00', 'prepared', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(26130, 1, 0, 0, 0, NULL, NULL, '2020-12-18 07:00:00', '2020-12-18 09:30:00', 'prepared', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(26131, 1, 0, 0, 0, NULL, NULL, '2020-12-18 09:30:00', '2020-12-18 12:00:00', 'prepared', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(26132, 1, 0, 0, 0, NULL, NULL, '2020-12-18 12:00:00', '2020-12-18 14:30:00', 'prepared', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(26133, 1, 0, 0, 0, NULL, NULL, '2020-12-18 14:30:00', '2020-12-18 17:00:00', 'prepared', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(26134, 1, 0, 0, 0, NULL, NULL, '2020-12-18 17:00:00', '2020-12-18 19:30:00', 'prepared', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(26135, 1, 0, 0, 0, NULL, NULL, '2020-12-18 19:30:00', '2020-12-18 22:00:00', 'prepared', '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `truck_driver`
--

CREATE TABLE IF NOT EXISTS `truck_driver` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `full_name` varchar(50) COLLATE utf8_slovak_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_slovak_ci AUTO_INCREMENT=17 ;

--
-- Dumping data for table `truck_driver`
--

INSERT INTO `truck_driver` (`id`, `full_name`) VALUES
(1, 'Jozko Zlaty'),
(2, 'Ferko Mrkvicka'),
(3, 'Alica Zazrakov'),
(4, 'Zlatka zlta'),
(5, 'Kamiom kamionisticky'),
(6, 'Iba kamion'),
(7, 'Nie niesomKamion'),
(8, 'Hmm Hmmmm'),
(9, 'A Haaaa'),
(10, 'Juraj Oslovsky'),
(11, 'Zabka Zabkova'),
(12, 'Sused Neverni'),
(13, 'Kamarat Parohac'),
(14, 'Janko Hrasko'),
(15, 'Hrasko Janko'),
(16, 'Sarsa Mafia1');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
