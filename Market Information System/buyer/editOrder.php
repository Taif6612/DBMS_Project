<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Crops</title>
    <link rel="stylesheet" href="css/allOrderStyle.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>

    /* Form Container */
    .form-container {
        background-color: #ffffff;
        border-radius: 8px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        width: 400px;
        padding: 20px;
        box-sizing: border-box;
        margin: 50px auto;
    }

    /* Form Heading */
    .form-container h2 {
        text-align: center;
        margin-bottom: 20px;
        color: #333333;
        font-size: 24px;
    }

    /* Form Group */
    .form-group {
        margin-bottom: 15px;
    }

    label {
        display: block;
        font-size: 14px;
        color: #555555;
        margin-bottom: 5px;
    }

    input[type="text"],
    input[type="number"] {
        width: 100%;
        padding: 10px;
        border: 1px solid #cccccc;
        border-radius: 4px;
        box-sizing: border-box;
        font-size: 14px;
        color: #333333;
        transition: border-color 0.3s ease;
    }

    input[type="text"]:focus,
    input[type="number"]:focus {
        border-color: #38a169;
        outline: none;
    }

    /* Button */
    button {
        width: 100%;
        padding: 10px 15px;
        font-size: 16px;
        color: #ffffff;
        background: linear-gradient(135deg, #38a169, #2d7a57);
        border: none;
        border-radius: 4px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    button:hover {
        background: linear-gradient(135deg, #2d7a57, #38a169);
    }

    @media screen and (max-width: 480px) {
        .form-container {
            width: 90%;
            padding: 15px;
        }

        button {
            font-size: 14px;
        }
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
    <?php
        $conn = mysqli_connect("localhost", "root", "", "farmsmart");

        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        session_start();

        // Ensure user is logged in
        if (!isset($_SESSION['active_user_id'])) {
            die("You must be logged in to view this page.");
        }

        // Retrieve order and crop details from the GET request
        if (isset($_GET['order_id']) && isset($_GET['crop_id'])) {
            $order_id = $_GET['order_id'];
            $crop_id = $_GET['crop_id'];

            // Fetch quantity and unit price from order_crop_relationship
            $order_query = "SELECT quantity, unit_price FROM order_crop_relationship 
                            WHERE order_id = '$order_id' AND crop_id = '$crop_id'";
            $order_result = mysqli_query($conn, $order_query);

            if ($order_result && mysqli_num_rows($order_result) > 0) {
                $order_row = mysqli_fetch_assoc($order_result);
                $quantity = $order_row['quantity'];
                $unit_price = $order_row['unit_price'];
            } else {
                die("Order details not found.");
            }

            $crop_query = "SELECT c_name FROM crop_information_per_farmer 
                        WHERE crop_id = '$crop_id'";
            $crop_result = mysqli_query($conn, $crop_query);

            if ($crop_result && mysqli_num_rows($crop_result) > 0) {
                $crop_row = mysqli_fetch_assoc($crop_result);
                $crop_name = $crop_row['c_name'];
            } else {
                die("Crop details not found.");
            }
        } else {
            die("Invalid request.");
        }

        mysqli_close($conn);
    ?>

    <div class="form-container">
        <h2>Edit Order</h2>
        <form method="POST" action="updateOrderProcessing.php">
            <div class="form-group">
                <label for="crop_name">Crop Name:</label>
                <input type="text" id="crop_name" name="crop_name" value="<?php echo $crop_name; ?>" readonly>
            </div>
            <div class="form-group">
                <label for="quantity">Quantity:</label>
                <input type="number" id="quantity" name="quantity" value="<?php echo $quantity; ?>" required>
            </div>
            <input type="hidden" name="order_id" value="<?php echo $order_id; ?>">
            <input type="hidden" name="crop_id" value="<?php echo $crop_id; ?>">

            <button type="submit">Update Order</button>
        </form>
    </div>

    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</body>

</html>