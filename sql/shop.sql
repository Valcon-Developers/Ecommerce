-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 14, 2025 at 01:35 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `shop`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `ID` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Description` text NOT NULL,
  `Ordering` int(11) DEFAULT NULL,
  `Visibility` tinyint(4) NOT NULL DEFAULT 0,
  `Allow_Comment` tinyint(4) NOT NULL DEFAULT 0,
  `Allow_Ads` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`ID`, `Name`, `Description`, `Ordering`, `Visibility`, `Allow_Comment`, `Allow_Ads`) VALUES
(13, 'laptops', '', 1, 0, 0, 0),
(17, 'phones', '', 2, 0, 0, 0),
(18, 'games', '', 3, 0, 0, 0),
(21, 'offers', '', 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `catlearn`
--

CREATE TABLE `catlearn` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `num` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `catlearn`
--

INSERT INTO `catlearn` (`id`, `name`, `num`) VALUES
(7, 'others', 9),
(12, 'Endo', 1),
(13, 'Remove', 2),
(14, 'opertive', 4),
(15, 'crown', 5),
(16, 'oral medicin', 6);

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `item_ID` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Description` text NOT NULL,
  `price_buy` int(11) NOT NULL,
  `price_sale` int(11) DEFAULT NULL,
  `price_deleting` int(11) NOT NULL,
  `Add_Date` date NOT NULL,
  `Country_Made` varchar(255) NOT NULL,
  `Image` varchar(255) NOT NULL,
  `File` varchar(255) NOT NULL,
  `hidden` smallint(6) NOT NULL,
  `Cat_ID` int(11) NOT NULL,
  `trash` tinyint(6) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`item_ID`, `Name`, `Description`, `price_buy`, `price_sale`, `price_deleting`, `Add_Date`, `Country_Made`, `Image`, `File`, `hidden`, `Cat_ID`, `trash`) VALUES
(47, 'contra', 'Contra Low Speed apple With 3 Holes', 1200, 1300, 1400, '2025-06-13', '', 'img_684c64b6472f3.jpeg', '', 0, 17, 0),
(48, 'semester 3', 'all tools you needed in semseter 3 in falal university', 15000, 17000, 17500, '2025-06-14', '', 'img_684c93365229c.jpeg', 'file_684c9336522b5.pdf', 0, 21, 0);

-- --------------------------------------------------------

--
-- Table structure for table `learn`
--

CREATE TABLE `learn` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `link` text NOT NULL,
  `CAT_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `learn`
--

INSERT INTO `learn` (`id`, `name`, `link`, `CAT_ID`) VALUES
(1, 'اخر يوم في سنه تالته اسنان فيديو ملهوش لزمه\r\n', 'https://youtu.be/O1aaWARnS5g?si=KQodVM1wgPAvcWxJ', 7),
(2, 'زتونه امتحانات الثانويه   ', 'https://youtu.be/Fc09snJF0xE?si=geulpwE67UhjUz0J', 7);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `address` text NOT NULL,
  `payment_method` varchar(50) NOT NULL,
  `product_string` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `confirm` smallint(6) NOT NULL DEFAULT 0,
  `payment` smallint(6) NOT NULL DEFAULT 0,
  `prepared` smallint(6) NOT NULL DEFAULT 0,
  `done` smallint(6) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `name`, `phone`, `address`, `payment_method`, `product_string`, `created_at`, `confirm`, `payment`, `prepared`, `done`) VALUES
(127, 'محمد عبدالجواد', '847658475', 'Egypt cairo', 'instapay', '47->contra=>1; 48->semester 3=>5; ', '2025-06-13 21:39:51', 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `review`
--

CREATE TABLE `review` (
  `id` int(11) NOT NULL,
  `image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `review`
--

INSERT INTO `review` (`id`, `image`) VALUES
(4, 'img_684c651bd8603.png'),
(5, 'img_684c65beb03f6.png'),
(6, 'img_684c65d37033c.jpeg'),
(7, 'img_684c65ea5d6be.jpeg');

