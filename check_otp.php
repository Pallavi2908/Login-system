<?php
    require 'connection.php';
    // include 'verification.php';
    require 'C:\xampp\htdocs\Login system\vendor\autoload.php';
    if (!$con) {
        die("Failed to connect with MySQL: " . mysqli_connect_error());
    }
    if (isset($_POST["submit_otp"]))
    {
        $otp = $_POST["new_otp"];
        $new_otp=$_POST["new_otp"];
        $token = $_POST["token"];
        $currentdate = date("U");
        $sql = "SELECT otp FROM `otp_table` WHERE token = ? AND otp_expiry >= ?";
        $stmt = mysqli_stmt_init($con);

        if (!mysqli_stmt_prepare($stmt, $sql)) {
            die("Timed out");
            exit();
        }
        mysqli_stmt_bind_param($stmt, "ss", $token, $currentdate); // Bind the parameters
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($row = mysqli_fetch_assoc($result)) {
            $retrievedOtp = $row['otp'];
            
           if( $retrievedOtp===$new_otp){
                echo "found user";
                header("refresh:5;url=https://www.google.com/"); 

                exit();
            }else{
                echo "Incorrect OTP!\n";
                echo "Re-sending OTP";
                header("refresh:2;url=otp.php");
            }
        }            
    
        
    }
?>