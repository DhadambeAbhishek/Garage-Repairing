<?php
session_start();

include("../database/db_connect.php");

// Debugging to check session variables
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'user') {
    header("Location: ../index.php"); // Use "../" if file is inside "user/" folder
    exit();
}
$user_id = $_SESSION['user_id'];

$query = "SELECT u.username, u.email, IFNULL(b.phone, '') AS phone
          FROM users u 
          LEFT JOIN bookingsreq b ON u.id = b.user_id 
          WHERE u.id = ? 
          LIMIT 1";

$stmt = $mysqli->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if (!$user) {
    echo "<script>alert('User profile data not found.');</script>";
    $user = ['username' => '', 'email' => '', 'phone' => ''];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <style>/* Container Styling */
.container {
    max-width: 500px;
    background: #ffffff;
    padding: 25px;
    border-radius: 8px;
    box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
    margin: 20px auto;
}

/* Header */
.container h2 {
    text-align: center;
    color: #333;
    margin-bottom: 20px;
}

/* Label Styling */
.container label {
    display: block;
    font-weight: 600;
    margin-bottom: 5px;
    color: #444;
}

/* Input Fields */
.container input[type="text"],
.container input[type="email"] {
    width: 100%;
    padding: 10px;
    margin-bottom: 15px;
    border: 1px solid #ccc;
    border-radius: 5px;
    font-size: 16px;
    transition: border 0.3s ease;
}

.container input[type="text"]:focus,
.container input[type="email"]:focus {
    border-color: #007bff;
    outline: none;
    box-shadow: 0px 2px 8px rgba(0, 123, 255, 0.3);
}

/* Readonly Email Field */
.container input[readonly] {
    background: #f4f4f4;
    color: #666;
    cursor: not-allowed;
}

/* Submit Button */
.container input[type="submit"] {
    width: 100%;
    padding: 12px;
    background: #007bff;
    color: white;
    border: none;
    border-radius: 5px;
    font-size: 18px;
    cursor: pointer;
    transition: background 0.3s ease;
}

.container input[type="submit"]:hover {
    background: #0056b3;
}

/* Responsive Design */
@media (max-width: 600px) {
    .container {
        width: 90%;
        padding: 20px;
    }
}
</style>
</head>
<body>
<?php include("navbar.php"); ?>
<div class="content">
    <div class="container">
        <h2>My Profile</h2>
        <form method="POST" action="update_profile.php">
            <label>Name:</label>
            <input type="text" name="name" value="<?= htmlspecialchars($user['username']); ?>" required>

            <label>Email:</label>
            <input type="email" name="email" value="<?= htmlspecialchars($user['email']); ?>" readonly>

            <label>Phone:</label>
            <input type="text" name="phone" value="<?= htmlspecialchars($user['phone']); ?>" required>

            <input type="submit" name="update_profile" value="Update Profile">
        </form>
    </div>
</div>
</body>
</html>
