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
    <title>Buy Crop - Farmer UI</title>
    <!-- Bootstrap CSS -->
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

    .form-container {
        background-color: #fff;
        max-width: 500px;
        margin: 50px auto;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    h2 {
        text-align: center;
        color: #333;
    }

    label {
        display: block;
        margin-bottom: 8px;
        color: #555;
    }

    input[type="text"],
    input[type="number"],
    input[type="submit"] {
        width: 100%;
        padding: 8px;
        margin-bottom: 15px;
        border: 1px solid #ccc;
        border-radius: 4px;
    }

    input[type="submit"] {
        background-color: #007bff;
        color: #fff;
        border: none;
        cursor: pointer;
    }

    input[type="submit"]:hover {
        background-color: #0056b3;
    }

    button {
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

        button:hover {
            background-color: #45a049;
        }
    
    </style>
</head>

<body>
    <div class="background-image"></div>
    <div class="blur"></div>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <a class="navbar-brand" href="LandingFarmer.php">FarmSmart</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
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
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <img src="path/to/avatar-placeholder.png" alt="<?php echo $f_id?>"
                            style="width: 30px; height: 30px;">
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
        $conn = mysqli_connect("localhost", "root", "", "farmsmart");
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        $f_id = $_GET['f_id'] ?? '';
        $crop_id = $_GET['crop_id'] ?? '';
        $warehouse_num = $_GET['warehouse_num'] ?? '';
        $zone_num = $_GET['zone_num'] ?? '';

        $crop_name = '';
        $quantity = '';
        $discount = '';

        $crop_query = "SELECT c_name FROM crop_information_per_farmer WHERE crop_id = '$crop_id'";
        $crop_result = mysqli_query($conn, $crop_query);
        if ($crop_row = mysqli_fetch_assoc($crop_result)) {
            $crop_name = $crop_row['c_name'];
        }

        $inventory_query = "
            SELECT quantity, price_disc 
            FROM crop_farmer_zone_warehouse_info 
            WHERE crop_id = '$crop_id' 
            AND warehouse_num = '$warehouse_num' 
            AND zone_num = '$zone_num'
            AND farmer_id = '$f_id'
        ";
        $inventory_result = mysqli_query($conn, $inventory_query);
        if ($inventory_row = mysqli_fetch_assoc($inventory_result)) {
            $quantity = $inventory_row['quantity'];
            $discount = $inventory_row['price_disc'];
        }
    ?>

    <div class="form-container">
        <h2>Edit Crop Inventory</h2>
        <form method="POST" action="editInventoryProcessing.php">
            <label for="crop_name">Crop Name:</label>
            <input type="text" id="crop_name" name="crop_name" value="<?php echo $crop_name; ?>">
            <input type="hidden"  name="crop_id" value="<?php echo $crop_id; ?>">
            <input type="hidden"  name="w_id" value="<?php echo $warehouse_num; ?>">
            <input type="hidden"  name="z_id" value="<?php echo $zone_num; ?>">

            <label for="quantity">Quantity:</label>
            <input type="number" id="quantity" name="quantity" value="<?php echo $quantity; ?>">

            <label for="discount">Discount Percentage:</label>
            <input type="number" step="0.01" id="discount" name="discount"
                value="<?php echo $discount; ?>">

            <button type="submit">Update</button>
        </form>
    </div>


    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>