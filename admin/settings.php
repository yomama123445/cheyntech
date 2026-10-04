<?php
$pageTitle       = 'Settings | Cheyn Gadgets Admin';
$pageDescription = 'Cheyn Gadgets Admin Settings — configure store details, payment channels, and system information.';
$adminActivePage = 'settings';
require '../includes/admin_header.php';
require '../includes/admin_sidebar.php';
?>

    <!-- TOP BAR -->
    <header class="admin-topbar">
      <button class="btn btn-sm btn-outline-secondary d-lg-none me-2" id="sidebarToggle" aria-label="Toggle sidebar">
        <i class="bi bi-list fs-5"></i>
      </button>
      <h5 class="mb-0 me-auto">Settings</h5>
      <div class="d-flex align-items-center gap-3">
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
            <li><a class="dropdown-item active" href="settings.php"><i class="bi bi-gear me-2"></i>Settings</a></li>
            <li><hr class="dropdown-divider my-1"></li>
            <li><a class="dropdown-item text-danger" href="../login.php?action=logout"><i class="bi bi-box-arrow-left me-2"></i>Logout</a></li>
          </ul>
        </div>
      </div>
    </header>

    <!-- MAIN AREA -->
    <main class="admin-main">

      <div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-2">
        <div>
          <h4 class="fw-bold mb-1">Store &amp; System Settings</h4>
          <p class="text-muted small mb-0">Overview of operational store parameters, payment accounts, and admin security.</p>
        </div>
      </div>

      <div class="row g-4">

        <!-- Store Profile Information -->
        <div class="col-lg-6">
          <div class="card border-0 shadow-sm rounded-4 h-100">
            <div class="card-header bg-white border-0 pt-4 px-4 pb-0 d-flex align-items-center justify-content-between">
              <h5 class="h6 fw-bold mb-0"><i class="bi bi-shop me-2 text-primary"></i>Storefront Profile</h5>
              <span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1 small">Live Storefront</span>
            </div>
            <div class="card-body p-4">
              <div class="mb-3">
                <label class="form-label text-muted small fw-semibold">Store Brand Name</label>
                <input type="text" class="form-control form-control-sm bg-light" value="Cheyn Gadgets" readonly>
              </div>
              <div class="mb-3">
                <label class="form-label text-muted small fw-semibold">Physical Location</label>
                <input type="text" class="form-control form-control-sm bg-light" value="Roxas City, Capiz, Philippines" readonly>
              </div>
              <div class="mb-3">
                <label class="form-label text-muted small fw-semibold">Store Hotline / Contact</label>
                <input type="text" class="form-control form-control-sm bg-light" value="0917-824-3968" readonly>
              </div>
              <div class="mb-0">
                <label class="form-label text-muted small fw-semibold">Operating Schedule</label>
                <input type="text" class="form-control form-control-sm bg-light" value="Monday – Saturday · 9:00 AM – 6:00 PM" readonly>
              </div>
            </div>
          </div>
        </div>

        <!-- Payment Channels & Accounts -->
        <div class="col-lg-6">
          <div class="card border-0 shadow-sm rounded-4 h-100">
            <div class="card-header bg-white border-0 pt-4 px-4 pb-0 d-flex align-items-center justify-content-between">
              <h5 class="h6 fw-bold mb-0"><i class="bi bi-wallet2 me-2 text-primary"></i>Payment Channels</h5>
              <span class="badge bg-primary-subtle text-primary border border-primary-subtle px-2 py-1 small">Manual Verification</span>
            </div>
            <div class="card-body p-4">
              <!-- GCash -->
              <div class="p-3 rounded-3 bg-light border mb-3">
                <div class="d-flex align-items-center justify-content-between mb-1">
                  <strong class="text-dark small"><i class="bi bi-phone-fill text-primary me-1"></i>GCash</strong>
                  <span class="badge bg-success small">Active</span>
                </div>
                <div class="small text-muted">Account Name: <strong class="text-dark">Cheyn's Gadgets</strong></div>
                <div class="small text-muted">Number: <span class="font-monospace text-dark fw-bold">0917-824-3968</span></div>
              </div>

              <!-- Bank Transfer -->
              <div class="p-3 rounded-3 bg-light border mb-3">
                <div class="d-flex align-items-center justify-content-between mb-1">
                  <strong class="text-dark small"><i class="bi bi-bank text-primary me-1"></i>Bank Transfer (BDO)</strong>
                  <span class="badge bg-success small">Active</span>
                </div>
                <div class="small text-muted">Account Name: <strong class="text-dark">BDO · Cheyn's Gadgets</strong></div>
                <div class="small text-muted">Account Number: <span class="font-monospace text-dark fw-bold">0012-3456-7890</span></div>
              </div>

              <!-- Cash -->
              <div class="p-3 rounded-3 bg-light border">
                <div class="d-flex align-items-center justify-content-between mb-1">
                  <strong class="text-dark small"><i class="bi bi-cash-stack text-primary me-1"></i>Cash on Pickup / Delivery</strong>
                  <span class="badge bg-success small">Active</span>
                </div>
                <div class="small text-muted">Pay in cash when picking up in-store or receiving local delivery.</div>
              </div>
            </div>
          </div>
        </div>

        <!-- Admin Account & Security -->
        <div class="col-lg-6">
          <div class="card border-0 shadow-sm rounded-4 h-100">
            <div class="card-header bg-white border-0 pt-4 px-4 pb-0">
              <h5 class="h6 fw-bold mb-0"><i class="bi bi-shield-lock me-2 text-primary"></i>Admin Account &amp; Credentials</h5>
            </div>
            <div class="card-body p-4">
              <p class="text-muted small mb-3">Your administrator account has full access to products, inventory counts, and order fulfillment states.</p>
              <div class="d-flex align-items-center gap-3 p-3 bg-light rounded-3 mb-3 border">
                <div class="admin-user-avatar fs-5" style="width:48px;height:48px;"><?= strtoupper(substr($_SESSION['user_name'] ?? 'A', 0, 1)) ?></div>
                <div>
                  <strong class="d-block text-dark"><?= htmlspecialchars($_SESSION['user_name'] ?? 'Admin') ?></strong>
                  <span class="text-muted small"><?= htmlspecialchars($_SESSION['user_email'] ?? 'admin@cheyngadgets.site') ?></span>
                </div>
                <span class="badge bg-primary ms-auto">Admin</span>
              </div>
              <div class="d-flex gap-2 flex-wrap">
                <a href="../profile.php" class="btn btn-outline-dark btn-sm">
                  <i class="bi bi-person-gear me-1"></i>Update Profile &amp; Password
                </a>
                <a href="../login.php?action=logout" class="btn btn-outline-danger btn-sm">
                  <i class="bi bi-box-arrow-left me-1"></i>Logout Now
                </a>
              </div>
            </div>
          </div>
        </div>

        <!-- System Diagnostics -->
        <div class="col-lg-6">
          <div class="card border-0 shadow-sm rounded-4 h-100">
            <div class="card-header bg-white border-0 pt-4 px-4 pb-0">
              <h5 class="h6 fw-bold mb-0"><i class="bi bi-cpu me-2 text-primary"></i>System Diagnostics</h5>
            </div>
            <div class="card-body p-4">
              <ul class="list-group list-group-flush small">
                <li class="list-group-item d-flex justify-content-between align-items-center px-0 py-2">
                  <span class="text-muted">PHP Version</span>
                  <span class="fw-semibold text-dark"><?= PHP_VERSION ?></span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center px-0 py-2">
                  <span class="text-muted">Hosting Stack</span>
                  <span class="fw-semibold text-dark">HestiaCP (Nginx + PHP-FPM)</span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center px-0 py-2">
                  <span class="text-muted">Asset Cache Busting</span>
                  <span class="badge bg-success-subtle text-success border border-success-subtle">Active (filemtime)</span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center px-0 py-2">
                  <span class="text-muted">Session Cookie Hardening</span>
                  <span class="badge bg-success-subtle text-success border border-success-subtle">HttpOnly · Lax</span>
                </li>
              </ul>
            </div>
          </div>
        </div>

      </div><!-- /row -->

    </main>
  </div><!-- /admin-content -->
</div><!-- /admin-layout -->

<div class="toast-ct" id="toastMsg" role="alert" aria-live="polite"></div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="<?= asset_url('../assets/js/main.js') ?>"></script>
</body>
</html>
