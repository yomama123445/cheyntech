-- ============================================================
-- Cheyn Gadgets Database Schema & Initial Seed
-- For MariaDB / MySQL (HestiaCP phpMyAdmin)
-- ============================================================

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ------------------------------------------------------------
-- 1. Table: users
-- ------------------------------------------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(100) NOT NULL,
  `email` VARCHAR(150) NOT NULL UNIQUE,
  `password_hash` VARCHAR(255) NOT NULL,
  `phone` VARCHAR(30) DEFAULT NULL,
  `role` ENUM('customer', 'admin') NOT NULL DEFAULT 'customer',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ------------------------------------------------------------
-- 2. Table: products
-- ------------------------------------------------------------
DROP TABLE IF EXISTS `products`;
CREATE TABLE `products` (
  `id` VARCHAR(50) NOT NULL,
  `name` VARCHAR(150) NOT NULL,
  `category` ENUM('preowned', 'new', 'android', 'tablet') NOT NULL,
  `condition` ENUM('Brand New', 'Refurbished', 'Pre-owned') NOT NULL DEFAULT 'Pre-owned',
  `badge_class` VARCHAR(50) DEFAULT 'badge-preowned',
  `short_desc` TEXT DEFAULT NULL,
  `full_desc` TEXT DEFAULT NULL,
  `main_image` VARCHAR(255) NOT NULL,
  `specs_json` LONGTEXT DEFAULT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ------------------------------------------------------------
-- 3. Table: product_variants
-- ------------------------------------------------------------
DROP TABLE IF EXISTS `product_variants`;
CREATE TABLE `product_variants` (
  `id` VARCHAR(80) NOT NULL,
  `product_id` VARCHAR(50) NOT NULL,
  `storage` VARCHAR(20) NOT NULL,
  `color` VARCHAR(50) NOT NULL,
  `color_hex` VARCHAR(10) DEFAULT '#000000',
  `price` DECIMAL(10,2) NOT NULL,
  `stock` INT NOT NULL DEFAULT 10,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `fk_pv_product` (`product_id`),
  CONSTRAINT `fk_pv_product` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ------------------------------------------------------------
-- 4. Table: orders
-- ------------------------------------------------------------
DROP TABLE IF EXISTS `orders`;
CREATE TABLE `orders` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `order_number` VARCHAR(30) NOT NULL UNIQUE,
  `user_id` INT UNSIGNED DEFAULT NULL,
  `customer_name` VARCHAR(100) NOT NULL,
  `customer_email` VARCHAR(150) NOT NULL,
  `customer_phone` VARCHAR(30) NOT NULL,
  `fulfillment` ENUM('pickup', 'delivery') NOT NULL DEFAULT 'pickup',
  `delivery_address` TEXT DEFAULT NULL,
  `delivery_fee` DECIMAL(10,2) NOT NULL DEFAULT 0.00,
  `payment_method` ENUM('cash', 'gcash', 'bank') NOT NULL DEFAULT 'cash',
  `total_amount` DECIMAL(10,2) NOT NULL,
  `status` ENUM('pending', 'processing', 'ready_pickup', 'out_for_delivery', 'completed', 'cancelled') NOT NULL DEFAULT 'pending',
  `notes` TEXT DEFAULT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_order_number` (`order_number`),
  KEY `fk_orders_user` (`user_id`),
  CONSTRAINT `fk_orders_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ------------------------------------------------------------
-- 5. Table: order_items
-- ------------------------------------------------------------
DROP TABLE IF EXISTS `order_items`;
CREATE TABLE `order_items` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `order_id` INT UNSIGNED NOT NULL,
  `variant_id` VARCHAR(80) DEFAULT NULL,
  `product_name` VARCHAR(150) NOT NULL,
  `variant_info` VARCHAR(100) DEFAULT NULL,
  `price` DECIMAL(10,2) NOT NULL,
  `qty` INT UNSIGNED NOT NULL DEFAULT 1,
  `line_total` DECIMAL(10,2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_oi_order` (`order_id`),
  CONSTRAINT `fk_oi_order` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- ============================================================
-- INITIAL SEED DATA
-- ============================================================


-- Seed Products (Current 12 Catalog Gadgets)
INSERT INTO `products` (`id`, `name`, `category`, `condition`, `badge_class`, `short_desc`, `full_desc`, `main_image`, `specs_json`) VALUES
('iphone13pro', 'iPhone 13 Pro', 'preowned', 'Refurbished', 'badge-refurbished', 'A15 Bionic chip · Pro camera system · 120Hz ProMotion display', 'This iPhone 13 Pro has been professionally refurbished by Cheyn Gadgets. Fully cleaned and tested.', '/assets/products/iphone13pro-128-graphite.jpg', '{"Display":"6.1″ Super Retina XDR, 120Hz","Chip":"Apple A15 Bionic","Battery":"3,095 mAh"}'),
('iphone12', 'iPhone 12', 'preowned', 'Pre-owned', 'badge-preowned', 'A14 Bionic · 5G capable · Ceramic Shield front glass', 'This iPhone 12 is a pre-owned unit inspected and tested by our technicians.', '/assets/products/iphone12-64-blue.jpg', '{"Display":"6.1″ Super Retina XDR","Chip":"Apple A14 Bionic","Battery":"2,815 mAh"}'),
('s22', 'Samsung Galaxy S22', 'android', 'Refurbished', 'badge-refurbished', 'Snapdragon 8 Gen 1 · 50MP triple camera · 6.1″ Dynamic AMOLED', 'Professionally refurbished Samsung Galaxy S22. Full function test passed.', '/assets/products/s22-256-phantom.jpg', '{"Display":"6.1″ Dynamic AMOLED 2X, 120Hz","Chip":"Snapdragon 8 Gen 1","Battery":"3,700 mAh"}'),
('ipad9', 'Apple iPad 9th Gen', 'tablet', 'Pre-owned', 'badge-preowned', 'A13 Bionic · 10.2″ Retina display · All-day battery life', 'Pre-owned iPad 9th Gen in excellent condition. iCloud cleared and tested.', '/assets/products/ipad9-64-gray.jpg', '{"Display":"10.2″ Retina IPS","Chip":"Apple A13 Bionic","Battery":"Up to 10 hours"}'),
('pixel7', 'Google Pixel 7', 'android', 'Refurbished', 'badge-refurbished', 'Google Tensor G2 · 50MP main camera · 7-year Android updates', 'Refurbished Google Pixel 7 with Tensor G2 chip. Clean IMEI and tested.', '/assets/products/pixel7-128-obsidian.jpg', '{"Display":"6.3″ OLED, 90Hz","Chip":"Google Tensor G2","Battery":"4,355 mAh"}'),
('iphone14', 'iPhone 14', 'new', 'Brand New', 'badge-available', 'A15 Bionic · Crash Detection · Emergency SOS via satellite', 'Brand new sealed iPhone 14 with official Apple warranty.', '/assets/products/iphone14-256-midnight.jpg', '{"Display":"6.1″ Super Retina XDR","Chip":"Apple A15 Bionic","Battery":"3,279 mAh"}'),
('iphone11', 'iPhone 11', 'preowned', 'Pre-owned', 'badge-preowned', 'A13 Bionic · Dual 12MP ultra-wide cameras · Face ID', 'Pre-owned iPhone 11 fully tested. Face ID and battery verified.', '/assets/products/iphone11-64-white.jpg', '{"Display":"6.1″ Liquid Retina IPS","Chip":"Apple A13 Bionic","Battery":"3,110 mAh"}'),
('a54', 'Samsung Galaxy A54', 'android', 'Brand New', 'badge-available', 'Exynos 1380 · 50MP OIS camera · 5000mAh battery', 'Brand new Samsung Galaxy A54 5G. Comes with Samsung warranty.', '/assets/products/a54-128-violet.jpg', '{"Display":"6.4″ Super AMOLED, 120Hz","Chip":"Exynos 1380","Battery":"5,000 mAh"}'),
('iphonese3', 'iPhone SE 3rd Gen', 'preowned', 'Refurbished', 'badge-refurbished', 'A15 Bionic · 5G capable · Touch ID · Compact design', 'Refurbished iPhone SE 3rd Gen. The most affordable 5G iPhone.', '/assets/products/iphonese3-128-starlight.jpg', '{"Display":"4.7″ Retina IPS","Chip":"Apple A15 Bionic","Battery":"2,018 mAh"}'),
('rn12pro', 'Xiaomi Redmi Note 12 Pro', 'android', 'Brand New', 'badge-available', 'MediaTek Dimensity 1080 · 200MP camera · 67W charging', 'Brand new Xiaomi Redmi Note 12 Pro sealed with local warranty.', '/assets/products/rn12pro-256-skyblue.jpg', '{"Display":"6.67″ AMOLED, 120Hz","Chip":"MediaTek Dimensity 1080","Battery":"5,000 mAh"}'),
('ipadmini6', 'Apple iPad Mini 6th Gen', 'tablet', 'Pre-owned', 'badge-preowned', 'A15 Bionic · 8.3″ Liquid Retina · USB-C · Touch ID', 'Pre-owned iPad Mini 6 with A15 Bionic chip and USB-C.', '/assets/products/ipadmini6-64-purple.jpg', '{"Display":"8.3″ Liquid Retina","Chip":"Apple A15 Bionic","Battery":"Up to 10 hours"}'),
('op11', 'OnePlus 11', 'android', 'Refurbished', 'badge-refurbished', 'Snapdragon 8 Gen 2 · Hasselblad camera · 100W SUPERVOOC', 'Refurbished OnePlus 11 with Snapdragon 8 Gen 2.', '/assets/products/op11-256-titan.jpg', '{"Display":"6.7″ AMOLED, 120Hz LTPO","Chip":"Snapdragon 8 Gen 2","Battery":"5,000 mAh"}');

-- Seed Product Variants
INSERT INTO `product_variants` (`id`, `product_id`, `storage`, `color`, `color_hex`, `price`, `stock`) VALUES
('iphone13pro-128-graphite', 'iphone13pro', '128GB', 'Graphite', '#4a4a4a', 32500.00, 5),
('iphone13pro-256-graphite', 'iphone13pro', '256GB', 'Graphite', '#4a4a4a', 38500.00, 3),
('iphone12-64-blue', 'iphone12', '64GB', 'Blue', '#4b7db7', 21800.00, 4),
('iphone12-128-blue', 'iphone12', '128GB', 'Blue', '#4b7db7', 24500.00, 2),
('s22-128-phantom', 's22', '128GB', 'Phantom Black', '#1b1b1b', 24500.00, 4),
('s22-256-phantom', 's22', '256GB', 'Phantom Black', '#1b1b1b', 28000.00, 3),
('ipad9-64-gray', 'ipad9', '64GB', 'Space Gray', '#86868b', 22000.00, 6),
('pixel7-128-obsidian', 'pixel7', '128GB', 'Obsidian', '#2a2a2a', 24000.00, 5),
('iphone14-128-midnight', 'iphone14', '128GB', 'Midnight', '#1c1c1e', 41900.00, 3),
('iphone14-256-midnight', 'iphone14', '256GB', 'Midnight', '#1c1c1e', 44900.00, 4),
('iphone11-64-white', 'iphone11', '64GB', 'White', '#f5f5f7', 17500.00, 4),
('a54-128-violet', 'a54', '128GB', 'Awesome Violet', '#9b8ec4', 19990.00, 7),
('iphonese3-128-starlight', 'iphonese3', '128GB', 'Starlight', '#f5f0e8', 23500.00, 3),
('rn12pro-256-skyblue', 'rn12pro', '256GB', 'Sky Blue', '#8bb8d4', 16499.00, 5),
('ipadmini6-64-purple', 'ipadmini6', '64GB', 'Purple', '#c6b8d7', 29800.00, 2),
('op11-256-titan', 'op11', '256GB', 'Titan Black', '#1a1a1a', 34500.00, 4);

-- Seed A Real Demo Order (CT-10493) for Tracking Verification
INSERT INTO `orders` (`id`, `order_number`, `customer_name`, `customer_email`, `customer_phone`, `fulfillment`, `payment_method`, `total_amount`, `status`)
VALUES (1, 'CT-10493', 'Juan dela Cruz', 'juan@example.com', '09171234567', 'pickup', 'cash', 32500.00, 'ready_pickup');

INSERT INTO `order_items` (`order_id`, `variant_id`, `product_name`, `variant_info`, `price`, `qty`, `line_total`)
VALUES (1, 'iphone13pro-128-graphite', 'iPhone 13 Pro', '128GB · Graphite', 32500.00, 1, 32500.00);

SET FOREIGN_KEY_CHECKS = 1;
