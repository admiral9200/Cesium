-- phpMyAdmin SQL Dump
-- version 4.5.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jan 30, 2021 at 10:37 PM
-- Server version: 10.1.13-MariaDB
-- PHP Version: 5.6.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+02:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `chip_coffee`
--

-- --------------------------------------------------------

--
-- Table structure for table `cc_address`
--

CREATE TABLE `cc_address` (
  `email` varchar(100) NOT NULL,
  `address` varchar(100) NOT NULL,
  `state` varchar(100) NOT NULL,
  `active` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cc_address`
--

INSERT INTO `cc_address` (`email`, `address`, `state`, `active`) VALUES
('some@random.mail', 'Test', 'Test 23231', 0);

-- --------------------------------------------------------

--
-- Table structure for table `cc_coffees`
--

CREATE TABLE `cc_coffees` (
  `code` smallint(5) NOT NULL,
  `name` varchar(100) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `milk` tinyint(1) NOT NULL,
  `cinnamon` tinyint(1) NOT NULL,
  `choco` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cc_coffees`
--

INSERT INTO `cc_coffees` (`code`, `name`, `price`, `milk`, `cinnamon`, `choco`) VALUES
(1000, 'Espresso', '1.00', 0, 0, 0),
(1001, 'Cappuccino', '1.00', 0, 1, 1),
(1002, 'Cappuccino Latte', '1.00', 0, 1, 1),
(1003, 'Freddo Espresso', '1.00', 1, 0, 0),
(1004, 'Freddo Cappuccino', '1.10', 0, 1, 0),
(1005, 'Freddo Cappuccino Latte', '1.30', 0, 1, 0),
(1006, 'Frappe', '0.60', 1, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `cc_orders`
--

CREATE TABLE `cc_orders` (
  `email` varchar(100) NOT NULL,
  `date` varchar(10) NOT NULL,
  `time` varchar(10) NOT NULL,
  `payment` varchar(40) NOT NULL,
  `doorname` varchar(100) NOT NULL,
  `floor` int(3) NOT NULL,
  `phone` int(15) NOT NULL,
  `comment` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `cc_orders_products`
--

CREATE TABLE `cc_orders_products` (
  `id` int(10) NOT NULL,
  `coffee` varchar(100) NOT NULL,
  `sugar` varchar(30) NOT NULL,
  `sugarType` varchar(30) NOT NULL,
  `milk` tinyint(1) NOT NULL,
  `choco` tinyint(1) NOT NULL,
  `cinnamon` tinyint(1) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `qty` tinyint(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `cc_payments`
--

CREATE TABLE `cc_payments` (
  `id` int(10) NOT NULL,
  `txnid` varchar(20) NOT NULL,
  `payment_amount` decimal(7,2) NOT NULL,
  `payment_status` varchar(25) NOT NULL,
  `itemid` varchar(25) NOT NULL,
  `createdtime` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `cc_staff`
--

CREATE TABLE `cc_staff` (
  `email` varchar(100) NOT NULL,
  `firstName` varchar(100) NOT NULL,
  `lastName` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cc_staff`
--

INSERT INTO `cc_staff` (`email`, `firstName`, `lastName`, `password`) VALUES
('z3r0luck@mail.com', 'Efthymios', 'Paraschou', 'developer');

-- --------------------------------------------------------

--
-- Table structure for table `cc_users`
--

CREATE TABLE `cc_users` (
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `firstName` varchar(100) NOT NULL,
  `lastName` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cc_orders`
--
ALTER TABLE cc_orders ADD id MEDIUMINT UNSIGNED NOT NULL AUTO_INCREMENT FIRST, ADD INDEX (id);

--
-- Indexes for table `cc_orders_products`
--
ALTER TABLE `cc_orders_products`
  ADD KEY `id` (`id`);

--
-- Indexes for table `cc_payments`
--
ALTER TABLE `cc_payments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cc_users`
--
ALTER TABLE `cc_users` ADD PRIMARY KEY (`email`);

ALTER TABLE `cc_orders` AUTO_INCREMENT = 10000;

--
-- AUTO_INCREMENT for table `cc_payments`
--
ALTER TABLE `cc_payments`
  MODIFY `id` int(6) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
