<?php
if (isset($_GET['zone_num']) && isset($_GET['warehouse_num'])) {
    $zone_num = $_GET['zone_num'];
    $warehouse_num = $_GET['warehouse_num'];
}
?>
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
    .menu-bar {
        background: #333;
        color: #fff;
        padding: 15px;
        text-align: center;
        font-size: 1.5rem;
        text-transform: uppercase;
    }

    .page-title {
        text-align: center;
        margin: 20px 0;
        animation: fadeIn 1s ease-in-out;
    }

    .page-title h2,
    .page-title h3 {
        margin: 5px;
        color: #333;
        font-weight: bold;
    }

    /* Animation */
    @keyframes fadeIn {
        0% {
            opacity: 0;
            transform: translateY(-20px);
        }

        100% {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes cardHover {
        0% {
            transform: scale(1);
        }

        100% {
            transform: scale(1.05);
        }
    }

    /* Card Container */
    .card-container {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 20px;
        margin: 20px;
    }

    /* Advanced Card Design */
    .card {
        background: #fff;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
        border-radius: 15px;
        padding: 20px;
        width: 320px;
        text-align: left;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .card:hover {
        box-shadow: 0 12px 30px rgba(0, 0, 0, 0.4);
    }

    .card-header {
        background: linear-gradient(to right, #4CAF50, #81C784);
        color: #fff;
        padding: 10px;
        border-radius: 10px;
        text-align: center;
        font-size: 1.2rem;
        margin-bottom: 15px;
    }

    .card-body label {
        font-weight: bold;
        display: block;
        margin-bottom: 5px;
        color: #555;
    }

    .card-body input {
        width: 100%;
        padding: 10px;
        margin-bottom: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
        background: #f9f9f9;
        font-size: 14px;
        transition: border 0.3s;
    }

    .card-body input:hover {
        border: 1px solid #4CAF50;
    }

    .process-order {
        width: 100%;
        background: linear-gradient(to right, #4CAF50, #81C784);
        color: white;
        border: none;
        padding: 12px;
        border-radius: 5px;
        cursor: pointer;
        font-size: 16px;
        text-transform: uppercase;
        transition: background 0.3s ease, transform 0.3s ease;
    }

    .process-order:hover {
        background: linear-gradient(to right, #388E3C, #4CAF50);
        transform: translateY(-2px);
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

    <div class="page-title">
        <h2>Warehouse :<span id="warehouse-number"><?php echo $warehouse_num; ?></span></h2>
        <h3>Zone :<span id="zone-number"><?php echo $zone_num; ?></span></h3>
    </div>


    <div class="card-container">
            <?php
            
            if (!$conn) {
                die("Connection failed: " . mysqli_connect_error());
            }
            $sql = "SELECT * 
                    FROM crop_farmer_zone_warehouse_info 
                    WHERE warehouse_num = '$warehouse_num' AND zone_num = '$zone_num'";

            $result = mysqli_query($conn, $sql);

            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $crop_id = $row['crop_id'];
                    $cost = $row['cost'];
                    $quantity = $row['quantity'];
                    $disc = $row['price_disc'];
                    $cost_after_disc = $cost - ($disc*$cost)/100;
                    $farmer_id = $row['farmer_id'];
                    $sql2 = "SELECT c_name FROM crop_information_per_farmer WHERE crop_id='$crop_id'";
                    $result2 = mysqli_query($conn, $sql2);
                    if (mysqli_num_rows($result2) > 0){
                        $row2 = mysqli_fetch_assoc($result2);
                    }

                    $sql3 = "SELECT farmer_name FROM farmer_information WHERE farmer_id='$farmer_id'";
                    $result3 = mysqli_query($conn, $sql3);
                    if (mysqli_num_rows($result3) > 0){
                        $row3 = mysqli_fetch_assoc($result3);
                    }
            ?>
        <div class="card">
        <form action="preOrder.php" method="POST">
                <div class="card-header">
                    <h4>Crop : <span><?php echo $row2['c_name']; ?></span></h4>
                </div>
                <div class="card-body">
                    <input type="hidden" name="crop-id" value="<?php echo $crop_id; ?>" readonly>
                    <input type="hidden" name="farmer-id" value="<?php echo $farmer_id; ?>" readonly>
                    <input type="hidden" name="w_num" value="<?php echo $warehouse_num; ?>" readonly>
                    <input type="hidden" name="z_num" value="<?php echo $zone_num; ?>" readonly>
                    <input type="hidden" name="c_name" value="<?php echo $row2['c_name']; ?>" readonly>
                    <input type="hidden" name="disc" value="<?php echo $disc; ?>" readonly>

                    <label for="crop-price">Unit Price(Per Kg):</label>
                    <input type="text" id="crop-price" name="crop-price" value="<?php echo $cost_after_disc.' Taka'; ?>" readonly>

                    <label>In Stoke:</label>
                    <input type="text" name="stoke" value="<?php echo $quantity.' kg'; ?>" readonly>

                    <label for="salesperson">Salesperson:</label>
                    <input type="text" id="salesperson" name="salesperson" value="<?php echo $row3['farmer_name']; ?>" readonly>
                </div>
                <button type="submit" class="process-order">Buy This Crop</button>
            </form>
        </div>
        <?php
            }
        } else {
            echo "<p>No crops available in this warehouse.</p>";
        }

        mysqli_close($conn);
        ?>
    </div>


    <!-- FontAwesome for Icons -->
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</body>

</html>