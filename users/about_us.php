<?php 
session_start();


include("../database/db_connect.php");

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'user') {
    header("Location: ../index.php"); // Use "../" if file is inside "user/" folder
    exit();
}

?>
<?php include("navbar.php"); ?>
<link rel="stylesheet" href="style.css">
<style>
    /* About Us Section */
.about-container {
    max-width: 900px;
    margin: 50px auto;
    background: white;
    padding: 30px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    border-radius: 8px;
}

.about-container h1 {
    color: #007bff;
    text-align: center;
}

.about-container p {
    font-size: 18px;
    line-height: 1.6;
    color: #555;
}

.about-container ul {
    list-style: none;
    padding: 0;
}

.about-container ul li {
    font-size: 18px;
    padding: 5px 0;
    color: #333;
}
</style>
<div class="content">
<div class="container">
<div class="about-container">
    <h1>About Us</h1>
    <p>Welcome to RMC&B Garage, your trusted partner in vehicle repair and maintenance. 
       We specialize in high-quality car services, ensuring your vehicle remains in top condition.</p>

    <h2>Why Choose Us?</h2>
    <ul>
        <li>✔ Expert Mechanics with Years of Experience</li>
        <li>✔ Affordable & Transparent Pricing</li>
        <li>✔ High-Quality Service with Original Parts</li>
        <li>✔ Quick Turnaround Time</li>
    </ul>

    <h2>Our Mission</h2>
    <p>We aim to provide professional and reliable car repair services while ensuring customer satisfaction.</p>

    <h2>Contact Us</h2>
    <p>Email: abhishek@rmcgarage.com</p>
    <p>Phone: +1 234 567 890</p>
</div>
</div>
</div>

<?php include 'footer.php'; ?>
