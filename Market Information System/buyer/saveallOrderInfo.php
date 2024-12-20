<?php
$conn = mysqli_connect("localhost", "root", "", "farmsmart");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

session_start();

if (!isset($_SESSION['active_user_id'])) {
    die("You must be logged in to place an order.");
}

$b_id = $_SESSION['active_user_id'];
$order_id = $_POST['order_id'];
$order_date = $_POST['order_date'];
$zone_num = $_POST['zone_num'];
$warehouse_num = $_POST['warehouse_num'];
$crop_id = $_POST['crop-id'];
$farmer_id = $_POST['farmer-id'];
$quantity = $_POST['quantity'];
$unit_price = $_POST['unit_price'];
$payment_method = $_POST['payment_method'];

$check_quantity_query = "SELECT quantity FROM crop_farmer_zone_warehouse_info 
                          WHERE crop_id = '$crop_id' 
                          AND zone_num = '$zone_num' 
                          AND warehouse_num = '$warehouse_num'";

$check_result = mysqli_query($conn, $check_quantity_query);

if ($check_result && mysqli_num_rows($check_result) > 0) {
    $row = mysqli_fetch_assoc($check_result);
    $available_quantity = $row['quantity'];

    if ($available_quantity >= $quantity) {
        $order_details_query = "INSERT INTO order_details (order_id, buyer_id,farmer_id, zone_num, warehouse_num, order_date, payment)
                                VALUES ('$order_id', '$b_id', '$farmer_id', '$zone_num', '$warehouse_num', '$order_date', '$payment_method')";

        if (mysqli_query($conn, $order_details_query)) {
            $order_crop_query = "INSERT INTO order_crop_relationship (crop_id, order_id, quantity, unit_price)
                                 VALUES ('$crop_id', '$order_id', '$quantity', '$unit_price')";

            if (mysqli_query($conn, $order_crop_query)) {
                $update_quantity_query = "UPDATE crop_farmer_zone_warehouse_info 
                                          SET quantity = quantity - $quantity 
                                          WHERE crop_id = '$crop_id' 
                                          AND zone_num = '$zone_num' 
                                          AND warehouse_num = '$warehouse_num'";

                if (mysqli_query($conn, $update_quantity_query)) {
                    echo "Order successfully placed and inventory updated!";
                } else {
                    echo "Error updating inventory: " . mysqli_error($conn);
                }
            } else {
                echo "Error saving crop details: " . mysqli_error($conn);
            }
        } else {
            echo "Error saving order details: " . mysqli_error($conn);
        }
    } else {
        echo "Not enough crop in warehouse. Available quantity: $available_quantity.";
    }
} else {
    echo "Error retrieving crop details: " . mysqli_error($conn);
}

mysqli_close($conn);
?>