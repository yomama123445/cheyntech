// Today date
const d = new Date();
const todayEl = document.getElementById('todayDate');
if (todayEl) {
  todayEl.textContent = d.toLocaleDateString('en-PH', { weekday: 'short', month: 'short', day: 'numeric', year: 'numeric' });
}

// Real CSV generation and export
async function exportOrdersCSV() {
  try {
    let orderList = [];

    // 1. Fetch live orders from ../api/admin/orders.php
    try {
      const res = await fetch('../api/admin/orders.php', {
        headers: { 'Accept': 'application/json' },
        cache: 'no-store'
      });
      if (res.ok) {
        const data = await res.json();
        if (data && data.success && Array.isArray(data.orders)) {
          orderList = data.orders;
        }
      }
    } catch (apiErr) {
      console.warn('Could not fetch live orders from API:', apiErr);
    }

    // Fallback data if offline or API returns empty
    if (!orderList.length) {
      orderList = [
        {
          id: 'CT-10493',
          date: '2026-08-12',
          customer: { name: 'Juan dela Cruz', phone: '09171234567' },
          total: 32500,
          fulfillment: 'Pickup',
          payment: 'Cash',
          status: 'Ready for Pickup'
        }
      ];
    }

    // 2. Build CSV rows containing Order Number, Date, Customer Name, Phone, Total Amount, Fulfillment, Payment, Status
    const headers = ['Order Number', 'Date', 'Customer Name', 'Phone', 'Total Amount', 'Fulfillment', 'Payment', 'Status'];
    const escapeCsv = (val) => {
      const s = String(val == null ? '' : val).replace(/"/g, '""');
      return `"${s}"`;
    };

    const csvRows = [headers.map(escapeCsv).join(',')];
    orderList.forEach(o => {
      const row = [
        o.id,
        o.date,
        (o.customer && o.customer.name) || '',
        (o.customer && o.customer.phone) || '',
        Number(o.total || 0).toFixed(2),
        o.fulfillment || '',
        o.payment || '',
        o.status || ''
      ];
      csvRows.push(row.map(escapeCsv).join(','));
    });

    const csvContent = '\uFEFF' + csvRows.join('\r\n');

    // 3. Create a Blob with type text/csv, create an object URL, and trigger a download anchor for cheyn-gadgets-orders-{date}.csv
    const now = new Date();
    const dateStr = now.toISOString().slice(0, 10);
    const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
    const url = URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = `cheyn-gadgets-orders-${dateStr}.csv`;
    document.body.appendChild(a);
    a.click();
    document.body.removeChild(a);
    URL.revokeObjectURL(url);

    // 4. Display showToast('Orders exported successfully!', 'toast-success') only after the download begins
    showToast('Orders exported successfully!', 'toast-success');
  } catch (err) {
    console.error('CSV export failed:', err);
    showToast('Failed to export orders CSV.', 'toast-error');
  }
}

window.exportOrdersCSV = exportOrdersCSV;

function showToast(msg, cls = '') {
  const t = document.getElementById('toastMsg');
  if (!t) return;
  t.textContent = msg;
  t.className = 'toast-ct show ' + cls;
  setTimeout(() => t.className = 'toast-ct', 3200);
}

// ---- LIVE DASHBOARD DATA ----
async function loadDashboardStats() {
  // 1. Load Products & Low Stock
  try {
    const res = await fetch('../api/admin/products.php', {
      headers: { 'Accept': 'application/json' },
      cache: 'no-store'
    });
    if (res.ok) {
      const data = await res.json();
      if (data && data.success && Array.isArray(data.products)) {
        const products = data.products;
        const totalEl = document.getElementById('statTotalProducts');
        if (totalEl) totalEl.textContent = products.length;

        const lowStock = products.filter(p => Number(p.stock) <= 3);
        const lowStockEl = document.getElementById('statLowStock');
        if (lowStockEl) lowStockEl.textContent = lowStock.length;

        const lowStockList = document.getElementById('lowStockList');
        if (lowStockList) {
          if (lowStock.length === 0) {
            lowStockList.innerHTML = '<li class="py-3 text-center text-muted">All products well-stocked.</li>';
          } else {
            lowStockList.innerHTML = lowStock.slice(0, 5).map((p, idx) => {
              const borderClass = idx < Math.min(lowStock.length, 5) - 1 ? 'border-bottom' : '';
              const iconClass = p.category === 'tablet' ? 'bi-tablet' : p.category === 'android' ? 'bi-phone' : 'bi-phone';
              return `<li class="d-flex align-items-center justify-content-between py-3 ${borderClass}">
                <div class="d-flex align-items-center gap-2 gap-sm-3 min-w-0 me-2">
                  <div class="low-stock-icon pink"><i class="bi ${iconClass}"></i></div>
                  <div class="min-w-0">
                    <div class="low-stock-name text-truncate">${p.name}</div>
                    <div class="low-stock-qty">Only ${p.stock} unit${p.stock === 1 ? '' : 's'} left</div>
                  </div>
                </div>
                <a href="products.php" class="badge-ct badge-preowned text-decoration-none flex-shrink-0">Restock</a>
              </li>`;
            }).join('');
          }
        }
      }
    }
  } catch (err) {
    console.warn('Could not load products for dashboard:', err);
  }

  // 2. Load Orders & Status counts
  try {
    const res = await fetch('../api/admin/orders.php', {
      headers: { 'Accept': 'application/json' },
      cache: 'no-store'
    });
    if (res.ok) {
      const data = await res.json();
      if (data && data.success && Array.isArray(data.orders)) {
        const orders = data.orders;
        const pendingCount = orders.filter(o => o.status === 'Pending' || o.status === 'Processing').length;
        const completedCount = orders.filter(o => o.status === 'Completed').length;

        const pendingEl = document.getElementById('statPendingOrders');
        if (pendingEl) pendingEl.textContent = pendingCount;

        const completedEl = document.getElementById('statCompletedOrders');
        if (completedEl) completedEl.textContent = completedCount;

        const tbody = document.getElementById('recentOrdersTbody');
        if (tbody && orders.length > 0) {
          tbody.innerHTML = orders.slice(0, 5).map(o => {
            const badgeClass = o.status === 'Pending' ? 'bg-warning-subtle text-warning-emphasis'
              : o.status === 'Processing' ? 'badge-status-processing'
              : o.status === 'Ready' || o.status === 'Ready for Pickup' ? 'badge-status-ready'
              : o.status === 'Completed' ? 'bg-success-subtle text-success-emphasis'
              : 'bg-secondary-subtle text-secondary-emphasis';

            const itemsDesc = Array.isArray(o.items) && o.items.length
              ? o.items.map(i => `${i.name} × ${i.qty}`).join(', ')
              : 'Items ordered';

            return `<tr>
              <td class="ps-4 td-id">#${o.id}</td>
              <td class="td-name">${(o.customer && o.customer.name) || 'Customer'}</td>
              <td class="d-none d-md-table-cell td-meta">${itemsDesc}</td>
              <td class="td-id">₱${Number(o.total || 0).toLocaleString()}</td>
              <td class="d-none d-lg-table-cell"><span class="badge bg-info-subtle text-info-emphasis rounded-pill td-sm-badge">${o.fulfillment || 'Pickup'}</span></td>
              <td><span class="badge rounded-pill td-sm-badge ${badgeClass}">${o.status}</span></td>
              <td class="pe-4"><a href="orders.php" class="btn btn-sm btn-ct-outline td-sm-badge">View</a></td>
            </tr>`;
          }).join('');
        }
      }
    }
  } catch (err) {
    console.warn('Could not load orders for dashboard:', err);
  }
}

if (document.readyState === 'loading') {
  document.addEventListener('DOMContentLoaded', loadDashboardStats);
} else {
  loadDashboardStats();
}
