<?php
session_start();
include("../database/db_connect.php");
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../index.php"); // Use "../" if file is inside "user/" folder
    exit();
}
$sql = "SELECT b.id, b.name, b.email, b.brand, b.model, b.vehicle_type, 
               GROUP_CONCAT(s.service_name SEPARATOR ', ') AS services, 
               b.total_price, b.booking_date 
        FROM bookingsreq b
        LEFT JOIN booking_servicess bs ON b.id = bs.booking_id
        LEFT JOIN services s ON bs.service_id = s.id
        WHERE b.status = 'Completed'  -- ✅ Filter only completed bookings
        GROUP BY b.id";

$result = $mysqli->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Billing - Admin Panel</title>
    <style>.main-content {
    padding: 20px;
    background: #f8f9fa; /* Light grey background */
    border-radius: 10px;
}

h1, h2 {
    color: #333;
    margin-bottom: 15px;
}

table {
    width: 100%;
    border-collapse: collapse;
    background: #fff;
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0px 2px 10px rgba(0, 0, 0, 0.1);
}

th, td {
    padding: 12px 15px;
    text-align: left;
    border-bottom: 1px solid #ddd;
}

th {
    background: #007bff;
    color: white;
    font-weight: bold;
    text-transform: uppercase;
}

tr:hover {
    background: #f1f1f1; /* Light hover effect */
}

td small {
    color: #777;
    font-size: 12px;
}

.btn {
    display: inline-block;
    background: #28a745;
    color: white;
    padding: 6px 12px;
    border-radius: 5px;
    text-decoration: none;
    font-weight: bold;
}

.btn:hover {
    background: #218838;
}

</style>
</head>
<body>
<?php include("adm_navbar.php"); ?>
<div class="content">
<div class="main-content">
    <header>
        <h1>Billing & Invoices</h1>
    </header>

    <h2>Completed Service Records</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Customer</th>
            <th>Vehicle</th>
            <th>Services</th>
            <th>Total Price</th>
            <th>Booking Date</th>
            <th>Actions</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= $row['id']; ?></td>
                <td><?= $row['name']; ?> <br> <small><?= $row['email']; ?></small></td>
                <td><?= $row['brand']; ?> - <?= $row['model']; ?> (<?= $row['vehicle_type']; ?>)</td>
                <td><?= $row['services']; ?></td>
                <td>₹<?= number_format($row['total_price'], 2); ?></td>
                <td><?= date("d M Y", strtotime($row['booking_date'])); ?></td>
                <td>
                    <a href="generate_invoice.php?id=<?= $row['id']; ?>" class="btn">🧾 Generate Invoice</a>
                    <a href="download_invoice.php?id=<?= $row['id']; ?>" class="btn">🧾 Download Invoice</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>
</div>

</div>
</body>
</html>
