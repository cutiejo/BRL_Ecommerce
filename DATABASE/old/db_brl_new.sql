-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 20, 2024 at 08:23 PM
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
-- Database: `db_brl1`
--

-- --------------------------------------------------------

--
-- Table structure for table `add_user`
--

CREATE TABLE `add_user` (
  `id` int(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `add_user`
--

INSERT INTO `add_user` (`id`, `username`, `password`) VALUES
(1, 'xcfg', 'thxtf'),
(2, 'xcfg', 'thxtf'),
(6, 'admin', 'admin'),
(7, 'xcfg', 'thxtf');

-- --------------------------------------------------------

--
-- Table structure for table `stock`
--

CREATE TABLE `stock` (
  `stock_id` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `stock_quantity` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_category`
--

CREATE TABLE `tbl_category` (
  `category_id` int(11) NOT NULL,
  `category_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_category`
--

INSERT INTO `tbl_category` (`category_id`, `category_name`) VALUES
(72, 'Paper Products'),
(73, 'Hotel Toiletries'),
(74, 'Custodial and Equipment'),
(75, 'Cleaning Solutions');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_orders`
--

CREATE TABLE `tbl_orders` (
  `order_id` int(11) NOT NULL,
  `product_name` varchar(255) DEFAULT NULL,
  `order_date` date DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_orders`
--

INSERT INTO `tbl_orders` (`order_id`, `product_name`, `order_date`, `quantity`, `price`) VALUES
(309, 'Mop', '2024-01-29', 4, 132.00),
(315, 'Cleaning Solutions', '2024-02-03', 4, 1600.00),
(317, 'Mop', '2024-02-05', 2, 200.00),
(318, 'Mop', '2024-02-05', 2, 200.00);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_product`
--

CREATE TABLE `tbl_product` (
  `pid` int(11) NOT NULL,
  `pimage` varchar(255) NOT NULL,
  `pname` varchar(200) NOT NULL,
  `pcategory` int(11) NOT NULL,
  `saleprice` float NOT NULL,
  `stock_quantity` int(11) NOT NULL,
  `pdescription` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_product`
--

INSERT INTO `tbl_product` (`pid`, `pimage`, `pname`, `pcategory`, `saleprice`, `stock_quantity`, `pdescription`) VALUES
(134, 'uploads/mop.jpg', 'Mop', 74, 100, 86, 'mop'),
(146, 'uploads/trash bag.jpg', 'Trashbag', 74, 200, 30, 'trashbag '),
(148, 'uploads/1520134752632.jpg', 'JANITORIAL AND HOUSEKEEPING SUPPLIES', 74, 2500, 99, 'equipments'),
(149, 'uploads/large_20150714_115829.jpg', 'Cleaning Solutions', 70, 400, 146, 'cleaning'),
(156, 'uploads/tissue.png', 'Tissue', 72, 200, 11, 'Tissue paper'),
(157, 'uploads/papercups.png', 'Paper Cups', 72, 289, 15, 'Paper cups'),
(158, 'uploads/dispenser.png', 'Dispenser', 72, 1200, 3, 'Dispenser'),
(160, 'uploads/Screenshot 2024-03-18 233720.png', 'testtt', 72, 2, 1, 'we'),
(161, 'uploads/Screenshot 2024-03-18 233514.png', 'tttt', 72, 345, 345, 'asd'),
(162, 'uploads/Screenshot 2024-03-14 005448.png', 'ty', 74, 4, 43, 'refd'),
(164, 'uploads/Screenshot 2024-03-14 010732.png', 'ew', 74, 3, 2, 'edfs');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `useremail` varchar(200) NOT NULL,
  `password` varchar(100) NOT NULL,
  `role` varchar(50) NOT NULL DEFAULT 'user_type',
  `reset_token` varchar(64) DEFAULT NULL,
  `reset_token_expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `useremail`, `password`, `role`, `reset_token`, `reset_token_expires_at`) VALUES
(22, 'cashier01', 'cashier1@gmail.com', 'cashier1234', 'cashier', '21dd69e85fba6e9c77523a6eed22df9edc22528f2b485a6bfd09eb66e839f691', NULL),
(23, 'Cashier', 'brltrading101@gmail.com', 'staff123456', 'cashier', 'f05ec8b16268e243459de3951f7d3b7f', NULL),
(29, 'admin', 'admin@gmail.com', 'admin123', 'admin', '', '0000-00-00 00:00:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `add_user`
--
ALTER TABLE `add_user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stock`
--
ALTER TABLE `stock`
  ADD PRIMARY KEY (`stock_id`),
  ADD KEY `fk_stock_product` (`product_id`);

--
-- Indexes for table `tbl_category`
--
ALTER TABLE `tbl_category`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `tbl_orders`
--
ALTER TABLE `tbl_orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `fk_orders_product` (`product_name`);

--
-- Indexes for table `tbl_product`
--
ALTER TABLE `tbl_product`
  ADD PRIMARY KEY (`pid`),
  ADD UNIQUE KEY `pname` (`pname`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `reset_token_hash` (`reset_token`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `add_user`
--
ALTER TABLE `add_user`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `stock`
--
ALTER TABLE `stock`
  MODIFY `stock_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `tbl_category`
--
ALTER TABLE `tbl_category`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=76;

--
-- AUTO_INCREMENT for table `tbl_orders`
--
ALTER TABLE `tbl_orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=319;

--
-- AUTO_INCREMENT for table `tbl_product`
--
ALTER TABLE `tbl_product`
  MODIFY `pid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=165;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `stock`
--
ALTER TABLE `stock`
  ADD CONSTRAINT `fk_stock_product` FOREIGN KEY (`product_id`) REFERENCES `tbl_product` (`pid`) ON DELETE CASCADE,
  ADD CONSTRAINT `stock_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `tbl_product` (`pid`);

--
-- Constraints for table `tbl_orders`
--
ALTER TABLE `tbl_orders`
  ADD CONSTRAINT `fk_orders_product` FOREIGN KEY (`product_name`) REFERENCES `tbl_product` (`pname`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
