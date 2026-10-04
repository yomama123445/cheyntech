'use strict';

/* ============================================================
   CATALOG DATA
   ============================================================ */
let PRODUCTS = (typeof CHEYN_PRODUCTS !== 'undefined' && Array.isArray(CHEYN_PRODUCTS)) ? CHEYN_PRODUCTS : [];


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
 * Derive a product's catalog category from its name/id/category so it can be matched
 * against the UI checkbox values ('preowned' | 'new' | 'android' | 'tablet' | 'wearable').
 */
function productCategories(p) {
  const name = (p.name || '').toLowerCase();
  const id   = (p.id || '').toLowerCase();

  // Wearables & smart accessories (Apple Watch, AirPods, etc.)
  if (id.includes('watch') || name.includes('watch') || id.includes('airpod') || name.includes('airpod') || p.category === 'wearable') {
    return ['wearable'];
  }

  // Tablets (iPads, Android tablets)
  if (id.includes('ipad') || name.includes('ipad') || id.includes('tablet') || name.includes('tablet') || p.category === 'tablet') {
    return ['tablet'];
  }

  // Android smartphones
  if (p.category === 'android' || name.includes('samsung') || name.includes('vivo') || name.includes('tecno') || name.includes('honor') || name.includes('pixel') || name.includes('oneplus') || name.includes('redmi') || name.includes('xiaomi')) {
    return ['android'];
  }

  // iPhones
  if (name.includes('iphone') || id.includes('iphone')) {
    const cats = [];
    if (p.condition === 'Brand New' || p.badge === 'badge-available' || p.category === 'new') {
      cats.push('new');
    }
    if (p.condition === 'Pre-owned' || p.condition === 'Refurbished' || p.category === 'preowned' || !cats.length) {
      cats.push('preowned');
    }
    return cats;
  }

  if (p.category) {
    return [p.category];
  }
  return ['android'];
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
  const qLower = q.toLowerCase().trim();

  return PRODUCTS.filter(p => {
    // --- Search query against product name / keywords ---
    if (qLower) {
      const pName = (p.name || '').toLowerCase();
      const pCats = productCategories(p);

      const isWearableQuery = ['wearable', 'wearables', 'smartwatch', 'smart watch', 'watch', 'airpod', 'airpods'].some(w => qLower.includes(w) || w.includes(qLower));
      const isTabletQuery   = ['tablet', 'tablets', 'ipad', 'ipads'].some(w => qLower.includes(w) || w.includes(qLower));

      const nameMatch     = pName.includes(qLower);
      const categoryMatch = (isWearableQuery && pCats.includes('wearable')) || (isTabletQuery && pCats.includes('tablet'));

      if (!nameMatch && !categoryMatch) return false;
    }

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
          <img src="${p.image ? (p.image.startsWith('/') ? p.image.substring(1) : p.image) : 'assets/products/placeholder.jpg'}" alt="${p.name}" loading="lazy" onerror="this.onerror=null;this.src='assets/products/placeholder.jpg'">
          <span class="badge-ct ${p.badge}">${p.badgeLabel}</span>
        </div>
        <div class="card-body">
          <p class="product-name">${p.name}</p>
          <div class="product-spec-row">
            <span class="spec-chip">${variant}</span>
            <span class="spec-chip">${p.condition === 'Brand New' ? 'Sealed Box' : 'Grade A'}</span>
            <span class="spec-chip text-success"><i class="bi bi-shield-check"></i> Verified</span>
          </div>
          <p class="product-price">${formatPrice(price)}</p>
        </div>
        <div class="card-footer">
          <button class="btn btn-ct btn-ct-sm flex-fill"
            onclick="CheynCart.add({id:'${defaultStorage.id}',name:'${p.name.replace(/'/g, "\\'")}',price:${price},variant:'${variant}',color:'${color}',image:'${p.image}'}, this)">
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

  if (totalPages <= 1) {
    nav.innerHTML = '';
    return;
  }

  const prevDisabled = currentPage === 1;
  const nextDisabled = currentPage === totalPages;

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
   CLEAR ALL FILTERS
   Resets all checkboxes, search inputs, active filter state,
   and re-renders the complete catalog.
   ============================================================ */
function clearAllFilters() {
  const searchInput = document.getElementById('catalogSearchInput');
  if (searchInput) searchInput.value = '';
  const searchInputMobile = document.getElementById('catalogSearchInputMobile');
  if (searchInputMobile) searchInputMobile.value = '';

  const priceMin = document.getElementById('priceMin');
  if (priceMin) priceMin.value = '';
  const priceMax = document.getElementById('priceMax');
  if (priceMax) priceMax.value = '';

  document.querySelectorAll('input[name="cat"], input[name="variant"], input[name="color"], input[name="condition"]').forEach(cb => {
    cb.checked = false;
  });

  activeFilters = {
    q:        '',
    cats:     [],
    variants: [],
    colors:   [],
    conds:    [],
    priceMin: null,
    priceMax: null,
  };

  currentPage = 1;
  window.history.replaceState({}, '', window.location.pathname);

  renderProducts();
  renderActiveTags();
}

window.clearAllFilters = clearAllFilters;

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

  grid.innerHTML = pageItems.length
    ? pageItems.map(buildCardHTML).join('')
    : `<div class="col-12 py-4">
        <div class="empty-state-box">
          <div class="empty-icon">
            <i class="bi bi-search"></i>
          </div>
          <h3>No matching gadgets found</h3>
          <p>We couldn't find any products matching your current filters or search terms. Try adjusting your selections or clear your filters to view all gadgets.</p>
          <button type="button" class="btn btn-ct px-4 py-2" id="clearFiltersBtn" onclick="clearAllFilters()">
            <i class="bi bi-arrow-counterclockwise me-1"></i> Clear Filters
          </button>
        </div>
      </div>`;

  const clearBtn = document.getElementById('clearFiltersBtn');
  if (clearBtn) {
    clearBtn.addEventListener('click', clearAllFilters);
  }

  renderPagination(totalPages);
  updateFilterCounts(filtered);

  // Keep both result-count elements in sync
  const heroCount = document.getElementById('heroResultCount');
  const sortCount = document.getElementById('sortBarCount');
  if (heroCount) heroCount.textContent = filtered.length;
  if (sortCount) sortCount.textContent = filtered.length;
}

