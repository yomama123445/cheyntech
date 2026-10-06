<?php
// api/contact.php
declare(strict_types=1);

require_once __DIR__ . '/../includes/session.php';

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

// TASK B4: CSRF token validation
$clientCsrf  = $_SERVER['HTTP_X_CSRF_TOKEN'] ?? ($input['csrf_token'] ?? '');
$sessionCsrf = $_SESSION['csrf_token'] ?? '';
if (empty($sessionCsrf) || !hash_equals($sessionCsrf, $clientCsrf)) {
    http_response_code(403);
    echo json_encode(['success' => false, 'error' => 'Invalid or missing CSRF token.']);
    exit;
}

// TASK B4: Hidden honeypot check
$honeypot = trim((string)($input['website'] ?? ''));
if (!empty($honeypot)) {
    echo json_encode([
        'success' => true,
        'message' => 'Your inquiry has been submitted successfully!',
        'id'      => 0
    ]);
    exit;
}

$productName = trim((string)($input['product_name'] ?? $input['productName'] ?? ''));
$name        = trim((string)($input['name'] ?? $input['contactName'] ?? ''));
$email       = trim((string)($input['email'] ?? $input['contactEmail'] ?? ''));
$phone       = trim((string)($input['phone'] ?? $input['contactPhone'] ?? ''));
$message     = trim((string)($input['message'] ?? $input['contactMessage'] ?? ''));

// Validate required fields
if (empty($productName) || empty($name) || empty($email) || empty($message)) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'error'   => 'Please fill in all required fields (Product, Name, Email, and Message).'
    ]);
    exit;
}

// TASK B4: Max lengths (name 100, email 150, message 2000)
if (mb_strlen($name) > 100 || mb_strlen($email) > 150 || mb_strlen($message) > 2000) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'error'   => 'One or more fields exceed maximum allowed character length (Name: 100, Email: 150, Message: 2000).'
    ]);
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'error'   => 'Please provide a valid email address.'
    ]);
    exit;
}

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../includes/rate_limit.php';

// TASK S6: 5 inquiries per 10 minutes (600s)
check_rate_limit($pdo, 'contact', 5, 600);

try {
    $stmt = $pdo->prepare('
        INSERT INTO inquiries (product_name, name, email, phone, message)
        VALUES (?, ?, ?, ?, ?)
    ');
    $stmt->execute([
        $productName,
        $name,
        $email,
        !empty($phone) ? $phone : null,
        $message
    ]);

    $inquiryId = (int)$pdo->lastInsertId();

    echo json_encode([
        'success' => true,
        'message' => 'Your inquiry has been submitted successfully!',
        'id'      => $inquiryId
    ]);
    exit;

} catch (Exception $e) {
    error_log('Contact inquiry error: ' . $e->getMessage());
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error'   => 'Unable to record your inquiry. Please try again later.'
    ]);
    exit;
}
