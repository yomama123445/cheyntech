<?php
$pageTitle       = 'Orders | CheynTech Admin';
$pageDescription = 'CheynTech Admin — Order Management.';
$adminActivePage = 'orders';
require '../includes/admin_header.php';
require '../includes/admin_sidebar.php';
?>

    <!-- TOP BAR -->
    <header class="admin-topbar">
      <button class="btn btn-sm btn-outline-secondary d-lg-none me-2" id="sidebarToggle" aria-label="Toggle sidebar">
        <i class="bi bi-list fs-5"></i>
      </button>
      <h5 class="mb-0 me-auto">Orders</h5>
      <div class="d-flex align-items-center gap-3">
        <button class="btn btn-outline-secondary btn-sm" onclick="exportCSV()">
          <i class="bi bi-download me-1"></i> Export CSV
        </button>
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

      <!-- Summary stat mini-cards -->
      <div class="row g-3 mb-4">
        <div class="col-6 col-lg-2">
          <div class="card border-0 shadow-sm text-center py-3 px-2">
            <div class="stat-count-sm" id="countAll">8</div>
            <div class="stat-label-sm">All Orders</div>
          </div>
        </div>
        <div class="col-6 col-lg-2">
          <div class="card border-0 shadow-sm text-center py-3 px-2">
            <div class="stat-count-sm" id="countPending">2</div>
            <div class="stat-label-sm">Pending</div>
          </div>
        </div>
        <div class="col-6 col-lg-2">
          <div class="card border-0 shadow-sm text-center py-3 px-2">
            <div class="stat-count-sm" id="countProcessing">2</div>
            <div class="stat-label-sm">Processing</div>
          </div>
        </div>
        <div class="col-6 col-lg-2">
          <div class="card border-0 shadow-sm text-center py-3 px-2">
            <div class="stat-count-sm" id="countReady">1</div>
            <div class="stat-label-sm">Ready</div>
          </div>
        </div>
        <div class="col-6 col-lg-2">
          <div class="card border-0 shadow-sm text-center py-3 px-2">
            <div class="stat-count-sm" id="countOutForDelivery">1</div>
            <div class="stat-label-sm">Out for Delivery</div>
          </div>
        </div>
        <div class="col-6 col-lg-2">
          <div class="card border-0 shadow-sm text-center py-3 px-2">
            <div class="stat-count-sm" id="countCompleted">2</div>
            <div class="stat-label-sm">Completed</div>
          </div>
        </div>
      </div>

      <!-- Filter Tabs -->
      <div class="card border-0 shadow-sm mb-4">
        <div class="card-body py-0 px-3">
          <ul class="nav nav-tabs border-0" id="orderTabs" role="tablist" aria-label="Order status filters">
            <li class="nav-item" role="presentation">
              <button class="nav-link active fw-600 px-3" id="tab-all" data-filter="All" type="button" onclick="filterOrders('All', this)">All</button>
            </li>
            <li class="nav-item" role="presentation">
              <button class="nav-link fw-600 px-3" data-filter="Pending" type="button" onclick="filterOrders('Pending', this)">Pending</button>
            </li>
            <li class="nav-item" role="presentation">
              <button class="nav-link fw-600 px-3" data-filter="Processing" type="button" onclick="filterOrders('Processing', this)">Processing</button>
            </li>
            <li class="nav-item" role="presentation">
              <button class="nav-link fw-600 px-3 d-none d-sm-block" data-filter="Ready for Pickup" type="button" onclick="filterOrders('Ready for Pickup', this)">Ready for Pickup</button>
            </li>
            <li class="nav-item" role="presentation">
              <button class="nav-link fw-600 px-3 d-none d-md-block" data-filter="Out for Delivery" type="button" onclick="filterOrders('Out for Delivery', this)">Out for Delivery</button>
            </li>
            <li class="nav-item" role="presentation">
              <button class="nav-link fw-600 px-3" data-filter="Completed" type="button" onclick="filterOrders('Completed', this)">Completed</button>
            </li>
          </ul>
        </div>
      </div>

      <!-- Orders Table -->
      <div class="card border-0 shadow-sm">
        <div class="table-responsive">
          <table class="table table-hover align-middle mb-0" id="ordersTable" aria-label="Orders table">
            <thead class="table-light">
              <tr>
                <th class="ps-4" class="admin-th">Order ID</th>
                <th class="admin-th" class="d-none d-md-table-cell">Date</th>
                <th class="admin-th">Customer</th>
                <th class="admin-th" class="d-none d-lg-table-cell">Items</th>
                <th class="admin-th">Total</th>
                <th class="admin-th" class="d-none d-md-table-cell">Fulfillment</th>
                <th class="admin-th" class="d-none d-lg-table-cell">Payment</th>
                <th class="admin-th">Status</th>
                <th class="pe-4" class="admin-th">Action</th>
              </tr>
            </thead>
            <tbody id="ordersTbody">
              <!-- rendered by JS -->
            </tbody>
          </table>
        </div>
        <div class="card-footer bg-white border-0 py-3 px-4 d-flex align-items-center justify-content-between">
          <p class="text-muted mb-0">Showing <span id="orderCount">8</span> orders</p>
          <nav aria-label="Orders pagination">
            <ul class="pagination pagination-sm mb-0">
              <li class="page-item active"><a class="page-link" href="#">1</a></li>
              <li class="page-item"><a class="page-link" href="#">2</a></li>
              <li class="page-item"><a class="page-link" href="#"><i class="bi bi-chevron-right"></i></a></li>
            </ul>
          </nav>
        </div>
      </div>

    </main>
  </div><!-- /admin-content -->
