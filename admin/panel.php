<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Responsive Nav and Sidebar</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Roboto', sans-serif;
            display: flex;
            flex-direction: column;
        }

        /* Navigation Bar */
        .navbar {
            background-color: #2c3e50;
            color: white;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 20px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        }

        .navbar .logo {
            font-size: 1.8em;
            font-weight: bold;
        }

        .navbar .menu {
            display: flex;
            gap: 20px;
        }

        .navbar .menu a {
            color: white;
            text-decoration: none;
            font-size: 1em;
            transition: color 0.3s ease;
        }

        .navbar .menu a:hover {
            color: #18bc9c;
        }

        .navbar .menu-toggle {
            display: none;
            font-size: 1.8em;
            cursor: pointer;
        }

        /* Sidebar */
        .sidebar {
            width: 250px;
            background-color: #34495e;
            color: white;
            position: fixed;
            top: 0;
            /* left: -250px; */
            height: 100%;
            padding: 20px;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.2);
            transition: transform 0.3s ease;
        }
        /* Desktop Default: Sidebar Visible */
    .sidebar {
        left: 0;
    }
        .sidebar.open {
            left: -250px;
        }

        .sidebar .close-btn {
            font-size: 1.5em;
            color: white;
            cursor: pointer;
            text-align: right;
            margin-bottom: 20px;
        }

        .sidebar a {
            color: white;
            text-decoration: none;
            display: block;
            margin: 15px 0;
            font-size: 1.1em;
            transition: color 0.3s ease;
        }

        .sidebar a:hover {
            color: #18bc9c;
        }

        .toggle-arrow {
            font-size: 1.8em;
            cursor: pointer;
            position: fixed;
            left: 10px;
            top: 20px;
            color: #2c3e50;
            display: none;
            z-index: 1000;
        }

        .toggle-arrow.open {
            display: block;
        }

        .content {
            margin-left: 250px;
            padding: 20px;
            background-color: #ecf0f1;
            min-height: 100vh;
            transition: margin-left 0.3s ease;
        }

        @media screen and (max-width: 768px) {
            .navbar .menu {
                display: none;
            }

            .navbar .menu-toggle {
                display: block;
            }

            .sidebar {
                left: -250px;
            }

            .sidebar.open {
                left: 0;
            }

            .content {
                margin-left: 0;
            }

            .sidebar.open ~ .content {
                margin-left: 250px;
            }

            .toggle-arrow {
                display: block;
            }
        }
    </style>
</head>
<body>
    <div class="navbar">
        <div class="logo">My Website</div>
        <div class="menu-toggle" onclick="toggleSidebar()">&#9776;</div>
        <div class="menu">
            <a href="#">Home</a>
            <a href="#">About</a>
            <a href="#">Services</a>
            <a href="#">Contact</a>
        </div>
    </div>

    <div class="toggle-arrow" id="toggleArrow" onclick="toggleSidebar()">&#x2192;</div>

    <div class="sidebar" id="sidebar">
        <div class="close-btn" onclick="toggleSidebar()">&times;</div>
        <a href="#">Dashboard</a>
        <a href="#">Profile</a>
        <a href="#">Settings</a>
        <a href="#">Logout</a>
    </div>

    <div class="content">
        <h1>Welcome to My Website</h1>
        <p>This is a fully responsive layout with a navigation bar and a sidebar. Resize your browser to see the responsiveness in action.</p>
        <p>Enhance your UI experience with smooth transitions and elegant styles.</p>
    </div>

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const toggleArrow = document.getElementById('toggleArrow');
            sidebar.classList.toggle('open');
            if (sidebar.classList.contains('open')) {
                toggleArrow.innerHTML = '&#x2190;'; // Left arrow
            } else {
                toggleArrow.innerHTML = '&#x2192;'; // Right arrow
            }
        }
    </script>
</body>
</html>
