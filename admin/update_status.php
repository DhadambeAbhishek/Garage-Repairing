<?php
session_start();
include("../database/db_connect.php");
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../index.php"); // Use "../" if file is inside "user/" folder
    exit();
}

if (isset($_GET['id'])) {
    $booking_id = $_GET['id'];
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update Status</title>
    <style>/* General Form Styling */
.form-container {
    width: 50%;
    margin: 40px auto;
    padding: 25px;
    background: #ffffff;
    border-radius: 12px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    text-align: center;
}

/* Form Heading */
.form-container h2 {
    font-size: 22px;
    color: #333;
    margin-bottom: 15px;
}

/* Label */
.form-container label {
    display: block;
    font-size: 16px;
    color: #555;
    font-weight: 600;
    margin-bottom: 8px;
}

/* Select Dropdown */
.form-container select {
    width: 100%;
    padding: 12px;
    font-size: 16px;
    border: 2px solid #ddd;
    border-radius: 8px;
    background: #f9f9f9;
    outline: none;
    transition: border-color 0.3s ease-in-out;
}

/* Dropdown Hover & Focus Effect */
.form-container select:focus {
    border-color: #007bff;
}

/* Submit Button */
.form-container button {
    background: #007bff;
    color: white;
    padding: 12px 18px;
    font-size: 16px;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    margin-top: 15px;
    transition: background 0.3s ease-in-out;
}

/* Hover Effect */
.form-container button:hover {
    background: #0056b3;
}

/* Responsive Design */
@media screen and (max-width: 768px) {
    .form-container {
        width: 80%;
    }
}
</style>
</head>
<body>
<?php include("adm_navbar.php"); ?>
<div class="content">
<div class="form-container">
    <h2>Update Booking Status</h2>
    <form action="process_update_status.php" method="POST">
        <input type="hidden" name="booking_id" value="<?= $booking_id; ?>">
        
        <label>Change Status:</label>
        <select name="status" required>
            <option value="Pending">Pending</option>
            <option value="Processing">Processing</option>
            <option value="Completed">Completed</option>
        </select>
        
        <button type="submit">Update</button>
    </form>
</div>
</div>
</body>
</html>