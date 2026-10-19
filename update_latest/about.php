<?php
$pageTitle       = 'About Us | Cheyn Gadgets';
$pageDescription = 'Learn about Cheyn Gadgets — Roxas City\'s trusted source for pre-owned, refurbished, and brand-new gadgets.';
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
  <section class="page-header" aria-labelledby="aboutHeroHeading">
    <div class="container">
      <span class="hero-badge"><i class="bi bi-geo-alt-fill me-1"></i>Roxas City, Capiz</span>
      <h1 id="aboutHeroHeading">About Cheyn Gadgets</h1>
      <p class="hero-sub page-subtitle mb-0">Serving Tech Lovers in Roxas City with Honest Advice &amp; Tested Hardware</p>
    </div>
  </section>

  <!-- OUR STORY & STOREFRONT HIGHLIGHT -->
  <section class="py-5" id="story" aria-labelledby="ourStoryHeading">
    <div class="container">
      <div class="row g-5 align-items-center">
        <div class="col-lg-6">
          <span class="section-label">OUR STORY</span>
          <h2 id="ourStoryHeading" class="fw-bold mb-3">
            Born Local, Built on Trust
          </h2>
          <p class="text-muted mb-3">
            <strong>Cheyn Gadgets</strong> started as a small, passionate initiative right here in Roxas City. What began as helping friends and family find trusted pre-owned iPhones quickly grew into a community storefront known for honest deals and dependable gadgets.
          </p>
          <p class="text-muted mb-4">
            Today, we carry a curated lineup of <strong>pre-owned</strong>, <strong>refurbished</strong>, and <strong>brand-new</strong> smartphones, tablets, and accessories. Every single unit is personally tested by our team before it ever goes on display or gets dispatched to a customer.
          </p>
          <div class="mission-box">
            <p class="fw-bold mb-1"><i class="bi bi-quote fs-5 text-ct me-1"></i>Our Promise to Every Customer</p>
            <p class="mb-0 text-muted">
              We treat every buyer like a neighbor. You are always welcome to hold, test, and check the phone thoroughly before paying — no pressure, no hidden issues.
            </p>
          </div>
        </div>
        <div class="col-lg-6" id="location">
          <div class="store-feature-card" id="pickup">
            <img
              src="assets/img/store/storefront.jpg"
              alt="Cheyn Gadgets storefront in Roxas City"
              class="store-feature-img"
              loading="lazy"
              onerror="this.onerror=null;this.src='assets/img/hero-product.jpg'"
            >
            <div class="store-feature-caption">
              <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                <div>
                  <h6 class="fw-bold mb-0 text-dark">Cheyn Gadgets Storefront</h6>
                  <span class="text-muted small">Roxas City, Capiz</span>
                </div>
                <span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1 small">
                  <i class="bi bi-door-open me-1"></i>Open for In-Store Pickup
                </span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- STORE & COMMUNITY GALLERY -->
  <section class="py-5 bg-ct-soft border-top border-bottom" aria-labelledby="galleryHeading">
    <div class="container">
      <div class="section-header text-center mb-5">
        <span class="section-label">IN OUR STORE</span>
        <h2 id="galleryHeading" class="section-title">Life at Cheyn Gadgets</h2>
        <p class="section-subtitle mx-auto" style="max-width: 540px;">
          From careful device diagnostics on our bench to happy in-store customer handovers across Roxas City.
        </p>
      </div>

      <div class="row g-4">
        <!-- Photo Card 1: Customer Pickup -->
        <div class="col-md-4">
          <article class="gallery-card">
            <div class="gallery-img-wrap">
              <img
                src="assets/img/store/customer-1.jpg"
                alt="Happy customer pickup at Cheyn Gadgets"
                class="gallery-img"
                loading="lazy"
                onerror="this.onerror=null;this.src='assets/img/iphone15_promax.jpeg'"
              >
            </div>
            <div class="gallery-body">
              <span class="gallery-tag">In-Store Handover</span>
              <h5 class="gallery-title">Customer Pickups</h5>
              <p class="gallery-desc">Satisfied customers checking their units in person with all accessories included.</p>
            </div>
          </article>
        </div>

        <!-- Photo Card 2: Bench Testing -->
        <div class="col-md-4" id="inspection">
          <article class="gallery-card">
            <div class="gallery-img-wrap">
              <img
                src="assets/img/store/testing.jpg"
                alt="Device diagnostic check in store"
                class="gallery-img"
                loading="lazy"
                onerror="this.onerror=null;this.src='assets/img/iphone_13pro.jpeg'"
              >
            </div>
            <div class="gallery-body">
              <span class="gallery-tag">Hands-On Inspection</span>
              <h5 class="gallery-title">Diagnostic Verification</h5>
              <p class="gallery-desc">Verifying TrueTone, camera sensors, and battery health before any device goes to stock.</p>
            </div>
          </article>
        </div>

        <!-- Photo Card 3: Fresh Stock -->
        <div class="col-md-4" id="delivery">
          <article class="gallery-card">
            <div class="gallery-img-wrap">
              <img
                src="assets/img/store/inventory.jpg"
                alt="Fresh gadget stock ready for pickup"
                class="gallery-img"
                loading="lazy"
                onerror="this.onerror=null;this.src='assets/img/iPhone_12.jpeg'"
              >
            </div>
            <div class="gallery-body">
              <span class="gallery-tag">Fresh Arrivals</span>
              <h5 class="gallery-title">Curated Inventory</h5>
              <p class="gallery-desc">Sealed brand-new phones and clean Grade A pre-owned units ready for immediate release.</p>
            </div>
          </article>
        </div>
      </div>
    </div>
  </section>

  <!-- WHY BUY LOCALLY -->
  <section class="py-5" id="why-us" aria-labelledby="whyHeading">
    <div class="container">
      <div class="section-header text-center mb-5">
        <span class="section-label">WHY BUY LOCALLY</span>
        <h2 id="whyHeading" class="section-title">The Local Store Advantage</h2>
        <p class="section-subtitle mx-auto" style="max-width: 540px;">
          Why gadget buyers in Capiz prefer visiting us directly instead of risking unseen online purchases.
        </p>
      </div>

      <div class="row g-4">
        <div class="col-md-4">
          <div class="feature-card h-100">
            <div class="feature-icon-wrap"><i class="bi bi-person-check-fill text-ct"></i></div>
            <h3 class="h5 fw-bold mb-2">Test Before You Pay</h3>
            <p class="text-muted small mb-0">
              Hold the unit in your hands. Test the camera, check the touchscreen, verify the battery capacity, and ensure you're completely satisfied before completing your purchase.
            </p>
          </div>
        </div>

        <div class="col-md-4" id="warranty">
          <div class="feature-card h-100">
            <div class="feature-icon-wrap"><i class="bi bi-arrow-repeat text-ct"></i></div>
            <h3 class="h5 fw-bold mb-2">7-Day Store Replacement</h3>
            <p class="text-muted small mb-0">
              No long waiting periods or complicated return forms. If any functional defect shows up within your first 7 days, bring it back to our Roxas City shop.
            </p>
          </div>
        </div>

        <div class="col-md-4">
          <div class="feature-card h-100">
            <div class="feature-icon-wrap"><i class="bi bi-tag-fill text-ct"></i></div>
            <h3 class="h5 fw-bold mb-2">Honest, Fair Pricing</h3>
            <p class="text-muted small mb-0">
              Straightforward pricing without hidden fees or surprise add-ons. We provide authentic value for both brand-new and quality-inspected pre-owned units.
            </p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- CTA BANNER -->
  <section class="cta-section text-center py-5">
    <div class="container">
      <h2 class="mb-2">Visit Cheyn Gadgets in Roxas City</h2>
      <p class="mb-4 mx-auto text-slate-400" style="max-width: 500px; color: #94a3b8;">
        Check our available inventory online or get in touch for custom model inquiries and same-day reservation.
      </p>
      <div class="d-flex justify-content-center gap-3 flex-wrap">
        <a href="catalog.php" class="btn btn-cta-light px-4">Browse Catalog <i class="bi bi-arrow-right ms-1"></i></a>
        <a href="contact.php" class="btn btn-cta-outline-light px-4">Store Location &amp; Contact</a>
      </div>
    </div>
  </section>

<?php require 'includes/footer.php'; ?>
</body>
</html>
