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
$pageTitle       = 'Log In / Register | Cheyn Gadgets';
$pageDescription = 'Log in or create your Cheyn Gadgets account to start shopping for gadgets.';
$activePage      = 'login';
require 'includes/header.php';
?>

  <main class="auth-wrapper">
    <div class="text-center mb-4">
      <h1 class="h4 fw-bold mb-0">Welcome to Cheyn Gadgets</h1>
      <p class="text-muted small mt-1">Your trusted gadget store in Roxas City</p>
    </div>

    <div class="auth-card">
      <div class="auth-tabs">
        <ul class="nav nav-tabs" id="authTabs" role="tablist">
          <li class="nav-item" role="presentation">
            <button class="nav-link active" id="login-tab" data-bs-toggle="tab" data-bs-target="#loginPane" type="button" role="tab" aria-controls="loginPane" aria-selected="true">
              <i class="bi bi-box-arrow-in-right me-1"></i>Log In
            </button>
          </li>
          <li class="nav-item" role="presentation">
            <button class="nav-link" id="register-tab" data-bs-toggle="tab" data-bs-target="#registerPane" type="button" role="tab" aria-controls="registerPane" aria-selected="false">
              <i class="bi bi-person-plus me-1"></i>Register
            </button>
          </li>
        </ul>

        <div class="tab-content">
          <!-- LOG IN PANE -->
          <div class="tab-pane fade show active" id="loginPane" role="tabpanel" aria-labelledby="login-tab">
            <div class="auth-card-body">
              <h2 class="h5 fw-bold mb-1">Log In to Your Account</h2>
              <p class="text-muted small mb-4">Enter your credentials to continue.</p>
              <form id="loginForm" novalidate>
                <div class="mb-3">
                  <label for="loginEmail" class="form-label fw-semibold">Email Address</label>
                  <input type="email" class="form-control" id="loginEmail" placeholder="you@email.com" autocomplete="email" required>
                  <div class="invalid-feedback">Please enter a valid email address.</div>
                </div>
                <div class="mb-3">
                  <label for="loginPassword" class="form-label fw-semibold">Password</label>
                  <div class="input-group">
                    <input type="password" class="form-control border-end-0" id="loginPassword" placeholder="Enter your password" autocomplete="current-password" required>
                    <button class="btn btn-outline-secondary pass-toggle" type="button" id="loginPassToggle" aria-label="Show password">
                      <i class="bi bi-eye" id="loginPassIcon"></i>
                    </button>
                  </div>
                  <div class="invalid-feedback">Please enter your password.</div>
                </div>
                <div class="d-flex align-items-center justify-content-between mb-4">
                  <div class="form-check mb-0">
                    <input class="form-check-input" type="checkbox" id="rememberMe">
                    <label class="form-check-label small" for="rememberMe">Remember me</label>
                  </div>
                  <a href="contact.php?product=Password+Reset+Request" class="forgot-link">Forgot your password?</a>
                </div>
                <div class="d-grid mb-3">
                  <button type="submit" class="btn btn-ct btn-lg"><i class="bi bi-box-arrow-in-right me-2"></i>Log In</button>
                </div>
                <p class="text-center text-muted small mb-0">
                  Don't have an account? <a href="#" class="forgot-link fw-semibold" id="switchToRegister">Create one</a>
                </p>
              </form>
            </div>
          </div>

          <!-- REGISTER PANE -->
          <div class="tab-pane fade" id="registerPane" role="tabpanel" aria-labelledby="register-tab">
            <div class="auth-card-body">
              <h2 class="h5 fw-bold mb-1">Create an Account</h2>
              <p class="text-muted small mb-4">Join Cheyn Gadgets and start shopping today.</p>
              <form id="registerForm" novalidate>
                <div class="mb-3">
                  <label for="regName" class="form-label fw-semibold">Full Name</label>
                  <input type="text" class="form-control" id="regName" placeholder="Juan dela Cruz" autocomplete="name" required>
                  <div class="invalid-feedback">Please enter your full name.</div>
                </div>
                <div class="mb-3">
                  <label for="regEmail" class="form-label fw-semibold">Email Address</label>
                  <input type="email" class="form-control" id="regEmail" placeholder="you@email.com" autocomplete="email" required>
                  <div class="invalid-feedback">Please enter a valid email address.</div>
                </div>
                <div class="mb-3">
                  <label for="regPhone" class="form-label fw-semibold">Phone Number</label>
                  <input type="tel" class="form-control" id="regPhone" placeholder="09XX-XXX-XXXX" autocomplete="tel">
                </div>
                <div class="mb-3">
                  <label for="regPassword" class="form-label fw-semibold">Password</label>
                  <div class="input-group">
                    <input type="password" class="form-control border-end-0" id="regPassword" placeholder="Create a strong password" autocomplete="new-password" required minlength="8">
                    <button class="btn btn-outline-secondary pass-toggle" type="button" id="regPassToggle" aria-label="Show password">
                      <i class="bi bi-eye" id="regPassIcon"></i>
                    </button>
                  </div>
                  <div class="invalid-feedback">Password must be at least 8 characters.</div>
                  <div class="form-text">Minimum 8 characters.</div>
                </div>
                <div class="mb-3">
                  <label for="regConfirmPassword" class="form-label fw-semibold">Confirm Password</label>
                  <div class="input-group">
                    <input type="password" class="form-control border-end-0" id="regConfirmPassword" placeholder="Re-enter your password" autocomplete="new-password" required>
                    <button class="btn btn-outline-secondary pass-toggle" type="button" id="regConfirmPassToggle" aria-label="Show confirm password">
                      <i class="bi bi-eye" id="regConfirmPassIcon"></i>
                    </button>
                  </div>
                  <div class="invalid-feedback" id="confirmPassError">Passwords do not match.</div>
                </div>
                <div class="form-check mb-4">
                  <input class="form-check-input" type="checkbox" id="agreeTerms" required>
                  <label class="form-check-label small terms-label" for="agreeTerms">
                    I agree to the <a href="about.php" target="_blank" rel="noopener noreferrer">Terms and Conditions</a>
                  </label>
                  <div class="invalid-feedback">You must agree to the Terms and Conditions.</div>
                </div>
                <div class="d-grid mb-3">
                  <button type="submit" class="btn btn-ct btn-lg"><i class="bi bi-person-check me-2"></i>Create Account</button>
                </div>
                <p class="text-center text-muted small mb-0">
                  Already have an account? <a href="#" class="forgot-link fw-semibold" id="switchToLogin">Log in</a>
                </p>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>

  </main>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="assets/js/main.js"></script>
  <script src="assets/js/login.js"></script>
</body>
</html>
