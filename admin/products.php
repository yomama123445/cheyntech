<?php
$pageTitle       = 'Products | Cheyn Gadgets Admin';
$pageDescription = 'Cheyn Gadgets Admin — Product Management.';
$adminActivePage = 'products';
require '../includes/admin_header.php';
require '../includes/admin_sidebar.php';
?>

    <!-- TOP BAR -->
    <header class="admin-topbar">
      <button class="btn btn-sm btn-outline-secondary d-lg-none me-2" id="sidebarToggle" aria-label="Toggle sidebar">
        <i class="bi bi-list fs-5"></i>
      </button>
      <h5 class="mb-0 me-auto">Products</h5>
      <div class="d-flex align-items-center gap-2 gap-sm-3">
        <button class="btn btn-ct btn-sm" data-bs-toggle="modal" data-bs-target="#productModal" onclick="openAddModal()">
          <i class="bi bi-plus-lg me-1"></i> <span class="d-none d-sm-inline">Add </span>Product
        </button>
        <div class="dropdown">
          <button class="btn p-0 d-flex align-items-center gap-2 admin-profile-btn" id="profileDropdown" data-bs-toggle="dropdown" aria-expanded="false">
            <div class="admin-user-avatar"><?= strtoupper(substr($_SESSION['user_name'] ?? 'A', 0, 1)) ?></div>
            <span class="fw-600 d-none d-md-inline admin-username"><?= htmlspecialchars($_SESSION['user_name'] ?? 'Admin') ?></span>
            <i class="bi bi-chevron-down admin-chevron d-none d-md-inline"></i>
          </button>
          <ul class="dropdown-menu dropdown-menu-end admin-profile-menu" aria-labelledby="profileDropdown">
            <li class="admin-profile-header px-3 py-2">
              <div class="d-flex align-items-center gap-2">
                <div class="admin-user-avatar"><?= strtoupper(substr($_SESSION['user_name'] ?? 'A', 0, 1)) ?></div>
                <div>
                  <div class="fw-700 admin-profile-name"><?= htmlspecialchars($_SESSION['user_name'] ?? 'Admin') ?></div>
                  <div class="text-muted admin-profile-role"><?= ucfirst(htmlspecialchars($_SESSION['user_role'] ?? 'Administrator')) ?></div>
                </div>
              </div>
            </li>
            <li><hr class="dropdown-divider my-1"></li>
            <li><a class="dropdown-item" href="../profile.php"><i class="bi bi-person me-2"></i>My Profile</a></li>
            <li><a class="dropdown-item" href="settings.php"><i class="bi bi-gear me-2"></i>Settings</a></li>
            <li><hr class="dropdown-divider my-1"></li>
            <li><a class="dropdown-item text-danger" href="../login.php?action=logout"><i class="bi bi-box-arrow-left me-2"></i>Logout</a></li>
          </ul>
        </div>
      </div>
    </header>

    <!-- MAIN AREA -->
    <main class="admin-main">

      <!-- Search / Filter Bar -->
      <div class="card border-0 shadow-sm mb-4 px-4 py-3">
        <div class="row g-2 align-items-center">
          <div class="col-12 col-md-5">
            <div class="input-group">
              <span class="input-group-text bg-white border-end-0"><i class="bi bi-search text-muted"></i></span>
              <input type="search" id="productSearch" class="form-control border-start-0 ps-0" placeholder="Search products…" aria-label="Search products">
            </div>
          </div>
          <div class="col-6 col-md-3">
            <select id="filterCategory" class="form-select" aria-label="Filter by category">
              <option value="">All Categories</option>
              <option value="iPhone">iPhone</option>
              <option value="Android">Android</option>
              <option value="Tablet">Tablet</option>
              <option value="Accessories">Accessories</option>
              <option value="Wearables">Wearables</option>
            </select>
          </div>
          <div class="col-6 col-md-3">
            <select id="filterCondition" class="form-select" aria-label="Filter by condition">
              <option value="">All Conditions</option>
              <option value="Pre-owned">Pre-owned</option>
              <option value="Refurbished">Refurbished</option>
              <option value="Brand New">Brand New</option>
            </select>
          </div>
          <div class="col-12 col-md-1 text-md-end">
            <button class="btn btn-outline-secondary w-100" onclick="resetFilters()" title="Reset filters">
              <i class="bi bi-arrow-counterclockwise"></i>
            </button>
          </div>
        </div>
      </div>

      <!-- Products Count -->
      <div class="d-flex align-items-center justify-content-between mb-3">
        <p class="text-muted mb-0">Showing <span id="productCount">10</span> products</p>
        <div class="d-flex gap-2">
          <button class="btn btn-sm btn-outline-secondary" title="Grid view" id="viewGrid"><i class="bi bi-grid-3x3-gap"></i></button>
          <button class="btn btn-sm btn-secondary" title="Table view" id="viewTable"><i class="bi bi-table"></i></button>
        </div>
      </div>

      <!-- Products Table -->
      <div class="card border-0 shadow-sm mb-4">
        <div class="table-responsive">
          <table class="table table-hover align-middle mb-0" id="productsTable" aria-label="Products table">
            <thead class="table-light">
              <tr>
                <th class="ps-4 admin-th">Image</th>
                <th class="admin-th">Product Name</th>
                <th class="admin-th d-none d-md-table-cell">Category</th>
                <th class="admin-th d-none d-lg-table-cell">Condition</th>
                <th class="admin-th">Price</th>
                <th class="admin-th d-none d-md-table-cell">Stock</th>
                <th class="admin-th d-none d-lg-table-cell">Status</th>
                <th class="pe-4 admin-th text-end">Actions</th>
              </tr>
            </thead>
            <tbody id="productsTbody">
              <!-- Rows rendered by JS -->
            </tbody>
          </table>
        </div>
      </div>

      <!-- Pagination -->
      <nav aria-label="Products pagination">
        <ul class="pagination justify-content-center" id="pagination">
          <li class="page-item disabled"><a class="page-link" href="#" aria-label="Previous"><i class="bi bi-chevron-left"></i></a></li>
          <li class="page-item active"><a class="page-link" href="#" onclick="changePage(1,event)">1</a></li>
          <li class="page-item"><a class="page-link" href="#" onclick="changePage(2,event)">2</a></li>
          <li class="page-item"><a class="page-link" href="#" onclick="changePage(3,event)">3</a></li>
          <li class="page-item"><a class="page-link" href="#" aria-label="Next"><i class="bi bi-chevron-right"></i></a></li>
        </ul>
      </nav>

    </main>
  </div><!-- /admin-content -->
