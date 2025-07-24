<?php
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    ini_set('log_errors', 1);
    
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
$stmt = $pdo->prepare("SELECT * FROM variations WHERE product_id = :product_id");
$stmt->execute(['product_id' => $productId]);
$variations = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (empty($variations)) {
    die("No variations found.");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Variations</title>
</head>
<body>
    <h1>Variations</h1>
    <table border="1" cellpadding="5">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Model</th>
                <th>Details</th>
                <th>Features</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($variations as $variation): ?>
                <tr>
                    <td><?php echo htmlspecialchars($variation['id']); ?></td>
                    <td><?php echo htmlspecialchars($variation['name']); ?></td>
                    <td><?php echo htmlspecialchars($variation['model_id']); ?></td>
                    <td><?php echo htmlspecialchars($variation['detail_data']); ?></td>
                    <td><?php echo htmlspecialchars($variation['features_data']); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
