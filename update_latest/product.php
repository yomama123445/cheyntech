<?php
$pageTitle       = 'Device Details | Cheyn Gadgets Roxas City';
$pageDescription = 'Inspected pre-owned and new smartphones at Cheyn Gadgets in Roxas City, Capiz. In-store testing and local warranty.';
$activePage      = 'catalog';
require 'includes/header.php';
?>

  <!-- BREADCRUMB -->
  <div class="breadcrumb-wrap">
    <div class="container">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.php">Home</a></li>
          <li class="breadcrumb-item"><a href="catalog.php">Inventory</a></li>
          <li class="breadcrumb-item active" aria-current="page" id="breadcrumbProduct">Loading…</li>
        </ol>
      </nav>
    </div>
  </div>

  <!-- MAIN PRODUCT SECTION -->
  <main class="py-4 py-lg-5">
    <div class="container">
      <div class="row g-4 g-lg-5">

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

          <!-- Quality Assurance Badges Grid -->
          <div class="quality-badges-grid mb-4">
            <div class="quality-badge-item">
              <i class="bi bi-shield-check"></i>
              <div>
                <strong>Tested in Person</strong>
                <span>Checked before listing</span>
              </div>
            </div>
            <div class="quality-badge-item">
              <i class="bi bi-battery-charging"></i>
              <div>
                <strong>Healthy Battery</strong>
                <span>85%+ on pre-owned units</span>
              </div>
            </div>
            <div class="quality-badge-item">
              <i class="bi bi-arrow-repeat"></i>
              <div>
                <strong>7-Day Replacement</strong>
                <span>Local shop warranty</span>
              </div>
            </div>
            <div class="quality-badge-item">
              <i class="bi bi-shop"></i>
              <div>
                <strong>Roxas City Pickup</strong>
                <span>Test before you buy</span>
              </div>
            </div>
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
              <i class="bi bi-arrow-repeat text-muted"></i> 7-Day Replacement
            </span>
            <span class="d-flex align-items-center gap-1 small text-muted">
              <i class="bi bi-truck text-muted"></i> Pickup or Delivery
            </span>
            <span class="d-flex align-items-center gap-1 small text-muted">
              <i class="bi bi-credit-card text-muted"></i> GCash / Bank Transfer
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
            <h5 class="fw-700 mb-3">How to Order from Cheyn Gadgets</h5>
            <ol class="ps-3">
              <li class="mb-2"><strong>Add to Cart</strong> — Select your preferred storage and color, then click "Add to Cart".</li>
              <li class="mb-2"><strong>Checkout</strong> — Fill in your contact details and choose your fulfillment method (Pickup or Local Delivery).</li>
              <li class="mb-2"><strong>Choose Payment</strong> — Pay via Cash on Pickup, GCash, or Bank Transfer. Instructions will be provided after checkout.</li>
              <li class="mb-2"><strong>Confirmation</strong> — Our team will review and confirm your order within 1–2 hours during store hours.</li>
              <li><strong>Receive Your Unit</strong> — Pick up at our Roxas City store, or wait for our delivery staff to coordinate with you.</li>
            </ol>
            <div class="alert alert-info mt-3 small">
              <i class="bi bi-info-circle me-2"></i>
              Store hours: Mon–Sat, 9:00 AM – 6:00 PM · Questions? <a href="contact.php" class="alert-link">Contact us</a> or message us on Facebook.
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
        <div id="relatedGrid" class="row g-3"></div>
      </section>

    </div><!-- /container -->
  </main>

  <!-- ═══ STICKY MOBILE BOTTOM BAR ═══ -->
  <aside class="sticky-mobile-bar d-md-none" id="stickyMobileBar" aria-label="Quick Purchase">
    <div class="container-fluid px-3 py-1 d-flex align-items-center justify-content-between gap-2">
      <div class="d-flex align-items-center gap-2 overflow-hidden">
        <img id="stickyBarImg" src="assets/products/placeholder.jpg" alt="Thumbnail" class="sticky-bar-thumb" onerror="this.onerror=null;this.src='assets/products/placeholder.jpg'">
        <div class="text-truncate">
          <div class="sticky-bar-title text-truncate" id="stickyBarTitle">Gadget</div>
          <div class="sticky-bar-price" id="stickyBarPrice">₱0</div>
        </div>
      </div>
      <button type="button" class="btn btn-ct btn-sm py-2 px-3 text-nowrap fw-700" id="stickyBarAddBtn">
        <i class="bi bi-cart-plus me-1"></i> Add to Cart
      </button>
    </div>
  </aside>

<?php require 'includes/footer.php'; ?>
  <script src="<?= asset_url('assets/js/products-data.js') ?>"></script>
  <script src="<?= asset_url('assets/js/product.js') ?>"></script>
</body>
</html>

