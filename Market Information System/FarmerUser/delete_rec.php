<?php
$conn = mysqli_connect("localhost", "root", "", "farmsmart");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if (isset($_GET['recommendation_id'])) {
    $recommendation_id = $_GET['recommendation_id'];

    $deleteQuery = "DELETE FROM recommendations WHERE recommendation_id = '$recommendation_id'";
    mysqli_query($conn, $deleteQuery);
}

header("Location: http://localhost/Market%20Information%20System/FarmerUser/LandingFarmer.php");
mysqli_close($conn);
?>