-- --------------------------------------------------------

--
-- Table structure for table `setting`
--

CREATE TABLE `setting` (
  `id` int(11) NOT NULL,
  `telegram` varchar(255) DEFAULT NULL,
  `facebook` varchar(255) DEFAULT NULL,
  `instagram` varchar(255) DEFAULT NULL,
  `whatsapp_group` varchar(255) DEFAULT NULL,
  `whatsapp_number` varchar(255) DEFAULT NULL,
  `youtube` varchar(255) DEFAULT NULL,
  `insta_account` varchar(255) DEFAULT NULL,
  `bg_phone` varchar(255) DEFAULT NULL,
  `bg_desktop` varchar(255) DEFAULT NULL,
  `phone_1` varchar(15) NOT NULL,
  `phone_2` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `setting`
--

INSERT INTO `setting` (`id`, `telegram`, `facebook`, `instagram`, `whatsapp_group`, `whatsapp_number`, `youtube`, `insta_account`, `bg_phone`, `bg_desktop`, `phone_1`, `phone_2`) VALUES
(1, 'telegram link', 'face#', 'instagram#', 'https://chat.whatsapp.com/C3OARv9wfry2GYrH03tJRm', '01013128975', 'https://youtu.be/O1aaWARnS5g?si=lLqhS6dkMFlN9_DE', 'instpay#', '1749334151_phone_mobile.jpg', '1749334211_desktop_full.jpg', '01013128975', '01069394958');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `UserID` int(11) NOT NULL,
  `Username` varchar(255) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `FullName` varchar(255) NOT NULL,
  `GroupID` int(11) NOT NULL DEFAULT 0,
  `TrustStatus` int(11) NOT NULL DEFAULT 0,
  `RegStatus` int(11) NOT NULL DEFAULT 0,
  `Date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`UserID`, `Username`, `Password`, `Email`, `FullName`, `GroupID`, `TrustStatus`, `RegStatus`, `Date`) VALUES
(1, 'mohamed          ', '39e21432a7dcba489697b4ef779f4b0c6f08b89f', 'mohamed@gmail.com', 'mohamed Abdelgawad ', 2, 0, 1, '2025-03-10'),
(11, 'sohib   ', '39e21432a7dcba489697b4ef779f4b0c6f08b89f', 'sohib@gmail.com', 'Sohib AlMoHaGer', 1, 0, 0, '2025-03-10'),
(22, 'hassan', '82e17b329850b3ff13ca46205d80ec9a29bc479f', 'hassan@gmail.com', 'Hassan Ahmed', 1, 0, 0, '2025-03-18'),
(23, 'khaled', 'dea742e166979027ae70b28e0a9006fb1010e760', 'khaled@gmail.com', 'Khaled', 1, 0, 0, '2025-03-18'),
(25, 'ادم ', 'e8b05c62a01f4f850c53b623400a2d8521ad56cc', 'adam@gmail.com', 'ادم عبدالجواد', 1, 0, 0, '2025-04-24');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `Name` (`Name`);

--
-- Indexes for table `catlearn`
--
ALTER TABLE `catlearn`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`item_ID`),
  ADD KEY `Cat_ID` (`Cat_ID`);

--
-- Indexes for table `learn`
--
ALTER TABLE `learn`
  ADD PRIMARY KEY (`id`),
  ADD KEY `CAT_ID` (`CAT_ID`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `review`
--
ALTER TABLE `review`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `setting`
--
ALTER TABLE `setting`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`UserID`),
  ADD UNIQUE KEY `Username` (`Username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `catlearn`
--
ALTER TABLE `catlearn`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `item_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `learn`
--
ALTER TABLE `learn`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=128;

--
-- AUTO_INCREMENT for table `review`
--
ALTER TABLE `review`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `setting`
--
ALTER TABLE `setting`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `items`
--
ALTER TABLE `items`
  ADD CONSTRAINT `Cat_ID` FOREIGN KEY (`Cat_ID`) REFERENCES `categories` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
