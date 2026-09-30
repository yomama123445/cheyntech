# CheynTech — Isolated Fix Prompts

---

## 🔴 High Priority

---

### I-1 · Broken Category Card Images
**File:** `index.php` · Lines 94–127

> In `index.php`, find the four `<div class="cat-img-wrap">` elements inside the "Shop by Category" section. Each contains a broken `<img>` tag. Delete the `<img>` tag inside each one and replace it with the following icons, matching the category:
>
> - Pre-owned iPhones → `<i class="bi bi-phone cat-icon"></i>`
> - New iPhones → `<i class="bi bi-phone-fill cat-icon"></i>`
> - Android → `<i class="bi bi-grid cat-icon"></i>`
> - Tablets → `<i class="bi bi-tablet cat-icon"></i>`
>
> Touch nothing outside those four `<div class="cat-img-wrap">` elements. Do not modify any CSS or JS files.

---

### I-2 · Hero Image Missing + Empty Alt
**File:** `assets/js/index.js` · Lines 17–31

> In `index.js`, rewrite the `initHero()` function body as follows. Get `img` and `caption` as before. Then:
> 1. Always set `img.alt = 'Featured product — ' + heroProduct.name` first.
> 2. If `heroProduct.image` is a non-empty string, set `img.src = heroProduct.image` as normal.
> 3. If `heroProduct.image` is empty or missing, replace the `<img>` element entirely with:
> ```js
> img.outerHTML = '<div style="width:100%;height:100%;display:flex;align-items:center;justify-content:center;background:var(--ct-primary-light);border-radius:var(--ct-radius-lg)"><i class="bi bi-phone" style="font-size:5rem;color:var(--ct-primary)"></i></div>';
> ```
> 4. The `caption` logic stays unchanged. Do not touch any other function or file.

---

### I-4 · All Featured Product Card Images Are Broken
**File:** `index.php` · Lines 149–296

> In `index.php`, add an `onerror` attribute to every `<img>` tag inside a `<div class="card-img-wrap">` in the Featured Products section. The attribute value must be:
> ```
> onerror="this.onerror=null;this.src='https://placehold.co/400x400/fce4ec/e91e8c?text='+encodeURIComponent(this.alt)"
> ```
> Apply this to all 8 product card images. Do not change `src`, `alt`, `loading`, or any other attribute. Do not modify any other file.

---

### CH-1 · Placeholder Payment Details
**File:** `checkout.php` · Lines 141–168

> In `checkout.php`, locate the `<div id="gcashInfo" class="payment-info-box">` block (around line 141) and the `<div id="bankInfo" class="payment-info-box">` block (around line 158). Delete all inner HTML from both divs and replace each with:
>
> `#gcashInfo` inner content:
> ```html
> <span class="text-muted fst-italic">GCash details will be provided upon order confirmation via SMS or email.</span>
> ```
>
> `#bankInfo` inner content:
> ```html
> <span class="text-muted fst-italic">Bank transfer details will be provided upon order confirmation via SMS or email.</span>
> ```
>
> Do not touch radio inputs, labels, or any JS files.

---

### CH-2 · Fake Demo Cart Shown at Checkout
**File:** `assets/js/checkout.js` · Lines 5–13

> In `checkout.js`, delete the `getCartOrFallback()` function (lines 5–13) entirely. In every place it is called (`renderSummary()` line 18, and `initForm()` line 132), replace `getCartOrFallback()` with `CheynCart.get()`.
>
> Then, at the top of `renderSummary()`, add an empty-cart guard: if `CheynCart.get().length === 0`, execute `window.location.href = 'cart.php'` and return early. Do not modify any PHP or CSS files.

---

### CA-1 · Fake Items Seeded into Every Empty Cart
**File:** `assets/js/cart.js` · Lines 10–18, 101

> In `cart.js`:
> 1. Delete the entire `seedSampleCart()` function (lines 10–18).
> 2. On line 101 (inside the `DOMContentLoaded` callback), delete the `seedSampleCart();` call.
>
> The `renderCart()` call on the following line already handles the empty state via `#emptyCartState`. No other changes needed. Do not touch any other function or file.

