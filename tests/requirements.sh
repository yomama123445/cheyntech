#!/usr/bin/env bash
# Non-blocking progress report: which proposal requirements the code currently satisfies.
# Always exits 0. Run: bash tests/requirements.sh
ok()   { echo "DONE     $1"; }
todo() { echo "PENDING  $1"; }
has()  { [ -e "$1" ] && ok "$2" || todo "$2"; }

has robots.txt            "SEO: robots.txt"
has sitemap.xml           "SEO: sitemap.xml"
has .htaccess             "HTTPS redirect and security headers (.htaccess)"
has profile.php           "Customer profile page"
has api/auth/profile.php  "Customer profile API"
has scripts/create_admin.php "Admin account script"
has DEPLOY.md             "Deployment notes"

grep -rq "session_regenerate_id" api/auth 2>/dev/null && ok "Session regeneration on login" || todo "Session regeneration on login"
grep -q "FOR UPDATE" api/orders/create.php 2>/dev/null && ok "Row locking on checkout" || todo "Row locking on checkout"
grep -qiE "cancel.*(stock|restock)|restock" api/admin/orders.php 2>/dev/null && ok "Stock restored on cancel" || todo "Stock restored on cancel"
grep -q "getMessage" api/orders/create.php 2>/dev/null && grep -v error_log api/orders/create.php | grep -q "getMessage" && todo "No exception text sent to client" || ok "No exception text sent to client"
grep -q "Low Stock Items</div>" admin/dashboard.php 2>/dev/null && grep -B2 "Low Stock Items" admin/dashboard.php | grep -qE 'stat-value">[0-9]+<' && todo "Admin dashboard uses live data" || ok "Admin dashboard uses live data"
grep -qE "^const|^var|^let" assets/js/admin/products.js 2>/dev/null && head -5 assets/js/admin/products.js | grep -q "stock:" && todo "Admin products load from API (no sample array)" || ok "Admin products load from API (no sample array)"
grep -rq "seedSampleCart" assets/js 2>/dev/null && todo "No fake seeded cart" || ok "No fake seeded cart"
exit 0
