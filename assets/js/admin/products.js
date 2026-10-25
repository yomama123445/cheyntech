// ====== PRODUCT DATA (Loaded live from api/admin/products.php) ======
let products = [];
const PAGE_SIZE = 10;
let currentPage = 1;
let currentFilteredProducts = [];

let deleteTargetId = null;
const productModal     = new bootstrap.Modal(document.getElementById('productModal'));
const deleteModal      = new bootstrap.Modal(document.getElementById('deleteModal'));
const adjustStockModal = new bootstrap.Modal(document.getElementById('adjustStockModal'));

function openAdjustStockModal(id) {
  const p = products.find(x => String(x.id) === String(id));
  if (!p) return;
  document.getElementById('adjustStockProductId').value = p.id;
  document.getElementById('adjustStockProductName').textContent = `${p.name} (${p.storage && p.storage !== 'N/A' ? p.storage + ' · ' : ''}${p.color || ''})`;
  document.getElementById('adjustStockInput').value = p.stock || 0;
  adjustStockModal.show();
}

function stepAdjustStock(step) {
  const inp = document.getElementById('adjustStockInput');
  const current = parseInt(inp.value, 10) || 0;
  inp.value = Math.max(0, current + step);
}

async function submitAdjustStock() {
  const id = document.getElementById('adjustStockProductId').value;
  const newStock = Math.max(0, parseInt(document.getElementById('adjustStockInput').value, 10) || 0);
  const p = products.find(x => String(x.id) === String(id));
  if (!p) return;

  const btn = document.getElementById('confirmAdjustStockBtn');
  const originalHtml = btn.innerHTML;
  btn.disabled = true;
  btn.innerHTML = '<span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span> Saving...';

  const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content || '';

  try {
    const res = await fetch('../api/admin/products.php', {
      method: 'PUT',
      headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json',
        'X-CSRF-Token': csrfToken
      },
      body: JSON.stringify({
        id: p.id,
        stock: newStock
      })
    });
    const result = await res.json();
    if (!res.ok || !result.success) {
      throw new Error(result.error || 'Failed to update stock');
    }

    p.stock = newStock;
    p.status = (newStock === 0) ? 'Out of Stock' : (newStock <= 3 ? 'Low Stock' : 'Available');

    showToast(`Stock for ${p.name} updated to ${newStock} units.`, 'toast-success');
    adjustStockModal.hide();
    renderTable(products);
  } catch (err) {
    console.error('Adjust stock error:', err);
    showToast(err.message || 'Error updating stock.', 'toast-error');
  } finally {
    btn.disabled = false;
    btn.innerHTML = originalHtml;
  }
}

function conditionBadge(cond) {
  if (cond === 'Pre-owned' || cond === 'Refurbished') return '<span class="badge-ct badge-preowned">Pre-owned</span>';
  return '<span class="badge-ct badge-available">Brand New</span>';
}

function statusBadge(st, stock) {
  if (stock === 0) return '<span class="badge-ct badge-outofstock">Out of Stock</span>';
  if (stock <= 3)  return '<span class="badge bg-warning-subtle text-warning-emphasis border border-warning-subtle rounded-pill px-2 py-1"><i class="bi bi-exclamation-triangle-fill me-1"></i>Low Stock</span>';
  return '<span class="badge-ct badge-available">In Stock</span>';
}

