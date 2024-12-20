<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users</title>
    <link rel="stylesheet" href="css/manageuserStyle.css">
    <link rel="stylesheet" href="css/style.css">
    <style>
        /* Form Styling */
        .form-container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background: #f9f9f9;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        .form-container h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #555;
        }

        .form-group input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        .update-btn {
            display: block;
            width: 100%;
            padding: 10px;
            background-color: #4caf50;
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
        }

        .update-btn:hover {
            background-color: #45a049;
        }

        .back-btn {
            display: block;
            margin-top: 15px;
            text-align: center;
            color: #4caf50;
            text-decoration: none;
            font-weight: bold;
        }

        .back-btn:hover {
            text-decoration: underline;
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
                <li><a href="admin.php">Dashboard</a></li>
                <li><a href="manage_user.php">Manage Users</a></li>
                <li><a href="manage-crops.php">Manage Recommendations</a></li>
                <li><a href="warehouse.php" class="active">Warehouse Management</a></li>
            </ul>
        </nav>

        <main class="content">
        <div class="form-container">
        <h2>Update Warehouse Information</h2>
        <?php
        $conn = mysqli_connect("localhost", "root", "", "farmsmart");

        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        $warehouse_num = isset($_GET['id']) ? mysqli_real_escape_string($conn, $_GET['id']) : '';
        $zone_num = '';
        $storage_capacity = '';

        if (!empty($warehouse_num)) {
            $query = "SELECT * FROM warehouse WHERE warehouse_num = '$warehouse_num'";
            $result = mysqli_query($conn, $query);

            if ($result && mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);
                $zone_num = $row['zone_num'];
                $storage_capacity = $row['storage_capacity'];
            } else {
                echo "<p style='color: red; text-align: center;'>Invalid warehouse number.</p>";
            }
        }
        ?>
        <form action="updatewarehouseInfoProcessing.php" method="post">
            <div class="form-group">
                <label for="warehouse_num">Warehouse Number</label>
                <input type="text" name="warehouse_num" id="warehouse_num" value="<?php echo $warehouse_num; ?>" readonly>
            </div>
            <div class="form-group">
                <label for="zone_num">Zone Number</label>
                <input type="text" name="zone_num" id="zone_num" value="<?php echo $zone_num; ?>" readonly>
            </div>
            <div class="form-group">
                <label for="storage_capacity">Storage Capacity</label>
                <input type="text" name="storage_capacity" id="storage_capacity" value="<?php echo $storage_capacity; ?>">
            </div>
            <button type="submit" class="update-btn">Update Data</button>
        </form>
        <a href="http://localhost/Market%20Information%20System/admin/view_warehouse_items.php?warehouse_num=<?php echo $warehouse_num;?>" class="back-btn">Back to Warehouse</a>
    </div>
        </main>
    </div>
</body>
</html>
