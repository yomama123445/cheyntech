<?php
$pageTitle   = 'Cheyn Gadgets | Function-Tested Phones in Roxas City';
$pageDescription = 'Every phone function-tested before listing. Pre-owned, refurbished, and brand-new phones and tablets from Cheyn\'s Gadgets, Roxas City — order online for pickup or local delivery.';
$activePage  = 'home';
require 'includes/header.php';
?>

  <!-- HERO -->
  <section class="hero-section" aria-label="Hero">
    <div class="container">
      <div class="row align-items-center gy-4">
        <div class="col-lg-6 col-md-7">
          <div class="hero-eyebrow">
            <span class="live-dot"></span>
            <span>Live Roxas City Storefront · In Stock for Pickup</span>
          </div>
          <h1>Tested Hardware.<br><span class="highlight">Certified Condition.</span></h1>
          <p class="lead mt-3">Every phone undergoes 20+ hardware diagnostic checks before listing. Inspected in-store with a 7-day replacement guarantee.</p>
          <div class="d-flex align-items-center gap-3 mt-4 flex-wrap">
            <a href="catalog.php" class="btn btn-ct text-white px-4">Browse Catalog <i class="bi bi-arrow-right ms-1"></i></a>
            <a href="track-order.php" class="btn btn-ct-outline px-4">Track Order</a>
          </div>
          <div class="d-flex gap-2 mt-4 pt-1 flex-wrap">
            <span class="badge-grade"><i class="bi bi-patch-check-fill text-success"></i> Grade A · Pristine</span>
            <span class="badge-grade"><i class="bi bi-battery-charging text-primary"></i> ≥85% Battery Health</span>
            <span class="badge-grade"><i class="bi bi-unlock-fill text-dark"></i> Factory Unlocked</span>
          </div>
        </div>
        <div class="col-lg-6 col-md-5 text-center d-none d-md-block">
          <div class="hero-device-wrapper">
            <!-- Floating diagnostic HUD proof chips -->
            <div class="hud-chip hud-top-left">
              <i class="bi bi-shield-check text-success fs-6"></i>
              <span>Clean IMEI · NTC</span>
            </div>
            <div class="hud-chip hud-bottom-left">
              <i class="bi bi-battery-charging text-primary fs-6"></i>
              <span>89% Battery Health</span>
            </div>
            <div class="hud-chip hud-bottom-right">
              <i class="bi bi-check2-circle text-info fs-6"></i>
              <span>Face ID &amp; Cameras Passed</span>
            </div>

            <div class="hero-img-frame">
              <a href="product.php?id=iphone13" class="d-flex align-items-center justify-content-center w-100 h-100 text-decoration-none">
                <img
                  id="heroProductImg"
                  src="assets/img/iphone_13pro.jpeg"
                  alt="Featured product — iPhone 13"
                  class="hero-product-img"
                  loading="eager"
                  onerror="this.onerror=null;this.src='assets/products/placeholder.jpg'"
                >
              </a>
            </div>
          </div>
          <p class="hero-img-caption" id="heroProductCaption">iPhone 13 · 128GB · Midnight</p>
        </div>
      </div>
    </div>
  </section>

  <!-- 20-POINT DIAGNOSTIC INSPECTION STRIP -->
  <div class="diagnostic-strip">
    <div class="container">
      <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-4 g-3">
        <div class="col">
          <div class="diagnostic-item">
            <div class="diag-icon"><i class="bi bi-display"></i></div>
            <div class="diag-info">
              <span class="diag-title">Screen &amp; TrueTone</span>
              <span class="diag-spec">OLED Touch &amp; Pixels</span>
              <span class="diag-status"><i class="bi bi-check-circle-fill"></i> Passed</span>
            </div>
          </div>
        </div>
        <div class="col">
          <div class="diagnostic-item">
            <div class="diag-icon"><i class="bi bi-battery-charging"></i></div>
            <div class="diag-info">
              <span class="diag-title">Battery Health</span>
              <span class="diag-spec">Capacity ≥85% Guaranteed</span>
              <span class="diag-status"><i class="bi bi-check-circle-fill"></i> Certified</span>
            </div>
          </div>
        </div>
        <div class="col">
          <div class="diagnostic-item">
            <div class="diag-icon"><i class="bi bi-camera"></i></div>
            <div class="diag-info">
              <span class="diag-title">Audio &amp; Cameras</span>
              <span class="diag-spec">Stereo Mic, 4K &amp; Face ID</span>
              <span class="diag-status"><i class="bi bi-check-circle-fill"></i> Verified</span>
            </div>
          </div>
        </div>
        <div class="col">
          <div class="diagnostic-item">
            <div class="diag-icon"><i class="bi bi-upc-scan"></i></div>
            <div class="diag-info">
              <span class="diag-title">Network &amp; IMEI</span>
              <span class="diag-spec">Factory Unlocked · Clean</span>
              <span class="diag-status"><i class="bi bi-check-circle-fill"></i> NTC Clean</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- SHOP BY CATEGORY -->
  <section class="py-5" id="categories">
    <div class="container">
      <div class="section-header text-center">
        <span class="section-label">Browse</span>
        <h2 class="section-title">Shop by Category</h2>
        <p class="section-subtitle">Find the right device for every need and budget</p>
      </div>
      <div class="row g-3 justify-content-center">
        <div class="col-6 col-md-3">
          <a href="catalog.php?cat=preowned" class="category-card h-100">
            <div class="cat-img-wrap">
              <i class="bi bi-phone cat-icon"></i>
            </div>
            <p class="cat-name mb-0">Pre-owned iPhones</p>
            <span class="cat-count">Quality-checked units</span>
          </a>
        </div>
        <div class="col-6 col-md-3">
          <a href="catalog.php?cat=new" class="category-card h-100">
            <div class="cat-img-wrap">
              <i class="bi bi-phone-fill cat-icon"></i>
            </div>
            <p class="cat-name mb-0">New iPhones</p>
            <span class="cat-count">Brand-new sealed units</span>
          </a>
        </div>
        <div class="col-6 col-md-3">
          <a href="catalog.php?cat=android" class="category-card h-100">
            <div class="cat-img-wrap">
              <i class="bi bi-grid cat-icon"></i>
            </div>
            <p class="cat-name mb-0">Android</p>
            <span class="cat-count">Samsung, Pixel &amp; more</span>
          </a>
        </div>
        <div class="col-6 col-md-3">
          <a href="catalog.php?cat=tablet" class="category-card h-100">
            <div class="cat-img-wrap">
              <i class="bi bi-tablet cat-icon"></i>
            </div>
            <p class="cat-name mb-0">Tablets</p>
            <span class="cat-count">iPad &amp; Android tablets</span>
          </a>
        </div>
      </div>
    </div>
  </section>

  <div class="section-divider"></div>

  <!-- FEATURED PRODUCTS -->
  <section class="py-5 bg-ct-soft" id="featured">
    <div class="container">
      <div class="section-header d-flex align-items-end justify-content-between flex-wrap gap-2">
        <div>
          <span class="section-label">Hot Picks</span>
          <h2 class="section-title">Featured Products</h2>
        </div>
        <a href="catalog.php" class="btn btn-ct-outline btn-sm mb-1">View All <i class="bi bi-arrow-right ms-1"></i></a>
      </div>
      <div class="row row-cols-2 row-cols-md-3 row-cols-xl-4 g-3" id="featuredGrid">

        <div class="col">
          <article class="product-card">
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

        <div class="col">
          <article class="product-card">
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

        <div class="col">
          <article class="product-card">
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

        <div class="col">
          <article class="product-card">
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

        <div class="col">
          <article class="product-card">
            <div class="card-img-wrap">
              <img src="assets/img/iphone_15.jpeg" alt="iPhone 15 128GB Black" loading="lazy" onerror="this.onerror=null;this.src='assets/products/placeholder.jpg'">
              <span class="badge-ct badge-preowned">Pre-owned</span>
            </div>
            <div class="card-body">
              <p class="product-name">iPhone 15 – 128GB Black</p>
              <div class="product-spec-row">
                <span class="spec-chip">128GB</span>
                <span class="spec-chip">Pristine</span>
                <span class="spec-chip text-success"><i class="bi bi-battery-charging"></i> 96%</span>
              </div>
              <p class="product-price">₱41,500</p>
            </div>
            <div class="card-footer">
              <button class="btn btn-ct btn-ct-sm flex-grow-1" onclick="quickAddToCart({id:'iphone15-128gb-black',name:'iPhone 15 128GB Black',price:41500,variant:'128GB',color:'Black',image:'assets/img/iphone_15.jpeg'}, this)">
                <i class="bi bi-cart-plus me-1"></i>Add
              </button>
              <a href="product.php?id=iphone15" class="btn btn-ct-outline btn-ct-sm">View</a>
            </div>
          </article>
        </div>

        <div class="col">
          <article class="product-card">
            <div class="card-img-wrap">
              <img src="assets/img/samsunggalaxy_A06.jpeg" alt="Samsung Galaxy A06 5G 128GB Light Blue" loading="lazy" onerror="this.onerror=null;this.src='assets/products/placeholder.jpg'">
              <span class="badge-ct badge-available">Brand New</span>
            </div>
            <div class="card-body">
              <p class="product-name">Samsung Galaxy A06 5G – 128GB</p>
              <div class="product-spec-row">
                <span class="spec-chip">128GB</span>
                <span class="spec-chip text-primary">Sealed Box</span>
                <span class="spec-chip"><i class="bi bi-shield-check text-success"></i> NTC</span>
              </div>
              <p class="product-price">₱6,290</p>
            </div>
            <div class="card-footer">
              <button class="btn btn-ct btn-ct-sm flex-grow-1" onclick="quickAddToCart({id:'samsung-a06-128gb-lightblue',name:'Samsung Galaxy A06 5G 128GB',price:6290,variant:'128GB',color:'Light Blue',image:'assets/img/samsunggalaxy_A06.jpeg'}, this)">
                <i class="bi bi-cart-plus me-1"></i>Add
              </button>
              <a href="product.php?id=samsung-a06" class="btn btn-ct-outline btn-ct-sm">View</a>
            </div>
          </article>
        </div>

        <div class="col">
          <article class="product-card">
            <div class="card-img-wrap">
              <img src="assets/img/ipad_9th_gen.jpeg" alt="Apple iPad 10th Gen 128GB Silver" loading="lazy" onerror="this.onerror=null;this.src='assets/products/placeholder.jpg'">
              <span class="badge-ct badge-preowned">Pre-owned</span>
            </div>
            <div class="card-body">
              <p class="product-name">Apple iPad 10th Gen – 128GB</p>
              <div class="product-spec-row">
                <span class="spec-chip">128GB</span>
                <span class="spec-chip">Grade A</span>
                <span class="spec-chip text-success"><i class="bi bi-battery-charging"></i> 91%</span>
              </div>
              <p class="product-price">₱23,500</p>
            </div>
            <div class="card-footer">
              <button class="btn btn-ct btn-ct-sm flex-grow-1" onclick="quickAddToCart({id:'ipad10-128gb-silver',name:'Apple iPad 10th Gen 128GB',price:23500,variant:'128GB',color:'Silver',image:'assets/img/ipad_9th_gen.jpeg'}, this)">
                <i class="bi bi-cart-plus me-1"></i>Add
              </button>
              <a href="product.php?id=ipad10" class="btn btn-ct-outline btn-ct-sm">View</a>
            </div>
          </article>
        </div>

        <div class="col">
          <article class="product-card">
            <div class="card-img-wrap">
              <img src="assets/img/apple_watch.jpeg" alt="Apple Watch 44mm Midnight" loading="lazy" onerror="this.onerror=null;this.src='assets/products/placeholder.jpg'">
              <span class="badge-ct badge-preowned">Pre-owned</span>
            </div>
            <div class="card-body">
              <p class="product-name">Apple Watch – 44mm Midnight</p>
              <div class="product-spec-row">
                <span class="spec-chip">44mm</span>
                <span class="spec-chip">Grade A</span>
                <span class="spec-chip text-success"><i class="bi bi-battery-charging"></i> 90%</span>
              </div>
              <p class="product-price">₱11,500</p>
            </div>
            <div class="card-footer">
              <button class="btn btn-ct btn-ct-sm flex-grow-1" onclick="quickAddToCart({id:'apple-watch-44mm-midnight',name:'Apple Watch 44mm Midnight',price:11500,variant:'44mm',color:'Midnight',image:'assets/img/apple_watch.jpeg'}, this)">
                <i class="bi bi-cart-plus me-1"></i>Add
              </button>
              <a href="product.php?id=apple-watch" class="btn btn-ct-outline btn-ct-sm">View</a>
            </div>
          </article>
        </div>

      </div><!-- /row -->
      <div class="text-center mt-4">
        <a href="catalog.php" class="btn btn-ct text-white px-5">Browse All Products <i class="bi bi-grid ms-1"></i></a>
      </div>
    </div>
  </section>

  <!-- CTA BANNER -->
  <section class="cta-section text-center">
    <div class="container">
      <h2 class="mb-2">Find your exact device in Roxas City.</h2>
      <p class="mb-4 mx-auto text-slate-400" style="max-width: 480px; color: #94a3b8;">Filter by budget, brand, or condition for in-store pickup or local delivery.</p>
      <div class="d-flex justify-content-center gap-2 flex-wrap mb-4">
        <a href="catalog.php?cat=preowned" class="quick-pill"><i class="bi bi-phone me-1"></i> Pre-owned iPhones</a>
        <a href="catalog.php?cat=new" class="quick-pill"><i class="bi bi-box-seam me-1"></i> Brand New Sealed</a>
        <a href="catalog.php?cat=android" class="quick-pill"><i class="bi bi-grid me-1"></i> Android Phones</a>
        <a href="catalog.php?cat=tablet" class="quick-pill"><i class="bi bi-tablet me-1"></i> iPads &amp; Tablets</a>
      </div>
      <div class="d-flex justify-content-center gap-3 flex-wrap">
        <a href="catalog.php" class="btn btn-cta-light px-4">Browse All Inventory <i class="bi bi-arrow-right ms-1"></i></a>
        <a href="track-order.php" class="btn btn-cta-outline-light px-4">Track Order</a>
      </div>
    </div>
  </section>

<?php require 'includes/footer.php'; ?>
  <script src="assets/js/index.js"></script>
</body>
</html>
