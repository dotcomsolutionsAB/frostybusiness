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

$name = $_POST['name'];
$model = $_POST['model'];
$category_id = $_POST['category_id'];
$new_category_name = $_POST['new_category_name'] ?? '';
$sheet_id = $_POST['sheet_id'] ?? 0;
$image_id = $_POST['image_id'] ?? 0;
$features = $_POST['features'];
$details = $_POST['details'] ?: '';

// Handle "Other" category option
if ($category_id === 'other' && !empty($new_category_name)) {
    $sql = "INSERT INTO categories (name, created_at, updated_at) VALUES (?, NOW(), NOW())";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$new_category_name]);
    $category_id = $pdo->lastInsertId();
}

// Check if product exists
$sql = "SELECT id FROM products WHERE name = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$name]);
$product = $stmt->fetch();

if ($product) {
    // Save as variation
    $sql = "INSERT INTO variations (model_id, name, product_id, detail_data, features_data, created_at, updated_at)
            VALUES (?, ?, ?, ?, ?, NOW(), NOW())";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$model, $name, $product['id'], $details, $features]);
} else {
    // Save as new product
    $sql = "INSERT INTO products (model, name, category_id, sheet_id, image_id, features, details, created_at, updated_at)
            VALUES (?, ?, ?, ?, ?, ?, ?, NOW(), NOW())";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$model, $name, $category_id, $sheet_id, $image_id, $features, $details]);
}

echo json_encode(['success' => true]);

?>
