<?php
// Database configuration
$host = 'localhost';
$dbname = 'frostybusiness';
$username = 'frostybusiness';
$password = '1y5D^dn09';

// Connect to the database
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Fetch rows from google_sheet table where status = 0
$sql = "SELECT * FROM google_sheet WHERE status = 0";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$sheets = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($sheets as $sheet) {
    $sheetId = $sheet['id'];
    $sheetPath = $sheet['path'];

    // Fetch data from Google Sheet URL
    $sheetData = file_get_contents($sheetPath);
    $rows = json_decode($sheetData, true); // Assuming the sheet returns JSON data

    foreach ($rows as $row) {
        $categoryName = $row['Category'];
        $model = $row['Model'];
        $name = $row['Name'];

        // Check if category exists
        $sql = "SELECT id FROM categories WHERE name = :name";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['name' => $categoryName]);
        $category = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$category) {
            // Insert new category
            $sql = "INSERT INTO categories (name) VALUES (:name)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute(['name' => $categoryName]);
            $categoryId = $pdo->lastInsertId();
        } else {
            $categoryId = $category['id'];
        }

        // Check if product model exists
        $sql = "SELECT id FROM products WHERE model = :model";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['model' => $model]);
        $product = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$product) {
            // Insert new product
            $details = generateHtmlTable($row, '_');
            $features = generateHtmlTable($row, 'Feature');

            $sql = "INSERT INTO products (model, name, category_id, sheet_id, image_id, features, details, created_at, updated_at) 
                    VALUES (:model, :name, :category_id, :sheet_id, :image_id, :features, :details, NOW(), NOW())";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                'model' => $model,
                'name' => $name,
                'category_id' => $categoryId,
                'sheet_id' => $sheetId,
                'image_id' => 0,
                'features' => $features,
                'details' => $details
            ]);
            $productId = $pdo->lastInsertId();
        } else {
            $productId = $product['id'];
        }

        // Insert variation
        $detailsData = generateHtmlTable($row, '_');
        $featuresData = generateHtmlTable($row, 'Feature');
        $sql = "INSERT INTO variations (name, product_id, detail_data, features_data, created_at, updated_at) 
                VALUES (:name, :product_id, :detail_data, :features_data, NOW(), NOW())";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            'name' => $name,
            'product_id' => $productId,
            'detail_data' => $detailsData,
            'features_data' => $featuresData
        ]);
    }

    // Update google_sheet table status to 1
    $sql = "UPDATE google_sheet SET status = 1 WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['id' => $sheetId]);
}

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

?>