function renderPagination() {
  const paginationEl = document.getElementById('pagination');
  if (!paginationEl) return;
  const total = currentFilteredProducts.length;
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

function renderCurrentPage() {
  const tbody = document.getElementById('productsTbody');
  const countEl = document.getElementById('productCount');
  const total = currentFilteredProducts.length;
  const totalPages = Math.ceil(total / PAGE_SIZE) || 1;

  if (currentPage > totalPages) currentPage = totalPages;
  if (currentPage < 1) currentPage = 1;

  const start = (currentPage - 1) * PAGE_SIZE;
  const end = Math.min(start + PAGE_SIZE, total);
  const paged = currentFilteredProducts.slice(start, end);

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
    tbody.innerHTML = '<tr><td colspan="8" class="text-center py-5 text-muted">No products found.</td></tr>';
    renderPagination();
    return;
  }

  tbody.innerHTML = paged.map(p => `
    <tr data-id="${p.id}" data-category="${p.category}" data-condition="${p.condition}">
      <td class="ps-4">
        <img src="${p.img || '/assets/products/placeholder.jpg'}" alt="${p.name}" width="48" height="48" class="rounded border" style="object-fit:cover;" onerror="this.onerror=null;this.src='/assets/products/placeholder.jpg'">
      </td>
      <td>
        <div class="fw-600 text-dark">${p.name}</div>
        <div class="text-xs text-muted">${p.storage && p.storage !== 'N/A' ? p.storage + ' · ' : ''}${p.color || ''}</div>
      </td>
      <td class="d-none d-md-table-cell text-muted">${p.category}</td>
      <td class="d-none d-lg-table-cell">${conditionBadge(p.condition)}</td>
      <td class="text-sm fw-700 text-ct">₱${Number(p.price || 0).toLocaleString()}</td>
      <td class="d-none d-md-table-cell">
        <span class="${p.stock <= 3 ? 'fw-700 text-danger' : 'fw-600'}">${p.stock}</span>
      </td>
      <td class="d-none d-lg-table-cell">${statusBadge(p.status, p.stock)}</td>
      <td class="pe-4 text-end">
        <div class="d-flex gap-1 justify-content-end">
          <button class="btn btn-sm btn-outline-primary" onclick="openAdjustStockModal('${p.id}')" title="Adjust Stock">
            <i class="bi bi-box-seam me-1"></i>Stock
          </button>
          <button class="btn btn-sm btn-ct-outline" onclick="openEditModal('${p.id}')" title="Edit"><i class="bi bi-pencil"></i></button>
          <button class="btn btn-sm btn-outline-danger" onclick="openDeleteModal('${p.id}')" title="Delete"><i class="bi bi-trash"></i></button>
        </div>
      </td>
    </tr>
  `).join('');

  renderPagination();
}

function renderTable(list) {
  currentFilteredProducts = list;
  renderCurrentPage();
}

function applyFilters() {
  const q     = document.getElementById('productSearch').value.toLowerCase().trim();
  const cat   = document.getElementById('filterCategory').value;
  const cond  = document.getElementById('filterCondition').value;
  currentPage = 1;
  const list  = products.filter(p => {
    const matchQ    = !q    || p.name.toLowerCase().includes(q) || p.category.toLowerCase().includes(q);
    const matchCat  = !cat  || p.category === cat;
    const matchCond = !cond || p.condition === cond;
    return matchQ && matchCat && matchCond;
  });
  renderTable(list);
}

function resetFilters() {
  document.getElementById('productSearch').value = '';
  document.getElementById('filterCategory').value = '';
  document.getElementById('filterCondition').value = '';
  currentPage = 1;
  renderTable(products);
}

function changePage(p, e) {
  if (e) e.preventDefault();
  const totalPages = Math.ceil(currentFilteredProducts.length / PAGE_SIZE) || 1;
  if (p < 1 || p > totalPages) return;
  currentPage = p;
  renderCurrentPage();
}

document.getElementById('productSearch').addEventListener('input', applyFilters);
document.getElementById('filterCategory').addEventListener('change', applyFilters);
document.getElementById('filterCondition').addEventListener('change', applyFilters);

// ---- ADD MODAL ----
function openAddModal() {
  document.getElementById('productModalLabel').textContent = 'Add New Product';
  document.getElementById('saveLabel').textContent = 'Save Product';
  document.getElementById('productForm').reset();
  document.getElementById('editProductId').value = '';
  document.getElementById('imagePreviewWrap').innerHTML = '';
  document.getElementById('productForm').classList.remove('was-validated');
}

// ---- EDIT MODAL ----
function openEditModal(id) {
  const p = products.find(x => String(x.id) === String(id));
  if (!p) return;
  document.getElementById('productModalLabel').textContent = 'Edit Product';
  document.getElementById('saveLabel').textContent = 'Update Product';
  document.getElementById('editProductId').value = p.id;
  document.getElementById('pName').value = p.name;
  document.getElementById('pCategory').value = p.category;
  document.getElementById('pCondition').value = p.condition;
  document.getElementById('pStorage').value = p.storage || '';
  document.getElementById('pColor').value = p.color || '';
  document.getElementById('pPrice').value = p.price;
  document.getElementById('pStock').value = p.stock;
  document.getElementById('pDescription').value = p.description || '';
  document.getElementById('imagePreviewWrap').innerHTML = `<img src="${p.img || '/assets/products/placeholder.jpg'}" class="img-preview" alt="current" onerror="this.onerror=null;this.src='/assets/products/placeholder.jpg'">`;
  document.getElementById('productForm').classList.remove('was-validated');
  productModal.show();
}

