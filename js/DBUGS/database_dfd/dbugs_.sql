-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 21, 2023 at 05:22 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `webts`
--

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`cat_id`, `cat_name`, `cat_desc`, `cat_status`, `cat_date_added`) VALUES
(1, 'skincare', 'pampalinis ng budhi nyo', 'A', '2023-10-04 13:56:57'),
(2, 'make-up', 'kolorete', 'A', '2023-10-04 13:58:29');

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`item_id`, `item_cat_id`, `item_status`) VALUES
(1, 1, 'A'),
(2, 2, 'A'),
(3, 1, 'A');

--
-- Dumping data for table `item_details`
--

INSERT INTO `item_details` (`item_id`, `item_name`, `item_price`, `item_desc`, `item_img`, `item_qty`, `item_date_added`) VALUES
(NULL, 'COSME+ Sun Protector', 0, 'Protects the skin from harsh UV rays', 0, 1000, '2023-10-21 15:04:51'),
(NULL, 'COSME+ Skin int foundation', 0, 'Can cover your imperfections', 0, 1000, '2023-10-21 15:07:03'),
(NULL, 'COSME+ Water-based Moisturizer', 0, 'Moistures your skin', 0, 500, '2023-10-21 15:08:37'),
(1, NULL, 150, NULL, 0, NULL, '2023-10-21 15:14:07');

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`ord_id`, `ord_user_id`, `date_ordered`, `ord_status`) VALUES
(2, NULL, '', 'A');

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `user_fullname`, `username`, `password`, `user_date_joined`, `user_status`, `user_email_address`, `user_type`) VALUES
(4, 'TEST', 'test', '1234', '2023-10-19 07:16:28', 'A', '', 'A'),
(5, 'Allysa Madara', 'lysa', '4321', '2023-10-19 07:18:55', 'A', 'madaraallysa26@gmail.com', 'U');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
