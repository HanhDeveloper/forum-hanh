-- phpMyAdmin SQL Dump
-- version 4.8.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 10, 2018 at 11:47 AM
-- Server version: 10.1.34-MariaDB
-- PHP Version: 7.2.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `demo`
--

-- --------------------------------------------------------

--
-- Table structure for table `chatbox`
--

CREATE TABLE `chatbox` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `message` varchar(5000) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `time` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `chatbox`
--

INSERT INTO `chatbox` (`id`, `user_id`, `message`, `time`, `created_at`, `updated_at`) VALUES
(5, 1, 'hanh', 1533892806, '2018-08-10 09:20:06', NULL),
(6, 2, 'Bot chưa được học từ này', 1533892806, '2018-08-10 09:20:06', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `chatbox_simi`
--

CREATE TABLE `chatbox_simi` (
  `id` int(10) UNSIGNED NOT NULL,
  `ask` varchar(5000) COLLATE utf8_unicode_ci NOT NULL,
  `ans` varchar(5000) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `forums`
--

CREATE TABLE `forums` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `type` varchar(2) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `refid` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `is_active` enum('0','1') COLLATE utf8_unicode_ci NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `forum_threads`
--

CREATE TABLE `forum_threads` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `forum_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(10) UNSIGNED NOT NULL,
  `from` int(10) UNSIGNED NOT NULL,
  `to` int(10) UNSIGNED NOT NULL,
  `message` varchar(5000) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `is_read` enum('0','1') COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `messages_last_seen`
--

CREATE TABLE `messages_last_seen` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `message_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `key` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `val` text COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `username` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `rights` tinyint(3) UNSIGNED NOT NULL DEFAULT '0',
  `fullname` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `sex` enum('?','m','f') COLLATE utf8_unicode_ci NOT NULL DEFAULT '?',
  `coin` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `gold` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `vip_exp` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `dayb` int(2) UNSIGNED NOT NULL DEFAULT '0',
  `monthb` int(2) UNSIGNED NOT NULL DEFAULT '0',
  `yearb` int(4) UNSIGNED NOT NULL DEFAULT '0',
  `about` varchar(5000) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `city` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `address` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `mobile` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `status` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `ip` bigint(11) NOT NULL DEFAULT '0',
  `ip_via_proxy` bigint(11) NOT NULL DEFAULT '0',
  `total_on_site` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `failed_login` tinyint(3) UNSIGNED NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`, `rights`, `fullname`, `sex`, `coin`, `gold`, `vip_exp`, `dayb`, `monthb`, `yearb`, `about`, `city`, `address`, `mobile`, `status`, `ip`, `ip_via_proxy`, `total_on_site`, `failed_login`, `created_at`, `updated_at`) VALUES
(1, 'hanh', 'hanh', '', 0, 'Hạnh Chợ Đọ', '?', 0, 0, 0, 0, 0, 0, '', '', '', '', '', 0, 0, 0, 0, '2018-08-10 09:17:44', NULL),
(2, 'bot', 'hanh', '', 0, 'BOT', '?', 0, 0, 0, 0, 0, 0, '', '', '', '', '', 0, 0, 0, 0, '2018-08-10 09:17:44', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `chatbox`
--
ALTER TABLE `chatbox`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `chatbox_simi`
--
ALTER TABLE `chatbox_simi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `forums`
--
ALTER TABLE `forums`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `forum_threads`
--
ALTER TABLE `forum_threads`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `from` (`from`),
  ADD KEY `to` (`to`);

--
-- Indexes for table `messages_last_seen`
--
ALTER TABLE `messages_last_seen`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `message_id` (`message_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `chatbox`
--
ALTER TABLE `chatbox`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `chatbox_simi`
--
ALTER TABLE `chatbox_simi`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `forums`
--
ALTER TABLE `forums`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `forum_threads`
--
ALTER TABLE `forum_threads`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `messages_last_seen`
--
ALTER TABLE `messages_last_seen`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `chatbox`
--
ALTER TABLE `chatbox`
  ADD CONSTRAINT `chatbox_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `chatbox_simi`
--
ALTER TABLE `chatbox_simi`
  ADD CONSTRAINT `chatbox_simi_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `messages_ibfk_1` FOREIGN KEY (`from`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `messages_ibfk_2` FOREIGN KEY (`to`) REFERENCES `users` (`id`);

--
-- Constraints for table `messages_last_seen`
--
ALTER TABLE `messages_last_seen`
  ADD CONSTRAINT `messages_last_seen_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `messages_last_seen_ibfk_2` FOREIGN KEY (`message_id`) REFERENCES `messages` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
