(function () {
  'use strict';

  var params = new URLSearchParams(window.location.search);
  var productParam = params.get('product');
  var productInput = document.getElementById('productName');
  if (productInput) {
    productInput.value = productParam ? decodeURIComponent(productParam) : '';
  }

  var form = document.getElementById('inquiryForm');
  var successAlert = document.getElementById('inquirySuccess');

  if (successAlert) {
    successAlert.style.display = 'none';
  }

  if (form) {
    form.addEventListener('submit', async function (e) {
      e.preventDefault();
      if (!form.checkValidity()) {
        form.classList.add('was-validated');
        return;
      }

      var payload = {
        product_name: productInput ? productInput.value.trim() : '',
        name: (document.getElementById('contactName')?.value || '').trim(),
        email: (document.getElementById('contactEmail')?.value || '').trim(),
        phone: (document.getElementById('contactPhone')?.value || '').trim(),
        message: (document.getElementById('contactMessage')?.value || '').trim(),
        website: (document.getElementById('contactWebsite')?.value || '').trim()
      };

      var csrfMeta = document.querySelector('meta[name="csrf-token"]');
      var csrfToken = csrfMeta ? csrfMeta.getAttribute('content') : '';

      var submitBtn = form.querySelector('button[type="submit"]');
      var origBtnText = submitBtn ? submitBtn.innerHTML : '';
      if (submitBtn) {
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>Sending…';
      }

      try {
        var res = await fetch('api/contact.php', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-CSRF-Token': csrfToken
          },
          body: JSON.stringify(payload)
        });

        var data = await res.json();

        // Show the success banner only when the response returns { success: true }
        if (data && data.success) {
          if (successAlert) {
            successAlert.style.display = 'flex';
            successAlert.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
          }
          form.reset();
          form.classList.remove('was-validated');
          if (productInput) {
            productInput.value = '';
          }
        } else {
          var errorMsg = (data && data.error) ? data.error : 'Unable to submit your inquiry. Please try again.';
          if (typeof showToast === 'function') {
            showToast(errorMsg, 'error');
          } else {
            console.error(errorMsg);
          }
        }
      } catch (err) {
        console.error('Contact form submission error:', err);
        if (typeof showToast === 'function') {
          showToast('An error occurred while sending your inquiry. Please try again later.', 'error');
        }
      } finally {
        if (submitBtn) {
          submitBtn.disabled = false;
          submitBtn.innerHTML = origBtnText;
        }
      }
    });
  }
})();
