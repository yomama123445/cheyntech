<?php
$pageTitle       = 'Customer Inquiries | Cheyn Gadgets Admin';
$pageDescription = 'Cheyn Gadgets Admin — View and manage customer inquiries and password reset requests.';
$adminActivePage = 'inquiries';
require '../includes/admin_header.php';
require '../includes/admin_sidebar.php';
?>

    <!-- TOP BAR -->
    <header class="admin-topbar">
      <button class="btn btn-sm btn-outline-secondary d-lg-none me-2" id="sidebarToggle" aria-label="Toggle sidebar">
        <i class="bi bi-list fs-5"></i>
      </button>
      <h5 class="mb-0 me-auto">Customer Inquiries</h5>
      <div class="d-flex align-items-center gap-2 gap-sm-3">
        <a href="../index.php" class="admin-view-store-btn" title="View Customer Storefront">
          <i class="bi bi-arrow-up-right small text-muted"></i>
          <span class="d-none d-sm-inline">View Store</span>
        </a>
        <div class="dropdown">
          <button class="btn p-0 d-flex align-items-center gap-2 admin-profile-btn" id="profileDropdown" data-bs-toggle="dropdown" aria-expanded="false">
            <div class="admin-user-avatar"><?= strtoupper(substr($_SESSION['user_name'] ?? 'A', 0, 1)) ?></div>
            <span class="fw-600 d-none d-md-inline admin-username"><?= htmlspecialchars($_SESSION['user_name'] ?? 'Admin') ?></span>
            <i class="bi bi-chevron-down admin-chevron d-none d-md-inline"></i>
          </button>
          <ul class="dropdown-menu dropdown-menu-end admin-profile-menu" aria-labelledby="profileDropdown">
            <li class="admin-profile-header px-3 py-2">
              <div class="d-flex align-items-center gap-2">
                <div class="admin-user-avatar"><?= strtoupper(substr($_SESSION['user_name'] ?? 'A', 0, 1)) ?></div>
                <div>
                  <div class="fw-700 admin-profile-name"><?= htmlspecialchars($_SESSION['user_name'] ?? 'Admin') ?></div>
                  <div class="text-muted admin-profile-role"><?= ucfirst(htmlspecialchars($_SESSION['user_role'] ?? 'Administrator')) ?></div>
                </div>
              </div>
            </li>
            <li><hr class="dropdown-divider my-1"></li>
            <li><a class="dropdown-item" href="../index.php"><i class="bi bi-house me-2"></i>Return to Store</a></li>
            <li><a class="dropdown-item" href="../profile.php"><i class="bi bi-person me-2"></i>My Profile</a></li>
            <li><a class="dropdown-item" href="settings.php"><i class="bi bi-gear me-2"></i>Settings</a></li>
            <li><hr class="dropdown-divider my-1"></li>
            <li><a class="dropdown-item text-danger" href="../login.php?action=logout"><i class="bi bi-box-arrow-left me-2"></i>Logout</a></li>
          </ul>
        </div>
      </div>
    </header>

    <!-- MAIN AREA -->
    <main class="admin-main">

      <!-- Summary stat mini-cards -->
      <div class="row g-3 mb-4">
        <div class="col-6 col-md-4">
          <div class="stat-card">
            <div class="stat-label">Total Inquiries</div>
            <div class="stat-value" id="countAll">0</div>
          </div>
        </div>
        <div class="col-6 col-md-4">
          <div class="stat-card">
            <div class="stat-label">General Messages</div>
            <div class="stat-value text-primary" id="countGeneral">0</div>
          </div>
        </div>
        <div class="col-12 col-md-4">
          <div class="stat-card">
            <div class="stat-label">Password Reset Requests</div>
            <div class="stat-value text-danger" id="countReset">0</div>
          </div>
        </div>
      </div>

      <!-- Inquiries Table Card -->
      <div class="card border-0 shadow-sm rounded-4">
        <div class="card-header bg-white border-0 pt-4 px-4 pb-0 d-flex flex-wrap justify-content-between align-items-center gap-2">
          <h5 class="h6 fw-bold mb-0"><i class="bi bi-chat-left-dots me-2 text-primary"></i>Customer Messages</h5>
          <span class="badge bg-light text-muted border px-2 py-1 small" id="inquiryBadge">Loading…</span>
        </div>
        <div class="card-body p-0 mt-3">
          <div class="table-responsive">
            <table class="table table-hover align-middle mb-0" id="inquiriesTable">
              <thead class="table-light text-muted small text-uppercase">
                <tr>
                  <th class="ps-4">Sender</th>
                  <th>Contact Info</th>
                  <th>Product / Topic</th>
                  <th>Message Preview</th>
                  <th>Date</th>
                  <th class="pe-4 text-end">Action</th>
                </tr>
              </thead>
              <tbody id="inquiriesTbody">
                <tr>
                  <td colspan="6" class="text-center py-5 text-muted">
                    <div class="spinner-border spinner-border-sm text-primary me-2" role="status"></div> Loading inquiries…
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>

    </main>
  </div><!-- /admin-content -->
