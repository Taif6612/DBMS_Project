<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Account</title>
    <link rel="stylesheet" href="css/registerStyle.css">
    <style>
        .form-section p {
            font-size: 15px;
            color: #777;
            margin-bottom: 14px;
        }
        .form-group {
            margin-bottom: 14px;
        }
        
        .form-group label {
            display: block;
            font-size: 15px;
            color: #333;
            margin-bottom: 5px;
        }
        
        .form-group input, .form-group select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 15px;
            
        }
        .l_acc{
            margin-top: 5px;
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <a href="" class="navlogo"><div class="logo">FarmSmart</div></a> 
        <div class="menu">
            <a href="#">Home</a>
            <a href="#">About</a>
            <a href="#">Contact</a>
        </div>
    </nav>

    <div class="container">
        <div class="left-section">
            <div class="overlay">
                <h1 class="welcome-text">
                    Welcome to <span>FarmSmart</span>
                </h1>
                <p>Empowering farmers and buyers to connect seamlessly. Join us today and unlock the best marketplace experience!</p>
            </div>
        </div>
        <div class="right-section">
            <div class="form-section">
                <h1>Register</h1>
                <p>Join our platform and enjoy the best marketplace experience!</p>
                <form method="post" action="registerProcess.php">
                    <div class="form-group">
                        <label for="useid">User ID</label>
                        <input type="text" id="useid" name="useid" value="<?php echo uniqid('usr_');?>" required>
                    </div>
                    <div class="form-group">
                        <label for="username">Full Name</label>
                        <input type="text" id="username" name="username" placeholder="Enter your full name" required>
                    </div>
                    <div class="form-group">
                        <label for="Password">Password</label>
                        <input type="password" id="Password" name="password" placeholder="Enter your Password number" required>
                    </div>
                    <div class="form-group">
                        <label for="location">District</label>
                        <input type="text" id="district" name="district" placeholder="Enter your District" required>
                    </div>
                    <div class="form-group">
                        <label for="village">Village</label>
                        <input type="text" id="village" name="village" placeholder="Enter your Village number" required>
                    </div>
                    <div class="form-group">
                        <label for="user-role">User Role</label>
                        <select id="user-role" name="user-role" required>
                            <option value="" disabled selected>Select Role</option>
                            <option value="Farmer">Farmer</option>
                            <option value="Buyer">Buyer</option>
                            <option value="Analysist">Analysist</option>
                            <option value="Supplier">Supplier</option>
                        </select>
                    </div>
                    <button type="submit">Register</button>
                </form>
                <p class="l_acc">Already have an account? <a class="l_btn" href="login.php">Login here</a></p>
            </div>
        </div>
    </div>
</body>
</html>
