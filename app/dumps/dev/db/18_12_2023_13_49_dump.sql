-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: database
-- Generation Time: Dec 18, 2023 at 12:49 PM
-- Wersja serwera: 8.0.34
-- Wersja PHP: 8.1.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `swiatov`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `attachments`
--

CREATE TABLE `attachments` (
  `id` bigint UNSIGNED NOT NULL,
  `original_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `filename` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `checksum` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mimetype` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `size` varchar(8) COLLATE utf8mb4_unicode_ci NOT NULL,
  `location` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `public_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `attachment_post`
--

CREATE TABLE `attachment_post` (
  `id` bigint UNSIGNED NOT NULL,
  `attachment_id` bigint UNSIGNED NOT NULL,
  `post_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `categories`
--

CREATE TABLE `categories` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'programowanie', '2023-12-18 13:45:06', '2023-12-18 13:45:06', NULL),
(2, 'it', '2023-12-18 13:45:06', '2023-12-18 13:45:06', NULL),
(3, 'cybersec', '2023-12-18 13:45:06', '2023-12-18 13:45:06', NULL),
(4, 'lifestyle', '2023-12-18 13:45:06', '2023-12-18 13:45:06', NULL),
(5, 'rozwój', '2023-12-18 13:45:06', '2023-12-18 13:45:06', NULL);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `comments`
--

CREATE TABLE `comments` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `title` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('accepted','archived','in_trash') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `post_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `user_id`, `title`, `content`, `status`, `created_at`, `updated_at`, `post_id`) VALUES
(1, 1, 'I am to see what was coming. It was so small as this.', 'I\'m a hatter.\' Here the Dormouse shall!\' they both bowed low, and their curls got entangled together. Alice laughed so.', 'accepted', '2023-12-18 13:45:06', '2023-12-18 13:45:06', 1),
(2, 1, 'Alice angrily. \'It wasn\'t very civil of you to leave it.', 'March Hare interrupted in a trembling voice to a shriek, \'and just as I\'d taken the highest tree in front of the.', 'in_trash', '2023-12-18 13:45:06', '2023-12-18 13:45:06', 1),
(3, 1, 'Duchess\'s voice died away, even in the sand with wooden.', 'I shall remember it in a court of justice before, but she got to do,\' said Alice to herself, \'I wonder how many hours.', 'in_trash', '2023-12-18 13:45:06', '2023-12-18 13:45:06', 1),
(4, 1, 'First, she dreamed of little birds and animals that had a.', 'I used--and I don\'t remember where.\' \'Well, it must be getting home; the night-air doesn\'t suit my throat!\' and a.', 'accepted', '2023-12-18 13:45:06', '2023-12-18 13:45:06', 1),
(5, 1, 'I want to get to,\' said the Hatter: \'let\'s all move one.', 'Mock Turtle, who looked at them with the glass table and the Queen ordering off her unfortunate guests to.', 'in_trash', '2023-12-18 13:45:06', '2023-12-18 13:45:06', 1),
(6, 1, 'They all made of solid glass; there was no one to listen.', 'HIM TWO--\" why, that must be off, and found that her shoulders were nowhere to be no use in waiting by the hand, it.', 'accepted', '2023-12-18 13:45:06', '2023-12-18 13:45:06', 1),
(7, 1, 'So she swallowed one of its mouth, and addressed her in a.', 'Pigeon. \'I\'m NOT a serpent, I tell you!\' said Alice. \'And ever since that,\' the Hatter asked triumphantly. Alice did.', 'in_trash', '2023-12-18 13:45:06', '2023-12-18 13:45:06', 1),
(8, 1, 'And he added looking angrily at the Hatter, \'or you\'ll be.', 'Time as well as she passed; it was only the pepper that makes them so often, of course was, how to spell \'stupid,\' and.', 'in_trash', '2023-12-18 13:45:06', '2023-12-18 13:45:06', 1),
(9, 1, 'Footman, \'and that for two reasons. First, because I\'m on.', 'Hatter, with an important air, \'are you all ready? This is the same height as herself; and when she noticed a curious.', 'in_trash', '2023-12-18 13:45:06', '2023-12-18 13:45:06', 1),
(10, 1, 'Alice; \'I daresay it\'s a French mouse, come over with.', 'Alice alone with the next question is, Who in the middle, wondering how she would catch a bad cold if she was as much.', 'accepted', '2023-12-18 13:45:06', '2023-12-18 13:45:06', 1);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `fraud_scores`
--

CREATE TABLE `fraud_scores` (
  `id` bigint UNSIGNED NOT NULL,
  `weightable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `weightable_id` bigint UNSIGNED NOT NULL,
  `score` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `labels`
--

CREATE TABLE `labels` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_visible` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `label_ticket`
--

CREATE TABLE `label_ticket` (
  `label_id` bigint UNSIGNED NOT NULL,
  `ticket_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `lang_post`
--

