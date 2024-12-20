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
    <title>Edit-Data</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/farmerdataStyle.css">
    <style>
    .form-container {
        background-color: #fff;
        padding: 2rem;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        width: 400px;
        margin: 30px auto;
    }

    .form-container h2 {
        text-align: center;
        color: #444;
        margin-bottom: 1rem;
        font-size: 1.8rem;
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-group label {
        display: block;
        font-weight: bold;
        margin-bottom: 0.5rem;
        color: #555;
    }

    .form-group input {
        width: 95%;
        padding: 0.7rem;
        border: 1px solid #ccc;
        border-radius: 5px;
        font-size: 1rem;
        transition: border-color 0.3s ease;
    }

    .form-group input:focus {
        outline: none;
        border-color: #38a169;
        box-shadow: 0 0 5px rgba(116, 235, 213, 0.5);
    }

    .btn {
        display: inline-block;
        width: 100%;
        background: linear-gradient(135deg, #38a169, #2d7a57);
        color: #fff;
        text-align: center;
        padding: 0.7rem;
        font-size: 1.1rem;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        transition: background 0.3s ease;
    }

    .btn:hover {
        background: #38a169;
    }

    .btn:active {
        background: #42a39b;
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
                <a style="color:#ebde2b" href="allCrops.php">All crops</a>
            </nav>
            <div class="actions">
                <a href="profile.php" class="profile-icon"><?php echo $a_id;?></i></a>
                <a href="../FarmerUser/logoutProcess.php" class="logout-btn">Logout</a>
            </div>
        </div>
    </header>
    <?php
        if (!isset($_GET['analysis_id']) || !isset($_GET['crop_id'])) {
            die("Missing required parameters.");
        }

        $analysis_id = $_GET['analysis_id'];
        $crop_id = $_GET['crop_id'];
        $conn = mysqli_connect("localhost", "root", "", "farmsmart");

        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        $sql = "SELECT * FROM analysis_data_for_crops 
                WHERE analysis_id = '$analysis_id' AND crop_id = '$crop_id' 
                AND analysis_id = '$a_id'"; 

        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) == 1) {
            $row = mysqli_fetch_assoc($result); 
        } else {
            die("No matching record found or access denied.");
        }

        mysqli_close($conn);
    ?>
    <div class="form-container">
        <h2>Update Table Data</h2>
        <form action="update_table.php" method="POST">
            <div class="form-group">
                <label for="analysis_id">Analysis ID</label>
                <input type="text" id="analysis_id" name="analysis_id" value="<?php echo $row['analysis_id']; ?>" readonly required>
            </div>
            <div class="form-group">
                <label for="crop_id">Crop ID</label>
                <input type="text" id="crop_id" name="crop_id" value="<?php echo $row['crop_id']; ?>" readonly required>
            </div>
            <div class="form-group">
                <label for="c_name">Crop Name</label>
                <input type="text" id="c_name" name="c_name" value="<?php echo $row['c_name']; ?>" required>
            </div>
            <div class="form-group">
                <label for="date">Date</label>
                <input type="date" id="date" name="date" value="<?php echo $row['date']; ?>" required>
            </div>
            <div class="form-group">
                <label for="price_value">Price Value</label>
                <input type="number" step="0.01" id="price_value" name="price_value" value="<?php echo $row['price_value']; ?>" required>
            </div>
            <button type="submit" class="btn">Update Data</button>
        </form>
    </div>


    <footer>
        <p>&copy; 2024 FarmSmart. All Rights Reserved.</p>
    </footer>
</body>

</html>