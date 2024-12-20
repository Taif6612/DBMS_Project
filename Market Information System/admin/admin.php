<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
    .bar-wrapper {
        display: flex;
        flex-direction: column;
        align-items: center;
        width: 10%;
        position: relative;
        margin-top: auto;
    }

    .bar {
        width: 100%;
        background-color: #82cfae;
        text-align: center;
        color: #353232;
        font-size: 0.9rem;
        line-height: 1.5;
        border-radius: 5px 5px 0 0;
        transition: background-color 0.3s ease;
        display: flex;
        align-items: flex-end;
        justify-content: center;
        font-weight: bold;
    }

    .bar:hover {
        background-color: #75b69a;
    }

    .xValue {
        margin-top: 10px;
        font-size: 0.9rem;
        color: #333;
        font-weight: bold;
        text-align: center;
        transform: rotate(0deg);
        position: absolute;
        bottom: -32px;
        white-space: nowrap;
    }
    </style>
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
                <li><a href="admin.php" class="active">Dashboard</a></li>
                <li><a href="manage_user.php">Manage Users</a></li>
                <li><a href="manage-crops.php">Manage Recommendations</a></li>
                <li><a href="warehouse.php">Warehouse Management</a></li>
            </ul>
        </nav>

        <main class="content">
            <section id="dashboard">
                <h2>Dashboard Overview</h2>
                <div class="cards">
                <?php
                    $conn = mysqli_connect("localhost", "root", "", "farmsmart");

                    if (!$conn) {
                        die("Connection failed: " . mysqli_connect_error());
                    }

                    $query = "
                        SELECT COUNT(*) AS total_users FROM (
                            SELECT buyer_id AS user_id FROM buyer_information
                            UNION ALL
                            SELECT farmer_id AS user_id FROM farmer_information
                            UNION ALL
                            SELECT analysist_id AS user_id FROM analysist_information
                            UNION ALL
                            SELECT supplier_id AS user_id FROM supplier_information
                        ) AS all_users
                    ";

                    $result = mysqli_query($conn, $query);
                    $total_users = 0;

                    if ($result) {
                        $row = mysqli_fetch_assoc($result);
                        $total_users = $row['total_users'];
                    } else {
                        die("Query Failed: " . mysqli_error($conn));
                    }

                    mysqli_close($conn);
                ?>
                    <a href="manage_user.php" class="card-link">
                        <div class="card">
                            <h3>Total Users</h3>
                            <p><?php echo $total_users; ?></p>
                        </div>
                    </a>
                    <a href="warehouse.php" class="card-link">
                        <div class="card">
                            <h3>Type of Crop In Warehouse</h3>
                            <p>
                                <?php
                            $conn = mysqli_connect("localhost", "root", "", "farmsmart");

                            if (!$conn) {
                                die("Connection failed: " . mysqli_connect_error());
                            }
                            $sql = "SELECT COUNT(*) AS total_crops FROM crop_farmer_zone_warehouse_info";
                            $result = mysqli_query($conn, $sql);
                            if ($result) {
                                $row = mysqli_fetch_assoc($result);
                                echo $row['total_crops']; 
                            } else {
                                echo "0"; 
                            }

                            
                            mysqli_close($conn);
                            ?>
                            </p>
                        </div>
                    </a>
                    <a href="viewall_crop.php" class="card-link">
                        <div class="card">
                            <h3>Total Crops</h3>
                            <p>
                                <?php
                            $conn = mysqli_connect("localhost", "root", "", "farmsmart");

                            if (!$conn) {
                                die("Connection failed: " . mysqli_connect_error());
                            }
                            $sql = "SELECT COUNT(*) AS total_crops FROM analysis_data_for_crops";
                            $result = mysqli_query($conn, $sql);
                            if ($result) {
                                $row = mysqli_fetch_assoc($result);
                                echo $row['total_crops']; 
                            } else {
                                echo "0"; 
                            }

                            
                            mysqli_close($conn);
                            ?>
                            </p>
                        </div>
                    </a>
                </div>
            </section>
            <section id="data-analysis">
                <h2>Data Analysis</h2>

                <div class="chart-section">
                    <h3>Farmer Crop Analysis</h3>
                    <p>x-Farmers <br> y-Crops Sell Quantity</p>
                    <div class="bar-chart">
                    <?php
                    $conn = mysqli_connect("localhost", "root", "", "farmsmart");

                    if (!$conn) {
                        die("Connection failed: " . mysqli_connect_error());
                    }

                    $query1 = "SELECT farmer_id, crop_id, quantity FROM crop_farmer_zone_warehouse_info";
                    $result1 = mysqli_query($conn, $query1);

                    if (mysqli_num_rows($result1) > 0) {
                        while ($row1 = mysqli_fetch_assoc($result1)) {
                            $farmer_id = $row1['farmer_id'];
                            $crop_id = $row1['crop_id'];
                            $quantity = $row1['quantity'];

                            $query2 = "SELECT farmer_name FROM farmer_information WHERE farmer_id = '$farmer_id'";
                            $result2 = mysqli_query($conn, $query2);
                            $farmer_name = "";
                            if ($result2 && mysqli_num_rows($result2) > 0) {
                                $row2 = mysqli_fetch_assoc($result2);
                                $farmer_name = $row2['farmer_name'];
                            }

                            $query3 = "SELECT c_name FROM crop_information_per_farmer WHERE crop_id = '$crop_id'";
                            $result3 = mysqli_query($conn, $query3);
                            $crop_name = "";
                            if ($result3 && mysqli_num_rows($result3) > 0) {
                                $row3 = mysqli_fetch_assoc($result3);
                                $crop_name = $row3['c_name'];
                            }

                            ?>
                                    <div style="height: <?php echo $quantity / 10; ?>%;" class="bar-wrapper">
                                        <div class="bar" style="height: 100%;"><?php echo $quantity.'Kg'; ?></div>
                                        <span class="xValue"><?php echo $farmer_name . '<br>' . $crop_name; ?></span>
                                    </div>
                                    <?php
                        }
                    } else {
                        echo "No data found.";
                    }

                    mysqli_close($conn);
                    ?>
                    </div>
                </div>


                <section id="data-analysis">
                    <h2>User Distribution</h2>
                    <?php
                    $conn = mysqli_connect("localhost", "root", "", "farmsmart");

                    if (!$conn) {
                        die("Connection failed: " . mysqli_connect_error());
                    }

                    $farmer_query = "SELECT COUNT(*) AS farmer_count FROM farmer_information";
                    $farmer_result = mysqli_query($conn, $farmer_query);
                    $farmer_row = mysqli_fetch_assoc($farmer_result);
                    $farmer_count = $farmer_row['farmer_count'];

                    $buyer_query = "SELECT COUNT(*) AS buyer_count FROM buyer_information";
                    $buyer_result = mysqli_query($conn, $buyer_query);
                    $buyer_row = mysqli_fetch_assoc($buyer_result);
                    $buyer_count = $buyer_row['buyer_count'];

                    $analysist_query = "SELECT COUNT(*) AS analysist_count FROM analysist_information";
                    $analysist_result = mysqli_query($conn, $analysist_query);
                    $analysist_row = mysqli_fetch_assoc($analysist_result);
                    $analysist_count = $analysist_row['analysist_count'];

                    $supplier_query = "SELECT COUNT(*) AS supplier_count FROM supplier_information";
                    $supplier_result = mysqli_query($conn, $supplier_query);
                    $supplier_row = mysqli_fetch_assoc($supplier_result);
                    $supplier_count = $supplier_row['supplier_count'];

                    $total_users = $farmer_count + $buyer_count + $analysist_count + $supplier_count;

                    $farmer_percent = ($farmer_count / $total_users) * 100;
                    $buyer_percent = ($buyer_count / $total_users) * 100;
                    $analysist_percent = ($analysist_count / $total_users) * 100;
                    $supplier_percent = ($supplier_count / $total_users) * 100;

                    echo "
                    <div class='chart-section'>
                        <h3>User Distribution in System</h3>
                        <!-- Pie Chart -->
                        <div class='pie-chart' style='
                            display: flex;
                            justify-content: center;
                            align-items: center;
                            margin: 20px auto;
                            width: 250px;
                            height: 250px;
                            position: relative;
                            background: conic-gradient(
                                #007bff 0% $farmer_percent%,        
                                #28a745 $farmer_percent% " . ($farmer_percent + $buyer_percent) . "%,  
                                #ffc107 " . ($farmer_percent + $buyer_percent) . "% " . ($farmer_percent + $buyer_percent + $analysist_percent) . "%, 
                                #dc3545 " . ($farmer_percent + $buyer_percent + $analysist_percent) . "% 100% 
                            );
                            border-radius: 50%;
                            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
                        '>
                        </div>

                        <!-- Legend -->
                        <div class='chart-legend-inline' style='
                            display: flex;
                            justify-content: center;
                            align-items: center;
                            flex-wrap: wrap;
                            gap: 15px;
                            margin-top: 15px;
                        '>
                            <div class='legend-item' style='
                                display: flex;
                                align-items: center;
                                font-size: 1rem;
                                gap: 10px;
                            '>
                                <span class='legend-color' style='
                                    width: 20px;
                                    height: 20px;
                                    border-radius: 50%;
                                    display: inline-block;
                                    border: 1px solid #ddd;
                                    background-color: #007bff;
                                '></span> Farmers: $farmer_count
                            </div>
                            <div class='legend-item' style='
                                display: flex;
                                align-items: center;
                                font-size: 1rem;
                                gap: 10px;
                            '>
                                <span class='legend-color' style='
                                    width: 20px;
                                    height: 20px;
                                    border-radius: 50%;
                                    display: inline-block;
                                    border: 1px solid #ddd;
                                    background-color: #28a745;
                                '></span> Buyers: $buyer_count
                            </div>
                            <div class='legend-item' style='
                                display: flex;
                                align-items: center;
                                font-size: 1rem;
                                gap: 10px;
                            '>
                                <span class='legend-color' style='
                                    width: 20px;
                                    height: 20px;
                                    border-radius: 50%;
                                    display: inline-block;
                                    border: 1px solid #ddd;
                                    background-color: #ffc107;
                                '></span> Analysts: $analysist_count
                            </div>
                            <div class='legend-item' style='
                                display: flex;
                                align-items: center;
                                font-size: 1rem;
                                gap: 10px;
                            '>
                                <span class='legend-color' style='
                                    width: 20px;
                                    height: 20px;
                                    border-radius: 50%;
                                    display: inline-block;
                                    border: 1px solid #ddd;
                                    background-color: #dc3545;
                                '></span> Suppliers: $supplier_count
                            </div>
                        </div>
                    </div>";
                    
                    // Close the database connection
                    mysqli_close($conn);
                    ?>
                </section>


            </section>

        </main>

    </div>
</body>

</html>