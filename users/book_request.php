<?php
session_start();

include("../database/db_connect.php");

// Debugging to check session variables
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'user') {
    header("Location: ../index.php"); // Use "../" if file is inside "user/" folder
    exit();
}
 // Fetch bike services
 $bike_services = [];
 $result = $mysqli->query("SELECT * FROM services WHERE vehicle_type = 'Bike'");
 while ($row = $result->fetch_assoc()) {
     $bike_services[$row['service_name']] = $row['price'];
 }
 
 // Fetch car services
 $car_services = [];
 $result = $mysqli->query("SELECT * FROM services WHERE vehicle_type = 'Car'");
 while ($row = $result->fetch_assoc()) {
     $car_services[$row['service_name']] = $row['price'];
 }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book a Service</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
       /* Global Styles */
body {
    font-family: 'Poppins', sans-serif;
    margin: 0;
    padding: 0;
    background-color: #f8f9fa;
}

/* Container */
.containers {
    display: flex;
    justify-content: space-between;
    align-items: center;
    max-width: 1100px;
    margin: 50px auto;
    background: #fff;
    padding: 30px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    border-radius: 10px;
}

/* Left Side - Booking Form */
.booking-form {
    width: 55%;
    padding: 20px;
}

.booking-form h2 {
    color: #007bff;
    text-align: center;
    font-size: 24px;
    margin-bottom: 20px;
}

/* Form Input Fields */
.booking-form label {
    display: block;
    margin-bottom: 6px;
    font-weight: 600;
    color: #333;
}

.booking-form input,
.booking-form select {
    width: 100%;
    padding: 10px;
    border: 2px solid #ddd;
    border-radius: 5px;
    font-size: 14px;
    transition: 0.3s;
}

.booking-form input:focus,
.booking-form select:focus {
    border-color: #007bff;
    outline: none;
}

/* Button */
.btn {
    width: 100%;
    padding: 12px;
    background: #007bff;
    color: white;
    border: none;
    cursor: pointer;
    margin-top: 15px;
    font-size: 16px;
    border-radius: 6px;
    transition: 0.3s;
}

.btn:hover {
    background: #0056b3;
}

/* Service List */
.service-list {
    display: flex;
    flex-direction: column;
    gap: 10px;
    max-width: 400px;
}

.service-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 8px 12px;
    border: 1px solid #ddd;
    border-radius: 6px;
    background: #f9f9f9;
}

.form-check-input {
    width: 18px;
    height: 18px;
}

/* Right Side - Image */
.image-container {
    width: 40%;
    display: flex;
    align-items: center;
    justify-content: center;
}

.image-container img {
    width: 100%;
    border-radius: 8px;
    max-height: 350px;
    object-fit: cover;
}

/* Responsive Design */
@media screen and (max-width: 900px) {
    .containers {
        flex-direction: column;
        text-align: center;
        padding: 20px;
    }

    .booking-form,
    .image-container {
        width: 100%;
    }

    .booking-form {
        order: 1;
    }

    .image-container {
        order: 2;
    }
}

    </style>
    <script>


        function showServices() {
            const vehicleType = document.getElementById('vehicle_type').value;
            if (vehicleType === 'Bike') {
                document.getElementById('bike_services').style.display = 'block';
                document.getElementById('car_services').style.display = 'none';
            } else if (vehicleType === 'Car') {
                document.getElementById('car_services').style.display = 'block';
                document.getElementById('bike_services').style.display = 'none';
            } else {
                document.getElementById('bike_services').style.display = 'none';
                document.getElementById('car_services').style.display = 'none';
            }
        }


    </script>
</head>

<body>
    <?php include("navbar.php"); ?>
    <div class="content">
        <div class="container">
            <div class="containers">
                <div class="container">
                    <h2>Service Booking</h2>

                    <!-- Combined Form -->
                    <form action="process_booking.php" method="POST">
                        <div class="form-group">
                            <label for="name">Name:</label>
                            <input type="text" name="name" id="name" required>
                        </div>

                        <div class="form-group">
                            <label for="email">Email:</label>
                            <input type="email" name="email" id="email" required>
                        </div>

                        <div class="form-group">
                            <label for="phone">Phone:</label>
                            <input type="text" name="phone" id="phone" required>
                        </div>

                        <div class="form-group">
                            <label for="brand">Brand:</label>
                            <input type="text" name="brand" id="brand" required>
                        </div>

                        <div class="form-group">
                            <label for="model">Model:</label>
                            <input type="text" name="model" id="model" required>
                        </div>

                        <div class="form-group">
                            <label for="vehicle_type">Vehicle Type:</label>
                            <select name="vehicle_type" id="vehicle_type" onchange="showServices()" required>
                                <option value="">Select Vehicle Type</option>
                                <option value="Bike">Bike</option>
                                <option value="Car">Car</option>
                            </select>
                        </div>

                        <!-- Bike Services -->
                        <div id="bike_services" style="display: none;">
                            <h3>Select Services for Bike:</h3>
                            <table class="table">
                                <tr>
                                    <th>Service Name</th>
                                    <th>Price (INR)</th>
                                    <th>Select</th>
                                </tr>
                                <?php foreach ($bike_services as $service_name => $price) : ?>
                                <tr>
                                    <td>
                                        <?= $service_name; ?>
                                    </td>
                                    <td>₹
                                        <?= number_format($price, 2); ?>
                                    </td>
                                    <td><input type="checkbox" name="service_type[]" value="<?= $service_name; ?>"></td>
                                </tr>
                                <?php endforeach; ?>
                            </table>
                        </div>

                        <!-- Car Services -->
                        <div id="car_services" style="display: none;">
                            <h3>Select Services for Car:</h3>
                            <table class="table">
                                <tr>
                                    <th>Service Name</th>
                                    <th>Price (INR)</th>
                                    <th>Select</th>
                                </tr>
                                <?php foreach ($car_services as $service_name => $price) : ?>
                                <tr>
                                    <td>
                                        <?= $service_name; ?>
                                    </td>
                                    <td>₹
                                        <?= number_format($price, 2); ?>
                                    </td>
                                    <td><input type="checkbox" name="service_type[]" value="<?= $service_name; ?>"></td>
                                </tr>
                                <?php endforeach; ?>
                            </table>
                        </div>

                        <button type="submit">Submit Booking</button>
                    </form>
                </div>
                <!-- Right Side - Image -->
                <div class="image-container">
                    <img src="../uploads/OIP.jpg" alt="Car Service">
                </div>
            </div>
        </div>
    </div>
            
</body>
</html>