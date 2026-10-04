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
/* ============================================================
   REAL-DATA FILTER DERIVATION & RENDERING
   Derives categories, storages, colors, and conditions directly
   from the live catalog products dataset.
   ============================================================ */
function extractFilterData(products) {
  const categoryDefinitions = [
    { id: 'preowned', label: 'Pre-owned iPhones' },
    { id: 'new',      label: 'New iPhones' },
    { id: 'android',  label: 'Android Phones' },
    { id: 'tablet',   label: 'Tablets & iPads' },
    { id: 'wearable', label: 'Wearables & Watches' }
  ];

  const catCounts = {};
  categoryDefinitions.forEach(c => { catCounts[c.id] = 0; });

  products.forEach(p => {
    const pCats = productCategories(p);
    pCats.forEach(catId => {
      if (catCounts[catId] !== undefined) {
        catCounts[catId]++;
      }
    });
  });

  const categories = categoryDefinitions
    .map(c => ({ id: c.id, label: c.label, count: catCounts[c.id] || 0 }))
    .filter(c => c.count > 0 || c.id === 'new');

  // Extract storage options across all products
  const storageMap = {};
  products.forEach(p => {
    (p.storageOptions || []).forEach(opt => {
      const raw = (opt.label || '').trim();
      if (!raw) return;
      const slug = raw.toLowerCase().replace(/\s+/g, '');
      if (!storageMap[slug]) {
        storageMap[slug] = {
          slug: slug,
          label: raw.toUpperCase().includes('GB') ? raw.replace(/gb/i, ' GB') : raw,
          pids: new Set()
        };
      }
      storageMap[slug].pids.add(p.id);
    });
  });

  const storages = Object.values(storageMap).map(s => ({
    slug: s.slug,
    label: s.label,
    count: s.pids.size
  }));

  storages.sort((a, b) => {
    const isGbA = a.slug.endsWith('gb');
    const isGbB = b.slug.endsWith('gb');
    if (isGbA && isGbB) {
      return parseInt(a.slug, 10) - parseInt(b.slug, 10);
    }
    if (isGbA && !isGbB) return -1;
    if (!isGbA && isGbB) return 1;
    return a.label.localeCompare(b.label);
  });

  // Extract distinct colors across all products
  const colorMap = {};
  products.forEach(p => {
    (p.colorOptions || []).forEach(opt => {
      const raw = (opt.label || '').trim();
      if (!raw) return;
      const slug = colorSlug(raw);
      if (!colorMap[slug]) {
        colorMap[slug] = {
          slug: slug,
          label: raw,
          hex: opt.hex || '#000000',
          border: opt.border || (['#ffffff', '#fff', '#f5f5f7', '#e2e2e4'].includes((opt.hex || '').toLowerCase()) ? '#c0c0c0' : ''),
          pids: new Set()
        };
      }
      colorMap[slug].pids.add(p.id);
    });
  });

  const colors = Object.values(colorMap).map(c => ({
    slug: c.slug,
    label: c.label,
    hex: c.hex,
    border: c.border,
    count: c.pids.size
  }));

  colors.sort((a, b) => b.count - a.count || a.label.localeCompare(b.label));

  // Extract conditions across all products
  const condDefinitions = [
    { slug: 'preowned',    label: 'Pre-owned' },
    { slug: 'refurbished', label: 'Refurbished' },
    { slug: 'brandnew',    label: 'Brand New' }
  ];

  const conditions = condDefinitions.map(def => {
    const count = products.filter(p => conditionSlug(p.condition) === def.slug).length;
    return { slug: def.slug, label: def.label, count };
  }).filter(c => c.count > 0);

  return { categories, storages, colors, conditions };
}

