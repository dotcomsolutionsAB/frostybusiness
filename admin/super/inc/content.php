<div class="title">
    <ion-icon name="folder-outline"></ion-icon>
    <span class="text">Content</span>
</div>
<div class="content-section">
    <div class="section">
        <h3>API (Count: 8)</h3>
        <button onclick="handleClick('API')">Click Me</button>
    </div>
    <div class="section">
        <h3>Projects (Count: 4)</h3>
        <a href="./project/project_actions.php"><button>Click Me</button></a>
    </div>
    <div class="section">
        <h3>Details (Count: 12)</h3>
        <button onclick="handleClick('Details')">Click Me</button>
    </div>
    <div class="section">
        <h3>Permissions (Count: 121)</h3>
        <button onclick="handleClick('Permissions')">Click Me</button>
    </div>
</div>
<style>
    .content-section {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-around;
        padding: 20px;
        background-color:rgba(108, 203, 193, 0.83);
        border-radius: 10px;
    }

    .section {
        background: #ffffff;
        border: 1px solid #ddd;
        border-radius: 10px;
        padding: 15px 20px;
        width: 200px;
        margin: 10px;
        text-align: center;
        box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
    }

    .section h3 {
        font-size: 16px;
        margin-bottom: 10px;
    }

    .section button {
        padding: 10px 15px;
        font-size: 14px;
        color: #ffffff;
        background-color:rgb(255, 10, 10);
        border: none;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .section button:hover {
        background-color:rgb(251, 184, 16);
    }
</style>
<script>
    function handleClick(section) {
        alert(`Button clicked for ${section}`);
    }
</script>