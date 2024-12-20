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
    <title>Farmer UI</title>
    <!-- Bootstrap CSS -->
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
        background-image: url('image/Background_image.jpeg');
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

    .custom-card {
        border: 2px solid #007B5F;
        /* Dark green border */
        border-radius: 8px;
        /* Rounded corners */
    }

    .border-image {
        border: 2px solid #007B5F;
        /* Dark green border for the statistics image */
        border-radius: 8px;
        /* Rounded corners */
        padding: 5px;
        /* Optional: add some padding around the image */
    }

    .bar-wrapper {
        display: flex;
        flex-direction: column;
        align-items: center;
        width: 10%;
        position: relative;
        margin-top: auto;
    }

    .chart-section {
        margin-bottom: 40px;
        padding: 20px;
        background-color: #7cd4a4;
        border: 1px solid #ddd;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .chart-section h3 {
        font-size: 1.5rem;
        color: #333;
        margin-bottom: 5px;
        text-align: center;
    }

    .chart-section p {
        text-align: center;
        color: #333;
        margin-bottom: 8px;
    }

    .bar-chart {
        display: flex;
        align-items: flex-end;
        gap: 5px;
        height: 400px;
        background-color: #bce2cd;
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 10px;
        padding-bottom: 35px;
    }

    .bar {
        width: 100%;
        background-color: #f8f9fa;
        text-align: center;
        color: #353232;
        font-size: 0.9rem;
        line-height: 1.5;
        border-radius: 5px 5px 0 0;
        transition: background-color 0.3s ease;
        display: flex;
        align-items: flex-end;
        justify-content: center;
        font-weight: bold;
    }

    .bar:hover {
        background-color: #dddddd;
    }

    .xValue {
        font-size: 0.9rem;
        color: #333;
        font-weight: bold;
        text-align: center;
        transform: rotate(0deg);
        position: absolute;
        bottom: -32px;
        white-space: nowrap;
        line-height: 15px;
    }
    .card {
        border: 2px solid #007B5F;
        /* Green border */
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        transition: transform 0.2s, box-shadow 0.2s;
    }

    .card:hover {
        transform: scale(1.05);
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
    }

    .card-title {
        font-size: 1.25rem;
        font-weight: bold;
        color: #007B5F;
    }

    .card-subtitle {
        font-size: 1rem;
        color: #6c757d;
    }

    .card-text {
        font-size: 0.9rem;
        color: #333;
    }

    .card-footer {
        background-color: #f8f9fa;
        border-top: 1px solid #ddd;
    }

    .btn-primary {
        background-color: #007B5F;
        border: none;
        transition: background-color 0.3s ease;
    }

    .btn-primary:hover {
        background-color: #005f36;
    }
    .recommendation-section {
    display: flex;
    gap: 20px;
    justify-content: center;
    flex-wrap: wrap;
    margin-top: 40px;
}

.recommendation-card {
    width: 300px;
    border: 2px solid #007B5F;
    border-radius: 15px;
    background: linear-gradient(145deg, #e6fff1, #c0e4d2);
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
    overflow: hidden;
    transition: transform 0.3s, box-shadow 0.3s;
}

.recommendation-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 12px 24px rgba(0, 0, 0, 0.3);
}

.card-header {
    background-color: #007B5F;
    color: #fff;
    text-align: center;
    padding: 10px;
    font-size: 1.5rem;
    font-weight: bold;
    border-bottom: 2px solid #005f36;
}

.card-body {
    padding: 15px;
    text-align: center;
}

.card-title {
    color: #007B5F;
    font-weight: bold;
    margin-top: 10px;
    margin-bottom: 5px;
    font-size: 1.2rem;
}

.card-text {
    color: #333;
    margin-bottom: 15px;
    line-height: 1.4;
    font-size: 1rem;
    text-align: justify;
}

@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.recommendation-card {
    animation: fadeIn 0.6s ease-in-out;
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

    <!-- Landing Page with Statistics -->
    <section id="statistics" class="container mt-5 content">
        <section id="data-analysis">

            <div class="chart-section">
                <h3>Price Analysis</h3>
                <p>x-Date-Crop <br> y-Crops Price</p>
                <div class="bar-chart">
                    <?php
                    $conn = mysqli_connect("localhost", "root", "", "farmsmart");

                    if (!$conn) {
                        die("Connection failed: " . mysqli_connect_error());
                    }

                    $query1 = "SELECT * FROM analysis_data_for_crops";
                    $result1 = mysqli_query($conn, $query1);

                    if (mysqli_num_rows($result1) > 0) {
                        while ($row1 = mysqli_fetch_assoc($result1)) {
                            $crop_id = $row1['crop_id'];
                            $price_value = $row1['price_value'];
                            $date = $row1['date'];

                            $query3 = "SELECT c_name FROM crop_information_per_farmer WHERE crop_id = '$crop_id'";
                            $result3 = mysqli_query($conn, $query3);
                            $crop_name = "";
                            if ($result3 && mysqli_num_rows($result3) > 0) {
                                $row3 = mysqli_fetch_assoc($result3);
                                $crop_name = $row3['c_name'];
                            }

                            ?>
                    <div style="height: <?php echo $price_value / 10; ?>%;" class="bar-wrapper">
                        <div class="bar" style="height: 100%;"><?php echo $price_value.'BDT'; ?></div>
                        <span class="xValue"><?php echo $date . '<br>' . $crop_name; ?></span>
                    </div>
                    <?php
                        }
                    } else {
                        echo "No data found.";
                    }

                    mysqli_close($conn);
                    ?>
                </div>
            </div>

        </section>
    </section>
    <?php
        $currentMonth = date('F'); 
        $nextMonth = date('F', strtotime('+1 month')); 

        $conn = mysqli_connect("localhost", "root", "", "farmsmart");

        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        // Query for the current and next month's recommendations
        $query = "SELECT * FROM recommendation WHERE month_name IN ('$currentMonth', '$nextMonth')";
        $result = mysqli_query($conn, $query);

        $recommendations = [];
        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                $recommendations[] = $row;
            }
        }
        $recommendations=array_reverse($recommendations);
        mysqli_close($conn);

    ?>

    <!-- Crop Analysis Section -->
    
    <section id="analysis" class="container mt-5 content">
        <h2 class="text-center">Recommendations</h2>
        <p class="text-center">Access valuable data on weather, land, and soil conditions to plan your crops efficiently.</p>
        <div class="recommendation-section">
            <?php 
            $monthCounter = 0;
            foreach ($recommendations as $recommendation): 
                if ($monthCounter == 0) {
                    $monthTitle = "Present Month: " . $recommendation['month_name'];
                } else {
                    $monthTitle = "Next Month: " . $recommendation['month_name'];
                }
                $monthCounter++;
            ?>
            <div class="recommendation-card">
                <div class="card-header">
                    <h2><?php echo $monthTitle; ?></h2>
                </div>
                <div class="card-body">
                    <h4 class="card-title">Recommended Crops</h4>
                    <p class="card-text"><?php echo $recommendation['crops']; ?></p>
                    <h4 class="card-title">Weather Condition</h4>
                    <p class="card-text"><?php echo $recommendation['weather_condition']; ?></p>
                    <h4 class="card-title">Protection Tips</h4>
                    <p class="card-text"><?php echo $recommendation['protection']; ?></p>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </section>


    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>