CREATE TABLE `lang_post` (
  `id` bigint UNSIGNED NOT NULL,
  `post_id` bigint UNSIGNED NOT NULL,
  `langs` set('pl','en','de','it','sk','cze','sp','fr') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `lang_post`
--

INSERT INTO `lang_post` (`id`, `post_id`, `langs`, `created_at`, `updated_at`) VALUES
(1, 1, 'cze', '2023-12-18 13:45:06', '2023-12-18 13:45:06'),
(2, 1, 'en', '2023-12-18 13:45:06', '2023-12-18 13:45:06'),
(3, 1, 'sk', '2023-12-18 13:45:06', '2023-12-18 13:45:06');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `licenses`
--

CREATE TABLE `licenses` (
  `id` bigint UNSIGNED NOT NULL,
  `type` enum('standard','developer','extended') COLLATE utf8mb4_unicode_ci NOT NULL,
  `monthly_price` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `annual_price` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `license_user`
--

CREATE TABLE `license_user` (
  `id` bigint UNSIGNED NOT NULL,
  `license_id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `billing_period` enum('montly','annually') COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '0',
  `is_stopped` tinyint(1) DEFAULT NULL,
  `stopped_at` timestamp NOT NULL DEFAULT '2023-12-18 13:45:04',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `license_user_action`
--

CREATE TABLE `license_user_action` (
  `id` bigint UNSIGNED NOT NULL,
  `license_id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `action` enum('subscribed','unsubscribed') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `messages`
--

CREATE TABLE `messages` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `ticket_id` bigint UNSIGNED NOT NULL,
  `message` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2014_10_12_200000_add_two_factor_columns_to_users_table', 1),
(4, '2018_08_08_100000_create_telescope_entries_table', 1),
(5, '2019_05_03_000001_create_customer_columns', 1),
(6, '2019_05_03_000002_create_subscriptions_table', 1),
(7, '2019_05_03_000003_create_subscription_items_table', 1),
(8, '2019_08_19_000000_create_failed_jobs_table', 1),
(9, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(10, '2023_10_12_113241_create_permission_table', 1),
(11, '2023_10_12_113729_create_roles_table', 1),
(12, '2023_10_12_122103_create_model_has_permissions_table', 1),
(13, '2023_10_12_122619_create_model_has_roles_table', 1),
(14, '2023_10_12_122909_create_role_has_permissions_table', 1),
(15, '2023_10_12_132621_create_categories_table', 1),
(16, '2023_10_12_132713_create_tags_table', 1),
(17, '2023_10_12_132852_create_comments_table', 1),
(18, '2023_10_13_112613_create_posts_table', 1),
(19, '2023_10_13_113644_create_attachments_table', 1),
(20, '2023_10_13_114527_create_post_tag_table', 1),
(21, '2023_10_13_114919_create_lang_post_table', 1),
(22, '2023_10_13_115500_create_user_post_likes_table', 1),
(23, '2023_10_13_115621_create_user_post_likes_action_table', 1),
(24, '2023_10_13_132341_create_licenses_table', 1),
(25, '2023_10_13_133057_create_license_user_table', 1),
(26, '2023_10_13_133330_create_license_user_action_table', 1),
(27, '2023_10_24_083344_create_visits_table', 1),
(28, '2023_10_24_090223_create_fraud_scores_table', 1),
(29, '2023_10_24_163040_create_site_maps_table', 1),
(30, '2023_10_24_165958_add_foreign_key_to_comments_table', 1),
(31, '2023_10_25_130507_add_should_be_published_at_column_to_posts_table', 1),
(32, '2023_10_26_140807_create_sessions_table', 1),
(33, '2023_10_30_182913_create_tickets_table', 1),
(34, '2023_10_30_182914_create_messages_table', 1),
(35, '2023_10_30_182916_create_labels_table', 1),
(36, '2023_10_30_182918_create_label_ticket_table', 1),
(37, '2023_10_30_182919_add_assigned_to_column_into_tickets_table', 1),
(38, '2023_11_04_185946_create_tickets_categories_table', 1),
(39, '2023_11_06_105029_add_foreign_category_id_to_tickets_table', 1),
(40, '2023_11_12_103324_create_user_block_histories_table', 1),
(41, '2023_11_20_113953_add_lock_reason_column_to_users_table', 1),
(42, '2023_11_30_131456_create_user_account_histories_table', 1),
(43, '2023_11_30_154753_add_soft_deletes_column_to_users_table', 1),
(44, '2023_12_03_164553_create_notifications_table', 1),
(45, '2023_12_12_081637_add_unique_key_to_filename_column_in_attachments_table', 1),
(46, '2023_12_12_082847_add_public_url_column_to_attachments_table', 1),
(47, '2023_12_12_092816_add_unique_key_to_checksum_column_in_attachments_table', 1),
(48, '2023_12_17_150259_create_attachment_post_table', 1),
(49, '2023_12_18_114138_add_description_column_to_posts_table', 1);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `id` bigint UNSIGNED NOT NULL,
  `permission_id` bigint UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `id` bigint UNSIGNED NOT NULL,
  `role_id` bigint UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`id`, `role_id`, `model_type`, `model_id`, `created_at`, `updated_at`) VALUES
(1, 3, 'App\\Models\\User', 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `notifications`
--

CREATE TABLE `notifications` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_id` bigint UNSIGNED NOT NULL,
  `data` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(125) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(125) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'siteMapRestore', 'web', '2023-12-18 13:45:05', '2023-12-18 13:45:05', NULL),
(2, 'tokenDelete', 'web', '2023-12-18 13:45:05', '2023-12-18 13:45:05', NULL),
(3, 'permissionUpdate', 'web', '2023-12-18 13:45:05', '2023-12-18 13:45:05', NULL),
(4, 'tokenRead', 'web', '2023-12-18 13:45:05', '2023-12-18 13:45:05', NULL),
(5, 'licenseAssignUser', 'web', '2023-12-18 13:45:05', '2023-12-18 13:45:05', NULL),
(6, 'ticketForceDelete', 'web', '2023-12-18 13:45:05', '2023-12-18 13:45:05', NULL),
(7, 'permissionRestore', 'web', '2023-12-18 13:45:05', '2023-12-18 13:45:05', NULL),
(8, 'postCommentUpdate', 'web', '2023-12-18 13:45:05', '2023-12-18 13:45:05', NULL),
(9, 'licenseRead', 'web', '2023-12-18 13:45:05', '2023-12-18 13:45:05', NULL),
(10, 'tokenWrite', 'web', '2023-12-18 13:45:05', '2023-12-18 13:45:05', NULL),
(11, 'permissionWrite', 'web', '2023-12-18 13:45:05', '2023-12-18 13:45:05', NULL),
(12, 'postAttachmentAdd', 'web', '2023-12-18 13:45:05', '2023-12-18 13:45:05', NULL),
(13, 'permissionIndex', 'web', '2023-12-18 13:45:05', '2023-12-18 13:45:05', NULL),
(14, 'postCommentForceDelete', 'web', '2023-12-18 13:45:05', '2023-12-18 13:45:05', NULL),
(15, 'userRestore', 'web', '2023-12-18 13:45:05', '2023-12-18 13:45:05', NULL),
(16, 'postRead', 'web', '2023-12-18 13:45:05', '2023-12-18 13:45:05', NULL),
(17, 'roleForceDelete', 'web', '2023-12-18 13:45:05', '2023-12-18 13:45:05', NULL),
(18, 'postCommentRestore', 'web', '2023-12-18 13:45:05', '2023-12-18 13:45:05', NULL),
(19, 'userBlockWrite', 'web', '2023-12-18 13:45:05', '2023-12-18 13:45:05', NULL),
(20, 'postAttachmentUpdate', 'web', '2023-12-18 13:45:05', '2023-12-18 13:45:05', NULL),
(21, 'ticketIndex', 'web', '2023-12-18 13:45:05', '2023-12-18 13:45:05', NULL),
(22, 'licenseIndex', 'web', '2023-12-18 13:45:05', '2023-12-18 13:45:05', NULL),
(23, 'ticketDelete', 'web', '2023-12-18 13:45:05', '2023-12-18 13:45:05', NULL),
(24, 'roleRestore', 'web', '2023-12-18 13:45:05', '2023-12-18 13:45:05', NULL),
(25, 'siteMapUpdate', 'web', '2023-12-18 13:45:05', '2023-12-18 13:45:05', NULL),
(26, 'siteMapForceDelete', 'web', '2023-12-18 13:45:05', '2023-12-18 13:45:05', NULL),
(27, 'licenseRestore', 'web', '2023-12-18 13:45:05', '2023-12-18 13:45:05', NULL),
(28, 'roleRevokePermission', 'web', '2023-12-18 13:45:05', '2023-12-18 13:45:05', NULL),
(29, 'licenseForceDelete', 'web', '2023-12-18 13:45:05', '2023-12-18 13:45:05', NULL),
(30, 'postDelete', 'web', '2023-12-18 13:45:05', '2023-12-18 13:45:05', NULL),
(31, 'siteMapDelete', 'web', '2023-12-18 13:45:05', '2023-12-18 13:45:05', NULL),
(32, 'userRead', 'web', '2023-12-18 13:45:05', '2023-12-18 13:45:05', NULL),
(33, 'ticketRead', 'web', '2023-12-18 13:45:05', '2023-12-18 13:45:05', NULL),
(34, 'roleUpdate', 'web', '2023-12-18 13:45:05', '2023-12-18 13:45:05', NULL),
(35, 'userAssignRole', 'web', '2023-12-18 13:45:05', '2023-12-18 13:45:05', NULL),
(36, 'userRevokeRole', 'web', '2023-12-18 13:45:05', '2023-12-18 13:45:05', NULL),
(37, 'postForceDelete', 'web', '2023-12-18 13:45:05', '2023-12-18 13:45:05', NULL),
(38, 'permissionForceDelete', 'web', '2023-12-18 13:45:05', '2023-12-18 13:45:05', NULL),
(39, 'userBlockRestore', 'web', '2023-12-18 13:45:05', '2023-12-18 13:45:05', NULL),
(40, 'postAttachmentRead', 'web', '2023-12-18 13:45:05', '2023-12-18 13:45:05', NULL),
(41, 'postAttachmentDelete', 'web', '2023-12-18 13:45:05', '2023-12-18 13:45:05', NULL),
(42, 'licenseUpdate', 'web', '2023-12-18 13:45:05', '2023-12-18 13:45:05', NULL),
(43, 'postWrite', 'web', '2023-12-18 13:45:05', '2023-12-18 13:45:05', NULL),
(44, 'postIndex', 'web', '2023-12-18 13:45:05', '2023-12-18 13:45:05', NULL),
(45, 'roleRead', 'web', '2023-12-18 13:45:05', '2023-12-18 13:45:05', NULL),
(46, 'postCommentApprove', 'web', '2023-12-18 13:45:05', '2023-12-18 13:45:05', NULL),
(47, 'userWrite', 'web', '2023-12-18 13:45:05', '2023-12-18 13:45:05', NULL),
(48, 'userDelete', 'web', '2023-12-18 13:45:05', '2023-12-18 13:45:05', NULL),
(49, 'postRestore', 'web', '2023-12-18 13:45:05', '2023-12-18 13:45:05', NULL),
(50, 'postAttachmentForceDelete', 'web', '2023-12-18 13:45:05', '2023-12-18 13:45:05', NULL),
(51, 'userBlockIndex', 'web', '2023-12-18 13:45:05', '2023-12-18 13:45:05', NULL),
(52, 'permissionDelete', 'web', '2023-12-18 13:45:05', '2023-12-18 13:45:05', NULL),
(53, 'ticketUpdate', 'web', '2023-12-18 13:45:05', '2023-12-18 13:45:05', NULL),
(54, 'postCommentRead', 'web', '2023-12-18 13:45:05', '2023-12-18 13:45:05', NULL),
(55, 'userBlockDelete', 'web', '2023-12-18 13:45:05', '2023-12-18 13:45:05', NULL),
(56, 'licenseDelete', 'web', '2023-12-18 13:45:05', '2023-12-18 13:45:05', NULL),
(57, 'licenseWrite', 'web', '2023-12-18 13:45:05', '2023-12-18 13:45:05', NULL),
(58, 'roleWrite', 'web', '2023-12-18 13:45:05', '2023-12-18 13:45:05', NULL),
(59, 'postAttachmentRestore', 'web', '2023-12-18 13:45:05', '2023-12-18 13:45:05', NULL),
(60, 'tokenForceDelete', 'web', '2023-12-18 13:45:05', '2023-12-18 13:45:05', NULL),
(61, 'roleAssignPermission', 'web', '2023-12-18 13:45:05', '2023-12-18 13:45:05', NULL),
(62, 'postCommentDelete', 'web', '2023-12-18 13:45:05', '2023-12-18 13:45:05', NULL),
(63, 'ticketRestore', 'web', '2023-12-18 13:45:05', '2023-12-18 13:45:05', NULL),
(64, 'tokenIndex', 'web', '2023-12-18 13:45:05', '2023-12-18 13:45:05', NULL),
(65, 'userRevokeLicense', 'web', '2023-12-18 13:45:05', '2023-12-18 13:45:05', NULL),
(66, 'userPostLike', 'web', '2023-12-18 13:45:05', '2023-12-18 13:45:05', NULL),
(67, 'siteMapRead', 'web', '2023-12-18 13:45:05', '2023-12-18 13:45:05', NULL),
(68, 'tokenRestore', 'web', '2023-12-18 13:45:05', '2023-12-18 13:45:05', NULL),
(69, 'userBlockRead', 'web', '2023-12-18 13:45:05', '2023-12-18 13:45:05', NULL),
(70, 'roleDelete', 'web', '2023-12-18 13:45:05', '2023-12-18 13:45:05', NULL),
(71, 'ticketWrite', 'web', '2023-12-18 13:45:05', '2023-12-18 13:45:05', NULL),
(72, 'userUpdate', 'web', '2023-12-18 13:45:05', '2023-12-18 13:45:05', NULL),
(73, 'postUpdate', 'web', '2023-12-18 13:45:05', '2023-12-18 13:45:05', NULL),
(74, 'siteMapIndex', 'web', '2023-12-18 13:45:05', '2023-12-18 13:45:05', NULL),
(75, 'roleIndex', 'web', '2023-12-18 13:45:05', '2023-12-18 13:45:05', NULL),
(76, 'userIndex', 'web', '2023-12-18 13:45:05', '2023-12-18 13:45:05', NULL),
(77, 'userForceDelete', 'web', '2023-12-18 13:45:05', '2023-12-18 13:45:05', NULL),
(78, 'userBlockForceDelete', 'web', '2023-12-18 13:45:05', '2023-12-18 13:45:05', NULL),
(79, 'permissionRead', 'web', '2023-12-18 13:45:05', '2023-12-18 13:45:05', NULL),
(80, 'tokenUpdate', 'web', '2023-12-18 13:45:05', '2023-12-18 13:45:05', NULL),
(81, 'userAssignPermission', 'web', '2023-12-18 13:45:05', '2023-12-18 13:45:05', NULL),
(82, 'postCommentWrite', 'web', '2023-12-18 13:45:05', '2023-12-18 13:45:05', NULL),
(83, 'siteMapWrite', 'web', '2023-12-18 13:45:05', '2023-12-18 13:45:05', NULL);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `posts`
--

CREATE TABLE `posts` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `category_id` bigint UNSIGNED NOT NULL,
  `title` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` enum('post','event','vip') COLLATE utf8mb4_unicode_ci NOT NULL,
  `thumbnail_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `content` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('published','archived','unpublished','pending','closed') COLLATE utf8mb4_unicode_ci NOT NULL,
  `archived` tinyint(1) NOT NULL DEFAULT '0',
  `archived_at` date DEFAULT NULL,
  `published_at` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `should_be_published_at` timestamp NULL DEFAULT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `user_id`, `category_id`, `title`, `type`, `thumbnail_path`, `content`, `status`, `archived`, `archived_at`, `published_at`, `created_at`, `updated_at`, `deleted_at`, `should_be_published_at`, `description`) VALUES
(1, 1, 3, 'Turtle said: \'advance twice.', 'post', 'https://via.placeholder.com/1024x1024.png/00cc99?text=vip+ducimus', 'Gryphon. \'I\'ve forgotten the Duchess sang the second verse of the jurymen. \'It isn\'t directed at all,\' said the King and Queen of Hearts, and I never heard before, \'Sure then I\'m here! Digging for apples, yer honour!\' \'Digging for apples, indeed!\' said the Mock Turtle replied, counting off the subjects on his flappers, \'--Mystery, ancient and modern, with Seaography: then Drawling--the Drawling-master was an old conger-eel, that used to say.\' \'So he did, so he with his nose Trims his belt and his friends shared their never-ending meal, and the blades of grass, but she had finished, her sister kissed her, and the Queen\'s absence, and were resting in the pool was getting quite crowded with the bread-knife.\' The March Hare said to herself how this same little sister of hers would, in the distance, sitting sad and lonely on a crimson velvet cushion; and, last of all her riper years, the simple and loving heart of her going, though she knew she had this fit) An obstacle that came between.', 'archived', 1, '2023-12-18', NULL, '2023-12-18 13:45:06', '2023-12-18 13:45:06', NULL, NULL, NULL),
(2, 1, 4, 'When the Mouse was bristling.', 'vip', 'https://via.placeholder.com/1024x1024.png/0033cc?text=vip+ipsa', 'Alice thought), and it set to work, and very angrily. \'A knot!\' said Alice, and she went out, but it did not at all a pity. I said \"What for?\"\' \'She boxed the Queen\'s voice in the kitchen. \'When I\'M a Duchess,\' she said aloud. \'I must be really offended. \'We won\'t talk about wasting IT. It\'s HIM.\' \'I don\'t see,\' said the Hatter, it woke up again with a yelp of delight, which changed into alarm in another moment, splash! she was playing against herself, for she felt that she began thinking over other children she knew, who might do very well to say it out to sea!\" But the insolence of his teacup and bread-and-butter, and then sat upon it.) \'I\'m glad they\'ve begun asking riddles.--I believe I can listen all day about it!\' Last came a little bottle that stood near. The three soldiers wandered about for them, but they began running when they had a pencil that squeaked. This of course, to begin again, it was a dispute going on within--a constant howling and sneezing, and every now and.', 'published', 0, NULL, '2023-12-18 13:45:06', '2023-12-18 13:45:06', '2023-12-18 13:45:06', NULL, NULL, NULL),
(3, 1, 2, 'Rabbit say, \'A barrowful.', 'event', 'https://via.placeholder.com/1024x1024.png/00bb66?text=vip+tempora', 'For a minute or two, she made her feel very queer to ME.\' \'You!\' said the Duck. \'Found IT,\' the Mouse was swimming away from him, and said anxiously to herself, rather sharply; \'I advise you to leave the room, when her eye fell upon a Gryphon, lying fast asleep in the house till she fancied she heard her sentence three of the way YOU manage?\' Alice asked. \'We called him a fish)--and rapped loudly at the Lizard in head downwards, and the March Hare. \'Yes, please do!\' pleaded Alice. \'And be quick about it,\' added the Dormouse. \'Don\'t talk nonsense,\' said Alice more boldly: \'you know you\'re growing too.\' \'Yes, but some crumbs must have been was not a bit afraid of interrupting him,) \'I\'ll give him sixpence. _I_ don\'t believe it,\' said Alice. \'Anything you like,\' said the Caterpillar. \'Well, perhaps not,\' said Alice to herself, as usual. \'Come, there\'s half my plan done now! How puzzling all these changes are! I\'m never sure what I\'m going to give the hedgehog a blow with its mouth open.', 'pending', 0, NULL, NULL, '2023-12-18 13:45:06', '2023-12-18 13:45:06', NULL, NULL, NULL),
(4, 1, 1, 'THAT direction,\' the Cat.', 'vip', 'https://via.placeholder.com/1024x1024.png/00ffff?text=event+rerum', 'Allow me to introduce it.\' \'I don\'t even know what \"it\" means.\' \'I know what they\'re about!\' \'Read them,\' said the Dormouse, not choosing to notice this last remark that had made the whole pack rose up into the court, \'Bring me the truth: did you manage on the back. At last the Mouse, frowning, but very politely: \'Did you speak?\' \'Not I!\' said the young man said, \'And your hair has become very white; And yet you incessantly stand on your shoes and stockings for you now, dears? I\'m sure she\'s the best of educations--in fact, we went to school in the distance. \'And yet what a wonderful dream it had made. \'He took me for his housemaid,\' she said this, she looked back once or twice she had been all the while, till at last she spread out her hand on the same thing a bit!\' said the Dodo in an undertone to the shore, and then said \'The fourth.\' \'Two days wrong!\' sighed the Hatter. He came in with a sigh. \'I only took the hookah out of it, and found herself lying on the floor: in another.', 'closed', 0, NULL, NULL, '2023-12-18 13:45:06', '2023-12-18 13:45:06', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `post_tag`
--

CREATE TABLE `post_tag` (
  `id` bigint UNSIGNED NOT NULL,
  `post_id` bigint UNSIGNED NOT NULL,
  `tag_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `post_tag`
--

INSERT INTO `post_tag` (`id`, `post_id`, `tag_id`, `created_at`, `updated_at`) VALUES
(1, 1, 1, '2023-12-18 13:45:06', '2023-12-18 13:45:06'),
(2, 1, 2, '2023-12-18 13:45:06', '2023-12-18 13:45:06'),
(3, 1, 3, '2023-12-18 13:45:06', '2023-12-18 13:45:06');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `roles`
--

CREATE TABLE `roles` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(125) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(125) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'user', 'web', '2023-12-18 13:45:05', '2023-12-18 13:45:05', NULL),
(2, 'vipMember', 'web', '2023-12-18 13:45:05', '2023-12-18 13:45:05', NULL),
(3, 'admin', 'web', '2023-12-18 13:45:05', '2023-12-18 13:45:05', NULL),
(4, 'subAuthor', 'web', '2023-12-18 13:45:05', '2023-12-18 13:45:05', NULL),
(5, 'moderator', 'web', '2023-12-18 13:45:06', '2023-12-18 13:45:06', NULL);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint UNSIGNED NOT NULL,
  `role_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_has_permissions`
--

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(9, 1, '2023-12-18 13:45:06', '2023-12-18 13:45:06', NULL),
(42, 1, '2023-12-18 13:45:06', '2023-12-18 13:45:06', NULL),
(57, 1, '2023-12-18 13:45:06', '2023-12-18 13:45:06', NULL),
(65, 1, '2023-12-18 13:45:06', '2023-12-18 13:45:06', NULL),
(44, 1, '2023-12-18 13:45:06', '2023-12-18 13:45:06', NULL),
(16, 1, '2023-12-18 13:45:06', '2023-12-18 13:45:06', NULL),
(66, 1, '2023-12-18 13:45:06', '2023-12-18 13:45:06', NULL),
(69, 1, '2023-12-18 13:45:06', '2023-12-18 13:45:06', NULL),
(40, 1, '2023-12-18 13:45:06', '2023-12-18 13:45:06', NULL),
(54, 1, '2023-12-18 13:45:06', '2023-12-18 13:45:06', NULL),
(82, 1, '2023-12-18 13:45:06', '2023-12-18 13:45:06', NULL),
(67, 1, '2023-12-18 13:45:06', '2023-12-18 13:45:06', NULL),
(76, 3, '2023-12-18 13:45:06', '2023-12-18 13:45:06', NULL),
(32, 3, '2023-12-18 13:45:06', '2023-12-18 13:45:06', NULL),
(47, 3, '2023-12-18 13:45:06', '2023-12-18 13:45:06', NULL),
(72, 3, '2023-12-18 13:45:06', '2023-12-18 13:45:06', NULL),
(48, 3, '2023-12-18 13:45:06', '2023-12-18 13:45:06', NULL),
(15, 3, '2023-12-18 13:45:06', '2023-12-18 13:45:06', NULL),
(77, 3, '2023-12-18 13:45:06', '2023-12-18 13:45:06', NULL),
(35, 3, '2023-12-18 13:45:06', '2023-12-18 13:45:06', NULL),
(81, 3, '2023-12-18 13:45:06', '2023-12-18 13:45:06', NULL),
(36, 3, '2023-12-18 13:45:06', '2023-12-18 13:45:06', NULL),
(65, 3, '2023-12-18 13:45:06', '2023-12-18 13:45:06', NULL),
(51, 3, '2023-12-18 13:45:06', '2023-12-18 13:45:06', NULL),
(69, 3, '2023-12-18 13:45:06', '2023-12-18 13:45:06', NULL),
(19, 3, '2023-12-18 13:45:06', '2023-12-18 13:45:06', NULL),
(55, 3, '2023-12-18 13:45:06', '2023-12-18 13:45:06', NULL),
(78, 3, '2023-12-18 13:45:06', '2023-12-18 13:45:06', NULL),
(39, 3, '2023-12-18 13:45:06', '2023-12-18 13:45:06', NULL),
(66, 3, '2023-12-18 13:45:06', '2023-12-18 13:45:06', NULL),
(64, 3, '2023-12-18 13:45:06', '2023-12-18 13:45:06', NULL),
(4, 3, '2023-12-18 13:45:06', '2023-12-18 13:45:06', NULL),
(10, 3, '2023-12-18 13:45:06', '2023-12-18 13:45:06', NULL),
(80, 3, '2023-12-18 13:45:06', '2023-12-18 13:45:06', NULL),
(2, 3, '2023-12-18 13:45:06', '2023-12-18 13:45:06', NULL),
(60, 3, '2023-12-18 13:45:06', '2023-12-18 13:45:06', NULL),
(68, 3, '2023-12-18 13:45:06', '2023-12-18 13:45:06', NULL),
(21, 3, '2023-12-18 13:45:06', '2023-12-18 13:45:06', NULL),
(33, 3, '2023-12-18 13:45:06', '2023-12-18 13:45:06', NULL),
(71, 3, '2023-12-18 13:45:06', '2023-12-18 13:45:06', NULL),
(53, 3, '2023-12-18 13:45:06', '2023-12-18 13:45:06', NULL),
(23, 3, '2023-12-18 13:45:06', '2023-12-18 13:45:06', NULL),
(6, 3, '2023-12-18 13:45:06', '2023-12-18 13:45:06', NULL),
(63, 3, '2023-12-18 13:45:06', '2023-12-18 13:45:06', NULL),
(75, 3, '2023-12-18 13:45:06', '2023-12-18 13:45:06', NULL),
(45, 3, '2023-12-18 13:45:06', '2023-12-18 13:45:06', NULL),
(58, 3, '2023-12-18 13:45:06', '2023-12-18 13:45:06', NULL),
(34, 3, '2023-12-18 13:45:06', '2023-12-18 13:45:06', NULL),
(70, 3, '2023-12-18 13:45:06', '2023-12-18 13:45:06', NULL),
(24, 3, '2023-12-18 13:45:06', '2023-12-18 13:45:06', NULL),
(17, 3, '2023-12-18 13:45:06', '2023-12-18 13:45:06', NULL),
(61, 3, '2023-12-18 13:45:06', '2023-12-18 13:45:06', NULL),
(28, 3, '2023-12-18 13:45:06', '2023-12-18 13:45:06', NULL),
(13, 3, '2023-12-18 13:45:06', '2023-12-18 13:45:06', NULL),
(79, 3, '2023-12-18 13:45:06', '2023-12-18 13:45:06', NULL),
(11, 3, '2023-12-18 13:45:06', '2023-12-18 13:45:06', NULL),
(3, 3, '2023-12-18 13:45:06', '2023-12-18 13:45:06', NULL),
(52, 3, '2023-12-18 13:45:06', '2023-12-18 13:45:06', NULL),
(7, 3, '2023-12-18 13:45:06', '2023-12-18 13:45:06', NULL),
(38, 3, '2023-12-18 13:45:06', '2023-12-18 13:45:06', NULL),
(22, 3, '2023-12-18 13:45:06', '2023-12-18 13:45:06', NULL),
(9, 3, '2023-12-18 13:45:06', '2023-12-18 13:45:06', NULL),
(57, 3, '2023-12-18 13:45:06', '2023-12-18 13:45:06', NULL),
(42, 3, '2023-12-18 13:45:06', '2023-12-18 13:45:06', NULL),
(56, 3, '2023-12-18 13:45:06', '2023-12-18 13:45:06', NULL),
(27, 3, '2023-12-18 13:45:06', '2023-12-18 13:45:06', NULL),
(29, 3, '2023-12-18 13:45:06', '2023-12-18 13:45:06', NULL),
(5, 3, '2023-12-18 13:45:06', '2023-12-18 13:45:06', NULL),
(74, 3, '2023-12-18 13:45:06', '2023-12-18 13:45:06', NULL),
(67, 3, '2023-12-18 13:45:06', '2023-12-18 13:45:06', NULL),
(83, 3, '2023-12-18 13:45:06', '2023-12-18 13:45:06', NULL),
(25, 3, '2023-12-18 13:45:06', '2023-12-18 13:45:06', NULL),
(31, 3, '2023-12-18 13:45:06', '2023-12-18 13:45:06', NULL),
(1, 3, '2023-12-18 13:45:06', '2023-12-18 13:45:06', NULL),
(26, 3, '2023-12-18 13:45:06', '2023-12-18 13:45:06', NULL),
(44, 3, '2023-12-18 13:45:06', '2023-12-18 13:45:06', NULL),
(16, 3, '2023-12-18 13:45:06', '2023-12-18 13:45:06', NULL),
(43, 3, '2023-12-18 13:45:06', '2023-12-18 13:45:06', NULL),
(73, 3, '2023-12-18 13:45:06', '2023-12-18 13:45:06', NULL),
(30, 3, '2023-12-18 13:45:06', '2023-12-18 13:45:06', NULL),
(49, 3, '2023-12-18 13:45:06', '2023-12-18 13:45:06', NULL),
(37, 3, '2023-12-18 13:45:06', '2023-12-18 13:45:06', NULL),
(54, 3, '2023-12-18 13:45:06', '2023-12-18 13:45:06', NULL),
(82, 3, '2023-12-18 13:45:06', '2023-12-18 13:45:06', NULL),
(8, 3, '2023-12-18 13:45:06', '2023-12-18 13:45:06', NULL),
(46, 3, '2023-12-18 13:45:06', '2023-12-18 13:45:06', NULL),
(62, 3, '2023-12-18 13:45:06', '2023-12-18 13:45:06', NULL),
(18, 3, '2023-12-18 13:45:06', '2023-12-18 13:45:06', NULL),
(14, 3, '2023-12-18 13:45:06', '2023-12-18 13:45:06', NULL),
(40, 3, '2023-12-18 13:45:06', '2023-12-18 13:45:06', NULL),
(12, 3, '2023-12-18 13:45:06', '2023-12-18 13:45:06', NULL),
(20, 3, '2023-12-18 13:45:06', '2023-12-18 13:45:06', NULL),
(41, 3, '2023-12-18 13:45:06', '2023-12-18 13:45:06', NULL),
(59, 3, '2023-12-18 13:45:06', '2023-12-18 13:45:06', NULL),
(50, 3, '2023-12-18 13:45:06', '2023-12-18 13:45:06', NULL),
(76, 5, '2023-12-18 13:45:06', '2023-12-18 13:45:06', NULL),
(32, 5, '2023-12-18 13:45:06', '2023-12-18 13:45:06', NULL),
(47, 5, '2023-12-18 13:45:06', '2023-12-18 13:45:06', NULL),
(72, 5, '2023-12-18 13:45:06', '2023-12-18 13:45:06', NULL),
(48, 5, '2023-12-18 13:45:06', '2023-12-18 13:45:06', NULL),
(15, 5, '2023-12-18 13:45:06', '2023-12-18 13:45:06', NULL),
(77, 5, '2023-12-18 13:45:06', '2023-12-18 13:45:06', NULL),
(81, 5, '2023-12-18 13:45:06', '2023-12-18 13:45:06', NULL),
(65, 5, '2023-12-18 13:45:06', '2023-12-18 13:45:06', NULL),
(51, 5, '2023-12-18 13:45:06', '2023-12-18 13:45:06', NULL),
(69, 5, '2023-12-18 13:45:06', '2023-12-18 13:45:06', NULL),
(19, 5, '2023-12-18 13:45:06', '2023-12-18 13:45:06', NULL),
(55, 5, '2023-12-18 13:45:06', '2023-12-18 13:45:06', NULL),
(78, 5, '2023-12-18 13:45:06', '2023-12-18 13:45:06', NULL),
(39, 5, '2023-12-18 13:45:06', '2023-12-18 13:45:06', NULL),
(66, 5, '2023-12-18 13:45:06', '2023-12-18 13:45:06', NULL),
(64, 5, '2023-12-18 13:45:06', '2023-12-18 13:45:06', NULL),
(4, 5, '2023-12-18 13:45:06', '2023-12-18 13:45:06', NULL),
(80, 5, '2023-12-18 13:45:06', '2023-12-18 13:45:06', NULL),
(2, 5, '2023-12-18 13:45:06', '2023-12-18 13:45:06', NULL),
(60, 5, '2023-12-18 13:45:06', '2023-12-18 13:45:06', NULL),
(68, 5, '2023-12-18 13:45:06', '2023-12-18 13:45:06', NULL),
(21, 5, '2023-12-18 13:45:06', '2023-12-18 13:45:06', NULL),
(33, 5, '2023-12-18 13:45:06', '2023-12-18 13:45:06', NULL),
(71, 5, '2023-12-18 13:45:06', '2023-12-18 13:45:06', NULL),
(53, 5, '2023-12-18 13:45:06', '2023-12-18 13:45:06', NULL),
(23, 5, '2023-12-18 13:45:06', '2023-12-18 13:45:06', NULL),
(6, 5, '2023-12-18 13:45:06', '2023-12-18 13:45:06', NULL),
(63, 5, '2023-12-18 13:45:06', '2023-12-18 13:45:06', NULL),
(75, 5, '2023-12-18 13:45:06', '2023-12-18 13:45:06', NULL),
(45, 5, '2023-12-18 13:45:06', '2023-12-18 13:45:06', NULL),
(58, 5, '2023-12-18 13:45:06', '2023-12-18 13:45:06', NULL),
(34, 5, '2023-12-18 13:45:06', '2023-12-18 13:45:06', NULL),
(70, 5, '2023-12-18 13:45:06', '2023-12-18 13:45:06', NULL),
(24, 5, '2023-12-18 13:45:06', '2023-12-18 13:45:06', NULL),
(17, 5, '2023-12-18 13:45:06', '2023-12-18 13:45:06', NULL),
(61, 5, '2023-12-18 13:45:06', '2023-12-18 13:45:06', NULL),
(28, 5, '2023-12-18 13:45:06', '2023-12-18 13:45:06', NULL),
(13, 5, '2023-12-18 13:45:06', '2023-12-18 13:45:06', NULL),
(79, 5, '2023-12-18 13:45:06', '2023-12-18 13:45:06', NULL),
(11, 5, '2023-12-18 13:45:06', '2023-12-18 13:45:06', NULL),
(3, 5, '2023-12-18 13:45:06', '2023-12-18 13:45:06', NULL),
(52, 5, '2023-12-18 13:45:06', '2023-12-18 13:45:06', NULL),
(7, 5, '2023-12-18 13:45:06', '2023-12-18 13:45:06', NULL),
(38, 5, '2023-12-18 13:45:06', '2023-12-18 13:45:06', NULL),
(22, 5, '2023-12-18 13:45:06', '2023-12-18 13:45:06', NULL),
(9, 5, '2023-12-18 13:45:06', '2023-12-18 13:45:06', NULL),
(57, 5, '2023-12-18 13:45:06', '2023-12-18 13:45:06', NULL),
(42, 5, '2023-12-18 13:45:06', '2023-12-18 13:45:06', NULL),
(56, 5, '2023-12-18 13:45:06', '2023-12-18 13:45:06', NULL),
(27, 5, '2023-12-18 13:45:06', '2023-12-18 13:45:06', NULL),
(29, 5, '2023-12-18 13:45:06', '2023-12-18 13:45:06', NULL),
(5, 5, '2023-12-18 13:45:06', '2023-12-18 13:45:06', NULL),
(74, 5, '2023-12-18 13:45:06', '2023-12-18 13:45:06', NULL),
(67, 5, '2023-12-18 13:45:06', '2023-12-18 13:45:06', NULL),
(83, 5, '2023-12-18 13:45:06', '2023-12-18 13:45:06', NULL),
(25, 5, '2023-12-18 13:45:06', '2023-12-18 13:45:06', NULL),
(31, 5, '2023-12-18 13:45:06', '2023-12-18 13:45:06', NULL),
(1, 5, '2023-12-18 13:45:06', '2023-12-18 13:45:06', NULL),
(26, 5, '2023-12-18 13:45:06', '2023-12-18 13:45:06', NULL),
(44, 5, '2023-12-18 13:45:06', '2023-12-18 13:45:06', NULL),
(16, 5, '2023-12-18 13:45:06', '2023-12-18 13:45:06', NULL),
(43, 5, '2023-12-18 13:45:06', '2023-12-18 13:45:06', NULL),
(73, 5, '2023-12-18 13:45:06', '2023-12-18 13:45:06', NULL),
(30, 5, '2023-12-18 13:45:06', '2023-12-18 13:45:06', NULL),
(49, 5, '2023-12-18 13:45:06', '2023-12-18 13:45:06', NULL),
(37, 5, '2023-12-18 13:45:06', '2023-12-18 13:45:06', NULL),
(54, 5, '2023-12-18 13:45:06', '2023-12-18 13:45:06', NULL),
(82, 5, '2023-12-18 13:45:06', '2023-12-18 13:45:06', NULL),
(8, 5, '2023-12-18 13:45:06', '2023-12-18 13:45:06', NULL),
(46, 5, '2023-12-18 13:45:06', '2023-12-18 13:45:06', NULL),
(62, 5, '2023-12-18 13:45:06', '2023-12-18 13:45:06', NULL),
(18, 5, '2023-12-18 13:45:06', '2023-12-18 13:45:06', NULL),
(14, 5, '2023-12-18 13:45:06', '2023-12-18 13:45:06', NULL),
(40, 5, '2023-12-18 13:45:06', '2023-12-18 13:45:06', NULL),
(12, 5, '2023-12-18 13:45:06', '2023-12-18 13:45:06', NULL),
(20, 5, '2023-12-18 13:45:06', '2023-12-18 13:45:06', NULL),
(41, 5, '2023-12-18 13:45:06', '2023-12-18 13:45:06', NULL),
(59, 5, '2023-12-18 13:45:06', '2023-12-18 13:45:06', NULL),
(50, 5, '2023-12-18 13:45:06', '2023-12-18 13:45:06', NULL),
(9, 2, '2023-12-18 13:45:06', '2023-12-18 13:45:06', NULL),
(42, 2, '2023-12-18 13:45:06', '2023-12-18 13:45:06', NULL),
(57, 2, '2023-12-18 13:45:06', '2023-12-18 13:45:06', NULL),
(65, 2, '2023-12-18 13:45:06', '2023-12-18 13:45:06', NULL),
(44, 2, '2023-12-18 13:45:06', '2023-12-18 13:45:06', NULL),
(16, 2, '2023-12-18 13:45:06', '2023-12-18 13:45:06', NULL),
(66, 2, '2023-12-18 13:45:06', '2023-12-18 13:45:06', NULL),
(69, 2, '2023-12-18 13:45:06', '2023-12-18 13:45:06', NULL),
(40, 2, '2023-12-18 13:45:06', '2023-12-18 13:45:06', NULL),
(54, 2, '2023-12-18 13:45:06', '2023-12-18 13:45:06', NULL),
(82, 2, '2023-12-18 13:45:06', '2023-12-18 13:45:06', NULL),
(67, 2, '2023-12-18 13:45:06', '2023-12-18 13:45:06', NULL),
(43, 2, '2023-12-18 13:45:06', '2023-12-18 13:45:06', NULL),
(71, 2, '2023-12-18 13:45:06', '2023-12-18 13:45:06', NULL),
(33, 2, '2023-12-18 13:45:06', '2023-12-18 13:45:06', NULL),
(21, 2, '2023-12-18 13:45:06', '2023-12-18 13:45:06', NULL),
(4, 2, '2023-12-18 13:45:06', '2023-12-18 13:45:06', NULL),
(64, 2, '2023-12-18 13:45:06', '2023-12-18 13:45:06', NULL);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `site_maps`
--

CREATE TABLE `site_maps` (
  `id` bigint UNSIGNED NOT NULL,
  `location` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_modificated` date NOT NULL,
  `change_freq` enum('always','hourly','daily','weekly','monthly','yearly','never') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'monthly',
  `priority` decimal(8,2) NOT NULL DEFAULT '0.50',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `subscriptions`
--

CREATE TABLE `subscriptions` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `stripe_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `stripe_status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `stripe_price` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `quantity` int DEFAULT NULL,
  `trial_ends_at` timestamp NULL DEFAULT NULL,
  `ends_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `subscription_items`
--

CREATE TABLE `subscription_items` (
  `id` bigint UNSIGNED NOT NULL,
  `subscription_id` bigint UNSIGNED NOT NULL,
  `stripe_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `stripe_product` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `stripe_price` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `quantity` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `tags`
--

CREATE TABLE `tags` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tags`
--

INSERT INTO `tags` (`id`, `name`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'php', '2023-12-18 13:45:06', '2023-12-18 13:45:06', NULL),
(2, 'js', '2023-12-18 13:45:06', '2023-12-18 13:45:06', NULL),
(3, 'devops', '2023-12-18 13:45:06', '2023-12-18 13:45:06', NULL);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `telescope_entries`
--

CREATE TABLE `telescope_entries` (
  `sequence` bigint UNSIGNED NOT NULL,
  `uuid` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `family_hash` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `should_display_on_index` tinyint(1) NOT NULL DEFAULT '1',
  `type` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `telescope_entries`
--

INSERT INTO `telescope_entries` (`sequence`, `uuid`, `batch_id`, `family_hash`, `should_display_on_index`, `type`, `content`, `created_at`) VALUES
(1, '9ae0d019-bca4-4634-958f-26950599b5ec', '9ae0d019-c4b6-401c-8897-ac626807ae63', NULL, 1, 'command', '{\"command\":\"list\",\"exit_code\":0,\"arguments\":{\"command\":\"list\",\"namespace\":null},\"options\":{\"raw\":false,\"format\":\"txt\",\"short\":false,\"help\":false,\"quiet\":false,\"verbose\":false,\"version\":false,\"ansi\":null,\"no-interaction\":false,\"env\":null},\"hostname\":\"2babe7b598cc\"}', '2023-12-18 13:45:47'),
(2, '9ae0d03b-7398-410f-805a-e19bd68e91bd', '9ae0d03b-7a4d-407c-828d-638d6500c522', NULL, 1, 'command', '{\"command\":\"list\",\"exit_code\":0,\"arguments\":{\"command\":\"list\",\"namespace\":null},\"options\":{\"raw\":false,\"format\":\"txt\",\"short\":false,\"help\":false,\"quiet\":false,\"verbose\":false,\"version\":false,\"ansi\":null,\"no-interaction\":false,\"env\":null},\"hostname\":\"2babe7b598cc\"}', '2023-12-18 13:46:09'),
(3, '9ae0d04a-cc62-41be-b083-2c857da65617', '9ae0d04a-d304-4fec-baa6-651d6ae33462', NULL, 1, 'command', '{\"command\":\"help\",\"exit_code\":0,\"arguments\":{\"command\":\"schema:dump\",\"command_name\":\"help\"},\"options\":{\"format\":\"txt\",\"raw\":false,\"help\":true,\"quiet\":false,\"verbose\":false,\"version\":false,\"ansi\":null,\"no-interaction\":false,\"env\":null},\"hostname\":\"2babe7b598cc\"}', '2023-12-18 13:46:19'),
(4, '9ae0d0a7-48ad-48a2-a33e-34631a21f37d', '9ae0d0a7-5614-4cf9-8394-ef88831781ae', '2c9df26c95fc011b5c85440234c3f2de', 0, 'exception', '{\"class\":\"Symfony\\\\Component\\\\Process\\\\Exception\\\\ProcessFailedException\",\"file\":\"\\/var\\/www\\/vendor\\/symfony\\/process\\/Process.php\",\"line\":267,\"message\":\"The command \\\"mysqldump  --user=\\\"${:LARAVEL_LOAD_USER}\\\" --password=\\\"${:LARAVEL_LOAD_PASSWORD}\\\" --host=\\\"${:LARAVEL_LOAD_HOST}\\\" --port=\\\"${:LARAVEL_LOAD_PORT}\\\" --no-tablespaces --skip-add-locks --skip-comments --skip-set-charset --tz-utc \\\"${:LARAVEL_LOAD_DATABASE}\\\" --routines --result-file=\\\"${:LARAVEL_LOAD_PATH}\\\" --no-data\\\" failed.\\n\\nExit Code: 1(General error)\\n\\nWorking directory: \\/var\\/www\\n\\nOutput:\\n================\\n\\n\\nError Output:\\n================\\n\\u0007mysqldump: Can\'t create\\/write to file \'.\\/app\\/dumps\\/db\\/\' (Errcode: 21 \\\"Is a directory\\\")\\n\",\"context\":null,\"trace\":[{\"file\":\"\\/var\\/www\\/vendor\\/laravel\\/framework\\/src\\/Illuminate\\/Database\\/Schema\\/MySqlSchemaState.php\",\"line\":151},{\"file\":\"\\/var\\/www\\/vendor\\/laravel\\/framework\\/src\\/Illuminate\\/Database\\/Schema\\/MySqlSchemaState.php\",\"line\":160},{\"file\":\"\\/var\\/www\\/vendor\\/laravel\\/framework\\/src\\/Illuminate\\/Database\\/Schema\\/MySqlSchemaState.php\",\"line\":154},{\"file\":\"\\/var\\/www\\/vendor\\/laravel\\/framework\\/src\\/Illuminate\\/Database\\/Schema\\/MySqlSchemaState.php\",\"line\":21},{\"file\":\"\\/var\\/www\\/vendor\\/laravel\\/framework\\/src\\/Illuminate\\/Database\\/Console\\/DumpCommand.php\",\"line\":45},{\"file\":\"\\/var\\/www\\/vendor\\/laravel\\/framework\\/src\\/Illuminate\\/Container\\/BoundMethod.php\",\"line\":36},{\"file\":\"\\/var\\/www\\/vendor\\/laravel\\/framework\\/src\\/Illuminate\\/Container\\/Util.php\",\"line\":41},{\"file\":\"\\/var\\/www\\/vendor\\/laravel\\/framework\\/src\\/Illuminate\\/Container\\/BoundMethod.php\",\"line\":93},{\"file\":\"\\/var\\/www\\/vendor\\/laravel\\/framework\\/src\\/Illuminate\\/Container\\/BoundMethod.php\",\"line\":35},{\"file\":\"\\/var\\/www\\/vendor\\/laravel\\/framework\\/src\\/Illuminate\\/Container\\/Container.php\",\"line\":662},{\"file\":\"\\/var\\/www\\/vendor\\/laravel\\/framework\\/src\\/Illuminate\\/Console\\/Command.php\",\"line\":211},{\"file\":\"\\/var\\/www\\/vendor\\/symfony\\/console\\/Command\\/Command.php\",\"line\":326},{\"file\":\"\\/var\\/www\\/vendor\\/laravel\\/framework\\/src\\/Illuminate\\/Console\\/Command.php\",\"line\":180},{\"file\":\"\\/var\\/www\\/vendor\\/symfony\\/console\\/Application.php\",\"line\":1081},{\"file\":\"\\/var\\/www\\/vendor\\/symfony\\/console\\/Application.php\",\"line\":320},{\"file\":\"\\/var\\/www\\/vendor\\/symfony\\/console\\/Application.php\",\"line\":174},{\"file\":\"\\/var\\/www\\/vendor\\/laravel\\/framework\\/src\\/Illuminate\\/Foundation\\/Console\\/Kernel.php\",\"line\":201},{\"file\":\"\\/var\\/www\\/artisan\",\"line\":35}],\"line_preview\":{\"258\":\"     * @return $this\",\"259\":\"     *\",\"260\":\"     * @throws ProcessFailedException if the process didn\'t terminate successfully\",\"261\":\"     *\",\"262\":\"     * @final\",\"263\":\"     *\\/\",\"264\":\"    public function mustRun(callable $callback = null, array $env = []): static\",\"265\":\"    {\",\"266\":\"        if (0 !== $this->run($callback, $env)) {\",\"267\":\"            throw new ProcessFailedException($this);\",\"268\":\"        }\",\"269\":\"\",\"270\":\"        return $this;\",\"271\":\"    }\",\"272\":\"\",\"273\":\"    \\/**\",\"274\":\"     * Starts the process and returns after writing the input to STDIN.\",\"275\":\"     *\",\"276\":\"     * This method blocks until all STDIN data is sent to the process then it\",\"277\":\"     * returns while the process runs in the background.\"},\"hostname\":\"2babe7b598cc\",\"occurrences\":1}', '2023-12-18 13:47:19'),
(5, '9ae0d0a5-db3b-4af4-9700-f11b6b8eae4f', '9ae0d0a7-5614-4cf9-8394-ef88831781ae', NULL, 1, 'command', '{\"command\":\"schema:dump\",\"exit_code\":1,\"arguments\":{\"command\":\"schema:dump\"},\"options\":{\"database\":null,\"path\":\".\\/app\\/dumps\\/db\\/\",\"prune\":false,\"help\":false,\"quiet\":false,\"verbose\":false,\"version\":false,\"ansi\":null,\"no-interaction\":false,\"env\":null},\"hostname\":\"2babe7b598cc\"}', '2023-12-18 13:47:18'),
(6, '9ae0d0dd-a677-44e6-9f88-b6549b11a4f3', '9ae0d0dd-acd1-4ea0-b143-afb1b5158b3b', '2c9df26c95fc011b5c85440234c3f2de', 1, 'exception', '{\"class\":\"Symfony\\\\Component\\\\Process\\\\Exception\\\\ProcessFailedException\",\"file\":\"\\/var\\/www\\/vendor\\/symfony\\/process\\/Process.php\",\"line\":267,\"message\":\"The command \\\"mysqldump  --user=\\\"${:LARAVEL_LOAD_USER}\\\" --password=\\\"${:LARAVEL_LOAD_PASSWORD}\\\" --host=\\\"${:LARAVEL_LOAD_HOST}\\\" --port=\\\"${:LARAVEL_LOAD_PORT}\\\" --no-tablespaces --skip-add-locks --skip-comments --skip-set-charset --tz-utc \\\"${:LARAVEL_LOAD_DATABASE}\\\" --routines --result-file=\\\"${:LARAVEL_LOAD_PATH}\\\" --no-data\\\" failed.\\n\\nExit Code: 2(Misuse of shell builtins)\\n\\nWorking directory: \\/var\\/www\\n\\nOutput:\\n================\\n\\n\\nError Output:\\n================\\nmysqldump: Got error: 1045: \\\"Plugin caching_sha2_password could not be loaded: Error loading shared library \\/usr\\/lib\\/mariadb\\/plugin\\/caching_sha2_password.so: No such file or directory\\\" when trying to connect\\n\",\"context\":null,\"trace\":[{\"file\":\"\\/var\\/www\\/vendor\\/laravel\\/framework\\/src\\/Illuminate\\/Database\\/Schema\\/MySqlSchemaState.php\",\"line\":151},{\"file\":\"\\/var\\/www\\/vendor\\/laravel\\/framework\\/src\\/Illuminate\\/Database\\/Schema\\/MySqlSchemaState.php\",\"line\":160},{\"file\":\"\\/var\\/www\\/vendor\\/laravel\\/framework\\/src\\/Illuminate\\/Database\\/Schema\\/MySqlSchemaState.php\",\"line\":154},{\"file\":\"\\/var\\/www\\/vendor\\/laravel\\/framework\\/src\\/Illuminate\\/Database\\/Schema\\/MySqlSchemaState.php\",\"line\":21},{\"file\":\"\\/var\\/www\\/vendor\\/laravel\\/framework\\/src\\/Illuminate\\/Database\\/Console\\/DumpCommand.php\",\"line\":45},{\"file\":\"\\/var\\/www\\/vendor\\/laravel\\/framework\\/src\\/Illuminate\\/Container\\/BoundMethod.php\",\"line\":36},{\"file\":\"\\/var\\/www\\/vendor\\/laravel\\/framework\\/src\\/Illuminate\\/Container\\/Util.php\",\"line\":41},{\"file\":\"\\/var\\/www\\/vendor\\/laravel\\/framework\\/src\\/Illuminate\\/Container\\/BoundMethod.php\",\"line\":93},{\"file\":\"\\/var\\/www\\/vendor\\/laravel\\/framework\\/src\\/Illuminate\\/Container\\/BoundMethod.php\",\"line\":35},{\"file\":\"\\/var\\/www\\/vendor\\/laravel\\/framework\\/src\\/Illuminate\\/Container\\/Container.php\",\"line\":662},{\"file\":\"\\/var\\/www\\/vendor\\/laravel\\/framework\\/src\\/Illuminate\\/Console\\/Command.php\",\"line\":211},{\"file\":\"\\/var\\/www\\/vendor\\/symfony\\/console\\/Command\\/Command.php\",\"line\":326},{\"file\":\"\\/var\\/www\\/vendor\\/laravel\\/framework\\/src\\/Illuminate\\/Console\\/Command.php\",\"line\":180},{\"file\":\"\\/var\\/www\\/vendor\\/symfony\\/console\\/Application.php\",\"line\":1081},{\"file\":\"\\/var\\/www\\/vendor\\/symfony\\/console\\/Application.php\",\"line\":320},{\"file\":\"\\/var\\/www\\/vendor\\/symfony\\/console\\/Application.php\",\"line\":174},{\"file\":\"\\/var\\/www\\/vendor\\/laravel\\/framework\\/src\\/Illuminate\\/Foundation\\/Console\\/Kernel.php\",\"line\":201},{\"file\":\"\\/var\\/www\\/artisan\",\"line\":35}],\"line_preview\":{\"258\":\"     * @return $this\",\"259\":\"     *\",\"260\":\"     * @throws ProcessFailedException if the process didn\'t terminate successfully\",\"261\":\"     *\",\"262\":\"     * @final\",\"263\":\"     *\\/\",\"264\":\"    public function mustRun(callable $callback = null, array $env = []): static\",\"265\":\"    {\",\"266\":\"        if (0 !== $this->run($callback, $env)) {\",\"267\":\"            throw new ProcessFailedException($this);\",\"268\":\"        }\",\"269\":\"\",\"270\":\"        return $this;\",\"271\":\"    }\",\"272\":\"\",\"273\":\"    \\/**\",\"274\":\"     * Starts the process and returns after writing the input to STDIN.\",\"275\":\"     *\",\"276\":\"     * This method blocks until all STDIN data is sent to the process then it\",\"277\":\"     * returns while the process runs in the background.\"},\"hostname\":\"2babe7b598cc\",\"occurrences\":2}', '2023-12-18 13:47:55'),
(7, '9ae0d0dd-2e45-4a78-b1ba-23a5891f6c04', '9ae0d0dd-acd1-4ea0-b143-afb1b5158b3b', NULL, 1, 'command', '{\"command\":\"schema:dump\",\"exit_code\":1,\"arguments\":{\"command\":\"schema:dump\"},\"options\":{\"database\":null,\"path\":\".\\/app\\/dumps\\/db\\/18_12_2023_13_47_dump.sql\",\"prune\":false,\"help\":false,\"quiet\":false,\"verbose\":false,\"version\":false,\"ansi\":null,\"no-interaction\":false,\"env\":null},\"hostname\":\"2babe7b598cc\"}', '2023-12-18 13:47:55');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `telescope_entries_tags`
--

CREATE TABLE `telescope_entries_tags` (
  `entry_uuid` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tag` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `telescope_monitoring`
--

CREATE TABLE `telescope_monitoring` (
  `tag` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `tickets`
--

CREATE TABLE `tickets` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `message` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `priority` enum('low','medium','urgent') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'low',
  `status` enum('open','inReview','declined','resolved') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'open',
  `is_resolved` tinyint(1) NOT NULL DEFAULT '0',
  `is_declined` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `assigned_to` bigint UNSIGNED DEFAULT NULL,
  `category_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tickets`
--

INSERT INTO `tickets` (`id`, `uuid`, `user_id`, `title`, `message`, `priority`, `status`, `is_resolved`, `is_declined`, `created_at`, `updated_at`, `deleted_at`, `assigned_to`, `category_id`) VALUES
(1, '9273e85f-3b13-40ba-b4bb-04ae36217d7c', 1, 'Hatter. Alice felt that she was quite surprised to find that the mouse to the game, the Queen had ordered. They very soon came upon a heap of sticks and dry leaves, and the Hatter added as an.', 'Cheshire Cat,\' said Alice: \'three inches is such a simple question,\' added the Gryphon, \'you first form into a graceful zigzag, and was in the book,\' said the Mouse, frowning, but very politely.', 'low', 'open', 0, 0, '2023-12-18 13:45:06', '2023-12-18 13:45:06', NULL, NULL, 1),
(2, 'cb89a245-5196-4641-91d4-12c14ed38a96', 1, 'Duchess. An invitation for the hedgehogs; and in THAT direction,\' the Cat again, sitting on the bank--the birds with draggled feathers, the animals with their heads off?\' shouted the Queen said.', 'WOULD put their heads down and make one repeat lessons!\' thought Alice; \'but when you throw them, and he poured a little three-legged table, all made a memorandum of the court. All this time the.', 'low', 'open', 0, 0, '2023-12-18 13:45:06', '2023-12-18 13:45:06', NULL, NULL, 2),
(3, 'efe6b844-3ebe-46f9-a26e-82c6d632f8b4', 1, 'Queen till she was about a foot high: then she walked on in these words: \'Yes, we went to school in the chimney close above her: then, saying to herself, as well as she could for sneezing. There was.', 'When she got to grow here,\' said the Hatter. \'You might just as well. The twelve jurors were writing down \'stupid things!\' on their slates, \'SHE doesn\'t believe there\'s an atom of meaning in it, and.', 'low', 'open', 0, 0, '2023-12-18 13:45:06', '2023-12-18 13:45:06', NULL, NULL, 3),
(4, '42f88fc7-89ae-4bd8-bb5a-61e2d1ee8449', 1, 'I get SOMEWHERE,\' Alice added as an explanation; \'I\'ve none of them even when they passed too close, and waving their forepaws to mark the time, while the rest of the house down!\' said the White.', 'Alice, and, after folding his arms and frowning at the corners: next the ten courtiers; these were all turning into little cakes as they came nearer, Alice could hear the rattle of the trees as well.', 'low', 'open', 0, 0, '2023-12-18 13:45:06', '2023-12-18 13:45:06', NULL, NULL, 4);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `tickets__categories`
--

CREATE TABLE `tickets__categories` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tickets__categories`
--

INSERT INTO `tickets__categories` (`id`, `name`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'payment', '2023-12-18 13:45:06', '2023-12-18 13:45:06', NULL),
(2, 'account', '2023-12-18 13:45:06', '2023-12-18 13:45:06', NULL),
(3, 'bug', '2023-12-18 13:45:06', '2023-12-18 13:45:06', NULL),
(4, 'apiToken', '2023-12-18 13:45:06', '2023-12-18 13:45:06', NULL);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `two_factor_secret` text COLLATE utf8mb4_unicode_ci,
  `two_factor_recovery_codes` text COLLATE utf8mb4_unicode_ci,
  `two_factor_confirmed_at` timestamp NULL DEFAULT NULL,
  `ip` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `current_team_id` bigint UNSIGNED DEFAULT NULL,
  `status` enum('active','banned') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `last_login_at` timestamp NULL DEFAULT NULL,
  `ban_duration` enum('P1D','P1W','P1M','P1Y','forever') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `banned_at` timestamp NULL DEFAULT NULL,
  `profile_photo_path` varchar(2048) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `stripe_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pm_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pm_last_four` varchar(4) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `trial_ends_at` timestamp NULL DEFAULT NULL,
  `lock_reason` text COLLATE utf8mb4_unicode_ci,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `two_factor_secret`, `two_factor_recovery_codes`, `two_factor_confirmed_at`, `ip`, `remember_token`, `current_team_id`, `status`, `last_login_at`, `ban_duration`, `banned_at`, `profile_photo_path`, `created_at`, `updated_at`, `stripe_id`, `pm_type`, `pm_last_four`, `trial_ends_at`, `lock_reason`, `deleted_at`) VALUES
(1, 'ov', 'ov@swiat-ov.pl', '2023-12-18 13:45:05', '$2y$10$js7gyuHeQbjLjy0niujr6e.UmV9EOWdiqO0ed3GiwZoxRMdCTaBiW', NULL, NULL, NULL, '24.26.34.240', 'lW8EQ22vIG', NULL, 'active', NULL, NULL, NULL, NULL, '2023-12-18 13:45:05', '2023-12-18 13:45:05', NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `user_account_histories`
--

CREATE TABLE `user_account_histories` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `action` enum('created','edited','deleted','forceDeleted') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `user_block_histories`
--

CREATE TABLE `user_block_histories` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `action` enum('locked','unlocked') COLLATE utf8mb4_unicode_ci NOT NULL,
  `ban_duration` enum('P1D','P1W','P1M','P1Y','forever') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `user_post_likes`
--

CREATE TABLE `user_post_likes` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `post_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `user_post_likes_action`
--

CREATE TABLE `user_post_likes_action` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `post_id` bigint UNSIGNED NOT NULL,
  `action` enum('liked','disliked') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `visits`
--

CREATE TABLE `visits` (
  `id` bigint UNSIGNED NOT NULL,
  `client_ip` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lang` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `timezone` timestamp NOT NULL,
  `device_orientation` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `device_angle` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `referrer` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `width` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `height` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `local_time` timestamp NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `attachments`
--
ALTER TABLE `attachments`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `attachments_filename_unique` (`filename`),
  ADD UNIQUE KEY `attachments_checksum_unique` (`checksum`),
  ADD UNIQUE KEY `attachments_public_url_unique` (`public_url`);

--
-- Indeksy dla tabeli `attachment_post`
--
ALTER TABLE `attachment_post`
  ADD PRIMARY KEY (`id`),
  ADD KEY `attachment_post_attachment_id_foreign` (`attachment_id`),
  ADD KEY `attachment_post_post_id_foreign` (`post_id`);

--
-- Indeksy dla tabeli `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `categories_name_unique` (`name`);

--
-- Indeksy dla tabeli `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `comments_user_id_foreign` (`user_id`),
  ADD KEY `comments_post_id_foreign` (`post_id`);

--
-- Indeksy dla tabeli `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indeksy dla tabeli `fraud_scores`
--
ALTER TABLE `fraud_scores`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fraud_scores_weightable_type_weightable_id_index` (`weightable_type`,`weightable_id`);

--
-- Indeksy dla tabeli `labels`
--
ALTER TABLE `labels`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `lang_post`
--
ALTER TABLE `lang_post`
  ADD PRIMARY KEY (`id`),
  ADD KEY `lang_post_post_id_foreign` (`post_id`);

--
-- Indeksy dla tabeli `licenses`
--
ALTER TABLE `licenses`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `license_user`
--
ALTER TABLE `license_user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `license_user_license_id_foreign` (`license_id`),
  ADD KEY `license_user_user_id_foreign` (`user_id`);

--
-- Indeksy dla tabeli `license_user_action`
--
ALTER TABLE `license_user_action`
  ADD PRIMARY KEY (`id`),
  ADD KEY `license_user_action_license_id_foreign` (`license_id`),
  ADD KEY `license_user_action_user_id_foreign` (`user_id`);

--
-- Indeksy dla tabeli `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `model_has_permissions_permission_id_foreign` (`permission_id`),
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indeksy dla tabeli `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `model_has_roles_role_id_foreign` (`role_id`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indeksy dla tabeli `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifications_notifiable_type_notifiable_id_index` (`notifiable_type`,`notifiable_id`);

--
-- Indeksy dla tabeli `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indeksy dla tabeli `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indeksy dla tabeli `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indeksy dla tabeli `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `posts_title_unique` (`title`),
  ADD KEY `posts_user_id_foreign` (`user_id`),
  ADD KEY `posts_category_id_foreign` (`category_id`);

--
-- Indeksy dla tabeli `post_tag`
--
ALTER TABLE `post_tag`
  ADD PRIMARY KEY (`id`),
  ADD KEY `post_tag_post_id_foreign` (`post_id`),
  ADD KEY `post_tag_tag_id_foreign` (`tag_id`);

--
-- Indeksy dla tabeli `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indeksy dla tabeli `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD KEY `role_has_permissions_permission_id_foreign` (`permission_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indeksy dla tabeli `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indeksy dla tabeli `site_maps`
--
ALTER TABLE `site_maps`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `subscriptions`
--
ALTER TABLE `subscriptions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `subscriptions_stripe_id_unique` (`stripe_id`),
  ADD KEY `subscriptions_user_id_stripe_status_index` (`user_id`,`stripe_status`);

--
-- Indeksy dla tabeli `subscription_items`
--
ALTER TABLE `subscription_items`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `subscription_items_stripe_id_unique` (`stripe_id`),
  ADD KEY `subscription_items_subscription_id_stripe_price_index` (`subscription_id`,`stripe_price`);

--
-- Indeksy dla tabeli `tags`
--
ALTER TABLE `tags`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `tags_name_unique` (`name`);

--
-- Indeksy dla tabeli `telescope_entries`
--
ALTER TABLE `telescope_entries`
  ADD PRIMARY KEY (`sequence`),
  ADD UNIQUE KEY `telescope_entries_uuid_unique` (`uuid`),
  ADD KEY `telescope_entries_batch_id_index` (`batch_id`),
  ADD KEY `telescope_entries_family_hash_index` (`family_hash`),
  ADD KEY `telescope_entries_created_at_index` (`created_at`),
  ADD KEY `telescope_entries_type_should_display_on_index_index` (`type`,`should_display_on_index`);

--
-- Indeksy dla tabeli `telescope_entries_tags`
--
ALTER TABLE `telescope_entries_tags`
  ADD KEY `telescope_entries_tags_entry_uuid_tag_index` (`entry_uuid`,`tag`),
  ADD KEY `telescope_entries_tags_tag_index` (`tag`);

--
-- Indeksy dla tabeli `tickets`
--
ALTER TABLE `tickets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tickets_user_id_foreign` (`user_id`),
  ADD KEY `tickets_assigned_to_foreign` (`assigned_to`),
  ADD KEY `tickets_category_id_foreign` (`category_id`);

--
-- Indeksy dla tabeli `tickets__categories`
--
ALTER TABLE `tickets__categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `tickets__categories_name_unique` (`name`);

--
-- Indeksy dla tabeli `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `users_stripe_id_index` (`stripe_id`);

--
-- Indeksy dla tabeli `user_account_histories`
--
ALTER TABLE `user_account_histories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_account_histories_user_id_foreign` (`user_id`);

--
-- Indeksy dla tabeli `user_block_histories`
--
ALTER TABLE `user_block_histories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_block_histories_user_id_foreign` (`user_id`);

--
-- Indeksy dla tabeli `user_post_likes`
--
ALTER TABLE `user_post_likes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_post_likes_user_id_foreign` (`user_id`),
  ADD KEY `user_post_likes_post_id_foreign` (`post_id`);

--
-- Indeksy dla tabeli `user_post_likes_action`
--
ALTER TABLE `user_post_likes_action`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_post_likes_action_user_id_foreign` (`user_id`),
  ADD KEY `user_post_likes_action_post_id_foreign` (`post_id`);

--
-- Indeksy dla tabeli `visits`
--
ALTER TABLE `visits`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `attachments`
--
ALTER TABLE `attachments`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `attachment_post`
--
ALTER TABLE `attachment_post`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `fraud_scores`
--
ALTER TABLE `fraud_scores`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `labels`
--
ALTER TABLE `labels`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lang_post`
--
ALTER TABLE `lang_post`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `licenses`
--
ALTER TABLE `licenses`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `license_user`
--
ALTER TABLE `license_user`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `license_user_action`
--
ALTER TABLE `license_user_action`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=84;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `post_tag`
--
ALTER TABLE `post_tag`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `site_maps`
--
ALTER TABLE `site_maps`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `subscriptions`
--
ALTER TABLE `subscriptions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `subscription_items`
--
ALTER TABLE `subscription_items`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tags`
--
ALTER TABLE `tags`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `telescope_entries`
--
ALTER TABLE `telescope_entries`
  MODIFY `sequence` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tickets`
--
ALTER TABLE `tickets`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tickets__categories`
--
ALTER TABLE `tickets__categories`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `user_account_histories`
--
ALTER TABLE `user_account_histories`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_block_histories`
--
ALTER TABLE `user_block_histories`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_post_likes`
--
ALTER TABLE `user_post_likes`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_post_likes_action`
--
ALTER TABLE `user_post_likes_action`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `visits`
--
ALTER TABLE `visits`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `attachment_post`
--
ALTER TABLE `attachment_post`
  ADD CONSTRAINT `attachment_post_attachment_id_foreign` FOREIGN KEY (`attachment_id`) REFERENCES `attachments` (`id`),
  ADD CONSTRAINT `attachment_post_post_id_foreign` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`);

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_post_id_foreign` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`),
  ADD CONSTRAINT `comments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `lang_post`
--
ALTER TABLE `lang_post`
  ADD CONSTRAINT `lang_post_post_id_foreign` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`);

--
-- Constraints for table `license_user`
--
ALTER TABLE `license_user`
  ADD CONSTRAINT `license_user_license_id_foreign` FOREIGN KEY (`license_id`) REFERENCES `licenses` (`id`),
  ADD CONSTRAINT `license_user_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `license_user_action`
--
ALTER TABLE `license_user_action`
  ADD CONSTRAINT `license_user_action_license_id_foreign` FOREIGN KEY (`license_id`) REFERENCES `licenses` (`id`),
  ADD CONSTRAINT `license_user_action_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`);

--
-- Constraints for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`);

--
-- Constraints for table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `posts_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`),
  ADD CONSTRAINT `posts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `post_tag`
--
ALTER TABLE `post_tag`
  ADD CONSTRAINT `post_tag_post_id_foreign` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`),
  ADD CONSTRAINT `post_tag_tag_id_foreign` FOREIGN KEY (`tag_id`) REFERENCES `tags` (`id`);

--
-- Constraints for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`),
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`);

