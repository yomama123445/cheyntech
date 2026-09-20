<?php
$pageTitle   = 'CheynTech | Function-Tested Phones in Roxas City';
$pageDescription = 'Every phone function-tested before listing. Pre-owned, refurbished, and brand-new phones and tablets from Cheyn\'s Gadgets, Roxas City — order online for pickup or local delivery.';
$activePage  = 'home';
require 'includes/header.php';
?>

  <!-- HERO -->
  <section class="hero-section" aria-label="Hero">
    <div class="container">
      <div class="row align-items-center gy-4">
        <div class="col-lg-6 col-md-7">
          <p class="hero-eyebrow mb-2">Cheyn's Gadgets · Roxas City</p>
          <h1>Every phone <span class="highlight">function-tested</span> before it reaches you.</h1>
          <p class="lead mt-3">Pre-owned, refurbished, and brand-new phones and tablets from Cheyn's Gadgets — graded in-store and available for pickup or delivery in Roxas City.</p>
          <div class="mt-4">
            <a href="catalog.php" class="btn btn-ct text-white">Shop Now <i class="bi bi-arrow-right ms-1"></i></a>
          </div>
          <div class="d-flex gap-3 mt-4 flex-wrap">
            <div class="d-flex align-items-center gap-1 text-muted">
              <i class="bi bi-shield-fill-check text-ct"></i>
              <span class="small">7-Day Guarantee</span>
            </div>
            <div class="d-flex align-items-center gap-1 text-muted">
              <i class="bi bi-truck text-ct"></i>
              <span class="small">Local Delivery</span>
            </div>
            <div class="d-flex align-items-center gap-1 text-muted">
              <i class="bi bi-patch-check-fill text-ct"></i>
              <span class="small">Function Tested</span>
            </div>
          </div>
        </div>
        <div class="col-lg-6 col-md-5 text-center d-none d-md-block">
          <div class="hero-img-frame">
            <img
              id="heroProductImg"
              src=""
              alt=""
              class="hero-product-img"
              loading="eager"
            >
          </div>
          <p class="hero-img-caption" id="heroProductCaption"></p>
        </div>
      </div>
    </div>
  </section>


  <!-- FEATURE STRIP -->
  <div class="feature-strip">
    <div class="container">
      <div class="row row-cols-2 row-cols-md-4 g-3 justify-content-center text-center">
        <div class="col">
          <div class="feature-strip-item">
            <i class="bi bi-recycle"></i>
            <span>Pre-owned, Refurbished &amp; Brand New</span>
          </div>
        </div>
        <div class="col">
          <div class="feature-strip-item">
            <i class="bi bi-cash-coin"></i>
            <span>Cash · GCash · Bank Transfer</span>
          </div>
        </div>
        <div class="col">
          <div class="feature-strip-item">
            <i class="bi bi-upc-scan"></i>
            <span>IMEI Verified Units</span>
          </div>
        </div>
        <div class="col">
          <div class="feature-strip-item">
            <i class="bi bi-geo-alt-fill"></i>
            <span>Roxas City, Capiz</span>
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
              <img src="/assets/products/category-preowned.jpg" alt="Pre-owned iPhones" loading="lazy">
            </div>
            <p class="cat-name mb-0">Pre-owned iPhones</p>
            <span class="cat-count">Quality-checked units</span>
          </a>
        </div>
        <div class="col-6 col-md-3">
          <a href="catalog.php?cat=new" class="category-card h-100">
            <div class="cat-img-wrap">
              <img src="/assets/products/category-new.jpg" alt="New iPhones" loading="lazy">
            </div>
            <p class="cat-name mb-0">New iPhones</p>
            <span class="cat-count">Brand-new sealed units</span>
          </a>
        </div>
        <div class="col-6 col-md-3">
          <a href="catalog.php?cat=android" class="category-card h-100">
            <div class="cat-img-wrap">
              <img src="/assets/products/category-android.jpg" alt="Android" loading="lazy">
            </div>
            <p class="cat-name mb-0">Android</p>
            <span class="cat-count">Samsung, Pixel &amp; more</span>
          </a>
        </div>
        <div class="col-6 col-md-3">
          <a href="catalog.php?cat=tablet" class="category-card h-100">
            <div class="cat-img-wrap">
              <img src="/assets/products/category-tablet.jpg" alt="Tablets" loading="lazy">
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
      <div class="row g-3" id="featuredGrid">

        <div class="col-6 col-md-4 col-xl-3">
          <article class="product-card">
            <div class="card-img-wrap">
              <img src="/assets/products/iphone13pro-128-graphite.jpg" alt="iPhone 13 Pro 128GB Graphite" loading="lazy">
              <span class="badge-ct badge-refurbished">Refurbished</span>
            </div>
            <div class="card-body">
              <p class="product-name">iPhone 13 Pro – 128GB Graphite</p>
              <p class="product-price">₱32,500</p>
            </div>
            <div class="card-footer">
              <button class="btn btn-ct btn-ct-sm flex-grow-1" onclick="quickAddToCart({id:'iphone13pro-128-graphite',name:'iPhone 13 Pro 128GB Graphite',price:32500,variant:'128GB',color:'Graphite',image:'/assets/products/iphone13pro-128-graphite.jpg'})">
                <i class="bi bi-cart-plus me-1"></i>Add
              </button>
              <a href="product.php?id=iphone13pro" class="btn btn-ct-outline btn-ct-sm">View</a>
            </div>
          </article>
        </div>

        <div class="col-6 col-md-4 col-xl-3">
          <article class="product-card">
            <div class="card-img-wrap">
              <img src="/assets/products/iphone12-64-blue.jpg" alt="iPhone 12 64GB Blue" loading="lazy">
              <span class="badge-ct badge-preowned">Pre-owned</span>
            </div>
            <div class="card-body">
              <p class="product-name">iPhone 12 – 64GB Blue</p>
              <p class="product-price">₱21,800</p>
            </div>
            <div class="card-footer">
              <button class="btn btn-ct btn-ct-sm flex-grow-1" onclick="quickAddToCart({id:'iphone12-64-blue',name:'iPhone 12 64GB Blue',price:21800,variant:'64GB',color:'Blue',image:'/assets/products/iphone12-64-blue.jpg'})">
                <i class="bi bi-cart-plus me-1"></i>Add
              </button>
              <a href="product.php?id=iphone12" class="btn btn-ct-outline btn-ct-sm">View</a>
            </div>
          </article>
        </div>

        <div class="col-6 col-md-4 col-xl-3">
          <article class="product-card">
            <div class="card-img-wrap">
              <img src="/assets/products/s22-256-phantom.jpg" alt="Samsung Galaxy S22 256GB Phantom Black" loading="lazy">
              <span class="badge-ct badge-available">Brand New</span>
            </div>
            <div class="card-body">
              <p class="product-name">Samsung Galaxy S22 – 256GB Phantom Black</p>
              <p class="product-price">₱28,000</p>
            </div>
            <div class="card-footer">
              <button class="btn btn-ct btn-ct-sm flex-grow-1" onclick="quickAddToCart({id:'s22-256-phantom',name:'Samsung Galaxy S22 256GB',price:28000,variant:'256GB',color:'Phantom Black',image:'/assets/products/s22-256-phantom.jpg'})">
                <i class="bi bi-cart-plus me-1"></i>Add
              </button>
              <a href="product.php?id=s22" class="btn btn-ct-outline btn-ct-sm">View</a>
            </div>
          </article>
        </div>

        <div class="col-6 col-md-4 col-xl-3">
          <article class="product-card">
            <div class="card-img-wrap">
              <img src="/assets/products/ipad9-64-gray.jpg" alt="iPad 9th Gen 64GB Space Gray" loading="lazy">
              <span class="badge-ct badge-refurbished">Refurbished</span>
            </div>
            <div class="card-body">
              <p class="product-name">iPad 9th Gen – 64GB Space Gray</p>
              <p class="product-price">₱22,000</p>
            </div>
            <div class="card-footer">
              <button class="btn btn-ct btn-ct-sm flex-grow-1" onclick="quickAddToCart({id:'ipad9-64-gray',name:'iPad 9th Gen 64GB',price:22000,variant:'64GB',color:'Space Gray',image:'/assets/products/ipad9-64-gray.jpg'})">
                <i class="bi bi-cart-plus me-1"></i>Add
              </button>
              <a href="product.php?id=ipad9" class="btn btn-ct-outline btn-ct-sm">View</a>
            </div>
          </article>
        </div>

        <div class="col-6 col-md-4 col-xl-3">
          <article class="product-card">
            <div class="card-img-wrap">
              <img src="/assets/products/pixel7-128-obsidian.jpg" alt="Google Pixel 7 128GB Obsidian" loading="lazy">
              <span class="badge-ct badge-available">Brand New</span>
            </div>
            <div class="card-body">
              <p class="product-name">Google Pixel 7 – 128GB Snow</p>
              <p class="product-price">₱24,000</p>
            </div>
            <div class="card-footer">
              <button class="btn btn-ct btn-ct-sm flex-grow-1" onclick="quickAddToCart({id:'pixel7-128-obsidian',name:'Google Pixel 7 128GB',price:24000,variant:'128GB',color:'Obsidian',image:'/assets/products/pixel7-128-obsidian.jpg'})">
                <i class="bi bi-cart-plus me-1"></i>Add
              </button>
              <a href="product.php?id=pixel7" class="btn btn-ct-outline btn-ct-sm">View</a>
            </div>
          </article>
        </div>

        <div class="col-6 col-md-4 col-xl-3">
          <article class="product-card">
            <div class="card-img-wrap">
              <img src="/assets/products/iphone14-256-midnight.jpg" alt="iPhone 14 256GB Midnight" loading="lazy">
              <span class="badge-ct badge-preowned">Pre-owned</span>
            </div>
            <div class="card-body">
              <p class="product-name">iPhone 13 – 128GB Midnight</p>
              <p class="product-price">₱28,500</p>
            </div>
            <div class="card-footer">
              <button class="btn btn-ct btn-ct-sm flex-grow-1" onclick="quickAddToCart({id:'iphone14-256-midnight',name:'iPhone 14 256GB Midnight',price:44900,variant:'256GB',color:'Midnight',image:'/assets/products/iphone14-256-midnight.jpg'})">
                <i class="bi bi-cart-plus me-1"></i>Add
              </button>
              <a href="product.php?id=iphone14" class="btn btn-ct-outline btn-ct-sm">View</a>
            </div>
          </article>
        </div>

        <div class="col-6 col-md-4 col-xl-3">
          <article class="product-card">
            <div class="card-img-wrap">
              <img src="/assets/products/a54-128-violet.jpg" alt="Samsung Galaxy A54 5G 128GB Awesome Graphite" loading="lazy">
              <span class="badge-ct badge-available">Brand New</span>
            </div>
            <div class="card-body">
              <p class="product-name">Samsung Galaxy A54 5G – 128GB Awesome Graphite</p>
              <p class="product-price">₱16,999</p>
            </div>
            <div class="card-footer">
              <button class="btn btn-ct btn-ct-sm flex-grow-1" onclick="quickAddToCart({id:'a54-128-violet',name:'Samsung Galaxy A54 128GB Awesome Violet',price:19990,variant:'128GB',color:'Awesome Violet',image:'/assets/products/a54-128-violet.jpg'})">
                <i class="bi bi-cart-plus me-1"></i>Add
              </button>
              <a href="product.php?id=a54" class="btn btn-ct-outline btn-ct-sm">View</a>
            </div>
          </article>
        </div>

        <div class="col-6 col-md-4 col-xl-3">
          <article class="product-card">
            <div class="card-img-wrap">
              <img src="/assets/products/iphonese3-128-starlight.jpg" alt="iPhone SE 3rd Gen 64GB Starlight" loading="lazy">
              <span class="badge-ct badge-refurbished">Refurbished</span>
            </div>
            <div class="card-body">
              <p class="product-name">iPhone SE 3rd Gen – 64GB Starlight</p>
              <p class="product-price">₱18,500</p>
            </div>
            <div class="card-footer">
              <button class="btn btn-ct btn-ct-sm flex-grow-1" onclick="quickAddToCart({id:'iphonese3-128-starlight',name:'iPhone SE 3rd Gen 128GB Starlight',price:23500,variant:'128GB',color:'Starlight',image:'/assets/products/iphonese3-128-starlight.jpg'})">
                <i class="bi bi-cart-plus me-1"></i>Add
              </button>
              <a href="product.php?id=iphonese3" class="btn btn-ct-outline btn-ct-sm">View</a>
            </div>
          </article>
        </div>

      </div><!-- /row -->
      <div class="text-center mt-4">
        <a href="catalog.php" class="btn btn-ct text-white px-5">Browse All Products <i class="bi bi-grid ms-1"></i></a>
      </div>
    </div>
  </section>



  <!-- TESTIMONIALS -->
  <section class="py-5">
    <div class="container">
      <div class="section-header text-center">
        <span class="section-label">Happy Customers</span>
        <h2 class="section-title">What People Say</h2>
      </div>
      <div class="row g-3">
        <div class="col-md-4">
          <div class="testimonial-card">
            <div class="stars mb-2">★★★★★</div>
            <p class="small mb-3">"Ordered a pre-owned iPhone 12. Came in perfect condition, fully tested. The delivery was fast and the price was unbeatable!"</p>
            <div class="d-flex align-items-center gap-2">
              <div class="avatar-circle">MJ</div>
              <div>
                <div class="testimonial-name">Maria J.</div>
                <div class="testimonial-place text-muted">Roxas City</div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="testimonial-card">
            <div class="stars mb-2">★★★★★</div>
            <p class="small mb-3">"Ang ganda ng serbisyo! Nag-order ako ng Samsung Galaxy S22 tapos dumating ng mabilis. Legit na tindahan, sure akong babalik!"</p>
            <div class="d-flex align-items-center gap-2">
              <div class="avatar-circle">KA</div>
              <div>
                <div class="testimonial-name">Kristoffer A.</div>
                <div class="testimonial-place text-muted">Roxas City</div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="testimonial-card">
            <div class="stars mb-2">★★★★★</div>
            <p class="small mb-3">"Super satisfied! They replaced the unit no questions asked when I found a minor issue. The 7-day guarantee is real!"</p>
            <div class="d-flex align-items-center gap-2">
              <div class="avatar-circle">JT</div>
              <div>
                <div class="testimonial-name">Joy T.</div>
                <div class="testimonial-place text-muted">Roxas City</div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- CTA BANNER -->
  <section class="cta-section text-center text-white">
    <div class="container">
      <h2 class="mb-2">Ready to Find Your Next Gadget?</h2>
      <p class="mb-4 opacity-75">Shop hundreds of pre-owned, refurbished, and brand-new devices today.</p>
      <div class="d-flex justify-content-center gap-3 flex-wrap">
        <a href="catalog.php" class="btn btn-cta-light">Shop Now <i class="bi bi-arrow-right ms-1"></i></a>
        <a href="about.php" class="btn btn-cta-outline-light">Learn More</a>
      </div>
    </div>
  </section>

<?php require 'includes/footer.php'; ?>
  <script src="assets/js/index.js"></script>
</body>
</html>
