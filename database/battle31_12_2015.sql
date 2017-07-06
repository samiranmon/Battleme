-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Dec 31, 2015 at 06:04 PM
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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `friend_list`
--

INSERT INTO `friend_list` (`id`, `resource_id`, `user_id`, `active`, `resourse_approved`, `user_approved`, `message`, `req_sent`, `req_accepted`) VALUES
(1, 1, 3, 0, 1, 0, '', '2015-12-31 16:16:10', '0000-00-00'),
(2, 3, 1, 0, 0, 1, '', '2015-12-31 16:16:10', '0000-00-00'),
(3, 2, 3, 0, 1, 0, '', '2015-12-31 16:25:14', '0000-00-00'),
(4, 3, 2, 0, 0, 1, '', '2015-12-31 16:25:14', '0000-00-00');

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE IF NOT EXISTS `notifications` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `subject_id` int(11) NOT NULL,
  `subject_type` varchar(11) NOT NULL,
  `object_id` int(11) NOT NULL,
  `object_type` varchar(11) NOT NULL,
  `message` text NOT NULL,
  `status` int(11) NOT NULL DEFAULT '0',
  `created_on` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `subject_id`, `subject_type`, `object_id`, `object_type`, `message`, `status`, `created_on`) VALUES
(1, 3, 'fan', 1, 'fan', 'have send you friend request', 0, '2015-12-31 16:16:10'),
(2, 3, 'fan', 2, 'fan', 'have send you friend request', 0, '2015-12-31 16:25:14');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `user_type` varchar(255) DEFAULT NULL,
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
  `secret_key` varchar(250) NOT NULL,
  `keycreated` datetime NOT NULL,
  `created_on` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `firstname`, `lastname`, `email`, `user_type`, `password`, `phone_no`, `profile_picture`, `address1`, `address2`, `city`, `state`, `country`, `info`, `aboutme`, `secret_key`, `keycreated`, `created_on`) VALUES
(1, 'Aatish', 'Gore', 'aatish.gore@wwindia.com', 'fan', '5e06d17c2c27db807bd5497972a6e90c', NULL, 'johndoe1.jpg', NULL, NULL, 'Mumbai', NULL, 'India', 'Software Developer 1', 'Software Developer', '', '0000-00-00 00:00:00', '2015-12-30'),
(2, 'John', 'Doe', 'johndoe@gmail.com', 'fan', '6579e96f76baa00787a28653876c6127', NULL, 'johndoe.jpg', NULL, NULL, 'Mumbai', NULL, 'India', 'dummy user', 'dummy user', '', '0000-00-00 00:00:00', '2015-12-30'),
(3, 'Tushar', 'Patil', 'tushar.patil@wwindia.com', 'fan', 'df7c905d9ffebe7cda405cf1c82a3add', NULL, NULL, NULL, NULL, 'Mumbai', NULL, 'India', 'Software Developer', 'Software Developer', '', '0000-00-00 00:00:00', '2015-12-30');

-- --------------------------------------------------------

--
-- Table structure for table `user_follow`
--

CREATE TABLE IF NOT EXISTS `user_follow` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `following_frnd_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
