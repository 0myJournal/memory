-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 10, 2020 at 02:18 PM
-- Server version: 10.4.13-MariaDB
-- PHP Version: 7.4.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `memory`
--

-- --------------------------------------------------------

--
-- Table structure for table `games`
--

CREATE TABLE `games` (
  `game_id` int(11) NOT NULL,
  `player_one_id` int(10) NOT NULL,
  `player_two_id` int(10) NOT NULL,
  `turns_player_one` int(10) NOT NULL,
  `turns_player_two` int(10) NOT NULL,
  `winner_id` int(10) DEFAULT NULL,
  `datetime` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `games`
--

INSERT INTO `games` (`game_id`, `player_one_id`, `player_two_id`, `turns_player_one`, `turns_player_two`, `winner_id`, `datetime`) VALUES
(15, 14, 13, 3, 1, 13, '2020-12-05 15:58:07'),
(16, 14, 13, 2, 3, 14, '2020-12-05 16:02:22'),
(17, 14, 13, 3, 1, 13, '2020-12-05 16:06:31'),
(18, 14, 13, 0, 1, 14, '2020-12-05 16:12:12'),
(19, 14, 13, 0, 1, 14, '2020-12-05 16:12:57'),
(20, 15, 14, 0, 0, NULL, '2020-12-05 18:42:37'),
(21, 15, 14, 0, 1, 15, '2020-12-05 18:43:21'),
(22, 15, 14, 0, 1, 15, '2020-12-05 18:44:47'),
(23, 15, 14, 0, 0, NULL, '2020-12-05 18:45:39'),
(24, 15, 41, 5, 14, 15, '2020-12-05 18:51:48'),
(25, 15, 41, 5, 11, 15, '2020-12-05 18:53:59'),
(26, 15, 41, 9, 7, 41, '2020-12-05 18:55:32'),
(27, 15, 41, 0, 1, 15, '2020-12-05 18:58:35'),
(28, 15, 41, 10, 9, 41, '2020-12-05 19:00:09'),
(29, 42, 41, 0, 1, 42, '2020-12-05 19:18:00'),
(30, 42, 41, 0, 1, 42, '2020-12-07 10:28:12'),
(31, 42, 41, 0, 1, 42, '2020-12-07 10:28:44'),
(32, 14, 13, 0, 1, 14, '2020-12-07 13:27:19'),
(33, 14, 13, 0, 1, 14, '2020-12-07 13:30:10'),
(34, 14, 13, 0, 2, 14, '2020-12-07 16:36:13'),
(35, 14, 13, 1, 1, NULL, '2020-12-07 16:37:20'),
(36, 14, 13, 0, 2, 14, '2020-12-07 16:37:54'),
(37, 14, 13, 1, 1, NULL, '2020-12-07 16:38:09'),
(38, 14, 13, 2, 4, 14, '2020-12-07 16:38:48'),
(39, 42, 13, 0, 1, 42, '2020-12-07 17:58:08'),
(40, 42, 13, 0, 2, 42, '2020-12-07 17:58:32'),
(41, 42, 13, 0, 1, 42, '2020-12-07 17:58:47'),
(42, 42, 13, 8, 10, 42, '2020-12-07 18:00:04'),
(43, 42, 13, 0, 0, NULL, '2020-12-07 18:02:31'),
(44, 42, 13, 2, 1, 13, '2020-12-07 18:02:57'),
(45, 15, 42, 2, 2, NULL, '2020-12-08 22:32:41'),
(46, 15, 42, 0, 1, 15, '2020-12-08 22:33:30'),
(47, 42, 41, 0, 2, 42, '2020-12-08 22:34:53'),
(48, 42, 41, 0, 2, 42, '2020-12-08 22:35:19'),
(49, 13, 41, 8, 8, NULL, '2020-12-08 22:37:56'),
(50, 15, 14, 10, 12, 15, '2020-12-08 22:43:14'),
(51, 43, 41, 2, 4, 43, '2020-12-08 22:48:22'),
(52, 41, 43, 3, 5, 41, '2020-12-08 22:50:32'),
(53, 44, 13, 1, 3, 44, '2020-12-08 22:58:46'),
(54, 44, 43, 0, 0, NULL, '2020-12-08 23:01:41'),
(55, 41, 44, 9, 10, 41, '2020-12-09 13:20:49'),
(56, 41, 42, 4, 1, 42, '2020-12-09 15:38:58'),
(57, 41, 13, 2, 5, 41, '2020-12-09 15:40:14'),
(58, 43, 44, 0, 1, 43, '2020-12-09 18:32:03'),
(59, 44, 43, 2, 1, 43, '2020-12-10 10:09:12'),
(60, 45, 14, 1, 1, NULL, '2020-12-10 10:10:59'),
(61, 45, 14, 1, 1, NULL, '2020-12-10 13:01:37');

-- --------------------------------------------------------

--
-- Table structure for table `images`
--

CREATE TABLE `images` (
  `image_id` int(11) NOT NULL,
  `image_name` varchar(20) DEFAULT NULL,
  `link` varchar(500) NOT NULL,
  `memory_use` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `images`
--

INSERT INTO `images` (`image_id`, `image_name`, `link`, `memory_use`) VALUES
(11, 'Orthodox Church', 'https://media-cdn.tripadvisor.com/media/photo-s/15/84/6c/01/russian-orthodox-church.jpg', 1),
(19, 'PHP', 'https://upload.wikimedia.org/wikipedia/commons/2/27/PHP-logo.svg', 1),
(20, 'mySQL', 'https://webwereld.nl/cmsdata/features/3760756/1q42wz8f3ij958r3_thumb800.gif', 1),
(25, 'Big Floppa', 'https://i.kym-cdn.com/entries/icons/facebook/000/034/421/cover1.jpg', 1),
(26, 'Koning David', 'https://upload.wikimedia.org/wikipedia/commons/a/a3/Gottlieb_Welt%C3%A9_-_King_David.jpg', 1),
(27, 'Johannes de doper', 'https://historiek.net/wp-content/uploads-phistor1/2010/08/Sint-Johannes-de-Doper-schilderij-van-Titiaan.jpeg', 1),
(30, 'Mattheüs ', 'https://upload.wikimedia.org/wikipedia/commons/7/7f/Rembrandt_Harmensz._van_Rijn_049.jpg', 1),
(31, 'Paulus', 'https://upload.wikimedia.org/wikipedia/commons/3/32/Rembrandt_Harmensz._van_Rijn_163.jpg', 1),
(32, 'bekering van Paulus', 'https://upload.wikimedia.org/wikipedia/commons/thumb/2/21/Michelangelo%2C_paolina%2C_conversione_di_saulo_01.jpg/399px-Michelangelo%2C_paolina%2C_conversione_di_saulo_01.jpg', 1),
(33, 'Heilige Maria', 'https://upload.wikimedia.org/wikipedia/commons/5/5c/L%27_Annonciation_de_1644%2C_Philippe_de_Champaigne..jpg', 1),
(34, 'laatste avondmaal', 'https://m.media-amazon.com/images/S/aplus-media/sc/f4d7f045-b648-4def-b6b2-0a9a6a80dd29.__CR0,0,970,600_PT0_SX970_V1___.jpg', 1),
(36, NULL, 'https://cdn.webshopapp.com/shops/3533/files/32176966/poopoopeedo-poo-poo-pee-do.jpg', 0),
(37, NULL, 'https://www.lifestylecat.nl/pub/media/catalog/product/cache/fbdbf7d1a34915fc2733f65c570090e9/3/1/313.jpg', 0),
(38, NULL, 'images/gigachad.png', 0),
(39, NULL, 'images/listen.jpg', 1),
(40, NULL, 'images/19.gif', 0),
(41, NULL, 'images/17.jpeg', 1),
(42, NULL, 'https://cdn11.bigcommerce.com/s-30c33/images/stencil/1280x1280/products/2404/2295/1SR12-E__36747.1316243293.jpg', 1),
(43, NULL, 'images/14.jpg', 0),
(44, NULL, 'https://upload.wikimedia.org/wikipedia/commons/6/69/Apostol-Andrey-Pervozvannyj.jpg', 1),
(45, NULL, 'images/petrus (2).jpg', 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(10) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(100) NOT NULL COMMENT 'md5 hashed',
  `email` varchar(70) NOT NULL,
  `admin` tinyint(1) NOT NULL DEFAULT 0,
  `date_joined` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `password`, `email`, `admin`, `date_joined`) VALUES
(13, 'Bonte', 'e3bb2bc7643c4c9c86f604685b9c900c', 'fbonte@rocvantwente.nl', 0, '2020-12-05 12:15:21'),
(14, 'ewaldo', 'd1f6b8cbe2731d6d9a5e2f0b548cf170', 'ewaldo2002@gmail.com', 1, '2020-12-05 12:17:25'),
(15, 'jos', 'f3a23a006a8808ce4cf03ffb64c79fc8', 'jos@thanos.com', 0, '2020-12-05 12:48:19'),
(41, 'marijke', 'a2d04f5b850bff794a520641a03de83d', 'marijke@gmail.com', 0, '2020-12-05 18:50:08'),
(42, 'greg', '66eed8b3e79653173d0f57e1477ff73a', 'greg@gregmail.com', 0, '2020-12-05 19:17:23'),
(43, 'Mario', '6513931bf54b5254f608c881859c6047', 'mario@italy.com', 0, '2020-12-08 22:47:14'),
(44, 'deeznuts', 'dc4e7c5ac912cfb0f4bb9ba3dee83d94', 'deeznuts@hazelnut.com', 0, '2020-12-08 22:57:28'),
(45, 'nibba', 'b1d5e5b2a31a1e9a33310b8f967dac84', 'nibba@nibba.com', 0, '2020-12-10 10:09:57');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `games`
--
ALTER TABLE `games`
  ADD PRIMARY KEY (`game_id`),
  ADD KEY `player_one_id` (`player_one_id`),
  ADD KEY `player_two_id` (`player_two_id`),
  ADD KEY `winner_id` (`winner_id`),
  ADD KEY `winner_id_2` (`winner_id`);

--
-- Indexes for table `images`
--
ALTER TABLE `images`
  ADD PRIMARY KEY (`image_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `games`
--
ALTER TABLE `games`
  MODIFY `game_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT for table `images`
--
ALTER TABLE `images`
  MODIFY `image_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `games`
--
ALTER TABLE `games`
  ADD CONSTRAINT `games_ibfk_1` FOREIGN KEY (`player_one_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `games_ibfk_2` FOREIGN KEY (`player_two_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `games_ibfk_3` FOREIGN KEY (`winner_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
