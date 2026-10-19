<?php
// includes/rate_limit.php
declare(strict_types=1);

/**
 * Robust database-backed IP rate limiter for public endpoints.
 * Returns 429 Too Many Requests if threshold is exceeded.
 *
 * @param PDO    $pdo         Active PDO database instance
 * @param string $endpoint    Unique endpoint key (e.g. 'auth', 'contact', 'track')
 * @param int    $maxHits     Maximum requests allowed per window
 * @param int    $windowSec   Window duration in seconds
 */
function check_rate_limit(PDO $pdo, string $endpoint, int $maxHits, int $windowSec): void {
    $ip = (string)($_SERVER['REMOTE_ADDR'] ?? '127.0.0.1');
    if (empty($ip)) {
        $ip = '127.0.0.1';
    }

    try {
        // Opportunistic garbage collection of expired entries (~2% probability)
        if (random_int(1, 50) === 1) {
            $pdo->query('DELETE FROM rate_limits WHERE expires_at < NOW()');
        }

        // Check current valid window
        $stmt = $pdo->prepare('
            SELECT id, hits, expires_at 
            FROM rate_limits 
            WHERE ip_address = ? AND endpoint = ? AND expires_at > NOW() 
            LIMIT 1
        ');
        $stmt->execute([$ip, $endpoint]);
        $record = $stmt->fetch();

        if ($record) {
            if ((int)$record['hits'] >= $maxHits) {
                http_response_code(429);
                header('Retry-After: ' . $windowSec);
                echo json_encode([
                    'success' => false,
                    'error'   => 'Too many requests. Please wait a few moments before trying again.'
                ]);
                exit;
            }

            $update = $pdo->prepare('UPDATE rate_limits SET hits = hits + 1 WHERE id = ?');
            $update->execute([$record['id']]);
        } else {
            $insert = $pdo->prepare('
                INSERT INTO rate_limits (ip_address, endpoint, hits, expires_at)
                VALUES (?, ?, 1, DATE_ADD(NOW(), INTERVAL ? SECOND))
            ');
            $insert->execute([$ip, $endpoint, $windowSec]);
        }
    } catch (Exception $e) {
        // Fail open safely on database or schema glitch so legitimate users are never locked out
        error_log('Rate limiter notice: ' . $e->getMessage());
    }
}
