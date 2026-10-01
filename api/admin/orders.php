<?php
// api/admin/orders.php
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

// Handle GET: Returns real orders with customer details and line items
if ($method === 'GET') {
    try {
        $ordersStmt = $pdo->query('
            SELECT o.id, o.order_number, o.customer_name, o.customer_email, o.customer_phone,
                   o.fulfillment, o.delivery_address, o.delivery_fee, o.payment_method,
                   o.total_amount, o.status, o.notes, o.created_at, o.updated_at
            FROM orders o
            ORDER BY o.created_at DESC
        ');
        $ordersRows = $ordersStmt->fetchAll();

        $itemsStmt = $pdo->query('
            SELECT oi.id, oi.order_id, oi.variant_id, oi.product_name, oi.variant_info,
                   oi.price, oi.qty, oi.line_total
            FROM order_items oi
            ORDER BY oi.id ASC
        ');
        $itemsRows = $itemsStmt->fetchAll();

        $itemsByOrderId = [];
        foreach ($itemsRows as $item) {
            $name = $item['product_name'];
            if (!empty($item['variant_info'])) {
                $name .= ' (' . $item['variant_info'] . ')';
            }
            $itemsByOrderId[$item['order_id']][] = [
                'id'        => $item['variant_id'],
                'name'      => $name,
                'qty'       => (int)$item['qty'],
                'price'     => (float)$item['price'],
                'lineTotal' => (float)$item['line_total']
            ];
        }

        $statusLabelMap = [
            'pending'          => 'Pending',
            'processing'       => 'Processing',
            'ready_pickup'     => 'Ready for Pickup',
            'out_for_delivery' => 'Out for Delivery',
            'completed'        => 'Completed',
            'cancelled'        => 'Cancelled'
        ];

        $paymentLabelMap = [
            'cash'  => 'Cash',
            'gcash' => 'GCash',
            'bank'  => 'Bank Transfer'
        ];

        $orders = [];
        foreach ($ordersRows as $row) {
            $statusLabel = $statusLabelMap[$row['status']] ?? ucfirst((string)$row['status']);
            $orderNumber = !empty($row['order_number']) ? $row['order_number'] : ('CT-' . str_pad((string)$row['id'], 4, '0', STR_PAD_LEFT));
            $items       = $itemsByOrderId[$row['id']] ?? [];

            $fulfillmentLabel = ($row['fulfillment'] === 'delivery') ? 'Delivery' : 'Pickup';
            $paymentLabel     = $paymentLabelMap[$row['payment_method']] ?? ucfirst((string)$row['payment_method']);
            $paid             = in_array($row['status'], ['completed'], true) || in_array($row['payment_method'], ['gcash', 'bank'], true);

            $dateFormatted     = date('Y-m-d', strtotime((string)$row['created_at']));
            $dateTimeFormatted = date('Y-m-d H:i', strtotime((string)$row['created_at']));
            $updatedFormatted  = date('Y-m-d H:i', strtotime((string)$row['updated_at']));

            $history = [
                [
                    'date'   => $dateTimeFormatted,
                    'status' => 'Pending',
                    'note'   => 'Order placed by customer.'
                ]
            ];
            if ($statusLabel !== 'Pending') {
                $history[] = [
                    'date'   => $updatedFormatted,
                    'status' => $statusLabel,
                    'note'   => 'Status updated to ' . $statusLabel . '.'
                ];
            }

            $orders[] = [
                'id'          => $orderNumber,
                'order_id'    => (int)$row['id'],
                'date'        => $dateFormatted,
                'status'      => $statusLabel,
                'raw_status'  => $row['status'],
                'customer'    => [
                    'name'    => $row['customer_name'] ?? 'Customer',
                    'email'   => $row['customer_email'] ?? '',
                    'phone'   => $row['customer_phone'] ?? '',
                    'address' => $row['delivery_address'] ?? 'Store Pickup'
                ],
                'items'       => $items,
                'fulfillment' => $fulfillmentLabel,
                'payment'     => $paymentLabel,
                'paid'        => $paid,
                'total'       => (float)$row['total_amount'],
                'history'     => $history
            ];
        }

        if (isset($_GET['export']) && $_GET['export'] === 'csv') {
            $today = date('Y-m-d');
            header('Content-Type: text/csv; charset=utf-8');
            header('Content-Disposition: attachment; filename="cheyn-gadgets-orders-' . $today . '.csv"');
            $output = fopen('php://output', 'w');
            fputcsv($output, ['Order Number', 'Date', 'Customer Name', 'Phone', 'Total Amount', 'Fulfillment', 'Payment', 'Status']);
            foreach ($orders as $o) {
                fputcsv($output, [
                    $o['id'],
                    $o['date'],
                    $o['customer']['name'] ?? '',
                    $o['customer']['phone'] ?? '',
                    number_format((float)$o['total'], 2, '.', ''),
                    $o['fulfillment'],
                    $o['payment'],
                    $o['status']
                ]);
            }
            fclose($output);
            exit;
        }

        echo json_encode([
            'success' => true,
            'count'   => count($orders),
            'orders'  => $orders
        ]);
        exit;

    } catch (Exception $e) {
        error_log('Orders GET error: ' . $e->getMessage());
        http_response_code(500);
        echo json_encode(['success' => false, 'error' => 'Failed to load orders.']);
        exit;
    }
}

// Handle POST / PATCH / PUT: Updates order status
if ($method === 'POST' || $method === 'PATCH' || $method === 'PUT') {
    $input = json_decode(file_get_contents('php://input'), true);
    if (!is_array($input)) {
        $input = $_POST;
    }

    $orderIdentifier = trim((string)($input['id'] ?? $input['order_id'] ?? $input['order_number'] ?? ''));
    $newStatus       = trim((string)($input['status'] ?? ''));

    if (empty($orderIdentifier) || empty($newStatus)) {
        http_response_code(400);
        echo json_encode(['success' => false, 'error' => 'Missing order ID or status.']);
        exit;
    }

    $statusEnumMap = [
        'pending'          => 'pending',
        'processing'       => 'processing',
        'ready for pickup' => 'ready_pickup',
        'ready_pickup'     => 'ready_pickup',
        'ready'            => 'ready_pickup',
        'out for delivery' => 'out_for_delivery',
        'out_for_delivery' => 'out_for_delivery',
        'completed'        => 'completed',
        'cancelled'        => 'cancelled'
    ];

    $normalized = $statusEnumMap[strtolower($newStatus)] ?? null;
    if (!$normalized) {
        http_response_code(400);
        echo json_encode(['success' => false, 'error' => 'Invalid order status: ' . $newStatus]);
        exit;
    }

    try {
        $pdo->beginTransaction();

        $findStmt = $pdo->prepare('SELECT id, order_number, status FROM orders WHERE order_number = ? OR id = ? LIMIT 1 FOR UPDATE');
        $findStmt->execute([$orderIdentifier, is_numeric($orderIdentifier) ? (int)$orderIdentifier : 0]);
        $order = $findStmt->fetch();

        if (!$order) {
            $pdo->rollBack();
            http_response_code(404);
            echo json_encode(['success' => false, 'error' => 'Order not found.']);
            exit;
        }

        $previousStatus = (string)$order['status'];

        $updateStmt = $pdo->prepare('UPDATE orders SET status = ?, updated_at = CURRENT_TIMESTAMP WHERE id = ?');
        $updateStmt->execute([$normalized, $order['id']]);

        // TASK B3: When status changes to cancelled from any non-cancelled state, restore variant stock
        if ($normalized === 'cancelled' && $previousStatus !== 'cancelled') {
            $itemsStmt = $pdo->prepare('SELECT variant_id, qty FROM order_items WHERE order_id = ?');
            $itemsStmt->execute([$order['id']]);
            $orderItems = $itemsStmt->fetchAll();

            $restockStmt = $pdo->prepare('UPDATE product_variants SET stock = stock + ? WHERE id = ?');
            foreach ($orderItems as $item) {
                if (!empty($item['variant_id']) && (int)$item['qty'] > 0) {
                    $restockStmt->execute([(int)$item['qty'], $item['variant_id']]);
                }
            }
        }

        $pdo->commit();

        $statusLabelMap = [
            'pending'          => 'Pending',
            'processing'       => 'Processing',
            'ready_pickup'     => 'Ready for Pickup',
            'out_for_delivery' => 'Out for Delivery',
            'completed'        => 'Completed',
            'cancelled'        => 'Cancelled'
        ];

        echo json_encode([
            'success'      => true,
            'message'      => 'Order status updated successfully.',
            'order_id'     => $order['id'],
            'order_number' => $order['order_number'],
            'status'       => $statusLabelMap[$normalized],
            'raw_status'   => $normalized
        ]);
        exit;

    } catch (Exception $e) {
        if ($pdo->inTransaction()) {
            $pdo->rollBack();
        }
        error_log('Order status update error: ' . $e->getMessage());
        http_response_code(500);
        echo json_encode(['success' => false, 'error' => 'Failed to update order status.']);
        exit;
    }
}

http_response_code(405);
echo json_encode(['success' => false, 'error' => 'Method not allowed.']);
