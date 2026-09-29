<?php $adminActivePage = $adminActivePage ?? ''; ?>

<!-- Sidebar Overlay (mobile) -->
<div id="sidebarOverlay" class="position-fixed"></div>

<div class="admin-layout">

  <!-- ========== SIDEBAR ========== -->
  <aside class="admin-sidebar" id="adminSidebar" aria-label="Admin navigation">
    <a href="dashboard.php" class="sidebar-brand">
      <img src="../assets/img/logo-64.png" alt="Cheyn Gadgets" width="34" height="34">
      <span class="brand-name">Cheyn Gadgets</span>
    </a>

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
      <a href="#" class="nav-link">
        <i class="bi bi-people"></i> Customers
      </a>
    </nav>

    <div class="sidebar-section-label mt-2">System</div>
    <nav>
      <a href="#" class="nav-link sidebar-disabled" aria-disabled="true">
        <i class="bi bi-gear"></i> Settings
      </a>
    </nav>

    <div class="mt-auto p-3 border-top border-white border-opacity-10">
      <a href="../login.php" class="nav-link sidebar-logout">
        <i class="bi bi-box-arrow-left"></i> Logout
      </a>
    </div>
  </aside>

  <!-- ========== MAIN CONTENT ========== -->
  <div class="admin-content">
