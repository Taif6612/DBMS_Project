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

    $sql = "UPDATE analysist_information 
            SET analysist_name='$supplier_name', a_password='$s_password', district='$district', village='$village' 
            WHERE analysist_id='$s_id'";

    if (mysqli_query($conn, $sql)) {
        header("Location: http://localhost/Market%20Information%20System/analysist/profile.php");
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

mysqli_close($conn);
?>
