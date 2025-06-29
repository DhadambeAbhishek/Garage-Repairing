<?php
session_start();
include("../database/db_connect.php");

// Check if the mechanic is logged in
if (!isset($_SESSION['mechanic_id']) || empty($_SESSION['fullname'])) {
    header("Location: mechanic_login.php");
    exit();
}

// Display login success message
if (isset($_SESSION['login_success'])) {
    echo "<script>alert('" . $_SESSION['login_success'] . "');</script>";
    unset($_SESSION['login_success']);  // Remove message after displaying
}


// Get mechanic details
// Get mechanic details
$mechanic_id = $_SESSION['mechanic_id'];

// Fetch assigned bookings
$sql = "SELECT b.id, b.vehicle_type, GROUP_CONCAT(s.service_name SEPARATOR ', ') AS services, 
               b.total_price, b.booking_date, b.status, b.brand, b.model, b.name, b.phone 
        FROM bookingsreq b
        JOIN users u ON b.user_id = u.id
        LEFT JOIN booking_servicess bs ON b.id = bs.booking_id
        LEFT JOIN services s ON bs.service_id = s.id
        WHERE b.mechanic_id = ?
        GROUP BY b.id";

$stmt = $mysqli->prepare($sql);
$stmt->bind_param("i", $mechanic_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assigned Tasks - Mechanic Panel</title>
    <link rel="stylesheet" href="../styles.css"> <!-- Link to external CSS -->
    <style>
        /* Assigned Bookings Table Styling */
.assigned-bookings-container {
    background: #fff;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    font-family: 'Poppins', sans-serif;
    max-width: 100%;
    margin: auto;
    overflow-x: auto;
}

.assigned-bookings-container h2 {
    font-size: 24px;
    color: #333;
    text-align: center;
    margin-bottom: 15px;
}

.assigned-bookings-container table {
    width: 100%;
    border-collapse: collapse;
    background: #fff;
    overflow: hidden;
    border-radius: 8px;
}

.assigned-bookings-container th,
.assigned-bookings-container td {
    padding: 12px;
    text-align: center;
    border-bottom: 1px solid #ddd;
    font-size: 15px;
}

.assigned-bookings-container th {
    background: #007bff;
    color: #fff;
    font-weight: bold;
}

.assigned-bookings-container tr:nth-child(even) {
    background: #f9f9f9;
}

.assigned-bookings-container tr:hover {
    background: #f1f1f1;
}

.assigned-bookings-container .btn {
    background: #28a745;
    color: white;
    padding: 6px 12px;
    text-decoration: none;
    font-size: 14px;
    border-radius: 5px;
    display: inline-block;
    transition: 0.3s ease;
}

.assigned-bookings-container .btn:hover {
    background: #218838;
}

.no-tasks {
    text-align: center;
    font-size: 16px;
    color: #888;
    margin-top: 10px;
}

    </style>
</head>
<body>
    <?php include 'mechanic_nav.php'; ?>
    <div class="assigned-bookings-container">
    <h2>Assigned Bookings</h2>

    <?php if ($result->num_rows > 0): ?>
        <table>
            <tr>
                <th>ID</th>
                <th>Vehicle Type</th>
                <th>Services</th>
                <th>Total Price</th>
                <th>Booking Date</th>
                <th>Status</th>
                <th>Brand</th>
                <th>Model</th>
                <th>Customer Name</th>
                <th>Phone</th>
                <th>Update Status</th>
            </tr>

            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['id']); ?></td>
                    <td><?= htmlspecialchars($row['vehicle_type']); ?></td>
                    <td><?= htmlspecialchars($row['services']); ?></td>
                    <td>₹<?= number_format($row['total_price'], 2); ?></td>
                    <td><?= date("d M Y", strtotime($row['booking_date'])); ?></td>
                    <td><strong><?= htmlspecialchars($row['status']); ?></strong></td>
                    <td><?= htmlspecialchars($row['brand']); ?></td>
                    <td><?= htmlspecialchars($row['model']); ?></td>
                    <td><?= htmlspecialchars($row['name']); ?></td>
                    <td><?= htmlspecialchars($row['phone']); ?></td>
                    <td>
                        <a href="update_status.php?id=<?= $row['id']; ?>" class="btn">Update</a>
                    </td>
                </tr>
            <?php endwhile; ?>

        </table>
    <?php else: ?>
        <p class="no-tasks">No assigned tasks yet.</p>
    <?php endif; ?>
    </div>
</body>
</html>

<?php
$stmt->close();
$mysqli->close();
?>