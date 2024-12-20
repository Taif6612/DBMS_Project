<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Manage Users</title>
    <link rel="stylesheet" href="css/style.css" />
    <link rel="stylesheet" href="css/edituserStyle.css" />
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

      <main class="content">
        <section id="edit-users">
            <h2>Edit User</h2>
            <?php
                    $conn = mysqli_connect("localhost", "root", "", "farmsmart");

                    if (!$conn) {
                        die("Connection failed: " . mysqli_connect_error());
                    }
                    $user_id = $_GET['user_id'];

                    $query = "
                            SELECT buyer_id AS id, buyer_name AS name, district, village, 'Buyer' AS role 
                            FROM buyer_information WHERE buyer_id = '$user_id'
                            UNION
                            SELECT farmer_id AS id, farmer_name AS name, district, village, 'Farmer' AS role 
                            FROM farmer_information WHERE farmer_id = '$user_id'
                            UNION
                            SELECT analysist_id AS id, analysist_name AS name, district, village, 'Analysist' AS role 
                            FROM analysist_information WHERE analysist_id = '$user_id'
                            UNION
                            SELECT supplier_id AS id, supplier_name AS name, district, village, 'Supplier' AS role 
                            FROM supplier_information WHERE supplier_id = '$user_id';
                        ";
                        $result = mysqli_query($conn, $query);

                        if ($result && mysqli_num_rows($result) > 0) {
                            $user = mysqli_fetch_assoc($result);
                        } else {
                            echo "User not found.";
                            exit;
                        }
                  
                    mysqli_close($conn);
                    ?>
            <div class="form-container">
            <form action="edituserProcess.php" method="POST">
                <div class="form-group">
                    <label for="user-id">ID</label>
                    <input type="hidden" name="user-id" value="<?php echo $user['id']; ?>">
                </div>
                <div class="form-group">
                    <label for="user-name">Name</label>
                    <input type="text" name="user-name" value="<?php echo $user['name']; ?>">
                </div>
                <div class="form-group">
                    <label for="user-district">District</label>
                    <input type="text" name="user-district" value="<?php echo $user['district']; ?>">
                </div>
                <div class="form-group">
                    <label for="user-village">Village</label>
                    <input type="text" name="user-village" value="<?php echo $user['village']; ?>">
                </div>
                <div class="form-group">
                    <label for="user-role">Role</label>
                    <select id="user-role" name="user-role" required>
                        <option value="" disabled>Select Role</option>
                        <option value="Farmer" <?php echo $user['role'] == 'Farmer' ? 'selected' : ''; ?>>Farmer</option>
                        <option value="Buyer" <?php echo $user['role'] == 'Buyer' ? 'selected' : ''; ?>>Buyer</option>
                        <option value="Analysist" <?php echo $user['role'] == 'Analysist' ? 'selected' : ''; ?>>Analysist</option>
                        <option value="Supplier" <?php echo $user['role'] == 'Supplier' ? 'selected' : ''; ?>>Supplier</option>
                    </select>
                </div>
                <button type="submit" class="update-btn">Update Data</button>
            </form>
            </div>
        </section>
      </main>
    </div>
  </body>
</html>
