<?php
session_start();

if (!isset($_SESSION['active_user_id'])) {
    die("You must be logged in to view this page.");
}

$conn = mysqli_connect("localhost", "root", "", "farmsmart");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if (isset($_GET['supply_id'])) {
    $supply_id = $_GET['supply_id'];
    $order_id = $_GET['order_id'];

    $detailsQuery = "SELECT crop_id, quantity FROM supply_crop_details WHERE supply_id = '$supply_id'";
    $detailsResult = mysqli_query($conn, $detailsQuery);

    if ($detailsRow = mysqli_fetch_assoc($detailsResult)) {
        $crop_id = $detailsRow['crop_id'];
        $quantity = $detailsRow['quantity'];

        $cropQuery = "SELECT c_name FROM crop_information_per_farmer WHERE crop_id = '$crop_id'";
        $cropResult = mysqli_query($conn, $cropQuery);
        $cropName = "Unknown";
        if ($cropRow = mysqli_fetch_assoc($cropResult)) {
            $cropName = $cropRow['c_name'];
        }
    } else {
        die("Supply details not found.");
    }
} else {
    die("Invalid request.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Order</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/editOrder.css">
</head>
<body>
    <div class="navbar">
        <div class="logo">FarmSmart</div>
        <div class="menu">
            <a href="index.php">Dashboard</a>
            <a href="browsecrops.php">Browse Crops</a>
            <a href="orders.php" class="active">My Purchases</a>
        </div>
        <div class="user-actions">
            <a href="profile.php"><i class="fa-solid fa-user profile-icon"></i></a>
            <a href="../FarmerUser/logoutProcess.php" class="logout">Logout</a>
        </div>
    </div>

    <section class="form-section">
        <h1>Edit Order</h1>
        <form action="update-order.php" method="POST" class="edit-form">
            <!-- Hidden Supply ID -->
            <div class="form-group">
                <label for="supply_id">Supply ID</label>
                <input type="text" id="supply_id" name="supply_id" value="<?php echo $supply_id; ?>" readonly>
                <input type="hidden" name="order_id" value="<?php echo $order_id; ?>">
            </div>

            <!-- Crop Name -->
            <div class="form-group">
                <label for="crop_name">Crop Name</label>
                <input type="text" id="crop_name" name="crop_name" value="<?php echo $cropName; ?>" readonly>
            </div>

            <!-- Editable Quantity -->
            <div class="form-group">
                <label for="quantity">Quantity (kg)</label>
                <input type="number" id="quantity" name="quantity" value="<?php echo $quantity; ?>" min="1" required>
            </div>

            <div class="form-action">
                <button type="submit" class="btn save-btn">Update Order</button>
            </div>
        </form>
    </section>
</body>
</html>

<?php
mysqli_close($conn);
?>
