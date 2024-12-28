-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 27, 2024 at 08:40 AM
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
-- Database: `oreep360`
--

-- --------------------------------------------------------

--
-- Table structure for table `agents`
--

CREATE TABLE `agents` (
  `agent_id` int(11) NOT NULL,
  `fullname` varchar(75) DEFAULT NULL,
  `contact_no` varchar(100) DEFAULT NULL,
  `email_address` varchar(50) DEFAULT NULL,
  `password` varchar(70) DEFAULT NULL,
  `1st_verification` varchar(25) DEFAULT 'Unverified',
  `2nd_verification` varchar(25) DEFAULT 'Unverified',
  `registration_date` datetime DEFAULT current_timestamp(),
  `profile_img` varchar(100) DEFAULT 'assets/images/unknown.png'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `agents`
--

INSERT INTO `agents` (`agent_id`, `fullname`, `contact_no`, `email_address`, `password`, `1st_verification`, `2nd_verification`, `registration_date`, `profile_img`) VALUES
(22505, 'Bongbong Marcos', '09123456781', 'marcos.bong@nmsc.edu.ph', 'bong2024', 'Verified', 'Unverified', '2024-12-11 03:23:49', 'assets/images/unknown.png'),
(43687, 'John Doe', '09123456789', 'johndoe@gmail.com', 'pass', 'Verified', 'Unverified', '2024-11-29 14:46:59', 'assets/images/unknown.png');

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `notification_id` int(11) NOT NULL,
  `_to` int(50) DEFAULT NULL,
  `content` text DEFAULT NULL,
  `remarks` varchar(25) DEFAULT 'Unread'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `properties`
--

CREATE TABLE `properties` (
  `property_id` int(11) NOT NULL,
  `agent_id` int(11) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `address` varchar(150) DEFAULT NULL,
  `price` int(11) NOT NULL,
  `map_latitude` varchar(50) DEFAULT NULL,
  `map_longitude` varchar(50) DEFAULT NULL,
  `cover_img` varchar(255) DEFAULT NULL,
  `show_to_clients` varchar(11) DEFAULT 'No'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `properties`
--

INSERT INTO `properties` (`property_id`, `agent_id`, `name`, `description`, `address`, `price`, `map_latitude`, `map_longitude`, `cover_img`, `show_to_clients`) VALUES
(4, 43687, 'NMSCST', 'SKWELAHAN', 'LABUYO, TANGUB CITY', 2342, '8.2361', '123.7214', 'uploads/properties/property_674ab780500434.70775001/Blue_Generals_Welcome.jpg', 'Yes');

-- --------------------------------------------------------

--
-- Table structure for table `property_amenities`
--

CREATE TABLE `property_amenities` (
  `amenity_id` int(11) NOT NULL,
  `property_id` int(11) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `property_amenities`
--

INSERT INTO `property_amenities` (`amenity_id`, `property_id`, `name`) VALUES
(9, 4, 'Free water'),
(15, 4, 'Free Wi-Fi'),
(18, 4, 'Free Youtube');

-- --------------------------------------------------------

--
-- Table structure for table `property_images`
--

CREATE TABLE `property_images` (
  `id` int(11) NOT NULL,
  `property_id` int(11) NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `uploaded_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `property_images`
--

INSERT INTO `property_images` (`id`, `property_id`, `image_path`, `uploaded_at`) VALUES
(1, 4, '../uploads/property_image_compilation/4/6763bd18387e1_bjjkbb.jpg', '2024-12-19 06:28:40'),
(2, 4, '../uploads/property_image_compilation/4/6763bd183a4e1_gkn.jpg', '2024-12-19 06:28:40'),
(3, 4, '../uploads/property_image_compilation/4/6763bd183c122_h.jpeg', '2024-12-19 06:28:40'),
(4, 4, '../uploads/property_image_compilation/4/6763bd183fa7a_gardening.jpg', '2024-12-19 06:28:40');

-- --------------------------------------------------------

--
-- Table structure for table `property_views`
--

CREATE TABLE `property_views` (
  `view_id` int(11) NOT NULL,
  `property_id` int(11) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `image_count` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `account_name` varchar(50) NOT NULL,
  `username` varchar(25) NOT NULL,
  `password` varchar(75) NOT NULL,
  `user_type` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `account_name`, `username`, `password`, `user_type`) VALUES
(1, 'admin', 'admin', 'pass', 'admin'),
(4, 'Sample', 'sample', '12345', 'user');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `agents`
--
ALTER TABLE `agents`
  ADD PRIMARY KEY (`agent_id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`notification_id`);

--
-- Indexes for table `properties`
--
ALTER TABLE `properties`
  ADD PRIMARY KEY (`property_id`);

--
-- Indexes for table `property_amenities`
--
ALTER TABLE `property_amenities`
  ADD PRIMARY KEY (`amenity_id`),
  ADD KEY `prop_id` (`property_id`);

--
-- Indexes for table `property_images`
--
ALTER TABLE `property_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `property_id` (`property_id`);

--
-- Indexes for table `property_views`
--
ALTER TABLE `property_views`
  ADD PRIMARY KEY (`view_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `properties`
--
ALTER TABLE `properties`
  MODIFY `property_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `property_amenities`
--
ALTER TABLE `property_amenities`
  MODIFY `amenity_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `property_images`
--
ALTER TABLE `property_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `property_views`
--
ALTER TABLE `property_views`
  MODIFY `view_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1715653914;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `property_amenities`
--
ALTER TABLE `property_amenities`
  ADD CONSTRAINT `prop_id` FOREIGN KEY (`property_id`) REFERENCES `properties` (`property_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `property_images`
--
ALTER TABLE `property_images`
  ADD CONSTRAINT `property_images_ibfk_1` FOREIGN KEY (`property_id`) REFERENCES `properties` (`property_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
