<?php
include('../admin/functions.php');



if (isset($_POST['request_part'])) {
    $partId = $_POST['part_id'];
    $requestQuantity = $_POST['request_quantity'];
    echo updateStock($partId, -$requestQuantity);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mechanic - Inventory Management</title>
    <style>/* Inventory Management Styling */
.inventory-container {
    background: #fff;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    font-family: 'Poppins', sans-serif;
    max-width: 100%;
    margin: auto;
    overflow-x: auto;
}

.inventory-container h1 {
    text-align: center;
    font-size: 28px;
    color: #333;
    margin-bottom: 15px;
}

.inventory-container h2 {
    font-size: 22px;
    color: #007bff;
    margin-top: 20px;
    border-bottom: 3px solid #007bff;
    display: inline-block;
    padding-bottom: 5px;
}

.inventory-container table {
    width: 100%;
    border-collapse: collapse;
    background: #fff;
    overflow: hidden;
    border-radius: 8px;
    margin-top: 15px;
}

.inventory-container th,
.inventory-container td {
    padding: 12px;
    text-align: center;
    border-bottom: 1px solid #ddd;
    font-size: 15px;
}

.inventory-container th {
    background: #007bff;
    color: #fff;
    font-weight: bold;
}

.inventory-container tr:nth-child(even) {
    background: #f9f9f9;
}

.inventory-container tr:hover {
    background: #f1f1f1;
}

.inventory-container input[type="number"] {
    width: 80px;
    padding: 5px;
    text-align: center;
    border: 1px solid #ddd;
    border-radius: 5px;
    font-size: 14px;
}

.inventory-container input[type="submit"] {
    background: #28a745;
    color: white;
    padding: 6px 12px;
    border: none;
    font-size: 14px;
    border-radius: 5px;
    cursor: pointer;
    transition: 0.3s ease;
}

.inventory-container input[type="submit"]:hover {
    background: #218838;
}
</style>
</head>
<body>
<?php include 'mechanic_nav.php'; ?>
<div class="inventory-container">

    <h1>Mechanic - Inventory Management</h1>

    <h2>Available Car Parts</h2>
    <table>
        <tr>
            <th>Part Name</th>
            <th>Brand</th>
            <th>Model</th>
            <th>Material</th>
            <th>Quantity</th>
            <th>Request Quantity</th>
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
                    <td>
                        <form method='POST' action='mechanic_inventory_request.php'>
                            <input type='number' name='request_quantity' min='1' max='{$row['quantity']}'>
                            <input type='hidden' name='part_id' value='{$row['id']}'>
                            <input type='submit' name='request_part' value='Request'>
                        </form>
                    </td>
                  </tr>";
        }
        ?>
    </table>

    <h2>Available Bike Parts</h2>
    <table>
        <tr>
            <th>Part Name</th>
            <th>Brand</th>
            <th>Model</th>
            <th>Material</th>
            <th>Quantity</th>
            <th>Request Quantity</th>
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
                    <td>
                        <form method='POST' action='mechanic_inventory_request.php'>
                            <input type='number' name='request_quantity' min='1' max='{$row['quantity']}'>
                            <input type='hidden' name='part_id' value='{$row['id']}'>
                            <input type='submit' name='request_part' value='Request'>
                        </form>
                    </td>
                  </tr>";
        }
        ?>
    </table>
    </div>
</body>
</html>