</div><!-- /admin-layout -->

<!-- ORDER DETAIL MODAL -->
<div class="modal fade" id="orderModal" tabindex="-1" aria-labelledby="orderModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header border-0 pb-0">
        <div>
          <h5 class="modal-title fw-700" id="orderModalLabel">Order #CT-0000</h5>
          <p class="text-muted mb-0" id="modalOrderDate">Loading…</p>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body pt-3">
        <div class="row g-4">

          <!-- Left: Customer + Items -->
          <div class="col-12 col-md-7">

            <!-- Customer Info -->
            <div class="mb-4">
              <h6 class="fw-700 mb-3"><i class="bi bi-person-circle me-2 text-ct"></i>Customer Info</h6>
              <div class="card bg-light border-0 p-3">
                <div class="row g-2">
                  <div class="col-5 text-muted fw-500">Name</div>
                  <div class="col-7 fw-600" id="modalCustomerName">—</div>
                  <div class="col-5 text-muted fw-500">Email</div>
                  <div class="col-7" id="modalCustomerEmail">—</div>
                  <div class="col-5 text-muted fw-500">Phone</div>
                  <div class="col-7" id="modalCustomerPhone">—</div>
                  <div class="col-5 text-muted fw-500">Address</div>
                  <div class="col-7" id="modalCustomerAddress">—</div>
                </div>
              </div>
            </div>

            <!-- Items List -->
            <div class="mb-4">
              <h6 class="fw-700 mb-3"><i class="bi bi-bag me-2 text-ct"></i>Items Ordered</h6>
              <div id="modalItemsList"></div>
              <div class="d-flex justify-content-between pt-3 border-top mt-2">
                <span class="fw-600">Order Total</span>
                <span class="fw-800" class="text-ct" id="modalTotal">₱0</span>
              </div>
            </div>

          </div>

          <!-- Right: Fulfillment + Payment + Status -->
          <div class="col-12 col-md-5">

            <!-- Fulfillment -->
            <div class="mb-4">
              <h6 class="fw-700 mb-3"><i class="bi bi-truck me-2 text-ct"></i>Fulfillment</h6>
              <div class="card bg-light border-0 p-3">
                <div class="row g-2">
                  <div class="col-5 text-muted fw-500">Type</div>
                  <div class="col-7 fw-600" id="modalFulfillment">—</div>
                  <div class="col-5 text-muted fw-500">Payment</div>
                  <div class="col-7 fw-600" id="modalPayment">—</div>
                  <div class="col-5 text-muted fw-500">Paid?</div>
                  <div class="col-7" id="modalPaid">—</div>
                </div>
              </div>
            </div>

            <!-- Update Status -->
            <div class="mb-4">
              <h6 class="fw-700 mb-3"><i class="bi bi-arrow-repeat me-2 text-ct"></i>Update Status</h6>
              <select class="form-select mb-3" id="modalStatusSelect" aria-label="Order status">
                <option value="Pending">Pending</option>
                <option value="Processing">Processing</option>
                <option value="Ready for Pickup">Ready for Pickup</option>
                <option value="Out for Delivery">Out for Delivery</option>
                <option value="Completed">Completed</option>
                <option value="Cancelled">Cancelled</option>
              </select>
              <button class="btn w-100 fw-600" class="btn-ct" onclick="updateOrderStatus()">
                <i class="bi bi-check-lg me-1"></i> Update Status
              </button>
            </div>

            <!-- Status History -->
            <div>
              <h6 class="fw-700 mb-3"><i class="bi bi-clock-history me-2 text-ct"></i>Status History</h6>
              <ul class="list-unstyled mb-0" id="modalStatusHistory">
                <!-- rendered by JS -->
              </ul>
            </div>

          </div>

        </div>
      </div>

      <div class="modal-footer border-0">
        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-outline-danger btn-sm" onclick="cancelOrder()">
          <i class="bi bi-x-circle me-1"></i> Cancel Order
        </button>
      </div>
    </div>
  </div>
</div>

<!-- Toast -->
<div class="toast-ct" id="toastMsg" role="alert" aria-live="polite"></div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="../assets/js/main.js"></script>
<script src="../assets/js/admin/orders.js"></script>
</body>
</html>
