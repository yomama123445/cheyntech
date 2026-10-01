# CheynTech checklist (ordered by risk). Source of truth for scope: docs/cheyntech_proposal.pdf
Each item: file, exact change, what not to touch, and a check that proves it.
Items tagged [REQ] come straight from the proposal's in-scope list or success metrics.

## Security (do first; read these diffs yourself before merging)

- [x] **S1 Stop leaking exception text.** File: api/orders/create.php only (the catch block).
  Replace `$e->getMessage()` in the JSON response with a generic message and call
  `error_log($e->getMessage())`. Use a small custom exception class for the deliberate
  out-of-stock and missing-variant errors so those keep a safe, specific message.
  Do not edit anything in config/.
  Done when: no `getMessage()` appears inside a json_encode or echo in api/orders/create.php.

- [x] **S2 Regenerate session on login and register.** api/auth/login.php, api/auth/register.php.
  Call `session_regenerate_id(true)` right after success, before writing $_SESSION. Nothing else.
  Done when: `grep -n session_regenerate_id api/auth/*.php` lists both files.

- [ ] **S3 Harden session cookies.** Add includes/session.php (HttpOnly, SameSite=Lax, Secure on HTTPS)
  and use it everywhere session_start() is called today.
  Done when: `grep -rn "session_start()" --include=*.php .` matches only includes/session.php.

- [ ] **S4 CSRF on admin write endpoints.** api/admin/products.php (POST, PUT, DELETE),
  api/admin/orders.php (POST, PATCH, PUT): copy the hash_equals check from api/auth/login.php, non-GET only.
  Send X-CSRF-Token from assets/js/admin/*.js (read the meta tag as assets/js/login.js does).
  Done when: smoke test "admin write without token" passes (add it to tests only if TASK says so; run manually with curl otherwise).

- [ ] **S5 Protect order tracking.** api/orders/track.php, assets/js/track-order.js, track-order.php.
  Require order number AND checkout email; same 404 message for both failures. Use `random_int` instead of
  `mt_rand` in api/orders/create.php for order numbers.

- [ ] **S6 Rate limit** login, register, contact, track: migration for a `rate_limit` table plus
  includes/rate_limit.php keyed by IP + endpoint (10 per 10 min auth/track, 5 per 10 min contact). Return 429.

- [ ] **S7 [REQ] HTTPS and security headers.** Add BOTH `.htaccess` (force HTTPS, HSTS, X-Content-Type-Options,
  X-Frame-Options, Referrer-Policy; deny web access to config/, database/, docs/, wireframes/, *.md, *.xml, *.sql)
  and `deploy/nginx-snippet.conf` with the equivalent Nginx rules, since HestiaCP may serve through Nginx only.
  The owner decides which applies after checking the server (see DEPLOY.md). Never expose repomix-output.xml.
  Done when: both files exist and `grep -c "config" .htaccess deploy/nginx-snippet.conf` is at least 1 in each.

## Correctness and inventory

- [ ] **B1 [REQ] Fix overselling race.** api/orders/create.php: `SELECT ... FOR UPDATE` per variant inside the
  transaction; replace `GREATEST(0, stock - ?)` with `stock = stock - ?` guarded by `AND stock >= ?` and fail the
  order if zero rows updated. Return 409 on insufficient stock.

- [ ] **B2 Do not trust client names.** api/orders/create.php: take product name and variant label from the
  database by variant id. Cap qty at 10 per line and 20 lines per order.

- [ ] **B3 [REQ] Restore stock on cancel.** api/admin/orders.php: when status changes to `cancelled` from any
  non-cancelled state, add each order item's qty back to product_variants in the same transaction. Do not
  restore twice (check previous status).
  DECISION NEEDED FROM OWNER: the proposal says stock decrements "on confirmed orders", but code decrements
  when the order is placed (pending). Keep current behavior unless told otherwise.

- [ ] **B4 Contact form protection.** api/contact.php, assets/js/contact.js: CSRF check, hidden honeypot,
  max lengths (name 100, email 150, message 2000).

- [ ] **B5 Validate JSON bodies.** login.php, register.php, orders/create.php: non-array body returns 400.

## Missing proposal features

- [ ] **F1 [REQ] Customer profile management.** Add profile.php, api/auth/profile.php (GET/PUT name, phone,
  password change requiring current password, CSRF protected), assets/js/profile.js, and a "My account" link in
  includes/header.php when logged in. Show the user's past orders (join on orders.user_id).

- [ ] **F2 [REQ] Live admin dashboard.** admin/dashboard.php and assets/js/admin/dashboard.js currently show
  hardcoded numbers and a hardcoded low-stock list (e.g. "Low Stock Items: 5", "iPhone 12 Mini"). Compute the
  stats and low-stock list from api/admin/products.php and api/admin/orders.php. Low stock means stock <= 3
  (same rule as api/admin/products.php).

- [ ] **F3 [REQ] Manual stock adjustment in admin.** assets/js/admin/products.js contains a hardcoded sample
  product array. Remove it and load from api/admin/products.php. Add an "Adjust stock" control that PUTs the
  new stock value (CSRF protected, admin only).

- [ ] **F4 [REQ] SEO files.** Add robots.txt and sitemap.xml (public pages only; exclude admin/ and api/).
  Confirm every public page sets a unique $pageTitle and $pageDescription before including header.php.
  Done when: `bash tests/requirements.sh` shows SEO checks passing.

- [ ] **F5 Remove demo data paths.** Per vibe-coded-audit.md items CA-1 (seeded fake cart), CH-2 (fake checkout
  cart), CH-1 (placeholder payment details) and assets/js/products-data.js if the pages now load from the API.
  Check each is still present before changing it; record mismatches in BUILDER_NOTES.md.

## Deployment readiness

- [ ] **D1 No hardcoded credentials.** Use config/database.example.php's pattern in the repo. On HestiaCP keep the real
  config/database.php as a server-only file (gitignored, chmod 640), or set variables in the PHP-FPM pool. Rotate the DB password.
- [ ] **D2 Admin account script.** scripts/create_admin.php, CLI only, refuses to run under a web server.
- [ ] **D3 Deploy notes.** DEPLOY.md for HestiaCP: create web domain and database in the panel, import schema via phpMyAdmin,
  enable Let's Encrypt SSL with force-HTTPS, upload via Git or SFTP, create the server-only config, run create_admin.php over SSH,
  check whether Apache or Nginx-only serves the site, enable backups.

## Polish (fixes.md; run a few rounds, then review by eye)

- [ ] **P1 Location wording.** Roxas City already appears in several files. List every remaining reference to
  another place (e.g. "Capiz" in index.php line 76 and contact.php line 92) and confirm with the owner whether
  each should stay. Text-only changes.
- [ ] **P2 Remove emojis and unprofessional symbols** from pages and JS strings.
- [ ] **P3 Brand-styled toasts and dialogs** instead of native alert/confirm.
- [ ] **P4 Catalog filter button flexbox bug** (fixes.md).
- [ ] **P5 Dead buttons** (fixes.md): list every `<button>` and CTA without a handler or link, then fix or remove.

## Final QA against proposal success metrics (human, not agent)
Lighthouse mobile performance >= 80 and accessibility >= 90; layouts checked at 375, 768, 1440 px;
owner can add/edit/delete products and update order status unaided; stock decrements correctly.
