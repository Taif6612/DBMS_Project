<?php
$conn = mysqli_connect("localhost", "root", "", "farmsmart");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $order_id = $_POST['order_id'];
    $crop_id = $_POST['crop_id'];
    $quantity = $_POST['quantity'];

    $update_query = "UPDATE order_crop_relationship 
                     SET quantity = '$quantity' 
                     WHERE order_id = '$order_id' AND crop_id = '$crop_id'";

    if (mysqli_query($conn, $update_query)) {
        echo "Order updated successfully.";
        header("Location: http://localhost/Market%20Information%20System/buyer/allOrder.php"); 
        exit();
    } else {
        echo "Error updating order: " . mysqli_error($conn);
    }
} else {
    echo "Invalid request.";
}

mysqli_close($conn);
?>
