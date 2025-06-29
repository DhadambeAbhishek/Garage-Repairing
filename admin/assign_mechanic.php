<?php
session_start();
include("../database/db_connect.php");
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../index.php"); // Use "../" if file is inside "user/" folder
    exit();
}
if (isset($_GET['id'])) {
    $booking_id = $_GET['id'];// Assuming booking_id is passed via URL
    // Fetch assigned mechanic (if any)
     $sql = "SELECT mechanic_id FROM bookingsreq WHERE id = ?";
     $stmt = $mysqli->prepare($sql);
     $stmt->bind_param("i", $booking_id);
     $stmt->execute();
     $result = $stmt->get_result();
     $booking = $result->fetch_assoc();
     $assigned_mechanic = $booking['mechanic_id'] ?? null;

    // Fetch available mechanics
    $query = "SELECT mechanic_id, fullname FROM mechanics";
    $result = $mysqli->query($query);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Assign Mechanic</title>
    <style>/* Form Container */
/* Assign Mechanic Form Styling */
.assign-mechanic-container {
    background: #fff;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    max-width: 400px;
    margin: auto;
    font-family: 'Poppins', sans-serif;
}

.assign-mechanic-container h2 {
    font-size: 22px;
    color: #333;
    margin-bottom: 15px;
    text-align: center;
}

.assign-mechanic-container label {
    font-weight: 600;
    color: #555;
    display: block;
    margin-bottom: 5px;
}

.assign-mechanic-container select,
.assign-mechanic-container button {
    width: 100%;
    padding: 10px;
    margin-bottom: 15px;
    border: 1px solid #ddd;
    border-radius: 5px;
    font-size: 16px;
}

.assign-mechanic-container select {
    background: #f9f9f9;
}

.assign-mechanic-container button {
    background: #007bff;
    color: #fff;
    border: none;
    cursor: pointer;
    transition: 0.3s ease;
}

.assign-mechanic-container button:hover {
    background: #0056b3;
}

.assign-mechanic-container p {
    text-align: center;
    font-size: 14px;
    font-weight: bold;
}

</style>
</head>
<body>
<?php include("adm_navbar.php"); ?>
<div class="content">
<div class="assign-mechanic-container">
    <h2>Assign Mechanic</h2>
    <form action="process_assign_mechanic.php" method="POST">
        <input type="hidden" name="booking_id" value="<?= $booking_id; ?>">
        
        <label>Select Mechanic:</label>
        <select name="mechanic_id" <?= $assigned_mechanic ? 'disabled' : 'required'; ?>>
            <option value="">Select Mechanic</option>
            <?php while ($row = $result->fetch_assoc()): ?>
                <option value="<?= $row['mechanic_id']; ?>" 
                    <?= ($assigned_mechanic == $row['mechanic_id']) ? 'selected' : ''; ?>>
                    <?= $row['fullname']; ?>
                </option>
            <?php endwhile; ?>
        </select>

        <?php if (!$assigned_mechanic): ?>
            <button type="submit">Assign</button>
        <?php else: ?>
            <p style="color: red;">Already assigned to <?= $assigned_mechanic; ?></p>
        <?php endif; ?>
    </form>
</div>

</div>
</body>
</html>