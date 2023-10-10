<?php

    include 'connection.php';
    $host="localhost";
    $user="root";
    $password='';
    $db_name="otp_system";
    $con=mysqli_connect($host,$user,$password,$db_name);
    if(!$con){
        die("Failed to connect with MySQL: ". mysqli_connect_error()); 
    }
    if($_SERVER["REQUEST_METHOD"]=="POST"){
        $password=$_POST['password'];
        $email=$_POST['email'];
        $company=$_POST['company'];
        if(empty($password)){
            echo "Empty field detected";
            echo "<a href='register.html'>Redirect back to registration form</a>";
       
        }else{
            $check_email_query= "SELECT * FROM `otp_table` WHERE email='$email'";
            $result=mysqli_query($con, $check_email_query);

            if(mysqli_num_rows($result)>0){
                echo "email already exists.";
                echo "<a href='register.html'>Redirect back to registration form</a>";

            }else{
                //hashing passwords
                $hashed_password=password_hash($password,PASSWORD_DEFAULT);
                $sql="INSERT INTO `otp_table`(password,email,company) VALUES ('$hashed_password','$email', '$company')";
                if(mysqli_query($con,$sql)){
                    echo "Registered successfully";
                    echo "<a href='login.html'>Click here</a> to log in.";
                }else{
                    echo "Error: ".mysqli_error($con);
                }
            }
        }   
    }
    mysqli_close($con);
?>