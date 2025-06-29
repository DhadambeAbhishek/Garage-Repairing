<?php
session_start();
include("../database/db_connect.php");
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../index.php"); // Use "../" if file is inside "user/" folder
    exit();
}
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $booking_id = $_POST['booking_id'];
    $status = $_POST['status'];

    $stmt = $mysqli->prepare("UPDATE bookingsreq SET status = ? WHERE id = ?");
    $stmt->bind_param("si", $status, $booking_id);

    if ($stmt->execute()) {
        echo "<script>alert('Status updated successfully.!'); </script>";
            header("Location:admin_u_view_requests.php");
    } else {
        echo "Error updating status.";
    }
}
?>