---

## 🟠 Medium Priority

---

### L-1 · Raw `alert()` Dialogs on Login/Register Submit
**File:** `assets/js/login.js` · Lines 48, 63

> In `login.js`:
> - Line 48: Replace `alert('Login submitted! (Backend integration pending)')` with `showToast('Login coming soon. Stay tuned!', 'info')`
> - Line 63: Replace `alert('Account created! (Backend integration pending)')` with `showToast('Registration coming soon. Stay tuned!', 'info')`
>
> Do not change any validation logic, form structure, or other lines. `showToast` is already globally available from `main.js`.

---

### P-1 · "You May Also Like" Always Shows Same 4 Static iPhones
**Files:** `product.php` · Lines 158–238 · `assets/js/product.js` · after line 206

> In `product.php`, delete the four static `<article class="product-card">` elements inside the "You May Also Like" `<div class="row g-3">`. Replace the row contents with a single empty container: `<div id="relatedGrid" class="row g-3"></div>`.
>
> In `product.js`, after the `addBtn` event listener block (after line 206, still inside `DOMContentLoaded`), add:
> ```js
> var relatedGrid = document.getElementById('relatedGrid');
> if (relatedGrid) {
>   var related = CHEYN_PRODUCTS.filter(function(p) { return p.id !== product.id; }).slice(0, 4);
>   relatedGrid.innerHTML = related.map(function(p) {
>     var opt = p.storageOptions[0];
>     return '<div class="col-6 col-md-3"><article class="product-card">' +
>       '<div class="card-img-wrap"><img src="' + p.image + '" alt="' + p.name + '" loading="lazy" onerror="this.onerror=null;this.src=\'https://placehold.co/400x400/fce4ec/e91e8c?text=\'+encodeURIComponent(this.alt)">' +
>       '<span class="badge-ct ' + p.badge + '">' + p.badgeLabel + '</span></div>' +
>       '<div class="card-body"><p class="product-name">' + p.name + '</p><p class="product-price">' + formatPrice(opt.price) + '</p></div>' +
>       '<div class="card-footer"><a href="product.php?id=' + p.id + '" class="btn btn-ct btn-ct-sm flex-grow-1">View</a></div>' +
>       '</article></div>';
>   }).join('');
> }
> ```
> Do not modify any CSS files.

---

### C-1 · Hardcoded Filter Counts in Catalog
**Files:** `catalog.php` · Lines 68–80 · `assets/js/catalog.js`

> In `catalog.php`, remove the `(5)`, `(2)`, `(3)` count strings from all filter checkbox labels. Instead, append `<span class="filter-count text-muted ms-1"></span>` to each label text with a matching `data-filter-count` attribute on the input — for example: `<input ... data-filter-count-for="preowned">` and `<span class="filter-count" data-count-for="preowned"></span>`.
>
> In `catalog.js`, create a `updateFilterCounts(filteredProducts)` function that iterates all `[data-count-for]` spans and counts how many items in `filteredProducts` match the filter value. Call it after every filter/sort operation and once on initial load.

---

### C-2 · Hardcoded Result Count ("12 products found")
**Files:** `catalog.php` · Lines 26, 170 · `assets/js/catalog.js`

> In `catalog.php`:
> - Line 26: Replace `<strong>12</strong> results` with `<strong id="heroResultCount">0</strong> results`
> - Line 170: Replace `12 products found` with `<span id="sortBarCount">0</span> products found`
>
> In `catalog.js`, wherever the product grid is rendered after filtering/sorting, add two lines immediately after:
> ```js
> document.getElementById('heroResultCount').textContent = filteredProducts.length;
> document.getElementById('sortBarCount').textContent = filteredProducts.length;
> ```
> These two lines should run every time the catalog re-renders. Do not touch any other markup or styles.

---

### C-3 · Dead Filter Tag Pills
**Files:** `catalog.php` · Lines 51–53 · `assets/js/catalog.js`

