<?php
$pageTitle       = 'Cheyn Gadgets | Certified Tech in Roxas City';
$pageDescription = 'Function-tested smartphones and tablets in Roxas City, Capiz. Pre-owned and brand-new devices inspected in-store for immediate pickup or delivery.';
$activePage      = 'home';
require 'includes/header.php';
?>

  <!-- ==============================================
       CINEMATIC VIDEO HERO STAGE (Apple-grade)
       ============================================== -->
  <section class="apple-hero-video-section" aria-label="Featured Innovation">
    <div class="container">

      <!-- Eyebrow Tag -->
      <div class="apple-hero-eyebrow">
        <span class="apple-live-dot"></span>
        <span>Cheyn Certified &middot; Roxas City Storefront</span>
      </div>

      <!-- Main Headline -->
      <h1 class="apple-hero-headline">
        Function-tested. <span class="apple-gradient-text">Certified.</span><br>Ready for you.
      </h1>

      <!-- Subtitle -->
      <p class="apple-hero-subtitle">
        Every smartphone and tablet is rigorously inspected at our Capiz workbench before listing. Experience premium technology with local in-store pickup or same-day delivery.
      </p>

      <!-- Action Buttons -->
      <div class="apple-hero-actions">
        <a href="catalog.php" class="btn apple-btn-primary">
          Browse Inventory <i class="bi bi-arrow-right ms-1"></i>
        </a>
        <a href="about.php" class="btn apple-btn-secondary">
          Our Inspection Process
        </a>
      </div>

      <!-- Cinematic Looping Video Stage -->
      <div class="apple-video-frame">
        <video class="w-100" autoplay loop muted playsinline poster="assets/img/iphone_15.jpeg">
          <source src="assets/video/iphone15_video.mp4" type="video/mp4">
          Your browser does not support HTML5 video.
        </video>
      </div>
      <p class="apple-video-caption">
        iPhone 15 Series &middot; Titanium Design &middot; Function-Tested &amp; Sealed Units
      </p>

      <!-- Micro Trust Strip -->
      <div class="apple-hero-trust-strip">
        <div class="apple-hero-trust-item">
          <i class="bi bi-shield-check"></i>
          <span>7-Day In-Store Replacement</span>
        </div>
        <div class="apple-hero-trust-item">
          <i class="bi bi-battery-charging"></i>
          <span>85%+ Battery Health Certified</span>
        </div>
        <div class="apple-hero-trust-item">
          <i class="bi bi-cpu"></i>
          <span>50-Point Bench Diagnostic</span>
        </div>
        <div class="apple-hero-trust-item">
          <i class="bi bi-geo-alt"></i>
          <span>Roxas City Local Dispatch</span>
        </div>
      </div>

    </div>
  </section>

  <!-- ==============================================
       APPLE-STYLE DEVICE CATEGORY RIBBON
       ============================================== -->
  <section class="apple-category-section" id="categories">
    <div class="container">
      <div class="apple-section-header text-center">
        <span class="apple-section-tag">Explore Cheyn</span>
        <h2 class="apple-section-title">Choose your device.</h2>
        <p class="apple-section-subtitle mx-auto">
          Every device function-tested, iCloud/Google cleared, and backed by our Roxas City storefront.
        </p>
      </div>

      <div class="row row-cols-2 row-cols-md-3 row-cols-lg-5 g-3 justify-content-center">
        <!-- 1. Pre-owned iPhones -->
        <div class="col">
          <a href="catalog.php?cat=preowned" class="apple-category-card">
            <span class="apple-category-pill">Pre-owned</span>
            <div class="apple-category-img-wrap">
              <img src="assets/img/iphone_13pro.jpeg" alt="Pre-owned iPhones" class="apple-category-img" loading="lazy">
            </div>
            <h3 class="apple-category-name">Pre-owned iPhone</h3>
            <p class="apple-category-desc">Tested battery &amp; Grade A</p>
            <span class="apple-category-price">From ₱17,500</span>
          </a>
        </div>

        <!-- 2. Brand New iPhones -->
        <div class="col">
          <a href="catalog.php?cat=new" class="apple-category-card">
            <span class="apple-category-pill">Brand New</span>
            <div class="apple-category-img-wrap">
              <img src="assets/img/iphone_14.jpeg" alt="Brand New iPhones" class="apple-category-img" loading="lazy">
            </div>
            <h3 class="apple-category-name">New iPhone</h3>
            <p class="apple-category-desc">Factory sealed with warranty</p>
            <span class="apple-category-price">From ₱41,900</span>
          </a>
        </div>

        <!-- 3. Android Flagships -->
        <div class="col">
          <a href="catalog.php?cat=android" class="apple-category-card">
            <span class="apple-category-pill">Android</span>
            <div class="apple-category-img-wrap">
              <img src="assets/img/samsung_galaxy_s22.jpeg" alt="Android Phones" class="apple-category-img" loading="lazy">
            </div>
            <h3 class="apple-category-name">Android</h3>
            <p class="apple-category-desc">Samsung, Pixel &amp; OnePlus</p>
            <span class="apple-category-price">From ₱6,290</span>
          </a>
        </div>

        <!-- 4. Tablets & iPads -->
        <div class="col">
          <a href="catalog.php?cat=tablet" class="apple-category-card">
            <span class="apple-category-pill">Tablets</span>
            <div class="apple-category-img-wrap">
              <img src="assets/img/ipad_9th_gen.jpeg" alt="iPads and Tablets" class="apple-category-img" loading="lazy">
            </div>
            <h3 class="apple-category-name">iPad &amp; Tablets</h3>
            <p class="apple-category-desc">For study, work, and media</p>
            <span class="apple-category-price">From ₱22,000</span>
          </a>
        </div>

        <!-- 5. Audio & Wearables -->
        <div class="col">
          <a href="catalog.php?cat=wearable" class="apple-category-card">
            <span class="apple-category-pill">Accessories</span>
            <div class="apple-category-img-wrap">
              <img src="assets/img/apple_watch.jpeg" alt="Apple Watch & Audio" class="apple-category-img" loading="lazy">
            </div>
            <h3 class="apple-category-name">Wearables</h3>
            <p class="apple-category-desc">Apple Watch &amp; AirPods</p>
            <span class="apple-category-price">From ₱11,500</span>
          </a>
        </div>
      </div>
    </div>
  </section>

  <!-- ==============================================
       APPLE BENTO TRUST GRID (4 Core Pillars)
       ============================================== -->
  <section class="apple-bento-section" id="standards">
    <div class="container">
      <div class="apple-section-header text-center mb-5">
        <span class="apple-section-tag">The Cheyn Standard</span>
        <h2 class="apple-section-title text-white">Engineered for confidence.</h2>
        <p class="apple-section-subtitle mx-auto text-secondary text-white-50">
          Every device sold goes through a meticulous bench verification process at our local storefront.
        </p>
      </div>

      <div class="row g-4">
        <!-- Bento Tile 1: 50-Point Bench Diagnostic (Wide 8-col) -->
        <div class="col-lg-8">
          <div class="apple-bento-card apple-bento-card-featured">
            <div class="apple-bento-icon">
              <i class="bi bi-cpu"></i>
            </div>
            <h3 class="apple-bento-title">50-Point Precision Bench Diagnostic</h3>
            <p class="apple-bento-text">
              We never guess device health. Every smartphone is connected to hardware diagnostic tools to evaluate pixel health, Touch response, True Tone, Face ID, cellular bands, stereo microphones, and charging ICs.
            </p>
            <div class="apple-diag-pills">
              <span class="apple-diag-pill"><i class="bi bi-display"></i> OLED &amp; Touch Matrix</span>
              <span class="apple-diag-pill"><i class="bi bi-person-bounding-box"></i> Face ID / Biometrics</span>
              <span class="apple-diag-pill"><i class="bi bi-camera"></i> 4K OIS &amp; Zoom Optics</span>
              <span class="apple-diag-pill"><i class="bi bi-speaker"></i> Stereo Audio &amp; Mics</span>
              <span class="apple-diag-pill"><i class="bi bi-broadcast-pin"></i> 5G / LTE Openline</span>
              <span class="apple-diag-pill"><i class="bi bi-shield-lock"></i> Clean IMEI &amp; NTC</span>
            </div>
          </div>
        </div>

        <!-- Bento Tile 2: Battery Health (4-col) -->
        <div class="col-lg-4">
          <div class="apple-bento-card">
            <div class="apple-bento-icon">
              <i class="bi bi-battery-charging"></i>
            </div>
            <div class="apple-bento-metric">85%+</div>
            <span class="apple-bento-metric-label mb-3 d-block">Minimum Certified Capacity</span>
            <p class="apple-bento-text mb-0">
              Zero degraded cells. Every pre-owned battery is tested for charge cycle retention, impedance, and thermal stability so your unit easily lasts all day.
            </p>
          </div>
        </div>

        <!-- Bento Tile 3: 7-Day Replacement Guarantee (6-col) -->
        <div class="col-lg-6">
          <div class="apple-bento-card">
            <div class="apple-bento-icon">
              <i class="bi bi-arrow-repeat"></i>
            </div>
            <h3 class="apple-bento-title">7-Day In-Store Replacement</h3>
            <p class="apple-bento-text mb-0">
              Complete peace of mind. In the rare event of a verified manufacturer or hardware defect, exchange your unit directly at our Roxas City storefront without delays or bureaucratic claims.
            </p>
          </div>
        </div>

        <!-- Bento Tile 4: Roxas City Local Presence (6-col) -->
        <div class="col-lg-6">
          <div class="apple-bento-card">
            <div class="apple-bento-icon">
              <i class="bi bi-geo-alt"></i>
            </div>
            <h3 class="apple-bento-title">Roxas City Storefront &amp; Dispatch</h3>
            <p class="apple-bento-text mb-0">
              Not a faceless drop-shipper. We operate an active physical tech storefront in Roxas City, Capiz. Inspect units in your own hands or receive express delivery across Capiz.
            </p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- ==============================================
       FEATURED HARDWARE SHOWCASE
       ============================================== -->
  <section class="py-5 bg-white" id="featured">
    <div class="container">
      <div class="d-flex align-items-end justify-content-between flex-wrap gap-2 mb-4">
        <div>
          <span class="apple-section-tag">In Stock Today</span>
          <h2 class="apple-section-title mb-0">Featured Devices.</h2>
        </div>
        <a href="catalog.php" class="btn btn-ct-outline btn-sm">View All Inventory <i class="bi bi-arrow-right ms-1"></i></a>
      </div>

      <div class="row row-cols-2 row-cols-md-3 row-cols-xl-4 g-3" id="featuredGrid">

        <!-- Product 1 -->
        <div class="col">
          <article class="product-card spotlight-card">
            <div class="card-img-wrap">
              <img src="assets/img/iphone_13pro.jpeg" alt="iPhone 13 128GB Midnight" loading="lazy" onerror="this.onerror=null;this.src='assets/products/placeholder.jpg'">
              <span class="badge-ct badge-preowned">Pre-owned</span>
            </div>
            <div class="card-body">
              <p class="product-name">iPhone 13 – 128GB Midnight</p>
              <div class="product-spec-row">
                <span class="spec-chip">128GB</span>
                <span class="spec-chip">Grade A</span>
                <span class="spec-chip text-success"><i class="bi bi-battery-charging"></i> 89%</span>
              </div>
              <p class="product-price">₱29,500</p>
            </div>
            <div class="card-footer">
              <button class="btn btn-ct btn-ct-sm flex-grow-1" onclick="quickAddToCart({id:'iphone13-128gb-midnight',name:'iPhone 13 128GB Midnight',price:29500,variant:'128GB',color:'Midnight',image:'assets/img/iphone_13pro.jpeg'}, this)">
                <i class="bi bi-cart-plus me-1"></i>Add
              </button>
              <a href="product.php?id=iphone13" class="btn btn-ct-outline btn-ct-sm">View</a>
            </div>
          </article>
        </div>

        <!-- Product 2 -->
        <div class="col">
          <article class="product-card spotlight-card">
            <div class="card-img-wrap">
              <img src="assets/img/iPhone_12.jpeg" alt="iPhone 12 128GB Blue" loading="lazy" onerror="this.onerror=null;this.src='assets/products/placeholder.jpg'">
              <span class="badge-ct badge-preowned">Pre-owned</span>
            </div>
            <div class="card-body">
              <p class="product-name">iPhone 12 – 128GB Blue</p>
              <div class="product-spec-row">
                <span class="spec-chip">128GB</span>
                <span class="spec-chip">Grade A</span>
                <span class="spec-chip text-success"><i class="bi bi-battery-charging"></i> 87%</span>
              </div>
              <p class="product-price">₱24,500</p>
            </div>
            <div class="card-footer">
              <button class="btn btn-ct btn-ct-sm flex-grow-1" onclick="quickAddToCart({id:'iphone12-128gb-blue',name:'iPhone 12 128GB Blue',price:24500,variant:'128GB',color:'Blue',image:'assets/img/iPhone_12.jpeg'}, this)">
                <i class="bi bi-cart-plus me-1"></i>Add
              </button>
              <a href="product.php?id=iphone12" class="btn btn-ct-outline btn-ct-sm">View</a>
            </div>
          </article>
        </div>

        <!-- Product 3 -->
        <div class="col">
          <article class="product-card spotlight-card">
            <div class="card-img-wrap">
              <img src="assets/img/iphone_11.jpeg" alt="iPhone 11 128GB Black" loading="lazy" onerror="this.onerror=null;this.src='assets/products/placeholder.jpg'">
              <span class="badge-ct badge-preowned">Pre-owned</span>
            </div>
            <div class="card-body">
              <p class="product-name">iPhone 11 – 128GB Black</p>
              <div class="product-spec-row">
                <span class="spec-chip">128GB</span>
                <span class="spec-chip">Grade A</span>
                <span class="spec-chip text-success"><i class="bi bi-battery-charging"></i> 86%</span>
              </div>
              <p class="product-price">₱18,500</p>
            </div>
            <div class="card-footer">
              <button class="btn btn-ct btn-ct-sm flex-grow-1" onclick="quickAddToCart({id:'iphone11-128gb-black',name:'iPhone 11 128GB Black',price:18500,variant:'128GB',color:'Black',image:'assets/img/iphone_11.jpeg'}, this)">
                <i class="bi bi-cart-plus me-1"></i>Add
              </button>
              <a href="product.php?id=iphone11" class="btn btn-ct-outline btn-ct-sm">View</a>
            </div>
          </article>
        </div>

        <!-- Product 4 -->
        <div class="col">
          <article class="product-card spotlight-card">
            <div class="card-img-wrap">
              <img src="assets/img/iphone_14.jpeg" alt="iPhone 14 128GB Midnight" loading="lazy" onerror="this.onerror=null;this.src='assets/products/placeholder.jpg'">
              <span class="badge-ct badge-preowned">Pre-owned</span>
            </div>
            <div class="card-body">
              <p class="product-name">iPhone 14 – 128GB Midnight</p>
              <div class="product-spec-row">
                <span class="spec-chip">128GB</span>
                <span class="spec-chip">Grade A+</span>
                <span class="spec-chip text-success"><i class="bi bi-battery-charging"></i> 92%</span>
              </div>
              <p class="product-price">₱34,500</p>
            </div>
            <div class="card-footer">
              <button class="btn btn-ct btn-ct-sm flex-grow-1" onclick="quickAddToCart({id:'iphone14-128gb-midnight',name:'iPhone 14 128GB Midnight',price:34500,variant:'128GB',color:'Midnight',image:'assets/img/iphone_14.jpeg'}, this)">
                <i class="bi bi-cart-plus me-1"></i>Add
              </button>
              <a href="product.php?id=iphone14" class="btn btn-ct-outline btn-ct-sm">View</a>
            </div>
          </article>
        </div>

      </div>

      <div class="text-center mt-5">
        <a href="catalog.php" class="btn apple-btn-primary px-5">
          Browse All Available Devices <i class="bi bi-grid ms-1"></i>
        </a>
      </div>
    </div>
  </section>

  <!-- ==============================================
       PHYSICAL STOREFRONT PRESENCE (Roxas City)
       ============================================== -->
  <section class="apple-storefront-section">
    <div class="container">
      <div class="apple-storefront-card">
        <span class="apple-section-tag">Roxas City Experience</span>
        <h2 class="apple-section-title mb-3">Visit us in person.</h2>
        <p class="apple-section-subtitle mx-auto mb-4">
          Test any device in your own hands before purchasing. Inspect screens, compare battery health percentages, and speak directly with our technicians at our physical store in Roxas City, Capiz.
        </p>
        <div class="d-flex justify-content-center align-items-center gap-3 flex-wrap">
          <a href="contact.php" class="btn apple-btn-primary">
            Store Location &amp; Hours <i class="bi bi-geo-alt ms-1"></i>
          </a>
          <a href="about.php" class="btn btn-ct-outline">
            About Our Store
          </a>
        </div>
      </div>
    </div>
  </section>

  <!-- Invisible anchors for JS backward-compatibility -->
  <div class="d-none" aria-hidden="true">
    <img id="heroProductImg" src="assets/img/iphone_13pro.jpeg" alt="Hero">
    <span id="heroProductCaption"></span>
  </div>

<?php require 'includes/footer.php'; ?>
  <script src="<?= asset_url('assets/js/index.js') ?>"></script>
</body>
</html>
