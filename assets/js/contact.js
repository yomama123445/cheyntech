(function () {
  'use strict';

  var params = new URLSearchParams(window.location.search);
  var productParam = params.get('product');
  var productInput = document.getElementById('productName');
  if (productInput) {
    productInput.value = productParam ? decodeURIComponent(productParam) : 'iPhone 13 Pro-128GB Graphite';
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
        message: (document.getElementById('contactMessage')?.value || '').trim()
      };

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
            'Accept': 'application/json'
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
          if (typeof alert === 'function') {
            alert(errorMsg);
          } else {
            console.error(errorMsg);
          }
        }
      } catch (err) {
        console.error('Contact form submission error:', err);
        if (typeof alert === 'function') {
          alert('An error occurred while sending your inquiry. Please try again later.');
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
