'use strict';
// product.js — Product detail page interactions
// Requires: assets/js/products-data.js (loaded first), main.js (CheynCart, formatPrice, showToast)

(function () {

  /* ── Resolve product from URL query param ──────────────────── */
  var productId = new URLSearchParams(window.location.search).get('id') || '';
  var product   = cheynFindProduct(productId);

  /* If no matching product, show an error state and bail out */
  if (!product) {
    document.addEventListener('DOMContentLoaded', function () {
      var main = document.querySelector('main');
      if (main) {
        main.innerHTML =
          '<div class="container py-5 text-center">' +
            '<i class="bi bi-exclamation-triangle text-ct" style="font-size:3rem"></i>' +
            '<h2 class="mt-3 fw-700">Product Not Found</h2>' +
            '<p class="text-muted">The product you\'re looking for doesn\'t exist or has been removed.</p>' +
            '<a href="catalog.php" class="btn btn-ct text-white mt-2">Back to Catalog</a>' +
          '</div>';
      }
      document.title = 'Product Not Found | CheynTech';
    });
    return;
  }

  /* ── State ──────────────────────────────────────────────────── */
  var currentStorage = product.storageOptions[0].label;
  var currentPrice   = product.storageOptions[0].price;
  var currentColor   = product.colorOptions[0].label;

  /* ── Helper ─────────────────────────────────────────────────── */
  function fmt(n) {
    return '\u20B1' + n.toLocaleString('en-PH');
  }

  /* ── Populate page on DOMContentLoaded ──────────────────────── */
  document.addEventListener('DOMContentLoaded', function () {

    /* --- Page title & meta --- */
    document.title = product.name + ' | CheynTech';

    /* --- Breadcrumb --- */
    var bc = document.getElementById('breadcrumbProduct');
    if (bc) bc.textContent = product.name;

    /* --- Main image (first gallery shot) --- */
    var mainImg = document.getElementById('mainProductImg');
    if (mainImg && product.gallery.length) {
      mainImg.src = product.gallery[0].src;
      mainImg.alt = product.name;
    }

    /* --- Gallery thumbnails --- */
    var thumbsEl = document.getElementById('galleryThumbs');
    if (thumbsEl && product.gallery.length) {
      thumbsEl.innerHTML = product.gallery.map(function (g, i) {
        return '<button class="gallery-thumb' + (i === 0 ? ' active' : '') + '"' +
               ' aria-label="' + g.alt + ' view"' +
               ' data-src="' + g.src + '">' +
               '<img src="' + g.thumb + '" alt="' + g.alt + '">' +
               '</button>';
      }).join('');

      /* Wire thumbnail click events */
      thumbsEl.querySelectorAll('.gallery-thumb').forEach(function (btn) {
        btn.addEventListener('click', function () {
          var src = btn.dataset.src;
          if (!src) return;
          mainImg.src = src;
          thumbsEl.querySelectorAll('.gallery-thumb').forEach(function (b) {
            b.classList.remove('active');
          });
          btn.classList.add('active');
        });
      });
    }

    /* --- Condition badge --- */
    var badgesEl = document.getElementById('conditionBadges');
    if (badgesEl) {
      var badgeMap = {
        'badge-refurbished': 'Refurbished',
        'badge-preowned':    'Pre-owned',
        'badge-available':   'Brand New',
      };
      badgesEl.innerHTML =
        '<span class="badge-ct ' + product.badge + '">' + product.badgeLabel + '</span>' +
        '<span class="badge-ct badge-available">Available</span>';
    }

    /* --- Name & price --- */
    var nameEl  = document.getElementById('productName');
    var priceEl = document.getElementById('productPrice');
    if (nameEl)  nameEl.textContent  = product.name;
    if (priceEl) priceEl.textContent = fmt(currentPrice);

    /* --- Short description --- */
    var shortDescEl = document.getElementById('productShortDesc');
    if (shortDescEl) shortDescEl.textContent = product.desc;

    /* --- Storage options --- */
    var storageEl = document.getElementById('storageOptions');
    if (storageEl) {
      storageEl.innerHTML = product.storageOptions.map(function (opt, i) {
        var isFirst = i === 0;
        return '<button class="btn btn-sm ' + (isFirst ? 'btn-ct storage-btn active' : 'btn-ct-outline storage-btn') + '"' +
               ' data-storage="' + opt.label + '"' +
               ' data-price="'   + opt.price + '">' +
               opt.label +
               '</button>';
      }).join('');

      storageEl.querySelectorAll('.storage-btn').forEach(function (btn) {
        btn.addEventListener('click', function () {
          storageEl.querySelectorAll('.storage-btn').forEach(function (b) {
            b.classList.remove('active', 'btn-ct');
            b.classList.add('btn-ct-outline');
          });
          btn.classList.add('active', 'btn-ct');
          btn.classList.remove('btn-ct-outline');
          currentStorage = btn.dataset.storage;
          currentPrice   = parseInt(btn.dataset.price, 10);
          if (priceEl) priceEl.textContent = fmt(currentPrice);
          /* Update specs storage row if present */
          var specStorageEl = document.getElementById('specStorage');
          if (specStorageEl) specStorageEl.textContent = currentStorage;
        });
      });
    }

    /* --- Color options --- */
    var colorEl      = document.getElementById('colorOptions');
    var colorLabelEl = document.getElementById('selectedColorLabel');
    if (colorEl) {
      colorEl.innerHTML = product.colorOptions.map(function (c, i) {
        var isFirst = i === 0;
        var borderStyle = c.border ? 'border-color:' + c.border + ';' : '';
        return '<label class="color-option-btn' + (isFirst ? ' active' : '') + '" data-color="' + c.label + '">' +
               '<input type="radio" name="color" value="' + c.label + '"' + (isFirst ? ' checked' : '') + ' class="visually-hidden">' +
               '<span class="color-dot" style="background:' + c.hex + ';' + borderStyle + '" title="' + c.label + '"></span>' +
               '<span class="color-label">' + c.label + '</span>' +
               '</label>';
      }).join('');

      if (colorLabelEl) colorLabelEl.textContent = currentColor;

      colorEl.querySelectorAll('.color-option-btn').forEach(function (label) {
        label.addEventListener('click', function () {
          colorEl.querySelectorAll('.color-option-btn').forEach(function (l) {
            l.classList.remove('active');
          });
          label.classList.add('active');
          currentColor = label.dataset.color;
          if (colorLabelEl) colorLabelEl.textContent = currentColor;
        });
      });
    }

    /* --- Description tab --- */
    var descBodyEl = document.getElementById('descBody');
    if (descBodyEl) descBodyEl.textContent = product.fullDesc || product.desc;

    /* --- Specs table --- */
    var specsBodyEl = document.getElementById('specsBody');
    if (specsBodyEl && product.specs) {
      specsBodyEl.innerHTML = Object.entries(product.specs).map(function (pair, i) {
        var key = pair[0], val = pair[1];
        var isFirst = i === 0;
        /* For the Storage row, keep it live-updatable */
        if (key === 'Storage') {
          return '<tr><th class="text-muted fw-600' + (isFirst ? ' col-4' : '') + '">' + key + '</th>' +
                 '<td id="specStorage">' + currentStorage + '</td></tr>';
        }
        return '<tr><th class="text-muted fw-600' + (isFirst ? ' col-4' : '') + '">' + key + '</th>' +
               '<td>' + val + '</td></tr>';
      }).join('');
    }

    /* --- "Ask a Question" link --- */
    var askBtn = document.getElementById('askQuestionBtn');
    if (askBtn) {
      askBtn.href = 'contact.php?product=' + encodeURIComponent(product.name);
    }

    /* --- Add to Cart --- */
    var addBtn = document.getElementById('addToCartBtn');
    if (addBtn) {
      addBtn.addEventListener('click', function () {
        /* Find the storage option that matches currentStorage to get its variant id */
        var storageOpt = product.storageOptions.find(function (o) {
          return o.label === currentStorage;
        }) || product.storageOptions[0];

        CheynCart.add({
          id      : storageOpt.id,
          name    : product.name + ' – ' + currentStorage + ' ' + currentColor,
          price   : currentPrice,
          variant : currentStorage,
          color   : currentColor,
          image   : product.image,
        }, addBtn);
      });
    }

  }); // end DOMContentLoaded

})();
