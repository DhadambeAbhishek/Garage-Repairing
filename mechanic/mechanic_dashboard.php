<?php
session_start();
include("../database/db_connect.php");

// Check if the mechanic is logged in
if (!isset($_SESSION['mechanic_id']) || empty($_SESSION['fullname'])) {
    header("Location: mechanic_login.php");
    exit();
}

// Display login success message
if (isset($_SESSION['login_success'])) {
    echo "<script>alert('" . $_SESSION['login_success'] . "');</script>";
    unset($_SESSION['login_success']);  // Remove message after displaying
}
$mechanic_id = $_SESSION['mechanic_id'];

// Fetch mechanic details
$query = "SELECT fullname, Mrole, status FROM mechanics WHERE mechanic_id = ?";
$stmt = $mysqli->prepare($query);
$stmt->bind_param("i", $mechanic_id);
$stmt->execute();
$result = $stmt->get_result();
$mechanic = $result->fetch_assoc();

// Count pending and completed tasks
$pending_query = "SELECT COUNT(*) AS pending_count FROM bookingsreq WHERE mechanic_id = ? AND status = 'Pending'";
$processing_count = "SELECT COUNT(*) AS processing_count FROM bookingsreq WHERE mechanic_id = ? AND status = 'Processing'";
$completed_query = "SELECT COUNT(*) AS completed_count FROM bookingsreq WHERE mechanic_id = ? AND status = 'Completed'";

$stmt = $mysqli->prepare($pending_query);
$stmt->bind_param("i", $mechanic_id);
$stmt->execute();
$result = $stmt->get_result();
$pending_count = $result->fetch_assoc()['pending_count'];

