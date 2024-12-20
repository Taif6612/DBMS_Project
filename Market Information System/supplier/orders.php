<?php
session_start();

if (!isset($_SESSION['active_user_id'])) {
    die("You must be logged in to view this page.");
}
$s_id = $_SESSION['active_user_id'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FarmSmart - My Purchases</title>
    <!-- Font Awesome Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/orders.css">
</head>
<body>
    <!-- Navbar -->
    <div class="navbar">
        <div class="logo">FarmSmart</div>
        <div class="menu">
            <a href="index.php">Dashboard</a>
            <a href="browsecrops.php">Browse Crops</a>
            <a class="active" href="orders.php">My Purchases</a>
        </div>
        <div class="user-actions">
            <a href="profile.php"><i class="fa-solid fa-user profile-icon"></i></a>
            <a href="../FarmerUser/logoutProcess.php" class="logout">Logout</a>
        </div>
    </div>

    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-content">
            <h1>My Purchases</h1>
            <p>Review your orders and manage them easily.</p>
        </div>
    </section>

    <!-- Search Form -->
    <section class="search-section">
        <form method="GET" action="orders.php">
            <input type="text" name="search" placeholder="Search by Crop Name or Order Date" value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>">
            <button type="submit" class="btn search-btn">Search</button>
        </form>
    </section>

    <!-- Orders Table Section -->
    <section class="orders-section">
        <table class="orders-table">
            <thead>
                <tr>
                    <th>Supply ID</th>
                    <th>Crop Name</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Order Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $conn = mysqli_connect("localhost", "root", "", "farmsmart");
                if (!$conn) {
                    die("Connection failed: " . mysqli_connect_error());
                }

                // Get search input from the user
                $searchTerm = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';

                // Build the query with search functionality
                $supplyQuery = "SELECT supply_id, supply_date FROM supply_info WHERE supplier_id = '$s_id'";

                // If there's a search term, add conditions to search by crop name or order date
                if ($searchTerm != '') {
                    $supplyQuery .= " AND (supply_date LIKE '%$searchTerm%' OR supply_id IN (SELECT supply_id FROM supply_crop_details WHERE crop_id IN (SELECT crop_id FROM crop_information_per_farmer WHERE c_name LIKE '%$searchTerm%')))";
                }

                // Execute the query
                $supplyResult = mysqli_query($conn, $supplyQuery);

                if (mysqli_num_rows($supplyResult) > 0) {
                    while ($supplyRow = mysqli_fetch_assoc($supplyResult)) {
                        $supply_id = $supplyRow['supply_id'];
                        $supply_date = $supplyRow['supply_date'];

                        $detailsQuery = "SELECT crop_id, quantity, unit_price FROM supply_crop_details WHERE supply_id = '$supply_id'";
                        $detailsResult = mysqli_query($conn, $detailsQuery);

                        while ($detailsRow = mysqli_fetch_assoc($detailsResult)) {
                            $crop_id = $detailsRow['crop_id'];
                            $quantity = $detailsRow['quantity'];
                            $unit_price = $detailsRow['unit_price'];

                            $cropQuery = "SELECT c_name FROM crop_information_per_farmer WHERE crop_id = '$crop_id'";
                            $cropResult = mysqli_query($conn, $cropQuery);
                            $cropName = "Unknown";
                            if ($cropRow = mysqli_fetch_assoc($cropResult)) {
                                $cropName = $cropRow['c_name'];
                            }

                            $orderQuery = "SELECT order_id FROM order_crop_relationship WHERE crop_id = '$crop_id'";
                            $orderResult = mysqli_query($conn, $orderQuery);
                            $order_id = "N/A";
                            if ($orderRow = mysqli_fetch_assoc($orderResult)) {
                                $order_id = $orderRow['order_id'];
                            }

                            echo "<tr>";
                            echo "<td>" . $supply_id . "</td>";
                            echo "<td>" . $cropName . "</td>";
                            echo "<td>" . $quantity . " kg</td>";
                            echo "<td>$" . $unit_price . "</td>";
                            echo "<td>" . $supply_date . "</td>";
                            echo "<td><a href='edit-order.php?supply_id=" . $supply_id . "&order_id=" . $order_id . "' class='btn edit-btn'>Edit</a></td>";
                            echo "</tr>";
                        }
                    }
                } else {
                    echo "<tr><td colspan='6'>No orders found.</td></tr>";
                }

                // Close the connection
                mysqli_close($conn);
                ?>
            </tbody>
        </table>
    </section>

</body>
</html>
