-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Host: db
-- Generation Time: Jun 06, 2022 at 11:08 PM
-- Server version: 10.3.28-MariaDB-1:10.3.28+maria~focal
-- PHP Version: 8.0.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `flight_booking_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `airport_list`
--

CREATE TABLE `airport_list` (
  `id` int(30) NOT NULL,
  `airport` text NOT NULL,
  `location` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `airport_list`
--

INSERT INTO `airport_list` (`id`, `airport`, `location`) VALUES
(4, 'Dubai International Airport', 'Garhoud, Dubai'),
(6, 'CAI - Cairo Intl', 'Cairo, Egypt'),
(7, 'Hurghada (HRG - Hurghada Intl.)', 'Hurghada, Egypt'),
(8, 'Alexandria (HBE - Borg El Arab)', 'Alexandria, Egypt');

-- --------------------------------------------------------

--
-- Table structure for table `flight_list`
--

CREATE TABLE `flight_list` (
  `id` int(30) NOT NULL,
  `plane_no` text NOT NULL,
  `departure_airport_id` int(30) NOT NULL,
  `arrival_airport_id` int(30) NOT NULL,
  `departure_datetime` datetime NOT NULL,
  `arrival_datetime` datetime NOT NULL,
  `seats` int(10) NOT NULL DEFAULT 0,
  `price` double NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `flight_list`
--

INSERT INTO `flight_list` (`id`, `plane_no`, `departure_airport_id`, `arrival_airport_id`, `departure_datetime`, `arrival_datetime`, `seats`, `price`, `date_created`) VALUES
(1, 'DUB1', 4, 6, '2022-06-30 10:00:00', '2022-06-30 13:00:00', 150, 7500, '2020-09-25 11:23:52'),
(2, 'DUB2', 6, 4, '2022-07-10 10:00:00', '2022-07-10 12:00:00', 100, 5000, '2020-09-25 11:46:12'),
(3, 'CAI1', 6, 7, '2022-07-15 08:00:00', '2022-07-15 10:00:00', 100, 2500, '2020-09-25 11:57:31'),
(4, 'CAI2', 7, 6, '2022-07-30 12:00:00', '2020-07-30 15:00:00', 100, 2500, '2020-09-25 14:50:47'),
(5, 'DXB123', 8, 6, '2022-08-01 10:00:00', '2022-08-01 12:00:00', 150, 8000, '2020-09-25 11:23:52'),
(6, 'DXB321', 6, 8, '2022-08-10 10:00:00', '2022-08-10 12:00:00', 150, 9000, '2020-09-25 11:23:52');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(30) NOT NULL,
  `date_created` datetime NOT NULL,
  `date_updated` datetime DEFAULT NULL,
  `total` int(30) NOT NULL,
  `rate` int(30) DEFAULT NULL,
  `comment` varchar(255) DEFAULT NULL,
  `userId` int(30) NOT NULL,
  `isCanceled` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `date_created`, `date_updated`, `total`, `rate`, `comment`, `userId`, `isCanceled`) VALUES
(14, '2022-06-06 21:48:31', '2022-06-06 21:48:57', 18000, 4, 'It was good', 36, 1),
(15, '2022-06-06 21:52:14', NULL, 9000, NULL, NULL, 36, 0),
(16, '2022-06-06 22:31:30', NULL, 34500, NULL, NULL, 36, 0),
(17, '2022-06-06 23:36:04', '2022-06-06 23:57:44', 103500, 4, 'This was amazing ', 39, 0);

-- --------------------------------------------------------

--
-- Table structure for table `orders_flights`
--

CREATE TABLE `orders_flights` (
  `id` int(30) NOT NULL,
  `flightId` int(30) NOT NULL,
  `orderId` int(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `orders_flights`
--

INSERT INTO `orders_flights` (`id`, `flightId`, `orderId`) VALUES
(17, 6, 14),
(18, 6, 15),
(19, 1, 16),
(20, 6, 16),
(21, 3, 16),
(22, 5, 16),
(23, 2, 16),
(24, 4, 16),
(25, 1, 17),
(26, 3, 17),
(27, 5, 17),
(28, 2, 17),
(29, 4, 17),
(30, 6, 17);

-- --------------------------------------------------------

--
-- Table structure for table `orders_passengers`
--

CREATE TABLE `orders_passengers` (
  `id` int(30) NOT NULL,
  `name` varchar(255) NOT NULL,
  `nationalIdUrl` varchar(255) NOT NULL,
  `orderId` int(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `orders_passengers`
--

INSERT INTO `orders_passengers` (`id`, `name`, `nationalIdUrl`, `orderId`) VALUES
(6, 'youssef', '/uploads/BG.jpg', 11),
(7, 'moustafa', '/uploads/BG.jpg', 11),
(8, 'Yahya Nabil Salah', '/uploads/Profile Picture.jpg', 12),
(9, 'Mahmoud', '/uploads/', 12),
(10, 'Tamer', '/uploads/', 12),
(11, 'Donia', '/uploads/', 12),
(12, 'Mahmoud', '/uploads/', 13),
(13, 'Tamers', '/uploads/', 13),
(14, 'Mohamed', '/uploads/badges 1.png', 14),
(15, 'Ahmed', '/uploads/', 14),
(16, 'Mohamed', '/uploads/NID_1.jpg', 15),
(17, 'Mohamed', '/uploads/NID_1.jpg', 16),
(18, 'Mohamed', '/uploads/', 17),
(19, 'Ahmed', '/uploads/', 17),
(20, 'Asmaaa', '/uploads/', 17);

-- --------------------------------------------------------

--
-- Table structure for table `system_settings`
--

CREATE TABLE `system_settings` (
  `id` int(30) NOT NULL,
  `name` text NOT NULL,
  `email` varchar(200) NOT NULL,
  `contact` varchar(20) NOT NULL,
  `cover_img` text NOT NULL,
  `about_content` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `system_settings`
--

INSERT INTO `system_settings` (`id`, `name`, `email`, `contact`, `cover_img`, `about_content`) VALUES
(1, 'Online Flight Booking System', 'info@sample.comm', '+6948 8542 623', '1600998360_travel-cover.jpg', '&lt;p style=&quot;text-align: center; background: transparent; position: relative;&quot;&gt;&lt;span style=&quot;background: transparent; position: relative; font-size: 14px;&quot;&gt;&lt;span style=&quot;font-size:28px;background: transparent; position: relative;&quot;&gt;&lt;b style=&quot;margin: 0px; padding: 0px; color: rgb(0, 0, 0); font-family: &amp;quot;Open Sans&amp;quot;, Arial, sans-serif; text-align: justify;&quot;&gt;Lorem Ipsum&lt;/b&gt;&lt;span style=&quot;color: rgb(0, 0, 0); font-family: &amp;quot;Open Sans&amp;quot;, Arial, sans-serif; font-weight: 400; text-align: justify;&quot;&gt;&amp;nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&rsquo;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.&lt;/span&gt;&lt;br&gt;&lt;/span&gt;&lt;/p&gt;&lt;p style=&quot;text-align: center; background: transparent; position: relative;&quot;&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;&lt;/p&gt;');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(30) NOT NULL,
  `name` varchar(200) NOT NULL,
  `status` text NOT NULL COMMENT 'approved, pending',
  `email` varchar(100) NOT NULL,
  `password` varchar(200) NOT NULL,
  `role` varchar(255) NOT NULL DEFAULT 'customer' COMMENT 'customer, customerService, qualityControl',
  `isDisabled` tinyint(1) NOT NULL DEFAULT 0,
  `disabledComment` varchar(255) DEFAULT NULL,
  `nationalIdUrl` varchar(255) DEFAULT NULL,
  `pictureUrl` varchar(255) DEFAULT NULL,
  `nationalId` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `status`, `email`, `password`, `role`, `isDisabled`, `disabledComment`, `nationalIdUrl`, `pictureUrl`, `nationalId`) VALUES
(1, 'Administrator', '', 'admin@admin.com', 'admin123', 'qualityControl', 0, '', '', '', ''),
(36, 'Donia Sameh', 'approved', 'donia@donia.com', '123', 'customer', 0, '123', '/uploads/NID_1.jpg', '/uploads/PP.jpeg', NULL),
(37, 'Customer Service', 'approved', 'cs@cs.com', '123', 'qualityControl', 0, '123', NULL, NULL, NULL),
(38, 'Mohamed', 'approved', 'm@m.com', '123', 'customerService', 0, NULL, NULL, NULL, NULL),
(39, 'Donia Sameh', 'approved', 'donia@sameh.com', '123', 'customer', 1, 'Bad user.', '/uploads/NID_2.jpg', '/uploads/PP.jpeg', NULL),
(40, 'test', 'approved', 'test@test.com', '123', 'qualityControl', 0, NULL, NULL, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `airport_list`
--
ALTER TABLE `airport_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `flight_list`
--
ALTER TABLE `flight_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`);

--
-- Indexes for table `orders_flights`
--
ALTER TABLE `orders_flights`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders_passengers`
--
ALTER TABLE `orders_passengers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `system_settings`
--
ALTER TABLE `system_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `airport_list`
--
ALTER TABLE `airport_list`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `flight_list`
--
ALTER TABLE `flight_list`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `orders_flights`
--
ALTER TABLE `orders_flights`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `orders_passengers`
--
ALTER TABLE `orders_passengers`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `system_settings`
--
ALTER TABLE `system_settings`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
