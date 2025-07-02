<?php
header("Content-Type: application/json");

// Include your config
include('../../backend/admin/assets/inc/config.php');

// Fetch all available medicines
$sql = "SELECT med_name AS name, med_qty AS quantity FROM his_pharmaceuticals ORDER BY med_name ASC";
$result = $mysqli->query($sql);

$medicines = [];

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $medicines[] = $row;
    }
}

echo json_encode($medicines);
?>
