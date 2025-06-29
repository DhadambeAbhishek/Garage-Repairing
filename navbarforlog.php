<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Navigation Bar</title>
    <style>/* General Reset */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: Arial, sans-serif;
}

/* Navbar Styling */
.navbar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    background: #333;
    padding: 15px 20px;
}

.navbar .logo a {
    color: white;
    font-size: 22px;
    font-weight: bold;
    text-decoration: none;
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
    padding: 8px 12px;
    transition: 0.3s;
}

.nav-links a:hover {
    background: #007bff;
    border-radius: 5px;
}

/* Responsive Navbar */
@media screen and (max-width: 768px) {
    .navbar {
        flex-direction: column;
        text-align: center;
    }

    .nav-links {
        flex-direction: column;
        width: 100%;
        padding-top: 10px;
    }

    .nav-links li {
        margin-bottom: 10px;
    }
}
</style> <!-- Link to CSS -->
</head>
<body>

<nav class="navbar">
    <div class="logo">
        <a href="index.php">RMC&B Garage</a>
    </div>
    <ul class="nav-links">
        <li><a href="index.php">Home</a></li>
        <li><a href="login.php">Login</a></li>
        <li><a href="mechanic_login.php">Mechanic Login</a></li>
    </ul>
</nav>

</body>
</html>
