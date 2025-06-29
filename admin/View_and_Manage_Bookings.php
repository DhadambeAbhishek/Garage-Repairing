<?php
session_start();
include("../database/db_connect.php"); // Database connection

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../index.php"); // Use "../" if file is inside "user/" folder
    exit();
}

// Fetch user booking requests
$sql = "SELECT b.id, u.username AS username, b.vehicle_type, b.brand, b.model, 
        b.service_type, b.status, m.fullname AS mechanic_name
        FROM bookings b
        JOIN users u ON b.user_id = u.id
        LEFT JOIN mechanics m ON b.assigned_mechanic = m.mechanic_id";

$result = $mysqli->query($sql);


// Fetch available mechanics
$mechanic_sql = "SELECT * FROM mechanics WHERE status = 'Active'";
$mechanics = $mysqli->query($mechanic_sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Manage Bookings</title>
    <style>
        body { font-family: Arial, sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 10px; border: 1px solid #ddd; text-align: center; }
        th { background-color: #007bff; color: white; }
        .btn { padding: 5px 10px; text-decoration: none; color: white; border-radius: 5px; }
        .edit-btn { background-color: #28a745; }
        .delete-btn { background-color: #dc3545; }
    </style>
</head>
<body>
<?php include("adm_navbar.php"); ?>
<div class="content">
<h2>Manage User Booking Requests</h2>

<table>
    <tr>
        <th>ID</th>
        <th>User</th>
        <th>Vehicle Type</th>
        <th>Brand</th>
        <th>Model</th>
        <th>Service Type</th>
        <th>Status</th>
        <th>Assigned Mechanic</th>
        <th>Actions</th>
    </tr>
    
    <?php while ($row = $result->fetch_assoc()) { ?>
        <tr>
            <td><?php echo $row['id']; ?></td>
            <td><?php echo $row['username']; ?></td>
            <td><?php echo $row['vehicle_type']; ?></td>
            <td><?php echo $row['brand']; ?></td>
            <td><?php echo $row['model']; ?></td>
            <td><?php echo $row['service_type']; ?></td>
            <td><?php echo $row['status'];?></td>
            <td><?php echo ($row['mechanic_name']) ? $row['mechanic_name'] : 'Not Assigned'; ?></td>
            <td>
                <a href="edit_booking.php?id=<?php echo $row['id']; ?>" class="btn edit-btn">Edit</a>
            </td>
        </tr>
    <?php } ?>
</table>
    </div>
</body>
</html>
