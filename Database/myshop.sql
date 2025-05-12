-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 12, 2025 at 04:35 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `myshop`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `admin_id` int(10) NOT NULL,
  `admin_email` varchar(100) NOT NULL,
  `admin_pass` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`admin_id`, `admin_email`, `admin_pass`) VALUES
(1, 'abc@gmail.com', 'abc'),
(2, 'def@gmail.com', 'def');

-- --------------------------------------------------------

--
-- Table structure for table `brands`
--

CREATE TABLE `brands` (
  `brand_id` int(10) NOT NULL,
  `brand_title` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `brands`
--

INSERT INTO `brands` (`brand_id`, `brand_title`) VALUES
(2, 'ASPENHOME'),
(3, 'AMERICAN DREW'),
(4, 'BEST HOME FURNISHINGS'),
(5, 'BRENTWOOD CLASSICS'),
(7, 'BEDGEAR');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `p_id` int(10) NOT NULL,
  `ip_add` varchar(255) NOT NULL,
  `qty` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `cat_id` int(10) NOT NULL,
  `cat_title` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`cat_id`, `cat_title`) VALUES
(2, 'SOFAS & LOUNGERS'),
(3, 'WARDROBES'),
(4, 'DINING SETS'),
(5, 'SHOE RACKS'),
(6, 'STUDY TABLES\r\n'),
(7, 'LAPTOP TABLES'),
(8, 'OFFICE CHAIRS'),
(10, 'BEDS'),
(11, 'ABC');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `customer_id` int(10) NOT NULL,
  `customer_name` varchar(100) NOT NULL,
  `customer_email` varchar(100) NOT NULL,
  `customer_pass` varchar(100) NOT NULL,
  `customer_country` text NOT NULL,
  `customer_city` text NOT NULL,
  `customer_contact` text NOT NULL,
  `customer_address` text NOT NULL,
  `customer_image` text NOT NULL,
  `customer_ip` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`customer_id`, `customer_name`, `customer_email`, `customer_pass`, `customer_country`, `customer_city`, `customer_contact`, `customer_address`, `customer_image`, `customer_ip`) VALUES
(1, 'Haymant Mangla', 'haymant_1998@outlook.com', 'admin', 'India', 'Moga', '8968687874', 'adadm', 'photo.jpg', '::1'),
(2, 'Mahesh Jadhav', 'jadhavmahes6244@gmail.com', 'Test@1234', 'India', 'Mumbai', '9359613329', 'Mangaldham Society, ISCKON temple road, Dharmaraj Chowk, Ravet', 'Ashish img.jpg', '::1'),
(3, 'Ashish Santosh Mishra', 'mishraashishsantosh2001@gmail.com', 'Ashish@123', 'India', 'Pune', '7875466597', 'Kharabwadi Chakan', 'Ashish img.jpg', '::1'),
(4, 'Mahesh Jadhav', 'jadhavmahes6244@gmail.com', 'Test@1234', 'India', 'Pune', '9632587410', 'Mangaldham Society, ISCKON temple road, Dharmaraj Chowk, Ravet', 'Ashish img.jpg', '::1'),
(5, 'Mahesh Jadhav', 'jadhavmahes6244@gmail', 'Test@123', 'India', 'Pune', '9359613329', 'Mangaldham Society, ISCKON temple road, Dharmaraj Chowk, Ravet', 'Ashish img.jpg', '::1');

-- --------------------------------------------------------

--
-- Table structure for table `customer_orders`
--

