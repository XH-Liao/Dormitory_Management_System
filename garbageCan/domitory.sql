-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- 主機： 127.0.0.1
-- 產生時間： 2022-12-19 15:15:09
-- 伺服器版本： 10.4.24-MariaDB
-- PHP 版本： 8.0.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 資料庫： `domitory`
--

-- --------------------------------------------------------

--
-- 資料表結構 `入住申請`
--

CREATE TABLE `入住申請` (
  `申請日期` date NOT NULL DEFAULT current_timestamp(),
  `核可狀態` tinyint(1) NOT NULL,
  `繳費狀態` tinyint(1) NOT NULL,
  `學年度` int(11) NOT NULL,
  `學期` int(11) NOT NULL,
  `申請編號` int(11) NOT NULL,
  `學號` char(8) NOT NULL,
  `Account` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- 資料表結構 `學生`
--

CREATE TABLE `學生` (
  `學號` char(8) NOT NULL,
  `姓名` varchar(50) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `連絡電話` varchar(10) NOT NULL,
  `性別` char(1) NOT NULL,
  `生日` date NOT NULL,
  `密碼` varchar(100) NOT NULL,
  `房間號碼` int(11) DEFAULT NULL,
  `宿舍編號` char(2) DEFAULT NULL,
  `舍監編號` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 傾印資料表的資料 `學生`
--

INSERT INTO `學生` (`學號`, `姓名`, `Email`, `連絡電話`, `性別`, `生日`, `密碼`, `房間號碼`, `宿舍編號`, `舍監編號`) VALUES
('a123', 'A一', '', '', '男', '2022-01-01', 'Nuk2022-01-01', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- 資料表結構 `宿舍大樓`
--

CREATE TABLE `宿舍大樓` (
  `大樓名稱` varchar(50) NOT NULL,
  `房間住宿費用` int(11) NOT NULL,
  `房間數` int(11) NOT NULL,
  `宿舍編號` char(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- 資料表結構 `宿舍大樓_大樓設備`
--

CREATE TABLE `宿舍大樓_大樓設備` (
  `大樓設備` varchar(50) NOT NULL,
  `宿舍編號` char(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- 資料表結構 `宿舍房間`
--

CREATE TABLE `宿舍房間` (
  `房間號碼` int(11) NOT NULL,
  `當前入住人數` int(11) NOT NULL,
  `宿舍編號` char(2) NOT NULL,
  `舍監編號` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- 資料表結構 `宿舍房間_設備`
--

CREATE TABLE `宿舍房間_設備` (
  `設備` varchar(50) NOT NULL,
  `房間號碼` int(11) NOT NULL,
  `宿舍編號` char(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- 資料表結構 `留言`
--

CREATE TABLE `留言` (
  `內容` varchar(500) NOT NULL,
  `日期` date NOT NULL,
  `No` int(11) NOT NULL,
  `學號` char(8) DEFAULT NULL,
  `舍監編號` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- 資料表結構 `系統消息`
--

CREATE TABLE `系統消息` (
  `日期` date NOT NULL,
  `內容` varchar(500) NOT NULL,
  `No` int(11) NOT NULL,
  `Account` varchar(50) DEFAULT NULL,
  `舍監編號` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- 資料表結構 `系統管理員`
--

CREATE TABLE `系統管理員` (
  `Account` varchar(50) NOT NULL,
  `生日` date NOT NULL,
  `密碼` varchar(100) NOT NULL,
  `姓名` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 傾印資料表的資料 `系統管理員`
--

INSERT INTO `系統管理員` (`Account`, `生日`, `密碼`, `姓名`) VALUES
('z123', '2000-01-01', 'Nuk2000-01-01', 'Z一');

-- --------------------------------------------------------

--
-- 資料表結構 `舍監`
--

CREATE TABLE `舍監` (
  `舍監編號` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- 資料表結構 `違規紀錄`
--

CREATE TABLE `違規紀錄` (
  `日期` date NOT NULL,
  `違規事項` varchar(100) NOT NULL,
  `學號` char(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 已傾印資料表的索引
--

--
-- 資料表索引 `入住申請`
--
ALTER TABLE `入住申請`
  ADD PRIMARY KEY (`申請編號`,`學號`),
  ADD KEY `學號` (`學號`),
  ADD KEY `Account` (`Account`);

--
-- 資料表索引 `學生`
--
ALTER TABLE `學生`
  ADD PRIMARY KEY (`學號`),
  ADD KEY `房間號碼` (`房間號碼`,`宿舍編號`),
  ADD KEY `舍監編號` (`舍監編號`);

--
-- 資料表索引 `宿舍大樓`
--
ALTER TABLE `宿舍大樓`
  ADD PRIMARY KEY (`宿舍編號`);

--
-- 資料表索引 `宿舍大樓_大樓設備`
--
ALTER TABLE `宿舍大樓_大樓設備`
  ADD PRIMARY KEY (`大樓設備`,`宿舍編號`),
  ADD KEY `宿舍編號` (`宿舍編號`);

--
-- 資料表索引 `宿舍房間`
--
ALTER TABLE `宿舍房間`
  ADD PRIMARY KEY (`房間號碼`,`宿舍編號`),
  ADD KEY `宿舍編號` (`宿舍編號`),
  ADD KEY `舍監編號` (`舍監編號`);

--
-- 資料表索引 `宿舍房間_設備`
--
ALTER TABLE `宿舍房間_設備`
  ADD PRIMARY KEY (`設備`,`房間號碼`,`宿舍編號`),
  ADD KEY `房間號碼` (`房間號碼`,`宿舍編號`);

--
-- 資料表索引 `留言`
--
ALTER TABLE `留言`
  ADD PRIMARY KEY (`No`),
  ADD KEY `學號` (`學號`),
  ADD KEY `舍監編號` (`舍監編號`);

--
-- 資料表索引 `系統消息`
--
ALTER TABLE `系統消息`
  ADD PRIMARY KEY (`No`),
  ADD KEY `Account` (`Account`),
  ADD KEY `舍監編號` (`舍監編號`);

--
-- 資料表索引 `系統管理員`
--
ALTER TABLE `系統管理員`
  ADD PRIMARY KEY (`Account`);

--
-- 資料表索引 `舍監`
--
ALTER TABLE `舍監`
  ADD PRIMARY KEY (`舍監編號`);

--
-- 資料表索引 `違規紀錄`
--
ALTER TABLE `違規紀錄`
  ADD PRIMARY KEY (`日期`,`學號`),
  ADD UNIQUE KEY `違規事項` (`違規事項`),
  ADD KEY `學號` (`學號`);

--
-- 在傾印的資料表使用自動遞增(AUTO_INCREMENT)
--

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `入住申請`
--
ALTER TABLE `入住申請`
  MODIFY `申請編號` int(11) NOT NULL AUTO_INCREMENT;

--
-- 已傾印資料表的限制式
--

--
-- 資料表的限制式 `入住申請`
--
ALTER TABLE `入住申請`
  ADD CONSTRAINT `入住申請_ibfk_1` FOREIGN KEY (`學號`) REFERENCES `學生` (`學號`),
  ADD CONSTRAINT `入住申請_ibfk_2` FOREIGN KEY (`Account`) REFERENCES `系統管理員` (`Account`);

--
-- 資料表的限制式 `學生`
--
ALTER TABLE `學生`
  ADD CONSTRAINT `學生_ibfk_1` FOREIGN KEY (`房間號碼`,`宿舍編號`) REFERENCES `宿舍房間` (`房間號碼`, `宿舍編號`),
  ADD CONSTRAINT `學生_ibfk_2` FOREIGN KEY (`舍監編號`) REFERENCES `舍監` (`舍監編號`);

--
-- 資料表的限制式 `宿舍大樓_大樓設備`
--
ALTER TABLE `宿舍大樓_大樓設備`
  ADD CONSTRAINT `宿舍大樓_大樓設備_ibfk_1` FOREIGN KEY (`宿舍編號`) REFERENCES `宿舍大樓` (`宿舍編號`);

--
-- 資料表的限制式 `宿舍房間`
--
ALTER TABLE `宿舍房間`
  ADD CONSTRAINT `宿舍房間_ibfk_1` FOREIGN KEY (`宿舍編號`) REFERENCES `宿舍大樓` (`宿舍編號`),
  ADD CONSTRAINT `宿舍房間_ibfk_2` FOREIGN KEY (`舍監編號`) REFERENCES `舍監` (`舍監編號`);

--
-- 資料表的限制式 `宿舍房間_設備`
--
ALTER TABLE `宿舍房間_設備`
  ADD CONSTRAINT `宿舍房間_設備_ibfk_1` FOREIGN KEY (`房間號碼`,`宿舍編號`) REFERENCES `宿舍房間` (`房間號碼`, `宿舍編號`);

--
-- 資料表的限制式 `留言`
--
ALTER TABLE `留言`
  ADD CONSTRAINT `留言_ibfk_1` FOREIGN KEY (`學號`) REFERENCES `學生` (`學號`),
  ADD CONSTRAINT `留言_ibfk_2` FOREIGN KEY (`舍監編號`) REFERENCES `舍監` (`舍監編號`);

--
-- 資料表的限制式 `系統消息`
--
ALTER TABLE `系統消息`
  ADD CONSTRAINT `系統消息_ibfk_1` FOREIGN KEY (`Account`) REFERENCES `系統管理員` (`Account`),
  ADD CONSTRAINT `系統消息_ibfk_2` FOREIGN KEY (`舍監編號`) REFERENCES `舍監` (`舍監編號`);

--
-- 資料表的限制式 `違規紀錄`
--
ALTER TABLE `違規紀錄`
  ADD CONSTRAINT `違規紀錄_ibfk_1` FOREIGN KEY (`學號`) REFERENCES `學生` (`學號`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
