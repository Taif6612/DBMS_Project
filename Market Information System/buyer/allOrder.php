<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['active_user_id'])) {
    die("You must be logged in to view this page.");
}

// Database connection
$conn = mysqli_connect("localhost", "root", "", "farmsmart");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$b_id = $_SESSION['active_user_id'];

// Search filter setup
$search_keyword = "";
if ($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['search_crop'])) {
    $search_keyword = mysqli_real_escape_string($conn, $_POST['search_crop']);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Crops</title>
    <link rel="stylesheet" href="css/allOrderStyle.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        /* Search input styling */
        .search-section {
            text-align: center;
            margin: 20px 0;
        }

        .search-section form {
            display: inline-flex;
            align-items: center;
            gap: 10px;
        }

        .search-section input[type="text"] {
            width: 250px;
            padding: 10px;
            font-size: 16px;
            border: 2px solid #ddd;
            border-radius: 5px;
            outline: none;
            transition: border-color 0.3s ease;
        }

        .search-section input[type="text"]:focus {
            border-color: #4CAF50;
        }

        .search-section button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 15px;
            font-size: 16px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .search-section button:hover {
            background-color: #45a049;
        }
    </style>
</head>

<body>
    <!-- Navbar -->
    <div class="navbar">
        <div class="logo">FarmSmart</div>
        <div class="menu">
            <a href="index.php">Home</a>
            <a href="buyproduct.php">Buy Products</a>
            <a href="allOrder.php">My Product</a>
        </div>
        <div class="user-actions">
            <a href="profile.php"><i class="fa-solid fa-user profile-icon"></i></a>
            <a href="../FarmerUser/logoutProcess.php" class="logout">Logout</a>
        </div>
    </div>

    <section class="search-section">
        <form method="POST" action="allOrder.php">
            <input type="text" name="search_crop" placeholder="Search by crop name" value="<?php echo htmlspecialchars($search_keyword); ?>">
            <button type="submit" class="search-btn">Search</button>
        </form>
    </section>

    <section class="orders-section">
        <h1>Ordered Products</h1>
        <div class="orders-container">
            <?php
            $order_query = "SELECT order_id, order_date FROM order_details WHERE buyer_id = '$b_id'";
            $order_result = mysqli_query($conn, $order_query);

            if (mysqli_num_rows($order_result) > 0) {
                while ($order_row = mysqli_fetch_assoc($order_result)) {
                    $order_id = $order_row['order_id'];
                    $order_date = $order_row['order_date'];

                    $crop_relation_query = "SELECT crop_id, quantity, unit_price 
                                            FROM order_crop_relationship 
                                            WHERE order_id = '$order_id'";
                    $crop_relation_result = mysqli_query($conn, $crop_relation_query);

                    while ($crop_row = mysqli_fetch_assoc($crop_relation_result)) {
                        $crop_id = $crop_row['crop_id'];
                        $quantity = $crop_row['quantity'];
                        $unit_price = $crop_row['unit_price'];
                        $total_price = $quantity * $unit_price;

                        if (!empty($search_keyword)) {
                            $crop_name_query = "SELECT c_name FROM crop_information_per_farmer 
                                                WHERE crop_id = '$crop_id' AND c_name LIKE '%$search_keyword%'";
                        } else {
                            $crop_name_query = "SELECT c_name FROM crop_information_per_farmer 
                                                WHERE crop_id = '$crop_id'";
                        }

                        $crop_name_result = mysqli_query($conn, $crop_name_query);
                        $crop_name_row = mysqli_fetch_assoc($crop_name_result);

                        if (!empty($search_keyword) && !$crop_name_row) {
                            continue;
                        }

                        $crop_name = $crop_name_row['c_name'] ?? "Unknown";

                        ?>
                        <form class="order-item">
                            <div class="order-details">
                                <div class="form-group">
                                    <label>Product Name:</label>
                                    <input type="text" value="<?php echo htmlspecialchars($crop_name); ?>" readonly>
                                </div>
                                <div class="form-group">
                                    <label>Quantity:</label>
                                    <input type="number" value="<?php echo $quantity; ?>" readonly>
                                </div>
                                <div class="form-group">
                                    <label>Unit Price:</label>
                                    <input type="text" value="<?php echo $unit_price; ?>" readonly>
                                </div>
                                <div class="form-group">
                                    <label>Total Price:</label>
                                    <input type="text" value="<?php echo $total_price . " BDT"; ?>" readonly>
                                </div>
                                <div class="form-group">
                                    <label>Order Date:</label>
                                    <input type="text" value="<?php echo $order_date; ?>" readonly>
                                </div>
                            </div>
                            <div class="order-actions">
                                <a href="editOrder.php?order_id=<?php echo $order_id; ?>&crop_id=<?php echo $crop_id; ?>" class="edit-order-btn">Edit</a>
                                <button type="button" class="delete-order-btn">Delete</button>
                            </div>
                        </form>
                        <?php
                    }
                }
            } else {
                echo "<p>No orders found for this buyer.</p>";
            }

            mysqli_close($conn);
            ?>
        </div>
    </section>
</body>

</html>
