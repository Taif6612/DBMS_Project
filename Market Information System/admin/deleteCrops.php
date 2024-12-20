<?php
$conn = mysqli_connect("localhost", "root", "", "farmsmart");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if (isset($_GET['farmer_id']) && isset($_GET['crop_id'])) {
    $farmer_id = mysqli_real_escape_string($conn, $_GET['farmer_id']);
    $crop_id = mysqli_real_escape_string($conn, $_GET['crop_id']);

    $delete_related = "DELETE FROM analysis_data_for_crops WHERE crop_id = '$crop_id'";
    if (!mysqli_query($conn, $delete_related)) {
        die("Error deleting related data: " . mysqli_error($conn));
    }

    $delete_crop = "DELETE FROM crop_information_per_farmer WHERE farmer_id = '$farmer_id' AND crop_id = '$crop_id'";
    if (mysqli_query($conn, $delete_crop)) {
        header("Location: http://localhost/Market%20Information%20System/admin/viewall_crop.php");
    } else {
        die("Error deleting crop: " . mysqli_error($conn));
    }
}

mysqli_close($conn);
?>
