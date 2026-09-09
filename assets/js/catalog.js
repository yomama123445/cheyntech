'use strict';

/* ============================================================
   CATALOG DATA
   ============================================================ */
const PRODUCTS = [
  {
    id: 'iphone13pro-128-graphite',
    name: 'iPhone 13 Pro 128GB Graphite',
    price: 32500,
    badge: 'badge-refurbished',
    badgeLabel: 'Refurbished',
    variant: '128GB',
    color: 'Graphite',
    desc: 'A15 Bionic chip · Pro camera system · 120Hz ProMotion display',
    image: 'https://placehold.co/400x400/fce4ec/e91e8c?text=iPhone+13+Pro',
    date: 7,
  },
  {
    id: 'iphone12-64-blue',
    name: 'iPhone 12 64GB Blue',
    price: 21800,
    badge: 'badge-preowned',
    badgeLabel: 'Pre-owned',
    variant: '64GB',
    color: 'Blue',
    desc: 'A14 Bionic · 5G capable · Ceramic Shield front glass',
    image: 'https://placehold.co/400x400/dbeafe/1e3a8a?text=iPhone+12',
    date: 3,
  },
  {
    id: 's22-256-phantom',
    name: 'Samsung Galaxy S22 256GB Phantom Black',
    price: 28000,
    badge: 'badge-refurbished',
    badgeLabel: 'Refurbished',
    variant: '256GB',
    color: 'Phantom Black',
    desc: 'Snapdragon 8 Gen 1 · 50MP triple camera · 6.1" Dynamic AMOLED',
    image: 'https://placehold.co/400x400/fce4ec/e91e8c?text=Galaxy+S22',
    date: 5,
  },
  {
    id: 'ipad9-64-gray',
    name: 'Apple iPad 9th Gen 64GB Space Gray',
    price: 22000,
    badge: 'badge-preowned',
    badgeLabel: 'Pre-owned',
    variant: '64GB',
    color: 'Space Gray',
    desc: 'A13 Bionic · 10.2" Retina display · All-day battery life',
    image: 'https://placehold.co/400x400/fce4ec/e91e8c?text=iPad+9th+Gen',
    date: 2,
  },
  {
    id: 'pixel7-128-obsidian',
    name: 'Google Pixel 7 128GB Obsidian',
    price: 24000,
    badge: 'badge-refurbished',
    badgeLabel: 'Refurbished',
    variant: '128GB',
    color: 'Obsidian',
    desc: 'Google Tensor G2 · 50MP main camera · 7-year Android updates',
    image: 'https://placehold.co/400x400/fce4ec/e91e8c?text=Pixel+7',
    date: 6,
  },
  {
    id: 'iphone14-256-midnight',
    name: 'iPhone 14 256GB Midnight',
    price: 44900,
    badge: 'badge-available',
    badgeLabel: 'Brand New',
    variant: '256GB',
    color: 'Midnight',
    desc: 'A15 Bionic · Crash Detection · Emergency SOS via satellite',
    image: 'https://placehold.co/400x400/fce4ec/e91e8c?text=iPhone+14',
    date: 10,
  },
  {
    id: 'iphone11-64-white',
    name: 'iPhone 11 64GB White',
    price: 17500,
    badge: 'badge-preowned',
    badgeLabel: 'Pre-owned',
    variant: '64GB',
    color: 'White',
    desc: 'A13 Bionic · Dual 12MP ultra-wide cameras · Face ID',
    image: 'https://placehold.co/400x400/fce4ec/e91e8c?text=iPhone+11',
    date: 1,
  },
  {
    id: 'a54-128-violet',
    name: 'Samsung Galaxy A54 128GB Awesome Violet',
    price: 19990,
    badge: 'badge-available',
    badgeLabel: 'Brand New',
    variant: '128GB',
    color: 'Awesome Violet',
    desc: 'Exynos 1380 · 50MP OIS camera · 5000mAh battery',
    image: 'https://placehold.co/400x400/fce4ec/e91e8c?text=Galaxy+A54',
    date: 9,
  },
  {
    id: 'iphonese3-128-starlight',
    name: 'iPhone SE 3rd Gen 128GB Starlight',
    price: 23500,
    badge: 'badge-refurbished',
    badgeLabel: 'Refurbished',
    variant: '128GB',
    color: 'Starlight',
    desc: 'A15 Bionic · 5G capable · Touch ID · Compact 4.7" design',
    image: 'https://placehold.co/400x400/fce4ec/e91e8c?text=iPhone+SE+3',
    date: 4,
  },
  {
    id: 'rn12pro-256-skyblue',
    name: 'Xiaomi Redmi Note 12 Pro 256GB Sky Blue',
    price: 16499,
    badge: 'badge-available',
    badgeLabel: 'Brand New',
    variant: '256GB',
    color: 'Sky Blue',
    desc: 'MediaTek Dimensity 1080 · 200MP camera · 67W turbo charging',
    image: 'https://placehold.co/400x400/fce4ec/e91e8c?text=Redmi+Note+12',
    date: 8,
  },
  {
    id: 'ipadmini6-64-purple',
    name: 'Apple iPad Mini 6th Gen 64GB Purple',
    price: 29800,
    badge: 'badge-preowned',
    badgeLabel: 'Pre-owned',
    variant: '64GB',
    color: 'Purple',
    desc: 'A15 Bionic · 8.3" Liquid Retina · USB-C · Touch ID on top',
    image: 'https://placehold.co/400x400/fce4ec/e91e8c?text=iPad+Mini+6',
    date: 11,
  },
  {
    id: 'op11-256-titan',
    name: 'OnePlus 11 256GB Titan Black',
    price: 34500,
    badge: 'badge-refurbished',
    badgeLabel: 'Refurbished',
    variant: '256GB',
    color: 'Titan Black',
    desc: 'Snapdragon 8 Gen 2 · Hasselblad camera · 100W SUPERVOOC charging',
    image: 'https://placehold.co/400x400/fce4ec/e91e8c?text=OnePlus+11',
    date: 12,
  },
];

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
  return `
    <div class="col">
      <article class="product-card">
        <div class="card-img-wrap">
          <img src="${p.image}" alt="${p.name}" loading="lazy">
          <span class="badge-ct ${p.badge}">${p.badgeLabel}</span>
        </div>
        <div class="card-body">
          <p class="product-name">${p.name}</p>
          <p class="product-price">${formatPrice(p.price)}</p>
          <p class="product-desc">${p.desc}</p>
        </div>
        <div class="card-footer">
          <button class="btn btn-ct btn-ct-sm flex-fill"
            onclick="CheynCart.add({id:'${p.id}',name:'${p.name}',price:${p.price},variant:'${p.variant}',color:'${p.color}',image:'${p.image}'}, this)">
            <i class="bi bi-cart-plus me-1"></i> Add to Cart
          </button>
          <a href="product.html" class="btn btn-ct-outline btn-ct-sm" aria-label="View ${p.name}">
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
    case 'price-asc':  return sorted.sort((a, b) => a.price - b.price);
    case 'price-desc': return sorted.sort((a, b) => b.price - a.price);
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
