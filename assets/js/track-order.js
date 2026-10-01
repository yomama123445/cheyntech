(function () {
  'use strict';

  /* ── Populate result with order data and dynamically render stepper ── */
  function showResult(data) {
    document.getElementById('resultOrderId').textContent = data.id;
    document.getElementById('resultProduct').innerHTML   = data.product;
    document.getElementById('resultDate').textContent    = data.date;

    // 1. Select all .order-stepper .step elements
    var steps = document.querySelectorAll('.order-stepper .step');
    var currentStep = Number(data.currentStep || 1);

    // 2. Given data.currentStep (1 = Pending, 2 = Processing, 3 = Ready/Delivery, 4 = Completed):
    //    • For index < currentStep - 1: set class step completed
    //    • For index === currentStep - 1: set class step active
    //    • For index > currentStep - 1: set class step
    steps.forEach(function (step, index) {
      if (index < currentStep - 1) {
        step.className = 'step completed';
        step.removeAttribute('aria-current');
        var circle = step.querySelector('.step-circle');
        if (circle) circle.setAttribute('aria-label', 'Completed');
      } else if (index === currentStep - 1) {
        step.className = 'step active';
        step.setAttribute('aria-current', 'step');
        var circle = step.querySelector('.step-circle');
        if (circle) circle.setAttribute('aria-label', 'Current step');
      } else {
        step.className = 'step';
        step.removeAttribute('aria-current');
        var circle = step.querySelector('.step-circle');
        if (circle) circle.setAttribute('aria-label', 'Pending');
      }
    });

    // 3. Update the .result-status-badge element's inner text and icon to reflect data.status and data.badgeIcon
    var badgeEl = document.querySelector('.result-status-badge') || document.querySelector('.order-info-badge');
    if (badgeEl) {
      var icon = data.badgeIcon || data.statusBadgeIcon || 'bi-bag-check-fill';
      var statusText = data.status || data.statusLabel || 'Processing';
      badgeEl.innerHTML = '<i class="bi ' + icon + ' me-1"></i>' + statusText;
    }

    var resultEl   = document.getElementById('trackResult');
    var notFoundEl = document.getElementById('trackNotFound');
    var infoCards  = document.getElementById('trackInfoCards');

    if (notFoundEl) notFoundEl.classList.add('d-none');
    if (resultEl)   resultEl.classList.remove('d-none');
    if (infoCards)  infoCards.classList.add('d-none');

    // 4. In main.js, re-run initStepper() so the progress bar fill line updates to the correct width percentage
    if (typeof window.initStepper === 'function') {
      window.initStepper();
    } else if (typeof initStepper === 'function') {
      initStepper();
    }

    // Smooth scroll to result
    setTimeout(function () {
      resultEl.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }, 80);
  }

  /* ── Show clean alert card when order is not found ── */
  function showNotFound(orderId) {
    var resultEl   = document.getElementById('trackResult');
    var notFoundEl = document.getElementById('trackNotFound');
    var notFoundId = document.getElementById('notFoundOrderId');
    var infoCards  = document.getElementById('trackInfoCards');

    if (resultEl)   resultEl.classList.add('d-none');
    if (notFoundId) notFoundId.textContent = orderId ? orderId : 'the ID and email entered';
    if (notFoundEl) {
      notFoundEl.classList.remove('d-none');
      setTimeout(function () {
        notFoundEl.scrollIntoView({ behavior: 'smooth', block: 'start' });
      }, 80);
    }
    if (infoCards) infoCards.classList.remove('d-none');
  }

  /* ── Perform order tracking query against API ── */
  function performTrack(orderId, email) {
    var errEl      = document.getElementById('trackError');
    var notFoundEl = document.getElementById('trackNotFound');
    var resultEl   = document.getElementById('trackResult');

    if (errEl)      errEl.style.display = 'none';
    if (notFoundEl) notFoundEl.classList.add('d-none');

    var queryUrl = 'api/orders/track.php?id=' + encodeURIComponent(orderId) + '&email=' + encodeURIComponent(email);

    fetch(queryUrl)
      .then(function (res) {
        if (res.status === 404) return null;
        return res.json();
      })
      .then(function (data) {
        if (data && data.success) {
          showResult({
            id:              data.orderNumber,
            product:         data.productLine || 'Ordered Gadget',
            date:            data.date,
            status:          data.statusLabel,
            badgeIcon:       data.badgeIcon || 'bi-bag-check-fill',
            statusBadgeIcon: data.badgeIcon || 'bi-bag-check-fill',
            currentStep:     data.currentStep || 1
          });
        } else {
          showNotFound(orderId);
        }
      })
      .catch(function () {
        showNotFound(orderId);
      });
  }

  /* ── Track form handler ── */
  function initTrackForm() {
    var form       = document.getElementById('trackForm');
    var input      = document.getElementById('trackInput');
    var emailInput = document.getElementById('trackEmail');
    var errEl      = document.getElementById('trackError');
    var notFoundEl = document.getElementById('trackNotFound');

    if (errEl) errEl.style.display = 'none';

    // Pre-fill from sessionStorage (after checkout redirect)
    try {
      var lastOrder = sessionStorage.getItem('ct_last_order');
      var lastEmail = sessionStorage.getItem('ct_last_email');
      if (lastOrder && input)      { input.value = lastOrder; }
      if (lastEmail && emailInput) { emailInput.value = lastEmail; }
    } catch (e) {}

    if (form) {
      form.addEventListener('submit', function (e) {
        e.preventDefault();
        var val   = (input ? input.value : '').trim().toUpperCase();
        var email = (emailInput ? emailInput.value : '').trim();

        if (errEl)      errEl.style.display = 'none';
        if (notFoundEl) notFoundEl.classList.add('d-none');

        if (!val || !email) {
          if (errEl) {
            errEl.style.display = 'block';
            errEl.innerHTML = '<i class="bi bi-exclamation-circle me-1"></i>Please enter both your Order ID (e.g. CT-10493) and checkout email.';
          }
          if (!val && input) {
            input.focus();
          } else if (emailInput) {
            emailInput.focus();
          }
          return;
        }

        performTrack(val, email);
      });
    }
  }

  document.addEventListener('DOMContentLoaded', function () {
    initTrackForm();

    // Check URL parameters first (?id= or ?order= and ?email=)
    var params = new URLSearchParams(window.location.search);
    var queryOrder = params.get('id') || params.get('order');
    var queryEmail = params.get('email');

    var inputEl = document.getElementById('trackInput');
    var emailEl = document.getElementById('trackEmail');

    if (queryOrder && inputEl) {
      inputEl.value = queryOrder.trim().toUpperCase();
    }
    if (queryEmail && emailEl) {
      emailEl.value = queryEmail.trim();
    }

    if (queryOrder && queryEmail) {
      performTrack(queryOrder.trim().toUpperCase(), queryEmail.trim());
      return;
    }

    // Auto-show result if last order and email stored from checkout
    try {
      var lastOrder = sessionStorage.getItem('ct_last_order');
      var lastEmail = sessionStorage.getItem('ct_last_email');
      if (lastOrder && lastEmail) {
        if (inputEl) inputEl.value = lastOrder;
        if (emailEl) emailEl.value = lastEmail;
        performTrack(lastOrder, lastEmail);
      }
    } catch (e) {}
  });

})();
