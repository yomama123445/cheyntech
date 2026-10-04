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
          <!-- Home Dropdown -->
          <li class="nav-item dropdown has-nav-tray">
            <a class="nav-link dropdown-toggle <?= $activePage === 'home' ? 'active' : '' ?>" href="index.php" id="homeDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              Home
            </a>
            <div class="dropdown-menu nav-tray shadow-sm" aria-labelledby="homeDropdown">
              <div class="container">
                <div class="row g-4 ps-lg-4">
                  <div class="col-12 col-lg-4 nav-tray-col">
                    <span class="nav-tray-label">Explore Store</span>
                    <a href="index.php" class="nav-tray-link-lg">Store Overview</a>
                    <a href="catalog.php" class="nav-tray-link-lg">All Phone Listings</a>
                    <a href="catalog.php?cat=preowned" class="nav-tray-link-lg">Pre-owned Gadgets</a>
                    <a href="about.php" class="nav-tray-link-lg">Why Cheyn Gadgets</a>
                  </div>
                  <div class="col-12 col-lg-4 d-none d-lg-block nav-tray-col">
                    <span class="nav-tray-label">Shop by Category</span>
                    <ul class="nav-tray-links">
                      <li><a href="catalog.php?cat=preowned">Pre-owned iPhones</a></li>
                      <li><a href="catalog.php?cat=new">Brand New Factory Sealed</a></li>
                      <li><a href="catalog.php?cat=android">Android Phones (Samsung &bull; Vivo &bull; Tecno)</a></li>
                      <li><a href="catalog.php?cat=tablet">Tablets &amp; Apple iPads</a></li>
                      <li><a href="catalog.php?cat=wearable">Watches &amp; Accessories</a></li>
                    </ul>
                  </div>
                  <div class="col-12 col-lg-4 d-none d-lg-block nav-tray-col">
                    <span class="nav-tray-label">Local Services</span>
                    <ul class="nav-tray-links">
                      <li><a href="track-order.php">Track Order Status</a></li>
                      <li><a href="about.php">Store Location &amp; Hours (Roxas City)</a></li>
                      <li><a href="about.php#warranty">7-Day Replacement &amp; Service Warranty</a></li>
                      <li><a href="contact.php">Ask About a Specific Model</a></li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
          </li>

          <!-- Apple Dropdown -->
          <li class="nav-item dropdown has-nav-tray">
            <a class="nav-link dropdown-toggle" href="catalog.php?cat=preowned" id="appleDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              Apple
            </a>
            <div class="dropdown-menu nav-tray shadow-sm" aria-labelledby="appleDropdown">
              <div class="container">
                <div class="row g-4 ps-lg-4">
                  <div class="col-12 col-lg-4 nav-tray-col">
                    <span class="nav-tray-label">Explore Apple</span>
                    <a href="catalog.php?cat=preowned" class="nav-tray-link-lg">Pre-owned iPhones</a>
                    <a href="catalog.php?cat=new" class="nav-tray-link-lg">Brand New iPhones</a>
                    <a href="catalog.php?cat=wearable" class="nav-tray-link-lg">Apple Watch &amp; AirPods</a>
                    <a href="catalog.php?q=iPhone" class="nav-tray-link-lg">All Apple Listings</a>
                  </div>
                  <div class="col-12 col-lg-4 d-none d-lg-block nav-tray-col">
                    <span class="nav-tray-label">Popular in Store</span>
                    <ul class="nav-tray-links">
                      <li><a href="catalog.php?q=iPhone+11">iPhone 11 Series</a></li>
                      <li><a href="catalog.php?q=iPhone+12">iPhone 12 / 12 Pro</a></li>
                      <li><a href="catalog.php?q=iPhone+13">iPhone 13 / 13 Pro</a></li>
                      <li><a href="catalog.php?q=iPhone+14">iPhone 14 / 14 Pro Max</a></li>
                      <li><a href="catalog.php?q=iPhone+15">iPhone 15 Series</a></li>
                    </ul>
                  </div>
                  <div class="col-12 col-lg-4 d-none d-lg-block nav-tray-col">
                    <span class="nav-tray-label">Store Standards</span>
                    <ul class="nav-tray-links">
                      <li><a href="catalog.php?cat=preowned">Battery Health Tested</a></li>
                      <li><a href="catalog.php?cat=preowned">Grade A Condition Units</a></li>
                      <li><a href="about.php#warranty">7-Day Replacement Warranty</a></li>
                      <li><a href="about.php#warranty">30-Day Service Warranty</a></li>
                      <li><a href="about.php">In-Store Inspection &amp; Pickup</a></li>
                    </ul>
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
                <div class="row g-4 ps-lg-4">
                  <div class="col-12 col-lg-4 nav-tray-col">
                    <span class="nav-tray-label">Explore Android</span>
                    <a href="catalog.php?cat=android&q=Samsung" class="nav-tray-link-lg">Samsung Galaxy</a>
                    <a href="catalog.php?cat=android&q=Vivo" class="nav-tray-link-lg">Vivo</a>
                    <a href="catalog.php?cat=android&q=Tecno" class="nav-tray-link-lg">Tecno</a>
                    <a href="catalog.php?cat=android&q=Honor" class="nav-tray-link-lg">Honor</a>
                    <a href="catalog.php?cat=android" class="nav-tray-link-lg">All Android Devices</a>
                  </div>
                  <div class="col-12 col-lg-4 d-none d-lg-block nav-tray-col">
                    <span class="nav-tray-label">Popular Series</span>
                    <ul class="nav-tray-links">
                      <li><a href="catalog.php?cat=android&q=Samsung">Galaxy A Series 5G</a></li>
                      <li><a href="catalog.php?cat=android&q=Vivo">Vivo Y &amp; V Series</a></li>
                      <li><a href="catalog.php?cat=android&q=Tecno">Tecno Spark Series</a></li>
                      <li><a href="catalog.php?cat=android&q=Honor">Honor X Series</a></li>
                    </ul>
                  </div>
                  <div class="col-12 col-lg-4 d-none d-lg-block nav-tray-col">
                    <span class="nav-tray-label">Store Standards</span>
                    <ul class="nav-tray-links">
                      <li><a href="catalog.php?cat=android">Display &amp; Hardware Checked</a></li>
                      <li><a href="catalog.php?cat=android">Clean Battery Cycles</a></li>
                      <li><a href="about.php#warranty">Local Capiz Warranty</a></li>
                      <li><a href="catalog.php?cat=android">In-Store Pickup Available</a></li>
                    </ul>
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
                <div class="row g-4 ps-lg-4">
                  <div class="col-12 col-lg-4 nav-tray-col">
                    <span class="nav-tray-label">Explore Tablets</span>
                    <a href="catalog.php?cat=tablet&q=iPad" class="nav-tray-link-lg">Apple iPads</a>
                    <a href="catalog.php?cat=tablet&q=Android" class="nav-tray-link-lg">Android Tablets</a>
                    <a href="catalog.php?cat=tablet" class="nav-tray-link-lg">All Tablet Listings</a>
                  </div>
                  <div class="col-12 col-lg-4 d-none d-lg-block nav-tray-col">
                    <span class="nav-tray-label">Ideal For</span>
                    <ul class="nav-tray-links">
                      <li><a href="catalog.php?cat=tablet&q=iPad">Online Class &amp; School</a></li>
                      <li><a href="catalog.php?cat=tablet">Streaming &amp; Entertainment</a></li>
                      <li><a href="catalog.php?cat=tablet">Store POS &amp; Business</a></li>
                    </ul>
                  </div>
                  <div class="col-12 col-lg-4 d-none d-lg-block nav-tray-col">
                    <span class="nav-tray-label">Store Standards</span>
                    <ul class="nav-tray-links">
                      <li><a href="catalog.php?cat=tablet">Clean iCloud / Google Accounts</a></li>
                      <li><a href="catalog.php?cat=tablet">Battery Tested for Daily Use</a></li>
                      <li><a href="catalog.php?cat=tablet">Charger Cable Included</a></li>
                      <li><a href="about.php">In-Store Testing Welcomed</a></li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
          </li>

          <!-- About Dropdown -->
          <li class="nav-item dropdown has-nav-tray">
            <a class="nav-link dropdown-toggle <?= $activePage === 'about' ? 'active' : '' ?>" href="about.php" id="aboutDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              About
            </a>
            <div class="dropdown-menu nav-tray shadow-sm" aria-labelledby="aboutDropdown">
              <div class="container">
                <div class="row g-4 ps-lg-4">
                  <div class="col-12 col-lg-4 nav-tray-col">
                    <span class="nav-tray-label">About Cheyn Gadgets</span>
                    <a href="about.php" class="nav-tray-link-lg">Our Story &amp; Shop</a>
                    <a href="about.php#warranty" class="nav-tray-link-lg">Local Warranty Policy</a>
                    <a href="about.php#location" class="nav-tray-link-lg">Store Location &amp; Hours</a>
                  </div>
                  <div class="col-12 col-lg-4 d-none d-lg-block nav-tray-col">
                    <span class="nav-tray-label">How We Work</span>
                    <ul class="nav-tray-links">
                      <li><a href="about.php">In-Store Pickup Guide</a></li>
                      <li><a href="about.php">Local Delivery in Roxas City</a></li>
                      <li><a href="about.php">Device Inspection Standards</a></li>
                      <li><a href="contact.php">Ask a Question</a></li>
                    </ul>
                  </div>
                  <div class="col-12 col-lg-4 d-none d-lg-block nav-tray-col">
                    <span class="nav-tray-label">Get in Touch</span>
                    <ul class="nav-tray-links">
                      <li><a href="contact.php">Customer Contact Form</a></li>
                      <li><a href="contact.php">Inquire on a Specific Model</a></li>
                      <li><a href="https://facebook.com" target="_blank" rel="noopener">Official Facebook Page &rarr;</a></li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
          </li>

          <!-- Track Order Dropdown -->
          <li class="nav-item dropdown has-nav-tray">
            <a class="nav-link dropdown-toggle <?= $activePage === 'track-order' ? 'active' : '' ?>" href="track-order.php" id="trackDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              Track Order
            </a>
            <div class="dropdown-menu nav-tray shadow-sm" aria-labelledby="trackDropdown">
              <div class="container">
                <div class="row g-4 ps-lg-4">
                  <div class="col-12 col-lg-4 nav-tray-col">
                    <span class="nav-tray-label">Order Status</span>
                    <a href="track-order.php" class="nav-tray-link-lg">Track an Order</a>
                    <a href="track-order.php" class="nav-tray-link-lg">Pickup Claim Slip</a>
                    <a href="contact.php" class="nav-tray-link-lg">Order Support Inquiry</a>
                  </div>
                  <div class="col-12 col-lg-4 d-none d-lg-block nav-tray-col">
                    <span class="nav-tray-label">Payments</span>
                    <ul class="nav-tray-links">
                      <li><a href="track-order.php">GCash Account Transfer</a></li>
                      <li><a href="track-order.php">BDO Bank Deposit</a></li>
                      <li><a href="track-order.php">Cash on In-Store Pickup</a></li>
                    </ul>
                  </div>
                  <div class="col-12 col-lg-4 d-none d-lg-block nav-tray-col">
                    <span class="nav-tray-label">Pickup &amp; Delivery</span>
                    <ul class="nav-tray-links">
                      <li><a href="track-order.php">Ready for Pickup Status</a></li>
                      <li><a href="track-order.php">Store Claim Verification</a></li>
                      <li><a href="contact.php">Need Help? Message Us</a></li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
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
  <!-- Full-screen backdrop blur overlay (Apple-style) -->
  <div class="nav-backdrop" id="navBackdrop" aria-hidden="true"></div>
<?php endif; ?>
