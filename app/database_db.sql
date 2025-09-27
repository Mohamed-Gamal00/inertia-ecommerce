-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 27, 2025 at 12:38 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `imdadat`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `super_admin` tinyint(1) NOT NULL DEFAULT 0,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `name`, `email`, `image`, `super_admin`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(11, 'mohamed gamal', 'admin@admin.com', NULL, 0, NULL, '$2y$12$.G5PL0MZ3bNWLGAAR12iI.LVy0gNMlQll2kHjhU2GdZLG8zoZNaPa', 'lFYiTMY9aXkB8ttZcmb6biPF9oO3DgBIj0QNgcaJAanTfcflxMvP6wqkiB5C', '2024-12-18 11:10:42', '2025-03-26 09:26:23'),
(15, 'developer', 'dev@dev.com', NULL, 1, NULL, '$2y$10$BHIViLJ0WbTG.D1ckEzWEOkayrzbsJmNcH.BmcM5RmHs/at7TaC6K', NULL, '2025-03-26 09:34:42', '2025-03-26 09:34:42');

-- --------------------------------------------------------

--
-- Table structure for table `admin_rule`
--

CREATE TABLE `admin_rule` (
  `rule_id` bigint(20) UNSIGNED NOT NULL,
  `admin_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admin_rule`
--

INSERT INTO `admin_rule` (`rule_id`, `admin_id`) VALUES
(8, 11),
(8, 15);

-- --------------------------------------------------------

--
-- Table structure for table `advertisements`
--

CREATE TABLE `advertisements` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `title_en` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `advertisements`
--

INSERT INTO `advertisements` (`id`, `title`, `title_en`, `is_active`, `created_at`, `updated_at`) VALUES
(2, 'ترقبوا تدشين وإطلاق موقع وتطبيق شركة امدادات الضيافة للتجارة ـ أدوات ومستلزمات الفنادق والمستشفيات والمدارس', 'welcome in ID trading', 1, '2024-06-30 10:41:05', '2024-12-19 07:16:15');

-- --------------------------------------------------------

--
-- Table structure for table `bulk_orders`
--

CREATE TABLE `bulk_orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `company_name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `bulk_orders`
--

INSERT INTO `bulk_orders` (`id`, `name`, `phone`, `company_name`, `description`, `created_at`, `updated_at`) VALUES
(1, 'test', '012323432', 'test', 'test', '2025-01-12 10:28:03', '2025-01-12 10:28:03');

-- --------------------------------------------------------

--
-- Table structure for table `carts`
--

CREATE TABLE `carts` (
  `id` char(36) NOT NULL,
  `cookie_id` char(36) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `guest_id` bigint(20) UNSIGNED DEFAULT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` smallint(5) UNSIGNED NOT NULL DEFAULT 1,
  `discounted_price` decimal(8,2) DEFAULT NULL,
  `weight` decimal(6,2) NOT NULL DEFAULT 0.00,
  `color_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `carts`
--

INSERT INTO `carts` (`id`, `cookie_id`, `status`, `user_id`, `guest_id`, `product_id`, `quantity`, `discounted_price`, `weight`, `color_id`, `created_at`, `updated_at`) VALUES
('20e4fb05-6e7f-4ee7-8612-38832bd8985f', 'd823874f-2a60-4bb4-86e7-3dd81646d243', 1, 1, NULL, 16, 3, NULL, 0.00, NULL, '2025-03-29 12:36:43', '2025-03-29 12:37:28'),
('24e9a2b1-79ba-4268-8747-0959f13e619c', '20e884e6-aecd-4f52-9002-65f03c279fad', 1, NULL, NULL, 15, 1, NULL, 10.00, NULL, '2025-05-28 12:04:51', '2025-05-28 12:09:07'),
('413e4e2d-4d52-4b19-a065-c053aad5b36d', '6d4ea3d5-ef0d-4ac5-b7e9-72fe79cf1479', 1, 1, NULL, 16, 1, NULL, 0.00, NULL, '2025-04-05 08:11:07', '2025-04-05 08:11:31'),
('53737bb7-055e-47f3-83ac-b060f21ab14c', 'e0a5ac3f-baab-4380-a457-a333e1e35d64', 1, 1, NULL, 16, 2, NULL, 0.00, NULL, '2025-04-02 10:58:56', '2025-04-02 11:05:41'),
('53b2a980-e0b2-4961-ae8e-f22e7956f111', '20e884e6-aecd-4f52-9002-65f03c279fad', 0, NULL, NULL, 15, 1, NULL, 10.00, NULL, '2025-05-28 14:20:07', '2025-05-28 14:21:14'),
('5b77d386-80eb-4146-993c-6214382eb6bd', 'a1af3cac-d45b-49af-a76c-e31c1a5a135f', 1, 1, NULL, 16, 3, 90.00, 0.00, NULL, '2025-02-09 07:53:08', '2025-02-09 07:53:31'),
('70e161d0-a4e9-4c41-aac9-914d22174489', '20e884e6-aecd-4f52-9002-65f03c279fad', 1, NULL, NULL, 16, 1, NULL, 10.00, NULL, '2025-05-27 11:01:00', '2025-05-28 12:09:07'),
('82345d2b-1423-4ec2-8452-9f80e3c5171a', '70fb602e-9ec9-41f0-b51c-d0ab9689af23', 1, 1, NULL, 16, 2, NULL, 0.00, NULL, '2025-03-30 09:45:05', '2025-03-30 09:45:51'),
('83010ad1-9d9b-4ab9-bbd8-cb68df7f1806', '18980867-7cad-401f-9d65-139f617fed32', 1, 1, NULL, 16, 2, NULL, 0.00, NULL, '2025-03-30 09:00:30', '2025-03-30 09:01:37'),
('983a7160-b7ee-4834-96ea-8b9d031be221', '60690d3f-3146-4a60-bcd4-61c04c1b98d9', 0, NULL, NULL, 16, 1, NULL, 10.00, NULL, '2025-05-27 10:57:34', '2025-05-27 10:59:06'),
('9b2e95cb-81d8-4235-9df7-b22b730d7ca4', '6f784e5c-f880-4452-9e2f-1fa9d72a30a6', 1, 1, NULL, 16, 3, NULL, 0.00, NULL, '2025-03-29 12:53:07', '2025-03-29 13:01:42'),
('b6e7151f-9039-4d37-be51-1cfb253fee77', 'de31d1fd-819a-47c8-852a-eecf9e4ae4d5', 1, 1, NULL, 16, 3, NULL, 0.00, NULL, '2025-03-29 13:21:47', '2025-03-29 13:47:36'),
('d711dd38-707d-48d0-a253-07fcb2058559', '6d4ea3d5-ef0d-4ac5-b7e9-72fe79cf1479', 1, 1, NULL, 14, 1, NULL, 0.00, NULL, '2025-04-05 08:10:52', '2025-04-05 08:11:31'),
('d9b5f401-3a0f-47ce-b334-9bbb53a34a9b', '6d4ea3d5-ef0d-4ac5-b7e9-72fe79cf1479', 1, 1, NULL, 15, 1, NULL, 0.00, NULL, '2025-04-05 08:11:02', '2025-04-05 08:11:31'),
('f1d644a1-3725-4069-ad85-a6eb336ebbe7', '20e884e6-aecd-4f52-9002-65f03c279fad', 1, NULL, NULL, 15, 1, NULL, 10.00, NULL, '2025-05-28 10:38:06', '2025-05-28 12:09:07'),
('f6e2f29e-00e9-4f74-b745-0796874e6574', '20e884e6-aecd-4f52-9002-65f03c279fad', 1, NULL, NULL, 15, 1, NULL, 10.00, NULL, '2025-05-28 12:07:56', '2025-05-28 12:09:07'),
('fd51fb7a-f9ea-4413-a730-b94b2d2fce2e', '2e3f2d87-45b2-4192-bf57-086a7a68db31', 1, 1, NULL, 16, 3, NULL, 0.00, NULL, '2025-02-09 07:29:49', '2025-02-09 07:32:48');

-- --------------------------------------------------------

--
-- Table structure for table `cart_item_choices`
--

CREATE TABLE `cart_item_choices` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `cart_id` bigint(20) UNSIGNED NOT NULL,
  `choice_id` bigint(20) UNSIGNED NOT NULL,
  `sub_choice_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `category_choices`
--

CREATE TABLE `category_choices` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `choice_id` bigint(20) UNSIGNED NOT NULL,
  `main_category_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `choices`
--

CREATE TABLE `choices` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `parent_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `choices`
--

INSERT INTO `choices` (`id`, `parent_id`, `name`, `created_at`, `updated_at`) VALUES
(1, NULL, 'التقطيع', '2024-11-20 15:16:19', '2025-03-29 09:22:02'),
(2, 1, 'تقيطيع 1', '2024-11-20 16:09:21', '2025-03-29 09:22:32'),
(3, 1, 'تقطيع 2', '2025-03-29 09:22:53', '2025-03-29 09:22:53'),
(4, 1, 'تقطيع 3', '2025-03-29 09:23:08', '2025-03-29 09:23:08'),
(5, NULL, 'التغليف', '2025-03-29 09:23:36', '2025-03-29 09:23:36'),
(6, 5, 'تغليف 1', '2025-03-29 09:23:53', '2025-03-29 09:23:53'),
(7, 5, 'تغليف 2', '2025-03-29 09:24:08', '2025-03-29 09:24:08');

-- --------------------------------------------------------

--
-- Table structure for table `choices_products`
--

CREATE TABLE `choices_products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `choice_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `choices_products`
--

INSERT INTO `choices_products` (`id`, `choice_id`, `product_id`) VALUES
(21, 5, 15),
(22, 5, 16),
(26, 1, 24),
(28, 5, 24);

-- --------------------------------------------------------

--
-- Table structure for table `cities`
--

CREATE TABLE `cities` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name_ar` varchar(255) NOT NULL,
  `name_en` varchar(255) NOT NULL,
  `code` varchar(255) NOT NULL,
  `status` enum('used','not_used') NOT NULL DEFAULT 'not_used',
  `shipping_price` decimal(8,2) DEFAULT NULL,
  `country_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cities`
--

INSERT INTO `cities` (`id`, `name_ar`, `name_en`, `code`, `status`, `shipping_price`, `country_id`) VALUES
(1, 'سانت جوليا دي لوريا', 'Sant Julia de Loria', '06', 'not_used', NULL, 1),
(2, 'أندورا لا فيلا', 'Andorra la Vella', '07', 'not_used', NULL, 1),
(3, 'لا ماسانا', 'La Massana', '04', 'not_used', NULL, 1),
(4, 'أوردينو', 'Ordino', '05', 'not_used', NULL, 1),
(5, 'كانيلو', 'Canillo', '02', 'not_used', NULL, 1),
(6, 'نزلوا', 'Encamp', '03', 'not_used', NULL, 1),
(7, 'إسكالديس أنجوردني', 'Escaldes-Engordany', '08', 'not_used', NULL, 1),
(8, 'الفجيرة', 'Fujairah', '04', 'not_used', NULL, 2),
(9, 'أبو ظبي', 'Abu Dhabi', '01', 'not_used', NULL, 2),
(10, 'دبي', 'Dubai', '03', 'not_used', NULL, 2),
(11, 'رأس الخيمة', 'Ras Al Khaimah', '05', 'not_used', NULL, 2),
(12, 'ام القيوين', 'Umm Al Quwain', '07', 'not_used', NULL, 2),
(13, 'الشارقة', 'Sharjah', '06', 'not_used', NULL, 2),
(14, 'عجمان', 'Ajman', '02', 'not_used', NULL, 2),
(15, 'بكتيكا', 'Paktika', '29', 'not_used', NULL, 3),
(16, 'فرح', 'Farah', '06', 'not_used', NULL, 3),
(17, 'هلمند', 'Helmand', '10', 'not_used', NULL, 3),
(18, 'قندز', 'Kondoz', '24', 'not_used', NULL, 3),
(19, 'باميان', 'Bamian', '05', 'not_used', NULL, 3),
(20, 'غور', 'Ghowr', '09', 'not_used', NULL, 3),
(21, 'لغمان', 'Laghman', '35', 'not_used', NULL, 3),
(23, 'غزنة', 'Ghazni', '08', 'not_used', NULL, 3),
(24, 'ورداك', 'Vardak', '27', 'not_used', NULL, 3),
(25, 'أوروزغان', 'Oruzgan', '39', 'not_used', NULL, 3),
(26, 'زابول', 'Zabol', '28', 'not_used', NULL, 3),
(27, 'بادغيس', 'Badghis', '02', 'not_used', NULL, 3),
(28, 'بدخشان', 'Badakhshan', '01', 'not_used', NULL, 3),
(29, 'فارياب', 'Faryab', '07', 'not_used', NULL, 3),
(30, 'تخار', 'Takhar', '26', 'not_used', NULL, 3),
(31, 'لوجار', 'Lowgar', '17', 'not_used', NULL, 3),
(32, 'هرات', 'Herat', '11', 'not_used', NULL, 3),
(33, 'دايكندي', 'Daykondi', '41', 'not_used', NULL, 3),
(34, 'سار بول', 'Sar-e Pol', '33', 'not_used', NULL, 3),
(35, 'بلخ', 'Balkh', '30', 'not_used', NULL, 3),
(36, 'كابول', 'Kabol', '13', 'not_used', NULL, 3),
(37, 'نيمروز', 'Nimruz', '19', 'not_used', NULL, 3),
(38, 'قندهار', 'Kandahar', '23', 'not_used', NULL, 3),
(39, 'خوست', 'Khowst', '37', 'not_used', NULL, 3),
(41, 'كابيسا', 'Kapisa', '14', 'not_used', NULL, 3),
(42, 'ننجرهار', 'Nangarhar', '18', 'not_used', NULL, 3),
(43, 'سامانغان', 'Samangan', '32', 'not_used', NULL, 3),
(44, 'بكتيا', 'Paktia', '36', 'not_used', NULL, 3),
(45, 'بغلان', 'Baghlan', '03', 'not_used', NULL, 3),
(46, 'جوزجان', 'Jowzjan', '31', 'not_used', NULL, 3),
(47, 'كونار', 'Konar', '34', 'not_used', NULL, 3),
(48, 'نورستان', 'Nurestan', '38', 'not_used', NULL, 3),
(52, 'بانجشير', 'Panjshir', '42', 'not_used', NULL, 3),
(53, 'القديس يوحنا', 'Saint John', '04', 'not_used', NULL, 4),
(54, 'القديس بول', 'Saint Paul', '06', 'not_used', NULL, 4),
(55, 'القديس جورج', 'Saint George', '03', 'not_used', NULL, 4),
(56, 'القديس بطرس', 'Saint Peter', '07', 'not_used', NULL, 4),
(57, 'القديس ماري', 'Saint Mary', '05', 'not_used', NULL, 4),
(58, 'باربودا', 'Barbuda', '01', 'not_used', NULL, 4),
(59, 'سانت فيليب', 'Saint Philip', '08', 'not_used', NULL, 4),
(61, 'فلور', 'Vlore', '51', 'not_used', NULL, 6),
(62, 'كورتشي', 'Korce', '46', 'not_used', NULL, 6),
(63, 'شكودر', 'Shkoder', '49', 'not_used', NULL, 6),
(64, 'دوريس', 'Durres', '42', 'not_used', NULL, 6),
(65, 'الباسان', 'Elbasan', '43', 'not_used', NULL, 6),
(66, 'كوكس', 'Kukes', '47', 'not_used', NULL, 6),
(67, 'فيير', 'Fier', '44', 'not_used', NULL, 6),
(68, 'بيرات', 'Berat', '40', 'not_used', NULL, 6),
(69, 'جيروكاستر', 'Gjirokaster', '45', 'not_used', NULL, 6),
(70, 'تيرانا', 'Tirane', '50', 'not_used', NULL, 6),
(71, 'ليج', 'Lezhe', '48', 'not_used', NULL, 6),
(72, 'ديبر', 'Diber', '41', 'not_used', NULL, 6),
(73, 'Aragatsotn', 'Aragatsotn', '01', 'not_used', NULL, 7),
(74, 'أرارات', 'Ararat', '02', 'not_used', NULL, 7),
(75, 'كوتايك', 'Kotayk\'', '05', 'not_used', NULL, 7),
(76, 'تافوش', 'Tavush', '09', 'not_used', NULL, 7),
(77, 'سيونيك', 'Syunik\'', '08', 'not_used', NULL, 7),
(78, 'Geghark\'unik \"', 'Geghark\'unik\'', '04', 'not_used', NULL, 7),
(79, 'دزوتس دازور', 'Vayots\' Dzor', '10', 'not_used', NULL, 7),
(80, 'Lorri', 'Lorri', '06', 'not_used', NULL, 7),
(81, 'أرمافير', 'Armavir', '03', 'not_used', NULL, 7),
(82, 'يريفان', 'Yerevan', '11', 'not_used', NULL, 7),
(83, 'شيراك', 'Shirak', '07', 'not_used', NULL, 7),
(85, 'بنغيلا', 'Benguela', '01', 'not_used', NULL, 9),
(86, 'يجي', 'Uige', '15', 'not_used', NULL, 9),
(87, 'بنغو', 'Bengo', '19', 'not_used', NULL, 9),
(88, 'كوانزا نورتي', 'Cuanza Norte', '05', 'not_used', NULL, 9),
(89, 'مالانج', 'Malanje', '12', 'not_used', NULL, 9),
(90, 'كوانزا سول', 'Cuanza Sul', '06', 'not_used', NULL, 9),
(91, 'هوامبو', 'Huambo', '08', 'not_used', NULL, 9),
(92, 'موكسيكو', 'Moxico', '14', 'not_used', NULL, 9),
(93, 'كواندو كوبانجو', 'Cuando Cubango', '04', 'not_used', NULL, 9),
(94, 'بيي', 'Bie', '02', 'not_used', NULL, 9),
(95, 'هويلا', 'Huila', '09', 'not_used', NULL, 9),
(96, 'لوندا سول', 'Lunda Sul', '18', 'not_used', NULL, 9),
(98, 'زائير', 'Zaire', '16', 'not_used', NULL, 9),
(99, 'كونين', 'Cunene', '07', 'not_used', NULL, 9),
(100, 'لوندا نورتي', 'Lunda Norte', '17', 'not_used', NULL, 9),
(101, 'ناميبي', 'Namibe', '13', 'not_used', NULL, 9),
(102, 'كابيندا', 'Cabinda', '03', 'not_used', NULL, 9),
(103, 'بوينس آيرس', 'Buenos Aires', '01', 'not_used', NULL, 10),
(104, 'قرطبة', 'Cordoba', '05', 'not_used', NULL, 10),
(105, 'انتري ريوس', 'Entre Rios', '08', 'not_used', NULL, 10),
(106, 'سالتا', 'Salta', '17', 'not_used', NULL, 10),
(107, 'خوخوي', 'Jujuy', '10', 'not_used', NULL, 10),
(108, 'لا بامبا', 'La Pampa', '11', 'not_used', NULL, 10),
(109, 'مندوزا', 'Mendoza', '13', 'not_used', NULL, 10),
(110, 'ميسيونيس', 'Misiones', '14', 'not_used', NULL, 10),
(111, 'سانتا كروز', 'Santa Cruz', '20', 'not_used', NULL, 10),
(112, 'سانتا في', 'Santa Fe', '21', 'not_used', NULL, 10),
(113, 'توكومان', 'Tucuman', '24', 'not_used', NULL, 10),
(114, 'كورينتس', 'Corrientes', '06', 'not_used', NULL, 10),
(115, 'سان خوان', 'San Juan', '18', 'not_used', NULL, 10),
(116, 'سانتياغو ديل إستيرو', 'Santiago del Estero', '22', 'not_used', NULL, 10),
(117, 'كاتاماركا', 'Catamarca', '02', 'not_used', NULL, 10),
(118, 'نيوكوين', 'Neuquen', '15', 'not_used', NULL, 10),
(119, 'وفي مقاطعة الاتحادية', 'Distrito Federal', '07', 'not_used', NULL, 10),
(120, 'لا ريوخا', 'La Rioja', '12', 'not_used', NULL, 10),
(121, 'ريو نيغرو', 'Rio Negro', '16', 'not_used', NULL, 10),
(122, 'شوبوت', 'Chubut', '04', 'not_used', NULL, 10),
(123, 'سان لويس', 'San Luis', '19', 'not_used', NULL, 10),
(124, 'تييرا ديل فويغو', 'Tierra del Fuego', '23', 'not_used', NULL, 10),
(125, 'فورموزا', 'Formosa', '09', 'not_used', NULL, 10),
(126, 'شاكو', 'Chaco', '03', 'not_used', NULL, 10),
(127, 'Niederosterreich', 'Niederosterreich', '03', 'not_used', NULL, 11),
(128, 'سالزبورغ', 'Salzburg', '05', 'not_used', NULL, 11),
(129, 'Oberosterreich', 'Oberosterreich', '04', 'not_used', NULL, 11),
(130, 'تيرول', 'Tirol', '07', 'not_used', NULL, 11),
(131, 'كارنتين', 'Karnten', '02', 'not_used', NULL, 11),
(132, 'STEIERMARK', 'Steiermark', '06', 'not_used', NULL, 11),
(133, 'فورارلبرغ', 'Vorarlberg', '08', 'not_used', NULL, 11),
(134, 'فيينا', 'Wien', '09', 'not_used', NULL, 11),
(135, 'بورغنلاند', 'Burgenland', '01', 'not_used', NULL, 11),
(136, 'نيو ساوث ويلز', 'New South Wales', '02', 'not_used', NULL, 12),
(137, 'تسمانيا', 'Tasmania', '06', 'not_used', NULL, 12),
(138, 'القسم الغربي من استراليا', 'Western Australia', '08', 'not_used', NULL, 12),
(139, 'كوينزلاند', 'Queensland', '04', 'not_used', NULL, 12),
(140, 'فيكتوريا', 'Victoria', '07', 'not_used', NULL, 12),
(141, 'جنوب استراليا', 'South Australia', '05', 'not_used', NULL, 12),
(142, 'الإقليم الشمالي', 'Northern Territory', '03', 'not_used', NULL, 12),
(143, 'إقليم العاصمة الأسترالية', 'Australian Capital Territory', '01', 'not_used', NULL, 12),
(146, 'نيفتكالا', 'Neftcala', '36', 'not_used', NULL, 14),
(147, 'زانلار', 'Xanlar', '62', 'not_used', NULL, 14),
(148, 'يفلاكس', 'Yevlax', '68', 'not_used', NULL, 14),
(149, 'أجداس', 'Agdas', '04', 'not_used', NULL, 14),
(150, 'سابيراباد', 'Sabirabad', '46', 'not_used', NULL, 14),
(151, 'يارديملي', 'Yardimli', '66', 'not_used', NULL, 14),
(152, 'Calilabad', 'Calilabad', '15', 'not_used', NULL, 14),
(153, 'ساتلي', 'Saatli', '45', 'not_used', NULL, 14),
(154, 'الساقي', 'Saki', '47', 'not_used', NULL, 14),
(155, 'كوردامير', 'Kurdamir', '27', 'not_used', NULL, 14),
(156, 'كازاكس', 'Qazax', '40', 'not_used', NULL, 14),
(157, 'توفوز', 'Tovuz', '58', 'not_used', NULL, 14),
(158, 'سامكير', 'Samkir', '51', 'not_used', NULL, 14),
(159, 'أغدام', 'Agdam', '03', 'not_used', NULL, 14),
(160, 'كوبادلي', 'Qubadli', '43', 'not_used', NULL, 14),
(161, 'أوغوز', 'Oguz', '37', 'not_used', NULL, 14),
(162, 'لاكين', 'Lacin', '28', 'not_used', NULL, 14),
(163, 'كالباكار', 'Kalbacar', '26', 'not_used', NULL, 14),
(164, 'Haciqabul', 'Haciqabul', '23', 'not_used', NULL, 14),
(165, 'بيلاسوفار', 'Bilasuvar', '13', 'not_used', NULL, 14),
(166, 'بالاكان', 'Balakan', '10', 'not_used', NULL, 14),
(167, 'ناخيتشيفان', 'Naxcivan', '35', 'not_used', NULL, 14),
(168, 'قابالا', 'Qabala', '38', 'not_used', NULL, 14),
(169, 'أجكابادي', 'Agcabadi', '02', 'not_used', NULL, 14),
(170, 'ساماكسي', 'Samaxi', '50', 'not_used', NULL, 14),
(171, 'دافاسي', 'Davaci', '17', 'not_used', NULL, 14),
(172, 'قباء', 'Quba', '42', 'not_used', NULL, 14),
(173, 'كوسار', 'Qusar', '44', 'not_used', NULL, 14),
(174, 'إيميسلي', 'Imisli', '24', 'not_used', NULL, 14),
(175, 'أبسيرون', 'Abseron', '01', 'not_used', NULL, 14),
(176, 'زاكماز', 'Xacmaz', '60', 'not_used', NULL, 14),
(177, 'كابرايل', 'Cabrayil', '14', 'not_used', NULL, 14),
(178, 'إيسمييلي', 'Ismayilli', '25', 'not_used', NULL, 14),
(179, 'غورانبوي', 'Goranboy', '21', 'not_used', NULL, 14),
(180, 'فضولي', 'Fuzuli', '18', 'not_used', NULL, 14),
(181, 'باكي', 'Baki', '09', 'not_used', NULL, 14),
(182, 'بيلاكان', 'Beylaqan', '12', 'not_used', NULL, 14),
(183, 'داسكاسان', 'Daskasan', '16', 'not_used', NULL, 14),
(184, 'ماسالي', 'Masalli', '32', 'not_used', NULL, 14),
(185, 'زاكاتالا', 'Zaqatala', '70', 'not_used', NULL, 14),
(186, 'نكران', 'Lankaran', '29', 'not_used', NULL, 14),
(187, 'ليريك', 'Lerik', '31', 'not_used', NULL, 14),
(188, 'علي بيرملي', 'Ali Bayramli', '07', 'not_used', NULL, 14),
(189, 'QAX', 'Qax', '39', 'not_used', NULL, 14),
(190, 'ساموكس', 'Samux', '52', 'not_used', NULL, 14),
(191, 'زارداب', 'Zardab', '71', 'not_used', NULL, 14),
(192, 'جاداباي', 'Gadabay', '19', 'not_used', NULL, 14),
(193, 'أوكار', 'Ucar', '59', 'not_used', NULL, 14),
(194, 'بردا', 'Barda', '11', 'not_used', NULL, 14),
(195, 'سيازان', 'Siyazan', '53', 'not_used', NULL, 14),
(196, 'كسوكافاند', 'Xocavand', '65', 'not_used', NULL, 14),
(197, 'زانجيلان', 'Zangilan', '69', 'not_used', NULL, 14),
(198, 'XIZI', 'Xizi', '63', 'not_used', NULL, 14),
(199, 'يفلاكس', 'Yevlax', '67', 'not_used', NULL, 14),
(200, 'AGSU', 'Agsu', '06', 'not_used', NULL, 14),
(201, 'كوبستان', 'Qobustan', '41', 'not_used', NULL, 14),
(202, 'جويكاي', 'Goycay', '22', 'not_used', NULL, 14),
(203, 'أستارا', 'Astara', '08', 'not_used', NULL, 14),
(204, 'كسوكالي', 'Xocali', '64', 'not_used', NULL, 14),
(205, 'زانكاندي', 'Xankandi', '61', 'not_used', NULL, 14),
(206, 'رواسب', 'Tartar', '57', 'not_used', NULL, 14),
(207, 'أجستافا', 'Agstafa', '05', 'not_used', NULL, 14),
(208, 'ساليان', 'Salyan', '49', 'not_used', NULL, 14),
(209, 'سوسة', 'Susa', '55', 'not_used', NULL, 14),
(210, 'غانكا', 'Ganca', '20', 'not_used', NULL, 14),
(211, 'سامكيت', 'Sumqayit', '54', 'not_used', NULL, 14),
(212, 'الساقي', 'Saki', '48', 'not_used', NULL, 14),
(213, 'نفتالان', 'Naftalan', '34', 'not_used', NULL, 14),
(214, 'نكران', 'Lankaran', '30', 'not_used', NULL, 14),
(215, 'مينغاشفير', 'Mingacevir', '33', 'not_used', NULL, 14),
(216, 'سوسة', 'Susa', '56', 'not_used', NULL, 14),
(217, 'جمهورية صربسكا', 'Republika Srpska', '02', 'not_used', NULL, 15),
(218, 'اتحاد البوسنة والهرسك', 'Federation of Bosnia and Herzegovina', '01', 'not_used', NULL, 15),
(220, 'القديس يوسف', 'Saint Joseph', '06', 'not_used', NULL, 16),
(221, 'سانت لوسي', 'Saint Lucy', '07', 'not_used', NULL, 16),
(222, 'سانت توماس', 'Saint Thomas', '11', 'not_used', NULL, 16),
(223, 'جيمس قديس', 'Saint James', '04', 'not_used', NULL, 16),
(224, 'القديس يوحنا', 'Saint John', '05', 'not_used', NULL, 16),
(225, 'القديس بطرس', 'Saint Peter', '09', 'not_used', NULL, 16),
(226, 'كنيسة المسيح', 'Christ Church', '01', 'not_used', NULL, 16),
(227, 'القديس جورج', 'Saint George', '03', 'not_used', NULL, 16),
(228, 'القديس مايكل', 'Saint Michael', '08', 'not_used', NULL, 16),
(229, 'القديس أندرو', 'Saint Andrew', '02', 'not_used', NULL, 16),
(230, 'سانت فيليب', 'Saint Philip', '10', 'not_used', NULL, 16),
(231, 'خولنا', 'Khulna', '82', 'not_used', NULL, 17),
(232, 'راجشاهي', 'Rajshahi', '83', 'not_used', NULL, 17),
(233, 'دكا', 'Dhaka', '81', 'not_used', NULL, 17),
(235, 'باريسال', 'Barisal', '85', 'not_used', NULL, 17),
(236, 'سيلهيت', 'Sylhet', '86', 'not_used', NULL, 17),
(237, 'شيتاغونغ', 'Chittagong', '84', 'not_used', NULL, 17),
(238, 'فلاندر الشرقية', 'Oost-Vlaanderen', '08', 'not_used', NULL, 18),
(239, 'فلاندر الغربية', 'West-Vlaanderen', '09', 'not_used', NULL, 18),
(241, 'ليمبورغ', 'Limburg', '05', 'not_used', NULL, 18),
(242, 'أنتويرب', 'Antwerpen', '01', 'not_used', NULL, 18),
(243, 'لوكسمبورغ', 'Luxembourg', '06', 'not_used', NULL, 18),
(244, 'ليمبورغ', 'Hainaut', '03', 'not_used', NULL, 18),
(245, 'مرتبط ب', 'Liege', '04', 'not_used', NULL, 18),
(246, 'نامور', 'Namur', '07', 'not_used', NULL, 18),
(247, 'بروكسل Hoofdstedelijk Gewest', 'Brussels Hoofdstedelijk Gewest', '11', 'not_used', NULL, 18),
(248, 'فلامس برابانت', 'Vlaams-Brabant', '12', 'not_used', NULL, 18),
(249, 'برابانت الوالون', 'Brabant Wallon', '10', 'not_used', NULL, 18),
(251, 'موهون', 'Mouhoun', '63', 'not_used', NULL, 19),
(252, 'بام', 'Bam', '15', 'not_used', NULL, 19),
(257, 'تابوا', 'Tapoa', '42', 'not_used', NULL, 19),
(258, 'سوم', 'Soum', '40', 'not_used', NULL, 19),
(259, 'يرابا', 'Leraba', '61', 'not_used', NULL, 19),
(260, 'نومبيل', 'Noumbiel', '67', 'not_used', NULL, 19),
(262, 'جناجنا', 'Gnagna', '21', 'not_used', NULL, 19),
(265, 'ياتينجا', 'Yatenga', '76', 'not_used', NULL, 19),
(266, 'بانوا', 'Banwa', '46', 'not_used', NULL, 19),
(267, 'بوني', 'Poni', '69', 'not_used', NULL, 19),
(268, 'وروم', 'Loroum', '62', 'not_used', NULL, 19),
(269, 'كوريتنجا', 'Kouritenga', '28', 'not_used', NULL, 19),
(270, 'توي', 'Tuy', '74', 'not_used', NULL, 19),
(271, 'كوسي', 'Kossi', '58', 'not_used', NULL, 19),
(272, 'باسور', 'Passore', '34', 'not_used', NULL, 19),
(273, 'كيندوجو', 'Kenedougou', '54', 'not_used', NULL, 19),
(274, 'بالة', 'Bale', '45', 'not_used', NULL, 19),
(275, 'بوغوريبا', 'Bougouriba', '48', 'not_used', NULL, 19),
(276, 'هويت', 'Houet', '51', 'not_used', NULL, 19),
(277, 'جورما', 'Gourma', '50', 'not_used', NULL, 19),
(278, 'نامنتنجا', 'Namentenga', '64', 'not_used', NULL, 19),
(279, 'سانماتينغا', 'Sanmatenga', '70', 'not_used', NULL, 19),
(281, 'إيوبا', 'Ioba', '52', 'not_used', NULL, 19),
(282, 'غانزورغو', 'Ganzourgou', '20', 'not_used', NULL, 19),
(283, 'الناعوري', 'Naouri', '65', 'not_used', NULL, 19),
(284, 'بولكيمد', 'Boulkiemde', '19', 'not_used', NULL, 19),
(285, 'زوندويجو', 'Zoundweogo', '44', 'not_used', NULL, 19),
(286, 'زوندوما', 'Zondoma', '78', 'not_used', NULL, 19),
(289, 'Komoe', 'Komoe', '55', 'not_used', NULL, 19),
(290, 'ياغا', 'Yagha', '75', 'not_used', NULL, 19),
(291, 'كوموندجاري', 'Komondjari', '56', 'not_used', NULL, 19),
(292, 'سورو', 'Sourou', '73', 'not_used', NULL, 19),
(293, 'نايالا', 'Nayala', '66', 'not_used', NULL, 19),
(294, 'سيسيلي', 'Sissili', '72', 'not_used', NULL, 19),
(295, 'سانجوي', 'Sanguie', '36', 'not_used', NULL, 19),
(296, 'أودالان', 'Oudalan', '33', 'not_used', NULL, 19),
(297, 'كولبيلوجو', 'Koulpelogo', '59', 'not_used', NULL, 19),
(298, 'زيرو', 'Ziro', '77', 'not_used', NULL, 19),
(299, 'كورويجو', 'Kourweogo', '60', 'not_used', NULL, 19),
(300, 'أوبريتنغا', 'Oubritenga', '68', 'not_used', NULL, 19),
(301, 'سينو', 'Seno', '71', 'not_used', NULL, 19),
(302, 'بازيجا', 'Bazega', '47', 'not_used', NULL, 19),
(303, 'كاديوغو', 'Kadiogo', '53', 'not_used', NULL, 19),
(304, 'كومبينغا', 'Kompienga', '57', 'not_used', NULL, 19),
(305, 'بولغو', 'Boulgou', '49', 'not_used', NULL, 19),
(306, 'لوفيتش', 'Lovech', '46', 'not_used', NULL, 20),
(307, 'فارنا', 'Varna', '61', 'not_used', NULL, 20),
(308, 'بورغاس', 'Burgas', '39', 'not_used', NULL, 20),
(309, 'رازغراد', 'Razgrad', '52', 'not_used', NULL, 20),
(310, 'بلوفديف', 'Plovdiv', '51', 'not_used', NULL, 20),
(311, 'Khaskovo', 'Khaskovo', '43', 'not_used', NULL, 20),
(312, 'SOFIYA', 'Sofiya', '58', 'not_used', NULL, 20),
(313, 'سيليسترا', 'Silistra', '55', 'not_used', NULL, 20),
(314, 'فيدين', 'Vidin', '63', 'not_used', NULL, 20),
(315, 'مونتانا', 'Montana', '47', 'not_used', NULL, 20),
(316, 'Mikhaylovgrad', 'Mikhaylovgrad', '33', 'not_used', NULL, 20),
(317, 'جراد صوفيا', 'Grad Sofiya', '42', 'not_used', NULL, 20),
(318, 'تارغوفيشته', 'Turgovishte', '60', 'not_used', NULL, 20),
(319, 'Kurdzhali', 'Kurdzhali', '44', 'not_used', NULL, 20),
(320, 'دوبريتش', 'Dobrich', '40', 'not_used', NULL, 20),
(321, 'شومين', 'Shumen', '54', 'not_used', NULL, 20),
(322, 'بلاغويفغارد', 'Blagoevgrad', '38', 'not_used', NULL, 20),
(323, 'سموليان', 'Smolyan', '57', 'not_used', NULL, 20),
(324, 'ستارا زاغورا', 'Stara Zagora', '59', 'not_used', NULL, 20),
(325, 'بازارجيك', 'Pazardzhik', '48', 'not_used', NULL, 20),
(326, 'حيلة', 'Ruse', '53', 'not_used', NULL, 20),
(327, 'فراتسا', 'Vratsa', '64', 'not_used', NULL, 20),
(328, 'بليفين', 'Pleven', '50', 'not_used', NULL, 20),
(329, 'برنيك', 'Pernik', '49', 'not_used', NULL, 20),
(330, 'كيوستينديل', 'Kyustendil', '45', 'not_used', NULL, 20),
(331, 'يامبول', 'Yambol', '65', 'not_used', NULL, 20),
(332, 'غابروفو', 'Gabrovo', '41', 'not_used', NULL, 20),
(333, 'سليفن', 'Sliven', '56', 'not_used', NULL, 20),
(334, 'فيليكو ترنوفو', 'Veliko Turnovo', '62', 'not_used', NULL, 20),
(335, 'جد حفص', 'Jidd Hafs', '05', 'not_used', NULL, 21),
(337, 'المنطقة الشمالية', 'Al Mintaqah ash Shamaliyah', '10', 'not_used', NULL, 21),
(339, 'المنامة', 'Al Manamah', '02', 'not_used', NULL, 21),
(340, 'سترة', 'Sitrah', '06', 'not_used', NULL, 21),
(341, 'المنطقة الغربية', 'Al Mintaqah al Gharbiyah', '08', 'not_used', NULL, 21),
(342, 'ولاية جزرور حوار', 'Mintaqat Juzur Hawar', '09', 'not_used', NULL, 21),
(343, 'الحد', 'Al Hadd', '01', 'not_used', NULL, 21),
(344, 'المنطقة الوسطى', 'Al Mintaqah al Wusta', '11', 'not_used', NULL, 21),
(345, 'الرفاع', 'Ar Rifa', '13', 'not_used', NULL, 21),
(346, 'مدينة', 'Madinat', '12', 'not_used', NULL, 21),
(347, 'كاروزي', 'Karuzi', '14', 'not_used', NULL, 22),
(348, 'رويجي', 'Ruyigi', '21', 'not_used', NULL, 22),
(349, 'بوبانزا', 'Bubanza', '09', 'not_used', NULL, 22),
(350, 'بوروري', 'Bururi', '10', 'not_used', NULL, 22),
(351, 'ماكامبا', 'Makamba', '17', 'not_used', NULL, 22),
(352, 'كاينزا', 'Kayanza', '15', 'not_used', NULL, 22),
(354, 'روتانا', 'Rutana', '20', 'not_used', NULL, 22),
(355, 'مويينغا', 'Muyinga', '18', 'not_used', NULL, 22),
(356, 'سيبيتوكييه', 'Cibitoke', '12', 'not_used', NULL, 22),
(357, 'غيتيغا', 'Gitega', '13', 'not_used', NULL, 22),
(358, 'كانكوزا', 'Cankuzo', '11', 'not_used', NULL, 22),
(359, 'بوجمبورا', 'Bujumbura', '02', 'not_used', NULL, 22),
(360, 'نغوزي', 'Ngozi', '19', 'not_used', NULL, 22),
(361, 'كيروندو', 'Kirundo', '16', 'not_used', NULL, 22),
(362, 'هضبة', 'Plateau', '17', 'not_used', NULL, 23),
(363, 'التلال', 'Collines', '11', 'not_used', NULL, 23),
(366, 'أويمي', 'Oueme', '16', 'not_used', NULL, 23),
(367, 'زو', 'Zou', '18', 'not_used', NULL, 23),
(370, 'Atlanyique', 'Atlanyique', '09', 'not_used', NULL, 23),
(371, 'بورغو', 'Borgou', '10', 'not_used', NULL, 23),
(372, 'مونو', 'Mono', '15', 'not_used', NULL, 23),
(374, 'كوفو', 'Kouffo', '12', 'not_used', NULL, 23),
(375, 'دونجا', 'Donga', '13', 'not_used', NULL, 23),
(376, 'ساحلي', 'Littoral', '14', 'not_used', NULL, 23),
(377, 'أليبوري', 'Alibori', '07', 'not_used', NULL, 23),
(378, 'أتاكورا', 'Atakora', '08', 'not_used', NULL, 23),
(379, 'ديفونشاير', 'Devonshire', '01', 'not_used', NULL, 24),
(380, 'باجيت', 'Paget', '04', 'not_used', NULL, 24),
(381, 'سانت جورج', 'Saint George\'s', '07', 'not_used', NULL, 24),
(382, 'الحدادون', 'Smiths', '09', 'not_used', NULL, 24),
(383, 'هاميلتون', 'Hamilton', '03', 'not_used', NULL, 24),
(384, 'وارويك', 'Warwick', '11', 'not_used', NULL, 24),
(385, 'سانديز', 'Sandys', '08', 'not_used', NULL, 24),
(386, 'القديس جورج', 'Saint George', '06', 'not_used', NULL, 24),
(387, 'هاميلتون', 'Hamilton', '02', 'not_used', NULL, 24),
(389, 'سانتا كروز', 'Santa Cruz', '08', 'not_used', NULL, 26),
(390, 'باندو', 'Pando', '06', 'not_used', NULL, 26),
(391, 'تاريخا', 'Tarija', '09', 'not_used', NULL, 26),
(392, 'لاباز', 'La Paz', '04', 'not_used', NULL, 26),
(393, 'أورورو', 'Oruro', '05', 'not_used', NULL, 26),
(394, 'كوتشابامبا', 'Cochabamba', '02', 'not_used', NULL, 26),
(395, 'بوتوسي', 'Potosi', '07', 'not_used', NULL, 26),
(396, 'شوكيساكا', 'Chuquisaca', '01', 'not_used', NULL, 26),
(397, 'البنى', 'El Beni', '03', 'not_used', NULL, 26),
(398, 'سانتا كاتارينا', 'Santa Catarina', '26', 'not_used', NULL, 27),
(399, 'ماتو جروسو دو سول', 'Mato Grosso do Sul', '11', 'not_used', NULL, 27),
(400, 'ريو غراندي دو سول', 'Rio Grande do Sul', '23', 'not_used', NULL, 27),
(401, 'اسبيريتو سانتو', 'Espirito Santo', '08', 'not_used', NULL, 27),
(402, 'باهيا', 'Bahia', '05', 'not_used', NULL, 27),
(403, 'روندونيا', 'Rondonia', '24', 'not_used', NULL, 27),
(404, 'ميناس جيرايس', 'Minas Gerais', '15', 'not_used', NULL, 27),
(405, 'بارايبا', 'Paraiba', '17', 'not_used', NULL, 27),
(406, 'أمابا', 'Amapa', '03', 'not_used', NULL, 27),
(407, 'أمازوناس', 'Amazonas', '04', 'not_used', NULL, 27),
(408, 'الفقرة', 'Para', '16', 'not_used', NULL, 27),
(409, 'سيارا', 'Ceara', '06', 'not_used', NULL, 27),
(410, 'ريو دي جانيرو', 'Rio de Janeiro', '21', 'not_used', NULL, 27),
(411, 'غوياس', 'Goias', '29', 'not_used', NULL, 27),
(412, 'ساو باولو', 'Sao Paulo', '27', 'not_used', NULL, 27),
(413, 'بارانا', 'Parana', '18', 'not_used', NULL, 27),
(414, 'ريو غراندي دو نورتي', 'Rio Grande do Norte', '22', 'not_used', NULL, 27),
(415, 'فدان', 'Acre', '01', 'not_used', NULL, 27),
(416, 'بياوي', 'Piaui', '20', 'not_used', NULL, 27),
(417, 'بيرنامبوكو', 'Pernambuco', '30', 'not_used', NULL, 27),
(418, 'ماتو جروسو', 'Mato Grosso', '14', 'not_used', NULL, 27),
(419, 'مارانهاو', 'Maranhao', '13', 'not_used', NULL, 27),
(420, 'توكانتينز', 'Tocantins', '31', 'not_used', NULL, 27),
(421, 'رورايما', 'Roraima', '25', 'not_used', NULL, 27),
(422, 'ألاغواس', 'Alagoas', '02', 'not_used', NULL, 27),
(423, 'سيرغيبي', 'Sergipe', '28', 'not_used', NULL, 27),
(424, 'وفي مقاطعة الاتحادية', 'Distrito Federal', '07', 'not_used', NULL, 27),
(425, 'Acklins and Crooked Islands', 'Acklins and Crooked Islands', '24', 'not_used', NULL, 28),
(426, 'ماياجيوانا', 'Mayaguana', '16', 'not_used', NULL, 28),
(427, 'جزيرة طويلة', 'Long Island', '15', 'not_used', NULL, 28),
(428, 'بروفيدانس الجديدة', 'New Providence', '23', 'not_used', NULL, 28),
(429, 'اكسوما', 'Exuma', '10', 'not_used', NULL, 28),
(430, 'بيميني', 'Bimini', '05', 'not_used', NULL, 28),
(431, 'ميناء الحاكم', 'Governor\'s Harbour', '27', 'not_used', NULL, 28),
(432, 'سان سلفادور وروم كاي', 'San Salvador and Rum Cay', '35', 'not_used', NULL, 28),
(433, 'فريش كريك', 'Fresh Creek', '26', 'not_used', NULL, 28),
(434, 'جزيرة القط', 'Cat Island', '06', 'not_used', NULL, 28),
(435, 'Nichollstown و جزر بيري', 'Nichollstown and Berry Islands', '32', 'not_used', NULL, 28),
(436, 'كيمبس باي', 'Kemps Bay', '30', 'not_used', NULL, 28),
(437, 'ميناء حر', 'Freeport', '25', 'not_used', NULL, 28),
(438, 'صوت صخري', 'Rock Sound', '33', 'not_used', NULL, 28),
(439, 'جزيرة الميناء', 'Harbour Island', '22', 'not_used', NULL, 28),
(440, 'هاي روك', 'High Rock', '29', 'not_used', NULL, 28),
(441, 'جرين تيرتل كاي', 'Green Turtle Cay', '28', 'not_used', NULL, 28),
(442, 'مارش هاربر', 'Marsh Harbour', '31', 'not_used', NULL, 28),
(443, 'جزيرة راكد', 'Ragged Island', '18', 'not_used', NULL, 28),
(444, 'ساندي بوينت', 'Sandy Point', '34', 'not_used', NULL, 28),
(445, 'من Inagua', 'Inagua', '13', 'not_used', NULL, 28),
(446, 'وانجدي Phodrang', 'Wangdi Phodrang', '22', 'not_used', NULL, 29),
(447, 'بارو', 'Paro', '13', 'not_used', NULL, 29),
(448, 'داغا', 'Daga', '08', 'not_used', NULL, 29),
(449, 'مونغار', 'Mongar', '12', 'not_used', NULL, 29),
(450, 'Shemgang', 'Shemgang', '18', 'not_used', NULL, 29),
(451, 'تيمفو', 'Thimphu', '20', 'not_used', NULL, 29),
(452, 'Tashigang', 'Tashigang', '19', 'not_used', NULL, 29),
(453, 'شيرانغ', 'Chirang', '07', 'not_used', NULL, 29),
(454, 'Geylegphug', 'Geylegphug', '09', 'not_used', NULL, 29),
(455, 'سامدروب', 'Samdrup', '17', 'not_used', NULL, 29),
(456, 'بوم ثانج', 'Bumthang', '05', 'not_used', NULL, 29),
(457, 'Samchi', 'Samchi', '16', 'not_used', NULL, 29),
(458, 'Tongsa', 'Tongsa', '21', 'not_used', NULL, 29),
(459, 'جوخا', 'Chhukha', '06', 'not_used', NULL, 29),
(460, 'Pemagatsel', 'Pemagatsel', '14', 'not_used', NULL, 29),
(461, 'ها', 'Ha', '10', 'not_used', NULL, 29),
(462, 'بونخا', 'Punakha', '15', 'not_used', NULL, 29),
(463, 'Lhuntshi', 'Lhuntshi', '11', 'not_used', NULL, 29),
(464, 'وسط', 'Central', '01', 'not_used', NULL, 30),
(465, 'الجنوب الشرقي', 'South-East', '09', 'not_used', NULL, 30),
(466, 'شمال شرق', 'North-East', '08', 'not_used', NULL, 30),
(467, 'الشمال الغربي', 'North-West', '11', 'not_used', NULL, 30),
(468, 'غانزي', 'Ghanzi', '03', 'not_used', NULL, 30),
(469, 'كوينينج', 'Kweneng', '06', 'not_used', NULL, 30),
(470, 'كغالاغادي', 'Kgalagadi', '04', 'not_used', NULL, 30),
(472, 'جنوبي', 'Southern', '10', 'not_used', NULL, 30),
(473, 'كجاتلينج', 'Kgatleng', '05', 'not_used', NULL, 30),
(474, 'Homyel\'skaya Voblasts \"', 'Homyel\'skaya Voblasts\'', '02', 'not_used', NULL, 31),
(475, 'مينسك', 'Minsk', '04', 'not_used', NULL, 31),
(476, 'Brestskaya Voblasts \"', 'Brestskaya Voblasts\'', '01', 'not_used', NULL, 31),
(477, 'هيرودزينسكايا فوبلاست', 'Hrodzyenskaya Voblasts\'', '03', 'not_used', NULL, 31),
(478, 'Mahilyowskaya Voblasts \"', 'Mahilyowskaya Voblasts\'', '06', 'not_used', NULL, 31),
(479, 'Vitsyebskaya Voblasts \"', 'Vitsyebskaya Voblasts\'', '07', 'not_used', NULL, 31),
(480, 'توليدو', 'Toledo', '06', 'not_used', 500.00, 32),
(481, 'كايو', 'Cayo', '02', 'not_used', 11.00, 32),
(482, 'ستان كريك', 'Stann Creek', '05', 'not_used', 4545.00, 32),
(483, 'كوروزال', 'Corozal', '03', 'not_used', 545.00, 32),
(484, 'أورانج ووك', 'Orange Walk', '04', 'not_used', NULL, 32),
(485, 'بليز', 'Belize', '01', 'not_used', NULL, 32),
(500, 'خط الاستواء', 'Equateur', '02', 'not_used', NULL, 35),
(501, 'الشرقية', 'Orientale', '09', 'not_used', NULL, 35),
(503, 'شمال كيفو', 'Nord-Kivu', '11', 'not_used', NULL, 35),
(505, 'مانيما', 'Maniema', '10', 'not_used', NULL, 35),
(506, 'باندوندو', 'Bandundu', '01', 'not_used', NULL, 35),
(508, 'كاتانغا', 'Katanga', '05', 'not_used', NULL, 35),
(509, 'جنوب كيفو', 'Sud-Kivu', '12', 'not_used', NULL, 35),
(510, 'الكونغو السفلى', 'Bas-Congo', '08', 'not_used', NULL, 35),
(511, 'كاساي الشرقية', 'Kasai-Oriental', '04', 'not_used', NULL, 35),
(512, 'كينشاسا', 'Kinshasa', '06', 'not_used', NULL, 35),
(513, 'نانا مامبيري', 'Nana-Mambere', '09', 'not_used', NULL, 36),
(514, 'أواكا', 'Ouaka', '11', 'not_used', NULL, 36),
(515, 'كوتو العليا', 'Haute-Kotto', '03', 'not_used', NULL, 36),
(516, 'سانغا مباري', 'Sangha-Mbaere', '16', 'not_used', NULL, 36),
(517, 'بامينغي-بانغوران', 'Bamingui-Bangoran', '01', 'not_used', NULL, 36),
(518, 'مبومو', 'Mbomou', '08', 'not_used', NULL, 36),
(519, 'باس كوتو', 'Basse-Kotto', '02', 'not_used', NULL, 36),
(520, 'كيمو', 'Kemo', '06', 'not_used', NULL, 36),
(521, 'هوت مبومو', 'Haut-Mbomou', '05', 'not_used', NULL, 36),
(522, 'أوهام بندي', 'Ouham-Pende', '13', 'not_used', NULL, 36),
(523, 'أوهام', 'Ouham', '12', 'not_used', NULL, 36),
(524, 'أومبلا مبوكي', 'Ombella-Mpoko', '17', 'not_used', NULL, 36),
(525, 'كفيت-كويست', 'Cuvette-Ouest', '14', 'not_used', NULL, 36),
(526, 'مامبري كادي', 'Mambere-Kadei', '04', 'not_used', NULL, 36),
(527, 'وباي', 'Lobaye', '07', 'not_used', NULL, 36),
(529, 'نانا غريبيزي', 'Nana-Grebizi', '15', 'not_used', NULL, 36),
(530, 'بانغي', 'Bangui', '18', 'not_used', NULL, 36),
(532, 'الهضاب', 'Plateaux', '08', 'not_used', NULL, 37),
(533, 'حوض السباحة', 'Pool', '11', 'not_used', NULL, 37),
(534, 'سانغا', 'Sangha', '10', 'not_used', NULL, 37),
(535, 'يكومو', 'Lekoumou', '05', 'not_used', NULL, 37),
(536, 'يكوالا', 'Likouala', '06', 'not_used', NULL, 37),
(537, 'كويلو', 'Kouilou', '04', 'not_used', NULL, 37),
(538, 'نياري', 'Niari', '07', 'not_used', NULL, 37),
(539, 'بوينزا', 'Bouenza', '01', 'not_used', NULL, 37),
(540, 'برازافيل', 'Brazzaville', '12', 'not_used', NULL, 37),
(541, 'كفيت-كويست', 'Cuvette-Ouest', '14', 'not_used', NULL, 37),
(542, 'كفيت', 'Cuvette', '13', 'not_used', NULL, 37),
(543, 'ثورجو', 'Thurgau', '19', 'not_used', NULL, 38),
(544, 'أرجاو', 'Aargau', '01', 'not_used', NULL, 38),
(545, 'برن', 'Bern', '05', 'not_used', NULL, 38),
(546, 'زيوريخ', 'Zurich', '25', 'not_used', NULL, 38),
(547, 'فريبورغ', 'Fribourg', '06', 'not_used', NULL, 38),
(548, 'Ausser-رودين', 'Ausser-Rhoden', '02', 'not_used', NULL, 38),
(549, 'فاليه', 'Valais', '22', 'not_used', NULL, 38),
(550, 'أوري', 'Uri', '21', 'not_used', NULL, 38),
(551, 'غراوبوندن', 'Graubunden', '09', 'not_used', NULL, 38),
(552, 'تيسان', 'Ticino', '20', 'not_used', NULL, 38),
(553, 'لوزيرن', 'Luzern', '11', 'not_used', NULL, 38),
(554, 'أوبوالدن', 'Obwalden', '14', 'not_used', NULL, 38),
(555, 'سولوتورن', 'Solothurn', '18', 'not_used', NULL, 38),
(556, 'بازل شتات', 'Basel-Stadt', '04', 'not_used', NULL, 38),
(557, 'الداخلية-رودين', 'Inner-Rhoden', '10', 'not_used', NULL, 38),
(558, 'زوغ', 'Zug', '24', 'not_used', NULL, 38),
(559, 'فو', 'Vaud', '23', 'not_used', NULL, 38),
(560, 'العصر الجوارسي أو الجوري', 'Jura', '26', 'not_used', NULL, 38),
(561, 'كانتون ريف بازل', 'Basel-Landschaft', '03', 'not_used', NULL, 38),
(562, 'شفيتس', 'Schwyz', '17', 'not_used', NULL, 38),
(563, 'سانكت غالن', 'Sankt Gallen', '15', 'not_used', NULL, 38),
(564, 'شافهاوزن', 'Schaffhausen', '16', 'not_used', NULL, 38),
(565, 'جلاروس', 'Glarus', '08', 'not_used', NULL, 38),
(566, 'جنيف', 'Geneve', '07', 'not_used', NULL, 38),
(567, 'نيوشاتل', 'Neuchatel', '12', 'not_used', NULL, 38),
(568, 'نيدوالدن', 'Nidwalden', '13', 'not_used', NULL, 38),
(579, 'فالي دو بانداما', 'Vallee du Bandama', '90', 'not_used', NULL, 39),
(581, 'N\'zi كومو', 'N\'zi-Comoe', '86', 'not_used', NULL, 39),
(585, 'موين كومو', 'Moyen-Comoe', '85', 'not_used', NULL, 39),
(587, 'اجونيه', 'Lagunes', '82', 'not_used', NULL, 39),
(588, 'زانزان', 'Zanzan', '92', 'not_used', NULL, 39),
(589, 'سود كومو', 'Sud-Comoe', '89', 'not_used', NULL, 39),
(590, 'البحيرات', 'Lacs', '81', 'not_used', NULL, 39),
(598, 'فورماجر', 'Fromager', '79', 'not_used', NULL, 39),
(600, 'Agneby', 'Agneby', '74', 'not_used', NULL, 39),
(601, 'بس ساساندرا', 'Bas-Sassandra', '76', 'not_used', NULL, 39),
(603, 'مراهو', 'Marahoue', '83', 'not_used', NULL, 39),
(608, 'بافنج', 'Bafing', '75', 'not_used', NULL, 39),
(614, 'السافانا', 'Savanes', '87', 'not_used', NULL, 39),
(619, 'سود بانداما', 'Sud-Bandama', '88', 'not_used', NULL, 39),
(620, 'أوت ساساندرا', 'Haut-Sassandra', '80', 'not_used', NULL, 39),
(621, 'موين كافالي', 'Moyen-Cavally', '84', 'not_used', NULL, 39),
(622, 'ديكس - هويت مونتاجنيس', 'Dix-Huit Montagnes', '78', 'not_used', NULL, 39),
(623, 'دانغيل', 'Denguele', '77', 'not_used', NULL, 39),
(624, 'ورودوجو', 'Worodougou', '91', 'not_used', NULL, 39),
(626, 'بيو بيو', 'Bio-Bio', '06', 'not_used', NULL, 41),
(627, 'مولي', 'Maule', '11', 'not_used', NULL, 41),
(628, 'لوس لاغوس', 'Los Lagos', '09', 'not_used', NULL, 41),
(629, 'تاراباكا', 'Tarapaca', '13', 'not_used', NULL, 41),
(630, 'فالبارايسو', 'Valparaiso', '01', 'not_used', NULL, 41),
(631, 'أتاكاما', 'Atacama', '05', 'not_used', NULL, 41),
(632, 'كوكيمبو', 'Coquimbo', '07', 'not_used', NULL, 41),
(633, 'Libertador General Bernardo O\'Higgins', 'Libertador General Bernardo O\'Higgins', '08', 'not_used', NULL, 41),
(634, 'أنتوفاغاستا', 'Antofagasta', '03', 'not_used', NULL, 41),
(635, 'أراوكاريا', 'Araucania', '04', 'not_used', NULL, 41),
(636, 'Aisen del General Carlos Ibanez del Campo', 'Aisen del General Carlos Ibanez del Campo', '02', 'not_used', NULL, 41),
(637, 'منطقة متروبوليتانا', 'Region Metropolitana', '12', 'not_used', NULL, 41),
(638, 'Magallanes y de la Antartica Chilena', 'Magallanes y de la Antartica Chilena', '10', 'not_used', NULL, 41),
(639, 'EST', 'Est', '04', 'not_used', NULL, 42),
(640, 'أداماوا', 'Adamaoua', '10', 'not_used', NULL, 42),
(641, 'مركز', 'Centre', '11', 'not_used', NULL, 42),
(642, 'سود', 'Sud', '14', 'not_used', NULL, 42),
(643, 'الإقليم الشمالي الغربي', 'Nord-Ouest', '07', 'not_used', NULL, 42),
(644, 'المتطرف نور', 'Extreme-Nord', '12', 'not_used', NULL, 42),
(645, 'الإقليم الجنوبي الغربي', 'Sud-Ouest', '09', 'not_used', NULL, 42),
(646, 'ساحلي', 'Littoral', '05', 'not_used', NULL, 42),
(647, 'نورد', 'Nord', '13', 'not_used', NULL, 42),
(648, 'كويست', 'Ouest', '08', 'not_used', NULL, 42),
(649, 'سيتشوان', 'Sichuan', '32', 'not_used', NULL, 43),
(650, 'شينجيانغ', 'Xinjiang', '13', 'not_used', NULL, 43),
(651, 'ني المغول', 'Nei Mongol', '20', 'not_used', NULL, 43),
(652, 'يونان', 'Yunnan', '29', 'not_used', NULL, 43),
(653, 'قويتشو', 'Guizhou', '18', 'not_used', NULL, 43),
(654, 'هيلونغجيانغ', 'Heilongjiang', '08', 'not_used', NULL, 43),
(655, 'شاندونغ', 'Shandong', '25', 'not_used', NULL, 43),
(656, 'لياونينغ', 'Liaoning', '19', 'not_used', NULL, 43),
(657, 'شنشى', 'Shaanxi', '26', 'not_used', NULL, 43),
(658, 'تشينغهاي', 'Qinghai', '06', 'not_used', NULL, 43),
(659, 'قانسو', 'Gansu', '15', 'not_used', NULL, 43),
(660, 'جيانغسو', 'Jiangsu', '04', 'not_used', NULL, 43),
(661, 'فوجيان', 'Fujian', '07', 'not_used', NULL, 43),
(662, 'هونان', 'Hunan', '11', 'not_used', NULL, 43),
(663, 'جيانغشى', 'Jiangxi', '03', 'not_used', NULL, 43),
(664, 'قوانغشى', 'Guangxi', '16', 'not_used', NULL, 43),
(665, 'تشجيانغ', 'Zhejiang', '02', 'not_used', NULL, 43),
(666, 'خبى', 'Hebei', '10', 'not_used', NULL, 43),
(667, 'هوبى', 'Hubei', '12', 'not_used', NULL, 43),
(668, 'انهوى', 'Anhui', '01', 'not_used', NULL, 43),
(669, 'تيانجين', 'Tianjin', '28', 'not_used', NULL, 43),
(670, 'هاينان', 'Hainan', '31', 'not_used', NULL, 43),
(671, 'قوانغدونغ', 'Guangdong', '30', 'not_used', NULL, 43),
(672, 'زيزانغ', 'Xizang', '14', 'not_used', NULL, 43),
(673, 'جيلين', 'Jilin', '05', 'not_used', NULL, 43),
(674, 'تشونغتشينغ', 'Chongqing', '33', 'not_used', NULL, 43),
(675, 'بكين', 'Beijing', '22', 'not_used', NULL, 43),
(676, 'شانشى', 'Shanxi', '24', 'not_used', NULL, 43),
(677, 'شنغهاي', 'Shanghai', '23', 'not_used', NULL, 43),
(678, 'خنان', 'Henan', '09', 'not_used', NULL, 43),
(679, 'نينغشيا', 'Ningxia', '21', 'not_used', NULL, 43),
(680, 'كونديناماركا', 'Cundinamarca', '33', 'not_used', NULL, 44),
(681, 'نورتي دي سانتاندر', 'Norte de Santander', '21', 'not_used', NULL, 44),
(682, 'نارينو', 'Narino', '20', 'not_used', NULL, 44),
(684, 'ريزارالدا', 'Risaralda', '24', 'not_used', NULL, 44),
(685, 'أنتيوكيا', 'Antioquia', '02', 'not_used', NULL, 44),
(686, 'أمازوناس', 'Amazonas', '01', 'not_used', NULL, 44),
(687, 'لا غواخيرا', 'La Guajira', '17', 'not_used', NULL, 44),
(688, 'شوكو', 'Choco', '11', 'not_used', NULL, 44),
(689, 'كاوكا', 'Cauca', '09', 'not_used', NULL, 44),
(690, 'فالي ديل كاوكا', 'Valle del Cauca', '29', 'not_used', NULL, 44),
(691, 'اروكا', 'Arauca', '03', 'not_used', NULL, 44),
(692, 'ميتا', 'Meta', '19', 'not_used', NULL, 44),
(693, 'كاكويتا', 'Caqueta', '08', 'not_used', NULL, 44),
(694, 'كازاناري', 'Casanare', '32', 'not_used', NULL, 44),
(695, 'فاوبيس', 'Vaupes', '30', 'not_used', NULL, 44),
(696, 'توليما', 'Tolima', '28', 'not_used', NULL, 44),
(697, 'هويلا', 'Huila', '16', 'not_used', NULL, 44),
(699, 'اتلانتيكو', 'Atlantico', '04', 'not_used', NULL, 44),
(700, 'قرطبة', 'Cordoba', '12', 'not_used', NULL, 44),
(701, 'سانتاندر', 'Santander', '26', 'not_used', NULL, 44),
(702, 'سيزار', 'Cesar', '10', 'not_used', NULL, 44),
(703, 'سوكري', 'Sucre', '27', 'not_used', NULL, 44),
(705, 'بوتومايو', 'Putumayo', '22', 'not_used', NULL, 44),
(707, 'غوابياري', 'Guaviare', '14', 'not_used', NULL, 44),
(708, 'San Andres y Providencia', 'San Andres y Providencia', '25', 'not_used', NULL, 44),
(709, 'فيتشادا', 'Vichada', '31', 'not_used', NULL, 44),
(710, 'كوينديو', 'Quindio', '23', 'not_used', NULL, 44),
(711, 'غواينيا', 'Guainia', '15', 'not_used', NULL, 44),
(712, 'Distrito Especial', 'Distrito Especial', '34', 'not_used', NULL, 44),
(713, 'غواناكاست', 'Guanacaste', '03', 'not_used', NULL, 45),
(714, 'ليمون', 'Limon', '06', 'not_used', NULL, 45),
(715, 'بونتاريناس', 'Puntarenas', '07', 'not_used', NULL, 45),
(716, 'ألاخويلا', 'Alajuela', '01', 'not_used', NULL, 45),
(717, 'هيريديا', 'Heredia', '04', 'not_used', NULL, 45),
(718, 'سان خوسيه', 'San Jose', '08', 'not_used', NULL, 45),
(719, 'قرطاج', 'Cartago', '02', 'not_used', NULL, 45),
(720, 'سيينفويغوس', 'Cienfuegos', '08', 'not_used', NULL, 46),
(721, 'لا هافانا', 'La Habana', '11', 'not_used', NULL, 46),
(722, 'سانتياغو دي كوبا', 'Santiago de Cuba', '15', 'not_used', NULL, 46),
(723, 'كاماغواي', 'Camaguey', '05', 'not_used', NULL, 46),
(724, 'سيوداد دي لا هافانا', 'Ciudad de la Habana', '02', 'not_used', NULL, 46),
(725, 'فيلا كلارا', 'Villa Clara', '16', 'not_used', NULL, 46),
(726, 'بينار ديل ريو', 'Pinar del Rio', '01', 'not_used', NULL, 46),
(727, 'ماتانزاس', 'Matanzas', '03', 'not_used', NULL, 46),
(728, 'غوانتانامو', 'Guantanamo', '10', 'not_used', NULL, 46),
(729, 'لاس توناس', 'Las Tunas', '13', 'not_used', NULL, 46),
(730, 'سييغو دي أفيلا', 'Ciego de Avila', '07', 'not_used', NULL, 46),
(731, 'سانكتي سبيريتوس', 'Sancti Spiritus', '14', 'not_used', NULL, 46),
(732, 'هولغوين', 'Holguin', '12', 'not_used', NULL, 46),
(733, 'غرانما', 'Granma', '09', 'not_used', NULL, 46),
(734, 'جزيرة دي لا جوفينتود', 'Isla de la Juventud', '04', 'not_used', NULL, 46),
(735, 'ساو دومينغوس', 'Sao Domingos', '17', 'not_used', NULL, 47),
(738, 'ليماسول', 'Limassol', '05', 'not_used', NULL, 49),
(739, 'نيقوسيا', 'Nicosia', '04', 'not_used', NULL, 49),
(740, 'بافوس', 'Paphos', '06', 'not_used', NULL, 49),
(741, 'فاماغوستا', 'Famagusta', '01', 'not_used', NULL, 49),
(742, 'لارنكا', 'Larnaca', '03', 'not_used', NULL, 49),
(743, 'كيرينيا', 'Kyrenia', '02', 'not_used', NULL, 49),
(744, 'كارلوفارسكي كراج', 'Karlovarsky kraj', '81', 'not_used', NULL, 50),
(745, 'بردوبيكي كراج', 'Pardubicky kraj', '86', 'not_used', NULL, 50),
(747, 'Jihomoravsky كراج', 'Jihomoravsky kraj', '78', 'not_used', NULL, 50),
(748, 'Jihocesky kraj', 'Jihocesky kraj', '79', 'not_used', NULL, 50),
(749, 'أولوموكي كراج', 'Olomoucky kraj', '84', 'not_used', NULL, 50),
(750, 'Moravskoslezsky كراج', 'Moravskoslezsky kraj', '85', 'not_used', NULL, 50),
(752, 'Kralovehradecky كراج', 'Kralovehradecky kraj', '82', 'not_used', NULL, 50),
(753, 'أوستيكي كراج', 'Ustecky kraj', '89', 'not_used', NULL, 50),
(754, 'Stredocesky كراج', 'Stredocesky kraj', '88', 'not_used', NULL, 50),
(755, 'فيسوسينا', 'Vysocina', '80', 'not_used', NULL, 50),
(756, 'Plzensky كراج', 'Plzensky kraj', '87', 'not_used', NULL, 50),
(760, 'زلينسكي كراج', 'Zlinsky kraj', '90', 'not_used', NULL, 50),
(761, 'هلفني ميستو براها', 'Hlavni mesto Praha', '52', 'not_used', NULL, 50),
(763, 'Liberecky كراج', 'Liberecky kraj', '83', 'not_used', NULL, 50),
(773, 'نوردراين فيستفالن', 'Nordrhein-Westfalen', '07', 'not_used', NULL, 51),
(774, 'بادن فورتمبيرغ', 'Baden-Wurttemberg', '01', 'not_used', NULL, 51),
(775, 'بايرن ميونيخ', 'Bayern', '02', 'not_used', NULL, 51),
(776, 'راينلاند-بفالز', 'Rheinland-Pfalz', '08', 'not_used', NULL, 51),
(777, 'Niedersachsen', 'Niedersachsen', '06', 'not_used', NULL, 51),
(778, 'شليسفيغ هولشتاين', 'Schleswig-Holstein', '10', 'not_used', NULL, 51),
(779, 'براندنبورغ', 'Brandenburg', '11', 'not_used', NULL, 51),
(780, 'سكسونيا أنهالت', 'Sachsen-Anhalt', '14', 'not_used', NULL, 51),
(781, 'ساكسن', 'Sachsen', '13', 'not_used', NULL, 51),
(782, 'THÜRINGEN', 'Thuringen', '15', 'not_used', NULL, 51),
(783, 'هيسن', 'Hessen', '05', 'not_used', NULL, 51),
(784, 'مكلنبورغ-فوربومرن', 'Mecklenburg-Vorpommern', '12', 'not_used', NULL, 51),
(785, 'هامبورغ', 'Hamburg', '04', 'not_used', NULL, 51),
(786, 'البرلينية', 'Berlin', '16', 'not_used', NULL, 51),
(787, 'سارلاند', 'Saarland', '09', 'not_used', NULL, 51),
(788, 'بريمن', 'Bremen', '03', 'not_used', NULL, 51),
(789, 'علي صبيح', 'Ali Sabieh', '01', 'not_used', NULL, 52),
(790, 'تاجورا', 'Tadjoura', '05', 'not_used', NULL, 52),
(792, 'أوبوك', 'Obock', '04', 'not_used', NULL, 52),
(794, 'أرتا', 'Arta', '08', 'not_used', NULL, 52),
(795, 'دخيل', 'Dikhil', '06', 'not_used', NULL, 52),
(796, 'سيدانمارك', 'Syddanmark', '21', 'not_used', NULL, 53),
(797, 'ميتجيلاند', 'Midtjylland', '18', 'not_used', NULL, 53),
(798, 'نوردلاند', 'Nordjylland', '19', 'not_used', NULL, 53),
(799, 'Sjelland', 'Sjelland', '20', 'not_used', NULL, 53),
(800, 'هوفدستادين', 'Hovedstaden', '17', 'not_used', NULL, 53),
(801, 'القديس أندرو', 'Saint Andrew', '02', 'not_used', NULL, 54),
(802, 'القديس داود', 'Saint David', '03', 'not_used', NULL, 54),
(803, 'القديس يوسف', 'Saint Joseph', '06', 'not_used', NULL, 54),
(804, 'القديس جورج', 'Saint George', '04', 'not_used', NULL, 54),
(805, 'سانت باتريك', 'Saint Patrick', '09', 'not_used', NULL, 54),
(806, 'القديس بطرس', 'Saint Peter', '11', 'not_used', NULL, 54),
(807, 'القديس يوحنا', 'Saint John', '05', 'not_used', NULL, 54),
(808, 'سان مارك', 'Saint Mark', '08', 'not_used', NULL, 54),
(809, 'القديس بول', 'Saint Paul', '10', 'not_used', NULL, 54),
(810, 'القديس لوقا', 'Saint Luke', '07', 'not_used', NULL, 54),
(811, 'سانشيز راميريز', 'Sanchez Ramirez', '21', 'not_used', NULL, 55),
(812, 'إسبايلات', 'Espaillat', '08', 'not_used', NULL, 55),
(813, 'دوارتي', 'Duarte', '06', 'not_used', NULL, 55),
(814, 'سمانا', 'Samana', '20', 'not_used', NULL, 55),
(815, 'ماريا ترينيداد سانشيز', 'Maria Trinidad Sanchez', '14', 'not_used', NULL, 55),
(816, 'لا رومانا', 'La Romana', '12', 'not_used', NULL, 55),
(817, 'ازوا', 'Azua', '01', 'not_used', NULL, 55),
(818, 'سان كريستوبال', 'San Cristobal', '33', 'not_used', NULL, 55),
(819, 'الصيبو', 'El Seibo', '28', 'not_used', NULL, 55),
(820, 'مونت بلاتا', 'Monte Plata', '32', 'not_used', NULL, 55),
(821, 'Distrito Nacional', 'Distrito Nacional', '05', 'not_used', NULL, 55),
(822, 'إلياس بينا', 'Elias Pina', '11', 'not_used', NULL, 55),
(823, 'سانتياغو', 'Santiago', '25', 'not_used', NULL, 55),
(824, 'سانتياغو رودريجيز', 'Santiago Rodriguez', '26', 'not_used', NULL, 55),
(825, 'بيرافيا', 'Peravia', '17', 'not_used', NULL, 55),
(826, 'مونت كريستي', 'Monte Cristi', '15', 'not_used', NULL, 55),
(827, 'سالسيدو', 'Salcedo', '19', 'not_used', NULL, 55),
(828, 'بويرتو بلاتا', 'Puerto Plata', '18', 'not_used', NULL, 55),
(829, 'سان بيدرو دي ماكوريس', 'San Pedro De Macoris', '24', 'not_used', NULL, 55),
(830, 'بدرنالس', 'Pedernales', '16', 'not_used', NULL, 55),
(831, 'الاستقلال', 'Independencia', '09', 'not_used', NULL, 55),
(832, 'لا فيغا', 'La Vega', '30', 'not_used', NULL, 55),
(833, 'داجابون', 'Dajabon', '04', 'not_used', NULL, 55),
(834, 'حاتو العمدة', 'Hato Mayor', '29', 'not_used', NULL, 55),
(835, 'باراهونا', 'Barahona', '03', 'not_used', NULL, 55),
(836, 'سان خوان', 'San Juan', '23', 'not_used', NULL, 55),
(837, 'لا التاغراسيا', 'La Altagracia', '10', 'not_used', NULL, 55),
(838, 'فالفيردي', 'Valverde', '27', 'not_used', NULL, 55),
(839, 'Baoruco', 'Baoruco', '02', 'not_used', NULL, 55),
(840, 'مونسنور نويل', 'Monsenor Nouel', '31', 'not_used', NULL, 55),
(841, 'عين تموشنت', 'Ain Temouchent', '36', 'not_used', NULL, 56),
(842, 'وهران', 'Oran', '09', 'not_used', NULL, 56),
(843, 'المدية', 'Medea', '06', 'not_used', NULL, 56),
(844, 'الشلف', 'Chlef', '41', 'not_used', NULL, 56),
(845, 'بشار', 'Bechar', '38', 'not_used', NULL, 56),
(846, 'تمنراست', 'Tamanghasset', '53', 'not_used', NULL, 56),
(847, 'بجاية', 'Bejaia', '18', 'not_used', NULL, 56),
(848, 'تيزي وزو', 'Tizi Ouzou', '14', 'not_used', NULL, 56),
(849, 'بومرداس', 'Boumerdes', '40', 'not_used', NULL, 56),
(850, 'عين الدفلة', 'Ain Defla', '35', 'not_used', NULL, 56),
(851, 'عنابة', 'Annaba', '37', 'not_used', NULL, 56),
(852, 'سطيف', 'Setif', '12', 'not_used', NULL, 56),
(853, 'غليزان', 'Relizane', '51', 'not_used', NULL, 56),
(854, 'ماسكارا', 'Mascara', '26', 'not_used', NULL, 56),
(855, 'مستغانم', 'Mostaganem', '07', 'not_used', NULL, 56),
(856, 'تيارت', 'Tiaret', '13', 'not_used', NULL, 56),
(857, 'برج بوعريريج', 'Bordj Bou Arreridj', '39', 'not_used', NULL, 56),
(858, 'تيبازة', 'Tipaza', '55', 'not_used', NULL, 56),
(860, 'البويرة', 'Bouira', '21', 'not_used', NULL, 56),
(861, 'تيسمسيلت', 'Tissemsilt', '56', 'not_used', NULL, 56),
(862, 'جيجل', 'Jijel', '24', 'not_used', NULL, 56),
(863, 'صيدا', 'Saida', '10', 'not_used', NULL, 56),
(864, 'إليزي', 'Illizi', '46', 'not_used', NULL, 56),
(865, 'تلمسان', 'Tlemcen', '15', 'not_used', NULL, 56),
(866, 'أدرار', 'Adrar', '34', 'not_used', NULL, 56),
(867, 'الأغواط', 'Laghouat', '25', 'not_used', NULL, 56),
(868, 'قسنطينة', 'Constantine', '04', 'not_used', NULL, 56),
(869, 'خنشلة', 'Khenchela', '47', 'not_used', NULL, 56),
(870, 'باتنة', 'Batna', '03', 'not_used', NULL, 56),
(871, 'الجزائر', 'Alger', '01', 'not_used', NULL, 56),
(872, 'مسيلة', 'M\'sila', '27', 'not_used', NULL, 56),
(873, 'سكيكدة', 'Skikda', '31', 'not_used', NULL, 56),
(874, 'ام البواقي', 'Oum el Bouaghi', '29', 'not_used', NULL, 56),
(875, 'نعمة', 'Naama', '49', 'not_used', NULL, 56),
(876, 'سيدي بلعباس', 'Sidi Bel Abbes', '30', 'not_used', NULL, 56),
(877, 'ميلة', 'Mila', '48', 'not_used', NULL, 56),
(878, 'ورقلة', 'Ouargla', '50', 'not_used', NULL, 56),
(879, 'الجلفة', 'Djelfa', '22', 'not_used', NULL, 56),
(880, 'البيض', 'El Bayadh', '42', 'not_used', NULL, 56),
(881, 'سوق أهراس', 'Souk Ahras', '52', 'not_used', NULL, 56),
(882, 'الواد', 'El Oued', '43', 'not_used', NULL, 56),
(883, 'البليدة', 'Blida', '20', 'not_used', NULL, 56),
(884, 'بسكرة', 'Biskra', '19', 'not_used', NULL, 56),
(885, 'تبسة', 'Tebessa', '33', 'not_used', NULL, 56),
(886, 'قالمة', 'Guelma', '23', 'not_used', NULL, 56),
(887, 'تندوف', 'Tindouf', '54', 'not_used', NULL, 56),
(888, 'غرداية', 'Ghardaia', '45', 'not_used', NULL, 56),
(889, 'مانابي', 'Manabi', '14', 'not_used', NULL, 57),
(890, 'زامورا-شينشيب', 'Zamora-Chinchipe', '20', 'not_used', NULL, 57),
(891, 'مورونا سانتياغو', 'Morona-Santiago', '15', 'not_used', NULL, 57),
(892, 'اورو', 'El Oro', '08', 'not_used', NULL, 57),
(893, 'ازواي', 'Azuay', '02', 'not_used', NULL, 57),
(894, 'سوكومبيوس', 'Sucumbios', '22', 'not_used', NULL, 57),
(895, 'غواياس', 'Guayas', '10', 'not_used', NULL, 57),
(896, 'لوس ريوس', 'Los Rios', '13', 'not_used', NULL, 57),
(897, 'وخا', 'Loja', '12', 'not_used', NULL, 57),
(898, 'شيمبورازو', 'Chimborazo', '06', 'not_used', NULL, 57),
(899, 'تونغوراهوا', 'Tungurahua', '19', 'not_used', NULL, 57),
(900, 'ازميرالدا', 'Esmeraldas', '09', 'not_used', NULL, 57),
(901, 'بيشينشا', 'Pichincha', '18', 'not_used', NULL, 57),
(902, 'إمبابورا', 'Imbabura', '11', 'not_used', NULL, 57),
(903, 'كوتوباكسي', 'Cotopaxi', '07', 'not_used', NULL, 57),
(904, 'كارشي', 'Carchi', '05', 'not_used', NULL, 57),
(905, 'نابو', 'Napo', '23', 'not_used', NULL, 57),
(906, 'كنار', 'Canar', '04', 'not_used', NULL, 57),
(907, 'باستازا', 'Pastaza', '17', 'not_used', NULL, 57),
(908, 'أوريانا', 'Orellana', '24', 'not_used', NULL, 57),
(909, 'بوليفار', 'Bolivar', '03', 'not_used', NULL, 57),
(910, 'غالاباغوس', 'Galapagos', '01', 'not_used', NULL, 57),
(911, 'Harjumaa', 'Harjumaa', '01', 'not_used', NULL, 58),
(912, 'تارتوما', 'Tartumaa', '18', 'not_used', NULL, 58),
(913, 'هيوما', 'Hiiumaa', '02', 'not_used', NULL, 58),
(914, 'رابلاما', 'Raplamaa', '13', 'not_used', NULL, 58),
(915, 'فلغما', 'Valgamaa', '19', 'not_used', NULL, 58),
(916, 'انيما', 'Laanemaa', '07', 'not_used', NULL, 58),
(917, 'بولفاما', 'Polvamaa', '12', 'not_used', NULL, 58),
(918, 'بارنوما', 'Parnumaa', '11', 'not_used', NULL, 58),
(919, 'اني فيريوما', 'Laane-Virumaa', '08', 'not_used', NULL, 58),
(920, 'يارفا', 'Jarvamaa', '04', 'not_used', NULL, 58),
(921, 'فيلجاندي', 'Viljandimaa', '20', 'not_used', NULL, 58),
(922, 'ساريما', 'Saaremaa', '14', 'not_used', NULL, 58),
(923, 'جوغفما', 'Jogevamaa', '05', 'not_used', NULL, 58),
(924, 'المؤسسة الدولية للتنمية فيروما', 'Ida-Virumaa', '03', 'not_used', NULL, 58),
(925, 'فوروما', 'Vorumaa', '21', 'not_used', NULL, 58),
(926, 'الشرقية', 'Ash Sharqiyah', '14', 'not_used', 30.00, 59),
(927, 'الغربية', 'Al Gharbiyah', '05', 'not_used', 50.00, 59),
(928, 'الدقهلية', 'Ad Daqahliyah', '01', 'not_used', 20.00, 59),
(929, 'الجيزة', 'Al Jizah', '08', 'not_used', NULL, 59),
(930, 'المنيا', 'Al Minya', '10', 'not_used', NULL, 59),
(931, 'كفر الشيخ', 'Kafr ash Shaykh', '21', 'not_used', NULL, 59),
(932, 'البحيرة', 'Al Buhayrah', '03', 'not_used', NULL, 59),
(933, 'قنا', 'Qina', '23', 'not_used', NULL, 59),
(934, 'القاهره', 'Al Qahirah', '11', 'not_used', 50.00, 59),
(935, 'الاسكندرية', 'Al Iskandariyah', '06', 'not_used', NULL, 59),
(936, 'الفيوم', 'Al Fayyum', '04', 'not_used', NULL, 59),
(937, 'أسيوط', 'Asyut', '17', 'not_used', NULL, 59),
(938, 'المنوفية', 'Al Minufiyah', '09', 'not_used', NULL, 59),
(939, 'بني سويف', 'Bani Suwayf', '18', 'not_used', NULL, 59),
(940, 'القليوبية', 'Al Qalyubiyah', '12', 'not_used', NULL, 59),
(941, 'أسوان', 'Aswan', '16', 'not_used', NULL, 59),
(942, 'شمال سينا', 'Shamal Sina\'', '27', 'not_used', NULL, 59),
(943, 'سوهاج', 'Suhaj', '24', 'not_used', NULL, 59),
(944, 'جنب سينا', 'Janub Sina\'', '26', 'not_used', NULL, 59),
(945, 'البحر الاحمر', 'Al Bahr al Ahmar', '02', 'not_used', NULL, 59),
(946, 'الاسماعيلية', 'Al Isma\'iliyah', '07', 'not_used', NULL, 59),
(947, 'دمياط', 'Dumyat', '20', 'not_used', NULL, 59),
(948, 'مطروح', 'Matruh', '22', 'not_used', NULL, 59),
(949, 'كما سوايز', 'As Suways', '15', 'not_used', NULL, 59),
(950, 'الوادي الجديد', 'Al Wadi al Jadid', '13', 'not_used', NULL, 59),
(951, 'بور سعيد', 'Bur Sa\'id', '19', 'not_used', NULL, 59),
(954, 'أراغون', 'Aragon', '52', 'not_used', NULL, 62),
(955, 'غاليسيا', 'Galicia', '58', 'not_used', NULL, 62),
(956, 'كاستيا ي ليون', 'Castilla y Leon', '55', 'not_used', NULL, 62),
(957, 'إكستريمادورا', 'Extremadura', '57', 'not_used', NULL, 62),
(958, 'بايس فاسكو', 'Pais Vasco', '59', 'not_used', NULL, 62),
(959, 'كانتابريا', 'Cantabria', '39', 'not_used', NULL, 62),
(960, 'نافارا', 'Navarra', '32', 'not_used', NULL, 62),
(961, 'أستورياس', 'Asturias', '34', 'not_used', NULL, 62),
(962, 'لا ريوخا', 'La Rioja', '27', 'not_used', NULL, 62),
(963, 'كاستيا لا مانشا', 'Castilla-La Mancha', '54', 'not_used', NULL, 62),
(964, 'مورسيا', 'Murcia', '31', 'not_used', NULL, 62),
(965, 'الأندلس', 'Andalucia', '51', 'not_used', NULL, 62),
(966, 'Comunidad فالنسيانا', 'Comunidad Valenciana', '60', 'not_used', NULL, 62),
(967, 'كاتالونيا', 'Catalonia', '56', 'not_used', NULL, 62),
(968, 'جزر الكناري', 'Canarias', '53', 'not_used', NULL, 62),
(969, 'مدريد', 'Madrid', '29', 'not_used', NULL, 62),
(970, 'ايسلاس باليريس', 'Islas Baleares', '07', 'not_used', NULL, 62),
(984, 'أولو', 'Oulu', '08', 'not_used', NULL, 64),
(985, 'فنلندا الغربية', 'Western Finland', '15', 'not_used', NULL, 64),
(986, 'ابلاند', 'Lapland', '06', 'not_used', NULL, 64),
(987, 'شرق فنلندا', 'Eastern Finland', '14', 'not_used', NULL, 64),
(988, 'جنوب فنلندا', 'Southern Finland', '13', 'not_used', NULL, 64),
(989, 'أرض', 'Aland', '01', 'not_used', NULL, 64),
(992, 'شمالي', 'Northern', '03', 'not_used', NULL, 65);
INSERT INTO `cities` (`id`, `name_ar`, `name_en`, `code`, `status`, `shipping_price`, `country_id`) VALUES
(993, 'الغربي', 'Western', '05', 'not_used', NULL, 65),
(994, 'وسط', 'Central', '01', 'not_used', NULL, 65),
(995, 'الشرقية', 'Eastern', '02', 'not_used', NULL, 65),
(997, 'ثرثرة', 'Yap', '04', 'not_used', NULL, 67),
(998, 'بوهنباي', 'Pohnpei', '02', 'not_used', NULL, 67),
(999, 'شوك', 'Chuuk', '03', 'not_used', NULL, 67),
(1000, 'كوسراي', 'Kosrae', '01', 'not_used', NULL, 67),
(1002, 'آكيتن', 'Aquitaine', '97', 'not_used', NULL, 69),
(1003, 'نور-با-دو-كاليه', 'Nord-Pas-de-Calais', 'B4', 'not_used', NULL, 69),
(1004, 'لورين', 'Lorraine', 'B2', 'not_used', NULL, 69),
(1005, 'هوت نورماندي', 'Haute-Normandie', 'A7', 'not_used', NULL, 69),
(1006, 'بيكاردي', 'Picardie', 'B6', 'not_used', NULL, 69),
(1007, 'فرانش-كونت', 'Franche-Comte', 'A6', 'not_used', NULL, 69),
(1008, 'باي دو لا لوار', 'Pays de la Loire', 'B5', 'not_used', NULL, 69),
(1009, 'الشمبانيا اردين', 'Champagne-Ardenne', 'A4', 'not_used', NULL, 69),
(1010, 'مركز', 'Centre', 'A3', 'not_used', NULL, 69),
(1011, 'لانغدوك روسيون', 'Languedoc-Roussillon', 'A9', 'not_used', NULL, 69),
(1012, 'بواتو-شارانت', 'Poitou-Charentes', 'B7', 'not_used', NULL, 69),
(1013, 'رون ألب', 'Rhone-Alpes', 'B9', 'not_used', NULL, 69),
(1014, 'باس نورماندي', 'Basse-Normandie', '99', 'not_used', NULL, 69),
(1015, 'إيل دو فرانس', 'Ile-de-France', 'A8', 'not_used', NULL, 69),
(1016, 'بورغون', 'Bourgogne', 'A1', 'not_used', NULL, 69),
(1017, 'أوفيرني', 'Auvergne', '98', 'not_used', NULL, 69),
(1018, 'بروفانس ألب كوت دازور', 'Provence-Alpes-Cote d\'Azur', 'B8', 'not_used', NULL, 69),
(1019, 'كورس', 'Corse', 'A5', 'not_used', NULL, 69),
(1020, 'الألزاس', 'Alsace', 'C1', 'not_used', NULL, 69),
(1021, 'بريتان', 'Bretagne', 'A2', 'not_used', NULL, 69),
(1022, 'ميدي-بيرينيه', 'Midi-Pyrenees', 'B3', 'not_used', NULL, 69),
(1023, 'ليموزين', 'Limousin', 'B1', 'not_used', NULL, 69),
(1024, 'إيستوير', 'Estuaire', '01', 'not_used', NULL, 70),
(1025, 'ليو نتيم', 'Woleu-Ntem', '09', 'not_used', NULL, 70),
(1026, 'موين-أوغوي', 'Moyen-Ogooue', '03', 'not_used', NULL, 70),
(1027, 'أوغوي البحرية', 'Ogooue-Maritime', '08', 'not_used', NULL, 70),
(1028, 'أوغوي لولو', 'Ogooue-Lolo', '07', 'not_used', NULL, 70),
(1029, 'أوجوي إيفندو', 'Ogooue-Ivindo', '06', 'not_used', NULL, 70),
(1030, 'أوت أوغوي', 'Haut-Ogooue', '02', 'not_used', NULL, 70),
(1031, 'نغوني', 'Ngounie', '04', 'not_used', NULL, 70),
(1032, 'النيانغا', 'Nyanga', '05', 'not_used', NULL, 70),
(1033, 'رسيستيرشاير', 'Worcestershire', 'Q4', 'not_used', NULL, 71),
(1034, 'هامبشاير', 'Hampshire', 'F2', 'not_used', NULL, 71),
(1035, 'هرفوردشير', 'Herefordshire', 'F7', 'not_used', NULL, 71),
(1036, 'إسيكس', 'Essex', 'E4', 'not_used', NULL, 71),
(1037, 'بوويز', 'Powys', 'Y8', 'not_used', NULL, 71),
(1038, 'مونماوثشاير', 'Monmouthshire', 'Y4', 'not_used', NULL, 71),
(1039, 'الحدود الاسكتلندية', 'Scottish Borders', 'T9', 'not_used', NULL, 71),
(1040, 'كمبريا', 'Cumbria', 'C9', 'not_used', NULL, 71),
(1041, 'ديفون', 'Devon', 'D4', 'not_used', NULL, 71),
(1042, 'ستافوردشاير', 'Staffordshire', 'M9', 'not_used', NULL, 71),
(1043, 'دورست', 'Dorset', 'D6', 'not_used', NULL, 71),
(1044, 'هيرتفورد', 'Hertford', 'F8', 'not_used', NULL, 71),
(1045, 'كامبريدج', 'Cambridgeshire', 'C3', 'not_used', NULL, 71),
(1046, 'لانكشاير', 'Lancashire', 'H2', 'not_used', NULL, 71),
(1047, 'كونوي', 'Conwy', 'X8', 'not_used', NULL, 71),
(1048, 'سرديجون', 'Ceredigion', 'X6', 'not_used', NULL, 71),
(1049, 'روندا سينون تاف', 'Rhondda Cynon Taff', 'Y9', 'not_used', NULL, 71),
(1050, 'هضبة', 'Highland', 'V3', 'not_used', NULL, 71),
(1051, 'بيرث و كينروس', 'Perth and Kinross', 'W1', 'not_used', NULL, 71),
(1052, 'كيرفيلي', 'Caerphilly', 'X4', 'not_used', NULL, 71),
(1053, 'Blaenau Gwent', 'Blaenau Gwent', 'X2', 'not_used', NULL, 71),
(1054, 'ميرثير تيدفيل', 'Merthyr Tydfil', 'Y3', 'not_used', NULL, 71),
(1055, 'بيمبروكشاير', 'Pembrokeshire', 'Y7', 'not_used', NULL, 71),
(1056, 'أبردينشاير', 'Aberdeenshire', 'T6', 'not_used', NULL, 71),
(1057, 'جويند', 'Gwynedd', 'Y2', 'not_used', NULL, 71),
(1058, 'مدينة أبردين', 'Aberdeen City', 'T5', 'not_used', NULL, 71),
(1059, 'ناي آلة موسيقية', 'Fife', 'V1', 'not_used', NULL, 71),
(1060, 'نيث بورت تالبوت', 'Neath Port Talbot', 'Y5', 'not_used', NULL, 71),
(1061, 'جزيرة انجلسي', 'Isle of Anglesey', 'X1', 'not_used', NULL, 71),
(1062, 'ووكينغهام', 'Wokingham', 'Q2', 'not_used', NULL, 71),
(1063, 'يورك', 'York', 'Q5', 'not_used', NULL, 71),
(1064, 'ستيرلينغ', 'Stirling', 'W6', 'not_used', NULL, 71),
(1065, 'كرمرثنشير', 'Carmarthenshire', 'X7', 'not_used', NULL, 71),
(1066, 'كارديف', 'Bridgend', 'X3', 'not_used', NULL, 71),
(1067, 'شرق لوثيان', 'East Lothian', 'U6', 'not_used', NULL, 71),
(1068, 'انجوس', 'Angus', 'T7', 'not_used', NULL, 71),
(1069, 'موراي', 'Moray', 'V6', 'not_used', NULL, 71),
(1070, 'تورفين', 'Torfaen', 'Z2', 'not_used', NULL, 71),
(1071, 'سوانسي', 'Swansea', 'Z1', 'not_used', NULL, 71),
(1072, 'فيل غلامورغان', 'Vale of Glamorgan', 'Z3', 'not_used', NULL, 71),
(1073, 'أوكسفوردشاير', 'Oxfordshire', 'K2', 'not_used', NULL, 71),
(1074, 'سيارة بمقعدين', 'Surrey', 'N7', 'not_used', NULL, 71),
(1075, 'جنوب لاناركشاير', 'South Lanarkshire', 'W5', 'not_used', NULL, 71),
(1076, 'يسترشير', 'Leicestershire', 'H5', 'not_used', NULL, 71),
(1077, 'ويجان', 'Wigan', 'P7', 'not_used', NULL, 71),
(1078, 'نورثهامبتونشاير', 'Northamptonshire', 'J1', 'not_used', NULL, 71),
(1079, 'لينكولنشاير', 'Lincolnshire', 'H7', 'not_used', NULL, 71),
(1080, 'أرغيل وبوت', 'Argyll and Bute', 'T8', 'not_used', NULL, 71),
(1081, 'نورثمبرلاند', 'Northumberland', 'J6', 'not_used', NULL, 71),
(1082, 'نورفولك', 'Norfolk', 'I9', 'not_used', NULL, 71),
(1083, 'سوليهال', 'Solihull', 'M2', 'not_used', NULL, 71),
(1084, 'ريكسهام', 'Wrexham', 'Z4', 'not_used', NULL, 71),
(1085, 'شيشاير', 'Cheshire', 'C5', 'not_used', NULL, 71),
(1086, 'شروبشاير', 'Shropshire', 'L6', 'not_used', NULL, 71),
(1087, 'بانبريدج', 'Banbridge', 'R2', 'not_used', NULL, 71),
(1088, 'جنوب جلوسيسترشاير', 'South Gloucestershire', 'M6', 'not_used', NULL, 71),
(1089, 'لوثيان الغربية', 'West Lothian', 'W9', 'not_used', NULL, 71),
(1091, 'كينت', 'Kent', 'G5', 'not_used', NULL, 71),
(1092, 'ليدز', 'Leeds', 'H3', 'not_used', NULL, 71),
(1093, 'سومرست', 'Somerset', 'M3', 'not_used', NULL, 71),
(1094, 'جلوسيسترشاير', 'Gloucestershire', 'E6', 'not_used', NULL, 71),
(1095, 'باكينجهامشير', 'Buckinghamshire', 'B9', 'not_used', NULL, 71),
(1096, 'كوليرين', 'Coleraine', 'R6', 'not_used', NULL, 71),
(1097, 'كريجافون', 'Craigavon', 'R8', 'not_used', NULL, 71),
(1098, 'أنتريم', 'Antrim', 'Q6', 'not_used', NULL, 71),
(1099, 'يمافادي', 'Limavady', 'S4', 'not_used', NULL, 71),
(1100, 'أرما', 'Armagh', 'Q8', 'not_used', NULL, 71),
(1101, 'بلايميندا', 'Ballymena', 'Q9', 'not_used', NULL, 71),
(1102, 'شمال يوركشاير', 'North Yorkshire', 'J7', 'not_used', NULL, 71),
(1103, 'سيفتون', 'Sefton', 'L8', 'not_used', NULL, 71),
(1104, 'وارويكشاير', 'Warwickshire', 'P3', 'not_used', NULL, 71),
(1105, 'ديري', 'Derry', 'S6', 'not_used', NULL, 71),
(1106, 'ايلين سيار', 'Eilean Siar', 'W8', 'not_used', NULL, 71),
(1107, 'شمال لاناركشاير', 'North Lanarkshire', 'V8', 'not_used', NULL, 71),
(1108, 'فالكيرك', 'Falkirk', 'U9', 'not_used', NULL, 71),
(1109, 'جزر شتلاند', 'Shetland Islands', 'W3', 'not_used', NULL, 71),
(1110, 'ويلتشير', 'Wiltshire', 'P8', 'not_used', NULL, 71),
(1111, 'دورهام', 'Durham', 'D8', 'not_used', NULL, 71),
(1112, 'دارلينجتون', 'Darlington', 'D1', 'not_used', NULL, 71),
(1113, 'سوفولك', 'Suffolk', 'N5', 'not_used', NULL, 71),
(1114, 'ديربيشاير', 'Derbyshire', 'D3', 'not_used', NULL, 71),
(1115, 'والسال', 'Walsall', 'O8', 'not_used', NULL, 71),
(1116, 'روثرهام', 'Rotherham', 'L3', 'not_used', NULL, 71),
(1117, 'غرب دنبارتنشير', 'West Dunbartonshire', 'W7', 'not_used', NULL, 71),
(1118, 'شرق ساسكس', 'East Sussex', 'E2', 'not_used', NULL, 71),
(1119, 'كوفنتري', 'Coventry', 'C7', 'not_used', NULL, 71),
(1120, 'دربي', 'Derby', 'D2', 'not_used', NULL, 71),
(1121, 'ساوثيند على البحر', 'Southend-on-Sea', 'M5', 'not_used', NULL, 71),
(1122, 'كلاكمانشاير', 'Clackmannanshire', 'U1', 'not_used', NULL, 71),
(1123, 'كركليس', 'Kirklees', 'G8', 'not_used', NULL, 71),
(1124, 'سانت هيلينز', 'St. Helens', 'N1', 'not_used', NULL, 71),
(1125, 'أوما', 'Omagh', 'T3', 'not_used', NULL, 71),
(1126, 'كورنوال', 'Cornwall', 'C6', 'not_used', NULL, 71),
(1127, 'شمال لينكولنشاير', 'North Lincolnshire', 'J3', 'not_used', NULL, 71),
(1128, 'نيوري ومورن', 'Newry and Mourne', 'S9', 'not_used', NULL, 71),
(1129, 'جنوب ايرشاير', 'South Ayrshire', 'W4', 'not_used', NULL, 71),
(1130, 'جزيرة وايت', 'Isle of Wight', 'G2', 'not_used', NULL, 71),
(1132, 'دومفريز وجالاوي', 'Dumfries and Galloway', 'U2', 'not_used', NULL, 71),
(1133, 'بيدفوردشير', 'Bedfordshire', 'A5', 'not_used', NULL, 71),
(1134, 'أسفل', 'Down', 'R9', 'not_used', NULL, 71),
(1135, 'دونجانون', 'Dungannon', 'S1', 'not_used', NULL, 71),
(1136, 'رينفروشاير', 'Renfrewshire', 'W2', 'not_used', NULL, 71),
(1137, 'ليستر', 'Leicester', 'H4', 'not_used', NULL, 71),
(1138, 'مدينة غلاسكو', 'Glasgow City', 'V2', 'not_used', NULL, 71),
(1139, 'غرب ساسكس', 'West Sussex', 'P6', 'not_used', NULL, 71),
(1140, 'وارينغتون', 'Warrington', 'P2', 'not_used', NULL, 71),
(1141, 'كوكستاون', 'Cookstown', 'R7', 'not_used', NULL, 71),
(1142, 'شمال ايرشاير', 'North Ayrshire', 'V7', 'not_used', NULL, 71),
(1143, 'بارنسلي', 'Barnsley', 'A3', 'not_used', NULL, 71),
(1144, 'استربان', 'Strabane', 'T4', 'not_used', NULL, 71),
(1145, 'دونكاستر', 'Doncaster', 'D5', 'not_used', NULL, 71),
(1146, 'بلموني', 'Ballymoney', 'R1', 'not_used', NULL, 71),
(1147, 'فيرماناغ', 'Fermanagh', 'S2', 'not_used', NULL, 71),
(1149, 'نوتنغهام', 'Nottingham', 'J8', 'not_used', NULL, 71),
(1151, 'تامسايد', 'Tameside', 'O1', 'not_used', NULL, 71),
(1152, 'روتلاند', 'Rutland', 'L4', 'not_used', NULL, 71),
(1153, 'نوتينغمشير', 'Nottinghamshire', 'J9', 'not_used', NULL, 71),
(1154, 'ميدلوثيان', 'Midlothian', 'V5', 'not_used', NULL, 71),
(1155, 'شرق ايرشاير', 'East Ayrshire', 'U4', 'not_used', NULL, 71),
(1156, 'ستوك أون ترينت', 'Stoke-on-Trent', 'N4', 'not_used', NULL, 71),
(1157, 'بريستول', 'Bristol', 'B7', 'not_used', NULL, 71),
(1158, 'فلينتشير', 'Flintshire', 'Y1', 'not_used', NULL, 71),
(1159, 'بلاكبيرن مع داروين', 'Blackburn with Darwen', 'A8', 'not_used', NULL, 71),
(1160, 'مويلي', 'Moyle', 'S8', 'not_used', NULL, 71),
(1161, 'كاريكفرجس', 'Carrickfergus', 'R4', 'not_used', NULL, 71),
(1162, 'كاسلرا', 'Castlereagh', 'R5', 'not_used', NULL, 71),
(1163, 'ليرن', 'Larne', 'S3', 'not_used', NULL, 71),
(1164, 'بلفاست', 'Belfast', 'R3', 'not_used', NULL, 71),
(1165, 'مايرافلت', 'Magherafelt', 'S7', 'not_used', NULL, 71),
(1166, 'شمال داون', 'North Down', 'T2', 'not_used', NULL, 71),
(1167, 'شمال سومرست', 'North Somerset', 'J4', 'not_used', NULL, 71),
(1168, 'شرق رينفروشاير', 'East Renfrewshire', 'U7', 'not_used', NULL, 71),
(1169, 'نيوبورت', 'Newport', 'Y6', 'not_used', NULL, 71),
(1170, 'باث وشمال شرق سومرست', 'Bath and North East Somerset', 'A4', 'not_used', NULL, 71),
(1173, 'نيوهام', 'Newham', 'I8', 'not_used', NULL, 71),
(1175, 'دنبيشير', 'Denbighshire', 'X9', 'not_used', NULL, 71),
(1176, 'شرق ركوب يوركشاير', 'East Riding of Yorkshire', 'E1', 'not_used', NULL, 71),
(1177, 'بيكسلي', 'Bexley', 'A6', 'not_used', NULL, 71),
(1178, 'بروملي', 'Bromley', 'B8', 'not_used', NULL, 71),
(1179, 'برادفورد', 'Bradford', 'B4', 'not_used', NULL, 71),
(1180, 'غابة براكنيل', 'Bracknell Forest', 'B3', 'not_used', NULL, 71),
(1181, 'كارديف', 'Cardiff', 'X5', 'not_used', NULL, 71),
(1182, 'برمنغهام', 'Birmingham', 'A7', 'not_used', NULL, 71),
(1183, 'أوركني', 'Orkney', 'V9', 'not_used', NULL, 71),
(1184, 'شرق دانبارتونشاير', 'East Dunbartonshire', 'U5', 'not_used', NULL, 71),
(1185, 'بلاكبول', 'Blackpool', 'A9', 'not_used', NULL, 71),
(1186, 'ساوثامبتون', 'Southampton', 'M4', 'not_used', NULL, 71),
(1187, 'نيوكاسل أبون تاين', 'Newcastle upon Tyne', 'I7', 'not_used', NULL, 71),
(1188, 'بولتون', 'Bolton', 'B1', 'not_used', NULL, 71),
(1189, 'ريدكار وكليفلاند', 'Redcar and Cleveland', 'K9', 'not_used', NULL, 71),
(1190, 'بورنموث', 'Bournemouth', 'B2', 'not_used', NULL, 71),
(1191, 'سويندون', 'Swindon', 'N9', 'not_used', NULL, 71),
(1192, 'ستوكبورت', 'Stockport', 'N2', 'not_used', NULL, 71),
(1193, 'وندسور ومايدنهيد', 'Windsor and Maidenhead', 'P9', 'not_used', NULL, 71),
(1194, 'إنفركلايد', 'Inverclyde', 'V4', 'not_used', NULL, 71),
(1195, 'ميدواي', 'Medway', 'I3', 'not_used', NULL, 71),
(1196, 'ميلتون كينز', 'Milton Keynes', 'I6', 'not_used', NULL, 71),
(1197, 'دندي سيتي', 'Dundee City', 'U3', 'not_used', NULL, 71),
(1198, 'تيلفورد وركين', 'Telford and Wrekin', 'O2', 'not_used', NULL, 71),
(1199, 'قراءة', 'Reading', 'K7', 'not_used', NULL, 71),
(1200, 'دفن', 'Bury', 'C1', 'not_used', NULL, 71),
(1201, 'ولفرهامبتون', 'Wolverhampton', 'Q3', 'not_used', NULL, 71),
(1202, 'ساوثوورك', 'Southwark', 'M8', 'not_used', NULL, 71),
(1203, 'كامدن', 'Camden', 'C4', 'not_used', NULL, 71),
(1204, 'مستنقع', 'Slough', 'M1', 'not_used', NULL, 71),
(1205, 'ميدلسبره', 'Middlesbrough', 'I5', 'not_used', NULL, 71),
(1206, 'ستوكتون أون تيز', 'Stockton-on-Tees', 'N3', 'not_used', NULL, 71),
(1207, 'نيوتاونبي', 'Newtownabbey', 'T1', 'not_used', NULL, 71),
(1208, 'يسبورن', 'Lisburn', 'S5', 'not_used', NULL, 71),
(1210, 'ويشام', 'Lewisham', 'H6', 'not_used', NULL, 71),
(1211, 'غرب بيركشاير', 'West Berkshire', 'P4', 'not_used', NULL, 71),
(1212, 'مانشستر', 'Manchester', 'I2', 'not_used', NULL, 71),
(1213, 'وستمنستر', 'Westminster', 'P5', 'not_used', NULL, 71),
(1214, 'أردز', 'Ards', 'Q7', 'not_used', NULL, 71),
(1215, 'بليموث', 'Plymouth', 'K4', 'not_used', NULL, 71),
(1216, 'كرويدون', 'Croydon', 'C8', 'not_used', NULL, 71),
(1217, 'باركينج وداجنهام', 'Barking and Dagenham', 'A1', 'not_used', NULL, 71),
(1218, 'هارتلبول', 'Hartlepool', 'F5', 'not_used', NULL, 71),
(1219, 'شيفيلد', 'Sheffield', 'L9', 'not_used', NULL, 71),
(1220, 'أولدهام', 'Oldham', 'K1', 'not_used', NULL, 71),
(1221, 'نوزلي', 'Knowsley', 'G9', 'not_used', NULL, 71),
(1222, 'ليفربول', 'Liverpool', 'H8', 'not_used', NULL, 71),
(1223, 'دادلي', 'Dudley', 'D7', 'not_used', NULL, 71),
(1224, 'غيتسهيد', 'Gateshead', 'E5', 'not_used', NULL, 71),
(1225, 'إيلينغ', 'Ealing', 'D9', 'not_used', NULL, 71),
(1226, 'ادنبره', 'Edinburgh', 'U8', 'not_used', NULL, 71),
(1227, 'انفيلد', 'Enfield', 'E3', 'not_used', NULL, 71),
(1228, 'كلدردل', 'Calderdale', 'C2', 'not_used', NULL, 71),
(1229, 'وقف على', 'Halton', 'E9', 'not_used', NULL, 71),
(1230, 'شمال تينيسايد', 'North Tyneside', 'J5', 'not_used', NULL, 71),
(1231, 'ثوروك', 'Thurrock', 'O3', 'not_used', NULL, 71),
(1232, 'شمال شرق لينكولنشاير', 'North East Lincolnshire', 'J2', 'not_used', NULL, 71),
(1233, 'يرل', 'Wirral', 'Q1', 'not_used', NULL, 71),
(1234, 'بتذلل', 'Hackney', 'E8', 'not_used', NULL, 71),
(1235, 'هامرسميث وفولهام', 'Hammersmith and Fulham', 'F1', 'not_used', NULL, 71),
(1236, 'هافرينج', 'Havering', 'F6', 'not_used', NULL, 71),
(1237, 'مسلفة', 'Harrow', 'F4', 'not_used', NULL, 71),
(1238, 'بارنيت', 'Barnet', 'A2', 'not_used', NULL, 71),
(1239, 'هونسلو', 'Hounslow', 'G1', 'not_used', NULL, 71),
(1240, 'برايتون وهوف', 'Brighton and Hove', 'B6', 'not_used', NULL, 71),
(1241, 'كينغستون على هال', 'Kingston upon Hull', 'G6', 'not_used', NULL, 71),
(1242, 'ريدبريدج', 'Redbridge', 'K8', 'not_used', NULL, 71),
(1243, 'إزلينغتون', 'Islington', 'G3', 'not_used', NULL, 71),
(1244, 'كنسينغتون وتشيلسي', 'Kensington and Chelsea', 'G4', 'not_used', NULL, 71),
(1245, 'كينغستون أبون تيمز', 'Kingston upon Thames', 'G7', 'not_used', NULL, 71),
(1246, 'لامبث', 'Lambeth', 'H1', 'not_used', NULL, 71),
(1247, 'لندن', 'London', 'H9', 'not_used', NULL, 71),
(1248, 'لوتون', 'Luton', 'I1', 'not_used', NULL, 71),
(1249, 'سندرلاند', 'Sunderland', 'N6', 'not_used', NULL, 71),
(1250, 'ميرتون', 'Merton', 'I4', 'not_used', NULL, 71),
(1251, 'ساندويل', 'Sandwell', 'L7', 'not_used', NULL, 71),
(1252, 'سالفورد', 'Salford', 'L5', 'not_used', NULL, 71),
(1253, 'بيتربورو', 'Peterborough', 'K3', 'not_used', NULL, 71),
(1254, 'بول', 'Poole', 'K5', 'not_used', NULL, 71),
(1255, 'برج هامليتس', 'Tower Hamlets', 'O5', 'not_used', NULL, 71),
(1256, 'بورتسموث', 'Portsmouth', 'K6', 'not_used', NULL, 71),
(1257, 'روتشديل', 'Rochdale', 'L2', 'not_used', NULL, 71),
(1258, 'غرينتش', 'Greenwich', 'E7', 'not_used', NULL, 71),
(1259, 'جنوب تينيسايد', 'South Tyneside', 'M7', 'not_used', NULL, 71),
(1260, 'ترافورد', 'Trafford', 'O6', 'not_used', NULL, 71),
(1261, 'ساتون', 'Sutton', 'N8', 'not_used', NULL, 71),
(1262, 'تورباي', 'Torbay', 'O4', 'not_used', NULL, 71),
(1263, 'ريتشموند على نهر التايمز', 'Richmond upon Thames', 'L1', 'not_used', NULL, 71),
(1264, 'هيلينغدون', 'Hillingdon', 'F9', 'not_used', NULL, 71),
(1265, 'ويكفيلد', 'Wakefield', 'O7', 'not_used', NULL, 71),
(1266, 'والثام فوريست', 'Waltham Forest', 'O9', 'not_used', NULL, 71),
(1267, 'اندسوورث', 'Wandsworth', 'P1', 'not_used', NULL, 71),
(1268, 'برنت', 'Brent', 'B5', 'not_used', NULL, 71),
(1269, 'هارينجي', 'Haringey', 'F3', 'not_used', NULL, 71),
(1270, 'القديس أندرو', 'Saint Andrew', '01', 'not_used', NULL, 72),
(1271, 'القديس جورج', 'Saint George', '03', 'not_used', NULL, 72),
(1272, 'القديس داود', 'Saint David', '02', 'not_used', NULL, 72),
(1273, 'سانت باتريك', 'Saint Patrick', '06', 'not_used', NULL, 72),
(1274, 'سان مارك', 'Saint Mark', '05', 'not_used', NULL, 72),
(1275, 'القديس يوحنا', 'Saint John', '04', 'not_used', NULL, 72),
(1276, 'أبخازيا', 'Abkhazia', '02', 'not_used', NULL, 73),
(1277, 'Ninotsmindis Raioni', 'Ninotsmindis Raioni', '39', 'not_used', NULL, 73),
(1278, 'P\'ot\'i', 'P\'ot\'i', '42', 'not_used', NULL, 73),
(1279, 'Ambrolauris Raioni', 'Ambrolauris Raioni', '09', 'not_used', NULL, 73),
(1280, 'اباشي ريوني', 'Abashis Raioni', '01', 'not_used', NULL, 73),
(1281, 'أخالتسميس ريوني', 'Akhalts\'ikhis Raioni', '07', 'not_used', NULL, 73),
(1282, 'زيستابونيس ريوني', 'Zestap\'onis Raioni', '62', 'not_used', NULL, 73),
(1283, 'تسالينججيريس ريوني', 'Tsalenjikhis Raioni', '58', 'not_used', NULL, 73),
(1284, 'مارنوليس رايوني', 'Marneulis Raioni', '35', 'not_used', NULL, 73),
(1285, 'جوريس رايوني', 'Goris Raioni', '22', 'not_used', NULL, 73),
(1286, 'كاريسليز ريوني', 'K\'arelis Raioni', '25', 'not_used', NULL, 73),
(1287, 'خاشوريس رايوني', 'Khashuris Raioni', '28', 'not_used', NULL, 73),
(1288, 'كاسبيس رايونى', 'Kaspis Raioni', '26', 'not_used', NULL, 73),
(1289, 'أجاريا', 'Ajaria', '04', 'not_used', NULL, 73),
(1290, 'متخيسيس ريوني', 'Mts\'khet\'is Raioni', '38', 'not_used', NULL, 73),
(1291, 'Ch\'okhatauris Raioni', 'Ch\'okhatauris Raioni', '16', 'not_used', NULL, 73),
(1292, 'Akhalk\'alak\'is Raioni', 'Akhalk\'alak\'is Raioni', '06', 'not_used', NULL, 73),
(1293, 'Samtrediis Raioni', 'Samtrediis Raioni', '48', 'not_used', NULL, 73),
(1294, 'Tqibuli', 'Tqibuli', '56', 'not_used', NULL, 73),
(1295, 'Dushet\'is Raioni', 'Dushet\'is Raioni', '19', 'not_used', NULL, 73),
(1296, 'أونيس رايوني', 'Onis Raioni', '40', 'not_used', NULL, 73),
(1297, 'Lentekhis Raioni', 'Lentekhis Raioni', '34', 'not_used', NULL, 73),
(1298, 'مارتفيليز ريوني', 'Martvilis Raioni', '36', 'not_used', NULL, 73),
(1299, 'K\'ut\'aisi', 'K\'ut\'aisi', '31', 'not_used', NULL, 73),
(1300, 'أخالورجيس رايوني', 'Akhalgoris Raioni', '05', 'not_used', NULL, 73),
(1301, 'Aspindzis Raioni', 'Aspindzis Raioni', '10', 'not_used', NULL, 73),
(1302, 'احمدى ريونى', 'Akhmetis Raioni', '08', 'not_used', NULL, 73),
(1303, 'Lagodekhis Raioni', 'Lagodekhis Raioni', '32', 'not_used', NULL, 73),
(1304, 'Zugdidis Raioni', 'Zugdidis Raioni', '64', 'not_used', NULL, 73),
(1305, 'بورجوميس رايوني', 'Borjomis Raioni', '13', 'not_used', NULL, 73),
(1306, 'T\'ianet\'is Raioni', 'T\'ianet\'is Raioni', '55', 'not_used', NULL, 73),
(1307, 'خبيص الريوني', 'Khobis Raioni', '29', 'not_used', NULL, 73),
(1308, 'Kharagaulis Raioni', 'Kharagaulis Raioni', '27', 'not_used', NULL, 73),
(1309, 'فانيس ريوني', 'Vanis Raioni', '61', 'not_used', NULL, 73),
(1310, 'تيلافيس ريوني', 'T\'elavis Raioni', '52', 'not_used', NULL, 73),
(1311, 'تسالكيس رايوني', 'Tsalkis Raioni', '59', 'not_used', NULL, 73),
(1312, 'قزبيجايز ريوني', 'Qazbegis Raioni', '43', 'not_used', NULL, 73),
(1313, 'ساجاريجوس رايوني', 'Sagarejos Raioni', '47', 'not_used', NULL, 73),
(1314, 'تيريتسقاروس ريوني', 'T\'et\'ritsqaros Raioni', '54', 'not_used', NULL, 73),
(1315, 'Dedop\'listsqaros Raioni', 'Dedop\'listsqaros Raioni', '17', 'not_used', NULL, 73),
(1316, 'جافي ريوني', 'Javis Raioni', '24', 'not_used', NULL, 73),
(1317, 'Ch\'khorotsqus Raioni', 'Ch\'khorotsqus Raioni', '15', 'not_used', NULL, 73),
(1318, 'Tsqaltubo', 'Tsqaltubo', '60', 'not_used', NULL, 73),
(1319, 'Rust\'avi', 'Rust\'avi', '45', 'not_used', NULL, 73),
(1320, 'تبليسي', 'T\'bilisi', '51', 'not_used', NULL, 73),
(1321, 'بغدايس الريوني', 'Baghdat\'is Raioni', '11', 'not_used', NULL, 73),
(1322, 'Lanch\'khut\'is Raioni', 'Lanch\'khut\'is Raioni', '33', 'not_used', NULL, 73),
(1323, 'Chiat\'ura', 'Chiat\'ura', '14', 'not_used', NULL, 73),
(1324, 'Ts\'ageris Raioni', 'Ts\'ageris Raioni', '57', 'not_used', NULL, 73),
(1327, 'وسط', 'Central', '04', 'not_used', NULL, 76),
(1328, 'الغربي', 'Western', '09', 'not_used', NULL, 76),
(1329, 'أشانتي', 'Ashanti', '02', 'not_used', NULL, 76),
(1330, 'الشرق الأوسط', 'Upper East', '10', 'not_used', NULL, 76),
(1331, 'فولتا', 'Volta', '08', 'not_used', NULL, 76),
(1332, 'برونغ أهافو', 'Brong-Ahafo', '03', 'not_used', NULL, 76),
(1333, 'شمالي', 'Northern', '06', 'not_used', NULL, 76),
(1334, 'أكبر أكرا', 'Greater Accra', '01', 'not_used', NULL, 76),
(1335, 'أعالي الغرب', 'Upper West', '11', 'not_used', NULL, 76),
(1336, 'الشرقية', 'Eastern', '05', 'not_used', NULL, 76),
(1338, 'Vestgronland', 'Vestgronland', '03', 'not_used', NULL, 78),
(1339, 'Nordgronland', 'Nordgronland', '01', 'not_used', NULL, 78),
(1340, 'Ostgronland', 'Ostgronland', '02', 'not_used', NULL, 78),
(1341, 'سنترال ريفر', 'Central River', '03', 'not_used', NULL, 79),
(1342, 'الغربي', 'Western', '05', 'not_used', NULL, 79),
(1343, 'الضفة الشمالية', 'North Bank', '07', 'not_used', NULL, 79),
(1344, 'أعالي النهر', 'Upper River', '04', 'not_used', NULL, 79),
(1345, 'نهر سفلي', 'Lower River', '02', 'not_used', NULL, 79),
(1346, 'بانجول', 'Banjul', '01', 'not_used', NULL, 79),
(1347, 'كوروسا', 'Kouroussa', '19', 'not_used', NULL, 80),
(1348, 'بيلا', 'Beyla', '01', 'not_used', NULL, 80),
(1349, 'كوندارا', 'Koundara', '18', 'not_used', NULL, 80),
(1350, 'دنجواياري', 'Dinguiraye', '07', 'not_used', NULL, 80),
(1351, 'مالي', 'Mali', '22', 'not_used', NULL, 80),
(1352, 'ماكنتا', 'Macenta', '21', 'not_used', NULL, 80),
(1355, 'كيسيدوغو', 'Kissidougou', '17', 'not_used', NULL, 80),
(1356, 'فوريكاريا', 'Forecariah', '10', 'not_used', NULL, 80),
(1357, 'بيتا', 'Pita', '25', 'not_used', NULL, 80),
(1361, 'دابولا', 'Dabola', '05', 'not_used', NULL, 80),
(1362, 'بوكي', 'Boke', '03', 'not_used', NULL, 80),
(1363, 'مامو', 'Mamou', '23', 'not_used', NULL, 80),
(1364, 'فاراناه', 'Faranah', '09', 'not_used', NULL, 80),
(1365, 'تليملي', 'Telimele', '27', 'not_used', NULL, 80),
(1366, 'بوفا', 'Boffa', '02', 'not_used', NULL, 80),
(1367, 'جوكيدو', 'Gueckedou', '13', 'not_used', NULL, 80),
(1368, 'كنديا', 'Kindia', '16', 'not_used', NULL, 80),
(1369, 'فريا', 'Fria', '11', 'not_used', NULL, 80),
(1370, 'تواج', 'Tougue', '28', 'not_used', NULL, 80),
(1371, 'يومو', 'Yomou', '29', 'not_used', NULL, 80),
(1372, 'جاوال', 'Gaoual', '12', 'not_used', NULL, 80),
(1373, 'كيروان', 'Kerouane', '15', 'not_used', NULL, 80),
(1374, 'دالابا', 'Dalaba', '06', 'not_used', NULL, 80),
(1375, 'كوناكري', 'Conakry', '04', 'not_used', NULL, 80),
(1376, 'كويا', 'Coyah', '30', 'not_used', NULL, 80),
(1377, 'دوبريكا', 'Dubreka', '31', 'not_used', NULL, 80),
(1378, 'كانكان', 'Kankan', '32', 'not_used', NULL, 80),
(1379, 'كوبيا', 'Koubia', '33', 'not_used', NULL, 80),
(1380, 'ابي', 'Labe', '34', 'not_used', NULL, 80),
(1381, 'يلوما', 'Lelouma', '35', 'not_used', NULL, 80),
(1382, 'لولا', 'Lola', '36', 'not_used', NULL, 80),
(1383, 'مانديانا', 'Mandiana', '37', 'not_used', NULL, 80),
(1384, 'نزيريكوري', 'Nzerekore', '38', 'not_used', NULL, 80),
(1385, 'سيجويري', 'Siguiri', '39', 'not_used', NULL, 80),
(1387, 'سنترو سور', 'Centro Sur', '06', 'not_used', NULL, 82),
(1388, 'ويلي-نزاس', 'Wele-Nzas', '09', 'not_used', NULL, 82),
(1389, 'كي نتيم', 'Kie-Ntem', '07', 'not_used', NULL, 82),
(1390, 'الساحلي', 'Litoral', '08', 'not_used', NULL, 82),
(1391, 'أنوبون', 'Annobon', '03', 'not_used', NULL, 82),
(1392, 'بيوكو نورتي', 'Bioko Norte', '04', 'not_used', NULL, 82),
(1393, 'بيوكو سور', 'Bioko Sur', '05', 'not_used', NULL, 82),
(1395, 'كيلكيس', 'Kilkis', '06', 'not_used', NULL, 83),
(1396, 'لاريسا', 'Larisa', '21', 'not_used', NULL, 83),
(1397, 'أتيكي', 'Attiki', '35', 'not_used', NULL, 83),
(1398, 'تريكالا', 'Trikala', '22', 'not_used', NULL, 83),
(1399, 'بريفيزا', 'Preveza', '19', 'not_used', NULL, 83),
(1400, 'Kerkira', 'Kerkira', '25', 'not_used', NULL, 83),
(1401, 'وانينا', 'Ioannina', '17', 'not_used', NULL, 83),
(1402, 'بيلا', 'Pella', '07', 'not_used', NULL, 83),
(1403, 'سالونيك', 'Thessaloniki', '13', 'not_used', NULL, 83),
(1404, 'Voiotia', 'Voiotia', '33', 'not_used', NULL, 83),
(1405, 'Kikladhes', 'Kikladhes', '49', 'not_used', NULL, 83),
(1406, 'كافالا', 'Kavala', '14', 'not_used', NULL, 83),
(1407, 'أرغوليس', 'Argolis', '36', 'not_used', NULL, 83),
(1408, 'Rethimni', 'Rethimni', '44', 'not_used', NULL, 83),
(1409, 'سيراي', 'Serrai', '05', 'not_used', NULL, 83),
(1410, 'اكونيا', 'Lakonia', '42', 'not_used', NULL, 83),
(1411, 'ايراكليون', 'Iraklion', '45', 'not_used', NULL, 83),
(1412, 'اسيتي', 'Lasithi', '46', 'not_used', NULL, 83),
(1413, 'Rodhopi', 'Rodhopi', '02', 'not_used', NULL, 83),
(1414, 'دراما', 'Drama', '04', 'not_used', NULL, 83),
(1415, 'ميسينيا', 'Messinia', '40', 'not_used', NULL, 83),
(1416, 'إيفويا', 'Evvoia', '34', 'not_used', NULL, 83),
(1417, 'Akhaia', 'Akhaia', '38', 'not_used', NULL, 83),
(1418, 'ماغنيزيا', 'Magnisia', '24', 'not_used', NULL, 83),
(1419, 'خانيا', 'Khania', '43', 'not_used', NULL, 83),
(1420, 'Kardhitsa', 'Kardhitsa', '23', 'not_used', NULL, 83),
(1421, 'إفروس', 'Evros', '01', 'not_used', NULL, 83),
(1422, 'Arkadhia', 'Arkadhia', '41', 'not_used', NULL, 83),
(1423, 'أيتوليا كاي Akarnania', 'Aitolia kai Akarnania', '31', 'not_used', NULL, 83),
(1424, 'كوزاني', 'Kozani', '11', 'not_used', NULL, 83),
(1425, 'ثريبروتيا', 'Thesprotia', '18', 'not_used', NULL, 83),
(1426, 'يسفوس', 'Lesvos', '51', 'not_used', NULL, 83),
(1427, 'Dhodhekanisos', 'Dhodhekanisos', '47', 'not_used', NULL, 83),
(1428, 'كيفالونيا', 'Kefallinia', '27', 'not_used', NULL, 83),
(1429, 'Khios', 'Khios', '50', 'not_used', NULL, 83),
(1430, 'أرتا', 'Arta', '20', 'not_used', NULL, 83),
(1431, 'غريفينا', 'Grevena', '10', 'not_used', NULL, 83),
(1432, 'زاكينثوس', 'Zakinthos', '28', 'not_used', NULL, 83),
(1433, 'Evritania', 'Evritania', '30', 'not_used', NULL, 83),
(1434, 'فثيوتيس', 'Fthiotis', '29', 'not_used', NULL, 83),
(1435, 'كاستوريا', 'Kastoria', '09', 'not_used', NULL, 83),
(1436, 'ساموس', 'Samos', '48', 'not_used', NULL, 83),
(1437, 'إيماثيا', 'Imathia', '12', 'not_used', NULL, 83),
(1438, 'فلورينا', 'Florina', '08', 'not_used', NULL, 83),
(1439, 'بييريا', 'Pieria', '16', 'not_used', NULL, 83),
(1440, 'Levkas', 'Levkas', '26', 'not_used', NULL, 83),
(1441, 'فوكيس', 'Fokis', '32', 'not_used', NULL, 83),
(1442, 'إليا', 'Ilia', '39', 'not_used', NULL, 83),
(1443, 'كورينثيا', 'Korinthia', '37', 'not_used', NULL, 83),
(1444, 'كسانتي', 'Xanthi', '03', 'not_used', NULL, 83),
(1445, 'Khalkidhiki', 'Khalkidhiki', '15', 'not_used', NULL, 83),
(1448, 'ايزابال', 'Izabal', '09', 'not_used', NULL, 85),
(1449, 'ألتا فيراباس', 'Alta Verapaz', '01', 'not_used', NULL, 85),
(1450, 'ريتالهوليو', 'Retalhuleu', '15', 'not_used', NULL, 85),
(1451, 'البروغريسو', 'El Progreso', '05', 'not_used', NULL, 85),
(1452, 'غواتيمالا', 'Guatemala', '07', 'not_used', NULL, 85),
(1453, 'جوتيابا', 'Jutiapa', '11', 'not_used', NULL, 85),
(1454, 'تشيمالتنانغو', 'Chimaltenango', '03', 'not_used', NULL, 85),
(1455, 'شيكيمولا', 'Chiquimula', '04', 'not_used', NULL, 85),
(1456, 'زاكابا', 'Zacapa', '22', 'not_used', NULL, 85),
(1457, 'جالابا', 'Jalapa', '10', 'not_used', NULL, 85),
(1458, 'سان ماركوس', 'San Marcos', '17', 'not_used', NULL, 85),
(1459, 'كيشي', 'Quiche', '14', 'not_used', NULL, 85),
(1460, 'هوهوتنانغو', 'Huehuetenango', '08', 'not_used', NULL, 85),
(1461, 'كويتزالتنانغو', 'Quetzaltenango', '13', 'not_used', NULL, 85),
(1462, 'باجا فيراباز', 'Baja Verapaz', '02', 'not_used', NULL, 85),
(1463, 'سانتا روزا', 'Santa Rosa', '18', 'not_used', NULL, 85),
(1464, 'سولولا', 'Solola', '19', 'not_used', NULL, 85),
(1465, 'بيتين', 'Peten', '12', 'not_used', NULL, 85),
(1466, 'ايسكوينتلا', 'Escuintla', '06', 'not_used', NULL, 85),
(1467, 'سكاتيبيكيز', 'Sacatepequez', '16', 'not_used', NULL, 85),
(1468, 'توتونيكابان', 'Totonicapan', '21', 'not_used', NULL, 85),
(1469, 'سوشيتبيكيز', 'Suchitepequez', '20', 'not_used', NULL, 85),
(1470, 'كاشيو', 'Cacheu', '06', 'not_used', NULL, 86),
(1471, 'بومبو', 'Biombo', '12', 'not_used', NULL, 86),
(1472, 'أويو', 'Oio', '04', 'not_used', NULL, 86),
(1473, 'بيساو', 'Bissau', '11', 'not_used', NULL, 86),
(1474, 'بافاتا', 'Bafata', '01', 'not_used', NULL, 86),
(1475, 'تومبالي', 'Tombali', '07', 'not_used', NULL, 86),
(1476, 'غابو', 'Gabu', '10', 'not_used', NULL, 86),
(1477, 'بولاما', 'Bolama', '05', 'not_used', NULL, 86),
(1478, 'كينارا', 'Quinara', '02', 'not_used', NULL, 86),
(1479, 'ماهايكا بيبريس', 'Mahaica-Berbice', '15', 'not_used', NULL, 87),
(1480, 'Upper Takutu-Upper Essequibo', 'Upper Takutu-Upper Essequibo', '19', 'not_used', NULL, 87),
(1481, 'باريما وايني', 'Barima-Waini', '10', 'not_used', NULL, 87),
(1482, 'بومرون سوبينام', 'Pomeroon-Supenaam', '16', 'not_used', NULL, 87),
(1483, 'ديميرارا ماهايكا', 'Demerara-Mahaica', '12', 'not_used', NULL, 87),
(1484, 'جويوني مزروني', 'Cuyuni-Mazaruni', '11', 'not_used', NULL, 87),
(1485, 'شرق بيربيس-كورنتي', 'East Berbice-Corentyne', '13', 'not_used', NULL, 87),
(1486, 'Essequibo Islands-West Demerara', 'Essequibo Islands-West Demerara', '14', 'not_used', NULL, 87),
(1487, 'بوتارو سيباروني', 'Potaro-Siparuni', '17', 'not_used', NULL, 87),
(1488, 'Upper Demerara-Berbice', 'Upper Demerara-Berbice', '18', 'not_used', NULL, 87),
(1490, 'القولون', 'Colon', '03', 'not_used', NULL, 89),
(1491, 'تشولوتيكا', 'Choluteca', '02', 'not_used', NULL, 89),
(1492, 'كوماياغوا', 'Comayagua', '04', 'not_used', NULL, 89),
(1493, 'فالي', 'Valle', '17', 'not_used', NULL, 89),
(1494, 'سانتا باربارا', 'Santa Barbara', '16', 'not_used', NULL, 89),
(1495, 'فرانسيسكو مورازان', 'Francisco Morazan', '08', 'not_used', NULL, 89),
(1496, 'الباريسو', 'El Paraiso', '07', 'not_used', NULL, 89),
(1497, 'هندوراسي', 'Lempira', '13', 'not_used', NULL, 89),
(1498, 'كوبان', 'Copan', '05', 'not_used', NULL, 89),
(1499, 'اولانجو', 'Olancho', '15', 'not_used', NULL, 89),
(1500, 'كورتيس', 'Cortes', '06', 'not_used', NULL, 89),
(1501, 'يورو', 'Yoro', '18', 'not_used', NULL, 89),
(1502, 'أتلانتيدا', 'Atlantida', '01', 'not_used', NULL, 89),
(1503, 'Intibuca', 'Intibuca', '10', 'not_used', NULL, 89),
(1504, 'لاباز', 'La Paz', '12', 'not_used', NULL, 89),
(1505, 'أوكوتبيك', 'Ocotepeque', '14', 'not_used', NULL, 89),
(1506, 'جراسياس ديوس', 'Gracias a Dios', '09', 'not_used', NULL, 89),
(1507, 'ايسلاس دي لا باهيا', 'Islas de la Bahia', '11', 'not_used', NULL, 89),
(1508, 'بريمورسكو غورانسكا', 'Primorsko-Goranska', '12', 'not_used', NULL, 90),
(1509, 'سبليتسكو دالماتينسكا', 'Splitsko-Dalmatinska', '15', 'not_used', NULL, 90),
(1510, 'Istarska', 'Istarska', '04', 'not_used', NULL, 90),
(1511, 'أوسيجيكو', 'Osjecko-Baranjska', '10', 'not_used', NULL, 90),
(1512, 'فيروفيتيكو-بودرافسكا', 'Viroviticko-Podravska', '17', 'not_used', NULL, 90),
(1513, 'غراد زغرب', 'Grad Zagreb', '21', 'not_used', NULL, 90),
(1514, 'سيساكو موسلافاكا', 'Sisacko-Moslavacka', '14', 'not_used', NULL, 90),
(1515, 'ليكو سنجسكا', 'Licko-Senjska', '08', 'not_used', NULL, 90),
(1516, 'برودسكو بوسافسكا', 'Brodsko-Posavska', '02', 'not_used', NULL, 90),
(1517, 'دوبروفنيك نيريتفا', 'Dubrovacko-Neretvanska', '03', 'not_used', NULL, 90),
(1518, 'بوزيسكو-سلافونسكا', 'Pozesko-Slavonska', '11', 'not_used', NULL, 90),
(1519, 'زاجريباكا', 'Zagrebacka', '20', 'not_used', NULL, 90),
(1520, 'بجيلوفارسكو بيلوجوورسكا', 'Bjelovarsko-Bilogorska', '01', 'not_used', NULL, 90),
(1521, 'فارازدينسكا', 'Varazdinska', '16', 'not_used', NULL, 90),
(1522, 'فوكوفارسكو سريمسكا', 'Vukovarsko-Srijemska', '18', 'not_used', NULL, 90),
(1523, 'كاربينسكو زاجورسكا', 'Krapinsko-Zagorska', '07', 'not_used', NULL, 90),
(1524, 'كوبرفنيكو كريزفاكا', 'Koprivnicko-Krizevacka', '06', 'not_used', NULL, 90),
(1525, 'كارلوفاكا', 'Karlovacka', '05', 'not_used', NULL, 90),
(1526, 'سيبينسكو كنينسكا', 'Sibensko-Kninska', '13', 'not_used', NULL, 90),
(1527, 'ميديمرسكا', 'Medimurska', '09', 'not_used', NULL, 90),
(1529, 'سود', 'Sud', '12', 'not_used', NULL, 91),
(1530, 'مركز', 'Centre', '07', 'not_used', NULL, 91),
(1532, 'كويست', 'Ouest', '11', 'not_used', NULL, 91),
(1533, 'نورد', 'Nord', '09', 'not_used', NULL, 91),
(1534, 'الإقليم الشمالي الغربي', 'Nord-Ouest', '03', 'not_used', NULL, 91),
(1535, 'الشمال الشرقي', 'Nord-Est', '10', 'not_used', NULL, 91),
(1536, 'الجنوب الشرقي', 'Sud-Est', '13', 'not_used', NULL, 91),
(1537, 'أرتيبونيت', 'Artibonite', '06', 'not_used', NULL, 91),
(1538, 'كومارم إسترجم', 'Komarom-Esztergom', '12', 'not_used', NULL, 92),
(1539, 'فيجر', 'Fejer', '08', 'not_used', NULL, 92),
(1540, 'جاز ناجيكن سزولنوك', 'Jasz-Nagykun-Szolnok', '20', 'not_used', NULL, 92),
(1541, 'بارانيا', 'Baranya', '02', 'not_used', NULL, 92),
(1542, 'سزابولكس زاتمار بيريج', 'Szabolcs-Szatmar-Bereg', '18', 'not_used', NULL, 92),
(1543, 'هيفيز', 'Heves', '11', 'not_used', NULL, 92),
(1544, 'بورسود أباوج زمبلين', 'Borsod-Abauj-Zemplen', '04', 'not_used', NULL, 92),
(1545, 'جيور موسون سوبرون', 'Gyor-Moson-Sopron', '09', 'not_used', NULL, 92),
(1546, 'الآفات', 'Pest', '16', 'not_used', NULL, 92),
(1547, 'فيزبرم', 'Veszprem', '23', 'not_used', NULL, 92),
(1548, 'البكالوريا كيسكون', 'Bacs-Kiskun', '01', 'not_used', NULL, 92),
(1549, 'خدمات القيمة المضافة', 'Vas', '22', 'not_used', NULL, 92),
(1550, 'هاجدو بيهار', 'Hajdu-Bihar', '10', 'not_used', NULL, 92),
(1551, 'زالة', 'Zala', '24', 'not_used', NULL, 92),
(1552, 'سوموغي', 'Somogy', '17', 'not_used', NULL, 92),
(1553, 'تولنا', 'Tolna', '21', 'not_used', NULL, 92),
(1554, 'نوجراد', 'Nograd', '14', 'not_used', NULL, 92),
(1555, 'بودابست', 'Budapest', '05', 'not_used', NULL, 92),
(1556, 'ميشكولتس', 'Miskolc', '13', 'not_used', NULL, 92),
(1557, 'كسونجراد', 'Csongrad', '06', 'not_used', NULL, 92),
(1558, 'ديبريسين', 'Debrecen', '07', 'not_used', NULL, 92),
(1559, 'بيكيس', 'Bekes', '03', 'not_used', NULL, 92),
(1560, 'سيجد', 'Szeged', '19', 'not_used', NULL, 92),
(1561, 'بيكس', 'Pecs', '15', 'not_used', NULL, 92),
(1562, 'جيور', 'Gyor', '25', 'not_used', NULL, 92),
(1563, 'جاوا تيمور', 'Jawa Timur', '08', 'not_used', NULL, 93),
(1565, 'سولاويزي تينجارا', 'Sulawesi Tenggara', '22', 'not_used', NULL, 93),
(1567, 'نوسا تينجارا تيمور', 'Nusa Tenggara Timur', '18', 'not_used', NULL, 93),
(1568, 'سولاويسي اوتارا', 'Sulawesi Utara', '31', 'not_used', NULL, 93),
(1569, 'سومطرة بارات', 'Sumatera Barat', '24', 'not_used', NULL, 93),
(1570, 'اتشيه', 'Aceh', '01', 'not_used', NULL, 93),
(1571, 'سولاويزي تنجاه', 'Sulawesi Tengah', '21', 'not_used', NULL, 93),
(1575, 'جاوا تينغاه', 'Jawa Tengah', '07', 'not_used', NULL, 93),
(1576, 'جاوا بارات', 'Jawa Barat', '30', 'not_used', NULL, 93),
(1577, 'بالي', 'Bali', '02', 'not_used', NULL, 93),
(1579, 'بانتين', 'Banten', '33', 'not_used', NULL, 93),
(1580, 'سومطرة اوتارا', 'Sumatera Utara', '26', 'not_used', NULL, 93),
(1581, 'كاليمانتان تيمور', 'Kalimantan Timur', '14', 'not_used', NULL, 93),
(1582, 'لامبونج', 'Lampung', '15', 'not_used', NULL, 93),
(1583, 'نوسا تينجارا بارات', 'Nusa Tenggara Barat', '17', 'not_used', NULL, 93),
(1584, 'كاليمانتان بارات', 'Kalimantan Barat', '11', 'not_used', NULL, 93),
(1585, 'كاليمنتان Tengah', 'Kalimantan Tengah', '13', 'not_used', NULL, 93),
(1587, 'بنجكولو', 'Bengkulu', '03', 'not_used', NULL, 93),
(1588, 'جامبي', 'Jambi', '05', 'not_used', NULL, 93),
(1589, 'كاليمانتان سيلاتان', 'Kalimantan Selatan', '12', 'not_used', NULL, 93),
(1590, 'يوجياكرتا', 'Yogyakarta', '10', 'not_used', NULL, 93),
(1591, 'جاكرتا رايا', 'Jakarta Raya', '04', 'not_used', NULL, 93),
(1593, 'مالوكو', 'Maluku', '28', 'not_used', NULL, 93),
(1594, 'غالواي', 'Galway', '10', 'not_used', NULL, 94),
(1595, 'فلين', 'Cork', '04', 'not_used', NULL, 94),
(1596, 'كيري', 'Kerry', '11', 'not_used', NULL, 94),
(1597, 'اللمريكية قصيدة خماسية فكاهية', 'Limerick', '16', 'not_used', NULL, 94),
(1598, 'لونجفورد', 'Longford', '18', 'not_used', NULL, 94),
(1599, 'اويس', 'Laois', '15', 'not_used', NULL, 94),
(1600, 'وترفورد', 'Waterford', '27', 'not_used', NULL, 94),
(1601, 'مايو', 'Mayo', '20', 'not_used', NULL, 94),
(1602, 'سليغو', 'Sligo', '25', 'not_used', NULL, 94),
(1603, 'كيلدير', 'Kildare', '12', 'not_used', NULL, 94),
(1604, 'دبلن', 'Dublin', '07', 'not_used', NULL, 94),
(1605, 'ويكلو', 'Wicklow', '31', 'not_used', NULL, 94),
(1606, 'كافان', 'Cavan', '02', 'not_used', NULL, 94),
(1607, 'كيلكيني', 'Kilkenny', '13', 'not_used', NULL, 94),
(1608, 'ويكسفورد', 'Wexford', '30', 'not_used', NULL, 94),
(1609, 'كارلو', 'Carlow', '01', 'not_used', NULL, 94),
(1610, 'أوفالي', 'Offaly', '23', 'not_used', NULL, 94),
(1611, 'موناغان', 'Monaghan', '22', 'not_used', NULL, 94),
(1612, 'يتريم', 'Leitrim', '14', 'not_used', NULL, 94),
(1613, 'كلير', 'Clare', '03', 'not_used', NULL, 94),
(1614, 'دونيجال', 'Donegal', '06', 'not_used', NULL, 94),
(1615, 'لاوث', 'Louth', '19', 'not_used', NULL, 94),
(1616, 'روسكومون', 'Roscommon', '24', 'not_used', NULL, 94),
(1617, 'تيبيراري', 'Tipperary', '26', 'not_used', NULL, 94),
(1618, 'ستميث', 'Westmeath', '29', 'not_used', NULL, 94),
(1619, 'ميث', 'Meath', '21', 'not_used', NULL, 94),
(1627, 'ولاية البنغال الغربية', 'West Bengal', '28', 'not_used', NULL, 96),
(1628, 'أوتار براديش', 'Uttar Pradesh', '36', 'not_used', NULL, 96),
(1629, 'البنجاب', 'Punjab', '23', 'not_used', NULL, 96),
(1630, 'ماديا براديش', 'Madhya Pradesh', '35', 'not_used', NULL, 96),
(1631, 'كارناتاكا', 'Karnataka', '19', 'not_used', NULL, 96),
(1632, 'ماهاراشترا', 'Maharashtra', '16', 'not_used', NULL, 96),
(1633, 'هاريانا', 'Haryana', '10', 'not_used', NULL, 96),
(1634, 'أوتارانتشال', 'Uttarakhand', '39', 'not_used', NULL, 96),
(1635, 'ولاية اندرا براديش', 'Andhra Pradesh', '02', 'not_used', NULL, 96),
(1636, 'تريبورا', 'Tripura', '26', 'not_used', NULL, 96),
(1637, 'تاميل نادو', 'Tamil Nadu', '25', 'not_used', NULL, 96),
(1638, 'جامو وكشمير', 'Jammu and Kashmir', '12', 'not_used', NULL, 96),
(1639, 'جزر أندامان ونيكوبار', 'Andaman and Nicobar Islands', '01', 'not_used', NULL, 96),
(1640, 'أسام', 'Assam', '03', 'not_used', NULL, 96),
(1641, 'تشهاتيسجاره', 'Chhattisgarh', '37', 'not_used', NULL, 96),
(1642, 'راجستان', 'Rajasthan', '24', 'not_used', NULL, 96),
(1643, 'غوا', 'Goa', '33', 'not_used', NULL, 96),
(1644, 'بودوتشيري', 'Puducherry', '22', 'not_used', NULL, 96),
(1645, 'غوجارات', 'Gujarat', '09', 'not_used', NULL, 96),
(1646, 'ولاية كيرالا', 'Kerala', '13', 'not_used', NULL, 96),
(1647, 'اروناتشال براديش', 'Arunachal Pradesh', '30', 'not_used', NULL, 96),
(1648, 'أوريسا', 'Orissa', '21', 'not_used', NULL, 96),
(1649, 'هيماشال براديش', 'Himachal Pradesh', '11', 'not_used', NULL, 96),
(1650, 'بيهار', 'Bihar', '34', 'not_used', NULL, 96),
(1651, 'ميغالايا', 'Meghalaya', '18', 'not_used', NULL, 96),
(1652, 'ناجالاند', 'Nagaland', '20', 'not_used', NULL, 96),
(1653, 'مانيبور', 'Manipur', '17', 'not_used', NULL, 96),
(1654, 'ميزورام', 'Mizoram', '31', 'not_used', NULL, 96),
(1655, 'جهارخاند', 'Jharkhand', '38', 'not_used', NULL, 96),
(1657, 'دلهي', 'Delhi', '07', 'not_used', NULL, 96),
(1658, 'دادرا وناغار هافيلي', 'Dadra and Nagar Haveli', '06', 'not_used', NULL, 96),
(1660, 'دامان وديو', 'Daman and Diu', '32', 'not_used', NULL, 96),
(1661, 'سيكيم', 'Sikkim', '29', 'not_used', NULL, 96),
(1662, 'شانديغار', 'Chandigarh', '05', 'not_used', NULL, 96),
(1663, 'اكشادويب', 'Lakshadweep', '14', 'not_used', NULL, 96),
(1664, 'السليمانية', 'As Sulaymaniyah', '05', 'not_used', NULL, 97),
(1665, 'ذي قار', 'Dhi Qar', '09', 'not_used', NULL, 97),
(1666, 'ميسان', 'Maysan', '14', 'not_used', NULL, 97),
(1667, 'ديالى', 'Diyala', '10', 'not_used', NULL, 97),
(1668, 'بغداد', 'Baghdad', '07', 'not_used', NULL, 97),
(1669, 'أكانت', 'Wasit', '16', 'not_used', NULL, 97),
(1670, 'صلاح الدين', 'Salah ad Din', '18', 'not_used', NULL, 97),
(1671, 'القادسية', 'Al Qadisiyah', '04', 'not_used', NULL, 97),
(1672, 'بابل', 'Babil', '06', 'not_used', NULL, 97),
(1673, 'كربلاء', 'Karbala\'', '12', 'not_used', NULL, 97),
(1674, 'النجف', 'An Najaf', '17', 'not_used', NULL, 97),
(1675, 'المثنى', 'Al Muthanna', '03', 'not_used', NULL, 97),
(1676, 'الانبار', 'Al Anbar', '01', 'not_used', NULL, 97),
(1677, 'دهوك', 'Dahuk', '08', 'not_used', NULL, 97),
(1678, 'نينوى', 'Ninawa', '15', 'not_used', NULL, 97),
(1679, 'اربيل', 'Arbil', '11', 'not_used', NULL, 97),
(1680, 'البصرة', 'Al Basrah', '02', 'not_used', NULL, 97),
(1681, 'في التميم', 'At Ta\'mim', '13', 'not_used', NULL, 97),
(1682, 'زنجان', 'Zanjan', '27', 'not_used', NULL, 98),
(1683, 'أزربايجان بختاري', 'Azarbayjan-e Bakhtari', '01', 'not_used', NULL, 98),
(1684, 'يزد', 'Yazd', '31', 'not_used', NULL, 98),
(1685, 'خوزستان', 'Khuzestan', '15', 'not_used', NULL, 98),
(1686, 'أصفهان', 'Esfahan', '28', 'not_used', NULL, 98),
(1687, 'أردبيل', 'Ardabil', '32', 'not_used', NULL, 98),
(1688, 'طهران', 'Tehran', '26', 'not_used', NULL, 98),
(1689, 'شرق ازربايجان', 'East Azarbaijan', '33', 'not_used', NULL, 98),
(1690, 'بوشهر', 'Bushehr', '22', 'not_used', NULL, 98),
(1691, 'هرمزكان', 'Hormozgan', '11', 'not_used', NULL, 98),
(1692, 'مازندران', 'Mazandaran', '17', 'not_used', NULL, 98),
(1693, 'كرمان', 'Kerman', '29', 'not_used', NULL, 98),
(1694, 'فارس', 'Fars', '07', 'not_used', NULL, 98),
(1695, 'Kohkiluyeh va Buyer Ahmadi', 'Kohkiluyeh va Buyer Ahmadi', '05', 'not_used', NULL, 98),
(1696, 'خراسان', 'Khorasan', '30', 'not_used', NULL, 98),
(1697, 'سيستان وبلوتشستان', 'Sistan va Baluchestan', '04', 'not_used', NULL, 98),
(1698, 'Chahar Mahall va Bakhtiari', 'Chahar Mahall va Bakhtiari', '03', 'not_used', NULL, 98),
(1699, 'كرمان', 'Kerman', '12', 'not_used', NULL, 98),
(1700, 'مازندران', 'Mazandaran', '35', 'not_used', NULL, 98),
(1701, 'قزوين', 'Qazvin', '38', 'not_used', NULL, 98),
(1702, 'زنجان', 'Zanjan', '36', 'not_used', NULL, 98),
(1703, 'المركزي', 'Markazi', '24', 'not_used', NULL, 98),
(1704, 'المركزي', 'Markazi', '19', 'not_used', NULL, 98),
(1705, 'ورستان', 'Lorestan', '23', 'not_used', NULL, 98),
(1706, 'المركزي', 'Markazi', '34', 'not_used', NULL, 98),
(1707, 'خراسان رضوي', 'Khorasan-e Razavi', '42', 'not_used', NULL, 98),
(1708, 'همدان', 'Hamadan', '09', 'not_used', NULL, 98),
(1709, 'سمنان', 'Semnan', '25', 'not_used', NULL, 98),
(1710, 'جيلان', 'Gilan', '08', 'not_used', NULL, 98),
(1711, 'كردستان', 'Kordestan', '16', 'not_used', NULL, 98),
(1712, 'Bakhtaran', 'Bakhtaran', '13', 'not_used', NULL, 98),
(1713, 'إيلام', 'Ilam', '10', 'not_used', NULL, 98),
(1714, 'مقاطعة سمنان', 'Semnan Province', '18', 'not_used', NULL, 98),
(1715, 'كلستان', 'Golestan', '37', 'not_used', NULL, 98),
(1716, 'قم', 'Qom', '39', 'not_used', NULL, 98),
(1718, 'زنجان', 'Zanjan', '21', 'not_used', NULL, 98),
(1720, 'Skagafjardarsysla', 'Skagafjardarsysla', '28', 'not_used', NULL, 99),
(1721, 'Borgarfjardarsysla', 'Borgarfjardarsysla', '07', 'not_used', NULL, 99),
(1722, 'Myrasysla', 'Myrasysla', '17', 'not_used', NULL, 99),
(1723, 'Rangarvallasysla', 'Rangarvallasysla', '23', 'not_used', NULL, 99),
(1724, 'Eyjafjardarsysla', 'Eyjafjardarsysla', '09', 'not_used', NULL, 99),
(1725, 'Kjosarsysla', 'Kjosarsysla', '15', 'not_used', NULL, 99),
(1726, 'Vestur-Isafjardarsysla', 'Vestur-Isafjardarsysla', '36', 'not_used', NULL, 99),
(1728, 'Strandasysla', 'Strandasysla', '30', 'not_used', NULL, 99),
(1729, 'Gullbringusysla', 'Gullbringusysla', '10', 'not_used', NULL, 99),
(1730, 'Austur-Hunavatnssysla', 'Austur-Hunavatnssysla', '05', 'not_used', NULL, 99),
(1731, 'Austur-Skaftafellssysla', 'Austur-Skaftafellssysla', '06', 'not_used', NULL, 99),
(1732, 'Nordur-Mulasysla', 'Nordur-Mulasysla', '20', 'not_used', NULL, 99),
(1733, 'Sudur-Mulasysla', 'Sudur-Mulasysla', '31', 'not_used', NULL, 99),
(1734, 'Vestur-Bardastrandarsysla', 'Vestur-Bardastrandarsysla', '34', 'not_used', NULL, 99),
(1735, 'Snafellsnes- og Hnappadalssysla', 'Snafellsnes- og Hnappadalssysla', '29', 'not_used', NULL, 99),
(1736, 'Arnessysla', 'Arnessysla', '03', 'not_used', NULL, 99),
(1737, 'Vestur-Hunavatnssysla', 'Vestur-Hunavatnssysla', '35', 'not_used', NULL, 99),
(1738, 'Sudur-Tingeyjarsysla', 'Sudur-Tingeyjarsysla', '32', 'not_used', NULL, 99),
(1740, 'Vestur-Skaftafellssysla', 'Vestur-Skaftafellssysla', '37', 'not_used', NULL, 99),
(1742, 'Nordur-Tingeyjarsysla', 'Nordur-Tingeyjarsysla', '21', 'not_used', NULL, 99),
(1743, 'توسكانا', 'Toscana', '16', 'not_used', NULL, 100),
(1744, 'فينيتو', 'Veneto', '20', 'not_used', NULL, 100),
(1745, 'كامبانيا', 'Campania', '04', 'not_used', NULL, 100),
(1746, 'مارتش', 'Marche', '10', 'not_used', NULL, 100),
(1747, 'بيمونتي', 'Piemonte', '12', 'not_used', NULL, 100),
(1748, 'لومبارديا', 'Lombardia', '09', 'not_used', NULL, 100),
(1749, 'ساردينيا', 'Sardegna', '14', 'not_used', NULL, 100),
(1750, 'أبروتسو', 'Abruzzi', '01', 'not_used', NULL, 100),
(1751, 'إيميليا-رومانيا', 'Emilia-Romagna', '05', 'not_used', NULL, 100),
(1752, 'ترينتينو ألتو أديجي', 'Trentino-Alto Adige', '17', 'not_used', NULL, 100),
(1753, 'أومبريا', 'Umbria', '18', 'not_used', NULL, 100),
(1754, 'باسيليكاتا', 'Basilicata', '02', 'not_used', NULL, 100),
(1755, 'بوليا', 'Puglia', '13', 'not_used', NULL, 100),
(1756, 'صقلية', 'Sicilia', '15', 'not_used', NULL, 100),
(1757, 'لاتسيو', 'Lazio', '07', 'not_used', NULL, 100),
(1758, 'ليغوريا', 'Liguria', '08', 'not_used', NULL, 100),
(1759, 'كالابريا', 'Calabria', '03', 'not_used', NULL, 100),
(1760, 'موليز', 'Molise', '11', 'not_used', NULL, 100),
(1761, 'فريولي فينيتسيا جوليا', 'Friuli-Venezia Giulia', '06', 'not_used', NULL, 100),
(1762, 'فالي أوستا', 'Valle d\'Aosta', '19', 'not_used', NULL, 100),
(1764, 'سانت آن', 'Saint Ann', '09', 'not_used', NULL, 101),
(1765, 'سانت إليزابيث', 'Saint Elizabeth', '11', 'not_used', NULL, 101),
(1766, 'هانوفر', 'Hanover', '02', 'not_used', NULL, 101),
(1767, 'يستمورلاند', 'Westmoreland', '16', 'not_used', NULL, 101),
(1768, 'تريلاوني', 'Trelawny', '15', 'not_used', NULL, 101),
(1769, 'مانشستر', 'Manchester', '04', 'not_used', NULL, 101),
(1770, 'جيمس قديس', 'Saint James', '12', 'not_used', NULL, 101),
(1771, 'القديس أندرو', 'Saint Andrew', '08', 'not_used', NULL, 101),
(1772, 'سانت توماس', 'Saint Thomas', '14', 'not_used', NULL, 101),
(1773, 'القديس ماري', 'Saint Mary', '13', 'not_used', NULL, 101),
(1774, 'بورتلاند', 'Portland', '07', 'not_used', NULL, 101),
(1775, 'كلارندون', 'Clarendon', '01', 'not_used', NULL, 101),
(1776, 'سانت كاترين', 'Saint Catherine', '10', 'not_used', NULL, 101),
(1777, 'كينغستون', 'Kingston', '17', 'not_used', NULL, 101),
(1779, 'في الطفيلة', 'At Tafilah', '12', 'not_used', NULL, 102),
(1782, 'الكرك', 'Al Karak', '09', 'not_used', NULL, 102),
(1784, 'البلقاء', 'Al Balqa\'', '02', 'not_used', NULL, 102),
(1786, 'عمان', 'Amman', '16', 'not_used', NULL, 102),
(1787, 'العقبة', 'Al Aqabah', '21', 'not_used', NULL, 102),
(1788, 'أوكيناوا', 'Okinawa', '47', 'not_used', NULL, 103),
(1789, 'ناغازاكي', 'Nagasaki', '27', 'not_used', NULL, 103),
(1790, 'هوكايدو', 'Hokkaido', '12', 'not_used', NULL, 103),
(1791, 'توكوشيما', 'Tokushima', '39', 'not_used', NULL, 103),
(1792, 'مي', 'Mie', '23', 'not_used', NULL, 103),
(1793, 'كاناغاوا', 'Kanagawa', '19', 'not_used', NULL, 103),
(1794, 'شيبا', 'Chiba', '04', 'not_used', NULL, 103),
(1795, 'هيوغو', 'Hyogo', '13', 'not_used', NULL, 103),
(1796, 'ياماغوتشي', 'Yamaguchi', '45', 'not_used', NULL, 103),
(1797, 'أوموري', 'Aomori', '03', 'not_used', NULL, 103),
(1798, 'ميازاكي', 'Miyazaki', '25', 'not_used', NULL, 103),
(1799, 'شيزوكا', 'Shizuoka', '37', 'not_used', NULL, 103),
(1800, 'شيمان', 'Shimane', '36', 'not_used', NULL, 103),
(1801, 'فوكوشيما', 'Fukushima', '08', 'not_used', NULL, 103),
(1802, 'أوكاياما', 'Okayama', '31', 'not_used', NULL, 103),
(1803, 'شيجا', 'Shiga', '35', 'not_used', NULL, 103),
(1804, 'كاجوشيما', 'Kagoshima', '18', 'not_used', NULL, 103),
(1805, 'هيروشيما', 'Hiroshima', '11', 'not_used', NULL, 103),
(1806, 'توتوري', 'Tottori', '41', 'not_used', NULL, 103),
(1807, 'اكيتا', 'Akita', '02', 'not_used', NULL, 103),
(1808, 'ناغانو', 'Nagano', '26', 'not_used', NULL, 103),
(1809, 'فوكوي', 'Fukui', '06', 'not_used', NULL, 103),
(1810, 'سايتاما', 'Saitama', '34', 'not_used', NULL, 103),
(1811, 'واكاياما', 'Wakayama', '43', 'not_used', NULL, 103),
(1812, 'كوتشي', 'Kochi', '20', 'not_used', NULL, 103),
(1813, 'ايواتي', 'Iwate', '16', 'not_used', NULL, 103),
(1814, 'مياجي', 'Miyagi', '24', 'not_used', NULL, 103),
(1815, 'نيجاتا', 'Niigata', '29', 'not_used', NULL, 103),
(1816, 'صمغة', 'Gumma', '10', 'not_used', NULL, 103),
(1817, 'أيشي', 'Aichi', '01', 'not_used', NULL, 103),
(1818, 'توياما', 'Toyama', '42', 'not_used', NULL, 103),
(1819, 'كوماموتو', 'Kumamoto', '21', 'not_used', NULL, 103),
(1820, 'كاغاوا', 'Kagawa', '17', 'not_used', NULL, 103),
(1821, 'ايمى', 'Ehime', '05', 'not_used', NULL, 103),
(1822, 'طوكيو', 'Tokyo', '40', 'not_used', NULL, 103),
(1823, 'فوكوكا', 'Fukuoka', '07', 'not_used', NULL, 103),
(1824, 'توتشيغي', 'Tochigi', '38', 'not_used', NULL, 103),
(1825, 'ياماغاتا', 'Yamagata', '44', 'not_used', NULL, 103),
(1826, 'قصة طويلة', 'Saga', '33', 'not_used', NULL, 103),
(1827, 'أويتا', 'Oita', '30', 'not_used', NULL, 103),
(1828, 'جيفو', 'Gifu', '09', 'not_used', NULL, 103),
(1829, 'إيشيكاوا', 'Ishikawa', '15', 'not_used', NULL, 103),
(1830, 'نارا', 'Nara', '28', 'not_used', NULL, 103),
(1831, 'ايباراكي', 'Ibaraki', '14', 'not_used', NULL, 103),
(1832, 'كيوتو', 'Kyoto', '22', 'not_used', NULL, 103),
(1833, 'ياماناشي', 'Yamanashi', '46', 'not_used', NULL, 103),
(1834, 'أوساكا', 'Osaka', '32', 'not_used', NULL, 103),
(1835, 'ساحل', 'Coast', '02', 'not_used', NULL, 104),
(1836, 'نيانزا', 'Nyanza', '07', 'not_used', NULL, 104),
(1837, 'الوادي المتصدع', 'Rift Valley', '08', 'not_used', NULL, 104),
(1838, 'الغربي', 'Western', '09', 'not_used', NULL, 104),
(1839, 'شمال شرق', 'North-Eastern', '06', 'not_used', NULL, 104),
(1840, 'الشرقية', 'Eastern', '03', 'not_used', NULL, 104),
(1841, 'منطقة نيروبي', 'Nairobi Area', '05', 'not_used', NULL, 104),
(1842, 'وسط', 'Central', '01', 'not_used', NULL, 104),
(1843, 'جلال آباد', 'Jalal-Abad', '03', 'not_used', NULL, 105),
(1844, 'نارين', 'Naryn', '04', 'not_used', NULL, 105),
(1845, 'أوش', 'Osh', '05', 'not_used', NULL, 105),
(1846, 'تشوي', 'Chuy', '02', 'not_used', NULL, 105),
(1847, 'يسيك-كول', 'Ysyk-Kol', '07', 'not_used', NULL, 105),
(1848, 'بيشكيك', 'Bishkek', '01', 'not_used', NULL, 105),
(1849, 'تالاس', 'Talas', '06', 'not_used', NULL, 105),
(1850, 'باتكن', 'Batken', '09', 'not_used', NULL, 105),
(1852, 'سيم ريب', 'Siem Reap', '16', 'not_used', NULL, 106),
(1853, 'كراتي', 'Kracheh', '09', 'not_used', NULL, 106),
(1854, 'كامبونغ ثوم', 'Kampong Thum', '05', 'not_used', NULL, 106),
(1855, 'كامبونج شنانج', 'Kampong Chhnang', '03', 'not_used', NULL, 106),
(1857, 'كامبونج تشام', 'Kampong Cham', '02', 'not_used', NULL, 106),
(1858, 'كامبونج سبيو', 'Kampong Speu', '04', 'not_used', NULL, 106),
(1859, 'اتخاذ س', 'Takeo', '19', 'not_used', NULL, 106),
(1860, 'باتامبانغ', 'Batdambang', '01', 'not_used', NULL, 106);
INSERT INTO `cities` (`id`, `name_ar`, `name_en`, `code`, `status`, `shipping_price`, `country_id`) VALUES
(1861, 'بريى فنج', 'Prey Veng', '14', 'not_used', NULL, 106),
(1862, 'راتاناكيري كيري', 'Ratanakiri Kiri', '15', 'not_used', NULL, 106),
(1863, 'سفاي رينج', 'Svay Rieng', '18', 'not_used', NULL, 106),
(1864, 'كوه كونغ', 'Koh Kong', '08', 'not_used', NULL, 106),
(1865, 'بورسات', 'Pursat', '12', 'not_used', NULL, 106),
(1866, 'بنوم بنه', 'Phnum Penh', '11', 'not_used', NULL, 106),
(1867, 'موندولكيري', 'Mondulkiri', '10', 'not_used', NULL, 106),
(1868, 'ستونغ ترينغ', 'Stung Treng', '17', 'not_used', NULL, 106),
(1869, 'كامبوت', 'Kampot', '06', 'not_used', NULL, 106),
(1870, 'بانتي ميانشي', 'Banteay Meanchey', '25', 'not_used', NULL, 106),
(1871, 'برياه فيهيار', 'Preah Vihear', '13', 'not_used', NULL, 106),
(1872, 'كاندال', 'Kandal', '07', 'not_used', NULL, 106),
(1874, 'أنجوان', 'Anjouan', '01', 'not_used', NULL, 108),
(1875, 'موهيلي', 'Moheli', '03', 'not_used', NULL, 108),
(1876, 'القمر الكبرى', 'Grande Comore', '02', 'not_used', NULL, 108),
(1877, 'سانت جورج جينجيرلاند', 'Saint George Gingerland', '04', 'not_used', NULL, 109),
(1878, 'سانت جيمس ويندوارد', 'Saint James Windward', '05', 'not_used', NULL, 109),
(1879, 'سانت توماس لوولاند', 'Saint Thomas Lowland', '12', 'not_used', NULL, 109),
(1880, 'سانت جورج باسيتير', 'Saint George Basseterre', '03', 'not_used', NULL, 109),
(1881, 'القديس يوحنا فيجترى', 'Saint John Figtree', '07', 'not_used', NULL, 109),
(1882, 'القديس بطرس باستير', 'Saint Peter Basseterre', '11', 'not_used', NULL, 109),
(1883, 'القديس يوحنا كابيستر', 'Saint John Capisterre', '06', 'not_used', NULL, 109),
(1884, 'كنيسة المسيح نيقولا تاون', 'Christ Church Nichola Town', '01', 'not_used', NULL, 109),
(1885, 'الثالوث بالميتو بوينت', 'Trinity Palmetto Point', '15', 'not_used', NULL, 109),
(1886, 'سانت آن ساندي بوينت', 'Saint Anne Sandy Point', '02', 'not_used', NULL, 109),
(1887, 'سانت ماري كايون', 'Saint Mary Cayon', '08', 'not_used', NULL, 109),
(1888, 'جزيرة سانت توماس الوسطى', 'Saint Thomas Middle Island', '13', 'not_used', NULL, 109),
(1889, 'سانت بول كابيستر', 'Saint Paul Capisterre', '09', 'not_used', NULL, 109),
(1890, 'P\'yongan-نامدو', 'P\'yongan-namdo', '15', 'not_used', NULL, 110),
(1891, 'P\'yongan-bukto', 'P\'yongan-bukto', '11', 'not_used', NULL, 110),
(1892, 'P\'yongyang-سي', 'P\'yongyang-si', '12', 'not_used', NULL, 110),
(1893, 'كانج وون دو', 'Kangwon-do', '09', 'not_used', NULL, 110),
(1894, 'هوانغهاي-bukto', 'Hwanghae-bukto', '07', 'not_used', NULL, 110),
(1895, 'هامكيونغ-نامدو', 'Hamgyong-namdo', '03', 'not_used', NULL, 110),
(1896, 'تشاغانغ دو', 'Chagang-do', '01', 'not_used', NULL, 110),
(1897, 'هامكيونغ-bukto', 'Hamgyong-bukto', '17', 'not_used', NULL, 110),
(1898, 'هوانغهاي-نامدو', 'Hwanghae-namdo', '06', 'not_used', NULL, 110),
(1899, 'Namp\'o-سي', 'Namp\'o-si', '14', 'not_used', NULL, 110),
(1900, 'كايسونج، الاشتراكية', 'Kaesong-si', '08', 'not_used', NULL, 110),
(1901, 'يانجانج دو', 'Yanggang-do', '13', 'not_used', NULL, 110),
(1902, 'ناجين سونبونج سي', 'Najin Sonbong-si', '18', 'not_used', NULL, 110),
(1903, 'Ch\'ungch\'ong-bukto', 'Ch\'ungch\'ong-bukto', '05', 'not_used', NULL, 111),
(1904, 'كانج وون دو', 'Kangwon-do', '06', 'not_used', NULL, 111),
(1905, 'Ch\'ungch\'ong-نامدو', 'Ch\'ungch\'ong-namdo', '17', 'not_used', NULL, 111),
(1906, 'كيونجسانج-bukto', 'Kyongsang-bukto', '14', 'not_used', NULL, 111),
(1907, 'تشولا-نامدو', 'Cholla-namdo', '16', 'not_used', NULL, 111),
(1908, 'كيونجي دو', 'Kyonggi-do', '13', 'not_used', NULL, 111),
(1909, 'تشيجو دو', 'Cheju-do', '01', 'not_used', NULL, 111),
(1910, 'تشولا-bukto', 'Cholla-bukto', '03', 'not_used', NULL, 111),
(1911, 'سول-t\'ukpyolsi', 'Seoul-t\'ukpyolsi', '11', 'not_used', NULL, 111),
(1912, 'كيونجسانج-نامدو', 'Kyongsang-namdo', '20', 'not_used', NULL, 111),
(1913, 'تايجو-jikhalsi', 'Taegu-jikhalsi', '15', 'not_used', NULL, 111),
(1914, 'بوسان-jikhalsi', 'Pusan-jikhalsi', '10', 'not_used', NULL, 111),
(1915, 'كوانجو-jikhalsi', 'Kwangju-jikhalsi', '18', 'not_used', NULL, 111),
(1916, 'أولسان-gwangyoksi', 'Ulsan-gwangyoksi', '21', 'not_used', NULL, 111),
(1917, 'إنشون-jikhalsi', 'Inch\'on-jikhalsi', '12', 'not_used', NULL, 111),
(1918, 'تايجون-jikhalsi', 'Taejon-jikhalsi', '19', 'not_used', NULL, 111),
(1919, 'الكوييت', 'Al Kuwayt', '02', 'not_used', NULL, 112),
(1920, 'الجهراء', 'Al Jahra', '05', 'not_used', NULL, 112),
(1923, 'ألماتي', 'Almaty', '01', 'not_used', NULL, 114),
(1924, 'جنوب كازاخستان', 'South Kazakhstan', '10', 'not_used', NULL, 114),
(1925, 'شمال كازاخستان', 'North Kazakhstan', '16', 'not_used', NULL, 114),
(1926, 'بافلودار', 'Pavlodar', '11', 'not_used', NULL, 114),
(1927, 'كاراجهاندي', 'Qaraghandy', '12', 'not_used', NULL, 114),
(1928, 'كيزيلورودا', 'Qyzylorda', '14', 'not_used', NULL, 114),
(1929, 'شرق كازاخستان', 'East Kazakhstan', '15', 'not_used', NULL, 114),
(1930, 'أكمولا', 'Aqmola', '03', 'not_used', NULL, 114),
(1931, 'أكتوب', 'Aqtobe', '04', 'not_used', NULL, 114),
(1932, 'كوستاناي', 'Qostanay', '13', 'not_used', NULL, 114),
(1933, 'غرب كازاخستان', 'West Kazakhstan', '07', 'not_used', NULL, 114),
(1934, 'أتيراو', 'Atyrau', '06', 'not_used', NULL, 114),
(1935, 'Zhambyl', 'Zhambyl', '17', 'not_used', NULL, 114),
(1936, 'أستانا', 'Astana', '05', 'not_used', NULL, 114),
(1937, 'مانجهيستاو', 'Mangghystau', '09', 'not_used', NULL, 114),
(1938, 'مدينة ألماتي', 'Almaty City', '02', 'not_used', NULL, 114),
(1939, 'Bayqonyr', 'Bayqonyr', '08', 'not_used', NULL, 114),
(1941, 'سافاناخيت', 'Savannakhet', '10', 'not_used', NULL, 115),
(1942, 'فونغسالي', 'Phongsali', '08', 'not_used', NULL, 115),
(1943, 'سروان', 'Saravan', '09', 'not_used', NULL, 115),
(1946, 'هوافان', 'Houaphan', '03', 'not_used', NULL, 115),
(1947, 'أتابو', 'Attapu', '01', 'not_used', NULL, 115),
(1949, 'تشامباساك', 'Champasak', '02', 'not_used', NULL, 115),
(1950, 'وانجفرابانج', 'Louangphrabang', '17', 'not_used', NULL, 115),
(1951, 'أودومكساي', 'Oudomxai', '07', 'not_used', NULL, 115),
(1955, 'زيانجكوانج', 'Xiangkhoang', '14', 'not_used', NULL, 115),
(1956, 'فينتيان', 'Vientiane', '11', 'not_used', NULL, 115),
(1960, 'Xaignabouri', 'Xaignabouri', '13', 'not_used', NULL, 115),
(1961, 'خاموان', 'Khammouan', '04', 'not_used', NULL, 115),
(1966, 'شمال لبنان', 'Liban-Nord', '03', 'not_used', NULL, 116),
(1967, 'الجنوب', 'Al Janub', '02', 'not_used', NULL, 116),
(1968, 'بيروت', 'Beyrouth', '04', 'not_used', NULL, 116),
(1969, 'جبل لبنان', 'Mont-Liban', '05', 'not_used', NULL, 116),
(1970, 'البقاع', 'Beqaa', '01', 'not_used', NULL, 116),
(1971, 'لبنان-سود', 'Liban-Sud', '06', 'not_used', NULL, 116),
(1972, 'ميكو', 'Micoud', '08', 'not_used', NULL, 117),
(1973, 'لابوري', 'Laborie', '07', 'not_used', NULL, 117),
(1974, 'دينيري', 'Dennery', '05', 'not_used', NULL, 117),
(1975, 'آنس-لا-راي', 'Anse-la-Raye', '01', 'not_used', NULL, 117),
(1976, 'فيو فورت', 'Vieux-Fort', '10', 'not_used', NULL, 117),
(1977, 'كاستري', 'Castries', '03', 'not_used', NULL, 117),
(1978, 'سوفرير', 'Soufriere', '09', 'not_used', NULL, 117),
(1979, 'جروس-جزيرة', 'Gros-Islet', '06', 'not_used', NULL, 117),
(1980, 'تشويسيول', 'Choiseul', '04', 'not_used', NULL, 117),
(1981, 'الدوفين الابن البكر لملك فرنسي', 'Dauphin', '02', 'not_used', NULL, 117),
(1982, 'براسلين', 'Praslin', '11', 'not_used', NULL, 117),
(1983, 'بلزرس', 'Balzers', '01', 'not_used', NULL, 118),
(1984, 'جمبرين', 'Gamprin', '03', 'not_used', NULL, 118),
(1985, 'بلانكن', 'Planken', '05', 'not_used', NULL, 118),
(1986, 'فادوز', 'Vaduz', '11', 'not_used', NULL, 118),
(1987, 'اشن', 'Eschen', '02', 'not_used', NULL, 118),
(1988, 'تريسنبرغ', 'Triesenberg', '10', 'not_used', NULL, 118),
(1989, 'شلينبرغ', 'Schellenberg', '08', 'not_used', NULL, 118),
(1990, 'مورن', 'Mauren', '04', 'not_used', NULL, 118),
(1991, 'روجل', 'Ruggell', '06', 'not_used', NULL, 118),
(1992, 'ستشان', 'Schaan', '07', 'not_used', NULL, 118),
(1993, 'تريزين', 'Triesen', '09', 'not_used', NULL, 118),
(1994, 'الشمال الغربي', 'North Western', '32', 'not_used', NULL, 119),
(1995, 'جنوبي', 'Southern', '34', 'not_used', NULL, 119),
(1996, 'وسط', 'Central', '29', 'not_used', NULL, 119),
(1997, 'ساباراغاموا', 'Sabaragamuwa', '33', 'not_used', NULL, 119),
(1998, 'شمال وسط', 'North Central', '30', 'not_used', NULL, 119),
(2000, 'الغربي', 'Western', '36', 'not_used', NULL, 119),
(2001, 'أوفا', 'Uva', '35', 'not_used', NULL, 119),
(2002, 'نيمبا', 'Nimba', '09', 'not_used', NULL, 120),
(2003, 'غراند باسا', 'Grand Bassa', '11', 'not_used', NULL, 120),
(2004, 'وفا', 'Lofa', '05', 'not_used', NULL, 120),
(2005, 'بونغ', 'Bong', '01', 'not_used', NULL, 120),
(2007, 'مونتسيرادو', 'Montserrado', '14', 'not_used', NULL, 120),
(2009, 'مارغيبي', 'Margibi', '17', 'not_used', NULL, 120),
(2011, 'الصينية', 'Sino', '10', 'not_used', NULL, 120),
(2012, 'نهر سيس', 'River Cess', '18', 'not_used', NULL, 120),
(2013, 'غراند كيب ماونت', 'Grand Cape Mount', '12', 'not_used', NULL, 120),
(2015, 'ماريلاند', 'Maryland', '13', 'not_used', NULL, 120),
(2016, 'غراند كيب ماونت', 'Grand Cape Mount', '04', 'not_used', NULL, 120),
(2017, 'غباربولو', 'Gbarpolu', '21', 'not_used', NULL, 120),
(2018, 'نهر جي', 'River Gee', '22', 'not_used', NULL, 120),
(2019, 'جراند جيده', 'Grand Gedeh', '19', 'not_used', NULL, 120),
(2020, 'وفا', 'Lofa', '20', 'not_used', NULL, 120),
(2021, 'ماسيرو', 'Maseru', '14', 'not_used', NULL, 121),
(2022, 'كوثينج', 'Quthing', '18', 'not_used', NULL, 121),
(2023, 'مافتينج', 'Mafeteng', '13', 'not_used', NULL, 121),
(2024, 'بيريا', 'Berea', '10', 'not_used', NULL, 121),
(2025, 'موهاليس هوك', 'Mohales Hoek', '15', 'not_used', NULL, 121),
(2026, 'تابا تسيكا', 'Thaba-Tseka', '19', 'not_used', NULL, 121),
(2027, 'بوثا بوثي', 'Butha-Buthe', '11', 'not_used', NULL, 121),
(2028, 'يرايب', 'Leribe', '12', 'not_used', NULL, 121),
(2029, 'كاشاس نيك', 'Qachas Nek', '17', 'not_used', NULL, 121),
(2030, 'موكوتلونج', 'Mokhotlong', '16', 'not_used', NULL, 121),
(2032, 'بانيفزيو ابسكريتيس', 'Panevezio Apskritis', '60', 'not_used', NULL, 122),
(2033, 'Telsiu Apskritis', 'Telsiu Apskritis', '63', 'not_used', NULL, 122),
(2034, 'Klaipedos Apskritis', 'Klaipedos Apskritis', '58', 'not_used', NULL, 122),
(2035, 'Vilniaus Apskritis', 'Vilniaus Apskritis', '65', 'not_used', NULL, 122),
(2036, 'Siauliu Apskritis', 'Siauliu Apskritis', '61', 'not_used', NULL, 122),
(2037, 'Taurages Apskritis', 'Taurages Apskritis', '62', 'not_used', NULL, 122),
(2038, 'Marijampoles Apskritis', 'Marijampoles Apskritis', '59', 'not_used', NULL, 122),
(2040, 'Utenos Apskritis', 'Utenos Apskritis', '64', 'not_used', NULL, 122),
(2041, 'عليتاوس ابسكريتيس', 'Alytaus Apskritis', '56', 'not_used', NULL, 122),
(2042, 'كاونو ابسكريتيس', 'Kauno Apskritis', '57', 'not_used', NULL, 122),
(2043, 'لوكسمبورغ', 'Luxembourg', '03', 'not_used', NULL, 123),
(2044, 'Grevenmacher', 'Grevenmacher', '02', 'not_used', NULL, 123),
(2045, 'Diekirch', 'Diekirch', '01', 'not_used', NULL, 123),
(2046, 'مادوناس', 'Madonas', '20', 'not_used', NULL, 124),
(2047, 'كلديجاس', 'Kuldigas', '15', 'not_used', NULL, 124),
(2048, 'داوجافبيلس', 'Daugavpils', '07', 'not_used', NULL, 124),
(2049, 'تكما', 'Tukuma', '29', 'not_used', NULL, 124),
(2050, 'فنتسبيلز', 'Ventspils', '33', 'not_used', NULL, 124),
(2051, 'دوبيليز', 'Dobeles', '08', 'not_used', NULL, 124),
(2052, 'ليباجاس', 'Liepajas', '17', 'not_used', NULL, 124),
(2053, 'بالفو', 'Balvu', '03', 'not_used', NULL, 124),
(2054, 'سالدوس', 'Saldus', '27', 'not_used', NULL, 124),
(2055, 'باوسكا', 'Bauskas', '04', 'not_used', NULL, 124),
(2056, 'يمبازو', 'Limbazu', '18', 'not_used', NULL, 124),
(2057, 'لدزاس', 'Ludzas', '19', 'not_used', NULL, 124),
(2058, 'سيسو', 'Cesu', '05', 'not_used', NULL, 124),
(2059, 'يكاب', 'Jekabpils', '10', 'not_used', NULL, 124),
(2060, 'ألكسنيز', 'Aluksnes', '02', 'not_used', NULL, 124),
(2061, 'ريزكنس', 'Rezeknes', '24', 'not_used', NULL, 124),
(2062, 'ريغاس', 'Rigas', '26', 'not_used', NULL, 124),
(2063, 'الغيلان', 'Ogres', '21', 'not_used', NULL, 124),
(2064, 'كراسلافاس', 'Kraslavas', '14', 'not_used', NULL, 124),
(2065, 'جلبينيز', 'Gulbenes', '09', 'not_used', NULL, 124),
(2066, 'ريغا', 'Riga', '25', 'not_used', NULL, 124),
(2067, 'بريلي', 'Preilu', '22', 'not_used', NULL, 124),
(2068, 'أيزكروكليز', 'Aizkraukles', '01', 'not_used', NULL, 124),
(2069, 'تالسو', 'Talsu', '28', 'not_used', NULL, 124),
(2070, 'جيلجافاس', 'Jelgavas', '12', 'not_used', NULL, 124),
(2071, 'فالكاس', 'Valkas', '30', 'not_used', NULL, 124),
(2072, 'فالميراس', 'Valmieras', '31', 'not_used', NULL, 124),
(2073, 'يابايا', 'Liepaja', '16', 'not_used', NULL, 124),
(2074, 'فنتسبيلز', 'Ventspils', '32', 'not_used', NULL, 124),
(2075, 'داوجافبيلس', 'Daugavpils', '06', 'not_used', NULL, 124),
(2076, 'ريزكن', 'Rezekne', '23', 'not_used', NULL, 124),
(2077, 'يفرن', 'Yafran', '62', 'not_used', NULL, 125),
(2078, 'طرابلس', 'Tarabulus', '61', 'not_used', NULL, 125),
(2079, 'أحد فنادق الخمس', 'An Nuqat al Khams', '51', 'not_used', NULL, 125),
(2080, 'العزيزية', 'Al Aziziyah', '03', 'not_used', NULL, 125),
(2081, 'الزاوية', 'Az Zawiyah', '53', 'not_used', NULL, 125),
(2082, 'مصراتة', 'Misratah', '58', 'not_used', NULL, 125),
(2083, 'غريان', 'Gharyan', '57', 'not_used', NULL, 125),
(2084, 'طبرق', 'Tubruq', '42', 'not_used', NULL, 125),
(2085, 'ترهونة', 'Tarhunah', '41', 'not_used', NULL, 125),
(2087, 'الشطي', 'Ash Shati\'', '13', 'not_used', NULL, 125),
(2088, 'اجدابيا', 'Ajdabiya', '47', 'not_used', NULL, 125),
(2089, 'مرزق', 'Murzuq', '30', 'not_used', NULL, 125),
(2090, 'الجبل الاخضر', 'Al Jabal al Akhdar', '49', 'not_used', NULL, 125),
(2093, 'غدامس', 'Ghadamis', '56', 'not_used', NULL, 125),
(2096, 'Awbari', 'Awbari', '52', 'not_used', NULL, 125),
(2097, 'الخمص', 'Al Khums', '50', 'not_used', NULL, 125),
(2099, 'الكفرة', 'Al Kufrah', '08', 'not_used', NULL, 125),
(2102, 'الفاتح', 'Al Fatih', '48', 'not_used', NULL, 125),
(2103, 'بنغازي', 'Banghazi', '54', 'not_used', NULL, 125),
(2104, 'زليتن', 'Zlitan', '45', 'not_used', NULL, 125),
(2105, 'الجفرة', 'Al Jufrah', '05', 'not_used', NULL, 125),
(2108, 'Sawfajjin', 'Sawfajjin', '59', 'not_used', NULL, 125),
(2110, 'درنة', 'Darnah', '55', 'not_used', NULL, 125),
(2111, 'سبها', 'Sabha', '34', 'not_used', NULL, 125),
(2116, 'سرت', 'Surt', '60', 'not_used', NULL, 125),
(2166, 'جاجوزيا', 'Gagauzia', '51', 'not_used', NULL, 128),
(2175, 'أنتاناناريفو', 'Antananarivo', '05', 'not_used', NULL, 129),
(2176, 'ماهاجانغا', 'Mahajanga', '03', 'not_used', NULL, 129),
(2177, 'توليارا', 'Toliara', '06', 'not_used', NULL, 129),
(2178, 'فيانارانتسوا', 'Fianarantsoa', '02', 'not_used', NULL, 129),
(2179, 'أنتسيرانانا', 'Antsiranana', '01', 'not_used', NULL, 129),
(2180, 'تواماسينا', 'Toamasina', '04', 'not_used', NULL, 129),
(2182, 'بيتروفيتش', 'Petrovec', '79', 'not_used', NULL, 131),
(2183, 'بوجوفينيه', 'Bogovinje', '10', 'not_used', NULL, 131),
(2184, 'وزوفو', 'Lozovo', '60', 'not_used', NULL, 131),
(2185, 'Rostusa', 'Rostusa', '88', 'not_used', NULL, 131),
(2186, 'ستارو ناجوريكان', 'Staro Nagoricane', '97', 'not_used', NULL, 131),
(2187, 'غيفيغليا', 'Gevgelija', '33', 'not_used', NULL, 131),
(2188, 'Srbinovo', 'Srbinovo', '94', 'not_used', NULL, 131),
(2189, 'أوراساك', 'Orasac', '75', 'not_used', NULL, 131),
(2190, 'فالاندوفو', 'Valandovo', 'A8', 'not_used', NULL, 131),
(2191, 'إيلندين', 'Ilinden', '36', 'not_used', NULL, 131),
(2192, 'أوهريد', 'Ohrid', '74', 'not_used', NULL, 131),
(2193, 'سفيتي نيكول', 'Sveti Nikole', 'A4', 'not_used', NULL, 131),
(2194, 'يبكوفو', 'Lipkovo', '59', 'not_used', NULL, 131),
(2195, 'زيتوسي', 'Zitose', 'C4', 'not_used', NULL, 131),
(2196, 'ستدينيكاني', 'Studenicani', 'A2', 'not_used', NULL, 131),
(2197, 'كريفوغاستاني', 'Krivogastani', '53', 'not_used', NULL, 131),
(2198, 'رادوفيس', 'Radovis', '84', 'not_used', NULL, 131),
(2199, 'Dobrusevo', 'Dobrusevo', '26', 'not_used', NULL, 131),
(2200, 'رانكوفس', 'Rankovce', '85', 'not_used', NULL, 131),
(2201, 'Topolcani', 'Topolcani', 'A7', 'not_used', NULL, 131),
(2202, 'كريفا بالانكا', 'Kriva Palanka', '52', 'not_used', NULL, 131),
(2203, 'زاجاس', 'Zajas', 'C1', 'not_used', NULL, 131),
(2204, 'فيتوليستي', 'Vitoliste', 'B5', 'not_used', NULL, 131),
(2205, 'حرم', 'Debar', '21', 'not_used', NULL, 131),
(2206, 'بوزيلوفو', 'Bosilovo', '11', 'not_used', NULL, 131),
(2207, 'Dzepciste', 'Dzepciste', '31', 'not_used', NULL, 131),
(2208, 'فاسيليفو', 'Vasilevo', 'A9', 'not_used', NULL, 131),
(2209, 'ستار دوجران', 'Star Dojran', '96', 'not_used', NULL, 131),
(2210, 'السراج', 'Saraj', '90', 'not_used', NULL, 131),
(2211, 'آراسينوفو', 'Aracinovo', '01', 'not_used', NULL, 131),
(2212, 'أوسلوميج', 'Oslomej', '77', 'not_used', NULL, 131),
(2213, 'Miravci', 'Miravci', '66', 'not_used', NULL, 131),
(2214, 'بيلسيستا', 'Belcista', '03', 'not_used', NULL, 131),
(2215, 'كاربينكي', 'Karbinci', '40', 'not_used', NULL, 131),
(2216, 'كروسيفو', 'Krusevo', '54', 'not_used', NULL, 131),
(2217, 'Kondovo', 'Kondovo', '48', 'not_used', NULL, 131),
(2218, 'رسن', 'Resen', '86', 'not_used', NULL, 131),
(2219, 'Lukovo', 'Lukovo', '61', 'not_used', NULL, 131),
(2220, 'فرانيستيكا', 'Vranestica', 'B6', 'not_used', NULL, 131),
(2221, 'نيغوتينو-Polosko', 'Negotino-Polosko', '70', 'not_used', NULL, 131),
(2222, 'ستيب', 'Stip', '98', 'not_used', NULL, 131),
(2223, 'Sopotnica', 'Sopotnica', '93', 'not_used', NULL, 131),
(2224, 'أوريزاري', 'Orizari', '76', 'not_used', NULL, 131),
(2225, 'فيليس', 'Veles', 'B1', 'not_used', NULL, 131),
(2226, 'البكالوريا', 'Bac', '02', 'not_used', NULL, 131),
(2227, 'زيلينيكوفو', 'Zelenikovo', 'C2', 'not_used', NULL, 131),
(2228, 'نوفو سيلو', 'Novo Selo', '72', 'not_used', NULL, 131),
(2229, 'ستروميكا', 'Strumica', 'A1', 'not_used', NULL, 131),
(2230, 'مافروفي أنوفي', 'Mavrovi Anovi', '64', 'not_used', NULL, 131),
(2231, 'نوفا سي', 'Novaci', '71', 'not_used', NULL, 131),
(2232, 'غوستيفار', 'Gostivar', '34', 'not_used', NULL, 131),
(2233, 'كسير-سانديفو', 'Cucer-Sandevo', '20', 'not_used', NULL, 131),
(2234, 'ديمير كابيجا', 'Demir Kapija', '25', 'not_used', NULL, 131),
(2235, 'أولسيفو', 'Oblesevo', '73', 'not_used', NULL, 131),
(2236, 'كاسكا', 'Caska', '15', 'not_used', NULL, 131),
(2237, 'Murtino', 'Murtino', '68', 'not_used', NULL, 131),
(2238, 'دمير حصار', 'Demir Hisar', '24', 'not_used', NULL, 131),
(2239, 'Probistip', 'Probistip', '83', 'not_used', NULL, 131),
(2240, 'Makedonski برود', 'Makedonski Brod', '63', 'not_used', NULL, 131),
(2241, 'كاربوس', 'Karpos', '41', 'not_used', NULL, 131),
(2242, 'بسترتشا', 'Bistrica', '05', 'not_used', NULL, 131),
(2243, 'سوبيست', 'Sopiste', '92', 'not_used', NULL, 131),
(2244, 'كومانوفو', 'Kumanovo', '57', 'not_used', NULL, 131),
(2245, 'كافادارشي', 'Kavadarci', '42', 'not_used', NULL, 131),
(2246, 'بريليب', 'Prilep', '82', 'not_used', NULL, 131),
(2247, 'كوكاني', 'Kocani', '46', 'not_used', NULL, 131),
(2248, 'ساموكوف', 'Samokov', '89', 'not_used', NULL, 131),
(2249, 'Klecevce', 'Klecevce', '45', 'not_used', NULL, 131),
(2250, 'دولنيني', 'Dolneni', '28', 'not_used', NULL, 131),
(2251, 'دولنا بانجيكا', 'Dolna Banjica', '27', 'not_used', NULL, 131),
(2252, 'فراتنيكا', 'Vratnica', 'B8', 'not_used', NULL, 131),
(2253, 'موغيلا', 'Mogila', '67', 'not_used', NULL, 131),
(2254, 'بيروفو', 'Berovo', '04', 'not_used', NULL, 131),
(2255, 'بريفينيكا', 'Brvenica', '12', 'not_used', NULL, 131),
(2256, 'Makedonska Kamenica', 'Makedonska Kamenica', '62', 'not_used', NULL, 131),
(2257, 'Sipkovica', 'Sipkovica', '91', 'not_used', NULL, 131),
(2258, 'ديلوغوجدي', 'Delogozdi', '23', 'not_used', NULL, 131),
(2259, 'ديلسيفو', 'Delcevo', '22', 'not_used', NULL, 131),
(2260, 'فينيكا', 'Vinica', 'B4', 'not_used', NULL, 131),
(2261, 'بوغوميلا', 'Bogomila', '09', 'not_used', NULL, 131),
(2262, 'بيتولا', 'Bitola', '06', 'not_used', NULL, 131),
(2263, 'Blatec', 'Blatec', '07', 'not_used', NULL, 131),
(2264, 'Cegrane', 'Cegrane', '16', 'not_used', NULL, 131),
(2265, 'كراتوفو', 'Kratovo', '51', 'not_used', NULL, 131),
(2266, 'بوجدانسي', 'Bogdanci', '08', 'not_used', NULL, 131),
(2267, 'Konopiste', 'Konopiste', '49', 'not_used', NULL, 131),
(2268, 'زلينو', 'Zelino', 'C3', 'not_used', NULL, 131),
(2269, 'Labunista', 'Labunista', '58', 'not_used', NULL, 131),
(2270, 'سوتو اوريزاري', 'Suto Orizari', 'A3', 'not_used', NULL, 131),
(2271, 'تيرس', 'Tearce', 'A5', 'not_used', NULL, 131),
(2272, 'فروتوك', 'Vrutok', 'B9', 'not_used', NULL, 131),
(2273, 'Staravina', 'Staravina', '95', 'not_used', NULL, 131),
(2274, 'نيغوتينو', 'Negotino', '69', 'not_used', NULL, 131),
(2275, 'درجوفو', 'Drugovo', '30', 'not_used', NULL, 131),
(2276, 'زليتوفو', 'Zletovo', 'C5', 'not_used', NULL, 131),
(2277, 'بيسيفو', 'Pehcevo', '78', 'not_used', NULL, 131),
(2278, 'سيسينوفو', 'Cesinovo', '19', 'not_used', NULL, 131),
(2279, 'Capari', 'Capari', '14', 'not_used', NULL, 131),
(2280, 'Kukurecani', 'Kukurecani', '56', 'not_used', NULL, 131),
(2281, 'فراب سيست', 'Vrapciste', 'B7', 'not_used', NULL, 131),
(2282, 'روسومان', 'Rosoman', '87', 'not_used', NULL, 131),
(2283, 'Velesta', 'Velesta', 'B2', 'not_used', NULL, 131),
(2284, 'كونس', 'Konce', '47', 'not_used', NULL, 131),
(2285, 'جرادسكو', 'Gradsko', '35', 'not_used', NULL, 131),
(2286, 'Kosel', 'Kosel', '50', 'not_used', NULL, 131),
(2287, 'كيسيلا فودا', 'Kisela Voda', '44', 'not_used', NULL, 131),
(2288, 'جيجنوفسي', 'Jegunovce', '38', 'not_used', NULL, 131),
(2289, 'بلاسنيكا', 'Plasnica', '80', 'not_used', NULL, 131),
(2290, 'Kamenjane', 'Kamenjane', '39', 'not_used', NULL, 131),
(2291, 'في Izvor', 'Izvor', '37', 'not_used', NULL, 131),
(2292, 'ستروغا', 'Struga', '99', 'not_used', NULL, 131),
(2293, 'Podares', 'Podares', '81', 'not_used', NULL, 131),
(2294, 'تيتوفو', 'Tetovo', 'A6', 'not_used', NULL, 131),
(2295, 'Meseista', 'Meseista', '65', 'not_used', NULL, 131),
(2296, 'فيفكاني', 'Vevcani', 'B3', 'not_used', NULL, 131),
(2297, 'زرنوف سي', 'Zrnovci', 'C6', 'not_used', NULL, 131),
(2298, 'كيشيفو', 'Kicevo', '43', 'not_used', NULL, 131),
(2299, 'Kuklis', 'Kuklis', '55', 'not_used', NULL, 131),
(2300, 'كوليكورو', 'Koulikoro', '07', 'not_used', NULL, 132),
(2301, 'موبتي', 'Mopti', '04', 'not_used', NULL, 132),
(2302, 'كايس', 'Kayes', '03', 'not_used', NULL, 132),
(2305, 'تمبكتو', 'Tombouctou', '08', 'not_used', NULL, 132),
(2306, 'سيجو', 'Segou', '05', 'not_used', NULL, 132),
(2307, 'سيكاسو', 'Sikasso', '06', 'not_used', NULL, 132),
(2308, 'باماكو', 'Bamako', '01', 'not_used', NULL, 132),
(2309, 'قاو', 'Gao', '09', 'not_used', NULL, 132),
(2310, 'كيدال', 'Kidal', '10', 'not_used', NULL, 132),
(2311, 'بيغو', 'Pegu', '09', 'not_used', NULL, 133),
(2312, 'دولة مون', 'Mon State', '13', 'not_used', NULL, 133),
(2313, 'ولاية كاشين', 'Kachin State', '04', 'not_used', NULL, 133),
(2314, 'ولاية راخين', 'Rakhine State', '01', 'not_used', NULL, 133),
(2315, 'يانجون', 'Yangon', '17', 'not_used', NULL, 133),
(2316, 'إيراوادي', 'Irrawaddy', '03', 'not_used', NULL, 133),
(2317, 'تيناسيريم', 'Tenasserim', '12', 'not_used', NULL, 133),
(2318, 'ولاية كاران', 'Karan State', '05', 'not_used', NULL, 133),
(2319, 'ساغانغ', 'Sagaing', '10', 'not_used', NULL, 133),
(2320, 'ماغوي', 'Magwe', '07', 'not_used', NULL, 133),
(2321, 'ولاية تشين', 'Chin State', '02', 'not_used', NULL, 133),
(2322, 'ولاية شان', 'Shan State', '11', 'not_used', NULL, 133),
(2323, 'ماندالاي', 'Mandalay', '08', 'not_used', NULL, 133),
(2326, 'ولاية كاياه', 'Kayah State', '06', 'not_used', NULL, 133),
(2328, 'دورنوغوفي', 'Dornogovi', '07', 'not_used', NULL, 134),
(2329, 'أومنجوفي', 'Omnogovi', '14', 'not_used', NULL, 134),
(2330, 'دوندغوفي', 'Dundgovi', '08', 'not_used', NULL, 134),
(2331, 'دزافهان', 'Dzavhan', '09', 'not_used', NULL, 134),
(2332, 'توف', 'Tov', '18', 'not_used', NULL, 134),
(2333, 'ساهباتار', 'Suhbaatar', '17', 'not_used', NULL, 134),
(2334, 'بلغان', 'Bulgan', '21', 'not_used', NULL, 134),
(2335, 'آرهانجاي', 'Arhangay', '01', 'not_used', NULL, 134),
(2336, 'Govisumber', 'Govisumber', '24', 'not_used', NULL, 134),
(2337, 'هينتي', 'Hentiy', '11', 'not_used', NULL, 134),
(2338, 'بيان-أولجي', 'Bayan-Olgiy', '03', 'not_used', NULL, 134),
(2339, 'دورنود', 'Dornod', '06', 'not_used', NULL, 134),
(2340, 'هوفزجول', 'Hovsgol', '13', 'not_used', NULL, 134),
(2341, 'غوفي ألتاي', 'Govi-Altay', '10', 'not_used', NULL, 134),
(2342, 'هوود', 'Hovd', '12', 'not_used', NULL, 134),
(2343, 'سيلينجي', 'Selenge', '16', 'not_used', NULL, 134),
(2344, 'بيانهونجور', 'Bayanhongor', '02', 'not_used', NULL, 134),
(2345, 'أولان باتور', 'Ulaanbaatar', '20', 'not_used', NULL, 134),
(2346, 'أوفورهانجاي', 'Ovorhangay', '15', 'not_used', NULL, 134),
(2347, 'أوفس', 'Uvs', '19', 'not_used', NULL, 134),
(2348, 'Darhan-Uul', 'Darhan-Uul', '23', 'not_used', NULL, 134),
(2349, 'أورهون', 'Orhon', '25', 'not_used', NULL, 134),
(2350, 'Ilhas', 'Ilhas', '01', 'not_used', NULL, 135),
(2363, 'براكنة', 'Brakna', '05', 'not_used', NULL, 138),
(2364, 'هده الشوقي', 'Hodh Ech Chargui', '01', 'not_used', NULL, 138),
(2365, 'غورغول', 'Gorgol', '04', 'not_used', NULL, 138),
(2366, 'العصابة', 'Assaba', '03', 'not_used', NULL, 138),
(2367, 'جواديماكا', 'Guidimaka', '10', 'not_used', NULL, 138),
(2368, 'أدرار', 'Adrar', '07', 'not_used', NULL, 138),
(2369, 'حوده الغربي', 'Hodh El Gharbi', '02', 'not_used', NULL, 138),
(2370, 'تيرس زمور', 'Tiris Zemmour', '11', 'not_used', NULL, 138),
(2371, 'إنشيري', 'Inchiri', '12', 'not_used', NULL, 138),
(2372, 'ترارزة', 'Trarza', '06', 'not_used', NULL, 138),
(2373, 'داخلة نواذيبو', 'Dakhlet Nouadhibou', '08', 'not_used', NULL, 138),
(2375, 'تاغانت', 'Tagant', '09', 'not_used', NULL, 138),
(2376, 'سانت أنتوني', 'Saint Anthony', '01', 'not_used', NULL, 139),
(2377, 'القديس بطرس', 'Saint Peter', '03', 'not_used', NULL, 139),
(2378, 'سانت جورج', 'Saint Georges', '02', 'not_used', NULL, 139),
(2380, 'بورت لويس', 'Port Louis', '18', 'not_used', NULL, 141),
(2381, 'النهر الاسود', 'Black River', '12', 'not_used', NULL, 141),
(2382, 'موكا', 'Moka', '15', 'not_used', NULL, 141),
(2383, 'ريفير دو ريمبارت', 'Riviere du Rempart', '19', 'not_used', NULL, 141),
(2384, 'بامبليماوسيس', 'Pamplemousses', '16', 'not_used', NULL, 141),
(2385, 'رودريغز', 'Rodrigues', '23', 'not_used', NULL, 141),
(2386, 'جراند بورت', 'Grand Port', '14', 'not_used', NULL, 141),
(2387, 'فلاك', 'Flacq', '13', 'not_used', NULL, 141),
(2388, 'بلينز ويلهيمز', 'Plaines Wilhems', '17', 'not_used', NULL, 141),
(2389, 'سافان', 'Savanne', '20', 'not_used', NULL, 141),
(2392, 'سينو', 'Seenu', '01', 'not_used', NULL, 142),
(2393, 'معاليه', 'Maale', '40', 'not_used', NULL, 142),
(2394, 'نكوتاكوتا', 'Nkhotakota', '18', 'not_used', NULL, 143),
(2395, 'رومبي', 'Rumphi', '21', 'not_used', NULL, 143),
(2396, 'مزيمبا', 'Mzimba', '15', 'not_used', NULL, 143),
(2397, 'ليلونغوي', 'Lilongwe', '11', 'not_used', NULL, 143),
(2398, 'نتشيسي', 'Ntchisi', '20', 'not_used', NULL, 143),
(2399, 'سليمة', 'Salima', '22', 'not_used', NULL, 143),
(2400, 'مشينجي', 'Mchinji', '13', 'not_used', NULL, 143),
(2401, 'شيتيبا', 'Chitipa', '04', 'not_used', NULL, 143),
(2402, 'نتشيو', 'Ntcheu', '16', 'not_used', NULL, 143),
(2403, 'الدوا', 'Dowa', '07', 'not_used', NULL, 143),
(2404, 'كاسونغو', 'Kasungu', '09', 'not_used', NULL, 143),
(2405, 'زومبا', 'Zomba', '23', 'not_used', NULL, 143),
(2406, 'نسانجي', 'Nsanje', '19', 'not_used', NULL, 143),
(2407, 'شيكواوا', 'Chikwawa', '02', 'not_used', NULL, 143),
(2408, 'ثيولو', 'Thyolo', '05', 'not_used', NULL, 143),
(2409, 'ديدزا', 'Dedza', '06', 'not_used', NULL, 143),
(2410, 'بالاكا', 'Balaka', '26', 'not_used', NULL, 143),
(2411, 'مانغوتشي', 'Mangochi', '12', 'not_used', NULL, 143),
(2412, 'مشاينجا', 'Machinga', '28', 'not_used', NULL, 143),
(2413, 'خليج نخاتا', 'Nkhata Bay', '17', 'not_used', NULL, 143),
(2414, 'تشيرادزولو', 'Chiradzulu', '03', 'not_used', NULL, 143),
(2415, 'بلانتير', 'Blantyre', '24', 'not_used', NULL, 143),
(2416, 'كارونجا', 'Karonga', '08', 'not_used', NULL, 143),
(2417, 'بالومبي', 'Phalombe', '30', 'not_used', NULL, 143),
(2418, 'موانزا', 'Mwanza', '25', 'not_used', NULL, 143),
(2419, 'مولانجي', 'Mulanje', '29', 'not_used', NULL, 143),
(2420, 'ميتشواكان دي أوكامبو', 'Michoacan de Ocampo', '16', 'not_used', NULL, 144),
(2421, 'تشيهواهوا', 'Chihuahua', '06', 'not_used', NULL, 144),
(2422, 'فيراكروز-افى', 'Veracruz-Llave', '30', 'not_used', NULL, 144),
(2423, 'يوكاتان', 'Yucatan', '31', 'not_used', NULL, 144),
(2424, 'كوينتانا رو', 'Quintana Roo', '23', 'not_used', NULL, 144),
(2425, 'سونورا', 'Sonora', '26', 'not_used', NULL, 144),
(2426, 'تلاكسكالا', 'Tlaxcala', '29', 'not_used', NULL, 144),
(2427, 'تشياباس', 'Chiapas', '05', 'not_used', NULL, 144),
(2428, 'كواهويلا دي سرقسطة', 'Coahuila de Zaragoza', '07', 'not_used', NULL, 144),
(2429, 'دورانجو', 'Durango', '10', 'not_used', NULL, 144),
(2430, 'غواناخواتو', 'Guanajuato', '11', 'not_used', NULL, 144),
(2431, 'نويفو ليون', 'Nuevo Leon', '19', 'not_used', NULL, 144),
(2432, 'أواكساكا', 'Oaxaca', '20', 'not_used', NULL, 144),
(2433, 'تاباسكو', 'Tabasco', '27', 'not_used', NULL, 144),
(2434, 'تاماوليباس', 'Tamaulipas', '28', 'not_used', NULL, 144),
(2435, 'غيريرو', 'Guerrero', '12', 'not_used', NULL, 144),
(2436, 'باجا كاليفورنيا', 'Baja California', '02', 'not_used', NULL, 144),
(2437, 'كامبيتشي', 'Campeche', '04', 'not_used', NULL, 144),
(2438, 'ناياريت', 'Nayarit', '18', 'not_used', NULL, 144),
(2439, 'بويبلا', 'Puebla', '21', 'not_used', NULL, 144),
(2440, 'سينالوا', 'Sinaloa', '25', 'not_used', NULL, 144),
(2441, 'اغواسكالينتيس', 'Aguascalientes', '01', 'not_used', NULL, 144),
(2442, 'سان لويس بوتوسي', 'San Luis Potosi', '24', 'not_used', NULL, 144),
(2443, 'زاكاتيكاس', 'Zacatecas', '32', 'not_used', NULL, 144),
(2444, 'المكسيك', 'Mexico', '15', 'not_used', NULL, 144),
(2445, 'خاليسكو', 'Jalisco', '14', 'not_used', NULL, 144),
(2446, 'الهيدلج من نبلاء الأسبان', 'Hidalgo', '13', 'not_used', NULL, 144),
(2447, 'موريلوس', 'Morelos', '17', 'not_used', NULL, 144),
(2448, 'كوليما', 'Colima', '08', 'not_used', NULL, 144),
(2449, 'كويريتارو دي أرتياغا', 'Queretaro de Arteaga', '22', 'not_used', NULL, 144),
(2450, 'باجا كاليفورنيا سور', 'Baja California Sur', '03', 'not_used', NULL, 144),
(2451, 'وفي مقاطعة الاتحادية', 'Distrito Federal', '09', 'not_used', NULL, 144),
(2452, 'ساراواك', 'Sarawak', '11', 'not_used', NULL, 145),
(2453, 'صباح', 'Sabah', '16', 'not_used', NULL, 145),
(2454, 'ملقا', 'Melaka', '04', 'not_used', NULL, 145),
(2455, 'برليس', 'Perlis', '08', 'not_used', NULL, 145),
(2456, 'نيجري سيمبيلان', 'Negeri Sembilan', '05', 'not_used', NULL, 145),
(2457, 'كيدا', 'Kedah', '02', 'not_used', NULL, 145),
(2458, 'جوهور', 'Johor', '01', 'not_used', NULL, 145),
(2459, 'بيراك', 'Perak', '07', 'not_used', NULL, 145),
(2460, 'بولاو بينانج', 'Pulau Pinang', '09', 'not_used', NULL, 145),
(2461, 'تيرينجانو', 'Terengganu', '13', 'not_used', NULL, 145),
(2462, 'كيلانتان', 'Kelantan', '03', 'not_used', NULL, 145),
(2463, 'باهانج', 'Pahang', '06', 'not_used', NULL, 145),
(2464, 'كوالا لامبور', 'Kuala Lumpur', '14', 'not_used', NULL, 145),
(2465, 'سيلانغور', 'Selangor', '12', 'not_used', NULL, 145),
(2466, 'لابوان', 'Labuan', '15', 'not_used', NULL, 145),
(2467, 'مابوتو', 'Maputo', '04', 'not_used', NULL, 146),
(2468, 'نامبولا', 'Nampula', '06', 'not_used', NULL, 146),
(2469, 'زامبيزيا', 'Zambezia', '09', 'not_used', NULL, 146),
(2470, 'نياسا', 'Niassa', '07', 'not_used', NULL, 146),
(2471, 'كابو دلغادو', 'Cabo Delgado', '01', 'not_used', NULL, 146),
(2472, 'غزة', 'Gaza', '02', 'not_used', NULL, 146),
(2473, 'إنهامبان', 'Inhambane', '03', 'not_used', NULL, 146),
(2474, 'مانيكا', 'Manica', '10', 'not_used', NULL, 146),
(2475, 'تيتي', 'Tete', '08', 'not_used', NULL, 146),
(2476, 'سوفالا', 'Sofala', '05', 'not_used', NULL, 146),
(2478, 'هارداب', 'Hardap', '30', 'not_used', NULL, 147),
(2479, 'أوتجوزوندتوبا', 'Otjozondjupa', '39', 'not_used', NULL, 147),
(2481, 'كاراس', 'Karas', '31', 'not_used', NULL, 147),
(2482, 'أوموساتي', 'Omusati', '36', 'not_used', NULL, 147),
(2483, 'أوشانا', 'Oshana', '37', 'not_used', NULL, 147),
(2484, 'كونين', 'Kunene', '32', 'not_used', NULL, 147),
(2485, 'إيرونغو', 'Erongo', '29', 'not_used', NULL, 147),
(2486, 'أوشيكوتو', 'Oshikoto', '38', 'not_used', NULL, 147),
(2487, 'أوماهيكي', 'Omaheke', '35', 'not_used', NULL, 147),
(2488, 'كابريفي', 'Caprivi', '28', 'not_used', NULL, 147),
(2489, 'أوكافانغو', 'Okavango', '34', 'not_used', NULL, 147),
(2490, 'أوهانغوينا', 'Ohangwena', '33', 'not_used', NULL, 147),
(2491, 'ويندهوك', 'Windhoek', '21', 'not_used', NULL, 147),
(2493, 'نيامي', 'Niamey', '05', 'not_used', NULL, 149),
(2494, 'ديفا', 'Diffa', '02', 'not_used', NULL, 149),
(2496, 'تاهوا', 'Tahoua', '06', 'not_used', NULL, 149),
(2497, 'أغاديز', 'Agadez', '01', 'not_used', NULL, 149),
(2498, 'زيندر', 'Zinder', '07', 'not_used', NULL, 149),
(2499, 'دوسو', 'Dosso', '03', 'not_used', NULL, 149),
(2500, 'مرادي', 'Maradi', '04', 'not_used', NULL, 149),
(2501, 'نيامي', 'Niamey', '08', 'not_used', NULL, 149),
(2504, 'بينو', 'Benue', '26', 'not_used', NULL, 151),
(2505, 'ناساراوا', 'Nassarawa', '56', 'not_used', NULL, 151),
(2506, 'كادونا', 'Kaduna', '23', 'not_used', NULL, 151),
(2507, 'أويو', 'Oyo', '32', 'not_used', NULL, 151),
(2508, 'أداماوا', 'Adamawa', '35', 'not_used', NULL, 151),
(2509, 'أوسان', 'Osun', '42', 'not_used', NULL, 151),
(2510, 'بورنو', 'Borno', '27', 'not_used', NULL, 151),
(2511, 'بوتشي', 'Bauchi', '46', 'not_used', NULL, 151),
(2513, 'أوجون', 'Ogun', '16', 'not_used', NULL, 151),
(2514, 'انامبرا', 'Anambra', '25', 'not_used', NULL, 151),
(2515, 'يوبي', 'Yobe', '44', 'not_used', NULL, 151),
(2516, 'لاغوس', 'Lagos', '05', 'not_used', NULL, 151),
(2517, 'دلتا', 'Delta', '36', 'not_used', NULL, 151),
(2518, 'إينوغو', 'Enugu', '47', 'not_used', NULL, 151),
(2519, 'إقليم العاصمة الفيدرالية', 'Federal Capital Territory', '11', 'not_used', NULL, 151),
(2520, 'كوجى', 'Kogi', '41', 'not_used', NULL, 151),
(2521, 'تارابا', 'Taraba', '43', 'not_used', NULL, 151),
(2522, 'أكوا إيبوم', 'Akwa Ibom', '21', 'not_used', NULL, 151),
(2523, 'إيبوني', 'Ebonyi', '53', 'not_used', NULL, 151),
(2525, 'المنظمة البحرية الدولية', 'Imo', '28', 'not_used', NULL, 151),
(2526, 'جيغاوا', 'Jigawa', '39', 'not_used', NULL, 151),
(2528, 'كوارا', 'Kwara', '30', 'not_used', NULL, 151),
(2529, 'أبيا', 'Abia', '45', 'not_used', NULL, 151),
(2530, 'غومبي', 'Gombe', '55', 'not_used', NULL, 151),
(2531, 'عبر نهر', 'Cross River', '22', 'not_used', NULL, 151),
(2532, 'كاتسينا', 'Katsina', '24', 'not_used', NULL, 151),
(2533, 'سوكوتو', 'Sokoto', '51', 'not_used', NULL, 151),
(2534, 'النيجر', 'Niger', '31', 'not_used', NULL, 151),
(2535, 'زامفارا', 'Zamfara', '57', 'not_used', NULL, 151),
(2536, 'ايدو', 'Edo', '37', 'not_used', NULL, 151),
(2538, 'كانو', 'Kano', '29', 'not_used', NULL, 151),
(2539, 'كيبي', 'Kebbi', '40', 'not_used', NULL, 151),
(2540, 'إكيتي', 'Ekiti', '54', 'not_used', NULL, 151),
(2541, 'بايلسا', 'Bayelsa', '52', 'not_used', NULL, 151),
(2542, 'هضبة', 'Plateau', '49', 'not_used', NULL, 151),
(2543, 'أوندو', 'Ondo', '48', 'not_used', NULL, 151),
(2544, 'الأنهار', 'Rivers', '50', 'not_used', NULL, 151),
(2547, 'ليون', 'Leon', '08', 'not_used', NULL, 152),
(2548, 'شونتالز', 'Chontales', '04', 'not_used', NULL, 152),
(2549, 'ماناغوا', 'Managua', '10', 'not_used', NULL, 152),
(2550, 'أوتومونا أتلانتيكو نورتي', 'Autonoma Atlantico Norte', '17', 'not_used', NULL, 152),
(2551, 'غرناطة', 'Granada', '06', 'not_used', NULL, 152),
(2552, 'ماتاغلبا', 'Matagalpa', '12', 'not_used', NULL, 152),
(2553, 'بواكو', 'Boaco', '01', 'not_used', NULL, 152),
(2554, 'كارازو', 'Carazo', '02', 'not_used', NULL, 152),
(2555, 'تشينانديغا', 'Chinandega', '03', 'not_used', NULL, 152),
(2556, 'ريو سان خوان', 'Rio San Juan', '14', 'not_used', NULL, 152),
(2557, 'ريفاس', 'Rivas', '15', 'not_used', NULL, 152),
(2558, 'مسايا', 'Masaya', '11', 'not_used', NULL, 152),
(2559, 'خينوتيغا', 'Jinotega', '07', 'not_used', NULL, 152),
(2560, 'نويفا سيجوفيا', 'Nueva Segovia', '13', 'not_used', NULL, 152),
(2561, 'منطقة الاستقلال الذاتي اتلانتيكو سور', 'Region Autonoma Atlantico Sur', '18', 'not_used', NULL, 152),
(2562, 'مادريز', 'Madriz', '09', 'not_used', NULL, 152),
(2563, 'إستيلي', 'Esteli', '05', 'not_used', NULL, 152),
(2564, 'درينثي', 'Drenthe', '01', 'not_used', NULL, 153),
(2565, 'زويد-هولندا', 'Zuid-Holland', '11', 'not_used', NULL, 153),
(2566, 'أوفيريجسيل', 'Overijssel', '15', 'not_used', NULL, 153),
(2567, 'نورد هولاند', 'Noord-Holland', '07', 'not_used', NULL, 153),
(2568, 'زيلاند', 'Zeeland', '10', 'not_used', NULL, 153),
(2569, 'ليمبورغ', 'Limburg', '05', 'not_used', NULL, 153),
(2570, 'نورد برابانت', 'Noord-Brabant', '06', 'not_used', NULL, 153),
(2571, 'جيلديرلاند', 'Gelderland', '03', 'not_used', NULL, 153),
(2572, 'فريسلاند', 'Friesland', '02', 'not_used', NULL, 153),
(2573, 'جرونينجن', 'Groningen', '04', 'not_used', NULL, 153),
(2574, 'أوتريخت', 'Utrecht', '09', 'not_used', NULL, 153),
(2575, 'فليفولاند', 'Flevoland', '16', 'not_used', NULL, 153),
(2576, 'نوردلاند', 'Nordland', '09', 'not_used', NULL, 154),
(2577, 'تروندلاج', 'Sor-Trondelag', '16', 'not_used', NULL, 154),
(2578, 'ترومس', 'Troms', '18', 'not_used', NULL, 154),
(2579, 'فيستفولد', 'Vestfold', '20', 'not_used', NULL, 154),
(2580, 'هدمارك', 'Hedmark', '06', 'not_used', NULL, 154),
(2581, 'هوردالاند', 'Hordaland', '07', 'not_used', NULL, 154),
(2582, 'سترة-أغدر', 'Vest-Agder', '19', 'not_used', NULL, 154),
(2583, 'أكثر أوج رومسدال', 'More og Romsdal', '08', 'not_used', NULL, 154),
(2584, 'تيليمارك', 'Telemark', '17', 'not_used', NULL, 154),
(2585, 'بوسكيرود', 'Buskerud', '04', 'not_used', NULL, 154),
(2586, 'روغالاند', 'Rogaland', '14', 'not_used', NULL, 154),
(2587, 'أوست-أغدر', 'Aust-Agder', '02', 'not_used', NULL, 154),
(2588, 'أوبلاند', 'Oppland', '11', 'not_used', NULL, 154),
(2589, 'سوغن أوغ فيوردان', 'Sogn og Fjordane', '15', 'not_used', NULL, 154),
(2590, 'آكيرشوس', 'Akershus', '01', 'not_used', NULL, 154),
(2591, 'نور-ترونديلاغ', 'Nord-Trondelag', '10', 'not_used', NULL, 154),
(2592, 'أوستفولد', 'Ostfold', '13', 'not_used', NULL, 154),
(2593, 'فينمارك', 'Finnmark', '05', 'not_used', NULL, 154),
(2594, 'أوسلو', 'Oslo', '12', 'not_used', NULL, 154),
(2598, 'ولينغتون', 'Wellington', 'G2', 'not_used', NULL, 158),
(2599, 'الساحل الغربي', 'West Coast', 'G3', 'not_used', NULL, 158),
(2600, 'كانتربري', 'Canterbury', 'E9', 'not_used', NULL, 158),
(2601, 'أوتاجو', 'Otago', 'F7', 'not_used', NULL, 158),
(2602, 'أوكلاند', 'Auckland', 'E7', 'not_used', NULL, 158),
(2603, 'جيسبورن', 'Gisborne', 'F1', 'not_used', NULL, 158),
(2604, 'خليج هوكس', 'Hawke\'s Bay', 'F2', 'not_used', NULL, 158),
(2605, 'تاراناكي', 'Taranaki', 'F9', 'not_used', NULL, 158),
(2606, 'مارلبورو', 'Marlborough', 'F4', 'not_used', NULL, 158),
(2607, 'نيلسون', 'Nelson', 'F5', 'not_used', NULL, 158),
(2608, 'وايكاتو', 'Waikato', 'G1', 'not_used', NULL, 158),
(2609, 'ساوثلاند', 'Southland', 'F8', 'not_used', NULL, 158),
(2611, 'خليج بلنتي', 'Bay of Plenty', 'E8', 'not_used', NULL, 158),
(2613, 'ماناواتو-وانجانوي', 'Manawatu-Wanganui', 'F3', 'not_used', NULL, 158),
(2614, 'الباطنة', 'Al Batinah', '02', 'not_used', NULL, 159),
(2615, 'الزاهرة', 'Az Zahirah', '05', 'not_used', NULL, 159),
(2616, 'الشرقية', 'Ash Sharqiyah', '04', 'not_used', NULL, 159),
(2617, 'مسقط', 'Masqat', '06', 'not_used', NULL, 159),
(2618, 'مسندم', 'Musandam', '07', 'not_used', NULL, 159),
(2619, 'ظفار', 'Zufar', '08', 'not_used', NULL, 159),
(2621, 'لوس سانتوس', 'Los Santos', '07', 'not_used', NULL, 160),
(2622, 'دارين', 'Darien', '05', 'not_used', NULL, 160),
(2623, 'شيريكي', 'Chiriqui', '02', 'not_used', NULL, 160),
(2624, 'القولون', 'Colon', '04', 'not_used', NULL, 160),
(2625, 'فيراغواس', 'Veraguas', '10', 'not_used', NULL, 160),
(2626, 'سان بلاس', 'San Blas', '09', 'not_used', NULL, 160),
(2627, 'بوكاس ديل تورو', 'Bocas del Toro', '01', 'not_used', NULL, 160),
(2628, 'هيريرا', 'Herrera', '06', 'not_used', NULL, 160),
(2629, 'بناما', 'Panama', '08', 'not_used', NULL, 160),
(2630, 'كوكلي', 'Cocle', '03', 'not_used', NULL, 160),
(2631, 'انكاش', 'Ancash', '02', 'not_used', NULL, 161),
(2632, 'ابوريماك', 'Apurimac', '03', 'not_used', NULL, 161),
(2633, 'أريكويبا', 'Arequipa', '04', 'not_used', NULL, 161),
(2634, 'إيكا', 'Ica', '11', 'not_used', NULL, 161),
(2635, 'كوسكو', 'Cusco', '08', 'not_used', NULL, 161),
(2636, 'امبايكي', 'Lambayeque', '14', 'not_used', NULL, 161),
(2637, 'أوكايالي', 'Ucayali', '25', 'not_used', NULL, 161),
(2638, 'لا ليبرتاد', 'La Libertad', '13', 'not_used', NULL, 161),
(2639, 'اياكوتشو', 'Ayacucho', '05', 'not_used', NULL, 161),
(2640, 'ليما', 'Lima', '15', 'not_used', NULL, 161),
(2641, 'بونو', 'Puno', '21', 'not_used', NULL, 161),
(2642, 'جونين', 'Junin', '12', 'not_used', NULL, 161),
(2643, 'أديس أبابا', 'Tumbes', '24', 'not_used', NULL, 161),
(2644, 'تاكنا', 'Tacna', '23', 'not_used', NULL, 161),
(2645, 'كاخاماركا', 'Cajamarca', '06', 'not_used', NULL, 161),
(2646, 'هوانكافليكا', 'Huancavelica', '09', 'not_used', NULL, 161),
(2647, 'موكيجوا', 'Moquegua', '18', 'not_used', NULL, 161),
(2648, 'أمازوناس', 'Amazonas', '01', 'not_used', NULL, 161),
(2649, 'هوانوكو', 'Huanuco', '10', 'not_used', NULL, 161),
(2650, 'سان مارتن', 'San Martin', '22', 'not_used', NULL, 161),
(2651, 'بيورا', 'Piura', '20', 'not_used', NULL, 161),
(2652, 'لوريتو', 'Loreto', '16', 'not_used', NULL, 161),
(2653, 'باسكو', 'Pasco', '19', 'not_used', NULL, 161),
(2654, 'مادري دي ديوس', 'Madre de Dios', '17', 'not_used', NULL, 161),
(2655, 'كالاو', 'Callao', '07', 'not_used', NULL, 161),
(2657, 'المرتفعات الشرقية', 'Eastern Highlands', '09', 'not_used', NULL, 163),
(2658, 'مادانغ', 'Madang', '12', 'not_used', NULL, 163),
(2659, 'خليج ميلن', 'Milne Bay', '03', 'not_used', NULL, 163),
(2660, 'الغربي', 'Western', '06', 'not_used', NULL, 163),
(2661, 'وسط', 'Central', '01', 'not_used', NULL, 163),
(2662, 'ساندون', 'Sandaun', '18', 'not_used', NULL, 163),
(2663, 'شرق سيبيك', 'East Sepik', '11', 'not_used', NULL, 163),
(2664, 'غرب بريطانيا الجديدة', 'West New Britain', '17', 'not_used', NULL, 163),
(2665, 'المرتفعات الجنوبية', 'Southern Highlands', '05', 'not_used', NULL, 163),
(2666, 'شمالي', 'Northern', '04', 'not_used', NULL, 163),
(2667, 'خليج', 'Gulf', '02', 'not_used', NULL, 163),
(2668, 'المرتفعات الغربية', 'Western Highlands', '16', 'not_used', NULL, 163),
(2669, 'موروبى', 'Morobe', '14', 'not_used', NULL, 163),
(2670, 'شيمبو', 'Chimbu', '08', 'not_used', NULL, 163),
(2671, 'شرق بريطانيا الجديدة', 'East New Britain', '10', 'not_used', NULL, 163),
(2672, 'شمال سولومونز', 'North Solomons', '07', 'not_used', NULL, 163),
(2673, 'انجا', 'Enga', '19', 'not_used', NULL, 163),
(2674, 'اليد', 'Manus', '13', 'not_used', NULL, 163),
(2675, 'أيرلندا الجديدة', 'New Ireland', '15', 'not_used', NULL, 163),
(2676, 'رأس المال الوطني', 'National Capital', '20', 'not_used', NULL, 163),
(2677, 'بانجاسينان', 'Pangasinan', '51', 'not_used', NULL, 164),
(2678, 'سيبو', 'Cebu', '21', 'not_used', NULL, 164),
(2679, 'سمر', 'Samar', '55', 'not_used', NULL, 164),
(2680, 'كامارينز سور', 'Camarines Sur', '16', 'not_used', NULL, 164),
(2681, 'لويلو', 'Iloilo', '30', 'not_used', NULL, 164),
(2682, 'ايلوكوس نورتي', 'Ilocos Norte', '28', 'not_used', NULL, 164),
(2683, 'أثر قديم', 'Antique', '06', 'not_used', NULL, 164),
(2684, 'بوهول', 'Bohol', '11', 'not_used', NULL, 164),
(2685, 'كاجايان', 'Cagayan', '14', 'not_used', NULL, 164),
(2686, 'سمر الشرقية', 'Eastern Samar', '23', 'not_used', NULL, 164),
(2687, 'دافاو', 'Davao', '24', 'not_used', NULL, 164),
(2688, 'يتي', 'Leyte', '37', 'not_used', NULL, 164),
(2689, 'ماسبات', 'Masbate', '39', 'not_used', NULL, 164),
(2690, 'نيجروس اوكسيدنتال', 'Negros Occidental', '45', 'not_used', NULL, 164),
(2691, 'نويفا فيزكايا', 'Nueva Vizcaya', '48', 'not_used', NULL, 164),
(2692, 'رومبلون', 'Romblon', '54', 'not_used', NULL, 164),
(2693, 'جنوب كوتاباتو', 'South Cotabato', '70', 'not_used', NULL, 164),
(2694, 'ايلوكوس سور', 'Ilocos Sur', '29', 'not_used', NULL, 164),
(2695, 'كويزون', 'Quezon', 'H2', 'not_used', NULL, 164),
(2696, 'لاناو ديل نورتي', 'Lanao del Norte', '34', 'not_used', NULL, 164),
(2697, 'شمال كوتاباتو', 'North Cotabato', '57', 'not_used', NULL, 164),
(2698, 'سوريجاو ديل سور', 'Surigao del Sur', '62', 'not_used', NULL, 164),
(2699, 'اليجان', 'Iligan', 'C8', 'not_used', NULL, 164),
(2700, 'جنوب ليتي', 'Southern Leyte', '59', 'not_used', NULL, 164),
(2701, 'تارلاك', 'Tarlac', '63', 'not_used', NULL, 164),
(2702, 'بوكيدنون', 'Bukidnon', '12', 'not_used', NULL, 164),
(2703, 'ميندورو اوكسيدنتال', 'Mindoro Occidental', '40', 'not_used', NULL, 164),
(2704, 'بالاوان', 'Palawan', '49', 'not_used', NULL, 164),
(2705, 'العبرة', 'Abra', '01', 'not_used', NULL, 164),
(2706, 'بولاكان', 'Bulacan', '13', 'not_used', NULL, 164),
(2707, 'كابيز', 'Capiz', '18', 'not_used', NULL, 164),
(2708, 'Nueva Ecija', 'Nueva Ecija', '47', 'not_used', NULL, 164),
(2709, 'سورسوجون', 'Sorsogon', '58', 'not_used', NULL, 164),
(2710, 'بينجويت', 'Benguet', '10', 'not_used', NULL, 164),
(2711, 'شمال سمر', 'Northern Samar', '67', 'not_used', NULL, 164),
(2712, 'كويرينو', 'Quirino', '68', 'not_used', NULL, 164),
(2713, 'ايزابيلا', 'Isabela', '31', 'not_used', NULL, 164),
(2714, 'كالينجا-أباياو', 'Kalinga-Apayao', '32', 'not_used', NULL, 164),
(2715, 'جبل', 'Mountain', '44', 'not_used', NULL, 164),
(2716, 'الباي', 'Albay', '05', 'not_used', NULL, 164),
(2717, 'باتانجاس', 'Batangas', '09', 'not_used', NULL, 164),
(2718, 'كاتاندونيز', 'Catanduanes', '19', 'not_used', NULL, 164),
(2719, 'نيجروس أورينتال', 'Negros Oriental', '46', 'not_used', NULL, 164),
(2720, 'إيفوغاو', 'Ifugao', '27', 'not_used', NULL, 164),
(2721, 'ميساميس اورينتال', 'Misamis Oriental', '43', 'not_used', NULL, 164),
(2722, 'لاغونا', 'Laguna', '33', 'not_used', NULL, 164),
(2723, 'زامبوانجا ديل سور', 'Zamboanga del Sur', '66', 'not_used', NULL, 164),
(2724, 'كاميجوين', 'Camiguin', '17', 'not_used', NULL, 164),
(2725, 'نيجروس اوكسيدنتال', 'Negros Occidental', 'H3', 'not_used', NULL, 164),
(2726, 'باتان', 'Bataan', '07', 'not_used', NULL, 164),
(2727, 'لاناو ديل سور', 'Lanao del Sur', '35', 'not_used', NULL, 164),
(2728, 'باسيلان', 'Basilan', '22', 'not_used', NULL, 164),
(2729, 'لا يونيون', 'La Union', '36', 'not_used', NULL, 164),
(2730, 'كامارينز نورتي', 'Camarines Norte', '15', 'not_used', NULL, 164),
(2731, 'كالوكان', 'Caloocan', 'B4', 'not_used', NULL, 164),
(2732, 'يغاسبي', 'Legaspi', 'D5', 'not_used', NULL, 164),
(2733, 'من Calbayog', 'Calbayog', 'B3', 'not_used', NULL, 164),
(2734, 'أغوسان ديل نورتي', 'Agusan del Norte', '02', 'not_used', NULL, 164),
(2735, 'بامبانجا', 'Pampanga', '50', 'not_used', NULL, 164),
(2736, 'ميندورو الشرقية', 'Mindoro Oriental', '41', 'not_used', NULL, 164),
(2738, 'سولو', 'Sulu', '60', 'not_used', NULL, 164),
(2739, 'مدينة سيبو', 'Cebu City', 'B7', 'not_used', NULL, 164),
(2740, 'روكساس', 'Roxas', 'F3', 'not_used', NULL, 164),
(2741, 'ميساميس اوكسيدنتال', 'Misamis Occidental', '42', 'not_used', NULL, 164),
(2742, 'اكلان', 'Aklan', '04', 'not_used', NULL, 164),
(2743, 'ماجوينداناو', 'Maguindanao', '56', 'not_used', NULL, 164),
(2744, 'دوماغويتي', 'Dumaguete', 'C5', 'not_used', NULL, 164),
(2745, 'سوريجاو ديل نورتي', 'Surigao del Norte', '61', 'not_used', NULL, 164),
(2746, 'اورموك', 'Ormoc', 'E4', 'not_used', NULL, 164),
(2747, 'دافاو ديل سور', 'Davao del Sur', '25', 'not_used', NULL, 164),
(2748, 'زامباليس', 'Zambales', '64', 'not_used', NULL, 164),
(2749, 'أغوسان ديل سور', 'Agusan del Sur', '03', 'not_used', NULL, 164),
(2751, 'لابو لابو لابو', 'Lapu-Lapu', 'D4', 'not_used', NULL, 164),
(2752, 'ماريندوك', 'Marinduque', '38', 'not_used', NULL, 164),
(2753, 'ريزال', 'Rizal', '53', 'not_used', NULL, 164),
(2754, 'بوتوان', 'Butuan', 'A8', 'not_used', NULL, 164),
(2755, 'كاجايان دي أورو', 'Cagayan de Oro', 'B2', 'not_used', NULL, 164),
(2756, 'باساي', 'Pasay', 'E9', 'not_used', NULL, 164),
(2757, 'سلطان كودارات', 'Sultan Kudarat', '71', 'not_used', NULL, 164),
(2758, 'مدينة دافاو', 'Davao City', 'C3', 'not_used', NULL, 164),
(2759, 'كافيت', 'Cavite', '20', 'not_used', NULL, 164),
(2760, 'مدينة ايلويلو', 'Iloilo City', 'C9', 'not_used', NULL, 164),
(2761, 'سيالي', 'Silay', 'F8', 'not_used', NULL, 164),
(2762, 'باجاديان', 'Pagadian', 'E7', 'not_used', NULL, 164),
(2763, 'تريسي مارتيرز', 'Trece Martires', 'G6', 'not_used', NULL, 164),
(2764, 'مدينة كويزون', 'Quezon City', 'F2', 'not_used', NULL, 164),
(2765, 'سيكويجور', 'Siquijor', '69', 'not_used', NULL, 164),
(2766, 'كوتاباتو', 'Cotabato', 'B8', 'not_used', NULL, 164),
(2767, 'لوس', 'Angeles', 'A1', 'not_used', NULL, 164),
(2768, 'توليدو', 'Toledo', 'G5', 'not_used', NULL, 164),
(2769, 'سان كارلوس', 'San Carlos', 'F4', 'not_used', NULL, 164),
(2770, 'ليبا', 'Lipa', 'D6', 'not_used', NULL, 164),
(2771, 'دافاو اورينتال', 'Davao Oriental', '26', 'not_used', NULL, 164),
(2772, 'تاكلوبان', 'Tacloban', 'G1', 'not_used', NULL, 164),
(2773, 'من Tawitawi', 'Tawitawi', '72', 'not_used', NULL, 164),
(2775, 'Zamboanga del Norte', 'Zamboanga del Norte', '65', 'not_used', NULL, 164),
(2776, 'زامبوانغا', 'Zamboanga', 'G7', 'not_used', NULL, 164),
(2777, 'باكولود', 'Bacolod', 'A2', 'not_used', NULL, 164),
(2778, 'مراوي', 'Marawi', 'E1', 'not_used', NULL, 164),
(2779, 'فجر', 'Aurora', 'G8', 'not_used', NULL, 164),
(2780, 'من Ozamis', 'Ozamis', 'E6', 'not_used', NULL, 164),
(2781, 'داناو', 'Danao', 'C1', 'not_used', NULL, 164),
(2782, 'باجو', 'Bago', 'A3', 'not_used', NULL, 164),
(2783, 'كاباناتوان', 'Cabanatuan', 'A9', 'not_used', NULL, 164),
(2785, 'باجيو', 'Baguio', 'A4', 'not_used', NULL, 164),
(2786, 'تانجوب', 'Tangub', 'G4', 'not_used', NULL, 164),
(2787, 'النجا', 'Naga', 'E2', 'not_used', NULL, 164),
(2788, 'اولونجابو', 'Olongapo', 'E3', 'not_used', NULL, 164),
(2789, 'سان بابلو', 'San Pablo', 'F7', 'not_used', NULL, 164),
(2790, 'Oroquieta', 'Oroquieta', 'E5', 'not_used', NULL, 164),
(2791, 'مانيلا', 'Manila', 'D9', 'not_used', NULL, 164),
(2792, 'سان خوان', 'San Juan', 'M6', 'not_used', NULL, 164),
(2793, 'الجنرال سانتوس', 'General Santos', 'C6', 'not_used', NULL, 164),
(2794, 'Dapitan', 'Dapitan', 'C2', 'not_used', NULL, 164),
(2795, 'Canlaon', 'Canlaon', 'B5', 'not_used', NULL, 164),
(2796, 'داغوبان', 'Dagupan', 'B9', 'not_used', NULL, 164),
(2798, 'باتانيس', 'Batanes', '08', 'not_used', NULL, 164),
(2799, 'باتانجاس سيتي', 'Batangas City', 'A7', 'not_used', NULL, 164),
(2800, 'من Dipolog', 'Dipolog', 'C4', 'not_used', NULL, 164),
(2802, 'تاغبيلاران', 'Tagbilaran', 'G3', 'not_used', NULL, 164),
(2803, 'كاديز', 'Cadiz', 'B1', 'not_used', NULL, 164),
(2804, 'مانداوي', 'Mandaue', 'D8', 'not_used', NULL, 164),
(2805, 'مدينة كافيت', 'Cavite City', 'B6', 'not_used', NULL, 164),
(2806, 'تاجايتاى', 'Tagaytay', 'G2', 'not_used', NULL, 164),
(2807, 'Gingoog', 'Gingoog', 'C7', 'not_used', NULL, 164),
(2808, 'Iriga', 'Iriga', 'D1', 'not_used', NULL, 164),
(2809, 'Paranaque', 'Paranaque', 'L7', 'not_used', NULL, 164),
(2811, 'لا كارلوتا', 'La Carlota', 'D2', 'not_used', NULL, 164),
(2812, 'اواج', 'Laoag', 'D3', 'not_used', NULL, 164),
(2813, 'لوسينا', 'Lucena', 'D7', 'not_used', NULL, 164),
(2814, 'مالايبالاي', 'Malaybalay', 'K6', 'not_used', NULL, 164),
(2815, 'Palayan', 'Palayan', 'E8', 'not_used', NULL, 164),
(2816, 'بويرتو برنسيسا', 'Puerto Princesa', 'F1', 'not_used', NULL, 164),
(2817, 'سوريجاو', 'Surigao', 'F9', 'not_used', NULL, 164),
(2818, 'البنجاب', 'Punjab', '04', 'not_used', NULL, 165),
(2819, 'السند', 'Sindh', '05', 'not_used', NULL, 165),
(2820, 'بلوشستان', 'Balochistan', '02', 'not_used', NULL, 165),
(2821, 'الحدود الشمالية الغربية', 'North-West Frontier', '03', 'not_used', NULL, 165),
(2822, 'المناطق الشمالية', 'Northern Areas', '07', 'not_used', NULL, 165),
(2823, 'المناطق القبلية الخاضعة للإدارة الاتحادية', 'Federally Administered Tribal Areas', '01', 'not_used', NULL, 165),
(2824, 'آزاد كشمير', 'Azad Kashmir', '06', 'not_used', NULL, 165),
(2825, 'اسلام اباد', 'Islamabad', '08', 'not_used', NULL, 165),
(2833, 'زاخودنيبومورسكي', 'Zachodniopomorskie', '87', 'not_used', NULL, 166),
(2835, 'سفيتوكرجيسكي', 'Swietokrzyskie', '84', 'not_used', NULL, 166);
INSERT INTO `cities` (`id`, `name_ar`, `name_en`, `code`, `status`, `shipping_price`, `country_id`) VALUES
(2864, 'ودزكي', 'Lodzkie', '74', 'not_used', NULL, 166),
(2866, 'فارمينسكو مازورسكي', 'Warminsko-Mazurskie', '85', 'not_used', NULL, 166),
(2872, 'مالوبولسكا', 'Malopolskie', '77', 'not_used', NULL, 166),
(2874, 'مازوفيتسكي', 'Mazowieckie', '78', 'not_used', NULL, 166),
(2876, 'بودلاسكي', 'Podlaskie', '81', 'not_used', NULL, 166),
(2880, 'بودكارباتسكي', 'Podkarpackie', '80', 'not_used', NULL, 166),
(2881, 'وبوسكي', 'Lubuskie', '76', 'not_used', NULL, 166),
(2882, 'DOLNOSLASKIE', 'Dolnoslaskie', '72', 'not_used', NULL, 166),
(2883, 'وبليسكي', 'Lubelskie', '75', 'not_used', NULL, 166),
(2884, 'بومورسكي', 'Pomorskie', '82', 'not_used', NULL, 166),
(2885, 'كوجاوسكو بومورسكي', 'Kujawsko-Pomorskie', '73', 'not_used', NULL, 166),
(2886, 'فيلكوبولسكي', 'Wielkopolskie', '86', 'not_used', NULL, 166),
(2887, 'سلاسكي', 'Slaskie', '83', 'not_used', NULL, 166),
(2888, 'أوبولسكي', 'Opolskie', '79', 'not_used', NULL, 166),
(2893, 'براغا', 'Braga', '04', 'not_used', NULL, 170),
(2894, 'فيلا ريال', 'Vila Real', '21', 'not_used', NULL, 170),
(2895, 'سانتاريم', 'Santarem', '18', 'not_used', NULL, 170),
(2896, 'ليريا', 'Leiria', '13', 'not_used', NULL, 170),
(2897, 'لشبونة', 'Lisboa', '14', 'not_used', NULL, 170),
(2898, 'براغانكا', 'Braganca', '05', 'not_used', NULL, 170),
(2899, 'فيانا دو كاستيلو', 'Viana do Castelo', '20', 'not_used', NULL, 170),
(2900, 'بورتاليجري', 'Portalegre', '16', 'not_used', NULL, 170),
(2901, 'سيتوبال', 'Setubal', '19', 'not_used', NULL, 170),
(2902, 'الأزور', 'Azores', '23', 'not_used', NULL, 170),
(2903, 'فيسيو', 'Viseu', '22', 'not_used', NULL, 170),
(2904, 'بورتو', 'Porto', '17', 'not_used', NULL, 170),
(2905, 'افيرو', 'Aveiro', '02', 'not_used', NULL, 170),
(2906, 'كاستيلو برانكو', 'Castelo Branco', '06', 'not_used', NULL, 170),
(2907, 'فارو', 'Faro', '09', 'not_used', NULL, 170),
(2908, 'كويمبرا', 'Coimbra', '07', 'not_used', NULL, 170),
(2909, 'الماديرا', 'Madeira', '10', 'not_used', NULL, 170),
(2910, 'باجة', 'Beja', '03', 'not_used', NULL, 170),
(2911, 'غواردا', 'Guarda', '11', 'not_used', NULL, 170),
(2912, 'ايفورا', 'Evora', '08', 'not_used', NULL, 170),
(2914, 'كورديليرا', 'Cordillera', '08', 'not_used', NULL, 172),
(2915, 'ألتو بارانا', 'Alto Parana', '01', 'not_used', NULL, 172),
(2916, 'كازابا', 'Caazapa', '05', 'not_used', NULL, 172),
(2917, 'بوكورون', 'Boqueron', '24', 'not_used', NULL, 172),
(2918, 'Paraguari', 'Paraguari', '15', 'not_used', NULL, 172),
(2919, 'أمامباي', 'Amambay', '02', 'not_used', NULL, 172),
(2920, 'ألتو باراجواي', 'Alto Paraguay', '23', 'not_used', NULL, 172),
(2921, 'كانينديو', 'Canindeyu', '19', 'not_used', NULL, 172),
(2922, 'كونسيبسيون', 'Concepcion', '07', 'not_used', NULL, 172),
(2923, 'ميسيونيس', 'Misiones', '12', 'not_used', NULL, 172),
(2924, 'كاغوازو', 'Caaguazu', '04', 'not_used', NULL, 172),
(2925, 'نيمبوكو', 'Neembucu', '13', 'not_used', NULL, 172),
(2926, 'إيتابوا', 'Itapua', '11', 'not_used', NULL, 172),
(2927, 'وسط', 'Central', '06', 'not_used', NULL, 172),
(2928, 'حي سان بيدرو', 'San Pedro', '17', 'not_used', NULL, 172),
(2929, 'سيادة الرئيس هايز', 'Presidente Hayes', '16', 'not_used', NULL, 172),
(2930, 'جويرا', 'Guaira', '10', 'not_used', NULL, 172),
(2931, 'مدينة شمال شمالي', 'Madinat ach Shamal', '08', 'not_used', NULL, 173),
(2932, 'الدوحة', 'Ad Dawhah', '01', 'not_used', NULL, 173),
(2933, 'أم صلال', 'Umm Salal', '09', 'not_used', NULL, 173),
(2934, 'الخور', 'Al Khawr', '04', 'not_used', NULL, 173),
(2935, 'الجميلية', 'Al Jumaliyah', '03', 'not_used', NULL, 173),
(2936, 'بلدية الوكرة', 'Al Wakrah Municipality', '05', 'not_used', NULL, 173),
(2938, 'إيلفوف', 'Ilfov', '43', 'not_used', NULL, 175),
(2939, 'غيورغيو', 'Giurgiu', '42', 'not_used', NULL, 175),
(2940, 'بيهور', 'Bihor', '05', 'not_used', NULL, 175),
(2941, 'كاراس سيفيرين', 'Caras-Severin', '12', 'not_used', NULL, 175),
(2942, 'ميهيدينتي', 'Mehedinti', '26', 'not_used', NULL, 175),
(2943, 'فاسلوي', 'Vaslui', '38', 'not_used', NULL, 175),
(2944, 'تولسيا', 'Tulcea', '37', 'not_used', NULL, 175),
(2945, 'كونستانتا', 'Constanta', '14', 'not_used', NULL, 175),
(2946, 'موريس', 'Mures', '27', 'not_used', NULL, 175),
(2947, 'هارغيتا', 'Harghita', '20', 'not_used', NULL, 175),
(2948, 'ألبا', 'Alba', '01', 'not_used', NULL, 175),
(2949, 'اراد', 'Arad', '02', 'not_used', NULL, 175),
(2950, 'هونيدوارا', 'Hunedoara', '21', 'not_used', NULL, 175),
(2951, 'ساتو ماري', 'Satu Mare', '32', 'not_used', NULL, 175),
(2952, 'سيبيو', 'Sibiu', '33', 'not_used', NULL, 175),
(2953, 'مارامريس', 'Maramures', '25', 'not_used', NULL, 175),
(2954, 'براسوف', 'Brasov', '09', 'not_used', NULL, 175),
(2955, 'كلوج', 'Cluj', '13', 'not_used', NULL, 175),
(2956, 'تيليورمان', 'Teleorman', '35', 'not_used', NULL, 175),
(2957, 'دامبوفيتا', 'Dambovita', '16', 'not_used', NULL, 175),
(2958, 'دولج', 'Dolj', '17', 'not_used', NULL, 175),
(2959, 'سوسيفا', 'Suceava', '34', 'not_used', NULL, 175),
(2960, 'بوتوساني', 'Botosani', '07', 'not_used', NULL, 175),
(2961, 'اياسي', 'Iasi', '23', 'not_used', NULL, 175),
(2962, 'ارجيس', 'Arges', '03', 'not_used', NULL, 175),
(2963, 'بوزاو', 'Buzau', '11', 'not_used', NULL, 175),
(2964, 'تيم هو', 'Timis', '36', 'not_used', NULL, 175),
(2965, 'نيمت', 'Neamt', '28', 'not_used', NULL, 175),
(2966, 'باكاو', 'Bacau', '04', 'not_used', NULL, 175),
(2967, 'برايلا', 'Braila', '08', 'not_used', NULL, 175),
(2968, 'سالاج', 'Salaj', '31', 'not_used', NULL, 175),
(2969, 'كوفاسنا', 'Covasna', '15', 'not_used', NULL, 175),
(2970, 'بيستريتا ناسود', 'Bistrita-Nasaud', '06', 'not_used', NULL, 175),
(2971, 'كالاراسي', 'Calarasi', '41', 'not_used', NULL, 175),
(2972, 'غورج', 'Gorj', '19', 'not_used', NULL, 175),
(2973, 'ايالوميتا', 'Ialomita', '22', 'not_used', NULL, 175),
(2974, 'أولت', 'Olt', '29', 'not_used', NULL, 175),
(2975, 'فالسيا', 'Valcea', '39', 'not_used', NULL, 175),
(2976, 'براهوفا', 'Prahova', '30', 'not_used', NULL, 175),
(2977, 'فرانتشا', 'Vrancea', '40', 'not_used', NULL, 175),
(2978, 'بوخارست', 'Bucuresti', '10', 'not_used', NULL, 175),
(2979, 'جالاتي', 'Galati', '18', 'not_used', NULL, 175),
(2983, 'موسكفا', 'Moskva', '47', 'not_used', NULL, 176),
(2984, 'كاريليا', 'Karelia', '28', 'not_used', NULL, 176),
(2985, 'سخا', 'Sakha', '63', 'not_used', NULL, 176),
(2987, 'التيسكي كراي', 'Altaisky krai', '04', 'not_used', NULL, 176),
(2988, 'إيفانوفو', 'Ivanovo', '21', 'not_used', NULL, 176),
(2989, 'كوستروما', 'Kostroma', '37', 'not_used', NULL, 176),
(2990, 'Nizhegorod', 'Nizhegorod', '51', 'not_used', NULL, 176),
(2991, 'تفير \"', 'Tver\'', '77', 'not_used', NULL, 176),
(2992, 'فلاديمير', 'Vladimir', '83', 'not_used', NULL, 176),
(2993, 'موج الشعر بإستمرار\'', 'Perm\'', '58', 'not_used', NULL, 176),
(2994, 'أديغيا', 'Adygeya', '01', 'not_used', NULL, 176),
(2995, 'تشيتا', 'Chita', '14', 'not_used', NULL, 176),
(2996, 'Taymyr', 'Taymyr', '74', 'not_used', NULL, 176),
(2997, 'كيميروفو', 'Kemerovo', '29', 'not_used', NULL, 176),
(2998, 'الأدمرت', 'Udmurt', '80', 'not_used', NULL, 176),
(2999, 'Khakass', 'Khakass', '31', 'not_used', NULL, 176),
(3000, 'فولوغدا', 'Vologda', '85', 'not_used', NULL, 176),
(3001, 'أومسك', 'Omsk', '54', 'not_used', NULL, 176),
(3002, 'أورينبورغ', 'Orenburg', '55', 'not_used', NULL, 176),
(3003, 'إيركوتسك', 'Irkutsk', '20', 'not_used', NULL, 176),
(3004, 'كراسنويارسك', 'Krasnoyarsk', '39', 'not_used', NULL, 176),
(3005, 'سفيردلوفسك', 'Sverdlovsk', '71', 'not_used', NULL, 176),
(3006, 'Tambovskaya أوبلاست', 'Tambovskaya oblast', '72', 'not_used', NULL, 176),
(3007, 'Arkhangel\'sk', 'Arkhangel\'sk', '06', 'not_used', NULL, 176),
(3008, 'نوفوسيبيرسك', 'Novosibirsk', '53', 'not_used', NULL, 176),
(3009, 'ريازان \"', 'Ryazan\'', '62', 'not_used', NULL, 176),
(3010, 'تولا', 'Tula', '76', 'not_used', NULL, 176),
(3011, 'روستوف', 'Rostov', '61', 'not_used', NULL, 176),
(3012, 'ياروسلافل \"', 'Yaroslavl\'', '88', 'not_used', NULL, 176),
(3013, 'تتارستان', 'Tatarstan', '73', 'not_used', NULL, 176),
(3014, 'تيومين \"', 'Tyumen\'', '78', 'not_used', NULL, 176),
(3015, 'بينزا', 'Penza', '57', 'not_used', NULL, 176),
(3016, 'ساراتوف', 'Saratov', '67', 'not_used', NULL, 176),
(3017, 'تشوفاشيا', 'Chuvashia', '16', 'not_used', NULL, 176),
(3018, 'كومي', 'Komi', '34', 'not_used', NULL, 176),
(3019, 'بريانسك', 'Bryansk', '10', 'not_used', NULL, 176),
(3020, 'الثمرة الجناحية', 'Samara', '65', 'not_used', NULL, 176),
(3022, 'جمهورية ماري ايل', 'Mariy-El', '45', 'not_used', NULL, 176),
(3023, 'لينينغراد', 'Leningrad', '42', 'not_used', NULL, 176),
(3024, 'كيروف', 'Kirov', '33', 'not_used', NULL, 176),
(3025, 'غورنو ألتاي', 'Gorno-Altay', '03', 'not_used', NULL, 176),
(3026, 'داغستان', 'Dagestan', '17', 'not_used', NULL, 176),
(3027, 'قبردينو بلقاريا', 'Kabardin-Balkar', '22', 'not_used', NULL, 176),
(3028, 'آمور', 'Amur', '05', 'not_used', NULL, 176),
(3029, 'اوسيتيا الشمالية', 'North Ossetia', '68', 'not_used', NULL, 176),
(3030, 'كراشاي-الشركس', 'Karachay-Cherkess', '27', 'not_used', NULL, 176),
(3031, 'كراسنودار', 'Krasnodar', '38', 'not_used', NULL, 176),
(3032, 'ليبيتسك', 'Lipetsk', '43', 'not_used', NULL, 176),
(3033, 'سمولينسك', 'Smolensk', '69', 'not_used', NULL, 176),
(3034, 'كالينينغراد', 'Kaliningrad', '23', 'not_used', NULL, 176),
(3035, 'باشكورتوستان', 'Bashkortostan', '08', 'not_used', NULL, 176),
(3036, 'تشيليابينسك', 'Chelyabinsk', '13', 'not_used', NULL, 176),
(3037, 'Ul\'yanovsk', 'Ul\'yanovsk', '81', 'not_used', NULL, 176),
(3038, 'ستافروبول \"', 'Stavropol\'', '70', 'not_used', NULL, 176),
(3039, 'كورغان', 'Kurgan', '40', 'not_used', NULL, 176),
(3040, 'أستراخان \"', 'Astrakhan\'', '07', 'not_used', NULL, 176),
(3041, 'فولغوغراد', 'Volgograd', '84', 'not_used', NULL, 176),
(3042, 'الكالميك', 'Kalmyk', '24', 'not_used', NULL, 176),
(3043, 'كالوغا', 'Kaluga', '25', 'not_used', NULL, 176),
(3044, 'ماجادان', 'Magadan', '44', 'not_used', NULL, 176),
(3045, 'بسكوف', 'Pskov', '60', 'not_used', NULL, 176),
(3046, 'أوريل', 'Orel', '56', 'not_used', NULL, 176),
(3047, 'Primor\'ye', 'Primor\'ye', '59', 'not_used', NULL, 176),
(3048, 'بيلغورود', 'Belgorod', '09', 'not_used', NULL, 176),
(3049, 'بوريات', 'Buryat', '11', 'not_used', NULL, 176),
(3050, 'تومسك', 'Tomsk', '75', 'not_used', NULL, 176),
(3051, 'مورمانسك', 'Murmansk', '49', 'not_used', NULL, 176),
(3053, 'سخالين', 'Sakhalin', '64', 'not_used', NULL, 176),
(3054, 'فورونيج', 'Voronezh', '86', 'not_used', NULL, 176),
(3055, 'نوفغورود', 'Novgorod', '52', 'not_used', NULL, 176),
(3056, 'موردوفيا', 'Mordovia', '46', 'not_used', NULL, 176),
(3057, 'كامتشاتكا', 'Kamchatka', '26', 'not_used', NULL, 176),
(3058, 'خاباروفسك', 'Khabarovsk', '30', 'not_used', NULL, 176),
(3059, 'كورياك', 'Koryak', '36', 'not_used', NULL, 176),
(3060, 'Chukot', 'Chukot', '15', 'not_used', NULL, 176),
(3061, 'خانتي-Mansiy', 'Khanty-Mansiy', '32', 'not_used', NULL, 176),
(3062, 'كورسك', 'Kursk', '41', 'not_used', NULL, 176),
(3063, 'Aginsky Buryatsky AO', 'Aginsky Buryatsky AO', '02', 'not_used', NULL, 176),
(3064, 'تو فا', 'Tuva', '79', 'not_used', NULL, 176),
(3065, 'نينيتس', 'Nenets', '50', 'not_used', NULL, 176),
(3066, 'Evenk', 'Evenk', '18', 'not_used', NULL, 176),
(3067, 'Yevrey', 'Yevrey', '89', 'not_used', NULL, 176),
(3069, 'يامال نينيتس', 'Yamal-Nenets', '87', 'not_used', NULL, 176),
(3070, 'مدينة سانت بطرسبرغ', 'Saint Petersburg City', '66', 'not_used', NULL, 176),
(3071, 'مدينة موسكو', 'Moscow City', '48', 'not_used', NULL, 176),
(3072, 'كيغالي', 'Kigali', '09', 'not_used', NULL, 177),
(3073, 'ولكن ل', 'Butare', '01', 'not_used', NULL, 177),
(3077, 'كيبيونغو', 'Kibungo', '07', 'not_used', NULL, 177),
(3080, 'غيتامارا', 'Gitarama', '06', 'not_used', NULL, 177),
(3082, 'مكه', 'Makkah', '14', 'used', 5.00, 178),
(3083, 'الرياض', 'Ar Riyad', '10', 'used', 10.00, 178),
(3084, 'وابل', 'Ha\'il', '13', 'used', 20.00, 178),
(3085, 'الحدود الشمالية', 'Al Hudud ash Shamaliyah', '15', 'used', 15.00, 178),
(3086, 'جازان', 'Jizan', '17', 'used', 20.00, 178),
(3087, 'الشرقية', 'Ash Sharqiyah', '06', 'used', 25.00, 178),
(3088, 'المدينة', 'Al Madinah', '05', 'used', 120.00, 178),
(3089, 'القاسم', 'Al Qasim', '08', 'used', 90.00, 178),
(3090, 'الباحة', 'Al Bahah', '02', 'used', 64.00, 178),
(3091, 'تبوك', 'Tabuk', '19', 'used', 100.00, 178),
(3092, 'الجوف', 'Al Jawf', '20', 'used', 350.00, 178),
(3094, 'ماكيرا', 'Makira', '08', 'not_used', NULL, 179),
(3096, 'بيو فالون', 'Beau Vallon', '08', 'not_used', NULL, 180),
(3098, 'بحر الغزال', 'Bahr al Ghazal', '32', 'not_used', NULL, 181),
(3100, 'نهر النيل', 'River Nile', '53', 'not_used', NULL, 181),
(3101, 'دارفور', 'Darfur', '33', 'not_used', NULL, 181),
(3102, 'كردفان', 'Kurdufan', '34', 'not_used', NULL, 181),
(3103, 'الوسطى', 'Al Wusta', '27', 'not_used', NULL, 181),
(3104, 'الرماد الشمالي', 'Ash Shamaliyah', '30', 'not_used', NULL, 181),
(3105, 'الشرقية', 'Ash Sharqiyah', '31', 'not_used', NULL, 181),
(3106, 'الاستيوة', 'Al Istiwa\'iyah', '28', 'not_used', NULL, 181),
(3110, 'الخرطوم', 'Al Khartum', '29', 'not_used', NULL, 181),
(3113, 'شمال دارفور', 'Northern Darfur', '55', 'not_used', NULL, 181),
(3119, 'ولاية وسط الاستوائية', 'Central Equatoria State', '44', 'not_used', NULL, 181),
(3120, 'ولاية الوحده', 'Al Wahadah State', '40', 'not_used', NULL, 181),
(3121, 'كسلا', 'Kassala', '52', 'not_used', NULL, 181),
(3124, 'جنوب كردفان', 'Southern Kordofan', '50', 'not_used', NULL, 181),
(3126, 'أعالي النيل', 'Upper Nile', '35', 'not_used', NULL, 181),
(3127, 'جنوب دارفور', 'Southern Darfur', '49', 'not_used', NULL, 181),
(3133, 'Vasternorrlands لان', 'Vasternorrlands Lan', '24', 'not_used', NULL, 182),
(3134, 'فاسترا جوتلاند', 'Vastra Gotaland', '28', 'not_used', NULL, 182),
(3135, 'نوربوتنز لان', 'Norrbottens Lan', '14', 'not_used', NULL, 182),
(3136, 'فاستربوتينز لان', 'Vasterbottens Lan', '23', 'not_used', NULL, 182),
(3137, 'سكين لان', 'Skane Lan', '27', 'not_used', NULL, 182),
(3138, 'كالمار لان', 'Kalmar Lan', '09', 'not_used', NULL, 182),
(3139, 'جامتلاندز لان', 'Jamtlands Lan', '07', 'not_used', NULL, 182),
(3140, 'كرونوبيرز لان', 'Kronobergs Lan', '12', 'not_used', NULL, 182),
(3141, 'Ostergotlands لان', 'Ostergotlands Lan', '16', 'not_used', NULL, 182),
(3142, 'ستوكهلم لان', 'Stockholms Lan', '26', 'not_used', NULL, 182),
(3143, 'دالارناس لان', 'Dalarnas Lan', '10', 'not_used', NULL, 182),
(3144, 'بليكينج لان', 'Blekinge Lan', '02', 'not_used', NULL, 182),
(3145, 'جافليبورجس لان', 'Gavleborgs Lan', '03', 'not_used', NULL, 182),
(3146, 'سوديرمانلاندز لان', 'Sodermanlands Lan', '18', 'not_used', NULL, 182),
(3147, 'فاستمانلاندس لان', 'Vastmanlands Lan', '25', 'not_used', NULL, 182),
(3148, 'فارملاند لان', 'Varmlands Lan', '22', 'not_used', NULL, 182),
(3149, 'هولاندز لان', 'Hallands Lan', '06', 'not_used', NULL, 182),
(3150, 'أوربرو لان', 'Orebro Lan', '15', 'not_used', NULL, 182),
(3151, 'أوبسالا لان', 'Uppsala Lan', '21', 'not_used', NULL, 182),
(3152, 'جونكوبنج لان', 'Jonkopings Lan', '08', 'not_used', NULL, 182),
(3153, 'جوتلاندز لان', 'Gotlands Lan', '05', 'not_used', NULL, 182),
(3156, 'بوهينج كوميون', 'Bohinj Commune', '04', 'not_used', NULL, 185),
(3157, 'Brezovica Commune', 'Brezovica Commune', '09', 'not_used', NULL, 185),
(3160, 'كوسيتش', 'Kosice', '03', 'not_used', NULL, 187),
(3161, 'بانسكا بيستريكا', 'Banska Bystrica', '01', 'not_used', NULL, 187),
(3162, 'نيترا', 'Nitra', '04', 'not_used', NULL, 187),
(3163, 'ترنافا', 'Trnava', '07', 'not_used', NULL, 187),
(3164, 'بريسوف', 'Presov', '05', 'not_used', NULL, 187),
(3165, 'زيلينا', 'Zilina', '08', 'not_used', NULL, 187),
(3166, 'براتيسلافا', 'Bratislava', '02', 'not_used', NULL, 187),
(3167, 'ترينشن', 'Trencin', '06', 'not_used', NULL, 187),
(3169, 'المنطقة الغربية', 'Western Area', '04', 'not_used', NULL, 188),
(3170, 'شمالي', 'Northern', '02', 'not_used', NULL, 188),
(3171, 'الشرقية', 'Eastern', '01', 'not_used', NULL, 188),
(3172, 'جنوبي', 'Southern', '03', 'not_used', NULL, 188),
(3173, 'أكوافيفا', 'Acquaviva', '01', 'not_used', NULL, 189),
(3174, 'كيسانيوفا', 'Chiesanuova', '02', 'not_used', NULL, 189),
(3175, 'سان مارينو', 'San Marino', '07', 'not_used', NULL, 189),
(3176, 'سيرافالي', 'Serravalle', '09', 'not_used', NULL, 189),
(3177, 'داكار', 'Dakar', '01', 'not_used', NULL, 190),
(3179, 'ديوربيل', 'Diourbel', '03', 'not_used', NULL, 190),
(3181, 'كولدا', 'Kolda', '11', 'not_used', NULL, 190),
(3182, 'زيغينشور', 'Ziguinchor', '12', 'not_used', NULL, 190),
(3183, 'تييس', 'Thies', '07', 'not_used', NULL, 190),
(3184, 'فاتيك', 'Fatick', '09', 'not_used', NULL, 190),
(3185, 'كاولاك', 'Kaolack', '10', 'not_used', NULL, 190),
(3186, 'تامباكوندا', 'Tambacounda', '05', 'not_used', NULL, 190),
(3187, 'وغا', 'Louga', '13', 'not_used', NULL, 190),
(3188, 'ماتام', 'Matam', '15', 'not_used', NULL, 190),
(3189, 'سانت لويس', 'Saint-Louis', '14', 'not_used', NULL, 190),
(3191, 'خليج', 'Bay', '04', 'not_used', NULL, 191),
(3192, 'Shabeellaha Hoose', 'Shabeellaha Hoose', '14', 'not_used', NULL, 191),
(3193, 'باكول', 'Bakool', '01', 'not_used', NULL, 191),
(3194, 'هيران', 'Hiiraan', '07', 'not_used', NULL, 191),
(3195, 'جدو', 'Gedo', '06', 'not_used', NULL, 191),
(3196, 'باري', 'Bari', '03', 'not_used', NULL, 191),
(3197, 'غالغودود', 'Galguduud', '05', 'not_used', NULL, 191),
(3198, 'مدق', 'Mudug', '10', 'not_used', NULL, 191),
(3199, 'Woqooyi Galbeed', 'Woqooyi Galbeed', '16', 'not_used', NULL, 191),
(3200, 'جوبادا ديكسي', 'Jubbada Dhexe', '08', 'not_used', NULL, 191),
(3201, 'Shabeellaha Dhexe', 'Shabeellaha Dhexe', '13', 'not_used', NULL, 191),
(3202, 'جوبادا هووز', 'Jubbada Hoose', '09', 'not_used', NULL, 191),
(3204, 'نوغال', 'Nugaal', '11', 'not_used', NULL, 191),
(3205, 'سناج', 'Sanaag', '12', 'not_used', NULL, 191),
(3206, 'بنادر', 'Banaadir', '02', 'not_used', NULL, 191),
(3208, 'بروكوبوندو', 'Brokopondo', '10', 'not_used', NULL, 192),
(3209, 'سيباليويني', 'Sipaliwini', '18', 'not_used', NULL, 192),
(3210, 'ماروويجني', 'Marowijne', '13', 'not_used', NULL, 192),
(3211, 'الفقرة', 'Para', '15', 'not_used', NULL, 192),
(3212, 'كوميويجني', 'Commewijne', '11', 'not_used', NULL, 192),
(3213, 'سارامكا', 'Saramacca', '17', 'not_used', NULL, 192),
(3214, 'نيكيري', 'Nickerie', '14', 'not_used', NULL, 192),
(3215, 'كوروني', 'Coronie', '12', 'not_used', NULL, 192),
(3216, 'وانيكا', 'Wanica', '19', 'not_used', NULL, 192),
(3217, 'باراماريبو', 'Paramaribo', '16', 'not_used', NULL, 192),
(3218, 'ساو تومي', 'Sao Tome', '02', 'not_used', NULL, 193),
(3219, 'برينسيبي', 'Principe', '01', 'not_used', NULL, 193),
(3220, 'سونسوناتي', 'Sonsonate', '13', 'not_used', NULL, 194),
(3221, 'مورازان', 'Morazan', '08', 'not_used', NULL, 194),
(3222, 'سان فيسينتي', 'San Vicente', '12', 'not_used', NULL, 194),
(3223, 'لا يونيون', 'La Union', '07', 'not_used', NULL, 194),
(3224, 'سان سلفادور', 'San Salvador', '10', 'not_used', NULL, 194),
(3225, 'شالاتنانغو', 'Chalatenango', '03', 'not_used', NULL, 194),
(3226, 'لا ليبرتاد', 'La Libertad', '05', 'not_used', NULL, 194),
(3227, 'كاباناس', 'Cabanas', '02', 'not_used', NULL, 194),
(3228, 'كوسكاتلان', 'Cuscatlan', '04', 'not_used', NULL, 194),
(3229, 'أوسولوتان', 'Usulutan', '14', 'not_used', NULL, 194),
(3230, 'اهواتشابان', 'Ahuachapan', '01', 'not_used', NULL, 194),
(3231, 'سانتا آنا', 'Santa Ana', '11', 'not_used', NULL, 194),
(3232, 'سان ميغيل', 'San Miguel', '09', 'not_used', NULL, 194),
(3233, 'لاباز', 'La Paz', '06', 'not_used', NULL, 194),
(3234, 'الحسكة', 'Al Hasakah', '01', 'not_used', NULL, 195),
(3235, 'الرقة', 'Ar Raqqah', '04', 'not_used', NULL, 195),
(3236, 'طرطوس', 'Tartus', '14', 'not_used', NULL, 195),
(3237, 'ريف دمشق', 'Rif Dimashq', '08', 'not_used', NULL, 195),
(3238, 'حمص', 'Hims', '11', 'not_used', NULL, 195),
(3239, 'إدلب', 'Idlib', '12', 'not_used', NULL, 195),
(3240, 'حماه', 'Hamah', '10', 'not_used', NULL, 195),
(3241, 'حلب', 'Halab', '09', 'not_used', NULL, 195),
(3242, 'القنيطرة', 'Al Qunaytirah', '03', 'not_used', NULL, 195),
(3243, 'دار', 'Dar', '06', 'not_used', NULL, 195),
(3244, 'كما السويداء', 'As Suwayda\'', '05', 'not_used', NULL, 195),
(3245, 'اللاذقية', 'Al Ladhiqiyah', '02', 'not_used', NULL, 195),
(3246, 'دير الزور', 'Dayr az Zawr', '07', 'not_used', NULL, 195),
(3247, 'دمشق', 'Dimashq', '13', 'not_used', NULL, 195),
(3248, 'وبومبو', 'Lubombo', '02', 'not_used', NULL, 196),
(3249, 'هوهو', 'Hhohho', '01', 'not_used', NULL, 196),
(3250, 'مانزيني', 'Manzini', '03', 'not_used', NULL, 196),
(3251, 'شيزلويني', 'Shiselweni', '04', 'not_used', NULL, 196),
(3253, 'واداي', 'Ouaddai', '12', 'not_used', NULL, 198),
(3254, 'بيلتين', 'Biltine', '02', 'not_used', NULL, 198),
(3255, 'البطحاء', 'Batha', '01', 'not_used', NULL, 198),
(3256, 'مايو-كيبي', 'Mayo-Kebbi', '10', 'not_used', NULL, 198),
(3257, 'شاري باغيرمي', 'Chari-Baguirmi', '04', 'not_used', NULL, 198),
(3258, 'غويرا', 'Guera', '05', 'not_used', NULL, 198),
(3259, 'سلامات', 'Salamat', '13', 'not_used', NULL, 198),
(3260, 'كانم', 'Kanem', '06', 'not_used', NULL, 198),
(3261, 'لوجون اوكسيدنتال', 'Logone Occidental', '08', 'not_used', NULL, 198),
(3262, 'لاك', 'Lac', '07', 'not_used', NULL, 198),
(3263, 'بوركو إندي تيبستي', 'Borkou-Ennedi-Tibesti', '03', 'not_used', NULL, 198),
(3264, 'تانجيل', 'Tandjile', '14', 'not_used', NULL, 198),
(3265, 'موين شاري', 'Moyen-Chari', '11', 'not_used', NULL, 198),
(3266, 'لوجوني اورينتال', 'Logone Oriental', '09', 'not_used', NULL, 198),
(3268, 'الهضاب', 'Plateaux', '25', 'not_used', NULL, 200),
(3281, 'كارا', 'Kara', '23', 'not_used', NULL, 200),
(3289, 'السافانا', 'Savanes', '26', 'not_used', NULL, 200),
(3290, 'المركزية', 'Centrale', '22', 'not_used', NULL, 200),
(3292, 'بحري', 'Maritime', '24', 'not_used', NULL, 200),
(3293, 'ترات', 'Trat', '49', 'not_used', NULL, 201),
(3294, 'تشيانغ ماي', 'Chiang Mai', '02', 'not_used', NULL, 201),
(3295, 'نان', 'Nan', '04', 'not_used', NULL, 201),
(3296, 'براشين بوري', 'Prachin Buri', '45', 'not_used', NULL, 201),
(3297, 'كرابي', 'Krabi', '63', 'not_used', NULL, 201),
(3298, 'ساكون ناخون', 'Sakon Nakhon', '20', 'not_used', NULL, 201),
(3299, 'ناخون فانوم', 'Nakhon Phanom', '73', 'not_used', NULL, 201),
(3300, 'أمنات تشاروين', 'Amnat Charoen', '77', 'not_used', NULL, 201),
(3301, 'ساموت سونغخرام', 'Samut Songkhram', '54', 'not_used', NULL, 201),
(3302, 'ناخون صوان', 'Nakhon Sawan', '16', 'not_used', NULL, 201),
(3303, 'كانشانابوري', 'Kanchanaburi', '50', 'not_used', NULL, 201),
(3304, 'أوبون راتشاثاني', 'Ubon Ratchathani', '71', 'not_used', NULL, 201),
(3305, 'شومفون', 'Chumphon', '58', 'not_used', NULL, 201),
(3306, 'شاشوينجساو', 'Chachoengsao', '44', 'not_used', NULL, 201),
(3307, 'سا كايو', 'Sa Kaeo', '80', 'not_used', NULL, 201),
(3308, 'روي إت', 'Roi Et', '25', 'not_used', NULL, 201),
(3309, 'ناراثيوات', 'Narathiwat', '31', 'not_used', NULL, 201),
(3310, 'باتاني', 'Pattani', '69', 'not_used', NULL, 201),
(3311, 'تشايافوم', 'Chaiyaphum', '26', 'not_used', NULL, 201),
(3312, 'كالاسين', 'Kalasin', '23', 'not_used', NULL, 201),
(3313, 'تشون بوري', 'Chon Buri', '46', 'not_used', NULL, 201),
(3314, 'سوخوثاي', 'Sukhothai', '09', 'not_used', NULL, 201),
(3315, 'سورة ثاني', 'Surat Thani', '60', 'not_used', NULL, 201),
(3317, 'فرا ناخون سي أيوتثايا', 'Phra Nakhon Si Ayutthaya', '36', 'not_used', NULL, 201),
(3318, 'نونثابوري', 'Nonthaburi', '38', 'not_used', NULL, 201),
(3319, 'ساموت براكان', 'Samut Prakan', '42', 'not_used', NULL, 201),
(3320, 'آنج ثونغ', 'Ang Thong', '35', 'not_used', NULL, 201),
(3321, 'كرونج ثيب', 'Krung Thep', '40', 'not_used', NULL, 201),
(3322, 'فيتسانولوك', 'Phitsanulok', '12', 'not_used', NULL, 201),
(3323, 'ناخون باتوم', 'Nakhon Pathom', '53', 'not_used', NULL, 201),
(3324, 'فيشيت', 'Phichit', '13', 'not_used', NULL, 201),
(3325, 'راتشابوري', 'Ratchaburi', '52', 'not_used', NULL, 201),
(3326, 'سوفان بوري', 'Suphan Buri', '51', 'not_used', NULL, 201),
(3327, 'الغناء بوري', 'Sing Buri', '33', 'not_used', NULL, 201),
(3328, 'براشواب خيرى خان', 'Prachuap Khiri Khan', '57', 'not_used', NULL, 201),
(3329, 'امفون', 'Lamphun', '05', 'not_used', NULL, 201),
(3330, 'رايونج', 'Rayong', '47', 'not_used', NULL, 201),
(3331, 'أوبون راتشاثاني', 'Ubon Ratchathani', '75', 'not_used', NULL, 201),
(3332, 'شاي نات', 'Chai Nat', '32', 'not_used', NULL, 201),
(3333, 'بوريرام', 'Buriram', '28', 'not_used', NULL, 201),
(3334, 'فيتشابوري', 'Phetchaburi', '56', 'not_used', NULL, 201),
(3335, 'تاك', 'Tak', '08', 'not_used', NULL, 201),
(3336, 'فاياو', 'Phayao', '41', 'not_used', NULL, 201),
(3337, 'لوب بوري', 'Lop Buri', '34', 'not_used', NULL, 201),
(3338, 'سارابوري', 'Saraburi', '37', 'not_used', NULL, 201),
(3339, 'ناخون نايوك', 'Nakhon Nayok', '43', 'not_used', NULL, 201),
(3340, 'يالا', 'Yala', '70', 'not_used', NULL, 201),
(3341, 'ناخون راتشاسيما', 'Nakhon Ratchasima', '27', 'not_used', NULL, 201),
(3342, 'ساموت ساخون', 'Samut Sakhon', '55', 'not_used', NULL, 201),
(3343, 'خون كاين', 'Khon Kaen', '22', 'not_used', NULL, 201),
(3344, 'يوثاي ثاني', 'Uthai Thani', '15', 'not_used', NULL, 201),
(3345, 'نونغ خاي', 'Nong Khai', '17', 'not_used', NULL, 201),
(3346, 'مها ساراخام', 'Maha Sarakham', '24', 'not_used', NULL, 201),
(3347, 'امبانج', 'Lampang', '06', 'not_used', NULL, 201),
(3348, 'سونغكلا', 'Songkhla', '68', 'not_used', NULL, 201),
(3349, 'ناخون سي ثامارات', 'Nakhon Si Thammarat', '64', 'not_used', NULL, 201),
(3350, 'ويي', 'Loei', '18', 'not_used', NULL, 201),
(3351, 'شيانج راي', 'Chiang Rai', '03', 'not_used', NULL, 201),
(3352, 'سورين', 'Surin', '29', 'not_used', NULL, 201),
(3353, 'فيتشابون', 'Phetchabun', '14', 'not_used', NULL, 201),
(3354, 'فراى', 'Phrae', '07', 'not_used', NULL, 201),
(3355, 'فانغ نغا', 'Phangnga', '61', 'not_used', NULL, 201),
(3356, 'أوتاراديت', 'Uttaradit', '10', 'not_used', NULL, 201),
(3357, 'سيساكيت', 'Sisaket', '30', 'not_used', NULL, 201),
(3358, 'ترانج', 'Trang', '65', 'not_used', NULL, 201),
(3359, 'كامبينغ فيت', 'Kamphaeng Phet', '11', 'not_used', NULL, 201),
(3360, 'فوكيت', 'Phuket', '62', 'not_used', NULL, 201),
(3361, 'موكداهان', 'Mukdahan', '78', 'not_used', NULL, 201),
(3362, 'ياسوثون', 'Yasothon', '72', 'not_used', NULL, 201),
(3363, 'فاتهالونج', 'Phatthalung', '66', 'not_used', NULL, 201),
(3364, 'باثوم ثاني', 'Pathum Thani', '39', 'not_used', NULL, 201),
(3365, 'شانثابوري', 'Chanthaburi', '48', 'not_used', NULL, 201),
(3366, 'ماي هونغ سون', 'Mae Hong Son', '01', 'not_used', NULL, 201),
(3367, 'رانونج', 'Ranong', '59', 'not_used', NULL, 201),
(3368, 'أودون ثاني', 'Udon Thani', '76', 'not_used', NULL, 201),
(3369, 'ساتون', 'Satun', '67', 'not_used', NULL, 201),
(3370, 'نونغ بوا لامفو', 'Nong Bua Lamphu', '79', 'not_used', NULL, 201),
(3371, 'ناخون فانوم', 'Nakhon Phanom', '21', 'not_used', NULL, 201),
(3372, 'خاتلون', 'Khatlon', '02', 'not_used', NULL, 202),
(3373, 'صغد', 'Sughd', '03', 'not_used', NULL, 202),
(3374, 'كوهستوني بدخشون', 'Kuhistoni Badakhshon', '01', 'not_used', NULL, 202),
(3376, 'يباب', 'Lebap', '04', 'not_used', NULL, 204),
(3377, 'البلقان', 'Balkan', '02', 'not_used', NULL, 204),
(3378, 'آهال', 'Ahal', '01', 'not_used', NULL, 204),
(3380, 'مريم العذراء', 'Mary', '05', 'not_used', NULL, 204),
(3381, 'داشوغوز', 'Dashoguz', '03', 'not_used', NULL, 204),
(3382, 'Madanin', 'Madanin', '28', 'not_used', NULL, 205),
(3383, 'الكاف', 'El Kef', '14', 'not_used', NULL, 205),
(3384, 'توزر', 'Tozeur', '35', 'not_used', NULL, 205),
(3385, 'سوسة', 'Sousse', '23', 'not_used', NULL, 205),
(3386, 'قابس', 'Gabes', '29', 'not_used', NULL, 205),
(3387, 'صفاقس', 'Sfax', '32', 'not_used', NULL, 205),
(3388, 'بنزرت', 'Bizerte', '18', 'not_used', NULL, 205),
(3389, 'المنستير', 'Al Munastir', '16', 'not_used', NULL, 205),
(3390, 'نابل', 'Nabeul', '19', 'not_used', NULL, 205),
(3391, 'القصرين', 'Kasserine', '02', 'not_used', NULL, 205),
(3392, 'تطاوين', 'Tataouine', '34', 'not_used', NULL, 205),
(3393, 'سيدي بوزيد', 'Sidi Bou Zid', '33', 'not_used', NULL, 205),
(3394, 'المهدية', 'Al Mahdia', '15', 'not_used', NULL, 205),
(3395, 'جندوبة', 'Jendouba', '06', 'not_used', NULL, 205),
(3396, 'بن عروس', 'Ben Arous', '27', 'not_used', NULL, 205),
(3397, 'القيروان', 'Kairouan', '03', 'not_used', NULL, 205),
(3398, 'زغوان', 'Zaghouan', '37', 'not_used', NULL, 205),
(3399, 'قبلي', 'Kebili', '31', 'not_used', NULL, 205),
(3400, 'باجه', 'Bajah', '17', 'not_used', NULL, 205),
(3402, 'سليانة', 'Siliana', '22', 'not_used', NULL, 205),
(3404, 'تونس', 'Tunis', '36', 'not_used', NULL, 205),
(3405, 'تونجاتابو', 'Tongatapu', '02', 'not_used', NULL, 206),
(3406, 'ها', 'Ha', '01', 'not_used', NULL, 206),
(3407, 'فافا', 'Vava', '03', 'not_used', NULL, 206),
(3408, 'أماسيا', 'Amasya', '05', 'not_used', NULL, 207),
(3409, 'هاتاي', 'Hatay', '31', 'not_used', NULL, 207),
(3410, 'ديار بكر', 'Diyarbakir', '21', 'not_used', NULL, 207),
(3411, 'أضنة', 'Adana', '81', 'not_used', NULL, 207),
(3412, 'بولو', 'Bolu', '14', 'not_used', NULL, 207),
(3413, 'أنقرة', 'Ankara', '68', 'not_used', NULL, 207),
(3414, 'قونية', 'Konya', '71', 'not_used', NULL, 207),
(3415, 'بيلجيك', 'Bilecik', '11', 'not_used', NULL, 207),
(3416, 'إزمير', 'Izmir', '35', 'not_used', NULL, 207),
(3417, 'توكات', 'Tokat', '60', 'not_used', NULL, 207),
(3418, 'أدرنة', 'Edirne', '22', 'not_used', NULL, 207),
(3419, 'كيرسهير', 'Kirsehir', '40', 'not_used', NULL, 207),
(3420, 'سيارة نقل', 'Van', '65', 'not_used', NULL, 207),
(3421, 'كاستامونو', 'Kastamonu', '37', 'not_used', NULL, 207),
(3422, 'سيفاس', 'Sivas', '58', 'not_used', NULL, 207),
(3423, 'دنيزلي', 'Denizli', '20', 'not_used', NULL, 207),
(3424, 'كوتاهيا', 'Kutahya', '43', 'not_used', NULL, 207),
(3425, 'بينغول', 'Bingol', '12', 'not_used', NULL, 207),
(3426, 'كهرمان ماراس', 'Kahramanmaras', '46', 'not_used', NULL, 207),
(3427, 'سانليورفا', 'Sanliurfa', '63', 'not_used', NULL, 207),
(3428, 'الزراعية', 'Agri', '04', 'not_used', NULL, 207),
(3429, 'اسكيسهير', 'Eskisehir', '26', 'not_used', NULL, 207),
(3430, 'ملاطية', 'Malatya', '44', 'not_used', NULL, 207),
(3431, 'أديامان', 'Adiyaman', '02', 'not_used', NULL, 207),
(3432, 'جيرسون', 'Giresun', '28', 'not_used', NULL, 207),
(3433, 'المصحف', 'Mus', '49', 'not_used', NULL, 207),
(3434, 'كوروم', 'Corum', '19', 'not_used', NULL, 207),
(3435, 'أرضروم', 'Erzurum', '25', 'not_used', NULL, 207),
(3436, 'مرسين', 'Mersin', '32', 'not_used', NULL, 207),
(3437, 'أيدين', 'Aydin', '09', 'not_used', NULL, 207),
(3438, 'نفسهير', 'Nevsehir', '50', 'not_used', NULL, 207),
(3439, 'مانيسا', 'Manisa', '45', 'not_used', NULL, 207),
(3440, 'كاناكالي', 'Canakkale', '17', 'not_used', NULL, 207),
(3441, 'أوردو', 'Ordu', '52', 'not_used', NULL, 207),
(3442, 'يوزغات', 'Yozgat', '66', 'not_used', NULL, 207),
(3443, 'تونجلي', 'Tunceli', '62', 'not_used', NULL, 207),
(3444, 'ماردين', 'Mardin', '72', 'not_used', NULL, 207),
(3445, 'سينوب', 'Sinop', '57', 'not_used', NULL, 207),
(3446, 'أنطاليا', 'Antalya', '07', 'not_used', NULL, 207),
(3447, 'ارزينجان', 'Erzincan', '24', 'not_used', NULL, 207),
(3448, 'أرتفين', 'Artvin', '08', 'not_used', NULL, 207),
(3449, 'ساكاريا', 'Sakarya', '54', 'not_used', NULL, 207),
(3450, 'أفيون قره حصار', 'Afyonkarahisar', '03', 'not_used', NULL, 207),
(3451, 'بورصة', 'Bursa', '16', 'not_used', NULL, 207),
(3452, 'طرابزون', 'Trabzon', '61', 'not_used', NULL, 207),
(3453, 'ستنعم', 'Tekirdag', '59', 'not_used', NULL, 207),
(3454, 'كيليس', 'Kilis', '90', 'not_used', NULL, 207),
(3455, 'غازي عنتاب', 'Gaziantep', '83', 'not_used', NULL, 207),
(3456, 'سيرناك', 'Sirnak', '80', 'not_used', NULL, 207),
(3457, 'باليكسير', 'Balikesir', '10', 'not_used', NULL, 207),
(3458, 'إيلازيغ', 'Elazig', '23', 'not_used', NULL, 207),
(3459, 'أردهان', 'Ardahan', '86', 'not_used', NULL, 207),
(3460, 'الرجل الوطواط', 'Batman', '76', 'not_used', NULL, 207),
(3461, 'قيصري', 'Kayseri', '38', 'not_used', NULL, 207),
(3462, 'قوجا', 'Kocaeli', '41', 'not_used', NULL, 207),
(3463, 'سامسون', 'Samsun', '55', 'not_used', NULL, 207),
(3464, 'اسبرطة', 'Isparta', '33', 'not_used', NULL, 207),
(3465, 'موغلا', 'Mugla', '48', 'not_used', NULL, 207),
(3466, 'بتليس', 'Bitlis', '13', 'not_used', NULL, 207),
(3467, 'ريزي', 'Rize', '53', 'not_used', NULL, 207),
(3468, 'هكاري', 'Hakkari', '70', 'not_used', NULL, 207),
(3469, 'اسطنبول', 'Istanbul', '34', 'not_used', NULL, 207),
(3470, 'كرمان', 'Karaman', '78', 'not_used', NULL, 207),
(3471, 'اجدير', 'Igdir', '88', 'not_used', NULL, 207),
(3472, 'نيغدة', 'Nigde', '73', 'not_used', NULL, 207),
(3473, 'اوساك', 'Usak', '64', 'not_used', NULL, 207),
(3474, 'سيرت', 'Siirt', '74', 'not_used', NULL, 207),
(3475, 'كيركلاريلي', 'Kirklareli', '39', 'not_used', NULL, 207),
(3476, 'بوردور', 'Burdur', '15', 'not_used', NULL, 207),
(3477, 'جوموشان', 'Gumushane', '69', 'not_used', NULL, 207),
(3478, 'عثمانية', 'Osmaniye', '91', 'not_used', NULL, 207),
(3479, 'يالوفا', 'Yalova', '92', 'not_used', NULL, 207),
(3480, 'كارس', 'Kars', '84', 'not_used', NULL, 207),
(3481, 'توباغو', 'Tobago', '11', 'not_used', NULL, 208),
(3482, 'كاروني', 'Caroni', '02', 'not_used', NULL, 208),
(3483, 'القديس داود', 'Saint David', '07', 'not_used', NULL, 208),
(3484, 'اريما', 'Arima', '01', 'not_used', NULL, 208),
(3485, 'القديس جورج', 'Saint George', '08', 'not_used', NULL, 208),
(3486, 'سانت باتريك', 'Saint Patrick', '09', 'not_used', NULL, 208),
(3487, 'فيكتوريا', 'Victoria', '12', 'not_used', NULL, 208),
(3488, 'ناريفا', 'Nariva', '04', 'not_used', NULL, 208),
(3489, 'ميناء اسبانيا', 'Port-of-Spain', '05', 'not_used', NULL, 208),
(3490, 'القديس أندرو', 'Saint Andrew', '06', 'not_used', NULL, 208),
(3491, 'مايارو', 'Mayaro', '03', 'not_used', NULL, 208),
(3492, 'سان فرناندو', 'San Fernando', '10', 'not_used', NULL, 208),
(3494, 'تاي وان', 'T\'ai-wan', '04', 'not_used', NULL, 210),
(3495, 'تاي-بى', 'T\'ai-pei', '03', 'not_used', NULL, 210),
(3496, 'فو شين', 'Fu-chien', '01', 'not_used', NULL, 210),
(3497, 'كاو هسيونج،', 'Kao-hsiung', '02', 'not_used', NULL, 210),
(3499, 'تابورا', 'Tabora', '17', 'not_used', NULL, 211),
(3500, 'مانيارا', 'Manyara', '27', 'not_used', NULL, 211),
(3501, 'متوارا', 'Mtwara', '11', 'not_used', NULL, 211),
(3502, 'ليندي', 'Lindi', '07', 'not_used', NULL, 211),
(3503, 'روفوما', 'Ruvuma', '14', 'not_used', NULL, 211),
(3504, 'إيرينغا', 'Iringa', '04', 'not_used', NULL, 211),
(3505, 'طنجة', 'Tanga', '18', 'not_used', NULL, 211),
(3506, 'بيمبا الجنوبية', 'Pemba South', '20', 'not_used', NULL, 211),
(3507, 'كاجيرا', 'Kagera', '19', 'not_used', NULL, 211),
(3508, 'أروشا', 'Arusha', '26', 'not_used', NULL, 211),
(3509, 'موانزا', 'Mwanza', '12', 'not_used', NULL, 211),
(3510, 'كليمنجارو', 'Kilimanjaro', '06', 'not_used', NULL, 211),
(3511, 'بواني', 'Pwani', '02', 'not_used', NULL, 211),
(3512, 'زنجبار الوسطى', 'Zanzibar Central', '21', 'not_used', NULL, 211),
(3513, 'دودوما', 'Dodoma', '03', 'not_used', NULL, 211),
(3514, 'شينيانغا', 'Shinyanga', '15', 'not_used', NULL, 211),
(3515, 'زنجبار الحضري', 'Zanzibar Urban', '25', 'not_used', NULL, 211),
(3516, 'بيمبا الشمالية', 'Pemba North', '13', 'not_used', NULL, 211),
(3517, 'مارا', 'Mara', '08', 'not_used', NULL, 211),
(3518, 'دار السلام', 'Dar es Salaam', '23', 'not_used', NULL, 211),
(3519, 'زنجبار الشمالية', 'Zanzibar North', '22', 'not_used', NULL, 211),
(3520, 'مبيا', 'Mbeya', '09', 'not_used', NULL, 211),
(3521, 'سينغيدا', 'Singida', '16', 'not_used', NULL, 211),
(3522, 'كيغوما', 'Kigoma', '05', 'not_used', NULL, 211),
(3523, 'موروجورو', 'Morogoro', '10', 'not_used', NULL, 211),
(3524, 'روكوا', 'Rukwa', '24', 'not_used', NULL, 211),
(3525, 'KRYM', 'Krym', '11', 'not_used', NULL, 212),
(3526, 'أوديسكا أوبلاست', 'Odes\'ka Oblast\'', '17', 'not_used', NULL, 212),
(3527, 'خاركيفسكا أوبلاست', 'Kharkivs\'ka Oblast\'', '07', 'not_used', NULL, 212),
(3528, 'بولتافسكا أوبلاست', 'Poltavs\'ka Oblast\'', '18', 'not_used', NULL, 212),
(3529, 'Kyyivs\'ka Oblast \'', 'Kyyivs\'ka Oblast\'', '13', 'not_used', NULL, 212),
(3530, 'زاكارباتسكا أوبلاست', 'Zakarpats\'ka Oblast\'', '25', 'not_used', NULL, 212),
(3531, 'سومسكا أوبلاست', 'Sums\'ka Oblast\'', '21', 'not_used', NULL, 212),
(3532, 'دونيتسك أوبلاست', 'Donets\'ka Oblast\'', '05', 'not_used', NULL, 212),
(3533, 'خيرسونسكا أوبلاست', 'Khersons\'ka Oblast\'', '08', 'not_used', NULL, 212),
(3534, 'L\'vivs\'ka Oblast \'', 'L\'vivs\'ka Oblast\'', '15', 'not_used', NULL, 212),
(3535, 'تشيركاشكا أوبلاست', 'Cherkas\'ka Oblast\'', '01', 'not_used', NULL, 212),
(3536, 'فينيتسكا أوبلاست', 'Vinnyts\'ka Oblast\'', '23', 'not_used', NULL, 212),
(3537, 'ريفنينسكا أوبلاست', 'Rivnens\'ka Oblast\'', '19', 'not_used', NULL, 212),
(3538, 'خميلنيتسكا أوبلاست', 'Khmel\'nyts\'ka Oblast\'', '09', 'not_used', NULL, 212),
(3539, 'تشيرنيهيفسكا أوبلاست', 'Chernihivs\'ka Oblast\'', '02', 'not_used', NULL, 212),
(3540, 'دنيبروبيتروفسكا أوبلاست', 'Dnipropetrovs\'ka Oblast\'', '04', 'not_used', NULL, 212),
(3541, 'ميكولاييفسكا أوبلاست', 'Mykolayivs\'ka Oblast\'', '16', 'not_used', NULL, 212),
(3542, 'تيرنوبل أوكا أوبلاست', 'Ternopil\'s\'ka Oblast\'', '22', 'not_used', NULL, 212),
(3543, 'زيتوميرسكا أوبلاست', 'Zhytomyrs\'ka Oblast\'', '27', 'not_used', NULL, 212),
(3544, 'تشيرنيفتسكا أوبلاست', 'Chernivets\'ka Oblast\'', '03', 'not_used', NULL, 212),
(3545, 'لوهانسكا أوبلاست', 'Luhans\'ka Oblast\'', '14', 'not_used', NULL, 212),
(3546, 'سيفاستوبول \"', 'Sevastopol\'', '20', 'not_used', NULL, 212),
(3547, 'كيروفوهرادسكا أوبلاست', 'Kirovohrads\'ka Oblast\'', '10', 'not_used', NULL, 212),
(3548, 'ايفانو فرانكيفسكا أوبلاست', 'Ivano-Frankivs\'ka Oblast\'', '06', 'not_used', NULL, 212),
(3549, 'زابوريزكا أوبلاست', 'Zaporiz\'ka Oblast\'', '26', 'not_used', NULL, 212),
(3550, 'فولينسكا أوبلاست', 'Volyns\'ka Oblast\'', '24', 'not_used', NULL, 212),
(3552, 'نيبى', 'Nebbi', '58', 'not_used', NULL, 213),
(3553, 'كاتاكوي', 'Katakwi', '69', 'not_used', NULL, 213),
(3554, 'الليرة', 'Lira', '47', 'not_used', NULL, 213),
(3555, 'اباك', 'Apac', '26', 'not_used', NULL, 213),
(3556, 'كابيرامايدو', 'Kaberamaido', '80', 'not_used', NULL, 213),
(3557, 'أروا', 'Arua', '77', 'not_used', NULL, 213),
(3558, 'سوروتي', 'Soroti', '95', 'not_used', NULL, 213),
(3559, 'تورورو', 'Tororo', '76', 'not_used', NULL, 213),
(3560, 'غولو', 'Gulu', '30', 'not_used', NULL, 213),
(3561, 'باليسا', 'Pallisa', '60', 'not_used', NULL, 213),
(3562, 'بادر', 'Pader', '92', 'not_used', NULL, 213),
(3563, 'كومي', 'Kumi', '46', 'not_used', NULL, 213),
(3564, 'أدجومانى', 'Adjumani', '65', 'not_used', NULL, 213),
(3565, 'كوتيدو', 'Kotido', '45', 'not_used', NULL, 213),
(3566, 'كيتجوم', 'Kitgum', '84', 'not_used', NULL, 213),
(3567, 'ماسيندى', 'Masindi', '50', 'not_used', NULL, 213),
(3568, 'مبارارا', 'Mbarara', '52', 'not_used', NULL, 213),
(3570, 'بونديبوجيو', 'Bundibugyo', '28', 'not_used', NULL, 213),
(3571, 'ناكابيريبيريت', 'Nakapiripirit', '91', 'not_used', NULL, 213),
(3572, 'موروتو', 'Moroto', '88', 'not_used', NULL, 213),
(3573, 'مويو', 'Moyo', '72', 'not_used', NULL, 213),
(3574, 'مبالي', 'Mbale', '87', 'not_used', NULL, 213),
(3575, 'يومبى', 'Yumbe', '97', 'not_used', NULL, 213),
(3576, 'كابشوروا', 'Kapchorwa', '39', 'not_used', NULL, 213),
(3577, 'ناكاسونغولا', 'Nakasongola', '73', 'not_used', NULL, 213),
(3578, 'موبيندي', 'Mubende', '56', 'not_used', NULL, 213),
(3579, 'كيسورو', 'Kisoro', '43', 'not_used', NULL, 213),
(3580, 'إيغانغا', 'Iganga', '78', 'not_used', NULL, 213),
(3581, 'كايونجا', 'Kayunga', '83', 'not_used', NULL, 213),
(3582, 'موكونو', 'Mukono', '90', 'not_used', NULL, 213),
(3583, 'مبيجي', 'Mpigi', '89', 'not_used', NULL, 213),
(3584, 'كامولي', 'Kamuli', '38', 'not_used', NULL, 213),
(3585, 'ويرو', 'Luwero', '70', 'not_used', NULL, 213),
(3586, 'ماساكا', 'Masaka', '71', 'not_used', NULL, 213),
(3587, 'راكاي', 'Rakai', '61', 'not_used', NULL, 213),
(3588, 'كالانغالا', 'Kalangala', '36', 'not_used', NULL, 213),
(3589, 'كيبالي', 'Kibale', '41', 'not_used', NULL, 213),
(3590, 'بوجيرى', 'Bugiri', '66', 'not_used', NULL, 213),
(3591, 'اكيسو', 'Wakiso', '96', 'not_used', NULL, 213),
(3592, 'كيبوجا', 'Kiboga', '42', 'not_used', NULL, 213),
(3593, 'كمبالا', 'Kampala', '37', 'not_used', NULL, 213),
(3594, 'مايوج', 'Mayuge', '86', 'not_used', NULL, 213),
(3595, 'كينجوجو', 'Kyenjojo', '85', 'not_used', NULL, 213),
(3596, 'روكونجيري', 'Rukungiri', '93', 'not_used', NULL, 213),
(3597, 'بوشينى', 'Bushenyi', '29', 'not_used', NULL, 213),
(3598, 'هويما', 'Hoima', '31', 'not_used', NULL, 213),
(3599, 'كاموينج', 'Kamwenge', '81', 'not_used', NULL, 213),
(3600, 'كابارولي', 'Kabarole', '79', 'not_used', NULL, 213),
(3601, 'سيرونكو', 'Sironko', '94', 'not_used', NULL, 213),
(3602, 'كاسيس', 'Kasese', '40', 'not_used', NULL, 213),
(3603, 'سيمبابول', 'Sembabule', '74', 'not_used', NULL, 213),
(3605, 'جينجا', 'Jinja', '33', 'not_used', NULL, 213),
(3606, 'بوسيا', 'Busia', '67', 'not_used', NULL, 213),
(3607, 'نتنجامو', 'Ntungamo', '59', 'not_used', NULL, 213),
(3608, 'كنونغ', 'Kanungu', '82', 'not_used', NULL, 213),
(3610, 'ألاباما', 'Alabama', 'AL', 'not_used', NULL, 230),
(3611, 'ألاسكا', 'Alaska', 'AK', 'not_used', NULL, 230),
(3612, 'ساموا الأمريكية', 'American Samoa', 'AS', 'not_used', NULL, 230),
(3613, 'أريزونا', 'Arizona', 'AZ', 'not_used', NULL, 230),
(3614, 'أركنساس', 'Arkansas', 'AR', 'not_used', NULL, 230),
(3615, 'كاليفورنيا', 'California', 'CA', 'not_used', NULL, 230),
(3616, 'كولورادو', 'Colorado', 'CO', 'not_used', NULL, 230),
(3617, 'كونيتيكت', 'Connecticut', 'CT', 'not_used', NULL, 230),
(3618, 'ديلاوير', 'Delaware', 'DE', 'not_used', NULL, 230),
(3619, 'مقاطعة كولومبيا', 'District of Columbia', 'DC', 'not_used', NULL, 230),
(3620, 'فلوريدا', 'Florida', 'FL', 'not_used', NULL, 230),
(3621, 'جورجيا', 'Georgia', 'GA', 'not_used', NULL, 230),
(3622, 'غوام', 'Guam', 'GU', 'not_used', NULL, 230),
(3623, 'هاواي', 'Hawaii', 'HI', 'not_used', NULL, 230),
(3624, 'ايداهو', 'Idaho', 'ID', 'not_used', NULL, 230),
(3625, 'إلينوي', 'Illinois', 'IL', 'not_used', NULL, 230),
(3626, 'إنديانا', 'Indiana', 'IN', 'not_used', NULL, 230),
(3627, 'أيوا', 'Iowa', 'IA', 'not_used', NULL, 230),
(3628, 'كانساس', 'Kansas', 'KS', 'not_used', NULL, 230),
(3629, 'كنتاكي', 'Kentucky', 'KY', 'not_used', NULL, 230),
(3630, 'لويزيانا', 'Louisiana', 'LA', 'not_used', NULL, 230),
(3631, 'مين', 'Maine', 'ME', 'not_used', NULL, 230),
(3632, 'جزر مارشال', 'Marshall Islands', 'MH', 'not_used', NULL, 230),
(3633, 'ماريلاند', 'Maryland', 'MD', 'not_used', NULL, 230),
(3634, 'ماساتشوستس', 'Massachusetts', 'MA', 'not_used', NULL, 230),
(3635, 'ميشيغان', 'Michigan', 'MI', 'not_used', NULL, 230),
(3636, 'ولايات ميكرونيزيا الموحدة', 'Federated States of Micronesia', 'FM', 'not_used', NULL, 230),
(3637, 'مينيسوتا', 'Minnesota', 'MN', 'not_used', NULL, 230),
(3638, 'ميسيسيبي', 'Mississippi', 'MS', 'not_used', NULL, 230),
(3639, 'ميسوري', 'Missouri', 'MO', 'not_used', NULL, 230),
(3640, 'مونتانا', 'Montana', 'MT', 'not_used', NULL, 230),
(3641, 'نبراسكا', 'Nebraska', 'NE', 'not_used', NULL, 230),
(3642, 'نيفادا', 'Nevada', 'NV', 'not_used', NULL, 230),
(3643, 'نيو هامبشاير', 'New Hampshire', 'NH', 'not_used', NULL, 230),
(3644, 'نيو جيرسي', 'New Jersey', 'NJ', 'not_used', NULL, 230),
(3645, 'المكسيك جديدة', 'New Mexico', 'NM', 'not_used', NULL, 230),
(3646, 'نيويورك', 'New York', 'NY', 'not_used', NULL, 230),
(3647, 'شمال كارولينا', 'North Carolina', 'NC', 'not_used', NULL, 230),
(3648, 'شمال داكوتا', 'North Dakota', 'ND', 'not_used', NULL, 230),
(3649, 'جزر مريانا الشمالية', 'Northern Mariana Islands', 'MP', 'not_used', NULL, 230),
(3650, 'أوهايو', 'Ohio', 'OH', 'not_used', NULL, 230),
(3651, 'أوكلاهوما', 'Oklahoma', 'OK', 'not_used', NULL, 230),
(3652, 'ولاية أوريغون', 'Oregon', 'OR', 'not_used', NULL, 230),
(3653, 'بالاو', 'Palau', 'PW', 'not_used', NULL, 230),
(3654, 'بنسلفانيا', 'Pennsylvania', 'PA', 'not_used', NULL, 230),
(3655, 'بورتوريكو', 'Puerto Rico', 'PR', 'not_used', NULL, 230),
(3656, 'جزيرة رود', 'Rhode Island', 'RI', 'not_used', NULL, 230),
(3657, 'كارولينا الجنوبية', 'South Carolina', 'SC', 'not_used', NULL, 230),
(3658, 'جنوب داكوتا', 'South Dakota', 'SD', 'not_used', NULL, 230),
(3659, 'تينيسي', 'Tennessee', 'TN', 'not_used', NULL, 230),
(3660, 'تكساس', 'Texas', 'TX', 'not_used', NULL, 230),
(3661, 'يوتا', 'Utah', 'UT', 'not_used', NULL, 230),
(3662, 'فيرمونت', 'Vermont', 'VT', 'not_used', NULL, 230),
(3663, 'جزر العذراء', 'Virgin Islands', 'VI', 'not_used', NULL, 230),
(3664, 'فرجينيا', 'Virginia', 'VA', 'not_used', NULL, 230),
(3665, 'واشنطن', 'Washington', 'WA', 'not_used', NULL, 230),
(3666, 'فرجينيا الغربية', 'West Virginia', 'WV', 'not_used', NULL, 230),
(3667, 'ولاية ويسكونسن', 'Wisconsin', 'WI', 'not_used', NULL, 230),
(3668, 'وايومنغ', 'Wyoming', 'WY', 'not_used', NULL, 230),
(3669, 'روشا', 'Rocha', '14', 'not_used', NULL, 214),
(3670, 'فلوريدا', 'Florida', '07', 'not_used', NULL, 214),
(3671, 'مونتيفيديو', 'Montevideo', '10', 'not_used', NULL, 214),
(3672, 'ريفيرا', 'Rivera', '13', 'not_used', NULL, 214),
(3673, 'سيرو لارجو', 'Cerro Largo', '03', 'not_used', NULL, 214),
(3674, 'تاكواريمبو', 'Tacuarembo', '18', 'not_used', NULL, 214),
(3675, 'افاييخا', 'Lavalleja', '08', 'not_used', NULL, 214),
(3676, 'Treinta ذ تريس', 'Treinta y Tres', '19', 'not_used', NULL, 214),
(3677, 'سوريانو', 'Soriano', '17', 'not_used', NULL, 214),
(3678, 'دورازنو', 'Durazno', '05', 'not_used', NULL, 214),
(3679, 'كانيلونز', 'Canelones', '02', 'not_used', NULL, 214),
(3680, 'فلوريس', 'Flores', '06', 'not_used', NULL, 214),
(3681, 'مالدونادو', 'Maldonado', '09', 'not_used', NULL, 214),
(3682, 'سالتو', 'Salto', '15', 'not_used', NULL, 214),
(3683, 'ريو نيغرو', 'Rio Negro', '12', 'not_used', NULL, 214),
(3684, 'أرتيجاس', 'Artigas', '01', 'not_used', NULL, 214),
(3685, 'بايساندو', 'Paysandu', '11', 'not_used', NULL, 214),
(3686, 'كولونيا', 'Colonia', '04', 'not_used', NULL, 214),
(3687, 'سان خوسيه', 'San Jose', '16', 'not_used', NULL, 214),
(3688, 'Khorazm', 'Khorazm', '05', 'not_used', NULL, 215),
(3689, 'قاشقادري', 'Qashqadaryo', '08', 'not_used', NULL, 215),
(3690, 'سمرقند', 'Samarqand', '10', 'not_used', NULL, 215),
(3691, 'أنديجان', 'Andijon', '01', 'not_used', NULL, 215),
(3692, 'جيزاكس', 'Jizzax', '15', 'not_used', NULL, 215),
(3693, 'طشقند', 'Toshkent', '14', 'not_used', NULL, 215),
(3694, 'Surkhondaryo', 'Surkhondaryo', '12', 'not_used', NULL, 215),
(3695, 'Qoraqalpoghiston', 'Qoraqalpoghiston', '09', 'not_used', NULL, 215),
(3696, 'Nawoiy', 'Nawoiy', '07', 'not_used', NULL, 215),
(3698, 'نامانجان', 'Namangan', '06', 'not_used', NULL, 215),
(3699, 'Farghona', 'Farghona', '03', 'not_used', NULL, 215),
(3700, 'Bukhoro', 'Bukhoro', '02', 'not_used', NULL, 215),
(3701, 'طشقند', 'Toshkent', '13', 'not_used', NULL, 215),
(3703, 'شارلوت', 'Charlotte', '01', 'not_used', NULL, 216),
(3704, 'القديس جورج', 'Saint George', '04', 'not_used', NULL, 216),
(3705, 'غرينادين', 'Grenadines', '06', 'not_used', NULL, 216),
(3706, 'سانت باتريك', 'Saint Patrick', '05', 'not_used', NULL, 216),
(3707, 'القديس أندرو', 'Saint Andrew', '02', 'not_used', NULL, 216),
(3708, 'القديس داود', 'Saint David', '03', 'not_used', NULL, 216),
(3709, 'صقر', 'Falcon', '11', 'not_used', NULL, 217),
(3710, 'محض', 'Apure', '03', 'not_used', NULL, 217),
(3711, 'بوليفار', 'Bolivar', '06', 'not_used', NULL, 217),
(3712, 'تاكيرا', 'Tachira', '20', 'not_used', NULL, 217),
(3713, 'ميراندا', 'Miranda', '15', 'not_used', NULL, 217),
(3714, 'غواريكو', 'Guarico', '12', 'not_used', NULL, 217),
(3715, 'انزواتيجي', 'Anzoategui', '02', 'not_used', NULL, 217),
(3716, 'نويفا اسبارتا', 'Nueva Esparta', '17', 'not_used', NULL, 217),
(3717, 'بورتوغيزا', 'Portuguesa', '18', 'not_used', NULL, 217),
(3718, 'سوكري', 'Sucre', '19', 'not_used', NULL, 217),
(3719, 'باريناس', 'Barinas', '05', 'not_used', NULL, 217),
(3720, 'لارا', 'Lara', '13', 'not_used', NULL, 217),
(3721, 'سوليا', 'Zulia', '23', 'not_used', NULL, 217),
(3722, 'ميريدا', 'Merida', '14', 'not_used', NULL, 217),
(3723, 'كارابوبو', 'Carabobo', '07', 'not_used', NULL, 217),
(3724, 'كوجيديس', 'Cojedes', '08', 'not_used', NULL, 217),
(3725, 'أراغوا', 'Aragua', '04', 'not_used', NULL, 217),
(3726, 'ياراكوي', 'Yaracuy', '22', 'not_used', NULL, 217),
(3727, 'أمازوناس', 'Amazonas', '01', 'not_used', NULL, 217),
(3728, 'موناجاس', 'Monagas', '16', 'not_used', NULL, 217),
(3729, 'تروخيو', 'Trujillo', '21', 'not_used', NULL, 217),
(3730, 'فارغاس', 'Vargas', '26', 'not_used', NULL, 217),
(3732, 'دلتا أماكورو', 'Delta Amacuro', '09', 'not_used', NULL, 217),
(3733, 'وفي مقاطعة الاتحادية', 'Distrito Federal', '25', 'not_used', NULL, 217),
(3734, 'Dependencias Federales', 'Dependencias Federales', '24', 'not_used', NULL, 217),
(3742, 'ثانه هوا', 'Thanh Hoa', '34', 'not_used', NULL, 220),
(3745, 'كوانج نام', 'Quang Nam', '84', 'not_used', NULL, 220),
(3746, 'الابن لا', 'Son La', '32', 'not_used', NULL, 220),
(3751, 'تاي نينه', 'Tay Ninh', '33', 'not_used', NULL, 220),
(3753, 'التايلانديه بينه', 'Thai Binh', '35', 'not_used', NULL, 220),
(3754, 'كين جيانج', 'Kien Giang', '21', 'not_used', NULL, 220),
(3755, 'دونج ثاب', 'Dong Thap', '09', 'not_used', NULL, 220),
(3761, 'سوك ترانج', 'Soc Trang', '65', 'not_used', NULL, 220),
(3764, 'بن تري', 'Ben Tre', '03', 'not_used', NULL, 220),
(3765, 'هوشي منه', 'Ho Chi Minh', '20', 'not_used', NULL, 220),
(3766, 'ترا فينه', 'Tra Vinh', '67', 'not_used', NULL, 220),
(3767, 'هاي فونج', 'Hai Phong', '13', 'not_used', NULL, 220),
(3768, 'تساو بانج', 'Cao Bang', '05', 'not_used', NULL, 220),
(3769, 'آن جيانج', 'An Giang', '01', 'not_used', NULL, 220),
(3772, 'نجى آن', 'Nghe An', '58', 'not_used', NULL, 220),
(3773, 'جيا لاي', 'Gia Lai', '49', 'not_used', NULL, 220),
(3774, 'لام دونغ', 'Lam Dong', '23', 'not_used', NULL, 220),
(3775, 'بينه دنه', 'Binh Dinh', '46', 'not_used', NULL, 220),
(3776, 'بينه فووك', 'Binh Phuoc', '76', 'not_used', NULL, 220),
(3777, 'لانج سون', 'Lang Son', '39', 'not_used', NULL, 220),
(3778, 'تيان جيانج', 'Tien Giang', '37', 'not_used', NULL, 220),
(3779, 'طويل', 'Long An', '24', 'not_used', NULL, 220),
(3780, 'نينه ثوان', 'Ninh Thuan', '60', 'not_used', NULL, 220),
(3781, 'كوانج نينه', 'Quang Ninh', '30', 'not_used', NULL, 220),
(3782, 'باك ليو', 'Bac Lieu', '73', 'not_used', NULL, 220),
(3783, 'كا ماو', 'Ca Mau', '77', 'not_used', NULL, 220),
(3786, 'بينه دونغ', 'Binh Duong', '75', 'not_used', NULL, 220),
(3787, 'بينه ثوان', 'Binh Thuan', '47', 'not_used', NULL, 220),
(3788, 'فينه لونج', 'Vinh Long', '69', 'not_used', NULL, 220),
(3789, 'دونج ناي', 'Dong Nai', '43', 'not_used', NULL, 220),
(3791, 'باك اساسه', 'Bac Kan', '72', 'not_used', NULL, 220),
(3792, 'باك جيانج', 'Bac Giang', '71', 'not_used', NULL, 220),
(3793, 'ثوا ثين هوي', 'Thua Thien-Hue', '66', 'not_used', NULL, 220),
(3794, 'باك نينه', 'Bac Ninh', '74', 'not_used', NULL, 220),
(3795, 'ها جيانج', 'Ha Giang', '50', 'not_used', NULL, 220),
(3796, 'توين كوانج', 'Tuyen Quang', '68', 'not_used', NULL, 220),
(3797, 'التايلاندية نغوين', 'Thai Nguyen', '85', 'not_used', NULL, 220),
(3798, 'دا نانج', 'Da Nang', '78', 'not_used', NULL, 220),
(3799, 'خانه هوا', 'Khanh Hoa', '54', 'not_used', NULL, 220),
(3800, 'با ريا فونج تاو', 'Ba Ria-Vung Tau', '45', 'not_used', NULL, 220),
(3801, 'كوانج نجاي', 'Quang Ngai', '63', 'not_used', NULL, 220),
(3803, 'ها نام', 'Ha Nam', '80', 'not_used', NULL, 220),
(3804, 'فو ين', 'Phu Yen', '61', 'not_used', NULL, 220),
(3805, 'كوانغ بينه', 'Quang Binh', '62', 'not_used', NULL, 220),
(3806, 'فو ثو', 'Phu Tho', '83', 'not_used', NULL, 220),
(3807, 'كوانغ تري', 'Quang Tri', '64', 'not_used', NULL, 220),
(3808, 'ها تنه', 'Ha Tinh', '52', 'not_used', NULL, 220),
(3809, 'كون توم', 'Kon Tum', '55', 'not_used', NULL, 220),
(3811, 'ين باي', 'Yen Bai', '70', 'not_used', NULL, 220),
(3812, 'نينه بينه', 'Ninh Binh', '59', 'not_used', NULL, 220),
(3813, 'نام دينه', 'Nam Dinh', '82', 'not_used', NULL, 220),
(3814, 'هاي دونج', 'Hai Duong', '79', 'not_used', NULL, 220),
(3815, 'ها نوي', 'Ha Noi', '44', 'not_used', NULL, 220),
(3816, 'هوا بينه', 'Hoa Binh', '53', 'not_used', NULL, 220),
(3817, 'هونغ ين', 'Hung Yen', '81', 'not_used', NULL, 220),
(3818, 'فينه فوك', 'Vinh Phuc', '86', 'not_used', NULL, 220),
(3819, 'سانما', 'Sanma', '13', 'not_used', NULL, 221);
INSERT INTO `cities` (`id`, `name_ar`, `name_en`, `code`, `status`, `shipping_price`, `country_id`) VALUES
(3820, 'أوبا', 'Aoba', '06', 'not_used', NULL, 221),
(3821, 'الراعي', 'Shepherd', '14', 'not_used', NULL, 221),
(3822, 'Malakula', 'Malakula', '10', 'not_used', NULL, 221),
(3823, 'Pentecote', 'Pentecote', '12', 'not_used', NULL, 221),
(3824, 'توربا', 'Torba', '07', 'not_used', NULL, 221),
(3825, 'إيفات', 'Efate', '08', 'not_used', NULL, 221),
(3826, 'تافيا', 'Tafea', '15', 'not_used', NULL, 221),
(3827, 'Ambrym', 'Ambrym', '05', 'not_used', NULL, 221),
(3828, 'برنامج التحصين الموسع', 'Epi', '09', 'not_used', NULL, 221),
(3829, 'Paama في', 'Paama', '11', 'not_used', NULL, 221),
(3832, 'لحج', 'Lahij', '06', 'not_used', NULL, 224),
(3833, 'صعدة', 'Sa\'dah', '15', 'not_used', NULL, 224),
(3834, 'الحديدة', 'Al Hudaydah', '08', 'not_used', NULL, 224),
(3835, 'مأرب', 'Ma\'rib', '14', 'not_used', NULL, 224),
(3836, 'البيضاء', 'Al Bayda\'', '07', 'not_used', NULL, 224),
(3837, 'ذمار', 'Dhamar', '11', 'not_used', NULL, 224),
(3838, 'صنعاء\'', 'San\'a\'', '16', 'not_used', NULL, 224),
(3839, 'المهرة', 'Al Mahrah', '03', 'not_used', NULL, 224),
(3840, 'حضرموت', 'Hadramawt', '04', 'not_used', NULL, 224),
(3841, 'تعز', 'Taizz', '17', 'not_used', NULL, 224),
(3842, 'حجة', 'Hajjah', '12', 'not_used', NULL, 224),
(3843, 'أبين', 'Abyan', '01', 'not_used', NULL, 224),
(3844, 'إب', 'Ibb', '13', 'not_used', NULL, 224),
(3845, 'عدن', 'Adan', '02', 'not_used', NULL, 224),
(3846, 'المحويت', 'Al Mahwit', '10', 'not_used', NULL, 224),
(3847, 'الجوف', 'Al Jawf', '09', 'not_used', NULL, 224),
(3850, 'الرأس الغربي', 'Western Cape', '11', 'not_used', NULL, 226),
(3851, 'الرأس الشرقي', 'Eastern Cape', '05', 'not_used', NULL, 226),
(3852, 'مبومالانغا', 'Mpumalanga', '07', 'not_used', NULL, 226),
(3853, 'دولة حرة', 'Free State', '03', 'not_used', NULL, 226),
(3854, 'الشمال الغربي', 'North-West', '10', 'not_used', NULL, 226),
(3855, 'ليمبوبو', 'Limpopo', '09', 'not_used', NULL, 226),
(3856, 'كوازولو ناتال', 'KwaZulu-Natal', '02', 'not_used', NULL, 226),
(3857, 'المنطقة الشمالية الغربية', 'North-Western Province', '01', 'not_used', NULL, 226),
(3858, 'غوتنغ', 'Gauteng', '06', 'not_used', NULL, 226),
(3859, 'الرأس الشمالي', 'Northern Cape', '08', 'not_used', NULL, 226),
(3861, 'جنوبي', 'Southern', '07', 'not_used', NULL, 227),
(3862, 'الشمالية الغربية', 'North-Western', '06', 'not_used', NULL, 227),
(3863, 'شمالي', 'Northern', '05', 'not_used', NULL, 227),
(3864, 'الغربي', 'Western', '01', 'not_used', NULL, 227),
(3865, 'الشرقية', 'Eastern', '03', 'not_used', NULL, 227),
(3866, 'حزام النحاس', 'Copperbelt', '08', 'not_used', NULL, 227),
(3867, 'وابولا', 'Luapula', '04', 'not_used', NULL, 227),
(3868, 'وسط', 'Central', '02', 'not_used', NULL, 227),
(3869, 'لوساكا', 'Lusaka', '09', 'not_used', NULL, 227),
(3883, 'ماتابيللاند الشمالية', 'Matabeleland North', '06', 'not_used', NULL, 229),
(3884, 'ماشونالاند الشرقية', 'Mashonaland East', '04', 'not_used', NULL, 229),
(3885, 'ماشونالاند الوسطى', 'Mashonaland Central', '03', 'not_used', NULL, 229),
(3886, 'ماتابيليلاند الجنوبية', 'Matabeleland South', '07', 'not_used', NULL, 229),
(3888, 'ماسفينغو', 'Masvingo', '08', 'not_used', NULL, 229),
(3890, 'نجران', 'Najran', '1', 'used', 150.00, 178),
(3892, 'الخبر', 'alkhabar', '2', 'used', 40.00, 178);

-- --------------------------------------------------------

--
-- Table structure for table `colors`
--

CREATE TABLE `colors` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `color_code` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `colors`
--

INSERT INTO `colors` (`id`, `name`, `color_code`) VALUES
(1, 'احمر', '#ff1500'),
(3, 'ازرق', '#0004ff'),
(4, 'اصفر', '#f7ff03');

-- --------------------------------------------------------

--
-- Table structure for table `color_product`
--

CREATE TABLE `color_product` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `color_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `comment` text NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `rate` enum('1','2','3','4','5') DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `common_questions`
--

CREATE TABLE `common_questions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `common_questions`
--

INSERT INTO `common_questions` (`id`, `title`, `description`, `created_at`, `updated_at`) VALUES
(1, 'ما هي مدة التوصيل المتوقعة للطلبات؟', 'نحن نسعى جاهدين لتوصيل طلباتكم بأسرع وقت ممكن. عادةً ما تستغرق مدة التوصيل داخل المدينة من 1 إلى 3 أيام عمل، وللمدن الأخرى من 3 إلى 7 أيام عمل. قد تختلف المدة حسب موقعكم وخيارات الشحن المتاحة.', '2024-07-07 10:17:39', '2024-11-19 15:02:27'),
(2, 'هل يمكنني استبدال أو إرجاع المنتج إذا لم يكن كما توقعت؟', 'نعم، يمكنكم استبدال أو إرجاع المنتج خلال 14 يومًا من استلام الطلب بشرط أن يكون المنتج بحالته الأصلية وغير مستخدم، مع توفير الفاتورة. لمزيد من التفاصيل، يمكنكم مراجعة سياسة الإرجاع لدينا.', '2024-07-07 10:18:28', '2024-11-19 15:02:58');

-- --------------------------------------------------------

--
-- Table structure for table `companies`
--

CREATE TABLE `companies` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `name_en` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `companies`
--

INSERT INTO `companies` (`id`, `name`, `name_en`, `image`, `created_at`, `updated_at`) VALUES
(1, 'السعودي', 'alsaody', 'uploads/companies/fzJuvrTgR5BjOU3qg9EnIk8gg4AGNB6gF4PZiLbb.jpg', '2024-11-13 12:32:36', '2024-11-13 12:43:12'),
(2, 'مدستار', 'medstar', 'uploads/companies/uAC6PI6vojNRKZT7DRdHmYQIINUuB5xgLowF7K7s.jpg', '2024-11-13 12:33:15', '2024-11-13 12:42:38'),
(3, 'المنديل الابيض', NULL, 'uploads/companies/4mcYRRWNBzNfjogYCdmNP9sFdtNFQBVutK7iWO1I.png', '2024-11-13 12:34:32', '2024-11-13 12:34:32'),
(4, 'اوريكو', NULL, 'uploads/companies/kLoMd2LIYQqA5Rha8xhQ7ODdxGZ1gHxKxlZ4d7Go.png', '2024-11-13 12:35:13', '2024-11-13 12:35:13'),
(5, 'اّل ياسر', NULL, 'uploads/companies/fIlvkqOyoCeUqAAWNMj6tBpM5U1VhEzdyMNQpyWl.jpg', '2024-11-13 12:35:51', '2024-11-13 12:44:06'),
(6, 'السعودية لصناعة الاوراق', NULL, 'uploads/companies/zhnPamdo1sFA6OcAJTTrzsCdtDbC5BIsXyx1RcG2.png', '2024-11-13 12:36:45', '2024-11-13 12:36:45'),
(7, 'test', 'test', 'uploads/companies/fE5uHOco8K46A5nkq4uDlSQy58AaLyO6PhaQ8DLy.jpg', '2025-01-12 08:09:54', '2025-01-12 08:09:54');

-- --------------------------------------------------------

--
-- Table structure for table `contact_us`
--

CREATE TABLE `contact_us` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `phone_number` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `email` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `contact_us`
--

INSERT INTO `contact_us` (`id`, `name`, `phone_number`, `message`, `email`, `created_at`, `updated_at`) VALUES
(1, 'Search Engine Index', '499613345', 'Hello,\n\nfor your website do be displayed in searches your domain needs to be indexed in the Google Search Index.\n\nTo add your domain to Google Search Index now, please visit \n\nhttps://SearchRegister.org/', 'submissions@searchindex.site', '2024-11-15 16:41:21', '2024-11-15 16:41:21'),
(2, 'Search Engine Index', '677101866', 'Hello,\r\n\r\nfor your website do be displayed in searches your domain needs to be indexed in the Google Search Index.\r\n\r\nTo add your domain to Google Search Index now, please visit \r\n\r\nhttps://SearchRegister.info/', 'submissions@searchindex.site', '2024-11-16 05:26:15', '2024-11-16 05:26:15'),
(3, 'Search Engine Index', '613359028', 'Hello,\r\n\r\nfor your website do be displayed in searches your domain needs to be indexed in the Google Search Index.\r\n\r\nTo add your domain to Google Search Index now, please visit \r\n\r\nhttps://SearchRegister.org/', 'submissions@searchindex.site', '2024-11-16 17:41:10', '2024-11-16 17:41:10'),
(4, 'Search Engine Index', '45141194', 'Hello,\r\n\r\nfor your website do be displayed in searches your domain needs to be indexed in the Google Search Index.\r\n\r\nTo add your domain to Google Search Index now, please visit \r\n\r\nhttps://SearchRegister.org/', 'submissions@searchindex.site', '2024-11-16 18:36:53', '2024-11-16 18:36:53'),
(5, 'Search Engine Index', '327552641', 'Hello,\r\n\r\nfor your website do be displayed in searches your domain needs to be indexed in the Google Search Index.\r\n\r\nTo add your domain to Google Search Index now, please visit \r\n\r\nhttps://SearchRegister.info/', 'submissions@searchindex.site', '2024-11-16 22:25:18', '2024-11-16 22:25:18'),
(6, 'Search Engine Index', '9058201148', 'Hello,\r\n\r\nfor your website do be displayed in searches your domain needs to be indexed in the Google Search Index.\r\n\r\nTo add your domain to Google Search Index now, please visit \r\n\r\nhttps://SearchRegister.info/', 'submissions@searchindex.site', '2024-11-17 00:30:05', '2024-11-17 00:30:05'),
(7, 'Lindsay Bickford', '753621368', 'Looking to increase traffic to your video or website on a budget? For Details: http://h6j4hu.contactblastingworks.my', 'bickford.lindsay51@gmail.com', '2024-11-17 04:34:46', '2024-11-17 04:34:46'),
(8, 'Search Engine Index', '6559440859', 'Hello,\r\n\r\nfor your website do be displayed in searches your domain needs to be indexed in the Google Search Index.\r\n\r\nTo add your domain to Google Search Index now, please visit \r\n\r\nhttps://SearchRegister.org/', 'submissions@searchindex.site', '2024-11-17 14:16:19', '2024-11-17 14:16:19'),
(9, 'Monarch Web', '1234567890', 'Hello team, \"imdadataldiyhafah.com\"\r\n\r\nI just wanted to know if you require a better solution to manage SEO, SMO, SMM, PPC Campaigns, keyword research, Reporting etc.\r\n\r\nWe can manage all as we have a 150+ expert team of professionals and help you save a hefty amount on hiring resources.\r\n\r\nWe can increase targeted visitor\'s to your website so that it appears on Google\'s first page. Bing, Yahoo, AOL, etc.\r\n\r\nPlease respond with your phone number, so we can schedule a follow-up call for you within 24 hours. I\'d be glad to go over our plan with you.\r\n\r\n\r\nThank you,\r\nMonarch Web', 'monarchwebsolution@gmail.com', '2024-11-18 09:00:09', '2024-11-18 09:00:09'),
(10, 'Deep Arora', '1234567890', 'Hey there,\r\n\r\nhttp://www.imdadataldiyhafah.com\r\n\r\nI am SEO/Digital Marketing Consultant and I work with 30+experienced IT professionals.\r\n\r\nWe can increase targeted traffic to your website so that it appears on Google\'s first page. Bing, Yahoo, AOL, etc.\r\n\r\nDo you want to appear on the front page, then?\r\n\r\nNote: I’d love to have a quick chat or call to find out if you are interested to know more about our SEO service and price.\r\n\r\nKind Regards,\r\nSud A | SEO manager\r\n\r\n\r\n\r\n\r\n\r\n If you don’t want me to contact you again about this, reply with “no thanks”', 'info@letsoptimizeweb.com', '2024-11-26 17:23:33', '2024-11-26 17:23:33'),
(11, 'Search Engine Index', '7944353704', 'Hello,\r\n\r\nfor your website do be displayed in searches your domain needs to be indexed in the Google Search Index.\r\n\r\nTo add your domain to Google Search Index now, please visit \r\n\r\nhttps://SearchRegister.org/', 'submissions@searchindex.site', '2024-11-27 15:15:29', '2024-11-27 15:15:29'),
(12, 'Sud A', '1234567890', 'Hey there,\n\nhttp://www.imdadataldiyhafah.com\n\nI am SEO/Digital Marketing Consultant and I work with 30+experienced IT professionals.\n\nWe can increase targeted traffic to your website so that it appears on Google\'s first page. Bing, Yahoo, AOL, etc.\n\nDo you want to appear on the front page, then?\n\nNote: I’d love to have a quick chat or call to find out if you are interested to know more about our SEO service and price.\n\nKind Regards,\nSud A | Digital marketing manager\n\n\n\n\n\n If you don’t want me to contact you again about this, reply with “no thanks”', 'info@letsoptimizeweb.com', '2024-11-29 04:42:09', '2024-11-29 04:42:09'),
(13, 'Search Engine Index', '9267794304', 'Hello,\r\n\r\nfor your website do be displayed in searches your domain needs to be indexed in the Google Search Index.\r\n\r\nTo add your domain to Google Search Index now, please visit \r\n\r\nhttps://SearchRegister.org/', 'submissions@searchindex.site', '2024-12-07 18:13:42', '2024-12-07 18:13:42'),
(14, 'Luella Fong', '3017600115', '', 'fong.luella@gmail.com', '2024-12-12 02:57:28', '2024-12-12 02:57:28'),
(15, 'Rolando Rumsey', '887253488', 'Businesses that accepted Visa/Mastercard payments between 2004 and 2019 may qualify for compensation as part of the $5.54 billion class action settlement.\nThe deadline is fast approaching: February 4, 2025.\nAct now to claim your share!\nVisit: http://cardsettlement.top for details and filing assistance.', 'rolando.rumsey@gmail.com', '2024-12-12 04:37:09', '2024-12-12 04:37:09'),
(16, 'Monarch Web', '2132620124', 'Hello pageranktechnology@gmail.com,\r\n\r\nWe collaborate with start-ups, SMBs, and new domain owners to provide Website design - re-design and development services at modest rate.\r\n\r\nWe have a dedicated team of 45 professional designers and developers with over 8 plus years of experience and we thrive on the idea that design makes a difference.\r\n\r\nOur services at a glance: -\r\n\r\nWebsite Designing/Re-Designing\r\n\r\n#E-commerce development (Magento, Shopify, Woo Commerce etc.)\r\n\r\n#Graphic Designing\r\n\r\n#WordPress Theme Design & Customization\r\n\r\n#Custom themes, Plugins & Widget Development\r\n\r\n#Custom Templates, Modules, Plugins Design & Development\r\n\r\nShare a brief about your project with your phone number (With Country Code) /Skype and suitable time (Meeting) to talk to you, and get a guaranteed response within 24 hours.\r\n\r\nI’m waiting for your reply.\r\n\r\nThanks in Advance,\r\nMonarch\r\n\r\n\r\n\r\n\r\nYour website: imdadataldiyhafah.com\r\n\r\nNote: - If you’re not Interested in our services, send us \"opt-out\"', 'pageranktechnology@gmail.com', '2024-12-12 14:13:03', '2024-12-12 14:13:03'),
(17, 'Eddy Collette', '3904113235', 'Businesses that accepted Visa/Mastercard payments between 2004 and 2019 may qualify for compensation as part of the $5.54 billion class action settlement.\r\nThe deadline is fast approaching: February 4, 2025.\r\nAct now to claim your share!\r\nVisit: http://cardsettlement.top for details and filing assistance.', 'collette.eddy@gmail.com', '2024-12-14 04:48:31', '2024-12-14 04:48:31'),
(18, 'Amelia Brown', '96431078', 'Hi there,\r\n\r\nWe run a Youtube growth service, where we can increase your subscriber count safely and practically. \r\n\r\n- Guaranteed: We guarantee to gain you 700-1500 new subscribers each month.\r\n- Real, human subscribers who subscribe because they are interested in your channel/videos.\r\n- Safe: All actions are done, without using any automated tasks / bots.\r\n\r\nOur price is just $60 (USD) per month and we can start immediately.\r\n\r\nIf you are interested then we can discuss further.\r\n\r\nKind Regards,\r\nAmelia', 'ameliabrown5822@gmail.com', '2024-12-17 20:03:40', '2024-12-17 20:03:40'),
(19, 'Deep Arora', '1234567890', 'Hey imdadataldiyhafah.com,\r\n\r\nI hope you are doing good!\r\n\r\nI was going through your website on behalf of this email. It has a good design and it looks awesome, but it’s not ranking in top on Google and other major search engines.\r\n\r\nI’m an SEO Expert and I helped over 250 businesses rank on the (1st Page on Google). My charges are very compatible.\r\n\r\nTo enhance your website\'s visibility and ranking, consider implementing strategies such as improving on-site SEO, adding LSI keywords, monitoring technical SEO, aligning content with search intent, reducing bounce time, targeting additional keywords, publishing high-quality content.\r\n\r\nI would be happy to send you \"charges\", “Proposal” Past work Details, \"Our Packages\", and take Complete Responsibility for improving your Presence etc.\r\n\r\nThanks \r\nDeep Arora', 'digitalxplode1@gmail.com', '2024-12-18 07:22:58', '2024-12-18 07:22:58'),
(20, 'Joanna Riggs', '2252457267', 'Hi,\r\n\r\nI just visited imdadataldiyhafah.com and wondered if you\'d ever thought about having an engaging video to explain what you do?\r\n\r\nOur prices start from just $195.\r\n\r\nLet me know if you\'re interested in seeing samples of our previous work.\r\n\r\nRegards,\r\nJoanna\r\n\r\nUnsubscribe: https://removeme.live/unsubscribe.php?d=imdadataldiyhafah.com', 'joannariggs278@gmail.com', '2024-12-18 15:57:55', '2024-12-18 15:57:55'),
(21, 'Colette McPeak', '475583448', 'Make your marketing budget work harder. For a flat rate, we’ll send your ad text to millions of website contact forms. It’s cost-effective, reliable, and guarantees your message is read.\r\n\r\n Feel free to contact me using the details below if you want to learn more about my approach.\r\n\r\nRegards,\r\nColette McPeak\r\nEmail: Colette.McPeak@morebiz.my\r\nWebsite: http://tgpync.form-submission-masters.ink\r\nConnect with me via Skype: https://join.skype.com/invite/nVcxdDgQnfhA', 'colette.mcpeak@gmail.com', '2024-12-18 21:21:06', '2024-12-18 21:21:06'),
(22, 'NAYUYUTY4754877NERTYTRY', '84598168963', 'METRYTRE4754877MAERWETT', 'warrenwatters2022@sabesmail.com', '2024-12-20 08:29:07', '2024-12-20 08:29:07'),
(23, 'Georgina Minnis', '655466442', 'Over 10,000 satisfied users have already skyrocketed their website traffic with us. Be the next success story—start driving real results now!  \r\nDiscover more at: http://realhumanwebtraffic.top', 'georgina.minnis@gmail.com', '2024-12-25 11:35:47', '2024-12-25 11:35:47'),
(24, 'TabSainibe', '86824855415', 'Your account has been dormant for 364 days. To prevent deletion and retrieve your funds, please sign in and initiate a withdrawal within 24 hours. For help, join our Telegram group: https://t.me/s/attention6786742', 'ocuolhv5@gmail.com', '2024-12-25 16:48:44', '2024-12-25 16:48:44'),
(29, 'Mostafa Taha', '0111245547', 'هذا النص هو مثال لنص يمكن أن يستبدل في نفس المساحة، لقد تم توليد هذا النص من مولد النص العربى، حيث يمكنك أن تولد مثل هذا النص أو العديد من النصوص الأخرى إضافة إلى زيادة عدد الحروف التى يولدها التطبيق.', 'test@test.com', '2025-03-26 08:46:53', '2025-03-26 08:46:53');

--
-- Triggers `contact_us`
--
DELIMITER $$
CREATE TRIGGER `after_contact_us_delete` AFTER DELETE ON `contact_us` FOR EACH ROW BEGIN
    DELETE FROM notifications
    WHERE JSON_EXTRACT(data, '$.message_id') = OLD.id;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `cookie_discount_ids`
--

CREATE TABLE `cookie_discount_ids` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `cookie_id` varchar(255) NOT NULL,
  `discount_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cookie_discount_ids`
--

INSERT INTO `cookie_discount_ids` (`id`, `cookie_id`, `discount_id`) VALUES
(185, '2e3f2d87-45b2-4192-bf57-086a7a68db31', 22),
(186, 'a1af3cac-d45b-49af-a76c-e31c1a5a135f', 22);

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

CREATE TABLE `countries` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name_ar` varchar(255) NOT NULL,
  `phone_code` varchar(100) DEFAULT NULL,
  `name_en` varchar(255) NOT NULL,
  `code` varchar(255) NOT NULL,
  `status` enum('used','not_used') NOT NULL DEFAULT 'not_used'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `countries`
--

INSERT INTO `countries` (`id`, `name_ar`, `phone_code`, `name_en`, `code`, `status`) VALUES
(1, 'أندورا', '376', 'Andorra', 'ad', 'not_used'),
(2, 'الإمارات العربية المتحدة', '971', 'United Arab Emirates', 'ae', 'not_used'),
(3, 'أفغانستان', '93', 'Afghanistan', 'af', 'not_used'),
(4, 'أنتيغوا وبربودا', '268', 'Antigua and Barbuda', 'ag', 'not_used'),
(5, 'أنغيلا', '264', 'Anguilla', 'ai', 'not_used'),
(6, 'ألبانيا', '355', 'Albania', 'al', 'not_used'),
(7, 'أرمينيا', '374', 'Armenia', 'am', 'not_used'),
(8, 'جزر الأنتيل الهولندية', '599', 'Netherlands Antilles', 'an', 'not_used'),
(9, 'أنغولا', '244', 'Angola', 'ao', 'not_used'),
(10, 'الأرجنتين', '54', 'Argentina', 'ar', 'not_used'),
(11, 'النمسا', '43', 'Austria', 'at', 'not_used'),
(12, 'أستراليا', '61', 'Australia', 'au', 'not_used'),
(13, 'أروبا', '297', 'Aruba', 'aw', 'not_used'),
(14, 'أذربيجان', '994', 'Azerbaijan', 'az', 'not_used'),
(15, 'البوسنة والهرسك', '387', 'Bosnia and Herzegovina', 'ba', 'not_used'),
(16, 'بربادوس', '1-246', 'Barbados', 'bb', 'not_used'),
(17, 'بنغلاديش', '880', 'Bangladesh', 'bd', 'not_used'),
(18, 'بلجيكا', '32', 'Belgium', 'be', 'not_used'),
(19, 'بوركينا فاسو', '226', 'Burkina Faso', 'bf', 'not_used'),
(20, 'بلغاريا', '359', 'Bulgaria', 'bg', 'not_used'),
(21, 'البحرين', '973', 'Bahrain', 'bh', 'not_used'),
(22, 'بوروندي', '257', 'Burundi', 'bi', 'not_used'),
(23, 'بنين', '229', 'Benin', 'bj', 'not_used'),
(24, 'برمودا', '1-441', 'Bermuda', 'bm', 'not_used'),
(25, 'بروناي دار السلام', '673', 'Brunei Darussalam', 'bn', 'not_used'),
(26, 'بوليفيا', '591', 'Bolivia', 'bo', 'not_used'),
(27, 'البرازيل', '55', 'Brazil', 'br', 'not_used'),
(28, 'الباهاما', '242', 'Bahamas', 'bs', 'not_used'),
(29, 'بوتان', '975', 'Bhutan', 'bt', 'not_used'),
(30, 'بوتسوانا', '267', 'Botswana', 'bw', 'not_used'),
(31, 'روسيا البيضاء', '375', 'Belarus', 'by', 'not_used'),
(32, 'بليز', '501', 'Belize', 'bz', 'not_used'),
(33, 'كندا', '1', 'Canada', 'ca', 'not_used'),
(34, 'جزر كوكوس (كيلينغ)', '61', 'Cocos (Keeling) Islands', 'cc', 'not_used'),
(35, 'جمهورية الكونغو الديموقراطية', '243', 'Democratic Republic of the Congo', 'cd', 'not_used'),
(36, 'جمهورية افريقيا الوسطى', '236', 'Central African Republic', 'cf', 'not_used'),
(37, 'الكونغو', '242', 'Congo', 'cg', 'not_used'),
(38, 'سويسرا', '41', 'Switzerland', 'ch', 'not_used'),
(39, 'ساحل العاج (ساحل العاج)', '225', 'Cote D\'Ivoire (Ivory Coast)', 'ci', 'not_used'),
(40, 'جزر كوك', '682', 'Cook Islands', 'ck', 'not_used'),
(41, 'تشيلي', '56', 'Chile', 'cl', 'not_used'),
(42, 'الكاميرون', '237', 'Cameroon', 'cm', 'not_used'),
(43, 'الصين', '86', 'China', 'cn', 'not_used'),
(44, 'كولومبيا', '57', 'Colombia', 'co', 'not_used'),
(45, 'كوستا ريكا', '506', 'Costa Rica', 'cr', 'not_used'),
(46, 'كوبا', '53', 'Cuba', 'cu', 'not_used'),
(47, 'الرأس الأخضر', '238', 'Cape Verde', 'cv', 'not_used'),
(48, 'جزيرة الكريسماس', '61', 'Christmas Island', 'cx', 'not_used'),
(49, 'قبرص', '357', 'Cyprus', 'cy', 'not_used'),
(50, 'جمهورية التشيك', '420', 'Czech Republic', 'cz', 'not_used'),
(51, 'ألمانيا', '49', 'Germany', 'de', 'not_used'),
(52, 'جيبوتي', '253', 'Djibouti', 'dj', 'not_used'),
(53, 'الدنمارك', '45', 'Denmark', 'dk', 'not_used'),
(54, 'دومينيكا', '1-767', 'Dominica', 'dm', 'not_used'),
(55, 'جمهورية الدومنيكان', '1-809', 'Dominican Republic', 'do', 'not_used'),
(56, 'الجزائر', '213', 'Algeria', 'dz', 'not_used'),
(57, 'الإكوادور', '593', 'Ecuador', 'ec', 'not_used'),
(58, 'استونيا', '372', 'Estonia', 'ee', 'not_used'),
(59, 'مصر', '20', 'Egypt', 'eg', 'not_used'),
(60, 'الصحراء الغربية', '212', 'Western Sahara', 'eh', 'not_used'),
(61, 'إريتريا', '291', 'Eritrea', 'er', 'not_used'),
(62, 'إسبانيا', '34', 'Spain', 'es', 'not_used'),
(63, 'أثيوبيا', '251', 'Ethiopia', 'et', 'not_used'),
(64, 'فنلندا', '358', 'Finland', 'fi', 'not_used'),
(65, 'فيجي', '679', 'Fiji', 'fj', 'not_used'),
(66, 'جزر فوكلاند (مالفيناس)', '500', 'Falkland Islands (Malvinas)', 'fk', 'not_used'),
(67, 'ولايات ميكرونيزيا الموحدة', '691', 'Federated States of Micronesia', 'fm', 'not_used'),
(68, 'جزر صناعية', '298', 'Faroe Islands', 'fo', 'not_used'),
(69, 'فرنسا', '33', 'France', 'fr', 'not_used'),
(70, 'الغابون', '241', 'Gabon', 'ga', 'not_used'),
(71, 'بريطانيا العظمى (المملكة المتحدة)', '44', 'Great Britain (UK)', 'gb', 'not_used'),
(72, 'غرينادا', '1-473', 'Grenada', 'gd', 'not_used'),
(73, 'جورجيا', '995', 'Georgia', 'ge', 'not_used'),
(74, 'غيانا الفرنسية', '594', 'French Guiana', 'gf', 'not_used'),
(75, 'لا شيء', 'NULL', 'NULL', 'gg', 'not_used'),
(76, 'غانا', '233', 'Ghana', 'gh', 'not_used'),
(77, 'جبل طارق', '350', 'Gibraltar', 'gi', 'not_used'),
(78, 'الأرض الخضراء', '299', 'Greenland', 'gl', 'not_used'),
(79, 'غامبيا', '220', 'Gambia', 'gm', 'not_used'),
(80, 'غينيا', '224', 'Guinea', 'gn', 'not_used'),
(81, 'جوادلوب', '590', 'Guadeloupe', 'gp', 'not_used'),
(82, 'غينيا الإستوائية', '240', 'Equatorial Guinea', 'gq', 'not_used'),
(83, 'اليونان', '30', 'Greece', 'gr', 'not_used'),
(84, 'جورجيا وجزر ساندويتش', '500', 'S. Georgia and S. Sandwich Islands', 'gs', 'not_used'),
(85, 'غواتيمالا', '502', 'Guatemala', 'gt', 'not_used'),
(86, 'غينيا بيساو', '245', 'Guinea-Bissau', 'gw', 'not_used'),
(87, 'غيانا', '592', 'Guyana', 'gy', 'not_used'),
(88, 'هونغ كونغ', '852', 'Hong Kong', 'hk', 'not_used'),
(89, 'هندوراس', '504', 'Honduras', 'hn', 'not_used'),
(90, 'كرواتيا (هرفاتسكا)', '385', 'Croatia (Hrvatska)', 'hr', 'not_used'),
(91, 'هايتي', '509', 'Haiti', 'ht', 'not_used'),
(92, 'اليونان', '36', 'Hungary', 'hu', 'not_used'),
(93, 'أندونيسيا', '62', 'Indonesia', 'id', 'not_used'),
(94, 'أيرلندا', '353', 'Ireland', 'ie', 'not_used'),
(96, 'الهند', '91', 'India', 'in', 'not_used'),
(97, 'العراق', '964', 'Iraq', 'iq', 'not_used'),
(98, 'إيران', '98', 'Iran', 'ir', 'not_used'),
(99, 'أيسلندا', '354', 'Iceland', 'is', 'not_used'),
(100, 'إيطاليا', '39', 'Italy', 'it', 'not_used'),
(101, 'جامايكا', '1-876', 'Jamaica', 'jm', 'not_used'),
(102, 'الأردن', '962', 'Jordan', 'jo', 'not_used'),
(103, 'اليابان', '81', 'Japan', 'jp', 'not_used'),
(104, 'كينيا', '254', 'Kenya', 'ke', 'not_used'),
(105, 'قرغيزستان', '996', 'Kyrgyzstan', 'kg', 'not_used'),
(106, 'كمبوديا', '855', 'Cambodia', 'kh', 'not_used'),
(107, 'كيريباس', '686', 'Kiribati', 'ki', 'not_used'),
(108, 'جزر القمر', '269', 'Comoros', 'km', 'not_used'),
(109, 'سانت كيتس ونيفيس', '1-869', 'Saint Kitts and Nevis', 'kn', 'not_used'),
(110, 'كوريا الشمالية', '850', 'Korea (North)', 'kp', 'not_used'),
(111, 'كوريا، جنوب)', '82', 'Korea (South)', 'kr', 'not_used'),
(112, 'الكويت', '965', 'Kuwait', 'kw', 'not_used'),
(113, 'جزر كايمان', '1-345', 'Cayman Islands', 'ky', 'not_used'),
(114, 'كازاخستان', '7', 'Kazakhstan', 'kz', 'not_used'),
(115, 'لاوس', '856', 'Laos', 'la', 'not_used'),
(116, 'لبنان', '961', 'Lebanon', 'lb', 'not_used'),
(117, 'القديسة لوسيا', '1-758', 'Saint Lucia', 'lc', 'not_used'),
(118, 'ليختنشتاين', '423', 'Liechtenstein', 'li', 'not_used'),
(119, 'سيريلانكا', '94', 'Sri Lanka', 'lk', 'not_used'),
(120, 'ليبيريا', '231', 'Liberia', 'lr', 'not_used'),
(121, 'ليسوتو', '266', 'Lesotho', 'ls', 'not_used'),
(122, 'ليتوانيا', '370', 'Lithuania', 'lt', 'not_used'),
(123, 'لوكسمبورغ', '352', 'Luxembourg', 'lu', 'not_used'),
(124, 'لاتفيا', '371', 'Latvia', 'lv', 'not_used'),
(125, 'ليبيا', '218', 'Libya', 'ly', 'not_used'),
(126, 'المغرب', '212', 'Morocco', 'ma', 'not_used'),
(127, 'موناكو', '377', 'Monaco', 'mc', 'not_used'),
(128, 'مولدوفا', '373', 'Moldova', 'md', 'not_used'),
(129, 'مدغشقر', '261', 'Madagascar', 'mg', 'not_used'),
(130, 'جزر مارشال', '692', 'Marshall Islands', 'mh', 'not_used'),
(131, 'مقدونيا', '389', 'Macedonia', 'mk', 'not_used'),
(132, 'مالي', '223', 'Mali', 'ml', 'not_used'),
(133, 'ميانمار', '95', 'Myanmar', 'mm', 'not_used'),
(134, 'منغوليا', '976', 'Mongolia', 'mn', 'not_used'),
(135, 'ماكاو', '853', 'Macao', 'mo', 'not_used'),
(136, 'جزر مريانا الشمالية', '1-670', 'Northern Mariana Islands', 'mp', 'not_used'),
(137, 'مارتينيك', '596', 'Martinique', 'mq', 'not_used'),
(138, 'موريتانيا', '222', 'Mauritania', 'mr', 'not_used'),
(139, 'مونتسيرات', '1-664', 'Montserrat', 'ms', 'not_used'),
(140, 'مالطا', '356', 'Malta', 'mt', 'not_used'),
(141, 'موريشيوس', '230', 'Mauritius', 'mu', 'not_used'),
(142, 'جزر المالديف', '960', 'Maldives', 'mv', 'not_used'),
(143, 'مالاوي', '265', 'Malawi', 'mw', 'not_used'),
(144, 'المكسيك', '52', 'Mexico', 'mx', 'not_used'),
(145, 'ماليزيا', '60', 'Malaysia', 'my', 'not_used'),
(146, 'موزمبيق', '258', 'Mozambique', 'mz', 'not_used'),
(147, 'ناميبيا', '264', 'Namibia', 'na', 'not_used'),
(148, 'كاليدونيا الجديدة', '687', 'New Caledonia', 'nc', 'not_used'),
(149, 'النيجر', '227', 'Niger', 'ne', 'not_used'),
(150, 'جزيرة نورفولك', '672', 'Norfolk Island', 'nf', 'not_used'),
(151, 'نيجيريا', '234', 'Nigeria', 'ng', 'not_used'),
(152, 'نيكاراغوا', '505', 'Nicaragua', 'ni', 'not_used'),
(153, 'هولندا', '31', 'Netherlands', 'nl', 'not_used'),
(154, 'النرويج', '47', 'Norway', 'no', 'not_used'),
(155, 'نيبال', '977', 'Nepal', 'np', 'not_used'),
(156, 'ناورو', '674', 'Nauru', 'nr', 'not_used'),
(157, 'نيوي', '683', 'Niue', 'nu', 'not_used'),
(158, 'نيوزيلندا (اوتياروا)', '64', 'New Zealand (Aotearoa)', 'nz', 'not_used'),
(159, 'سلطنة عمان', '968', 'Oman', 'om', 'not_used'),
(160, 'بناما', '507', 'Panama', 'pa', 'not_used'),
(161, 'بيرو', '51', 'Peru', 'pe', 'not_used'),
(162, 'بولينيزيا الفرنسية', '689', 'French Polynesia', 'pf', 'not_used'),
(163, 'بابوا غينيا الجديدة', '675', 'Papua New Guinea', 'pg', 'not_used'),
(164, 'الفلبين', '63', 'Philippines', 'ph', 'not_used'),
(165, 'باكستان', '92', 'Pakistan', 'pk', 'not_used'),
(166, 'بولندا', '48', 'Poland', 'pl', 'not_used'),
(167, 'سانت بيير وميكلون', '508', 'Saint Pierre and Miquelon', 'pm', 'not_used'),
(168, 'بيتكيرن', '64', 'Pitcairn', 'pn', 'not_used'),
(169, 'الأراضي الفلسطينية', '970', 'Palestinian Territory', 'ps', 'not_used'),
(170, 'البرتغال', '351', 'Portugal', 'pt', 'not_used'),
(171, 'بالاو', '680', 'Palau', 'pw', 'not_used'),
(172, 'باراغواي', '595', 'Paraguay', 'py', 'not_used'),
(173, 'دولة قطر', '974', 'Qatar', 'qa', 'not_used'),
(174, 'جمع شمل', '262', 'Reunion', 're', 'not_used'),
(175, 'رومانيا', '40', 'Romania', 'ro', 'not_used'),
(176, 'الاتحاد الروسي', '7', 'Russian Federation', 'ru', 'not_used'),
(177, 'رواندا', '250', 'Rwanda', 'rw', 'not_used'),
(178, 'المملكة العربية السعودية', '966', 'Saudi Arabia', 'sa', 'used'),
(179, 'جزر سليمان', '677', 'Solomon Islands', 'sb', 'not_used'),
(180, 'سيشيل', '248', 'Seychelles', 'sc', 'not_used'),
(181, 'سودان', '249', 'Sudan', 'sd', 'not_used'),
(182, 'السويد', '46', 'Sweden', 'se', 'not_used'),
(183, 'سنغافورة', '65', 'Singapore', 'sg', 'not_used'),
(184, 'سانت هيلانة', '290', 'Saint Helena', 'sh', 'not_used'),
(185, 'سلوفينيا', '386', 'Slovenia', 'si', 'not_used'),
(186, 'سفالبارد وجان مايان', '47', 'Svalbard and Jan Mayen', 'sj', 'not_used'),
(187, 'سلوفاكيا', '421', 'Slovakia', 'sk', 'not_used'),
(188, 'سيرا ليون', '232', 'Sierra Leone', 'sl', 'not_used'),
(189, 'سان مارينو', '378', 'San Marino', 'sm', 'not_used'),
(190, 'السنغال', '221', 'Senegal', 'sn', 'not_used'),
(191, 'الصومال', '252', 'Somalia', 'so', 'not_used'),
(192, 'سورينام', '597', 'Suriname', 'sr', 'not_used'),
(193, 'ساو تومي وبرنسيبي', '239', 'Sao Tome and Principe', 'st', 'not_used'),
(194, 'السلفادور', '503', 'El Salvador', 'sv', 'not_used'),
(195, 'سوريا', '963', 'Syria', 'sy', 'not_used'),
(196, 'سوازيلاند', '268', 'Swaziland', 'sz', 'not_used'),
(197, 'جزر تركس وكايكوس', '1-649', 'Turks and Caicos Islands', 'tc', 'not_used'),
(198, 'تشاد', '235', 'Chad', 'td', 'not_used'),
(199, 'المناطق الجنوبية لفرنسا', '262', 'French Southern Territories', 'tf', 'not_used'),
(200, 'ليذهب', '228', 'Togo', 'tg', 'not_used'),
(201, 'تايلاند', '66', 'Thailand', 'th', 'not_used'),
(202, 'طاجيكستان', '992', 'Tajikistan', 'tj', 'not_used'),
(203, 'توكيلاو', '690', 'Tokelau', 'tk', 'not_used'),
(204, 'تركمانستان', '993', 'Turkmenistan', 'tm', 'not_used'),
(205, 'تونس', '216', 'Tunisia', 'tn', 'not_used'),
(206, 'تونغا', '676', 'Tonga', 'to', 'not_used'),
(207, 'تركيا', '90', 'Turkey', 'tr', 'not_used'),
(208, 'ترينداد وتوباغو', '1-868', 'Trinidad and Tobago', 'tt', 'not_used'),
(209, 'توفالو', '688', 'Tuvalu', 'tv', 'not_used'),
(210, 'تايوان', '886', 'Taiwan', 'tw', 'not_used'),
(211, 'تنزانيا', '255', 'Tanzania', 'tz', 'not_used'),
(212, 'أوكرانيا', '380', 'Ukraine', 'ua', 'not_used'),
(213, 'أوغندا', '256', 'Uganda', 'ug', 'not_used'),
(214, 'أوروغواي', '598', 'Uruguay', 'uy', 'not_used'),
(215, 'أوزبكستان', '998', 'Uzbekistan', 'uz', 'not_used'),
(216, 'سانت فنسنت وجزر غرينادين', '1-784', 'Saint Vincent and the Grenadines', 'vc', 'not_used'),
(217, 'فنزويلا', '58', 'Venezuela', 've', 'not_used'),
(218, 'جزر العذراء البريطانية)', '1-284', 'Virgin Islands (British)', 'vg', 'not_used'),
(219, 'جزر فيرجن (الولايات المتحدة)', '1-340', 'Virgin Islands (U.S.)', 'vi', 'not_used'),
(220, 'فيتنام', '84', 'Viet Nam', 'vn', 'not_used'),
(221, 'فانواتو', '678', 'Vanuatu', 'vu', 'not_used'),
(222, 'واليس وفوتونا', '681', 'Wallis and Futuna', 'wf', 'not_used'),
(223, 'ساموا', '685', 'Samoa', 'ws', 'not_used'),
(224, 'اليمن', '967', 'Yemen', 'ye', 'not_used'),
(225, 'مايوت', '262', 'Mayotte', 'yt', 'not_used'),
(226, 'جنوب أفريقيا', '27', 'South Africa', 'za', 'not_used'),
(227, 'زامبيا', '260', 'Zambia', 'zm', 'not_used'),
(228, 'زائير (سابقة)', '243', 'Zaire (former)', 'zr', 'not_used'),
(229, 'زيمبابوي', '263', 'Zimbabwe', 'zw', 'not_used'),
(230, 'الولايات المتحدة', '1', 'United States of America', 'us', 'not_used');

-- --------------------------------------------------------

--
-- Table structure for table `currencies`
--

CREATE TABLE `currencies` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(50) NOT NULL,
  `name_ar` varchar(255) NOT NULL,
  `status` enum('used','not_used') NOT NULL DEFAULT 'not_used',
  `code` varchar(50) NOT NULL,
  `symbol` varchar(5) DEFAULT NULL,
  `price_in_default_currency` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `default_currency` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `currencies`
--

INSERT INTO `currencies` (`id`, `name`, `name_ar`, `status`, `code`, `symbol`, `price_in_default_currency`, `created_at`, `updated_at`, `default_currency`) VALUES
(105, 'Afghani', 'افغاني', 'not_used', 'AFN', '؋', NULL, NULL, '2024-11-14 04:48:41', 0),
(106, 'Lek', 'ليك ألباني', 'not_used', 'ALL', 'Lek', NULL, NULL, '2024-06-29 08:55:06', 0),
(107, 'Netherlands Antillian Guilder', 'جيلدر الأنتيل الهولندية', 'not_used', 'ANG', 'ƒ', NULL, NULL, '2024-07-18 12:36:59', 0),
(108, 'Argentine Peso', 'بيزو أرجنتيني', 'not_used', 'ARS', '$', NULL, NULL, '2024-06-27 14:29:49', 0),
(109, 'Australian Dollar', 'دولار أسترالي', 'not_used', 'AUD', '$', NULL, NULL, NULL, 0),
(110, 'Aruban Guilder', '\"فلورن أروبي', 'not_used', 'AWG', 'ƒ', NULL, NULL, NULL, 0),
(111, 'Azerbaijanian Manat', 'مانات أذربيجاني', 'not_used', 'AZN', 'ман', NULL, NULL, NULL, 0),
(112, 'Convertible Marks', 'المارك البوسني والهرسكي', 'not_used', 'BAM', 'KM', NULL, NULL, '2024-06-27 14:42:13', 0),
(113, 'Bangladeshi Taka', 'تاكا بنجلاديشي', 'not_used', 'BDT', '৳', NULL, NULL, NULL, 0),
(114, 'Barbados Dollar', 'دولار بربادوسي', 'not_used', 'BBD', '$', NULL, NULL, NULL, 0),
(115, 'Bulgarian Lev', 'ليف بلغاري', 'not_used', 'BGN', 'лв', NULL, NULL, NULL, 0),
(116, 'Bermudian Dollar', 'دولار برمودي', 'not_used', 'BMD', '$', NULL, NULL, NULL, 0),
(117, 'Brunei Dollar', 'دولار بروناي', 'not_used', 'BND', '$', NULL, NULL, NULL, 0),
(118, 'BOV Boliviano Mvdol', 'ربوليفيانو بوليفي', 'not_used', 'BOB', '$b', NULL, NULL, NULL, 0),
(119, 'Brazilian Real', 'ريال برازيلي', 'not_used', 'BRL', 'R$', NULL, NULL, NULL, 0),
(120, 'Bahamian Dollar', 'دولار باهامي', 'not_used', 'BSD', '$', NULL, NULL, NULL, 0),
(121, 'Pula', 'بولا بوتسواني', 'not_used', 'BWP', 'P', NULL, NULL, NULL, 0),
(122, 'Belarussian Ruble', 'روبل بيلاروسي', 'not_used', 'BYR', '₽', NULL, NULL, NULL, 0),
(123, 'Belize Dollar', ' دولار بليزي', 'not_used', 'BZD', 'BZ$', NULL, NULL, NULL, 0),
(124, 'Canadian Dollar', 'دولار كندي', 'not_used', 'CAD', '$', NULL, NULL, NULL, 0),
(125, 'Swiss Franc', 'فرنك سويسري', 'not_used', 'CHF', 'CHF', NULL, NULL, NULL, 0),
(126, 'CLF Chilean Peso Unidades de fomento', 'بيزو تشيلي', 'not_used', 'CLP', '$', NULL, NULL, NULL, 0),
(127, 'Yuan Renminbi', 'يوان صيني', 'not_used', 'CNY', '¥', NULL, NULL, NULL, 0),
(128, 'COU Colombian Peso Unidad de Valor Real', 'بيزو كولومبي', 'not_used', 'COP', '$', NULL, NULL, NULL, 0),
(129, 'Costa Rican Colon', 'كولون كوستاريكي', 'not_used', 'CRC', '₡', NULL, NULL, NULL, 0),
(130, 'CUC Cuban Peso Peso Convertible', 'بيزو كوبي', 'not_used', 'CUP', '₱', NULL, NULL, NULL, 0),
(131, 'Czech Koruna', 'كورونا تشيكية', 'not_used', 'CZK', 'Kč', NULL, NULL, NULL, 0),
(132, 'Danish Krone', 'كرونة دنماركية', 'not_used', 'DKK', 'kr', NULL, NULL, NULL, 0),
(133, 'Dominican Peso', 'بيزو دومنيكاني', 'not_used', 'DOP', 'RD$', NULL, NULL, NULL, 0),
(134, 'Egyptian Pound', 'جنيه مصري', 'used', 'EGP', '£', NULL, NULL, '2025-01-13 09:34:06', 0),
(135, 'Euro', 'يورو', 'not_used', 'EUR', '€', NULL, NULL, NULL, 0),
(136, 'Fiji Dollar', 'دولار فيجي', 'not_used', 'FJD', '$', NULL, NULL, NULL, 0),
(137, 'Falkland Islands Pound', 'جنيه جزر فوكلاند', 'not_used', 'FKP', '£', NULL, NULL, NULL, 0),
(138, 'Pound Sterling', 'جنيه إسترليني', 'not_used', 'GBP', '£', NULL, NULL, NULL, 0),
(139, 'Gibraltar Pound', 'جنيه جبل طارق', 'not_used', 'GIP', '£', NULL, NULL, NULL, 0),
(140, 'Quetzal', 'كوتزال جواتيمالا', 'not_used', 'GTQ', 'Q', NULL, NULL, NULL, 0),
(141, 'Guyana Dollar', ' دولار غيانا', 'not_used', 'GYD', '$', NULL, NULL, NULL, 0),
(142, 'Hong Kong Dollar', 'دولار هونغ كونغ', 'not_used', 'HKD', '$', NULL, NULL, NULL, 0),
(143, 'Lempira', 'ليمبيرا هندوراس', 'not_used', 'HNL', 'L', NULL, NULL, NULL, 0),
(144, 'Croatian Kuna', 'كونا كرواتي', 'not_used', 'HRK', 'kn', NULL, NULL, NULL, 0),
(145, 'Forint', 'فورينت مجري', 'not_used', 'HUF', 'Ft', NULL, NULL, NULL, 0),
(146, 'Rupiah', 'روبية إندونيسية', 'not_used', 'IDR', 'Rp', NULL, NULL, NULL, 0),
(147, 'New Israeli Sheqel', 'شيكل', 'not_used', 'ILS', '₪', NULL, NULL, NULL, 0),
(148, 'Iranian Rial', 'ريال إيراني', 'not_used', 'IRR', '﷼', NULL, NULL, NULL, 0),
(149, 'Iceland Krona', 'كرونا أيسلندية', 'not_used', 'ISK', 'kr', NULL, NULL, NULL, 0),
(150, 'Jamaican Dollar', 'دولار جامايكي', 'not_used', 'JMD', 'J$', NULL, NULL, NULL, 0),
(151, 'Yen', 'ين ياباني', 'not_used', 'JPY', '¥', NULL, NULL, NULL, 0),
(152, 'Som', 'سوم قيرغيزستاني', 'not_used', 'KGS', 'лв', NULL, NULL, NULL, 0),
(153, 'Riel', 'رييل كمبودي', 'not_used', 'KHR', '៛', NULL, NULL, NULL, 0),
(154, 'North Korean Won', 'وون كوريا الشمالية', 'not_used', 'KPW', '₩', NULL, NULL, NULL, 0),
(155, 'Won', 'وون كوريا الجنوبية', 'not_used', 'KRW', '₩', NULL, NULL, NULL, 0),
(156, 'Cayman Islands Dollar', 'دولار جزر كايمان', 'not_used', 'KYD', '$', NULL, NULL, NULL, 0),
(157, 'Tenge', 'تينغ كازاخستاني', 'not_used', 'KZT', 'лв', NULL, NULL, NULL, 0),
(158, 'Kip', ' كيب لاوسي', 'not_used', 'LAK', '₭', NULL, NULL, NULL, 0),
(159, 'Lebanese Pound', 'ليرة لبنانية', 'not_used', 'LBP', '£', NULL, NULL, NULL, 0),
(160, 'Sri Lanka Rupee', 'روبية سريلانكية', 'not_used', 'LKR', '₨', NULL, NULL, NULL, 0),
(161, 'Liberian Dollar', 'دولار ليبيري', 'not_used', 'LRD', '$', NULL, NULL, NULL, 0),
(162, 'Lithuanian Litas', 'يتا ليتوانية', 'not_used', 'LTL', 'Lt', NULL, NULL, NULL, 0),
(163, 'Latvian Lats', ' لاتس لاتفيا', 'not_used', 'LVL', 'Ls', NULL, NULL, NULL, 0),
(164, 'Denar', 'دينار مقدوني', 'not_used', 'MKD', 'ден', NULL, NULL, NULL, 0),
(165, 'Tugrik', 'توغروغ منغولي', 'not_used', 'MNT', '₮', NULL, NULL, NULL, 0),
(166, 'Mauritius Rupee', 'روبية موريشيوسية', 'not_used', 'MUR', '₨', NULL, NULL, NULL, 0),
(167, 'MXV Mexican Peso Mexican Unidad de Inversion (UDI]', 'بيزو مكسيكي', 'not_used', 'MXN', '$', NULL, NULL, NULL, 0),
(168, 'Malaysian Ringgit', 'رينغيت ماليزي', 'not_used', 'MYR', 'RM', NULL, NULL, NULL, 0),
(169, 'Metical', 'متكال موزمبيقي', 'not_used', 'MZN', 'MT', NULL, NULL, NULL, 0),
(170, 'Naira', 'نايرا نيجيري', 'not_used', 'NGN', '₦', NULL, NULL, NULL, 0),
(171, 'Cordoba Oro', ' كوردوبة نيكاراغوا', 'not_used', 'NIO', 'C$', NULL, NULL, NULL, 0),
(172, 'Norwegian Krone', 'كرونة نرويجية', 'not_used', 'NOK', 'kr', NULL, NULL, NULL, 0),
(173, 'Nepalese Rupee', ' روبية نيبالية', 'not_used', 'NPR', '₨', NULL, NULL, NULL, 0),
(174, 'New Zealand Dollar', 'دولار نيوزيلندي', 'not_used', 'NZD', '$', NULL, NULL, NULL, 0),
(175, 'Rial Omani', ' ريال عماني', 'not_used', 'OMR', '﷼', NULL, NULL, NULL, 0),
(176, 'USD Balboa US Dollar', 'بالبوا بنمي', 'not_used', 'PAB', 'B/.', NULL, NULL, NULL, 0),
(177, 'Nuevo Sol', 'سول بيروفي', 'not_used', 'PEN', 'S/.', NULL, NULL, NULL, 0),
(178, 'Philippine Peso', ' بيزو فلبيني', 'not_used', 'PHP', 'Php', NULL, NULL, NULL, 0),
(179, 'Pakistan Rupee', 'روبية باكستانية', 'not_used', 'PKR', '₨', NULL, NULL, NULL, 0),
(180, 'Zloty', 'زلوتي بولندي', 'not_used', 'PLN', 'zł', NULL, NULL, NULL, 0),
(181, 'Guarani', 'جواراني باراغواي', 'not_used', 'PYG', 'Gs', NULL, NULL, NULL, 0),
(182, 'Qatari Rial', 'ريال قطري', 'not_used', 'QAR', '﷼', NULL, NULL, '2024-06-29 09:02:03', 0),
(183, 'New Leu', 'ليو روماني', 'not_used', 'RON', 'lei', NULL, NULL, '2024-06-29 08:01:08', 0),
(184, 'Serbian Dinar', 'دينار صربي', 'not_used', 'RSD', 'Дин.', NULL, NULL, NULL, 0),
(185, 'Russian Ruble', 'روبل روسي', 'not_used', 'RUB', 'руб', NULL, NULL, NULL, 0),
(186, 'Saudi Riyal', 'ريال سعودي', 'used', 'SAR', '﷼', '3.47', NULL, '2025-01-13 09:34:06', 1),
(187, 'Solomon Islands Dollar', 'دولار جزر سليمان', 'not_used', 'SBD', '$', NULL, NULL, NULL, 0),
(188, 'Seychelles Rupee', 'روبية سيشيلية', 'not_used', 'SCR', '₨', NULL, NULL, NULL, 0),
(189, 'Swedish Krona', ' كرونا سويدية', 'not_used', 'SEK', 'kr', NULL, NULL, NULL, 0),
(190, 'Singapore Dollar', 'دولار سنغافوري', 'not_used', 'SGD', '$', NULL, NULL, NULL, 0),
(191, 'Saint Helena Pound', 'جنيه سانت هيليني', 'not_used', 'SHP', '£', NULL, NULL, NULL, 0),
(192, 'Somali Shilling', ' شلن صومالي', 'not_used', 'SOS', 'S', NULL, NULL, NULL, 0),
(193, 'Surinam Dollar', 'دولار سورينامي', 'not_used', 'SRD', '$', NULL, NULL, NULL, 0),
(194, 'USD El Salvador Colon US Dollar', 'كولون إل سلفادوري', 'not_used', 'SVC', '$', NULL, NULL, NULL, 0),
(195, 'Syrian Pound', 'ليرة سورية', 'not_used', 'SYP', '£', NULL, NULL, NULL, 0),
(196, 'Baht', 'باهت تايلاندي', 'not_used', 'THB', '฿', NULL, NULL, NULL, 0),
(197, 'Turkish Lira', 'ليرة تركية', 'not_used', 'TRY', 'TL', '12', NULL, NULL, 0),
(198, 'Trinidad and Tobago Dollar', 'دولار ترينيداد وتوباغو', 'not_used', 'TTD', 'TT$', NULL, NULL, NULL, 0),
(199, 'New Taiwan Dollar', 'دولار تايواني', 'not_used', 'TWD', 'NT$', NULL, NULL, NULL, 0),
(200, 'Hryvnia', 'هريفنيا أوكرانية', 'not_used', 'UAH', '₴', NULL, NULL, NULL, 0),
(201, 'US Dollar', 'دولار أمريكي', 'not_used', 'USD', '$', NULL, NULL, NULL, 0),
(202, 'UYI Uruguay Peso en Unidades Indexadas', 'بيزو أوروغواي', 'not_used', 'UYU', '$U', NULL, NULL, NULL, 0),
(203, 'Uzbekistan Sum', 'سوم أوزبكستاني', 'not_used', 'UZS', 'лв', NULL, NULL, NULL, 0),
(204, 'Bolivar Fuerte', 'بوليفار فنزويلي', 'not_used', 'VEF', 'Bs', NULL, NULL, NULL, 0),
(205, 'Dong', ' دونج فيتنامي', 'not_used', 'VND', '₫', NULL, NULL, NULL, 0),
(206, 'East Caribbean Dollar', 'دولار شرق الكاريبي', 'not_used', 'XCD', '$', NULL, NULL, NULL, 0),
(207, 'Yemeni Rial', 'ريال يمني', 'not_used', 'YER', '﷼', NULL, NULL, NULL, 0),
(208, 'Rand', 'راند جنوب إفريقيا', 'not_used', 'ZAR', 'R', NULL, NULL, NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `designs`
--

CREATE TABLE `designs` (
  `id` tinyint(3) UNSIGNED NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `page_name` varchar(255) DEFAULT NULL,
  `image` varchar(255) NOT NULL,
  `image_en` varchar(255) DEFAULT NULL,
  `main_banar` tinyint(1) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `designs`
--

INSERT INTO `designs` (`id`, `title`, `page_name`, `image`, `image_en`, `main_banar`, `description`, `updated_at`, `created_at`) VALUES
(1, 'banner1', 'home', 'uploads/designs/9I8ZEEojZKRuV05tQ5McIWGIDUaHL93ZoWK3PcMX.png', 'designs/VBXoTDwWi9xJCmhWM7pJjlLQWtDtNGyYNN7TJtaC.png', NULL, 'ggggggggg', '2025-01-12 09:47:03', '2024-01-20 07:43:41'),
(4, 'بنر رئيسي', NULL, 'uploads/designs/na6WoOICply0jPO0tZmcFn1WXyYPWfSnFplnDgsm.jpg', 'uploads/designs/cy3014M4QgRcB6AVbyGhQEx6PUzEkPHFg5jcwNMJ.png', 1, 'يبليب', '2024-06-29 12:20:39', '2024-01-28 12:33:01'),
(5, 'banner2', 'home', 'uploads/designs/tr1EJh1oRih93bNsUXSgAaREmoMzrlrwivfyn05B.png', 'designs/8IeyhSMPVyqPTtA8DH6NEZ5eOPdwRfSIMFqrVuvK.png', NULL, NULL, '2024-11-17 20:06:42', '2024-01-28 12:34:36'),
(6, 'banner3', 'home', 'uploads/designs/BEAOKy6UMaxF9ITVI7UzuQTgcXaQDcCRZVsIxFbO.png', 'designs/LAz8SkMMsQZ1bbkCYcqevDjqTTEpxVmpF9sHyhoj.png', NULL, NULL, '2024-11-17 20:07:49', '2024-01-28 12:35:10'),
(12, 'banner4', 'home', 'uploads/designs/BVSXy1ebd3NlfCqNYjf1IEq0EqbVMPQsMe60vUbm.png', 'designs/1iXLovTeat4LpBcOQMubWentIAaeCD6SVSMUcMoC.png', NULL, 'test', '2024-11-17 20:08:05', '2024-06-24 11:35:44'),
(16, 'banner5', 'home', 'uploads/designs/GSeIAxcbwEwUCHV2gM98QG5piK8VasCF0ASmv6pP.png', 'designs/mu4sVeAMqswGCej4HBwwmlfKAJcoKch31wZCArND.png', NULL, NULL, '2024-11-17 20:08:31', '2024-06-27 09:34:10'),
(17, 'discount1', 'home', 'uploads/designs/sPLBeRV54BAWMCjcRyDcCzvekQyXpyS8mBRBolCQ.png', 'designs/G3nAeeJRjSB2n5uh0NCByZ40t80kyeNJo2IErFo9.png', NULL, NULL, '2024-11-17 20:08:55', '2024-06-29 13:03:20'),
(18, 'discount2', 'home', 'uploads/designs/aNXrxKQNVTGhk6pBlbjfUqkbD3PGAP2ehu9AUTfX.png', 'designs/kVF3Eq8flii83sNzv6Ev7rOQCXYgXEnNCufuJxgD.png', NULL, NULL, '2024-11-17 20:09:09', '2024-06-29 13:23:12'),
(19, 'offer_page_1', 'offers-page', 'uploads/designs/jMaJvq9JDVqnzJvr9LX2yHNnM0c8y4v3Hm8nPmDA.png', 'designs/zhSXglhAsq3zMWlmtmwuAl4XxFtq4R03dIpoRNeg.png', NULL, NULL, '2024-11-17 20:09:30', '2024-06-30 09:23:42'),
(20, 'offer_page_2', 'offers-page', 'uploads/designs/FBvbPJJvd9LupdS9m1sFSos5xa7i17whiEctdNvH.png', 'designs/DGxlixUVbURB0EolBKvt2Tv5yU8SZKzqhQgSShDI.png', NULL, NULL, '2024-11-19 15:15:53', '2024-06-30 09:24:06');

-- --------------------------------------------------------

--
-- Table structure for table `discount_codes`
--

CREATE TABLE `discount_codes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `code` varchar(255) NOT NULL,
  `price` decimal(8,2) NOT NULL,
  `discount_type` enum('percentage','price') NOT NULL DEFAULT 'price',
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `number_of_used` smallint(6) NOT NULL,
  `product_ids` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `discount_codes`
--

INSERT INTO `discount_codes` (`id`, `name`, `code`, `price`, `discount_type`, `status`, `number_of_used`, `product_ids`, `created_at`, `updated_at`) VALUES
(22, 'TEST', 'MG', 10.00, 'percentage', 'active', 73, NULL, '2024-10-17 10:18:36', '2025-02-09 07:53:17');

-- --------------------------------------------------------

--
-- Table structure for table `discount_code_product`
--

CREATE TABLE `discount_code_product` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `discount_code_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `forget_passwords`
--

CREATE TABLE `forget_passwords` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` char(36) NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `guests`
--

CREATE TABLE `guests` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `cookie_id` varchar(255) DEFAULT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `family_name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone_number` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `guests`
--

INSERT INTO `guests` (`id`, `cookie_id`, `first_name`, `family_name`, `email`, `phone_number`, `address`, `created_at`, `updated_at`) VALUES
(1, NULL, NULL, NULL, NULL, NULL, NULL, '2025-02-09 10:17:27', '2025-02-09 10:17:27');

-- --------------------------------------------------------

--
-- Table structure for table `header_banners`
--

CREATE TABLE `header_banners` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `header_image` varchar(255) DEFAULT NULL,
  `header_image_en` varchar(255) DEFAULT NULL,
  `image_link` varchar(1000) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `header_banners`
--

INSERT INTO `header_banners` (`id`, `header_image`, `header_image_en`, `image_link`) VALUES
(51, 'uploads/header_images/9ZZt1tbi5Zw8Gl6CGAIiBvmKpx28RgFop5fTAQlE.jpg', 'uploads/header_images/uGdIFm2NesYcCyEfv9d0LiqXIMN5pLB29Ec5pGFb.png', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `header_texts`
--

CREATE TABLE `header_texts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `header_texts`
--

INSERT INTO `header_texts` (`id`, `title`, `description`, `created_at`, `updated_at`) VALUES
(2, 'هذا النص هو مثال لنص يمكن أن يستبدل في نفس المساحة، لقد تم توليد هذا النص من مولد النص العربى، حيث يمكنك أن تولد مثل هذا النص أو العديد من النصوص الأخرى إضافة إلى زيادة عدد الحروف التى يولدها التطبيق.', NULL, '2024-01-28 11:13:17', '2024-06-30 09:58:16'),
(3, 'هذا النص هو مثال لنص يمكن أن يستبدل في نفس المساحة، لقد تم توليد هذا النص من مولد النص العربى، حيث يمكنك أن تولد مثل هذا النص أو العديد من النصوص الأخرى إضافة إلى زيادة عدد الحروف التى يولدها التطبيق.', NULL, '2024-01-28 11:14:24', '2024-06-30 09:58:29');

-- --------------------------------------------------------

--
-- Table structure for table `main_categories`
--

CREATE TABLE `main_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `parent_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `name_en` varchar(255) DEFAULT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `main_categories`
--

INSERT INTO `main_categories` (`id`, `parent_id`, `name`, `name_en`, `slug`, `description`, `image`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, NULL, 'منظفات الأطباق', 'Dish Cleaners', 'منظفات-الأطباق', NULL, 'uploads/main_categories/We4Wgtq8iseePyiOBTLohdFFCum7vv4VcsExDKqP.png', '2024-11-12 13:02:52', '2024-11-19 14:56:45', NULL),
(2, NULL, 'منظفات الأرضيات', 'Floor Cleaners', 'منظفات-الأرضيات', NULL, 'uploads/main_categories/eQuyyjSagjfAJ6cGs6ShyN6I7T7THSqYAyTRKWJz.png', '2024-11-12 13:03:21', '2024-11-19 14:56:29', NULL),
(3, NULL, 'منظفات الملابس', 'Laundry Detergents', 'منظفات-الملابس', NULL, 'uploads/main_categories/RiBYjENKZ9pz95Vx2oxnEs5z4oPFNh42NGU2rITu.png', '2024-11-12 13:03:51', '2024-11-19 14:56:09', NULL),
(4, NULL, 'معطرات الهواء', 'Air Fresheners', 'معطرات-الهواء', NULL, 'uploads/main_categories/fNuh6DuNHnb8haGUIjHvIhdbYnnMLT132L2IpJAA.png', '2024-11-12 13:04:17', '2024-11-19 14:55:51', NULL),
(5, NULL, 'منتجات العناية الشخصية', 'Personal Care Products', 'منتجات-العناية-الشخصية', NULL, 'uploads/main_categories/vL8kxRAe9YWvXAXU1Ary4vky0FTVSKa0CIQDF61l.png', '2024-11-12 13:04:44', '2024-11-19 14:55:39', NULL),
(6, NULL, 'منظفات الحمامات', 'Bathroom Cleaners', 'منظفات-الحمامات', NULL, 'uploads/main_categories/KCoTjnQTBYzJf4TwF3hdEmoZnaR02tLiB0AZryea.png', '2024-11-12 13:05:06', '2024-11-19 14:55:23', NULL),
(7, NULL, 'مطهرات', 'Disinfectants', 'مطهرات', NULL, 'uploads/main_categories/82FatmBVXlbSaLx7BjkCUgpIhD6xRmBix7KwcnI2.png', '2024-11-12 13:05:27', '2024-11-19 14:55:11', NULL),
(8, NULL, 'ملمعات الأثاث', 'Furniture Polish', 'ملمعات-الأثاث', NULL, 'uploads/main_categories/ShjjixGEioEI2PqCJOspPEWpldyX88AVdaHJ0mgA.jpg', '2024-11-12 13:05:50', '2025-03-01 10:51:04', NULL),
(9, 8, 'test', 'test', 'test', NULL, NULL, '2024-11-21 10:14:50', '2024-11-21 10:14:50', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2024_01_07_235501_create_settings_table', 1),
(6, '2024_01_07_235757_create_main_categories_table', 1),
(7, '2024_01_08_000128_create_first_sub_categories_table', 1),
(8, '2024_01_08_000351_create_sec_sub_categories_table', 1),
(9, '2024_01_08_000442_create_products_table', 1),
(10, '2024_01_08_001943_create_product_images_table', 1),
(12, '2024_01_08_120557_create_main_category_settings_table', 2),
(13, '2024_01_08_121246_create_main_category_main_category_setting_table', 3),
(14, '2024_01_09_125214_add_quantity_to_products_table', 4),
(15, '2024_01_13_113614_create_sub_settings_table', 5),
(16, '2024_01_13_113828_add_foreign_key_to_main_category_settings', 6),
(17, '2024_01_13_130146_add_foreign_key_to_sub_settings_settings', 7),
(18, '2024_01_15_041939_create_product_sub_setting_table', 8),
(19, '2024_01_16_161016_create_admins_table', 9),
(20, '2024_01_21_193647_add_foreign_to_companies_table', 10),
(21, '2024_01_22_150121_create_rules_table', 11),
(22, '2024_01_22_150435_create_rule_abilities_table', 11),
(23, '2024_01_22_150622_create_admin_rule_table', 11),
(24, '2024_01_23_115251_add_super_admin_column_to_admins_table', 12),
(25, '2024_01_24_122211_add_phone_number_column_to_users_table', 13),
(26, '2024_01_25_144826_create_colors_table', 14),
(27, '2024_01_25_144941_create_table_color_product_table', 14),
(28, '2024_01_28_131859_create_header_texts_table', 15),
(29, '2024_01_28_155020_add_is_special_to_products_table', 16),
(30, '2024_01_30_115849_add_column_slug_to_products_table', 17),
(31, '2024_01_30_140625_create_product_user_table', 18),
(32, '2024_01_30_165414_create_wishlist_products_user_table', 19),
(33, '2014_10_12_200000_add_two_factor_columns_to_users_table', 20),
(34, '2024_02_01_111058_create_carts_table', 20),
(35, '2023_11_01_200404_create_orders_table', 21),
(36, '2023_11_01_202540_create_order_items_table', 21),
(37, '2023_11_01_210543_create_order_addresses_table', 21),
(38, '2024_02_03_113518_add_sec_name_and_family_name_to_users_table', 22),
(39, '2024_02_03_115122_create_user_addresses_table', 23),
(40, '2021_05_04_234350_create_countries_table', 24),
(41, '2021_05_04_234415_create_cities_table', 24),
(42, '2020_06_08_112452_create_currencies_table', 25),
(43, '2024_02_06_115300_create_product_availabilities_table', 26),
(44, '2024_02_06_130348_add_column_product_avaibaility_id_to_table_products', 27),
(45, '2024_02_06_141331_add_column_shipping_price_to_settings_price', 28),
(46, '2024_02_06_170437_create_shipping_types_table', 29),
(47, '2024_02_07_154758_create_shipping_types_and_price_table', 29),
(48, '2024_02_08_134404_create_product_features_table', 30),
(49, '2024_02_10_134007_create_return_products_table', 31),
(50, '2024_02_10_144749_add_column_arrangement_to_order_statuses_table', 32),
(51, '2024_02_11_134437_add_default_currency_to_currencies_table', 33),
(52, '2024_02_11_151319_add_default_currency_to_users_table', 34),
(53, '2024_02_12_135106_create_comments_table', 35),
(54, '2024_02_13_105551_create_notifications_table', 36),
(55, '2024_02_13_130404_create_send_news_to_users_table', 37),
(56, '2024_02_14_155846_create_discount_codes_table', 38),
(57, '2024_02_14_161802_create_discount_codes_table', 39),
(58, '2024_02_15_182446_create_user_discount_codes_table', 40),
(59, '2024_02_15_200507_create_cookie_discount_ids_table', 40),
(60, '2024_02_17_132804_create_contact_us_table', 41),
(61, '2024_03_02_151600_create_guests_table', 42),
(62, '2024_03_02_175653_create_wishlist_products_guest_table', 43),
(63, '2024_03_03_122052_create_product_sub_category_table', 44),
(64, '2024_06_30_131230_create_advertisements_table', 45),
(65, '2024_06_30_144148_create_pages_table', 46),
(66, '2024_07_02_122604_create_shipping_companies_table', 47),
(67, '2024_07_02_122951_create_shipping_locations_table', 47),
(68, '2024_07_07_130212_create_common_questions_table', 48),
(69, '2024_07_07_140522_create_representatives_orders_table', 49),
(70, '2024_07_07_145246_create_bulk_orders_table', 50),
(71, '2024_07_15_110213_create_header_banners_table', 51),
(72, '2024_07_17_124728_create_choices_table', 52),
(73, '2024_07_17_130413_create_category_choices_table', 53),
(74, '2024_07_20_132905_create_choices_products_table', 54),
(75, '2024_08_01_123909_create_store_featuers_table', 55),
(76, '2024_08_03_112751_create_discount_code_product_table', 56),
(77, '2024_08_03_134704_add_discounted_price_to_carts_table', 57),
(78, '2024_08_13_105347_create_user_tokens_table', 58),
(79, '2025_03_29_125641_create_order_choices_table', 59),
(80, '2025_04_05_100957_create_order_item_choices_table', 60);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` char(36) NOT NULL,
  `type` varchar(255) NOT NULL,
  `notifiable_type` varchar(255) NOT NULL,
  `notifiable_id` bigint(20) UNSIGNED NOT NULL,
  `data` text NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `type`, `notifiable_type`, `notifiable_id`, `data`, `read_at`, `created_at`, `updated_at`) VALUES
('0dbe9648-5598-4aac-a7a9-4dd65be697e1', 'App\\Notifications\\OrderCreatedNotification', 'App\\Models\\Admin', 11, '{\"title\":\"\\u064a\\u0648\\u062c\\u062f \\u0637\\u0644\\u0628 \\u062c\\u062f\\u064a\\u062f\",\"body\":\"\\u062a\\u0645\\u062a \\u0627\\u0636\\u0627\\u0641\\u0629 \\u0627\\u0644\\u0637\\u0644\\u0628 \\u0644\\u0642\\u0627\\u0626\\u0645\\u0629 \\u0627\\u0644\\u0637\\u0644\\u0628\\u0627\\u062a\",\"url\":\"http:\\/\\/127.0.0.1:8000\\/admin\\/dashboard\\/orders\\/61\",\"order_id\":61}', '2025-09-27 07:36:25', '2025-05-28 12:09:07', '2025-09-27 07:36:25'),
('22028304-e919-4a35-8269-e22b3b6ec61c', 'App\\Notifications\\OrderCreatedNotification', 'App\\Models\\Admin', 11, '{\"title\":\"\\u064a\\u0648\\u062c\\u062f \\u0637\\u0644\\u0628 \\u062c\\u062f\\u064a\\u062f\",\"body\":\"\\u062a\\u0645\\u062a \\u0627\\u0636\\u0627\\u0641\\u0629 \\u0627\\u0644\\u0637\\u0644\\u0628 \\u0644\\u0642\\u0627\\u0626\\u0645\\u0629 \\u0627\\u0644\\u0637\\u0644\\u0628\\u0627\\u062a\",\"url\":\"http:\\/\\/127.0.0.1:8000\\/admin\\/dashboard\\/orders\\/60\",\"order_id\":60}', NULL, '2025-05-28 12:06:09', '2025-05-28 12:06:09'),
('24825dfc-2c33-4b7e-8992-e5f97ec4167d', 'App\\Notifications\\OrderCreatedNotification', 'App\\Models\\Admin', 15, '{\"title\":\"\\u064a\\u0648\\u062c\\u062f \\u0637\\u0644\\u0628 \\u062c\\u062f\\u064a\\u062f\",\"body\":\"\\u062a\\u0645\\u062a \\u0627\\u0636\\u0627\\u0641\\u0629 \\u0627\\u0644\\u0637\\u0644\\u0628 \\u0644\\u0642\\u0627\\u0626\\u0645\\u0629 \\u0627\\u0644\\u0637\\u0644\\u0628\\u0627\\u062a\",\"url\":\"http:\\/\\/127.0.0.1:8000\\/admin\\/dashboard\\/orders\\/59\",\"order_id\":59}', NULL, '2025-05-28 12:03:28', '2025-05-28 12:03:28'),
('4a1eeecb-f5b0-4183-8054-ba6207b0abd6', 'App\\Notifications\\ContactFormSubmitted', 'App\\Models\\Admin', 14, '{\"title\":\"\\u064a\\u0648\\u062c\\u062f \\u0631\\u0633\\u0627\\u0644\\u0629 \\u062c\\u062f\\u064a\\u062f\\u0647\",\"body\":\"\\u062a\\u0645\\u062a \\u0627\\u0636\\u0627\\u0641\\u0629 \\u0627\\u0644\\u0631\\u0633\\u0627\\u0644\\u0647 \\u0644\\u0642\\u0627\\u0626\\u0645\\u0629 \\u0627\\u0644\\u0631\\u0633\\u0627\\u0626\\u0644\",\"url\":\"http:\\/\\/127.0.0.1:8000\\/admin\\/contact_us_view\\/29\\/show\",\"message_id\":29}', NULL, '2025-03-26 08:46:54', '2025-03-26 08:46:54'),
('4d0d36cb-e6b2-4056-a9c3-bc3a98bc2802', 'App\\Notifications\\OrderCreatedNotification', 'App\\Models\\Admin', 11, '{\"title\":\"\\u064a\\u0648\\u062c\\u062f \\u0637\\u0644\\u0628 \\u062c\\u062f\\u064a\\u062f\",\"body\":\"\\u062a\\u0645\\u062a \\u0627\\u0636\\u0627\\u0641\\u0629 \\u0627\\u0644\\u0637\\u0644\\u0628 \\u0644\\u0642\\u0627\\u0626\\u0645\\u0629 \\u0627\\u0644\\u0637\\u0644\\u0628\\u0627\\u062a\",\"url\":\"http:\\/\\/127.0.0.1:8000\\/admin\\/dashboard\\/orders\\/58\",\"order_id\":58}', NULL, '2025-05-28 10:31:21', '2025-05-28 10:31:21'),
('66877c3b-6c40-471a-90f3-cbd79e83d4d8', 'App\\Notifications\\OrderCreatedNotification', 'App\\Models\\Admin', 15, '{\"title\":\"\\u064a\\u0648\\u062c\\u062f \\u0637\\u0644\\u0628 \\u062c\\u062f\\u064a\\u062f\",\"body\":\"\\u062a\\u0645\\u062a \\u0627\\u0636\\u0627\\u0641\\u0629 \\u0627\\u0644\\u0637\\u0644\\u0628 \\u0644\\u0642\\u0627\\u0626\\u0645\\u0629 \\u0627\\u0644\\u0637\\u0644\\u0628\\u0627\\u062a\",\"url\":\"http:\\/\\/127.0.0.1:8000\\/admin\\/dashboard\\/orders\\/58\",\"order_id\":58}', NULL, '2025-05-28 10:31:21', '2025-05-28 10:31:21'),
('704b08ae-f67d-430f-b7fb-5ff335d5c2f3', 'App\\Notifications\\OrderCreatedNotification', 'App\\Models\\Admin', 11, '{\"title\":\"\\u064a\\u0648\\u062c\\u062f \\u0637\\u0644\\u0628 \\u062c\\u062f\\u064a\\u062f\",\"body\":\"\\u062a\\u0645\\u062a \\u0627\\u0636\\u0627\\u0641\\u0629 \\u0627\\u0644\\u0637\\u0644\\u0628 \\u0644\\u0642\\u0627\\u0626\\u0645\\u0629 \\u0627\\u0644\\u0637\\u0644\\u0628\\u0627\\u062a\",\"url\":\"http:\\/\\/127.0.0.1:8000\\/admin\\/orders\\/57\",\"order_id\":57}', NULL, '2025-04-05 08:11:31', '2025-04-05 08:11:31'),
('7fc9d65d-31ba-4459-9daf-427cddcb0c77', 'App\\Notifications\\OrderCreatedNotification', 'App\\Models\\Admin', 11, '{\"title\":\"\\u064a\\u0648\\u062c\\u062f \\u0637\\u0644\\u0628 \\u062c\\u062f\\u064a\\u062f\",\"body\":\"\\u062a\\u0645\\u062a \\u0627\\u0636\\u0627\\u0641\\u0629 \\u0627\\u0644\\u0637\\u0644\\u0628 \\u0644\\u0642\\u0627\\u0626\\u0645\\u0629 \\u0627\\u0644\\u0637\\u0644\\u0628\\u0627\\u062a\",\"url\":\"http:\\/\\/127.0.0.1:8000\\/admin\\/dashboard\\/orders\\/59\",\"order_id\":59}', '2025-09-27 07:36:32', '2025-05-28 12:03:28', '2025-09-27 07:36:32'),
('943337da-5ef1-40b0-9910-833c0dac50bf', 'App\\Notifications\\ContactFormSubmitted', 'App\\Models\\Admin', 11, '{\"title\":\"\\u064a\\u0648\\u062c\\u062f \\u0631\\u0633\\u0627\\u0644\\u0629 \\u062c\\u062f\\u064a\\u062f\\u0647\",\"body\":\"\\u062a\\u0645\\u062a \\u0627\\u0636\\u0627\\u0641\\u0629 \\u0627\\u0644\\u0631\\u0633\\u0627\\u0644\\u0647 \\u0644\\u0642\\u0627\\u0626\\u0645\\u0629 \\u0627\\u0644\\u0631\\u0633\\u0627\\u0626\\u0644\",\"url\":\"http:\\/\\/127.0.0.1:8000\\/admin\\/contact_us_view\\/29\\/show\",\"message_id\":29}', '2025-03-26 09:03:32', '2025-03-26 08:46:54', '2025-03-26 09:03:32'),
('d8c82076-3bf7-42ff-bf66-c8a83ef5a01f', 'App\\Notifications\\OrderCreatedNotification', 'App\\Models\\Admin', 15, '{\"title\":\"\\u064a\\u0648\\u062c\\u062f \\u0637\\u0644\\u0628 \\u062c\\u062f\\u064a\\u062f\",\"body\":\"\\u062a\\u0645\\u062a \\u0627\\u0636\\u0627\\u0641\\u0629 \\u0627\\u0644\\u0637\\u0644\\u0628 \\u0644\\u0642\\u0627\\u0626\\u0645\\u0629 \\u0627\\u0644\\u0637\\u0644\\u0628\\u0627\\u062a\",\"url\":\"http:\\/\\/127.0.0.1:8000\\/admin\\/dashboard\\/orders\\/61\",\"order_id\":61}', NULL, '2025-05-28 12:09:07', '2025-05-28 12:09:07'),
('deb48778-137d-4653-b531-394820377873', 'App\\Notifications\\OrderCreatedNotification', 'App\\Models\\Admin', 15, '{\"title\":\"\\u064a\\u0648\\u062c\\u062f \\u0637\\u0644\\u0628 \\u062c\\u062f\\u064a\\u062f\",\"body\":\"\\u062a\\u0645\\u062a \\u0627\\u0636\\u0627\\u0641\\u0629 \\u0627\\u0644\\u0637\\u0644\\u0628 \\u0644\\u0642\\u0627\\u0626\\u0645\\u0629 \\u0627\\u0644\\u0637\\u0644\\u0628\\u0627\\u062a\",\"url\":\"http:\\/\\/127.0.0.1:8000\\/admin\\/dashboard\\/orders\\/60\",\"order_id\":60}', NULL, '2025-05-28 12:06:09', '2025-05-28 12:06:09'),
('ece5174a-acb1-400b-ad3b-89363e20d914', 'App\\Notifications\\OrderCreatedNotification', 'App\\Models\\Admin', 15, '{\"title\":\"\\u064a\\u0648\\u062c\\u062f \\u0637\\u0644\\u0628 \\u062c\\u062f\\u064a\\u062f\",\"body\":\"\\u062a\\u0645\\u062a \\u0627\\u0636\\u0627\\u0641\\u0629 \\u0627\\u0644\\u0637\\u0644\\u0628 \\u0644\\u0642\\u0627\\u0626\\u0645\\u0629 \\u0627\\u0644\\u0637\\u0644\\u0628\\u0627\\u062a\",\"url\":\"http:\\/\\/127.0.0.1:8000\\/admin\\/orders\\/57\",\"order_id\":57}', NULL, '2025-04-05 08:11:31', '2025-04-05 08:11:31');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `guest_id` bigint(20) UNSIGNED DEFAULT NULL,
  `cookie_id` varchar(255) DEFAULT NULL,
  `number` varchar(255) NOT NULL,
  `order_status_id` smallint(5) UNSIGNED DEFAULT NULL,
  `payment_method` varchar(255) NOT NULL,
  `status` enum('pending','processing','delivering','completed','cancelled','refunded') NOT NULL DEFAULT 'pending',
  `shipping_price` varchar(255) DEFAULT NULL,
  `total_price` varchar(255) DEFAULT NULL,
  `totalBeforeDiscount` varchar(255) DEFAULT NULL,
  `payment_status` enum('pending','paid','failed') NOT NULL DEFAULT 'pending',
  `note` varchar(1000) DEFAULT NULL,
  `return_order` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `guest_id`, `cookie_id`, `number`, `order_status_id`, `payment_method`, `status`, `shipping_price`, `total_price`, `totalBeforeDiscount`, `payment_status`, `note`, `return_order`, `created_at`, `updated_at`) VALUES
(57, 1, NULL, NULL, '2025000001', 2, 'cash_on_delivery', 'pending', '20', '145', '145', 'pending', NULL, 0, '2025-04-05 08:11:31', '2025-04-05 08:11:31'),
(58, NULL, NULL, '20e884e6-aecd-4f52-9002-65f03c279fad', '2025000002', 2, 'card_payment', 'pending', '20SAR', '100', '0', 'pending', 'Autem quisquam perfe', 0, '2025-05-28 10:31:21', '2025-05-28 10:31:21'),
(59, NULL, NULL, '20e884e6-aecd-4f52-9002-65f03c279fad', '2025000003', 2, 'tamara', 'pending', NULL, '35', '35', 'pending', 'In illo quis occaeca', 0, '2025-05-28 12:03:28', '2025-05-28 12:03:28'),
(60, NULL, NULL, '20e884e6-aecd-4f52-9002-65f03c279fad', '2025000004', 2, 'tamara', 'pending', NULL, '35', '35', 'pending', 'Aut omnis dolor culp', 0, '2025-05-28 12:06:09', '2025-05-28 12:06:09'),
(61, NULL, NULL, '20e884e6-aecd-4f52-9002-65f03c279fad', '2025000005', 2, 'tamara', 'pending', '20SAR', '35', '35', 'pending', 'Aut rerum commodo de', 0, '2025-05-28 12:09:07', '2025-05-28 12:09:07');

--
-- Triggers `orders`
--
DELIMITER $$
CREATE TRIGGER `after_order_delete` AFTER DELETE ON `orders` FOR EACH ROW BEGIN
    DELETE FROM notifications
    WHERE JSON_EXTRACT(data, '$.order_id') = OLD.id;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `order_addresses`
--

CREATE TABLE `order_addresses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `type` enum('billing','shipping') NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone_number` varchar(255) NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `country_id` bigint(20) UNSIGNED DEFAULT NULL,
  `city_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_addresses`
--

INSERT INTO `order_addresses` (`id`, `order_id`, `type`, `first_name`, `last_name`, `email`, `phone_number`, `address`, `country_id`, `city_id`) VALUES
(50, 57, 'billing', 'mohamed', 'gamal', 'mg792@gmail.com', '052222222', 'El mansura street', 178, 3088),
(51, 58, 'billing', 'Martina', 'Tyson', 'jyxu@mailinator.com', '460', 'Suscipit quia aliqua', 178, 3082),
(52, 59, 'billing', 'Lawrence', 'Dale', 'fiweronal@mailinator.com', '470', 'Mollit aut facere po', 178, 3090),
(53, 60, 'billing', 'Blake', 'Simmons', 'mufoxeximi@mailinator.com', '705', 'Eiusmod sed culpa il', 178, 3082),
(54, 61, 'billing', 'Lee', 'Garrett', 'zuqo@mailinator.com', '257', 'Aut ut proident vel', 178, 3082);

-- --------------------------------------------------------

--
-- Table structure for table `order_choices`
--

CREATE TABLE `order_choices` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `choice_id` bigint(20) UNSIGNED NOT NULL,
  `sub_choice_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED DEFAULT NULL,
  `product_name` varchar(255) NOT NULL,
  `price` double(8,2) NOT NULL,
  `quantity` smallint(5) UNSIGNED NOT NULL DEFAULT 1,
  `color` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `product_name`, `price`, `quantity`, `color`) VALUES
(60, 57, 16, 'ملمع الأثاث الخشبي', 100.00, 1, NULL),
(61, 57, 14, 'مطهر متعدد الاستعمالات', 10.00, 1, NULL),
(62, 57, 15, 'مناديل مطهرة', 35.00, 1, NULL),
(63, 58, 16, 'ملمع الأثاث الخشبي', 100.00, 1, NULL),
(64, 59, 15, 'مناديل مطهرة', 40.00, 1, NULL),
(65, 60, 15, 'مناديل مطهرة', 40.00, 1, NULL),
(66, 61, 15, 'مناديل مطهرة', 40.00, 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `order_item_choices`
--

CREATE TABLE `order_item_choices` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_item_id` bigint(20) UNSIGNED NOT NULL,
  `choice_id` bigint(20) UNSIGNED NOT NULL,
  `sub_choice_id` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`sub_choice_id`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order_statuses`
--

CREATE TABLE `order_statuses` (
  `id` smallint(5) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `name_en` varchar(255) DEFAULT NULL,
  `default_status` tinyint(1) NOT NULL DEFAULT 0,
  `arrangement` tinyint(3) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_statuses`
--

INSERT INTO `order_statuses` (`id`, `name`, `name_en`, `default_status`, `arrangement`) VALUES
(1, 'قيد التوصيل', 'Under delivery', 0, 2),
(2, 'قيد الانتظار', 'pending', 1, 1),
(3, 'جاري الشحن', 'shipped', 0, 3),
(4, 'تم التوصيل', 'delivered', 0, 4);

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE `pages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `content` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pages`
--

INSERT INTO `pages` (`id`, `title`, `content`, `created_at`, `updated_at`) VALUES
(1, 'الشروط والأحكام\n', '<p style=\"text-align: right;\"><strong><span class=\"example2\">uهذا النص هو مثال لنص يمكن أن يستبدل في نفس المساحة، لقد تم توليد هذا النص من مولد النص العربى، حيث يمكنك أن تولد مثل هذا النص أو العديد من النصوص&nbsp; &nbsp;<span style=\"color: #e03e2d;\">updateالأخرى</span> إضافة إلى زيادة عدد الحروف التى يولدها التطبيق.</span></strong><br /><span style=\"color: #3598db;\"><strong><span class=\"example1\">إذا كنت تحتاج إلى عدد أكبر من الفقرات يتيح لك مولد النص العربى زيادة عدد الفقرات كما تريد، النص لن يبدو مقسما ولا يحوي أخطاء لغوية، مولد النص العربى مفيد لمصممي المواقع على وجه الخصوص، حيث يحتاج العميل فى كثير من الأحيان أن يطلع على صورة حقيقية لتصميم الموقع.</span></strong></span><br />ومن هنا وجب على المصمم أن يضع نصوصا مؤقتة على التصميم ليظهر للعميل الشكل كاملاً،دور مولد النص العربى أن يوفر على المصمم عناء البحث عن نص بديل لا علاقة له بالموضوع الذى يتحدث عنه التصميم فيظهر بشكل لا يليق.<br />هذا النص يمكن أن يتم تركيبه على أي تصميم دون مشكلة فلن يبدو وكأنه نص منسوخ، غير منظم، غير منسق، أو حتى غير مفهوم. لأنه مازال نصاً بديلاً ومؤقتاً.</p>', NULL, '2024-08-06 09:39:43'),
(2, 'سياسة الشحن', '<p style=\"text-align: right;\"><span style=\"color: #169179;\">هذا النص هو مثال لنص يمكن أن يستبدل في نفس المساحة، لقد تم توليد هذا النص من مولد النص العربى، حيث يمكنك أن تولد مثل هذا النص أو العديد من النصوص الأخرى إضافة إلى زيادة عدد الحروف التى يولدها التطبيق. إذا كنت تحتاج إلى عدد أكبر من الفقرات يتيح لك مولد النص العربى زيادة عدد الفقرات كما تريد، النص لن يبدو مقسما ولا يحوي أخطاء لغوية، مولد النص العربى مفيد لمصممي المواقع على وجه الخصوص، حيث يحتاج العميل فى كثير من الأحيان أن يطلع على صورة حقيقية لتصميم الموقع. ومن هنا وجب على المصمم أن يضع نصوصا مؤقتة على التصميم ليظهر للعميل الشكل كاملاً،دور مولد النص العربى أن يوفر على المصمم عناء البحث عن نص بديل لا علاقة له بالموضوع الذى يتحدث عنه التصميم فيظهر بشكل لا يليق. هذا النص يمكن أن يتم تركيبه على أي تصميم دون مشكلة فلن يبدو وكأنه نص منسوخ، غير منظم، غير منسق، أو حتى غير مفهوم. لأنه مازال نصاً بديلاً ومؤقتاً.</span></p>', NULL, '2024-08-06 09:42:43'),
(3, 'سياسة الخصوصية', '<p style=\"text-align: right;\"><strong>سياسة الخصوصية</strong><br />نشكرك عزيزنا العميل على زيارتك واستخدامك لمتجرنا. نحن نلتزم بحماية خصوصيتك وسرية معلوماتك الشخصية. يرجى قراءة سياسة الخصوصية التالية لفهم كيفية جمعنا واستخدامنا لمعلوماتك وحمايتنا للمعلومات التي تقدمها لنا<br /><strong>جمع المعلومات</strong>&nbsp;<br />عند قيامك بزيارة موقعنا أو تطبيقنا أو إجراء معاملة عبره، قد نقوم بجمع بعض المعلومات الشخصية التي تشمل اسمك، وعنوانك، ورقم هاتفك، وعنوان بريدك الإلكتروني، ومعلومات الدفع. قد نستخدم تقنيات مثل ملفات تعريف الارتباط (كوكيز) ووسائط تتبع أخرى لجمع معلومات إضافية عنك<br /><strong>استخدام المعلومات</strong>&nbsp;<br />نستخدم المعلومات التي نجمعها لتحسين خدماتنا وتجربتك كمستخدم. قد نستخدم المعلومات لتقديم المنتجات والخدمات التي طلبتها، ومعالجة الدفعات، وتوفير الدعم العملائي، وتخصيص تجربتك، وإرسال رسائل ترويجية إليك إذا كنت قد أعطيتنا موافقتك المسبقة لذلك<br /><strong>الكشف عن المعلومات</strong><br />نحن نلتزم بعدم مشاركة معلوماتك الشخصية مع أطراف ثالثة غير مرخص لها، باستثناء الحالات التالية<br />عندما يكون الكشف ضروريًا للامتثال للقوانين واللوائح المعمول بها</p>\r\n<p style=\"text-align: right;\">عندما يتطلب الكشف حماية حقوقنا وفق القوانين واللوائح المعمول بها<br />عندما يكون الكشف ضروريًا لحماية سلامتك أو سلامة الآخرين<br />أ<strong>مان المعلومات</strong><br />نحن نتخذ إجراءات أمنية معقولة لحماية المعلومات الشخصية التي تقدمها لنا. ومع ذلك، فإنه لا يوجد نظام أمني مطلق، ولا يمكن ضمان الأمان الكامل للمعلومات عبر الإنترنت<br /><strong>حقوقك</strong><br />لديك الحق في الوصول إلى المعلومات الشخصية التي نحتفظ بها وتصحيحها وحذفها وتقييد معالجتها، ولديك الحق في سحب موافقتك في أي وقت. يمكنك ممارسة هذه الحقوق عن طريق الاتصال بنا عبر معلومات الاتصال الموجودة في نهاية سياسة الخصوصية<br /><strong>تغييرات في السياسة</strong></p>\r\n<p style=\"text-align: right;\">قد نقوم بتحديث سياسة الخصوصية هذه بين الحين والآخر. سنقوم بنشر أي تغييرات على موقعنا وسيتم تطبيقها فور نشرها. يرجى مراجعة سياسة الخصوصية بانتظام</p>\r\n<p style=\"text-align: right;\"><strong>اتصال&nbsp;</strong><br />إذا كان لديك أي أسئلة أو استفسارات حول سياسة الخصوصية، يُرجى الاتصال بنا عبر الوسائل المتاحة في موقعنا</p>', NULL, '2024-12-21 07:05:44'),
(4, 'من نحن', '<p style=\"text-align: right;\"><strong>تعتير شركة امدادات الضيافة للتجارة من الشركات الرائدة والموردة لكافة أدوات ومواد النظافة (مستلزمات الفنادق ، المدارس، المستشفيات ،&nbsp; اليلاستيك ، الورقيات ، الخردوات ، الأواني المنزلية ) ( جملة ـ قطاغي ) وتمتلك شركة امدادات الضيافة فروعا في المملكة&nbsp; العربية السعودية علاوة على مركزها الرئيسي في مدينة جدة دوار النجوم .</strong></p>\r\n<p style=\"text-align: right;\"><strong>وما يميزنا غن غيرنا هو جودة المنتجات وتوافرها بالكميات المطلوبة بالإضافة الى أن شركة إمدادات الضيافة للتجارة&nbsp; .واكبت التكنلوجيا الرقمية بإطلاق موقغ وتطبيق مبيغات أونلاين خدمة للمستهلك وتوفيرا للجهد&nbsp; والوق</strong>ت&nbsp;</p>', NULL, '2024-12-21 07:14:13'),
(5, 'التبديل و المرتجعات', '<div class=\"blog-title mt-5 mb-5\">\r\n<h1 style=\"text-align: right;\">س<strong>ياسات الاستبدال والاسترجاع</strong></h1>\r\n<p style=\"text-align: right;\"><strong>نشكر اختياركم موقعنا الإكتروني لشراء منتجاتكم ذات الجودة القغالة ويسعدنا أن نقوم بخدمتكم. &nbsp;في بعض الأحيان ربما يتغير رأيك فيما يتعلق بالمنتجات التي قمت بشرائها، لا عليك. فنحن في متجر وتطبيق شركة امدادات التجارة سنبذل ما في وسعنا لتتم عملية الاسترجاع أو الاستبدال بمنتهى البساطة والسلاسة بقدر الإمكان</strong></p>\r\n<p style=\"text-align: right;\"><strong>:لقد قمنا بتسهيل عملية الاسترجاع أو الاستبدال من خلال الإجراءات التالية</strong></p>\r\n<p style=\"text-align: right;\"><strong>&nbsp;سياسة الفترة الزمنية لاسترجاع أو استبدال المشتريات</strong></p>\r\n<p style=\"text-align: right; padding-left: 40px;\"><strong>عند الرغبة في استبدال أو استرجاع المنتج عليك الاتصال بنا أولا&nbsp;</strong><br /><strong>يحق للعميل استرجاع المنتج خلال 3 أيام من تاريخ الإستلام، بشرط أن يكون المنتج سليما لم يطرأ إليه أي تغيير، &nbsp;ويتحمل العميل تكاليف الشحن كاملا، ويتم إرجاع تكلفة المنتج للعميل خلال 14 يوم عمل</strong><br /><strong>يحق للعميل استبدال المنتج بمنتج آخر، وذلك قبل إرسال الشحنة. وبعد إرسال الشحنة يحق له الاستبدال خلال 14 أيام عمل، وعليه تحمل تكلفة الشحن كاملا ودفع فارق تكلفة المنتج إن وجد</strong><br /><strong>إذا كان المنتج معيبا، أو غير مطابق للمواصفات التي تم تحديدها وقت الشراء يحق للعميل استبدال المنتج أو استرجاعه خلال 14 يوما، وعلى العميل في هذه الحالة إرسال ما يثبت تكاليف الشحن موضح فيه: رقم الارسالية &nbsp;الشحن &ndash; والتكلفة. فيحق للعميل عندئذ استرجاع المبلغ كاملا.</strong><br /><strong>المنتجات الشاملة في الخصومات والعروض لا تستبدل ولا تسترجع، ويستثنى من ذلك وجود عيب في المنتج،&nbsp;</strong><br /><strong>&nbsp;:لا يقبل استرجاع المنتجات أو استبدالها في الحالات التالية</strong><br /><strong>&nbsp;لا يقبل الاسترجاع بعد مضي 3 أيام من تاريخ الاستلام، ولا يقبل الاستبدال بعد 14 يوما</strong><br /><strong>عند تغير المنتج عن حالته الأصلية لأي سبب من الاسباب</strong><br /><strong>عند الاستعمال بما يتعدى غرض التجربة</strong><br /><strong>المنتجات التي تم تصنيعها بطلب من العميل وفقا لمواصفات محدده</strong></p>\r\n<h1><strong>ا</strong></h1>\r\n</div>', '2024-11-13 10:51:31', '2024-12-21 07:12:03');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `password_reset_tokens`
--

INSERT INTO `password_reset_tokens` (`email`, `token`, `created_at`) VALUES
('ahmedtahaa999@gmail.com', '$2y$12$nVRL63L8XTJvj0s31LY6JueGJV..n6zqOpsdnJXtPX9GivXoBBBYK', '2024-02-18 18:00:00'),
('gabartaha028@gmail.com', '$2y$12$fgN7nvAM5Hyz8N/yPTmUtuji/eUTv23zwI0oPMdQfeDmYJxKWqIgu', '2024-02-18 18:10:21'),
('gabartaha028@gmailcom', '$2y$12$M/91OOwLyVZrI20bO.NJzOc4UgG7mmLNxE/8thi2ujePqZtxJzYp2', '2024-02-18 18:03:52'),
('jemi@gmail.com', '$2y$12$phPR6H3RbdswMeZkS0XDc.pg0LjfrQwD3XjS6PAEIb6HCmuBUuCXm', '2024-03-08 18:10:46'),
('jemi123@gmail.com', '$2y$12$nJxJLXN026gutGYMPWsbhuDwE3o8cZftVmCvhmC0porcUpV8MDzzW', '2024-07-07 09:46:20'),
('mostafataha011188@gmail.com', '$2y$12$3bDMtJoJjoxxnYBari4EUONaQ/BezwBUBstqXMJtAqZsh8W4jelSi', '2024-03-02 08:25:33'),
('user@user.com', '$2y$12$ahW6dtdWdg3EKpdg5NMfEuJRsS06ekUExMuWPm.DnyupEyUyRLRIW', '2024-07-22 10:05:17');

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `personal_access_tokens`
--

INSERT INTO `personal_access_tokens` (`id`, `tokenable_type`, `tokenable_id`, `name`, `token`, `abilities`, `last_used_at`, `expires_at`, `created_at`, `updated_at`) VALUES
(10, 'App\\Models\\User', 8, '-AuthToken', '2b37f11269bd993c0d0c0d3a45fa67da8114ea5ba6b3f93e395db3e932086eb9', '[\"*\"]', '2025-01-21 14:45:23', NULL, '2025-01-21 14:01:59', '2025-01-21 14:45:23'),
(11, 'App\\Models\\User', 8, '-AuthToken', 'ccc93b2c4fea47ebbe5d0064762da93a04335e420e294d9889cbca0ae2f01100', '[\"*\"]', NULL, NULL, '2025-01-21 14:37:59', '2025-01-21 14:37:59'),
(12, 'App\\Models\\User', 8, '-AuthToken', '947c76a180d6e29030f52ff070dc8832211145eef72170764411a08a267fc6f4', '[\"*\"]', NULL, NULL, '2025-01-21 14:47:01', '2025-01-21 14:47:01'),
(13, 'App\\Models\\User', 1, '-AuthToken', '44a850eceab8133680e8c0c6199639df65b0f8923fba27aa859fc05febf3c0e2', '[\"*\"]', NULL, NULL, '2025-01-22 09:35:36', '2025-01-22 09:35:36'),
(15, 'App\\Models\\User', 1, '-AuthToken', '48c3b60693ef5994a7fa610270fd82891a26f736c7320ae0799666d4e585d0ff', '[\"*\"]', NULL, NULL, '2025-01-22 09:36:48', '2025-01-22 09:36:48'),
(16, 'App\\Models\\User', 1, '-AuthToken', '329c08d7550393e2aa2784f7aa4e5827cd7e5e651887f5c3de960ebd13fc53c1', '[\"*\"]', NULL, NULL, '2025-01-22 09:37:17', '2025-01-22 09:37:17'),
(17, 'App\\Models\\User', 1, '-AuthToken', 'b8ea386a8cc9754b69e89685d232e2577fd27985e16d819439b680f98c47759d', '[\"*\"]', NULL, NULL, '2025-01-22 13:10:40', '2025-01-22 13:10:40'),
(18, 'App\\Models\\User', 1, '-AuthToken', 'a32c10c5c62fc79d5bbdea16c325479ea7c7950ba67980fead9d7205b22e4491', '[\"*\"]', NULL, NULL, '2025-01-22 13:11:13', '2025-01-22 13:11:13'),
(19, 'App\\Models\\User', 1, '-AuthToken', 'd04e17dd27728fea985428f6cb5dc665b62f6d295fa437bd1ede66c261c8b7a9', '[\"*\"]', NULL, NULL, '2025-01-22 13:12:47', '2025-01-22 13:12:47'),
(20, 'App\\Models\\User', 1, '-AuthToken', 'e701c7da7bd11a08b312579b25289d15a191ff73bbf0c5557c4da7a30d26d548', '[\"*\"]', NULL, NULL, '2025-01-22 13:13:21', '2025-01-22 13:13:21'),
(21, 'App\\Models\\User', 1, '-AuthToken', '47dc9b507d3f453fbbd661004db40fd2d249a8c71ea52c688e5528612ccd5a36', '[\"*\"]', '2025-01-22 13:38:10', NULL, '2025-01-22 13:13:55', '2025-01-22 13:38:10'),
(22, 'App\\Models\\User', 1, '-AuthToken', '06fd27340d5cfa54e94a58420bb4c6692ab0189c1cc15781e4a8aed1adf5a6f6', '[\"*\"]', '2025-01-29 13:55:50', NULL, '2025-01-25 10:11:49', '2025-01-29 13:55:50'),
(23, 'App\\Models\\User', 1, '-AuthToken', 'ccad1b1aa39506197458818ebd11bdaa09f91f3728417675014dbf9d958352f5', '[\"*\"]', '2025-02-09 11:15:30', NULL, '2025-02-06 09:17:37', '2025-02-09 11:15:30'),
(24, 'App\\Models\\User', 1, '-AuthToken', 'f91f06c431bef7d66a4192fcda5945ab09cec957166a4f8f23beeb0c685c25f0', '[\"*\"]', '2025-04-05 08:11:31', NULL, '2025-03-05 07:42:48', '2025-04-05 08:11:31');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `name_en` varchar(255) DEFAULT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `price` decimal(8,2) DEFAULT NULL,
  `discount_price` decimal(8,2) DEFAULT NULL,
  `weight` decimal(8,2) DEFAULT 0.00,
  `quantity` smallint(5) UNSIGNED DEFAULT 1,
  `status` enum('active','archived') NOT NULL DEFAULT 'active',
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `parent_id` bigint(20) UNSIGNED DEFAULT NULL,
  `company_id` bigint(20) UNSIGNED DEFAULT NULL,
  `main_category_setting_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `is_special` tinyint(1) NOT NULL DEFAULT 0,
  `product_availability_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `name_en`, `slug`, `description`, `image`, `price`, `discount_price`, `weight`, `quantity`, `status`, `category_id`, `parent_id`, `company_id`, `main_category_setting_id`, `created_at`, `updated_at`, `deleted_at`, `is_special`, `product_availability_id`) VALUES
(1, 'سائل تنظيف الصحون', 'Dishwashing Liquid', 'سائل-تنظيف-الصحون', NULL, 'products/KnHegFjH0PshONKbXDW7vhRFRvOYEwPirAUgwvuv.jpg', 50.00, NULL, 10.00, 100, 'active', 1, 1, NULL, NULL, '2024-11-12 13:44:09', '2024-11-13 13:07:00', NULL, 0, 1),
(2, 'جل تنظيف الأواني', 'Dish Cleaning Gel', 'جل-تنظيف-الأواني', NULL, 'products/w9naVQif0FVEeXA5hHyo5fPpOsLoX7aHsdAGouxK.jpg', 50.00, NULL, 10.00, 100, 'active', 1, 1, NULL, NULL, '2024-11-12 14:03:05', '2024-11-13 13:06:24', NULL, 0, 2),
(3, 'منظف الأرضيات المعطر', 'Scented Floor Cleaner', 'منظف-الأرضيات-المعطر', NULL, 'products/x4jtslhTFuSaxmYyq1s85IQLApa3XMAVWuM7bho6.jpg', 50.00, NULL, 10.00, 100, 'active', 2, 2, NULL, NULL, '2024-11-12 14:05:23', '2024-11-13 13:06:10', NULL, 0, 2),
(4, 'منظف الأرضيات المقاوم للبكتيريا', 'Anti-Bacterial Floor Cleaner', 'منظف-الأرضيات-المقاوم-للبكتيريا', NULL, 'products/1EKEWwS9JicVLFM4TxV1EULzuZr99cHqG4xkjsI9.jpg', 100.00, NULL, 10.00, 99, 'active', 2, 2, NULL, NULL, '2024-11-12 14:06:14', '2024-12-25 06:49:05', NULL, 0, 2),
(5, 'مسحوق غسيل الملابس', 'Laundry Powder', 'مسحوق-غسيل-الملابس', NULL, 'products/sY3dEDKbGvtLJxEmb6jDOX64jcQ68D7FHfWQNEvv.jpg', 22.00, NULL, 10.00, 100, 'active', 3, 3, NULL, NULL, '2024-11-12 14:07:33', '2024-11-13 13:04:09', NULL, 0, 2),
(6, 'سائل غسيل الملابس', 'Laundry Liquid', 'سائل-غسيل-الملابس', NULL, 'products/Y55PmIZKJmiqFoYJYUhMvgXq5OgJ4h8IFlYld9I1.jpg', 30.00, NULL, 10.00, 100, 'active', 3, 3, NULL, NULL, '2024-11-12 14:08:28', '2024-11-13 13:03:56', NULL, 0, 2),
(7, 'بخاخ معطر الجو', 'Air Freshener Spray', 'بخاخ-معطر-الجو', NULL, 'products/wnl6GZLi5V9oVDFwAYsuiMMvjtjWShKP4IQT4788.jpg', 100.00, NULL, 10.00, 98, 'active', 4, 4, NULL, NULL, '2024-11-12 14:09:53', '2025-01-26 13:36:46', NULL, 0, 2),
(9, 'صابون سائل لليدين', 'Liquid Hand Soap', 'صابون-سائل-لليدين', NULL, 'products/1ZpkfAoZD2fxZhSMKM3HtO59LqtXDpFfbqinDjyr.jpg', 100.00, 90.00, 10.00, 95, 'active', 5, 5, NULL, NULL, '2024-11-12 14:11:57', '2025-01-27 13:36:28', NULL, 0, 2),
(10, 'شامبو الشعر', 'Hair Shampoo', 'شامبو-الشعر', NULL, 'products/9nG6ovsZYO5VVu8JfZAghVD8b6BQR2vCv5hwsxaZ.jpg', 50.00, 45.00, 10.00, 99, 'active', 5, 5, NULL, NULL, '2024-11-12 14:12:40', '2025-01-27 12:49:34', NULL, 0, 2),
(11, 'منظف المرحاض', 'Toilet Cleaner', 'منظف-المرحاض', NULL, 'products/IyfNitUCI3HBMsOQ6pdglQcZWUvoEWIKCM5yh4qL.jpg', 100.00, 90.00, 10.00, 100, 'active', 6, 6, NULL, NULL, '2024-11-12 14:13:43', '2024-11-13 17:28:32', NULL, 0, 2),
(13, 'منظف بلاط الحمام', 'Bathroom Tile Cleaner', 'منظف-بلاط-الحمام', NULL, 'products/bF9tBbxGBftUnls66mA5gVstlwglaDZFtQyDjMCS.jpg', 80.00, 70.00, 10.00, 100, 'active', 6, 6, NULL, NULL, '2024-11-12 14:14:38', '2024-11-13 12:59:06', NULL, 0, 2),
(14, 'مطهر متعدد الاستعمالات', 'Multi-Purpose Disinfectant', 'مطهر-متعدد-الاستعمالات', NULL, 'products/AEn0xLn6trTr1no49wcnPugjole6pri5kd5LvtbT.jpg', 10.00, NULL, 10.00, 98, 'active', 7, 7, NULL, NULL, '2024-11-12 14:15:57', '2025-04-05 08:11:31', NULL, 0, 2),
(15, 'مناديل مطهرة', 'Disinfectant Wipes', 'مناديل-مطهرة', NULL, 'products/6HgvIuSMWdRHciFeS8SBcXdPmvE2CnDY02iqehM6.jpg', 40.00, 35.00, 10.00, 91, 'active', 7, 7, NULL, NULL, '2024-11-12 14:20:57', '2025-05-28 12:09:07', NULL, 0, 2),
(16, 'ملمع الأثاث الخشبي', 'Wood Furniture Polish', 'ملمع-الأثاث-الخشبي', NULL, 'products/dGmOxXbc1nmcI8JPKgmvju9NvYdQ6dVpHCUxZLqK.jpg', 100.00, NULL, 10.00, 49, 'active', 2, 2, NULL, NULL, '2024-11-12 14:22:07', '2025-05-28 10:31:21', NULL, 0, 2),
(24, 'test', 'adidas', 'test', NULL, NULL, 122.00, NULL, NULL, 3, 'active', 8, 8, NULL, NULL, '2025-04-02 10:13:07', '2025-09-27 07:29:52', NULL, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `product_availabilities`
--

CREATE TABLE `product_availabilities` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `name_en` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_availabilities`
--

INSERT INTO `product_availabilities` (`id`, `name`, `name_en`) VALUES
(1, 'متوفر', 'available'),
(2, 'جديد', 'New');

-- --------------------------------------------------------

--
-- Table structure for table `product_features`
--

CREATE TABLE `product_features` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `feature_name` varchar(255) DEFAULT NULL,
  `feature_name_en` varchar(255) DEFAULT NULL,
  `feature_description` varchar(255) DEFAULT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product_images`
--

CREATE TABLE `product_images` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `image` varchar(255) NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_images`
--

INSERT INTO `product_images` (`id`, `image`, `product_id`, `created_at`, `updated_at`) VALUES
(1, 'uploads/products_image/lUuFUDgVqyRt1mglvHLAmftWpiuORh3VVF7MYhIq.png', 1, '2024-11-12 13:44:09', '2024-11-12 13:44:09'),
(4, 'uploads/products_image/UdI5SVGg0sB2xXhrHGXlOIexV4cAMOlFPrOzzvnS.png', 1, '2024-12-26 10:52:29', '2024-12-26 10:52:29');

-- --------------------------------------------------------

--
-- Table structure for table `product_user`
--

CREATE TABLE `product_user` (
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `representatives_orders`
--

CREATE TABLE `representatives_orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `representatives_orders`
--

INSERT INTO `representatives_orders` (`id`, `name`, `phone`, `description`, `created_at`, `updated_at`) VALUES
(1, 'test update', '01114866898', 'test update', '2024-07-07 11:21:35', '2024-07-07 11:30:47'),
(3, 'mohamed gamal', '01065743058', 'test', '2024-07-14 09:26:38', '2024-07-14 09:26:38'),
(4, 'mohamed gamal', '01065743058', 'test test test test', '2024-07-22 13:23:54', '2024-07-22 13:23:54'),
(5, 'test', '0105412587', 'descriptiondescriptiondescriptiondescriptiondescription', '2024-08-13 15:35:56', '2024-08-13 15:35:56'),
(6, 'test', '01054132587', 'testtesttesttesttesttesttesttesttesttesttesttesttesttesttesttest', '2024-08-13 15:48:47', '2024-08-13 15:48:47'),
(7, 'test', '01054132587', 'testtesttesttesttesttesttesttesttesttesttesttesttesttesttesttest', '2024-08-25 14:43:01', '2024-08-25 14:43:01'),
(8, 'test', '01054132587', 'testtesttesttesttesttesttesttesttesttesttesttesttesttesttesttest', '2024-08-25 14:56:35', '2024-08-25 14:56:35'),
(9, 'test', '01054132587', 'testtesttesttesttesttesttesttesttesttesttesttesttesttesttesttest', '2024-08-25 14:57:45', '2024-08-25 14:57:45'),
(10, 'Ali Gahzal', '0548484545', 'hola hola hola dhsjsh', '2024-08-25 14:59:46', '2024-08-25 14:59:46'),
(11, 'Ali Gamal', '05484848848', 'hola hola hshsjsvshsbdj jdhsbsbsjbsh hdhsjsjshs hshs', '2024-08-25 15:01:55', '2024-08-25 15:01:55'),
(12, 'aliahaha', '0546488448', 'vshshsh sbshshsb', '2024-08-25 15:28:00', '2024-08-25 15:28:00'),
(13, 'test', '01054132587', 'testtesttesttesttesttesttesttesttesttesttesttesttesttesttesttest', '2024-08-27 13:27:20', '2024-08-27 13:27:20'),
(14, 'test', '01054132587', 'testtesttesttesttesttesttesttesttesttesttesttesttesttesttesttest', '2024-10-19 14:17:10', '2024-10-19 14:17:10');

-- --------------------------------------------------------

--
-- Table structure for table `return_products`
--

CREATE TABLE `return_products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `guest_id` bigint(20) UNSIGNED DEFAULT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rules`
--

CREATE TABLE `rules` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `rules`
--

INSERT INTO `rules` (`id`, `name`, `created_at`, `updated_at`) VALUES
(8, 'admin', '2024-01-23 11:49:31', '2024-12-17 06:16:46');

-- --------------------------------------------------------

--
-- Table structure for table `rule_abilities`
--

CREATE TABLE `rule_abilities` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `rule_id` bigint(20) UNSIGNED NOT NULL,
  `ability` varchar(255) NOT NULL,
  `type` enum('allow','deny') NOT NULL DEFAULT 'deny'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `rule_abilities`
--

INSERT INTO `rule_abilities` (`id`, `rule_id`, `ability`, `type`) VALUES
(47, 8, 'category.view', 'allow'),
(48, 8, 'category.edit', 'allow'),
(49, 8, 'category.create', 'allow'),
(50, 8, 'category.delete', 'allow'),
(55, 8, 'sub_filter.create', 'allow'),
(56, 8, 'sub_filter.edit', 'allow'),
(58, 8, 'company.view', 'allow'),
(59, 8, 'company.create', 'allow'),
(60, 8, 'company.edit', 'allow'),
(61, 8, 'company.delete', 'allow'),
(62, 8, 'design.view', 'allow'),
(63, 8, 'design.create', 'allow'),
(133, 8, 'product_availability.create', 'allow'),
(134, 8, 'currency.create', 'allow'),
(135, 8, 'country.create', 'allow'),
(136, 8, 'filter.view', 'allow'),
(137, 8, 'filter.edit', 'allow'),
(138, 8, 'filter.create', 'allow'),
(139, 8, 'filter.delete', 'allow'),
(140, 8, 'sub_filter.delete', 'allow'),
(147, 8, 'admin.group.create', 'allow'),
(150, 8, 'order.view', 'allow'),
(151, 8, 'order.edit', 'allow'),
(152, 8, 'order.delete', 'allow'),
(153, 8, 'return_order.view', 'allow'),
(154, 8, 'return_order.edit', 'allow'),
(155, 8, 'return_order.delete', 'allow'),
(156, 8, 'news.view', 'allow'),
(157, 8, 'settings.edit', 'allow'),
(158, 8, 'shipping.edit', 'allow'),
(159, 8, 'discount_code.view', 'allow'),
(160, 8, 'discount_code.edit', 'allow'),
(161, 8, 'discount_code.delete', 'allow'),
(162, 8, 'discount_code.create', 'allow'),
(163, 8, 'order_status.view', 'allow'),
(164, 8, 'order_status.edit', 'allow'),
(165, 8, 'order_status.delete', 'allow'),
(166, 8, 'order_status.create', 'allow'),
(167, 8, 'product_availability.view', 'allow'),
(168, 8, 'product_availability.edit', 'allow'),
(169, 8, 'product_availability.delete', 'allow'),
(170, 8, 'currency.view', 'allow'),
(171, 8, 'currency.edit', 'allow'),
(172, 8, 'currency.delete', 'allow'),
(173, 8, 'country.view', 'allow'),
(174, 8, 'country.edit', 'allow'),
(175, 8, 'country.delete', 'allow'),
(176, 8, 'color.view', 'allow'),
(177, 8, 'color.create', 'allow'),
(178, 8, 'color.edit', 'allow'),
(179, 8, 'color.delete', 'allow'),
(483, 8, 'design.edit', 'allow'),
(484, 8, 'design.delete', 'allow'),
(488, 8, 'admin.group.edit', 'allow'),
(489, 8, 'admin.group.delete', 'allow'),
(494, 8, 'admin.group.view', 'allow'),
(496, 8, 'product.view', 'allow'),
(498, 8, 'product.edit', 'allow');

-- --------------------------------------------------------

--
-- Table structure for table `send_news_to_users`
--

CREATE TABLE `send_news_to_users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `subscription_email` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `send_news_to_users`
--

INSERT INTO `send_news_to_users` (`id`, `subscription_email`) VALUES
(6, 'brjbbjeembuea@dont-reply.me'),
(5, 'bzsrsmasebuea@do-not-respond.me'),
(1, 'eejajaabjluea@dont-reply.me'),
(4, 'emrielmzabuea@dont-reply.me'),
(2, 'erlmesijzbuea@dont-reply.me'),
(3, 'eszsslealbuea@do-not-respond.me'),
(7, 'jyxu@mailinator.com');

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `website_name` varchar(255) NOT NULL,
  `website_name_en` varchar(255) DEFAULT NULL,
  `subscription_title` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `phone_number` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `google_play` varchar(255) DEFAULT NULL,
  `apple_store` varchar(255) DEFAULT NULL,
  `facebook` varchar(255) DEFAULT NULL,
  `twitter` varchar(255) DEFAULT NULL,
  `instagram` varchar(255) DEFAULT NULL,
  `snap` varchar(255) DEFAULT NULL,
  `tiktok` varchar(255) DEFAULT NULL,
  `tax_number` varchar(255) DEFAULT NULL,
  `value_added_tax` decimal(10,0) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `publishable_key` varchar(255) DEFAULT NULL,
  `secret_key` varchar(255) DEFAULT NULL,
  `sms_api_key` varchar(255) DEFAULT NULL,
  `sms_user_name` varchar(255) DEFAULT NULL,
  `sms_sender` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `website_name`, `website_name_en`, `subscription_title`, `address`, `phone_number`, `email`, `google_play`, `apple_store`, `facebook`, `twitter`, `instagram`, `snap`, `tiktok`, `tax_number`, `value_added_tax`, `image`, `logo`, `publishable_key`, `secret_key`, `sms_api_key`, `sms_user_name`, `sms_sender`, `created_at`, `updated_at`) VALUES
(1, 'امدادات الضيافة للتجارة', 'imdatadt al-dhiyafah', 'انضم الان و احصل علي 10% علي مشترياتك التالية', 'عنوان المتجر update d', '0541603194', 'website@info.com', 'https://play.google.com/store/apps/details?id=com.imdadataldiyhafah.app', 'https://apps.apple.com/us/app/%D8%A7%D9%85%D8%AF%D8%A7%D8%AF%D8%A7%D8%AA-%D8%A7%D9%84%D8%B6%D9%8A%D8%A7%D9%81%D8%A9/id6738141212', 'https://www.facebook.com/imdadat94?mibextid=ZbWKwL', 'https://x.com/imdadat94?t=Eouw5wmRxuDcwxEtdWvBjQ&s=08', 'https://www.instagram.com/', 'https://www.snapchat.com/', 'https://www.tiktok.com/', '1234567891', NULL, 'uploads/website_image/QND0G5AmxaIWkRXWvnzyl8vfTqOUtzYrZJAOJ40E.png', 'uploads/website_image/WfhcvIyTIPOV3dVKPcaab1Q8YNqcg5MYUUNA7jse.png', 'pk_test_GBJgMzEt7XyQfVNhmtteJgYbsdV4J57T3ehctoh4', 'sk_test_w9KTQxohGr4qUzkx6vtDQWu7pmERSgfqdGWJoMZz', '34f857fa066ffb5c4b178fa987fbaf3bad3642df', 'imdadat', 'ImdadatD', NULL, '2025-03-05 07:36:46');

-- --------------------------------------------------------

--
-- Table structure for table `shipping_types_and_price`
--

CREATE TABLE `shipping_types_and_price` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `add_pickup_from_store` tinyint(1) DEFAULT 0,
  `add_wight_price` tinyint(1) DEFAULT 0,
  `add_normal_price` tinyint(1) DEFAULT 0,
  `add_price_based_on_city` tinyint(1) DEFAULT 1,
  `weight_price` decimal(8,2) DEFAULT 0.00,
  `normal_shipping_price` decimal(8,2) DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `shipping_types_and_price`
--

INSERT INTO `shipping_types_and_price` (`id`, `add_pickup_from_store`, `add_wight_price`, `add_normal_price`, `add_price_based_on_city`, `weight_price`, `normal_shipping_price`) VALUES
(1, 1, 1, 1, 0, 5.00, 20.00);

-- --------------------------------------------------------

--
-- Table structure for table `store_featuers`
--

CREATE TABLE `store_featuers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `title_en` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `store_featuers`
--

INSERT INTO `store_featuers` (`id`, `image`, `title`, `title_en`, `description`, `created_at`, `updated_at`) VALUES
(1, 'uploads/public/t94qpibheJi3Z6qvS5Txtj8RyP4rUl1MOVpR3aST.png', 'شحن مجاني', 'free shipping', 'شحن مجانى للطلبات أكثر من 1000 ريال', '2024-08-01 10:31:10', '2024-08-07 10:29:26'),
(2, 'uploads/public/DhaXIH73QCv6tr9DGUKhY0r9X3SloRpP8T3NGHPL.png', 'خدمة عملاء 24 ساعة', '24 hour customer service', '24 ساعة . 7 أيام الأسبوع معك دائماً', '2024-08-01 11:17:13', '2024-08-08 10:16:16'),
(3, 'uploads/public/ffzR4otRbpfmAPI6rWEFOdHlnOKcBgiNE3OKad1i.png', 'عروض وتخفيضات', 'Offers and discounts', 'خصومات كبيرة وتخفيضات مخصصة لك', '2024-08-01 11:17:46', '2024-08-08 10:16:40'),
(4, 'uploads/public/0PNx1QgKjnqcTNwk251tmx6dacRAVWOooO2qO17g.png', 'وسائل دفع متنوعة', 'Various payment methods', 'أكثر وسائل الدفع أمان متوفرة لدينا', '2024-08-01 11:18:25', '2024-08-08 10:17:01');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `family_name` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone_number` varchar(255) DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `two_factor_secret` text DEFAULT NULL,
  `two_factor_recovery_codes` text DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `default_currency` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `family_name`, `address`, `email`, `phone_number`, `email_verified_at`, `password`, `image`, `two_factor_secret`, `two_factor_recovery_codes`, `remember_token`, `created_at`, `updated_at`, `default_currency`) VALUES
(1, 'mohamed 2', 'gamel 2', 'El mansura street', 'mg792@gmail.com', '522222222', NULL, '$2y$10$r2ewdiwIPPIIXHtgY.fLau8DHQ.5e/wvbtMdfZkpcukfOY8ir6Cuq', 'uploads/users/J6Cxxp3GuisOcnlyUKW5bN7IAZy2g09j4cR85yYL.jpg', NULL, NULL, NULL, '2025-01-22 09:33:22', '2025-01-25 10:56:09', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users_verificationcodes`
--

CREATE TABLE `users_verificationcodes` (
  `id` int(11) NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(255) NOT NULL,
  `verification_code_expires_at` varchar(255) DEFAULT NULL,
  `compare_code` varchar(255) DEFAULT NULL,
  `is_reset_password` tinyint(1) NOT NULL DEFAULT 0,
  `is_verified` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `users_verificationcodes`
--

INSERT INTO `users_verificationcodes` (`id`, `user_id`, `code`, `verification_code_expires_at`, `compare_code`, `is_reset_password`, `is_verified`, `created_at`, `updated_at`) VALUES
(82, 1, '1111', '2025-01-22 11:37:24', NULL, 0, 1, '2025-01-22 09:33:22', '2025-01-22 09:36:32');

-- --------------------------------------------------------

--
-- Table structure for table `user_addresses`
--

CREATE TABLE `user_addresses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `address_title` varchar(255) NOT NULL,
  `main_address` tinyint(1) NOT NULL DEFAULT 0,
  `first_name` varchar(255) NOT NULL,
  `family_name` varchar(255) NOT NULL,
  `phone_number` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `country_id` bigint(20) UNSIGNED NOT NULL,
  `city_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_addresses`
--

INSERT INTO `user_addresses` (`id`, `address_title`, `main_address`, `first_name`, `family_name`, `phone_number`, `address`, `user_id`, `country_id`, `city_id`) VALUES
(15, 'العنوان الأساسي', 1, 'mohamed', 'gamal', '052222222', 'El mansura street', 1, 178, 3088),
(16, '15 شارع السلام', 0, 'mohamed', 'gamal', '0522222222', 'القاهرة الجديدة', 1, 178, 3088);

-- --------------------------------------------------------

--
-- Table structure for table `user_discount_codes`
--

CREATE TABLE `user_discount_codes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `wishlist_products_guest`
--

CREATE TABLE `wishlist_products_guest` (
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `guest_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `wishlist_products_user`
--

CREATE TABLE `wishlist_products_user` (
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `admins_email_unique` (`email`);

--
-- Indexes for table `admin_rule`
--
ALTER TABLE `admin_rule`
  ADD PRIMARY KEY (`rule_id`,`admin_id`),
  ADD KEY `admin_rule_admin_id_foreign` (`admin_id`);

--
-- Indexes for table `advertisements`
--
ALTER TABLE `advertisements`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bulk_orders`
--
ALTER TABLE `bulk_orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `carts`
--
ALTER TABLE `carts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `carts_user_id_foreign` (`user_id`),
  ADD KEY `carts_product_id_foreign` (`product_id`),
  ADD KEY `carts_color_id_foreign` (`color_id`),
  ADD KEY `carts_guest_id_foreign` (`guest_id`);

--
-- Indexes for table `cart_item_choices`
--
ALTER TABLE `cart_item_choices`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `category_choices`
--
ALTER TABLE `category_choices`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_choices_choice_id_foreign` (`choice_id`),
  ADD KEY `category_choices_main_category_id_foreign` (`main_category_id`);

--
-- Indexes for table `choices`
--
ALTER TABLE `choices`
  ADD PRIMARY KEY (`id`),
  ADD KEY `choice_parent_id` (`parent_id`);

--
-- Indexes for table `choices_products`
--
ALTER TABLE `choices_products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `choices_products_choice_id_foreign` (`choice_id`),
  ADD KEY `choices_products_product_id_foreign` (`product_id`);

--
-- Indexes for table `cities`
--
ALTER TABLE `cities`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cities_country_id_foreign` (`country_id`);

--
-- Indexes for table `colors`
--
ALTER TABLE `colors`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `color_product`
--
ALTER TABLE `color_product`
  ADD PRIMARY KEY (`id`),
  ADD KEY `table_color_product_product_id_foreign` (`product_id`),
  ADD KEY `table_color_product_color_id_foreign` (`color_id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `comments_user_id_foreign` (`user_id`),
  ADD KEY `comments_product_id_foreign` (`product_id`);

--
-- Indexes for table `common_questions`
--
ALTER TABLE `common_questions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `companies`
--
ALTER TABLE `companies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contact_us`
--
ALTER TABLE `contact_us`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cookie_discount_ids`
--
ALTER TABLE `cookie_discount_ids`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cookie_discount_ids_discount_id_foreign` (`discount_id`);

--
-- Indexes for table `countries`
--
ALTER TABLE `countries`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `countries_code_unique` (`code`);

--
-- Indexes for table `currencies`
--
ALTER TABLE `currencies`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `currencies_name_unique` (`name`),
  ADD UNIQUE KEY `currencies_code_unique` (`code`);

--
-- Indexes for table `designs`
--
ALTER TABLE `designs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `discount_codes`
--
ALTER TABLE `discount_codes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `discount_codes_code_unique` (`code`);

--
-- Indexes for table `discount_code_product`
--
ALTER TABLE `discount_code_product`
  ADD PRIMARY KEY (`id`),
  ADD KEY `discount_code_product_product_id_foreign` (`product_id`),
  ADD KEY `discount_code_product_discount_code_id_foreign` (`discount_code_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `forget_passwords`
--
ALTER TABLE `forget_passwords`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `forget_passwords_code_unique` (`code`),
  ADD KEY `forget_passwords_user_id_foreign` (`user_id`);

--
-- Indexes for table `guests`
--
ALTER TABLE `guests`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `guests_email_unique` (`email`);

--
-- Indexes for table `header_banners`
--
ALTER TABLE `header_banners`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `header_texts`
--
ALTER TABLE `header_texts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `main_categories`
--
ALTER TABLE `main_categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`),
  ADD KEY `category_parent_id` (`parent_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifications_notifiable_type_notifiable_id_index` (`notifiable_type`,`notifiable_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `orders_number_unique` (`number`),
  ADD KEY `orders_user_id_foreign` (`user_id`),
  ADD KEY `orders_order_status_id_foreign` (`order_status_id`),
  ADD KEY `orders_guest_id_goreign` (`guest_id`);

--
-- Indexes for table `order_addresses`
--
ALTER TABLE `order_addresses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_addresses_order_id_foreign` (`order_id`),
  ADD KEY `order_addresses_city_id_foreign` (`city_id`),
  ADD KEY `order_addresses_country_id_foreign` (`country_id`);

--
-- Indexes for table `order_choices`
--
ALTER TABLE `order_choices`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_choices_order_id_foreign` (`order_id`),
  ADD KEY `order_choices_choice_id_foreign` (`choice_id`),
  ADD KEY `order_choices_sub_choice_id_foreign` (`sub_choice_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `order_items_order_id_product_id_unique` (`order_id`,`product_id`),
  ADD KEY `order_items_product_id_foreign` (`product_id`);

--
-- Indexes for table `order_item_choices`
--
ALTER TABLE `order_item_choices`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_item_choices_order_item_id_foreign` (`order_item_id`),
  ADD KEY `order_item_choices_choice_id_foreign` (`choice_id`);

--
-- Indexes for table `order_statuses`
--
ALTER TABLE `order_statuses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`),
  ADD KEY `products_category_id_foreign` (`category_id`),
  ADD KEY `products_first_subcategory_id_foreign` (`company_id`),
  ADD KEY `products_main_category_setting_id_foreign` (`main_category_setting_id`),
  ADD KEY `products_product_availability_id_foreign` (`product_availability_id`),
  ADD KEY `id` (`id`);

--
-- Indexes for table `product_availabilities`
--
ALTER TABLE `product_availabilities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_features`
--
ALTER TABLE `product_features`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_features_product_id_foreign` (`product_id`);

--
-- Indexes for table `product_images`
--
ALTER TABLE `product_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_images_product_id_foreign` (`product_id`);

--
-- Indexes for table `product_user`
--
ALTER TABLE `product_user`
  ADD PRIMARY KEY (`product_id`,`user_id`),
  ADD KEY `product_user_user_id_foreign` (`user_id`);

--
-- Indexes for table `representatives_orders`
--
ALTER TABLE `representatives_orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `return_products`
--
ALTER TABLE `return_products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `return_products_user_id_foreign` (`user_id`),
  ADD KEY `return_products_product_id_foreign` (`product_id`),
  ADD KEY `return_products_guest_foreign` (`guest_id`);

--
-- Indexes for table `rules`
--
ALTER TABLE `rules`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rule_abilities`
--
ALTER TABLE `rule_abilities`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `rule_abilities_rule_id_ability_unique` (`rule_id`,`ability`);

--
-- Indexes for table `send_news_to_users`
--
ALTER TABLE `send_news_to_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`subscription_email`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `shipping_types_and_price`
--
ALTER TABLE `shipping_types_and_price`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `store_featuers`
--
ALTER TABLE `store_featuers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `users_default_currency_foreign` (`default_currency`);

--
-- Indexes for table `users_verificationcodes`
--
ALTER TABLE `users_verificationcodes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_relation` (`user_id`);

--
-- Indexes for table `user_addresses`
--
ALTER TABLE `user_addresses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_addresses_user_id_foreign` (`user_id`),
  ADD KEY `user_addresses_country_id_foreign` (`country_id`),
  ADD KEY `user_addresses_city_id_foreign` (`city_id`);

--
-- Indexes for table `user_discount_codes`
--
ALTER TABLE `user_discount_codes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `wishlist_products_guest`
--
ALTER TABLE `wishlist_products_guest`
  ADD PRIMARY KEY (`product_id`,`guest_id`),
  ADD KEY `wishlist_products_guest_guest_id_foreign` (`guest_id`);

--
-- Indexes for table `wishlist_products_user`
--
ALTER TABLE `wishlist_products_user`
  ADD PRIMARY KEY (`product_id`,`user_id`),
  ADD KEY `wishlist_products_user_user_id_foreign` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `advertisements`
--
ALTER TABLE `advertisements`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `bulk_orders`
--
ALTER TABLE `bulk_orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `cart_item_choices`
--
ALTER TABLE `cart_item_choices`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `category_choices`
--
ALTER TABLE `category_choices`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `choices`
--
ALTER TABLE `choices`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `choices_products`
--
ALTER TABLE `choices_products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `cities`
--
ALTER TABLE `cities`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3893;

--
-- AUTO_INCREMENT for table `colors`
--
ALTER TABLE `colors`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `color_product`
--
ALTER TABLE `color_product`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `common_questions`
--
ALTER TABLE `common_questions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `companies`
--
ALTER TABLE `companies`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `contact_us`
--
ALTER TABLE `contact_us`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `cookie_discount_ids`
--
ALTER TABLE `cookie_discount_ids`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=187;

--
-- AUTO_INCREMENT for table `countries`
--
ALTER TABLE `countries`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=232;

--
-- AUTO_INCREMENT for table `currencies`
--
ALTER TABLE `currencies`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=210;

--
-- AUTO_INCREMENT for table `designs`
--
ALTER TABLE `designs`
  MODIFY `id` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `discount_codes`
--
ALTER TABLE `discount_codes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `discount_code_product`
--
ALTER TABLE `discount_code_product`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `forget_passwords`
--
ALTER TABLE `forget_passwords`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `guests`
--
ALTER TABLE `guests`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `header_banners`
--
ALTER TABLE `header_banners`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT for table `header_texts`
--
ALTER TABLE `header_texts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `main_categories`
--
ALTER TABLE `main_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=81;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT for table `order_addresses`
--
ALTER TABLE `order_addresses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT for table `order_choices`
--
ALTER TABLE `order_choices`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

--
-- AUTO_INCREMENT for table `order_item_choices`
--
ALTER TABLE `order_item_choices`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `order_statuses`
--
ALTER TABLE `order_statuses`
  MODIFY `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `pages`
--
ALTER TABLE `pages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `product_availabilities`
--
ALTER TABLE `product_availabilities`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `product_features`
--
ALTER TABLE `product_features`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `product_images`
--
ALTER TABLE `product_images`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `representatives_orders`
--
ALTER TABLE `representatives_orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `return_products`
--
ALTER TABLE `return_products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rules`
--
ALTER TABLE `rules`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `rule_abilities`
--
ALTER TABLE `rule_abilities`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=500;

--
-- AUTO_INCREMENT for table `send_news_to_users`
--
ALTER TABLE `send_news_to_users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `shipping_types_and_price`
--
ALTER TABLE `shipping_types_and_price`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `store_featuers`
--
ALTER TABLE `store_featuers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users_verificationcodes`
--
ALTER TABLE `users_verificationcodes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=83;

--
-- AUTO_INCREMENT for table `user_addresses`
--
ALTER TABLE `user_addresses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `user_discount_codes`
--
ALTER TABLE `user_discount_codes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `admin_rule`
--
ALTER TABLE `admin_rule`
  ADD CONSTRAINT `admin_rule_admin_id_foreign` FOREIGN KEY (`admin_id`) REFERENCES `admins` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `admin_rule_rule_id_foreign` FOREIGN KEY (`rule_id`) REFERENCES `rules` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `carts`
--
ALTER TABLE `carts`
  ADD CONSTRAINT `carts_color_id_foreign` FOREIGN KEY (`color_id`) REFERENCES `colors` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `carts_guest_id_foreign` FOREIGN KEY (`guest_id`) REFERENCES `guests` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `carts_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `carts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `category_choices`
--
ALTER TABLE `category_choices`
  ADD CONSTRAINT `category_choices_choice_id_foreign` FOREIGN KEY (`choice_id`) REFERENCES `choices` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `category_choices_main_category_id_foreign` FOREIGN KEY (`main_category_id`) REFERENCES `main_categories` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `choices`
--
ALTER TABLE `choices`
  ADD CONSTRAINT `choice_parent_id` FOREIGN KEY (`parent_id`) REFERENCES `choices` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `choices_products`
--
ALTER TABLE `choices_products`
  ADD CONSTRAINT `choices_products_choice_id_foreign` FOREIGN KEY (`choice_id`) REFERENCES `choices` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `choices_products_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `cities`
--
ALTER TABLE `cities`
  ADD CONSTRAINT `cities_country_id_foreign` FOREIGN KEY (`country_id`) REFERENCES `countries` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `color_product`
--
ALTER TABLE `color_product`
  ADD CONSTRAINT `table_color_product_color_id_foreign` FOREIGN KEY (`color_id`) REFERENCES `colors` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `table_color_product_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `comments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `cookie_discount_ids`
--
ALTER TABLE `cookie_discount_ids`
  ADD CONSTRAINT `cookie_discount_ids_discount_id_foreign` FOREIGN KEY (`discount_id`) REFERENCES `discount_codes` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `discount_code_product`
--
ALTER TABLE `discount_code_product`
  ADD CONSTRAINT `discount_code_product_discount_code_id_foreign` FOREIGN KEY (`discount_code_id`) REFERENCES `discount_codes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `discount_code_product_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `forget_passwords`
--
ALTER TABLE `forget_passwords`
  ADD CONSTRAINT `forget_passwords_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `main_categories`
--
ALTER TABLE `main_categories`
  ADD CONSTRAINT `category_parent_id` FOREIGN KEY (`parent_id`) REFERENCES `main_categories` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_guest_id_goreign` FOREIGN KEY (`guest_id`) REFERENCES `guests` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `orders_order_status_id_foreign` FOREIGN KEY (`order_status_id`) REFERENCES `order_statuses` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `order_addresses`
--
ALTER TABLE `order_addresses`
  ADD CONSTRAINT `order_addresses_city_id_foreign` FOREIGN KEY (`city_id`) REFERENCES `cities` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `order_addresses_country_id_foreign` FOREIGN KEY (`country_id`) REFERENCES `countries` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `order_addresses_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `order_choices`
--
ALTER TABLE `order_choices`
  ADD CONSTRAINT `order_choices_choice_id_foreign` FOREIGN KEY (`choice_id`) REFERENCES `choices` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_choices_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_choices_sub_choice_id_foreign` FOREIGN KEY (`sub_choice_id`) REFERENCES `choices` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `order_item_choices`
--
ALTER TABLE `order_item_choices`
  ADD CONSTRAINT `order_item_choices_choice_id_foreign` FOREIGN KEY (`choice_id`) REFERENCES `choices` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_item_choices_order_item_id_foreign` FOREIGN KEY (`order_item_id`) REFERENCES `order_items` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `main_categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `products_companies_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `products_product_availability_id_foreign` FOREIGN KEY (`product_availability_id`) REFERENCES `product_availabilities` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `product_features`
--
ALTER TABLE `product_features`
  ADD CONSTRAINT `product_features_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `product_images`
--
ALTER TABLE `product_images`
  ADD CONSTRAINT `product_images_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `product_user`
--
ALTER TABLE `product_user`
  ADD CONSTRAINT `product_user_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `product_user_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `return_products`
--
ALTER TABLE `return_products`
  ADD CONSTRAINT `return_products_guest_foreign` FOREIGN KEY (`guest_id`) REFERENCES `guests` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `return_products_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `return_products_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `rule_abilities`
--
ALTER TABLE `rule_abilities`
  ADD CONSTRAINT `rule_abilities_rule_id_foreign` FOREIGN KEY (`rule_id`) REFERENCES `rules` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_default_currency_foreign` FOREIGN KEY (`default_currency`) REFERENCES `currencies` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `users_verificationcodes`
--
ALTER TABLE `users_verificationcodes`
  ADD CONSTRAINT `user_relation` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_addresses`
--
ALTER TABLE `user_addresses`
  ADD CONSTRAINT `user_addresses_city_id_foreign` FOREIGN KEY (`city_id`) REFERENCES `cities` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_addresses_country_id_foreign` FOREIGN KEY (`country_id`) REFERENCES `countries` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_addresses_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `wishlist_products_guest`
--
ALTER TABLE `wishlist_products_guest`
  ADD CONSTRAINT `wishlist_products_guest_guest_id_foreign` FOREIGN KEY (`guest_id`) REFERENCES `guests` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `wishlist_products_guest_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `wishlist_products_user`
--
ALTER TABLE `wishlist_products_user`
  ADD CONSTRAINT `wishlist_products_user_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `wishlist_products_user_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
