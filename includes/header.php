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
  <link rel="preconnect" href="https://cdn.jsdelivr.net" crossorigin>
  <link rel="dns-prefetch" href="https://cdn.jsdelivr.net">
  <link rel="icon" type="image/png" href="assets/img/favicon-32.png">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <link rel="stylesheet" href="<?= asset_url('assets/css/style.css') ?>">
</head>
<body>

<?php if ($activePage === 'login'): ?>
  <!-- APPLE-STYLE MINIMAL AUTH RIBBON (account.apple.com style) -->
  <header class="apple-minimal-nav" role="banner">
    <div class="container d-flex align-items-center justify-content-between">
      <a href="index.php" class="apple-minimal-brand d-flex align-items-center gap-2 text-decoration-none">
        <img src="assets/img/logo-64.png" alt="Cheyn Gadgets logo" width="28" height="28">
        <span class="apple-minimal-title">Cheyn ID</span>
      </a>
      <a href="index.php" class="apple-minimal-back text-decoration-none">
        <span class="d-none d-sm-inline">Return to </span>Store &rarr;
      </a>
    </div>
  </header>
<?php else: ?>

  <!-- SEARCH OVERLAY -->
  <div class="search-overlay" id="searchOverlay" role="dialog" aria-modal="true" aria-labelledby="searchOverlayTitle">
    <h2 id="searchOverlayTitle" class="visually-hidden">Search Products</h2>
    <button class="search-close" id="searchClose" aria-label="Close search"><i class="bi bi-x"></i></button>
    <form class="search-inner" id="searchForm" role="search">
      <input type="search" id="searchInput" placeholder="Search for phones, tablets…" autocomplete="off" aria-labelledby="searchOverlayTitle">
      <p class="search-hint">Press Enter to search · Esc to close</p>
    </form>
  </div>

  <!-- TOP UTILITY BAR (Hidden for Apple-grade slim translucent navigation) -->
  <div class="top-utility-bar d-none">
  </div>

  <!-- NAVBAR (Apple-grade slim translucent navbar) -->
  <nav class="navbar navbar-expand-lg navbar-ct sticky-top" role="navigation" aria-label="Main navigation">
    <div class="container d-flex align-items-center justify-content-between">
      <a class="navbar-brand d-flex align-items-center gap-2" href="index.php">
        <img src="assets/img/logo-64.png" alt="Cheyn Gadgets logo" width="22" height="22">
        <span class="brand-name">Cheyn Gadgets<span class="brand-dot">.</span></span>
      </a>
      <!-- Mobile Quick Actions -->
      <div class="d-flex align-items-center gap-2 d-lg-none">
        <a href="#" class="mobile-nav-btn nav-search-trigger" aria-label="Search">
          <i class="bi bi-search"></i>
        </a>
        <a href="cart.php" class="mobile-nav-btn position-relative" aria-label="Shopping cart">
          <i class="bi bi-bag"></i>
          <span class="cart-badge">0</span>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMain"
                aria-controls="navMain" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
      </div>

      <div class="collapse navbar-collapse" id="navMain">
        <ul class="navbar-nav mx-auto gap-lg-1">
          <li class="nav-item">
            <a class="nav-link <?= $activePage === 'home' ? 'active' : '' ?>" <?= $activePage === 'home' ? 'aria-current="page"' : '' ?> href="index.php">Home</a>
          </li>

          <!-- Apple Dropdown -->
          <li class="nav-item dropdown has-nav-tray">
            <a class="nav-link dropdown-toggle" href="catalog.php?cat=preowned" id="appleDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              Apple
            </a>
            <div class="dropdown-menu nav-tray shadow-sm" aria-labelledby="appleDropdown">
              <div class="container">
                <div class="row g-4 align-items-start">
                  <div class="col-12 col-lg-5">
                    <span class="nav-tray-heading">Explore Apple</span>
                    <div class="d-flex flex-column gap-2">
                      <a class="nav-tray-item" href="catalog.php?cat=preowned">
                        <i class="bi bi-phone text-ct"></i>
                        <div>
                          <div class="nav-tray-item-title">Pre-owned iPhones</div>
                          <span class="nav-tray-item-desc">Tested battery &amp; Grade A units</span>
                        </div>
                      </a>
                      <a class="nav-tray-item" href="catalog.php?cat=new">
                        <i class="bi bi-box-seam text-ct"></i>
                        <div>
                          <div class="nav-tray-item-title">Brand New iPhones</div>
                          <span class="nav-tray-item-desc">Factory sealed official units</span>
                        </div>
                      </a>
                      <a class="nav-tray-item" href="catalog.php?cat=wearable">
                        <i class="bi bi-smartwatch text-ct"></i>
                        <div>
                          <div class="nav-tray-item-title">Apple Watches &amp; AirPods</div>
                          <span class="nav-tray-item-desc">Wearables &amp; sound accessories</span>
                        </div>
                      </a>
                    </div>
                  </div>
                  <div class="col-12 col-lg-3 d-none d-lg-block border-start ps-lg-4">
                    <span class="nav-tray-heading">Popular Models</span>
                    <ul class="nav-tray-sublinks">
                      <li><a href="catalog.php?q=iPhone+11">iPhone 11 Series</a></li>
                      <li><a href="catalog.php?q=iPhone+12">iPhone 12 / 12 Pro</a></li>
                      <li><a href="catalog.php?q=iPhone+13">iPhone 13 / 13 Pro</a></li>
                      <li><a href="catalog.php?q=iPhone+14">iPhone 14 / 14 Pro Max</a></li>
                      <li><a href="catalog.php?q=iPhone+15">iPhone 15 Series</a></li>
                    </ul>
                  </div>
                  <div class="col-12 col-lg-4 d-none d-lg-block">
                    <div class="nav-tray-card">
                      <span class="badge bg-white text-dark border mb-2"><i class="bi bi-geo-alt me-1 text-ct"></i>Roxas City Shop</span>
                      <div class="fw-semibold small text-dark mb-1">Local Store Warranty</div>
                      <p class="text-muted text-xs mb-3">Every pre-owned iPhone is physically tested and battery-checked. Backed by our 7-day replacement and 30-day service warranty in Roxas City.</p>
                      <a href="catalog.php?q=iPhone" class="small fw-semibold text-ct text-decoration-none">
                        Browse all Apple listings &rarr;
                      </a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </li>

          <!-- Android Dropdown -->
          <li class="nav-item dropdown has-nav-tray">
            <a class="nav-link dropdown-toggle" href="catalog.php?cat=android" id="androidDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              Android
            </a>
            <div class="dropdown-menu nav-tray shadow-sm" aria-labelledby="androidDropdown">
              <div class="container">
                <div class="row g-4 align-items-start">
                  <div class="col-12 col-lg-5">
                    <span class="nav-tray-heading">Explore Android</span>
                    <div class="d-flex flex-column gap-2">
                      <a class="nav-tray-item" href="catalog.php?cat=android&q=Samsung">
                        <i class="bi bi-phone text-primary"></i>
                        <div>
                          <div class="nav-tray-item-title">Samsung</div>
                          <span class="nav-tray-item-desc">Galaxy series &amp; 5G smartphones</span>
                        </div>
                      </a>
                      <a class="nav-tray-item" href="catalog.php?cat=android&q=Vivo">
                        <i class="bi bi-phone text-primary"></i>
                        <div>
                          <div class="nav-tray-item-title">Vivo</div>
                          <span class="nav-tray-item-desc">Budget &amp; everyday mid-range phones</span>
                        </div>
                      </a>
                      <a class="nav-tray-item" href="catalog.php?cat=android&q=Tecno">
                        <i class="bi bi-phone text-primary"></i>
                        <div>
                          <div class="nav-tray-item-title">Tecno</div>
                          <span class="nav-tray-item-desc">Spark series &amp; high value phones</span>
                        </div>
                      </a>
                      <a class="nav-tray-item" href="catalog.php?cat=android&q=Honor">
                        <i class="bi bi-phone text-primary"></i>
                        <div>
                          <div class="nav-tray-item-title">Honor</div>
                          <span class="nav-tray-item-desc">Sleek styling &amp; durable builds</span>
                        </div>
                      </a>
                    </div>
                  </div>
                  <div class="col-12 col-lg-3 d-none d-lg-block border-start ps-lg-4">
                    <span class="nav-tray-heading">Popular Series</span>
                    <ul class="nav-tray-sublinks">
                      <li><a href="catalog.php?cat=android&q=Samsung">Samsung Galaxy A Series</a></li>
                      <li><a href="catalog.php?cat=android&q=Vivo">Vivo Y &amp; V Series</a></li>
                      <li><a href="catalog.php?cat=android&q=Tecno">Tecno Spark Series</a></li>
                      <li><a href="catalog.php?cat=android&q=Honor">Honor X Series</a></li>
                    </ul>
                  </div>
                  <div class="col-12 col-lg-4 d-none d-lg-block">
                    <div class="nav-tray-card">
                      <span class="badge bg-white text-dark border mb-2"><i class="bi bi-shield-check me-1 text-ct"></i>Tested &amp; Verified</span>
                      <div class="fw-semibold small text-dark mb-1">Affordable Everyday Units</div>
                      <p class="text-muted text-xs mb-3">Pre-owned and value Android devices checked for clean displays, reliable batteries, and fully working cameras.</p>
                      <a href="catalog.php?cat=android" class="small fw-semibold text-ct text-decoration-none">
                        Browse all Android devices &rarr;
                      </a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </li>

          <!-- Tablets Dropdown -->
          <li class="nav-item dropdown has-nav-tray">
            <a class="nav-link dropdown-toggle" href="catalog.php?cat=tablet" id="tabletsDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              Tablets
            </a>
            <div class="dropdown-menu nav-tray shadow-sm" aria-labelledby="tabletsDropdown">
              <div class="container">
                <div class="row g-4 align-items-start">
                  <div class="col-12 col-lg-5">
                    <span class="nav-tray-heading">Explore Tablets</span>
                    <div class="d-flex flex-column gap-2">
                      <a class="nav-tray-item" href="catalog.php?cat=tablet&q=iPad">
                        <i class="bi bi-tablet text-ct"></i>
                        <div>
                          <div class="nav-tray-item-title">iPads</div>
                          <span class="nav-tray-item-desc">iPad Air, Standard &amp; Pro units</span>
                        </div>
                      </a>
                      <a class="nav-tray-item" href="catalog.php?cat=tablet&q=Android">
                        <i class="bi bi-tablet-landscape text-ct"></i>
                        <div>
                          <div class="nav-tray-item-title">Android Tablets</div>
                          <span class="nav-tray-item-desc">Kids learning, streaming &amp; POS</span>
                        </div>
                      </a>
                    </div>
                  </div>
                  <div class="col-12 col-lg-3 d-none d-lg-block border-start ps-lg-4">
                    <span class="nav-tray-heading">Ideal For</span>
                    <ul class="nav-tray-sublinks">
                      <li><a href="catalog.php?cat=tablet&q=iPad">Online Class &amp; School</a></li>
                      <li><a href="catalog.php?cat=tablet">Streaming &amp; Media</a></li>
                      <li><a href="catalog.php?cat=tablet">Store POS &amp; Business</a></li>
                    </ul>
                  </div>
                  <div class="col-12 col-lg-4 d-none d-lg-block">
                    <div class="nav-tray-card">
                      <span class="badge bg-white text-dark border mb-2"><i class="bi bi-check2-circle me-1 text-ct"></i>Clean Accounts</span>
                      <div class="fw-semibold small text-dark mb-1">Ready for Setup</div>
                      <p class="text-muted text-xs mb-3">All iPads and tablets are factory reset with no locks or account bindings. In-store inspection welcomed before purchase.</p>
                      <a href="catalog.php?cat=tablet" class="small fw-semibold text-ct text-decoration-none">
                        Browse all tablets &rarr;
                      </a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </li>

          <li class="nav-item">
            <a class="nav-link <?= $activePage === 'about' ? 'active' : '' ?>" href="about.php">
              About
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link <?= $activePage === 'track-order' ? 'active' : '' ?>" href="track-order.php">
              Track Order
            </a>
          </li>
        </ul>

        <!-- Desktop Nav Icons (Apple-style Search, Bag, User) -->
        <div class="d-none d-lg-flex align-items-center gap-3 nav-icons">
          <a href="#" id="searchToggle" class="nav-search-btn" aria-label="Search">
            <i class="bi bi-search"></i>
            <span class="search-kbd d-none d-md-inline-flex">⌘K</span>
          </a>
          <a href="cart.php" class="position-relative nav-cart-btn" aria-label="Shopping cart">
            <i class="bi bi-bag"></i>
            <span class="cart-badge">0</span>
          </a>
          <?php if (!empty($_SESSION['user_id'])): ?>
            <div class="dropdown">
              <a href="profile.php" class="nav-user-btn dropdown-toggle text-decoration-none" id="navUserDropdown" data-bs-toggle="dropdown" aria-expanded="false" aria-label="Account">
                <i class="bi bi-person"></i>
              </a>
              <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0" aria-labelledby="navUserDropdown">
                <li><span class="dropdown-item-text text-muted small">Signed in as<br><strong class="text-dark"><?= htmlspecialchars($_SESSION['user_name'] ?? 'User') ?></strong></span></li>
                <li><hr class="dropdown-divider my-1"></li>
                <li><a class="dropdown-item py-1 small" href="profile.php"><i class="bi bi-person me-2"></i>My Profile &amp; Orders</a></li>
                <?php if (($_SESSION['user_role'] ?? '') === 'admin'): ?>
                  <li><a class="dropdown-item py-1 small" href="admin/dashboard.php"><i class="bi bi-speedometer2 me-2 text-ct"></i>Admin Dashboard</a></li>
                <?php endif; ?>
                <li><hr class="dropdown-divider my-1"></li>
                <li><a class="dropdown-item py-1 small text-danger" href="login.php?action=logout"><i class="bi bi-box-arrow-right me-2"></i>Log Out</a></li>
              </ul>
            </div>
          <?php else: ?>
            <a href="login.php" class="nav-user-btn" aria-label="Sign In" title="Sign In">
              <i class="bi bi-person"></i>
            </a>
          <?php endif; ?>
        </div>

        <!-- Mobile Drawer Account Section -->
        <div class="d-lg-none pt-3 mt-3 border-top mobile-nav-user">
          <?php if (!empty($_SESSION['user_id'])): ?>
            <div class="d-flex align-items-center justify-content-between mb-3 px-2">
              <div class="d-flex align-items-center gap-2">
                <i class="bi bi-person-circle fs-4 text-primary"></i>
                <div>
                  <span class="d-block small text-muted">Signed in as</span>
                  <strong class="d-block text-dark"><?= htmlspecialchars($_SESSION['user_name'] ?? 'User') ?></strong>
                </div>
              </div>
              <?php if (($_SESSION['user_role'] ?? '') === 'admin'): ?>
                <span class="badge bg-primary-subtle text-primary">Admin</span>
              <?php endif; ?>
            </div>
            <div class="d-grid gap-2">
              <a href="profile.php" class="btn btn-sm btn-outline-secondary text-start"><i class="bi bi-person me-2"></i>My Profile &amp; Orders</a>
              <?php if (($_SESSION['user_role'] ?? '') === 'admin'): ?>
                <a href="admin/dashboard.php" class="btn btn-sm btn-outline-primary text-start"><i class="bi bi-speedometer2 me-2"></i>Admin Dashboard</a>
              <?php endif; ?>
              <a href="login.php?action=logout" class="btn btn-sm btn-outline-danger text-start"><i class="bi bi-box-arrow-right me-2"></i>Log Out</a>
            </div>
          <?php else: ?>
            <div class="d-grid gap-2">
              <a href="login.php" class="btn btn-sm btn-outline-secondary"><i class="bi bi-box-arrow-in-right me-2"></i>Sign In</a>
              <a href="login.php#register" class="btn btn-sm btn-ct"><i class="bi bi-person-plus me-2"></i>Create Account</a>
            </div>
          <?php endif; ?>
        </div>

      </div>
    </div>
  </nav>
<?php endif; ?>
