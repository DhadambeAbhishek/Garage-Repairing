<?php
session_start();

include("../database/db_connect.php");

// Debugging to check session variables
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'user') {
    header("Location: ../index.php"); // Use "../" if file is inside "user/" folder
    exit();
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $message = $_POST["message"];
    $rating = $_POST["rating"];

    $stmt = $mysqli->prepare("INSERT INTO feedback (name, email, message, rating) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("sssi", $name, $email, $message, $rating);

    if ($stmt->execute()) {
        echo "<p style='color: green; text-align: center;'>Feedback submitted successfully!</p>";
    } else {
        echo "<p style='color: red; text-align: center;'>Error submitting feedback.</p>";
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Feedback</title>
    <style>body {
    font-family: Arial, sans-serif;
    background-color: #f8f9fa;
    text-align: center;
    margin: 0;
    padding: 0;
}

.container {
    background: white;
    width: 50%;
    margin: 50px auto;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
}

h2 {
    color: #333;
}

input, textarea {
    width: 90%;
    padding: 10px;
    margin: 10px 0;
    border: 1px solid #ccc;
    border-radius: 5px;
}

button {
    background-color: #28a745;
    color: white;
    padding: 10px 15px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

button:hover {
    background-color: #218838;
}

/* Star Rating */
.rating {
    direction: rtl;
    display: flex;
    justify-content: center;
    gap: 5px;
    margin: 15px 0;
}

.rating input {
    display: none;
}

.rating label {
    font-size: 30px;
    color: #ddd;
    cursor: pointer;
}

.rating input:checked ~ label,
.rating label:hover,
.rating label:hover ~ label {
    color: gold;
}
</style>
</head>
<body>
<?php include("navbar.php"); ?>
<div class="content">
    <div class="container">
        <h2>Submit Feedback</h2>
        <form method="POST">
            <input type="text" name="name" placeholder="Your Name" required><br>
            <input type="email" name="email" placeholder="Your Email" required><br>
            <textarea name="message" placeholder="Your Feedback" required></textarea><br>

            <div class="rating">
                <input type="radio" name="rating" value="5" id="star5"><label for="star5">&#9733;</label>
                <input type="radio" name="rating" value="4" id="star4"><label for="star4">&#9733;</label>
                <input type="radio" name="rating" value="3" id="star3"><label for="star3">&#9733;</label>
                <input type="radio" name="rating" value="2" id="star2"><label for="star2">&#9733;</label>
                <input type="radio" name="rating" value="1" id="star1" required><label for="star1">&#9733;</label>
            </div>

            <button type="submit">Submit</button>
        </form>
    </div>
    </div>
</body>
</html>
