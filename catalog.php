<?php
$pageTitle       = 'Available Phones & Gadgets | Cheyn Gadgets Roxas City';
$pageDescription = 'Browse tested pre-owned and new smartphones, tablets, and accessories at Cheyn Gadgets in Roxas City, Capiz. Honest condition and local shop support.';
$activePage      = 'catalog';
require 'includes/header.php';
?>

  <!-- BREADCRUMB -->
  <div class="breadcrumb-wrap">
    <div class="container">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.php">Home</a></li>
          <li class="breadcrumb-item active" aria-current="page">Inventory</li>
        </ol>
      </nav>
    </div>
  </div>

  <!-- PAGE HEADER -->
  <header class="catalog-hero py-4 bg-white border-bottom">
    <div class="container">
      <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3">
        <div>
          <span class="apple-section-tag mb-1 d-inline-block">Tested Inventory &middot; Roxas City, Capiz</span>
          <h1 class="h3 fw-semibold text-dark mb-1" id="catalogPageTitle">Available Phones &amp; Gadgets</h1>
          <p class="text-muted small mb-0" id="catalogPageSubtitle">
            Every unit tested by hand with a 7-day replacement warranty &middot; Showing <strong id="heroResultCount" class="text-dark">0</strong> items
          </p>
        </div>
        <div class="d-flex align-items-center gap-2">
          <button class="btn btn-ct-outline btn-sm d-flex align-items-center gap-2"
            type="button" data-bs-toggle="offcanvas" data-bs-target="#filterOffcanvas" aria-controls="filterOffcanvas"
            aria-label="Open detailed filters">
            <i class="bi bi-sliders2"></i>
            <span>Detailed Filters</span>
            <span class="badge bg-secondary-subtle text-dark rounded-pill ms-1 d-none" id="activeFilterBadge">0</span>
          </button>
          <a href="contact.php" class="btn btn-ct btn-sm d-none d-sm-inline-flex align-items-center gap-1">
            <i class="bi bi-chat-dots"></i> Ask About Stock
          </a>
        </div>
      </div>
    </div>
  </header>

  <!-- CATEGORY PILL NAVIGATION BAR -->
  <nav class="catalog-category-bar py-2 bg-white border-bottom sticky-top shadow-none" aria-label="Device categories">
    <div class="container">
      <div class="category-pills-scroller d-flex align-items-center gap-2 overflow-x-auto py-1">
        <button type="button" class="category-pill active" data-cat="all">
          <span>All Devices</span>
          <span class="pill-count" id="countAll">0</span>
        </button>
        <button type="button" class="category-pill" data-cat="apple">
          <i class="bi bi-apple me-1"></i>
          <span>Apple iPhones &amp; Tech</span>
          <span class="pill-count" id="countApple">0</span>
        </button>
        <button type="button" class="category-pill" data-cat="android">
          <i class="bi bi-android2 me-1"></i>
          <span>Android Phones</span>
          <span class="pill-count" id="countAndroid">0</span>
        </button>
        <button type="button" class="category-pill" data-cat="tablet">
          <i class="bi bi-tablet me-1"></i>
          <span>Tablets &amp; iPads</span>
          <span class="pill-count" id="countTablet">0</span>
        </button>
        <button type="button" class="category-pill" data-cat="wearable">
          <i class="bi bi-smartwatch me-1"></i>
          <span>Wearables &amp; Tech</span>
          <span class="pill-count" id="countWearable">0</span>
        </button>
      </div>
    </div>
  </nav>

  <!-- TOOLBAR -->
  <section class="catalog-toolbar-wrap py-3 bg-light-subtle border-bottom" aria-label="Inventory filters and search">
    <div class="container">
      <div class="row g-2 align-items-center justify-content-between">
        <!-- Quick Condition Filter Pills -->
        <div class="col-12 col-md-auto">
          <div class="d-flex align-items-center gap-2 flex-wrap">
            <span class="text-xs fw-semibold text-muted text-uppercase tracking-wider">Condition:</span>
            <div class="btn-group btn-group-sm condition-pill-group" role="group" aria-label="Filter by condition">
              <button type="button" class="btn btn-condition-pill active" data-condition="all">All</button>
              <button type="button" class="btn btn-condition-pill" data-condition="preowned">Pre-owned</button>
              <button type="button" class="btn btn-condition-pill" data-condition="brandnew">Brand New</button>
            </div>
          </div>
        </div>

        <!-- Search + Sort -->
        <div class="col-12 col-md-auto">
          <div class="d-flex align-items-center gap-2 flex-wrap flex-md-nowrap justify-content-md-end">
            <!-- Search Pill -->
            <div class="catalog-search-pill flex-grow-1 flex-md-grow-0">
              <i class="bi bi-search search-icon"></i>
              <input type="search" class="form-control form-control-sm" id="catalogSearchInput"
                placeholder="Search iPhone, Samsung, iPad…" aria-label="Search devices">
            </div>

            <!-- Sort Select -->
            <div class="d-flex align-items-center gap-1">
              <label for="sortSelect" class="text-xs text-muted d-none d-lg-inline mb-0 text-nowrap">Sort:</label>
              <select id="sortSelect" class="form-select form-select-sm sort-pill-select" aria-label="Sort products">
                <option value="featured">Featured</option>
                <option value="price-asc">Price: Low to High</option>
                <option value="price-desc">Price: High to Low</option>
                <option value="newest">Newest First</option>
                <option value="name">Name A–Z</option>
              </select>
            </div>
          </div>
        </div>
      </div>

      <!-- Active Filters Tag Strip -->
      <div class="active-filters-wrap mt-2 pt-2 border-top border-light" id="activeFiltersContainer" style="display: none;">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
          <div class="active-filters d-flex flex-wrap gap-1 align-items-center" id="activeFilters"></div>
          <a href="catalog.php" id="clearAllLink" class="text-xs text-muted text-decoration-none">
            <i class="bi bi-arrow-counterclockwise me-1"></i>Reset All
          </a>
        </div>
      </div>
    </div>
  </section>

  <!-- MAIN CATALOG GRID -->
  <main class="py-4">
    <div class="container">
      <div class="d-flex align-items-center justify-content-between mb-3 text-muted small">
        <div>
          <span id="sortBarCount" class="fw-semibold text-dark">0</span> units verified &amp; available for pickup
        </div>
        <div class="text-xs text-muted d-none d-sm-block">
          <i class="bi bi-geo-alt-fill text-danger me-1"></i>Cheyn Gadgets &middot; Roxas City Store
        </div>
      </div>

      <!-- Product Cards Grid -->
      <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-xl-4 g-3 g-lg-4" id="productGrid">
        <!-- Products rendered dynamically by catalog.js -->
      </div>

      <!-- Pagination -->
      <nav id="paginationNav" class="mt-5 d-flex justify-content-center" aria-label="Catalog pagination"></nav>

    </div><!-- /container -->
  </main>

  <!-- DETAILED FILTERS OFFCANVAS (Storage, Color, Price, Condition) -->
  <div class="offcanvas offcanvas-end offcanvas-filter" tabindex="-1" id="filterOffcanvas" aria-labelledby="filterOffcanvasLabel">
    <div class="offcanvas-header border-bottom">
      <h5 class="offcanvas-title h6 fw-bold mb-0" id="filterOffcanvasLabel">
        <i class="bi bi-sliders2 me-2"></i>Filter Options
      </h5>
      <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close filters"></button>
    </div>
    <div class="offcanvas-body">
      <!-- Search inside offcanvas -->
      <div class="filter-group mb-3 pb-3 border-bottom">
        <label class="filter-group-label" for="catalogSearchInputMobile">Search Keyword</label>
        <div class="catalog-search-wrap">
          <input type="search" class="form-control form-control-sm" id="catalogSearchInputMobile"
            placeholder="e.g. iPhone 13, Samsung, iPad…" aria-label="Search products mobile">
          <i class="bi bi-search search-icon"></i>
        </div>
      </div>

      <!-- Category Filter Checkboxes -->
      <div class="filter-group mb-3 pb-3 border-bottom">
        <p class="filter-group-label">Device Type</p>
        <div class="filter-check" id="categoryFilterList">
          <div class="form-check">
            <input class="form-check-input" type="checkbox" id="catApple" name="cat" value="apple" data-filter-count-for="apple">
            <label class="form-check-label d-flex align-items-center justify-content-between" for="catApple">
              <span>Apple (iPhones &amp; Tech)</span>
              <span class="filter-count text-muted ms-1" data-count-for="apple"></span>
            </label>
          </div>
          <div class="form-check">
            <input class="form-check-input" type="checkbox" id="catAndroid" name="cat" value="android" data-filter-count-for="android">
            <label class="form-check-label d-flex align-items-center justify-content-between" for="catAndroid">
              <span>Android Smartphones</span>
              <span class="filter-count text-muted ms-1" data-count-for="android"></span>
            </label>
          </div>
          <div class="form-check">
            <input class="form-check-input" type="checkbox" id="catTablet" name="cat" value="tablet" data-filter-count-for="tablet">
            <label class="form-check-label d-flex align-items-center justify-content-between" for="catTablet">
              <span>Tablets &amp; iPads</span>
              <span class="filter-count text-muted ms-1" data-count-for="tablet"></span>
            </label>
          </div>
          <div class="form-check">
            <input class="form-check-input" type="checkbox" id="catWearable" name="cat" value="wearable" data-filter-count-for="wearable">
            <label class="form-check-label d-flex align-items-center justify-content-between" for="catWearable">
              <span>Wearables &amp; Tech</span>
              <span class="filter-count text-muted ms-1" data-count-for="wearable"></span>
            </label>
          </div>
        </div>
        <!-- Mobile mirror category list for sync -->
        <div class="d-none" id="mCategoryFilterList"></div>
      </div>

      <!-- Condition Checkboxes -->
      <div class="filter-group mb-3 pb-3 border-bottom">
        <p class="filter-group-label">Unit Condition</p>
        <div class="filter-check" id="conditionFilterList">
          <div class="form-check">
            <input class="form-check-input" type="checkbox" id="condPreowned" name="condition" value="preowned">
            <label class="form-check-label d-flex align-items-center justify-content-between" for="condPreowned">
              <span>Pre-owned (Inspected Grade A)</span>
            </label>
          </div>
          <div class="form-check">
            <input class="form-check-input" type="checkbox" id="condRefurb" name="condition" value="refurbished">
            <label class="form-check-label d-flex align-items-center justify-content-between" for="condRefurb">
              <span>Refurbished</span>
            </label>
          </div>
          <div class="form-check">
            <input class="form-check-input" type="checkbox" id="condNew" name="condition" value="brandnew">
            <label class="form-check-label d-flex align-items-center justify-content-between" for="condNew">
              <span>Brand New (Factory Sealed)</span>
            </label>
          </div>
        </div>
        <div class="d-none" id="mConditionFilterList"></div>
      </div>

      <!-- Storage Options -->
      <div class="filter-group mb-3 pb-3 border-bottom">
        <p class="filter-group-label">Storage Capacity</p>
        <div class="filter-check" id="storageFilterList">
          <div class="form-check">
            <input class="form-check-input" type="checkbox" id="var64" name="variant" value="64gb">
            <label class="form-check-label d-flex align-items-center justify-content-between" for="var64"><span>64 GB</span></label>
          </div>
          <div class="form-check">
            <input class="form-check-input" type="checkbox" id="var128" name="variant" value="128gb">
            <label class="form-check-label d-flex align-items-center justify-content-between" for="var128"><span>128 GB</span></label>
          </div>
          <div class="form-check">
            <input class="form-check-input" type="checkbox" id="var256" name="variant" value="256gb">
            <label class="form-check-label d-flex align-items-center justify-content-between" for="var256"><span>256 GB</span></label>
          </div>
          <div class="form-check">
            <input class="form-check-input" type="checkbox" id="var512" name="variant" value="512gb">
            <label class="form-check-label d-flex align-items-center justify-content-between" for="var512"><span>512 GB</span></label>
          </div>
        </div>
        <div class="d-none" id="mStorageFilterList"></div>
      </div>

      <!-- Color Options -->
      <div class="filter-group mb-3 pb-3 border-bottom">
        <p class="filter-group-label">Color Finish</p>
        <div class="filter-colors-wrap" id="colorFilterList">
          <!-- Dynamically populated from inventory -->
        </div>
        <div class="d-none" id="mColorFilterList"></div>
      </div>

      <!-- Action Buttons -->
      <div class="d-grid gap-2 mt-4">
        <button type="button" class="btn btn-ct" id="applyFiltersBtn" data-bs-dismiss="offcanvas">
          <i class="bi bi-check2 me-1"></i> Apply Filters
        </button>
        <button type="button" class="btn btn-outline-secondary btn-sm" id="clearAllLinkMobile" data-bs-dismiss="offcanvas">
          Clear All Filters
        </button>
      </div>
    </div>
  </div>

<?php require 'includes/footer.php'; ?>
  <script src="<?= asset_url('assets/js/products-data.js') ?>"></script>
  <script src="<?= asset_url('assets/js/catalog.js') ?>"></script>
</body>
</html>
