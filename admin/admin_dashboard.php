<?php
session_start();
include("../database/db_connect.php");
// If session is set
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../index.php"); // Use "../" if file is inside "user/" folder
    exit();
}
if (isset($_SESSION['login_success'])) {
    echo "<script>alert('" . $_SESSION['login_success'] . "');</script>";
    unset($_SESSION['login_success']);  // Remove message after displaying
}
// Query to count total users
$sql_users = "SELECT COUNT(*) AS total_users FROM users WHERE role = 'user'";
$result_users = $mysqli->query($sql_users);
$row_users = $result_users->fetch_assoc();
$total_users = $row_users['total_users'];

// Query to count total mechanics
$sql_mechanics = "SELECT COUNT(*) AS total_mechanics FROM mechanics";
$result_mechanics = $mysqli->query($sql_mechanics);
$row_mechanics = $result_mechanics->fetch_assoc();
$total_mechanics = $row_mechanics['total_mechanics'];

// Query to count pending status requests
$sql_pending = "SELECT COUNT(*) AS pending_requests FROM bookingsreq WHERE status = 'Pending'";
$result_pending = $mysqli->query($sql_pending);
$row_pending = $result_pending->fetch_assoc();
$pending_requests = $row_pending['pending_requests'];

// Count completed requests
$sql_completed = "SELECT COUNT(*) AS completed_requests FROM bookingsreq WHERE status = 'Completed'";
$result_completed = $mysqli->query($sql_completed);
$completed_requests = $result_completed->fetch_assoc()['completed_requests'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <style>/* General Dashboard Styling */
.dashboard-container {
    display: flex;
    justify-content: space-between;
    gap: 20px;
    padding: 20px;
    flex-wrap: wrap;
}

/* Dashboard Box */
.dashboard-box {
    background: #ffffff;
    padding: 25px;
    border-radius: 12px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.12);
    text-align: center;
    width: 30%;
    min-width: 220px;
    transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
    position: relative;
    overflow: hidden;
}

/* Hover Effect */
.dashboard-box:hover {
    transform: translateY(-5px);
    box-shadow: 0 6px 14px rgba(0, 0, 0, 0.15);
}

/* Heading */
.dashboard-box h3 {
    font-size: 20px;
    color: #333;
    margin-bottom: 12px;
    font-weight: 600;
}

/* Data Text */
.dashboard-box p {
    font-size: 28px;
    font-weight: bold;
    color: #007bff;
    margin: 5px 0;
}

/* Status Styles */
.pending {
    background: #ffecec;
    border-left: 6px solid #dc3545;
    color: #dc3545;
}

.completed {
    background: #e3fcef;
    border-left: 6px solid #28a745;
    color: #28a745;
}

.processing {
    background: #fff3cd;
    border-left: 6px solid #ffc107;
    color: #856404;
}

/* Icon Styling */
.dashboard-box i {
    font-size: 40px;
    margin-bottom: 10px;
    color: inherit;
}

/* Responsive Design */
@media screen and (max-width: 768px) {
    .dashboard-container {
        flex-direction: column;
        align-items: center;
    }
    .dashboard-box {
        width: 85%;
    }
}


</style>
</head>
<body>
<?php include("adm_navbar.php"); ?>
<div class="content">
    <h1>Welcome to Admin Dashboard</h1>

    <div class="dashboard-container">
    <div class="dashboard-box">
        <h3>Total Users</h3>
        <p><?php echo $total_users; ?></p>
    </div>

    <div class="dashboard-box">
        <h3>Total Mechanics</h3>
        <p><?php echo $total_mechanics; ?></p>
    </div>

    <div class="dashboard-box pending">
        <h3>Pending Requests</h3>
        <p><?php echo $pending_requests; ?></p>
    </div>

    <div class="dashboard-box completed">
        <h3>Completed Requests</h3>
        <p><?php echo $completed_requests; ?></p>
    </div>
</div>

<!-- Notifications Section - Place it right below the dashboard -->
<div class="notifications">
    <h3>🔔 New Notifications</h3>
    <?php
    // Query unread notifications
    $sql = "SELECT message, COUNT(*) as count, MIN(id) as id 
            FROM notifications 
            WHERE status = 'unread' 
            GROUP BY message 
            ORDER BY created_at DESC";
    $result = $mysqli->query($sql);

    if ($result->num_rows > 0) {
        while ($notif = $result->fetch_assoc()) {
            $count = $notif['count'];
            echo "<p>📢 {$notif['message']} " . ($count > 1 ? "({$count} new)" : "") . 
                 " <a href='mark_as_read.php?id={$notif['id']}&bulk=1'>Mark as Read</a></p>";
        }
    } else {
        echo "<p>No new notifications.</p>";
    }
    ?>
</div>

</div>
</body>
</html>