</div><!-- /admin-layout -->

<!-- ADD / EDIT PRODUCT MODAL -->
<div class="modal fade" id="productModal" tabindex="-1" aria-labelledby="productModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header border-0 pb-0">
        <h5 class="modal-title fw-700" id="productModalLabel">Add New Product</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body pt-3">
        <form id="productForm" novalidate>
          <input type="hidden" id="editProductId">
          <div class="row g-3">

            <div class="col-12">
              <label class="form-label fw-600" for="pName">Product Name <span class="text-danger">*</span></label>
              <input type="text" class="form-control" id="pName" placeholder="e.g. iPhone 15 Pro Max 256GB" required>
              <div class="invalid-feedback">Product name is required.</div>
            </div>

            <div class="col-6 col-md-4">
              <label class="form-label fw-600" for="pCategory">Category <span class="text-danger">*</span></label>
              <select class="form-select" id="pCategory" required>
                <option value="" disabled selected>Select…</option>
                <option value="iPhone">iPhone</option>
                <option value="Android">Android</option>
                <option value="Tablet">Tablet</option>
                <option value="Accessories">Accessories</option>
                <option value="Wearables">Wearables</option>
              </select>
              <div class="invalid-feedback">Select a category.</div>
            </div>

            <div class="col-6 col-md-4">
              <label class="form-label fw-600" for="pCondition">Condition <span class="text-danger">*</span></label>
              <select class="form-select" id="pCondition" required>
                <option value="" disabled selected>Select…</option>
                <option value="Pre-owned">Pre-owned</option>
                <option value="Refurbished">Refurbished</option>
                <option value="Brand New">Brand New</option>
              </select>
              <div class="invalid-feedback">Select a condition.</div>
            </div>

            <div class="col-6 col-md-4">
              <label class="form-label fw-600" for="pStorage">Storage</label>
              <select class="form-select" id="pStorage">
                <option value="">N/A</option>
                <option value="64GB">64GB</option>
                <option value="128GB">128GB</option>
                <option value="256GB">256GB</option>
                <option value="512GB">512GB</option>
                <option value="1TB">1TB</option>
              </select>
            </div>

            <div class="col-6 col-md-4">
              <label class="form-label fw-600" for="pColor">Color</label>
              <input type="text" class="form-control" id="pColor" placeholder="e.g. Titanium Black">
            </div>

            <div class="col-6 col-md-4">
              <label class="form-label fw-600" for="pPrice">Price (₱) <span class="text-danger">*</span></label>
              <div class="input-group">
                <span class="input-group-text">₱</span>
                <input type="number" class="form-control" id="pPrice" placeholder="0.00" min="0" step="0.01" required>
              </div>
              <div class="invalid-feedback">Enter a valid price.</div>
            </div>

            <div class="col-6 col-md-4">
              <label class="form-label fw-600" for="pStock">Stock Quantity <span class="text-danger">*</span></label>
              <input type="number" class="form-control" id="pStock" placeholder="0" min="0" required>
              <div class="invalid-feedback">Enter stock quantity.</div>
            </div>

            <div class="col-12">
              <label class="form-label fw-600" for="pDescription">Description</label>
              <textarea class="form-control" id="pDescription" rows="3" placeholder="Describe the product condition, inclusions, warranty, etc."></textarea>
            </div>

            <div class="col-12">
              <label class="form-label fw-600" for="pImages">Upload Images</label>
              <input class="form-control" type="file" id="pImages" multiple accept="image/*">
              <div class="form-text">You can upload up to 5 images. Supported: JPG, PNG, WEBP.</div>
              <div id="imagePreviewWrap" class="d-flex gap-2 flex-wrap mt-2"></div>
            </div>

          </div>
        </form>
      </div>
      <div class="modal-footer border-0 pt-0">
        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-ct" onclick="saveProduct()">
          <i class="bi bi-check-lg me-1"></i> <span id="saveLabel">Save Product</span>
        </button>
      </div>
    </div>
  </div>
