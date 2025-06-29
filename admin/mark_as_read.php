<?php
include("../database/db_connect.php");

if (isset($_GET['id']) && isset($_GET['bulk'])) {
    // ✅ Fetch notification message by ID
    $stmt = $mysqli->prepare("SELECT message FROM notifications WHERE id = ?");
    $stmt->bind_param("i", $_GET['id']);
    $stmt->execute();
    $result = $stmt->get_result();
    $notif = $result->fetch_assoc();

    if ($notif) {
        // ✅ Mark all notifications with the same message as read
        $stmt = $mysqli->prepare("UPDATE notifications SET status = 'read' WHERE message = ?");
        $stmt->bind_param("s", $notif['message']);
        $stmt->execute();
    }
} elseif (isset($_GET['id'])) {
    // ✅ Mark a single notification as read
    $stmt = $mysqli->prepare("UPDATE notifications SET status = 'read' WHERE id = ?");
    $stmt->bind_param("i", $_GET['id']);
    $stmt->execute();
}

// ✅ Redirect to admin dashboard
header("Location: admin_dashboard.php");
exit();
?>
