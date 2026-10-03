<?php
// api/orders/track.php
declare(strict_types=1);

header('Content-Type: application/json');
require_once __DIR__ . '/../../config/database.php';

$orderNumber   = trim((string)($_GET['id'] ?? $_GET['order_number'] ?? ''));
$customerEmail = trim((string)($_GET['email'] ?? ''));

// TASK S5: Require order number AND checkout email; same 404 message for both failures.
if (empty($orderNumber) || empty($customerEmail)) {
    http_response_code(404);
    echo json_encode(['success' => false, 'error' => 'Order not found. Please verify your Order ID and email address.']);
    exit;
}

try {
    $stmt = $pdo->prepare('
        SELECT o.id, o.order_number, o.customer_name, o.customer_email, o.fulfillment, o.payment_method,
               o.total_amount, o.status, o.created_at
        FROM orders o
        WHERE o.order_number = ? AND LOWER(o.customer_email) = LOWER(?)
        LIMIT 1
    ');
    $stmt->execute([$orderNumber, $customerEmail]);
    $order = $stmt->fetch();

    if (!$order) {
        http_response_code(404);
        echo json_encode(['success' => false, 'error' => 'Order not found. Please verify your Order ID and email address.']);
        exit;
    }

    // Fetch line items
    $itemStmt = $pdo->prepare('SELECT product_name, variant_info, price, qty, line_total FROM order_items WHERE order_id = ?');
    $itemStmt->execute([$order['id']]);
    $items = $itemStmt->fetchAll();

    // Human-readable status mapping
    $statusMap = [
        'pending'          => ['label' => 'Pending Review', 'step' => 1, 'badge' => 'badge-status-pending', 'icon' => 'bi-clock-history'],
        'processing'       => ['label' => 'Processing & Testing', 'step' => 2, 'badge' => 'badge-status-processing', 'icon' => 'bi-gear-fill'],
        'ready_pickup'     => ['label' => 'Ready for Pickup', 'step' => 3, 'badge' => 'badge-status-ready', 'icon' => 'bi-bag-check-fill'],
        'out_for_delivery' => ['label' => 'Out for Delivery', 'step' => 3, 'badge' => 'badge-status-delivery', 'icon' => 'bi-truck'],
        'completed'        => ['label' => 'Completed', 'step' => 4, 'badge' => 'badge-status-completed', 'icon' => 'bi-check-circle-fill'],
        'cancelled'        => ['label' => 'Cancelled', 'step' => 0, 'badge' => 'badge-status-cancelled', 'icon' => 'bi-x-circle-fill'],
    ];

    $statusInfo = $statusMap[$order['status']] ?? $statusMap['pending'];

    // Format product line summary
    $itemSummary = [];
    foreach ($items as $it) {
        $desc = htmlspecialchars($it['product_name']);
        if (!empty($it['variant_info'])) {
            $desc .= ' (' . htmlspecialchars($it['variant_info']) . ')';
        }
        $itemSummary[] = $desc . ' ×' . $it['qty'];
    }

    echo json_encode([
        'success'      => true,
        'orderNumber'  => $order['order_number'],
        'date'         => date('F j, Y', strtotime($order['created_at'])),
        'fulfillment'  => $order['fulfillment'] === 'delivery' ? 'Local Delivery' : 'Pickup at Cheyn Gadgets Store',
        'status'       => $order['status'],
        'statusLabel'  => $statusInfo['label'],
        'currentStep'  => $statusInfo['step'],
        'badgeClass'   => $statusInfo['badge'],
        'badgeIcon'    => $statusInfo['icon'],
        'productLine'  => implode(', ', $itemSummary),
        'total'        => (float)$order['total_amount'],
        'paymentMethod'=> $order['payment_method'],
        'items'        => $items
    ]);
} catch (Exception $e) {
    error_log('Order track error: ' . $e->getMessage());
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => 'Database error while retrieving order.']);
}
