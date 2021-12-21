-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 10, 2021 at 01:36 PM
-- Server version: 10.4.20-MariaDB
-- PHP Version: 7.4.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `lv_zampoita`
--

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `restaurant_name` varchar(255) NOT NULL,
  `restaurant_name_color` varchar(100) NOT NULL,
  `restaurant_punch_line` varchar(255) NOT NULL,
  `website` varchar(255) NOT NULL,
  `restaurant_type` varchar(255) NOT NULL,
  `short_description` text NOT NULL,
  `phone_one` varchar(100) NOT NULL,
  `phone_two` varchar(100) NOT NULL,
  `wifi` enum('yes','no') NOT NULL DEFAULT 'no',
  `wheel_chair` enum('yes','no') NOT NULL DEFAULT 'no',
  `payment_type` varchar(255) NOT NULL,
  `region` varchar(255) NOT NULL,
  `subregion` varchar(255) NOT NULL,
  `zip_code` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `area` varchar(100) NOT NULL,
  `long_description` longtext NOT NULL,
  `opening_hours` text NOT NULL,
  `role` enum('admin','merchant') NOT NULL,
  `membership_plan` int(11) NOT NULL,
  `membership_status` enum('active','inactive') NOT NULL,
  `activation_code` varchar(200) NOT NULL,
  `forget_pass_tokan` varchar(255) NOT NULL,
  `status` enum('active','inactive','deleted') NOT NULL DEFAULT 'active',
  `merchant_status` enum('active','inactive') NOT NULL,
  `created_on` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_on` datetime NOT NULL,
  `updated_by` int(11) NOT NULL,
  `attachment` text NOT NULL,
  `logo_shape` enum('1','2','3') NOT NULL DEFAULT '1',
  `defualt_cover` varchar(255) NOT NULL,
  `cover_type` varchar(255) NOT NULL,
  `slider_images` varchar(255) NOT NULL,
  `slider_images_title` longtext NOT NULL,
  `featured` tinyint(1) NOT NULL,
  `featured_city` int(11) NOT NULL,
  `basic_delivery_free` varchar(255) NOT NULL,
  `basic_delivery_standard` varchar(255) NOT NULL,
  `basic_delivery_other` varchar(255) NOT NULL,
  `social_url` text NOT NULL,
  `reg_mode` tinyint(1) NOT NULL DEFAULT 1,
  `company_reg_no` varchar(255) NOT NULL,
  `step1_active` tinyint(1) NOT NULL DEFAULT 0,
  `step2_active` tinyint(1) NOT NULL DEFAULT 0,
  `reg_type` varchar(250) NOT NULL,
  `menu_data` longtext DEFAULT NULL,
  `menu_published` tinyint(1) DEFAULT 0,
  `address_1` varchar(250) DEFAULT NULL,
  `address_2` varchar(250) DEFAULT NULL,
  `address_3` varchar(250) DEFAULT NULL,
  `main_food_tag` varchar(250) NOT NULL,
  `opening_time` longtext DEFAULT NULL,
  `parking` varchar(250) DEFAULT NULL,
  `is_delivery` enum('yes','no') NOT NULL DEFAULT 'no',
  `need_activation` int(11) NOT NULL DEFAULT 0,
  `disable_open_close_hours` int(11) NOT NULL DEFAULT 0,
  `slug` varchar(250) NOT NULL,
  `card_details` text NOT NULL,
  `billing_addresss` varchar(250) NOT NULL,
  `pdf_menu_status` tinyint(4) NOT NULL,
  `image_menu_status` tinyint(4) NOT NULL,
  `catgory_name` varchar(255) DEFAULT NULL,
  `catgory_short_description` text DEFAULT NULL,
  `catgory_photo` varchar(255) DEFAULT NULL,
  `menu_url` text DEFAULT NULL,
  `is_menu_url_set` tinyint(1) DEFAULT 0,
  `food_description` text DEFAULT NULL,
  `event_active` char(10) NOT NULL,
  `template` int(11) NOT NULL DEFAULT 1,
  `is_actv_mnu` tinyint(4) DEFAULT NULL,
  `standard_delivery_charge` int(11) DEFAULT NULL,
  `min_order_delivery_charge` int(11) DEFAULT NULL,
  `free_delivery_charge_order` int(11) DEFAULT NULL,
  `menu_feature` tinyint(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
