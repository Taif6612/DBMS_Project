<?php
    $conn = mysqli_connect("localhost", "root", "", "farmsmart");

    if (!$conn) {
        die("Connection failed");
    }

    $farmer_id = $_POST['farmer_id'];
    $crop_id = $_POST['crop_id'];
    $crop_name = $_POST['crop_name'];
    $growing_season = $_POST['growing_season'];

    $sql = "INSERT INTO crop_information_per_farmer (crop_id,farmer_id, c_name, growing_season) 
            VALUES ( '$crop_id','$farmer_id', '$crop_name', '$growing_season')";

    if (mysqli_query($conn, $sql)) {
        echo "Crop information uploaded successfully!";
    } else {
        echo "Error";
    }

    mysqli_close($conn);
?>

