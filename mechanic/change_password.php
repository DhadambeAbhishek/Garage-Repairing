<?php
session_start();
include("../database/db_connect.php");

// Check if the mechanic is logged in
if (!isset($_SESSION['mechanic_id']) || empty($_SESSION['fullname'])) {
    header("Location: mechanic_login.php");
    exit();
}
$mechanic_id = $_SESSION['mechanic_id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $old_password = trim($_POST['old_password']);
    $new_password = trim($_POST['new_password']);
    $confirm_password = trim($_POST['confirm_password']);

    // Fetch the existing hashed password
    $sql = "SELECT password FROM mechanics WHERE mechanic_id = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("i", $mechanic_id);
    $stmt->execute();
    $stmt->bind_result($stored_password);
    $stmt->fetch();
    $stmt->close();

    // Verify old password
    if (!password_verify($old_password, $stored_password)) {
        $error_message = "Old password is incorrect!";
    } elseif ($new_password !== $confirm_password) {
        $error_message = "New passwords do not match!";
    } else {
        // Hash the new password
        $hashed_password = password_hash($new_password, PASSWORD_BCRYPT);

        // Update the new password in the database
        $update_sql = "UPDATE mechanics SET password = ? WHERE mechanic_id = ?";
        $update_stmt = $mysqli->prepare($update_sql);
        $update_stmt->bind_param("si", $hashed_password, $mechanic_id);

        if ($update_stmt->execute()) {
            $_SESSION['success_message'] = "Password updated successfully!";
            header("Location: change_password.php");
            exit();
        } else {
            $error_message = "Error updating password!";
        }
        $update_stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password</title>
    <link rel="stylesheet" href="../styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            text-align: center;
        }
        .container {
            background: white;
            padding: 20px;
            width: 400px;
            margin: auto;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            color: #333;
        }
        label {
            display: block;
            margin-top: 10px;
            font-weight: bold;
        }
        input {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .btn {
            background: #007bff;
            color: white;
            padding: 10px;
            margin-top: 15px;
            border: none;
            cursor: pointer;
            width: 100%;
            border-radius: 5px;
        }
        .btn:hover {
            background: #0056b3;
        }
        .success {
            color: green;
            margin-top: 10px;
        }
        .error {
            color: red;
            margin-top: 10px;
        }
    </style>
</head>
<body>

<?php include 'mechanic_nav.php'; ?>

<div class="container" style="margin-top: 78px";>
    <h2>Change Password</h2>

    <?php if (isset($_SESSION['success_message'])): ?>
        <p class="success"><?php echo $_SESSION['success_message']; unset($_SESSION['success_message']); ?></p>
    <?php endif; ?>

    <?php if (isset($error_message)): ?>
        <p class="error"><?php echo $error_message; ?></p>
    <?php endif; ?>

    <form method="post">
        <label>Old Password:</label>
        <input type="password" name="old_password" required>

        <label>New Password:</label>
        <input type="password" name="new_password" required>

        <label>Confirm New Password:</label>
        <input type="password" name="confirm_password" required>

        <button type="submit" class="btn">Change Password</button>
    </form>
</div>

</body>
</html>