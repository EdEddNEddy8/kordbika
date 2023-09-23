-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 23, 2023 at 09:40 AM
-- Server version: 10.6.12-MariaDB-cll-lve
-- PHP Version: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `u642167750_kb`
--

-- --------------------------------------------------------

--
-- Table structure for table `arena_fights`
--

CREATE TABLE `arena_fights` (
  `id` int(11) NOT NULL,
  `player_id` int(11) NOT NULL,
  `player_hp` int(11) NOT NULL,
  `player_energy` int(11) NOT NULL,
  `player_damage` int(11) NOT NULL,
  `monster_id` int(11) NOT NULL,
  `monster_hp` int(11) NOT NULL,
  `is_active` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `attacks`
--

CREATE TABLE `attacks` (
  `id` int(11) NOT NULL,
  `attacker_id` int(11) NOT NULL,
  `opponent_id` int(11) NOT NULL,
  `attack_time` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('pending','completed') NOT NULL DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `attacks`
--

INSERT INTO `attacks` (`id`, `attacker_id`, `opponent_id`, `attack_time`, `status`) VALUES
(8, 0, 0, '2023-09-08 17:49:24', 'pending'),
(9, 0, 0, '2023-09-08 17:49:34', 'pending'),
(10, 0, 0, '2023-09-08 17:49:37', 'pending'),
(11, 0, 0, '2023-09-08 17:49:38', 'pending'),
(12, 0, 0, '2023-09-08 17:49:40', 'pending');

-- --------------------------------------------------------

--
-- Table structure for table `avatar`
--

CREATE TABLE `avatar` (
  `id` int(11) NOT NULL,
  `image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `avatar`
--

INSERT INTO `avatar` (`id`, `image`) VALUES
(1, 'images/pic_image/1.jpg'),
(2, 'images/pic_image/2.jpg'),
(3, 'images/pic_image/3.jpg'),
(4, 'images/pic_image/4.jpg'),
(5, 'images/pic_image/5.jpg'),
(6, 'images/pic_image/6.jpg'),
(7, 'images/pic_image/7.jpg'),
(8, 'images/pic_image/8.jpg'),
(9, 'images/pic_image/9.jpg'),
(10, 'images/pic_image/10.jpg'),
(11, 'images/pic_image/11.jpg'),
(12, 'images/pic_image/12.jpg'),
(13, 'images/pic_image/13.jpg'),
(14, 'images/pic_image/14.jpg'),
(15, 'images/pic_image/15.jpg'),
(16, 'images/pic_image/16.jpg'),
(17, 'images/pic_image/17.jpg'),
(18, 'images/pic_image/18.jpg'),
(19, 'images/pic_image/19.jpg'),
(20, 'images/pic_image/20.jpg'),
(21, 'images/pic_image/21.jpg'),
(22, 'images/pic_image/22.jpg'),
(23, 'images/pic_image/23.jpg'),
(24, 'images/pic_image/24.jpg'),
(25, 'images/pic_image/25.jpg'),
(26, 'images/pic_image/26.jpg'),
(27, 'images/pic_image/27.jpg'),
(28, 'images/pic_image/28.jpg'),
(29, 'images/pic_image/29.jpg'),
(30, 'images/pic_image/30.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `ban_list`
--

CREATE TABLE `ban_list` (
  `id` int(11) NOT NULL,
  `player_id` int(11) NOT NULL,
  `reason` varchar(255) NOT NULL,
  `time` int(11) NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ban_list`
--

INSERT INTO `ban_list` (`id`, `player_id`, `reason`, `time`) VALUES
(1, 2, 'Veikals', 2023);

-- --------------------------------------------------------

--
-- Table structure for table `casino_prizes`
--

CREATE TABLE `casino_prizes` (
  `id` int(11) NOT NULL,
  `prizetype` varchar(255) NOT NULL,
  `value` int(11) NOT NULL,
  `color` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `casino_prizes`
--

INSERT INTO `casino_prizes` (`id`, `prizetype`, `value`, `color`) VALUES
(11, 'Respect', 111, 'red'),
(12, 'Power', 100, 'blue');

-- --------------------------------------------------------

--
-- Table structure for table `characters`
--

CREATE TABLE `characters` (
  `id` int(11) NOT NULL,
  `image` varchar(255) NOT NULL DEFAULT 'assets/img/characters/female/',
  `category_id` int(11) NOT NULL DEFAULT 2
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `characters`
--

INSERT INTO `characters` (`id`, `image`, `category_id`) VALUES
(1, 'images/characters/male/1m.png', 1),
(2, 'images/characters/male/2m.png', 1),
(3, 'images/characters/male/3m.png', 1),
(4, 'images/characters/male/4m.png', 1),
(5, 'images/characters/male/5m.png', 1),
(6, 'images/characters/male/6m.png', 1),
(9, 'images/characters/female/1f.png', 2),
(10, 'images/characters/female/2f.png', 2),
(11, 'images/characters/female/3f.png', 2),
(12, 'images/characters/female/4f.png', 2),
(13, 'images/characters/female/5f.png', 2),
(14, 'images/characters/female/6f.png', 2),
(16, 'images/characters/female/7f.png', 2);

-- --------------------------------------------------------

--
-- Table structure for table `character_categories`
--

CREATE TABLE `character_categories` (
  `id` int(11) NOT NULL,
  `fa_icon` varchar(255) NOT NULL,
  `category` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `character_categories`
--

INSERT INTO `character_categories` (`id`, `fa_icon`, `category`) VALUES
(1, 'fa-male', 'Male Characters'),
(2, 'fa-female', 'Female Characters');

-- --------------------------------------------------------

--
-- Table structure for table `chat_messages`
--

CREATE TABLE `chat_messages` (
  `id` int(11) NOT NULL,
  `sender` varchar(255) NOT NULL,
  `recipient` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `chat_messages`
--

INSERT INTO `chat_messages` (`id`, `sender`, `recipient`, `message`, `timestamp`) VALUES
(1, 'Tiesnesis', '', 'asdasd', '2023-09-14 21:10:57');

-- --------------------------------------------------------

--
-- Table structure for table `clans`
--

CREATE TABLE `clans` (
  `id` int(11) NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `avatar` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'images/clan_avatar/clan_house_default.jpg',
  `max_members` int(255) NOT NULL DEFAULT 5,
  `leader_id` int(11) NOT NULL,
  `leader_username` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `dimants_banka` int(11) NOT NULL,
  `zelts_banka` int(11) NOT NULL,
  `koks_banka` int(11) NOT NULL,
  `dzelzs_banka` int(11) NOT NULL,
  `āda_banka` int(11) NOT NULL,
  `akmens_banka` int(11) NOT NULL,
  `total_power` int(11) NOT NULL,
  `total_agility` int(11) NOT NULL,
  `total_endurance` int(11) NOT NULL,
  `total_intelligence` int(11) NOT NULL,
  `total_uzbrukums` int(11) NOT NULL,
  `total_aizsardsziba` int(11) NOT NULL,
  `bonus_max_hp` int(11) NOT NULL,
  `bonus_max_energy` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `clans`
--

INSERT INTO `clans` (`id`, `name`, `avatar`, `max_members`, `leader_id`, `leader_username`, `dimants_banka`, `zelts_banka`, `koks_banka`, `dzelzs_banka`, `āda_banka`, `akmens_banka`, `total_power`, `total_agility`, `total_endurance`, `total_intelligence`, `total_uzbrukums`, `total_aizsardsziba`, `bonus_max_hp`, `bonus_max_energy`) VALUES
(190, 'Pheonixxx', 'images/clan_avatar/admin.jpg', 5, 1, 'Admin', 300, 300, 0, 0, 0, 0, 334, 0, 25, 0, 0, 0, 0, 0),
(189, 'aaaaaaaaa', 'images/clan_avatar/', 5, 4, 'Demo2', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `clansjoin`
--

CREATE TABLE `clansjoin` (
  `id` int(11) NOT NULL,
  `clan_id` int(11) NOT NULL,
  `player_id` int(11) NOT NULL,
  `accept` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `clan_member_history`
--

CREATE TABLE `clan_member_history` (
  `id` int(11) NOT NULL,
  `event_type` varchar(255) NOT NULL,
  `player_username` varchar(255) NOT NULL,
  `event_time` timestamp NOT NULL DEFAULT current_timestamp(),
  `clan_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `clan_member_history`
--

INSERT INTO `clan_member_history` (`id`, `event_type`, `player_username`, `event_time`, `clan_id`) VALUES
(1, 'join', 'player123', '2023-09-01 00:03:44', 190);

-- --------------------------------------------------------

--
-- Table structure for table `clan_resources`
--

CREATE TABLE `clan_resources` (
  `id` int(11) NOT NULL,
  `clan_id` int(11) NOT NULL,
  `dimants` int(11) DEFAULT 0,
  `zelts` int(11) DEFAULT 0,
  `koks` int(11) DEFAULT 0,
  `dzelzs` int(11) DEFAULT 0,
  `āda` int(11) DEFAULT 0,
  `akmens` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `clan_upgrades`
--

CREATE TABLE `clan_upgrades` (
  `id` int(11) NOT NULL,
  `clan_id` int(11) NOT NULL,
  `hp_upgrade` int(11) DEFAULT 0,
  `energy_upgrade` int(11) DEFAULT 0,
  `max_members_upgrade` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `clan_upgrades`
--

INSERT INTO `clan_upgrades` (`id`, `clan_id`, `hp_upgrade`, `energy_upgrade`, `max_members_upgrade`) VALUES
(1, 190, 100, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `cron_energyrefill`
--

CREATE TABLE `cron_energyrefill` (
  `id` int(11) NOT NULL,
  `type` varchar(10) NOT NULL DEFAULT 'full',
  `pl_id` int(11) NOT NULL,
  `timestamp` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cron_energyrefill`
--

INSERT INTO `cron_energyrefill` (`id`, `type`, `pl_id`, `timestamp`) VALUES
(1, 'full', 0, '1692860785'),
(2, 'refill10', 1, '1690982378'),
(3, 'refill10', 9, '1686169696');

-- --------------------------------------------------------

--
-- Table structure for table `custom_pages`
--

CREATE TABLE `custom_pages` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `fa_icon` varchar(255) NOT NULL,
  `logged` varchar(3) NOT NULL DEFAULT 'No'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `custom_pages`
--

INSERT INTO `custom_pages` (`id`, `title`, `content`, `fa_icon`, `logged`) VALUES
(1, 'FAQ', 'Demo page for Frequently Asked Questions (FAQ)', 'fa-question-circle', 'No'),
(2, 'Terms of Service', 'Demo page for Terms of Service', 'fa-align-justify', 'No'),
(3, 'News', 'Demo page for News (Blog)', 'fa-newspaper', 'No'),
(4, 'Contact', 'Demo page for Contact', 'fa-headset', 'No'),
(5, 'Privacy Policy', 'Demo page for Privacy Policy', 'fa-user-lock', 'No');

-- --------------------------------------------------------

--
-- Table structure for table `damage_history`
--

CREATE TABLE `damage_history` (
  `id` int(11) NOT NULL,
  `arena_fights_id` int(11) NOT NULL,
  `player_id` int(11) DEFAULT NULL,
  `damage_info` int(11) DEFAULT NULL,
  `damage_type` varchar(255) NOT NULL,
  `monster_attack` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `damage_history`
--

INSERT INTO `damage_history` (`id`, `arena_fights_id`, `player_id`, `damage_info`, `damage_type`, `monster_attack`) VALUES
(4670, 631, NULL, NULL, '', 26),
(4672, 631, NULL, NULL, '', 38),
(4674, 631, NULL, NULL, '', 76),
(4676, 631, NULL, NULL, '', 93),
(4678, 631, NULL, NULL, '', 94),
(4680, 631, NULL, NULL, '', 97),
(4682, 631, NULL, NULL, '', 28),
(4684, 631, NULL, NULL, '', 57),
(4686, 631, NULL, NULL, '', 64),
(4688, 631, NULL, NULL, '', 88),
(4690, 631, NULL, NULL, '', 18),
(4692, 632, NULL, NULL, '', 4),
(4943, 661, NULL, NULL, '', 386),
(4945, 661, NULL, NULL, '', 533),
(4947, 661, NULL, NULL, '', 129),
(4949, 661, NULL, NULL, '', 477),
(4951, 661, NULL, NULL, '', 224),
(4953, 661, NULL, NULL, '', 12),
(5954, 845, NULL, NULL, '', 622),
(5956, 845, NULL, NULL, '', 290),
(5958, 845, NULL, NULL, '', 684),
(5960, 845, NULL, NULL, '', 505);

-- --------------------------------------------------------

--
-- Table structure for table `equipped_items`
--

CREATE TABLE `equipped_items` (
  `id` int(11) NOT NULL,
  `player_id` int(11) DEFAULT NULL,
  `item_id` int(11) DEFAULT NULL,
  `durability` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fights`
--

CREATE TABLE `fights` (
  `id` int(11) NOT NULL,
  `playera_id` int(11) NOT NULL,
  `playerb_id` int(11) NOT NULL,
  `winner_id` int(11) NOT NULL,
  `date` varchar(255) NOT NULL,
  `time` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `fights`
--

INSERT INTO `fights` (`id`, `playera_id`, `playerb_id`, `winner_id`, `date`, `time`) VALUES
(1, 1, 14, 1, '15 September 2023', '09:21'),
(2, 2, 36, 2, '15 September 2023', '23:44'),
(3, 2, 36, 2, '15 September 2023', '23:44'),
(4, 2, 36, 2, '15 September 2023', '23:44'),
(5, 2, 36, 2, '15 September 2023', '23:44'),
(6, 2, 36, 2, '15 September 2023', '23:44'),
(7, 2, 36, 2, '15 September 2023', '23:44'),
(8, 2, 36, 2, '15 September 2023', '23:44'),
(9, 2, 36, 2, '15 September 2023', '23:44'),
(10, 2, 36, 2, '15 September 2023', '23:44'),
(11, 2, 36, 2, '15 September 2023', '23:44'),
(12, 1, 37, 1, '16 September 2023', '09:15'),
(13, 1, 37, 1, '16 September 2023', '09:15'),
(14, 1, 37, 1, '16 September 2023', '09:15'),
(15, 1, 37, 1, '16 September 2023', '09:15'),
(16, 1, 30, 1, '21 September 2023', '12:44'),
(17, 1, 30, 1, '21 September 2023', '12:46'),
(18, 1, 30, 1, '21 September 2023', '12:46'),
(19, 1, 30, 1, '21 September 2023', '12:48'),
(20, 1, 30, 1, '21 September 2023', '12:49'),
(21, 1, 30, 1, '21 September 2023', '12:52'),
(22, 1, 30, 1, '21 September 2023', '12:53'),
(23, 1, 30, 1, '21 September 2023', '12:56'),
(24, 1, 30, 1, '21 September 2023', '12:56'),
(25, 1, 30, 1, '21 September 2023', '12:56'),
(26, 1, 30, 1, '21 September 2023', '12:56'),
(27, 1, 30, 1, '21 September 2023', '12:56'),
(28, 1, 30, 1, '21 September 2023', '12:56'),
(29, 1, 30, 1, '21 September 2023', '12:57'),
(30, 1, 30, 1, '21 September 2023', '12:58'),
(31, 1, 30, 1, '21 September 2023', '12:58'),
(32, 1, 30, 1, '21 September 2023', '12:58'),
(33, 1, 30, 1, '21 September 2023', '12:58'),
(34, 1, 30, 1, '21 September 2023', '12:58'),
(35, 1, 30, 1, '21 September 2023', '12:58'),
(36, 1, 30, 1, '21 September 2023', '12:58'),
(37, 1, 36, 1, '21 September 2023', '13:10'),
(38, 1, 36, 1, '21 September 2023', '13:11'),
(39, 1, 36, 1, '21 September 2023', '13:11'),
(40, 1, 36, 1, '21 September 2023', '13:11'),
(41, 1, 36, 1, '21 September 2023', '13:11'),
(42, 1, 36, 1, '21 September 2023', '13:11'),
(43, 1, 36, 1, '21 September 2023', '13:11'),
(44, 1, 36, 1, '21 September 2023', '13:11'),
(45, 1, 36, 1, '21 September 2023', '13:11'),
(46, 1, 36, 1, '21 September 2023', '13:11'),
(47, 1, 36, 1, '21 September 2023', '13:11'),
(48, 1, 36, 1, '21 September 2023', '13:14'),
(49, 1, 36, 1, '21 September 2023', '13:14'),
(50, 1, 36, 1, '21 September 2023', '13:14'),
(51, 1, 36, 1, '21 September 2023', '13:15'),
(52, 1, 36, 1, '21 September 2023', '13:15'),
(53, 1, 36, 1, '21 September 2023', '13:15'),
(54, 1, 36, 1, '21 September 2023', '13:15'),
(55, 1, 36, 1, '21 September 2023', '13:15'),
(56, 1, 36, 1, '21 September 2023', '13:15'),
(57, 1, 36, 1, '21 September 2023', '13:15'),
(58, 1, 36, 1, '21 September 2023', '13:15'),
(59, 1, 36, 1, '21 September 2023', '13:15'),
(60, 1, 36, 1, '21 September 2023', '13:15'),
(61, 1, 36, 1, '21 September 2023', '13:15'),
(62, 1, 36, 1, '21 September 2023', '13:15'),
(63, 1, 36, 1, '21 September 2023', '13:15'),
(64, 1, 36, 1, '21 September 2023', '13:15'),
(65, 1, 36, 1, '21 September 2023', '13:15'),
(66, 1, 36, 1, '21 September 2023', '13:15'),
(67, 1, 36, 1, '21 September 2023', '13:15'),
(68, 1, 36, 1, '21 September 2023', '13:15'),
(69, 1, 36, 1, '21 September 2023', '13:15'),
(70, 1, 36, 1, '21 September 2023', '13:15'),
(71, 1, 36, 1, '21 September 2023', '13:15'),
(72, 1, 36, 1, '21 September 2023', '13:15'),
(73, 1, 36, 1, '21 September 2023', '13:15'),
(74, 1, 36, 1, '21 September 2023', '13:15'),
(75, 1, 36, 1, '21 September 2023', '13:15'),
(76, 1, 36, 1, '21 September 2023', '13:15'),
(77, 1, 36, 1, '21 September 2023', '13:15'),
(78, 1, 36, 1, '21 September 2023', '13:15'),
(79, 1, 36, 1, '21 September 2023', '13:15'),
(80, 1, 36, 1, '21 September 2023', '13:15'),
(81, 1, 36, 1, '21 September 2023', '13:15'),
(82, 1, 36, 1, '21 September 2023', '13:15'),
(83, 1, 36, 1, '21 September 2023', '13:15'),
(84, 1, 36, 1, '21 September 2023', '13:15'),
(85, 1, 36, 1, '21 September 2023', '13:15'),
(86, 1, 36, 1, '21 September 2023', '13:15'),
(87, 1, 36, 1, '21 September 2023', '13:15'),
(88, 1, 36, 1, '21 September 2023', '13:15'),
(89, 1, 36, 1, '21 September 2023', '13:15'),
(90, 1, 36, 1, '21 September 2023', '13:15'),
(91, 1, 36, 1, '21 September 2023', '13:16'),
(92, 1, 36, 1, '21 September 2023', '13:16'),
(93, 1, 36, 1, '21 September 2023', '13:16'),
(94, 1, 36, 1, '21 September 2023', '13:16'),
(95, 1, 36, 1, '21 September 2023', '13:16'),
(96, 1, 36, 1, '21 September 2023', '13:16'),
(97, 1, 36, 1, '21 September 2023', '13:16'),
(98, 1, 36, 1, '21 September 2023', '13:16'),
(99, 1, 36, 1, '21 September 2023', '13:16'),
(100, 1, 36, 1, '21 September 2023', '13:16'),
(101, 1, 36, 1, '21 September 2023', '13:16'),
(102, 1, 36, 1, '21 September 2023', '13:16'),
(103, 1, 36, 1, '21 September 2023', '13:16'),
(104, 1, 36, 1, '21 September 2023', '13:16'),
(105, 1, 36, 1, '21 September 2023', '13:16'),
(106, 1, 36, 1, '21 September 2023', '13:16'),
(107, 1, 36, 1, '21 September 2023', '13:16'),
(108, 1, 36, 1, '21 September 2023', '13:16'),
(109, 1, 36, 1, '21 September 2023', '13:16'),
(110, 1, 36, 1, '21 September 2023', '13:16'),
(111, 1, 36, 1, '21 September 2023', '13:16'),
(112, 1, 36, 1, '21 September 2023', '13:16'),
(113, 1, 36, 1, '21 September 2023', '13:16'),
(114, 1, 36, 1, '21 September 2023', '13:16'),
(115, 1, 36, 1, '21 September 2023', '13:16'),
(116, 1, 36, 1, '21 September 2023', '13:16'),
(117, 1, 36, 1, '21 September 2023', '13:16'),
(118, 1, 36, 1, '21 September 2023', '13:16'),
(119, 1, 36, 1, '21 September 2023', '13:16'),
(120, 1, 36, 1, '21 September 2023', '13:16'),
(121, 1, 36, 1, '21 September 2023', '13:16'),
(122, 1, 36, 1, '21 September 2023', '13:16'),
(123, 1, 36, 1, '21 September 2023', '13:16'),
(124, 1, 36, 1, '21 September 2023', '13:16'),
(125, 1, 36, 1, '21 September 2023', '13:16'),
(126, 1, 36, 1, '21 September 2023', '13:16'),
(127, 1, 36, 1, '21 September 2023', '13:16'),
(128, 1, 36, 1, '21 September 2023', '13:16'),
(129, 1, 36, 1, '21 September 2023', '13:16'),
(130, 1, 36, 1, '21 September 2023', '13:16'),
(131, 1, 36, 1, '21 September 2023', '13:16'),
(132, 1, 36, 1, '21 September 2023', '13:16'),
(133, 1, 36, 1, '21 September 2023', '13:16'),
(134, 1, 36, 1, '21 September 2023', '13:16'),
(135, 1, 36, 1, '21 September 2023', '13:16'),
(136, 1, 36, 1, '21 September 2023', '13:16'),
(137, 1, 36, 1, '21 September 2023', '13:16'),
(138, 1, 36, 1, '21 September 2023', '13:16'),
(139, 1, 36, 1, '21 September 2023', '13:16'),
(140, 1, 36, 1, '21 September 2023', '13:16'),
(141, 1, 36, 1, '21 September 2023', '13:16'),
(142, 1, 36, 1, '21 September 2023', '13:16'),
(143, 1, 36, 1, '21 September 2023', '13:16'),
(144, 1, 36, 1, '21 September 2023', '13:16'),
(145, 1, 36, 1, '21 September 2023', '13:16'),
(146, 1, 36, 1, '21 September 2023', '13:16'),
(147, 1, 36, 1, '21 September 2023', '13:16'),
(148, 1, 36, 1, '21 September 2023', '13:16'),
(149, 1, 36, 1, '21 September 2023', '13:16'),
(150, 1, 36, 1, '21 September 2023', '13:16'),
(151, 1, 36, 1, '21 September 2023', '13:16'),
(152, 1, 36, 1, '21 September 2023', '13:16'),
(153, 1, 36, 1, '21 September 2023', '13:16'),
(154, 1, 36, 1, '21 September 2023', '13:16'),
(155, 1, 36, 1, '21 September 2023', '13:16'),
(156, 1, 36, 1, '21 September 2023', '13:16'),
(157, 1, 36, 1, '21 September 2023', '13:16'),
(158, 1, 36, 1, '21 September 2023', '13:16'),
(159, 1, 36, 1, '21 September 2023', '13:16'),
(160, 1, 36, 1, '21 September 2023', '13:16'),
(161, 1, 36, 1, '21 September 2023', '13:16'),
(162, 1, 36, 1, '21 September 2023', '13:16'),
(163, 1, 36, 1, '21 September 2023', '13:16'),
(164, 1, 36, 1, '21 September 2023', '13:16'),
(165, 1, 36, 1, '21 September 2023', '13:16'),
(166, 1, 36, 1, '21 September 2023', '13:16'),
(167, 1, 36, 1, '21 September 2023', '13:16'),
(168, 1, 36, 1, '21 September 2023', '13:16'),
(169, 1, 36, 1, '21 September 2023', '13:16'),
(170, 1, 36, 1, '21 September 2023', '13:16'),
(171, 1, 36, 1, '21 September 2023', '13:16'),
(172, 1, 36, 1, '21 September 2023', '13:16'),
(173, 1, 36, 1, '21 September 2023', '13:16'),
(174, 1, 36, 1, '21 September 2023', '13:16'),
(175, 1, 36, 1, '21 September 2023', '13:16'),
(176, 1, 36, 1, '21 September 2023', '13:16'),
(177, 1, 36, 1, '21 September 2023', '13:16'),
(178, 1, 36, 1, '21 September 2023', '13:16'),
(179, 1, 36, 1, '21 September 2023', '13:16'),
(180, 1, 36, 1, '21 September 2023', '13:16'),
(181, 1, 36, 1, '21 September 2023', '13:16'),
(182, 1, 36, 1, '21 September 2023', '13:16'),
(183, 1, 36, 1, '21 September 2023', '13:16'),
(184, 1, 36, 1, '21 September 2023', '13:16'),
(185, 1, 36, 1, '21 September 2023', '13:16'),
(186, 1, 36, 1, '21 September 2023', '13:16'),
(187, 1, 36, 1, '21 September 2023', '13:16'),
(188, 1, 36, 1, '21 September 2023', '13:16'),
(189, 1, 36, 1, '21 September 2023', '13:16'),
(190, 1, 36, 1, '21 September 2023', '13:16'),
(191, 1, 36, 1, '21 September 2023', '13:16'),
(192, 1, 36, 1, '21 September 2023', '13:16'),
(193, 1, 36, 1, '21 September 2023', '13:16'),
(194, 1, 36, 1, '21 September 2023', '13:16'),
(195, 1, 36, 1, '21 September 2023', '13:16'),
(196, 1, 36, 1, '21 September 2023', '13:16'),
(197, 1, 36, 1, '21 September 2023', '13:16'),
(198, 1, 36, 1, '21 September 2023', '13:16'),
(199, 1, 36, 1, '21 September 2023', '13:16'),
(200, 1, 36, 1, '21 September 2023', '13:16'),
(201, 1, 36, 1, '21 September 2023', '13:16'),
(202, 1, 36, 1, '21 September 2023', '13:16'),
(203, 1, 36, 1, '21 September 2023', '13:16'),
(204, 1, 36, 1, '21 September 2023', '13:16'),
(205, 1, 36, 1, '21 September 2023', '13:16'),
(206, 1, 36, 1, '21 September 2023', '13:16'),
(207, 1, 36, 1, '21 September 2023', '13:16'),
(208, 1, 36, 1, '21 September 2023', '13:16'),
(209, 1, 36, 1, '21 September 2023', '13:16'),
(210, 1, 36, 1, '21 September 2023', '13:16'),
(211, 1, 36, 1, '21 September 2023', '13:16'),
(212, 1, 36, 1, '21 September 2023', '13:16'),
(213, 1, 36, 1, '21 September 2023', '13:16'),
(214, 1, 36, 1, '21 September 2023', '13:16'),
(215, 1, 36, 1, '21 September 2023', '13:16'),
(216, 1, 36, 1, '21 September 2023', '13:16'),
(217, 1, 36, 1, '21 September 2023', '13:16'),
(218, 1, 36, 1, '21 September 2023', '13:16'),
(219, 1, 36, 1, '21 September 2023', '13:16'),
(220, 1, 36, 1, '21 September 2023', '13:16'),
(221, 1, 36, 1, '21 September 2023', '13:16'),
(222, 1, 36, 1, '21 September 2023', '13:16'),
(223, 1, 36, 1, '21 September 2023', '13:16'),
(224, 1, 36, 1, '21 September 2023', '13:16'),
(225, 1, 36, 1, '21 September 2023', '13:16'),
(226, 1, 36, 1, '21 September 2023', '13:16'),
(227, 1, 36, 1, '21 September 2023', '13:16'),
(228, 1, 36, 1, '21 September 2023', '13:16'),
(229, 1, 36, 1, '21 September 2023', '13:16'),
(230, 1, 36, 1, '21 September 2023', '13:16'),
(231, 1, 36, 1, '21 September 2023', '13:16'),
(232, 1, 36, 1, '21 September 2023', '13:16'),
(233, 1, 36, 1, '21 September 2023', '13:16'),
(234, 1, 36, 1, '21 September 2023', '13:16'),
(235, 1, 36, 1, '21 September 2023', '13:16'),
(236, 1, 36, 1, '21 September 2023', '13:16'),
(237, 1, 36, 1, '21 September 2023', '13:16'),
(238, 1, 36, 1, '21 September 2023', '13:16'),
(239, 1, 36, 1, '21 September 2023', '13:16'),
(240, 1, 36, 1, '21 September 2023', '13:16'),
(241, 1, 36, 1, '21 September 2023', '13:16'),
(242, 1, 36, 1, '21 September 2023', '13:16'),
(243, 1, 36, 1, '21 September 2023', '13:16'),
(244, 1, 36, 1, '21 September 2023', '13:16'),
(245, 1, 36, 1, '21 September 2023', '13:16'),
(246, 1, 36, 1, '21 September 2023', '13:16'),
(247, 1, 36, 1, '21 September 2023', '13:16'),
(248, 1, 36, 1, '21 September 2023', '13:16'),
(249, 1, 36, 1, '21 September 2023', '13:16'),
(250, 1, 36, 1, '21 September 2023', '13:16'),
(251, 1, 36, 1, '21 September 2023', '13:16'),
(252, 1, 36, 1, '21 September 2023', '13:16'),
(253, 1, 36, 1, '21 September 2023', '13:16'),
(254, 1, 36, 1, '21 September 2023', '13:16'),
(255, 1, 36, 1, '21 September 2023', '13:16'),
(256, 1, 36, 1, '21 September 2023', '13:16'),
(257, 1, 36, 1, '21 September 2023', '13:16'),
(258, 1, 36, 1, '21 September 2023', '13:16'),
(259, 1, 36, 1, '21 September 2023', '13:16'),
(260, 1, 36, 1, '21 September 2023', '13:16'),
(261, 1, 36, 1, '21 September 2023', '13:16'),
(262, 1, 36, 1, '21 September 2023', '13:16'),
(263, 1, 36, 1, '21 September 2023', '13:16'),
(264, 1, 36, 1, '21 September 2023', '13:16'),
(265, 1, 36, 1, '21 September 2023', '13:16'),
(266, 1, 36, 1, '21 September 2023', '13:16'),
(267, 1, 36, 1, '21 September 2023', '13:16'),
(268, 1, 36, 1, '21 September 2023', '13:16'),
(269, 1, 36, 1, '21 September 2023', '13:16'),
(270, 1, 36, 1, '21 September 2023', '13:16'),
(271, 1, 36, 1, '21 September 2023', '13:16'),
(272, 1, 36, 1, '21 September 2023', '13:17'),
(273, 1, 36, 1, '21 September 2023', '13:17'),
(274, 1, 36, 1, '21 September 2023', '13:17'),
(275, 1, 36, 1, '21 September 2023', '13:17'),
(276, 1, 36, 1, '21 September 2023', '13:17'),
(277, 1, 36, 1, '21 September 2023', '13:17'),
(278, 1, 36, 1, '21 September 2023', '13:17'),
(279, 1, 36, 1, '21 September 2023', '13:24'),
(280, 1, 36, 1, '21 September 2023', '13:24'),
(281, 1, 36, 1, '21 September 2023', '13:24'),
(282, 1, 36, 1, '21 September 2023', '13:24'),
(283, 1, 36, 1, '21 September 2023', '13:24'),
(284, 1, 36, 1, '21 September 2023', '13:24'),
(285, 1, 36, 1, '21 September 2023', '13:24'),
(286, 1, 36, 1, '21 September 2023', '13:24'),
(287, 1, 36, 1, '21 September 2023', '13:24'),
(288, 1, 36, 1, '21 September 2023', '13:24'),
(289, 1, 36, 1, '21 September 2023', '13:24'),
(290, 1, 36, 1, '21 September 2023', '13:24'),
(291, 1, 36, 1, '21 September 2023', '13:24'),
(292, 1, 36, 1, '21 September 2023', '13:24'),
(293, 1, 36, 1, '21 September 2023', '13:24'),
(294, 1, 36, 1, '21 September 2023', '13:24'),
(295, 1, 36, 1, '21 September 2023', '13:24'),
(296, 1, 36, 1, '21 September 2023', '13:24'),
(297, 1, 36, 1, '21 September 2023', '13:27'),
(298, 1, 36, 1, '21 September 2023', '13:27'),
(299, 1, 36, 1, '21 September 2023', '13:29'),
(300, 1, 36, 1, '21 September 2023', '13:29'),
(301, 1, 36, 1, '21 September 2023', '13:29'),
(302, 1, 36, 1, '21 September 2023', '13:30'),
(303, 1, 36, 1, '21 September 2023', '13:30'),
(304, 1, 36, 1, '21 September 2023', '13:30'),
(305, 1, 36, 1, '21 September 2023', '13:30'),
(306, 1, 36, 1, '21 September 2023', '13:30'),
(307, 1, 36, 1, '21 September 2023', '13:30'),
(308, 1, 36, 1, '21 September 2023', '13:30'),
(309, 1, 36, 1, '21 September 2023', '13:30'),
(310, 1, 36, 1, '21 September 2023', '13:30'),
(311, 1, 36, 1, '21 September 2023', '13:30'),
(312, 1, 36, 1, '21 September 2023', '13:30'),
(313, 1, 36, 1, '21 September 2023', '13:30'),
(314, 1, 36, 1, '21 September 2023', '13:30'),
(315, 1, 36, 1, '21 September 2023', '13:30'),
(316, 1, 36, 1, '21 September 2023', '13:30'),
(317, 1, 36, 1, '21 September 2023', '13:31'),
(318, 1, 36, 1, '21 September 2023', '13:31'),
(319, 1, 36, 1, '21 September 2023', '13:31'),
(320, 1, 36, 1, '21 September 2023', '13:31'),
(321, 1, 36, 1, '21 September 2023', '13:31'),
(322, 1, 36, 1, '21 September 2023', '13:31'),
(323, 1, 18, 1, '21 September 2023', '14:42'),
(324, 1, 18, 1, '21 September 2023', '14:42'),
(325, 1, 18, 1, '21 September 2023', '14:42'),
(326, 1, 18, 1, '21 September 2023', '14:42'),
(327, 1, 18, 1, '21 September 2023', '14:42'),
(328, 1, 18, 1, '21 September 2023', '14:44'),
(329, 1, 18, 1, '21 September 2023', '14:44'),
(330, 1, 18, 1, '21 September 2023', '14:44'),
(331, 1, 18, 1, '21 September 2023', '14:44'),
(332, 1, 18, 1, '21 September 2023', '14:44'),
(333, 1, 18, 1, '21 September 2023', '14:44'),
(334, 1, 18, 1, '21 September 2023', '14:45'),
(335, 1, 18, 1, '21 September 2023', '14:45'),
(336, 1, 18, 1, '21 September 2023', '14:45'),
(337, 1, 18, 1, '21 September 2023', '14:45'),
(338, 1, 18, 1, '21 September 2023', '14:45'),
(339, 1, 18, 1, '21 September 2023', '14:45'),
(340, 1, 18, 1, '21 September 2023', '14:45'),
(341, 1, 18, 1, '21 September 2023', '14:45'),
(342, 1, 18, 1, '21 September 2023', '14:45'),
(343, 1, 18, 1, '21 September 2023', '14:46'),
(344, 1, 18, 1, '21 September 2023', '14:46'),
(345, 1, 18, 1, '21 September 2023', '14:46'),
(346, 1, 18, 1, '21 September 2023', '14:46'),
(347, 1, 18, 1, '21 September 2023', '14:46'),
(348, 1, 18, 1, '21 September 2023', '14:46'),
(349, 1, 18, 1, '21 September 2023', '14:46'),
(350, 1, 18, 1, '21 September 2023', '14:46'),
(351, 1, 18, 1, '21 September 2023', '14:46'),
(352, 1, 18, 1, '21 September 2023', '14:46'),
(353, 1, 18, 1, '21 September 2023', '14:48'),
(354, 1, 18, 1, '21 September 2023', '14:48'),
(355, 1, 18, 1, '21 September 2023', '14:48'),
(356, 1, 18, 1, '21 September 2023', '14:48'),
(357, 1, 18, 1, '21 September 2023', '14:48'),
(358, 1, 18, 1, '21 September 2023', '14:48'),
(359, 1, 18, 1, '21 September 2023', '14:48');

-- --------------------------------------------------------

--
-- Table structure for table `fight_history`
--

CREATE TABLE `fight_history` (
  `id` int(11) NOT NULL,
  `player_id` int(11) NOT NULL,
  `monster_id` int(11) NOT NULL,
  `result` varchar(255) NOT NULL,
  `victory_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `fight_history`
--

INSERT INTO `fight_history` (`id`, `player_id`, `monster_id`, `result`, `victory_date`) VALUES
(402, 1, 13, '', '2023-09-21 20:38:34'),
(445, 2, 7, '', '2023-09-21 21:09:11'),
(485, 1, 18, '', '2023-09-22 00:25:52'),
(486, 2, 7, '', '2023-09-22 08:02:55'),
(498, 1, 7, '', '2023-09-22 08:31:17'),
(499, 2, 7, '', '2023-09-22 13:44:55'),
(500, 2, 7, '', '2023-09-22 13:45:15'),
(501, 1, 7, '', '2023-09-22 17:42:27'),
(502, 1, 7, '', '2023-09-22 19:05:48'),
(503, 1, 7, '', '2023-09-22 19:59:21'),
(504, 1, 7, '', '2023-09-22 20:00:32'),
(505, 1, 7, '', '2023-09-22 20:01:01'),
(506, 1, 7, '', '2023-09-22 20:01:08'),
(507, 1, 7, '', '2023-09-22 20:04:02'),
(508, 1, 7, '', '2023-09-22 20:04:23'),
(510, 1, 7, '', '2023-09-22 20:04:37'),
(511, 1, 7, '', '2023-09-22 20:05:07'),
(512, 1, 16, '', '2023-09-22 20:06:11'),
(513, 1, 7, '', '2023-09-22 20:06:23'),
(515, 1, 7, '', '2023-09-22 20:07:02'),
(516, 1, 7, '', '2023-09-22 20:07:06'),
(517, 1, 7, '', '2023-09-22 20:08:30'),
(518, 1, 7, '', '2023-09-22 20:08:34'),
(519, 1, 7, '', '2023-09-22 20:11:50'),
(520, 1, 7, '', '2023-09-22 20:11:57'),
(521, 1, 7, '', '2023-09-22 20:12:02'),
(522, 1, 7, '', '2023-09-22 20:12:12'),
(523, 1, 7, '', '2023-09-22 20:13:18'),
(524, 1, 7, '', '2023-09-22 20:13:31'),
(525, 1, 7, '', '2023-09-22 20:13:50'),
(526, 1, 7, '', '2023-09-22 20:16:26'),
(527, 1, 7, '', '2023-09-22 20:16:50'),
(528, 1, 7, '', '2023-09-22 20:17:25'),
(529, 1, 7, '', '2023-09-22 20:22:57'),
(530, 1, 7, '', '2023-09-22 20:23:03'),
(531, 1, 7, '', '2023-09-22 20:26:27'),
(532, 1, 7, '', '2023-09-22 20:26:32'),
(533, 1, 7, '', '2023-09-22 20:26:46'),
(534, 1, 7, '', '2023-09-22 20:29:14'),
(535, 1, 7, '', '2023-09-22 20:29:19'),
(536, 1, 7, '', '2023-09-22 20:30:59'),
(537, 1, 7, '', '2023-09-22 20:33:59'),
(539, 1, 7, '', '2023-09-22 20:34:33'),
(540, 1, 7, '', '2023-09-22 20:34:51'),
(542, 1, 7, '', '2023-09-22 20:35:06'),
(550, 1, 7, '', '2023-09-22 20:36:27'),
(551, 1, 7, '', '2023-09-22 20:36:52'),
(553, 1, 7, '', '2023-09-22 20:50:11'),
(554, 1, 7, '', '2023-09-22 20:50:51'),
(557, 1, 7, '', '2023-09-22 21:44:29'),
(558, 1, 7, '', '2023-09-22 21:44:45'),
(559, 1, 7, '', '2023-09-22 21:44:49'),
(560, 1, 7, '', '2023-09-22 21:44:53'),
(561, 1, 7, '', '2023-09-22 21:44:56'),
(562, 1, 7, '', '2023-09-22 21:44:59'),
(563, 1, 7, '', '2023-09-22 21:45:02'),
(564, 1, 7, '', '2023-09-22 21:45:04'),
(565, 1, 7, '', '2023-09-22 21:45:06');

-- --------------------------------------------------------

--
-- Table structure for table `global_chat`
--

CREATE TABLE `global_chat` (
  `id` int(11) NOT NULL,
  `player_id` int(11) NOT NULL,
  `date` varchar(255) NOT NULL,
  `time` varchar(255) NOT NULL,
  `message` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `global_chat`
--

INSERT INTO `global_chat` (`id`, `player_id`, `date`, `time`, `message`) VALUES
(1, 1, '31 July 2023', '21:26', 'sasasa'),
(2, 1, '22 August 2023', '20:05', 'ssssaa');

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `level` int(11) NOT NULL DEFAULT 0,
  `type` varchar(50) NOT NULL,
  `max_hp` int(11) NOT NULL,
  `max_energy` int(11) NOT NULL,
  `power` int(11) NOT NULL,
  `agility` int(11) NOT NULL,
  `endurance` int(11) NOT NULL,
  `intelligence` int(11) NOT NULL,
  `attack` int(11) NOT NULL,
  `defense` int(11) NOT NULL,
  `bonus_xp` int(11) NOT NULL,
  `nolietojums` int(11) NOT NULL,
  `max_nolietojums` int(11) NOT NULL,
  `zelts` int(11) NOT NULL,
  `koks` int(11) NOT NULL,
  `dzelzs` int(11) NOT NULL,
  `āda` int(11) NOT NULL,
  `akmens` int(11) NOT NULL,
  `action_duration_hours` int(11) NOT NULL,
  `upgradable_stats` varchar(255) DEFAULT NULL,
  `dimants` int(11) NOT NULL,
  `min_level` int(11) NOT NULL,
  `max_level` int(11) NOT NULL,
  `active` varchar(255) NOT NULL DEFAULT 'Yes',
  `role` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`id`, `name`, `image`, `level`, `type`, `max_hp`, `max_energy`, `power`, `agility`, `endurance`, `intelligence`, `attack`, `defense`, `bonus_xp`, `nolietojums`, `max_nolietojums`, `zelts`, `koks`, `dzelzs`, `āda`, `akmens`, `action_duration_hours`, `upgradable_stats`, `dimants`, `min_level`, `max_level`, `active`, `role`) VALUES
(111, 'Spēka Mikstūra 1 Stunda', 'images/items/miksturas/111.jpg', 0, '7', 0, 0, 100, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, '0', 5, 0, 0, 'Yes', ''),
(112, 'Spēka Mikstūra 2 Stundas', 'images/items/miksturas/111.jpg', 0, '7', 0, 0, 100, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 2, '', 0, 0, 0, 'Yes', ''),
(114, 'Mūmijas Cepure', 'images/items/cepures/1.jpg', 0, '1', 0, 25, 0, 0, 0, 0, 0, 0, 0, 100, 100, 3000, 1000, 1000, 1000, 1000, 0, '0', 0, 0, 25, 'Yes', ''),
(115, 'Mūmijas Apmetnis', 'images/items/apmetņi/9.jpg', 0, '2', 25, 0, 0, 0, 0, 0, 0, 0, 0, 100, 100, 100, 0, 0, 0, 0, 0, '0', 0, 0, 25, 'Yes', ''),
(116, 'Mūmijas Nūja', 'images/items/nūjas/10.jpg', 0, '3', 0, 0, 25, 0, 0, 0, 25, 0, 0, 100, 100, 100, 0, 0, 0, 0, 0, '0', 0, 0, 25, 'Yes', ''),
(117, 'Mūmijas Amulets', 'images/items/amuleti/7.jpg', 0, '4', 0, 0, 0, 25, 0, 0, 0, 0, 0, 100, 100, 100, 0, 0, 0, 0, 0, '0', 0, 0, 25, 'Yes', ''),
(118, 'Mūmijas Apavi', 'images/items/zābaki/8.jpg', 0, '5', 0, 0, 0, 0, 25, 0, 0, 0, 0, 100, 100, 100, 0, 0, 0, 0, 0, '0', 0, 0, 25, 'Yes', ''),
(119, 'Mūmijas Spēka Gredzens', 'images/items/ringi/3.jpg', 0, '6', 0, 0, 20, 0, 0, 0, 20, 0, 0, 100, 100, 0, 0, 0, 0, 0, 0, '0', 0, 0, 25, 'Yes', ''),
(120, 'Mūmijas Dzīvības Gredzens ', 'images/items/ringi/5.jpg', 0, '6', 20, 0, 0, 0, 0, 0, 0, 0, 0, 100, 100, 100, 0, 0, 0, 0, 0, '0', 0, 0, 25, 'Yes', ''),
(121, 'Mūmijas Enerģijas Gredzens', 'images/items/ringi/6.jpg', 0, '6', 0, 20, 0, 0, 0, 0, 0, 0, 0, 100, 100, 100, 0, 0, 0, 0, 0, '0', 0, 0, 25, 'Yes', ''),
(122, 'Xp Mikstūra 10% 1Stunda', 'images/items/miksturas/121.jpg', 0, '7', 0, 0, 0, 0, 0, 0, 0, 0, 10, 0, 0, 0, 0, 0, 0, 0, 1, '0', 10, 0, 0, 'Yes', 'VIP');

-- --------------------------------------------------------

--
-- Table structure for table `item_categories`
--

CREATE TABLE `item_categories` (
  `id` int(11) NOT NULL,
  `category` varchar(255) NOT NULL,
  `fa_icon` varchar(255) NOT NULL,
  `equipped_count` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `item_categories`
--

INSERT INTO `item_categories` (`id`, `category`, `fa_icon`, `equipped_count`) VALUES
(1, 'cepures', 'fa-shield-alt', 0),
(2, 'apmetnis', ' ', 0),
(3, 'nūjas', 'fa-gavel', 0),
(4, 'amulets', ' ', 0),
(5, 'zābaki', ' ', 0),
(6, 'gredzens', 'fa', 0),
(7, 'miksturas', 'fa-solid fa-flask', 0);

-- --------------------------------------------------------

--
-- Table structure for table `item_upgrades`
--

CREATE TABLE `item_upgrades` (
  `id` int(11) NOT NULL,
  `item_id` int(11) DEFAULT NULL,
  `upgrade_chance` decimal(5,2) DEFAULT NULL,
  `required_resources` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `izsoles`
--

CREATE TABLE `izsoles` (
  `id` int(11) NOT NULL,
  `image` varchar(255) NOT NULL,
  `item_id` int(11) NOT NULL,
  `player_id` int(11) NOT NULL DEFAULT 0,
  `preces_apraksts` text NOT NULL,
  `ievietosanas_datums` timestamp NOT NULL DEFAULT current_timestamp(),
  `resurss` varchar(255) NOT NULL,
  `daudzums` int(11) NOT NULL,
  `termins` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `izsoles`
--

INSERT INTO `izsoles` (`id`, `image`, `item_id`, `player_id`, `preces_apraksts`, `ievietosanas_datums`, `resurss`, `daudzums`, `termins`) VALUES
(2, '', 108, 1, 'tests', '2023-09-13 02:39:30', 'dimants', 1400, '2023-09-14 02:39:30');

-- --------------------------------------------------------

--
-- Table structure for table `languages`
--

CREATE TABLE `languages` (
  `id` int(11) NOT NULL,
  `language` varchar(255) NOT NULL,
  `langcode` varchar(255) NOT NULL,
  `default_language` varchar(255) NOT NULL DEFAULT 'Yes/No'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `languages`
--

INSERT INTO `languages` (`id`, `language`, `langcode`, `default_language`) VALUES
(1, 'English', 'en', 'Yes'),
(2, 'Latviešu', 'lv', 'No');

-- --------------------------------------------------------

--
-- Table structure for table `levels`
--

CREATE TABLE `levels` (
  `level` int(11) NOT NULL,
  `min_respect` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `levels`
--

INSERT INTO `levels` (`level`, `min_respect`) VALUES
(0, 0),
(1, 100),
(2, 566),
(3, 1559),
(4, 3200),
(5, 5590),
(6, 8818),
(7, 12964),
(8, 18102),
(9, 24300),
(10, 31623),
(11, 40131),
(12, 49883),
(13, 60934),
(14, 73336),
(15, 87142),
(16, 102400),
(17, 119158),
(18, 137462),
(19, 157356),
(20, 178885),
(21, 202092),
(22, 227016),
(23, 253699),
(24, 282181),
(25, 312500),
(26, 344694),
(27, 378800),
(28, 414854),
(29, 452892),
(30, 492950),
(31, 535062),
(32, 579262),
(33, 625583),
(34, 674058),
(35, 724720),
(36, 777600),
(37, 832730),
(38, 890141),
(39, 949864),
(40, 1011929),
(41, 1076365),
(42, 1143203),
(43, 1212470),
(44, 1284197),
(45, 1358411),
(46, 1435141),
(47, 1514414),
(48, 1596258),
(49, 1680700),
(50, 1767767);

-- --------------------------------------------------------

--
-- Table structure for table `lobby`
--

CREATE TABLE `lobby` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `avatar` varchar(255) NOT NULL,
  `monsterb_id` int(11) NOT NULL,
  `date` varchar(255) NOT NULL,
  `time` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `loot`
--

CREATE TABLE `loot` (
  `id` int(11) NOT NULL,
  `monster_id` int(11) NOT NULL,
  `item_id` varchar(255) NOT NULL,
  `item_description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `fromid` int(11) NOT NULL,
  `toid` int(11) NOT NULL,
  `date` varchar(255) NOT NULL,
  `time` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `viewed` varchar(3) NOT NULL DEFAULT 'No',
  `reply_to` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `fromid`, `toid`, `date`, `time`, `content`, `viewed`, `reply_to`) VALUES
(3, 1, 5, '02 June 2023', '13:38', 'admin challenged you to fight and you lost the fight. You lost $265.', 'Yes', ''),
(4, 1, 2, '04 June 2023', '18:13', 'admin challenged you to fight and you lost the fight. You lost $265.', 'Yes', ''),
(5, 9, 11, '07 June 2023', '20:17', 'Demo1 challenged you to fight and you lost the fight. You lost $265.', 'No', ''),
(6, 1, 10, '08 June 2023', '11:25', 'admin challenged you to fight and you lost the fight. You lost $265.', 'No', ''),
(7, 1, 10, '08 June 2023', '11:25', 'admin challenged you to fight and you lost the fight. You lost $265.', 'No', ''),
(8, 1, 10, '08 June 2023', '11:25', 'admin challenged you to fight and you lost the fight. You lost $265.', 'No', ''),
(9, 1, 11, '08 June 2023', '11:25', 'admin challenged you to fight and you lost the fight. You lost $265.', 'No', ''),
(10, 1, 11, '08 June 2023', '11:25', 'admin challenged you to fight and you lost the fight. You lost $265.', 'No', ''),
(11, 1, 2, '05 August 2023', '15:47', 'sdasdasd', 'Yes', ''),
(12, 2, 1, '05 August 2023', '15:54', 'sdasdas', 'Yes', ''),
(13, 1, 2, '01 September 2023', '18:51', 'cccc', 'Yes', ''),
(14, 1, 2, '01 September 2023', '18:53', 'cccc', 'Yes', ''),
(15, 1, 2, '01 September 2023', '18:53', 'qqqq', 'Yes', ''),
(16, 1, 0, '01 September 2023', '18:54', 'tests?\r\n', 'No', '');

-- --------------------------------------------------------

--
-- Table structure for table `miksturi`
--

CREATE TABLE `miksturi` (
  `id` int(11) NOT NULL,
  `nosaukums` varchar(255) NOT NULL,
  `ilgums_minutes` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `monsters`
--

CREATE TABLE `monsters` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `avatar` varchar(255) NOT NULL,
  `character_id` int(11) NOT NULL,
  `hp` int(11) NOT NULL,
  `damage_no` int(11) NOT NULL,
  `damage_lidz` int(11) NOT NULL,
  `attack_interval` int(11) NOT NULL,
  `uzbrukums` int(11) NOT NULL,
  `aizsardzība` int(11) NOT NULL,
  `zelts_no` int(11) NOT NULL,
  `zelts_lidz` int(11) NOT NULL,
  `koks_no` int(11) DEFAULT NULL,
  `koks_lidz` int(11) DEFAULT NULL,
  `dzelzs_no` int(11) DEFAULT NULL,
  `dzelzs_lidz` int(11) DEFAULT NULL,
  `ada_no` int(11) DEFAULT NULL,
  `ada_lidz` int(11) DEFAULT NULL,
  `akmens_no` int(11) DEFAULT NULL,
  `akmens_lidz` int(11) DEFAULT NULL,
  `xp` int(11) NOT NULL,
  `resistance` decimal(4,2) NOT NULL DEFAULT 0.00,
  `loot` int(11) NOT NULL,
  `monster_drop_chance` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `monsters`
--

INSERT INTO `monsters` (`id`, `username`, `avatar`, `character_id`, `hp`, `damage_no`, `damage_lidz`, `attack_interval`, `uzbrukums`, `aizsardzība`, `zelts_no`, `zelts_lidz`, `koks_no`, `koks_lidz`, `dzelzs_no`, `dzelzs_lidz`, `ada_no`, `ada_lidz`, `akmens_no`, `akmens_lidz`, `xp`, `resistance`, `loot`, `monster_drop_chance`) VALUES
(7, 'Mardaks', 'images/monsters/pic_monster/7.png', 1, 150, 1, 10, 3, 100, 100, 1, 100, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 10, '1.00', 122, 30),
(13, 'Karaliena', 'images/monsters/pic_monster/8.png', 2, 2000, 1, 200, 4, 100, 100, 1, 150, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 20, '0.00', 0, 0),
(14, 'Kakadu', 'images/monsters/pic_monster/1.png', 3, 3000, 1, 300, 5, 1, 100, 1, 150, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 25, '0.00', 0, 0),
(15, 'Lakrusu', 'images/monsters/pic_monster/2.png', 4, 4000, 1, 400, 6, 1, 1, 1, 1000, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 35, '0.00', 0, 0),
(16, 'Lapiņa', 'images/monsters/pic_monster/3.png', 5, 5000, 1, 500, 7, 1, 1, 1, 1000, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 55, '0.00', 0, 0),
(17, 'Dieviete', 'images/monsters/pic_monster/5.png', 6, 6000, 1, 600, 8, 1, 1, 1, 1000, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 85, '0.00', 0, 0),
(18, 'Puuka', 'images/monsters/pic_monster/9.png', 7, 7000, 1, 700, 9, 1000, 1000, 1, 1000, 1, 1000, 1, 1000, 1, 1000, 1, 1000, 105, '0.50', 122, 0);

-- --------------------------------------------------------

--
-- Table structure for table `monsters_characters`
--

CREATE TABLE `monsters_characters` (
  `id` int(11) NOT NULL,
  `image` varchar(255) NOT NULL,
  `category_id` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `monsters_characters`
--

INSERT INTO `monsters_characters` (`id`, `image`, `category_id`) VALUES
(1, 'images/characters/female/5f.png', 1),
(2, 'images/characters/female/1f.png', 2),
(3, 'images/characters/female/2f.png', 3),
(4, 'images/characters/female/3f.png', 4),
(5, 'images/characters/female/6f.png', 5),
(6, 'images/characters/female/7f.png', 6),
(7, 'images/characters/male/1m.png', 7),
(8, 'images/characters/male/2m.png', 8),
(9, 'images/characters/male/3m.png', 9),
(10, 'images/characters/male/4m.png', 10),
(11, 'images/characters/male/5m.png', 11),
(12, 'images/characters/male/6m.png', 12);

-- --------------------------------------------------------

--
-- Table structure for table `paid_services`
--

CREATE TABLE `paid_services` (
  `id` int(11) NOT NULL,
  `service` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL DEFAULT 'images/icons/',
  `type` varchar(255) NOT NULL,
  `amount` int(11) NOT NULL,
  `cost` int(11) NOT NULL,
  `currency` varchar(255) NOT NULL DEFAULT 'EUR'
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `paid_services`
--

INSERT INTO `paid_services` (`id`, `service`, `image`, `type`, `amount`, `cost`, `currency`) VALUES
(9, 'Energy Pack', 'images/icons/energy.png', 'energyrefill', 100, 2, 'EUR');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset`
--

CREATE TABLE `password_reset` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `resetkey` varchar(255) NOT NULL,
  `expiry_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` int(11) NOT NULL,
  `player_id` int(11) NOT NULL,
  `service_id` int(11) NOT NULL,
  `txn_id` varchar(255) NOT NULL,
  `date` varchar(255) NOT NULL,
  `time` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `players`
--

CREATE TABLE `players` (
  `id` int(11) NOT NULL,
  `avatar` varchar(255) NOT NULL DEFAULT 'images/pic_image/0.jpg',
  `clan_id` int(11) NOT NULL,
  `clanjoin` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL DEFAULT 'Player',
  `clan_role` varchar(255) NOT NULL DEFAULT 'Officer',
  `level` int(11) NOT NULL DEFAULT 1,
  `dimants` int(11) NOT NULL,
  `zelts` int(11) NOT NULL,
  `koks` int(11) NOT NULL,
  `dzelzs` int(11) NOT NULL,
  `āda` int(11) NOT NULL,
  `akmens` int(11) NOT NULL,
  `respect` int(11) NOT NULL DEFAULT 0,
  `hp` int(11) NOT NULL DEFAULT 100,
  `max_hp` int(11) NOT NULL DEFAULT 100,
  `energy` int(11) NOT NULL DEFAULT 100,
  `max_energy` int(11) NOT NULL DEFAULT 100,
  `clan_bonus_applied` int(1) NOT NULL,
  `total_power` int(11) NOT NULL,
  `attack` int(11) NOT NULL,
  `defense` int(11) NOT NULL,
  `power` int(11) NOT NULL DEFAULT 0,
  `agility` int(11) NOT NULL DEFAULT 0,
  `endurance` int(11) NOT NULL DEFAULT 0,
  `intelligence` int(11) NOT NULL DEFAULT 0,
  `speed` int(11) NOT NULL,
  `character_id` int(11) NOT NULL DEFAULT 0,
  `atr_point` int(11) NOT NULL,
  `bank` int(11) NOT NULL DEFAULT 0,
  `bank_gold` int(11) NOT NULL,
  `timeonline` varchar(255) NOT NULL,
  `daily_bonus` varchar(255) DEFAULT NULL,
  `spins` int(11) NOT NULL,
  `status` varchar(255) NOT NULL,
  `upgrade_stones` int(11) DEFAULT 0,
  `nepieciesamie_akmeni` int(11) DEFAULT 0,
  `magic_level` int(11) DEFAULT 0,
  `points` int(11) NOT NULL,
  `reward_given` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `players`
--

INSERT INTO `players` (`id`, `avatar`, `clan_id`, `clanjoin`, `username`, `password`, `email`, `role`, `clan_role`, `level`, `dimants`, `zelts`, `koks`, `dzelzs`, `āda`, `akmens`, `respect`, `hp`, `max_hp`, `energy`, `max_energy`, `clan_bonus_applied`, `total_power`, `attack`, `defense`, `power`, `agility`, `endurance`, `intelligence`, `speed`, `character_id`, `atr_point`, `bank`, `bank_gold`, `timeonline`, `daily_bonus`, `spins`, `status`, `upgrade_stones`, `nepieciesamie_akmeni`, `magic_level`, `points`, `reward_given`) VALUES
(1, 'images/pic_image/admin.jpg', 190, 0, 'Tiesnesis', 'd19cb4afff3cf72e327de5f96564bb1c32235ab0250c217e2faddbf2eff238e4', 'demo@demo2.ss', 'Admin', 'Leader', 8, 4300, 78872, 0, 0, 0, 0, 19611, 362780, 370689, 100005, 100005, 0, 25, 0, 0, 160, 0, 0, 0, 120, 9, 18, 0, 0, '1695461999', '23 September 2023', 0, '', 10000000, 0, 4, 620, 0),
(2, 'images/pic_image/19.jpg', 0, 0, 'demo', '2a97516c354b68848cdbd8f54a226a0a55b21ed138e207ad6c5cbb9c00aa5aea', 'demo@demo.com', 'VIP', 'Officer', 5, 71190, 94192, 98000, 98000, 98000, 98000, 7651, 237, 301, 129, 129, 0, 25, 30, 10, 100, 10, 10, 10, 120, 3, 1, 0, 0, '1695455329', '23 September 2023', 10, '', 0, 0, 0, 0, 0),
(3, 'images/pic_image/admin.jpg', 0, 0, 'Edgars', '4d1d174cda4c5708bd2c1cda474d9d2ee60b5f545893b6d523b2d9b58b71c291', 'edgars@edgars.com', 'Admin', 'Member', 1, 31950, 0, 0, 0, 0, 0, 500, 0, 128, 101, 101, 0, 25, 25, 0, 25, 0, 0, 0, 120, 3, 0, 100, 0, '1695407880', '22 September 2023', 0, '', 0, 0, 0, 0, 0),
(4, 'images/pic_image/0.jpg', 189, 0, 'Demo2', '2a97516c354b68848cdbd8f54a226a0a55b21ed138e207ad6c5cbb9c00aa5aea', 'dsds@dsd.ds', 'Player', 'Leader', 3, 20970, 4500, 0, 0, 0, 0, 2925, 5, 102, 104, 104, 0, 0, 0, 0, 10, 0, 10, 0, 120, 4, 6, 0, 0, '1693509661', '27 August 2023', 0, '', 0, 0, 0, 0, 0),
(5, 'images/pic_image/0.jpg', 0, 0, 'Demo3', '2a97516c354b68848cdbd8f54a226a0a55b21ed138e207ad6c5cbb9c00aa5aea', 'assa@sas.sa', 'Player', 'Officer', 3, 10400, 0, 0, 0, 0, 0, 2600, 0, 100, 100, 100, 0, 0, 0, 0, 10, 0, 10, 0, 120, 6, 6, 0, 0, '1694532484', '12 September 2023', 0, '', 0, 0, 0, 0, 0),
(14, 'images/pic_image/0.jpg', 0, 0, 'test1', '9f86d081884c7d659a2feaa0c55ad015a3bf4f1b2b0b822cd15d6c15b0f00a08', 'tes@tes.com', 'Player', 'Officer', 1, 2800, 0, 0, 0, 0, 0, 0, 40, 100, 100, 100, 0, 0, 0, 0, 0, 0, 0, 0, 120, 3, 0, 0, 0, '1691268404', '05 August 2023', 0, '', 0, 0, 0, 0, 0),
(15, 'images/pic_image/0.jpg', 0, 0, 'test2', '9f86d081884c7d659a2feaa0c55ad015a3bf4f1b2b0b822cd15d6c15b0f00a08', 'tes2@tes.com', 'Player', 'Officer', 1, 1650, 0, 0, 0, 0, 0, 0, 40, 100, 100, 100, 0, 0, 0, 0, 0, 0, 0, 0, 120, 2, 0, 0, 0, '1691358981', '06 August 2023', 0, '', 0, 0, 0, 0, 0),
(16, 'images/pic_image/0.jpg', 0, 0, 'test3', '9f86d081884c7d659a2feaa0c55ad015a3bf4f1b2b0b822cd15d6c15b0f00a08', 'tes3@tes.com', 'Player', 'Officer', 1, 850, 0, 0, 0, 0, 0, 0, 0, 100, 100, 100, 0, 0, 0, 0, 0, 0, 0, 0, 120, 1, 0, 0, 0, '1691362121', '06 August 2023', 0, '', 0, 0, 0, 0, 0),
(17, 'images/pic_image/0.jpg', 0, 0, 'Angel', '2a97516c354b68848cdbd8f54a226a0a55b21ed138e207ad6c5cbb9c00aa5aea', 'hshshssu@djdjdj.dj', 'Player', 'Officer', 1, 550, 0, 0, 0, 0, 0, 0, 40, 100, 100, 100, 0, 0, 0, 0, 0, 0, 0, 0, 120, 6, 0, 0, 0, '1691363571', '06 August 2023', 0, '', 0, 0, 0, 0, 0),
(18, 'images/pic_image/0.jpg', 0, 0, 'tetstsq', '2a97516c354b68848cdbd8f54a226a0a55b21ed138e207ad6c5cbb9c00aa5aea', 'vasjaaviiiww@gmail.com', 'Player', 'Officer', 1, 250, 1000, 0, 0, 0, 0, 650, 40, 100, 100, 100, 0, 0, 0, 0, 0, 0, 0, 0, 120, 6, 0, 0, 0, '1692732637', '22 August 2023', 0, '', 0, 0, 0, 0, 0),
(19, 'images/pic_image/0.jpg', 0, 0, 'admin1', '2a97516c354b68848cdbd8f54a226a0a55b21ed138e207ad6c5cbb9c00aa5aea', 'vasjaavii22i@gmail.com', 'Player', 'Officer', 1, 1500, 0, 0, 0, 0, 0, 0, 100, 100, 100, 100, 0, 0, 0, 0, 0, 0, 0, 0, 120, 0, 0, 0, 0, '1692738093', '22 August 2023', 0, '', 0, 0, 0, 0, 0),
(20, 'images/pic_image/0.jpg', 0, 0, 'demo8', '2a97516c354b68848cdbd8f54a226a0a55b21ed138e207ad6c5cbb9c00aa5aea', 'vasjaadfdffviii@gmail.com', 'Player', 'Officer', 1, 900, 0, 0, 0, 0, 0, 0, 100, 100, 100, 100, 0, 0, 0, 0, 0, 0, 0, 0, 120, 0, 0, 0, 0, '1692782092', '23 August 2023', 0, '', 0, 0, 0, 0, 0),
(21, 'images/pic_image/0.jpg', 0, 0, 'adminqq', '8c6976e5b5410415bde908bd4dee15dfb167a9c873fc4bb8a81f6f2ab448a918', 'vasjaaviiiw@gmail.com', 'Player', 'Officer', 1, 450, 0, 0, 0, 0, 0, 0, 100, 100, 100, 100, 0, 0, 0, 0, 0, 0, 0, 0, 120, 0, 0, 0, 0, '1692890053', NULL, 0, '', 0, 0, 0, 0, 0),
(22, 'images/pic_image/0.jpg', 0, 0, 'adminaas', '8c6976e5b5410415bde908bd4dee15dfb167a9c873fc4bb8a81f6f2ab448a918', 'vasjsaaaviiisa@gmail.comasa', 'Player', 'Officer', 1, 300, 0, 0, 0, 0, 0, 0, 100, 100, 100, 100, 0, 0, 0, 0, 0, 0, 0, 0, 120, 0, 0, 0, 0, '1692890214', NULL, 0, '', 0, 0, 0, 0, 0),
(24, 'images/pic_image/0.jpg', 0, 0, 'admink', '8c6976e5b5410415bde908bd4dee15dfb167a9c873fc4bb8a81f6f2ab448a918', 'vasjsaaa2viiisa@gmail.com', 'Player', 'Officer', 1, 150, 0, 0, 0, 0, 0, 0, 100, 100, 100, 100, 0, 0, 0, 0, 0, 0, 0, 0, 120, 0, 0, 0, 0, '1692890645', NULL, 0, '', 0, 0, 0, 0, 0),
(25, 'images/pic_image/0.jpg', 0, 0, 'tiesnesis1', '8c6976e5b5410415bde908bd4dee15dfb167a9c873fc4bb8a81f6f2ab448a918', 'vasjaa21viii@gmail.com', 'Player', 'Officer', 1, 1500, 0, 0, 0, 0, 0, 0, 100, 100, 100, 100, 0, 0, 0, 0, 0, 0, 0, 0, 120, 0, 0, 0, 0, '1692890910', NULL, 0, '', 0, 0, 0, 0, 0),
(26, 'images/pic_image/0.jpg', 0, 0, 'tiesnesis3', '8c6976e5b5410415bde908bd4dee15dfb167a9c873fc4bb8a81f6f2ab448a918', 'vasja2aviiiww@gmail.com', 'Player', 'Officer', 1, 900, 0, 0, 0, 0, 0, 0, 100, 100, 100, 100, 0, 0, 0, 0, 0, 0, 0, 0, 120, 0, 0, 0, 0, '1692890999', NULL, 0, '', 0, 0, 0, 0, 0),
(27, 'images/pic_image/0.jpg', 0, 0, 's', '043a718774c572bd8a25adbeb1bfcd5c0256ae11cecf9f9c3f925d0e52beaf89', 's', 'Player', 'Officer', 1, 450, 0, 0, 0, 0, 0, 0, 100, 100, 100, 100, 0, 0, 0, 0, 0, 0, 0, 0, 120, 0, 0, 0, 0, '1692891883', NULL, 0, '', 0, 0, 0, 0, 0),
(28, 'images/pic_image/0.jpg', 0, 0, '111111', 'd17f25ecfbcc7857f7bebea469308be0b2580943e96d13a3ad98a13675c4bfc2', '1', 'Player', 'Officer', 1, 300, 0, 0, 0, 0, 0, 0, 100, 100, 100, 100, 0, 0, 0, 0, 0, 0, 0, 0, 120, 0, 0, 0, 0, '1692892196', NULL, 0, '', 0, 0, 0, 0, 0),
(29, 'images/pic_image/0.jpg', 0, 0, 'tiesnesis333', '8c6976e5b5410415bde908bd4dee15dfb167a9c873fc4bb8a81f6f2ab448a918', '2', 'Player', 'Officer', 1, 150, 0, 0, 0, 0, 0, 0, 100, 100, 100, 100, 0, 0, 0, 0, 0, 0, 0, 0, 120, 0, 0, 0, 0, '1692893198', NULL, 0, '', 0, 0, 0, 0, 0),
(30, 'images/pic_image/0.jpg', 0, 0, 'admin1111', '8c6976e5b5410415bde908bd4dee15dfb167a9c873fc4bb8a81f6f2ab448a918', 'vasjaaviii@gmail.com', 'Player', 'Officer', 1, 1500, 0, 0, 0, 0, 0, 0, 100, 100, 100, 100, 0, 0, 0, 0, 0, 0, 0, 0, 120, 3, 0, 0, 0, '1692893881', NULL, 0, '', 0, 0, 0, 0, 0),
(32, 'images/pic_image/0.jpg', 0, 0, 'Sajas', '8c6976e5b5410415bde908bd4dee15dfb167a9c873fc4bb8a81f6f2ab448a918', 'Ss', 'Player', 'Officer', 0, 900, 0, 0, 0, 0, 0, 0, 100, 100, 100, 100, 0, 0, 0, 0, 0, 0, 0, 0, 120, 0, 0, 0, 0, '1693328685', NULL, 0, '', 0, 0, 0, 0, 0),
(33, 'images/pic_image/0.jpg', 0, 0, 'adminaasasa', 'a6c069419d501437cbae3ce92e14e36d07bd5135fd83a3164b9abba32992946f', 'ekrilovs8@gmail.co', 'Player', 'Officer', 0, 450, 0, 0, 0, 0, 0, 0, 100, 100, 100, 100, 0, 0, 0, 0, 0, 0, 0, 0, 120, 0, 0, 0, 0, '1693404315', NULL, 0, '', 0, 0, 0, 0, 0),
(34, 'images/pic_image/0.jpg', 0, 0, 'tiesnesisdadasd', 'aac0b1e9c7496922938cadf8bd21e7d8aea90f2fc534818c83cef8479c5dd341', 'vasjaav111iii@gmail.com', 'Player', 'Officer', 0, 300, 0, 0, 0, 0, 0, 0, 100, 100, 100, 100, 0, 0, 0, 0, 0, 0, 0, 0, 120, 0, 0, 0, 0, '1693404573', NULL, 0, '', 0, 0, 0, 0, 0),
(35, 'images/pic_image/0.jpg', 0, 0, 'demoddsdsds', '004d051a9f8f0d65dc04b49422d789b460a377b90ab67179a79e70abd85b6981', 'vasjdssd', 'Player', 'Officer', 0, 150, 0, 0, 0, 0, 0, 0, 100, 100, 100, 100, 0, 0, 0, 0, 0, 0, 0, 0, 120, 0, 0, 0, 0, '1693404943', NULL, 0, '', 0, 0, 0, 0, 0),
(36, 'images/pic_image/0.jpg', 0, 0, 'Slepenais', 'b590a3a5b922f46a25966baa0141b1384a095876b24444e97795629ede248f02', 'starkingxxc@gmail.com', 'Player', 'Officer', 0, 1500, 0, 0, 0, 0, 0, 0, 100, 100, 100, 100, 0, 0, 0, 0, 0, 0, 0, 0, 120, 2, 0, 0, 0, '1694109075', NULL, 0, '', 0, 0, 0, 0, 0),
(37, 'images/pic_image/0.jpg', 0, 0, 'iksdee', '9b2db4b30d5a525de90da52eb5939c3d6b607c3b645c0f83c9ac63889eb04a46', 'iksdee@gmail.com', 'Player', 'Officer', 0, 1900, 0, 0, 0, 0, 0, 0, 100, 100, 100, 100, 0, 0, 0, 0, 0, 0, 0, 0, 120, 3, 0, 0, 0, '1694426398', '11 September 2023', 0, '', 0, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `player_actions`
--

CREATE TABLE `player_actions` (
  `id` int(11) NOT NULL,
  `player_id` int(11) NOT NULL,
  `action_type` varchar(50) NOT NULL,
  `action_id` int(11) NOT NULL,
  `finishtime` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `player_inventory`
--

CREATE TABLE `player_inventory` (
  `id` int(11) NOT NULL,
  `player_id` int(11) DEFAULT NULL,
  `item_id` int(11) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `level` int(11) NOT NULL,
  `max_level` int(11) NOT NULL,
  `type` int(11) NOT NULL,
  `max_hp` int(11) NOT NULL,
  `max_energy` int(11) NOT NULL,
  `power` int(11) NOT NULL,
  `agility` int(11) NOT NULL,
  `endurance` int(11) NOT NULL,
  `intelligence` int(11) NOT NULL,
  `attack` int(11) NOT NULL,
  `defense` int(11) NOT NULL,
  `nolietojums` int(11) NOT NULL,
  `max_nolietojums` int(11) NOT NULL,
  `bonus_xp` int(11) NOT NULL,
  `equipped` tinyint(1) NOT NULL,
  `equipped_count` int(11) NOT NULL DEFAULT 0,
  `stars` int(11) DEFAULT 0,
  `termiņa_beigas` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `action_duration_hours` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `player_inventory`
--

INSERT INTO `player_inventory` (`id`, `player_id`, `item_id`, `name`, `image`, `level`, `max_level`, `type`, `max_hp`, `max_energy`, `power`, `agility`, `endurance`, `intelligence`, `attack`, `defense`, `nolietojums`, `max_nolietojums`, `bonus_xp`, `equipped`, `equipped_count`, `stars`, `termiņa_beigas`, `action_duration_hours`) VALUES
(570, 2, 114, 'Mūmijas Cepure', 'images/items/cepures/1.jpg', 0, 25, 1, 0, 25, 0, 0, 0, 0, 0, 0, 98, 100, 0, 1, 0, 0, '0000-00-00 00:00:00', 0),
(571, 2, 114, 'Mūmijas Cepure', 'images/items/cepures/1.jpg', 0, 25, 1, 0, 25, 0, 0, 0, 0, 0, 0, 100, 100, 0, 0, 0, 0, '0000-00-00 00:00:00', 0),
(572, 2, 122, 'Xp Mikstūra 10% 1Stunda', 'images/items/miksturas/121.jpg', 0, 0, 7, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 10, 0, 0, 0, '0000-00-00 00:00:00', 1),
(573, 2, 122, 'Xp Mikstūra 10% 1Stunda', 'images/items/miksturas/121.jpg', 0, 0, 7, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 10, 0, 0, 0, '0000-00-00 00:00:00', 1),
(575, 2, 122, 'Xp Mikstūra 10% 1Stunda', 'images/items/miksturas/121.jpg', 0, 0, 7, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 10, 0, 0, 0, '0000-00-00 00:00:00', 1),
(576, 2, 122, 'Xp Mikstūra 10% 1Stunda', 'images/items/miksturas/121.jpg', 0, 0, 7, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 10, 0, 0, 0, '0000-00-00 00:00:00', 1),
(577, 2, 122, 'Xp Mikstūra 10% 1Stunda', 'images/items/miksturas/121.jpg', 0, 0, 7, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 10, 0, 0, 0, '0000-00-00 00:00:00', 1),
(582, 3, 116, 'Mūmijas Nūja', 'images/items/nūjas/10.jpg', 0, 25, 3, 0, 0, 25, 0, 0, 0, 25, 0, 100, 100, 0, 1, 0, 0, '0000-00-00 00:00:00', 0),
(585, 1, 122, 'Xp Mikstūra 10% 1Stunda', 'images/items/miksturas/121.jpg', 0, 0, 7, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 10, 0, 0, 0, '0000-00-00 00:00:00', 1),
(586, 1, 122, 'Xp Mikstūra 10% 1Stunda', 'images/items/miksturas/121.jpg', 0, 0, 7, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 10, 0, 0, 0, '0000-00-00 00:00:00', 1),
(587, 1, 122, 'Xp Mikstūra 10% 1Stunda', 'images/items/miksturas/121.jpg', 0, 0, 7, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 10, 0, 0, 0, '0000-00-00 00:00:00', 1),
(588, 1, 122, 'Xp Mikstūra 10% 1Stunda', 'images/items/miksturas/121.jpg', 0, 0, 7, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 10, 0, 0, 0, '0000-00-00 00:00:00', 1),
(589, 1, 122, 'Xp Mikstūra 10% 1Stunda', 'images/items/miksturas/121.jpg', 0, 0, 7, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 10, 0, 0, 0, '0000-00-00 00:00:00', 1),
(590, 1, 122, 'Xp Mikstūra 10% 1Stunda', 'images/items/miksturas/121.jpg', 0, 0, 7, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 10, 0, 0, 0, '0000-00-00 00:00:00', 1),
(591, 1, 122, 'Xp Mikstūra 10% 1Stunda', 'images/items/miksturas/121.jpg', 0, 0, 7, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 10, 0, 0, 0, '0000-00-00 00:00:00', 1),
(592, 1, 122, 'Xp Mikstūra 10% 1Stunda', 'images/items/miksturas/121.jpg', 0, 0, 7, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 10, 0, 0, 0, '0000-00-00 00:00:00', 1),
(594, 1, 122, 'Xp Mikstūra 10% 1Stunda', 'images/items/miksturas/121.jpg', 0, 0, 7, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 10, 0, 0, 0, '0000-00-00 00:00:00', 1),
(595, 1, 122, 'Xp Mikstūra 10% 1Stunda', 'images/items/miksturas/121.jpg', 0, 0, 7, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 10, 0, 0, 0, '0000-00-00 00:00:00', 1),
(596, 1, 122, 'Xp Mikstūra 10% 1Stunda', 'images/items/miksturas/121.jpg', 0, 0, 7, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 10, 0, 0, 0, '0000-00-00 00:00:00', 1),
(597, 1, 122, 'Xp Mikstūra 10% 1Stunda', 'images/items/miksturas/121.jpg', 0, 0, 7, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 10, 0, 0, 0, '0000-00-00 00:00:00', 1),
(598, 1, 122, 'Xp Mikstūra 10% 1Stunda', 'images/items/miksturas/121.jpg', 0, 0, 7, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 10, 0, 0, 0, '0000-00-00 00:00:00', 1),
(599, 1, 122, 'Xp Mikstūra 10% 1Stunda', 'images/items/miksturas/121.jpg', 0, 0, 7, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 10, 0, 0, 0, '0000-00-00 00:00:00', 1);

-- --------------------------------------------------------

--
-- Table structure for table `player_properties`
--

CREATE TABLE `player_properties` (
  `id` int(11) NOT NULL,
  `player_id` int(11) NOT NULL,
  `property_id` int(11) NOT NULL,
  `profittime` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `player_properties`
--

INSERT INTO `player_properties` (`id`, `player_id`, `property_id`, `profittime`) VALUES
(1, 1, 1, '1693092960'),
(2, 1, 2, '1693093881');

-- --------------------------------------------------------

--
-- Table structure for table `properties`
--

CREATE TABLE `properties` (
  `id` int(11) NOT NULL,
  `property` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL DEFAULT 'images/properties/',
  `money` int(11) NOT NULL,
  `gold` int(11) NOT NULL,
  `min_level` int(11) NOT NULL DEFAULT 1,
  `respect` int(11) NOT NULL,
  `income` int(11) NOT NULL,
  `format` varchar(255) NOT NULL,
  `time` int(11) NOT NULL,
  `vip` varchar(3) NOT NULL DEFAULT 'No'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `properties`
--

INSERT INTO `properties` (`id`, `property`, `image`, `money`, `gold`, `min_level`, `respect`, `income`, `format`, `time`, `vip`) VALUES
(1, 'Shop', 'images/properties/Shop.png', 3000, 0, 1, 1000, 500, 'Minutes', 15, 'No'),
(2, 'Cafe', 'images/properties/Cafe.png', 6000, 0, 2, 2000, 950, 'Minutes', 30, 'No'),
(3, 'Old House', 'images/properties/Old-House.png', 14000, 0, 4, 3500, 1600, 'Hours', 1, 'No'),
(4, 'Small House', 'images/properties/Small-House.png', 25000, 1, 6, 5000, 5000, 'Hours', 3, 'No'),
(5, 'Factory', 'images/properties/Factory.png', 32000, 2, 10, 8000, 9100, 'Hours', 5, 'No'),
(6, 'Big House', 'images/properties/Big-House.png', 48000, 4, 14, 9900, 14000, 'Hours', 8, 'No'),
(7, 'Mansion', 'images/properties/Mansion.png', 60000, 8, 15, 12000, 20000, 'Hours', 10, 'Yes'),
(8, 'School', 'images/properties/School.png', 75000, 12, 16, 14000, 25000, 'Hours', 12, 'No'),
(9, 'Hospital', 'images/properties/Hospital.png', 90500, 20, 17, 16000, 30000, 'Hours', 16, 'No'),
(10, 'Hotel', 'images/properties/Hotel.png', 150000, 37, 17, 18000, 45000, 'Hours', 24, 'Yes'),
(11, 'Company', 'images/properties/Company.png', 264000, 50, 19, 20000, 62000, 'Hours', 24, 'Yes');

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL DEFAULT 'vCity',
  `description` varchar(255) NOT NULL DEFAULT 'vCity - Online Browser Game',
  `keywords` varchar(255) NOT NULL DEFAULT 'online, browser, game, virtual, city, online game, browser game, players, vehicles, upgrades, items, characters',
  `startdimants` int(11) NOT NULL DEFAULT 1500,
  `startzelts` int(11) NOT NULL DEFAULT 20,
  `dailybonus_dimants` int(11) NOT NULL DEFAULT 1,
  `paypal_email` varchar(255) NOT NULL,
  `default_themeid` int(11) NOT NULL DEFAULT 1,
  `about` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `title`, `description`, `keywords`, `startdimants`, `startzelts`, `dailybonus_dimants`, `paypal_email`, `default_themeid`, `about`) VALUES
(1, ' Kordbika.fun', ' ', '', 100, 1000, 1000, '', 34, 'vCity is an online browser game in which you can have your own virutal life. You can buy vehicles, items, properties and you can do many activities.&lt;br /&gt;&lt;br /&gt;\r\n \r\nMain features: \r\n&lt;ul&gt;\r\n   &lt;li&gt;Upgrade character&lt;/li&gt;\r\n   &lt;li&gt;Buy items&lt;/li&gt;\r\n   &lt;li&gt;Buy vehicles&lt;/li&gt;\r\n   &lt;li&gt;Upgrade vehicles&lt;/li&gt;\r\n   &lt;li&gt;Buy Properties and earn income&lt;/li&gt;\r\n   &lt;li&gt;Fight against other players&lt;/li&gt;\r\n   &lt;li&gt;Race against other players&lt;/li&gt;\r\n   &lt;li&gt;Train character in gym&lt;/li&gt;\r\n   &lt;li&gt;Go to school&lt;/li&gt;\r\n   &lt;li&gt;Go to work&lt;/li&gt;\r\n   &lt;li&gt;Advance with levels&lt;/li&gt;\r\n&lt;/ul&gt;');

-- --------------------------------------------------------

--
-- Table structure for table `status`
--

CREATE TABLE `status` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `resources` varchar(255) NOT NULL,
  `price` int(11) NOT NULL,
  `duration_days` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `status`
--

INSERT INTO `status` (`id`, `name`, `image`, `resources`, `price`, `duration_days`) VALUES
(1, 'Judge', 'images/statusi/judge.png', 'dimants', 1000, 5),
(2, 'Statusa nosaukums', 'attelu_ceels.png', '50', 100, 5);

-- --------------------------------------------------------

--
-- Table structure for table `tournaments`
--

CREATE TABLE `tournaments` (
  `id` int(11) NOT NULL,
  `start_datetime` datetime DEFAULT NULL,
  `end_datetime` datetime DEFAULT NULL,
  `is_active` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tournaments`
--

INSERT INTO `tournaments` (`id`, `start_datetime`, `end_datetime`, `is_active`) VALUES
(4, '2023-09-22 18:57:00', '2023-09-25 00:00:00', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tournament_rewards`
--

CREATE TABLE `tournament_rewards` (
  `id` int(11) NOT NULL,
  `player_id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `dimants` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tournament_rewards`
--

INSERT INTO `tournament_rewards` (`id`, `player_id`, `username`, `dimants`) VALUES
(1200, 1, 'Tiesnesis', 500),
(1201, 2, 'demo', 350),
(1202, 3, 'Edgars', 250),
(1203, 4, 'Demo2', 100),
(1204, 5, 'Demo3', 50);

-- --------------------------------------------------------

--
-- Table structure for table `upgrades`
--

CREATE TABLE `upgrades` (
  `id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `power` int(11) NOT NULL,
  `agility` int(11) NOT NULL,
  `endurance` int(11) NOT NULL,
  `intelligence` int(11) NOT NULL,
  `attack` int(11) NOT NULL,
  `defense` int(11) NOT NULL,
  `nolietojums` int(11) NOT NULL,
  `level` int(11) NOT NULL,
  `improve_chance` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `arena_fights`
--
ALTER TABLE `arena_fights`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `attacks`
--
ALTER TABLE `attacks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `avatar`
--
ALTER TABLE `avatar`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ban_list`
--
ALTER TABLE `ban_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `casino_prizes`
--
ALTER TABLE `casino_prizes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `characters`
--
ALTER TABLE `characters`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `character_categories`
--
ALTER TABLE `character_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `chat_messages`
--
ALTER TABLE `chat_messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `clans`
--
ALTER TABLE `clans`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `clansjoin`
--
ALTER TABLE `clansjoin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `clan_member_history`
--
ALTER TABLE `clan_member_history`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `clan_resources`
--
ALTER TABLE `clan_resources`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `clan_upgrades`
--
ALTER TABLE `clan_upgrades`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cron_energyrefill`
--
ALTER TABLE `cron_energyrefill`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `custom_pages`
--
ALTER TABLE `custom_pages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `damage_history`
--
ALTER TABLE `damage_history`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `equipped_items`
--
ALTER TABLE `equipped_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `player_id` (`player_id`),
  ADD KEY `item_id` (`item_id`);

--
-- Indexes for table `fights`
--
ALTER TABLE `fights`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fight_history`
--
ALTER TABLE `fight_history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `player_id` (`player_id`),
  ADD KEY `monster_id` (`monster_id`);

--
-- Indexes for table `global_chat`
--
ALTER TABLE `global_chat`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `item_categories`
--
ALTER TABLE `item_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `item_upgrades`
--
ALTER TABLE `item_upgrades`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `izsoles`
--
ALTER TABLE `izsoles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `languages`
--
ALTER TABLE `languages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `levels`
--
ALTER TABLE `levels`
  ADD PRIMARY KEY (`level`);

--
-- Indexes for table `lobby`
--
ALTER TABLE `lobby`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `loot`
--
ALTER TABLE `loot`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `miksturi`
--
ALTER TABLE `miksturi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `monsters`
--
ALTER TABLE `monsters`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `monsters_characters`
--
ALTER TABLE `monsters_characters`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `paid_services`
--
ALTER TABLE `paid_services`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset`
--
ALTER TABLE `password_reset`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `players`
--
ALTER TABLE `players`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `player_actions`
--
ALTER TABLE `player_actions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `player_inventory`
--
ALTER TABLE `player_inventory`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `fk_player_id` (`player_id`);

--
-- Indexes for table `player_properties`
--
ALTER TABLE `player_properties`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `properties`
--
ALTER TABLE `properties`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `status`
--
ALTER TABLE `status`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tournaments`
--
ALTER TABLE `tournaments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tournament_rewards`
--
ALTER TABLE `tournament_rewards`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `upgrades`
--
ALTER TABLE `upgrades`
  ADD PRIMARY KEY (`id`),
  ADD KEY `item_id` (`item_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `arena_fights`
--
ALTER TABLE `arena_fights`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=938;

--
-- AUTO_INCREMENT for table `attacks`
--
ALTER TABLE `attacks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `avatar`
--
ALTER TABLE `avatar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `ban_list`
--
ALTER TABLE `ban_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `casino_prizes`
--
ALTER TABLE `casino_prizes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `characters`
--
ALTER TABLE `characters`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `character_categories`
--
ALTER TABLE `character_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `chat_messages`
--
ALTER TABLE `chat_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `clans`
--
ALTER TABLE `clans`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=201;

--
-- AUTO_INCREMENT for table `clansjoin`
--
ALTER TABLE `clansjoin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=328;

--
-- AUTO_INCREMENT for table `clan_member_history`
--
ALTER TABLE `clan_member_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `clan_resources`
--
ALTER TABLE `clan_resources`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `clan_upgrades`
--
ALTER TABLE `clan_upgrades`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `cron_energyrefill`
--
ALTER TABLE `cron_energyrefill`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `custom_pages`
--
ALTER TABLE `custom_pages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `damage_history`
--
ALTER TABLE `damage_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6604;

--
-- AUTO_INCREMENT for table `equipped_items`
--
ALTER TABLE `equipped_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `fights`
--
ALTER TABLE `fights`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=360;

--
-- AUTO_INCREMENT for table `fight_history`
--
ALTER TABLE `fight_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=566;

--
-- AUTO_INCREMENT for table `global_chat`
--
ALTER TABLE `global_chat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=123;

--
-- AUTO_INCREMENT for table `item_categories`
--
ALTER TABLE `item_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `item_upgrades`
--
ALTER TABLE `item_upgrades`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `izsoles`
--
ALTER TABLE `izsoles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `languages`
--
ALTER TABLE `languages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `lobby`
--
ALTER TABLE `lobby`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `loot`
--
ALTER TABLE `loot`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `miksturi`
--
ALTER TABLE `miksturi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `monsters`
--
ALTER TABLE `monsters`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `monsters_characters`
--
ALTER TABLE `monsters_characters`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `paid_services`
--
ALTER TABLE `paid_services`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `password_reset`
--
ALTER TABLE `password_reset`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `players`
--
ALTER TABLE `players`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `player_actions`
--
ALTER TABLE `player_actions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `player_inventory`
--
ALTER TABLE `player_inventory`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=600;

--
-- AUTO_INCREMENT for table `player_properties`
--
ALTER TABLE `player_properties`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `properties`
--
ALTER TABLE `properties`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `status`
--
ALTER TABLE `status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tournaments`
--
ALTER TABLE `tournaments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tournament_rewards`
--
ALTER TABLE `tournament_rewards`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1205;

--
-- AUTO_INCREMENT for table `upgrades`
--
ALTER TABLE `upgrades`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `equipped_items`
--
ALTER TABLE `equipped_items`
  ADD CONSTRAINT `equipped_items_ibfk_1` FOREIGN KEY (`player_id`) REFERENCES `players` (`id`),
  ADD CONSTRAINT `equipped_items_ibfk_2` FOREIGN KEY (`item_id`) REFERENCES `player_inventory` (`id`);

--
-- Constraints for table `fight_history`
--
ALTER TABLE `fight_history`
  ADD CONSTRAINT `fight_history_ibfk_1` FOREIGN KEY (`player_id`) REFERENCES `players` (`id`),
  ADD CONSTRAINT `fight_history_ibfk_2` FOREIGN KEY (`monster_id`) REFERENCES `monsters` (`id`);

--
-- Constraints for table `player_inventory`
--
ALTER TABLE `player_inventory`
  ADD CONSTRAINT `fk_player_id` FOREIGN KEY (`player_id`) REFERENCES `players` (`id`),
  ADD CONSTRAINT `player_inventory_ibfk_1` FOREIGN KEY (`player_id`) REFERENCES `players` (`id`);

--
-- Constraints for table `upgrades`
--
ALTER TABLE `upgrades`
  ADD CONSTRAINT `upgrades_ibfk_1` FOREIGN KEY (`item_id`) REFERENCES `player_inventory` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
