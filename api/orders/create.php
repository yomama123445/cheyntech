<?php
// api/orders/create.php
declare(strict_types=1);

class OrderException extends Exception {
    public function getUserMessage(): string {
        return $this->message;
    }
}

require_once __DIR__ . '/../../includes/session.php';

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

require_once __DIR__ . '/../../config/database.php';

$input = json_decode(file_get_contents('php://input'), true);
if (!is_array($input)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => 'Invalid JSON body.']);
    exit;
}

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

if (count($items) > 20) {
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => 'Order cannot exceed 20 unique items.']);
    exit;
}

try {
    $pdo->beginTransaction();

    // Generate cryptographically secure unique order number: CT-XXXXX
    $orderNumber = '';
    for ($i = 0; $i < 5; $i++) {
        $candidate = 'CT-' . random_int(10000, 99999);
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

    // Server-side lookup query with row locking for prices and stock validation
    $priceStmt = $pdo->prepare('
        SELECT pv.price, pv.stock, pv.storage, pv.color, p.name AS product_name 
        FROM product_variants pv 
        JOIN products p ON pv.product_id = p.id 
        WHERE pv.id = ? 
        LIMIT 1 
        FOR UPDATE
    ');

    $processedItems = [];
    $subtotal = 0.00;

    foreach ($items as $item) {
        $qty = min(10, max(1, (int)($item['qty'] ?? 1)));
        $variantId = $item['id'] ?? '';

        $priceStmt->execute([$variantId]);
        $variant = $priceStmt->fetch();
        if (!$variant) {
            http_response_code(400);
            throw new OrderException("Product variant {$variantId} no longer exists.");
        }
        if ($variant['stock'] < $qty) {
            http_response_code(409);
            throw new OrderException("Insufficient stock for {$variant['product_name']}.");
        }

        $unitPrice = (float)$variant['price'];
        $lineTotal = $unitPrice * $qty;
        $subtotal += $lineTotal;

        $productName = $variant['product_name'] ?? 'Product';
        $variantInfo = trim(($variant['storage'] ?? '') . ' ' . ($variant['color'] ?? ''));

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

    // Insert order items & safely decrement stock guarded against overselling
    $itemStmt = $pdo->prepare('
        INSERT INTO order_items (order_id, variant_id, product_name, variant_info, price, qty, line_total)
        VALUES (?, ?, ?, ?, ?, ?, ?)
    ');

    $stockStmt = $pdo->prepare('
        UPDATE product_variants SET stock = stock - ? WHERE id = ? AND stock >= ?
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

        $stockStmt->execute([$pItem['qty'], $pItem['variantId'], $pItem['qty']]);
        if ($stockStmt->rowCount() === 0) {
            http_response_code(409);
            throw new OrderException("Insufficient stock for {$pItem['productName']}.");
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
} catch (OrderException $e) {
    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }
    error_log($e->getMessage());
    if (http_response_code() === 200) {
        http_response_code(400);
    }
    echo json_encode(['success' => false, 'error' => $e->getUserMessage()]);
} catch (Exception $e) {
    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }
    error_log($e->getMessage());
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => 'Failed to place order. Please try again later.']);
}
