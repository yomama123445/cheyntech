(function () {
  'use strict';

  function getCsrfToken() {
    var meta = document.querySelector('meta[name="csrf-token"]');
    return meta ? meta.getAttribute('content') : '';
  }

  function formatPrice(num) {
    return '₱' + Number(num).toLocaleString('en-PH', {
      minimumFractionDigits: 2,
      maximumFractionDigits: 2
    });
  }

  function getStatusBadge(status, rawStatus) {
    var s = (rawStatus || '').toLowerCase();
    var badgeClass = 'bg-secondary';
    if (s === 'completed') badgeClass = 'bg-success';
    else if (s === 'processing') badgeClass = 'bg-primary';
    else if (s === 'ready_pickup' || s === 'out_for_delivery') badgeClass = 'bg-info text-dark';
    else if (s === 'pending') badgeClass = 'bg-warning text-dark';
    else if (s === 'cancelled') badgeClass = 'bg-danger';

    return '<span class="badge ' + badgeClass + '">' + (status || 'Pending') + '</span>';
  }

  var currentUserEmail = '';

  function loadProfile() {
    var loadingEl = document.getElementById('ordersLoading');
    var emptyEl   = document.getElementById('noOrdersMessage');
    var tableEl   = document.getElementById('ordersContainer');
    var tbody     = document.getElementById('ordersTableBody');

    fetch('api/auth/profile.php')
      .then(function (res) {
        if (res.status === 401) {
          window.location.href = 'login.php';
          return null;
        }
        return res.json();
      })
      .then(function (data) {
        if (!data || !data.success) {
          if (typeof showToast === 'function') {
            showToast('Failed to load profile details.', 'error');
          }
          return;
        }

        var u = data.user;
        currentUserEmail = u.email;

        var nameInput  = document.getElementById('profileName');
        var emailInput = document.getElementById('profileEmail');
        var phoneInput = document.getElementById('profilePhone');
        var dispName   = document.getElementById('profileDisplayName');
        var dispEmail  = document.getElementById('profileDisplayEmail');

        if (nameInput)  nameInput.value  = u.name || '';
        if (emailInput) emailInput.value = u.email || '';
        if (phoneInput) phoneInput.value = u.phone || '';
        if (dispName)   dispName.textContent = u.name || 'User';
        if (dispEmail)  dispEmail.textContent = u.email || '';

        // Render orders
        if (loadingEl) loadingEl.classList.add('d-none');

        var orders = data.orders || [];
        if (orders.length === 0) {
          if (emptyEl) emptyEl.classList.remove('d-none');
          if (tableEl) tableEl.classList.add('d-none');
        } else {
          if (emptyEl) emptyEl.classList.add('d-none');
          if (tableEl) tableEl.classList.remove('d-none');

          if (tbody) {
            tbody.innerHTML = '';
            orders.forEach(function (ord) {
              var itemsDesc = [];
              if (ord.items && ord.items.length) {
                ord.items.forEach(function (it) {
                  var line = it.product_name;
                  if (it.variant_info) line += ' (' + it.variant_info + ')';
                  line += ' ×' + it.qty;
                  itemsDesc.push(line);
                });
              } else {
                itemsDesc.push('Gadget Order');
              }

              var tr = document.createElement('tr');
              var trackUrl = 'track-order.php?id=' + encodeURIComponent(ord.order_number) + '&email=' + encodeURIComponent(currentUserEmail);

              tr.innerHTML =
                '<td><strong class="text-dark">' + ord.order_number + '</strong><br><span class="text-muted" style="font-size: 0.8rem;">' + ord.fulfillment + '</span></td>' +
                '<td>' + ord.date + '</td>' +
                '<td>' + itemsDesc.join(', ') + '</td>' +
                '<td><strong>' + formatPrice(ord.total) + '</strong></td>' +
                '<td>' + getStatusBadge(ord.status, ord.raw_status) + '</td>' +
                '<td><a href="' + trackUrl + '" class="btn btn-sm btn-outline-secondary py-1 px-2"><i class="bi bi-box-seam me-1"></i>Track</a></td>';

              tbody.appendChild(tr);
            });
          }
        }
      })
      .catch(function (err) {
        console.error('Error loading profile:', err);
        if (loadingEl) loadingEl.classList.add('d-none');
      });
  }

  function initProfileForm() {
    var form = document.getElementById('profileForm');
    var successAlert = document.getElementById('profileSuccessAlert');
    var errorAlert   = document.getElementById('profileErrorAlert');

    if (!form) return;

    form.addEventListener('submit', function (e) {
      e.preventDefault();
      if (successAlert) successAlert.classList.add('d-none');
      if (errorAlert)   errorAlert.classList.add('d-none');

      var name  = (document.getElementById('profileName')?.value || '').trim();
      var phone = (document.getElementById('profilePhone')?.value || '').trim();

      if (!name) {
        if (errorAlert) {
          errorAlert.textContent = 'Please enter your name.';
          errorAlert.classList.remove('d-none');
        }
        return;
      }

      var submitBtn = form.querySelector('button[type="submit"]');
      var origText = submitBtn ? submitBtn.innerHTML : '';
      if (submitBtn) {
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span>Saving…';
      }

      fetch('api/auth/profile.php', {
        method: 'PUT',
        headers: {
          'Content-Type': 'application/json',
          'Accept': 'application/json',
          'X-CSRF-Token': getCsrfToken()
        },
        body: JSON.stringify({ name: name, phone: phone })
      })
      .then(function (res) { return res.json(); })
      .then(function (data) {
        if (data && data.success) {
          if (successAlert) {
            successAlert.textContent = data.message || 'Profile updated successfully!';
            successAlert.classList.remove('d-none');
          }
          var dispName = document.getElementById('profileDisplayName');
          if (dispName) dispName.textContent = name;
          if (typeof showToast === 'function') {
            showToast('Profile updated successfully!', 'success');
          }
        } else {
          var err = (data && data.error) ? data.error : 'Failed to update profile.';
          if (errorAlert) {
            errorAlert.textContent = err;
            errorAlert.classList.remove('d-none');
          }
          if (typeof showToast === 'function') {
            showToast(err, 'error');
          }
        }
      })
      .catch(function () {
        if (errorAlert) {
          errorAlert.textContent = 'An error occurred while saving your profile.';
          errorAlert.classList.remove('d-none');
        }
      })
      .finally(function () {
        if (submitBtn) {
          submitBtn.disabled = false;
          submitBtn.innerHTML = origText;
        }
      });
    });
  }

  function initPasswordForm() {
    var form = document.getElementById('passwordForm');
    var successAlert = document.getElementById('passwordSuccessAlert');
    var errorAlert   = document.getElementById('passwordErrorAlert');

    if (!form) return;

    form.addEventListener('submit', function (e) {
      e.preventDefault();
      if (successAlert) successAlert.classList.add('d-none');
      if (errorAlert)   errorAlert.classList.add('d-none');

      var currentPass = document.getElementById('currentPassword')?.value || '';
      var newPass     = document.getElementById('newPassword')?.value || '';
      var confirmPass = document.getElementById('confirmPassword')?.value || '';
      var name        = (document.getElementById('profileName')?.value || '').trim();
      var phone       = (document.getElementById('profilePhone')?.value || '').trim();

      if (!currentPass) {
        if (errorAlert) {
          errorAlert.textContent = 'Please enter your current password.';
          errorAlert.classList.remove('d-none');
        }
        return;
      }

      if (newPass.length < 8) {
        if (errorAlert) {
          errorAlert.textContent = 'New password must be at least 8 characters long.';
          errorAlert.classList.remove('d-none');
        }
        return;
      }

      if (newPass !== confirmPass) {
        if (errorAlert) {
          errorAlert.textContent = 'New password and confirmation do not match.';
          errorAlert.classList.remove('d-none');
        }
        return;
      }

      var submitBtn = form.querySelector('button[type="submit"]');
      var origText = submitBtn ? submitBtn.innerHTML : '';
      if (submitBtn) {
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span>Updating…';
      }

      fetch('api/auth/profile.php', {
        method: 'PUT',
        headers: {
          'Content-Type': 'application/json',
          'Accept': 'application/json',
          'X-CSRF-Token': getCsrfToken()
        },
        body: JSON.stringify({
          name: name,
          phone: phone,
          current_password: currentPass,
          new_password: newPass
        })
      })
      .then(function (res) { return res.json(); })
      .then(function (data) {
        if (data && data.success) {
          if (successAlert) {
            successAlert.textContent = 'Password updated successfully!';
            successAlert.classList.remove('d-none');
          }
          form.reset();
          if (typeof showToast === 'function') {
            showToast('Password changed successfully!', 'success');
          }
        } else {
          var err = (data && data.error) ? data.error : 'Failed to update password.';
          if (errorAlert) {
            errorAlert.textContent = err;
            errorAlert.classList.remove('d-none');
          }
          if (typeof showToast === 'function') {
            showToast(err, 'error');
          }
        }
      })
      .catch(function () {
        if (errorAlert) {
          errorAlert.textContent = 'An error occurred while updating your password.';
          errorAlert.classList.remove('d-none');
        }
      })
      .finally(function () {
        if (submitBtn) {
          submitBtn.disabled = false;
          submitBtn.innerHTML = origText;
        }
      });
    });
  }

  document.addEventListener('DOMContentLoaded', function () {
    loadProfile();
    initProfileForm();
    initPasswordForm();
  });

})();
