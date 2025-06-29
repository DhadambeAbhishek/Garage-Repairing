<?php
session_start();
include("../database/db_connect.php"); // Database connection

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../index.php"); // Use "../" if file is inside "user/" folder
    exit();
}
// Check if booking ID is provided
if (!isset($_GET['id'])) {
    echo "Invalid request.";
    exit();
}

$booking_id = $_GET['id'];

// Fetch booking details
$sql = "SELECT * FROM bookings WHERE id = ?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("i", $booking_id);
$stmt->execute();
$result = $stmt->get_result();
$booking = $result->fetch_assoc();

if (!$booking) {
    echo "Booking not found!";
    exit();
}

// Fetch available mechanics
$mechanic_sql = "SELECT * FROM mechanics WHERE status = 'Active'";
$mechanic_result = $mysqli->query($mechanic_sql);

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $new_status = $_POST['status'];
    $assigned_mechanic = $_POST['assigned_mechanic'];

    // Update the booking with new status and assigned mechanic
    $update_sql = "UPDATE bookings SET status = ?, assigned_mechanic = ? WHERE id = ?";
    $stmt = $mysqli->prepare($update_sql);
    $stmt->bind_param("sii", $new_status, $assigned_mechanic, $booking_id);

    if ($stmt->execute()) {
        echo "<script>alert('Booking updated successfully!'); </script>";
    } else {
        echo "Error updating booking: " . $mysqli->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Booking</title>
</head>
<body>
<?php include("adm_navbar.php"); ?>
<div class="content">
<h2>Edit Booking # <?php echo $booking_id; ?></h2>
<form method="post">
<label>Service Type:</label>
    <input type="text" name="service_type" value="<?php echo $booking['service_type']; ?>" readonly>

<label>Status:</label>
    <select name="status">
        <option value="Pending" <?php if ($booking['status'] == 'Pending') echo 'selected'; ?>>Pending</option>
        <option value="Processing" <?php if ($booking['status'] == 'Processing') echo 'selected'; ?>>Processing</option>
        <option value="Completed" <?php if ($booking['status'] == 'Completed') echo 'selected'; ?>>Completed</option>
    </select>

    <label>Assign Mechanic:</label>
    <select name="assigned_mechanic">
        <option value="">Select Mechanic</option>
        <?php while ($mechanic = $mechanic_result->fetch_assoc()) { ?>
            <option value="<?php echo $mechanic['mechanic_id']; ?>" 
                <?php if ($booking['assigned_mechanic'] == $mechanic['mechanic_id']) echo 'selected'; ?>>
                <?php echo $mechanic['fullname']; ?> (<?php echo $mechanic['status']; ?>)
            </option>
        <?php } ?>
    </select>

    <button type="submit">Update</button>
</form>
</div>
</body>
</html>