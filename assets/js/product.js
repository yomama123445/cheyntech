'use strict';
// product.js — Product detail page interactions

(function () {
  // -- Image gallery --
  document.querySelectorAll('.gallery-thumb').forEach(function (btn) {
    btn.addEventListener('click', function () {
      var src = btn.dataset.src;
      if (!src) return;
      document.getElementById('mainProductImg').src = src;
      document.querySelectorAll('.gallery-thumb').forEach(function (b) { b.classList.remove('active'); });
      btn.classList.add('active');
    });
  });

  // -- Storage selector --
  var currentStorage = '128GB';
  var currentPrice   = 32500;

  document.querySelectorAll('.storage-btn').forEach(function (btn) {
    btn.addEventListener('click', function () {
      document.querySelectorAll('.storage-btn').forEach(function (b) {
        b.classList.remove('active', 'btn-ct');
        b.classList.add('btn-ct-outline');
      });
      btn.classList.add('active', 'btn-ct');
      btn.classList.remove('btn-ct-outline');
      currentStorage = btn.dataset.storage;
      currentPrice   = parseInt(btn.dataset.price, 10);
      document.getElementById('productPrice').textContent = formatPrice(currentPrice);
      document.getElementById('specStorage').textContent  = currentStorage;
    });
  });

  // -- Color selector --
  var currentColor = 'Graphite';

  document.querySelectorAll('.color-option-btn').forEach(function (label) {
    label.addEventListener('click', function () {
      document.querySelectorAll('.color-option-btn').forEach(function (l) { l.classList.remove('active'); });
      label.classList.add('active');
      currentColor = label.dataset.color;
      document.getElementById('selectedColorLabel').textContent = currentColor;
    });
  });

  // -- Add to Cart --
  var addBtn = document.getElementById('addToCartBtn');
  addBtn && addBtn.addEventListener('click', function () {
    CheynCart.add({
      id      : 'iphone13pro-' + currentStorage.toLowerCase() + '-' + currentColor.toLowerCase().replace(/\s/g, ''),
      name    : 'iPhone 13 Pro – ' + currentStorage + ' ' + currentColor,
      price   : currentPrice,
      variant : currentStorage,
      color   : currentColor,
      image   : 'https://placehold.co/400x400/fce4ec/e91e8c?text=iPhone+13+Pro'
    }, this);
  });
})();
