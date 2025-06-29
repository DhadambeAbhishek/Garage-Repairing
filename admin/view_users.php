<?php
session_start();
include("../database/db_connect.php");

// Query to count total mechanics
$sql = "SELECT COUNT(*) AS total_user_list FROM bookings";
$result = $mysqli->query($sql);
$row = $result->fetch_assoc();
$total_users = $row['total_user_list'];

// Fetch users from database
$result = $mysqli->query("SELECT * FROM bookings");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Users</title>
    <style>
        .dashboard {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            display: inline-block;
            width: 300px;
        }
        .count {
            font-size: 24px;
            font-weight: bold;
            color: #007bff;
        }
        .container {
            max-width: 800px;
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
<div class="dashboard">
        <h2>Total users</h2>
        <p class="count"><?php echo $total_users; ?></p>
    </div>
    <h2>Registered Users</h2>
    
    <table>
        <tr>
            <th>User ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Vehicle_type</th>
            <th>Brand</th>
            <th>Registered Date</th>
        </tr>
        
        <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?= $row['user_id']; ?></td>
            <td><?= $row['name']; ?></td>
            <td><?= $row['email']; ?></td>
            <td><?= $row['phone']; ?></td>
            <td><?= $row['vehicle_type']; ?></td>
            <td><?= $row['brand']; ?></td>
            <td><?= $row['created_at']; ?></td>
            
        </tr>
        <?php endwhile; ?>
    </table>
</div>
</div>
</body>
</html>

<?php $mysqli->close(); ?>
