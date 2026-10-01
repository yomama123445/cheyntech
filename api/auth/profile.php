<?php
// api/auth/profile.php
declare(strict_types=1);

require_once __DIR__ . '/../../includes/session.php';
require_once __DIR__ . '/../../config/database.php';

header('Content-Type: application/json');
header('Cache-Control: no-cache, no-store, must-revalidate');

if (empty($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode(['success' => false, 'error' => 'Unauthorized. Please sign in.']);
    exit;
}

$userId = (int)$_SESSION['user_id'];
$method = $_SERVER['REQUEST_METHOD'];

// -------------------------------------------------------------
// GET: Fetch customer profile and past orders
// -------------------------------------------------------------
if ($method === 'GET') {
    try {
        $stmt = $pdo->prepare('SELECT id, name, email, phone, role, created_at FROM users WHERE id = ? LIMIT 1');
        $stmt->execute([$userId]);
        $user = $stmt->fetch();

        if (!$user) {
            http_response_code(404);
            echo json_encode(['success' => false, 'error' => 'User account not found.']);
            exit;
        }

        // Fetch user's past orders
        $ordersStmt = $pdo->prepare('
            SELECT id, order_number, fulfillment, delivery_address, payment_method,
                   total_amount, status, created_at
            FROM orders
            WHERE user_id = ?
            ORDER BY created_at DESC
        ');
        $ordersStmt->execute([$userId]);
        $orderRows = $ordersStmt->fetchAll();

        // Fetch line items for user's orders
        $orderIds = array_column($orderRows, 'id');
        $itemsByOrderId = [];

        if (!empty($orderIds)) {
            $inClause = implode(',', array_fill(0, count($orderIds), '?'));
            $itemStmt = $pdo->prepare("
                SELECT order_id, product_name, variant_info, price, qty, line_total
                FROM order_items
                WHERE order_id IN ($inClause)
                ORDER BY id ASC
            ");
            $itemStmt->execute($orderIds);
            $items = $itemStmt->fetchAll();

            foreach ($items as $it) {
                $itemsByOrderId[$it['order_id']][] = [
                    'product_name' => $it['product_name'],
                    'variant_info' => $it['variant_info'],
                    'price'        => (float)$it['price'],
                    'qty'          => (int)$it['qty'],
                    'line_total'   => (float)$it['line_total']
                ];
            }
        }

        $statusLabelMap = [
            'pending'          => 'Pending Review',
            'processing'       => 'Processing',
            'ready_pickup'     => 'Ready for Pickup',
            'out_for_delivery' => 'Out for Delivery',
            'completed'        => 'Completed',
            'cancelled'        => 'Cancelled'
        ];

        $orders = [];
        foreach ($orderRows as $row) {
            $orders[] = [
                'id'           => $row['id'],
                'order_number' => $row['order_number'],
                'date'         => date('M d, Y', strtotime((string)$row['created_at'])),
                'fulfillment'  => $row['fulfillment'] === 'delivery' ? 'Local Delivery' : 'Store Pickup',
                'address'      => $row['delivery_address'] ?: 'Store Pickup',
                'payment'      => ucfirst((string)$row['payment_method']),
                'total'        => (float)$row['total_amount'],
                'status'       => $statusLabelMap[$row['status']] ?? ucfirst((string)$row['status']),
                'raw_status'   => $row['status'],
                'items'        => $itemsByOrderId[$row['id']] ?? []
            ];
        }

        echo json_encode([
            'success' => true,
            'user'    => [
                'id'         => (int)$user['id'],
                'name'       => $user['name'],
                'email'      => $user['email'],
                'phone'      => $user['phone'] ?? '',
                'role'       => $user['role'],
                'created_at' => $user['created_at']
            ],
            'orders'  => $orders
        ]);
        exit;

    } catch (Exception $e) {
        error_log('Profile GET error: ' . $e->getMessage());
        http_response_code(500);
        echo json_encode(['success' => false, 'error' => 'Failed to load profile details.']);
        exit;
    }
}

// -------------------------------------------------------------
// PUT: Update customer profile details (name, phone, password)
// -------------------------------------------------------------
if ($method === 'PUT' || $method === 'POST') {
    $clientCsrf  = $_SERVER['HTTP_X_CSRF_TOKEN'] ?? '';
    $sessionCsrf = $_SESSION['csrf_token'] ?? '';
    if (empty($sessionCsrf) || !hash_equals($sessionCsrf, $clientCsrf)) {
        http_response_code(403);
        echo json_encode(['success' => false, 'error' => 'Invalid or missing CSRF token.']);
        exit;
    }

    $input = json_decode(file_get_contents('php://input'), true);
    if (!is_array($input)) {
        $input = $_POST;
    }
    if (!is_array($input)) {
        http_response_code(400);
        echo json_encode(['success' => false, 'error' => 'Invalid JSON body.']);
        exit;
    }

    $name            = trim((string)($input['name'] ?? ''));
    $phone           = trim((string)($input['phone'] ?? ''));
    $currentPassword = (string)($input['current_password'] ?? '');
    $newPassword     = (string)($input['new_password'] ?? '');

    if (empty($name)) {
        http_response_code(400);
        echo json_encode(['success' => false, 'error' => 'Name cannot be empty.']);
        exit;
    }

    if (mb_strlen($name) > 100) {
        http_response_code(400);
        echo json_encode(['success' => false, 'error' => 'Name cannot exceed 100 characters.']);
        exit;
    }

    if (mb_strlen($phone) > 30) {
        http_response_code(400);
        echo json_encode(['success' => false, 'error' => 'Phone number cannot exceed 30 characters.']);
        exit;
    }

    try {
        $userStmt = $pdo->prepare('SELECT password_hash FROM users WHERE id = ? LIMIT 1');
        $userStmt->execute([$userId]);
        $userRecord = $userStmt->fetch();

        if (!$userRecord) {
            http_response_code(404);
            echo json_encode(['success' => false, 'error' => 'User account not found.']);
            exit;
        }

        $passwordUpdate = false;
        $newPasswordHash = null;

        if (!empty($newPassword) || !empty($currentPassword)) {
            if (empty($currentPassword)) {
                http_response_code(400);
                echo json_encode(['success' => false, 'error' => 'Please provide your current password to set a new password.']);
                exit;
            }

            if (!password_verify($currentPassword, (string)$userRecord['password_hash'])) {
                http_response_code(400);
                echo json_encode(['success' => false, 'error' => 'Current password is incorrect.']);
                exit;
            }

            if (strlen($newPassword) < 8) {
                http_response_code(400);
                echo json_encode(['success' => false, 'error' => 'New password must be at least 8 characters long.']);
                exit;
            }

            $passwordUpdate = true;
            $newPasswordHash = password_hash($newPassword, PASSWORD_BCRYPT);
        }

        if ($passwordUpdate) {
            $updateStmt = $pdo->prepare('UPDATE users SET name = ?, phone = ?, password_hash = ? WHERE id = ?');
            $updateStmt->execute([$name, $phone ?: null, $newPasswordHash, $userId]);
        } else {
            $updateStmt = $pdo->prepare('UPDATE users SET name = ?, phone = ? WHERE id = ?');
            $updateStmt->execute([$name, $phone ?: null, $userId]);
        }

        $_SESSION['user_name'] = $name;

        echo json_encode([
            'success' => true,
            'message' => 'Profile updated successfully.',
            'user'    => [
                'id'    => $userId,
                'name'  => $name,
                'email' => $_SESSION['user_email'] ?? '',
                'phone' => $phone
            ]
        ]);
        exit;

    } catch (Exception $e) {
        error_log('Profile update error: ' . $e->getMessage());
        http_response_code(500);
        echo json_encode(['success' => false, 'error' => 'Failed to update profile.']);
        exit;
    }
}

http_response_code(405);
echo json_encode(['success' => false, 'error' => 'Method not allowed.']);
