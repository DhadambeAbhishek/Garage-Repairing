<?php
session_start();
include("../database/db_connect.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $invoice_number = $_POST['invoice_number'] ?? '';
    $payment_method = $_POST['payment_method'] ?? '';

    if (empty($invoice_number) || empty($payment_method)) {
        die("Error: Missing invoice number or payment method.");
    }

    // Get user_id from session
    $user_id = $_SESSION['user_id'];

    // ✅ Fetch Username
    $user_query = $mysqli->prepare("SELECT username FROM users WHERE user_id = ?");
    $user_query->bind_param("i", $user_id);
    $user_query->execute();
    $user_result = $user_query->get_result();
    
    if ($user_row = $user_result->fetch_assoc()) {
        $username = $user_row['username'];
    } else {
        $username = "Unknown User"; // Fallback in case username not found
    }

    // Different status for Cash payments
    $payment_status = ($payment_method === "Cash") ? "Pending" : "Paid";

    // ✅ Update Payment Status
    $sql = "UPDATE invoices SET status=?, payment_method=? WHERE invoice_number=?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("sss", $payment_status, $payment_method, $invoice_number);

    if ($stmt->execute()) {
        // ✅ Notify Admin with Username
        $message = "$username selected $payment_method for Invoice #$invoice_number.";
        $notif_stmt = $mysqli->prepare("INSERT INTO notifications (user_id, message, status) VALUES (?, ?, 'unread')");
        $notif_stmt->bind_param("is", $user_id, $message);
        $notif_stmt->execute();

        // ✅ Redirect based on payment method
        if ($payment_method === "Cash") {
            echo "<script>alert('Cash payment selected. Please pay at the counter.'); window.location.href='../user/user_dashboard.php';</script>";
        } else {
            print "<script>alert('Payment Successfully Done!'); </script>";
            header("Location: download_invoice.php?invoice=$invoice_number");
            exit();
        }
    } else {
        echo "❌ Payment failed. Try again.";
    }
}
?>
