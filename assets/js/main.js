/* =====================================================
   Cheyn Gadgets — Global JavaScript
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
    showToast(`${product.name} added to cart`, 'success');

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
  const toggleBtns = document.querySelectorAll('#searchToggle, .nav-search-trigger');
  const overlay    = document.getElementById('searchOverlay');
  const closeBtn   = document.getElementById('searchClose');
  const input      = document.getElementById('searchInput');
  const form       = document.getElementById('searchForm');

  if (!toggleBtns.length) return;

  /* On the catalog page, skip the modal — just focus the inline search box */
  const onCatalogPage = !!document.getElementById('catalogSearchInput');
  if (onCatalogPage) {
    toggleBtns.forEach(btn => {
      btn.addEventListener('click', e => {
        e.preventDefault();
        const catalogInput = document.getElementById('catalogSearchInput');
        if (catalogInput) {
          catalogInput.scrollIntoView({ behavior: 'smooth', block: 'center' });
          setTimeout(() => catalogInput.focus(), 300);
        }
      });
    });
    return; /* skip overlay wiring on this page */
  }

  if (!overlay) return;

  const open  = () => { overlay.classList.add('active');    requestAnimationFrame(() => input && input.focus()); };
  const close = () => overlay.classList.remove('active');

  toggleBtns.forEach(btn => {
    btn.addEventListener('click', e => { e.preventDefault(); open(); });
  });
  closeBtn  && closeBtn.addEventListener('click', close);
  overlay.addEventListener('click', e => { if (e.target === overlay) close(); });
  document.addEventListener('keydown', e => {
    if (e.key === 'Escape') close();
    if ((e.metaKey || e.ctrlKey) && e.key.toLowerCase() === 'k') {
      e.preventDefault();
      open();
    }
    if (e.key === '/' && !['INPUT', 'TEXTAREA'].includes(document.activeElement?.tagName)) {
      e.preventDefault();
      open();
    }
  });

  if (form && input) {
    form.addEventListener('submit', e => {
      e.preventDefault();
      const q = input.value.trim();
      if (q) window.location.href = `catalog.php?q=${encodeURIComponent(q)}`;
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
  const page = window.location.pathname.split('/').pop() || 'index.php';
  const urlParams = new URLSearchParams(window.location.search);
  const cat = (urlParams.get('cat') || '').toLowerCase();
  const q = (urlParams.get('q') || '').toLowerCase();

  document.querySelectorAll('.navbar-ct .nav-link[href]:not(.dropdown-toggle)').forEach(link => {
    const href = link.getAttribute('href').split('?')[0];
    if (href === page) link.classList.add('active');
  });

  // Highlight specific category dropdown when browsing catalog
  if (page === 'catalog.php') {
    if (cat.includes('preowned') || cat.includes('new') || cat.includes('wearable') || q.includes('apple') || q.includes('iphone') || q.includes('watch') || q.includes('airpod')) {
      document.getElementById('appleDropdown')?.classList.add('active');
    } else if (cat.includes('tablet') || q.includes('tablet') || q.includes('ipad')) {
      document.getElementById('tabletsDropdown')?.classList.add('active');
    } else if (cat.includes('android') || q.includes('samsung') || q.includes('vivo') || q.includes('tecno') || q.includes('honor')) {
      document.getElementById('androidDropdown')?.classList.add('active');
    }
  }
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
  const closeBtn = document.getElementById('sidebarCloseBtn');
  const sidebar  = document.querySelector('.admin-sidebar');
  const overlay  = document.getElementById('sidebarOverlay');
  if (!sidebar) return;

  const open  = () => {
    sidebar.classList.add('open');
    if (overlay) {
      overlay.classList.add('active');
      overlay.style.display = 'block';
    }
  };
  const close = () => {
    sidebar.classList.remove('open');
    if (overlay) {
      overlay.classList.remove('active');
      overlay.style.display = 'none';
    }
  };

  if (toggle) {
    toggle.addEventListener('click', e => {
      e.preventDefault();
      e.stopPropagation();
      sidebar.classList.contains('open') ? close() : open();
    });
  }
  if (closeBtn) {
    closeBtn.addEventListener('click', e => {
      e.preventDefault();
      close();
    });
  }
  if (overlay) {
    overlay.addEventListener('click', close);
  }
  document.addEventListener('keydown', e => {
    if (e.key === 'Escape' && sidebar.classList.contains('open')) {
      close();
    }
  });
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
  const stepIndex      = (activeIdx !== -1 && activeIdx > completedCount) ? activeIdx : completedCount;
  const maxSteps       = steps.length - 1;
  const progress       = maxSteps > 0 ? (stepIndex / maxSteps) : 0;
  const trackSpan      = maxSteps / steps.length;

  fillLine.style.width = `${Math.min(Math.max(progress * trackSpan * 100, 0), trackSpan * 100)}%`;
}
window.initStepper = initStepper;

/* =====================================================
   USER AUTH & HEADER PROFILE
   ===================================================== */
function initUserAuth() {
  var accountLink = document.querySelector('a[aria-label="Account"]');
  if (!accountLink) return;

  function escapeHtml(str) {
    var div = document.createElement('div');
    div.textContent = str || '';
    return div.innerHTML;
  }

  fetch('api/auth/me.php', { headers: { 'Accept': 'application/json' } })
    .then(function(res) { return res.json(); })
    .then(function(data) {
      if (data && data.loggedIn && data.user) {
        var user = data.user;
        var initial = (user.name || 'U').charAt(0).toUpperCase();

        var container = document.createElement('div');
        container.className = 'dropdown d-inline-block';
        container.innerHTML =
          '<button class="btn p-0 border-0 bg-transparent d-flex align-items-center" id="userMenuBtn" data-bs-toggle="dropdown" aria-expanded="false">' +
            '<div style="width:32px;height:32px;border-radius:50%;background:var(--ct-primary);color:#fff;font-weight:700;font-size:0.85rem;display:flex;align-items:center;justify-content:center;">' +
              escapeHtml(initial) +
            '</div>' +
          '</button>' +
          '<ul class="dropdown-menu dropdown-menu-end shadow-sm" aria-labelledby="userMenuBtn" style="min-width:200px;font-size:0.88rem;">' +
            '<li class="px-3 py-2 border-bottom">' +
              '<div class="fw-bold text-dark text-truncate">' + escapeHtml(user.name) + '</div>' +
              '<div class="text-muted small text-truncate">' + escapeHtml(user.email) + '</div>' +
            '</li>' +
            (user.role === 'admin' ? '<li><a class="dropdown-item py-2" href="admin/dashboard.php"><i class="bi bi-speedometer2 me-2 text-ct"></i>Admin Dashboard</a></li>' : '') +
            '<li><a class="dropdown-item py-2" href="track-order.php"><i class="bi bi-box-seam me-2"></i>Track Orders</a></li>' +
            '<li><a class="dropdown-item py-2" href="cart.php"><i class="bi bi-cart3 me-2"></i>My Cart</a></li>' +
            '<li><hr class="dropdown-divider my-1"></li>' +
            '<li><a class="dropdown-item py-2 text-danger" href="#" id="globalLogoutBtn"><i class="bi bi-box-arrow-right me-2"></i>Log Out</a></li>' +
          '</ul>';

        container.querySelector('#userMenuBtn').setAttribute('title', user.name);

        accountLink.parentNode.replaceChild(container, accountLink);

        var logoutBtn = document.getElementById('globalLogoutBtn');
        if (logoutBtn) {
          logoutBtn.addEventListener('click', function(e) {
            e.preventDefault();
            fetch('api/auth/logout.php')
              .then(function() {
                showToast('Logged out successfully', 'info');
                setTimeout(function() { window.location.reload(); }, 600);
              });
          });
        }
      }
    })
    .catch(function() {
      // If DB/backend is offline, link stays as standard login.php link
    });
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
  initUserAuth();
});
