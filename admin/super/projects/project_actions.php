<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Project Actions</title>
    <link rel="stylesheet" href="style.css"> <!-- Include your existing styles -->
</head>
<body>
    <div class="side">
        <a href="../index.php">Back Home</a>
    </div>
    <div class="container">
        <h2>Project Actions</h2>
        <div class="actions">
            <button onclick="createProject()">Create Project</button>
            <button onclick="updateProject()">Update Project</button>
            <button onclick="deleteProject()">Delete Project</button>
        </div>
        <div id="action-output" class="output">
            <!-- Dynamic output for actions -->
        </div>
    </div>
    <script>
        function createProject() {
            document.getElementById('action-output').innerHTML = "<p>Create Project functionality will be implemented here.</p>";
        }

        function updateProject() {
            document.getElementById('action-output').innerHTML = "<p>Update Project functionality will be implemented here.</p>";
        }

        function deleteProject() {
            document.getElementById('action-output').innerHTML = "<p>Delete Project functionality will be implemented here.</p>";
        }
    </script>
</body>
</html>
<style>
    .container {
    text-align: center;
    padding: 20px;
    font-family: Arial, sans-serif;
}

.actions button {
    margin: 10px;
    padding: 10px 20px;
    font-size: 16px;
    border: none;
    background-color: #1891d1;
    color: white;
    cursor: pointer;
    border-radius: 5px;
}

.actions button:hover {
    background-color: #007bb5;
}

.output {
    margin-top: 20px;
    padding: 15px;
    border: 1px solid #ddd;
    border-radius: 5px;
    background: #f9f9f9;
}
</style>
<script>
    document.querySelector('#projects-btn').addEventListener('click', function() {
    window.location.href = 'project_actions.php';
});
</script>