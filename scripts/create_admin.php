<?php
// scripts/create_admin.php
// CLI-only script to create or promote an admin user account.
declare(strict_types=1);

if (php_sapi_name() !== 'cli') {
    http_response_code(403);
    echo "Error: This script must be executed via the command line interface (CLI).\n";
    exit(1);
}

require_once __DIR__ . '/../config/database.php';

echo "=== CheynTech Admin Account Setup ===\n";

$name     = $argv[1] ?? '';
$email    = $argv[2] ?? '';
$password = $argv[3] ?? '';

if (empty($name)) {
    echo "Admin Name: ";
    $name = trim((string)fgets(STDIN));
}
if (empty($email)) {
    echo "Admin Email: ";
    $email = trim((string)fgets(STDIN));
}
if (empty($password)) {
    echo "Admin Password (min 8 chars): ";
    $password = trim((string)fgets(STDIN));
}

if (empty($name) || empty($email) || empty($password)) {
    echo "Error: Name, email, and password are required.\n";
    exit(1);
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo "Error: Invalid email format: {$email}\n";
    exit(1);
}

if (strlen($password) < 8) {
    echo "Error: Password must be at least 8 characters long.\n";
    exit(1);
}

try {
    $stmt = $pdo->prepare('SELECT id, name, role FROM users WHERE email = ? LIMIT 1');
    $stmt->execute([$email]);
    $existing = $stmt->fetch();

    $hash = password_hash($password, PASSWORD_BCRYPT);

    if ($existing) {
        $update = $pdo->prepare('UPDATE users SET name = ?, password_hash = ?, role = "admin" WHERE id = ?');
        $update->execute([$name, $hash, $existing['id']]);
        echo "Success: Existing user '{$email}' (ID: {$existing['id']}) updated and promoted to Admin.\n";
    } else {
        $insert = $pdo->prepare('INSERT INTO users (name, email, password_hash, role) VALUES (?, ?, ?, "admin")');
        $insert->execute([$name, $email, $hash]);
        $newId = (int)$pdo->lastInsertId();
        echo "Success: New admin user '{$email}' created with ID: {$newId}.\n";
    }
} catch (Exception $e) {
    echo "Database error: " . $e->getMessage() . "\n";
    exit(1);
}
