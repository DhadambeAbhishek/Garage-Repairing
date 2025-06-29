<?php
session_start();
include("../database/db_connect.php");
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../index.php"); // Use "../" if file is inside "user/" folder
    exit();
}
if (isset($_POST['delete_mechanice'])) {
    $mechanice_id = $_POST['mechanice_id']; // Corrected variable name

    // Delete user from the database
    $deleteQuery = "DELETE FROM mechanics WHERE mechanic_id = ?";
    $stmt = $mysqli->prepare($deleteQuery);
    $stmt->bind_param("i", $mechanice_id);

    if ($stmt->execute()) {
        echo "<script>alert('User deleted successfully!'); window.location.href='view_mechanices.php';</script>";
    } else {
        echo "<script>alert('Error deleting user.');</script>";
    }
}
// Query to count total mechanics
$sql = "SELECT COUNT(*) AS total_mechanics FROM mechanics";
$result = $mysqli->query($sql);
$row = $result->fetch_assoc();
$total_mechanics = $row['total_mechanics'];

// Fetch all mechanics
$sql = "SELECT mechanic_id, fullname, Mrole, status FROM mechanics";
$result = $mysqli->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Mechanics</title>
    <style>
        .dashboard {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            display: inline-block;
            width: 300px;
        }
        h2 {
            color: #333;
        }
        .count {
            font-size: 24px;
            font-weight: bold;
            color: #007bff;
        }

        table {
            width: 80%;
            margin: 20px auto;
            border-collapse: collapse;
            background: white;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            overflow: hidden;
        }

         th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
           background: #007bff;
           color: white;
        }

        tr:nth-child(even) {
           background: #f2f2f2;
        }

        tr:hover {
             background: #ddd;
        }

        td {
            color: #333;
        }
        .delete-btn {
    background: #dc3545;
    color: white;
    padding: 8px 12px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background 0.3s ease;
}

.delete-btn:hover {
    background: #c82333;
}

/* Responsive Design */
@media screen and (max-width: 768px) {
    table {
        width: 100%;
    }
    th, td {
        padding: 8px;
        font-size: 14px;
    }
}
    </style>
</head>
<body>
<?php include("adm_navbar.php"); ?>
<div class="content">
    <div class="dashboard">
        <h2>Total Mechanics</h2>
        <p class="count"><?php echo $total_mechanics; ?></p>
    </div>
    <table border="1">
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Role</th>
        <th>Status</th>
        <th>Action</th>
    </tr>
    <?php while ($row = $result->fetch_assoc()) { ?>
        <tr>
            <td><?php echo $row['mechanic_id']; ?></td>
            <td><?php echo htmlspecialchars($row['fullname']); ?></td>
            <td><?php echo htmlspecialchars($row['Mrole']); ?></td>
            <td>
                <span class="status <?php echo strtolower($row['status']); ?>">
                    <?php echo htmlspecialchars($row['status']); ?>
                </span>
            </td>
            <td>
                <form method="POST" onsubmit="return confirm('Are you sure you want to delete this mechanic?');">
                    <input type="hidden" name="mechanice_id" value="<?php echo $row['mechanic_id']; ?>">
                    <button type="submit" name="delete_mechanice" class="delete-btn">Delete</button>
                </form>
            </td>
        </tr>
    <?php } ?>
</table>
</div >
</body>
</html>



