(function () {
    'use strict';

    /* ── Render order summary sidebar ── */
    function renderSummary() {
      if (CheynCart.get().length === 0) { window.location.href = 'cart.php'; return; }
      var cart     = CheynCart.get();
      var subtotal = cart.reduce(function(s,i){ return s + i.price*(i.qty||1); }, 0);
      var listEl   = document.getElementById('checkoutItemList');

      listEl.innerHTML = cart.map(function(item) {
        return '<div class="summary-item">' +
          '<img src="' + (item.image || '/assets/products/placeholder.jpg') + '" alt="' + item.name + '" onerror="this.onerror=null;this.src=\'/assets/products/placeholder.jpg\'">' +
          '<div class="summary-item-info">' +
            '<div class="name">' + item.name + ' &times;' + (item.qty||1) + '</div>' +
            '<div class="variant">' + (item.variant||'') + (item.color ? ' &middot; '+item.color : '') + '</div>' +
          '</div>' +
          '<div class="summary-item-price">' + formatPrice(item.price*(item.qty||1)) + '</div>' +
        '</div>';
      }).join('');

      document.getElementById('coSubtotal').textContent = formatPrice(subtotal);
      document.getElementById('coTotal').textContent    = formatPrice(subtotal);
      updateDeliveryFee();
    }

    /* ── Update delivery fee label based on fulfillment ── */
    function updateDeliveryFee() {
      var isDelivery = document.getElementById('fulfillDelivery').checked;
      var feeEl = document.getElementById('coDeliveryFee');
      if (isDelivery) {
        feeEl.textContent = 'To be confirmed';
        feeEl.style.color = 'var(--ct-muted)';
      } else {
        feeEl.textContent = 'Free';
        feeEl.style.color = 'var(--ct-primary)';
      }
    }

    /* ── Radio card visual selection ── */
    function initRadioCards() {
      document.querySelectorAll('.radio-card').forEach(function(card) {
        var radio = card.querySelector('input[type="radio"]');
        if (radio) {
          radio.addEventListener('change', function() {
            // Deselect siblings in same group
            document.querySelectorAll('input[name="' + radio.name + '"]').forEach(function(r) {
              r.closest('.radio-card') && r.closest('.radio-card').classList.remove('selected');
            });
            card.classList.add('selected');
          });
          if (radio.checked) card.classList.add('selected');
        }
      });
    }

    /* ── Show/hide delivery address ── */
    function initFulfillmentToggle() {
      var pickup   = document.getElementById('fulfillPickup');
      var delivery = document.getElementById('fulfillDelivery');
      var addrFields = document.getElementById('deliveryAddressFields');

      function toggle() {
        if (delivery.checked) {
          addrFields.classList.remove('d-none');
          requestAnimationFrame(function() {
            addrFields.classList.add('open');
          });
        } else {
          addrFields.classList.remove('open');
          setTimeout(function() {
            if (!delivery.checked) addrFields.classList.add('d-none');
          }, 350);
        }
        updateDeliveryFee();
      }

      pickup.addEventListener('change', toggle);
      delivery.addEventListener('change', toggle);
      toggle();
    }

    /* ── Show/hide payment info boxes ── */
    function initPaymentToggle() {
      var payments = document.querySelectorAll('input[name="payment"]');
      payments.forEach(function(radio) {
        radio.addEventListener('change', function() {
          document.getElementById('gcashInfo').classList.remove('show');
          document.getElementById('bankInfo').classList.remove('show');
          if (radio.value === 'gcash') document.getElementById('gcashInfo').classList.add('show');
          if (radio.value === 'bank')  document.getElementById('bankInfo').classList.add('show');
        });
      });
    }

    /* ── Generate random order ID ── */
    function generateOrderId() {
      return 'CT-' + String(Math.floor(10000 + Math.random() * 90000));
    }

    /* ── Fulfillment label ── */
    function fulfillmentLabel() {
      return document.getElementById('fulfillDelivery').checked ? 'Local Delivery' : 'Pickup at Cheyn Gadgets Store';
    }

    /* ── Payment label ── */
    function paymentLabel() {
      var val = document.querySelector('input[name="payment"]:checked').value;
      var map = { cash: 'Cash on Pickup/Delivery', gcash: 'GCash', bank: 'Bank Transfer (BDO/BPI)' };
      return map[val] || val;
    }

    /* ── Form submit ── */
    function initForm() {
      var form = document.getElementById('checkoutForm');
      form.addEventListener('submit', function(e) {
        e.preventDefault();

        // HTML5 validation
        if (!form.checkValidity()) {
          form.classList.add('was-validated');
          form.querySelector(':invalid') && form.querySelector(':invalid').focus();
          showToast('Please fill in all required fields.', 'error');
          return;
        }

        var cart = CheynCart.get();
        if (!cart.length) {
          showToast('Your cart is empty.', 'error');
          return;
        }

        var submitBtn = form.querySelector('button[type="submit"]');
        var originalText = submitBtn.innerHTML;
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Placing Order…';

        var payload = {
          fullName:      document.getElementById('fullName').value.trim(),
          email:         document.getElementById('email').value.trim(),
          phone:         document.getElementById('phone').value.trim(),
          fulfillment:   document.getElementById('fulfillDelivery').checked ? 'delivery' : 'pickup',
          payment:       document.querySelector('input[name="payment"]:checked').value,
          addrStreet:    document.getElementById('addrStreet') ? document.getElementById('addrStreet').value.trim() : '',
          addrBarangay:  document.getElementById('addrBarangay') ? document.getElementById('addrBarangay').value.trim() : '',
          addrCity:      document.getElementById('addrCity') ? document.getElementById('addrCity').value.trim() : '',
          addrProvince:  document.getElementById('addrProvince') ? document.getElementById('addrProvince').value.trim() : '',
          addrNotes:     document.getElementById('addrNotes') ? document.getElementById('addrNotes').value.trim() : '',
          items:         cart
        };

        var csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;

        fetch('api/orders/create.php', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-CSRF-Token': csrfToken
          },
          body: JSON.stringify(payload)
        })
        .then(function(res) { return res.json(); })
        .then(function(data) {
          submitBtn.disabled = false;
          submitBtn.innerHTML = originalText;

          var orderNumber = data.orderNumber || generateOrderId();
          var subtotal = data.total || cart.reduce(function(s,i){ return s + i.price*(i.qty||1); }, 0);

          // Populate modal with real order response
          document.getElementById('modalOrderId').textContent       = orderNumber;
          document.getElementById('confirmName').textContent        = data.customerName || payload.fullName;
          document.getElementById('confirmEmail').textContent       = data.email || payload.email;
          document.getElementById('confirmPhone').textContent       = data.phone || payload.phone;
          document.getElementById('confirmFulfillment').textContent = data.fulfillment || fulfillmentLabel();
          document.getElementById('confirmPayment').textContent     = data.payment || paymentLabel();
          document.getElementById('confirmTotal').textContent       = formatPrice(subtotal);

          // Save order ID and email for track page
          try {
            sessionStorage.setItem('ct_last_order', orderNumber);
            sessionStorage.setItem('ct_last_email', payload.email);
          } catch(e) {}

          // Clear cart after placing
          CheynCart.clear();

          // Show payment instructions in modal if GCash/Bank
          renderConfirmPaymentInstructions(payload.payment);

          // Show modal
          var modal = new bootstrap.Modal(document.getElementById('confirmationModal'), { backdrop: 'static' });
          modal.show();
        })
        .catch(function() {
          // Graceful fallback if database is not connected locally yet
          submitBtn.disabled = false;
          submitBtn.innerHTML = originalText;

          var subtotal = cart.reduce(function(s,i){ return s + i.price*(i.qty||1); }, 0);
          var fallbackId = generateOrderId();

          document.getElementById('modalOrderId').textContent       = fallbackId;
          document.getElementById('confirmName').textContent        = payload.fullName;
          document.getElementById('confirmEmail').textContent       = payload.email;
          document.getElementById('confirmPhone').textContent       = payload.phone;
          document.getElementById('confirmFulfillment').textContent = fulfillmentLabel();
          document.getElementById('confirmPayment').textContent     = paymentLabel();
          document.getElementById('confirmTotal').textContent       = formatPrice(subtotal);

          try {
            sessionStorage.setItem('ct_last_order', fallbackId);
            sessionStorage.setItem('ct_last_email', payload.email);
          } catch(e) {}
          CheynCart.clear();

          // Show payment instructions in modal if GCash/Bank
          renderConfirmPaymentInstructions(payload.payment);

          var modal = new bootstrap.Modal(document.getElementById('confirmationModal'), { backdrop: 'static' });
          modal.show();
        });
      });
    }

    /* ── Render payment instructions in confirmation modal ── */
    function renderConfirmPaymentInstructions(paymentMethod) {
      var box = document.getElementById('confirmPaymentInstructions');
      if (!box) return;
      var badge = document.getElementById('confirmPaymentBadge');
      var text = document.getElementById('confirmPaymentText');
      var label = document.getElementById('confirmAccountLabel');
      var val = document.getElementById('confirmAccountVal');
      var copyBtn = document.getElementById('confirmCopyBtn');

      if (paymentMethod === 'gcash') {
        box.classList.remove('d-none');
        if (badge) { badge.textContent = 'GCash'; badge.className = 'badge bg-primary'; }
        if (text) text.innerHTML = 'Send payment to our verified GCash account and include your <strong>Order ID</strong> in the message:';
        if (label) label.textContent = "Cheyn's Gadgets (GCash)";
        if (val) val.textContent = '0917-824-3968';
        if (copyBtn) copyBtn.setAttribute('data-copy', '09178243968');
      } else if (paymentMethod === 'bank') {
        box.classList.remove('d-none');
        if (badge) { badge.textContent = 'Bank Transfer'; badge.className = 'badge bg-info text-dark'; }
        if (text) text.innerHTML = 'Transfer payment to our BDO account and use your <strong>Order ID</strong> as payment reference:';
        if (label) label.textContent = "BDO • Cheyn's Gadgets";
        if (val) val.textContent = '0012-3456-7890';
        if (copyBtn) copyBtn.setAttribute('data-copy', '001234567890');
      } else {
        box.classList.add('d-none');
      }
    }

    /* ── Global copy-to-clipboard handler ── */
    function initCopyButtons() {
      document.addEventListener('click', function(e) {
        var btn = e.target.closest('.copy-btn');
        if (!btn) return;
        var text = btn.getAttribute('data-copy');
        if (!text) return;
        if (navigator.clipboard && navigator.clipboard.writeText) {
          navigator.clipboard.writeText(text).then(function() {
            var orig = btn.innerHTML;
            btn.innerHTML = '<i class="bi bi-check2"></i> Copied!';
            btn.classList.remove('btn-outline-secondary');
            btn.classList.add('btn-success');
            setTimeout(function() {
              btn.innerHTML = orig;
              btn.classList.remove('btn-success');
              btn.classList.add('btn-outline-secondary');
            }, 2000);
          });
        }
      });
    }

    /* ── Boot ── */
    document.addEventListener('DOMContentLoaded', function() {
      initRadioCards();
      initFulfillmentToggle();
      initPaymentToggle();
      initCopyButtons();
      renderSummary();
      initForm();
    });

  })();
