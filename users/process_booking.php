<?php
session_start();
include("../database/db_connect.php");

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'user') {
    header("Location: ../index.php"); // Use "../" if file is inside "user/" folder
    exit();
}
$user_id = $_SESSION['user_id'];
$vehicle_type = $_POST['vehicle_type'];
$brand = $_POST['brand'];
$model = $_POST['model'];
$name = $_POST['name'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$total_price = 0;
$booking_date = date("Y-m-d H:i:s");

// 🚀 **Fix: Ensure services are selected**
if (!isset($_POST['service_type']) || !is_array($_POST['service_type'])) {
    die("Error: No services selected.");
}

$selected_services = $_POST['service_type']; // Array of selected services

// Fetch service prices and calculate total price
$service_ids = [];
foreach ($selected_services as $service_name) {
    $query = "SELECT id, price FROM services WHERE service_name = ?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("s", $service_name);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($row = $result->fetch_assoc()) {
        $service_ids[] = $row['id'];
        $total_price += $row['price'];
    }
}

// 🚀 **Step 1: Insert into `bookings` table**
$query = "INSERT INTO bookingsreq (user_id, vehicle_type, total_price, booking_date, status, brand, model, name, email, phone) 
          VALUES (?, ?, ?, ?, 'Pending', ?, ?, ?, ?, ?)";
$stmt = $mysqli->prepare($query);
$stmt->bind_param("isdssssss", $user_id, $vehicle_type, $total_price, $booking_date, $brand, $model, $name, $email, $phone);
$stmt->execute();
$booking_id = $stmt->insert_id; // Get the last inserted booking ID

// 🚀 **Step 2: Insert multiple services into `booking_services` table**
foreach ($service_ids as $service_id) {
    $query = "INSERT INTO booking_servicess (booking_id, service_id) VALUES (?, ?)";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("ii", $booking_id, $service_id);
    $stmt->execute();
}

echo "<script>alert('successfully book!'); window.location='book_request.php';</script>";
?>