(function () {
    'use strict';

    function conditionBadge(condition) {
      const map = { 'Pre-owned': 'badge-preowned', 'Refurbished': 'badge-refurbished', 'Brand New': 'badge-available' };
      const cls = map[condition] || 'badge-refurbished';
      return '<span class="badge-ct ' + cls + '">' + (condition || 'Pre-owned') + '</span>';
    }

    function seedSampleCart() {
      const existing = CheynCart.get();
      if (existing.length === 0) {
        CheynCart.save([
          { id: 'iphone13pro-128-graphite', name: 'iPhone 13 Pro', variant: '128GB', color: 'Graphite', condition: 'Pre-owned',   price: 32500, qty: 1, image: 'https://placehold.co/400x400/fce4ec/e91e8c?text=iPhone+13+Pro' },
          { id: 'iphone12-64-blue',         name: 'iPhone 12',     variant: '64GB',  color: 'Blue',     condition: 'Refurbished', price: 21800, qty: 1, image: 'https://placehold.co/400x400/fce4ec/e91e8c?text=iPhone+12' }
        ]);
      }
    }

    function buildItemCard(item, index) {
      var lineTotal = item.price * (item.qty || 1);
      return '<div class="cart-item-card" data-index="' + index + '">' +
        '<img src="' + (item.image || 'https://placehold.co/400x400/fce4ec/e91e8c?text=Product') + '" alt="' + item.name + '" class="cart-item-img" loading="lazy" onerror="this.src=\'https://placehold.co/400x400/fce4ec/e91e8c?text=Product\'">' +
        '<div class="cart-item-info">' +
          '<div class="cart-item-name">' + item.name + '</div>' +
          '<div class="cart-item-variant">' + (item.variant || '') + (item.color ? ' &middot; ' + item.color : '') + '</div>' +
          conditionBadge(item.condition) +
          '<div class="mt-2">' +
            '<div class="qty-stepper" role="group" aria-label="Quantity">' +
              '<button type="button" class="qty-btn-minus" data-index="' + index + '" aria-label="Decrease">&minus;</button>' +
              '<span class="qty-val">' + item.qty + '</span>' +
              '<button type="button" class="qty-btn-plus" data-index="' + index + '" aria-label="Increase">+</button>' +
            '</div>' +
          '</div>' +
        '</div>' +
        '<div class="text-end flex-shrink-0">' +
          '<div class="cart-item-unit mb-1">Unit: ' + formatPrice(item.price) + '</div>' +
          '<div class="cart-item-price">' + formatPrice(lineTotal) + '</div>' +
        '</div>' +
        '<button class="btn-remove btn-remove-item" data-index="' + index + '" aria-label="Remove from cart"><i class="bi bi-trash3"></i></button>' +
      '</div>';
    }

    function updateSummary() {
      var cart     = CheynCart.get();
      var count    = cart.reduce(function(s,i){ return s + (i.qty||1); }, 0);
      var subtotal = cart.reduce(function(s,i){ return s + i.price*(i.qty||1); }, 0);
      document.getElementById('summaryItemCount').textContent = count;
      document.getElementById('summarySubtotal').textContent  = formatPrice(subtotal);
      document.getElementById('summaryTotal').textContent     = formatPrice(subtotal);
    }

    function renderCart() {
      var cart        = CheynCart.get();
      var emptyState  = document.getElementById('emptyCartState');
      var cartContent = document.getElementById('cartContent');
      var listEl      = document.getElementById('cartItemList');

      if (!cart.length) {
        emptyState.classList.remove('d-none');
        cartContent.classList.add('d-none');
        return;
      }

      emptyState.classList.add('d-none');
      cartContent.classList.remove('d-none');
      listEl.innerHTML = cart.map(function(item, i){ return buildItemCard(item, i); }).join('');
      updateSummary();
    }

    document.getElementById('cartItemList').addEventListener('click', function(e) {
      var minusBtn  = e.target.closest('.qty-btn-minus');
      var plusBtn   = e.target.closest('.qty-btn-plus');
      var removeBtn = e.target.closest('.btn-remove-item');

      if (minusBtn) {
        var idx = +minusBtn.dataset.index;
        var cart = CheynCart.get();
        var newQty = (cart[idx].qty || 1) - 1;
        if (newQty <= 0) { CheynCart.remove(idx); showToast('Item removed from cart', 'info'); }
        else { CheynCart.updateQty(idx, newQty); }
        renderCart();
      }
      if (plusBtn) {
        var idx2 = +plusBtn.dataset.index;
        var cart2 = CheynCart.get();
        CheynCart.updateQty(idx2, (cart2[idx2].qty || 1) + 1);
        renderCart();
      }
      if (removeBtn) {
        var idx3 = +removeBtn.dataset.index;
        var cart3 = CheynCart.get();
        var name = cart3[idx3] ? cart3[idx3].name : 'Item';
        CheynCart.remove(idx3);
        showToast(name + ' removed from cart', 'info');
        renderCart();
      }
    });

    document.addEventListener('DOMContentLoaded', function() {
      seedSampleCart();
      renderCart();
    });
  })();
