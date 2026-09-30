(function () {
      'use strict';

      // Activate tab from hash
      function activateTabFromHash() {
        if (window.location.hash === '#register') {
          bootstrap.Tab.getOrCreateInstance(document.getElementById('register-tab')).show();
        }
      }
      activateTabFromHash();
      window.addEventListener('hashchange', activateTabFromHash);

      // Cross-link tab switches
      document.getElementById('switchToRegister').addEventListener('click', function (e) {
        e.preventDefault();
        bootstrap.Tab.getOrCreateInstance(document.getElementById('register-tab')).show();
        history.replaceState(null, '', '#register');
      });
      document.getElementById('switchToLogin').addEventListener('click', function (e) {
        e.preventDefault();
        bootstrap.Tab.getOrCreateInstance(document.getElementById('login-tab')).show();
        history.replaceState(null, '', window.location.pathname);
      });

      // Password toggle helper
      function wirePassToggle(btnId, inputId, iconId) {
        var btn = document.getElementById(btnId);
        var inp = document.getElementById(inputId);
        var ico = document.getElementById(iconId);
        if (!btn) return;
        btn.addEventListener('click', function () {
          var isPass = inp.type === 'password';
          inp.type = isPass ? 'text' : 'password';
          ico.className = isPass ? 'bi bi-eye-slash' : 'bi bi-eye';
          btn.setAttribute('aria-label', isPass ? 'Hide password' : 'Show password');
          inp.focus();
        });
      }
      wirePassToggle('loginPassToggle', 'loginPassword', 'loginPassIcon');
      wirePassToggle('regPassToggle', 'regPassword', 'regPassIcon');
      wirePassToggle('regConfirmPassToggle', 'regConfirmPassword', 'regConfirmPassIcon');

      // Login form
      var loginForm = document.getElementById('loginForm');
      loginForm.addEventListener('submit', function (e) {
        e.preventDefault();
        if (!loginForm.checkValidity()) { loginForm.classList.add('was-validated'); return; }

        var email = document.getElementById('loginEmail').value.trim();
        var password = document.getElementById('loginPassword').value;
        var submitBtn = loginForm.querySelector('button[type="submit"]');
        var originalText = submitBtn.innerHTML;

        submitBtn.disabled = true;
        submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Logging in…';

        fetch('api/auth/login.php', {
          method: 'POST',
          headers: { 'Content-Type': 'application/json', 'Accept': 'application/json' },
          body: JSON.stringify({ email: email, password: password })
        })
        .then(function(res) { return res.json(); })
        .then(function(data) {
          if (data.success) {
            showToast('Welcome back, ' + data.user.name + '!', 'success');
            setTimeout(function() {
              if (data.user.role === 'admin') {
                window.location.href = 'admin/dashboard.php';
              } else {
                window.location.href = 'index.php';
              }
            }, 800);
          } else {
            showToast(data.error || 'Login failed. Please check your credentials.', 'error');
            submitBtn.disabled = false;
            submitBtn.innerHTML = originalText;
          }
        })
        .catch(function() {
          showToast('Could not reach authentication server. Check database configuration.', 'error');
          submitBtn.disabled = false;
          submitBtn.innerHTML = originalText;
        });
      });

      // Register form
      var registerForm = document.getElementById('registerForm');
      registerForm.addEventListener('submit', function (e) {
        e.preventDefault();
        var pass = document.getElementById('regPassword').value;
        var conf = document.getElementById('regConfirmPassword');
        if (pass !== conf.value) {
          conf.setCustomValidity('Passwords do not match.');
        } else {
          conf.setCustomValidity('');
        }
        if (!registerForm.checkValidity()) { registerForm.classList.add('was-validated'); return; }

        var name = document.getElementById('regName').value.trim();
        var email = document.getElementById('regEmail').value.trim();
        var phone = document.getElementById('regPhone').value.trim();
        var submitBtn = registerForm.querySelector('button[type="submit"]');
        var originalText = submitBtn.innerHTML;

        submitBtn.disabled = true;
        submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Creating account…';

        fetch('api/auth/register.php', {
          method: 'POST',
          headers: { 'Content-Type': 'application/json', 'Accept': 'application/json' },
          body: JSON.stringify({ name: name, email: email, password: pass, phone: phone })
        })
        .then(function(res) { return res.json(); })
        .then(function(data) {
          if (data.success) {
            showToast('Account created successfully! Welcome to Cheyn Gadgets.', 'success');
            setTimeout(function() {
              window.location.href = 'index.php';
            }, 1000);
          } else {
            showToast(data.error || 'Registration failed.', 'error');
            submitBtn.disabled = false;
            submitBtn.innerHTML = originalText;
          }
        })
        .catch(function() {
          showToast('Could not connect to server. Check database configuration.', 'error');
          submitBtn.disabled = false;
          submitBtn.innerHTML = originalText;
        });
      });

      document.getElementById('regConfirmPassword').addEventListener('input', function () {
        this.setCustomValidity('');
      });
    })();
