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
$sql = "SELECT p.id, p.name AS product_name, p.model, c.name AS category_name, u.file_original_name, u.path 
        FROM products p
        LEFT JOIN categories c ON p.category_id = c.id
        LEFT JOIN uploads u ON p.image_id = u.id";
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
    <script>
        function openPopup(type, productId) {
            const popup = document.getElementById('popupModal');
            const iframe = document.getElementById('popupIframe');
            let url = '';

            if (type === 'update') {
                url = `update_product.php?id=${productId}`;
            } else if (type === 'variations') {
                url = `view_variations.php?id=${productId}`;
            } else if (type === 'delete') {
                if (confirm('Are you sure you want to delete this product?')) {
                    url = `delete_product.php?id=${productId}`;
                    window.location.href = url;
                    return;
                } else {
                    return;
                }
            }

            iframe.src = url;
            popup.style.display = 'block';
        }

        function closePopup() {
            const popup = document.getElementById('popupModal');
            const iframe = document.getElementById('popupIframe');
            iframe.src = '';
            popup.style.display = 'none';
        }
    </script>
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
                        <?php if (!empty($product['file_original_name'])): ?>
                            <img src="<?php echo htmlspecialchars($product['path']); ?>" alt="<?php echo htmlspecialchars($product['file_original_name']); ?>" width="100">
                        <?php else: ?>
                            No Image
                        <?php endif; ?>
                    </td>
                    <td class="actions">
                        <a href="#" class="update" onclick="openPopup('update', <?php echo htmlspecialchars($product['id']); ?>);">Update</a>
                        <a href="#" class="update" onclick="openPopup('variations', <?php echo htmlspecialchars($product['id']); ?>);">View All Variations</a>
                        <a href="#" class="delete" onclick="openPopup('delete', <?php echo htmlspecialchars($product['id']); ?>);">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <!-- Popup Modal -->
    <div id="popupModal" style="display: none; position: fixed; top: 10%; left: 10%; width: 80%; height: 80%; background: #fff; border: 1px solid #ddd; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); z-index: 1000;">
        <iframe id="popupIframe" style="width: 100%; height: 100%; border: none;"></iframe>
        <button onclick="closePopup()" style="position: absolute; top: 10px; right: 10px; padding: 5px 10px; background-color: #f44336; color: #fff; border: none; border-radius: 5px; cursor: pointer;">Close</button>
    </div>
</body>
</html>
