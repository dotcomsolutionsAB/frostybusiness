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

// Assuming the product details field contains the HTML table
$detailsRaw = $product['details']; 

// Check if details are present
if (!empty($detailsRaw)) {
    // Create a new DOMDocument object to parse the HTML
    $dom = new DOMDocument();
    
    // Load the HTML content into the DOM object
    libxml_use_internal_errors(true);  // Suppress warnings for malformed HTML
    $dom->loadHTML('<?xml encoding="UTF-8">' . $detailsRaw);  // Prevent warnings related to encoding
    libxml_clear_errors();
    
    // Get all the table rows
    $rows = $dom->getElementsByTagName('tr');
    
    // Initialize an array to hold the processed details
    $detailsRows = [];
    
    foreach ($rows as $row) {
        $cells = $row->getElementsByTagName('td');
        
        // Ensure there are exactly two cells (key and value)
        if ($cells->length == 2) {
            $key = trim($cells->item(0)->textContent);  // Extract the key (left column)
            $value = trim($cells->item(1)->textContent); // Extract the value (right column)
            
            // Clean up the key (e.g., remove leading underscores)
            $key = ltrim($key, '_');
            
            // Add the key-value pair to the array
            $detailsRows[] = [$key, $value];
        }
    }
} else {
    $detailsRows = [];
}
?>

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


