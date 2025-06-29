<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* General Styles */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: 'Arial', sans-serif;
    background-color: #f4f4f4;
}

/* Navbar Styling */
.navbar {
    background-color: #ffffff;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    padding: 10px 20px;
}

.navbar-brand {
    font-size: 20px;
    font-weight: bold;
    color: #333;
    display: flex;
    align-items: center;
}

.navbar-brand i {
    margin-right: 8px;
}

.search-bar {
    width: 300px;
    border-radius: 20px;
    border: 1px solid #ccc;
    padding: 5px 15px;
    font-size: 14px;
}

.icon-button {
    background: none;
    border: none;
    font-size: 18px;
    margin-left: 15px;
    color: #333;
}

.icon-button:hover {
    color: #04AA6D;
}

.profile-img {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    object-fit: cover;
}

/* Sidebar Styling */
.sidebar {
    width: 250px;
    height: 100vh;
    position: fixed;
    left: 0;
    top: 0;
    background-color: #2C3E50;
    padding-top: 20px;
    color: white;
    overflow-y: auto;
}

.menu {
    list-style-type: none;
    padding: 0;
}

.menu li {
    padding: 10px 20px;
    transition: background-color 0.3s ease;
}

.menu li a {
    color: #fff;
    text-decoration: none;
    display: block;
    padding: 10px 15px;
    background-color: #333;
    border-radius: 5px;
    font-size: 16px;
    transition: background-color 0.3s ease, transform 0.2s ease;
}

.menu li a:hover {
    background-color: #1A252F;
}

.dropdown-menu {
    display: none;
    list-style: none;
    padding-left: 20px;
}

.dropdown:hover .dropdown-menu {
    display: block;
}

.dropdown-menu li a {
    padding-left: 30px;
}

/* Content Styling */
.content {
    margin-left: 250px;
    padding: 20px;
    background-color: #fff;
    min-height: 100vh;
    color: #333;
}

h1 {
    font-size: 24px;
    margin-bottom: 20px;
}

p {
    font-size: 16px;
    color: #666;
}

/* Media Queries for Responsiveness */
@media (max-width: 768px) {
    .navbar {
        padding: 10px;
    }

    .search-bar {
        width: 200px;
    }

    .sidebar {
        width: 200px;
    }

    .content {
        margin-left: 200px;
    }

    .menu li {
        padding: 8px 16px;
    }

    .menu li a {
        font-size: 14px;
    }

    .profile-img {
        width: 35px;
        height: 35px;
    }
}

@media (max-width: 576px) {
    .navbar {
        flex-direction: column;
        align-items: flex-start;
    }

    .search-bar {
        width: 100%;
        margin-top: 10px;
    }

    .sidebar {
        width: 100%;
        position: relative;
        height: auto;
    }

    .content {
        margin-left: 0;
    }
}

    </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg">
    <div class="container-fluid">
        <a class="navbar-brand" href="#"><i class="fas fa-tools"></i>Admin</a>
        
        <form class="d-flex ms-auto">
            <input class="form-control search-bar" type="search" placeholder="Search..." aria-label="Search">
        </form>

        <div class="d-flex align-items-center">
            <button class="icon-button"><i class="fas fa-envelope"></i></button>
            <button class="icon-button"><i class="fas fa-bell"></i></button>
            
            <div class="dropdown">
                <button class="icon-button dropdown-toggle" type="button" id="profileDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="../uploads/adminlogo.png" alt="Profile" class="profile-img">
                </button>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileDropdown">
                    <li><a class="dropdown-item" href="#"><i class="fas fa-user"></i> Profile</a></li>
                    <li><a class="dropdown-item" href="#"><i class="fas fa-cog"></i> Settings</a></li>
                </ul>
            </div>
        </div>
    </div>
</nav>

<!-- Sidebar -->
<div class="sidebar">
    <ul class="menu">
        <li><a href="admin_dashboard.php"><i class="fas fa-home"></i> Dashboard</a></li>
        
        <li class="dropdown">
            <a href="#" class="dropdown-btn"><i class="fas fa-user-cog"></i> Mechanics <i class="fas fa-chevron-down"></i></a>
            <ul class="dropdown-menu">
                <li><a href="create_mechanics.php">Credential Mechanics</a></li>
                <li><a href="view_mechanices.php">View Mechanics</a></li>
            </ul>
        </li>

        <li class="dropdown">
            <a href="#" class="dropdown-btn"><i class="fas fa-tools"></i> Services <i class="fas fa-chevron-down"></i></a>
            <ul class="dropdown-menu">
                <li><a href="admin_user_services.php">Manage Services</a></li>
            </ul>
        </li>

        <li class="dropdown">
            <a href="#" class="dropdown-btn"><i class="fas fa-boxes"></i> Inventory <i class="fas fa-chevron-down"></i></a>
            <ul class="dropdown-menu">
                <li><a href="admin_inventory.php">Manage Inventory</a></li>
            </ul>
        </li>

        <li class="dropdown">
            <a href="#" class="dropdown-btn"><i class="fas fa-users"></i> Users <i class="fas fa-chevron-down"></i></a>
            <ul class="dropdown-menu">
                <li><a href="admin_u_view_requests.php">User Requests</a></li>
                <li><a href="manage_user.php">User manage</a></li>
            </ul>
        </li>

        <li><a href="billing.php"><i class="fas fa-file-invoice"></i> Generate Bill</a></li>
        <li><a href="reports.php"><i class="fas fa-chart-line"></i> reports</a></li>
        <li><a href="feedback_user.php"><i class="fas fa-chart-line"></i> Feedback</a></li>
        <li><a href="/RMYC_R/logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
    </ul>
</div>

<!-- Main Content 
<div class="content">
    <p>Manage.</p>
</div>-->

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
