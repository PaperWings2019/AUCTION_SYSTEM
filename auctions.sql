-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- 主机： 127.0.0.1:3306
-- 生成日期： 2022-11-09 16:07:51
-- 服务器版本： 5.7.36
-- PHP 版本： 7.4.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 数据库： `auction_system`
--

-- --------------------------------------------------------

--
-- 表的结构 `auctions`
--

DROP TABLE IF EXISTS `auctions`;
CREATE TABLE IF NOT EXISTS `auctions` (
  `itemID` int(11) NOT NULL AUTO_INCREMENT,
  `itemName` varchar(50) DEFAULT NULL,
  `itemDescription` varchar(200) DEFAULT NULL,
  `category` varchar(30) DEFAULT NULL,
  `startingPrice` int(11) DEFAULT NULL,
  `reservePrice` int(11) DEFAULT NULL,
  `endDate` varchar(20) DEFAULT NULL,
  `sellerID` int(11) DEFAULT NULL,
  `highestBid` int(11) DEFAULT NULL,
  `auctionStatus` int(11) DEFAULT NULL,
  `buyerID` int(30) DEFAULT NULL,
  PRIMARY KEY (`itemID`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `auctions`
--

INSERT INTO `auctions` (`itemID`, `itemName`, `itemDescription`, `category`, `startingPrice`, `reservePrice`, `endDate`, `sellerID`, `highestBid`, `auctionStatus`, `buyerID`) VALUES
(18, 'AJ1', 'Fancy shoes', '3', 100, 200, '2022-11-10T12:44', 2, 136, NULL, 1),
(19, 'Toy car', 'toy car', '6', 10, 10, '2022-11-09T12:44', 3, 12, NULL, 1),
(20, 'iPhone3', 'old phone', '6', 50, 50, '2022-11-09T12:44', 3, 50, NULL, NULL),
(21, 'G305', 'mouse', '5', 25, 28, '2022-11-17T15:57', 2, 25, NULL, NULL);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
