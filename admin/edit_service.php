<?php
session_start();
include("../database/db_connect.php");
// If session is set
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../index.php"); // Use "../" if file is inside "user/" folder
    exit();
}

$id = $_GET['id'];
$result = $mysqli->query("SELECT * FROM services WHERE id = $id");
$service = $result->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $vehicle_type = $_POST['vehicle_type'];
    $service_name = $_POST['service_name'];
    $price = $_POST['price'];

    $stmt = $mysqli->prepare("UPDATE services SET vehicle_type = ?, service_name = ?, price = ? WHERE id = ?");
    $stmt->bind_param("ssdi", $vehicle_type, $service_name, $price, $id);
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
form {
    width: 100%;
    max-width: 500px;
    margin: 0 auto;
    padding: 20px;
    border: 1px solid #ddd;
    border-radius: 8px;
    background-color: #f9f9f9;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    font-family: Arial, sans-serif;
}

/* Title of the form */
h2 {
    text-align: center;
    color: #333;
}

/* Style for labels */
label {
    display: block;
    margin-bottom: 8px;
    font-size: 14px;
    color: #333;
}

/* Style for select and input fields */
select, input[type="text"], input[type="number"] {
    width: 100%;
    padding: 10px;
    margin-bottom: 20px;
    border: 1px solid #ddd;
    border-radius: 4px;
    font-size: 14px;
}

/* Focus effect for inputs */
select:focus, input[type="text"]:focus, input[type="number"]:focus {
    border-color: #28a745;
    outline: none;
}

/* Style for submit button */
button {
    width: 100%;
    padding: 12px;
    background-color: #28a745;
    color: white;
    font-size: 16px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    transition: background-color 0.3s;
}

/* Button hover effect */
button:hover {
    background-color: #218838;
}
</style>
</head>
<body>
<?php include("adm_navbar.php"); ?>
<div class="content">
<h2>Edit Service</h2>
<form method="POST">
    <label>Vehicle Type:</label>
    <select name="vehicle_type">
        <option value="Bike" <?= $service['vehicle_type'] == 'Bike' ? 'selected' : ''; ?>>Bike</option>
        <option value="Car" <?= $service['vehicle_type'] == 'Car' ? 'selected' : ''; ?>>Car</option>
    </select>

    <label>Service Name:</label>
    <input type="text" name="service_name" value="<?= $service['service_name']; ?>" required>

    <label>Price (INR):</label>
    <input type="number" step="0.01" name="price" value="<?= $service['price']; ?>" required>

    <button type="submit">Update Service</button>
</form>
</div>
</body>
</html>


