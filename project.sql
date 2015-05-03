-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: May 03, 2015 at 02:55 PM
-- Server version: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `project`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE IF NOT EXISTS `categories` (
  `categoryid` int(11) NOT NULL AUTO_INCREMENT,
  `catname` varchar(30) NOT NULL,
  PRIMARY KEY (`categoryid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`categoryid`, `catname`) VALUES
(2, 'Food');

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE IF NOT EXISTS `product` (
  `productid` int(11) NOT NULL AUTO_INCREMENT,
  `category` varchar(25) NOT NULL,
  `productname` varchar(25) NOT NULL,
  `vendorid` varchar(25) NOT NULL,
  `description` varchar(200) NOT NULL,
  `price` float NOT NULL,
  `productnumber` int(11) NOT NULL,
  `features` varchar(100) NOT NULL,
  `image` varchar(300) NOT NULL,
  `constraints` varchar(100) NOT NULL,
  `discount` int(3) NOT NULL,
  `approved` varchar(1) NOT NULL COMMENT 'p= pending, a=approved, r=removed',
  `quantity` int(10) NOT NULL,
  PRIMARY KEY (`productid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=16 ;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`productid`, `category`, `productname`, `vendorid`, `description`, `price`, `productnumber`, `features`, `image`, `constraints`, `discount`, `approved`, `quantity`) VALUES
(2, 'Food', 'food', 'vendor', 'food', 10, 10, 'food', 'food.jpg', 'food', 10, '1', 189),
(3, 'Food2', 'Fooodsss', 'vendor', 'food', 10, 10, 'food', 'food.jpg', 'food', 10, '1', 207),
(4, 'Food', 'food9', 'vendor', 'food9', 9, 999, 'food9', 'DSCN0027.JPG', 'food', 9, '0', 9),
(5, 'Food', 'food3', 'vendor', 'food3', 3, 3, '3', 'apples.gif', '3', 3, '0', 3),
(6, 'Food', 'test', 'vendor', 'test', 100, 100, '100', 'apples.gif', '100', 100, '0', 100),
(7, 'Food', 'apple', 'vendor', 'apple', 2, 2, '2', 'apples.gif', '2', 2, '0', 2),
(8, 'Food', 'apple6', 'vendor', 'apple', 2, 2, '2', 'apples.gif', '2', 2, '0', 2),
(9, 'Food', 'app', 'vendor', 'app', 9, 9, '9', 'apples.gif', '9', 9, '0', 9),
(10, 'Food', 'vendor', 'vendor', 'vendor', 9, 9, '9', 'apples.gif', '9', 9, '0', 9),
(11, 'Food', 'vendor3', 'vendor', 'vendor3', 9, 9, '9', 'apples.gif', '9', 9, '1', 9),
(12, 'Food', 'vendor9', 'vendor', 'vendor9', 9, 9, '9', 'apples.gif', '9', 9, '1', 9),
(13, 'Food', 'vend', 'vendor', 'vend', 7, 7, '7', 'apples.gif', '7', 7, '0', 7),
(14, 'Food', 'pear', 'vendor', 'pear', 10, 10, '10', 'food.jpg', '10', 10, '0', 10),
(15, 'Food', 'apple', 'vendor', 'apple', 9, 9, 'apple', 'apples.gif', 'apple', 9, 'r', 9);

-- --------------------------------------------------------

--
-- Table structure for table `transaction`
--

CREATE TABLE IF NOT EXISTS `transaction` (
  `transactionid` timestamp NOT NULL,
  `username` varchar(20) NOT NULL,
  `vendorid` varchar(20) NOT NULL,
  `productid` int(11) NOT NULL,
  `productamount` int(11) NOT NULL,
  `price` int(11) NOT NULL,
  `status` varchar(1) NOT NULL DEFAULT 'p' COMMENT '''p''=pending, ''s''=shipped, ''c''=cancelled',
  `fname` varchar(20) NOT NULL,
  `lname` varchar(20) NOT NULL,
  `address` varchar(25) NOT NULL,
  `city` varchar(20) NOT NULL,
  `state` varchar(2) NOT NULL,
  `zipcode` int(5) NOT NULL,
  PRIMARY KEY (`transactionid`,`username`,`productid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `transaction`
--

INSERT INTO `transaction` (`transactionid`, `username`, `vendorid`, `productid`, `productamount`, `price`, `status`, `fname`, `lname`, `address`, `city`, `state`, `zipcode`) VALUES
('2015-04-22 19:05:29', 'user1', 'vendor2', 2, 9, 9, 's', 'User', 'One', '123 Addr Road', 'Long Branch', 'NJ', 7764),
('2015-04-25 21:03:43', 'user1', 'vendor2', 2, 9, 9, 's', 'User', 'One', '123 Addr Road', 'Long Branch', 'NJ', 7764),
('2015-04-25 21:03:47', 'user1', 'vendor2', 2, 20, 9, 'c', 'User', 'One', '123 Addr Road', 'Long Branch', 'NJ', 7764),
('2015-04-25 23:25:53', 'user1', 'vendor2', 2, 13, 9, 's', 'User', 'One', '123 Addr Road', 'Long Branch', 'NJ', 7764),
('2015-04-26 19:05:42', 'user1', 'vendor2', 2, 9, 9, 's', 'User', 'One', '123 Addr Road', 'Long Branch', 'NJ', 7764);

--
-- Triggers `transaction`
--
DROP TRIGGER IF EXISTS `decrimentQuantities`;
DELIMITER //
CREATE TRIGGER `decrimentQuantities` AFTER INSERT ON `transaction`
 FOR EACH ROW UPDATE product
     SET quantity = COALESCE(quantity, 0) -  COALESCE(NEW.productamount,0)
   WHERE productid = NEW.productid
//
DELIMITER ;
DROP TRIGGER IF EXISTS `incrementOnCancel`;
DELIMITER //
CREATE TRIGGER `incrementOnCancel` AFTER UPDATE ON `transaction`
 FOR EACH ROW UPDATE product
     SET quantity = COALESCE(quantity, 0) +  COALESCE(NEW.productamount,0)
   WHERE productid = NEW.productid AND NEW.status = 'c'
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `username` varchar(20) NOT NULL,
  `fname` varchar(20) NOT NULL,
  `lname` varchar(20) NOT NULL,
  `psword` varchar(50) NOT NULL,
  `address` varchar(25) NOT NULL,
  `city` varchar(20) NOT NULL,
  `state` varchar(2) NOT NULL,
  `zipcode` int(5) NOT NULL,
  `email` varchar(40) NOT NULL,
  `phone` varchar(10) NOT NULL,
  `lastlogin` bigint(10) NOT NULL,
  `loginattempts` int(11) NOT NULL,
  `role` varchar(12) NOT NULL,
  `approved` tinyint(1) NOT NULL,
  `locked` tinyint(1) NOT NULL,
  PRIMARY KEY (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`username`, `fname`, `lname`, `psword`, `address`, `city`, `state`, `zipcode`, `email`, `phone`, `lastlogin`, `loginattempts`, `role`, `approved`, `locked`) VALUES
('admin', 'admin', 'admin', 'd033e22ae348aeb5660fc2140aec35850c4da997', 'adminville', 'admin', 'NJ', 7712, 'admin', '1111111', 0, 0, 'admin', 0, 0),
('admin2', 'Admin', 'Two', '9d737ae503ed092cd1b5e2fec61d8474be13a9c1', '123 Addr Road', 'Long Branch', 'NJ', 7764, 'vendor2@email.com', '1234567890', 0, 0, 'admin', 1, 0),
('user1', 'User', 'One', 'b3daa77b4c04a9551b8781d03191fe098f325e67', '123 Addr Road', 'Long Branch', 'NJ', 7764, 'user1@email.com', '1234567890', 0, 0, 'customer', 0, 0),
('user2', 'User', 'Two', 'a1881c06eec96db9901c7bbfe41c42a3f08e9cb4', '123 Addr Road', 'Columbia', 'FL', 7764, 'fake@email.com', '3332221111', 0, 0, 'customer', 0, 0),
('vendor', 'vendor', 'vendor', '9fdcb2f441fcdd2e24e21bf8d45413ae72c0443c', 'vendor', 'vendor', 'NJ', 7755, 'vendor', '111111', 1430341645, 0, 'vendor', 1, 0),
('vendor2', 'Vendor', 'Two', '9d737ae503ed092cd1b5e2fec61d8474be13a9c1', '123 Addr Road', 'Long Branch', 'NJ', 7764, 'vendor2@email.com', '1234567890', 0, 0, 'vendor', 1, 0);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
