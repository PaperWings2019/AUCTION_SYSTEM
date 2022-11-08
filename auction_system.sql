-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- 主机： 127.0.0.1:3306
-- 生成日期： 2022-11-07 14:29:03
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
  `buyerID` int(30),
  PRIMARY KEY (`itemID`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `auctions`
--

INSERT INTO `auctions` (`itemID`, `itemName`, `itemDescription`, `category`, `startingPrice`, `reservePrice`, `endDate`, `sellerID`, `highestBid`, `auctionStatus`, `buyerID`) VALUES
(18, 'AJ1', 'Fancy shoes', '3', 100, 200, '2022-11-09T12:44', 2, 133, NULL, 1);


-- --------------------------------------------------------

--
-- 表的结构 `bidhistory`
--

DROP TABLE IF EXISTS `bidhistory`;
CREATE TABLE IF NOT EXISTS `bidhistory` (
  `bidID` int(30) NOT NULL,
  `buyerID` int(11) DEFAULT NULL,
  `itemID` int(11) DEFAULT NULL,
  `bidPrice` int(11) DEFAULT NULL,
  `bidTime` time DEFAULT NULL,
  PRIMARY KEY (`bidID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `password` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `email` varchar(30) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `account_type` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `Email` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `user`
--

INSERT INTO `user` (`id`, `password`, `email`, `account_type`) VALUES
(4, '719317d0722c7f5122475de7b17246795e74e3c9', 'muyaoli123@gmail.com', 0),
(3, '719317d0722c7f5122475de7b17246795e74e3c9', '1427578193@qq.com', 1),
(2, 'e44daa2696689a3ec249cf684bc0670c6935d1bb', 'chengkai.dai.22@ucl.ac.uk', 1),
(1, 'e44daa2696689a3ec249cf684bc0670c6935d1bb', '1823963114@qq.com', 0);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
