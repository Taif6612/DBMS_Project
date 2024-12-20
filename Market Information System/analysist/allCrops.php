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
    <title>Crop List</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/farmerdataStyle.css">
    <style>
    .table-container {
        width: 90%;
        margin: 2rem auto;
        background-color: #fff;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        overflow: hidden;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        table-layout: fixed;
    }

    table th,
    table td {
        padding: 1rem;
        text-align: center;
        border-bottom: 1px solid #ddd;
    }

    table th {
        background: linear-gradient(135deg, #38a169, #2d7a57);
        color: #fff;
        font-size: 1.1rem;
    }

    table tr:nth-child(even) {
        background-color: #f9f9f9;
    }

    table tr:hover {
        background-color: #eafaf7;
        transition: background 0.3s ease;
    }

    .action-btn {
        display: inline-block;
        padding: 0.5rem 1rem;
        font-size: 0.9rem;
        color: #fff;
        background-color: #38a169;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        text-decoration: none;
        transition: background 0.3s ease;
    }

    .action-btn:hover {
        background-color: #2d7a57;
    }

    .action-btn:active {
        background-color: #2e7d73;
    }
    .search-form {
        text-align: center;
        margin-bottom: 1rem;
    }

    .search-form input {
        padding: 0.8rem;
        width: 300px;
        border-radius: 5px;
        border: 1px solid #ccc;
        margin-top: 15px;
    }

    .search-form button {
        padding: 0.8rem 1rem;
        background-color: #38a169;
        color: #fff;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }

    .search-form button:hover {
        background-color: #2d7a57;
    }
    </style>
</head>

<body>
    <header class="navbar">
        <div class="navbar-container">
            <div class="logo">FarmSmart</div>
            <nav class="menu">
                <a href="index.php"> Home</a>
                <a href="addPrice.php">Post crops</a>
                <a style="color:#ebde2b" href="cropEditForm.php">All crops</a>
            </nav>
            <div class="actions">
                <a href="profile.php" class="profile-icon"><?php echo $a_id;?></i></a>
                <a href="../FarmerUser/logoutProcess.php" class="logout-btn">Logout</a>
            </div>
        </div>
    </header>
    <?php
    $conn = mysqli_connect("localhost", "root", "", "farmsmart");
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $search = "";
    if (isset($_POST['search'])) {
        $search = mysqli_real_escape_string($conn, $_POST['search']);
    }

    $sql = "SELECT analysis_id, crop_id, c_name, date, price_value 
            FROM analysis_data_for_crops 
            WHERE analysis_id = '$a_id'";

    if (!empty($search)) {
        $sql .= " AND (c_name LIKE '%$search%' 
                    OR date LIKE '%$search%' 
                    OR price_value LIKE '%$search%')";
    }

    $result = mysqli_query($conn, $sql);
    ?>

    <!-- Search Form -->
    <div class="search-form">
        <form method="POST" action="">
            <input type="text" name="search" placeholder="Search by crop name, date, or price..."
                value="<?php echo $search; ?>">
            <button type="submit">Search</button>
        </form>
    </div>
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>Analysis ID</th>
                    <th>Crop ID</th>
                    <th>Crop Name</th>
                    <th>Date</th>
                    <th>Price Value</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>
                            <td>{$row['analysis_id']}</td>
                            <td>{$row['crop_id']}</td>
                            <td>{$row['c_name']}</td>
                            <td>{$row['date']}</td>
                            <td>{$row['price_value']} BDT</td>
                            <td>
                                <a href='cropEditForm.php?analysis_id={$row['analysis_id']}&crop_id={$row['crop_id']}' 
                                class='action-btn'>Edit</a>
                            </td>
                        </tr>";
                    }
                } else {
                    echo "<tr><td colspan='6'>No data found for the active user</td></tr>";
                }
                mysqli_close($conn);
                ?>
            </tbody>
        </table>
    </div>


    <footer>
        <p>&copy; 2024 FarmSmart. All Rights Reserved.</p>
    </footer>
</body>

</html>