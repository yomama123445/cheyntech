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
  <div class="page-header py-4 bg-white border-bottom">
    <div class="container">
      <div class="d-flex flex-wrap align-items-center justify-content-between gap-2">
        <div>
          <span class="apple-section-tag mb-1">Our Inventory</span>
          <h1 class="h3 fw-semibold text-dark mb-1">All Available Phones &amp; Tech</h1>
          <p class="text-muted small mb-0">Inspected by hand in Roxas City &middot; Showing <strong id="heroResultCount" class="text-dark">0</strong> items</p>
        </div>
        <button class="btn btn-ct-outline btn-sm filter-mobile-btn d-flex d-lg-none align-items-center gap-2"
          type="button" data-bs-toggle="offcanvas" data-bs-target="#filterOffcanvas" aria-controls="filterOffcanvas"
          aria-label="Open filters">
          <i class="bi bi-sliders2"></i> Filters
        </button>
      </div>
    </div>
  </div>

  <!-- MAIN CONTENT -->
  <main class="py-4">
    <div class="container">
      <div class="row g-4">

        <!-- LEFT SIDEBAR FILTERS -->
        <div class="col-lg-3 filter-col" aria-label="Product filters">
          <div class="filter-card">
            <div class="filter-title-bar">
              <span><i class="bi bi-sliders2 me-1"></i> Filters</span>
              <a href="catalog.php" id="clearAllLink">Clear All</a>
            </div>

            <div class="active-filters" id="activeFilters"></div>

            <div class="filter-group">
              <div class="catalog-search-wrap">
                <input type="search" class="form-control" id="catalogSearchInput"
                  placeholder="Search products…" aria-label="Search products">
                <i class="bi bi-search search-icon"></i>
              </div>
            </div>

            <div class="filter-group">
              <p class="filter-group-label">Category</p>
              <div class="filter-check" id="categoryFilterList">
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" id="catPreownedIphone" name="cat" value="preowned" data-filter-count-for="preowned">
                  <label class="form-check-label d-flex align-items-center justify-content-between" for="catPreownedIphone"><span>Pre-owned iPhones</span> <span class="filter-count text-muted ms-1" data-count-for="preowned"></span></label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" id="catNewIphone" name="cat" value="new" data-filter-count-for="new">
                  <label class="form-check-label d-flex align-items-center justify-content-between" for="catNewIphone"><span>New iPhones</span> <span class="filter-count text-muted ms-1" data-count-for="new"></span></label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" id="catAndroid" name="cat" value="android" data-filter-count-for="android">
                  <label class="form-check-label d-flex align-items-center justify-content-between" for="catAndroid"><span>Android</span> <span class="filter-count text-muted ms-1" data-count-for="android"></span></label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" id="catTablet" name="cat" value="tablet" data-filter-count-for="tablet">
                  <label class="form-check-label d-flex align-items-center justify-content-between" for="catTablet"><span>Tablets</span> <span class="filter-count text-muted ms-1" data-count-for="tablet"></span></label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" id="catWearable" name="cat" value="wearable" data-filter-count-for="wearable">
                  <label class="form-check-label d-flex align-items-center justify-content-between" for="catWearable"><span>Wearables &amp; Watches</span> <span class="filter-count text-muted ms-1" data-count-for="wearable"></span></label>
                </div>
              </div>
            </div>

            <div class="filter-group">
              <p class="filter-group-label">Storage</p>
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
            </div>

            <div class="filter-group">
              <p class="filter-group-label">Color</p>
              <div class="filter-colors-wrap" id="colorFilterList">
                <!-- Dynamically populated from real product colors -->
              </div>
            </div>

            <div class="filter-group">
              <p class="filter-group-label">Condition</p>
              <div class="filter-check" id="conditionFilterList">
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" id="condPreowned" name="condition" value="preowned">
                  <label class="form-check-label d-flex align-items-center justify-content-between" for="condPreowned"><span>Pre-owned</span></label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" id="condRefurb" name="condition" value="refurbished">
                  <label class="form-check-label d-flex align-items-center justify-content-between" for="condRefurb"><span>Refurbished</span></label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" id="condNew" name="condition" value="brandnew">
                  <label class="form-check-label d-flex align-items-center justify-content-between" for="condNew"><span>Brand New</span></label>
                </div>
              </div>
            </div>

            <div class="d-grid">
              <button type="button" class="btn btn-ct" id="applyFiltersBtn">
                <i class="bi bi-funnel-fill me-1"></i> Apply Filters
              </button>
            </div>
          </div>
        </div>

        <!-- PRODUCT GRID -->
        <div class="col-lg-9">
          <div class="sort-bar">
            <span class="sort-label"><i class="bi bi-grid-3x3-gap me-1"></i> <span id="sortBarCount">0</span> products found</span>
            <div class="d-flex align-items-center gap-2">
              <button class="btn btn-ct-outline btn-sm d-inline-flex d-lg-none align-items-center gap-1 py-1 px-2"
                type="button" data-bs-toggle="offcanvas" data-bs-target="#filterOffcanvas" aria-controls="filterOffcanvas"
                aria-label="Open filters">
                <i class="bi bi-sliders2"></i> Filters
              </button>
              <label for="sortSelect" class="sort-label mb-0 d-none d-sm-inline">Sort by:</label>
              <select id="sortSelect" class="form-select form-select-sm" aria-label="Sort products">
                <option value="featured">Featured</option>
                <option value="price-asc">Price: Low to High</option>
                <option value="price-desc">Price: High to Low</option>
                <option value="newest">Newest First</option>
                <option value="name">Name A–Z</option>
              </select>
            </div>
          </div>

          <div class="row row-cols-1 row-cols-sm-2 row-cols-xl-3 g-3" id="productGrid">
            <!-- Products are rendered dynamically by catalog.js -->
          </div><!-- /productGrid -->

          <!-- Pagination — rendered dynamically by catalog.js -->
          <nav id="paginationNav" class="mt-5 d-flex justify-content-center" aria-label="Catalog pagination"></nav>

        </div><!-- /col-lg-9 -->
      </div><!-- /row -->
    </div><!-- /container -->
  </main>

  <!-- OFF-CANVAS FILTER (Mobile) -->
  <div class="offcanvas offcanvas-start offcanvas-filter" tabindex="-1" id="filterOffcanvas" aria-labelledby="filterOffcanvasLabel">
    <div class="offcanvas-header">
      <h5 class="offcanvas-title" id="filterOffcanvasLabel"><i class="bi bi-sliders2 me-2"></i>Filters</h5>
      <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close filters"></button>
    </div>
    <div class="offcanvas-body">
      <div class="filter-group mb-3 pb-3 border-bottom">
        <p class="filter-group-label">Search</p>
        <div class="catalog-search-wrap">
          <input type="search" class="form-control" id="catalogSearchInputMobile" placeholder="Search products…" aria-label="Search products mobile">
          <i class="bi bi-search search-icon"></i>
        </div>
      </div>
      <div class="filter-group mb-3 pb-3 border-bottom">
        <p class="filter-group-label">Category</p>
        <div class="filter-check" id="mCategoryFilterList">
          <div class="form-check"><input class="form-check-input" type="checkbox" id="mCatPreownedIphone" name="cat" value="preowned"><label class="form-check-label d-flex align-items-center justify-content-between" for="mCatPreownedIphone"><span>Pre-owned iPhones</span></label></div>
          <div class="form-check"><input class="form-check-input" type="checkbox" id="mCatNewIphone" name="cat" value="new"><label class="form-check-label d-flex align-items-center justify-content-between" for="mCatNewIphone"><span>New iPhones</span></label></div>
          <div class="form-check"><input class="form-check-input" type="checkbox" id="mCatAndroid" name="cat" value="android"><label class="form-check-label d-flex align-items-center justify-content-between" for="mCatAndroid"><span>Android</span></label></div>
          <div class="form-check"><input class="form-check-input" type="checkbox" id="mCatTablet" name="cat" value="tablet"><label class="form-check-label d-flex align-items-center justify-content-between" for="mCatTablet"><span>Tablets</span></label></div>
          <div class="form-check"><input class="form-check-input" type="checkbox" id="mCatWearable" name="cat" value="wearable"><label class="form-check-label d-flex align-items-center justify-content-between" for="mCatWearable"><span>Wearables &amp; Watches</span></label></div>
        </div>
      </div>
      <div class="filter-group mb-3 pb-3 border-bottom">
        <p class="filter-group-label">Storage</p>
        <div class="filter-check" id="mStorageFilterList">
          <div class="form-check"><input class="form-check-input" type="checkbox" id="mVar64" name="variant" value="64gb"><label class="form-check-label d-flex align-items-center justify-content-between" for="mVar64"><span>64 GB</span></label></div>
          <div class="form-check"><input class="form-check-input" type="checkbox" id="mVar128" name="variant" value="128gb"><label class="form-check-label d-flex align-items-center justify-content-between" for="mVar128"><span>128 GB</span></label></div>
          <div class="form-check"><input class="form-check-input" type="checkbox" id="mVar256" name="variant" value="256gb"><label class="form-check-label d-flex align-items-center justify-content-between" for="mVar256"><span>256 GB</span></label></div>
          <div class="form-check"><input class="form-check-input" type="checkbox" id="mVar512" name="variant" value="512gb"><label class="form-check-label d-flex align-items-center justify-content-between" for="mVar512"><span>512 GB</span></label></div>
        </div>
      </div>
      <div class="filter-group mb-3 pb-3 border-bottom">
        <p class="filter-group-label">Color</p>
        <div class="filter-colors-wrap" id="mColorFilterList">
          <!-- Dynamically populated from real product colors -->
        </div>
      </div>
      <div class="filter-group mb-3 pb-3 border-bottom">
        <p class="filter-group-label">Condition</p>
        <div class="filter-check" id="mConditionFilterList">
          <div class="form-check"><input class="form-check-input" type="checkbox" id="mCondPreowned" name="condition" value="preowned"><label class="form-check-label d-flex align-items-center justify-content-between" for="mCondPreowned"><span>Pre-owned</span></label></div>
          <div class="form-check"><input class="form-check-input" type="checkbox" id="mCondRefurb" name="condition" value="refurbished"><label class="form-check-label d-flex align-items-center justify-content-between" for="mCondRefurb"><span>Refurbished</span></label></div>
          <div class="form-check"><input class="form-check-input" type="checkbox" id="mCondNew" name="condition" value="brandnew"><label class="form-check-label d-flex align-items-center justify-content-between" for="mCondNew"><span>Brand New</span></label></div>
        </div>
      </div>
      <div class="d-grid gap-2 mt-3">
        <button type="button" class="btn btn-ct" id="applyFiltersBtnMobile" data-bs-dismiss="offcanvas"><i class="bi bi-funnel-fill me-1"></i> Apply Filters</button>
        <a href="#" id="clearAllLinkMobile" class="btn btn-ct-outline" data-bs-dismiss="offcanvas">Clear All</a>
      </div>
    </div>
  </div>

<?php require 'includes/footer.php'; ?>
  <script src="<?= asset_url('assets/js/products-data.js') ?>"></script>
  <script src="<?= asset_url('assets/js/catalog.js') ?>"></script>
</body>
</html>
