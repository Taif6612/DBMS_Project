<?php
$conn = mysqli_connect("localhost", "root", "", "farmsmart");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $crop_id = $_POST['crop-id'];
    $crop_name = $_POST['crop-name'];
    $growing_season = $_POST['growing_season'];

    // Update query
    $updateQuery = "UPDATE crop_information_per_farmer 
                    SET c_name = '$crop_name', growing_season = '$growing_season' 
                    WHERE crop_id = '$crop_id'";

    if (mysqli_query($conn, $updateQuery)) {
        echo "Crop information updated successfully.";
    } else {
        echo "Error updating crop information: " . mysqli_error($conn);
    }
}

mysqli_close($conn);

header("Location: http://localhost/Market%20Information%20System/admin/manage-crops.php");
exit();
?>
