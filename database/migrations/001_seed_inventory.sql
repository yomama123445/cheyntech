SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

ALTER TABLE `products` ADD COLUMN IF NOT EXISTS `description` TEXT DEFAULT NULL;
ALTER TABLE `products` MODIFY `description` TEXT DEFAULT NULL;

DELETE FROM `order_items` WHERE `variant_id` IS NOT NULL;
DELETE FROM `product_variants`;
DELETE FROM `products`;

INSERT INTO `products` (`id`, `name`, `category`, `condition`, `badge_class`, `short_desc`, `full_desc`, `main_image`, `specs_json`) VALUES
('iphonexr', 'iPhone XR', 'preowned', 'Pre-owned', 'badge-preowned', 'Liquid Retina HD display · A12 Bionic chip · Advanced 12MP camera', 'This iPhone XR is pre-owned, thoroughly inspected and tested by our technicians. All hardware functions, cameras, speakers, and Face ID work perfectly.', '/assets/img/iphone_xr.jpeg', '{"Display":"6.1″ Liquid Retina HD","Chip":"Apple A12 Bionic","Rear Camera":"12MP Wide with OIS","Front Camera":"7MP TrueDepth Face ID","Battery":"2,942 mAh"}'),
('iphone11', 'iPhone 11', 'preowned', 'Pre-owned', 'badge-preowned', 'Dual 12MP ultra-wide and wide cameras · A13 Bionic · All-day battery', 'Pre-owned iPhone 11 in excellent tested condition. Verified Face ID, healthy battery life, and pristine display.', '/assets/img/iphone_11.jpeg', '{"Display":"6.1″ Liquid Retina IPS","Chip":"Apple A13 Bionic","Rear Camera":"Dual 12MP (Ultra-Wide, Wide)","Front Camera":"12MP TrueDepth","Battery":"3,110 mAh"}'),
('iphone12', 'iPhone 12', 'preowned', 'Pre-owned', 'badge-preowned', 'Super Retina XDR OLED · A14 Bionic · Ceramic Shield · 5G speed', 'Pre-owned iPhone 12 tested across all diagnostics. Features vibrant OLED display, MagSafe compatibility, and high-speed 5G.', '/assets/img/iPhone_12.jpeg', '{"Display":"6.1″ Super Retina XDR OLED","Chip":"Apple A14 Bionic","Rear Camera":"Dual 12MP with Night Mode","Front Camera":"12MP TrueDepth","Battery":"2,815 mAh"}'),
('iphone13', 'iPhone 13', 'preowned', 'Pre-owned', 'badge-preowned', 'Cinematic mode in 1080p · A15 Bionic · Super Retina XDR display', 'Pre-owned iPhone 13 featuring advanced dual-camera system, durable flat-edge design, and extended battery endurance.', '/assets/img/iphone_13pro.jpeg', '{"Display":"6.1″ Super Retina XDR","Chip":"Apple A15 Bionic","Rear Camera":"Dual 12MP Sensor-shift OIS","Front Camera":"12MP TrueDepth","Battery":"3,227 mAh"}'),
('iphone12pro', 'iPhone 12 Pro', 'preowned', 'Refurbished', 'badge-refurbished', 'Triple 12MP cameras with LiDAR · A14 Bionic · Surgical stainless steel', 'Professionally refurbished iPhone 12 Pro. Fully restored, certified internal components, and polished stainless steel frame.', '/assets/img/iPhone_12.jpeg', '{"Display":"6.1″ Super Retina XDR OLED","Chip":"Apple A14 Bionic","Rear Camera":"Triple 12MP with LiDAR Scanner","Front Camera":"12MP TrueDepth","Battery":"2,815 mAh"}'),
('iphone11promax', 'iPhone 11 Pro Max', 'preowned', 'Pre-owned', 'badge-preowned', 'Triple camera system · 6.5″ Super Retina XDR OLED · Long battery life', 'Pre-owned iPhone 11 Pro Max offering high-performance triple zoom camera system and large vibrant OLED display.', '/assets/img/iphone_11.jpeg', '{"Display":"6.5″ Super Retina XDR OLED","Chip":"Apple A13 Bionic","Rear Camera":"Triple 12MP (Ultra-Wide, Wide, Telephoto)","Front Camera":"12MP TrueDepth","Battery":"3,969 mAh"}'),
('iphone12promax', 'iPhone 12 Pro Max', 'preowned', 'Pre-owned', 'badge-preowned', '6.7″ Super Retina XDR · Sensor-shift optical stabilization · A14 Bionic', 'Pre-owned iPhone 12 Pro Max with max-size screen and studio-grade photography capabilities.', '/assets/img/iPhone_12.jpeg', '{"Display":"6.7″ Super Retina XDR OLED","Chip":"Apple A14 Bionic","Rear Camera":"Triple 12MP with LiDAR & Sensor-shift","Front Camera":"12MP TrueDepth","Battery":"3,687 mAh"}'),
('iphone13promax', 'iPhone 13 Pro Max', 'preowned', 'Refurbished', 'badge-refurbished', '120Hz ProMotion display · Pro camera system · Massive battery life', 'Refurbished iPhone 13 Pro Max. Super-smooth 120Hz refresh rate, cinematic video, and exceptional battery runtime.', '/assets/img/iphone_13pro.jpeg', '{"Display":"6.7″ Super Retina XDR ProMotion 120Hz","Chip":"Apple A15 Bionic","Rear Camera":"Triple 12MP Pro camera system","Front Camera":"12MP TrueDepth","Battery":"4,352 mAh"}'),
('iphone14', 'iPhone 14', 'preowned', 'Pre-owned', 'badge-preowned', 'A15 Bionic 5-core GPU · Photonic Engine · Crash Detection safety', 'Pre-owned iPhone 14 in pristine condition. Excellent battery health and full Apple ecosystem integration.', '/assets/img/iphone_14.jpeg', '{"Display":"6.1″ Super Retina XDR","Chip":"Apple A15 Bionic","Rear Camera":"Dual 12MP with Photonic Engine","Front Camera":"12MP with Autofocus","Battery":"3,279 mAh"}'),
('iphone14promax', 'iPhone 14 Pro Max', 'preowned', 'Refurbished', 'badge-refurbished', 'Dynamic Island · 48MP main camera · Always-On display · A16 Bionic', 'Refurbished iPhone 14 Pro Max with revolutionary Dynamic Island interface and 48MP photography.', '/assets/img/iphone14_pro.jpeg', '{"Display":"6.7″ Super Retina XDR Always-On 120Hz","Chip":"Apple A16 Bionic","Rear Camera":"48MP Main + 12MP Ultra Wide + 12MP Telephoto","Front Camera":"12MP TrueDepth","Battery":"4,323 mAh"}'),
('iphone15', 'iPhone 15', 'preowned', 'Pre-owned', 'badge-preowned', 'Dynamic Island · 48MP camera · USB-C · Color-infused back glass', 'Pre-owned iPhone 15 in like-new condition. Fast universal USB-C charging and sharp 48MP photo resolution.', '/assets/img/iphone_15.jpeg', '{"Display":"6.1″ Super Retina XDR with Dynamic Island","Chip":"Apple A16 Bionic","Rear Camera":"48MP Main with 2x Telephoto","Front Camera":"12MP TrueDepth","Battery":"3,349 mAh"}'),
('samsung-a06', 'Samsung Galaxy A06 5G', 'android', 'Brand New', 'badge-available', '6.7″ HD+ display · 50MP dual camera · 5,000mAh battery', 'Brand new sealed Samsung Galaxy A06. Smooth performance for everyday tasks, media, and long battery life.', '/assets/img/samsunggalaxy_A06.jpeg', '{"Display":"6.7″ PLS LCD 60Hz","Chip":"MediaTek Helio G85","Rear Camera":"50MP Main + 2MP Depth","Front Camera":"8MP","Battery":"5,000 mAh"}'),
('vivo-y03s', 'Vivo Y03s', 'android', 'Brand New', 'badge-available', '90Hz Sunlight display · 5,000mAh long battery · Sleek modern body', 'Brand new Vivo Y03s. Fluid 90Hz refresh rate and expandable storage support.', '/assets/products/placeholder.jpg', '{"Display":"6.56″ 90Hz Sunlight Display","Chip":"MediaTek Helio G85","Rear Camera":"13MP Main + Auxiliary","Front Camera":"5MP","Battery":"5,000 mAh"}'),
('spark-go3', 'Tecno Spark Go 3', 'android', 'Brand New', 'badge-available', '90Hz eye-care display · Dynamic Port alerts · Dual stereo speakers', 'Brand new Tecno Spark Go 3 featuring clean minimalist styling and loud dual stereo audio.', '/assets/products/placeholder.jpg', '{"Display":"6.6″ IPS LCD 90Hz","Chip":"Unisoc T606 Octa-core","Rear Camera":"13MP HDR","Front Camera":"8MP with Dual Flash","Battery":"5,000 mAh"}'),
('honor-x7c', 'Honor X7c', 'android', 'Brand New', 'badge-available', '108MP ultra-clear camera · 6,000mAh massive battery · IP64 water resistance', 'Brand new Honor X7c equipped with an extraordinary 6,000mAh powerhouse battery and ultra-sharp 108MP camera.', '/assets/products/placeholder.jpg', '{"Display":"6.77″ 120Hz Eye-Comfort Display","Chip":"Qualcomm Snapdragon 685","Rear Camera":"108MP Ultra-Clear + 2MP","Front Camera":"8MP","Battery":"6,000 mAh"}'),
('ipad10', 'Apple iPad 10th Gen', 'tablet', 'Pre-owned', 'badge-preowned', '10.9″ Liquid Retina display · A14 Bionic · USB-C · Touch ID', 'Pre-owned Apple iPad 10th Gen with all-screen front, fast USB-C connectivity, and Apple Pencil support.', '/assets/img/ipad_9th_gen.jpeg', '{"Display":"10.9″ Liquid Retina IPS","Chip":"Apple A14 Bionic","Rear Camera":"12MP Wide","Front Camera":"12MP Landscape Ultra Wide","Battery":"Up to 10 hours"}'),
('ipadair2', 'Apple iPad Air 2', 'tablet', 'Pre-owned', 'badge-preowned', '9.7″ Retina display · A8X chip · Ultra-thin lightweight tablet', 'Pre-owned iPad Air 2 in working tested condition. Ideal for lightweight reading, browsing, video streaming, and study.', '/assets/img/ipad_9th_gen.jpeg', '{"Display":"9.7″ Retina IPS (2048 x 1536)","Chip":"Apple A8X with M8 Coprocessor","Rear Camera":"8MP iSight","Front Camera":"1.2MP FaceTime HD","Battery":"Up to 10 hours"}'),
('mxs-kids', 'MXS Kids Learning Tablet', 'tablet', 'Brand New', 'badge-available', 'Kid-proof protective bumper · Preloaded educational apps · Parental controls', 'Brand new MXS Kids tablet featuring drop-resistant silicone casing and child-friendly learning environment.', '/assets/products/placeholder.jpg', '{"Display":"7.0″ IPS HD","Features":"Shockproof Silicone Bumper, Parental Controls","Storage":"512MB RAM + Expansion","Battery":"3,000 mAh"}'),
('apple-airpods', 'Apple AirPods', 'preowned', 'Pre-owned', 'badge-preowned', 'High-fidelity audio · Automatic device switching · Siri voice control', 'Pre-owned authentic Apple AirPods with charging case. Fully sanitized, battery-tested, and sound verified.', '/assets/img/apple_airpods.jpeg', '{"Connectivity":"Bluetooth 5.0, Apple H1 chip","Battery":"Up to 5 hours listening time","Case":"Lightning Charging Case"}'),
('apple-watch', 'Apple Watch', 'preowned', 'Pre-owned', 'badge-preowned', 'Retina OLED display · Heart rate monitoring · Activity & workout tracking', 'Pre-owned Apple Watch thoroughly tested with clean iCloud status, responsive touchscreen, and health sensors.', '/assets/img/apple_watch.jpeg', '{"Display":"OLED Retina Display","Sensors":"Optical heart sensor, Accelerometer, Gyroscope","Connectivity":"Bluetooth, Wi-Fi, GPS"}');

