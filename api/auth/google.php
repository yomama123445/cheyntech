<?php
// api/auth/google.php
declare(strict_types=1);

require_once __DIR__ . '/../../includes/session.php';

header('Content-Type: application/json');
header('Cache-Control: no-cache, no-store, must-revalidate');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'error' => 'Method not allowed.']);
    exit;
}

$input = json_decode(file_get_contents('php://input'), true);
if (!is_array($input)) {
    $input = $_POST;
}

$credential = trim((string)($input['credential'] ?? ''));
if (empty($credential)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => 'Missing Google credential token.']);
    exit;
}

require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../includes/rate_limit.php';

// TASK S6 compliance: 15 attempts per 10 minutes
check_rate_limit($pdo, 'auth_google', 15, 600);

try {
    // Verify ID token via Google OAuth2 tokeninfo endpoint
    $verifyUrl = 'https://oauth2.googleapis.com/tokeninfo?id_token=' . urlencode($credential);
    
    $ctx = stream_context_create([
        'http' => [
            'timeout'    => 5,
            'user_agent' => 'CheynTech-Auth/1.0'
        ]
    ]);
    
    $response = @file_get_contents($verifyUrl, false, $ctx);
    if ($response === false) {
        http_response_code(401);
        echo json_encode(['success' => false, 'error' => 'Google authentication failed or expired. Please try again.']);
        exit;
    }

    $payload = json_decode($response, true);
    if (!is_array($payload) || empty($payload['email'])) {
        http_response_code(401);
        echo json_encode(['success' => false, 'error' => 'Unable to verify Google profile.']);
        exit;
    }

    // Verify email is verified by Google
    $emailVerified = ($payload['email_verified'] ?? false);
    if ($emailVerified !== true && $emailVerified !== 'true') {
        http_response_code(403);
        echo json_encode(['success' => false, 'error' => 'Google email is not verified.']);
        exit;
    }

    $email = strtolower(trim((string)$payload['email']));
    $name  = trim((string)($payload['name'] ?? explode('@', $email)[0]));

    // Check if user already exists in database
    $stmt = $pdo->prepare('SELECT id, name, email, role FROM users WHERE LOWER(email) = ? LIMIT 1');
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user) {
        $userId   = (int)$user['id'];
        $userName = (string)$user['name'];
        $userRole = (string)$user['role'];
    } else {
        // Auto-provision customer account for new Google users
        $randomSecret = bin2hex(random_bytes(24));
        $hashedSecret = password_hash($randomSecret, PASSWORD_BCRYPT);

        $insertStmt = $pdo->prepare('
            INSERT INTO users (name, email, password_hash, phone, role)
            VALUES (?, ?, ?, NULL, "customer")
        ');
        $insertStmt->execute([$name, $email, $hashedSecret]);
        $userId   = (int)$pdo->lastInsertId();
        $userName = $name;
        $userRole = 'customer';
    }

    // Harden session: regenerate session ID on login
    session_regenerate_id(true);
    $_SESSION['user_id']    = $userId;
    $_SESSION['user_name']  = $userName;
    $_SESSION['user_email'] = $email;
    $_SESSION['user_role']  = $userRole;

    echo json_encode([
        'success'  => true,
        'message'  => 'Signed in successfully with Google.',
        'user'     => [
            'id'    => $userId,
            'name'  => $userName,
            'email' => $email,
            'role'  => $userRole
        ]
    ]);
    exit;

} catch (Exception $e) {
    error_log('Google sign-in error: ' . $e->getMessage());
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => 'An error occurred during Google sign-in. Please try again.']);
    exit;
}
