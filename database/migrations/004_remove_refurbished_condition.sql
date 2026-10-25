-- Migration: 004_remove_refurbished_condition.sql
-- Description: Convert all 'Refurbished' condition products to 'Pre-owned' and update badge classes

UPDATE `products`
SET `condition`   = 'Pre-owned',
    `badge_class` = 'badge-preowned',
    `full_desc`   = REPLACE(REPLACE(`full_desc`, 'Professionally refurbished', 'Pre-owned'), 'Refurbished', 'Pre-owned')
WHERE `condition` = 'Refurbished' OR `badge_class` = 'badge-refurbished';
