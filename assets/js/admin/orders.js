// ====================================================
// ORDER DATA
// ====================================================
let orders = [];
let currentOrderId = null;
const orderModal = new bootstrap.Modal(document.getElementById('orderModal'));

// ====================================================
// STATUS BADGE helper
// ====================================================
const STATUS_CONFIG = {
  'Pending':         { bg:'#fef3c7', color:'#78350f' },
  'Processing':      { bg:'#dbeafe', color:'#1e3a8a' },
  'Ready for Pickup':{ bg:'#fde68a', color:'#78350f' },
  'Out for Delivery':{ bg:'#e0f2fe', color:'#0369a1' },
  'Completed':       { bg:'#d1fae5', color:'#065f46' },
  'Cancelled':       { bg:'#fee2e2', color:'#7f1d1d' },
};

function statusBadgeHtml(status) {
  const cfg = STATUS_CONFIG[status] || { bg:'#f3f4f6', color:'#374151' };
  return `<span class="badge rounded-pill fw-600" style="background:${cfg.bg};color:${cfg.color};font-size:0.72rem;">${status}</span>`;
}

function fulfillmentBadgeHtml(f) {
  return f === 'Delivery'
    ? `<span class="badge bg-info-subtle text-info-emphasis rounded-pill td-sm-badge">Delivery</span>`
    : `<span class="badge bg-secondary-subtle text-secondary-emphasis rounded-pill td-sm-badge">Pickup</span>`;
}

// ====================================================
// PAGINATION STATE & RENDER
// ====================================================
const PAGE_SIZE = 10;
let currentPage = 1;
let currentFilteredOrders = [];

function renderPagination() {
  const paginationEl = document.getElementById('pagination');
  if (!paginationEl) return;
  const total = currentFilteredOrders.length;
  const totalPages = Math.ceil(total / PAGE_SIZE) || 1;

  if (totalPages <= 1) {
    paginationEl.innerHTML = '';
    return;
  }

  let html = '';
  const prevDisabled = currentPage === 1 ? 'disabled' : '';
  html += `<li class="page-item ${prevDisabled}"><a class="page-link" href="#" onclick="changePage(${currentPage - 1}, event)" aria-label="Previous"><i class="bi bi-chevron-left"></i></a></li>`;

  for (let p = 1; p <= totalPages; p++) {
    const active = p === currentPage ? 'active' : '';
    html += `<li class="page-item ${active}"><a class="page-link" href="#" onclick="changePage(${p}, event)">${p}</a></li>`;
  }

  const nextDisabled = currentPage === totalPages ? 'disabled' : '';
  html += `<li class="page-item ${nextDisabled}"><a class="page-link" href="#" onclick="changePage(${currentPage + 1}, event)" aria-label="Next"><i class="bi bi-chevron-right"></i></a></li>`;

  paginationEl.innerHTML = html;
}

function changePage(p, e) {
  if (e) e.preventDefault();
  const totalPages = Math.ceil(currentFilteredOrders.length / PAGE_SIZE) || 1;
  if (p < 1 || p > totalPages) return;
  currentPage = p;
  renderCurrentPage();
}
window.changePage = changePage;

function renderCurrentPage() {
  const tbody = document.getElementById('ordersTbody');
  const countEl = document.getElementById('orderCount');
  const total = currentFilteredOrders.length;
  const totalPages = Math.ceil(total / PAGE_SIZE) || 1;

  if (currentPage > totalPages) currentPage = totalPages;
  if (currentPage < 1) currentPage = 1;

  const start = (currentPage - 1) * PAGE_SIZE;
  const end = Math.min(start + PAGE_SIZE, total);
  const paged = currentFilteredOrders.slice(start, end);

  if (countEl) {
    if (total === 0) {
      countEl.textContent = '0';
    } else if (total <= PAGE_SIZE) {
      countEl.textContent = total;
    } else {
      countEl.textContent = `${start + 1}–${end} of ${total}`;
    }
  }

  if (!paged.length) {
    tbody.innerHTML = '<tr><td colspan="9" class="text-center py-5 text-muted">No orders found for this filter.</td></tr>';
    renderPagination();
    return;
  }

  tbody.innerHTML = paged.map(o => {
    const itemSummary = o.items.map(i => `${i.name} ×${i.qty}`).join(', ');
    const total = o.items.reduce((sum, i) => sum + i.price * i.qty, 0);
    return `
      <tr data-id="${o.id}" data-status="${o.status}">
        <td class="ps-4 text-sm fw-700">#${o.id}</td>
        <td class="d-none d-md-table-cell text-xs text-muted">${formatDate(o.date)}</td>
        <td >${o.customer.name}</td>
        <td class="d-none d-lg-table-cell text-xs text-muted text-truncate" style="max-width:180px;">${itemSummary}</td>
        <td class="fw-700 text-ct">₱${total.toLocaleString()}</td>
        <td class="d-none d-md-table-cell">${fulfillmentBadgeHtml(o.fulfillment)}</td>
        <td class="d-none d-lg-table-cell" >${o.payment}</td>
        <td class="status-cell">${statusBadgeHtml(o.status)}</td>
        <td class="pe-4">
          <button class="btn btn-sm btn-ct-outline text-xs" onclick="openOrderModal('${o.id}')">
            <i class="bi bi-eye me-1"></i>View
          </button>
        </td>
      </tr>`;
  }).join('');

  renderPagination();
}

