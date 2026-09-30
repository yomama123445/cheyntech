// ====== PRODUCT DATA ======
let products = [
  { id:1, name:'iPhone 15 Pro Max', category:'iPhone', condition:'Brand New', storage:'256GB', color:'Titanium Black', price:79999, stock:8, status:'Available', img:'/assets/products/placeholder.jpg' },
  { id:2, name:'iPhone 14 Pro', category:'iPhone', condition:'Pre-owned', storage:'128GB', color:'Deep Purple', price:48000, stock:5, status:'Available', img:'/assets/products/placeholder.jpg' },
  { id:3, name:'iPhone 13 mini', category:'iPhone', condition:'Pre-owned', storage:'64GB', color:'Midnight', price:23500, stock:2, status:'Low Stock', img:'/assets/products/placeholder.jpg' },
  { id:4, name:'Samsung Galaxy S24 Ultra', category:'Android', condition:'Brand New', storage:'512GB', color:'Titanium Gray', price:72500, stock:6, status:'Available', img:'/assets/products/placeholder.jpg' },
  { id:5, name:'Xiaomi 14T Pro', category:'Android', condition:'Brand New', storage:'256GB', color:'Titan Black', price:29999, stock:10, status:'Available', img:'/assets/products/placeholder.jpg' },
  { id:6, name:'Samsung Galaxy Tab S9', category:'Tablet', condition:'Refurbished', storage:'128GB', color:'Graphite', price:36000, stock:1, status:'Low Stock', img:'/assets/products/placeholder.jpg' },
  { id:7, name:'iPad Air (M2)', category:'Tablet', condition:'Brand New', storage:'256GB', color:'Starlight', price:41999, stock:7, status:'Available', img:'/assets/products/placeholder.jpg' },
  { id:8, name:'AirPods Pro (2nd Gen)', category:'Accessories', condition:'Brand New', storage:'N/A', color:'White', price:14999, stock:3, status:'Low Stock', img:'/assets/products/placeholder.jpg' },
  { id:9, name:'Apple Watch Series 9', category:'Wearables', condition:'Brand New', storage:'N/A', color:'Midnight Alum.', price:22999, stock:2, status:'Low Stock', img:'/assets/products/placeholder.jpg' },
  { id:10, name:'Oppo Find X7 Ultra', category:'Android', condition:'Pre-owned', storage:'512GB', color:'Black', price:54000, stock:1, status:'Low Stock', img:'/assets/products/placeholder.jpg' },
];

let deleteTargetId = null;
const productModal = new bootstrap.Modal(document.getElementById('productModal'));
const deleteModal  = new bootstrap.Modal(document.getElementById('deleteModal'));

function conditionBadge(cond) {
  if (cond === 'Pre-owned')  return '<span class="badge-ct badge-preowned">Pre-owned</span>';
  if (cond === 'Refurbished') return '<span class="badge-ct badge-refurbished">Refurbished</span>';
  return '<span class="badge-ct badge-available">Brand New</span>';
}

function statusBadge(st, stock) {
  if (stock === 0) return '<span class="badge-ct badge-outofstock">Out of Stock</span>';
  if (stock <= 3)  return '<span class="badge rounded-pill td-sm-badge">Low Stock</span>';
  return '<span class="badge-ct badge-available">Available</span>';
}

function renderTable(list) {
  const tbody = document.getElementById('productsTbody');
  document.getElementById('productCount').textContent = list.length;
  if (!list.length) {
    tbody.innerHTML = '<tr><td colspan="8" class="text-center py-5 text-muted">No products found.</td></tr>';
    return;
  }
  tbody.innerHTML = list.map(p => `
    <tr data-id="${p.id}" data-category="${p.category}" data-condition="${p.condition}">
      <td class="ps-4">
        <img src="${p.img || '/assets/products/placeholder.jpg'}" alt="${p.name}" width="48" height="48" onerror="this.onerror=null;this.src='/assets/products/placeholder.jpg'">
      </td>
      <td>
        <div>${p.name}</div>
        <div class="text-xs text-muted">${p.storage && p.storage !== 'N/A' ? p.storage + ' · ' : ''}${p.color || ''}</div>
      </td>
      <td class="d-none d-md-table-cell">${p.category}</td>
      <td class="d-none d-lg-table-cell">${conditionBadge(p.condition)}</td>
      <td class="text-sm fw-700 text-ct">₱${Number(p.price || 0).toLocaleString()}</td>
      <td class="d-none d-md-table-cell">
        <span>${p.stock}</span>
      </td>
      <td class="d-none d-lg-table-cell">${statusBadge(p.status, p.stock)}</td>
      <td class="pe-4">
        <div class="d-flex gap-1">
          <button class="btn btn-sm btn-ct-outline" onclick="openEditModal('${p.id}')" title="Edit"><i class="bi bi-pencil"></i></button>
          <button class="btn btn-sm btn-outline-danger" onclick="openDeleteModal('${p.id}')" title="Delete"><i class="bi bi-trash"></i></button>
        </div>
      </td>
    </tr>
  `).join('');
}

function applyFilters() {
  const q     = document.getElementById('productSearch').value.toLowerCase().trim();
  const cat   = document.getElementById('filterCategory').value;
  const cond  = document.getElementById('filterCondition').value;
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
  renderTable(products);
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

  if (id) {
    try {
      const res = await fetch('../api/admin/products.php', {
        method: 'PUT',
        headers: { 'Content-Type': 'application/json', 'Accept': 'application/json' },
        body: JSON.stringify({ id: id, ...data })
      });
      const result = await res.json();
      if (!res.ok || !result.success) {
        throw new Error(result.error || 'Failed to update product');
      }
    } catch (err) {
      console.warn('API update failed, updating in local memory:', err);
    }

    const idx = products.findIndex(x => String(x.id) === String(id));
    if (idx > -1) { products[idx] = { ...products[idx], ...data }; }
    showToast('Product updated successfully!', 'toast-success');
  } else {
    try {
      const res = await fetch('../api/admin/products.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'Accept': 'application/json' },
        body: JSON.stringify(data)
      });
      const result = await res.json();
      if (res.ok && result.success && result.product_id) {
        data.id = result.product_id;
      } else {
        data.id = 'prod-' + Date.now();
      }
    } catch (err) {
      console.warn('API create failed, adding to local memory:', err);
      data.id = 'prod-' + Date.now();
    }

    products.unshift(data);
    showToast('Product added successfully!', 'toast-success');
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
    try {
      const res = await fetch('../api/admin/products.php', {
        method: 'DELETE',
        headers: { 'Content-Type': 'application/json', 'Accept': 'application/json' },
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

// ---- PAGINATION STUB ----
function changePage(p, e) {
  e.preventDefault();
  document.querySelectorAll('#pagination .page-item').forEach(li => li.classList.remove('active'));
  e.currentTarget.parentElement.classList.add('active');
}

// ---- SIDEBAR TOGGLE ----
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
