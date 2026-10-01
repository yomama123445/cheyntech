<?php
require_once __DIR__ . '/includes/session.php';

if (empty($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$pageTitle       = 'My Account | Cheyn Gadgets';
$pageDescription = 'Manage your Cheyn Gadgets profile, view your past orders, and track deliveries.';
$activePage      = 'profile';

require 'includes/header.php';
?>

  <!-- BREADCRUMB -->
  <div class="breadcrumb-wrap">
    <div class="container">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.php">Home</a></li>
          <li class="breadcrumb-item active" aria-current="page">My Account</li>
        </ol>
      </nav>
    </div>
  </div>

  <!-- PAGE HEADER -->
  <div class="page-header py-4 bg-light border-bottom">
    <div class="container">
      <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
        <div>
          <h1 class="h3 fw-bold mb-1">My Account</h1>
          <p class="text-muted small mb-0">Manage your profile details and view your gadget orders.</p>
        </div>
        <div class="d-flex align-items-center gap-2">
          <a href="login.php?action=logout" class="btn btn-outline-danger btn-sm">
            <i class="bi bi-box-arrow-right me-1"></i>Sign Out
          </a>
        </div>
      </div>
    </div>
  </div>

  <!-- MAIN CONTENT -->
  <main class="py-5">
    <div class="container">
      <div class="row g-4">
        
        <!-- LEFT: Profile & Settings -->
        <div class="col-lg-4">
          <!-- Profile Card -->
          <div class="card border-0 shadow-sm rounded-4 mb-4">
            <div class="card-body p-4 text-center">
              <div class="rounded-circle bg-light d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                <i class="bi bi-person-fill text-primary display-6"></i>
              </div>
              <h2 class="h5 fw-bold mb-1" id="profileDisplayName"><?= htmlspecialchars($_SESSION['user_name'] ?? 'User') ?></h2>
              <p class="text-muted small mb-3" id="profileDisplayEmail"><?= htmlspecialchars($_SESSION['user_email'] ?? '') ?></p>
              <div class="badge bg-secondary-subtle text-secondary px-3 py-2 rounded-pill small" id="profileDisplayRole">
                <?= ucfirst(htmlspecialchars($_SESSION['user_role'] ?? 'Customer')) ?>
              </div>
            </div>
          </div>

          <!-- Edit Profile Form Card -->
          <div class="card border-0 shadow-sm rounded-4 mb-4">
            <div class="card-header bg-white border-0 pt-4 px-4 pb-0">
              <h3 class="h6 fw-bold mb-0"><i class="bi bi-person-gear me-2 text-primary"></i>Personal Details</h3>
            </div>
            <div class="card-body p-4">
              <div class="alert alert-success d-none py-2 px-3 small" id="profileSuccessAlert" role="alert"></div>
              <div class="alert alert-danger d-none py-2 px-3 small" id="profileErrorAlert" role="alert"></div>

              <form id="profileForm" novalidate>
                <div class="mb-3">
                  <label for="profileName" class="form-label small fw-semibold">Full Name</label>
                  <input type="text" class="form-control form-control-sm" id="profileName" maxlength="100" required>
                </div>
                <div class="mb-3">
                  <label for="profileEmail" class="form-label small fw-semibold">Email Address</label>
                  <input type="email" class="form-control form-control-sm bg-light" id="profileEmail" readonly disabled>
                  <div class="form-text text-muted small">Email address cannot be modified.</div>
                </div>
                <div class="mb-3">
                  <label for="profilePhone" class="form-label small fw-semibold">Contact Phone</label>
                  <input type="tel" class="form-control form-control-sm" id="profilePhone" placeholder="09XX-XXX-XXXX" maxlength="30">
                </div>
                <button type="submit" class="btn btn-ct btn-sm w-100 py-2">
                  <i class="bi bi-check2 me-1"></i>Save Changes
                </button>
              </form>
            </div>
          </div>

          <!-- Change Password Card -->
          <div class="card border-0 shadow-sm rounded-4">
            <div class="card-header bg-white border-0 pt-4 px-4 pb-0">
              <h3 class="h6 fw-bold mb-0"><i class="bi bi-shield-lock me-2 text-primary"></i>Change Password</h3>
            </div>
            <div class="card-body p-4">
              <div class="alert alert-success d-none py-2 px-3 small" id="passwordSuccessAlert" role="alert"></div>
              <div class="alert alert-danger d-none py-2 px-3 small" id="passwordErrorAlert" role="alert"></div>

              <form id="passwordForm" novalidate>
                <div class="mb-3">
                  <label for="currentPassword" class="form-label small fw-semibold">Current Password</label>
                  <input type="password" class="form-control form-control-sm" id="currentPassword" required autocomplete="current-password">
                </div>
                <div class="mb-3">
                  <label for="newPassword" class="form-label small fw-semibold">New Password</label>
                  <input type="password" class="form-control form-control-sm" id="newPassword" minlength="8" required autocomplete="new-password">
                  <div class="form-text text-muted small">Minimum 8 characters.</div>
                </div>
                <div class="mb-3">
                  <label for="confirmPassword" class="form-label small fw-semibold">Confirm New Password</label>
                  <input type="password" class="form-control form-control-sm" id="confirmPassword" minlength="8" required autocomplete="new-password">
                </div>
                <button type="submit" class="btn btn-outline-dark btn-sm w-100 py-2">
                  <i class="bi bi-key me-1"></i>Update Password
                </button>
              </form>
            </div>
          </div>
        </div>

        <!-- RIGHT: Order History -->
        <div class="col-lg-8">
          <div class="card border-0 shadow-sm rounded-4">
            <div class="card-header bg-white border-0 p-4 pb-0 d-flex align-items-center justify-content-between">
              <div>
                <h2 class="h5 fw-bold mb-1"><i class="bi bi-receipt me-2 text-primary"></i>Order History</h2>
                <p class="text-muted small mb-0">View all past and current orders placed with this account.</p>
              </div>
              <a href="catalog.php" class="btn btn-ct-outline btn-sm">
                <i class="bi bi-bag-plus me-1"></i>Shop More
              </a>
            </div>
            <div class="card-body p-4">
              <div id="ordersLoading" class="text-center py-5">
                <div class="spinner-border text-primary" role="status">
                  <span class="visually-hidden">Loading orders…</span>
                </div>
                <p class="text-muted small mt-2">Loading your orders…</p>
              </div>

              <div id="noOrdersMessage" class="text-center py-5 d-none">
                <div class="rounded-circle bg-light d-inline-flex align-items-center justify-content-center mb-3" style="width: 64px; height: 64px;">
                  <i class="bi bi-bag-x text-muted fs-3"></i>
                </div>
                <h3 class="h6 fw-bold mb-1">No Orders Yet</h3>
                <p class="text-muted small mb-3">You haven't placed any orders yet. Discover our quality gadgets today!</p>
                <a href="catalog.php" class="btn btn-ct btn-sm px-4">Browse Catalog</a>
              </div>

              <div id="ordersContainer" class="d-none">
                <div class="table-responsive">
                  <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                      <tr class="small text-muted">
                        <th>Order #</th>
                        <th>Date</th>
                        <th>Items</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody id="ordersTableBody" class="small">
                      <!-- Rendered by profile.js -->
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>
    </div>
  </main>

<?php require 'includes/footer.php'; ?>
  <script src="assets/js/profile.js"></script>
</body>
</html>