/* ============================================================
   FILTER COUNTS
   Updates every [data-count-for] span with the number of products
   in the current filtered set that match that category value.
   ============================================================ */
function updateFilterCounts(filteredProducts) {
  document.querySelectorAll('[data-count-for]').forEach(span => {
    const key = span.dataset.countFor;
    let count = 0;

    filteredProducts.forEach(p => {
      const pCats = productCategories(p);
      if (pCats.includes(key)) count++;
    });

    span.textContent = count > 0 ? '(' + count + ')' : '';
  });
}

/* ============================================================
   READ FILTERS FROM DOM
   ============================================================ */
function collectFiltersFromDOM() {
  const qDesktop = document.getElementById('catalogSearchInput')?.value.trim() || '';
  const qMobile  = document.getElementById('catalogSearchInputMobile')?.value.trim() || '';
  const getChecked = name => [...new Set([...document.querySelectorAll(`input[name="${name}"]:checked`)].map(i => i.value))];

  return {
    q:        qDesktop || qMobile,
    cats:     getChecked('cat'),
    variants: getChecked('variant'),
    colors:   getChecked('color'),
    conds:    getChecked('condition'),
    priceMin: parseFloat(document.getElementById('priceMin')?.value) || null,
    priceMax: parseFloat(document.getElementById('priceMax')?.value) || null,
  };
}

/* ============================================================
   APPLY FILTERS BUTTONS (Desktop + Mobile Offcanvas)
   ============================================================ */
