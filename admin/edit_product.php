<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Product</title>
</head>
<body>
    <h1>Update Product</h1>
    <form action="update_product.php" method="POST" enctype="multipart/form-data">
        <label for="product_id">Select Product:</label>
        <select name="product_id" id="product_id" required>
            <?php
            // Fetch products from the database
            try {
                $pdo = new PDO("mysql:host=localhost;dbname=frostybusiness", "frostybusiness", "1y5D^dn09");
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                $stmt = $pdo->query("SELECT id, name FROM products");
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    echo "<option value='{$row['id']}'>{$row['name']}</option>";
                }
            } catch (PDOException $e) {
                die("Database connection failed: " . $e->getMessage());
            }
            ?>
        </select>
        <br><br>

        <label for="name">Product Name:</label>
        <input type="text" id="name" name="name" required>
        <br><br>

        <label for="model">Model:</label>
        <input type="text" id="model" name="model" required>
        <br><br>

        <label for="category_id">Category:</label>
        <select name="category_id" id="category_id" required>
            <?php
            // Fetch categories from the database
            try {
                $stmt = $pdo->query("SELECT id, name FROM categories");
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    echo "<option value='{$row['id']}'>{$row['name']}</option>";
                }
            } catch (PDOException $e) {
                die("Database connection failed: " . $e->getMessage());
            }
            ?>
        </select>
        <br><br>

        <label for="features">Features:</label>
        <textarea id="features" name="features" rows="4" cols="50"></textarea>
        <br><br>

        <label for="details">Details:</label>
        <textarea id="details" name="details" rows="4" cols="50"></textarea>
        <br><br>

        <label for="image">Upload Image:</label>
        <input type="file" id="image" name="image" accept="image/*">
        <br><br>

        <button type="submit">Update Product</button>
    </form>
</body>
</html>