// ---- SAVE (ADD / EDIT) ----
async function saveProduct() {
  const form = document.getElementById('productForm');
  form.classList.add('was-validated');
  if (!form.checkValidity()) return;

  const id   = document.getElementById('editProductId').value;
  const data = {
    name:        document.getElementById('pName').value.trim(),
    category:    document.getElementById('pCategory').value,
    condition:   document.getElementById('pCondition').value,
    storage:     document.getElementById('pStorage').value || 'N/A',
    color:       document.getElementById('pColor').value.trim() || 'Default',
    price:       parseFloat(document.getElementById('pPrice').value),
    stock:       parseInt(document.getElementById('pStock').value),
    description: document.getElementById('pDescription').value.trim(),
    img:         '/assets/products/placeholder.jpg',
  };
  data.status = data.stock === 0 ? 'Out of Stock' : data.stock <= 3 ? 'Low Stock' : 'Available';

  const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content || '';

  if (id) {
    try {
      const res = await fetch('../api/admin/products.php', {
        method: 'PUT',
        headers: {
          'Content-Type': 'application/json',
          'Accept': 'application/json',
          'X-CSRF-Token': csrfToken
        },
        body: JSON.stringify({ id: id, ...data })
      });
      const result = await res.json();
      if (!res.ok || !result.success) {
        throw new Error(result.error || 'Failed to update product');
      }
      const idx = products.findIndex(x => String(x.id) === String(id));
      if (idx > -1) { products[idx] = { ...products[idx], ...data }; }
      showToast('Product updated successfully!', 'toast-success');
    } catch (err) {
      showToast(err.message || 'Failed to update product on server.', 'toast-danger');
      return;
    }
  } else {
    try {
      const res = await fetch('../api/admin/products.php', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'Accept': 'application/json',
          'X-CSRF-Token': csrfToken
        },
        body: JSON.stringify(data)
      });
      const result = await res.json();
      if (!res.ok || !result.success || !result.product_id) {
        throw new Error(result.error || 'Failed to create product');
      }
      data.id = result.product_id;
      products.unshift(data);
      showToast('Product added successfully!', 'toast-success');
    } catch (err) {
      showToast(err.message || 'Failed to create product on server.', 'toast-danger');
      return;
    }
  }

  productModal.hide();
  renderTable(products);
}

// ---- DELETE ----
function openDeleteModal(id) {
  const p = products.find(x => String(x.id) === String(id));
  if (!p) return;
  deleteTargetId = p.id;
  document.getElementById('deleteProductName').textContent = p.name;
  deleteModal.show();
}

document.getElementById('confirmDeleteBtn').addEventListener('click', async () => {
  if (deleteTargetId !== null) {
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content || '';
    try {
      const res = await fetch('../api/admin/products.php', {
        method: 'DELETE',
        headers: {
          'Content-Type': 'application/json',
          'Accept': 'application/json',
          'X-CSRF-Token': csrfToken
        },
        body: JSON.stringify({ id: deleteTargetId })
      });
      const result = await res.json();
      if (!res.ok || !result.success) {
        throw new Error(result.error || 'Failed to delete product');
      }
    } catch (err) {
      console.warn('API delete failed, removing from local memory:', err);
    }

    products = products.filter(x => String(x.id) !== String(deleteTargetId));
  }

  deleteModal.hide();
  renderTable(products);
  showToast('Product deleted.', 'toast-error');
});

// ---- IMAGE PREVIEW ----
document.getElementById('pImages').addEventListener('change', function () {
  const wrap = document.getElementById('imagePreviewWrap');
  wrap.innerHTML = '';
  Array.from(this.files).slice(0, 5).forEach(file => {
    const reader = new FileReader();
    reader.onload = e => {
      const img = document.createElement('img');
      img.src = e.target.result;
      img.style = 'width:60px;height:60px;border-radius:8px;object-fit:cover;border:2px solid var(--ct-primary)';
      wrap.appendChild(img);
    };
    reader.readAsDataURL(file);
  });
});


// ---- TOAST ----
function showToast(msg, cls='') {
  const t = document.getElementById('toastMsg');
  t.textContent = msg;
  t.className = 'toast-ct show ' + cls;
  setTimeout(() => t.className = 'toast-ct', 3200);
}

// ---- LOAD PRODUCTS FROM API ----
async function loadProducts() {
  try {
    const res = await fetch('../api/admin/products.php', {
      headers: { 'Accept': 'application/json' },
      cache: 'no-store'
    });
    if (res.ok) {
      const data = await res.json();
      if (data && data.success && Array.isArray(data.products) && data.products.length > 0) {
        products = data.products;
      }
    }
  } catch (err) {
    console.warn('Failed to fetch admin products from API:', err);
  }

  renderTable(products);
}

// Init
if (document.readyState === 'loading') {
  document.addEventListener('DOMContentLoaded', loadProducts);
} else {
  loadProducts();
}
