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

// Fetch products and their categories
$sql = "SELECT p.id, p.name AS product_name, p.model, c.name AS category_name, p.features, p.details, p.image_id 
        FROM products p
        LEFT JOIN categories c ON p.category_id = c.id";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (empty($products)) {
    die("No products found.");
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Products</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f4f4f4;
        }
        .actions {
            display: flex;
            gap: 10px;
        }
        .actions a {
            text-decoration: none;
            color: #fff;
            padding: 5px 10px;
            border-radius: 5px;
        }
        .update {
            background-color: #4caf50;
        }
        .delete {
            background-color: #f44336;
        }
    </style>
</head>
<body>
    <h1>All Products</h1>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Product Name</th>
                <th>Model</th>
                <th>Category</th>
                <th>Features</th>
                <th>Details</th>
                <th>Image</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($products as $product): ?>
                <tr>
                    <td><?php echo htmlspecialchars($product['id']); ?></td>
                    <td><?php echo htmlspecialchars($product['product_name']); ?></td>
                    <td><?php echo htmlspecialchars($product['model']); ?></td>
                    <td><?php echo htmlspecialchars($product['category_name']); ?></td>
                    <td><?php echo htmlspecialchars($product['features']); ?></td>
                    <td><?php echo htmlspecialchars($product['details']); ?></td>
                    <td>
                        <?php if ($product['image_id']): ?>
                            <img src="../images/uploads/<?php echo htmlspecialchars($product['image_id']); ?>.jpg" alt="Product Image" width="100">
                        <?php else: ?>
                            No Image
                        <?php endif; ?>
                    </td>
                    <td class="actions">
                        <a href="update_product.php?id=<?php echo htmlspecialchars($product['id']); ?>" class="update">Update</a>
                        <a href="delete_product.php?id=<?php echo htmlspecialchars($product['id']); ?>" class="delete" onclick="return confirm('Are you sure you want to delete this product?');">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