> In `catalog.php`, delete lines 51–53 (the two hardcoded `<span class="filter-tag">` elements). Leave the `<div class="active-filters" id="activeFilters">` container div in place but empty it.
>
> In `catalog.js`, add a `renderActiveTags()` function. It should read the current active filter state, build one `.filter-tag` span per active value, and set `#activeFilters`'s `innerHTML`. Each tag's `×` button should: uncheck the corresponding checkbox, trigger a catalog re-render, and call `renderActiveTags()` again. If there are no active filters, set `document.getElementById('activeFilters').style.display = 'none'`, otherwise remove that style. Call `renderActiveTags()` after every filter change and on initial load.

---

### C-4 · Mobile Offcanvas Filter Inputs Have No `name` or `value`
**File:** `catalog.php` · Lines 212–233

> In `catalog.php`, find every `<input class="form-check-input" type="checkbox">` inside the `#filterOffcanvas` offcanvas body (the mobile filter panel, lines 212–233). Add the missing `name` and `value` attributes to each, matching their desktop counterparts:
>
> - `mCatPreownedIphone` → `name="cat" value="preowned"`
> - `mCatNewIphone` → `name="cat" value="new"`
> - `mCatAndroid` → `name="cat" value="android"`
> - `mCatTablet` → `name="cat" value="tablet"`
> - `mVar64` → `name="variant" value="64gb"`
> - `mVar128` → `name="variant" value="128gb"`
> - `mVar256` → `name="variant" value="256gb"`
> - `mVar512` → `name="variant" value="512gb"`
> - `mCondPreowned` → `name="condition" value="preowned"`
> - `mCondRefurb` → `name="condition" value="refurbished"`
> - `mCondNew` → `name="condition" value="brandnew"`
>
> Do not change any other attribute. Do not touch any JS or CSS files.

---

### T-1 · Any `CT-XXXXX` Input Shows a Fake iPhone Order
**File:** `assets/js/track-order.js` · Lines 59–77

> In `track-order.js`, inside the form submit handler, delete the fallback `if (!order)` branch that returns demo data for any regex-matching order ID (lines 61–77). Replace the entire `if (!order)` block with:
> ```js
> if (!order) {
>   errEl.style.display = 'block';
>   errEl.innerHTML = '<i class="bi bi-exclamation-circle me-1"></i>Order not found. Please double-check your Order ID or <a href="contact.php">contact us</a>.';
>   input.focus();
>   return;
> }
> ```
> Do not touch the `ORDERS` map, the `showResult()` function, or any other part of the file.

---

### CO-4 · Contact Form Resets to Hardcoded Product Name
**File:** `assets/js/contact.js` · Line 19

> In `contact.js`, on line 19, change:
> ```js
> productInput.value = 'iPhone 13 Pro-128GB Graphite';
> ```
> to:
> ```js
> productInput.value = '';
> ```
> That is the only change. Do not modify any other line in the file.

---

## 🟡 Low Priority

---

### CO-1 · Contact Page Phone Number is a Placeholder
**File:** `contact.php` · Line 96

> In `contact.php`, find line 96: `<a href="tel:09XXXXXXXXX" ...>09XX-XXX-XXXX</a>`. Replace both the `href` value and the display text with the real store phone number. If the real number is not yet confirmed, replace the entire `<a>` element with: `<span class="text-muted fst-italic">To be confirmed</span>`.

---

### CO-2 · All Social Links Point to `#`
**Files:** `contact.php` · Lines 119–121 · `includes/footer.php` · Lines 12–14

> In `contact.php` (lines 119–121) and `includes/footer.php` (lines 12–14), replace `href="#"` on each social anchor with the real URL:
> - Facebook → `href="https://facebook.com/YOUR_PAGE_NAME"`
> - Instagram → `href="https://instagram.com/YOUR_HANDLE"`
> - TikTok → `href="https://tiktok.com/@YOUR_HANDLE"`
>
> Also add `target="_blank" rel="noopener noreferrer"` to each. If a platform is not yet active, replace that anchor's `href="#"` with `aria-disabled="true" tabindex="-1" title="Coming soon"` and remove the `href` attribute entirely.

