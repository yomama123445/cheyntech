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
            <div class="admin-user-avatar">A</div>
            <span class="fw-600 d-none d-md-inline admin-username">Admin User</span>
            <i class="bi bi-chevron-down admin-chevron d-none d-md-inline"></i>
          </button>
          <ul class="dropdown-menu dropdown-menu-end admin-profile-menu" aria-labelledby="profileDropdown">
            <li class="admin-profile-header px-3 py-2">
              <div class="d-flex align-items-center gap-2">
                <div class="admin-user-avatar">A</div>
                <div>
                  <div class="fw-700 admin-profile-name">Admin User</div>
                  <div class="text-muted admin-profile-role">Administrator</div>
                </div>
              </div>
            </li>
            <li><hr class="dropdown-divider my-1"></li>
            <li><a class="dropdown-item" href="#"><i class="bi bi-person me-2"></i>My Profile</a></li>
            <li><a class="dropdown-item" href="#"><i class="bi bi-gear me-2"></i>Settings</a></li>
            <li><hr class="dropdown-divider my-1"></li>
            <li><a class="dropdown-item text-danger" href="../login.php"><i class="bi bi-box-arrow-left me-2"></i>Logout</a></li>
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
        <div class="col-6 col-xl-3">
          <div class="stat-card">
            <div class="stat-icon pink-soft"><i class="bi bi-box-seam"></i></div>
            <div>
              <div class="stat-value">48</div>
              <div class="stat-label">Total Products</div>
            </div>
          </div>
        </div>
        <div class="col-6 col-xl-3">
          <div class="stat-card">
            <div class="stat-icon yellow-soft"><i class="bi bi-clock"></i></div>
            <div>
              <div class="stat-value">12</div>
              <div class="stat-label">Pending Orders</div>
            </div>
          </div>
        </div>
        <div class="col-6 col-xl-3">
          <div class="stat-card">
            <div class="stat-icon green-soft"><i class="bi bi-check-circle"></i></div>
            <div>
              <div class="stat-value">89</div>
              <div class="stat-label">Completed Orders</div>
            </div>
          </div>
        </div>
        <div class="col-6 col-xl-3">
          <div class="stat-card">
            <div class="stat-icon blue-soft"><i class="bi bi-exclamation-triangle"></i></div>
            <div>
              <div class="stat-value">5</div>
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
                <tbody>
                  <tr>
                    <td class="ps-4 td-id">#CT-0091</td>
                    <td class="td-name">Maria Santos</td>
                    <td class="d-none d-md-table-cell td-meta">iPhone 14 Pro × 1</td>
                    <td class="td-id">₱58,000</td>
                    <td class="d-none d-lg-table-cell"><span class="badge bg-info-subtle text-info-emphasis rounded-pill td-sm-badge">Delivery</span></td>
                    <td><span class="badge bg-warning-subtle text-warning-emphasis rounded-pill td-sm-badge">Pending</span></td>
                    <td class="pe-4"><a href="orders.php" class="btn btn-sm btn-outline-secondary td-sm-badge">View</a></td>
                  </tr>
                  <tr>
                    <td class="ps-4 td-id">#CT-0090</td>
                    <td class="td-name">Juan dela Cruz</td>
                    <td class="d-none d-md-table-cell td-meta">Samsung S24 Ultra × 1</td>
                    <td class="td-id">₱72,500</td>
                    <td class="d-none d-lg-table-cell"><span class="badge bg-secondary-subtle text-secondary-emphasis rounded-pill td-sm-badge">Pickup</span></td>
                    <td><span class="badge rounded-pill td-sm-badge badge-status-processing">Processing</span></td>
                    <td class="pe-4"><a href="orders.php" class="btn btn-sm btn-outline-secondary td-sm-badge">View</a></td>
                  </tr>
                  <tr>
                    <td class="ps-4 td-id">#CT-0089</td>
                    <td class="td-name">Ana Reyes</td>
                    <td class="d-none d-md-table-cell td-meta">iPad Air (M2) × 1, AirPods × 1</td>
                    <td class="td-id">₱46,200</td>
                    <td class="d-none d-lg-table-cell"><span class="badge bg-info-subtle text-info-emphasis rounded-pill td-sm-badge">Delivery</span></td>
                    <td><span class="badge rounded-pill td-sm-badge badge-status-ready">Ready</span></td>
                    <td class="pe-4"><a href="orders.php" class="btn btn-sm btn-outline-secondary td-sm-badge">View</a></td>
                  </tr>
                  <tr>
                    <td class="ps-4 td-id">#CT-0088</td>
                    <td class="td-name">Carlo Mendoza</td>
                    <td class="d-none d-md-table-cell td-meta">iPhone 13 Pre-owned × 2</td>
                    <td class="td-id">₱39,000</td>
                    <td class="d-none d-lg-table-cell"><span class="badge bg-secondary-subtle text-secondary-emphasis rounded-pill td-sm-badge">Pickup</span></td>
                    <td><span class="badge bg-success-subtle text-success-emphasis rounded-pill td-sm-badge">Completed</span></td>
                    <td class="pe-4"><a href="orders.php" class="btn btn-sm btn-outline-secondary td-sm-badge">View</a></td>
                  </tr>
                  <tr>
                    <td class="ps-4 td-id">#CT-0087</td>
                    <td class="td-name">Liza Bautista</td>
                    <td class="d-none d-md-table-cell td-meta">Xiaomi 14T Pro × 1</td>
                    <td class="td-id">₱29,999</td>
                    <td class="d-none d-lg-table-cell"><span class="badge bg-info-subtle text-info-emphasis rounded-pill td-sm-badge">Delivery</span></td>
                    <td><span class="badge rounded-pill td-sm-badge badge-status-processing">Processing</span></td>
                    <td class="pe-4"><a href="orders.php" class="btn btn-sm btn-outline-secondary td-sm-badge">View</a></td>
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
              <h6 class="fw-700 mb-0"><i class="bi bi-exclamation-triangle me-2 alert-icon-blue"></i>Low Stock Alerts</h6>
              <a href="products.php" class="btn btn-sm btn-ct-outline">Manage</a>
            </div>
            <div class="card-body px-4 py-2">
              <ul class="list-unstyled mb-0">
                <li class="d-flex align-items-center justify-content-between py-3 border-bottom">
                  <div class="d-flex align-items-center gap-3">
                    <div class="low-stock-icon pink"><i class="bi bi-phone"></i></div>
                    <div>
                      <div class="low-stock-name">iPhone 12 Mini (Pre-owned)</div>
                      <div class="low-stock-qty">Only 2 units left</div>
                    </div>
                  </div>
                  <span class="badge-ct badge-preowned">Restock</span>
                </li>
                <li class="d-flex align-items-center justify-content-between py-3 border-bottom">
                  <div class="d-flex align-items-center gap-3">
                    <div class="low-stock-icon blue"><i class="bi bi-tablet"></i></div>
                    <div>
                      <div class="low-stock-name">Samsung Galaxy Tab S9</div>
                      <div class="low-stock-qty">Only 1 unit left</div>
                    </div>
                  </div>
                  <span class="badge-ct badge-preowned">Restock</span>
                </li>
                <li class="d-flex align-items-center justify-content-between py-3 border-bottom">
                  <div class="d-flex align-items-center gap-3">
                    <div class="low-stock-icon yellow"><i class="bi bi-earbuds"></i></div>
                    <div>
                      <div class="low-stock-name">AirPods Pro (2nd Gen)</div>
                      <div class="low-stock-qty">Only 3 units left</div>
                    </div>
                  </div>
                  <span class="badge-ct badge-refurbished">Restock</span>
                </li>
                <li class="d-flex align-items-center justify-content-between py-3 border-bottom">
                  <div class="d-flex align-items-center gap-3">
                    <div class="low-stock-icon green"><i class="bi bi-watch"></i></div>
                    <div>
                      <div class="low-stock-name">Apple Watch Series 9</div>
                      <div class="low-stock-qty">Only 2 units left</div>
                    </div>
                  </div>
                  <span class="badge-ct badge-available">Restock</span>
                </li>
                <li class="d-flex align-items-center justify-content-between py-3">
                  <div class="d-flex align-items-center gap-3">
                    <div class="low-stock-icon pink"><i class="bi bi-phone-flip"></i></div>
                    <div>
                      <div class="low-stock-name">Oppo Find X7 Ultra</div>
                      <div class="low-stock-qty">Only 1 unit left</div>
                    </div>
                  </div>
                  <span class="badge-ct badge-preowned">Restock</span>
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
<script src="../assets/js/main.js"></script>
<script src="../assets/js/admin/dashboard.js"></script>
</body>
</html>
