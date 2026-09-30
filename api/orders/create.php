<?php
// api/orders/create.php
declare(strict_types=1);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'error' => 'Method not allowed']);
    exit;
}

$clientCsrf  = $_SERVER['HTTP_X_CSRF_TOKEN'] ?? '';
$sessionCsrf = $_SESSION['csrf_token'] ?? '';
if (empty($sessionCsrf) || !hash_equals($sessionCsrf, $clientCsrf)) {
    http_response_code(403);
    echo json_encode(['success' => false, 'error' => 'Invalid or missing CSRF token.']);
    exit;
}

require_once '../../config/database.php';

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

    // Server-side lookup query for prices and stock validation
    $priceStmt = $pdo->prepare('SELECT price, stock, product_id FROM product_variants WHERE id = ? LIMIT 1');

    $processedItems = [];
    $subtotal = 0.00;

    foreach ($items as $item) {
        $qty = max(1, (int)($item['qty'] ?? 1));
        $variantId = $item['id'] ?? '';

        $priceStmt->execute([$variantId]);
        $variant = $priceStmt->fetch();
        if (!$variant) {
            throw new Exception("Product variant {$variantId} no longer exists.");
        }
        if ($variant['stock'] < $qty) {
            throw new Exception("Insufficient stock for variant {$variantId}.");
        }

        $unitPrice = (float)$variant['price'];
        $lineTotal = $unitPrice * $qty;
        $subtotal += $lineTotal;

        $productName = $item['name'] ?? 'Product';
        $variantInfo = trim(($item['variant'] ?? '') . ' ' . ($item['color'] ?? ''));

        $processedItems[] = [
            'variantId'   => $variantId,
            'productName' => $productName,
            'variantInfo' => $variantInfo ?: null,
            'unitPrice'   => $unitPrice,
            'qty'         => $qty,
            'lineTotal'   => $lineTotal,
        ];
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

    // Insert order items & decrement stock using server-calculated prices
    $itemStmt = $pdo->prepare('
        INSERT INTO order_items (order_id, variant_id, product_name, variant_info, price, qty, line_total)
        VALUES (?, ?, ?, ?, ?, ?, ?)
    ');

    $stockStmt = $pdo->prepare('
        UPDATE product_variants SET stock = GREATEST(0, stock - ?) WHERE id = ?
    ');

    foreach ($processedItems as $pItem) {
        $itemStmt->execute([
            $orderId,
            $pItem['variantId'],
            $pItem['productName'],
            $pItem['variantInfo'],
            $pItem['unitPrice'],
            $pItem['qty'],
            $pItem['lineTotal']
        ]);

        $stockStmt->execute([$pItem['qty'], $pItem['variantId']]);
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
