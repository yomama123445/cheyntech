-- Migration: 003_update_real_product_images.sql
-- Description: Update products table with authentic in-store photos (WebP optimized)

UPDATE `products` SET `main_image` = 'assets/img/products/real/iphone_11.webp' WHERE `id` = 'iphone11';
UPDATE `products` SET `main_image` = 'assets/img/products/real/iphone_11_promax.webp' WHERE `id` = 'iphone11promax';
UPDATE `products` SET `main_image` = 'assets/img/products/real/iphone_12.webp' WHERE `id` = 'iphone12';
UPDATE `products` SET `main_image` = 'assets/img/products/real/iphone_12_promax.webp' WHERE `id` = 'iphone12promax';
UPDATE `products` SET `main_image` = 'assets/img/products/real/iphone_13.webp' WHERE `id` = 'iphone13';
UPDATE `products` SET `main_image` = 'assets/img/products/real/iphone_13_pro.webp' WHERE `id` = 'iphone13pro';
UPDATE `products` SET `main_image` = 'assets/img/products/real/iphone_13_promax.webp' WHERE `id` = 'iphone13promax';
UPDATE `products` SET `main_image` = 'assets/img/products/real/iphone_14_promax.webp' WHERE `id` = 'iphone14promax';
UPDATE `products` SET `main_image` = 'assets/img/products/real/ipad_10thgen.webp' WHERE `id` = 'ipad10';
UPDATE `products` SET `main_image` = 'assets/img/products/real/airpods.webp' WHERE `id` = 'apple-airpods';
UPDATE `products` SET `main_image` = 'assets/img/products/real/vivo_box.webp' WHERE `id` = 'vivo-y03s';
