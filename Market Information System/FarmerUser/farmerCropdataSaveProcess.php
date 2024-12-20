<?php
$conn = mysqli_connect("localhost", "root", "", "farmsmart");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$farmerId = $_POST['FarmerId'];
$cropname = $_POST['cropName'];
$cropId = $_POST['cropId'];
$unitPrice = $_POST['unitPrice'];
$updateDate = $_POST['sellDate']; 


$sql = "INSERT INTO farmer_crop_data (farmerid, cropid, cost_per_unit, cropName, update_date) 
        VALUES ('$farmerId', '$cropId', $unitPrice, '$cropname', '$updateDate')";

if (mysqli_query($conn, $sql)) {
    echo "Crop data saved successfully!";
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}

mysqli_close($conn);
header("Location: http://localhost/Market%20Information%20System/FarmerUser/sell.php"); 
exit();
?>
