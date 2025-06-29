<?php
/**
 * Template Name: user_dashboard
 */

session_start();
include("../database/db_connect.php");

// Debugging to check session variables
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'user') {
    header("Location: ../index.php"); // Use "../" if file is inside "user/" folder
    exit();
}
if (isset($_SESSION['login_success'])) {
    echo "<script>alert('" . $_SESSION['login_success'] . "');</script>";
    unset($_SESSION['login_success']);  // Remove message after displaying
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>User Dashboard</title>
</head>
<link rel="stylesheet" href="style.css">
<style>

   * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: Arial, sans-serif;
}

/* Main Container */
.containerpx {
    display: flex;
    align-items: center;
    justify-content: center;
    height: 100vh;
    padding: 20px;
    background-color: #f4f4f4;
}

/* Left Side (Image) */
.left {
    flex: 1;
    text-align: center;
}

.left img {
    max-width: 100%;
    height: auto;
    border-radius: 10px;
}

/* Right Side (Text + Button) */
.right {
    flex: 1;
    padding: 20px;
    text-align: center;
}

.right h2 {
    font-size: 28px;
    margin-bottom: 10px;
}

.right p {
    font-size: 18px;
    margin-bottom: 20px;
}

.btn {
    background-color: #007bff;
    color: #fff;
    padding: 12px 20px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 16px;
    transition: 0.3s;
}

.btn:hover {
    background-color: #0056b3;
}

/* Responsive Design */
@media (max-width: 768px) {
    .containerpx {
        flex-direction: column;
        text-align: center;
    }

    .left, .right {
        width: 100%;
    }
}
</style>
<body>
<nav>
<?php include("navbar.php"); ?>
<div class="container">
    <div class="containerpx">
        <!-- Left Side (Image) -->
        <div class="left">
            <img src="../uploads/home.png" alt="Car Service">
        </div>

        <!-- Right Side (Text + Button) -->
        <div class="right">
            <h2>Welcome to RMC Garage</h2>
            <p>We offer premium Car & Bike repair and maintenance services with expert mechanics.</p>
            <a href="book_request.php"><button class="btn">Book a Service</button></a>
            
        </div>
    </div>
</div>
<?php include 'footer.php'; ?>
</body>
</html>
