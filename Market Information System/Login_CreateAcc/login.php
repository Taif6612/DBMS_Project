<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="css/loginStyle.css">
    <style>
        select{
            padding-right: 30px;
            padding: 10px;
            border-radius: 4px;
            font-size: 16px;
            border: 1px solid #ccc;
        }
    </style>
</head>
<body>
  <nav class="navbar">
    <a href="" class="navlogo"><div class="logo">FarmSmart</div></a>    
    <ul class="menu">
        <li><a href="#">Home</a></li>
        <li><a href="#">About</a></li>
        <li><a href="#">Contact</a></li>
    </ul>
  </nav>
  <div class="container">
    <div class="card">
        <!-- Left Side Welcome Section -->
        <div class="left-section">
            <h1 class="welcome-text">
                Welcome Back In <br> <span>FarmSmart</span>
            </h1>
            <p class="description">
                Transform your farming experience with the latest market insights, personalized recommendations, and a vibrant community. Get started now!
            </p>
        </div>

        <!-- Right Side Login Form -->
        <div class="right-section">
            <div class="form-container">
                <h2 class="form-title">Login</h2>
                <p class="form-subtitle">Welcome back! Login to access your account.</p>

                <form method="post" action="loginProcess.php">
                    <div class="input-group">
                        <label for="usertype">User Type</label>
                        <select name="usertype" id="usertype" required>
                            <option value="" disabled selected>Select your user type</option>
                            <option value="Farmer">Farmer</option>
                            <option value="Buyer">Buyer</option>
                            <option value="Analysist">Analysist</option>
                            <option value="Supplier">Supplier</option>
                        </select>
                    </div>
                    <div class="input-group">
                        <label for="username">User ID</label>
                        <input type="text" name="userid" placeholder="Enter your userid" required>
                    </div>
                    <div class="input-group">
                        <label for="password">Password</label>
                        <input type="password" name="password" placeholder="Enter your password" required>
                    </div>
                    <button type="submit" class="btn-login">Login</button>
                </form>

                <p class="register-link">Don't have an account? <a href="registerPage.php">Register here</a></p>
            </div>
        </div>
    </div>
</div>
    </div>
</body>
</html>
