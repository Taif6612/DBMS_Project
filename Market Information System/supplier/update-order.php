<?php
session_start();

if (!isset($_SESSION['active_user_id'])) {
    die("You must be logged in to view this page.");
}

$conn = mysqli_connect("localhost", "root", "", "farmsmart");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $supply_id = $_POST['supply_id'];
    $new_quantity = $_POST['quantity'];
    $order_id = $_POST['order_id'];

    $detailsQuery = "SELECT quantity, crop_id FROM supply_crop_details WHERE supply_id = '$supply_id'";
    $detailsResult = mysqli_query($conn, $detailsQuery);
    $detailsRow = mysqli_fetch_assoc($detailsResult);

    if ($detailsRow) {
        $current_quantity = $detailsRow['quantity'];
        $crop_id = $detailsRow['crop_id'];

        // Fetch the available quantity in order_crop_relationship
        $stockQuery = "SELECT quantity FROM order_crop_relationship WHERE crop_id = '$crop_id' AND order_id = '$order_id'";
        $stockResult = mysqli_query($conn, $stockQuery);
        $stockRow = mysqli_fetch_assoc($stockResult);

        if ($stockRow) {
            $available_stock = $stockRow['quantity'];

            // Calculate the difference in quantity
            $quantity_difference = $new_quantity - $current_quantity;

            // Check if the new quantity is greater than the available stock
            if ($available_stock < $quantity_difference) {
                die("Error: Insufficient stock available.");
            }

            if ($quantity_difference > 0) {
                $new_available_stock = $available_stock - $quantity_difference;
                $updateStockQuery = "UPDATE order_crop_relationship 
                                     SET quantity = '$new_available_stock' 
                                     WHERE crop_id = '$crop_id' AND order_id = '$order_id'";
                mysqli_query($conn, $updateStockQuery);
            }

            elseif ($quantity_difference < 0) {
                $new_available_stock = $available_stock + abs($quantity_difference);
                $updateStockQuery = "UPDATE order_crop_relationship 
                                     SET quantity = '$new_available_stock' 
                                     WHERE crop_id = '$crop_id' AND order_id = '$order_id'";
                mysqli_query($conn, $updateStockQuery);
            }

            $updateDetailsQuery = "UPDATE supply_crop_details 
                                   SET quantity = '$new_quantity' 
                                   WHERE supply_id = '$supply_id'";
            if (mysqli_query($conn, $updateDetailsQuery)) {
                echo "Order updated successfully!";
            } else {
                echo "Error updating order: " . mysqli_error($conn);
            }
        } else {
            die("Error: No matching entry found in the order_crop_relationship table.");
        }
    } else {
        die("Error: No matching entry found in the supply_crop_details table.");
    }
}
?>
