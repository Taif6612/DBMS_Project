-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 20, 2024 at 11:41 AM
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
-- Database: `farmsmart`
--

-- --------------------------------------------------------

--
-- Table structure for table `analysist_information`
--

CREATE TABLE `analysist_information` (
  `analysist_id` varchar(50) NOT NULL,
  `analysist_name` varchar(30) NOT NULL,
  `a_password` varchar(252) NOT NULL,
  `district` varchar(30) NOT NULL,
  `village` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `analysist_information`
--

INSERT INTO `analysist_information` (`analysist_id`, `analysist_name`, `a_password`, `district`, `village`) VALUES
('usr_675767fe76dad', 'Ananta Takla', '11111', 'Dhaka', 'Gazipur'),
('usr_676525b6d97ad', 'Younus', '11111', 'Dhaka', 'UK');

-- --------------------------------------------------------

--
-- Table structure for table `analysis_data_for_crops`
--

CREATE TABLE `analysis_data_for_crops` (
  `analysis_id` varchar(50) NOT NULL,
  `crop_id` varchar(50) NOT NULL,
  `c_name` varchar(50) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `price_value` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `analysis_data_for_crops`
--

INSERT INTO `analysis_data_for_crops` (`analysis_id`, `crop_id`, `c_name`, `date`, `price_value`) VALUES
('usr_675753a18e399', 'crop_675b18b38f634', 'Lichii', '2024-12-16', 300.00),
('usr_675767fe76dad', 'crop_675760e1ba21d', 'Rice', '2024-12-10', 400.00),
('usr_675767fe76dad', 'crop_675760ee833df', 'Wheat', '2024-12-17', 410.00),
('usr_675767fe76dad', 'crop_67576101a97cc', 'Barley', '2024-12-10', 300.00),
('usr_675767fe76dad', 'crop_6757613e154c2', 'Wheat', '2024-12-09', 300.00),
('usr_675767fe76dad', 'crop_6757614b293e0', 'Mango', '2024-12-12', 400.00),
('usr_675767fe76dad', 'crop_6761b6efd81b0', 'Tomato', '2024-12-17', 480.00),
('usr_675767fe76dad', 'crop_6761b6fa8b7ab', 'Badhacofi', '2024-12-19', 320.00);

-- --------------------------------------------------------

--
-- Table structure for table `buyer_information`
--

CREATE TABLE `buyer_information` (
  `buyer_id` varchar(50) NOT NULL,
  `buyer_name` varchar(30) NOT NULL,
  `b_password` varchar(252) NOT NULL,
  `district` varchar(30) NOT NULL,
  `village` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `buyer_information`
--

INSERT INTO `buyer_information` (`buyer_id`, `buyer_name`, `b_password`, `district`, `village`) VALUES
('usr_675753a18e399', 'Mahadi Khan', '11111', 'Dhaka', 'Mirpur'),
('usr_6759e7c994f82', 'Sapik Khan', '11111', 'Dhaka', 'Basundhara');

-- --------------------------------------------------------

--
-- Table structure for table `crop_farmer_zone_warehouse_info`
--

CREATE TABLE `crop_farmer_zone_warehouse_info` (
  `crop_id` varchar(50) NOT NULL,
  `farmer_id` varchar(50) NOT NULL,
  `zone_num` int(10) NOT NULL,
  `warehouse_num` varchar(50) NOT NULL,
  `cost` decimal(10,2) DEFAULT NULL,
  `wh_delivery_date` date DEFAULT NULL,
  `quantity` int(10) DEFAULT NULL,
  `price_disc` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `crop_farmer_zone_warehouse_info`
--

INSERT INTO `crop_farmer_zone_warehouse_info` (`crop_id`, `farmer_id`, `zone_num`, `warehouse_num`, `cost`, `wh_delivery_date`, `quantity`, `price_disc`) VALUES
('crop_675760ee833df', 'usr_675751e9653fb', 3223, 'w_67577df694ff4', 400.00, '2024-12-16', 75, 10),
('crop_67576101a97cc', 'usr_675751e9653fb', 5434, 'w_67577dfde0b15', 300.00, '2024-12-18', 50, 10),
('crop_6757613e154c2', 'usr_6757520b406b5', 4433, 'w_675b21b9a2334', 300.00, '2024-12-16', 505, 16),
('crop_6757614b293e0', 'usr_6757520b406b5', 3223, 'w_67577e0e6408b', 400.00, '2024-12-16', 70, 10),
('crop_675b18b38f634', 'usr_675751e9653fb', 5434, 'w_67577dfde0b15', 300.00, '2024-12-19', 390, 15);

-- --------------------------------------------------------

--
-- Table structure for table `crop_information_per_farmer`
--

CREATE TABLE `crop_information_per_farmer` (
  `crop_id` varchar(50) NOT NULL,
  `farmer_id` varchar(50) DEFAULT NULL,
  `c_name` varchar(50) DEFAULT NULL,
  `growing_season` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `crop_information_per_farmer`
--

INSERT INTO `crop_information_per_farmer` (`crop_id`, `farmer_id`, `c_name`, `growing_season`) VALUES
('crop_675760e1ba21d', 'usr_675751e9653fb', 'Carrott', 'Summer'),
('crop_675760ee833df', 'usr_675751e9653fb', 'Wheat', 'Winter'),
('crop_67576101a97cc', 'usr_675751e9653fb', 'Barley', 'Monsoon'),
('crop_6757613e154c2', 'usr_6757520b406b5', 'Wheat', 'Winter'),
('crop_6757614b293e0', 'usr_6757520b406b5', 'Mango', 'Summer'),
('crop_675b18b38f634', 'usr_675751e9653fb', 'Lichii', 'Monsoon'),
('crop_6761b6efd81b0', 'usr_675751e9653fb', 'Tomato', 'Winter'),
('crop_6761b6fa8b7ab', 'usr_675751e9653fb', 'Badhacofi', 'Winter');

-- --------------------------------------------------------

--
-- Table structure for table `farmer_information`
--

CREATE TABLE `farmer_information` (
  `farmer_id` varchar(50) NOT NULL,
  `farmer_name` varchar(30) NOT NULL,
  `f_password` varchar(252) NOT NULL,
  `district` varchar(50) NOT NULL,
  `village` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `farmer_information`
--

INSERT INTO `farmer_information` (`farmer_id`, `farmer_name`, `f_password`, `district`, `village`) VALUES
('usr_675751e9653fb', 'Rohim Mia', '11111', 'Rajshahi', 'Uganda'),
('usr_6757520b406b5', 'Hero Alom', '11111', 'Dhaka', 'Uganda');

-- --------------------------------------------------------

--
-- Table structure for table `order_crop_relationship`
--

CREATE TABLE `order_crop_relationship` (
  `crop_id` varchar(50) NOT NULL,
  `order_id` varchar(50) NOT NULL,
  `quantity` int(10) NOT NULL,
  `unit_price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_crop_relationship`
--

INSERT INTO `order_crop_relationship` (`crop_id`, `order_id`, `quantity`, `unit_price`) VALUES
('crop_675760e1ba21d', 'order_6759d4d41ae53', 2, 400.00),
('crop_675760e1ba21d', 'order_6759da27829f2', 1, 400.00),
('crop_675760e1ba21d', 'order_6759e88095700', 1, 400.00),
('crop_675760ee833df', 'order_675fe5c977fee', 3, 360.00),
('crop_675760ee833df', 'order_675ff1b11049a', 20, 360.00),
('crop_67576101a97cc', 'order_6759d602ab402', 90, 300.00),
('crop_67576101a97cc', 'order_6759d901e5700', 50, 300.00),
('crop_6757614b293e0', 'order_67606a950fe1a', 1, 360.00),
('crop_6757614b293e0', 'order_67606ad9c8952', 2, 360.00),
('crop_6757614b293e0', 'order_67616ba647b49', 18, 360.00),
('crop_675b18b38f634', 'order_675ff836beee6', 20, 255.00),
('crop_675b18b38f634', 'order_67642b9e1ff39', 95, 255.00);

-- --------------------------------------------------------

--
-- Table structure for table `order_details`
--

CREATE TABLE `order_details` (
  `order_id` varchar(50) NOT NULL,
  `buyer_id` varchar(50) DEFAULT NULL,
  `farmer_id` varchar(50) NOT NULL,
  `zone_num` int(10) DEFAULT NULL,
  `warehouse_num` varchar(50) DEFAULT NULL,
  `order_date` date DEFAULT NULL,
  `payment` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_details`
--

INSERT INTO `order_details` (`order_id`, `buyer_id`, `farmer_id`, `zone_num`, `warehouse_num`, `order_date`, `payment`) VALUES
('order_6759d4d41ae53', 'usr_675753a18e399', '', 3223, 'w_67577e0e6408b', '2024-12-12', 'BKash'),
('order_6759d602ab402', 'usr_675753a18e399', '', 3223, 'w_67577df694ff4', '2024-12-12', 'Nogod'),
('order_6759d901e5700', 'usr_675753a18e399', '', 3223, 'w_67577df694ff4', '2024-12-12', 'Nogod'),
('order_6759da27829f2', 'usr_675753a18e399', '', 3223, 'w_67577e0e6408b', '2024-12-12', 'BKash'),
('order_6759e88095700', 'usr_6759e7c994f82', '', 3223, 'w_67577e0e6408b', '2024-12-12', 'Hand Cash'),
('order_675fe5c977fee', 'usr_675753a18e399', '', 3223, 'w_67577df694ff4', '2024-12-12', 'BKash'),
('order_675ff1b11049a', 'usr_675753a18e399', 'usr_675751e9653fb', 3223, 'w_67577df694ff4', '2024-12-16', 'Rocket'),
('order_675ff836beee6', 'usr_675753a18e399', 'usr_675751e9653fb', 5434, 'w_67577dfde0b15', '2024-12-16', 'Rocket'),
('order_67606a950fe1a', 'usr_675753a18e399', 'usr_6757520b406b5', 3223, 'w_67577e0e6408b', '2024-12-16', 'Hand Cash'),
('order_67606ad9c8952', 'usr_675753a18e399', 'usr_6757520b406b5', 3223, 'w_67577e0e6408b', '0000-00-00', 'Rocket'),
('order_67616ba647b49', 'usr_6759e7c994f82', 'usr_6757520b406b5', 3223, 'w_67577e0e6408b', '2024-12-18', 'BKash'),
('order_67642b9e1ff39', 'usr_675753a18e399', 'usr_675751e9653fb', 5434, 'w_67577dfde0b15', '2024-12-19', 'Hand Cash');

-- --------------------------------------------------------

--
-- Table structure for table `recommendation`
--

CREATE TABLE `recommendation` (
  `id` int(11) NOT NULL,
  `month_name` varchar(20) DEFAULT NULL,
  `crops` text DEFAULT NULL,
  `weather_condition` text DEFAULT NULL,
  `protection` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `recommendation`
--

INSERT INTO `recommendation` (`id`, `month_name`, `crops`, `weather_condition`, `protection`) VALUES
(1, 'January', 'Rice (Boro, early season), Cauliflower, Cabbage, Tomato, Carrot, Lettuce, Spinach, Radish, Onion (early)', 'Cool and dry, with low humidity', 'Use row covers or mulch to protect plants from frost and maintain soil moisture'),
(2, 'February', 'Rice (Boro, early season), Cauliflower, Cabbage, Tomato, Carrot, Lettuce, Spinach, Radish, Chili, Garlic (early), Onion', 'Mild and dry, with cooler temperatures', 'Ensure adequate irrigation and provide shade for sensitive crops during the hottest part of the day'),
(3, 'March', 'Rice (Boro, main season), Cauliflower, Cabbage, Tomato, Carrot, Lettuce, Spinach, Radish, Chili, Garlic, Onion, Peas, Eggplant (Brinjal)', 'Warming up, with occasional light rain', 'Use shade nets to protect crops from heat stress and monitor for early pest outbreaks'),
(4, 'April', 'Rice (Boro, main season), Cauliflower, Cabbage, Tomato, Carrot, Lettuce, Spinach, Radish, Chili, Garlic, Onion, Peas, Pumpkin, Cucumber, Bittermelon (Karela)', 'Hot and dry, with increasing humidity', 'Provide adequate irrigation and use mulch to reduce heat stress and conserve moisture'),
(5, 'May', 'Rice (Boro, main season), Cauliflower, Cabbage, Tomato, Carrot, Lettuce, Spinach, Radish, Chili, Garlic, Onion, Peas, Cucumber, Watermelon, Pumpkin, Bittermelon', 'Hot and humid, with occasional showers', 'Ensure proper drainage, and use pest control measures for fungal diseases'),
(6, 'June', 'Rice (Aman, early season), Tomato, Cucumber, Watermelon, Pumpkin, Chili, Okra (Ladyfinger), Bittermelon (Karela), Eggplant (Brinjal)', 'Start of the rainy season, with high humidity', 'Use raised beds, improve drainage, and apply fungicides to prevent waterlogging and fungal diseases'),
(7, 'July', 'Rice (Aman, early season), Tomato, Cucumber, Watermelon, Pumpkin, Chili, Okra (Ladyfinger), Bittermelon (Karela), Eggplant (Brinjal), Green Beans, Luffa (Bottle Gourd)', 'Heavy rainfall, high humidity, and warm temperatures', 'Provide proper drainage and regularly inspect for fungal diseases and pests'),
(8, 'August', 'Rice (Aman, early season), Chili, Tomato, Cucumber, Watermelon, Pumpkin, Okra (Ladyfinger), Bittermelon, Eggplant (Brinjal), Green Beans, Luffa (Bottle Gourd), Sweet Potato', 'Continued heavy rain and high humidity', 'Use rain shelters for delicate crops and ensure good airflow to prevent fungal growth'),
(9, 'September', 'Rice (Aman, main season), Chili, Tomato, Cucumber, Watermelon, Pumpkin, Okra (Ladyfinger), Bittermelon, Eggplant (Brinjal), Green Beans, Luffa (Bottle Gourd), Sweet Potato, Yam, Mango (Late season)', 'Heavy monsoon rains, warm and humid', 'Ensure proper drainage, use plant supports to prevent damage from wind, and keep crops elevated from water'),
(10, 'October', 'Rice (Aman, main season), Chili, Tomato, Cucumber, Pumpkin, Okra (Ladyfinger), Bittermelon, Eggplant (Brinjal), Green Beans, Luffa (Bottle Gourd), Sweet Potato, Yam, Mango (Late season), Pineapple (Late season)', 'Reduced rainfall, warm temperatures', 'Maintain regular irrigation and protect plants from pests and fungal diseases as humidity decreases'),
(11, 'November', 'Rice (Aman, main season), Chili, Tomato, Cucumber, Pumpkin, Okra (Ladyfinger), Bittermelon, Eggplant (Brinjal), Green Beans, Luffa (Bottle Gourd), Sweet Potato, Yam, Pineapple, Coconut, Papaya, Guava', 'Cool and dry, with mild temperatures', 'Mulch crops to retain moisture and provide frost protection for sensitive crops during cooler nights'),
(12, 'December', 'Rice (Aman, late season), Chili, Tomato, Cucumber, Pumpkin, Okra (Ladyfinger), Bittermelon, Eggplant (Brinjal), Green Beans, Luffa (Bottle Gourd), Sweet Potato, Yam, Papaya, Guava, Coconut, Pineapple', 'Cool and dry, with low humidity', 'Use row covers for frost-sensitive crops and ensure proper water management');

-- --------------------------------------------------------

--
-- Table structure for table `supplier_information`
--

CREATE TABLE `supplier_information` (
  `supplier_id` varchar(50) NOT NULL,
  `supplier_name` varchar(30) NOT NULL,
  `s_password` varchar(252) NOT NULL,
  `district` varchar(30) NOT NULL,
  `village` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `supplier_information`
--

INSERT INTO `supplier_information` (`supplier_id`, `supplier_name`, `s_password`, `district`, `village`) VALUES
('usr_67615176228ae', 'Kuddus khan', '11111', 'Dhaka', 'Mirpu'),
('usr_67642ef709f7e', 'Liton Das', '11111', 'Dhaka', 'Gazipur'),
('usr_67652560bfb8f', 'Manna', '11111', 'Dhaka', 'Motijhil');

-- --------------------------------------------------------

--
-- Table structure for table `supply_crop_details`
--

CREATE TABLE `supply_crop_details` (
  `supply_id` varchar(50) DEFAULT NULL,
  `crop_id` varchar(50) DEFAULT NULL,
  `quantity` int(10) DEFAULT NULL,
  `unit_price` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `supply_crop_details`
--

INSERT INTO `supply_crop_details` (`supply_id`, `crop_id`, `quantity`, `unit_price`) VALUES
('supply_67616a213aa04', 'crop_675760e1ba21d', 45, 400.00),
('supply_676179bff3ff4', 'crop_6757614b293e0', 4, 400.00),
('supply_67642f2742921', 'crop_675760e1ba21d', 8, 400.00),
('supply_676430650a08d', 'crop_675760e1ba21d', 9, 400.00),
('supply_676431e0574c9', 'crop_6757614b293e0', 2, 400.00),
('supply_6764321a430d3', 'crop_6757614b293e0', 8, 400.00),
('supply_67643243ddd5c', 'crop_675760e1ba21d', 3, 400.00),
('supply_6764406fc8ed9', 'crop_675760ee833df', 2, 410.00);

-- --------------------------------------------------------

--
-- Table structure for table `supply_info`
--

CREATE TABLE `supply_info` (
  `supply_id` varchar(50) NOT NULL,
  `buyer_id` varchar(50) DEFAULT NULL,
  `supplier_id` varchar(50) DEFAULT NULL,
  `supply_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `supply_info`
--

INSERT INTO `supply_info` (`supply_id`, `buyer_id`, `supplier_id`, `supply_date`) VALUES
('supply_67616a213aa04', 'usr_675753a18e399', 'usr_67615176228ae', '2024-12-17'),
('supply_676179bff3ff4', 'usr_6759e7c994f82', 'usr_67615176228ae', '2024-12-17'),
('supply_67642f2742921', 'usr_675753a18e399', 'usr_67642ef709f7e', '2024-12-19'),
('supply_676430650a08d', 'usr_6759e7c994f82', 'usr_67642ef709f7e', '2024-12-19'),
('supply_676431e0574c9', 'usr_675753a18e399', 'usr_67642ef709f7e', '2024-12-19'),
('supply_6764321a430d3', 'usr_675753a18e399', 'usr_67642ef709f7e', '2024-12-19'),
('supply_67643243ddd5c', 'usr_6759e7c994f82', 'usr_67642ef709f7e', '2024-12-19'),
('supply_6764406fc8ed9', 'usr_675753a18e399', 'usr_67642ef709f7e', '2024-12-19');

-- --------------------------------------------------------

--
-- Table structure for table `warehouse`
--

CREATE TABLE `warehouse` (
  `zone_num` int(10) NOT NULL,
  `warehouse_num` varchar(50) NOT NULL,
  `storage_capacity` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `warehouse`
--

INSERT INTO `warehouse` (`zone_num`, `warehouse_num`, `storage_capacity`) VALUES
(3223, 'w_67577df694ff4', 1010),
(3223, 'w_67577e0e6408b', 2000),
(4433, 'w_675b21b9a2334', 5000),
(5434, 'w_67577dfde0b15', 1050);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `analysist_information`
--
ALTER TABLE `analysist_information`
  ADD PRIMARY KEY (`analysist_id`);

--
-- Indexes for table `analysis_data_for_crops`
--
ALTER TABLE `analysis_data_for_crops`
  ADD PRIMARY KEY (`analysis_id`,`crop_id`),
  ADD KEY `crop_id` (`crop_id`);

--
-- Indexes for table `buyer_information`
--
ALTER TABLE `buyer_information`
  ADD PRIMARY KEY (`buyer_id`);

--
-- Indexes for table `crop_farmer_zone_warehouse_info`
--
ALTER TABLE `crop_farmer_zone_warehouse_info`
  ADD PRIMARY KEY (`crop_id`,`farmer_id`,`zone_num`,`warehouse_num`),
  ADD KEY `farmer_id` (`farmer_id`),
  ADD KEY `zone_num` (`zone_num`,`warehouse_num`);

--
-- Indexes for table `crop_information_per_farmer`
--
ALTER TABLE `crop_information_per_farmer`
  ADD PRIMARY KEY (`crop_id`),
  ADD KEY `farmer_id` (`farmer_id`);

--
-- Indexes for table `farmer_information`
--
ALTER TABLE `farmer_information`
  ADD PRIMARY KEY (`farmer_id`);

--
-- Indexes for table `order_crop_relationship`
--
ALTER TABLE `order_crop_relationship`
  ADD PRIMARY KEY (`crop_id`,`order_id`),
  ADD KEY `order_id` (`order_id`);

--
-- Indexes for table `order_details`
--
ALTER TABLE `order_details`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `buyer_id` (`buyer_id`),
  ADD KEY `zone_num` (`zone_num`,`warehouse_num`);

--
-- Indexes for table `recommendation`
--
ALTER TABLE `recommendation`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `supplier_information`
--
ALTER TABLE `supplier_information`
  ADD PRIMARY KEY (`supplier_id`);

--
-- Indexes for table `supply_crop_details`
--
ALTER TABLE `supply_crop_details`
  ADD KEY `supply_id` (`supply_id`),
  ADD KEY `crop_id` (`crop_id`);

--
-- Indexes for table `supply_info`
--
ALTER TABLE `supply_info`
  ADD PRIMARY KEY (`supply_id`),
  ADD KEY `buyer_id` (`buyer_id`),
  ADD KEY `supplier_id` (`supplier_id`);

--
-- Indexes for table `warehouse`
--
ALTER TABLE `warehouse`
  ADD PRIMARY KEY (`zone_num`,`warehouse_num`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `recommendation`
--
ALTER TABLE `recommendation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `analysis_data_for_crops`
--
ALTER TABLE `analysis_data_for_crops`
  ADD CONSTRAINT `analysis_data_for_crops_ibfk_1` FOREIGN KEY (`crop_id`) REFERENCES `crop_information_per_farmer` (`crop_id`);

--
-- Constraints for table `crop_farmer_zone_warehouse_info`
--
ALTER TABLE `crop_farmer_zone_warehouse_info`
  ADD CONSTRAINT `crop_farmer_zone_warehouse_info_ibfk_1` FOREIGN KEY (`crop_id`) REFERENCES `crop_information_per_farmer` (`crop_id`),
  ADD CONSTRAINT `crop_farmer_zone_warehouse_info_ibfk_2` FOREIGN KEY (`farmer_id`) REFERENCES `farmer_information` (`farmer_id`),
  ADD CONSTRAINT `crop_farmer_zone_warehouse_info_ibfk_3` FOREIGN KEY (`zone_num`,`warehouse_num`) REFERENCES `warehouse` (`zone_num`, `warehouse_num`);

--
-- Constraints for table `crop_information_per_farmer`
--
ALTER TABLE `crop_information_per_farmer`
  ADD CONSTRAINT `crop_information_per_farmer_ibfk_1` FOREIGN KEY (`farmer_id`) REFERENCES `farmer_information` (`farmer_id`);

--
-- Constraints for table `order_crop_relationship`
--
ALTER TABLE `order_crop_relationship`
  ADD CONSTRAINT `order_crop_relationship_ibfk_1` FOREIGN KEY (`crop_id`) REFERENCES `crop_information_per_farmer` (`crop_id`),
  ADD CONSTRAINT `order_crop_relationship_ibfk_2` FOREIGN KEY (`order_id`) REFERENCES `order_details` (`order_id`);

--
-- Constraints for table `order_details`
--
ALTER TABLE `order_details`
  ADD CONSTRAINT `order_details_ibfk_1` FOREIGN KEY (`buyer_id`) REFERENCES `buyer_information` (`buyer_id`),
  ADD CONSTRAINT `order_details_ibfk_2` FOREIGN KEY (`zone_num`,`warehouse_num`) REFERENCES `warehouse` (`zone_num`, `warehouse_num`);

--
-- Constraints for table `supply_crop_details`
--
ALTER TABLE `supply_crop_details`
  ADD CONSTRAINT `supply_crop_details_ibfk_1` FOREIGN KEY (`supply_id`) REFERENCES `supply_info` (`supply_id`),
  ADD CONSTRAINT `supply_crop_details_ibfk_2` FOREIGN KEY (`crop_id`) REFERENCES `crop_information_per_farmer` (`crop_id`);

--
-- Constraints for table `supply_info`
--
ALTER TABLE `supply_info`
  ADD CONSTRAINT `supply_info_ibfk_1` FOREIGN KEY (`buyer_id`) REFERENCES `buyer_information` (`buyer_id`),
  ADD CONSTRAINT `supply_info_ibfk_2` FOREIGN KEY (`supplier_id`) REFERENCES `supplier_information` (`supplier_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
