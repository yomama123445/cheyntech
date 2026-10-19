<?php
$pageTitle       = 'Contact Us | Cheyn Gadgets';
$pageDescription = 'Contact Cheyn Gadgets — send an inquiry about a listing or reach us at our Roxas City store.';
$activePage      = '';
require 'includes/header.php';
?>

  <!-- BREADCRUMB -->
  <div class="breadcrumb-wrap">
    <div class="container">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0">
          <li class="breadcrumb-item"><a href="index.php">Home</a></li>
          <li class="breadcrumb-item active" aria-current="page">Contact Us</li>
        </ol>
      </nav>
    </div>
  </div>

  <!-- PAGE HEADER -->
  <div class="page-header py-4 bg-white border-bottom">
    <div class="container">
      <span class="apple-section-tag mb-1">Get in Touch</span>
      <h1 class="h3 fw-semibold text-dark mb-1">Contact Us</h1>
      <p class="text-muted small mb-0">Have a question about a phone or want to visit our shop? We're happy to help.</p>
    </div>
  </div>

  <!-- MAIN -->
  <main class="py-5">
    <div class="container">
      <div class="row g-4 align-items-start">
        <!-- LEFT: Inquiry Form -->
        <div class="col-lg-7">
          <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5">
            <h2 class="h4 fw-bold mb-1">Ask About a Listing</h2>
            <p class="text-muted small mb-4">Fill in the form below and we'll get back to you as soon as possible.</p>

            <div class="alert alert-success d-none align-items-center gap-2 rounded-3" id="inquirySuccess" role="alert" aria-live="polite">
              <i class="bi bi-check-circle-fill flex-shrink-0"></i>
              <span>Your inquiry has been sent! We'll get back to you shortly.</span>
            </div>

            <form id="inquiryForm" novalidate>
              <div class="d-none" aria-hidden="true">
                <input type="text" name="website" id="contactWebsite" tabindex="-1" autocomplete="off">
              </div>
              <div class="mb-3">
                <label for="productName" class="form-label fw-semibold">Listing / Product Name</label>
                <input type="text" class="form-control" id="productName" name="productName" placeholder="e.g. iPhone 13 Pro 128GB Graphite" maxlength="150" required>
                <div class="invalid-feedback">Please enter the product name.</div>
              </div>
              <div class="mb-3">
                <label for="contactName" class="form-label fw-semibold">Your Name</label>
                <input type="text" class="form-control" id="contactName" name="contactName" placeholder="Juan dela Cruz" maxlength="100" required>
                <div class="invalid-feedback">Please enter your name.</div>
              </div>
              <div class="row g-3 mb-3">
                <div class="col-md-6">
                  <label for="contactEmail" class="form-label fw-semibold">Email Address</label>
                  <input type="email" class="form-control" id="contactEmail" name="contactEmail" placeholder="you@email.com" maxlength="150" required>
                  <div class="invalid-feedback">Please enter a valid email address.</div>
                </div>
                <div class="col-md-6">
                  <label for="contactPhone" class="form-label fw-semibold">Phone Number</label>
                  <input type="tel" class="form-control" id="contactPhone" name="contactPhone" placeholder="09XX-XXX-XXXX" maxlength="30">
                </div>
              </div>
              <div class="mb-4">
                <label for="contactMessage" class="form-label fw-semibold">Your Message</label>
                <textarea class="form-control" id="contactMessage" name="contactMessage" rows="5" placeholder="Ask about battery health, warranty, delivery to your area..." maxlength="2000" required></textarea>
                <div class="invalid-feedback">Please enter your message.</div>
              </div>
              <div class="d-grid">
                <button type="submit" class="btn btn-ct btn-lg">
                  <i class="bi bi-send me-2"></i>Send Inquiry
                </button>
              </div>
            </form>
          </div>
        </div>

        <!-- RIGHT: Contact Info Card -->
        <div class="col-lg-5">
          <div class="contact-info-card">
            <div class="contact-info-header">
              <h2 class="h5 fw-bold text-white mb-1"><i class="bi bi-shop me-2 text-ct"></i>Cheyn Gadgets</h2>
              <p class="text-white-50 small mb-0">Roxas City's trusted gadget store</p>
            </div>
            <div class="contact-info-body">
              <div class="contact-info-list mb-4">
                <div class="contact-info-item">
                  <span class="contact-icon-wrap contact-info-icon"><i class="bi bi-geo-alt-fill"></i></span>
                  <div>
                    <div class="contact-info-label">Store Location</div>
                    <div class="contact-info-value">Roxas Avenue, Roxas City, Capiz</div>
                  </div>
                </div>
                <div class="contact-info-item">
                  <span class="contact-icon-wrap contact-info-icon"><i class="bi bi-telephone-fill"></i></span>
                  <div>
                    <div class="contact-info-label">Store Hotline / SMS</div>
                    <div class="contact-info-value"><a href="tel:09178243968" class="text-dark text-decoration-none fw-600">0917-824-3968</a></div>
                  </div>
                </div>
                <div class="contact-info-item">
                  <span class="contact-icon-wrap contact-info-icon"><i class="bi bi-envelope-fill"></i></span>
                  <div>
                    <div class="contact-info-label">Email</div>
                    <div class="contact-info-value"><a href="mailto:hello@cheyntech.ph" class="text-dark text-decoration-none">hello@cheyntech.ph</a></div>
                  </div>
                </div>
                <div class="contact-info-item">
                  <span class="contact-icon-wrap contact-info-icon"><i class="bi bi-clock-fill"></i></span>
                  <div>
                    <div class="contact-info-label">Store Hours</div>
                    <div class="contact-info-value">
                      <div>Monday – Saturday</div>
                      <div class="fw-semibold">9:00 AM – 6:00 PM</div>
                    </div>
                  </div>
                </div>
              </div>
              <hr class="my-3">
              <div class="mb-4">
                <p class="contact-info-label mb-2">Follow Us</p>
                <div class="d-flex gap-2">
                  <a href="https://www.facebook.com/profile.php?id=61580936674089" target="_blank" rel="noopener noreferrer" class="btn btn-sm btn-outline-secondary rounded-circle d-flex align-items-center justify-content-center social-btn" aria-label="Facebook"><i class="bi bi-facebook"></i></a>
                  <a aria-disabled="true" tabindex="-1" title="Coming soon" class="btn btn-sm btn-outline-secondary rounded-circle d-flex align-items-center justify-content-center social-btn" aria-label="Instagram (coming soon)" style="opacity:.45;cursor:default;pointer-events:none;"><i class="bi bi-instagram"></i></a>
                  <a href="https://www.tiktok.com/@cheyniphonesandgadgets" target="_blank" rel="noopener noreferrer" class="btn btn-sm btn-outline-secondary rounded-circle d-flex align-items-center justify-content-center social-btn" aria-label="TikTok"><i class="bi bi-tiktok"></i></a>
                </div>
              </div>
              <!-- Google Maps Embed -->
              <iframe
                src="https://www.google.com/maps?q=Roxas+City,+Capiz,+Philippines&output=embed"
                width="100%"
                height="200"
                style="border:0;border-radius:12px;margin-top:1rem;"
                loading="lazy"
                referrerpolicy="no-referrer-when-downgrade"
                title="Cheyn Gadgets store location"
                allowfullscreen>
              </iframe>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>

<?php require 'includes/footer.php'; ?>
  <script src="<?= asset_url('assets/js/contact.js') ?>"></script>
</body>
</html>
