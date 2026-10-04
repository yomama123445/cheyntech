(function () {
  'use strict';

  // --- Safe toast helper ---
  function notify(msg, type) {
    if (typeof showToast === 'function') {
      showToast(msg, type);
    } else {
      console.log('[' + (type || 'info') + '] ' + msg);
    }
  }

  // --- Element shake animation helper ---
  function shakeElement(el) {
    if (!el) return;
    el.classList.remove('apple-shake');
    void el.offsetWidth; // trigger reflow
    el.classList.add('apple-shake');
    el.classList.add('is-invalid');
    setTimeout(function () {
      el.classList.remove('apple-shake');
    }, 400);
  }

  // --- Email regex validator ---
  function isValidEmail(email) {
    return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
  }

  // ============================================================
  // TAB NAVIGATION & HASH SYNCHRONIZATION
  // ============================================================
  function resetLoginForm() {
    var step1 = document.getElementById('loginStep1');
    var step2 = document.getElementById('loginStep2');
    if (step1 && step2) {
      step1.classList.remove('d-none');
      step2.classList.add('d-none');
    }
    document.getElementById('loginEmailError')?.style.setProperty('display', 'none');
    document.getElementById('loginPasswordError')?.style.setProperty('display', 'none');
    document.getElementById('loginEmailBox')?.classList.remove('is-invalid');
    document.getElementById('loginPasswordBox')?.classList.remove('is-invalid');
  }

  function resetRegisterForm() {
    var s1 = document.getElementById('regStep1');
    var s2 = document.getElementById('regStep2');
    var s3 = document.getElementById('regStep3');
    if (s1 && s2 && s3) {
      s1.classList.remove('d-none');
      s2.classList.add('d-none');
      s3.classList.add('d-none');
    }
    document.getElementById('regDot1')?.classList.add('active');
    document.getElementById('regDot2')?.classList.remove('active');
    document.getElementById('regDot3')?.classList.remove('active');

    ['regNameError', 'regEmailError', 'regPasswordError', 'confirmPassError', 'agreeTermsError'].forEach(function(id) {
      var err = document.getElementById(id);
      if (err) err.style.display = 'none';
    });
    ['regNameBox', 'regEmailBox', 'regPasswordBox', 'regConfirmPasswordBox'].forEach(function(id) {
      document.getElementById(id)?.classList.remove('is-invalid');
    });
  }

  function switchAuthTab(targetTabId) {
    var isRegister = targetTabId === 'register-tab';
    var loginPane = document.getElementById('loginPane');
    var registerPane = document.getElementById('registerPane');
    var loginTab = document.getElementById('login-tab');
    var registerTab = document.getElementById('register-tab');

    if (isRegister) {
      loginTab?.classList.remove('active');
      loginTab?.setAttribute('aria-selected', 'false');
      registerTab?.classList.add('active');
      registerTab?.setAttribute('aria-selected', 'true');

      loginPane?.classList.remove('active', 'show');
      registerPane?.classList.add('active', 'show');
      resetRegisterForm();
      if (window.location.hash !== '#register') {
        history.replaceState(null, '', '#register');
      }
      setTimeout(function () { document.getElementById('regName')?.focus(); }, 80);
    } else {
      registerTab?.classList.remove('active');
      registerTab?.setAttribute('aria-selected', 'false');
      loginTab?.classList.add('active');
      loginTab?.setAttribute('aria-selected', 'true');

      registerPane?.classList.remove('active', 'show');
      loginPane?.classList.add('active', 'show');
      resetLoginForm();
      if (window.location.hash) {
        history.replaceState(null, '', window.location.pathname + window.location.search);
      }
      setTimeout(function () { document.getElementById('loginEmail')?.focus(); }, 80);
    }
  }

  function activateTabFromHash() {
    if (window.location.hash === '#register') {
      switchAuthTab('register-tab');
    }
  }

  document.getElementById('register-tab')?.addEventListener('click', function (e) {
    e.preventDefault();
    switchAuthTab('register-tab');
  });

  document.getElementById('login-tab')?.addEventListener('click', function (e) {
    e.preventDefault();
    switchAuthTab('login-tab');
  });

  document.getElementById('switchToRegister')?.addEventListener('click', function (e) {
    e.preventDefault();
    switchAuthTab('register-tab');
  });

  document.getElementById('switchToLogin')?.addEventListener('click', function (e) {
    e.preventDefault();
    switchAuthTab('login-tab');
  });

  activateTabFromHash();
  window.addEventListener('hashchange', activateTabFromHash);

  // ============================================================
  // PASSWORD VISIBILITY TOGGLES
  // ============================================================
  function wirePassToggle(btnId, inputId, iconId) {
    var btn = document.getElementById(btnId);
    var inp = document.getElementById(inputId);
    var ico = document.getElementById(iconId);
    if (!btn || !inp || !ico) return;
    btn.addEventListener('click', function (e) {
      e.preventDefault();
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

  // ============================================================
  // SIGN IN: STEPPED ONE-AT-A-TIME FLOW
  // ============================================================
  var loginStep1 = document.getElementById('loginStep1');
  var loginStep2 = document.getElementById('loginStep2');
  var loginEmailInput = document.getElementById('loginEmail');
  var loginPasswordInput = document.getElementById('loginPassword');
  var loginEmailBox = document.getElementById('loginEmailBox');
  var loginPasswordBox = document.getElementById('loginPasswordBox');
  var loginEmailError = document.getElementById('loginEmailError');
  var loginPasswordError = document.getElementById('loginPasswordError');
  var loginEmailDisplay = document.getElementById('loginEmailDisplay');

  function goToLoginStep2() {
    var email = (loginEmailInput?.value || '').trim();
    if (!email || !isValidEmail(email)) {
      if (loginEmailError) loginEmailError.style.display = 'block';
      shakeElement(loginEmailBox);
      loginEmailInput?.focus();
      return false;
    }
    if (loginEmailError) loginEmailError.style.display = 'none';
    loginEmailBox?.classList.remove('is-invalid');
    if (loginEmailDisplay) loginEmailDisplay.textContent = email;

    loginStep1?.classList.add('d-none');
    loginStep2?.classList.remove('d-none');
    setTimeout(function () {
      loginPasswordInput?.focus();
    }, 100);
    return true;
  }

  function goToLoginStep1() {
    loginStep2?.classList.add('d-none');
    loginStep1?.classList.remove('d-none');
    setTimeout(function () {
      loginEmailInput?.focus();
      loginEmailInput?.select();
    }, 100);
  }

  document.getElementById('loginContinueBtn')?.addEventListener('click', goToLoginStep2);

  loginEmailInput?.addEventListener('keydown', function (e) {
    if (e.key === 'Enter') {
      e.preventDefault();
      goToLoginStep2();
    }
  });

  loginEmailInput?.addEventListener('input', function () {
    if (loginEmailError) loginEmailError.style.display = 'none';
    loginEmailBox?.classList.remove('is-invalid');
  });

  document.getElementById('loginBackBtn')?.addEventListener('click', goToLoginStep1);
  document.getElementById('loginBackToEmail')?.addEventListener('click', goToLoginStep1);

  loginPasswordInput?.addEventListener('input', function () {
    if (loginPasswordError) loginPasswordError.style.display = 'none';
    loginPasswordBox?.classList.remove('is-invalid');
  });

  // Login Form Submission
  var loginForm = document.getElementById('loginForm');
  loginForm?.addEventListener('submit', function (e) {
    e.preventDefault();

    // If still on step 1, proceed to step 2 first
    if (loginStep1 && !loginStep1.classList.contains('d-none')) {
      goToLoginStep2();
      return;
    }

    var email = (loginEmailInput?.value || '').trim();
    var password = loginPasswordInput?.value || '';

    if (!password) {
      if (loginPasswordError) {
        loginPasswordError.textContent = 'Please enter your password.';
        loginPasswordError.style.display = 'block';
      }
      shakeElement(loginPasswordBox);
      loginPasswordInput?.focus();
      return;
    }

    var submitBtn = document.getElementById('loginSubmitBtn') || loginForm.querySelector('button[type="submit"]');
    var originalHtml = submitBtn.innerHTML;
    submitBtn.disabled = true;
    submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm"></span>';

    var csrfToken = document.querySelector('meta[name="csrf-token"]')?.content || '';

    fetch('api/auth/login.php', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json',
        'X-CSRF-Token': csrfToken
      },
      body: JSON.stringify({ email: email, password: password })
    })
    .then(function (res) { return res.json(); })
    .then(function (data) {
      if (data && data.success) {
        var userName = (data.user && data.user.name) ? data.user.name : '';
        notify('Welcome back' + (userName ? ', ' + userName : '') + '!', 'success');
        var target = (data.user && data.user.role === 'admin') ? 'admin/dashboard.php' : 'index.php';
        setTimeout(function () {
          window.location.href = target;
        }, 600);
      } else {
        var errMsg = (data && data.error) || 'Invalid email or password. Please try again.';
        if (loginPasswordError) {
          loginPasswordError.textContent = errMsg;
          loginPasswordError.style.display = 'block';
        }
        shakeElement(loginPasswordBox);
        notify(errMsg, 'error');
        submitBtn.disabled = false;
        submitBtn.innerHTML = originalHtml;
        loginPasswordInput?.focus();
        loginPasswordInput?.select();
      }
    })
    .catch(function () {
      notify('Could not reach authentication server. Check database configuration.', 'error');
      submitBtn.disabled = false;
      submitBtn.innerHTML = originalHtml;
    });
  });

  // ============================================================
  // CREATE ACCOUNT: STEPPED PROGRESSION
  // ============================================================
  var regStep1 = document.getElementById('regStep1');
  var regStep2 = document.getElementById('regStep2');
  var regStep3 = document.getElementById('regStep3');

  var regDot1 = document.getElementById('regDot1');
  var regDot2 = document.getElementById('regDot2');
  var regDot3 = document.getElementById('regDot3');

  var regNameInput = document.getElementById('regName');
  var regEmailInput = document.getElementById('regEmail');
  var regPhoneInput = document.getElementById('regPhone');
  var regPasswordInput = document.getElementById('regPassword');
  var regConfirmPasswordInput = document.getElementById('regConfirmPassword');
  var agreeTermsCheck = document.getElementById('agreeTerms');

  var regNameBox = document.getElementById('regNameBox');
  var regEmailBox = document.getElementById('regEmailBox');
  var regPasswordBox = document.getElementById('regPasswordBox');
  var regConfirmPasswordBox = document.getElementById('regConfirmPasswordBox');

  var regNameError = document.getElementById('regNameError');
  var regEmailError = document.getElementById('regEmailError');
  var regPasswordError = document.getElementById('regPasswordError');
  var confirmPassError = document.getElementById('confirmPassError');
  var agreeTermsError = document.getElementById('agreeTermsError');

  // Step 1 -> Step 2
  function goToRegStep2() {
    var name = (regNameInput?.value || '').trim();
    if (!name || name.length < 2) {
      if (regNameError) regNameError.style.display = 'block';
      shakeElement(regNameBox);
      regNameInput?.focus();
      return false;
    }
    if (regNameError) regNameError.style.display = 'none';
    regNameBox?.classList.remove('is-invalid');

    regStep1?.classList.add('d-none');
    regStep2?.classList.remove('d-none');
    regDot1?.classList.remove('active');
    regDot2?.classList.add('active');
    setTimeout(function () { regEmailInput?.focus(); }, 100);
    return true;
  }

  document.getElementById('regStep1Next')?.addEventListener('click', goToRegStep2);
  regNameInput?.addEventListener('keydown', function (e) {
    if (e.key === 'Enter') {
      e.preventDefault();
      goToRegStep2();
    }
  });
  regNameInput?.addEventListener('input', function () {
    if (regNameError) regNameError.style.display = 'none';
    regNameBox?.classList.remove('is-invalid');
  });

  // Step 2 -> Step 1
  document.getElementById('regStep2Back')?.addEventListener('click', function () {
    regStep2?.classList.add('d-none');
    regStep1?.classList.remove('d-none');
    regDot2?.classList.remove('active');
    regDot1?.classList.add('active');
    setTimeout(function () { regNameInput?.focus(); }, 100);
  });

  // Step 2 -> Step 3
  function goToRegStep3() {
    var email = (regEmailInput?.value || '').trim();
    if (!email || !isValidEmail(email)) {
      if (regEmailError) regEmailError.style.display = 'block';
      shakeElement(regEmailBox);
      regEmailInput?.focus();
      return false;
    }
    if (regEmailError) regEmailError.style.display = 'none';
    regEmailBox?.classList.remove('is-invalid');

    regStep2?.classList.add('d-none');
    regStep3?.classList.remove('d-none');
    regDot2?.classList.remove('active');
    regDot3?.classList.add('active');
    setTimeout(function () { regPasswordInput?.focus(); }, 100);
    return true;
  }

  document.getElementById('regStep2Next')?.addEventListener('click', goToRegStep3);
  regEmailInput?.addEventListener('keydown', function (e) {
    if (e.key === 'Enter') {
      e.preventDefault();
      goToRegStep3();
    }
  });
  regPhoneInput?.addEventListener('keydown', function (e) {
    if (e.key === 'Enter') {
      e.preventDefault();
      goToRegStep3();
    }
  });
  regEmailInput?.addEventListener('input', function () {
    if (regEmailError) regEmailError.style.display = 'none';
    regEmailBox?.classList.remove('is-invalid');
  });

  // Step 3 -> Step 2
  document.getElementById('regStep3Back')?.addEventListener('click', function () {
    regStep3?.classList.add('d-none');
    regStep2?.classList.remove('d-none');
    regDot3?.classList.remove('active');
    regDot2?.classList.add('active');
    setTimeout(function () { regEmailInput?.focus(); }, 100);
  });

  regPasswordInput?.addEventListener('input', function () {
    if (regPasswordError) regPasswordError.style.display = 'none';
    regPasswordBox?.classList.remove('is-invalid');
  });
  regConfirmPasswordInput?.addEventListener('input', function () {
    if (confirmPassError) confirmPassError.style.display = 'none';
    regConfirmPasswordBox?.classList.remove('is-invalid');
  });
  agreeTermsCheck?.addEventListener('change', function () {
    if (agreeTermsError) agreeTermsError.style.display = 'none';
  });

  // Register Form Submission
  var registerForm = document.getElementById('registerForm');
  registerForm?.addEventListener('submit', function (e) {
    e.preventDefault();

    // Check if on earlier step
    if (regStep1 && !regStep1.classList.contains('d-none')) {
      goToRegStep2();
      return;
    }
    if (regStep2 && !regStep2.classList.contains('d-none')) {
      goToRegStep3();
      return;
    }

    var pass = regPasswordInput?.value || '';
    var conf = regConfirmPasswordInput?.value || '';
    var hasError = false;

    if (pass.length < 8) {
      if (regPasswordError) regPasswordError.style.display = 'block';
      shakeElement(regPasswordBox);
      if (!hasError) regPasswordInput?.focus();
      hasError = true;
    }

    if (pass !== conf) {
      if (confirmPassError) confirmPassError.style.display = 'block';
      shakeElement(regConfirmPasswordBox);
      if (!hasError) regConfirmPasswordInput?.focus();
      hasError = true;
    }

    if (!agreeTermsCheck?.checked) {
      if (agreeTermsError) agreeTermsError.style.display = 'block';
      hasError = true;
    }

    if (hasError) return;

    var name = (regNameInput?.value || '').trim();
    var email = (regEmailInput?.value || '').trim();
    var phone = (regPhoneInput?.value || '').trim();
    var submitBtn = document.getElementById('regSubmitBtn') || registerForm.querySelector('button[type="submit"]');
    var originalHtml = submitBtn.innerHTML;

    submitBtn.disabled = true;
    submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Creating account…';

    var csrfToken = document.querySelector('meta[name="csrf-token"]')?.content || '';

    fetch('api/auth/register.php', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json',
        'X-CSRF-Token': csrfToken
      },
      body: JSON.stringify({ name: name, email: email, password: pass, phone: phone })
    })
    .then(function (res) { return res.json(); })
    .then(function (data) {
      if (data && data.success) {
        notify('Account created successfully! Welcome to Cheyn Gadgets.', 'success');
        setTimeout(function () {
          window.location.href = 'index.php';
        }, 600);
      } else {
        var msg = (data && data.error) || 'Registration failed.';
        notify(msg, 'error');
        if (msg.toLowerCase().includes('email')) {
          // Go back to email step if email already registered
          regStep3?.classList.add('d-none');
          regStep2?.classList.remove('d-none');
          regDot3?.classList.remove('active');
          regDot2?.classList.add('active');
          if (regEmailError) {
            regEmailError.textContent = msg;
            regEmailError.style.display = 'block';
          }
          shakeElement(regEmailBox);
          regEmailInput?.focus();
        }
        submitBtn.disabled = false;
        submitBtn.innerHTML = originalHtml;
      }
    })
    .catch(function () {
      notify('Could not connect to server. Check database configuration.', 'error');
      submitBtn.disabled = false;
      submitBtn.innerHTML = originalHtml;
    });
  });

})();
