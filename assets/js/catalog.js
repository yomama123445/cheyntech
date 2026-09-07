'use strict';
    document.getElementById('applyFiltersBtn')?.addEventListener('click', () => {
      const q        = document.getElementById('catalogSearchInput')?.value.trim() || '';
      const cats     = [...document.querySelectorAll('input[name="cat"]:checked')].map(i => i.value);
      const variants = [...document.querySelectorAll('input[name="variant"]:checked')].map(i => i.value);
      const colors   = [...document.querySelectorAll('input[name="color"]:checked')].map(i => i.value);
      const conds    = [...document.querySelectorAll('input[name="condition"]:checked')].map(i => i.value);
      const priceMin = document.getElementById('priceMin')?.value || '';
      const priceMax = document.getElementById('priceMax')?.value || '';
      const params   = new URLSearchParams();
      if (q)               params.set('q', q);
      if (cats.length)     params.set('cat', cats.join(','));
      if (variants.length) params.set('variant', variants.join(','));
      if (colors.length)   params.set('color', colors.join(','));
      if (conds.length)    params.set('condition', conds.join(','));
      if (priceMin)        params.set('priceMin', priceMin);
      if (priceMax)        params.set('priceMax', priceMax);
      window.history.replaceState({}, '', window.location.pathname + (params.toString() ? '?' + params.toString() : ''));
      showToast('Filters applied', 'info');
    });
    (function () {
      const params   = new URLSearchParams(window.location.search);
      const catParam = params.get('cat');
      if (catParam) catParam.split(',').forEach(v => {
        const el = document.querySelector('input[name="cat"][value="' + v + '"]');
        if (el) el.checked = true;
      });
    })();
    document.querySelectorAll('.filter-tag button').forEach(btn => {
      btn.addEventListener('click', () => btn.closest('.filter-tag').remove());
    });
    document.getElementById('sortSelect')?.addEventListener('change', (e) => {
      showToast('Sorted by: ' + e.target.options[e.target.selectedIndex].text, 'info');
    });
