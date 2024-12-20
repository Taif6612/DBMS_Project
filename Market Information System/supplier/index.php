<?php
    session_start();

    if (!isset($_SESSION['active_user_id'])) {
        die("You must be logged in to view this page.");
    }
    $s_id = $_SESSION['active_user_id'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FarmSmart - Supplier Dashboard</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/supplierstyle.css">
</head>
<body>
    <div class="navbar">
        <div class="logo">FarmSmart</div>
        <div class="menu">
            <a class="active" href="index.php">Dashboard</a>
            <a href="browsecrops.php">Browse Crops</a>
            <a href="orders.php">My Purchases</a>
        </div>
        <div class="user-actions">
            <a href="profile.php"><i class="fa-solid fa-user profile-icon"></i></a>
            <a href="../FarmerUser/logoutProcess.php" class="logout">Logout</a>
        </div>
    </div>

    <section class="hero">
        <h1>Welcome, Supplier</h1>
        <p>Discover high-quality crops and make smart purchasing decisions.</p>
        <a href="browsecrops.php" class="cta">Browse Crops</a>
    </section>

    <section class="content">
        <h2>Your Tools</h2>
        <div class="cards">
            <div class="card">
                <h3>Browse Crops</h3>
                <p>Explore a variety of fresh crops available for purchase from farmers.</p>
                <a href="browsecrops.php">Start Browsing</a>
            </div>
            <div class="card">
                <h3>Track Purchases</h3>
                <p>View and manage your crop purchases with ease.</p>
                <a href="orders.php">View Purchases</a>
            </div>
            <div class="card">
                <h3>Market Insights</h3>
                <p>Stay updated with market trends to make informed buying decisions.</p>
                <a href="#">Learn More</a>
            </div>
        </div>
    </section>
    <footer class="footer">
        <p>&copy; 2024 FarmSmart. All Rights Reserved.</p>
    </footer>
</body>
</html>
