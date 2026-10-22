<?php
require_once __DIR__ . '/includes/session.php';

$pageTitle       = 'Store Policies, Privacy & Warranty | Cheyn Gadgets';
$pageDescription = 'Customer policies, 7-day replacement warranty, data privacy statement, and delivery terms for Cheyn Gadgets Roxas City.';
$activePage      = 'policy';

require 'includes/header.php';
?>

  <!-- BREADCRUMB -->
  <div class="breadcrumb-wrap">
    <div class="container">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.php">Home</a></li>
          <li class="breadcrumb-item active" aria-current="page">Store Policies</li>
        </ol>
      </nav>
    </div>
  </div>

  <!-- HEADER -->
  <header class="page-header py-5 bg-white border-bottom">
    <div class="container">
      <span class="badge rounded-pill bg-light text-muted border px-3 py-1 mb-2 small fw-semibold">Cheyn Gadgets Standards</span>
      <h1 class="display-6 fw-bold text-dark mb-2">Store Policies &amp; Warranty</h1>
      <p class="text-muted lead mb-0" style="max-width: 650px;">
        Everything you need to know about our 7-day replacement warranty, testing process, data privacy, and pickup/delivery terms.
      </p>
    </div>
  </header>

  <!-- CONTENT -->
  <main class="py-5 bg-light">
    <div class="container">
      <div class="row g-4 justify-content-center">

        <div class="col-lg-8">

          <!-- 1. Warranty & 7-Day Replacement Policy -->
          <section class="card border-0 shadow-sm rounded-4 mb-4 p-4 p-md-5 bg-white" id="warranty">
            <div class="d-flex align-items-center gap-3 mb-3">
              <div class="rounded-circle bg-ct-subtle p-3 text-ct d-flex align-items-center justify-content-center" style="width:48px;height:48px;">
                <i class="bi bi-shield-check fs-4"></i>
              </div>
              <h2 class="h4 fw-bold mb-0">7-Day Replacement Warranty</h2>
            </div>
            <p class="text-muted">
              Every gadget sold at Cheyn Gadgets undergoes multi-point functional inspection. For peace of mind, all pre-owned, refurbished, and brand-new items include our standard replacement warranty:
            </p>
            <ul class="text-muted small mb-3 lh-lg">
              <li><strong>Coverage Window:</strong> 7 calendar days from the date of in-store pickup or receipt of local delivery.</li>
              <li><strong>What is Covered:</strong> Hardware functional defects (e.g., touchscreen failure, camera malfunction, speaker/mic defects, charging port issues) that were not present or disclosed at time of purchase.</li>
              <li><strong>Condition for Replacement:</strong> The device must be in the exact physical condition as when released, complete with any accessories and packaging provided.</li>
              <li><strong>Void Conditions:</strong> Warranty is void if the device exhibits physical impact damage, cracked glass, unauthorized opening/tampering, liquid contact, or software jailbreaking/custom firmware.</li>
            </ul>
          </section>

          <!-- 2. Data Privacy Policy -->
          <section class="card border-0 shadow-sm rounded-4 mb-4 p-4 p-md-5 bg-white" id="privacy">
            <div class="d-flex align-items-center gap-3 mb-3">
              <div class="rounded-circle bg-ct-subtle p-3 text-ct d-flex align-items-center justify-content-center" style="width:48px;height:48px;">
                <i class="bi bi-lock fs-4"></i>
              </div>
              <h2 class="h4 fw-bold mb-0">Privacy &amp; Data Protection</h2>
            </div>
            <p class="text-muted">
              In compliance with the Philippine Data Privacy Act of 2012 (Republic Act No. 10173), Cheyn Gadgets respects and protects customer personal information:
            </p>
            <ul class="text-muted small mb-0 lh-lg">
              <li><strong>Information We Collect:</strong> Your name, phone number, email address, delivery street address, and purchase order history.</li>
              <li><strong>Purpose of Use:</strong> Information is used exclusively to process orders, verify payments, coordinate pickup/local dispatch, and provide customer support.</li>
              <li><strong>Storage &amp; Security:</strong> Customer records are stored in secure, password-hashed databases with prepared statement protection. We never sell, rent, or trade customer information to third-party advertisers.</li>
              <li><strong>Account Rights:</strong> You may review and update your name and phone number at any time through your <a href="profile.php">Account Profile</a>.</li>
            </ul>
          </section>

          <!-- 3. Fulfillment & Pickup Terms -->
          <section class="card border-0 shadow-sm rounded-4 mb-4 p-4 p-md-5 bg-white" id="terms">
            <div class="d-flex align-items-center gap-3 mb-3">
              <div class="rounded-circle bg-ct-subtle p-3 text-ct d-flex align-items-center justify-content-center" style="width:48px;height:48px;">
                <i class="bi bi-box-seam fs-4"></i>
              </div>
              <h2 class="h4 fw-bold mb-0">Fulfillment &amp; Ordering Terms</h2>
            </div>
            <ul class="text-muted small mb-0 lh-lg">
              <li><strong>In-Store Pickup:</strong> Orders marked ready for pickup will be reserved at our Roxas City store for up to 3 business days. Customers are encouraged to test the device in-store before completing payment.</li>
              <li><strong>Local Staff Delivery:</strong> Coordinated locally within Roxas City and nearby Capiz areas. Our staff will contact you via SMS or phone call prior to dispatch.</li>
              <li><strong>Manual Payment Verification:</strong> For GCash or BDO Bank Transfers, please send proof of payment to our Facebook page or store hotline with your Order Number for rapid verification.</li>
            </ul>
          </section>

        </div>

      </div>
    </div>
  </main>

<?php require 'includes/footer.php'; ?>
