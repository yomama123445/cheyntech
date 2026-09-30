<?php
// api/products/get.php
declare(strict_types=1);

header('Content-Type: application/json');
header('Cache-Control: no-cache, no-store, must-revalidate');

require_once __DIR__ . '/../../config/database.php';

/**
 * Format flat SQL product + variant joined rows into structured product entities
 * with nested storageOptions, colorOptions, variants, specs, and gallery.
 */
function formatProductRows(array $rows): array {
    $products = [];
    $storageSeen = [];
    $colorSeen = [];

    foreach ($rows as $row) {
        $pid = (string)$row['id'];
        if (!isset($products[$pid])) {
            $badgeClass = !empty($row['badge_class']) ? (string)$row['badge_class'] : 'badge-preowned';
            $condition  = !empty($row['condition']) ? (string)$row['condition'] : 'Pre-owned';

            $badgeLabel = $condition;
            if ($badgeClass === 'badge-refurbished') {
                $badgeLabel = 'Refurbished';
            } elseif ($badgeClass === 'badge-available') {
                $badgeLabel = 'Brand New';
            } elseif ($badgeClass === 'badge-preowned') {
                $badgeLabel = 'Pre-owned';
            }

            $specs = [];
            if (!empty($row['specs_json'])) {
                $decoded = json_decode((string)$row['specs_json'], true);
                if (is_array($decoded)) {
                    $specs = $decoded;
                }
            }
            if (!isset($specs['Condition']) && !empty($condition)) {
                $specs['Condition'] = $condition;
            }

            $mainImage = !empty($row['main_image']) ? (string)$row['main_image'] : '/assets/products/placeholder.jpg';

            $products[$pid] = [
                'id'             => $row['id'],
                'name'           => $row['name'],
                'category'       => $row['category'] ?? '',
                'condition'      => $condition,
                'badge'          => $badgeClass,
                'badgeLabel'     => $badgeLabel,
                'desc'           => $row['short_desc'] ?: '',
                'fullDesc'       => $row['full_desc'] ?: ($row['short_desc'] ?: ''),
                'image'          => $mainImage,
                'date'           => !empty($row['created_at']) ? strtotime((string)$row['created_at']) : 0,
                'specs'          => $specs,
                'gallery'        => [
                    [
                        'src'   => $mainImage,
                        'thumb' => $mainImage,
                        'alt'   => $row['name']
                    ]
                ],
                'storageOptions' => [],
                'colorOptions'   => [],
                'variants'       => []
            ];
            $storageSeen[$pid] = [];
            $colorSeen[$pid]   = [];
        }

        if (!empty($row['variant_id'])) {
            $variantId    = (string)$row['variant_id'];
            $storageLabel = !empty($row['storage']) ? (string)$row['storage'] : 'Standard';
            $colorLabel   = !empty($row['color']) ? (string)$row['color'] : 'Default';
            $colorHex     = !empty($row['color_hex']) ? (string)$row['color_hex'] : '#000000';
            $price        = (float)$row['price'];
            $stock        = (int)$row['stock'];

            $products[$pid]['variants'][] = [
                'id'        => $variantId,
                'storage'   => $storageLabel,
                'color'     => $colorLabel,
                'color_hex' => $colorHex,
                'price'     => $price,
                'stock'     => $stock
            ];

            // Unique storage options list
            if (!isset($storageSeen[$pid][$storageLabel])) {
                $storageSeen[$pid][$storageLabel] = true;
                $products[$pid]['storageOptions'][] = [
                    'label' => $storageLabel,
                    'price' => $price,
                    'id'    => $variantId,
                    'stock' => $stock
                ];
            }

            // Unique color options list
            if (!isset($colorSeen[$pid][$colorLabel])) {
                $colorSeen[$pid][$colorLabel] = true;
                $isLight = in_array(strtolower($colorHex), ['#ffffff', '#fff', '#f5f5f7', '#f0ede8', '#e2e2e4', '#fafafa'], true);
                $products[$pid]['colorOptions'][] = [
                    'label'  => $colorLabel,
                    'hex'    => $colorHex,
                    'border' => $isLight ? '#cccccc' : ''
                ];
            }
        }
    }

    // Ensure fallback storage/color option if product has no variants in DB
    foreach ($products as $pid => &$prod) {
        if (empty($prod['storageOptions'])) {
            $prod['storageOptions'][] = [
                'label' => 'Standard',
                'price' => 0.0,
                'id'    => $prod['id'],
                'stock' => 0
            ];
        }
        if (empty($prod['colorOptions'])) {
            $prod['colorOptions'][] = [
                'label'  => 'Standard',
                'hex'    => '#000000',
                'border' => ''
            ];
        }
    }
    unset($prod);

    return array_values($products);
}

$productId = isset($_GET['id']) ? trim((string)$_GET['id']) : '';

try {
    if (!empty($productId)) {
        $stmt = $pdo->prepare('
            SELECT 
                p.id,
                p.name,
                p.category,
                p.condition,
                p.badge_class,
                p.short_desc,
                p.full_desc,
                p.main_image,
                p.specs_json,
                p.created_at,
                pv.id AS variant_id,
                pv.storage,
                pv.color,
                pv.color_hex,
                pv.price,
                pv.stock
            FROM products p
            LEFT JOIN product_variants pv ON p.id = pv.product_id
            WHERE p.id = ?
            ORDER BY pv.price ASC, pv.storage ASC
        ');
        $stmt->execute([$productId]);
        $rows = $stmt->fetchAll();

        if (empty($rows)) {
            http_response_code(404);
            echo json_encode([
                'success' => false,
                'error'   => 'Product not found.'
            ]);
            exit;
        }

        $formatted = formatProductRows($rows);
        $product   = $formatted[0] ?? null;

        if (!$product) {
            http_response_code(404);
            echo json_encode([
                'success' => false,
                'error'   => 'Product not found.'
            ]);
            exit;
        }

        echo json_encode([
            'success' => true,
            'product' => $product
        ]);
        exit;
    }

    // Query all active products
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
            p.specs_json,
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

    $products = formatProductRows($rows);

    echo json_encode([
        'success'  => true,
        'count'    => count($products),
        'products' => $products
    ]);
    exit;

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error'   => 'Database error: ' . $e->getMessage()
    ]);
    exit;
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error'   => $e->getMessage()
    ]);
    exit;
}
