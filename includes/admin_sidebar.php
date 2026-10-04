<?php $adminActivePage = $adminActivePage ?? ''; ?>

<!-- Sidebar Overlay (mobile) -->
<div id="sidebarOverlay" class="position-fixed"></div>

<div class="admin-layout">

  <!-- ========== SIDEBAR ========== -->
  <aside class="admin-sidebar" id="adminSidebar" aria-label="Admin navigation">
    <style>
      .admin-sidebar .nav-link:hover {
        color: var(--ct-primary);
        background: var(--ct-primary-soft);
        border-left-color: var(--ct-primary);
      }
      .admin-sidebar .nav-link.active {
        color: var(--ct-primary);
        background: var(--ct-primary-soft);
        border-left-color: var(--ct-primary);
        font-weight: 600;
      }
      .admin-sidebar .nav-link:hover i,
      .admin-sidebar .nav-link.active i {
        color: var(--ct-primary);
      }
    </style>
    <div class="sidebar-brand d-flex align-items-center justify-content-between">
      <a href="dashboard.php" class="d-flex align-items-center gap-2 text-decoration-none">
        <img src="../assets/img/logo-64.png" alt="Cheyn Gadgets" width="34" height="34">
        <span class="brand-name">Cheyn Gadgets</span>
      </a>
      <button type="button" class="btn btn-sm btn-link text-white-50 d-lg-none p-0 ms-2" id="sidebarCloseBtn" aria-label="Close sidebar">
        <i class="bi bi-x-lg fs-5"></i>
      </button>
    </div>

    <div class="sidebar-section-label">Main Menu</div>
    <nav>
      <a href="dashboard.php" class="nav-link <?= $adminActivePage === 'dashboard' ? 'active' : '' ?>" <?= $adminActivePage === 'dashboard' ? 'aria-current="page"' : '' ?>>
        <i class="bi bi-grid-1x2-fill"></i> Dashboard
      </a>
      <a href="products.php" class="nav-link <?= $adminActivePage === 'products' ? 'active' : '' ?>" <?= $adminActivePage === 'products' ? 'aria-current="page"' : '' ?>>
        <i class="bi bi-box-seam"></i> Products
      </a>
      <a href="orders.php" class="nav-link <?= $adminActivePage === 'orders' ? 'active' : '' ?>" <?= $adminActivePage === 'orders' ? 'aria-current="page"' : '' ?>>
        <i class="bi bi-receipt"></i> Orders
      </a>
    </nav>

    <div class="sidebar-section-label mt-2">System</div>
    <nav>
      <a href="settings.php" class="nav-link <?= $adminActivePage === 'settings' ? 'active' : '' ?>" <?= $adminActivePage === 'settings' ? 'aria-current="page"' : '' ?>>
        <i class="bi bi-gear"></i> Settings
      </a>
    </nav>

    <div class="mt-auto p-3 border-top border-white border-opacity-10">
      <a href="../login.php?action=logout" class="nav-link sidebar-logout">
        <i class="bi bi-box-arrow-left"></i> Logout
      </a>
    </div>
  </aside>

  <!-- ========== MAIN CONTENT ========== -->
  <div class="admin-content">
