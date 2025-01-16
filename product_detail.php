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

if (!isset($_GET['model'])) {
    die("Product model not specified.");
}

$productModel = $_GET['model'];

// Fetch product details
$stmt = $pdo->prepare(
    "SELECT p.id, p.name AS product_name, p.model, p.features, p.details, c.name AS category_name, u.file_original_name, u.path 
     FROM products p
     LEFT JOIN categories c ON p.category_id = c.id
     LEFT JOIN uploads u ON p.image_id = u.id
     WHERE p.model = :model"
);
$stmt->execute(['model' => $productModel]);
$product = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$product) {
    die("Product not found.");
}

// Process features into a list format
$features = array_filter(array_map('trim', explode("\n", $product['features'])));

// Process details into table rows
$detailsRows = array_filter(array_map(function($line) {
    $columns = array_map('trim', explode("\t", $line));
    if (count($columns) === 2) {
        $columns[0] = ltrim($columns[0], '_'); // Remove leading underscore
        return $columns;
    }
    return null;
}, explode("\n", $product['details'])));
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Details</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
        }
        .product-details {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: #f9f9f9;
        }
        .product-details img {
            max-width: 100%;
            height: auto;
            display: block;
            margin-bottom: 20px;
        }
        .product-details h1 {
            font-size: 24px;
            margin-bottom: 10px;
        }
        .product-details p {
            margin: 5px 0;
        }
        .features-list {
            list-style: none;
            padding: 0;
        }
        .features-list li {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
        }
        .features-list .icon {
            color: green;
            margin-right: 10px;
        }
        .details-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        .details-table th, .details-table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        .details-table th {
            background-color: #f4f4f4;
        }
    </style>
</head>
<body>
    <div class="product-details">
        <h1><?php echo htmlspecialchars($product['product_name']); ?></h1>
        <p><strong>Model:</strong> <?php echo htmlspecialchars($product['model']); ?></p>
        <p><strong>Category:</strong> <?php echo htmlspecialchars($product['category_name']); ?></p>

        <?php if (!empty($product['path'])): ?>
            <img src="<?php echo htmlspecialchars($product['path']); ?>" alt="<?php echo htmlspecialchars($product['file_original_name']); ?>">
        <?php else: ?>
            <p><em>No image available.</em></p>
        <?php endif; ?>

        <?php if (!empty($features)): ?>
            <p><strong>Features:</strong></p>
            <ul class="features-list">
                <?php foreach ($features as $feature): ?>
                    <li>
                        <div class="icon">
                            <span class="fa fa-check"></span>
                        </div>
                        <div class="text">
                            <p><?php echo htmlspecialchars($feature); ?></p>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>

        <?php if (!empty($detailsRows)): ?>
    <p><strong>Details:</strong></p>
    <table class="details-table">
        <thead>
            <tr>
                <th>Property</th>
                <th>Value</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($detailsRows as $row): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row[0]); ?></td>
                    <td><?php echo htmlspecialchars($row[1]); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    <p><em>No details available.</em></p>
<?php endif; ?>

    </div>
</body>
</html>
