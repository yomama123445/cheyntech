// Today date
  const d = new Date();
  document.getElementById('todayDate').textContent = d.toLocaleDateString('en-PH',{weekday:'short',month:'short',day:'numeric',year:'numeric'});

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

  function exportOrdersCSV() {
    showToast('Orders CSV download started!', 'toast-success');
  }

  function showToast(msg, cls='') {
    const t = document.getElementById('toastMsg');
    t.textContent = msg;
    t.className = 'toast-ct show ' + cls;
    setTimeout(() => t.className = 'toast-ct', 3200);
  }
