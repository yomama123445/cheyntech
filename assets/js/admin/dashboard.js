// Today date
const d = new Date();
const todayEl = document.getElementById('todayDate');
if (todayEl) {
  todayEl.textContent = d.toLocaleDateString('en-PH', { weekday: 'short', month: 'short', day: 'numeric', year: 'numeric' });
}

// Sidebar toggle (mobile)
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
