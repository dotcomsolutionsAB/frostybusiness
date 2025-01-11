

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Google Sheet Status</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <a href="index.php" class="btn btn-primary">Back</a>
        <?php
            // Database configuration
            $host = 'localhost';
            $dbname = 'tbl_';
            $username = 'tbl_';
            $password = 'Jzz4Qp1e5Za1k@can';
            
            // Create a database connection
            $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_status'])) {
                // Update status in google_sheet table to 0
                $sheetId = intval($_POST['sheet_id']);
                $stmt = $conn->prepare("UPDATE google_sheet SET status = 0 WHERE id = :id");
                $stmt->execute([':id' => $sheetId]);
                echo "<p>Status updated for Sheet ID: $sheetId</p>";
            }
            
            // Fetch all sheets
            $stmt = $conn->prepare("SELECT * FROM google_sheet");
            $stmt->execute();
            $sheets = $stmt->fetchAll(PDO::FETCH_ASSOC);
        ?>
        <div class="container mt-5">
            <h1>Google Sheets</h1>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($sheets as $sheet): ?>
                        <tr>
                            <td><?= htmlspecialchars($sheet['id']) ?></td>
                            <td><?= htmlspecialchars($sheet['name']) ?></td>
                            <td><?= htmlspecialchars($sheet['status']) ?></td>
                            <td>
                                <form method="POST" style="display:inline-block;">
                                    <input type="hidden" name="sheet_id" value="<?= $sheet['id'] ?>">
                                    <button type="submit" name="update_status" class="btn btn-primary" <?= $sheet['status'] == 0 ? 'disabled' : '' ?>>Update Status to 0</button>
                                    <a href="add_api.php" class="btn btn-warning">Run API</a>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
        </table>
        </div>
    </div>
</body>
</html>
