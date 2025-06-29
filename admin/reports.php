<?php
session_start();
include("../database/db_connect.php");
// If session is set
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../index.php"); // Use "../" if file is inside "user/" folder
    exit();
}
// Query for revenue trends (monthly)
$query_revenue = "SELECT MONTH(booking_date) AS month, SUM(total_price) AS revenue FROM bookingsreq GROUP BY MONTH(booking_date)";
$result_revenue = $mysqli->query($query_revenue);

$query_service_trends = "
    SELECT s.service_name, COUNT(bs.service_id) AS count 
    FROM booking_servicess bs
    JOIN services s ON bs.service_id = s.id 
    GROUP BY s.service_name
";
$result_service_trends = $mysqli->query($query_service_trends);


// Query for inventory status
$query_inventory = "SELECT part_name, quantity FROM inventory";
$result_inventory = $mysqli->query($query_inventory);

// Query for mechanic performance
$query_mechanics = "SELECT fullname, skill_rating FROM mechanics";
$result_mechanics = $mysqli->query($query_mechanics);

// Fetch results for the dashboard
$revenue_data = [];
while ($row = $result_revenue->fetch_assoc()) {
    $revenue_data[] = $row;
}

$service_trends_data = [];
while ($row = $result_service_trends->fetch_assoc()) {
    $service_trends_data[] = $row;
}

$inventory_data = [];
while ($row = $result_inventory->fetch_assoc()) {
    $inventory_data[] = $row;
}

$mechanic_data = [];
while ($row = $result_mechanics->fetch_assoc()) {
    $mechanic_data[] = $row;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save_snapshot'])) { 
    $revenue_json = json_encode($revenue_data);
    $service_json = json_encode($service_trends_data);
    $mechanic_json = json_encode($mechanic_data);
    $inventory_json = json_encode($inventory_data);

    $insert = $mysqli->prepare("
        INSERT INTO dashboard_snapshots (revenue_data, service_data, mechanic_data, inventory_data)
        VALUES (?, ?, ?, ?)
    ");
    $insert->bind_param("ssss", $revenue_json, $service_json, $mechanic_json, $inventory_json);

    if ($insert->execute()) {
        echo "<script>alert('✅ Snapshot saved successfully!');</script>";
    } else {
        echo "<script>alert('❌ Failed to save snapshot.');</script>";
    }
}

// Close database connection
$mysqli->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Garage Reports & Analytics</title>
    <style>.container {
    max-width: 1200px;
    margin: auto;
    padding: 20px;
}

/* Title Styling */
h1 {
    text-align: center;
    font-size: 24px;
    font-weight: bold;
    margin-bottom: 20px;
}

/* Chart Layout */
canvas {
    width: 100%;
    max-width: 500px;
    height: auto;
    background: #fff;
    border-radius: 10px;
    padding: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

/* Grid Layout for Charts */
.chart-container {
    display: flex;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 20px;
    margin-bottom: 30px;
}

.chart-box {
    flex: 1;
    min-width: 350px;
    text-align: center;
}

/* Inventory Table */
table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

th, td {
    padding: 12px;
    border: 1px solid #ddd;
    text-align: center;
}

th {
    background-color: #007bff;
    color: white;
}

/* Responsive Design */
@media (max-width: 768px) {
    .chart-container {
        flex-direction: column;
        align-items: center;
    }
    
    .chart-box {
        width: 100%;
    }
}
button[name="save_snapshot"] {
    margin-top: 20px;
    padding: 10px 20px;
    background-color: #28a745;
    border: none;
    color: white;
    font-weight: bold;
    border-radius: 5px;
    cursor: pointer;
}

button[name="save_snapshot"]:hover {
    background-color: #218838;
}

</style>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
<?php include("adm_navbar.php"); ?>
 <div class="content">
    <div class="container">
        <h1>Garage Reports</h1>
        <div class="chart-container">
        <div class="chart-box">
            <h2>Revenue Trend</h2>
            <canvas id="revenueChart"></canvas>
        </div>
        
        <div class="chart-box">
            <h2>Service Type Trends</h2>
            <canvas id="serviceChart"></canvas>
        </div>

        <div class="chart-box">
            <h2>Mechanic Performance</h2>
            <canvas id="mechanicChart"></canvas>
        </div>
    </div>
        <h2>Inventory Status</h2>
        <table>
            <thead>
                <tr>
                    <th>Part Name</th>
                    <th>Quantity</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($inventory_data as $item): ?>
                <tr>
                    <td><?= $item['part_name'] ?></td>
                    <td><?= $item['quantity'] ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
          <form method="post">
          <button type="submit" name="save_snapshot">💾 Save Dashboard Snapshot</button>
          </form>
        </div>
 </div>
    <script>
        // Revenue Trend Chart (Monthly)
        const revenueData = {
            labels: <?php echo json_encode(array_column($revenue_data, 'month')); ?>,
            datasets: [{
                label: 'Monthly Revenue',
                data: <?php echo json_encode(array_column($revenue_data, 'revenue')); ?>,
                borderColor: 'rgba(75, 192, 192, 1)',
                fill: false,
            }]
        };

        const revenueConfig = {
            type: 'line',
            data: revenueData,
        };

        new Chart(document.getElementById('revenueChart'), revenueConfig);

        // Service Type Trends
        const serviceData = {
            labels: <?php echo json_encode(array_column($service_trends_data, 'service_name')); ?>,
            datasets: [{
                label: 'Service Trends',
                data: <?php echo json_encode(array_column($service_trends_data, 'count')); ?>,
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        };

        const serviceConfig = {
            type: 'bar',
            data: serviceData,
        };

        new Chart(document.getElementById('serviceChart'), serviceConfig);

        // Mechanic Performance
        const mechanicData = {
            labels: <?php echo json_encode(array_column($mechanic_data, 'fullname')); ?>,
            datasets: [{
                label: 'Mechanic Performance',
                data: <?php echo json_encode(array_column($mechanic_data, 'skill_rating')); ?>,
                backgroundColor: 'rgba(153, 102, 255, 0.2)',
                borderColor: 'rgba(153, 102, 255, 1)',
                borderWidth: 1
            }]
        };

        const mechanicConfig = {
            type: 'bar',
            data: mechanicData,
        };

        new Chart(document.getElementById('mechanicChart'), mechanicConfig);
    </script>
</body>
</html>
