<?php
$conn = mysqli_connect("localhost", "root", "", "farmsmart");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $analysis_id = $_POST['analysis_id'];
    $crop_id = $_POST['crop_id'];
    $crop_name = $_POST['crop_name'];
    $date = $_POST['date'];
    $pricevalue = $_POST['pricevalue'];
    $action = $_POST['action']; 

    if ($action == 'update') {
        $sql_update = "INSERT INTO analysis_data_for_crops (analysis_id, crop_id, c_name, date, price_value) 
                        VALUES ('$analysis_id','$crop_id', '$crop_name','$date',$pricevalue)";

        if (mysqli_query($conn, $sql_update)) {
            echo "Crop information updated successfully!";
        } else {
            echo "Error updating record: " . mysqli_error($conn);
        }

    } elseif ($action == 'delete') {
        $sql_delete = "DELETE FROM crop_information_per_farmer WHERE crop_id = '$crop_id'";

        if (mysqli_query($conn, $sql_delete)) {
            echo "Crop deleted successfully!";
        } else {
            echo "Error deleting record: " . mysqli_error($conn);
        }
    }
}

mysqli_close($conn);
?>
