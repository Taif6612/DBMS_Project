<?php
$conn = mysqli_connect("localhost", "root", "", "farmsmart");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if (isset($_GET['buyer_id']) && isset($_GET['crop_id'])) {
    $buyer_id = $_GET['buyer_id'];
    $crop_id = $_GET['crop_id'];
    $order_id = $_GET['order_id'];

    $supply_id = uniqid("supply_");

    // Fetch buyer name
    $buyerName = "";
    $buyerQuery = "SELECT buyer_name FROM buyer_information WHERE buyer_id = '$buyer_id'";
    $buyerResult = mysqli_query($conn, $buyerQuery);
    if ($buyerRow = mysqli_fetch_assoc($buyerResult)) {
        $buyerName = $buyerRow['buyer_name'];
    }

    // Fetch crop name
    $cropName = "";
    $cropQuery = "SELECT c_name FROM crop_information_per_farmer WHERE crop_id = '$crop_id'";
    $cropResult = mysqli_query($conn, $cropQuery);
    if ($cropRow = mysqli_fetch_assoc($cropResult)) {
        $cropName = $cropRow['c_name'];
    }

    $price = "";
    $priceQuery = "SELECT price_value FROM analysis_data_for_crops WHERE crop_id = '$crop_id'";
    $priceResult = mysqli_query($conn, $priceQuery);
    if ($priceRow = mysqli_fetch_assoc($priceResult)) {
        $price = $priceRow['price_value'];
    }

} else {
    echo "Invalid request.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FarmSmart - My Purchases</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/buynow.css">
</head>
<body>
    <!-- Navbar -->
    <div class="navbar">
        <div class="logo">FarmSmart</div>
        <div class="menu">
            <a href="index.php">Dashboard</a>
            <a href="browsecrops.php">Browse Crops</a>
            <a class="active" href="orders.php">My Purchases</a>
        </div>
        <div class="user-actions">
            <a href="profile.php"><i class="fa-solid fa-user profile-icon"></i></a>
            <a href="../FarmerUser/logoutProcess.php" class="logout">Logout</a>
        </div>
    </div>

    <section class="hero">
        <div class="hero-content">
            <h1>Order Crop</h1>
            <p>Fill in the details below to place your order.</p>
        </div>
    </section>

    <section class="form-section">
        <form action="process_order.php" method="POST" class="order-form">
            <div class="form-group">
                <label for="supply_id">Supply ID</label>
                <input type="text" id="supply_id" name="supply_id" value="<?php echo $supply_id; ?>" readonly>
                <input type="hidden" name="buyer_id" value="<?php echo $buyer_id; ?>">
                <input type="hidden" name="crop_id" value="<?php echo $crop_id; ?>">
                <input type="hidden" name="order_id" value="<?php echo $order_id; ?>"> 
            </div>

            <div class="form-group">
                <label for="buyer_name">Buyer Name</label>
                <input type="text" id="buyer_name" name="buyer_name" value="<?php echo $buyerName; ?>" readonly>
            </div>

            <div class="form-group">
                <label for="order_date">Order Date</label>
                <input type="date" id="order_date" name="order_date" required>
            </div>

            <div class="form-group">
                <label for="quantity">Quantity (kg)</label>
                <input type="number" id="quantity" name="quantity" placeholder="Enter Quantity" min="1" required>
            </div>

            <div class="form-group">
                <label for="crop_name">Crop Name</label>
                <input type="text" id="crop_name" name="crop_name" value="<?php echo $cropName; ?>" readonly>
            </div>

            <div class="form-group">
                <label for="price">Price per kg ($)</label>
                <input type="text" id="price" name="price" value="<?php echo $price; ?>" readonly>
            </div>

            <div class="form-action">
                <button type="submit" class="btn">Confirm Order</button>
            </div>
        </form>
    </section>
</body>
</html>
