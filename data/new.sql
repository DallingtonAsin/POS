SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";



/*CREATE TABLE `sales` (
  `billno` int(11) NOT NULL,
  `ProductID` varchar(255) NOT NULL,
  `ProductName` varchar(255) NOT NULL,
  `Quantity` int(30) NOT NULL,
  `OriginalPrice` double NOT NULL,
  `Price` double DEFAULT NULL,
  `Amount` double GENERATED ALWAYS AS (`Quantity` * `Price`) STORED,
  `Discount` double NOT NULL,
  `Cost` double NOT NULL,
  `Customer` varchar(30) NOT NULL,
  `Date` datetime NOT NULL DEFAULT current_timestamp(),
  `CashierName` varchar(20) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='Sales';*/


CREATE TABLE `products` (
  `id` int(250) NOT NULL,
  `ProductID` varchar(20) DEFAULT NULL,
  `ProductName` varchar(20) NOT NULL,
  `Category` varchar(80) DEFAULT NULL,
  `QuantityAvailable` int(15) NOT NULL,
  `QuantityLastAdded` int(15) DEFAULT NULL,
  `BuyingPrice` double NOT NULL,
  `SellingPrice` double NOT NULL,
  `ProfitPerUnit` double,
  `TotalCostPrice`,
  `TotalProfit` double,
  `Supplier` varchar(30) DEFAULT NULL,
  `DateofEntry` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `ExpiryDate` date DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

