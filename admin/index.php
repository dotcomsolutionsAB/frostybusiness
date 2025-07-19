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

// Fetch products and their categories
$sql = "SELECT p.id, p.name AS product_name, p.model,p.features, p.details, c.name AS category_name, u.file_original_name, u.path 
        FROM products p
        LEFT JOIN categories c ON p.category_id = c.id
        LEFT JOIN uploads u ON p.image_id = u.id";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (empty($products)) {
    die("No products found.");
}

$sql2 = "SELECT id, name FROM categories";
$stmt2 = $pdo->prepare($sql2);
$stmt2->execute();
$categoriess = $stmt2->fetchAll(PDO::FETCH_ASSOC);

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
    <!-- Add product -->
     <style>
       #addProductModal {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 500px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            z-index: 1000;
            padding: 20px;
            animation: fadeIn 0.3s ease-in-out;
        }
        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }
        #addProductForm label {
            display: flex;
            justify-content: space-between;
            margin-bottom: 5px;
            font-weight: bold;
            color: #555;
        }
        #addProductForm input, #addProductForm select, #addProductForm textarea {
            width: 95%;
            padding: 10px;
            margin-bottom: 5px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
            background-color: #f9f9f9;
            transition: border-color 0.3s;
        }
        #addProductForm button {
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            font-weight: bold;
            background-color: #007bff;
            color: white;
        }
        #addProductForm button[type="button"] {
            background-color: #f44336;
        }
        .buttons{
            display: flex;
            flex-direction: row;
            justify-content: flex-end;
            gap: 20px;
        }
    </style>
</head>
<body>
    <h1>All Products</h1>

    <!-- Add product Code -->
    <button onclick="openAddProductModal()">Add Product</button>

    <!-- Add Product Modal -->
    <div id="addProductModal">
        <form id="addProductForm" onsubmit="saveProduct(event)">
            <h2>Add Product</h2>

            <label for="name">Product Name:</label>
            <input type="text" id="name" name="name" required>

            <label for="model">Model:</label>
            <input type="text" id="model" name="model" required>

            <label for="category_id">Category:</label>
            <select id="category_id" name="category_id">
                <option value="">Select Category</option>
                <?php foreach ($categoriess as $category): ?>
                    <option value="<?php echo htmlspecialchars($category['id']); ?>">
                        <?php echo htmlspecialchars($category['name']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <label>
                Other
                <input type="checkbox" id="otherCategory">
            </label>
            <input type="text" id="newCategoryName" name="new_category_name" placeholder="New Category Name" style="display: none;">

            <label for="sheet_id">Sheet ID:</label>
            <input type="number" id="sheet_id" name="sheet_id" value="0">

            <label for="image_id">Image ID:</label>
            <input type="number" id="image_id" name="image_id" value="0">

            <label for="features">Features:</label>
            <textarea id="features" name="features" placeholder="Enter features separated by line breaks"></textarea>

            <label for="details">Details:</label>
            <textarea id="details" name="details" placeholder="Enter details"></textarea>

            <div class="buttons">
                <button type="submit">Save</button>
                <button type="button" onclick="closeAddProductModal()">Close</button>
            </div>
        </form>
    </div>

    <script>
        function openAddProductModal() {
            document.getElementById('addProductModal').style.display = 'block';
        }

        function closeAddProductModal() {
            document.getElementById('addProductModal').style.display = 'none';
        }

        document.getElementById('otherCategory').addEventListener('change', function () {
            const newCategoryField = document.getElementById('newCategoryName');
            newCategoryField.style.display = this.checked ? 'block' : 'none';
        });

        async function saveProduct(event) {
            event.preventDefault();
            const formData = new FormData(document.getElementById('addProductForm'));

            // Convert features into `<li>` tags
            const features = formData.get('features').split('\n').map(f => `<li>${f.trim()}</li>`).join('');
            formData.set('features', features);

            try {
                const response = await fetch('save_product.php', {
                    method: 'POST',
                    body: formData
                });
                const result = await response.json();

                if (result.success) {
                    alert('Product saved successfully!');
                    closeAddProductModal();
                    location.reload();
                } else {
                    alert('Error: ' + result.message);
                }
            } catch (error) {
                console.error('Error saving product:', error);
                alert('An unexpected error occurred.');
            }
        }
    </script>
    <!-- End Add product Code -->

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
                    <td><?php echo htmlspecialchars($product['features'] ?? ''); ?></td>
                    <td><?php echo htmlspecialchars($product['details'] ?? ''); ?></td>
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
