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
        alert('Login submitted! (Backend integration pending)');
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
        alert('Account created! (Backend integration pending)');
      });

      document.getElementById('regConfirmPassword').addEventListener('input', function () {
        this.setCustomValidity('');
      });
    })();
