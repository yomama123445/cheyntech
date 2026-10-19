-- ============================================================
-- CheynTech Migration 002: Add rate_limit table (TASK S6)
-- Protects auth endpoints, contact form, and order tracking
-- ============================================================

SET NAMES utf8mb4;

CREATE TABLE IF NOT EXISTS `rate_limits` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `ip_address` VARCHAR(45) NOT NULL,
  `endpoint` VARCHAR(60) NOT NULL,
  `hits` INT UNSIGNED NOT NULL DEFAULT 1,
  `first_hit_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `expires_at` TIMESTAMP NOT NULL,
  INDEX `idx_ip_endpoint_expires` (`ip_address`, `endpoint`, `expires_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
