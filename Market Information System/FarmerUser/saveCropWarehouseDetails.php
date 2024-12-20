<?php
$conn = mysqli_connect("localhost", "root", "", "farmsmart");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $crop_id = $_POST['crop_id'];
    $farmer_id = $_POST['farmer_id'];
    $price = $_POST['price'];
    $warehouse_selection = $_POST['warehouse']; 
    $quantity = $_POST['quantity'];
    $delivery_date = $_POST['delivery_date'];
    $price_disc = $_POST['price_disc'];

    list($warehouse_number, $zone_number) = explode(' - ', $warehouse_selection);

    $capacity_query = "SELECT storage_capacity FROM warehouse 
                       WHERE zone_num = '$zone_number' AND warehouse_num = '$warehouse_number'";
    $capacity_result = mysqli_query($conn, $capacity_query);

    if (mysqli_num_rows($capacity_result) > 0) {
        $row = mysqli_fetch_assoc($capacity_result);
        $storage_capacity = $row['storage_capacity'];
    } else {
        die("Error: Unable to retrieve storage capacity.");
    }

    $total_quantity_query = "SELECT SUM(quantity) AS total_quantity 
                             FROM crop_farmer_zone_warehouse_info 
                             WHERE zone_num = '$zone_number' AND warehouse_num = '$warehouse_number'";
    $total_quantity_result = mysqli_query($conn, $total_quantity_query);

    if ($total_quantity_result) {
        $total_row = mysqli_fetch_assoc($total_quantity_result);
        $total_quantity = $total_row['total_quantity'] ?? 0; 
    } else {
        die("Error: Unable to calculate total quantity.");
    }

    if (($total_quantity + $quantity) <= $storage_capacity) {
        $check_query = "SELECT * FROM crop_farmer_zone_warehouse_info 
                        WHERE crop_id = '$crop_id' AND farmer_id = '$farmer_id' 
                        AND zone_num = '$zone_number' AND warehouse_num = '$warehouse_number'";
        $check_result = mysqli_query($conn, $check_query);

        if (mysqli_num_rows($check_result) > 0) {
            $update_query = "UPDATE crop_farmer_zone_warehouse_info 
                             SET quantity = quantity + $quantity, 
                                 cost = $price, 
                                 wh_delivery_date = '$delivery_date'
                             WHERE crop_id = '$crop_id' AND farmer_id = '$farmer_id' 
                             AND zone_num = '$zone_number' AND warehouse_num = '$warehouse_number'";

            if (mysqli_query($conn, $update_query)) {
                echo "Record updated successfully!";
            } else {
                echo "Error updating record: " . mysqli_error($conn);
            }
        } else {
            $insert_query = "INSERT INTO crop_farmer_zone_warehouse_info 
                             (crop_id, farmer_id, zone_num, warehouse_num, cost, wh_delivery_date, quantity,price_disc)
                             VALUES ('$crop_id', '$farmer_id', '$zone_number', '$warehouse_number', '$price', '$delivery_date', '$quantity','$price_disc')";

            if (mysqli_query($conn, $insert_query)) {
                echo "Crop warehouse details saved successfully!";
            } else {
                echo "Error inserting record: " . mysqli_error($conn);
            }
        }
    } else {
        echo "<script>alert('Storage Full: Not enough capacity in the selected warehouse.');</script>";
    }
}

mysqli_close($conn);
?>
