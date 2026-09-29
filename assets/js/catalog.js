'use strict';

/* ============================================================
   CATALOG DATA
   Defined in assets/js/products-data.js (loaded before this script).
   ============================================================ */
const PRODUCTS = CHEYN_PRODUCTS;


/* ============================================================
   STATE
   ============================================================ */
const PAGE_SIZE = 6;
let currentPage = 1;
let currentSort = 'featured';

/** Active filter state — updated by applyFiltersBtn and restored from URL on load. */
let activeFilters = {
  q:        '',   // search query against product name
  cats:     [],   // 'preowned' | 'new' | 'android' | 'tablet'
  variants: [],   // '64gb' | '128gb' | '256gb' | '512gb'
  colors:   [],   // 'space-gray' | 'silver' | 'midnight' | etc.
  conds:    [],   // 'preowned' | 'refurbished' | 'brandnew'
  priceMin: null, // number or null
  priceMax: null, // number or null
};

/* ============================================================
   HELPERS
   ============================================================ */
function formatPrice(n) {
  return '\u20B1' + n.toLocaleString('en-PH');
}

/**
 * Derive a product's catalog category from its name/id so it can be matched
 * against the UI checkbox values ('preowned' | 'new' | 'android' | 'tablet').
 */
function productCategories(p) {
  const name = p.name.toLowerCase();
  const id   = p.id.toLowerCase();
  const cats = [];
  if (id.includes('ipad') || name.includes('ipad')) {
    cats.push('tablet');
  } else if (name.includes('iphone')) {
    if (p.condition === 'Pre-owned')  cats.push('preowned');
    if (p.condition === 'Brand New')  cats.push('new');
    // Refurbished iPhones don't match the two iPhone cat filters by design
  } else {
    // Samsung, Google, Xiaomi, OnePlus, etc.
    cats.push('android');
  }
  return cats;
}

/** Normalise a condition string to the checkbox value format. */
function conditionSlug(condition) {
  switch (condition) {
    case 'Pre-owned':  return 'preowned';
    case 'Refurbished': return 'refurbished';
    case 'Brand New':  return 'brandnew';
    default:           return condition.toLowerCase().replace(/[^a-z0-9]/g, '');
  }
}

/**
 * Normalise a color label to match catalog.php checkbox values.
 * e.g. 'Phantom Black' → 'phantom-black', 'Space Gray' → 'space-gray'
 */
function colorSlug(label) {
  return label.toLowerCase().replace(/\s+/g, '-').replace(/[^a-z0-9-]/g, '');
}

/* ============================================================
   FILTER
   ============================================================ */
function filterProducts() {
  const { q, cats, variants, colors, conds, priceMin, priceMax } = activeFilters;
  const qLower = q.toLowerCase();

  return PRODUCTS.filter(p => {
    // --- Search query against product name ---
    if (qLower && !p.name.toLowerCase().includes(qLower)) return false;

    // --- Category ---
    if (cats.length) {
      const pCats = productCategories(p);
      if (!cats.some(c => pCats.includes(c))) return false;
    }

    // --- Condition ---
    if (conds.length && !conds.includes(conditionSlug(p.condition))) return false;

    // --- Variant (storage) — product must offer at least one matching option ---
    if (variants.length) {
      const hasVariant = p.storageOptions.some(
        o => variants.includes(o.label.toLowerCase().replace(/\s+/g, ''))
      );
      if (!hasVariant) return false;
    }

    // --- Color — product must offer at least one matching color ---
    if (colors.length) {
      const hasColor = p.colorOptions.some(o => colors.includes(colorSlug(o.label)));
      if (!hasColor) return false;
    }

    // --- Price range (against the cheapest storage option) ---
    const basePrice = p.storageOptions[0].price;
    if (priceMin !== null && basePrice < priceMin) return false;
    if (priceMax !== null && basePrice > priceMax) return false;

    return true;
  });
}

