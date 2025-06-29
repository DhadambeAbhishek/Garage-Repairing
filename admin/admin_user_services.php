<?php
session_start();
include("../database/db_connect.php");
// If session is set
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../index.php"); // Use "../" if file is inside "user/" folder
    exit();
}
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $mysqli->query("DELETE FROM services WHERE id = $id");
    header("Location: admin_services.php");
}

// Fetch All Services
$result = $mysqli->query("SELECT * FROM services");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>/* Style for the table */
/* General table styling */
table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
    background: #fff;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

/* Table headers */
th {
    background: #007bff;
    color: #fff;
    padding: 12px;
    text-align: left;
}

/* Table rows */
td {
    padding: 10px;
    border-bottom: 1px solid #ddd;
}

/* Alternate row background */
tr:nth-child(even) {
    background: #f9f9f9;
}

/* Hover effect */
tr:hover {
    background: #f1f1f1;
}

/* Add Service Button */
a[href="add_service.php"] {
    display: inline-block;
    background: #28a745;
    color: #fff;
    padding: 10px 15px;
    border-radius: 5px;
    text-decoration: none;
    font-weight: bold;
    margin-bottom: 10px;
}

a[href="add_service.php"]:hover {
    background: #218838;
}

/* Action Links (Edit & Delete) */
td a {
    padding: 5px 10px;
    text-decoration: none;
    font-weight: bold;
    border-radius: 3px;
}

/* Edit button */
td a[href^="edit_service.php"] {
    background: #ffc107;
    color: #212529;
}

td a[href^="edit_service.php"]:hover {
    background: #e0a800;
}

/* Delete button */
td a[href^="?delete="] {
    background: #dc3545;
    color: #fff;
}

td a[href^="?delete="]:hover {
    background: #c82333;
}

</style>
</head>
<body>
<?php include("adm_navbar.php"); ?>
<div class="content">
  <h2>Manage Services</h2>
  <a href="add_service.php">Add New Service</a>
  <table border="1">
    <tr>
        <th>ID</th>
        <th>Vehicle Type</th>
        <th>Service Name</th>
        <th>Price (INR)</th>
        <th>Actions</th>
    </tr>
    <?php while ($row = $result->fetch_assoc()) : ?>
        <tr>
            <td><?= $row['id']; ?></td>
            <td><?= $row['vehicle_type']; ?></td>
            <td><?= $row['service_name']; ?></td>
            <td>₹<?= number_format($row['price'], 2); ?></td>
            <td>
                <a href="edit_service.php?id=<?= $row['id']; ?>">Edit</a> | 
                <a href="?delete=<?= $row['id']; ?>" onclick="return confirm('Delete this service?')">Delete</a>
            </td>
        </tr>
    <?php endwhile; ?>
  </table>
</div>
</body>
</html>
