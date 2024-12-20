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

    h2,
    p {
        text-align: center;
    }

    /* Form Styling */
    .form-container {
        max-width: 600px;
        margin: 40px auto;
        padding: 20px;
        background: #fff;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        border-radius: 8px;
    }

    .form-container h2 {
        color: #444;
        margin-bottom: 10px;
    }

    form {
        display: flex;
        flex-direction: column;
        gap: 15px;

    }

    label {
        font-weight: 500;
        margin-bottom: 5px;
    }

    select,
    input[type="text"],
    input[type="number"],
    input[type="date"] {
        width: 100%;
        padding: 10px;
        font-size: 1rem;
        border: 1px solid #ddd;
        border-radius: 8px;
        transition: box-shadow 0.3s ease, border-color 0.3s ease;
    }

    select:focus,
    input:focus {
        border-color: #4CAF50;
        box-shadow: 0 0 8px rgba(76, 175, 80, 0.2);
        outline: none;
    }

    button {
        padding: 12px;
        font-size: 1rem;
        color: #fff;
        background: linear-gradient(135deg, #4CAF50, #43a047);
        border: none;
        border-radius: 8px;
        cursor: pointer;
        transition: background 0.3s ease, transform 0.3s ease;
    }

    button:hover {
        background: linear-gradient(135deg, #43a047, #388e3c);
        transform: scale(1.05);
    }

    button:active {
        transform: scale(0.97);
    }

    .btn-load {
        background: linear-gradient(135deg, #43a047, #388e3c);
    }

    .btn-load:hover {
        background: linear-gradient(135deg, #4CAF50, #43a047);
    }

    .form-group {
        position: relative;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(10px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    </style>
</head>

<body>
    <div class="background-image"></div>
    <div class="blur"></div>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <a class="navbar-brand" href="LandingFarmer.html">FarmSmart</a> <!-- Updated logo text -->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
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
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <img src="path/to/avatar-placeholder.png" alt="<?php echo $f_id?>"
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

    <!-- Sell Page Content -->
    <div class="form-container">
        <h2>Deliver In WareHouse</h2>
        <form method="post" action="cropDeliverForm.php">
            <?php
                $conn = mysqli_connect("localhost", "root", "", "farmsmart");

                if (!$conn) {
                    die("Connection failed: " . mysqli_connect_error());
                }
                
                $sql_analysis = "SELECT crop_id FROM analysis_data_for_crops";
                $result_analysis = mysqli_query($conn, $sql_analysis);
                
                $crops_for_farmer = []; 
                
                if (mysqli_num_rows($result_analysis) > 0) {
                    while ($row_analysis = mysqli_fetch_assoc($result_analysis)) {
                        $crop_id = $row_analysis['crop_id'];
                
                        $sql_farmer_check = "SELECT crop_id FROM crop_information_per_farmer WHERE crop_id = '$crop_id' AND farmer_id = '$f_id'";
                        $result_farmer_check = mysqli_query($conn, $sql_farmer_check);
                
                        if (mysqli_num_rows($result_farmer_check) > 0) {
                            $crops_for_farmer[] = $crop_id;
                        }
                    }
                }
                
            ?>
            <div class="form-group">
                <label for="crop">Select Crop</label>
                <select id="crop" name="crop">
                    <option value="">-- Select Crop ID --</option>
                    <?php
                        if (!empty($crops_for_farmer)) {
                            foreach ($crops_for_farmer as $crop) {
                                echo "<option value='$crop'>$crop</option>";
                            }
                        } else {
                            echo "<option value=''>No crops available</option>";
                        }
                    ?>
                </select>
            </div>

            <button type="submit">Load Form</button>
            <!-- Submit Button -->
        </form>
    </div>



    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>