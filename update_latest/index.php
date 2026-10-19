<?php
$pageTitle       = 'Cheyn Gadgets | Pre-owned Phones in Roxas City';
$pageDescription = 'Carefully inspected pre-owned smartphones and gadgets in Roxas City, Capiz. Tested in person, honest battery health, and local shop support.';
$activePage      = 'home';
require 'includes/header.php';
?>

  <!-- ==============================================
       APPLE-GRADE SEAMLESS CINEMA HERO STAGE
       ============================================== -->
  <section class="apple-hero-video-section" aria-label="Welcome to Cheyn Gadgets">
    <div class="container">

      <!-- Eyebrow Tag -->
      <div class="apple-hero-eyebrow">
        <span class="apple-live-dot"></span>
        <span>Cheyn Gadgets &middot; Roxas City Storefront</span>
      </div>

      <!-- Main Headline -->
      <h1 class="apple-hero-headline">
        Pre-owned phones you can count on.
      </h1>

      <!-- Subtitle -->
      <p class="apple-hero-subtitle">
        Every phone is checked by hand at our local shop before listing. Honest battery health, clean condition, and 7-day replacement support.
      </p>

      <!-- Action Links -->
      <div class="apple-hero-actions">
        <a href="catalog.php" class="apple-hero-link-primary">
          View available phones <i class="bi bi-chevron-right"></i>
        </a>
        <a href="about.php" class="apple-hero-link-secondary">
          How we test our phones <i class="bi bi-chevron-right"></i>
        </a>
      </div>

      <!-- Cinematic Borderless Video Showcase -->
      <div class="apple-video-frame">
        <video class="w-100" autoplay loop muted playsinline poster="assets/img/iphone_15.jpeg">
          <source src="assets/video/iphone15_video.mp4" type="video/mp4">
          Your browser does not support HTML5 video.
        </video>
      </div>

      <!-- Integrated Hardware Inspection HUD -->
      <div class="apple-hero-hud">
        <div class="apple-hud-card">
          <div class="apple-hud-stat">85%+</div>
          <div class="apple-hud-label">Battery Health</div>
          <div class="apple-hud-sub">Maintained on all pre-owned units</div>
        </div>
        <div class="apple-hud-card">
          <div class="apple-hud-stat">Tested by Hand</div>
          <div class="apple-hud-label">In-Person Verification</div>
          <div class="apple-hud-sub">Screen, camera, mics &amp; network</div>
        </div>
        <div class="apple-hud-card">
          <div class="apple-hud-stat">7 Days</div>
          <div class="apple-hud-label">Shop Replacement</div>
          <div class="apple-hud-sub">Hassle-free local storefront swap</div>
        </div>
        <div class="apple-hud-card">
          <div class="apple-hud-stat">Roxas City</div>
          <div class="apple-hud-label">Local Storefront</div>
          <div class="apple-hud-sub">In-store testing before you buy</div>
        </div>
      </div>

    </div>
  </section>

  <!-- ==============================================
       DEVICE CATEGORY RIBBON
       ============================================== -->
  <section class="apple-category-section" id="categories">
    <div class="container">
      <div class="apple-section-header text-center">
        <span class="apple-section-tag">Categories</span>
        <h2 class="apple-section-title">Browse our selection.</h2>
        <p class="apple-section-subtitle mx-auto">
          From carefully tested pre-owned iPhones to Android devices, tablets, and accessories.
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
            <p class="apple-category-desc">Tested battery &amp; clean body</p>
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
            <p class="apple-category-desc">Samsung, Pixel &amp; more</p>
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
            <p class="apple-category-desc">For study, work, and family</p>
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
            <p class="apple-category-desc">Apple Watch &amp; sound</p>
            <span class="apple-category-price">From ₱11,500</span>
          </a>
        </div>
      </div>
    </div>
  </section>

  <!-- ==============================================
       HONEST & HUMBLE BENTO GRID (How we work)
       ============================================== -->
  <section class="apple-bento-section" id="standards">
    <div class="container">
      <div class="apple-section-header text-center mb-5">
        <span class="apple-section-tag">How we work</span>
        <h2 class="apple-section-title">A few things you can count on.</h2>
        <p class="apple-section-subtitle mx-auto">
          Buying second-hand shouldn't feel like a gamble. Here is how we check each phone before it reaches your hands.
        </p>
      </div>

      <div class="row g-4">
        <!-- Bento Tile 1: Checked in person (Wide 8-col) -->
        <div class="col-lg-8">
          <div class="apple-bento-card">
            <div class="apple-bento-icon">
              <i class="bi bi-phone"></i>
            </div>
            <h3 class="apple-bento-title">Tested in person before listing</h3>
            <p class="apple-bento-text">
              We check the essentials on every phone: touchscreen response, cameras, microphones, stereo speakers, Face ID or Touch ID, buttons, and network signal.
            </p>
            <div class="apple-diag-pills">
              <span class="apple-diag-pill"><i class="bi bi-display"></i> Screen &amp; Touch</span>
              <span class="apple-diag-pill"><i class="bi bi-person-bounding-box"></i> Face ID / Touch ID</span>
              <span class="apple-diag-pill"><i class="bi bi-camera"></i> Front &amp; Back Cameras</span>
              <span class="apple-diag-pill"><i class="bi bi-speaker"></i> Speakers &amp; Mic</span>
              <span class="apple-diag-pill"><i class="bi bi-broadcast-pin"></i> Openline Signal</span>
              <span class="apple-diag-pill"><i class="bi bi-check-circle"></i> Clean iCloud &amp; Google</span>
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
            <span class="apple-bento-metric-label mb-3 d-block">Minimum Battery Health</span>
            <p class="apple-bento-text mb-0">
              No worn-out batteries. Every pre-owned unit maintains at least 85% battery health so it comfortably gets you through the day.
            </p>
          </div>
        </div>

        <!-- Bento Tile 3: 7-Day Replacement (6-col) -->
        <div class="col-lg-6">
          <div class="apple-bento-card">
            <div class="apple-bento-icon">
              <i class="bi bi-arrow-repeat"></i>
            </div>
            <h3 class="apple-bento-title">7-Day shop replacement</h3>
            <p class="apple-bento-text mb-0">
              If you run into an unexpected hardware defect after purchasing, just bring the phone back to our Roxas City storefront and we will swap it or take care of it.
            </p>
          </div>
        </div>

        <!-- Bento Tile 4: Roxas City Local Presence (6-col) -->
        <div class="col-lg-6">
          <div class="apple-bento-card">
            <div class="apple-bento-icon">
              <i class="bi bi-geo-alt"></i>
            </div>
            <h3 class="apple-bento-title">A real shop in Roxas City</h3>
            <p class="apple-bento-text mb-0">
              We are not an anonymous online seller. Come visit us, hold the phone in your hand, and test everything at your own pace before deciding.
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
          <span class="apple-section-tag">In the shop</span>
          <h2 class="apple-section-title mb-0">Recently added.</h2>
        </div>
        <a href="catalog.php" class="btn btn-ct-outline btn-sm">View All Phones <i class="bi bi-arrow-right ms-1"></i></a>
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
        <a href="catalog.php" class="btn apple-btn-primary px-4">
          Browse All Available Phones <i class="bi bi-arrow-right ms-1"></i>
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
        <span class="apple-section-tag">Roxas City Shop</span>
        <h2 class="apple-section-title mb-3">Drop by the shop.</h2>
        <p class="apple-section-subtitle mx-auto mb-4">
          Have questions or want to see a phone in person? Visit our store in Roxas City, Capiz. You can inspect screens, compare battery percentages, and test features with no pressure.
        </p>
        <div class="d-flex justify-content-center align-items-center gap-3 flex-wrap">
          <a href="contact.php" class="btn apple-btn-primary">
            Store Location &amp; Hours <i class="bi bi-geo-alt ms-1"></i>
          </a>
          <a href="about.php" class="btn btn-ct-outline">
            About Cheyn Gadgets
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
