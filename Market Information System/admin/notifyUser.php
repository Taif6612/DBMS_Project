<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/notify.css">
</head>
<body>
    <div class="admin-panel">
        <header class="header">
            <h1>Admin Dashboard</h1>
            <div class="user-info">
                <span>Welcome, Admin</span>
                <a href="#" class="logout">Logout</a>
            </div>
        </header>

        <nav class="sidebar">
            <ul>
                <li><a href="admin.php">Dashboard</a></li>
                <li><a href="manage_user.php" class="active">Manage Users</a></li>
                <li><a href="manage-crops.php">Manage Recommendations</a></li>
                <li><a href="warehouse.php">Warehouse Management</a></li>
            </ul>
        </nav>
        <?php
            $conn = mysqli_connect("localhost", "root", "", "farmsmart");

            if (!$conn) {
                die("Connection failed: " . mysqli_connect_error());
            }

            $crop_id = $_GET['crop_id'];
            $farmer_id = $_GET['farmer_id'];

            $crop_name = ""; 
            if (!empty($crop_id)) {
                $query = "SELECT c_name FROM crop_information_per_farmer WHERE crop_id = '$crop_id'";
                
                $result = mysqli_query($conn, $query);
                
                if ($result && mysqli_num_rows($result) > 0) {
                    $row = mysqli_fetch_assoc($result);
                    $crop_name = $row['c_name'];
                }
            }

            mysqli_close($conn);
        ?>
        <main class="content">
            <section id="notify-users">
                <h2>Send Recommendation</h2>
                <div class="form-container">
                    <form action="process_recommendation.php" method="POST">
                        <div class="form-group">
                            <label for="user-id">Crop Name</label>
                            <input type="hidden" id="recommendation_id" name="recommendation_id" value="<?php echo uniqid('r_');?>" required>
                            <input type="text" name="crop_name" value="<?php echo $crop_name; ?>" readonly>
                            <input type="hidden" name="farmer_id" value="<?php echo $farmer_id; ?>">
                            <input type="hidden" name="crop_id" value="<?php echo $crop_id; ?>">
                        </div>
                        <!-- Subject -->
                        <div class="form-group">
                            <label for="subject">Subject</label>
                            <input type="text" name="subject" placeholder="Enter Subject" required>
                        </div>
                        <!-- Message -->
                        <div class="form-group">
                            <label for="message">Recommendation Message :</label>
                            <textarea name="message" placeholder="Write your message here..." required></textarea>
                        </div>
                        <!-- Notify Button -->
                        <button type="submit" class="notify-btn">Send</button>
                    </form>
                </div>
            </section>
        </main>
    </div>
</body>
</html>
