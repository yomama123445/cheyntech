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
            <span class="eyebrow-dot"></span>
            <span>Cheyn's Gadgets · Roxas City Storefront</span>
          </div>
          <h1>Every phone <span class="highlight">function-tested</span> before it reaches you.</h1>
          <p class="lead mt-3">Pre-owned, refurbished, and brand-new smartphones and tablets — graded in-store and available for pickup or local delivery across Roxas City.</p>
          <div class="d-flex align-items-center gap-3 mt-4 flex-wrap">
            <a href="catalog.php" class="btn btn-ct text-white px-4">Browse Catalog <i class="bi bi-arrow-right ms-1"></i></a>
            <a href="track-order.php" class="btn btn-ct-outline px-4">Track Order</a>
          </div>
          <div class="d-flex gap-4 mt-4 pt-2 flex-wrap">
            <div class="d-flex align-items-center gap-2 text-secondary">
              <i class="bi bi-shield-check text-ct fs-5"></i>
              <span class="small fw-semibold">7-Day Guarantee</span>
            </div>
            <div class="d-flex align-items-center gap-2 text-secondary">
              <i class="bi bi-truck text-ct fs-5"></i>
              <span class="small fw-semibold">Roxas City Delivery</span>
            </div>
            <div class="d-flex align-items-center gap-2 text-secondary">
              <i class="bi bi-patch-check-fill text-ct fs-5"></i>
              <span class="small fw-semibold">20+ Point Inspection</span>
            </div>
          </div>
        </div>
        <div class="col-lg-6 col-md-5 text-center d-none d-md-block">
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
          <p class="hero-img-caption" id="heroProductCaption">iPhone 13 · 128GB · Midnight</p>
        </div>
      </div>
    </div>
  </section>

  <!-- FEATURE / CERTIFICATION STRIP -->
  <div class="feature-strip">
    <div class="container">
      <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-4 g-3">
        <div class="col">
          <div class="feature-strip-item">
            <i class="bi bi-shield-check"></i>
            <div class="strip-text">
              <span class="strip-title">7-Day Replacement</span>
              <span class="strip-desc">Store warranty on functional defects</span>
            </div>
          </div>
        </div>
        <div class="col">
          <div class="feature-strip-item">
            <i class="bi bi-cpu"></i>
            <div class="strip-text">
              <span class="strip-title">Hardware Tested</span>
              <span class="strip-desc">Cameras, screen, battery &amp; speakers</span>
            </div>
          </div>
        </div>
        <div class="col">
          <div class="feature-strip-item">
            <i class="bi bi-upc-scan"></i>
            <div class="strip-text">
              <span class="strip-title">IMEI Verified</span>
              <span class="strip-desc">Authentic serial &amp; clean status</span>
            </div>
          </div>
        </div>
        <div class="col">
          <div class="feature-strip-item">
            <i class="bi bi-geo-alt-fill"></i>
            <div class="strip-text">
              <span class="strip-title">Roxas City Storefront</span>
              <span class="strip-desc">Capiz pickup &amp; local dispatch</span>
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
      <div class="d-inline-flex align-items-center gap-2 px-3 py-1 mb-3 rounded-pill" style="background:#1e293b;border:1px solid #334155;font-size:0.75rem;color:#cbd5e1;text-transform:uppercase;letter-spacing:0.08em;font-weight:600;">
        <i class="bi bi-shield-check text-primary"></i>
        <span>Certified Electronics Storefront</span>
      </div>
      <h2 class="mb-3">Ready to find your next gadget?</h2>
      <p class="mb-4 mx-auto" style="max-width: 520px; color: #94a3b8; font-size: 1.05rem;">Browse function-tested iPhones, Android smartphones, and tablets. Order online for pickup or fast Roxas City delivery.</p>
      <div class="d-flex justify-content-center gap-3 flex-wrap">
        <a href="catalog.php" class="btn btn-cta-light">Browse Catalog <i class="bi bi-arrow-right ms-1"></i></a>
        <a href="track-order.php" class="btn btn-cta-outline-light">Track Existing Order</a>
      </div>
    </div>
  </section>

<?php require 'includes/footer.php'; ?>
  <script src="assets/js/index.js"></script>
</body>
</html>
