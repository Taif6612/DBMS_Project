<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Crops</title>
    <link rel="stylesheet" href="css/manage_cropsStyle.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="admin-panel">
        <header class="header">
            <h1>Admin Dashboard</h1>
            <div class="user-info">
                <span>Welcome, Admin</span>
                <a href="#" class="logout">Logout</a>
            </div>
        </header>

        <nav class="sidebar">
            <ul>
            <li><a href="admin.php">Dashboard</a></li>
                <li><a href="manage_user.php">Manage Users</a></li>
                <li><a href="manage-crops.php">Manage Recommendations</a></li>
                <li><a href="warehouse.php" class="active">Warehouse Management</a></li>
            </ul>
        </nav>

        <main class="content">
            <section id="manage-users">
                <h2>Manage Crops</h2>

                

                <!-- User Table -->
                <div class="table-container">
                <?php
                    $conn = mysqli_connect("localhost", "root", "", "farmsmart");

                    if (!$conn) {
                        die("Connection failed: " . mysqli_connect_error());
                    }

                    $search = "";
                    if (isset($_GET['search']) && !empty($_GET['search'])) {
                        $search = mysqli_real_escape_string($conn, $_GET['search']);
                    }
                    $warehouse_num = $_GET['warehouse_num'];
                    $sql = "SELECT * FROM crop_farmer_zone_warehouse_info WHERE warehouse_num='$warehouse_num'";
                    

                    $result = mysqli_query($conn, $sql);

                    if (!$result) {
                        die("Query Failed: " . mysqli_error($conn));
                    }
                    ?>

                    <table class="user-table">
                        <thead>
                            <tr>
                                <th>Crop Owner</th>
                                <th>Crop Name</th>
                                <th>Unit Cost</th>
                                <th>Discount Parcent</th>
                                <th>Deliver In</th>
                                <th>Quantity</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (mysqli_num_rows($result) > 0) {
                                while ($row = mysqli_fetch_assoc($result)) {
                                    $farmer_id = $row['farmer_id'];
                                    $crop_id = $row['crop_id'];
                                    $farmer_query = "SELECT farmer_name FROM farmer_information WHERE farmer_id = '$farmer_id'";
                                    $farmer_result = mysqli_query($conn, $farmer_query);

                                    $farmer_name = "Unknown";
                                    if ($farmer_result && mysqli_num_rows($farmer_result) > 0) {
                                        $farmer_row = mysqli_fetch_assoc($farmer_result);
                                        $farmer_name = $farmer_row['farmer_name'];
                                    }

                                    $crop_query = "SELECT c_name FROM crop_information_per_farmer WHERE crop_id = '$crop_id'";
                                    $crop_result = mysqli_query($conn, $crop_query);

                                    $crop_name = "Unknown";
                                    if ($crop_result && mysqli_num_rows($crop_result) > 0) {
                                        $crop_row = mysqli_fetch_assoc($crop_result);
                                        $crop_name = $crop_row['c_name'];
                                    }
                                    
                                    echo '<tr class="buyer">';
                                    echo '<td>' . $farmer_name . '</td>';
                                    echo '<td>' . $crop_name . '</td>';
                                    echo '<td>' . $row['cost'] . '</td>';
                                    echo '<td>' . $row['price_disc'] . '</td>';
                                    echo '<td>' . $row['wh_delivery_date'] . '</td>';
                                    echo '<td>' . $row['quantity'] . '</td>';
                                    echo '</tr>';
                                }
                            } else {
                                echo '<tr><td colspan="4">No crop data available.</td></tr>';
                            }
                            ?>
                        </tbody>
                    </table>


            </div>
            <?php
                $count_qiery = "SELECT COUNT(*) AS t_crop FROM crop_farmer_zone_warehouse_info WHERE warehouse_num='$warehouse_num'";
                $c_result = mysqli_query($conn,$count_qiery); 
                $t_crop = 0;
                if ($c_result && mysqli_num_rows($c_result) > 0) {
                    $c_row = mysqli_fetch_assoc($c_result);
                    $t_crop = $c_row['t_crop'];
                }
            ?>
            <div class="count-container">
                    <span class="count-result">Total Crops: <strong><?php echo $t_crop;?></strong></span>
            </div>
            <div class="count-container">
            <a href="editwarehouse.php?id=<?php echo $warehouse_num;?>" class="btn">Edit This WareHouse</a>
            </div>
            
            </section>
        </main>
    </div>
</body>
</html>