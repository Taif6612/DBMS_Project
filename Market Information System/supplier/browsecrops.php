<?php
session_start();

if (!isset($_SESSION['active_user_id'])) {
    die("You must be logged in to view this page.");
}
$s_id = $_SESSION['active_user_id'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FarmSmart - Browse Crops</title>
    <!-- Font Awesome Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/browsecrops.css">
    <style>
        .search-form {
            display: flex;
            align-items: center;
            background: #ffffff;
            border: 1px solid #ddd;
            border-radius: 50px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            transition: box-shadow 0.3s ease;
            width: 400px;
            margin: 0 auto;
            margin-bottom: 30px;
        }

        .search-form:hover {
            box-shadow: 0 6px 10px rgba(0, 0, 0, 0.15);
        }

        .search-input {
            flex: 1;
            border: none;
            padding: 12px 20px;
            font-size: 16px;
            outline: none;
            border-radius: 50px 0 0 50px;
            transition: background 0.3s ease;
        }

        .search-input::placeholder {
            color: #aaa;
        }

        .search-input:focus {
            background: #f0f0f0;
        }

        .search-btn {
            background-color: #00796b;
            color: white;
            border: none;
            padding: 12px 20px;
            font-size: 16px;
            cursor: pointer;
            transition: background 0.3s ease;
            border-radius: 0 50px 50px 0;
        }

        .search-btn:hover {
            background-color: #004d40;
        }

        .search-btn:focus {
            outline: none;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <div class="navbar">
        <div class="logo">FarmSmart</div>
        <div class="menu">
            <a href="index.php">Dashboard</a>
            <a class="active" href="browsecrops.php">Browse Crops</a>
            <a href="orders.php">My Purchases</a>
        </div>
        <div class="user-actions">
            <a href="profile.php"><i class="fa-solid fa-user profile-icon"></i></a>
            <a href="../FarmerUser/logoutProcess.php" class="logout">Logout</a>
        </div>
    </div>

    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-content">
            <h1>Browse Crops</h1>
            <p>Discover the freshest crops from reliable sellers and make your best choice today!</p>
        </div>
    </section>

    <!-- Crops Section -->
    <section class="content">
        <h2>Available Crops</h2>
        <form action="" method="GET" class="search-form">
            <input type="text" name="search" class="search-input" placeholder="Search by crop name..." value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
            <button type="submit" class="btn search-btn">Search</button>
        </form>
        <div class="crop-cards">

        <?php
        $conn = mysqli_connect("localhost", "root", "", "farmsmart");

        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        // Add a search filter if provided
        $search_query = '';
        if (isset($_GET['search']) && !empty($_GET['search'])) {
            $search_query = mysqli_real_escape_string($conn, $_GET['search']);
        }

        $orderCropQuery = "SELECT * FROM order_crop_relationship";
        if (!empty($search_query)) {
            $orderCropQuery .= " WHERE crop_id IN (
                SELECT crop_id FROM crop_information_per_farmer WHERE c_name LIKE '%$search_query%'
            )";
        }

        $orderCropResult = mysqli_query($conn, $orderCropQuery);

        if (mysqli_num_rows($orderCropResult) > 0) {
            while ($orderCropRow = mysqli_fetch_assoc($orderCropResult)) {
                $crop_id = $orderCropRow['crop_id'];
                $quantity = $orderCropRow['quantity'];
                $unit_price = $orderCropRow['unit_price'];
                $order_id = $orderCropRow['order_id'];

                // Fetch crop name
                $cropName = '';
                $cropInfoQuery = "SELECT c_name FROM crop_information_per_farmer WHERE crop_id = '$crop_id'";
                $cropInfoResult = mysqli_query($conn, $cropInfoQuery);

                if (mysqli_num_rows($cropInfoResult) > 0) {
                    $cropNameRow = mysqli_fetch_assoc($cropInfoResult);
                    $cropName = $cropNameRow['c_name'];
                }

                // Fetch posting date and price
                $postingDate = '';
                $price = '';
                $analysisQuery = "SELECT date, price_value FROM analysis_data_for_crops WHERE crop_id = '$crop_id'";
                $analysisResult = mysqli_query($conn, $analysisQuery);

                if (mysqli_num_rows($analysisResult) > 0) {
                    $analysisRow = mysqli_fetch_assoc($analysisResult);
                    $postingDate = $analysisRow['date'];
                    $price = $analysisRow['price_value'];
                }

                // Fetch seller name
                $sellerName = '';
                $buyerQuery = "SELECT buyer_id FROM order_details WHERE order_id = '$order_id'";
                $buyerResult = mysqli_query($conn, $buyerQuery);

                if (mysqli_num_rows($buyerResult) > 0) {
                    $buyerRow = mysqli_fetch_assoc($buyerResult);
                    $buyer_id = $buyerRow['buyer_id'];

                    $buyerInfoQuery = "SELECT buyer_name FROM buyer_information WHERE buyer_id = '$buyer_id'";
                    $buyerInfoResult = mysqli_query($conn, $buyerInfoQuery);

                    if (mysqli_num_rows($buyerInfoResult) > 0) {
                        $buyerInfoRow = mysqli_fetch_assoc($buyerInfoResult);
                        $sellerName = $buyerInfoRow['buyer_name'];
                    }
                }

                // Display crop card
                ?>
                <div class="crop-card">
                    <h3><?php echo $cropName; ?></h3>
                    <p><strong>Posting Date:</strong> <?php echo $postingDate; ?></p>
                    <p><strong>Price:</strong> <?php echo $price; ?> per kg</p>
                    <p><strong>Available Quantity:</strong> <?php echo $quantity; ?> kg</p>
                    <p><strong>Seller:</strong> <?php echo $sellerName; ?></p>
                    <a href="buyNow.php?buyer_id=<?php echo $buyer_id; ?>&crop_id=<?php echo $crop_id; ?>&order_id=<?php echo $order_id; ?>" class="btn">Buy Now</a>
                </div>
                <?php
            }
        } else {
            echo "<p>No crops found.</p>";
        }

        mysqli_close($conn);
        ?>
        </div>
    </section>
</body>
</html>
