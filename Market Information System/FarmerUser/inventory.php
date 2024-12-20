<?php
    session_start();

    if (!isset($_SESSION['active_user_id'])) {
        die("You must be logged in to view this page.");
    }
    $f_id = $_SESSION['active_user_id'];

    $conn = mysqli_connect("localhost", "root", "", "farmsmart");
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $search_keyword = '';
    if (isset($_GET['search'])) {
        $search_keyword = mysqli_real_escape_string($conn, $_GET['search']);
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crop Inventory - Farmer UI</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
    body {
        margin: 0;
        /* Remove default margin */
    }

    .background-image {
        position: fixed;
        /* Fix the background image */
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-image: url('image/minimalistic\ image\ of\ a\ farm\ warehouse.png');
        /* Placeholder for your image */
        background-size: cover;
        /* Cover the entire area */
        background-position: center;
        /* Center the image */
        z-index: 1;
        /* Behind all content */
        overflow: hidden;
        /* Prevents any overflow */
    }

    .blur {
        position: fixed;
        /* Fix the blur layer */
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        backdrop-filter: blur(8px);
        /* Apply blur effect */
        z-index: 2;
        /* On top of the background */
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

    .content {
        position: relative;
        /* To keep content above blur layer */
        z-index: 4;
        /* Highest z-index for content */
        padding: 20px;
        /* Add padding for spacing */
    }

    .btn-primary {
        background-color: #007B5F;
        /* Darker green for buttons */
        border: none;
    }

    .btn-primary:hover {
        background-color: #005f36;
        /* Dark green on hover */
    }

    table {
        background-color: rgba(255, 255, 255, 0.8);
        /* White background for table with some transparency */
        border-collapse: collapse;
        /* Collapse borders */
        width: 100%;
        /* Full width */
        border: 2px solid #005f36;
        /* Dark green border for the table */
    }

    th,
    td {
        border: 1px solid #005f36;
        /* Dark green border for table cells */
        padding: 10px;
        /* Padding for cells */
        text-align: center;
        /* Center align text */
    }

    th {
        background-color: #e0f2e0;
        /* Light green background for header */
    }

    .avatar {
        width: 40px;
        /* Avatar width */
        height: 40px;
        /* Avatar height */
        border-radius: 50%;
        /* Circular avatar */
    }

    /* General Button Styling */
    a.edtBtn,
    a.dltBtn {
        display: inline-block;
        padding: 8px 16px;
        text-decoration: none;
        font-weight: bold;
        font-size: 14px;
        border-radius: 5px;
        text-align: center;
        transition: all 0.3s ease-in-out;
    }

    /* Edit Button Styling */
    a.edtBtn {
        background-color: #4CAF50;
        /* Green */
        color: white;
        border: 1px solid #4CAF50;
    }

    a.edtBtn:hover {
        background-color: #45a049;
        border-color: #3d8e41;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
    }

    /* Delete Button Styling */
    a.dltBtn {
        background-color: #f44336;
        /* Red */
        color: white;
        border: 1px solid #f44336;
    }

    a.dltBtn:hover {
        background-color: #d32f2f;
        border-color: #b71c1c;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
    }

    /* Spacing between buttons */
    td a {
        margin-right: 8px;
    }

    /* Responsive table styling (optional) */
    .table {
        width: 100%;
        border-collapse: collapse;
    }

    .table th,
    .table td {
        padding: 12px;
        text-align: center;
        border: 1px solid #ddd;
    }

    .table th {
        background-color: #f4f4f4;
        color: #333;
        font-weight: bold;
    }

    .table tr:nth-child(even) {
        background-color: #f9f9f9;
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
                <li class="nav-item"><a class="nav-link" href="postCrop.php">Post Crops</a></li>
                <li class="nav-item"><a class="nav-link" href="sell.php">Deliver In Warehouse</a></li>
                <li class="nav-item"><a class="nav-link" href="inventory.php">Crop Inventory</a></li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <img src="path/to/avatar-placeholder.png" alt="<?php echo $f_id ?>"
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

    <!-- Inventory Page Content -->
    <div class="container mt-5 content">
        <h2 class="text-center">Crop Inventory</h2>
        <p class="text-center">Here is a list of your current crops:</p>

        <!-- Search Form -->
        <form method="GET" action="" class="form-inline mb-3 justify-content-center">
            <input type="text" name="search" class="form-control mr-2" placeholder="Search by Crop Name"
                value="<?php echo $search_keyword; ?>">
            <button type="submit" class="btn btn-primary">Search</button>
        </form>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Crop Name</th>
                    <th>Quantity</th>
                    <th>Market Price per Unit</th>
                    <th>My Discounted Percentage</th>
                    <th>Warehouse-Zone</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $query = "
                    SELECT crop_id, quantity, cost, price_disc, warehouse_num, zone_num,
                           (SELECT c_name FROM crop_information_per_farmer WHERE crop_id = c.crop_id) AS c_name
                    FROM crop_farmer_zone_warehouse_info c
                    WHERE farmer_id = '$f_id'";
                    
                    if (!empty($search_keyword)) {
                        $query .= " AND (SELECT c_name FROM crop_information_per_farmer WHERE crop_id = c.crop_id) LIKE '%$search_keyword%'";
                    }

                    $result = mysqli_query($conn, $query);

                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                ?>
                <tr>
                    <td><?php echo $row['c_name']; ?></td>
                    <td><?php echo $row['quantity']; ?></td>
                    <td><?php echo $row['cost'] . ' taka'; ?></td>
                    <td><?php echo $row['price_disc']; ?>%</td>
                    <td><?php echo $row['warehouse_num'] . '-' . $row['zone_num']; ?></td>
                    <td>
                        <a class="edtBtn" href="editInventory.php?f_id=<?php echo $f_id; ?>
                                               &crop_id=<?php echo $row['crop_id']; ?>
                                               &warehouse_num=<?php echo $row['warehouse_num']; ?>
                                               &zone_num=<?php echo $row['zone_num']; ?>">Edit</a>
                    </td>
                </tr>
                <?php
                        }
                    } else {
                ?>
                <tr>
                    <td colspan="6" class="text-center">No crop inventory available.</td>
                </tr>
                <?php
                    }
                ?>
            </tbody>
        </table>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>