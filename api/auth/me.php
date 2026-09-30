<?php
// api/auth/me.php
declare(strict_types=1);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

header('Content-Type: application/json');

if (!empty($_SESSION['user_id'])) {
    echo json_encode([
        'loggedIn' => true,
        'user' => [
            'id'    => $_SESSION['user_id'],
            'name'  => $_SESSION['user_name'] ?? 'User',
            'email' => $_SESSION['user_email'] ?? '',
            'role'  => $_SESSION['user_role'] ?? 'customer',
        ]
    ]);
} else {
    echo json_encode(['loggedIn' => false]);
}