--
-- Constraints for table `telescope_entries_tags`
--
ALTER TABLE `telescope_entries_tags`
  ADD CONSTRAINT `telescope_entries_tags_entry_uuid_foreign` FOREIGN KEY (`entry_uuid`) REFERENCES `telescope_entries` (`uuid`) ON DELETE CASCADE;

--
-- Constraints for table `tickets`
--
ALTER TABLE `tickets`
  ADD CONSTRAINT `tickets_assigned_to_foreign` FOREIGN KEY (`assigned_to`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `tickets_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `tickets__categories` (`id`),
  ADD CONSTRAINT `tickets_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `user_account_histories`
--
ALTER TABLE `user_account_histories`
  ADD CONSTRAINT `user_account_histories_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `user_block_histories`
--
ALTER TABLE `user_block_histories`
  ADD CONSTRAINT `user_block_histories_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `user_post_likes`
--
ALTER TABLE `user_post_likes`
  ADD CONSTRAINT `user_post_likes_post_id_foreign` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`),
  ADD CONSTRAINT `user_post_likes_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `user_post_likes_action`
--
ALTER TABLE `user_post_likes_action`
  ADD CONSTRAINT `user_post_likes_action_post_id_foreign` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`),
  ADD CONSTRAINT `user_post_likes_action_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
