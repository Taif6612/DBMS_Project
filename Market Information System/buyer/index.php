<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FarmSmart - Market Information System</title>
    <!-- Font Awesome CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/indexstyle.css">
</head>
<body>
    <!-- Navbar -->
    <div class="navbar">
        <div class="logo">FarmSmart</div>
        <div class="menu">
            <a href="index.php">Home</a>
            <a href="buyproduct.php">Buy Products</a>
            <a href="allOrder.php">My Product</a>
        </div>
        <div class="user-actions">
            <a href="profile.php"><i class="fa-solid fa-user profile-icon"></i></a>
            <a href="../FarmerUser/logoutProcess.php" class="logout">Logout</a>
        </div>
    </div>

    <!-- Hero Section -->
    <section class="hero">
        <h1>Welcome to FarmSmart</h1>
        <p>Connecting farmers and buyers with reliable market information.</p>
        <a href="buyproduct.php" class="cta">Explore Products</a>
    </section>

    <!-- Content Section -->
    <section class="content">
        <h2>Our Features</h2>
        <div class="cards">
            <div class="card">
                <h3>Browse Products</h3>
                <p>Discover a variety of farm-fresh products available for purchase directly from farmers.</p>
                <a href="#">Learn More</a>
            </div>
            <div class="card">
                <h3>Market Trends</h3>
                <p>Stay informed with the latest market prices and trends to make informed buying decisions.</p>
                <a href="#">Learn More</a>
            </div>
            <div class="card">
                <h3>Direct Communication</h3>
                <p>Connect directly with farmers for personalized deals and better transparency.</p>
                <a href="#">Learn More</a>
            </div>
        </div>
    </section>
    <footer class="footer">
        <p>&copy; 2024 FarmSmart. All Rights Reserved.</p>
    </footer>
</body>
</html>
