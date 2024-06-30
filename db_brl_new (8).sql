-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 30, 2024 at 09:04 PM
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
-- Database: `db_brl_new`
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
-- Table structure for table `messagesc`
--

CREATE TABLE `messagesc` (
  `id` int(5) NOT NULL,
  `text` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `system` varchar(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `messagesc`
--

INSERT INTO `messagesc` (`id`, `text`, `created_at`, `system`) VALUES
(1, 'sdsadadas', '2024-06-18 11:28:21', NULL),
(2, 'sdadsadasdadsadsasda', '2024-06-18 11:29:05', NULL),
(3, 'fck this', '2024-06-18 11:29:27', NULL),
(4, 'fd', '2024-06-18 11:55:39', NULL),
(5, 'dada', '2024-06-18 13:44:41', NULL),
(6, 'dsa', '2024-06-18 13:44:44', NULL),
(7, 'saSAs', '2024-06-19 16:07:21', NULL),
(8, 'saSAs', '2024-06-19 16:07:23', NULL),
(9, 'saSAs', '2024-06-19 16:07:23', NULL),
(10, 'saSAs', '2024-06-19 16:07:23', NULL),
(11, 'saSSs', '2024-06-19 10:07:36', NULL),
(12, 'saSAsSAsA', '2024-06-19 16:07:42', NULL),
(13, 'saSAsSAsA', '2024-06-19 16:07:42', NULL),
(14, 'saSAsSAsA', '2024-06-19 16:07:43', NULL),
(15, 'PIOPOI', '2024-06-19 10:12:16', NULL),
(16, 'dsada', '2024-06-19 16:35:49', NULL),
(17, 'ouiouo', '2024-06-19 16:36:06', NULL),
(18, 'sdadsa', '2024-06-20 01:34:15', NULL),
(19, 'sdadsa', '2024-06-20 01:34:15', NULL),
(20, 'sdadsa', '2024-06-20 01:34:16', NULL),
(21, 'dsa', '2024-06-20 01:34:19', NULL),
(22, 'a', '2024-06-20 01:37:52', NULL),
(23, 'fdfss', '2024-06-20 01:51:53', NULL),
(24, 'ggfdgd', '2024-06-20 01:52:32', NULL),
(25, 'dsadaa', '2024-06-20 01:52:59', NULL),
(26, 'dsadew', '2024-06-20 01:54:10', NULL),
(27, 'gdgdd', '2024-06-20 01:54:17', NULL),
(28, 'dsa', '2024-06-20 02:07:12', NULL),
(29, 'dsadaiy', '2024-06-20 02:09:18', NULL),
(30, 'gfdgdgd', '2024-06-20 02:41:19', NULL),
(31, 'dsa', '2024-06-20 02:43:18', NULL),
(32, 'asddadada', '2024-06-20 03:03:59', NULL),
(33, 'ewqeq', '2024-06-20 03:06:18', NULL),
(34, 'ewq', '2024-06-20 03:06:24', NULL),
(35, 'message to sa admin', '2024-06-20 03:07:39', NULL),
(36, 'or form admin', '2024-06-20 03:07:44', NULL),
(37, 'message to from user', '2024-06-20 03:07:52', NULL),
(38, 'ui', '2024-06-20 03:15:42', NULL),
(39, 'erw', '2024-06-20 03:21:45', NULL),
(40, 'ewq', '2024-06-20 03:28:45', NULL),
(41, 'admin to', '2024-06-20 03:28:57', NULL),
(42, 'sdda', '2024-06-20 03:30:44', NULL),
(43, 'dadadasdadsaa', '2024-06-20 03:30:49', NULL),
(44, 'aSss', '2024-06-20 03:31:41', NULL),
(45, 'SAssSS', '2024-06-20 03:31:45', NULL),
(46, 'sdadadas', '2024-06-20 06:54:12', NULL),
(47, 'kay admin to', '2024-06-20 06:54:28', NULL),
(48, 'kay admin to', '2024-06-20 06:54:37', NULL),
(49, 'kay user to', '2024-06-20 06:54:53', NULL),
(50, 'dsada', '2024-06-20 07:34:33', NULL),
(51, 'dsa', '2024-06-20 07:36:26', NULL),
(52, 'sdadad', '2024-06-20 07:38:41', NULL),
(53, 'kay admin', '2024-06-20 07:39:19', NULL),
(54, 'kay user', '2024-06-20 07:39:30', NULL),
(55, 'dsadda', '2024-06-20 08:02:33', NULL),
(56, 'sAAs', '2024-06-20 08:04:09', NULL),
(57, 'aaaaaaaaaaa', '2024-06-20 08:04:17', NULL),
(58, 'asddadasd', '2024-06-20 08:12:38', NULL),
(59, 'dsa', '2024-06-20 08:12:43', NULL),
(60, 'dasdada', '2024-06-20 08:37:05', NULL),
(61, 'yuck', '2024-06-20 08:37:20', NULL),
(62, 'sas', '2024-06-20 08:37:30', NULL),
(63, 'SsSs', '2024-06-20 08:46:02', NULL),
(64, 'ewqewqe', '2024-06-20 09:05:09', NULL),
(65, 'zxxX', '2024-06-20 09:57:56', 'A'),
(66, 'sASsSa', '2024-06-20 09:59:04', 'A'),
(67, 'SAssS', '2024-06-20 10:02:11', 'A'),
(68, 'hjgggjgjhg', '2024-06-20 12:10:49', 'A'),
(69, 'hgggjhgh', '2024-06-20 12:10:54', 'B'),
(70, 'admin', '2024-06-20 12:11:01', 'A'),
(71, 'user', '2024-06-20 12:11:11', 'B'),
(72, 'dsadaad', '2024-06-21 13:10:45', 'A'),
(73, 'dasdsada', '2024-06-21 13:10:51', 'B'),
(74, 'aaaaaaaaaaaaaa', '2024-06-21 13:10:57', 'B'),
(75, 'ADD', '2024-06-21 13:11:07', 'A'),
(76, 'SADSAA', '2024-06-21 13:11:13', 'B'),
(77, 'czcxczcczczczczczczzz', '2024-06-21 13:17:53', 'A'),
(78, 'cxzczzczczc', '2024-06-21 13:18:00', 'B'),
(79, 'dasda', '2024-06-21 13:35:14', 'A'),
(80, 'aaa', '2024-06-21 13:35:17', 'A'),
(81, 'sdadad', '2024-06-21 13:39:40', 'A'),
(82, 'dadada', '2024-06-21 13:39:44', 'A'),
(83, 'dsadada', '2024-06-21 13:39:48', 'A'),
(84, 'dsadada', '2024-06-21 13:39:50', 'A'),
(85, 'dasdada', '2024-06-21 13:43:02', 'A'),
(86, 'admin to', '2024-06-21 13:43:10', 'A'),
(87, 'user to', '2024-06-21 13:43:19', 'B'),
(88, 'DSADASD', '2024-06-21 15:39:22', 'B'),
(89, 'DSADA', '2024-06-21 15:39:31', 'A'),
(90, 'dsada', '2024-06-21 15:40:30', 'B'),
(91, 'saSSAs', '2024-06-21 15:41:42', 'B'),
(92, 'saSSss', '2024-06-21 15:41:49', 'A'),
(93, 'AAAAA', '2024-06-21 15:41:53', 'A'),
(94, 'DSDAA', '2024-06-21 15:42:01', 'B'),
(95, 'DSA', '2024-06-21 15:42:15', 'A'),
(96, 'DFSF', '2024-06-21 15:43:30', 'B'),
(97, 'DFSF', '2024-06-21 15:43:38', 'A'),
(98, 'SDFS', '2024-06-21 15:43:50', 'B'),
(99, 'ADMIN', '2024-06-21 15:43:57', 'B'),
(100, 'DEDE', '2024-06-21 15:44:04', 'A'),
(101, 'dsaddadad', '2024-06-21 16:07:34', 'B'),
(102, 'xxdsdad', '2024-06-21 16:07:38', 'A'),
(103, 'dsadsadsada', '2024-06-21 16:08:17', 'B'),
(104, 'dasdadada', '2024-06-21 16:08:22', 'A'),
(105, '43242', '2024-06-22 00:57:51', 'B'),
(106, '442342', '2024-06-22 00:58:52', 'B'),
(107, 'werw', '2024-06-22 01:05:56', 'B'),
(108, 'tretete', '2024-06-22 01:06:01', 'B'),
(109, 'dsadsadad', '2024-06-22 01:08:52', 'B'),
(110, 'dsadada', '2024-06-22 01:09:02', 'B'),
(111, 'dadada', '2024-06-22 01:11:46', 'B'),
(112, 'dsada', '2024-06-22 01:12:54', 'B'),
(113, 'ewqeqeq', '2024-06-22 01:13:19', 'B'),
(114, 'qeqweq', '2024-06-22 01:14:54', 'A'),
(115, 'admin', '2024-06-22 01:15:07', 'A'),
(116, 'eqeq', '2024-06-22 01:15:11', 'B'),
(117, 'eweweq', '2024-06-22 01:19:27', 'B'),
(118, 'ewqeeqe', '2024-06-22 01:19:32', 'B'),
(119, 'sxsa', '2024-06-22 01:23:55', 'B'),
(120, 'gddf', '2024-06-22 01:24:03', 'A'),
(121, 'ad', '2024-06-22 01:24:34', 'A'),
(122, 'dasdadad', '2024-06-22 01:43:34', 'B'),
(123, 'saSSa', '2024-06-22 01:47:07', 'B'),
(124, 'sadad', '2024-06-22 01:47:20', 'B'),
(125, 'saSs', '2024-06-22 01:47:30', 'A'),
(126, 'dsadasdas', '2024-06-22 01:52:02', 'B'),
(127, 'dsada', '2024-06-22 01:52:05', 'B'),
(128, 'dasda', '2024-06-22 01:54:22', 'B'),
(129, 'fsdf', '2024-06-22 01:59:07', 'A'),
(130, 'xxZX', '2024-06-22 02:03:49', 'A'),
(131, 'dsada', '2024-06-22 02:04:57', 'B'),
(132, 'xzxz', '2024-06-22 02:05:01', 'A'),
(133, 'sASs', '2024-06-22 02:09:54', 'B'),
(134, 'admin?', '2024-06-22 02:10:01', 'A'),
(135, 'fdsfs', '2024-06-22 02:10:19', 'B'),
(136, 'xzxxx', '2024-06-22 15:14:42', 'A'),
(137, 'dasdadsa', '2024-06-23 02:21:39', 'A'),
(138, 'dsdada', '2024-06-23 02:32:18', 'A'),
(139, 'aaaaaaaaaaaa', '2024-06-23 02:32:25', 'A'),
(140, 'aSSSSSSSSSSSSSSSSSS', '2024-06-23 02:32:35', 'B'),
(141, 'DASDADA', '2024-06-23 02:34:57', 'A'),
(142, 'DSADAS', '2024-06-23 02:36:08', 'A'),
(143, 'DSADAD', '2024-06-23 02:36:29', 'A'),
(144, 'vgfgd', '2024-06-23 02:43:08', 'A'),
(145, 'gdfgfd', '2024-06-23 02:43:11', 'A'),
(146, 'hfghffhh', '2024-06-23 02:43:49', 'A'),
(147, 'hgfhfhf', '2024-06-23 02:43:52', 'A'),
(148, 'dasdada', '2024-06-23 02:46:40', 'A'),
(149, 'dsadadsa', '2024-06-23 02:46:43', 'A'),
(150, 'fsdfsfs', '2024-06-23 02:47:18', 'B'),
(151, 'rrwrerw', '2024-06-23 03:03:32', 'A'),
(152, 'sAS', '2024-06-23 03:08:58', 'A'),
(153, 'dsadsa', '2024-06-23 03:50:48', 'A'),
(154, 'dsadada', '2024-06-23 03:51:35', 'A'),
(155, 'dsadadadad', '2024-06-23 03:52:16', 'A'),
(156, 'admin to', '2024-06-23 03:52:25', 'A'),
(157, 'user naman to', '2024-06-23 03:52:35', 'B'),
(158, 'fwefewf', '2024-06-23 04:20:16', 'B'),
(159, 'popiop', '2024-06-23 04:20:31', 'A'),
(160, 'dsadsadada', '2024-06-23 04:25:31', 'B'),
(161, 'dsadadad', '2024-06-23 04:31:23', 'B'),
(162, 'user', '2024-06-23 04:31:30', 'B'),
(163, 'admin', '2024-06-23 04:31:36', 'A'),
(164, 'dsdadd', '2024-06-23 04:38:31', 'A'),
(165, 'dsdadas', '2024-06-23 04:38:41', 'B'),
(166, 'aaaaaaaaaaaaa', '2024-06-23 04:38:47', 'A'),
(167, 'hrghf', '2024-06-28 04:50:44', 'B'),
(168, 'hi ako ba to', '2024-06-28 05:06:12', 'B'),
(169, 'oo cashier rin to', '2024-06-28 05:16:10', 'A'),
(170, 'ako ang admin', '2024-06-28 05:16:27', 'A'),
(171, 'k', '2024-06-28 05:16:45', 'B');

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
-- Table structure for table `tbl_cart`
--

CREATE TABLE `tbl_cart` (
  `cart_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_cart`
--

INSERT INTO `tbl_cart` (`cart_id`, `user_id`, `product_id`, `quantity`) VALUES
(1, 29, 158, 28),
(4, 29, 165, 17),
(5, 29, 134, 6),
(6, 29, 146, 11),
(7, 29, 149, 22),
(8, 29, 156, 30),
(10, 29, 148, 5),
(11, 29, 168, 1),
(12, 49, 149, 9),
(13, 49, 167, 1),
(14, 49, 158, 2),
(15, 49, 165, 2),
(16, 50, 157, 1),
(17, 49, 168, 2);

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
  `price` decimal(10,2) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_orders`
--

INSERT INTO `tbl_orders` (`order_id`, `product_name`, `order_date`, `quantity`, `price`, `user_id`, `product_id`) VALUES
(323, 'Cleaning Solutions', '2024-06-26', 3, 1200.00, 29, 149),
(328, 'rssdvvv', '2024-06-26', 1, 23.00, 29, 165),
(334, 'JANITORIAL AND HOUSEKEEPING SUPPLIES', '2024-06-26', 3, 7500.00, 29, 148),
(337, 'JANITORIAL AND HOUSEKEEPING SUPPLIES', '2024-06-26', 4, 8.00, 29, 148),
(338, 'Cleaning Solutions', '2024-06-26', 16, 6400.00, 29, 149),
(339, 'Tissue', '2024-06-26', 29, 5800.00, 29, 156),
(340, 'Cleaning Solutions', '2024-06-26', 16, 6400.00, 29, 149),
(341, 'Tissue', '2024-06-26', 29, 5800.00, 29, 156),
(342, 'rssdvvv', '2024-06-26', 17, 391.00, 29, 165),
(343, 'Mop', '2024-06-26', 6, 600.00, 29, 134),
(344, 'Trashbag', '2024-06-26', 9, 1800.00, 29, 146),
(345, 'Cleaning Solutions', '2024-06-26', 16, 6400.00, 29, 149),
(347, 'Cleaning Solutions', '2024-06-26', 16, 6400.00, 29, 149),
(348, 'Tissue', '2024-06-27', 29, 5800.00, 29, 156),
(349, 'JANITORIAL AND HOUSEKEEPING SUPPLIES', '2024-06-27', 4, 8.00, 29, 148),
(350, 'Tissue', '2024-06-27', 29, 5800.00, 29, 156),
(351, 'JANITORIAL AND HOUSEKEEPING SUPPLIES', '2024-06-27', 4, 8.00, 29, 148),
(352, 'Dispenser', '2024-06-27', 23, 23.00, 29, 158),
(353, 'JANITORIAL AND HOUSEKEEPING SUPPLIES', '2024-06-27', 4, 8.00, 29, 148),
(354, 'Mop', '2024-06-27', 6, 600.00, 29, 134),
(355, 'Trashbag', '2024-06-27', 9, 1800.00, 29, 146),
(356, 'Dispenser', '2024-06-27', 28, 28.00, 29, 158),
(357, 'Tissue', '2024-06-27', 29, 5800.00, 29, 156),
(358, 'Cleaning Solutions', '2024-06-27', 1, 400.00, 29, 149),
(359, 'Cleaning Solutions', '2024-06-27', 1, 400.00, 29, 149),
(360, 'rssdvvv', '2024-06-27', 17, 391.00, 29, 165),
(361, 'Mop', '2024-06-27', 6, 600.00, 29, 134),
(362, 'Dispenser', '2024-06-27', 28, 28.00, 29, 158),
(363, 'rssdvvv', '2024-06-27', 17, 391.00, 29, 165),
(364, 'Cleaning Solutions', '2024-06-27', 2, 800.00, 29, 149),
(365, 'Tissue', '2024-06-27', 29, 5800.00, 29, 156),
(366, 'Cleaning Solutions', '2024-06-27', 7, 2800.00, 29, 149),
(367, 'Tissue', '2024-06-27', 29, 5800.00, 29, 156),
(368, 'rssdvvv', '2024-06-27', 17, 391.00, 29, 165),
(369, 'Mop', '2024-06-27', 6, 600.00, 29, 134),
(370, 'Dispenser', '2024-06-27', 28, 28.00, 29, 158),
(371, 'rssdvvv', '2024-06-27', 17, 391.00, 29, 165),
(372, 'Dispenser', '2024-06-27', 28, 28.00, 29, 158),
(373, 'rssdvvv', '2024-06-27', 17, 391.00, 29, 165),
(374, 'Dispenser', '2024-06-27', 28, 28.00, 29, 158),
(375, 'rssdvvv', '2024-06-27', 17, 391.00, 29, 165),
(376, 'Dispenser', '2024-06-27', 28, 28.00, 29, 158),
(377, 'rssdvvv', '2024-06-27', 17, 391.00, 29, 165),
(378, 'Dispenser', '2024-06-27', 28, 28.00, 29, 158),
(379, 'rssdvvv', '2024-06-27', 17, 391.00, 29, 165),
(380, 'Dispenser', '2024-06-27', 28, 28.00, 29, 158),
(381, 'rssdvvv', '2024-06-27', 17, 391.00, 29, 165),
(382, 'Dispenser', '2024-06-27', 28, 28.00, 29, 158),
(383, 'rssdvvv', '2024-06-27', 17, 391.00, 29, 165),
(384, 'Dispenser', '2024-06-27', 28, 28.00, 29, 158),
(385, 'rssdvvv', '2024-06-27', 17, 391.00, 29, 165),
(386, 'Dispenser', '2024-06-27', 28, 28.00, 29, 158),
(387, 'rssdvvv', '2024-06-27', 17, 391.00, 29, 165),
(388, 'Dispenser', '2024-06-27', 28, 28.00, 29, 158),
(389, 'rssdvvv', '2024-06-27', 17, 391.00, 29, 165),
(390, 'Dispenser', '2024-06-27', 28, 28.00, 29, 158),
(391, 'rssdvvv', '2024-06-27', 17, 391.00, 29, 165),
(392, 'Dispenser', '2024-06-27', 28, 28.00, 29, 158),
(393, 'rssdvvv', '2024-06-27', 17, 391.00, 29, 165),
(394, 'Dispenser', '2024-06-27', 28, 28.00, 29, 158),
(395, 'rssdvvv', '2024-06-27', 17, 391.00, 29, 165),
(396, 'Mop', '2024-06-27', 6, 600.00, 29, 134),
(397, 'Tissue', '2024-06-27', 29, 5800.00, 29, 156),
(398, 'Mop', '2024-06-27', 6, 600.00, 29, 134),
(399, 'Trashbag', '2024-06-27', 10, 2000.00, 29, 146),
(400, 'Cleaning Solutions', '2024-06-27', 9, 3600.00, 29, 149),
(401, 'Tissue', '2024-06-27', 29, 5800.00, 29, 156),
(402, 'rssdvvv', '2024-06-27', 17, 391.00, 29, 165),
(403, 'Mop', '2024-06-27', 6, 600.00, 29, 134),
(404, 'Dispenser', '2024-06-27', 28, 33600.00, 29, 158),
(405, 'rssdvvv', '2024-06-27', 17, 391.00, 29, 165),
(406, 'Tissue', '2024-06-28', 30, 6000.00, 29, 156),
(407, 'JANITORIAL AND HOUSEKEEPING SUPPLIES', '2024-06-28', 5, 12500.00, 29, 148),
(408, 'Cleaning Solutions', '2024-07-01', 1, 4005.00, 49, 149),
(409, 'Cleaning Solutions', '2024-07-01', 2, 8010.00, 49, 149),
(410, 'r', '2024-07-01', 1, 66.00, 49, 168),
(411, 'w', '2024-07-01', 1, 22.00, 50, 167);

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
(134, 'uploads/mop.jpg', 'Mop', 74, 100.9, 86, 'mop'),
(146, 'uploads/trash bag.jpg', 'Trashbag', 74, 200, 30, 'trashbag '),
(148, 'uploads/1520134752632.jpg', 'JANITORIAL AND HOUSEKEEPING SUPPLIES', 74, 25300, 97, 'equipments'),
(149, 'uploads/large_20150714_115829.jpg', 'Cleaning Solutions', 75, 4005, 146, 'cleaning'),
(156, 'uploads/tissue.png', 'Tissue', 72, 200, 11, 'Tissue paper'),
(157, 'uploads/papercups.png', 'Paper Cups', 72, 289, 15, 'Paper cups'),
(158, 'uploads/dispenser.png', 'Dispenser', 72, 1200, 3, 'Dispenser'),
(161, 'uploads/Screenshot 2024-03-18 233514.png', 'tttt', 72, 345, 345, 'asd'),
(162, 'uploads/Screenshot 2024-03-14 005448.png', 'ty', 74, 4, 43, 'refd'),
(165, 'uploads/Screenshot 2024-03-19 005316.png', 'rssdvvv', 73, 23, 11, 'xsa'),
(167, 'uploads/RIZAL Magazine templates.png', 'w', 75, 22, 2, 'ads'),
(168, 'uploads/philippines_flag.png', 'r', 73, 66, 7, 'jg'),
(169, 'uploads/travel.jpg', 'kh', 75, 7, 67, 'jf'),
(177, 'uploads/Jose-Rizal-Travel-Tips-MAINIMAGE.jpg', 'khhf', 73, 665, 65, 'j');

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
(23, 'User1', 'user@gmail.com', 'user123456', 'user', 'f05ec8b16268e243459de3951f7d3b7f', NULL),
(29, 'admin', 'admin@gmail.com', 'admin123', 'admin', '', '0000-00-00 00:00:00'),
(38, 'jo', 'jo@gmail.com', '12345', 'user', NULL, NULL),
(49, 'Jo4', 'jo4@gmail.com', '$2y$10$GeG.1DavojB.WjrhkyFdWugOwr0/NGiYCQs9wmzTQUGWfp0yfdaKO', 'user', NULL, NULL),
(50, 'Test', 'test@gmail.com', '$2y$10$gZxg6LktCSHrY8lwXcSdcO18eqtZ7rKF90JsV7OufdioxWsUhK1US', 'user', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_details`
--

CREATE TABLE `user_details` (
  `user_id` int(11) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `gender` enum('Male','Female','Other') DEFAULT 'Male',
  `birthday` date DEFAULT NULL,
  `mobile_number` varchar(20) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_details`
--

INSERT INTO `user_details` (`user_id`, `full_name`, `gender`, `birthday`, `mobile_number`, `address`) VALUES
(38, 'jo', 'Female', '2015-02-02', '9656189470', 'dasma'),
(41, 'Jo', 'Female', '2011-05-24', '9656278124', 'dasma'),
(43, 'Jo', 'Female', '2023-07-06', '9656278124', 'dasma'),
(44, 'Jo', 'Female', '2023-07-06', '9656278124', 'dasma'),
(45, 'Jo11', 'Female', '2024-06-30', '9656278124', 'dasma'),
(46, 'Jo11', 'Female', '2024-04-03', '9656278124', 'dasma'),
(47, 'Jo4', 'Female', '2024-02-08', '9656278124', 'dasma'),
(48, 'Jo4', 'Female', '2024-02-08', '9656278124', 'dasma'),
(49, 'JoannaC', 'Female', '2024-01-04', '9656278124', 'dasma'),
(50, 'Test', 'Female', '2023-10-03', '9781234456', 'Test');

-- --------------------------------------------------------

--
-- Table structure for table `wishlist`
--

CREATE TABLE `wishlist` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `wishlist`
--

INSERT INTO `wishlist` (`id`, `user_id`, `product_id`, `created_at`) VALUES
(3, 29, 146, '2024-06-27 16:04:30'),
(5, 29, 158, '2024-06-27 16:04:53'),
(6, 29, 156, '2024-06-27 16:06:04'),
(7, 29, 157, '2024-06-27 16:08:27'),
(8, 29, 148, '2024-06-27 16:08:37'),
(10, 29, 134, '2024-06-27 16:08:43'),
(11, 29, 161, '2024-06-27 16:09:27'),
(14, 29, 167, '2024-06-30 15:55:49'),
(15, 29, 149, '2024-06-30 16:21:03'),
(16, 49, 157, '2024-06-30 16:23:01'),
(17, 49, 149, '2024-06-30 17:09:33'),
(18, 50, 146, '2024-06-30 17:32:35'),
(19, 50, 148, '2024-06-30 17:32:38'),
(20, 49, 165, '2024-06-30 17:47:30');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `add_user`
--
ALTER TABLE `add_user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `messagesc`
--
ALTER TABLE `messagesc`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stock`
--
ALTER TABLE `stock`
  ADD PRIMARY KEY (`stock_id`),
  ADD KEY `fk_stock_product` (`product_id`);

--
-- Indexes for table `tbl_cart`
--
ALTER TABLE `tbl_cart`
  ADD PRIMARY KEY (`cart_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`);

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
-- Indexes for table `user_details`
--
ALTER TABLE `user_details`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `wishlist`
--
ALTER TABLE `wishlist`
  ADD PRIMARY KEY (`id`),
  ADD KEY `wishlist_ibfk_1` (`user_id`),
  ADD KEY `fk_product_id` (`product_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `add_user`
--
ALTER TABLE `add_user`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `messagesc`
--
ALTER TABLE `messagesc`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=172;

--
-- AUTO_INCREMENT for table `stock`
--
ALTER TABLE `stock`
  MODIFY `stock_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `tbl_cart`
--
ALTER TABLE `tbl_cart`
  MODIFY `cart_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `tbl_category`
--
ALTER TABLE `tbl_category`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=76;

--
-- AUTO_INCREMENT for table `tbl_orders`
--
ALTER TABLE `tbl_orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=412;

--
-- AUTO_INCREMENT for table `tbl_product`
--
ALTER TABLE `tbl_product`
  MODIFY `pid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=178;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `wishlist`
--
ALTER TABLE `wishlist`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

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
-- Constraints for table `tbl_cart`
--
ALTER TABLE `tbl_cart`
  ADD CONSTRAINT `tbl_cart_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `tbl_cart_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `tbl_product` (`pid`);

--
-- Constraints for table `tbl_orders`
--
ALTER TABLE `tbl_orders`
  ADD CONSTRAINT `fk_orders_product` FOREIGN KEY (`product_name`) REFERENCES `tbl_product` (`pname`);

--
-- Constraints for table `wishlist`
--
ALTER TABLE `wishlist`
  ADD CONSTRAINT `fk_product_id` FOREIGN KEY (`product_id`) REFERENCES `tbl_product` (`pid`),
  ADD CONSTRAINT `wishlist_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `wishlist_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `tbl_product` (`pid`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
