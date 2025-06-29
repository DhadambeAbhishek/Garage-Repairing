<?php
// Database connection
session_start();
include("../database/db_connect.php");

// Fetch bookings from the database
$result = $mysqli->query("SELECT bookings.*, users.id AS user_id, users.email AS user_email 
                         FROM bookings 
                          JOIN users ON bookings.user_id = users.id;");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Bookings</title>
    <style>
        .container {
            max-width: 900px;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #007bff;
            color: white;
        }
        .action-btn {
            padding: 5px 10px;
            text-decoration: none;
            color: white;
            border-radius: 5px;
        }
        .edit-btn {
            background-color: #28a745;
        }
        .delete-btn {
            background-color: #dc3545;
        }
        .edit-btn:hover {
            background-color: #218838;
        }
        .delete-btn:hover {
            background-color: #c82333;
        }
    </style>
</head>
<body>
<?php include("adm_navbar.php"); ?>
<div class="content">
 <div class="container">
    <h2>User Bookings</h2>
    
    <table>
        <tr>
            <th>Booking ID</th>
            <th>User Name</th>
            <th>Email</th>
            <th>Service Name</th>
            <th>Booking Date</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
        
        <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?= $row['id']; ?></td>
            <td><?= $row['name']; ?></td>
            <td><?= $row['email']; ?></td>
            <td><?= $row['service_type']; ?></td>
            <td><?= $row['created_at']; ?></td>
            <td><?= ucfirst($row['status']); ?></td>
            <td>
                <a href="delete_booking.php?id=<?= $row['id']; ?>" class="action-btn delete-btn" onclick="return confirm('Are you sure you want to delete this booking?');">Delete</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
 </div>
</div>
</body>
</html>

<?php $mysqli->close(); ?>
