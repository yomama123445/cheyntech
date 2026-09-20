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

/* ============================================================
   HELPERS
   ============================================================ */
function formatPrice(n) {
  return '\u20B1' + n.toLocaleString('en-PH');
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
   ============================================================ */
function renderProducts() {
  const grid = document.getElementById('productGrid');
  if (!grid) return;

  const sorted = sortProducts(PRODUCTS);
  const totalPages = Math.ceil(sorted.length / PAGE_SIZE);

  if (currentPage > totalPages) currentPage = totalPages || 1;

  const start = (currentPage - 1) * PAGE_SIZE;
  const pageItems = sorted.slice(start, start + PAGE_SIZE);

  // Update count label
  const countLabel = document.querySelector('.sort-label i.bi-grid-3x3-gap')?.parentElement;
  if (countLabel) {
    countLabel.innerHTML = `<i class="bi bi-grid-3x3-gap me-1"></i> ${sorted.length} products found`;
  }

  grid.innerHTML = pageItems.map(buildCardHTML).join('');
  renderPagination(totalPages);
}

/* ============================================================
   EXISTING FILTER / MISC LOGIC (preserved)
   ============================================================ */
document.getElementById('applyFiltersBtn')?.addEventListener('click', () => {
  const q        = document.getElementById('catalogSearchInput')?.value.trim() || '';
  const cats     = [...document.querySelectorAll('input[name="cat"]:checked')].map(i => i.value);
  const variants = [...document.querySelectorAll('input[name="variant"]:checked')].map(i => i.value);
  const colors   = [...document.querySelectorAll('input[name="color"]:checked')].map(i => i.value);
  const conds    = [...document.querySelectorAll('input[name="condition"]:checked')].map(i => i.value);
  const priceMin = document.getElementById('priceMin')?.value || '';
  const priceMax = document.getElementById('priceMax')?.value || '';
  const params   = new URLSearchParams();
  if (q)               params.set('q', q);
  if (cats.length)     params.set('cat', cats.join(','));
  if (variants.length) params.set('variant', variants.join(','));
  if (colors.length)   params.set('color', colors.join(','));
  if (conds.length)    params.set('condition', conds.join(','));
  if (priceMin)        params.set('priceMin', priceMin);
  if (priceMax)        params.set('priceMax', priceMax);
  window.history.replaceState({}, '', window.location.pathname + (params.toString() ? '?' + params.toString() : ''));
  showToast('Filters applied', 'info');
});

(function () {
  const params   = new URLSearchParams(window.location.search);
  const catParam = params.get('cat');
  if (catParam) catParam.split(',').forEach(v => {
    const el = document.querySelector('input[name="cat"][value="' + v + '"]');
    if (el) el.checked = true;
  });
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
