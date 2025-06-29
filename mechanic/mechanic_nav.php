<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mechanic Dashboard</title>
    <style>* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: Arial, sans-serif;
}

.navbar {
    background: #333;
    color: white;
    padding: 15px 20px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.nav-links {
    list-style: none;
    display: flex;
}

.nav-links li {
    margin: 0 15px;
}

.nav-links a {
    text-decoration: none;
    color: white;
    font-size: 16px;
}

.nav-links a:hover {
    color: #f0a500;
}

.logout-btn {
    background: red;
    padding: 8px 12px;
    border-radius: 5px;
}

.logout-btn:hover {
    background: darkred;
}
</style>
</head>
<body>

    <nav class="navbar">
        <div class="logo">
            <h2>Mechanic Panel</h2>
        </div>
        <ul class="nav-links">
            <li><a href="mechanic_dashboard.php">Dashboard</a></li>
            <li><a href="mechanic_view_tasks.php">View Tasks</a></li>
            <li><a href="mechanic_inventory_request.php">Request Parts </a></li>
            <li><a href="mechanic_profile.php">Profile</a></li>
            <li><a href="change_password.php">Change Password</a></li>
            <li><a href="..\logout.php" class="logout-btn">Logout</a></li>
        </ul>
    </nav>

</body>
</html>