/** Render dynamic filter checkboxes and colors from real product data */
function renderFilterControls(products) {
  if (!products || !products.length) return;
  const data = extractFilterData(products);

  // 1. Categories
  const catContainers = [
    { el: document.getElementById('categoryFilterList'), prefix: 'cat_' },
    { el: document.getElementById('mCategoryFilterList'), prefix: 'mCat_' }
  ];
  catContainers.forEach(({ el, prefix }) => {
    if (!el) return;
    el.innerHTML = data.categories.map(c => `
      <div class="form-check">
        <input class="form-check-input" type="checkbox" id="${prefix}${c.id}" name="cat" value="${c.id}"
          ${activeFilters.cats.includes(c.id) ? 'checked' : ''} data-filter-count-for="${c.id}">
        <label class="form-check-label d-flex align-items-center justify-content-between" for="${prefix}${c.id}">
          <span>${c.label}</span>
          <span class="filter-count text-muted ms-1" data-count-for="${c.id}">(${c.count})</span>
        </label>
      </div>
    `).join('');
  });

  // 2. Storage
  const storageContainers = [
    { el: document.getElementById('storageFilterList'), prefix: 'var_' },
    { el: document.getElementById('mStorageFilterList'), prefix: 'mVar_' }
  ];
  storageContainers.forEach(({ el, prefix }) => {
    if (!el) return;
    el.innerHTML = data.storages.map(s => `
      <div class="form-check">
        <input class="form-check-input" type="checkbox" id="${prefix}${s.slug}" name="variant" value="${s.slug}"
          ${activeFilters.variants.includes(s.slug) ? 'checked' : ''}>
        <label class="form-check-label d-flex align-items-center justify-content-between" for="${prefix}${s.slug}">
          <span>${s.label}</span>
          <span class="filter-count text-muted ms-1">(${s.count})</span>
        </label>
      </div>
    `).join('');
  });

  // 3. Colors
  const colorContainers = [
    { el: document.getElementById('colorFilterList'), prefix: 'col_' },
    { el: document.getElementById('mColorFilterList'), prefix: 'mCol_' }
  ];
  colorContainers.forEach(({ el, prefix }) => {
    if (!el) return;
    el.innerHTML = data.colors.map(c => `
      <label class="color-option d-flex align-items-center justify-content-between w-100 mb-2" for="${prefix}${c.slug}">
        <div class="d-flex align-items-center gap-2">
          <input class="form-check-input m-0" type="checkbox" id="${prefix}${c.slug}" name="color" value="${c.slug}"
            ${activeFilters.colors.includes(c.slug) ? 'checked' : ''}>
          <span class="color-dot" style="background:${c.hex};${c.border ? 'border-color:' + c.border + ';' : ''}"></span>
          <span class="color-label">${c.label}</span>
        </div>
        <span class="filter-count text-muted ms-1">(${c.count})</span>
      </label>
    `).join('');
  });

  // 4. Conditions
  const condContainers = [
    { el: document.getElementById('conditionFilterList'), prefix: 'cond_' },
    { el: document.getElementById('mConditionFilterList'), prefix: 'mCond_' }
  ];
  condContainers.forEach(({ el, prefix }) => {
    if (!el) return;
    el.innerHTML = data.conditions.map(c => `
      <div class="form-check">
        <input class="form-check-input" type="checkbox" id="${prefix}${c.slug}" name="condition" value="${c.slug}"
          ${activeFilters.conds.includes(c.slug) ? 'checked' : ''}>
        <label class="form-check-label d-flex align-items-center justify-content-between" for="${prefix}${c.slug}">
          <span>${c.label}</span>
          <span class="filter-count text-muted ms-1">(${c.count})</span>
        </label>
      </div>
    `).join('');
  });

  // Wire auto-update on desktop checkbox change
  const filterCard = document.querySelector('.filter-card');
  if (filterCard && !filterCard.dataset.wiredAutoApply) {
    filterCard.dataset.wiredAutoApply = 'true';
    filterCard.addEventListener('change', e => {
      if (e.target.matches('input[type="checkbox"]')) {
        applyFilters(false);
      }
    });
  }
}

function updateFilterCounts(filteredProducts) {
  // Update category data-count-for spans if any present
  document.querySelectorAll('[data-count-for]').forEach(span => {
    const key = span.dataset.countFor;
    let count = 0;
    filteredProducts.forEach(p => {
      const pCats = productCategories(p);
      if (pCats.includes(key)) count++;
    });
    span.textContent = count > 0 ? '(' + count + ')' : '(0)';
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
function applyFilters(showToastNotification = true) {
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
  if (showToastNotification) {
    showToast('Filters applied', 'info');
  }
}

document.getElementById('applyFiltersBtn')?.addEventListener('click', () => applyFilters(true));
document.getElementById('applyFiltersBtnMobile')?.addEventListener('click', () => applyFilters(true));

/* ============================================================
   RESTORE CHECKBOXES + SEARCH FROM URL (on page load)
   ============================================================ */
(function () {
  const params = new URLSearchParams(window.location.search);
  const getParamVals = param => (params.get(param) || '').split(',').map(s => s.trim().toLowerCase()).filter(Boolean);

  activeFilters.cats     = getParamVals('cat');
  activeFilters.variants = getParamVals('variant');
  activeFilters.colors   = getParamVals('color');
  activeFilters.conds    = getParamVals('condition');

  // Populate search input from ?q= and store in activeFilters
  const q = params.get('q') || '';
  if (q) {
    activeFilters.q = q;
    const input = document.getElementById('catalogSearchInput');
    if (input) input.value = q;
    const inputMobile = document.getElementById('catalogSearchInputMobile');
    if (inputMobile) inputMobile.value = q;
  }

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

  // Initial render of filter controls with static product data
  if (typeof CHEYN_PRODUCTS !== 'undefined' && Array.isArray(CHEYN_PRODUCTS) && CHEYN_PRODUCTS.length > 0) {
    renderFilterControls(CHEYN_PRODUCTS);
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
    renderFilterControls(PRODUCTS);
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
      renderFilterControls(PRODUCTS);
      renderProducts();
      renderActiveTags();
    }
  } catch (err) {
    if (!PRODUCTS.length && typeof CHEYN_PRODUCTS !== 'undefined' && Array.isArray(CHEYN_PRODUCTS)) {
      PRODUCTS = CHEYN_PRODUCTS;
      renderFilterControls(PRODUCTS);
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
