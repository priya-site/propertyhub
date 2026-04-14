-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 07, 2026 at 10:26 AM
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
-- Database: `propertyhub`
--

-- --------------------------------------------------------

--
-- Table structure for table `brokers`
--

CREATE TABLE `brokers` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `contact` varchar(15) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `brokers`
--

INSERT INTO `brokers` (`id`, `name`, `email`, `password`, `contact`, `user_id`) VALUES
(1, 'Kishori Bait', 'kishori@gmail.com', '$2y$10$7VgSU4I0W/TzF96VR.wvZeSydlElK0sUlZKYMcGADz.jfeYQgIIoa', '9145768456', 6),
(2, 'Divyal ', 'divyal@gmail.com', '$2y$10$CCgVzTZ6QpabjQCt7MfCQOoecLGPKEtwW7RF9z7ct3bgtgxSSOoay', '2546576863', 7),
(3, 'Aditi', 'aditi@gmail.com', '$2y$10$PD2JUlaVnk4.fI3yKnO28O12LIH02H2EKhYrPzIUqxr6vJuVwe13q', '2544658863', 8);

-- --------------------------------------------------------

--
-- Table structure for table `broker_leads`
--

CREATE TABLE `broker_leads` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `broker_id` int(11) DEFAULT NULL,
  `property_id` int(11) NOT NULL,
  `property_name` varchar(255) DEFAULT NULL,
  `client_name` varchar(255) DEFAULT NULL,
  `contact` varchar(20) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `status` varchar(50) DEFAULT 'New',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `payment_status` varchar(50) DEFAULT 'not_requested',
  `deal_status` varchar(50) DEFAULT 'open',
  `price` bigint(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `broker_leads`
--

INSERT INTO `broker_leads` (`id`, `user_id`, `broker_id`, `property_id`, `property_name`, `client_name`, `contact`, `email`, `message`, `status`, `created_at`, `payment_status`, `deal_status`, `price`) VALUES
(21, 18, 19, 8, 'Beach House', 'Priya Gupta', '9184769846', 'priya@gmail.com', 'Hii! I am interested in this property.', 'Closed', '2026-04-07 06:16:08', 'paid', 'open', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `earnings`
--

CREATE TABLE `earnings` (
  `id` int(11) NOT NULL,
  `owner_id` int(11) DEFAULT NULL,
  `property_id` int(11) DEFAULT NULL,
  `property_name` varchar(255) DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `status` enum('completed') NOT NULL DEFAULT 'completed',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `earnings`
--

INSERT INTO `earnings` (`id`, `owner_id`, `property_id`, `property_name`, `amount`, `status`, `created_at`) VALUES
(50, 14, 5, 'Commercial Office', 14000000.00, 'completed', '2026-04-07 06:13:23');

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `rating` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `gender` enum('male','female') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `feedback`
--

INSERT INTO `feedback` (`id`, `name`, `message`, `rating`, `created_at`, `gender`) VALUES
(7, 'Aditi', 'Excellent service! Found my dream villa.', 5, '2026-03-25 07:22:00', 'female'),
(8, 'soham', 'Very smooth experience and great support.', 4, '2026-03-25 07:28:42', 'male'),
(9, 'Savi', 'Great investment platform! Highly recommended.', 4, '2026-03-25 07:29:27', 'female'),
(10, 'Parth', 'Amazing property options and transparent dealing.', 5, '2026-03-25 07:29:49', 'male'),
(11, 'Aditya', 'PropertyHub made buying stress-free and easy.', 4, '2026-03-25 07:30:18', 'male');

-- --------------------------------------------------------

--
-- Table structure for table `inquiries`
--

CREATE TABLE `inquiries` (
  `id` int(11) NOT NULL,
  `owner_id` int(11) DEFAULT NULL,
  `property_name` varchar(255) DEFAULT NULL,
  `customer_name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `status` varchar(20) DEFAULT 'New',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `message` text NOT NULL,
  `property_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `payment_status` enum('not_requested','pending','paid') DEFAULT 'not_requested'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `inquiries`
--

INSERT INTO `inquiries` (`id`, `owner_id`, `property_name`, `customer_name`, `email`, `phone`, `status`, `created_at`, `message`, `property_id`, `user_id`, `payment_status`) VALUES
(48, 14, 'Commercial Office', 'Priya Gupta', 'priya@gmail.com', '9184769846', 'Completed', '2026-04-07 06:13:23', 'Hii! I am interested in this property.', 5, 18, 'paid');

-- --------------------------------------------------------

--
-- Table structure for table `owners`
--

CREATE TABLE `owners` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `contact` varchar(15) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `owners`
--

INSERT INTO `owners` (`id`, `name`, `email`, `password`, `contact`, `user_id`) VALUES
(1, 'Sakshi Sakharkar', 'sakshi@gmail.com', '$2y$10$T0oxsUaHmD/FSjr0kgW/HOpFsIP5.g.qb8p2meAKD/zABH6CIZD6K', '9134657698', 5),
(2, 'Sejal Gupta ', 'sejal@gmail.com', '$2y$10$r6W15c2xfeGDsDXjgtAYsu6l/tL3ql0ryMlwv3Q9wPrjDZ2t1RU7.', '9134657095', 6),
(4, 'Sneha Gupta', 'sneha@gmail.com', '$2y$10$dHJdqCjQTu3AxbpgepeScuk59WhXyd14rZ6CRf.iB9qZuhl7ALRri', '2546576863', 7),
(5, 'Karan Gupta', 'karan@gmail.com', '$2y$10$qWMa7A5NXIV2o4.L2jl2Xe9iEaLrQEpi0PlseS8jNVWhD8q//lFGW', '2546576863', 8);

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` int(11) NOT NULL,
  `lead_id` int(11) DEFAULT NULL,
  `broker_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `status` varchar(50) DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `property_id` int(11) DEFAULT NULL,
  `owner_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`id`, `lead_id`, `broker_id`, `user_id`, `amount`, `status`, `created_at`, `property_id`, `owner_id`) VALUES
(46, NULL, NULL, 18, 14000000.00, 'paid', '2026-04-07 06:14:33', 5, 14),
(47, 21, 19, 18, 25000000.00, 'pending', '2026-04-07 06:16:47', 8, NULL),
(48, NULL, 19, 18, 25000000.00, 'paid', '2026-04-07 06:17:26', 8, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `properties`
--

CREATE TABLE `properties` (
  `id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `price` bigint(100) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `bedrooms` int(11) DEFAULT NULL,
  `bathrooms` int(11) DEFAULT NULL,
  `area` varchar(50) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `owner_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `property_type` varchar(50) DEFAULT NULL,
  `listing_type` varchar(20) DEFAULT NULL,
  `broker_id` int(11) DEFAULT NULL,
  `status` varchar(20) DEFAULT 'Active',
  `amenities` text DEFAULT NULL,
  `parking` enum('Yes','No') DEFAULT NULL,
  `images` text DEFAULT NULL,
  `video` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `properties`
--

INSERT INTO `properties` (`id`, `title`, `location`, `price`, `image`, `bedrooms`, `bathrooms`, `area`, `description`, `owner_id`, `created_at`, `property_type`, `listing_type`, `broker_id`, `status`, `amenities`, `parking`, `images`, `video`) VALUES
(3, 'Luxury Villa', 'Mumbai, Maharashtra', 12000000, 'uploads/pl-img1.png', 3, 2, '1550', 'Beautiful luxury villa with modern design feature floor-to-ceiling glass facades, double-height living rooms, and custom infinity pools that overlook scenic landscapes.', 14, '2026-03-14 08:00:11', 'Villa', 'Rent', NULL, 'Active', '🏊Swimming Pool 🏋 Gym 🌳 Garden 🔐 24x7 Security 🛗 Lift ⚡ Power Backup', 'Yes', 'https://images.pexels.com/photos/6957083/pexels-photo-6957083.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/8082330/pexels-photo-8082330.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/8134753/pexels-photo-8134753.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/6076854/pexels-photo-6076854.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/8082304/pexels-photo-8082304.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/6283973/pexels-photo-6283973.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/7061670/pexels-photo-7061670.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/7061392/pexels-photo-7061392.jpeg?auto=compress&cs=tinysrgb&h=350', 'https://videos.pexels.com/video-files/7578546/7578546-uhd_2560_1440_30fps.mp4'),
(4, 'Modern Apartment', 'Pune, Maharashtra', 2000000, 'uploads/pl-img2.png', 2, 2, '1550', 'Stylish apartment in city center, Built-in planters, vertical gardens, and large windows that frame outdoor greenery to improve mental well-being.', 14, '2026-03-14 08:02:18', 'Apartment', 'Rent', NULL, 'Active', '🏊Swimming Pool 🏋 Gym 🌳 Garden 🔐 24x7 Security 🛗 Lift ⚡ Power Backup', 'Yes', 'https://images.pexels.com/photos/7511701/pexels-photo-7511701.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/7031708/pexels-photo-7031708.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/6970049/pexels-photo-6970049.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/17832175/pexels-photo-17832175.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/7546561/pexels-photo-7546561.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/5712145/pexels-photo-5712145.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/6508347/pexels-photo-6508347.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/8146333/pexels-photo-8146333.jpeg?auto=compress&cs=tinysrgb&h=350', 'https://videos.pexels.com/video-files/7578546/7578546-uhd_2560_1440_30fps.mp4'),
(5, 'Commercial Office', 'Delhi, India', 14000000, 'uploads/pl-img3.png', 0, 2, '1450', 'High-end corporate lobbies often use marble countertops, gold accents, and integrated green walls to create a welcoming first impression.', 14, '2026-03-14 08:04:07', 'Office', 'Sale', NULL, 'Sold', ' 🏋 Gym 🌳 Garden 🔐 24x7 Security 🛗 Lift ⚡ Power Backup', 'Yes', 'https://images.pexels.com/photos/13051216/pexels-photo-13051216.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/10161225/pexels-photo-10161225.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/7195880/pexels-photo-7195880.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/5710711/pexels-photo-5710711.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/32255385/pexels-photo-32255385.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/5511084/pexels-photo-5511084.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/8477424/pexels-photo-8477424.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/8477453/pexels-photo-8477453.jpeg?auto=compress&cs=tinysrgb&h=350', 'https://videos.pexels.com/video-files/8293312/8293312-sd_640_360_30fps.mp4'),
(7, 'Family House', 'Banglore, India', 16000000, 'uploads/1775280564_house3.png', 2, 2, '1550', 'Green features like solar roofing, rainwater harvesting, and locally sourced stone are now standard in middle-class projects, not just luxury villas.', NULL, '2026-03-14 08:12:17', 'House', 'Sale', 19, 'Active', ' 🏋 Gym 🌳 Garden 🔐 24x7 Security 🛗 Lift ⚡ Power Backup', 'Yes', 'https://images.pexels.com/photos/19980227/pexels-photo-19980227.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/280239/pexels-photo-280239.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/34569488/pexels-photo-34569488.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/7546767/pexels-photo-7546767.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/11209666/pexels-photo-11209666.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/7061664/pexels-photo-7061664.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/8504308/pexels-photo-8504308.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/8143712/pexels-photo-8143712.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/7220420/pexels-photo-7220420.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/12277297/pexels-photo-12277297.jpeg?auto=compress&cs=tinysrgb&h=350', 'https://videos.pexels.com/video-files/7578117/7578117-sd_960_540_30fps.mp4'),
(8, 'Beach House', 'Goa, India', 25000000, 'uploads/pl-img5.png', 2, 2, '1450', 'Physical beach houses are homes designed for seaside living, often featuring specialized materials to withstand salt air and sand.', NULL, '2026-03-14 08:24:09', 'House', 'Rent', 19, 'Sold', ' 🏋 Gym 🌳 Garden 🔐 24x7 Security 🛗 Lift ⚡ Power Backup', 'Yes', 'https://images.pexels.com/photos/271654/pexels-photo-271654.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/3935351/pexels-photo-3935351.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/280239/pexels-photo-280239.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/34787741/pexels-photo-34787741.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/4221390/pexels-photo-4221390.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/36777837/pexels-photo-36777837.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/4221389/pexels-photo-4221389.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/4119835/pexels-photo-4119835.jpeg?auto=compress&cs=tinysrgb&h=350', 'https://videos.pexels.com/video-files/7578117/7578117-sd_960_540_30fps.mp4'),
(9, 'Budget Flat', 'Indore, India', 12000000, 'uploads/pl-img6.png', 4, 2, '1450', 'Modern budget projects now include basic lifestyle features like gated security, 24/7 water supply, elevators, and small landscaped gardens or play areas.', NULL, '2026-03-14 08:29:08', 'Flat', 'Sale', 19, 'Active', ' 🏋 Gym 🌳 Garden 🔐 24x7 Security 🛗 Lift ⚡ Power Backup', 'Yes', 'https://images.pexels.com/photos/13722890/pexels-photo-13722890.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/30469367/pexels-photo-30469367.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/14614673/pexels-photo-14614673.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/6180673/pexels-photo-6180673.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/10758468/pexels-photo-10758468.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/4716791/pexels-photo-4716791.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/6890396/pexels-photo-6890396.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/4716789/pexels-photo-4716789.jpeg?auto=compress&cs=tinysrgb&h=350', 'https://videos.pexels.com/video-files/7578117/7578117-sd_960_540_30fps.mp4'),
(10, 'Commercial Office', 'Delhi, India', 16000000, 'uploads/pl-img7.png', 0, 4, '1550', 'A large, established office in the West known for offering a mix of residential and dedicated commercial spaces', 21, '2026-03-14 08:33:19', 'Office', 'Sale', NULL, 'Active', '🏊Swimming Pool 🏋 Gym 🌳 Garden 🔐 24x7 Security 🛗 Lift ⚡ Power Backup', 'Yes', 'https://images.pexels.com/photos/13051216/pexels-photo-13051216.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/10161225/pexels-photo-10161225.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/7195880/pexels-photo-7195880.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/5710711/pexels-photo-5710711.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/32255385/pexels-photo-32255385.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/5511084/pexels-photo-5511084.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/8477424/pexels-photo-8477424.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/8477453/pexels-photo-8477453.jpeg?auto=compress&cs=tinysrgb&h=350', 'https://videos.pexels.com/video-files/8293312/8293312-sd_640_360_30fps.mp4'),
(11, 'Luxury Pent House', 'Mumbai, Maharashtra', 25000000, 'uploads/pl-img8.png', 4, 3, '1550', 'A preferred stretch for new high-rise towers due to planned infrastructure upgrades and wider roads', 21, '2026-03-14 08:35:06', 'House', 'Sale', NULL, 'Active', '🏊Swimming Pool 🏋 Gym 🌳 Garden 🔐 24x7 Security 🛗 Lift ⚡ Power Backup', 'Yes', 'https://images.pexels.com/photos/271654/pexels-photo-271654.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/3935351/pexels-photo-3935351.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/280239/pexels-photo-280239.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/34787741/pexels-photo-34787741.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/4221390/pexels-photo-4221390.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/36777837/pexels-photo-36777837.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/4221389/pexels-photo-4221389.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/4119835/pexels-photo-4119835.jpeg?auto=compress&cs=tinysrgb&h=350', 'https://videos.pexels.com/video-files/7578117/7578117-sd_960_540_30fps.mp4'),
(13, 'Studio Apartment', 'Banglore, India', 2000000, 'uploads/pl-img10.png', 5, 4, '1850', 'A premium 18-storey tower offering \"Luxury 1 RK\" units with modern rooftop amenities. It is highly rated for its budget-friendly pricing and central location near D-Mart', NULL, '2026-03-14 08:39:16', 'Apartment', 'Rent', 23, 'Active', '🏊Swimming Pool 🏋 Gym 🌳 Garden 🔐 24x7 Security 🛗 Lift ⚡ Power Backup', 'Yes', 'https://images.pexels.com/photos/7511701/pexels-photo-7511701.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/7031708/pexels-photo-7031708.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/6970049/pexels-photo-6970049.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/17832175/pexels-photo-17832175.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/7546561/pexels-photo-7546561.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/5712145/pexels-photo-5712145.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/6508347/pexels-photo-6508347.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/8146333/pexels-photo-8146333.jpeg?auto=compress&cs=tinysrgb&h=350', 'https://videos.pexels.com/video-files/7578546/7578546-uhd_2560_1440_30fps.mp4'),
(14, 'Residential Plot', 'Ahemdabad, India', 32000000, 'uploads/pl-img11.png', 5, 3, '1650', 'Densely populated urban zones where smaller, high-value residential plots are found near the station.', NULL, '2026-03-14 08:40:50', 'Plot', 'Sale', 23, 'Active', '🏊Swimming Pool 🏋 Gym 🌳 Garden 🔐 24x7 Security 🛗 Lift ⚡ Power Backup', 'Yes', 'https://images.pexels.com/photos/31737858/pexels-photo-31737858.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/14614673/pexels-photo-14614673.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/34717351/pexels-photo-34717351.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/34538288/pexels-photo-34538288.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/30925021/pexels-photo-30925021.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/16869704/pexels-photo-16869704.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/16056401/pexels-photo-16056401.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/31362244/pexels-photo-31362244.jpeg?auto=compress&cs=tinysrgb&h=350', 'https://videos.pexels.com/video-files/7578546/7578546-uhd_2560_1440_30fps.mp4'),
(15, 'Duplex Villa', 'Hyderabad, India', 4000000, 'uploads/pl-img12.png', 5, 4, '1650', 'A 5BHK luxury villa built on 3,000 sq. ft. of land. It features an attached spacious deck, high-end interior design, and views of both the water and mountains.', NULL, '2026-03-14 08:42:07', 'Villa', 'Rent', 23, 'Active', '🏊Swimming Pool 🏋 Gym 🌳 Garden 🔐 24x7 Security 🛗 Lift ⚡ Power Backup', 'Yes', 'https://images.pexels.com/photos/6957083/pexels-photo-6957083.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/8082330/pexels-photo-8082330.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/8134753/pexels-photo-8134753.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/6076854/pexels-photo-6076854.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/8082304/pexels-photo-8082304.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/6283973/pexels-photo-6283973.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/7061670/pexels-photo-7061670.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/7061392/pexels-photo-7061392.jpeg?auto=compress&cs=tinysrgb&h=350', 'https://videos.pexels.com/video-files/7578546/7578546-uhd_2560_1440_30fps.mp4'),
(16, 'Lake View House', 'Udaipur, India', 25000000, 'uploads/pl-img13.png', 5, 3, '1650', 'Modern lake houses often feature floor-to-ceiling windows to maximize natural light and blur the lines between indoor and outdoor living. ', 22, '2026-03-16 04:49:37', 'House', 'Sale', NULL, 'Active', '🏊Swimming Pool 🏋 Gym 🌳 Garden 🔐 24x7 Security 🛗 Lift ⚡ Power Backup', 'Yes', 'https://images.pexels.com/photos/271654/pexels-photo-271654.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/3935351/pexels-photo-3935351.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/280239/pexels-photo-280239.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/34787741/pexels-photo-34787741.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/4221390/pexels-photo-4221390.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/36777837/pexels-photo-36777837.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/4221389/pexels-photo-4221389.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/4119835/pexels-photo-4119835.jpeg?auto=compress&cs=tinysrgb&h=350', 'https://videos.pexels.com/video-files/7578117/7578117-sd_960_540_30fps.mp4'),
(17, 'IT Park Office', 'Gurgaon, India', 25000000, 'uploads/pl-img14.png', 0, 4, '1850', 'IT park offices are evolving from traditional desk-heavy environments into \"destination workspaces\" that prioritise employee well-being, flexible layouts, and high-tech integration.', NULL, '2026-03-16 04:52:07', 'Office', 'Sale', 24, 'Active', '🏋 Gym 🌳 Garden 🔐 24x7 Security 🛗 Lift ⚡ Power Backup', 'No', 'https://images.pexels.com/photos/13051216/pexels-photo-13051216.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/10161225/pexels-photo-10161225.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/7195880/pexels-photo-7195880.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/5710711/pexels-photo-5710711.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/32255385/pexels-photo-32255385.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/5511084/pexels-photo-5511084.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/8477424/pexels-photo-8477424.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/8477453/pexels-photo-8477453.jpeg?auto=compress&cs=tinysrgb&h=350', 'https://videos.pexels.com/video-files/8293312/8293312-sd_640_360_30fps.mp4'),
(18, 'Hill Station Cottage', 'Manali, India', 2000000, 'uploads/pl-img15.png', 3, 2, '1550', 'A hill station cottage captures the essence of mountain living, ranging from heritage colonial bungalows to modern prefabricated A-frame designs.', NULL, '2026-03-16 04:53:38', 'House', 'Rent', 24, 'Active', '🏊Swimming Pool 🏋 Gym 🌳 Garden 🔐 24x7 Security 🛗 Lift ⚡ Power Backup', 'Yes', 'https://images.pexels.com/photos/271654/pexels-photo-271654.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/3935351/pexels-photo-3935351.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/280239/pexels-photo-280239.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/34787741/pexels-photo-34787741.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/4221390/pexels-photo-4221390.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/36777837/pexels-photo-36777837.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/4221389/pexels-photo-4221389.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/4119835/pexels-photo-4119835.jpeg?auto=compress&cs=tinysrgb&h=350', 'https://videos.pexels.com/video-files/7578117/7578117-sd_960_540_30fps.mp4'),
(20, 'Farm House', 'Jaipur, India', 52000000, 'uploads/pl-img9.png', 4, 3, '1850', 'A blend of rustic charm with contemporary elements like large windows and open layouts. Known for delicious food, clean rooms, and spacious group offers.', 21, '2026-03-17 08:31:07', 'House', 'Rent', NULL, 'Active', '🏊Swimming Pool 🏋 Gym 🌳 Garden 🔐 24x7 Security 🛗 Lift ⚡ Power Backup', 'Yes', 'https://images.pexels.com/photos/271654/pexels-photo-271654.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/3935351/pexels-photo-3935351.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/280239/pexels-photo-280239.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/34787741/pexels-photo-34787741.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/4221390/pexels-photo-4221390.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/36777837/pexels-photo-36777837.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/4221389/pexels-photo-4221389.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/4119835/pexels-photo-4119835.jpeg?auto=compress&cs=tinysrgb&h=350', 'https://videos.pexels.com/video-files/7578117/7578117-sd_960_540_30fps.mp4'),
(21, 'Studio Flats', 'Banglore, India', 2000000, 'uploads/flat1.png', 2, 1, '1450', 'It is a self-contained unit where the living room, bedroom, and kitchen are integrated into a single open space, with only the bathroom being separate.', 14, '2026-03-18 06:21:56', 'Flat', 'Rent', NULL, 'Active', '🏊Swimming Pool 🏋 Gym 🌳 Garden 🔐 24x7 Security 🛗 Lift ⚡ Power Backup', 'Yes', 'https://images.pexels.com/photos/13722890/pexels-photo-13722890.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/30469367/pexels-photo-30469367.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/14614673/pexels-photo-14614673.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/6180673/pexels-photo-6180673.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/10758468/pexels-photo-10758468.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/4716791/pexels-photo-4716791.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/6890396/pexels-photo-6890396.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/4716789/pexels-photo-4716789.jpeg?auto=compress&cs=tinysrgb&h=350', 'https://videos.pexels.com/video-files/7578117/7578117-sd_960_540_30fps.mp4'),
(22, 'Plot', 'Manali, India', 4000000, 'uploads/land1.png', 3, 3, '1850', 'This is a precise, technical record used in official documents like the Sale Deed or 7/12 Extract.', 14, '2026-03-18 06:24:50', 'Plot', 'Sale', NULL, 'Active', '🏊Swimming Pool 🏋 Gym 🌳 Garden 🔐 24x7 Security 🛗 Lift ⚡ Power Backup', 'Yes', 'https://images.pexels.com/photos/31737858/pexels-photo-31737858.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/14614673/pexels-photo-14614673.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/34717351/pexels-photo-34717351.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/34538288/pexels-photo-34538288.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/30925021/pexels-photo-30925021.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/16869704/pexels-photo-16869704.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/16056401/pexels-photo-16056401.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/31362244/pexels-photo-31362244.jpeg?auto=compress&cs=tinysrgb&h=350', 'https://videos.pexels.com/video-files/7578546/7578546-uhd_2560_1440_30fps.mp4'),
(23, 'Apartment', 'Andheri, India', 16000000, 'uploads/Apt1.png', 4, 3, '1850', 'Highlight what makes life easier—modular kitchen, piped gas, 24/7 water, power backup, or lift access.', 14, '2026-03-18 06:28:01', 'Apartment', 'Rent', NULL, 'Active', '🏊Swimming Pool 🏋 Gym 🌳 Garden 🔐 24x7 Security 🛗 Lift ⚡ Power Backup', 'Yes', 'https://images.pexels.com/photos/7511701/pexels-photo-7511701.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/7031708/pexels-photo-7031708.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/6970049/pexels-photo-6970049.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/17832175/pexels-photo-17832175.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/7546561/pexels-photo-7546561.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/5712145/pexels-photo-5712145.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/6508347/pexels-photo-6508347.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/8146333/pexels-photo-8146333.jpeg?auto=compress&cs=tinysrgb&h=350', 'https://videos.pexels.com/video-files/7578546/7578546-uhd_2560_1440_30fps.mp4'),
(24, 'Duplex Flat', 'Mumbai, Maharashtra', 52000000, 'uploads/flat2.png', 4, 4, '1850', 'Typically houses the living room, dining area, kitchen, and guest bedroom. Usually reserved for private family space, such as the master bedrooms and a study.', 21, '2026-03-18 06:31:07', 'Flat', 'Sale', NULL, 'Active', '🏊Swimming Pool 🏋 Gym 🌳 Garden 🔐 24x7 Security 🛗 Lift ⚡ Power Backup', 'Yes', 'https://images.pexels.com/photos/13722890/pexels-photo-13722890.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/30469367/pexels-photo-30469367.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/14614673/pexels-photo-14614673.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/6180673/pexels-photo-6180673.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/10758468/pexels-photo-10758468.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/4716791/pexels-photo-4716791.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/6890396/pexels-photo-6890396.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/4716789/pexels-photo-4716789.jpeg?auto=compress&cs=tinysrgb&h=350', 'https://videos.pexels.com/video-files/7578117/7578117-sd_960_540_30fps.mp4'),
(25, 'Office', 'Banglore, India', 52000000, 'uploads/Office.png', 0, 5, '1850', 'Start with the business advantage (e.g., \"Main Road Facing Office\" or \"Modern Corporate Hub\"). Mention the number of cabins, workstations, a reception area, and a private washroom.', 21, '2026-03-18 06:34:38', 'Office', 'Rent', NULL, 'Active', '🏊Swimming Pool 🏋 Gym 🌳 Garden 🔐 24x7 Security 🛗 Lift ⚡ Power Backup', 'Yes', 'https://images.pexels.com/photos/13051216/pexels-photo-13051216.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/10161225/pexels-photo-10161225.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/7195880/pexels-photo-7195880.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/5710711/pexels-photo-5710711.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/32255385/pexels-photo-32255385.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/5511084/pexels-photo-5511084.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/8477424/pexels-photo-8477424.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/8477453/pexels-photo-8477453.jpeg?auto=compress&cs=tinysrgb&h=350', 'https://videos.pexels.com/video-files/8293312/8293312-sd_640_360_30fps.mp4'),
(26, 'Cluster Villa ', 'Goa, India', 16000000, 'uploads/villa1.png', 5, 4, '1550', 'Cluster villas are often semi-detached or terraced, sharing one or two walls with neighbours in a \"four-leaf clover\" or T-shaped arrangement.', 21, '2026-03-18 06:37:32', 'Villa', 'Rent', NULL, 'Active', '🏊Swimming Pool 🏋 Gym 🌳 Garden 🔐 24x7 Security 🛗 Lift ⚡ Power Backup', 'Yes', 'https://images.pexels.com/photos/6957083/pexels-photo-6957083.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/8082330/pexels-photo-8082330.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/8134753/pexels-photo-8134753.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/6076854/pexels-photo-6076854.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/8082304/pexels-photo-8082304.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/6283973/pexels-photo-6283973.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/7061670/pexels-photo-7061670.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/7061392/pexels-photo-7061392.jpeg?auto=compress&cs=tinysrgb&h=350', 'https://videos.pexels.com/video-files/7578546/7578546-uhd_2560_1440_30fps.mp4'),
(27, 'Rented Flats', 'Delhi, India', 2000000, 'uploads/flat3.png', 3, 2, '1850', 'Clearly state if it is Unfurnished (basic lights/fans), Semi-Furnished (wardrobes/modular kitchen), or Fully Furnished (beds, AC, fridge, sofa).', 22, '2026-03-18 06:39:41', 'Flat', 'Rent', NULL, 'Active', '🏊Swimming Pool 🏋 Gym 🌳 Garden 🔐 24x7 Security 🛗 Lift ⚡ Power Backup', 'Yes', 'https://images.pexels.com/photos/13722890/pexels-photo-13722890.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/30469367/pexels-photo-30469367.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/14614673/pexels-photo-14614673.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/6180673/pexels-photo-6180673.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/10758468/pexels-photo-10758468.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/4716791/pexels-photo-4716791.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/6890396/pexels-photo-6890396.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/4716789/pexels-photo-4716789.jpeg?auto=compress&cs=tinysrgb&h=350', 'https://videos.pexels.com/video-files/7578117/7578117-sd_960_540_30fps.mp4'),
(28, 'Parallel Plot', 'Mumbai, Maharashtra', 52000000, 'uploads/land2.png', 4, 4, '1450', 'Unlike corner plots, parallel plots are flanked by neighbours on two sides, which reduces exposure to passing traffic and noise from street intersections.', 22, '2026-03-18 06:41:20', 'Plot', 'Sale', NULL, 'Active', '🏊Swimming Pool 🏋 Gym 🌳 Garden 🔐 24x7 Security 🛗 Lift ⚡ Power Backup', 'Yes', 'https://images.pexels.com/photos/31737858/pexels-photo-31737858.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/14614673/pexels-photo-14614673.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/34717351/pexels-photo-34717351.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/34538288/pexels-photo-34538288.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/30925021/pexels-photo-30925021.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/16869704/pexels-photo-16869704.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/16056401/pexels-photo-16056401.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/31362244/pexels-photo-31362244.jpeg?auto=compress&cs=tinysrgb&h=350', 'https://videos.pexels.com/video-files/7578546/7578546-uhd_2560_1440_30fps.mp4'),
(29, 'Loft Apartments', 'Banglore, India', 4000000, 'uploads/Apt2.png', 3, 3, '1850', 'Highlight raw materials—exposed brick walls, polished concrete floors, visible ductwork, and massive factory-style windows.', 22, '2026-03-18 06:45:46', 'Apartment', 'Sale', NULL, 'Active', '🏊Swimming Pool 🏋 Gym 🌳 Garden 🔐 24x7 Security 🛗 Lift ⚡ Power Backup', 'Yes', 'https://images.pexels.com/photos/7511701/pexels-photo-7511701.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/7031708/pexels-photo-7031708.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/6970049/pexels-photo-6970049.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/17832175/pexels-photo-17832175.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/7546561/pexels-photo-7546561.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/5712145/pexels-photo-5712145.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/6508347/pexels-photo-6508347.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/8146333/pexels-photo-8146333.jpeg?auto=compress&cs=tinysrgb&h=350', 'https://videos.pexels.com/video-files/7578546/7578546-uhd_2560_1440_30fps.mp4'),
(30, 'Private Office', 'Goa, India', 16000000, 'uploads/Office2.png', 0, 5, '1850', 'Highlight that it’s \"ready-to-move\" with pre-installed high-speed internet (LAN/Wi-Fi), ergonomic furniture, and dedicated AC controls.', 22, '2026-03-18 06:48:19', 'Office', 'Sale', NULL, 'Active', '🏊Swimming Pool 🏋 Gym 🌳 Garden 🔐 24x7 Security 🛗 Lift ⚡ Power Backup', 'Yes', 'https://images.pexels.com/photos/13051216/pexels-photo-13051216.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/10161225/pexels-photo-10161225.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/7195880/pexels-photo-7195880.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/5710711/pexels-photo-5710711.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/32255385/pexels-photo-32255385.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/5511084/pexels-photo-5511084.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/8477424/pexels-photo-8477424.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/8477453/pexels-photo-8477453.jpeg?auto=compress&cs=tinysrgb&h=350', 'https://videos.pexels.com/video-files/8293312/8293312-sd_640_360_30fps.mp4'),
(31, 'Triplex Villa', 'Banglore, India', 25000000, 'uploads/villa2.png', 4, 3, '1550', 'Usually the \"Public Zone\"—Double-height living room, formal dining, kitchen, and guest suite. The \"Family Zone\"—Master bedrooms, kids\' rooms, and a cozy family lounge.', 22, '2026-03-18 06:50:40', 'Villa', 'Rent', NULL, 'Active', '🏊Swimming Pool 🏋 Gym 🌳 Garden 🔐 24x7 Security 🛗 Lift ⚡ Power Backup', 'Yes', 'https://images.pexels.com/photos/6957083/pexels-photo-6957083.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/8082330/pexels-photo-8082330.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/8134753/pexels-photo-8134753.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/6076854/pexels-photo-6076854.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/8082304/pexels-photo-8082304.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/6283973/pexels-photo-6283973.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/7061670/pexels-photo-7061670.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/7061392/pexels-photo-7061392.jpeg?auto=compress&cs=tinysrgb&h=350', 'https://videos.pexels.com/video-files/7578546/7578546-uhd_2560_1440_30fps.mp4'),
(32, 'Sharing Flat', 'Mumbai, Maharashtra', 4000000, 'uploads/flat4.png', 0, 3, '2', 'Focuses on affordability, community, and \"per-bed\" facilities. Unlike renting an entire flat, these listings target students or working professionals looking for a budget-friendly, managed stay.', NULL, '2026-03-18 06:54:13', 'Flat', 'Rent', 19, 'Active', '🏊Swimming Pool 🏋 Gym 🌳 Garden 🔐 24x7 Security 🛗 Lift ⚡ Power Backup', 'Yes', 'https://images.pexels.com/photos/13722890/pexels-photo-13722890.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/30469367/pexels-photo-30469367.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/14614673/pexels-photo-14614673.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/6180673/pexels-photo-6180673.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/10758468/pexels-photo-10758468.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/4716791/pexels-photo-4716791.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/6890396/pexels-photo-6890396.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/4716789/pexels-photo-4716789.jpeg?auto=compress&cs=tinysrgb&h=350', 'https://videos.pexels.com/video-files/7578117/7578117-sd_960_540_30fps.mp4'),
(33, 'Circular Plot', 'Manali, India', 25000000, 'uploads/land3.png', 0, 3, '2', 'Typically features a central focal point, making it ideal for structures that require 360-degree views or radial access. Offers a distinctive, \"organic\" look compared to the rigid lines of traditional grid-based developments.', NULL, '2026-03-18 06:56:07', 'Plot', 'Sale', 19, 'Active', '🏊Swimming Pool 🏋 Gym 🌳 Garden 🔐 24x7 Security 🛗 Lift ⚡ Power Backup', 'Yes', 'https://images.pexels.com/photos/31737858/pexels-photo-31737858.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/14614673/pexels-photo-14614673.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/34717351/pexels-photo-34717351.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/34538288/pexels-photo-34538288.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/30925021/pexels-photo-30925021.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/16869704/pexels-photo-16869704.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/16056401/pexels-photo-16056401.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/31362244/pexels-photo-31362244.jpeg?auto=compress&cs=tinysrgb&h=350', 'https://videos.pexels.com/video-files/7578546/7578546-uhd_2560_1440_30fps.mp4'),
(34, 'Railroad Apartment', 'Delhi, India', 12000000, 'uploads/Apt3.png', 0, 3, '3', 'Emphasize that the apartment spans the entire depth of the building. Typically, the kitchen/living area is at one end, and the bedroom is at the far other end.', NULL, '2026-03-18 06:58:26', 'Apartment', 'Rent', 19, 'Active', '🏊Swimming Pool 🏋 Gym 🌳 Garden 🔐 24x7 Security 🛗 Lift ⚡ Power Backup', 'Yes', 'https://images.pexels.com/photos/7511701/pexels-photo-7511701.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/7031708/pexels-photo-7031708.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/6970049/pexels-photo-6970049.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/17832175/pexels-photo-17832175.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/7546561/pexels-photo-7546561.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/5712145/pexels-photo-5712145.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/6508347/pexels-photo-6508347.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/8146333/pexels-photo-8146333.jpeg?auto=compress&cs=tinysrgb&h=350', 'https://videos.pexels.com/video-files/7578546/7578546-uhd_2560_1440_30fps.mp4'),
(35, 'Flat', 'Andheri, India', 4000000, 'uploads/flat5.png', 0, 3, '3', 'Focuses on affordability, community, and \"per-bed\" facilities. Unlike renting an entire flat, these listings target students or working professionals looking for a budget-friendly, managed stay.', NULL, '2026-03-18 07:09:10', 'Flat', 'Rent', 23, 'Active', '🏊Swimming Pool 🏋 Gym 🌳 Garden 🔐 24x7 Security 🛗 Lift ⚡ Power Backup', 'Yes', 'https://images.pexels.com/photos/13722890/pexels-photo-13722890.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/30469367/pexels-photo-30469367.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/14614673/pexels-photo-14614673.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/6180673/pexels-photo-6180673.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/10758468/pexels-photo-10758468.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/4716791/pexels-photo-4716791.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/6890396/pexels-photo-6890396.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/4716789/pexels-photo-4716789.jpeg?auto=compress&cs=tinysrgb&h=350', 'https://videos.pexels.com/video-files/7578117/7578117-sd_960_540_30fps.mp4'),
(36, 'Hybrid Office', 'Delhi, India', 52000000, 'uploads/Office3.png', 0, 5, '1450', 'Open layouts with modular furniture, movable whiteboards, and \"campfire\" meeting setups to encourage brainstorming.', NULL, '2026-03-18 07:12:34', 'Office', 'Sale', 23, 'Active', '🏊Swimming Pool 🏋 Gym 🌳 Garden 🔐 24x7 Security 🛗 Lift ⚡ Power Backup', 'Yes', 'https://images.pexels.com/photos/13051216/pexels-photo-13051216.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/10161225/pexels-photo-10161225.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/7195880/pexels-photo-7195880.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/5710711/pexels-photo-5710711.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/32255385/pexels-photo-32255385.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/5511084/pexels-photo-5511084.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/8477424/pexels-photo-8477424.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/8477453/pexels-photo-8477453.jpeg?auto=compress&cs=tinysrgb&h=350', 'https://videos.pexels.com/video-files/8293312/8293312-sd_640_360_30fps.mp4'),
(37, 'Walk-up Apartments', 'Banglore, India', 54000000, 'uploads/Apt4.png', 4, 3, '1850', 'Privacy and Peace with fewer units per floor and smaller overall building sizes, these apartments often provide a quieter, more intimate living environment.', NULL, '2026-03-18 07:16:02', 'Apartment', 'Rent', 23, 'Active', '🏊Swimming Pool 🏋 Gym 🌳 Garden 🔐 24x7 Security 🛗 Lift ⚡ Power Backup', 'Yes', 'https://images.pexels.com/photos/7511701/pexels-photo-7511701.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/7031708/pexels-photo-7031708.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/6970049/pexels-photo-6970049.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/17832175/pexels-photo-17832175.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/7546561/pexels-photo-7546561.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/5712145/pexels-photo-5712145.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/6508347/pexels-photo-6508347.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/8146333/pexels-photo-8146333.jpeg?auto=compress&cs=tinysrgb&h=350', 'https://videos.pexels.com/video-files/7578546/7578546-uhd_2560_1440_30fps.mp4'),
(38, 'Parallel Plot', 'Goa, India', 62000000, 'uploads/land4.png', 4, 3, '1850', 'These plots develop along with the main narrative arc, often presenting events in a non-linear manner.', NULL, '2026-03-18 07:20:55', 'Plot', 'Sale', 24, 'Active', '🏊Swimming Pool 🏋 Gym 🌳 Garden 🔐 24x7 Security 🛗 Lift ⚡ Power Backup', 'Yes', 'https://images.pexels.com/photos/31737858/pexels-photo-31737858.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/14614673/pexels-photo-14614673.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/34717351/pexels-photo-34717351.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/34538288/pexels-photo-34538288.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/30925021/pexels-photo-30925021.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/16869704/pexels-photo-16869704.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/16056401/pexels-photo-16056401.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/31362244/pexels-photo-31362244.jpeg?auto=compress&cs=tinysrgb&h=350', 'https://videos.pexels.com/video-files/7578546/7578546-uhd_2560_1440_30fps.mp4'),
(39, 'Virtual Office', 'Delhi, India', 72000000, 'uploads/Office4.png', 0, 4, '1900', 'Access to fully equipped conference rooms or coworking desks when you need to meet clients in person or have a quiet space to focus.', NULL, '2026-03-18 07:25:40', 'Office', 'Sale', 24, 'Active', '🏊Swimming Pool 🏋 Gym 🌳 Garden 🔐 24x7 Security 🛗 Lift ⚡ Power Backup', 'Yes', 'https://images.pexels.com/photos/13051216/pexels-photo-13051216.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/10161225/pexels-photo-10161225.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/7195880/pexels-photo-7195880.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/5710711/pexels-photo-5710711.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/32255385/pexels-photo-32255385.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/5511084/pexels-photo-5511084.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/8477424/pexels-photo-8477424.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/8477453/pexels-photo-8477453.jpeg?auto=compress&cs=tinysrgb&h=350', 'https://videos.pexels.com/video-files/8293312/8293312-sd_640_360_30fps.mp4'),
(40, 'Flex Apartments', 'Bandra, India', 4500000, 'uploads/Apt5.png', 4, 3, '1950', 'Describe exactly what the extra space can be—a nursery, a guest bedroom, or a dedicated work-from-home studio.', NULL, '2026-03-18 07:28:58', 'Apartment', 'Rent', 24, 'Active', '🏊Swimming Pool 🏋 Gym 🌳 Garden 🔐 24x7 Security 🛗 Lift ⚡ Power Backup', 'Yes', 'https://images.pexels.com/photos/7511701/pexels-photo-7511701.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/7031708/pexels-photo-7031708.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/6970049/pexels-photo-6970049.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/17832175/pexels-photo-17832175.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/7546561/pexels-photo-7546561.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/5712145/pexels-photo-5712145.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/6508347/pexels-photo-6508347.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/8146333/pexels-photo-8146333.jpeg?auto=compress&cs=tinysrgb&h=350', 'https://videos.pexels.com/video-files/7578546/7578546-uhd_2560_1440_30fps.mp4'),
(41, 'Row Villa', 'Jaipur, India', 6000000, 'uploads/villa4.png', 4, 3, '1650', 'They are built in a row, they offer a \"neighborhood\" vibe where kids can play in a common internal road while still having a private home.', NULL, '2026-03-18 07:31:53', 'Villa', 'Sale', 24, 'Active', '🏊Swimming Pool 🏋 Gym 🌳 Garden 🔐 24x7 Security 🛗 Lift ⚡ Power Backup', 'Yes', 'https://images.pexels.com/photos/6957083/pexels-photo-6957083.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/8082330/pexels-photo-8082330.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/8134753/pexels-photo-8134753.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/6076854/pexels-photo-6076854.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/8082304/pexels-photo-8082304.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/6283973/pexels-photo-6283973.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/7061670/pexels-photo-7061670.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/7061392/pexels-photo-7061392.jpeg?auto=compress&cs=tinysrgb&h=350', 'https://videos.pexels.com/video-files/7578546/7578546-uhd_2560_1440_30fps.mp4'),
(42, 'Bungalow Villa', 'Mumbai, Maharashtra', 52000000, 'uploads/villa5.png', 8, 4, '1950', 'Emphasize \"Four-Side Open\" living (e.g., \"Palatial 4BHK Standalone Villa with Private Garden\"). Expansive living hall, guest bedroom, modular kitchen, and a servant\'s room.', NULL, '2026-03-18 08:21:21', 'Villa', 'Rent', 24, 'Active', '🏊Swimming Pool 🏋 Gym 🌳 Garden 🔐 24x7 Security 🛗 Lift ⚡ Power Backup', 'Yes', 'https://images.pexels.com/photos/6957083/pexels-photo-6957083.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/8082330/pexels-photo-8082330.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/8134753/pexels-photo-8134753.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/6076854/pexels-photo-6076854.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/8082304/pexels-photo-8082304.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/6283973/pexels-photo-6283973.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/7061670/pexels-photo-7061670.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/7061392/pexels-photo-7061392.jpeg?auto=compress&cs=tinysrgb&h=350', 'https://videos.pexels.com/video-files/7578546/7578546-uhd_2560_1440_30fps.mp4'),
(43, 'Episodic Plot', 'Manali, India', 52000000, 'uploads/land5.png', 3, 3, '1450', 'This structure is very common in \"road trip\" stories where the character moves from one location to another, meeting new people in each \"episode.\" \r\n', NULL, '2026-03-18 08:25:37', 'Plot', 'Sale', 19, 'Active', '🏊Swimming Pool 🏋 Gym 🌳 Garden 🔐 24x7 Security 🛗 Lift ⚡ Power Backup', 'Yes', 'https://images.pexels.com/photos/31737858/pexels-photo-31737858.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/14614673/pexels-photo-14614673.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/34538288/pexels-photo-34538288.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/34277650/pexels-photo-34277650.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/30925021/pexels-photo-30925021.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/16869704/pexels-photo-16869704.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/16056401/pexels-photo-16056401.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/31362244/pexels-photo-31362244.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/14613395/pexels-photo-14613395.jpeg?auto=compress&cs=tinysrgb&h=350,https://images.pexels.com/photos/30211404/pexels-photo-30211404.jpeg?auto=compress&cs=tinysrgb&h=350', 'https://videos.pexels.com/video-files/7578546/7578546-uhd_2560_1440_30fps.mp4');

-- --------------------------------------------------------

--
-- Table structure for table `saved_properties`
--

CREATE TABLE `saved_properties` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `property_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `saved_properties`
--

INSERT INTO `saved_properties` (`id`, `user_id`, `property_id`) VALUES
(13, 1, 3),
(14, 1, 8),
(15, 1, 11),
(16, 1, 14),
(17, 1, 9),
(18, 1, 16),
(20, 3, 14),
(21, 1, 42),
(23, 13, 3),
(24, 18, 3),
(25, 18, 8),
(26, 18, 16),
(27, 18, 24);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `contact` varchar(15) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `contact`, `email`, `password`, `role`) VALUES
(14, 'Sakshi Sakharkar', '2546576863', 'sakshi@gmail.com', '$2y$10$oIGmuvLQtfaUy4mIrurY1uQOgEt9VXnDQHz718q4Fux.tfcDHi1XG', 'owner'),
(18, 'Priya Gupta', '2546576863', 'priya@gmail.com', '$2y$10$SmIsMKoNw6RE/52EeVSbLem4k/sCWxQtEjL80AeBLdiRhQbOoS45K', 'user'),
(19, 'Kishori Bait', '2544658863', 'kishori@gmail.com', '$2y$10$7sDnkY8R3XeSkfCbCtkDJ.IM4pc0zzP/jq9fbUd2u1IpAk96IgtU2', 'broker'),
(20, 'Apurva Gholap', '2544658863', 'apurva@gmail.com', '$2y$10$xK.ek9v0MHzlOUWOIROuZeS53SO95wYveeeVw1VQ4O9X9zXZHGjvi', 'user'),
(21, 'Sejal Gupta', '2544658863', 'sejal@gmail.com', '$2y$10$5NhxXdry3U85pl8245biZep/i1k4pMkXpKuYbj.iyVH2UyYV846xi', 'owner'),
(22, 'Sneha Gupta', '4766878420', 'sneha@gmail.com', '$2y$10$Y7X.ZgQy5uetokE.zzTzNu.H53QOQuICVts5hdyIDgQQy67a262Hi', 'owner'),
(23, 'Divyal Agaskar', '2546576863', 'divyal@gmail.com', '$2y$10$4.u6E9ZlYoIESv.icZFQpuHEp8OeFMXPsgalssPL.UiIspDvNBCdi', 'broker'),
(24, 'Aditi Ambrale', '4766878420', 'aditi@gmail.com', '$2y$10$2dajhVx5h3A0zKNw43sxO.GyXHK.VGT2SrSmTV531g6flbcs9SI8i', 'broker'),
(28, 'sneha', '2546576863', 'sneha@gmail.com', '$2y$10$EAJFmleVvTI2H5sE9xePW.0MImp6mQyVGdR3/bztcnet0w2kwc0oS', 'user');

-- --------------------------------------------------------

--
-- Table structure for table `viewed_properties`
--

CREATE TABLE `viewed_properties` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `property_id` int(11) DEFAULT NULL,
  `viewed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `viewed_properties`
--

INSERT INTO `viewed_properties` (`id`, `user_id`, `property_id`, `viewed_at`) VALUES
(1, 1, 3, '2026-03-14 08:00:35'),
(2, 1, 7, '2026-03-14 08:12:33'),
(3, 1, 4, '2026-03-14 08:12:59'),
(4, 1, 5, '2026-03-14 08:13:10'),
(5, 1, 4, '2026-03-14 08:14:51'),
(6, 1, 4, '2026-03-14 08:20:06'),
(7, 1, 4, '2026-03-14 08:20:56'),
(8, 1, 4, '2026-03-14 08:21:04'),
(9, 1, 4, '2026-03-14 08:21:34'),
(10, 1, 5, '2026-03-14 08:21:59'),
(11, 3, 4, '2026-03-16 04:54:02'),
(12, 3, 3, '2026-03-16 06:22:42'),
(13, 3, 4, '2026-03-16 06:22:48'),
(14, 3, 5, '2026-03-16 06:22:52'),
(15, 3, 7, '2026-03-16 06:22:57'),
(16, 3, 8, '2026-03-16 06:23:04'),
(17, 3, 9, '2026-03-16 06:23:11'),
(18, 3, 12, '2026-03-16 06:23:20'),
(19, 3, 14, '2026-03-16 06:23:41'),
(20, 3, 8, '2026-03-16 06:23:56'),
(21, 3, 11, '2026-03-16 06:24:02'),
(22, 3, 11, '2026-03-16 06:24:29'),
(23, 3, 11, '2026-03-16 06:26:59'),
(24, 3, 11, '2026-03-16 06:27:27'),
(25, 3, 11, '2026-03-16 06:27:39'),
(26, 3, 11, '2026-03-16 06:27:50'),
(27, 3, 11, '2026-03-16 06:28:15'),
(28, 3, 11, '2026-03-16 06:30:46'),
(29, 3, 11, '2026-03-16 06:31:05'),
(30, 3, 11, '2026-03-16 06:31:26'),
(31, 3, 11, '2026-03-16 06:33:03'),
(32, 3, 11, '2026-03-16 06:33:06'),
(33, 3, 11, '2026-03-16 06:33:16'),
(34, 3, 11, '2026-03-16 06:33:46'),
(35, 3, 11, '2026-03-16 06:38:43'),
(36, 3, 11, '2026-03-16 06:39:20'),
(37, 3, 11, '2026-03-16 06:40:13'),
(38, 3, 11, '2026-03-16 06:40:30'),
(39, 3, 11, '2026-03-16 06:40:54'),
(40, 3, 11, '2026-03-16 06:41:23'),
(41, 3, 11, '2026-03-16 06:41:31'),
(42, 3, 11, '2026-03-16 06:43:10'),
(43, 3, 11, '2026-03-16 06:43:20'),
(44, 3, 11, '2026-03-16 06:43:32'),
(45, 3, 11, '2026-03-16 06:43:42'),
(46, 3, 11, '2026-03-16 06:44:17'),
(47, 3, 11, '2026-03-16 06:47:30'),
(48, 3, 11, '2026-03-16 06:48:11'),
(49, 3, 11, '2026-03-16 06:48:35'),
(50, 3, 11, '2026-03-16 06:50:31'),
(51, 3, 11, '2026-03-16 06:50:41'),
(52, 3, 11, '2026-03-16 06:51:08'),
(53, 3, 11, '2026-03-16 06:51:18'),
(54, 3, 11, '2026-03-16 06:51:36'),
(55, 3, 11, '2026-03-16 06:51:43'),
(56, 3, 11, '2026-03-16 06:51:51'),
(57, 3, 11, '2026-03-16 06:51:53'),
(58, 3, 11, '2026-03-16 06:52:03'),
(59, 3, 11, '2026-03-16 06:52:12'),
(60, 3, 11, '2026-03-16 06:52:15'),
(61, 3, 11, '2026-03-16 06:52:29'),
(62, 3, 4, '2026-03-16 06:56:51'),
(63, 3, 8, '2026-03-16 06:56:56'),
(64, 3, 14, '2026-03-16 06:57:02'),
(65, 3, 15, '2026-03-16 06:57:05'),
(66, 3, 4, '2026-03-16 07:01:03'),
(67, 1, 4, '2026-03-16 07:17:54'),
(68, 1, 4, '2026-03-16 07:18:47'),
(69, 1, 4, '2026-03-16 07:19:18'),
(70, 1, 9, '2026-03-16 07:19:28'),
(71, 1, 9, '2026-03-16 07:19:35'),
(72, 1, 3, '2026-03-16 08:28:55'),
(73, 1, 7, '2026-03-16 08:29:00'),
(74, 13, 8, '2026-03-16 08:37:03'),
(75, 13, 4, '2026-03-17 05:16:59'),
(76, 13, 15, '2026-03-17 05:17:09'),
(77, 1, 11, '2026-03-17 05:23:55'),
(78, 1, 9, '2026-03-17 07:49:42'),
(79, 1, 8, '2026-03-17 07:54:28'),
(80, 1, 8, '2026-03-17 08:02:14'),
(81, 1, 7, '2026-03-17 08:02:18'),
(82, 1, 10, '2026-03-17 08:12:59'),
(83, 1, 8, '2026-03-18 05:16:33'),
(84, 1, 31, '2026-03-18 07:04:09'),
(85, 1, 30, '2026-03-18 07:04:14'),
(86, 1, 32, '2026-03-18 07:04:18'),
(87, 1, 29, '2026-03-18 07:04:28'),
(88, 1, 28, '2026-03-18 07:04:31'),
(89, 1, 27, '2026-03-18 07:04:34'),
(90, 1, 26, '2026-03-18 07:04:38'),
(91, 1, 22, '2026-03-18 07:04:42'),
(92, 1, 23, '2026-03-18 07:04:45'),
(93, 1, 34, '2026-03-18 07:04:50'),
(94, 3, 37, '2026-03-18 07:18:34'),
(95, 3, 36, '2026-03-18 07:18:37'),
(96, 3, 35, '2026-03-18 07:18:40'),
(97, 3, 28, '2026-03-18 07:46:12'),
(98, 1, 25, '2026-03-20 05:39:45'),
(99, 1, 9, '2026-03-20 06:39:52'),
(100, 1, 18, '2026-03-20 06:49:40'),
(101, 3, 18, '2026-03-20 06:51:29'),
(102, 3, 18, '2026-03-20 06:51:32'),
(103, 3, 18, '2026-03-20 06:51:34'),
(104, 3, 18, '2026-03-20 06:51:34'),
(105, 3, 18, '2026-03-20 06:51:34'),
(106, 3, 18, '2026-03-20 06:51:42'),
(107, 3, 18, '2026-03-20 06:51:46'),
(108, 3, 18, '2026-03-20 06:52:44'),
(109, 3, 18, '2026-03-20 06:52:46'),
(110, 1, 22, '2026-03-20 07:10:03'),
(111, 1, 4, '2026-03-20 07:31:45'),
(112, 1, 4, '2026-03-20 07:38:10'),
(113, 1, 4, '2026-03-20 07:38:12'),
(114, 1, 4, '2026-03-20 07:38:14'),
(115, 1, 8, '2026-03-20 07:38:26'),
(116, 1, 9, '2026-03-20 07:38:33'),
(117, 1, 4, '2026-03-20 07:44:14'),
(118, 1, 4, '2026-03-20 07:44:16'),
(119, 1, 4, '2026-03-20 07:45:16'),
(120, 1, 4, '2026-03-20 07:46:03'),
(121, 1, 4, '2026-03-20 07:46:16'),
(122, 1, 4, '2026-03-20 07:46:28'),
(123, 1, 4, '2026-03-20 07:46:44'),
(124, 1, 13, '2026-03-20 07:46:54'),
(125, 1, 8, '2026-03-20 08:07:20'),
(126, 1, 29, '2026-03-20 08:11:03'),
(127, 1, 27, '2026-03-20 08:12:15'),
(128, 1, 10, '2026-03-20 08:14:21'),
(129, 1, 15, '2026-03-20 08:15:37'),
(130, 1, 15, '2026-03-20 08:16:18'),
(131, 1, 18, '2026-03-20 08:27:13'),
(132, 1, 8, '2026-03-21 05:42:44'),
(133, 1, 11, '2026-03-21 05:42:52'),
(134, 2, 11, '2026-03-21 05:46:28'),
(135, 13, 16, '2026-03-21 06:05:01'),
(136, 1, 25, '2026-03-21 06:22:06'),
(137, 2, 25, '2026-03-21 06:26:07'),
(138, 13, 14, '2026-03-21 07:27:54'),
(139, 13, 5, '2026-03-21 09:10:26'),
(140, 1, 4, '2026-03-23 05:30:17'),
(141, 1, 4, '2026-03-23 05:46:28'),
(142, 1, 4, '2026-03-23 06:01:25'),
(143, 1, 4, '2026-03-23 06:19:03'),
(144, 13, 10, '2026-03-23 06:28:41'),
(145, 1, 7, '2026-03-23 06:36:28'),
(146, 1, 4, '2026-03-23 06:39:54'),
(147, 1, 7, '2026-03-23 06:39:59'),
(148, 1, 10, '2026-03-23 06:40:07'),
(149, 1, 14, '2026-03-23 06:40:26'),
(150, 1, 10, '2026-03-24 05:28:42'),
(151, 1, 7, '2026-03-24 05:28:48'),
(152, 1, 3, '2026-03-27 06:14:51'),
(153, 1, 3, '2026-03-27 06:15:16'),
(154, 1, 3, '2026-03-27 06:17:24'),
(155, 1, 3, '2026-03-27 06:18:52'),
(156, 1, 4, '2026-03-27 06:27:27'),
(157, 1, 4, '2026-03-27 06:28:46'),
(158, 1, 3, '2026-03-27 06:28:54'),
(159, 1, 3, '2026-03-27 06:30:52'),
(160, 1, 3, '2026-03-27 06:31:37'),
(161, 1, 3, '2026-03-27 06:32:35'),
(162, 1, 3, '2026-03-27 06:35:36'),
(163, 1, 8, '2026-03-27 06:37:47'),
(164, 1, 10, '2026-03-27 06:37:53'),
(165, 1, 13, '2026-03-27 06:37:57'),
(166, 1, 16, '2026-03-28 05:54:20'),
(167, 1, 3, '2026-03-28 05:54:36'),
(168, 1, 3, '2026-03-28 05:54:48'),
(169, 1, 3, '2026-03-28 05:55:35'),
(170, 1, 3, '2026-03-28 05:56:10'),
(171, 1, 40, '2026-03-28 06:03:48'),
(172, 1, 3, '2026-03-28 06:04:02'),
(173, 1, 4, '2026-03-28 06:04:27'),
(174, 1, 5, '2026-03-28 06:04:32'),
(175, 1, 4, '2026-03-28 06:04:43'),
(176, 1, 5, '2026-03-28 06:04:47'),
(177, 1, 5, '2026-03-28 06:04:49'),
(178, 1, 4, '2026-03-28 06:05:18'),
(179, 1, 31, '2026-03-30 05:42:42'),
(180, 1, 4, '2026-03-30 07:07:26'),
(181, 1, 3, '2026-03-30 07:07:39'),
(182, 1, 3, '2026-03-30 07:07:51'),
(183, 1, 11, '2026-03-30 07:41:11'),
(184, 1, 11, '2026-03-30 07:42:02'),
(185, 1, 11, '2026-03-30 07:43:14'),
(186, 1, 11, '2026-03-30 07:43:17'),
(187, 1, 11, '2026-03-30 07:46:01'),
(188, 1, 13, '2026-03-30 07:46:06'),
(189, 1, 15, '2026-03-30 07:49:36'),
(190, 1, 11, '2026-03-31 05:21:09'),
(191, 1, 45, '2026-03-31 05:24:24'),
(192, 1, 45, '2026-03-31 05:27:23'),
(193, 1, 47, '2026-03-31 05:30:00'),
(194, 1, 0, '2026-03-31 06:37:46'),
(195, 1, 3, '2026-03-31 06:44:15'),
(196, 1, 3, '2026-03-31 06:46:04'),
(197, 1, 3, '2026-03-31 06:46:05'),
(198, 1, 3, '2026-03-31 06:46:05'),
(199, 1, 3, '2026-03-31 06:46:06'),
(200, 1, 4, '2026-03-31 06:46:42'),
(201, 1, 3, '2026-03-31 06:46:46'),
(202, 1, 43, '2026-03-31 06:46:53'),
(203, 1, 3, '2026-03-31 06:46:59'),
(204, 1, 3, '2026-03-31 06:47:57'),
(205, 1, 3, '2026-03-31 07:37:58'),
(206, 1, 3, '2026-03-31 07:39:38'),
(207, 1, 3, '2026-03-31 08:46:19'),
(208, 1, 4, '2026-03-31 08:55:04'),
(209, 1, 4, '2026-03-31 08:55:22'),
(210, 1, 4, '2026-03-31 08:55:44'),
(211, 1, 3, '2026-04-01 05:31:38'),
(212, 1, 8, '2026-04-01 05:31:46'),
(213, 1, 8, '2026-04-01 05:33:49'),
(214, 1, 15, '2026-04-01 06:13:06'),
(215, 1, 7, '2026-04-02 05:21:07'),
(216, 1, 8, '2026-04-02 05:21:13'),
(217, 1, 4, '2026-04-02 05:21:23'),
(218, 13, 11, '2026-04-02 05:44:17'),
(219, 13, 18, '2026-04-02 06:09:20'),
(220, 1, 4, '2026-04-04 05:48:26'),
(221, 1, 50, '2026-04-04 06:11:07'),
(222, 1, 50, '2026-04-04 06:11:10'),
(223, 1, 50, '2026-04-04 06:17:08'),
(224, 1, 50, '2026-04-04 06:18:18'),
(225, 1, 51, '2026-04-04 06:23:21'),
(226, 1, 43, '2026-04-04 06:24:46'),
(227, 1, 43, '2026-04-04 06:25:48'),
(228, 1, 42, '2026-04-04 06:25:57'),
(229, 1, 40, '2026-04-04 06:26:01'),
(230, 1, 37, '2026-04-04 06:26:04'),
(231, 1, 4, '2026-04-04 06:26:10'),
(232, 1, 7, '2026-04-04 07:05:27'),
(233, 1, 4, '2026-04-04 07:19:49'),
(234, 1, 4, '2026-04-04 07:21:41'),
(235, 1, 5, '2026-04-04 07:45:57'),
(236, 1, 7, '2026-04-06 06:23:54'),
(237, 1, 52, '2026-04-06 07:14:46'),
(238, 1, 52, '2026-04-06 07:17:45'),
(239, 18, 53, '2026-04-06 07:44:54'),
(240, 18, 53, '2026-04-06 07:45:00'),
(241, 18, 0, '2026-04-06 08:21:29'),
(242, 18, 4, '2026-04-06 08:21:52'),
(243, 18, 8, '2026-04-06 08:21:58'),
(244, 18, 15, '2026-04-06 08:22:02'),
(245, 14, 10, '2026-04-06 08:43:35'),
(246, 14, 16, '2026-04-06 08:43:42'),
(247, 14, 18, '2026-04-06 08:43:46'),
(248, 18, 55, '2026-04-06 08:49:54'),
(249, 18, 55, '2026-04-06 08:50:38'),
(250, 18, 40, '2026-04-06 08:50:45'),
(251, 18, 37, '2026-04-06 08:50:59'),
(252, 18, 37, '2026-04-06 08:56:27'),
(253, 18, 43, '2026-04-06 08:56:48'),
(254, 18, 54, '2026-04-06 08:56:57'),
(255, 18, 54, '2026-04-06 08:57:04'),
(256, 19, 7, '2026-04-06 09:07:15'),
(257, 19, 54, '2026-04-06 09:08:02'),
(258, 20, 54, '2026-04-07 05:39:34'),
(259, 20, 55, '2026-04-07 05:39:37'),
(260, 18, 5, '2026-04-07 05:51:43'),
(261, 14, 5, '2026-04-07 05:54:59'),
(262, 18, 8, '2026-04-07 06:06:46'),
(263, 18, 5, '2026-04-07 06:12:44'),
(264, 18, 8, '2026-04-07 06:15:41'),
(265, 18, 54, '2026-04-07 06:36:00'),
(266, 18, 56, '2026-04-07 06:36:03'),
(267, 18, 5, '2026-04-07 06:36:15'),
(268, 18, 4, '2026-04-07 06:37:16'),
(269, 18, 4, '2026-04-07 06:43:04'),
(270, 18, 4, '2026-04-07 06:44:02'),
(271, 18, 4, '2026-04-07 06:44:22'),
(272, 18, 4, '2026-04-07 06:44:31'),
(273, 18, 4, '2026-04-07 06:45:45'),
(274, 18, 4, '2026-04-07 06:45:53'),
(275, 18, 7, '2026-04-07 06:46:18'),
(276, 18, 7, '2026-04-07 06:46:22'),
(277, 18, 13, '2026-04-07 06:46:27'),
(278, 18, 14, '2026-04-07 06:46:32'),
(279, 18, 23, '2026-04-07 06:46:40'),
(280, 18, 30, '2026-04-07 06:46:48'),
(281, 18, 31, '2026-04-07 06:47:40'),
(282, 18, 31, '2026-04-07 06:47:52'),
(283, 18, 4, '2026-04-07 06:51:10'),
(284, 18, 4, '2026-04-07 06:52:03'),
(285, 18, 4, '2026-04-07 06:52:14'),
(286, 18, 4, '2026-04-07 06:52:23'),
(287, 18, 8, '2026-04-07 06:52:40'),
(288, 18, 16, '2026-04-07 06:52:49'),
(289, 18, 28, '2026-04-07 06:52:56'),
(290, 18, 56, '2026-04-07 06:53:09'),
(291, 18, 35, '2026-04-07 06:53:49'),
(292, 18, 35, '2026-04-07 06:54:08'),
(293, 18, 4, '2026-04-07 07:10:24'),
(294, 18, 4, '2026-04-07 07:11:10'),
(295, 18, 3, '2026-04-07 07:11:39'),
(296, 18, 5, '2026-04-07 07:16:04'),
(297, 18, 3, '2026-04-07 07:16:47'),
(298, 18, 3, '2026-04-07 07:18:05'),
(299, 18, 7, '2026-04-07 07:26:50'),
(300, 19, 10, '2026-04-07 07:30:23'),
(301, 19, 30, '2026-04-07 07:30:30'),
(302, 19, 22, '2026-04-07 07:30:39'),
(303, 19, 14, '2026-04-07 07:30:56'),
(304, 19, 43, '2026-04-07 07:31:01'),
(305, 18, 7, '2026-04-07 07:31:38'),
(306, 18, 15, '2026-04-07 07:31:50'),
(307, 18, 7, '2026-04-07 07:32:05'),
(308, 18, 8, '2026-04-07 07:32:18'),
(309, 18, 22, '2026-04-07 07:44:21'),
(310, 18, 14, '2026-04-07 07:44:33'),
(311, 18, 38, '2026-04-07 07:44:37'),
(312, 18, 33, '2026-04-07 07:44:56');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `brokers`
--
ALTER TABLE `brokers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `broker_leads`
--
ALTER TABLE `broker_leads`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `earnings`
--
ALTER TABLE `earnings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `inquiries`
--
ALTER TABLE `inquiries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `owners`
--
ALTER TABLE `owners`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `properties`
--
ALTER TABLE `properties`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `saved_properties`
--
ALTER TABLE `saved_properties`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `viewed_properties`
--
ALTER TABLE `viewed_properties`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `brokers`
--
ALTER TABLE `brokers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `broker_leads`
--
ALTER TABLE `broker_leads`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `earnings`
--
ALTER TABLE `earnings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `inquiries`
--
ALTER TABLE `inquiries`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `owners`
--
ALTER TABLE `owners`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `properties`
--
ALTER TABLE `properties`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT for table `saved_properties`
--
ALTER TABLE `saved_properties`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `viewed_properties`
--
ALTER TABLE `viewed_properties`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=313;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
