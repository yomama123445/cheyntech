'use strict';
// index.js — Home page specific JS

/* ─── Hero product config ───────────────────────────────────────────────────
   To swap the featured product, edit ONLY this object.
   Fields:
     name    – full product name shown in the caption and img alt
     variant – short spec string appended to the caption (set "" to hide)
     image   – path to the product photo (relative to site root)
   ──────────────────────────────────────────────────────────────────────── */
const heroProduct = {
  name:    'iPhone 13',
  variant: '128GB · Midnight',
  image:   'assets/img/iphone_13pro.jpeg',
};

function initHero() {
  const img     = document.getElementById('heroProductImg');
  const caption = document.getElementById('heroProductCaption');

  if (img) {
    img.alt = 'Featured product — ' + heroProduct.name;
    if (heroProduct.image) {
      let src = heroProduct.image;
      if (src.startsWith('/')) src = src.substring(1);
      img.src = src;
      img.onerror = function () {
        this.onerror = null;
        this.src = 'assets/products/placeholder.jpg';
      };
    } else {
      img.outerHTML = '<div style="width:100%;height:100%;display:flex;align-items:center;justify-content:center;background:var(--ct-primary-light);border-radius:var(--ct-radius-lg)"><i class="bi bi-phone" style="font-size:5rem;color:var(--ct-primary)"></i></div>';
    }
  }

  if (caption) {
    caption.textContent = heroProduct.variant
      ? heroProduct.name + ' · ' + heroProduct.variant
      : heroProduct.name;
  }
}

document.addEventListener('DOMContentLoaded', initHero);

function quickAddToCart(product, btn) {
  CheynCart.add(product, btn);
}
