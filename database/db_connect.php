<?php
// db_connect.php

// Set up database connection parameters
$servername = "localhost"; // Usually localhost for local setups
$username = "root";        // Database username (default is root)
$password = "";            // Database password (default is empty for XAMPP)
$dbname = "garage_repair"; // Name of your database

// Create connection
$mysqli = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}
?>
