<?php
    $conn = mysqli_connect("localhost", "root", "", "farmsmart");

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $user_id = $_POST['user-id']; 
        $user_name = $_POST['user-name']; 
        $user_district = $_POST['user-district']; 
        $user_village = $_POST['user-village']; 
        $user_role = $_POST['user-role'];
    
        $table_name = '';
        $id_column = '';
    
        switch ($user_role) {
            case 'Buyer':
                $table_name = 'buyer_information';
                $id_column = 'buyer_id';
                break;
            case 'Farmer':
                $table_name = 'farmer_information';
                $id_column = 'farmer_id';
                break;
            case 'Analysist':
                $table_name = 'analysist_information';
                $id_column = 'analysist_id';
                break;
            case 'Supplier':
                $table_name = 'supplier_information';
                $id_column = 'supplier_id';
                break;
            default:
                echo "Invalid role selected.";
                exit;
        }
    
        $update_query = "
            UPDATE $table_name
            SET
                district = '$user_district', 
                village = '$user_village'
            WHERE $id_column = '$user_id'
        ";
    
        if (mysqli_query($conn, $update_query)) {
            echo "User data updated successfully.";
            header("Location: http://localhost/Market%20Information%20System/admin/manage_user.php");
            exit;
        } else {
            echo "Error updating user: " . mysqli_error($conn);
        }
    } else {
        echo "Invalid request.";
        exit;
    }
    
    mysqli_close($conn);
    ?>