---

### CO-3 · Contact Map is a Grey Box
**File:** `contact.php` · Lines 124–129

> In `contact.php`, delete the entire map placeholder `<div>` block (lines 124–129). In its place, insert:
> ```html
> <iframe
>   src="https://www.google.com/maps?q=Roxas+City,+Capiz,+Philippines&output=embed"
>   width="100%"
>   height="200"
>   style="border:0;border-radius:12px;margin-top:1rem;"
>   loading="lazy"
>   referrerpolicy="no-referrer-when-downgrade"
>   title="CheynTech store location"
>   allowfullscreen>
> </iframe>
> ```
> Do not modify any CSS or JS files.

---

### P-2 · Trust Note Hardcoded for All Conditions
**Files:** `product.php` · Line 72 · `assets/js/product.js` · after line 102

> In `product.php`, give the trust note `<span class="small">` element an id: `id="trustNoteText"`.
>
> In `product.js`, after line 102 (where `shortDescEl` is set), add:
> ```js
> var trustNote = document.getElementById('trustNoteText');
> if (trustNote) {
>   if (product.condition === 'Brand New') {
>     trustNote.innerHTML = 'Full function test passed — battery, screen, cameras, and all connectivity checked. <strong>7-day replacement guarantee</strong> · Comes with charger and original box.';
>   } else if (product.condition === 'Refurbished') {
>     trustNote.innerHTML = 'Professionally refurbished — battery, screen, cameras, and ports all verified. <strong>7-day replacement guarantee</strong> · Comes with a compatible charger.';
>   } else {
>     trustNote.innerHTML = 'Function-tested by our team — screen, cameras, Face ID, and connectivity verified. <strong>7-day replacement guarantee</strong> · Unit only; charger may not be included.';
>   }
> }
> ```
> Do not touch any other line in either file.

---

### P-3 · Store Hours Mismatch on Product Page
**File:** `product.php` · Line 151

> In `product.php`, on line 151, find the text `9:00 AM – 7:00 PM` and change it to `9:00 AM – 6:00 PM`. That is the only change. Do not touch any other file.

---

### T-2 · Placeholder Phone Number in Track Order
**File:** `track-order.php` · Lines 139–141

> In `track-order.php`, find lines 139–141:
> ```html
> <a href="tel:+639171234567" class="fw-600 track-action-link">
>   <i class="bi bi-telephone-fill me-1"></i>0917-123-4567
> </a>
> ```
> Replace it with the actual store phone number. If not yet confirmed, replace the entire `<a>` block with:
> ```html
> <span class="fw-600 track-action-link">Contact us via Facebook or email for assistance.</span>
> ```
> Do not touch any other line in the file.

---

### I-3 · Pixel 7 Card Name/Alt Mismatch
**File:** `index.php` · Line 229

> In `index.php`, on line 229, find `<p class="product-name">Google Pixel 7 – 128GB Snow</p>` and change `Snow` to `Obsidian` so it matches the `alt` attribute and the `quickAddToCart` `color` field on the same card. That is the only change.

---

### A-1 · Admin Dashboard — Total Products Can Be Made Real
**Files:** `admin/dashboard.php` · Line 60 · `assets/js/admin/dashboard.js`

> In `admin/dashboard.php`, give the "Total Products" stat value span an id: change `<div class="stat-value">48</div>` (line 60) to `<div class="stat-value" id="totalProductsCount">—</div>`.
>
> In `assets/js/admin/dashboard.js`, add the following at the bottom of the `DOMContentLoaded` callback (or directly if there is none):
> ```js
> if (typeof CHEYN_PRODUCTS !== 'undefined') {
>   var el = document.getElementById('totalProductsCount');
>   if (el) el.textContent = CHEYN_PRODUCTS.length;
> }
> ```
> Then in `admin/dashboard.php`, add `<script src="../assets/js/products-data.js"></script>` before the existing `dashboard.js` script tag so `CHEYN_PRODUCTS` is available. Leave all other stat values (orders, low stock) as-is — those require real data.
