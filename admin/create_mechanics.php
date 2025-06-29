<?php
session_start();
include("../database/db_connect.php");
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../index.php"); // Use "../" if file is inside "user/" folder
    exit();
}

// Add Mechanic
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["username"];
    $email = $_POST["email"];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    $sql = "INSERT INTO users (username, email, password, role) VALUES ('$name', '$email', '$password', 'mechanic')";
    if ($mysqli->query($sql) === TRUE) {
        echo "Mechanic added successfully!";
    } else {
        echo "Error: " . $mysqli->error;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
    /* Form Container */
.form-container {
    width: 50%;
    margin: 40px auto;
    background: #fff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

/* Form Title */
.form-container h2 {
    text-align: center;
    color: #333;
    margin-bottom: 20px;
}

/* Form Labels */
label {
    font-weight: bold;
    color: #333;
    display: block;
    margin-top: 10px;
}

/* Form Inputs & Textarea */
input[type="text"],
input[type="email"],
input[type="password"],
input[type="date"],
textarea,
input[type="file"] {
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
    margin-top: 5px;
    font-size: 16px;
}

/* Checkbox & Radio Inputs */
input[type="checkbox"],
input[type="radio"] {
    margin-right: 5px;
}

/* Submit Button */
button {
    width: 100%;
    background: #007bff;
    color: #fff;
    border: none;
    padding: 12px;
    font-size: 18px;
    font-weight: bold;
    border-radius: 5px;
    cursor: pointer;
    margin-top: 15px;
    transition: background 0.3s ease-in-out;
}

button:hover {
    background: #0056b3;
}

/* Responsive Design */
@media (max-width: 768px) {
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
        <h2>Mechanic Job Application Form</h2>
        <form method="POST" action="submit_application.php" enctype="multipart/form-data">
            <!-- Full Name -->
            <label for="fullname">Full Name:</label>
            <input type="text" name="fullname" id="fullname" required><br>

            <!-- Date of Birth -->
            <label for="dob">Date of Birth:</label>
            <input type="date" name="dob" id="dob" required><br>

            <!-- Phone Number -->
            <label for="phone">Phone Number:</label>
            <input type="text" name="phone" id="phone" required><br>

            <!-- Email -->
            <label for="email">Email Address:</label>
            <input type="email" name="email" id="email" required><br>

            <!-- Password -->
            <label for="password">Password:</label>
            <input type="password" name="password" id="password" required><br>

            <!-- Address -->
            <label for="address">Home Address:</label>
            <textarea name="address" id="address" rows="4" required></textarea><br>

            <!-- Type of Work Experience -->
            <label for="work_experience">What type of mechanic work are you experienced in?</label><br>
            <input type="checkbox" name="work_experience[]" value="Auto car repairs"> Auto Car repairs<br>
            <input type="checkbox" name="work_experience[]" value="Diesel mechanics"> Diesel mechanics<br>
            <input type="checkbox" name="work_experience[]" value="Motorcycle repairs"> Motorcycle repairs<br><br>

            <!-- Rate Mechanical Skills -->
            <label for="skill_rating">How would you rate your mechanical skills?</label><br>
            <input type="radio" name="skill_rating" value="1"> 1
            <input type="radio" name="skill_rating" value="2"> 2
            <input type="radio" name="skill_rating" value="3"> 3
            <input type="radio" name="skill_rating" value="4"> 4
            <input type="radio" name="skill_rating" value="5"> 5<br><br>

            <!-- Previous Work Experience -->
            <label for="experience">Tell us about your previous work experience as a mechanic:</label><br>
            <textarea name="experience" id="experience" rows="4" required></textarea><br>

            <!-- Resume Upload -->
            <label for="resume">Upload Your Resume:</label>
            <input type="file" name="resume" id="resume" required><br>

            <button type="submit" name="submit">Submit Application</button>
        </form>
    </div>
</div>
</body>
</html>