</div><!-- /admin-layout -->

<!-- INQUIRY DETAIL MODAL -->
<div class="modal fade" id="inquiryModal" tabindex="-1" aria-labelledby="inquiryModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content rounded-4 border-0 shadow">
      <div class="modal-header border-0 pb-0">
        <div>
          <h5 class="modal-title fw-bold" id="inquiryModalLabel">Customer Inquiry</h5>
          <span class="text-muted small" id="modalInquiryDate"></span>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body py-4">
        <div class="p-3 bg-light rounded-3 mb-3">
          <div class="row g-2 small">
            <div class="col-4 text-muted">Sender Name:</div>
            <div class="col-8 fw-semibold text-dark" id="modalSenderName">—</div>
            <div class="col-4 text-muted">Email:</div>
            <div class="col-8" id="modalSenderEmail">—</div>
            <div class="col-4 text-muted">Phone:</div>
            <div class="col-8" id="modalSenderPhone">—</div>
            <div class="col-4 text-muted">Topic:</div>
            <div class="col-8" id="modalInquiryTopic">—</div>
          </div>
        </div>

        <h6 class="fw-bold mb-2 small text-uppercase text-muted">Message Content</h6>
        <div class="p-3 bg-white border rounded-3 mb-3 text-break" id="modalInquiryMessage" style="max-height: 220px; overflow-y: auto; font-size: 0.92rem;">
        </div>
      </div>
      <div class="modal-footer border-0 pt-0">
        <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-danger btn-sm" id="modalDeleteBtn" onclick="deleteCurrentInquiry()">
          <i class="bi bi-trash me-1"></i>Delete Message
        </button>
      </div>
    </div>
  </div>
</div>

<div class="toast-ct" id="toastMsg" role="alert" aria-live="polite"></div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
let inquiries = [];
let currentInquiryId = null;
const inquiryModal = new bootstrap.Modal(document.getElementById('inquiryModal'));

function showToast(msg, cls = '') {
  const t = document.getElementById('toastMsg');
  if (!t) return;
  t.textContent = msg;
  t.className = 'toast-ct show ' + cls;
  setTimeout(() => t.className = 'toast-ct', 3000);
}

function escapeHtml(str) {
  const div = document.createElement('div');
  div.textContent = str || '';
  return div.innerHTML;
}

async function loadInquiries() {
  const tbody = document.getElementById('inquiriesTbody');
  try {
    const res = await fetch('../api/admin/inquiries.php', {
      headers: { 'Accept': 'application/json' },
      cache: 'no-store'
    });
    const data = await res.json();
    if (res.ok && data.success && Array.isArray(data.inquiries)) {
      inquiries = data.inquiries;
      renderInquiries();
    } else {
      tbody.innerHTML = '<tr><td colspan="6" class="text-center py-4 text-danger">Failed to load inquiries.</td></tr>';
    }
  } catch (err) {
    tbody.innerHTML = '<tr><td colspan="6" class="text-center py-4 text-danger">Network error loading inquiries.</td></tr>';
  }
}

