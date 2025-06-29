<?php
session_start();
include("../database/db_connect.php");
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../index.php"); // Use "../" if file is inside "user/" folder
    exit();
}
if (isset($_GET['id'])) {
    $booking_id = intval($_GET['id']);

    // Delete the booking
    $sql = "DELETE FROM bookingsreq WHERE id = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("i", $booking_id);

    if ($stmt->execute()) {
        echo "<script>alert('Booking deleted successfully!'); window.location.href='admin_u_view_requests.php';</script>";
    } else {
        echo "<script>alert('Error deleting booking!'); window.location.href='admin_u_view_requests.php';</script>";
    }

    $stmt->close();
    $conn->close();
} else {
    echo "<script>alert('Invalid request!'); window.location.href='admin_u_view_requests.php';</script>";
}
?>