<?php $adminActivePage = $adminActivePage ?? ''; ?>

<!-- Sidebar Overlay (mobile) -->
<div id="sidebarOverlay" class="position-fixed"></div>

<div class="admin-layout">

  <!-- ========== SIDEBAR ========== -->
  <aside class="admin-sidebar" id="adminSidebar" aria-label="Admin navigation">
    <div class="sidebar-brand d-flex align-items-center justify-content-between">
      <a href="dashboard.php" class="d-flex align-items-center gap-2 text-decoration-none">
        <img src="../assets/img/logo-64.png" alt="Cheyn Gadgets" width="30" height="30" class="rounded-circle shadow-xs">
        <span class="brand-name">Cheyn Gadgets<span class="text-ct ms-0.5">.</span></span>
      </a>
      <button type="button" class="btn btn-sm btn-link text-muted d-lg-none p-0 ms-2" id="sidebarCloseBtn" aria-label="Close sidebar">
        <i class="bi bi-x-lg fs-5"></i>
      </button>
    </div>

    <div class="sidebar-section-label">Overview</div>
    <nav>
      <a href="dashboard.php" class="nav-link <?= $adminActivePage === 'dashboard' ? 'active' : '' ?>" <?= $adminActivePage === 'dashboard' ? 'aria-current="page"' : '' ?>>
        <i class="bi bi-grid-1x2"></i> <span>Dashboard</span>
      </a>
      <a href="products.php" class="nav-link <?= $adminActivePage === 'products' ? 'active' : '' ?>" <?= $adminActivePage === 'products' ? 'aria-current="page"' : '' ?>>
        <i class="bi bi-box-seam"></i> <span>Products &amp; Stock</span>
      </a>
      <a href="orders.php" class="nav-link <?= $adminActivePage === 'orders' ? 'active' : '' ?>" <?= $adminActivePage === 'orders' ? 'aria-current="page"' : '' ?>>
        <i class="bi bi-receipt"></i> <span>Orders</span>
      </a>
      <a href="inquiries.php" class="nav-link <?= $adminActivePage === 'inquiries' ? 'active' : '' ?>" <?= $adminActivePage === 'inquiries' ? 'aria-current="page"' : '' ?>>
        <i class="bi bi-chat-left-dots"></i> <span>Inquiries</span>
      </a>
    </nav>

    <div class="sidebar-section-label mt-2">Configuration</div>
    <nav>
      <a href="settings.php" class="nav-link <?= $adminActivePage === 'settings' ? 'active' : '' ?>" <?= $adminActivePage === 'settings' ? 'aria-current="page"' : '' ?>>
        <i class="bi bi-sliders"></i> <span>Settings</span>
      </a>
      <a href="../catalog.php" class="nav-link" target="_blank" rel="noopener">
        <i class="bi bi-arrow-up-right-square"></i> <span>Storefront</span>
      </a>
    </nav>

    <div class="mt-auto p-3 border-top border-light-subtle">
      <a href="../login.php?action=logout" class="nav-link sidebar-logout d-flex align-items-center gap-2">
        <i class="bi bi-box-arrow-left"></i> <span>Sign Out</span>
      </a>
    </div>
  </aside>

  <!-- ========== MAIN CONTENT ========== -->
  <div class="admin-content">
