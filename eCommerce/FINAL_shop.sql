-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 28, 2024 at 04:07 PM
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
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `adminid` int(11) NOT NULL,
  `Username` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`adminid`, `Username`, `password`) VALUES
(1, 'ali', '12345'),
(2, 'aml', '123123'),
(3, 'Abanoub', '123123');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `ID` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Description` text NOT NULL,
  `parent` int(11) NOT NULL,
  `Ordering` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`ID`, `Name`, `Description`, `parent`, `Ordering`) VALUES
(19, 'Mobile Phones', '', 0, 1),
(20, 'Electronics', '', 0, 2),
(21, 'Fashion', '', 0, 3),
(22, 'Video Games', '', 0, 4),
(23, 'Toys & Games', '', 0, 5);

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `c_id` int(11) NOT NULL,
  `comment` text NOT NULL,
  `status` tinyint(4) NOT NULL,
  `comment_date` date NOT NULL,
  `item_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`c_id`, `comment`, `status`, `comment_date`, `item_id`, `user_id`) VALUES
(3, 'amazing', 1, '2023-12-16', 22, 1);

-- --------------------------------------------------------

--
-- Table structure for table `confirm-buy`
--

CREATE TABLE `confirm-buy` (
  `Confirmation_ID` int(11) NOT NULL,
  `Item_ID` int(11) NOT NULL,
  `Member_ID` int(11) NOT NULL,
  `Confirmation_Date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `confirm-buy`
--

INSERT INTO `confirm-buy` (`Confirmation_ID`, `Item_ID`, `Member_ID`, `Confirmation_Date`) VALUES
(134, 23, 1, '2024-01-28');

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `Item_ID` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Description` text NOT NULL,
  `Price` varchar(255) NOT NULL,
  `Add_Date` date NOT NULL,
  `Country_Made` varchar(255) NOT NULL,
  `Status` varchar(255) NOT NULL,
  `Approve` tinyint(4) NOT NULL DEFAULT 0,
  `Cat_ID` int(11) NOT NULL,
  `Member_ID` int(11) NOT NULL,
  `tags` varchar(255) NOT NULL,
  `avatar` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`Item_ID`, `Name`, `Description`, `Price`, `Add_Date`, `Country_Made`, `Status`, `Approve`, `Cat_ID`, `Member_ID`, `tags`, `avatar`) VALUES
