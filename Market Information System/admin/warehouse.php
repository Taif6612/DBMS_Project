<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Historical Data</title>

    <style>
    .form-container {
        background: #fff;
        padding: 40px;
        border-radius: 15px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        width: 100%;
        max-width: 600px;
        opacity: 0;
        animation: fadeIn 1s ease forwards;
        margin: 0 auto;
        margin-bottom: 80px;
    }

    /* Form Heading */
    h2 {
        font-size: 2rem;
        color: #38a169;
        margin-bottom: 20px;
        text-align: center;
        font-weight: bold;
    }

    /* Form Elements */
    .crop-form {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    .form-group {
        display: flex;
        flex-direction: column;
    }

    label {
        font-size: 1rem;
        color: #333;
        margin-bottom: 8px;
    }

    input,
    textarea {
        padding: 12px 15px;
        font-size: 1rem;
        border: 1px solid #ddd;
        border-radius: 8px;
        transition: border-color 0.3s ease, box-shadow 0.3s ease;
    }

    input:focus,
    textarea:focus {
        border-color: #38a169;
        box-shadow: 0 0 8px rgba(56, 161, 105, 0.4);
    }

    textarea {
        resize: vertical;
    }

    /* Submit Button */
    .submit-btn {
        padding: 15px;
        background-color: #38a169;
        color: white;
        font-size: 1.1rem;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        transition: background-color 0.3s ease, transform 0.3s ease;
    }

    .submit-btn:hover {
        background-color: #2d7a57;
        transform: translateY(-5px);
    }

    .submit-btn:active {
        background-color: #234f39;
    }

    /* Table Styles */
    .table-container {
        width: 90%;
        max-width: 1000px;
        margin-top: 40px;
        background: #fff;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        margin: 0 auto;
    }

    h3 {
        font-size: 1.5rem;
        color: #38a169;
        margin-bottom: 20px;
        font-weight: bold;
        text-align: center;
    }

    .crop-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    .crop-table th,
    .crop-table td {
        padding: 12px;
        text-align: left;
        border: 1px solid #ddd;
    }

    .crop-table th {
        background-color: #38a169;
        color: white;
        font-weight: bold;
    }

    .crop-table tr:nth-child(even) {
        background-color: #f9f9f9;
    }

    .crop-table tr:hover {
        background-color: #f1f1f1;
    }

    /* Action Buttons */
    .edit-btn,
    .delete-btn {
        padding: 8px 16px;
        text-decoration: none;
        border-radius: 8px;
        font-weight: bold;
        color: white;
        display: inline-block;
        margin-right: 10px;
        transition: background-color 0.3s ease, transform 0.2s ease;
    }

    .edit-btn {
        background-color: #007bff;
    }

    .delete-btn {
        background-color: #dc3545;
    }

    .edit-btn:hover {
        background-color: #0056b3;
        transform: translateY(-3px);
    }

    .delete-btn:hover {
        background-color: #c82333;
        transform: translateY(-3px);
    }

    .edit-btn:active,
    .delete-btn:active {
        transform: translateY(0);
    }

    .view-btn {
        background-color: #007bff;
        color: white;
        padding: 8px 16px;
        text-decoration: none;
        border-radius: 8px;
        font-weight: bold;
        transition: 0.3s;
    }

    .view-btn:hover {
        background-color: #0056b3;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
        }

        to {
            opacity: 1;
        }
    }
    </style>
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
            <h2>Update Crop Information</h2>
            <div class="form-container">

                <form action="warehouseCreateProcess.php" method="POST" class="crop-form">
                    <div class="form-group">
                        <label>Zone Number</label>
                        <input type="text" name="zoneNumber" placeholder="Enter Zone Number required" required />
                    </div>
                    <div class="form-group">
                        <label>Warehouse Number</label>
                        <input type="text" name="wNumber" value="<?php echo uniqid('w_');?>" readonly />
                    </div>
                    <div class="form-group">
                        <label>Capacity</label>
                        <input type="text" name="capacity" required />
                    </div>
                    <button type="submit" class="submit-btn">Create WareHouse</button>
                </form>
            </div>

            <section id="data-analysis">
                <h2>Visual Representation</h2>
                <?php
                $conn = mysqli_connect("localhost", "root", "", "farmsmart");

                if (!$conn) {
                    die("Connection failed: " . mysqli_connect_error());
                }

                $warehouse_query = "SELECT warehouse_num, storage_capacity FROM warehouse";
                $warehouse_result = mysqli_query($conn, $warehouse_query);

                while ($warehouse = mysqli_fetch_assoc($warehouse_result)) {
                    $warehouse_num = $warehouse['warehouse_num'];
                    $storage_capacity = $warehouse['storage_capacity'];

                    $in_stock_query = "SELECT SUM(quantity) AS in_stock FROM crop_farmer_zone_warehouse_info WHERE warehouse_num = '$warehouse_num'";
                    $in_stock_result = mysqli_query($conn, $in_stock_query);
                    $in_stock_row = mysqli_fetch_assoc($in_stock_result);
                    $in_stock = $in_stock_row['in_stock'] ?? 0; 

                    $available_space = $storage_capacity - $in_stock;

                    $in_stock_percent = ($in_stock / $storage_capacity) * 100;
                    $available_space_percent = ($available_space / $storage_capacity) * 100;

                    echo "
                    <div class='chart-section'>
                        <h3>Warehouse: $warehouse_num</h3>
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
                                #007bff 0% $in_stock_percent%,        
                                #28a745 $in_stock_percent% 100%       
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
                                '></span> In Stock: $in_stock Kg
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
                                '></span> Available Space: $available_space Kg
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
                                '></span> Capacity: $storage_capacity Kg
                            </div>
                            <a href='view_warehouse_items.php?warehouse_num=$warehouse_num' class='view-btn'>View Items</a>
                        </div>
                    </div>";
                }

                // Close the database connection
                $conn->close();
                ?>


    </div>

    </section>

    </main>

    </div>
</body>

</html>