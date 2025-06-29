<link rel="stylesheet" href="style.css">
<?php
session_start();
include("navbar.php"); 
include("../database/db_connect.php");

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'user') {
    header("Location: ../index.php"); // Use "../" if file is inside "user/" folder
    exit();
}
$user_id = $_SESSION['user_id'];

$query = "SELECT b.id, b.vehicle_type, b.total_price, b.booking_date, b.status, 
                 b.brand, b.model, GROUP_CONCAT(s.service_name SEPARATOR ', ') AS services 
          FROM bookingsreq b
          JOIN booking_servicess bs ON b.id = bs.booking_id
          JOIN services s ON bs.service_id = s.id
          WHERE b.user_id = ?
          GROUP BY b.id";

$stmt = $mysqli->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html>
<head>

    <title>Booking History</title>
    <style>
        /* General Table Styling */
table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
    background: #1f2937; /* Dark background */
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
}

/* Table Header */
th {
    background: #facc15; /* Gold header */
    color: #1f2937;
    font-size: 1rem;
    padding: 12px;
    text-align: left;
    border-bottom: 2px solid #facc15;
}

/* Table Data */
td {
    color: white;
    font-size: 0.95rem;
    padding: 12px;
    border-bottom: 1px solid rgba(255, 255, 255, 0.2);
}

/* Alternating Row Colors */
tr:nth-child(even) {
    background: rgba(255, 255, 255, 0.1);
}

tr:nth-child(odd) {
    background: rgba(255, 255, 255, 0.05);
}

/* Hover Effect */
tr:hover {
    background: rgba(255, 255, 255, 0.2);
    transition: 0.3s ease-in-out;
}

/* Responsive Design */
@media (max-width: 768px) {
    table {
        display: block;
        overflow-x: auto;
        white-space: nowrap;
    }

    th, td {
        font-size: 0.9rem;
        padding: 10px;
    }
}

    </style>
</head>
<body>
<div class="content">
    <h2>Your Booking History</h2>

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
            </tr>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['id']; ?></td>
                    <td><?= $row['vehicle_type']; ?></td>
                    <td><?= $row['services']; ?></td>
                    <td>₹<?= number_format($row['total_price'], 2); ?></td>
                    <td><?= $row['booking_date']; ?></td>
                    <td><?= $row['status']; ?></td>
                    <td><?= $row['brand']; ?></td>
                    <td><?= $row['model']; ?></td>
                </tr>
            <?php endwhile; ?>
        </table>
    <?php else: ?>
        <p>No booking history available.</p>
    <?php endif; ?>
</div>

</body>
</html>