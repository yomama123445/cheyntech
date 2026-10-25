-- Migration: 003_update_real_product_images.sql
-- Description: Update products table with authentic in-store photos

UPDATE `products` SET `main_image` = 'assets/img/products/real/iphone_11.jpg' WHERE `id` = 'iphone11';
UPDATE `products` SET `main_image` = 'assets/img/products/real/iphone_11_promax.jpg' WHERE `id` = 'iphone11promax';
UPDATE `products` SET `main_image` = 'assets/img/products/real/iphone_12.jpg' WHERE `id` = 'iphone12';
UPDATE `products` SET `main_image` = 'assets/img/products/real/iphone_12_promax.jpg' WHERE `id` = 'iphone12promax';
UPDATE `products` SET `main_image` = 'assets/img/products/real/iphone_13.jpg' WHERE `id` = 'iphone13';
UPDATE `products` SET `main_image` = 'assets/img/products/real/iphone_13_pro.jpg' WHERE `id` = 'iphone13pro';
UPDATE `products` SET `main_image` = 'assets/img/products/real/iphone_13_promax.jpg' WHERE `id` = 'iphone13promax';
UPDATE `products` SET `main_image` = 'assets/img/products/real/iphone_14_promax.jpeg' WHERE `id` = 'iphone14promax';
UPDATE `products` SET `main_image` = 'assets/img/products/real/ipad_10thgen.png' WHERE `id` = 'ipad10';
UPDATE `products` SET `main_image` = 'assets/img/products/real/airpods.jpg' WHERE `id` = 'apple-airpods';
UPDATE `products` SET `main_image` = 'assets/img/products/real/vivo_box.jpg' WHERE `id` = 'vivo-y03s';
