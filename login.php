<?php
require_once __DIR__ . '/includes/session.php';
if (isset($_GET['action']) && $_GET['action'] === 'logout') {
    $_SESSION = [];
    if (ini_get('session.use_cookies')) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params['path'], $params['domain'],
            $params['secure'], $params['httponly']
        );
    }
    session_destroy();
    header('Location: login.php');
    exit;
}

if (!empty($_SESSION['user_id'])) {
    if (($_SESSION['user_role'] ?? '') === 'admin') {
        header('Location: admin/dashboard.php');
    } else {
        header('Location: profile.php');
    }
    exit;
}
$pageTitle       = 'Sign In or Create Account | Cheyn Gadgets';
$pageDescription = 'Sign in or create your Cheyn Gadgets account to manage orders and shop for certified phones and tablets in Roxas City.';
$activePage      = 'login';
require 'includes/header.php';
?>

  <main class="auth-wrapper apple-auth-canvas">
    <div class="container py-4">
      <div class="row justify-content-center">
        <div class="col-12 col-sm-10 col-md-8 col-lg-6 col-xl-5" style="max-width: 480px;">

          <!-- Header / Brand Section -->
          <div class="apple-auth-header text-center mb-4">
            <div class="apple-auth-badge mb-3">
              <span class="apple-brand-circle">
                <i class="bi bi-shield-lock-fill"></i>
              </span>
            </div>
            <h1 class="apple-auth-title">Sign in for faster checkout.</h1>
            <p class="apple-auth-subtitle">Manage orders, track deliveries, and enjoy seamless shopping with your Cheyn Account.</p>
          </div>

          <!-- Apple Auth Card -->
          <div class="auth-card apple-auth-card">
            <!-- Apple Segmented Control Switcher -->
            <div class="apple-segmented-wrap mb-4">
              <ul class="nav apple-segmented-control" id="authTabs" role="tablist">
                <li class="nav-item flex-fill" role="presentation">
                  <button class="nav-link active w-100" id="login-tab" data-bs-toggle="tab" data-bs-target="#loginPane" type="button" role="tab" aria-controls="loginPane" aria-selected="true">
                    Sign In
                  </button>
                </li>
                <li class="nav-item flex-fill" role="presentation">
                  <button class="nav-link w-100" id="register-tab" data-bs-toggle="tab" data-bs-target="#registerPane" type="button" role="tab" aria-controls="registerPane" aria-selected="false">
                    Create Account
                  </button>
                </li>
              </ul>
            </div>

            <div class="tab-content">
              <!-- SIGN IN PANE -->
              <div class="tab-pane fade show active" id="loginPane" role="tabpanel" aria-labelledby="login-tab">
                <div class="apple-pane-heading mb-4 text-center">
                  <h2 class="h5 fw-bold mb-1 text-dark">Sign In to Your Account</h2>
                  <p class="apple-pane-desc mb-0">Enter your email and password to continue.</p>
                </div>

                <form id="loginForm" novalidate>
                  <div class="apple-form-group mb-3">
                    <label for="loginEmail" class="apple-form-label">Email Address</label>
                    <input type="email" class="form-control apple-form-control" id="loginEmail" placeholder="you@email.com" autocomplete="email" required>
                    <div class="invalid-feedback">Please enter a valid email address.</div>
                  </div>

                  <div class="apple-form-group mb-3">
                    <div class="d-flex align-items-center justify-content-between mb-1">
                      <label for="loginPassword" class="apple-form-label mb-0">Password</label>
                      <a href="contact.php?product=Password+Reset+Request" class="apple-subtle-link">Forgot password?</a>
                    </div>
                    <div class="input-group apple-input-group">
                      <input type="password" class="form-control apple-form-control border-end-0" id="loginPassword" placeholder="Enter your password" autocomplete="current-password" required>
                      <button class="btn btn-outline-secondary pass-toggle apple-pass-toggle" type="button" id="loginPassToggle" aria-label="Show password">
                        <i class="bi bi-eye" id="loginPassIcon"></i>
                      </button>
                    </div>
                    <div class="invalid-feedback">Please enter your password.</div>
                  </div>

                  <div class="d-flex align-items-center justify-content-between mb-4">
                    <div class="form-check mb-0">
                      <input class="form-check-input apple-checkbox" type="checkbox" id="rememberMe">
                      <label class="form-check-label apple-check-label" for="rememberMe">Stay signed in</label>
                    </div>
                  </div>

                  <div class="d-grid mb-3">
                    <button type="submit" class="btn btn-ct apple-btn-primary">
                      <i class="bi bi-box-arrow-in-right me-2"></i>Sign In
                    </button>
                  </div>

                  <p class="text-center apple-switch-hint mb-0">
                    Don't have an account? <a href="#" class="apple-accent-link fw-semibold" id="switchToRegister">Create one now</a>
                  </p>
                </form>
              </div>

              <!-- CREATE ACCOUNT PANE -->
              <div class="tab-pane fade" id="registerPane" role="tabpanel" aria-labelledby="register-tab">
                <div class="apple-pane-heading mb-4 text-center">
                  <h2 class="h5 fw-bold mb-1 text-dark">Create Cheyn ID</h2>
                  <p class="apple-pane-desc mb-0">Join Cheyn Gadgets for certified devices &amp; priority support.</p>
                </div>

                <form id="registerForm" novalidate>
                  <div class="apple-form-group mb-3">
                    <label for="regName" class="apple-form-label">Full Name</label>
                    <input type="text" class="form-control apple-form-control" id="regName" placeholder="Juan dela Cruz" autocomplete="name" required>
                    <div class="invalid-feedback">Please enter your full name.</div>
                  </div>

                  <div class="apple-form-group mb-3">
                    <label for="regEmail" class="apple-form-label">Email Address</label>
                    <input type="email" class="form-control apple-form-control" id="regEmail" placeholder="you@email.com" autocomplete="email" required>
                    <div class="invalid-feedback">Please enter a valid email address.</div>
                  </div>

                  <div class="apple-form-group mb-3">
                    <label for="regPhone" class="apple-form-label">Phone Number <span class="text-muted fw-normal">(Optional)</span></label>
                    <input type="tel" class="form-control apple-form-control" id="regPhone" placeholder="09XX-XXX-XXXX" autocomplete="tel">
                  </div>

                  <div class="apple-form-group mb-3">
                    <label for="regPassword" class="apple-form-label">Password</label>
                    <div class="input-group apple-input-group">
                      <input type="password" class="form-control apple-form-control border-end-0" id="regPassword" placeholder="Create a strong password" autocomplete="new-password" required minlength="8">
                      <button class="btn btn-outline-secondary pass-toggle apple-pass-toggle" type="button" id="regPassToggle" aria-label="Show password">
                        <i class="bi bi-eye" id="regPassIcon"></i>
                      </button>
                    </div>
                    <div class="invalid-feedback">Password must be at least 8 characters.</div>
                    <div class="form-text apple-form-help">Minimum 8 characters.</div>
                  </div>

                  <div class="apple-form-group mb-3">
                    <label for="regConfirmPassword" class="apple-form-label">Confirm Password</label>
                    <div class="input-group apple-input-group">
                      <input type="password" class="form-control apple-form-control border-end-0" id="regConfirmPassword" placeholder="Re-enter your password" autocomplete="new-password" required>
                      <button class="btn btn-outline-secondary pass-toggle apple-pass-toggle" type="button" id="regConfirmPassToggle" aria-label="Show confirm password">
                        <i class="bi bi-eye" id="regConfirmPassIcon"></i>
                      </button>
                    </div>
                    <div class="invalid-feedback" id="confirmPassError">Passwords do not match.</div>
                  </div>

                  <div class="form-check apple-terms-check mb-4">
                    <input class="form-check-input apple-checkbox" type="checkbox" id="agreeTerms" required>
                    <label class="form-check-label apple-check-label terms-label" for="agreeTerms">
                      I agree to the <a href="about.php" target="_blank" rel="noopener noreferrer" class="apple-accent-link">Terms and Conditions</a> &amp; <a href="about.php" target="_blank" rel="noopener noreferrer" class="apple-accent-link">Privacy Policy</a>
                    </label>
                    <div class="invalid-feedback">You must agree to the Terms and Conditions.</div>
                  </div>

                  <div class="d-grid mb-3">
                    <button type="submit" class="btn btn-ct apple-btn-primary">
                      <i class="bi bi-person-check me-2"></i>Create Account
                    </button>
                  </div>

                  <p class="text-center apple-switch-hint mb-0">
                    Already have an account? <a href="#" class="apple-accent-link fw-semibold" id="switchToLogin">Sign in</a>
                  </p>
                </form>
              </div>
            </div>

            <!-- Apple Privacy & Security Badge -->
            <div class="apple-privacy-strip mt-4 pt-3 border-top text-center">
              <div class="d-inline-flex align-items-center gap-1 text-muted small mb-1">
                <i class="bi bi-shield-check text-success"></i>
                <span class="fw-semibold text-secondary">Apple-grade Privacy &amp; Protection</span>
              </div>
              <p class="apple-privacy-text text-muted mb-0">Your account data is encrypted and never shared with third parties.</p>
            </div>
          </div>

          <!-- Educational Disclaimer Pill -->
          <div class="text-center mt-3">
            <span class="apple-edu-badge">
              <i class="bi bi-info-circle me-1"></i> This website is for educational purposes only.
            </span>
          </div>

        </div>
      </div>
    </div>
  </main>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="<?= asset_url('assets/js/main.js') ?>"></script>
  <script src="<?= asset_url('assets/js/login.js') ?>"></script>
</body>
</html>