function applyFilters() {
  activeFilters = collectFiltersFromDOM();
  currentPage   = 1;

  // Sync search input values across desktop and mobile
  const searchDesktop = document.getElementById('catalogSearchInput');
  const searchMobile  = document.getElementById('catalogSearchInputMobile');
  if (searchDesktop && searchMobile) {
    if (activeFilters.q) {
      searchDesktop.value = activeFilters.q;
      searchMobile.value  = activeFilters.q;
    }
  }

  // Synchronize desktop and mobile checkbox sets
  ['cat', 'variant', 'color', 'condition'].forEach(name => {
    const list = activeFilters[name === 'cat' ? 'cats' : (name === 'variant' ? 'variants' : (name === 'color' ? 'colors' : 'conds'))] || [];
    document.querySelectorAll(`input[name="${name}"]`).forEach(cb => {
      cb.checked = list.includes(cb.value);
    });
  });

  // Sync URL so the state is shareable / back-navigable
  const params = new URLSearchParams();
  if (activeFilters.q)               params.set('q',         activeFilters.q);
  if (activeFilters.cats.length)     params.set('cat',       activeFilters.cats.join(','));
  if (activeFilters.variants.length) params.set('variant',   activeFilters.variants.join(','));
  if (activeFilters.colors.length)   params.set('color',     activeFilters.colors.join(','));
  if (activeFilters.conds.length)    params.set('condition', activeFilters.conds.join(','));
  if (activeFilters.priceMin)        params.set('priceMin',  activeFilters.priceMin);
  if (activeFilters.priceMax)        params.set('priceMax',  activeFilters.priceMax);
  window.history.replaceState({}, '', window.location.pathname + (params.toString() ? '?' + params.toString() : ''));

  renderProducts();
  renderActiveTags();
  showToast('Filters applied', 'info');
}

document.getElementById('applyFiltersBtn')?.addEventListener('click', applyFilters);
document.getElementById('applyFiltersBtnMobile')?.addEventListener('click', applyFilters);

/* ============================================================
   RESTORE CHECKBOXES + SEARCH FROM URL (on page load)
   ============================================================ */
