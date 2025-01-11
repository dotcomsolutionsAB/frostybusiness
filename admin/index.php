    <?php
        // Database configuration
        $host = 'localhost';
        $dbname = 'tbl_';
        $username = 'tbl_';
        $password = 'Jzz4Qp1e5Za1k@can';

        // Create a database connection
        $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            // Fetch all data from brands table
            $stmt = $conn->prepare("SELECT b.*, c.name as category_name FROM brands b JOIN categories c ON b.category_id = c.id");
            $stmt->execute();
            $brands = $stmt->fetchAll(PDO::FETCH_ASSOC);
    ?>

    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Brands Management</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    </head>
    <body>
        <div class="container">
            <a href="sheet.php" class="btn btn-warning btn-sm">Go To Sheet</a>
        </div>
        <div class="container mt-5">
            <h2>Brands Table</h2>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Category</th>
                        <th>Description</th>
                        <th>URL</th>
                        <th>Photo</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($brands as $brand) { ?>
                        <tr>
                            <td><?= $brand['id'] ?></td>
                            <td><?= htmlspecialchars($brand['name']) ?></td>
                            <td><?= htmlspecialchars($brand['category_name']) ?></td>
                            <td><?= htmlspecialchars($brand['description']) ?></td>
                            <td><a href="<?= htmlspecialchars($brand['url_link']) ?>" target="_blank">Link</a></td>
                            <td><img src="<?= htmlspecialchars($brand['photos']) ?>" alt="Photo" style="width: 50px; height: 50px;"></td>
                            <td>
                                <button class="btn btn-warning btn-sm" onclick="showUpdatePopup(<?= $brand['id'] ?>, '<?= addslashes($brand['name']) ?>', '<?= addslashes($brand['description']) ?>', '<?= addslashes($brand['url_link']) ?>', '<?= addslashes($brand['photos']) ?>')">Update</button>
                                <button class="btn btn-danger btn-sm" onclick="deleteBrand(<?= $brand['id'] ?>)">Delete</button>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>

        <!-- Update Popup -->
        <div id="updatePopup" class="modal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Update Brand</h5>
                        <button type="button" class="btn-close" onclick="closePopup()"></button>
                    </div>
                    <div class="modal-body">
                        <form id="updateForm">
                            <input type="hidden" id="updateId">
                            <div class="mb-3">
                                <label for="updateName" class="form-label">Name</label>
                                <input type="text" class="form-control" id="updateName" required>
                            </div>
                            <div class="mb-3">
                                <label for="updateDescription" class="form-label">Description</label>
                                <textarea class="form-control" id="updateDescription" required></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="updateUrl" class="form-label">URL</label>
                                <input type="url" class="form-control" id="updateUrl">
                            </div>
                            <div class="mb-3">
                                <label for="updatePhoto" class="form-label">Photo</label>
                                <input type="text" class="form-control" id="updatePhoto">
                            </div>
                            <button type="button" class="btn btn-primary" onclick="submitUpdate()">Update</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <script>
            function showUpdatePopup(id, name, description, url, photo) {
                document.getElementById('updateId').value = id;
                document.getElementById('updateName').value = name;
                document.getElementById('updateDescription').value = description;
                document.getElementById('updateUrl').value = url;
                document.getElementById('updatePhoto').value = photo;
                document.getElementById('updatePopup').style.display = 'block';
            }

            function closePopup() {
                document.getElementById('updatePopup').style.display = 'none';
            }

            function deleteBrand(id) {
                if (confirm('Are you sure you want to delete this brand?')) {
                    $.post('', { action: 'delete', id: id }, function(response) {
                        location.reload();
                    });
                }
            }

            function submitUpdate() {
                const id = document.getElementById('updateId').value;
                const name = document.getElementById('updateName').value;
                const description = document.getElementById('updateDescription').value;
                const url = document.getElementById('updateUrl').value;
                const photo = document.getElementById('updatePhoto').value;

                $.post('', {
                    action: 'update',
                    id: id,
                    name: name,
                    description: description,
                    url: url,
                    photo: photo
                }, function(response) {
                    location.reload();
                });
            }
        </script>
    </body>
    </html>
    <?php
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $action = $_POST['action'] ?? '';

            if ($action === 'delete') {
                $id = $_POST['id'] ?? 0;
                $stmt = $conn->prepare("DELETE FROM brands WHERE id = :id");
                $stmt->execute([':id' => $id]);
                echo json_encode(["message" => "Brand deleted successfully"]);
                exit;
            }

            if ($action === 'update') {
                $id = $_POST['id'] ?? 0;
                $name = $_POST['name'] ?? '';
                $description = $_POST['description'] ?? '';
                $url = $_POST['url'] ?? '';
                $photo = $_POST['photo'] ?? '';

                $stmt = $conn->prepare("UPDATE brands SET name = :name, description = :description, url_link = :url, photos = :photo WHERE id = :id");
                $stmt->execute([
                    ':id' => $id,
                    ':name' => $name,
                    ':description' => $description,
                    ':url' => $url,
                    ':photo' => $photo
                ]);

                echo json_encode(["message" => "Brand updated successfully"]);
                exit;
            }
        }
    ?>
