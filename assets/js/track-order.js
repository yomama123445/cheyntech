(function () {
    'use strict';

    /* ── Sample order data map (keyed by order ID) ── */
    var ORDERS = {
      'CT-10493': {
        id:        'CT-10493',
        product:   'iPhone 13 Pro &ndash; 128GB &bull; Pickup at Cheyn Gadgets Store',
        date:      'August 12, 2026',
        status:    'Ready for Pickup',
        statusBadgeIcon: 'bi-bag-check'
      }
    };

    /* ── Populate result with order data ── */
    function showResult(data) {
      document.getElementById('resultOrderId').textContent  = data.id;
      document.getElementById('resultProduct').innerHTML    = data.product;
      document.getElementById('resultDate').textContent     = data.date;

      var resultEl = document.getElementById('trackResult');
      var infoCards = document.getElementById('trackInfoCards');

      resultEl.classList.remove('d-none');
      infoCards.classList.add('d-none');

      // Smooth scroll to result
      setTimeout(function() {
        resultEl.scrollIntoView({ behavior: 'smooth', block: 'start' });
      }, 80);

      // Re-run stepper animation
      if (typeof initStepper === 'function') initStepper();
    }

    /* ── Track form handler ── */
    function initTrackForm() {
      var form    = document.getElementById('trackForm');
      var input   = document.getElementById('trackInput');
      var errEl   = document.getElementById('trackError');

      // Pre-fill from sessionStorage (after checkout redirect)
      try {
        var last = sessionStorage.getItem('ct_last_order');
        if (last) { input.value = last; }
      } catch(e) {}

      form.addEventListener('submit', function(e) {
        e.preventDefault();
        var val = input.value.trim().toUpperCase();
        errEl.style.display = 'none';

        if (!val || !val.startsWith('CT-')) {
          errEl.style.display = 'block';
          input.focus();
          return;
        }

        var order = ORDERS[val];
        if (!order) {
          errEl.style.display = 'block';
          errEl.innerHTML = '<i class="bi bi-exclamation-circle me-1"></i>Order not found. Please double-check your Order ID or <a href="contact.php">contact us</a>.';
          input.focus();
          return;
        }

        showResult(order);
      });
    }

    document.addEventListener('DOMContentLoaded', function () {
      initTrackForm();

      // Auto-show result if last_order stored from checkout
      try {
        var last = sessionStorage.getItem('ct_last_order');
        if (last) {
          document.getElementById('trackInput').value = last;
          showResult({
            id:      last,
            product: 'iPhone 13 Pro &ndash; 128GB &bull; Pickup at Cheyn Gadgets Store',
            date:    'August 12, 2026',
            status:  'Ready for Pickup'
          });
        }
      } catch(e) {}
    });

  })();
