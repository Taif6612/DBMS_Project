<?php
$conn = mysqli_connect("localhost", "root", "", "farmsmart");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$search = "";
if (isset($_GET['search']) && !empty($_GET['search'])) {
    $search = mysqli_real_escape_string($conn, $_GET['search']);
}

$sql = "SELECT * FROM recommendation";
if (!empty($search)) {
    $sql .= " WHERE month_name LIKE '%$search%'";
}

$result = mysqli_query($conn, $sql);

if (!$result) {
    die("Query Failed: " . mysqli_error($conn));
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Recommendations</title>
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
                <li><a href="manage-crops.php" class="active">Manage Recommendations</a></li>
                <li><a href="warehouse.php">Warehouse Management</a></li>
            </ul>
        </nav>

        <main class="content">
            <section id="manage-recommendations">
                <h2>Manage Recommendations</h2>

                <!-- Filter and Search Row -->
                <div class="filter-search">
                    <!-- Search Section -->
                    <form action="" method="GET" class="search-form">
                        <input type="text" id="search" name="search" class="search-input" placeholder="Search by month name">
                        <button type="submit" class="btn search-btn">Search</button>
                    </form>
                </div>

                <div class="table-container">
                    <table class="user-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Month</th>
                                <th>Crops</th>
                                <th>Weather Condition</th>
                                <th>Protection</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (mysqli_num_rows($result) > 0) {
                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo '<tr>';
                                    echo '<td>' . $row['id'] . '</td>';
                                    echo '<td>' . $row['month_name'] . '</td>';
                                    echo '<td>' . $row['crops'] . '</td>';
                                    echo '<td>' . $row['weather_condition'] . '</td>';
                                    echo '<td>' . $row['protection'] . '</td>';
                                    echo '<td><a href="editRecommendation.php?id=' . $row['id'] . '" class="btn">Edit</a></td>';
                                    echo '</tr>';
                                }
                            } else {
                                echo '<tr><td colspan="6">No recommendation data available.</td></tr>';
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </section>
        </main>
    </div>
</body>
</html>
