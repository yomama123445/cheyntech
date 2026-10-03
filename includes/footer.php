  <!-- FOOTER -->
  <footer class="site-footer mt-auto">
    <div class="container">
      <div class="row gy-4">
        <div class="col-lg-4 col-md-6">
          <a href="index.php" class="d-flex align-items-center gap-2 text-decoration-none mb-3">
            <img src="assets/img/logo-64.png" alt="Cheyn Gadgets" width="34" height="34">
            <span class="footer-brand-name">Cheyn Gadgets</span>
          </a>
          <p class="mb-3">Your trusted electronics storefront in Roxas City. Specializing in function-tested pre-owned, refurbished, and brand-new smartphones, tablets, and wearables.</p>
          <div class="d-inline-flex align-items-center gap-2 px-3 py-1 mb-3 rounded-pill" style="background:#1e293b;border:1px solid #334155;font-size:0.78rem;color:#cbd5e1;">
            <i class="bi bi-geo-alt-fill text-danger"></i>
            <span>Roxas City, Capiz · Tested &amp; Certified Units</span>
          </div>
          <div class="social-links d-flex gap-2">
            <a href="https://www.facebook.com/profile.php?id=61580936674089" target="_blank" rel="noopener noreferrer" aria-label="Facebook"><i class="bi bi-facebook"></i></a>
            <a aria-disabled="true" tabindex="-1" title="Coming soon" aria-label="Instagram (coming soon)" style="opacity:.45;cursor:default;pointer-events:none;"><i class="bi bi-instagram"></i></a>
            <a href="https://www.tiktok.com/@cheyniphonesandgadgets" target="_blank" rel="noopener noreferrer" aria-label="TikTok"><i class="bi bi-tiktok"></i></a>
          </div>
        </div>
        <div class="col-6 col-md-3 col-lg-2 offset-lg-1">
          <h6 class="footer-heading">Shop</h6>
          <div class="footer-links">
            <a href="catalog.php?cat=preowned">Pre-owned iPhones</a>
            <a href="catalog.php?cat=new">New iPhones</a>
            <a href="catalog.php?cat=android">Android Devices</a>
            <a href="catalog.php?cat=tablet">Tablets &amp; iPads</a>
          </div>
        </div>
        <div class="col-6 col-md-3 col-lg-2">
          <h6 class="footer-heading">Support &amp; Trust</h6>
          <div class="footer-links">
            <?php if (!empty($_SESSION['user_id'])): ?>
              <a href="track-order.php">Track Order</a>
            <?php else: ?>
              <a href="login.php">Sign In to Track</a>
            <?php endif; ?>
            <a href="contact.php">Store Location &amp; Contact</a>
            <a href="about.php">Inspection Process</a>
          </div>
        </div>
        <div class="col-6 col-md-3 col-lg-2">
          <h6 class="footer-heading">Account</h6>
          <div class="footer-links">
            <a href="login.php">Sign In</a>
            <a href="login.php#register">Create Account</a>
            <a href="cart.php">Shopping Cart</a>
          </div>
        </div>
      </div>
    </div>
  </footer>

  <button id="backToTop" aria-label="Back to top"><i class="bi bi-chevron-up"></i></button>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="<?= asset_url('assets/js/main.js') ?>"></script>