function buildCardHTML(p) {
  // Use the first storage option as the card's default price/variant
  const defaultStorage = p.storageOptions[0];
  const defaultColor   = p.colorOptions[0];
  const price   = defaultStorage.price;
  const variant = defaultStorage.label;
  const color   = defaultColor.label;
  return `
    <div class="col">
      <article class="product-card">
        <div class="card-img-wrap">
          <img src="${p.image}" alt="${p.name}" loading="lazy">
          <span class="badge-ct ${p.badge}">${p.badgeLabel}</span>
        </div>
        <div class="card-body">
          <p class="product-name">${p.name}</p>
          <p class="product-price">${formatPrice(price)}</p>
          <p class="product-desc">${p.desc}</p>
        </div>
        <div class="card-footer">
          <button class="btn btn-ct btn-ct-sm flex-fill"
            onclick="CheynCart.add({id:'${defaultStorage.id}',name:'${p.name}',price:${price},variant:'${variant}',color:'${color}',image:'${p.image}'}, this)">
            <i class="bi bi-cart-plus me-1"></i> Add to Cart
          </button>
          <a href="product.php?id=${p.id}" class="btn btn-ct-outline btn-ct-sm" aria-label="View ${p.name}">
            <i class="bi bi-eye"></i>
          </a>
        </div>
      </article>
    </div>`;
}

/* ============================================================
   SORT
   ============================================================ */
function sortProducts(list) {
  const sorted = [...list];
  switch (currentSort) {
    case 'price-asc':  return sorted.sort((a, b) => a.storageOptions[0].price - b.storageOptions[0].price);
    case 'price-desc': return sorted.sort((a, b) => b.storageOptions[0].price - a.storageOptions[0].price);
    case 'newest':     return sorted.sort((a, b) => b.date - a.date);
    case 'name':       return sorted.sort((a, b) => a.name.localeCompare(b.name));
    default:           return sorted; // 'featured' — preserve original order
  }
}


/* ============================================================
   PAGINATION RENDER
   ============================================================ */
function renderPagination(totalPages) {
  const nav = document.getElementById('paginationNav');
  if (!nav) return;

  const prevDisabled = currentPage === 1;
  const nextDisabled = currentPage === totalPages || totalPages === 0;

  let html = `<ul class="pagination gap-1">`;

  html += `<li class="page-item${prevDisabled ? ' disabled' : ''}">
    <a class="page-link" href="#" data-page="${currentPage - 1}" aria-label="Previous page"${prevDisabled ? ' tabindex="-1"' : ''}>
      <i class="bi bi-chevron-left"></i>
    </a>
  </li>`;

  for (let i = 1; i <= totalPages; i++) {
    html += `<li class="page-item${i === currentPage ? ' active' : ''}"${i === currentPage ? ' aria-current="page"' : ''}>
      <a class="page-link" href="#" data-page="${i}">${i}</a>
    </li>`;
  }

  html += `<li class="page-item${nextDisabled ? ' disabled' : ''}">
    <a class="page-link" href="#" data-page="${currentPage + 1}" aria-label="Next page"${nextDisabled ? ' tabindex="-1"' : ''}>
      <i class="bi bi-chevron-right"></i>
    </a>
  </li>`;

  html += `</ul>`;
  nav.innerHTML = html;

  nav.querySelectorAll('a.page-link[data-page]').forEach(link => {
    link.addEventListener('click', e => {
      e.preventDefault();
      const page = parseInt(link.dataset.page, 10);
      if (isNaN(page) || page < 1 || page > totalPages) return;
      currentPage = page;
      renderProducts();
      document.getElementById('productGrid')?.scrollIntoView({ behavior: 'smooth', block: 'start' });
    });
  });
}

/* ============================================================
   MAIN RENDER
   Filters → sorts → paginates.
   ============================================================ */
function renderProducts() {
  const grid = document.getElementById('productGrid');
  if (!grid) return;

  const filtered = filterProducts();
  const sorted   = sortProducts(filtered);
  const totalPages = Math.ceil(sorted.length / PAGE_SIZE);

  if (currentPage > totalPages) currentPage = totalPages || 1;

  const start     = (currentPage - 1) * PAGE_SIZE;
  const pageItems = sorted.slice(start, start + PAGE_SIZE);

  // Update count label
  const countLabel = document.querySelector('.sort-label i.bi-grid-3x3-gap')?.parentElement;
  if (countLabel) {
    countLabel.innerHTML = `<i class="bi bi-grid-3x3-gap me-1"></i> ${sorted.length} products found`;
  }

  grid.innerHTML = pageItems.length
    ? pageItems.map(buildCardHTML).join('')
    : '<p class="text-muted py-5 text-center col-12">No products match your filters.</p>';

  renderPagination(totalPages);
}

