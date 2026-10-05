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
    $redirect = $_GET['redirect'] ?? '';
    if (!empty($redirect) && str_starts_with($redirect, 'checkout')) {
        header('Location: ' . $redirect);
        exit;
    }
    if (($_SESSION['user_role'] ?? '') === 'admin') {
        header('Location: admin/dashboard.php');
    } else {
        header('Location: profile.php');
    }
    exit;
}
$pageTitle       = 'Cheyn ID | Sign In or Create Account';
$pageDescription = 'Sign in with your Cheyn ID or create an account for fast checkout, device & order tracking, and local support in Roxas City.';
$activePage      = 'login';
require 'includes/header.php';
?>

  <main class="apple-auth-viewport">
    <div class="container apple-auth-container">

      <!-- Apple Header Emblem & Brand Mark -->
      <div class="apple-auth-hero text-center mb-4">
        <div class="apple-hero-glyph-wrap mb-3">
          <div class="apple-hero-glyph">
            <i class="bi bi-shield-lock-fill"></i>
          </div>
        </div>
      </div>

      <!-- Checkout Redirect Notice -->
      <?php if (!empty($_GET['redirect']) && str_starts_with($_GET['redirect'], 'checkout')): ?>
        <div class="alert alert-light border shadow-sm d-flex align-items-center gap-2 mb-4 py-2 px-3 rounded-3" role="status">
          <i class="bi bi-bag-check text-primary fs-5 flex-shrink-0"></i>
          <span class="small text-muted">Please sign in or create a Cheyn ID to proceed with your checkout.</span>
        </div>
      <?php endif; ?>

      <!-- Segmented Mode Control (Sign In / Create Account) -->
      <div class="apple-segmented-container mb-4">
        <ul class="nav apple-segmented-pills" id="authTabs" role="tablist">
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

      <!-- Main Interactive Stage (One input at a time) -->
      <div class="apple-auth-stage">
        <div class="tab-content w-100">

          <!-- ==============================================
               SIGN IN: ONE INPUT AT A TIME (Apple ID Flow)
               ============================================== -->
          <div class="tab-pane show active" id="loginPane" role="tabpanel" aria-labelledby="login-tab">
            <form id="loginForm" novalidate autocomplete="on">

              <!-- SIGN IN: STEP 1 (Email / Identifier) -->
              <div class="apple-auth-step" id="loginStep1">
                <div class="text-center mb-4">
                  <h1 class="apple-hero-title">Sign in with Cheyn ID</h1>
                  <p class="apple-hero-subtitle">Enter your email address to continue to your account.</p>
                </div>

                <div class="apple-step-body">
                  <label for="loginEmail" class="apple-field-label">Email Address</label>
                  <div class="apple-input-box" id="loginEmailBox">
                    <input type="email" class="apple-single-input" id="loginEmail" autocomplete="email" required>
                    <button type="button" class="apple-circle-action-btn" id="loginContinueBtn" aria-label="Continue to password">
                      <i class="bi bi-arrow-right"></i>
                    </button>
                  </div>
                  <div class="apple-field-error" id="loginEmailError">Please enter a valid email address.</div>

                  <div class="d-flex align-items-center justify-content-between mt-4 pt-1">
                    <div class="form-check mb-0">
                      <input class="form-check-input apple-checkbox" type="checkbox" id="rememberMe">
                      <label class="form-check-label apple-check-label" for="rememberMe">Keep me signed in</label>
                    </div>
                    <a href="contact.php?product=Password+Reset+Request" class="apple-subtle-link">Forgotten password?</a>
                  </div>

                  <div class="apple-switch-prompt text-center mt-4 pt-3">
                    <p class="mb-0 text-muted small">
                      Don't have a Cheyn ID? <a href="#" class="apple-accent-link fw-semibold" id="switchToRegister">Create yours now</a>
                    </p>
                  </div>
                </div>
              </div>

              <!-- SIGN IN: STEP 2 (Password) -->
              <div class="apple-auth-step d-none" id="loginStep2">
                <div class="text-center mb-4">
                  <h2 class="apple-hero-title">Enter your password</h2>
                  <div class="apple-identity-pill mt-2">
                    <span class="apple-identity-text" id="loginEmailDisplay"></span>
                    <button type="button" class="apple-identity-edit-btn" id="loginBackBtn" title="Change email" aria-label="Change email">
                      <i class="bi bi-pencil-fill"></i>
                    </button>
                  </div>
                </div>

                <div class="apple-step-body">
                  <label for="loginPassword" class="apple-field-label">Password</label>
                  <div class="apple-input-box" id="loginPasswordBox">
                    <input type="password" class="apple-single-input" id="loginPassword" autocomplete="current-password" required>
                    <button type="button" class="apple-eye-btn pass-toggle" id="loginPassToggle" aria-label="Show password">
                      <i class="bi bi-eye" id="loginPassIcon"></i>
                    </button>
                    <button type="submit" class="apple-circle-action-btn apple-submit-btn" id="loginSubmitBtn" aria-label="Sign In">
                      <i class="bi bi-arrow-right"></i>
                    </button>
                  </div>
                  <div class="apple-field-error" id="loginPasswordError">Please enter your password.</div>

                  <div class="d-flex align-items-center justify-content-between mt-4 pt-1">
                    <button type="button" class="btn btn-link apple-back-text-btn p-0 text-decoration-none" id="loginBackToEmail">
                      <i class="bi bi-arrow-left me-1"></i> Use different email
                    </button>
                    <a href="contact.php?product=Password+Reset+Request" class="apple-subtle-link">Forgotten password?</a>
                  </div>
                </div>
              </div>

            </form>
          </div>

          <!-- ==============================================
               CREATE ACCOUNT: STEPPED PROGRESSION (Apple Flow)
               ============================================== -->
          <div class="tab-pane" id="registerPane" role="tabpanel" aria-labelledby="register-tab">
            <form id="registerForm" novalidate autocomplete="on">

              <!-- Stepped Progress Dots -->
              <div class="apple-step-indicator text-center mb-4">
                <span class="apple-step-dot active" id="regDot1" title="Step 1: Your Name"></span>
                <span class="apple-step-dot" id="regDot2" title="Step 2: Contact Info"></span>
                <span class="apple-step-dot" id="regDot3" title="Step 3: Security &amp; Finish"></span>
              </div>

              <!-- REGISTER: STEP 1 (Name) -->
              <div class="apple-auth-step" id="regStep1">
                <div class="text-center mb-4">
                  <h1 class="apple-hero-title">Create your Cheyn ID</h1>
                  <p class="apple-hero-subtitle">Let's start with your full name.</p>
                </div>

                <div class="apple-step-body">
                  <label for="regName" class="apple-field-label">Full Name</label>
                  <div class="apple-input-box" id="regNameBox">
                    <input type="text" class="apple-single-input" id="regName" autocomplete="name" required>
                    <button type="button" class="apple-circle-action-btn" id="regStep1Next" aria-label="Continue to contact info">
                      <i class="bi bi-arrow-right"></i>
                    </button>
                  </div>
                  <div class="apple-field-error" id="regNameError">Please enter your full name.</div>

                  <div class="apple-switch-prompt text-center mt-4 pt-3">
                    <p class="mb-0 text-muted small">
                      Already have a Cheyn ID? <a href="#" class="apple-accent-link fw-semibold" id="switchToLogin">Sign in</a>
                    </p>
                  </div>
                </div>
              </div>

              <!-- REGISTER: STEP 2 (Email & Phone) -->
              <div class="apple-auth-step d-none" id="regStep2">
                <div class="text-center mb-4">
                  <h2 class="apple-hero-title">Contact Information</h2>
                  <p class="apple-hero-subtitle">Where can we send order updates and receipts?</p>
                </div>

                <div class="apple-step-body">
                  <div class="mb-3">
                    <label for="regEmail" class="apple-field-label">Email Address</label>
                    <div class="apple-input-box" id="regEmailBox">
                      <input type="email" class="apple-single-input" id="regEmail" autocomplete="email" required>
                    </div>
                    <div class="apple-field-error" id="regEmailError">Please enter a valid email address.</div>
                  </div>

                  <div class="mb-4">
                    <label for="regPhone" class="apple-field-label">Mobile Number <span class="text-muted fw-normal">(Optional)</span></label>
                    <div class="apple-input-box" id="regPhoneBox">
                      <input type="tel" class="apple-single-input" id="regPhone" autocomplete="tel">
                    </div>
                  </div>

                  <div class="d-flex align-items-center justify-content-between mt-4">
                    <button type="button" class="btn btn-link apple-back-text-btn p-0 text-decoration-none" id="regStep2Back">
                      <i class="bi bi-arrow-left me-1"></i> Back
                    </button>
                    <button type="button" class="btn btn-ct apple-step-pill-btn" id="regStep2Next">
                      Continue <i class="bi bi-arrow-right ms-1"></i>
                    </button>
                  </div>
                </div>
              </div>

              <!-- REGISTER: STEP 3 (Password & Terms) -->
              <div class="apple-auth-step d-none" id="regStep3">
                <div class="text-center mb-4">
                  <h2 class="apple-hero-title">Set your password</h2>
                  <p class="apple-hero-subtitle">Choose a secure password for your Cheyn ID.</p>
                </div>

                <div class="apple-step-body">
                  <div class="mb-3">
                    <label for="regPassword" class="apple-field-label">Password</label>
                    <div class="apple-input-box" id="regPasswordBox">
                      <input type="password" class="apple-single-input" id="regPassword" autocomplete="new-password" required minlength="8">
                      <button type="button" class="apple-eye-btn pass-toggle" id="regPassToggle" aria-label="Show password">
                        <i class="bi bi-eye" id="regPassIcon"></i>
                      </button>
                    </div>
                    <div class="apple-field-error" id="regPasswordError">Password must be at least 8 characters.</div>
                    <div class="form-text apple-form-help">Must be at least 8 characters.</div>
                  </div>

                  <div class="mb-3">
                    <label for="regConfirmPassword" class="apple-field-label">Confirm Password</label>
                    <div class="apple-input-box" id="regConfirmPasswordBox">
                      <input type="password" class="apple-single-input" id="regConfirmPassword" autocomplete="new-password" required>
                      <button type="button" class="apple-eye-btn pass-toggle" id="regConfirmPassToggle" aria-label="Show confirm password">
                        <i class="bi bi-eye" id="regConfirmPassIcon"></i>
                      </button>
                    </div>
                    <div class="apple-field-error" id="confirmPassError">Passwords do not match.</div>
                  </div>

                  <div class="form-check apple-terms-check mb-4">
                    <input class="form-check-input apple-checkbox" type="checkbox" id="agreeTerms" required>
                    <label class="form-check-label apple-check-label terms-label" for="agreeTerms">
                      I agree to the <a href="about.php" target="_blank" rel="noopener noreferrer" class="apple-accent-link">Terms and Conditions</a> &amp; <a href="about.php" target="_blank" rel="noopener noreferrer" class="apple-accent-link">Privacy Policy</a>
                    </label>
                    <div class="apple-field-error" id="agreeTermsError">You must agree to the Terms and Conditions.</div>
                  </div>

                  <div class="d-flex align-items-center justify-content-between mt-4">
                    <button type="button" class="btn btn-link apple-back-text-btn p-0 text-decoration-none" id="regStep3Back">
                      <i class="bi bi-arrow-left me-1"></i> Back
                    </button>
                    <button type="submit" class="btn btn-ct apple-step-pill-btn" id="regSubmitBtn">
                      <i class="bi bi-person-check me-2"></i>Create Account
                    </button>
                  </div>
                </div>
              </div>

            </form>
          </div>

        </div>
      </div>

    </div>
  </main>

  <!-- Apple Account Minimal Footer -->
  <footer class="apple-minimal-footer" role="contentinfo">
    <div class="container d-flex flex-column flex-md-row justify-content-between align-items-center gap-2 text-center text-md-start">
      <div class="apple-minimal-footer-links d-flex flex-wrap justify-content-center justify-content-md-start align-items-center gap-2 gap-md-3">
        <span>&copy; <?= date('Y') ?> Cheyn Gadgets. All rights reserved.</span>
        <a href="about.php">Privacy Policy</a>
        <a href="about.php">Terms of Use</a>
        <a href="contact.php">Store Support</a>
      </div>
      <p class="apple-minimal-footnote mb-0 text-center text-md-end">This website is for educational purposes only.</p>
    </div>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="<?= asset_url('assets/js/main.js') ?>"></script>
  <script src="<?= asset_url('assets/js/login.js') ?>"></script>
</body>
</html>
