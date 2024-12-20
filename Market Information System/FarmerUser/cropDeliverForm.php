<?php
    session_start();

    if (!isset($_SESSION['active_user_id'])) {
        die("You must be logged in to view this page.");
    }
    $f_id = $_SESSION['active_user_id'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sell Crop - Farmer UI</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
    body {
        margin: 0;
        /* Remove default margin */
    }

    .navbar {
        background-color: rgba(0, 95, 54, 0.8);
        /* Dark green with transparency */
        z-index: 3;
        /* Above blur layer */
    }

    .navbar-brand {
        font-size: 1.5rem;
        /* Adjust the font size */
        font-weight: bold;
        /* Make it bold */
        color: #ffffff;
        /* Change the text color to white */
    }

    .navbar-brand:hover {
        color: #e0e0e0;
        /* Change color on hover */
    }

    .content {
        position: relative;
        /* To keep content above blur layer */
        z-index: 4;
        /* Highest z-index for content */
        padding: 20px;
        /* Add padding for spacing */
    }

    .btn-primary {
        background-color: #007B5F;
        /* Darker green for buttons */
        border: none;
    }

    .btn-primary:hover {
        background-color: #005f36;
        /* Dark green on hover */
    }

    h2,
    p {
        text-align: center;
    }

    .form-container {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            padding: 30px;
            width: 400px;
            animation: fadeIn 1s ease-in-out;
            margin: 30px auto
        }

        h2 {
            text-align: center;
            color: #333;
            font-size: 24px;
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            font-size: 16px;
            color: #555;
            margin-bottom: 5px;
        }

        .form-group input,
        .form-group select {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            border: 2px solid #ddd;
            border-radius: 5px;
            transition: all 0.3s ease;
        }

        .form-group input:focus,
        .form-group select:focus {
            border-color: #4CAF50;
            box-shadow: 0 0 8px rgba(76, 175, 80, 0.3);
        }

        .form-group input[type="date"] {
            cursor: pointer;
        }

        .form-group button {
            width: 100%;
            padding: 12px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .form-group button:hover {
            background-color: #45a049;
        }

        /* Animation for form fade-in */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-50px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>

<body>
    <div class="background-image"></div>
    <div class="blur"></div>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark">
    <a class="navbar-brand" href="LandingFarmer.php">FarmSmart</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link" href="postCrop.php">Post Crops</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="sell.php">Deliver In warehouse</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="inventory.php">Crop Inventory</a>
            </li>
            <!-- Avatar and Logout Button -->
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <img src="path/to/avatar-placeholder.png" alt="<?php echo $f_id?>" style="width: 30px; height: 30px;">
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="profile.php">Profile</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="logoutProcess.php">Logout</a>
                </div>
            </li>
        </ul>
    </div>
</nav>
<?php
        $crop_id = $_POST['crop'];
        $conn = mysqli_connect("localhost", "root", "", "farmsmart");

        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        // Fetch market price and crop name
        $sql = "SELECT price_value FROM analysis_data_for_crops WHERE crop_id = '$crop_id'";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);

        $crop_name = ""; 
        $name_sql = "SELECT c_name FROM crop_information_per_farmer WHERE crop_id = '$crop_id' AND farmer_id = '$f_id'";
        $name_result = mysqli_query($conn, $name_sql);
        if ($name_result && mysqli_num_rows($name_result) > 0) {
            $name_row = mysqli_fetch_assoc($name_result);
            $crop_name = $name_row['c_name'];
        }
    ?>
    <div class="form-container">
        <h2>Enter Details</h2>
        <form action="saveCropWarehouseDetails.php" method="POST">
            <input type="hidden" name="farmer_id" value="<?php echo $f_id; ?>">

            <div class="form-group">
                <label for="crop_id">Crop Name:</label>
                <input type="text" name="crop_name" value="<?php echo $crop_name; ?>" readonly>
                <input type="hidden" name="crop_id" value="<?php echo $crop_id; ?>" readonly>
            </div>

            <div class="form-group">
                <label for="price">Market Price:</label>
                <input type="text" id="price" name="price" value="<?php echo $row['price_value']; ?>" readonly>
            </div>

            <div class="form-group">
                <label for="price_disc">Discount Percentage:</label>
                <input type="text" id="price_disc" name="price_disc" placeholder="Enter The Percentage of Discount">
            </div>

            <div class="form-group">
                <label for="warehouse">Select Warehouse:</label>
                <select id="warehouse" name="warehouse" required>
                    <option value="">-- Select Warehouse --</option>
                    <?php
                        $wsql = "SELECT zone_num, warehouse_num FROM warehouse";
                        $wresult = mysqli_query($conn, $wsql);
                        if (mysqli_num_rows($wresult) > 0) {
                            while ($wrow = mysqli_fetch_assoc($wresult)) {
                                $zone_number = $wrow['zone_num'];
                                $warehouse_number = $wrow['warehouse_num'];
                                echo "<option value='$warehouse_number - $zone_number'>Zone $zone_number - Warehouse $warehouse_number</option>";
                            }
                        } else {
                            echo "<option value=''>No warehouses available</option>";
                        }
                        mysqli_close($conn);
                    ?>
                </select>
            </div>

            <div class="form-group">
                <label for="quantity">Quantity:</label>
                <input type="text" id="quantity" name="quantity" required>
            </div>

            <div class="form-group">
                <label for="delivery_date">Delivery Date:</label>
                <input type="date" id="delivery_date" name="delivery_date" required>
            </div>

            <div class="form-group">
                <button type="submit">Save Details</button>
            </div>
        </form>
    </div>



    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>