CREATE TABLE `customer_orders` (
  `order_id` int(10) NOT NULL,
  `customer_id` int(10) NOT NULL,
  `due_amount` int(100) NOT NULL,
  `invoice_no` int(100) NOT NULL,
  `total_products` int(100) NOT NULL,
  `order_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `order_status` text NOT NULL,
  `payment_method` varchar(255) DEFAULT NULL,
  `payment_id` varchar(255) DEFAULT NULL,
  `product_names` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `customer_orders`
--

INSERT INTO `customer_orders` (`order_id`, `customer_id`, `due_amount`, `invoice_no`, `total_products`, `order_date`, `order_status`, `payment_method`, `payment_id`, `product_names`) VALUES
(1, 1, 2336, 537, 4, '2025-05-12 10:07:29', 'Pending', 'Razorpay', 'COD', NULL),
(2, 1, 290, 697, 1, '2025-05-12 10:55:12', 'Complete', 'Razorpay', 'COD', NULL),
(3, 1, 148, 59, 1, '2025-05-12 10:56:51', 'Failed', 'Razorpay', 'pay_QTzaL3zjvewJHP', NULL),
(4, 1, 1479, 543, 1, '2025-05-12 11:00:06', 'Pending', 'Razorpay', 'COD', NULL),
(5, 1, 349, 816, 1, '2025-05-12 11:01:19', 'Failed', 'Razorpay', 'pay_QTzf9ZmjQ2e1jA', NULL),
(6, 2, 1479, 705, 1, '2025-05-12 11:13:23', 'Pending', 'COD', 'COD', NULL),
(7, 2, 149, 776, 1, '2025-05-12 11:16:43', 'Failed', 'Razorpay', 'pay_QTzvPc1kV9A1SV', NULL),
(8, 2, 1479, 620, 1, '2025-05-12 11:17:39', 'Failed', 'Razorpay', 'pay_QTzwMJ7ihWdYxe', NULL),
(9, 2, 1, 180, 1, '2025-05-12 11:23:56', 'Failed', 'Razorpay', 'pay_QU031uwp63dofH', NULL),
(10, 2, 1, 238, 1, '2025-05-12 13:19:25', 'Complete', 'Razorpay', 'pay_QU1n21IgT3cBGy', NULL),
(11, 2, 1, 957, 1, '2025-05-12 13:21:08', 'Complete', 'Razorpay', 'pay_QU22iGF527eYvK', NULL),
(12, 2, 1479, 86, 1, '2025-05-12 14:20:09', 'Pending', 'COD', 'COD', ''),
(13, 2, 290, 218, 1, '2025-05-12 14:23:29', 'Pending', 'COD', 'COD', 'Kosmo Grace Three Door Wardrobe with Drawer & Locker in Rigato Walnut Finish');

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `payment_id` int(10) NOT NULL,
  `invoice_no` int(10) NOT NULL,
  `amount` int(10) NOT NULL,
  `payment_mode` text NOT NULL,
  `ref_no` int(10) NOT NULL,
  `code` int(10) NOT NULL,
  `payment_date` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`payment_id`, `invoice_no`, `amount`, `payment_mode`, `ref_no`, `code`, `payment_date`) VALUES
(1, 537, 2336, 'Easypay/UBL Transfer', 12345, 123, '12-05-2025');

-- --------------------------------------------------------

--
-- Table structure for table `pending_order`
--

CREATE TABLE `pending_order` (
  `order_id` int(10) NOT NULL,
  `customer_id` int(10) NOT NULL,
  `invoice_no` int(10) NOT NULL,
  `product_id` int(10) NOT NULL,
  `qty` int(10) NOT NULL,
  `order_status` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `pending_order`
--

INSERT INTO `pending_order` (`order_id`, `customer_id`, `invoice_no`, `product_id`, `qty`, `order_status`) VALUES
(1, 1, 537, 8, 1, 'Pending'),
(2, 1, 697, 5, 1, 'Complete'),
(3, 1, 59, 3, 1, 'Failed'),
(4, 1, 543, 4, 1, 'Pending'),
(5, 1, 816, 8, 1, 'Failed'),
(6, 2, 705, 4, 1, 'Pending'),
(7, 2, 776, 2, 1, 'Failed'),
(8, 2, 620, 4, 1, 'Failed'),
(9, 2, 180, 9, 1, 'Failed'),
(10, 2, 238, 9, 1, 'Complete'),
(11, 2, 957, 9, 1, 'Complete'),
(12, 2, 86, 4, 1, 'Pending'),
(13, 2, 218, 5, 1, 'Pending');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` int(10) NOT NULL,
  `cat_id` int(10) NOT NULL,
  `brand_id` int(10) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `product_title` text NOT NULL,
  `status` text NOT NULL,
  `product_img1` text NOT NULL,
  `product_img2` text NOT NULL,
  `product_img3` text NOT NULL,
  `product_price` int(10) NOT NULL,
  `product_desc` text NOT NULL,
  `product_keywords` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `cat_id`, `brand_id`, `date`, `product_title`, `status`, `product_img1`, `product_img2`, `product_img3`, `product_price`, `product_desc`, `product_keywords`) VALUES
