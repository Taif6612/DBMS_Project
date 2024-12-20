<?php
session_start();

if (!isset($_SESSION['active_user_id'])) {
    die("You must be logged in to view this page.");
}
$s_id = $_SESSION['active_user_id']; 

$conn = mysqli_connect("localhost", "root", "", "farmsmart");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form inputs
    $supply_id = $_POST['supply_id'];
    $buyer_id = $_POST['buyer_id'];
    $crop_id = $_POST['crop_id'];
    $order_id = $_POST['order_id']; 
    $order_date = $_POST['order_date'];
    $quantity = $_POST['quantity'];
    $price = $_POST['price'];
    echo $crop_id;
    echo $order_id;
    $orderQuery = "SELECT quantity FROM order_crop_relationship WHERE crop_id = '$crop_id' AND order_id = '$order_id'";
    $orderResult = mysqli_query($conn, $orderQuery);

    if ($orderRow = mysqli_fetch_assoc($orderResult)) {
        $availableQuantity = $orderRow['quantity'];

        // Step 2: Check if the requested quantity is valid
        if ($quantity > $availableQuantity) {
            echo "Requested quantity exceeds available stock. Available quantity: $availableQuantity kg.";
            exit;
        } else {
            // Step 3: Update the remaining quantity in order_crop_relationship
            $newQuantity = $availableQuantity - $quantity;
            $updateOrderQuery = "UPDATE order_crop_relationship 
                                 SET quantity = '$newQuantity' 
                                 WHERE crop_id = '$crop_id' AND order_id = '$order_id'";

            if (!mysqli_query($conn, $updateOrderQuery)) {
                echo "Error updating order quantity: " . mysqli_error($conn);
                exit;
            }

            // Step 4: Insert data into supply_info table
            $supplyInfoQuery = "INSERT INTO supply_info (supply_id, buyer_id, supplier_id, supply_date) 
                                VALUES ('$supply_id', '$buyer_id', '$s_id', '$order_date')";
            if (!mysqli_query($conn, $supplyInfoQuery)) {
                echo "Error inserting into supply_info: " . mysqli_error($conn);
                exit;
            }	

            // Step 5: Insert data into supply_crop_details table
            $supplyCropDetailsQuery = "INSERT INTO supply_crop_details (supply_id, crop_id, quantity, unit_price) 
                                       VALUES ('$supply_id', '$crop_id', '$quantity', '$price')";
            if (!mysqli_query($conn, $supplyCropDetailsQuery)) {
                echo "Error inserting into supply_crop_details: " . mysqli_error($conn);
                exit;
            }

            echo "Order confirmed successfully!";
        }
    } else {
        echo "Crop not found for the specified order in the order_crop_relationship table.";
    }
} else {
    echo "Invalid request.";
}

mysqli_close($conn);
?>
