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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $productId = $_POST['product_id'];
    $name = trim($_POST['name']);
    $model = trim($_POST['model']);
    $categoryId = $_POST['category_id'];
    $features = trim($_POST['features']);
    $details = trim($_POST['details']);
    $imageId = null;

    // Handle file upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = "../images/uploads/";
        $fileName = basename($_FILES['image']['name']);
        $filePath = $uploadDir . $fileName;
        $fileExtension = pathinfo($filePath, PATHINFO_EXTENSION);

        if (move_uploaded_file($_FILES['image']['tmp_name'], $filePath)) {
            // Insert into uploads table
            $stmt = $pdo->prepare("INSERT INTO uploads (file_original_name, path, extension, created_at, updated_at) 
                                   VALUES (:file_original_name, :path, :extension, NOW(), NOW())");
            $stmt->execute([
                'file_original_name' => $fileName,
                'path' => $filePath,
                'extension' => $fileExtension,
            ]);

            $imageId = $pdo->lastInsertId();

            // Update product's image_id
            $stmt = $pdo->prepare("UPDATE products SET image_id = :image_id WHERE id = :id");
            $stmt->execute(['image_id' => $imageId, 'id' => $productId]);
        } else {
            die("Failed to upload image.");
        }
    }

    // Update product
    $sql = "UPDATE products SET 
                name = :name, 
                model = :model, 
                category_id = :category_id, 
                features = :features, 
                details = :details, 
                updated_at = NOW() 
            WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        'name' => $name,
        'model' => $model,
        'category_id' => $categoryId,
        'features' => $features,
        'details' => $details,
        'id' => $productId
    ]);

    echo "Product updated successfully.";
} else {
    echo "Invalid request method.";
}
?>
