<?php
    $conn = mysqli_connect("localhost", "root", "", "farmsmart");
    session_start();

    if (!isset($_SESSION['active_user_id'])) {
        die("You must be logged in to view this page.");
    }
    $b_id = $_SESSION['active_user_id'];
    $bname_query = "SELECT buyer_name FROM buyer_information WHERE buyer_id='$b_id'";
    $b_result = mysqli_query($conn, $bname_query);
    if (mysqli_num_rows($b_result) > 0){
        $b_row = mysqli_fetch_assoc($b_result);
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buy Products</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/buyproductstyle.css">
    <style>
        /* Global Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Arial', sans-serif;
        }

        /* Form Container */
        .form-container {
            display: flex;
            width: 90%;
            max-width: 1100px;
            height: 75%;
            background: #fff;
            color: #333;
            border-radius: 15px;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.2);
            overflow: hidden;
            margin: 80px auto;
        }

        /* Left Section */
        .form-left,
        .form-right {
            flex: 1;
            padding: 30px;
        }

        .form-left {
            background: linear-gradient(135deg, #2d7a57, #38a169);
            color: #fff;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
        }

        .form-left h1 {
            font-size: 2rem;
            margin-bottom: 20px;
        }

        .form-left .form-group {
            margin-bottom: 20px;
        }

        .form-left label {
            font-weight: bold;
            display: block;
            margin-bottom: 8px;
        }

        .form-left input {
            width: 100%;
            padding: 10px;
            font-size: 1rem;
            border: none;
            border-radius: 6px;
            background: #f9f9f9;
        }

        /* Right Section */
        .form-right .form-header {
            margin-bottom: 10px;
            text-align: center;
        }

        .form-right h1 {
            font-size: 2rem;
            color: #2d7a57;
        }

        .form-right .form-group {
            margin-bottom: 20px;
        }

        .form-right label {
            font-weight: bold;
            display: block;
            margin-bottom: 8px;
        }

        .form-right input,
        .form-right select {
            width: 100%;
            padding: 10px;
            font-size: 1rem;
            border: 1px solid #ddd;
            border-radius: 6px;
            background: #f9f9f9;
        }

        .form-right .radio-group {
            display: flex;
            gap: 15px;
            text-align: center;
        }

        .form-right .radio-group input {
            margin-right: 5px;
        }

        /* Submit Button */
        .submit-btn {
            width: 100%;
            padding: 12px;
            background-color: #38a169;  
            color: white;
            font-size: 1.2rem;
            font-weight: bold;
            border: none;
            border-radius: 6px;
            transition: background-color 0.3s ease, box-shadow 0.3s ease;
            cursor: pointer;
            margin-top: 20px;
        }

        .submit-btn:hover {
            background-color: #2d7a57;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
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

    <div class="form-container">
        <div class="form-left">
            <h1>Order Details</h1>
            <form action="saveallOrderInfo.php" method="post">
                <div class="form-group">
                    <label for="order_id">Order ID</label>
                    <input type="text" name="order_id" value="<?php echo uniqid('order_');?>" readonly />
                </div>
                <div class="form-group">
                    <label for="order_date">Order Date</label>
                    <input type="date" name="order_date"/>
                </div>
                <div class="form-group">
                    <label for="zone_num">Zone Number</label>
                    <input type="text" name="zone_num" name="zone_num" value="<?php echo $_POST['z_num']?>" required />
                </div>
                <div class="form-group">
                    <label for="warehouse_num">Warehouse Number</label>
                    <input type="text" name="warehouse_num" name="warehouse_num" value="<?php echo $_POST['w_num']?>" required />
                </div>
        </div>

        <!-- Right Section -->
        <div class="form-right">
            <div class="form-header">
                <h1>Crop Information</h1>
            </div>
                <div class="form-group">
                    <label for="crop_name">Crop Name</label>
                    <input type="text" id="crop_name" name="crop_name" value="<?php echo $_POST['c_name']?>" readonly />
                    <input type="hidden" name="crop-id" value="<?php echo $_POST['crop-id']?>" readonly>
                    <input type="hidden" name="farmer-id" value="<?php echo $_POST['farmer-id']?>" readonly>
                </div>
                <div class="form-group">
                    <label for="quantity">Quantity</label>
                    <input type="number" id="quantity" name="quantity" placeholder="Enter Quantity" min="1" required />
                </div>
                <div class="form-group">
                    <label for="unit_price">Unit Price</label>
                    <input type="text" name="unit_price" value="<?php echo $_POST['crop-price']?>" readonly />
                </div>
                <div class="form-group">
                    <label>Payment Method</label>
                    <div class="radio-group">
                        <label><input type="radio" name="payment_method" value="BKash" required /> Bkash</label>
                        <label><input type="radio" name="payment_method" value="Nogod" required /> Nogod</label>
                        <label><input type="radio" name="payment_method" value="Rocket" required /> Rocket</label>
                        <label><input type="radio" name="payment_method" value="Hand Cash" required /> Hand Cash</label>
                    </div>
                </div>
                <button type="submit" class="submit-btn">Submit Order</button>
            
        </div>
        </form>
    </div>

    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</body>

</html>
