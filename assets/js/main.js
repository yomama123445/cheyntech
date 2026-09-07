/* =====================================================
   CheynTech — Global JavaScript
   Project: Online Ordering & Delivery Management System
   ===================================================== */

'use strict';

/* =====================================================
   CART MANAGER
   ===================================================== */
const CheynCart = {

  /** Retrieve cart from localStorage */
  get() {
    try {
      return JSON.parse(localStorage.getItem('ct_cart') || '[]');
    } catch { return []; }
  },

  /** Persist cart + refresh UI */
  save(cart) {
    localStorage.setItem('ct_cart', JSON.stringify(cart));
    CheynCart.updateBadge();
  },

  /** Add or increment a product. Pass the clicked button as triggerBtn for visual feedback. */
  add(product, triggerBtn) {
    const cart = CheynCart.get();
    const idx  = cart.findIndex(
      i => i.id === product.id && i.variant === product.variant && i.color === product.color
    );
    if (idx > -1) {
      cart[idx].qty += 1;
    } else {
      cart.push({ ...product, qty: 1 });
    }
    CheynCart.save(cart);
    showToast(`✓ ${product.name} added to cart`, 'success');

    /* Visual button feedback */
    if (triggerBtn) {
      const original = triggerBtn.innerHTML;
      triggerBtn.innerHTML = '<i class="bi bi-check-lg me-1"></i>Added!';
      triggerBtn.classList.add('btn-added');
      triggerBtn.disabled = true;
      setTimeout(() => {
        triggerBtn.innerHTML = original;
        triggerBtn.classList.remove('btn-added');
        triggerBtn.disabled = false;
      }, 1500);
    }
  },

  /** Remove item by index */
  remove(index) {
    const cart = CheynCart.get();
    cart.splice(index, 1);
    CheynCart.save(cart);
  },

  /** Update quantity; removes if qty ≤ 0 */
  updateQty(index, qty) {
    const cart = CheynCart.get();
    cart[index].qty = qty;
    if (qty <= 0) cart.splice(index, 1);
    CheynCart.save(cart);
  },

  /** Total item count (sum of quantities) */
  count() {
    return CheynCart.get().reduce((s, i) => s + (i.qty || 1), 0);
  },

  /** Cart subtotal in pesos */
  total() {
    return CheynCart.get().reduce((s, i) => s + i.price * (i.qty || 1), 0);
  },

  /** Clear all cart items */
  clear() {
    localStorage.removeItem('ct_cart');
    CheynCart.updateBadge();
  },

  /** Sync badge number across all pages */
  updateBadge() {
    const n = CheynCart.count();
    document.querySelectorAll('.cart-badge').forEach(el => {
      el.textContent = n;
      el.style.display = n > 0 ? 'flex' : 'none';
    });
  }
};

/* =====================================================
   TOAST NOTIFICATION
   ===================================================== */
let _toastTimer = null;

function showToast(message, type = 'info', duration = 3000) {
  let toast = document.getElementById('ct-toast');
  if (!toast) {
    toast = document.createElement('div');
    toast.id = 'ct-toast';
    toast.className = 'toast-ct';
    document.body.appendChild(toast);
  }

  const icons = { success: 'check-circle-fill', error: 'x-circle-fill', info: 'info-circle-fill' };
  toast.className = `toast-ct toast-${type}`;
  toast.innerHTML = `<i class="bi bi-${icons[type] || icons.info}"></i> ${message}`;

  clearTimeout(_toastTimer);
  requestAnimationFrame(() => requestAnimationFrame(() => toast.classList.add('show')));
  _toastTimer = setTimeout(() => toast.classList.remove('show'), duration);
}

/* =====================================================
   SEARCH OVERLAY
   ===================================================== */
