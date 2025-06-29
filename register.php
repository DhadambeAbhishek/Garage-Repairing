<?php

include("database/db_connect.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT); // Secure password hashing
    $role = 'user'; // Default role

    // Check if user already exists
    $checkQuery = "SELECT * FROM users WHERE email = ?";
    $stmt = $mysqli->prepare($checkQuery);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        die("User with this email already exists!");
    }

    // Insert new user
    $query = "INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, ?)";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("ssss", $username, $email, $password, $role);

    if ($stmt->execute()) {
      print "<script>alert('Register successfully!'); </script>";
      header("Location:login.php");
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
    <style>/* Reset default margin and padding */
/* General Reset */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: Arial, sans-serif;
}
.box {
            display: flex;
            width: 60%;
            max-width: 900px;
            background: white;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
            border-radius: 10px;
            overflow: hidden;
            justify-content: center;
            align-items: center;
        }

        .left {
            width: 50%;
            padding: 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            text-align: center;
        }

        .right {
            width: 50%;
            background: #f9f9f9;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .right img {
            max-width: 100%;
            height: auto;
            border-radius: 5px;
        }

        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        label {
            font-size: 14px;
            color: #555;
            margin-bottom: 5px;
            font-weight: bold;
            text-align: left;
        }

        input, select {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        button {
            padding: 12px;
            background: #007BFF;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: background 0.3s ease;
        }

        button:hover {
            background: #0056b3;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .box {
                flex-direction: column;
                width: 90%;
            }

            .left, .right {
                width: 100%;
            }

            .right {
                padding: 10px;
            }
        }
    </style>
</head>
<body>
<?php include 'navbarforlog.php'; ?>
<div class="container">
<div class="box" style="margin-top: 90px ; margin-left: 250px ;">
    <div class="left">
        <h2>Sign Up</h2>
        <form method="post">
            <label for="username">Username:</label>
            <input type="text" name="username" id="username" required>

            <label for="email">Email:</label>
            <input type="email" name="email" id="email" required>
             <!-- Hidden field for role -->
             <input type="hidden" name="role" value="user">
             <!--label for="role">Role:</label>
            <select name="role">
                <option value="user">User</option>
                <option value="admin">Admin</option>
            </select>-->

            <label for="password">Password:</label>
            <input type="password" name="password" id="password" required>

            <button type="submit">Sign Up</button>
        </form>
    </div>

    <div class="right">
        <img src="./uploads/onlineregistrationsign.png" alt="Sign Up Image">
    </div>
    </div>
</div>
</div>
</body>
</html>


