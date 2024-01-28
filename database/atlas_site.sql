-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 28, 2024 at 02:34 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.0.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `atlas_site`
--

-- --------------------------------------------------------

--
-- Table structure for table `budget_tracking`
--

CREATE TABLE `budget_tracking` (
  `id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `trip_name` varchar(100) NOT NULL,
  `category` varchar(100) NOT NULL,
  `amount` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `geotagged_locations`
--

CREATE TABLE `geotagged_locations` (
  `id` int(11) NOT NULL,
  `location_name` varchar(255) DEFAULT NULL,
  `latitude` decimal(10,8) DEFAULT NULL,
  `longitude` decimal(11,8) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roammates`
--

CREATE TABLE `roammates` (
  `id` int(11) NOT NULL,
  `follower` varchar(50) NOT NULL,
  `following` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `traveltips`
--

CREATE TABLE `traveltips` (
  `tip_id` int(11) NOT NULL,
  `tip` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `traveltips`
--

INSERT INTO `traveltips` (`tip_id`, `tip`) VALUES
(1, 'Pack light and only bring essentials.'),
(2, 'Research local customs and traditions before your trip.'),
(3, 'Keep important documents and valuables in a secure place.'),
(4, 'Try local cuisine to experience the culture.'),
(5, 'Check the weather forecast for your destination.'),
(6, 'Stay hydrated, especially in hot climates.'),
(7, 'Make a photocopy of your passport and keep it separately.'),
(8, 'Visit historical sites and landmarks to understand the local heritage.'),
(9, 'Have a basic first aid kit and necessary medications.'),
(10, 'Bring a power bank to keep your electronic devices charged.'),
(11, 'Keep a small emergency cash reserve in local currency.'),
(12, 'Capture memories but also take time to enjoy the moment.'),
(13, 'Take photos of important documents.'),
(14, 'Bring a versatile power adapter for your electronic devices.'),
(15, 'Pack a travel pillow or inflatable neck pillow for added comfort.'),
(16, 'Use a luggage tag with a clear cover for easy identification.'),
(17, 'Consider using packing lists to ensure you don’t forget essentials.'),
(18, 'Keep a journal to document your travel experiences and memories.'),
(19, 'Invest in comfortable and supportive travel shoes.');

-- --------------------------------------------------------

--
-- Table structure for table `trips`
--

CREATE TABLE `trips` (
  `trip_id` int(11) NOT NULL,
  `location` varchar(255) NOT NULL,
  `trip_name` varchar(255) NOT NULL,
  `email` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_posts`
--

CREATE TABLE `user_posts` (
  `id` int(11) NOT NULL,
  `type` varchar(15) NOT NULL,
  `title` varchar(100) NOT NULL,
  `text` text NOT NULL,
  `image` varchar(100) NOT NULL DEFAULT 'NULL',
  `rating` int(11) NOT NULL,
  `likes` int(11) NOT NULL,
  `email` varchar(20) NOT NULL,
  `location_name` varchar(255) NOT NULL,
  `latitude` decimal(10,8) NOT NULL,
  `longitude` decimal(11,8) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_profile`
--

CREATE TABLE `user_profile` (
  `email` varchar(50) NOT NULL,
  `firstName` varchar(50) NOT NULL,
  `lastName` varchar(50) NOT NULL,
  `password` varchar(15) NOT NULL,
  `profilePic` varchar(170) NOT NULL DEFAULT 'pfp/defaultpfp.jpg'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_profile`
--

INSERT INTO `user_profile` (`email`, `firstName`, `lastName`, `password`, `profilePic`) VALUES
('laiba@gmail.com', 'Laiba', 'Ijaz', '123456', 'pfp/defaultpfp.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `budget_tracking`
--
ALTER TABLE `budget_tracking`
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `geotagged_locations`
--
ALTER TABLE `geotagged_locations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roammates`
--
ALTER TABLE `roammates`
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `trips`
--
ALTER TABLE `trips`
  ADD PRIMARY KEY (`trip_id`);

--
-- Indexes for table `user_posts`
--
ALTER TABLE `user_posts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_profile`
--
ALTER TABLE `user_profile`
  ADD PRIMARY KEY (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `budget_tracking`
--
ALTER TABLE `budget_tracking`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `geotagged_locations`
--
ALTER TABLE `geotagged_locations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `roammates`
--
ALTER TABLE `roammates`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `trips`
--
ALTER TABLE `trips`
  MODIFY `trip_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `user_posts`
--
ALTER TABLE `user_posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
