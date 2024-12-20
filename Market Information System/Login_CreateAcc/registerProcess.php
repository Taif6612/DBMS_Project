<?php
    $conn = mysqli_connect("localhost", "root", "", "farmsmart");

    if (!$conn) {
        die("Connection failed" );
    }
    
    $useid = $_POST['useid'];
    $username = $_POST['username'];
    $password = $_POST['password']; 
    $district = $_POST['district'];
    $village = $_POST['village'];
    $user_role = $_POST['user-role'];
    
    if ($user_role === "Farmer") {
        $sql = "INSERT INTO farmer_information (farmer_id, farmer_name, f_password, district, village) 
        VALUES ('$useid', '$username', '$password', '$district', '$village')";
    } elseif ($user_role === "Buyer") {
        $sql = "INSERT INTO buyer_information (buyer_id, buyer_name, b_password, district, village) 
        VALUES ('$useid', '$username', '$password', '$district', '$village')";
    } elseif ($user_role === "Analysist") {
        $sql = "INSERT INTO analysist_information (analysist_id, analysist_name, a_password, district, village) 
        VALUES ('$useid', '$username', '$password', '$district', '$village')";
    } elseif ($user_role === "Supplier") {
        $sql = "INSERT INTO supplier_information (supplier_id, supplier_name, s_password, district, village) 
        VALUES ('$useid', '$username', '$password', '$district', '$village')";					

    } else {
        die("Invalid user role selected!");
    }

    if (mysqli_query($conn, $sql) === TRUE) {
        echo "New record created successfully. <a href='login.php'>Go to login page</a>";
    } else {
        echo "Error";
    }
    
    mysqli_close($conn);

?>