<?php
require_once __DIR__ . '/includes/session.php';

if (empty($_SESSION['user_id'])) {
    header('Location: login.php?redirect=checkout.php');
    exit;
}

$pageTitle       = 'Order Checkout | Cheyn Gadgets Roxas City';
$pageDescription = 'Complete your gadget order — Cheyn Gadgets in Roxas City, Capiz.';
$activePage      = '';
require 'includes/header.php';
?>

  <!-- BREADCRUMB -->
  <div class="breadcrumb-wrap">
    <div class="container">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.php">Home</a></li>
          <li class="breadcrumb-item"><a href="cart.php">Bag</a></li>
          <li class="breadcrumb-item active" aria-current="page">Checkout</li>
        </ol>
      </nav>
    </div>
  </div>

  <!-- PAGE HEADER -->
  <div class="page-header py-4 bg-white border-bottom">
    <div class="container">
      <h1 class="h3 fw-semibold text-dark mb-1"><i class="bi bi-bag-check me-2"></i>Checkout</h1>
      <p class="text-muted small mb-0">Provide your contact info and choose store pickup or local delivery.</p>
    </div>
  </div>

  <!-- MAIN -->
  <main class="checkout-section">
    <div class="container">

      <div class="row g-4 align-items-start">

        <!-- ═══ LEFT: FORM ═══ -->
        <div class="col-lg-7">
          <form id="checkoutForm" novalidate>

            <!-- ── Section 1: Contact Info ── -->
            <div class="mb-4">
              <div class="form-section-heading">
                <i class="bi bi-person-lines-fill me-2"></i>Contact Information
              </div>
              <div class="row g-3">
                <div class="col-12">
                  <label for="fullName" class="form-label fw-600">Full Name <span class="text-danger">*</span></label>
                  <input type="text" class="form-control" id="fullName" name="fullName" value="<?= htmlspecialchars($_SESSION['user_name'] ?? '') ?>" placeholder="e.g. Maria Santos" required autocomplete="name">
                  <div class="invalid-feedback">Please enter your full name.</div>
                </div>
                <div class="col-md-6">
                  <label for="email" class="form-label fw-600">Email Address <span class="text-danger">*</span></label>
                  <input type="email" class="form-control" id="email" name="email" value="<?= htmlspecialchars($_SESSION['user_email'] ?? '') ?>" placeholder="you@email.com" required autocomplete="email">
                  <div class="invalid-feedback">Please enter a valid email address.</div>
                </div>
                <div class="col-md-6">
                  <label for="phone" class="form-label fw-600">Phone Number <span class="text-danger">*</span></label>
                  <div class="input-group">
                    <span class="input-group-text fw-semibold text-muted">+63</span>
                    <input type="tel" class="form-control" id="phone" name="phone" value="<?= htmlspecialchars($_SESSION['user_phone'] ?? '') ?>" placeholder="09XX XXX XXXX" required autocomplete="tel" pattern="^(09|\+639)\d{9}$">
                  </div>
                  <div class="invalid-feedback">Enter a valid PH mobile number (e.g. 09171234567).</div>
                </div>
              </div>
            </div>

            <!-- ── Section 2: Fulfillment Method ── -->
            <div class="mb-4">
              <div class="form-section-heading">
                <i class="bi bi-truck me-2"></i>Fulfillment Method
              </div>

              <div class="d-flex flex-column gap-3" role="radiogroup" aria-label="Fulfillment method">

                <!-- Pickup -->
                <label class="radio-card" id="cardPickup">
                  <input class="form-check-input mt-0" type="radio" name="fulfillment" id="fulfillPickup" value="pickup" checked>
                  <div class="radio-icon"><i class="bi bi-shop"></i></div>
                  <div>
                    <div class="radio-label">Pickup at Cheyn Gadgets Store</div>
                    <div class="radio-sub">
                      <i class="bi bi-geo-alt me-1"></i>Cheyn Gadgets, Roxas City<br>
                      Mon&ndash;Sat &bull; 9:00 AM &ndash; 6:00 PM &bull; <span class="fw-600 text-success">Free</span>
                    </div>
                  </div>
                </label>

                <!-- Delivery -->
                <label class="radio-card" id="cardDelivery">
                  <input class="form-check-input mt-0" type="radio" name="fulfillment" id="fulfillDelivery" value="delivery">
                  <div class="radio-icon"><i class="bi bi-truck"></i></div>
                  <div class="w-100">
                    <div class="radio-label">Local Delivery</div>
                    <div class="radio-sub">Delivery within Roxas City &amp; nearby areas &bull; Fee confirmed after order review</div>

                    <!-- Delivery address fields (shown when delivery selected) -->
                    <div id="deliveryAddressFields" class="delivery-address-wrapper d-none">
                      <div class="row g-2">
                        <div class="col-12">
                          <input type="text" class="form-control form-control-sm" id="addrStreet" name="addrStreet" placeholder="House No. / Street / Subdivision">
                        </div>
                        <div class="col-md-6">
                          <input type="text" class="form-control form-control-sm" id="addrBarangay" name="addrBarangay" placeholder="Barangay">
                        </div>
                        <div class="col-md-6">
                          <input type="text" class="form-control form-control-sm" id="addrCity" name="addrCity" placeholder="City / Municipality">
                        </div>
                        <div class="col-md-6">
                          <input type="text" class="form-control form-control-sm" id="addrProvince" name="addrProvince" placeholder="Province">
                        </div>
                        <div class="col-12">
                          <textarea class="form-control form-control-sm" id="addrNotes" name="addrNotes" rows="2" placeholder="Delivery notes (landmark, gate code, etc.)"></textarea>
                        </div>
                      </div>
                    </div>
                  </div>
                </label>

              </div>
            </div>

            <!-- ── Section 3: Payment Method ── -->
            <div class="mb-4">
              <div class="form-section-heading">
                <i class="bi bi-credit-card-2-front me-2"></i>Payment Method
              </div>

              <div class="d-flex flex-column gap-3" role="radiogroup" aria-label="Payment method">

                <!-- Cash -->
                <label class="radio-card" id="cardCash">
                  <input class="form-check-input mt-0" type="radio" name="payment" id="paymentCash" value="cash" checked>
                  <div class="radio-icon"><i class="bi bi-cash-stack"></i></div>
                  <div>
                    <div class="radio-label">Cash on Pickup / Delivery</div>
                    <div class="radio-sub">Pay in cash when you pick up or receive your order. No upfront payment required.</div>
                  </div>
                </label>

                <!-- GCash -->
                <label class="radio-card" id="cardGcash">
                  <input class="form-check-input mt-0" type="radio" name="payment" id="paymentGcash" value="gcash">
                  <div class="radio-icon"><i class="bi bi-phone-fill"></i></div>
                  <div class="w-100">
                    <div class="radio-label">GCash</div>
                    <div class="radio-sub">Send payment via GCash and present proof upon pickup or via message.</div>
                    <div id="gcashInfo" class="payment-info-box mt-2">
                      <div class="d-flex flex-wrap align-items-center justify-content-between p-2 rounded bg-white border mb-2">
                        <div>
                          <span class="text-muted text-xs d-block">Account Name</span>
                          <strong class="text-dark">Cheyn's Gadgets</strong>
                        </div>
                        <div class="text-end">
                          <span class="text-muted text-xs d-block">GCash Number</span>
                          <span class="font-monospace fw-700 text-dark">0917-824-3968</span>
                          <button type="button" class="btn btn-sm btn-outline-secondary py-0 px-2 ms-1 copy-btn" data-copy="09178243968" title="Copy Number">
                            <i class="bi bi-clipboard"></i> Copy
                          </button>
                        </div>
                      </div>
                      <div class="text-muted text-xs">
                        <i class="bi bi-info-circle me-1 text-ct"></i> Include your <strong>Order ID</strong> in the message field when sending payment.
                      </div>
                    </div>
                  </div>
                </label>

                <!-- Bank Transfer -->
                <label class="radio-card" id="cardBank">
                  <input class="form-check-input mt-0" type="radio" name="payment" id="paymentBank" value="bank">
                  <div class="radio-icon"><i class="bi bi-bank"></i></div>
                  <div class="w-100">
                    <div class="radio-label">Bank Transfer (BDO / BPI)</div>
                    <div class="radio-sub">Transfer directly to our store bank account and present deposit confirmation.</div>
                    <div id="bankInfo" class="payment-info-box mt-2">
                      <div class="d-flex flex-wrap align-items-center justify-content-between p-2 rounded bg-white border mb-2">
                        <div>
                          <span class="text-muted text-xs d-block">Bank &amp; Account Name</span>
                          <strong class="text-dark">BDO &bull; Cheyn's Gadgets</strong>
                        </div>
                        <div class="text-end">
                          <span class="text-muted text-xs d-block">Account Number</span>
                          <span class="font-monospace fw-700 text-dark">0012-3456-7890</span>
                          <button type="button" class="btn btn-sm btn-outline-secondary py-0 px-2 ms-1 copy-btn" data-copy="001234567890" title="Copy Number">
                            <i class="bi bi-clipboard"></i> Copy
                          </button>
                        </div>
                      </div>
                      <div class="text-muted text-xs">
                        <i class="bi bi-info-circle me-1 text-ct"></i> Put your <strong>Order ID</strong> in the reference / remarks field for faster verification.
                      </div>
                    </div>
                  </div>
                </label>

              </div>
            </div>

            <!-- ── Submit ── -->
            <div class="d-grid mt-4">
              <button type="submit" class="btn btn-ct py-3 submit-btn-lg">
                <i class="bi bi-check2-circle me-2"></i>Place Order
              </button>
              <p class="text-center mt-2 secure-form-note">
                By placing your order, you agree to our <a href="about.php" target="_blank" rel="noopener noreferrer">Terms &amp; Conditions</a>. Orders are subject to manual review.
              </p>
            </div>

          </form>
        </div>

        <!-- ═══ RIGHT: Order Summary ═══ -->
        <div class="col-lg-5">
          <div class="order-summary-card">
            <div class="summary-title">
              <i class="bi bi-bag me-2 checkout-page-icon"></i>Your Order
            </div>

            <!-- Cart items rendered by JS -->
            <div id="checkoutItemList"></div>

            <hr class="summary-divider">

            <div class="summary-row">
              <span class="label">Subtotal</span>
              <span class="value" id="coSubtotal">&#8369;0</span>
            </div>
            <div class="summary-row">
              <span class="label">Delivery Fee</span>
              <span class="value checkout-page-icon" id="coDeliveryFee">Free</span>
            </div>

            <div class="summary-grand">
              <span>Total</span>
              <span class="value" id="coTotal">&#8369;0</span>
            </div>

            <!-- Trust notes -->
            <div class="d-flex align-items-center justify-content-center gap-3 pt-3 text-muted" style="font-size: 0.75rem; border-top: 1px solid #f1f5f9;">
              <span><i class="bi bi-lock me-1"></i>Manual verification</span>
              <span>&middot;</span>
              <span><i class="bi bi-arrow-repeat me-1"></i>7-day replacement</span>
            </div>
          </div>
        </div>

      </div><!-- /row -->
    </div>
  </main>

  <!-- ═══ ORDER CONFIRMATION MODAL ═══ -->
  <div class="modal fade" id="confirmationModal" tabindex="-1" role="dialog" aria-modal="true" aria-labelledby="confirmationModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
        <div class="modal-header border-0 text-white pb-0 modal-gradient-header">
          <div class="w-100 text-center pb-3">
            <div class="modal-check-badge"><i class="bi bi-check-circle-fill text-success fs-1"></i></div>
            <h4 class="fw-800 mb-1" id="confirmationModalLabel">Order Placed Successfully!</h4>
            <p class="mb-0">We've received your order. Our team will review and confirm it shortly.</p>
          </div>
        </div>
        <div class="modal-body p-4">
          <div class="text-center mb-4">
            <div class="modal-order-id" id="modalOrderId">CT-XXXXX</div>
            <div class="confirm-modal-note">Your Order ID &mdash; save this for tracking</div>
          </div>

          <div class="row g-3 mb-3">
            <div class="col-12">
              <div class="p-3 rounded-3 confirm-info-box">
                <div class="confirm-row"><span class="cl">Customer</span><span id="confirmName" class="fw-600"></span></div>
                <div class="confirm-row"><span class="cl">Email</span><span id="confirmEmail" class="fw-600"></span></div>
                <div class="confirm-row"><span class="cl">Phone</span><span id="confirmPhone" class="fw-600"></span></div>
                <div class="confirm-row"><span class="cl">Fulfillment</span><span id="confirmFulfillment" class="fw-600"></span></div>
                <div class="confirm-row"><span class="cl">Payment</span><span id="confirmPayment" class="fw-600"></span></div>
                <div class="confirm-row"><span class="cl">Total</span><span id="confirmTotal" class="fw-600 confirm-total-value"></span></div>
              </div>
            </div>
          </div>

          <!-- Payment instructions for GCash / Bank Transfer -->
          <div id="confirmPaymentInstructions" class="d-none alert alert-light border p-3 mb-3">
            <div class="d-flex align-items-center justify-content-between mb-2">
              <strong class="text-dark"><i class="bi bi-wallet2 me-1 text-ct"></i> Payment Instructions:</strong>
              <span id="confirmPaymentBadge" class="badge bg-secondary"></span>
            </div>
            <p class="text-xs mb-2" id="confirmPaymentText">Please send your manual payment to the store account below:</p>
            <div class="d-flex flex-wrap align-items-center justify-content-between p-2 rounded bg-white border">
              <div>
                <span class="text-muted text-xs d-block" id="confirmAccountLabel">Account Details</span>
                <span class="fw-700 font-monospace text-dark" id="confirmAccountVal"></span>
              </div>
              <button type="button" class="btn btn-sm btn-outline-secondary copy-btn" id="confirmCopyBtn" title="Copy Number">
                <i class="bi bi-clipboard"></i> Copy
              </button>
            </div>
          </div>

          <div class="alert d-flex align-items-center gap-2 mb-0">
            <i class="bi bi-info-circle-fill flex-shrink-0"></i>
            <span>You'll receive a confirmation message via SMS or email within <strong>1&ndash;2 hours</strong>. Our team manually reviews all orders.</span>
          </div>
        </div>
        <div class="modal-footer border-0 px-4 pb-4 gap-2 flex-nowrap">
          <a href="track-order.php" class="btn btn-ct flex-fill" id="trackOrderModalBtn" autofocus>
            <i class="bi bi-search me-1"></i>Track My Order
          </a>
          <a href="catalog.php" class="btn btn-ct-outline flex-fill">
            <i class="bi bi-grid me-1"></i>Continue Shopping
          </a>
        </div>
      </div>
    </div>
  </div>

<?php require 'includes/footer.php'; ?>
  <script src="<?= asset_url('assets/js/checkout.js') ?>"></script>
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      var modalEl = document.getElementById('confirmationModal');
      var trackBtn = document.getElementById('trackOrderModalBtn');
      if (modalEl && trackBtn) {
        modalEl.addEventListener('shown.bs.modal', function () {
          trackBtn.focus();
        });
      }
    });
  </script>
</body>
</html>
