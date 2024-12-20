<?php
$conn = mysqli_connect("localhost", "root", "", "farmsmart");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $warehouse_num = $_POST['warehouse_num'];
    $zone_num = $_POST['zone_num'];
    $storage_capacity = $_POST['storage_capacity'];

    if (!empty($warehouse_num) && !empty($zone_num) && !empty($storage_capacity)) {
        $update_query = "
            UPDATE warehouse 
            SET
                storage_capacity = '$storage_capacity' 
            WHERE 
                warehouse_num = '$warehouse_num'";

        if (mysqli_query($conn, $update_query)) {
            header("Location: http://localhost/Market%20Information%20System/admin/warehouse.php");
            exit();
        } else {
            echo "Error updating record: " . mysqli_error($conn);
        }
    } 
}

mysqli_close($conn);
?>
