<?php
// api/admin/products.php
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

// Helper to normalize category to DB enum ('preowned', 'new', 'android', 'tablet')
function mapCategoryToEnum(string $cat, string $cond): string {
    $c = strtolower(trim($cat));
    if (in_array($c, ['preowned', 'new', 'android', 'tablet'], true)) {
        return $c;
    }
    if ($c === 'tablet' || strpos($c, 'ipad') !== false) {
        return 'tablet';
    }
    if ($c === 'iphone') {
        return ($cond === 'Brand New') ? 'new' : 'preowned';
    }
    return 'android';
}

// -------------------------------------------------------------
// GET: List products for admin table / management
// -------------------------------------------------------------
if ($method === 'GET') {
    try {
        $stmt = $pdo->query('
            SELECT 
                p.id,
                p.name,
                p.category,
                p.condition,
                p.badge_class,
                p.short_desc,
                p.full_desc,
                p.main_image,
                p.created_at,
                pv.id AS variant_id,
                pv.storage,
                pv.color,
                pv.color_hex,
                pv.price,
                pv.stock
            FROM products p
            LEFT JOIN product_variants pv ON p.id = pv.product_id
            ORDER BY p.created_at DESC, pv.price ASC
        ');
        $rows = $stmt->fetchAll();

        $products = [];
        foreach ($rows as $row) {
            $pid = (string)$row['id'];
            if (!isset($products[$pid])) {
                $categoryLabel = ucfirst($row['category']);
                if ($row['category'] === 'preowned') $categoryLabel = 'iPhone';
                if ($row['category'] === 'new')      $categoryLabel = 'iPhone';
                if ($row['category'] === 'tablet')   $categoryLabel = 'Tablet';
                if ($row['category'] === 'android')  $categoryLabel = 'Android';

                $products[$pid] = [
                    'id'          => $pid,
                    'name'        => $row['name'],
                    'category'    => $categoryLabel,
                    'rawCategory' => $row['category'],
                    'condition'   => $row['condition'] ?: 'Pre-owned',
                    'storage'     => $row['storage'] ?: 'N/A',
                    'color'       => $row['color'] ?: 'Default',
                    'price'       => (float)($row['price'] ?? 0),
                    'stock'       => (int)($row['stock'] ?? 0),
                    'status'      => ((int)($row['stock'] ?? 0) === 0) ? 'Out of Stock' : (((int)($row['stock'] ?? 0) <= 3) ? 'Low Stock' : 'Available'),
                    'img'         => $row['main_image'] ?: '/assets/products/placeholder.jpg',
                    'description' => $row['full_desc'] ?: ($row['short_desc'] ?: ''),
                    'variant_id'  => $row['variant_id'] ?: $pid
                ];
            }
        }

        echo json_encode([
            'success'  => true,
            'count'    => count($products),
            'products' => array_values($products)
        ]);
        exit;

    } catch (Exception $e) {
        error_log('Admin products GET error: ' . $e->getMessage());
        http_response_code(500);
        echo json_encode(['success' => false, 'error' => 'Failed to load products.']);
        exit;
    }
}

// -------------------------------------------------------------
// POST: Create product and initial variant
// -------------------------------------------------------------
if ($method === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    if (!is_array($input)) {
        $input = $_POST;
    }

    $name      = trim((string)($input['name'] ?? ''));
    $category  = trim((string)($input['category'] ?? 'Android'));
    $condition = trim((string)($input['condition'] ?? 'Pre-owned'));
    $storage   = trim((string)($input['storage'] ?? 'N/A'));
    $color     = trim((string)($input['color'] ?? 'Default'));
    $price     = (float)($input['price'] ?? 0);
    $stock     = (int)($input['stock'] ?? 1);
    $desc      = trim((string)($input['description'] ?? ''));
    $image     = trim((string)($input['img'] ?? $input['image'] ?? '/assets/products/placeholder.jpg'));

    if (empty($name) || $price <= 0) {
        http_response_code(400);
        echo json_encode(['success' => false, 'error' => 'Product name and valid price are required.']);
        exit;
    }

    $dbCategory = mapCategoryToEnum($category, $condition);
    $badgeClass = ($condition === 'Refurbished') ? 'badge-refurbished' : (($condition === 'Pre-owned') ? 'badge-preowned' : 'badge-available');

    // Generate unique product and variant identifiers
    $cleanSlug  = strtolower((string)preg_replace('/[^a-zA-Z0-9]+/', '', $name));
    if (empty($cleanSlug)) {
        $cleanSlug = 'product';
    }
    $productId  = substr($cleanSlug, 0, 20) . '-' . substr(bin2hex(random_bytes(3)), 0, 5);

    $cleanStorage = strtolower((string)preg_replace('/[^a-zA-Z0-9]+/', '', $storage));
    $cleanColor   = strtolower((string)preg_replace('/[^a-zA-Z0-9]+/', '', $color));
    $variantId    = $productId . '-' . ($cleanStorage ?: 'std') . '-' . ($cleanColor ?: 'def');

    try {
        $pdo->beginTransaction();

        $prodStmt = $pdo->prepare('
            INSERT INTO products (id, name, category, `condition`, badge_class, short_desc, full_desc, main_image, specs_json)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
        ');
        $specsJson = json_encode(['Condition' => $condition]);
        $prodStmt->execute([
            $productId,
            $name,
            $dbCategory,
            $condition,
            $badgeClass,
            $desc,
            $desc,
            $image,
            $specsJson
        ]);

        $varStmt = $pdo->prepare('
            INSERT INTO product_variants (id, product_id, storage, color, color_hex, price, stock)
            VALUES (?, ?, ?, ?, ?, ?, ?)
        ');
        $varStmt->execute([
            $variantId,
            $productId,
            $storage,
            $color,
            '#4a4a4a',
            $price,
            $stock
        ]);

        $pdo->commit();

        echo json_encode([
            'success'    => true,
            'message'    => 'Product created successfully.',
            'product_id' => $productId,
            'variant_id' => $variantId
        ]);
        exit;

    } catch (Exception $e) {
        if ($pdo->inTransaction()) {
            $pdo->rollBack();
        }
        error_log('Admin product create error: ' . $e->getMessage());
        http_response_code(500);
        echo json_encode(['success' => false, 'error' => 'Failed to create product.']);
        exit;
    }
}

// -------------------------------------------------------------
// PUT: Edit product and variant stock / price / specs
// -------------------------------------------------------------
if ($method === 'PUT') {
    $input = json_decode(file_get_contents('php://input'), true);
    if (!is_array($input)) {
        http_response_code(400);
        echo json_encode(['success' => false, 'error' => 'Invalid JSON payload.']);
        exit;
    }

    $id        = trim((string)($input['id'] ?? ''));
    $price     = isset($input['price']) ? (float)$input['price'] : null;
    $stock     = isset($input['stock']) ? (int)$input['stock'] : null;
    $name      = isset($input['name']) ? trim((string)$input['name']) : null;
    $condition = isset($input['condition']) ? trim((string)$input['condition']) : null;
    $storage   = isset($input['storage']) ? trim((string)$input['storage']) : null;
    $color     = isset($input['color']) ? trim((string)$input['color']) : null;
    $desc      = isset($input['description']) ? trim((string)$input['description']) : null;

    if (empty($id)) {
        http_response_code(400);
        echo json_encode(['success' => false, 'error' => 'Product ID is required for editing.']);
        exit;
    }

    try {
        $pdo->beginTransaction();

        // 1. Update product_variants (by product_id or variant id)
        if ($price !== null || $stock !== null || $storage !== null || $color !== null) {
            $fields = [];
            $params = [];

            if ($price !== null) {
                $fields[] = 'price = ?';
                $params[] = $price;
            }
            if ($stock !== null) {
                $fields[] = 'stock = ?';
                $params[] = $stock;
            }
            if ($storage !== null) {
                $fields[] = 'storage = ?';
                $params[] = $storage;
            }
            if ($color !== null) {
                $fields[] = 'color = ?';
                $params[] = $color;
            }

            if (!empty($fields)) {
                $params[] = $id;
                $params[] = $id;
                $sql = 'UPDATE product_variants SET ' . implode(', ', $fields) . ' WHERE product_id = ? OR id = ?';
                $stmt = $pdo->prepare($sql);
                $stmt->execute($params);
            }
        }

        // 2. Update products table
        $prodFields = [];
        $prodParams = [];

        if ($name !== null) {
            $prodFields[] = 'name = ?';
            $prodParams[] = $name;
        }
        if ($condition !== null) {
            $prodFields[] = '`condition` = ?';
            $prodParams[] = $condition;
            $prodFields[] = 'badge_class = ?';
            $prodParams[] = ($condition === 'Refurbished') ? 'badge-refurbished' : (($condition === 'Pre-owned') ? 'badge-preowned' : 'badge-available');
        }
        if ($desc !== null) {
            $prodFields[] = 'short_desc = ?';
            $prodParams[] = $desc;
            $prodFields[] = 'full_desc = ?';
            $prodParams[] = $desc;
        }

        if (!empty($prodFields)) {
            $prodParams[] = $id;
            $sql = 'UPDATE products SET ' . implode(', ', $prodFields) . ' WHERE id = ?';
            $stmt = $pdo->prepare($sql);
            $stmt->execute($prodParams);
        }

        $pdo->commit();

        echo json_encode([
            'success' => true,
            'message' => 'Product updated successfully.'
        ]);
        exit;

    } catch (Exception $e) {
        if ($pdo->inTransaction()) {
            $pdo->rollBack();
        }
        error_log('Admin product update error: ' . $e->getMessage());
        http_response_code(500);
        echo json_encode(['success' => false, 'error' => 'Failed to update product.']);
        exit;
    }
}

// -------------------------------------------------------------
// DELETE: Archive / remove product and associated variants
// -------------------------------------------------------------
if ($method === 'DELETE') {
    $input = json_decode(file_get_contents('php://input'), true);
    $id = trim((string)($input['id'] ?? $_GET['id'] ?? ''));

    if (empty($id)) {
        http_response_code(400);
        echo json_encode(['success' => false, 'error' => 'Product ID is required for deletion.']);
        exit;
    }

    try {
        // Attempt deleting from products (cascades to product_variants)
        $stmt = $pdo->prepare('DELETE FROM products WHERE id = ?');
        $stmt->execute([$id]);

        if ($stmt->rowCount() === 0) {
            // Attempt deleting from product_variants directly
            $stmtVar = $pdo->prepare('DELETE FROM product_variants WHERE id = ?');
            $stmtVar->execute([$id]);
        }

        echo json_encode([
            'success' => true,
            'message' => 'Product archived/deleted successfully.'
        ]);
        exit;

    } catch (Exception $e) {
        error_log('Admin product delete error: ' . $e->getMessage());
        http_response_code(500);
        echo json_encode(['success' => false, 'error' => 'Failed to delete product.']);
        exit;
    }
}

http_response_code(405);
echo json_encode(['success' => false, 'error' => 'Method not allowed.']);
