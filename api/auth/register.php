<?php
// api/auth/register.php
declare(strict_types=1);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

header('Content-Type: application/json');
require_once '../../config/database.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'error' => 'Method not allowed']);
    exit;
}

$input = json_decode(file_get_contents('php://input'), true);
$name = trim($input['name'] ?? '');
$email = trim($input['email'] ?? '');
$password = $input['password'] ?? '';
$phone = trim($input['phone'] ?? '');

if (empty($name) || empty($email) || empty($password)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => 'Please fill in all required fields.']);
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => 'Please provide a valid email address.']);
    exit;
}

if (strlen($password) < 8) {
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => 'Password must be at least 8 characters.']);
    exit;
}

try {
    // Check if email already registered
    $checkStmt = $pdo->prepare('SELECT id FROM users WHERE email = ? LIMIT 1');
    $checkStmt->execute([$email]);
    if ($checkStmt->fetch()) {
        http_response_code(409);
        echo json_encode(['success' => false, 'error' => 'An account with this email already exists.']);
        exit;
    }

    // Securely hash password
    $hash = password_hash($password, PASSWORD_BCRYPT);

    $insertStmt = $pdo->prepare('INSERT INTO users (name, email, password_hash, phone, role) VALUES (?, ?, ?, ?, "customer")');
    $insertStmt->execute([$name, $email, $hash, $phone]);

    $newId = (int)$pdo->lastInsertId();

    // Auto-login newly registered user
    $_SESSION['user_id'] = $newId;
    $_SESSION['user_name'] = $name;
    $_SESSION['user_email'] = $email;
    $_SESSION['user_role'] = 'customer';

    echo json_encode([
        'success' => true,
        'user' => [
            'id' => $newId,
            'name' => $name,
            'email' => $email,
            'role' => 'customer'
        ]
    ]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => 'Server error while creating account.']);
}
