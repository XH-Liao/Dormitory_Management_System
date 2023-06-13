-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- 主機： 127.0.0.1
-- 產生時間： 2023-06-13 13:15:44
-- 伺服器版本： 10.4.27-MariaDB
-- PHP 版本： 8.0.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 資料庫： `dms`
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 傾印資料表的資料 `入住申請`
--

INSERT INTO `入住申請` (`申請日期`, `核可狀態`, `繳費狀態`, `學年度`, `學期`, `申請編號`, `學號`, `Account`) VALUES
('2023-01-06', 1, 0, 111, 1, 367, 'a1095503', 'admin'),
('2023-01-06', 1, 0, 111, 1, 368, 'a1095502', 'admin'),
('2023-01-06', 0, 0, 111, 1, 369, 'a1095504', NULL),
('2023-01-06', 0, 0, 111, 1, 370, 'a1095505', NULL),
('2023-01-06', 0, 0, 111, 1, 371, 'a1095506', NULL),
('2023-01-06', 1, 0, 111, 1, 372, 'a1095512', 'admin'),
('2023-01-06', 1, 0, 111, 1, 373, 'a1095513', 'admin'),
('2023-01-06', 0, 0, 111, 1, 374, 'a1095514', NULL),
('2023-01-06', 0, 0, 111, 1, 375, 'a1095515', NULL),
('2023-01-06', 0, 0, 111, 1, 376, 'a1095516', NULL);

-- --------------------------------------------------------

--
-- 資料表結構 `學生`
--

