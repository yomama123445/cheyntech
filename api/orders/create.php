<?php
// api/orders/create.php
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

$customerName  = trim($input['fullName'] ?? '');
$customerEmail = trim($input['email'] ?? '');
$customerPhone = trim($input['phone'] ?? '');
$fulfillment   = ($input['fulfillment'] ?? '') === 'delivery' ? 'delivery' : 'pickup';
$paymentMethod = in_array($input['payment'] ?? '', ['cash', 'gcash', 'bank'], true) ? $input['payment'] : 'cash';
$items         = $input['items'] ?? [];

// Optional delivery details
$deliveryAddress = '';
if ($fulfillment === 'delivery') {
    $parts = [
        $input['addrStreet'] ?? '',
        $input['addrBarangay'] ?? '',
        $input['addrCity'] ?? '',
        $input['addrProvince'] ?? ''
    ];
    $notes = trim($input['addrNotes'] ?? '');
    $deliveryAddress = implode(', ', array_filter(array_map('trim', $parts)));
    if ($notes) {
        $deliveryAddress .= ' (Notes: ' . $notes . ')';
    }
}

if (empty($customerName) || empty($customerEmail) || empty($customerPhone) || empty($items)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => 'Missing required customer or cart information.']);
    exit;
}

try {
    $pdo->beginTransaction();

    // Generate unique human-readable order number: CT-XXXXX
    $orderNumber = '';
    for ($i = 0; $i < 5; $i++) {
        $candidate = 'CT-' . mt_rand(10000, 99999);
        $check = $pdo->prepare('SELECT id FROM orders WHERE order_number = ? LIMIT 1');
        $check->execute([$candidate]);
        if (!$check->fetch()) {
            $orderNumber = $candidate;
            break;
        }
    }
    if (!$orderNumber) {
        $orderNumber = 'CT-' . time();
    }

    // Calculate total
    $subtotal = 0.00;
    foreach ($items as $item) {
        $qty = max(1, (int)($item['qty'] ?? 1));
        $price = (float)($item['price'] ?? 0);
        $subtotal += ($price * $qty);
    }

    $userId = $_SESSION['user_id'] ?? null;

    $orderStmt = $pdo->prepare('
        INSERT INTO orders (
            order_number, user_id, customer_name, customer_email, customer_phone,
            fulfillment, delivery_address, payment_method, total_amount, status
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, "pending")
    ');
    $orderStmt->execute([
        $orderNumber,
        $userId,
        $customerName,
        $customerEmail,
        $customerPhone,
        $fulfillment,
        $deliveryAddress ?: null,
        $paymentMethod,
        $subtotal
    ]);

    $orderId = (int)$pdo->lastInsertId();

    // Insert order items & decrement stock
    $itemStmt = $pdo->prepare('
        INSERT INTO order_items (order_id, variant_id, product_name, variant_info, price, qty, line_total)
        VALUES (?, ?, ?, ?, ?, ?, ?)
    ');

    $stockStmt = $pdo->prepare('
        UPDATE product_variants SET stock = GREATEST(0, stock - ?) WHERE id = ?
    ');

    foreach ($items as $item) {
        $qty = max(1, (int)($item['qty'] ?? 1));
        $price = (float)($item['price'] ?? 0);
        $lineTotal = $price * $qty;
        $variantId = $item['id'] ?? null;
        $productName = $item['name'] ?? 'Product';
        $variantInfo = trim(($item['variant'] ?? '') . ' ' . ($item['color'] ?? ''));

        $itemStmt->execute([
            $orderId,
            $variantId,
            $productName,
            $variantInfo ?: null,
            $price,
            $qty,
            $lineTotal
        ]);

        if ($variantId) {
            $stockStmt->execute([$qty, $variantId]);
        }
    }

    $pdo->commit();

    echo json_encode([
        'success'      => true,
        'orderNumber'  => $orderNumber,
        'total'        => $subtotal,
        'customerName' => $customerName,
        'email'        => $customerEmail,
        'phone'        => $customerPhone,
        'fulfillment'  => $fulfillment === 'delivery' ? 'Local Delivery' : 'Pickup at Store',
        'payment'      => ucfirst($paymentMethod)
    ]);
} catch (Exception $e) {
    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => 'Failed to place order. ' . $e->getMessage()]);
}
