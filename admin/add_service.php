<?php
session_start();
include("../database/db_connect.php");
// If session is set
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../index.php"); // Use "../" if file is inside "user/" folder
    exit();
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $vehicle_type = $_POST['vehicle_type'];
    $service_name = $_POST['service_name'];
    $price = $_POST['price'];

    $stmt = $mysqli->prepare("INSERT INTO services (vehicle_type, service_name, price) VALUES (?, ?, ?)");
    $stmt->bind_param("ssd", $vehicle_type, $service_name, $price);
    $stmt->execute();

    header("Location: admin_user_services.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>/* General form styles */
/* Target only the "Add New Service" form */
.service-form {
    max-width: 400px;
    margin: 20px auto;
    padding: 20px;
    background: #ffffff;
    border-radius: 8px;
    box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
}

/* Label styling */
.service-form label {
    font-weight: bold;
    display: block;
    margin: 10px 0 5px;
    color: #333;
}

/* Input and Select Styling */
.service-form input, .service-form select {
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
    font-size: 16px;
    outline: none;
}

/* Button Styling */
.service-form button {
    width: 100%;
    background-color: #007bff;
    color: white;
    padding: 10px;
    border: none;
    border-radius: 5px;
    font-size: 18px;
    cursor: pointer;
    margin-top: 15px;
    transition: background 0.3s ease-in-out;
}

.service-form button:hover {
    background-color: #0056b3;
}

/* Responsive Styling */
@media (max-width: 768px) {
    .service-form {
        width: 90%;
    }
}

</style>
</head>
<body>
<?php include("adm_navbar.php"); ?>
<div class="content">
 <h2>Add New Service</h2>
<form method="POST" class="service-form">
    <label>Vehicle Type:</label>
    <select name="vehicle_type" required>
        <option value="Bike">Bike</option>
        <option value="Car">Car</option>
    </select>

    <label>Service Name:</label>
    <input type="text" name="service_name" required>

    <label>Price (INR):</label>
    <input type="number" step="0.01" name="price" required>

    <button type="submit">Add Service</button>
</form>
</div>
</body>
</html>
