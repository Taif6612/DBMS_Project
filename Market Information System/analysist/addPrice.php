<?php
    session_start();

    if (!isset($_SESSION['active_user_id'])) {
        die("You must be logged in to view this page.");
    }
    $a_id = $_SESSION['active_user_id'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Farmers List</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/farmerdataStyle.css">
    <style>
    .buy-products {
        text-align: center;
        padding: 20px 20px;
        animation: fadeInUp 1s ease-out;
    }

    .buy-products h1 {
        font-size: 2.5rem;
        color: #2d7a57;
    }

    .products-container {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        align-items: center;
        gap: 20px;
        max-width: 1200px;
        margin: 0 auto;
    }

    .product-card {
        background: white;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        padding: 20px;
        display: flex;
        flex-direction: column;
        align-items: center;
        width: 250px;
        transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
    }

    .product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
    }


    .product-details {
        width: 100%;
        display: flex;
        flex-direction: column;
        gap: 8px;
        margin-bottom: 15px;
    }

    .product-detail-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .product-detail-item label {
        font-size: 0.85rem;
        flex-basis: 40%;
    }

    .product-detail-item input {
        font-size: 0.9rem;
        padding: 5px;
        width: 55%;
        background-color: #f0f0f0;
        border: none;
        border-radius: 3px;
        text-align: center;
    }

    .product-actions {
        margin-top: 10px;
        display: flex;
        gap: 8px;
    }

    .product-actions a {
        background: #38a169;
        color: white;
        padding: 6px 12px;
        text-decoration: none;
        border-radius: 5px;
        cursor: pointer;
        transition: background 0.3s, transform 0.3s;
        font-size: 14px;
    }

    .product-actions button {
        background: #38a169;
        color: white;
        padding: 6px 12px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        transition: background 0.3s, transform 0.3s;
        font-size: 14px;
    }

    .product-card a:hover {
        background: #2d7a57;
        transform: translateY(-3px);
    }

    .product-card button:hover {
        background: #2d7a57;
        transform: translateY(-3px);
    }
    </style>
</head>

<body>
    <header class="navbar">
        <div class="navbar-container">
            <div class="logo">FarmSmart</div>
            <nav class="menu">
                <a href="index.php"> Home</a>
                <a style="color:#ebde2b" href="addPrice.php">Post crops</a>
                <a href="allCrops.php">All crops</a>
            </nav>
            <div class="actions">
                <a href="profile.php" class="profile-icon"><?php echo $a_id;?></i></a>
                <a href="../FarmerUser/logoutProcess.php" class="logout-btn">Logout</a>
            </div>
        </div>
    </header>

    <section class="buy-products">
        <h1>Update Price</h1>

        <div class="products-container">
        <?php
            $conn = mysqli_connect("localhost", "root", "", "farmsmart");

            if (!$conn) {
                die("Connection failed" );
            }

            $sql = "SELECT crop_id, c_name 
                    FROM crop_information_per_farmer
                    WHERE crop_id NOT IN (SELECT crop_id FROM analysis_data_for_crops)";
            $result = mysqli_query($conn, $sql);

            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
            ?>
            <form class="product-card" method="post" action="deleteOrUpdate.php">
                <div class="product-details">
                    <div class="product-detail-item">
                        <label>Analysis ID</label>
                        <input type="text" name="analysis_id" value="<?php echo $a_id;?>" readonly>
                    </div>
                    <div class="product-detail-item">
                        <label>Crop ID:</label>
                        <input type="text" name="crop_id" value="<?php echo $row['crop_id']; ?>" readonly>
                    </div>
                    <div class="product-detail-item">
                        <label>Crop Name:</label>
                        <input type="text" name="crop_name" value="<?php echo $row['c_name']; ?>" readonly>
                    </div>
                    <div class="product-detail-item">
                        <label>Update Date:</label>
                        <input type="date" name="date" required>
                    </div>
                    <div class="product-detail-item">
                        <label>Unit Price:</label>
                        <input type="text" name="pricevalue" placeholder="Enter Price" required>
                    </div>
                </div>
                <div class="product-actions">
                <button type="submit" name="action" value="delete" class="add-to-cart">Delete</button>
                <button type="submit" name="action" value="update" class="add-to-cart">Update</button>
                </div>
            </form>
            <?php 
                }
            }
            ?>
        </div>
    </section>

    <footer>
        <p>&copy; 2024 FarmSmart. All Rights Reserved.</p>
    </footer>
</body>

</html>