(function () {
  const params = new URLSearchParams(window.location.search);

  function restoreCheckboxes(name, param) {
    const vals = params.get(param);
    if (!vals) return;
    vals.split(',').forEach(v => {
      document.querySelectorAll(`input[name="${name}"][value="${v}"]`).forEach(el => {
        el.checked = true;
      });
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
    const inputMobile = document.getElementById('catalogSearchInputMobile');
    if (inputMobile) inputMobile.value = q;
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

/* ============================================================
   ACTIVE FILTER TAGS
   ============================================================ */
function renderActiveTags() {
  const container = document.getElementById('activeFilters');
  if (!container) return;

  const { q, cats, variants, colors, conds } = activeFilters;

  // Human-readable label maps
  const catLabels  = { preowned: 'Pre-owned iPhones', new: 'New iPhones', android: 'Android', tablet: 'Tablets', wearable: 'Wearables & Smartwatches' };
  const condLabels = { preowned: 'Pre-owned', refurbished: 'Refurbished', brandnew: 'Brand New' };

  const tags = [];

  if (q) tags.push({ label: `"${q}"`, name: 'q', value: q });
  cats.forEach(v     => tags.push({ label: catLabels[v]  || v, name: 'cat',       value: v }));
  variants.forEach(v => tags.push({ label: v.toUpperCase(),    name: 'variant',   value: v }));
  colors.forEach(v   => tags.push({ label: v.replace(/-/g, ' ').replace(/\b\w/g, c => c.toUpperCase()),
                                    name: 'color', value: v }));
  conds.forEach(v    => tags.push({ label: condLabels[v]  || v, name: 'condition', value: v }));

  if (!tags.length) {
    container.innerHTML = '';
    container.style.display = 'none';
    return;
  }

  container.style.display = '';
  container.innerHTML = tags.map(tag =>
    `<span class="filter-tag" data-name="${tag.name}" data-value="${tag.value}">${tag.label} ` +
    `<button type="button" aria-label="Remove ${tag.label} filter"><i class="bi bi-x"></i></button></span>`
  ).join('');

  // Wire each × button
  container.querySelectorAll('.filter-tag button').forEach(btn => {
    btn.addEventListener('click', () => {
      const span  = btn.closest('.filter-tag');
      const fname = span.dataset.name;
      const fval  = span.dataset.value;

      if (fname === 'q') {
        const input = document.getElementById('catalogSearchInput');
        if (input) input.value = '';
        const inputMobile = document.getElementById('catalogSearchInputMobile');
        if (inputMobile) inputMobile.value = '';
      } else {
        document.querySelectorAll(`input[name="${fname}"][value="${fval}"]`).forEach(cb => {
          cb.checked = false;
        });
      }

      activeFilters = collectFiltersFromDOM();
      currentPage   = 1;
      renderProducts();
      renderActiveTags();
    });
  });
}

/* ============================================================
   SORT EVENT LISTENER (fixed)
   ============================================================ */
document.getElementById('sortSelect')?.addEventListener('change', e => {
  currentSort = e.target.value;
  currentPage = 1;
  renderProducts();
  renderActiveTags();
});

/* ============================================================
   SHIMMER SKELETON PLACEHOLDER
   ============================================================ */
function renderSkeletonGrid() {
  const grid = document.getElementById('productGrid');
  if (!grid) return;
  grid.innerHTML = Array.from({ length: 6 }).map(() => `
    <div class="col">
      <div class="skeleton-card">
        <div class="skeleton-box skeleton-img"></div>
        <div class="skeleton-body">
          <div class="skeleton-box skeleton-line title"></div>
          <div class="skeleton-box skeleton-line" style="width: 55%;"></div>
          <div class="skeleton-box skeleton-line price"></div>
        </div>
        <div class="skeleton-footer">
          <div class="skeleton-box skeleton-btn"></div>
        </div>
      </div>
    </div>
  `).join('');
}

/* ============================================================
   INIT & API FETCH
   ============================================================ */
async function loadCatalogProducts() {
  if (PRODUCTS.length > 0) {
    renderProducts();
    renderActiveTags();
  } else {
    renderSkeletonGrid();
  }

  try {
    const res = await fetch('api/products/get.php', {
      headers: { 'Accept': 'application/json' },
      cache: 'no-store'
    });
    if (!res.ok) {
      throw new Error(`HTTP error ${res.status}`);
    }
    const data = await res.json();
    let fetched = Array.isArray(data) ? data : (data && (data.products || data.data));
    if (fetched && typeof fetched === 'object' && !Array.isArray(fetched)) {
      fetched = Object.values(fetched);
    }
    if (Array.isArray(fetched) && fetched.length > 0) {
      PRODUCTS = fetched;
      renderProducts();
      renderActiveTags();
    }
  } catch (err) {
    if (!PRODUCTS.length && typeof CHEYN_PRODUCTS !== 'undefined' && Array.isArray(CHEYN_PRODUCTS)) {
      PRODUCTS = CHEYN_PRODUCTS;
      renderProducts();
      renderActiveTags();
    }
  }
}

document.addEventListener('DOMContentLoaded', () => {
  const params = new URLSearchParams(window.location.search);
  const pageParam = parseInt(params.get('page'), 10);
  if (pageParam && pageParam > 0) currentPage = pageParam;

  const sortEl = document.getElementById('sortSelect');
  if (sortEl) currentSort = sortEl.value;

  document.getElementById('clearAllLink')?.addEventListener('click', e => {
    e.preventDefault();
    clearAllFilters();
  });

  document.getElementById('clearAllLinkMobile')?.addEventListener('click', e => {
    e.preventDefault();
    clearAllFilters();
  });

  loadCatalogProducts();
});
