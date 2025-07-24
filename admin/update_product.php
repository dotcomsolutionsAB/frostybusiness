<?php
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    ini_set('log_errors', 1);
    
// Database configuration
$host = '127.0.0.1';
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
$stmt = $pdo->prepare("SELECT * FROM products WHERE id = :id");
$stmt->execute(['id' => $productId]);
$product = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$product) {
    die("Product not found.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $category_id = $_POST['category_id'];
    $features = $_POST['features'];
    $details = $_POST['details'];

    // Handle file upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = "../images/uploads/";
        if (!is_dir($uploadDir) || !is_writable($uploadDir)) {
            echo "<p>Upload directory does not exist or is not writable.</p>";
            exit;
        }
    
        $fileName = uniqid() . '_' . basename($_FILES['image']['name']);
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
    
            // Update product's image_id if necessary
            $stmt = $pdo->prepare("UPDATE products SET image_id = :image_id WHERE id = :id");
            $stmt->execute(['image_id' => $imageId, 'id' => $productId]);
        } else {
            echo "<p>Failed to move uploaded file. Check directory permissions and path.</p>";
            exit;
        }
    } else if (isset($_FILES['image']['error'])) {
        echo "File upload error code: " . $_FILES['image']['error'];
        exit;
    }
    

    $stmt = $pdo->prepare("UPDATE products SET category_id = :category_id, features = :features, details = :details, updated_at = NOW() WHERE id = :id");
    $stmt->execute([
        'category_id' => $category_id,
        'features' => $features,
        'details' => $details,
        'id' => $productId
    ]);

    echo "<script>window.parent.closePopup();</script>";
    exit;
}

$categories = $pdo->query("SELECT id, name FROM categories")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update Product</title>
</head>
<body>
    <h1>Update Product</h1>
    <form method="POST" enctype="multipart/form-data">
        <p><b>Product Name:</b> <?php echo htmlspecialchars($product['name']); ?></p>
        <p><b>Model:</b> <?php echo htmlspecialchars($product['model']); ?></p>

        <label for="category_id">Category:</label>
        <select name="category_id" id="category_id">
            <?php foreach ($categories as $category): ?>
                <option value="<?php echo $category['id']; ?>" <?php echo $product['category_id'] == $category['id'] ? 'selected' : ''; ?>>
                    <?php echo htmlspecialchars($category['name']); ?>
                </option>
            <?php endforeach; ?>
        </select>
        <br><br>

        <label for="features">Features:</label>
        <textarea name="features" id="features" rows="4" cols="50"><?php echo htmlspecialchars($product['features']); ?></textarea>
        <br><br>

        <label for="details">Details:</label>
        <textarea name="details" id="details" rows="4" cols="50"><?php echo htmlspecialchars($product['details']); ?></textarea>
        <br><br>

        <label for="image">Upload Image:</label>
        <input type="file" id="image" name="image" accept="image/*">
        <br><br>

        <button type="submit">Update</button>
    </form>
</body>
</html>
