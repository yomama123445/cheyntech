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

/* ─── Ambient Cursor Spotlight ─────────────────────────────────────────── */
function initSpotlight() {
  const cards = document.querySelectorAll('.spotlight-card, .product-card');
  cards.forEach(card => {
    card.addEventListener('mousemove', e => {
      const rect = card.getBoundingClientRect();
      const x = e.clientX - rect.left;
      const y = e.clientY - rect.top;
      card.style.setProperty('--mouse-x', `${x}px`);
      card.style.setProperty('--mouse-y', `${y}px`);
    });
    card.addEventListener('mouseleave', () => {
      card.style.setProperty('--mouse-x', '-500px');
      card.style.setProperty('--mouse-y', '-500px');
    });
  });
}

/* ─── Interactive Hardware Tier Switcher ────────────────────────────────── */
const tierData = {
  pristine: {
    badge: 'Grade A · Pristine',
    image: 'assets/img/iphone_13pro.jpeg',
    batteryChip: '<i class="bi bi-battery-charging text-primary"></i> ≥85% Battery Health',
    cosmeticChip: '<i class="bi bi-stars text-warning"></i> Near-Flawless Body',
    kicker: 'FLAGSHIP VALUE',
    heading: 'Pristine Grade A',
    summary: 'Indistinguishable from new at arm\'s length. Carefully selected pre-owned devices with zero screen imperfections and verified original internal components.',
    cosmetic: 'Micro-wear only visible under harsh direct light. Screen is 100% scratch-free.',
    battery: '≥85% to 100% genuine health. Never degraded or third-party locked.',
    box: 'CheynTech safety case packaging + fast-charging cable + 20W power adapter.',
    warranty: '7-day 1-to-1 in-store replacement + 30-day hardware service warranty.',
    priceRange: '₱14,500 – ₱34,500',
    ctaText: 'Browse Grade A Inventory',
    ctaLink: 'catalog.php?cat=preowned'
  },
  sealed: {
    badge: 'Factory Sealed · 100% New',
    image: 'assets/img/iphone15_promax.jpeg',
    batteryChip: '<i class="bi bi-battery-full text-success"></i> 100% Battery (0 Cycles)',
    cosmeticChip: '<i class="bi bi-box-seam-fill text-primary"></i> Factory Mint Box',
    kicker: 'UNTOUCHED ORIGINAL',
    heading: 'Brand New Sealed',
    summary: 'Direct from authorized supply channels. Factory box with untouched pull-tabs, brand-new accessories, and official manufacturer warranty.',
    cosmetic: '100% factory original condition with intact factory screen film and seal.',
    battery: '100% battery capacity with 0 charge cycles out of the box.',
    box: 'Complete official retail box with all manufacturer documentation and original accessories.',
    warranty: '1-Year official manufacturer warranty + CheynTech local store support.',
    priceRange: '₱35,000 – ₱75,000',
    ctaText: 'Browse Brand New Sealed',
    ctaLink: 'catalog.php?cat=new'
  },
  daily: {
    badge: 'Grade B · Daily Driver',
    image: 'assets/img/iPhone_12.jpeg',
    batteryChip: '<i class="bi bi-battery-half text-warning"></i> ≥80% Battery Health',
    cosmeticChip: '<i class="bi bi-tag-fill text-success"></i> Maximum Savings',
    kicker: 'PRACTICAL CHOICE',
    heading: 'Daily Driver (Grade B)',
    summary: 'The smartest way to get high-end specs on a budget. 100% fully functional internals with visible pocket or casing wear that a case easily covers.',
    cosmetic: 'Minor signs of everyday handling on outer chassis or bezels. Screen is clear and intact.',
    battery: '≥80% reliable battery retention. Stress-tested for all-day daily usability.',
    box: 'CheynTech protective packaging + certified charging cable.',
    warranty: '7-day replacement guarantee + 30-day store hardware warranty.',
    priceRange: '₱8,500 – ₱22,000',
    ctaText: 'Browse Daily Driver Deals',
    ctaLink: 'catalog.php?cat=preowned'
  }
};

function initTierSwitcher() {
  const buttons = document.querySelectorAll('.tier-pill-btn');
  if (!buttons.length) return;

  const badgeEl       = document.getElementById('tierBadge');
  const imgEl         = document.getElementById('tierImg');
  const batteryChipEl = document.getElementById('tierBatteryChip');
  const cosmeticChipEl= document.getElementById('tierCosmeticChip');
  const kickerEl      = document.getElementById('tierKicker');
  const headingEl     = document.getElementById('tierHeading');
  const summaryEl     = document.getElementById('tierSummary');
  const cosmeticValEl = document.getElementById('tierCosmeticVal');
  const batteryValEl  = document.getElementById('tierBatteryVal');
  const boxValEl      = document.getElementById('tierBoxVal');
  const warrantyValEl = document.getElementById('tierWarrantyVal');
  const priceRangeEl  = document.getElementById('tierPriceRange');
  const ctaBtnEl      = document.getElementById('tierCtaBtn');

  buttons.forEach(btn => {
    btn.addEventListener('click', () => {
      const tierKey = btn.getAttribute('data-tier');
      const data = tierData[tierKey];
      if (!data) return;

      // Update active state
      buttons.forEach(b => {
        b.classList.remove('active');
        b.setAttribute('aria-selected', 'false');
      });
      btn.classList.add('active');
      btn.setAttribute('aria-selected', 'true');

      // Animate image transition
      if (imgEl) {
        imgEl.style.opacity = '0';
        imgEl.style.transform = 'scale(0.96)';
        setTimeout(() => {
          imgEl.src = data.image;
          imgEl.alt = data.heading;
          imgEl.style.opacity = '1';
          imgEl.style.transform = 'scale(1)';
        }, 160);
      }

      // Update text & chips
      if (badgeEl) badgeEl.textContent = data.badge;
      if (batteryChipEl) batteryChipEl.innerHTML = data.batteryChip;
      if (cosmeticChipEl) cosmeticChipEl.innerHTML = data.cosmeticChip;
      if (kickerEl) kickerEl.textContent = data.kicker;
      if (headingEl) headingEl.textContent = data.heading;
      if (summaryEl) summaryEl.textContent = data.summary;
      if (cosmeticValEl) cosmeticValEl.textContent = data.cosmetic;
      if (batteryValEl) batteryValEl.textContent = data.battery;
      if (boxValEl) boxValEl.textContent = data.box;
      if (warrantyValEl) warrantyValEl.textContent = data.warranty;
      if (priceRangeEl) priceRangeEl.textContent = data.priceRange;
      if (ctaBtnEl) {
        ctaBtnEl.innerHTML = `${data.ctaText} <i class="bi bi-arrow-right ms-1"></i>`;
        ctaBtnEl.href = data.ctaLink;
      }
    });
  });
}

document.addEventListener('DOMContentLoaded', () => {
  initHero();
  initSpotlight();
  initTierSwitcher();
});

function quickAddToCart(product, btn) {
  CheynCart.add(product, btn);
}
