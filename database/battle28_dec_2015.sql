-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Dec 28, 2015 at 08:48 PM
-- Server version: 5.5.43-0ubuntu0.14.04.1
-- PHP Version: 5.5.9-1ubuntu4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `battle`
--

-- --------------------------------------------------------

--
-- Table structure for table `friend_list`
--

CREATE TABLE IF NOT EXISTS `friend_list` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `resource_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `active` int(11) NOT NULL,
  `resourse_approved` int(11) NOT NULL DEFAULT '0',
  `user_approved` int(11) NOT NULL DEFAULT '0',
  `message` text NOT NULL,
  `req_sent` datetime NOT NULL,
  `req_accepted` date NOT NULL,
  PRIMARY KEY (`id`),
  KEY `resource_id` (`resource_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `friend_list`
--

INSERT INTO `friend_list` (`id`, `resource_id`, `user_id`, `active`, `resourse_approved`, `user_approved`, `message`, `req_sent`, `req_accepted`) VALUES
(1, 3, 1, 1, 1, 1, '', '2015-12-28 13:01:32', '2015-12-28'),
(2, 1, 3, 1, 1, 1, '', '2015-12-28 13:01:32', '2015-12-28'),
(3, 3, 2, 1, 1, 1, '', '2015-12-28 13:01:34', '2015-12-28'),
(4, 2, 3, 1, 1, 1, '', '2015-12-28 13:01:34', '2015-12-28'),
(5, 2, 1, 1, 1, 1, '', '2015-12-28 16:19:37', '2015-12-28'),
(6, 1, 2, 1, 1, 1, '', '2015-12-28 16:19:37', '2015-12-28');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `phone_no` varchar(255) DEFAULT NULL,
  `profile_picture` varchar(255) DEFAULT NULL,
  `address1` text,
  `address2` text,
  `city` varchar(255) DEFAULT NULL,
  `state` varchar(255) DEFAULT NULL,
  `country` varchar(255) DEFAULT NULL,
  `info` text NOT NULL,
  `aboutme` varchar(250) NOT NULL,
  `key` varchar(250) NOT NULL,
  `keycreated` datetime NOT NULL,
  `created_on` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `firstname`, `lastname`, `email`, `username`, `password`, `phone_no`, `profile_picture`, `address1`, `address2`, `city`, `state`, `country`, `info`, `aboutme`, `key`, `keycreated`, `created_on`) VALUES
(1, 'Tushar', 'Patil', 'tushar.patil@wwindia.com', NULL, 'df7c905d9ffebe7cda405cf1c82a3add', NULL, 'dsfd.jpg', NULL, '', 'Mumbai', NULL, 'India', 'Software Developer @ neosoft technologies', 'Software Developer', '', '0000-00-00 00:00:00', '2015-12-21'),
(2, 'Sameer', 'Jambhulkar', 'sameer.jambhulkar@wwindia.com', NULL, 'd524813536b71639999ba12bdb3621a8', NULL, 'sameer.jpg', NULL, NULL, 'Kalyan', NULL, 'India', 'Neosoft', 'Software Developer', '', '0000-00-00 00:00:00', '2015-12-21'),
(3, 'Shriniwas', 'Yesare', 'shriniwas.yesare@wwindia.com', NULL, '90dc8a8bf354717411720f32fa4a83c6', NULL, 'shri.jpg', NULL, NULL, 'Kolhapur', NULL, 'India', 'Drupal developer', 'Software Developer', '', '0000-00-00 00:00:00', '2015-12-23'),
(4, 'John', 'Doe', 'johndoe@gmail.com', NULL, '5f4dcc3b5aa765d61d8327deb882cf99', NULL, 'johndoe.jpg', NULL, NULL, 'Vasai', NULL, 'India', 'dummy text', 'dummy text', '', '0000-00-00 00:00:00', '2015-12-24');

-- --------------------------------------------------------

--
-- Table structure for table `user_follow`
--

CREATE TABLE IF NOT EXISTS `user_follow` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `following_frnd_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `user_follow`
--

INSERT INTO `user_follow` (`id`, `user_id`, `following_frnd_id`) VALUES
(1, 2, 1),
(2, 2, 3),
(3, 2, 4),
(4, 1, 2);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
