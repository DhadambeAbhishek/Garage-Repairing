<?php
session_start();
include("../database/db_connect.php");
include('functions.php');
// If session is set
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../index.php"); // Use "../" if file is inside "user/" folder
    exit();
}
if (isset($_POST['add_part'])) {
    $partName = $_POST['part_name'];
    $partType = $_POST['part_type'];
    $brand = $_POST['brand'];
    $model = $_POST['model'];
    $material = $_POST['material'];
    $quantity = $_POST['quantity'];
    echo addPart($partName, $partType, $brand, $model, $material, $quantity);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Inventory Management</title>
    <style>/* General Page Styling */
/* Main Inventory Container */
.inventory-container {
    max-width: 1200px;
    margin: 20px auto;
    padding: 20px;
    background: #ffffff;
    border-radius: 10px;
    box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.1);
}

/* Form Styling */
.inventory-container form {
    background: #f8f9fa;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.08);
    margin-bottom: 30px;
}

/* Form Labels */
.inventory-container label {
    display: block;
    font-weight: bold;
    margin: 10px 0 5px;
    color: #333;
}

/* Form Inputs & Select */
.inventory-container input, .inventory-container select {
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
    font-size: 16px;
    outline: none;
}

/* Submit Button */
.inventory-container input[type="submit"] {
    width: 100%;
    background-color: #007bff;
    color: white;
    padding: 12px;
    border: none;
    border-radius: 5px;
    font-size: 18px;
    cursor: pointer;
    margin-top: 15px;
    transition: background 0.3s ease-in-out;
}

.inventory-container input[type="submit"]:hover {
    background-color: #0056b3;
}

/* Inventory Table Styling */
.table-container {
    margin-top: 20px;
    background: #ffffff;
    padding: 15px;
    border-radius: 8px;
    box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
}

/* Table Headings */
.table-container h3 {
    color: #333;
    margin-bottom: 10px;
    font-size: 20px;
}

/* Table Design */
.table-container table {
    width: 100%;
    border-collapse: collapse;
    background: white;
}

/* Table Headers */
.table-container th {
    background: #007bff;
    color: white;
    padding: 12px;
    text-align: left;
}

/* Table Data */
.table-container td {
    padding: 10px;
    border-bottom: 1px solid #ddd;
}

/* Alternating Row Color */
.table-container tr:nth-child(even) {
    background: #f9f9f9;
}

/* Update Stock Button */
.table-container a {
    display: inline-block;
    padding: 8px 12px;
    background: #28a745;
    color: white;
    border-radius: 5px;
    text-decoration: none;
    transition: background 0.3s ease-in-out;
}

.table-container a:hover {
    background: #218838;
}

/* Responsive Design */
@media (max-width: 768px) {
    .inventory-container {
        width: 95%;
    }

    .table-container table, .table-container th, .table-container td {
        display: block;
        width: 100%;
    }

    .table-container th {
        text-align: center;
    }
}


</style>
</head>
<body>
<?php include("adm_navbar.php"); ?>
<div class="content">
<div class="inventory-container">
    <h1>Admin - Inventory Management</h1>

    <form method="POST" action="admin_inventory.php">
        <h2>Add Spare Part</h2>
        <label for="part_name">Part Name:</label>
        <input type="text" name="part_name" required>
        
        <label for="part_type">Part Type:</label>
        <select name="part_type">
            <option value="car">Car</option>
            <option value="bike">Bike</option>
        </select>
        
        <label for="brand">Brand:</label>
        <input type="text" name="brand" required>
        
        <label for="model">Model:</label>
        <input type="text" name="model" required>
        
        <label for="material">Material:</label>
        <input type="text" name="material" required>

        <label for="quantity">Quantity:</label>
        <input type="number" name="quantity" required>

        <input type="submit" name="add_part" value="Add Part">
    </form>

    <div class="table-container">
        <h3>Car Parts</h3>
        <table>
            <tr>
                <th>Part Name</th>
                <th>Brand</th>
                <th>Model</th>
                <th>Material</th>
                <th>Quantity</th>
                <th>Actions</th>
            </tr>
            <?php
            $carInventory = getInventory('car');
            while ($row = $carInventory->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['part_name']}</td>
                        <td>{$row['brand']}</td>
                        <td>{$row['model']}</td>
                        <td>{$row['material']}</td>
                        <td>{$row['quantity']}</td>
                        <td><a href='updatestock.php?id={$row['id']}'>Update Stock</a></td>
                    </tr>";
            }
            ?>
        </table>
    </div>

    <div class="table-container">
        <h3>Bike Parts</h3>
        <table>
            <tr>
                <th>Part Name</th>
                <th>Brand</th>
                <th>Model</th>
                <th>Material</th>
                <th>Quantity</th>
                <th>Actions</th>
            </tr>
            <?php
            $bikeInventory = getInventory('bike');
            while ($row = $bikeInventory->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['part_name']}</td>
                        <td>{$row['brand']}</td>
                        <td>{$row['model']}</td>
                        <td>{$row['material']}</td>
                        <td>{$row['quantity']}</td>
                        <td><a href='updatestock.php?id={$row['id']}'>Update Stock</a></td>
                    </tr>";
            }
            ?>
        </table>
    </div>
</div>

</body>
</html>
