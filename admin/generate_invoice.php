<?php
session_start();
require_once __DIR__ . '/../database/tcpdf/tcpdf.php';
include("../database/db_connect.php");

// Check if Booking ID is provided
if (!isset($_GET['id'])) {
    die("Error: Booking ID is missing.");
}

$booking_id = $_GET['id'];

// ✅ Fetch booking details (including user_id)
$sql = "SELECT b.id, b.user_id, b.total_price, b.name, b.email, b.phone, 
        b.brand, b.model, b.vehicle_type, b.booking_date, 
        GROUP_CONCAT(s.service_name SEPARATOR ', ') AS services 
        FROM bookingsreq b 
        JOIN users u ON b.user_id = u.id 
        LEFT JOIN booking_servicess bs ON b.id = bs.booking_id 
        LEFT JOIN services s ON bs.service_id = s.id 
        WHERE b.id = ?";

$stmt = $mysqli->prepare($sql);
$stmt->bind_param("i", $booking_id);
$stmt->execute();
$result = $stmt->get_result();
$booking = $result->fetch_assoc();

if (!$booking) {
    die("Error: Invalid Booking ID.");
}

// ✅ Assign user_id from fetched data
$user_id = $booking['user_id'];
$total_amount = $booking['total_price'];
$status = 'Pending';

// ✅ Generate Unique Invoice Number
$invoice_number = "INV" . str_pad($booking_id, 5, "0", STR_PAD_LEFT);

// ✅ Insert invoice record
$stmt = $mysqli->prepare("INSERT INTO invoices (user_id, booking_id, invoice_number, total_amount, status) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("iisss", $user_id, $booking_id, $invoice_number, $total_amount, $status);
$stmt->execute();

// ✅ Generate PDF Invoice
$pdf = new TCPDF();
$pdf->AddPage();
$pdf->SetFont('Helvetica', '', 12);

$content = "
    <h2>Invoice</h2>
    <p><strong>Invoice ID:</strong> {$invoice_number}</p>
    <p><strong>Customer:</strong> {$booking['name']}</p>
    <p><strong>Email:</strong> {$booking['email']}</p>
    <p><strong>Phone:</strong> {$booking['phone']}</p>
    <p><strong>Vehicle:</strong> {$booking['brand']} - {$booking['model']} ({$booking['vehicle_type']})</p>
    <p><strong>Services:</strong> {$booking['services']}</p>
    <p><strong>Total Price:</strong> ₹" . number_format($total_amount, 2) . "</p>
    <p><strong>Date:</strong> " . date("d M Y", strtotime($booking['booking_date'])) . "</p>
    <hr>
    <p>Thank you for choosing our service!</p>
    <p><b>Payment Status:</b> Pending</p>
    <p><a href='payment.php?invoice={$invoice_number}'>Click here to Pay Now</a></p>
    <p>Thank you,<br>RMC Garage</p>";

$pdf->writeHTML($content);
$pdf->Output("Invoice_$invoice_number.pdf", "D");
?>
