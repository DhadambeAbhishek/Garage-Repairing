<?php
include("../database/db_connect.php");
// Get user's latest unpaid invoice
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'user') {
    header("Location: ../index.php"); // Use "../" if file is inside "user/" folder
    exit();
}
$user_id = $_SESSION['user_id'];  // Get logged-in user's ID

$sql = "SELECT invoice_number FROM invoices WHERE user_id = ? AND status = 'Pending' ORDER BY created_at DESC LIMIT 1";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$invoice = $result->fetch_assoc();

$invoice_number = $invoice ? $invoice['invoice_number'] : '';  // If no invoice, leave blank
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Navigation Bar</title>
    <style>/* Global Styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }
        
        /* Navbar Styles */
        .navbar {
            background: #1f2937;
            color: white;
            position: fixed;
            width: 100%;
            top: 0;
            left: 0;
            height: 70px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            z-index: 1000;
        }
        
        .nav-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 90%;
            max-width: 1200px;
        }
        
        /* Logo */
        .logo {
            font-size: 1.5rem;
            font-weight: bold;
            color: #facc15;
            text-decoration: none;
        }
        
        /* Navigation Links */
        .nav-links {
            list-style: none;
            display: flex;
            gap: 20px;
        }
        
        .nav-links li {
            display: inline;
        }
        
        .nav-links a {
            color: white;
            text-decoration: none;
            font-size: 1rem;
            padding: 10px 15px;
            border-radius: 5px;
            transition: all 0.3s ease;
        }
        
        /* Hover & Active Effects */
        .nav-links a:hover,
        .nav-links .active {
            background: linear-gradient(45deg, #facc15, #f97316);
            color: #1f2937;
            font-weight: bold;
        }
        
        /* User Profile */
        .user-profile {
            display: flex;
            align-items: center;
        }
        
        .user-profile img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            border: 2px solid white;
        }
        
        /* Page Content */
        .content {
            margin-top: 100px;
            text-align: center;
            padding: 20px;
        }
        
        .content h1 {
            font-size: 2rem;
            color: #1f2937;
        }
        
        .content p {
            font-size: 1.2rem;
            color: #555;
        }
        
        /* Responsive Design */
        @media (max-width: 768px) {
            .nav-links {
                display: none; /* Hide nav links for mobile */
            }
        
            .nav-container {
                justify-content: space-between;
            }
        }
        /* Dropdown Menu Styling */
.dropdown-menu {
    display: none;
    list-style: none;
    padding-left: 0;
    position: absolute;
    top: 50px;
    right: 0;
    background: #ffffff;
    border-radius: 8px;
    box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.15);
    min-width: 180px;
    padding: 10px 0;
    opacity: 0;
    transform: translateY(-10px);
    transition: opacity 0.3s ease, transform 0.3s ease;
}

.dropdown:hover .dropdown-menu {
    display: block;
    opacity: 1;
    transform: translateY(0);
}

/* Dropdown Items */
.dropdown-menu li {
    padding: 8px 20px;
}

.dropdown-menu li a {
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 16px;
    color: #333;
    text-decoration: none;
    padding: 10px;
    transition: all 0.3s ease;
    border-radius: 6px;
}

.dropdown-menu li a i {
    font-size: 18px;
    color: #007bff;
    transition: color 0.3s ease;
}

.dropdown-menu li a:hover {
    background: linear-gradient(90deg, #007bff, #0056b3);
    color: #ffffff;
    transform: translateX(5px);
}

.dropdown-menu li a:hover i {
    color: #ffffff;
}

/* Profile Image Styling */
.profile-img {
    width: 45px;
    height: 45px;
    border-radius: 50%;
    object-fit: cover;
    transition: all 0.3s ease-in-out;
    cursor: pointer;
    border: 2px solid transparent;
}

.profile-img:hover {
    transform: scale(1.1);
    border-color: #007bff;
    box-shadow: 0px 4px 12px rgba(0, 123, 255, 0.4);
}

/* Icon Button Styling */
.icon-button {
    background: none;
    border: none;
    font-size: 18px;
    margin-left: 15px;
    color: #333;
    transition: color 0.3s ease;
    cursor: pointer;
}

.icon-button:hover {
    color: #007bff;
}

        </style>
</head>
<body>

    <nav class="navbar">
        <div class="nav-container">
            <a href="#" class="logo">🚗 RMC&B Garage</a>
            <ul class="nav-links">
                <li><a href="user_dashboard.php" class="active">Dashboard</a></li>
                <li><a href="book_request.php">Book_Request</a></li>
                <li><a href="view_history.php">View_History</a></li>
                
                <li>
                 <?php if (!empty($invoice_number)): ?>
                <a href="payment.php?invoice=<?= urlencode($invoice_number); ?>">Payment</a>
                 <?php else: ?>
                <a href="#">No Pending Payments</a>   
                 <?php endif; ?>
                </li>
                
                <li><a href="about_us.php">About_Us</a></li>
                <li><a href="Feedback_Form.php">Feedback</a></li>
                
            </ul>
            
            <div class="dropdown">
                <button class="icon-button dropdown-toggle" type="button" id="profileDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="../uploads/adminlogo.png" alt="Profile" class="profile-img">
                </button>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileDropdown">
                    <li><a class="dropdown-item" href="profile.php"><i class="fas fa-user"></i> Profile</a></li>
                    <!--<li><a class="dropdown-item" href="#"><i class="fas fa-cog"></i> Settings</a></li>-->
                    <li><a class="dropdown-item" href="/RMYC_R/logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>
</body>
</html>