<?php
// api/admin/inquiries.php
declare(strict_types=1);

require_once __DIR__ . '/../../includes/session.php';

header('Content-Type: application/json');
header('Cache-Control: no-cache, no-store, must-revalidate');

// Admin session security check
if (empty($_SESSION['user_id']) || ($_SESSION['user_role'] ?? '') !== 'admin') {
    http_response_code(401);
    echo json_encode(['success' => false, 'error' => 'Unauthorized. Admin session required.']);
    exit;
}

require_once __DIR__ . '/../../config/database.php';

$method = $_SERVER['REQUEST_METHOD'];

if ($method !== 'GET') {
    $clientCsrf  = $_SERVER['HTTP_X_CSRF_TOKEN'] ?? '';
    $sessionCsrf = $_SESSION['csrf_token'] ?? '';
    if (empty($sessionCsrf) || !hash_equals($sessionCsrf, $clientCsrf)) {
        http_response_code(403);
        echo json_encode(['success' => false, 'error' => 'Invalid or missing CSRF token.']);
        exit;
    }
}

// -------------------------------------------------------------
// GET: Fetch customer inquiries & password reset requests
// -------------------------------------------------------------
if ($method === 'GET') {
    try {
        $stmt = $pdo->query('
            SELECT id, product_name, name, email, phone, message, created_at
            FROM inquiries
            ORDER BY created_at DESC
        ');
        $rows = $stmt->fetchAll();

        $inquiries = [];
        foreach ($rows as $r) {
            $isPasswordReset = (stripos($r['product_name'] ?? '', 'Password') !== false) || (stripos($r['message'] ?? '', 'reset') !== false);
            $inquiries[] = [
                'id'          => (int)$r['id'],
                'productName' => $r['product_name'] ?? 'General Inquiry',
                'name'        => $r['name'] ?? 'Visitor',
                'email'       => $r['email'] ?? '',
                'phone'       => $r['phone'] ?? '',
                'message'     => $r['message'] ?? '',
                'isReset'     => $isPasswordReset,
                'date'        => date('M j, Y g:i A', strtotime((string)$r['created_at'])),
                'rawDate'     => $r['created_at']
            ];
        }

        echo json_encode([
            'success'   => true,
            'count'     => count($inquiries),
            'inquiries' => $inquiries
        ]);
        exit;

    } catch (Exception $e) {
        error_log('Admin inquiries GET error: ' . $e->getMessage());
        http_response_code(500);
        echo json_encode(['success' => false, 'error' => 'Failed to load inquiries.']);
        exit;
    }
}

// -------------------------------------------------------------
// DELETE: Delete / clear inquiry
// -------------------------------------------------------------
if ($method === 'DELETE') {
    $input = json_decode(file_get_contents('php://input'), true);
    $id = (int)($input['id'] ?? $_GET['id'] ?? 0);

    if ($id <= 0) {
        http_response_code(400);
        echo json_encode(['success' => false, 'error' => 'Valid inquiry ID is required.']);
        exit;
    }

    try {
        $stmt = $pdo->prepare('DELETE FROM inquiries WHERE id = ?');
        $stmt->execute([$id]);

        echo json_encode([
            'success' => true,
            'message' => 'Inquiry removed successfully.'
        ]);
        exit;

    } catch (Exception $e) {
        error_log('Admin inquiry delete error: ' . $e->getMessage());
        http_response_code(500);
        echo json_encode(['success' => false, 'error' => 'Failed to remove inquiry.']);
        exit;
    }
}

http_response_code(405);
echo json_encode(['success' => false, 'error' => 'Method not allowed.']);
