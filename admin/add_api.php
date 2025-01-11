<?php
// Database configuration
$host = 'localhost';
$dbname = 'tbl_';
$username = 'tbl_';
$password = 'Jzz4Qp1e5Za1k@can';

// Create a database connection
try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo json_encode(["message" => "Database connection failed: " . $e->getMessage()]);
    exit;
}

// Fetch Google Sheet paths where status == 0
$stmt = $conn->prepare("SELECT * FROM google_sheet WHERE status = 0");
$stmt->execute();
$googleSheets = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (!$googleSheets) {
    echo json_encode(["message" => "No Google Sheets with status 0 found."]);
    exit;
}

foreach ($googleSheets as $sheet) {
    $spreadsheetPath = $sheet['path'];

    // Check if the path is a URL
    if (filter_var($spreadsheetPath, FILTER_VALIDATE_URL)) {
        // Fetch the Google Sheets content as CSV
        $csvContent = file_get_contents($spreadsheetPath);
        if ($csvContent === false) {
            echo json_encode(["message" => "Failed to fetch the sheet: " . $sheet['name']]);
            continue;
        }

        // Parse the CSV content
        $lines = explode(PHP_EOL, $csvContent);
        $data = array_map('str_getcsv', $lines);
    } else {
        if (!file_exists($spreadsheetPath)) {
            echo json_encode(["message" => "File not found: " . $spreadsheetPath]);
            continue;
        }

        // Open the file and read data
        $file = fopen($spreadsheetPath, 'r');
        $data = [];
        while (($row = fgetcsv($file)) !== false) {
            $data[] = $row;
        }
        fclose($file);
    }

    if (count($data) < 2) { // Ensure there is data beyond the header row
        echo json_encode(["message" => "No data found in the sheet: " . $sheet['name']]);
        continue;
    }

    // Skip the header row
    $headers = array_shift($data);

    $addedCount = 0;        // Tracks newly added brands
    $updatedCount = 0;      // Tracks updated brands
    $incompleteCount = 0;   // Tracks rows with missing essential data
    $totalRows = count($data); // Total rows excluding header

    foreach ($data as $row) {
        // Extract data with null coalescing to handle missing fields
        $sn = $row[0] ?? null;
        $categoryName = $row[1] ?? null;
        $name = $row[2] ?? null;
        $description = $row[3] ?? null;
        $url = $row[4] ?? null;
        $photo = $row[5] ?? null;

        // Skip rows with missing essential data
        if (!$categoryName || !$name) {
            $incompleteCount++;
            continue;
        }

        // Insert or fetch the category ID
        $stmt = $conn->prepare("SELECT id FROM categories WHERE name = :name");
        $stmt->execute([':name' => $categoryName]);
        $category = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$category) {
            $stmt = $conn->prepare("INSERT INTO categories (name) VALUES (:name)");
            $stmt->execute([':name' => $categoryName]);
            $categoryId = $conn->lastInsertId();
        } else {
            $categoryId = $category['id'];
        }

        // Check if the brand already exists
        $stmt = $conn->prepare("SELECT id FROM brands WHERE name = :name");
        $stmt->execute([':name' => $name]);
        $brand = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$brand) {
            // Insert new brand
            $stmt = $conn->prepare(
                "INSERT INTO brands (name, category_id, description, url_link, photos) VALUES (:name, :category_id, :description, :url_link, :photos)"
            );
            $stmt->execute([
                ':name' => $name,
                ':category_id' => $categoryId,
                ':description' => $description,
                ':url_link' => $url,
                ':photos' => $photo
            ]);
            $addedCount++;
        } else {
            // Update existing brand
            $stmt = $conn->prepare(
                "UPDATE brands SET category_id = :category_id, description = :description, url_link = :url_link, photos = :photos WHERE id = :id"
            );
            $stmt->execute([
                ':id' => $brand['id'],
                ':category_id' => $categoryId,
                ':description' => $description,
                ':url_link' => $url,
                ':photos' => $photo
            ]);
            $updatedCount++;
        }
    }

    // Update the google_sheet status to 0
    $stmt = $conn->prepare("UPDATE google_sheet SET status = 1 WHERE id = :id");
    $stmt->execute([':id' => $sheet['id']]);

    // Generate and output the response for this sheet
    $response = [
        "message" => "Sheet processed successfully.",
        "sheet_name" => $sheet['name'],
        "total_rows" => $totalRows,
        "added_count" => $addedCount,
        "updated_count" => $updatedCount,
        "incomplete_count" => $incompleteCount
    ];

    echo json_encode($response);
}
?>
