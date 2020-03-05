-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 16, 2019 at 06:46 PM
-- Server version: 10.1.38-MariaDB
-- PHP Version: 7.3.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `id2134730_pos`
--

-- --------------------------------------------------------

--
-- Table structure for table `administrators`
--

CREATE TABLE `administrators` (
  `Username` varchar(20) NOT NULL,
  `password` char(255) NOT NULL,
  `Email` varchar(240) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `administrators`
--

INSERT INTO `administrators` (`Username`, `password`, `Email`) VALUES
('Dallington', '$2y$10$FzOEz9Irm5CCEpGrJVxh6OIAQNyTlIuJUlRt/BMrnut004Hl4iMAG', 'asingwire50dallington@gmail.com');

-- --------------------------------------------------------

--
-- Stand-in structure for view `bestcustomers`
-- (See below for the actual view)
--
CREATE TABLE `bestcustomers` (
`Customer` varchar(30)
,`VolumeofSales` double
,`percent` double(19,2)
);

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `ItemId` int(255) NOT NULL,
  `Item` varchar(200) NOT NULL,
  `Quantity` int(255) NOT NULL,
  `Price` double NOT NULL,
  `Total` double NOT NULL,
  `Discount` double NOT NULL,
  `Amount` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `cashiers`
--

CREATE TABLE `cashiers` (
  `id` int(11) NOT NULL,
  `CashierName` varchar(20) NOT NULL,
  `MobileNo` varchar(17) NOT NULL,
  `Address` varchar(20) NOT NULL,
  `Email` varchar(50) DEFAULT NULL,
  `Password` varchar(255) NOT NULL,
  `Image` longblob
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cashiers`
--

INSERT INTO `cashiers` (`id`, `CashierName`, `MobileNo`, `Address`, `Email`, `Password`, `Image`) VALUES
(3, 'james Aine', '07005782175', 'Mbarara', 'ainejames90@gmail.com', '$2y$10$dzdmWl11', NULL),
(20, 'Dallington', '0774017823', 'Mukono', 'findpaulkee@gmail.com', '$2y$10$UJqvWW8CTffd80awD4ni/eWkT5trmvJbganW3cICMh1KueR9g/be6', NULL);

-- --------------------------------------------------------

--
-- Stand-in structure for view `cashiersperformance`
-- (See below for the actual view)
--
CREATE TABLE `cashiersperformance` (
`Cashier` varchar(20)
,`VolumeofConductedSales` double
,`percent` double(19,2)
);

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `id` int(255) NOT NULL,
  `Category` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `Category`) VALUES
(1, 'Alcoholics'),
(3, 'Beverage'),
(5, 'Building materials'),
(4, 'Computer'),
(2, 'Fast Food'),
(6, 'Furniture'),
(8, 'Utensils');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` int(250) NOT NULL,
  `CustomerName` varchar(40) NOT NULL,
  `Phone` varchar(15) NOT NULL,
  `DR` double NOT NULL,
  `CR` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `CustomerName`, `Phone`, `DR`, `CR`) VALUES
(1, 'Peterson Ainomugisha', '+2247893030319', 5700, 500),
(2, 'Alison Becker', '+256774014672', 1000, 5500),
(3, 'Henderson', '+2567772712442', 800, 9000),
(4, 'Mugisha Peter', '+256792712763', 3658595000, 200),
(5, 'John Nasasira', '+2567772712672', 0, 3658595000),
(6, 'Mercy k', '0789358972', 0, 0),
(9, 'Ike', '+2567772712432', 0, 0),
(10, 'Jane Allen', '+2567772712431', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `damages`
--

CREATE TABLE `damages` (
  `id` int(250) NOT NULL,
  `ItemID` varchar(30) NOT NULL,
  `ProductName` varchar(30) NOT NULL,
  `Category` varchar(80) NOT NULL,
  `Quantity` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `damages`
--

INSERT INTO `damages` (`id`, `ItemID`, `ProductName`, `Category`, `Quantity`) VALUES
(2, 'fa', 'fanta', 'Beverage', 80),
(7, 'su', 'sugar', 'Beverage', 5),
(9, 'ri', 'rice', 'Beverage', 8),
(10, 'sa', 'salt', 'Fast food', 6),
(12, 'mi', 'milk', 'Beverage', 8),
(13, 'ce', 'cement', 'Building materials', 4),
(15, 'de', 'decoder', 'Beverage', 8),
(18, 'ri', 'Rice', ' Food', 2);

-- --------------------------------------------------------

--
-- Table structure for table `expenses`
--

CREATE TABLE `expenses` (
  `id` int(255) NOT NULL,
  `ExpenseType` varchar(200) NOT NULL,
  `Amount` double NOT NULL,
  `DateOfExpense` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `expenses`
--

INSERT INTO `expenses` (`id`, `ExpenseType`, `Amount`, `DateOfExpense`) VALUES
(1, 'Rent', 50, '2019-07-30 21:00:00'),
(3, 'Salary', 7000, '2019-07-22 00:00:00'),
(4, 'Transport', 10000, '2019-07-21 00:00:00'),
(6, 'Salary', 450000, '2019-07-21 00:00:00'),
(7, 'Transport', 45500, '2019-07-21 00:00:00'),
(9, 'Rent', 2550, '2019-07-29 00:00:00'),
(12, 'salary', 5000, '2019-07-22 00:00:00'),
(13, 'travel', 5000, '2019-07-28 21:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `expensetypes`
--

CREATE TABLE `expensetypes` (
  `id` int(255) NOT NULL,
  `ExpenseType` varchar(120) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `expensetypes`
--

INSERT INTO `expensetypes` (`id`, `ExpenseType`) VALUES
(1, 'Transport'),
(2, 'salary'),
(3, 'Rent'),
(4, 'travel');

-- --------------------------------------------------------

--
-- Stand-in structure for view `monthlysales`
-- (See below for the actual view)
--
CREATE TABLE `monthlysales` (
`monthly_date` varchar(7)
,`year` int(4)
,`month_name` varchar(9)
,`sales_made` double
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `mostsellingproducts`
-- (See below for the actual view)
--
CREATE TABLE `mostsellingproducts` (
`ProductName` varchar(255)
,`Qty` decimal(51,0)
,`TotalSales` double
);

-- --------------------------------------------------------

--
-- Table structure for table `passwordrest`
--

CREATE TABLE `passwordrest` (
  `id` int(30) NOT NULL,
  `email` text NOT NULL,
  `selector` text NOT NULL,
  `token` longtext NOT NULL,
  `expires` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(250) NOT NULL,
  `ProductID` varchar(20) DEFAULT NULL,
  `ProductName` varchar(20) NOT NULL,
  `Category` varchar(80) DEFAULT NULL,
  `QuantityAvailable` int(15) NOT NULL,
  `QuantityLastAdded` int(15) DEFAULT NULL,
  `BuyingPrice` double NOT NULL,
  `SellingPrice` double NOT NULL,
  `ProfitPerUnit` double AS (SellingPrice-BuyingPrice) PERSISTENT,
  `TotalCostPrice` float AS ((QuantityAvailable*BuyingPrice)) PERSISTENT,
  `TotalProfit` float AS (QuantityAvailable*(SellingPrice-BuyingPrice)) PERSISTENT,
  `Supplier` varchar(30) DEFAULT NULL,
  `DateofEntry` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `ExpiryDate` date DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `ProductID`, `ProductName`, `Category`, `QuantityAvailable`, `QuantityLastAdded`, `BuyingPrice`, `SellingPrice`, `ProfitPerUnit`, `TotalCostPrice`, `TotalProfit`, `Supplier`, `DateofEntry`, `ExpiryDate`) VALUES
(1, 'Su', 'Sugar', 'Fast Food', 13, 9, 2900, 3600, 700, 37700, 9100, 'Code solution Tech', '2019-09-16 10:50:16', '2020-02-26'),
(2, 'Ri', 'Rice', ' Food', 12, 5, 2600, 2700, 100, 31200, 1200, 'Microsoft Company', '2019-09-16 10:50:46', '2021-01-08'),
(3, 'Sa', 'Salt', 'Fast Food', 11, 5, 5300, 5600, 300, 58300, 3300, 'Apple Co', '2019-09-13 13:50:30', '2019-10-16'),
(14, 'dec', 'decoder', 'Beverage', 16, 15, 5000, 5500, 500, 80000, 8000, 'Microsoft Company', '2019-09-16 10:23:39', '2019-06-17'),
(5, 'fa', 'fanta', 'Beverage', 15, 20, 1500, 2000, 500, 22500, 7500, 'Code solution Tech', '2019-09-12 18:20:08', '2019-06-12'),
(6, 'mi', 'milk', 'Beverage', 10, 7, 4500, 5000, 500, 45000, 5000, 'Microsoft Company', '2019-09-12 19:45:55', '2019-10-24'),
(7, 'Ce', 'Cement', 'Building materials', 18, 5, 30000, 32000, 2000, 540000, 36000, 'Microsoft Company', '2019-09-16 10:35:52', '2020-03-14'),
(8, 'Be', 'Bread', 'Fast Food', 15, 6, 5000, 5300, 300, 75000, 4500, 'Microsoft Company', '2019-09-16 08:40:19', '2020-08-21'),
(9, 'cu', 'cups', 'Beverage', 15, 36, 3000, 3200, 200, 45000, 3000, 'Samsung', '2019-09-12 20:27:24', '2019-11-15'),
(11, 'hp', 'Hewlet', 'Computer', 12, 20, 1500000, 1700000, 200000, 18000000, 2400000, 'Samsung', '2019-09-12 19:45:55', '2020-04-23'),
(12, 'cak', 'cakes', 'Fast Food', 15, 30, 9000, 9500, 500, 135000, 7500, 'Steve Apple Co', '2019-09-16 08:45:44', '2020-03-25'),
(13, 'kir', 'kiri soda', 'Beverage', 48, 8, 1200, 1400, 200, 57600, 9600, 'Code solution Tech', '2019-09-16 10:27:37', '2019-12-26'),
(28, 'bu', 'ban', 'food', 24, 32, 1500, 1700, 200, 36000, 4800, 'CST', '2019-09-12 20:01:47', '0000-00-00'),
(42, NULL, 'pens', NULL, 25, NULL, 500, 600, 100, 12500, 2500, NULL, '2019-09-13 16:06:19', NULL),
(40, NULL, '500', NULL, 0, NULL, 600, 25, -575, 0, -0, NULL, '2019-09-13 16:03:50', NULL),
(43, NULL, 'Product Name', NULL, 0, NULL, 0, 0, 0, 0, 0, NULL, '2019-09-16 08:19:42', NULL),
(39, NULL, 'Buying Price', NULL, 0, NULL, 0, 0, 0, 0, 0, NULL, '2019-09-13 16:03:50', NULL),
(37, NULL, 'iron sheets', NULL, 12, NULL, 1500, 1800, 300, 18000, 3600, NULL, '2019-07-29 09:18:42', NULL),
(38, NULL, 'bars of soap', NULL, 19, NULL, 1200, 1400, 200, 22800, 3800, NULL, '2019-09-12 17:36:38', NULL),
(45, NULL, 'Product Name', NULL, 0, NULL, 0, 0, 0, 0, 0, NULL, '2019-09-16 08:20:55', NULL),
(46, NULL, 'Flasks', '', 8, NULL, 500, 600, 100, 4000, 800, '', '2019-09-16 08:22:14', '0000-00-00');

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

CREATE TABLE `sales` (
  `billno` int(11) NOT NULL,
  `ProductID` varchar(255) NOT NULL,
  `ProductName` varchar(255) NOT NULL,
  `Quantity` int(30) NOT NULL,
  `OriginalPrice` double NOT NULL,
  `Price` double DEFAULT NULL,
  `Amount` double AS ((Quantity*Price)) PERSISTENT,
  `Discount` double NOT NULL,
  `Cost` double NOT NULL,
  `Customer` varchar(30) NOT NULL,
  `Date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `CashierName` varchar(20) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='Sales';

--
-- Dumping data for table `sales`
--

INSERT INTO `sales` (`billno`, `ProductID`, `ProductName`, `Quantity`, `OriginalPrice`, `Price`, `Amount`, `Discount`, `Cost`, `Customer`, `Date`, `CashierName`) VALUES
(6, 'Su', 'sugar', 70, 3400, 34500, 2415000, 0, 241500, 'Zedde', '2018-12-20 00:00:00', 'James'),
(74, 'Sa', 'Salt', 1, 5300, 5600, 5600, 0, 5600, 'GoodCustomer', '2019-09-09 15:12:55', 'Dallington'),
(4, 'Ce', 'cement', 10, 1400, 1500, 15000, 4, 150000, 'Lilian', '2019-05-18 00:00:00', 'Smartson'),
(64, 'Su', 'Sugar', 1, 2900, 3600, 3600, 0, 3600, 'GoodCustomer', '2019-07-28 13:53:11', 'Dallington'),
(2, 'Su', 'sugar', 10, 2200, 2300, 23000, 8, 23000, 'Fred', '2019-06-03 00:00:00', 'James'),
(3, '', 'Toshiba', 20, 14000, 15000, 300000, 15, 300000, 'Henderson', '2019-06-10 00:00:00', 'James'),
(10, 'Su', 'Sugar', 2, 3400, 3430, 6860, 2, 6860, 'john', '2019-06-13 00:00:00', 'Smartson'),
(8, 'Su', 'Sugar', 50, 3300, 3500, 175000, 0, 175000, 'Firmino', '2019-07-15 00:00:00', 'James'),
(9, 'Ri', 'rice', 2, 1100, 1225, 2450, 0, 2450, 'Dicksens', '2019-06-15 00:00:00', 'james'),
(11, 'Su', 'sugar', 1, 3300, 3450, 3450, 0, 3450, 'JK Ayekowa', '2019-08-21 00:00:00', 'James'),
(65, 'dec', 'decoder', 2, 5000, 5500, 11000, 0, 11000, 'GoodCustomer', '2019-07-28 13:53:11', 'Dallington'),
(13, 'Su', 'Sugar', 20, 2300, 2400, 48000, 0, 4800, 'GoodCustomer', '2019-04-21 00:00:00', 'Dallington'),
(14, 'Ri', 'Rice', 20, 2200, 2250, 45000, 0, 4500, 'GoodCustomer', '2019-07-21 00:00:00', 'James'),
(15, 'Sa', 'Salt', 1, 5300, 5500, 5500, 0, 5500, 'GoodCustomer', '2019-08-21 00:00:00', 'James'),
(16, 'Ri', 'Rice', 5, 2700, 2750, 13750, 5, 13750, 'GoodCustomer', '2019-06-21 00:00:00', 'James'),
(17, 'Ce', 'Cement', 2, 2400, 2500, 5000, 5, 5000, 'Suarez', '2019-06-21 00:00:00', 'James'),
(27, 'dec', 'decoder', 2, 5000, 5500, 11000, 2.5, 10725, 'GoodCustomer', '2019-06-26 09:22:42', 'Dallington'),
(29, 'Sa', 'salt', 2, 5300, 5600, 11200, 2, 10976, 'GoodCustomer', '2019-06-26 14:10:17', 'Dallington'),
(30, 'Ri', 'rice', 2, 2600, 2700, 5400, 4, 5184, 'GoodCustomer', '2019-06-26 14:10:17', 'Dallington'),
(31, 'mi', 'milk', 2, 4500, 5000, 10000, 0, 10000, 'GoodCustomer', '2019-06-26 16:39:45', 'Dallington'),
(32, 'dec', 'decoder', 3, 5000, 5500, 16500, 0, 16500, 'GoodCustomer', '2019-06-26 16:39:45', 'Dallington'),
(33, 'Ce', 'cement', 1, 30000, 32000, 32000, 0, 32000, 'GoodCustomer', '2019-06-26 16:39:45', 'Dallington'),
(34, 'Su', 'Sugar', 5, 2900, 3600, 18000, 0, 18000, 'GoodCustomer', '2019-04-26 19:33:48', 'Dallington'),
(35, 'Ri', 'rice', 4, 2600, 2700, 10800, 0, 10800, 'GoodCustomer', '2019-04-26 19:33:48', 'Dallington'),
(36, 'Su', 'Sugar', 2, 2900, 3600, 7200, 0, 7200, 'GoodCustomer', '2019-04-27 08:46:13', 'Dallington'),
(37, 'dec', 'decoder', 2, 5000, 5500, 11000, 0, 11000, 'GoodCustomer', '2019-02-27 08:46:13', 'Dallington'),
(38, 'Be', 'bread', 20, 5000, 5300, 106000, 2, 25970, 'GoodCustomer', '2019-02-27 09:17:17', ' Dallington'),
(39, 'bu', 'ban', 2, 1500, 1700, 3400, 0, 3400, 'GoodCustomer', '2019-02-27 09:21:48', ' Sarah'),
(40, 'cak', 'cakes', 2, 9000, 9500, 19000, 0, 19000, 'GoodCustomer', '2019-06-27 09:21:48', ' Sarah'),
(41, 'cu', 'cups', 3, 3000, 3200, 9600, 0, 9600, 'GoodCustomer', '2019-06-27 09:21:48', ' Sarah'),
(42, 'fa', 'fanta', 3, 1500, 2000, 6000, 0, 6000, 'GoodCustomer', '2019-06-27 09:21:48', ' Sarah'),
(43, 'fa', 'fanta', 2, 1500, 2000, 4000, 0, 4000, 'GoodCustomer', '2019-06-27 09:28:13', ' Sarah'),
(44, 'Be', 'bread', 2, 5000, 5300, 10600, 0, 10600, 'GoodCustomer', '2019-06-27 09:28:13', ' Sarah'),
(45, 'Su', 'Sugar', 2, 2900, 3600, 7200, 0, 7200, 'GoodCustomer', '2019-06-27 09:29:20', ' Sarah'),
(46, 'hp', 'Hewlet', 1, 1500000, 1700000, 1700000, 0, 1700000, 'GoodCustomer', '2019-06-27 09:34:30', ' Sarah'),
(47, 'cak', 'cakes', 2, 9000, 9500, 19000, 0, 19000, 'GoodCustomer', '2019-06-27 09:34:30', ' Sarah'),
(48, 'cu', 'cups', 3, 3000, 3200, 9600, 0, 9600, 'GoodCustomer', '2019-06-27 09:36:35', ' Sarah'),
(49, 'Su', 'Sugar', 3, 2900, 3600, 10800, 0, 10800, 'GoodCustomer', '2019-06-27 10:00:19', ' Sarah'),
(50, 'dec', 'decoder', 2, 5000, 5500, 11000, 0, 11000, 'GoodCustomer', '2019-06-27 10:02:03', ' Sarah'),
(51, 'Su', 'Sugar', 3, 2900, 3600, 10800, 0, 10800, 'GoodCustomer', '2019-06-27 10:07:12', ' Sarah'),
(52, 'Sa', 'salt', 1, 5300, 5600, 5600, 0, 5600, 'GoodCustomer', '2019-06-27 10:11:48', ' Sarah'),
(53, 'Sa', 'salt', 1, 5300, 5600, 5600, 0, 5600, 'GoodCustomer', '2019-06-27 10:16:48', ' Sarah'),
(54, 'Su', 'Sugar', 1, 2900, 3600, 3600, 0, 3600, 'GoodCustomer', '2019-06-27 10:18:40', ' Sarah'),
(55, 'Su', 'Sugar', 1, 2900, 3600, 3600, 0, 3600, 'GoodCustomer', '2019-06-27 10:23:32', ' Sarah'),
(56, 'Su', 'Sugar', 3, 2900, 3600, 10800, 0, 10800, 'GoodCustomer', '2019-06-27 18:42:31', ' Dallington'),
(57, 'cak', 'cakes', 1, 9000, 9500, 9500, 0, 9500, 'GoodCustomer', '2019-06-27 18:42:32', ' Dallington'),
(58, 'hp', 'Hewlet', 2, 1500000, 1700000, 3400000, 0, 3400000, 'GoodCustomer', '2019-06-27 18:42:32', ' Dallington'),
(59, 'Su', 'Sugar', 5, 2900, 3600, 18000, 0, 18000, 'GoodCustomer', '2019-06-28 09:29:32', ' Dallington'),
(60, 'Ri', 'Rice', 5, 2600, 2700, 13500, 0, 13500, 'GoodCustomer', '2019-06-28 09:29:32', ' Dallington'),
(61, 'fa', 'fanta', 5, 1500, 2000, 10000, 0, 10000, 'GoodCustomer', '2019-06-28 09:29:32', ' Dallington'),
(62, 'Su', 'Sugar', 5, 2900, 3600, 18000, 0, 18000, 'GoodCustomer', '2019-06-30 12:52:44', ' Dallington'),
(63, 'Su', 'Sugar', 4, 2900, 3600, 14400, 0, 14400, 'GoodCustomer', '2019-06-30 13:01:18', ' Dallington'),
(66, 'Be', 'Bread', 3, 5000, 5300, 15900, 100, 15600, 'GoodCustomer', '2019-07-28 13:56:14', 'Dallington'),
(67, 'Su', 'Sugar', 2, 2900, 3600, 7200, 0, 7200, 'GoodCustomer', '2019-07-29 12:30:14', 'Dallington'),
(68, 'dec', 'decoder', 2, 5000, 5500, 11000, 100, 10800, 'GoodCustomer', '2019-07-29 12:30:14', 'Dallington'),
(70, 'cu', 'cups', 5, 3000, 3200, 16000, 200, 15000, 'GoodCustomer', '2019-08-14 01:24:41', 'Dallington'),
(71, 'Be', 'Bread', 5, 5000, 5300, 26500, 0, 26500, 'GoodCustomer', '2019-08-14 01:24:41', 'Dallington'),
(72, 'Sa', 'Salt', 1, 5300, 5600, 5600, 0, 5600, 'GoodCustomer', '2019-08-20 19:40:23', 'Dallington'),
(73, 'cu', 'cups', 1, 3000, 3200, 3200, 8, 2944, 'GoodCustomer', '2019-08-20 19:40:23', 'Dallington'),
(75, 'Su', 'Sugar', 2, 2900, 3600, 7200, 100, 7000, 'GoodCustomer', '2019-09-09 15:12:55', 'Dallington'),
(76, 'Be', 'Bread', 2, 5000, 5300, 10600, 5, 10070, 'GoodCustomer', '2019-09-09 15:12:55', 'Dallington'),
(104, 'Be', 'Bread', 3, 5000, 5300, 15900, 100, 15600, 'GoodCustomer', '2019-09-12 22:39:18', 'Dallington'),
(103, 'Be', 'Bread', 2, 5000, 5300, 10600, 0, 10600, 'GoodCustomer', '2019-09-12 22:32:38', 'Dallington'),
(99, 'dec', 'decoder', 3, 5000, 5500, 16500, 0, 16500, 'GoodCustomer', '2019-09-12 21:26:56', 'Dallington'),
(100, 'Be', 'Bread', 1, 5000, 5300, 5300, 0, 5300, 'GoodCustomer', '2019-09-12 21:28:18', 'Dallington'),
(101, 'Sa', 'Salt', 1, 5300, 5600, 5600, 0, 5600, 'GoodCustomer', '2019-09-12 22:25:30', 'Dallington'),
(102, 'kir', 'kiri soda', 1, 1200, 1400, 1400, 0, 1400, 'GoodCustomer', '2019-09-12 22:25:30', 'Dallington'),
(115, 'Su', 'Sugar', 2, 2900, 3600, 7200, 100, 7000, 'GoodCustomer', '2019-09-16 11:32:48', 'Paul Kee'),
(114, 'Be', 'Bread', 3, 5000, 5300, 15900, 120, 15540, 'GoodCustomer', '2019-09-16 11:07:20', 'Paul Kee'),
(113, 'Be', 'Bread', 5, 5000, 5300, 26500, 500, 24000, 'GoodCustomer', '2019-09-13 16:50:30', 'Paul Kee'),
(112, 'Sa', 'Salt', 1, 5300, 5600, 5600, 0, 5600, 'GoodCustomer', '2019-09-13 16:50:30', 'Paul Kee'),
(111, 'Be', 'Bread', 5, 5000, 5300, 26500, 0, 26500, 'GoodCustomer', '2019-09-12 23:27:24', 'Dallington'),
(110, 'cu', 'cups', 3, 3000, 3200, 9600, 200, 9000, 'GoodCustomer', '2019-09-12 23:27:24', 'Dallington'),
(109, 'cu', 'cups', 2, 3000, 3200, 6400, 0, 6400, 'GoodCustomer', '2019-09-12 23:05:39', 'Dallington'),
(108, 'bu', 'ban', 1, 1500, 1700, 1700, 0, 1700, 'GoodCustomer', '2019-09-12 23:01:47', 'Dallington'),
(107, 'mi', 'milk', 2, 4500, 5000, 10000, 200, 9600, 'GoodCustomer', '2019-09-12 22:45:55', 'Dallington'),
(106, 'hp', 'Hewlet', 3, 1500000, 1700000, 5100000, 5, 4845000, 'GoodCustomer', '2019-09-12 22:45:55', 'Dallington'),
(105, 'cak', 'cakes', 2, 9000, 9500, 19000, 0, 19000, 'GoodCustomer', '2019-09-12 22:45:55', 'Dallington'),
(116, 'Be', 'Bread', 2, 5000, 5300, 10600, 0, 10600, 'GoodCustomer', '2019-09-16 11:40:19', 'Paul Kee'),
(117, 'cak', 'cakes', 2, 9000, 9500, 19000, 0, 19000, 'GoodCustomer', '2019-09-16 11:45:44', 'Paul Kee'),
(118, 'dec', 'decoder', 2, 5000, 5500, 11000, 0, 11000, 'GoodCustomer', '2019-09-16 11:50:23', 'Paul Kee'),
(119, 'Su', 'Sugar', 3, 2900, 3600, 10800, 0, 10800, 'GoodCustomer', '2019-09-16 12:01:21', 'Paul Kee'),
(120, 'dec', 'decoder', 2, 5000, 5500, 11000, 0, 11000, 'GoodCustomer', '2019-09-16 13:23:39', 'Dallington'),
(121, 'kir', 'kiri soda', 1, 1200, 1400, 1400, 0, 1400, 'GoodCustomer', '2019-09-16 13:27:37', 'Dallington'),
(122, 'Ce', 'Cement', 2, 30000, 32000, 64000, 0, 64000, 'GoodCustomer', '2019-09-16 13:35:52', 'Dallington'),
(123, 'Su', 'Sugar', 2, 2900, 3600, 7200, 200, 6800, 'GoodCustomer', '2019-09-16 13:50:16', 'Dallington'),
(124, 'Ri', 'Rice', 3, 2600, 2700, 8100, 0, 8100, 'GoodCustomer', '2019-09-16 13:50:46', 'Dallington');

-- --------------------------------------------------------

--
-- Table structure for table `suppliers`
--

CREATE TABLE `suppliers` (
  `id` int(255) NOT NULL,
  `SupplierName` varchar(100) NOT NULL,
  `Address` varchar(100) NOT NULL,
  `Contact` varchar(15) NOT NULL,
  `Email` varchar(200) NOT NULL,
  `DR` double NOT NULL,
  `CR` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `suppliers`
--

INSERT INTO `suppliers` (`id`, `SupplierName`, `Address`, `Contact`, `Email`, `DR`, `CR`) VALUES
(1, 'Steve Apple Co', 'U.S.A', '+22477401475', 'stevieappco@gmail.com', 35000, 7000),
(2, 'Microsoft Company', 'California U.S.A', '+22470047742', 'microsoftco@gmail.com', 500, 20000),
(3, 'Code solution Tech', 'Mbarara', '+256774014729', 'codesolution@gmail.com', 4200, 67000),
(4, 'Kakira Sugar Estates', 'Kampala', '+256774014730', 'kakirasugars@gmail.com', 0, 95420752000),
(5, 'Samsung', 'U.S.A', '+25677341400', 'samsung@gmail.com', 300, 900),
(6, 'CocaCola', 'Kampala', '+256778014720', '', 35950000, 0),
(7, 'Dangote Co', 'Nigeria', '+224791886279', '', 0, 0),
(10, 'Balya Cement Manufacturers', 'Mbarara', '+256774014754', '', 0, 0),
(11, 'Dstv', 'South Africa', '+256774014755', '', 0, 0),
(12, 'Enock Limited', 'Kampala', '+256774014721', '', 0, 0),
(13, 'MTN', 'Kampala', '+256774014712', '', 0, 0),
(14, 'Bill Gates', 'U.S.A', '+256774014712', '', 500, 100);

-- --------------------------------------------------------

--
-- Stand-in structure for view ``monthlysales``
-- (See below for the actual view)
--
CREATE TABLE ```monthlysales``` (
`monthly_date` varchar(7)
,`year` int(4)
,`month_name` varchar(9)
,`sales_made` double
);

-- --------------------------------------------------------

--
-- Structure for view `bestcustomers`
--
DROP TABLE IF EXISTS `bestcustomers`;

CREATE ALGORITHM=UNDEFINED DEFINER=`Dallington`@`localhost` SQL SECURITY DEFINER VIEW `bestcustomers`  AS  select `sales`.`Customer` AS `Customer`,sum(`sales`.`Cost`) AS `VolumeofSales`,round(((sum(`sales`.`Cost`) * 100) / (select sum(`monthlysales`.`sales_made`) from `monthlysales`)),2) AS `percent` from `sales` group by `sales`.`Customer` order by sum(`sales`.`Cost`) desc limit 10 ;

-- --------------------------------------------------------

--
-- Structure for view `cashiersperformance`
--
DROP TABLE IF EXISTS `cashiersperformance`;

CREATE ALGORITHM=UNDEFINED DEFINER=`Dallington`@`localhost` SQL SECURITY DEFINER VIEW `cashiersperformance`  AS  select `sales`.`CashierName` AS `Cashier`,sum(`sales`.`Cost`) AS `VolumeofConductedSales`,round(((sum(`sales`.`Cost`) * 100) / (select sum(`monthlysales`.`sales_made`) from `monthlysales`)),2) AS `percent` from `sales` group by `sales`.`CashierName` order by sum(`sales`.`Cost`) desc ;

-- --------------------------------------------------------

--
-- Structure for view `monthlysales`
--
DROP TABLE IF EXISTS `monthlysales`;

CREATE ALGORITHM=UNDEFINED DEFINER=`Dallington`@`localhost` SQL SECURITY DEFINER VIEW `monthlysales`  AS  select date_format(`sales`.`Date`,'%m-%Y') AS `monthly_date`,year(`sales`.`Date`) AS `year`,monthname(`sales`.`Date`) AS `month_name`,sum(`sales`.`Amount`) AS `sales_made` from `sales` group by date_format(`sales`.`Date`,'%m-%Y') ;

-- --------------------------------------------------------

--
-- Structure for view `mostsellingproducts`
--
DROP TABLE IF EXISTS `mostsellingproducts`;

CREATE ALGORITHM=UNDEFINED DEFINER=`Dallington`@`localhost` SQL SECURITY DEFINER VIEW `mostsellingproducts`  AS  select `sales`.`ProductName` AS `ProductName`,sum(`sales`.`Quantity`) AS `Qty`,sum(`sales`.`Cost`) AS `TotalSales` from `sales` group by `sales`.`ProductName` order by sum(`sales`.`Cost`) desc limit 10 ;

-- --------------------------------------------------------

--
-- Structure for view ``monthlysales``
--
DROP TABLE IF EXISTS ```monthlysales```;

CREATE ALGORITHM=UNDEFINED DEFINER=`Dallington`@`localhost` SQL SECURITY DEFINER VIEW ```monthlysales```  AS  select date_format(`sales`.`Date`,'%m-%Y') AS `monthly_date`,year(`sales`.`Date`) AS `year`,monthname(`sales`.`Date`) AS `month_name`,sum(`sales`.`Amount`) AS `sales_made` from `sales` group by date_format(`sales`.`Date`,'%m-%Y') ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `administrators`
--
ALTER TABLE `administrators`
  ADD PRIMARY KEY (`password`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`ItemId`);

--
-- Indexes for table `cashiers`
--
ALTER TABLE `cashiers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`),
  ADD KEY `Category` (`Category`),
  ADD KEY `Category_2` (`Category`),
  ADD KEY `Category_3` (`Category`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `damages`
--
ALTER TABLE `damages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `expenses`
--
ALTER TABLE `expenses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `expensetypes`
--
ALTER TABLE `expensetypes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `passwordrest`
--
ALTER TABLE `passwordrest`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `Category` (`Category`),
  ADD KEY `BuyingPrice` (`BuyingPrice`);

--
-- Indexes for table `sales`
--
ALTER TABLE `sales`
  ADD PRIMARY KEY (`billno`),
  ADD KEY `OriginalPrice` (`OriginalPrice`,`Price`);

--
-- Indexes for table `suppliers`
--
ALTER TABLE `suppliers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `SupplierName` (`SupplierName`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `ItemId` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cashiers`
--
ALTER TABLE `cashiers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int(250) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `damages`
--
ALTER TABLE `damages`
  MODIFY `id` int(250) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `expenses`
--
ALTER TABLE `expenses`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `expensetypes`
--
ALTER TABLE `expensetypes`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `passwordrest`
--
ALTER TABLE `passwordrest`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(250) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `sales`
--
ALTER TABLE `sales`
  MODIFY `billno` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=125;

--
-- AUTO_INCREMENT for table `suppliers`
--
ALTER TABLE `suppliers`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