// ====================================================
// RENDER TABLE
// ====================================================
function renderOrders(list) {
  currentFilteredOrders = list;
  renderCurrentPage();
}

function formatDate(d) {
  return new Date(d).toLocaleDateString('en-PH', { month:'short', day:'numeric', year:'numeric' });
}

// ====================================================
// FILTER TABS & SEARCH
// ====================================================
let activeStatusFilter = 'All';
let activeSearchQuery  = '';

function applyFilters() {
  const q = activeSearchQuery.trim().toLowerCase();
  currentPage = 1;
  const filtered = orders.filter(o => {
    const matchStatus = (activeStatusFilter === 'All') || (o.status === activeStatusFilter);
    if (!matchStatus) return false;
    if (!q) return true;
    const haystack = [
      o.id,
      (o.customer && o.customer.name) || '',
      (o.customer && o.customer.phone) || '',
      (o.customer && o.customer.email) || '',
      (o.customer && o.customer.address) || ''
    ].join(' ').toLowerCase();
    return haystack.includes(q);
  });
  renderOrders(filtered);
}

function filterOrders(status, btn) {
  document.querySelectorAll('#orderTabs .nav-link').forEach(el => el.classList.remove('active'));
  btn.classList.add('active');
  activeStatusFilter = status;
  applyFilters();
}

function searchOrders(query) {
  activeSearchQuery = query;
  applyFilters();
}

// ====================================================
// ORDER DETAIL MODAL
// ====================================================
function openOrderModal(id) {
  const o = orders.find(x => x.id === id);
  if (!o) return;
  currentOrderId = id;

  document.getElementById('orderModalLabel').textContent = `Order #${o.id}`;
  document.getElementById('modalOrderDate').textContent  = 'Placed: ' + formatDate(o.date);

  // Customer
  document.getElementById('modalCustomerName').textContent    = o.customer.name;
  document.getElementById('modalCustomerEmail').textContent   = o.customer.email;
  const cleanPhone = (o.customer.phone || '').replace(/[^0-9+]/g, '');
  let phoneHtml = cleanPhone ? `<a href="tel:${cleanPhone}" class="text-decoration-none fw-600"><i class="bi bi-telephone me-1"></i>${o.customer.phone}</a>` : (o.customer.phone || '—');
  if (cleanPhone && (o.fulfillment === 'Delivery' || o.fulfillment === 'Local Delivery')) {
    const smsBody = encodeURIComponent(`Hi ${o.customer.name}, this is Cheyn's Gadgets regarding Order #${o.id}. Our staff is coordinating your delivery.`);
    phoneHtml += ` <a href="sms:${cleanPhone}?body=${smsBody}" class="btn btn-sm btn-outline-success py-0 px-2 ms-2 text-xs" title="Message customer for dispatch"><i class="bi bi-chat-text me-1"></i>SMS</a>`;
  }
  document.getElementById('modalCustomerPhone').innerHTML   = phoneHtml;
  document.getElementById('modalCustomerAddress').textContent = o.customer.address;
  const notesEl = document.getElementById('modalCustomerNotes');
  if (notesEl) {
    notesEl.textContent = o.notes ? o.notes : '—';
  }

  // Items
  const total = o.items.reduce((s, i) => s + i.price * i.qty, 0);
  document.getElementById('modalItemsList').innerHTML = o.items.map(i => `
    <div class="d-flex justify-content-between align-items-start py-2 border-bottom" >
      <div>
        <div class="fw-600">${i.name}</div>
        <div class="text-muted text-xs">Qty: ${i.qty}</div>
      </div>
      <div class="fw-700 text-nowrap ms-3">₱${(i.price * i.qty).toLocaleString()}</div>
    </div>
  `).join('');
  document.getElementById('modalTotal').textContent = '₱' + total.toLocaleString();

  // Fulfillment + Payment
  document.getElementById('modalFulfillment').textContent = o.fulfillment;
  document.getElementById('modalPayment').textContent     = o.payment;
  document.getElementById('modalPaid').innerHTML = o.paid
    ? '<span class="badge bg-success-subtle text-success-emphasis rounded-pill">Paid</span>'
    : '<span class="badge bg-warning-subtle text-warning-emphasis rounded-pill">Unpaid</span>';

  // Status select
  document.getElementById('modalStatusSelect').value = o.status;

  // History
  renderStatusHistory(o.history);

  orderModal.show();
}

