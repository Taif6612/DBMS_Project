<?php 
    session_start();
    $con = mysqli_connect("localhost", "root", "", "farmsmart");
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $log_id = $_POST['userid'];
        $log_pass = $_POST['password'];
        $usertype = $_POST['usertype'];

        if($log_id=="admin" && $log_pass=='11111'){
            header("Location: /farmsmart/Market%20Information%20System/admin/admin.php");
            exit();
        }
         elseif ($usertype === "Farmer") {
            $sql = "SELECT farmer_id FROM farmer_information WHERE farmer_id='$log_id' AND f_password='$log_pass'";
        } elseif ($usertype === "Buyer") {
            $sql = "SELECT buyer_id FROM buyer_information WHERE buyer_id='$log_id' AND b_password='$log_pass'";
        } elseif ($usertype === "Analysist") {
            $sql = "SELECT analysist_id FROM analysist_information WHERE analysist_id='$log_id' AND a_password='$log_pass'";
        } elseif ($usertype === "Supplier") {
            $sql = "SELECT supplier_id FROM supplier_information WHERE supplier_id='$log_id' AND s_password='$log_pass'";
        } else {
            die("Invalid user role selected!");
        }

        $result = mysqli_query($con, $sql);

        if (mysqli_num_rows($result) == 1) {
            $_SESSION['active_user_id'] = $log_id;

            if ($usertype == "Farmer") {
                header("Location: /farmsmart/Market%20Information%20System/FarmerUser/LandingFarmer.php");
                exit();
            } elseif ($usertype == "Buyer") {
                header("Location: /farmsmart/Market%20Information%20System/buyer/");
                exit();
            } elseif ($usertype == "Analysist") {
                header("Location: /farmsmart/Market%20Information%20System/analysist/");
                exit();
            } elseif ($usertype == "Supplier") {
                header("Location: /farmsmart/Market%20Information%20System/supplier/");
                exit(); 
            }
            else {
                echo "Invalid user type.";
            }
        } else {
            echo "Invalid login credentials.";
        }
    }
?>
