<?php
$pageTitle       = 'About Us | Cheyn Gadgets';
$pageDescription = 'Learn about Cheyn Gadgets — Roxas City\'s trusted source for pre-owned and brand-new gadgets.';
$activePage      = 'about';
require 'includes/header.php';
?>

  <!-- BREADCRUMB -->
  <div class="breadcrumb-wrap">
    <div class="container">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0">
          <li class="breadcrumb-item"><a href="index.php">Home</a></li>
          <li class="breadcrumb-item active" aria-current="page">About</li>
        </ol>
      </nav>
    </div>
  </div>

  <!-- PAGE HEADER -->
  <header class="py-5 text-center bg-white border-bottom">
    <div class="container py-lg-4" style="max-width: 760px;">
      <span class="apple-section-tag mb-2 d-inline-block">Store Profile &middot; Roxas City</span>
      <h1 class="display-6 fw-semibold text-dark tracking-tight mb-3">About Cheyn Gadgets</h1>
      <p class="text-muted fs-6 mb-0">
        Serving Roxas City with thoroughly inspected hardware, honest grading, and dependable local store support.
      </p>
    </div>
  </header>

  <!-- OUR STORY & STOREFRONT HIGHLIGHT -->
  <section class="py-5" id="story" aria-labelledby="ourStoryHeading">
    <div class="container">
      <div class="row g-5 align-items-center">
        <div class="col-lg-6">
          <span class="apple-section-tag mb-1">Our Story</span>
          <h2 id="ourStoryHeading" class="h2 fw-semibold text-dark mb-3">
            Born local. Built on trust.
          </h2>
          <p class="text-muted mb-3">
            <strong>Cheyn Gadgets</strong> started as a small, passionate initiative right here in Roxas City. What began as helping friends and family find trusted pre-owned iPhones quickly grew into a community storefront known for honest deals and dependable gadgets.
          </p>
          <p class="text-muted mb-4">
            Today, we carry a curated lineup of <strong>pre-owned</strong> and <strong>brand-new</strong> smartphones, tablets, and accessories. Every single unit is personally tested by our team before it ever goes on display or gets dispatched to a customer.
          </p>
          <div class="p-4 rounded-4 bg-light border border-light-subtle">
            <p class="text-dark fw-medium mb-1">&ldquo;Every buyer is treated like a neighbor.&rdquo;</p>
            <p class="text-muted small mb-0">
              You are always welcome to hold, test, and check the phone thoroughly before paying &mdash; no pressure, no hidden issues.
            </p>
          </div>
        </div>
        <div class="col-lg-6" id="location">
          <div class="card border-0 shadow-sm rounded-4 overflow-hidden" id="pickup">
            <img
              src="assets/img/store/storefront_facade.webp"
              alt="Cheyn Gadgets storefront at Premier De Mayo St., Roxas City"
              class="img-fluid w-100"
              style="height: 340px; object-fit: cover;"
              loading="lazy"
              decoding="async"
              onerror="this.onerror=null;this.src='assets/img/store/storefront_facade.jpg'"
            >
            <div class="p-3 bg-white border-top">
              <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                <div>
                  <h3 class="h6 fw-semibold mb-0 text-dark">ASB-1 Building, Premier De Mayo St.</h3>
                  <span class="text-muted small">Near Old GSIS riverside, Roxas City, Capiz</span>
                </div>
                <span class="badge bg-light text-dark border px-2 py-1 small fw-normal">
                  <i class="bi bi-clock me-1 text-muted"></i>Open Daily 9:00 AM – 7:30 PM
                </span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- STORE & COMMUNITY GALLERY -->
  <section class="py-5 bg-light border-top border-bottom" aria-labelledby="galleryHeading">
    <div class="container">
      <div class="apple-section-header text-center mb-5">
        <span class="apple-section-tag">Inside the Shop</span>
        <h2 id="galleryHeading" class="apple-section-title">Life at Cheyn Gadgets.</h2>
        <p class="apple-section-subtitle mx-auto">
          From careful device diagnostics on our bench to happy in-store customer handovers across Roxas City.
        </p>
      </div>

      <div class="row g-4">
        <!-- Photo Card 1: Customer Pickup -->
        <div class="col-md-4">
          <article class="card border-0 shadow-sm rounded-4 overflow-hidden h-100 bg-white">
            <div class="position-relative" style="height: 240px; overflow: hidden;">
              <img
                src="assets/img/proof/customer_handover_1.webp"
                alt="Happy customer device handover at Cheyn Gadgets"
                class="img-fluid w-100 h-100"
                style="object-fit: cover;"
                loading="lazy"
                decoding="async"
                onerror="this.onerror=null;this.src='assets/img/proof/customer_handover_1.jpeg'"
              >
            </div>
            <div class="p-3 p-md-4">
              <span class="text-xs text-muted text-uppercase tracking-wider fw-semibold d-block mb-1">In-Store Handover</span>
              <h3 class="h6 fw-semibold text-dark mb-1">Customer Pickups</h3>
              <p class="text-muted small mb-0">Satisfied customers checking their units in person with all accessories included.</p>
            </div>
          </article>
        </div>

        <!-- Photo Card 2: Bench Testing -->
        <div class="col-md-4" id="inspection">
          <article class="card border-0 shadow-sm rounded-4 overflow-hidden h-100 bg-white">
            <div class="position-relative" style="height: 240px; overflow: hidden;">
              <img
                src="assets/img/store/interior_display_1.webp"
                alt="Device diagnostic check and display in store"
                class="img-fluid w-100 h-100"
                style="object-fit: cover;"
                loading="lazy"
                decoding="async"
                onerror="this.onerror=null;this.src='assets/img/store/interior_display_1.jpg'"
              >
            </div>
            <div class="p-3 p-md-4">
              <span class="text-xs text-muted text-uppercase tracking-wider fw-semibold d-block mb-1">Hands-On Inspection</span>
              <h3 class="h6 fw-semibold text-dark mb-1">Diagnostic Verification</h3>
              <p class="text-muted small mb-0">Verifying TrueTone, camera sensors, and battery health before any device goes to stock.</p>
            </div>
          </article>
        </div>

        <!-- Photo Card 3: Fresh Stock -->
        <div class="col-md-4" id="delivery">
          <article class="card border-0 shadow-sm rounded-4 overflow-hidden h-100 bg-white">
            <div class="position-relative" style="height: 240px; overflow: hidden;">
              <img
                src="assets/img/store/interior_design.webp"
                alt="Showroom display at Cheyn Gadgets Roxas City"
                class="img-fluid w-100 h-100"
                style="object-fit: cover;"
                loading="lazy"
                decoding="async"
                onerror="this.onerror=null;this.src='assets/img/store/interior_design.jpg'"
              >
            </div>
            <div class="p-3 p-md-4">
              <span class="text-xs text-muted text-uppercase tracking-wider fw-semibold d-block mb-1">Store Showroom</span>
              <h3 class="h6 fw-semibold text-dark mb-1">Curated Inventory</h3>
              <p class="text-muted small mb-0">Clean displays, genuine accessories, and quality-inspected devices ready for release.</p>
            </div>
          </article>
        </div>
      </div>
    </div>
  </section>

  <!-- WHY BUY LOCALLY -->
  <section class="py-5 bg-white" id="why-us" aria-labelledby="whyHeading">
    <div class="container py-lg-3">
      <div class="apple-section-header text-center mb-5">
        <span class="apple-section-tag">Why Buy Locally</span>
        <h2 id="whyHeading" class="apple-section-title">The local store advantage.</h2>
        <p class="apple-section-subtitle mx-auto">
          Why gadget buyers in Capiz prefer visiting us directly instead of risking unseen online purchases.
        </p>
      </div>

      <div class="row g-4">
        <div class="col-md-4">
          <div class="p-4 rounded-4 bg-light border border-light-subtle h-100">
            <span class="text-xs text-muted text-uppercase tracking-wider fw-semibold d-block mb-2">01 &middot; Transparency</span>
            <h3 class="h5 fw-semibold text-dark mb-2">Test before you pay</h3>
            <p class="text-muted small mb-0">
              Hold the unit in your hands. Test the camera, check touchscreen responsiveness, verify battery percentage, and be fully satisfied before completing your purchase.
            </p>
          </div>
        </div>

        <div class="col-md-4" id="warranty">
          <div class="p-4 rounded-4 bg-light border border-light-subtle h-100">
            <span class="text-xs text-muted text-uppercase tracking-wider fw-semibold d-block mb-2">02 &middot; Peace of mind</span>
            <h3 class="h5 fw-semibold text-dark mb-2">7-Day store replacement</h3>
            <p class="text-muted small mb-0">
              No long waiting periods or complicated return forms. If any functional defect shows up within your first 7 days, bring it back to our Roxas City shop.
            </p>
          </div>
        </div>

        <div class="col-md-4">
          <div class="p-4 rounded-4 bg-light border border-light-subtle h-100">
            <span class="text-xs text-muted text-uppercase tracking-wider fw-semibold d-block mb-2">03 &middot; Direct value</span>
            <h3 class="h5 fw-semibold text-dark mb-2">Honest, fair pricing</h3>
            <p class="text-muted small mb-0">
              Straightforward pricing without hidden fees or surprise add-ons. We provide authentic value for both brand-new and quality-inspected pre-owned units.
            </p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- MEET THE TEAM -->
  <section class="py-5 bg-light border-top" aria-labelledby="teamHeading">
    <div class="container py-lg-3">
      <div class="row g-4 align-items-center">
        <div class="col-lg-6">
          <span class="apple-section-tag mb-1">Our Team</span>
          <h2 id="teamHeading" class="h2 fw-semibold text-dark mb-3">Meet the People Behind CheynGadget</h2>
          <p class="text-muted mb-3">
            Behind every tested iPhone, honest recommendation, and smooth transaction is our dedicated Roxas City crew. We are local tech enthusiasts passionate about helping you get the best value for your device.
          </p>
          <ul class="list-unstyled text-muted mb-4 small">
            <li class="d-flex align-items-center gap-2 mb-2">
              <i class="bi bi-check2 text-muted fs-6"></i>
              <span>Hands-on diagnostics and iCloud verification by in-store staff</span>
            </li>
            <li class="d-flex align-items-center gap-2 mb-2">
              <i class="bi bi-check2 text-muted fs-6"></i>
              <span>Patient in-store customer support and warranty assistance</span>
            </li>
            <li class="d-flex align-items-center gap-2">
              <i class="bi bi-check2 text-muted fs-6"></i>
              <span>Accredited financing guidance with Skyro installment plans</span>
            </li>
          </ul>
        </div>
        <div class="col-lg-6">
          <div class="card border-0 shadow-sm rounded-4 overflow-hidden bg-white">
            <img
              src="assets/img/store/the_crew.webp"
              alt="CheynGadget Roxas City Team"
              class="img-fluid w-100"
              loading="lazy"
              decoding="async"
              onerror="this.onerror=null;this.src='assets/img/store/the_crew.jpg'"
            >
            <div class="p-3 bg-white text-center border-top">
              <span class="small text-muted fw-medium">The Cheyn iPhones &amp; Gadgets Team &middot; Roxas Branch</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- CTA BANNER -->
  <section class="py-5 text-center bg-white border-top">
    <div class="container py-lg-4" style="max-width: 620px;">
      <span class="apple-section-tag mb-2 d-inline-block">Roxas City Storefront</span>
      <h2 class="h3 fw-semibold text-dark mb-2">Visit Cheyn Gadgets in Roxas City</h2>
      <p class="text-muted small mb-4">
        Check our available inventory online or stop by our store to inspect devices in person.
      </p>
      <div class="d-flex justify-content-center gap-2 flex-wrap">
        <a href="catalog.php" class="btn apple-btn-primary">Browse Inventory <i class="bi bi-arrow-right ms-1"></i></a>
        <a href="contact.php" class="btn btn-outline-secondary px-3" style="border-radius: 9999px;">Store Location &amp; Map</a>
      </div>
    </div>
  </section>

<?php require 'includes/footer.php'; ?>
</body>
</html>
