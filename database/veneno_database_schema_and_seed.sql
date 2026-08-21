-- ==========================================================
-- Veneno Auto Care Platform - MySQL Production Database Dump
-- Domain: veneno.ae
-- Generated for cPanel phpMyAdmin One-Click Import
-- ==========================================================

SET FOREIGN_KEY_CHECKS = 0;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `loyalty_tier` varchar(255) NOT NULL DEFAULT 'Silver',
  `loyalty_points` int(11) NOT NULL DEFAULT 0,
  `address` text DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `users` (`id`, `name`, `email`, `phone`, `avatar`, `loyalty_tier`, `loyalty_points`, `address`, `notes`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
  (1, 'Dominic Toretto (Super Admin)', 'admin@venenoautocare.com', '+1 (555) 901-2000', 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=400&q=80', 'VIP Platinum', 5000, NULL, NULL, NULL, '$2y$12$rlJh9jELP.5Yshf5WUHYYOt6wvX/ZKffqq5YEc5cPH.hTkyPMvb6y', NULL, '2026-08-21 15:56:15', '2026-08-21 15:56:15'),
  (2, 'Elena Rostova (Operations Manager)', 'manager@venenoautocare.com', '+1 (555) 901-2001', 'https://images.unsplash.com/photo-1580489944761-15a19d654956?auto=format&fit=crop&w=400&q=80', 'Gold', 1200, NULL, NULL, NULL, '$2y$12$9YWs9n9VcXxFjIJ0cR4re.V93Ror2qrdvEPf3EQOIP4/0j7618FuG', NULL, '2026-08-21 15:56:16', '2026-08-21 15:56:16'),
  (3, 'Marcus Vance (Master Detailer)', 'marcus@venenoautocare.com', '+1 (555) 901-2002', 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=400&q=80', 'Gold', 850, NULL, NULL, NULL, '$2y$12$IG0wvwnTvIdZ5ejaUzzbieG20nywpH8SPhs188H1.ggrTxjBvBFGu', NULL, '2026-08-21 15:56:16', '2026-08-21 15:56:16'),
  (4, 'Alex Sterling', 'alex@example.com', '+1 (555) 234-5678', 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?auto=format&fit=crop&w=400&q=80', 'VIP Platinum', 3450, '742 Evergreen Terrace, Beverly Hills, CA 90210', NULL, NULL, '$2y$12$f.RkU.qlYbJL2cli5KAkVejJ8ej7rCGit9oSDWkDxiUc8IufuAG3C', NULL, '2026-08-21 15:56:17', '2026-08-21 15:56:17');

DROP TABLE IF EXISTS `password_reset_tokens`;
CREATE TABLE IF NOT EXISTS `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `sessions`;
CREATE TABLE IF NOT EXISTS `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `cache`;
CREATE TABLE IF NOT EXISTS `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `cache_locks`;
CREATE TABLE IF NOT EXISTS `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `jobs`;
CREATE TABLE IF NOT EXISTS `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `job_batches`;
CREATE TABLE IF NOT EXISTS `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `permissions`;
CREATE TABLE IF NOT EXISTS `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
  (1, 'view-revenue', 'web', '2026-08-21 15:56:13', '2026-08-21 15:56:13'),
  (2, 'manage-staff', 'web', '2026-08-21 15:56:13', '2026-08-21 15:56:13'),
  (3, 'edit-pricing', 'web', '2026-08-21 15:56:13', '2026-08-21 15:56:13'),
  (4, 'manage-campaigns', 'web', '2026-08-21 15:56:13', '2026-08-21 15:56:13'),
  (5, 'delete-records', 'web', '2026-08-21 15:56:13', '2026-08-21 15:56:13'),
  (6, 'update-job-status', 'web', '2026-08-21 15:56:13', '2026-08-21 15:56:13');

DROP TABLE IF EXISTS `roles`;
CREATE TABLE IF NOT EXISTS `roles` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
  (1, 'super_admin', 'web', '2026-08-21 15:56:13', '2026-08-21 15:56:13'),
  (2, 'manager', 'web', '2026-08-21 15:56:13', '2026-08-21 15:56:13'),
  (3, 'technician', 'web', '2026-08-21 15:56:13', '2026-08-21 15:56:13'),
  (4, 'receptionist', 'web', '2026-08-21 15:56:13', '2026-08-21 15:56:13'),
  (5, 'customer', 'web', '2026-08-21 15:56:13', '2026-08-21 15:56:13');

DROP TABLE IF EXISTS `model_has_permissions`;
CREATE TABLE IF NOT EXISTS `model_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL,
  PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `model_has_roles`;
CREATE TABLE IF NOT EXISTS `model_has_roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL,
  PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
  (1, 'App\\Models\\User', 1),
  (2, 'App\\Models\\User', 2),
  (3, 'App\\Models\\User', 3),
  (5, 'App\\Models\\User', 4);

DROP TABLE IF EXISTS `role_has_permissions`;
CREATE TABLE IF NOT EXISTS `role_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL,
  PRIMARY KEY (`permission_id`,`role_id`),
  KEY `role_has_permissions_role_id_foreign` (`role_id`),
  CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
  (1, 1),
  (2, 1),
  (3, 1),
  (4, 1),
  (5, 1),
  (6, 1),
  (1, 2),
  (2, 2),
  (3, 2),
  (4, 2),
  (6, 2),
  (6, 3);

DROP TABLE IF EXISTS `vehicles`;
CREATE TABLE IF NOT EXISTS `vehicles` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `make` varchar(255) NOT NULL,
  `model` varchar(255) NOT NULL,
  `year` int(11) NOT NULL DEFAULT 2024,
  `color` varchar(255) DEFAULT NULL,
  `license_plate` varchar(255) DEFAULT NULL,
  `type` enum('sedan','coupe','suv','truck','exotic') NOT NULL DEFAULT 'sedan',
  `vin` varchar(255) DEFAULT NULL,
  `condition_notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `vehicles_user_id_foreign` (`user_id`),
  CONSTRAINT `vehicles_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `vehicles` (`id`, `user_id`, `make`, `model`, `year`, `color`, `license_plate`, `type`, `vin`, `condition_notes`, `created_at`, `updated_at`) VALUES
  (1, 4, 'Porsche', '911 Turbo S', 2024, 'Guards Red', 'VEN911', 'coupe', 'WP0AB2A99NS298311', 'Minor swirl marks on rear quarter panel. Clear coat in pristine condition.', '2026-08-21 15:56:17', '2026-08-21 15:56:17'),
  (2, 4, 'Lamborghini', 'Urus Performante', 2023, 'Nero Nemesis Matte', 'URUS88', 'suv', 'ZPBUA1ZL3PLA01928', 'Matte clear coat requires dedicated matte ceramic protective formula.', '2026-08-21 15:56:17', '2026-08-21 15:56:17');

DROP TABLE IF EXISTS `service_packages`;
CREATE TABLE IF NOT EXISTS `service_packages` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `tagline` varchar(255) DEFAULT NULL,
  `slug` varchar(255) NOT NULL,
  `category` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `duration_hours` int(11) NOT NULL DEFAULT 4,
  `price_sedan` decimal(10,2) NOT NULL,
  `price_coupe` decimal(10,2) NOT NULL,
  `price_suv` decimal(10,2) NOT NULL,
  `price_truck` decimal(10,2) NOT NULL,
  `price_exotic` decimal(10,2) NOT NULL,
  `warranty` varchar(255) DEFAULT NULL,
  `badge` varchar(255) DEFAULT NULL,
  `popular` tinyint(1) NOT NULL DEFAULT 0,
  `features` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`features`)),
  `before_image` varchar(255) DEFAULT NULL,
  `after_image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `service_packages_slug_unique` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `service_packages` (`id`, `name`, `tagline`, `slug`, `category`, `description`, `duration_hours`, `price_sedan`, `price_coupe`, `price_suv`, `price_truck`, `price_exotic`, `warranty`, `badge`, `popular`, `features`, `before_image`, `after_image`, `created_at`, `updated_at`) VALUES
  (1, 'Diamond Ceramic Coating', '9H+ Multi-Layer Graphene Shield with 5-Year High-Gloss Warranty', 'ceramic-coating', 'ceramic', 'Our flagship 9H+ nano-ceramic and graphene matrix formula bonds molecularly to clear coat, providing extreme hydrophobic water contact angle (115°), UV oxidation prevention, acid rain resistance, and permanent deep mirror reflections.', 8, 799, 749, 949, 1099, 1299, '5 Years Certified Warranty', 'Most Popular', 1, '[\"Multi-stage decontamination wash & clay bar treatment\",\"Stage 1 Paint Correction to eliminate 85%+ swirls\",\"Dual layer 9H Nano-Diamond ceramic base coat\",\"Top coat ultra-slick hydrophobic topper\",\"Wheel faces & exterior glass ceramic protection\",\"IR Lamp heat cure for maximum bond density\",\"Warranty certificate & CarFax detailing registry\"]', 'https://images.unsplash.com/photo-1607860108855-64acf2078ed9?auto=format&fit=crop&w=1000&q=80', 'https://images.unsplash.com/photo-1617814076367-b759c7d7e738?auto=format&fit=crop&w=1000&q=80', '2026-08-21 15:56:17', '2026-08-21 15:56:17'),
  (2, 'Self-Healing PPF (Paint Protection Film)', 'Military-Grade 8mil Polyurethane Barrier Against Rock Chips & Scratches', 'paint-protection-film', 'ppf', 'Precision computer-cut optical clear film that self-heals swirl marks and light scratches with sun heat. Protect your front bumper, hood, fenders, and mirrors against highway gravel and road debris.', 12, 1499, 1399, 1699, 1899, 2499, '10-Year Anti-Yellowing Warranty', 'Ultimate Armor', '0', '[\"Full Front Bumper, Full Hood & Mirror Caps coverage\",\"High-gloss self-healing elastomeric polymer layer\",\"Digitally pre-cut plotters for zero razor blade contact on paint\",\"Wrapped edges for nearly invisible seamless seams\",\"Resistant to rock chips, bug splatter, and road salt\",\"Top-coated with ceramic slip layer for easy washing\"]', 'https://images.unsplash.com/photo-1552519507-da3b142c6e3d?auto=format&fit=crop&w=1000&q=80', 'https://images.unsplash.com/photo-1542282088-72c9c27ed0cd?auto=format&fit=crop&w=1000&q=80', '2026-08-21 15:56:17', '2026-08-21 15:56:17'),
  (3, 'Multi-Stage Paint Correction', 'Restores Deep Mirror Clarity & Eliminates 95% of Paint Defects', 'paint-correction', 'correction', 'Microscopic paint surface leveling utilizing rotary and dual-action polishers with diminishing abrasives to permanently eliminate spiderweb swirls, buffer holograms, deep wash scratches, and water spots.', 6, 499, 449, 599, 699, 899, 'Surface Clarity Guaranteed', 'Showroom Finish', '0', '[\"Electronic digital paint depth gauge inspection\",\"Heavy cutting micro-abrasive compound step\",\"Refining jeweling polish for maximal optical reflection\",\"Removal of bird drop etchings & hard water scaling\",\"Panel wipe IPA alcohol strip inspection under LED sunlight lamps\",\"Carnauba & synthetic sealant base sealant finish\"]', 'https://images.unsplash.com/photo-1503376780353-7e6692767b70?auto=format&fit=crop&w=1000&q=80', 'https://images.unsplash.com/photo-1502877338535-766e1452684a?auto=format&fit=crop&w=1000&q=80', '2026-08-21 15:56:17', '2026-08-21 15:56:17'),
  (4, 'Interior Master Deep Rejuvenation', 'Hospital-Grade Steam Sanitization, Leather Nourishing & Hot Water Extraction', 'interior-detailing', 'interior', 'A 360-degree interior revival that extracts deep-seated bacteria, spills, pet hair, and odors from fabrics, carpets, vents, and headliners, complemented with pH-neutral conditioner that softens and protects leather.', 4, 299, 269, 349, 399, 449, 'Anti-Stain & Freshness Guarantee', 'Best Value', 1, '[\"Pressurized 212\\u00b0F thermal steam vent & crevices extraction\",\"Heated carpet & upholstery chemical extraction\",\"Leather deep cleaning, brush scrub & lanolin conditioning\",\"Ozone generator gas odor & allergen neutralization\",\"UV matte protectant on dash, console, and door cards\",\"Streak-free crystal glass clarifying on all interior glass\"]', 'https://images.unsplash.com/photo-1583121274602-3e2820c69888?auto=format&fit=crop&w=1000&q=80', 'https://images.unsplash.com/photo-1563720223185-11003d516935?auto=format&fit=crop&w=1000&q=80', '2026-08-21 15:56:17', '2026-08-21 15:56:17'),
  (5, 'Ceramic IR Nano Window Tinting', 'Up to 98% Infrared Heat Rejection with Total UV Block', 'window-tinting', 'tinting', 'Premium ceramic nanoparticle window films that block solar energy without heat build up, keeping cabin 25°F cooler.', 3, 399, 349, 449, 479, 599, 'Lifetime Bubble & Fade Free', 'Heat Shield', '0', '[\"Computer-cut precision templates for every vehicle model\",\"99% UV-A and UV-B cancer radiation blockage\",\"Up to 94% Infrared (IR) solar heat rejection\",\"Lifetime nationwide bubble, peel & color change warranty\"]', 'https://images.unsplash.com/photo-1511919884226-fd3cad34687c?auto=format&fit=crop&w=1000&q=80', 'https://images.unsplash.com/photo-1618843479313-40f8afb4b4d8?auto=format&fit=crop&w=1000&q=80', '2026-08-21 15:56:17', '2026-08-21 15:56:17');

DROP TABLE IF EXISTS `service_addons`;
CREATE TABLE IF NOT EXISTS `service_addons` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `icon_name` varchar(255) NOT NULL DEFAULT 'Sparkles',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `service_addons` (`id`, `name`, `description`, `price`, `icon_name`, `created_at`, `updated_at`) VALUES
  (1, 'Windshield & Glass Hydrophobic Shield', '3-Year rain repellent coating on all glass surfaces', 149, 'Droplets', '2026-08-21 15:56:17', '2026-08-21 15:56:17'),
  (2, 'Wheel Off Barrel & Caliper Ceramic', 'High-temp 1200°F ceramic armor on alloy wheels and brake calipers', 299, 'Disc', '2026-08-21 15:56:17', '2026-08-21 15:56:17'),
  (3, 'Engine Bay Detail & Plastic Restoration', 'Steam degreasing, wiring harness protection & satin dress', 179, 'Sun', '2026-08-21 15:56:17', '2026-08-21 15:56:17'),
  (4, 'Leather Ceramic Barrier & Stain Guard', 'Hydrophobic breathable barrier against jean dye transfer', 199, 'Sparkles', '2026-08-21 15:56:17', '2026-08-21 15:56:17'),
  (5, 'Concierge Flatbed Pickup & Delivery', 'Enclosed luxury vehicle transportation within 50 miles', 150, 'Truck', '2026-08-21 15:56:17', '2026-08-21 15:56:17');

DROP TABLE IF EXISTS `bookings`;
CREATE TABLE IF NOT EXISTS `bookings` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `booking_code` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `customer_name` varchar(255) NOT NULL,
  `customer_email` varchar(255) NOT NULL,
  `customer_phone` varchar(255) NOT NULL,
  `vehicle_id` bigint(20) UNSIGNED DEFAULT NULL,
  `vehicle_summary` varchar(255) DEFAULT NULL,
  `service_package_id` bigint(20) UNSIGNED NOT NULL,
  `booking_date` date NOT NULL,
  `time_slot` varchar(255) NOT NULL,
  `status` enum('pending','confirmed','in_progress','polishing','curing','qc_ready','completed','cancelled') NOT NULL DEFAULT 'pending',
  `payment_status` enum('pending','partial_deposit','paid','refunded') NOT NULL DEFAULT 'pending',
  `payment_method` enum('stripe_card','apple_pay','cash_in_store','wire_transfer') NOT NULL DEFAULT 'stripe_card',
  `total_amount` decimal(10,2) NOT NULL,
  `deposit_amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `assigned_technician_id` bigint(20) UNSIGNED DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `marketing_source` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `bookings_booking_code_unique` (`booking_code`),
  KEY `bookings_user_id_foreign` (`user_id`),
  KEY `bookings_vehicle_id_foreign` (`vehicle_id`),
  KEY `bookings_service_package_id_foreign` (`service_package_id`),
  KEY `bookings_assigned_technician_id_foreign` (`assigned_technician_id`),
  CONSTRAINT `bookings_assigned_technician_id_foreign` FOREIGN KEY (`assigned_technician_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  CONSTRAINT `bookings_service_package_id_foreign` FOREIGN KEY (`service_package_id`) REFERENCES `service_packages` (`id`) ON DELETE CASCADE,
  CONSTRAINT `bookings_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  CONSTRAINT `bookings_vehicle_id_foreign` FOREIGN KEY (`vehicle_id`) REFERENCES `vehicles` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `bookings` (`id`, `booking_code`, `user_id`, `customer_name`, `customer_email`, `customer_phone`, `vehicle_id`, `vehicle_summary`, `service_package_id`, `booking_date`, `time_slot`, `status`, `payment_status`, `payment_method`, `total_amount`, `deposit_amount`, `assigned_technician_id`, `notes`, `marketing_source`, `created_at`, `updated_at`) VALUES
  (1, 'VEN-8492', 4, 'Alex Sterling', 'alex@example.com', '+1 (555) 234-5678', 1, '2024 Porsche 911 Turbo S (Coupe)', 1, '2026-08-23', '09:00 AM', 'curing', 'paid', 'stripe_card', 1197, 250, 3, 'Customer requested extra focus on front bumper and hood.', 'Google Search', '2026-08-21 15:56:17', '2026-08-21 15:56:17');

DROP TABLE IF EXISTS `booking_addon`;
CREATE TABLE IF NOT EXISTS `booking_addon` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `booking_id` bigint(20) UNSIGNED NOT NULL,
  `service_addon_id` bigint(20) UNSIGNED NOT NULL,
  `price_at_booking` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `booking_addon_booking_id_foreign` (`booking_id`),
  KEY `booking_addon_service_addon_id_foreign` (`service_addon_id`),
  CONSTRAINT `booking_addon_booking_id_foreign` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`id`) ON DELETE CASCADE,
  CONSTRAINT `booking_addon_service_addon_id_foreign` FOREIGN KEY (`service_addon_id`) REFERENCES `service_addons` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `booking_addon` (`id`, `booking_id`, `service_addon_id`, `price_at_booking`, `created_at`, `updated_at`) VALUES
  (1, 1, 1, 149, '2026-08-21 15:56:17', '2026-08-21 15:56:17'),
  (2, 1, 2, 299, '2026-08-21 15:56:17', '2026-08-21 15:56:17');

DROP TABLE IF EXISTS `booking_stages_histories`;
CREATE TABLE IF NOT EXISTS `booking_stages_histories` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `booking_id` bigint(20) UNSIGNED NOT NULL,
  `stage` varchar(255) NOT NULL,
  `notes` text DEFAULT NULL,
  `photo_url` varchar(255) DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `booking_stages_histories_booking_id_foreign` (`booking_id`),
  KEY `booking_stages_histories_created_by_foreign` (`created_by`),
  CONSTRAINT `booking_stages_histories_booking_id_foreign` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`id`) ON DELETE CASCADE,
  CONSTRAINT `booking_stages_histories_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `booking_stages_histories` (`id`, `booking_id`, `stage`, `notes`, `photo_url`, `created_by`, `created_at`, `updated_at`) VALUES
  (1, 1, 'in_progress', 'Car checked in. Iron decontamination wash and clay bar completed.', NULL, 3, '2026-08-21 15:56:17', '2026-08-21 15:56:17'),
  (2, 1, 'polishing', 'Stage 1 correction completed. Swirl reduction measured at 92%.', NULL, 3, '2026-08-21 15:56:17', '2026-08-21 15:56:17'),
  (3, 1, 'curing', 'Ceramic 9H dual layer applied. IR heat cure in progress.', NULL, 3, '2026-08-21 15:56:17', '2026-08-21 15:56:17');

DROP TABLE IF EXISTS `payments`;
CREATE TABLE IF NOT EXISTS `payments` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `booking_id` bigint(20) UNSIGNED NOT NULL,
  `stripe_session_id` varchar(255) DEFAULT NULL,
  `stripe_payment_intent_id` varchar(255) DEFAULT NULL,
  `amount` decimal(10,2) NOT NULL,
  `currency` varchar(10) NOT NULL DEFAULT 'usd',
  `payment_method` varchar(255) NOT NULL DEFAULT 'stripe_card',
  `status` varchar(255) NOT NULL DEFAULT 'authorized',
  `receipt_number` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `payments_booking_id_foreign` (`booking_id`),
  CONSTRAINT `payments_booking_id_foreign` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `payments` (`id`, `booking_id`, `stripe_session_id`, `stripe_payment_intent_id`, `amount`, `currency`, `payment_method`, `status`, `receipt_number`, `created_at`, `updated_at`) VALUES
  (1, 1, 'cs_test_veneno_911_session', 'pi_3P9veneno911_secret', 1197, 'usd', 'stripe_card', 'authorized', 'VEN-REC-90182', '2026-08-21 15:56:17', '2026-08-21 15:56:17');

DROP TABLE IF EXISTS `inquiries`;
CREATE TABLE IF NOT EXISTS `inquiries` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `customer_name` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `vehicle_details` varchar(255) DEFAULT NULL,
  `service_requested` varchar(255) DEFAULT NULL,
  `message_text` text DEFAULT NULL,
  `status` enum('new','contacted','booked','lost') NOT NULL DEFAULT 'new',
  `assigned_to` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `inquiries_assigned_to_foreign` (`assigned_to`),
  CONSTRAINT `inquiries_assigned_to_foreign` FOREIGN KEY (`assigned_to`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `inquiries` (`id`, `customer_name`, `phone`, `vehicle_details`, `service_requested`, `message_text`, `status`, `assigned_to`, `created_at`, `updated_at`) VALUES
  (1, 'Sheikh Rashid Al Mansoori', '+971 50 123 4567', '2024 Ferrari SF90 Stradale', 'Full Body Self-Healing PPF & Ceramic Coating', 'Hi Veneno team, I just received my SF90 Stradale and need full body PPF before track day. Please contact me with availability.', 'new', 1, '2026-08-21 15:56:17', '2026-08-21 15:56:17');

DROP TABLE IF EXISTS `marketing_campaigns`;
CREATE TABLE IF NOT EXISTS `marketing_campaigns` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `type` enum('email','sms','whatsapp') NOT NULL DEFAULT 'email',
  `audience` varchar(255) NOT NULL DEFAULT 'all',
  `status` enum('draft','scheduled','active','completed') NOT NULL DEFAULT 'draft',
  `scheduled_at` datetime DEFAULT NULL,
  `sent_count` int(11) NOT NULL DEFAULT 0,
  `open_rate` decimal(5,2) NOT NULL DEFAULT 0.00,
  `click_rate` decimal(5,2) NOT NULL DEFAULT 0.00,
  `conversions` int(11) NOT NULL DEFAULT 0,
  `revenue_generated` decimal(12,2) NOT NULL DEFAULT 0.00,
  `budget` decimal(10,2) NOT NULL DEFAULT 0.00,
  `discount_code` varchar(255) DEFAULT NULL,
  `body_content` longtext NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `marketing_campaigns` (`id`, `title`, `subject`, `type`, `audience`, `status`, `scheduled_at`, `sent_count`, `open_rate`, `click_rate`, `conversions`, `revenue_generated`, `budget`, `discount_code`, `body_content`, `created_at`, `updated_at`) VALUES
  (1, 'VIP Spring Graphene Protection', '✨ Your Vehicle Deserves Showroom Mirror Armor: Exclusive $150 Off', 'email', 'vip', 'active', '2026-08-18 15:56:17', 840, 52.4, 24.1, 38, 45600, 650, 'VENENO150', 'Exclusive invitation for luxury vehicle owners to refresh their hydrophobic ceramic barrier with complimentary glass protection.', '2026-08-21 15:56:17', '2026-08-21 15:56:17');

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
  (1, '0001_01_01_000000_create_users_table', 1),
  (2, '0001_01_01_000001_create_cache_table', 1),
  (3, '0001_01_01_000002_create_jobs_table', 1),
  (4, '2026_08_15_154617_create_permission_tables', 1),
  (5, '2026_08_15_160000_create_veneno_core_tables', 1);

SET FOREIGN_KEY_CHECKS = 1;
