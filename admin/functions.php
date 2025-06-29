<?php
include("../database/db_connect.php");
// Add a new part to inventory
function addPart($partName, $partType, $brand, $model, $material, $quantity) {
    global $mysqli;
    $sql = "INSERT INTO inventory (part_name, part_type, brand, model, material, quantity) 
            VALUES ('$partName', '$partType', '$brand', '$model', '$material', $quantity)";
    if ($mysqli->query($sql) === TRUE) {
        return "New part added successfully.";
    } else {
        return "Error: " . $sql . "<br>" . $mysqli->error;
    }
}

// Update stock when parts are used or received
function updateStock($partId, $quantity) {
    global $mysqli;
    $sql = "UPDATE inventory SET quantity = quantity + $quantity WHERE id = $partId";
    if ($mysqli->query($sql) === TRUE) {
        return "Stock updated successfully.";
    } else {
        return "Error: " . $sql . "<br>" . $mysqli->error;
    }
}

// Get all inventory parts filtered by part type
function getInventory($partType = null) {
    global $mysqli;
    $sql = "SELECT * FROM inventory";
    if ($partType) {
        $sql .= " WHERE part_type = '$partType'";
    }
    $result = $mysqli->query($sql);
    return $result;
}
?>
