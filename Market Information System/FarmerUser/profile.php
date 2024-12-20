<?php
    session_start();

    if (!isset($_SESSION['active_user_id'])) {
        die("You must be logged in to view this page.");
    }
    $f_id = $_SESSION['active_user_id'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sell Crop - Farmer UI</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
    body {
        margin: 0;
        /* Remove default margin */
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

    .edit-profile-card {
    background-color: #fff;
    width: 100%;
    max-width: 400px;
    padding: 30px;
    border-radius: 10px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    text-align: center;
    margin: 50px auto;
}

.edit-profile-card h2 {
    font-size: 1.8rem;
    color: #00796b;
    margin-bottom: 20px;
}

.form-group {
    margin-bottom: 20px;
    text-align: left;
}

.form-group label {
    font-size: 1rem;
    color: #555;
    margin-bottom: 8px;
    display: block;
}

.form-group input {
    width: 100%;
    padding: 8px;
    font-size: 1rem;
    border: 1px solid #ccc;
    border-radius: 5px;
}

.save-btn {
    padding: 10px 20px;
    background-color: #1fa78c;
    color: white;
    font-weight: bold;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

.save-btn:hover {
    background-color: #148f77;
}
    </style>
</head>

<body>
    <div class="background-image"></div>
    <div class="blur"></div>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark">
    <a class="navbar-brand" href="LandingFarmer.php">FarmSmart</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link" href="postCrop.php">Post Crops</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="sell.php">Deliver In warehouse</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="inventory.php">Crop Inventory</a>
            </li>
            <!-- Avatar and Logout Button -->
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <img src="path/to/avatar-placeholder.png" alt="<?php echo $f_id?>" style="width: 30px; height: 30px;">
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
    <?php
        $conn = mysqli_connect("localhost", "root", "", "farmsmart");
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

         
        $sql = "SELECT * FROM farmer_information WHERE farmer_id = '$f_id'";
        $result = mysqli_query($conn, $sql);

        if ($result->num_rows > 0) {
            $row = mysqli_fetch_assoc($result);
            $supplier_name = $row['farmer_name'];
            $s_password = $row['f_password'];
            $district = $row['district'];
            $village = $row['village'];
        } else {
            $supplier_name = $s_password = $district = $village = "Not Found";
        }

        mysqli_close($conn);
    ?>
    <section class="edit-profile-container">
        <div class="edit-profile-card">
            <h2>Edit Profile</h2>
            <form action="edit-profile.php" method="POST">
                <div class="form-group">
                    <label for="supplier_name">Name:</label>
                    <input type="text" id="supplier_name" name="supplier_name" value="<?php echo $supplier_name; ?>" required>
                </div>
                <div class="form-group">
                    <label for="s_password">Password:</label>
                    <input type="password" id="s_password" name="s_password" value="<?php echo $s_password; ?>" required>
                </div>
                <div class="form-group">
                    <label for="district">District:</label>
                    <input type="text" id="district" name="district" value="<?php echo $district; ?>" required>
                </div>
                <div class="form-group">
                    <label for="village">Village:</label>
                    <input type="text" id="village" name="village" value="<?php echo $village; ?>" required>
                </div>
                <button type="submit" class="save-btn">Save Changes</button>
            </form>
        </div>

</body>
</html>
