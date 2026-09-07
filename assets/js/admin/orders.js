// ====================================================
// ORDER DATA
// ====================================================
const orders = [
  {
    id: 'CT-0091', date: '2026-08-27', status: 'Pending',
    customer: { name:'Maria Santos', email:'maria.santos@email.com', phone:'+63 917 123 4567', address:'456 Rizal St., Makati City, Metro Manila' },
    items: [{ name:'iPhone 14 Pro 256GB (Deep Purple)', qty:1, price:48000 }],
    fulfillment: 'Delivery', payment: 'GCash', paid: true,
    history: [{ date:'2026-08-27 09:12', status:'Pending', note:'Order placed by customer.' }]
  },
  {
    id: 'CT-0090', date: '2026-08-26', status: 'Processing',
    customer: { name:'Juan dela Cruz', email:'juan.delacruz@email.com', phone:'+63 918 234 5678', address:'789 Bonifacio Ave., Quezon City, Metro Manila' },
    items: [{ name:'Samsung Galaxy S24 Ultra 512GB', qty:1, price:72500 }],
    fulfillment: 'Pickup', payment: 'Bank Transfer', paid: true,
    history: [
      { date:'2026-08-26 14:00', status:'Pending', note:'Order placed.' },
      { date:'2026-08-26 15:30', status:'Processing', note:'Payment verified. Preparing item.' }
    ]
  },
  {
    id: 'CT-0089', date: '2026-08-25', status: 'Ready for Pickup',
    customer: { name:'Ana Reyes', email:'ana.reyes@email.com', phone:'+63 919 345 6789', address:'123 Katipunan Ave., Quezon City, Metro Manila' },
    items: [
      { name:'iPad Air M2 256GB (Starlight)', qty:1, price:41999 },
      { name:'AirPods Pro 2nd Gen', qty:1, price:14999 }
    ],
    fulfillment: 'Pickup', payment: 'COD', paid: false,
    history: [
      { date:'2026-08-25 10:00', status:'Pending', note:'Order placed.' },
      { date:'2026-08-25 11:30', status:'Processing', note:'Items picked and packed.' },
      { date:'2026-08-25 14:00', status:'Ready for Pickup', note:'Ready at the store. Awaiting customer.' }
    ]
  },
  {
    id: 'CT-0088', date: '2026-08-24', status: 'Completed',
    customer: { name:'Carlo Mendoza', email:'carlo.mendoza@email.com', phone:'+63 920 456 7890', address:'22 Mabini St., Pasig City, Metro Manila' },
    items: [{ name:'iPhone 13 128GB Pre-owned (Midnight)', qty:2, price:19500 }],
    fulfillment: 'Pickup', payment: 'Cash', paid: true,
    history: [
      { date:'2026-08-24 09:00', status:'Pending', note:'Order placed.' },
      { date:'2026-08-24 10:00', status:'Processing', note:'Preparing items.' },
      { date:'2026-08-24 11:30', status:'Ready for Pickup', note:'Ready at store.' },
      { date:'2026-08-24 13:15', status:'Completed', note:'Customer picked up. Payment received.' }
    ]
  },
  {
    id: 'CT-0087', date: '2026-08-24', status: 'Out for Delivery',
    customer: { name:'Liza Bautista', email:'liza.bautista@email.com', phone:'+63 921 567 8901', address:'67 Taft Ave., Manila City, Metro Manila' },
    items: [{ name:'Xiaomi 14T Pro 256GB (Titan Black)', qty:1, price:29999 }],
    fulfillment: 'Delivery', payment: 'GCash', paid: true,
    history: [
      { date:'2026-08-24 08:00', status:'Pending', note:'Order placed.' },
      { date:'2026-08-24 09:30', status:'Processing', note:'Payment confirmed. Packing.' },
      { date:'2026-08-24 11:00', status:'Out for Delivery', note:'Handed to rider. ETA: 2–4 hrs.' }
    ]
  },
  {
    id: 'CT-0086', date: '2026-08-23', status: 'Completed',
    customer: { name:'Ricky Torres', email:'ricky.torres@email.com', phone:'+63 922 678 9012', address:'15 Shaw Blvd., Mandaluyong City, Metro Manila' },
    items: [{ name:'Apple Watch Series 9 45mm (Midnight)', qty:1, price:22999 }],
    fulfillment: 'Delivery', payment: 'PayMaya', paid: true,
    history: [
      { date:'2026-08-23 10:00', status:'Pending', note:'Order placed.' },
      { date:'2026-08-23 11:00', status:'Processing', note:'Payment confirmed.' },
      { date:'2026-08-23 13:00', status:'Out for Delivery', note:'On its way.' },
      { date:'2026-08-23 16:45', status:'Completed', note:'Delivered. Customer confirmed receipt.' }
    ]
  },
  {
    id: 'CT-0085', date: '2026-08-22', status: 'Processing',
    customer: { name:'Grace Villanueva', email:'grace.v@email.com', phone:'+63 923 789 0123', address:'8 EDSA, Caloocan City, Metro Manila' },
    items: [
      { name:'Oppo Find X7 Ultra 512GB', qty:1, price:54000 },
      { name:'Oppo Smart Tag', qty:2, price:999 }
    ],
    fulfillment: 'Delivery', payment: 'Bank Transfer', paid: true,
    history: [
      { date:'2026-08-22 14:00', status:'Pending', note:'Order placed.' },
      { date:'2026-08-22 16:00', status:'Processing', note:'Bank transfer confirmed.' }
    ]
  },
  {
    id: 'CT-0084', date: '2026-08-21', status: 'Pending',
    customer: { name:'Ben Aquino', email:'ben.aquino@email.com', phone:'+63 924 890 1234', address:'5 Dapitan St., Sampaloc, Manila' },
    items: [{ name:'Samsung Galaxy Tab S9 128GB (Refurbished)', qty:1, price:36000 }],
    fulfillment: 'Pickup', payment: 'COD', paid: false,
    history: [{ date:'2026-08-21 17:30', status:'Pending', note:'Order placed. Awaiting confirmation.' }]
  },
];

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
    ? `<span class="badge bg-info-subtle text-info-emphasis rounded-pill" class="td-sm-badge">Delivery</span>`
    : `<span class="badge bg-secondary-subtle text-secondary-emphasis rounded-pill" class="td-sm-badge">Pickup</span>`;
}

