-- SQL para MOBELS ALEJANDRO
-- Crea todas las tablas necesarias para el e-commerce

-- TABLA: users
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL UNIQUE,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- TABLA: password_reset_tokens
CREATE TABLE IF NOT EXISTS `password_reset_tokens` (
  `email` varchar(255) NOT NULL PRIMARY KEY,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- TABLA: sessions
CREATE TABLE IF NOT EXISTS `sessions` (
  `id` varchar(255) NOT NULL PRIMARY KEY,
  `user_id` bigint unsigned NULL DEFAULT NULL,
  `ip_address` varchar(45) NULL DEFAULT NULL,
  `user_agent` text NULL DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int NOT NULL,
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- TABLA: cache
CREATE TABLE IF NOT EXISTS `cache` (
  `key` varchar(255) NOT NULL PRIMARY KEY,
  `value` mediumtext NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- TABLA: cache_locks
CREATE TABLE IF NOT EXISTS `cache_locks` (
  `key` varchar(255) NOT NULL PRIMARY KEY,
  `owner` varchar(255) NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- TABLA: jobs
CREATE TABLE IF NOT EXISTS `jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint unsigned NOT NULL,
  `reserved_at` int unsigned NULL DEFAULT NULL,
  `available_at` int unsigned NOT NULL,
  `created_at` int unsigned NOT NULL,
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- TABLA: job_batches
CREATE TABLE IF NOT EXISTS `job_batches` (
  `id` varchar(255) NOT NULL PRIMARY KEY,
  `name` varchar(255) NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext NULL DEFAULT NULL,
  `cancelled_at` int NULL DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- TABLA: failed_jobs
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `uuid` varchar(255) NOT NULL UNIQUE,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- TABLA: categories
CREATE TABLE IF NOT EXISTS `categories` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL UNIQUE,
  `description` text NULL DEFAULT NULL,
  `image` varchar(255) NULL DEFAULT NULL,
  `is_featured` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- TABLA: products
CREATE TABLE IF NOT EXISTS `products` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `category_id` bigint unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL UNIQUE,
  `sku` varchar(255) NULL DEFAULT NULL UNIQUE,
  `short_description` varchar(255) NOT NULL,
  `description` text NULL DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `stock` int unsigned NOT NULL DEFAULT 0,
  `lead_time_days` smallint unsigned NOT NULL DEFAULT 7,
  `image` varchar(255) NULL DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `is_featured` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  KEY `products_category_id_foreign` (`category_id`),
  CONSTRAINT `products_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- TABLA: product_color_variants
CREATE TABLE IF NOT EXISTS `product_color_variants` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `product_id` bigint unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `hex_color` varchar(7) NOT NULL,
  `swatch_image_path` varchar(2048) NULL DEFAULT NULL,
  `sort_order` smallint unsigned NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  UNIQUE KEY `product_color_variants_product_id_slug_unique` (`product_id`, `slug`),
  CONSTRAINT `product_color_variants_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- TABLA: product_color_variant_images
CREATE TABLE IF NOT EXISTS `product_color_variant_images` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `product_color_variant_id` bigint unsigned NOT NULL,
  `image_path` varchar(2048) NOT NULL,
  `alt_text` varchar(255) NULL DEFAULT NULL,
  `sort_order` smallint unsigned NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  KEY `product_color_variant_images_product_color_variant_id_foreign` (`product_color_variant_id`),
  CONSTRAINT `product_color_variant_images_product_color_variant_id_foreign` FOREIGN KEY (`product_color_variant_id`) REFERENCES `product_color_variants` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- TABLA: orders
CREATE TABLE IF NOT EXISTS `orders` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `user_id` bigint unsigned NULL DEFAULT NULL,
  `customer_name` varchar(255) NOT NULL,
  `customer_email` varchar(255) NOT NULL,
  `customer_phone` varchar(255) NULL DEFAULT NULL,
  `delivery_address` varchar(255) NOT NULL,
  `notes` text NULL DEFAULT NULL,
  `subtotal` decimal(10,2) NOT NULL,
  `shipping_amount` decimal(10,2) NOT NULL DEFAULT 0,
  `total` decimal(10,2) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `payment_method` varchar(255) NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  KEY `orders_user_id_foreign` (`user_id`),
  CONSTRAINT `orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- TABLA: order_items
CREATE TABLE IF NOT EXISTS `order_items` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `order_id` bigint unsigned NOT NULL,
  `product_id` bigint unsigned NULL DEFAULT NULL,
  `product_name` varchar(255) NOT NULL,
  `unit_price` decimal(10,2) NOT NULL,
  `quantity` int unsigned NOT NULL,
  `line_total` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  KEY `order_items_order_id_foreign` (`order_id`),
  KEY `order_items_product_id_foreign` (`product_id`),
  CONSTRAINT `order_items_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  CONSTRAINT `order_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- TABLA: quote_requests
CREATE TABLE IF NOT EXISTS `quote_requests` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `product_id` bigint unsigned NOT NULL,
  `customer_name` varchar(255) NOT NULL,
  `phone` varchar(40) NOT NULL,
  `email` varchar(255) NULL DEFAULT NULL,
  `city` varchar(255) NULL DEFAULT NULL,
  `project_details` text NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `responded_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  KEY `quote_requests_product_id_foreign` (`product_id`),
  CONSTRAINT `quote_requests_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
