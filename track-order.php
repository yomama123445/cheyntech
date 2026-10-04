<?php
$pageTitle       = 'Track Your Order | Cheyn Gadgets Roxas City';
$pageDescription = 'Check the status of your phone order or in-store pickup — Cheyn Gadgets in Roxas City, Capiz.';
$activePage      = 'track-order';
require 'includes/header.php';
?>

  <!-- BREADCRUMB -->
  <div class="breadcrumb-wrap">
    <div class="container">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.php">Home</a></li>
          <li class="breadcrumb-item active" aria-current="page">Track Order</li>
        </ol>
      </nav>
    </div>
  </div>

  <!-- PAGE HEADER -->
  <div class="page-header py-4 bg-white border-bottom">
    <div class="container">
      <h1 class="h3 fw-semibold text-dark mb-1"><i class="bi bi-box-seam me-2"></i>Track Your Order</h1>
      <p class="text-muted small mb-0">Check the preparation status of your store pickup or local delivery.</p>
    </div>
  </div>

  <!-- MAIN -->
  <main class="track-section">
    <div class="container track-container">

      <!-- ── TOP: SEARCH FORM ── -->
      <div class="track-search-wrap mb-5">
        <div class="track-icon-badge"><i class="bi bi-box-seam"></i></div>
        <h2 class="h4 fw-700 mb-2">Order Lookup</h2>
        <p class="text-muted small mb-3">Check the status of your delivery or in-store pickup.</p>
        <form id="trackForm" novalidate>
          <div class="row g-2 mb-2">
            <div class="col-12 col-md-6">
              <input
                type="text"
                class="form-control"
                id="trackInput"
                placeholder="Order ID (e.g. CT-10493)"
                aria-label="Order ID"
                autocomplete="off"
                required
              >
            </div>
            <div class="col-12 col-md-6">
              <input
                type="email"
                class="form-control"
                id="trackEmail"
                placeholder="Checkout Email (e.g. name@email.com)"
                aria-label="Checkout Email"
                autocomplete="email"
                required
              >
            </div>
          </div>
          <button type="submit" class="btn btn-ct w-100 py-2">
            <i class="bi bi-search me-1"></i>Track Order
          </button>
          <div id="trackError" class="text-danger mt-2 text-start" style="display: none;">
            <i class="bi bi-exclamation-circle me-1"></i>Please enter both your Order ID (e.g. CT-10493) and checkout email.
          </div>
        </form>
      </div>

      <!-- ── NOT FOUND ALERT CARD ── -->
      <div id="trackNotFound" class="d-none" aria-live="polite">
        <div class="track-not-found-card">
          <div class="track-not-found-icon">
            <i class="bi bi-search"></i>
          </div>
          <h2 class="h4 fw-800 mb-2">Order Not Found</h2>
          <p class="text-muted mb-4">
            We couldn't find an order matching <strong id="notFoundOrderId" class="text-dark"></strong>. Please verify your Order ID and try again, or reach out to our team for assistance.
          </p>
          <div class="d-flex flex-wrap justify-content-center gap-3">
            <a href="contact.php" class="btn btn-ct px-4 py-2">
              <i class="bi bi-headset me-1"></i> Contact Support
            </a>
            <a href="catalog.php" class="btn btn-ct-outline px-4 py-2">
              <i class="bi bi-arrow-left me-1"></i> Return to Shop
            </a>
          </div>
        </div>
      </div>

      <!-- ── RESULT SECTION (hidden until search) ── -->
      <div id="trackResult" class="d-none" aria-live="polite">
        <div class="order-info-card">

          <!-- Print-Only Store Slip Header -->
          <div class="d-none d-print-block p-3 border-bottom mb-2 text-center">
            <h4 class="fw-800 text-dark mb-1">Cheyn's Gadgets</h4>
            <p class="text-muted text-xs mb-0">Roxas City, Capiz &bull; Official Customer Order Slip</p>
          </div>

          <!-- Header -->
          <div class="order-info-header">
            <div>
              <div class="order-info-id" id="resultOrderId">CT-10493</div>
              <div class="order-info-product">
                <i class="bi bi-phone me-1"></i>
                <span id="resultProduct">iPhone 13 Pro &ndash; 128GB &bull; Pickup at Cheyn Gadgets Store</span>
              </div>
              <div class="order-info-meta">
                <i class="bi bi-calendar3 me-1"></i>Placed on <span id="resultDate">August 12, 2026</span>
              </div>
            </div>
            <div class="d-flex flex-column align-items-end gap-2">
              <div class="order-info-badge result-status-badge">
                <i class="bi bi-bag-check me-1"></i>Ready for Pickup
              </div>
              <button type="button" class="btn btn-sm btn-outline-secondary d-print-none py-1 px-3 text-xs" onclick="window.print()" title="Print this slip for pickup verification">
                <i class="bi bi-printer me-1"></i> Print Slip
              </button>
            </div>
          </div>

          <!-- Body -->
          <div class="order-info-body">

            <!-- ── Payment Instructions Box (shown if pending and non-cash) ── -->
            <div id="trackPaymentNotice" class="d-none alert alert-light border p-3 mb-4 rounded-3">
              <div class="d-flex align-items-center justify-content-between mb-2">
                <strong class="text-dark"><i class="bi bi-wallet2 me-1 text-ct"></i> Pending Payment:</strong>
                <span id="trackPaymentBadge" class="badge bg-primary"></span>
              </div>
              <p class="text-xs mb-2 text-muted" id="trackPaymentText"></p>
              <div class="d-flex flex-wrap align-items-center justify-content-between p-2 rounded bg-white border">
                <div>
                  <span class="text-muted text-xs d-block" id="trackAccountLabel">Account Details</span>
                  <span class="fw-700 font-monospace text-dark" id="trackAccountVal"></span>
                </div>
                <button type="button" class="btn btn-sm btn-outline-secondary copy-btn" id="trackCopyBtn" title="Copy Number">
                  <i class="bi bi-clipboard"></i> Copy
                </button>
              </div>
            </div>

            <!-- ── Stepper ── -->
            <div class="mb-4">
              <div class="status-history-title">Order Progress</div>
              <div class="order-stepper" role="list" aria-label="Order status steps">

                <!-- Fill line (animated by initStepper in main.js) -->
                <div class="step-fill status-fill-bar"></div>

                <!-- Step 1: Pending (completed) -->
                <div class="step completed" role="listitem">
                  <div class="step-circle" aria-label="Completed"><i class="bi bi-check-lg"></i></div>
                  <div class="step-label">Pending</div>
                </div>

                <!-- Step 2: Processing (completed) -->
                <div class="step completed" role="listitem">
                  <div class="step-circle" aria-label="Completed"><i class="bi bi-gear-fill"></i></div>
                  <div class="step-label">Processing</div>
                </div>

                <!-- Step 3: Ready for Pickup (active) -->
                <div class="step active" role="listitem" aria-current="step">
                  <div class="step-circle" aria-label="Current step"><i class="bi bi-bag-check-fill"></i></div>
                  <div class="step-label">Ready for Pickup</div>
                </div>

                <!-- Step 4: Completed -->
                <div class="step" role="listitem">
                  <div class="step-circle" aria-label="Pending"><i class="bi bi-star-fill"></i></div>
                  <div class="step-label">Completed</div>
                </div>

              </div>
            </div>

            <!-- ── Status History ── -->
            <div class="status-history">
              <div class="status-history-title">Status History</div>

              <div class="status-history-item done">
                <div class="status-dot status-dot-done" aria-label="Completed"><i class="bi bi-check-lg"></i></div>
                <div class="history-info">
                  <div class="status-history-time">August 12, 2026 &bull; 10:14 AM</div>
                  <div class="status-history-label">Order Received</div>
                  <div class="status-history-note">Your order CT-10493 has been placed and is pending review by our team.</div>
                </div>
              </div>

              <div class="status-history-item done">
                <div class="status-dot status-dot-done" aria-label="Completed"><i class="bi bi-check-lg"></i></div>
                <div class="history-info">
                  <div class="status-history-time">August 12, 2026 &bull; 11:47 AM</div>
                  <div class="status-history-label">Order Confirmed &amp; Processing</div>
                  <div class="status-history-note">Payment verified. Your iPhone 13 Pro is being prepared and inspected by our technicians.</div>
                </div>
              </div>

              <div class="status-history-item current">
                <div class="status-dot status-dot-current" aria-label="Current"><i class="bi bi-bag-check-fill"></i></div>
                <div class="history-info">
                  <div class="status-history-time">August 13, 2026 &bull; 9:05 AM</div>
                  <div class="status-history-label">Ready for Pickup &#8212; <span class="track-action-link">Action Required</span></div>
                  <div class="status-history-note">
                    Your item is ready at <strong>Cheyn Gadgets, Roxas City</strong>.<br>
                    Visit us Mon&ndash;Sat, 9:00 AM&ndash;6:00 PM. Bring a valid ID and your Order ID.<br>
                    <span class="fw-600 track-action-link">Contact us via Facebook or email for pickup assistance.</span>
                  </div>
                </div>
              </div>

              <div class="status-history-item pending">
                <div class="status-dot status-dot-pending" aria-label="Pending"><i class="bi bi-clock"></i></div>
                <div class="history-info">
                  <div class="status-history-time">Pending</div>
                  <div class="status-history-label">Order Completed</div>
                  <div class="status-history-note">Item successfully handed over. We hope you enjoy your gadget!</div>
                </div>
              </div>

            </div>
            <!-- /status history -->

            <!-- ── Help strip ── -->
            <div class="help-strip">
              <p>
                <i class="bi bi-headset me-2 track-action-link"></i>
                Need help with your order? Our team is happy to assist.
              </p>
              <a href="contact.php" class="btn btn-ct-outline btn-ct-sm">
                <i class="bi bi-chat-dots me-1"></i>Contact Us
              </a>
            </div>

            <!-- Print-Only Claim Verification Footer -->
            <div class="d-none d-print-block mt-4 pt-3 border-top text-center text-xs text-muted">
              <p class="mb-1 fw-700 text-dark">Cheyn's Gadgets &bull; Roxas City Store</p>
              <p class="mb-0">Mon&ndash;Sat 9:00 AM &ndash; 6:00 PM &bull; Present this slip or your Order ID along with a valid ID upon pickup or delivery confirmation.</p>
            </div>

          </div><!-- /order-info-body -->
        </div><!-- /order-info-card -->
      </div><!-- /trackResult -->

      <!-- ── Info cards below search ── -->
      <div id="trackInfoCards" class="mt-5">
        <div class="row g-3 text-center">
          <div class="col-md-4">
            <div class="p-3 rounded-3 track-info-panel">
              <div class="track-info-icon"><i class="bi bi-clock-history"></i></div>
              <div class="fw-700 track-info-label">Real-Time Updates</div>
              <p class="mb-0 track-info-text">Order statuses updated by our team as your item progresses.</p>
            </div>
          </div>
          <div class="col-md-4">
            <div class="p-3 rounded-3 track-info-panel">
              <div class="track-info-icon"><i class="bi bi-check2-circle"></i></div>
              <div class="fw-700 track-info-label">Verified &amp; Inspected</div>
              <p class="mb-0 track-info-text">Every unit is inspected before being released to you.</p>
            </div>
          </div>
          <div class="col-md-4">
            <div class="p-3 rounded-3 track-info-panel">
              <div class="track-info-icon"><i class="bi bi-headset"></i></div>
              <div class="fw-700 track-info-label">Dedicated Support</div>
              <p class="mb-0 track-info-text">Questions? Message us on Facebook or call our store directly.</p>
            </div>
          </div>
        </div>
      </div>

    </div><!-- /container -->
  </main>

<?php require 'includes/footer.php'; ?>
  <script src="<?= asset_url('assets/js/track-order.js') ?>"></script>
</body>
</html>
