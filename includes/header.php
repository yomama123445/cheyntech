<?php
require_once __DIR__ . '/session.php';
$_SESSION['csrf_token'] = $_SESSION['csrf_token'] ?? bin2hex(random_bytes(32));

// Set defaults if not defined before including
$pageTitle       = $pageTitle       ?? 'Cheyn Gadgets | Gadgets You Can Trust';
$pageDescription = $pageDescription ?? 'Cheyn Gadgets — Browse pre-owned, refurbished, and brand-new phones and tablets. Order online for in-store pickup or local delivery in Roxas City.';
$activePage      = $activePage      ?? '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="<?= htmlspecialchars($pageDescription) ?>">
  <meta name="csrf-token" content="<?= $_SESSION['csrf_token'] ?>">
  <title><?= htmlspecialchars($pageTitle) ?></title>
  <link rel="icon" type="image/png" href="assets/img/favicon-32.png">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

  <!-- SEARCH OVERLAY -->
  <div class="search-overlay" id="searchOverlay" role="dialog" aria-modal="true" aria-labelledby="searchOverlayTitle">
    <h2 id="searchOverlayTitle" class="visually-hidden">Search Products</h2>
    <button class="search-close" id="searchClose" aria-label="Close search"><i class="bi bi-x"></i></button>
    <form class="search-inner" id="searchForm" role="search">
      <input type="search" id="searchInput" placeholder="Search for phones, tablets…" autocomplete="off" aria-labelledby="searchOverlayTitle">
      <p class="search-hint">Press Enter to search · Esc to close</p>
    </form>
  </div>

  <!-- NAVBAR -->
  <nav class="navbar navbar-expand-lg navbar-ct sticky-top" role="navigation" aria-label="Main navigation">
    <div class="container">
      <a class="navbar-brand d-flex align-items-center gap-2" href="index.php">
        <img src="assets/img/logo-64.png" alt="Cheyn Gadgets logo" width="38" height="38">
        <span class="brand-name">Cheyn Gadgets</span>
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMain"
              aria-controls="navMain" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navMain">
        <ul class="navbar-nav mx-auto gap-1">
          <li class="nav-item"><a class="nav-link <?= $activePage === 'home'        ? 'active' : '' ?>" <?= $activePage === 'home'        ? 'aria-current="page"' : '' ?> href="index.php">Home</a></li>
          <li class="nav-item"><a class="nav-link <?= $activePage === 'catalog'     ? 'active' : '' ?>" <?= $activePage === 'catalog'     ? 'aria-current="page"' : '' ?> href="catalog.php">Catalog</a></li>
          <li class="nav-item"><a class="nav-link <?= $activePage === 'about'       ? 'active' : '' ?>" <?= $activePage === 'about'       ? 'aria-current="page"' : '' ?> href="about.php">About</a></li>
          <li class="nav-item"><a class="nav-link <?= $activePage === 'track-order' ? 'active' : '' ?>" <?= $activePage === 'track-order' ? 'aria-current="page"' : '' ?> href="track-order.php">Track Order</a></li>
        </ul>
        <div class="d-flex align-items-center gap-3 nav-icons">
          <a href="#" id="searchToggle" aria-label="Search"><i class="bi bi-search"></i></a>
          <a href="cart.php" class="position-relative" aria-label="Shopping cart">
            <i class="bi bi-cart3"></i>
            <span class="cart-badge">0</span>
          </a>
          <?php if (!empty($_SESSION['user_id'])): ?>
            <div class="dropdown">
              <a href="profile.php" class="d-flex align-items-center gap-1 text-decoration-none text-dark" id="accountDropdown" data-bs-toggle="dropdown" aria-expanded="false" aria-label="My Account">
                <i class="bi bi-person-circle fs-5"></i>
                <span class="small fw-semibold d-none d-lg-inline">My Account</span>
              </a>
              <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0" aria-labelledby="accountDropdown">
                <li><span class="dropdown-item-text text-muted small">Signed in as<br><strong><?= htmlspecialchars($_SESSION['user_name'] ?? 'User') ?></strong></span></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item" href="profile.php"><i class="bi bi-person me-2"></i>My Profile &amp; Orders</a></li>
                <?php if (($_SESSION['user_role'] ?? '') === 'admin'): ?>
                  <li><a class="dropdown-item" href="admin/dashboard.php"><i class="bi bi-speedometer2 me-2"></i>Admin Dashboard</a></li>
                <?php endif; ?>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item text-danger" href="login.php?action=logout" id="navLogoutLink"><i class="bi bi-box-arrow-right me-2"></i>Log Out</a></li>
              </ul>
            </div>
          <?php else: ?>
            <a href="login.php" aria-label="Account"><i class="bi bi-person-circle"></i></a>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </nav>
