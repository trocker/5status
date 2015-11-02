-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Oct 27, 2015 at 03:36 AM
-- Server version: 5.5.44-0ubuntu0.14.04.1
-- PHP Version: 5.5.9-1ubuntu4.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `5status`
--

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE IF NOT EXISTS `accounts` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `user_id` int(255) NOT NULL,
  `email_id` varchar(2000) NOT NULL,
  `password_hash` varchar(2000) NOT NULL,
  `auth_key` varchar(2000) NOT NULL,
  `creation_date` varchar(200) NOT NULL,
  `modified_date` varchar(200) NOT NULL,
  `account_status` varchar(200) NOT NULL DEFAULT 'INVITED',
  `name` varchar(2000) NOT NULL DEFAULT 'DEFAULT',
  `picture` varchar(2000) NOT NULL DEFAULT 'http://societyofillustratorssandiego.org/wp-content/uploads/2015/03/male-placeholder.gif',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`id`, `user_id`, `email_id`, `password_hash`, `auth_key`, `creation_date`, `modified_date`, `account_status`, `name`, `picture`) VALUES
(1, 17700, 'nsteja1@gmail.com', 'd73b04b0e696b0945283defa3eee4538', 'comeonwork', '1443486420\r\n', '1443486420', 'JOINED', 'DEFAULT', 'http://societyofillustratorssandiego.org/wp-content/uploads/2015/03/male-placeholder.gif'),
(8, 17701, 'someone@example.com', '99c9b6865ba532fb581c01710f857eebbf8522bdb8ec17276e9fe3e5be321660', '798839820299950', '1445910207', '1445910207', 'JOINED', 'Goatee Person', 'http://i.imgur.com/43ESX4c.png');

-- --------------------------------------------------------

--
-- Table structure for table `cards`
--

CREATE TABLE IF NOT EXISTS `cards` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `card_title` varchar(2000) NOT NULL,
  `owner_id` varchar(200) NOT NULL,
  `creation_date` varchar(200) NOT NULL,
  `modified_date` varchar(200) NOT NULL,
  `card_status` varchar(200) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `cards`
--

INSERT INTO `cards` (`id`, `card_title`, `owner_id`, `creation_date`, `modified_date`, `card_status`) VALUES
(6, 'Call up the plumber', '17700', '1443493952', '1443493952', 'TO-DO'),
(7, 'Call up the plumber', '17700', '1443494123', '1443494123', 'TO-DO'),
(8, 'DO NOT Call up the plumber', '17700', '1443494203', '1443494203', 'TO-DO'),
(9, 'Electrician please!', '17700', '1443637559', '1443637559', 'TO-DO'),
(10, 'CHANGE THE FREAKING TITLE 1234', '17700', '1444949291', '1444949291', 'TO-DO');

-- --------------------------------------------------------

--
-- Table structure for table `card_sharers`
--

CREATE TABLE IF NOT EXISTS `card_sharers` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `card_id` int(255) NOT NULL,
  `user_id` int(255) NOT NULL,
  `priority` int(255) NOT NULL,
  `creation_date` int(255) NOT NULL,
  `joined_comments` varchar(1000) NOT NULL DEFAULT 'NONE',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE IF NOT EXISTS `comments` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `comment` varchar(2000) NOT NULL,
  `card_id` int(255) DEFAULT NULL,
  `creation_date` int(255) NOT NULL,
  `type` varchar(255) NOT NULL DEFAULT 'NORMAL',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
