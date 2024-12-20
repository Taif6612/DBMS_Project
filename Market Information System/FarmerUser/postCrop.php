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
    <title>Buy Crop - Farmer UI</title>
    <!-- Bootstrap CSS -->
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

    .price-section {
        flex-grow: 1;
        padding: 20px;
        text-align: center;
    }

    .price-section .container {
        max-width: 1000px;
        margin: 0 auto;
    }

    .price-section h1 {
        font-size: 28px;
        margin-bottom: 20px;
        color: #2d7a57;
    }

    /* Table Styles */
    .table-container {
        overflow-x: auto;
    }

    .price-table {
        width: 100%;
        border-collapse: collapse;
        background: white;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        animation: fadeIn 1s ease-in-out;
    }

    .price-table th,
    .price-table td {
        text-align: center;
        padding: 12px 15px;
        font-size: 14px;
        color: #555;
    }

    .price-table th {
        background-color: #2d7a57;
        color: white;
        text-transform: uppercase;
    }

    .price-table tr:nth-child(even) {
        background-color: #f9f9f9;
    }

    .price-table tr:hover {
        background-color: #eaf7e9;
        cursor: pointer;
        transition: background 0.3s ease;
    }

    .price-table td {
        position: relative;
    }



    .price-table td img {
        width: 50px;
        height: 50px;
        object-fit: cover;
        border-radius: 4px;
        border: 1px solid #ddd;
    }

    /* Animations */
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes fadeTooltip {
        to {
            opacity: 1;
        }
    }

    .active {
        color: white;
    }

    .form-container {
        background-color: #fff;
        padding: 40px;
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        width: 100%;
        max-width: 600px;
        transition: transform 0.3s ease;
        margin: 50px auto;
    }

    .form-container:hover {
        transform: translateY(-10px);
    }

    h2 {
        text-align: center;
        margin-bottom: 30px;
        color: #333;
        font-size: 24px;
        font-weight: 500;
    }

    .form-group {
        margin-bottom: 20px;
    }

    label {
        display: block;
        font-size: 16px;
        font-weight: 500;
        color: #333;
        margin-bottom: 8px;
    }

    input[type="text"],
    select {
        width: 100%;
        padding: 10px;
        font-size: 16px;
        border: 2px solid #ddd;
        border-radius: 8px;
        outline: none;
        transition: border-color 0.3s ease;
    }

    input[type="text"]:focus,
    select:focus {
        border-color: rgba(0, 95, 54, 0.8);
    }

    button[type="submit"] {
        width: 100%;
        padding: 12px;
        background: linear-gradient(135deg, #2d7a57, #38a169);
        color: #fff;
        font-size: 18px;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        transition: background-color 0.3s ease;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    button[type="submit"]:hover {
        background: linear-gradient(135deg, #38a169, #2d7a57);
        box-shadow: 0 6px 10px rgba(0, 0, 0, 0.1);
    }

    .form-group input,
    .form-group select {
        transition: all 0.3s ease;
    }

    .form-group input:focus+label,
    .form-group select:focus+label {
        color: rgba(0, 95, 54, 0.8);
        font-weight: 600;
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

    <section class="price-section">
        <div class="container">
            <div class="form-container">
                <h2>Upload Crop Information</h2>
                <form action="registerCropInfo.php" method="post">
                    <div class="form-group">
                        <label for="farmer_id">Farmer ID</label>
                        <input type="text" id="farmer_id" name="farmer_id" value="<?php echo $f_id?>" required>
                    </div>
                    <div class="form-group">
                        <label for="crop_id">Crop ID</label>
                        <input type="text" id="crop_id" name="crop_id" value="<?php echo uniqid('crop_');?>" required>
                    </div>
                    <div class="form-group">
                        <label for="crop_name">Crop Name</label>
                        <input type="text" id="crop_name" name="crop_name" placeholder="Enter Crop Name" required>
                    </div>
                    <div class="form-group">
                        <label for="growing_season">Growing Season</label>
                        <select id="growing_season" name="growing_season" required>
                            <option value="" disabled selected>Select Growing Season</option>
                            <option value="Spring">Spring</option>
                            <option value="Summer">Summer</option>
                            <option value="Monsoon">Monsoon</option>
                            <option value="Winter">Winter</option>
                        </select>
                    </div>
                    <button type="submit">Submit</button>
                </form>
            </div>

        </div>
    </section>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>