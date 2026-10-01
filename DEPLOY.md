# CheynTech HestiaCP Deployment Guide

This guide covers deploying CheynTech (`cheyngadgets.site`) on a VPS running **HestiaCP** (Nginx + Apache or Nginx + PHP-FPM, MariaDB).

---

## 1. Create Web Domain in HestiaCP

1. Log into your HestiaCP Admin Panel (`https://your-server-ip:8083`).
2. Navigate to **WEB** &rarr; click **Add Web Domain**.
3. Enter your domain: `cheyngadgets.site` (and alias `www.cheyngadgets.site`).
4. In Advanced Options:
   - Check **Enable SSL for this domain**.
   - Check **Use Let's Encrypt to obtain SSL certificate**.
   - Check **Enable automatic HTTP-to-HTTPS redirection**.
5. Save the domain.

---

## 2. Create the Database

1. In HestiaCP, navigate to **DB** &rarr; click **Add Database**.
2. Set:
   - **Database Name**: e.g., `Cheyn_gadgets_db` (or prefix assigned by HestiaCP).
   - **Database User**: e.g., `Cheyn_Cheyn`.
   - **Password**: Generate a strong password and save it securely.
3. Save the database.
4. Click **phpMyAdmin** link in HestiaCP.
5. Select your newly created database.
6. Go to the **Import** tab &rarr; choose `database/schema.sql` from the repository &rarr; click **Go**.
7. If there are any SQL files in `database/migrations/`, import them in ascending order (`001_...sql`, `002_...sql`).

---

## 3. Upload Application Files

Deploy using either **Git** (recommended) or **SFTP**:

### Option A: Via Git (over SSH)
SSH into your server:
```bash
ssh user@your-server-ip
cd /home/<user>/web/cheyngadgets.site/public_html
git clone https://github.com/yomama123445/cheyntech.git .
```

### Option B: Via SFTP
Upload project files into `/home/<user>/web/cheyngadgets.site/public_html/`.

---

## 4. Configure Database Credentials (Server-Only)

Create the production `config/database.php` file on the server. Never commit this file to source control.

```bash
cd /home/<user>/web/cheyngadgets.site/public_html
cp config/database.example.php config/database.php
chmod 640 config/database.php
```

Edit `config/database.php` with your database credentials:
```php
<?php
declare(strict_types=1);

$db_host = '127.0.0.1';
$db_name = 'Cheyn_gadgets_db';
$db_user = 'Cheyn_Cheyn';
$db_pass = 'YOUR_DB_PASSWORD';

try {
    $pdo = new PDO(
        "mysql:host={$db_host};dbname={$db_name};charset=utf8mb4",
        $db_user,
        $db_pass,
        [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
            PDO::ATTR_TIMEOUT            => 5,
        ]
    );
} catch (PDOException $e) {
    error_log('DB connection failed: ' . $e->getMessage());
    http_response_code(500);
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'error' => 'Service temporarily unavailable.']);
    exit;
}
```

---

## 5. Web Server Configuration & Security Headers

HestiaCP can run in two configurations:

### Configuration A: Nginx + Apache (Default)
Apache processes `.htaccess` automatically. The included `.htaccess` file enforces:
- HTTPS redirection
- HSTS (`Strict-Transport-Security: max-age=31536000; includeSubDomains`)
- Security headers (`X-Content-Type-Options`, `X-Frame-Options`, `Referrer-Policy`)
- Strict directory protection (denies direct access to `config/`, `database/`, `docs/`, `*.sql`, `*.md`)

### Configuration B: Nginx-Only (PHP-FPM)
If running Nginx standalone without Apache, `.htaccess` is ignored. Apply the included Nginx rules:
1. Copy `deploy/nginx-snippet.conf` to `/etc/nginx/conf.d/domains/cheyngadgets.site.conf` (or include it in `/home/<user>/conf/web/cheyngadgets.site/nginx.ssl.conf_incl`).
2. Test configuration: `nginx -t`.
3. Reload Nginx: `systemctl reload nginx`.

---

## 6. Create Admin Account

Run the CLI-only script over SSH to initialize your administrator account:
```bash
cd /home/<user>/web/cheyngadgets.site/public_html
php scripts/create_admin.php "Cheyn Admin" "admin@cheyngadgets.site" "YourSuperSecurePassword123!"
```

---

## 7. File Permissions & Backups

Ensure proper web server ownership and permissions:
```bash
chown -R <user>:<user> /home/<user>/web/cheyngadgets.site/public_html
find /home/<user>/web/cheyngadgets.site/public_html -type d -exec chmod 755 {} \;
find /home/<user>/web/cheyngadgets.site/public_html -type f -exec chmod 644 {} \;
chmod 640 /home/<user>/web/cheyngadgets.site/public_html/config/database.php
```

### Enable Automatic Backups in HestiaCP
1. In HestiaCP panel &rarr; **BACKUP** &rarr; verify automated daily backups are enabled.
2. Confirm both WEB (`cheyngadgets.site`) and DB (`Cheyn_gadgets_db`) are included in backup profiles.
