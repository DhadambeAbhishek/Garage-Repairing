<?php
session_start();
include("../database/db_connect.php");

// Check if the mechanic is logged in
if (!isset($_SESSION['mechanic_id']) || empty($_SESSION['fullname'])) {
    header("Location: mechanic_login.php");
    exit();
}

$mechanic_id = $_SESSION['mechanic_id'];

// Fetch mechanic details
$sql = "SELECT fullname, email, address FROM mechanics WHERE mechanic_id = ?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("i", $mechanic_id);
$stmt->execute();
$result = $stmt->get_result();
$mechanic = $result->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullname = trim($_POST['fullname']);
    $email = trim($_POST['email']);
    $address = trim($_POST['address']);

    // Update query
    $update_sql = "UPDATE mechanics SET fullname = ?, email = ?, address = ? WHERE mechanic_id = ?";
    $update_stmt = $mysqli->prepare($update_sql);
    $update_stmt->bind_param("sssi", $fullname, $email, $address, $mechanic_id);

    if ($update_stmt->execute()) {
        $_SESSION['success_message'] = "Profile updated successfully!";
        header("Location: mechanic_profile.php");
        exit();
    } else {
        $error_message = "Error updating profile!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mechanic Profile</title>
    <link rel="stylesheet" href="../styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            text-align: center;
        }
        .profile-container {
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

<div class="profile-container" style="margin-top: 78px";>
    <h2>Update Profile</h2>

    <?php if (isset($_SESSION['success_message'])): ?>
        <p class="success"><?php echo $_SESSION['success_message']; unset($_SESSION['success_message']); ?></p>
    <?php endif; ?>

    <?php if (isset($error_message)): ?>
        <p class="error"><?php echo $error_message; ?></p>
    <?php endif; ?>

    <form method="post">
        <label>Username:</label>
        <input type="text" name="fullname" value="<?php echo htmlspecialchars($mechanic['fullname']); ?>" required>

        <label>Email:</label>
        <input type="email" name="email" value="<?php echo htmlspecialchars($mechanic['email']); ?>" required>

        <label>Address:</label>
        <input type="text" name="address" value="<?php echo htmlspecialchars($mechanic['address']); ?>" required>

        <button type="submit" class="btn">Update Profile</button>
    </form>
</div>

</body>
</html>