<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Edit Crops</title>
    <link rel="stylesheet" href="css/style.css" />
    <link rel="stylesheet" href="css/editcrops.css" />
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
          <li><a href="manage_user.php">Manage Users</a></li>
          <li><a href="manage-crops.php">Manage Recommendations</a></li>
          <li><a href="warehouse.php">Warehouse Management</a></li>
        </ul>
      </nav>

      <main class="content">
        <section id="edit-Crops">
            <h2>Edit Crops</h2>
            <div class="form-container">
            <?php
              $conn = mysqli_connect("localhost", "root", "", "farmsmart");

              if (!$conn) {
                  die("Connection failed: " . mysqli_connect_error());
              }
              if (isset($_GET['crop_id'])) {
                  $crop_id = $_GET['crop_id'];
                  $farmer_id = $_GET['farmer_id'];

                  $sql = "SELECT * FROM crop_information_per_farmer WHERE farmer_id = '$farmer_id' AND crop_id='$crop_id'";
                  $result = mysqli_query($conn, $sql);
                  if ($row = mysqli_fetch_assoc($result)) {
                      $crop_id = $row['crop_id'];
                      $crop_name = $row['c_name'];
                      $owner = $row['farmer_id'];
                      $growing_season = $row['growing_season'];
                  } else {
                      echo "No crop data found for the given Farmer ID.";
                      exit();
                  }
              } else {
                  echo "Farmer ID not provided.";
                  exit();
              }
              mysqli_close($conn);
              ?>

            <form action="updatecropInfoProcessing.php" method="post">
                <div class="form-group">
                    <label for="crop-id">Crop ID</label>
                    <input type="text" name="crop-id" value="<?php echo $crop_id; ?>" readonly>
                </div>
                <div class="form-group">
                    <label for="crop-name">Crop Name</label>
                    <input type="text" name="crop-name" value="<?php echo $crop_name; ?>">
                </div>
                <div class="form-group">
                    <label for="crop-Owner">Growing Season</label>
                    <input type="text" name="growing_season" value="<?php echo $growing_season; ?>">
                </div>
                <button type="submit" class="update-btn">Update Data</button>
            </form>
            </div>
        </section>
      </main>
    </div>
  </body>
</html>
