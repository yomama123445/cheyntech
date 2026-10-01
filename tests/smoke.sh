#!/usr/bin/env bash
# Smoke tests against a local PHP server + test database.
# Needs: php, curl, a MySQL/MariaDB with database/schema.sql loaded, and config/database.php
# pointing at it (CI does this automatically). Uses TEST data only, never production.
set -u
PORT=${PORT:-8089}
BASE="http://127.0.0.1:$PORT"
FAIL=0

php -S 127.0.0.1:$PORT -t . >/tmp/php-server.log 2>&1 &
SERVER_PID=$!
trap 'kill $SERVER_PID 2>/dev/null' EXIT
sleep 1

check() { # name, expected_status, actual_status
  if [ "$2" = "$3" ]; then echo "PASS  $1"; else echo "FAIL  $1 (expected $2, got $3)"; FAIL=1; fi
}
status() { curl -s -o /dev/null -w '%{http_code}' "$@"; }

# 1. every PHP file parses
LINT_FAIL=0
while IFS= read -r f; do php -l "$f" >/dev/null 2>&1 || { echo "FAIL  lint $f"; LINT_FAIL=1; }; done < <(find . -name '*.php' -not -path './vendor/*')
[ $LINT_FAIL = 0 ] && echo "PASS  php -l on all files" || FAIL=1

# 2. public pages load
for p in index.php catalog.php cart.php login.php contact.php about.php track-order.php; do
  check "GET $p" 200 "$(status "$BASE/$p")"
done

# 3. products API responds with JSON success
body=$(curl -s "$BASE/api/products/get.php")
echo "$body" | grep -q '"success":true' && echo "PASS  products API success" || { echo "FAIL  products API"; FAIL=1; }

# 4. auth and write endpoints reject requests without a CSRF token
check "login without CSRF"    403 "$(status -X POST -H 'Content-Type: application/json' -d '{"email":"a@b.co","password":"x"}' "$BASE/api/auth/login.php")"
check "register without CSRF" 403 "$(status -X POST -H 'Content-Type: application/json' -d '{}' "$BASE/api/auth/register.php")"
check "order without CSRF"    403 "$(status -X POST -H 'Content-Type: application/json' -d '{}' "$BASE/api/orders/create.php")"

# 5. admin endpoints reject anonymous users (GET and writes)
check "admin orders GET anon"      401 "$(status "$BASE/api/admin/orders.php")"
check "admin products GET anon"    401 "$(status "$BASE/api/admin/products.php")"
check "admin products DELETE anon" 401 "$(status -X DELETE "$BASE/api/admin/products.php?id=x")"

# 6. no internal error text leaks
leak=$(curl -s -X POST -H 'Content-Type: application/json' -d '{}' "$BASE/api/contact.php")
echo "$leak" | grep -qi 'SQLSTATE\|PDOException\|stack trace' && { echo "FAIL  error text leak"; FAIL=1; } || echo "PASS  no error leak on contact"

# 7. unknown order lookup is a clean 404
check "track unknown order" 404 "$(status "$BASE/api/orders/track.php?id=CT-00000")"

exit $FAIL
