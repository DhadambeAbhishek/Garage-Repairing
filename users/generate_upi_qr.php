<?php
$upi_id = "your_upi_id@upi"; // Replace with your actual UPI ID
$payee_name = "Your Business Name";
$amount = isset($_GET['amount']) ? $_GET['amount'] : "1.00"; // Get amount from the request
$txn_note = "Garage Service Payment";
$upi_url = "upi://pay?pa=$upi_id&pn=$payee_name&am=$amount&tn=$txn_note&cu=INR";

// Generate QR Code using Google API
$qr_code_url = "https://chart.googleapis.com/chart?chs=250x250&cht=qr&chl=" . urlencode($upi_url);
echo json_encode(["qr_code" => $qr_code_url, "upi_url" => $upi_url]);
?>
