<?php
$conn = mysqli_connect("localhost", "root", "", "farmsmart");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$id = isset($_GET['id']) ? $_GET['id'] : 0;
if ($id > 0) {
    $sql = "SELECT * FROM recommendation WHERE id = $id";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
    } else {
        die("Recommendation not found.");
    }
} else {
    die("Invalid ID.");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $month_name =  $_POST['month_name'];
    $crops =  $_POST['crops'];
    $weather_condition =  $_POST['weather_condition'];
    $protection =  $_POST['protection'];

    $update_sql = "UPDATE recommendation SET 
                   month_name='$month_name', 
                   crops='$crops', 
                   weather_condition='$weather_condition', 
                   protection='$protection' 
                   WHERE id=$id";

    if (mysqli_query($conn, $update_sql)) {
        header("Location: http://localhost/Market%20Information%20System/admin/manage-crops.php");
        exit();
    } else {
        echo "Error updating recommendation: " . mysqli_error($conn);
    }
}

mysqli_close($conn);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
    .content {
    padding: 20px;
}

.edit-form {
    max-width: 600px;
    margin: 0 auto;
}

.form-group {
    margin-bottom: 15px;
}

.form-group label {
    display: block;
    margin-bottom: 5px;
    font-weight: bold;
}

.form-group input,
.form-group textarea {
    width: 100%;
    padding: 12px;
    border: 1px solid #ccc;
    border-radius: 5px;
    outline: none;
    transition: all 0.3s ease;
    font-size: 1rem;
}

.form-group textarea {
    height: 100px;
    resize: vertical;
}
.form-group input:focus {
    border-color: #4a7c31;
    box-shadow: 0 0 8px rgba(33, 95, 69, 0.6);
}
.form-group textarea:focus {
    border-color: #4a7c31;
    box-shadow: 0 0 8px rgba(33, 95, 69, 0.6);
}
.btn {
    display: inline-block;
    padding: 10px 20px;
    font-size: 16px;
    background-color: #38a169;
    color: #fff;
    text-align: center;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    margin: 0 auto;
}

.btn:hover {
    background-color: #286e49;
}
    </style>
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
                <li><a href="manage-crops.php" class="active">Manage Recommendations</a></li>
                <li><a href="warehouse.php">Warehouse Management</a></li>
            </ul>
        </nav>

        <main class="content">
            <h2>Edit Recommendation</h2>
            <section id="edit-recommendation">
                <form action="" method="POST" class="edit-form">
                    <div class="form-group">
                        <label for="month_name">Month Name</label>
                        <input type="text" id="month_name" name="month_name" value="<?php echo $row['month_name']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="crops">Crops</label>
                        <textarea id="crops" name="crops" required><?php echo $row['crops']; ?></textarea>
                    </div>
                    <div class="form-group">
                        <label for="weather_condition">Weather Condition</label>
                        <textarea id="weather_condition" name="weather_condition" required><?php echo $row['weather_condition']; ?></textarea>
                    </div>
                    <div class="form-group">
                        <label for="protection">Protection</label>
                        <textarea id="protection" name="protection" required><?php echo $row['protection']; ?></textarea>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn">Update Recommendation</button>
                    </div>
                </form>
            </section>
        </main>

    </div>
</body>

</html>