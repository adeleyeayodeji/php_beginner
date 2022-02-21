-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jan 20, 2022 at 07:35 AM
-- Server version: 5.7.31-log
-- PHP Version: 7.4.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `phpbeginner`
--

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

DROP TABLE IF EXISTS `category`;
CREATE TABLE IF NOT EXISTS `category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(1000) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `name`) VALUES
(9, 'Well'),
(8, 'Yes '),
(6, 'Wawooo'),
(10, 'Products');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

DROP TABLE IF EXISTS `comments`;
CREATE TABLE IF NOT EXISTS `comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(255) DEFAULT NULL,
  `message` text,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` int(11) DEFAULT '0',
  `post_id` bigint(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `user_id`, `message`, `timestamp`, `status`, `post_id`) VALUES
(7, 7, 'skdjhjksdfsd', '2021-10-04 13:48:16', 1, 5);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
CREATE TABLE IF NOT EXISTS `orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` varchar(1000) DEFAULT NULL,
  `amount` varchar(1000) DEFAULT NULL,
  `user_id` int(255) DEFAULT NULL,
  `product_id` int(255) DEFAULT NULL,
  `quantity` int(255) DEFAULT NULL,
  `status` varchar(1000) DEFAULT NULL,
  `payment_status` varchar(1000) DEFAULT NULL,
  `payment_method` varchar(1000) DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=26 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `order_id`, `amount`, `user_id`, `product_id`, `quantity`, `status`, `payment_status`, `payment_method`, `timestamp`) VALUES
(20, '724037562', '200000', 8, 3, 1, 'Processing', 'paid', 'paystack', '2021-11-10 21:59:50'),
(19, '724037562', '200000', 8, 6, 2, 'Processing', 'paid', 'paystack', '2021-11-10 21:59:50'),
(18, 'PHP_852567', '2000', 8, 6, 2, 'Processing', 'paid', 'flutterwave', '2021-11-10 21:59:14'),
(16, '378972760', '3584300', 8, 5, 1, 'Completed', 'paid', 'paystack', '2021-11-10 14:46:06'),
(15, '378972760', '3584300', 8, 6, 3, 'Completed', 'paid', 'paystack', '2021-11-10 14:46:06'),
(17, 'PHP_852567', '2000', 8, 3, 1, 'Processing', 'paid', 'flutterwave', '2021-11-10 21:59:14'),
(14, 'PHP_858724', '1000', 8, 6, 2, 'Completed', 'paid', 'flutterwave', '2021-11-10 14:45:38'),
(21, '313550967', '3584300', 9, 6, 3, 'Completed', 'paid', 'paystack', '2021-11-15 19:41:32'),
(22, '313550967', '3584300', 9, 5, 1, 'Completed', 'paid', 'paystack', '2021-11-15 19:41:32'),
(23, 'PHP_441073', '3000', 9, 3, 3, 'Processing', 'paid', 'flutterwave', '2021-11-15 19:43:26'),
(24, '929960435', '300000', 9, 6, 2, 'Processing', 'paid', 'paystack', '2021-11-16 16:09:57'),
(25, '929960435', '300000', 9, 3, 2, 'Processing', 'paid', 'paystack', '2021-11-16 16:09:57');

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

DROP TABLE IF EXISTS `posts`;
CREATE TABLE IF NOT EXISTS `posts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(1000) DEFAULT NULL,
  `content` text,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` int(11) NOT NULL DEFAULT '0',
  `category_id` varchar(1000) DEFAULT NULL,
  `thumbnail` varchar(1000) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `title`, `content`, `timestamp`, `status`, `category_id`, `thumbnail`) VALUES
(4, 'Another post', 'Quia non blanditiis ', '2021-09-29 09:48:37', 0, '6', 'uploads/588045-1a9U3x1519498143.jpg'),
(3, 'Quod quam accusamus ', 'Sed delectus illo s', '2021-09-29 09:15:06', 0, '9', 'uploads/485120-learn-to-code.jpg'),
(5, 'Third post', 'At dolorem deserunt ', '2021-09-29 09:48:55', 1, '9', 'uploads/best-php-tutorials-for-beginners.jpg'),
(6, 'New Post Now', 'skdjhfjsdhfkjsdnsdkjhfsd sdkjfhsdfsd', '2021-10-04 13:47:10', 1, '8', 'uploads/f5cb6616-79d4-4215-97bb-ec06804e10fd.png');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
CREATE TABLE IF NOT EXISTS `products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(1000) DEFAULT NULL,
  `image` varchar(1000) DEFAULT NULL,
  `status` int(255) DEFAULT '0',
  `category_id` varchar(1000) DEFAULT NULL,
  `content` text,
  `price` varchar(1000) DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `title`, `image`, `status`, `category_id`, `content`, `price`, `timestamp`) VALUES
(3, 'Product 2', 'uploads/61zo+IzGbtL._UX569_.jpg', 1, '10', 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using Content here, content here making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for lorem ipsum will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose injected humour and the like.\r\n\r\n', '1000', '2021-10-28 21:06:39'),
(5, 'Long Sleeve t shirts', 'uploads/61MSZWTT3IL._UY550_.jpg', 0, '10', '34dwewdwedwdwd', '34343', '2021-10-28 21:40:47'),
(6, 'Bread', 'uploads/milk-bread.jpg', 1, '10', 'njskajdnjksandasd sadsadas sadasd', '500', '2021-11-09 12:30:07');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(1000) DEFAULT NULL,
  `email` varchar(1000) DEFAULT NULL,
  `password` varchar(1000) DEFAULT NULL,
  `role` varchar(1000) NOT NULL DEFAULT 'user',
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`, `timestamp`) VALUES
(5, 'Adeleye Ayodeji', 'adeleyeayodeji@gmail.com', '827ccb0eea8a706c4c34a16891f84e7b', 'admin', '2021-09-29 12:44:00'),
(7, 'Biggi Man', 'biggiman@gmail.com', '536fdec61b8b1f4c50606e3f7a27541f', 'user', '2021-10-04 10:26:10'),
(8, 'Dominic Christensen', 'biggidroid@gmail.com', '1b0e5f02623d653f0f5ce09f6b1e0f54', 'user', '2021-11-02 21:14:10'),
(9, 'Test User', 'testuser@gmail.com', '827ccb0eea8a706c4c34a16891f84e7b', 'user', '2021-11-15 19:40:00');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
