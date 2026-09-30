'use strict';
// product.js — Product detail page interactions
// Requires: assets/js/products-data.js (loaded first), main.js (CheynCart, formatPrice, showToast)

(function () {

  /* ── Resolve product id from URL query param ───────────────── */
  var productId = new URLSearchParams(window.location.search).get('id') || '';
  var fallbackProduct = (typeof cheynFindProduct === 'function') ? cheynFindProduct(productId) : null;

  /* ── Helper ─────────────────────────────────────────────────── */
  function fmt(n) {
    return '\u20B1' + Number(n || 0).toLocaleString('en-PH');
  }

  /* ── Render 404 Error State ─────────────────────────────────── */
  function renderNotFound() {
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
    document.title = 'Product Not Found | Cheyn Gadgets';
  }

  /* ── Render Full Product Details ────────────────────────────── */
  function renderProductPage(product) {
    var storageOptions = (product.storageOptions && product.storageOptions.length)
      ? product.storageOptions
      : [{ label: 'Standard', price: 0, id: product.id }];
    var colorOptions = (product.colorOptions && product.colorOptions.length)
      ? product.colorOptions
      : [{ label: 'Default', hex: '#000000', border: '' }];

    var currentStorage = storageOptions[0].label;
    var currentPrice   = storageOptions[0].price;
    var currentColor   = colorOptions[0].label;

    /* --- Page title & meta --- */
    document.title = product.name + ' | Cheyn Gadgets';

    /* --- Breadcrumb --- */
    var bc = document.getElementById('breadcrumbProduct');
    if (bc) bc.textContent = product.name;

    /* --- Main image (first gallery shot or main image) --- */
    var mainImg = document.getElementById('mainProductImg');
    if (mainImg) {
      var initialSrc = (product.gallery && product.gallery.length && product.gallery[0].src)
        ? product.gallery[0].src
        : (product.image || '/assets/products/placeholder.jpg');
      mainImg.src = initialSrc;
      mainImg.alt = product.name;
      mainImg.onerror = function () {
        this.onerror = null;
        this.src = '/assets/products/placeholder.jpg';
      };
    }

    /* --- Gallery thumbnails --- */
    var thumbsEl = document.getElementById('galleryThumbs');
    if (thumbsEl) {
      if (product.gallery && product.gallery.length > 1) {
        thumbsEl.innerHTML = product.gallery.map(function (g, i) {
          return '<button class="gallery-thumb' + (i === 0 ? ' active' : '') + '"' +
                 ' aria-label="' + (g.alt || product.name) + ' view"' +
                 ' data-src="' + g.src + '">' +
                 '<img src="' + (g.thumb || g.src) + '" alt="' + (g.alt || product.name) + '" onerror="this.onerror=null;this.src=\'/assets/products/placeholder.jpg\'">' +
                 '</button>';
        }).join('');

        thumbsEl.querySelectorAll('.gallery-thumb').forEach(function (btn) {
          btn.addEventListener('click', function () {
            var src = btn.dataset.src;
            if (!src || !mainImg) return;
            mainImg.src = src;
            thumbsEl.querySelectorAll('.gallery-thumb').forEach(function (b) {
              b.classList.remove('active');
            });
            btn.classList.add('active');
          });
        });
      } else {
        thumbsEl.innerHTML = '';
      }
    }

    /* --- Condition badge --- */
    var badgesEl = document.getElementById('conditionBadges');
    if (badgesEl) {
      badgesEl.innerHTML =
        '<span class="badge-ct ' + (product.badge || 'badge-preowned') + '">' + (product.badgeLabel || product.condition || 'Pre-owned') + '</span>' +
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
      storageEl.innerHTML = storageOptions.map(function (opt, i) {
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
          var specStorageEl = document.getElementById('specStorage');
          if (specStorageEl) specStorageEl.textContent = currentStorage;
        });
      });
    }

    /* --- Color options --- */
    var colorEl      = document.getElementById('colorOptions');
    var colorLabelEl = document.getElementById('selectedColorLabel');
    if (colorEl) {
      colorEl.innerHTML = colorOptions.map(function (c, i) {
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
      addBtn.onclick = function () {
        var storageOpt = storageOptions.find(function (o) {
          return o.label === currentStorage;
        }) || storageOptions[0];

        // Match exact variant by storage + color if available
        var variantId = storageOpt.id;
        if (product.variants && product.variants.length) {
          var exactVariant = product.variants.find(function (v) {
            return v.storage === currentStorage && v.color === currentColor;
          });
          if (exactVariant) {
            variantId = exactVariant.id;
          }
        }

        CheynCart.add({
          id      : variantId,
          name    : product.name + ' – ' + currentStorage + ' ' + currentColor,
          price   : currentPrice,
          variant : currentStorage,
          color   : currentColor,
          image   : product.image,
        }, addBtn);
      };
    }

    /* --- Related products grid --- */
    var relatedGrid = document.getElementById('relatedGrid');
    if (relatedGrid) {
      var sourceList = (typeof CHEYN_PRODUCTS !== 'undefined' && Array.isArray(CHEYN_PRODUCTS)) ? CHEYN_PRODUCTS : [];
      var related = sourceList.filter(function (p) { return p.id !== product.id; }).slice(0, 4);
      relatedGrid.innerHTML = related.map(function (p) {
        var opt = (p.storageOptions && p.storageOptions.length) ? p.storageOptions[0] : { price: 0 };
        return '<div class="col-6 col-md-3"><article class="product-card">' +
          '<div class="card-img-wrap"><img src="' + (p.image || '/assets/products/placeholder.jpg') + '" alt="' + p.name + '" loading="lazy" onerror="this.onerror=null;this.src=\'/assets/products/placeholder.jpg\'">' +
          '<span class="badge-ct ' + (p.badge || 'badge-preowned') + '">' + (p.badgeLabel || 'Pre-owned') + '</span></div>' +
          '<div class="card-body"><p class="product-name">' + p.name + '</p><p class="product-price">' + fmt(opt.price) + '</p></div>' +
          '<div class="card-footer"><a href="product.php?id=' + p.id + '" class="btn btn-ct btn-ct-sm flex-grow-1">View</a></div>' +
          '</article></div>';
      }).join('');
    }
  }

  /* ── Load Product From API With Offline Fallback ────────────── */
  async function loadProduct() {
    if (!productId) {
      renderNotFound();
      return;
    }

    var product = null;

    try {
      var res = await fetch('api/products/get.php?id=' + encodeURIComponent(productId), {
        headers: { 'Accept': 'application/json' },
        cache: 'no-store'
      });
      if (res.ok) {
        var data = await res.json();
        if (data && data.success && data.product) {
          product = data.product;
        } else if (data && data.id) {
          product = data;
        }
      }
    } catch (err) {
      console.warn('Could not fetch product from API:', err);
    }

    // Fall back to static CHEYN_PRODUCTS if API fetch failed or returned nothing
    if (!product && fallbackProduct) {
      product = fallbackProduct;
    } else if (product && fallbackProduct) {
      // Merge rich static gallery if DB only provided single main image
      if ((!product.gallery || product.gallery.length <= 1) && fallbackProduct.gallery && fallbackProduct.gallery.length > 1) {
        product.gallery = fallbackProduct.gallery;
      }
    }

    if (!product) {
      renderNotFound();
      return;
    }

    renderProductPage(product);
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', loadProduct);
  } else {
    loadProduct();
  }

})();
