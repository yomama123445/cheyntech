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

      var resultEl   = document.getElementById('trackResult');
      var notFoundEl = document.getElementById('trackNotFound');
      var infoCards  = document.getElementById('trackInfoCards');

      if (notFoundEl) notFoundEl.classList.add('d-none');
      if (resultEl) resultEl.classList.remove('d-none');
      if (infoCards) infoCards.classList.add('d-none');

      // Smooth scroll to result
      setTimeout(function() {
        resultEl.scrollIntoView({ behavior: 'smooth', block: 'start' });
      }, 80);

      // Re-run stepper animation
      if (typeof initStepper === 'function') initStepper();
    }

    /* ── Show clean alert card when order is not found ── */
    function showNotFound(orderId) {
      var resultEl   = document.getElementById('trackResult');
      var notFoundEl = document.getElementById('trackNotFound');
      var notFoundId = document.getElementById('notFoundOrderId');
      var infoCards  = document.getElementById('trackInfoCards');

      if (resultEl) resultEl.classList.add('d-none');
      if (notFoundId) notFoundId.textContent = orderId ? orderId : 'the ID entered';
      if (notFoundEl) {
        notFoundEl.classList.remove('d-none');
        setTimeout(function() {
          notFoundEl.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }, 80);
      }
      if (infoCards) infoCards.classList.remove('d-none');
    }

    /* ── Track form handler ── */
    function initTrackForm() {
      var form       = document.getElementById('trackForm');
      var input      = document.getElementById('trackInput');
      var errEl      = document.getElementById('trackError');
      var notFoundEl = document.getElementById('trackNotFound');

      if (errEl) errEl.style.display = 'none';

      // Pre-fill from sessionStorage (after checkout redirect)
      try {
        var last = sessionStorage.getItem('ct_last_order');
        if (last) { input.value = last; }
      } catch(e) {}

      form.addEventListener('submit', function(e) {
        e.preventDefault();
        var val = input.value.trim().toUpperCase();
        if (errEl) errEl.style.display = 'none';
        if (notFoundEl) notFoundEl.classList.add('d-none');

        if (!val) {
          if (errEl) {
            errEl.style.display = 'block';
            errEl.innerHTML = '<i class="bi bi-exclamation-circle me-1"></i>Please enter an Order ID (e.g. CT-10493).';
          }
          input.focus();
          return;
        }

        // Fetch real order from database API with fallback to sample map
        fetch('api/orders/track.php?id=' + encodeURIComponent(val))
          .then(function(res) {
            if (res.status === 404) return null;
            return res.json();
          })
          .then(function(data) {
            if (data && data.success) {
              showResult({
                id:              data.orderNumber,
                product:         data.productLine || 'Ordered Gadget',
                date:            data.date,
                status:          data.statusLabel,
                statusBadgeIcon: data.badgeIcon || 'bi-bag-check'
              });
            } else if (ORDERS[val]) {
              showResult(ORDERS[val]);
            } else {
              showNotFound(val);
            }
          })
          .catch(function() {
            if (ORDERS[val]) {
              showResult(ORDERS[val]);
            } else {
              showNotFound(val);
            }
          });
      });
    }

    document.addEventListener('DOMContentLoaded', function () {
      initTrackForm();

      // Check URL parameters first (?id= or ?order=)
      var params = new URLSearchParams(window.location.search);
      var queryOrder = params.get('id') || params.get('order');

      if (queryOrder) {
        var cleanId = queryOrder.trim().toUpperCase();
        document.getElementById('trackInput').value = cleanId;
        if (ORDERS[cleanId]) {
          showResult(ORDERS[cleanId]);
        } else {
          showNotFound(cleanId);
        }
        return;
      }

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
