<?php
$pageTitle       = 'My Cart | CheynTech';
$pageDescription = 'Review your cart and proceed to checkout — CheynTech Online Store';
$activePage      = '';
require 'includes/header.php';
?>

  <!-- BREADCRUMB -->
  <div class="breadcrumb-wrap">
    <div class="container">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.php">Home</a></li>
          <li class="breadcrumb-item active" aria-current="page">Cart</li>
        </ol>
      </nav>
    </div>
  </div>

  <!-- MAIN CONTENT -->
  <main class="cart-section">
    <div class="container">

      <h1 class="fw-800 mb-4">
        <i class="bi bi-cart3 me-2 cart-page-title-icon"></i>My Cart
      </h1>

      <!-- EMPTY STATE -->
      <div id="emptyCartState" class="empty-cart d-none">
        <div class="empty-icon">
          <i class="bi bi-cart-x"></i>
        </div>
        <h3>Your cart is empty</h3>
        <p>Looks like you haven't added any items yet.<br>Browse our gadgets and find your next favorite!</p>
        <a href="catalog.php" class="btn btn-ct px-4">
          <i class="bi bi-grid me-2"></i>Browse Products
        </a>
      </div>

      <!-- CART CONTENT -->
      <div id="cartContent" class="row g-4">

        <!-- LEFT: item list -->
        <div class="col-lg-8">
          <div id="cartItemList" class="d-flex flex-column gap-3"></div>
          <div class="mt-3">
            <a href="catalog.php" class="text-decoration-none fw-600">
              <i class="bi bi-arrow-left me-1"></i> Continue Shopping
            </a>
          </div>
        </div>

        <!-- RIGHT: Order Summary -->
        <div class="col-lg-4">
          <div class="summary-card">
            <div class="summary-title">
              <i class="bi bi-receipt me-2 cart-page-title-icon"></i>Order Summary
            </div>

            <div class="shipping-note">
              <i class="bi bi-info-circle-fill flex-shrink-0 mt-1"></i>
              <span>Shipping will be confirmed based on your fulfillment option (pickup or delivery) at checkout.</span>
            </div>

            <div class="summary-row">
              <span class="label">Subtotal (<span id="summaryItemCount">0</span> items)</span>
              <span class="value" id="summarySubtotal">&#8369;0</span>
            </div>
            <div class="summary-row">
              <span class="label">Shipping</span>
              <span class="value text-muted value-note">Calculated at checkout</span>
            </div>

            <div class="summary-total">
              <span>Total</span>
              <span class="value" id="summaryTotal">&#8369;0</span>
            </div>

            <a href="checkout.php" class="btn btn-ct w-100 mt-4 py-3 checkout-btn" id="checkoutBtn">
              <i class="bi bi-lock-fill me-2"></i>Proceed to Checkout
            </a>

            <p class="secure-note">
              <i class="bi bi-shield-check me-1"></i>Secure checkout &middot; Manual payment confirmation
            </p>
          </div>
        </div>

      </div><!-- /cartContent -->
    </div>
  </main>

<?php require 'includes/footer.php'; ?>
  <script src="assets/js/cart.js"></script>
</body>
</html>
