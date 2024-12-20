<?php
    session_start();

    if (!isset($_SESSION['active_user_id'])) {
        die("You must be logged in to view this page.");
    }
    $b_id = $_SESSION['active_user_id'];
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
    .products-container {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    gap: 20px;
    padding: 20px;
}

/* Warehouse Card */
.warehouse-card {
    background: linear-gradient(145deg, #ffffff, #f1f1f1);
    border-radius: 15px;
    box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    overflow: hidden;
    width: 350px;
}

.warehouse-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 15px 30px rgba(0, 0, 0, 0.2);
}

/* Card Header */
.card-header {
    background: linear-gradient(135deg, #38a169, #2d7a57);
    color: white;
    text-align: center;
    padding: 20px;
    border-bottom: 1px solid #e9ecef;
}

.card-header h2 {
    margin: 0;
    font-size: 1.8rem;
}

.card-header p {
    margin: 5px 0 0;
    font-size: 1rem;
}

/* Card Body */
.card-body {
    padding: 20px;
}

.form-group {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 15px;
}

.form-group label {
    font-weight: bold;
    font-size: 1rem;
    color: #555;
}

.form-group span {
    font-size: 1rem;
    color: #333;
}

/* View Details Button */
.view-details-btn {
    display: block;
    text-align: center;
    text-decoration: none;
    padding: 10px 20px;
    background-color: #28a745;
    color: white;
    font-size: 1rem;
    font-weight: bold;
    border-radius: 25px;
    transition: background-color 0.3s ease, box-shadow 0.3s ease;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    margin-top: 20px;
}

.view-details-btn:hover {
    background-color: #218838;
    box-shadow: 0 6px 15px rgba(0, 0, 0, 0.2);
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

    <section class="buy-products">
        <h1>All WareHouse</h1>


        <div class="products-container">
        <?php
            $conn = mysqli_connect("localhost","root","","farmsmart");
            if (!$conn) {
                die("Connection failed: " . mysqli_connect_error());
            }

            $sql1 = "SELECT * FROM warehouse";
            $result1 = mysqli_query($conn,$sql1);
            if(mysqli_num_rows($result1)>0){
                $i=0;
                while($row = mysqli_fetch_assoc($result1)){
                    $i=$i+1;
                    $z_num = $row['zone_num'];
                    $w_num = $row['warehouse_num'];
                    $sql2 = "SELECT SUM(quantity) AS total_quantity 
                             FROM crop_farmer_zone_warehouse_info 
                             WHERE zone_num = '$z_num' AND warehouse_num = '$w_num'";
                    $result2 = mysqli_query($conn, $sql2);
                    if ($result2) {
                        $total_row = mysqli_fetch_assoc($result2);
                        $total_quantity = $total_row['total_quantity'] ?? 0; 
                    } else {
                        die("Error: Unable to calculate total quantity.");
                    }
            ?>
            <div class="warehouse-card">
                <div class="card-header">
                    <h2>WareHouse <?php echo $i; ?></h2>
                    <p>Zone: <?php echo $row['zone_num']; ?></p>
                    <p>W.Number : <?php echo $row['warehouse_num']; ?></p>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label>Capacity:</label>
                        <span><?php echo $row['storage_capacity'].' kg'; ?></span>
                    </div>
                    <div class="form-group">
                        <label>Available Product :</label>
                        <span><?php echo $total_quantity.' kg'; ?></span>
                    </div>
                    <a href="warehouseDetails.php?zone_num=<?php echo $z_num;?>&warehouse_num=<?php echo $w_num;?>" class="view-details-btn">View WareHouse Item</a>
                </div>
            </div>
            <?php
                }
            }
            ?>
        </div>
    </section>

    <!-- FontAwesome for Icons -->
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</body>

</html>