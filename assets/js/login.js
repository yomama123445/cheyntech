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
        history.replaceState(null, '', window.location.pathname + window.location.search);
      });

      // Keep URL hash in sync on direct tab click
      document.getElementById('register-tab')?.addEventListener('shown.bs.tab', function () {
        if (window.location.hash !== '#register') {
          history.replaceState(null, '', '#register');
        }
      });
      document.getElementById('login-tab')?.addEventListener('shown.bs.tab', function () {
        if (window.location.hash) {
          history.replaceState(null, '', window.location.pathname + window.location.search);
        }
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

      // Safe toast helper
      function notify(msg, type) {
        if (typeof showToast === 'function') {
          showToast(msg, type);
        } else {
          console.log('[' + (type || 'info') + '] ' + msg);
        }
      }

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

        var csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;

        fetch('api/auth/login.php', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-CSRF-Token': csrfToken || ''
          },
          body: JSON.stringify({ email: email, password: password })
        })
        .then(function(res) { return res.json(); })
        .then(function(data) {
          if (data && data.success) {
            var userName = (data.user && data.user.name) ? data.user.name : '';
            notify('Welcome back' + (userName ? ', ' + userName : '') + '!', 'success');
            var target = (data.user && data.user.role === 'admin') ? 'admin/dashboard.php' : 'index.php';
            setTimeout(function() {
              window.location.href = target;
            }, 600);
          } else {
            notify((data && data.error) || 'Login failed. Please check your credentials.', 'error');
            submitBtn.disabled = false;
            submitBtn.innerHTML = originalText;
          }
        })
        .catch(function() {
          notify('Could not reach authentication server. Check database configuration.', 'error');
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

        var csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;

        fetch('api/auth/register.php', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-CSRF-Token': csrfToken || ''
          },
          body: JSON.stringify({ name: name, email: email, password: pass, phone: phone })
        })
        .then(function(res) { return res.json(); })
        .then(function(data) {
          if (data && data.success) {
            notify('Account created successfully! Welcome to Cheyn Gadgets.', 'success');
            setTimeout(function() {
              window.location.href = 'index.php';
            }, 600);
          } else {
            notify((data && data.error) || 'Registration failed.', 'error');
            submitBtn.disabled = false;
            submitBtn.innerHTML = originalText;
          }
        })
        .catch(function() {
          notify('Could not connect to server. Check database configuration.', 'error');
          submitBtn.disabled = false;
          submitBtn.innerHTML = originalText;
        });
      });

      document.getElementById('regConfirmPassword').addEventListener('input', function () {
        this.setCustomValidity('');
      });
    })();