// ====================================================
// RENDER TABLE
// ====================================================
function renderOrders(list) {
  const tbody = document.getElementById('ordersTbody');
  document.getElementById('orderCount').textContent = list.length;
  if (!list.length) {
    tbody.innerHTML = '<tr><td colspan="9" class="text-center py-5 text-muted">No orders found for this filter.</td></tr>';
    return;
  }
  tbody.innerHTML = list.map(o => {
    const itemSummary = o.items.map(i => `${i.name} ×${i.qty}`).join(', ');
    const total = o.items.reduce((sum, i) => sum + i.price * i.qty, 0);
    return `
      <tr data-id="${o.id}" data-status="${o.status}">
        <td class="ps-4" class="text-sm fw-700">#${o.id}</td>
        <td class="d-none d-md-table-cell" class="text-xs text-muted">${formatDate(o.date)}</td>
        <td >${o.customer.name}</td>
        <td class="d-none d-lg-table-cell text-xs text-muted text-truncate" style="max-width:180px;">${itemSummary}</td>
        <td class="fw-700 text-ct">₱${total.toLocaleString()}</td>
        <td class="d-none d-md-table-cell">${fulfillmentBadgeHtml(o.fulfillment)}</td>
        <td class="d-none d-lg-table-cell" >${o.payment}</td>
        <td class="status-cell">${statusBadgeHtml(o.status)}</td>
        <td class="pe-4">
          <button class="btn btn-sm btn-outline-secondary" class="text-xs" onclick="openOrderModal('${o.id}')">
            <i class="bi bi-eye me-1"></i>View
          </button>
        </td>
      </tr>`;
  }).join('');
}

function formatDate(d) {
  return new Date(d).toLocaleDateString('en-PH', { month:'short', day:'numeric', year:'numeric' });
}

// ====================================================
// FILTER TABS
// ====================================================
function filterOrders(status, btn) {
  document.querySelectorAll('#orderTabs .nav-link').forEach(el => el.classList.remove('active'));
  btn.classList.add('active');
  const filtered = status === 'All' ? orders : orders.filter(o => o.status === status);
  renderOrders(filtered);
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
  document.getElementById('modalCustomerPhone').textContent   = o.customer.phone;
  document.getElementById('modalCustomerAddress').textContent = o.customer.address;

  // Items
  const total = o.items.reduce((s, i) => s + i.price * i.qty, 0);
  document.getElementById('modalItemsList').innerHTML = o.items.map(i => `
    <div class="d-flex justify-content-between align-items-start py-2 border-bottom" >
      <div>
        <div class="fw-600">${i.name}</div>
        <div class="text-muted" class="text-xs">Qty: ${i.qty}</div>
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
          <div class="text-muted" class="text-xs">${h.date}</div>
          <div >${h.note}</div>
        </div>
      </li>`;
  }).join('');
}

// ====================================================
// UPDATE STATUS
// ====================================================
function updateOrderStatus() {
  const o = orders.find(x => x.id === currentOrderId);
  if (!o) return;
  const newStatus = document.getElementById('modalStatusSelect').value;
  if (newStatus === o.status) { showToast('Status unchanged.', ''); return; }

  const now = new Date().toLocaleString('en-PH', {year:'numeric',month:'2-digit',day:'2-digit',hour:'2-digit',minute:'2-digit'}).replace(',','');
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
  const header = ['Order ID','Date','Customer','Total','Fulfillment','Payment','Status'];
  const rows   = orders.map(o => {
    const total = o.items.reduce((s,i) => s + i.price * i.qty, 0);
    return [o.id, o.date, o.customer.name, total, o.fulfillment, o.payment, o.status];
  });
  const csvContent = [header, ...rows].map(r => r.join(',')).join('\n');
  const blob = new Blob([csvContent], { type:'text/csv;charset=utf-8;' });
  const url  = URL.createObjectURL(blob);
  const a = document.createElement('a');
  a.href = url; a.download = 'cheyntech_orders.csv'; a.click();
  URL.revokeObjectURL(url);
  showToast('Orders exported to CSV!', 'toast-success');
}

// ====================================================
// SIDEBAR TOGGLE
// ====================================================
const sidebarToggle = document.getElementById('sidebarToggle');
const adminSidebar  = document.getElementById('adminSidebar');
const overlay       = document.getElementById('sidebarOverlay');
sidebarToggle && sidebarToggle.addEventListener('click', () => {
  adminSidebar.classList.toggle('open');
  overlay.style.display = adminSidebar.classList.contains('open') ? 'block' : 'none';
});
overlay && overlay.addEventListener('click', () => {
  adminSidebar.classList.remove('open');
  overlay.style.display = 'none';
});

// ====================================================
// TOAST
// ====================================================
function showToast(msg, cls='') {
  const t = document.getElementById('toastMsg');
  t.textContent = msg;
  t.className = 'toast-ct show ' + cls;
  setTimeout(() => t.className = 'toast-ct', 3200);
}

// Init
renderOrders(orders);
updateCounters();
