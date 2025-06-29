<?php
session_start();
include("../database/db_connect.php");

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'user') {
    header("Location: ../index.php");
    exit();
}
// Include navbar
include("navbar.php");

// Get the correct invoice number key from URL
// Get the invoice number from URL
$invoice_number = isset($_GET['invoice']) ? $_GET['invoice'] : '';

$invoice = [];
$status = "";

// Fetch invoice details (total_amount & status in one query)
if (!empty($invoice_number)) {
    $stmt = $mysqli->prepare("SELECT total_amount, status FROM invoices WHERE invoice_number = ?");
    $stmt->bind_param("s", $invoice_number);
    $stmt->execute();
    $result = $stmt->get_result();
    $invoice = $result->fetch_assoc();

    if ($invoice) {
        $status = $invoice['status'];
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment</title>
    <script src="https://js.stripe.com/v3/"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/instascan/1.0.0/instascan.min.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            padding: 20px;
            background-color: #f9f9f9;
        }
        .payment-container {
            max-width: 500px;
            margin: auto;
            padding: 20px;
            background: white;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }
        h2, h3 {
            text-align: center;
        }
        select, input, button {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .payment-section {
            display: none;
            text-align: center;
            padding: 15px;
        }
        .upi-qr img {
            width: 200px;
            margin: 10px 0;
        }
        button {
            background: #28a745;
            color: white;
            border: none;
            cursor: pointer;
            font-size: 16px;
        }
        button:hover {
            background: #218838;
        }
    </style>
</head>
<body>
<div class="content">
<div class="payment-container">
    <h2>Payment for Invoice: <?= htmlspecialchars($invoice_number); ?></h2>
    <p>Total Amount: ₹ <?= isset($invoice['total_amount']) ? number_format(floatval($invoice['total_amount']), 2) : 'N/A'; ?></p>

    <form action="../admin/process_payment.php" method="POST">
        <input type="hidden" name="invoice_number" value="<?= htmlspecialchars($invoice_number); ?>">

        <label>Select Payment Method:</label>
            <select name="payment_method" id="payment-method" required>
                <option value="">-- Select Payment Method --</option>
                <option value="UPI">UPI</option>
                <option value="Credit/Debit Card">Credit/Debit Card</option>
                <option value="Cash">Cash</option>
            </select>

            <!-- UPI QR Code Section -->
            <div id="upi-section" class="payment-section">
                <h3>Scan to Pay via UPI</h3>
                <div class="upi-qr">
                    <img id="upi-qr-image" src="../uploads/QRcode.png" alt="UPI QR Code">
                </div>
                <a id="upi-payment-link" href="#" style="display: none;" target="_blank">Click to Pay via UPI App</a>
            </div>

            <!-- Credit/Debit Card Section -->
            <div id="card-section" class="payment-section">
                <h3>Enter Card Details</h3>
                <input type="text" name="cardholder_name" placeholder="Cardholder Name" required>
                <input type="text" name="card_number" placeholder="Card Number" required pattern="\d{16}">
                <input type="text" name="expiry_date" placeholder="Expiry (MM/YY)" required pattern="\d{2}/\d{2}">
                <input type="password" name="cvv" placeholder="CVV" required pattern="\d{3}">
            </div>

             <!-- Cash Payment Section -->
             <div id="cash-section" class="payment-section" style="display: none;">
                <h3>Cash Payment Selected</h3>
                <p>Please pay at the counter to complete your transaction.</p>
              </div>
            <button type="submit">Proceed to Pay</button>
        </form>

        <?php
        // Show download link only if payment is completed
        if ($status === 'Paid') {
            echo "<p><strong>Download Paid Invoice:</strong></p>";
            echo "<a href='../admin/download_invoice.php?invoice=" . htmlspecialchars($invoice_number) . "' target='_blank'>Click here to Download Paid Invoice</a>";
        }
        ?>
    </div>
</div>

<script>
    document.getElementById("payment-method").addEventListener("change", function () {
        let method = this.value;

    // Hide all sections first
    document.getElementById("upi-section").style.display = "none";
    document.getElementById("card-section").style.display = "none";
    document.getElementById("cash-section").style.display = "none";

    // Show the selected section
    if (method === "UPI") {
        document.getElementById("upi-section").style.display = "block";

        // Ensure total amount exists before fetching QR code
        let totalAmountElement = document.getElementById("total-amount");
        let amount = totalAmountElement ? totalAmountElement.innerText : "0";

        fetch("generate_upi_qr.php?amount=" + amount)
            .then(response => response.json())
            .then(data => {
                document.getElementById("upi-qr-image").src = data.qr_code;
                document.getElementById("upi-payment-link").href = data.upi_url;
                document.getElementById("upi-payment-link").style.display = "block";
            })
            .catch(error => console.error("Error generating UPI QR:", error));
    } else if (method === "Credit/Debit Card") {
        document.getElementById("card-section").style.display = "block";
    } else if (method === "Cash") {
        document.getElementById("cash-section").style.display = "block";
    }
});
</script>

</div>
</body>
</html>