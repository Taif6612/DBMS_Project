<?php
    session_start();

   
    session_unset(); 
    session_destroy(); 

    header("Location: http://localhost/Market%20Information%20System/Login_CreateAcc/login.php");
    exit();
?>