(function () {
    'use strict';

    /* ── Fallback sample cart ── */
    function getCartOrFallback() {
      var cart = CheynCart.get();
      if (!cart.length) {
        cart = [
          { id: 'iphone13pro-128-graphite', name: 'iPhone 13 Pro', variant: '128GB', color: 'Graphite', condition: 'Pre-owned',   price: 32500, qty: 1, image: 'https://placehold.co/400x400/fce4ec/e91e8c?text=iPhone+13+Pro' },
          { id: 'iphone12-64-blue',         name: 'iPhone 12',     variant: '64GB',  color: 'Blue',     condition: 'Refurbished', price: 21800, qty: 1, image: 'https://placehold.co/400x400/fce4ec/e91e8c?text=iPhone+12' }
        ];
      }
      return cart;
    }

    /* ── Render order summary sidebar ── */
    function renderSummary() {
      var cart     = getCartOrFallback();
      var subtotal = cart.reduce(function(s,i){ return s + i.price*(i.qty||1); }, 0);
      var listEl   = document.getElementById('checkoutItemList');

      listEl.innerHTML = cart.map(function(item) {
        return '<div class="summary-item">' +
          '<img src="' + (item.image || 'https://placehold.co/400x400/fce4ec/e91e8c?text=Product') + '" alt="' + item.name + '" onerror="this.src=\'https://placehold.co/400x400/fce4ec/e91e8c?text=Product\'">' +
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
        } else {
          addrFields.classList.add('d-none');
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
      return document.getElementById('fulfillDelivery').checked ? 'Local Delivery' : 'Pickup at CheynTech Store';
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

        var cart     = getCartOrFallback();
        var subtotal = cart.reduce(function(s,i){ return s + i.price*(i.qty||1); }, 0);
        var orderId  = generateOrderId();

        // Populate modal
        document.getElementById('modalOrderId').textContent   = orderId;
        document.getElementById('confirmName').textContent    = document.getElementById('fullName').value;
        document.getElementById('confirmEmail').textContent   = document.getElementById('email').value;
        document.getElementById('confirmPhone').textContent   = document.getElementById('phone').value;
        document.getElementById('confirmFulfillment').textContent = fulfillmentLabel();
        document.getElementById('confirmPayment').textContent     = paymentLabel();
        document.getElementById('confirmTotal').textContent       = formatPrice(subtotal);

        // Save order ID for track page
        try { sessionStorage.setItem('ct_last_order', orderId); } catch(e) {}

        // Clear cart after placing
        CheynCart.clear();

        // Show modal
        var modal = new bootstrap.Modal(document.getElementById('confirmationModal'), { backdrop: 'static' });
        modal.show();
      });
    }

    /* ── Boot ── */
    document.addEventListener('DOMContentLoaded', function() {
      initRadioCards();
      initFulfillmentToggle();
      initPaymentToggle();
      renderSummary();
      initForm();
    });

  })();