(20, 'Samsung Galaxy A54', 'Dual SIM Mobile Phone Android, 8GB RAM, 256GB, Awesome Graphite - 1 year Warranty', '200', '2023-12-15', 'USA', '1', 1, 19, 1, 'ِAndroid , 8GB RAM, 256GB', '7180008421_Screenshot 2023-12-15 114033.png'),
(21, 'Nokia G21', 'Nokia G21 4gb ram, 128gb memory, finger print sensor - blue', '100', '2023-12-15', 'USA', 'Buy', 1, 19, 1, 'ِAndroid , 4gb ram, 128gb', '464134088_Nokia G21.png'),
(22, 'realme C53', 'realme C53 Dual SIM 6GB RAM 128GB Mighty Black 4G LTE', '200', '2023-12-15', 'Canada', 'Buy', 1, 19, 1, 'ِAndroid , 6GB RAM 128GB', '9359862529_realme C53.png'),
(23, 'iPhone 11', 'Apple iPhone 11 With Facetime Physical Dual SIM - 128GB, 4G, LTE, White, International Version', '300', '2023-12-15', 'USA', 'Buy', 1, 19, 1, 'Apple , 128GB, 4G', '3543674351_iPhone11.png'),
(24, 'iPhone 12', 'iPhone 12 Pro 128GB Graphite', '400', '2023-12-15', 'USA', '2', 1, 19, 1, 'Apple , 128GB', '9576295502_iPhone12.png'),
(25, ' iPhone 13', 'New Apple iPhone 13 with FaceTime (128GB) - Midnight', '300', '2023-12-15', 'USA', '1', 1, 19, 1, 'Apple , 128GB', '9122258045_iPhone13.png'),
(26, 'iPhone 14', 'Apple iPhone 14 Pro (128 GB) - Gold, Bluetooth, Wi-Fi', '300', '2023-12-15', 'USA', '1', 1, 19, 1, 'Apple , 128GB', '7703625556_iPhone14.png'),
(27, 'Vivo V27', 'Vivo V27 5G, 8GB RAM, 256GB ROM - Noble Black', '200', '2023-12-15', 'USA', 'Buy', 1, 19, 1, 'Android , 8GB RAM, 256GB', '8113192335_VivoV27.png'),
(28, 'soundcore', 'soundcore by Anker P20i Headphones In-Ear, 10 mm Driver, Bluetooth 5.3, Adjustable EQ, 30 Hours Playtime, IPX5 Waterproof, 2 Micros with AI, Can be Used Individually + 18 Months Local Warranty', '50', '2023-12-15', 'China', 'Buy', 1, 20, 1, 'Headphones', '8179064250_Headphones1.png'),
(29, 'Oraimo OTW-330', 'Oraimo OTW-330 FreePods Lite Havy Bass TWS Earphone with APP Control,IPX4 Bluetooth 5.3, 40h Play Time, Anifast Fast Charging, Pure Bass Performance- Black + 12 Months Local Warranty', '100', '2023-12-15', 'China', 'Buy', 1, 20, 1, 'Headphones', '1630106085_Headphones2.png'),
(30, 'Headphones', 'Max Bluetooth Headphones, Wireless Bluetooth Headset with Earphone Cover, Clear Sound and HD Microphone, for All Mobile Phones with Noise Canceling Technology (Black)', '200', '2023-12-15', 'USA', 'Buy', 1, 20, 1, 'Bluetooth Headphones', '1248711631_Headphone3.png'),
(31, 'Oraimo Headphone', 'Oraimo Wireless Headset oraimo OEB-H89D Black', '200', '2023-12-15', 'USA', '1', 1, 20, 1, ' Bluetooth  Headphone', '6836124789_Headphone4.png'),
(32, 'SUB BT ', 'SUB BT +LED ZR4930D - ZERO', '200', '2023-12-15', 'China', '1', 1, 20, 1, 'SUB ', '8063560277_SUB1.png'),
(33, 'Wireless Mouse', 'Bluetooth Wireless Mouse, Dual Mode Slim Rechargeable Wireless Mouse Silent Cordless Mouse with Bluetooth 4.0 and 2.4G Wireless, Compatible with Laptop, PC, Windows Mac Android OS Tablet (Silver)', '100', '2023-12-15', 'China', '1', 1, 20, 1, 'Mouse', '8497117393_Mouse1.png'),
(34, 'Lava ST-13 Mouse', 'Lava ST-13 Wireless Gaming Grade Specifications Mouse With Fast Track - Red Black', '50', '2023-12-15', 'China', '1', 1, 20, 1, 'Mouse', '4725930715_Mouse2.png'),
(35, 'Toshiba 4K TV', 'Toshiba 4K Smart Frameless D-LED Ultra HD 65 Inch TV with Built-In Receiver, Black - 65U5965EA - Promotions (WE & Shahid VIP)', '200', '2023-12-15', 'USA', '1', 1, 20, 1, 'TV', '7346990279_TV1.png'),
(36, 'Sony 4K TV ', 'Sony 55 inch 4K LED Smart Android TV with Remote Control, USB, HDMI - KD-55X7500H - WE Promotion', '300', '2023-12-15', 'USA', '1', 1, 20, 1, 'TV', '9854873978_TV2.png'),
(37, 'Dell Vostro 3510 laptop', 'Dell Vostro 3510 laptop - Intel core i5-1035G1, 8GB RAM, 1TB HDD, Intel UHD Graphics, 15.6\" HD TN 220 nits Anti-glare, Ubuntu - Carbon Black + Gift', '200', '2023-12-15', 'USA', '1', 1, 20, 1, 'laptop ', '2971726642_Laptop1.png'),
(39, 'Sweater', 'Nas Trends for Fashion SAE unisex-child NAS-412014331222 Sweater', '10', '2023-12-15', 'Egypt', 'Buy', 1, 21, 1, 'Sweater', '8687722652_Sweater1.png'),
(40, 'Hoodie ', 'NAS Trends Cold Mountain Kids Unisex Oversized Zip-up Hoodie - Olive- 8 Yrs', '30', '2023-12-15', 'Italy', 'Buy', 1, 21, 1, 'Hoodie ', '8574496236_Hoodie1.png'),
(41, 'Sweatshirt', 'Andora boys 34W23B30305 Sweatshirt', '10', '2023-12-15', 'USA', 'Buy', 1, 21, 1, 'Sweatshirt', '8931151115_Sweatshirt1.png'),
(42, 'Casual Hoodie', 'Romba Men\'s Casual Hoodie Sweatshirt', '10', '2023-12-15', 'Italy', 'Buy', 1, 21, 1, 'Hoodie ', '2223037657_Hoodie2.png'),
(43, 'Sony playstation 5', 'Sony playstation 5 console with wireless controller cd version, white and black', '200', '2023-12-15', 'USA', 'Buy', 1, 22, 1, 'playstation', '9384708013_P1.png'),
(44, 'PlayStation 5 Controller', ' DualSense Charging Station - PlayStation 5 Controller', '100', '2023-12-15', 'USA', 'Buy', 1, 22, 1, 'Controller', '7415663187_C1.png'),
(45, 'FC 24', 'SPORTS FC 24 Arabic - PS4', '30', '2023-12-15', 'USA', 'Buy', 1, 22, 1, 'FC', '8424648146_F1.png'),
(46, '  Gaming Headset', 'G2000 Gaming Headset, Surround Stereo Gaming Headphones with Noise Cancelling Mic, LED Light & Soft Memory Earmuffs, Works with Xbox One, PS4, Nintendo Switch, PC Mac Computer Games - Red, Wired', '100$', '2023-12-15', 'China', '1', 1, 20, 1, 'Headphones', '8721781894_H1.png'),
(47, 'Spider Man', 'MARVEL’S SPIDER-MAN 2 – PS5', '30$', '2023-12-15', 'USA', 'Buy', 1, 22, 1, 'Game', '9853317829_S1.png'),
(48, 'Crash Team Rumble', 'ACTIVISION Crash Team Rumble - Deluxe Edition', '40$', '2023-12-15', 'Canada', '1', 1, 22, 1, 'Game', '2029148369_G1.png'),
(49, 'Montessori toys', 'Montessori toys for 1 2 3 years old boys wooden sorting stacking toys age 6 12 month shape color recognition stacker 1 2 3 baby boys girls toddlers kid birthday present gifts age 3+', '10$', '2023-12-15', 'USA', '1', 1, 23, 1, 'toys', '1343084705_T1.png'),
(50, 'Car Toys', 'Swift RC Car Toys Remote Control | Stunt Car for 3-12 Year-Old Boys | RC Cars 360 Degree Flips Double Sided Rotating 4WD 2.4Ghz Outdoor Toys Car for Kids Birthday Gifts (Blue)', '30$', '2023-12-15', 'China', 'Buy', 1, 23, 1, 'toys', '1154940071_T2.png'),
(51, 'Chess', 'Magnetic Chess, Checkers, Backgammon Game Set - 3-in-1 Board Games Set, 25 cm Foldable and Portable, Perfect for Travel', '30$', '2023-12-15', 'Egypt', 'Buy', 1, 23, 1, 'Chess', '2843195224_T3.png');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `UserID` int(11) NOT NULL COMMENT 'To identify user',
  `Username` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'Username To Login',
  `Password` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'Password To Login',
  `Email` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `FullName` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `RegStatus` int(11) NOT NULL DEFAULT 0 COMMENT 'User approval',
  `Date` date DEFAULT NULL,
  `avatar` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`UserID`, `Username`, `Password`, `Email`, `FullName`, `RegStatus`, `Date`, `avatar`) VALUES
