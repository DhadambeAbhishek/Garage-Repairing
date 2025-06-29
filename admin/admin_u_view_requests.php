<?php
session_start();
include("../database/db_connect.php");
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../index.php"); // Use "../" if file is inside "user/" folder
    exit();
}

// Fetch all booking requests
$query = "SELECT b.id, b.vehicle_type, GROUP_CONCAT(s.service_name SEPARATOR ', ') AS services, 
                 b.total_price, b.booking_date, b.status, b.brand, b.model, 
                 b.name, b.email, b.phone, m.fullname 
          FROM bookingsreq b
          LEFT JOIN booking_servicess bs ON b.id = bs.booking_id
          LEFT JOIN services s ON bs.service_id = s.id
          LEFT JOIN mechanics m ON b.mechanic_id = m.mechanic_id
          GROUP BY b.id";

$result = $mysqli->query($query);
?>

<!DOCTYPE html>
<html>

<head>
    <title>Manage Booking Requests</title>
    <style>/* Booking Requests Section */
h2 {
    text-align: center;
    color: #222;
    font-size: 26px;
    margin-bottom: 15px;
}

/* Scrollable Table Container */
.table-container {
    width: 95%;
    margin: 0 auto;
    overflow-x: auto;
    overflow-y: auto;
    max-height: 500px; /* Adjust vertical height */
    border: 1px solid #ddd;
    border-radius: 5px;
    background: #fff;
    padding: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

/* Booking Requests Table */
table {
    width: 100%;
    border-collapse: collapse;
    min-width: 1200px; /* Ensures scrolling for smaller screens */
}

/* Table Headers */
th {
    background: #343a40;
    color: white;
    text-align: left;
    padding: 12px;
    position: sticky;
    top: 0;
    z-index: 2;
}

/* Table Cells */
td {
    padding: 10px;
    border-bottom: 1px solid #ddd;
    white-space: nowrap; /* Prevents text wrapping */
}

/* Hover Effect */
tr:hover {
    background: #f8f9fa;
}

/* Buttons */
.btn {
    padding: 8px 12px;
    border-radius: 4px;
    font-size: 14px;
    text-decoration: none;
    color: white;
    font-weight: bold;
    display: inline-block;
    text-align: center;
    transition: 0.3s ease-in-out;
}

/* Assign Button - Blue */
.btn-assign {
    background: #007bff;
}

.btn-assign:hover {
    background: #0056b3;
}

/* Status Button - Orange */
.btn-status {
    background: #fd7e14;
    color: white;
}

.btn-status:hover {
    background: #e65100;
}

/* Delete Button - Red */
.btn-delete {
    background: #dc3545;
}

.btn-delete:hover {
    background: #b02a37;
}

/* Responsive Design */
@media (max-width: 768px) {
    .table-container {
        width: 100%;
    }
    
    table {
        min-width: 1000px; /* Ensures horizontal scrolling */
    }
}
</style>
</head>

<body>
    <?php include("adm_navbar.php"); ?>
    <div class="content">
        <h2>Booking Requests</h2>
        <div class="table-container">
        <table>
            <tr>
                <th>ID</th>
                <th>Vehicle Type</th>
                <th>Services</th>
                <th>Total Price</th>
                <th>Booking Date</th>
                <th>Brand</th>
                <th>Model</th>
                <th>Customer Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Mechanic</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td>
                    <?= $row['id']; ?>
                </td>
                <td>
                    <?= $row['vehicle_type']; ?>
                </td>
                <td>
                    <?= $row['services']; ?>
                </td>
                <td>₹
                    <?= number_format($row['total_price'], 2); ?>
                </td>
                <td>
                    <?= $row['booking_date']; ?>
                </td>
                <td>
                    <?= $row['brand']; ?>
                </td>
                <td>
                    <?= $row['model']; ?>
                </td>
                <td>
                    <?= $row['name']; ?>
                </td>
                <td>
                    <?= $row['email']; ?>
                </td>
                <td>
                    <?= $row['phone']; ?>
                </td>
                <td>
                    <?= isset($row['fullname']) ? $row['fullname'] : "Not Assigned"; ?>
                </td>
                <td>
                    <?= $row['status']; ?>
                </td>
                <td>
                    <a href="assign_mechanic.php?id=<?= $row['id']; ?>" class="btn btn-assign">Assign</a>
                    <a href="update_status.php?id=<?= $row['id']; ?>" class="btn btn-status">Change Status</a>
                    <a href="delete_booking.php?id=<?= $row['id']; ?>" class="btn btn-delete"
                        onclick="return confirm('Are you sure you want to delete this booking?');">Delete</a>
                </td>

            </tr>
            <?php endwhile; ?>
        </table>
        </div>
    </div>
</body>

</html>