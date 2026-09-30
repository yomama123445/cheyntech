<?php
// api/contact.php
declare(strict_types=1);

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

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'error'   => 'Please provide a valid email address.'
    ]);
    exit;
}

require_once __DIR__ . '/../config/database.php';

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
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error'   => 'Unable to record your inquiry. Please try again later.'
    ]);
    exit;
}
