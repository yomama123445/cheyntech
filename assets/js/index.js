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
  name:    'iPhone 13 Pro',
  variant: '128GB · Graphite',
  image:   '/assets/img/hero-product.jpg',
};

function initHero() {
  const img     = document.getElementById('heroProductImg');
  const caption = document.getElementById('heroProductCaption');

  if (img) {
    const alt = 'Featured product — ' + heroProduct.name;
    if (heroProduct.image) {
      img.src = heroProduct.image;
      img.alt = alt;
    } else {
      img.outerHTML = `<div style="width:100%;height:100%;display:flex;align-items:center;justify-content:center;background:var(--ct-primary-light);border-radius:var(--ct-radius-lg)" aria-label="${alt}"><i class="bi bi-phone" style="font-size:5rem;color:var(--ct-primary)"></i></div>`;
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