(2, 6, 3, '2019-03-17 11:02:29', 'Leiko Study Desk with Book Shelf in Nut Brown Finish', 'on', 'prod 2-1.png', 'prod 2-2.png', 'prod 2-3.png', 149, 'Mintwud presents a wide showcase of modern furniture thats designed to seamlessly blend with your interiors. Crafted for compact homes, the range is clean and convenient. All the collections have an understated design aesthetic that adapt to any space. The designs represent the ideals of cutting excess, practicality and an absence of decoration.', 'study table'),
(3, 5, 4, '2019-03-17 11:02:38', 'Aperi Solid Wood Shoe Rack With Center shelf in Provincial Teak Finish ', 'on', 'prod 3-1.png', 'prod 3-2.png', 'prod 3-3.png', 148, 'Contemporary Furniture reflects designs that are current or en vogue. It doesnt necessarily reference historical design styles and often provides a feeling of everything in its place.', 'shoe rack'),
(4, 4, 5, '2019-03-17 11:02:49', 'Tiber Solid Wood Six Seater Dining Set in Premium Acacia Finish', 'on', 'prod 4-1.png', 'prod 4-2.png', 'prod 4-3.png', 1479, 'Rustic, rich & retreat. An undeniably dramatic Acacia wood collection which adds to your vanity.\r\n\r\nReflecting designs that are Classic and Contemporary; Woodsworth delivers the right blend of aesthetics and functionality, as well as comfort and promised quality.', 'dining sets'),
(5, 3, 1, '2019-03-17 11:03:04', 'Kosmo Grace Three Door Wardrobe with Drawer & Locker in Rigato Walnut Finish', 'on', 'prod 5-1.png', 'prod 5-2.png', 'prod 5-3.png', 290, 'Modern Furniture reflects the design philosophy of form following function prevalent in modernism. These designs represent the ideals of cutting excess, practicality and an absence of decoration.\r\n\r\nThe forms of furniture are visually light (like in the use of polished metal and engineered wood) and follow minimalist principles of design which are influenced by architectural concepts like the cantilever. Modern furniture fits best in open floor plans with clean lines that thrive in the absence of clutter.', 'Kosmo Grace Three Door Wardrobe'),
(6, 7, 3, '2019-03-17 11:01:48', 'Half and Half Portable Folding multipurpose Laptop cum Study Table in Green Colour', 'on', 'prod 6-1.png', 'prod 6-2.png', 'prod 6-3.png', 159, 'Sattva Portable Folding Laptop table is made of high quality pine wood material with exquisiteWorkmanship makes it durable and light enough to carry easily.', 'study table, laptop table'),
(7, 1, 1, '2019-03-17 11:01:19', 'Stanfield Solid Wood Queen Size Bed in Honey oak Finish', 'on', 'prod 7-1.png', 'prod 7-2.png', 'prod 7-3.png', 349, 'Colonial Style Furniture is graceful and refined, often characterized by the use of turnings, curved legs and motifs to present an elegant appearance. Colonial Style Furniture on Pepperfry sees Indian craftsmen interpreting European period styles (such as the Queen Anne and Georgian styles) in indigenous woods like Sheesham and Mango.', 'beds, '),
(8, 2, 2, '2019-03-17 11:01:33', 'Cielo One Seater Sofa in Chestnut Brown Colour', 'on', 'prod 8-1.png', 'prod 8-2.png', 'prod 8-3.png', 349, 'Robust & Well Crafted.\r\nCrafted with a neat silhouette, Cielo makes for an enduring sofa with its deep-set seat and styling.\r\nCasaCraft offers the best in comfort, with elan. The collections are a series of modern designs, which are simple yet striking and represent the ideals of minimalism and cutting excess. The designs are a perfect blend of functionality and exceptional aesthetics. Each piece is crafted with passion and reflects quality and style, addressing the needs of a wide range of audience.', 'sofas,'),
(9, 11, 5, '2025-05-12 11:23:05', 'xyz', 'on', 'pexels-cottonbro-5875695.jpg', '', '', 1, 'abc abc abc', 'xyz');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `brands`
--
ALTER TABLE `brands`
  ADD PRIMARY KEY (`brand_id`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`p_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`cat_id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`customer_id`);

--
-- Indexes for table `customer_orders`
--
ALTER TABLE `customer_orders`
  ADD PRIMARY KEY (`order_id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`payment_id`);

--
-- Indexes for table `pending_order`
--
ALTER TABLE `pending_order`
  ADD PRIMARY KEY (`order_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `admin_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `brands`
--
ALTER TABLE `brands`
  MODIFY `brand_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `cat_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `customer_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `customer_orders`
--
ALTER TABLE `customer_orders`
  MODIFY `order_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `payment_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `pending_order`
--
ALTER TABLE `pending_order`
  MODIFY `order_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
