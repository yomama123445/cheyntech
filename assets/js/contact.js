(function () {
      'use strict';
      var params = new URLSearchParams(window.location.search);
      var productParam = params.get('product');
      var productInput = document.getElementById('productName');
      productInput.value = productParam ? decodeURIComponent(productParam) : 'iPhone 13 Pro-128GB Graphite';

      var form = document.getElementById('inquiryForm');
      var successAlert = document.getElementById('inquirySuccess');

      form.addEventListener('submit', function (e) {
        e.preventDefault();
        if (!form.checkValidity()) { form.classList.add('was-validated'); return; }
        successAlert.style.removeProperty('display');
        successAlert.style.display = 'flex';
        successAlert.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
        form.reset();
        form.classList.remove('was-validated');
        productInput.value = 'iPhone 13 Pro-128GB Graphite';
      });
    })();