function renderInquiries() {
  const tbody = document.getElementById('inquiriesTbody');
  const countAll = document.getElementById('countAll');
  const countGeneral = document.getElementById('countGeneral');
  const countReset = document.getElementById('countReset');
  const badge = document.getElementById('inquiryBadge');

  const resets = inquiries.filter(i => i.isReset).length;
  const generals = inquiries.length - resets;

  if (countAll) countAll.textContent = inquiries.length;
  if (countGeneral) countGeneral.textContent = generals;
  if (countReset) countReset.textContent = resets;
  if (badge) badge.textContent = `${inquiries.length} total`;

  if (!inquiries.length) {
    tbody.innerHTML = '<tr><td colspan="6" class="text-center py-5 text-muted"><i class="bi bi-inbox fs-3 d-block mb-2 text-secondary"></i>No customer inquiries recorded yet.</td></tr>';
    return;
  }

  tbody.innerHTML = inquiries.map(i => {
    const topicBadge = i.isReset 
      ? '<span class="badge bg-danger-subtle text-danger border border-danger-subtle">Password Reset</span>'
      : `<span class="badge bg-secondary-subtle text-dark border">${escapeHtml(i.productName)}</span>`;

    const cleanPhone = (i.phone || '').replace(/[^0-9+]/g, '');
    const phoneHtml = cleanPhone ? `<br><a href="tel:${cleanPhone}" class="text-muted small text-decoration-none"><i class="bi bi-telephone me-1"></i>${escapeHtml(i.phone)}</a>` : '';

    return `
      <tr>
        <td class="ps-4 fw-semibold text-dark">${escapeHtml(i.name)}</td>
        <td>
          <a href="mailto:${escapeHtml(i.email)}" class="text-decoration-none text-dark">${escapeHtml(i.email)}</a>
          ${phoneHtml}
        </td>
        <td>${topicBadge}</td>
        <td class="text-muted small text-truncate" style="max-width: 240px;">${escapeHtml(i.message)}</td>
        <td class="text-muted small">${escapeHtml(i.date)}</td>
        <td class="pe-4 text-end">
          <button class="btn btn-sm btn-ct-outline" onclick="openInquiryModal(${i.id})">
            <i class="bi bi-eye me-1"></i>Read
          </button>
        </td>
      </tr>`;
  }).join('');
}

function openInquiryModal(id) {
  const item = inquiries.find(x => x.id === id);
  if (!item) return;
  currentInquiryId = id;

  document.getElementById('modalInquiryDate').textContent = item.date;
  document.getElementById('modalSenderName').textContent = item.name;
  document.getElementById('modalSenderEmail').innerHTML = `<a href="mailto:${encodeURIComponent(item.email)}">${escapeHtml(item.email)}</a>`;
  document.getElementById('modalSenderPhone').textContent = item.phone || 'None provided';
  document.getElementById('modalInquiryTopic').textContent = item.productName;
  document.getElementById('modalInquiryMessage').textContent = item.message;

  inquiryModal.show();
}

async function deleteCurrentInquiry() {
  if (!currentInquiryId) return;
  const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content || '';

  try {
    const res = await fetch('../api/admin/inquiries.php', {
      method: 'DELETE',
      headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json',
        'X-CSRF-Token': csrfToken
      },
      body: JSON.stringify({ id: currentInquiryId })
    });
    const data = await res.json();
    if (res.ok && data.success) {
      inquiries = inquiries.filter(x => x.id !== currentInquiryId);
      inquiryModal.hide();
      renderInquiries();
      showToast('Inquiry removed successfully.', 'toast-success');
    } else {
      showToast(data.error || 'Failed to remove inquiry.', 'toast-danger');
    }
  } catch (err) {
    showToast('Network error removing inquiry.', 'toast-danger');
  }
}

document.addEventListener('DOMContentLoaded', loadInquiries);
</script>
</body>
</html>
