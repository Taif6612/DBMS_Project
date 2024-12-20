<?php
session_start();
if (!isset($_SESSION['active_user_id'])) {
    die("You must be logged in to perform this action.");
}
$active_user_id = $_SESSION['active_user_id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $analysis_id = $_POST['analysis_id'];
    $crop_id = $_POST['crop_id'];
    $c_name = $_POST['c_name'];
    $date = $_POST['date'];
    $price_value = $_POST['price_value'];

    if (empty($analysis_id) || empty($crop_id) || empty($c_name) || empty($date) || empty($price_value)) {
        die("All fields are required.");
    }

    $conn = mysqli_connect("localhost", "root", "", "farmsmart");

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $sql = "UPDATE analysis_data_for_crops 
            SET c_name = '$c_name', date = '$date', price_value = '$price_value'
            WHERE analysis_id = '$analysis_id' 
            AND crop_id = '$crop_id'
            AND analysis_id = '$active_user_id'"; 

    if (mysqli_query($conn, $sql)) {
        echo "Record updated successfully.";
        header("Location: http://localhost/Market%20Information%20System/analysist/allCrops.php");
        exit();
    } else {
        echo "Error updating record: " . mysqli_error($conn);
    }

    mysqli_close($conn);
} else {
    echo "Invalid request method.";
}
?>
