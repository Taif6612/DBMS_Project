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

    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-content">
            <h1>Welcome to FarmSmart</h1>
            <p>Your centralized system for managing farmer queries, providing recommendations, and promoting sustainable agriculture practices.</p>
            <a href="#features" class="learn-more-btn">Learn More</a>
        </div>
    </section>

    <!-- Features Section -->
    <section class="key-features">
        <h2 class="section-title">Key Features</h2>
        <div class="features-container">
            <div class="feature-card">
                <h3>Manage Queries</h3>
                <p>Review and respond to farmers' concerns efficiently through our intuitive platform.</p>
            </div>
            <div class="feature-card">
                <h3>Provide Recommendations</h3>
                <p>Share valuable insights and suggestions to help farmers enhance their productivity.</p>
            </div>
            <div class="feature-card">
                <h3>Monitor Performance</h3>
                <p>Keep track of progress and provide real-time updates on agricultural activities.</p>
            </div>
        </div>
    </section>
    

    <!-- Footer -->
    <footer class="footer">
        <p>&copy; 2024 FarmSmart. All Rights Reserved.</p>
    </footer>
</body>
</html>