$stmt = $mysqli->prepare($processing_count);
$stmt->bind_param("i", $mechanic_id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$processing_count = $row['processing_count'];



$stmt = $mysqli->prepare($completed_query);
$stmt->bind_param("i", $mechanic_id);
$stmt->execute();
$result = $stmt->get_result();
$completed_count = $result->fetch_assoc()['completed_count'];

// Update mechanic status
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['status'])) {
    $new_status = $_POST['status'];
    $update_query = "UPDATE mechanics SET status = ? WHERE mechanic_id = ?";
    $stmt = $mysqli->prepare($update_query);
    $stmt->bind_param("si", $new_status, $mechanic_id);

    if ($stmt->execute()) {
        $_SESSION['status_message'] = "Status updated successfully!";
        header("Location: mechanic_dashboard.php"); // Refresh to show the updated status
        exit();
    } else {
        $error_message = "Failed to update status.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mechanic Dashboard</title>
    <style>
        /* General Styling */
/* General Styling */
body {
    font-family: 'Arial', sans-serif;
    background-color: #f4f4f4;
    margin: 0;
    padding: 0;
}

.mechanic-dashboard {
    max-width: 1200px;
    margin: 20px auto;
    padding: 20px;
    background: white;
    border-radius: 10px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
}

/* Top Section Layout */
.topdiv {
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 20px;
}

.right img {
    height: 357px;
    width: 650px; /* Medium size */
    border-radius: 10px;
}

.leftside {
    flex: 1;
}

.current-status {
    background: white;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    width: 460px;
    margin-top: 20px;
}

.current-status h3 {
    color: #333;
    border-bottom: 3px solid #007bff;
    display: inline-block;
    padding-bottom: 5px;
}

/* Status Update Form */
.status-form {
    margin-top: 15px;
}

.status-form label {
    font-weight: bold;
    display: block;
    margin-bottom: 5px;
}

.status-form select {
    width: 100%;
    padding: 10px;
    font-size: 14px;
    border: 1px solid #ccc;
    border-radius: 5px;
}

.status-form button {
    background: #007bff;
    color: white;
    border: none;
    padding: 10px 15px;
    font-size: 14px;
    border-radius: 5px;
    cursor: pointer;
    margin-top: 10px;
    transition: background 0.3s ease-in-out, transform 0.2s ease-in-out;
}

.status-form button:hover {
    background: #0056b3;
    transform: scale(1.05);
}

/* Status Message Styling */
.success-msg {
    color: #28a745;
    font-weight: bold;
    margin-top: 10px;
}

.error-msg {
    color: #dc3545;
    font-weight: bold;
    margin-top: 10px;
}

/* Task Status Section */
.status-container {
    display: flex;
    justify-content: space-between;
    flex-wrap: wrap;
    margin: 20px 0;
    gap: 20px;
}

.status-box {
    flex: 1;
    min-width: 220px;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    text-align: center;
    transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
    font-weight: bold;
}

.status-box:hover {
    transform: translateY(-5px);
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
}

/* Status Colors */
.pending {
    background: #ffecec;
    border-left: 6px solid #dc3545;
    color: #dc3545;
}

.processing {
    background: #fff3cd;
    border-left: 6px solid #ffc107;
    color: #856404;
}

.completed {
    background: #e3fcef;
    border-left: 6px solid #28a745;
    color: #28a745;
}

/* Center Image Styling */
.center {
    display: flex;
    justify-content: center;
    align-items: center;
    margin-top: 20px;
}

.center img {
    width: 150px; /* Small size */
    height: auto;
    border-radius: 10px;
}

/* Responsive Design */
@media (max-width: 768px) {
    .topdiv {
        flex-direction: column;
        align-items: center;
        text-align: center;
    }
    
    .status-container {
        flex-direction: column;
        align-items: center;
    }

    .status-box {
        width: 90%;
        margin-bottom: 15px;
    }

    .current-status {
        max-width: 100%;
    }
}
    </style>
</head>

<body>
    <?php include 'mechanic_nav.php'; ?>
    <div class="mechanic-dashboard">
    <div class="topdiv">
        <div class="right">
            <img src="../uploads/cartoon-workshop-with-mechanic.png" alt="Right Image">
        </div>
    
    <div leftside>
        <h2>Welcome,
            <?php echo htmlspecialchars($mechanic['fullname']); ?>!
        </h2>
        <p>Role:
            <?php echo htmlspecialchars($mechanic['Mrole']); ?>
        </p>
        <!-- Current Status Section -->
        <div class="left">
        <div class="current-status">
            <h3>Your Current Status</h3>
            <p>Status: <strong>
                    <?php echo htmlspecialchars($mechanic['status']); ?>
                </strong></p>

            <?php if (isset($_SESSION['status_message'])): ?>
            <p class="success-msg">
                <?php echo $_SESSION['status_message']; unset($_SESSION['status_message']); ?>
            </p>
            <?php endif; ?>

            <?php if (isset($error_message)): ?>
            <p class="error-msg">
                <?php echo $error_message; ?>
            </p>
            <?php endif; ?>

            <!-- Status Update Form -->
            <form method="post" class="status-form">
                <label for="status">Update Status:</label>
                <select name="status" id="status">
                    <option value="Active" <?php if ($mechanic['status']=='Active' ) echo 'selected' ; ?>>Active
                    </option>
                    <option value="Working" <?php if ($mechanic['status']=='Working' ) echo 'selected' ; ?>>Working
                    </option>
                    <option value="Break" <?php if ($mechanic['status']=='Break' ) echo 'selected' ; ?>>Break</option>
                </select>
                <button type="submit">Update Status</button>
            </form>
        </div>
        </div>
    </div>
    </div>
    <!-- Task Status Section -->
    <div class="center">
        <img src="../uploads/repairman-cartoon-style.png" alt="center Image">
    </div>
    <div class="status-container">
        <div class="status-box pending">
            <h3>Pending Tasks</h3>
            <p>
                <?php echo $pending_count; ?>
            </p>
        </div>
        <div class="status-box processing">
            <h3>Processing Tasks</h3>
            <p>
                <?php echo $processing_count; ?>
            </p>
        </div>
        <div class="status-box completed">
            <h3>Completed Tasks</h3>
            <p>
                <?php echo $completed_count; ?>
            </p>
        </div>
    </div>
    </div>

</body>

</html>