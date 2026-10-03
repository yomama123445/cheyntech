<?php
$pageTitle       = 'Catalog | Cheyn Gadgets';
$pageDescription = 'Browse pre-owned, refurbished, and brand-new phones and tablets at Cheyn Gadgets — your trusted Roxas City gadget store.';
$activePage      = 'catalog';
require 'includes/header.php';
?>

  <!-- BREADCRUMB -->
  <div class="breadcrumb-wrap">
    <div class="container">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.php">Home</a></li>
          <li class="breadcrumb-item active" aria-current="page">Catalog</li>
        </ol>
      </nav>
    </div>
  </div>

  <!-- PAGE HEADER -->
  <div class="page-header">
    <div class="container">
      <div class="d-flex flex-wrap align-items-center justify-content-between gap-2">
        <div>
          <h1>Shop by Category</h1>
          <p class="page-subtitle result-count mt-1">Showing <strong id="heroResultCount">0</strong> results</p>
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
              <div class="filter-check">
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" id="catPreownedIphone" name="cat" value="preowned" data-filter-count-for="preowned">
                  <label class="form-check-label" for="catPreownedIphone">Pre-owned iPhones <span class="filter-count text-muted ms-1" data-count-for="preowned"></span></label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" id="catNewIphone" name="cat" value="new" data-filter-count-for="new">
                  <label class="form-check-label" for="catNewIphone">New iPhones <span class="filter-count text-muted ms-1" data-count-for="new"></span></label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" id="catAndroid" name="cat" value="android" data-filter-count-for="android">
                  <label class="form-check-label" for="catAndroid">Android <span class="filter-count text-muted ms-1" data-count-for="android"></span></label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" id="catTablet" name="cat" value="tablet" data-filter-count-for="tablet">
                  <label class="form-check-label" for="catTablet">Tablets <span class="filter-count text-muted ms-1" data-count-for="tablet"></span></label>
                </div>
              </div>
            </div>

            <div class="filter-group">
              <p class="filter-group-label">Storage</p>
              <div class="filter-check">
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" id="var64" name="variant" value="64gb">
                  <label class="form-check-label" for="var64">64 GB</label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" id="var128" name="variant" value="128gb">
                  <label class="form-check-label" for="var128">128 GB</label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" id="var256" name="variant" value="256gb">
                  <label class="form-check-label" for="var256">256 GB</label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" id="var512" name="variant" value="512gb">
                  <label class="form-check-label" for="var512">512 GB</label>
                </div>
              </div>
            </div>

            <div class="filter-group">
              <p class="filter-group-label">Color</p>
              <label class="color-option">
                <input class="form-check-input" type="checkbox" name="color" value="space-gray">
                <span class="color-dot" style="background:#4a4a4a;"></span>
                <span class="color-label">Space Gray</span>
              </label>
              <label class="color-option">
                <input class="form-check-input" type="checkbox" name="color" value="silver">
                <span class="color-dot" style="background:#e2e2e4;border-color:#c0c0c0;"></span>
                <span class="color-label">Silver</span>
              </label>
              <label class="color-option">
                <input class="form-check-input" type="checkbox" name="color" value="gold">
                <span class="color-dot" style="background:#f0d58c;"></span>
                <span class="color-label">Gold</span>
              </label>
              <label class="color-option">
                <input class="form-check-input" type="checkbox" name="color" value="midnight">
                <span class="color-dot" style="background:#1c1c1e;"></span>
                <span class="color-label">Midnight</span>
              </label>
              <label class="color-option">
                <input class="form-check-input" type="checkbox" name="color" value="starlight">
                <span class="color-dot" style="background:#f5f0e8;border-color:#ccc;"></span>
                <span class="color-label">Starlight</span>
              </label>
              <label class="color-option">
                <input class="form-check-input" type="checkbox" name="color" value="deep-purple">
                <span class="color-dot" style="background:#5e4b8b;"></span>
                <span class="color-label">Deep Purple</span>
              </label>
            </div>

            <div class="filter-group">
              <p class="filter-group-label">Condition</p>
              <div class="filter-check">
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" id="condPreowned" name="condition" value="preowned">
                  <label class="form-check-label" for="condPreowned">Pre-owned</label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" id="condRefurb" name="condition" value="refurbished">
                  <label class="form-check-label" for="condRefurb">Refurbished</label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" id="condNew" name="condition" value="brandnew">
                  <label class="form-check-label" for="condNew">Brand New</label>
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
              <label for="sortSelect" class="sort-label mb-0">Sort by:</label>
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
        <div class="filter-check">
          <div class="form-check"><input class="form-check-input" type="checkbox" id="mCatPreownedIphone" name="cat" value="preowned"><label class="form-check-label" for="mCatPreownedIphone">Pre-owned iPhones</label></div>
          <div class="form-check"><input class="form-check-input" type="checkbox" id="mCatNewIphone" name="cat" value="new"><label class="form-check-label" for="mCatNewIphone">New iPhones</label></div>
          <div class="form-check"><input class="form-check-input" type="checkbox" id="mCatAndroid" name="cat" value="android"><label class="form-check-label" for="mCatAndroid">Android</label></div>
          <div class="form-check"><input class="form-check-input" type="checkbox" id="mCatTablet" name="cat" value="tablet"><label class="form-check-label" for="mCatTablet">Tablets</label></div>
        </div>
      </div>
      <div class="filter-group mb-3 pb-3 border-bottom">
        <p class="filter-group-label">Storage</p>
        <div class="filter-check">
          <div class="form-check"><input class="form-check-input" type="checkbox" id="mVar64" name="variant" value="64gb"><label class="form-check-label" for="mVar64">64 GB</label></div>
          <div class="form-check"><input class="form-check-input" type="checkbox" id="mVar128" name="variant" value="128gb"><label class="form-check-label" for="mVar128">128 GB</label></div>
          <div class="form-check"><input class="form-check-input" type="checkbox" id="mVar256" name="variant" value="256gb"><label class="form-check-label" for="mVar256">256 GB</label></div>
          <div class="form-check"><input class="form-check-input" type="checkbox" id="mVar512" name="variant" value="512gb"><label class="form-check-label" for="mVar512">512 GB</label></div>
        </div>
      </div>
      <div class="filter-group mb-3 pb-3 border-bottom">
        <p class="filter-group-label">Condition</p>
        <div class="filter-check">
          <div class="form-check"><input class="form-check-input" type="checkbox" id="mCondPreowned" name="condition" value="preowned"><label class="form-check-label" for="mCondPreowned">Pre-owned</label></div>
          <div class="form-check"><input class="form-check-input" type="checkbox" id="mCondRefurb" name="condition" value="refurbished"><label class="form-check-label" for="mCondRefurb">Refurbished</label></div>
          <div class="form-check"><input class="form-check-input" type="checkbox" id="mCondNew" name="condition" value="brandnew"><label class="form-check-label" for="mCondNew">Brand New</label></div>
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
