<?php
include("database/db_connect.php");

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $username = trim($_POST['username']);
  $password = trim($_POST['password']);

  // Fetch user from database
  $query = "SELECT id, username, role, password FROM users WHERE username = ?";

  // Prepare statement and check if it succeeds
  $stmt = $mysqli->prepare($query);
  if (!$stmt) {
      die("Prepare failed: " . $mysqli->error);
  }
  $stmt->bind_param("s", $username);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows == 1) {
      $user = $result->fetch_assoc();

      // Verify password
      if (password_verify($password, $user['password'])) {
          $_SESSION['user_id'] = $user['id'];
          $_SESSION['username'] = $user['username'];
          $_SESSION['role'] = $user['role'];
          $_SESSION['login_success'] = "You have successfully logged in!";

          // Redirect based on role
          if ($user['role'] == "admin") {
            print "<script>alert('Logged In successfully!'); </script>";
              header("Location: admin\admin_dashboard.php");
          } else {
            print "<script>alert('Logged In successfully!'); </script>";
              header("Location:user\user_dashboard.php");
          }
          exit();
      } else {
            print "<script>alert('Invalid password!'); </script>";
      }
  } else {
        print "<script>alert('User not found!'); </script>";
  }
}
?>

<!-- HTML form for login -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Login</title>
    <link rel="stylesheet" href="style.css"> <!-- Add your CSS if needed -->
    <style>/* Reset default margin and padding */
/* Reset Styles */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: Arial, sans-serif;
}

/* Main Container */
.container {
    display: flex;
    align-items: center;
    justify-content: center;
    height: 100vh;
    padding: 20px;
}

/* Left & Right Images */
.left, .right {
    flex: 1;
    text-align: center;
}

.left img, .right img {
    max-width: 100%;
    height: auto;
    border-radius: 10px;
}

/* Center (Login Form) */
.center {
    flex: 1;
    padding: 30px;
    text-align: center;
    background: #f8f9fa;
    border-radius: 10px;
    box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
}

input, select {
    width: 100%;
    padding: 10px;
    margin-bottom: 15px;
    border: 1px solid #ccc;
    border-radius: 5px;
}

.center h2 {
    font-size: 24px;
    margin-bottom: 20px;
}

.center form {
    display: flex;
    flex-direction: column;
    align-items: center;
}

.center label {
    font-size: 16px;
    margin-bottom: 5px;
    text-align: left;
    width: 100%;
}


/* Login Button */
.center button {
    background-color: #007bff;
    color: #fff;
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 16px;
    transition: 0.3s;
}

.center button:hover {
    background-color: #0056b3;
}

/* Responsive Design */
@media (max-width: 768px) {
    .container {
        flex-direction: column;
    }

    .left, .right {
        display: none;
    }

    .center {
        width: 100%;
        max-width: 400px;
    }
}

</style>
</head>
<body>
<?php include 'navbarforlog.php'; ?>
  <div class="container">
    <div class="left">
            <img src="./uploads/bike1.png" alt="Left Image">
      </div>
        <div class="center">
        <h2>Login to Your Account</h2>

          <form method="POST" action="">
          <label for="username">Username:</label>
          <input type="text" id="username" name="username" required>


           <label for="email">Email:</label>
          <input type="email" id="email" name="email" required>

          <label for="password">Password:</label>
          <input type="password" id="password" name="password" required>

          <label for="role">Role:</label>
          <select id="role" name="role" required>
           <option value="admin">Admin</option>
           <option value="user">User</option>
          </select>

          <button type="submit">Login</button>
        </form><br>
        <p>Don't have an account? <a href="register.php">Sign up</a></p>
  </div>

  <!-- Right Side (Image) -->
  <div class="right">
            <img src="./uploads/bike2.png" alt="Right Image">
        </div>
    </div>
</div>


</body>
</html>
