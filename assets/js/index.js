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
    img.src = heroProduct.image;
    img.alt = 'Featured product — ' + heroProduct.name;
  }

  if (caption) {
    caption.textContent = heroProduct.variant
      ? heroProduct.name + ' · ' + heroProduct.variant
      : heroProduct.name;
  }
}

document.addEventListener('DOMContentLoaded', initHero);

function quickAddToCart(product) {
  CheynCart.add(product);
}