INSERT INTO `product_variants` (`id`, `product_id`, `storage`, `color`, `color_hex`, `price`, `stock`) VALUES
('iphonexr-128gb-black', 'iphonexr', '128GB', 'Black', '#1c1c1e', 13500, 1),
('iphone11-128gb-black', 'iphone11', '128GB', 'Black', '#1c1c1e', 18500, 10),
('iphone11-256gb-black', 'iphone11', '256GB', 'Black', '#1c1c1e', 21500, 2),
('iphone12-128gb-blue', 'iphone12', '128GB', 'Blue', '#4b7db7', 24500, 5),
('iphone12-256gb-blue', 'iphone12', '256GB', 'Blue', '#4b7db7', 27500, 8),
('iphone13-128gb-midnight', 'iphone13', '128GB', 'Midnight', '#1c1c1e', 29500, 5),
('iphone13-256gb-midnight', 'iphone13', '256GB', 'Midnight', '#1c1c1e', 33500, 8),
('iphone12pro-256gb-graphite', 'iphone12pro', '256GB', 'Graphite', '#4a4a4a', 29500, 2),
('iphone11promax-256gb-spacegray', 'iphone11promax', '256GB', 'Space Gray', '#4a4a4a', 24500, 2),
('iphone11promax-512gb-spacegray', 'iphone11promax', '512GB', 'Space Gray', '#4a4a4a', 26900, 1),
('iphone12promax-128gb-pacificblue', 'iphone12promax', '128GB', 'Pacific Blue', '#2d4b68', 31500, 3),
('iphone13promax-256gb-sierrablue', 'iphone13promax', '256GB', 'Sierra Blue', '#9bb5ce', 39500, 2),
('iphone14-128gb-midnight', 'iphone14', '128GB', 'Midnight', '#1c1c1e', 34500, 1),
('iphone14promax-256gb-deeppurple', 'iphone14promax', '256GB', 'Deep Purple', '#433d4c', 48500, 1),
('iphone15-128gb-black', 'iphone15', '128GB', 'Black', '#1c1c1e', 41500, 2),
('samsung-a06-128gb-lightblue', 'samsung-a06', '128GB', 'Light Blue', '#7ba4cc', 6290, 1),
('vivo-y03s-128gb-spaceblack', 'vivo-y03s', '128GB', 'Space Black', '#1c1c1e', 5499, 1),
('spark-go3-64gb-gravityblack', 'spark-go3', '64GB', 'Gravity Black', '#1c1c1e', 4299, 1),
('honor-x7c-128gb-midnightblack', 'honor-x7c', '128GB', 'Midnight Black', '#1c1c1e', 8999, 1),
('ipad10-128gb-silver', 'ipad10', '128GB', 'Silver', '#e2e2e4', 23500, 2),
('ipadair2-128gb-spacegray', 'ipadair2', '128GB', 'Space Gray', '#86868b', 8900, 1),
('mxs-kids-512mb-blue', 'mxs-kids', '512MB', 'Blue', '#4b7db7', 2999, 3),
('apple-airpods-white', 'apple-airpods', 'Standard', 'White', '#f5f5f7', 6500, 10),
('apple-watch-44mm-midnight', 'apple-watch', '44mm', 'Midnight', '#1c1c1e', 11500, 1);

SET FOREIGN_KEY_CHECKS = 1;