(1, 'Abanoub', '601f1889667efaebb33b8c12572835da3f027f78', 'abanoub@gmail.com', 'Abanoub Ragheb', 1, '2023-10-29', ''),
(2, 'Amal', '12345', 'Amal@gmail.com', 'Amal Ali', 1, '2023-11-21', ''),
(14, 'Mahmoud', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'Mahmoud@gmail.com', 'Mahmoud Ahmed', 1, '2023-11-25', ''),
(15, 'Marina', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'marina@gmail.com', 'Marina Ramziii', 1, '2023-11-26', ''),
(16, 'Semo', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'Semo@gmail.com', 'Semo Adel', 1, '2023-11-29', ''),
(17, 'Ali Ahmed', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'Ali@gmail.com', 'Ali Ahmed', 1, '2023-11-29', ''),
(19, 'Ziad', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'ziad@gmail.com', 'Ziad Ahmed', 1, '2023-11-29', ''),
(20, 'Hind', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'hind@gmail.com', 'hind', 1, '2023-11-29', ''),
(21, 'Hema', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'hema@gmail.com', 'Hemaaaa', 1, '2023-11-29', ''),
(22, 'Sara', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'Sara@gmail.com', 'Sara Ahmed', 1, '2023-11-29', ''),
(23, 'KoKo', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'koko@gmail.com', 'KoKOKOK', 1, '2023-11-29', ''),
(24, 'Amrr', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'Amrr@gmail.com', 'Amrr Ahmed', 1, '2023-11-29', ''),
(27, 'Manar', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'manar@gmail.com', 'Manar Ali', 1, '2023-11-29', ''),
(29, 'yusf', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'ysuf@gmail.com', 'yusf', 0, '2023-12-01', ''),
(30, 'Yaso', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'yaso@gmail.com', 'Yaso', 1, '2023-11-30', ''),
(32, 'amll', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', 'amlelshorbagy@gmail.com', '', 0, '2023-12-14', ''),
(34, 'amlll', '8cb2237d0679ca88db6464eac60da96345513964', 'amlelshorbagy7@gmail.com', 'amlali', 1, '2023-12-14', ''),
(35, 'amola', '7c4a8d09ca3762af61e59520943dc26494f8941b', 'amlelshorbagy7@gmail.com', 'amlali', 1, '2023-12-14', ''),
(36, 'alii', '8cb2237d0679ca88db6464eac60da96345513964', 'amlelshorbagy7@gmail.com', 'amlali', 1, '2023-12-14', ''),
(39, 'abcd', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', 'abcd@gmail.com', '', 0, '2023-12-16', ''),
(40, 'aabb', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', 'aa@gmali.com', '', 0, '2023-12-16', ''),
(41, 'lool', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', 'lol@gmail.com', '', 0, '2023-12-16', ''),
(255, 'aml', '12345', 'aml@gmail.com', 'amlali', 0, '2023-12-09', ''),
(256, '1111', '011c945f30ce2cbafc452f39840f025693339c42', '1111@gmail.com', '', 0, '2024-01-28', ''),
(257, 'Mustafa Hamza', '601f1889667efaebb33b8c12572835da3f027f78', 'MustafaHamza@gmail.com', 'Mustafa Hamza', 1, '2024-01-28', '8080226028_user.png'),
(258, 'Ziad Ahmed', '601f1889667efaebb33b8c12572835da3f027f78', 'ZiadAhmed@gmail.com', 'Ziad Ahmed', 1, '2024-01-28', '7463365561_user.png'),
(259, 'Abdulrahman Ahmed', '601f1889667efaebb33b8c12572835da3f027f78', 'AbdulrahmanAhmed@gmail.com', 'Abdulrahman Ahmed', 1, '2024-01-28', '3586797728_user.png'),
(260, 'Basema', '601f1889667efaebb33b8c12572835da3f027f78', 'Basema@gmail.com', 'Basema', 1, '2024-01-28', '9122853203_user.png'),
(261, 'Aml Ali', '601f1889667efaebb33b8c12572835da3f027f78', 'AmlAli@gmail.com', 'Aml Ali', 1, '2024-01-28', '8377925273_user.png'),
(262, 'Abanoub Ragheb', '601f1889667efaebb33b8c12572835da3f027f78', 'AbanoubRagheb@gmail.com', 'Abanoub Ragheb', 1, '2024-01-28', '2065509644_user.png');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`adminid`),
  ADD UNIQUE KEY `adminid` (`adminid`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`c_id`),
  ADD KEY `items_comments` (`item_id`),
  ADD KEY `comment_user` (`user_id`);

--
-- Indexes for table `confirm-buy`
--
ALTER TABLE `confirm-buy`
  ADD PRIMARY KEY (`Confirmation_ID`),
  ADD KEY `member_confirm` (`Member_ID`),
  ADD KEY `item_confirm` (`Item_ID`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`Item_ID`),
  ADD KEY `member_1` (`Member_ID`),
  ADD KEY `cat_1` (`Cat_ID`);

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
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `adminid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `c_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `confirm-buy`
--
ALTER TABLE `confirm-buy`
  MODIFY `Confirmation_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=135;

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `Item_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT COMMENT 'To identify user', AUTO_INCREMENT=263;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comment_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`UserID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `items_comments` FOREIGN KEY (`item_id`) REFERENCES `items` (`Item_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `confirm-buy`
--
ALTER TABLE `confirm-buy`
  ADD CONSTRAINT `item_confirm` FOREIGN KEY (`Item_ID`) REFERENCES `items` (`Item_ID`),
  ADD CONSTRAINT `member_confirm` FOREIGN KEY (`Member_ID`) REFERENCES `users` (`UserID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `items`
--
ALTER TABLE `items`
  ADD CONSTRAINT `cat_1` FOREIGN KEY (`Cat_ID`) REFERENCES `categories` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `member_1` FOREIGN KEY (`Member_ID`) REFERENCES `users` (`UserID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
