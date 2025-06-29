<?php
session_start();
include("./database/db_connect.php");

// Get Login Data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $email = $_POST['email'];
  $password = $_POST['password'];

  $sql = "SELECT * FROM mechanics WHERE email = ?";
  $stmt = $mysqli->prepare($sql);

  if (!$stmt) {
      die("Error preparing statement: " . $mysqli->error);
  }

  $stmt->bind_param("s", $email);
  $stmt->execute();
  $result = $stmt->get_result();
  $row = $result->fetch_assoc();

  // Debugging - Check query results
  if (!$row) {
      print "<script>alert('No mechanic found with this email.'); </script>";
      //die("No mechanic found with this email.");
  }

  if (password_verify($password, $row['password'])) {
      $_SESSION['mechanic_id'] = $row['mechanic_id'];
      $_SESSION['fullname'] = $row['fullname'];
      $_SESSION['role'] = $row['Mrole'];
      $_SESSION['login_success'] = "You have successfully logged in!";  // Set notification message
      header("Location: mechanic/mechanic_dashboard.php");
      exit();
  } else {
      print "<script>alert('Invalid password!'); </script>";
  }

  $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>/* Reset default margin and padding */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: Arial, sans-serif;
}
/* Main Container */
.login-container {
    display: flex;
    width: 80%;
    max-width: 1100px;
    background: white;
    box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.1);
    border-radius: 10px;
    overflow: hidden;
}

/* Left & Right Image Sections */
.left-image, .right-image {
    flex: 1;
    display: flex;
    justify-content: center;
    align-items: center;
    background: #ddd;
}

.left-image img, .right-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

/* Login Form Section */
.login-form {
    flex: 1;
    padding: 40px;
    text-align: center;
}

.login-form h2 {
    margin-bottom: 20px;
}

.login-form label {
    display: block;
    text-align: left;
    margin: 10px 0 5px;
    font-weight: bold;
}

.login-form input {
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
    margin-bottom: 15px;
}

.login-form button {
    width: 100%;
    padding: 12px;
    background: #007bff;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 16px;
}

.login-form button:hover {
    background: #0056b3;
}

/* Responsive Design */
@media screen and (max-width: 900px) {
    .login-container {
        flex-direction: column;
        width: 90%;
    }
    .left-image, .right-image {
        display: none;
    }
    .login-form {
        padding: 20px;
    }
}

</style>
</head>
<body>
<?php include 'navbarforlog.php'; ?>
<div class="container" style="margin-top: 115px ; margin-left: 185px ; margin-right: 5px ;">

<div class="login-container">
    <!-- Left Side - Mechanic Image -->
    <div class="left-image">
        <img src="./uploads/mech.png" alt="Mechanic">
    </div>

    <!-- Center - Login Form -->
    <div class="login-form">
        <h2>Mechanic Login</h2>
        <form action="mechanic_login.php" method="post">
            <label for="email">Email:</label>
            <input type="email" name="email" id="email" required>

            <label for="password">Password:</label>
            <input type="password" name="password" id="password" required>

            <button type="submit" name="login">Login</button>
        </form>
    </div>

    <!-- Right Side - Garage Image -->
    <div class="right-image">
        <img src="./uploads/mech1.png" alt="Garage">
    </div>
</div>
</div>

</body>
</html>