CREATE TABLE `學生` (
  `學號` char(8) NOT NULL,
  `姓名` varchar(50) NOT NULL,
  `Email` varchar(100) DEFAULT NULL,
  `連絡電話` varchar(10) DEFAULT NULL,
  `性別` char(1) NOT NULL,
  `生日` date NOT NULL,
  `密碼` varchar(500) NOT NULL,
  `房間號碼` int(11) DEFAULT NULL,
  `宿舍編號` char(2) DEFAULT NULL,
  `舍監編號` int(11) DEFAULT NULL,
  `班級編號` char(6) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 傾印資料表的資料 `學生`
--

INSERT INTO `學生` (`學號`, `姓名`, `Email`, `連絡電話`, `性別`, `生日`, `密碼`, `房間號碼`, `宿舍編號`, `舍監編號`, `班級編號`) VALUES
('a1085501', 'Stu108_1', NULL, NULL, '男', '2000-01-01', '$2y$10$CBfIQuEZQa7jdZI.MBEqRueU2N39.q9DUNWdqpN7h3.n3vahYS8Hi', NULL, NULL, NULL, 'A10855'),
('a1085502', 'Stu108_2', NULL, NULL, '女', '2000-01-02', '$2y$10$F8S49s1ZbyAo5NBMHUVWxuJ/hnqW3NGJI/tviKnseZAx6UbHrLAj6', NULL, NULL, NULL, 'A10855'),
('a1095502', 'A2', 'a1095527@mail.nuk.edu.tw', '', '男', '2000-01-02', '$2y$10$fWxQNOP7A6DGdIcv81D92OKcOme.c3N4AB7LdTFwKq8lVLOjBxR6m', 1, 'OE', 2, 'A10955'),
('a1095503', 'A3', 'a1095527@mail.nuk.edu.tw', '', '男', '2000-01-03', '$2y$10$K7cfHFucnqQd5c1kqg6g5.kt.w4WLT/0VGoNmlpBU1m9jvBKWMV/u', 1, 'OE', NULL, 'A10955'),
('a1095504', 'A4', 'a1095527@mail.nuk.edu.tw', '', '男', '2000-01-04', '$2y$10$g72jungmjAvO9zvkcpSJRO3Gm5Im4s2nWxXL7jdgLnmEP6ggsTnli', NULL, NULL, NULL, 'A10955'),
('a1095505', 'A5', 'a1095527@mail.nuk.edu.tw', '', '男', '2000-01-05', '$2y$10$.QG.nrsnGqnNukqPA2c3gux20Iflz6ReQgvj6Zb0S2ZmfMLSeNC1O', NULL, NULL, NULL, 'A10955'),
('a1095506', 'A6', 'a1095527@mail.nuk.edu.tw', '', '男', '2000-01-06', '$2y$10$rT3ZTdSpsP4TuedeBvxYLeb5oLysezvX0USEfrS5vCAN14rwGK8Dm', NULL, NULL, NULL, 'A10955'),
('a1095507', 'A7', 'a1095527@mail.nuk.edu.tw', '', '男', '2000-01-07', '$2y$10$KHvBv1CEcpwJk3YR.i7bIOKEkZO3Bh4PO7FHTwH2V.9/4UVh86P/S', NULL, NULL, NULL, 'A10955'),
('a1095508', 'A8', 'a1095527@mail.nuk.edu.tw', '', '男', '2000-01-08', '$2y$10$9/PM1i0lgUVMa9Ble2CNNulOTNaKFdQpX6FFAY0xDIxddjWQW7xo2', NULL, NULL, NULL, 'A10955'),
('a1095509', 'A9', 'a1095527@mail.nuk.edu.tw', '', '男', '2000-01-09', '$2y$10$wEbvoaosmotsazDtWoogteqt/ziaPGWyrPKDnGfl4wH0523.EEDdO', NULL, NULL, NULL, 'A10955'),
('a1095510', 'A10', 'a1095527@mail.nuk.edu.tw', '', '男', '2000-01-10', '$2y$10$E9Vi8ZAlwwnGauSdJsEGiuz32KdYKDkIjGhjcnD8gJ0ennh2lJSte', NULL, NULL, NULL, 'A10955'),
('a1095512', 'A12', 'a1095527@mail.nuk.edu.tw', '', '女', '2000-01-12', '$2y$10$2wAcolBMeesjmNACLGHaZ.iOgnk8oRCvd.7n4hGOEoGRE.sHMTxz2', 1, 'OF', 12, 'A10955'),
('a1095513', 'A13', 'a1095527@mail.nuk.edu.tw', '', '女', '2000-01-13', '$2y$10$00.e9EAlxEEUHwqWz/um2eHmvRihtTD3cZuTU2t0meJ6SP4801rg2', 1, 'OF', NULL, 'A10955'),
('a1095514', 'A14', 'a1095527@mail.nuk.edu.tw', '', '女', '2000-01-14', '$2y$10$VojuW.3Nset3BhrjMD7fROpdwkRMbEipSVfz0HIz0pLOeGdwRWojC', NULL, NULL, NULL, 'A10955'),
('a1095515', 'A15', 'a1095527@mail.nuk.edu.tw', '', '女', '2000-01-15', '$2y$10$VKmlTsieVNJ6eCL03N2NCOO50Te7pOQWZM9FIugqI6D92X74GpVUa', NULL, NULL, NULL, 'A10955'),
('a1095516', 'A16', 'a1095527@mail.nuk.edu.tw', '', '女', '2000-01-16', '$2y$10$p5Hom10KmfIaFJkfOSh2ku52smUfDe.7gKoR7PsnBvXFLoc1MtG0e', NULL, NULL, NULL, 'A10955'),
('a1095517', 'A17', 'a1095527@mail.nuk.edu.tw', '', '女', '2000-01-17', '$2y$10$BORNbb8AiH8sSHtSU4ToTeq975RdvrBWu44tqRq9CH17xgqRtYVdS', NULL, NULL, NULL, 'A10955'),
('a1095518', 'A18', 'a1095527@mail.nuk.edu.tw', '', '女', '2000-01-18', '$2y$10$9T1HMoFq7h.CFDOk8qFUG.rC6Cs7p5FLoQgSBZ.n1GHMdrItutXym', NULL, NULL, NULL, 'A10955'),
('a1095519', 'A19', 'a1095527@mail.nuk.edu.tw', '', '女', '2000-01-19', '$2y$10$0ah1M8A.nkuqSJVB4M4mluSi4FKwFfuwDsBA1XUEd9wDVp21wzvA2', NULL, NULL, NULL, 'A10955'),
('a1095520', 'A20', 'a1095527@mail.nuk.edu.tw', '', '女', '2000-01-20', '$2y$10$csZBw4bxOBl3/3BNASGaqOyRVIomghWCTclNTNVWrQtOPvsjSzAz.', NULL, NULL, NULL, 'A10955'),
('a1105501', 'Stu110_1', NULL, NULL, '男', '2000-01-01', '$2y$10$p6777tzh7Po.kplMwPItI.V6dTHwKuvpFiPCDAF6Zc3MH/sIJz1Ha', NULL, NULL, NULL, 'A11055'),
('a1105502', 'Stu110_2', NULL, NULL, '男', '2000-01-02', '$2y$10$SZFXO2BH92T6Pyd6W99jie/55MLMfRRj7xZIuw838qDbxhShBEEtK', NULL, NULL, NULL, 'A11055'),
('a1105503', 'Stu110_3', NULL, NULL, '男', '2000-01-03', '$2y$10$jpJP/Lipg7f1pZlPIuwd1eQduev2cS3LqrjAbhqjCiWdXDOwGsUpO', NULL, NULL, NULL, 'A11055');

-- --------------------------------------------------------

--
-- 資料表結構 `宿舍大樓`
--

CREATE TABLE `宿舍大樓` (
  `大樓名稱` varchar(50) NOT NULL,
  `房間住宿費用` int(11) NOT NULL,
  `房間數` int(11) NOT NULL,
  `宿舍編號` char(2) NOT NULL,
  `性別` char(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 傾印資料表的資料 `宿舍大樓`
--

INSERT INTO `宿舍大樓` (`大樓名稱`, `房間住宿費用`, `房間數`, `宿舍編號`, `性別`) VALUES
('學一男宿', 8000, 5, 'OA', '男'),
('學一女宿', 8000, 5, 'OB', '女'),
('學二男宿', 9000, 5, 'OE', '男'),
('學二女宿', 9000, 5, 'OF', '女');

-- --------------------------------------------------------

--
-- 資料表結構 `宿舍大樓_大樓設備`
--

CREATE TABLE `宿舍大樓_大樓設備` (
  `大樓設備` varchar(50) NOT NULL,
  `宿舍編號` char(2) NOT NULL,
  `維修狀態` tinyint(1) NOT NULL DEFAULT 0,
  `報修人` varchar(10) DEFAULT NULL,
  `聯絡方式` varchar(10) DEFAULT NULL,
  `損毀情況` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 傾印資料表的資料 `宿舍大樓_大樓設備`
--

INSERT INTO `宿舍大樓_大樓設備` (`大樓設備`, `宿舍編號`, `維修狀態`, `報修人`, `聯絡方式`, `損毀情況`) VALUES
('冰箱', 'OB', 0, NULL, NULL, NULL),
('桌子', 'OB', 1, 'Andy', 'andy123@gm', '桌腳損壞'),
('椅子', 'OB', 0, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- 資料表結構 `宿舍房間`
--

CREATE TABLE `宿舍房間` (
  `房間號碼` int(11) NOT NULL,
  `當前入住人數` int(11) NOT NULL,
  `宿舍編號` char(2) NOT NULL,
  `舍監編號` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 傾印資料表的資料 `宿舍房間`
--

INSERT INTO `宿舍房間` (`房間號碼`, `當前入住人數`, `宿舍編號`, `舍監編號`) VALUES
(1, 0, 'OA', NULL),
(1, 0, 'OB', NULL),
(1, 2, 'OE', 2),
(1, 2, 'OF', 12),
(2, 0, 'OA', NULL),
(2, 0, 'OB', NULL),
(2, 0, 'OE', NULL),
(2, 0, 'OF', NULL),
(3, 0, 'OA', NULL),
(3, 0, 'OB', NULL),
(3, 0, 'OE', NULL),
(3, 0, 'OF', NULL),
(4, 0, 'OA', NULL),
(4, 0, 'OB', NULL),
(4, 0, 'OE', NULL),
(4, 0, 'OF', NULL),
(5, 0, 'OA', NULL),
(5, 0, 'OB', NULL),
(5, 0, 'OE', NULL),
(5, 0, 'OF', NULL);

-- --------------------------------------------------------

--
-- 資料表結構 `宿舍房間_設備`
--

CREATE TABLE `宿舍房間_設備` (
  `設備` varchar(50) NOT NULL,
  `房間號碼` int(11) NOT NULL,
  `宿舍編號` char(2) NOT NULL,
  `維修狀態` tinyint(1) NOT NULL DEFAULT 0,
  `報修人` varchar(10) DEFAULT NULL,
  `聯絡方式` varchar(10) DEFAULT NULL,
  `損毀情況` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 傾印資料表的資料 `宿舍房間_設備`
--

INSERT INTO `宿舍房間_設備` (`設備`, `房間號碼`, `宿舍編號`, `維修狀態`, `報修人`, `聯絡方式`, `損毀情況`) VALUES
('書架', 1, 'OB', 0, NULL, NULL, NULL),
('椅子', 1, 'OB', 1, 'Peter', '09xx', '椅腳會晃動'),
('鞋櫃', 1, 'OB', 0, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- 資料表結構 `班級`
--

CREATE TABLE `班級` (
  `班級編號` char(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 傾印資料表的資料 `班級`
--

INSERT INTO `班級` (`班級編號`) VALUES
('A10855'),
('A10955'),
('A11055');

-- --------------------------------------------------------

--
-- 資料表結構 `留言`
--

CREATE TABLE `留言` (
  `標題` varchar(50) NOT NULL,
  `內容` varchar(500) NOT NULL,
  `日期` datetime NOT NULL DEFAULT current_timestamp(),
  `No` int(11) NOT NULL,
  `學號` char(8) DEFAULT NULL,
  `舍監編號` int(11) DEFAULT NULL,
  `回覆時間` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `回覆內容` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 傾印資料表的資料 `留言`
--

INSERT INTO `留言` (`標題`, `內容`, `日期`, `No`, `學號`, `舍監編號`, `回覆時間`, `回覆內容`) VALUES
('有人的學生證掉了，學號a1095500', '幫忙放去系辦了，記得去領', '2023-01-06 22:01:42', 11, 'a1095502', NULL, NULL, '');

-- --------------------------------------------------------

--
-- 資料表結構 `系統消息`
--

CREATE TABLE `系統消息` (
  `日期` date NOT NULL DEFAULT current_timestamp(),
  `標題` varchar(50) NOT NULL,
  `內容` varchar(500) NOT NULL,
  `No` int(11) NOT NULL,
  `Account` varchar(50) DEFAULT NULL,
  `舍監編號` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 傾印資料表的資料 `系統消息`
--

INSERT INTO `系統消息` (`日期`, `標題`, `內容`, `No`, `Account`, `舍監編號`) VALUES
('2023-01-06', '即日起，開放宿舍申請，請同學記得申請！', '申請宿舍步驟\r\n1. 登入本系統\r\n2. 選擇「申請入住」\r\n3. 閱讀條文\r\n4. 按下申請按鈕\r\n5. 留意本系統之公告\r\n6. 等待系統管理員核可申請、分派房間後，進行繳費！', 18, 'admin', NULL),
('2023-01-06', '已核可同學的宿舍申請，請同學記得繳納住宿費用！', '繳費步驟如下：\r\n1. 進入本系統\r\n2. 選擇「申請入住」\r\n3. 按下繳費按鈕\r\n4. 輸入信用卡號等資料\r\n5. 確認繳費\r\n6. 確認是否為已繳費', 19, 'admin', NULL);

-- --------------------------------------------------------

--
-- 資料表結構 `系統管理員`
--

CREATE TABLE `系統管理員` (
  `Account` varchar(50) NOT NULL,
  `生日` date NOT NULL,
  `密碼` varchar(100) NOT NULL,
  `姓名` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 傾印資料表的資料 `系統管理員`
--

INSERT INTO `系統管理員` (`Account`, `生日`, `密碼`, `姓名`) VALUES
('admin', '2000-01-01', '$2y$10$HYZHrhLU5QQj/VK79vcp2ushFDKzHwHIB6VOgsa0f7Pc/RDLmsvRi', 'Admin'),
('z1095502', '2000-01-02', '$2y$10$g6TfVcrO6cxI7uab3jedou9cfKvESQ2eOWeWYHKXSp2wJEXgn1k5.', 'Z2'),
('z1095503', '2000-01-03', '$2y$10$/mYS0mJK8q8dDJh2U4a1M.1SHOfRBIs0Fvozk50ecpnKxOn5eCI8e', 'Z3'),
('z1095504', '2000-01-04', '$2y$10$Qrnrh18Tbs5HkECRy6EAHOf95X.uqYz.TiS.bF0tAdAaZSsdxJBrq', 'Z4'),
('z1095505', '2000-01-05', '$2y$10$oVkfGpX4GacQUj3BsSG6YeSLbP.xtnS8kM3dgiiIH/8wMjUmidyQC', 'Z5'),
('z1095506', '2000-01-06', '$2y$10$uYAuH85C19plOlemDaCXPub7dhbNCzianJ2G7wi4LcbeRRU9hHi.i', 'Z6');

-- --------------------------------------------------------

--
-- 資料表結構 `老師`
--

CREATE TABLE `老師` (
  `老師編號` char(8) NOT NULL,
  `班級編號` char(6) DEFAULT NULL,
  `姓名` varchar(10) NOT NULL,
  `密碼` varchar(100) NOT NULL,
  `生日` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 傾印資料表的資料 `老師`
--

INSERT INTO `老師` (`老師編號`, `班級編號`, `姓名`, `密碼`, `生日`) VALUES
('t1085501', 'A10855', '張保榮', '$2y$10$fWxQNOP7A6DGdIcv81D92OKcOme.c3N4AB7LdTFwKq8lVLOjBxR6m', '2001-01-01'),
('t1095501', 'A10955', '林文揚', '$2y$10$29nK4GcanDb81LOuxyrMX.HVl8YHD4b1cONnYuu8aeF421Hsdzk8W', '2001-01-01'),
('t1095502', 'A10955', '洪宗貝', '$2y$10$fWxQNOP7A6DGdIcv81D92OKcOme.c3N4AB7LdTFwKq8lVLOjBxR6m', '2001-01-01'),
('t1115501', NULL, 'TR1', '$2y$10$g6TfVcrO6cxI7uab3jedou9cfKvESQ2eOWeWYHKXSp2wJEXgn1k5.', '2000-11-01'),
('t1115502', NULL, 'TA2', '$2y$10$g6TfVcrO6cxI7uab3jedou9cfKvESQ2eOWeWYHKXSp2wJEXgn1k5.', '2000-11-02');

-- --------------------------------------------------------

--
-- 資料表結構 `舍監`
--

CREATE TABLE `舍監` (
  `舍監編號` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 傾印資料表的資料 `舍監`
--

INSERT INTO `舍監` (`舍監編號`) VALUES
(2),
(12);

-- --------------------------------------------------------

--
-- 資料表結構 `違規紀錄`
--

CREATE TABLE `違規紀錄` (
  `日期` date NOT NULL,
  `違規事項` varchar(100) NOT NULL,
  `學號` char(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 傾印資料表的資料 `違規紀錄`
--

INSERT INTO `違規紀錄` (`日期`, `違規事項`, `學號`) VALUES
('2022-12-01', '第一條', 'a1095503'),
('2022-12-02', '第二條', 'a1095513');

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
  ADD KEY `舍監編號` (`舍監編號`),
  ADD KEY `學生_ibfk_3` (`班級編號`);

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
-- 資料表索引 `班級`
--
ALTER TABLE `班級`
  ADD PRIMARY KEY (`班級編號`);

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
-- 資料表索引 `老師`
--
ALTER TABLE `老師`
  ADD PRIMARY KEY (`老師編號`),
  ADD KEY `班級編號` (`班級編號`);

--
-- 資料表索引 `舍監`
--
ALTER TABLE `舍監`
  ADD PRIMARY KEY (`舍監編號`);

--
-- 資料表索引 `違規紀錄`
--
ALTER TABLE `違規紀錄`
  ADD PRIMARY KEY (`日期`,`學號`,`違規事項`) USING BTREE,
  ADD KEY `學號` (`學號`);

--
-- 在傾印的資料表使用自動遞增(AUTO_INCREMENT)
--

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `入住申請`
--
ALTER TABLE `入住申請`
  MODIFY `申請編號` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=381;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `留言`
--
ALTER TABLE `留言`
  MODIFY `No` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `系統消息`
--
ALTER TABLE `系統消息`
  MODIFY `No` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- 已傾印資料表的限制式
--

--
-- 資料表的限制式 `入住申請`
--
ALTER TABLE `入住申請`
  ADD CONSTRAINT `入住申請_ibfk_1` FOREIGN KEY (`學號`) REFERENCES `學生` (`學號`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `入住申請_ibfk_2` FOREIGN KEY (`Account`) REFERENCES `系統管理員` (`Account`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- 資料表的限制式 `學生`
--
ALTER TABLE `學生`
  ADD CONSTRAINT `學生_ibfk_1` FOREIGN KEY (`房間號碼`,`宿舍編號`) REFERENCES `宿舍房間` (`房間號碼`, `宿舍編號`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `學生_ibfk_2` FOREIGN KEY (`舍監編號`) REFERENCES `舍監` (`舍監編號`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `學生_ibfk_3` FOREIGN KEY (`班級編號`) REFERENCES `班級` (`班級編號`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- 資料表的限制式 `宿舍大樓_大樓設備`
--
ALTER TABLE `宿舍大樓_大樓設備`
  ADD CONSTRAINT `宿舍大樓_大樓設備_ibfk_1` FOREIGN KEY (`宿舍編號`) REFERENCES `宿舍大樓` (`宿舍編號`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- 資料表的限制式 `宿舍房間`
--
ALTER TABLE `宿舍房間`
  ADD CONSTRAINT `宿舍房間_ibfk_1` FOREIGN KEY (`宿舍編號`) REFERENCES `宿舍大樓` (`宿舍編號`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `宿舍房間_ibfk_2` FOREIGN KEY (`舍監編號`) REFERENCES `舍監` (`舍監編號`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- 資料表的限制式 `宿舍房間_設備`
--
ALTER TABLE `宿舍房間_設備`
  ADD CONSTRAINT `宿舍房間_設備_ibfk_1` FOREIGN KEY (`房間號碼`,`宿舍編號`) REFERENCES `宿舍房間` (`房間號碼`, `宿舍編號`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- 資料表的限制式 `留言`
--
ALTER TABLE `留言`
  ADD CONSTRAINT `留言_ibfk_1` FOREIGN KEY (`學號`) REFERENCES `學生` (`學號`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `留言_ibfk_2` FOREIGN KEY (`舍監編號`) REFERENCES `舍監` (`舍監編號`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- 資料表的限制式 `系統消息`
--
ALTER TABLE `系統消息`
  ADD CONSTRAINT `系統消息_ibfk_1` FOREIGN KEY (`Account`) REFERENCES `系統管理員` (`Account`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- 資料表的限制式 `老師`
--
ALTER TABLE `老師`
  ADD CONSTRAINT `老師_ibfk_1` FOREIGN KEY (`班級編號`) REFERENCES `班級` (`班級編號`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- 資料表的限制式 `違規紀錄`
--
ALTER TABLE `違規紀錄`
  ADD CONSTRAINT `違規紀錄_ibfk_1` FOREIGN KEY (`學號`) REFERENCES `學生` (`學號`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
