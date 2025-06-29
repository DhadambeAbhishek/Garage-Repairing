<?php
session_start();
include("../database/db_connect.php");
// If session is set
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../index.php"); // Use "../" if file is inside "user/" folder
    exit();
}
$result = $mysqli->query("SELECT * FROM feedback ORDER BY created_at DESC");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedback List</title>
    <style>/* General Styles */

/* Container */
.box {
    width: 60%;
    margin: 50px auto;
    background: #fff;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
}

/* Heading */
h2 {
    color: #333;
    
}

/* Back Link */


/* Feedback Box */
.feedback-box {
    background: #fafafa;
    border-left: 5px solid #007BFF;
    padding: 15px;
    margin-bottom: 20px;
    border-radius: 8px;
    text-align: left;
}

/* Name and Email */
.feedback-box p strong {
    color: #007BFF;
    font-size: 16px;
}

.feedback-box p {
    margin: 5px 0;
    color: #555;
}

/* Star Rating */
.star-rating {
    font-size: 20px;
    color: gold;
    margin-top: 5px;
}

</style>
</head>
<body>
<?php include("adm_navbar.php"); ?>
<div class="content">
<div class="box">
        <h2>All Feedback</h2>
        <hr>
        <?php while ($row = $result->fetch_assoc()): ?>
            <div class="feedback-box">
                <p><strong><?php echo htmlspecialchars($row['name']); ?></strong> (<?php echo $row['email']; ?>)</p>
                <p><?php echo nl2br(htmlspecialchars($row['message'])); ?></p>
                <p class="star-rating">
                    <?php 
                    $stars = str_repeat("⭐", $row['rating']);
                    echo $stars;
                    ?>
                </p>
            </div>
        <?php endwhile; ?>
    </div>
</div>
</body>
</html>

