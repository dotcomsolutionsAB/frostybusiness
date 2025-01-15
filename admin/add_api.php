<?php
// Database configuration
$host = 'localhost';
$dbname = 'frostybusiness';
$username = 'frostybusiness';
$password = '1y5D^dn09';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

$sql = "SELECT * FROM google_sheet WHERE status = 0";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$sheets = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (empty($sheets)) {
    die("Sheets are not fetched due to invalid status.");
}

$response = [
    'products_inserted' => 0,
    'products_updated' => 0,
    'variations_inserted' => 0,
    'variations_updated' => 0,
    'categories_inserted' => [],
    'total_products' => 0,
    'total_categories' => 0,
    'total_variations' => 0,
];

foreach ($sheets as $sheet) {
    $sheetId = $sheet['id'];
    $sheetPath = $sheet['path'];

    $sheetData = file_get_contents($sheetPath);
    if ($sheetData === false) {
        file_put_contents('log.txt', "Failed to fetch data from $sheetPath\n", FILE_APPEND);
        continue;
    }

    $rows = [];
    $lines = explode("\n", $sheetData);
    $headers = str_getcsv(array_shift($lines));
    foreach ($lines as $line) {
        $row = str_getcsv($line);
        if ($row && count($row) === count($headers)) {
            $rows[] = array_combine($headers, $row);
        }
    }

    // Cache categories for performance
    $categoryCache = [];

    foreach ($rows as $row) {
        $categoryName = trim($row['Category'] ?? '');
        $model = trim($row['Model'] ?? '');
        $name = trim($row['Name'] ?? '');

        if (!$categoryName || !$model || !$name) {
            file_put_contents('log.txt', "Skipping row with missing data: " . json_encode($row) . "\n", FILE_APPEND);
            continue;
        }

        // Fetch or insert category
        if (!isset($categoryCache[$categoryName])) {
            $stmt = $pdo->prepare("SELECT id FROM categories WHERE name = :name");
            $stmt->execute(['name' => $categoryName]);
            $category = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$category) {
                $stmt = $pdo->prepare("INSERT INTO categories (name) VALUES (:name)");
                $stmt->execute(['name' => $categoryName]);
                $categoryCache[$categoryName] = $pdo->lastInsertId();
                $response['categories_inserted'][] = $categoryName;
            } else {
                $categoryCache[$categoryName] = $category['id'];
            }
        }
        $categoryId = $categoryCache[$categoryName];

        // Check if a product with the same name already exists
        $stmt = $pdo->prepare("SELECT * FROM products WHERE name = :name");
        $stmt->execute(['name' => $name]);
        $existingProduct = $stmt->fetch(PDO::FETCH_ASSOC);

        $features = generateHtmlList($row, 'Feature');
        $details = generateHtmlTable($row, '_');

        if (!$existingProduct) {
            // Insert product into `products` table
            $stmt = $pdo->prepare("INSERT INTO products (model, name, category_id, sheet_id, image_id, features, details, created_at, updated_at) 
                                   VALUES (:model, :name, :category_id, :sheet_id, :image_id, :features, :details, NOW(), NOW())");
            $stmt->execute([
                'model' => $model,
                'name' => $name,
                'category_id' => $categoryId,
                'sheet_id' => $sheetId,
                'image_id' => 0,
                'features' => $features,
                'details' => $details,
            ]);
            $productId = $pdo->lastInsertId();
            $response['products_inserted']++;
        } else {
            // Update product if data has changed
            $productId = $existingProduct['id'];
            $updateFields = [];
            $updateParams = [
                'id' => $productId
            ];

            if ($existingProduct['model'] !== $model) {
                $updateFields[] = "model = :model";
                $updateParams['model'] = $model;
            }

            if ($existingProduct['features'] !== $features) {
                $updateFields[] = "features = :features";
                $updateParams['features'] = $features;
            }

            if ($existingProduct['details'] !== $details) {
                $updateFields[] = "details = :details";
                $updateParams['details'] = $details;
            }

            if (!empty($updateFields)) {
                $sql = "UPDATE products SET " . implode(", ", $updateFields) . ", updated_at = NOW() WHERE id = :id";
                $stmt = $pdo->prepare($sql);
                $stmt->execute($updateParams);
                $response['products_updated']++;
            }
        }

        // Check if variation exists
        $stmt = $pdo->prepare("SELECT * FROM variations WHERE model_id = :model_id AND product_id = :product_id");
        $stmt->execute([
            'model_id' => $model,
            'product_id' => $productId,
        ]);
        $existingVariation = $stmt->fetch(PDO::FETCH_ASSOC);

        $detailsData = generateHtmlTable($row, '_');
        $featuresData = generateHtmlList($row, 'Feature');

        if (!$existingVariation) {
            // Insert new variation
            $stmt = $pdo->prepare("INSERT INTO variations (name, product_id, model_id, detail_data, features_data, created_at, updated_at) 
                                   VALUES (:name, :product_id, :model_id, :detail_data, :features_data, NOW(), NOW())");
            $stmt->execute([
                'name' => $name,
                'product_id' => $productId,
                'model_id' => $model,
                'detail_data' => $detailsData,
                'features_data' => $featuresData,
            ]);
            $response['variations_inserted']++;
        } else {
            // Update variation if data has changed
            $updateFields = [];
            $updateParams = [
                'id' => $existingVariation['id']
            ];

            if ($existingVariation['detail_data'] !== $detailsData) {
                $updateFields[] = "detail_data = :detail_data";
                $updateParams['detail_data'] = $detailsData;
            }

            if ($existingVariation['features_data'] !== $featuresData) {
                $updateFields[] = "features_data = :features_data";
                $updateParams['features_data'] = $featuresData;
            }

            if (!empty($updateFields)) {
                $sql = "UPDATE variations SET " . implode(", ", $updateFields) . ", updated_at = NOW() WHERE id = :id";
                $stmt = $pdo->prepare($sql);
                $stmt->execute($updateParams);
                $response['variations_updated']++;
            }
        }
    }

    // Mark sheet as processed
    $pdo->prepare("UPDATE google_sheet SET status = 1 WHERE id = :id")->execute(['id' => $sheetId]);
}

$response['total_products'] = $pdo->query("SELECT COUNT(*) FROM products")->fetchColumn();
$response['total_categories'] = $pdo->query("SELECT COUNT(*) FROM categories")->fetchColumn();
$response['total_variations'] = $pdo->query("SELECT COUNT(*) FROM variations")->fetchColumn();

header('Content-Type: application/json');
echo json_encode($response);

function generateHtmlTable($row, $prefix) {
    $html = '<table>';
    foreach ($row as $key => $value) {
        if (strpos($key, $prefix) === 0) {
            $html .= "<tr><td>$key</td><td>$value</td></tr>";
        }
    }
    $html .= '</table>';
    return $html;
}

function generateHtmlList($row, $prefix) {
    $html = '<ul>';
    foreach ($row as $key => $value) {
        if (strpos($key, $prefix) === 0) {
            $html .= "<li>$key: $value</li>";
        }
    }
    $html .= '</ul>';
    return $html;
}
?>
