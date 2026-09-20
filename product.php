<?php
$pageTitle       = 'Product Detail | CheynTech';
$pageDescription = 'Browse function-tested phones and tablets at CheynTech, Roxas City.';
$activePage      = 'catalog';
require 'includes/header.php';
?>

  <!-- BREADCRUMB -->
  <div class="breadcrumb-wrap">
    <div class="container">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.php">Home</a></li>
          <li class="breadcrumb-item"><a href="catalog.php">Catalog</a></li>
          <li class="breadcrumb-item active" aria-current="page" id="breadcrumbProduct">Loading…</li>
        </ol>
      </nav>
    </div>
  </div>

  <!-- MAIN PRODUCT SECTION -->
  <main class="py-5">
    <div class="container">
      <div class="row g-5">

        <!-- LEFT: Image Gallery -->
        <div class="col-lg-6">
          <div class="product-gallery">
            <!-- Main image -->
            <div class="gallery-main mb-3">
              <img
                id="mainProductImg"
                src=""
                alt=""
                class="img-fluid rounded-ct w-100"
                loading="eager"
              >
            </div>
            <!-- Thumbnails — injected by product.js -->
            <div class="gallery-thumbs d-flex gap-2 flex-wrap" id="galleryThumbs"></div>
          </div>
        </div>

        <!-- RIGHT: Product Info -->
        <div class="col-lg-6">

          <!-- Condition badge — injected by product.js -->
          <div class="d-flex flex-wrap gap-2 mb-3" id="conditionBadges"></div>

          <!-- Product name & price -->
          <h1 class="fw-800 mb-1" id="productName"></h1>
          <div class="product-price mb-3" id="productPrice"></div>

          <!-- Storage selector — injected by product.js -->
          <div class="mb-3" id="storageSection">
            <p class="filter-group-label mb-2">Storage</p>
            <div class="d-flex gap-2 flex-wrap" id="storageOptions"></div>
          </div>

          <!-- Color selector — injected by product.js -->
          <div class="mb-4" id="colorSection">
            <p class="filter-group-label mb-2">Color — <span id="selectedColorLabel" class="text-ct fw-700"></span></p>
            <div class="d-flex gap-3 flex-wrap" id="colorOptions"></div>
          </div>

          <!-- Short description -->
          <p class="text-muted mb-3" id="productShortDesc"></p>

          <!-- Trust note -->
          <div class="d-flex align-items-center gap-2 mb-4 p-3 bg-ct-soft rounded-ct-lg">
            <i class="bi bi-patch-check-fill text-ct fs-5 flex-shrink-0"></i>
            <span class="small">Full function test passed — battery, screen, cameras, and all connectivity checked. <strong>7-day replacement guarantee</strong> · Comes with charger and original box.</span>
          </div>

          <!-- CTA Buttons -->
          <div class="d-flex gap-3 flex-wrap mb-3">
            <button class="btn btn-ct px-4 py-2 flex-grow-1" id="addToCartBtn">
              <i class="bi bi-cart-plus me-2"></i>Add to Cart
            </button>
            <a href="contact.php" id="askQuestionBtn" class="btn btn-ct-outline px-4 py-2">
              <i class="bi bi-chat-dots me-2"></i>Ask a Question
            </a>
          </div>

          <!-- Secondary trust -->
          <div class="d-flex gap-3 flex-wrap">
            <span class="d-flex align-items-center gap-1 small text-muted">
              <i class="bi bi-shield-check text-ct"></i> 7-Day Guarantee
            </span>
            <span class="d-flex align-items-center gap-1 small text-muted">
              <i class="bi bi-truck text-ct"></i> Pickup or Delivery
            </span>
            <span class="d-flex align-items-center gap-1 small text-muted">
              <i class="bi bi-cash-coin text-ct"></i> GCash / Bank Transfer
            </span>
          </div>

        </div><!-- /col right -->
      </div><!-- /row -->

      <!-- TABBED SECTION: Description / Specs / How to Order -->
      <div class="mt-5">
        <ul class="nav nav-tabs" id="productTabs" role="tablist">
          <li class="nav-item" role="presentation">
            <button class="nav-link active" id="descTab" data-bs-toggle="tab" data-bs-target="#descPane"
                    type="button" role="tab" aria-controls="descPane" aria-selected="true">
              Description
            </button>
          </li>
          <li class="nav-item" role="presentation">
            <button class="nav-link" id="specsTab" data-bs-toggle="tab" data-bs-target="#specsPane"
                    type="button" role="tab" aria-controls="specsPane" aria-selected="false">
              Specifications
            </button>
          </li>
          <li class="nav-item" role="presentation">
            <button class="nav-link" id="howtoTab" data-bs-toggle="tab" data-bs-target="#howtoPane"
                    type="button" role="tab" aria-controls="howtoPane" aria-selected="false">
              How to Order
            </button>
          </li>
        </ul>
        <div class="tab-content border border-top-0 rounded-bottom p-4 bg-white" id="productTabContent">

          <!-- Description — body injected by product.js -->
          <div class="tab-pane fade show active" id="descPane" role="tabpanel" aria-labelledby="descTab">
            <h5 class="fw-700 mb-3">About This Unit</h5>
            <p id="descBody"></p>
          </div>

          <!-- Specifications — table injected by product.js -->
          <div class="tab-pane fade" id="specsPane" role="tabpanel" aria-labelledby="specsTab">
            <h5 class="fw-700 mb-3">Technical Specifications</h5>
            <table class="table table-sm table-bordered">
              <tbody id="specsBody"></tbody>
            </table>
          </div>

          <!-- How to Order — static -->
          <div class="tab-pane fade" id="howtoPane" role="tabpanel" aria-labelledby="howtoTab">
            <h5 class="fw-700 mb-3">How to Order from CheynTech</h5>
            <ol class="ps-3">
              <li class="mb-2"><strong>Add to Cart</strong> — Select your preferred storage and color, then click "Add to Cart".</li>
              <li class="mb-2"><strong>Checkout</strong> — Fill in your contact details and choose your fulfillment method (Pickup or Local Delivery).</li>
              <li class="mb-2"><strong>Choose Payment</strong> — Pay via Cash on Pickup, GCash, or Bank Transfer. Instructions will be provided after checkout.</li>
              <li class="mb-2"><strong>Confirmation</strong> — Our team will review and confirm your order within 1–2 hours during store hours.</li>
              <li><strong>Receive Your Unit</strong> — Pick up at our Roxas City store, or wait for our delivery staff to coordinate with you.</li>
            </ol>
            <div class="alert alert-info mt-3 small">
              <i class="bi bi-info-circle me-2"></i>
              Store hours: Mon–Sat, 9:00 AM – 7:00 PM · Questions? <a href="contact.php" class="alert-link">Contact us</a> or message us on Facebook.
            </div>
          </div>

        </div>
      </div>

      <!-- YOU MAY ALSO LIKE -->
      <section class="mt-5 pt-4">
        <div class="section-header mb-4">
          <span class="section-label">Related</span>
          <h2 class="section-title">You May Also Like</h2>
        </div>
        <div class="row g-3">
          <div class="col-6 col-md-3">
            <article class="product-card">
              <div class="card-img-wrap">
                <img src="https://placehold.co/400x400/fce4ec/e91e8c?text=iPhone+12" alt="iPhone 12 64GB Blue" loading="lazy">
                <span class="badge-ct badge-preowned">Pre-owned</span>
              </div>
              <div class="card-body">
                <p class="product-name">iPhone 12 – 64GB Blue</p>
                <p class="product-price">₱21,800</p>
              </div>
              <div class="card-footer">
                <button class="btn btn-ct btn-ct-sm flex-grow-1" onclick="CheynCart.add({id:'iphone12-64-blue',name:'iPhone 12 64GB Blue',price:21800,variant:'64GB',color:'Blue',image:'/assets/products/iphone12-64-blue.jpg'}, this)">
                  <i class="bi bi-cart-plus me-1"></i>Add
                </button>
                <a href="product.php?id=iphone12" class="btn btn-ct-outline btn-ct-sm">View</a>
              </div>
            </article>
          </div>
          <div class="col-6 col-md-3">
            <article class="product-card">
              <div class="card-img-wrap">
                <img src="https://placehold.co/400x400/fce4ec/e91e8c?text=iPhone+SE+3" alt="iPhone SE 3rd Gen" loading="lazy">
                <span class="badge-ct badge-refurbished">Refurbished</span>
              </div>
              <div class="card-body">
                <p class="product-name">iPhone SE 3rd Gen – 128GB Starlight</p>
                <p class="product-price">₱23,500</p>
              </div>
              <div class="card-footer">
                <button class="btn btn-ct btn-ct-sm flex-grow-1" onclick="CheynCart.add({id:'iphonese3-128-starlight',name:'iPhone SE 3rd Gen 128GB Starlight',price:23500,variant:'128GB',color:'Starlight',image:'/assets/products/iphonese3-128-starlight.jpg'}, this)">
                  <i class="bi bi-cart-plus me-1"></i>Add
                </button>
                <a href="product.php?id=iphonese3" class="btn btn-ct-outline btn-ct-sm">View</a>
              </div>
            </article>
          </div>
          <div class="col-6 col-md-3">
            <article class="product-card">
              <div class="card-img-wrap">
                <img src="https://placehold.co/400x400/fce4ec/e91e8c?text=iPhone+14" alt="iPhone 14 256GB Midnight" loading="lazy">
                <span class="badge-ct badge-available">Brand New</span>
              </div>
              <div class="card-body">
                <p class="product-name">iPhone 14 – 256GB Midnight</p>
                <p class="product-price">₱44,900</p>
              </div>
              <div class="card-footer">
                <button class="btn btn-ct btn-ct-sm flex-grow-1" onclick="CheynCart.add({id:'iphone14-256-midnight',name:'iPhone 14 256GB Midnight',price:44900,variant:'256GB',color:'Midnight',image:'/assets/products/iphone14-256-midnight.jpg'}, this)">
                  <i class="bi bi-cart-plus me-1"></i>Add
                </button>
                <a href="product.php?id=iphone14" class="btn btn-ct-outline btn-ct-sm">View</a>
              </div>
            </article>
          </div>
          <div class="col-6 col-md-3">
            <article class="product-card">
              <div class="card-img-wrap">
                <img src="https://placehold.co/400x400/fce4ec/e91e8c?text=iPhone+11" alt="iPhone 11 64GB White" loading="lazy">
                <span class="badge-ct badge-preowned">Pre-owned</span>
              </div>
              <div class="card-body">
                <p class="product-name">iPhone 11 – 64GB White</p>
                <p class="product-price">₱17,500</p>
              </div>
              <div class="card-footer">
                <button class="btn btn-ct btn-ct-sm flex-grow-1" onclick="CheynCart.add({id:'iphone11-64-white',name:'iPhone 11 64GB White',price:17500,variant:'64GB',color:'White',image:'/assets/products/iphone11-64-white.jpg'}, this)">
                  <i class="bi bi-cart-plus me-1"></i>Add
                </button>
                <a href="product.php?id=iphone11" class="btn btn-ct-outline btn-ct-sm">View</a>
              </div>
            </article>
          </div>
        </div>
      </section>

    </div><!-- /container -->
  </main>

<?php require 'includes/footer.php'; ?>
  <script src="assets/js/products-data.js"></script>
  <script src="assets/js/product.js"></script>
</body>
</html>

