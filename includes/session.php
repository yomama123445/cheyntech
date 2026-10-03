<?php
// includes/session.php
// Centralized hardened session initialization with secure cookie parameters
declare(strict_types=1);

if (session_status() === PHP_SESSION_NONE) {
    $isSecure = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
        || (isset($_SERVER['SERVER_PORT']) && (int)$_SERVER['SERVER_PORT'] === 443)
        || (!empty($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https');

    session_set_cookie_params([
        'lifetime' => 0,
        'path'     => '/',
        'domain'   => '',
        'secure'   => $isSecure,
        'httponly' => true,
        'samesite' => 'Lax',
    ]);

    session_start();
}

/**
 * Generates cache-busted asset URL based on file modification timestamp.
 * Prevents aggressive browser/proxy caching from serving stale CSS and JS.
 */
if (!function_exists('asset_url')) {
    function asset_url(string $path): string {
        $cleanPath = ltrim($path, '/');
        $fsPath = __DIR__ . '/../' . (str_starts_with($cleanPath, '../') ? substr($cleanPath, 3) : $cleanPath);
        $v = file_exists($fsPath) ? (string)filemtime($fsPath) : '1.0';
        return $path . '?v=' . $v;
    }
}
