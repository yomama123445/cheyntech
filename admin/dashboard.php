<?php
$pageTitle       = 'Dashboard | Cheyn Gadgets Admin';
$pageDescription = 'Cheyn Gadgets Admin Dashboard — overview of orders, products, and inventory.';
$adminActivePage = 'dashboard';
require '../includes/admin_header.php';
require '../includes/admin_sidebar.php';
?>

    <!-- TOP BAR -->
    <header class="admin-topbar">
      <button class="btn btn-sm btn-outline-secondary d-lg-none me-2" id="sidebarToggle" aria-label="Toggle sidebar">
        <i class="bi bi-list fs-5"></i>
      </button>
      <h5 class="mb-0 me-auto">Dashboard</h5>
      <div class="d-flex align-items-center gap-3">
        <span class="d-none d-sm-inline text-muted qa-desc">
          <i class="bi bi-calendar3 me-1"></i><span id="todayDate"></span>
        </span>
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

      <!-- Welcome -->
      <div class="mb-4">
        <h4 class="fw-700 mb-1">Welcome back, Admin</h4>
        <p class="text-muted mb-0 admin-username">Here's what's happening with your store today.</p>
      </div>

      <!-- STAT CARDS -->
      <div class="row g-3 mb-4">
        <div class="col-6 col-lg-4 col-xl">
          <div class="stat-card">
            <div class="stat-icon green-soft"><i class="bi bi-wallet2"></i></div>
            <div class="min-w-0 flex-grow-1">
              <div class="stat-value text-truncate" id="statTotalRevenue">₱0</div>
              <div class="stat-label">Total Revenue</div>
            </div>
          </div>
        </div>
        <div class="col-6 col-lg-4 col-xl">
          <div class="stat-card">
            <div class="stat-icon yellow-soft"><i class="bi bi-clock-history"></i></div>
            <div class="min-w-0 flex-grow-1">
              <div class="stat-value text-truncate" id="statPendingOrders">—</div>
              <div class="stat-label">Pending Orders</div>
            </div>
          </div>
        </div>
        <div class="col-6 col-lg-4 col-xl">
          <div class="stat-card">
            <div class="stat-icon blue-soft"><i class="bi bi-check2-circle"></i></div>
            <div class="min-w-0 flex-grow-1">
              <div class="stat-value text-truncate" id="statCompletedOrders">—</div>
              <div class="stat-label">Completed Orders</div>
            </div>
          </div>
        </div>
        <div class="col-6 col-lg-6 col-xl">
          <div class="stat-card">
            <div class="stat-icon pink-soft"><i class="bi bi-box-seam"></i></div>
            <div class="min-w-0 flex-grow-1">
              <div class="stat-value text-truncate" id="statTotalProducts">—</div>
              <div class="stat-label">Total Products</div>
            </div>
          </div>
        </div>
        <div class="col-12 col-lg-6 col-xl">
          <div class="stat-card">
            <div class="stat-icon yellow-soft"><i class="bi bi-exclamation-triangle"></i></div>
            <div class="min-w-0 flex-grow-1">
              <div class="stat-value text-truncate" id="statLowStock">—</div>
              <div class="stat-label">Low Stock Items</div>
            </div>
          </div>
        </div>
      </div>

      <div class="row g-4">

        <!-- RECENT ORDERS TABLE -->
        <div class="col-12 col-xl-8">
          <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-0 d-flex align-items-center justify-content-between py-3 px-4">
              <h6 class="fw-700 mb-0"><i class="bi bi-receipt me-2 text-ct"></i>Recent Orders</h6>
              <a href="orders.php" class="btn btn-sm btn-ct-outline">View All</a>
            </div>
            <div class="table-responsive">
              <table class="table table-hover align-middle mb-0" aria-label="Recent orders">
                <thead class="table-light">
                  <tr>
                    <th class="ps-4 admin-th">Order ID</th>
                    <th class="admin-th">Customer</th>
                    <th class="d-none d-md-table-cell admin-th">Items</th>
                    <th class="admin-th">Total</th>
                    <th class="d-none d-lg-table-cell admin-th">Fulfillment</th>
                    <th class="admin-th">Status</th>
                    <th class="pe-4 admin-th">Action</th>
                  </tr>
                </thead>
                <tbody id="recentOrdersTbody">
                  <tr>
                    <td colspan="7" class="text-center py-4 text-muted">
                      <div class="spinner-border spinner-border-sm text-ct me-2" role="status"></div>
                      Loading recent orders…
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>

        <!-- LOW STOCK ALERTS -->
        <div class="col-12 col-xl-4">
          <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-0 d-flex align-items-center justify-content-between py-3 px-4">
              <h6 class="fw-700 mb-0"><i class="bi bi-exclamation-triangle me-2 text-warning"></i>Low Stock Alerts</h6>
              <a href="products.php" class="btn btn-sm btn-ct-outline">Manage</a>
            </div>
            <div class="card-body px-4 py-2">
              <ul class="list-unstyled mb-0" id="lowStockList">
                <li class="py-4 text-center text-muted">
                  <div class="spinner-border spinner-border-sm text-ct me-2" role="status"></div>
                  Checking inventory levels…
                </li>
              </ul>
            </div>
          </div>
        </div>

      </div><!-- /row -->

      <!-- QUICK ACTIONS -->
      <div class="row g-3 mt-2">
        <div class="col-12">
          <h6 class="fw-700 mb-2"><i class="bi bi-lightning-charge-fill me-2 text-ct"></i>Quick Actions</h6>
        </div>
        <div class="col-12 col-md-4">
          <div class="card border-0 shadow-sm text-center p-4">
            <div class="mb-3">
              <span class="qa-icon-wrap pink"><i class="bi bi-plus-circle-fill"></i></span>
            </div>
            <h6 class="fw-700 mb-1">Add New Product</h6>
            <p class="text-muted mb-3 qa-desc">List a new gadget in your inventory.</p>
            <a href="products.php" class="btn w-100 btn-ct">Add Product</a>
          </div>
        </div>
        <div class="col-12 col-md-4">
          <div class="card border-0 shadow-sm text-center p-4">
            <div class="mb-3">
              <span class="qa-icon-wrap green"><i class="bi bi-file-earmark-spreadsheet-fill"></i></span>
            </div>
            <h6 class="fw-700 mb-1">Export Orders CSV</h6>
            <p class="text-muted mb-3 qa-desc">Download all order records as a spreadsheet.</p>
            <button class="btn w-100 btn-ct-outline" onclick="exportOrdersCSV()">Export CSV</button>
          </div>
        </div>
        <div class="col-12 col-md-4">
          <div class="card border-0 shadow-sm text-center p-4">
            <div class="mb-3">
              <span class="qa-icon-wrap blue"><i class="bi bi-boxes"></i></span>
            </div>
            <h6 class="fw-700 mb-1">View Inventory</h6>
            <p class="text-muted mb-3 qa-desc">Check stock levels and product details.</p>
            <a href="products.php" class="btn w-100 btn-ct-outline">View Inventory</a>
          </div>
        </div>
      </div>

    </main>
  </div><!-- /admin-content -->
</div><!-- /admin-layout -->

<div class="toast-ct" id="toastMsg" role="alert" aria-live="polite"></div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="<?= asset_url('../assets/js/main.js') ?>"></script>
<script src="<?= asset_url('../assets/js/admin/dashboard.js') ?>"></script>
</body>
</html>
