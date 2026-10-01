'use strict';
/* ============================================================
   CHEYN GADGETS SHARED PRODUCT DATA (STATIC FALLBACK)
   Synchronized with MariaDB database/migrations/001_seed_inventory.sql
   ============================================================ */

var CHEYN_PRODUCTS = [
  {
    id: 'iphonexr',
    name: 'iPhone XR',
    badge: 'badge-preowned',
    badgeLabel: 'Pre-owned',
    condition: 'Pre-owned',
    desc: 'Liquid Retina HD display · A12 Bionic chip · Advanced 12MP camera',
    fullDesc: 'This iPhone XR is pre-owned, thoroughly inspected and tested by our technicians. All hardware functions, cameras, speakers, and Face ID work perfectly.',
    image: 'assets/img/iphone_xr.jpeg',
    storageOptions: [
      { label: '128GB', price: 13500, id: 'iphonexr-128gb-black', stock: 1 }
    ],
    colorOptions: [
      { label: 'Black', hex: '#1c1c1e', border: '' }
    ],
    gallery: [
      { src: 'assets/img/iphone_xr.jpeg', thumb: 'assets/img/iphone_xr.jpeg', alt: 'iPhone XR' }
    ],
    specs: {
      Display: '6.1″ Liquid Retina HD',
      Chip: 'Apple A12 Bionic',
      'Rear Camera': '12MP Wide with OIS',
      'Front Camera': '7MP TrueDepth Face ID',
      Battery: '2,942 mAh',
      Condition: 'Pre-owned'
    }
  },
  {
    id: 'iphone11',
    name: 'iPhone 11',
    badge: 'badge-preowned',
    badgeLabel: 'Pre-owned',
    condition: 'Pre-owned',
    desc: 'Dual 12MP ultra-wide and wide cameras · A13 Bionic · All-day battery',
    fullDesc: 'Pre-owned iPhone 11 in excellent tested condition. Verified Face ID, healthy battery life, and pristine display.',
    image: 'assets/img/iphone_11.jpeg',
    storageOptions: [
      { label: '128GB', price: 18500, id: 'iphone11-128gb-black', stock: 10 },
      { label: '256GB', price: 21500, id: 'iphone11-256gb-black', stock: 2 }
    ],
    colorOptions: [
      { label: 'Black', hex: '#1c1c1e', border: '' }
    ],
    gallery: [
      { src: 'assets/img/iphone_11.jpeg', thumb: 'assets/img/iphone_11.jpeg', alt: 'iPhone 11' }
    ],
    specs: {
      Display: '6.1″ Liquid Retina IPS',
      Chip: 'Apple A13 Bionic',
      'Rear Camera': 'Dual 12MP (Ultra-Wide, Wide)',
      'Front Camera': '12MP TrueDepth',
      Battery: '3,110 mAh',
      Condition: 'Pre-owned'
    }
  },
  {
    id: 'iphone12',
    name: 'iPhone 12',
    badge: 'badge-preowned',
    badgeLabel: 'Pre-owned',
    condition: 'Pre-owned',
    desc: 'Super Retina XDR OLED · A14 Bionic · Ceramic Shield · 5G speed',
    fullDesc: 'Pre-owned iPhone 12 tested across all diagnostics. Features vibrant OLED display, MagSafe compatibility, and high-speed 5G.',
    image: 'assets/img/iPhone_12.jpeg',
    storageOptions: [
      { label: '128GB', price: 24500, id: 'iphone12-128gb-blue', stock: 5 },
      { label: '256GB', price: 27500, id: 'iphone12-256gb-blue', stock: 8 }
    ],
    colorOptions: [
      { label: 'Blue', hex: '#4b7db7', border: '' }
    ],
    gallery: [
      { src: 'assets/img/iPhone_12.jpeg', thumb: 'assets/img/iPhone_12.jpeg', alt: 'iPhone 12' }
    ],
    specs: {
      Display: '6.1″ Super Retina XDR OLED',
      Chip: 'Apple A14 Bionic',
      'Rear Camera': 'Dual 12MP with Night Mode',
      'Front Camera': '12MP TrueDepth',
      Battery: '2,815 mAh',
      Condition: 'Pre-owned'
    }
  },
  {
    id: 'iphone13',
    name: 'iPhone 13',
    badge: 'badge-preowned',
    badgeLabel: 'Pre-owned',
    condition: 'Pre-owned',
    desc: 'Cinematic mode in 1080p · A15 Bionic · Super Retina XDR display',
    fullDesc: 'Pre-owned iPhone 13 featuring advanced dual-camera system, durable flat-edge design, and extended battery endurance.',
    image: 'assets/img/iphone_13pro.jpeg',
    storageOptions: [
      { label: '128GB', price: 29500, id: 'iphone13-128gb-midnight', stock: 5 },
      { label: '256GB', price: 33500, id: 'iphone13-256gb-midnight', stock: 8 }
    ],
    colorOptions: [
      { label: 'Midnight', hex: '#1c1c1e', border: '' }
    ],
    gallery: [
      { src: 'assets/img/iphone_13pro.jpeg', thumb: 'assets/img/iphone_13pro.jpeg', alt: 'iPhone 13' }
    ],
    specs: {
      Display: '6.1″ Super Retina XDR',
      Chip: 'Apple A15 Bionic',
      'Rear Camera': 'Dual 12MP Sensor-shift OIS',
      'Front Camera': '12MP TrueDepth',
      Battery: '3,227 mAh',
      Condition: 'Pre-owned'
    }
  },
  {
    id: 'iphone12pro',
    name: 'iPhone 12 Pro',
    badge: 'badge-refurbished',
    badgeLabel: 'Refurbished',
    condition: 'Refurbished',
    desc: 'Triple 12MP cameras with LiDAR · A14 Bionic · Surgical stainless steel',
    fullDesc: 'Professionally refurbished iPhone 12 Pro. Fully restored, certified internal components, and polished stainless steel frame.',
    image: 'assets/img/iPhone_12.jpeg',
    storageOptions: [
      { label: '256GB', price: 29500, id: 'iphone12pro-256gb-graphite', stock: 2 }
    ],
    colorOptions: [
      { label: 'Graphite', hex: '#4a4a4a', border: '' }
    ],
    gallery: [
      { src: 'assets/img/iPhone_12.jpeg', thumb: 'assets/img/iPhone_12.jpeg', alt: 'iPhone 12 Pro' }
    ],
    specs: {
      Display: '6.1″ Super Retina XDR OLED',
      Chip: 'Apple A14 Bionic',
      'Rear Camera': 'Triple 12MP with LiDAR Scanner',
      'Front Camera': '12MP TrueDepth',
      Battery: '2,815 mAh',
      Condition: 'Refurbished'
    }
  },
  {
    id: 'iphone11promax',
    name: 'iPhone 11 Pro Max',
    badge: 'badge-preowned',
    badgeLabel: 'Pre-owned',
    condition: 'Pre-owned',
    desc: 'Triple camera system · 6.5″ Super Retina XDR OLED · Long battery life',
    fullDesc: 'Pre-owned iPhone 11 Pro Max offering high-performance triple zoom camera system and large vibrant OLED display.',
    image: 'assets/img/iphone_11.jpeg',
    storageOptions: [
      { label: '256GB', price: 24500, id: 'iphone11promax-256gb-spacegray', stock: 2 },
      { label: '512GB', price: 26900, id: 'iphone11promax-512gb-spacegray', stock: 1 }
    ],
    colorOptions: [
      { label: 'Space Gray', hex: '#4a4a4a', border: '' }
    ],
    gallery: [
      { src: 'assets/img/iphone_11.jpeg', thumb: 'assets/img/iphone_11.jpeg', alt: 'iPhone 11 Pro Max' }
    ],
    specs: {
      Display: '6.5″ Super Retina XDR OLED',
      Chip: 'Apple A13 Bionic',
      'Rear Camera': 'Triple 12MP (Ultra-Wide, Wide, Telephoto)',
      'Front Camera': '12MP TrueDepth',
      Battery: '3,969 mAh',
      Condition: 'Pre-owned'
    }
  },
  {
    id: 'iphone12promax',
    name: 'iPhone 12 Pro Max',
    badge: 'badge-preowned',
    badgeLabel: 'Pre-owned',
    condition: 'Pre-owned',
    desc: '6.7″ Super Retina XDR · Sensor-shift optical stabilization · A14 Bionic',
    fullDesc: 'Pre-owned iPhone 12 Pro Max with max-size screen and studio-grade photography capabilities.',
    image: 'assets/img/iPhone_12.jpeg',
    storageOptions: [
      { label: '128GB', price: 31500, id: 'iphone12promax-128gb-pacificblue', stock: 3 }
    ],
    colorOptions: [
      { label: 'Pacific Blue', hex: '#2d4b68', border: '' }
    ],
    gallery: [
      { src: 'assets/img/iPhone_12.jpeg', thumb: 'assets/img/iPhone_12.jpeg', alt: 'iPhone 12 Pro Max' }
    ],
    specs: {
      Display: '6.7″ Super Retina XDR OLED',
      Chip: 'Apple A14 Bionic',
      'Rear Camera': 'Triple 12MP with LiDAR & Sensor-shift',
      'Front Camera': '12MP TrueDepth',
      Battery: '3,687 mAh',
      Condition: 'Pre-owned'
    }
  },
  {
    id: 'iphone13promax',
    name: 'iPhone 13 Pro Max',
    badge: 'badge-refurbished',
    badgeLabel: 'Refurbished',
    condition: 'Refurbished',
    desc: '120Hz ProMotion display · Pro camera system · Massive battery life',
    fullDesc: 'Refurbished iPhone 13 Pro Max. Super-smooth 120Hz refresh rate, cinematic video, and exceptional battery runtime.',
    image: 'assets/img/iphone_13pro.jpeg',
    storageOptions: [
      { label: '256GB', price: 39500, id: 'iphone13promax-256gb-sierrablue', stock: 2 }
    ],
    colorOptions: [
      { label: 'Sierra Blue', hex: '#9bb5ce', border: '' }
    ],
    gallery: [
      { src: 'assets/img/iphone_13pro.jpeg', thumb: 'assets/img/iphone_13pro.jpeg', alt: 'iPhone 13 Pro Max' }
    ],
    specs: {
      Display: '6.7″ Super Retina XDR ProMotion 120Hz',
      Chip: 'Apple A15 Bionic',
      'Rear Camera': 'Triple 12MP Pro camera system',
      'Front Camera': '12MP TrueDepth',
      Battery: '4,352 mAh',
      Condition: 'Refurbished'
    }
  },
  {
    id: 'iphone14',
    name: 'iPhone 14',
    badge: 'badge-preowned',
    badgeLabel: 'Pre-owned',
    condition: 'Pre-owned',
    desc: 'A15 Bionic 5-core GPU · Photonic Engine · Crash Detection safety',
    fullDesc: 'Pre-owned iPhone 14 in pristine condition. Excellent battery health and full Apple ecosystem integration.',
    image: 'assets/img/iphone_14.jpeg',
    storageOptions: [
      { label: '128GB', price: 34500, id: 'iphone14-128gb-midnight', stock: 1 }
    ],
    colorOptions: [
      { label: 'Midnight', hex: '#1c1c1e', border: '' }
    ],
    gallery: [
      { src: 'assets/img/iphone_14.jpeg', thumb: 'assets/img/iphone_14.jpeg', alt: 'iPhone 14' }
    ],
    specs: {
      Display: '6.1″ Super Retina XDR',
      Chip: 'Apple A15 Bionic',
      'Rear Camera': 'Dual 12MP with Photonic Engine',
      'Front Camera': '12MP with Autofocus',
      Battery: '3,279 mAh',
      Condition: 'Pre-owned'
    }
  },
  {
    id: 'iphone14promax',
    name: 'iPhone 14 Pro Max',
    badge: 'badge-refurbished',
    badgeLabel: 'Refurbished',
    condition: 'Refurbished',
    desc: 'Dynamic Island · 48MP main camera · Always-On display · A16 Bionic',
    fullDesc: 'Refurbished iPhone 14 Pro Max with revolutionary Dynamic Island interface and 48MP photography.',
    image: 'assets/img/iphone14_pro.jpeg',
    storageOptions: [
      { label: '256GB', price: 48500, id: 'iphone14promax-256gb-deeppurple', stock: 1 }
    ],
    colorOptions: [
      { label: 'Deep Purple', hex: '#433d4c', border: '' }
    ],
    gallery: [
      { src: 'assets/img/iphone14_pro.jpeg', thumb: 'assets/img/iphone14_pro.jpeg', alt: 'iPhone 14 Pro Max' }
    ],
    specs: {
      Display: '6.7″ Super Retina XDR Always-On 120Hz',
      Chip: 'Apple A16 Bionic',
      'Rear Camera': '48MP Main + 12MP Ultra Wide + 12MP Telephoto',
      'Front Camera': '12MP TrueDepth',
      Battery: '4,323 mAh',
      Condition: 'Refurbished'
    }
  },
  {
    id: 'iphone15',
    name: 'iPhone 15',
    badge: 'badge-preowned',
    badgeLabel: 'Pre-owned',
    condition: 'Pre-owned',
    desc: 'Dynamic Island · 48MP camera · USB-C · Color-infused back glass',
    fullDesc: 'Pre-owned iPhone 15 in like-new condition. Fast universal USB-C charging and sharp 48MP photo resolution.',
    image: 'assets/img/iphone_15.jpeg',
    storageOptions: [
      { label: '128GB', price: 41500, id: 'iphone15-128gb-black', stock: 2 }
    ],
    colorOptions: [
      { label: 'Black', hex: '#1c1c1e', border: '' }
    ],
    gallery: [
      { src: 'assets/img/iphone_15.jpeg', thumb: 'assets/img/iphone_15.jpeg', alt: 'iPhone 15' }
    ],
    specs: {
      Display: '6.1″ Super Retina XDR with Dynamic Island',
      Chip: 'Apple A16 Bionic',
      'Rear Camera': '48MP Main with 2x Telephoto',
      'Front Camera': '12MP TrueDepth',
      Battery: '3,349 mAh',
      Condition: 'Pre-owned'
    }
  },
  {
    id: 'samsung-a06',
    name: 'Samsung Galaxy A06 5G',
    badge: 'badge-available',
    badgeLabel: 'Brand New',
    condition: 'Brand New',
    desc: '6.7″ HD+ display · 50MP dual camera · 5,000mAh battery',
    fullDesc: 'Brand new sealed Samsung Galaxy A06. Smooth performance for everyday tasks, media, and long battery life.',
    image: 'assets/img/samsunggalaxy_A06.jpeg',
    storageOptions: [
      { label: '128GB', price: 6290, id: 'samsung-a06-128gb-lightblue', stock: 1 }
    ],
    colorOptions: [
      { label: 'Light Blue', hex: '#7ba4cc', border: '' }
    ],
    gallery: [
      { src: 'assets/img/samsunggalaxy_A06.jpeg', thumb: 'assets/img/samsunggalaxy_A06.jpeg', alt: 'Samsung Galaxy A06' }
    ],
    specs: {
      Display: '6.7″ PLS LCD 60Hz',
      Chip: 'MediaTek Helio G85',
      'Rear Camera': '50MP Main + 2MP Depth',
      'Front Camera': '8MP',
      Battery: '5,000 mAh',
      Condition: 'Brand New'
    }
  },
  {
    id: 'vivo-y03s',
    name: 'Vivo Y03s',
    badge: 'badge-available',
    badgeLabel: 'Brand New',
    condition: 'Brand New',
    desc: '90Hz Sunlight display · 5,000mAh long battery · Sleek modern body',
    fullDesc: 'Brand new Vivo Y03s. Fluid 90Hz refresh rate and expandable storage support.',
    image: 'assets/products/placeholder.jpg',
    storageOptions: [
      { label: '128GB', price: 5499, id: 'vivo-y03s-128gb-spaceblack', stock: 1 }
    ],
    colorOptions: [
      { label: 'Space Black', hex: '#1c1c1e', border: '' }
    ],
    gallery: [
      { src: 'assets/products/placeholder.jpg', thumb: 'assets/products/placeholder.jpg', alt: 'Vivo Y03s' }
    ],
    specs: {
      Display: '6.56″ 90Hz Sunlight Display',
      Chip: 'MediaTek Helio G85',
      'Rear Camera': '13MP Main + Auxiliary',
      'Front Camera': '5MP',
      Battery: '5,000 mAh',
      Condition: 'Brand New'
    }
  },
  {
    id: 'spark-go3',
    name: 'Tecno Spark Go 3',
    badge: 'badge-available',
    badgeLabel: 'Brand New',
    condition: 'Brand New',
    desc: '90Hz eye-care display · Dynamic Port alerts · Dual stereo speakers',
    fullDesc: 'Brand new Tecno Spark Go 3 featuring clean minimalist styling and loud dual stereo audio.',
    image: 'assets/products/placeholder.jpg',
    storageOptions: [
      { label: '64GB', price: 4299, id: 'spark-go3-64gb-gravityblack', stock: 1 }
    ],
    colorOptions: [
      { label: 'Gravity Black', hex: '#1c1c1e', border: '' }
    ],
    gallery: [
      { src: 'assets/products/placeholder.jpg', thumb: 'assets/products/placeholder.jpg', alt: 'Tecno Spark Go 3' }
    ],
    specs: {
      Display: '6.6″ IPS LCD 90Hz',
      Chip: 'Unisoc T606 Octa-core',
      'Rear Camera': '13MP HDR',
      'Front Camera': '8MP with Dual Flash',
      Battery: '5,000 mAh',
      Condition: 'Brand New'
    }
  },
  {
    id: 'honor-x7c',
    name: 'Honor X7c',
    badge: 'badge-available',
    badgeLabel: 'Brand New',
    condition: 'Brand New',
    desc: '108MP ultra-clear camera · 6,000mAh massive battery · IP64 water resistance',
    fullDesc: 'Brand new Honor X7c equipped with an extraordinary 6,000mAh powerhouse battery and ultra-sharp 108MP camera.',
    image: 'assets/products/placeholder.jpg',
    storageOptions: [
      { label: '128GB', price: 8999, id: 'honor-x7c-128gb-midnightblack', stock: 1 }
    ],
    colorOptions: [
      { label: 'Midnight Black', hex: '#1c1c1e', border: '' }
    ],
    gallery: [
      { src: 'assets/products/placeholder.jpg', thumb: 'assets/products/placeholder.jpg', alt: 'Honor X7c' }
    ],
    specs: {
      Display: '6.77″ 120Hz Eye-Comfort Display',
      Chip: 'Qualcomm Snapdragon 685',
      'Rear Camera': '108MP Ultra-Clear + 2MP',
      'Front Camera': '8MP',
      Battery: '6,000 mAh',
      Condition: 'Brand New'
    }
  },
  {
    id: 'ipad10',
    name: 'Apple iPad 10th Gen',
    badge: 'badge-preowned',
    badgeLabel: 'Pre-owned',
    condition: 'Pre-owned',
    desc: '10.9″ Liquid Retina display · A14 Bionic · USB-C · Touch ID',
    fullDesc: 'Pre-owned Apple iPad 10th Gen with all-screen front, fast USB-C connectivity, and Apple Pencil support.',
    image: 'assets/img/ipad_9th_gen.jpeg',
    storageOptions: [
      { label: '128GB', price: 23500, id: 'ipad10-128gb-silver', stock: 2 }
    ],
    colorOptions: [
      { label: 'Silver', hex: '#e2e2e4', border: '#c0c0c0' }
    ],
    gallery: [
      { src: 'assets/img/ipad_9th_gen.jpeg', thumb: 'assets/img/ipad_9th_gen.jpeg', alt: 'iPad 10th Gen' }
    ],
    specs: {
      Display: '10.9″ Liquid Retina IPS',
      Chip: 'Apple A14 Bionic',
      'Rear Camera': '12MP Wide',
      'Front Camera': '12MP Landscape Ultra Wide',
      Battery: 'Up to 10 hours',
      Condition: 'Pre-owned'
    }
  },
  {
    id: 'ipadair2',
    name: 'Apple iPad Air 2',
    badge: 'badge-preowned',
    badgeLabel: 'Pre-owned',
    condition: 'Pre-owned',
    desc: '9.7″ Retina display · A8X chip · Ultra-thin lightweight tablet',
    fullDesc: 'Pre-owned iPad Air 2 in working tested condition. Ideal for lightweight reading, browsing, video streaming, and study.',
    image: 'assets/img/ipad_9th_gen.jpeg',
    storageOptions: [
      { label: '128GB', price: 8900, id: 'ipadair2-128gb-spacegray', stock: 1 }
    ],
    colorOptions: [
      { label: 'Space Gray', hex: '#86868b', border: '' }
    ],
    gallery: [
      { src: 'assets/img/ipad_9th_gen.jpeg', thumb: 'assets/img/ipad_9th_gen.jpeg', alt: 'iPad Air 2' }
    ],
    specs: {
      Display: '9.7″ Retina IPS',
      Chip: 'Apple A8X with M8 Coprocessor',
      'Rear Camera': '8MP iSight',
      'Front Camera': '1.2MP FaceTime HD',
      Battery: 'Up to 10 hours',
      Condition: 'Pre-owned'
    }
  },
  {
    id: 'mxs-kids',
    name: 'MXS Kids Learning Tablet',
    badge: 'badge-available',
    badgeLabel: 'Brand New',
    condition: 'Brand New',
    desc: 'Kid-proof protective bumper · Preloaded educational apps · Parental controls',
    fullDesc: 'Brand new MXS Kids tablet featuring drop-resistant silicone casing and child-friendly learning environment.',
    image: 'assets/products/placeholder.jpg',
    storageOptions: [
      { label: '512MB', price: 2999, id: 'mxs-kids-512mb-blue', stock: 3 }
    ],
    colorOptions: [
      { label: 'Blue', hex: '#4b7db7', border: '' }
    ],
    gallery: [
      { src: 'assets/products/placeholder.jpg', thumb: 'assets/products/placeholder.jpg', alt: 'MXS Kids' }
    ],
    specs: {
      Display: '7.0″ IPS HD',
      Features: 'Shockproof Silicone Bumper, Parental Controls',
      Battery: '3,000 mAh',
      Condition: 'Brand New'
    }
  },
  {
    id: 'apple-airpods',
    name: 'Apple AirPods',
    badge: 'badge-preowned',
    badgeLabel: 'Pre-owned',
    condition: 'Pre-owned',
    desc: 'High-fidelity audio · Automatic device switching · Siri voice control',
    fullDesc: 'Pre-owned authentic Apple AirPods with charging case. Fully sanitized, battery-tested, and sound verified.',
    image: 'assets/img/apple_airpods.jpeg',
    storageOptions: [
      { label: 'Standard', price: 6500, id: 'apple-airpods-white', stock: 10 }
    ],
    colorOptions: [
      { label: 'White', hex: '#f5f5f7', border: '#e2e2e4' }
    ],
    gallery: [
      { src: 'assets/img/apple_airpods.jpeg', thumb: 'assets/img/apple_airpods.jpeg', alt: 'Apple AirPods' }
    ],
    specs: {
      Connectivity: 'Bluetooth 5.0, Apple H1 chip',
      Battery: 'Up to 5 hours listening time',
      Case: 'Lightning Charging Case',
      Condition: 'Pre-owned'
    }
  },
  {
    id: 'apple-watch',
    name: 'Apple Watch',
    badge: 'badge-preowned',
    badgeLabel: 'Pre-owned',
    condition: 'Pre-owned',
    desc: 'Retina OLED display · Heart rate monitoring · Activity & workout tracking',
    fullDesc: 'Pre-owned Apple Watch thoroughly tested with clean iCloud status, responsive touchscreen, and health sensors.',
    image: 'assets/img/apple_watch.jpeg',
    storageOptions: [
      { label: '44mm', price: 11500, id: 'apple-watch-44mm-midnight', stock: 1 }
    ],
    colorOptions: [
      { label: 'Midnight', hex: '#1c1c1e', border: '' }
    ],
    gallery: [
      { src: 'assets/img/apple_watch.jpeg', thumb: 'assets/img/apple_watch.jpeg', alt: 'Apple Watch' }
    ],
    specs: {
      Display: 'OLED Retina Display',
      Sensors: 'Optical heart sensor, Accelerometer, Gyroscope',
      Connectivity: 'Bluetooth, Wi-Fi, GPS',
      Condition: 'Pre-owned'
    }
  }
];

function cheynFindProduct(id) {
  if (!id) return null;
  return CHEYN_PRODUCTS.find(function(p) { return p.id === id; }) || null;
}
