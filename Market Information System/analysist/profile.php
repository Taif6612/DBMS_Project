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
    <title>FarmSmart - Agriculture Department</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/indexStyle.css">
    <style>
        .edit-profile-container {
    display: flex;
    justify-content: center;
    padding: 70px 10px;
}

.edit-profile-card {
    background-color: #fff;
    width: 100%;
    max-width: 400px;
    padding: 30px;
    border-radius: 10px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    text-align: center;
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



/* Animations */
@keyframes fadeIn {
    from {
        opacity: 0;
        transform: scale(0.9);
    }
    to {
        opacity: 1;
        transform: scale(1);
    }
}

    </style>
</head>
<body>
    <!-- Navbar -->
    <header class="navbar">
        <div class="navbar-container">
            <div class="logo">FarmSmart</div>
            <nav class="menu">
                <a style="color:#ebde2b" href="index.php"> Home</a>
                <a href="addPrice.php">Post crops</a>
                <a href="allCrops.php">All crops</a>
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

         

        // Fetch the supplier information
        $sql = "SELECT * FROM analysist_information WHERE analysist_id = '$a_id'";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $supplier_name = $row['analysist_name'];
            $s_password = $row['a_password'];
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
