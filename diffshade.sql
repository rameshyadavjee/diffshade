-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Oct 08, 2024 at 12:12 PM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `diffshade`
--

-- --------------------------------------------------------

--
-- Table structure for table `differenceshading`
--

CREATE TABLE `differenceshading` (
  `id` int NOT NULL,
  `jobcard_no` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `dept` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `original_image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `uploaded_by` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `differenceshading`
--

INSERT INTO `differenceshading` (`id`, `jobcard_no`, `dept`, `original_image`, `uploaded_by`, `created_at`, `updated_at`) VALUES
(7, 'D-09gds', 'Folded Cartoon', 'original.jpg', '1-Ramesh Yadav', '2024-07-17 06:25:45', '2024-07-17 06:25:45'),
(8, 'C-8655', 'Corrugation', 'original.jpg', '1-Ramesh Yadav', '2024-08-03 03:03:52', '2024-08-03 03:03:52'),
(9, 'F-5684', 'Corrugation', 'original.jpg', '1-Ramesh Yadav', '2024-08-03 03:18:41', '2024-08-03 03:18:41'),
(10, 'A-0001', 'Folded Cartoon', 'original.jpg', '1-Ramesh Yadav', '2024-09-18 02:15:50', '2024-09-18 02:15:50');

-- --------------------------------------------------------

--
-- Table structure for table `diffshadedetail`
--

CREATE TABLE `diffshadedetail` (
  `id` int NOT NULL,
  `jobcard_no` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `uploaded_image` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `output_image` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `accuracy` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_by` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `diffshadedetail`
--

INSERT INTO `diffshadedetail` (`id`, `jobcard_no`, `uploaded_image`, `output_image`, `accuracy`, `created_by`, `created_at`, `updated_at`) VALUES
(175, 'D-09gds', '2024-08-30_11-16-58.jpg', 'JOB_20240830_164702.jpg', '0.9306868249656367', '1-Ramesh Yadav', '2024-08-30 05:46:58', '2024-08-30 05:46:58'),
(176, 'C-8655', '2024-08-30_11-17-33.jpg', 'JOB_20240830_164735.jpg', '', '1-Ramesh Yadav', '2024-08-30 05:47:33', '2024-08-30 05:47:33'),
(177, 'C-8655', '2024-08-30_11-17-53.jpg', 'JOB_20240830_164832.jpg', '0.9986652869722982', '1-Ramesh Yadav', '2024-08-30 05:47:53', '2024-08-30 05:47:53'),
(178, 'F-5684', '2024-08-30_11-19-45.jpg', 'JOB_20240830_164948.jpg', '', '1-Ramesh Yadav', '2024-08-30 05:49:45', '2024-08-30 05:49:45'),
(179, 'F-5684', '2024-08-30_12-11-59.jpg', 'JOB_20240830_174206.jpg', '0.9766360043112702', '1-Ramesh Yadav', '2024-08-30 06:41:59', '2024-08-30 06:41:59'),
(263, 'A-0001', '20241001_161422.jpg', '20241001_161421.jpg', '0.9177602233714632', '1-Ramesh', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
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
-- Table structure for table `migrations`
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
(3, '2014_10_12_100000_create_password_resets_table', 1),
(4, '2019_08_19_000000_create_failed_jobs_table', 1),
(5, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(6, '2024_07_12_092303_laratrust_setup_tables', 2);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `display_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `display_name`, `description`, `created_at`, `updated_at`) VALUES
(1, 'users-create', 'Create Users', 'Create Users', '2024-07-12 05:44:18', '2024-07-12 05:44:18'),
(2, 'users-read', 'Read Users', 'Read Users', '2024-07-12 05:44:18', '2024-07-12 05:44:18'),
(3, 'users-update', 'Update Users', 'Update Users', '2024-07-12 05:44:18', '2024-07-12 05:44:18'),
(4, 'users-delete', 'Delete Users', 'Delete Users', '2024-07-12 05:44:18', '2024-07-12 05:44:18'),
(5, 'payments-create', 'Create Payments', 'Create Payments', '2024-07-12 05:44:18', '2024-07-12 05:44:18'),
(6, 'payments-read', 'Read Payments', 'Read Payments', '2024-07-12 05:44:18', '2024-07-12 05:44:18'),
(7, 'payments-update', 'Update Payments', 'Update Payments', '2024-07-12 05:44:18', '2024-07-12 05:44:18'),
(8, 'payments-delete', 'Delete Payments', 'Delete Payments', '2024-07-12 05:44:18', '2024-07-12 05:44:18'),
(9, 'profile-read', 'Read Profile', 'Read Profile', '2024-07-12 05:44:18', '2024-07-12 05:44:18'),
(10, 'profile-update', 'Update Profile', 'Update Profile', '2024-07-12 05:44:18', '2024-07-12 05:44:18'),
(11, 'module_1_name-create', 'Create Module_1_name', 'Create Module_1_name', '2024-07-12 05:44:18', '2024-07-12 05:44:18'),
(12, 'module_1_name-read', 'Read Module_1_name', 'Read Module_1_name', '2024-07-12 05:44:18', '2024-07-12 05:44:18'),
(13, 'module_1_name-update', 'Update Module_1_name', 'Update Module_1_name', '2024-07-12 05:44:18', '2024-07-12 05:44:18'),
(14, 'module_1_name-delete', 'Delete Module_1_name', 'Delete Module_1_name', '2024-07-12 05:44:18', '2024-07-12 05:44:18');

-- --------------------------------------------------------

--
-- Table structure for table `permission_role`
--

CREATE TABLE `permission_role` (
  `permission_id` bigint UNSIGNED NOT NULL,
  `role_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permission_role`
--

INSERT INTO `permission_role` (`permission_id`, `role_id`) VALUES
(1, 1),
(2, 1),
(3, 1),
(4, 1),
(5, 1),
(6, 1),
(7, 1),
(8, 1),
(9, 1),
(10, 1),
(1, 2),
(2, 2),
(3, 2),
(4, 2),
(9, 2),
(10, 2),
(9, 3),
(10, 3),
(11, 4),
(12, 4),
(13, 4),
(14, 4);

-- --------------------------------------------------------

--
-- Table structure for table `permission_user`
--

CREATE TABLE `permission_user` (
  `permission_id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `user_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
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
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `display_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `display_name`, `description`, `created_at`, `updated_at`) VALUES
(1, 'superadministrator', 'Superadministrator', 'Superadministrator', '2024-07-12 05:44:18', '2024-07-12 05:44:18'),
(2, 'administrator', 'Administrator', 'Administrator', '2024-07-12 05:44:18', '2024-07-12 05:44:18'),
(3, 'user', 'User', 'User', '2024-07-12 05:44:18', '2024-07-12 05:44:18'),
(4, 'role_name', 'Role Name', 'Role Name', '2024-07-12 05:44:18', '2024-07-12 05:44:18');

-- --------------------------------------------------------

--
-- Table structure for table `role_user`
--

CREATE TABLE `role_user` (
  `role_id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `user_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_user`
--

INSERT INTO `role_user` (`role_id`, `user_id`, `user_type`) VALUES
(1, 1, 'App\\Models\\User');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Ramesh Yadav', 'ramesh.yadav@sweetdisp.com', NULL, '$2y$10$q7tEG8tdql7SySmAVtdELuOucdN8/MOmuHv6p8BSVSEZWfpBnDtU6', 'jk0jJy8VZ3Rm17wQIbliLQC0MzOovzDIlC4ai5rqYAkfKMrQ9juzP6RQUwGF', '2024-06-11 23:42:12', '2024-06-11 23:42:12'),
(2, 'Aditya', 'mis@canpac.in', NULL, '$2y$10$H4yAbZv1yTRvbMo3O.eGjumH2tu/A/rHX7FSk2Yg39yssjapJmWMu', NULL, '2024-06-26 04:21:01', '2024-06-26 04:21:01'),
(3, 'subhash', 'subhash@canpac.in', NULL, '$2y$10$aNZ9DkK7zzTqGj2YBCU48O/xlaAS8uN6m8/Q2.MX.Ys78UMNK1WPO', NULL, '2024-06-28 05:49:36', '2024-06-28 05:49:36'),
(4, 'Dhrumil', 'dhrumil@canpac.in', NULL, '$2y$10$A7BQYOEMAOhvHE/VNBsLbOZcanHGke5jPj1x8jNTPMN6JXO.sptBS', NULL, '2024-07-02 23:53:47', '2024-07-02 23:53:47'),
(5, 'Halla Montgomery', 'gerahu@mailinator.com', NULL, '$2y$10$WyER1msgySLBnT7vlOnF9.J8dbyHPWuGqaji6D20ARzaLHcL4E37K', NULL, '2024-10-01 05:24:29', '2024-10-01 05:24:29');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `differenceshading`
--
ALTER TABLE `differenceshading`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `diffshadedetail`
--
ALTER TABLE `diffshadedetail`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_unique` (`name`);

--
-- Indexes for table `permission_role`
--
ALTER TABLE `permission_role`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `permission_role_role_id_foreign` (`role_id`);

--
-- Indexes for table `permission_user`
--
ALTER TABLE `permission_user`
  ADD PRIMARY KEY (`user_id`,`permission_id`,`user_type`),
  ADD KEY `permission_user_permission_id_foreign` (`permission_id`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_unique` (`name`);

--
-- Indexes for table `role_user`
--
ALTER TABLE `role_user`
  ADD PRIMARY KEY (`user_id`,`role_id`,`user_type`),
  ADD KEY `role_user_role_id_foreign` (`role_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `differenceshading`
--
ALTER TABLE `differenceshading`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `diffshadedetail`
--
ALTER TABLE `diffshadedetail`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=264;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `permission_role`
--
ALTER TABLE `permission_role`
  ADD CONSTRAINT `permission_role_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `permission_role_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `permission_user`
--
ALTER TABLE `permission_user`
  ADD CONSTRAINT `permission_user_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `role_user`
--
ALTER TABLE `role_user`
  ADD CONSTRAINT `role_user_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
