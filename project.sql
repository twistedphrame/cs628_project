-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Apr 24, 2015 at 11:27 PM
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
  `approved` tinyint(1) NOT NULL DEFAULT '0',
  `quantity` int(10) NOT NULL,
  PRIMARY KEY (`productid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`productid`, `category`, `productname`, `vendorid`, `description`, `price`, `productnumber`, `features`, `image`, `constraints`, `discount`, `approved`, `quantity`) VALUES
(2, 'Food', 'food', 'vendor', 'food', 10, 10, 'food', 'food', 'food', 10, 0, 20);

-- --------------------------------------------------------

--
-- Table structure for table `transaction`
--

CREATE TABLE IF NOT EXISTS `transaction` (
  `transactionid` datetime NOT NULL,
  `username` varchar(20) NOT NULL,
  `vendorid` varchar(20) NOT NULL,
  `productid` int(11) NOT NULL,
  `productamount` int(11) NOT NULL,
  `price` int(11) NOT NULL,
  `delivered` tinyint(1) NOT NULL,
  PRIMARY KEY (`transactionid`,`username`,`productid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
  `lastlogin` date NOT NULL,
  `loginattempts` int(11) NOT NULL,
  `role` varchar(12) NOT NULL,
  `approved` tinyint(1) NOT NULL,
  PRIMARY KEY (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`username`, `fname`, `lname`, `psword`, `address`, `city`, `state`, `zipcode`, `email`, `phone`, `lastlogin`, `loginattempts`, `role`, `approved`) VALUES
('admin', 'admin', 'admin', 'd033e22ae348aeb5660fc2140aec35850c4da997', 'adminville', 'admin', 'NJ', 7712, 'admin', '1111111', '0000-00-00', 0, 'admin', 0),
('user1', 'User', 'One', 'b3daa77b4c04a9551b8781d03191fe098f325e67', '123 Addr Road', 'Long Branch', 'NJ', 7764, 'user1@email.com', '1234567890', '0000-00-00', 0, 'customer', 0),
('user2', 'User', 'Two', 'a1881c06eec96db9901c7bbfe41c42a3f08e9cb4', '123 Addr Road', 'Columbia', 'FL', 7764, 'fake@email.com', '3332221111', '0000-00-00', 0, 'customer', 0),
('vendor', 'vendor', 'vendor', '9fdcb2f441fcdd2e24e21bf8d45413ae72c0443c', 'vendor', 'vendor', 'NJ', 7755, 'vendor', '111111', '0000-00-00', 0, 'vendor', 0);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
