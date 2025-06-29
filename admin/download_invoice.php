<?php
session_start();
require_once __DIR__ . '/../database/tcpdf/tcpdf.php';
include("../database/db_connect.php");

// ✅ Check User Role (Admin or User)
if (!isset($_SESSION['user_id']) || !in_array($_SESSION['role'], ['admin', 'user'])) {
    die("Unauthorized access.");
}

// ✅ Get Invoice Number from URL
if (!isset($_GET['invoice']) && !isset($_GET['id'])) {
    die("Error: Invoice number is missing.");
}

$invoice_number = isset($_GET['invoice']) ? $_GET['invoice'] : '';
$booking_id = isset($_GET['id']) ? $_GET['id'] : '';

if (!empty($invoice_number)) {
    // ✅ Fetch Invoice Details by Invoice Number (For Users)
    $sql = "SELECT i.*, u.username, u.email, b.phone, b.brand, b.model, b.vehicle_type, 
            GROUP_CONCAT(s.service_name SEPARATOR ', ') AS services 
            FROM invoices i 
            JOIN bookingsreq b ON i.booking_id = b.id 
            JOIN users u ON i.user_id = u.id 
            LEFT JOIN booking_servicess bs ON b.id = bs.booking_id 
            LEFT JOIN services s ON bs.service_id = s.id 
            WHERE i.invoice_number = ? AND i.status = 'Paid'";

    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("s", $invoice_number);
} elseif (!empty($booking_id)) {
    // ✅ Fetch Invoice Details by Booking ID (For Admin)
    $sql = "SELECT i.*, u.username, u.email, b.phone, b.brand, b.model, b.vehicle_type, 
            GROUP_CONCAT(s.service_name SEPARATOR ', ') AS services 
            FROM invoices i 
            JOIN bookingsreq b ON i.booking_id = b.id 
            JOIN users u ON i.user_id = u.id 
            LEFT JOIN booking_servicess bs ON b.id = bs.booking_id 
            LEFT JOIN services s ON bs.service_id = s.id 
            WHERE b.id = ? AND i.status = 'Paid'";

    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("i", $booking_id);
}

$stmt->execute();
$result = $stmt->get_result();
$invoice = $result->fetch_assoc();

if (!$invoice) {
    die("Error: No paid invoice found.");
}

// ✅ Generate PDF Invoice
$pdf = new TCPDF();
$pdf->AddPage();
$pdf->SetFont('Helvetica', '', 12);

$content = "
    <h2>PAID INVOICE</h2>
    <p><strong>Invoice ID:</strong> {$invoice['invoice_number']}</p>
    <p><strong>Customer:</strong> {$invoice['username']}</p>
    <p><strong>Email:</strong> {$invoice['email']}</p>
    <p><strong>Phone:</strong> {$invoice['phone']}</p>
    <p><strong>Vehicle:</strong> {$invoice['brand']} - {$invoice['model']} ({$invoice['vehicle_type']})</p>
    <p><strong>Services:</strong> {$invoice['services']}</p>
    <p><strong>Total Price:</strong> ₹" . number_format($invoice['total_amount'], 2) . "</p>
    <hr>
    <p><b>Payment Status:</b> ✅ Paid</p>
    <p>Thank you,<br>RMC Garage</p>";

$pdf->writeHTML($content);
$pdf->Output("Paid_Invoice_{$invoice['invoice_number']}.pdf", "D");
?>
