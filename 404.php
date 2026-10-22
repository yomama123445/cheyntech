<?php
require_once __DIR__ . '/includes/session.php';

http_response_code(404);

$pageTitle       = 'Page Not Found (404) | Cheyn Gadgets';
$pageDescription = 'The page you requested could not be found. Browse our catalog of tested iPhones, Android smartphones, and tablets.';
$activePage      = '';

require 'includes/header.php';
?>

  <!-- 404 HERO -->
  <main class="py-5 my-md-5">
    <div class="container text-center py-5">
      <div class="mb-4">
        <span class="badge rounded-pill bg-light text-muted border px-3 py-2 small fw-semibold">Error 404</span>
      </div>
      <h1 class="display-4 fw-bold text-dark mb-3">Looking for something?</h1>
      <p class="lead text-muted mx-auto mb-4" style="max-width: 580px;">
        We couldn't find the page you're looking for. It may have been moved, renamed, or is temporarily unavailable.
      </p>

      <div class="d-flex flex-wrap justify-content-center gap-3 mb-5">
        <a href="index.php" class="btn btn-ct px-4 py-2">
          <i class="bi bi-house me-2"></i>Return to Home
        </a>
        <a href="catalog.php" class="btn btn-outline-secondary px-4 py-2">
          <i class="bi bi-grid me-2"></i>Browse Catalog
        </a>
        <a href="track-order.php" class="btn btn-outline-secondary px-4 py-2">
          <i class="bi bi-box-seam me-2"></i>Track an Order
        </a>
      </div>

      <!-- Quick Category Recommendations -->
      <div class="row g-3 justify-content-center text-start mx-auto" style="max-width: 760px;">
        <div class="col-sm-6 col-md-3">
          <a href="catalog.php?cat=preowned" class="card border-0 shadow-xs h-100 p-3 text-decoration-none bg-light rounded-4 text-center">
            <i class="bi bi-phone text-ct fs-3 mb-2"></i>
            <span class="fw-semibold text-dark small">Pre-owned iPhones</span>
          </a>
        </div>
        <div class="col-sm-6 col-md-3">
          <a href="catalog.php?cat=new" class="card border-0 shadow-xs h-100 p-3 text-decoration-none bg-light rounded-4 text-center">
            <i class="bi bi-phone-fill text-ct fs-3 mb-2"></i>
            <span class="fw-semibold text-dark small">New iPhones</span>
          </a>
        </div>
        <div class="col-sm-6 col-md-3">
          <a href="catalog.php?cat=android" class="card border-0 shadow-xs h-100 p-3 text-decoration-none bg-light rounded-4 text-center">
            <i class="bi bi-robot text-ct fs-3 mb-2"></i>
            <span class="fw-semibold text-dark small">Android Phones</span>
          </a>
        </div>
        <div class="col-sm-6 col-md-3">
          <a href="catalog.php?cat=tablet" class="card border-0 shadow-xs h-100 p-3 text-decoration-none bg-light rounded-4 text-center">
            <i class="bi bi-tablet text-ct fs-3 mb-2"></i>
            <span class="fw-semibold text-dark small">Tablets &amp; iPads</span>
          </a>
        </div>
      </div>

    </div>
  </main>

<?php require 'includes/footer.php'; ?>
