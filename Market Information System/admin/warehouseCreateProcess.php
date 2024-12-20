<?php
$conn = mysqli_connect("localhost", "root", "", "farmsmart");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $zoneNumber = $_POST['zoneNumber'];
    $wNumber = $_POST['wNumber'];
    $capacity = $_POST['capacity'];

    $sql = "INSERT INTO warehouse (zone_num, warehouse_num, storage_capacity) 
            VALUES ('$zoneNumber', '$wNumber', '$capacity')";

    if (mysqli_query($conn, $sql)) {
        echo "Warehouse created successfully!";
    } else {
        echo "Error";
    }
}

mysqli_close($conn);
?>