</div>

<!-- DELETE CONFIRM MODAL -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header border-0">
        <h6 class="modal-title fw-700 text-danger" id="deleteModalLabel"><i class="bi bi-trash me-2"></i>Delete Product</h6>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body py-2">
        <p class="mb-0">Are you sure you want to delete <strong id="deleteProductName"></strong>? This action cannot be undone.</p>
      </div>
      <div class="modal-footer border-0 pt-0">
        <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-danger btn-sm" id="confirmDeleteBtn">Delete</button>
      </div>
    </div>
  </div>
</div>

<!-- ADJUST STOCK MODAL (TASK F3) -->
<div class="modal fade" id="adjustStockModal" tabindex="-1" aria-labelledby="adjustStockModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header border-0 pb-0">
        <h6 class="modal-title fw-700" id="adjustStockModalLabel"><i class="bi bi-box-seam me-2 text-ct"></i>Adjust Stock</h6>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body py-3">
        <div class="small text-muted mb-2 text-truncate" id="adjustStockProductName"></div>
        <input type="hidden" id="adjustStockProductId">
        <label class="form-label small fw-600 mb-1" for="adjustStockInput">New Available Units</label>
        <div class="input-group">
          <button class="btn btn-outline-secondary" type="button" onclick="stepAdjustStock(-1)"><i class="bi bi-dash"></i></button>
          <input type="number" class="form-control text-center fw-700" id="adjustStockInput" min="0" value="0">
          <button class="btn btn-outline-secondary" type="button" onclick="stepAdjustStock(1)"><i class="bi bi-plus"></i></button>
        </div>
        <div class="form-text text-xs mt-1">Directly syncs physical in-store count to store database.</div>
      </div>
      <div class="modal-footer border-0 pt-0">
        <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-ct btn-sm" id="confirmAdjustStockBtn" onclick="submitAdjustStock()">
          <i class="bi bi-check2 me-1"></i> Save Stock
        </button>
      </div>
    </div>
  </div>
</div>

<!-- Toast -->
<div class="toast-ct" id="toastMsg" role="alert" aria-live="polite"></div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="<?= asset_url('../assets/js/main.js') ?>"></script>
<script src="<?= asset_url('../assets/js/admin/products.js') ?>"></script>
</body>
</html>
