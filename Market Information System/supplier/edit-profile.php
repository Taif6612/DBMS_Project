<?php
session_start();

if (!isset($_SESSION['active_user_id'])) {
    die("You must be logged in to view this page.");
}

$s_id = $_SESSION['active_user_id'];

$conn = mysqli_connect("localhost", "root", "", "farmsmart") or die("Connection failed");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $supplier_name = $_POST['supplier_name'];
    $s_password = $_POST['s_password'];
    $district = $_POST['district'];
    $village = $_POST['village'];

    $sql = "UPDATE supplier_information 
            SET supplier_name='$supplier_name', s_password='$s_password', district='$district', village='$village' 
            WHERE supplier_id='$s_id'";

    if (mysqli_query($conn, $sql)) {
        header("Location: http://localhost/Market%20Information%20System/supplier/profile.php");
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

mysqli_close($conn);
?>
