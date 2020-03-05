-- phpMyAdmin SQL Dump
-- version 4.8.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 02, 2019 at 08:25 PM
-- Server version: 10.1.34-MariaDB
-- PHP Version: 7.2.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `easyinventory`
--

-- --------------------------------------------------------

--
-- Table structure for table `administrators`
--

CREATE TABLE `administrators` (
  `Username` varchar(20) NOT NULL,
  `password` char(15) NOT NULL,
  `Email` varchar(240) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `administrators`
--

INSERT INTO `administrators` (`Username`, `password`, `Email`) VALUES
('Dallington', '2020', 'asingwire50dallington@gmail.com'),
('Nelson', '6767', ''),
('Wilson', '7788', ''),
('Rodgers', '5566', '');

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
-- Table structure for table `cashiers`
--

CREATE TABLE `cashiers` (
  `id` int(11) NOT NULL,
  `CashierName` varchar(20) NOT NULL,
  `MobileNo` varchar(17) NOT NULL,
  `Address` varchar(20) NOT NULL,
  `Email` varchar(50) DEFAULT NULL,
  `Password` varchar(15) NOT NULL,
  `Image` longblob
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cashiers`
--

INSERT INTO `cashiers` (`id`, `CashierName`, `MobileNo`, `Address`, `Email`, `Password`, `Image`) VALUES
(1, 'Dallington', '0774014728', 'Mbarara', 'dallingtonasin100@gmail.com', '9090', NULL),
(2, 'Moses Mugisha', '07005782139', 'Kitugumu', 'mugishamoses200@gmail.com', '$2y$10$ndzqlNLN', NULL),
(3, 'james Aine', '07005782175', 'Mbarara', 'ainejames90@gmail.com', '$2y$10$dzdmWl11', NULL),
(4, 'Annet Ninsiima', '0772833275', 'Kasese', 'annetnisiima@gmail.com', '$2y$10$fdX.VXwm', NULL),
(7, 'Terry John', '0774014756', 'Liverpool', '', '$2y$10$hb9J9jR3', NULL),
(8, 'Sarah', '0708877426', 'Mukono', NULL, '4545', NULL),
(10, 'Isaac Mujuni', '0774014628', 'Isingiro', '', '$2y$10$DGIXQKf1', NULL),
(11, 'Kemigisha Usher', '0774014432', 'Koboko', '', '$2y$10$dr2U3NiG', NULL),
(12, 'Jeff Lee', '+25677552277', 'China', 'getleejeff@gmail.com', '$2y$10$O3nenHPT', NULL),
(15, 'Mane VVD', '0774014722', 'Liverpool', '', '$2y$10$G2PTBeq0', NULL),
(14, 'jimmy Okim', '+25677552211', 'Kasese', 'jimmyokim@gmail.com', '$2y$10$hCjAPmb3', NULL);

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
(7, 'Utensils');

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
(1, 'Peterson Ainomugisha', '+2247893030319', 5500, 500),
(2, 'Alison Becker', '+256774014672', 1000, 5500),
(3, 'Henderson', '+2567772712442', 800, 9000),
(4, 'Mugisha Peter', '+256792712763', 0, 0),
(5, 'John Nasasira', '+2567772712672', 0, 0),
(6, 'Mercy k', '0789358972', 0, 0),
(7, 'Fred kk', '+2567772712442', 0, 0),
(8, 'Angella', '+25677727186', 0, 0);

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
(2, 'fa', 'fanta', 'Beverage', 8),
(7, 'su', 'sugar', 'Beverage', 5),
(9, 'ri', 'rice', 'Beverage', 8),
(10, 'sa', 'salt', 'Fast food', 6),
(12, 'mi', 'milk', 'Beverage', 8),
(13, 'ce', 'cement', 'Building materials', 4),
(14, 'ri', 'rice', 'Fast food', 2),
(15, 'de', 'decoder', 'Beverage', 8);

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
  `ProductID` varchar(20) NOT NULL,
  `ProductName` varchar(20) NOT NULL,
  `Category` varchar(80) NOT NULL,
  `QuantityAvailable` int(15) NOT NULL,
  `QuantityLastAdded` int(15) NOT NULL,
  `BuyingPrice` double NOT NULL,
  `SellingPrice` double NOT NULL,
  `Supplier` varchar(30) NOT NULL,
  `DateofEntry` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `ExpiryDate` date NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `ProductID`, `ProductName`, `Category`, `QuantityAvailable`, `QuantityLastAdded`, `BuyingPrice`, `SellingPrice`, `Supplier`, `DateofEntry`, `ExpiryDate`) VALUES
(1, 'Su', 'Sugar', 'Fast Food', 21, 9, 2900, 3600, 'Code solution Tech', '2019-06-30 10:01:18', '2020-02-26'),
(2, 'Ri', 'Rice', ' Food', 5, 5, 2600, 2700, 'Microsoft Company', '2019-06-28 06:29:32', '2021-01-08'),
(3, 'Sa', 'Salt', 'Fast Food', 6, 5, 5300, 5600, 'Apple Co', '2019-06-27 07:16:48', '2019-10-16'),
(14, 'dec', 'decoder', 'Beverage', 7, 15, 5000, 5500, 'Microsoft Company', '2019-06-30 09:52:10', '2019-06-17'),
(5, 'fa', 'fanta', 'Beverage', 10, 20, 1500, 2000, 'Code solution Tech', '2019-06-28 06:29:32', '2019-06-12'),
(6, 'mi', 'milk', 'Beverage', 3, 7, 4500, 5000, 'Microsoft Company', '2019-06-26 13:39:45', '2019-10-24'),
(7, 'Ce', 'Cement', 'Building materials', 2, 5, 30000, 32000, 'Microsoft Company', '2019-06-26 13:39:45', '2020-03-14'),
(8, 'Be', 'Bread', 'Fast Food', 58, 6, 5000, 5300, 'Microsoft Company', '2019-06-27 06:28:13', '2020-08-21'),
(9, 'cu', 'cups', 'Beverage', 30, 36, 3000, 3200, 'Samsung', '2019-06-27 06:36:35', '2019-11-15'),
(11, 'hp', 'Hewlet', 'Computer', 17, 20, 1500000, 1700000, 'Samsung', '2019-06-27 15:42:32', '2020-04-23'),
(12, 'cak', 'cakes', 'Fast Food', 25, 30, 9000, 9500, 'Steve Apple Co', '2019-06-27 15:42:32', '2020-03-25'),
(13, 'kir', 'kiri soda', 'Beverage', 8, 8, 1200, 1400, 'Code solution Tech', '2019-06-15 15:48:07', '2019-12-26'),
(28, 'bu', 'ban', 'food', 30, 32, 1500, 1700, 'CST', '2019-06-27 06:21:48', '0000-00-00'),
(27, 'do', 'donught', 'food', 32, 32, 1500, 1700, 'CST', '2019-06-05 21:00:00', '2020-06-05');

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
(6, 'Su', 'sugar', 7, 3400, 34500, 241500, 0, 241500, 'Zedde', '2018-12-20 00:00:00', 'James'),
(7, '', 'Dell', 10, 5200, 5225, 52250, 5, 52250, 'Moses', '2019-03-01 00:00:00', 'James'),
(4, 'Ce', 'cement', 100, 1400, 1500, 150000, 4, 150000, 'Lilian', '2019-05-18 00:00:00', 'Smartson'),
(5, 'Sa', 'Salt', 3, 2300, 2500, 7500, 4, 7500, 'Henry', '2019-05-19 00:00:00', 'Timothy'),
(2, 'Su', 'sugar', 10, 2200, 2300, 23000, 8, 23000, 'Fred', '2019-06-03 00:00:00', 'James'),
(3, '', 'Toshiba', 20, 14000, 15000, 300000, 15, 300000, 'Henderson', '2019-06-10 00:00:00', 'James'),
(10, 'Su', 'Sugar', 2, 3400, 3430, 6860, 2, 6860, 'john', '2019-06-13 00:00:00', 'Smartson'),
(8, 'Su', 'Sugar', 50, 3300, 3500, 175000, 0, 175000, 'Firmino', '2019-06-15 00:00:00', 'James'),
(9, 'Ri', 'rice', 2, 1100, 1225, 2450, 0, 2450, 'Dicksens', '2019-06-15 00:00:00', 'james'),
(11, 'Su', 'sugar', 1, 3300, 3450, 3450, 0, 3450, 'JK Ayekowa', '2019-06-21 00:00:00', 'James'),
(12, 'Sa', 'Salt', 5, 1200, 1300, 6500, 1, 6500, 'Alex', '2019-06-21 00:00:00', 'Jane'),
(13, 'Su', 'Sugar', 2, 2300, 2400, 4800, 0, 4800, 'GoodCustomer', '2019-06-21 00:00:00', 'Dallington'),
(14, 'Ri', 'Rice', 2, 2200, 2250, 4500, 0, 4500, 'GoodCustomer', '2019-06-21 00:00:00', 'James'),
(15, 'Sa', 'Salt', 1, 5300, 5500, 5500, 0, 5500, 'GoodCustomer', '2019-06-21 00:00:00', 'James'),
(16, 'Ri', 'Rice', 5, 2700, 2750, 13750, 5, 13750, 'GoodCustomer', '2019-06-21 00:00:00', 'James'),
(17, 'Ce', 'Cement', 2, 2400, 2500, 5000, 5, 5000, 'Suarez', '2019-06-21 00:00:00', 'James'),
(27, 'dec', 'decoder', 2, 5000, 5500, 11000, 2.5, 10725, 'GoodCustomer', '2019-06-26 09:22:42', 'Dallington'),
(29, 'Sa', 'salt', 2, 5300, 5600, 11200, 2, 10976, 'GoodCustomer', '2019-06-26 14:10:17', 'Dallington'),
(30, 'Ri', 'rice', 2, 2600, 2700, 5400, 4, 5184, 'GoodCustomer', '2019-06-26 14:10:17', 'Dallington'),
(31, 'mi', 'milk', 2, 4500, 5000, 10000, 0, 10000, 'GoodCustomer', '2019-06-26 16:39:45', 'Dallington'),
(32, 'dec', 'decoder', 3, 5000, 5500, 16500, 0, 16500, 'GoodCustomer', '2019-06-26 16:39:45', 'Dallington'),
(33, 'Ce', 'cement', 1, 30000, 32000, 32000, 0, 32000, 'GoodCustomer', '2019-06-26 16:39:45', 'Dallington'),
(34, 'Su', 'Sugar', 5, 2900, 3600, 18000, 0, 18000, 'GoodCustomer', '2019-06-26 19:33:48', 'Dallington'),
(35, 'Ri', 'rice', 4, 2600, 2700, 10800, 0, 10800, 'GoodCustomer', '2019-06-26 19:33:48', 'Dallington'),
(36, 'Su', 'Sugar', 2, 2900, 3600, 7200, 0, 7200, 'GoodCustomer', '2019-06-27 08:46:13', 'Dallington'),
(37, 'dec', 'decoder', 2, 5000, 5500, 11000, 0, 11000, 'GoodCustomer', '2019-06-27 08:46:13', 'Dallington'),
(38, 'Be', 'bread', 5, 5000, 5300, 26500, 2, 25970, 'GoodCustomer', '2019-06-27 09:17:17', ' Dallington'),
(39, 'bu', 'ban', 2, 1500, 1700, 3400, 0, 3400, 'GoodCustomer', '2019-06-27 09:21:48', ' Sarah'),
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
(63, 'Su', 'Sugar', 4, 2900, 3600, 14400, 0, 14400, 'GoodCustomer', '2019-06-30 13:01:18', ' Dallington');

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
(4, 'Kakira Sugar Estates', 'Kampala', '+256774014730', 'kakirasugars@gmail.com', 0, 0),
(5, 'Samsung', 'U.S.A', '+25677341400', 'samsung@gmail.com', 300, 900),
(6, 'CocaCola', 'Kampala', '+256778014720', '', 0, 0),
(7, 'Dangote Co', 'Nigeria', '+224791886279', '', 0, 0),
(9, 'Dangote Co', 'Nigeria', '+224791886279', '', 0, 0),
(10, 'Balya Cement Manufacturers', 'Mbarara', '+256774014754', '', 0, 0),
(11, 'Dstv', 'South Africa', '+256774014755', '', 0, 0),
(12, 'Enock Limited', 'Kampala', '+256774014721', '', 0, 0),
(13, 'MTN', 'Kampala', '+256774014712', '', 0, 0);

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

CREATE ALGORITHM=UNDEFINED DEFINER=`Dallington`@`localhost` SQL SECURITY DEFINER VIEW `mostsellingproducts`  AS  select `sales`.`ProductName` AS `ProductName`,sum(`sales`.`Cost`) AS `TotalSales` from `sales` group by `sales`.`ProductName` order by sum(`sales`.`Cost`) desc limit 10 ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `administrators`
--
ALTER TABLE `administrators`
  ADD PRIMARY KEY (`password`);

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
  ADD PRIMARY KEY (`id`),
  ADD KEY `Category` (`Category`);

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
-- AUTO_INCREMENT for table `cashiers`
--
ALTER TABLE `cashiers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int(250) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `damages`
--
ALTER TABLE `damages`
  MODIFY `id` int(250) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `passwordrest`
--
ALTER TABLE `passwordrest`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(250) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `sales`
--
ALTER TABLE `sales`
  MODIFY `billno` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT for table `suppliers`
--
ALTER TABLE `suppliers`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `damages`
--
ALTER TABLE `damages`
  ADD CONSTRAINT `damages_ibfk_1` FOREIGN KEY (`Category`) REFERENCES `category` (`Category`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
