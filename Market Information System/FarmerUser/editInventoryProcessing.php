<?php
session_start();

if (!isset($_SESSION['active_user_id'])) {
    die("You must be logged in to perform this action.");
}

$f_id = $_SESSION['active_user_id'];

$conn = mysqli_connect("localhost", "root", "", "farmsmart");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$crop_id = $_POST['crop_id'] ;
$warehouse_num = $_POST['w_id'];
$zone_num = $_POST['z_id'];
$crop_name = $_POST['crop_name'];
$quantity = $_POST['quantity'];
$discount = $_POST['discount'];

$capacity_query = "SELECT storage_capacity 
                   FROM warehouse 
                   WHERE zone_num = '$zone_num' AND warehouse_num = '$warehouse_num'";
$capacity_result = mysqli_query($conn, $capacity_query);

if ($capacity_result && $row = mysqli_fetch_assoc($capacity_result)) {
    $storage_capacity = $row['storage_capacity'];
} else {
    die("Error: Unable to retrieve warehouse storage capacity.");
}

$total_quantity_query = "SELECT SUM(quantity) AS total_quantity 
                         FROM crop_farmer_zone_warehouse_info 
                         WHERE zone_num = '$zone_num' AND warehouse_num = '$warehouse_num'";
$total_quantity_result = mysqli_query($conn, $total_quantity_query);

if ($total_quantity_result && $total_row = mysqli_fetch_assoc($total_quantity_result)) {
    $current_total_quantity = $total_row['total_quantity'] ?? 0;
} else {
    die("Error: Unable to retrieve the current total quantity in the warehouse.");
}

$previous_quantity_query = "SELECT quantity 
                            FROM crop_farmer_zone_warehouse_info 
                            WHERE crop_id = '$crop_id' 
                            AND warehouse_num = '$warehouse_num' 
                            AND zone_num = '$zone_num' 
                            AND farmer_id = '$f_id'";
$previous_quantity_result = mysqli_query($conn, $previous_quantity_query);

if ($previous_quantity_result && $prev_row = mysqli_fetch_assoc($previous_quantity_result)) {
    $previous_quantity = $prev_row['quantity'];
} else {
    die("Error: Unable to retrieve the previous crop quantity.");
}

$new_total_quantity = ($current_total_quantity - $previous_quantity) + $quantity;

if ($new_total_quantity > $storage_capacity) {
    die("Error: Not enough storage space. Available capacity is exceeded.");
}

$update_query = "UPDATE crop_farmer_zone_warehouse_info 
                 SET quantity = '$quantity', price_disc = '$discount' 
                 WHERE crop_id = '$crop_id' 
                 AND warehouse_num = '$warehouse_num' 
                 AND zone_num = '$zone_num' 
                 AND farmer_id = '$f_id'";

if (mysqli_query($conn, $update_query)) {
    echo "<script>alert('Crop inventory updated successfully!');</script>";
    header("Location: http://localhost/Market%20Information%20System/FarmerUser/inventory.php");
    exit();
} else {
    echo "Error updating inventory: " . mysqli_error($conn);
}

mysqli_close($conn);
?>
