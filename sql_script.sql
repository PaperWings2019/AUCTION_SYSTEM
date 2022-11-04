DROP DATABASE auction_system;

CREATE DATABASE auction_system
  DEFAULT CHARACTER SET utf8
  DEFAULT COLLATE utf8_general_ci;
  
DROP USER 'auctionadmin'@'localhost';
FLUSH PRIVILEGES;
  
CREATE USER 'auctionadmin'@'localhost'
	IDENTIFIED BY 'adminpassword';

GRANT SELECT, UPDATE, INSERT, DELETE
    ON auction_system.*
    TO 'auctionadmin'@'localhost';

USE auction_system;

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `password` varchar(100) COLLATE utf8_bin NOT NULL,
  `email` varchar(30) COLLATE utf8_bin NOT NULL,
  `account_type` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `Email` (`email`)
);

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
  PRIMARY KEY (`itemID`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb3;

--
-- 插入 `auctions` 测试数据集
--

INSERT INTO `auctions` (`itemID`, `itemName`, `itemDescription`, `category`, `startingPrice`, `reservePrice`, `endDate`, `sellerID`, `highestBid`, `auctionStatus`) VALUES
(1, 'qw', 'qwe', 'hello', 1, 2, '2000-01-02', NULL, 1, 0),
(6, 'jntm', 'xiaoheizi', 'CXK', 1, 2, '2023-01-02', NULL, 2, 0),
(7, 'yydz', 'jiandingwei', 'dz', 1, 2, '2023-01-02', NULL, 3, 0),
(8, 'jntm', 'xiaoheizi', 'CXK', 1, 2, '2023-01-02', NULL, 4, 0),
(9, 'test', 'qwe', 'hello', 1, 2, '2000-01-02', NULL, 5, 0),
(10, 'jntm', 'xiaoheizi', 'CXK', 1, 2, '2023-01-02', NULL, 2, 0),
(11, 'test', 'qwe', 'hello', 1, 2, '2000-01-02', NULL, 5, 0),
(12, 'qw', 'qwe', 'hello', 1, 2, '2000-01-02', NULL, 1, 0),
(13, 'qw', 'qwe', 'hello', 1, 2, '2000-01-02', NULL, 1, 0),
(14, 'jntm', 'xiaoheizi', 'CXK', 1, 2, '2023-01-02', NULL, 2, 0),
(15, 'jntm', 'xiaoheizi', 'CXK', 1, 2, '2023-01-02', NULL, 4, 0),
(16, 'jntm', 'xiaoheizi', 'CXK', 1, 2, '2023-01-02', NULL, 2, 0),
(17, 'yydz', 'jiandingwei', 'dz', 1, 2, '2023-01-02', NULL, 3, 0);
COMMIT;

CREATE TABLE BidHistory
(
  buyerID INTEGER,
  itemID INTEGER,
  bidPrice INTEGER,
  bidTime TIME

);
