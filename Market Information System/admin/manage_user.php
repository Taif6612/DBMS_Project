<?php
$conn = mysqli_connect("localhost", "root", "", "farmsmart");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$search_query = '';
if (isset($_GET['search']) && !empty($_GET['search'])) {
    $search_query = mysqli_real_escape_string($conn, $_GET['search']);
}

$query = "
    SELECT buyer_id AS user_id, buyer_name AS name, district, village, 'Buyer' AS role FROM buyer_information
    UNION
    SELECT farmer_id AS user_id, farmer_name AS name, district, village, 'Farmer' AS role FROM farmer_information
    UNION
    SELECT analysist_id AS user_id, analysist_name AS name, district, village, 'Analysist' AS role FROM analysist_information
    UNION
    SELECT supplier_id AS user_id, supplier_name AS name, district, village, 'Supplier' AS role FROM supplier_information
";

if (!empty($search_query)) {
    $query = "
        SELECT buyer_id AS user_id, buyer_name AS name, district, village, 'Buyer' AS role 
        FROM buyer_information WHERE buyer_name LIKE '%$search_query%'
        UNION
        SELECT farmer_id AS user_id, farmer_name AS name, district, village, 'Farmer' AS role 
        FROM farmer_information WHERE farmer_name LIKE '%$search_query%'
        UNION
        SELECT analysist_id AS user_id, analysist_name AS name, district, village, 'Analysist' AS role 
        FROM analysist_information WHERE analysist_name LIKE '%$search_query%'
        UNION
        SELECT supplier_id AS user_id, supplier_name AS name, district, village, 'Supplier' AS role 
        FROM supplier_information WHERE supplier_name LIKE '%$search_query%'
    ";
}


$result = mysqli_query($conn, $query);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users</title>
    <link rel="stylesheet" href="css/manageuserStyle.css">
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
                <li><a href="manage_user.php" class="active">Manage Users</a></li>
                <li><a href="manage-crops.php">Manage Recommendations</a></li>
                <li><a href="warehouse.php">Warehouse Management</a></li>
            </ul>
        </nav>

        <main class="content">
            <section id="manage-users">
                <h2>Manage Users</h2>

                <!-- Filter and Search Row -->
                <div class="filter-search">

                    <!-- Search Section -->
                    <form action="" method="GET" class="search-form">
                        <input type="text" id="search" name="search" class="search-input" placeholder="Search by name" value="<?php echo htmlspecialchars($search_query); ?>">
                        <button type="submit" class="btn search-btn">Search</button>
                    </form>
                </div>

                <!-- User Table -->
                <div class="table-container">
                    <table class="user-table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>District</th>
                                <th>Village</th>
                                <th>Role</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Displaying users from the query result
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo "<tr>";
                                echo "<td>" . $row['name'] . "</td>";
                                echo "<td>" . $row['district'] . "</td>";
                                echo "<td>" . $row['village'] . "</td>";
                                echo "<td>" . $row['role'] . "</td>";
                                echo "<td><a href='editUser.php?user_id=" . $row['user_id'] . "' class='btn'>Edit</a> 
                                    </td>";
                                echo "</tr>";
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