/* ============================================================
   READ FILTERS FROM DOM
   ============================================================ */
function collectFiltersFromDOM() {
  return {
    q:        document.getElementById('catalogSearchInput')?.value.trim() || '',
    cats:     [...document.querySelectorAll('input[name="cat"]:checked')].map(i => i.value),
    variants: [...document.querySelectorAll('input[name="variant"]:checked')].map(i => i.value),
    colors:   [...document.querySelectorAll('input[name="color"]:checked')].map(i => i.value),
    conds:    [...document.querySelectorAll('input[name="condition"]:checked')].map(i => i.value),
    priceMin: parseFloat(document.getElementById('priceMin')?.value) || null,
    priceMax: parseFloat(document.getElementById('priceMax')?.value) || null,
  };
}

/* ============================================================
   APPLY FILTERS BUTTON
   ============================================================ */
document.getElementById('applyFiltersBtn')?.addEventListener('click', () => {
  activeFilters = collectFiltersFromDOM();
  currentPage   = 1;

  // Sync URL so the state is shareable / back-navigable
  const params = new URLSearchParams();
  if (activeFilters.q)               params.set('q',         activeFilters.q);
  if (activeFilters.cats.length)     params.set('cat',       activeFilters.cats.join(','));
  if (activeFilters.variants.length) params.set('variant',   activeFilters.variants.join(','));
  if (activeFilters.colors.length)   params.set('color',     activeFilters.colors.join(','));
  if (activeFilters.conds.length)    params.set('condition',  activeFilters.conds.join(','));
  if (activeFilters.priceMin)        params.set('priceMin',  activeFilters.priceMin);
  if (activeFilters.priceMax)        params.set('priceMax',  activeFilters.priceMax);
  window.history.replaceState({}, '', window.location.pathname + (params.toString() ? '?' + params.toString() : ''));

  renderProducts();
  showToast('Filters applied', 'info');
});

/* ============================================================
   RESTORE CHECKBOXES + SEARCH FROM URL (on page load)
   ============================================================ */
(function () {
  const params = new URLSearchParams(window.location.search);

  function restoreCheckboxes(name, param) {
    const vals = params.get(param);
    if (!vals) return;
    vals.split(',').forEach(v => {
      const el = document.querySelector(`input[name="${name}"][value="${v}"]`);
      if (el) el.checked = true;
    });
  }

  restoreCheckboxes('cat',       'cat');
  restoreCheckboxes('variant',   'variant');
  restoreCheckboxes('color',     'color');
  restoreCheckboxes('condition', 'condition');

  // Populate search input from ?q= and store in activeFilters
  const q = params.get('q') || '';
  if (q) {
    const input = document.getElementById('catalogSearchInput');
    if (input) input.value = q;
  }

  // Build activeFilters from whatever was just restored
  activeFilters = collectFiltersFromDOM();

  // Price range
  const priceMin = params.get('priceMin');
  const priceMax = params.get('priceMax');
  if (priceMin) {
    const el = document.getElementById('priceMin');
    if (el) { el.value = priceMin; activeFilters.priceMin = parseFloat(priceMin); }
  }
  if (priceMax) {
    const el = document.getElementById('priceMax');
    if (el) { el.value = priceMax; activeFilters.priceMax = parseFloat(priceMax); }
  }
})();

document.querySelectorAll('.filter-tag button').forEach(btn => {
  btn.addEventListener('click', () => btn.closest('.filter-tag').remove());
});

/* ============================================================
   SORT EVENT LISTENER (fixed)
   ============================================================ */
document.getElementById('sortSelect')?.addEventListener('change', e => {
  currentSort = e.target.value;
  currentPage = 1;
  renderProducts();
});

/* ============================================================
   INIT
   ============================================================ */
document.addEventListener('DOMContentLoaded', () => {
  const params = new URLSearchParams(window.location.search);
  const pageParam = parseInt(params.get('page'), 10);
  if (pageParam && pageParam > 0) currentPage = pageParam;

  const sortEl = document.getElementById('sortSelect');
  if (sortEl) currentSort = sortEl.value;

  renderProducts();
});

