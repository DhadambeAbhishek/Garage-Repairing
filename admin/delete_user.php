<?php
// Database connection
session_start();
include("../database/db_connect.php");

// Check if user_id is set
if (isset($_GET['user_id'])) {
    $user_id = $_GET['user_id'];

    // Delete query
    $stmt = $mysqli->prepare("DELETE FROM bookings WHERE user_id = ?");
    $stmt->bind_param("i", $user_id);

    if ($stmt->execute()) {
        echo "<script>alert('User deleted successfully!'); window.location='view_users.php';</script>";
    } else {
        echo "Error deleting user: " . $stmt->error;
    }

    $stmt->close();
}

$mysqli->close();
?>
