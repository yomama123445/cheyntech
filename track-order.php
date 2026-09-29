<?php
$pageTitle       = 'Track Order | CheynTech';
$pageDescription = 'Track your CheynTech order in real time';
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

  <!-- MAIN -->
  <main class="track-section">
    <div class="container track-container">

      <!-- ── TOP: SEARCH FORM ── -->
      <div class="track-search-wrap mb-5">
        <div class="track-emoji">&#128269;</div>
        <h2>Track Your Order</h2>
        <p>Enter your Order ID to see real-time status updates on your CheynTech purchase.</p>
        <form id="trackForm" novalidate>
          <div class="track-input-group d-flex">
            <input
              type="text"
              class="form-control"
              id="trackInput"
              placeholder="e.g. CT-10493"
              aria-label="Order ID"
              autocomplete="off"
              required
            >
            <button type="submit" class="btn btn-ct">
              <i class="bi bi-search me-1"></i>Track
            </button>
          </div>
          <div id="trackError" class="text-danger mt-2">
            <i class="bi bi-exclamation-circle me-1"></i>Please enter a valid Order ID (e.g. CT-10493).
          </div>
        </form>
      </div>

      <!-- ── RESULT SECTION (hidden until search) ── -->
      <div id="trackResult" class="d-none" aria-live="polite">
        <div class="order-result-card">

          <!-- Header -->
          <div class="result-header">
            <div>
              <div class="result-order-id" id="resultOrderId">CT-10493</div>
              <div class="result-product">
                <i class="bi bi-phone me-1"></i>
                <span id="resultProduct">iPhone 13 Pro &ndash; 128GB &bull; Pickup at CheynTech Store</span>
              </div>
              <div class="result-meta">
                <i class="bi bi-calendar3 me-1"></i>Placed on <span id="resultDate">August 12, 2026</span>
              </div>
            </div>
            <div class="result-status-badge">
              <i class="bi bi-bag-check me-1"></i>Ready for Pickup
            </div>
          </div>

          <!-- Body -->
          <div class="result-body">

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

              <div class="history-item done">
                <div class="history-dot" aria-label="Completed"><i class="bi bi-check-lg"></i></div>
                <div class="history-info">
                  <div class="hist-time">August 12, 2026 &bull; 10:14 AM</div>
                  <div class="hist-msg">Order Received</div>
                  <div class="hist-sub">Your order CT-10493 has been placed and is pending review by our team.</div>
                </div>
              </div>

              <div class="history-item done">
                <div class="history-dot" aria-label="Completed"><i class="bi bi-check-lg"></i></div>
                <div class="history-info">
                  <div class="hist-time">August 12, 2026 &bull; 11:47 AM</div>
                  <div class="hist-msg">Order Confirmed &amp; Processing</div>
                  <div class="hist-sub">Payment verified. Your iPhone 13 Pro is being prepared and inspected by our technicians.</div>
                </div>
              </div>

              <div class="history-item current">
                <div class="history-dot" aria-label="Current"><i class="bi bi-bag-check-fill"></i></div>
                <div class="history-info">
                  <div class="hist-time">August 13, 2026 &bull; 9:05 AM</div>
                  <div class="hist-msg">Ready for Pickup &#8212; <span class="track-action-link">Action Required</span></div>
                  <div class="hist-sub">
                    Your item is ready at <strong>Cheyn's Gadgets, Roxas City</strong>.<br>
                    Visit us Mon&ndash;Sat, 9:00 AM&ndash;6:00 PM. Bring a valid ID and your Order ID.<br>
                    <a href="tel:+639171234567" class="fw-600 track-action-link">
                      <i class="bi bi-telephone-fill me-1"></i>0917-123-4567
                    </a>
                  </div>
                </div>
              </div>

              <div class="history-item">
                <div class="history-dot" aria-label="Pending"><i class="bi bi-star"></i></div>
                <div class="history-info">
                  <div class="hist-time">Pending</div>
                  <div class="hist-msg hist-msg-note">Order Completed</div>
                  <div class="hist-sub">Item successfully handed over. We hope you enjoy your gadget!</div>
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

          </div><!-- /result-body -->
        </div><!-- /order-result-card -->
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
              <div class="track-info-icon"><i class="bi bi-shield-check"></i></div>
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
  <script src="assets/js/track-order.js"></script>
</body>
</html>
