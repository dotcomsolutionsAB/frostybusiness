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

if (!isset($_GET['id'])) {
    die("Product ID not specified.");
}

$productId = $_GET['id'];

// Fetch product and image ID
$stmt = $pdo->prepare("SELECT image_id FROM products WHERE id = :id");
$stmt->execute(['id' => $productId]);
$product = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$product) {
    die("Product not found.");
}

$imageId = $product['image_id'];

// If an image exists, delete it from the uploads table and the directory
if ($imageId && $imageId != 0) {
    $stmt = $pdo->prepare("SELECT path FROM uploads WHERE id = :id");
    $stmt->execute(['id' => $imageId]);
    $upload = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($upload) {
        $filePath = $upload['path'];
        if (file_exists($filePath)) {
            unlink($filePath);
        }

        // Delete from uploads table
        $stmt = $pdo->prepare("DELETE FROM uploads WHERE id = :id");
        $stmt->execute(['id' => $imageId]);
    }
}

// Delete the product from the products table
$stmt = $pdo->prepare("DELETE FROM products WHERE id = :id");
$stmt->execute(['id' => $productId]);

header("Location: index.php");
exit;
?>
