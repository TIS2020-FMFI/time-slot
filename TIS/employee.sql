-- phpMyAdmin SQL Dump
-- version 4.0.4.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Nov 06, 2020 at 01:54 PM
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

-- --------------------------------------------------------

--
-- Table structure for table `employee`
--

CREATE TABLE IF NOT EXISTS `employee` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `meno` text NOT NULL,
  `priezvsko` text NOT NULL,
  `email` text NOT NULL,
  `heslo` text NOT NULL,
  `role` text NOT NULL,
  `is_working` tinyint(1) NOT NULL,
  `login_count` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `employee`
--

INSERT INTO `employee` (`id`, `meno`, `priezvsko`, `email`, `heslo`, `role`, `is_working`, `login_count`) VALUES
(2, 'Admin', 'Admin', 'admin.admin@gmial.com', '21232f297a57a5a743894a0e4a801fc3', 'AD', 1, 0),
(3, 'EXD', 'EXD', 'EXD.EXD@gmial.com', '08e72627bd8dce9e03cf847a7569a5de', 'EXD', 1, 0),
(4, 'IND', 'IND', 'IND.IND@gmial.com', '82828756da24342a94c9b1355ae83653', 'IND', 1, 0),
(5, 'GM', 'GM', 'GM.GM@gmial.com', '64f3bd1741ab8d6ba545a1ae09bb8728', 'GM', 1, 0),
(6, 'asdfsdfsg', 'dfsghg', 'root@gmial.com', '6db23eee40d34e8290441bd8ff5bd924', 'EXD', 0, 0);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
