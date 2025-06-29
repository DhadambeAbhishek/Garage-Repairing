<?php
session_start();
include("../database/db_connect.php");
 // Include your database connection

 if (isset($_GET['id'])) {
    $booking_id = $_GET['id'];
    
    if (isset($_POST['status'])) {
        $new_status = $_POST['status'];

        $sql = "UPDATE bookingsreq SET status = ? WHERE id = ?";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("si", $new_status, $booking_id);

        if ($stmt->execute()) {
            echo "<script>alert('Status updated successfully!'); window.location.href='mechanic_view_tasks.php';</script>";
        } else {
            echo "<script>alert('Error updating status!'); window.location.href='mechanic_view_tasks.php';</script>";
        }

        $stmt->close();
        $mysqli->close();
    }
} else {
    echo "<script>alert('Invalid request!'); window.location.href='mechanic_view_tasks.php';</script>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Booking Status</title>
    <style>/* Form Container */
form {
    width: 100%;
    max-width: 350px;
    background: #ffffff;
    padding: 20px;
    margin: 20px auto;
    box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
    border-radius: 8px;
    text-align: center;
}

/* Label Styling */
label {
    font-size: 16px;
    font-weight: bold;
    color: #333;
    display: block;
    margin-bottom: 8px;
}

/* Dropdown Styling */
select {
    width: 100%;
    padding: 10px;
    font-size: 14px;
    border: 1px solid #ccc;
    border-radius: 5px;
    outline: none;
    background-color: #f9f9f9;
    cursor: pointer;
    transition: border-color 0.3s ease;
}

select:hover, select:focus {
    border-color: #007bff;
}

/* Submit Button */
button {
    width: 100%;
    padding: 10px;
    font-size: 16px;
    color: white;
    background: #007bff;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    margin-top: 12px;
    transition: background 0.3s ease;
}

button:hover {
    background: #0056b3;
}
</style>
</head>
<body>
<?php include 'mechanic_nav.php'; ?>
<h2>Update Booking Status</h2>

<form method="post">
    <label for="status">Select Status:</label>
    <select name="status" required>
        <option value="Pending">Pending</option>
        <option value="Processing">Processing</option>
        <option value="Completed">Completed</option>
    </select>
    <br>
    <button type="submit">Update Status</button>
</form>

</body>
</html>