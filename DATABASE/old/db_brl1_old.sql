-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jan 30, 2024 at 09:01 PM
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
(30, 'Equipment'),
(51, 'test'),
(66, 'swA'),
(67, 'gg'),
(68, 'y'),
(70, 'Cleaning');

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
(297, 'eee', '2024-01-28', 100, 23300.00),
(298, 'eee', '2024-01-28', 20, 4660.00),
(299, 'eee', '2024-01-28', 1, 233.00),
(300, '4v5tr5', '2024-01-28', 12, 636.00),
(301, '4v5tr5', '2024-01-28', 2, 106.00),
(302, '4v5tr5', '2024-01-28', 4, 212.00),
(303, '4v5tr5', '2024-01-28', 2, 106.00),
(304, 'Mop', '2024-01-29', 1, 33.00),
(305, '4v5tr5', '2024-01-26', 1, 53.00),
(306, 'eee', '2024-01-23', 1, 233.00),
(307, 'Trash bag', '2024-01-04', 2, 66.00),
(308, 'Trash bag', '2024-01-29', 5, 165.00),
(309, 'Mop', '2024-01-29', 4, 132.00),
(310, 'qwe', '2024-01-30', 23, 2829.00),
(311, 'Mop', '2024-01-04', 27, 891.00),
(312, 'Trash bag', '2024-01-24', 15, 495.00),
(313, 'reviewer', '2024-01-11', 20, 2000.00);

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
(133, 'uploads/trash bag.jpg', 'Trash bag', 51, 33, 8, 'xsdfdezfrgvdfvncvhsdefxrgthyujkilop;[\']jh\r\nbgvffuhy6rxsdfdezfrgvdfvncvhsdefxrgthyujkilop;[\']jhbgvffuhy6r'),
(134, 'uploads/mop.jpg', 'Mop', 30, 33, 3, 'adxsf'),
(135, 'uploads/large_20150714_115829.jpg', '4v5tr5', 51, 53, 2, 'vfgb nf'),
(136, 'uploads/OIP.jpg', 'eee', 70, 233, 0, 'wax'),
(138, 'uploads/pic1-removebg-preview.png', 'test', 51, 22, 1, 'asfg'),
(139, 'uploads/1520134752632.jpg', 'saasd', 30, 12334300, 0, 'zv gbvfsxvcfchfbcn'),
(141, 'uploads/350239901_621612069897522_7699114098215634277_n.jpg', 'cc', 68, 11, 2, 'cc'),
(142, 'uploads/large_20150714_120052.jpg', 'qwe', 51, 123, 45655, 'eghjk'),
(143, 'uploads/413105199_1745917735917289_3398546945372105628_n.jpg', 'reviewer', 70, 100, 10, 'para mataas sa exam');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `useremail` varchar(200) NOT NULL,
  `password` varchar(100) NOT NULL,
  `role` varchar(50) NOT NULL DEFAULT 'user_type'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `useremail`, `password`, `role`) VALUES
(21, 'admin', 'admin@gmail.com', 'admin123', 'admin'),
(22, 'cashier01', 'cashier1@gmail.com', 'cashier123', 'cashier');

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
  ADD PRIMARY KEY (`user_id`);

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
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;

--
-- AUTO_INCREMENT for table `tbl_orders`
--
ALTER TABLE `tbl_orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=314;

--
-- AUTO_INCREMENT for table `tbl_product`
--
ALTER TABLE `tbl_product`
  MODIFY `pid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=144;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

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