function initSearchOverlay() {
  const toggleBtn = document.getElementById('searchToggle');
  const overlay   = document.getElementById('searchOverlay');
  const closeBtn  = document.getElementById('searchClose');
  const input     = document.getElementById('searchInput');
  const form      = document.getElementById('searchForm');

  if (!toggleBtn) return;

  /* On the catalog page, skip the modal — just focus the inline search box */
  const onCatalogPage = !!document.getElementById('catalogSearchInput');
  if (onCatalogPage) {
    toggleBtn.addEventListener('click', e => {
      e.preventDefault();
      const catalogInput = document.getElementById('catalogSearchInput');
      if (catalogInput) {
        catalogInput.scrollIntoView({ behavior: 'smooth', block: 'center' });
        setTimeout(() => catalogInput.focus(), 300);
      }
    });
    return; /* skip overlay wiring on this page */
  }

  if (!overlay) return;

  const open  = () => { overlay.classList.add('active');    requestAnimationFrame(() => input && input.focus()); };
  const close = () => overlay.classList.remove('active');

  toggleBtn.addEventListener('click', e => { e.preventDefault(); open(); });
  closeBtn  && closeBtn.addEventListener('click', close);
  overlay.addEventListener('click', e => { if (e.target === overlay) close(); });
  document.addEventListener('keydown', e => { if (e.key === 'Escape') close(); });

  if (form && input) {
    form.addEventListener('submit', e => {
      e.preventDefault();
      const q = input.value.trim();
      if (q) window.location.href = `catalog.html?q=${encodeURIComponent(q)}`;
    });
  }
}

/* =====================================================
   BACK TO TOP
   ===================================================== */
function initBackToTop() {
  const btn = document.getElementById('backToTop');
  if (!btn) return;
  window.addEventListener('scroll', () => {
    btn.classList.toggle('visible', window.scrollY > 500);
  }, { passive: true });
  btn.addEventListener('click', () => window.scrollTo({ top: 0, behavior: 'smooth' }));
}

/* =====================================================
   STICKY NAVBAR — shadow on scroll
   ===================================================== */
function initNavbarScroll() {
  const nav = document.querySelector('.navbar-ct');
  if (!nav) return;
  window.addEventListener('scroll', () => {
    nav.classList.toggle('scrolled', window.scrollY > 8);
  }, { passive: true });
}

/* =====================================================
   ACTIVE NAV LINK HIGHLIGHT
   ===================================================== */
function initActiveNav() {
  const page = window.location.pathname.split('/').pop() || 'index.html';
  document.querySelectorAll('.navbar-ct .nav-link[href]').forEach(link => {
    const href = link.getAttribute('href').split('?')[0];
    if (href === page) link.classList.add('active');
  });
}

/* =====================================================
   PRICE FORMATTER
   ===================================================== */
function formatPrice(amount) {
  return '₱' + Number(amount).toLocaleString('en-PH', { minimumFractionDigits: 0, maximumFractionDigits: 0 });
}

/* =====================================================
   ADMIN SIDEBAR TOGGLE (mobile)
   ===================================================== */
function initAdminSidebar() {
  const toggle   = document.getElementById('sidebarToggle');
  const sidebar  = document.querySelector('.admin-sidebar');
  const overlay  = document.getElementById('sidebarOverlay');
  if (!toggle || !sidebar) return;

  const open  = () => { sidebar.classList.add('open');    overlay && overlay.classList.add('active'); };
  const close = () => { sidebar.classList.remove('open'); overlay && overlay.classList.remove('active'); };

  toggle.addEventListener('click', () => sidebar.classList.contains('open') ? close() : open());
  overlay && overlay.addEventListener('click', close);
}

/* =====================================================
   CATALOG: URL param query → search field
   ===================================================== */
function initCatalogSearch() {
  const input = document.getElementById('catalogSearchInput');
  if (!input) return;
  const params = new URLSearchParams(window.location.search);
  const q = params.get('q');
  if (q) input.value = decodeURIComponent(q);
}

/* =====================================================
   ORDER STATUS STEPPER ANIMATION
   ===================================================== */
function initStepper() {
  const steps = document.querySelectorAll('.order-stepper .step');
  if (!steps.length) return;
  let fillLine = document.querySelector('.step-fill');
  if (!fillLine) return;

  const completedCount = [...steps].filter(s => s.classList.contains('completed')).length;
  const activeIdx      = [...steps].findIndex(s => s.classList.contains('active'));
  const progress       = completedCount / (steps.length - 1);

  fillLine.style.width = `${Math.min(progress * 80, 80)}%`;
}

/* =====================================================
   INIT ALL
   ===================================================== */
document.addEventListener('DOMContentLoaded', () => {
  CheynCart.updateBadge();
  initSearchOverlay();
  initBackToTop();
  initNavbarScroll();
  initActiveNav();
  initAdminSidebar();
  initCatalogSearch();
  initStepper();
});
