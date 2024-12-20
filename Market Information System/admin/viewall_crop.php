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
                <li><a href="warehouse.php">Warehouse Management</a></li>
            </ul>
        </nav>

        <main class="content">
            <section id="manage-users">
                <h2>Manage Crops</h2>

                <!-- Filter and Search Row -->
                <div class="filter-search">
                    <!-- Filter Section -->
                    

                    <!-- Search Section -->
                    <form action="" method="GET" class="search-form">
                        <input type="text" id="search" name="search" class="search-input" placeholder="Search by crop name">
                        <button type="submit" class="btn search-btn">Search</button>
                    </form>
                </div>

                <!-- User Table -->
                <div class="table-container">
                <?php
                    $conn = mysqli_connect("localhost", "root", "", "farmsmart");

                    if (!$conn) {
                        die("Connection failed: " . mysqli_connect_error());
                    }

                    // Get the search query from the input
                    $search = "";
                    if (isset($_GET['search']) && !empty($_GET['search'])) {
                        $search = mysqli_real_escape_string($conn, $_GET['search']);
                    }

                    // Modify the SQL query to filter by crop name if a search term is provided
                    $sql = "SELECT * FROM crop_information_per_farmer";
                    if (!empty($search)) {
                        $sql .= " WHERE c_name LIKE '%$search%'";
                    }

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
                                <th>Growing Season</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (mysqli_num_rows($result) > 0) {
                                while ($row = mysqli_fetch_assoc($result)) {
                                    $farmer_id = $row['farmer_id'];
                                    $farmer_query = "SELECT farmer_name FROM farmer_information WHERE farmer_id = '$farmer_id'";
                                    $farmer_result = mysqli_query($conn, $farmer_query);

                                    $farmer_name = "Unknown";
                                    if ($farmer_result && mysqli_num_rows($farmer_result) > 0) {
                                        $farmer_row = mysqli_fetch_assoc($farmer_result);
                                        $farmer_name = $farmer_row['farmer_name'];
                                    }

                                    echo '<tr class="buyer">';
                                    echo '<td>' . $farmer_name . '</td>';
                                    echo '<td>' . $row['c_name'] . '</td>';
                                    echo '<td>' . $row['growing_season'] . '</td>';
                                    echo '<td>
                                            <a href="editCrops.php?farmer_id=' . $row['farmer_id'] . '&crop_id=' . $row['crop_id'] . '" class="btn">Edit</a>
                                            <a href="deleteCrops.php?farmer_id=' . $row['farmer_id'] . '&crop_id=' . $row['crop_id'] . '" class="btn btn-delete">Delete</a>
                                        </td>';
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
                $count_qiery = "SELECT COUNT(*) AS t_crop FROM crop_information_per_farmer";
                $c_result = mysqli_query($conn,$count_qiery); 
                $t_crop = 0;
                if ($c_result && mysqli_num_rows($c_result) > 0) {
                    $c_row = mysqli_fetch_assoc($c_result);
                    $t_crop = $c_row['t_crop'];
                }
            ?>
            <div class="count-container">
                    <span class="count-result">Total Crops: <strong><?php echo $t_crop;?></strong></span>
                </form>
            </div>
            </section>
        </main>
    </div>
</body>
</html>