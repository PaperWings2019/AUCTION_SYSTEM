-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- 主机： 127.0.0.1:3306
-- 生成日期： 2022-11-15 17:15:33
-- 服务器版本： 8.0.26
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
  `itemID` int NOT NULL AUTO_INCREMENT,
  `itemName` varchar(50) DEFAULT NULL,
  `itemDescription` varchar(200) DEFAULT NULL,
  `category` varchar(30) DEFAULT NULL,
  `startingPrice` int DEFAULT NULL,
  `reservePrice` int DEFAULT NULL,
  `endDate` varchar(20) DEFAULT NULL,
  `sellerID` int DEFAULT NULL,
  `highestBid` int DEFAULT NULL,
  `auctionStatus` int DEFAULT NULL,
  `buyerID` int DEFAULT NULL,
  PRIMARY KEY (`itemID`),
  KEY `fk_userid_1` (`sellerID`),
  KEY `fk_userid_2` (`buyerID`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8mb3;

--
-- 转存表中的数据 `auctions`
--

INSERT INTO `auctions` (`itemID`, `itemName`, `itemDescription`, `category`, `startingPrice`, `reservePrice`, `endDate`, `sellerID`, `highestBid`, `auctionStatus`, `buyerID`) VALUES
(18, 'AJ1', 'Fancy shoes', '3', 100, 200, '2022-11-10 12:44:00', 2, 138, 0, 5),
(19, 'Toy car', 'toy car', '6', 10, 10, '2022-11-09 12:44:00', 3, 12, 0, 1),
(20, 'iPhone3', 'old phone', '6', 50, 50, '2022-11-09 12:44:00', 3, 50, 0, NULL),
(21, 'G305', 'mouse', '5', 25, 28, '2022-11-17 15:57:00', 2, 25, 1, NULL),
(24, 'G102', '1', '1', 1, 2, '2022-11-27 16:12:00', 2, 125, 1, 6),
(25, 'CRAZYFRIDAY', 'VME50', '7', 50, 99, '2022-11-11 18:10:00', 7, 50, 0, NULL),
(26, 'CRAZYFRIDAY', '', '7', 50, 100, '2022-11-11 18:19:00', 7, 52, 0, 6),
(27, 'CRAZYFRIDAY', '****', '7', 100, 200, '2022-11-15 14:00:00', 7, 100, 0, NULL),
(28, 'TESTTEST', 'test', '7', 100, 199, '2022-11-15 14:07:00', 7, 100, 0, NULL),
(29, 'TESTTEST2', 'TESTTEST2', '7', 100, 200, '2022-11-15 14:09:00', 7, 100, 0, NULL),
(30, 'TESTTEST23', 'TESTTEST23', '7', 100, 200, '2022-11-16 14:49:00', 7, 2000, 1, 6),
(32, 'TESTTEST234', 'TESTTEST234', '7', 100, 1998, '2022-11-15 17:11:00', 7, 100, 0, NULL);

-- --------------------------------------------------------

--
-- 表的结构 `bidhistory`
--

DROP TABLE IF EXISTS `bidhistory`;
CREATE TABLE IF NOT EXISTS `bidhistory` (
  `bidID` int NOT NULL,
  `buyerID` int DEFAULT NULL,
  `itemID` int DEFAULT NULL,
  `bidPrice` int DEFAULT NULL,
  `bidTime` time DEFAULT NULL,
  PRIMARY KEY (`bidID`),
  KEY `fk_userid` (`buyerID`),
  KEY `fk_itemid` (`itemID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- 转存表中的数据 `bidhistory`
--

INSERT INTO `bidhistory` (`bidID`, `buyerID`, `itemID`, `bidPrice`, `bidTime`) VALUES
(1, 1, 19, 11, '22:08:30'),
(2, 1, 19, 12, '22:20:25'),
(3, 1, 18, 134, '15:55:19'),
(4, 1, 18, 135, '15:55:24'),
(5, 1, 18, 136, '15:55:35'),
(6, 5, 18, 138, '16:17:21'),
(7, 6, 24, 123, '17:21:39'),
(8, 6, 24, 124, '17:24:00'),
(9, 6, 26, 52, '20:49:25'),
(10, 6, 30, 2000, '14:50:28'),
(11, 6, 24, 125, '14:50:45');

-- --------------------------------------------------------

--
-- 表的结构 `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `userID` int NOT NULL AUTO_INCREMENT,
  `password` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `email` varchar(30) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `accountType` int NOT NULL,
  PRIMARY KEY (`userID`),
  UNIQUE KEY `Email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb3;

--
-- 转存表中的数据 `user`
--

INSERT INTO `user` (`userID`, `password`, `email`, `accountType`) VALUES
(1, 'e44daa2696689a3ec249cf684bc0670c6935d1bb', '1823963114@qq.com', 0),
(2, 'e44daa2696689a3ec249cf684bc0670c6935d1bb', 'chengkai.dai.22@ucl.ac.uk', 1),
(3, '719317d0722c7f5122475de7b17246795e74e3c9', '1427578193@qq.com', 1),
(4, '719317d0722c7f5122475de7b17246795e74e3c9', 'muyaoli123@gmail.com', 0),
(5, 'afc677037be3d92324fa6597d6c1506b534e306b', '12345@12.co', 0),
(6, 'b58964f12f18a4361d77374cc03e44a14fa4c8b6', '627060692@qq.com', 0),
(7, '493918ba81eacbf9a345a52504601cda06c0bc7a', '627060693@qq.com', 1);

-- --------------------------------------------------------

--
-- 表的结构 `watchlist`
--

DROP TABLE IF EXISTS `watchlist`;
CREATE TABLE IF NOT EXISTS `watchlist` (
  `watchlistID` int NOT NULL AUTO_INCREMENT,
  `itemID` int NOT NULL,
  `userID` int NOT NULL,
  PRIMARY KEY (`watchlistID`),
  KEY `fk_userid_w` (`userID`),
  KEY `fk_itemid_w` (`itemID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- 限制导出的表
--

--
-- 限制表 `auctions`
--
ALTER TABLE `auctions`
  ADD CONSTRAINT `fk_userid_1` FOREIGN KEY (`sellerID`) REFERENCES `user` (`userID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_userid_2` FOREIGN KEY (`buyerID`) REFERENCES `user` (`userID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- 限制表 `bidhistory`
--
ALTER TABLE `bidhistory`
  ADD CONSTRAINT `fk_itemid` FOREIGN KEY (`itemID`) REFERENCES `auctions` (`itemID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_userid` FOREIGN KEY (`buyerID`) REFERENCES `user` (`userID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- 限制表 `watchlist`
--
ALTER TABLE `watchlist`
  ADD CONSTRAINT `fk_itemid_w` FOREIGN KEY (`itemID`) REFERENCES `auctions` (`itemID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_userid_w` FOREIGN KEY (`userID`) REFERENCES `user` (`userID`) ON DELETE CASCADE ON UPDATE CASCADE;

DELIMITER $$
--
-- 事件
--
DROP EVENT IF EXISTS `set_status_when_expired`$$
CREATE DEFINER=`root`@`localhost` EVENT `set_status_when_expired` ON SCHEDULE EVERY 1 SECOND STARTS '2022-11-15 16:44:20' ENDS '2031-11-01 16:44:20' ON COMPLETION PRESERVE ENABLE DO UPDATE auctions a
SET a.auctionStatus = 0
WHERE TIMESTAMPDIFF(SECOND, a.endDate, CURRENT_TIMESTAMP()) >= 0$$

DELIMITER ;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