function renderStatusHistory(history) {
  const ul = document.getElementById('modalStatusHistory');
  ul.innerHTML = [...history].reverse().map((h, i) => {
    const cfg = STATUS_CONFIG[h.status] || { bg:'#f3f4f6', color:'#374151' };
    return `
      <li class="d-flex gap-2 mb-3">
        <div style="width:28px;height:28px;border-radius:50%;background:${cfg.bg};display:flex;align-items:center;justify-content:center;flex-shrink:0;margin-top:2px;">
          <i class="bi bi-check2" style="color:${cfg.color};font-size:0.8rem;"></i>
        </div>
        <div>
          <div class="fw-600" >${h.status}</div>
          <div class="text-muted text-xs">${h.date}</div>
          <div >${h.note}</div>
        </div>
      </li>`;
  }).join('');
}

// ====================================================
// UPDATE STATUS
// ====================================================
async function updateOrderStatus() {
  const o = orders.find(x => x.id === currentOrderId);
  if (!o) return;
  const newStatus = document.getElementById('modalStatusSelect').value;
  if (newStatus === o.status) { showToast('Status unchanged.', ''); return; }

  // Safeguard against invalid status transitions
  if (o.status === 'Cancelled' && newStatus !== 'Cancelled') {
    showToast('Cancelled orders cannot be reopened directly to preserve stock integrity.', 'toast-warning');
    document.getElementById('modalStatusSelect').value = 'Cancelled';
    return;
  }

  try {
    const res = await fetch('../api/admin/orders.php', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json',
        'X-CSRF-Token': document.querySelector('meta[name="csrf-token"]')?.content || ''
      },
      body: JSON.stringify({
        id: o.order_id || o.id,
        status: newStatus
      })
    });
    const result = await res.json();
    if (!res.ok || !result.success) {
      throw new Error(result.error || 'Failed to update order status');
    }
  } catch (err) {
    showToast(err.message || 'Failed to update order status on server.', 'toast-danger');
    document.getElementById('modalStatusSelect').value = o.status;
    return;
  }

  const now = new Date().toLocaleString('en-PH', {year:'numeric',month:'2-digit',day:'2-digit',hour:'2-digit',minute:'2-digit'}).replace(',','');
  if (!o.history) o.history = [];
  o.history.push({ date: now, status: newStatus, note: `Status updated by admin.` });
  o.status = newStatus;

  // Update row badge live
  const row = document.querySelector(`tr[data-id="${currentOrderId}"]`);
  if (row) {
    row.setAttribute('data-status', newStatus);
    const statusCell = row.querySelector('.status-cell');
    if (statusCell) statusCell.innerHTML = statusBadgeHtml(newStatus);
  }

  renderStatusHistory(o.history);
  updateCounters();
  showToast(`Order #${currentOrderId} updated to "${newStatus}"`, 'toast-success');
}

function cancelOrder() {
  document.getElementById('modalStatusSelect').value = 'Cancelled';
  updateOrderStatus();
}

// ====================================================
// COUNTER UPDATE
// ====================================================
function updateCounters() {
  const counts = { All: orders.length, Pending:0, Processing:0, 'Ready for Pickup':0, 'Out for Delivery':0, Completed:0 };
  orders.forEach(o => { if (counts[o.status] !== undefined) counts[o.status]++; });
  document.getElementById('countAll').textContent          = counts.All;
  document.getElementById('countPending').textContent      = counts.Pending;
  document.getElementById('countProcessing').textContent   = counts.Processing;
  document.getElementById('countReady').textContent        = counts['Ready for Pickup'];
  document.getElementById('countOutForDelivery').textContent = counts['Out for Delivery'];
  document.getElementById('countCompleted').textContent    = counts.Completed;
}

// ====================================================
// EXPORT CSV
// ====================================================
function exportCSV() {
  window.location.href = '../api/admin/orders.php?export=csv';
  showToast('Downloading orders CSV…', 'toast-success');
}

// ====================================================
// TOAST
// ====================================================
function showToast(msg, cls='') {
  const t = document.getElementById('toastMsg');
  t.textContent = msg;
  t.className = 'toast-ct show ' + cls;
  setTimeout(() => t.className = 'toast-ct', 3200);
}

// ====================================================
// LOAD ORDERS FROM API
// ====================================================
async function loadOrders() {
  try {
    const res = await fetch('../api/admin/orders.php', {
      headers: { 'Accept': 'application/json' },
      cache: 'no-store'
    });
    if (res.ok) {
      const data = await res.json();
      if (data && data.success && Array.isArray(data.orders)) {
        orders = data.orders;
      }
    } else {
      console.warn('Admin orders API returned HTTP ' + res.status);
    }
  } catch (err) {
    console.warn('Failed to fetch orders from API:', err);
  }

  renderOrders(orders);
  updateCounters();
}

// Init
if (document.readyState === 'loading') {
  document.addEventListener('DOMContentLoaded', loadOrders);
} else {
  loadOrders();
}
